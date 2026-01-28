<?php

namespace App\Livewire\Control\Integrations;

use Livewire\Component;
use App\Models\Merchant;
use App\Models\MerchantIntegration;
use App\Models\MerchantCredential;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class IntegrationList extends Component
{
    public $merchants;
    
    // Modal State
    public $isConfigModalOpen = false;
    public $configuringMerchant = null;
    
    // Form Config Data
    public $outlet_id;
    public $is_enabled = false;
    public $auto_accept = true;
    public $client_id;
    public $client_secret;
    public $relay_secret;

    public function mount()
    {
        $this->refreshMerchants();
    }

    public function refreshMerchants()
    {
        $this->merchants = Merchant::with('integrations')->get();
    }

    public function configure($merchantId)
    {
        $this->configuringMerchant = Merchant::with(['integrations.credential'])->find($merchantId);
        
        if (!$this->configuringMerchant) return;

        // Load existing config if available
        $integration = $this->configuringMerchant->integrations->first();
        
        if ($integration) {
            $this->outlet_id = $integration->outlet_id;
            $this->is_enabled = $integration->is_enabled;
            $this->auto_accept = $integration->auto_accept;
            
            if ($integration->credential) {
                $this->client_id = $integration->credential->client_id;
                // Don't show secrets for security, or show partial?
                // For now, leave blank implies "don't change"
                $this->client_secret = ''; 
                $this->relay_secret = ''; 
            }
        } else {
            $this->resetConfigForm();
        }

        $this->isConfigModalOpen = true;
    }

    public function resetConfigForm()
    {
        $this->outlet_id = '';
        $this->is_enabled = false;
        $this->auto_accept = true;
        $this->client_id = '';
        $this->client_secret = '';
        $this->relay_secret = '';
    }

    public function saveConfiguration()
    {
        $this->validate([
            'outlet_id' => 'required',
            'client_id' => 'required',
            // Secret required only if creating new integration
            // 'client_secret' => 'required', 
        ]);
        
        // 1. Find or Create Integration
        $integration = MerchantIntegration::updateOrCreate(
            ['merchant_id' => $this->configuringMerchant->id],
            [
                'outlet_id' => $this->outlet_id,
                'is_enabled' => $this->is_enabled,
                'auto_accept' => $this->auto_accept,
                'settings' => [] 
            ]
        );

        // 2. Update Credentials
        $credentialData = ['client_id' => $this->client_id];
        
        // Only update secrets if provided (not empty)
        if (!empty($this->client_secret)) {
            $credentialData['client_secret'] = $this->client_secret; // Model casts to encrypted
        }
        if (!empty($this->relay_secret)) {
            $credentialData['relay_secret'] = $this->relay_secret; // Model casts to encrypted
        }

        MerchantCredential::updateOrCreate(
            ['integration_id' => $integration->id],
            $credentialData
        );

        $this->isConfigModalOpen = false;
        $this->refreshMerchants();
        
        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => 'Configuration Saved',
            'text' => $this->configuringMerchant->name . ' integration updated.'
        ]);
    }
    
    public function testConnection($merchantId)
    {
        // Use IntegrationManager to test auth
        $integration = MerchantIntegration::where('merchant_id', $merchantId)->first();
        if(!$integration) {
             $this->dispatch('swal:modal', [
                'type' => 'error',
                'title' => 'Not Configured',
                'text' => 'Please save configuration first.'
            ]);
            return;
        }

        try {
            $manager = new \App\Services\Integration\IntegrationManager();
            $provider = $manager->make($integration);
            
            if($provider->authenticate()) {
                $this->dispatch('swal:modal', [
                    'type' => 'success',
                    'title' => 'Connection Successful',
                    'text' => 'Successfully authenticated with ' . $integration->merchant->name
                ]);
            } else {
                 $this->dispatch('swal:modal', [
                    'type' => 'error',
                    'title' => 'Connection Failed',
                    'text' => 'Authentication rejected. Check Client ID and Secret.'
                ]);
            }
        } catch (\Exception $e) {
            $this->dispatch('swal:modal', [
                'type' => 'error',
                'title' => 'Error',
                'text' => $e->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.control.integrations.integration-list')
            ->layout('layouts.control', ['title' => 'Merchant Integrations']);
    }
}

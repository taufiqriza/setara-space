<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow; // Use Now for sync drivers
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderReceived implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function broadcastOn(): array
    {
        // Broadcast to a channel that the Control Panel (Livewire) listens to
        return [
            new Channel('pos-channel'),
        ];
    }
    
    public function broadcastAs()
    {
        return 'order-received';
    }
}

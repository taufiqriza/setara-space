<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Merchants (Master Data)
        Schema::create('merchants', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // gofood, grabfood, shopeefood
            $table->string('name');
            $table->string('logo_url')->nullable();
            $table->enum('status', ['active', 'inactive', 'coming_soon'])->default('inactive');
            $table->timestamps();
        });

        // 2. Merchant Integrations (Config)
        Schema::create('merchant_integrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained('merchants')->onDelete('cascade');
            $table->string('outlet_id')->nullable(); // External outlet ID
            $table->boolean('is_enabled')->default(false);
            $table->boolean('auto_accept')->default(true);
            $table->json('settings')->nullable(); // Additional config
            $table->timestamps();
        });

        // 3. Merchant Credentials (Secure Storage)
        Schema::create('merchant_credentials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('integration_id')->constrained('merchant_integrations')->onDelete('cascade');
            $table->text('client_id')->nullable();
            $table->text('client_secret')->nullable(); // Encrypted
            $table->text('relay_secret')->nullable(); // Encrypted
            $table->text('access_token')->nullable(); // Encrypted or plain
            $table->dateTime('token_expiry')->nullable();
            $table->timestamps();
        });

        // 4. Merchant Orders (Linking)
        Schema::create('merchant_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('integration_id')->constrained('merchant_integrations');
            $table->string('external_order_id')->index();
            $table->string('driver_name')->nullable();
            $table->string('driver_phone')->nullable();
            $table->string('driver_plate')->nullable();
            $table->string('booking_id')->nullable(); // GoFood usually has booking_id and order_no
            $table->json('raw_payload')->nullable(); // Audit purpose
            $table->timestamps();
        });

        // 5. Integration Logs (Observability)
        Schema::create('integration_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('integration_id')->nullable()->constrained('merchant_integrations')->onDelete('cascade');
            $table->string('type')->default('inbound'); // inbound, outbound, system
            $table->string('endpoint')->nullable();
            $table->integer('status_code')->nullable();
            $table->text('request_payload')->nullable();
            $table->text('response_body')->nullable();
            $table->text('error_message')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('integration_logs');
        Schema::dropIfExists('merchant_orders');
        Schema::dropIfExists('merchant_credentials');
        Schema::dropIfExists('merchant_integrations');
        Schema::dropIfExists('merchants');
    }
};

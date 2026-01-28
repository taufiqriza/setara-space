<?php

namespace App\Services\Integration\DTO;

class StandardOrderDTO
{
    public function __construct(
        public string $external_id,
        public string $booking_id,
        public string $customer_name,
        public string $driver_name,
        public ?string $driver_phone,
        public ?string $driver_plate,
        public float $total_amount,
        public array $items, // Array of ['sku' => string, 'name' => string, 'qty' => int, 'price' => float, 'notes' => string]
        public ?string $notes = null,
        public string $payment_method = 'gofood'
    ) {}
    
    public static function fromArray(array $data): self
    {
        return new self(
            external_id: $data['external_id'],
            booking_id: $data['booking_id'],
            customer_name: $data['customer_name'],
            driver_name: $data['driver_name'],
            driver_phone: $data['driver_phone'] ?? null,
            driver_plate: $data['driver_plate'] ?? null,
            total_amount: (float) $data['total_amount'],
            items: $data['items'],
            notes: $data['notes'] ?? null,
            payment_method: $data['payment_method'] ?? 'gofood'
        );
    }
}

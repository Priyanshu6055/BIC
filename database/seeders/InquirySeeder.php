<?php

namespace Database\Seeders;

use App\Models\Inquiry;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InquirySeeder extends Seeder
{
    public function run(): void
    {
        $types = ['startup', 'msme', 'investor', 'ma'];

        foreach ($types as $type) {
            Inquiry::create([
                'reference' => 'BIC-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6)),
                'type' => $type,
                'name' => 'Test User ' . ucfirst($type),
                'email' => "test_$type@example.com",
                'phone' => '+919876543210',
                'company' => 'Test Company ' . ucfirst($type),
                'payload' => ['test' => 'data'],
                'document_path' => null,
                'status' => 'New',
            ]);
        }
    }
}

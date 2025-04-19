<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant;

class TenantSeed extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::create(['id' => 'tenant1']);
        $tenant->domains()->create(['domain' => 'tenant1.localhost']);
    }
}

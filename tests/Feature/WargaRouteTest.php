<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Warga;
use App\Models\Pengumuman;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WargaRouteTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_warga_create_page(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/warga/create');
        $response->assertStatus(200);
    }

    public function test_admin_can_access_pengumuman_create_page(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/pengumuman/create');
        $response->assertStatus(200);
    }

    public function test_warga_cannot_access_warga_management(): void
    {
        $warga = User::factory()->create(['role' => 'warga']);

        $response = $this->actingAs($warga)->get('/warga/create');
        $response->assertStatus(403);
    }
}

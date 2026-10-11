<?php

namespace Tests\Feature;

use App\Models\MasterNotification;
use Database\Seeders\MasterNotificationSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MasterNotificationSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeder_creates_all_thirteen_push_enabled_templates_idempotently(): void
    {
        $seeder = app(MasterNotificationSeeder::class);

        $seeder->run();
        $seeder->run();

        $this->assertSame(13, MasterNotification::count());
        $this->assertSame(13, MasterNotification::where('push_enabled', true)->count());
        $this->assertSame(13, MasterNotification::where('is_active', true)->count());
        $this->assertDatabaseHas('master_notifications', [
            'code' => 'training_application_status_changed',
            'title_template' => 'Status pendaftaran :training',
        ]);
    }
}

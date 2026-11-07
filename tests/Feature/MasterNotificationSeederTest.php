<?php

namespace Tests\Feature;

use App\Models\MasterNotification;
use Database\Seeders\MasterNotificationSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MasterNotificationSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_reseeding_restores_deleted_templates_without_changing_their_identity(): void
    {
        $seeder = app(MasterNotificationSeeder::class);
        $seeder->run();

        $template = MasterNotification::where('code', 'order_token_approved')->firstOrFail();
        $identity = $template->only(['id', 'uuid', 'code']);
        $template->delete();

        $seeder->run();

        $restored = MasterNotification::where('code', $identity['code'])->sole();
        $this->assertSame($identity, $restored->only(['id', 'uuid', 'code']));
        $this->assertNull($restored->deleted_at);
    }
}

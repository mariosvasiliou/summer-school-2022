<?php

namespace Tests\Unit\Jobs;

use App\Models\Contact;
use App\Models\Report;
use App\Models\User;
use App\Notifications\ClientReportNotification;
use Database\Seeders\ReportSeeder;
use File;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Notification;
use Storage;
use Tests\TestCase;

/**
 * @coversDefaultClass \App\Jobs\NotifyUserOfCompletedClientExport
 */
class NotifyUserOfCompletedClientExportTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @date   25/8/2022
     * @author MariosV
     */
    public function user_get_notified_on_excel_export(): void
    {
        $this->seed(ReportSeeder::class);
        Contact::factory()->count(50)->create(['is_client' => 1]);
        $date = now();
        $this->travelTo($date);
        $user = User::factory()->createOneQuietly();
        Notification::fake();

        $this->actingAs($user)
             ->get(route('reports.excel', ['report' => Report::first()->id]));

        $fileName = sprintf('clients-%s.xlsx', now()->format('d_m_Y_H_i_s'));
        $fullPath = Storage::disk('exports')->path($fileName);

        Notification::assertSentTo(
            $user,
            function (ClientReportNotification $notification, $channels) use ($fullPath) {
                return $notification->filepath === $fullPath;
            }
        );

        File::delete($fullPath);

    }

    /**
     * @test
     * @date   25/8/2022
     * @author MariosV
     */
    public function user_get_notified_on_pdf_export(): void
    {
        $this->seed(ReportSeeder::class);
        Contact::factory()->count(50)->create(['is_client' => 1]);
        $date = now();
        $this->travelTo($date);
        $user = User::factory()->createOneQuietly();
        Notification::fake();

        $this->actingAs($user)
             ->get(route('reports.pdf', ['report' => Report::first()->id]));

        $fileName = sprintf('clients-%s.pdf', now()->format('d_m_Y_H_i_s'));
        $fullPath = Storage::disk('exports')->path($fileName);

        Notification::assertSentTo(
            $user,
            function (ClientReportNotification $notification, $channels) use ($fullPath) {
                return $notification->filepath === $fullPath;
            }
        );

        File::delete($fullPath);

    }
}

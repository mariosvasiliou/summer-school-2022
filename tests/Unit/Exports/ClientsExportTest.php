<?php

namespace Tests\Unit\Exports;

use App\Models\Contact;
use App\Models\Report;
use App\Models\User;
use Database\Seeders\ReportSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

/**
 * @coversDefaultClass \App\Exports\ClientsExport
 */
class ClientsExportTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     * @date   25/8/2022
     * @author MariosV
     */
    public function user_can_queue_export_in_excel(): void
    {
        $this->seed(ReportSeeder::class);
        Contact::factory()->count(50)->create(['is_client' => 1]);
        $date = now();
        $this->travelTo($date);
        $user = User::factory()->createOneQuietly();
        Excel::fake();

        $this->actingAs($user)
             ->get(route('reports.excel', ['report' => Report::first()->id]));

        $fileName = sprintf('clients-%s.xlsx', now()->format('d_m_Y_H_i_s'));

        Excel::assertQueued($fileName, 'exports');

    }

    /**
     * @test
     * @date   25/8/2022
     * @author MariosV
     */
    public function user_can_queue_export_in_pdf(): void
    {
        $this->seed(ReportSeeder::class);
        Contact::factory()->count(50)->create(['is_client' => 1]);
        $date = now();
        $this->travelTo($date);
        $user = User::factory()->createOneQuietly();
        Excel::fake();

        $this->actingAs($user)
             ->get(route('reports.pdf', ['report' => Report::first()->id]));

        $fileName = sprintf('clients-%s.pdf', now()->format('d_m_Y_H_i_s'));

        Excel::assertQueued($fileName, 'exports');

    }
}

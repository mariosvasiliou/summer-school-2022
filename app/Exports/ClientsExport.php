<?php

namespace App\Exports;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomQuerySize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use Throwable;

class ClientsExport implements FromQuery, ShouldAutoSize, WithMapping, WithHeadings, WithEvents, WithCustomQuerySize
{
    use Exportable;

    public function query(): EloquentBuilder|Builder
    {
        return Contact::with('department')->where('is_client', 1);
    }

    public function querySize(): int
    {
        return 500;
    }

    public function map($contact): array
    {
        return [
            $contact->id,
            $contact->full_name ?? '',
            $contact->is_legal_entity ? 'Yes' : 'No',
            $contact->gender ?? '',
            $contact->email ?? '',
            $contact->street ?? '',
            $contact->building ?? '',
            $contact->number ?? '',
            $contact->postal_code ?? '',
            $contact->city ?? '',
            $contact->country ?? '',
            $contact->home_number ?? '',
            $contact->work_number ?? '',
            $contact->mobile_number ?? '',
            $contact->comments ?? '',
            optional($contact->department)->name ?? '',
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            __('Name'),
            __('Is Legal Entity'),
            __('Gender'),
            __('Email'),
            __('Street'),
            __('Building'),
            __('Number'),
            __('Postal Code'),
            __('City'),
            __('Country'),
            __('Home Number'),
            __('Work Number'),
            __('Mobile Number'),
            __('Comments'),
            __('Departments'),
        ];
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $event->sheet
                    ->getPageSetup()
                    ->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
            },
        ];
    }

    public function failed(Throwable $exception): void
    {
        // handle failed export
        report($exception);
        //todo perhaps notify user that export is failed?
    }
}

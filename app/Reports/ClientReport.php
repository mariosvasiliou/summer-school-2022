<?php

namespace App\Reports;

use App\Exports\ClientsExport;
use App\Jobs\NotifyUserOfCompletedClientExport;
use Storage;

class ClientReport extends BasicReport
{

    /**
     * @inheritDoc
     */
    public function downloadExcel()
    {
        $fileName = sprintf('clients-%s.xlsx', now()->format('d_m_Y_H_i_s'));
        $fullPath = Storage::disk('exports')->path($fileName);
        (new ClientsExport)->queue($fileName, 'exports', \Maatwebsite\Excel\Excel::XLSX)->chain([
            new NotifyUserOfCompletedClientExport(auth()->user(), $fullPath),
        ]);
        return response('success');

    }

    /**
     * @inheritDoc
     */
    public function downloadPDF()
    {
        $fileName = sprintf('clients-%s.pdf', now()->format('d_m_Y_H_i_s'));
        $fullPath = Storage::disk('exports')->path($fileName);
        (new ClientsExport)->queue($fileName, 'exports', \Maatwebsite\Excel\Excel::DOMPDF)->chain([
            new NotifyUserOfCompletedClientExport(auth()->user(), $fullPath),
        ]);
        return response('success');
    }
}

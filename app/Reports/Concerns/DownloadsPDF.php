<?php

namespace App\Reports\Concerns;

interface DownloadsPDF
{
    /**
     * Download PDF .pdf file
     *
     * @return mixed
     */
    public function downloadPDF();
}

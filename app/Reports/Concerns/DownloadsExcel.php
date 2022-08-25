<?php

namespace App\Reports\Concerns;

interface DownloadsExcel
{
    /**
     * Download excel .xlsx file
     *
     * @return mixed
     */
    public function downloadExcel();
}

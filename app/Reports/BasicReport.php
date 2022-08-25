<?php

namespace App\Reports;

use App\Reports\Concerns\DownloadsExcel;
use App\Reports\Concerns\DownloadsPDF;

abstract class BasicReport implements DownloadsPDF, DownloadsExcel
{
}

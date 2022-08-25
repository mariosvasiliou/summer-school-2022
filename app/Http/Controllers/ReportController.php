<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(): View|Factory|Application
    {
        $this->authorize('viewAny', Report::class);
        $reports = Report::where('is_active', 1)->paginate();
        return view('pages.reports.index', ['reports' => $reports]);
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function exportExcel(Report $report)
    {
        $this->authorize('view', $report);

        //check if results > 1000 then queue else immediately
        //inform user with appropriate message
        return (new ($report->class_name))->downloadExcel();
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function exportPDF(Report $report)
    {
        $this->authorize('view', $report);
        //check if results > 1000 then queue else immediately
        //inform user with appropriate message
        return (new $report->class_name())->downloadPDF();
    }
}

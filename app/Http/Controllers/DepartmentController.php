<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;
use Arr;
use Cache;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DepartmentController extends Controller
{

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Department::class, 'department');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request): View|Factory|Application
    {
        $uniqueKey   = implode('_', array_merge($request->keys(), $request->input()));
        $departments = Cache::tags(['departments'])->rememberForever('departments_' . $uniqueKey, function () {
            return Department::withCount('contacts')->paginate(1);
        });
        return view('pages.departments.index', ['departments' => $departments]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(): View|Factory|Application
    {
        return view('pages.departments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreDepartmentRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreDepartmentRequest $request): RedirectResponse
    {
        $data = $request->validated();
        Department::create($data);

        Cache::tags(['departments'])->flush();

        //todo show message to user? check https://php-flasher.io/
        return redirect()->route('departments.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Department $department
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Department $department): View|Factory|Application
    {
        return \view('pages.departments.view', ['department' => $department]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Department $department
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Department $department): Application|Factory|View
    {
        return \view('pages.departments.edit', ['department' => $department]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateDepartmentRequest $request
     * @param \App\Models\Department                     $department
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateDepartmentRequest $request, Department $department): RedirectResponse
    {
        $data = $request->validated();
        if (!Arr::has($data, ['is_active'])) {
            Arr::set($data, 'is_active', 0);
        }
        $department->update($data);

        //todo show message to user? check https://php-flasher.io/
        return redirect()->route('departments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Department $department
     *
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function destroy(Department $department): Response
    {
        Cache::tags(['departments'])->flush();
        //todo perhaps permit if department is used by contacts
        $department->deleteOrFail();
        return response('success');
    }
}

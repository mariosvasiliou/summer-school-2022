<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Contact;
use App\Models\Department;
use App\Models\User;
use Arr;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(): View|Factory|Application
    {
        $users = User::with('contact:id,first_name,last_name')->paginate();
        return view('pages.users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(): View|Factory|Application
    {
        $departments = Department::get();
        return view('pages.users.create', ['departments' => $departments]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreUserRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $data     = $request->validated();
        $is_admin = Arr::pull($data, 'is_admin', 0);
        $contact  = Contact::create($data);
        User::create([
            'email'      => Arr::get($data, 'email'),
            'password'   => Hash::make(Arr::get($data, 'password')),
            'contact_id' => $contact->id,
            'is_admin'   => $is_admin,
        ]);
        //todo show message to user? check https://php-flasher.io/
        return redirect()->route('users.index');

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\User $user
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(User $user): View|Factory|Application
    {
        $user->load('contact.department');
        return \view('pages.users.view', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\User $user
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(User $user): View|Factory|Application
    {
        $user->load('contact.department');
        $departments = Department::get();

        return \view('pages.users.edit', ['user' => $user, 'departments' => $departments]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateUserRequest $request
     * @param \App\Models\User                     $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $data     = $request->validated();
        $is_admin = Arr::pull($data, 'is_admin', 0);
        $user->contact->update($data);
        $user->update([
            'email'    => Arr::get($data, 'email'),
            'is_admin' => $is_admin,
        ]);
        //todo show message to user? check https://php-flasher.io/
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $user
     *
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function destroy(User $user): Response
    {
        $user->deleteOrFail();
        return response('success');
    }
}

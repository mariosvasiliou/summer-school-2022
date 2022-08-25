<?php

namespace App\Http\Controllers;

use App\Exceptions\ContactIsUserException;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Jobs\ContactReport;
use App\Models\Contact;
use App\Models\Department;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class ContactController extends Controller
{

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Contact::class, 'contact');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(): View|Factory|Application
    {
        $contacts = Contact::paginate()->withQueryString();

        return view('pages.contacts.index', ['contacts' => $contacts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(): View|Factory|Application
    {
        $departments = Department::get();
        return view('pages.contacts.create', ['departments' => $departments]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreContactRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreContactRequest $request): RedirectResponse
    {
        $data = $request->validated();
        Contact::create($data);

        //todo return message to user?
        //todo highlight latest??
        return redirect()->route('contacts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Contact $contact
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Contact $contact): View|Factory|Application
    {
        $contact->loadMissing('department');
        return \view('pages.contacts.view', ['contact' => $contact]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Contact $contact
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Contact $contact): View|Factory|Application
    {
        $departments = Department::get();
        return \view('pages.contacts.edit', ['contact' => $contact, 'departments' => $departments]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateContactRequest $request
     * @param \App\Models\Contact                     $contact
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateContactRequest $request, Contact $contact): RedirectResponse
    {
        $data = $request->validated();
        $contact->update($data);

        //todo return message to user?
        //todo highlight latest??
        return redirect()->route('contacts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Contact $contact
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Throwable
     */
    public function destroy(Contact $contact): Application|ResponseFactory|Response
    {
        $this->authorize('delete');
        throw_if($contact->is_user, ContactIsUserException::class);

        $contact->deleteOrFail();

        //todo return message to user?
        return response('success');

    }
}

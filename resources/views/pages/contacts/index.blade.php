@php use App\Models\Contact; @endphp
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-1 justify-content-end">
            <div class="col-3">
                @can('create',Contact::class)
                    <button class="btn btn-success btn-md float-end" onclick="goToCreateView(this)"
                            data-href="{{route('contacts.create')}}">
                        {{__('Create')}} <i class="bi bi-plus-square-dotted"></i>
                    </button>
                @endcan
            </div>
        </div>
        <div class="row">
            <table class="table table-bordered table-striped bg-white">
                <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>{{__('Full Name')}}</th>
                    <th>{{__('Email')}}</th>
                    <th>{{__('Address')}}</th>
                    <th>{{__('Work/Home No.')}}</th>
                    <th>{{__('Mobile No.')}}</th>
                    <th>{{__('Comments')}}</th>
                    <th>{{__('Actions')}}</th>
                </tr>
                </thead>
                <tbody class="table-group-divider">
                @foreach($contacts as $contact)
                    <tr>
                        <th>{{$contact->id}}</th>
                        <th>
                            <a @class([
                              'link-info'=>!$contact->is_client && !$contact->is_user,
                              'link-primary'=>$contact->is_client,
                              'link-warning'=>$contact->is_user])
                               href="{{route ('contacts.show', ['contact'=>$contact->id])}}" target="_blank">
                                {{$contact->full_name}}
                            </a>
                        </th>
                        <th>{{$contact->email}}</th>
                        <th>{{$contact->full_address}}</th>
                        <th>{{$contact->work_number ?? $contact->home_number}}</th>
                        <th>{{$contact->mobile_number}}</th>
                        <th>{{\Str::limit($contact->comments,30)}}</th>
                        <th>
                            @can('update',$contact)
                                <a class="btn btn-sm btn-outline-warning"
                                   href="{{route('contacts.edit',['contact'=>$contact->id])}}"
                                   title="Edit" data-bs-toggle="tooltip">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            @endcan
                            @can('delete',$contact)
                                <a class="btn btn-sm btn-outline-danger delete" data-href="{{route('contacts.destroy',['contact'=>$contact->id])}}"
                                   title="Delete" data-bs-toggle="tooltip" onclick="deleteEntity(this)">
                                    <i class="bi bi-trash"></i>
                                </a>
                            @endcan
                        </th>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $contacts->links() }}
        </div>
    </div>
@stop

@push('scripts')
    <script src="{{ mix('js/grids.js') }}" defer></script>
@endpush

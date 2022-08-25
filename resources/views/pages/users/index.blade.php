@php use App\Models\User; @endphp
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-1 justify-content-end">
            <div class="col-3">
                @can('create',User::class)
                    <button class="btn btn-success btn-md float-end" onclick="goToCreateView(this)"
                            data-href="{{route('users.create')}}">
                        {{__('Create')}} <i class="bi bi-plus-square-dotted"></i>
                    </button>
                @endcan
            </div>
        </div>
        <div class="row">
            <table class="table table-bordered table-striped bg-white">
                <thead class="table-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{__('Contact')}}</th>
                    <th scope="col">{{__('Email')}}</th>
                    <th scope="col">{{__('Verified')}}</th>
                    <th scope="col">{{__('Admin')}}</th>
                    <th scope="col">{{__('Actions')}}</th>
                </tr>
                </thead>
                <tbody class="table-group-divider">
                @foreach($users as $user)
                    <tr>
                        <th>{{$user->id}}</th>
                        <th>
                            <a @class([
                              'link-info'=>!$user->is_admin,
                              'link-danger'=>$user->is_admin])
                               href="{{route ('users.show', ['user'=>$user->id])}}" target="_blank">
                                {{$user->contact->full_name}}
                            </a>
                        </th>
                        <th>{{$user->email}}</th>
                        <th>{{ optional($user->email_verified_at)->format('d.m.Y H:i:s') ?? ''}}</th>
                        <th @class(['text-danger'=>$user->is_admin])>{{$user->is_admin ? 'Yes' : 'No'}}</th>
                        <th>
                            @can('update',$user)
                                <a class="btn btn-sm btn-outline-warning" href="{{route('users.edit',['user'=>$user->id])}}"
                                   title="Edit" data-bs-toggle="tooltip">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            @endcan
                            @can('delete',$user)
                                <a class="btn btn-sm btn-outline-danger delete"
                                   data-href="{{route('users.destroy',['user'=>$user->id])}}"
                                   title="Delete" data-bs-toggle="tooltip" onclick="deleteEntity(this)">
                                    <i class="bi bi-trash"></i>
                                </a>
                            @endcan
                        </th>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $users->links() }}
        </div>
    </div>
@stop

@push('scripts')
    <script src="{{ mix('js/grids.js') }}" defer></script>
@endpush

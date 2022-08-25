@extends('layouts.app')

@section('content')
    <div class="container px-5">
        <div class="row justify-content-center">
            <div class="col-7">
                <div class="card">
                    <h5 class="card-header bg-secondary text-white">
                        {{$user->contact->full_name}}
                        @if ($user->is_admin)
                            <span class="badge bg-danger">{{__('Admin')}}</span>
                        @else
                            <span class="badge bg-info">{{__('User')}}</span>
                        @endif
                    </h5>
                    <div class="card-body">
                        <p class="card-text">
                            <strong>{{ __('Email: ')}}</strong> {{ $user->email ?? 'Not set'}}<br />
                            <strong>{{ __('Email Verified: ')}}</strong> {{  optional($user->email_verified_at)->format('d.m.Y H:i:s') ?? 'No'}}<br />
                            <strong>{{ __('Address: ')}}</strong> {{$user->contact->full_address ?? 'Not set'}}<br />
                            <strong>{{ __('Department: ')}}</strong> {{$user->contact->department->name ?? 'Not set'}}<br />
                            <strong>{{ __('Comments: ')}}</strong> {{$user->contact->comments ?? 'Not set'}}<br />
                        </p>
                        <div class="text-center">
                            <a href="{{route('users.edit',['user'=>$user->id])}}" class="btn btn-md btn-warning text-center">
                                {{__('Edit')}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@stop

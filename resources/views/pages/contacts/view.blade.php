@extends('layouts.app')

@section('content')
    <div class="container px-5">
        <div class="row justify-content-center">
            <div class="col-7">
                <div class="card">
                    <h5 class="card-header bg-secondary text-white">
                        {{$contact->full_name}}
                        @if ($contact->is_client)
                            <span class="badge bg-primary">{{__('Client')}}</span>
                        @elseif ($contact->is_user)
                            <span class="badge bg-warning">{{__('User')}}</span>
                        @else
                            <span class="badge bg-info">{{__('Contact')}}</span>
                        @endif
                    </h5>
                    {{--                    <img class="card-img-top"--}}
                    {{--                         src="https://ui-avatars.com/api/?name={{urlencode($contact->full_name)}}&background=random&size=128" alt="{{$contact->full_name}}">--}}
                    <div class="card-body">
                        <p class="card-text">
                            <strong>{{ __('Email: ')}}</strong> {{ $contact->email ?? 'Not set'}}<br />
                            <strong>{{ __('Address: ')}}</strong> {{$contact->full_address ?? 'Not set'}}<br />
                            <strong>{{ __('Department: ')}}</strong> {{$contact->department->name ?? 'Not set'}}<br />
                            <strong>{{ __('Comments: ')}}</strong> {{$contact->comments ?? 'Not set'}}<br />
                        </p>
                        <div class="text-center">
                            <a href="{{route('contacts.edit',['contact'=>$contact->id])}}" class="btn btn-md btn-warning text-center">
                                {{__('Edit')}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@stop

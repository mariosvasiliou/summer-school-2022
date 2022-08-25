@extends('layouts.app')
@section('content')
    <div class="container px-5">
        <h1 class="text-center">{{__('Edit User')}}
            <small class="text-info">{{ $user->contact->full_name }}</small>
        </h1>
        <hr />
        @include('forms.user',['url'=>route('users.update',['user'=>$user->id]),'contact'=>$user->contact,'user'=>$user])
    </div>
@stop

@extends('layouts.app')
@section('content')
    <div class="container px-5">
        <h1 class="text-center">{{__('Edit Department')}}
            <small class="text-info">{{ $department->name }}</small>
        </h1>
        <hr />
        @include('forms.department',['url'=>route('departments.update',['department'=>$department->id]),'department'=>$department])
    </div>
@stop

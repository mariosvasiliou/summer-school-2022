@extends('layouts.app')

@section('content')
    <div class="container px-5">
        <div class="row justify-content-center">
            <div class="col-7">
                <div class="card">
                    <h5 class="card-header bg-secondary text-white">
                        {{$department->name}}
                        @if ($department->is_active)
                            <span class="badge bg-success">{{__('Active')}}</span>
                        @else
                            <span class="badge bg-danger">{{__('Inactive')}}</span>
                        @endif
                    </h5>
                    <div class="card-body">
                        <p class="card-text">
                            <strong>{{ __('Description: ')}}</strong> {{$department->description ?? 'Not set'}}<br />
                        </p>
                        <div class="text-center">
                            <a href="{{route('departments.edit',['department'=>$department->id])}}" class="btn btn-md btn-warning text-center">
                                {{__('Edit')}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

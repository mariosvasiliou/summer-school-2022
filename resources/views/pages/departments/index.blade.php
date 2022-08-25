@php use App\Models\Department; @endphp
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-1 justify-content-end">
            <div class="col-3">
                @can('create',Department::class)
                    <button class="btn btn-success btn-md float-end" onclick="goToCreateView(this)" data-href="{{route('departments.create')}}">
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
                    <th scope="col">{{__('Name')}}</th>
                    <th scope="col" colspan="2">{{__('Description')}}</th>
                    <th scope="col">{{__('Active')}}</th>
                    <th scope="col">{{__('Assigned Contacts')}}</th>
                    <th scope="col">{{__('Actions')}}</th>
                </tr>
                </thead>
                <tbody class="table-group-divider">
                @foreach($departments as $department)
                    <tr>
                        <th style="width: 5%">{{$department->id}}</th>
                        <th>
                            <a @class([
                              'link-danger'=>!$department->is_active,
                              'link-success'=>$department->is_active])
                               href="{{route ('departments.show', ['department'=>$department->id])}}" target="_blank">
                                {{$department->name}}
                            </a>
                        </th>
                        <th colspan="2">{{\Str::limit($department->description,150)}}</th>
                        <th @class(['text-danger'=>!$department->is_active]) style="width: 10%">{{$department->is_active ? 'Yes' : 'No'}}</th>
                        <th>{{$department->contacts_count}}</th>
                        <th style="width: 10%">
                            @can('update',$department)
                                <a class="btn btn-sm btn-outline-warning"
                                   href="{{route('departments.edit',['department'=>$department->id])}}"
                                   title="Edit" data-bs-toggle="tooltip">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            @endcan
                            @can('delete',$department)
                                <a class="btn btn-sm btn-outline-danger delete"
                                   data-href="{{route('departments.destroy',['department'=>$department->id])}}"
                                   title="Delete" data-bs-toggle="tooltip" onclick="deleteEntity(this)">
                                    <i class="bi bi-trash"></i>
                                </a>
                            @endcan
                        </th>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $departments->links() }}
        </div>
    </div>
@stop

@push('scripts')
    <script src="{{ mix('js/grids.js') }}" defer></script>
@endpush

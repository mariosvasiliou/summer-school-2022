@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form id="{{!isset($department)  ?'department_create_form' : 'department_update_form'}}" method="POST" action="{{ $url  }}">
    @csrf
    @if(isset($department))
        @method('PUT')
    @endif
    <div class="mb-3">
        <label class="form-label required" for="name">{{__('Name')}}</label>
        <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" type="text" placeholder="Write Name" maxlength="255" required
               value="{{ $department->name ?? old('name') }}" />
    </div>
    <div class="mb-3">
        <label class="form-label" for="description">{{__("Description")}}</label>
        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" type="text" placeholder="Write Description"
                  style="height:10rem;" maxlength="1000">{{ $department->description ?? old('description')}}</textarea>
    </div>
    <div class="mb-3">
        <div class="form-check form-switch form-switch-md">
            <input class="form-check-input @error('is_active') is-invalid @enderror" id="is_active" type="checkbox" name="is_active"
                   @checked( $department->is_active ?? old('is_active') ?? 1) value="1" />
            <label class="form-check-label mt-1 mx-1" for="is_active">{{__('Active')}}</label>
        </div>
    </div>
    <div class="d-grid">
        <div class="col-12 text-center">
            <button @class([
                      'btn btn-lg',
                      'btn-success'=>!isset($department),
                      'btn-warning'=>isset($department)
                    ]) id="submitButton" type="submit">
                {{ !isset($department) ? __('Create') :  __('Update')}}
            </button>
        </div>
    </div>
</form>


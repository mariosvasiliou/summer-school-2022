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
<form id="{{!isset($contact)  ?'contact_create_form' : 'contact_update_form'}}" method="POST" action="{{ $url  }}">
    @csrf
    @if(isset($contact))
        @method('PUT')
    @endif
    <div class="mb-3">
        <div class="form-check form-switch form-switch-md">
            <input class="form-check-input @error('is_legal_entity') is-invalid @enderror" id="is_legal_entity" type="checkbox" name="is_legal_entity"
                   @checked($contact->is_legal_entity ?? old('is_legal_entity')) value="1" />
            <label class="form-check-label mt-1 mx-1" for="is_legal_entity">{{__('Is Legal Entity?')}}</label>
        </div>
    </div>
    <div class="row physical">
        <div class="mb-3 col-md-5">
            <label class="form-label required" for="first_name">{{__('First Name')}}</label>
            <input class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" type="text" placeholder="Write First Name" maxlength="255"
                   required value="{{$contact->first_name ?? old('first_name') }}" />
        </div>
        <div class="mb-3 col-md-5">
            <label class="form-label required" for="last_name">{{__('Last Name')}}</label>
            <input class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" type="text" placeholder="Write Last Name" maxlength="255" required
                   value="{{$contact->last_name ?? old('last_name')}}" />
        </div>
        <div class="mb-3 col-md-2">
            <label class="form-label" for="gender">{{__('Gender')}}</label>
            <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" aria-label="Gender">
                <option value="male" @selected(optional($contact)->gender === 'male') >
                    {{ __('Male') }}
                </option>
                <option value="female" @selected(optional($contact)->gender === 'female') >
                    {{ __('Female') }}
                </option>
                <option value="trans" @selected(optional($contact)->gender === 'trans') >
                    {{ __('Transgender') }}
                </option>
                <option value="other" @selected(optional($contact)->gender === 'other' || blank(optional($contact)->gender)) >
                    {{ __('Other') }}
                </option>
            </select>
        </div>
    </div>
    <div class="row legal">
        <div class="mb-3">
            <label class="form-label required" for="legal_name">{{__('Legal Name')}}</label>
            <input class="form-control @error('legal_name') is-invalid @enderror" id="legal_name" name="legal_name" type="text" placeholder="Write Legal Name" maxlength="255"
                   required value="{{$contact->legal_name ?? old('legal_name')}}" />
        </div>
    </div>
    <div class="row">
        <div class="mb-3 col-md-6">
            <label class="form-label required" for="email">{{__('Email Address')}}</label>
            <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="text" placeholder="Write Email Address" required
                   value="{{$contact->email ?? old('email')}}" />
        </div>
        <div class="mb-3 col-md-6">
            <label class="form-label" for="department_id">{{__('Department')}}</label>
            <select class="form-select @error('department_id') is-invalid @enderror" id="department_id" name="department_id" aria-label="Department">
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}" @selected($contact->department_id?? old('department_id') === $department->id)>
                        {{ $department->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="mb-3 col-md-6">
            <label class="form-label" for="street">{{__('Street')}}</label>
            <input class="form-control @error('street') is-invalid @enderror" id="street" name="street" type="text" placeholder="Write Street name" maxlength="255"
                   value="{{$contact->street ?? old('street')}}" />
        </div>
        <div class="mb-3 col-md-4">
            <label class="form-label" for="building">{{__('Building')}}</label>
            <input class="form-control @error('building') is-invalid @enderror" id="building" name="building" type="text" placeholder="Write Building name" maxlength="255"
                   value="{{$contact->building ?? old('building')}}" />
        </div>
        <div class="mb-3 col-md-2">
            <label class="form-label" for="number">{{__('Number')}}</label>
            <input class="form-control @error('number') is-invalid @enderror" id="number" name="number" type="text" placeholder="Write Number" maxlength="10"
                   value="{{$contact->number ?? old('number')}}" />
        </div>
    </div>
    <div class="row">
        <div class="mb-3 col-md-4">
            <label class="form-label" for="postal_code">{{__('Postal Code')}}</label>
            <input class="form-control @error('postal_code') is-invalid @enderror" id="postal_code" name="postal_code" type="text" placeholder="Write Postal Code" maxlength="10"
                   value="{{$contact->postal_code ?? old('postal_code')}}" />
        </div>
        <div class="mb-3 col-md-4">
            <label class="form-label" for="city">{{__('City')}}</label>
            <input class="form-control @error('city') is-invalid @enderror" id="city" name="city" type="text" placeholder="Write City" maxlength="30"
                   value="{{$contact->city ?? old('city')}}" />
        </div>
        <div class="mb-3 col-md-4">
            <label class="form-label" for="country">{{__("Country")}}</label>
            <input class="form-control @error('country') is-invalid @enderror" id="country" name="country" type="text" placeholder="Write Country" maxlength="30"
                   value="{{$contact->country ?? old('country')}}" />
        </div>
    </div>
    <div class="row">
        <div class="mb-3 col-md-4 physical">
            <label class="form-label" for="home_number">{{__('Home Number')}}</label>
            <input class="form-control @error('home_number') is-invalid @enderror" id="home_number" name="home_number" type="text" placeholder="Write Home Phone Number"
                   maxlength="30" value="{{$contact->home_number ?? old('home_number')}}" />
        </div>
        <div class="mb-3 col-md-4 physical">
            <label class="form-label" for="mobile_number">{{__('Mobile Number')}}</label>
            <input class="form-control @error('mobile_number') is-invalid @enderror" id="mobile_number" name="mobile_number" type="text" placeholder="Write Mobile Phone Number"
                   maxlength="30" value="{{$contact->mobile_number ?? old('mobile_number')}}" />
        </div>
        <div class="mb-3 col-md-4">
            <label class="form-label" for="work_number">{{__('Work Number')}}</label>
            <input class="form-control @error('work_number') is-invalid @enderror" id="work_number" name="work_number" type="text" placeholder="Write Work Phone Number"
                   maxlength="30" value="{{$contact->work_number ?? old('work_number') }}" />
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label" for="comments">{{__("Comments")}}</label>
        <textarea class="form-control @error('comments') is-invalid @enderror" id="comments" name="comments" type="text" placeholder="Write some Comments" style="height:10rem;"
                  maxlength="65000">{{$contact->comments ?? old('comments')}}</textarea>
    </div>
    <div class="mb-3">
        <div class="form-check form-switch form-switch-md">
            <input class="form-check-input @error('is_client') is-invalid @enderror" id="is_client" type="checkbox" name="is_client"
                   @checked($contact->is_client ?? old('is_client')) value="1" />
            <label class="form-check-label mt-1 mx-1" for="is_client">{{__('Client')}}</label>
        </div>
    </div>
    <div class="mb-3 physical">
        <div class="form-check form-switch form-switch-md">
            <input class="form-check-input @error('is_user') is-invalid @enderror" id="is_user" type="checkbox" name="is_user"
                   @checked($contact->is_user ?? old('is_user')) value="1" />
            <label class="form-check-label mt-1 mx-1" for="is_user">{{__('User')}}</label>
        </div>
    </div>
    <div class="d-grid">
        <div class="col-12 text-center">
            <button @class([
                      'btn btn-lg',
                      'btn-success'=>!isset($contact),
                      'btn-warning'=>isset($contact)
                    ]) id="submitButton" type="submit">
                {{ !isset($contact) ? __('Create') :  __('Update')}}
            </button>
        </div>
    </div>
</form>

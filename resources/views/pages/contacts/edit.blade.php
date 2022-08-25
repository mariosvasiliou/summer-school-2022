@extends('layouts.app')
@section('content')
    <div class="container px-5">
        <h1 class="text-center">{{__('Edit Contact')}}
            <small class="text-info">{{ $contact->full_name }}</small>
        </h1>
        <hr />
        @include('forms.contact',['url'=>route('contacts.update',['contact'=>$contact->id]),'contact'=>$contact])
    </div>
@stop

@push('scripts')
    <script>
        let switchLegal = document.getElementById('is_legal_entity');
        let firstNameInput = document.getElementById('first_name');
        let lastNameInput = document.getElementById('last_name');
        let legalNameInput = document.getElementById('legal_name');

        function switchInputsForLegal() {
            let legalDivs = document.querySelectorAll('.legal');
            let physicalDivs = document.querySelectorAll('.physical');
            if (switchLegal.checked) {//legal selected
                legalDivs.forEach(function(div) {
                    div.style.display = '';
                });
                physicalDivs.forEach(function(div) {
                    div.style.display = 'none';
                });
                firstNameInput.required = false;
                lastNameInput.required = false;
                legalNameInput.required = true;
            } else {//physical selected
                legalDivs.forEach(function(div) {
                    div.style.display = 'none';
                });
                physicalDivs.forEach(function(div) {
                    div.style.display = '';
                });
                firstNameInput.required = true;
                lastNameInput.required = true;
                legalNameInput.required = false;
            }
        }

        document.addEventListener('DOMContentLoaded', function(event) {
            switchInputsForLegal();
            switchLegal.addEventListener('change', switchInputsForLegal);
        });
    </script>
@endpush

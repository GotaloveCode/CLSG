@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="card">
                <div class="card-header">{{ __('Expression Of Interest Form') }}</div>
                <div class="card-body">
                    <eoi-form submit-url="{{ route('eois.store') }}"
                              :services="{{ $services }}"
                              :connections="{{ $connections }}"
                              :estimated-costs="{{ $estimatedCosts }}"
                              :operation-costs="{{ $operationCosts }}"
                    ></eoi-form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

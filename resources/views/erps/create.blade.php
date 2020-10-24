@extends('layouts.dashboard')

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">{{ __('Emergency Response Plan Form') }}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('Emergency Response Plan Form') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body"><!-- Content start -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            @isset($erp)
                                <erp-form :existing-erp="{{$erp_load}}" submit-url="{{ route('erps.update',$erp->id) }}"
                                          wsp_id="{{$wsp->id}}"
                                          :interventions="{{ $interventions }}"></erp-form>
                            @else
                                <erp-form submit-url="{{ route('erps.store') }}" wsp_id="{{$wsp->id}}"
                                          :interventions="{{ $interventions }}"></erp-form>
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Content end -->
    </div>

@endsection

@extends('layouts.dashboard')

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">{{ __('Report Formats Form') }}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('Report Formats Form') }}
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
                        <format-form
                            :scores="{{$items}}"
                            :format_item="{{$format_item}}"
                        ></format-form>

                    </div>
                </div>
            </div>
        </div>
        <!-- Content end -->
    </div>

@endsection

@extends('layouts.dashboard')

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">{{ __('Performance Score Card') }}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('Performance Score Card') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">
        <section id="card-headings">
            <div class="row">
                <performance-card
                    :score="{{$score}}"
                ></performance-card>
            </div>
        </section>
    </div>
@endsection

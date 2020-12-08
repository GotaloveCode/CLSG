@extends('layouts.dashboard')

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">{{ __('CSLG CALCULATION') }}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('CSLG CALCULATION') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    @role("wstf")
                    <div class="card-header">
                        <div class="card-title text-right">
                            @if($cslg_calculation == 'Pending')
                                <a href="{{route("cslg-calculation.create")}}" class="btn btn-primary"> <i
                                            class="feather icon-dollar-sign"></i>Disburse</a>
                            @endif
                        </div>
                    </div>
                    @endrole
                    <div class="card-content">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Amount</th>
                                </tr>
                                </thead>
                                <tr>
                                    <td>Verified amount of revenues collected during in the month (KES) :</td>
                                    <td>{{ number_format($cslg_calculation->revenue) }}</td>
                                </tr>
                                <tr>
                                    <td>Grant Multiplier for this month (as per CLSG Agreement) :</td>
                                    <td>{{ $cslg_calculation->monthly_grant_multiplier }}</td>
                                </tr>
                                <tr>
                                    <td>Actual Performance Score (%) :</td>
                                    <td>{{ $cslg_calculation->actual_performance_score }}%</td>
                                </tr>
                                <tr>
                                    <td>Performance Adjustment (%) :</td>
                                    <td>{{ $cslg_calculation->adjusted_performance_score }}%</td>
                                </tr>
                                <tr>
                                    <td>Fixed Grant :</td>
                                    <td> {{ number_format($cslg_calculation->fixed_grant) }}</td>
                                </tr>
                                <tr>
                                    <td>Gross CLSG Amount (KES)</td>
                                    <td>
                                        {{ number_format($cslg_calculation->gross_clsg) }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
{{--                @if(auth()->user()->hasRole('wsp'))--}}
{{--                <view-cslg-calculation--}}
{{--                    :cslg="{{$cslg}}"--}}
{{--                    :operations="{{$operations}}"--}}
{{--                ></view-cslg-calculation>--}}
{{--                @else--}}
{{--                    <approve-clg-calculation--}}
{{--                        :cslg="{{$cslg}}"--}}
{{--                        :operations="{{$operations}}"--}}
{{--                    ></approve-clg-calculation>--}}
{{--                @endif--}}

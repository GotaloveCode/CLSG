@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="card">
                <div class="card-header">{{ __('Expression Of Interest Form') }}</div>
                <div class="card-body">
                    <eoi-service-form :connections="{{ $connections }}" :services="{{ $services }}"
                                      :estimated-costs="{{ $estimatedCosts }}" eoi_id="{{ $eoi->id }}"
                                      submit-url="{{ route('eoi.services.update',$eoi->id) }}"></eoi-service-form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

{{--<hr>--}}
{{--<p class="col-md-12">A. Breakdown of short-term COVID-19 related emergency interventions and--}}
{{--    estimated costs:</p>--}}
{{--<table class="table">--}}
{{--    <thead>--}}
{{--    <tr>--}}
{{--        <th>Type of service / items</th>--}}
{{--        <th>Name of Low income area and number of facilities required</th>--}}
{{--        <th>Total No. required</th>--}}
{{--    </tr>--}}
{{--    @foreach($services as $service)--}}
{{--        <tr>--}}
{{--            <td>{{$service->name}}</td>--}}
{{--            <td><input type="text" class="form-control" name="areas_{{$service->id}}"></td>--}}
{{--            <td><input type="number" class="form-control" name="total_{{$service->id}}"></td>--}}
{{--        </tr>--}}
{{--    @endforeach--}}
{{--    </thead>--}}
{{--    <tr>--}}
{{--        <th colspan="3">People Served By</th>--}}
{{--    </tr>--}}
{{--    @foreach($connections as $connection)--}}
{{--        <tr>--}}
{{--            <td>{{$connection->name}}</td>--}}
{{--            <td><input type="text" class="form-control" name="aconnection->id}}"></td>--}}
{{--            <td><input type="number" class="form-control" name="total_{{$connection->id}}"></td>--}}
{{--        </tr>--}}
{{--    @endforeach--}}
{{--    <tr>--}}
{{--        <th>Estimated costs</th>--}}
{{--        <th>Unit Cost (KES) </th>--}}
{{--        <th>Total cost (KES) </th>--}}
{{--    </tr>--}}
{{--    @foreach($connections as $connection)--}}
{{--        <tr>--}}
{{--            <td>{{$connection->name}}</td>--}}
{{--            <td><input type="text" class="form-control" name="aconnection->id}}"></td>--}}
{{--            <td><input type="number" class="form-control" name="total_{{$connection->id}}"></td>--}}
{{--        </tr>--}}
{{--    @endforeach--}}
{{--</table>--}}

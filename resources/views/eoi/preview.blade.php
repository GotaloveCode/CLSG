@extends('layouts.app')

@section('content')
    <div class="container">
        <p>{{ now()->format('d/M/Y') }}</p>

        <p>
            The Chief Executive Officer<br>
            Water Sector Trust Fund<br>
            Mara Road<br>
            Nairobi
        </p>

        <p>Att: Ms./Mr. {{$eoi->program_manager}},</p>
        <p>This note is to request for funding under the Conditional Liquidity Support Grant (CLSG) in the amount
            indicated below: </p>

        <table class="table table-borderless">
            <tr>
                <td>Fixed grant:</td>
                <td><b>KES: </b>{{ number_format($eoi->fixed_grant)}}</td>
            </tr>
            <tr>
                <td>Estimated variable grant:</td>
                <td><b>KES: </b>{{ number_format($eoi->variable_grant)}}</td>
            </tr>
            <tr>
                <td><b>Total grant:</b></td>
                <td><b>KES: </b> {{ number_format($eoi->fixed_grant + $eoi->variable_grant)}}</td>
            </tr>
        </table>
        <p>The total CLSG funding amount requested will be used for the following purposes and in the amounts indicated
            in each line below:
        </p>
        <table class="table table-borderless">
            <tr>
                <td width="5%">1.</td>
                <td>Short-term COVID-19 emergency interventions</td>
                <td><b>KES: </b>{{ number_format($eoi->emergency_intervention_total)}}</td>
            </tr>
            <tr>
                <td width="5%">2.</td>
                <td>Operation & Maintenance Costs</td>
                <td><b>KES: </b>{{ number_format($eoi->operation_costs_total)}}</td>
            </tr>
        </table>
        <p>
            The total amount is intended to cover ...... percent of the cost of the approved short-term COVID-19
            emergency interventions, including the a) provision of tanker services, b) hand washing stations, c)
            speeding up connections, d) provision of free connections (where feasible) and e) installation of public
            standpoints. The remaining ...... percent, equivalent to an amount of KES {{ number_format($eoi->operation_costs_total) }} will be used to cover the
            Operation & Maintenance for service delivery.
        </p>
        <p>
            The implementation of the emergency interventions is expected to be completed in {{$eoi->months}} months
            from the date of signing a CLSG agreement between the WSTF and {{$eoi->wsp->name}}.
        </p>
        <p>The company serves low income areas as detailed in the table below. </p>
        <table class="table table-bordered">
            <tr>
                <th>Population served</th>
                <th>Name of Low income areas</th>
                <th>Total No of people served</th>
            </tr>
            <tr>
                <td>Water services</td>
                <td>{{ $eoi->water_service_areas }}</td>
                <td>{{ number_format($eoi->total_people_water_served) }}</td>
            </tr>
            <tr>
                <td>Proportion of low income population served</td>
                <td colspan="2">{{ number_format($eoi->proportion_served) }} %</td>
            </tr>
        </table>
        <p>A. Breakdown of short-term COVID-19 related emergency interventions and estimated costs:</p>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Type of service / items</th>
                <th>Name of Low income area and number of facilities required</th>
                <th>Total No. required</th>
            </tr>
            </thead>
            @foreach($eoi->services as $service)
                <tr>
                    <td>{{ $service->name }}</td>
                    <td>{{ $service->pivot->areas }}</td>
                    <td>{{ number_format($service->pivot->total) }}</td>
                </tr>
            @endforeach
            <tr>
                <th colspan="3">People served by</th>
            </tr>
            @foreach($eoi->connections as $connection)
                <tr>
                    <td>{{ $connection->name }}</td>
                    <td>{{ $connection->pivot->areas }}</td>
                    <td>{{ number_format($connection->pivot->total) }}</td>
                </tr>
            @endforeach
            <tr>
                <th>Estimated costs</th>
                <th>Unit Cost (KES)</th>
                <th>Total cost (KES)</th>
            </tr>
            @foreach($eoi->estimatedcosts as $cost)
                <tr>
                    <td>{{ $cost->name }}</td>
                    <td>{{ number_format($cost->pivot->unit) }}</td>
                    <td>{{ number_format($cost->pivot->total) }}</td>
                </tr>
            @endforeach
            <tr>
                <td><b>Total Costs</b></td>
                <td></td>
                <td><b>{{ number_format($eoi->estimatedcosts->sum('pivot.total')) }}</b></td>
            </tr>
        </table>
        <p>B. Breakdown of O&M estimated costs:</p>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>S/N</th>
                <th>Type of Service/item</th>
                <th>Qty</th>
                <th>Unit Rate in Kshs.</th>
                <th>Total Cost in Kshs.</th>
            </tr>
            </thead>
            @foreach($eoi->operationcosts as $cost)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $cost->name }}</td>
                    <td>{{ $cost->quantity }}</td>
                    <td>{{ number_format($cost->pivot->unit_rate) }}</td>
                    <td>{{ number_format($cost->pivot->total) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2"><b>Total Costs</b></td>
                <td></td>
                <td></td>
                <td><b>{{ number_format($eoi->operationcosts->sum('pivot.total')) }}</b></td>
            </tr>
        </table>
    </div>
@endsection





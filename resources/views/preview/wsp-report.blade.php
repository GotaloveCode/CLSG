<h4 class="text-center">WSP MONTHLY REPORTING</h4>
<br>
<p><b>Name of WSP:</b> {{$wsp_report->bcp->wsp->name}}</p>
<p><b>Reporting period
        (month):</b> {{\DateTime::createFromFormat("!m",$wsp_report->month)->format("F")}} {{ $wsp_report->year }}</p>
<p><b>Revenues collected this month (KES):</b> {{$wsp_report->revenue}}</p>
<p><b>Total CLSG amount disbursed to date (KES):</b> {{$wsp_report->clsg_total}}</p>

<h5><b>Status of resolution of issues (if any) raised in previous performance verification
        reports</b></h5>

<p><b>Response:</b>{{$wsp_report->status_of_resolution ==1 ? 'Yes.' : 'No.'}}</p>
@if($wsp_report->status_of_resolution_comment)
    <p><b>Comment:</b> {{$wsp_report->status_of_resolution_comment}}</p>
@endif
<br>
<h5>O&M costs this month (KES):</h5>
@php
    $oem_sum = 0;
@endphp
<table class="table">
    <thead>
    <tr>
        <th>Service</th>
        <th>Cost (KES)</th>
    </tr>
    </thead>
    <tbody>
    @foreach(json_decode($wsp_report->operations_costs) as $item)
        @php
            $oem_sum += $item->amount;
        @endphp
        <tr>
            <td>{{ $operationCosts->find($item->id)->name}}</td>
            <td>{{ number_format($item->amount) }}</td>
        </tr>
    @endforeach
    <tr>
        <td></td>
        <th>{{ number_format($oem_sum) }}</th>
    </tr>
    </tbody>
</table>
<h5><b>Challenges (if any) encountered during the reporting period and mitigation measures</b></h5>
<p><b>Response:</b>{{$wsp_report->challenges ==1 ? 'Yes.' : 'No.'}}</p>
@if($wsp_report->challenges_comment)
    <p><b>Comment:</b>{{$wsp_report->challenges_comment}}</p>
@endif
<h5>Expected activities for the next month (specifying any planned procurement or
    contracting)</h5>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Activity</th>
            <th>Description</th>
        </tr>
        </thead>
        <tbody>
        @foreach(json_decode($wsp_report->expected_activities) as $item)
            <tr>
                <td>{{ $services->find($item->activity)->name }}</td>
                <td>{{ $item->description }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<h5>Status of implementation of COVID-19 emergency interventions (both physical and financial progress)</h5>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Service</th>
            <th>Description</th>
            <th>Cost (KES)</th>
        </tr>
        </thead>
        <tbody>
        @php
            $covid_sum = 0;
        @endphp
        @foreach(json_decode($wsp_report->status_of_covid_implementation) as $item)
            <tr>
                <td>{{$services->find($item->service)->name}}</td>
                <td>{{$item->description}}</td>
                <td>{{ number_format($item->cost) }}</td>
            </tr>
            @php
                $covid_sum += $item->cost;
            @endphp
        @endforeach
        <tr>
            <td colspan="2"></td>
            <th>{{ number_format($covid_sum) }}</th>
        </tr>
        </tbody>
    </table>
</div>

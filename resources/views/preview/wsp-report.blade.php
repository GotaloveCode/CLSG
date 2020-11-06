<h4 class="text-center">WSP MONTHLY REPORTING</h4>
<br>
<p>Name of WSP: <b>{{$wsp_report->bcp->wsp->name}}</b></p>
<p>Reporting period (month): <b>{{\DateTime::createFromFormat("!m",$wsp_report->month)->format("F")}} {{ $wsp_report->year }}</b></p>
<p>Revenues collected this month (KES): <b>{{$wsp_report->revenue}}</b></p>
<p>Total CLSG amount disbursed to date (KES): <b>{{$wsp_report->clsg_total}}</b></p>

<h5>Status of resolution of issues (if any) raised in previous performance verification
    reports</h5>

<p>Response:<b>{{$wsp_report->status_of_resolution ==1 ? 'Yes.' : 'No.'}}</b></p>
@if($wsp_report->status_of_resolution_comment)
    <p>Comment:<b>{{$wsp_report->challenges_cooment}}</b></p>
@endif
<br>
<h5>O&M costs this month (KES):</h5>
<table class="table">
    <thead>
    <tr>
        <th>Service</th>
        <th>Description</th>
    </tr>
    </thead>
    <tbody>
    @foreach(json_decode($wsp_report->status_of_covid_implementation) as $item)
        <tr>
            <td>{{$services->find($item->service)->name}}</td>
            <td>{{$item->description}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<h5>Challenges (if any) encountered during the reporting period and mitigation measures</h5>
<p>Response:<b>{{$wsp_report->challenges ==1 ? 'Yes.' : 'No.'}}</b></p>
@if($wsp_report->challenges_cooment)
    <p>Comment:<b>{{$wsp_report->challenges_cooment}}</b></p>
@endif
<h5>Expected activities for the next month (specifying any planned procurement or
    contracting)</h5>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Service</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>
        @foreach(json_decode($wsp_report->operations_costs) as $item)
            <tr>
                <td>{{ $operationCosts->find($item->id)->name }}</td>
                <td>{{ number_format($item->amount) }}</td>
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
        </tr>
        </thead>
        <tbody>
        @foreach(json_decode($wsp_report->status_of_covid_implementation) as $item)
            <tr>
                <td>{{$services->find($item->service)->name}}</td>
                <td>{{$item->description}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

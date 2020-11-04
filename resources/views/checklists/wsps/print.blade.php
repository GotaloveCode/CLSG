@extends('layouts.print')
@section('content')
    <div class="card">
        <div class="card-header text-center"><h4>WSP MONTHLY REPORTING</h4></div>
    </div>
    <div class="card-body">
        <p>Name of WSP: <b>{{$wsp_report->bcp()->first()->wsp->name}}</b></p>
        <p>Reporting period (month): <b>{{\DateTime::createFromFormat("!m",$wsp_report->month)->format("F")}}</b></p>
        <p>Revenues collected this month (KES): <b>{{$wsp_report->revenue}}</b></p>
        <p>O&M costs this month (KES): <b>{{$wsp_report->operations_costs}}</b></p>
        <p>Total CLSG amount disbursed to date (KES): <b>{{$wsp_report->clsg_total}}</b></p>
    </div>
    <div>
        <div class="card-header">
            <h4>Status of resolution of issues (if any) raised in previous performance verification reports</h4>

        </div>
        <div class="card-body">
            <p>Response:<b>{{$wsp_report->status_of_resolution ==1 ? 'Yes.' : 'No.'}}</b></p>
            @if($wsp_report->status_of_resolution_comment)
                <p>Comment:<b>{{$wsp_report->challenges_cooment}}</b></p>
            @endif
        </div>
    </div>
    <div>
        <div class="card-header">
            <h4>Challenges (if any) encountered during the reporting period and mitigation measures</h4>

        </div>
        <div class="card-body">
            <p>Response:<b>{{$wsp_report->challenges ==1 ? 'Yes.' : 'No.'}}</b></p>
            @if($wsp_report->challenges_cooment)
                <p>Comment:<b>{{$wsp_report->challenges_cooment}}</b></p>
            @endif
        </div>
    </div>
    <div>
        <div class="card-header">
            <h4>Expected activities for the next month (specifying any planned procurement or contracting)</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Service</th>
                        <th>Description</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(json_decode($wsp_report->expected_activities) as $activity)
                        <tr>
                            <td>{{$activity->activity}}</td>
                            <td>{{$activity->description}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="div">
        <div class="card-header">
            <h4>Status of implementation of COVID-19 emergency interventions (both physical and financial progress)</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Service</th>
                        <th>Description</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(json_decode($wsp_report->status_of_covid_implementation) as $erp)
                        <tr>
                            <td>{{$erp->service}}</td>
                            <td>{{$erp->description}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@extends('layouts.print')
@section('content')
    <h4>PERFORMANCE SCORECARD</h4>
    <p><strong>Period : </strong> {{ getMonthName($score->month) }} {{ $score->year }}</p>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
            <tr>
                <th>Performance Scorecard</th>
                <th>Achievement</th>
                <th>Comments</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td width="50%">Business Continuity Plan (BCP) approved by the Board</td>
                <td>{{ $score->bcp_score }}%</td>
                <td></td>
            </tr>
            <tr>
                <td width="50%">COVID-19 Emergency Response Plan (ERP) for vulnerable consumers approved by the Board
                </td>
                <td>{{ $score->erp_score }}%</td>
                <td></td>
            </tr>
            <tr>
                <td>Monthly reporting on BCP and ERP activities</td>
                <td>{{ $score->bcp_erp_score }}%</td>
                <td></td>
            </tr>
            <tr>
                <td width="50%">Improved financial management of the CLSG. Personnel expenditures as a percentage of O&M
                    expenditures shall not vary by more than 5% of the amounts spent in the previous period
                </td>
                <td>{{ $score->financial_score }}%</td>
                <td></td>
            </tr>
            <tr>
                <td width="50%">Quarterly reporting on the performance of the CLSG (pass/fail)</td>
                <td>{{ $score->performance_score }}%</td>
                <td></td>
            </tr>
            <tr>
                <td width="50%">Regulatory compliance (pass/fail)</td>
                <td>{{ $score->compliance_score }}%</td>
                <td></td>
            </tr>
            <tr>
                <td width="50%">Maintain at least 50 percent collection efficiency</td>
                <td>{{ $score->collection_efficiency_score }}%</td>
                <td>{{$score->collection_efficiency_comment}}</td>
            </tr>
            <tr>
                <td width="50%">Maintain NRW at pre-COVID levels</td>
                <td>{{ $score->nrw_score }}%</td>
                <td>{{$score->nrw_comment}}</td>
            </tr>
            <tr>
                <td>Maintain at least 8 hours of service per day in urban areas</td>
                <td>{{ $score->service_per_day_score }}%</td>
                <td>{{$score->service_per_day_comment}}</td>
            </tr>
            <tr>
                <td width="50%">Maintain drinking water quality within acceptable range</td>
                <td>{{ $score->drinking_water_score }}%</td>
                <td>{{$score->drinking_water_comment}}</td>
            </tr>
            <tr>
                <td width="50%"><b>Total</b></td>
                <td>{{ ((int)$score->service_per_day_score+(int)$score->performance_score+(int)$score->nrw_score+(int)$score->financial_score+(int)$score->erp_score+
                (int)$score->drinking_water_score+(int)$score->compliance_score+(int)$score->collection_efficiency_score+(int)$score->bcp_score+(int)$score->bcp_erp_score) }}
                    %
                </td>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection

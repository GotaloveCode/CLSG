<div>
    <h4 class="text-center">BUSINESS CONTINUITY PLAN</h4>
    <p>{{ $eoi->date ? $eoi->date->format('d/m/Y') : now()->format('d/m/Y') }}</p>

    <p>A. <b>Executive Summary</b></p>
    <p>{{$bcp->executive_summary}}</p>

    <p>B. <b>Company Overview</b></p>
    <p>{{$bcp->company_overview}}</p>

    <p>C. <b>Financing</b></p>
    <p>{{$bcp->financing}}</p>

    <p>D. <b>Strategic Direction</b></p>
    <p>{{$bcp->strategic_direction}}</p>

    <p>E. <b>Environment Analysis</b></p>
    <p>{{$bcp->environment_analysis}}

    </p>F. <b>Rationale</b></p>
    <p>{{$bcp->rationale}}</p>

    <p>G. <b>Specific Objectives</b></p>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Description</th>

        </tr>
        </thead>
        @foreach($bcp->objectives as $obj)
            <tr>
                <td>{{ $obj->description }}</td>

            </tr>
        @endforeach
    </table>
    <p>H. <b>Breakdown of O&M costs:</b></p>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Type of Service/item</th>
            <th>Qty</th>
            <th>Unit Cost (KES)</th>
            <th>Total Cost (KES)</th>
        </tr>
        </thead>
        @foreach($bcp->operationcosts as $cost)
            <tr>
                <td>{{ $cost->name }}</td>
                <td>{{ $cost->pivot->quantity }}</td>
                <td>{{ number_format($cost->pivot->unit_rate) }}</td>
                <td>{{ number_format($cost->pivot->total) }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="1"><b>Total Costs</b></td>
            <td></td>
            <td></td>
            <td><b>{{ number_format($bcp->operationcosts->sum('pivot.total')) }}</b></td>
        </tr>
    </table>
    <p>I. <b>Revenue Projections:</b></p>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Month</th>
            <th>Year</th>
            <th>Amount (KES)</th>
        </tr>
        </thead>
        @foreach($bcp->revenue_projections as $rev)
            <tr>
                <td>{{ $rev->month }}</td>
                <td>{{ $rev->year }}</td>
                <td>{{ number_format($rev->amount) }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="1"><b>Total Costs</b></td>
            <td></td>
            <td><b>{{ number_format($bcp->revenue_projections->sum('amount')) }}</b></td>
        </tr>
    </table>
</div>

<div>
    <h4 class="text-center">BUSINESS CONTINUITY PLAN</h4>
    <p>{{ $bcp->date ? $bcp->date->format('d/m/Y') : now()->format('d/m/Y') }}</p>

    <h5>1. Executive Summary</h5>
    <p>{{$bcp->executive_summary}}</p>

    <h5>2.Introduction </h5>
    <p>{{$bcp->introduction}}</p>

    <h5>3. Planning Assumptions</h5>
    <p>{{$bcp->planning_assumptions}}</p>

    <h5>4. BCP Team</h5>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Name</th>
            <th>Unit</th>
            <th>Role</th>
        </tr>
        </thead>
        @foreach($bcp->bcpteams as $member)
            <tr>
                <td>{{ $member->name }}</td>
                <td>{{ $member->unit }}</td>
                <td>{{ $member->role }}</td>
            </tr>
        @endforeach
    </table>
    <h5>5. Essential Operations</h5>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Priority</th>
            <th>Essential Function</th>
            <th>Primary</th>
            <th>Back Up</th>
        </tr>
        </thead>
        @foreach($bcp->essentialOperations as $op)
            <tr>
                <td>{{ $op->priority_level }}</td>
                <td>{{ $op->essentialfunction->name }}</td>
                <td>{{ $op->primaryStaff->firstname }} {{ $op->primaryStaff->lastname }}</td>
                <td>{{ $op->backupStaff->firstname }} {{ $op->backupStaff->lastname }}</td>
            </tr>
        @endforeach
    </table>

    <h5>6. COVID-19 Emergency Response Plan for Vulnerable Customers</h5>
    <p>{{$bcp->emergency_response_plan}}</p>

    <h5>7. Staff Health Protection </h5>
    <p>{{$bcp->staff_health_protection}}</p>

    <h5>8. Supply Chains for Essential Products and Services</h5>
    <p>{{$bcp->supply_chain}}</p>
    <h5>9. Communication Plan</h5>
    <p>{{$bcp->communication_plan}}</p>

    <h5>10. Annexes </h5>
    <h6>Revenue Projections:</h6>
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
    @if($bcp->government_subsidy==1)
    <h6>Government Subsidy</h6>
    <p>KES {{ number_format($bcp->government_subsidy_amount) }}</p>
    @endif
</div>


<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" navigation-header"><span>General</span><i class="feather icon-minus" data-toggle="tooltip"
                                                                  data-placement="right"
                                                                  data-original-title="General"></i>
            </li>
            <li class=" nav-item">
                <a href="{{ route('home') }}">
                    <i class="feather icon-home"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item"><a href="#"><i class="feather icon-edit"></i><span class="menu-title">EOI</span></a>
                <ul class="menu-content">
                    @isset($eoi)
                        @can('view_eoi')
                            <li><a class="menu-item" href="{{ route('eois.show',$eoi->id) }}">View EOI</a>
                            </li>
                        @endcan
                    @else
                        @can('create_eoi')
                            <li><a class="menu-item" href="{{ route('eois.create') }}">Create EOI</a>
                            </li>
                        @endcan
                    @endisset
                    @can('list_eoi')
                        <li><a class="menu-item" href="{{ route('eois.index') }}">EOI List</a>
                        </li>
                    @endcan
                </ul>
            </li>
            <li class="nav-item"><a href="#"><i class="feather icon-briefcase"></i><span
                        class="menu-title">BCP</span></a>
                <ul class="menu-content">
                    @isset($bcp)
                        @can('view_bcp')
                            <li><a class="menu-item" href="{{ route('bcps.show',$bcp->id) }}">View BCP</a>
                            </li>
                        @endcan
                    @else
                        @can('create_bcp')
                            <li><a class="menu-item" href="{{ route('bcps.create') }}">Create BCP</a>
                            </li>
                        @endcan
                    @endisset
                    @can('list_bcp')
                        <li><a class="menu-item" href="{{ route('bcps.index') }}">BCP List</a>
                        </li>
                    @endcan
                </ul>
            </li>
            <li class="nav-item"><a href="#"><i class="feather icon-life-buoy"></i><span class="menu-title">ERPs</span></a>
                <ul class="menu-content">
                    @can('create_erp')
                        @isset($erp)
                            @can('view_erp')
                                <li><a class="menu-item" href="{{ route('erps.show',$erp->id) }}">View ERP</a>
                                </li>
                            @endcan
                        @else
                            @can('create_erp')
                                <li><a class="menu-item" href="{{ route('erps.create') }}">Create ERP</a>
                                </li>
                            @endcan
                        @endif
                    @endcan
                    @can('list_erp')
                        <li><a class="menu-item" href="{{ route('erps.index') }}">ERP List</a>
                        </li>
                    @endcan
                </ul>
            </li>
            <li class="nav-item">
                <a href="#"><i class="feather icon-award"></i><span class="menu-title">CLSG</span></a>
                <ul class="menu-content">
                    <li>
                        <a class="menu-item" href="{{ route('clsg.formula') }}">
                            CLSG Formula
                        </a>
                    </li>
                    @can('list_erp')
                        <li><a class="menu-item" href="{{ route('clsg.index') }}">CLSG List</a>
                        </li>
                    @else
                        @isset($wsp)
                            <li><a class="menu-item" href="{{ route('clsg.show',$wsp->id) }}">View CLSG</a>
                            </li>
                        @endisset
                    @endcan
                </ul>
            </li>
            <li class=" nav-item"><a href="#"><i class="feather icon-users"></i><span
                        class="menu-title">Staff</span></a>
                <ul class="menu-content">
                    @can('create_staff')
                        <li><a class="menu-item" href="{{ route('staff.create') }}">Create Staff</a>
                        </li>
                    @endcan
                    <li><a class="menu-item" href="{{ route('staff.index') }}">Staff List</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item"><a href="#"><i class="feather icon-user"></i><span
                        class="menu-title">User Management</span></a>
                <ul class="menu-content">
                    @can('view_users')
                        <li><a class="menu-item" href="{{ route('users.index') }}">Users List</a>
                        </li>
                    @endcan
                    @can('delete_users')
                        <li><a class="menu-item" href="{{ route('users.trashed') }}">Deleted Users</a>
                        </li>
                    @endcan
                    @can('view-roles')
                        <li><a class="menu-item" href="{{ route('roles.index') }}">Roles</a>
                        </li>
                    @endcan
                </ul>
            </li>
            @can('review_bcp')
                <li class=" nav-item"><a href="#"><i class="feather icon-bar-chart"></i><span
                            class="menu-title">Reports</span></a>
                    <ul class="menu-content">
                        <li><a class="menu-item" href="{{ route('wsp-reporting.index') }}">Monthly WSP</a>
                        </li>
                        <li><a class="menu-item" href="{{ route('essential-operation.index') }}">Essential
                                Operations</a>
                        </li>
                        <li><a class="menu-item" data-title="Vulnerable Customers"
                               href="{{ route('vulnerable-customer.index')}}">Vulnerable Customers</a>
                        </li>
                        <li><a class="menu-item" data-title="Staff & Health Protection"
                               href="{{ route('staff-health.index')}}">Staff & Health Protection</a>
                        </li>
                        <li><a class="menu-item" href="{{ route('performance-score-card.index')}}">Performance
                                Scorecard</a>
                        </li>
                        <li><a class="menu-item" data-title="CSLG CALCULATION"
                               href="{{ route('cslg-calculation.index')}}">CSLG
                                Calculation</a>
                        </li>
                    </ul>
                </li>
            @else
                @isset($bcp)
                    @if($bcp->status == 'WSTF Approved'))
                    <li class=" nav-item"><a href="#"><i class="feather icon-bar-chart"></i><span
                                class="menu-title">Reports</span></a>
                        <ul class="menu-content">
                            <li><a class="menu-item" href="{{ route('wsp-reporting.index') }}">Monthly WSP</a>
                            </li>
                            <li><a class="menu-item" href="{{ route('essential-operation.index') }}">Essential
                                    Operations</a>
                            </li>
                            <li><a class="menu-item" data-title="Vulnerable Customers"
                                   href="{{ route('vulnerable-customer.index')}}">Vulnerable Customers</a>
                            </li>
                            <li><a class="menu-item" data-title="Staff & Health Protection"
                                   href="{{ route('staff-health.index')}}">Staff & Health Protection</a>
                            </li>
                            <li><a class="menu-item" href="{{ route('performance-score-card.index')}}">Performance
                                    Scorecard</a>
                            </li>
                            <li><a class="menu-item" data-title="CSLG CALCULATION"
                                   href="{{ route('cslg-calculation.index')}}">CSLG
                                    Calculation</a>
                            </li>
                        </ul>
                    </li>
                    @endif
                @endisset
            @endcan
            @can('create_wsps')
                <li class=" nav-item"><a href="#"><i class="feather icon-compass"></i><span
                            class="menu-title">Wsps</span></a>
                    <ul class="menu-content">
                        <li><a class="menu-item" href="{{ route('wsps.export') }}">Import Wsps</a>
                        </li>
                    </ul>
                </li>
            @endcan
        </ul>
    </div>
</div>
<!-- END: Main Menu-->

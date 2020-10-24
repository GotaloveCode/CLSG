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
            <li class="nav-item"><a href="#"><i class="feather icon-edit"></i><span class="menu-title">EOIs</span></a>
                <ul class="menu-content">
                    @can('create-eoi')
                        @if($eoi)
                            <li><a class="menu-item" href="{{ route('eois.show',$eoi->id) }}">View EOI</a>
                            </li>
                        @else
                            <li><a class="menu-item" href="{{ route('eois.create') }}">Create EOI</a>
                            </li>
                        @endif
                    @endcan
                    @can('list-eoi')
                        <li><a class="menu-item" href="{{ route('eois.index') }}">EOI List</a>
                        </li>
                    @endcan
                </ul>
            </li>
            <li class="nav-item"><a href="#"><i class="feather icon-briefcase"></i><span class="menu-title">BCPs</span></a>
                <ul class="menu-content">
                    @can('create-bcp')
                        @if($bcp)
                            <li><a class="menu-item" href="{{ route('bcps.show',$bcp->id) }}">View BCP</a>
                            </li>
                        @else
                            <li><a class="menu-item" href="{{ route('bcps.create') }}">Create BCP</a>
                            </li>
                        @endif
                    @endcan
                    @can('list-bcp')
                        <li><a class="menu-item" href="{{ route('bcps.index') }}">BCP List</a>
                        </li>
                    @endcan
                </ul>
            </li>
            <li class="nav-item"><a href="#"><i class="feather icon-life-buoy"></i><span class="menu-title">ERPs</span></a>
                <ul class="menu-content">
                    @can('create-erp')
                        @if($erp)
                            <li><a class="menu-item" href="{{ route('erps.show',$erp->id) }}">View ERP</a>
                            </li>
                        @else
                            <li><a class="menu-item" href="{{ route('erps.create') }}">Create ERP</a>
                            </li>
                        @endif
                    @endcan
                    @can('list-erp')
                        <li><a class="menu-item" href="{{ route('erps.index') }}">ERP List</a>
                        </li>
                    @endcan
                </ul>
            </li>
            <li class=" nav-item"><a href="#"><i class="feather icon-users"></i><span
                        class="menu-title">Staff</span></a>
                <ul class="menu-content">
                    @can('create-staff')
                        <li><a class="menu-item" href="{{ route('staff.create') }}">Create Staff</a>
                        </li>
                    @endcan
                    <li><a class="menu-item" href="{{ route('staff.index') }}">Staff List</a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item"><a href="#"><i class="feather icon-user"></i><span class="menu-title">Users</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="{{ route('users.index') }}">Users List</a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item"><a href="#"><i class="feather icon-bar-chart"></i><span
                        class="menu-title">Reports</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="{{ url('/reports/monthly-revenue') }}">BCP Monthly Reporting</a>
                    </li>
                </ul>
            </li>
            @can('create-wsps')
                <li class=" nav-item"><a href="#"><i class="feather icon-compass"></i><span class="menu-title">Wsps</span></a>
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

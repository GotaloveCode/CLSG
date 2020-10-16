<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" navigation-header"><span>General</span><i class=" feather icon-minus" data-toggle="tooltip" data-placement="right" data-original-title="General"></i>
            </li>
            <li class=" nav-item"><a href="index.html"><i class="feather icon-home"></i><span class="menu-title" data-i18n="Dashboard">Dashboard</span><span class="badge badge badge-primary badge-pill float-right mr-2">3</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="dashboard-ecommerce.html" data-i18n="eCommerce">eCommerce</a>
                    </li>
                </ul>
            </li>

            <li class=" nav-item"><a href="#"><i class="feather icon-user"></i><span class="menu-title" data-i18n="Users">Users</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="{{ route('users.index') }}" data-i18n="Users List">Users List</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<!-- END: Main Menu-->

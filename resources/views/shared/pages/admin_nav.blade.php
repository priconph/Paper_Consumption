<input type="hidden" id="userLevel" value="{{ $_SESSION['user_level'] }}">

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-danger elevation-4">
    <!-- Brand Logo -->
    <a id="toManagement" href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('public/images/pcms.png') }}" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        {{-- <i class="brand-image elevation-3 mt-2 fas fa-book-reader"></i> --}}
        <span class="brand-text font-weight-light" style="font-size: 14px;">Paper Consumption Monitoring<br>
        </span>
    </a>

    <a id="toSummary" href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('public/images/pcms.png') }}" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        {{-- <i class="brand-image elevation-3 mt-2 fas fa-book-reader"></i> --}}
        <span class="brand-text font-weight-light" style="font-size: 14px;">Paper Consumption Monitoring<br>

        </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">ADMINISTRATOR - @auth
                        {{ Auth::user()->department->name }}
                    @endauth</li>
                <li class="nav-item has-treeview">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li id="managementRoute" class="nav-item has-treeview">
                    <a href="{{ route('management') }}" class="nav-link">
                        <i class="nav-icon fa fa-users"></i>
                        <p>Management</p>
                    </a>
                </li>

                {{-- NEW CODE CLARK 02/03/2025 --}}
                @auth
                    @if(Auth::user()->department_id == 8) {{-- FOR ISS ACCESS ONLY --}}
                        <li id="activeMonthConfigRoute" class="nav-item has-treeview">
                            <a href="{{ route('data_settings') }}" class="nav-link">
                                <i class="nav-icon fas fa-sliders-h"></i>
                                <p>Data Settings</p>
                            </a>
                        </li>
                    @endif
                @endauth

                <li class="nav-header"> PAPER CONSUMPTION - @auth
                        {{ Auth::user()->department->name }}
                    @endauth</li>
                <li id="paperConsumptionRoute" class="item has-treeview">


                    <ul class="menu-content list-unstyled">
                        <li class="nav-item has-treeview" id="paperConsumptionRoutesId">

                            <a href="{{ route('paper_consumption_report') }}" aria-controls="monthly-target"
                                aria-selected="true" class="nav-link" id="aRoutesId">&nbsp;
                                <i class="nav-icon fa fa-clipboard-list"></i>&nbsp;&nbsp;&nbsp;
                                <p>Overview</p>
                            </a>
                        </li>
                        {{-- <li class="nav-item has-treeview" id="paperConsumptionRoutesId">
                    <a href="{{ route('total_paper_purchases') }}" class="nav-link" id="aRoutesId">
                        <p>Total Paper Purchases</p>
                    </a>
                </li>
                <li class="nav-item has-treeview" id="paperConsumptionRoutesId">
                    <a href="" class="nav-link" id="aRoutesId">
                        <p>Beginning Balance / BOH</p>
                    </a>
                </li>
                <li class="nav-item has-treeview" id="paperConsumptionRoutesId">
                    <a href="" class="nav-link" id="aRoutesId">
                        <p>Month Ending Balance / EOH</p>
                    </a>
                </li>
                <li class="nav-item has-treeview" id="paperConsumptionRoutesId">
                    <a href="" class="nav-link" id="aRoutesId">
                        <p>Total Used Paper</p>
                    </a>
                </li>
                <li class="nav-item has-treeview" id="paperConsumptionRoutesId">
                    <a href="" class="nav-link" id="aRoutesId">
                        <p style="font-size: 13px;">Reason of (+/-) of Actual Consumption</p>
                    </a>
                </li> --}}
                        <li class="nav-item has-treeview" id="paperConsumptionRoutesId">
                            <a href="{{ route('paper_consumption_report_monthly') }}" class="nav-link"
                                id="aRoutesId">&nbsp;
                                <i class="fas fa-file-export"></i>&nbsp;
                                <p>Used Papers</p>
                            </a>
                        </li>
                    </ul>

                    <hr>
                </li>

                <li id="paperConsumptionRoute" class="nav-item has-treeview">
                    <a href="{{ route('summary') }}" class="nav-link">
                        <i class="nav-icon fas fa-eye"></i>
                        <p>Summary</p>
                    </a>
                    {{-- <div class="collapse" id="summaryRoutesId">
                        <ul class="menu-content list-unstyled">
                            <li class="nav-item has-treeview" id="paperConsumptionRoutesId">
                                <a href="{{ route('summary') }}" class="nav-link" id="aRoutesId">
                                    <p>FY Target</p>
                                </a>
                            </li>
                            <li class="nav-item has-treeview" id="paperConsumptionRoutesId">
                                <a href="#" class="nav-link" id="aRoutesId">
                                    <p>Monthly Target</p>
                                </a>
                            </li>
                            <li class="nav-item has-treeview" id="paperConsumptionRoutesId">
                                <a href="#" class="nav-link" id="aRoutesId">
                                    <p>Actual Consumption</p>
                                </a>
                            </li>
                            <li class="nav-item has-treeview" id="paperConsumptionRoutesId">
                                <a href="#" class="nav-link" id="aRoutesId">
                                    <p>Target (-) Actual</p>
                                </a>
                            </li>
                            <li class="nav-item has-treeview" id="paperConsumptionRoutesId">
                                <a href="#" class="nav-link" id="aRoutesId">
                                    <p>Quarterly</p>
                                </a>
                            </li>
                            <li class="nav-item has-treeview" id="paperConsumptionRoutesId">
                                <a href="#" class="nav-link" id="aRoutesId">
                                    <p>Deduction Policy</p>
                                </a>
                            </li>
                        </ul>
                    </div> --}}
                </li>
            </ul>
            <hr>
        </nav>
    </div>
</aside>

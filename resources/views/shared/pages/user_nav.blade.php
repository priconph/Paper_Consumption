<input type="hidden" id="userLevel" value="{{ $_SESSION['user_level'] }}">

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-danger elevation-4">
    <a id="toPaperConsumptionReport" href="{{ route('paper_consumption_report') }}" class="brand-link">
        <img src="{{ asset('public/images/pcms.png') }}" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light" style="font-size: 14px;">Paper Consumption Monitoring<br>
        </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">

                    <h6>
                        User - @auth
                            {{ Auth::user()->department->name }}
                        @endauth
                    </h6>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{ route('user_dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>

                </li>
                <li class="nav-header"> PAPER CONSUMPTION - @auth
                        {{ Auth::user()->department->name }}
                    @endauth</li>
                <li id="paperConsumptionRoute" class="item has-treeview">

                    {{-- <li id="paperConsumptionRoute" class="nav-item has-treeview">
                    <a href="#routesId" class="nav-link" data-toggle="collapse" aria-expanded="false"
                        aria-controls="routesId">
                        <i class="nav-icon fa fa-file"></i>
                        <p>Paper Consumption</p>
                    </a>
                    <div class="collapse" id="routesId">
                        <ul class="menu-content list-unstyled">
                            <li class="nav-item has-treeview" id="paperConsumptionRoutesId">
                                <a href="{{ route('paper_consumption_report') }}" class="nav-link"
                                    id="aRoutesId">
                                    <p>Overview</p>
                                </a>
                            </li>
                            <li class="nav-item has-treeview" id="paperConsumptionRoutesId">
                                <a href="{{ route('paper_consumption_report_monthly') }}" class="nav-link"
                                    id="aRoutesId">
                                    <p>Monthly Used Papers</p>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <hr>
                </li> --}}


                    <ul class="menu-content list-unstyled">
                        <li class="nav-item has-treeview" id="paperConsumptionRoutesId">
                            <a href="{{ route('paper_consumption_report') }}" aria-controls="monthly-target"
                                aria-selected="true" class="nav-link" id="aRoutesId">&nbsp;
                                <i class="nav-icon fa fa-clipboard-list"></i>&nbsp;&nbsp;&nbsp;
                                <p>Overview</p>
                            </a>
                        </li>

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

                {{-- <li id="paperConsumptionRoute" class="nav-item has-treeview">
                    <a href="{{ route('summary') }}" class="nav-link">
                        <i class="nav-icon fa fa-clipboard-list"></i>
                        <p>Summary</p>
                    </a>
                </li> --}}
            </ul>
            {{-- <hr> --}}

            {{-- <li class="nav-item has-treeview">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>Summary</p>
                    </a>
                </li> --}}

            {{-- <li class="nav-item has-treeview"> --}}
            {{-- <button data-toggle="modal" data-target="#modalFiscalYear" id="setFiscalYearbtn" class="nav-link btn" style="background-color: inherit; border: 0; color: lightgray;">
                        <i class="nav-icon fa fa-calendar"></i>
                        <p>Set Fiscal Year</p>
                    </button> --}}
            {{-- </li> --}}
        </nav>
    </div>
</aside>

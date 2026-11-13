@php $layout = 'layouts.user_layout'; @endphp
@auth
    @php

    if (Auth::user()->user_level_id == 2 || Auth::user()->user_level_id == 1) {
        $layout = 'layouts.admin_layout';
    }
    @endphp
@endauth

@auth
    @extends($layout)

    @section('content_page')
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <h2 class="mt-1"><span>{{ Auth::user()->department->name }}</span> Paper Consumption -
                        FY&nbsp;<span class="currentFY"></span></h2>
                    <br>
                    <div class="row">
                        {{-- DEPARTMENTS CARD --}}
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h4>Total Consumption</h4>
                                    <h3><span class="deptConsumption"></span> <sup style="font-size: 20px">PCS</sup>
                                        <span>/</span> <span class="deptConsumptionReams"></span> <sup
                                            style="font-size: 20px">REAM</sup>
                                    </h3>
                                    <span> {{ Auth::user()->department->name }}</span>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h4>Total Target</h4>
                                    <h3><span class="deptTarget"></span> <sup style="font-size: 20px">PCS</sup>
                                        <span>/</span> <span class="deptTargetReams"></span> <sup
                                            style="font-size: 20px">REAM</sup>
                                    </h3>
                                    <span> {{ Auth::user()->department->name }}</span>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    @endsection

    <!--     {{-- JS CONTENT --}} -->
    @section('js_content')
        <script type="text/javascript">
            $(document).ready(function() {
                //============================== GET TOTAL CONSUMPTION SUMMARY OF LOGGED DEPT FOR DASHBOARD ============================
                function currentFY() {
                    $.ajax({
                        url: "get_current_fy",
                        method: "get",
                        dataType: "json",
                        success: function(response) {
                            $('.currentFY').text(response['result']);

                            // console.log(response['totalWorkloads']);
                        }
                    });
                }
                currentFY();


                //============================== GET TOTAL TARGET OF LOGGED DEPT FOR DASHBOARD ==============================
                function deptTarget() {
                    $.ajax({
                        url: "get_dept_target",
                        method: "get",
                        dataType: "json",
                        success: function(response) {
                            $('.deptTarget').text(response['result']);
                            let current_target_pieces = Number(response['result']);
                            let current_target_reams = current_target_pieces / 500;

                            let current_target_reams_final = current_target_reams.toFixed(2);

                            $('.deptTargetReams').html(current_target_reams_final);
                        }
                    });
                }
                deptTarget();

                //============================== GET TOTAL CONSUMPTION OF BOD FOR DASHBOARD ==============================
                function deptConsumption() {
                    $.ajax({
                        url: "get_dept_consumption",
                        method: "get",
                        dataType: "json",
                        success: function(response) {
                            $('.deptConsumption').text(response['result']);
                            let current_consumption_pieces = Number(response['result']);
                            let current_consumption_reams = current_consumption_pieces / 500;

                            let current_consumption_reams_final = current_consumption_reams.toFixed(2);

                            $('.deptConsumptionReams').html(current_consumption_reams_final);
                        }
                    });
                }
                deptConsumption();

                //============================== SIGN OUT ==============================
                $(document).ready(function() {
                    $("#formSignOut").submit(function(event) {
                        event.preventDefault();
                        SignOut();
                    });
                });
            });
        </script>
    @endsection
@endauth

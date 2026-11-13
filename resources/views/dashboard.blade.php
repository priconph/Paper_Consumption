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
    <style>
        ::-webkit-scrollbar {
            display: none !important;
        }

    </style>
    @section('content_page')
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <h2 class="mt-1">Support Group Paper Consumption - FY&nbsp;<span class="currentFY"></span></h2>
                    <hr>
                    <h4>Total Consumption</h4>
                    <br>
                    <div class="row">
                        {{-- DEPARTMENTS CARD --}}
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3><span class="bodConsumption"></span> <sup style="font-size: 20px">PCS</sup>
                                        <span>/</span> <span class="bodConsumptionReams"></span> <sup
                                            style="font-size: 20px">REAM</sup>
                                    </h3>
                                    <p>BOD</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-3 col-6 ">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3><span class="iasConsumption"></span> <sup style="font-size: 20px">PCS</sup>
                                        <span>/</span> <span class="iasConsumptionReams"></span> <sup
                                            style="font-size: 20px">REAM</sup>
                                    </h3>
                                    <p>IAS</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6 ">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3><span class="finConsumption"></span> <sup style="font-size: 20px">PCS</sup>
                                        <span>/</span> <span class="finConsumptionReams"></span> <sup
                                            style="font-size: 20px">REAM</sup>
                                    </h3>
                                    <p>FIN</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6 ">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3><span class="hrdConsumption"></span> <sup style="font-size: 20px">PCS</sup>
                                        <span>/</span> <span class="hrdConsumptionReams"></span> <sup
                                            style="font-size: 20px">REAM</sup>
                                    </h3>
                                    <p>HRD</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6 ">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3><span class="essConsumption"></span> <sup style="font-size: 20px">PCS</sup>
                                        <span>/</span> <span class="essConsumptionReams"></span> <sup
                                            style="font-size: 20px">REAM</sup>
                                    </h3>
                                    <p>ESS</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6 ">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3><span class="logConsumption"></span> <sup style="font-size: 20px">PCS</sup>
                                        <span>/</span> <span class="logConsumptionReams"></span> <sup
                                            style="font-size: 20px">REAM</sup>
                                    </h3>
                                    <p>LOG</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6 ">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3><span class="facConsumption"></span> <sup style="font-size: 20px">PCS</sup>
                                        <span>/</span> <span class="facConsumptionReams"></span> <sup
                                            style="font-size: 20px">REAM</sup>
                                    </h3>
                                    <p>FAC</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-3 col-6 ">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3><span class="issConsumption"></span> <sup style="font-size: 20px">PCS</sup>
                                        <span>/</span> <span class="issConsumptionReams"></span> <sup
                                            style="font-size: 20px">REAM</sup>
                                    </h3>
                                    <p>ISS</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6 ">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3><span class="qadConsumption"></span> <sup style="font-size: 20px">PCS</sup>
                                        <span>/</span> <span class="qadConsumptionReams"></span> <sup
                                            style="font-size: 20px">REAM</sup>
                                    </h3>
                                    <p>QAD</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6 ">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3><span class="emsConsumption"></span> <sup style="font-size: 20px">PCS</sup>
                                        <span>/</span> <span class="emsConsumptionReams"></span> <sup
                                            style="font-size: 20px">REAM</sup>
                                    </h3>
                                    <p>EMS</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
            </section>
        </div>
    @endsection

    <!--     {{-- JS CONTENT --}} -->
    @section('js_content')
        <script type="text/javascript">
            $(document).ready(function() {
                //============================== GET TOTAL CONSUMPTION SUMMARY FOR DASHBOARD ==============================
                function currentFY() {
                    $.ajax({
                        url: "get_current_fy",
                        method: "get",
                        dataType: "json",
                        success: function(response) {
                            $('.currentFY').text(response['result']);
                        }
                    });
                }
                currentFY();


                //============================== GET TOTAL CONSUMPTION OF BOD FOR DASHBOARD ==============================
                function bodConsumption() {
                    $.ajax({
                        url: "get_bod_consumption",
                        method: "get",
                        dataType: "json",
                        success: function(response) {
                            $('.bodConsumption').text(response['result']);
                            let current_consumption_pieces = Number(response['result']);
                            let current_consumption_reams = current_consumption_pieces / 500;

                            let current_consumption_reams_final = current_consumption_reams.toFixed(2);

                            $('.bodConsumptionReams').html(current_consumption_reams_final);
                        }
                    });
                }
                bodConsumption();

                //============================== GET TOTAL CONSUMPTION OF IAS FOR DASHBOARD ==============================
                function iasConsumption() {
                    $.ajax({
                        url: "get_ias_consumption",
                        method: "get",
                        dataType: "json",
                        success: function(response) {
                            $('.iasConsumption').text(response['result']);
                            let current_consumption_pieces = Number(response['result']);
                            let current_consumption_reams = current_consumption_pieces / 500;

                            let current_consumption_reams_final = current_consumption_reams.toFixed(2);

                            $('.iasConsumptionReams').html(current_consumption_reams_final);
                        }
                    });
                }
                iasConsumption();

                //============================== GET TOTAL CONSUMPTION OF FIN FOR DASHBOARD ==============================
                function finConsumption() {
                    $.ajax({
                        url: "get_fin_consumption",
                        method: "get",
                        dataType: "json",
                        success: function(response) {
                            $('.finConsumption').text(response['result']);
                            let current_consumption_pieces = Number(response['result']);
                            let current_consumption_reams = current_consumption_pieces / 500;

                            let current_consumption_reams_final = current_consumption_reams.toFixed(2);

                            $('.finConsumptionReams').html(current_consumption_reams_final);
                        }
                    });
                }
                finConsumption();

                //============================== GET TOTAL CONSUMPTION OF HRD FOR DASHBOARD ==============================
                function hrdConsumption() {
                    $.ajax({
                        url: "get_hrd_consumption",
                        method: "get",
                        dataType: "json",
                        success: function(response) {
                            $('.hrdConsumption').text(response['result']);
                            let current_consumption_pieces = Number(response['result']);
                            let current_consumption_reams = current_consumption_pieces / 500;

                            let current_consumption_reams_final = current_consumption_reams.toFixed(2);

                            $('.hrdConsumptionReams').html(current_consumption_reams_final);
                        }
                    });
                }
                hrdConsumption();

                //============================== GET TOTAL CONSUMPTION OF ESS FOR DASHBOARD ==============================
                function essConsumption() {
                    $.ajax({
                        url: "get_ess_consumption",
                        method: "get",
                        dataType: "json",
                        success: function(response) {
                            $('.essConsumption').text(response['result']);
                            let current_consumption_pieces = Number(response['result']);
                            let current_consumption_reams = current_consumption_pieces / 500;

                            let current_consumption_reams_final = current_consumption_reams.toFixed(2);

                            $('.essConsumptionReams').html(current_consumption_reams_final);
                        }
                    });
                }
                essConsumption();

                //============================== GET TOTAL CONSUMPTION OF LOG FOR DASHBOARD ==============================
                function logConsumption() {
                    $.ajax({
                        url: "get_log_consumption",
                        method: "get",
                        dataType: "json",
                        success: function(response) {
                            $('.logConsumption').text(response['result']);
                            let current_consumption_pieces = Number(response['result']);
                            let current_consumption_reams = current_consumption_pieces / 500;

                            let current_consumption_reams_final = current_consumption_reams.toFixed(2);

                            $('.logConsumptionReams').html(current_consumption_reams_final);
                        }
                    });
                }
                logConsumption();

                //============================== GET TOTAL CONSUMPTION OF FAC FOR DASHBOARD ==============================
                function facConsumption() {
                    $.ajax({
                        url: "get_fac_consumption",
                        method: "get",
                        dataType: "json",
                        success: function(response) {
                            $('.facConsumption').text(response['result']);
                            let current_consumption_pieces = Number(response['result']);
                            let current_consumption_reams = current_consumption_pieces / 500;

                            let current_consumption_reams_final = current_consumption_reams.toFixed(2);

                            $('.facConsumptionReams').html(current_consumption_reams_final);
                        }
                    });
                }
                facConsumption();

                //============================== GET TOTAL CONSUMPTION OF ISS FOR DASHBOARD ==============================
                function issConsumption() {
                    $.ajax({
                        url: "get_iss_consumption",
                        method: "get",
                        dataType: "json",
                        success: function(response) {
                            $('.issConsumption').text(response['result']);
                            let current_consumption_pieces = Number(response['result']);
                            let current_consumption_reams = current_consumption_pieces / 500;

                            let current_consumption_reams_final = current_consumption_reams.toFixed(2);

                            $('.issConsumptionReams').html(current_consumption_reams_final);
                        }
                    });
                }
                issConsumption();

                //============================== GET TOTAL CONSUMPTION OF QAD FOR DASHBOARD ==============================
                function qadConsumption() {
                    $.ajax({
                        url: "get_qad_consumption",
                        method: "get",
                        dataType: "json",
                        success: function(response) {
                            $('.qadConsumption').text(response['result']);
                            let current_consumption_pieces = Number(response['result']);
                            let current_consumption_reams = current_consumption_pieces / 500;

                            let current_consumption_reams_final = current_consumption_reams.toFixed(2);

                            $('.qadConsumptionReams').html(current_consumption_reams_final);
                        }
                    });
                }
                qadConsumption();

                //============================== GET TOTAL CONSUMPTION OF EMS FOR DASHBOARD ==============================
                function emsConsumption() {
                    $.ajax({
                        url: "get_ems_consumption",
                        method: "get",
                        dataType: "json",
                        success: function(response) {
                            $('.emsConsumption').text(response['result']);
                            let current_consumption_pieces = Number(response['result']);
                            let current_consumption_reams = current_consumption_pieces / 500;

                            let current_consumption_reams_final = current_consumption_reams.toFixed(2);

                            $('.emsConsumptionReams').html(current_consumption_reams_final);
                        }
                    });
                }
                emsConsumption();

                //============================== GET TOTAL CONSUMPTION OF PPC FACTORY 3 FOR DASHBOARD ==============================
                function emsConsumption() {
                    $.ajax({
                        url: "get_ems_consumption",
                        method: "get",
                        dataType: "json",
                        success: function(response) {
                            $('.emsConsumption').text(response['result']);
                            let current_consumption_pieces = Number(response['result']);
                            let current_consumption_reams = current_consumption_pieces / 500;

                            let current_consumption_reams_final = current_consumption_reams.toFixed(2);

                            $('.emsConsumptionReams').html(current_consumption_reams_final);
                        }
                    });
                }
                emsConsumption();

                //============================== GET TOTAL CONSUMPTION OF FACTORY 3 FOR DASHBOARD ==============================
                function emsConsumption() {
                    $.ajax({
                        url: "get_ems_consumption",
                        method: "get",
                        dataType: "json",
                        success: function(response) {
                            $('.emsConsumption').text(response['result']);
                            let current_consumption_pieces = Number(response['result']);
                            let current_consumption_reams = current_consumption_pieces / 500;

                            let current_consumption_reams_final = current_consumption_reams.toFixed(2);

                            $('.emsConsumptionReams').html(current_consumption_reams_final);
                        }
                    });
                }
                emsConsumption();

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

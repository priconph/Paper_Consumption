@if (!Auth::user())
    <script type="text/javascript">
        window.location = "/paper_consumption";
    </script>

@elseif(Auth::user()->user_level_id == 3)
    <script type="text/javascript">
        window.location = "dashboard";
    </script>
@else
    @php
        session_start();
        $_SESSION['user_level'] = Auth::user()->user_level_id;
        $_SESSION['user_department'] = Auth::user()->department_id;
    @endphp
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Paper Consumption Monitoring</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {{-- <link rel="shortcut icon" type="image/png" href="{{ asset('public/images/favicon.ico') }}"> --}}
        <style>
            #paperConsumptionRoutesId:hover {
                background-color: #778899 !important;
                list-style-type: none !important;
            }

            hr {
                color: white !important;
                background-color: white !important;
            }

            #aRoutesId {
                color: silver !important;
                background-color: none !important;
            }

        </style>

        {{-- CSS Styles --}}
        @include('shared.css_links.css_links')

    </head>

    <body class="hold-transition sidebar-mini">
        <div class="wrapper">
            @include('shared.pages.admin_header')
            @include('shared.pages.admin_nav')
            @yield('content_page')
            @include('shared.pages.admin_footer')
        </div>

        {{-- JS --}}
        @include('shared.js_links.js_links')
        @yield('js_content')
    </body>

    <input type="hidden" id="userLevel" value="{{ $_SESSION['user_level'] }}">
    <input type="hidden" id="userDept" value="{{ $_SESSION['user_department'] }}">


    <script>
        $(document).ready(function() {
            // if ($('#userDept').val() != 8) {
            //     $('#addMonthlyTargetModalbtn').css('display', 'none');
            // }


            if ($("#userLevel").val() == 1) {
                $("#managementRoute").hide();
                $("#paperConsumptionRoute").hide();

            } else if ($("#userLevel").val() == 3) {
                $("#managementRoute").hide();
                $("#paperConsumptionRoute").show();
            } else if ($("#userLevel").val() == 2) {
                $("#managementRoute").show();
                $("#paperConsumptionRoute").show();
            }
        });

        $(document).ready(function() {
            if ($("#userLevel").val() == 2) {
                $("#toSummary").hide();
                $("#toManagement").show();
            } else {
                $("#toSummary").show();
                $("#toManagement").hide();
            }
        });
    </script>

    </html>
@endif

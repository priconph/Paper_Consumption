{{-- @if (isset(Auth::user()->user_level_id) == 3)
    <script type="text/javascript">
        window.location = "paper_consumption_report";
    </script> --}}

@if (isset(Auth::user()->user_level_id) == 2)
    <script type="text/javascript">
        window.location = "dashboard";
    </script>

@elseif(isset(Auth::user()->user_level_id) == 1)
    <script type="text/javascript">
        window.location = "dashboard";
    </script>

@elseif(!isset(Auth::user()->user_level_id))
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Paper Consumption Monitoring</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- CSS Styles --}}
        @include('shared.css_links.css_links')
        <style>
            ::-webkit-scrollbar {
                display: none !important;
            }

            .logo {
                text-align: center;
                margin-top: 1rem;
                margin-bottom: -2rem
            }

            .logo img {
                max-width: 75%;
                width: 75%;
                height: auto;
                margin-top: -100px;
                margin-left: 100px;
            }

            html,
            body {
                margin: 0;
                height: 100%;
                overflow: hidden
            }

        </style>

    </head>

    <body>
        <div class="wrapper">
            <div class="row d-flex justify-content-center justify-content-sm-center align-items-center"
                style="min-height: 100vh;">
                <div class="col-sm-12 col-md-12 col-lg-7  text-center">
                    <div class="logo">
                        <img src="{{ asset('public/images/pcms.gif') }}">
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-5 d-flex justify-content-around">
                    <div class="card" style="box-shadow: 1px 1px 10px #808080; max-width: 90vw; width: 60%">
                        <h5 class="card-header bg-dark text-center py-4"><img
                                src="{{ asset('public/images/pcms.png') }}" height="60">&nbsp;&nbsp; <b>Paper
                                Consumption Monitoring </b></h5>
                        <div class="card-body my-0">
                            <p class="login-box-msg">Please sign In</p>
                            <form id="signInForm">
                                @csrf
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="username" placeholder="Username"
                                        id="idusername">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-user"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <input type="password" class="form-control" name="password" placeholder="Password"
                                        id="idpassword">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-lock"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 my-3">
                                        <button type="submit" class="btn btn-dark btn-block" id="btnSignIn"><i
                                                class="fa fa-check" id="btnSignInIcon"></i> Sign In</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('shared.js_links.js_links')
        <script type="text/javascript">
            $(document).ready(function() {
                $("#signInForm").submit(function(event) {
                    event.preventDefault();
                    SignIn();
                });
            });
        </script>
    </body>

    </html>
@endif

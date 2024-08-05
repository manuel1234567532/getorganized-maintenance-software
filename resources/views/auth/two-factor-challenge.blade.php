 <!doctype html>
<html lang="en" dir="ltr">

    <head>
        <!-- META DATA -->
        <meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- FAVICON -->
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('backend/images/brand/favicon.ico') }}" />
        <!-- TITLE -->
        <title>{{ env('APP_NAME') }} | 2FA</title>
        <!-- BOOTSTRAP CSS -->
        <link id="style" href="{{ asset('backend/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
        <!-- STYLE CSS -->
        <link href="{{ asset('backend/css/style.css') }}" rel="stylesheet" />
        <link href="{{ asset('backend/css/dark-style.css') }}" rel="stylesheet" />
        <link href="{{ asset('backend/css/transparent-style.css') }}" rel="stylesheet">
        <link href="{{ asset('backend/css/skin-modes.css') }}" rel="stylesheet" />
        <!--- FONT-ICONS CSS -->
        <link href="{{ asset('backend/css/icons.css') }}" rel="stylesheet" />
        <!-- COLOR SKIN CSS -->
        <link id="theme" rel="stylesheet" type="text/css" media="all" href="{{ asset('backend/colors/color1.css') }}" />
    </head>
 
     <body class="app sidebar-mini ltr login-img">
        <!-- BACKGROUND-IMAGE -->
        <div class="">
            <!-- GLOBAL LOADER -->
            <!-- ... -->
            <!-- PAGE -->
            <div class="page">
                <div class="">
                    <!-- CONTAINER OPEN -->
                    <div class="col col-login mx-auto mt-7">
                        <div class="text-center">
                            <img src="{{ asset('backend/images/brand/logo-getorganized.png') }}" class="header-brand-img" alt="">
                        </div>
                    </div>
                    <div class="container-login100">
                        <div class="wrap-login100 p-6">
                            <form id="2fa_verification_form" method="POST">
                                @csrf
                                <span class="login100-form-title pb-5">
                                    2FA Verifizierung
                                </span>
                                <!-- 2FA Token Input -->
                                <div class="wrap-input100 validate-input input-group">
                                    <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                        <i class="zmdi zmdi-lock text-muted" aria-hidden="true"></i>
                                    </a>
                                    <input id="2fa_token" type="text" class="input100 border-start-0 ms-0 form-control" name="2fa_token" required autofocus placeholder="2FA-Token eingeben...">
                                </div>

                                <!-- Error Message -->
                                @if ($errors->any())
                                    <div class="alert alert-danger mt-2">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <!-- Submit Button -->
                                <div class="container-login100-form-btn">
                                    <button type="submit" class="login100-form-btn btn-primary">
                                        Überprüfen
                                    </button>
                                </div>

                                <div class="text-center pt-3">
                                    <p class="text-dark mb-0">Zurück zu <a href="{{ route('login') }}" class="text-primary ms-1">Anmelden</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
 <!-- CONTAINER CLOSED -->
                </div>
            </div>
            <!-- End PAGE -->
        </div>
        <!-- BACKGROUND-IMAGE CLOSED -->

        <!-- JQUERY JS -->
        <script src="{{ asset('backend/js/jquery.min.js') }}"></script>
        <!-- BOOTSTRAP JS -->
        <script src="{{ asset('backend/plugins/bootstrap/js/popper.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
        <!-- SHOW PASSWORD JS -->
        <script src="{{ asset('backend/js/show-password.min.js') }}"></script>
        <!-- GENERATE OTP JS -->
        <script src="{{ asset('backend/js/generate-otp.js') }}"></script>
        <!-- Perfect SCROLLBAR JS-->
        <script src="{{ asset('backend/plugins/p-scroll/perfect-scrollbar.js') }}"></script>
        <!-- Color Theme js -->
        <script src="{{ asset('backend/js/themeColors.js') }}"></script>
        <!-- CUSTOM JS -->
        <script src="{{ asset('backend/js/custom.js') }}"></script>
    </body>

</html>
<script>
$(document).ready(function() {
    console.log
    $('#2fa_verification_form').on('submit', function(e) {
        e.preventDefault();

        // Sammle Formulardaten
        var formData = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: '/two-factor-login', // URL der 2FA-Verifizierung
            data: formData,
            success: function(response) {
                // Behandle Erfolgsfall
                if (response.success) {
                     toastMessage('2FA bestanden!', 'success');
                   setTimeout(function() {
                        window.location.href = '/dashboard'; // Weiterleitung zum Dashboard
                    }, 2000);
                } else {
                    // Zeige Fehlermeldung
                     toastMessage('Falscher 2FA-Code oder Wiederherstellungscode!', 'error');
                }
            },
            error: function(response) {
                // Behandle Fehlerfall
                 toastMessage('Es ist ein Fehler aufgetreten! Versuchen Sie es später erneut', 'error');
            }
        });
    });
});
</script>
@include('backend.layouts.partials.scripts')
 <script src="{{ asset('backend/js/common.js') }}"></script>
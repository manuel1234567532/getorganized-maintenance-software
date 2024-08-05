<!doctype html>
<html lang="en" dir="ltr">

<head>
    @include('backend.layouts.partials.head')
</head>

<body class="app sidebar-mini ltr light-mode">

    <!-- GLOBAL-LOADER -->
    <div id="global-loader">
        <img src="{{ asset('backend/images/loader.svg') }}" class="loader-img" alt="Loader">
    </div>
    <!-- /GLOBAL-LOADER -->

    <!-- PAGE -->
    <div class="page">
        <div class="page-main">

            <!-- app-Header -->
            <div class="app-header header sticky">
                <div class="container-fluid main-container">
                    <div class="d-flex">
                        <!-- sidebar-toggle-->
                        <a class="logo-horizontal " href="index.html">
                            <img src="{{ asset('backend/images/brand/logo_4.png') }}"
                                class="header-brand-img desktop-logo" alt="logo">
                            <img src="{{ asset('backend/images/brand/logo-3.png') }}"
                                class="header-brand-img light-logo1" alt="logo">
                        </a>
                        <!-- LOGO -->
                        <div class="d-flex order-lg-2 ms-auto header-right-icons">
                            <div class="navbar navbar-collapse responsive-navbar p-0">
                                <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                                    <div class="d-flex order-lg-2">
                                        <!-- FULL-SCREEN -->
                                        <div class="dropdown d-flex profile-1">
                                            <a href="javascript:void(0)" data-bs-toggle="dropdown"
                                                class="nav-link leading-none d-flex">
                                                <img src="{{ getImage(auth()->user()->avatar, true) }}"
                                                    alt="profile-user" class="avatar  profile-user brround cover-image">
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                <div class="drop-heading">
                                                    <div class="text-center">
                                                        <h5 class="text-dark mb-0 fs-14 fw-semibold">
                                                            {{ getFullName(auth()->user()) }}</h5>
                                                        <small
                                                            class="text-muted">{{ auth()->user()->username }}</small>
                                                    </div>
                                                </div>
                                                <div class="dropdown-divider m-0"></div>
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf
                                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                                        <i class="dropdown-icon fe fe-alert-circle"></i> Abmelden
                                                    </a>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /app-Header -->
            <!--app-content open-->
            <div class="main-content mt-8">
                <div class="side-app">
                    <!-- CONTAINER -->
                    <div class="main-container container-fluid">
                        <form action="{{ route('update-user-password', auth()->user()->id) }}" method="post" data-redirect='true'
                            data-form="ajax-form">
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-12 col-xl-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Bitte ändern Sie Ihr Passwort </h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label class="form-label" for="current_password">Aktuell
                                                    Passwort</label>
                                                <div class="wrap-input100 validate-input input-group"
                                                    id="Password-toggle">
                                                    <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                                        <i class="zmdi zmdi-eye text-muted" aria-hidden="true"></i>
                                                    </a>
                                                    <input class="input100 form-control" type="password"
                                                        placeholder="Current Password" autocomplete="current_password" id="current_password" name="current_password">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label class="form-label" for="password">Neues Kennwort</label>
                                                    <div class="wrap-input100 validate-input input-group"
                                                        id="Password-toggle1">
                                                        <a href="javascript:void(0)"
                                                            class="input-group-text bg-white text-muted">
                                                            <i class="zmdi zmdi-eye text-muted" aria-hidden="true"></i>
                                                        </a>
                                                        <input class="input100 form-control" type="password"
                                                            placeholder="New Password" autocomplete="password"
                                                            id="password" name="password">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="form-label"
                                                        for="password_confirmation">{{ __('messages.confirm_password') }}</label>
                                                    <div class="wrap-input100 validate-input input-group"
                                                        id="Password-toggle2">
                                                        <a href="javascript:void(0)"
                                                            class="input-group-text bg-white text-muted">
                                                            <i class="zmdi zmdi-eye text-muted" aria-hidden="true"></i>
                                                        </a>
                                                        <input class="input100 form-control" type="password"
                                                            placeholder="Confirm Password"
                                                            autocomplete="password_confirmation"
                                                            id="password_confirmation" name="password_confirmation">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary"
                                                    data-button="submit">Aktualisieren</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    </form>
                    <!-- CONTAINER END -->
                </div>
            </div>
            <!--app-content close-->

        </div>

        <!-- FOOTER -->
        @include('backend.layouts.partials.footer')
        <!-- FOOTER END -->

    </div>

    @include('backend.layouts.partials.scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    <script src="{{ asset('backend/js/common.js') }}"></script>
    <script src="{{ asset('backend/js/show-password.min.js') }}"></script>

</body>

</html>

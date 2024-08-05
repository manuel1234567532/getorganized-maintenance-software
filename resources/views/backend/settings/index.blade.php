@extends('backend.layouts.app')

@section('title', '| Kategorien ')

@section('breadcrumb')
    <!-- PAGE-HEADER -->
                        <div class="page-header">
                            <h1 class="page-title">Settings</h1>
                            <div>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Einstellungen</li>
                                </ol>
                            </div>
                        </div>
@endsection

@section('content')
 <!-- Row -->
 @php
    $userRole = \App\Models\RoleAndAccess::where('role_name', Auth::user()->user_type)->first();
@endphp
                        <div class="row ">
                            <div class="col-lg-6 col-xl-1">
                              
                            </div>
                            <div class="col-lg-6 col-xl-9">
                                <div class="row row-sm">
									 @if ($userRole->can_view_website_settings === 'yes')
                                    <div class="col-xl-12 col-xxl-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xl-2 col-sm-2 col-md-12">
                                                        <div class="mt-3 mb-5">
                                                            <span class="settings-icon bg-primary-transparent text-primary"><i class="fe fe-settings"></i></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-10 col-sm-10 col-md-12">
                                                        <a href="javascript:void(0)">
                                                            <h4 class="mb-1 text-dark">Allgemein</h4>
                                                        </a>
                                                        <p>Allgemeine Einstellungen wie Seitentitel, Logo und andere allgemeine und erweiterte Einstellungen.</p>
                                                        <a href="{{ route('general-settings.index') }}">Einstellungen ändern <i class="ion-chevron-right fs-10 ms-1"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									@endif
                                    <div class="col-xl-12 col-xxl-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xl-2 col-sm-2 col-md-12">
                                                        <div class="mt-3 mb-5">
                                                            <span class="settings-icon bg-danger-transparent text-danger border-danger"><i class="fe fe-bell"></i></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-10 col-sm-10 col-md-12">
                                                        <a href="javascript:void(0)">
                                                            <h4 class="mb-1 text-dark">Benachrichtungen</h4>
                                                        </a>
                                                        <p>Mit den Benachrichtigungseinstellungen können wir den Datenschutz und die Sicherheit der Benachrichtigungen steuern.</p>
                                                        <a href="{{ route('general-notifications.index') }}">Einstellungen ändern <i class="ion-chevron-right fs-10 ms-1"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                     @if ($userRole->can_view_users === 'yes')
                                    <div class="col-xl-12 col-xxl-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xl-2 col-sm-2 col-md-12">
                                                        <div class="mt-3 mb-5">
                                                            <span class="settings-icon bg-primary-transparent text-primary"><i class="fe fe-users"></i></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-10 col-sm-10 col-md-12">
                                                        <a href="javascript:void(0)">
                                                            <h4 class="mb-1 text-dark">Benutzer</h4>
                                                        </a>
                                                        <p>In den Benutzereinstellungen können Sie Benutzer anlegen, bearbeiten und löschen.</p>
                                                        <a href="{{ route('users.index') }}">Einstellungen ändern <i class="ion-chevron-right fs-10 ms-1"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                     @if ($userRole->can_view_roles === 'yes')
                                    <div class="col-xl-12 col-xxl-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xl-2 col-sm-2 col-md-12">
                                                        <div class="mt-3 mb-5">
                                                            <span class="settings-icon bg-warning-transparent text-warning border-warning"><i class="fe fe-lock"></i></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-10 col-sm-10 col-md-12">
                                                        <a href="javascript:void(0)">
                                                            <h4 class="mb-1 text-dark">Rollen</h4>
                                                        </a>
                                                        <p>In den Rollen Einstellungen können Sie Rollen erstellen um Benutzer aus gewisse Bereiche der Webseite auszuschließen.</p>
                                                        <a href="{{ route('roles.index') }}">Einstellungen ändern <i class="ion-chevron-right fs-10 ms-1"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                     @if ($userRole->can_view_machines === 'yes')
                                    <div class="col-xl-12 col-xxl-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xl-2 col-sm-2 col-md-12">
                                                        <div class="mt-3 mb-5">
                                                            <span class="settings-icon bg-success-transparent text-success border-success"><i class="fe fe-server"></i></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-10 col-sm-10 col-md-12">
                                                        <a href="javascript:void(0)">
                                                            <h4 class="mb-1 text-dark">Maschinen</h4>
                                                        </a>
                                                        <p>In den Maschineneinstellungen können Sie Maschinen erstellen, bearbeiten und löschen.</p>
                                                        <a href="{{ route('machines.index') }}">Einstellungen ändern <i class="ion-chevron-right fs-10 ms-1"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                     @if ($userRole->can_view_categories === 'yes')
                                    <div class="col-xl-12 col-xxl-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xl-2 col-sm-2 col-md-12">
                                                        <div class="mt-3 mb-5">
                                                            <span class="settings-icon bg-pink-transparent text-pink border-pink"><i class="fe fe-layers"></i></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-10 col-sm-10 col-md-12">
                                                        <a href="javascript:void(0)">
                                                            <h4 class="mb-1 text-dark">Maschinentypen</h4>
                                                        </a>
                                                        <p>In den Maschinentypeneinstellungen können Sie Maschinentypen erstellen, bearbeiten und löschen.</p>
                                                        <a href="{{ route('machine-types.index') }}">Einstellungen ändern <i class="ion-chevron-right fs-10 ms-1"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                     @if ($userRole->can_view_locations === 'yes')
                                    <div class="col-xl-12 col-xxl-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xl-2 col-sm-2 col-md-12">
                                                        <div class="mt-3 mb-5">
                                                            <span class="settings-icon bg-info-transparent text-info border-info"><i class="fe fe-map-pin"></i></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-10 col-sm-10 col-md-12">
                                                        <a href="javascript:void(0)">
                                                            <h4 class="mb-1 text-dark">Standorte</h4>
                                                        </a>
                                                        <p>In den Standorteinstellungen können Sie Standorte erstellen, bearbeiten und löschen.</p>
                                                        <a href="{{ route('location.index') }}">Einstellungen ändern <i class="ion-chevron-right fs-10 ms-1"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                     @if ($userRole->can_view_departement === 'yes')
                                    <div class="col-xl-12 col-xxl-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xl-2 col-sm-2 col-md-12">
                                                        <div class="mt-3 mb-5">
                                                            <span class="settings-icon bg-danger-transparent text-orange border-orange"><i class="fe fe-award"></i></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-10 col-sm-10 col-md-12">
                                                        <a href="javascript:void(0)">
                                                            <h4 class="mb-1 text-dark">Abteilungen</h4>
                                                        </a>
                                                        <p>In den Abteilungseinstellungen können Sie Abteilungen erstellen, bearbeiten und löschen.</p>
                                                        <a href="{{ route('departement.index') }}">Einstellungen ändern <i class="ion-chevron-right fs-10 ms-1"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                     @if ($userRole->can_view_files === 'yes')
                                    <div class="col-xl-12 col-xxl-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xl-2 col-sm-2 col-md-12">
                                                        <div class="mt-3 mb-5">
                                                            <span class="settings-icon bg-danger-transparent text-orange border-orange"><i class="fe fe-file"></i></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-10 col-sm-10 col-md-12">
                                                        <a href="javascript:void(0)">
                                                            <h4 class="mb-1 text-dark">Dateien</h4>
                                                        </a>
                                                        <p>In den Dateieneinstellungen können Sie Dateien freigeben, hochladen, bearbeiten und löschen</p>
                                                        <a href="{{ route('files.index') }}">Einstellungen ändern <i class="ion-chevron-right fs-10 ms-1"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="col-xl-12 col-xxl-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xl-2 col-sm-2 col-md-12">
                                                        <div class="mt-3 mb-5">
                                                            <span class="settings-icon bg-danger-transparent text-orange border-orange"><i class="fe fe-mail"></i></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-10 col-sm-10 col-md-12">
                                                        <a href="javascript:void(0)">
                                                            <h4 class="mb-1 text-dark">SMTP</h4>
                                                        </a>
                                                        <p>In den SMTP Einstellungen können Sie ihre Emailausgangsserver definieren.</p>
                                                        <a href="{{ route('smtp.index') }}">Einstellungen ändern <i class="ion-chevron-right fs-10 ms-1"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Row -->
                    </div>
                </div>
            </div>
            <!-- END MAIN-CONTENT -->
@endsection
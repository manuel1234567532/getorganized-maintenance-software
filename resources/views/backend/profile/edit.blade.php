@extends('backend.layouts.app')
@section('title', '| Edit Profile')

@section('breadcrumb')
    <div class="page-header">
        <h1 class="page-title">Profile</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Profile</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <!-- COL-END -->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="panel panel-primary">
                        <div class="tab-menu-heading">
                            <div class="tabs-menu1">
                                <!-- Tabs -->
                                <ul class="nav panel-tabs">
                                    <li><a href="#tab25" class="active" data-bs-toggle="tab">Profil</a></li>
                                    <li><a href="#tab26" data-bs-toggle="tab">Kennwort ändern</a></li>
                                    <li><a href="#tab27" data-bs-toggle="tab">2FA</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body tabs-menu-body pb-0">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab25">
                                    <div class="col-xl-12">
                                        <form action="{{ route('profile.update', auth()->user()->id) }}" method="post" data-form="ajax-form" enctype="multipart/form-data">
                                            @method('PUT')
                                            <div class="text-center chat-image mb-5">
                                                <div class="avatar chat-profile mb-3 brround upload-button"
                                                    style="width: 150px; height: 150px;">
                                                    <a href="javascript:void(0)">
                                                        <img alt="avatar" class="profile-pic chat-profile mb-3 brround"
                                                            src="{{ getImage(auth()->user()->avatar, true) }}" alt="profile pic" style="width: 150px;height: 150px;">
                                                    </a>
                                                </div>
                                                <input class="file-upload d-none" type="file" accept="image/*" name="image" id="profile" />
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="username">{{ __('messages.username') }}</label>
                                                        <input type="text" class="form-control" id="username"
                                                            name="username" placeholder="First Name" value="{{ auth()->user()->username }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="email">E-Mail-Adresse</label>
                                                        <input type="email" class="form-control" id="email" name="email"
                                                            placeholder="Email address" value="{{ auth()->user()->email }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="first_name">Vorname</label>
                                                        <input type="email" class="form-control" id="first_name" name="first_name"
                                                            placeholder="Vorname" value="{{ auth()->user()->first_name }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="last_name">Nachname</label>
                                                        <input type="email" class="form-control" id="last_name" name="last_name"
                                                            placeholder="Nachname" value="{{ auth()->user()->last_name }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12">
    <div class="form-group">
        <label class="form-label" for="birthday">Geburtstag</label>
        <div class="input-group date" id="datepicker">
            <input type="text" class="form-control" id="birthday" name="birthday" placeholder="TT.MM.JJJJ" required value="{{ auth()->user()->birthday ? \Carbon\Carbon::parse(auth()->user()->birthday)->format('d.m.Y') : '' }}" readonly>
            <span class="input-group-append">
                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
            </span>
        </div>
    </div>
</div>


                                                <div class="col-lg-6 col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="department">Abteilung</label>
                                                        <input type="text" class="form-control" id="department" name="department"
                                                            placeholder="Vorname" value="{{ auth()->user()->department }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary" data-button="submit">Aktualisieren</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab26">
                                    <div class="col-xl-12">
                                        <form action="{{ route('change-password', auth()->user()->id) }}" method="post"
                                            data-form="ajax-form">
                                            @method('PUT')
                                            <div class="form-group">
                                                <label class="form-label" for="current_password">Aktuelles
                                                    Passwort</label>
                                                <div class="wrap-input100 validate-input input-group"
                                                    id="Password-toggle">
                                                    <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                                        <i class="zmdi zmdi-eye text-muted" aria-hidden="true"></i>
                                                    </a>
                                                    <input class="input100 form-control" type="password"
                                                        placeholder="Derzeitiges Passwort" autocomplete="current_password" id="current_password" name="current_password">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label class="form-label" for="password">Neues Kennwort</label>
                                                    <div class="wrap-input100 validate-input input-group" id="Password-toggle1">
                                                        <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                                            <i class="zmdi zmdi-eye text-muted" aria-hidden="true"></i>
                                                        </a>
                                                        <input class="input100 form-control" type="password"
                                                            placeholder="Neues Kennwort" autocomplete="password" id="password" name="password">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="form-label" for="password_confirmation">{{ __('messages.confirm_password') }}</label>
                                                    <div class="wrap-input100 validate-input input-group"
                                                        id="Password-toggle2">
                                                        <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                                            <i class="zmdi zmdi-eye text-muted" aria-hidden="true"></i>
                                                        </a>
                                                        <input class="input100 form-control" type="password"
                                                            placeholder="Passwort bestätigen" autocomplete="password_confirmation"
                                                            id="password_confirmation" name="password_confirmation">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary" data-button="submit">Aktualisieren</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
<div class="tab-pane" id="tab27">
    @if (!Auth::user()->two_factor_confirmed_at)
        <!-- 2FA aktivieren -->
        <button id="activate2fa" class="btn btn-primary">2FA Aktivieren</button>

        <div id="qrCodeContainer" style="display: none;">
            <form method="POST" action="{{ route('activate2fa') }}">
                @csrf
                <button type="submit" class="btn btn-primary">QR-Code generieren</button>
            </form>
            <img src="{{ session('qrCodeUrl') }}" alt="QR Code">
        </div>
        <form method="POST" action="{{ route('verify2fa') }}">
            @csrf
            <div class="form-group" id="verify2faForm" style="display: none;">
    <label for="verification_code">Verifizierungscode</label>
    <input type="text" class="form-control" id="verification_code" name="verification_code" required style="width: 200px;">
</div>
            <button type="submit" class="btn btn-primary" id="verifyButton" style="display: none;">Überprüfen</button>
        </form>
        
          <!-- Container für dynamische Anzeige der Wiederherstellungscodes -->
       <div id="dynamicRecoveryCodesContainer" style="display: none;">
    <div class="card shadow">
        <div class="card-body">
            <h3 style="color: green;">2FA Erfolgreich aktiviert!</h3>
            <h3>Deine Wiederherstellungscodes!</h3>
            <p>Diese Codes sind wichtig falls du keinen Zugriff mehr auf dein 2FA-Gerät haben solltest. Diese Codes werden dir nur <strong>einmalig</strong> angezeigt! Bitte speichere sie auf einem sicheren Platz.</p>
            <ul id="dynamicRecoveryCodesList"></ul>
        </div>
        <div class="card-footer">
            <button id="downloadRecoveryCodes" class="btn btn-success mb-3" style="background: #009fff !important; border-color: #009fff; display: none;">Wiederherstellungscodes Herunterladen</button>
        </div>
    </div>
</div>
    @else
        <!-- 2FA deaktivieren -->
        <form method="POST" action="{{ route('deactivate2fa') }}">
            @csrf
    <button type="submit" class="btn btn-danger">Deaktivieren</button>
        </form>
    @endif
</div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- COL-END -->
    </div>
@push('scripts')
    <!-- SHOW PASSWORD JS -->
    <script src="{{ asset('backend/js/show-password.min.js') }}"></script>
    
<script>
document.addEventListener('DOMContentLoaded', function() {
    var activate2faButton = document.getElementById('activate2fa');
    var verifyButton2 = document.getElementById('verifyButton');
    var qrCodeContainer = document.getElementById('qrCodeContainer');
    var verify2faForm = document.getElementById('verify2faForm');
    var recoveryCodesContainer = document.getElementById('dynamicRecoveryCodesContainer');
    var recoveryCodesList = document.getElementById('dynamicRecoveryCodesList');

    if (activate2faButton) {
        activate2faButton.addEventListener('click', function(event) {
            event.preventDefault(); 

            $.ajax({
                url: '/activate2fa',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (qrCodeContainer) {
                      qrCodeContainer.innerHTML = '<p><strong>Scannen Sie diesen QR-Code mit Ihrer Authenticator-App.</strong></p><img src="' + response.qrCodeUrl + '" alt="QR Code" style="border: 2px solid #0186f780; border-radius: 10px;">';
                        qrCodeContainer.style.display = 'block';
                        activate2faButton.style.display = 'none';
                    }

                    if (verify2faForm && verifyButton2) {
                        verify2faForm.style.display = 'block';
                        verifyButton2.style.display = 'block';
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Fehler bei der Anforderung: ", status, error);
                }
            });
        });
    }

    if (verifyButton2) {
        verifyButton2.addEventListener('click', function(event) {
            event.preventDefault();

            var verificationCode = document.getElementById('verification_code').value;
            $.ajax({
                url: '/verify2fa',
                type: 'POST',
                data: {
                    verification_code: verificationCode,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success && recoveryCodesContainer && recoveryCodesList && response.recoveryCodes) {
                        toastMessage('2FA erfolgreich aktiviert!', 'success');
                        recoveryCodesList.innerHTML = '';
                        response.recoveryCodes.forEach(function(code) {
                            recoveryCodesList.innerHTML += '<li>' + code + '</li>';
                        });
                        recoveryCodesContainer.style.display = 'block';
                        qrCodeContainer.style.display = 'none';
                        activate2faButton.style.display = 'none';
                        verify2faForm.style.display = 'none';
                        verifyButton2.style.display = 'none';
                        
                         // Zeigen Sie den Download-Button an
                    var downloadButton = document.getElementById('downloadRecoveryCodes');
                    if (downloadButton) {
                        downloadButton.style.display = 'block';
                        downloadButton.addEventListener('click', function() {
                            // Erstellen Sie eine .txt-Datei mit den Wiederherstellungscodes und initiieren Sie den Download
                            var recoveryCodesText = response.recoveryCodes.join('\n');
                            var blob = new Blob([recoveryCodesText], { type: 'text/plain' });
                            var url = window.URL.createObjectURL(blob);
                            var a = document.createElement('a');
                            a.href = url;
                            a.download = 'GetOrganized_recovery_codes' + '.txt';
                            a.click();
                            window.URL.revokeObjectURL(url);
                        });
                    }
                    } else {
                      toastMessage('Fehler bei der Aktivierung von 2FA!', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error occurred:", status, error);
                }
            });
        });
    }
});
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#datepicker').datepicker({
            format: 'dd.mm.yyyy', // Deutsches Datumsformat
            language: 'de' // Sprache auf Deutsch setzen
        });
    });
</script>
@endpush

@endsection
@extends('backend.layouts.app')

@section('title', '| SMTP Einstellungen')

@section('breadcrumb')
    <div class="page-header">
        <h1 class="page-title">SMTP Einstellungen</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Alle Einstellungen</a></li>
                <li class="breadcrumb-item active" aria-current="page">SMTP Einstellungen</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            @if ($isSmtpSettingsSaved)
            <div class="alert alert-success">
                SMTP Einstellungen bereits konfiguriert!
            </div>
            @endif
            <div class="card">
                <div class="card-header">
                    SMTP Einstellungen
                </div>
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label for="smtpHost" class="form-label">SMTP Host</label>
                            <input type="text" class="form-control" id="smtpHost" placeholder="z.B. smtp.example.com" value="{{ $settings->smtp_host ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label for="smtpPort" class="form-label">SMTP Port</label>
                            <input type="number" class="form-control" id="smtpPort" placeholder="z.B. 587" value="{{ $settings->smtp_port ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label for="smtpUser" class="form-label">SMTP Benutzername</label>
                           <input type="text" class="form-control" id="smtpUser" placeholder="Benutzername" value="{{ $settings->smtp_username ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label for="smtpPassword" class="form-label">SMTP Passwort</label>
                            <input type="password" class="form-control" id="smtpPassword" placeholder="Passwort" value="{{ $settings->smtp_password ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label for="smtpSecurity" class="form-label">SMTP Sicherheit</label>
                            <select class="form-select" id="smtpSecurity">
                               <option value="tls" {{ $settings->smtp_security == 'tls' ? 'selected' : '' }}>TLS</option>
        						<option value="ssl" {{ $settings->smtp_security == 'ssl' ? 'selected' : '' }}>SSL</option>
                            </select>
                        </div>
						<div class="mb-3">
                            <label for="test_mail" class="form-label">Test E-Mail Empfänger*</label>
                            <input type="text" class="form-control" id="test_mail" placeholder="Empfänger E-Mail" value="{{ $settings->smtp_host ?? '' }}">
                        </div>
						<button type="button" class="btn btn-secondary" onclick="testSMTPSettings()"
							>Test-Mail senden</button>


                        <button type="button" class="btn btn-primary" onclick="createsmtpsettings()">Speichern</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function createsmtpsettings(event) {
        // Sammeln der Daten aus dem Formular
        var smtpData = {
            'smtp_host': $('#smtpHost').val(),
            'smtp_port': $('#smtpPort').val(),
            'smtp_username': $('#smtpUser').val(),
            'smtp_password': $('#smtpPassword').val(),
            'smtp_security': $('#smtpSecurity').val(),
        };


    // AJAX-Anfrage
    $.ajax({
        url: '{{ route("update-smtpsettings") }}', // Ersetzen Sie dies durch den Namen Ihrer Route
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), // CSRF-Token
            'Accept': 'application/json'
        },
        data: smtpData,
        success: function(response) {
            if (response.status === 200) {
                // Erfolgsmeldung anzeigen und Seite neu laden
                swal.fire("Erfolgreich!", response.message, "success").then(() => {
                     window.location.reload();
                });
            } else {
                // Fehlermeldung aus der Antwort anzeigen
                toastMessage(response.message, 'error');
            }
        },
        error: function(error) {
            // Allgemeine Fehlermeldung anzeigen
            toastMessage('Es ist ein Serverfehler aufgetreten.', 'error');
        }
    });
}
	function testSMTPSettings() {
    var smtpData = {
        'smtp_host': $('#smtpHost').val(),
        'smtp_port': $('#smtpPort').val(),
        'smtp_username': $('#smtpUser').val(),
        'smtp_password': $('#smtpPassword').val(),
        'smtp_security': $('#smtpSecurity').val(),
    };

    $.ajax({
        url: '{{ route('smtp.send-test-email') }}', // Die URL zum Senden der Test-E-Mail
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json'
        },
        data: smtpData,
success: function(response) {
    if (response.status === 'success') {
        swal.fire("Erfolg", response.message, "success").then(() => {
            window.location.reload();
        });
    } else {
        toastMessage(response.message, 'error');
    }
},
        error: function(error) {
            toastMessage('Es ist ein Serverfehler aufgetreten.', 'error');
        }
    });
}


</script>
@endsection

@extends('backend.layouts.app')

@section('title', '| Benachrichtigungen')

@section('breadcrumb')
<div class="page-header">
    <h1 class="page-title">Benachrichtigungseinstellungen</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Admin-Einstellungen</a></li>
            <li class="breadcrumb-item active" aria-current="page">Benachrichtigungseinstellungen</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Accounterstellung</h5>
                <div class="mb-3">
                    <label for="websiteName" class="form-label">Benutzer nach Accounterstellung per E-Mail benachrichtigen?</label>
                    <!-- Füge hier den Switch ein -->
                    <label class="switch">
                        <input type="checkbox" id="accountcreated" @if($notificationSettings['account_created_mail'] === 'yes') checked @endif>
                        <span class="slider round"></span>
                    </label>
                    <label for="websiteName" class="form-label">Benutzer nach Accounterstellung eine Willkommens-E-Mail zukommen lassen?</label>
                    <!-- Füge hier den Switch ein -->
                    <label class="switch">
                        <input type="checkbox" id="welcomemail" @if($notificationSettings['account_created_welcome_mail'] === 'yes') checked @endif>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Account gesperrt</h5>
                <div class="mb-3">
                    <label for="websiteName" class="form-label">Benutzer nach Accountsperrung per E-Mail benachrichtigen?</label>
                    <!-- Füge hier den Switch ein -->
                    <label class="switch">
                        <input type="checkbox" id="accountblocked" @if($notificationSettings['account_blocked_mail'] === 'yes') checked @endif>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Account freigegeben</h5>
                <div class="mb-3">
                    <label for="websiteName" class="form-label">Benutzer nach Accountentsperrung per E-Mail benachrichtigen?</label>
                    <!-- Füge hier den Switch ein -->
                    <label class="switch">
                        <input type="checkbox" id="accountunblocked" @if($notificationSettings['account_unlocked_mail'] === 'yes') checked @endif>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        </div>
    </div>
      <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Arbeitsauftrag überfällig</h5>
                <div class="mb-3">
                    <label for "websiteName" class="form-label">Benutzer bei überfälligen Arbeitsaufträgen per E-Mail benachrichtigen?</label>
                    <!-- Füge hier den Switch ein -->
                    <label class="switch">
                        <input type="checkbox" id="workorderoverdue" @if($notificationSettings['workorder_overdue_mail'] === 'yes') checked @endif>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        </div>
    </div>
      <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Arbeitsauftrag abgeschlossen</h5>
                <div class="mb-3">
                    <label for="websiteName" class="form-label">Benutzer bei abgeschlossenen Arbeitsaufträgen per E-Mail benachrichtigen?</label>
                    <!-- Füge hier den Switch ein -->
                    <label class="switch">
                       <input type="checkbox" id="workordercompleted" @if($notificationSettings['workorder_completed_mail'] === 'yes') checked @endif>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        </div>
    </div>
     <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Datei freigegeben</h5>
                <div class="mb-3">
                    <label for="websiteName" class="form-label">Benutzer nach freigeben einer Datei per E-Mail benachrichtigen?</label>
                    <!-- Füge hier den Switch ein -->
                    <label class="switch">
                        <input type="checkbox" id="fileaccepted" @if($notificationSettings['file_accepted_mail'] === 'yes') checked @endif>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        </div>
    </div>
     <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Datei abgelehnt</h5>
                <div class="mb-3">
                    <label for="websiteName" class="form-label">Benutzer nach Ablehnen einer Datei per E-Mail benachrichtigen?</label>
                    <!-- Füge hier den Switch ein -->
                    <label class="switch">
                        <input type="checkbox" id="filenotaccepted" @if($notificationSettings['file_notaccepted_mail'] === 'yes') checked @endif>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-end mt-4">
        <div class="col-md-2">
            <button class="btn btn-primary btn-block" id="saveButton">Speichern</button>
        </div>
    </div>
</div>
@endsection

<style>
#saveButton {
    margin-bottom: 30px; /* Oder ein Wert Ihrer Wahl */
}
/* Grundlegender Stil für den Switch, Größe verkleinert */
.switch {
  position: relative;
  display: inline-block;
  width: 40px; /* Verkleinerte Breite */
  height: 24px; /* Verkleinerte Höhe */
}

/* Stil für den Slider */
.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

/* Slider-Stil, Größe angepasst */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 20px; /* Verkleinerte Höhe des Griffs */
  width: 20px; /* Verkleinerte Breite des Griffs */
  left: 2px;
  bottom: 2px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

/* Farbwechsel und Position des Slider-Griffs beim Aktivieren */
input:checked + .slider {
  background-color: #00b0ff;
}

input:checked + .slider:before {
  -webkit-transform: translateX(16px); /* Angepasste Verschiebung */
  -ms-transform: translateX(16px);
  transform: translateX(16px);
}

input:not(:checked) + .slider {
  background-color: #ff004a;
}

/* Runde Ecken für den Slider */
.slider.round {
  border-radius: 24px; /* Angepasste Rundung */
}

.slider.round:before {
  border-radius: 50%;
}
.row {
    display: flex;
    flex-wrap: wrap;
}

.col-md-6 {
    display: flex;
    flex-direction: column;
}

.card {
    flex-grow: 1;
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('saveButton').addEventListener('click', function() {
            // Sammle die Werte der Switches
            var accountcreated = $('#accountcreated').prop('checked') ? 'yes' : 'no';
            var welcomemail = $('#welcomemail').prop('checked') ? 'yes' : 'no';
            var accountblocked = $('#accountblocked').prop('checked') ? 'yes' : 'no';
            var accountunblocked = $('#accountunblocked').prop('checked') ? 'yes' : 'no';
            var workorderoverdue = $('#workorderoverdue').prop('checked') ? 'yes' : 'no';
            var workordercompleted = $('#workordercompleted').prop('checked') ? 'yes' : 'no';
            var fileaccepted = $('#fileaccepted').prop('checked') ? 'yes' : 'no';
            var filenotaccepted = $('#filenotaccepted').prop('checked') ? 'yes' : 'no';

            // Erstelle ein JSON-Objekt mit den Einstellungen
            var settingsData = {
                account_created_mail: accountcreated,
                account_created_welcome_mail: welcomemail,
                account_blocked_mail: accountblocked,
                account_unlocked_mail: accountunblocked,
                workorder_overdue_mail: workorderoverdue,
                workorder_completed_mail: workordercompleted,
                file_accepted_mail: fileaccepted,
                file_notaccepted_mail: filenotaccepted,
            };

            // Führe den Ajax-Aufruf aus
            $.ajax({
                url: '{{ route('update-notifications') }}', // Die URL zum Aktualisieren der Einstellungen
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json'
                },
                data: settingsData,
                success: function(response) {
                    if (response.status === 200) { // Überprüfe auf den HTTP-Statuscode
                        // Zeige Erfolgsmeldung und lade die Seite neu
                        swal.fire("Erfolgreich!", response.message, "success").then(() => {
                            // Erzwinge das Neuladen der Seite und umgehe den Cache, indem du die URL änderst
                            window.location.reload();
                        });
                    } else {
                        // Wenn ein Fehler auftritt, zeige Fehlermeldung aus der Antwort an.
                        toastMessage(response.message, 'error');
                    }
                },
                error: function(error) {
                    // Fehlermeldung anzeigen, wenn ein allgemeiner Serverfehler auftritt
                    toastMessage('Es ist ein Serverfehler aufgetreten.', 'error');
                }
            });
        });
    });
</script>
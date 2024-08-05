@extends('backend.layouts.app')

@section('title', '| Allgemeine Einstellungen ')

@section('breadcrumb')
<div class="page-header">
    <h1 class="page-title">Allgemeine Einstellungen</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Pages</a></li>
            <li class="breadcrumb-item active" aria-current="page">Allgemeine Einstellungen</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="row">
<div class="col-md-6">
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Wartungsmodus</h5>
        <form action="{{ route('update-maintenance-mode') }}" method="POST" id="maintenanceForm">
            @csrf
            <div class="mb-3">
                <label for="websiteName" class="form-label">
                    @if($maintenanceMode === 'yes')
                        Wartungsmodus deaktivieren?
                    @else
                        Wartungsmodus aktivieren?
                    @endif
                </label>
                <!-- Füge hier den Switch ein -->
                <label class="switch">
                    <input type="checkbox" id="maintenanceSwitch" @if($maintenanceMode === 'yes') checked @endif>
                    <span class="slider round"></span>
                </label>
            </div>
            <!-- Button am unteren Rand der Karte, rechtsbündig -->
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary" id="updateMaintenanceMode">Speichern</button>
            </div>
        </form>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title d-inline">Webseitename</h5>
            <!-- Fragezeichen-Symbol mit Tooltip -->
            <span class="tooltip-icon" onmouseover="showTooltip('tooltip1')" onmouseout="hideTooltip('tooltip1')">?</span>
    		<div id="tooltip1" class="custom-tooltip">
        <img src="{{ asset('storage/demofiles/tooltip-website-name.jpg') }}" alt="Tooltip Bild">
    		</div>
            <form id="settingsForm">
                <div class="mb-3">
                    <label for="websiteName" class="form-label">Titel der Webseite</label>
                    <input type="text" class="form-control" id="websiteName" name="websiteName" placeholder="Webseitename eingeben" value="{{ $settings->website_name ?? '' }}">
                </div>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary" type="submit" form="settingsForm">Aktualisieren</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="col-md-6">
       <div class="card">
        <div class="card-body">
            <h5 class="card-title">Website Icon</h5>
            <div class="mb-3">
                <label for="icon" class="form-label">Icon auswählen</label>
                <input type="file" class="form-control" id="icon">
        <img id="iconPreview" src="{{ asset('storage/websiteSettings/icon.ico') }}" alt="Icon-Vorschau" class="mt-3" width="30" height="30">
            </div>
			 <div class="d-flex justify-content-end">
               <button id="uploadIconButton" class="btn btn-primary" style="display: none;">Hochladen</button>
				  </div>
        </div>
    </div>
        </div>
  <div class="col-md-6">
    <div class="card">
        <div class="card-body">
            <!-- Flex-Container für Titel und Fragezeichen-Symbol -->
            <div class="d-flex align-items-center mb-2">
                <h5 class="card-title mb-0">Anmeldeseite Logo</h5>
                <!-- Fragezeichen-Symbol mit Tooltip -->
                <span class="tooltip-icon ml-2" onmouseover="showTooltip('tooltip2')" onmouseout="hideTooltip('tooltip2')">?</span>
                <div id="tooltip2" class="custom-tooltip">
                    <img src="{{ asset('storage/demofiles/tooltip-login.jpg') }}" alt="Tooltip Bild">
                </div>
            </div>
            
            <div class="mb-3">
                <label for="logo" class="form-label">Logo auswählen</label>
                <input type="file" class="form-control" id="logo">
                <img id="logoPreview" src="{{ asset('storage/websiteSettings/logo-login.png') }}" alt="Logo-Vorschau" class="mt-3" style="max-width: 300px; max-height: 100px;">
            </div>
            <div class="d-flex justify-content-end">
                <button id="uploadLogoButton" class="btn btn-primary" style="display: none;">Hochladen</button>
            </div>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="card">
        <div class="card-body">
            <!-- Flex-Container für Titel und Fragezeichen-Symbol -->
            <div class="d-flex align-items-center mb-2">
                <h5 class="card-title mb-0">Sidebar Logo geöffnet Hell</h5>
                <!-- Fragezeichen-Symbol mit Tooltip -->
                <span class="tooltip-icon ml-2" onmouseover="showTooltip('tooltip3')" onmouseout="hideTooltip('tooltip3')">?</span>
                <div id="tooltip3" class="custom-tooltip">
                    <img src="{{ asset('storage/demofiles/tooltip-sidebar-opened-dark.jpg') }}" alt="Tooltip Bild">
                </div>
            </div>
            
            <div class="mb-3">
                <label for="sidebaropenwhite" class="form-label">Logo auswählen</label>
                <input type="file" class="form-control" id="sidebaropenwhite">
                <img id="logoPreviewsidebaropenwhite" src="{{ asset('storage/websiteSettings/sidebar_open_white.png') }}" alt="Logo-Vorschau" class="mt-3" style="max-width: 300px; max-height: 100px;">
            </div>
            <div class="d-flex justify-content-end">
                <button id="uploadLogoButtonsidebaropenwhite" class="btn btn-primary" style="display: none;">Hochladen</button>
            </div>
        </div>
    </div>
</div>

<div class="col-md-6">
    <div class="card">
        <div class="card-body">
            <!-- Flex-Container für Titel und Fragezeichen-Symbol -->
            <div class="d-flex align-items-center mb-2">
                <h5 class="card-title mb-0">Sidebar Logo geöffnet dunkel</h5>
                <!-- Fragezeichen-Symbol mit Tooltip -->
                <span class="tooltip-icon ml-2" onmouseover="showTooltip('tooltip4')" onmouseout="hideTooltip('tooltip4')">?</span>
                <div id="tooltip4" class="custom-tooltip">
                    <img src="{{ asset('storage/demofiles/tooltip-sidebar-opened-white.jpg') }}" alt="Tooltip Bild">
                </div>
            </div>
            <div class="mb-3">
                <label for="sidebaropendark" class="form-label">Logo auswählen</label>
                <input type="file" class="form-control" id="sidebaropendark">
               <img id="logoPreviewsidebaropendark" src="{{ asset('storage/websiteSettings/sidebar_open_dark.png') }}" alt="Logo-Vorschau" class="mt-3" style="max-width: 300px; max-height: 100px;">
            </div>
			 <div class="d-flex justify-content-end">
               <button id="uploadLogoButtonsidebaropendark" class="btn btn-primary" style="display: none;">Hochladen</button>
				  </div>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="card">
        <div class="card-body">
            <!-- Flex-Container für Titel und Fragezeichen-Symbol -->
            <div class="d-flex align-items-center mb-2">
                <h5 class="card-title mb-0">Sidebar Logo minimiert hell</h5>
                <!-- Fragezeichen-Symbol mit Tooltip -->
                <span class="tooltip-icon ml-2" onmouseover="showTooltip('tooltip5')" onmouseout="hideTooltip('tooltip5')">?</span>
                <div id="tooltip5" class="custom-tooltip">
                    <img src="{{ asset('storage/demofiles/tooltip-sidebar-closed-dark.jpg') }}" alt="Tooltip Bild">
                </div>
            </div>
            <div class="mb-3">
                <label for="sidebarclosedwhite" class="form-label">Logo auswählen</label>
                <input type="file" class="form-control" id="sidebarclosedwhite">
               <img id="logoPreviewsidebarclosedwhite" src="{{ asset('storage/websiteSettings/sidebar_closed_white.png') }}" alt="Logo-Vorschau" class="mt-3" style="max-width: 300px; max-height: 100px;">
            </div>
			 <div class="d-flex justify-content-end">
               <button id="uploadLogoButtonsidebarclosedwhite" class="btn btn-primary" style="display: none;">Hochladen</button>
				  </div>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="card">
        <div class="card-body">
            <!-- Flex-Container für Titel und Fragezeichen-Symbol -->
            <div class="d-flex align-items-center mb-2">
                <h5 class="card-title mb-0">Sidebar Logo minimiert dunkel</h5>
                <!-- Fragezeichen-Symbol mit Tooltip -->
                <span class="tooltip-icon ml-2" onmouseover="showTooltip('tooltip6')" onmouseout="hideTooltip('tooltip6')">?</span>
                <div id="tooltip6" class="custom-tooltip">
                    <img src="{{ asset('storage/demofiles/tooltip-sidebar-closed-white.jpg') }}" alt="Tooltip Bild">
                </div>
            </div>
            <div class="mb-3">
                <label for="sidebarcloseddark" class="form-label">Logo auswählen</label>
                <input type="file" class="form-control" id="sidebarcloseddark">
               <img id="logoPreviewsidebarcloseddark" src="{{ asset('storage/websiteSettings/sidebar_closed_dark.png') }}" alt="Logo-Vorschau" class="mt-3" style="max-width: 300px; max-height: 100px;">
            </div>
			 <div class="d-flex justify-content-end">
               <button id="uploadLogoButtonsidebarcloseddark" class="btn btn-primary" style="display: none;">Hochladen</button>
				  </div>
        </div>
    </div>
</div>
  <div class="row justify-content-end mt-4">
    <div class="col-md-2">
      <button class="btn btn-danger btn-block" id="restoreBackupButton">Zurücksetzen</button>
    </div>
</div>
</div>
@endsection

<style>
#restoreBackupButton {
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
  background-color: green;
}

input:checked + .slider:before {
  -webkit-transform: translateX(16px); /* Angepasste Verschiebung */
  -ms-transform: translateX(16px);
  transform: translateX(16px);
}

input:not(:checked) + .slider {
  background-color: red;
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
	
}
.tooltip-icon {
    display: inline-block;
    margin-left: 5px;
    cursor: help;
    font-size: 18px;
    position: relative; /* Relativ positionieren */
}

.custom-tooltip {
    display: none;
    position: absolute;
    left: 50px; /* Position etwas rechts vom Fragezeichen */
    top: 50px; /* Leichte vertikale Anpassung */
    border: 1px; /* Blauer, leicht transparenter Rand */
    border-radius: 8px; /* Abgerundete Ecken */
    background-color: rgba(0, 123, 255, 0.5);
    padding: 5px;
    z-index: 1001; /* Z-Index erhöhen */
    white-space: nowrap; /* Verhindert Umbrüche im Tooltip */
}



.custom-tooltip img {
    width: 200px; /* Passen Sie die Größe nach Bedarf an */
}
</style>
@push('scripts')
<script>
function showTooltip(tooltipId) {
    document.getElementById(tooltipId).style.display = 'block';
}

function hideTooltip(tooltipId) {
    document.getElementById(tooltipId).style.display = 'none';
}

//Website Name
document.getElementById('settingsForm').addEventListener('submit', function(e) {
    e.preventDefault();

    var formData = new FormData(this);

    fetch('{{ route('general-settings.update') }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => {
        if (response.status === 200) {
            return response.json();
        } else {
            throw new Error('Serverfehler');
        }
    })
    .then(data => {
        if (data.status === {{ Illuminate\Http\JsonResponse::HTTP_BAD_REQUEST }}) {
            // Wenn der Status ein BAD_REQUEST ist, bedeutet dies, dass websiteName leer ist.
            // Zeige die Fehlermeldung an.
            toastMessage('Webseitename darf nicht leer sein.', 'error');
        } else {
            // Wenn die Einstellungen erfolgreich gespeichert wurden, zeige Erfolgsmeldung an.
            toastMessage('Einstellungen gespeichert!', 'success');
            setTimeout(function() {
                window.location.reload(); // Seite wird neu geladen
            }, 1000); // 1000 Millisekunden entsprechen 1 Sekunde
        }
    })
    .catch(error => {
        // Fehlermeldung anzeigen, wenn ein allgemeiner Serverfehler auftritt
        toastMessage('Webseitename darf nicht leer sein!', 'error');
    });
});


 //Anmeldeseite Logo
let file; 
document.getElementById('logo').addEventListener('change', function(e) {
    const logoPreview = document.getElementById('logoPreview');
    file = e.target.files[0]; // Aktualisiere die 'file'-Variable innerhalb des Event-Handlers
    const uploadLogoButton = document.getElementById('uploadLogoButton');

    if (file) {
        const reader = new FileReader();

        reader.onload = function() {
            logoPreview.style.display = 'block';
            logoPreview.src = reader.result;
            uploadLogoButton.style.display = 'block'; // Zeige den Button, wenn ein Logo ausgewählt wurde
        }

        reader.readAsDataURL(file);
    } else {
        logoPreview.style.display = 'none';
        logoPreview.src = '#';
        uploadLogoButton.style.display = 'none'; // Verstecke den Button, wenn kein Logo ausgewählt ist
    }
});

document.getElementById('uploadLogoButton').addEventListener('click', function() {
    if (file) {
        const formData = new FormData();
        formData.append('logo', file);

        fetch('{{ route('upload-logo') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => {
            if (response.status === 200) {
                return response.json();
            } else {
                throw new Error('Serverfehler');
            }
        })
        .then(data => {
            if (data.success === 200) {
				swal.fire("Erfolgreich!", "Logo erfolgreich hochgeladen und gespeichert. Tipp: Browser Cache löschen!", "success").then(() => {
        // Force browser to reload the page and bypass cache by changing the URL
       window.location.reload();
				 });
            } else {
                // Wenn ein Fehler auftritt, zeige Fehlermeldung an.
                toastMessage(data.message, 'error');
            }
        })
        .catch(error => {
            // Fehlermeldung anzeigen, wenn ein allgemeiner Serverfehler auftritt
            toastMessage('Es ist ein Serverfehler aufgetreten.', 'error');
        });
    }
});


//SidebarIcon White Opened
document.getElementById('sidebaropenwhite').addEventListener('change', function(e) {
    const logoPreview = document.getElementById('logoPreviewsidebaropenwhite');
    file = e.target.files[0]; // Aktualisiere die 'file'-Variable innerhalb des Event-Handlers
    const uploadLogoButton = document.getElementById('uploadLogoButtonsidebaropenwhite');

    if (file) {
        const reader = new FileReader();

        reader.onload = function() {
            logoPreview.style.display = 'block';
            logoPreview.src = reader.result;
            uploadLogoButton.style.display = 'block'; // Zeige den Button, wenn ein Logo ausgewählt wurde
        }

        reader.readAsDataURL(file);
    } else {
        logoPreview.style.display = 'none';
        logoPreview.src = '#';
        uploadLogoButton.style.display = 'none'; // Verstecke den Button, wenn kein Logo ausgewählt ist
    }
});

document.getElementById('uploadLogoButtonsidebaropenwhite').addEventListener('click', function() {
    if (file) {
        const formData = new FormData();
        formData.append('sidebaropenwhite', file);

        fetch('{{ route('upload-logosidebaropenwhite') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => {
            if (response.status === 200) {
                return response.json();
            } else {
                throw new Error('Serverfehler');
            }
        })
        .then(data => {
            if (data.success === 200) {
           swal.fire("Erfolgreich!", "Logo erfolgreich hochgeladen und gespeichert. Tipp: Browser Cache löschen!", "success").then(() => {
        // Force browser to reload the page and bypass cache by changing the URL
                 window.location.reload();
    });
            } else {
                // Wenn ein Fehler auftritt, zeige Fehlermeldung an.
                toastMessage(data.message, 'error');
            }
        })
        .catch(error => {
            // Fehlermeldung anzeigen, wenn ein allgemeiner Serverfehler auftritt
            toastMessage('Es ist ein Serverfehler aufgetreten.', 'error');
        });
    }
});

//SidebarIcon Dark Opened
document.getElementById('sidebaropendark').addEventListener('change', function(e) {
    const logoPreview = document.getElementById('logoPreviewsidebaropendark');
    file = e.target.files[0]; // Aktualisiere die 'file'-Variable innerhalb des Event-Handlers
    const uploadLogoButton = document.getElementById('uploadLogoButtonsidebaropendark');

    if (file) {
        const reader = new FileReader();

        reader.onload = function() {
            logoPreview.style.display = 'block';
            logoPreview.src = reader.result;
            uploadLogoButton.style.display = 'block'; // Zeige den Button, wenn ein Logo ausgewählt wurde
        }

        reader.readAsDataURL(file);
    } else {
        logoPreview.style.display = 'none';
        logoPreview.src = '#';
        uploadLogoButton.style.display = 'none'; // Verstecke den Button, wenn kein Logo ausgewählt ist
    }
});

document.getElementById('uploadLogoButtonsidebaropendark').addEventListener('click', function() {
    if (file) {
        const formData = new FormData();
        formData.append('sidebaropendark', file);

        fetch('{{ route('upload-logosidebaropendark') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => {
            if (response.status === 200) {
                return response.json();
            } else {
                throw new Error('Serverfehler');
            }
        })
        .then(data => {
            if (data.success === 200) {
                swal.fire("Erfolgreich!", "Logo erfolgreich hochgeladen und gespeichert. Tipp: Browser Cache löschen!", "success").then(() => {
        // Force browser to reload the page and bypass cache by changing the URL
       window.location.reload();
				 });
            } else {
                // Wenn ein Fehler auftritt, zeige Fehlermeldung an.
                toastMessage(data.message, 'error');
            }
        })
        .catch(error => {
            // Fehlermeldung anzeigen, wenn ein allgemeiner Serverfehler auftritt
            toastMessage('Es ist ein Serverfehler aufgetreten.', 'error');
        });
    }
});

//SidebarIcon White closed
document.getElementById('sidebarclosedwhite').addEventListener('change', function(e) {
    const logoPreview = document.getElementById('logoPreviewsidebarclosedwhite');
    file = e.target.files[0]; // Aktualisiere die 'file'-Variable innerhalb des Event-Handlers
    const uploadLogoButton = document.getElementById('uploadLogoButtonsidebarclosedwhite');

    if (file) {
        const reader = new FileReader();

        reader.onload = function() {
            logoPreview.style.display = 'block';
            logoPreview.src = reader.result;
            uploadLogoButton.style.display = 'block'; // Zeige den Button, wenn ein Logo ausgewählt wurde
        }

        reader.readAsDataURL(file);
    } else {
        logoPreview.style.display = 'none';
        logoPreview.src = '#';
        uploadLogoButton.style.display = 'none'; // Verstecke den Button, wenn kein Logo ausgewählt ist
    }
});

document.getElementById('uploadLogoButtonsidebarclosedwhite').addEventListener('click', function() {
    if (file) {
        const formData = new FormData();
        formData.append('sidebarclosedwhite', file);

        fetch('{{ route('upload-logosidebarclosedwhite') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => {
            if (response.status === 200) {
                return response.json();
            } else {
                throw new Error('Serverfehler');
            }
        })
        .then(data => {
            if (data.success === 200) {
               swal.fire("Erfolgreich!", "Logo erfolgreich hochgeladen und gespeichert. Tipp: Browser Cache löschen!", "success").then(() => {
        // Force browser to reload the page and bypass cache by changing the URL
        window.location.reload();
				 });
            } else {
                // Wenn ein Fehler auftritt, zeige Fehlermeldung an.
                toastMessage(data.message, 'error');
            }
        })
        .catch(error => {
            // Fehlermeldung anzeigen, wenn ein allgemeiner Serverfehler auftritt
            toastMessage('Es ist ein Serverfehler aufgetreten.', 'error');
        });
    }
});

//SidebarIcon Dark closed
document.getElementById('sidebarcloseddark').addEventListener('change', function(e) {
    const logoPreview = document.getElementById('logoPreviewsidebarcloseddark');
    file = e.target.files[0]; // Aktualisiere die 'file'-Variable innerhalb des Event-Handlers
    const uploadLogoButton = document.getElementById('uploadLogoButtonsidebarcloseddark');

    if (file) {
        const reader = new FileReader();

        reader.onload = function() {
            logoPreview.style.display = 'block';
            logoPreview.src = reader.result;
            uploadLogoButton.style.display = 'block'; // Zeige den Button, wenn ein Logo ausgewählt wurde
        }

        reader.readAsDataURL(file);
    } else {
        logoPreview.style.display = 'none';
        logoPreview.src = '#';
        uploadLogoButton.style.display = 'none'; // Verstecke den Button, wenn kein Logo ausgewählt ist
    }
});

document.getElementById('uploadLogoButtonsidebarcloseddark').addEventListener('click', function() {
    if (file) {
        const formData = new FormData();
        formData.append('sidebarcloseddark', file);

        fetch('{{ route('upload-logosidebarcloseddark') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => {
            if (response.status === 200) {
                return response.json();
            } else {
                throw new Error('Serverfehler');
            }
        })
        .then(data => {
            if (data.success === 200) {
               swal.fire("Erfolgreich!", "Logo erfolgreich hochgeladen und gespeichert. Tipp: Browser Cache löschen!", "success").then(() => {
        // Force browser to reload the page and bypass cache by changing the URL
       window.location.reload();
				 });
            } else {
                // Wenn ein Fehler auftritt, zeige Fehlermeldung an.
                toastMessage(data.message, 'error');
            }
        })
        .catch(error => {
            // Fehlermeldung anzeigen, wenn ein allgemeiner Serverfehler auftritt
            toastMessage('Es ist ein Serverfehler aufgetreten.', 'error');
        });
    }
});
	//Icon Hochladen
	document.getElementById('icon').addEventListener('change', function(e) {
    const IconPreview = document.getElementById('iconPreview');
    file = e.target.files[0]; // Aktualisiere die 'file'-Variable innerhalb des Event-Handlers
    const uploadIconButton = document.getElementById('uploadIconButton');

    if (file) {
        const reader = new FileReader();

        reader.onload = function() {
            IconPreview.style.display = 'block';
            IconPreview.src = reader.result;
            uploadIconButton.style.display = 'block'; // Zeige den Button, wenn ein Logo ausgewählt wurde
        }

        reader.readAsDataURL(file);
    } else {
        IconPreview.style.display = 'none';
        IconPreview.src = '#';
        uploadIconButton.style.display = 'none'; // Verstecke den Button, wenn kein Logo ausgewählt ist
    }
});

document.getElementById('uploadIconButton').addEventListener('click', function() {
    if (file) {
        const formData = new FormData();
        formData.append('icon', file);

        fetch('{{ route('upload-icon') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => {
            if (response.status === 200) {
                return response.json();
            } else {
                throw new Error('Serverfehler');
            }
        })
        .then(data => {
            if (data.success === 200) {
               swal.fire("Erfolgreich!", "Icon erfolgreich hochgeladen!", "success").then(() => {
        // Force browser to reload the page and bypass cache by changing the URL
        window.location.reload();
				    });
            } else {
                // Wenn ein Fehler auftritt, zeige Fehlermeldung an.
                toastMessage(data.message, 'error');
            }
        })
        .catch(error => {
            // Fehlermeldung anzeigen, wenn ein allgemeiner Serverfehler auftritt
            toastMessage('Es ist ein Serverfehler aufgetreten.', 'error');
        });
    }
});
// Safetybackup wiederherstellen
function restoreBackup() {
    swal.fire({
        title: "Sicherheitskopie wiederherstellen",
        text: "Möchtest du die Sicherheitskopie wirklich wiederherstellen?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ja, wiederherstellen!",
        cancelButtonText: "Abbrechen",
    }).then((result) => {
        if (result.value) {
            axios.post('/settings/restore-backup', {
                _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            })
            .then(response => {
                if(response.status === 200){
                 swal.fire("Erfolgreich!", "Die Sicherheitskopie wurde erfolgreich wiederhergestellt.", "success").then(() => {
        // Force browser to reload the page and bypass cache by changing the URL
        window.location.href = window.location.href + "?nocache=" + new Date().getTime();
    });
                }
            })
            .catch(error => {
                swal.fire("Fehler!", "Ein Fehler ist aufgetreten: " + (error.response.data.message || error.message), "error");
            });
        }
    });
}

document.addEventListener('DOMContentLoaded', (event) => {
    const restoreButton = document.getElementById('restoreBackupButton');
    if (restoreButton) {
        restoreButton.addEventListener('click', function() {
            restoreBackup();
        });
    }
});
	
function updateMaintenanceMode() {
    const maintenanceSwitch = document.getElementById('maintenanceSwitch');
    const updateButton = document.getElementById('updateMaintenanceMode');
    const maintenanceForm = document.getElementById('maintenanceForm');

    updateButton.addEventListener('click', function(event) {
        event.preventDefault(); // Verhindert das Standardverhalten des Submit-Buttons
        const maintenanceMode = maintenanceSwitch.checked ? 'yes' : 'no';

        // Definieren Sie die Meldungstexte basierend auf dem Zustand des Switches
        let successMessage, errorMessage;

        if (maintenanceMode === 'yes') {
            successMessage = "Wartungsmodus aktiviert!";
            errorMessage = "Fehler beim Aktivieren des Wartungsmodus!";
        } else {
            successMessage = "Wartungsmodus deaktiviert!";
            errorMessage = "Fehler beim Deaktivieren des Wartungsmodus!";
        }

        // AJAX-Anfrage senden
fetch(maintenanceForm.getAttribute('action'), {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': maintenanceForm.querySelector('input[name="_token"]').value
    },
    body: JSON.stringify({ maintenance_mode: maintenanceMode })
})
.then(response => {
    if (response.ok) {
        return response.json();
    } else {
        throw new Error('Network response was not ok');
    }
})
.then(data => {
    if (data.success) {
        swal.fire("Erfolgreich!", successMessage, "success").then(() => {
            // Force browser to reload the page and bypass cache by changing the URL
            window.location.reload();
        });
    } else {
        swal.fire("Fehler!", errorMessage, "error");
    }
})
.catch(error => {
    console.error('Fehler beim Speichern des Wartungsmodus:', error);
    swal.fire("Fehler!", errorMessage, "error");
});
    });
}

// Die Funktion wird nur bei Klick auf den Button mit der ID "updateMaintenanceMode" aufgerufen
updateMaintenanceMode();

</script>
@endpush
@extends('backend.layouts.app')

@section('title', '| File Manager ')

@section('breadcrumb')
     <div class="page-header">
                            <h1 class="page-title">Datei Manager</h1>
                            <div>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Datei Manager</li>
                                </ol>
                            </div>
                        </div>
@endsection

@section('content')
  <!-- Row -->
                        <div class="row row-sm">
                            <div class="col-md-5 col-lg-5 col-xl-3">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <button class="btn btn-primary btn-block" data-bs-target="#createfile" data-bs-toggle="modal"><i class="fe fe-plus me-1"></i> Datei hochladen</button>
                                    </div>
</div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <a href="javascript:void(0)" class="file-manager-image"><img src="https://laravelui.spruko.com/sash/build/assets/images/media/folder1.png" alt="img"></a>
                                            <h3 class="ms-3 mt-5 fw-semibold">{{ $fileCount }} {{ $fileCount == 1 ? 'Datei' : 'Dateien' }}</h3>
                                        </div>
                                        <div class="progress progress-xs mb-3">
                                             @php
            $progressBarClass = 'bg-success'; // Grün für weniger als 30 GB
            if ($totalBytesUsed > 30 * 1024 * 1024 * 1024) {
                $progressBarClass = 'bg-warning'; // Gelb für über 30 GB
            }
            if ($totalBytesUsed > 100 * 1024 * 1024 * 1024) {
                $progressBarClass = 'bg-danger'; // Rot für über 100 GB
            }
        @endphp
        <div class="progress-bar {{ $progressBarClass }}" style="width: {{ $progressPercentage }}%;"></div>
                                        </div>
                                        <div class="">
                                            <div class="d-flex">
                                                <div class="d-flex">
                                                    <div>
                                                        <h6 class="mt-2"><i class="fe fe-circle text-success fs-12"></i> Totaler Speicherplatz</h6>
                                                        <span class="text-muted">128 GB</span>
                                                    </div>
                                                </div>
                                                <div class="ms-auto my-auto">
                                                    <h6 class="mt-2"><i class="fe fe-circle text-danger fs-12"></i> Benutzt</h6>
                                                    <span class="text-muted">{{ $displaySize }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
 <div class="col-md-7 col-lg-7 col-xl-9">
    <div class="row row-sm">
        <div class="d-flex align-items-center mb-2 ms-1">
            <div class="fs-20 fw-semibold text-dark">Alle Ordner</div>
              @php
    $userType = auth()->user()->user_type; // Holt den 'user_type' des eingeloggten Benutzers
    $canAddFolder = \App\Models\RoleAndAccess::where('role_name', $userType)
                                            ->where('can_create_folders', 'yes')
                                            ->exists(); // Überprüft, ob der Benutzer das Recht hat, Aufgaben zu erstellen
@endphp
            @if($canAddFolder)
            <button class="btn btn-primary ms-2" data-act="ajax-modal"
    data-action-url="{{ route('filemanager.create') }}" data-title="Neuen Ordner erstellen">
    <i class="bi bi-plus-lg"></i>
</button>
@endif
        </div>
		 <!-- DIESEN CODE IST FÜR DIE ORDNER IN DIE MAN DIE DATEI VERSCHIEBEN LASSEN KÖNNEN SOLL -->
   @foreach ($folders as $folder)
    <div class="col-xl-4 col-xxl-3 col-lg-6 col-md-6 col-sm-6">
         <div class="folder-container scale-up" data-folder-name="{{ $folder->folder_name }}">
        <div class="card pos-relative">
            <div class="card-body px-4 pt-4 pb-2">
                <div class="d-flex">
                        @if ($folder->folder_type == 'video blau')
                         <span class="bg-primary-transparent border border-primary brround">
                            <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                                            <path fill="#645acf" d="M9.3 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4H10L12 6H20C21.1 6 22 6.9 22 8V14.6C20.6 13.6 18.9 13 17 13C13.5 13 10.4 15.1 9.1 18.3L8.8 19L9.1 19.7C9.2 19.8 9.2 19.9 9.3 20M23 19C22.1 21.3 19.7 23 17 23S11.9 21.3 11 19C11.9 16.7 14.3 15 17 15S22.1 16.7 23 19M19.5 19C19.5 17.6 18.4 16.5 17 16.5S14.5 17.6 14.5 19 15.6 21.5 17 21.5 19.5 20.4 19.5 19M17 18C16.4 18 16 18.4 16 19S16.4 20 17 20 18 19.6 18 19 17.6 18 17 18" />
                                                        </svg>
                                                        </span>
                        @elseif ($folder->folder_type == 'video gelb')
                        <span class="bg-warning-transparent border border-warning brround">
                            <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                                            <path fill="#645acf" d="M9.3 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4H10L12 6H20C21.1 6 22 6.9 22 8V14.6C20.6 13.6 18.9 13 17 13C13.5 13 10.4 15.1 9.1 18.3L8.8 19L9.1 19.7C9.2 19.8 9.2 19.9 9.3 20M23 19C22.1 21.3 19.7 23 17 23S11.9 21.3 11 19C11.9 16.7 14.3 15 17 15S22.1 16.7 23 19M19.5 19C19.5 17.6 18.4 16.5 17 16.5S14.5 17.6 14.5 19 15.6 21.5 17 21.5 19.5 20.4 19.5 19M17 18C16.4 18 16 18.4 16 19S16.4 20 17 20 18 19.6 18 19 17.6 18 17 18" />
                                                        </svg>
                                                        </span>
                          @elseif ($folder->folder_type == 'pdf blau')
                                                 <span class="bg-primary-transparent border border-primary brround">
                            <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                                            <path fill="#f7b731" d="M19,20H4C2.89,20 2,19.1 2,18V6C2,4.89 2.89,4 4,4H10L12,6H19A2,2 0 0,1 21,8H21L4,8V18L6.14,10H23.21L20.93,18.5C20.7,19.37 19.92,20 19,20Z" />
                                                        </svg>
                                                        </span>
                         @elseif ($folder->folder_type == 'pdf gelb')
                        <span class="bg-warning-transparent border border-warning brround">
                            <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                                            <path fill="#f7b731" d="M19,20H4C2.89,20 2,19.1 2,18V6C2,4.89 2.89,4 4,4H10L12,6H19A2,2 0 0,1 21,8H21L4,8V18L6.14,10H23.21L20.93,18.5C20.7,19.37 19.92,20 19,20Z" />
                                                        </svg>
                                                        </span>
                        @endif
                    </span>
                    <div class="ms-auto mt-1 file-dropdown">
                        <a href="javascript:void(0)" class="text-muted" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical fs-18"></i></a>
                        <div class="dropdown-menu dropdown-menu-start">
                           <a data-act="ajax-modal" 
                                data-action-url="{{ route('filemanager.edit', $folder->id) }}" 
                                data-title="Ordner Bearbeiten - {{ $folder->folder_name }}" 
                                class="dropdown-item">
                                <i class="fe fe-edit me-2"></i> Bearbeiten
                            </a>
                            <a class="dropdown-item" href="javascript:void(0)"><i class="fe fe-download me-2"></i> Download</a>
                            <a class="dropdown-item" href="javascript:void(0)" 
                       onclick="confirmFolderDeletion('{{ $folder->folder_name }}', '{{ route('folder.deleteByName', $folder->folder_name) }}')">
                        <i class="fe fe-trash me-2"></i> Löschen
                    </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer border-top-0">
                <div class="d-flex">
                    <div>
                         <a href="{{ route('folder.view', ['folderName' => $folder->folder_name]) }}">
                            <h5 class="text-primary">{{ $folder->folder_name }}</h5>
                        </a>
                        <p class="text-muted fs-13 mb-0">35 Dateien</p>
                    </div>
                    <div class="ms-auto mt-4">
                        <h6 class="">23 MB</h6>
                                        </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endforeach
<div class="text-dark mb-2 ms-1 fs-20 fw-semibold">Alle Dateien</div>
<div class="row row-sm" style="cursor: pointer;">
    @forelse ($allfiles as $file)
        <div class="col-xl-4 col-xxl-3 col-lg-6 col-md-6 col-sm-6">
            <div class="card overflow-hidden file scale-up" draggable="true" data-file-id="{{ $file->id }}">
                <div class="mx-auto my-3">
                    <a href="{{ route('file.redirect', ['fileName' => $file->file_name]) }}" class="mx-auto my-3">
                        <img src="https://laravelui.spruko.com/sash/build/assets/images/media/files/pdf.png" alt="img">
                    </a>
                </div>
                <div class="card-footer">
                    <div class="d-flex">
                        <div class="">
                           <h5 class="mb-0 fw-semibold text-break" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $file->file_name }}">
    {{ Str::limit($file->file_name, 10, '') }}
</h5>
                        </div>
                        <div class="ms-auto my-auto">
                            <span class="text-muted mb-0">{{ \App\Helpers\CalculateFileSize::formatSizeUnits($file->file_size) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <p>Keine Dateien vorhanden.</p>
        </div>
    @endforelse
</div>
</div>
 
           <!-- Modal -->
<div class="modal" id="createfile">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Neue Datei Hochladen</h6>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
            </div>
            <div class="modal-body">
                <!-- Beginn des Formulars für den Datei-Upload -->
                <form action="{{ route('filemanager.upload') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <!-- Datei-Auswahl -->
                    <div>
                       <input id="demo" type="file" name="file" accept=".pdf"multiple>
                    </div>
                    <!-- Hochladen-Button -->
                    <div class="modal-footer">
                        <button class="btn ripple btn-danger" data-bs-dismiss="modal" type="button">Abbrechen</button>
                    </div>
                </form>
                <!-- Ende des Formulars -->
            </div>
        </div>
    </div>
</div>
<!-- Ende Modal -->



                    </div>
                </div>
            </div>
            <!-- END MAIN-CONTENT -->
@endsection

<script>

 document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
document.addEventListener('DOMContentLoaded', function () {
    // Funktion zum Verarbeiten des Drag-Start-Ereignisses für Dateien
    function handleDragStart(e) {
        e.dataTransfer.setData('text/plain', e.target.getAttribute('data-file-id'));
    }

   function moveToFolder(fileId, folderName) {
    fetch('/move-file-to-folder', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({fileId, folderName})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            toastMessage('Datei erfolgreich verschoben!', 'success');
        } else {
            if (data.errorType === 'alreadyInFolder') {
                toastMessage('Die Datei ist bereits in diesem Ordner!', 'warning');
            } else if (data.errorType === 'notFound') {
                toastMessage('Fehler beim Verschiebevorgang!', 'error');
            } else {
                toastMessage('Unbekannter Fehler', 'error');
            }
        }
    }).catch(error => {
        console.error('Fehler bei der Anfrage:', error);
        toastMessage('Fehler bei der Anfrage', 'error');
    });
}

    // Event-Listener für Drag-Start zu den Dateien hinzufügen
    document.querySelectorAll('.file').forEach(file => {
        file.addEventListener('dragstart', handleDragStart, false);
    });

    // Event-Listener für Mouseover, Drag-Enter und Drag-Leave zu den Ordnern hinzufügen
    document.querySelectorAll('.folder-container').forEach(folderContainer => {
        folderContainer.addEventListener('mouseover', function () {
            // Remove the line with 'classList.add('scale-up')'
        }, false);

        folderContainer.addEventListener('mouseleave', function () {
            // Remove the line with 'classList.remove('scale-up')'
        }, false);

        folderContainer.addEventListener('dragenter', function (e) {
            e.preventDefault();
            // Remove the line with 'classList.add('scale-up')'
        }, false);

        folderContainer.addEventListener('dragleave', function (e) {
            e.preventDefault();
            // Remove the line with 'classList.remove('scale-up')'
        }, false);

        folderContainer.addEventListener('dragover', function (e) {
            e.preventDefault();
        }, false);

        folderContainer.addEventListener('drop', function (e) {
            e.preventDefault();
            // Remove the line with 'classList.remove('scale-up')'
            const folderName = this.getAttribute('data-folder-name');
            const fileId = e.dataTransfer.getData('text/plain');
            moveToFolder(fileId, folderName);
        }, false);
    });
});

function confirmFolderDeletion(folderName, url) {
    swal.fire({
        title: "Bist du sicher?",
        text: "Möchtest du den Ordner " + folderName + " löschen? (Dateien bleiben erhalten!)",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ja, löschen!",
        cancelButtonText: "Abbrechen",
    }).then((result) => {
        if (result.value) {
            axios.delete(url)
                .then(response => {
                    if(response.status === 200){
                        toastMessage('Ordner ' + folderName + ' wurde erfolgreich gelöscht!', 'success');
                        window.location.reload();
                    }
                })
                .catch(error => {
                    swal.fire("Fehler!", "Ein Fehler ist aufgetreten: " + error.response.data.message, "error");
                });
        }
    });
}
</script>


<style>
.custom-cursor {
    cursor: pointer;
}
.tooltip {
    z-index: 1050; /* Setzen Sie einen Wert, der für Ihr Layout geeignet ist */
}
.scale-up {
    transition: transform 0.2s ease;
}

.scale-up:hover {
     box-shadow: 0px 0px 15px rgba(0, 123, 255, 0.6); /* Leichter blauer Schatten */
    transition: box-shadow 0.3s ease;
}
</style>

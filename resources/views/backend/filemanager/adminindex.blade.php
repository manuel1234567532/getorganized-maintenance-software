@extends('backend.layouts.app')

@section('title', '| Dateien')

@section('breadcrumb')
    <div class="page-header">
        <h1 class="page-title">Dateien</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('messages.dashboard') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dateien</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <h3 class="card-title font-weight-bold">Dateien</h3>
            
             <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createfile">
        <i class="ri-add-fill"></i> Neue Datei hinzufügen
    </button>
        </div>
 <!-- Modal -->
<div class="modal" id="createfile">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Neue Datei Hochladen</h6>
                <!-- Button entfernt -->
            </div>
            <div class="modal-body">
                <!-- Beginn des Formulars für den Datei-Upload -->
                <form action="{{ route('filemanager.upload') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <!-- Datei-Auswahl -->
                    <div>
                        <input id="demo" type="file" name="file" accept=".pdf" multiple>
                    </div>
                    <!-- Hochladen-Button (Abbrechen-Button) -->
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
        <div class="card-body">
            <div class="table-responsive">
                <table id="files_datatable" class="table table-bordered text-nowrap key-buttons border-bottom">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">#</th>
                            <th class="border-bottom-0">Dateiname</th>
                            <th class="border-bottom-0">Dateigröße</th>
                            <th class="border-bottom-0">Aktueller Ordner</th>
                            <th class="border-bottom-0">Hochgeladen von</th>
                            <th class="border-bottom-0">Status</th>
                            <th class="border-bottom-0">{{ __('messages.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $('#files_datatable').DataTable({
                ajax: '{{ route('files-datatable') }}', // Ändern Sie dies entsprechend Ihrer Route
                processing: true,
                serverSide: true,
                scrollX: false,
                autoWidth: true,
                columns: [
                    {
                         data: 'DT_RowIndex',
                        name: 'id'
                    },
                    {
                        data: 'file_name',
                        name: 'file_name'
                    },
                    {
                         data: 'file_size',
                        name: 'file_size'
                    },
                    {
                         data: 'current_folder',
                        name: 'current_folder'
                    },
                    {
                         data: 'uploaded_by',
                        name: 'uploaded_by'
                    },
                    {
                          data: 'status',
                        name: 'status'
                    },
                    {
                         data: 'actions',
                    name: 'actions',
                    orderable: true,
                    searchable: true
                }
            ],
                       language: {
                search: "Suchen:",
                searchPlaceholder: "Suche...",
                lengthMenu: "_MENU_ Einträge pro Seite anzeigen",
                zeroRecords: "Keine Einträge gefunden",
                info: "Zeige Seite _PAGE_ von _PAGES_",
                infoEmpty: "Keine Einträge verfügbar",
                infoFiltered: "(gefiltert von _MAX_ gesamten Einträgen)",
                paginate: {
                    first:      "Erste",
                    last:       "Letzte",
                    next:       "Nächste",
                    previous:   "Vorherige"
                },
                aria: {
                    sortAscending:  ": aktivieren, um Spalte aufsteigend zu sortieren",
                    sortDescending: ": aktivieren, um Spalte absteigend zu sortieren"
                }
            }
        });
    });
</script>
@endpush
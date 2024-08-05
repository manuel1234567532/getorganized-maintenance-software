@extends('backend.layouts.app')

@section('title', '| Kategorien ')

@section('breadcrumb')
    <div class="page-header">
        <h1 class="page-title">Maschinen Kategorien</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('messages.dashboard') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Kategorien</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <h3 class="card-title font-weight-bold">Kategorien</h3>
                <button type="button" class="btn mb-3 dark-icon btn-primary" data-act="ajax-modal" data-method="get"
                    data-action-url="{{ route('machine-types.create') }}" data-title="Neuen Maschinentyp hinzufügen">
                    <i class="ri-add-fill"></i> {{ __('messages.Add Machine') }}
                </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="machine_type_datatable" class="table table-bordered text-nowrap key-buttons border-bottom">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">#</th>
                            <th class="border-bottom-0">Name</th>
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
            $('#machine_type_datatable').DataTable({
                ajax: '{{ route('machine-types-datatable') }}',
                processing: true,
                serverSide: true,
                scrollX: false,
                autoWidth: true,
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
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
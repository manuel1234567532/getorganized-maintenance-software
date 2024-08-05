@extends('backend.layouts.app')

@section('title', '| Ersatzteile')

@section('breadcrumb')
    <div class="page-header">
        <h1 class="page-title">Alle Ersatzteile Instandhaltung Klagenfurt</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('messages.dashboard') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ersatzteile</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <h3 class="card-title font-weight-bold">Ersatzteile</h3>
            @php
    $userType = auth()->user()->user_type; // Holt den 'user_type' des eingeloggten Benutzers
    $canAddSpareparts = \App\Models\RoleAndAccess::where('role_name', $userType)
                                            ->where('can_create_sparepart', 'yes')
                                            ->exists(); // Überprüft, ob der Benutzer das Recht hat, Aufgaben zu erstellen
@endphp
            @if($canAddSpareparts)
                <button type="button" class="btn mb-3 dark-icon btn-primary" data-act="ajax-modal" data-method="get"
                    data-action-url="{{ route('spareparts.create') }}" data-title="Neues Ersatzteil hinzufügen">
                    <i class="ri-add-fill"></i> Ersatzteile erstellen
                </button>
            @endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="sparepart_datatable" class="table table-bordered text-nowrap key-buttons border-bottom">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">#</th>
                            <th class="border-bottom-0">ERSATZTEILNUMMER</th>
                            <th class="border-bottom-0">Bezeichnung</th>
                            <th class="border-bottom-0">LIEFERANT</th>
                            <th class="border-bottom-0">Lagerplatz</th>
                            <th class="border-bottom-0">Bestand</th>
                            <th class="border-bottom-0">Mindestbestand</th>
                            <th class="border-bottom-0">Preis pro Stück</th>
                            <th class="border-bottom-0">Gesamtpreis</th>
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
            $('#sparepart_datatable').DataTable({
                ajax: '{{ route('spareparts-datatable') }}',
                processing: true,
                serverSide: true,
                scrollX: false,
                autoWidth: true,
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id'
                    },
                    {
                        data: 'spare_part_number',
                        name: 'spare_part_number'
                    },
                    {
                        data: 'name_of_part',
                        name: 'name_of_part'
                    },
                    {
                        data: 'supplier',
                        name: 'supplier'
                    },
                    {
                        data: 'location',
                        name: 'location'
                    },
                    {
                        data: 'current_stock',
                        name: 'current_stock'
                    },
                    {
                        data: 'minimum_stock',
                        name: 'minimum_stock'
                    },
                    {
                        data: 'price_per_piece',
                        name: 'price_per_piece'
                    },
                    {
                        data: 'total_price',
                        name: 'total_price'
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
@extends('backend.layouts.app')

@section('title', '| Benutzers')

@section('breadcrumb')
    <div class="page-header">
        <h1 class="page-title">{{ __('messages.Users List') }}</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('messages.dashboard') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('messages.users') }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <h3 class="card-title font-weight-bold">{{ __('messages.users') }}</h3>
           
                <button type="button" class="btn mb-3 dark-icon btn-primary" data-act="ajax-modal" data-method="get"
                    data-action-url="{{ route('users.create') }}" data-title="Neuen Benutzer hinzufügen">
                    <i class="ri-add-fill"></i> {{ __('messages.Add User') }}
                </button>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="users_datatable" class="table table-bordered text-nowrap key-buttons border-bottom">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">#</th>
                            <th class="border-bottom-0">Benutzername</th>
                            <th class="border-bottom-0">Email</th>
                            <th class="border-bottom-0">Vorname</th>
                            <th class="border-bottom-0">Nachname</th>
                            <th class="border-bottom-0">Geburtstag</th>
                            <th class="border-bottom-0">Abteilung</th>
                            <th class="border-bottom-0">Rolle</th>
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
            $('#users_datatable').DataTable({
                ajax: '{{ route('users-datatable') }}',
                processing: true,
                serverSide: true,
                scrollX: false,
                autoWidth: true,
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id'
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                          data: 'first_name',
                        name: 'first_name'
                    },
                    {
                          data: 'last_name',
                        name: 'last_name'
                    },
                    {
                          data: 'birthday',
                        name: 'birthday'
                    },
                    {
                          data: 'department',
                        name: 'department'
                    },
                    {
                        data: 'user_type',
                        name: 'user_type'
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
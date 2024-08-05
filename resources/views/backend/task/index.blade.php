@extends('backend.layouts.app')

@section('title', '| Aufgabe')

@section('breadcrumb')
    <div class="page-header">
        <h1 class="page-title">Aufgabenliste</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('messages.dashboard') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Aufgabe</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="row">
 <!-- Offene Tickets -->
 <div class="col-sm-6 col-lg-6 col-md-12 col-xl-3">
                                <div class="card">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="bi bi-ticket-img-absolute circle-icon bg-danger align-items-center text-center box-danger-shadow bradius">
                                                <img src="https://laravelui.spruko.com/sash/build/assets/images/svgs/circle.svg" alt="img" class="card-img-absolute">
                                                <i class="lnr lnr-alarm fs-30 text-white mt-4"></i>
                                            </div>
                                        </div>
                                        <div class="col-8">
                                            <div class="card-body p-4">
                                                <h2 class="mb-2 fw-normal mt-2">{{ $openTasksCount }}</h2>
                                                <h5 class="fw-normal mb-0">{{ __('messages.total_tasks') }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
		
		        <!-- In Bearbeitung -->
 <div class="col-sm-6 col-lg-6 col-md-12 col-xl-3">
                                <div class="card">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="card-img-absolute circle-icon bg-primary text-center align-self-center box-primary-shadow bradius">
                                                <img src="https://laravelui.spruko.com/sash/build/assets/images/svgs/circle.svg" alt="img" class="card-img-absolute">
                                                <i class="lnr lnr-pencil fs-30  text-white mt-4"></i>
                                            </div>
                                        </div>
                                        <div class="col-8">
                                            <div class="card-body p-4">
                                                <h2 class="mb-2 fw-normal mt-2">{{ $inProgressTasksCount }}</h2>
                                                <h5 class="fw-normal mb-0">{{ __('messages.tasks_in_progress') }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

		 <!-- Bereits abgeschlossen -->
    <div class="col-sm-6 col-lg-6 col-md-12 col-xl-3">
                                <div class="card">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="card-img-absolute circle-icon bg-secondary align-items-center text-center box-secondary-shadow bradius">
                                                <img src="https://laravelui.spruko.com/sash/build/assets/images/svgs/circle.svg" alt="img" class="card-img-absolute">
                                                <i class="lnr lnr-checkmark-circle fs-30 text-white mt-4"></i>
                                            </div>
                                        </div>
                                        <div class="col-8">
                                            <div class="card-body p-4">
                                                <h2 class="mb-2 fw-normal mt-2">{{ $completedTasksCount }}</h2>
                                                <h5 class="fw-normal mb-0">{{ __('messages.finished_tasks') }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
    <div class="card">
        <div class="card-header justify-content-between">
            <h3 class="card-title font-weight-bold">Aufgabe</h3>
            @php
    $userType = auth()->user()->user_type; // Holt den 'user_type' des eingeloggten Benutzers
    $canAddTask = \App\Models\RoleAndAccess::where('role_name', $userType)
                                            ->where('can_create_task', 'yes')
                                            ->exists(); // Überprüft, ob der Benutzer das Recht hat, Aufgaben zu erstellen
@endphp
            @if($canAddTask)
    <button type="button" class="btn mb-3 dark-icon btn-primary" data-act="ajax-modal" data-method="get"
        data-action-url="{{ route('tasks.create') }}" data-title="neue Aufgabe hinzufügen">
        <i class="ri-add-fill"></i> Aufgabe hinzufügen
    </button>
@endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tasks_datatable" class="table table-bordered text-nowrap key-buttons border-bottom">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">#</th>
                            <th class="border-bottom-0">Machine</th>
                            <th class="border-bottom-0">Problem</th>
                            <th class="border-bottom-0">Priorität</th>
                            <th class="border-bottom-0">Erstellt von</th>
                            <th class="border-bottom-0">Datum</th>
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
            $('#tasks_datatable').DataTable({
                ajax: '{{ route('tasks-datatable') }}',
                processing: true,
                serverSide: true,
                scrollX: false,
                autoWidth: true,
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id'
                    },
                    {
                        data: 'machine_id',
                        name: 'machine_id'
                    },
                    {
                        data: 'problem',
                        name: 'problem'
                    },
                    {
                        data: 'priority_id',
                        name: 'priority_id'
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
    </script>
@endpush

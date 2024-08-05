@extends('backend.layouts.app')

@section('title', '| Arbeitsaufträge')

@section('breadcrumb')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <div class="page-header">
        <div class="d-flex flex-wrap">
            <h1 class="page-title">Arbeitsaufträge</h1>
            <div class="card">
                <select class="form-control form-select mx-2 select2" id="myDropdown">
                    <option value="#tab5">Liste</option>
                    <option value="#tab6">Kalender</option>
                </select>
            </div>
        </div>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('messages.dashboard') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Arbeitsaufträge</li>
            </ol>
        </div>
    </div>
    <style>
        /* Default button styles */
        .toggle-color {
            background-color: white;
            color: black;
            border: 1px solid black;
            /* Add black border */
        }

        /* Button styles when active */
        .toggle-color.active {
            background-color: rgb(79, 142, 255);
            color: white;
            border: 1px solid rgb(79, 142, 255);
            /* Change border color when active */
        }

        /* Default button styles */
        .toggle-priority {
            color: black;
            border: 1px solid black;
        }

        /* Button styles when active */
        .toggle-priority.active {
            color: white;
        }

        /* Priority colors */
        .toggle-priority[data-value="no"].active {
            background-color: rgb(79, 142, 255);
            border: 1px solid rgb(79, 142, 255);

        }

        .toggle-priority[data-value="low"].active {
            background-color: rgb(19, 191, 166);
            border: 1px solid rgb(19, 191, 166);

        }

        .toggle-priority[data-value="medium"].active {
            background-color: rgb(247, 183, 49);
            border: 1px solid rgb(247, 183, 49);
        }

        .toggle-priority[data-value="high"].active {
            background-color: rgb(232, 38, 70);
            border: 1px solid rgb(232, 38, 70);

        }

        .nav a {
            font-size: 14px
        }

        .start_date_list {
            display: none;
        }

        .img_container {
            display: flex;
            align-items: center;
            justify-content: center;
            /* background-color: gray; */
            border-radius: 50%;
            /* overflow: hidden; */
            width: 64px;
            height: 64px;
            margin-right: 10px;
        }

        @media (max-width:500px) {
            .top_buttons {
                flex-direction: column;
            }

            .top_create_button {
                margin-top: 0.5rem;
            }

            .icon-button {
                width: 131px;
                /* margin: 0 20px; */
            }

            .status_buttons {
                justify-content: center;
            }

            /* .work_order_pic {
                                                width: 50px;
                                                height: 50px !important; */
            /* display: none; */
            /* } */
            .img_container {
                width: 50px;
                height: 50px;
            }

            .start_date_table,
            .startdate_table_hr {
                display: none;
            }

            .start_date_list {
                display: block;
            }

            .fc-daygrid-day-top {
                flex-wrap: wrap !important;
                justify-content: center !important;
            }

        }
    </style>
@endsection

@section('content')
    <div class="selected-tab" id="tab5" style="display: none;">
        <div class="card">
            <div class="card-header justify-content-between d-flex flex-wrap top_buttons">
                <h3 class="card-title font-weight-bold">Arbeitsauftrag</h3>
  @php
    $userType = auth()->user()->user_type; // Holt den 'user_type' des eingeloggten Benutzers
    $canAddWorkOrder = \App\Models\RoleAndAccess::where('role_name', $userType)
                                            ->where('can_create_workorder', 'yes')
                                            ->exists(); // Überprüft, ob der Benutzer das Recht hat, Aufgaben zu erstellen
@endphp
            @if($canAddWorkOrder)
                <a href="{{ route('work-order.create') }}" id="tab3"><button type="button"
                        class="btn mb-3 dark-icon btn-primary top_create_button" data-title="Neues Ersatzteil hinzufügen">
                        <i class="ri-add-fill"></i> Arbeitsauftrag erstellen
                    </button></a>
            @endif
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-4 mt-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="panel panel-primary">
                                <div class="tab-menu-heading">
                                    <div class="tabs-menu1">
                                        <!-- Tabs -->
                                        <ul class="nav panel-tabs">
                                            <li><a href="#tab02" data-bs-toggle="tab">Bevorstehend</a></li>
                                            <li><a href="#tab1" class="active" data-bs-toggle="tab">Fällig</a></li>
                                            <li><a href="#tab2" data-bs-toggle="tab">Abgeschlossen</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body tabs-menu-body pb-0 px-0">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab1">
                                            @foreach ($workOrders as $workOrder)
                                                @php
                                                    $dateRange = $workOrder->schedule_period;
                                                    $dates = explode(' to ', $dateRange);
                                                    $startDate = $dates[0];
                                                    $endDate = $dates[1] ?? $startDate;
                                                    $carbonStartDate = \Carbon\Carbon::parse($startDate);
                                                    // $currentDate = date('Y-m-d');
                                                @endphp

                                                @if ($carbonStartDate->isBefore(now()) && $workOrder->status !== 'completed')
                                                    {{-- @if ($carbonStartDate->isSameDay(now()->addDay()))
                                                    {{ $carbonStartDate }} --}}
                                                    <div class="card" style="cursor: pointer;"
                                                        onclick="fetchWorkOrderName('{{ $workOrder->id }}')">
                                                        <div class="row px-2 py-3">
                                                            <div class="col-3">
                                                                <div class="img_container">
                                                                    <img src="{{ asset('storage/' . $workOrder->image_url) }}"
                                                                        class="" alt="Work Order Image"
                                                                        style="width: 100% !important;
                                                                        height: 100% !important;
                                                                     border-radius: 50%;
                                                                        vertical-align: middle;
                                                                        border-style: none;
                                                                    ">
                                                                </div>
                                                            </div>
															
															
    <div class="col-6 px-xxl-0">
    <div class="card-body p-0">
        <h5 class="card-title">{{ $workOrder->name }}</h5>
        <h6 style="margin-top: -19px;"><small>Erstellt von: {{ $workOrder->user->username }}</small>
        </h6>
        <p id="status_{{ $workOrder->id }}"
            class="px-2 btn p-0 text-center"
            style="border:1px solid; max-width: fit-content;
			{{ $workOrder->status === 'open' ? 'border-color:rgba(79,142,255); background-color:rgba(79,142,255); color: white;' : '' }}
			{{ $workOrder->status === 'onhold' ? 'border-color:rgba(247,183,49); background-color:rgba(247,183,49); color: white;' : '' }}
			{{ $workOrder->status === 'in_progress' ? 'border-color:rgba(79,142,255); background-color:rgba(79,142,255); color: white;' : '' }}
			{{ $workOrder->status === 'completed' ? 'border-color:rgba(9,173,149); background-color:rgba(9,173,149); color: white;' : '' }}">
            @php
                $status = $workOrder->status;
                $icon = '';
                $statusText = ''; // Deutsche Statusbeschreibung
                switch ($status) {
                    case 'open':
                        $icon = 'fa-unlock-alt';
                        $statusText = 'Offen';
                        break;
                    case 'onhold':
                        $icon = 'fa-pause-circle-o';
                        $statusText = 'In Wartestellung';
                        break;
                    case 'in_progress':
                        $icon = 'fa-refresh';
                        $statusText = 'In Bearbeitung';
                        break;
                    case 'completed':
                        $icon = 'fa-check';
                        $statusText = 'Abgeschlossen';
                        break;
                    default:
                        $icon = 'default-icon';
                        $statusText = 'Unbekannt';
                        break;
                }
            @endphp
           <i class="fa {{ $icon }} text-white" id="icon" style="margin-bottom: 8px;"></i>
            <span>{{ $statusText }}</span>
        </p>
    </div>
</div>
<div class="col-3 text-center">
                                                                <div class="">
                                                                    @php
                                                                        $userWorkOrdersFiltered = $userWorkOrders->where('work_order_id', $workOrder->id);
                                                                        $userCount = $userWorkOrdersFiltered->count();
                                                                    @endphp
                                                                    <img src="{{ getImage($workOrder->user->avatar, true) }}" class="brround" alt="User Image" style="width: 30px; height: 30px;">
                                                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info"> + {{ $userCount }}</span>
      <p class="badge text-dark">
    <span class="priorityDot mx-0 {{ $workOrder->priority === 'low' ? 'bg-success' : '' }}
        {{ $workOrder->priority === 'high' ? 'bg-danger' : '' }}
        {{ $workOrder->priority === 'medium' ? 'bg-warning' : '' }}">
    </span>
    @if ($workOrder->priority === 'low')
        {{ trans('Niedrig') }}
    @elseif ($workOrder->priority === 'high')
        {{ trans('Hoch') }}
    @elseif ($workOrder->priority === 'medium')
        {{ trans('Mittel') }}
    @endif
</p>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
@endif
@endforeach
</div>
                                        <div class="tab-pane" id="tab2">
                                            @foreach ($workOrders as $workOrder)
                                                @if ($workOrder->status === 'completed')
                                                    <div class="card" style="cursor: pointer;"
                                                        onclick="fetchWorkOrderName('{{ $workOrder->id }}')">
                                                        <div class="row px-2 py-3">
                                                            <div class="col-3">
                                                                <div class="img_container">
                                                                    <img src="{{ asset('storage/' . $workOrder->image_url) }}"
                                                                        class="" alt="Work Order Image"
                                                                        style="width: 100% !important;
                                                                        height: 100% !important;
                                                                     border-radius: 50%;
                                                                        vertical-align: middle;
                                                                        border-style: none;
                                                                    ">
                                                                </div>
                                                            </div>
                                                            <div class="col-6 px-xxl-0">
                                                              <div class="card-body p-0">
        <h5 class="card-title">{{ $workOrder->name }}</h5>
        <h6 style="margin-top: -19px;"><small>Erstellt von: {{ $workOrder->user->username }}</small>
        </h6>
        <p id="status_{{ $workOrder->id }}"
            class="px-2 btn p-0 text-center"
             style="border:1px solid; max-width: fit-content;
			{{ $workOrder->status === 'open' ? 'border-color:rgba(79,142,255); background-color:rgba(79,142,255); color: white;' : '' }}
			{{ $workOrder->status === 'onhold' ? 'border-color:rgba(247,183,49); background-color:rgba(247,183,49); color: white;' : '' }}
			{{ $workOrder->status === 'in_progress' ? 'border-color:rgba(79,142,255); background-color:rgba(79,142,255); color: white;' : '' }}
			{{ $workOrder->status === 'completed' ? 'border-color:rgba(9,173,149); background-color:rgba(9,173,149); color: white;' : '' }}">
            @php
                $status = $workOrder->status;
                $icon = '';
                $statusText = ''; // Deutsche Statusbeschreibung
                switch ($status) {
                    case 'open':
                        $icon = 'fa-unlock-alt';
                        $statusText = 'Offen';
                        break;
                    case 'onhold':
                        $icon = 'fa-pause-circle-o';
                        $statusText = 'In Wartestellung';
                        break;
                    case 'in_progress':
                        $icon = 'fa-refresh';
                        $statusText = 'In Bearbeitung';
                        break;
                    case 'completed':
                        $icon = 'fa-check';
                        $statusText = 'Abgeschlossen';
                        break;
                    default:
                        $icon = 'default-icon';
                        $statusText = 'Unbekannt';
                        break;
                }
            @endphp
         <i class="fa {{ $icon }} text-white" id="icon" style="margin-bottom: 8px;"></i>
        <span>{{ $statusText }}</span>
	</p>
         </div>
         </div>
         <div class="col-3 text-center">
         <div class="">
         @php
         $userWorkOrdersFiltered = $userWorkOrders->where('work_order_id', $workOrder->id);
         $userCount = $userWorkOrdersFiltered->count();
         @endphp
         <img src="{{ getImage($workOrder->user->avatar, true) }}" class="brround" alt="User Image" style="width: 30px; height: 30px;">
         <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info"> + {{ $userCount }}</span>
          <p class="badge text-dark">
    <span class="priorityDot mx-0 {{ $workOrder->priority === 'low' ? 'bg-success' : '' }}
        {{ $workOrder->priority === 'high' ? 'bg-danger' : '' }}
        {{ $workOrder->priority === 'medium' ? 'bg-warning' : '' }}">
    </span>
    @if ($workOrder->priority === 'low')
        {{ trans('Niedrig') }}
    @elseif ($workOrder->priority === 'high')
        {{ trans('Hoch') }}
    @elseif ($workOrder->priority === 'medium')
        {{ trans('Mittel') }}
    @endif
</p>
            </div>
          </div>
         </div>
        </div>
      @endif
      @endforeach
      </div>
       <div class="tab-pane" id="tab02">
      @foreach ($workOrders as $workOrder)
        @php
        $dateRange = $workOrder->schedule_period;
        $dates = explode(' to ', $dateRange);
        $startDate = $dates[0];
        $endDate = $dates[1] ?? $startDate;
        $carbonStartDate = \Carbon\Carbon::parse($startDate);
        @endphp

        @if (
           $carbonStartDate->isAfter(now()->addDay()) ||
           ($carbonStartDate->isAfter(now()) && $workOrder->status !== 'completed'))
              <div class="card" style="cursor: pointer;"
                onclick="fetchWorkOrderName('{{ $workOrder->id }}')">
                   <div class="row px-2 py-3">
                     {{-- <div class="col-3">
                     <img src="{{ asset('storage/' . $workOrder->image_url) }}"
                     class="card-img-left rounded h-75"
                     alt="Work Order Image">
                   </div> --}}
                   	<div class="col-3">
                    <div class="img_container">
                    <img src="{{ asset('storage/' . $workOrder->image_url) }}"
                    class="" alt="Work Order Image"
                    style="width: 100% !important;
                    height: 100% !important;
                    border-radius: 50%;
                    vertical-align: middle;
                    border-style: none;
                    ">
               	</div>
               </div>
        <div class="col-6 px-xxl-0">
    <div class="card-body p-0">
        <h5 class="card-title">{{ $workOrder->name }}</h5>
        <h6 style="margin-top: -19px;"><small>Erstellt von: {{ $workOrder->user->username }}</small>
        </h6>
        <p id="status_{{ $workOrder->id }}"
            class="px-2 btn p-0 text-center"
           style="border:1px solid; max-width: fit-content;
			{{ $workOrder->status === 'open' ? 'border-color:rgba(79,142,255); background-color:rgba(79,142,255); color: white;' : '' }}
			{{ $workOrder->status === 'onhold' ? 'border-color:rgba(247,183,49); background-color:rgba(247,183,49); color: white;' : '' }}
			{{ $workOrder->status === 'in_progress' ? 'border-color:rgba(79,142,255); background-color:rgba(79,142,255); color: white;' : '' }}
			{{ $workOrder->status === 'completed' ? 'border-color:rgba(9,173,149); background-color:rgba(9,173,149); color: white;' : '' }}">

            @php
                $status = $workOrder->status;
                $icon = '';
                $statusText = ''; // Deutsche Statusbeschreibung
                switch ($status) {
                    case 'open':
                        $icon = 'fa-unlock-alt';
                        $statusText = 'Offen';
                        break;
                    case 'onhold':
                        $icon = 'fa-pause-circle-o';
                        $statusText = 'In Wartestellung';
                        break;
                    case 'in_progress':
                        $icon = 'fa-refresh';
                        $statusText = 'In Bearbeitung';
                        break;
                    case 'completed':
                        $icon = 'fa-check';
                        $statusText = 'Abgeschlossen';
                        break;
                    default:
                        $icon = 'default-icon';
                        $statusText = 'Unbekannt';
                        break;
                }
            @endphp
            <i class="fa {{ $icon }} text-white" id="icon" style="margin-bottom: 8px;"></i>
            <span>{{ $statusText }}</span>
			</p>
       	</div>
       </div>
      <div class="col-3 text-center">
      <div class="">
        @php
          $userWorkOrdersFiltered = $userWorkOrders->where('work_order_id', $workOrder->id);
          $userCount = $userWorkOrdersFiltered->count();
          @endphp
          <img src="{{ getImage($workOrder->user->avatar, true) }}" class="brround" alt="User Image" style="width: 30px; height: 30px;">
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info"> + {{ $userCount }}</span>
           <p class="badge text-dark">
    <span class="priorityDot mx-0 {{ $workOrder->priority === 'low' ? 'bg-success' : '' }}
        {{ $workOrder->priority === 'high' ? 'bg-danger' : '' }}
        {{ $workOrder->priority === 'medium' ? 'bg-warning' : '' }}">
    </span>
    @if ($workOrder->priority === 'low')
        {{ trans('Niedrig') }}
    @elseif ($workOrder->priority === 'high')
        {{ trans('Hoch') }}
    @elseif ($workOrder->priority === 'medium')
        {{ trans('Mittel') }}
    @endif
</p>
         </div>
        </div>
	   </div>
     </div>
     @endif
                                            @endforeach
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-xl-8 mt-4">
                    <div id="editFormContainer" style="display: none;"></div>
                    <div id="createWorkOrder" style="display: none;">
                        @include('backend.workorder.create')
                    </div>
                    <div class="" id="workOrderDetails" style="display: none">
                        @include('backend.workorder.detail')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="selected-tab" id="tab6" style="display: none;">
        @include('backend.workorder.celenderview')
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        $('#myDropdown').change(function() {
            var selectedTab = $(this).val();
            $('.selected-tab').hide(); // Hide all tabs
            $(selectedTab).show(); // Show the selected tab
        });

        function fetchWorkOrderName(id) {
            fetch(`/work-order-details/${id}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Work order not found.');
                    }
                    return response.text();
                })
                .then(data => {
                    document.getElementById('createWorkOrder').style.display = 'none';
                    document.getElementById('editFormContainer').style.display = 'none';
                    document.getElementById('workOrderDetails').innerHTML = data;
                    document.getElementById('workOrderDetails').style.display = 'block';
                })
                .catch(error => {
                    console.error(error.message);
                });
        }


        $(function() {
            function toggleCreateForm() {
                var createForm = document.getElementById('createWorkOrder');
                if (createForm.style.display === 'none') {
                    createForm.style.display = 'block';
                    document.getElementById('workOrderDetails').style.display = 'none';
                    document.getElementById('editFormContainer').style.display = 'none';
                } else {
                    createForm.style.display = 'none';
                }
            }

            // Event listener for the button click
            document.getElementById('tab3').addEventListener('click', function(event) {
                event.preventDefault();
                toggleCreateForm();
            });
        });
        $(function() {
            const datePicker = flatpickr("#schedule_period_range_input", {
                mode: "range",
                dateFormat: "Y-m-d",
                onClose: function(selectedDates, dateStr, instance) {
                    document.getElementById("dateRangeInput").value = dateStr;

                    const weeklyButton = document.querySelector('[data-value="weekly"]');
                    const monthlyButton = document.querySelector('[data-value="monthly"]');
                    const yearlyButton = document.querySelector('[data-value="yearly"]');
                    const dailyButton = document.querySelector('[data-value="daily"]');

                    if (dateStr.includes("to")) {
                        console.log(1233);
                        weeklyButton.style.display = 'inline-block';
                        monthlyButton.style.display = 'inline-block';
                        yearlyButton.style.display = 'inline-block';
                        // dailyButton.style.display = 'none';

                    } else {
                        console.log(12);
                        // dailyButton.style.display = 'inline-block';
                    }
                }
            });

            document.getElementById("addTimeLink").addEventListener("click", function(event) {
                event.preventDefault();
                datePicker.set("mode", "range");
            });
        });

        const buttons = document.querySelectorAll('.toggle-color');
        const selectedTime = document.getElementById('selected-time');

        buttons.forEach(button => {
            button.addEventListener('click', function() {
                buttons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                selectedTime.value = this.getAttribute('data-value');
            });
        });

        const priorityButtons = document.querySelectorAll('.toggle-priority');
        const priorityInput = document.getElementById('priorityInput');

        priorityButtons.forEach(button => {
            button.addEventListener('click', function() {
                priorityButtons.forEach(btn => {
                    btn.classList.remove('active');
                });
                this.classList.add('active');
                priorityInput.value = this.getAttribute('data-value');
            });
        });
    </script>
@endpush
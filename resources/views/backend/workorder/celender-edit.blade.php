<style>
    .swal2-container {
        z-index: 999999;
    }

    .bi-arrow-left-circle {
        margin-right: 5px;
    }
</style>
<div id="calender-detail" class="fade show">
    @if ($workOrder->created_by == Auth::id())
        <div class="d-flex justify-content-between mb-3">
            <button id="backButton" class="btn btn-outline-dark btn-sm fade"><i
                    class="bi bi-arrow-left-circle"></i>Back</button>
            <button id="formEditButton" data-url="http://127.0.0.1:8000/work-order/1/edit"
                class="btn btn-sm btn-success px-4 btn-sm fade show">
                <i class="fe fe-edit"></i>
            </button>
        </div>
    @endif
    <div class="" id="Details">
        @include('backend.workorder.detail')
    </div>
</div>

<div id="calender-edit-form" class="fade d-none">
    <form action="{{ route('work-order.update', $workOrders->id) }}" method="post" enctype="multipart/form-data"
        data-form="ajax-form" data-refresh="true">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" id="name"
                        value="{{ $workOrders->name }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="image">Bild <span class="text-danger">*</span></label>
                    <input type="file" class="form-control" name="image" id="image">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="description">Beschreibung <span class="text-danger">*</span></label>
                    <textarea type="number" class="form-control" name="description" id="description">{{ $workOrders->description }}</textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="estimate_time">Schätzzeit <span class="text-danger">*</span></label>
                <div class="form-group d-flex align-items-center">
                    <div class="input-group">
                        <input type="number" class="form-control" name="estimate_hour" id="estimate_hour"
                            value="{{ $workOrders->estimate_hour }}">
                        <div class="input-group-text">geschätzte Stunde</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-auto">
                <div class="form-group d-flex align-items-center">
                    <div class="input-group">
                        <input type="number" class="form-control" name="estimate_minute" id="estimate_minute"
                            value="{{ $workOrders->estimate_minute }}">
                        <div class="input-group-text">geschätzte Minute</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="user_id">Nutzer <span class="text-danger">*</span></label>
                    <select class="form-control form-select" name="user_id[]" id="user__assign" multiple>
                        <option value="">Select User</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" @if (in_array($user->id, $userWorkOrder->pluck('user_id')->toArray())) selected @endif>
                                {{ $user->username }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <label for="schedule_period">Fälligkeitsdatum & Zeitplan <span class="text-danger">*</span></label>
                <div class="form-group d-flex align-items-center">
                    <div class="input-group">
                        <input type="text" class="form-control" name="schedule_period"
                            value="{{ $workOrders->schedule_period }}" id="schedule_period_range">
                        <input type="hidden" id="dateRange" name="date_range" value="">
                        <div class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="input-group px-4">
                        @if ($workOrders->schedule_period_time)
                            <span class="m-1 mx-4" id="addTime"
                                style="display: none;cursor: pointer;color: blue;">Fügen Sie
                                die
                                entsprechende Zeit hinzu</span>
                            <input type="time" id="time" class="form-control" name="time_field"
                                style="cursor: pointer" value="{{ $workOrders->schedule_period_time }}">
                        @else
                            <span class="m-1 mx-4" id="addTime" style="cursor: pointer;color: blue;">Fügen Sie
                                die
                                entsprechende Zeit hinzu</span>
                            <input type="time" id="time" class="form-control" name="time_field"
                                style="display: none; cursor: pointer">
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <label for="time_schedule" class="mr-3">Time Schedule</label>
                <div class="form-group d-flex align-items-center mt-3">
                    @if (str_contains($workOrders->schedule_period, 'to'))
                        <div class="d-flex">
                            <button type="button"
                                class="btn  mr-2 toggle-color {{ $workOrders->selected_time === 'no' ? ' active' : '' }}"
                                data-value-time="no">No</button>
                            {{-- <button type="button"
                                class="btn  mx-1 mr-2 toggle-color {{ $workOrders->selected_time === 'daily' ? ' active' : '' }}"
                                data-value-time="daily" style="display: none">Daily</button> --}}
                            <button type="button"
                                class="btn  mr-2 mx-2 toggle-color {{ $workOrders->selected_time === 'weekly' ? ' active' : '' }}"
                                data-value-time="weekly">Weekly</button>
                            <button type="button"
                                class="btn  mr-2 mx-1 toggle-color {{ $workOrders->selected_time === 'monthly' ? ' active' : '' }}"
                                data-value-time="monthly">Monthly</button>
                            <button type="button"
                                class="btn  mr-2 mx-1 toggle-color {{ $workOrders->selected_time === 'yearly' ? ' active' : '' }}"
                                data-value-time="yearly">Yearly</button>
                            <input type="hidden" id="selected-value" name="selected_time"
                                value="{{ $workOrders->selected_time }}">
                        </div>
                    @else
                        <div class="d-flex">
                            <button type="button"
                                class="btn  mr-2 toggle-color {{ $workOrders->selected_time === 'no' ? ' active' : '' }}"
                                data-value-time="no">No</button>
                            {{-- <button type="button"
                                class="btn  mx-1 mr-2 toggle-color {{ $workOrders->selected_time === 'daily' ? ' active' : '' }}"
                                data-value-time="daily">Daily</button> --}}
                            <button type="button" style="display: none"
                                class="btn  mr-2 mx-2 toggle-color {{ $workOrders->selected_time === 'weekly' ? ' active' : '' }}"
                                data-value-time="weekly">Weekly</button>
                            <button type="button" style="display: none"
                                class="btn  mr-2 mx-1 toggle-color {{ $workOrders->selected_time === 'monthly' ? ' active' : '' }}"
                                data-value-time="monthly">Monthly</button>
                            <button type="button" style="display: none"
                                class="btn  mr-2 mx-1 toggle-color {{ $workOrders->selected_time === 'yearly' ? ' active' : '' }}"
                                data-value-time="yearly">Yearly</button>
                            <input type="hidden" id="selected-value" name="selected_time"
                                value="{{ $workOrders->selected_time }}">
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <label for="priority" class="mr-3">Priorität</label>
                <div class="form-group d-flex align-items-center mt-3">
                    <div class="d-flex">
                        <button type="button"
                            class="btn mr-2 toggle-priority{{ $workOrders->priority === 'no' ? ' active' : '' }}"
                            data-value="no">No</button>
                        <button type="button"
                            class="btn mr-2 mx-1 toggle-priority{{ $workOrders->priority === 'low' ? ' active' : '' }}"
                            data-value="low">Low</button>
                        <button type="button"
                            class="btn mr-2 toggle-priority{{ $workOrders->priority === 'medium' ? ' active' : '' }}"
                            data-value="medium">Medium</button>
                        <button type="button"
                            class="btn mr-2 mx-1 toggle-priority{{ $workOrders->priority === 'high' ? ' active' : '' }}"
                            data-value="high">High</button>
                    </div>
                </div>
                <input type="hidden" id="priorityvalue" name="priority" value="{{ $workOrders->priority }}">

            </div>

            <div class="form-group">
                <label for="location_id">Standort</label>
                <select class="form-control form-select" name="location_id" id="location_id">
                    <option value="">Wähle einen Ort</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}" @if (in_array($location->id, $userWorkOrder->pluck('location_id')->toArray())) selected @endif>
                            {{ $location->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="machine_id">Maschine</label>
                <select class="form-control form-select" name="machine_id" id="machine_id">
                    <option value="">Maschine auswählen</option>
                    <!-- First list machines without a type -->
                    @foreach ($machinesWithoutType as $machine)
                        <option value="{{ $machine->id }}" @if (in_array($machine->id, $userWorkOrder->pluck('machine_id')->toArray())) selected @endif>
                            {{ $machine->name }}
                        </option>
                    @endforeach
                    <!-- Then list machine types and their machines -->
                    @foreach ($machineTypes as $machineType)
                        @if ($machineType->machines->isNotEmpty())
                            <!-- Check if the machine type has any machines -->
                            <optgroup label="{{ $machineType->name }}">
                                @foreach ($machineType->machines as $machine)
                                    <option value="{{ $machine->id }}"
                                        @if (in_array($machine->id, $userWorkOrder->pluck('machine_id')->toArray())) selected @endif>
                                        {{ $machine->name }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <button type="submit" class="btn btn-primary"
                        data-button="submit">{{ __('messages.submit') }}</button>
                </div>
            </div>
    </form>
</div>
<script src="{{ asset('backend/custom_js/calender-edit-modal.js') }}"></script>

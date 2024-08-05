<div class="card">
    <div class="card-body">
        <form action="{{ route('work-order.store') }}" method="post" enctype="multipart/form-data" data-form="ajax-form"
            data-refresh="true">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Titel/Name des Arbeitsauftrages <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" id="name">
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
                        <textarea type="number" class="form-control" name="description" id="description"></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="estimate_hour">Geschätzte Zeit <span class="text-danger">*</span></label>
                    <div class="form-group d-flex align-items-center">
                        <div class="input-group">
                            <input type="number" class="form-control" name="estimate_hour" id="estimate_hour">
                            <div class="input-group-text">Stunden</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-auto">
                    <div class="form-group d-flex align-items-center">
                        <div class="input-group">
                            <input type="number" class="form-control" name="estimate_minute" id="estimate_minute">
                            <div class="input-group-text">Minuten</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="user_id">Mitarbeiter zuweisen <span class="text-danger"></span></label>
                        <select class="form-control form-select select2" name="user_id[]" id="user_id" multiple>
                            <option value="" disabled>Mitarbeiter auswählen</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->username }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="schedule_period_range_input">Fälligkeitsdatum & Zeitplan <span
                            class="text-danger">*</span></label>
                    <div class="form-group d-flex align-items-center">
                        <div class="input-group">
                            <input type="text" class="form-control due-date-input" name="schedule_period"
                                id="schedule_period_range_input">
                            <input type="hidden" id="dateRangeInput" name="date_range" value="">
                            <div class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="input-group px-4">
                            <span class="m-1 mx-4" id="addTimeLink" style="cursor: pointer;color: blue;">Fügen Sie die
                                entsprechende Startzeit hinzu</span>
                            <input type="time" id="timeField" class="form-control" name="time_field"
                                style="display: none; cursor: pointer">
                        </div>
                    </div>
                </div>
            </div>
        <div class="row">
                <div class="col-md-6">
                    <label for="time_schedule" class="mr-3">Wiederholen?</label>
                    <div class="form-group d-flex align-items-center mt-3">
                        <div class="d-flex flex-wrap gap-2">
                            <button type="button" class="btn mx-1 toggle-color" data-value="no">Nein</button>
                            {{-- <button type="button" class="btn mx-1 toggle-color" data-value="daily">Täglich</button> --}}
                            <button type="button" class="btn mx-1 toggle-color" data-value="weekly">Wöchentlich</button>
                            <button type="button" class="btn mx-1 toggle-color"
                                data-value="monthly">Monatlich</button>
                            <button type="button" class="btn mx-1 toggle-color" data-value="yearly">Jährlich</button>
                            <input type="hidden" id="selected-time" name="selected_time" value="">
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="time_schedule" class="mr-3">Anzahl der Wiederholungen</label>
                    <input type="number" min="1" step="1" class="form-control"
                        name="no_of_repetitions" id="no_of_repetitions">
                </div>
            </div>
            <div class="row">
                <div class="col-md-9">
                    <label for="priority" class="mr-3">Priorität</label>
                    <div class="form-group d-flex align-items-center mt-3">
                        <div class="d-flex">
                            <button type="button" class="btn mx-1 toggle-priority" data-value="low">Niedrig</button>
                            <button type="button" class="btn mx-1 toggle-priority"
                                data-value="medium">Mittel</button>
                            <button type="button" class="btn mx-1 toggle-priority" data-value="high">Hoch</button>
                        </div>
                    </div>
                    <input type="hidden" id="priorityInput" name="priority" value="low">
                </div>
            </div>
            <div class="form-group">
                <label for="location_id" class="form-label">Standort <span class="text-danger">*</span></label>
                <select class="form-control form-select select2" name="location_id" id="location_id">
                    <option value="" disabled>Wähle einen Ort</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                    @endforeach
                </select>
            </div>

        <div class="form-group">
    <label for="machine_id" class="form-label">Maschine <span class="text-danger">*</span></label>
    <select class="form-control form-select" name="machine_id" id="machine_id">
        <option value="" disabled selected>Maschine auswählen</option>
        <!-- First list machines without a type -->
        @foreach ($machinesWithoutType as $machine)
            <option value="{{ $machine->id }}">
                {{ $machine->name }}
            </option>
        @endforeach
        <!-- Then list machine types and their machines -->
        @foreach ($machineTypes as $machineType)
            <optgroup label="{{ $machineType->name }}">
                @foreach ($machineType->machines as $machine)
                    <option value="{{ $machine->id }}">
                        {{ $machine->name }}
                    </option>
                @endforeach
            </optgroup>
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
</div>
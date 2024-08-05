@php
    $isEdit = isset($task);
    $url = $isEdit ? route('tasks.update', $task->id) : route('tasks.store');
@endphp
<form action="{{ $url }}" method="post" data-form="ajax-form" data-modal="#ajax-modal"
    data-datatable="#tasks_datatable">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="machine_id">Maschine</label>
            <select class="form-control select2 form-select" name="machine_id" id="machine_id">
                <option value="">Maschine auswählen</option>
                <!-- First list machines without a type -->
                @foreach ($machinesWithoutType as $machine)
                    <option value="{{ $machine->id }}" {{ $isEdit && $task->machine_id == $machine->id ? 'selected' : '' }}>
                        {{ $machine->name }}
                    </option>
                @endforeach
                <!-- Then list machine types and their machines -->
                @foreach ($machineTypes as $machineType)
                    @if ($machineType->machines->isNotEmpty()) <!-- Check if the machine type has any machines -->
                        <optgroup label="{{ $machineType->name }}">
                            @foreach ($machineType->machines as $machine)
                                <option value="{{ $machine->id }}" {{ $isEdit && $task->machine_id == $machine->id ? 'selected' : '' }}>
                                    {{ $machine->name }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="form-group col-lg-6">
            <label for="priority_id">Priorität</label>
            <select class="form-control select2 form-select" name="priority_id" id="priority_id">
                @foreach ($priorities as $priority)
                    <option value="{{ $priority->id }}"
                        {{ $isEdit && $task->priority_id == $priority->id ? 'selected' : '' }}>
                        {{ $priority->status }}
                    </option>
                @endforeach
            </select>
        </div>
         <div class="form-group col-lg-6">
    <label for="problem">Problem/Beschreibung</label>
    <input type="text" class="form-control" name="problem" id="problem"
           value="{{ $isEdit ? $task->problem : '' }}"
           {{ $isEdit ? 'readonly' : '' }}>
</div>
       @if ($isEdit)
    <div class="form-group col-lg-6">
        <label for="status">Status</label>
        <select class="form-control select2 form-select" name="status" id="status">
            <option value="offen" {{ $task->status == 'offen' ? 'selected' : '' }}>Offen</option>
            <option value="in bearbeitung" {{ $task->status == 'in bearbeitung' ? 'selected' : '' }}>In Bearbeitung</option>
            <option value="abgeschlossen" {{ $task->status == 'abgeschlossen' ? 'selected' : '' }}>Abgeschlossen</option>
        </select>
    </div>
@endif
    <div class="col-lg-12">
        <button type="submit" class="btn btn-primary" data-button="submit">
        {{ $isEdit ? 'Aktualisieren' : __('messages.submit') }}
    </button>
    </div>
</form>

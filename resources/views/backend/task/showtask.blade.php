@php
    $isEdit = isset($task);
    $url = $isEdit ? route('tasks.update', $task->id) : route('tasks.store');
@endphp
<form data-form="ajax-form" data-modal="#ajax-modal" data-datatable="#tasks_datatable">
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="machine_id">Maschine</label>
            <input type="text" class="form-control" id="machine_id"
                value="{{ $isEdit ? $task->machine->name : '' }}" readonly>
        </div>
        <div class="form-group col-lg-6">
            <label for="priority_id">Priorität</label>
            <input type="text" class="form-control" id="priority_id"
                value="{{ $isEdit ? $task->priority->name : '' }}" readonly>
        </div>
        <div class="form-group col-lg-6">
            <label for="problem">Problem</label>
            <input type="text" class="form-control" id="problem" value="{{ $isEdit ? $task->problem : '' }}"
                readonly>
        </div>
        <div class="form-group col-lg-6">
            <label for="status">Status</label>
            <input type="text" class="form-control" id="status" value="{{ $isEdit ? $task->status : '' }}"
                readonly>
        </div>
    </div>
</form>

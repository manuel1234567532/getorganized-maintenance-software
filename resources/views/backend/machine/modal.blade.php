@php
    $isEdit = isset($machines) ? true : false;
    $url = $isEdit ? route('machines.update', $machines->id) : route('machines.store');

@endphp
<form action="{{ $url }}" method="post" data-form="ajax-form" data-modal="#ajax-modal"
    data-datatable="#machine_datatable">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="first_name">Maschinen Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="name" id="name"
                value="{{ $isEdit ? $machines->name : '' }}">
        </div>
        <div class="form-group col-lg-6">
            <label for="machine_type_id">Maschinen Type</label>
            <select class="form-control select2 form-select" name="machine_type_id" id="machine_type_id">
                <option value="">Select Machine Type</option>
                @foreach ($machineTypes as $machineType)
                    <option value="{{ $machineType->id }}" @if ($isEdit && $machines->machine_type_id == $machineType->id) selected @endif>
                        {{ $machineType->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
 <div class="form-group col-lg-6">
    <label for="location_name">Standort</label>
    <select class="form-control select2 form-select" name="location_name" id="location_name">
        <option value="">Standort auswählen</option>
        @foreach ($locations as $location)
            <option value="{{ $location->name }}" @if ($isEdit && $machines->location_name == $location->name) selected @endif>
                {{ $location->name }}
            </option>
        @endforeach
    </select>
</div>


        <div class="form-group col-lg-6">
            <label for="status">Status</label>
            <select class="form-control select2 form-select" name="status" id="status">
                <option value="active" @if ($isEdit && $machines->status == 'active') selected @endif>Active</option>
                <option value="inactive" @if ($isEdit && $machines->status == 'inactive') selected @endif>Inactive</option>
            </select>
        </div>
    </div>
   <div class="col-lg-12">
    @if ($isEdit)
        <button type="submit" class="btn btn-primary" data-button="submit">Aktualisieren</button>
    @else
        <button type="submit" class="btn btn-primary" data-button="submit">Hinzufügen</button>
    @endif
</div>
</form>

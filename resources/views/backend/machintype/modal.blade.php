@php
    $isEdit = isset($machinetype) ? true : false;
    $url = $isEdit ? route('machine-types.update', $machinetype->id) : route('machine-types.store');

@endphp
<form action="{{$url}}" method="post" data-form="ajax-form" data-modal="#ajax-modal" data-datatable="#machine_type_datatable">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="first_name">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="name" id="name" value="{{$isEdit ? $machinetype->name : ''}}">
        </div>
        <div class="form-group col-lg-6">
            <label for="status">Status</label>
            <select class="form-control select2 form-select" name="status" id="status">
                <option value="active" @if ($isEdit && $machinetype->status == 'active') selected @endif>Active</option>
                <option value="inactive" @if ($isEdit && $machinetype->status == 'inactive') selected @endif>Inactive</option>
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

@php
    $isEdit = isset($location) ? true : false;
    $url = $isEdit ? route('location.update', $location->id) : route('location.store');

@endphp
<form action="{{$url}}" method="post" data-form="ajax-form" data-modal="#ajax-modal" data-datatable="#location_datatable">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif
    <div class="row">
        <div class="form-group col-lg-12">
            <label for="first_name">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="name" id="name" value="{{$isEdit ? $location->name : ''}}">
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

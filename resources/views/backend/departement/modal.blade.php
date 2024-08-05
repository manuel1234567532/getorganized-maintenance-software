@php
    $isEdit = isset($departement) ? true : false;
    $url = $isEdit ? route('departement.update', $departement->id) : route('departement.store');

@endphp
<form action="{{$url}}" method="post" data-form="ajax-form" data-modal="#ajax-modal" data-datatable="#departement_datatable">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif
    <div class="row">
        <div class="form-group col-lg-12">
            <label for="departement_name">Bezeichnung <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="departement_name" id="departement_name" value="{{$isEdit ? $departement->departement_name : ''}}">
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

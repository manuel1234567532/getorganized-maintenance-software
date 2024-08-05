@php
    $isEdit = isset($files) ? true : false;
    $url = $isEdit ? route('files.update', $files->id) : route('files.store');
@endphp
@php
use App\Helpers\CalculateFileSize; // Pfad zu Ihrem Helper
@endphp
<form action="{{ $url }}" method="post" data-form="ajax-form" data-modal="#ajax-modal"
    data-datatable="#files_datatable">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="file_name">Dateiname <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="file_name" id="file_name"
                value="{{ $isEdit ? $files->file_name : '' }}">
        </div>
         <div class="form-group col-lg-6">
            <label for="file_size">Dateigröße <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="file_size" id="file_size"
                value="{{ $isEdit ? CalculateFileSize::formatSizeUnits($files->file_size) : '' }}" disabled>
        </div>
<div class="form-group col-lg-6">
    <label for="current_folder">Aktueller Ordner</label>
    <select class="form-control select2 form-select" name="current_folder" id="current_folder">
        <option value="">Ordner auswählen</option>
        
        <!-- Hinzufügen der Option "Home" -->
        <option value="Home" 
            @if ($isEdit && isset($files) && $files->current_folder == 'Home') 
                selected 
            @endif>
            Home
        </option>

        @foreach ($allfolders as $folder)
            <option value="{{ $folder->folder_name }}" 
                @if ($isEdit && isset($files) && $files->current_folder == $folder->folder_name) 
                    selected 
                @endif>
                {{ $folder->folder_name }}
            </option>
        @endforeach
    </select>
</div>

 <div class="form-group col-lg-6">
            <label for="uploaded_by">Hochgeladen von <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="uploaded_by" id="uploaded_by"
                value="{{ $isEdit ? $files->uploaded_by : '' }}">
        </div>
        <div class="form-group col-lg-6">
            <label for="status">Status</label>
            <select class="form-control select2 form-select" name="status" id="status">
                <option value="">Status auswählen</option>
                <option value="warten_auf_freigabe" @if ($isEdit && $files->status == 'warten_auf_freigabe') selected @endif>Warten auf Freigabe</option>
                <option value="freigegeben" @if ($isEdit && $files->status == 'freigegeben') selected @endif>Freigegeben</option>
                <option value="abgelehnt" @if ($isEdit && $files->status == 'abgelehnt') selected @endif>Abgelehnt</option>
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
</script>
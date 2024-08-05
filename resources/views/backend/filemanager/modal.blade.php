@php
    $isEdit = isset($folder) ? true : false;
    $url = $isEdit ? route('filemanager.update', $folder->id) : route('filemanager.store');
@endphp
<form id="creatingfolder" action="{{ $url }}" method="post">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif
    <div class="row">
        <!-- Textbox with Label "Name des Ordners" -->
        <div class="form-group col-lg-6">
            <label for="name">Name des Ordners <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="name" id="name" value="{{ $isEdit ? $folder->name : '' }}">
        </div>

        <!-- Dropdown with Label "Ordner Type auswählen" -->
        <div class="form-group col-lg-6">
            <label for="folder_type">Ordner Type auswählen <span class="text-danger">*</span></label>
            <select class="form-control select2 form-select" name="folder_type" id="folder_type">
                <option value="pdf gelb" {{ $isEdit && $folder->folder_type === 'pdf gelb' ? 'selected' : '' }}>Ordner für PDF Dateien</option>
                <option value="video blau" {{ $isEdit && $folder->folder_type === 'video blau' ? 'selected' : '' }}>Ordner für Video Dateien</option>
            </select>
        </div>
        
        <!-- Submit Button -->
        <div class="col-lg-12">
    @if ($isEdit)
        <button type="submit" class="btn btn-primary" data-button="submit">Aktualisieren</button>
    @else
        <button type="submit" class="btn btn-primary" data-button="submit">Hinzufügen</button>
    @endif
</div>
    </div>
</form>

<script>
$(document).ready(function() {
    $('#creatingfolder').on('submit', function(e) {
        e.preventDefault(); // Verhindert das normale Absenden des Formulars

        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // Serialisiert die Formulardaten für das AJAX-Request
            success: function(data) {
                // Hier kannst du die Antwort des Servers verarbeiten, wenn benötigt
            },
            error: function(xhr, status, error) {
                // Hier kannst du Fehlerbehandlung durchführen, wenn das AJAX-Aufruf fehlschlägt
            }
        });

        // Optional: Deaktiviere den Senden-Button, um mehrfache Sendeanfragen zu verhindern
        form.find('[type="submit"]').prop('disabled', true);
    });
});
</script>
</script>
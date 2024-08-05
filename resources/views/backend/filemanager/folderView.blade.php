@extends('backend.layouts.app')

@section('title', '| File Manager ')

@section('breadcrumb')
    <div class="page-header">
        <h1 class="page-title">{{ $folderName }}</h1> <!-- Aktueller Ordnername -->
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">File Manager</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $folderName }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
@php
function formatSizeUnits($bytes) {
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = '0 bytes';
    }

    return $bytes;
}
@endphp
 <div class="row row-sm">
    @foreach ($files as $file)
        @if (pathinfo($file->file_name, PATHINFO_EXTENSION) == 'pdf')
            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-xxl-2" id="file-{{ $file->file_name }}">
                <div class="card overflow-hidden scale-up">
                     <button class="btn-modern" onclick="confirmDelete('{{ $file->file_name }}', '{{ route('file.delete', ['fileName' => $file->file_name]) }}', 'file-{{ $file->file_name }}')">
    <i class="fas fa-minus"></i>
</button>
                    <a href="{{ route('file.view', ['folderName' => $folderName, 'fileName' => $file->file_name]) }}" class="mx-auto my-3">
                        <img src="https://laravelui.spruko.com/sash/build/assets/images/media/files/pdf.png" alt="img">
                    </a>
                    <div class="card-footer">
                        <div class="d-flex">
                            <div class="">
                                <h5 class="mb-0 fw-semibold text-break">{{ Str::limit($file->file_name, 10, '') }}</h5>
                            </div>
                            <div class="ms-auto my-auto">
                                <span class="text-muted mb-0">{{ formatSizeUnits($file->file_size) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>

@endsection

<script>
function confirmDelete(fileName, url, elementId) {
    swal.fire({
        title: "Bist du sicher?",
        text: "Möchtest du " + fileName + " wirklich aus diesem Ordner entfernen?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ja, entfernen!",
        cancelButtonText: "Abbrechen",
    }).then((result) => {
        if (result.value) {
            axios.delete(url)
                .then(response => {
                    if(response.status === 200){
                        // Remove the file element from the view
                        document.getElementById(elementId).remove();
                        toastMessage(fileName + ' erfolgreich aus diesem Ordner entfernt!', 'success');
                        // Reload page or update UI as needed
                    }
                })
                .catch(error => {
                    swal.fire("Fehler!", "Ein Fehler ist aufgetreten: " + error.response.data.message, "error");
                });
        }
    });
}

</script>


<style>
.scale-up {
    transition: transform 0.2s ease;
}

.scale-up:hover {
    transform: scale(1.05);
}
.btn-modern {
    position: absolute;
    top: 10px; 
    right: 10px;
    padding: 1px 3px;
    font-size: 12px;
    color: white;
    background-color: rgba(255, 0, 0, 0.7); /* Red with transparency */
    border: none;
    border-radius: 5px; /* Rounded corners */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Subtle shadow */
    transition: transform 0.3s ease, background-color 0.3s ease; /* Animation effect */
}

.btn-modern:hover {
    background-color: rgba(255, 0, 0, 0.8); /* Slightly less transparent on hover */
    transform: scale(1.1); /* Slightly increase size */
    cursor: pointer;
}

</style>

@extends('backend.layouts.app')

@section('title', '| File Manager ')

@section('breadcrumb')
    <div class="page-header">
        <h1 class="page-title">Dateimanager Details</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Datei Manager Details</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <!-- Row -->
    <div class="row row-sm">
        <div class="col-xl-8 col-lg-12 col-md-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-body p-3">
                    @if(pathinfo($file->file_name, PATHINFO_EXTENSION) == 'pdf')
                        <!-- PDF-Vorschau mit <embed> -->
                       <embed src="{{ asset('storage/files/' . rawurlencode($file->file_name)) }}" type="application/pdf" width="100%" height="600px" />
                    @else
                        <!-- Bildvorschau für andere Dateitypen -->
                        <a href="javascript:void(0)"><img src="https://laravelui.spruko.com/sash/build/assets/images/media/files/img3.jpg" alt="img" class="br-5 w-100"></a>
                    @endif
                </div>
            </div>
        </div>
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
        <div class="col-xl-4 col-lg-12 col-md-12">
            <div class="card custom-card">
                <div class="card-body">
                    <h5 class="mb-3">Datei Informationen</h5>
                    <div class="">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="table-responsive">
                                    <table class="table mb-0 table-bordered text-nowrap">
                                        <tbody>
                                            <tr>
                                                <th>Dateiname</th>
                                                <td>{{ $file->file_name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Hochgeladen von</th>
                                                <td>{{ $file->uploaded_by }}</td>
                                            </tr>
                                            <tr>
                                                <th>Dateigröße</th>
                                                <td>{{ formatSizeUnits($file->file_size) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Dateitype</th>
                                                <td>{{ pathinfo($file->file_name, PATHINFO_EXTENSION) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-5 text-center">
                                    <button type="button" class="btn btn-icon btn-warning-light bradius me-3"><i class="fe fe-share-2 fs-14"></i></button>
                                    <a href="{{ asset('storage/files/' . rawurlencode($file->file_name)) }}" download class="btn btn-icon btn-success-light bradius">
                                    <i class="fe fe-download fs-14"></i>
                                    </a>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row-->
@endsection
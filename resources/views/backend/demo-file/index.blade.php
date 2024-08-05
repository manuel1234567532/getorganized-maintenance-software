  @extends('backend.layouts.app')

@section('title', '| Demo Datei ')

@section('breadcrumb')
      <div class="page-header">
                            <h1 class="page-title">Dateimanager Details</h1>
                            <div>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Dateimanager - Details</li>
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
                                        <a href="javascript:void(0)"><img src="https://getorganized.at/storage/demofiles/ProdDetailMain_NXTIII.jpg" alt="img" class="br-5 w-100"></a>
                                    </div>
                                </div>
                                </div>
                            <div class="col-xl-4 col-lg-12 col-md-12">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <h5 class="mb-3">Datei Details</h5>
                                        <div class="">
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <div class="table-responsive">
                                                        <table class="table mb-0 table-bordered text-nowrap">
                                                            <tbody>
                                                                <tr>
                                                                    <th>Dateiname</th>
                                                                    <td>test.pdf</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Veröfentlicht</th>
                                                                    <td>03.01.2024</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Größe</th>
                                                                    <td>25 MB</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Dateitype</th>
                                                                    <td>pdf</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="mt-5 text-center">
                                                        <button type="button" class="btn btn-icon  btn-info-light me-2 bradius"><i class="fe fe-edit"></i></button>
                                                        <button type="button" class="btn btn-icon  btn-danger-light me-2 bradius"><i class="fe fe-trash"></i></button>
                                                        <button type="button" class="btn btn-icon  btn-success-light me-2 bradius"><i class="fe fe-download fs-14"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Row-->


                    </div>
                </div>
            </div>
@endsection
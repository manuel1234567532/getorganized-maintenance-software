@extends('backend.layouts.app')

@section('title')
    | {{ __('messages.dashboard') }}
@endsection
@section('breadcrumb')
    <div class="page-header">
        <h1 class="page-title">{{ __('messages.dashboard') }}</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">{{ __('messages.dashboard') }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
                            <div class="col-xl-4 col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title fw-semibold">Daily Activity</h4>
                                    </div>
                                    <div class="card-body pb-0">
                                        <ul class="task-list">
                                            <li class="d-sm-flex">
                                                <div>
                                                    <i class="task-icon bg-primary"></i>
                                                    <h6 class="fw-semibold">Task Finished<span
                                                            class="text-muted fs-11 mx-2 fw-normal">09 July 2021</span>
                                                    </h6>
                                                    <p class="text-muted fs-12">Adam Berry finished task on<a href="javascript:void(0)"
                                                            class="fw-semibold"> Project Management</a></p>
                                                </div>
                                            </li>
                                            <li class="d-sm-flex">
                                                <div>
                                                    <i class="task-icon bg-secondary"></i>
                                                    <h6 class="fw-semibold">New Comment<span
                                                            class="text-muted fs-11 mx-2 fw-normal">05 July 2021</span>
                                                    </h6>
                                                    <p class="text-muted fs-12">Victoria commented on Project <a
                                                            href="javascript:void(0)" class="fw-semibold"> AngularJS Template</a></p>
                                                </div>
                                              
                                            </li>
                                            <li class="d-sm-flex">
                                                <div>
                                                    <i class="task-icon bg-success"></i>
                                                    <h6 class="fw-semibold">New Comment<span
                                                            class="text-muted fs-11 mx-2 fw-normal">25 June 2021</span>
                                                    </h6>
                                                    <p class="text-muted fs-12">Victoria commented on Project <a
                                                            href="javascript:void(0)" class="fw-semibold"> AngularJS Template</a></p>
                                                </div>
                                               
                                            </li>
                                            <li class="d-sm-flex">
                                                <div>
                                                    <i class="task-icon bg-warning"></i>
                                                    <h6 class="fw-semibold">Task Overdue<span
                                                            class="text-muted fs-11 mx-2 fw-normal">14 June 2021</span>
                                                    </h6>
                                                    <p class="text-muted mb-0 fs-12">Petey Cruiser finished task <a
                                                            href="javascript:void(0)" class="fw-semibold"> Integrated management</a></p>
                                                </div>
                                               
                                            </li>
                                            <li class="d-sm-flex">
                                                <div>
                                                    <i class="task-icon bg-danger"></i>
                                                    <h6 class="fw-semibold">Task Overdue<span
                                                            class="text-muted fs-11 mx-2 fw-normal">29 June 2021</span>
                                                    </h6>
                                                    <p class="text-muted mb-0 fs-12">Petey Cruiser finished task <a
                                                            href="javascript:void(0)" class="fw-semibold"> Integrated management</a></p>
                                                </div>
                                               
                                            </li>
                                            <li class="d-sm-flex">
                                                <div>
                                                    <i class="task-icon bg-info"></i>
                                                    <h6 class="fw-semibold">Task Finished<span
                                                            class="text-muted fs-11 mx-2 fw-normal">09 July 2021</span>
                                                    </h6>
                                                    <p class="text-muted fs-12">Adam Berry finished task on<a href="javascript:void(0)"
                                                            class="fw-semibold"> Project Management</a></p>
                                                </div>
                                               
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>


@endsection
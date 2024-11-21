@extends('admin.layout.master')
@section('title', 'Category List')
@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">
                    <div class="card ">
                        <div class="card-body">
                            <div class="ms-5">
                                <i class="fa-solid fa-arrow-left" onclick="history.back()"></i>
                            </div>
                            <div class="card-title">
                            </div>
                            <hr>
                            <div class="row my-2">
                                <div class="col-8 offset-2">
                                    @if (session('updatedSuccess'))
                                        <div class="">
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                {{ session('updatedSuccess') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3 offset-2">
                                    <img src="{{ asset('storage/' . $pizza->image) }}" class="img-thumbnail shadow-sm ">
                                </div>
                                <div class="col-7">
                                    <div class="my-3 fs-5 btn btn-danger d-block w-50 text-center">{{ $pizza->name }}</div>
                                    <span class="my-3 btn btn-sm btn-dark text-white"><i
                                            class="fa-solid fs-4 fa-money-bill me-2"></i>{{ $pizza->price }} kyats</span>
                                    <span class="my-3 btn btn-sm btn-dark text-white"><i
                                            class="fa-solid fs-4 fa-clock me-2"></i>{{ $pizza->waiting_time }}
                                        minutes</span>
                                    <span class="my-3 btn btn-sm btn-dark text-white "><i
                                            class="fa-solid fs-4 fa-eye me-2"></i>{{ $pizza->view_count }}</span>
                                    <span class="my-3 btn btn-sm btn-dark text-white  "><i
                                            class="fa-solid fa-clone me-2"></i>{{ $pizza->categories_name }}</span>
                                    <span class="my-3 btn btn-sm btn-dark text-white  "><i
                                            class="fa-solid fs-4 fa-calendar-days me-2"></i>{{ $pizza->created_at->format('j-F-Y') }}</span>
                                    <div class="my-3"><i class="fa-solid fs-4 fa-file-lines me-2 d-inline"></i>Details
                                    </div>
                                    <div class="">{{ $pizza->description }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

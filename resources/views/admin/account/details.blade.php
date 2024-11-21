@extends('admin.layout.master')
@section('title', 'Category List')
@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Account Info</h3>
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
                                    @if (Auth::user()->image == null)
                                        @if (Auth::user()->gender == 'male')
                                            <img src="{{ asset('images/user.jpg') }}" class="img-thumbnail shadow-sm">
                                        @else
                                            <img src="{{ asset('images/female_default.png') }}">
                                        @endif
                                    @else
                                        <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="" />
                                    @endif
                                </div>
                                <div class="col-5 offset-1">
                                    <h5 class="my-3 "><i class="fa-solid fa-user-pen me-2"></i>{{ Auth::user()->name }}
                                    </h5>
                                    <h5 class="my-3 "><i class="fa-regular fa-envelope me-2"></i>{{ Auth::user()->email }}
                                    </h5>
                                    <h5 class="my-3 "><i class="fa-solid fa-phone me-2"></i>{{ Auth::user()->phone }}</h5>
                                    <h5 class="my-3 "><i
                                            class="fa-solid fa-address-book me-2"></i>{{ Auth::user()->address }}</h5>
                                    <h5 class="my-3 "><i
                                            class="fa-solid fa-user-clock me-2"></i>{{ Auth::user()->created_at->format('j F Y') }}
                                    </h5>
                                    <h5 class="my-3 "><i class="fa-solid fa-venus-mars me-2"></i>{{ Auth::user()->gender }}
                                    </h5>
                                </div>
                                <div class="row mt-2">
                                    <a href="{{ route('admin#edit') }}">
                                        <div class="col-2 offset-5">
                                            <button class="btn btn-dark text-white"><i
                                                    class="fa-solid fa-pen-to-square me-2"></i>Edit profile</button>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

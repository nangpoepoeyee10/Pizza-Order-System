@extends('admin.layout.master')
@section('title', 'Category List')
@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="ms-5">
                                <a href="{{ route('admin#list') }}">
                                    <i class="fa-solid fa-arrow-left text-dark"></i>
                                </a>
                            </div>
                            <div class="card-title">
                                <h3 class="text-center title-2">Change Role</h3>
                            </div>
                            <hr>
                            <form action="{{ route('admin#change', $account->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-5 mt-2">
                                        <div class="col-6 offset-3">
                                            @if ($account->image == null)
                                                @if ($account->gender == 'male')
                                                    <img src="{{ asset('images/user.jpg') }}"
                                                        class="img-thumbnail shadow-sm">
                                                @else
                                                    <img src="{{ asset('images/female_default.png') }}">
                                                @endif
                                            @else
                                                <img src="{{ asset('storage/' . $account->image) }}" />
                                            @endif
                                        </div>
                                        
                                        {{-- <div class="mt-3">
                                    <input type="file" name="image" class="form-control @error('image') is-invalid  @enderror">
                                    @error('image')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                                </div> --}}
                                        <div class="mt-3">
                                            <button class="btn btn-dark text-white col-12" type="submit">Change <i
                                                    class="fa-solid fa-circle-arrow-right ms-1"></i></button>
                                        </div>
                                    </div>
                                    <div class="col-6  mt-2">
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Name</label>
                                            <input id="cc-pament" name="name" type="text"
                                                value="{{ old('name', $account->name) }}"
                                                class="form-control @error('name') is-invalid @enderror"
                                                aria-required="true" aria-invalid="false" placeholder="Enter Name" disabled>
                                            @error('name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Role</label>
                                            <select name="role" class="form-control">
                                                <option value="admin" @if ($account->role == 'admin') selected @endif>
                                                    Admin </option>
                                                <option value="user" @if ($account->role == 'user') selected @endif>
                                                    User </option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Email</label>
                                            <input id="cc-pament" name="email" type="email"
                                                value="{{ old('email', $account->email) }}"
                                                class="form-control @error('email') is-invalid @enderror"
                                                aria-required="true" aria-invalid="false" placeholder="Enter Email"
                                                disabled>
                                            @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Phone</label>
                                            <input id="cc-pament" name="phone" type="text"
                                                value="{{ old('phone', $account->phone) }}"
                                                class="form-control @error('phone') is-invalid @enderror"
                                                aria-required="true" aria-invalid="false" placeholder="Enter Phone"
                                                disabled>
                                            @error('phone')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Gender</label>
                                            <select name="gender" disabled value=""
                                                class="form-control @error('gender') is-invalid @enderror">
                                                <option value="">choose gender</option>
                                                <option value="{{ old('male', $account->gender) }}"
                                                    @if ($account->gender == 'male') selected @endif>Male</option>
                                                <option value="female" @if ($account->gender == 'female') selected @endif>
                                                    Female</option>
                                                @error('gender')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Address</label>
                                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" value="" cols="30"
                                                rows="10" disabled>{{ old('name', $account->address) }}</textarea>
                                            @error('address')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

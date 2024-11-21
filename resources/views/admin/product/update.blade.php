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
                                <a href="{{ route('product#list') }}" class="text-decoration-none text-dark">
                                    <i class="fa-solid fa-arrow-left"></i>
                                </a>
                            </div>
                            <div class="card-title">
                                <h3 class="text-center title-2">Update Pizza</h3>
                            </div>
                            <hr>
                            <form action="{{ route('product#update', $pizza->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-5 mt-2">
                                        <div class="col-6 offset-3">
                                            <img src="{{ asset('storage/' . $pizza->image) }}">
                                        </div>
                                        <input type="hidden" name="pizzaId" value="{{ $pizza->id }}">
                                        <div class="mt-3">
                                            <input type="file" name="pizzaImage"
                                                class="form-control @error('pizzaImage') is-invalid  @enderror">
                                            @error('pizzaImage')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mt-3">
                                            <button class="btn btn-dark text-white col-12" type="submit">Update <i
                                                    class="fa-solid fa-circle-arrow-right ms-1"></i></button>
                                        </div>
                                    </div>
                                    <div class="col-6  mt-2">
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Name</label>
                                            <input id="cc-pament" name="pizzaName" type="text"
                                                value="{{ old('pizzaName', $pizza->name) }}"
                                                class="form-control @error('name') is-invalid @enderror"
                                                aria-required="true" aria-invalid="false" placeholder="Enter Name">
                                            @error('pizzaName')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Category</label>
                                            <select name="pizzaCategory" id=""
                                                class="form-control  @error('pizzaCategory') is-invalid @enderror">
                                                <option value="">Choose category</option>
                                                @foreach ($category as $c)
                                                    <option value="{{ $c->id }}"
                                                        @if ($pizza->category_id == $c->id) selected @endif
                                                        class="text-black">{{ $c->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('pizzaCategory')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Description</label>
                                            <textarea name="pizzaDescription" class="form-control  @error('pizzaDescription') is-invalid @enderror" value="">{{ old('pizzaDescription', $pizza->description) }}</textarea>
                                            @error('pizzaDescription')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Price</label>
                                            <input id="cc-pament" name="pizzaPrice" type="number"
                                                class="form-control @error('pizzaPrice') is-invalid @enderror"
                                                value="{{ old('pizzaPrice', $pizza->price) }}" aria-required="true"
                                                aria-invalid="false" placeholder="Enter Price">
                                            @error('pizzaPrice')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Waiting Time</label>
                                            <input id="cc-pament" name="pizzaTime" type="number"
                                                class="form-control @error('pizzaTime') is-invalid @enderror"
                                                value="{{ old('pizzaTime', $pizza->waiting_time) }}" aria-required="true"
                                                aria-invalid="false">
                                            @error('pizzaTime')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">View Count</label>
                                            <input id="cc-pament" name="viewCount" type="number"
                                                class="form-control @error('viewCount') is-invalid @enderror " disabled
                                                value="{{ old('viewCount', $pizza->view_count) }}" aria-required="true"
                                                aria-invalid="false">
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Created Date</label>
                                            <input id="cc-pament" name="createdAt" type="text"
                                                class="form-control @error('createdAt') is-invalid @enderror " disabled
                                                value="{{ $pizza->created_at->format('j-F-Y') }}" aria-required="true"
                                                aria-invalid="false">
                                        </div>
                                        <div>
                                            <button id="payment-button" type="submit"
                                                class="btn btn-lg btn-info btn-block">
                                                <span id="payment-button-amount">Create</span>
                                                {{-- <span id="payment-button-sending" style="display:none;">Sending…</span> --}}
                                                <i class="fa-solid fa-circle-right"></i>
                                            </button>
                                        </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{--
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    user home page
    Role -{{ Auth::user()->role}}
    <form action="{{ route('logout')}}" method="post">
        @csrf
        <input type="submit" value="log out">
    </form>
</body>
</html> --}}
@extends('user.layouts.master')
@section('content')
    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-4">
                <!-- Price Start -->
                <h5 class=" position-relative text-uppercase mb-3"><span class="">Filter by Category</span></h5>
                <div class="bg-light p-4 mb-30">
                    <form>
                        <div class=" d-flex align-items-center justify-content-between mb-3 bg-dark text-white p-2">
                            <label class="" for="price-all">Categories</label>
                            <span class="badge border font-weight-normal">{{ count($category) }}</span>
                        </div>
                        <div class=" d-flex align-items-center justify-content-between my-3">
                            <a href="{{ route('user#home') }}" class="text-dark"><label class=""
                                    for="price-5">All</label></a>
                        </div>
                        @foreach ($category as $c)
                            <div class=" d-flex align-items-center justify-content-between mt-1">
                                <a href="{{ route('user#filter', $c->id) }}" class="text-dark"><label class=""
                                        for="price-5">{{ $c->name }} </label></a>
                            </div>
                            <hr>
                        @endforeach
                    </form>
                </div>
                <!-- Price End -->
                <div class="">
                    <button class="btn btn btn-warning w-100">Order</button>
                </div>
            </div>
            <!-- Shop Sidebar End -->
            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-8">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <a href="{{ route('user#cartList') }}">
                                    <button type="button" class="btn bg-dark text-white position-relative">
                                        <i class="fa-solid fa-cart-shopping me-1"></i>
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            {{ count($cart) }} </span>
                                    </button>
                                </a>
                                <a href="{{ route('user#history') }}" class="ms-2">
                                    <button type="button" class="btn bg-dark text-white position-relative">
                                        <i class="fa-solid fa-clock-rotate-left"></i> History
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            {{ count($history) }} </span>
                                    </button>
                                </a>
                            </div>
                            <div class="ml-2">
                                <div class="btn-group">
                                    {{-- <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#">Ascending</a>
                                        <a class="dropdown-item" href="#">Descending</a>
                                       </div> --}}
                                    <select name="sorting" id="sortingOption" class="form-control">
                                        <option value="">Choose option...</option>
                                        <option value="asc">Ascending</option>
                                        <option value="desc">Descending</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <span class="row" id="dataList">
                        @if (count($pizza) != 0)
                            @foreach ($pizza as $p)
                                <div class="col-lg-4 col-md-6 col-sm-6 pb-1 ">
                                    <div class="product-item bg-light mb-4" id="myForm">
                                        <div class="product-img position-relative overflow-hidden">
                                            <img class="img-fluid w-75 ms-5 mt-3 " src="{{ asset('storage/' . $p->image) }}"
                                                style="height: 250px;" alt="">
                                            <div class="product-action">
                                                <a href="" class="btn btn-outline-dark btn-square"><i
                                                        class="fa fa-shopping-cart"></i></a>
                                                <a href="{{ route('user#details', $p->id) }}"
                                                    class="btn btn-outline-dark btn-square"><i
                                                        class="fa-solid fa-circle-info"></i></a>
                                            </div>
                                        </div>
                                        <div class="text-center py-4">
                                            <a class="h6 text-decoration-none text-truncate"
                                                href="">{{ $p->name }}</a>
                                            <div class="d-flex align-items-center justify-content-center mt-2">
                                                {{-- <h5>20000 kyats</h5><h6 class="text-muted ml-2"><del>25000</del></h6> --}}
                                                <h5>{{ $p->price }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-center shadow-sm text-danger col-6 offset-3 py-5"><i
                                    class="fa-solid fa-pizza-slice me-2"></i>There is no pizza under this category!</p>
                        @endif
                    </span>
                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->
@endsection
@section('scriptSource')
    <script>
        $(document).ready(function() {
            $('#sortingOption').change(function() {
                $eventOption = $('#sortingOption').val();
                console.log($eventOption);
                if ($eventOption == 'asc') {
                    $.ajax({
                        type: 'get',
                        url: '/user/ajax/pizza/list',
                        data: {
                            'status': 'asc'
                        },
                        dataType: 'json',
                        success: function(response) {
                            $list = '';
                            for ($i = 0; $i < response.length; $i++) {
                                // console.log(`${response[$i].name}`);
                                $list += `
                   <div class="col-lg-4 col-md-6 col-sm-6 pb-1 " >
                    <div class="product-item bg-light mb-4" id="myForm">
                            <div class="product-img position-relative overflow-hidden">
                                <img class="img-fluid w-75 ms-5 mt-3" src="{{ asset('storage/${response[$i].image}') }}" style="height: 250px" alt="">
                                <div class="product-action">
                                    <a href="" class="btn btn-outline-dark btn-square"><i class="fa fa-shopping-cart"></i></a>
                                    <a href="" class="btn btn-outline-dark btn-square"><i class="fa-solid fa-circle-info"></i></a>
                                 </div>
                            </div>
                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate" href="">${response[$i].name}</a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    {{-- <h5>20000 kyats</h5><h6 class="text-muted ml-2"><del>25000</del></h6> --}}
                                    <h5>${response[$i].price}</h5>
                                </div>

                            </div>
                        </div>
                       </div>
                   `;
                            }
                            $('#dataList').html($list);
                        }
                    })
                } else if ($eventOption == 'desc') {
                    $.ajax({
                        type: 'get',
                        url: '/user/ajax/pizza/list',
                        data: {
                            'status': 'desc'
                        },
                        dataType: 'json',
                        success: function(response) {
                            $list = '';
                            for ($i = 0; $i < response.length; $i++) {
                                // console.log(`${response[$i].name}`);
                                $list += `
                   <div class="col-lg-4 col-md-6 col-sm-6 pb-1 " >
                    <div class="product-item bg-light mb-4" id="myForm">
                            <div class="product-img position-relative overflow-hidden">
                                <img class="img-fluid w-75 ms-5 mt-3" src="{{ asset('storage/${response[$i].image}') }}" style="height: 250px" alt="">
                                <div class="product-action">
                                    <a href="" class="btn btn-outline-dark btn-square"><i class="fa fa-shopping-cart"></i></a>
                                    <a href="" class="btn btn-outline-dark btn-square"><i class="fa-solid fa-circle-info"></i></a>
                                 </div>
                            </div>
                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate" href="">${response[$i].name}</a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    {{-- <h5>20000 kyats</h5><h6 class="text-muted ml-2"><del>25000</del></h6> --}}
                                    <h5>${response[$i].price}</h5>
                                </div>

                            </div>
                        </div>
                       </div>
                   `;
                            }
                            $('#dataList').html($list); //append
                        }
                    })
                }
            })
        });
    </script>
@endsection

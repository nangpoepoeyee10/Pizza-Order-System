@extends('admin.layout.master')
@section('title', 'Category List')
@section('content')

    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    @if (session('deleteSuccess'))
                        <div class="col-4 offset-8">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                {{ session('deleteSuccess') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif
                    <a href="{{ route('admin#orderList') }}" class="text-dark mb-2"><i
                            class="fa-solid fa-arrow-left-long me-1 "></i>Back</a>
                    <div class="row col-5">
                        <div class="card mt-4">
                            <div class="card-body ">
                                <h3 class=""><i class="fa-solid fa-clipboard me-3"></i>Order Info </h3>
                                <small class="text-warning mt-2"><i
                                        class="fa-solid fa-triangle-exclamation me-2"></i>Include Delivery Charges</small>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col"><i class="fa-solid fa-user me-2"></i>Customer Name</div>
                                    <div class="col">{{ strtoupper($orderList[0]->user_name) }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col"><i class="fa-solid fa-barcode me-2"></i>Order Code</div>
                                    <div class="col">{{ $orderList[0]->order_code }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col"><i class="fa-regular fa-clock me-2"></i>Order date</div>
                                    <div class="col">{{ $orderList[0]->created_at->format('F-j-Y') }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col"><i class="fa-solid fa-money-bill-wave me-2"></i>Costs</div>
                                    <div class="col">{{ $order->total_price }} Kyats</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Order ID</th>
                                    <th>Product Image</th>
                                    <th>Product Name</th>
                                    <th>Order Date</th>
                                    <th>Qty</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody id="dataList">
                                @foreach ($orderList as $o)
                                    <tr class="tr-shadow">
                                        <td class="col-0"></td>
                                        <td class="">{{ $o->id }}</td>
                                        <td class="col-2"><img src="{{ asset('storage/' . $o->product_image) }}"
                                                alt="" class="img-thumbnail"></td>
                                        <td>{{ $o->product_name }}</td>
                                        <td>{{ $o->created_at->format('F-j-Y') }}</td>
                                        <td class="">{{ $o->qty }}</td>
                                        <td class="">{{ $o->total }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
@endsection

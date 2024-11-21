@extends('user.layouts.master')
@section('content')
    <!-- Cart Start -->
    <div class="container-fluid" style="height: 500px">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0" id="dataTable">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach ($cartList as $c)
                            <tr>
                                <td class="align-middle"><img src="{{ asset('storage/' . $c->pizza_image) }}" alt=""
                                        style="width: 100px;" class="img img-thumbnail shadow-sm"></td>
                                <td class="align-middle"> {{ $c->pizza_name }}
                                    <input type="hidden" class="orderId" value="{{ $c->id }}">
                                    <input type="hidden" name="" class="productId" value="{{ $c->product_id }}">
                                    <input type="hidden" name="" class="userId" value="{{ $c->user_id }}">
                                </td>
                                <td class="align-middle" id="pizzaPrice">{{ $c->pizza_price }} kyats</td>
                                {{-- <input type="hidden" name="" id="pizzaPrice" value="{{$c->pizza_price}}"> --}}
                                <td class="align-middle">
                                    <div class="input-group quantity mx-auto" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-outline-warning btn-minus">
                                                <i class="fa fa-minus text-white"></i>
                                            </button>
                                        </div>
                                        <input type="text" class="form-control form-control-sm border-0 text-center"
                                            value="{{ $c->qty }}" id="qty">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-outline-warning btn-plus">
                                                <i class="fa fa-plus text-white"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle col-3" id="total">{{ $c->pizza_price * $c->qty }} kyats</td>
                                <td class="align-middle"><button class="btn btn-sm btn-danger btn-remove"><i
                                            class="fa fa-times"></i></button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart
                        Summary</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Subtotal</h6>
                            <h6 id="subTotal">{{ $totalPrice }} kyats</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping</h6>
                            <h6 class="font-weight-medium">4000 kyats</h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5 id="finalPrice">{{ $totalPrice + 4000 }} kyats</h5>
                        </div>
                        <button class="btn btn-block btn-primary btn-outline-warning font-weight-bold my-3 py-3"
                            id="orderBtn">Proceed To
                            Checkout</button>
                        <button class="btn btn-block btn-danger font-weight-bold my-3 py-3" id="clearBtn">Clear
                            Cart</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
@section('scriptSource')
    <script>
        //<script src="{{ asset('js/cart.js') }}">
        $(document).ready(function() {
            $('.btn-plus').click(function() {
                $parentNode = $(this).parents('tr');
                //     $price = $parentNode.find('#pizzaPrice').val(); //trထဲက pizzaPrice ဖြစ်တာfind
                $price = Number($parentNode.find("#pizzaPrice").text().replace("kyats", ""));
                $qty = ($parentNode.find('#qty').val() * 1);
                $total = $price * $qty;
                $parentNode.find('#total').html($total + " kyats");
                // total summary
                summaryCalculation();
            })
            //when minus button click
            $('.btn-minus').click(function() {
                $parentNode = $(this).parents('tr');
                $price = Number($parentNode.find("#pizzaPrice").text().replace("kyats", ""));
                $qty = ($parentNode.find('#qty').val() * 1);

                $total = $price * $qty;
                $parentNode.find('#total').html($total + " kyats");
                if ($qty == 0) {
                    $('.btn-minus').attr('disable');
                }
                summaryCalculation();
            })
            $('.btn-remove').click(function() {
                $parentNode = $(this).parents("tr");
                $parentNode.remove();
                $productId = $parentNode.find(".productId").val();
                $orderId = $parentNode.find(".orderId").val();
                //remove current product
                $.ajax({
                    type: 'get',
                    url: '/user/ajax/clear/current/product',
                    data: {
                        'productId': $productId,
                        'orderId': $orderId
                    },
                    dataType: 'json'
                })
                summaryCalculation();
            })

            function summaryCalculation() {
                $totalPrice = 0;
                $('#dataTable tbody tr').each(function(index, row) {
                    $totalPrice += Number($(row).find("#total").text().replace("kyats", ""));
                });
                $finalPrice = $totalPrice;
                $('#subTotal').html(`${$totalPrice} kyats`);
                $('#finalPrice').html(`${$finalPrice+4000} kyats`);
            }
            $('#orderBtn').click(function() {
                $orderList = [];
                $random = Math.floor(Math.random() * 1000001);
                $('#dataTable tbody tr').each(function(index, row) {
                    $orderList.push({
                        'user_id': $('.userId').val(),
                        'product_id': $(row).find('.productId').val(),
                        'qty': $(row).find('#qty').val(),
                        'total': $(row).find('#total').text().replace('kyats', "") * 1,
                        'order_code': 'POS000' + $('.userId').val() + $random
                    });
                });
                $.ajax({
                    type: 'get',
                    url: '/user/ajax/order',
                    data: Object.assign({}, $orderList),
                    dataType: 'json',
                    success: function(response) {
                        //console.log(response);
                        if (response.status == 'success') {
                            window.location.href = '/user/homePage';
                        }
                    }
                })
            })
            //when clear button click
            $('#clearBtn').click(function() {
                $('#dataTable tbody tr').remove();
                $('#subTotal').html("0 Kyats");
                $('#total').html("4000 Kyats");

                $.ajax({
                    type: 'get',
                    url: '/user/ajax/clear/cart',
                    dataType: 'json',
                })
            })
        })
    </script>
@endsection
@endsection

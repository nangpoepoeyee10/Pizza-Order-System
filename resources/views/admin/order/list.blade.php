@extends('admin.layout.master')
@section('title', 'Category List')
@section('content')

    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    {{-- <div class="table-data__tool">
                    <div class="table-data__tool-left">
                        <div class="overview-wrap">
                            <h2 class="title-1">Order List</h2>

                        </div>
                    </div>

                </div> --}}
                    {{-- <div class="row">
                        <div class="col-3">
                            <h5 class="text-secondary"> Search key: <span class="text-danger">{{ request('key')}}</span> </h5>
                        </div>
                    <div class="col-3 offset-6 mb-2">
                        <form action="{{ route('product#list')}}" method="get">
                            <div class="d-flex">
                                <input type="text" name="key" value="{{ request('key')}}" class="form-control" placeholder="search ...">
                                <button class="btn bg-dark text-white" type="submitt"><i class="fa-solid fa-magnifying-glass"></i></button>

                            </div>
                        </form>
                    </div>
                </div> --}}
                    @if (session('deleteSuccess'))
                        <div class="col-4 offset-8">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                {{ session('deleteSuccess') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('admin#changeStatus') }}" method="get">
                        @csrf
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i
                                    class="fa-solid fa-database me-1"></i>{{ count($order) }}</span>
                            <select name="orderStatus" id="orderStatus" class="form-control col-2">
                                <option value=" ">All</option>
                                <option value="0" @if (request('orderStatus') == '0') selected @endif>Pending</option>
                                <option value="1" @if (request('orderStatus') == '1') selected @endif>Accept</option>
                                <option value="2" @if (request('orderStatus') == '2') selected @endif>Reject</option>
                            </select>
                            <button type="submit" class="btn btn-dark text-white">Search</button>
                        </div>
                    </form>
                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th class="col-2">User Name</th>
                                    <th>Order Date</th>
                                    <th>Order Code</th>
                                    <th>Total amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="dataList">
                                @foreach ($order as $o)
                                    <tr class="tr-shadow">
                                        <input type="hidden" name="" class="orderId" value="{{ $o->id }}">
                                        <td class="">{{ $o->user_id }}</td>
                                        <td class="">{{ $o->user_name }}</td>
                                        <td class="">{{ $o->created_at->format('F-j-Y') }}</td>
                                        <td class="">
                                            <a href="{{ route('admin#listInfo', $o->order_code) }}">{{ $o->order_code }}</a>
                                        </td>
                                        <td class="amount">{{ $o->total_price }} Kyats</td>
                                        <td class="">
                                            <select name="status" class="form-control statusChange">
                                                <option value="0" style=""
                                                    @if ($o->status == 0) selected @endif>Pending</option>
                                                <option value="1" @if ($o->status == 1) selected @endif>
                                                    Accept</option>
                                                <option value="2" @if ($o->status == 2) selected @endif>
                                                    Reject</option>
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- END DATA TABLE -->
                </div>
                <div class="mt-3">
                    {{-- {{$order->links()}} --}}
                    {{-- {{ $categories->appends(request()->query())->links()}} --}}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scriptSection')
    <script>
        $('document').ready(function() {
            // $('#orderStatus').change(function() {
            //     $status = $('#orderStatus').val();

            //     $.ajax({
            //         type: 'get',
            //         url: '/order/ajax/status',
            //         data: {
            //             'status': $status
            //         },
            //         dataType: 'json',
            //         success: function(response) {

            //             $month=['January','February','March','April','May','June','July','August','September','October','November','December'];

            //             $list = '';
            //             for ($i = 0; $i < response.length; $i++) {
            //                 //console.log(`${response[$i].created_at}`);
            //                 $dbDate = new Date(response[$i].created_at);
            //                 $finalDate = $month[$dbDate.getMonth()]+'-'+$dbDate.getDate()+'-'+$dbDate.getFullYear();

            //                 if(response[$i].status == 0){
            //                     $statusMessage = `
        //                     <select name="status" class="form-control statusChange">
        //                             <option value="0" selected>Pending</option>
        //                             <option value="1">Accept</option>
        //                             <option value="2">Reject</option>
        //                         </select>
        //                     `;

            //                 }else if(response[$i].status == 1){
            //                     $statusMessage = `
        //                     <select name="status" class="form-control statusChange">
        //                             <option value="0" >Pending</option>
        //                             <option value="1" selected>Accept</option>
        //                             <option value="2">Reject</option>
        //                         </select>
        //                     `;
            //                 }else{
            //                     $statusMessage = `
        //                     <select name="status" class="form-control statusChange">
        //                             <option value="0" >Pending</option>
        //                             <option value="1">Accept</option>
        //                             <option value="2" selected>Reject</option>
        //                         </select>
        //                     `;
            //                 }

            //                  $list += `
        //                 <tr class="tr-shadow">
        //                     <input type="hidden" class="form-control orderId" value="${response[$i].id}">
        //                     <td > ${response[$i].user_id} </td>
        //                     <td class="col-2"> ${response[$i].user_name} </td>
        //                     <td > ${$finalDate} </td>
        //                     <td > ${response[$i].order_code} </td>
        //                     <td > ${response[$i].total_price}  Kyats</td>
        //                     <td >${$statusMessage}</td>
        //                 </tr>
        //        `;
            //             }
            //             $('#dataList').html($list);
            //         }

            //     })
            // })

            //change status
            $('.statusChange').change(function() {
                console.log('change');
                $parentNode = $(this).parents("tr");
                $orderId = $parentNode.find('.orderId').val();
                $currentStatus = $(this).val();
                $data = {
                    'orderId': $orderId,
                    'status': $currentStatus,
                };
                $.ajax({
                    type: 'get',
                    url: '/order/ajax/change/status',
                    data: $data,
                    dataType: 'json',
                })
                location.reload();
            })
        })
    </script>
@endsection

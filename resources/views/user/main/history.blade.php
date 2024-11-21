@extends('user.layouts.master')
@section('content')
    <!-- Cart Start -->
    <div class="container-fluid" style="height: 500px;">
        <div class="row px-xl-5">
            <div class="col-lg-8 offset-2 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0" id="dataTable">
                    <thead class="thead-dark">
                        <tr>
                            <th>Date</th>
                            <th>Order Id</th>
                            <th>Total Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach ($order as $ord)
                            <tr>
                                <td class="align-middle">{{ $ord->created_at->format('F-j-Y') }}</td>
                                <td class="align-middle">{{ $ord->order_code }}</td>
                                <td class="align-middle">{{ $ord->total_price }}</td>
                                <td class="align-middle">
                                    @if ($ord->status == 0)
                                        <span class="text-warning "><i
                                                class="fa-solid fa-hourglass-half ms-2"></i>Pending...</span>
                                    @elseif($ord->status == 1)
                                        <span class="text-success "><i class="fa-solid fa-circle-check ms-2"></i>Success
                                        </span>
                                    @elseif($ord->status == 2)
                                        <span class="text-danger"><i
                                                class="fa-solid fa-circle-exclamation ms-2"></i>Reject</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">{{ $order->links() }}</div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
@endsection

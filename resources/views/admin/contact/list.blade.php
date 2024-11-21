@extends('admin.layout.master')
@section('content')
   <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <h4 class="mb-2">Lists of Message</h4>
                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Message</th>

                                </tr>
                            </thead>
                            <tbody id="dataList">
                                @foreach ($con as $c)
                                    <tr>
                                        <td>{{ $c->id }}</td>
                                        <td>{{ $c->name }}</td>
                                        <td>{{ $c->email }}</td>
                                        <td>{{ $c->message }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-2">
                            {{-- {{ $con->links() }} --}}
                        </div>
                    </div>
                    <!-- END DATA TABLE -->
                </div>
                <div class="mt-3">
                    {{-- {{ $categories->appends(request()->query())->links()}} --}}
                </div>
            </div>
        </div>
    </div>
@endsection

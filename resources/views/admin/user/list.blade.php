@extends('admin.layout.master')
@section('title', 'Category List')
@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <h4 class="mb-2">Total - {{ $user->total() }}</h4>
                    @if (session('deleteSuccess'))
                        <div class="col-4 offset-8">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                {{ session('deleteSuccess') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif
                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Phone No.</th>
                                    <th>Address</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="dataList">
                                @foreach ($user as $u)
                                    <tr>
                                        {{-- <td class="col-2">
                                            @if ($u->image == null)
                                            @if($u->gender == 'male')
                                                <img src="{{asset('images/user.jpg')}}" class="img-thumbnail shadow-sm">
                                            @else
                                            <img src="{{asset('images/female_default.png')}}">
                                            @endif
                                        @else
                                            <img src="{{asset('storage/'.$u->image)}}" class="img-thumbnail shadow-sm">
                                        @endif
                                        </td> --}}
                                        <input type="hidden" id="userId" value="{{ $u->id }}">
                                        <td class="col-2"><img src="{{asset('storage/'.$u->image)}}" class="img-thumbnail shadow-sm w-50"></td>
                                        <td>{{ $u->name }}</td>
                                        <td>{{ $u->email }}</td>
                                        <td>{{ $u->gender }}</td>
                                        <td>{{ $u->phone }}</td>
                                        <td>{{ $u->address }}</td>
                                        <td>
                                            <select class="form-control statusChange">
                                                <option value="user" @if ($u->role == 'user') selected @endif>
                                                    User</option>
                                                <option value="admin" @if ($u->role == 'admin') selected @endif>
                                                    Admin</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div class="table-data-feature">
                                                <a href="{{ route('user#edit', $u->id) }}">
                                                    <button class="item me-1" data-toggle="tooltip" data-placement="top"
                                                        title="Edit">
                                                        <i class="zmdi zmdi-edit"></i>
                                                    </button></a>
                                                <a href="{{ route('user#delete', $u->id) }}">
                                                    <button class="item me-1" data-toggle="tooltip" data-placement="top"
                                                        title="Delete">
                                                        <i class="zmdi zmdi-delete"></i>
                                                    </button>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-2">
                            {{ $user->links() }}
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
@section('scriptSection')
    <script>
        $(document).ready(function() {
            //change status
            $('.statusChange').change(function() {
                $currentStatus = $(this).val();
                $parentNode = $(this).parents("tr");
                $userId = $parentNode.find('#userId').val();
                console.log($userId);
                $data = {
                    "userId": $userId,
                    'role': $currentStatus
                };
                $.ajax({
                    type: 'get',
                    url: '/user/change/role',
                    data: $data,
                    dataType: 'json'
                })
                location.reload();
            })
        })
    </script>
@endsection

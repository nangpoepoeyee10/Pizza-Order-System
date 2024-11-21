@extends('admin.layout.master')
@section('title','Category List')
@section('content')

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-12">
                <!-- DATA TABLE -->
                <div class="table-data__tool">
                    <div class="table-data__tool-left">
                        <div class="overview-wrap">
                            <h2 class="title-1">Admin List</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <h5 class="text-secondary"> Search key: <span class="text-danger">{{ request('key')}}</span> </h5>
                    </div>
                    <div class="col-3 offset-6 mb-2">
                        <form action="{{ route('admin#list')}}" method="get">
                            <div class="d-flex">
                                <input type="text" name="key" value="{{ request('key')}}" class="form-control" placeholder="search ...">
                                <button class="btn bg-dark text-white" type="submitt"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </form>
                </div>
                </div>
                @if(session('deleteSuccess'))
                <div class="col-4 offset-8" >
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        {{session('deleteSuccess')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-1 offset-10 my-2 bg-white shadow-sm px-2 py-2 text-center">
                    <h3><i class="fa-solid fa-database"></i> &nbsp; {{$admin->total()}} </h3>
                </div>
            </div>

                {{-- @if(count($admin) !=0) --}}
                <div class="table-responsive table-responsive-data2">
                    <table class="table table-data2 text-center">
                        <thead>
                            <tr>
                                <th >Image</th>
                                <th >Category Name</th>
                                <th >Email</th>
                                <th>Gender</th>
                                <th>Phone number</th>
                                <th>Address</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $admin as $a)
                                <tr class="tr-shadow my-2">
                                    <td class="col-2">
                                    @if ($a->image == null)
                                        @if($a->gender == 'male')
                                            <img src="{{asset('images/user.jpg')}}" class="img-thumbnail shadow-sm">
                                        @else
                                        <img src="{{asset('images/female_default.png')}}">
                                        @endif
                                    @else
                                        <img src="{{asset('storage/'.$a->image)}}" class="img-thumbnail shadow-sm">
                                    @endif
                                    </td>
                                <td >{{$a->name}}</td>
                                <td >{{$a->email}}</td>
                                <td>{{$a->gender}}</td>
                                <td>{{$a->phone}}</td>
                                <td>{{$a->address}}</td>
                               <td>
                                <div class="table-data-feature">
                                    {{-- <a href="@if (Auth::user()->id == $a->id) #
                                    @else {{route('admin#delete')}}"> @endif
                                        <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                            <i class="zmdi zmdi-delete"></i>
                                        </button>
                                    </a> --}}
                                    {{-- delete ma paw chin dr --}}
                                    @if (Auth::user()->id == $a->id)
                                    @else
                                    <a href="{{route('admin#changeRole',$a->id)}}">
                                        <button class="item me-1" data-toggle="tooltip" data-placement="top" title="Change Role">
                                           <i class="fa-solid fa-person-circle-minus "></i>
                                        </button>
                                        </a>
                                        <a href="{{route('admin#delete',$a->id)}}">
                                        <button class="item me-1" data-toggle="tooltip" data-placement="top" title="Delete">
                                            <i class="zmdi zmdi-delete"></i>
                                        </button>
                                        </a>
                                    @endif
                                    </div>
                               </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- @else
                <h3 class="text-secondary text-center mt-5">there is no category lists.</h3>
                @endif --}}
                <!-- END DATA TABLE -->
            </div>
            <div class="mt-3">
                {{$admin->links()}}

                {{-- {{ $categories->appends(request()->query())->links()}} --}}
            </div>
        </div>
    </div>
</div>
@endsection

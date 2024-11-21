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
                            <h2 class="title-1">Products List</h2>
                        </div>
                    </div>
                    <div class="table-data__tool-right">
                        <a href="{{route('product#createPage')}}">
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                <i class="fa-solid fa-plus"></i>Add pizza
                            </button>
                        </a>
                        <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                            CSV download
                        </button>
                    </div>
                </div>
                <div class="row">
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
                    <h3><i class="fa-solid fa-database"></i>&nbsp;{{ $pizzas->total()}}</h3>
                </div>
            </div>
            @if (count($pizzas) !=0)
            <div class="table-responsive table-responsive-data2">
                <table class="table table-data2 text-center">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th > Name</th>
                            <th >Price</th>
                            <th >Category</th>
                            <th class="col-3">View Count</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pizzas as $p )
                        <tr class="tr-shadow">
                            <td class="col-5"><img src="{{asset('storage/'.$p->image)}}" class="img-thumbnail shadow-sm w-50"></td>
                            <td class="col-2">{{$p->name}}</td>
                            <td class="col-1">{{$p->price}}</td>
                            <td class="col-2">{{$p->categories_name}}</td>
                            <td class="col-3"><i class="fa fa-solid fa-eye me-2"></i>{{$p->view_count}}</td>
                            <td>
                                <div class="table-data-feature">
                                    <a href="{{route('product#edit',$p->id)}}">
                                    <button class="item me-1" data-toggle="tooltip" data-placement="top" title="View">
                                        <i class="fa-solid fa-eye"></i>
                                    </button></a>
                                    <a href="{{route('product#updatePage',$p->id)}}">
                                        <button class="item me-1" data-toggle="tooltip" data-placement="top" title="Edit">
                                            <i class="zmdi zmdi-edit"></i>
                                        </button></a>

                                    <a href="{{route('product#delete',$p->id)}}">
                                    <button class="item me-1" data-toggle="tooltip" data-placement="top" title="Delete">
                                        <i class="zmdi zmdi-delete"></i>
                                    </button>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
                <div>
                    <h3 class="text-secondary text-center">There is no pizza.</h3>
                </div>
            @endif
                <!-- END DATA TABLE -->
            </div>
            <div class="mt-3">
                {{-- {{ $categories->appends(request()->query())->links()}} --}}
                {{$pizzas->links()}}
            </div>
        </div>
    </div>
</div>
@endsection

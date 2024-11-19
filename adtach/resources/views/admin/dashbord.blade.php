@extends('layout.app')
@extends('admin.nav')
@extends('admin.saidebar')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    @if (Auth::user()->role === 'admin')
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3> ${{ $price }} </h3>

                                    <p>Total Sales</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->

                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3> {{ $userCount }} </h3>

                                    <p>User Registrations</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="{{ route('viewUserTable') }}" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-secondary">
                                <div class="inner">
                                    <h3> {{ $lead }} </h3>

                                    <p>Total Agents Lead Counts</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="{{ route('viewAgentLeadlTable') }}" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h3> {{ $sale }} </h3>

                                    <p>Total Agents Sales Counts</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="{{ route('viewAgentSaleTable') }}" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    @endif
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3> {{ $trial }} </h3>

                                <p>Total Agents Trial Counts</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="{{ route('viewAgentTrialTable') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->

        {{-- <div class="content-wrapper"> --}}

        {{-- @if (is_iterable($productData))
         <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-3 ">
                        <h1 class="m-0 d-inline">Out Of Stock Product</h1>
                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <div class='container-fluid'>
            <div class="row">
                <div class="col-md-12">
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>PRODUCT IMG</th>
                                    <th>PRODUCT TITLE</th>
                                    <th>PRODUCT CATEGORY</th>
                                    <th>PRODUCT BRAND</th>
                                    <th>PRODUCT QTN</th>
                                    <th>PRODUCT STSTUS</th>
                                    <th>ACTIOLN</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productData as $data)
                                    @if ($data['product']->p_qtn == 0)
                                        <tr>
                                            <td>{{ $data['product']->id }}</td>
                                            <td><img style="width: 60px"
                                                    src="{{ asset('storage/' . $data['product']->p_img) }}"
                                                    alt="{{ $data['product']->p_title }}"
                                                    style="width: 100px; height: auto;">
                                            </td>
                                            <td>{{ $data['product']->p_title }}</td>
                                            <td>{{ $data['sub_categories']->s_c_name }}</td>
                                            <td>{{ $data['brand']->brand_name }}</td>
                                            <td> {{ $data['product']->p_qtn }} </td>
                                            <td>
                                                @if ($data['product']->status == 0)
                                                    <p class='text-white d-inline-block bg-danger p-2 mt-2'>Unactive</p>
                                                @else
                                                    <p class='text-white d-inline bg-primary d-inline-block p-2 mt-2'>Active</p>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('out-of-stock',$data['product']->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <a href="{{ route('out-of-stock-destroy',$data['product']->id) }}" class="btn btn-sm btn-danger"><i
                                                        class="fa-solid fa-trash"></i></a>

                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div>
                </div>
            </div>
        </div> --}}



        {{-- @endif --}}
    @endsection

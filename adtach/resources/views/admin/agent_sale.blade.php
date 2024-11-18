@extends('layout.app')
@extends('admin.nav')
@extends('admin.saidebar')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 d-inline">All Agent Sale Report</h1>
                    </div><!-- /.col -->
                    {{-- <div class="col-sm-4">
                        <h1 class="m-0 d-inline"><a href="{{ route('addUser') }}" class="btn btn-primary">Add New</a></h1>
                    </div><!-- /.col --> --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">DashBord</a></li>
                            <li class="breadcrumb-item active">All Agent Sale Report</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <div class='container-fluid'>
            <div class="row">
                <div class="col-md-12">
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            @if (session('success'))
                                <div class="alert alert-success text-center" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>CUSTOMER NAME</th>
                                    <th>CUSTOMER EMAIL</th>
                                    <th>CUSTOMER PHONE</th>
                                    <th>PRICE</th>
                                    <th>REMARKS</th>
                                    <th>STATUS</th>
                                    <th>AGENT NAME</th>
                                    <th>DATE</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $index => $customer)
                                    <tr>
                                        <td> {{ $index + 1 }} </td>
                                        <td> {{ $customer->customer_name }} </td>
                                        <td>{{ $customer->customer_email }}</td>
                                        <td>{{ $customer->customer_number }}</td>
                                        <td>{{ $customer->price }}</td>
                                        <td>{{ $customer->remarks }}</td>
                                        <td><span
                                                class="bg-success py-1 px-2 rounded block mt-5">{{ $customer->status }}</span>
                                        </td>
                                        <td> {{ $customer->user_name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($customer->created_at)->format('d M, Y') }}</td>
                                        <td>
                                            <a href="{{ route('cutomerUPdateSaleDetailFormVIew', $customer->id) }}"
                                                class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                                            <a href="{{ route('deleteSaleCustomerDetails',$customer->id) }}" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div>
                </div>
            </div>
        @endsection

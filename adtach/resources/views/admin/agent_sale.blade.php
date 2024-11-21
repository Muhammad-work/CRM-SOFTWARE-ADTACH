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
                                    <th>MAC ADDRESS</th>
                                    <th>DATE</th>
                                    <th>Sale Status</th>
                                    <th>Sale Expri Days</th>
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
                                        <td>
                                            @if ($customer->make_address)
                                                {{ $customer->make_address }}
                                            @else
                                                No Mac Address
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($customer->created_at)->format('d M, Y') }}</td>
                                        <td>
                                            @if ($customer->active_status !== null)
                                                @if ($customer->active_status == 'active')
                                                    <span class="bg-success py-1 px-2 rounded">Active</span>
                                                @else
                                                    <span class="bg-danger py-1 px-2 rounded">Inactive</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if ($customer->date_count !== null)
                                                @if ($customer->date_count > 0)
                                                    {{ $customer->date_count }}
                                                @else
                                                    <span class="bg-danger py-1 px-2 rounded">Expried</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('cutomerUPdateSaleDetailFormVIew', $customer->id) }}"
                                                class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                                            <a href="{{ route('deleteSaleCustomerDetails', $customer->id) }}"
                                                class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
                                            @if ($customer->active_status !== 'active' && $customer->active_status !== 'inactive')
                                                <a
                                                    href="{{ route('viewSaleDaysForm', $customer->id) }}"class="btn btn-primary ">Sale
                                                    Days</a>
                                            @endif
                                            @if ($customer->active_status === 'inactive')
                                                <a
                                                    href="{{ route('viewupdateSaleCustomerStatus', $customer->id) }}"class="btn btn-primary ">Update
                                                    Sale
                                                    Days</a>
                                            @endif
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

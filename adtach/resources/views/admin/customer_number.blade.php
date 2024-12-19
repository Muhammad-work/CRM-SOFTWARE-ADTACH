@extends('layout.app')
@extends('admin.nav')
@extends('admin.saidebar')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <h1 class="m-0 d-inline">All Customer Numbers Report</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-2">
                        <h1 class="m-0 d-inline"><a href="{{ route('viewCustomerNumberForm') }}" class="btn btn-primary">Add
                                New</a></h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">DashBord</a></li>
                            <li class="breadcrumb-item active">All Customer Numbers Report</li>
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
                                    <th>CUSTOMER NUMBER</th>
                                    <th>AGENT NAME</th>
                                    <th>CALL MONTH</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($allCustomerNumber as $index => $data)
                                    <tr>
                                        <td> {{ $index + 1 }} </td>

                                        <!-- Use \n as line breaks -->
                                        <td>{!! nl2br(e($data->customer_number)) !!}</td>

                                        <td>{{ $data['user']->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($data->date)->format('d M, Y') }}</td>
                                        <td>
                                            <a href="{{ route('editCustomerNumber',$data->id) }}" class="btn btn-primary">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <a href="" class="btn btn-danger">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
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

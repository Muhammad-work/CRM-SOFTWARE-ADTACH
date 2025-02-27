@extends('layout.app')
@extends('admin.nav')
@extends('admin.saidebar')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 d-inline">All Mac Expiry Report</h1>
                    </div><!-- /.col -->
                    {{-- <div class="col-sm-4">
                        <h1 class="m-0 d-inline"><a href="{{ route('addUser') }}" class="btn btn-primary">Add New</a></h1>
                    </div><!-- /.col --> --}}
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
                                    <th>STATUS</th>
                                    <th>AGENT NAME</th>
                                    <th>MAC ADDRESS</th>
                                    <th>MAC ADDRESS EXPIRY DATE</th>
                                    <th>EXPIRY DAYS</th>
                                    <th>EXPIRY MONTHS</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $index => $customer)
                                    <tr>
                                        <td> {{ $index + 1 }} </td>
                                        <td><span
                                                class="bg-success py-1 px-2 rounded block mt-5">{{ $customer->status }}</span>
                                        </td>

                                        <td> {{ $customer['user']->name }}</td>
                                        <td>
                                            @if ($customer->make_address)
                                                {{ $customer->make_address }}
                                            @else
                                                No Mac Address
                                            @endif
                                        </td>
                                        <td>
                                            @if ($customer->expiry_date)
                                                {{ \Carbon\Carbon::parse($customer->expiry_date)->format('d M, Y') }}
                                            @else
                                                No Expiry Date
                                            @endif
                                        </td>
                                        <td>{{ $customer->expired_days }}</td>
                                        <td>{{ $customer->expired_months }}</td>
                                        <td>
                                            <a href="{{ route('cutomerUPdateSaleDetailFormVIew', $customer->id) }}"
                                                class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>
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


            <script>
                let fileByMonth = document.querySelector('#filterbyMonth');
                let FilterMonthForm = document.querySelector('#filterbyMonthForm');
                fileByMonth.addEventListener('change', () => {
                    FilterMonthForm.submit();
                });
            </script>
        @endsection

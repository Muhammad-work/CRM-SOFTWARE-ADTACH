@extends('layout.app')
@extends('admin.nav')
@extends('admin.saidebar')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-3">
                        <h1 class="m-0 d-inline">All Agent Sale Report</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-3">
                        <a href="{{ route('viewAddNewAgentSaleForm') }}" class="btn btn-primary">Add New</a>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <form action="{{ route('filterSaleByDate') }}" method="get" id="filterbyDateForm">
                            <label for="exampleInputEmail1">Filter By Month</label>
                            <input type="month" class="form-control" name="date"
                                aria-label="Text input with 2 dropdown buttons" id="filterbyDate">
                        </form>
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
                                    <th>AGENT NAME</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $index => $customer)
                                    <tr>
                                        <td> {{ $index + 1 }} </td>
                                        <td>{{ $customer['user']->name }}</td>
                                        <td>
                                            <a href="{{ route('viewSaleTable', $customer['user']->id) }}"
                                                class="btn btn-primary"><i class="fa-solid fa-eye"></i></a>
                                            <a href="{{ route('viewAgentDistributeSale', $customer['user']->id) }}"
                                                class="btn btn-primary">Distribute Sale</a>
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
                let filterbyDate = document.querySelector('#filterbyDate');
                let filterbyDateForm = document.querySelector('#filterbyDateForm');
                filterbyDate.addEventListener('change', () => {
                    filterbyDateForm.submit();
                })
            </script>
        @endsection

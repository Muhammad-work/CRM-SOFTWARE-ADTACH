@extends('layout.app')
@extends('admin.nav')
@extends('admin.saidebar')



@section('content')
    {{-- <section class="content"> --}}
    <div class="content-wrapper">
        <div class="container-fluid ">
            <div class="row ">
                <div class="col-12   mt-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="text-center">Update Customer Numbers</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('storeEditCustomerNumberData',$customerNumber->id) }}" method="POST" enctype="multipart/form-data"
                            autocomplete="off">
                            @csrf
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-12 mt-2">
                                        <label for="exampleInputEmail1">Agent Name</label>
                                        <select class="form-select" name="agent" aria-label="Default select example">

                                            {{-- <option selected>-- Aelect Agent Name --</option> --}}
                                            @foreach ($agentName as $agent)
                                                @if ($customerNumber->agent === $agent->id)
                                                    <option value="{{ $customerNumber->agent }}" selected> {{ $agent->name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $agent->id }}"> {{ $agent->name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('agent')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-12 mt-2">
                                        <label for="exampleInputEmail1">Calling Month</label>
                                        <input type="date" class="form-control" name="date" id="exampleInputEmail1"
                                            placeholder="Enter User Email" value="{{ $customerNumber->date }}">
                                        @error('date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>


                                    <div class="col-12 mt-2">
                                        <label for="exampleInputEmail1">Customer Number</label>
                                        <textarea class="form-control" name="customerNumber" placeholder="Enter Customers Numbers" id="floatingTextarea" > {{ $customerNumber->customer_number }} </textarea>
                                        @error('customerNumber')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <a href="{{ route('viewCustomerNumber') }}" class="btn btn-primary">Back</a>
                                <button class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- </section> --}}
@endsection

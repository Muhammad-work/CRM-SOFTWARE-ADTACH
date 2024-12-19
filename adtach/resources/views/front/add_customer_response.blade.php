@extends('layout.index')
@extends('front.nav')

@section('home')
    <div class="container">
        <div class="row mt-7">
            <div class="col-6 mx-auto">
                @if (session('success'))
                    <div class="alert alert-success text-center" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                <form action="{{ route('storeCustomerResponse') }}" method="POST" autocomplete="off">
                    @csrf
                    <h2 class="text-xl font-bold text-center mb-2">Add Customer Response</h2>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Cutomer Name</label>
                        <input type="text" class="form-control" name="customer_name" id="exampleInputEmail1"
                            placeholder="Enter Customer Name" aria-describedby="emailHelp">
                        @error('customer_name')
                            <span class="text-danger"> {{ $message }} </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Customer Number</label>
                        <input type="number" class="form-control" name="customer_number"
                            placeholder="Enter Customer Number" id="exampleInputPassword1">
                        @error('customer_number')
                            <span class="text-danger"> {{ $message }} </span>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Date</label>
                        <input type="date" class="form-control" name="date" placeholder="Enter Make Address"
                                id="exampleInputPassword1">
                        @error('date')
                            <span class="text-danger"> {{ $message }} </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Remarks</label>
                        <textarea class="form-control" name="remarks" placeholder="Enetr Remarks" id="floatingTextarea"></textarea>
                        @error('remarks')
                            <span class="text-danger"> {{ $message }} </span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection

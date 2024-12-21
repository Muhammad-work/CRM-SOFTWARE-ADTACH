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
                <form action="{{ route('storeCustomerNumberEditDetails', $customer->id) }}" method="POST" autocomplete="off">
                    @csrf
                    <h2 class="text-xl font-bold text-center mb-2">Edit Customer Detail</h2>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Customer Name</label>
                        <input type="text" class="form-control" name="customer_name" id="exampleInputEmail1"
                            placeholder="Enter Customer Name" aria-describedby="emailHelp"
                            value="{{ $customer->customer_name }}">
                        @error('customer_name')
                            <span class="text-danger"> {{ $message }} </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Select Status</label>
                        <select class="form-select" name="status" aria-label="Default select example">
                            @if ($customer->status === 'trial')
                                <option selected value="trial">ON Trial</option>
                            @elseif($customer->status === 'not int')
                                <option selected value="not int">Not Intersted</option>
                            @elseif($customer->status === 'vm')
                                <option selected value="vm">VM</option>
                            @elseif($customer->status === 'hung up')
                                <option selected value="hung up">Hung Up</option>
                            @elseif($customer->status === 'not ava')
                                <option selected value="not ava">Not Available</option>
                            @elseif($customer->status === 'not in service')
                                <option selected value="not in service">Not In Service</option>
                            @else
                                <span class="px-2 py-1 bg-success rounded text-white">Pending</span>
                            @endif
                            <option value="trial">ON Trial</option>
                            <option value="not int">Not Intersted</option>
                            <option value="vm">VM</option>
                            <option value="hung up">Hung Up</option>
                            <option value="not ava">Not Available</option>
                            <option value="not in service">Not In Service</option>
                        </select>
                        @error('customer_name')
                            <span class="text-danger"> {{ $message }} </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Remarks</label>
                        <textarea class="form-control" name="remarks" placeholder="Enetr Remarks" id="floatingTextarea"> {{ $customer->remarks }} </textarea>
                        @error('remarks')
                            <span class="text-danger"> {{ $message }} </span>
                        @enderror
                    </div>
                    <a href="{{ route('viewCunstomerNumberTable') }}" class="btn btn-primary">Back</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection

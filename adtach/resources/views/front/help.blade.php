@extends('layout.index')
@extends('front.nav')

@section('home')
  
   <div class="container">
    <div class="row mt-7">
        <div class="col-6 mx-auto">
            <form autocomplete="off">
                <h2 class="text-xl font-bold text-center mb-4">Help Request Form</h2>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Cutomer Name</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter Customer Name" aria-describedby="emailHelp">
                </div>

                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Customer Number</label>
                    <input type="password" class="form-control" placeholder="Enter Customer Number" id="exampleInputPassword1">
                </div>

                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Customer Email</label>
                    <input type="password" class="form-control" placeholder="Enter Customer Email" id="exampleInputPassword1">
                </div>

                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Help Reason</label>
                    <textarea class="form-control" placeholder="Enetr Help Request Reason" id="floatingTextarea"></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
   </div>

@endsection

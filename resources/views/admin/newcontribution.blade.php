@extends('layouts.admin')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">All users</h1>
          </div>

        <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow-lg border-0 rounded-lg mt-2">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Create new Contribution</h3></div>
                        <div class="card-body">

                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                
                                @if (Session::has('account_form_status'))
                                    <div class="alert alert-info" role="alert">
                                        {{ session('contribution_form_status')  }}
                                    </div> 
                                @endif
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                
                            <form method="POST" action="{{ route('accounts.transfer') }}">
                                @csrf
                                <div class="form-group"><label class="small mb-1" for="inputDesc">Description</label><input class="form-control" id="inputDesc" type="text" placeholder="Enter Short Description" name="description" required/></div>
                                <div class="form-group"><label class="small mb-1" for="inputAmount">Amount</label><input class="form-control" id="inputAmount" type="number" placeholder="Enter Amount" name="amount" required/></div>
                                
                                <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block my-4" type="submit">Transfer</button></div>
                                
                            </form>
                            
                        </div>
                        
                    </div>
                </div>
            </div>


        


</div>



@endsection
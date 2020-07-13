@extends('layouts.admin')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">All users</h1>
          </div>

        

        <div class="table-responsive-md">
            <table class="table table-bordered table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Balance</th>
                <th scope="col">Last Update</th>
                <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($accounts as $account)
                    <tr>
                        <th>{{ $account->id }}</th>
                        <td>{{ $account->type }}</td>
                        <td>{{ $account->description }}</td>
                        <td>{{ $account->balance }}</td>
                        <td>{{ $account->updated_at }}</td>
                        <td><a href="#" class="btn btn-success btn-circle btn-sm"><i class="fas fa-check"></i></a></td>
                        
                    </tr>
                     
                @endforeach
            </tbody>
            </table>

        </div>

        <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow-lg border-0 rounded-lg mt-2">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Transfer funds</h3></div>
                        <div class="card-body">

                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                
                                @if (Session::has('account_form_status'))
                                    <div class="alert alert-info" role="alert">
                                        {{ session('trans_form_status')  }}
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
            
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group"><label class="small mb-1" for="inputType">From Account</label>
                                            <select id="inputType" class="form-control" name="name_1">
                                                <option value = "Main" >Main</option>
                                                <option value = "Loan" >Loan</option>
                                                
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group"><label class="small mb-1" for="inputType">To Account</label>
                                            <select id="inputType" class="form-control" name="name_2">
                                                <option value = "Loan" >Loan</option> 
                                                <option value = "Welfare" >Welfare</option>
                                                <option value = "Other" >Other</option>     
                                            </select>
                                        </div>
                                    </div>
                                    
                                    
                                </div>
                                <div class="form-group"><label class="small mb-1" for="inputAmount">Amount</label><input class="form-control" id="inputAmount" type="number" placeholder="Enter Amount" name="amount" required/></div>
                                
                                <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block my-4" type="submit">Transfer</button></div>
                                
                            </form>
                            
                        </div>
                        
                    </div>
                </div>
            </div>


        


</div>



@endsection
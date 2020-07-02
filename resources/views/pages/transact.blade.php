@extends('layouts.app')

@section('content')
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Transact to E-Chama</h3></div>
                        <div class="card-body">

                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                
                                @if (Session::has('trans_form_status'))
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

                                
                            <form method="POST" action="/transactions">
                                @csrf
                                <center><img src="{{ asset('assets/img/mpesa.png') }}" alt="mpesa-logo"></img></center>
                                <div class="form-group"><label class="small mb-1" for="inputPhone">Mpesa Phone</label><input class="form-control" id="inputPhone" type="text" placeholder="e.g. 254722000000" name="phone" required/></div>
            
                                <div class="form-row">
                                    <div class="col-md-5">
                                        <div class="form-group"><label class="small mb-1" for="inputType">Transaction Account</label>
                                            <select id="inputType" class="form-control" name="type">
                                                <option value = "2" >My Wallet</option>
                                                <option value = "1" >Loan Service</option>
                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="form-group"><label class="small mb-1" for="inputAmount">Amount</label><input class="form-control" id="inputAmount" type="number" placeholder="Enter Amount" name="amount" required /></div>
                                    </div>
                                    
                                </div>
                                
                                <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block my-4" type="submit">Send</button></div>
                            </form>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>



@endsection
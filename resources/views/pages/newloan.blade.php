@extends('layouts.app')

@section('content')
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Loan Application Form</h3></div>
                        <div class="card-body">

                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                
                                @if (Session::has('loan_form_status'))
                                    <div class="alert alert-info" role="alert">
                                        {{ session('loan_form_status')  }}
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
                            <form method="POST" action="/loans">
                                @csrf
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group"><label class="small mb-1" for="inputGrantDate">Preferred Fund Date</label><input class="form-control" id="inputGrantDate" type="date" name="grant_date" required/></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"><label class="small mb-1" for="inputRepaymentDate">Preferred Repayment Start Date</label><input class="form-control" id="inputRepaymentDate" type="date" name="repayment_date" required/></div>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="col-md-7">
                                        <div class="form-group"><label class="small mb-1" for="inputAmount">Amount</label><input class="form-control" id="inputAmount" type="number" placeholder="How much do you need?" name="amount" required /></div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group"><label class="small mb-1" for="inputPeriod">Repayment Period</label>
                                            <select id="inputPeriod" class="form-control" name="repayment_period">
                                                <option value = "1" >1 months</option>
                                                <option value = "3" >3 months</option>
                                                <option value = "6" >6 months</option>
                                                <option value = "12" >12 months</option>
                                                <option value = "18" selected>18 months</option>
                                                <option value = "24" selected>24 months</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block my-4" type="submit">Apply</button></div>
                            </form>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>



@endsection
@extends('layouts.app')

@section('content')
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Loan Application Form</h3></div>
                        <div class="card-body">
                            <form method="POST">
                                @csrf
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group"><label class="small mb-1" for="inputGrantDate">Preferred Grant Date</label><input class="form-control" id="inputGrantDate" type="date" name="grantDate" required/></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"><label class="small mb-1" for="inputRepaymentDate">Preferred Repayment Start Date</label><input class="form-control" id="inputRepaymentDate" type="date" name="repaymentDate" required/></div>
                                    </div>
                                </div>
                                <div class="form-group"><label class="small mb-1" for="inputPhone">M-Pesa Phone</label><input class="form-control py-4" id="inputPhone" type="text" placeholder="e.g. 254722000000" name="phone" required/></div>
                                <div class="form-row">
                                    <div class="col-md-7">
                                        <div class="form-group"><label class="small mb-1" for="inputAmount">Amount</label><input class="form-control" id="inputAmount" type="number" placeholder="How much do you need?" name="amount" required /></div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group"><label class="small mb-1" for="inputPeriod">Repayment Period</label>
                                            <select id="inputPeriod" class="form-control" name="repaymentPeriod">
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
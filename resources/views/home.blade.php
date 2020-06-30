@extends('layouts.app')

@section('content')
<div class="container">

        <!-- Status Cards -->
        <div class="row">

            <!-- Contributions (Monthly) Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Contributions (Monthly)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">5,000 <sup>KES<sup></div>
                    </div>
                    
                  </div>
                </div>
              </div>
            </div>

            <!-- Contributions (Total) Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Contributions</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">215,000 <sup>KES</sup></div>
                    </div>
                    
                  </div>
                </div>
              </div>
            </div>

            <!-- Pending Loans Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Loans</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">0 <sup>KES</sup></div>
                    </div>
                    
                  </div>
                </div>
              </div>
            </div>
        </div>

        <!-- End ofStatus cards -->


        <div class="row justify-content-center">

        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                        <div class="wrimagecard wrimagecard-topimage">
                            <a href="#" 
                            onclick=" //modal content setting js 
                            var price = document.getElementById('inputPhone');
                            price.value = 2547;

                                "
                            data-toggle="modal" data-target="#contributeModal">
                            <div class="wrimagecard-topimage_header" style="background-color: rgba(22, 160, 133, 0.1)">
                                <center><i class="fa fa-send" style="color:#16A085"></i></center>
                            </div>
                            <div class="wrimagecard-topimage_title">
                                <h4>Contribute
                                <div class="pull-right badge">7/2020</div></h4>
                            </div>
                            </a>
                        </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                        <div class="wrimagecard wrimagecard-topimage">
                            <a href="{{ route('newloan') }}">
                            <div class="wrimagecard-topimage_header" style="background-color: rgba(22, 160, 133, 0.1)">
                                <center><i class = "fa fa-dollar" style="color:#16A085"></i></center>
                            </div>
                            <div class="wrimagecard-topimage_title">
                                <h4>Loan Application
                                <div class="pull-right badge" id="WrControls"></div></h4>
                            </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="wrimagecard wrimagecard-topimage">
                            <a href="#">
                            <div class="wrimagecard-topimage_header" style="background-color:  rgba(213, 15, 37, 0.1)">
                                <center><i class="fa fa-list" style="color:#d50f25"> </i></center>
                            </div>
                            <div class="wrimagecard-topimage_title" >
                                <h4>Rotation list
                                <div class="pull-right badge" id="WrForms"></div>
                                </h4>
                            </div>
                            
                            </a>
                        </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                        <div class="wrimagecard wrimagecard-topimage">
                            <a href="#">
                            <div class="wrimagecard-topimage_header" style="background-color:  rgba(51, 105, 232, 0.1)">
                                <center><i class="fa fa-table" style="color:#3369e8"> </i></center>
                            </div>
                            <div class="wrimagecard-topimage_title">
                                <h4>Ledger
                                <div class="pull-right badge" id="WrGridSystem"></div></h4>
                            </div>
                            
                            </a>
                        </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                        <div class="wrimagecard wrimagecard-topimage">
                            <a href="#">
                            <div class="wrimagecard-topimage_header" style="background-color:  rgba(250, 188, 9, 0.1)">
                                <center><i class="fa fa-info-circle" style="color:#fabc09"> </i></center>
                            </div>
                            <div class="wrimagecard-topimage_title">
                                <h4>Information
                                <div class="pull-right badge" id="WrInformation"></div></h4>
                            </div>
                            
                            </a>
                        </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                        <div class="wrimagecard wrimagecard-topimage">
                            <a href="#">
                                <div class="wrimagecard-topimage_header" style="background-color: rgba(121, 90, 71, 0.1)">
                            <center><i class="fa fa-user" style="color:#795a47"> </i></center> 
                            </div>
                            <div class="wrimagecard-topimage_title">
                                <h4>Account
                                <div class="pull-right badge" id="WrNavigation"></div></h4>
                            </div>
                            
                            </a>
                        </div>
                        </div>
                        
                    </div>



                   
                </div>
            </div>
        </div>
    </div>
</div>


    <!-- The Modal -->
    <div class="modal " id="contributeModal" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
            <h4 id="item_name" class="modal-title">Contribute through M-Pesa</h4>
            <button onclick="location.reload()" type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body" id="modal_body">
        <center><img src="{{ asset('assets/img/mpesa.png') }}" alt="mpesa-logo"></img></center>
        
        <form method="POST" action=''  class="" enctype = 'multipart/form-data'>
            @csrf
            <div class="form-group"><label class="small mb-1" for="inputPhone">Mpesa Phone</label><input class="form-control" id="inputPhone" type="text" placeholder="e.g. 254722000000" name="phone" required/></div>
            <div class="form-group"><label class="small mb-1" for="inputAmount">Amount</label><input class="form-control" id="inputAmount" type="number" placeholder="Enter Amount" name="amount" required/></div>
            
        </div>

    

        <!-- Modal footer -->
        <div class="modal-footer">
            
            <center><button class="btn btn-success" type="submit" value="Submit" name="upload">Send</button><br><br></center>
            
        </div>
        </form>
        </div>
    </div>
    </div>
    <!--modale end-->


@endsection

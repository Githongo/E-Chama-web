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
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">My Wallet</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{ Auth::user()->wallet }} <sup>KES<sup></div>
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
                                
                    @if (Session::has('form_status'))
                        <div class="alert alert-info" role="alert">
                            {{ session('form_status')  }}
                        </div> 
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <em>Errors:</em>
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                        <div class="wrimagecard wrimagecard-topimage">
                            <a href="{{ route('transactions.index') }}">
                            <div class="wrimagecard-topimage_header" style="background-color: rgba(22, 160, 133, 0.1)">
                                <center><i class = "fa fa-mobile" style="color:#16A085"></i></center>
                                </div>
                                <div class="wrimagecard-topimage_title">
                                    <h4>Transact
                                    <div class="pull-right badge" id="WrControls"></div></h4>
                                </div>
                            </a>
                        </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                        <div class="wrimagecard wrimagecard-topimage">
                            <a href="{{ route('loans.index') }}">
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
                            <a href="{{ route ('home.rotations') }}">
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
                            <a href="#"  data-toggle="modal" data-target="#noticesModal">
                            <div class="wrimagecard-topimage_header" style="background-color:  rgba(51, 105, 232, 0.1)">
                                <center><i class="fa fa-info" style="color:#3369e8"></i></center>
                            </div>
                            <div class="wrimagecard-topimage_title">
                                <h4>Info
                                <div class="pull-right badge"></div></h4>
                            </div>
                            </a>
                        </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                        <div class="wrimagecard wrimagecard-topimage">
                            <a href="#">
                            <div class="wrimagecard-topimage_header" style="background-color:  rgba(250, 188, 9, 0.1)">
                                <center><i class="fa fa-table" style="color:#fabc09"> </i></center>
                            </div>
                            <div class="wrimagecard-topimage_title">
                                <h4>Ledger
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
    <div class="modal" id="noticesModal" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Notices</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body" id="modal_body">
        <p id="modal_content">
        <ol>
            @foreach ($notices as $notice)
                    <li> {{ $notice->message }} </li>                  
            @endforeach
        </ol>
        <p>
        </div>
    </div>
    </div>
    <!--modale end-->



@endsection

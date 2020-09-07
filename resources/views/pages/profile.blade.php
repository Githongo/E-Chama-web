@extends('layouts.app')

@section('content')

    <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Edit Profile details</h3></div>
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

                                
                            <form method="POST" action="/user/updateProfile">
                                @csrf
                                <div class="form-row">
                                    <div class="col d-flex flex-column flex-sm-row justify-content-center mb-3">
                                        <div class="text-center mb-2 mb-sm-0">
                                            <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap">{{ Auth::user()->name}}</h4>
                                            <p>Joined on: {{ Auth::user()->created_at }}</p>
                                            <h5>Wallet: {{ Auth::user()->wallet}} </h5>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group border-0"><label class="small mb-1" for="inputEmail">Your email:</label><input class="form-control" id="inputEmail" type="text" name="email" value="{{ Auth::user()->email }}" required/></div>
            
                                <div class="form-row">
                                    <div class="col-md-7">
                                        <div class="form-group"><label class="small mb-1" for="inputName">Your Name:</label>
                                            <input class="form-control" id="inputName" type="text" name="name" value="{{ Auth::user()->name }}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-5"><label class="small mb-1" for="inputPhone">Your Mpesa Enabled Phone:</label>
                                        <input class="form-control" id="inputPhone" type="number" name="phone" value="{{ Auth::user()->phone }}" required />
                                    </div>
                                </div>

                                
                                
                                <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block my-4" type="submit">SAVE CHANGES</button></div>
                                
                            </form>
 
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>



@endsection
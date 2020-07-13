@extends('layouts.admin')

@section('content')
<!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit User</h1>
          </div>

          <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Edit User: {{ $user->name }}</h3></div>
                        <div class="card-body">
                                
                                @if (Session::has('edit_form_status'))
                                    <div class="alert alert-info" role="alert">
                                        {{ session('edit_form_status')  }}
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

                                
                            <form method="POST" action="{{ route('admin.users.update', $user) }}">
                                @csrf
                                {{ method_field('PUT') }}
                                <center><img src="{{ asset('assets/img/default_profile.png') }}" alt="default profile"></img></center>
                                <label class="small mb-1" for="check-role">Role</label> 
                                @foreach ($roles as $role)
                                    <div class="form-check" id="check-role">
                                        <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                                        @if ($user->roles->pluck('id')->contains($role->id)) checked @endif >
                                        <label>{{ $role->name }}</label>
                                    </div>
                                    
                                @endforeach
                                <div class="form-group"><label class="small mb-1" for="inputPhone">Mpesa Phone</label><input class="form-control" id="inputPhone" type="text" placeholder="e.g. 254722000000" name="phone"/></div>
            
                                
                                <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block my-4" type="submit">SAVE</button></div>
                                
                            </form>
                            
                        </div>
                        
                    </div>
                </div>
            </div>
        

       

        </div>



@endsection
@extends('layouts.admin')

@section('content')
<!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Contributions (Monthly)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">40,000<sup>KES</sup></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Borrowed</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $loanTotal }} <sup>KES</sup></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Interest</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $interestTotal }} <sup>KES</sup></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-funnel-dollar fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Loan Requests</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"> {{ $requestCount }}</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Content Row -->

        <div class="table-responsive-md">
            <table class="table table-bordered table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Roles</th>
                <th scope="col">Rotation</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <th>{{ $user->id }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ implode(', ', $user->roles()->get()->pluck('name')->toArray())  }}</td>
                        <td>
                            @if($user->rotation == true)
                                <a href="#" class="btn btn-success btn-circle btn-sm"><i class="fas fa-check"></i></a>
                            @elseif($user->roatation == false)
                                <a href="#" class="btn btn-secondary btn-circle btn-sm"><i class="fas fa-times"></i></a>
                            @else
                                <a href="#" class="btn btn-secondary btn-circle btn-sm"><i class="fas fa-times"></i></a>
                            @endif
                        
                        </td>
                    </tr>
                     
                @endforeach
            </tbody>
            </table>

        </div>



@endsection
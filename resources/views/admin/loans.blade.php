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
                <th scope="col">Amount</th>
                <th scope="col">Interest</th>
                <th scope="col">Balance</th>
                <th scope="col">Granted on</th>
                <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($loans as $loan)
                    <tr>
                        <th>{{ $loan->id }}</th>
                        <td>{{ $loan->user['name'] }}</td>
                        <td>{{ $loan->amount }}</td>
                        <td>{{ $loan->interest }}</td>
                        <td>{{ $loan->balance }}</td>
                        <td>{{ $loan->grant_date }}</td>
                        <td><a href="#" class="btn btn-success btn-circle btn-sm"><i class="fas fa-check"></i></a></td>
                        
                    </tr>
                     
                @endforeach
            </tbody>
            </table>

        </div>



@endsection
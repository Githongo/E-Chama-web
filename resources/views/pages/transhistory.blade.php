@extends('layouts.app')

@section('content')
<!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{ Auth::user()->name }}'s Transaction History</h1>
          </div>

        

        <div class="table-responsive-md">
            <table class="table table-bordered table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Amount</th>
                <th scope="col">Status</th>
                <th scope="col">Date</th>
                <th scope="col">Type</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                    <tr>
                        <th>{{ $transaction->id }}</th>
                        <td>{{ $transaction->amount }}</td>
                        <td>{{ $transaction->status }}</td>
                        <td>{{ $transaction->created_at  }}</td>
                        <td>
                            @if($transaction->type == 1)
                                <p>Loan Service</p>
                            @elseif($transaction->type == 2)
                                <p>Wallet</p>
                            @else
                                <p>Other</i></p>
                            @endif
                        </td>
                        
                    </tr>
                     
                @endforeach
            </tbody>
            </table>

        </div>



@endsection
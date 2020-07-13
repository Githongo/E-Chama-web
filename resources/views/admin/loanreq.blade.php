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
                <th scope="col">Name</th>
                <th scope="col">Phone</th>
                <th scope="col">Amount</th>
                <th scope="col">Interest</th>
                <th scope="col">Repayment Period</th>
                <th scope="col">Grant Date</th>
                <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($loans as $loan)
                    <tr>
                        <td>{{ $loan->user['name'] }}</td>
                        <td>{{ $loan->user['phone'] }}</td>
                        <td>{{ $loan->amount }}</td>
                        <td>{{ $loan->interest }}</td>
                        <td>{{ $loan->repayment_period }}</td>
                        <td>{{ $loan->grant_date }}</td>
                        <td>
                            <form action="{{ route('loans.update', $loan) }}" method="POST" class="float-left">
                                @csrf
                                {{ method_field('PUT') }}
                                <button type="submit" class="btn btn-success btn-circle btn-sm mr-2"><i class="fas fa-thumbs-up"></i>
                            </form>
                            <form action="{{ route('loans.destroy', $loan) }}" method="POST" class="float-left">
                                @csrf
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-times-circle"></i>
                            </form>
                        </td>
                        
                    </tr>
                     
                @endforeach
            </tbody>
            </table>

        </div>



@endsection
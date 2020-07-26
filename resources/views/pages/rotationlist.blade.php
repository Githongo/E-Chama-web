@extends('layouts.app')

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
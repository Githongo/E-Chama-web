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
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Roles</th>
                <th scope="col">Rotation</th>
                <th scope="col">Actions</th>
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
                        <td>
                            <a href="{{ route('admin.users.edit', $user->id ) }}" class="btn btn-warning btn-circle btn-sm float-left mr-2"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="float-left">
                                @csrf
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-trash"></i>
                            </form>
                        </td>
                    </tr>
                     
                @endforeach
            </tbody>
            </table>

        </div>



@endsection
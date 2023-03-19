@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-4">Couriers</h1>
        <a href="{{ route('couriers.create') }}" class="btn btn-primary mb-3">Add Courier</a>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Link</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($couriers as $courier)
                        <tr>
                            <td>{{ $courier->id }}</td>
                            <td>{{ $courier->name }}</td>
                            <td>{{ $courier->link }}</td>
                            <td>
                                <a href="{{ route('couriers.edit', $courier->id) }}" class="btn btn-primary">Edit</a>
                                <form action="{{ route('couriers.destroy', $courier->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

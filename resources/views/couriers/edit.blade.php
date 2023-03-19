@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Edit Courier</h1>
        <form method="POST" action="{{ route('couriers.update', $courier->id) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $courier->name }}" required>
            </div>
            <div class="mb-3">
                <label for="link" class="form-label">Link:</label>
                <input type="text" class="form-control" id="link" name="link" value="{{ $courier->link }}"
                    required>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
@endsection

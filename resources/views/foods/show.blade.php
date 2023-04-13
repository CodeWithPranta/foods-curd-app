@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1>{{ $food->name }}</h1>
                <p>{{ $food->description }}</p>
                <p>Price: {{ $food->price }}</p>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6">
                <a href="{{ route('foods.index') }}" class="btn btn-secondary">Back to List</a>
                <a href="{{ route('foods.edit', $food->id) }}" class="btn btn-primary">Edit Food</a>
                <form action="{{ route('foods.destroy', $food->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this food?')">Delete Food</button>
                </form>
            </div>
        </div>
    </div>
@endsection

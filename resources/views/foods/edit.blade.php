@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Edit Food</h1>
        <form action="{{ route('foods.update', $food->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group mb-3">
                <label for="name">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $food->name) }}" required autofocus>
                @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="description">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description', $food->description) }}</textarea>
                @error('description')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="price">Price</label>
                <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $food->price) }}" min="0" required>
                @error('price')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <input type="hidden" name="latitude" id="latitude" value="{{$food->latitude}}">
            <input type="hidden" name="longitude" id="longitude" value="{{$food->longitude}}">
            <button type="submit" class="btn btn-primary">Update Food</button>
        </form>
    </div>
@endsection

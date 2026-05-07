@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Car</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('cars.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="reg_number" class="form-label">Registration Number</label>
                <input type="text"
                       name="reg_number"
                       id="reg_number"
                       class="form-control @error('reg_number') is-invalid @enderror"
                       value="{{ old('reg_number') }}">

                @error('reg_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="brand" class="form-label">Brand</label>
                <input type="text"
                       name="brand"
                       id="brand"
                       class="form-control @error('brand') is-invalid @enderror"
                       value="{{ old('brand') }}">

                @error('brand')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="model" class="form-label">Model</label>
                <input type="text"
                       name="model"
                       id="model"
                       class="form-control @error('model') is-invalid @enderror"
                       value="{{ old('model') }}">

                @error('model')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="owner_id" class="form-label">Owner</label>
                <select name="owner_id"
                        id="owner_id"
                        class="form-select @error('owner_id') is-invalid @enderror">
                    <option value="">Select owner</option>
                    @foreach ($owners as $owner)
                        <option value="{{ $owner->id }}" {{ old('owner_id') == $owner->id ? 'selected' : '' }}>
                            {{ $owner->name }} {{ $owner->surname }}
                        </option>
                    @endforeach
                </select>

                @error('owner_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="photos" class="form-label">Car Photos</label>
                <input type="file"
                       name="photos[]"
                       id="photos"
                       multiple
                       accept="image/*"
                       class="form-control @error('photos.*') is-invalid @enderror">

                @error('photos.*')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                <small class="text-muted">
                    You can upload multiple photos. Allowed: jpg, jpeg, png, webp. Max size: 2MB each.
                </small>
            </div>

            <button type="submit" class="btn btn-primary">Create</button>
            <a href="{{ route('cars.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </form>
    </div>
@endsection
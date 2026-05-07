@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Edit Car</h2>

            <div class="d-flex gap-2">
                <a href="{{ route('cars.show', $car) }}" class="btn btn-outline-primary">
                    View
                </a>

                <a href="{{ route('cars.index') }}" class="btn btn-outline-dark">
                    Back
                </a>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($car->photos->count())
            <div class="card shadow-sm mb-3">
                <div class="card-header">
                    Existing Car Photos
                </div>

                <div class="card-body">
                    <div class="row g-3">
                        @foreach($car->photos as $photo)
                            <div class="col-md-3">
                                <div class="card h-100">
                                    <img src="{{ asset('storage/' . $photo->path) }}"
                                         class="card-img-top"
                                         style="height: 160px; object-fit: cover;"
                                         alt="Car photo">

                                    <div class="card-body text-center">
                                        <form action="{{ route('car-photos.destroy', $photo) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Delete this photo?')">
                                                Delete Photo
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('cars.update', $car) }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="row g-3">
                    @csrf
                    @method('PUT')

                    <div class="col-md-6">
                        <label class="form-label">Registration Number</label>
                        <input type="text"
                               name="reg_number"
                               value="{{ old('reg_number', $car->reg_number) }}"
                               class="form-control @error('reg_number') is-invalid @enderror">

                        @error('reg_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Brand</label>
                        <input type="text"
                               name="brand"
                               value="{{ old('brand', $car->brand) }}"
                               class="form-control @error('brand') is-invalid @enderror">

                        @error('brand')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Model</label>
                        <input type="text"
                               name="model"
                               value="{{ old('model', $car->model) }}"
                               class="form-control @error('model') is-invalid @enderror">

                        @error('model')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Owner</label>
                        <select name="owner_id" class="form-select @error('owner_id') is-invalid @enderror">
                            <option value="">Select owner</option>
                            @foreach ($owners as $owner)
                                <option value="{{ $owner->id }}"
                                    {{ old('owner_id', $car->owner_id) == $owner->id ? 'selected' : '' }}>
                                    {{ $owner->name }} {{ $owner->surname }}
                                </option>
                            @endforeach
                        </select>

                        @error('owner_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label">Upload New Photos</label>
                        <input type="file"
                               name="photos[]"
                               multiple
                               accept="image/*"
                               class="form-control @error('photos.*') is-invalid @enderror">

                        @error('photos.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <small class="text-muted">
                            You can upload additional photos. Existing photos will not be removed.
                        </small>
                    </div>

                    <div class="col-12 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            Update
                        </button>

                        <a href="{{ route('cars.index') }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-3 d-flex gap-2">
            <form action="{{ route('cars.destroy', $car) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger"
                        onclick="return confirm('Delete this car?')">
                    Delete car
                </button>
            </form>
        </div>
    </div>
@endsection
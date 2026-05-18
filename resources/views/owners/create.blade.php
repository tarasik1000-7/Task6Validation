@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Add Owner</h2>

            <a href="{{ route('owners.index') }}" class="btn btn-outline-dark">
                Back
            </a>
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

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('owners.store') }}" method="POST" class="row g-3">
                    @csrf

                    <div class="col-md-6">
                        <label class="form-label">Name</label>
                        <input type="text"
                               name="name"
                               value="{{ old('name') }}"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="Enter name">

                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Surname</label>
                        <input type="text"
                               name="surname"
                               value="{{ old('surname') }}"
                               class="form-control @error('surname') is-invalid @enderror"
                               placeholder="Enter surname">

                        @error('surname')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    @if(auth()->user()->isAdmin())
                        <div class="col-md-6">
                            <label class="form-label">Insurance Agent</label>

                            <select name="user_id"
                                    class="form-select @error('user_id') is-invalid @enderror">
                                <option value="">Select insurance agent</option>

                                @foreach($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} - {{ $user->email }}
                                    </option>
                                @endforeach
                            </select>

                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif

                    <div class="col-12 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            Save
                        </button>

                        <a href="{{ route('owners.index') }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
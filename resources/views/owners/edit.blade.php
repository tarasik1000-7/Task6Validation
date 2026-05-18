@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Edit Owner</h2>

            <div class="d-flex gap-2">
                <a href="{{ route('owners.show', $owner) }}" class="btn btn-outline-primary">
                    View
                </a>

                <a href="{{ route('owners.index') }}" class="btn btn-outline-dark">
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

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('owners.update', $owner) }}" method="POST" class="row g-3">
                    @csrf
                    @method('PUT')

                    <div class="col-md-6">
                        <label class="form-label">Name</label>
                        <input type="text"
                               name="name"
                               value="{{ old('name', $owner->name) }}"
                               class="form-control @error('name') is-invalid @enderror">

                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Surname</label>
                        <input type="text"
                               name="surname"
                               value="{{ old('surname', $owner->surname) }}"
                               class="form-control @error('surname') is-invalid @enderror">

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
                                        {{ old('user_id', $owner->user_id) == $user->id ? 'selected' : '' }}>
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
                            Update
                        </button>

                        <a href="{{ route('owners.index') }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        @if(auth()->user()->isAdmin() || auth()->id() === $owner->user_id)
            <div class="mt-3 d-flex gap-2">
                <form action="{{ route('owners.destroy', $owner) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button class="btn btn-danger"
                            onclick="return confirm('Delete this owner?')">
                        Delete owner
                    </button>
                </form>
            </div>
        @endif
    </div>
@endsection
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1>{{ $owner->name }} {{ $owner->surname }}</h1>
                <p class="text-muted mb-0">Owner ID: {{ $owner->id }}</p>

                @if($owner->user)
                    <p class="text-muted mb-0">
                        Insurance Agent: {{ $owner->user->name }} - {{ $owner->user->email }}
                    </p>
                @endif
            </div>

            <a href="{{ route('owners.index') }}" class="btn btn-outline-dark">
                Back
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-header">
                Cars of this owner
            </div>

            <div class="card-body p-0">
                @if($owner->cars->count())
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0 align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Reg #</th>
                                    <th>Brand</th>
                                    <th>Model</th>
                                    <th>Owner</th>
                                    <th>Photos</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($owner->cars as $car)
                                    <tr>
                                        <td>{{ $car->id }}</td>
                                        <td>
                                            <strong>{{ $car->reg_number }}</strong>
                                        </td>
                                        <td>{{ $car->brand }}</td>
                                        <td>{{ $car->model }}</td>
                                        <td>{{ $owner->name }} {{ $owner->surname }}</td>

                                        <td>
                                            @if($car->photos->count())
                                                <div class="d-flex gap-2 flex-wrap">
                                                    @foreach($car->photos as $photo)
                                                        <img src="{{ asset('storage/' . $photo->path) }}"
                                                             alt="Car photo"
                                                             style="width: 90px; height: 60px; object-fit: cover; border-radius: 6px;">
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-muted">No photos</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-3">
                        <span class="text-muted">This owner has no cars yet.</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
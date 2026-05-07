@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>{{ __('messages.car_details') }}</h2>

            <div class="d-flex gap-2">
                <a href="{{ route('cars.index') }}" class="btn btn-outline-dark">
                    {{ __('messages.back') }}
                </a>

                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('cars.edit', $car) }}" class="btn btn-warning">
                        {{ __('messages.edit') }}
                    </a>
                @endif
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">

                <p>
                    <strong>ID:</strong>
                    {{ $car->id }}
                </p>

                <p>
                    <strong>{{ __('messages.reg_number') }}:</strong>
                    {{ $car->reg_number }}
                </p>

                <p>
                    <strong>{{ __('messages.brand') }}:</strong>
                    {{ $car->brand }}
                </p>

                <p>
                    <strong>{{ __('messages.model') }}:</strong>
                    {{ $car->model }}
                </p>

                <p>
                    <strong>{{ __('messages.owner') }}:</strong>

                    @if($car->owner)
                        <a href="{{ route('owners.show', $car->owner) }}"
                           class="text-decoration-none">
                            {{ $car->owner->name }}
                            {{ $car->owner->surname }}
                        </a>
                    @else
                        —
                    @endif
                </p>

                <hr>

                <h4 class="mb-3">
                    Car Photos
                </h4>

                @if($car->photos->count())

                    <div class="row g-3">
                        @foreach($car->photos as $photo)

                            <div class="col-md-3">
                                <div class="card shadow-sm h-100">

                                    <img
                                        src="{{ asset('storage/' . $photo->path) }}"
                                        class="card-img-top"
                                        style="height: 220px; object-fit: cover;"
                                        alt="Car photo">

                                </div>
                            </div>

                        @endforeach
                    </div>

                @else

                    <div class="alert alert-info">
                        No photos uploaded for this car.
                    </div>

                @endif

            </div>
        </div>
    </div>
@endsection
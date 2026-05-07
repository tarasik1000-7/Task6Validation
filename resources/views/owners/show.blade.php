@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2 class="mb-1">{{ $owner->name }} {{ $owner->surname }}</h2>
                <div class="text-muted">{{ __('messages.owner_id') }}: {{ $owner->id }}</div>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('owners.index') }}" class="btn btn-outline-dark">
                    {{ __('messages.back') }}
                </a>

                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('owners.edit', $owner) }}" class="btn btn-warning">
                        {{ __('messages.edit') }}
                    </a>

                    <a href="{{ route('cars.create') }}" class="btn btn-primary">
                        {{ __('messages.add_car') }}
                    </a>
                @endif
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header fw-semibold">
                {{ __('messages.cars_of_owner') }}
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-0 align-middle">
                    <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>{{ __('messages.reg_number') }}</th>
                        <th>{{ __('messages.brand') }}</th>
                        <th>{{ __('messages.model') }}</th>
                        <th>{{ __('messages.owner') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($owner->cars as $car)
                        <tr>
                            <td>{{ $car->id }}</td>
                            <td><strong>{{ $car->reg_number }}</strong></td>
                            <td>{{ $car->brand }}</td>
                            <td>{{ $car->model }}</td>
                            <td>{{ $car->owner?->name }} {{ $car->owner?->surname }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                {{ __('messages.no_cars_found') }}
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if(auth()->user()->role === 'admin')
            <div class="mt-3">
                <form action="{{ route('owners.destroy', $owner) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button class="btn btn-danger"
                            onclick="return confirm('Delete this owner?')">
                        {{ __('messages.delete_owner') }}
                    </button>
                </form>
            </div>
        @endif
    </div>
@endsection
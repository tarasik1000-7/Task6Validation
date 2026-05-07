@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>{{ __('messages.cars') }}</h2>

            <div class="d-flex gap-2">
                <a href="{{ route('owners.index') }}" class="btn btn-outline-dark">
                    {{ __('messages.owners') }}
                </a>

                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('cars.create') }}" class="btn btn-primary">
                        {{ __('messages.add_car') }}
                    </a>
                @endif
            </div>
        </div>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>{{ __('messages.reg_number') }}</th>
                <th>{{ __('messages.brand') }}</th>
                <th>{{ __('messages.model') }}</th>
                <th>{{ __('messages.owner') }}</th>
                <th width="220">{{ __('messages.actions') }}</th>
            </tr>
            </thead>
            <tbody>
            @forelse($cars as $car)
                <tr>
                    <td>{{ $car->id }}</td>
                    <td><strong>{{ $car->reg_number }}</strong></td>
                    <td>{{ $car->brand }}</td>
                    <td>{{ $car->model }}</td>
                    <td>
                        @if($car->owner)
                            <a href="{{ route('owners.show', $car->owner) }}" class="text-decoration-none">
                                {{ $car->owner->name }} {{ $car->owner->surname }}
                            </a>
                        @else
                            —
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('cars.show', $car) }}" class="btn btn-sm btn-primary">
                            {{ __('messages.view') }}
                        </a>

                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('cars.edit', $car) }}" class="btn btn-sm btn-warning">
                                {{ __('messages.edit') }}
                            </a>

                            <form action="{{ route('cars.destroy', $car) }}"
                                  method="POST"
                                  style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Delete this car?')">
                                    {{ __('messages.delete') }}
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">{{ __('messages.no_cars_found') }}</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="mt-3">
            {{ $cars->links() }}
        </div>
    </div>
@endsection
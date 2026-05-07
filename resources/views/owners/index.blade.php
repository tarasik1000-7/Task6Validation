@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>{{ __('messages.car_owners') }}</h2>

            <div class="d-flex gap-2">
                <a href="{{ route('cars.index') }}" class="btn btn-outline-dark">
                    {{ __('messages.cars') }}
                </a>

                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('owners.create') }}" class="btn btn-primary">
                        {{ __('messages.add_owner') }}
                    </a>
                @endif
            </div>
        </div>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>{{ __('messages.name') }}</th>
                    <th>{{ __('messages.surname') }}</th>
                    <th width="240">{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($owners as $owner)
                    <tr>
                        <td>{{ $owner->id }}</td>
                        <td>{{ $owner->name }}</td>
                        <td>{{ $owner->surname }}</td>
                        <td>
                            <a href="{{ route('owners.show', $owner) }}" class="btn btn-sm btn-primary">
                                {{ __('messages.view') }}
                            </a>

                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('owners.edit', $owner) }}" class="btn btn-sm btn-warning">
                                    {{ __('messages.edit') }}
                                </a>

                                <form action="{{ route('owners.destroy', $owner) }}"
                                      method="POST"
                                      style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete this owner?')">
                                        {{ __('messages.delete') }}
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">{{ __('messages.no_owners_found') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
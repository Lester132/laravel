@extends('layouts.app')

@section('content')
    <h1>{{ $user->first_name }}'s Appointment History</h1>

    @if($appointments->isEmpty())
        <p>No appointments found for this user.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Service Type</th>
                    <th>Appointment Date</th>
                    <th>Appointment Time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->service_type }}</td>
                        <td>{{ $appointment->appointment_date }}</td>
                        <td>{{ $appointment->appointment_time }}</td>
                        <td>{{ $appointment->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination links -->
        {{ $appointments->links() }}
    @endif
@endsection

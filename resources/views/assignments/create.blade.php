@extends('layouts.app')

@section('page-title', 'Assignment Management')

@if (isset($assignment))
    @section('sub-page-title', 'Update Assignment')
@else
  @section('sub-page-title', 'Add New Assignment')
@endif

@section('content')
<div class="container-fluid">
    <div class="card w-70">
        <div class="card-header">
           <h5> {{ isset($assignment) ? 'Update Assignment' : 'Add New Assignment' }} </h5>
        </div>
        <div class="card-body">
            <form id="assignmentForm" action="{{ isset($assignment) ? route('assignments.update', ['assignment' => $assignment->id]) : route('assignments.store') }}" method="POST">
                @csrf
                @if(isset($assignment))
                 @method('PUT')
                @endif

                <div class="form-group col-md-6">
                    <label for="driver_profile_id">Driver Profile<span class="text-danger">*</span></label>
                    <select name="driver_profile_id" id="driver_profile_id" class="form-control" required>
                        <option value="">Select Driver Profile</option>
                        @foreach($driverProfiles as $driverProfile)
                            <option value="{{ $driverProfile->id }}" {{ old('driver_profile_id', $assignment->driver_profile_id ?? '') == $driverProfile->id ? 'selected' : '' }}>
                                {{ $driverProfile->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="assigned_vehicle">Assigned Vehicle<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="assigned_vehicle" id="assigned_vehicle" value="{{ old('assigned_vehicle', $assignment->assigned_vehicle ?? '') }}" placeholder="Assigned Vehicle" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="route_details">Route Details<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="route_details" id="route_details" value="{{ old('route_details', $assignment->route_details ?? '') }}" placeholder="Route Details" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="incident_reports">Incident Reports (Optional)</label>
                    <textarea class="form-control" rows="4" name="incident_reports" id="incident_reports" placeholder="Incident Reports">{{ old('incident_reports', $assignment->incident_reports ?? '') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">{{ isset($assignment) ? 'Update Assignment' : 'Add Assignment' }}</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('#assignmentForm').on('submit', function(event) {
            event.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                dataType: 'json',
                data: formData,
                success: function(response) {
                    Swal.fire('Success!', response.message, 'success')
                    .then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '{{ route('assignments.index') }}';
                        }
                    });
                },
                error: function(xhr) {
                    const errors = xhr.responseJSON.errors;
                    let errorMessage = '';
                    for (let field in errors) {
                        if (errors.hasOwnProperty(field)) {
                            errorMessage += `${errors[field].join('\n')}\n`;
                        }
                    }

                    Swal.fire('Error!', errorMessage || 'An unexpected error occurred.', 'error');
                }
            });
        });
    });
</script>

@endsection

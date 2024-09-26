@extends('layouts.app')

@section('page-title', 'Performance Record Management')

@if (isset($performanceRecord))
    @section('sub-page-title', 'Update ')
@else
  @section('sub-page-title', 'Add ')
@endif

@section('content')
{{-- @dd($performanceRecord) --}}
<div class="container-fluid">
    <div class="card w-70">
        <div class="card-header">
            <h5>{{ isset($performanceRecord) ? 'Update Performance Record' : 'Add New Performance Record' }} </h5>
        </div>
        <div class="card-body">
            <form id="performanceRecordForm" action="{{ isset($performanceRecord) ? route('performance-records.update', $performanceRecord->id) : route('performance-records.store') }}" method="POST">
                @csrf
                @if(isset($performanceRecord))
                    @method('PUT')
                @endif

                <div class="form-group col-md-6">
                    <label for="driver_profile_id">Driver Profile<span class="text-danger">*</span></label>
                    <select name="driver_profile_id" id="driver_profile_id" class="form-control" required>
                        <option value="">Select Driver Profile</option>
                        @foreach($driverProfiles as $driverProfile)
                            <option value="{{ $driverProfile->id }}" {{ old('driver_profile_id', $performanceRecord->driver_profile_id ?? '') == $driverProfile->id ? 'selected' : '' }}>
                                {{ $driverProfile->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="on_time_delivery_rate">On-Time Delivery Rate (%)<span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="on_time_delivery_rate" id="on_time_delivery_rate" value="{{ old('on_time_delivery_rate', $performanceRecord->on_time_delivery_rate ?? '') }}" placeholder="On-Time Delivery Rate" required step="0.01">
                </div>

                <div class="form-group col-md-6">
                    <label for="incident_involvements">Incident Involvements<span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="incident_involvements" id="incident_involvements" value="{{ old('incident_involvements', $performanceRecord->incident_involvements ?? '') }}" placeholder="Incident Involvements" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="maintenance_compliance">Maintenance Compliance<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="maintenance_compliance" id="maintenance_compliance" value="{{ old('maintenance_compliance', $performanceRecord->maintenance_compliance ?? '') }}" placeholder="Maintenance Compliance" required>
                </div>

                <button type="submit" class="btn btn-primary">{{ isset($performanceRecord) ? 'Update Performance Record' : 'Add Performance Record' }}</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('#performanceRecordForm').on('submit', function(event) {
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
                            window.location.href = '{{ route('performance-records.index') }}';
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

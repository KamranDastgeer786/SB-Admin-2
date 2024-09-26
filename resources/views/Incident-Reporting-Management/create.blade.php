@extends('layouts.app')
@section('page-title', 'Incident Reporting Management')

@if (isset($incidentView))
    @section('sub-page-title', 'Update ')
@else
  @section('sub-page-title', 'Add')
@endif




@section('content')

{{-- @dd($incidentView); --}}
<div class="container-fluid">
    <div class="card w-70">
        <div class="card-header">
           <h5> {{ isset($incidentView) ? 'Update Incident View Reporting Management' : 'Add New Incident View Reporting Management' }} </h5>
        </div>
        <div class="card-body">
            <form id="incidentViewForm" action="{{ isset($incidentView) ? route('incidentViews.update', ['incidentView' => $incidentView->id]) : route('incidentViews.store') }}" method="POST">
                @csrf
                @if(isset($incidentView))
                    @method('PUT')
                @endif

                <div class="form-group col-md-6">
                    <label for="date_time">Date and Time<span class="text-danger">*</span></label>
                    <input type="datetime-local" class="form-control" name="date_time" id="date_time" value="{{ old('date_time', isset($incidentView) ? $incidentView->date_time->format('Y-m-d\TH:i') : '') }}" placeholder="Date and Time" max="" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="status">Status<span class="text-danger">*</span></label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="">Select Status</option>
                        <option value="Pending" {{ old('status', isset($incidentView) ? $incidentView->status : '') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Reviewed" {{ old('status', isset($incidentView) ? $incidentView->status : '') == 'Reviewed' ? 'selected' : '' }}>Reviewed</option>
                        <option value="Closed" {{ old('status', isset($incidentView) ? $incidentView->status : '') == 'Closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="assigned_reviewer">Assigned Reviewer<span class="text-danger">*</span></label>
                    <select name="assigned_reviewer" id="assigned_reviewer" class="form-control" required>
                        @foreach($users as $user)  
                            <option value="{{ $user->id }}" {{ old('assigned_reviewer', $incidentView->assigned_reviewer ?? '') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">{{ isset($incidentView) ? 'Update Incident View' : 'Add Incident View' }}</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {

        // Set the max attribute to the current date and time in the datetime-local field
        let now = new Date();
        let formattedNow = now.toISOString().slice(0, 16); // Get current date and time in the 'YYYY-MM-DDTHH:MM' format
        $('#date_time').attr('max', formattedNow);

        $('#incidentViewForm').on('submit', function(event) {
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
                            window.location.href = '{{ route('incidentViews.index') }}';
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

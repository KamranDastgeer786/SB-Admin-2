@extends('layouts.app')
@section('page-title', 'Incident Report Submission')

@if (isset($incidentReport))
    @section('sub-page-title', 'Update Report')
@else
  @section('sub-page-title', 'Add Incident Report')
@endif

@section('content')


<div class="container-fluid">
    <div class="row">
        <form id="incidentReportForm" action="{{ isset($incidentReport) ? route('incident_reports.update', ['incident_report' => $incidentReport->id]) : route('incident_reports.store') }}" method="POST" enctype="multipart/form-data">
             
            @csrf
            @if(isset($incidentReport))
                @method('PUT')
            @endif

            <div class="col-sm-8">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group col-md-12">
                            <label for="incident_date_time">Incident Date and Time<span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control" name="incident_date_time" id="incident_date_time" value="{{ old('incident_date_time', isset($incidentReport) ? $incidentReport->incident_date_time->format('Y-m-d\TH:i') : '') }}" required>
                        </div>
                        
                        <div class="form-group col-md-12">
                            <label for="location">Location of Incident<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="location" id="location" value="{{ old('location', $incidentReport->location ?? '') }}" placeholder="Location of Incident" required>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="description">Description of Incident<span class="text-danger">*</span></label>
                            <textarea class="form-control" name="description" id="description" placeholder="Description of Incident" rows="4" required>{{ old('description', $incidentReport->description ?? '') }}</textarea>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="names_individuals_involved">Names of Individuals Involved<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="names_individuals_involved" id="names_individuals_involved" value="{{ old('names_individuals_involved', $incidentReport->names_individuals_involved ?? '') }}" placeholder="Names of Individuals Involved" required>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="roles_in_incident">Roles in Incident<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="roles_in_incident" id="roles_in_incident" value="{{ old('roles_in_incident', $incidentReport->roles_in_incident ?? '') }}" placeholder="Roles in Incident" required>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="contact_information">Contact Information<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="contact_information" id="contact_information" value="{{ old('contact_information', $incidentReport->contact_information ?? '') }}" placeholder="Contact Information" required>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="attachments">Attachments (optional)</label>
                            <input type="file" class="form-control" name="attachments" id="attachments">
                        </div>

                        <div class="form-group col-md-12">
                            <label for="witness_statements">Witness Statements (optional)</label>
                            <textarea class="form-control" name="witness_statements" id="witness_statements" placeholder="Witness Statements" rows="4">{{ old('witness_statements', $incidentReport->witness_statements ?? '') }}</textarea>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="submitted_by">Submitted By<span class="text-danger">*</span></label>
                            <select name="submitted_by" class="form-control" id="submitted_by" required>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('submitted_by', $incidentReport->submitted_by ?? '') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="submission_date">Submission Date<span class="text-danger">*</span></label>
                            <input type="date" name="submission_date" class="form-control" id="submission_date" value="{{ old('submission_date', isset($incidentReport) ? $incidentReport->submission_date->format('Y-m-d') : '') }}" required>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-sm-4" style="margin-left: 65%; margin-top: -98.5%;">
                <div class="card w-100">
                    <div class="card-header">
                        Incident Status
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="status" id="status" value="{{ old('status', $incidentReport->status ?? 'Pending') }}">
                        <button type="button" class="btn btn-primary" onclick="submitForm('Pending')">Pending</button>
                        <button type="button" class="btn btn-secondary" onclick="submitForm('Reviewed')">Reviewed</button>
                        <button type="button" class="btn btn-success" onclick="submitForm('Closed')">Closed</button>
                    </div>
                </div>
            </div>
        </form>
        
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function submitForm(status) {
    $('#status').val(status);
    $('#incidentReportForm').submit();
}

$(document).ready(function() {
    // Set maximum date and time to current time for the incident_date_time field
        const now = new Date();
        const formattedNow = now.toISOString().slice(0, 16); // Format to match the datetime-local input
        $('#incident_date_time').attr('max', formattedNow);

        $('#incidentReportForm').on('submit', function(event) {
            const selectedDateTime = new Date($('#incident_date_time').val());

            // Check if the selected date and time is in the future
            if (selectedDateTime > now) {
                event.preventDefault();
                Swal.fire(
                    'Error!',
                    'Incident Date and Time cannot be in the future.',
                    'error'
                );
                return false;
            }

            event.preventDefault();
            
            var formData = new FormData($(this)[0]);

        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.fire(
                    'Success!',
                    response.message,
                    'success'
                ).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '{{ route('incident_reports.index') }}';
                    }
                });
            },
            error: function(xhr, status, error) {
                const errors = xhr.responseJSON.errors;
                let errorMessage = '';
                for (let field in errors) {
                    if (errors.hasOwnProperty(field)) {
                        errorMessage += `${errors[field].join('\n')}\n`;
                    }
                }

                Swal.fire(
                    'Error!',
                    errorMessage,
                    'error'
                );
            }
        });
    });
});
</script>




@endsection
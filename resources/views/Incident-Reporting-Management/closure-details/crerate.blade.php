@extends('layouts.app')

@section('page-title', 'Closure Detail')

@if (isset($closureDetail))
    @section('sub-page-title', 'Update Closure Detail ')
@else
  @section('sub-page-title', 'Add Closure Detail')
@endif

@section('content')
<div class="container-fluid">
    <div class="card w-70">
        <div class="card-header">
           <h5> {{ isset($closureDetail) ? 'Update Closure Detail' : 'Add New Closure Detail' }} </h5>
        </div>
        <div class="card-body">
            <form id="closureDetailForm" action="{{ isset($closureDetail) ? route('closureDetails.update', ['closureDetail' => $closureDetail->id]) : route('closureDetails.store') }}" method="POST">
                @csrf
                @if(isset($closureDetail))
                    @method('PUT')
                @endif

                <div class="form-group col-md-6">
                    <label for="incident_view_id">Incident View<span class="text-danger">*</span></label>
                    <select name="incident_view_id" id="incident_view_id" class="form-control" required>
                        <option value="">Select Incident View</option>
                        @foreach($incidentViews as $incidentView)
                            <option value="{{ $incidentView->id }}" {{ old('incident_view_id', isset($closureDetail) ? $closureDetail->incident_view_id : '') == $incidentView->id ? 'selected' : '' }}>
                                {{ $incidentView->id }}
                            </option>
                        @endforeach
                    </select>
                    @error('incident_view_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="closing_date">Closing Date</label>
                    <input type="date" class="form-control" name="closing_date" id="closing_date" value="{{ old('closing_date', isset($closureDetail) ? $closureDetail->closing_date : '') }}">
                    @error('closing_date')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="final_report">Final Report (Optional)</label>
                    <textarea class="form-control" rows="4" name="final_report" id="final_report">{{ old('final_report', isset($closureDetail) ? $closureDetail->final_report : '') }}</textarea>
                    @error('final_report')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="resolution_summary">Resolution Summary (Optional)</label>
                    <textarea class="form-control" rows="4" name="resolution_summary" id="resolution_summary">{{ old('resolution_summary', isset($closureDetail) ? $closureDetail->resolution_summary : '') }}</textarea>
                    @error('resolution_summary')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">{{ isset($closureDetail) ? 'Update Closure Detail' : 'Add Closure Detail' }}</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('#closureDetailForm').on('submit', function(event) {
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
                            window.location.href = '{{ route('closureDetails.index') }}';
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

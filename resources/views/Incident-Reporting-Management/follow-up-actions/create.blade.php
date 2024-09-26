@extends('layouts.app')

@section('page-title', 'Follow-Up Action Management')


@if (isset($followUpAction))
    @section('sub-page-title', 'Update ')
@else
  @section('sub-page-title', 'Add ')
@endif

@section('content')
<div class="container-fluid">
    <div class="card w-70">
        <div class="card-header">
           <h5> {{ isset($followUpAction) ? 'Update Follow-Up Action' : 'Add Follow-Up Action' }} </h5>
        </div>
        <div class="card-body">
            <form id="followUpActionForm" action="{{ isset($followUpAction) ? route('followUpActions.update', ['followUpAction' => $followUpAction->id]) : route('followUpActions.store') }}" method="POST">
                @csrf
                @if(isset($followUpAction))
                    @method('PUT')
                @endif

                <div class="form-group col-md-6">
                    <label for="incident_view_id">Incident View<span class="text-danger">*</span></label>
                    <select name="incident_view_id" id="incident_view_id" class="form-control" required>
                        <option value="">Select Incident View</option>
                        @foreach($incidentViews as $incidentView)
                            <option value="{{ $incidentView->id }}" {{ old('incident_view_id', $followUpAction->incident_view_id ?? '') == $incidentView->id ? 'selected' : '' }}>
                                {{ $incidentView->id}}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="follow_up_date">Follow-up Date</label>
                    <input type="date" class="form-control" name="follow_up_date" id="follow_up_date" value="{{ old('follow_up_date', $followUpAction->follow_up_date ?? '') }}">
                </div>

                <div class="form-group col-md-6">
                    <label for="assigned_user">Assigned User<span class="text-danger">*</span></label>
                    <select name="assigned_user" id="assigned_user" class="form-control" required>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('assigned_user', $followUpAction->assigned_user ?? '') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="notes">Notes (Optional)</label>
                    <textarea class="form-control" rows="4" name="notes" id="notes">{{ old('notes', $followUpAction->notes ?? '') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">{{ isset($followUpAction) ? 'Update Follow-Up Action' : 'Add Follow-Up Action' }}</button>
            </form>
        </div>
    </div>
</div>

{{-- Include SweetAlert and jQuery --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('#followUpActionForm').on('submit', function(event) {
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
                            window.location.href = '{{ route('followUpActions.index') }}';
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

@extends('layouts.app')

@section('page-title', 'PPE Assignment Records')

@if (isset($assignment))
    @section('sub-page-title', 'Update  PPE Equipment')
@else
  @section('sub-page-title', 'Assign PPE Equipment')
@endif

@section('content')

<div class="container-fluid">
    <div class="card w-70">
        <div class="card-header">
            <h5 > {{ isset($assignment) ? 'Update PPE Assignment' : 'Assign PPE Equipment' }} </h5>
        </div>
        <div class="card-body">
            <form id="assignmentForm" action="{{ isset($assignment) ? route('assignment-records.update', ['assignment_record' => $assignment->id]) : route('assignment-records.store') }}" method="POST">
                @csrf
                @if(isset($assignment))
                    @method('PUT')
                @endif

                <div class="form-group col-md-6">
                    <label for="ppe_equipment_id">PPE Equipment<span class="text-danger">*</span></label>
                    <select class="form-control" name="ppe_equipment_id" id="ppe_equipment_id" required>
                        @foreach($ppeEquipments as $ppeEquipment)
                            <option value="{{ $ppeEquipment->id }}" {{ (isset($assignment) && $assignment->ppe_equipment_id == $ppeEquipment->id) ? 'selected' : '' }}>
                                {{ $ppeEquipment->equipment_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group col-md-6">
                    <label for="assigned_to">Assigned To (User ID)<span class="text-danger">*</span></label>
                    <select class="form-control" name="assigned_to" id="assigned_to" required>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ (isset($assignment) && $assignment->assigned_to == $user->id) ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="date_of_assignment">Date of Assignment<span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="date_of_assignment" id="date_of_assignment" value="{{ old('date_of_assignment', $assignment->date_of_assignment ?? '') }}" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="ppe_condition">PPE Condition<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="ppe_condition" id="ppe_condition" value="{{ old('ppe_condition', $assignment->ppe_condition ?? '') }}" placeholder="PPE Condition" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="maintenance_due_date">Maintenance Due Date</label>
                    <input type="date" class="form-control" name="maintenance_due_date" id="maintenance_due_date" value="{{ old('maintenance_due_date', $assignment->maintenance_due_date ?? '') }}">
                </div>

                <button type="submit" class="btn btn-primary">{{ isset($assignment) ? 'Update Assignment' : 'Assign PPE Equipment' }}</button>
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
                    Swal.fire(
                        'Success!',
                        response.message,
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '{{ route('assignment-records.index') }}';
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

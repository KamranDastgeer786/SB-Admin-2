@extends('layouts.app')

@section('page-title', 'User PPE Equipment Assignment')

@if (isset($user_assignment))
    @section('sub-page-title', 'Update')
@else
  @section('sub-page-title', 'Add ')
@endif

@section('content')

{{-- @dd($assignment) --}}

<div class="container-fluid">
    <div class="card w-70">
        <div class="card-header">
           <h5> {{ isset($user_assignment) ? 'Update User PPE Equipment Assignment' : 'Add User PPE Equipment Assignment' }} </h5>
        </div>
        <div class="card-body">
            <form id="assignmentForm" action="{{ isset($user_assignment) ? route('user_assignments.update', ['user_assignment' => $user_assignment->id]) : route('user_assignments.store') }}" method="POST">
                @csrf
                @if(isset($user_assignment))
                    @method('PUT')
                @endif

                <div class="form-group col-md-6">
                    <label for="user_id">User<span class="text-danger">*</span></label>
                    <select class="form-control " name="user_id" id="user_id" required>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ (isset($user_assignment) && $user_assignment->user_id == $user->id) ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group col-md-6">
                    <label for="ppe_assigned">PPE Equipment<span class="text-danger">*</span></label>
                    <select class="form-control" name="pp_assigned" id="ppe_assigned" required>

                        @foreach($ppeEquipments as $ppeEquipment)
                            <option value="{{ $ppeEquipment->id }}" {{ (isset($user_assignment) && $user_assignment->ppe_assigned == $ppeEquipment->id) ? 'selected' : '' }}>
                                {{ $ppeEquipment->equipment_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="assignment_date">Assignment Date<span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="assignment_date" id="assignment_date" value="{{ old('assignment_date', $user_assignment->assignment_date ?? '') }}" required>
                </div>

                <button type="submit" class="btn btn-primary">{{ isset($user_assignment) ? 'Update Assignment' : 'Assign PPE Equipment' }}</button>
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
                            window.location.href = '{{ route('user_assignments.index') }}';
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


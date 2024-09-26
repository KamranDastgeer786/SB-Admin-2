@extends('layouts.app')

@section('page-title', 'Compliance Management')

@if (isset($compliance))
    @section('sub-page-title', 'Update Compliance ')
@else
  @section('sub-page-title', 'Add New Compliance ')
@endif

@section('content')
<div class="container-fluid">
    <div class="card w-70">
        <div class="card-header">
           <h5>{{ isset($compliance) ? 'Update Compliance' : 'Add New Compliance' }}</h5> 
        </div>
        <div class="card-body">
            <form id="complianceForm" action="{{ isset($compliance) ? route('compliances.update', ['compliance' => $compliance->id]) : route('compliances.store') }}" method="POST">
                @csrf
                @if(isset($compliance))
                    @method('PUT')
                @endif

                <div class="form-group col-md-6">
                    <label for="user_id">User<span class="text-danger">*</span></label>
                    <select name="user_id" id="user_id" class="form-control" required>
                        <option value="">Select User</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id', $compliance->user_id ?? '') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="training_completion">Training Completion Date</label>
                    <input type="date" class="form-control" name="training_completion" id="training_completion" value="{{ old('training_completion', $compliance->training_completion ?? '') }}">
                </div>

                <div class="form-group col-md-6">
                    <label for="inspection_logs">Inspection Logs</label>
                    <textarea class="form-control" rows="4" name="inspection_logs" id="inspection_logs" placeholder="Inspection Logs">{{ old('inspection_logs', $compliance->inspection_logs ?? '') }}</textarea>
                </div>

                <div class="form-group col-md-6">
                    <label for="fit_testing">Fit Testing Status<span class="text-danger">*</span></label>
                    <select name="fit_testing" id="fit_testing" class="form-control" required>
                        <option value="1" {{ old('fit_testing', $compliance->fit_testing ?? '') == '1' ? 'selected' : '' }}>Passed</option>
                        <option value="0" {{ old('fit_testing', $compliance->fit_testing ?? '') == '0' ? 'selected' : '' }}>Failed</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">{{ isset($compliance) ? 'Update Compliance' : 'Add Compliance' }}</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('#complianceForm').on('submit', function(event) {
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
                            window.location.href = '{{ route('compliances.index') }}';
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

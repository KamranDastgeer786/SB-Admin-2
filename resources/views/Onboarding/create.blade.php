@extends('layouts.app')

@section('page-title', 'Onboarding Records')

@if (isset($onboardingRecord))
    @section('sub-page-title', 'Update Onboarding Record')
@else
  @section('sub-page-title', 'Add Onboarding Record')
@endif

@section('content')

<div class="container-fluid">
    <div class="card w-70">
        <div class="card-header">
           <h5> {{ isset($onboardingRecord) ? 'Update Onboarding Record' : 'Add Onboarding Record' }} </h5>
        </div>
        <div class="card-body">
            <form id="onboardingForm" action="{{ isset($onboardingRecord) ? route('onboarding-records.update', ['onboarding_record' => $onboardingRecord->id]) : route('onboarding-records.store') }}" method="POST">
                @csrf
                @if(isset($onboardingRecord))
                    @method('PUT')
                @endif

                <div class="form-group col-md-6">
                    <label for="user_id">User<span class="text-danger">*</span></label>
                    <select class="form-control" name="user_id" id="user_id" required>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ (isset($onboardingRecord) && $onboardingRecord->user_id == $user->id) ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="ppe_training_completion_date">PPE Training Completion Date<span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="ppe_training_completion_date" id="ppe_training_completion_date" value="{{ old('ppe_training_completion_date', $onboardingRecord->ppe_training_completion_date ?? '') }}" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="ppe_fit_testing">PPE Fit Testing</label>
                    <input type="checkbox" name="ppe_fit_testing" id="ppe_fit_testing" {{ old('ppe_fit_testing', $onboardingRecord->ppe_fit_testing ?? '') ? 'checked' : '' }}>
                </div>

                <button type="submit" class="btn btn-primary">{{ isset($onboardingRecord) ? 'Update Record' : 'Create Record' }}</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('#onboardingForm').on('submit', function(event) {
            event.preventDefault();

            // Create a FormData object
            var formData = new FormData(this);
            // Handle checkbox separately
            var ppeFitTesting = $('#ppe_fit_testing').is(':checked') ? 1 : 0;
            formData.set('ppe_fit_testing', ppeFitTesting);

            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                dataType: 'json',
                processData: false, // Important for FormData
                contentType: false, // Important for FormData
                data: formData,
                success: function(response) {
                    Swal.fire(
                        'Success!',
                        response.message,
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '{{ route('onboarding-records.index') }}';
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

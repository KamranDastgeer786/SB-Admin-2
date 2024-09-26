@extends('layouts.app')
@section('page-title', 'Driver Profile Management')

@if (isset($driverprofile))
    @section('sub-page-title', 'Update Driver Profile')
@else
  @section('sub-page-title', 'Add Driver Profile')
@endif

@section('content')
{{-- @dd($driverprofile) --}}
<div class="container-fluid">
    <div class="card w-70">
        <div class="card-header">
            <h5 > {{ isset($driverprofile) ? 'Update Driver Profile' : 'Add Driver Profile' }} </h5>
        </div>
        <div class="card-body">
            <form id="driverProfileForm" action="{{ isset($driverprofile) ? route('driverprofiles.update', ['driverprofile' => $driverprofile->id]) : route('driverprofiles.store') }}" method="POST">
                @csrf
                @if(isset($driverprofile))
                 @method('PUT')
                @endif
                
                <div class="form-group col-md-6">
                    <label for="full_name">Full Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="full_name" id="full_name" value="{{ old('full_name', $driverprofile->full_name ?? '') }}" placeholder="Full Name" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="license_number">License Number<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="license_number" id="license_number" value="{{ old('license_number', $driverprofile->license_number ?? '') }}" placeholder="License Number" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="vehicle_information">Vehicle Information<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="vehicle_information" id="vehicle_information" value="{{ old('vehicle_information', $driverprofile->vehicle_information ?? '') }}" placeholder="Vehicle Information" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="contact_details">Contact Details<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="contact_details" id="contact_details" value="{{ old('contact_details', $driverprofile->contact_details ?? '') }}" placeholder="Contact Details" required>
                </div>

                <button type="submit" class="btn btn-primary">{{ isset($driverprofile) ? 'Update Driver Profile' : 'Add Driver Profile' }}</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('#driverProfileForm').on('submit', function(event) {
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
                            window.location.href = '{{ route('driverprofiles.index') }}';
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

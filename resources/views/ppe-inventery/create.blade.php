@extends('layouts.app')
@section('page-title', 'PPE Inventory Management')

@if (isset($ppe))
    @section('sub-page-title', 'Update')
@else
  @section('sub-page-title', 'Add ')
@endif

@section('content')

<div class="container-fluid">
    <div class="card w-70">
        <div class="card-header">
           <h5>{{ isset($ppe) ? 'Edit PPE Equipment' : 'Add New PPE Equipment' }} </h5>  
        </div>
        <div class="card-body">
            <form id="ppeForm" action="{{ isset($ppe) ? route('ppe.update', ['ppe' => $ppe->id]) : route('ppe.store') }}" method="POST">
                @csrf
                @if(isset($ppe))
                    @method('PUT')
                @endif
                
                <div class="form-group col-md-6">
                    <label for="equipment_name">Equipment Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="equipment_name" id="equipment_name" value="{{ old('equipment_name', $ppe->equipment_name ?? '') }}" placeholder="Equipment Name" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="equipment_type">Equipment Type<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="equipment_type" id="equipment_type" value="{{ old('equipment_type', $ppe->equipment_type ?? '') }}" placeholder="Equipment Type" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="serial_number">Serial Number<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="serial_number" id="serial_number" value="{{ old('serial_number', $ppe->serial_number ?? '') }}" placeholder="Serial Number" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="date_of_purchase">Date of Purchase<span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="date_of_purchase" id="date_of_purchase" value="{{ old('date_of_purchase', $ppe->date_of_purchase ?? '') }}" required>
                </div>

                <button type="submit" class="btn btn-primary">{{ isset($ppe) ? 'Update PPE Equipment' : 'Add PPE Equipment' }}</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Ensure CSRF token is set
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#ppeForm').on('submit', function(event) {
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
                            window.location.href = '{{ route('ppe.index') }}';
                        }
                    });
                },
                error: function(xhr) {
                    console.log(xhr.responseText); // Log response for debugging
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

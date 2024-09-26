@extends('layouts.app')

@section('page-title', 'Inventory Management')

@if (isset($inventory))
    @section('sub-page-title', 'Update Inventory ')
@else
  @section('sub-page-title', 'Add New Inventory')
@endif

@section('content')
<div class="container-fluid">
    <div class="card w-70">
        <div class="card-header">
           <h5>{{ isset($inventory) ? 'Update Inventory' : 'Add New Inventory' }} </h5> 
        </div>
        <div class="card-body">
            <form id="inventoryForm" action="{{ isset($inventory) ? route('inventories.update', ['inventory' => $inventory->id]) : route('inventories.store') }}" method="POST">
                @csrf
                @if(isset($inventory))
                    @method('PUT')
                @endif

                <div class="form-group col-md-6">
                    <label for="total_equipment">Total Equipment<span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="total_equipment" id="total_equipment" value="{{ old('total_equipment', $inventory->total_equipment ?? '') }}" placeholder="Total Equipment" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="available_stock">Available Stock<span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="available_stock" id="available_stock" value="{{ old('available_stock', $inventory->available_stock ?? '') }}" placeholder="Available Stock" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="maintenance_schedule">Maintenance Schedule<span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="maintenance_schedule" id="maintenance_schedule" value="{{ old('maintenance_schedule', $inventory->maintenance_schedule ?? '') }}" placeholder="Maintenance Schedule" required>
                </div>

                <button type="submit" class="btn btn-primary">{{ isset($inventory) ? 'Update Inventory' : 'Add Inventory' }}</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('#inventoryForm').on('submit', function(event) {
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
                            window.location.href = '{{ route('inventories.index') }}';
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

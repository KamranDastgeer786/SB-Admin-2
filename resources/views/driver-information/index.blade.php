@extends('layouts.app')
@section('page-title', 'Driver Information')
@section('content')

@push('styles')
    <!-- Custom styles for this page -->
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.min.css" rel="stylesheet">
@endpush

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary breadcrumb float-sm-right" style="background-color: ghostwhite;">Show All Driver Information</h6>
            <a href="{{ route('drivers.create') }}" class="btn btn-primary"> ✙ Add Drivers </a>
        </div>
        <div class="card-body">
            <div class="table-responsive" id="contactList">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" >
                    <thead>
                        <tr>
                            {{-- Personal Information --}}
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Date of Birth</th>
                            <th>Contact Number</th>
                            <th>Email Address</th>

                            {{-- License Information --}}
                            <th>License Number</th>
                            <th>License Issuing State</th>
                            <th>License Expiry Date</th>

                            {{-- Vehicle Information --}}
                            <th>Vehicle Make & Model</th>
                            <th>Vehicle Registration Number</th>
                            <th>Insurance Details</th>

                            {{-- Emergency Contact --}}
                            <th>Emergency Contact Name</th>
                            <th>Emergency Contact Number</th>
                            <th>Relationship with Driver</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                
                    <tbody id="categoryTableBody">
                        @forelse ($drivers as $driver)
                            <tr>

                              {{-- Personal Information --}}
                                <td>
                                    <a href="" class="btn-link">{{ $driver->id }}</a>
                                </td>

                                <td>
                                    <a href="" class="btn-link">{{ $driver->name }}</a>
                                </td>

                                <td>
                                    {{ $driver->date_of_birth  }}
                                </td>

                                <td>
                                    {{ $driver->contact_number  }}
                                </td>

                                <td>
                                    {{ $driver->email  }}
                                </td>

                               {{-- License Information --}}
                                <td>
                                   {{$driver->license_number}}
                                </td>
                                
                                <td>
                                    {{$driver->license_issuing_state}}
                                </td> 

                                <td>
                                    {{$driver->license_expiry_date}}
                                </td> 
                            
                              {{-- Vehicle Information --}}
                                <td>
                                    {{$driver->vehicle_make_model}}
                                </td> 

                                <td>
                                   {{$driver->vehicle_registration_number}}
                                </td> 

                                <td>
                                    {{$driver->insurance_details}}
                                </td>

                                {{-- Emergency Contact --}}
                                <td>
                                    {{$driver->emergency_contact_name}}
                                </td>

                                <td>
                                    {{$driver->emergency_contact_number}}
                                </td>

                                <td>
                                    {{$driver->emergency_contact_relationship}}
                                </td>

                                <td>
                                    <a href="{{ route('drivers.edit', $driver->id) }}" class="btn btn-primary btn-sm" style="width: 74px; margin-left: 40px;">
                                        <i class="fa fa-code"></i>
                                        Edit
                                    </a>
                                </td>

                            <td>


                                <a onclick="deleteDriver('{{ route('drivers.destroy', $driver->id) }}')" class="btn btn-danger btn-sm" style="width: 77px; margin-left: 40px;"> 
                                    <i class="fas fa-trash"></i>
                                    Delete
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9">No User Found.</td>
                        </tr>    
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.all.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function deleteDriver(url) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover deleted items!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire(
                            'Deleted!',
                            response.message,
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire(
                            'Error!',
                            xhr.responseJSON.message,
                            'error'
                        );
                    }
                });
            }
        });
    }

    $('.status-toggle').change(function() {
    var driverId = $(this).data('driver-id');
    var newActiveStatus = $(this).prop('checked') ? 1 : 0;

    $.ajax({
        url: '{{ route('drivers.update-active-status') }}',
        method: 'POST',
        data: {
            id: driverId,
            activeStatus: newActiveStatus
        },
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function(response) {
            Swal.fire(
                'Updated!',
                response.message,
                'success'
            );
        },
        error: function(xhr, status, error) {
            Swal.fire(
                'Error!',
                'Failed To Update Active Status.',
                'error'
            ).then(() => {
                location.reload();
            });
        }
    });
});
</script>

@push('scripts')
   <!-- Page level plugins -->
   <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
   <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

   <!-- Page level custom scripts -->
   <script src="{{ asset('js/demo/datatables-demo.js')}}"></script>
@endpush
@endsection



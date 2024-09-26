@extends('layouts.app')
@section('page-title', 'User Assignment Management')

@section('content')

@push('styles')
    <!-- Custom styles for this page -->
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.min.css" rel="stylesheet">
@endpush

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary breadcrumb float-sm-right" style="background-color: ghostwhite;">Show All User Assignments</h6>
            <a href="{{ route('user_assignments.create') }}" class="btn btn-primary"> ✙ Add New Assignment</a>
        </div>
        <div class="card-body">
            <div class="table-responsive" id="assignmentList">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>PPE Assigned</th>
                            <th>Assignment Date</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody id="assignmentTableBody">
                        @forelse($user_assignments as $assignment)
                            <tr>
                                {{-- @dd($assignment) --}}
                                <td>{{ $assignment->id }}</td>
                                <td>{{ $assignment->user->name }}</td>
                                <td>{{ $assignment->ppeEquipment->equipment_name }}</td>
                                <td>{{ \Carbon\Carbon::parse($assignment->assignment_date)->format('Y-m-d') }}</td>
                                <td>
                                    
                                    <a href="{{ route('user_assignments.edit', ['user_assignment' => $assignment->id]) }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                </td>
                                <td>
                                    <a onclick="deleteAssignment('{{ route('user_assignments.destroy', ['user_assignment' => $assignment->id]) }}')" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        @empty
                        <tr>
                            <td colspan="6">No User Assignments Found.</td>
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
    function deleteAssignment(url) {
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

    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>

@push('scripts')
   <!-- Page level plugins -->
   <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
   <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

   <!-- Page level custom scripts -->
   <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
@endpush

@endsection

@extends('layouts.app')

@section('page-title', 'Follow-Up Action Management')

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
            <h6 class="m-0 font-weight-bold text-primary breadcrumb float-sm-right" style="background-color: ghostwhite;">
                Show All Follow-Up Actions
            </h6>
            <a href="{{ route('followUpActions.create') }}" class="btn btn-primary"> ✙ Add Follow-Up Action</a>
        </div>
        <div class="card-body">
            <div class="table-responsive" id="followUpActionList">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Incident view id</th>
                            <th>Follow-Up Date</th>
                            <th>Assigned User</th>
                            <th>Notes</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody id="followUpActionTableBody">
                        @forelse ($followUpActions as $followUpAction)
                            <tr>
                                <td>{{ $followUpAction->id }}</td>
                                <td>{{ $followUpAction->incidentView->id }}</td>
                                <td>{{ $followUpAction->follow_up_date }}</td>
                                <td>{{ $followUpAction->assignedUser->name }}</td>
                                <td>{{ $followUpAction->notes }}</td>
                                <td>
                                    <a href="{{ route('followUpActions.edit', ['followUpAction' => $followUpAction->id]) }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                </td>
                                <td>
                                    <a onclick="deleteFollowUpAction('{{ route('followUpActions.destroy', ['followUpAction' => $followUpAction->id]) }}')" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        @empty
                        <tr>
                            <td colspan="7">No Follow-Up Actions Found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

@push('scripts')
    <!-- Include SweetAlert and jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables Scripts -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();

            window.deleteFollowUpAction = function(url) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You will not be able to recover this follow-up action!',
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
            };
        });
    </script>
@endpush

@endsection

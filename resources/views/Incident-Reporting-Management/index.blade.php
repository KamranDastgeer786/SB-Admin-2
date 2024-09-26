@extends('layouts.app')

@section('page-title', 'Incident View Management')

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
                Show All Incident Views
            </h6>
            <a href="{{ route('incidentViews.create') }}" class="btn btn-primary"> ✙ Add Incident View</a>
        </div>
        <div class="card-body">
            <div class="table-responsive" id="incidentViewList">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date and Time</th>
                            <th>Status</th>
                            <th>Assigned Reviewer</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody id="incidentViewTableBody">
                        @forelse ($incidentViews as $incidentView)
                            <tr>
                                <td>{{ $incidentView->id }}</td>
                                <td>{{ $incidentView->date_time ? \Carbon\Carbon::parse($incidentView->date_time)->format('Y-m-d H:i:s') : 'N/A' }}</td>
                                <td>{{ $incidentView->status }}</td>
                                {{-- <td>{{ $incidentView->assignedReviewer->name }}</td> --}}
                                <td>{{ $incidentView->assigned_reviewer}}</td>
                                <td>
                                    <a href="{{ route('incidentViews.edit', ['incidentView' => $incidentView->id]) }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                </td>
                                <td>
                                    <a onclick="deleteIncidentView('{{ route('incidentViews.destroy', ['incidentView' => $incidentView->id]) }}')" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        @empty
                        <tr>
                            <td colspan="6">No Incident Views Found.</td>
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
    function deleteIncidentView(url) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this incident view!',
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
</script>

@push('scripts')
   <!-- Page level plugins -->
   <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
   <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

   <!-- Page level custom scripts -->
   <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
@endpush
@endsection

@extends('layouts.app')

@section('page-title', 'Incident Report Submissions')

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
            <h6 class="m-0 font-weight-bold text-primary breadcrumb float-sm-right" style="background-color: ghostwhite;">Show All Incident Reports</h6>
            <a href="{{ route('incident_reports.create') }}" class="btn btn-primary"> ✙ Create New Report</a>
        </div>
        <div class="card-body">
            <div class="table-responsive" id="incidentList">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date and Time</th>
                            <th>Location</th>
                            <th>Description</th>
                            <th>Submitted By</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody id="incidentTableBody">
                        @forelse ($incidentReports as $report)
                            <tr>
                                <td>{{ $report->id }}</td>
                                <td>{{ \Carbon\Carbon::parse($report->incident_date_time)->format('Y-m-d H:i') }}</td>
                                <td>{{ $report->location }}</td>
                                <td>{{ Str::limit($report->description, 50) }}</td>
                                <td>{{ $report->user->name }}</td>
                                <td>{{ $report->status }}</td>
                                <td>
                                    <a href="{{ route('incident_reports.edit', ['incident_report' => $report->id]) }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-edit"></i>
                                        Edit
                                    </a>
                                </td>
                                <td>
                                    <a onclick="deleteIncident('{{ route('incident_reports.destroy', ['incident_report' => $report->id]) }}')" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No Incident Reports Found.</td>
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
function submitForm(status) {
    $('#status').val(status);
    $('#incidentReportForm').submit();
}

$(document).ready(function() {
    $('#incidentReportForm').on('submit', function(event) {
        event.preventDefault();
        
        var formData = new FormData($(this)[0]);

        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.fire(
                    'Success!',
                    response.message,
                    'success'
                ).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '{{ route('incident_reports.index') }}';
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

    function deleteIncident(url) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover deleted reports!',
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
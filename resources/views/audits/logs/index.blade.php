@extends('layouts.app')

@section('page-title', 'Audit Logs Management')

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
            <h6 class="m-0 font-weight-bold text-primary " style="background-color: ghostwhite;">
                Show All Logs
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive" id="logList">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Action Performed</th>
                            <th>User ID</th>
                            <th>IP Address</th>
                            <th>Timestamp</th>
                            {{-- <th>Edit</th>
                            <th>Delete</th> --}}
                        </tr>
                    </thead>
                    <tbody id="logTableBody">
                        @forelse ($logs as $log)
                            <tr>
                                <td>{{ $log->id }}</td>
                                <td>{{ $log->action_performed }}</td>
                                <td>{{ $log->user_id }}</td>
                                <td>{{ $log->ip_address }}</td>
                                <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                        @empty
                        <tr>
                            <td colspan="7">No Logs Found.</td>
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
   <!-- Page level plugins -->
   <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
   <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

   <!-- Page level custom scripts -->
   <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
@endpush
@endsection

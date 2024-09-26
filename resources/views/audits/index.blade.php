@extends('layouts.app')
@section('page-title', 'Audit Logs')
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
            <h6 class="m-0 font-weight-bold text-primary " style="background-color: ghostwhite;">Show All Audit </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive" id="auditList">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Action Type</th>
                            <th>Resource Affected</th>
                            <th>User Role</th>
                            <th>User ID</th>
                            <th>Date/Time</th>
                            {{-- <th>New Status</th>
                            <th>Previous Status</th> --}}
                        </tr>
                    </thead>
                
                    <tbody id="auditTableBody">
                        @forelse ($audits as $audit)
                            <tr>
                                <td>{{ $audit->id }}</td>
                                <td>{{ $audit->action_type }}</td>
                                <td>{{ $audit->resource_affected }}</td>
                                <td>{{ $audit->user_role }}</td>
                                <td>{{ $audit->user_id }}</td>
                                <td>{{ $audit->created_at->format('Y-m-d H:i:s') }}</td>
                                {{-- <td>{{ $audit->new_state }}</td>
                                <td>{{ $audit->previous_state}}</td> --}}
                                
                                
                                
                            </tr> 
                        @empty
                            <tr>
                                <td colspan="8">No audit logs found.</td>
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
   <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
   <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

   <!-- Page level custom scripts -->
   <script src="{{ asset('js/demo/datatables-demo.js')}}"></script>
@endpush
@endsection

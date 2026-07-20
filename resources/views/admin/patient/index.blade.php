@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <h4 class="page-title">Patients</h4>
        <div class="row">
            <div class="col-md-4">
                <a href="{{ route('admin.patients.create') }}" class="btn btn-primary mb-3">
                    <i class="fa fa-plus"></i> Add Patient
                </a>
            </div>
            <div class="col-md-8 mb-3">
                <div class="btn-group float-right" role="group">
                    <a href="{{ route('admin.patients.index') }}" class="btn btn-outline-secondary {{ !request()->has('type') ? 'active' : '' }}">
                        All
                    </a>
                    <a href="{{ route('admin.patients.index', ['type' => 'OPD']) }}" class="btn btn-outline-primary {{ request('type') == 'OPD' ? 'active' : '' }}">
                        OPD
                    </a>
                    <a href="{{ route('admin.patients.index', ['type' => 'IPD']) }}" class="btn btn-outline-info {{ request('type') == 'IPD' ? 'active' : '' }}">
                        IPD
                    </a>
                    <a href="{{ route('admin.patients.index', ['type' => 'ICU']) }}" class="btn btn-outline-danger {{ request('type') == 'ICU' ? 'active' : '' }}">
                        ICU
                    </a>
                </div>
                <input type="text"
                    id="search"
                    class="form-control float-right mr-2"
                    placeholder="Search Patient..."
                    value="{{ request('search') }}"
                    style="width:200px;">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <div class="card-block">
                        <div id="table-data">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Patient ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Gender</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($patients as $key => $patient)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $patient->patient_id }}</td>
                                                <td>{{ $patient->full_name }}</td>
                                                <td>{{ $patient->email ?? 'N/A' }}</td>
                                                <td>{{ $patient->phone }}</td>
                                                <td>{{ ucfirst($patient->gender ?? 'N/A') }}</td>
                                                <td>
                                                    @if($patient->patient_type)
                                                        <span class="badge badge-{{ $patient->patient_type == 'OPD' ? 'primary' : ($patient->patient_type == 'IPD' ? 'info' : 'danger') }}">
                                                            {{ $patient->patient_type }}
                                                        </span>
                                                    @else
                                                        <span class="badge badge-secondary">N/A</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($patient->is_active)
                                                        <span class="badge badge-success">Active</span>
                                                    @else
                                                        <span class="badge badge-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.patients.edit', $patient) }}" class="btn btn-sm btn-primary">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete_patient_{{ $patient->id }}">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>

                                            <!-- Delete Modal -->
                                            <div id="delete_patient_{{ $patient->id }}" class="modal fade delete-modal" role="dialog">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body text-center">
                                                            <img src="{{ asset('admin/assets/img/sent.png') }}" alt="" width="50" height="46">
                                                            <h3>Are you sure want to delete this Patient?</h3>
                                                            <div class="m-t-20">
                                                                <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                                                                <form action="{{ route('admin.patients.destroy', $patient) }}" method="POST" style="display:inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center">No patients found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="mt-3">
                                    {{ $patients->appends(request()->query())->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let timer;

    $('#search').keyup(function(){
        clearTimeout(timer);
        timer=setTimeout(function(){
            $.get(
                "{{ route('admin.patients.index') }}",
                {
                    search:$('#search').val()
                },
                function(response){
                    $('#table-data').html(
                        $(response).find('#table-data').html()
                    );
                }
            );
        },400);
    });

    $(document).on('click','.pagination a',function(e){
        e.preventDefault();
        $.get(
            $(this).attr('href'),
            {
                search:$('#search').val()
            },
            function(response){
                $('#table-data').html(
                    $(response).find('#table-data').html()
                );
            }
        );
    });
</script>
@endpush
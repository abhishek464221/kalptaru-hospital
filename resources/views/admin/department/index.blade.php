@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <h4 class="page-title">Departments</h4>
        <div class="row">
            <div class="col-md-8">
                <a href="{{ route('admin.departments.create') }}" class="btn btn-primary mb-3">
                    <i class="fa fa-plus"></i> Add Department
                </a>
            </div>
            <div class="col-md-4 mb-3">
                <input type="text"
                    id="search"
                    class="form-control"
                    placeholder="Search..."
                    value="{{ request('search') }}">
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
                                            <th>Name</th>
                                            <th>Code</th>
                                            <th>Head of Department</th>
                                            <th>Description</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($departments as $key => $department)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $department->name }}</td>
                                                <td>{{ $department->code }}</td>
                                                <td>{{ $department->head_of_department ?? 'N/A' }}</td>
                                                <td>{{ Str::limit($department->description, 30) }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.departments.edit', $department) }}" class="btn btn-sm btn-primary">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete_department" data-department-id="{{ $department->id }}">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No departments found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="mt-3">
                                    {{ $departments->appends(request()->query())->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div id="delete_department" class="modal fade delete-modal" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img src="{{ asset('admin/assets/img/sent.png') }}" alt="" width="50" height="46">
                <h3>Are you sure want to delete this Department?</h3>
                <div class="m-t-20">
                    <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                    <form id="delete-department-form" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
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
                "{{ route('admin.departments.index') }}",
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

    $('#delete_department').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var departmentId = button.data('department-id');
        var action = "{{ route('admin.departments.destroy', ':id') }}";
        action = action.replace(':id', departmentId);
        $('#delete-department-form').attr('action', action);
    });

</script>
@endpush
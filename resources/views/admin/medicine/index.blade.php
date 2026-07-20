@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <h4 class="page-title">Medicines</h4>
        <div class="row">
            <div class="col-md-8">
                <a href="{{ route('admin.medicines.create') }}" class="btn btn-primary mb-3">
                    <i class="fa fa-plus"></i> Add Medicine
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
                                            <th>Category</th>
                                            <th>Supplier</th>
                                            <th>Batch</th>
                                            <th>Purchase Price</th>
                                            <th>Selling Price</th>
                                            <th>Stock</th>
                                            <th>Expiry</th>
                                            <th>Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($medicines as $key => $medicine)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $medicine->name }}</td>
                                                <td>{{ $medicine->category ?? 'N/A' }}</td>
                                                <td>{{ $medicine->supplier ?? 'N/A' }}</td>
                                                <td>{{ $medicine->batch_number ?? 'N/A' }}</td>
                                                <td>₹{{ number_format($medicine->purchase_price, 2) }}</td>
                                                <td>₹{{ number_format($medicine->selling_price, 2) }}</td>
                                                <td>
                                                    <span class="badge {{ $medicine->stock_quantity <= 0 ? 'badge-danger' : ($medicine->isLowStock() ? 'badge-warning' : 'badge-success') }}">
                                                        {{ $medicine->stock_quantity }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($medicine->expiry_date)
                                                        <span class="badge {{ $medicine->isExpired() ? 'badge-danger' : 'badge-info' }}">
                                                            {{ $medicine->expiry_date->format('d M Y') }}
                                                        </span>
                                                    @else
                                                        <span class="badge badge-secondary">N/A</span>
                                                    @endif
                                                </td>
                                                <td>{!! $medicine->status_label !!}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.medicines.edit', $medicine) }}" class="btn btn-sm btn-primary">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete_medicine_{{ $medicine->id }}">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>

                                            <!-- Delete Modal per row -->
                                            <div id="delete_medicine_{{ $medicine->id }}" class="modal fade delete-modal" role="dialog">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body text-center">
                                                            <img src="{{ asset('admin/assets/img/sent.png') }}" alt="" width="50" height="46">
                                                            <h3>Are you sure want to delete this Medicine?</h3>
                                                            <div class="m-t-20">
                                                                <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                                                                <form action="{{ route('admin.medicines.destroy', $medicine) }}" method="POST" style="display:inline;">
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
                                                <td colspan="11" class="text-center">No medicines found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="mt-3">
                                    {{ $medicines->appends(request()->query())->links() }}
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
                "{{ route('admin.medicines.index') }}",
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
@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <h4 class="page-title">Payments</h4>
        <div class="row">
            <div class="col-md-8">
                <a href="{{ route('admin.payments.create') }}" class="btn btn-primary mb-3">
                    <i class="fa fa-plus"></i> Add Payment
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
                                            <th>Invoice</th>
                                            <th>Patient</th>
                                            <th>Amount</th>
                                            <th>Net Amount</th>
                                            <th>Date</th>
                                            <th>Method</th>
                                            <th>Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($payments as $key => $payment)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td><strong>{{ $payment->invoice_number }}</strong></td>
                                                <td>{{ $payment->patient_name }}</td>
                                                <td>₹{{ number_format($payment->amount, 2) }}</td>
                                                <td>₹{{ number_format($payment->net_amount, 2) }}</td>
                                                <td>{{ $payment->payment_date->format('d M Y') }}</td>
                                                <td>{{ ucfirst($payment->payment_method) }}</td>
                                                <td>
                                                    @php
                                                        $statusColors = [
                                                            'paid' => 'badge-success',
                                                            'pending' => 'badge-warning',
                                                            'partial' => 'badge-info',
                                                            'refunded' => 'badge-danger',
                                                        ];
                                                    @endphp
                                                    <span class="badge {{ $statusColors[$payment->status] ?? 'badge-secondary' }}">
                                                        {{ ucfirst($payment->status) }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.payments.edit', $payment) }}" class="btn btn-sm btn-primary">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete_payment_{{ $payment->id }}">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>

                                            <!-- Delete Modal per row -->
                                            <div id="delete_payment_{{ $payment->id }}" class="modal fade delete-modal" role="dialog">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body text-center">
                                                            <img src="{{ asset('admin/assets/img/sent.png') }}" alt="" width="50" height="46">
                                                            <h3>Are you sure want to delete this Payment?</h3>
                                                            <div class="m-t-20">
                                                                <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                                                                <form action="{{ route('admin.payments.destroy', $payment) }}" method="POST" style="display:inline;">
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
                                                <td colspan="9" class="text-center">No payments found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="mt-3">
                                    {{ $payments->appends(request()->query())->links() }}
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
                "{{ route('admin.payments.index') }}",
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
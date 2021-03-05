@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('cruds.order.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Order">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>{{ trans('cruds.order.fields.id') }}</th>
                        <th>{{ trans('cruds.order.fields.customer_name') }} <br> {{ trans('cruds.order.fields.mobile_number') }}</th>
                        <th>{{ trans('cruds.order.fields.delivery_boy_name') }} <br> {{ trans('cruds.order.fields.mobile_number') }}</th>
                        <th>{{ trans('cruds.order.fields.net_amount') }}</th>
                        <th>{{ trans('cruds.order.fields.gross_amount') }}</th>
                        <th>{{ trans('cruds.order.fields.payment_type') }}</th>
                        <th>{{ trans('cruds.order.fields.status') }}</th>
                        <th>{{ trans('cruds.order.fields.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customerOrders as $key => $customerOrder)
                        <tr data-entry-id="{{ $customerOrder->id }}">
                            <td></td>
                            <td>{{ $customerOrder->id ?? '' }}</td>
                            <td><b>{{ $customerOrder->userCustomer->first_name }}</b><br>{{ $customerOrder->userCustomer->mobile_number }}</td>
                            <td><b>{{ $customerOrder->userDeliveryBoy->first_name ?? '-' }}</b>{{ $customerOrder->userDeliveryBoy->mobile_number ?? '' }}</td>
                            <td>{{ round($customerOrder->net_amount, 2) ?? '' }}</td>
                            <td>{{ round($customerOrder->gross_amount, 2) ?? '' }}</td>
                            <td>{{ $customerOrder->payment_type ?? '' }}</td>
                            <td>
                                @if($customerOrder->order_status == 1)
                                    {{ trans('cruds.order.fields.pending') }}
                                @elseif($customerOrder->order_status == 2)
                                    {{ trans('cruds.order.fields.ordered') }}
                                @elseif($customerOrder->order_status == 3)
                                    {{ trans('cruds.order.fields.in_process') }}
                                @elseif($customerOrder->order_status == 4)
                                    {{ trans('cruds.order.fields.delivered') }}
                                @elseif($customerOrder->order_status == 5)
                                    {{ trans('cruds.order.fields.cancelled') }}
                                @endif
                            </td>
                            <td>
                                @can('order_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.orders.show', $customerOrder->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan
                                @can('order_cancel')
                                    @if($customerOrder->order_status == 1 || $customerOrder->order_status == 2)
                                        <!-- a class="btn btn-xs btn-primary" id="cancel_order" href="#" data-id="{{ $customerOrder->id }}">
                                            {{ trans('cruds.order.fields.cancel_order') }}
                                        </a -->
                                    @endif
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
$(function () {
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

    $.extend(true, $.fn.dataTable.defaults, {
        orderCellsTop: true,
        order: [[ 1, 'desc' ]],
        pageLength: 10,
    });
    let table = $('.datatable-Order:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
  
    $('#cancel_order').on('click', function () {
        var orderId = $(this).attr("data-id");
        var url = '{{ route("admin.orders.cancelOrder", "") }}';
        $(this).text('Cancelling...');
        url = url+'/'+orderId;
        if (orderId) {
            $.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $(this).text('Cancel Order');
                    if(data.status == "Success") {
                        alert('Order cancelled successfully.');
                        location.reload();
                    } else {
                        alert('Order not cancelled.');
                    }
                }
            });
        }
    });
})

</script>
@endsection
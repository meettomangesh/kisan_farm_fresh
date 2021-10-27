@extends('layouts.admin')
@section('content')
<style>
    .dataTables_scrollHeadInner {
        width: auto !important;
    }
</style>
<div class="card">
    <div class="card-header">
        {{ trans('cruds.report.fields.sales_for_supplier') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-sales-for-supplier" id="datatable-sales-for-supplier">
                <thead>
                    <tr>
                        <!-- <th></th> -->
                        <th></th>
                        <th>{{ trans('cruds.sales_for_supplier.fields.product_name') }}</th>
                        <th>{{ trans('cruds.sales_for_supplier.fields.item_qty') }}</th>
                        <th>{{ trans('cruds.sales_for_supplier.fields.cat_name') }}</th>
                        <th>{{ trans('cruds.sales_for_supplier.fields.prod_units') }}</th>
                        <th>{{ trans('cruds.sales_for_supplier.fields.prod_units_qty') }}</th>
                        <th>{{ trans('cruds.sales_for_supplier.fields.final') }}</th>
                        <th>{{ trans('cruds.sales_for_supplier.fields.order_date') }}</th>
                        <th>Action</th>
                    </tr>
                    <tr role="row" class="filter">
                        <th></th>
                        <th><input class="search" name="product_name" type="text" placeholder="Search" /></th>
                        <th><input class="search" name="total_unit" type="text" placeholder="Search" /></th>
                        <th><input class="search" name="cat_name" type="text" placeholder="Search" /></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>
                            <input class="search form-control" type="date" name="order_date" id="order_date" max="{{ date('Y-m-d') }}" />
                        </th>
                        <th> <button class="btn btn-sm yellow filter-submit margin-bottom-5" title="{!! trans('admin::messages.search') !!}"><i class="fa fa-search"></i></button>
                            <button class="btn btn-sm red filter-cancel margin-bottom-5" title="{!! trans('admin::messages.reset') !!}"><i class="fa fa-times"></i></button>
                        </th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

@section('scripts')
@parent
<script>
    $(function() {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        $.extend(true, $.fn.dataTable.defaults, {
            orderCellsTop: true,
            order: [
                [1, 'desc']
            ],
            pageLength: 10,
        });
        // $('.datatable-sales-for-supplier thead tr:eq(1) th').each(function(i) {
        //     $('input', this).on('keyup change', function() {
        //         if (table.column(i).search() !== this.value) {
        //             table.column(i).search(this.value).draw();
        //         }
        //     });
        // });
        let table = $('.datatable-sales-for-supplier').DataTable({
            processing: true,
            serverSide: true,
            // buttons: dtButtons,
            columns: [
                {data: null, name: 'rownum', searchable: false},
                {data: 'product_name', name: 'product_name'},
                {data: 'total_unit', name: 'total_unit'},
                {data: 'cat_name', name: 'cat_name'},
                {data: 'prod_units', name: 'prod_units'},
                {data: 'product_units_qty', name: 'product_units_qty'},
                {data: 'final', name: 'final'},
                {data: 'order_date', name: 'order_date'},
                {data: null, name: 'action', sortable: false}
            ],
            drawCallback: function(settings) {
                var api = this.api();
                var rows = api.rows({
                    page: 'current'
                }).nodes();
                var last = null;
                var page = api.page();
                var recNum = null;
                var displayLength = settings._iDisplayLength;
                api.column(0, {page: 'current'}).data().each(function(group, i) {
                    // recNum = ((page * displayLength) + i + 1);
                    $(rows).eq(i).children('td:first-child').html(recNum);
                });
                api.column(6, {page: 'current'}).data().each(function(data, i) {
                    var units = $(rows).eq(i).children('td:nth-child(5)').html();
                    var qty = $(rows).eq(i).children('td:nth-child(6)').html();
                    var unitsSplit = units.split(",");
                    var qtySplit = qty.split(",");
                    var finalOP = 0;
                    console.log($(rows).eq(i).children('td:nth-child(2)').html() + " unitsSplit: ", unitsSplit);
                    console.log("unitsSplit.length: ", unitsSplit.length);
                    console.log($(rows).eq(i).children('td:nth-child(2)').html() + " qtySplit: ", qtySplit);
                    if(unitsSplit.length > 0) {
                        for(var j = 0; j < unitsSplit.length; j++) {
                            console.log(j + " unit: " + unitsSplit[j]);
                            console.log(j + " qty: " + qtySplit[j]);
                            if(unitsSplit[j] == "250gm") {
                                finalOP = finalOP + ((250/1000) * qtySplit[j]);
                            } else if(unitsSplit[j] == "400gm") {
                                finalOP = finalOP + ((400/1000) * qtySplit[j]);
                            } else if(unitsSplit[j] == "500gm") {
                                finalOP = finalOP + ((500/1000) * qtySplit[j]);
                            } else if(unitsSplit[j] == "1kg") {
                                finalOP = finalOP + (1 * qtySplit[j]);
                            } else if(unitsSplit[j] == "250ml") {
                                finalOP = finalOP + ((250/1000) * qtySplit[j]);
                            } else if(unitsSplit[j] == "500ml") {
                                finalOP = finalOP + ((500/1000) * qtySplit[j]);
                            }else if(unitsSplit[j] == "1litr") {
                                finalOP = finalOP + (1 * qtySplit[j]);
                            } else if(unitsSplit[j] == "1Unit") {
                                finalOP = finalOP + (1 * qtySplit[j]);
                            } else if(unitsSplit[j] == "1Dozen") {
                                finalOP = finalOP + (1 * qtySplit[j]);
                            } else if(unitsSplit[j] == "Half Dozen") {
                                finalOP = finalOP + ((6/12) * qtySplit[j]);
                            }
                        }
                    }
                    console.log($(rows).eq(i).children('td:nth-child(2)').html() + " finalOP: ", finalOP);
                    $(rows).eq(i).children('td:nth-child(7)').html(finalOP);
                    // console.log($(rows).eq(i).children('td:nth-child(2)').html() + "Test: ", $(rows).eq(i).children('td:nth-child(5)').html());
                });
                api.column(8, {page: 'current'}).data().each(function(group, i) {
                    // recNum = ((page * displayLength) + i + 1);
                    $(rows).eq(i).children('td:nth-child(9)').html(null);
                });
            },
            ajax: {
                url: "sales-for-supplier/data",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            }
        });
        $('.filter-cancel').on('click', function(e) {
            $('.datatable-sales-for-supplier thead tr:eq(1) th').each(function(i) {
                $('input', this).val('');

                if (table.column(i).search() !== $('input', this).val()) {
                    table.column(i).search($('input', this).val());
                }
            });
            table.draw();
        });
        $('.search').on('keypress', function(e) {
            if (e.which == 13) {
                $('.filter-submit').click();
            }
        });
        $('.filter-submit').on('click', function(e) {
            $('.datatable-sales-for-supplier thead tr:eq(1) th').each(function(i) {
                if ($('input', this).val()) {
                    if (table.column(i).search() !== $('input', this).val()) {
                        table.column(i).search($('input', this).val()).draw();
                    }
                }
            });
        });
    });
</script>
@stop

@endsection
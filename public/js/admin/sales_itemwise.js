siteObjJs.admin.SalesItemwise = function () {
    var handleTable = function () {
        grid = new Datatable();
        // grid = $('.datatable-sales-itemwise').DataTable();
        grid.init({
            src: $('.datatable-sales-itemwise'),
            loadingMessage: 'Loading...',
            dataTable: {
                'language': {
                    'info': '<span class="seperator">|</span><b>Total _TOTAL_ record(s) found</b>',
                    'infoEmpty': '',
                },
                "bStateSave": false,
                "lengthMenu": siteObjJs.admin.commonJs.constants.gridLengthMenu,
                "pageLength": siteObjJs.admin.commonJs.constants.recordsPerPage,
                "columns": [
                    {data: null, name: 'rownum', searchable: false},
                    {data: 'order_id', name: 'order_id'},
                    {data: 'product_name', name: 'product_name'},
                    {data: 'selling_price', name: 'selling_price'},
                    {data: 'special_price', name: 'special_price'},
                    {data: 'item_qty', name: 'item_qty'},
                    {data: 'order_date', name: 'order_date'},
                    {data: 'order_status', name: 'order_status'},
                    {data: null, name: 'action', sortable: false}
                ],
                "drawCallback": function (settings) {
                    var api = this.api();
                    var rows = api.rows({page: 'current'}).nodes();
                    var last = null;
                    var page = api.page();
                    var recNum = null;
                    var displayLength = settings._iDisplayLength;
                    api.column(0, {page: 'current'}).data().each(function (group, i) {
                        recNum = ((page * displayLength) + i + 1);
                        $(rows).eq(i).children('td:first-child').html(recNum);
                    });
                    /*
                    api.column(23, {page: 'current'}).data().each(function (group, i) {
                        var recFormat = parseFloat($(rows).eq(i).children('td:nth-child(23)').html()).toFixed(2);
                        if (recFormat != '' && !isNaN(recFormat))
                            $(rows).eq(i).children('td:nth-child(23)').html(recFormat);
                    });*/
                    /* api.column(24, {page: 'current'}).data().each(function (group, i) {
                        var recFormat = parseFloat($(rows).eq(i).children('td:nth-child(24)').html()).toFixed(2);
                        if (recFormat != '' && !isNaN(recFormat))
                            $(rows).eq(i).children('td:nth-child(24)').html(recFormat);
                    });
                    api.column(25, {page: 'current'}).data().each(function (group, i) {
                        var recFormat = parseFloat($(rows).eq(i).children('td:nth-child(25)').html()).toFixed(2);
                        if (recFormat != '' && !isNaN(recFormat))
                            $(rows).eq(i).children('td:nth-child(25)').html(recFormat);
                    });
                    api.column(26, {page: 'current'}).data().each(function (group, i) {
                        var recFormat = parseFloat($(rows).eq(i).children('td:nth-child(26)').html()).toFixed(2);
                        if (recFormat != '' && !isNaN(recFormat))
                            $(rows).eq(i).children('td:nth-child(26)').html(recFormat);
                    });
                    api.column(27, {page: 'current'}).data().each(function (group, i) {
                        var recFormat = parseFloat($(rows).eq(i).children('td:nth-child(27)').html()).toFixed(2);
                        if (recFormat != '' && !isNaN(recFormat))
                            $(rows).eq(i).children('td:nth-child(27)').html(recFormat);
                    });
                    api.column(28, {page: 'current'}).data().each(function (group, i) {
                        var recFormat = parseFloat($(rows).eq(i).children('td:nth-child(28)').html()).toFixed(2);
                        if (recFormat != '' && !isNaN(recFormat))
                            $(rows).eq(i).children('td:nth-child(28)').html(recFormat);
                    });
                    api.column(29, {page: 'current'}).data().each(function (group, i) {
                        var recFormat = parseFloat($(rows).eq(i).children('td:nth-child(29)').html()).toFixed(2);
                        if (recFormat != '' && !isNaN(recFormat))
                            $(rows).eq(i).children('td:nth-child(29)').html(recFormat);
                    });
                    api.column(30, {page: 'current'}).data().each(function (group, i) {
                        var recFormat = parseFloat($(rows).eq(i).children('td:nth-child(30)').html()).toFixed(2);
                        if (recFormat != '' && !isNaN(recFormat))
                            $(rows).eq(i).children('td:nth-child(30)').html(recFormat);
                    });
                    api.column(31, {page: 'current'}).data().each(function (group, i) {
                        var recFormat = parseFloat($(rows).eq(i).children('td:nth-child(31)').html()).toFixed(2);
                        if (recFormat != '' && !isNaN(recFormat))
                            $(rows).eq(i).children('td:nth-child(31)').html(recFormat);
                    });
                    api.column(32, {page: 'current'}).data().each(function (group, i) {
                        var recFormat = parseFloat($(rows).eq(i).children('td:nth-child(31)').html()).toFixed(2);
                        if (recFormat != '' && !isNaN(recFormat))
                            $(rows).eq(i).children('td:nth-child(32)').html(recFormat);
                    });
                    api.column(33, {page: 'current'}).data().each(function (group, i) {
                        $(rows).eq(i).children('td:last-child').html(' ');
                    }); */
                },
                "ajax": {
                    "url": "reports/sales-itemwise/data",
                    "type": "POST"
                },
                order: [[1, 'desc']]
            }
        });

        $('#data-search').keyup(function () {
            grid.getDataTable().search($(this).val()).draw();
        });

        $(".form-filter-attr").keyup(function (e) {
            var code = e.which; // recommended to use e.which, it's normalized across browsers
            if (code == 13)
                e.preventDefault();
            if (code == 32 || code == 13 || code == 188 || code == 186) {
                $('.filter-submit').click();
            }
        });
        // For drop down filter
        $(".form-filter-select-attr").change(function () {
            $('.filter-submit').click();
        })
    };

    var handleDatetimePicker = function () {
        if (!jQuery().datepicker) {
            return;
        }
        $(".date-of-birth").datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            // isRTL: Metronic.isRTL(),
            changeYear: true,
            yearRange: 'yy-50:yy+1',
            // pickerPosition: (Metronic.isRTL() ? "bottom-right" : "bottom-left")
        });
    };

    return {
        //main function to initiate the module
        init: function () {
            handleDatetimePicker();
            handleTable();
        }
    };
}();
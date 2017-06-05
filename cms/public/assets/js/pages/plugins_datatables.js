$(function() {
    // datatables
    //altair_datatables.dt_default();
    altair_datatables.dt_ajax();
    /*
    altair_datatables.dt_scroll();
    altair_datatables.dt_individual_search();
    altair_datatables.dt_colVis();
    altair_datatables.dt_tableExport();
    */
});

var ajaxParams = {}; // set filter mode
var tableInitialized = false;

altair_datatables = {
    dt_default: function() {
        var $dt_default = $('#dt_default');
        if($dt_default.length) {
            $dt_default.DataTable();
        }
    },
    dt_scroll: function() {
        var $dt_scroll = $('#dt_scroll');
        if($dt_scroll.length) {
            $dt_scroll.DataTable({
                "scrollY": "200px",
                "scrollCollapse": false,
                "paging": false
            });
        }
    },
    dt_ajax: function() {
        var $dt_ajax = $('.tbl_ajax');
        
        if($dt_ajax.length) {
            //var grid = new Datatable();
            var length = 10,
                disable_sorting = [],
                default_column_sorting = 0,
                default_dir_sorting = 'desc';

            if($dt_ajax.attr('data-length'))
            {
                length = $dt_ajax.data('length');
            }

            if($dt_ajax.attr('data-disable-sorting'))
            {
                disable_sorting = $dt_ajax.data('disable-sorting');
            }

            if($dt_ajax.attr('data-default-column-sorting'))
            {
                default_column_sorting = $dt_ajax.data('default-column-sorting');

            }

            if($dt_ajax.attr('data-default-dir-sorting'))
            {
                default_dir_sorting = $dt_ajax.data('default-dir-sorting');
            }

            
            var dataTable = $dt_ajax.DataTable({

                "bFilter": false,
                "serverSide": true, // enable/disable server side ajax loading
                "bStateSave": false, // save datatable state(pagination, sort, etc) in cookie.

                "lengthMenu": [
                    [5,10, 20, 50, 100, 150],
                    [5,10, 20, 50, 100, 150] // change per page values here
                ],
                "pageLength": length, // default record count per page
                "language": { // language settings
                    // metronic spesific
                    "ajaxRequestGeneralError": "Koneksi error",

                    // data tables spesific
                    "infoEmpty": "Data tidak ditemukan",
                    "emptyTable": "Belum ada data",
                    "zeroRecords": "Data tidak ditemukan"
                },
                "orderClasses": false,
                "orderCellsTop": true,
                "columnDefs": [{ // define columns sorting options(by default all columns are sortable extept the first checkbox column)
                    'orderable': false,
                    'targets': disable_sorting
                }],
                "autoWidth": false, // disable fixed width and enable fluid table
                "processing": false,
                "ajax": {
                    "url": $dt_ajax.data('url'), // ajax source
                    "type": "POST",
                    "timeout": 20000,
                    "data": function(data) { // add request parameters before submit
                        $.each(ajaxParams, function(key, value) {
                            data[key] = value;
                        });
                        altair_helpers.content_preloader_show('md','primary','.md-card');
                    },
                    "dataSrc": function(res) { // Manipulate the data returned from the server
                        if (res.customActionMessage) {
                            altair_datatables.showNotification("<a href='javscript:;' class='notify-action'>Clear</a> "+res.customActionMessage, res.customActionStatus == 'OK' ? 'success' : 'danger');
                        }
                        altair_helpers.content_preloader_hide();
                        

                        return res.data;
                    },
                    "error": function() { // handle general connection errors
                        altair_datatables.showNotification("<a href='javscript:;' class='notify-action'>Clear</a> Koneksi error", "danger");
                        altair_helpers.content_preloader_hide();

                    }
                },
                "drawCallback": function(oSettings) { // run some code on table redraw

                    if (tableInitialized === false) { // check if table has been initialized
                        tableInitialized = true; // set table initialized
                        $dt_ajax.show(); // display table
                    }

                    // callback for ajax data load
                    altair_md.init();
                    //altair_md.checkbox_radio($dt_ajax.find('[data-md-icheck]'));
                    altair_helpers.table_check();
                    
                },
                "order": [
                   [default_column_sorting, default_dir_sorting]
                ]// set first column as a default sort by asc
            });
            
            $dt_ajax.on('click', '.filter-submit', function(e) {
                e.preventDefault();
                altair_datatables.submitFilter(dataTable);
            });

            // handle filter cancel button click
            $dt_ajax.on('click', '.filter-cancel', function(e) {
                e.preventDefault();
                altair_datatables.resetFilter(dataTable);
            });


            
        }
    },
    submitFilter: function(dataTable) {
        var table = $('.tbl_ajax');
        altair_datatables.setAjaxParam("action", "filter");

        // get all typeable inputs
        $('textarea.form-filter, select.form-filter, input.form-filter:not([type="radio"],[type="checkbox"])', table).each(function() {
            altair_datatables.setAjaxParam($(this).attr("name"), $(this).val());
        });

        // get all checkboxes
        $('input.form-filter[type="checkbox"]:checked', table).each(function() {
            altair_datatables.addAjaxParam($(this).attr("name"), $(this).val());
        });

        // get all radio buttons
        $('input.form-filter[type="radio"]:checked', table).each(function() {
            altair_datatables.setAjaxParam($(this).attr("name"), $(this).val());
        });

        dataTable.ajax.reload();
    },
    resetFilter: function(dataTable) {
        var table = $('.tbl_ajax');
        $('textarea.form-filter, select.form-filter, input.form-filter', table).each(function() {
            if( $(this).hasClass('selectized') ) {
                var $select = $(this).selectize();
                var selectize = $select[0].selectize;
                selectize.setValue('none');
            } else { 
                $(this).val('');
            }
            
        });
        $('input.form-filter[type="checkbox"]', table).each(function() {
            $(this).attr("checked", false);
        });
        altair_datatables.clearAjaxParams();
        altair_datatables.addAjaxParam("action", "filter_cancel");
        dataTable.ajax.reload();
    },
    setAjaxParam: function(name, value) {
        ajaxParams[name] = value;
    },

    addAjaxParam: function(name, value) {
        if (!ajaxParams[name]) {
            ajaxParams[name] = [];
        }

        skip = false;
        for (var i = 0; i < (ajaxParams[name]).length; i++) { // check for duplicates
            if (ajaxParams[name][i] === value) {
                skip = true;
            }
        }

        if (skip === false) {
            ajaxParams[name].push(value);
        }
    },
    clearAjaxParams: function(name, value) {
        ajaxParams = {};
    },
    showNotification: function(message = '',status = '') {
        thisNotify = UIkit.notify({
            message: message,
            status: status,
            timeout: 5000,
            group: null,
            pos: 'top-center'
        });
    },
    dt_individual_search: function() {
        var $dt_individual_search = $('#dt_individual_search');
        if($dt_individual_search.length) {

            // Setup - add a text input to each footer cell
            $dt_individual_search.find('tfoot th').each( function() {
                var title = $dt_individual_search.find('tfoot th').eq( $(this).index() ).text();
                $(this).html('<input type="text" class="md-input" placeholder="' + title + '" />');
            } );

            // reinitialize md inputs
            altair_md.inputs();

            // DataTable
            var individual_search_table = $dt_individual_search.DataTable();

            // Apply the search
            individual_search_table.columns().every(function() {
                var that = this;

                $('input', this.footer()).on('keyup change', function() {
                    that
                        .search( this.value )
                        .draw();
                } );
            });

        }
    },
    dt_colVis: function() {
        var $dt_colVis = $('#dt_colVis'),
            $dt_buttons = $dt_colVis.prev('.dt_colVis_buttons');

        if($dt_colVis.length) {

            // init datatables
            var colVis_table = $dt_colVis.DataTable({
                buttons: [
                    {
                        extend: 'colvis',
                        fade: 0
                    }
                ]
            });

            colVis_table.buttons().container().appendTo( $dt_buttons );

        }
    },
    dt_tableExport: function() {
        var $dt_tableExport = $('#dt_tableExport'),
            $dt_buttons = $dt_tableExport.prev('.dt_colVis_buttons');

        if($dt_tableExport.length) {
            var table_export = $dt_tableExport.DataTable({
                buttons: [
                    {
                        extend:    'copyHtml5',
                        text:      '<i class="uk-icon-files-o"></i> Copy',
                        titleAttr: 'Copy'
                    },
                    {
                        extend:    'print',
                        text:      '<i class="uk-icon-print"></i> Print',
                        titleAttr: 'Print'
                    },
                    {
                        extend:    'excelHtml5',
                        text:      '<i class="uk-icon-file-excel-o"></i> XLSX',
                        titleAttr: ''
                    },
                    {
                        extend:    'csvHtml5',
                        text:      '<i class="uk-icon-file-text-o"></i> CSV',
                        titleAttr: 'CSV'
                    },
                    {
                        extend:    'pdfHtml5',
                        text:      '<i class="uk-icon-file-pdf-o"></i> PDF',
                        titleAttr: 'PDF'
                    }
                ]
            });

            table_export.buttons().container().appendTo( $dt_buttons );

        }
    }
};
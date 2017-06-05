$(function() {
    // datatables
    altair_datatablesku.dt_ajax();
    
});

var ajaxParams = {}; // set filter mode
var tableInitialized = false;

altair_datatablesku = {
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
                        altair_datatablesku.showNotification("<a href='javscript:;' class='notify-action'>Clear</a> Koneksi error", "danger");
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
                altair_datatablesku.submitFilter(dataTable);
            });

            // handle filter cancel button click
            $dt_ajax.on('click', '.filter-cancel', function(e) {
                e.preventDefault();
                altair_datatablesku.resetFilter(dataTable);
            });


            
        }
    },
    submitFilter: function(dataTable) {
        var table = $('.tbl_ajax');
        altair_datatablesku.setAjaxParam("action", "filter");

        // get all typeable inputs
        $('textarea.form-filter, select.form-filter, input.form-filter:not([type="radio"],[type="checkbox"])', table).each(function() {
            altair_datatablesku.setAjaxParam($(this).attr("name"), $(this).val());
        });

        // get all checkboxes
        $('input.form-filter[type="checkbox"]:checked', table).each(function() {
            altair_datatablesku.addAjaxParam($(this).attr("name"), $(this).val());
        });

        // get all radio buttons
        $('input.form-filter[type="radio"]:checked', table).each(function() {
            altair_datatablesku.setAjaxParam($(this).attr("name"), $(this).val());
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
        altair_datatablesku.clearAjaxParams();
        altair_datatablesku.addAjaxParam("action", "filter_cancel");
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
    }
};
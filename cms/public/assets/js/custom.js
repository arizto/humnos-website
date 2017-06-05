$(function() {

	custom_scripts.script_modal();
	custom_scripts.script_delete();

});



custom_scripts = {
	script_modal: function() {
		
		var $modal = $('.ajax-modal');
		var modal = UIkit.modal(".ajax-modal");

		var $modal2 = $('.ajax-modal-2');
		var modal2 = UIkit.modal(".ajax-modal-2");

		if( $modal.length ) {
			$('body').on('click','.open-modal', function(){
				modal.show();
              	var url = $(this).data('url');
              	
              	$modal.load( url, '', function(){
              		//UIkit.modal($modal).show();
            	});
              	
            });

			$modal.on('click','.modal-close',function() {
				modal.hide();
			});

			$modal.on('click','.form-submit',function() {
				var target = $(this).data('target');
				$(target).submit();
			});

            $modal.on({
            	'hide.uk.modal': function() {
            		var content = `<div class="uk-modal-dialog uk-modal-dialog-blank">
								   		<div class="md-card uk-height-viewport">
								   			<div class="md-card-toolbar">
									            <div class="uk-float-right">
									                <a href="javascript:;" class="uk-modal-close"><i class="md-icon material-icons">&#xE14C;</i></a>
									            </div>
									            <span class="md-icon material-icons uk-modal-close">&#xE5C4;</span>
									        </div>  
								   			<div class="md-card-content uk-vertical-align uk-text-center">
								   					<img src="${base_url}assets/img/spinners/spinner.gif" class="uk-vertical-align-middle" alt="" width="32" height="32">
								   			</div>
								   		</div>
								    </div>`;
					$(this).html(content);
            	}
            });
			
		}

		if( $modal2.length ) {
			$('body').on('click','.open-modal-2', function(){
				modal2.show();
              	var url = $(this).data('url');
              	
              	$modal2.load( url, '', function(){
              		//UIkit.modal($modal).show();
            	});
              	
            });

			$modal2.on('click','.modal-close',function() {
				modal2.hide();
			});

			$modal2.on('click','.form-submit',function() {
				var target = $(this).data('target');
				$(target).submit();
			});

            $modal2.on({
            	'hide.uk.modal': function() {
            		var content = `<div class="uk-modal-dialog uk-modal-dialog-blank">
								   		<div class="md-card uk-height-viewport">
								   			<div class="md-card-toolbar">
									            <div class="uk-float-right">
									                <a href="javascript:;" class="uk-modal-close"><i class="md-icon material-icons">&#xE14C;</i></a>
									            </div>
									            <span class="md-icon material-icons uk-modal-close">&#xE5C4;</span>
									        </div>  
								   			<div class="md-card-content uk-vertical-align uk-text-center">
								   					<img src="${base_url}assets/img/spinners/spinner.gif" class="uk-vertical-align-middle" alt="" width="32" height="32">
								   			</div>
								   		</div>
								    </div>`;
					$(this).html(content);
            	}
            });
			
		}

	},
	script_delete: function() {

		$('body').on('click','.delete', function(){
			var url = $(this).data('url');
			var parent = $(this).parents('tr');
			parent.addClass('md-bg-green-200');
			UIkit.modal.confirm('Apakah anda yakin?' , function(){
				window.location.href = url;
			}, function() {
				parent.removeClass('md-bg-green-200');
			});
        });

        $('body').on('click','.bulk-delete', function(){
			var target = $(this).data('target');
			var $checkAll = $(target).find('.check_all');
            var $checkRow = $(target).find('.check_row');
            var val = [];
            $(target).find('input.check_row:checked').each(function(){
            	val.push($(this).val());
            });

            if( val.length > 0 ) {
            	UIkit.modal.confirm('Apakah anda yakin?' , function(){
					$(target).submit();
				}, function() {
					$checkAll.iCheck('uncheck');
					$checkRow.iCheck('uncheck');
				});
            }
        });

	},
	form_validate: function(target) {

		window.Parsley
		  	.addValidator('remoteKu', {
		    	requirementType: 'string',
		    	validateString: function(value, requirement) {

		    		var params = requirement.data,
		    			url = requirement.url,
		    			status = false,
		    			data = {};


		    		for (var key in params) {
		    			if($('input[name="'+params[key]+'"]').length > 0)
					  		data[key] = $('input[name="'+params[key]+'"]').val();
					}

		    		$.ajax({
					  	url: base_url+url,
					  	data: data,
					  	method: 'POST',
					  	async: false
					}).done(function(result) {
					  	result = JSON.parse(result);
					  	status = result.status;
					});

					return status
	    		},
		    	messages: {
		      		en: 'this value invalid'
		    	}
	  	});

		var $formValidate = $(target);

        $formValidate
            .parsley()
            .on('form:validated',function() {
                altair_md.update_input($formValidate.find('.md-input-danger'));
            })
            .on('field:validated',function(parsleyField) {
                if($(parsleyField.$element).hasClass('md-input')) {
                    altair_md.update_input( $(parsleyField.$element) );
                }
            });

        window.Parsley.on('field:validate', function() {
            var $server_side_error = $(this.$element).closest('.md-input-wrapper').siblings('.error_server_side');
            if($server_side_error) {
                $server_side_error.hide();
            }
        });
	}
}
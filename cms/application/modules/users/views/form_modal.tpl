<!-- BEGIN MODAL -->
<div class="uk-modal-dialog uk-modal-dialog-blank">
	<!-- BEGIN CARD -->
	<div class="md-card uk-height-viewport">
			<!-- BEGIN CARD TOOLBAR -->
	    <div class="md-card-toolbar">
	        <div class="md-card-toolbar-actions">
                <i class="md-icon material-icons uk-text-success form-submit" data-target="#form-user">&#xE161;</i>
                <i class="md-icon material-icons modal-close">&#xE14C;</i>
            </div>
	        <span class="md-icon material-icons uk-modal-close">&#xE5C4;</span>
	        <h3 class="md-card-toolbar-heading-text">
	            {$title}
	        </h3>
	    </div>                  
	    <!-- END CARD TOOLBAR -->
	    <!-- BEGIN CARD CONTENT -->
	    <div class="md-card-content uk-margin-large-bottom large-padding">
	    	<form id="form-user" method="post" action="{$action_url}">
	    		<input type="hidden" name="key" value="qwerty"/>
	    		{if $action == 'edit'}
	    		<input type="hidden" name="user_id" value="{$data['user_id']}"/>
	    		{/if}
	        	<div class="parsley-row uk-margin-top">
	                <label>Username *</label>
	                <input type="text" class="md-input uk-form-width-medium" name="user_name" required value="{$data['username']}" data-parsley-required-message="harus diisi (5 - 12 karakter)" data-parsley-minlength="5" data-parsley-maxlength="12" data-parsley-minlength-message="min. 5 karakter" data-parsley-maxlength-message="max 12 karakter" data-parsley-remote-ku='{ "url": "users/check_username", "data" : { "username":"user_name","user_id":"user_id" } }' data-parsley-remote-ku-message="username sudah terdaftar" 
	                data-parsley-type="alphanum" data-parsley-type-message="hanya boleh huruf dan angka"/>
	            </div>
	            {if $action == 'add'}
	            <div class="parsley-row uk-margin-top">
	                <label>Password *</label>
	                <a href="javascript:;" class="uk-form-password-toggle" data-uk-form-password>show</a>
	                <input type="password" id="#password" class="md-input" name="password" required value="{$data['password']}" data-parsley-required-message="harus diisi (5 - 12 karakter)" data-parsley-minlength="5" data-parsley-maxlength="12" data-parsley-minlength-message="min. 5 karakter" data-parsley-maxlength-message="max 12 karakter" data-parsley-pattern="/^\S*$/" data-parsley-pattern-message="tidak boldeh ada spasi"/>
	            </div>
	            <div class="parsley-row uk-margin-top">
	                <label>Konfirmasi password *</label>
	                <a href="javascript:;" class="uk-form-password-toggle" data-uk-form-password>show</a>
	                <input type="password" class="md-input" name="confirm_password" required value="{$data['confirm_password']}" data-parsley-required-message="harus diisi (5 - 12 karakter)" data-parsley-minlength="5" data-parsley-maxlength="12" data-parsley-minlength-message="min. 5 karakter" data-parsley-maxlength-message="max 12 karakter" data-parsley-equalto=":password" data-parsley-equalto-message="konfimasi password harus sama dengan password"/>
	            </div>
	            {/if}
	            <div class="parsley-row uk-margin-top">
	            	<label>Status *</label>
	                <select name="status" class="uk-form-width-small form-filter selectku" data-md-selectize data-parsley-required-message "harus diisi">
	                    <option value="1" {if $data['active'] == 1}selected{/if}>Active</option>
	                    <option value="0" {if $data['active'] == 0}selected{/if}>Disabled</option>
	                </select>
	            </div>
	        </form>
	    </div>
	    <!-- END CARD CONTENT -->
	</div>
	<!-- END CARD -->
</div>
<!-- END MODAL -->

<script type="text/javascript">
	{literal}
	$(document).ready(function(){
		altair_md.init();
		altair_forms.textarea_autosize();
		$('.selectku').selectize();
		custom_scripts.form_validate('#form-user');
	});
	{/literal}
</script>
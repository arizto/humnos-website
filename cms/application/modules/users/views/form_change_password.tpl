<!-- BEGIN MODAL -->
<div class="uk-modal-dialog uk-modal-dialog-blank">
	<!-- BEGIN CARD -->
	<div class="md-card uk-height-viewport">
			<!-- BEGIN CARD TOOLBAR -->
	    <div class="md-card-toolbar">
	        <div class="md-card-toolbar-actions">
                <i class="md-icon material-icons uk-text-success form-submit" data-target="#form-change-password">&#xE161;</i>
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
	    	<form id="form-change-password" method="post" action="{$action_url}">
	    		<input type="hidden" name="key" value="qwerty"/>
	    		<input type="hidden" name="user_id" value="{$data['user_id']}"/>
	            <div class="parsley-row uk-margin-top">
	                <label>Password lama *</label>
	                <a href="javascript:;" class="uk-form-password-toggle" data-uk-form-password>show</a>
	                <input type="password" class="md-input" name="password" required value="{$data['password']}" data-parsley-required-message="harus diisi (5 - 12 karakter)" data-parsley-minlength="5" data-parsley-maxlength="12" data-parsley-minlength-message="min. 5 karakter" data-parsley-maxlength-message="max 12 karakter" data-parsley-remote-ku='{ "url": "users/check_password", "data" : { "password":"password","user_id":"user_id" } }' data-parsley-remote-ku-message="password salah"/>
	            </div>
	            <div class="parsley-row uk-margin-top">
	                <label>Password baru *</label>
	                <a href="javascript:;" class="uk-form-password-toggle" data-uk-form-password>show</a>
	                <input type="password" id="new_password" class="md-input" name="new_password" required value="{$data['new_password']}" data-parsley-required-message="harus diisi (5 - 12 karakter)" data-parsley-minlength="5" data-parsley-maxlength="12" data-parsley-minlength-message="min. 5 karakter" data-parsley-maxlength-message="max 12 karakter" data-parsley-pattern="/^\S*$/" data-parsley-pattern-message="tidak boldeh ada spasi"/>
	            </div>
	            <div class="parsley-row uk-margin-top">
	                <label>Konfirmasi password baru *</label>
	                <a href="javascript:;" class="uk-form-password-toggle" data-uk-form-password>show</a>
	                <input type="password" class="md-input" name="confirm_new_password" required value="{$data['confirm_new_password']}" data-parsley-required-message="harus diisi (5 - 12 karakter)" data-parsley-minlength="5" data-parsley-maxlength="12" data-parsley-minlength-message="min. 5 karakter" data-parsley-maxlength-message="max 12 karakter" data-parsley-equalto="#new_password" data-parsley-equalto-message="konfimasi password harus sama dengan password"/>
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
		custom_scripts.form_validate('#form-change-password');
	});
	{/literal}
</script>
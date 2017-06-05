
<!-- BEGIN CARD -->
<div class="md-card">
    <!-- BEGIN CARD CONTENT -->
    <div class="md-card-content large-padding">
    	{if !empty($message) }
    	<div class="uk-alert uk-alert-danger" data-uk-alert>
            <a href="javascript:;" class="uk-alert-close uk-close"></a>
            {$message}
        </div>
        {/if}
    	<div class="login_heading">
    		<!--
            <div class="user_avatar"></div>
        	-->
        	<div class="md-bg-grey-200 uk-align-center uk-border-circle" style="width: 80px; height: 80px; padding: 10px;">
        		<img class="uk-responsive-height uk-margin-top uk-margin-bottom uk-align-center" src="{base_url()}public/assets/img/cross.png" style="width:40px"/>
        	</div>
        </div>
    	<form id="form-loginku" method="post" action="{$action_url}">
    		<input type="hidden" name="key" value="qwerty"/>
        	<div class="parsley-row uk-margin-top">
                <label>Username</label>
                <input type="text" class="md-input" name="username" required value="" data-parsley-required-message="harus diisi"/>
            </div>
            <div class="parsley-row uk-margin-top">
                <label>Password</label>
                <input type="password" class="md-input" name="password" required value="" data-parsley-required-message="harus diisi"/>
            </div>
            <div class="uk-margin-medium-top">
                <button type="submit" class="md-btn md-btn-primary md-btn-block md-btn-large">Sign In</button>
            </div>
        </form>
    </div>
    <!-- END CARD CONTENT -->
</div>
<!-- END CARD -->

<script type="text/javascript">
	{literal}
	$(document).ready(function(){
		custom_scripts.form_validate('#form-loginku');
	});
	{/literal}
</script>
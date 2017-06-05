<!-- BEGIN MODAL -->
<div class="uk-modal-dialog uk-modal-dialog-blank">
	<!-- BEGIN CARD -->
	<div class="md-card uk-height-viewport">
			<!-- BEGIN CARD TOOLBAR -->
	    <div class="md-card-toolbar">
	        <div class="md-card-toolbar-actions">
                <i class="md-icon material-icons uk-text-success form-submit" data-target="#form-gk">&#xE161;</i>
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
	    	<form id="form-gk" method="post" action="{$action_url}">
	    		<input type="hidden" name="key" value="qwerty"/>
	    		{if $action == 'edit'}
	    		<input type="hidden" name="gk_id" value="{$data['gk_id']}"/>
	    		{/if}
	    		<div class="parsley-row">	                
                    <label>Tanggal *</label>
                    <input class="md-input uk-form-width-medium" type="text" name="date" data-uk-datepicker="{ format:'DD-MM-YYYY' }" value="{$data['date']}" required readonly data-parsley-required-message="harus diisi">
	            </div>
	        	<div class="parsley-row uk-margin-top">
	                <label>Judul *</label>
	                <input type="text" class="md-input" name="title" required value="{$data['title']}" data-parsley-required-message="harus diisi"/>
	            </div>
	            <div class="parsley-row uk-margin-top">
	            	<label>Status *</label>
	                <select name="status" class="uk-form-width-small form-filter selectku" data-md-selectize data-parsley-required-message "harus diisi">
	                	<option value="0" {if $data['published'] == 0}selected{/if}>Draft</option>
	                    <option value="1" {if $data['published'] == 1}selected{/if}>Publish</option>
	                </select>
	            </div>
	            <div class="parsley-row uk-margin-top">
	                <label>Ayat Kutipan</label>
	                 <textarea cols="30" rows="4" class="md-input uk-form-width-large" name="verse">{$data['verse']}</textarea>
	            </div>
	            <div class="parsley-row uk-margin-top">
	                <label>Konten *</label>
	                <textarea cols="30" rows="4" class="md-input" name="content" required data-parsley-required-message="harus diisi">{$data['content']}</textarea>
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
		custom_scripts.form_validate('#form-gk');
	});
	{/literal}
</script>
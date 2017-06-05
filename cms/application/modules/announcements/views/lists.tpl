
<div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
	<div class="heading_actions">
        <a href="javascript:;" class="md-btn md-btn-success md-btn-small md-btn-wave-light md-btn-icon open-modal" data-url="{base_url('public/announcements/add')}">
        	<i class="uk-icon-plus"> Tambah</i>
        </a>
        <a href="javascript:;" class="md-btn md-btn-danger md-btn-small md-btn-wave-light md-btn-icon bulk-delete" data-target="#form-bulk-delete">
        	<i class="uk-icon-times"> Hapus</i>
        </a>
    </div>
    <h1>{$title}</h1>
    <span class="uk-text-upper uk-text-small"><a href="{base_url()}public/pengumuman/">{$sub_title}</a></span>
</div>

<div id="page_content_inner">
	<!-- BEGIN CARD -->
	<div class="md-card uk-margin-large-bottom">
		<!-- BEGIN CARD CONTENT -->
	    <div class="md-card-content">
	    	{if !empty($message) }
	    	<div class="uk-alert uk-alert-{$message['type']}" data-uk-alert>
                <a href="javascript:;" class="uk-alert-close uk-close"></a>
                {$message['text']}
            </div>
            {/if}

	    	<div class="uk-overflow-container uk-margin-large-bottom table-container">
	    		<form id="form-bulk-delete" method="post" action="{base_url()}public/announcements/bulk_delete">
			        <table class="uk-table uk-table-striped tbl_ajax table_check" data-url="{base_url()}public/announcements/lists_ajax" data-disable-sorting="[0,1,5]"
			        data-default-column-sorting="4" data-default-dir-sorting="desc">
			            <thead>
			                <tr>
		                	 	<th class="uk-width-1-10 uk-text-center small_col"><input type="checkbox" data-md-icheck class="check_all"></th>
			                	<th>No</th>
			                    <th>Konten</th>
			                    <th>Status</th>
			                    <th>Tanggal Update</th>
			                    <th>Aksi</th>
			                </tr>
			                <tr class="filter">
			                	<td></td>
			            		<td></td>
			            		<td>
			            			<input type="text" name="content" class="md-input form-filter" placeholder="konten" />
			            		</td>
			            		<td>
			            			<select id="select_status" name="status" class="uk-form-width-small form-filter" data-md-selectize>
		                                <option value="none">Pilih Status</option>
		                                <option value="1">Publish</option>
		                                <option value="0">Draft</option>
		                            </select>
			            		</td>
			            		<td>
			            			<div class="uk-input-group">
		                                <span class="uk-input-group-addon"><i class="uk-input-group-icon uk-icon-calendar"></i></span>
		                                <label for="uk_dp_1">Tgl Awal</label>
		                                <input class="md-input uk-form-width-small form-filter" type="text" id="date_from" name="date_from" data-uk-datepicker="{ format:'DD-MM-YYYY' }">
		                            </div>
		                            <div class="uk-input-group">
		                                <span class="uk-input-group-addon"><i class="uk-input-group-icon uk-icon-calendar"></i></span>
		                                <label for="uk_dp_1">Tgl Akhir</label>
		                                <input class="md-input uk-form-width-small form-filter" type="text" id="date_to" name="date_to" data-uk-datepicker="{ format:'DD-MM-YYYY' }">
		                            </div>
			            		</td>
			            		<td>
			            			<button class="md-btn md-btn-primary md-btn-small md-btn-wave-light md-btn-icon filter-submit"><i class="uk-icon-search"></i> Cari</button>
			            			<br/>
			            			<br/>
			            			<button class="md-btn md-btn-danger md-btn-small md-btn-wave-light md-btn-icon filter-cancel"><i class="uk-icon-times"></i> Reset</button>
			            		</td>
			            	</tr>
			            </thead>
			            <tbody>
			            	
			            </tbody>
			        </table>
			    </form>
	        </div>

	    </div>
	    <!-- END CARD CONTENT -->
	</div>
	<!-- END CARD -->

</div>

<div class="uk-modal uk-modal-card-fullscreen ajax-modal">
	<div class="uk-modal-dialog uk-modal-dialog-blank">
   		<div class="md-card uk-height-viewport">
   			<div class="md-card-toolbar">
	            <div class="uk-float-right">
	                <a href="javascript:;" class="uk-modal-close"><i class="md-icon material-icons">&#xE14C;</i></a>
	            </div>
	            <span class="md-icon material-icons uk-modal-close">&#xE5C4;</span>
	        </div>  
   			<div class="md-card-content uk-vertical-align uk-text-center">
   					<img src="{base_url()}public/assets/img/spinners/spinner.gif" class="uk-vertical-align-middle" alt="" width="32" height="32">
   			</div>
   		</div>
    </div>
</div>










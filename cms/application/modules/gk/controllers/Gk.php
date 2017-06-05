<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gk extends CI_Controller {
	
	private $user = array(
		'user_id' => 1
	);

	private $module = array();

	function __construct()
	{
		parent::__construct();

		$this->load->model('gkm');

		$this->user['user_id'] = $this->session->userdata('user_id');

		$this->module = $this->load->config('modules')['gk'];
		$this->module['main_route'] = base_url($this->module['route']);

		$this->parser->set_partial('header','partials/header');
		$this->parser->set_partial('navigation','partials/navigation');
		$this->parser->set_partial('footer','partials/footer');
		
	}

	public function index()
	{
		$this->lists();
	}

	public function lists()
	{
		$data['title'] = 'Data Garam Keluarga';

		$datac['title'] = 'Data Garam Keluarga';
		$datac['sub_title'] = 'Manage Data Garam Keluarga';

		$datac['message'] = $this->session->flashdata('message');

		$this->parser->set_partial('content','lists',$datac,true);

		$this->parser->parse('default',$data);
	}

	public function lists_ajax()
	{

		$start = 0;
		$length = 10;
		$order = '';
		$sort = array();

		if($this->input->post('start'))
		{
			$start = intval($this->input->post('start'));
		}

		if ( intval($this->input->post('length')) > 0 ) {
			$length = intval($this->input->post('length'));
		}

		if($this->input->post('order') != '')
		{
			$order = $this->input->post('order');
			$column = $order[0]['column'];
			switch($column)
			{

				case 2 : 
					$sort['column'] = 'title';
					break;
				case 3 : 
					$sort['column'] = 'date';
					break;
				case 4 : 
					$sort['column'] = 'published';
					break;
				default :
					$sort['column'] = 'date';
					break;
			}

			$sort['dir'] = $order[0]['dir'];

		}

		$where = array();

		$TotalRecords = $this->gkm->get_count()->total;

		$filtered = false;

		if($this->input->post('title') != '' )
		{
			$where['title like'] = '%'.$this->input->post('title').'%';
			$filtered = true;
		}

		if($this->input->post('date_from') != '' )
		{
			$where['DATE(date) >='] = date('Y-m-d',strtotime($this->input->post('date_from')));
			$filtered = true;
		}

		if($this->input->post('date_to') != '' )
		{
			$where['DATE(date) <='] = date('Y-m-d',strtotime($this->input->post('date_to')));
			$filtered = true;
		}

		if(  $this->input->post('status') != '' && $this->input->post('status') !== 'none' )
		{
			$where['published'] = $this->input->post('status');
			$filtered = true;
		}

		$param = array(
			'where' 	=> $where,
			'order' 	=> $sort,
			'start'		=> $start,
			'length'	=> $length
		);

		$gks = $this->gkm->gets($param);

		$TotalRecordsFiltered = $TotalRecords;

		if( $filtered )
		{
			$TotalRecordsFiltered = $this->gkm->get_count($where)->total;
		}

		$sEcho = intval($this->input->post('draw'));

	    $records = array();
	    $records['data'] = array();

	    if( !empty($gks) )
	    {
	    	$no = $start;

	    	foreach($gks as $g)
	    	{
	    		$no++;

	    		$checkbox = '<div class="uk-text-center uk-table-middle small_col"><input type="checkbox" data-md-icheck class="check_row" name="gk_ids[]" value="'.$g->gk_id.'"></div>';
	    		//$checkbox= '<input type="checkbox" data-md-icheck class="check_row">';
	    		$published = ($g->published == 0) ? '<span class="uk-badge uk-badge-danger">draft</span>' : '<span class="uk-badge uk-badge-success">publish</span>';
	    		$actions = '<a href="javascript:;" class="open-modal" data-url="'.base_url('public/gk/edit/'.$g->gk_id).'"><i class="md-icon material-icons">&#xE254;</i></a>
                            <a href="javascript:;" class="delete" data-url="'.base_url('public/gk/delete/'.$g->gk_id).'"><i class="md-icon material-icons uk-text-danger">&#xE14C;</i></a>';
	    		$records['data'][] = array(
	    			$checkbox,
					$no,
					'<div style="width: 150px;" class="uk-text-truncate">'.$g->title.'</div>',
					date('d-m-Y',strtotime($g->date)),
					'<div class="uk-text-center">'.$published.'</div>',
					'<div class="uk-text-center">'.$actions.'</div>'
				);

	    	}
	    }

	    $records["draw"] = $sEcho;
		$records["recordsTotal"] = $TotalRecords;
		$records["recordsFiltered"] = $TotalRecordsFiltered;
		echo json_encode($records);
	}

	public function add() {

		if( $this->input->post('key') == 'qwerty' )
		{
			$excerpt = $string = word_limiter($this->input->post('content'), 50);
			$title = str_replace(array('’','‘','“','”','…'), array("'","'",'"','"','...'), $this->input->post('title'));
			$content = str_replace(array('’','‘','“','”','…'), array("'","'",'"','"','...'), $this->input->post('content'));
			$excerpt = str_replace(array('’','‘','“','”','…'), array("'","'",'"','"','...'), $excerpt);
			$verse = str_replace(array('’','‘','“','”','…'), array("'","'",'"','"','...'), $this->input->post('verse'));
			$data = array(
				'title' 		=> $title,
				'content' 		=> $content,
				'excerpt' 		=> $excerpt,
				'verse' 		=> $verse,
				'date'			=> date('Y-m-d H:i:s',strtotime($this->input->post('date'))),
				'published'		=> $this->input->post('status'),
				'updated'		=> date('Y-m-d H:i:s'),
				'updated_by'	=> $this->user['user_id']

			);

			$result = $this->gkm->add($data);
			$this->session->set_flashdata('message', $result['message']);
			redirect($this->module['main_route']);
		}

		$data['title'] = 'Tambah Data Garam Keluarga';
		$data['action_url'] = base_url('public/gk/add');
		$data['action'] = 'add';
		$data['data'] = array(
			'title'		=> '',
			'content' 	=> '',
			'verse'		=> '',
			'published'	=> 0,
			'date'		=> date('d-m-Y')
		);
		$this->parser->parse('form_modal',$data);
	}

	public function edit($id = null) {

		if( $this->input->post('key') == 'qwerty' )
		{
			$excerpt = $string = word_limiter($this->input->post('content'), 50);
			$title = str_replace(array('’','‘','“','”','…'), array("'","'",'"','"','...'), $this->input->post('title'));
			$content = str_replace(array('’','‘','“','”','…'), array("'","'",'"','"','...'), $this->input->post('content'));
			$excerpt = str_replace(array('’','‘','“','”','…'), array("'","'",'"','"','...'), $excerpt);
			$verse = str_replace(array('’','‘','“','”','…'), array("'","'",'"','"','...'), $this->input->post('verse'));
			$data = array(
				'title' 		=> $title,
				'content' 		=> $content,
				'excerpt' 		=> $excerpt,
				'verse' 		=> $verse,
				'date'			=> date('Y-m-d H:i:s',strtotime($this->input->post('date'))),
				'published'		=> $this->input->post('status'),
				'updated'		=> date('Y-m-d H:i:s'),
				'updated_by'	=> $this->user['user_id']

			);

			$result = $this->gkm->edit($data, $this->input->post('gk_id'));
			$this->session->set_flashdata('message', $result['message']);
			redirect($this->module['main_route']);
		}

		if( $id == null )
		{
			redirect($this->module['main_route']);
		}

		$data['title'] = 'Edit Data Garam Keluarga';
		$data['action_url'] = base_url('public/gk/edit');
		$data['action'] = 'edit';

		$gk = $this->gkm->get($id);

		if( empty($gk) )
		{
			redirect($this->module['main_route']);
		}

		$data['data'] = array(
			'gk_id'		=> $id,
			'title'		=> $gk->title,
			'content' 	=> $gk->content,
			'verse'		=> $gk->verse,
			'published'	=> $gk->published,
			'date'		=> date('d-m-Y',strtotime($gk->date))
		);
		$this->parser->parse('form_modal',$data);
	}

	public function delete($id = null) {

		if( $id == null )
		{
			redirect($this->module['main_route']);
		}

		$result = $this->gkm->delete($id);
		$this->session->set_flashdata('message', $result['message']);
		redirect($this->module['main_route']);
		
	}

	public function bulk_delete() {

		$ids = $this->input->post('gk_ids');

		if( empty($ids) )
		{
			redirect($this->module['main_route']);
		}

		$result = $this->gkm->bulk_delete($ids);
		$this->session->set_flashdata('message', $result['message']);
		redirect($this->module['main_route']);
		
	}

}

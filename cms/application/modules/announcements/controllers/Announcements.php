<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Announcements extends CI_Controller {
	
	private $user = array(
		'user_id' => 1
	);

	private $module = array();

	function __construct()
	{
		parent::__construct();

		$this->load->model('announcementsm');

		$this->user['user_id'] = $this->session->userdata('user_id');

		$this->module = $this->load->config('modules')['announcements'];
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
		$data['title'] = 'Data Pengumuman';

		$datac['title'] = 'Data Pengumuman';
		$datac['sub_title'] = 'Manage Data Pengumuman';

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
					$sort['column'] = 'content';
					break;
				case 3 : 
					$sort['column'] = 'published';
					break;
				case 4 : 
					$sort['column'] = 'updated';
					break;
				default :
					$sort['column'] = 'updated';
					break;
			}

			$sort['dir'] = $order[0]['dir'];

		}

		$where = array();

		$TotalRecords = $this->announcementsm->get_count()->total;

		$filtered = false;

		if($this->input->post('content') != '' )
		{
			$where['content like'] = '%'.$this->input->post('content').'%';
			$filtered = true;
		}

		if($this->input->post('date_from') != '' )
		{
			$where['DATE(updated) >='] = date('Y-m-d',strtotime($this->input->post('date_from')));
			$filtered = true;
		}

		if($this->input->post('date_to') != '' )
		{
			$where['DATE(updated) <='] = date('Y-m-d',strtotime($this->input->post('date_to')));
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

		$announcements = $this->announcementsm->gets($param);

		$TotalRecordsFiltered = $TotalRecords;

		if( $filtered )
		{
			$TotalRecordsFiltered = $this->announcementsm->get_count($where)->total;
		}

		$sEcho = intval($this->input->post('draw'));

	    $records = array();
	    $records['data'] = array();

	    if( !empty($announcements) )
	    {
	    	$no = $start;

	    	foreach($announcements as $a)
	    	{
	    		$no++;

	    		$checkbox = '<div class="uk-text-center uk-table-middle small_col"><input type="checkbox" data-md-icheck class="check_row" name="announcement_ids[]" value="'.$a->announcement_id.'"></div>';
	    		$published = ($a->published == 0) ? '<span class="uk-badge uk-badge-danger">draft</span>' : '<span class="uk-badge uk-badge-success">publish</span>';
	    		$actions = '<a href="javascript:;" class="open-modal" data-url="'.base_url('public/announcements/edit/'.$a->announcement_id).'"><i class="md-icon material-icons">&#xE254;</i></a>
                            <a href="javascript:;" class="delete" data-url="'.base_url('public/announcements/delete/'.$a->announcement_id).'"><i class="md-icon material-icons uk-text-danger">&#xE14C;</i></a>';
	    		$records['data'][] = array(
	    			$checkbox,
					$no,
					'<div style="width: 100px;" class="uk-text-truncate">'.$a->excerpt.'</div>',
					'<div class="uk-text-center">'.$published.'</div>',
					date('d-m-Y',strtotime($a->updated)),
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
			$content = str_replace(array('’','‘','“','”','…'), array("'","'",'"','"','...'), $this->input->post('content'));
			$excerpt = str_replace(array('’','‘','“','”','…'), array("'","'",'"','"','...'), $excerpt);

			$data = array(
				'content' 		=> $content,
				'excerpt' 		=> $excerpt,
				'published'		=> $this->input->post('status'),
				'updated'		=> date('Y-m-d H:i:s'),
				'updated_by'	=> $this->user['user_id']

			);

			$result = $this->announcementsm->add($data);
			$this->session->set_flashdata('message', $result['message']);
			redirect($this->module['main_route']);
		}

		$data['title'] = 'Tambah Data Pengumuman';
		$data['action_url'] = base_url('public/announcements/add');
		$data['action'] = 'add';
		$data['data'] = array(
			'content' 	=> '',
			'published'	=> 1
		);
		$this->parser->parse('form_modal',$data);
	}

	public function edit($id = null) {

		if( $this->input->post('key') == 'qwerty' )
		{
			$excerpt = $string = word_limiter($this->input->post('content'), 50);
			$content = str_replace(array('’','‘','“','”','…'), array("'","'",'"','"','...'), $this->input->post('content'));
			$excerpt = str_replace(array('’','‘','“','”','…'), array("'","'",'"','"','...'), $excerpt);
			$data = array(
				'content' 		=> $content,
				'excerpt' 		=> $excerpt,
				'published'		=> $this->input->post('status'),
				'updated'		=> date('Y-m-d H:i:s'),
				'updated_by'	=> $this->user['user_id']

			);

			$result = $this->announcementsm->edit($data, $this->input->post('announcement_id'));
			$this->session->set_flashdata('message', $result['message']);
			redirect($this->module['main_route']);
		}

		if( $id == null )
		{
			redirect($this->module['main_route']);
		}

		$data['title'] = 'Edit Data Pengumuman';
		$data['action_url'] = base_url('public/announcements/edit');
		$data['action'] = 'edit';

		$a = $this->announcementsm->get($id);

		if( empty($a) )
		{
			redirect($this->module['main_route']);
		}

		$data['data'] = array(
			'announcement_id'	=> $id,
			'content' 			=> $a->content,
			'published'			=> $a->published
		);
		$this->parser->parse('form_modal',$data);
	}

	public function delete($id = null) {

		if( $id == null )
		{
			redirect($this->module['main_route']);
		}

		$result = $this->announcementsm->delete($id);
		$this->session->set_flashdata('message', $result['message']);
		redirect($this->module['main_route']);
		
	}

	public function bulk_delete() {

		$ids = $this->input->post('announcement_ids');

		if( empty($ids) )
		{
			redirect($this->module['main_route']);
		}

		$result = $this->announcementsm->bulk_delete($ids);
		$this->session->set_flashdata('message', $result['message']);
		redirect($this->module['main_route']);
		
	}

}

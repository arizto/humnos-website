<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmbunPagi extends CI_Controller {
	
	private $user = array(
		'user_id' => 1
	);

	private $module = array();

	function __construct()
	{
		parent::__construct();

		$this->load->model('embunPagim');

		$this->user['user_id'] = $this->session->userdata('user_id');

		$this->module = $this->load->config('modules')['embunPagi'];
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
		$data['title'] = 'Data Embun Pagi';

		$datac['title'] = 'Data Embun Pagi';
		$datac['sub_title'] = 'Manage Data Embun Pagi';

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

		$TotalRecords = $this->embunPagim->get_count()->total;

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

		$eps = $this->embunPagim->gets($param);

		$TotalRecordsFiltered = $TotalRecords;

		if( $filtered )
		{
			$TotalRecordsFiltered = $this->embunPagim->get_count($where)->total;
		}

		$sEcho = intval($this->input->post('draw'));

	    $records = array();
	    $records['data'] = array();

	    if( !empty($eps) )
	    {
	    	$no = $start;

	    	foreach($eps as $e)
	    	{
	    		$no++;

	    		$checkbox = '<div class="uk-text-center uk-table-middle small_col"><input type="checkbox" data-md-icheck class="check_row" name="ep_ids[]" value="'.$e->ep_id.'"></div>';
	    		$published = ($e->published == 0) ? '<span class="uk-badge uk-badge-danger">draft</span>' : '<span class="uk-badge uk-badge-success">publish</span>';
	    		$actions = '<a href="javascript:;" class="open-modal" data-url="'.base_url('public/embunPagi/edit/'.$e->ep_id).'"><i class="md-icon material-icons">&#xE254;</i></a>
                            <a href="javascript:;" class="delete" data-url="'.base_url('public/embunPagi/delete/'.$e->ep_id).'"><i class="md-icon material-icons uk-text-danger">&#xE14C;</i></a>';
	    		$records['data'][] = array(
	    			$checkbox,
					$no,
					'<div style="width: 150px;" class="uk-text-truncate">'.$e->title.'</div>',
					date('d-m-Y',strtotime($e->date)),
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

			$result = $this->embunPagim->add($data);
			$this->session->set_flashdata('message', $result['message']);
			redirect($this->module['main_route']);
		}

		$data['title'] = 'Tambah Data Embun Pagi';
		$data['action_url'] = base_url('public/embunPagi/add');
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

			$result = $this->embunPagim->edit($data, $this->input->post('ep_id'));
			$this->session->set_flashdata('message', $result['message']);
			redirect($this->module['main_route']);
		}

		if( $id == null )
		{
			redirect($this->module['main_route']);
		}

		$data['title'] = 'Edit Data Embun Pagi';
		$data['action_url'] = base_url('public/embunPagi/edit');
		$data['action'] = 'edit';

		$ep = $this->embunPagim->get($id);

		if( empty($ep) )
		{
			redirect($this->module['main_route']);
		}

		$data['data'] = array(
			'ep_id'		=> $id,
			'title'		=> $ep->title,
			'content' 	=> $ep->content,
			'verse'		=> $ep->verse,
			'published'	=> $ep->published,
			'date'		=> date('d-m-Y',strtotime($ep->date))
		);
		$this->parser->parse('form_modal',$data);
	}

	public function delete($id = null) {

		if( $id == null )
		{
			redirect($this->module['main_route']);
		}

		$result = $this->embunPagim->delete($id);
		$this->session->set_flashdata('message', $result['message']);
		redirect($this->module['main_route']);
		
	}

	public function bulk_delete() {

		$ids = $this->input->post('ep_ids');

		if( empty($ids) )
		{
			redirect($this->module['main_route']);
		}

		$result = $this->embunPagim->bulk_delete($ids);
		$this->session->set_flashdata('message', $result['message']);
		redirect($this->module['main_route']);
		
	}

}

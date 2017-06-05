<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	
	private $user = array(
		'user_id' => 1
	);

	private $module = array();

	function __construct()
	{
		parent::__construct();

		$this->load->model('usersm');

		$this->module = $this->load->config('modules')['users'];
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
		$data['title'] = 'Data User';

		$datac['title'] = 'Data User';
		$datac['sub_title'] = 'Manage Data User';

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
					$sort['column'] = 'username';
					break;
				case 3 : 
					$sort['column'] = 'active';
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

		$TotalRecords = $this->usersm->get_count()->total;

		$filtered = false;

		if($this->input->post('username') != '' )
		{
			$where['username like'] = '%'.$this->input->post('username').'%';
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
			$where['active'] = $this->input->post('status');
			$filtered = true;
		}

		$param = array(
			'where' 	=> $where,
			'order' 	=> $sort,
			'start'		=> $start,
			'length'	=> $length
		);

		$users = $this->usersm->gets($param);

		$TotalRecordsFiltered = $TotalRecords;

		if( $filtered )
		{
			$TotalRecordsFiltered = $this->usersm->get_count($where)->total;
		}

		$sEcho = intval($this->input->post('draw'));

	    $records = array();
	    $records['data'] = array();

	    if( !empty($users) )
	    {
	    	$no = $start;

	    	foreach($users as $u)
	    	{
	    		$no++;

	    		$checkbox = '<div class="uk-text-center uk-table-middle small_col"><input type="checkbox" data-md-icheck class="check_row" name="user_ids[]" value="'.$u->user_id.'"></div>';
	    		$active = ($u->active == 0) ? '<span class="uk-badge uk-badge-danger">disabled</span>' : '<span class="uk-badge uk-badge-success">active</span>';
	    		$actions = '<a href="javascript:;" class="open-modal" data-url="'.base_url('public/users/edit/'.$u->user_id).'"><i class="md-icon material-icons">&#xE254;</i></a>
	    		<a href="javascript:;" class="open-modal" data-url="'.base_url('public/users/change_password/'.$u->user_id).'"><i class="md-icon material-icons uk-text-primary">&#xE0DA;</i></a>
                            <a href="javascript:;" class="delete" data-url="'.base_url('public/users/delete/'.$u->user_id).'"><i class="md-icon material-icons uk-text-danger">&#xE14C;</i></a>';
	    		$records['data'][] = array(
	    			$checkbox,
					$no,
					$u->username,
					'<div class="uk-text-center">'.$active.'</div>',
					date('d-m-Y',strtotime($u->updated)),
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
			$this->load->library('encryption');
			$this->encryption->initialize(
		        array(
	                'cipher' => 'aes-256',
	                'mode' => 'ctr',
	                'key' => 'qwertasdfgzxcvbyuioghjkl012345op'
		        )
			);
			$password = $this->encryption->encrypt($this->input->post('password'));
			$data = array(
				'username' 		=> strtolower($this->input->post('user_name')),
				'password' 		=> $password,
				'active'		=> $this->input->post('status'),
				'updated'		=> date('Y-m-d H:i:s'),
			);

			$result = $this->usersm->add($data);
			$this->session->set_flashdata('message', $result['message']);
			redirect($this->module['main_route']);
		}

		$data['title'] = 'Tambah Data User';
		$data['action_url'] = base_url('public/users/add');
		$data['action'] = 'add';
		$data['data'] = array(
			'username'				=> '',
			'password' 				=> '',
			'confirm_password'		=> '',
			'active'				=> 1
		);
		$this->parser->parse('form_modal',$data);
	}

	public function edit($id = null) {

		if( $this->input->post('key') == 'qwerty' )
		{
			
			$data = array(
				'username' 		=> strtolower($this->input->post('user_name')),
				'active'		=> $this->input->post('status'),
				'updated'		=> date('Y-m-d H:i:s')
			);

			$result = $this->usersm->edit($data, $this->input->post('user_id'));
			$this->session->set_flashdata('message', $result['message']);
			redirect($this->module['main_route']);
		}

		if( $id == null )
		{
			redirect($this->module['main_route']);
		}

		$data['title'] = 'Edit Data User';
		$data['action_url'] = base_url('public/users/edit');
		$data['action'] = 'edit';

		$u = $this->usersm->get($id);

		if( empty($u) )
		{
			redirect($this->module['main_route']);
		}

		$data['data'] = array(
			'user_id'				=> $id,
			'username'				=> $u->username,
			'active'				=> $u->active
		);
		$this->parser->parse('form_modal',$data);
	}

	public function change_password($id = null) {

		if( $this->input->post('key') == 'qwerty' )
		{
			
			$this->load->library('encryption');
			$this->encryption->initialize(
		        array(
	                'cipher' => 'aes-256',
	                'mode' => 'ctr',
	                'key' => 'qwertasdfgzxcvbyuioghjkl012345op'
		        )
			);
			$password = $this->encryption->encrypt($this->input->post('new_password'));
			$data['password'] = $password;

			$result = $this->usersm->edit($data, $this->input->post('user_id'));
			$this->session->set_flashdata('message', $result['message']);
			redirect($this->module['main_route']);
		}

		if( $id == null )
		{
			redirect($this->module['main_route']);
		}

		$data['title'] = 'Edit Password User';
		$data['action_url'] = base_url('public/users/change_password');

		$u = $this->usersm->get($id);

		if( empty($u) )
		{
			redirect($this->module['main_route']);
		}

		$data['data'] = array(
			'user_id'				=> $id,
			'password' 				=> '',
			'new_password' 			=> '',
			'confirm_new_password'	=> ''
		);
		$this->parser->parse('form_change_password',$data);
	}

	public function check_password()
	{
		$result = array(
			'status' 	=> false,
			'message'	=> ''
		);

		if( $this->input->post('password') &&  $this->input->post('user_id') )
		{
			$u = $this->usersm->get($this->input->post('user_id'));
			$old_password = $this->input->post('password');
			$this->load->library('encryption');
			$this->encryption->initialize(
		        array(
	                'cipher' => 'aes-256',
	                'mode' => 'ctr',
	                'key' => 'qwertasdfgzxcvbyuioghjkl012345op'
		        )
			);

			if( !empty($u) )
			{
				$password = $this->encryption->decrypt($u->password);;
				if( $password == $old_password )
				{
					$result['status'] = true;
				}
			}
		}

		echo json_encode($result);
	}

	public function check_username()
	{
		$result = array(
			'status' 	=> false,
			'message'	=> ''
		);

		if( $this->input->post('username') )
		{
			if( $this->input->post('user_id') )
			{
				$where['username'] = $this->input->post('username');
				$where['user_id !='] = $this->input->post('user_id');

				$params['where'] = $where;

				$u = $this->usersm->gets($params);

				$result['status'] = true;
				
				if( !empty($u) )
				{
					$result['status'] = false;
				}
			}
			else
			{
				$u = $this->usersm->get_by_username($this->input->post('username'));
				if( empty($u) )
				{
					$result['status'] = true;
				}
			}

		}

		echo json_encode($result);
	}

	public function delete($id = null) {

		if( $id == null )
		{
			redirect($this->module['main_route']);
		}

		$result = $this->usersm->delete($id);
		$this->session->set_flashdata('message', $result['message']);
		redirect($this->module['main_route']);
		
	}

	public function bulk_delete() {

		$ids = $this->input->post('user_ids');

		if( empty($ids) )
		{
			redirect($this->module['main_route']);
		}

		$result = $this->usersm->bulk_delete($ids);
		$this->session->set_flashdata('message', $result['message']);
		redirect($this->module['main_route']);
		
	}

	public function login() {

		if( $this->session->userdata('user_id') )
		{
			$gk = $this->load->config('modules')['gk'];
			redirect(base_url($gk['route']));
		}

		$data['title'] = 'Halaman Login';

		$datac['message'] = $this->session->flashdata('message');
		$datac['action_url'] = base_url('public/users/validate');

		$this->parser->set_partial('content','form_login',$datac,true);
		$this->parser->parse('login',$data);
	}

	public function validate() {

		$message = 'error';

		if( $this->session->userdata('user_id') )
		{
			$gk = $this->load->config('modules')['gk'];
			redirect(base_url($gk['route']));
		}

		if( $this->input->post('key') == 'qwerty' )
		{
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$u = $this->usersm->get_by_username($username);

			$message = 'user tidak terdaftar';

			if( !empty($u) )
			{
				$message = 'user tidak aktif';

				if( $u->active == 1 )
				{
					$this->load->library('encryption');
					$this->encryption->initialize(
				        array(
			                'cipher' => 'aes-256',
			                'mode' => 'ctr',
			                'key' => 'qwertasdfgzxcvbyuioghjkl012345op'
				        )
					);
					$password_db = $this->encryption->decrypt($u->password);

					$message = 'password salah';
					if( $password == $password_db )
					{
						$data = array(
							'user_id'	=> $u->user_id,
							'username' 	=> $u->username
						);
						$this->session->set_userdata($data);
						$gk = $this->load->config('modules')['gk'];
						redirect(base_url($gk['route']));
					}
				}
			}

		}

		$this->session->set_flashdata('message', $message);

		redirect($this->module['main_route'].'login');
	}

	public function logout() {
		$this->session->sess_destroy();
		redirect($this->module['main_route'].'login');
	}

}

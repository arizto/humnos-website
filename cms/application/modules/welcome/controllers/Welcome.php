<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct()
	{
		parent::__construct();

		$this->parser->set_partial('header','partials/header');
		$this->parser->set_partial('navigation','partials/navigation');
		$this->parser->set_partial('footer','partials/footer');
		
	}

	public function index()
	{
		$data['title'] = 'Welcome to CodeIgniter !';

		//$data['content'] = $this->parser->parse('welcome_message','',true);

		//echo $this->parser->theme_url();

		//return false;
		$this->parser->set_partial('content','welcome_message',array(),true);

		$this->parser->parse('default',$data);
	}
}

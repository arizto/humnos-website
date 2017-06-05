<?php


class AuthenticationMiddleware
{
   

    /**
     * @var CI_Controller|object
     */
    private $ci;

    private $whitelists = array(
        'users/login',
        'users/validate'
    );


    public function __construct()
    {
        $this->ci = & get_instance();

        //var_dump($this->ci->session->userdata('role'));

    }

    public function authentify()
    {

        if( !$this->ci->session->userdata('user_id') )
        {

            if( !in_array(uri_string(), $this->whitelists ) )
            {
                redirect(base_url('public/users/login'));
            }
            
            
        }

    }

}



?>

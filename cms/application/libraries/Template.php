<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Custom Smarty Class
 *
 * Codeigniter Libraries for smarty template engine
 *
 * @package			CodeIgniter
 * @subpackage		Libraries
 * @category		Libraries
 * @author			Anonymous
 *
 */

//define('SMARTY_LIBS', APPPATH.'/thirdparty/Smarty') );

require_once APPPATH."third_party/Smarty/Smarty.class.php";

class Template extends Smarty {

	public $template_ext = '.php';

	public function __construct()
    {
        parent::__construct();
       
        $CI = get_instance();

        // Load the Smarty config file
        $CI->load->config('template');

        // Turn on/off debug
        $this->debugging = config_item('smarty_debug');

        // Set some pretty standard Smarty directories
        $this->setTemplateDir(config_item('theme_path').config_item('theme_name'));
        $this->setCompileDir(config_item('compile_directory'));
        $this->setCacheDir(config_item('cache_directory'));
        $this->setConfigDir(config_item('config_directory'));
        //$this->addPluginsDir(config_item('plugins_directory'));

        // Default template extension
        $this->template_ext = config_item('template_ext');
        $this->force_compile = 1;

        // How long to cache templates for
        $this->cache_lifetime = config_item('cache_lifetime');

        // Disable Smarty security policy
        $this->disableSecurity();

        // If caching is enabled, then disable force compile and enable cache
        if (config_item('cache_status') === true) {
            $this->enable_caching();
        } else {
            $this->disable_caching();
        }

        // Set the error reporting level
        $this->error_reporting   = config_item('template_error_reporting');
        // This will fix various issues like filemtime errors that some people experience
        // The cause of this is most likely setting the error_reporting value above
        // This is a static function in the main Smarty class
        //Smarty::muteExpectedErrors();
        // Should let us access Codeigniter stuff in views
        // This means we can go for example {$this->session->userdata('item')}
        // just like we normally would in standard CI views
        $this->assign("this", $CI);
        //My Vars
        $this->assign('APPPATH', APPPATH);
        $this->assign('BASEPATH', BASEPATH);
        $this->assign('systemurl', base_url());
        $this->assign('template', 'default');
        $this->assign("CI", $CI);
    }

    /**
     * Enable Caching
     *
     * Allows you to enable caching on a page by page basis
     * 
     * @example $this->smarty->enable_caching(); then do your parse call
     * 
     * @return void
     */
    public function enable_caching()
    {
        $this->caching = 1;
    }

    /**
     * Disable Caching
     *
     * Allows you to disable caching on a page by page basis
     * 
     * @example $this->smarty->disable_caching(); then do your parse call
     * 
     * @return void
     */
    public function disable_caching()
    {
        $this->caching = 0; 
    }

    public function test_install()
    {
    	$this->testInstall();
    }
}
// END Smarty Class
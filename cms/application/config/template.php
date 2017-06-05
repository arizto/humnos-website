<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 *
 * Config for codeigniter smarty template
 *
 * @package   Smarty
 * @author    anonymous
 * @version   1.0
 */
// Smarty caching enabled by default unless explicitly set to FALSE
$config['cache_status'] = FALSE;


// The path to the themes
// Default is implied root directory/themes/
$config['theme_path'] = APPPATH ."views/themes/";


// The default name of the theme to use (this can be overridden)
$config['theme_name'] = "default";


// Cache lifetime. Default value is 3600 seconds (1 hour) Smarty's default value
$config['cache_lifetime']       = 3600;


// Where templates are compiled
$config['compile_directory']    = APPPATH."cache/smarty/compiled/";


// Where templates are cached
$config['cache_directory']      = APPPATH."cache/smarty/cache/";


// Where Smarty configs are located
$config['config_directory']     = APPPATH."third_party/Smarty/configs/";


// Where my plugins are located
$config['plugins_directory']     = APPPATH."third_party/Smarty/plugins/";


// Default extension of templates if one isn't supplied
$config['template_ext']         = 'tpl';


// Error reporting level to use while processing templates
$config['template_error_reporting'] = E_ALL & ~E_NOTICE;


// Debug mode turned on or off (TRUE / FALSE)
$config['smarty_debug'] = FALSE;

// Application name
$config['application_name'] = "GARAM KELUARGA";


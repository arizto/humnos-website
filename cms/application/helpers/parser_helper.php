<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CI Smarty
 *
 * Smarty templating for Codeigniter
 *
 * @package   CI Smarty
 * @author    Dwayne Charrington
 * @copyright 2015 Dwayne Charrington and Github contributors
 * @link      http://ilikekillnerds.com
 * @license   MIT
 * @version   3.0
 */

/**
 * Theme URL
 *
 * A helper function for getting the current theme URL
 * in a web friendly format.
 *
 * @param string $location
 * @return mixed
 */
function theme_url($location = '')
{
    $CI =& get_instance();

    return $CI->parser->theme_url($location);
}

/**
 * CSS
 *
 * A helper function for getting the current theme CSS embed code
 * in a web friendly format
 *
 * @param $file
 * @param $attributes
 */
if ( ! function_exists('css') )
{
    function css($file, $attributes = array())
    {
        $CI =& get_instance();

        echo $CI->parser->css($file, $attributes);
    }
}

/**
 * JS
 *
 * A helper function for getting the current theme JS embed code
 * in a web friendly format
 *
 * @param $file
 * @param $attributes
 */
if ( ! function_exists('js') )
{
    function js($file, $attributes = array())
    {
        $CI =& get_instance();

        echo $CI->parser->js($file, $attributes);
    }
}

/**
 * IMG
 *
 * A helper function for getting the current theme IMG embed code
 * in a web friendly format
 *
 * @param $file
 * @param $attributes
 */
if ( ! function_exists('image') )
{
    function image($file, $attributes = array())
    {
        $CI =& get_instance();

        echo $CI->parser->img($file, $attributes);
    }
}

/**
 * Session
 *
 * A helper function for getting a session variable alias of $this->session->userdata($name)
 *
 * @param $name
 */
if ( ! function_exists('userdata') )
{
    function userdata($name)
    {
        $CI =& get_instance();

        return $CI->session->userdata($name);
    }
}

/**
 * Uri segment
 *
 * A helper function for getting a uri segment alias of $this->uri->segment(n)
 *
 * @param $segnum
 */
if ( ! function_exists('uriseg') )
{
    function uriseg($segnum)
    {
        $CI =& get_instance();

        return $CI->uri->segment($segnum);
    }
}

/**
 * Flashdata
 *
 * A helper function for getting a flash message alias of $this->session->flashdata($name)
 *
 * @param $name
 */
if ( ! function_exists('flashdata') )
{
    function flashdata($name)
    {
        $CI =& get_instance();

        return $CI->session->flashdata($name);
    }
}

/**
 * Elapsed time
 *
 * A helper function for getting codeigniter benchmark elapsed time
 * in a web friendly format.
 *
 * @param string $location
 * @return mixed
 */

function elapsed_time($location = '')
{
    $CI =& get_instance();

    return $CI->benchmark->elapsed_time();;
}

/**
 * APP NAME
 *
 * A helper function for getting application name
 *
 * @param string $location
 * @return mixed
 */

function app_name()
{
    $CI =& get_instance();

    return $CI->config->item('application_name');
}


/**
 * partial
 *
 * A helper function for getting partial
 *
 * @param string $location
 * @return mixed
 */

if ( ! function_exists('partial') )
{
    function partial($part)
    {
        $CI =& get_instance();

        return $CI->parser->get_partial($part);;
    }
}



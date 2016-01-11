<?php

/**
 * Helper to assist in debugging
 *
 * @copyright  2015 ALGROCH
 * @version    $Id$
 */
if ( !defined('BASEPATH') )
    exit('No direct script access allowed');


 if ( ! function_exists('my_set_value'))
 {
 	/**
 	 * Form Value
 	 *
 	 * Grabs a value from the POST array for the specified field so you can
 	 * re-populate an input field or textarea. If Form Validation
 	 * is active it retrieves the info from the validation class
 	 *
 	 * @param	string	$field		Field name
 	 * @param	string	$default	Default value
 	 * @param	bool	$html_escape	Whether to escape HTML special characters or not
 	 * @return	string
 	 */
 	function my_set_value($field, $default = '', $html_escape = TRUE)
 	{
 		$CI =& get_instance();

    $post = $CI->input->post($field, FALSE);
    //if( empty($post))
 		$value = $CI->input->post($field, FALSE);

 		isset($value) OR $value = $default;
 		return ($html_escape) ? html_escape($value) : $value;
 	}
 }

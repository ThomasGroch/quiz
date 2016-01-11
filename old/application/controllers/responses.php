<?php

/**
 * Base controller Class to extends in a controller class
 *
 * @copyright  2011 ALGROCH
 * @version    $Id$
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH . 'controllers/base/crud_controller.php');

class Responses extends CRUD_Controller {

    /**
     * contains the name of the controller in lowercase on plural
     * @access public
     * @var string
     */
    //public $ctrlr_name;

    function __construct() {
        parent::__construct();
    }

    public function show($page = 1) {
        parent::show($page);
    }

}

?>

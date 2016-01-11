<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
// ---------------------------------------------------------------------------

/**
 * Base_Controller
 *
 * Extends the Site_Controller class so I can declare special Admin controllers
 *
 * @copyright       2015 ALGROCH
 * @package       	CodeBase
 * @subpackage      Controllers
 */
class Base_Controller extends MY_Controller {

    /**
     * contains the name of the controller in lowercase on plural
     * @access public
     * @var string
     */
    public $ctrlr_name;

    /**
     * contains the name of the controller in uppercase
     * @access public
     * @var string
     */
    public $class_name;

    /**
     * Contains any data to pass to view
     * @access protected
     * @var array
     */
    public $data;

    /**
     * contains the DMZ object from the logged user
     * @access protected
     * @var Person
     */
    protected $logged_user;

    /**
     * contains the default layout to be used
     * @access public
     * @var string
     */
    //public $layout = 'base/sidebar_content_layout';

    function __construct() {
        parent::__construct();
        $this->data['data'] = array();

        //Set the default timezone configured in the codeigniter
        date_default_timezone_set($this->config->item('default_timezone'));

        //set default for ctrlr_name and class_name
        $class_name = get_class($this);
        $this->ctrlr_name = strtolower($class_name);
        $this->class_name = $class_name;

        //Set default for header and ctrl
        $this->data['ctrlr'] = $this->ctrlr_name;

        $class = $this->router->fetch_class();
        $action = $this->router->fetch_method();
        $this->action = $action;
        $this->data['action'] = $action;

        // $this->logged_user = $this->authentication->get_logged_user();
        // $this->data['data']['logged_user'] = $this->logged_user;

        // Set container variable
        $this->layout = $this->config->item('ci_my_admin_template_dir_admin') . "layout.php";
        //$this->_modules = $this->config->item('modules_locations');

        log_message('debug', 'CI My Admin : Admin_Controller class loaded');
    }

    function page() {
        if (!empty($this->data['content'])) {
            echo 'Use $this->view em vez de $this->data[\'content\'] em ' . $this->data['content'];
        }

        // Possibilita usar $this->view para setar a view manualmente
        if (empty($this->view)) {
            // Padrão controller_action_view.php
            $view = $this->config->item('ci_my_admin_template_dir_admin') . $this->ctrlr_name . '_' . $this->action;
            //$view = $this->ctrlr_name . '/' . $this->ctrlr_name . '_' . $this->action . '_view';
        } else {
            $view = $this->view;
        }
        // echo $view;exit;
        $this->data['content'] = $view;

        // Possibilita usar $this->layout para setar a layout manualmente
        $this->layout = (empty($this->layout)) ? 'base/content_layout' : $this->layout;

        if (isset($this->element)) {
            $this->data['data']['element'] = $this->element;
        }
        $this->data['layout'] = $this->layout;

        $this->data['data']['pagination'] = (!empty($this->data['data']['pagination'])) ? $this->data['data']['pagination'] : '';

        // if (isAjax() and !$this->force_noajax_view) {
        //     $output = $this->load->view($this->layout, $this->data, TRUE);
        //     $return_arr['content'] = $output;
        //     $this->_set_json_output($return_arr);
        // } else {
            $this->load->view($this->layout, $this->data);
        // }
    }

}

/* End of Base_controller.php */
/* Location: ./application/libraries/Base_controller.php */

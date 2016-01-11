<?php

/**
 * Crud_controller Class to extends in a Base_Controller class
 *
 * @copyright       2015 ALGROCH
 * @package       	CodeBase
 * @subpackage      Controllers
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH . 'libraries/Base_Controller.php');

abstract class CRUD_Controller extends Base_Controller {

    var $element;
    var $redirect_url = NULL;

    function __construct() {

        parent::__construct();

        $this->redirect_url = "admin/".$this->ctrlr_name;

        if (empty($this->element)) {
            $this->ctrlr_singular_name = singular($this->ctrlr_name);
            $this->load->model(array('admin/'.$this->ctrlr_singular_name));
        }
        // if ($this->authentication->is_signed_in()) {
        //     $this->_add_menu_item('edit', lang('manage'), array($this->ctrlr_name . '/edit', lang('edit_profile')));
        // }
        // $this->_add_menu_item('view', '', array($this->ctrlr_name . '/view', lang('home')));
    }

    public function index() {
        redirect($this->ctrlr_name . '/show');
    }

    function create() {
        //$this->_set_title(lang('create_' . singular($this->ctrlr_name)));
        $this->_form();
    }

    function edit($id = NULL) {
        if (empty($id)) {
            show_404();
        }
        $this->element = $this->{$this->ctrlr_singular_name}->get($id);

        // if (!$this->element->exists() ) {
        //     $this->msg_error(lang('no_permission'));
        //     redirect($this->ctrlr_name);
        // }
        // $this->_set_title(lang('edit'));
        $this->_form($id);
    }

    function _form($id = NULL) {
        $this->data['data']['fields'] = $this->{$this->ctrlr_singular_name}->getFields();
        //$this->view = (empty($this->view)) ? $this->ctrlr_name . '/' . $this->ctrlr_name . '_form_view' : $this->view;
        $this->view = (empty($this->view)) ? $this->config->item('ci_my_admin_template_dir_admin') . $this->ctrlr_name . '_form' : $this->view;

        if ($_POST || $_FILES) {
            $this->{$this->ctrlr_singular_name}->getFields();

            // Se o metodo _saveExtra existir no controller que estende o CRUD, salva o objeto por ele, caso contrario salva normalmente
            if (method_exists($this->{$this->ctrlr_singular_name}, '_saveExtra_' . $this->action)) {

                $res = $this->{$this->ctrlr_singular_name}->{'_saveExtra_' . $this->action}($id);

            } elseif (method_exists($this->{$this->ctrlr_singular_name}, '_saveExtra')) {

                $res = $this->{$this->ctrlr_singular_name}->_saveExtra($id);

            } else {
                echo 'erro';
            }

            if (!$res) {
                $errors = '';
                // foreach ($this->element->error->all as $k => $err)
                // {
                //     $errors .= $err;
                // }
                // $this->msg_error($errors);
            } else {
                // $this->msg_ok((empty($this->element->_msg) ? lang('save_success') : $this->element->_msg));
                if ( !isAjax() ) {
                    $redirect = ($this->redirect_url) ? $this->redirect_url : $this->ctrlr_name;
                    redirect($redirect);
                }
            }
        }
        parent::page();
    }

    function show($page = 1) {
        $this->element->get_paged($page, $this->config->item('max_num_items_on_page'));
        $this->layout = (empty($this->layout)) ? 'base/content_layout' : $this->layout;

        // $this->load->library('pagination');

        // $confpage['use_page_numbers'] = TRUE;
        // $confpage['total_rows'] = $this->element->paged->total_rows;
        // $confpage['per_page'] = $this->element->paged->page_size;
        // $confpage['base_url'] = site_url($this->ctrlr_name . '/' . $this->action . ((isset($this->viewing_id)) ? '/' . $this->viewing_id : ''));
        // $confpage['uri_segment'] = 4;

        // $this->pagination->initialize($confpage);

        $this->data['data']['pagination'] = $this->pagination->create_links();
        parent::page();
    }

    function view($id = NULL) {
        $this->element->get_by_id($id);

        if (!$this->element->exists() || !$this->element->can_view()) {
            $this->msg_error(lang('no_permission'));
            redirect($this->ctrlr_name);
        }

        $this->_set_title($this->element->__toString());
        $this->_add_menu('left', 'view', $id);
        parent::page();
    }

    function delete($id = NULL) {
        if (empty($id)) {
            show_404();
        }
        $this->{$this->ctrlr_singular_name}->delete($id);
        $redirect = ($this->redirect_url) ? $this->redirect_url : $this->ctrlr_name;
        if ( ! isAjax() ) {
          redirect($redirect);
        }
    }

}

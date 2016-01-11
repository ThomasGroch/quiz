<?php

class Admin extends Base_Controller {

    function __construct() {
        parent::__construct();

        $this->load->library(array('ion_auth'));

        if (!$this->ion_auth->logged_in()) {
            redirect('/auth', 'refresh');
        }
        $this->load->model(array('admin/quiz_session'));
        $this->load->model(array('admin/question'));
    }

    public function index() {
        $this->data['respostas'] = $this->quiz_session->get_all();
        $this->data['questions'] = $this->question->get_all();

        $this->view = $this->config->item('ci_my_admin_template_dir_admin') . "dashboard";
        parent::page();
    }

}

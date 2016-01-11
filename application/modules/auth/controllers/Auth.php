<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->helper(array('url', 'language'));

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->load->library(array('ion_auth','form_validation'));
    		$this->load->helper(array('url','language'));

    		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

    		$this->lang->load('auth');
        log_message('debug', 'CI My Admin : Auth class loaded');
    }

    public function index() {
        if ($this->ion_auth->logged_in()) {
            redirect('admin/dashboard', 'refresh');
        } else {
            $data['page'] = $this->config->item('ci_my_admin_template_dir_public') . "login_form";
            $data['module'] = 'auth';

            $this->load->view($this->_container, $data);
        }
    }

    public function login() {
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == true) {
            $remember = (bool) $this->input->post('remember');

            if ($this->ion_auth->login($this->input->post('email'), $this->input->post('password'), $remember)) {
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect('/admin/dashboard', 'refresh');
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('auth', 'refresh');
            }
        } else {
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $data['page'] = $this->config->item('ci_my_admin_template_dir_public') . "login_form";
            $data['module'] = 'auth';
            //$data['message'] = $this->data['message'];

            $this->load->view($this->_container, $data);
        }
    }

    public function logout() {
        $this->ion_auth->logout();

        redirect('auth', 'refresh');
    }

    // change password
  	function change_password()
  	{
  		$this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
  		$this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
  		$this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

  		if (!$this->ion_auth->logged_in())
  		{
  			redirect('auth/login', 'refresh');
  		}

  		$user = $this->ion_auth->user()->row();

  		if ($this->form_validation->run() == false)
  		{
  			// display the form
  			// set the flash data error message if there is one
  			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

  			$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
  			$this->data['old_password'] = array(
  				'name' => 'old',
  				'id'   => 'old',
  				'type' => 'password',
  			);
  			$this->data['new_password'] = array(
  				'name'    => 'new',
  				'id'      => 'new',
  				'type'    => 'password',
  				'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
  			);
  			$this->data['new_password_confirm'] = array(
  				'name'    => 'new_confirm',
  				'id'      => 'new_confirm',
  				'type'    => 'password',
  				'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
  			);
  			$this->data['user_id'] = array(
  				'name'  => 'user_id',
  				'id'    => 'user_id',
  				'type'  => 'hidden',
  				'value' => $user->id,
  			);

  			// render
  			//$this->_render_page($this->config->item('ci_my_admin_template_dir_public') . 'change_password', $this->data);
        $data['page'] = $this->config->item('ci_my_admin_template_dir_public') . "change_password";
        $this->_container = $this->config->item('ci_my_admin_template_dir_admin').'layout';
        $data['module'] = 'auth';
        $this->data['message'] = $this->data['message'];

        $this->data['content'] = $data['page'];
        $this->data['data'] = $this->data;
        $this->load->view($this->_container, $this->data);
  		}
  		else
  		{
  			$identity = $this->session->userdata('identity');

  			$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

  			if ($change)
  			{
  				//if the password was successfully changed
  				$this->session->set_flashdata('message', $this->ion_auth->messages());
  				$this->logout();
  			}
  			else
  			{
  				$this->session->set_flashdata('message', $this->ion_auth->errors());
  				redirect('auth/change_password', 'refresh');
  			}
  		}
  	}
    function _render_page($view, $data=null, $returnhtml=false)//I think this makes more sense
  	{

  		$this->viewdata = (empty($data)) ? $this->data: $data;

  		$view_html = $this->load->view($view, $this->viewdata, $returnhtml);

  		if ($returnhtml) return $view_html;//This will return html on 3rd argument being true
  	}

}

/* End of file auth.php */
/* Location: ./modules/auth/controllers/auth.php */

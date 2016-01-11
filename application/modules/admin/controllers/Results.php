<?php

class Results extends Base_Controller {

    function __construct() {
        parent::__construct();

        $this->load->library(array('ion_auth'));

        if (!$this->ion_auth->logged_in()) {
            redirect('/auth', 'refresh');
        }
        $this->load->model(array('admin/response'));
        $this->load->model(array('admin/question'));
        $this->load->model(array('admin/choice'));
				$this->load->model(array('admin/quiz_session'));
        $this->load->library('table');
    }

    public function index() {

      $sessions = $this->quiz_session->get_all();

      $header = array();
      $header[] = 'Sessão';
      $header_cache = array();
      foreach ($sessions as $session) {

        $responses = $this->response->get_all('', array('quiz_session_id' => $session['id']) );
        $row = array();
        $row[] = $session['id'];
        foreach ($responses as $response) {

          // Set table header
          if( ! in_array($response['question_id'], $header_cache) ){
            $question = $this->question->get($response['question_id']);
            $header[] = $question->label;
            $header_cache[] = $response['question_id'];
          }

          if( ! empty($response['answer'])) {

            // Dicertive
            $row[] = $response['answer'];

          }elseif( $response['choice_id'] != NULL){

            // Multichoice
            $choice = $this->choice->get($response['choice_id']);
            $row[] = $choice->label;

          }

        }
        $row[] = brazilian_datetime($session['date_created']);
        $this->table->add_row($row);

      }
      $header[] = 'Data';

      $this->table->set_heading($header);

      $tmpl = array (
                          'table_open'          => '<table class="table table-striped table-bordered table-hover" id="dataTables-example">',
                          //
                          // 'heading_row_start'   => '<tr>',
                          // 'heading_row_end'     => '</tr>',
                          // 'heading_cell_start'  => '<th>',
                          // 'heading_cell_end'    => '</th>',
                          //
                          // 'row_start'           => '<tr>',
                          // 'row_end'             => '</tr>',
                          // 'cell_start'          => '<td>',
                          // 'cell_end'            => '</td>',
                          //
                          // 'row_alt_start'       => '<tr>',
                          // 'row_alt_end'         => '</tr>',
                          // 'cell_alt_start'      => '<td>',
                          // 'cell_alt_end'        => '</td>',
                          //
                          // 'table_close'         => '</table>'
                    );

      $this->table->set_template($tmpl);
      $table = $this->table->generate();

      $this->data['data']['sessions'] = $sessions;

      $this->data['data']['table'] = $table;
      $this->view = $this->config->item('ci_my_admin_template_dir_admin') . "results_index";
      parent::page();
    }

}

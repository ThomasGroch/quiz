<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Quiz extends Base_Controller {

    function __construct() {
        parent::__construct();
				$this->load->model(array('admin/question'));
				$this->load->model(array('admin/choice'));
				$this->load->model(array('admin/response'));
				$this->load->model(array('admin/quiz_session'));
    }

		public function index() {

			if( $this->input->post() ) {

				$data['optional'] = $this->input->post('optional');
				$quiz_session_id = $this->quiz_session->insert($data);

				foreach ( $this->input->post('answers') as $question_id => $answer ) {
					unset($data);

					$data['quiz_session_id'] = $quiz_session_id;
					$data['question_id'] = $question_id;

					if( isset( $answer['answer'] )  ) {

						// Dicertive
						$data['answer'] = $answer['answer'];
						$this->response->insert($data);

					}else{

						// Multichoice
						$data['choice_id'] = $answer['choice'];
						$this->response->insert($data);

					}

				}

				exit;
			}

			$questions = $this->question->get_all();

			foreach( $questions as $key => $q ){
				$questions[$key]['choices'] = $this->choice->get_all('', array('question_id' => $q['id']) );
				//$questions[$key]['type'] = $this->config->item('questions_type')[$q['type']];
			}

			$this->data['questions'] = $questions;
        $this->layout = $this->config->item('ci_my_admin_template_dir_quiz') . "includes/layout";
        $this->view = $this->config->item('ci_my_admin_template_dir_quiz') . "quiz_index";
        parent::page();
    }

}

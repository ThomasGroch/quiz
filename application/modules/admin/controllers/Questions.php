<?php

class Questions extends CRUD_Controller {

    function __construct() {
        parent::__construct();

        $this->load->library(array('ion_auth'));

        if (!$this->ion_auth->logged_in()) {
            redirect('/auth', 'refresh');
        }

        //$this->load->model(array('admin/question'));
        $this->load->model(array('admin/choice'));
    }

    public function index() {
        $questions = $this->question->get_all('', array(), '', '', 'order_field asc');

        foreach( $questions as $key => $q ){
          $questions[$key]['type'] = $this->config->item('questions_type')[$q['type']];
        }

        $this->data['questions'] = $questions;
        //$this->data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "questions_list";
        //$this->load->view($this->_container, $data);
        parent::page();
    }
    //
    public function create() {
      $this->element = new stdClass();
      $this->element->label = $this->input->post('label');
      $this->element->type = $this->input->post('type');

      // repopulate fields
      $choice = array();
      if( $this->input->post('choice') ) {

        // foreach ( $this->input->post('choice') as $choice_id => $choice ){
        //   if ( empty(trim($choice)) ){
        //     continue;
        //   }
        //   var_dump($choice_id);
        //   $choice[$choice_id]['id'] = $choice_id;
        //   $choice[$choice_id]['label'] = $choice;
        // }

      }else{
        $choice[0]['id'] = time();
        $choice[0]['label'] = '';
      }
      $this->data['choice'] = $choice;
    //         if( $this->input->post('type') == 0 ){
    //           // Multipla Escolha
    //           foreach ( $this->input->post('choice') as $choice ){
    //             $data_choice['label'] = $choice;
    //             $data_choice['question_id'] = $question_id;
    //             $this->choice->insert($data_choice);
    //           }
    //         }
    //
    //         redirect('/admin/questions', 'refresh');
    //     }
    //
    //     //$this->data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "questions_create";
    //     //$this->load->view($this->_container, $data);
         parent::create();
    }

    public function edit( $id = NULL ) {
        // if ($this->input->post('name')) {
        //     $this->data['label'] = $this->input->post('label');
        //     $this->data['type'] = $this->input->post('type');
        //     $this->question->update($data, $id);
        //
        //     redirect('/admin/questions', 'refresh');
        // }
        //
        // $question = $this->question->get($id);
        $choice = $this->choice->get_all( '', array( 'question_id' => $id) );
        if (count($choice) == 0 ) {
          $choice[0]['id'] = 0;
          $choice[0]['label'] = '';
        }

        //$choice = $this->choice->get_from_question( $id );
        //
        // $this->data['question'] = $question;
        $this->data['data']['choice'] = $choice;
        parent::edit($id);
        // $this->data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "questions_create";
        // //$this->load->view($this->_container, $data);
        // parent::page();
    }
    //
    // public function delete($id) {
    //     $this->product->delete($id);
    //
    //     redirect('/admin/questions', 'refresh');
    // }

    public function sort()
    {
      $direction = $this->input->post('direction'); // back, forward
      $from = $this->input->post('fromPosition'); // 3
      // $this->input->post('group');
      $id = $this->input->post('id'); // 2
      $to = $this->input->post('toPosition'); // 2

      if( $direction == 'forward' ) {

        // If forward:
        $sql = "UPDATE questions SET order_field = (`order_field` - 1) WHERE order_field > ? AND order_field <= ?";
        $this->db->query($sql, array($from, $to) );

      }elseif( $direction = 'back') {

        // If back:
        $sql = "UPDATE questions SET order_field = (`order_field` + 1) WHERE order_field <= ? AND order_field >= ?";
        $this->db->query($sql, array($from, $to) );

      }

      // and the row we move:
      $sql = "UPDATE questions SET order_field = ? WHERE id = ?";
      $this->db->query($sql, array($to, $id) );

    }

}

<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Question extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    public function _saveExtra($question_id = NULL)
    {
      $data['label'] = $this->input->post('label');
      $data['type'] = $this->input->post('type');
      $question_id = $this->question->save($data, $question_id);

      if( $this->input->post('type') == 0 ){
        // Multipla Escolha

        $choices = $this->input->post('choice');
        foreach ( $choices as $choice_id => $choice ){
          if ( empty(trim($choice)) ){
            continue;
          }
          $data_choice['label'] = $choice;
          $data_choice['question_id'] = $question_id;
          $this->choice->save($data_choice, $choice_id);
        }
        
      }

      return true;
    }
}

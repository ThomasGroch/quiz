<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Choice extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_from_question($question_id) {
        return $this->db->get_where($this->table_name, array('question_id' => $question_id))->row();
    }
}

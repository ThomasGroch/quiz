<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Model extends CI_Model {

    protected $table_name = '';
    protected $primary_key = 'id';
    protected $removed_fields = array();

    public function __construct() {
        parent::__construct();

        $this->load->database();

        $this->load->helper('inflector');

        if (!$this->table_name) {
            $this->table_name = strtolower(plural(get_class($this)));
        }
    }

    public function init()
    {
      return $this;
    }

    public function get($id) {
        return $this->db->get_where($this->table_name, array($this->primary_key => $id))->row();
    }

    public function get_all($fields = '', $where = array(), $table = '', $limit = '', $order_by = '', $group_by = '') {
        $data = array();
        if ($fields != '') {
            $this->db->select($fields);
        }

        if (count($where)) {
            $this->db->where($where);
        }

        if ($table != '') {
            $this->table_name = $table;
        }

        if ($limit != '') {
            $this->db->limit($limit);
        }

        if ($order_by != '') {
            $this->db->order_by($order_by);
        }

        if ($group_by != '') {
            $this->db->group_by($group_by);
        }

        $Q = $this->db->get($this->table_name);

        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        
        return $data;
    }

    public function save($data, $id = NULL){
      // check if it exists on db
      if( $this->get($id) ){
        // if it does, update it
        $this->update($data, $id );
        return $id;
      }

      return $this->insert($data);
    }

    public function insert($data) {
        if ($this->db->field_exists('date_created', $this->table_name) ){
          $data['date_created'] = date('Y-m-d H:i:s');
        }
        if ($this->db->field_exists('date_updated', $this->table_name)){
          $data['date_updated'] = date('Y-m-d H:i:s');
        }
        if ($this->db->field_exists('created_from_ip', $this->table_name) ){
          $data['created_from_ip'] = $this->input->ip_address();
        }

        if ($this->db->field_exists('updated_from_ip', $this->table_name) ){
          $data['updated_from_ip'] = $this->input->ip_address();
        }

        $success = $this->db->insert($this->table_name, $data);
        if ($success) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }
    }

    public function update($data, $id) {
        if ($this->db->field_exists('date_updated', $this->table_name) ){
          $data['date_updated'] = date('Y-m-d H:i:s');
        }
        if ($this->db->field_exists('updated_from_ip', $this->table_name) ){
          $data['updated_from_ip'] = $this->input->ip_address();
        }

        $this->db->where($this->primary_key, $id);
        $success = $this->db->update($this->table_name, $data);
        if ($success) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }
    }

    public function delete($id) {
        $this->db->where($this->primary_key, $id);

        return $this->db->delete($this->table_name);
    }

    function getFields() {
        $fields = $this->db->list_fields($this->table_name);

        // Remove some fields
        $this->removed_fields[] = 'create_time';
        $this->removed_fields[] = 'update_time';
        $this->removed_fields[] = 'status';
        $this->removed_fields[] = 'date_updated';
        $this->removed_fields[] = 'date_created';
        $this->removed_fields[] = 'updated_from_ip';
        $this->removed_fields[] = 'created_from_ip';

        foreach ($fields as $k => $v) {
            //FIX: trocar create_time para $this->create_field do $conf do datamapper
            if ($v == 'id' || substr($v, -3) == '_id' || in_array($v, $this->removed_fields)) {
                unset($fields[$k]);
            }
        }

        $this->filtered_fields = $fields;

        return $this->filtered_fields;
    }

}

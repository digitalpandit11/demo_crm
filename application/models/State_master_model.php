<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class State_master_model extends CI_Model{ 
    function __construct() { 
        // Set table name 
    } 

    public function save_info_model($data){
        $this->db->insert('state_master',$data);
    }

    public function display_state_data_records()
    {
        $this->db->select('*');
        $this->db->from('state_master');
        $query = $this->db->get();
        return $query;
    }

    public function display_records_by_id($entity_id)
     {
        $this->db->select('*');
        $this->db->from('state_master');
        $this->db->where('entity_id', $entity_id);
        $query = $this->db->get();
        $data = $query->row_array();
        return $data;
    }
    
    public function update_state_master_model($update_data)
    {
        $this->db->where('entity_id', $update_data['entity_id']);
        $this->db->update('state_master', $update_data); 
    }

    public function view_display_records_by_id($entity_id)
    {


        $this->db->select('*');
        $this->db->from('state_master');
        $this->db->where('entity_id', $entity_id);
        $query = $this->db->get();
        $data = $query->row_array();
        return $data;
    }


    public function deleterecords($entity_id)
    {
      $this->db->where('entity_id', $entity_id);
      $this->db->delete('state_master');
    }

     
}

    

<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class Unit_master_model extends CI_Model{ 
    function __construct() { 
        // Set table name 
    } 

    public function save_info_model($data){
        $this->db->insert('unit_master',$data);
    }

    public function display_unit_data_records()
    {
        $this->db->select('*');
        $this->db->from('unit_master');
        $query = $this->db->get();
        return $query;
    }

    public function display_records_by_id($entity_id)
     {
        $this->db->select('*');
        $this->db->from('unit_master');
        $this->db->where('entity_id', $entity_id);
        $query = $this->db->get();
        $data = $query->row_array();
        return $data;
    }

    public function update_unit_master_model($update_data)
    {
        $this->db->where('entity_id', $update_data['entity_id']);
        $this->db->update('unit_master', $update_data); 
    }


    public function view_display_records_by_id($entity_id)
    {


        $this->db->select('*');
        $this->db->from('unit_master');
        $this->db->where('entity_id', $entity_id);
        $query = $this->db->get();
        $data = $query->row_array();
        return $data;
    }

    
     
}

    

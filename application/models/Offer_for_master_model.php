<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class Offer_for_master_model extends CI_Model{ 
    function __construct() { 
        // Set table name 
    } 

    public function save_info_model($data){
        $this->db->insert('offer_for_master',$data);
    }

    public function display_offer_for_data_records()
    {
        $this->db->select('*');
        $this->db->from('offer_for_master');
        $query = $this->db->get();
        return $query;
    }

    public function display_records_by_id($entity_id)
     {
        $this->db->select('*');
        $this->db->from('offer_for_master');
        $this->db->where('entity_id', $entity_id);
        $query = $this->db->get();
        $data = $query->row_array();
        return $data;
    }
    
    public function update_offer_for_master_model($update_data)
    {
        $this->db->where('entity_id', $update_data['entity_id']);
        $this->db->update('offer_for_master', $update_data); 
    }

    public function view_display_records_by_id($entity_id)
    {


        $this->db->select('*');
        $this->db->from('offer_for_master');
        $this->db->where('entity_id', $entity_id);
        $query = $this->db->get();
        $data = $query->row_array();
        return $data;
    }


    public function deleterecords($entity_id)
    {
      $this->db->where('entity_id', $entity_id);
      $this->db->delete('offer_for_master');
    }

     
}

    

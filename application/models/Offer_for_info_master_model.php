<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class Offer_for_info_master_model extends CI_Model{ 
    function __construct() { 
        // Set table name 
    } 

    public function save_info_model($data){
        $this->db->insert('offer_for_info',$data);
    }

     public function display_offer_for_info_data_records()
    {
       /* $this->db->select('*');
        $this->db->from('offer_for_info');
        $query = $this->db->get();
        return $query;*/

        $this->db->select('offer_for_info.*,
                          offer_for_master.offer_for');
        $this->db->from('offer_for_info');
        $this->db->join('offer_for_master', 'offer_for_info.offer_for_id= offer_for_master.entity_id', 'INNER');
        $query = $this->db->get();
        return $query;
    
    }

    public function get_offer_for_id_edit_model($hidden_offer_for_id)
    {
        $query = $this->db->get_where('offer_for_master', array('entity_id' => $hidden_offer_for_id));
        return $query;
    }

     public function get_offer_for_list()
    {
        $this->db->select('*');
        $this->db->from('offer_for_master');
        $this->db->order_by('entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

     public function display_records_by_id($entity_id)
     {
        $this->db->select('*');
        $this->db->from('offer_for_info');
        $this->db->where('entity_id', $entity_id);
        $query = $this->db->get();
        $data = $query->row_array();
        return $data;
    }
    
    public function update_offer_for_info_master_model($update_data)
    {
        $this->db->where('entity_id', $update_data['entity_id']);
        $this->db->update('offer_for_info', $update_data); 
    }

    public function view_display_records_by_id($entity_id)
     {


        $this->db->select('*');
        $this->db->from('offer_for_info');
        $this->db->where('entity_id', $entity_id);
        $query = $this->db->get();
        $data = $query->row_array();
        return $data;
    }


    public function deleterecords($entity_id)
    {
      $this->db->where('entity_id', $entity_id);
      $this->db->delete('offer_for_info');
    }

     
}

    

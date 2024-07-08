<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class Principle_engg_master_model extends CI_Model{ 
    function __construct() { 
        // Set table name 
    } 

    public function save_info_model($data){
        $this->db->insert('principle_engg_master',$data);
    }

     public function display_principle_engg_data_records()
    {
       /* $this->db->select('*');
        $this->db->from('principle_engg_master');
        $query = $this->db->get();
        return $query;*/

        $this->db->select('principle_engg_master.*,
                          product_make_master.make_name');
        $this->db->from('principle_engg_master');
        $this->db->join('product_make_master', 'principle_engg_master.product_make_id= product_make_master.entity_id', 'INNER');
        $query = $this->db->get();
        return $query;
    
    }

    public function get_product_make_id_edit_model($hidden_product_make_id)
    {
        $query = $this->db->get_where('product_make_master', array('entity_id' => $hidden_product_make_id));
        return $query;
    }

     public function get_product_make_list()
    {
        $this->db->select('*');
        $this->db->from('product_make_master');
        $this->db->order_by('entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

     public function display_records_by_id($entity_id)
     {
        $this->db->select('*');
        $this->db->from('principle_engg_master');
        $this->db->where('entity_id', $entity_id);
        $query = $this->db->get();
        $data = $query->row_array();
        return $data;
    }
    
    public function update_principle_engg_master_model($update_data)
    {
        $this->db->where('entity_id', $update_data['entity_id']);
        $this->db->update('principle_engg_master', $update_data); 
    }

    public function view_display_records_by_id($entity_id)
     {


        $this->db->select('*');
        $this->db->from('principle_engg_master');
        $this->db->where('entity_id', $entity_id);
        $query = $this->db->get();
        $data = $query->row_array();
        return $data;
    }


    public function deleterecords($entity_id)
    {
      $this->db->where('entity_id', $entity_id);
      $this->db->delete('principle_engg_master');
    }

     
}

    

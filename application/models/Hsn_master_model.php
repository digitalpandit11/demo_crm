<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class Hsn_master_model extends CI_Model{ 
    function __construct() { 
        // Set table name 
    } 

    public function save_info_model($data)
    {
        $this->db->insert('product_hsn_master',$data);
    }

    public function display_hsn_data_records()
    {
        $this->db->select('*');
        $this->db->from('product_hsn_master');
        $query = $this->db->get();
        return $query;
    }

    public function display_records_by_id($entity_id)
     {
        $this->db->select('*');
        $this->db->from('product_hsn_master');
        $this->db->where('entity_id', $entity_id);
        $query = $this->db->get();
        $data = $query->row_array();
        return $data;
    }
    
    public function update_hsn_master_model($update_data)
    {
        $this->db->where('entity_id', $update_data['entity_id']);
        $this->db->update('product_hsn_master', $update_data); 
    }


 
  public function view_display_records_by_id($entity_id)
     {


        $this->db->select('*');
        $this->db->from('product_hsn_master');
        $this->db->where('entity_id', $entity_id);
        $query = $this->db->get();
        $data = $query->row_array();
        return $data;
    }


    public function deleterecords($entity_id)
    {
      $this->db->where('entity_id', $entity_id);
      $this->db->delete('product_hsn_master');
    }

    public function check_customer_name_model($hsn_code)
    {
        $this->db->select('*');
        $this->db->from('product_hsn_master');
        $where = '(product_hsn_master.hsn_code = "'.$hsn_code.'" )';
        $this->db->where($where);
        $query = $this->db->get();
        $query_result = $query->num_rows();
        if($query_result == 0)
        {
            return true;
        }else
        {
            return false;
        }   
    }
    
}

    

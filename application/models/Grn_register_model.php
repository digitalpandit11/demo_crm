<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Grn_register_model extends CI_Model{

    public function get_all_grn_details()
    {
        $this->db->select('*');
        $this->db->from('grn_register');
        $this->db->order_by('entity_id', 'DESC');
        $grn_register_master = $this->db->get();
        $query_result = $grn_register_master->result();
        return $query_result;
    }

    public function get_all_vender_details()
    {
        $this->db->select('*');
        $this->db->from('vendor_master');
        $this->db->order_by('entity_id', 'DESC');
        $vendor_master = $this->db->get();
        $vendor_master_result = $vendor_master->result();
        return $vendor_master_result;
    }

    public function insert($data = array()){ 
        $insert = $this->db->insert_batch('grn_attachment',$data); 
        return $insert?true:false; 
    } 

    public function get_details_by_id_model($entity_id)
    {
        $this->db->select('*');
        $this->db->from('grn_register');
        $where = '(grn_register.entity_id = "'.$entity_id.'" )';
        $this->db->where($where);
        $query = $this->db->get();
        return $query;
    }

    public function get_state_list()
    {
        $this->db->select('entity_id , state_name , CONCAT(state_name,'.'" - "'.', state_code) AS State_name');
        $this->db->from('state_master');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_customer_list()
    {
        $this->db->select('*');
        $this->db->from('customer_master');
        $this->db->order_by('entity_id', 'DESC');
        $customer_master = $this->db->get();
        $customer_master_result = $customer_master->result();
        return $customer_master_result;
    }
}
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Pre_dispatch_register_model extends CI_Model{

    public function get_pre_dispatch_details()
    {
        $this->db->select('predispatch_master.*,
            customer_master.customer_name,
            customer_contact_master.contact_person,customer_contact_master.email_id,
            customer_contact_master.first_contact_no');
        $this->db->from('predispatch_master');
        /*$where = '(ticket_master.ticket_type = "'.'1'.'")';
        $this->db->where($where);*/
        $this->db->join('customer_master', 'predispatch_master.customer_id = customer_master.entity_id', 'INNER');
        $this->db->join('customer_contact_master', 'customer_master.entity_id = customer_contact_master.customer_id', 'INNER');
        $this->db->order_by('predispatch_master.entity_id', 'DESC');
        $this->db->group_by('predispatch_master.entity_id');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_state_list()
    {
        $this->db->select('*');
        $this->db->from('state_master');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_customer_list()
    {
        $this->db->select('customer_master.*,
                           city_master.city_name');
        $this->db->from('customer_master');
        $this->db->join('customer_contact_master', 'customer_contact_master.customer_id = customer_master.entity_id', 'INNER');
        $this->db->join('city_master', 'customer_master.city_id = city_master.entity_id', 'INNER');
        // $where = '(customer_address_master.address_type = 1)';
        // $this->db->where($where);
        $this->db->order_by('customer_master.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function insert($data = array()){ 
        $insert = $this->db->insert_batch('predispatch_attachment',$data); 
        return $insert?true:false; 
    } 

    public function get_details_by_id_model($entity_id)
    {
        $this->db->select('*');
        $this->db->from('predispatch_master');
        $where = '(predispatch_master.entity_id = "'.$entity_id.'" )';
        $this->db->where($where);
        $query = $this->db->get();
        return $query;
    }
}
?>
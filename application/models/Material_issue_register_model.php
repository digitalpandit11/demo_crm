<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Material_issue_register_model extends CI_Model{

    public function get_all_mi_details()
    {
        $this->db->select('material_issue_master.*,
        	customer_master.customer_name');
        $this->db->from('material_issue_master');
        $this->db->join('customer_master', 'material_issue_master.customer_id = customer_master.entity_id', 'INNER');
        $this->db->order_by('entity_id', 'DESC');
        $grn_register_master = $this->db->get();
        $query_result = $grn_register_master->result();
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

    public function get_grn_list()
    {
        $this->db->select('*');
        $this->db->from('grn_register');
        $this->db->order_by('entity_id', 'DESC');
        $grn_register = $this->db->get();
        $grn_register_result = $grn_register->result();
        return $grn_register_result;
    }

    public function get_details_by_id_model($entity_id)
    {
        $this->db->select('*');
        $this->db->from('material_issue_master');
        $where = '(material_issue_master.entity_id = "'.$entity_id.'" )';
        $this->db->where($where);
        $query = $this->db->get();
        return $query;
    }
}
?>
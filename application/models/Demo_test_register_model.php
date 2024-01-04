<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Demo_test_register_model extends CI_Model{

    public function save_demo_test_model($data)
    {
        $result = $this->db->insert('demo_test_master',$data);
        $lastid = $this->db->insert_id();

        return $result;
    }

    public function get_demo_test_details()
    {
        $this->db->select('demo_test_master.*,
            product_category_master.category_name');
        $this->db->from('demo_test_master');
        $this->db->join('product_category_master', 'demo_test_master.category_id = product_category_master.entity_id', 'INNER');
        $this->db->order_by('demo_test_master.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_product_category()
    {
        $this->db->select('*');
        $this->db->from('product_category_master');
        $this->db->order_by('product_category_master.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function insert($data = array()){ 
        $insert = $this->db->insert_batch('demotest_attachment',$data); 
        return $insert?true:false; 
    } 

    public function get_details_by_id_model($entity_id)
    {
        $this->db->select('*');
        $this->db->from('demo_test_master');
        $where = '(demo_test_master.entity_id = "'.$entity_id.'" )';
        $this->db->where($where);
        $query = $this->db->get();
        return $query;
    }
}
?>
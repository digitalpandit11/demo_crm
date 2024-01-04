<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Product_category_master_model extends CI_Model{

    public function save_product_category_master_model($data)
    {
        $result = $this->db->insert('product_category_master',$data);
        return $result;
    }

    public function get_product_category()
    {
        $this->db->select('*');
        $this->db->from('product_category_master');
        $this->db->order_by('entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_id_wise_product_category($entity_id)
    {
        $query = $this->db->get_where('product_category_master', array('entity_id' =>  $entity_id));
        return $query;
    }

    public function update_product_category_master_model($data)
    {
        $this->db->where('entity_id', $data['entity_id']);
        return $this->db->update('product_category_master', $data);
    }

    public function delete_product_category($entity_id)
    {
        $this->db->where('entity_id', $entity_id);
        $data = $this->db->delete('product_category_master');
        return $data;
    }   
}
?>
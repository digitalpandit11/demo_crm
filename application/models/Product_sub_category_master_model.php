<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Product_sub_category_master_model extends CI_Model{

    public function save_product_sub_category_master_model($data)
    {
        $result = $this->db->insert('product_subcategory_master',$data);
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

    public function get_product_sub_category_details()
    {
        $this->db->select('product_category_master.category_name,product_category_master.category_initial,product_subcategory_master.*');
        $this->db->from('product_subcategory_master');
         $this->db->join('product_category_master', 'product_subcategory_master.category_id = product_category_master.entity_id', 'INNER');
        $this->db->order_by('product_subcategory_master.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_id_wise_product_sub_category($entity_id)
    {
        $query = $this->db->get_where('product_subcategory_master', array('entity_id' =>  $entity_id));
        return $query;
    }

    public function update_product_sub_category_master_model($data)
    {
        $this->db->where('entity_id', $data['entity_id']);
        return $this->db->update('product_subcategory_master', $data);
    }

    public function delete_product_sub_category($entity_id)
    {
        $this->db->where('entity_id', $entity_id);
        $data = $this->db->delete('product_subcategory_master');
        return $data;
    }   
}
?>
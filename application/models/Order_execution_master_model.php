<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Order_execution_master_model extends CI_Model{

    public function get_approved_sales_order()
    {
        $this->db->select('sales_order_register.*,
            customer_master.customer_name');
        $this->db->from('sales_order_register');
        $where = '(sales_order_register.order_execution_status = "'.'1'.'" And sales_order_register.allocation_status = "'.'1'.'")';
        $this->db->where($where);
        $this->db->join('customer_master', 'sales_order_register.customer_id = customer_master.entity_id', 'INNER');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_customer_list()
    {
        $this->db->select('*');
        $this->db->from('customer_master');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_employee_list()
    {
        $this->db->select('entity_id,
            CONCAT(employee_id,'.'" - "'.', emp_first_name) AS Emp_name');
        $this->db->from('employee_master');
        $this->db->order_by('entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_payment_term_list()
    {
        $this->db->select('*');
        $this->db->from('payment_terms_master');
        $where = '(payment_terms_master.payment_type = "'.'1'.'")';
        $this->db->where($where);
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_order_product_list_by_id($entity_id)
    {
        $this->db->select('order_execution_product_relation.*,
            product_master.product_name,
            product_master.product_id');
        $this->db->from('order_execution_product_relation');
        $this->db->join('product_master', 'order_execution_product_relation.product_id = product_master.entity_id', 'INNER');
        $where = '(order_execution_product_relation.sales_order_id = "'.$entity_id.'" And order_execution_product_relation.status = "'.'1'.'")';
        $this->db->where($where);
        $query = $this->db->get();
        $query_data_result = $query->result();
        return $query_data_result;  
    }

    public function update_order_execution_relation($update_array)
    {
        $this->db->where('entity_id', $update_array['entity_id']);
        return $this->db->update('order_execution_product_relation', $update_array);
    }

    public function get_approved_sales_order_data()
    {
        $this->db->select('sales_order_register.*,
            customer_master.customer_name');
        $this->db->from('sales_order_register');
        $where = '(sales_order_register.order_execution_status = "'.'1'.'" And sales_order_register.allocation_status = "'.'2'.'")';
        $this->db->where($where);
        $this->db->join('customer_master', 'sales_order_register.customer_id = customer_master.entity_id', 'INNER');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }
    
    public function get_order_details_by_id_model($entity_id)
    {
        $this->db->select('sales_order_register.*');
        $this->db->from('sales_order_register');
        
        $where = '(sales_order_register.entity_id = "'.$entity_id.'" )';
        $this->db->where($where);
        $query = $this->db->get();
        return $query;
    }
}
?>
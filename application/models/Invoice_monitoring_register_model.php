<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
	class Invoice_monitoring_register_model extends CI_Model{

	    public function get_invoice_details()
	    {
	        $user_id = $_SESSION['user_id'];
	        $emp_id = $_SESSION['emp_id'];
	        
            $this->db->select('invoice_monitoring_master.*,
            sales_order_register.sales_order_no,
            sales_order_register.sales_order_date,
            sales_order_register.customer_bill_to_name');
            $this->db->from('invoice_monitoring_master');
            /*$where = '(enquiry_register.enquiry_status = "'.'1'.'" or enquiry_register.enquiry_status = "'.'2'.'" or enquiry_register.enquiry_status = "'.'3'.'")';
            $this->db->where($where);*/
            $this->db->join('sales_order_register', 'invoice_monitoring_master.sales_order_id = sales_order_register.entity_id', 'INNER');
            $this->db->order_by('invoice_monitoring_master.entity_id', 'DESC');
            $query = $this->db->get();
            $query_result = $query->result();
            return $query_result; 
	    }

	    public function get_sales_order_list()
	    {
	        $this->db->select('*');
	        $this->db->from('sales_order_register');
	        $where = '(sales_order_register.invoice_status = "'.'1'.'")';
            $this->db->where($where);
	        $this->db->order_by('entity_id', 'DESC');
	        $query = $this->db->get();
	        $query_result = $query->result();
	        return $query_result;  
	    }

	    public function save_invoice_model($data)
	    {
	        $this->db->insert('invoice_monitoring_master',$data);
	        $invoice_id = $this->db->insert_id();
	    }

	    public function get_invoice_details_by_id_model($entity_id)
	    {
	        $this->db->select('*');
	        $this->db->from('invoice_monitoring_master');
	        $where = '(invoice_monitoring_master.entity_id = "'.$entity_id.'" )';
	        $this->db->where($where);
	        $query = $this->db->get();
	        return $query;
	    }

	    public function update_model($data)
	    {
	        $this->db->where('entity_id', $data['entity_id']);
	        return $this->db->update('invoice_monitoring_master', $data);
	    }
	}
?>
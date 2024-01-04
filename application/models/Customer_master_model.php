<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Customer_master_model extends CI_Model{

    public function check_customer_name_model($customer_name)
    {
        $this->db->select('*');
        $this->db->from('customer_master');
        $where = '(customer_master.customer_name = "'.$customer_name.'")';
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

    public function check_user_name_model($user_name)
    {
        $this->db->select('*');
        $this->db->from('customer_master');
        $where = '(customer_master.user_name = "'.$user_name.'")';
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

    public function get_employee_list()
    {
        $this->db->select('*');
        $this->db->from('employee_master');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_state_list()
    {
        $this->db->select('entity_id , state_name , CONCAT(state_name) AS State_name');
        $this->db->from('state_master');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_city_list()
    {
        $this->db->select('*');
        $this->db->from('city_master');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_city_model_data($state_id)
    {
        $query = $this->db->get_where('city_master', array('state_id' => $state_id));
        return $query;
    }

    public function get_all_data_by_id($entity_id)
    {
        $this->db->select('*');
        $this->db->from('customer_master');
        $where = '(customer_master.entity_id = "'.$entity_id.'" )';
        $this->db->where($where);
        $query = $this->db->get();
        return $query;
    }

    public function get_state_id_data($entity_id)
    {
        $this->db->select('*');
        $this->db->from('state_master');
        $where = '(state_master.entity_id = "'.$entity_id.'" )';
        $this->db->where($where);
        $query = $this->db->get();
        return $query;
    }

    
    public function get_source_list()
    {
        $this->db->select('*');
        $this->db->from('enquiry_source_master');
        $this->db->order_by('entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }
    

    public function get_customer_address_details($entity_id)
    {
        $this->db->select('customer_contact_master.*');
        $this->db->from('customer_contact_master');
        $where = '(customer_contact_master.customer_id = "'.$entity_id.'")';
        $this->db->where($where);
        $this->db->order_by('entity_id',"desc");
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_customer_only_address_details($entity_id)
    {
        $this->db->select('customer_address_master.entity_id AS Cust_address_id,
            customer_address_master.address_type,
            customer_address_master.party_name,
            customer_address_master.address,
            customer_address_master.state_id,
            customer_address_master.city_id,
            customer_address_master.pin_code,
            customer_address_master.state_code,
            customer_address_master.gst_no,
            customer_address_master.pan_no');
        $this->db->from('customer_address_master');
        $where = '(customer_address_master.customer_id = "'.$entity_id.'")';
        $this->db->where($where);
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_customer_only_contact_details($entity_id)
    {
        $this->db->select('customer_address_master.address_type,
            customer_contact_master.entity_id AS Cust_contact_id,
            customer_contact_master.contact_person,
            customer_contact_master.email_id,
            customer_contact_master.first_contact_no,
            customer_contact_master.second_contact_no,
            customer_contact_master.whatsup_no');
        $this->db->from('customer_contact_master');
        $where = '(customer_contact_master.customer_id = "'.$entity_id.'")';
        $this->db->where($where);
        $this->db->join('customer_address_master', 'customer_contact_master.customer_address_id = customer_address_master.entity_id', 'INNER');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function update_address_relation($update_array)
    {
        $this->db->where('entity_id', $update_array['entity_id']);
        return $this->db->update('customer_address_master', $update_array);
    }

    public function update_relation($update_array)
    {
        $this->db->where('entity_id', $update_array['entity_id']);
        return $this->db->update('customer_contact_master', $update_array);
    }

    public function update_contact_relation($update_array)
    {
        $this->db->where('entity_id', $update_array['entity_id']);
        return $this->db->update('customer_contact_master', $update_array);
    }

    public function update_customer_master($update_array)
    {
        $this->db->where('entity_id', $update_array['entity_id']);
        return $this->db->update('customer_master', $update_array);
    }

    public function get_all_customers()
    {
        /*$company_id = $_SESSION['company_id'];*/

        $this->db->select('*');
        $this->db->from('customer_master');
        /*$where = '(customer_master.user_id = "'.$user_id.'" And customer_master.company_id = "'.$company_id.'")';
        $this->db->where($where);*/
        $this->db->order_by('customer_master.entity_id','DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_all_customers_and_contact()
    {
        $this->db->select('customer_master.entity_id,
            customer_master.customer_name,
            customer_master.address,
            customer_master.pin_code,
            customer_master.gst_no,
            customer_master.customer_type,
            customer_master.status,
            customer_contact_master.contact_person,
            customer_contact_master.email_id,
            customer_contact_master.first_contact_no,
            city_master.city_name,
            state_master.state_name');
        $this->db->from('customer_contact_master');
        $this->db->join('customer_master', 'customer_contact_master.customer_id = customer_master.entity_id', 'INNER');
        $this->db->join('state_master', 'customer_master.state_id = state_master.entity_id', 'INNER');
        $this->db->join('city_master', 'customer_master.city_id = city_master.entity_id', 'INNER');
        $this->db->order_by('customer_master.entity_id','DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function delete_customer_record($entity_id)
    {
        $this->db->where('entity_id', $entity_id);
        $data = $this->db->delete('customer_master');

        $this->db->select('*');
        $this->db->from('customer_contact_master');
        $where = '(customer_contact_master.customer_id = "'.$entity_id.'")';
        $this->db->where($where);
        $customer_contact_master_data = $this->db->get();
        $customer_contact_master_result = $customer_contact_master_data->result_array();

        foreach($customer_contact_master_result as $key => $value) 
        {
            $customer_contact_id = $value['entity_id'];

            $this->db->where('entity_id', $customer_contact_id);
            $this->db->delete('customer_contact_master');
        }

        $this->db->select('*');
        $this->db->from('customer_address_master');
        $where = '(customer_address_master.customer_id = "'.$entity_id.'")';
        $this->db->where($where);
        $customer_address_master_data = $this->db->get();
        $customer_address_master_result = $customer_address_master_data->result_array();

        foreach($customer_address_master_result as $key => $value) 
        {
            $customer_address_id = $value['entity_id'];

            $this->db->where('entity_id', $customer_address_id);
            $this->db->delete('customer_address_master');
        }
        return $data;
    }

    public function get_state_code_by_state_id($state_id)
    {
        $this->db->select('state_master.state_code');
        $this->db->from('state_master');
        $where = '(state_master.entity_id = "'.$state_id.'" )';
        $this->db->where($where);
        $state_master = $this->db->get();
        $state_master_query_result = $state_master->row_array();

        $data_result['data'] = json_encode($state_master_query_result);
        return $state_master_query_result;
    }

    public function get_customer_offer_details($entity_id)
    {
        $this->db->select('offer_register.*,
            enquiry_register.enquiry_no,
            employee_master.emp_first_name');
        $this->db->from('offer_register');
        $where = '(offer_register.status = "'.'2'.'" or offer_register.status = "'.'6'.'" or offer_register.status = "'.'7'.'" or offer_register.status = "'.'8'.'" or offer_register.status = "'.'9'.'")';
        $this->db->where($where);

        $where1 = '(offer_register.customer_id = "'.$entity_id.'")';
        $this->db->where($where1);
        $this->db->join('employee_master', 'offer_register.offer_engg_name = employee_master.entity_id', 'INNER');
        $this->db->join('enquiry_register', 'offer_register.enquiry_id = enquiry_register.entity_id', 'INNER');
        $this->db->order_by('offer_register.entity_id', 'DESC');
        $this->db->group_by('offer_register.entity_id');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result; 
    }

    public function get_customer_order_details($entity_id)
    {
        $this->db->select('sales_order_register.*,
            employee_master.emp_first_name');
        $this->db->from('sales_order_register');
        $where = '(sales_order_register.customer_id = "'.$entity_id.'")';
        $this->db->where($where);
        $this->db->join('employee_master', 'sales_order_register.order_engg_name = employee_master.entity_id', 'INNER');
        
        $this->db->order_by('sales_order_register.entity_id', 'DESC');
        $this->db->group_by('sales_order_register.entity_id');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;
    }

    public function get_customer_enquiry_details($entity_id)
    {
        $this->db->select('enquiry_register.*,
        customer_master.customer_name,');
        $this->db->from('enquiry_register');
        $where = '(enquiry_register.enquiry_status = "'.'1'.'" And enquiry_register.customer_id = "'.$entity_id.'")';
        $this->db->where($where);
        $this->db->join('customer_master', 'enquiry_register.customer_id = customer_master.entity_id', 'INNER');
        $this->db->order_by('enquiry_register.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;
        
    }

    public function get_contact_data($customer_id)
    {
        $query = $this->db->get_where('customer_contact_master', array('customer_id' => $customer_id));
        return $query;
    }
}
?>
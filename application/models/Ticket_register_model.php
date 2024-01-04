<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Ticket_register_model extends CI_Model{

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
        $this->db->select('customer_master.entity_id,customer_master.*,customer_contact_master.contact_person,customer_contact_master.email_id,
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

    public function get_contact_person_data($customer_id)
    {
        $query = $this->db->get_where('customer_contact_master', array('customer_id' => $customer_id));
       //echo $this->db->last_query();die;
        return $query;
    }

    public function get_all_data_by_customer_id($contact_id)
    {
        $this->db->select('customer_contact_master.contact_person,
            customer_contact_master.email_id,
            customer_contact_master.first_contact_no,
            state_master.state_name,
            state_master.state_code,
            city_master.city_name');
        $this->db->from('customer_contact_master');
        $this->db->join('customer_master', 'customer_master.entity_id = customer_contact_master.customer_id', 'INNER'); 
        $this->db->join('state_master', 'customer_master.state_id = state_master.entity_id', 'INNER');
        $this->db->join('city_master', 'customer_master.city_id = city_master.entity_id', 'INNER');
        $where = '(customer_contact_master.entity_id = "'.$contact_id.'" )';
        $this->db->where($where);
        $customer_master = $this->db->get();
        $customer_master_query_result = $customer_master->row_array();

        $data_result['data'] = json_encode($customer_master_query_result);
        return $customer_master_query_result;
    }

    /*public function get_employee_list()
    {
        $this->db->select('entity_id,
            CONCAT(employee_id,'.'" - "'.', emp_first_name) AS Emp_name');
        $this->db->from('employee_master');
        $this->db->order_by('employee_master.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }*/

    /*public function get_product_list()
    {
        $this->db->select('entity_id,
            CONCAT(product_id,'.'" - "'.', product_name) AS Product_name');
        $this->db->from('product_master');
        $this->db->order_by('product_master.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }*/

    public function save_ticket_model($data)
    {
        $this->db->insert('ticket_master',$data);
        $ticket_id = $this->db->insert_id();

        /*if(!empty($enquiry_product))
        {
            foreach ($enquiry_product as $key => $value) 
            {
               $product_id = $value;

               $enquiry_type_array = array('enquiry_id' => $enquiry_id , 'product_id' => $product_id);
                $this->db->insert('enquiry_product',$enquiry_type_array);
            }
        }*/

        $this->db->select('tracking_number');
        $this->db->from('tracking_master');
        $this->db->order_by('entity_id', 'DESC');
        $this->db->limit(1);
        $enquiry_tracking_master = $this->db->get();
        $results_enquiry_tracking_register = $enquiry_tracking_master->result_array();

        if(!empty($results_enquiry_tracking_register))
        {
            $enquiry_tracking_serial_no = $results_enquiry_tracking_register[0]['tracking_number'];
            $enquiry_tracking_data_seprate = explode('/', $enquiry_tracking_serial_no);
            $enquiry_tracking_doc_year = $enquiry_tracking_data_seprate['1'];
        }

        $this->db->select('document_series_no');
        $this->db->from('documentseries_master');
        $where = '(documentseries_master.entity_id = "'.'2'.'")';
        $this->db->where($where);
        $doc_record=$this->db->get();
        $results_doc_record = $doc_record->result_array();

        $doc_serial_no = $results_doc_record[0]['document_series_no'];
        $doc_data_seprate = explode('/', $doc_serial_no);
        $doc_year = $doc_data_seprate['1'];

        if(empty($results_enquiry_tracking_register[0]['tracking_number']) || ($enquiry_tracking_doc_year != $doc_year))
        {
            $first_no = '0001';
            $doc_no = $doc_serial_no.$first_no;
        }elseif(!empty($results_enquiry_tracking_register) && ($enquiry_tracking_doc_year == $doc_year))
        {
            $doc_type = $enquiry_tracking_data_seprate['0'];
            $ex_no = $enquiry_tracking_data_seprate['2'];
            $next_en = $ex_no + 1;
            $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
            $doc_no = $doc_type.'/'.$enquiry_tracking_doc_year.'/'.$next_doc_no;
        }

        date_default_timezone_set("Asia/Calcutta");
        $tracking_date = date('Y-m-d');
        $tracking_status = 1;
        $tracking_record = $data['ticket_record'];
        $next_action = NULL;
        $action_due_date = date('Y-m-d', strtotime('+1 days'));

        $tracking_data = array('ticket_id' => $ticket_id , 'tracking_number' => $doc_no , 'tracking_date' => $tracking_date , 'tracking_record' => $tracking_record , 'next_action' => $next_action , 'action_due_date' => $action_due_date , 'user_id' => $data['user_id'] , 'status' => $tracking_status);

        $this->db->insert('tracking_master', $tracking_data);
        $tracking_lastid = $this->db->insert_id();
    }

    public function get_tracking_details()
    {
        $this->db->select('tracking_master.*,
            ticket_master.ticket_number,
            ticket_master.ticket_date,
            customer_master.customer_name,
            customer_contact_master.contact_person,
            customer_contact_master.first_contact_no');
        $this->db->from('tracking_master');
        /*$where1 = '(ticket_master.status = "'.'1'.'" or ticket_master.status = "'.'2'.'")';
        $this->db->where($where1);*/
        $this->db->join('ticket_master', 'tracking_master.ticket_id = ticket_master.entity_id', 'INNER');
        $this->db->join('customer_master', 'ticket_master.customer_id = customer_master.entity_id', 'INNER');
        $this->db->join('customer_contact_master', 'customer_master.entity_id = customer_contact_master.customer_id', 'INNER');
        $this->db->order_by('tracking_master.entity_id', 'DESC');
        $this->db->group_by('tracking_master.entity_id');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_warrantee_claims_details()
    {
        $this->db->select('ticket_master.*,
            customer_master.customer_name,
            customer_contact_master.contact_person,
            customer_contact_master.email_id,
            customer_contact_master.first_contact_no');
        $this->db->from('ticket_master');
        $where = '(ticket_master.ticket_type = "'.'1'.'")';
        $this->db->where($where);
        $where1 = '(ticket_master.status = "'.'1'.'" or ticket_master.status = "'.'2'.'")';
        $this->db->where($where1);
        $this->db->join('customer_master', 'ticket_master.customer_id = customer_master.entity_id', 'INNER');
        $this->db->join('customer_contact_master', 'customer_master.entity_id = customer_contact_master.customer_id', 'INNER');
        $this->db->order_by('ticket_master.entity_id', 'DESC');
        $this->db->group_by('ticket_master.entity_id');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_paid_service_details()
    {
        $this->db->select('ticket_master.*,
            customer_master.customer_name,
            customer_contact_master.contact_person,
            customer_contact_master.email_id,
            customer_contact_master.first_contact_no');
        $this->db->from('ticket_master');
        $where = '(ticket_master.ticket_type = "'.'2'.'")';
        $this->db->where($where);
        $where1 = '(ticket_master.status = "'.'1'.'" or ticket_master.status = "'.'2'.'")';
        $this->db->where($where1);
        $this->db->join('customer_master', 'ticket_master.customer_id = customer_master.entity_id', 'INNER');
        $this->db->join('customer_contact_master', 'customer_master.entity_id = customer_contact_master.customer_id', 'INNER');
        $this->db->order_by('ticket_master.entity_id', 'DESC');
        $this->db->group_by('ticket_master.entity_id');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_technical_support_details()
    {
        $this->db->select('ticket_master.*,
            customer_master.customer_name,
            customer_contact_master.contact_person,
            customer_contact_master.email_id,
            customer_contact_master.first_contact_no');
        $this->db->from('ticket_master');
        $where = '(ticket_master.ticket_type = "'.'3'.'")';
        $this->db->where($where);
        $where1 = '(ticket_master.status = "'.'1'.'" or ticket_master.status = "'.'2'.'")';
        $this->db->where($where1);
        $this->db->join('customer_master', 'ticket_master.customer_id = customer_master.entity_id', 'INNER');
        $this->db->join('customer_contact_master', 'customer_master.entity_id = customer_contact_master.customer_id', 'INNER');
        $this->db->order_by('ticket_master.entity_id', 'DESC');
        $this->db->group_by('ticket_master.entity_id');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_technical_support_field_details()
    {
        $this->db->select('ticket_master.*,
            customer_master.customer_name,
            customer_contact_master.contact_person,
            customer_contact_master.email_id,
            customer_contact_master.first_contact_no');
        $this->db->from('ticket_master');
        $where = '(ticket_master.ticket_type = "'.'5'.'")';
        $this->db->where($where);
        $where1 = '(ticket_master.status = "'.'1'.'" or ticket_master.status = "'.'2'.'")';
        $this->db->where($where1);
        $this->db->join('customer_master', 'ticket_master.customer_id = customer_master.entity_id', 'INNER');
        $this->db->join('customer_contact_master', 'customer_master.entity_id = customer_contact_master.customer_id', 'INNER');
        $this->db->order_by('ticket_master.entity_id', 'DESC');
        $this->db->group_by('ticket_master.entity_id');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_inhouse_details()
    {
        $this->db->select('ticket_master.*,
            customer_master.customer_name,
            customer_contact_master.contact_person,
            customer_contact_master.first_contact_no');
        $this->db->from('ticket_master');
        $where = '(ticket_master.ticket_type = "'.'4'.'")';
        $this->db->where($where);
        $where1 = '(ticket_master.status = "'.'1'.'" or ticket_master.status = "'.'2'.'")';
        $this->db->where($where1);
        $this->db->join('customer_master', 'ticket_master.customer_id = customer_master.entity_id', 'INNER');
        $this->db->join('customer_contact_master', 'customer_master.entity_id = customer_contact_master.customer_id', 'INNER');
        $this->db->order_by('ticket_master.entity_id', 'DESC');
        $this->db->group_by('ticket_master.entity_id');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_ticket_details_by_id_model($entity_id)
    {
        $this->db->select('*');
        $this->db->from('ticket_master');
        $where = '(ticket_master.entity_id = "'.$entity_id.'" )';
        $this->db->where($where);
        $query = $this->db->get();
        //print_r( $query->row());die;
        return $query;
    }

    public function update_ticket_model($data)
    {
        $this->db->where('entity_id', $data['entity_id']);
        return $this->db->update('ticket_master', $data);
    }

    public function delete_enquiry_model($entity_id)
    {
        $this->db->where('entity_id', $entity_id);
        $data = $this->db->delete('enquiry_register');
        return $data;
    } 

    public function get_all_enquiry_details($user_id)
    {
        $this->db->select('enquiry_register.*,
            customer_master.customer_name,
            customer_contact_master.contact_person,
            customer_contact_master.first_contact_no');
        $this->db->from('enquiry_register');
        $where = '(enquiry_register.user_id = "'.$user_id.'")';
        $this->db->where($where);
        $this->db->join('customer_master', 'enquiry_register.customer_id = customer_master.entity_id', 'INNER');
        $this->db->join('customer_contact_master', 'customer_master.entity_id = customer_contact_master.customer_id', 'INNER');
        $this->db->order_by('enquiry_register.entity_id', 'DESC');
        $this->db->group_by('enquiry_register.entity_id');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_enquiry_product_by_id($entity_id)
    {
        $this->db->select('product_id');
        $this->db->from('enquiry_product');
        $this->db->where('enquiry_id', $entity_id);
        $query = $this->db->get();
        return $query;
    }

    public function get_vender_details()
    {
        $this->db->select('vendor_master.*');
        $this->db->from('vendor_master');
        $this->db->order_by('vendor_master.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function insert($data = array()){ 
        $insert = $this->db->insert_batch('tracking_attachment',$data); 
        return $insert?true:false; 
    } 
}
?>
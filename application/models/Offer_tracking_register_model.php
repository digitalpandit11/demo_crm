<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Offer_tracking_register_model extends CI_Model{

	public function get_offer_tracking_details($user_id)
    {
    	$this->db->select('offer_tracking_master.*,
    		enquiry_register.enquiry_no,
            customer_master.customer_name,
            offer_register.offer_no');
        $this->db->from('offer_tracking_master');
        $where = '(offer_tracking_master.user_id = "'.$user_id.'")';
        $this->db->where($where);
        $this->db->join('enquiry_register', 'offer_tracking_master.enquiry_id = enquiry_register.entity_id', 'INNER');
        $this->db->join('customer_master', 'offer_tracking_master.customer_id = customer_master.entity_id', 'INNER');
        $this->db->join('offer_register', 'offer_tracking_master.offer_id = offer_register.entity_id', 'INNER');
        $this->db->order_by('offer_tracking_master.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_offer_number_list()
    {
        $this->db->select('*');
        $this->db->from('offer_register');
        /*$where = '(offer_register.enquiry_status = "'.'1'.'" OR enquiry_register.enquiry_status = "'.'2'.'")';
        $this->db->where($where);*/
        $this->db->order_by('offer_register.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_all_data_by_offer_id($offer_id)
    {
    	$this->db->select('offer_register.offer_description,
            offer_register.offer_date,
            offer_register.customer_id,
            offer_register.enquiry_id,
            enquiry_register.enquiry_no,
            enquiry_register.enquiry_short_desc,
            enquiry_register.enquiry_date,
            customer_master.customer_name,
            CONCAT(employee_master.employee_id,'.'" - "'.', employee_master.emp_first_name) AS Emp_name');
        $this->db->from('offer_register');
        $where = '(offer_register.entity_id = "'.$offer_id.'")';
        $this->db->where($where);
        $this->db->join('enquiry_register', 'offer_register.enquiry_id = enquiry_register.entity_id', 'INNER');
        $this->db->join('customer_master', 'offer_register.customer_id = customer_master.entity_id', 'INNER');
        $this->db->join('employee_master', 'offer_register.offer_engg_name = employee_master.entity_id', 'INNER');
        $query = $this->db->get();
        $query_result = $query->row_array();
        $data_result['data'] = json_encode($query_result);
        return $query_result;
    }

    public function save_offer_tracking_model($data)
    {
        $this->db->insert('offer_tracking_master',$data);
    }

    public function get_list_of_offer()
    {
        $this->db->select('*');
        $this->db->from('offer_register');
        $this->db->order_by('entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_offer_tracking_data($offer_id)
    {
        $this->db->select('offer_tracking_master.*,
            enquiry_register.enquiry_no,
            customer_master.customer_name,
            user_login.full_name');
        $this->db->from('offer_tracking_master');
        $where = '(offer_tracking_master.offer_id = "'.$offer_id.'")';
        $this->db->where($where);
        $this->db->join('enquiry_register', 'offer_tracking_master.enquiry_id = enquiry_register.entity_id', 'INNER');
        $this->db->join('customer_master', 'offer_tracking_master.customer_id = customer_master.entity_id', 'INNER');
        $this->db->join('user_login', 'offer_tracking_master.user_id = user_login.entity_id', 'INNER');
        $this->db->order_by('offer_tracking_master.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result; 
    }


    public function offer_to_offer_track_save_model($entity_id)
    {
        $user_id = $_SESSION['user_id'];  

        $this->db->select('*');
        $this->db->from('offer_register');
        $where = '(offer_register.entity_id = "'.$entity_id.'")';
        $this->db->where($where);
        $query = $this->db->get();
        $query_result = $query->row();

        $offer_id = $query_result->entity_id;
        $customer_id = $query_result->customer_id;
        $offer_description = $query_result->offer_description;
        $enquiry_id = $query_result->enquiry_id;
        $status = 1;

        $this->db->select('tracking_number');
        $this->db->from('offer_tracking_master');
        $this->db->order_by('entity_id', 'DESC');
        $this->db->limit(1);
        $offer_register = $this->db->get();
        $results_offer_tracking_register = $offer_register->result_array();

        if(!empty($results_offer_tracking_register))
        {
            $offer_tracking_serial_no = $results_offer_tracking_register[0]['tracking_number'];
            $offer_tracking_data_seprate = explode('/', $offer_tracking_serial_no);
            $offer_tracking_doc_year = $offer_tracking_data_seprate['1'];
        }

        $this->db->select('document_series_no');
        $this->db->from('documentseries_master');
        $this->db->where('entity_id=8');
        $doc_record=$this->db->get();
        $results_doc_record = $doc_record->result_array();

        $doc_serial_no = $results_doc_record[0]['document_series_no'];
        $doc_data_seprate = explode('/', $doc_serial_no);
        $doc_year = $doc_data_seprate['1'];

        if(empty($results_offer_tracking_register[0]['tracking_number']) || ($offer_tracking_doc_year != $doc_year))
        {
            $first_no = '0001';
            $doc_no = $doc_serial_no.$first_no;
        }elseif(!empty($results_offer_tracking_register) && ($offer_tracking_doc_year == $doc_year))
        {
            $doc_type = $offer_tracking_data_seprate['0'];
            $ex_no = $offer_tracking_data_seprate['2'];
            $next_en = $ex_no + 1;
            $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
            $doc_no = $doc_type.'/'.$offer_tracking_doc_year.'/'.$next_doc_no;
        }

            
            $enquiry_data_enquiry_track_save = "INSERT INTO offer_tracking_master (user_id, tracking_number, customer_id, enquiry_id, offer_id, status) VALUES ('".$user_id."','".$doc_no."', '".$customer_id."', '".$enquiry_id."', '".$offer_id."', '".$status."')";
            $save_execute = $this->db->query($enquiry_data_enquiry_track_save);
        }


        public function get_offer_details_by_id_model($entity_id)
        {
            $this->db->select('offer_tracking_master.*,
                               enquiry_register.enquiry_no,
                               customer_master.customer_name,
                               offer_register.offer_no,
                               offer_register.offer_description');
            $this->db->from('offer_tracking_master');
            $this->db->join('offer_register', 'offer_tracking_master.offer_id = offer_register.entity_id', 'INNER');
            $this->db->join('enquiry_register', 'offer_tracking_master.enquiry_id = enquiry_register.entity_id', 'INNER');
            $this->db->join('customer_master', 'offer_tracking_master.customer_id = customer_master.entity_id', 'INNER');
            $where = '(offer_register.entity_id = "'.$entity_id.'" )';
            $this->db->where($where);
            $query = $this->db->get();
            return $query;
        }

        public function get_offer_tracking_data_by_offer_id_model($entity_id)
        {
            
            $this->db->select('*');
            $this->db->from('offer_tracking_master');
            $where = '(offer_tracking_master.offer_id = "'.$entity_id.'"  AND offer_tracking_master.status = 2)';
            $this->db->where($where);
            $query = $this->db->get();
            $query_result = $query->result();
            return $query_result;
        }

        public function update_offer_tracking_model($data)
    {
        $this->db->where('entity_id', $data['entity_id']);
        return $this->db->update('offer_tracking_master', $data);
    }

}
?>
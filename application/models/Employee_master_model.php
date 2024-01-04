<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class Employee_master_model extends CI_Model{ 
    function __construct() { 
    } 

    public function save_employee_master_model($data)
    {
        $this->db->insert('employee_master',$data);
    }
    
    public function get_state_list()
    {
        $this->db->select('entity_id , state_name');
        $this->db->from('state_master');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;
    } 

    public function get_location_wise_emp_id_model()
    {   
        $this->db->select('employee_id');
        $this->db->from('employee_master');
        $this->db->order_by('entity_id', 'DESC');
        $this->db->limit(1);
        $employee_master = $this->db->get();
        $results_employee_master = $employee_master->result_array();

        if(!empty($results_employee_master[0]['employee_id']))
        {
            $employee_id_serial_no = $results_employee_master[0]['employee_id'];
            $employee_id_data_seprate = explode('/', $employee_id_serial_no);
        }

        $this->db->select('document_series_no');
        $this->db->from('documentseries_master');
        $this->db->where('entity_id = 1');
        $doc_record=$this->db->get();
        $results_doc_record = $doc_record->result_array();
        
        $doc_serial_no = $results_doc_record[0]['document_series_no'];
        $doc_data_seprate = explode('/', $doc_serial_no);

        if(empty($results_employee_master[0]['employee_id']))
        {
            $first_no = '0001';
            $doc_no = $doc_serial_no.$first_no;
            return $doc_no;
        }
        elseif(!empty($results_employee_master))
        {

            $doc_type = $employee_id_data_seprate['0'];
            $second_type = $employee_id_data_seprate['1'];
            $ex_no = $employee_id_data_seprate['2'];
            $next_en = $ex_no + 1;
            $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
            $doc_no = $doc_type.'/'.$second_type.'/'.$next_doc_no;
            return $doc_no;
        }
    }

    public function get_employee_master_data()
    {
        $this->db->select('employee_master.*');
        $this->db->from('employee_master');
        $this->db->order_by('entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_employee_master_by_id($entity_id)
    {
        $this->db->select('*');
        $this->db->from('employee_master');
        $this->db->where('entity_id', $entity_id);
        $query = $this->db->get();
        return $query;
    }

    public function update_employee_master($data)
    {
        $this->db->where('entity_id', $data['entity_id']);
        return $this->db->update('employee_master', $data);
    }     
}
?>
    

<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class User_master_model extends CI_Model{ 
    function __construct() { 
        // Set table name 
    } 

    public function get_company()
    {
        $this->db->select('*');
        $this->db->from('company_master');
        $this->db->order_by('entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_employee()
    {
        $this->db->select('*');
        $this->db->from('employee_master');
        $this->db->order_by('entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_role()
    {
        $this->db->select('*');
        $this->db->from('role_master');
        $this->db->order_by('entity_id', 'asc');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function save_info_model($data)
    {
        $this->db->insert('user_login',$data);
    }

    public function display_regestration_data_records()
    {
        $this->db->select('user_login.*,employee_master.employee_id,employee_master.emp_first_name,employee_master.emp_last_name,employee_master.email_id,role_master.role_name ');
        $this->db->from('user_login');
        $this->db->join('employee_master','employee_master.entity_id = user_login.emp_id','inner');
        $this->db->join('role_master','role_master.entity_id = user_login.role_id','inner');
        $query = $this->db->get();
        return $query;
    }

    public function display_records_by_id($entity_id)
    {
        $this->db->select('*');
        $this->db->from('user_login');
        $this->db->where('entity_id', $entity_id);
        $query = $this->db->get();
        $data = $query->row_array();
        return $data;
    }

    public function get_role_edit_model($hidden_role_id)
    {
        $query = $this->db->get_where('role_master', array('entity_id' => $hidden_role_id));
        return $query;
    }

    public function get_company_edit_model($hidden_company_id)
    {
        $query = $this->db->get_where('company_master', array('entity_id' => $hidden_company_id));
        return $query;
    }

    public function update_info_model($data)
    {
        // print_r($data);
        // die();
        // $this->db->where('entity_id', $data['entity_id']);
        // $this->db->update('user_login', $data); 

        $this->db->where('entity_id', $data['entity_id']);
        return $this->db->update('user_login', $data);
    }

    public function deleterecords($entity_id)
    {
        $this->db->where('entity_id', $entity_id);
        $this->db->delete('user_login'); 
    }

    public function get_user_details_by_id_model($entity_id)
    {
        $this->db->select('*');
        $this->db->from('user_login');
        $where = '(user_login.entity_id = "'.$entity_id.'" )';
        $this->db->where($where);
        $query = $this->db->get();
        // $data = $query->row_array();
        // print_r($data);
        // die();
        return $query;
    }
}
?>
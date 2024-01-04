<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class Company_master_model extends CI_Model{ 
    function __construct() { 
    } 

    public function get_state_name()
    {
        $this->db->select('*');
        $this->db->from('state_master');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_city_model_data($state_id)
    {
        $query = $this->db->get_where('city_master', array('state_id' => $state_id));
        return $query;
    }

    public function save_company_master_model   ($data)
    {
        $this->db->insert('company_master',$data);
    }

    public function get_company_master_data()
    {
        $this->db->select('company_master.*,
                           state_master.state_name,
                           city_master.city_name');
        $this->db->from('company_master');
        $this->db->join('state_master', 'company_master.state_id = state_master.entity_id', 'INNER');
        $this->db->join('city_master', 'company_master.city_id = city_master.entity_id', 'INNER');
        $this->db->order_by('entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_company_master_by_id($entity_id)
    {
        $this->db->select('*');
        $this->db->from('company_master');
        $this->db->where('entity_id', $entity_id);
        $query = $this->db->get();
        return $query;
    }

    public function update_company_master($data)
    {
        $this->db->where('entity_id', $data['entity_id']);
        return $this->db->update('company_master', $data);
    }   

    //////

    public function get_company_master_data_by_id($entity_id)
    {
        $query = $this->db->get_where('company_master', array('entity_id' =>  $entity_id));
        return $query;
    }  

    public function get_city_id_edit_data($city_id){
        $query = $this->db->get_where('city_master', array('state_id' => $city_id));
        return $query;
    }
         
}

    

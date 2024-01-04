<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class City_master_model extends CI_Model{ 
    function __construct() { 
        // Set table name 
    } 

    public function save_info_model($data){
        $this->db->insert('city_master',$data);
    }

     public function display_city_data_records()
    {
       /* $this->db->select('*');
        $this->db->from('city_master');
        $query = $this->db->get();
        return $query;*/

        $this->db->select('city_master.*,
                          state_master.state_name');
        $this->db->from('city_master');
        $this->db->join('state_master', 'city_master.state_id= state_master.entity_id', 'INNER');
        $query = $this->db->get();
        return $query;
    
    }

    public function get_state_id_edit_model($hidden_state_id)
    {
        $query = $this->db->get_where('state_master', array('entity_id' => $hidden_state_id));
        return $query;
    }

     public function get_state_data()
    {
        $this->db->select('*');
        $this->db->from('state_master');
        $this->db->order_by('entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

     public function display_records_by_id($entity_id)
     {
        $this->db->select('*');
        $this->db->from('city_master');
        $this->db->where('entity_id', $entity_id);
        $query = $this->db->get();
        $data = $query->row_array();
        return $data;
    }
    
    public function update_city_master_model($update_data)
    {
        $this->db->where('entity_id', $update_data['entity_id']);
        $this->db->update('city_master', $update_data); 
    }

    public function view_display_records_by_id($entity_id)
     {


        $this->db->select('*');
        $this->db->from('city_master');
        $this->db->where('entity_id', $entity_id);
        $query = $this->db->get();
        $data = $query->row_array();
        return $data;
    }


    public function deleterecords($entity_id)
    {
      $this->db->where('entity_id', $entity_id);
      $this->db->delete('city_master');
    }

     
}

    

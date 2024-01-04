<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Enquiry_type_master_model extends CI_Model{

    public function get_enquiry_type_details()
    {
        $this->db->select('enquiry_type_master.*');
        $this->db->from('enquiry_type_master');
        $this->db->order_by('enquiry_type_master.entity_id','DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function save_enquiry_type_info($data)
    {
        $this->db->insert('enquiry_type_master', $data);
        $vender_type_id = $this->db->insert_id();
    }

    public function edit_enquiry_type_info($data)
    {
        $this->db->where('entity_id', $data['entity_id']);
        return $this->db->update('enquiry_type_master', $data);
    }
}
?>
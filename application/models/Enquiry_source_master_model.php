<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Enquiry_source_master_model extends CI_Model{

    public function get_enquiry_source_details()
    {
        $this->db->select('enquiry_source_master.*');
        $this->db->from('enquiry_source_master');
        $this->db->order_by('enquiry_source_master.entity_id','DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function save_enquiry_source_info($data)
    {
        $this->db->insert('enquiry_source_master', $data);
        $vender_type_id = $this->db->insert_id();
    }

    public function edit_enquiry_source_info($data)
    {
        $this->db->where('entity_id', $data['entity_id']);
        return $this->db->update('enquiry_source_master', $data);
    }
}
?>
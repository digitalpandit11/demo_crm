<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Material_make_master_model extends CI_Model{

    public function get_material_make_details()
    {
        $this->db->select('product_make_master.*');
        $this->db->from('product_make_master');
        $this->db->order_by('product_make_master.entity_id','DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function save_material_make_info($data)
    {
        $this->db->insert('product_make_master', $data);
        $material_make_id = $this->db->insert_id();
    }

    public function edit_material_make_info($data)
    {
        $this->db->where('entity_id', $data['entity_id']);
        return $this->db->update('product_make_master', $data);
    }

    public function delete_material_make_info($data)
    {
    
        $this->db->where('entity_id', $data);
        return $this->db->delete('product_make_master');
    }
}
?>
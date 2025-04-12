<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Tnc_master_model extends CI_Model{

    public function save_tnc_master($data)
    {
        $this->db->insert('tnc_master', $data);
        $dosage_id = $this->db->insert_id();
    }

    public function edit_tnc_master($id)
    {
        return $this->db->get_where('tnc_master', ['entity_id' => $id])->row_array();
    }

    public function edit_tnc_master_info($data)
    {
        $this->db->where('entity_id', $data['entity_id']);
        return $this->db->update('tnc_master', $data);
    }
}

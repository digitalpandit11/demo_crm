<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Dosage_master_model extends CI_Model{

    public function save_dosage_info($data)
    {
        $this->db->insert('dosage_master', $data);
        $dosage_id = $this->db->insert_id();
    }

    public function edit_dosage_master_info($data)
    {
        $this->db->where('entity_id', $data['entity_id']);
        return $this->db->update('dosage_master', $data);
    }
}

<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class Welcome_model extends CI_Model{ 
    function __construct() { 
        // Set table name 
    } 

    public function validate($user_name,$encrypted_password)
    {
        
        $this->db->where('user_name',$user_name);
        $this->db->where('password',$encrypted_password);
        $query = $this->db->get('user_login');

        if($query->num_rows() > 0)
        {
            $row = $query->row();
            return true;
        }else
        {
            return false;
        }
    }

    // public function save_sign_up_data($data)
    // {
    //     $this->db->insert('user_login',$data);

    // }
}
?>
<?php 
	if(!defined('BASEPATH')) exit('No direct script access allowed');

	class Telephone_master_model extends CI_Model
	{
        public function get_all()
        {
            $this->db->select('*');
            $this->db->from('telephone_master');
            $this->db->order_by('entity_id', 'DESC');
            $query = $this->db->get();
            $query_result = $query->result();
            return $query_result;
        }

        public function insertRecord($record)
        {
            date_default_timezone_set("Asia/Calcutta");

            $user_id = $_SESSION['user_id'];

            $todays_date = date('Y-m-d');
            $todays_time = date('h:i A');

            if(count($record) > 0)
            {
                $this->db->select('email,mobile');
                $this->db->from('telephone_master');
                $where = 'email = "'.$record[2].'" OR mobile ="'.$record[3].'"';
                $this->db->where($where);
                $query = $this->db->get();
                $query_result = $query->num_rows();

                $this->db->select('*');
                $this->db->from('customer_contact_master');
                $where = 'email_id = "'.$record[2].'" OR first_contact_no ="'.$record[3].'"';
                $this->db->where($where);
                $customer_contact_master_query = $this->db->get();
                $customer_contact_master_count = $customer_contact_master_query->num_rows();

                if($query_result == 0)
                {
                    $newuser = array(
                    "company_name" => trim($record[0]),
                    "client_name" => trim($record[1]),
                    "email" => trim($record[2]),
                    "mobile" => trim($record[3]),
                    "source" => trim($record[4]),
                    "remark" => trim($record[5]),
                    "designation" => trim($record[6]),
                    "address" => trim($record[7]),
                    "category" => trim($record[8]),
                    "state" => trim($record[9]),
                    "city" => trim($record[10]),
                    "pincode" => trim($record[11]),
                    "website" => trim($record[12]),
                    "status" =>1,
                    "added_user" => $user_id
                    );

                    $this->db->insert('telephone_master', $newuser);
                }else if($query_result > 0 && $customer_contact_master_count == 0){
                    $newuser = array(
                    "company_name" => trim($record[0]),
                    "client_name" => trim($record[1]),
                    "email" => trim($record[2]),
                    "mobile" => trim($record[3]),
                    "source" => trim($record[4]),
                    "remark" => trim($record[5]),
                    "designation" => trim($record[6]),
                    "address" => trim($record[7]),
                    "category" => trim($record[8]),
                    "state" => trim($record[9]),
                    "city" => trim($record[10]),
                    "pincode" => trim($record[11]),
                    "website" => trim($record[12]),
                    "status" =>2,
                    "added_user" => $user_id
                    );

                    $this->db->insert('telephone_master', $newuser);
                } elseif($query_result > 0 && $customer_contact_master_count > 0){
                    $newuser = array(
                    "company_name" => trim($record[0]),
                    "client_name" => trim($record[1]),
                    "email" => trim($record[2]),
                    "mobile" => trim($record[3]),
                    "source" => trim($record[4]),
                    "remark" => trim($record[5]),
                    "designation" => trim($record[6]),
                    "address" => trim($record[7]),
                    "category" => trim($record[8]),
                    "state" => trim($record[9]),
                    "city" => trim($record[10]),
                    "pincode" => trim($record[11]),
                    "website" => trim($record[12]),
                    "status" =>3,
                    "added_user" => $user_id
                    );

                    $this->db->insert('telephone_master', $newuser);
                }  
            } 
        }
	}

?>
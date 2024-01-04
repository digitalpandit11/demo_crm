<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    class User_master extends CI_Controller {
        public function __construct() {
		    parent::__construct();
	        $this->load->helper('form');
		    $this->load->library('form_validation');
		    $this->load->library('session');
            $this->load->model('user_master_model');
            $this->load->library('upload');
        }

        public function display_regestration_data()
    	{
	        $result['data']=$this->user_master_model->display_regestration_data_records();
	        $this->load->view('master/user_master/vw_regestration_index',$result);
    	}

		public function vw_regestration_create()
		{
	        $data['role_list'] = $this->user_master_model->get_role();
	        $data['company'] = $this->user_master_model->get_company();
	        $data['employee'] = $this->user_master_model->get_employee();
			$this->load->view('master/user_master/vw_regestration_create',$data);
		}

	    public function save_info()
	    {
	        $this->load->library('form_validation');
	        $this->form_validation->set_rules('username','Username','required');
	        $this->form_validation->set_rules('password','Password','required');
	        // $this->form_validation->set_rules('mobile_no', 'Mobile Number ', 'required|regex_match[/^[0-9]{10}$/]');
	        if($this->form_validation->run())
	        {
	            $username = $this->input->post('username');
	            $password = $this->input->post('password');
	            $role_id = $this->input->post('role_id');
	            // $full_name = $this->input->post('full_name');
	            // $mobile_no = $this->input->post('mobile_no');
	            // $designation = $this->input->post('designation');
	            $emp_id = $this->input->post('emp_id');
	            $shapassword = sha1($password);
	            
	            $activation_status = 1;

	            $data = array(
								'user_name ' => $username , 
								'simple_password' => $password, 
								'password' => $shapassword , 
								'role_id' => $role_id , 
								// 'full_name' => $full_name , 
								// 'mobile_no' => $mobile_no , 
								'activation_status' => $activation_status, 
								// 'designation' => $designation, 
								'emp_id' => $emp_id);

	            $this->user_master_model->save_info_model($data);
	            redirect('vw_regestration_data');
	        }else{
	            $this->session->set_flashdata('error','Enter Username And Password');
	            redirect(base_url().'vw_regestration_create');
	        }
	    }

	    public function edit_user_info()
	    {
	        $data['role_list'] = $this->user_master_model->get_role();
	        $data['company'] = $this->user_master_model->get_company();
	        $data['employee'] = $this->user_master_model->get_employee();
	        $entity_id = $this->uri->segment(2);
	        $data['sata'] = $this->user_master_model->display_records_by_id($entity_id);
	        
	        $this->load->view('master/user_master/vw_regestration_edit',$data);
	    }

	    public function get_role_edit()
	    {
	        $hidden_role_id = $this->input->post('hidden_role_id',TRUE);
	        $data = $this->user_master_model->get_role_edit_model($hidden_role_id)->result();
	        echo json_encode($data);
	    }

	    public function get_company_edit()
	    {
	        $hidden_company_id = $this->input->post('hidden_company_id',TRUE);
	        $data = $this->user_master_model->get_company_edit_model($hidden_company_id)->result();
	        echo json_encode($data);
	    }

	    public function update_info()
	    {
	    	$entity_id = $this->input->post('entity_id');

	        $username = $this->input->post('user_name');
            $password = $this->input->post('simple_password');
            $role_id = $this->input->post('role_id');
            // $full_name = $this->input->post('full_name');
            // $mobile_no = $this->input->post('mobile_no');
            // $designation = $this->input->post('designation');
            $shapassword = sha1($password);
            $activation_status = $this->input->post('activation_status');

            $emp_id = $this->input->post('emp_id');

	        $data = array(
						'entity_id ' => $entity_id, 
						'user_name ' => $username , 
						'simple_password' => $password, 
						'password' => $shapassword , 
						'role_id' => $role_id , 
						// 'full_name' => $full_name , 
						// 'mobile_no' => $mobile_no , 
						'activation_status' => $activation_status, 
						// 'designation' => $designation , 
						'emp_id' => $emp_id);
	     //    print_r($data);
	    	// die();

	    	$where = '(entity_id ="'.$entity_id.'")';
	        $this->db->where($where);
	        $data = $this->db->update('user_login',$data);

	        // $this->user_master_model->update_info_model($data);
	        redirect('vw_regestration_data');
	    }

	    public function vw_view_regestration()
	    {
	        $data['role_list'] = $this->user_master_model->get_role();
	        $data['company'] = $this->user_master_model->get_company();

	        $entity_id = $this->uri->segment(2);
	        $data['sata'] = $this->user_master_model->display_records_by_id($entity_id);
	        $this->load->view('master/user_master/vw_regestration_view',$data);
	    }

	    public function delete_user_info()
	    {
	        $entity_id = $this->uri->segment(2);
	        $data = $this->user_master_model->deleterecords($entity_id);
	        redirect('vw_regestration_data');
	    }

	    public function get_user_details_by_id(){
        $entity_id = $this->input->post('entity_id',TRUE);
        $data = $this->user_master_model->get_user_details_by_id_model($entity_id)->result();
        echo json_encode($data);
    }
	}
?>
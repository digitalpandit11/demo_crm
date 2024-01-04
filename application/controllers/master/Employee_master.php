<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ob_start();
class Employee_master extends CI_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('employee_master_model');
        $this->load->library('session');
        //$this->load->library('upload');
    }

	public function index()
	{
        $data['employee_master'] = $this->employee_master_model->get_employee_master_data();
		$this->load->view('master/employee_master/vw_employee_master_index',$data);
	}

    public function create_employee()
    {
        $data['doc_no']=$this->employee_master_model->get_location_wise_emp_id_model();
        $data['state_list'] = $this->employee_master_model->get_state_list(); 
        $this->load->view('master/employee_master/vw_employee_master_create',$data);
    }


    public function save_employee_master()
    {
        $employee_id = $this->input->post('employee_id');
        $emp_first_name = $this->input->post('emp_first_name');
        $emp_middle_name = $this->input->post('emp_middle_name');
        $emp_last_name = $this->input->post('emp_last_name');
        $email_id = $this->input->post('email_id');
        $mobile_no = $this->input->post('mobile_no'); 
        $date_of_birth = $this->input->post('date_of_birth');
        $joining_date = $this->input->post('joining_date');
        $leaving_date = $this->input->post('leaving_date');
        $emp_region_to_handle = $this->input->post('emp_region_to_handle');
        $status = 1;
        $data = array(
            'employee_id' => $employee_id,
            'emp_first_name' => $emp_first_name,
            'emp_middle_name' => $emp_middle_name,
            'emp_last_name' => $emp_last_name,
            'email_id' => $email_id,
            'mobile_no' => $mobile_no,
            'date_of_birth' => $date_of_birth,
            'joining_date' => $joining_date,
            'leaving_date' => $leaving_date,
            'emp_region_to_handle' => $emp_region_to_handle,
            'status' => $status
        );
       
        $this->employee_master_model->save_employee_master_model($data);
        redirect('employee_master');
    }

    public function edit_employee_master()
    {
        $entity_id = $this->uri->segment(2);
        $data['entity_id'] = $entity_id;
        $data['state_list'] = $this->employee_master_model->get_state_list(); 
        $this->load->view('master/employee_master/vw_employee_master_edit',$data);
    }

    public function get_all_data_by_id()
    {
        $entity_id = $this->input->post('entity_id',TRUE);
        $data = $this->employee_master_model->get_employee_master_by_id($entity_id)->result();
         echo json_encode($data);
    }

    public function update_employee_master()
    {
        $entity_id = $this->input->post('entity_id');
        $employee_id = $this->input->post('employee_id');
        $emp_first_name = $this->input->post('emp_first_name');
        $emp_middle_name = $this->input->post('emp_middle_name');
        $emp_last_name = $this->input->post('emp_last_name');
        $email_id = $this->input->post('email_id');
        $mobile_no = $this->input->post('mobile_no'); 
        $date_of_birth = $this->input->post('date_of_birth');
        $joining_date = $this->input->post('joining_date');
        $leaving_date = $this->input->post('leaving_date');
        $emp_region_to_handle = $this->input->post('emp_region_to_handle');
        $emp_status = $this->input->post('emp_status');

        $data = array(
            'entity_id' => $entity_id,
            'employee_id' => $employee_id,
            'emp_first_name' => $emp_first_name,
            'emp_middle_name' => $emp_middle_name,
            'emp_last_name' => $emp_last_name,
            'email_id' => $email_id,
            'mobile_no' => $mobile_no,
            'date_of_birth' => $date_of_birth,
            'joining_date' => $joining_date,
            'leaving_date' => $leaving_date,
            'emp_region_to_handle' => $emp_region_to_handle,
            'status' => $emp_status
        );
       
        $result = $this->employee_master_model->update_employee_master($data);
        redirect('employee_master');
    }

    public function view_employee_master()
    {
        $entity_id = $this->uri->segment(2);
        $data['entity_id'] = $entity_id;
        $data['state_list'] = $this->employee_master_model->get_state_list(); 
        $this->load->view('master/employee_master/vw_employee_master_view',$data);
    }
}
?>
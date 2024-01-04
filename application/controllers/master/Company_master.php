<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company_master extends CI_Controller {
	public function __construct() 
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('company_master_model');
    $this->load->library('session');
    //$this->load->library('upload');
  }

	public function index()
	{
    $data['company_master'] = $this->company_master_model->get_company_master_data();
		$this->load->view('master/company_master/vw_company_master_index',$data);
	}

  public function create_company()
  {
    $data['state_name']=$this->company_master_model->get_state_name();
    $this->load->view('master/company_master/vw_company_master_create',$data);
  }

  public function get_city_name()
  {
      $state_id = $this->input->post('id',TRUE);
      $data = $this->company_master_model->get_city_model_data($state_id)->result();
      echo json_encode($data);
  }

  public function save_company_master()
    {
       
     if(!empty($_FILES['company_logo'])){
      $ext = pathinfo($_FILES['company_logo']['name'],PATHINFO_EXTENSION);
      $company_logo = substr(str_replace(" ", "_", $_FILES['company_logo']['name']), 0);
      move_uploaded_file($_FILES["company_logo"]["tmp_name"], 'assets/'.$company_logo);
      $company_logo_img = $_FILES['company_logo']['name'];  
      
      }else{
     
      }

      $post = $this->input->post(); 

      $company_name = $this->input->post('company_name');
      $company_logo = $company_logo_img;
      $address = $this->input->post('address');
      $state_id = $this->input->post('state_id');
      $city_id = $this->input->post('city_id');
      $pin_code = $this->input->post('pin_code'); 
      $state_code = $this->input->post('state_code');
      $phone_no = $this->input->post('phone_no');
      $mobile_no = $this->input->post('mobile_no');
      $email_id = $this->input->post('email_id');
      $gst_no = $this->input->post('gst_no');
      $bank_name = $this->input->post('bank_name');
      $branch_name = $this->input->post('branch_name');
      $bank_ifsc_code = $this->input->post('bank_ifsc_code');
      $bank_account_no = $this->input->post('bank_account_no');

      $data = array(
          'company_name' => $company_name,
          'company_logo' => $company_logo,
          'address' => $address,
          'state_id' => $state_id,
          'city_id' => $city_id,
          'pin_code' => $pin_code,
          'state_code' => $state_code,
          'phone_no' => $phone_no,
          'mobile_no' => $mobile_no,
          'email_id' => $email_id,
          'gst_no' => $gst_no,
          'bank_name' => $bank_name,
          'branch_name' => $branch_name,
          'bank_ifsc_code' => $bank_ifsc_code,
          'bank_account_no' => $bank_account_no
      );
     
      $this->company_master_model->save_company_master_model($data);
      redirect('company_master');
    }

    public function edit_company_master()
    {
      $entity_id = $this->uri->segment(2);
      $data['entity_id'] = $entity_id;
      $data['state_name']=$this->company_master_model->get_state_name();
      $get_data = $this->company_master_model->get_company_master_by_id($entity_id);
      
     if($get_data->num_rows() > 0)
      {
        $row = $get_data->row_array();
        $data['state_id'] = $row['state_id'];
        $data['city_id'] = $row['city_id'];
        $data['company_logo'] = $row['company_logo'];
      }
    
      $this->load->view('master/company_master/vw_company_master_edit',$data);
    }

    public function get_state_id()
    {
        $state = $this->input->post('id',TRUE);
        $data = $this->company_master_model->get_state_id_model($state)->result();
        echo json_encode($data);
    }

    public function get_state_selected()
    {
        $entity_id = $this->input->post('entity_id',TRUE);
        $data = $this->company_master_model->get_state_selected_model($entity_id)->result();
        echo json_encode($data);
    }

    public function get_city_id()
    {
        $state_id = $this->input->post('state_id_db',TRUE);
        $data = $this->company_master_model->get_city_model($state_id)->result();
        echo json_encode($data);
    }

    public function get_city_selected()
    {
        $entity_id = $this->input->post('entity_id',TRUE);
        $data = $this->company_master_model->get_city_selected_model($entity_id)->result();
        echo json_encode($data);
    }

    ////////

    public function get_data_edit()
    {
        $entity_id = $this->input->post('entity_id',TRUE);
        $data = $this->company_master_model->get_company_master_data_by_id($entity_id)->result();
        echo json_encode($data);
    }

    public function select_city_id_edit()
    {
        $city_id = $this->input->post('id',TRUE);
        $data = $this->company_master_model->get_city_id_edit_data($city_id)->result();
        echo json_encode($data);
    }

    public function update_employee_master()
    {
       
       if(!empty($_FILES['company_logo'])){
          $ext = pathinfo($_FILES['company_logo']['name'],PATHINFO_EXTENSION);
          $company_logo = substr(str_replace(" ", "_", $_FILES['company_logo']['name']), 0);
          move_uploaded_file($_FILES["company_logo"]["tmp_name"], 'assets/'.$company_logo);
          $company_logo_img = $_FILES['company_logo']['name'];  
         
          }else{
          
          }

            $entity_id = $this->input->post('entity_id');
            $company_name = $this->input->post('company_name');
            $company_logo = $company_logo_img;
            $address = $this->input->post('address');
            $state_id = $this->input->post('state_id');
            // print_r($state_id);
            // die();
            $city_id = $this->input->post('city_id');
            $pin_code = $this->input->post('pin_code'); 
            $state_code = $this->input->post('state_code');
            $phone_no = $this->input->post('phone_no');
            $mobile_no = $this->input->post('mobile_no');
            $email_id = $this->input->post('email_id');
            $gst_no = $this->input->post('gst_no');
            $bank_name = $this->input->post('bank_name');
            $branch_name = $this->input->post('branch_name');
            $bank_ifsc_code = $this->input->post('bank_ifsc_code');
            $bank_account_no = $this->input->post('bank_account_no');

            $data = array(
                'entity_id' => $entity_id,
                'company_name' => $company_name,
                'company_logo' => $company_logo,
                'address' => $address,
                'state_id' => $state_id,
                'city_id' => $city_id,
                'pin_code' => $pin_code,
                'state_code' => $state_code,
                'phone_no' => $phone_no,
                'mobile_no' => $mobile_no,
                'email_id' => $email_id,
                'gst_no' => $gst_no,
                'bank_name' => $bank_name,
                'branch_name' => $branch_name,
                'bank_ifsc_code' => $bank_ifsc_code,
                'bank_account_no' => $bank_account_no
            );
       
        $result = $this->company_master_model->update_company_master($data);
        redirect('company_master');
    }

    public function view_company_master()
    {
        $entity_id = $this->uri->segment(2);
        $data['entity_id'] = $entity_id;
        $data['state_name']=$this->company_master_model->get_state_name();
        $get_data = $this->company_master_model->get_company_master_by_id($entity_id);
  
       if($get_data->num_rows() > 0)
        {
            $row = $get_data->row_array();
            $data['state_id'] = $row['state_id'];
            $data['city_id'] = $row['city_id'];
            $data['company_logo'] = $row['company_logo'];
        }
      
        $this->load->view('master/company_master/vw_company_master_view',$data);
    }


}

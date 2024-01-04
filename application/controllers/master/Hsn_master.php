<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ob_start();

class Hsn_master extends CI_Controller {
	public function __construct() {
		parent::__construct();

		// Load form helper library
		$this->load->helper('form');

		// Load form validation library
		$this->load->library('form_validation');

		// Load session library
		$this->load->library('session');

		// // Load the model
        $this->load->model('hsn_master_model');

       
	}

	public function index()
	{
      $result['data']=$this->hsn_master_model->display_hsn_data_records();
		$this->load->view('master/hsn_master/vw_hsn_data',$result);
	}


   public function vw_hsn_master()
    {
        $this->load->view('master/hsn_master/vw_hsn_master');
    }


    public function save_info()
    {
      $hsn_code = $this->input->post('hsn_code');
      $total_gst_percentage = $this->input->post('total_gst_percentage');
      $scgt= $total_gst_percentage/2;
      
      $igst = $this->input->post('total_gst_percentage');
   
    


       

        $data = array(
            'hsn_code' => $hsn_code,
            'total_gst_percentage' => $total_gst_percentage,
            'cgst' => $scgt,
            'sgst' => $scgt,
            'igst' => $igst
                 
        );

      $this->hsn_master_model->save_info_model($data);
      redirect('vw_hsn_data');
    }
    
    public function save_info_pop_up()
    {
      $hsn_code = $this->input->post('hsn_code');
      $total_gst_percentage = $this->input->post('total_gst_percentage');
      $scgt= $total_gst_percentage/2;
      
      $igst = $this->input->post('total_gst_percentage');
        $data = array(
            'hsn_code' => $hsn_code,
            'total_gst_percentage' => $total_gst_percentage,
            'cgst' => $scgt,
            'sgst' => $scgt,
            'igst' => $igst
                 
        );

      $this->hsn_master_model->save_info_model($data);
    }

    public function check_hsn_code()
    {
        $data = $this->input->post();
        if(!empty($data))
        {
            $hsn_code = $this->input->post('id');
            $data = $this->hsn_master_model->check_customer_name_model($hsn_code);
            if($data == 'true')
            {
                print_r($data);
                die();
            }
        }
    }

	 public function edit_hsn_master()
    {
        $entity_id = $this->uri->segment(2);
        $data = $this->hsn_master_model->display_records_by_id($entity_id);
        $sata['sata'] = $data;
      
        $this->load->view('master/hsn_master/vw_hsn_master_edit',$sata);
    }


    public function update_hsn_master()
     {
        $entity_id = $this->input->post('entity_id');
        $hsn_code = $this->input->post('hsn_code');
        $total_gst_percentage = $this->input->post('total_gst_percentage');
        $scgt= $total_gst_percentage/2;
       
     
     
       $igst = $this->input->post('total_gst_percentage');
     


        $update_data = array(
            'entity_id' => $entity_id,
            'hsn_code' => $hsn_code,
            'total_gst_percentage' => $total_gst_percentage,
            'cgst' => $scgt,
            'sgst' => $scgt,
            'igst' => $igst,
            
     
        );

        $this->hsn_master_model->update_hsn_master_model($update_data);
        redirect('vw_hsn_data');
    }

     public function view_hsn_master()
    {
        $entity_id = $this->uri->segment(2);

        $data = $this->hsn_master_model->view_display_records_by_id($entity_id);
        $sata['sata'] = $data;
        $this->load->view('master/hsn_master/vw_view_hsn_master',$sata);
    }

    public function delete_hsn_data()
    {
        $entity_id = $this->uri->segment(2);
        $data = $this->hsn_master_model->deleterecords($entity_id);
        redirect('vw_hsn_data');
    }
   

}

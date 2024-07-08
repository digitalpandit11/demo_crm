<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Offer_for_master extends CI_Controller {
	public function __construct() {
		parent::__construct();

		// Load form helper library
		$this->load->helper('form');

		// Load form validation library
		$this->load->library('form_validation');

		// Load session library
		$this->load->library('session');

		// // Load the model
        $this->load->model('Offer_for_master_model');

       
	}

	public function index()
	{
        $result['data']=$this->Offer_for_master_model->display_offer_for_data_records();
		$this->load->view('master/offer_for_master/vw_offer_for_data',$result);
	}


    public function vw_offer_for_master()
    {
        $this->load->view('master/offer_for_master/vw_offer_for_master');
    }
   
    public function save_info(){
      $offer_for = $this->input->post('offer_for');
      $remark = $this->input->post('remark');
       

        $data = array(
            'offer_for' => $offer_for,
            'remark' => $remark,
            'status' => 1
        );

      $this->Offer_for_master_model->save_info_model($data);
      redirect('vw_offer_for_data');
    }

    public function edit_offer_for_master()
    {
        $entity_id = $this->uri->segment(2);
        $data = $this->Offer_for_master_model->display_records_by_id($entity_id);
        $sata['sata'] = $data;
      
        $this->load->view('master/offer_for_master/vw_offer_for_master_edit',$sata);
    }


    public function update_offer_for_master()
     {
        $entity_id = $this->input->post('entity_id');
        $offer_for = $this->input->post('offer_for');
        $remark = $this->input->post('remark');
       
        $update_data = array(
            'entity_id' => $entity_id,
            'offer_for' => $offer_for,
            'remark' => $remark
     
        );

        $this->Offer_for_master_model->update_Offer_for_master_model($update_data);
        redirect('vw_offer_for_data');
    }

    public function view_offer_for_master()
    {
        $entity_id = $this->uri->segment(2);

        $data = $this->Offer_for_master_model->view_display_records_by_id($entity_id);
        $sata['sata'] = $data;
        $this->load->view('master/offer_for_master/vw_view_offer_for_master',$sata);
    }


    public function delete_offer_for_data()
    {
        $entity_id = $this->uri->segment(2);
        $data = $this->Offer_for_master_model->deleterecords($entity_id);
        redirect('vw_offer_for_data');
    }

	


}

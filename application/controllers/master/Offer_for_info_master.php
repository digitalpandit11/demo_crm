<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Offer_for_info_master extends CI_Controller {
	public function __construct() {
		parent::__construct();

		// Load form helper library
		$this->load->helper('form');

		// Load form validation library
		$this->load->library('form_validation');

		// Load session library
		$this->load->library('session');

		// // Load the model
        $this->load->model('offer_for_info_master_model');

       
	}

	public function index()
	{
        $result['data']=$this->offer_for_info_master_model->display_offer_for_info_data_records();
		$this->load->view('master/offer_for_info_master/vw_offer_for_info_data',$result);
	}


    public function vw_offer_for_info_master()
    {

        $data['offer_for_list'] = $this->offer_for_info_master_model->get_offer_for_list();

        $this->load->view('master/offer_for_info_master/vw_offer_for_info_master',$data);
    }
   
    public function save_info(){
        $offer_for_id = $this->input->post('offer_for_id');
        $offer_for_info = $this->input->post('offer_for_info');
       

        $data = array(
            'offer_for_info' => $offer_for_info,
            'offer_for_id' => $offer_for_id
           
        );

      $this->offer_for_info_master_model->save_info_model($data);
      redirect('vw_offer_for_info_data');
    }

     public function edit_offer_for_info_master()
    {
        $data['offer_for_list'] = $this->offer_for_info_master_model->get_offer_for_list();
        $entity_id = $this->uri->segment(2);
        $data['sata'] = $this->offer_for_info_master_model->display_records_by_id($entity_id);
      

        $this->load->view('master/offer_for_info_master/vw_offer_for_info_master_edit',$data);
    }

    public function get_offer_for_id_edit()
    {
        $hidden_offer_for_id = $this->input->post('hidden_offer_for_id',TRUE);
        $data = $this->offer_for_info_master_model->get_offer_for_id_edit_model($hidden_offer_for_id)->result();
        echo json_encode($data);
    }


    public function update_offer_for_info_master()
     {
        $entity_id = $this->input->post('entity_id');
        $offer_for_info = $this->input->post('offer_for_info');
        $offer_for_id = $this->input->post('offer_for_id');
       
        $update_data = array(
            'entity_id' => $entity_id,
            'offer_for_info' => $offer_for_info,
            'offer_for_id '=> $offer_for_id
     
        );

        $this->offer_for_info_master_model->update_offer_for_info_master_model($update_data);
        redirect('vw_offer_for_info_data');
    }

    public function view_offer_for_info_master()
    {
        $data['state'] = $this->offer_for_info_master_model->get_state_data();
        $entity_id = $this->uri->segment(2);

        $data['sata'] = $this->offer_for_info_master_model->view_display_records_by_id($entity_id);
        
        $this->load->view('master/offer_for_info_master/vw_view_offer_for_info_master',$data);
    }


    public function delete_offer_for_info_data()
    {
        $entity_id = $this->uri->segment(2);
        $data = $this->offer_for_info_master_model->deleterecords($entity_id);
        redirect('vw_offer_for_info_data');
    }

	


}

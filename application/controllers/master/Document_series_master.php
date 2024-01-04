<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Document_series_master extends CI_Controller
{
	public function __construct() 
	{
				parent::__construct();

				// Load form helper library
				$this->load->helper('form');

				// Load form validation library
				$this->load->library('form_validation');

				// Load session library
				$this->load->library('session');

				// // Load the model
				 $this->load->model('document_series_master_model');
   }

	public function index()
	{      
          $resultt['data']=$this->document_series_master_model->display_customer_data_records();
          $resultt['bata']=$this->document_series_master_model->session_data();
         $this->load->view('master/document_series_master/vw_document_series_data',$resultt);
  }

  public function vw_document_series_master()
  {
        $this->load->view('master/document_series_master/vw_document_series_master');
  }

	public function save_info()
  {
      $document_type = $this->input->post('document_type');
      $document_series_no = $this->input->post('document_series_no');
     
       $data = array(
            'document_type' => $document_type,
            'document_series_no' => $document_series_no
                   
        );

      $this->document_series_master_model->save_info_model($data);
      redirect('vw_document_series_data');
  }
 

	public function edit_document_series_master()
  {
        $entity_id = $this->uri->segment(2);
        $data = $this->document_series_master_model->display_records_by_id($entity_id);
        $sata['sata'] = $data;
      
        $this->load->view('master/document_series_master/vw_document_series_master_edit',$sata);
  }


  public function update_document_series_master_model()
  {
        $entity_id = $this->input->post('entity_id');
        $document_type = $this->input->post('document_type');
       $document_series_no = $this->input->post('document_series_no');
      


        $update_data = array(
            'entity_id' => $entity_id,
            'document_type' => $document_type,
            'document_series_no' => $document_series_no
          
     
        );

        $this->document_series_master_model->update_document_series_master_model($update_data);
        redirect('vw_document_series_data');
  }

  public function view_document_series_master()
  {
        $entity_id = $this->uri->segment(2);

        $data = $this->document_series_master_model->view_display_records_by_id($entity_id);
        $sata['sata'] = $data;
        $this->load->view('master/document_series_master/vw_view_document_series_master',$sata);
  }

  public function delete_document_series_data()
  {
        $entity_id = $this->uri->segment(2);
        $data = $this->document_series_master_model->deleterecords($entity_id);
        redirect('vw_document_series_data');
  }
   

}
?>
<?php
	if(!defined('BASEPATH')) exit('No direct script access allowed');
	ob_start();
	class Telephone_master extends CI_Controller
	{
		function __construct()
		{
			parent::__construct();

			$this->load->library('session');
			$this->load->helper('url');
			$this->load->model('telephone_master_model');
		}

		public function index()
		{
			$data['telephone_list'] = $this->telephone_master_model->get_all();
			$this->load->view('master/telephone_master/vw_telephone_master',$data);
		}

		public function create()
		{
			$this->load->view('master/telephone_master/vw_create_telephone_master');
		}

		public function save_telephone_register() 
	    {
	    	$user_id = $_SESSION['user_id'];

	        $company_name = $this->input->post('company_name');
	        $client_name = $this->input->post('client_name');
	        $email_address = $this->input->post('email_address');
	        $mobile_number = $this->input->post('mobile_number');
	        $source = $this->input->post('source');
	        $designation = $this->input->post('designation');
	        $remark = $this->input->post('remark');
	        $address = $this->input->post('address');
	        $state = $this->input->post('state');
	        $city = $this->input->post('city');
	        $pin_code = $this->input->post('pin_code');
	        $website = $this->input->post('website');
	        $category = $this->input->post('category');
	        $status = 1;

	        $data = array(
                    "company_name" => $company_name,
                    "client_name" => $client_name,
                    "email" => $email_address,
                    "mobile" => $mobile_number,
                    "source" => $source,
                    "remark" => $remark,
                    "address" => $address,
                    "designation" => $designation,
                    "category" => $category,
                    "state" => $state,
                    "city" => $city,
                    "pincode" => $pin_code,
                    "website" => $website,
                    "status" => $status,
                    "added_user" => $user_id);
            $this->db->insert('telephone_master', $data);

	        redirect('vw_telephone');
	    }

		public function uploadData()
	    {   
	      //  $entity_id = $this->input->post('panel_entity_id');
	        if($this->input->post('upload') != NULL ){ 
	            $data = array(); 
	            if(!empty($_FILES['file']['name'])){ 
	                // Set preference 
	                $config['upload_path'] = 'assets/files/'; 
	                $config['allowed_types'] = 'csv'; 
	                $config['max_size'] = '1000'; // max_size in kb 
	                $config['file_name'] = $_FILES['file']['name']; 

	                // Load upload library 
	                $this->load->library('upload',$config); 
	   
	                // File upload
	                if($this->upload->do_upload('file')){ 
	                    // Get data about the file
	                    $uploadData = $this->upload->data(); 
	                    $filename = $uploadData['file_name']; 

	                    // Reading file
	                    $file = fopen("assets/files/".$filename,"r");
	                    $i = 0;
	                    $numberOfFields = 13; // Total number of fields
	                    $importData_arr = array();
	                       
	                    while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
	                        $num = count($filedata);

	                        if($numberOfFields == $num){
	                            for ($c=0; $c < $num; $c++) {
	                                $importData_arr[$i][] = $filedata [$c];
	                            }
	                        }
	                        $i++;
	                    }
	                    fclose($file);

	                    $skip = 0;
	                    
	                    // insert import data
	                    foreach($importData_arr as $userdata){
	                        
	                        // Skip first row
	                        if($skip != 0){
	                            $this->telephone_master_model->insertRecord($userdata);
	                        }
	                        $skip ++;
	                    }
	                    $data['response'] = 'successfully uploaded '.$filename; 
	                }else{ 
	                    $data['response'] = 'failed'; 
	                } 
	            }else{ 
	                $data['response'] = 'failed'; 
	            } 
	            // load view 
	            redirect('vw_telephone');
	        }else{
	            // load view 
	            redirect('vw_telephone'); 
	        } 
	    }
	}
?>
<?php
	if (!defined('BASEPATH'))exit('No direct script access allowed ');
	ob_start();
	class Campaign_register extends CI_Controller
	{
		function __construct()
		{
			parent::__construct();
			$this->load->helper('url');
			$this->load->library('session');
			$this->load->library('email');
			$this->load->model('campaign_register_model');
		}

		public function index()
		{
			$data['campaign_details']=$this->campaign_register_model->get_all_campaigns();
			$this->load->view('sales/campaign_register/vw_campaign',$data);
		}

		public function create()
		{	
			$data['employee_list'] =$this->campaign_register_model->get_employee_list();
			$data['telephone_list']=$this->campaign_register_model->get_telephone_list();
			$this->load->view('sales/campaign_register/create_campaign',$data);
		}
    

		public function create2()
		{	
      $data['campaign_number'] = $this->campaign_register_model->generate_campaign_number();
			$data['employee_list'] =$this->campaign_register_model->get_employee_list();
			$data['telephone_list']=$this->campaign_register_model->get_telephone_list2();
			$this->load->view('sales/campaign_register/vw_create_campaign2',$data);
		}

    public function save_campaign2()
    {
      $campaign_number = $this->input->post('campaign_number');
      $campaign_name = $this->input->post('campaign_name');
      $user_id = $this->input->post('compaign_assign');
      $created_date = $this->input->post('created_date');
      $start_date = $this->input->post('start_date');
      $end_date = $this->input->post('end_date');
      $status = 2;

      $insert_array = array(
        'campaign_number' =>  $campaign_number,
        'campaign_name' => $campaign_name,
        'user_id' => $user_id,
        'created_date' => $created_date,
        'start_date' => $start_date,
        'end_date' => $end_date,
        'status' => $status);

        $campaign_id = $this->campaign_register_model->save_campaign_model($insert_array);

        redirect(base_url().'edit_campaign2/'.$campaign_id);



    }
    
		public function uploadData()
    {   

      $campaign_id = $this->input->post('campaign_id');


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
                            $this->campaign_register_model->insertRecord($userdata,$campaign_id);
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
            redirect(base_url().'edit_campaign2/'.$campaign_id);
        }else{
            // load view 
            redirect(base_url().'edit_campaign2/'.$campaign_id); 
        } 
    }

   public function update_campaign2()
   {

    $campaign_id = $this->input->post('campaign_id');
    $campaign_name = $this->input->post('campaign_name');
    $assigned_to = $this->input->post('compaign_assign');
    $status = $this->input->post('compaign_status');


    $update_array = array(
      'campaign_name' => $campaign_name,
      'user_id' => $assigned_to,
      'status' => $status
    );

    $this->db->where('entity_id' , $campaign_id);
    $this->db->update('campaign_register',$update_array);


    redirect(base_url().'vw_campaign'); 


   }

   
		public function add_contact() 
	    {
	    	$user_id = $_SESSION['user_id'];

	        $campaign_id = $this->input->post('modal_campaign_id');
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

	        $insert_array = array(
                    "campaign_id" => $campaign_id,
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
          
			$this->campaign_register_model->add_contcat_model($insert_array);

	        redirect('edit_campaign2/'.$campaign_id);
	    }


		public function client_list()
		{
			$id= $this->uri->segment(2);
			$data['relation_id']=$id;
			$data['campaign_data'] =$this->campaign_register_model->get_campaing_data($id);
			$data['campaign_clients'] =$this->campaign_register_model->get_campaing_clients($id);
			$this->load->view('sales/campaign_register/client_list',$data);
		}
		

		public function view_campaign2()
		{
			$campaign_id= $this->uri->segment(2);
			$data['relation_id']=$campaign_id;
			$data['campaign_data'] =$this->campaign_register_model->get_campaing_data2($campaign_id);
			$data['campaign_telephone_numbers'] =$this->campaign_register_model->get_campaign_telephone_numbers($campaign_id);
			$this->load->view('sales/campaign_register/vw_campaign2',$data);
		}
		
		public function client_list_update()
		{
            $id= $this->uri->segment(2);
			$data['relation_id']=$id;
			$data['campaign_data'] =$this->campaign_register_model->get_campaing_data($id);
			$data['campaign_clients'] =$this->campaign_register_model->get_campaing_clients($id);
      $data['telephone_list']=$this->campaign_register_model->get_telephone_list();
			$this->load->view('sales/campaign_register/client_list_update',$data);
		}

        public function update_campaign_client()
        {
        $campaign_id = $this->input->post('campaign_id');

        $client_checkbox = $this->input->post('client_checkbox');

        $added_date = date('Y-m-d');
        
        $status = 1;
        
        foreach ($client_checkbox as $key => $value) 
        {
          $telephone_id = $value['value'];
          
         $update_array = array('campaign_id' => $campaign_id, 'telephone_id' => $telephone_id, 'added_date' => $added_date, 'status' =>$status);
         $this->db->insert('campaign_relation',$update_array);

            
            
                // $campaign_relation_save = "INSERT INTO campaign_relation (campaign_id , telephone_id , added_date , status ) VALUES ('".$campaign_id."' , '".$telephone_id."' , '".$added_date."' , '".$status."' )";
                // $save_campaign_relation = $this->db->query($campaign_relation_save);
                //set session 
                // $this->session->set_userdata('campaign_relation', 'Product Saved....!');
            
        }

        $data = $campaign_id;
        echo json_encode($data);
        }


        public function remove_campaign_client(){
    
          $result = $this->campaign_register_model->remove_campaign_client();
          $msg['success'] = false;
          if($result){
              $msg['success'] = true;
          }
          echo json_encode($msg);
    
        }

		public function call_log()
		{
			$id = $this->uri->segment(2);

			$this->db->select('*');
			$this->db->from('campaign_relation');
			$this->db->where('entity_id',$id);

			$relation = $this->db->get()->row_array();

			$cname = $this->db->select('campaign_name,entity_id')
							->from('campaign_register')
							->where('entity_id',$relation['campaign_id'])
							->get()->row_array();

			$data['entity_id'] = $id;
			$data['telephone_id'] = $relation['telephone_id'];
			$data['log_detail']=$this->campaign_register_model->get_log_detail($relation['entity_id']);
			$data['campaign_name']=$cname['campaign_name'];
			$data['campaign_id']=$cname['entity_id'];

			$this->load->view('sales/campaign_register/call_log',$data);
		}

		public function vw_call_log2()
		{
			$campaign_telephone_relation_id = $this->uri->segment(2);

			$data['campaign_client_details'] = $this->campaign_register_model->get_client_details($campaign_telephone_relation_id);

			$data['log_detail']=$this->campaign_register_model->get_log_detail2($campaign_telephone_relation_id);
			

			$this->load->view('sales/campaign_register/vw_call_log2',$data);
		}

		public function create_campaign()
		{
			$telephone_list_id= $this->input->post('list_id');

			$dt['campaign_name'] = $this->input->post('cmp_name');
			$dt['user_id']  = $this->session->userdata('user_id');
			$dt['status']=1;
			$dt['start_date'] = $this->input->post('start');
			$dt['end_date'] = $this->input->post('end');

			$emp_id = $this->input->post('assign');

			$this->db->insert('campaign_register',$dt);
			$campaign_id = $this->db->insert_id();

			$emp = array('campaign_id'=>$campaign_id,'employee_id' =>$emp_id);

			$this->db->insert('campaign_emp_relation',$emp);


			foreach($telephone_list_id as $key => $asss)
			{
				$assign_id=$asss['value'];

				$data['telephone_id'] = $assign_id;
				$data['campaign_id']= $campaign_id;
				$data['status']= 1;

				$this->db->insert('campaign_relation',$data);
			}
				
				echo json_encode($campaign_id);
			
		}

		public function edit_campaign()
		{
			$cmp_id= $this->uri->segment(2);

			$data['telephone_list']=$this->campaign_register_model->get_campaign_telephone_list($cmp_id);

			$this->load->view('sales/campaign_register/edit_campaign',$data);
		}
    

		public function edit_campaign2()
		{
			$campaign_id= $this->uri->segment(2);

      		$data['employee_list'] =$this->campaign_register_model->get_employee_list();
			$data['campaign_details']=$this->campaign_register_model->get_campaign_details($campaign_id);

			$this->load->view('sales/campaign_register/vw_edit_campaign2',$data);
		}

		public function fetch_campaign_telephone_numbers()
		{
			$campaign_id= $this->input->post('campaign_id');

			$telephone_list =$this->campaign_register_model->get_campaign_telephone_list2($campaign_id);

			echo json_encode($telephone_list);
		}

		public function create_call_log()
		{
			$data['campaign_id']=$this->input->post('camp_name');
			$data['campaign_relation_id']=$this->input->post('entity_id');
			$data['record_type']=$this->input->post('type');
			$data['status']=$this->input->post('status');
			$data['message']=$this->input->post('msg');

			$result = $this->db->insert('call_log',$data);

			echo json_encode($result);
		}
		public function next()
		{
			$relation_id = $this->uri->segment(2);

			$com_id = $this->db->select('campaign_id')->from('campaign_relation')->where('entity_id',$relation_id)->get()->row_array();

			$campain_id = $com_id['campaign_id'];

			$next_data = $this->campaign_register_model->get_next($relation_id,$campain_id);

			redirect(base_url().'view_call_log/'.$next_data['entity_id']);


		}
		public function prev()
		{
			$relation_id = $this->uri->segment(2);

			$com_id = $this->db->select('campaign_id')->from('campaign_relation')->where('entity_id',$relation_id)->get()->row_array();

			$campain_id = $com_id['campaign_id'];

			$prev_data = $this->campaign_register_model->get_prev($relation_id,$campain_id);

			redirect(base_url().'view_call_log/'.$prev_data['entity_id']);


		}
		
		public function save_call_log()
		{
			$next_telephone_id = $this->input->post('next_telephone_id');

			date_default_timezone_set("Asia/Calcutta");
        	$Record_date = date('Y-m-d : h:i:s A');
        	$data['datestamp'] = date('d-m-Y');
			$data['last_log_date'] = $Record_date;
			$data['call_answered']=$this->input->post('call_sts');
			$data['case_open_close']=$this->input->post('open_close');
			$data['call_description']=$this->input->post('call_description');
			$data['next_action']=$this->input->post('next_action');
			$data['follow_up_date']=$this->input->post('fdate');
			$data['wrong_number']=$this->input->post('wrong_number');
			$data['telephone_id']=$this->input->post('telephone_id');
			$data['dnd']=$this->input->post('dnd');
			$data['campaign_id']=$this->input->post('campaign_name');
			$data['campaign_relation_id	']=$this->input->post('entity_id');
			$data['telephone_id_mobile']=$this->input->post('call_log_data');

			$data['user_id'] = $this->session->userdata('user_id');
			$data['status'] = 1;

			$entity_id =$this->input->post('telephone_id');

			if($data['dnd'] == 1 || $data['wrong_number'] == 1) 
			{
				$datas= array('dnd' => 1);
				$this->db->where('entity_id',$entity_id);
				$this->db->update('telephone_master',$datas);
			}

			$camp_relation=$this->input->post('entity_id');
			$camp_id =$this->input->post('campaign_name');

			$last_id = $this->campaign_register_model->save_call_log($data);

			//$next_data = $this->campaign_register_model->get_next($camp_relation,$camp_id);

			redirect(base_url().'view_call_log/'.$next_telephone_id);
		}
		
		public function save_call_log2()
		{
			$next_telephone_id = $this->input->post('next_telephone_id');

			date_default_timezone_set("Asia/Calcutta");
      $Record_date = date('Y-m-d : h:i:s A');
      $data['datestamp'] = date('d-m-Y');
			$data['last_log_date'] = $Record_date;
			$data['call_answered']=$this->input->post('call_sts');
			$data['case_open_close']=$this->input->post('open_close');
			$data['call_description']=$this->input->post('call_description');
			$data['next_action']=$this->input->post('next_action');
			$data['follow_up_date']=$this->input->post('fdate');
			$data['wrong_number']=$this->input->post('wrong_number');
			$data['telephone_id']=$this->input->post('telephone_id');
			$data['dnd']=$this->input->post('dnd');
			$data['campaign_id']=$this->input->post('campaign_id');
			$data['campaign_relation_id	']=$this->input->post('campaign_telephone_relation_id');
			$data['telephone_id_mobile']=$this->input->post('mobile');
			$data['user_id'] = $this->session->userdata('user_id');

      if ($data['case_open_close']  == 1 || $data['case_open_close']  == 3 || $data['wrong_number'] || $data['dnd']){
        $data['status'] = 3;
      }elseif ($data['call_answered'] || $data['call_description'] ){
        $data['status'] = 2;
      } else {
        $data['status'] = 1;
      }

			$last_id = $this->campaign_register_model->save_call_log2($data);

			//$next_data = $this->campaign_register_model->get_next($camp_relation,$camp_id);

			redirect(base_url().'view_call_log2/'.$next_telephone_id);
		}
	}
?>
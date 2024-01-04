<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ob_start();
class Ticket_register extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('ticket_register_model');
        $this->load->library('session');
    }

    public function create()
    {
        $data['state_list'] = $this->ticket_register_model->get_state_list();
        $data['customer_list'] = $this->ticket_register_model->get_customer_list();
        /*$data['employee_list'] = $this->ticket_register_model->get_employee_list();
        $data['product_list'] = $this->ticket_register_model->get_product_list();*/
        $this->load->view('support/ticket_register/vw_ticket_register_create',$data);
    }

    public function get_contact_person()
    {
        $customer_id = $this->input->post('id',TRUE);
        $data = $this->ticket_register_model->get_contact_person_data($customer_id)->result();
         echo json_encode($data);
    }

    public function get_all_customer_data()
    {
        $data = $this->input->post();
        if(!empty($data))
        {
            $contact_id = $this->input->post('id');
            $data = $this->ticket_register_model->get_all_data_by_customer_id($contact_id);
            echo json_encode([$data]);
        }
    }

    public function save_ticket()
    {
        if(!empty($_FILES['ticket_attachment']))
        {
            $ticket_attachment_img = "";
            foreach ($_FILES as $key => $value) {
                
                $file_name = $value['name'];
                $file_source_path = $value['tmp_name'];
                $file_upload_combine_array = array_combine($file_name, $file_source_path);
                //print_r($file_upload_combine_array);
                
                foreach ($file_upload_combine_array as $image_name=> $image_source_path) {
                    // echo $k. ' '. $a ;

                    $ext = pathinfo($image_name,PATHINFO_EXTENSION);

                    $ticket_attachment_upload = substr(str_replace(" ", "_", $image_name), 0);
                    move_uploaded_file($image_source_path, 'assets/ticket_attachment/'.$ticket_attachment_upload);

                    $ticket_attachment_img .= $ticket_attachment_upload.',';
                }  
            }
        }else{
            $ticket_attachment_img = NULL;
        }

        $this->db->select('ticket_number');
        $this->db->from('ticket_master');
        $this->db->order_by('ticket_master.entity_id', 'DESC');
        $this->db->limit(1);
        $ticket_master = $this->db->get();
        $results_ticket_master = $ticket_master->result_array();

        if(!empty($results_ticket_master[0]['ticket_number']))
        {
            $ticket_serial_no = $results_ticket_master[0]['ticket_number'];
            $ticket_data_seprate = explode('/', $ticket_serial_no);
        }

        $this->db->select('document_series_no');
        $this->db->from('documentseries_master');
        $where = '(documentseries_master.entity_id = "'.'3'.'")';
        $this->db->where($where);
        $doc_record=$this->db->get();
        $results_doc_record = $doc_record->result_array();
        
        $doc_serial_no = $results_doc_record[0]['document_series_no'];
        $doc_data_seprate = explode('/', $doc_serial_no);

        if(empty($results_ticket_master[0]['ticket_number']))
        {
            $first_no = '0001';
            $ticket_number = $doc_serial_no.$first_no;
        }
        elseif(!empty($results_ticket_master))
        {

            $doc_type = $ticket_data_seprate['0'];
            $second_type = $ticket_data_seprate['1'];
            $ex_no = $ticket_data_seprate['2'];
            $next_en = $ex_no + 1;
            $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
            $ticket_number = $doc_type.'/'.$second_type.'/'.$next_doc_no;
        }
        
        $user_id = $_SESSION['user_id'];
        $customer_id = $this->input->post('customer_id');
        $contact_id = $this->input->post('contact_id');
        $refrance_person = $this->input->post('refrance_person');
        $ticket_type = $this->input->post('ticket_type');
        $product_name = $this->input->post('product_name');
        $product_make = $this->input->post('product_make');
        $product_code = $this->input->post('product_code');
        $warrantee_status = $this->input->post('warrantee_status');
        $warrantee_year = $this->input->post('warrantee_year');
        $invoice_number = $this->input->post('invoice_number');
        $invoice_date = $this->input->post('invoice_date');
        $product_srno = $this->input->post('product_srno');
        $ticket_descrption = $this->input->post('ticket_descrption');

        /*$enquiry_product = $this->input->post('enquiry_product');*/

        date_default_timezone_set("Asia/Calcutta");
        $ticket_date = date('Y-m-d');
        $system_date_time = date("Y-m-d H:i:s");
        $ticket_status = 1;

        $data = array('refrance_name ' => $refrance_person , 'ticket_type ' => $ticket_type , 'customer_id' => $customer_id , 'contact_person_id' => $contact_id , 'product_name' => $product_name , 'product_make' => $product_make , 'product_code' => $product_code , 'warrantee_status' => $warrantee_status , 'warrantee_year' => $warrantee_year , 'invoice_number' => $invoice_number , 'invoice_date' => $invoice_date , 'product_serial_number' => $product_srno , 'ticket_number' => $ticket_number , 'ticket_date' => $ticket_date , 'ticket_record' => $ticket_descrption , 'attachment' => $ticket_attachment_img , 'user_id' => $user_id , 'status' => $ticket_status);

        $result = $this->ticket_register_model->save_ticket_model($data);

        if($ticket_type == 1)
        {
            redirect('vw_ticket_warrantee_claims_data');
        }elseif($ticket_type == 2)
        {
            redirect('vw_ticket_paid_service_data');
        }elseif($ticket_type == 3)
        {
            redirect('vw_ticket_technical_support_data');
        }elseif($ticket_type == 4)
        {
            redirect('vw_inhouse_data');
        }elseif($ticket_type == 5)
        {
            redirect('vw_ticket_technical_support_field_data');
        }
    }

    public function all_ticket_index()
    {
        $this->load->view('support/ticket_register/vw_all_ticket_index');
    }

    public function warrantee_claims_index()
    {
        $data['ticket_details'] = $this->ticket_register_model->get_warrantee_claims_details();
        $this->load->view('support/ticket_register/vw_warrantee_claims_index',$data);
    }

    public function paid_service_index()
    {
        $data['ticket_details'] = $this->ticket_register_model->get_paid_service_details();
        $this->load->view('support/ticket_register/vw_paid_service_index',$data);
    }

    public function technical_support_index()
    {
        $data['ticket_details'] = $this->ticket_register_model->get_technical_support_details();
        $this->load->view('support/ticket_register/vw_technical_support_index',$data);
    }

    public function technical_support_field_index()
    {
        $data['ticket_details'] = $this->ticket_register_model->get_technical_support_field_details();
        $this->load->view('support/ticket_register/vw_technical_support_field_index',$data);
    }

    public function inhouse_index()
    {
        $data['ticket_details'] = $this->ticket_register_model->get_inhouse_details();
        $this->load->view('support/ticket_register/vw_inhouse_index',$data);
    }

    public function update_ticket_data()
    {
        $entity_id = $this->uri->segment(2);

        $this->db->select('*');
        $this->db->from('ticket_master');
        $where = '(ticket_master.entity_id = "'.$entity_id.'")';
        $this->db->where($where);
        $query = $this->db->get();
        $query_result = $query->row_array();

        $status = $query_result['status'];

        if($status == 1 || $status == 2)
        {
            $data['entity_id'] = $entity_id;
            $ticket_data = $this->ticket_register_model->get_ticket_details_by_id_model($entity_id);
            $data['ticket_result'] = $ticket_data;
            /* $data['customer_list'] = $this->enquiry_register_model->get_customer_list();
            $data['product_list'] = $this->ticket_register_model->get_product_list();*/
            $this->load->view('support/ticket_register/vw_ticket_update',$data);
        }else{
                $data = site_url('dashboard');
                header("location:$data");
        }
    }

    public function view_ticket_data()
    {
        $entity_id = $this->uri->segment(2);

        $data['entity_id'] = $entity_id;
        $ticket_data = $this->ticket_register_model->get_ticket_details_by_id_model($entity_id);
        $data['ticket_result'] = $ticket_data;
        $this->load->view('support/ticket_register/vw_ticket_data_view',$data);
    }

    public function save_address()
    {
        date_default_timezone_set("Asia/Calcutta");
        $todays_date = date('Y-m-d');

       // $lead_source = $this->input->post('lead_source');
        $customer_name = $this->input->post('customer_name');
        $customer_type = $this->input->post('customer_type');
        $address = $this->input->post('address');
        $state_id = $this->input->post('state_id');
        $city_id = $this->input->post('city_id');
        $state_code = $this->input->post('state_code');
        $customer_pin_code = $this->input->post('customer_pin_code');
        $customer_gst_number = $this->input->post('customer_gst_number');
        $customer_note = $this->input->post('customer_note');
        // $customer_pan_number = $this->input->post('customer_pan_number');
        $customer_status = 1;

        $customer_name_array = array(
          'customer_name' => $customer_name , 
          'customer_type' => $customer_type , 
          'address' => $address , 
          'state_id' => $state_id , 
          'city_id' => $city_id , 
          'pin_code' => $customer_pin_code , 
          'state_code' => $state_code , 
          'gst_no' => $customer_gst_number , 
          'customer_note' => $customer_note , 
          'date_entered' => $todays_date,
        //   'source' => $lead_source,
          'status' => $customer_status);

        $this->db->insert('customer_master', $customer_name_array);
        $customer_lastid = $this->db->insert_id();


        $contact_person = $this->input->post('contact_person');
        $email_id = $this->input->post('contact_person_email_id');
        $first_contact_no = $this->input->post('first_contact_no');
        $second_contact_no = $this->input->post('second_contact_no');
        $whatsup_no = $this->input->post('whatsup_no');
        $contact_note = $this->input->post('contact_note');

        $customer_contact_array = array(
            'customer_id' => $customer_lastid , 
            'contact_person' => $contact_person , 
            'email_id' => $email_id , 
            'first_contact_no' => $first_contact_no , 
            'whatsup_no' => $whatsup_no , 
            'second_contact_no' => $second_contact_no , 
            'contact_note' => $contact_note , 
            );
  
        $data= $this->db->insert('customer_contact_master', $customer_contact_array);
        echo json_encode($data);
    }
    
    public function view_all_ticket()
    {
        $entity_id = $this->uri->segment(2);

        $data['entity_id'] = $entity_id;
        $ticket_data = $this->ticket_register_model->get_ticket_details_by_id_model($entity_id);
        $data['ticket_result'] = $ticket_data;
        $this->load->view('support/ticket_register/vw_ticket_view',$data);
    }

    public function vw_all_tracking_data()
    {
        $data['tracking_details'] = $this->ticket_register_model->get_tracking_details();
        $this->load->view('support/ticket_register/vw_all_tracking_index',$data);
    }

    public function get_ticket_details_by_id()
    {
        $entity_id = $this->input->post('entity_id',TRUE);
        $data = $this->ticket_register_model->get_ticket_details_by_id_model($entity_id)->result();
        echo json_encode($data);
    }

    public function update_ticket()
    {
        $entity_id = $this->input->post('entity_id');
        $user_id = $_SESSION['user_id'];
        $tracking_descrption = $this->input->post('tracking_descrption');

        $this->db->select('ticket_master.*');
        $this->db->from('ticket_master');
        $this->db->where('entity_id', $entity_id);
        $query = $this->db->get();
        $query_result = $query->row_array();

        $ticket_type = $query_result['ticket_type'];

        if(!empty($tracking_descrption))
        {
            $tracking_date = $this->input->post('tracking_date');
            $tracking_descrption = $this->input->post('tracking_descrption');
            $status = 1;
            $tracking_next_action = $this->input->post('tracking_next_action');

            $next_action = $tracking_next_action;
            // if(!empty($tracking_next_action))
            // {
            //     $next_action = $tracking_next_action;
            // }else{
            //     $next_action = "Call Tommarrow";
            // }

            $action_due_date = $this->input->post('action_due_date');

            $new_action_due_date = $action_due_date;
            // if(!empty($action_due_date))
            // {
            //     $new_action_due_date = $action_due_date;
            // }else{
            //     $new_action_due_date = date($tracking_date ,strtotime('+3 day'));
            // }

            $this->db->select('tracking_number');
            $this->db->from('tracking_master');
            $this->db->order_by('entity_id', 'DESC');
            $this->db->limit(1);
            $enquiry_register = $this->db->get();
            $results_enquiry_tracking_register = $enquiry_register->result_array();

            $this->db->select('*');
            $this->db->from('tracking_master');
            $where_or = '(ticket_id = "'.$entity_id.'")';
            $this->db->where($where_or);
            $tracking_master= $this->db->get();
            $tracking_master_count =  $tracking_master->num_rows();
            $tracking_master_result = $tracking_master->row_array();

            if(!empty($results_enquiry_tracking_register))
            {
                $enquiry_tracking_serial_no = $results_enquiry_tracking_register[0]['tracking_number'];
                $enquiry_tracking_data_seprate = explode('/', $enquiry_tracking_serial_no);
                $enquiry_tracking_doc_year = $enquiry_tracking_data_seprate['1'];
            }

            $this->db->select('document_series_no');
            $this->db->from('documentseries_master');
            $this->db->where('entity_id=2');
            $doc_record=$this->db->get();
            $results_doc_record = $doc_record->result_array();

            $doc_serial_no = $results_doc_record[0]['document_series_no'];
            $doc_data_seprate = explode('/', $doc_serial_no);
            $doc_year = $doc_data_seprate['1'];

            if(empty($results_enquiry_tracking_register[0]['tracking_number']) || ($enquiry_tracking_doc_year != $doc_year))
            {
                $first_no = '0001';
                $doc_no = $doc_serial_no.$first_no;
            }elseif(!empty($results_enquiry_tracking_register) && ($enquiry_tracking_doc_year == $doc_year))
            {
                $doc_type = $enquiry_tracking_data_seprate['0'];
                $ex_no = $enquiry_tracking_data_seprate['2'];
                $next_en = $ex_no + 1;
                $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
                $doc_no = $doc_type.'/'.$enquiry_tracking_doc_year.'/'.$next_doc_no;
            }

            $tracking_data = array('ticket_id' => $entity_id , 'tracking_number' => $doc_no , 'tracking_date' => $tracking_date , 'tracking_record' => $tracking_descrption , 'next_action' => $next_action , 'action_due_date' => $new_action_due_date , 'user_id' => $user_id , 'status' => $status);

            $this->db->insert('tracking_master', $tracking_data);
            $tracking_lastid = $this->db->insert_id();

            $data = array(); 
            $errorUploadType = $statusMsg = ''; 

            if(!empty($_FILES['tracking_attachment']['name']) && count(array_filter($_FILES['tracking_attachment']['name'])) > 0){ 
                $filesCount = count($_FILES['tracking_attachment']['name']); 

                for($i = 0; $i < $filesCount; $i++){ 
                    $_FILES['file']['name']     = $_FILES['tracking_attachment']['name'][$i]; 
                    $_FILES['file']['type']     = $_FILES['tracking_attachment']['type'][$i]; 
                    $_FILES['file']['tmp_name'] = $_FILES['tracking_attachment']['tmp_name'][$i]; 
                    $_FILES['file']['error']     = $_FILES['tracking_attachment']['error'][$i]; 
                    $_FILES['file']['size']     = $_FILES['tracking_attachment']['size'][$i]; 
                     
                    // File upload configuration 
                    $uploadPath = 'assets/tracking_attachment/'; 
                    $config['upload_path'] = $uploadPath; 
                    $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf'; 
                     
                    // Load and initialize upload library 
                    $this->load->library('upload', $config); 
                    $this->upload->initialize($config); 

                    // Upload file to server 
                    if($this->upload->do_upload('file')){ 
                        // Uploaded file data 
                        $fileData = $this->upload->data(); 
                        $uploadData[$i]['attachment'] = $fileData['file_name']; 
                        $uploadData[$i]['uploaded_on'] = date("Y-m-d H:i:s"); 
                        $uploadData[$i]['tracking_id'] = $tracking_lastid;
                        $uploadData[$i]['ticket_id'] = $entity_id;
                    }else{  
                        $errorUploadType .= $_FILES['file']['name'].' | '; 
                    } 
                } 
                 
                $errorUploadType = !empty($errorUploadType)?'<br/>File Type Error: '.trim($errorUploadType, ' | '):''; 
                if(!empty($uploadData)){ 
                    // Insert files data into the database 
                    $insert = $this->ticket_register_model->insert($uploadData); 
                     
                    // Upload status message 
                    $statusMsg = $insert?'Files uploaded successfully!'.$errorUploadType:'Some problem occurred, please try again.'; 
                }else{ 
                    $statusMsg = "Sorry, there was an error uploading your file.".$errorUploadType; 
                } 
            }else{ 
                $statusMsg = 'Please select image files to upload.'; 
            } 
        }
        $entity_id = $this->input->post('entity_id');
        /*$ticket_type = $this->input->post('ticket_type');*/
        $product_make = $this->input->post('product_make');
        $product_name = $this->input->post('product_name');
        $product_code = $this->input->post('product_code');
        /*$warrantee_status = $this->input->post('warrantee_status');*/
        $invoice_number = $this->input->post('invoice_number');
        $invoice_date = $this->input->post('invoice_date');
        $product_srno = $this->input->post('product_srno');
        $ticket_descrption = $this->input->post('ticket_descrption');
        $ticket_status = $this->input->post('ticket_status');
        $rejected_reason = $this->input->post('rejected_reason');

        $data = array('entity_id ' => $entity_id , 'product_make' => $product_make , 'product_name' => $product_name , 'product_code' => $product_code , 'invoice_number' => $invoice_number , 'invoice_date' => $invoice_date , 'product_serial_number' => $product_srno , 'ticket_record' => $ticket_descrption , 'user_id' => $user_id , 'status' => $ticket_status , 'management_decision' => $rejected_reason);

        $where = '(entity_id ="'.$entity_id.'")';
        $this->db->where($where);
        $this->db->update('ticket_master',$data);
        if($ticket_type == 1)
        {
            redirect('vw_ticket_warrantee_claims_data');
        }elseif($ticket_type == 2)
        {
            redirect('vw_ticket_paid_service_data');
        }elseif($ticket_type == 3)
        {
            redirect('vw_ticket_technical_support_data');
        }elseif($ticket_type == 5)
        {
            redirect('vw_ticket_technical_support_field_data');
        }
    }

    public function delete_ticket_attach_image()
    {
        $data = $this->uri->segment(2);
        $attachment_data = explode('-',$data);
        //print_r($attachment_data);
        if(!empty($attachment_data['0'] && $attachment_data['1']))
        {
            $image_name = $attachment_data['0'];
            $image_name_db = $attachment_data['0'].',';
            $entity_id = $attachment_data['1'];

            $this->db->select('attachment');
            $this->db->from('ticket_master');
            $where = '(ticket_master.entity_id = "'.$entity_id.'")';
            $this->db->where($where);
            $attachment_check = $this->db->get();
            $attachment_check_result = $attachment_check->row_array();

            $attachment_data = $attachment_check_result['attachment'];

            $delete_image = NULL;
            $replaced_data =  str_replace($image_name_db,$delete_image,$attachment_data);

            $image_attachment_new_array = array('attachment' => $replaced_data);
            $where = '(entity_id ="'.$entity_id.'")';
            $this->db->where($where);
            $this->db->update('ticket_master',$image_attachment_new_array);

            unlink("assets/ticket_attachment/".$image_name);
            redirect('update_ticket_data'.'/'.$entity_id); 
        }
    }

    public function move_ticket() 
    {
        $user_id = $_SESSION['user_id'];

        $refrance_ticket_id = $this->input->post('entity_id');
        $ticket_type = $this->input->post('ticket_type');
        $management_decision = $this->input->post('management_decision');

        $update_array = array('management_decision' => $management_decision , 'status' => 3 , 'user_id' => $user_id);
        $where = '(entity_id ="'.$refrance_ticket_id.'")';
        $this->db->where($where);
        $this->db->update('ticket_master',$update_array);

        $this->db->select('ticket_number');
        $this->db->from('ticket_master');
        $this->db->order_by('ticket_master.entity_id', 'DESC');
        $this->db->limit(1);
        $ticket_master = $this->db->get();
        $results_ticket_master = $ticket_master->result_array();

        if(!empty($results_ticket_master[0]['ticket_number']))
        {
            $ticket_serial_no = $results_ticket_master[0]['ticket_number'];
            $ticket_data_seprate = explode('/', $ticket_serial_no);
        }

        $this->db->select('document_series_no');
        $this->db->from('documentseries_master');
        $where = '(documentseries_master.entity_id = "'.'3'.'")';
        $this->db->where($where);
        $doc_record=$this->db->get();
        $results_doc_record = $doc_record->result_array();
        
        $doc_serial_no = $results_doc_record[0]['document_series_no'];
        $doc_data_seprate = explode('/', $doc_serial_no);

        if(empty($results_ticket_master[0]['ticket_number']))
        {
            $first_no = '0001';
            $ticket_number = $doc_serial_no.$first_no;
        }
        elseif(!empty($results_ticket_master))
        {

            $doc_type = $ticket_data_seprate['0'];
            $second_type = $ticket_data_seprate['1'];
            $ex_no = $ticket_data_seprate['2'];
            $next_en = $ex_no + 1;
            $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
            $ticket_number = $doc_type.'/'.$second_type.'/'.$next_doc_no;
        }
        
        $this->db->select('ticket_master.*');
        $this->db->from('ticket_master');
        $this->db->where('entity_id', $refrance_ticket_id);
        $query = $this->db->get();
        $query_result = $query->row_array();

        $old_ticket_number = $query_result['ticket_number'];
        $customer_id = $query_result['customer_id'];
        $contact_id = $query_result['contact_person_id'];
        $refrance_person = $query_result['refrance_name'];
        $product_make = $query_result['product_make'];
        $product_name = $query_result['product_name'];
        $product_code = $query_result['product_code'];
        
        $invoice_number = $query_result['invoice_number'];
        $invoice_date = $query_result['invoice_date'];
        $product_srno = $query_result['product_serial_number'];
        $ticket_descrption = $query_result['ticket_record'];
        $ticket_attachment_img = $query_result['attachment'];

        if($ticket_type == 1)
        {
            $warrantee_status = 1;
            $warrantee_year = $query_result['warrantee_year'];
        }else{
            $warrantee_status = 2;
            $warrantee_year = NULL;
        }
        
        date_default_timezone_set("Asia/Calcutta");
        $ticket_date = date('Y-m-d');
        $system_date_time = date("Y-m-d H:i:s");
        $ticket_status = 1;

        $this->db->select('ticket_master.*');
        $this->db->from('ticket_master');
        $this->db->where('refrance_ticket_id', $refrance_ticket_id);
        $query_count = $this->db->get();
        $query_count_result = $query_count->num_rows();

        if($query_count_result == 0)
        {
            $data = array('refrance_name ' => $refrance_person , 'ticket_type ' => $ticket_type , 'customer_id' => $customer_id , 'contact_person_id' => $contact_id , 'product_make' => $product_make , 'product_name' => $product_name , 'product_code' => $product_code , 'warrantee_status' => $warrantee_status , 'warrantee_year' => $warrantee_year , 'invoice_number' => $invoice_number , 'invoice_date' => $invoice_date , 'product_serial_number' => $product_srno , 'ticket_number' => $ticket_number , 'ticket_date' => $ticket_date , 'ticket_record' => $ticket_descrption , 'attachment' => $ticket_attachment_img , 'user_id' => $user_id , 'status' => $ticket_status , 'refrance_ticket_id' => $refrance_ticket_id);

            $this->db->insert('ticket_master',$data);
            $ticket_lastid = $this->db->insert_id();

            $this->db->select('tracking_number');
            $this->db->from('tracking_master');
            $this->db->order_by('entity_id', 'DESC');
            $this->db->limit(1);
            $enquiry_tracking_master = $this->db->get();
            $results_enquiry_tracking_register = $enquiry_tracking_master->result_array();

            if(!empty($results_enquiry_tracking_register))
            {
                $enquiry_tracking_serial_no = $results_enquiry_tracking_register[0]['tracking_number'];
                $enquiry_tracking_data_seprate = explode('/', $enquiry_tracking_serial_no);
                $enquiry_tracking_doc_year = $enquiry_tracking_data_seprate['1'];
            }

            $this->db->select('document_series_no');
            $this->db->from('documentseries_master');
            $where = '(documentseries_master.entity_id = "'.'2'.'")';
            $this->db->where($where);
            $doc_record=$this->db->get();
            $results_doc_record = $doc_record->result_array();

            $doc_serial_no = $results_doc_record[0]['document_series_no'];
            $doc_data_seprate = explode('/', $doc_serial_no);
            $doc_year = $doc_data_seprate['1'];

            if(empty($results_enquiry_tracking_register[0]['tracking_number']) || ($enquiry_tracking_doc_year != $doc_year))
            {
                $first_no = '0001';
                $doc_no = $doc_serial_no.$first_no;
            }elseif(!empty($results_enquiry_tracking_register) && ($enquiry_tracking_doc_year == $doc_year))
            {
                $doc_type = $enquiry_tracking_data_seprate['0'];
                $ex_no = $enquiry_tracking_data_seprate['2'];
                $next_en = $ex_no + 1;
                $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
                $doc_no = $doc_type.'/'.$enquiry_tracking_doc_year.'/'.$next_doc_no;
            }

            date_default_timezone_set("Asia/Calcutta");
            $tracking_date = date('Y-m-d');
            $tracking_status = 1;
            $tracking_record = $old_ticket_number.' Closed By team due to'.$management_decision.'And new ticket'.$ticket_number.'created by team';
            $next_action = 'Contact Customer.';
            $action_due_date = date('Y-m-d', strtotime('+1 days'));

            $tracking_data = array('ticket_id' => $ticket_lastid , 'tracking_number' => $doc_no , 'tracking_date' => $tracking_date , 'tracking_record' => $tracking_record , 'next_action' => $next_action , 'action_due_date' => $action_due_date , 'user_id' => $user_id , 'status' => $tracking_status);

            $this->db->insert('tracking_master', $tracking_data);
            $tracking_lastid = $this->db->insert_id();

            $data = site_url('update_ticket_data'.'/'.$ticket_lastid);
            echo $data;
        }else{

            $data = site_url('update_ticket_data'.'/'.$refrance_ticket_id);
            echo $data;
        }
    }



    public function update_all_ticket_data()
    {
        $entity_id = $this->uri->segment(2);

        $this->db->select('*');
        $this->db->from('ticket_master');
        $where = '(ticket_master.entity_id = "'.$entity_id.'")';
        $this->db->where($where);
        $query = $this->db->get();
        $query_result = $query->row_array();

        $status = $query_result['status'];
        // print_r($status);
        // exit();

        if($status == 1 || $status == 2 || $status == 3 || $status == 4)
        {
            $data['entity_id'] = $entity_id;
            $ticket_data = $this->ticket_register_model->get_ticket_details_by_id_model($entity_id);
            $data['ticket_result'] = $ticket_data;
            /* $data['customer_list'] = $this->enquiry_register_model->get_customer_list();
            $data['product_list'] = $this->ticket_register_model->get_product_list();*/
            $this->load->view('support/ticket_register/vw_all_ticket_update',$data);
        }else{
                $data = site_url('dashboard');
                header("location:$data");
        }
    }



    public function update_all_ticket()
    {
        $entity_id = $this->input->post('entity_id');
        $user_id = $_SESSION['user_id'];
        $tracking_descrption = $this->input->post('tracking_descrption');
       
        $this->db->select('ticket_master.*');
        $this->db->from('ticket_master');
        $this->db->where('entity_id', $entity_id);
        $query = $this->db->get();
        $query_result = $query->row_array();

        if(!empty($tracking_descrption))
        {
            $tracking_date = $this->input->post('tracking_date');
            $tracking_descrption = $this->input->post('tracking_descrption');
            $status = 1;
            $tracking_next_action = $this->input->post('tracking_next_action');

            if(!empty($tracking_next_action))
            {
                $next_action = $tracking_next_action;
            }else{
                $next_action = "Call Tommarrow";
            }

            $action_due_date = $this->input->post('action_due_date');

            if(!empty($action_due_date))
            {
                $new_action_due_date = $action_due_date;
            }else{
                $new_action_due_date = date($tracking_date ,strtotime('+3 day'));
            }

            $this->db->select('tracking_number');
            $this->db->from('tracking_master');
            $this->db->order_by('entity_id', 'DESC');
            $this->db->limit(1);
            $enquiry_register = $this->db->get();
            $results_enquiry_tracking_register = $enquiry_register->result_array();

            $this->db->select('*');
            $this->db->from('tracking_master');
            $where_or = '(ticket_id = "'.$entity_id.'")';
            $this->db->where($where_or);
            $tracking_master= $this->db->get();
            $tracking_master_count =  $tracking_master->num_rows();
            $tracking_master_result = $tracking_master->row_array();

            if(!empty($results_enquiry_tracking_register))
            {
                $enquiry_tracking_serial_no = $results_enquiry_tracking_register[0]['tracking_number'];
                $enquiry_tracking_data_seprate = explode('/', $enquiry_tracking_serial_no);
                $enquiry_tracking_doc_year = $enquiry_tracking_data_seprate['1'];
            }

            $this->db->select('document_series_no');
            $this->db->from('documentseries_master');
            $this->db->where('entity_id=2');
            $doc_record=$this->db->get();
            $results_doc_record = $doc_record->result_array();

            $doc_serial_no = $results_doc_record[0]['document_series_no'];
            $doc_data_seprate = explode('/', $doc_serial_no);
            $doc_year = $doc_data_seprate['1'];

            if(empty($results_enquiry_tracking_register[0]['tracking_number']) || ($enquiry_tracking_doc_year != $doc_year))
            {
                $first_no = '0001';
                $doc_no = $doc_serial_no.$first_no;
            }elseif(!empty($results_enquiry_tracking_register) && ($enquiry_tracking_doc_year == $doc_year))
            {
                $doc_type = $enquiry_tracking_data_seprate['0'];
                $ex_no = $enquiry_tracking_data_seprate['2'];
                $next_en = $ex_no + 1;
                $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
                $doc_no = $doc_type.'/'.$enquiry_tracking_doc_year.'/'.$next_doc_no;
            }

            $tracking_data = array('ticket_id' => $entity_id , 'tracking_number' => $doc_no , 'tracking_date' => $tracking_date , 'tracking_record' => $tracking_descrption , 'next_action' => $next_action , 'action_due_date' => $new_action_due_date , 'user_id' => $user_id , 'status' => $status);

            $this->db->insert('tracking_master', $tracking_data);
            $tracking_lastid = $this->db->insert_id();

            $data = array(); 
            $errorUploadType = $statusMsg = ''; 

            if(!empty($_FILES['tracking_attachment']['name']) && count(array_filter($_FILES['tracking_attachment']['name'])) > 0){ 
                $filesCount = count($_FILES['tracking_attachment']['name']); 

                for($i = 0; $i < $filesCount; $i++){ 
                    $_FILES['file']['name']     = $_FILES['tracking_attachment']['name'][$i]; 
                    $_FILES['file']['type']     = $_FILES['tracking_attachment']['type'][$i]; 
                    $_FILES['file']['tmp_name'] = $_FILES['tracking_attachment']['tmp_name'][$i]; 
                    $_FILES['file']['error']     = $_FILES['tracking_attachment']['error'][$i]; 
                    $_FILES['file']['size']     = $_FILES['tracking_attachment']['size'][$i]; 
                     
                    // File upload configuration 
                    $uploadPath = 'assets/tracking_attachment/'; 
                    $config['upload_path'] = $uploadPath; 
                    $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf'; 
                     
                    // Load and initialize upload library 
                    $this->load->library('upload', $config); 
                    $this->upload->initialize($config); 

                    // Upload file to server 
                    if($this->upload->do_upload('file')){ 
                        // Uploaded file data 
                        $fileData = $this->upload->data(); 
                        $uploadData[$i]['attachment'] = $fileData['file_name']; 
                        $uploadData[$i]['uploaded_on'] = date("Y-m-d H:i:s"); 
                        $uploadData[$i]['tracking_id'] = $tracking_lastid;
                        $uploadData[$i]['ticket_id'] = $entity_id;
                    }else{  
                        $errorUploadType .= $_FILES['file']['name'].' | '; 
                    } 
                } 
                 
                $errorUploadType = !empty($errorUploadType)?'<br/>File Type Error: '.trim($errorUploadType, ' | '):''; 
                if(!empty($uploadData)){ 
                    // Insert files data into the database 
                    $insert = $this->ticket_register_model->insert($uploadData); 
                     
                    // Upload status message 
                    $statusMsg = $insert?'Files uploaded successfully!'.$errorUploadType:'Some problem occurred, please try again.'; 
                }else{ 
                    $statusMsg = "Sorry, there was an error uploading your file.".$errorUploadType; 
                } 
            }else{ 
                $statusMsg = 'Please select image files to upload.'; 
            } 
        }
        $entity_id = $this->input->post('entity_id');
        /*$ticket_type = $this->input->post('ticket_type');*/
        $product_make = $this->input->post('product_make');
        $product_name = $this->input->post('product_name');
        $product_code = $this->input->post('product_code');
        /*$warrantee_status = $this->input->post('warrantee_status');*/
        $invoice_number = $this->input->post('invoice_number');
        $invoice_date = $this->input->post('invoice_date');
        $product_srno = $this->input->post('product_srno');
        $ticket_descrption = $this->input->post('ticket_descrption');
        $ticket_status = $this->input->post('ticket_status');
        $rejected_reason = $this->input->post('rejected_reason');
        $close_date = $this->input->post('close_date');

        $data = array('entity_id ' => $entity_id , 'product_make' => $product_make , 'product_name' => $product_name , 'product_code' => $product_code , 'invoice_number' => $invoice_number , 'invoice_date' => $invoice_date , 'product_serial_number' => $product_srno , 'ticket_record' => $ticket_descrption , 'attachment' => $ticket_attachment_img , 'user_id' => $user_id , 'status' => $ticket_status , 'management_decision' => $rejected_reason , 'close_date' => $close_date);

        $where = '(entity_id ="'.$entity_id.'")';
        $this->db->where($where);
        $this->db->update('ticket_master',$data);
        redirect('vw_all_ticket_data');
        // if($ticket_type == 1)
        // {
        //     redirect('vw_ticket_warrantee_claims_data');
        // }elseif($ticket_type == 2)
        // {
        //     redirect('vw_ticket_paid_service_data');
        // }elseif($ticket_type == 3)
        // {
        //     redirect('vw_ticket_technical_support_data');
        // }
    }
}
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ob_start();
class Pre_dispatch_register extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('pre_dispatch_register_model');
        $this->load->library('session');
    }

    public function index()
    {
        $data['pre_dispatch_details'] = $this->pre_dispatch_register_model->get_pre_dispatch_details();
        $this->load->view('support/pre_dispatch_register/vw_pre_dispatch_index',$data);
    }

    public function create()
    {
        $data['state_list'] = $this->pre_dispatch_register_model->get_state_list();
        $data['customer_list'] = $this->pre_dispatch_register_model->get_customer_list();
        $this->load->view('support/pre_dispatch_register/vw_pre_dispatch_create',$data);
    }

    public function save_pre_dispatch()
    {
        $user_id = $_SESSION['user_id'];
        $customer_id = $this->input->post('customer_id');
        $contact_id = $this->input->post('contact_id');
        $product_make = $this->input->post('product_make');
        $product_name = $this->input->post('product_name');
        $serial_number = $this->input->post('serial_number');
        $invoice_number = $this->input->post('invoice_number');
        $comment = $this->input->post('comment');

        date_default_timezone_set("Asia/Calcutta");
        $date = date('Y-m-d');
        $date_time = date("Y-m-d H:i:s");
        $status = 1;

        $data = array('customer_id' => $customer_id , 'contact_person_id' => $contact_id , 'product_make' => $product_make , 'product_name' => $product_name , 'serial_number' => $serial_number , 'invoice_number' => $invoice_number , 'comment' => $comment , 'user_id' => $user_id , 'status' => $status);

        $this->db->insert('predispatch_master', $data);
        $predispatch_lastid = $this->db->insert_id();

        $data = array(); 
        $errorUploadType = $statusMsg = ''; 

        if(!empty($_FILES['attachment']['name']) && count(array_filter($_FILES['attachment']['name'])) > 0){ 
            $filesCount = count($_FILES['attachment']['name']); 

            for($i = 0; $i < $filesCount; $i++){ 
                $_FILES['file']['name']     = $_FILES['attachment']['name'][$i]; 
                $_FILES['file']['type']     = $_FILES['attachment']['type'][$i]; 
                $_FILES['file']['tmp_name'] = $_FILES['attachment']['tmp_name'][$i]; 
                $_FILES['file']['error']     = $_FILES['attachment']['error'][$i]; 
                $_FILES['file']['size']     = $_FILES['attachment']['size'][$i]; 
                 
                // File upload configuration 
                $uploadPath = 'assets/predispatch_attachment/'; 
                $config['upload_path'] = $uploadPath; 
                $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf'; 
                 
                // Load and initialize upload library 
                $this->load->library('upload', $config); 
                $this->upload->initialize($config); 

                // Upload file to server 
                if($this->upload->do_upload('file')){ 
                    // Uploaded file data 
                    $fileData = $this->upload->data(); 
                    $uploadData[$i]['attachment_name'] = $fileData['file_name']; 
                    $uploadData[$i]['uploaded_on'] = date("Y-m-d H:i:s"); 
                    $uploadData[$i]['predispatch_id'] = $predispatch_lastid;
                }else{  
                    $errorUploadType .= $_FILES['file']['name'].' | '; 
                } 
            } 
             
            $errorUploadType = !empty($errorUploadType)?'<br/>File Type Error: '.trim($errorUploadType, ' | '):''; 
            if(!empty($uploadData)){ 
                // Insert files data into the database 
                $insert = $this->pre_dispatch_register_model->insert($uploadData); 
                 
                // Upload status message 
                $statusMsg = $insert?'Files uploaded successfully!'.$errorUploadType:'Some problem occurred, please try again.'; 
            }else{ 
                $statusMsg = "Sorry, there was an error uploading your file.".$errorUploadType; 
            } 
        }else{ 
            $statusMsg = 'Please select image files to upload.'; 
        }

        redirect('vw_predispatch_data'); 
    }

    public function update_predispatch()
    {
        $entity_id = $this->uri->segment(2);

        $data['entity_id'] = $entity_id;
        $this->load->view('support/pre_dispatch_register/vw_pre_dispatch_update',$data);
    }

    public function get_details_by_id()
    {
        $entity_id = $this->input->post('entity_id',TRUE);
        $data = $this->pre_dispatch_register_model->get_details_by_id_model($entity_id)->result();
        echo json_encode($data);
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

    public function delete_attachment()
    {
        $data = $this->uri->segment(2);
        $entity_id = $this->input->post('id');

        $this->db->select('attachment_name');
        $this->db->from('predispatch_attachment');
        $where = '(predispatch_attachment.entity_id = "'.$entity_id.'")';
        $this->db->where($where);
        $attachment_check = $this->db->get();
        $attachment_check_result = $attachment_check->row_array();

        $image_name = $attachment_check_result['attachment_name'];

        unlink("assets/predispatch_attachment/".$image_name);

        $this->db->where('entity_id', $entity_id);
        $result = $this->db->delete('predispatch_attachment'); 

        echo json_encode($result);
    }

    
    public function update_pre_dispatch()
    {
        $user_id = $_SESSION['user_id'];

        $entity_id = $this->input->post('entity_id');
        $product_make = $this->input->post('product_make');
        $product_name = $this->input->post('product_name');
        $serial_number = $this->input->post('serial_number');
        $invoice_number = $this->input->post('invoice_number');
        $comment = $this->input->post('comment');

        $data = array('product_make' => $product_make , 'product_name' => $product_name , 'serial_number' => $serial_number , 'invoice_number' => $invoice_number , 'comment' => $comment , 'user_id' => $user_id);

        $where = '(entity_id ="'.$entity_id.'")';
        $this->db->where($where);
        $this->db->update('predispatch_master',$data);

        $data = array(); 
        $errorUploadType = $statusMsg = ''; 

        if(!empty($_FILES['attachment']['name']) && count(array_filter($_FILES['attachment']['name'])) > 0){ 
            $filesCount = count($_FILES['attachment']['name']); 

            for($i = 0; $i < $filesCount; $i++){ 
                $_FILES['file']['name']     = $_FILES['attachment']['name'][$i]; 
                $_FILES['file']['type']     = $_FILES['attachment']['type'][$i]; 
                $_FILES['file']['tmp_name'] = $_FILES['attachment']['tmp_name'][$i]; 
                $_FILES['file']['error']     = $_FILES['attachment']['error'][$i]; 
                $_FILES['file']['size']     = $_FILES['attachment']['size'][$i]; 
                 
                // File upload configuration 
                $uploadPath = 'assets/predispatch_attachment/'; 
                $config['upload_path'] = $uploadPath; 
                $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf'; 
                 
                // Load and initialize upload library 
                $this->load->library('upload', $config); 
                $this->upload->initialize($config); 

                // Upload file to server 
                if($this->upload->do_upload('file')){ 
                    // Uploaded file data 
                    $fileData = $this->upload->data(); 
                    $uploadData[$i]['attachment_name'] = $fileData['file_name']; 
                    $uploadData[$i]['uploaded_on'] = date("Y-m-d H:i:s"); 
                    $uploadData[$i]['predispatch_id'] = $entity_id;
                }else{  
                    $errorUploadType .= $_FILES['file']['name'].' | '; 
                } 
            } 
             
            $errorUploadType = !empty($errorUploadType)?'<br/>File Type Error: '.trim($errorUploadType, ' | '):''; 
            if(!empty($uploadData)){ 
                // Insert files data into the database 
                $insert = $this->pre_dispatch_register_model->insert($uploadData); 
                 
                // Upload status message 
                $statusMsg = $insert?'Files uploaded successfully!'.$errorUploadType:'Some problem occurred, please try again.'; 
            }else{ 
                $statusMsg = "Sorry, there was an error uploading your file.".$errorUploadType; 
            } 
        }else{ 
            $statusMsg = 'Please select image files to upload.'; 
        }

        redirect('vw_predispatch_data'); 
    }

    public function view_predispatch()
    {
        $entity_id = $this->uri->segment(2);

        $data['entity_id'] = $entity_id;
        $this->load->view('support/pre_dispatch_register/vw_pre_dispatch_view',$data);
    }
}
?>
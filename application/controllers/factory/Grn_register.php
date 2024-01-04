<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ob_start();

class Grn_register extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('grn_register_model');
        $this->load->library('session');
    }

    public function index()
    {
        $data['grn_details'] = $this->grn_register_model->get_all_grn_details();
        $this->load->view('factory/grn_register/vw_grn_register_index',$data);
    }

    public function create()
    {
        $data['state_list'] = $this->grn_register_model->get_state_list();
        $data['vender_details'] = $this->grn_register_model->get_all_vender_details();
        $data['customer_list'] = $this->grn_register_model->get_customer_list();
        $this->load->view('factory/grn_register/vw_grn_register_create',$data);
    }

    public function save_grn()
    {
    	$user_id = $_SESSION['user_id'];

    	$vender_id = $this->input->post('vender_id');
    	$grn_date = $this->input->post('grn_date');
    	$invoice_number = $this->input->post('invoice_number');
		$document_date = $this->input->post('document_date');
		$document_description = $this->input->post('document_description');
		$invoice_amount = $this->input->post('invoice_amount');

        $this->db->select('grn_no');
        $this->db->from('grn_register');
        $this->db->order_by('entity_id', 'DESC');
        $this->db->limit(1);
        $grn_register_data = $this->db->get();
        $results_grn_register = $grn_register_data->result_array();

        if(!empty($results_grn_register))
        {
            $grn_serial_no = $results_grn_register[0]['grn_no'];
            $grn_data_seprate = explode('/', $grn_serial_no);
            $grn_doc_year = $grn_data_seprate['1'];
        }

        $this->db->select('document_series_no');
        $this->db->from('documentseries_master');
        $where = '(documentseries_master.entity_id = "'.'11'.'")';
        $this->db->where($where);
        $doc_record=$this->db->get();
        $results_doc_record = $doc_record->result_array();

        $doc_serial_no = $results_doc_record[0]['document_series_no'];
        $doc_data_seprate = explode('/', $doc_serial_no);
        $doc_year = $doc_data_seprate['1'];

        if(empty($results_grn_register[0]['grn_no']) || ($grn_doc_year != $doc_year))
        {
            $first_no = '0001';
            $doc_no = $doc_serial_no.$first_no;
        }elseif(!empty($results_grn_register) && ($grn_doc_year == $doc_year))
        {
            $doc_type = $grn_data_seprate['0'];
            $ex_no = $grn_data_seprate['2'];
            $next_en = $ex_no + 1;
            $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
            $doc_no = $doc_type.'/'.$grn_doc_year.'/'.$next_doc_no;
        }

        date_default_timezone_set("Asia/Calcutta");
        $current_time = date('h:i:sa');

		$data = array('boq_status' => 1 , 'grn_no' => $doc_no , 'grn_date' => $grn_date , 'grn_time' => $current_time , 'vendor_id' => $vender_id , 'document_date' => $document_date , 'document_description' => $document_description , 'grn_amount' => $invoice_amount , 'invoice_number' => $invoice_number , 'grn_created_by' => $user_id , 'status' => 2);

        $this->db->insert('grn_register', $data);
        $grn_lastid = $this->db->insert_id();

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
                $uploadPath = 'assets/grn_attachment/'; 
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
                    $uploadData[$i]['grn_id'] = $grn_lastid;
                }else{  
                    $errorUploadType .= $_FILES['file']['name'].' | '; 
                } 
            } 
             
            $errorUploadType = !empty($errorUploadType)?'<br/>File Type Error: '.trim($errorUploadType, ' | '):''; 
            if(!empty($uploadData)){ 
                // Insert files data into the database 
                $insert = $this->grn_register_model->insert($uploadData); 
                 
                // Upload status message 
                $statusMsg = $insert?'Files uploaded successfully!'.$errorUploadType:'Some problem occurred, please try again.'; 
            }else{ 
                $statusMsg = "Sorry, there was an error uploading your file.".$errorUploadType; 
            } 
        }else{ 
            $statusMsg = 'Please select image files to upload.'; 
        }

        redirect('vw_goods_receipt_note_data');
    }

    public function update()
    {
        $entity_id = $this->uri->segment(2);
        $data['entity_id'] = $entity_id;
        $data['vender_details'] = $this->grn_register_model->get_all_vender_details();
        $this->load->view('factory/grn_register/vw_grn_register_update',$data);
    }

    public function get_details_by_id()
    {
        $entity_id = $this->input->post('entity_id',TRUE);
        $data = $this->grn_register_model->get_details_by_id_model($entity_id)->result();
        echo json_encode($data);
    }

    public function delete_attachment()
    {
        $data = $this->uri->segment(2);
        $entity_id = $this->input->post('id');

        $this->db->select('attachment_name');
        $this->db->from('grn_attachment');
        $where = '(grn_attachment.entity_id = "'.$entity_id.'")';
        $this->db->where($where);
        $attachment_check = $this->db->get();
        $attachment_check_result = $attachment_check->row_array();

        $image_name = $attachment_check_result['attachment_name'];

        unlink("assets/grn_attachment/".$image_name);

        $this->db->where('entity_id', $entity_id);
        $result = $this->db->delete('grn_attachment'); 

        echo json_encode($result);
    }

    public function update_grn()
    {
    	$user_id = $_SESSION['user_id'];
    	$entity_id = $this->input->post('entity_id');
    	$vender_id = $this->input->post('vender_id');
    	$grn_date = $this->input->post('grn_date');
    	$invoice_number = $this->input->post('invoice_number');
		$document_date = $this->input->post('document_date');
		$document_description = $this->input->post('document_description');
		$invoice_amount = $this->input->post('invoice_amount');

        date_default_timezone_set("Asia/Calcutta");
        $current_time = date('h:i:sa');

		$data = array('grn_date' => $grn_date , 'grn_time' => $current_time , 'vendor_id' => $vender_id , 'document_date' => $document_date , 'document_description' => $document_description , 'grn_amount' => $invoice_amount , 'invoice_number' => $invoice_number , 'grn_created_by' => $user_id);

        $where = '(entity_id ="'.$entity_id.'")';
        $this->db->where($where);
        $this->db->update('grn_register',$data);

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
                $uploadPath = 'assets/grn_attachment/'; 
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
                    $uploadData[$i]['grn_id'] = $entity_id;
                }else{  
                    $errorUploadType .= $_FILES['file']['name'].' | '; 
                } 
            } 
             
            $errorUploadType = !empty($errorUploadType)?'<br/>File Type Error: '.trim($errorUploadType, ' | '):''; 
            if(!empty($uploadData)){ 
                // Insert files data into the database 
                $insert = $this->grn_register_model->insert($uploadData); 
                 
                // Upload status message 
                $statusMsg = $insert?'Files uploaded successfully!'.$errorUploadType:'Some problem occurred, please try again.'; 
            }else{ 
                $statusMsg = "Sorry, there was an error uploading your file.".$errorUploadType; 
            } 
        }else{ 
            $statusMsg = 'Please select image files to upload.'; 
        }

        redirect('vw_goods_receipt_note_data');
    }

    public function view()
    {
        $entity_id = $this->uri->segment(2);
        $data['entity_id'] = $entity_id;
        $data['vender_details'] = $this->grn_register_model->get_all_vender_details();
        $this->load->view('factory/grn_register/vw_grn_register_view',$data);
    }

    public function add_vender()
    {
        $vender_name = $this->input->post('vender_name');
        $address = $this->input->post('address');
        $state_id = $this->input->post('state_id');
        $city_id = $this->input->post('city_id');
        $state_code = $this->input->post('state_code');
        $pin_code = $this->input->post('pin_code');
        $gst_number = $this->input->post('gst_number');
        $phone_number = $this->input->post('phone_number');
        $contact_person = $this->input->post('contact_person');
        $email_id = $this->input->post('email_id');
        $contact_number = $this->input->post('contact_number');

        $data = array('vendor_name' => $vender_name , 'email_id' => $email_id , 'phone_no' => $phone_number , 'mobile_no' => $contact_number , 'contact_person' => $contact_person , 'address' => $address , 'state_id' => $state_id , 'city_id' => $city_id , 'pin_code' => $pin_code , 'state_code' => $state_code , 'gst_no' => $gst_number , 'status' => 1);

        $this->db->insert('vendor_master', $data);
        $vender_lastid = $this->db->insert_id();

        echo $vender_lastid;
    }

    public function save_and_create_challan()
    {
        $vender_id = $this->input->post('vender_id');
        $grn_date = $this->input->post('grn_date');
        $invoice_number = $this->input->post('invoice_number');
        $document_date = $this->input->post('document_date');
        $document_description = $this->input->post('document_description');
        $invoice_amount = $this->input->post('invoice_amount');
        $customer_id = $this->input->post('customer_id');

        $user_id = $_SESSION['user_id'];
        $user_name = $_SESSION['full_name'];

        $this->db->select('grn_no');
        $this->db->from('grn_register');
        $this->db->order_by('entity_id', 'DESC');
        $this->db->limit(1);
        $grn_register_data = $this->db->get();
        $results_grn_register = $grn_register_data->result_array();

        if(!empty($results_grn_register))
        {
            $grn_serial_no = $results_grn_register[0]['grn_no'];
            $grn_data_seprate = explode('/', $grn_serial_no);
            $grn_doc_year = $grn_data_seprate['1'];
        }

        $this->db->select('document_series_no');
        $this->db->from('documentseries_master');
        $where = '(documentseries_master.entity_id = "'.'11'.'")';
        $this->db->where($where);
        $doc_record=$this->db->get();
        $results_doc_record = $doc_record->result_array();

        $doc_serial_no = $results_doc_record[0]['document_series_no'];
        $doc_data_seprate = explode('/', $doc_serial_no);
        $doc_year = $doc_data_seprate['1'];

        if(empty($results_grn_register[0]['grn_no']) || ($grn_doc_year != $doc_year))
        {
            $first_no = '0001';
            $doc_no = $doc_serial_no.$first_no;
        }elseif(!empty($results_grn_register) && ($grn_doc_year == $doc_year))
        {
            $doc_type = $grn_data_seprate['0'];
            $ex_no = $grn_data_seprate['2'];
            $next_en = $ex_no + 1;
            $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
            $doc_no = $doc_type.'/'.$grn_doc_year.'/'.$next_doc_no;
        }

        date_default_timezone_set("Asia/Calcutta");
        $current_time = date('h:i:sa');
        $current_date = date('Y-m-d');

        $this->db->select('grn_no');
        $this->db->from('grn_register');
        $where = '(grn_register.grn_no = "'.$doc_no.'")';
        $this->db->where($where);
        $grn_register=$this->db->get();
        $grn_register_count = $grn_register->num_rows();

        if($grn_register_count == 0)
        {
            $grn_data = array('boq_status' => 1 , 'grn_no' => $doc_no , 'grn_date' => $grn_date , 'grn_time' => $current_time , 'vendor_id' => $vender_id , 'document_date' => $document_date , 'document_description' => $document_description , 'grn_amount' => $invoice_amount , 'invoice_number' => $invoice_number , 'grn_created_by' => $user_id , 'status' => 2);

            $this->db->insert('grn_register', $grn_data);
            $grn_lastid = $this->db->insert_id();

            $this->db->select('mi_no');
            $this->db->from('material_issue_master');
            $this->db->order_by('entity_id', 'DESC');
            $this->db->limit(1);
            $material_issue_master_data = $this->db->get();
            $results_material_issue_master = $material_issue_master_data->result_array();

            if(!empty($results_material_issue_master))
            {
                $mi_serial_no = $results_material_issue_master[0]['mi_no'];
                $mi_data_seprate = explode('/', $mi_serial_no);
                $mi_doc_year = $mi_data_seprate['1'];
            }

            $this->db->select('document_series_no');
            $this->db->from('documentseries_master');
            $where = '(documentseries_master.entity_id = "'.'12'.'")';
            $this->db->where($where);
            $doc_record=$this->db->get();
            $results_doc_record = $doc_record->result_array();

            $doc_serial_no = $results_doc_record[0]['document_series_no'];
            $doc_data_seprate = explode('/', $doc_serial_no);
            $doc_year = $doc_data_seprate['1'];

            if(empty($results_material_issue_master[0]['mi_no']) || ($mi_doc_year != $doc_year))
            {
                $first_no = '0001';
                $mi_doc_no = $doc_serial_no.$first_no;
            }elseif(!empty($results_material_issue_master) && ($mi_doc_year == $doc_year))
            {
                $doc_type = $mi_data_seprate['0'];
                $ex_no = $mi_data_seprate['2'];
                $next_en = $ex_no + 1;
                $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
                $mi_doc_no = $doc_type.'/'.$mi_doc_year.'/'.$next_doc_no;
            }

            $mi_data = array('grn_id' => $grn_lastid , 'boq_status' => 1 , 'customer_id' => $customer_id , 'mi_no' => $mi_doc_no , 'mi_date' => $current_date , 'grn_amount' => $invoice_amount , 'paid_amount' => 0 , 'balance_amount' => $invoice_amount , 'material_issue_created_by' => $user_name , 'user_id' => $user_id , 'status' => 1);

            $this->db->insert('material_issue_master', $mi_data);
            $mi_lastid = $this->db->insert_id();

            echo $mi_lastid;
        }else{

            $grn_register_data = $grn_register->row_array();

            $last_grn_id = $grn_register_data['entity_id'];

            $this->db->select('*');
            $this->db->from('material_issue_master');
            $where = '(material_issue_master.grn_id = "'.$last_grn_id.'" And material_issue_master.status = "'.'1'.'")';
            $this->db->where($where);
            $material_issue_master=$this->db->get();
            $material_issue_master_data = $material_issue_master->row_array();

            $last_mi_id = $material_issue_master_data['entity_id'];

            echo $last_mi_id;
        }  
    }
}
?>
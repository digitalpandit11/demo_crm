<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ob_start();
class Demo_test_register extends CI_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('demo_test_register_model');
        $this->load->library('session');
    }

	public function index()
	{
        $data['demo_test_result'] = $this->demo_test_register_model->get_demo_test_details();
		$this->load->view('support/demo_test_register/vw_demo_test_index',$data);
	}

    public function create()
    {
        $data['product_category'] = $this->demo_test_register_model->get_product_category();
        $this->load->view('support/demo_test_register/vw_demo_test_create',$data);
    }

    public function save_demo_test()
    {
        $category_id = $this->input->post('category_id');
        $test_name = $this->input->post('test_name');
        $product_make = $this->input->post('product_make');
        $product_name = $this->input->post('product_name');
        $user_id = $_SESSION['user_id'];

        $data = array('category_id' => $category_id , 'test_name' => $test_name , 'product_make' => $product_make , 'product_name' => $product_name , 'user_id' => $user_id , 'status' => 1);
        /*$result = $this->demo_test_register_model->save_demo_test_model($data);*/

        $this->db->insert('demo_test_master', $data);
        $demotest_lastid = $this->db->insert_id();

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
                $uploadPath = 'assets/demotest_attachment/'; 
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
                    $uploadData[$i]['demo_test_id'] = $demotest_lastid;
                }else{  
                    $errorUploadType .= $_FILES['file']['name'].' | '; 
                } 
            } 
             
            $errorUploadType = !empty($errorUploadType)?'<br/>File Type Error: '.trim($errorUploadType, ' | '):''; 
            if(!empty($uploadData)){ 
                // Insert files data into the database 
                $insert = $this->demo_test_register_model->insert($uploadData); 
                 
                // Upload status message 
                $statusMsg = $insert?'Files uploaded successfully!'.$errorUploadType:'Some problem occurred, please try again.'; 
            }else{ 
                $statusMsg = "Sorry, there was an error uploading your file.".$errorUploadType; 
            } 
        }else{ 
            $statusMsg = 'Please select image files to upload.'; 
        }

        redirect('vw_demotest_data');
    }

    public function update_demotest()
    {
        $entity_id = $this->uri->segment(2);

        $data['entity_id'] = $entity_id;
        $data['product_category'] = $this->demo_test_register_model->get_product_category();
        $this->load->view('support/demo_test_register/vw_demo_test_update',$data);
    }

    public function get_details_by_id()
    {
        $entity_id = $this->input->post('entity_id',TRUE);
        $data = $this->demo_test_register_model->get_details_by_id_model($entity_id)->result();
        echo json_encode($data);
    }

    public function delete_attachment()
    {
        $data = $this->uri->segment(2);
        $entity_id = $this->input->post('id');

        $this->db->select('attachment_name');
        $this->db->from('demotest_attachment');
        $where = '(demotest_attachment.entity_id = "'.$entity_id.'")';
        $this->db->where($where);
        $attachment_check = $this->db->get();
        $attachment_check_result = $attachment_check->row_array();

        $image_name = $attachment_check_result['attachment_name'];

        unlink("assets/demotest_attachment/".$image_name);

        $this->db->where('entity_id', $entity_id);
        $result = $this->db->delete('demotest_attachment'); 

        echo json_encode($result);
    }

    public function edit_demo_test()
    {
        $user_id = $_SESSION['user_id'];

        $entity_id = $this->input->post('entity_id');

        $category_id = $this->input->post('category_id');
        $test_name = $this->input->post('test_name');
        $product_make = $this->input->post('product_make');
        $product_name = $this->input->post('product_name');

        $data = array('category_id' => $category_id , 'test_name' => $test_name , 'product_make' => $product_make , 'product_name' => $product_name , 'user_id' => $user_id);

        $where = '(entity_id ="'.$entity_id.'")';
        $this->db->where($where);
        $this->db->update('demo_test_master',$data);

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
                $uploadPath = 'assets/demotest_attachment/'; 
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
                    $uploadData[$i]['demo_test_id'] = $entity_id;
                }else{  
                    $errorUploadType .= $_FILES['file']['name'].' | '; 
                } 
            } 
             
            $errorUploadType = !empty($errorUploadType)?'<br/>File Type Error: '.trim($errorUploadType, ' | '):''; 
            if(!empty($uploadData)){ 
                // Insert files data into the database 
                $insert = $this->demo_test_register_model->insert($uploadData); 
                 
                // Upload status message 
                $statusMsg = $insert?'Files uploaded successfully!'.$errorUploadType:'Some problem occurred, please try again.'; 
            }else{ 
                $statusMsg = "Sorry, there was an error uploading your file.".$errorUploadType; 
            } 
        }else{ 
            $statusMsg = 'Please select image files to upload.'; 
        }

        redirect('vw_demotest_data');
    }

    public function view_demotest()
    {
        $entity_id = $this->uri->segment(2);

        $data['entity_id'] = $entity_id;
        $data['product_category'] = $this->demo_test_register_model->get_product_category();
        $this->load->view('support/demo_test_register/vw_demo_test_view',$data);
    }
}
?>
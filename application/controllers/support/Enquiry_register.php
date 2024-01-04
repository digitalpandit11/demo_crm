<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ob_start();
class Enquiry_register extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('enquiry_register_model');
        $this->load->library('session');
    }

    public function index()
    {
        $data['enquiry_details'] = $this->enquiry_register_model->get_enquiry_details();
        $data['vender_details'] = $this->enquiry_register_model->get_vender_details();
        $this->load->view('support/enquiry_register/vw_enquiry_register_index',$data);
    }

    public function vw_all_enquiry_data()
    {
        $user_id = $_SESSION['user_id'];
        $data['enquiry_details'] = $this->enquiry_register_model->get_all_enquiry_details($user_id);
        $this->load->view('support/enquiry_register/vw_all_enquiry_register_index',$data);
    }

    public function create()
    {
        $data['state_list'] = $this->enquiry_register_model->get_state_list();
        $data['customer_list'] = $this->enquiry_register_model->get_customer_list();
        $data['employee_list'] = $this->enquiry_register_model->get_employee_list();
        $data['product_list'] = $this->enquiry_register_model->get_product_list();
        $this->load->view('support/enquiry_register/vw_enquiry_register_create',$data);
    }

    public function get_contact_person()
    {
        $customer_id = $this->input->post('id',TRUE);
        $data = $this->enquiry_register_model->get_contact_person_data($customer_id)->result();
         echo json_encode($data);
    }

    public function get_all_customer_data()
    {
        $data = $this->input->post();
        if(!empty($data))
        {
            $contact_id = $this->input->post('id');
            $data = $this->enquiry_register_model->get_all_data_by_customer_id($contact_id);
            echo json_encode([$data]);
        }
    }

    public function save_enquiry()
    {
        if(!empty($_FILES['enquiry_attachment']))
        {
            $enquiry_attachment_img = "";
            foreach ($_FILES as $key => $value) {
                
                $file_name = $value['name'];
                $file_source_path = $value['tmp_name'];
                $file_upload_combine_array = array_combine($file_name, $file_source_path);
                //print_r($file_upload_combine_array);
                
                foreach ($file_upload_combine_array as $image_name=> $image_source_path) {
                    // echo $k. ' '. $a ;

                    $ext = pathinfo($image_name,PATHINFO_EXTENSION);

                    $enquiry_attachment_upload = substr(str_replace(" ", "_", $image_name), 0);
                    move_uploaded_file($image_source_path, 'assets/enquiry_attachment/'.$enquiry_attachment_upload);

                    $enquiry_attachment_img .= $enquiry_attachment_upload.',';
                }  
            }
        }else{
            $enquiry_attachment_img = NULL;
        }

        $this->db->select('enquiry_no');
        $this->db->from('enquiry_register');
        $this->db->order_by('enquiry_register.entity_id', 'DESC');
        $this->db->limit(1);
        $enquiry_register = $this->db->get();
        $results_enquiry_register = $enquiry_register->result_array();

        if(!empty($results_enquiry_register[0]['enquiry_no']))
        {
            $enquiry_serial_no = $results_enquiry_register[0]['enquiry_no'];
            $enquiry_data_seprate = explode('/', $enquiry_serial_no);
        }

        $this->db->select('document_series_no');
        $this->db->from('documentseries_master');
        $where = '(documentseries_master.entity_id = "'.'6'.'")';
        $this->db->where($where);
        $doc_record=$this->db->get();
        $results_doc_record = $doc_record->result_array();
        
        $doc_serial_no = $results_doc_record[0]['document_series_no'];
        $doc_data_seprate = explode('/', $doc_serial_no);

        if(empty($results_enquiry_register[0]['enquiry_no']))
        {
            $first_no = '0001';
            $enquiry_number = $doc_serial_no.$first_no;
        }
        elseif(!empty($results_enquiry_register))
        {

            $doc_type = $enquiry_data_seprate['0'];
            $second_type = $enquiry_data_seprate['1'];
            $ex_no = $enquiry_data_seprate['2'];
            $next_en = $ex_no + 1;
            $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
            $enquiry_number = $doc_type.'/'.$second_type.'/'.$next_doc_no;
        }
        
        $user_id = $_SESSION['user_id'];
        $customer_id = $this->input->post('customer_id');
        $contact_id = $this->input->post('contact_id');
        $enquiry_descrption = $this->input->post('enquiry_descrption');
        $enquiry_type = $this->input->post('enquiry_type');
        $enquiry_source = $this->input->post('enquiry_source');
        $enquiry_urgency = $this->input->post('enquiry_urgency');

        /*$enquiry_product = $this->input->post('enquiry_product');*/

        date_default_timezone_set("Asia/Calcutta");
        $enquiry_date = date('Y-m-d');
        $system_date_time = date("Y-m-d H:i:s");
        $enquiry_status = 1;

        $data = array('enquiry_no ' => $enquiry_number , 'enquiry_long_desc' => $enquiry_descrption , 'customer_id' => $customer_id , 'contact_id' => $contact_id , 'enquiry_type' => $enquiry_type , 'enquiry_source' => $enquiry_source , 'enquiry_urgency' => $enquiry_urgency , 'enquiry_date' => $enquiry_date , 'enquiry_status' => $enquiry_status , 'attachment' => $enquiry_attachment_img , 'user_id' => $user_id);

        $result = $this->enquiry_register_model->save_enquiry_model($data);

        redirect('vw_enquiry_data');
    }

    public function update_enquiry_data()
    {
        $entity_id = $this->uri->segment(2);

        $data['entity_id'] = $entity_id;
        $enquiry_data = $this->enquiry_register_model->get_enquiry_details_by_id_model($entity_id);
        $data['enquiry_result'] = $enquiry_data;
       /* $data['customer_list'] = $this->enquiry_register_model->get_customer_list();*/
        $data['product_list'] = $this->enquiry_register_model->get_product_list();
        $this->load->view('support/enquiry_register/vw_enquiry_register_update',$data);

    }

    public function get_enquiry_details_by_id(){
        $entity_id = $this->input->post('entity_id',TRUE);
        $data = $this->enquiry_register_model->get_enquiry_details_by_id_model($entity_id)->result();
        echo json_encode($data);
    }

    public function get_enquiry_product_by_id()
    {
          $entity_id = $this->input->post('entity_id',TRUE);
          $data = $this->enquiry_register_model->get_enquiry_product_by_id($entity_id)->result();
          echo json_encode($data);
    }

    public function update_enquiry()
    {
        if(!empty($_FILES['employee_attachment']['name']))
        {
            $entity_id = $this->input->post('entity_id');

            $attachment_img = "";
            foreach ($_FILES as $key => $value) {
                
                $file_name = $value['name'];
                $file_source_path = $value['tmp_name'];
                $file_upload_combine_array = array_combine($file_name, $file_source_path);
                //print_r($file_upload_combine_array);
                
                foreach ($file_upload_combine_array as $image_name=> $image_source_path) {
                    // echo $k. ' '. $a ;

                    $ext = pathinfo($image_name,PATHINFO_EXTENSION);

                    $employee_attachment_upload = substr(str_replace(" ", "_", $image_name), 0);
                    move_uploaded_file($image_source_path, 'assets/enquiry_attachment/'.$employee_attachment_upload);

                    $attachment_img .= $employee_attachment_upload.',';
                }  
            }

            $this->db->select('attachment');
            $this->db->from('enquiry_register');
            $where = '(enquiry_register.entity_id = "'.$entity_id.'" )';
            $this->db->where($where);
            $attachment_check = $this->db->get();
            $attachment_check_result = $attachment_check->row_array();

            if(!empty($attachment_check_result))
            {
                $employee_attachment_img = $attachment_check_result['attachment'].$attachment_img;
            }else{
                $employee_attachment_img = $attachment_img;
            } 

            $enquiry_descrption = $this->input->post('enquiry_descrption');
            $enquiry_type = $this->input->post('enquiry_type');
            $enquiry_source = $this->input->post('enquiry_source');
            $enquiry_urgency = $this->input->post('enquiry_urgency'); 
            $enquiry_status = $this->input->post('enquiry_status'); 
            $rejected_reason = $this->input->post('rejected_reason'); 

            /*$enquiry_product = $this->input->post('enquiry_product');*/

            $data = array('entity_id'=> $entity_id , 'enquiry_long_desc' => $enquiry_descrption , 'enquiry_type' => $enquiry_type , 'enquiry_source' => $enquiry_source , 'enquiry_urgency' => $enquiry_urgency , 'enquiry_status' => $enquiry_status , 'attachment' => $employee_attachment_img , 'enquiry_cancel_reason' => $rejected_reason);

            $result = $this->enquiry_register_model->update_enquiry_model($data);

            /*$this->db->select('*');
            $this->db->from('enquiry_product');
            $where = '(enquiry_id = "'.$entity_id.'")';
            $this->db->where($where);
            $enquiry_product_r= $this->db->get();
            $enquiry_product_count =  $enquiry_product_r->num_rows();
            $enquiry_product_data = $enquiry_product_r->result_array();

            if(!empty($enquiry_product))
            {
                if($enquiry_product_count > 0)
                {
                    foreach ($enquiry_product_data as $key => $value) 
                    {
                        $enquiry_product_id = $value['entity_id'];
                        $this->db->where('entity_id', $enquiry_product_id);
                        $this->db->delete('enquiry_product');
                    }
                }
                    
                foreach ($enquiry_product as $key => $value) 
                {
                   $product_id = $value;

                   $enquiry_product_array = array('enquiry_id' => $entity_id , 'product_id' => $product_id);
                    $this->db->insert('enquiry_product',$enquiry_product_array);
                }
            }elseif(!empty($enquiry_product_data)){
                foreach ($enquiry_product_data as $key => $value) 
                {
                    $enquiry_product_id = $value['entity_id'];
                    $this->db->where('entity_id', $enquiry_product_id);
                    $this->db->delete('enquiry_product');
                }
            }*/

            redirect('vw_enquiry_data'); 
        }else{
            $entity_id = $this->input->post('entity_id');

            $enquiry_descrption = $this->input->post('enquiry_descrption');
            $enquiry_type = $this->input->post('enquiry_type');
            $enquiry_source = $this->input->post('enquiry_source');
            $enquiry_urgency = $this->input->post('enquiry_urgency'); 
            $enquiry_status = $this->input->post('enquiry_status');  
            $rejected_reason = $this->input->post('rejected_reason');

            /*$enquiry_product = $this->input->post('enquiry_product');*/

            $data = array('entity_id'=> $entity_id , 'enquiry_long_desc' => $enquiry_descrption , 'enquiry_type' => $enquiry_type , 'enquiry_source' => $enquiry_source , 'enquiry_urgency' => $enquiry_urgency , 'enquiry_status' => $enquiry_status , 'enquiry_cancel_reason' => $rejected_reason);

            $result = $this->enquiry_register_model->update_enquiry_model($data);

            /*$this->db->select('*');
            $this->db->from('enquiry_product');
            $where = '(enquiry_id = "'.$entity_id.'")';
            $this->db->where($where);
            $enquiry_product_r= $this->db->get();
            $enquiry_product_count =  $enquiry_product_r->num_rows();
            $enquiry_product_data = $enquiry_product_r->result_array();

            if(!empty($enquiry_product))
            {
                if($enquiry_product_count > 0)
                {
                    foreach ($enquiry_product_data as $key => $value) 
                    {
                        $enquiry_product_id = $value['entity_id'];
                        $this->db->where('entity_id', $enquiry_product_id);
                        $this->db->delete('enquiry_product');
                    }
                }
                    
                foreach ($enquiry_product as $key => $value) 
                {
                    $product_id = $value;

                    $enquiry_product_array = array('enquiry_id' => $entity_id , 'product_id' => $product_id);
                    $this->db->insert('enquiry_product',$enquiry_product_array);
                }
            }elseif(!empty($enquiry_product_data)){
                foreach ($enquiry_product_data as $key => $value) 
                {
                    $enquiry_product_id = $value['entity_id'];
                    $this->db->where('entity_id', $enquiry_product_id);
                    $this->db->delete('enquiry_product');
                }
            }*/

            redirect('vw_enquiry_data');
        }
    }

    public function delete_enquiry_data()
    {
        $entity_id = $this->uri->segment(2);
        $data = $this->enquiry_register_model->delete_enquiry_model($entity_id);
        redirect('vw_enquiry_data');
    }

    public function view_enquiry_data()
    {
        $entity_id = $this->uri->segment(2);

        $data['entity_id'] = $entity_id;
        $enquiry_data = $this->enquiry_register_model->get_enquiry_details_by_id_model($entity_id);
        $data['enquiry_result'] = $enquiry_data;
        $data['product_list'] = $this->enquiry_register_model->get_product_list();
        $this->load->view('support/enquiry_register/vw_enquiry_register_view',$data);
    }

    public function delete_enquiry_attach_image()
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
            $this->db->from('enquiry_register');
            $where = '(enquiry_register.entity_id = "'.$entity_id.'")';
            $this->db->where($where);
            $attachment_check = $this->db->get();
            $attachment_check_result = $attachment_check->row_array();

            $attachment_data = $attachment_check_result['attachment'];

            $delete_image = NULL;
            $replaced_data =  str_replace($image_name_db,$delete_image,$attachment_data);

            $image_attachment_new_array = array('attachment' => $replaced_data);
            $where = '(entity_id ="'.$entity_id.'")';
            $this->db->where($where);
            $this->db->update('enquiry_register',$image_attachment_new_array);

            unlink("assets/enquiry_attachment/".$image_name);
            redirect('update_enquiry_data'.'/'.$entity_id); 
        }
    }
}
?>
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
ob_start();
class Enquiry_register extends CI_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('enquiry_register_model');
        $this->load->library('session');
        $this->load->library('email');
    }

	public function index()
	{
        /*$data['enquiry_details'] = $this->enquiry_register_model->get_enquiry_details();
		$this->load->view('sales/enquiry_register/vw_enquiry_register_index',$data);*/
        $this->load->view('sales/enquiry_register/vw_enquiry_register_index');
	}

    public function vw_all_enquiry_data()
    {
        $data['enquiry_details'] = $this->enquiry_register_model->get_all_enquiry_details();
        $this->load->view('sales/enquiry_register/vw_all_enquiry_register_index',$data);
    }
    
    public function vw_old_enquiry_data()
    {
        $data['enquiry_details'] = $this->enquiry_register_model->get_all_old_enquiry_details();
        $this->load->view('sales/enquiry_register/vw_old_enquiry_register_index',$data);
    }

    public function get_ajax_enquiry_data()
    {   
        $user_id = $_SESSION['user_id'];
        $emp_id = $_SESSION['emp_id'];
        $table = "old_lead_master";
        // Table's primary key
        $primaryKey = 'entity_id';
        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database, while the `dt`
        // parameter represents the DataTables column identifier. In this case simple
        // indexes

        $columns = array(
            array( 'db' => '`old_lead_master`.`entity_id`',    'dt' => 0,  'field' => 'entity_id'),
            array( 'db' => '`old_lead_master`.`lead_date`', 'dt' => 1, 'field' => 'lead_date','formatter' => function( $d, $row ) {
                    return date( 'd-m-Y', strtotime($d));
                } 
            ),
            array( 'db' => '`old_lead_master`.`customer_name`', 'dt' => 2, 'field' => 'customer_name'),
            array( 'db' => '`old_lead_master`.`first_name`', 'dt' =>3, 'field' => 'first_name'),
            array( 'db' => '`old_lead_master`.`aaddress`', 'dt' => 4, 'field' => 'aaddress'),
            array( 'db' => '`old_lead_master`.`state`', 'dt' => 5, 'field' => 'state' ),
            array( 'db' => '`old_lead_master`.`city`', 'dt' => 6, 'field' => 'city' ),
            array( 'db' => '`old_lead_master`.`description`', 'dt' => 7, 'field' => 'description'),
            array( 'db' => '`old_lead_master`.`lead_source`', 'dt' => 8, 'field' => 'lead_source'),
            array( 'db' => '`old_lead_master`.`lead_source_description`', 'dt' => 9, 'field' => 'lead_source_description'),
            array( 'db' => '`old_lead_master`.`status`', 'dt' => 10, 'field' => 'status'),
        );
        // SQL server connection information

        // $sql_details = array(
        //     'user' => 'root',
        //     'pass' => '',
        //     'db'   => 'demo_crm',
        //     'host' => 'localhost'
        // );

        $sql_details = array(
           'user' => 'u117003035_vbtek',
            'pass' => 'S@14vbtek',
            'db' => 'u117003035_demo_crm',
            'host' => 'localhost'
        );
         
         
        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         * If you just want to use the basic configuration for DataTables with PHP
         * server-side, there is no need to edit below this line.
         */
        
        include APPPATH . 'third_party/datatable_ssp_class/ssp.php';

        $joinQuery = "FROM `{$table}`";
        $extraCondition = "";
        $groupBy = "";

        echo json_encode(
            SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns,$joinQuery, $extraCondition,$groupBy)
        );
    }
    
    public function create()
    {
        $customer_id = $this->uri->segment(2);

        if(!empty($customer_id))
        {
            $data['customer_id'] = $customer_id;
        }else{
            $data['customer_id'] = NULL;
        }

        $data['state_list'] = $this->enquiry_register_model->get_state_list();
        $data['customer_list'] = $this->enquiry_register_model->get_customer_list();
        $data['customer_contact_list'] = $this->enquiry_register_model->get_contact_list();
        $data['employee_list'] = $this->enquiry_register_model->get_employee_list();
        $data['source_list'] = $this->enquiry_register_model->get_source_list();
        //$data['enquiry_number'] = $this->enquiry_register_model->get_enquiry_number();
        $this->load->view('sales/enquiry_register/vw_enquiry_register_create',$data);
    }

    public function get_all_customer_data()
    {
        $data = $this->input->post();
        if(!empty($data))
        {
            $customer_id = $this->input->post('id');
            $data = $this->enquiry_register_model->get_all_data_by_customer_id($customer_id);
            echo json_encode([$data]);
        }
    }

    public function save_enquiry()
    {
        /*if(!empty($_FILES['employee_attachment']))
        {
            $ext = pathinfo($_FILES['employee_attachment']['name'],PATHINFO_EXTENSION);
            $employee_attachment_upload = substr(str_replace(" ", "_", $_FILES['employee_attachment']['name']), 0);
            move_uploaded_file($_FILES["employee_attachment"]["tmp_name"], 'assets/enquiry_attachment/'.$employee_attachment_upload);
            $employee_attachment_img = $_FILES['employee_attachment']['name'];  
        }else{
            $employee_attachment_img = NULL;
        }*/

        
        if(!empty($_FILES['employee_attachment']))
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

        // $enquiry_number = $this->input->post('enquiry_number');
        $customer_id = $this->input->post('customer_id');
        $contact_id = $this->input->post('customer_name');
        $employee_id = $this->input->post('employee_id');
        $enquiry_descrption = $this->input->post('enquiry_descrption');
        $enquiry_type = $this->input->post('enquiry_type');
        $enquiry_source = $this->input->post('enquiry_source');
        $enquiry_urgency = $this->input->post('enquiry_urgency');

        $this->db->select('enquiry_no');
        $this->db->from('enquiry_register');
        $this->db->order_by('entity_id', 'DESC');
        $this->db->limit(1);
        $enquiry_register = $this->db->get();
        $results_enquiry_register = $enquiry_register->result_array();

        $this->db->select('document_series_no');
        $this->db->from('documentseries_master');
        $this->db->where('entity_id=2');
        $doc_record=$this->db->get();
        $results_doc_record = $doc_record->result_array();

        $doc_serial_noss = $results_doc_record[0]['document_series_no'];
        // print_r($doc_serial_no);
        // die();

        $doc_data_seprate = explode('-', $doc_serial_noss);


        // $doc_year_data = $doc_data_seprate['2'].'-'.$doc_data_seprate['3'];
        // $doc_year_data_seprate = explode('/', $doc_year_data);
        // $doc_year = $doc_year_data_seprate['0'];

        if(empty($results_enquiry_register[0]['enquiry_no']))
        {
            if($enquiry_type == 1){
                $enquiry_type_inital = 'MH';

            }elseif($enquiry_type == 2){
                $enquiry_type_inital = 'PS';

            }elseif($enquiry_type == 3){
                $enquiry_type_inital = 'VC';

            }elseif($enquiry_type == 4){
                $enquiry_type_inital = 'TD';

            }elseif($enquiry_type == 5){
                $enquiry_type_inital = 'OT';

            }

            $first_no = '0001';
            $doc_no = $doc_serial_noss.''.$enquiry_type_inital.'/'.$first_no;


            // print_r($first_doc_no);
            // die();
            // return $first_doc_no;
        }

        if(!empty($results_enquiry_register[0]['enquiry_no']))
        {
        
        $en_serial_no = $results_enquiry_register[0]['enquiry_no'];
        

        $en_offer_data_seprate = explode('/', $en_serial_no);
        
        $enquiry_first_char = $en_offer_data_seprate['0'];
        $enquiry_second_char = $en_offer_data_seprate['1'];
        $next_en = $enquiry_second_char + 1;
        $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
        $enquiry_first_char_seprate = explode('-', $enquiry_first_char);
        // print_r($enquiry_first_char_seprate);
        // die();

        if($enquiry_type == 1){
            $enquiry_type_inital = 'MH';

        }elseif($enquiry_type == 2){
            $enquiry_type_inital = 'PS';

        }elseif($enquiry_type == 3){
            $enquiry_type_inital = 'VC';

        }elseif($enquiry_type == 4){
            $enquiry_type_inital = 'TD';

        }elseif($enquiry_type == 5){
            $enquiry_type_inital = 'OT';

        }

        $doc_no = $enquiry_first_char_seprate['0'].'-'. $enquiry_first_char_seprate['1'].'-'.$enquiry_type_inital.'/'.$next_doc_no;
        // print_r($doc_no);
        // die();
    }

        
        date_default_timezone_set("Asia/Calcutta");
        $enquiry_date = date('Y-m-d');
        $enquiry_status = 1;

        $data = array('enquiry_no' => $doc_no , 'enquiry_short_desc' => $enquiry_descrption , 'customer_id' => $customer_id , 'contact_person_id' => $contact_id , 'emp_id' => $employee_id , 'enquiry_type' => $enquiry_type , 'enquiry_source' => $enquiry_source , 'enquiry_urgency' => $enquiry_urgency , 'enquiry_date' => $enquiry_date , 'enquiry_status' => $enquiry_status , 'attachment' => $enquiry_attachment_img);

        $result = $this->enquiry_register_model->save_enquiry_model($data);

        redirect('vw_enquiry_data');
    }

    public function update_enquiry_data()
    {
        $entity_id = $this->uri->segment(2);
        $data['entity_id'] = $entity_id;
        $enquiry_data = $this->enquiry_register_model->get_enquiry_details_by_id_model($entity_id);
        $data['enquiry_result'] = $enquiry_data;
        $data['customer_contact_list'] = $this->enquiry_register_model->get_contact_list();
        $data['customer_list'] = $this->enquiry_register_model->get_customer_list();
        $data['employee_list'] = $this->enquiry_register_model->get_employee_list();
        $data['source_list'] = $this->enquiry_register_model->get_source_list();

        $this->load->view('sales/enquiry_register/vw_enquiry_register_update',$data);
    }

    public function get_enquiry_details_by_id(){
        $entity_id = $this->input->post('entity_id',TRUE);
        $data = $this->enquiry_register_model->get_enquiry_details_by_id_model($entity_id)->result();
        echo json_encode($data);
    }

    public function update_enquiry()
    {
        $enquiry_entity_id = $this->input->post('entity_id');
        $customer_id = $this->input->post('customer_name');
        
        $enquiry_tracking_descrption = $this->input->post('enquiry_tracking_descrption');

        if(!empty($enquiry_tracking_descrption))
        {
            $enquiry_tracking_date = $this->input->post('enquiry_tracking_date');
            $enquiry_tracking_descrption = $this->input->post('enquiry_tracking_descrption');
            $status = 2;
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
                $new_action_due_date = date($enquiry_tracking_date ,strtotime('+3 day'));
            }

            $user_id = $_SESSION['user_id'];  

            $this->db->select('tracking_number');
            $this->db->from('enquiry_tracking_master');
            $this->db->order_by('entity_id', 'DESC');
            $this->db->limit(1);
            $enquiry_register = $this->db->get();
            $results_enquiry_tracking_register = $enquiry_register->result_array();

            $this->db->select('*');
            $this->db->from('enquiry_tracking_master');
            $where_or = '(enquiry_id = "'.$enquiry_entity_id.'" AND status = 1)';
            $this->db->where($where_or);
            $enquiry_tracking_master= $this->db->get();
            $enquiry_tracking_master_count =  $enquiry_tracking_master->num_rows();
            $enquiry_tracking_master_master = $enquiry_tracking_master->row_array();

            if($enquiry_tracking_master_count === 0)
            {

                if(!empty($results_enquiry_tracking_register))
                {
                    $enquiry_tracking_serial_no = $results_enquiry_tracking_register[0]['tracking_number'];
                    $enquiry_tracking_data_seprate = explode('/', $enquiry_tracking_serial_no);
                    $enquiry_tracking_doc_year = $enquiry_tracking_data_seprate['1'];
                }

                $this->db->select('document_series_no');
                $this->db->from('documentseries_master');
                $this->db->where('entity_id=7');
                $doc_record=$this->db->get();
                $results_doc_record = $doc_record->result_array();

                $doc_serial_no = $results_doc_record[0]['document_series_no'];
                $doc_data_seprate = explode('/', $doc_serial_no);
                $doc_year = $doc_data_seprate['1'];

                if(empty($results_enquiry_tracking_register[0]['tracking_number']) || ($enquiry_tracking_doc_year != $doc_year))
                {
                    $first_no = '0001';
                    $doc_no = $doc_serial_no.$first_no;
                    //return $doc_no;
                }elseif(!empty($results_enquiry_tracking_register) && ($enquiry_tracking_doc_year == $doc_year))
                {
                    $doc_type = $enquiry_tracking_data_seprate['0'];
                    $ex_no = $enquiry_tracking_data_seprate['2'];
                    $next_en = $ex_no + 1;
                    $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
                    $doc_no = $doc_type.'/'.$enquiry_tracking_doc_year.'/'.$next_doc_no;
                    //return $doc_no;
                }

                $enquiry_data_enquiry_track_save = "INSERT INTO enquiry_tracking_master (user_id , tracking_number , enquiry_id , customer_id , tracking_date , tracking_record , next_action , action_due_date , status) VALUES ('".$user_id."' , '".$doc_no."' , '".$enquiry_entity_id."' , '".$customer_id."' , '".$enquiry_tracking_date."' , '".$enquiry_tracking_descrption."' , '".$next_action."' , '".$new_action_due_date."' , '".$status."')";
                $save_execute = $this->db->query($enquiry_data_enquiry_track_save);
            }else{
                $tracking_id = $enquiry_tracking_master_master['entity_id'];

                $update_array = array('enquiry_id' => $enquiry_entity_id , 'customer_id' => $customer_id , 'tracking_date' => $enquiry_tracking_date , 'tracking_record' => $enquiry_tracking_descrption , 'next_action' => $next_action , 'action_due_date' => $new_action_due_date , 'status' => $status);
                $where = '(entity_id ="'.$tracking_id.'")';
                $this->db->where($where);
                $this->db->update('enquiry_tracking_master',$update_array);
            }
        }

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

            /*$ext = pathinfo($_FILES['employee_attachment']['name'],PATHINFO_EXTENSION);
            $employee_attachment_upload = substr(str_replace(" ", "_", $_FILES['employee_attachment']['name']), 0);
            move_uploaded_file($_FILES["employee_attachment"]["tmp_name"], 'assets/enquiry_attachment/'.$employee_attachment_upload);
            $employee_attachment_img = $_FILES['employee_attachment']['name'];*/ 

            $customer_id = $this->input->post('customer_id');
            $contact_person_id = $this->input->post('customer_name');
            $employee_id = $this->input->post('employee_id');
            $enquiry_descrption = $this->input->post('enquiry_descrption');
            $enquiry_type = $this->input->post('enquiry_type');
            $enquiry_source = $this->input->post('enquiry_source');
            $enquiry_urgency = $this->input->post('enquiry_urgency'); 
            $enquiry_status = $this->input->post('enquiry_status');  
            $enquiry_rejected_reason = $this->input->post('enquiry_rejected_reason');


            $data = array('entity_id'=> $entity_id , 'enquiry_short_desc' => $enquiry_descrption , 'customer_id' => $customer_id , 'contact_person_id' => $contact_person_id , 'emp_id' => $employee_id , 'enquiry_type' => $enquiry_type , 'enquiry_source' => $enquiry_source , 'enquiry_urgency' => $enquiry_urgency , 'enquiry_status' => $enquiry_status , 'attachment' => $employee_attachment_img, 'enquiry_rejected_reason' => $enquiry_rejected_reason);

            $result = $this->enquiry_register_model->update_enquiry_model($data);
            redirect('vw_enquiry_data'); 
        }else{
            $entity_id = $this->input->post('entity_id');
            $customer_id = $this->input->post('customer_id');
            $contact_person_id = $this->input->post('customer_name');
            $employee_id = $this->input->post('employee_id');
            $enquiry_descrption = $this->input->post('enquiry_descrption');
            $enquiry_type = $this->input->post('enquiry_type');
            $enquiry_source = $this->input->post('enquiry_source');
            $enquiry_urgency = $this->input->post('enquiry_urgency'); 
            $enquiry_status = $this->input->post('enquiry_status');  

            $data = array('entity_id'=> $entity_id , 'enquiry_short_desc' => $enquiry_descrption , 'customer_id' => $customer_id , 'contact_person_id' => $contact_person_id , 'emp_id' => $employee_id , 'enquiry_type' => $enquiry_type , 'enquiry_source' => $enquiry_source , 'enquiry_urgency' => $enquiry_urgency , 'enquiry_status' => $enquiry_status);

            $result = $this->enquiry_register_model->update_enquiry_model($data);
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
        $data['customer_contact_list'] = $this->enquiry_register_model->get_contact_list();
        $data['customer_list'] = $this->enquiry_register_model->get_customer_list();
        $data['employee_list'] = $this->enquiry_register_model->get_employee_list();
        $data['source_list'] = $this->enquiry_register_model->get_source_list();
        $this->load->view('sales/enquiry_register/vw_enquiry_register_view',$data);
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

    public function vw_indiamartenquiry_data()
    {
        $data['enquiry_details'] = $this->enquiry_register_model->get_indiamartenquiry_details();
        $this->load->view('sales/enquiry_register/vw_indiamartenquiry_index',$data);
    }

    public function create_customer_indiamartenquiry()
    {
        $data['state_list'] = $this->enquiry_register_model->get_state_list();
        // $data['customer_list'] = $this->enquiry_register_model->get_customer_list();
         $data['employee_list'] = $this->enquiry_register_model->get_employee_list();
        //$data['enquiry_number'] = $this->enquiry_register_model->get_enquiry_number();
        $this->load->view('sales/enquiry_register/vw_indiamartenquiry_create',$data);
    }


    public function save_indiamart_enquiry()
    {
        /*if(!empty($_FILES['employee_attachment']))
        {
            $ext = pathinfo($_FILES['employee_attachment']['name'],PATHINFO_EXTENSION);
            $employee_attachment_upload = substr(str_replace(" ", "_", $_FILES['employee_attachment']['name']), 0);
            move_uploaded_file($_FILES["employee_attachment"]["tmp_name"], 'assets/enquiry_attachment/'.$employee_attachment_upload);
            $employee_attachment_img = $_FILES['employee_attachment']['name'];  
        }else{
            $employee_attachment_img = NULL;
        }*/

        if(!empty($_FILES['employee_attachment']))
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

        // $enquiry_number = $this->input->post('enquiry_number');
        //$customer_id = $this->input->post('customer_name');
        $customer_name = $this->input->post('customer_name');
        $status = 1;

        $customer_master_array = array('customer_name' => $customer_name, 'status' => $status);

        $this->db->insert('customer_master', $customer_master_array);
        $customer_master_lastid = $this->db->insert_id();

        $enquiry_contact_person = $this->input->post('enquiry_contact_person');
        $enquiry_email_id = $this->input->post('enquiry_email_id');
        $enquiry_contact_number = $this->input->post('enquiry_contact_number');
        $state_id = $this->input->post('state_id');
        $city_id = $this->input->post('city_id');
        $state_code = $this->input->post('state_code');
        $address_type_one = 1;
        $address_type_two = 2;
        $enquiry_customer_city = $this->input->post('enquiry_customer_city');

        $customer_address_master_array_one = array('customer_id'=> $customer_master_lastid, 'state_id' => $state_id, 'city_id'=> $city_id, 'address_type' => $address_type_one, 'state_code' => $state_code);
        $this->db->insert('customer_address_master', $customer_address_master_array_one);
        $customer_address_master_lastid_one = $this->db->insert_id();

        $customer_address_master_array = array('customer_id'=> $customer_master_lastid, 'state_id' => $state_id, 'city_id'=> $city_id, 'address_type' => $address_type_two, 'state_code' => $state_code);
        $this->db->insert('customer_address_master', $customer_address_master_array);
        $customer_address_master_lastid_two = $this->db->insert_id();


        $customer_contact_master_array_one = array('customer_id'=> $customer_master_lastid,'customer_address_id'=> $customer_address_master_lastid_one, 'contact_person'=> $enquiry_contact_person, 'email_id'=> $enquiry_email_id, 'first_contact_no'=> $enquiry_contact_number);
        $this->db->insert('customer_contact_master', $customer_contact_master_array_one);

        $customer_contact_master_array_two = array('customer_id'=> $customer_master_lastid,'customer_address_id'=> $customer_address_master_lastid_two, 'contact_person'=> $enquiry_contact_person, 'email_id'=> $enquiry_email_id, 'first_contact_no'=> $enquiry_contact_number);
        $this->db->insert('customer_contact_master', $customer_contact_master_array_two);



        $employee_id = $this->input->post('employee_id');
        $enquiry_descrption = $this->input->post('enquiry_descrption');
        $enquiry_type = $this->input->post('enquiry_type');
        $enquiry_source = 1;
        $enquiry_urgency = $this->input->post('enquiry_urgency');

        $this->db->select('enquiry_no');
        $this->db->from('enquiry_register');
        $this->db->order_by('entity_id', 'DESC');
        $this->db->limit(1);
        $enquiry_register = $this->db->get();
        $results_enquiry_register = $enquiry_register->result_array();

        $this->db->select('document_series_no');
        $this->db->from('documentseries_master');
        $this->db->where('entity_id=2');
        $doc_record=$this->db->get();
        $results_doc_record = $doc_record->result_array();

        $doc_serial_no = $results_doc_record[0]['document_series_no'];
        
        $doc_data_seprate = explode('-', $doc_serial_no);



        // $doc_year_data = $doc_data_seprate['2'].'-'.$doc_data_seprate['3'];
        // $doc_year_data_seprate = explode('/', $doc_year_data);
        // $doc_year = $doc_year_data_seprate['0'];

        if(empty($results_enquiry_register[0]['enquiry_no']))
        {
            if($enquiry_type == 1){
                $enquiry_type_inital = 'MH';

            }elseif($enquiry_type == 2){
                $enquiry_type_inital = 'PS';

            }elseif($enquiry_type == 3){
                $enquiry_type_inital = 'VC';

            }elseif($enquiry_type == 4){
                $enquiry_type_inital = 'TD';

            }elseif($enquiry_type == 5){
                $enquiry_type_inital = 'OT';

            }

            $first_no = '0001';
            $doc_no = $doc_serial_no.$enquiry_type_inital.'/'.$first_no;


            // print_r($first_doc_no);
            // die();
            // return $first_doc_no;
        }

        if(!empty($results_enquiry_register[0]['enquiry_no']))
        {
        
        $en_serial_no = $results_enquiry_register[0]['enquiry_no'];
        

        $en_offer_data_seprate = explode('/', $en_serial_no);
        
        $enquiry_first_char = $en_offer_data_seprate['0'];
        $enquiry_second_char = $en_offer_data_seprate['1'];
        $next_en = $enquiry_second_char + 1;
        $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
        $enquiry_first_char_seprate = explode('-', $enquiry_first_char);
        // print_r($enquiry_first_char_seprate);
        // die();

        if($enquiry_type == 1){
            $enquiry_type_inital = 'MH';

        }elseif($enquiry_type == 2){
            $enquiry_type_inital = 'PS';

        }elseif($enquiry_type == 3){
            $enquiry_type_inital = 'VC';

        }elseif($enquiry_type == 4){
            $enquiry_type_inital = 'TD';

        }elseif($enquiry_type == 5){
            $enquiry_type_inital = 'OT';

        }

        $doc_no = $enquiry_first_char_seprate['0'].'-'. $enquiry_first_char_seprate['1'].'-'.$enquiry_type_inital.'/'.$next_doc_no;
        }
        

        
        date_default_timezone_set("Asia/Calcutta");
        $enquiry_date = date('Y-m-d');
        $enquiry_status = 1;

        $data = array('enquiry_no ' => $doc_no , 'enquiry_short_desc' => $enquiry_descrption , 'customer_id' => $customer_master_lastid , 'emp_id' => $employee_id , 'enquiry_type' => $enquiry_type , 'enquiry_source' => $enquiry_source , 'enquiry_urgency' => $enquiry_urgency , 'enquiry_date' => $enquiry_date , 'enquiry_status' => $enquiry_status , 'attachment' => $enquiry_attachment_img);

        $result = $this->enquiry_register_model->save_enquiry_model($data);

        redirect('vw_indiamartenquiry_data');
    }

    public function update_indiamart_enquiry_data()
    {
        $entity_id = $this->uri->segment(2);
        $data['entity_id'] = $entity_id;
        $enquiry_data = $this->enquiry_register_model->get_enquiry_details_by_id_model($entity_id);
        $data['enquiry_result'] = $enquiry_data;
        $data['customer_contact_list'] = $this->enquiry_register_model->get_contact_list();
        $data['customer_list'] = $this->enquiry_register_model->get_customer_list();
        $data['employee_list'] = $this->enquiry_register_model->get_employee_list();
        $this->load->view('sales/enquiry_register/vw_indiamart_enquiry_register_update',$data);
    }

    public function get_indiamart_enquiry_details_by_id(){
        $entity_id = $this->input->post('entity_id',TRUE);
        $data = $this->enquiry_register_model->get_indiamart_enquiry_details_by_id_model($entity_id)->result();
        echo json_encode($data);
    }

    public function update_indiamart_enquiry()
    {
        $enquiry_entity_id = $this->input->post('entity_id');
        $customer_id = $this->input->post('customer_id');
        
        $enquiry_tracking_descrption = $this->input->post('enquiry_tracking_descrption');

        if(!empty($enquiry_tracking_descrption))
        {
            $enquiry_tracking_date = $this->input->post('enquiry_tracking_date');
            $enquiry_tracking_descrption = $this->input->post('enquiry_tracking_descrption');
            $status = 2;
            $tracking_next_action = $this->input->post('tracking_next_action');

            if(!empty($tracking_next_action))
            {
                $next_action = $tracking_next_action;
            }else{
                $next_action = "";
            }

            $action_due_date = $this->input->post('action_due_date');

            if(!empty($action_due_date))
            {
                $new_action_due_date = $action_due_date;
            }else{
                $new_action_due_date = date($enquiry_tracking_date ,strtotime('+3 day'));
            }

            $user_id = $_SESSION['user_id'];  

            $this->db->select('tracking_number');
            $this->db->from('enquiry_tracking_master');
            $this->db->order_by('entity_id', 'DESC');
            $this->db->limit(1);
            $enquiry_register = $this->db->get();
            $results_enquiry_tracking_register = $enquiry_register->result_array();

            $this->db->select('*');
            $this->db->from('enquiry_tracking_master');
            $where_or = '(enquiry_id = "'.$enquiry_entity_id.'" AND status = 1)';
            $this->db->where($where_or);
            $enquiry_tracking_master= $this->db->get();
            $enquiry_tracking_master_count =  $enquiry_tracking_master->num_rows();
            $enquiry_tracking_master_master = $enquiry_tracking_master->row_array();

            if($enquiry_tracking_master_count === 0)
            {

                if(!empty($results_enquiry_tracking_register))
                {
                    $enquiry_tracking_serial_no = $results_enquiry_tracking_register[0]['tracking_number'];
                    $enquiry_tracking_data_seprate = explode('/', $enquiry_tracking_serial_no);
                    $enquiry_tracking_doc_year = $enquiry_tracking_data_seprate['1'];
                }

                $this->db->select('document_series_no');
                $this->db->from('documentseries_master');
                $this->db->where('entity_id=7');
                $doc_record=$this->db->get();
                $results_doc_record = $doc_record->result_array();

                $doc_serial_no = $results_doc_record[0]['document_series_no'];
                $doc_data_seprate = explode('/', $doc_serial_no);
                $doc_year = $doc_data_seprate['1'];

                if(empty($results_enquiry_tracking_register[0]['tracking_number']) || ($enquiry_tracking_doc_year != $doc_year))
                {
                    $first_no = '0001';
                    $doc_no = $doc_serial_no.$first_no;
                    //return $doc_no;
                }elseif(!empty($results_enquiry_tracking_register) && ($enquiry_tracking_doc_year == $doc_year))
                {
                    $doc_type = $enquiry_tracking_data_seprate['0'];
                    $ex_no = $enquiry_tracking_data_seprate['2'];
                    $next_en = $ex_no + 1;
                    $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
                    $doc_no = $doc_type.'/'.$enquiry_tracking_doc_year.'/'.$next_doc_no;
                    //return $doc_no;
                }

                $enquiry_data_enquiry_track_save = "INSERT INTO enquiry_tracking_master (user_id , tracking_number , enquiry_id , customer_id , tracking_date , tracking_record , next_action , action_due_date , status) VALUES ('".$user_id."' , '".$doc_no."' , '".$enquiry_entity_id."' , '".$customer_id."' , '".$enquiry_tracking_date."' , '".$enquiry_tracking_descrption."' , '".$next_action."' , '".$new_action_due_date."' , '".$status."')";
                $save_execute = $this->db->query($enquiry_data_enquiry_track_save);
            }else{
                $tracking_id = $enquiry_tracking_master_master['entity_id'];

                $update_array = array('enquiry_id' => $enquiry_entity_id , 'customer_id' => $customer_id , 'tracking_date' => $enquiry_tracking_date , 'tracking_record' => $enquiry_tracking_descrption , 'next_action' => $next_action , 'action_due_date' => $new_action_due_date , 'status' => $status);
                $where = '(entity_id ="'.$tracking_id.'")';
                $this->db->where($where);
                $this->db->update('enquiry_tracking_master',$update_array);
            }
        }

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

            /*$ext = pathinfo($_FILES['employee_attachment']['name'],PATHINFO_EXTENSION);
            $employee_attachment_upload = substr(str_replace(" ", "_", $_FILES['employee_attachment']['name']), 0);
            move_uploaded_file($_FILES["employee_attachment"]["tmp_name"], 'assets/enquiry_attachment/'.$employee_attachment_upload);
            $employee_attachment_img = $_FILES['employee_attachment']['name'];*/ 

            $employee_id = $this->input->post('employee_id');
            $enquiry_descrption = $this->input->post('enquiry_descrption');
            $enquiry_type = $this->input->post('enquiry_type');
            $enquiry_source = 1;
            $enquiry_status = $this->input->post('enquiry_status');  

            $data = array('entity_id'=> $entity_id , 'enquiry_short_desc' => $enquiry_descrption , 'emp_id' => $employee_id , 'enquiry_type' => $enquiry_type , 'enquiry_source' => $enquiry_source, 'enquiry_status' => $enquiry_status , 'attachment' => $employee_attachment_img);

            $result = $this->enquiry_register_model->update_enquiry_model($data);
            redirect('vw_indiamartenquiry_data'); 
        }else{
            $entity_id = $this->input->post('entity_id');
            $employee_id = $this->input->post('employee_id');
            $enquiry_descrption = $this->input->post('enquiry_descrption');
            $enquiry_type = $this->input->post('enquiry_type');
            $enquiry_source = $this->input->post('enquiry_source');
            $enquiry_urgency = $this->input->post('enquiry_urgency'); 
            $enquiry_status = $this->input->post('enquiry_status');  

            $data = array('entity_id'=> $entity_id , 'enquiry_short_desc' => $enquiry_descrption , 'emp_id' => $employee_id , 'enquiry_type' => $enquiry_type , 'enquiry_source' => $enquiry_source , 'enquiry_urgency' => $enquiry_urgency , 'enquiry_status' => $enquiry_status);

            $result = $this->enquiry_register_model->update_enquiry_model($data);
            redirect('vw_indiamartenquiry_data');
        }
    }

    public function get_all_ajax_enquiry_data()
    {   
        $user_id = $_SESSION['user_id'];
        $emp_id = $_SESSION['emp_id'];

        $table = "enquiry_register";
        // Table's primary key
        $primaryKey = 'entity_id';
        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database, while the `dt`
        // parameter represents the DataTables column identifier. In this case simple
        // indexes

        $columns = array(
            array( 'db' => '`enquiry_register`.`entity_id`',    'dt' => 0,  'field' => 'entity_id'),
            array( 'db' => '`enquiry_register`.`enquiry_date`', 'dt' => 1, 'field' => 'enquiry_date','formatter' => function( $d, $row ) {
                    return date( 'd-m-Y', strtotime($d));
                } 
            ),
            array( 'db' => '`enquiry_register`.`enquiry_no`', 'dt' => 2, 'field' => 'enquiry_no'),
            array( 'db' => '`enquiry_register`.`enquiry_short_desc`', 'dt' =>3, 'field' => 'enquiry_short_desc'),

            array( 'db' => '`enquiry_register`.`contact_person_id`', 'dt' => 4, 
                'formatter' => function( $d, $row ) 
                {
                   $contact_person_id = $row['4'];
                    if(!empty($contact_person_id))
                    {
                        $this->db->select('*');
                        $this->db->from('customer_contact_master');
                        $where = '(customer_contact_master.entity_id = "'.$contact_person_id.'")';
                        $this->db->where($where);
                        $customer_contact_master_query = $this->db->get();
                        $customer_contact_master_query_result = $customer_contact_master_query->row_array();
                        $customer_contact_master_num_rows = $customer_contact_master_query->num_rows();

                        if($customer_contact_master_num_rows)
                        {
                            $contact_person = $customer_contact_master_query_result['contact_person'];
                        }else{
                            $contact_person = '';
                        }

                        return $contact_person;
                    }else{
                        return 'NA';
                    }
                },'field' => 'contact_person_id'),

            array( 'db' => '`enquiry_register`.`contact_person_id`', 'dt' => 5, 
                'formatter' => function( $d, $row ) 
                {
                   $contact_person_id = $row['5'];
                    if(!empty($contact_person_id))
                    {
                        $this->db->select('*');
                        $this->db->from('customer_contact_master');
                        $where = '(customer_contact_master.entity_id = "'.$contact_person_id.'")';
                        $this->db->where($where);
                        $customer_contact_master_query = $this->db->get();
                        $customer_contact_master_query_result = $customer_contact_master_query->row_array();
                        $customer_contact_master_num_rows = $customer_contact_master_query->num_rows();

                        if($customer_contact_master_num_rows)
                        {
                        $first_contact_no = $customer_contact_master_query_result['first_contact_no'];
                        }else{
                            $first_contact_no = '';
                        }

                        return $first_contact_no;
                    }else{
                        return 'NA';
                    }
                },'field' => 'contact_person_id'),

            array( 'db' => '`enquiry_register`.`contact_person_id`', 'dt' => 6, 
                'formatter' => function( $d, $row ) 
                {
                   $contact_person_id = $row['6'];
                    if(!empty($contact_person_id))
                    {
                        $this->db->select('*');
                        $this->db->from('customer_contact_master');
                        $where = '(customer_contact_master.entity_id = "'.$contact_person_id.'")';
                        $this->db->where($where);
                        $customer_contact_master_query = $this->db->get();
                        $customer_contact_master_query_result = $customer_contact_master_query->row_array();
                        $customer_contact_master_num_rows = $customer_contact_master_query->num_rows();

                        if($customer_contact_master_num_rows)
                        {
                            $email_id = $customer_contact_master_query_result['email_id'];
                        }else{
                            $email_id ='';
                        }

                        return $email_id;
                    }else{
                        return 'NA';
                    }
                },'field' => 'contact_person_id'),

            array( 'db' => '`enquiry_register`.`enquiry_type`', 'dt' => 7, 
                'formatter' => function( $d, $row ) 
                {
                    $Enquiry_type = $row['7'];

                    if($Enquiry_type == 1)
                    {
                        $Enq_type = "Pull Cord (MH)";
                        return $Enq_type;
                    }elseif($Enquiry_type == 2)
                    {
                        $Enq_type = "Porximity (PS)";
                        return $Enq_type;
                    }elseif($Enquiry_type == 3)
                    {
                        $Enq_type = "Vibrator Control (VC)";
                        return $Enq_type;
                    }elseif($Enquiry_type == 4)
                    {
                        $Enq_type = "Treading (TD)";
                        return $Enq_type;
                    }elseif($Enquiry_type == 5)
                    {
                        $Enq_type = "Other (OT)";
                        return $Enq_type;
                    }elseif($Enquiry_type == 6)
                    {
                        $Enq_type = "CUH & TD-MH";
                        return $Enq_type;
                    }elseif($Enquiry_type == 7)
                    {
                        $Enq_type = "TD-PS";
                        return $Enq_type;
                    }elseif($Enquiry_type == 8)
                    {
                        $Enq_type = "TD-VC";
                        return $Enq_type;
                    }else{
                        return "NA";
                    }

                },'field' => 'enquiry_type'),

            array( 'db' => '`enquiry_register`.`enquiry_source`', 'dt' => 8, 
                'formatter' => function( $d, $row ) 
                {
                   $enquiry_source_by = $row['8'];
                    if(!empty($enquiry_source_by))
                    {
                        $this->db->select('*');
                        $this->db->from('enquiry_source_master');
                        $where = '(enquiry_source_master.entity_id = "'.$enquiry_source_by.'")';
                        $this->db->where($where);
                        $enquiry_source_master = $this->db->get();
                        $enquiry_source_master_result = $enquiry_source_master->row_array();

                        $Enq_Source = $enquiry_source_master_result['source_name'];

                        return $Enq_Source;
                    }else{
                        return 'NA';
                    }
                },'field' => 'enquiry_source'),

            array( 'db' => '`enquiry_register`.`enquiry_status`', 'dt' => 9, 
                'formatter' => function( $d, $row ) 
                {
                    $Enquiry_status = $row['9'];

                    if($Enquiry_status == 1)
                    {
                        $en_status = "Pending";
                    }
                    if($Enquiry_status == 4)
                    {
                        $en_status = "Lost";
                    }
                    if($Enquiry_status == 5)
                    {
                        $en_status = "Regretted";
                    }else{
                        $en_status = "NA";
                    }
                    return $en_status; 

                },'field' => 'enquiry_status'),

            array( 'db' => '`enquiry_register`.`entity_id`', 'dt' => 10,
                'formatter' => function( $d, $row ) 
                {
                    $enquiry_source_by = $row['8'];

                    if($enquiry_source_by == 1)
                    {
                        return '<a href="update_indiamart_enquiry_data/'.$row['0'].'"><span class="btn btn-sm btn-info"><i class="fa fa-edit"></i></span></a> 

                            <a href="setoffer/'.$row['0'].'" class="btn btn-sm btn-block btn-warning">Make Offer</a>

                            <a href="view_enquiry_data/'.$row['0'].'"><span class="btn btn-sm btn-info"><i class="fa fa-eye"></i></span></a>';
                    }else{
                        return '<a href="update_enquiry_data/'.$row['0'].'"><span class="btn btn-sm btn-info"><i class="fa fa-edit"></i></span></a> 

                            <a href="setoffer/'.$row['0'].'" class="btn btn-sm btn-block btn-warning">Make Offer</a>

                            <a href="view_enquiry_data/'.$row['0'].'"><span class="btn btn-sm btn-info"><i class="fa fa-eye"></i></span></a>';
                    }

                },'field' => 'entity_id')
        );
        // SQL server connection information
        
        $sql_details = array(
           'user' => 'u117003035_vbtek',
            'pass' => 'S@14vbtek',
            'db' => 'u117003035_demo_crm',
            'host' => 'localhost'
        );
      
        // $sql_details = array(
        //     'user' => 'root',
        //     'pass' => '',
        //     'db'   => 'demo_crm',
        //     'host' => 'localhost'
        // );

        include APPPATH . 'third_party/datatable_ssp_class/ssp.php';

        $joinQuery = "FROM `{$table}`";
        if($user_id == 1)
        {
            $Where = "`enquiry_register`.`enquiry_status`=".'1';
        }else{
            $Where = "`enquiry_register`.`enquiry_status`=".'1';
        }
        $extraCondition = "";
        $groupBy = "";

        echo json_encode(
            SSP::simple( $_GET,$sql_details,$table,$primaryKey,$columns,$joinQuery,$Where,$extraCondition,$groupBy)
        );
    }
    
    public function create_lead()
    {
        $data['state_list'] = $this->enquiry_register_model->get_state_list();/*
        $data['customer_list'] = $this->enquiry_register_model->get_customer_list();
        $data['customer_contact_list'] = $this->enquiry_register_model->get_contact_list();*/
        $data['employee_list'] = $this->enquiry_register_model->get_employee_list();
        $data['source_list'] = $this->enquiry_register_model->get_source_list();

        $this->load->view('sales/enquiry_register/vw_lead_create',$data);
    }
    
    public function create_lead2()
    {
        $data['state_list'] = $this->enquiry_register_model->get_state_list();/*
        $data['customer_list'] = $this->enquiry_register_model->get_customer_list();
        $data['customer_contact_list'] = $this->enquiry_register_model->get_contact_list();*/
        $data['employee_list'] = $this->enquiry_register_model->get_employee_list();
        $data['source_list'] = $this->enquiry_register_model->get_source_list();

        $this->load->view('sales/enquiry_register/vw_lead_create_bk',$data);
    }

    public function get_customer_details_by_email_id()
    {
        $data = null;
        $data = $this->input->post('id');
        if(!empty($data))
        {
            $email_id = $this->input->post('id');
            $data1 = $this->enquiry_register_model->get_customer_details_by_email_id_model($email_id);
        }
      echo json_encode($data1);   
    }

    
    public function get_customer_details_by_contact_no()
    {
        $data = null;
        $data = $this->input->post('id');
        if(!empty($data))
        {
            $contact_no = $this->input->post('id');
            $data1 = $this->enquiry_register_model->get_customer_details_by_contact_no_model($contact_no);
        }
        // echo '<pre>';
        // print_r($data1);
        // die();
        echo json_encode($data1);
      }
     
       
    public function get_customer_email_data()
    {
        $data = null;
        $data = $this->input->post('id');
        if(!empty($data))
        {
            $email_id = $this->input->post('id');
            $data1 = $this->enquiry_register_model->get_all_data_by_email_id($email_id);
        }
        if(is_null($data1)){
              
          $data1 = false;
          echo json_encode([$data1]);
         
        } else {
        
          echo json_encode([$data1]);
        }
        
    }

    public function get_customer_contact_data()
    {
        $data = null;
        $data = $this->input->post('id');
            if(!empty($data))
            {
            $contact_number = $this->input->post('id');
            $data1 = $this->enquiry_register_model->get_all_data_by_contact_id($contact_number);
            }
            if(is_null($data1)){
              
              $data1 = false;
              echo json_encode([$data1]);
             
            } else {
            
              echo json_encode([$data1]);
            }
    }

    public function save_lead_data()
    {
        date_default_timezone_set("Asia/Calcutta");
        $date_entered = date('Y-m-d');
        $customer_id = $this->input->post('customer_id');
        $customer_name = $this->input->post('customer_name');
        $enquiry_email_id = $this->input->post('enquiry_email_id');
        $enquiry_contact_number = $this->input->post('enquiry_contact_number');
        $enquiry_contact_person = $this->input->post('enquiry_contact_person');
        $lead_source = $this->input->post('enquiry_source');
        $customer_type = $this->input->post('customer_type');
        $address = $this->input->post('address');
        $state_id = $this->input->post('state_id');
        $city_id = $this->input->post('city_id');
        $state_code = $this->input->post('state_code');
        $customer_pin_code = $this->input->post('customer_pin_code');
        $customer_gst_number = $this->input->post('customer_gst_number');
        $customer_pan_number = $this->input->post('customer_pan_number');

        $this->db->select('*');
        $this->db->from('customer_master');
        $where = '(customer_master.entity_id = "'.$customer_id.'" And customer_master.customer_name = "'.$customer_name.'")';
        $this->db->where($where);
        $customer_master = $this->db->get();
        $customer_master_result = $customer_master->row_array();
        $customer_master_count = $customer_master->num_rows();

        if($customer_master_count > 0)
        {
            $customer_id = $customer_master_result['entity_id'];

            $this->db->select('*');
            $this->db->from('customer_contact_master');
            $where = '(customer_contact_master.first_contact_no = "'.$enquiry_contact_number.'")';
            $this->db->where($where);
            $customer_contact_master = $this->db->get();
            $customer_contact_master_result = $customer_contact_master->row_array();
            $customer_contact_master_count = $customer_contact_master->num_rows();

            if($customer_contact_master_count == 0)
            {
                $contact_array = array('customer_id' => $customer_id , 'contact_person' => $enquiry_contact_person , 'email_id' => $enquiry_email_id , 'first_contact_no' => $enquiry_contact_number);
                $this->db->insert('customer_contact_master', $contact_array);
                $contact_person_id = $this->db->insert_id();
            }else{
                $contact_person_id = $customer_contact_master_result['entity_id'];
            }
        }else{
            $customer_array = array(
              'customer_name' => $customer_name , 
              'customer_type' => $customer_type , 
              'address' => $address , 
              'state_id' => $state_id , 
              'city_id' => $city_id , 
              'state_code' => $state_code , 
              'pin_code' => $customer_pin_code , 
              'gst_no' => $customer_gst_number , 
              'pan_no' => $customer_pan_number , 
              'date_entered' => $date_entered,
              'source' => $lead_source,
              'status' => 1);
            $this->db->insert('customer_master', $customer_array);
            $customer_id = $this->db->insert_id();

            $contact_array = array('customer_id' => $customer_id , 'contact_person' => $enquiry_contact_person , 'email_id' => $enquiry_email_id , 'first_contact_no' => $enquiry_contact_number);
            $this->db->insert('customer_contact_master', $contact_array);
            $contact_person_id = $this->db->insert_id();
        }
        
        $enquiry_descrption = $this->input->post('enquiry_descrption');
        $employee_id = $this->input->post('employee_id');
        $enquiry_type = $this->input->post('enquiry_type');
        $enquiry_source = $this->input->post('enquiry_source');
        $enquiry_urgency = $this->input->post('enquiry_urgency');

        if(!empty($_FILES['employee_attachment']))
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
        $this->db->order_by('entity_id', 'DESC');
        $this->db->limit(1);
        $enquiry_register = $this->db->get();
        $results_enquiry_register = $enquiry_register->result_array();

        $this->db->select('document_series_no');
        $this->db->from('documentseries_master');
        $this->db->where('entity_id=2');
        $doc_record=$this->db->get();
        $results_doc_record = $doc_record->result_array();
        $doc_serial_noss = $results_doc_record[0]['document_series_no'];

        $doc_data_seprate = explode('-', $doc_serial_noss);

        if(empty($results_enquiry_register[0]['enquiry_no']))
        {
            if($enquiry_type == 1){
                $enquiry_type_inital = 'MH';

            }elseif($enquiry_type == 2){
                $enquiry_type_inital = 'PS';

            }elseif($enquiry_type == 3){
                $enquiry_type_inital = 'VC';

            }elseif($enquiry_type == 4){
                $enquiry_type_inital = 'TD';

            }elseif($enquiry_type == 5){
                $enquiry_type_inital = 'OT';

            }

            $first_no = '0001';
            $doc_no = $doc_serial_noss.''.$enquiry_type_inital.'/'.$first_no;
        }

        if(!empty($results_enquiry_register[0]['enquiry_no']))
        {
        
            $en_serial_no = $results_enquiry_register[0]['enquiry_no'];
            

            $en_offer_data_seprate = explode('/', $en_serial_no);
            
            $enquiry_first_char = $en_offer_data_seprate['0'];
            $enquiry_second_char = $en_offer_data_seprate['1'];
            $next_en = $enquiry_second_char + 1;
            $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
            $enquiry_first_char_seprate = explode('-', $enquiry_first_char);
            // print_r($enquiry_first_char_seprate);
            // die();

            if($enquiry_type == 1){
                $enquiry_type_inital = 'MH';

            }elseif($enquiry_type == 2){
                $enquiry_type_inital = 'PS';

            }elseif($enquiry_type == 3){
                $enquiry_type_inital = 'VC';

            }elseif($enquiry_type == 4){
                $enquiry_type_inital = 'TD';

            }elseif($enquiry_type == 5){
                $enquiry_type_inital = 'OT';

            }

            $doc_no = $enquiry_first_char_seprate['0'].'-'. $enquiry_first_char_seprate['1'].'-'.$enquiry_type_inital.'/'.$next_doc_no;
        }

        date_default_timezone_set("Asia/Calcutta");
        $enquiry_date = date('Y-m-d');
        $enquiry_status = 1;

        $data = array('enquiry_no' => $doc_no , 'enquiry_short_desc' => $enquiry_descrption , 'customer_id' => $customer_id , 'contact_person_id' => $contact_person_id , 'emp_id' => $employee_id , 'enquiry_type' => $enquiry_type , 'enquiry_source' => $enquiry_source , 'enquiry_urgency' => $enquiry_urgency , 'enquiry_date' => $enquiry_date , 'enquiry_status' => $enquiry_status , 'attachment' => $enquiry_attachment_img);

        $result = $this->enquiry_register_model->save_enquiry_model($data);

        redirect('vw_enquiry_data');
    }

    public function save_india_mart_lead_data()
    {
        date_default_timezone_set("Asia/Calcutta");
        $date_entered = date('Y-m-d');
        $indiamart_log_id = $this->input->post('indiamart_log_id');
        
     
        $customer_name = $this->input->post('customer_name');
        $enquiry_email_id = $this->input->post('enquiry_email_id');
        $enquiry_contact_number = $this->input->post('enquiry_contact_number');
        $enquiry_contact_person = $this->input->post('enquiry_contact_person');
        $lead_source = 1;
        $customer_type = $this->input->post('customer_type');
        $address = $this->input->post('address');
        $state_id = $this->input->post('state_id');
        $city_id = $this->input->post('city_id');
        $state_code = $this->input->post('state_code');
        $customer_pin_code = $this->input->post('customer_pin_code');
        $customer_gst_number = $this->input->post('customer_gst_number');
        $customer_pan_number = $this->input->post('customer_pan_number');

            $customer_array = array(
              'customer_name' => $customer_name , 
              'customer_type' => $customer_type , 
              'address' => $address , 
              'state_id' => $state_id , 
              'city_id' => $city_id , 
              'state_code' => $state_code , 
              'pin_code' => $customer_pin_code , 
              'gst_no' => $customer_gst_number , 
              'pan_no' => $customer_pan_number ,
              'date_entered'  => $date_entered,
              'source' => $lead_source,
              'status' => 1);
            $this->db->insert('customer_master', $customer_array);
            $customer_id = $this->db->insert_id();

            $contact_array = array(
							'customer_id' => $customer_id , 
							'contact_person' => $enquiry_contact_person , 
							'email_id' => $enquiry_email_id , 
							'first_contact_no' => $enquiry_contact_number);
            $this->db->insert('customer_contact_master', $contact_array);
            $contact_person_id = $this->db->insert_id();
        
        
		//update enquiry details
        $enquiry_descrption = $this->input->post('enquiry_descrption');
        $employee_id = $this->input->post('employee_id');
        $enquiry_type = $this->input->post('enquiry_type');
        /*$enquiry_source = $this->input->post('enquiry_source');*/
        $enquiry_source = 1;
        $enquiry_urgency = $this->input->post('enquiry_urgency');
        $india_mart_details = $this->input->post('india_mart_details');

        if(!empty($_FILES['employee_attachment'])) 
				{
					$enquiry_attachment_img = "";
					foreach ($_FILES as $key => $value) 
					{

							$file_name = $value['name'];
							$file_source_path = $value['tmp_name'];
							$file_upload_combine_array = array_combine($file_name, $file_source_path);
							//print_r($file_upload_combine_array);

							foreach ($file_upload_combine_array as $image_name => $image_source_path) 
							{
								// echo $k. ' '. $a ;

								$ext = pathinfo($image_name, PATHINFO_EXTENSION);

								$enquiry_attachment_upload = substr(str_replace(" ", "_", $image_name), 0);
								move_uploaded_file($image_source_path, 'assets/enquiry_attachment/' . $enquiry_attachment_upload);

								$enquiry_attachment_img .= $enquiry_attachment_upload . ',';
							}
					}
				} else {
            $enquiry_attachment_img = NULL;
        }

		// generate enquiry no

        $this->db->select('enquiry_no');
        $this->db->from('enquiry_register');
        $this->db->order_by('entity_id', 'DESC');
        $this->db->limit(1);
        $enquiry_register = $this->db->get();
        $results_enquiry_register = $enquiry_register->result_array();

        $this->db->select('document_series_no');
        $this->db->from('documentseries_master');
        $this->db->where('entity_id=2');
        $doc_record=$this->db->get();
        $results_doc_record = $doc_record->result_array();
        $doc_serial_noss = $results_doc_record[0]['document_series_no'];

        $doc_data_seprate = explode('-', $doc_serial_noss);

        if(empty($results_enquiry_register[0]['enquiry_no']))
        {
            if($enquiry_type == 1){
                $enquiry_type_inital = 'MH';

            }elseif($enquiry_type == 2){
                $enquiry_type_inital = 'PS';

            }elseif($enquiry_type == 3){
                $enquiry_type_inital = 'VC';

            }elseif($enquiry_type == 4){
                $enquiry_type_inital = 'TD';

            }elseif($enquiry_type == 5){
                $enquiry_type_inital = 'OT';

            }

            $first_no = '0001';
            $doc_no = $doc_serial_noss.''.$enquiry_type_inital.'/'.$first_no;
        }

        if(!empty($results_enquiry_register[0]['enquiry_no']))
        {
        
            $en_serial_no = $results_enquiry_register[0]['enquiry_no'];
            

            $en_offer_data_seprate = explode('/', $en_serial_no);
            
            $enquiry_first_char = $en_offer_data_seprate['0'];
            $enquiry_second_char = $en_offer_data_seprate['1'];
            $next_en = $enquiry_second_char + 1;
            $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
            $enquiry_first_char_seprate = explode('-', $enquiry_first_char);
            // print_r($enquiry_first_char_seprate);
            // die();

            if($enquiry_type == 1){
                $enquiry_type_inital = 'MH';

            }elseif($enquiry_type == 2){
                $enquiry_type_inital = 'PS';

            }elseif($enquiry_type == 3){
                $enquiry_type_inital = 'VC';

            }elseif($enquiry_type == 4){
                $enquiry_type_inital = 'TD';

            }elseif($enquiry_type == 5){
                $enquiry_type_inital = 'OT';

            }

            $doc_no = $enquiry_first_char_seprate['0'].'-'. $enquiry_first_char_seprate['1'].'-'.$enquiry_type_inital.'/'.$next_doc_no;
        }

        date_default_timezone_set("Asia/Calcutta");
        $enquiry_date = date('Y-m-d');
        $enquiry_status = 1;

        $data = array(
					'enquiry_no' => $doc_no , 
					'enquiry_short_desc' => $enquiry_descrption , 
					'customer_id' => $customer_id , 
					'contact_person_id' => $contact_person_id , 
					'emp_id' => $employee_id , 
					'enquiry_type' => $enquiry_type , 
					'enquiry_source' => $enquiry_source , 
					'enquiry_urgency' => $enquiry_urgency , 
					'enquiry_date' => $enquiry_date , 
					'enquiry_status' => $enquiry_status , 
					'attachment' => $enquiry_attachment_img , 
					'india_mart_query_details' => $india_mart_details
				);

        $result = $this->enquiry_register_model->save_enquiry_model($data);

        date_default_timezone_set("Asia/Calcutta");
        $lead_conversion_date_and_time = date('Y-m-d h:i:sa');
        $india_mart_lead_status = 2;
        $update_array = array('lead_conversion_date_and_time' => $lead_conversion_date_and_time , 'status' => $india_mart_lead_status);

        $where = '(entity_id ="'.$indiamart_log_id.'")';
        $this->db->where($where);
        $this->db->update('indiamart_api_log',$update_array);

        redirect('vw_enquiry_data');
    }

    // public function save_india_mart_lead_data()
    // {
    //     date_default_timezone_set("Asia/Calcutta");
    //     $date_entered = date('Y-m-d');
    //     $indiamart_log_id = $this->input->post('indiamart_log_id');
        
    //     $customer_id = $this->input->post('customer_id');
    //     $customer_name = $this->input->post('customer_name');
    //     $enquiry_email_id = $this->input->post('enquiry_email_id');
    //     $enquiry_contact_number = $this->input->post('enquiry_contact_number');
    //     $enquiry_contact_person = $this->input->post('enquiry_contact_person');
    //     $lead_source = 1;
    //     $customer_type = $this->input->post('customer_type');
    //     $address = $this->input->post('address');
    //     $state_id = $this->input->post('state_id');
    //     $city_id = $this->input->post('city_id');
    //     $state_code = $this->input->post('state_code');
    //     $customer_pin_code = $this->input->post('customer_pin_code');
    //     $customer_gst_number = $this->input->post('customer_gst_number');
    //     $customer_pan_number = $this->input->post('customer_pan_number');

    //     if($customer_id)
    //     {
	// 					$this->db->select('*');
	// 					$this->db->from('customer_master');
	// 					$where = '(customer_master.entity_id = "'.$customer_id.'" And customer_master.customer_name = "'.$customer_name.'")';
	// 					$this->db->where($where);
	// 					$customer_master = $this->db->get();
	// 					$customer_master_result = $customer_master->row_array();
	// 					$customer_master_count = $customer_master->num_rows();

	// 					// if($customer_master_count > 0)
	// 					// {
    //         $customer_id = $customer_master_result['entity_id'];

    //         $this->db->select('*');
    //         $this->db->from('customer_contact_master');
    //         $where = '(customer_contact_master.first_contact_no = "'.$enquiry_contact_number.'")';
    //         $this->db->where($where);
    //         $customer_contact_master = $this->db->get();
    //         $customer_contact_master_result = $customer_contact_master->row_array();
    //         $customer_contact_master_count = $customer_contact_master->num_rows();

    //         if($customer_contact_master_count == 0)
    //         {
    //             $contact_array = array(
	// 								'customer_id' => $customer_id , 
	// 								'contact_person' => $enquiry_contact_person , 
	// 								'email_id' => $enquiry_email_id , 
	// 								'first_contact_no' => $enquiry_contact_number
	// 							);
    //             $this->db->insert('customer_contact_master', $contact_array);
    //             $contact_person_id = $this->db->insert_id();
    //         }else{
    //             $contact_person_id = $customer_contact_master_result['entity_id'];
    //         }
    //     }else{
    //         $customer_array = array(
    //           'customer_name' => $customer_name , 
    //           'customer_type' => $customer_type , 
    //           'address' => $address , 
    //           'state_id' => $state_id , 
    //           'city_id' => $city_id , 
    //           'state_code' => $state_code , 
    //           'pin_code' => $customer_pin_code , 
    //           'gst_no' => $customer_gst_number , 
    //           'pan_no' => $customer_pan_number ,
    //           'date_entered'  => $date_entered,
    //           'source' => $lead_source,
    //           'status' => 1);
    //         $this->db->insert('customer_master', $customer_array);
    //         $customer_id = $this->db->insert_id();

    //         $contact_array = array(
	// 						'customer_id' => $customer_id , 
	// 						'contact_person' => $enquiry_contact_person , 
	// 						'email_id' => $enquiry_email_id , 
	// 						'first_contact_no' => $enquiry_contact_number);
    //         $this->db->insert('customer_contact_master', $contact_array);
    //         $contact_person_id = $this->db->insert_id();
    //     }
        
	// 			//update enquiry details
    //     $enquiry_descrption = $this->input->post('enquiry_descrption');
    //     $employee_id = $this->input->post('employee_id');
    //     $enquiry_type = $this->input->post('enquiry_type');
    //     /*$enquiry_source = $this->input->post('enquiry_source');*/
    //     $enquiry_source = 1;
    //     $enquiry_urgency = $this->input->post('enquiry_urgency');
    //     $india_mart_details = $this->input->post('india_mart_details');

    //     if(!empty($_FILES['employee_attachment'])) 
	// 			{
	// 				$enquiry_attachment_img = "";
	// 				foreach ($_FILES as $key => $value) 
	// 				{

	// 						$file_name = $value['name'];
	// 						$file_source_path = $value['tmp_name'];
	// 						$file_upload_combine_array = array_combine($file_name, $file_source_path);
	// 						//print_r($file_upload_combine_array);

	// 						foreach ($file_upload_combine_array as $image_name => $image_source_path) 
	// 						{
	// 							// echo $k. ' '. $a ;

	// 							$ext = pathinfo($image_name, PATHINFO_EXTENSION);

	// 							$enquiry_attachment_upload = substr(str_replace(" ", "_", $image_name), 0);
	// 							move_uploaded_file($image_source_path, 'assets/enquiry_attachment/' . $enquiry_attachment_upload);

	// 							$enquiry_attachment_img .= $enquiry_attachment_upload . ',';
	// 						}
	// 				}
	// 			} else {
    //         $enquiry_attachment_img = NULL;
    //     }

	// 	// generate enquiry no

    //     $this->db->select('enquiry_no');
    //     $this->db->from('enquiry_register');
    //     $this->db->order_by('entity_id', 'DESC');
    //     $this->db->limit(1);
    //     $enquiry_register = $this->db->get();
    //     $results_enquiry_register = $enquiry_register->result_array();

    //     $this->db->select('document_series_no');
    //     $this->db->from('documentseries_master');
    //     $this->db->where('entity_id=2');
    //     $doc_record=$this->db->get();
    //     $results_doc_record = $doc_record->result_array();
    //     $doc_serial_noss = $results_doc_record[0]['document_series_no'];

    //     $doc_data_seprate = explode('-', $doc_serial_noss);

    //     if(empty($results_enquiry_register[0]['enquiry_no']))
    //     {
    //         if($enquiry_type == 1){
    //             $enquiry_type_inital = 'MH';

    //         }elseif($enquiry_type == 2){
    //             $enquiry_type_inital = 'PS';

    //         }elseif($enquiry_type == 3){
    //             $enquiry_type_inital = 'VC';

    //         }elseif($enquiry_type == 4){
    //             $enquiry_type_inital = 'TD';

    //         }elseif($enquiry_type == 5){
    //             $enquiry_type_inital = 'OT';

    //         }

    //         $first_no = '0001';
    //         $doc_no = $doc_serial_noss.''.$enquiry_type_inital.'/'.$first_no;
    //     }

    //     if(!empty($results_enquiry_register[0]['enquiry_no']))
    //     {
        
    //         $en_serial_no = $results_enquiry_register[0]['enquiry_no'];
            

    //         $en_offer_data_seprate = explode('/', $en_serial_no);
            
    //         $enquiry_first_char = $en_offer_data_seprate['0'];
    //         $enquiry_second_char = $en_offer_data_seprate['1'];
    //         $next_en = $enquiry_second_char + 1;
    //         $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
    //         $enquiry_first_char_seprate = explode('-', $enquiry_first_char);
    //         // print_r($enquiry_first_char_seprate);
    //         // die();

    //         if($enquiry_type == 1){
    //             $enquiry_type_inital = 'MH';

    //         }elseif($enquiry_type == 2){
    //             $enquiry_type_inital = 'PS';

    //         }elseif($enquiry_type == 3){
    //             $enquiry_type_inital = 'VC';

    //         }elseif($enquiry_type == 4){
    //             $enquiry_type_inital = 'TD';

    //         }elseif($enquiry_type == 5){
    //             $enquiry_type_inital = 'OT';

    //         }

    //         $doc_no = $enquiry_first_char_seprate['0'].'-'. $enquiry_first_char_seprate['1'].'-'.$enquiry_type_inital.'/'.$next_doc_no;
    //     }

    //     date_default_timezone_set("Asia/Calcutta");
    //     $enquiry_date = date('Y-m-d');
    //     $enquiry_status = 1;

    //     $data = array(
	// 				'enquiry_no' => $doc_no , 
	// 				'enquiry_short_desc' => $enquiry_descrption , 
	// 				'customer_id' => $customer_id , 
	// 				'contact_person_id' => $contact_person_id , 
	// 				'emp_id' => $employee_id , 
	// 				'enquiry_type' => $enquiry_type , 
	// 				'enquiry_source' => $enquiry_source , 
	// 				'enquiry_urgency' => $enquiry_urgency , 
	// 				'enquiry_date' => $enquiry_date , 
	// 				'enquiry_status' => $enquiry_status , 
	// 				'attachment' => $enquiry_attachment_img , 
	// 				'india_mart_query_details' => $india_mart_details
	// 			);

    //     $result = $this->enquiry_register_model->save_enquiry_model($data);

    //     date_default_timezone_set("Asia/Calcutta");
    //     $lead_conversion_date_and_time = date('Y-m-d h:i:sa');
    //     $india_mart_lead_status = 2;
    //     $update_array = array('lead_conversion_date_and_time' => $lead_conversion_date_and_time , 'status' => $india_mart_lead_status);

    //     $where = '(entity_id ="'.$indiamart_log_id.'")';
    //     $this->db->where($where);
    //     $this->db->update('indiamart_api_log',$update_array);

    //     redirect('vw_enquiry_data');
    // }

    public function save_indiamart_lead_with_existing_customer_and_contact()
    {
        $customer_id = $this->input->post('customer_id');
        $contact_id = $this->input->post('contact_id');
        $enquiry_descrption = $this->input->post('enquiry_descrption');
        $employee_id = $this->input->post('employee_id');
        $enquiry_type = $this->input->post('enquiry_type');
        $enquiry_urgency = $this->input->post('enquiry_urgency');
        $india_mart_details = $this->input->post('india_mart_details');
        $indiamart_log_id = $this->input->post('indiamart_log_id');


        // generate enquiry no

        $this->db->select('enquiry_no');
        $this->db->from('enquiry_register');
        $this->db->order_by('entity_id', 'DESC');
        $this->db->limit(1);
        $enquiry_register = $this->db->get();
        $results_enquiry_register = $enquiry_register->result_array();

        $this->db->select('document_series_no');
        $this->db->from('documentseries_master');
        $this->db->where('entity_id=2');
        $doc_record=$this->db->get();
        $results_doc_record = $doc_record->result_array();
        $doc_serial_noss = $results_doc_record[0]['document_series_no'];

        $doc_data_seprate = explode('-', $doc_serial_noss);

        if(empty($results_enquiry_register[0]['enquiry_no']))
        {
            if($enquiry_type == 1){
                $enquiry_type_inital = 'MH';

            }elseif($enquiry_type == 2){
                $enquiry_type_inital = 'PS';

            }elseif($enquiry_type == 3){
                $enquiry_type_inital = 'VC';

            }elseif($enquiry_type == 4){
                $enquiry_type_inital = 'TD';

            }elseif($enquiry_type == 5){
                $enquiry_type_inital = 'OT';

            }

            $first_no = '0001';
            $doc_no = $doc_serial_noss.''.$enquiry_type_inital.'/'.$first_no;
        }

        if(!empty($results_enquiry_register[0]['enquiry_no']))
        {
        
            $en_serial_no = $results_enquiry_register[0]['enquiry_no'];
            

            $en_offer_data_seprate = explode('/', $en_serial_no);
            
            $enquiry_first_char = $en_offer_data_seprate['0'];
            $enquiry_second_char = $en_offer_data_seprate['1'];
            $next_en = $enquiry_second_char + 1;
            $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
            $enquiry_first_char_seprate = explode('-', $enquiry_first_char);
            // print_r($enquiry_first_char_seprate);
            // die();

            if($enquiry_type == 1){
                $enquiry_type_inital = 'MH';

            }elseif($enquiry_type == 2){
                $enquiry_type_inital = 'PS';

            }elseif($enquiry_type == 3){
                $enquiry_type_inital = 'VC';

            }elseif($enquiry_type == 4){
                $enquiry_type_inital = 'TD';

            }elseif($enquiry_type == 5){
                $enquiry_type_inital = 'OT';

            }

            $doc_no = $enquiry_first_char_seprate['0'].'-'. $enquiry_first_char_seprate['1'].'-'.$enquiry_type_inital.'/'.$next_doc_no;
        }

        date_default_timezone_set("Asia/Calcutta");
        $enquiry_date = date('Y-m-d');
        $enquiry_status = 1;

        $data = array(
					'enquiry_no' => $doc_no , 
					'enquiry_short_desc' => $enquiry_descrption , 
					'customer_id' => $customer_id , 
					'contact_person_id' => $contact_id , 
					'emp_id' => $employee_id , 
					'enquiry_type' => $enquiry_type , 
					'enquiry_source' => 1 , 
					'enquiry_urgency' => $enquiry_urgency , 
					'enquiry_date' => $enquiry_date , 
					'enquiry_status' => $enquiry_status , 
					'india_mart_query_details' => $india_mart_details
				);

        $result = $this->enquiry_register_model->save_enquiry_model($data);

        date_default_timezone_set("Asia/Calcutta");
        $lead_conversion_date_and_time = date('Y-m-d h:i:sa');
        $india_mart_lead_status = 2;
        $update_array = array('lead_conversion_date_and_time' => $lead_conversion_date_and_time , 'status' => $india_mart_lead_status);

        $where = '(entity_id ="'.$indiamart_log_id.'")';
        $this->db->where($where);
        $this->db->update('indiamart_api_log',$update_array);

        echo site_url('vw_enquiry_data');

    
        
    }

    public function save_indiamart_lead_with_existing_customer_and_new_contact()
    {
        $customer_id = $this->input->post('customer_id');
        // $contact_id = $this->input->post('contact_id');
        $enquiry_descrption = $this->input->post('enquiry_descrption');
        $employee_id = $this->input->post('employee_id');
        $enquiry_type = $this->input->post('enquiry_type');
        $enquiry_urgency = $this->input->post('enquiry_urgency');
        $enquiry_email_id = $this->input->post('enquiry_email_id');
        $enquiry_contact_number = $this->input->post('enquiry_contact_number');
        $enquiry_contact_person = $this->input->post('enquiry_contact_person');
        $india_mart_details = $this->input->post('india_mart_details');
        $indiamart_log_id = $this->input->post('indiamart_log_id');

				// add new contact
				$contact_array = array(
					'customer_id' => $customer_id,
					'contact_person' => $enquiry_contact_person,
					'email_id' => $enquiry_email_id,
					'first_contact_no' => $enquiry_contact_number
				);
				$this->db->insert('customer_contact_master', $contact_array);
				$contact_id = $this->db->insert_id();

        // generate enquiry no

        $this->db->select('enquiry_no');
        $this->db->from('enquiry_register');
        $this->db->order_by('entity_id', 'DESC');
        $this->db->limit(1);
        $enquiry_register = $this->db->get();
        $results_enquiry_register = $enquiry_register->result_array();

        $this->db->select('document_series_no');
        $this->db->from('documentseries_master');
        $this->db->where('entity_id=2');
        $doc_record=$this->db->get();
        $results_doc_record = $doc_record->result_array();
        $doc_serial_noss = $results_doc_record[0]['document_series_no'];

        $doc_data_seprate = explode('-', $doc_serial_noss);

        if(empty($results_enquiry_register[0]['enquiry_no']))
        {
            if($enquiry_type == 1){
                $enquiry_type_inital = 'MH';

            }elseif($enquiry_type == 2){
                $enquiry_type_inital = 'PS';

            }elseif($enquiry_type == 3){
                $enquiry_type_inital = 'VC';

            }elseif($enquiry_type == 4){
                $enquiry_type_inital = 'TD';

            }elseif($enquiry_type == 5){
                $enquiry_type_inital = 'OT';

            }

            $first_no = '0001';
            $doc_no = $doc_serial_noss.''.$enquiry_type_inital.'/'.$first_no;
        }

        if(!empty($results_enquiry_register[0]['enquiry_no']))
        {
        
            $en_serial_no = $results_enquiry_register[0]['enquiry_no'];
            

            $en_offer_data_seprate = explode('/', $en_serial_no);
            
            $enquiry_first_char = $en_offer_data_seprate['0'];
            $enquiry_second_char = $en_offer_data_seprate['1'];
            $next_en = $enquiry_second_char + 1;
            $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
            $enquiry_first_char_seprate = explode('-', $enquiry_first_char);
            // print_r($enquiry_first_char_seprate);
            // die();

            if($enquiry_type == 1){
                $enquiry_type_inital = 'MH';

            }elseif($enquiry_type == 2){
                $enquiry_type_inital = 'PS';

            }elseif($enquiry_type == 3){
                $enquiry_type_inital = 'VC';

            }elseif($enquiry_type == 4){
                $enquiry_type_inital = 'TD';

            }elseif($enquiry_type == 5){
                $enquiry_type_inital = 'OT';

            }

            $doc_no = $enquiry_first_char_seprate['0'].'-'. $enquiry_first_char_seprate['1'].'-'.$enquiry_type_inital.'/'.$next_doc_no;
        }

        date_default_timezone_set("Asia/Calcutta");
        $enquiry_date = date('Y-m-d');
        $enquiry_status = 1;

        $data = array(
					'enquiry_no' => $doc_no , 
					'enquiry_short_desc' => $enquiry_descrption , 
					'customer_id' => $customer_id , 
					'contact_person_id' => $contact_id , 
					'emp_id' => $employee_id , 
					'enquiry_type' => $enquiry_type , 
					'enquiry_source' => 1 , 
					'enquiry_urgency' => $enquiry_urgency , 
					'enquiry_date' => $enquiry_date , 
					'enquiry_status' => $enquiry_status , 
					'india_mart_query_details' => $india_mart_details
				);

        $result = $this->enquiry_register_model->save_enquiry_model($data);

        date_default_timezone_set("Asia/Calcutta");
        $lead_conversion_date_and_time = date('Y-m-d h:i:sa');
        $india_mart_lead_status = 2;
        $update_array = array('lead_conversion_date_and_time' => $lead_conversion_date_and_time , 'status' => $india_mart_lead_status);

        $where = '(entity_id ="'.$indiamart_log_id.'")';
        $this->db->where($where);
        $this->db->update('indiamart_api_log',$update_array);

        echo site_url('vw_enquiry_data');

    
        
    }

}
?>
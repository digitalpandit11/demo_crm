<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class Invoice_monitoring_register extends CI_Controller {
    	public function __construct() {
            parent::__construct();
            $this->load->helper('url');
            $this->load->model('invoice_monitoring_register_model');
            $this->load->library('session');
            $this->load->library('email');
        }

    	public function index()
    	{
            $data['invoice_details'] = $this->invoice_monitoring_register_model->get_invoice_details();
    		$this->load->view('sales/invoice_monitoring_register/vw_invoice_monitoring_index',$data);
    	}

        public function create()
        {
            $data['sales_order'] = $this->invoice_monitoring_register_model->get_sales_order_list();
            $this->load->view('sales/invoice_monitoring_register/vw_invoice_monitoring_create',$data);
        }

        public function save_invoice_monitoring()
        {
            if(!empty($_FILES['invoice_attachment']))
            {
                $invoice_attachment_img = "";
                foreach ($_FILES as $key => $value) {
                    
                    $file_name = $value['name'];
                    $file_source_path = $value['tmp_name'];
                    $file_upload_combine_array = array_combine($file_name, $file_source_path);
                    //print_r($file_upload_combine_array);
                    
                    foreach ($file_upload_combine_array as $image_name=> $image_source_path) {
                        // echo $k. ' '. $a ;

                        $ext = pathinfo($image_name,PATHINFO_EXTENSION);

                        $invoice_attachment_upload = substr(str_replace(" ", "_", $image_name), 0);
                        move_uploaded_file($image_source_path, 'assets/invoice_attachment/'.$invoice_attachment_upload);

                        $invoice_attachment_img .= $invoice_attachment_upload;
                    }  
                }
            }else{
                $invoice_attachment_img = NULL;
            }

            $sales_order_id = $this->input->post('sales_order_id');
            $invoice_number = $this->input->post('invoice_number');
            $invoice_date = $this->input->post('invoice_date');
            $invoice_amount = $this->input->post('invoice_amount');

            date_default_timezone_set("Asia/Calcutta");
            $monitoring_date = date('Y-m-d');
            $monitoring_status = 1;
            $user_id = $_SESSION['user_id'];
            $monitoring_time = date("g:i a"); 

            $data = array('sales_order_id' => $sales_order_id , 'invoice_number' => $invoice_number , 'invoice_date' => $invoice_date , 'invoice_amount' => $invoice_amount , 'attachment ' => $invoice_attachment_img , 'cretaed_date' => $monitoring_date , 'cretaed_time' => $monitoring_time , 'user_id' => $user_id , 'updated_by_id' => $user_id , 'status' => $monitoring_status);

            $result = $this->invoice_monitoring_register_model->save_invoice_model($data);
            
            $update_order_array = array('invoice_status' => 2);
            $where = '(entity_id ="'.$sales_order_id.'")';
            $this->db->where($where);
            $this->db->update('sales_order_register',$update_order_array);
            
            redirect('vw_invoice_monitoring');
        }

        public function update_view()
        {
            $entity_id = $this->uri->segment(2);
            $data['entity_id'] = $entity_id;
            $data['sales_order'] = $this->invoice_monitoring_register_model->get_sales_order_list();
            $this->load->view('sales/invoice_monitoring_register/vw_invoice_monitoring_edit',$data);
        }

        public function get_invoice_details_by_id()
        {
            $entity_id = $this->input->post('entity_id',TRUE);
            $data = $this->invoice_monitoring_register_model->get_invoice_details_by_id_model($entity_id)->result();
            echo json_encode($data);
        }

        public function update_invoice_monitoring()
        {
            if(!empty($_FILES['invoice_attachment']['name']['0']))
            {
                $attachment_img = "";
                foreach ($_FILES as $key => $value) {
                    
                    $file_name = $value['name'];
                    $file_source_path = $value['tmp_name'];
                    $file_upload_combine_array = array_combine($file_name, $file_source_path);
                    //print_r($file_upload_combine_array);
                    
                    foreach ($file_upload_combine_array as $image_name=> $image_source_path) {
                        // echo $k. ' '. $a ;

                        $ext = pathinfo($image_name,PATHINFO_EXTENSION);

                        $invoice_attachment_upload = substr(str_replace(" ", "_", $image_name), 0);
                        move_uploaded_file($image_source_path, 'assets/invoice_attachment/'.$invoice_attachment_upload);

                        $attachment_img .= $invoice_attachment_upload;
                    }  
                }

                $entity_id = $this->input->post('entity_id');
                $sales_order_id = $this->input->post('sales_order_id');
                $invoice_number = $this->input->post('invoice_number');
                $invoice_date = $this->input->post('invoice_date');
                $invoice_amount = $this->input->post('invoice_amount');

                $user_id = $_SESSION['user_id'];

                $data = array('entity_id' => $entity_id , 'sales_order_id' => $sales_order_id , 'invoice_number' => $invoice_number , 'invoice_date' => $invoice_date , 'invoice_amount' => $invoice_amount , 'attachment ' => $attachment_img , 'updated_by_id' => $user_id);

                $result = $this->invoice_monitoring_register_model->update_model($data);
                redirect('vw_invoice_monitoring'); 
            }else{
                $entity_id = $this->input->post('entity_id');
                $sales_order_id = $this->input->post('sales_order_id');
                $invoice_number = $this->input->post('invoice_number');
                $invoice_date = $this->input->post('invoice_date');
                $invoice_amount = $this->input->post('invoice_amount');

                $user_id = $_SESSION['user_id'];

                $data = array('entity_id' => $entity_id , 'sales_order_id' => $sales_order_id , 'invoice_number' => $invoice_number , 'invoice_date' => $invoice_date , 'invoice_amount' => $invoice_amount , 'updated_by_id' => $user_id);

                $result = $this->invoice_monitoring_register_model->update_model($data);
                redirect('vw_invoice_monitoring');
            }
        }

        public function show_view()
        {
            $entity_id = $this->uri->segment(2);
            $data['entity_id'] = $entity_id;
            $data['sales_order'] = $this->invoice_monitoring_register_model->get_sales_order_list();
            $this->load->view('sales/invoice_monitoring_register/vw_invoice_monitoring_view',$data);
        }
    }
?>
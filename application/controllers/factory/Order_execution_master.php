<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ob_start();

class Order_execution_master extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('order_execution_master_model');
        $this->load->library('session');
    }

    public function index()
    {
        $data['sales_order_details'] = $this->order_execution_master_model->get_approved_sales_order();
        $this->load->view('factory/order_execution_master/vw_order_execution_master_index',$data);
    }

    public function update_order_execution_data()
    {
        $entity_id = $this->uri->segment(2);
        $data['entity_id'] = $entity_id;
        $data['customer_list'] = $this->order_execution_master_model->get_customer_list();
        $data['employee_list'] = $this->order_execution_master_model->get_employee_list();
        $data['payment_term_list'] = $this->order_execution_master_model->get_payment_term_list();
        $data['order_product_list'] = $this->order_execution_master_model->get_order_product_list_by_id($entity_id);
        $this->load->view('factory/order_execution_master/vw_order_execution_master_update',$data);
    }

    public function get_order_details_by_orderid()
    {
        $entity_id = $this->input->post('entity_id',TRUE);
        $data = $this->order_execution_master_model->get_order_details_by_id_model($entity_id)->result();
        echo json_encode($data);
    }

    public function update_push_to()
    {
        $entity_id = $this->input->post('order_relation_entity_id');
        $push_to = $this->input->post('push_to');
        if(empty($push_to))
        {
            $push_to = NULL;
        }

        $update_array = array('entity_id' => $entity_id,'push_to' => $push_to);
        $data = $this->order_execution_master_model->update_order_execution_relation($update_array);

        echo json_encode($data);
    }

    public function execute_sales_order()
    {
        $sales_order_id = $this->input->post('order_entity_id');

        $this->db->select('*');
        $this->db->from('sales_order_register');
        $where = '(sales_order_register.entity_id = "'.$sales_order_id.'")';
        $this->db->where($where);
        $sales_order_register_data = $this->db->get();
        $sales_order_register_result = $sales_order_register_data->row_array();

        $special_customer = $sales_order_register_result['special_customer'];
        $sales_order_type = $sales_order_register_result['sales_order_type'];

        $this->db->select('*');
        $this->db->from('order_execution_product_relation');
        $where = '(order_execution_product_relation.push_to IS NOT NULL And order_execution_product_relation.status = "'.'1'.'" And order_execution_product_relation.push_to = "'.'1'.'" And order_execution_product_relation.sales_order_id = "'.$sales_order_id.'")';
        $this->db->where($where);
        $work_order_data = $this->db->get();
        $work_order_data_result = $work_order_data->result_array();

        if(!empty($work_order_data_result))
        {
            foreach($work_order_data_result as $key => $value)
            {
                $wo_product_id = $value['product_id'];
                $wo_product_qty = $value['rfq_qty'];
                $product_category_id = $value['product_category_id'];

                $this->db->select('sales_order_product_relation.*');
                $this->db->from('sales_order_product_relation');
                $where = '(sales_order_product_relation.sales_order_id = "'.$sales_order_id.'" And sales_order_product_relation.product_id = "'.$wo_product_id.'")';
                $this->db->where($where);
                $sales_order_product_relation_data = $this->db->get();
                $sales_order_product_relation_result = $sales_order_product_relation_data->row_array();

                $product_custom_description = $sales_order_product_relation_result['product_custom_description'];

                $wo_product_relation_array = array('sales_order_id' => $sales_order_id , 'product_category_id' => $product_category_id , 'product_id' => $wo_product_id , 'work_order_qty' => $wo_product_qty , 'product_custom_description' => $product_custom_description , 'status' => 1);
                $this->db->insert('work_order_product_relation', $wo_product_relation_array);
            }

            $this->db->select('work_order_product_relation.*');
            $this->db->from('work_order_product_relation');
            $where = '(work_order_product_relation.sales_order_id = "'.$sales_order_id.'" And work_order_product_relation.status = "'.'1'.'")';
            $this->db->where($where);
            $this->db->group_by('work_order_product_relation.product_category_id');
            $work_order_product_relation = $this->db->get();
            $work_order_product_relation_result = $work_order_product_relation->result_array();
            $work_order_product_relation_count = $work_order_product_relation->num_rows();

            if($sales_order_type == 1){
                $sales_order_type_initial = 'MH';

            }elseif($sales_order_type == 2){
                $sales_order_type_initial = 'PS';

            }elseif($sales_order_type == 3){
                $sales_order_type_initial = 'VC';

            }elseif($sales_order_type == 4){
                $sales_order_type_initial = 'TD';

            }elseif($sales_order_type == 5){
                $sales_order_type_initial = 'OT';

            }


            if($special_customer == 1){
                $special_customer_inital = 'S';

            }elseif($special_customer == 2){
                $special_customer_inital = 'M';

            }elseif($special_customer == 3){
                $special_customer_inital = 'E';

            }elseif($special_customer == 4){
                $special_customer_inital = 'K';

            }elseif($special_customer == 5){
                $special_customer_inital = 'A';

            }elseif($special_customer == 6){
                $special_customer_inital = 'X';

            }

            $this->db->select('work_order_no');
            $this->db->from('work_order_master');
            $where = '(work_order_master.work_order_type = "'.'1'.'")';
            $this->db->where($where);
            $this->db->order_by('entity_id', 'DESC');
            $this->db->limit(1);
            $workorder_master = $this->db->get();
            $results_workorder_master = $workorder_master->result_array();

            $this->db->select('document_series_no');
            $this->db->from('documentseries_master');
            $this->db->where('entity_id=5');
            $doc_record=$this->db->get();
            $results_doc_record = $doc_record->result_array();

            $doc_serial_no = $results_doc_record[0]['document_series_no'];
            $doc_data_seprate = explode('/', $doc_serial_no);

            if(empty($results_workorder_master[0]['work_order_no']))
            {
                $first_no = '0001';
                $doc_no = $doc_serial_no.$sales_order_type_initial.$special_customer_inital.'/'.$first_no;

            }elseif(!empty($results_workorder_master))
            {
                $wo_serial_no = $results_workorder_master[0]['work_order_no'];
                $wo_data_seprate = explode('/', $wo_serial_no);

                $workorder_first_char = $wo_data_seprate['0'];
                $workorder_second_char = $wo_data_seprate['1'];
                $next_en = $workorder_second_char + 1;
                $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
                $workorder_first_char_seprate = explode('-', $workorder_first_char);

                $doc_no = $workorder_first_char_seprate['0'].'-'. $sales_order_type_initial.'-'.$special_customer_inital.'/'.$next_doc_no;
            }

            $work_order_type = 1;
            $work_order_category = 1;
            date_default_timezone_set('Asia/Kolkata');
            $work_order_date = date("Y-m-d");
            $order_status = 1;
            $work_order_status =1;

            if($work_order_product_relation_count == 1 || $work_order_product_relation_count >= 6)
            {
                $wo_data_master_save = "INSERT INTO work_order_master (work_order_no,work_order_type,work_order_category,work_order_date,special_customer,sales_order_id,status,work_order_status, workorder_type) VALUES ('".$doc_no."','".$work_order_type."','".$work_order_category."','".$work_order_date."','".$special_customer."','".$sales_order_id."','".$order_status."','".$work_order_status."','".$sales_order_type."')";
                $save_execute = $this->db->query($wo_data_master_save);
                $wo_master_lastid = $this->db->insert_id();

                $this->db->select('work_order_product_relation.*');
                $this->db->from('work_order_product_relation');
                $where = '(work_order_product_relation.sales_order_id = "'.$sales_order_id.'" And work_order_product_relation.status = "'.'1'.'")';
                $this->db->where($where);
                $work_order_product_category_relation = $this->db->get();
                $work_order_product_category_result = $work_order_product_category_relation->result_array();

                foreach ($work_order_product_category_result as $key => $value) 
                {
                    $work_order_relation_id = $value['entity_id'];

                    $update_wo_product_array = array('work_order_id' => $wo_master_lastid , 'status' => 2);

                    $this->db->where('entity_id', $work_order_relation_id);
                    $this->db->update('work_order_product_relation', $update_wo_product_array);
                }
            }elseif($work_order_product_relation_count == 2)
            {
                $First_doc_no = $doc_no.'-'."A";
                $Second_doc_no = $doc_no.'-'."B";

                $first_wo_data_master_save = "INSERT INTO work_order_master (work_order_no,work_order_type,work_order_category,work_order_date,special_customer,sales_order_id,status,work_order_status, workorder_type) VALUES ('".$First_doc_no."','".$work_order_type."','".$work_order_category."','".$work_order_date."','".$special_customer."','".$sales_order_id."','".$order_status."','".$work_order_status."','".$sales_order_type."')";
                $first_save_execute = $this->db->query($first_wo_data_master_save);
                $first_wo_master_lastid = $this->db->insert_id();

                $first_product_category_id = $work_order_product_relation_result[0]['product_category_id'];

                $this->db->select('work_order_product_relation.*');
                $this->db->from('work_order_product_relation');
                $where = '(work_order_product_relation.sales_order_id = "'.$sales_order_id.'" And work_order_product_relation.product_category_id = "'.$first_product_category_id.'" And work_order_product_relation.status = "'.'1'.'")';
                $this->db->where($where);
                $first_work_order_product_category_relation = $this->db->get();
                $first_work_order_product_category_result = $first_work_order_product_category_relation->result_array();

                foreach ($first_work_order_product_category_result as $key => $value) 
                {
                    $work_order_relation_id = $value['entity_id'];

                    $update_wo_product_array = array('work_order_id' => $first_wo_master_lastid , 'status' => 2);

                    $this->db->where('entity_id', $work_order_relation_id);
                    $this->db->update('work_order_product_relation', $update_wo_product_array);
                }

                $second_wo_data_master_save = "INSERT INTO work_order_master (work_order_no,work_order_type,work_order_category,work_order_date,special_customer,sales_order_id,status,work_order_status, workorder_type) VALUES ('".$Second_doc_no."','".$work_order_type."','".$work_order_category."','".$work_order_date."','".$special_customer."','".$sales_order_id."','".$order_status."','".$work_order_status."','".$sales_order_type."')";
                $second_save_execute = $this->db->query($second_wo_data_master_save);
                $second_wo_master_lastid = $this->db->insert_id();

                $second_product_category_id = $work_order_product_relation_result[1]['product_category_id'];

                $this->db->select('work_order_product_relation.*');
                $this->db->from('work_order_product_relation');
                $where = '(work_order_product_relation.sales_order_id = "'.$sales_order_id.'" And work_order_product_relation.product_category_id = "'.$second_product_category_id.'" And work_order_product_relation.status = "'.'1'.'")';
                $this->db->where($where);
                $second_work_order_product_category_relation = $this->db->get();
                $second_work_order_product_category_result = $second_work_order_product_category_relation->result_array();

                foreach ($second_work_order_product_category_result as $key => $value) 
                {
                    $work_order_relation_id = $value['entity_id'];

                    $update_wo_product_array = array('work_order_id' => $second_wo_master_lastid , 'status' => 2);

                    $this->db->where('entity_id', $work_order_relation_id);
                    $this->db->update('work_order_product_relation', $update_wo_product_array);
                }
            }elseif($work_order_product_relation_count == 3)
            {
                $First_doc_no = $doc_no.'-'."A";
                $Second_doc_no = $doc_no.'-'."B";
                $Third_doc_no = $doc_no.'-'."C";

                $first_wo_data_master_save = "INSERT INTO work_order_master (work_order_no,work_order_type,work_order_category,work_order_date,special_customer,sales_order_id,status,work_order_status, workorder_type) VALUES ('".$First_doc_no."','".$work_order_type."','".$work_order_category."','".$work_order_date."','".$special_customer."','".$sales_order_id."','".$order_status."','".$work_order_status."','".$sales_order_type."')";
                $first_save_execute = $this->db->query($first_wo_data_master_save);
                $first_wo_master_lastid = $this->db->insert_id();

                $first_product_category_id = $work_order_product_relation_result[0]['product_category_id'];

                $this->db->select('work_order_product_relation.*');
                $this->db->from('work_order_product_relation');
                $where = '(work_order_product_relation.sales_order_id = "'.$sales_order_id.'" And work_order_product_relation.product_category_id = "'.$first_product_category_id.'" And work_order_product_relation.status = "'.'1'.'")';
                $this->db->where($where);
                $first_work_order_product_category_relation = $this->db->get();
                $first_work_order_product_category_result = $first_work_order_product_category_relation->result_array();

                foreach ($first_work_order_product_category_result as $key => $value) 
                {
                    $work_order_relation_id = $value['entity_id'];

                    $update_wo_product_array = array('work_order_id' => $first_wo_master_lastid , 'status' => 2);

                    $this->db->where('entity_id', $work_order_relation_id);
                    $this->db->update('work_order_product_relation', $update_wo_product_array);
                }

                $second_wo_data_master_save = "INSERT INTO work_order_master (work_order_no,work_order_type,work_order_category,work_order_date,special_customer,sales_order_id,status,work_order_status, workorder_type) VALUES ('".$Second_doc_no."','".$work_order_type."','".$work_order_category."','".$work_order_date."','".$special_customer."','".$sales_order_id."','".$order_status."','".$work_order_status."','".$sales_order_type."')";
                $second_save_execute = $this->db->query($second_wo_data_master_save);
                $second_wo_master_lastid = $this->db->insert_id();

                $second_product_category_id = $work_order_product_relation_result[1]['product_category_id'];

                $this->db->select('work_order_product_relation.*');
                $this->db->from('work_order_product_relation');
                $where = '(work_order_product_relation.sales_order_id = "'.$sales_order_id.'" And work_order_product_relation.product_category_id = "'.$second_product_category_id.'" And work_order_product_relation.status = "'.'1'.'")';
                $this->db->where($where);
                $second_work_order_product_category_relation = $this->db->get();
                $second_work_order_product_category_result = $second_work_order_product_category_relation->result_array();

                foreach ($second_work_order_product_category_result as $key => $value) 
                {
                    $work_order_relation_id = $value['entity_id'];

                    $update_wo_product_array = array('work_order_id' => $second_wo_master_lastid , 'status' => 2);

                    $this->db->where('entity_id', $work_order_relation_id);
                    $this->db->update('work_order_product_relation', $update_wo_product_array);
                }

                $third_wo_data_master_save = "INSERT INTO work_order_master (work_order_no,work_order_type,work_order_category,work_order_date,special_customer,sales_order_id,status,work_order_status, workorder_type) VALUES ('".$Third_doc_no."','".$work_order_type."','".$work_order_category."','".$work_order_date."','".$special_customer."','".$sales_order_id."','".$order_status."','".$work_order_status."','".$sales_order_type."')";
                $third_save_execute = $this->db->query($third_wo_data_master_save);
                $third_wo_master_lastid = $this->db->insert_id();

                $third_product_category_id = $work_order_product_relation_result[2]['product_category_id'];

                $this->db->select('work_order_product_relation.*');
                $this->db->from('work_order_product_relation');
                $where = '(work_order_product_relation.sales_order_id = "'.$sales_order_id.'" And work_order_product_relation.product_category_id = "'.$third_product_category_id.'" And work_order_product_relation.status = "'.'1'.'")';
                $this->db->where($where);
                $third_work_order_product_category_relation = $this->db->get();
                $third_work_order_product_category_result = $third_work_order_product_category_relation->result_array();

                foreach ($third_work_order_product_category_result as $key => $value) 
                {
                    $work_order_relation_id = $value['entity_id'];

                    $update_wo_product_array = array('work_order_id' => $third_wo_master_lastid , 'status' => 2);

                    $this->db->where('entity_id', $work_order_relation_id);
                    $this->db->update('work_order_product_relation', $update_wo_product_array);
                }
            }elseif($work_order_product_relation_count == 4)
            {
                $First_doc_no = $doc_no.'-'."A";
                $Second_doc_no = $doc_no.'-'."B";
                $Third_doc_no = $doc_no.'-'."C";
                $Fourth_doc_no = $doc_no.'-'."D";

                $first_wo_data_master_save = "INSERT INTO work_order_master (work_order_no,work_order_type,work_order_category,work_order_date,special_customer,sales_order_id,status,work_order_status, workorder_type) VALUES ('".$First_doc_no."','".$work_order_type."','".$work_order_category."','".$work_order_date."','".$special_customer."','".$sales_order_id."','".$order_status."','".$work_order_status."','".$sales_order_type."')";
                $first_save_execute = $this->db->query($first_wo_data_master_save);
                $first_wo_master_lastid = $this->db->insert_id();

                $first_product_category_id = $work_order_product_relation_result[0]['product_category_id'];

                $this->db->select('work_order_product_relation.*');
                $this->db->from('work_order_product_relation');
                $where = '(work_order_product_relation.sales_order_id = "'.$sales_order_id.'" And work_order_product_relation.product_category_id = "'.$first_product_category_id.'" And work_order_product_relation.status = "'.'1'.'")';
                $this->db->where($where);
                $first_work_order_product_category_relation = $this->db->get();
                $first_work_order_product_category_result = $first_work_order_product_category_relation->result_array();

                foreach ($first_work_order_product_category_result as $key => $value) 
                {
                    $work_order_relation_id = $value['entity_id'];

                    $update_wo_product_array = array('work_order_id' => $first_wo_master_lastid , 'status' => 2);

                    $this->db->where('entity_id', $work_order_relation_id);
                    $this->db->update('work_order_product_relation', $update_wo_product_array);
                }

                $second_wo_data_master_save = "INSERT INTO work_order_master (work_order_no,work_order_type,work_order_category,work_order_date,special_customer,sales_order_id,status,work_order_status, workorder_type) VALUES ('".$Second_doc_no."','".$work_order_type."','".$work_order_category."','".$work_order_date."','".$special_customer."','".$sales_order_id."','".$order_status."','".$work_order_status."','".$sales_order_type."')";
                $second_save_execute = $this->db->query($second_wo_data_master_save);
                $second_wo_master_lastid = $this->db->insert_id();

                $second_product_category_id = $work_order_product_relation_result[1]['product_category_id'];

                $this->db->select('work_order_product_relation.*');
                $this->db->from('work_order_product_relation');
                $where = '(work_order_product_relation.sales_order_id = "'.$sales_order_id.'" And work_order_product_relation.product_category_id = "'.$second_product_category_id.'" And work_order_product_relation.status = "'.'1'.'")';
                $this->db->where($where);
                $second_work_order_product_category_relation = $this->db->get();
                $second_work_order_product_category_result = $second_work_order_product_category_relation->result_array();

                foreach ($second_work_order_product_category_result as $key => $value) 
                {
                    $work_order_relation_id = $value['entity_id'];

                    $update_wo_product_array = array('work_order_id' => $second_wo_master_lastid , 'status' => 2);

                    $this->db->where('entity_id', $work_order_relation_id);
                    $this->db->update('work_order_product_relation', $update_wo_product_array);
                }

                $third_wo_data_master_save = "INSERT INTO work_order_master (work_order_no,work_order_type,work_order_category,work_order_date,special_customer,sales_order_id,status,work_order_status, workorder_type) VALUES ('".$Third_doc_no."','".$work_order_type."','".$work_order_category."','".$work_order_date."','".$special_customer."','".$sales_order_id."','".$order_status."','".$work_order_status."','".$sales_order_type."')";
                $third_save_execute = $this->db->query($third_wo_data_master_save);
                $third_wo_master_lastid = $this->db->insert_id();

                $third_product_category_id = $work_order_product_relation_result[2]['product_category_id'];

                $this->db->select('work_order_product_relation.*');
                $this->db->from('work_order_product_relation');
                $where = '(work_order_product_relation.sales_order_id = "'.$sales_order_id.'" And work_order_product_relation.product_category_id = "'.$third_product_category_id.'" And work_order_product_relation.status = "'.'1'.'")';
                $this->db->where($where);
                $third_work_order_product_category_relation = $this->db->get();
                $third_work_order_product_category_result = $third_work_order_product_category_relation->result_array();

                foreach ($third_work_order_product_category_result as $key => $value) 
                {
                    $work_order_relation_id = $value['entity_id'];

                    $update_wo_product_array = array('work_order_id' => $third_wo_master_lastid , 'status' => 2);

                    $this->db->where('entity_id', $work_order_relation_id);
                    $this->db->update('work_order_product_relation', $update_wo_product_array);
                }

                $fourth_wo_data_master_save = "INSERT INTO work_order_master (work_order_no,work_order_type,work_order_category,work_order_date,special_customer,sales_order_id,status,work_order_status, workorder_type) VALUES ('".$Fourth_doc_no."','".$work_order_type."','".$work_order_category."','".$work_order_date."','".$special_customer."','".$sales_order_id."','".$order_status."','".$work_order_status."','".$sales_order_type."')";
                $fourth_save_execute = $this->db->query($fourth_wo_data_master_save);
                $fourth_wo_master_lastid = $this->db->insert_id();

                $fourth_product_category_id = $work_order_product_relation_result[3]['product_category_id'];

                $this->db->select('work_order_product_relation.*');
                $this->db->from('work_order_product_relation');
                $where = '(work_order_product_relation.sales_order_id = "'.$sales_order_id.'" And work_order_product_relation.product_category_id = "'.$fourth_product_category_id.'" And work_order_product_relation.status = "'.'1'.'")';
                $this->db->where($where);
                $fourth_work_order_product_category_relation = $this->db->get();
                $fourth_work_order_product_category_result = $fourth_work_order_product_category_relation->result_array();

                foreach ($fourth_work_order_product_category_result as $key => $value) 
                {
                    $work_order_relation_id = $value['entity_id'];

                    $update_wo_product_array = array('work_order_id' => $fourth_wo_master_lastid , 'status' => 2);

                    $this->db->where('entity_id', $work_order_relation_id);
                    $this->db->update('work_order_product_relation', $update_wo_product_array);
                }
            }elseif($work_order_product_relation_count == 5)
            {
                $First_doc_no = $doc_no.'-'."A";
                $Second_doc_no = $doc_no.'-'."B";
                $Third_doc_no = $doc_no.'-'."C";
                $Fourth_doc_no = $doc_no.'-'."D";
                $Fifth_doc_no = $doc_no.'-'."E";

                $first_wo_data_master_save = "INSERT INTO work_order_master (work_order_no,work_order_type,work_order_category,work_order_date,special_customer,sales_order_id,status,work_order_status, workorder_type) VALUES ('".$First_doc_no."','".$work_order_type."','".$work_order_category."','".$work_order_date."','".$special_customer."','".$sales_order_id."','".$order_status."','".$work_order_status."','".$sales_order_type."')";
                $first_save_execute = $this->db->query($first_wo_data_master_save);
                $first_wo_master_lastid = $this->db->insert_id();

                $first_product_category_id = $work_order_product_relation_result[0]['product_category_id'];

                $this->db->select('work_order_product_relation.*');
                $this->db->from('work_order_product_relation');
                $where = '(work_order_product_relation.sales_order_id = "'.$sales_order_id.'" And work_order_product_relation.product_category_id = "'.$first_product_category_id.'" And work_order_product_relation.status = "'.'1'.'")';
                $this->db->where($where);
                $first_work_order_product_category_relation = $this->db->get();
                $first_work_order_product_category_result = $first_work_order_product_category_relation->result_array();

                foreach ($first_work_order_product_category_result as $key => $value) 
                {
                    $work_order_relation_id = $value['entity_id'];

                    $update_wo_product_array = array('work_order_id' => $first_wo_master_lastid , 'status' => 2);

                    $this->db->where('entity_id', $work_order_relation_id);
                    $this->db->update('work_order_product_relation', $update_wo_product_array);
                }

                $second_wo_data_master_save = "INSERT INTO work_order_master (work_order_no,work_order_type,work_order_category,work_order_date,special_customer,sales_order_id,status,work_order_status, workorder_type) VALUES ('".$Second_doc_no."','".$work_order_type."','".$work_order_category."','".$work_order_date."','".$special_customer."','".$sales_order_id."','".$order_status."','".$work_order_status."','".$sales_order_type."')";
                $second_save_execute = $this->db->query($second_wo_data_master_save);
                $second_wo_master_lastid = $this->db->insert_id();

                $second_product_category_id = $work_order_product_relation_result[1]['product_category_id'];

                $this->db->select('work_order_product_relation.*');
                $this->db->from('work_order_product_relation');
                $where = '(work_order_product_relation.sales_order_id = "'.$sales_order_id.'" And work_order_product_relation.product_category_id = "'.$second_product_category_id.'" And work_order_product_relation.status = "'.'1'.'")';
                $this->db->where($where);
                $second_work_order_product_category_relation = $this->db->get();
                $second_work_order_product_category_result = $second_work_order_product_category_relation->result_array();

                foreach ($second_work_order_product_category_result as $key => $value) 
                {
                    $work_order_relation_id = $value['entity_id'];

                    $update_wo_product_array = array('work_order_id' => $second_wo_master_lastid , 'status' => 2);

                    $this->db->where('entity_id', $work_order_relation_id);
                    $this->db->update('work_order_product_relation', $update_wo_product_array);
                }

                $third_wo_data_master_save = "INSERT INTO work_order_master (work_order_no,work_order_type,work_order_category,work_order_date,special_customer,sales_order_id,status,work_order_status, workorder_type) VALUES ('".$Third_doc_no."','".$work_order_type."','".$work_order_category."','".$work_order_date."','".$special_customer."','".$sales_order_id."','".$order_status."','".$work_order_status."','".$sales_order_type."')";
                $third_save_execute = $this->db->query($third_wo_data_master_save);
                $third_wo_master_lastid = $this->db->insert_id();

                $third_product_category_id = $work_order_product_relation_result[2]['product_category_id'];

                $this->db->select('work_order_product_relation.*');
                $this->db->from('work_order_product_relation');
                $where = '(work_order_product_relation.sales_order_id = "'.$sales_order_id.'" And work_order_product_relation.product_category_id = "'.$third_product_category_id.'" And work_order_product_relation.status = "'.'1'.'")';
                $this->db->where($where);
                $third_work_order_product_category_relation = $this->db->get();
                $third_work_order_product_category_result = $third_work_order_product_category_relation->result_array();

                foreach ($third_work_order_product_category_result as $key => $value) 
                {
                    $work_order_relation_id = $value['entity_id'];

                    $update_wo_product_array = array('work_order_id' => $third_wo_master_lastid , 'status' => 2);

                    $this->db->where('entity_id', $work_order_relation_id);
                    $this->db->update('work_order_product_relation', $update_wo_product_array);
                }

                $fourth_wo_data_master_save = "INSERT INTO work_order_master (work_order_no,work_order_type,work_order_category,work_order_date,special_customer,sales_order_id,status,work_order_status, workorder_type) VALUES ('".$Fourth_doc_no."','".$work_order_type."','".$work_order_category."','".$work_order_date."','".$special_customer."','".$sales_order_id."','".$order_status."','".$work_order_status."','".$sales_order_type."')";
                $fourth_save_execute = $this->db->query($fourth_wo_data_master_save);
                $fourth_wo_master_lastid = $this->db->insert_id();

                $fourth_product_category_id = $work_order_product_relation_result[3]['product_category_id'];

                $this->db->select('work_order_product_relation.*');
                $this->db->from('work_order_product_relation');
                $where = '(work_order_product_relation.sales_order_id = "'.$sales_order_id.'" And work_order_product_relation.product_category_id = "'.$fourth_product_category_id.'" And work_order_product_relation.status = "'.'1'.'")';
                $this->db->where($where);
                $fourth_work_order_product_category_relation = $this->db->get();
                $fourth_work_order_product_category_result = $fourth_work_order_product_category_relation->result_array();

                foreach ($fourth_work_order_product_category_result as $key => $value) 
                {
                    $work_order_relation_id = $value['entity_id'];

                    $update_wo_product_array = array('work_order_id' => $fourth_wo_master_lastid , 'status' => 2);

                    $this->db->where('entity_id', $work_order_relation_id);
                    $this->db->update('work_order_product_relation', $update_wo_product_array);
                }

                $fifth_wo_data_master_save = "INSERT INTO work_order_master (work_order_no,work_order_type,work_order_category,work_order_date,special_customer,sales_order_id,status,work_order_status, workorder_type) VALUES ('".$Fifth_doc_no."','".$work_order_type."','".$work_order_category."','".$work_order_date."','".$special_customer."','".$sales_order_id."','".$order_status."','".$work_order_status."','".$sales_order_type."')";
                $fifth_save_execute = $this->db->query($fifth_wo_data_master_save);
                $fifth_wo_master_lastid = $this->db->insert_id();

                $fifth_product_category_id = $work_order_product_relation_result[4]['product_category_id'];

                $this->db->select('work_order_product_relation.*');
                $this->db->from('work_order_product_relation');
                $where = '(work_order_product_relation.sales_order_id = "'.$sales_order_id.'" And work_order_product_relation.product_category_id = "'.$fifth_product_category_id.'" And work_order_product_relation.status = "'.'1'.'")';
                $this->db->where($where);
                $fifth_work_order_product_category_relation = $this->db->get();
                $fifth_work_order_product_category_result = $fifth_work_order_product_category_relation->result_array();

                foreach ($fifth_work_order_product_category_result as $key => $value) 
                {
                    $work_order_relation_id = $value['entity_id'];

                    $update_wo_product_array = array('work_order_id' => $fifth_wo_master_lastid , 'status' => 2);

                    $this->db->where('entity_id', $work_order_relation_id);
                    $this->db->update('work_order_product_relation', $update_wo_product_array);
                }
            }
        }

        $this->db->select('*');
        $this->db->from('order_execution_product_relation');
        $where = '(order_execution_product_relation.push_to IS NOT NULL And order_execution_product_relation.status = "'.'1'.'" And order_execution_product_relation.push_to = "'.'2'.'" And order_execution_product_relation.sales_order_id = "'.$sales_order_id.'")';
        $this->db->where($where);
        $tred_order_data = $this->db->get();
        $tred_order_data_result = $tred_order_data->result_array();

        if(!empty($tred_order_data_result))
        {
            foreach($tred_order_data_result as $key => $value)
            {
                $to_product_id = $value['product_id'];
                $to_product_qty = $value['rfq_qty'];
                $product_category_id = $value['product_category_id'];

                $this->db->select('sales_order_product_relation.*');
                $this->db->from('sales_order_product_relation');
                $where = '(sales_order_product_relation.sales_order_id = "'.$sales_order_id.'" And sales_order_product_relation.product_id = "'.$to_product_id.'")';
                $this->db->where($where);
                $sales_order_product_relation_data = $this->db->get();
                $sales_order_product_relation_result = $sales_order_product_relation_data->row_array();
                $product_custom_description = $sales_order_product_relation_result['product_custom_description'];

                $to_product_relation_array = array('sales_order_id' => $sales_order_id , 'product_category_id' => $product_category_id , 'product_id' => $to_product_id , 'work_order_qty' => $to_product_qty, 'product_custom_description' => $product_custom_description , 'status' => 1);
                $this->db->insert('work_order_product_relation', $to_product_relation_array);
            }

            $this->db->select('work_order_product_relation.*');
            $this->db->from('work_order_product_relation');
            $where = '(work_order_product_relation.sales_order_id = "'.$sales_order_id.'" And work_order_product_relation.status = "'.'1'.'")';
            $this->db->where($where);
            $this->db->group_by('work_order_product_relation.product_category_id');
            $trade_order_product_relation = $this->db->get();
            $tred_order_product_relation_result = $trade_order_product_relation->result_array();
            $trade_order_product_relation_count = $trade_order_product_relation->num_rows();

            if($sales_order_type == 1){
                $sales_order_type_initial = 'MH';

            }elseif($sales_order_type == 2){
                $sales_order_type_initial = 'PS';

            }elseif($sales_order_type == 3){
                $sales_order_type_initial = 'VC';

            }elseif($sales_order_type == 4){
                $sales_order_type_initial = 'TD';

            }elseif($sales_order_type == 5){
                $sales_order_type_initial = 'OT';

            }


            if($special_customer == 1){
                $special_customer_inital = 'S';

            }elseif($special_customer == 2){
                $special_customer_inital = 'M';

            }elseif($special_customer == 3){
                $special_customer_inital = 'E';

            }elseif($special_customer == 4){
                $special_customer_inital = 'K';

            }elseif($special_customer == 5){
                $special_customer_inital = 'A';

            }elseif($special_customer == 6){
                $special_customer_inital = 'X';

            }

            $this->db->select('work_order_no');
            $this->db->from('work_order_master');
            $where = '(work_order_master.work_order_type = "'.'2'.'")';
            $this->db->where($where);
            $this->db->order_by('entity_id', 'DESC');
            $this->db->limit(1);
            $workorder_master = $this->db->get();
            $results_workorder_master = $workorder_master->result_array();

            $this->db->select('document_series_no');
            $this->db->from('documentseries_master');
            $this->db->where('entity_id=6');
            $doc_record=$this->db->get();
            $results_doc_record = $doc_record->result_array();

            $doc_serial_no = $results_doc_record[0]['document_series_no'];
            $doc_data_seprate = explode('/', $doc_serial_no);

            if(empty($results_workorder_master[0]['work_order_no']))
            {
                
                $first_no = '0001';
                $doc_no = $doc_serial_no.$special_customer_inital.'/'.$first_no;

            }elseif(!empty($results_workorder_master))
            {
                $wo_serial_no = $results_workorder_master[0]['work_order_no'];
                $wo_data_seprate = explode('/', $wo_serial_no);

                $workorder_first_char = $wo_data_seprate['0'];
                $workorder_second_char = $wo_data_seprate['1'];
                $next_en = $workorder_second_char + 1;
                $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
                $workorder_first_char_seprate = explode('-', $workorder_first_char);

                $doc_no = $workorder_first_char_seprate['0'].'-'. $workorder_first_char_seprate['1'].'-'.$special_customer_inital.'/'.$next_doc_no;
            }

            $tred_order_type = 2;
            $tred_order_category = 1;
            date_default_timezone_set('Asia/Kolkata');
            $tred_order_date = date("Y-m-d");
            $order_status = 1;
            $tred_order_status =1;

            if($trade_order_product_relation_count == 1 || $trade_order_product_relation_count >= 6)
            {
                $to_data_master_save = "INSERT INTO work_order_master (work_order_no,work_order_type,work_order_category,work_order_date,special_customer,sales_order_id,status,work_order_status, workorder_type) VALUES ('".$doc_no."','".$tred_order_type."','".$tred_order_category."','".$tred_order_date."','".$special_customer."','".$sales_order_id."','".$order_status."','".$tred_order_status."','".$sales_order_type."')";
                $save_execute = $this->db->query($to_data_master_save);
                $to_master_lastid = $this->db->insert_id();

                $this->db->select('work_order_product_relation.*');
                $this->db->from('work_order_product_relation');
                $where = '(work_order_product_relation.sales_order_id = "'.$sales_order_id.'" And work_order_product_relation.status = "'.'1'.'")';
                $this->db->where($where);
                $trade_order_product_category_relation = $this->db->get();
                $trade_order_product_category_result = $trade_order_product_category_relation->result_array();

                foreach ($trade_order_product_category_result as $key => $value) 
                {
                    $trade_order_relation_id = $value['entity_id'];

                    $update_to_product_array = array('work_order_id' => $to_master_lastid , 'status' => 2);

                    $this->db->where('entity_id', $trade_order_relation_id);
                    $this->db->update('work_order_product_relation', $update_to_product_array);
                }
            }elseif($trade_order_product_relation_count == 2)
            {
                $First_doc_no = $doc_no.'-'."A";
                $Second_doc_no = $doc_no.'-'."B";

                $first_to_data_master_save = "INSERT INTO work_order_master (work_order_no,work_order_type,work_order_category,work_order_date,special_customer,sales_order_id,status,work_order_status, workorder_type) VALUES ('".$First_doc_no."','".$tred_order_type."','".$tred_order_category."','".$tred_order_date."','".$special_customer."','".$sales_order_id."','".$order_status."','".$tred_order_status."','".$sales_order_type."')";
                $first_save_execute = $this->db->query($first_to_data_master_save);
                $first_to_master_lastid = $this->db->insert_id();

                $first_product_category_id = $tred_order_product_relation_result[0]['product_category_id'];

                $this->db->select('work_order_product_relation.*');
                $this->db->from('work_order_product_relation');
                $where = '(work_order_product_relation.sales_order_id = "'.$sales_order_id.'" And work_order_product_relation.product_category_id = "'.$first_product_category_id.'" And work_order_product_relation.status = "'.'1'.'")';
                $this->db->where($where);
                $first_tred_order_product_category_relation = $this->db->get();
                $first_tred_order_product_category_result = $first_tred_order_product_category_relation->result_array();

                foreach ($first_tred_order_product_category_result as $key => $value) 
                {
                    $tred_order_relation_id = $value['entity_id'];

                    $update_to_product_array = array('work_order_id' => $first_to_master_lastid , 'status' => 2);

                    $this->db->where('entity_id', $tred_order_relation_id);
                    $this->db->update('work_order_product_relation', $update_to_product_array);
                }

                $second_to_data_master_save = "INSERT INTO work_order_master (work_order_no,work_order_type,work_order_category,work_order_date,special_customer,sales_order_id,status,work_order_status, workorder_type) VALUES ('".$Second_doc_no."','".$tred_order_type."','".$tred_order_category."','".$tred_order_date."','".$special_customer."','".$sales_order_id."','".$order_status."','".$tred_order_status."','".$sales_order_type."')";
                $second_save_execute = $this->db->query($second_to_data_master_save);
                $second_to_master_lastid = $this->db->insert_id();

                $second_product_category_id = $tred_order_product_relation_result[1]['product_category_id'];

                $this->db->select('work_order_product_relation.*');
                $this->db->from('work_order_product_relation');
                $where = '(work_order_product_relation.sales_order_id = "'.$sales_order_id.'" And work_order_product_relation.product_category_id = "'.$second_product_category_id.'" And work_order_product_relation.status = "'.'1'.'")';
                $this->db->where($where);
                $second_tred_order_product_category_relation = $this->db->get();
                $second_tred_order_product_category_result = $second_tred_order_product_category_relation->result_array();

                foreach ($second_tred_order_product_category_result as $key => $value) 
                {
                    $tred_order_relation_id = $value['entity_id'];

                    $update_to_product_array = array('work_order_id' => $second_to_master_lastid , 'status' => 2);

                    $this->db->where('entity_id', $tred_order_relation_id);
                    $this->db->update('work_order_product_relation', $update_to_product_array);
                }
            }elseif($trade_order_product_relation_count == 3)
            {
                $First_doc_no = $doc_no.'-'."A";
                $Second_doc_no = $doc_no.'-'."B";
                $Third_doc_no = $doc_no.'-'."C";

                $first_to_data_master_save = "INSERT INTO work_order_master (work_order_no,work_order_type,work_order_category,work_order_date,special_customer,sales_order_id,status,work_order_status, workorder_type) VALUES ('".$First_doc_no."','".$tred_order_type."','".$tred_order_category."','".$tred_order_date."','".$special_customer."','".$sales_order_id."','".$order_status."','".$tred_order_status."','".$sales_order_type."')";
                $first_save_execute = $this->db->query($first_to_data_master_save);
                $first_to_master_lastid = $this->db->insert_id();

                $first_product_category_id = $tred_order_product_relation_result[0]['product_category_id'];

                $this->db->select('work_order_product_relation.*');
                $this->db->from('work_order_product_relation');
                $where = '(work_order_product_relation.sales_order_id = "'.$sales_order_id.'" And work_order_product_relation.product_category_id = "'.$first_product_category_id.'" And work_order_product_relation.status = "'.'1'.'")';
                $this->db->where($where);
                $first_tred_order_product_category_relation = $this->db->get();
                $first_tred_order_product_category_result = $first_tred_order_product_category_relation->result_array();

                foreach ($first_tred_order_product_category_result as $key => $value) 
                {
                    $tred_order_relation_id = $value['entity_id'];

                    $update_to_product_array = array('work_order_id' => $first_to_master_lastid , 'status' => 2);

                    $this->db->where('entity_id', $tred_order_relation_id);
                    $this->db->update('work_order_product_relation', $update_to_product_array);
                }

                $second_to_data_master_save = "INSERT INTO work_order_master (work_order_no,work_order_type,work_order_category,work_order_date,special_customer,sales_order_id,status,work_order_status, workorder_type) VALUES ('".$Second_doc_no."','".$tred_order_type."','".$tred_order_category."','".$tred_order_date."','".$special_customer."','".$sales_order_id."','".$order_status."','".$tred_order_status."','".$sales_order_type."')";
                $second_save_execute = $this->db->query($second_to_data_master_save);
                $second_to_master_lastid = $this->db->insert_id();

                $second_product_category_id = $tred_order_product_relation_result[1]['product_category_id'];

                $this->db->select('work_order_product_relation.*');
                $this->db->from('work_order_product_relation');
                $where = '(work_order_product_relation.sales_order_id = "'.$sales_order_id.'" And work_order_product_relation.product_category_id = "'.$second_product_category_id.'" And work_order_product_relation.status = "'.'1'.'")';
                $this->db->where($where);
                $second_tred_order_product_category_relation = $this->db->get();
                $second_tred_order_product_category_result = $second_tred_order_product_category_relation->result_array();

                foreach ($second_tred_order_product_category_result as $key => $value) 
                {
                    $tred_order_relation_id = $value['entity_id'];

                    $update_to_product_array = array('work_order_id' => $second_to_master_lastid , 'status' => 2);

                    $this->db->where('entity_id', $tred_order_relation_id);
                    $this->db->update('work_order_product_relation', $update_to_product_array);
                }

                $third_to_data_master_save = "INSERT INTO work_order_master (work_order_no,work_order_type,work_order_category,work_order_date,special_customer,sales_order_id,status,work_order_status, workorder_type) VALUES ('".$Third_doc_no."','".$tred_order_type."','".$tred_order_category."','".$tred_order_date."','".$special_customer."','".$sales_order_id."','".$order_status."','".$tred_order_status."','".$sales_order_type."')";
                $third_save_execute = $this->db->query($third_to_data_master_save);
                $third_to_master_lastid = $this->db->insert_id();

                $third_product_category_id = $tred_order_product_relation_result[2]['product_category_id'];

                $this->db->select('work_order_product_relation.*');
                $this->db->from('work_order_product_relation');
                $where = '(work_order_product_relation.sales_order_id = "'.$sales_order_id.'" And work_order_product_relation.product_category_id = "'.$third_product_category_id.'" And work_order_product_relation.status = "'.'1'.'")';
                $this->db->where($where);
                $third_tred_order_product_category_relation = $this->db->get();
                $third_tred_order_product_category_result = $third_tred_order_product_category_relation->result_array();

                foreach ($third_tred_order_product_category_result as $key => $value) 
                {
                    $tred_order_relation_id = $value['entity_id'];

                    $update_to_product_array = array('work_order_id' => $third_to_master_lastid , 'status' => 2);

                    $this->db->where('entity_id', $tred_order_relation_id);
                    $this->db->update('work_order_product_relation', $update_to_product_array);
                }
            }elseif($trade_order_product_relation_count == 4)
            {
                $First_doc_no = $doc_no.'-'."A";
                $Second_doc_no = $doc_no.'-'."B";
                $Third_doc_no = $doc_no.'-'."C";
                $Fourth_doc_no = $doc_no.'-'."D";

                $first_to_data_master_save = "INSERT INTO work_order_master (work_order_no,work_order_type,work_order_category,work_order_date,special_customer,sales_order_id,status,work_order_status, workorder_type) VALUES ('".$First_doc_no."','".$tred_order_type."','".$tred_order_category."','".$tred_order_date."','".$special_customer."','".$sales_order_id."','".$order_status."','".$tred_order_status."','".$sales_order_type."')";
                $first_save_execute = $this->db->query($first_to_data_master_save);
                $first_to_master_lastid = $this->db->insert_id();

                $first_product_category_id = $tred_order_product_relation_result[0]['product_category_id'];

                $this->db->select('work_order_product_relation.*');
                $this->db->from('work_order_product_relation');
                $where = '(work_order_product_relation.sales_order_id = "'.$sales_order_id.'" And work_order_product_relation.product_category_id = "'.$first_product_category_id.'" And work_order_product_relation.status = "'.'1'.'")';
                $this->db->where($where);
                $first_tred_order_product_category_relation = $this->db->get();
                $first_tred_order_product_category_result = $first_tred_order_product_category_relation->result_array();

                foreach ($first_tred_order_product_category_result as $key => $value) 
                {
                    $tred_order_relation_id = $value['entity_id'];

                    $update_to_product_array = array('work_order_id' => $first_to_master_lastid , 'status' => 2);

                    $this->db->where('entity_id', $tred_order_relation_id);
                    $this->db->update('work_order_product_relation', $update_to_product_array);
                }

                $second_to_data_master_save = "INSERT INTO work_order_master (work_order_no,work_order_type,work_order_category,work_order_date,special_customer,sales_order_id,status,work_order_status, workorder_type) VALUES ('".$Second_doc_no."','".$tred_order_type."','".$tred_order_category."','".$tred_order_date."','".$special_customer."','".$sales_order_id."','".$order_status."','".$tred_order_status."','".$sales_order_type."')";
                $second_save_execute = $this->db->query($second_to_data_master_save);
                $second_to_master_lastid = $this->db->insert_id();

                $second_product_category_id = $tred_order_product_relation_result[1]['product_category_id'];

                $this->db->select('work_order_product_relation.*');
                $this->db->from('work_order_product_relation');
                $where = '(work_order_product_relation.sales_order_id = "'.$sales_order_id.'" And work_order_product_relation.product_category_id = "'.$second_product_category_id.'" And work_order_product_relation.status = "'.'1'.'")';
                $this->db->where($where);
                $second_tred_order_product_category_relation = $this->db->get();
                $second_tred_order_product_category_result = $second_tred_order_product_category_relation->result_array();

                foreach ($second_tred_order_product_category_result as $key => $value) 
                {
                    $tred_order_relation_id = $value['entity_id'];

                    $update_to_product_array = array('work_order_id' => $second_to_master_lastid , 'status' => 2);

                    $this->db->where('entity_id', $tred_order_relation_id);
                    $this->db->update('work_order_product_relation', $update_to_product_array);
                }

                $third_to_data_master_save = "INSERT INTO work_order_master (work_order_no,work_order_type,work_order_category,work_order_date,special_customer,sales_order_id,status,work_order_status, workorder_type) VALUES ('".$Third_doc_no."','".$tred_order_type."','".$tred_order_category."','".$tred_order_date."','".$special_customer."','".$sales_order_id."','".$order_status."','".$tred_order_status."','".$sales_order_type."')";
                $third_save_execute = $this->db->query($third_to_data_master_save);
                $third_to_master_lastid = $this->db->insert_id();

                $third_product_category_id = $tred_order_product_relation_result[2]['product_category_id'];

                $this->db->select('work_order_product_relation.*');
                $this->db->from('work_order_product_relation');
                $where = '(work_order_product_relation.sales_order_id = "'.$sales_order_id.'" And work_order_product_relation.product_category_id = "'.$third_product_category_id.'" And work_order_product_relation.status = "'.'1'.'")';
                $this->db->where($where);
                $third_tred_order_product_category_relation = $this->db->get();
                $third_tred_order_product_category_result = $third_tred_order_product_category_relation->result_array();

                foreach ($third_tred_order_product_category_result as $key => $value) 
                {
                    $tred_order_relation_id = $value['entity_id'];

                    $update_to_product_array = array('work_order_id' => $third_to_master_lastid , 'status' => 2);

                    $this->db->where('entity_id', $tred_order_relation_id);
                    $this->db->update('work_order_product_relation', $update_to_product_array);
                }

                $fourth_to_data_master_save = "INSERT INTO work_order_master (work_order_no,work_order_type,work_order_category,work_order_date,special_customer,sales_order_id,status,work_order_status, workorder_type) VALUES ('".$Fourth_doc_no."','".$tred_order_type."','".$tred_order_category."','".$tred_order_date."','".$special_customer."','".$sales_order_id."','".$order_status."','".$tred_order_status."','".$sales_order_type."')";
                $fourth_save_execute = $this->db->query($fourth_to_data_master_save);
                $fourth_to_master_lastid = $this->db->insert_id();

                $fourth_product_category_id = $tred_order_product_relation_result[3]['product_category_id'];

                $this->db->select('work_order_product_relation.*');
                $this->db->from('work_order_product_relation');
                $where = '(work_order_product_relation.sales_order_id = "'.$sales_order_id.'" And work_order_product_relation.product_category_id = "'.$fourth_product_category_id.'" And work_order_product_relation.status = "'.'1'.'")';
                $this->db->where($where);
                $fourth_tred_order_product_category_relation = $this->db->get();
                $fourth_tred_order_product_category_result = $fourth_tred_order_product_category_relation->result_array();

                foreach ($fourth_tred_order_product_category_result as $key => $value) 
                {
                    $tred_order_relation_id = $value['entity_id'];

                    $update_to_product_array = array('work_order_id' => $fourth_to_master_lastid , 'status' => 2);

                    $this->db->where('entity_id', $tred_order_relation_id);
                    $this->db->update('work_order_product_relation', $update_to_product_array);
                }
            }elseif($trade_order_product_relation_count == 4)
            {
                $First_doc_no = $doc_no.'-'."A";
                $Second_doc_no = $doc_no.'-'."B";
                $Third_doc_no = $doc_no.'-'."C";
                $Fourth_doc_no = $doc_no.'-'."D";
                $Fifth_doc_no = $doc_no.'-'."E";

                $first_to_data_master_save = "INSERT INTO work_order_master (work_order_no,work_order_type,work_order_category,work_order_date,special_customer,sales_order_id,status,work_order_status, workorder_type) VALUES ('".$First_doc_no."','".$tred_order_type."','".$tred_order_category."','".$tred_order_date."','".$special_customer."','".$sales_order_id."','".$order_status."','".$tred_order_status."','".$sales_order_type."')";
                $first_save_execute = $this->db->query($first_to_data_master_save);
                $first_to_master_lastid = $this->db->insert_id();

                $first_product_category_id = $tred_order_product_relation_result[0]['product_category_id'];

                $this->db->select('work_order_product_relation.*');
                $this->db->from('work_order_product_relation');
                $where = '(work_order_product_relation.sales_order_id = "'.$sales_order_id.'" And work_order_product_relation.product_category_id = "'.$first_product_category_id.'" And work_order_product_relation.status = "'.'1'.'")';
                $this->db->where($where);
                $first_tred_order_product_category_relation = $this->db->get();
                $first_tred_order_product_category_result = $first_tred_order_product_category_relation->result_array();

                foreach ($first_tred_order_product_category_result as $key => $value) 
                {
                    $tred_order_relation_id = $value['entity_id'];

                    $update_to_product_array = array('work_order_id' => $first_to_master_lastid , 'status' => 2);

                    $this->db->where('entity_id', $tred_order_relation_id);
                    $this->db->update('work_order_product_relation', $update_to_product_array);
                }

                $second_to_data_master_save = "INSERT INTO work_order_master (work_order_no,work_order_type,work_order_category,work_order_date,special_customer,sales_order_id,status,work_order_status, workorder_type) VALUES ('".$Second_doc_no."','".$tred_order_type."','".$tred_order_category."','".$tred_order_date."','".$special_customer."','".$sales_order_id."','".$order_status."','".$tred_order_status."','".$sales_order_type."')";
                $second_save_execute = $this->db->query($second_to_data_master_save);
                $second_to_master_lastid = $this->db->insert_id();

                $second_product_category_id = $tred_order_product_relation_result[1]['product_category_id'];

                $this->db->select('work_order_product_relation.*');
                $this->db->from('work_order_product_relation');
                $where = '(work_order_product_relation.sales_order_id = "'.$sales_order_id.'" And work_order_product_relation.product_category_id = "'.$second_product_category_id.'" And work_order_product_relation.status = "'.'1'.'")';
                $this->db->where($where);
                $second_tred_order_product_category_relation = $this->db->get();
                $second_tred_order_product_category_result = $second_tred_order_product_category_relation->result_array();

                foreach ($second_tred_order_product_category_result as $key => $value) 
                {
                    $tred_order_relation_id = $value['entity_id'];

                    $update_to_product_array = array('work_order_id' => $second_to_master_lastid , 'status' => 2);

                    $this->db->where('entity_id', $tred_order_relation_id);
                    $this->db->update('work_order_product_relation', $update_to_product_array);
                }

                $third_to_data_master_save = "INSERT INTO work_order_master (work_order_no,work_order_type,work_order_category,work_order_date,special_customer,sales_order_id,status,work_order_status, workorder_type) VALUES ('".$Third_doc_no."','".$tred_order_type."','".$tred_order_category."','".$tred_order_date."','".$special_customer."','".$sales_order_id."','".$order_status."','".$tred_order_status."','".$sales_order_type."')";
                $third_save_execute = $this->db->query($third_to_data_master_save);
                $third_to_master_lastid = $this->db->insert_id();

                $third_product_category_id = $tred_order_product_relation_result[2]['product_category_id'];

                $this->db->select('work_order_product_relation.*');
                $this->db->from('work_order_product_relation');
                $where = '(work_order_product_relation.sales_order_id = "'.$sales_order_id.'" And work_order_product_relation.product_category_id = "'.$third_product_category_id.'" And work_order_product_relation.status = "'.'1'.'")';
                $this->db->where($where);
                $third_tred_order_product_category_relation = $this->db->get();
                $third_tred_order_product_category_result = $third_tred_order_product_category_relation->result_array();

                foreach ($third_tred_order_product_category_result as $key => $value) 
                {
                    $tred_order_relation_id = $value['entity_id'];

                    $update_to_product_array = array('work_order_id' => $third_to_master_lastid , 'status' => 2);

                    $this->db->where('entity_id', $tred_order_relation_id);
                    $this->db->update('work_order_product_relation', $update_to_product_array);
                }

                $fourth_to_data_master_save = "INSERT INTO work_order_master (work_order_no,work_order_type,work_order_category,work_order_date,special_customer,sales_order_id,status,work_order_status, workorder_type) VALUES ('".$Fourth_doc_no."','".$tred_order_type."','".$tred_order_category."','".$tred_order_date."','".$special_customer."','".$sales_order_id."','".$order_status."','".$tred_order_status."','".$sales_order_type."')";
                $fourth_save_execute = $this->db->query($fourth_to_data_master_save);
                $fourth_to_master_lastid = $this->db->insert_id();

                $fourth_product_category_id = $tred_order_product_relation_result[3]['product_category_id'];

                $this->db->select('work_order_product_relation.*');
                $this->db->from('work_order_product_relation');
                $where = '(work_order_product_relation.sales_order_id = "'.$sales_order_id.'" And work_order_product_relation.product_category_id = "'.$fourth_product_category_id.'" And work_order_product_relation.status = "'.'1'.'")';
                $this->db->where($where);
                $fourth_tred_order_product_category_relation = $this->db->get();
                $fourth_tred_order_product_category_result = $fourth_tred_order_product_category_relation->result_array();

                foreach ($fourth_tred_order_product_category_result as $key => $value) 
                {
                    $tred_order_relation_id = $value['entity_id'];

                    $update_to_product_array = array('work_order_id' => $fourth_to_master_lastid , 'status' => 2);

                    $this->db->where('entity_id', $tred_order_relation_id);
                    $this->db->update('work_order_product_relation', $update_to_product_array);
                }

                $fifth_to_data_master_save = "INSERT INTO work_order_master (work_order_no,work_order_type,work_order_category,work_order_date,special_customer,sales_order_id,status,work_order_status, workorder_type) VALUES ('".$Fifth_doc_no."','".$tred_order_type."','".$tred_order_category."','".$tred_order_date."','".$special_customer."','".$sales_order_id."','".$order_status."','".$tred_order_status."','".$sales_order_type."')";
                $fifth_save_execute = $this->db->query($fifth_to_data_master_save);
                $fifth_to_master_lastid = $this->db->insert_id();

                $fifth_product_category_id = $tred_order_product_relation_result[4]['product_category_id'];

                $this->db->select('work_order_product_relation.*');
                $this->db->from('work_order_product_relation');
                $where = '(work_order_product_relation.sales_order_id = "'.$sales_order_id.'" And work_order_product_relation.product_category_id = "'.$fifth_product_category_id.'" And work_order_product_relation.status = "'.'1'.'")';
                $this->db->where($where);
                $fifth_tred_order_product_category_relation = $this->db->get();
                $fifth_tred_order_product_category_result = $fifth_tred_order_product_category_relation->result_array();

                foreach ($fifth_tred_order_product_category_result as $key => $value) 
                {
                    $tred_order_relation_id = $value['entity_id'];

                    $update_to_product_array = array('work_order_id' => $fifth_to_master_lastid , 'status' => 2);

                    $this->db->where('entity_id', $tred_order_relation_id);
                    $this->db->update('work_order_product_relation', $update_to_product_array);
                }
            }
        }


        $this->db->select('*');
        $this->db->from('order_execution_product_relation');
        $where = '(order_execution_product_relation.sales_order_id = "'.$sales_order_id.'")';
        $this->db->where($where);
        $query = $this->db->get();
        $query_result_count = $query->num_rows();

        $this->db->select('*');
        $this->db->from('order_execution_product_relation');
        $where = '(order_execution_product_relation.push_to IS NOT NULL)';
        $this->db->where($where);
        $query_data = $this->db->get();
        $query_result_data = $query_data->result_array();
        
        foreach ($query_result_data as $key => $value) {

            $order_execution_relation_id = $value['entity_id'];
            $order_execution_relation_status = 2;

            $update_order_execution_relation_array = array('status' => $order_execution_relation_status);

            $this->db->where('entity_id', $order_execution_relation_id);
            $this->db->update('order_execution_product_relation', $update_order_execution_relation_array);
        }

        $this->db->select('*');
        $this->db->from('order_execution_product_relation');
        $where = '(order_execution_product_relation.status = "'.'2'.'" And order_execution_product_relation.sales_order_id = "'.$sales_order_id.'")';
        $this->db->where($where);
        $query_complete = $this->db->get();
        $query_result_count_complete = $query_complete->num_rows();

        if($query_result_count == $query_result_count_complete)
        {
            $allocation_status = 2;
            $update_sales_order_array = array('allocation_status' => $allocation_status);

            $this->db->where('entity_id', $sales_order_id);
            $this->db->update('sales_order_register', $update_sales_order_array);
        }

        redirect('vw_sales_order_execution_data');
    }

    public function view_approved_sales_order_execution()
    {
        $data['approved_sales_order_details'] = $this->order_execution_master_model->get_approved_sales_order_data();
        $this->load->view('factory/order_execution_master/vw_approved_order_execution_master_index',$data);
    }
}
?>
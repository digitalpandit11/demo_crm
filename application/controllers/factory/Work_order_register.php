<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Work_order_register extends CI_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('work_order_register_model');
        $this->load->library('session');
        $this->load->library("Workorder_pdf");
    }

	public function index()
	{
        $data['work_order_details'] = $this->work_order_register_model->get_all_pending_work_order();
		$this->load->view('factory/work_order_register/vw_work_order_index',$data);
	}

    public function all_work_order()
    {
        $data['work_order_all_details'] = $this->work_order_register_model->get_all_work_order_data();
        $this->load->view('factory/work_order_register/vw_all_work_order_index',$data);
    }

    public function all_completed_order_list()
    {
        $data['work_order_details_completed'] = $this->work_order_register_model->get_all_work_order();
        $this->load->view('factory/work_order_register/vw_completed_order_index',$data);
    }

    public function create()
    {
        $data['product_list'] = $this->work_order_register_model->get_product_list();
        $data['state_list'] = $this->work_order_register_model->get_state_list();
        $data['customer_list'] = $this->work_order_register_model->get_customer_list();
        $this->load->view('factory/work_order_register/vw_work_order_create',$data);
    }

    public function get_work_order_number()
    {
        $data = $this->input->post();
        if(!empty($data))
        {
            $order_type = $this->input->post('id');
            $data = $this->work_order_register_model->get_work_order_data($order_type);
            echo json_encode([$data]);
        }
    }

    public function add_work_order_product()
    {
        $order_type = $this->input->post('order_type');
        $product_checkbox = $this->input->post('product_checkbox');
        $special_customer = $this->input->post('special_customer');
        $order_date = $this->input->post('order_date');
        $issued_by = $this->input->post('issued_by');
        $issued_to = $this->input->post('issued_to');
        $standard_note = $this->input->post('standard_note');
        $urgency = $this->input->post('urgency');
        $order_descrption = $this->input->post('order_descrption');
        $po_no = $this->input->post('po_no');
        $po_date = $this->input->post('po_date');
        $customer_name = $this->input->post('customer_name');


        // print_r($customer_name);
        // die();


        $order_descrption = $this->input->post('order_descrption');
        $work_order_category = 2;
        $work_order_status = 1;
        $status = 1;

        $workorder_type = $this->input->post('workorder_type');
        // print_r($workorder_type);
        // die();

        if($order_type == 1)
        {
            $this->db->select('work_order_no');
            $this->db->from('work_order_master');
            $where = '(work_order_master.work_order_type = "'.'1'.'")';
            $this->db->where($where);
            $this->db->order_by('entity_id', 'DESC');
            $this->db->limit(1);
            $workorder_master = $this->db->get();
            $results_workorder_master = $workorder_master->result_array();

            if(!empty($results_workorder_master))
            {
                $workorder_serial_no = $results_workorder_master[0]['work_order_no'];
                $workorder_data_seprate = explode('/', $workorder_serial_no);
                $workorder_doc_year = $workorder_data_seprate['1'];
            }

            $this->db->select('document_series_no');
            $this->db->from('documentseries_master');
            $this->db->where('entity_id=5');
            $doc_record=$this->db->get();
            $results_doc_record = $doc_record->result_array();

            $doc_serial_no = $results_doc_record[0]['document_series_no'];
            $doc_data_seprate = explode('/', $doc_serial_no);
            //$doc_year = $doc_data_seprate['1'];
            // print_r($doc_year);
            // die();

            if(empty($results_workorder_master[0]['work_order_no']))
            {

                if($workorder_type == 1){
                    $workorder_type_inital = 'MH';

                }elseif($workorder_type == 2){
                    $workorder_type_inital = 'PS';

                }elseif($workorder_type == 3){
                    $workorder_type_inital = 'VC';

                }elseif($workorder_type == 4){
                    $workorder_type_inital = 'TD';

                }elseif($workorder_type == 5){
                    $workorder_type_inital = 'OT';

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
                    $special_customer_inital = 'O';

                }
                $first_no = '0001';
                $doc_no = $doc_serial_no.$workorder_type_inital.$special_customer_inital.'/'.$first_no;
                // print_r($doc_no);
                // die();
            }elseif(!empty($results_workorder_master))
            {
                

                $wo_serial_no = $results_workorder_master[0]['work_order_no'];
                $wo_data_seprate = explode('/', $wo_serial_no);

                $workorder_first_char = $wo_data_seprate['0'];
                $workorder_second_char = $wo_data_seprate['1'];
                $next_en = $workorder_second_char + 1;
                $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
                $workorder_first_char_seprate = explode('-', $workorder_first_char);
                


                if($workorder_type == 1){
                    $workorder_type_inital = 'MH';

                }elseif($workorder_type == 2){
                    $workorder_type_inital = 'PS';

                }elseif($workorder_type == 3){
                    $workorder_type_inital = 'VC';

                }elseif($workorder_type == 4){
                    $workorder_type_inital = 'TD';

                }elseif($workorder_type == 5){
                    $workorder_type_inital = 'OT';

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
                    $special_customer_inital = 'O';

                }

                $doc_no = $workorder_first_char_seprate['0'].'-'. $workorder_type_inital.'-'.$special_customer_inital.'/'.$next_doc_no;
                // print_r($doc_no);
                // die();
                



                // $doc_type = $workorder_data_seprate['0'];
                // $ex_no = $workorder_data_seprate['2'];
                // $next_en = $ex_no + 1;
                // $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
                // $doc_no = $doc_type.'/'.$workorder_doc_year.'/'.$special_customer_inital.'/'.$next_doc_no;
            }

            // date_default_timezone_set('Asia/Kolkata');
            // $work_order_date = date("Y-m-d");

            // $data_array = array('order_number' => $doc_no , 'order_date' => $work_order_date);
            // $data_result['data'] = json_encode($data_array);
            // return $data_array;
        }elseif($order_type == 2)
        {
            $this->db->select('work_order_no');
            $this->db->from('work_order_master');
            $where = '(work_order_master.work_order_type = "'.'2'.'")';
            $this->db->where($where);
            $this->db->order_by('entity_id', 'DESC');
            $this->db->limit(1);
            $workorder_master = $this->db->get();
            $results_workorder_master = $workorder_master->result_array();
            
            if(!empty($results_workorder_master))
            {
                $workorder_serial_no = $results_workorder_master[0]['work_order_no'];
                $workorder_data_seprate = explode('/', $workorder_serial_no);
                $workorder_doc_year = $workorder_data_seprate['1'];
            }

            $this->db->select('document_series_no');
            $this->db->from('documentseries_master');
            $this->db->where('entity_id=6');
            $doc_record=$this->db->get();
            $results_doc_record = $doc_record->result_array();

            $doc_serial_no = $results_doc_record[0]['document_series_no'];
            $doc_data_seprate = explode('/', $doc_serial_no);
            //$doc_year = $doc_data_seprate['1'];



            if(empty($results_workorder_master[0]['work_order_no']))
            {

                if($workorder_type == 1){
                    $workorder_type_inital = 'MH';

                }elseif($workorder_type == 2){
                    $workorder_type_inital = 'PS';

                }elseif($workorder_type == 3){
                    $workorder_type_inital = 'VC';

                }elseif($workorder_type == 4){
                    $workorder_type_inital = 'TD';

                }elseif($workorder_type == 5){
                    $workorder_type_inital = 'OT';

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

                }
                $first_no = '0001';
                $doc_no = $doc_serial_no.$workorder_type_inital.$special_customer_inital.'/'.$first_no;

            }elseif(!empty($results_workorder_master))
            {
                $wo_serial_no = $results_workorder_master[0]['work_order_no'];
                $wo_data_seprate = explode('/', $wo_serial_no);

                $workorder_first_char = $wo_data_seprate['0'];
                $workorder_second_char = $wo_data_seprate['1'];
                $next_en = $workorder_second_char + 1;
                $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
                $workorder_first_char_seprate = explode('-', $workorder_first_char);

                if($workorder_type == 1){
                    $workorder_type_inital = 'MH';

                }elseif($workorder_type == 2){
                    $workorder_type_inital = 'PS';

                }elseif($workorder_type == 3){
                    $workorder_type_inital = 'VC';

                }elseif($workorder_type == 4){
                    $workorder_type_inital = 'TD';

                }elseif($workorder_type == 5){
                    $workorder_type_inital = 'OT';

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

                }

                $doc_no = $workorder_first_char_seprate['0'].'-'. $workorder_type_inital.'-'.$special_customer_inital.'/'.$next_doc_no;

                
            }

            // date_default_timezone_set('Asia/Kolkata');
            // $work_order_date = date("Y-m-d");

            // $data_array = array('order_number' => $doc_no , 'order_date' => $work_order_date);
            // $data_result['data'] = json_encode($data_array);
            // return $data_array;
        }
        // print_r($doc_no);
        // die();
        $work_order_array = array('work_order_no' => $doc_no , 'work_order_type' => $order_type , 'work_order_category' => $work_order_category , 'work_order_date' => $order_date, 'special_customer' => $special_customer , 'issued_by' => $issued_by , 'issued_to' => $issued_to , 'standard_note' => $standard_note , 'urgency' => $urgency , 'work_order_description' => $order_descrption , 'work_order_status' => $work_order_status , 'status' => $status, 'workorder_type' => $workorder_type, 'po_no' => $po_no, 'po_date' => $po_date, 'customer_id' => $customer_name);

        $this->db->insert('work_order_master', $work_order_array);
        $work_order_lastid = $this->db->insert_id();

        foreach ($product_checkbox as $key => $value) {
            $product_id = $value;
            $this->db->select('product_master.*');
            $this->db->from('product_master');
            
            $where = '(product_master.entity_id = "'.$product_id.'" )';
            $this->db->where($where);
            $product_master_data = $this->db->get();
            $product_master_data_result = $product_master_data->result_array();
            $product_custom_description = $product_master_data_result[0]['product_long_description'];

             $work_order_product_array = array('work_order_id' => $work_order_lastid , 'product_id' => $product_id , 'status' => $status, 'product_custom_description' => $product_custom_description);
             $this->db->insert('work_order_product_relation', $work_order_product_array);
        }
        echo $work_order_lastid;
    }

    public function edit_work_order_data()
    {
        $entity_id = $this->uri->segment(2);
        $data['entity_id'] = $entity_id;
        $data['product_list'] = $this->work_order_register_model->get_product_list();
        $data['order_product_list'] = $this->work_order_register_model->get_order_product_list($entity_id);
        $this->load->view('factory/work_order_register/vw_work_order_edit',$data);
    }

    public function get_order_details_by_id()
    {
        $entity_id = $this->input->post('entity_id',TRUE);
        $data = $this->work_order_register_model->get_order_details_by_id_model($entity_id)->result();
        // print_r($data);
        // die();
        echo json_encode($data);
    }

    public function update_product_qty()
    {
        $entity_id = $this->input->post('order_relation_entity_id');
        $product_qty = $this->input->post('product_qty');

        $update_array = array('entity_id' => $entity_id,'work_order_qty' => $product_qty);
        $data = $this->work_order_register_model->update_order_product_relation($update_array);

        echo json_encode($data);
    }

    public function update_product_custom_description()
    {
        $entity_id = $this->input->post('order_relation_entity_id');
        $product_custom_description = $this->input->post('product_custom_description');

        $update_array = array('entity_id' => $entity_id,'product_custom_description' => $product_custom_description);
        $data = $this->work_order_register_model->update_order_product_relation($update_array);

        echo json_encode($data);
    }

    public function delete_order_product()
    {
        $entity_id = $this->input->post('id');
        $result = $this->work_order_register_model->delete_order_product($entity_id);
        echo json_encode($result);
    }

    public function update_work_order_product()
    {
        $entity_id = $this->input->post('entity_id');
        $product_checkbox = $this->input->post('product_checkbox');
        $exp_delivery_date = $this->input->post('exp_delivery_date');
        $order_date = $this->input->post('order_date');

        $issued_by = $this->input->post('issued_by');
        $issued_to = $this->input->post('issued_to');
        $standard_note = $this->input->post('standard_note');
        $urgency = $this->input->post('urgency');
        $order_descrption = $this->input->post('order_descrption');

        $po_no = $this->input->post('po_no');
        $po_date = $this->input->post('po_date');

        $status = 1;

        $work_order_array = array('expected_delivery_date' => $exp_delivery_date , 'work_order_date' => $order_date, 'issued_by' => $issued_by, 'issued_to' => $issued_to, 'standard_note' => $standard_note, 'urgency' => $urgency , 'work_order_description' => $order_descrption, 'po_no' => $po_no, 'po_date' => $po_date);

        $where = '(entity_id ="'.$entity_id.'")';
        $this->db->where($where);
        $this->db->update('work_order_master',$work_order_array);

        foreach ($product_checkbox as $key => $value) {
            $product_id = $value;

            $this->db->select('*');
            $this->db->from('work_order_product_relation');
            $where_or = '(product_id = "'.$product_id.'" AND work_order_id = "'.$entity_id.'")';
            $this->db->where($where_or);
            $order_product_exit= $this->db->get();
            $order_product_exit_data_count =  $order_product_exit->num_rows();

            if ($order_product_exit_data_count === 0) 
            {
                $work_order_product_array = array('work_order_id' => $entity_id , 'product_id' => $product_id , 'status' => $status);
                $this->db->insert('work_order_product_relation', $work_order_product_array);
            }
        }
    }

    public function save_work_order()
    {
        $entity_id = $this->input->post('order_entity_id');
        $exp_delivery_date = $this->input->post('exp_delivery_date');
        $order_date = $this->input->post('order_date');
        $issued_by = $this->input->post('issued_by');
        $issued_to = $this->input->post('issued_to');
        $standard_note = $this->input->post('standard_note');
        $urgency = $this->input->post('urgency');
        $order_descrption = $this->input->post('order_descrption');
        $workorder_type = $this->input->post('workorder_type');
        $po_no = $this->input->post('po_no');
        $po_date = $this->input->post('po_date');
        $work_order_status = 2;

        $this->db->select_sum('work_order_qty');
        $this->db->from('work_order_product_relation');
        $where = '(work_order_product_relation.work_order_id = "'.$entity_id.'")';
        $this->db->where($where);
        $work_order_product_relation_data = $this->db->get();
        $work_order_product_relation_data_work_order_qty = $work_order_product_relation_data->row();
        $total_work_order_qty = $work_order_product_relation_data_work_order_qty->work_order_qty;

        $this->db->select_sum('ready_qty');
        $this->db->from('work_order_product_relation');
        $where = '(work_order_product_relation.work_order_id = "'.$entity_id.'")';
        $this->db->where($where);
        $work_order_product_relation_ready_qty = $this->db->get();
        $work_order_product_relation_data_ready_qty = $work_order_product_relation_ready_qty->row();
        $total_ready_qty = $work_order_product_relation_data_ready_qty->ready_qty;

        $this->db->select_sum('dispatch_qty');
        $this->db->from('work_order_product_relation');
        $where = '(work_order_product_relation.work_order_id = "'.$entity_id.'")';
        $this->db->where($where);
        $work_order_product_relation_dispatch_qty = $this->db->get();
        $work_order_product_relation_data_dispatch_qty = $work_order_product_relation_dispatch_qty->row();
        $total_dispatch_qty = $work_order_product_relation_data_dispatch_qty->dispatch_qty;
        
        if($total_work_order_qty === $total_ready_qty && $total_work_order_qty === $total_dispatch_qty){
            $work_order_array = array('expected_delivery_date' => $exp_delivery_date , 'work_order_date' => $order_date, 'issued_by' => $issued_by, 'issued_to' => $issued_to, 'standard_note' => $standard_note, 'urgency' => $urgency , 'work_order_description' => $order_descrption, 'work_order_status' => $work_order_status, 'workorder_type' => $workorder_type, 'po_no' => $po_no, 'po_date' => $po_date);

        $where = '(entity_id ="'.$entity_id.'")';
        $this->db->where($where);
        $this->db->update('work_order_master',$work_order_array);

        redirect('vw_work_order_data');

        }else{
            $work_order_array = array('expected_delivery_date' => $exp_delivery_date , 'work_order_date' => $order_date, 'issued_by' => $issued_by, 'issued_to' => $issued_to, 'standard_note' => $standard_note, 'urgency' => $urgency , 'work_order_description' => $order_descrption, 'workorder_type' => $workorder_type, 'po_no' => $po_no, 'po_date' => $po_date);

        $where = '(entity_id ="'.$entity_id.'")';
        $this->db->where($where);
        $this->db->update('work_order_master',$work_order_array);

        redirect('vw_work_order_data');
        }
        
    }

    public function update_second_category_order()
    {
        $entity_id = $this->uri->segment(2);
        $data['entity_id'] = $entity_id;
        $data['product_list'] = $this->work_order_register_model->get_product_list();
        $data['order_product_list'] = $this->work_order_register_model->get_order_product_list($entity_id);
        $this->load->view('factory/work_order_register/vw_second_category_work_order_update',$data);
    }

    public function update_product_ready_qty()
    {
        $entity_id = $this->input->post('order_relation_entity_id');
        $product_ready_qty = $this->input->post('product_ready_qty');

        $this->db->select('*');
        $this->db->from('work_order_product_relation');
        $where = '(work_order_product_relation.entity_id = "'.$entity_id.'")';
        $this->db->where($where);
        $work_order_product_relation_data = $this->db->get();
        $work_order_product_relation_result = $work_order_product_relation_data->row_array();

        $work_order_qty = $work_order_product_relation_result['work_order_qty'];

        if($product_ready_qty <= $work_order_qty)
        {
            $update_array = array('entity_id' => $entity_id,'ready_qty' => $product_ready_qty);
            $data = $this->work_order_register_model->update_order_product_relation($update_array);
            echo json_encode($data);
        }else
        {
            ajaxError();
        }
    }

    public function update_product_dispatch_qty()
    {
        $entity_id = $this->input->post('order_relation_entity_id');
        $product_dis_qty = $this->input->post('product_dis_qty');

        $this->db->select('*');
        $this->db->from('work_order_product_relation');
        $where = '(work_order_product_relation.entity_id = "'.$entity_id.'")';
        $this->db->where($where);
        $work_order_product_relation_data = $this->db->get();
        $work_order_product_relation_result = $work_order_product_relation_data->row_array();

        $work_order_qty = $work_order_product_relation_result['work_order_qty'];

        if($product_dis_qty <= $work_order_qty)
        {
            $update_array = array('entity_id' => $entity_id,'dispatch_qty' => $product_dis_qty);
            $data = $this->work_order_register_model->update_order_product_relation($update_array);
            echo json_encode($data);
        }else
        {
            ajaxError();
        }
    }

    public function update_product_sales_comment()
    {
        $entity_id = $this->input->post('order_relation_entity_id');
        $sales_comment = $this->input->post('sales_comment');

        $update_array = array('entity_id' => $entity_id,'sales_comment' => $sales_comment);
        $data = $this->work_order_register_model->update_order_product_relation($update_array);

        echo json_encode($data);
    }

    public function update_product_factory_comment()
    {
        $entity_id = $this->input->post('order_relation_entity_id');
        $factory_comment = $this->input->post('factory_comment');

        $update_array = array('entity_id' => $entity_id,'factory_comment' => $factory_comment);
        $data = $this->work_order_register_model->update_order_product_relation($update_array);

        echo json_encode($data);
    }

    public function update_product_expected_dev_date()
    {
        $entity_id = $this->input->post('order_relation_entity_id');
        $exp_date = $this->input->post('exp_date');

        $update_array = array('entity_id' => $entity_id,'expected_delivery_date' => $exp_date);
        $data = $this->work_order_register_model->update_order_product_relation($update_array);

        echo json_encode($data);
    }

    public function confirm_order()
    {
        $entity_id = $this->input->post('entity_id');
        $exp_delivery_date = $this->input->post('exp_delivery_date');
        $order_date = $this->input->post('order_date');
        $issued_by = $this->input->post('issued_by');
        $issued_to = $this->input->post('issued_to');
        $standard_note = $this->input->post('standard_note');
        $urgency = $this->input->post('urgency');
        $order_descrption = $this->input->post('order_descrption');
        $work_order_status = 2;

        $work_order_array = array('expected_delivery_date' => $exp_delivery_date , 'work_order_date' => $order_date, 'issued_by' => $issued_by, 'issued_to' => $issued_to, 'standard_note' => $standard_note, 'urgency' => $urgency , 'work_order_description' => $order_descrption, 'work_order_status' => $work_order_status);

        $where = '(entity_id ="'.$entity_id.'")';
        $this->db->where($where);
        $this->db->update('work_order_master',$work_order_array);
    }

    public function view_second_category_order()
    {
        $entity_id = $this->uri->segment(2);
        $data['entity_id'] = $entity_id;
        $data['product_list'] = $this->work_order_register_model->get_product_list();
        $data['order_product_list'] = $this->work_order_register_model->get_order_product_list($entity_id);
        $this->load->view('factory/work_order_register/vw_second_category_work_order_view',$data);
    }

    public function update_first_category_order()
    {
        $entity_id = $this->uri->segment(2);
        $data['entity_id'] = $entity_id;
        $data['product_list'] = $this->work_order_register_model->get_product_list();
        $data['order_product_list'] = $this->work_order_register_model->get_order_product_list($entity_id);
        $this->load->view('factory/work_order_register/vw_first_category_work_order_update',$data);
    }

    public function get_first_category_order_details_by_id()
    {
        $entity_id = $this->input->post('entity_id',TRUE);
        $data = $this->work_order_register_model->get_first_category_order_details_by_id_model($entity_id)->result();
        echo json_encode($data);
    }

    public function view_first_category_order()
    {
        $entity_id = $this->uri->segment(2);
        $data['entity_id'] = $entity_id;
        $data['product_list'] = $this->work_order_register_model->get_product_list();
        $data['order_product_list'] = $this->work_order_register_model->get_order_product_list($entity_id);
        $this->load->view('factory/work_order_register/vw_first_category_work_order_view',$data);
    }
    
    public function download_normal_workorder()
    {
        ob_start();
        $entity_id = $this->uri->segment(2);

        $this->db->select('work_order_master.work_order_no AS Work_order_no,
                           work_order_master.work_order_type AS Work_order_type,
                           work_order_master.work_order_category AS Work_order_category,
                           work_order_master.work_order_date AS Work_order_date,
                           work_order_master.sales_order_id AS Sales_order_id,
                           work_order_master.expected_delivery_date AS Expected_delivery_date,
                           work_order_master.work_order_description AS Work_order_description,
                           work_order_master.issued_by AS Issued_by,
                           work_order_master.issued_to AS Issued_to,
                           work_order_master.standard_note AS Standard_note,
                           work_order_master.urgency AS Urgency');
        $this->db->from('work_order_master');
        
        $where = '(work_order_master.entity_id = "'.$entity_id.'")';
        $this->db->where($where);
        $query_workorder_data = $this->db->get();
        $query_workorder_data = $query_workorder_data->row_array();
        // print_r($query_workorder_data);
        // die();

        $Work_order_no = $query_workorder_data['Work_order_no'];
        $Work_order_type = $query_workorder_data['Work_order_type'];
        $Work_order_category = $query_workorder_data['Work_order_category'];
        $Work_order_date = $query_workorder_data['Work_order_date'];
        $Work_order_datess = date("d-m-Y",strtotime($Work_order_date));
        //$Sales_order_id = $query_workorder_data['Sales_order_id'];
        $Expected_delivery_date = $query_workorder_data['Expected_delivery_date'];
        $Issued_by = $query_workorder_data['Issued_by'];
        $Issued_to = $query_workorder_data['Issued_to'];
        $Standard_note = $query_workorder_data['Standard_note'];
        $Urgency = $query_workorder_data['Urgency'];


        $Work_order_description = $query_workorder_data['Work_order_description'];
        //$Sales_order_no = $query_workorder_data['Sales_order_no'];

        if ($Work_order_type == 1) {
               $Work_order_type = "Workorder";
            }elseif ($Work_order_type == 2) {
               $Work_order_type = "Tradeorder";
            }

        if ($Work_order_category == 1) {
               $Work_order_category = "Workorder";
            }elseif ($Work_order_category == 2) {
               $Work_order_category = "Tradeorder";
            }    


        $this->db->select('work_order_product_relation.entity_id AS Entity_id,
                           work_order_product_relation.work_order_id AS Work_order_id,
                           work_order_product_relation.product_id AS Product_id,
                           work_order_product_relation.work_order_qty AS Work_order_qty,
                           work_order_product_relation.dispatch_qty AS Dispatch_qty,
                           work_order_product_relation.sales_comment AS Sales_comment,
                           work_order_product_relation.factory_comment AS Factory_comment,
                           work_order_product_relation.expected_delivery_date AS Expected_delivery_date_product,

                           work_order_product_relation.product_custom_description AS Product_long_description,
                           product_master.product_id as Product_id,
                           product_master.product_name AS Product_name,
                           product_master.unit AS unit');
        $this->db->from('work_order_product_relation');
        $this->db->join('product_master', 'work_order_product_relation.product_id = product_master.entity_id', 'INNER');

        $where = '(work_order_product_relation.work_order_id = "'.$entity_id.'")';
        $this->db->where($where);
        $workorder_product_data= $this->db->get();
        $data__product = $workorder_product_data->result_array(); 
        $data_workorder_product_count = $workorder_product_data->num_rows();
        
        //print_r($data_offer_product_count);
        //die();
        //$location_id = $_SESSION['location_id'];
       
        $pdf = new Workorder_pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, 'LETTER', true, 'UTF-8', false);
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);

        // set font
        $pdf->SetFont('dejavusans', '', 10);
        $path_img = getcwd();

        // add a page
        $pdf->AddPage();

        if($data_workorder_product_count ===1)
        {

        $html = '<h2 style="text-align: center;">Workorder</h2>
        <table border="0.3" cellpadding="3" width="100%">
                            <tr style="background-color: #C0C0C0;">
                              <td style="font-size: 7.5px; width: 20%; text-indent:2em; line-height: 0.5;"><br><br><b>WO No :</b> '.strip_tags($Work_order_no).'<br></td>

                              <td style="font-size: 7.5px; width: 28%; text-indent:2em; line-height: 0.5;"><br><br><b>SO.No : </b>NA</td>

                              <td style="font-size: 7.5px; width: 18%; text-indent:2em; line-height: 0.5;"><br><br><b>WO Date : </b>'.strip_tags($Work_order_datess).'</td>

                              <td style="font-size: 7.5px; width: 34%; text-indent:2em; line-height: 0.5;"><br><br><b>Department : </b> Production / Sales / Store</td>
                            </tr>


                             <tr>
                              

                              

                              <td style="font-size: 7.5px; width: 76%; text-indent:2em;"><b>Product / Product Code /Specification/ </b></td>

                              <td style="font-size: 7.5px; width: 12%; text-indent:2em;"><b>Qty <br>&nbsp;&nbsp;UOM</b></td>

                              <td style="font-size: 7.5px; width: 12%; text-indent:2em;"><b>Del. <br>&nbsp;&nbsp;Date</b></td>

                              
                              
                             </tr>

                             
                        </table>';


        
         // reset pointer to the last page
        

                foreach ($data__product as $value_data) 
                {
                    $Entity_id = $value_data['Entity_id'];
                    $Work_order_id = $value_data['Work_order_id'];
                    $Product_id = $value_data['Product_id'];
                    $Work_order_qty = $value_data['Work_order_qty']; 
                    $Dispatch_qty = $value_data['Dispatch_qty']; 
                    $Sales_comment = $value_data['Sales_comment'];   
                    $Factory_comment = $value_data['Factory_comment'];   
                    $Expected_delivery_date = $value_data['Expected_delivery_date_product'];
                    $Expected_delivery_date_product = date("d-m-Y",strtotime($Expected_delivery_date));  
                    $Product_id = $value_data['Product_id']; 

                    $Product_name = $value_data['Product_name']; 
                    $unit = $value_data['unit']; 
                    $Product_long_description = $value_data['Product_long_description'];  
                    $Product_long_description_format = substr($Product_long_description,0,220); 
                       
                      $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            <tr>
                                
                                <td style="font-size: 9px; width:76%; text-indent:1em;">'.strip_tags($Product_name).' : '.strip_tags($Product_id).'<br>&nbsp;'.strip_tags($Product_long_description).'</td>
                                <td style="font-size: 7.5px; width: 12%; text-indent:1em;">'.strip_tags($Work_order_qty).'<br>&nbsp;&nbsp;'.strip_tags($unit).'</td>

                                <td style="font-size: 7.5px; width: 12%; text-indent:1em;">'.strip_tags($Expected_delivery_date_product).'</td>
                            </tr>
                            
                        </table>';
                        
                }
                $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            

                            <tr>
                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>WO Issued By :</b> '.strip_tags($Issued_by).'</td>


                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>Issued To : </b>'.strip_tags($Issued_to).'</td>

                              
                             </tr>

                            
                            
                            
                        </table>';


                $html .=  '<br><table>
                            
                            

                            <tr>
                              <td style="font-size: 8.5px; width: 100%; text-indent:2em;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'.strip_tags($Standard_note).'</b><br><br></td>
                              
                             </tr>

                            
                            
                            
                        </table>';        

        $pdf->writeHTML($html, true, false, true, false, '');


        
        }








        if($data_workorder_product_count ===2)
        {

        $html = '<h2 style="text-align: center;">Workorder</h2>
        <table border="0.3" cellpadding="3" width="100%">
                            <tr style="background-color: #C0C0C0;">
                              <td style="font-size: 7.5px; width: 20%; text-indent:2em; line-height: 0.5;"><br><br><b>WO No :</b> '.strip_tags($Work_order_no).'<br></td>

                              <td style="font-size: 7.5px; width: 28%; text-indent:2em; line-height: 0.5;"><br><br><b>SO.No : </b>NA</td>

                              <td style="font-size: 7.5px; width: 18%; text-indent:2em; line-height: 0.5;"><br><br><b>WO Date : </b>'.strip_tags($Work_order_datess).'</td>

                              <td style="font-size: 7.5px; width: 34%; text-indent:2em; line-height: 0.5;"><br><br><b>Department : </b> Production / Sales / Store</td>
                            </tr>


                             <tr>
                              

                              

                              <td style="font-size: 7.5px; width: 76%; text-indent:2em;"><b>Product / Product Code /Specification/ </b></td>

                              <td style="font-size: 7.5px; width: 12%; text-indent:2em;"><b>Qty <br>&nbsp;&nbsp;UOM</b></td>

                              <td style="font-size: 7.5px; width: 12%; text-indent:2em;"><b>Del. <br>&nbsp;&nbsp;Date</b></td>

                              
                              
                             </tr>

                             
                        </table>';


        
         // reset pointer to the last page
        

                foreach ($data__product as $value_data) 
                {
                    $Entity_id = $value_data['Entity_id'];
                    $Work_order_id = $value_data['Work_order_id'];
                    $Product_id = $value_data['Product_id'];
                    $Work_order_qty = $value_data['Work_order_qty']; 
                    $Dispatch_qty = $value_data['Dispatch_qty']; 
                    $Sales_comment = $value_data['Sales_comment'];   
                    $Factory_comment = $value_data['Factory_comment'];   
                    $Expected_delivery_date = $value_data['Expected_delivery_date_product'];
                    $Expected_delivery_date_product = date("d-m-Y",strtotime($Expected_delivery_date));  
                    $Product_id = $value_data['Product_id']; 

                    $Product_name = $value_data['Product_name']; 
                    $unit = $value_data['unit']; 
                    $Product_long_description = $value_data['Product_long_description'];  
                    $Product_long_description_format = substr($Product_long_description,0,220); 
                       
                      $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            <tr>
                                
                                <td style="font-size: 9px; width:76%; text-indent:1em;">'.strip_tags($Product_name).' : '.strip_tags($Product_id).'<br>&nbsp;'.strip_tags($Product_long_description).'</td>
                                <td style="font-size: 7.5px; width: 12%; text-indent:1em;">'.strip_tags($Work_order_qty).'<br>&nbsp;&nbsp;'.strip_tags($unit).'</td>

                                <td style="font-size: 7.5px; width: 12%; text-indent:1em;">'.strip_tags($Expected_delivery_date_product).'</td>
                            </tr>
                            
                        </table>';
                        
                }
                $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            

                            <tr>
                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>WO Issued By :</b> '.strip_tags($Issued_by).'</td>


                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>Issued To : </b>'.strip_tags($Issued_to).'</td>

                              
                             </tr>

                            
                            
                            
                        </table>';


                $html .=  '<br><table>
                            
                            

                            <tr>
                              <td style="font-size: 8.5px; width: 100%; text-indent:2em;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'.strip_tags($Standard_note).'</b><br><br></td>
                              
                             </tr>

                            
                            
                            
                        </table>';        

        $pdf->writeHTML($html, true, false, true, false, '');


        
        }





        if($data_workorder_product_count ===3)
        {

        $html = '<h2 style="text-align: center;">Workorder</h2>
        <table border="0.3" cellpadding="3" width="100%">
                            <tr style="background-color: #C0C0C0;">
                              <td style="font-size: 7.5px; width: 20%; text-indent:2em; line-height: 0.5;"><br><br><b>WO No :</b> '.strip_tags($Work_order_no).'<br></td>

                              <td style="font-size: 7.5px; width: 28%; text-indent:2em; line-height: 0.5;"><br><br><b>SO.No : </b>NA</td>

                              <td style="font-size: 7.5px; width: 18%; text-indent:2em; line-height: 0.5;"><br><br><b>WO Date : </b>'.strip_tags($Work_order_datess).'</td>

                              <td style="font-size: 7.5px; width: 34%; text-indent:2em; line-height: 0.5;"><br><br><b>Department : </b> Production / Sales / Store</td>
                            </tr>


                             <tr>
                              

                              

                              <td style="font-size: 7.5px; width: 76%; text-indent:2em;"><b>Product / Product Code /Specification/ </b></td>

                              <td style="font-size: 7.5px; width: 12%; text-indent:2em;"><b>Qty <br>&nbsp;&nbsp;UOM</b></td>

                              <td style="font-size: 7.5px; width: 12%; text-indent:2em;"><b>Del. <br>&nbsp;&nbsp;Date</b></td>

                              
                              
                             </tr>

                             
                        </table>';


        
         // reset pointer to the last page
        

                foreach ($data__product as $value_data) 
                {
                    $Entity_id = $value_data['Entity_id'];
                    $Work_order_id = $value_data['Work_order_id'];
                    $Product_id = $value_data['Product_id'];
                    $Work_order_qty = $value_data['Work_order_qty']; 
                    $Dispatch_qty = $value_data['Dispatch_qty']; 
                    $Sales_comment = $value_data['Sales_comment'];   
                    $Factory_comment = $value_data['Factory_comment'];   
                    $Expected_delivery_date = $value_data['Expected_delivery_date_product'];
                    $Expected_delivery_date_product = date("d-m-Y",strtotime($Expected_delivery_date));  
                    $Product_id = $value_data['Product_id']; 

                    $Product_name = $value_data['Product_name']; 
                    $unit = $value_data['unit']; 
                    $Product_long_description = $value_data['Product_long_description'];  
                    $Product_long_description_format = substr($Product_long_description,0,220); 
                       
                      $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            <tr>
                                
                                <td style="font-size: 9px; width:76%; text-indent:1em;">'.strip_tags($Product_name).' : '.strip_tags($Product_id).'<br>&nbsp;'.strip_tags($Product_long_description).'</td>
                                <td style="font-size: 7.5px; width: 12%; text-indent:1em;">'.strip_tags($Work_order_qty).'<br>&nbsp;&nbsp;'.strip_tags($unit).'</td>

                                <td style="font-size: 7.5px; width: 12%; text-indent:1em;">'.strip_tags($Expected_delivery_date_product).'</td>
                            </tr>
                            
                        </table>';
                        
                }
                $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            

                            <tr>
                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>WO Issued By :</b> '.strip_tags($Issued_by).'</td>


                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>Issued To : </b>'.strip_tags($Issued_to).'</td>

                              
                             </tr>

                            
                            
                            
                        </table>';


                $html .=  '<br><table>
                            
                            

                            <tr>
                              <td style="font-size: 8.5px; width: 100%; text-indent:2em;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'.strip_tags($Standard_note).'</b><br><br></td>
                              
                             </tr>

                            
                            
                            
                        </table>';        

        $pdf->writeHTML($html, true, false, true, false, '');


        
        }


        if($data_workorder_product_count ===4)
        {

        $html = '<h2 style="text-align: center;">Workorder</h2>
        <table border="0.3" cellpadding="3" width="100%">
                            <tr style="background-color: #C0C0C0;">
                              <td style="font-size: 7.5px; width: 20%; text-indent:2em; line-height: 0.5;"><br><br><b>WO No :</b> '.strip_tags($Work_order_no).'<br></td>

                              <td style="font-size: 7.5px; width: 28%; text-indent:2em; line-height: 0.5;"><br><br><b>SO.No : </b>NA</td>

                              <td style="font-size: 7.5px; width: 18%; text-indent:2em; line-height: 0.5;"><br><br><b>WO Date : </b>'.strip_tags($Work_order_datess).'</td>

                              <td style="font-size: 7.5px; width: 34%; text-indent:2em; line-height: 0.5;"><br><br><b>Department : </b> Production / Sales / Store</td>
                            </tr>


                             <tr>
                              

                              

                              <td style="font-size: 7.5px; width: 76%; text-indent:2em;"><b>Product / Product Code /Specification/ </b></td>

                              <td style="font-size: 7.5px; width: 12%; text-indent:2em;"><b>Qty <br>&nbsp;&nbsp;UOM</b></td>

                              <td style="font-size: 7.5px; width: 12%; text-indent:2em;"><b>Del. <br>&nbsp;&nbsp;Date</b></td>

                              
                              
                             </tr>

                             
                        </table>';


        
         // reset pointer to the last page
        

                foreach ($data__product as $value_data) 
                {
                    $Entity_id = $value_data['Entity_id'];
                    $Work_order_id = $value_data['Work_order_id'];
                    $Product_id = $value_data['Product_id'];
                    $Work_order_qty = $value_data['Work_order_qty']; 
                    $Dispatch_qty = $value_data['Dispatch_qty']; 
                    $Sales_comment = $value_data['Sales_comment'];   
                    $Factory_comment = $value_data['Factory_comment'];   
                    $Expected_delivery_date = $value_data['Expected_delivery_date_product'];
                    $Expected_delivery_date_product = date("d-m-Y",strtotime($Expected_delivery_date));  
                    $Product_id = $value_data['Product_id']; 

                    $Product_name = $value_data['Product_name']; 
                    $unit = $value_data['unit']; 
                    $Product_long_description = $value_data['Product_long_description'];  
                    $Product_long_description_format = substr($Product_long_description,0,220); 
                       
                      $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            <tr>
                                
                                <td style="font-size: 9px; width:76%; text-indent:1em;">'.strip_tags($Product_name).' : '.strip_tags($Product_id).'<br>&nbsp;'.strip_tags($Product_long_description).'</td>
                                <td style="font-size: 7.5px; width: 12%; text-indent:1em;">'.strip_tags($Work_order_qty).'<br>&nbsp;&nbsp;'.strip_tags($unit).'</td>

                                <td style="font-size: 7.5px; width: 12%; text-indent:1em;">'.strip_tags($Expected_delivery_date_product).'</td>
                            </tr>
                            
                        </table>';
                        
                }
                $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            

                            <tr>
                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>WO Issued By :</b> '.strip_tags($Issued_by).'</td>


                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>Issued To : </b>'.strip_tags($Issued_to).'</td>

                              
                             </tr>

                            
                            
                            
                        </table>';


                $html .=  '<br><table>
                            
                            

                            <tr>
                              <td style="font-size: 8.5px; width: 100%; text-indent:2em;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'.strip_tags($Standard_note).'</b><br><br></td>
                              
                             </tr>

                            
                            
                            
                        </table>';        

        $pdf->writeHTML($html, true, false, true, false, '');

        }



        if($data_workorder_product_count ===5)
        {

        $html = '<h2 style="text-align: center;">Workorder</h2>
        <table border="0.3" cellpadding="3" width="100%">
                            <tr style="background-color: #C0C0C0;">
                              <td style="font-size: 7.5px; width: 20%; text-indent:2em; line-height: 0.5;"><br><br><b>WO No :</b> '.strip_tags($Work_order_no).'<br></td>

                              <td style="font-size: 7.5px; width: 28%; text-indent:2em; line-height: 0.5;"><br><br><b>SO.No : </b>NA</td>

                              <td style="font-size: 7.5px; width: 18%; text-indent:2em; line-height: 0.5;"><br><br><b>WO Date : </b>'.strip_tags($Work_order_datess).'</td>

                              <td style="font-size: 7.5px; width: 34%; text-indent:2em; line-height: 0.5;"><br><br><b>Department : </b> Production / Sales / Store</td>
                            </tr>


                             <tr>
                              

                              

                              <td style="font-size: 7.5px; width: 76%; text-indent:2em;"><b>Product / Product Code /Specification/ </b></td>

                              <td style="font-size: 7.5px; width: 12%; text-indent:2em;"><b>Qty <br>&nbsp;&nbsp;UOM</b></td>

                              <td style="font-size: 7.5px; width: 12%; text-indent:2em;"><b>Del. <br>&nbsp;&nbsp;Date</b></td>

                              
                              
                             </tr>

                             
                        </table>';


        
         // reset pointer to the last page
        

                foreach ($data__product as $value_data) 
                {
                    $Entity_id = $value_data['Entity_id'];
                    $Work_order_id = $value_data['Work_order_id'];
                    $Product_id = $value_data['Product_id'];
                    $Work_order_qty = $value_data['Work_order_qty']; 
                    $Dispatch_qty = $value_data['Dispatch_qty']; 
                    $Sales_comment = $value_data['Sales_comment'];   
                    $Factory_comment = $value_data['Factory_comment'];   
                    $Expected_delivery_date = $value_data['Expected_delivery_date_product'];
                    $Expected_delivery_date_product = date("d-m-Y",strtotime($Expected_delivery_date));  
                    $Product_id = $value_data['Product_id']; 

                    $Product_name = $value_data['Product_name'];
                    $unit = $value_data['unit'];  
                    $Product_long_description = $value_data['Product_long_description'];  
                    $Product_long_description_format = substr($Product_long_description,0,220); 
                       
                      $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            <tr>
                                
                                <td style="font-size: 9px; width:76%; text-indent:1em;">'.strip_tags($Product_name).' : '.strip_tags($Product_id).'<br>&nbsp;'.strip_tags($Product_long_description).'</td>
                                <td style="font-size: 7.5px; width: 12%; text-indent:1em;">'.strip_tags($Work_order_qty).'<br>&nbsp;&nbsp;'.strip_tags($unit).'</td>

                                <td style="font-size: 7.5px; width: 12%; text-indent:1em;">'.strip_tags($Expected_delivery_date_product).'</td>
                            </tr>
                            
                        </table>';
                        
                }
                $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            

                            <tr>
                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>WO Issued By :</b> '.strip_tags($Issued_by).'</td>


                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>Issued To : </b>'.strip_tags($Issued_to).'</td>

                              
                             </tr>

                            
                            
                            
                        </table>';


                $html .=  '<br><table>
                            
                            

                            <tr>
                              <td style="font-size: 8.5px; width: 100%; text-indent:2em;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'.strip_tags($Standard_note).'</b><br><br></td>
                              
                             </tr>

                            
                            
                            
                        </table>';        

        $pdf->writeHTML($html, true, false, true, false, '');


        
        }


        if($data_workorder_product_count ===6)
        {

        $html = '<h2 style="text-align: center;">Workorder</h2>
        <table border="0.3" cellpadding="3" width="100%">
                            <tr style="background-color: #C0C0C0;">
                              <td style="font-size: 7.5px; width: 20%; text-indent:2em; line-height: 0.5;"><br><br><b>WO No :</b> '.strip_tags($Work_order_no).'<br></td>

                              <td style="font-size: 7.5px; width: 28%; text-indent:2em; line-height: 0.5;"><br><br><b>SO.No : </b>NA</td>

                              <td style="font-size: 7.5px; width: 18%; text-indent:2em; line-height: 0.5;"><br><br><b>WO Date : </b>'.strip_tags($Work_order_datess).'</td>

                              <td style="font-size: 7.5px; width: 34%; text-indent:2em; line-height: 0.5;"><br><br><b>Department : </b> Production / Sales / Store</td>
                            </tr>


                             <tr>
                              

                              

                              <td style="font-size: 7.5px; width: 76%; text-indent:2em;"><b>Product / Product Code /Specification/ </b></td>

                              <td style="font-size: 7.5px; width: 12%; text-indent:2em;"><b>Qty <br>&nbsp;&nbsp;UOM</b></td>

                              <td style="font-size: 7.5px; width: 12%; text-indent:2em;"><b>Del. <br>&nbsp;&nbsp;Date</b></td>

                              
                              
                             </tr>

                             
                        </table>';


        
         // reset pointer to the last page
        

                foreach ($data__product as $value_data) 
                {
                    $Entity_id = $value_data['Entity_id'];
                    $Work_order_id = $value_data['Work_order_id'];
                    $Product_id = $value_data['Product_id'];
                    $Work_order_qty = $value_data['Work_order_qty']; 
                    $Dispatch_qty = $value_data['Dispatch_qty']; 
                    $Sales_comment = $value_data['Sales_comment'];   
                    $Factory_comment = $value_data['Factory_comment'];   
                    $Expected_delivery_date = $value_data['Expected_delivery_date_product'];
                    $Expected_delivery_date_product = date("d-m-Y",strtotime($Expected_delivery_date));  
                    $Product_id = $value_data['Product_id']; 

                    $Product_name = $value_data['Product_name']; 
                    $unit = $value_data['unit']; 
                    $Product_long_description = $value_data['Product_long_description'];  
                    $Product_long_description_format = substr($Product_long_description,0,220); 
                       
                      $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            <tr>
                                
                                <td style="font-size: 9px; width:76%; text-indent:1em;">'.strip_tags($Product_name).' : '.strip_tags($Product_id).'<br>&nbsp;'.strip_tags($Product_long_description).'</td>
                                <td style="font-size: 7.5px; width: 12%; text-indent:1em;">'.strip_tags($Work_order_qty).'<br>&nbsp;&nbsp;'.strip_tags($unit).'</td>

                                <td style="font-size: 7.5px; width: 12%; text-indent:1em;">'.strip_tags($Expected_delivery_date_product).'</td>
                            </tr>
                            
                        </table>';
                        
                }
                $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            

                            <tr>
                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>WO Issued By :</b> '.strip_tags($Issued_by).'</td>


                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>Issued To : </b>'.strip_tags($Issued_to).'</td>

                              
                             </tr>

                            
                            
                            
                        </table>';


                $html .=  '<br><table>
                            
                            

                            <tr>
                              <td style="font-size: 8.5px; width: 100%; text-indent:2em;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'.strip_tags($Standard_note).'</b><br><br></td>
                              
                             </tr>

                            
                            
                            
                        </table>';        

        $pdf->writeHTML($html, true, false, true, false, '');


        
        }

        if($data_workorder_product_count >=7)
        {

        $html = '<h2 style="text-align: center;">Workorder</h2>
        <table border="0.3" cellpadding="3" width="100%">
                            <tr style="background-color: #C0C0C0;">
                              <td style="font-size: 7.5px; width: 20%; text-indent:2em; line-height: 0.5;"><br><br><b>WO No :</b> '.strip_tags($Work_order_no).'<br></td>

                              <td style="font-size: 7.5px; width: 28%; text-indent:2em; line-height: 0.5;"><br><br><b>SO.No : </b>NA</td>

                              <td style="font-size: 7.5px; width: 18%; text-indent:2em; line-height: 0.5;"><br><br><b>WO Date : </b>'.strip_tags($Work_order_datess).'</td>

                              <td style="font-size: 7.5px; width: 34%; text-indent:2em; line-height: 0.5;"><br><br><b>Department : </b> Production / Sales / Store</td>
                            </tr>


                             <tr>
                              

                              

                              <td style="font-size: 7.5px; width: 76%; text-indent:2em;"><b>Product / Product Code /Specification/ </b></td>

                              <td style="font-size: 7.5px; width: 12%; text-indent:2em;"><b>Qty <br>&nbsp;&nbsp;UOM</b></td>

                              <td style="font-size: 7.5px; width: 12%; text-indent:2em;"><b>Del. <br>&nbsp;&nbsp;Date</b></td>

                              
                              
                             </tr>

                             
                        </table>';


        
         // reset pointer to the last page
        

                foreach ($data__product as $value_data) 
                {
                    $Entity_id = $value_data['Entity_id'];
                    $Work_order_id = $value_data['Work_order_id'];
                    $Product_id = $value_data['Product_id'];
                    $Work_order_qty = $value_data['Work_order_qty']; 
                    $Dispatch_qty = $value_data['Dispatch_qty']; 
                    $Sales_comment = $value_data['Sales_comment'];   
                    $Factory_comment = $value_data['Factory_comment'];   
                    $Expected_delivery_date = $value_data['Expected_delivery_date_product'];
                    $Expected_delivery_date_product = date("d-m-Y",strtotime($Expected_delivery_date));  
                    $Product_id = $value_data['Product_id']; 

                    $Product_name = $value_data['Product_name']; 
                    $unit = $value_data['unit']; 
                    $Product_long_description = $value_data['Product_long_description'];  
                    $Product_long_description_format = substr($Product_long_description,0,220); 
                       
                      $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            <tr>
                                
                                <td style="font-size: 9px; width:76%; text-indent:1em;">'.strip_tags($Product_name).' : '.strip_tags($Product_id).'<br>&nbsp;'.strip_tags($Product_long_description).'</td>
                                <td style="font-size: 7.5px; width: 12%; text-indent:1em;">'.strip_tags($Work_order_qty).'<br>&nbsp;&nbsp;'.strip_tags($unit).'</td>

                                <td style="font-size: 7.5px; width: 12%; text-indent:1em;">'.strip_tags($Expected_delivery_date_product).'</td>
                            </tr>
                            
                        </table>';
                        
                }
                $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            

                            <tr>
                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>WO Issued By :</b> '.strip_tags($Issued_by).'</td>


                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>Issued To : </b>'.strip_tags($Issued_to).'</td>

                              
                             </tr>

                            
                            
                            
                        </table>';


                $html .=  '<br><table>
                            
                            

                            <tr>
                              <td style="font-size: 8.5px; width: 100%; text-indent:2em;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'.strip_tags($Standard_note).'</b><br><br></td>
                              
                             </tr>

                            
                            
                            
                        </table>';        

        $pdf->writeHTML($html, true, false, true, false, '');


        
        }
            $pdf->lastPage();

            //Close and output PDF document
            $pdf->Output('workorder'.date('Y-m-d-H:i:s').'.pdf', 'I');        
       
    }


    public function download_normal_tradeorder()
    {
        ob_start();
        $entity_id = $this->uri->segment(2);

        $this->db->select('work_order_master.work_order_no AS Work_order_no,
                           work_order_master.work_order_type AS Work_order_type,
                           work_order_master.work_order_category AS Work_order_category,
                           work_order_master.work_order_date AS Work_order_date,
                           work_order_master.sales_order_id AS Sales_order_id,
                           work_order_master.expected_delivery_date AS Expected_delivery_date,
                           work_order_master.work_order_description AS Work_order_description,
                           work_order_master.issued_by AS Issued_by,
                           work_order_master.issued_to AS Issued_to,
                           work_order_master.standard_note AS Standard_note,
                           work_order_master.urgency AS Urgency');
        $this->db->from('work_order_master');
        
        $where = '(work_order_master.entity_id = "'.$entity_id.'")';
        $this->db->where($where);
        $query_workorder_data = $this->db->get();
        $query_workorder_data = $query_workorder_data->row_array();
        // print_r($query_workorder_data);
        // die();

        $Work_order_no = $query_workorder_data['Work_order_no'];
        $Work_order_type = $query_workorder_data['Work_order_type'];
        $Work_order_category = $query_workorder_data['Work_order_category'];
        $Work_order_date = $query_workorder_data['Work_order_date'];
        $Work_order_datess = date("d-m-Y",strtotime($Work_order_date));
        //$Sales_order_id = $query_workorder_data['Sales_order_id'];
        $Expected_delivery_date = $query_workorder_data['Expected_delivery_date'];
        $Issued_by = $query_workorder_data['Issued_by'];
        $Issued_to = $query_workorder_data['Issued_to'];
        $Standard_note = $query_workorder_data['Standard_note'];
        $Urgency = $query_workorder_data['Urgency'];


        $Work_order_description = $query_workorder_data['Work_order_description'];
        //$Sales_order_no = $query_workorder_data['Sales_order_no'];

        if ($Work_order_type == 1) {
               $Work_order_type = "Workorder";
            }elseif ($Work_order_type == 2) {
               $Work_order_type = "Tradeorder";
            }

        if ($Work_order_category == 1) {
               $Work_order_category = "Workorder";
            }elseif ($Work_order_category == 2) {
               $Work_order_category = "Tradeorder";
            }    


        $this->db->select('work_order_product_relation.entity_id AS Entity_id,
                           work_order_product_relation.work_order_id AS Work_order_id,
                           work_order_product_relation.product_id AS Product_id,
                           work_order_product_relation.work_order_qty AS Work_order_qty,
                           work_order_product_relation.dispatch_qty AS Dispatch_qty,
                           work_order_product_relation.sales_comment AS Sales_comment,
                           work_order_product_relation.factory_comment AS Factory_comment,
                           work_order_product_relation.expected_delivery_date AS Expected_delivery_date_product,

                           work_order_product_relation.product_custom_description AS Product_long_description,
                           product_master.product_id as Product_id,
                           product_master.product_name AS Product_name,
                           product_master.unit AS unit');
        $this->db->from('work_order_product_relation');
        $this->db->join('product_master', 'work_order_product_relation.product_id = product_master.entity_id', 'INNER');

        $where = '(work_order_product_relation.work_order_id = "'.$entity_id.'")';
        $this->db->where($where);
        $workorder_product_data= $this->db->get();
        $data__product = $workorder_product_data->result_array(); 
        $data_workorder_product_count = $workorder_product_data->num_rows();
        
        //print_r($data_offer_product_count);
        //die();
        //$location_id = $_SESSION['location_id'];
       
        $pdf = new Workorder_pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, 'LETTER', true, 'UTF-8', false);
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);

        // set font
        $pdf->SetFont('dejavusans', '', 10);
        $path_img = getcwd();

        // add a page
        $pdf->AddPage();

        if($data_workorder_product_count ===1)
        {

        $html = '<h2 style="text-align: center;">Tradeorder</h2>
        <table border="0.3" cellpadding="3" width="100%">
                            <tr style="background-color: #C0C0C0;">
                              <td style="font-size: 7.5px; width: 20%; text-indent:2em; line-height: 0.5;"><br><br><b>WO No :</b> '.strip_tags($Work_order_no).'<br></td>

                              <td style="font-size: 7.5px; width: 28%; text-indent:2em; line-height: 0.5;"><br><br><b>SO.No : </b>NA</td>

                              <td style="font-size: 7.5px; width: 18%; text-indent:2em; line-height: 0.5;"><br><br><b>WO Date : </b>'.strip_tags($Work_order_datess).'</td>

                              <td style="font-size: 7.5px; width: 34%; text-indent:2em; line-height: 0.5;"><br><br><b>Department : </b> Production / Sales / Store</td>
                            </tr>


                             <tr>
                              

                              

                              <td style="font-size: 7.5px; width: 76%; text-indent:2em;"><b>Product / Product Code /Specification/ </b></td>

                              <td style="font-size: 7.5px; width: 12%; text-indent:2em;"><b>Qty <br>&nbsp;&nbsp;UOM</b></td>

                              <td style="font-size: 7.5px; width: 12%; text-indent:2em;"><b>Del. <br>&nbsp;&nbsp;Date</b></td>

                              
                              
                             </tr>

                             
                        </table>';


        
         // reset pointer to the last page
        

                foreach ($data__product as $value_data) 
                {
                    $Entity_id = $value_data['Entity_id'];
                    $Work_order_id = $value_data['Work_order_id'];
                    $Product_id = $value_data['Product_id'];
                    $Work_order_qty = $value_data['Work_order_qty']; 
                    $Dispatch_qty = $value_data['Dispatch_qty']; 
                    $Sales_comment = $value_data['Sales_comment'];   
                    $Factory_comment = $value_data['Factory_comment'];   
                    $Expected_delivery_date = $value_data['Expected_delivery_date_product'];
                    $Expected_delivery_date_product = date("d-m-Y",strtotime($Expected_delivery_date));  
                    $Product_id = $value_data['Product_id']; 

                    $Product_name = $value_data['Product_name'];
                    $unit = $value_data['unit'];  
                    $Product_long_description = $value_data['Product_long_description'];  
                    $Product_long_description_format = substr($Product_long_description,0,220); 
                       
                      $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            <tr>
                                
                                <td style="font-size: 9px; width:76%; text-indent:1em;">'.strip_tags($Product_name).' : '.strip_tags($Product_id).'<br>&nbsp;'.strip_tags($Product_long_description).'</td>
                                <td style="font-size: 7.5px; width: 12%; text-indent:1em;">'.strip_tags($Work_order_qty).'<br>&nbsp;&nbsp;'.strip_tags($unit).'</td>

                                <td style="font-size: 7.5px; width: 12%; text-indent:1em;">'.strip_tags($Expected_delivery_date_product).'</td>
                            </tr>
                            


                            
                        </table>';
                        
                }
                $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            

                            <tr>
                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>WO Issued By :</b> '.strip_tags($Issued_by).'</td>


                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>Issued To : </b>'.strip_tags($Issued_to).'</td>

                              
                             </tr>

                            
                            
                            
                        </table>';


                $html .=  '<br><table>
                            
                            

                            <tr>
                              <td style="font-size: 8.5px; width: 100%; text-indent:2em;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'.strip_tags($Standard_note).'</b><br><br></td>
                              
                             </tr>

                            
                            
                            
                        </table>';        

        $pdf->writeHTML($html, true, false, true, false, '');


        
        }








        if($data_workorder_product_count ===2)
        {

        $html = '<h2 style="text-align: center;">Tradeorder</h2>
        <table border="0.3" cellpadding="3" width="100%">
                            <tr style="background-color: #C0C0C0;">
                              <td style="font-size: 7.5px; width: 20%; text-indent:2em; line-height: 0.5;"><br><br><b>WO No :</b> '.strip_tags($Work_order_no).'<br></td>

                              <td style="font-size: 7.5px; width: 28%; text-indent:2em; line-height: 0.5;"><br><br><b>SO.No : </b>NA</td>

                              <td style="font-size: 7.5px; width: 18%; text-indent:2em; line-height: 0.5;"><br><br><b>WO Date : </b>'.strip_tags($Work_order_datess).'</td>

                              <td style="font-size: 7.5px; width: 34%; text-indent:2em; line-height: 0.5;"><br><br><b>Department : </b> Production / Sales / Store</td>
                            </tr>


                             <tr>
                              

                              

                              <td style="font-size: 7.5px; width: 76%; text-indent:2em;"><b>Product / Product Code /Specification/ </b></td>

                              <td style="font-size: 7.5px; width: 12%; text-indent:2em;"><b>Qty <br>&nbsp;&nbsp;UOM</b></td>

                              <td style="font-size: 7.5px; width: 12%; text-indent:2em;"><b>Del. <br>&nbsp;&nbsp;Date</b></td>

                              
                              
                             </tr>

                             
                        </table>';


        
         // reset pointer to the last page
        

                foreach ($data__product as $value_data) 
                {
                    $Entity_id = $value_data['Entity_id'];
                    $Work_order_id = $value_data['Work_order_id'];
                    $Product_id = $value_data['Product_id'];
                    $Work_order_qty = $value_data['Work_order_qty']; 
                    $Dispatch_qty = $value_data['Dispatch_qty']; 
                    $Sales_comment = $value_data['Sales_comment'];   
                    $Factory_comment = $value_data['Factory_comment'];   
                    $Expected_delivery_date = $value_data['Expected_delivery_date_product'];
                    $Expected_delivery_date_product = date("d-m-Y",strtotime($Expected_delivery_date));  
                    $Product_id = $value_data['Product_id']; 

                    $Product_name = $value_data['Product_name']; 
                    $unit = $value_data['unit'];  
                    $Product_long_description = $value_data['Product_long_description'];  
                    $Product_long_description_format = substr($Product_long_description,0,220); 
                       
                      $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            <tr>
                                
                                <td style="font-size: 9px; width:76%; text-indent:1em;">'.strip_tags($Product_name).' : '.strip_tags($Product_id).'<br>&nbsp;'.strip_tags($Product_long_description).'</td>
                                <td style="font-size: 7.5px; width: 12%; text-indent:1em;">'.strip_tags($Work_order_qty).'<br>&nbsp;&nbsp;'.strip_tags($unit).'</td>

                                <td style="font-size: 7.5px; width: 12%; text-indent:1em;">'.strip_tags($Expected_delivery_date_product).'</td>
                            </tr>
                            


                            
                        </table>';
                        
                }
                $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            

                            <tr>
                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>WO Issued By :</b> '.strip_tags($Issued_by).'</td>


                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>Issued To : </b>'.strip_tags($Issued_to).'</td>

                              
                             </tr>

                            
                            
                            
                        </table>';


                $html .=  '<br><table>
                            
                            

                            <tr>
                              <td style="font-size: 8.5px; width: 100%; text-indent:2em;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'.strip_tags($Standard_note).'</b><br><br></td>
                              
                             </tr>

                            
                            
                            
                        </table>';        

        $pdf->writeHTML($html, true, false, true, false, '');


        
        }





        if($data_workorder_product_count ===3)
        {

        $html = '<h2 style="text-align: center;">Tradeorder</h2>
        <table border="0.3" cellpadding="3" width="100%">
                            <tr style="background-color: #C0C0C0;">
                              <td style="font-size: 7.5px; width: 20%; text-indent:2em; line-height: 0.5;"><br><br><b>WO No :</b> '.strip_tags($Work_order_no).'<br></td>

                              <td style="font-size: 7.5px; width: 28%; text-indent:2em; line-height: 0.5;"><br><br><b>SO.No : </b>NA</td>

                              <td style="font-size: 7.5px; width: 18%; text-indent:2em; line-height: 0.5;"><br><br><b>WO Date : </b>'.strip_tags($Work_order_datess).'</td>

                              <td style="font-size: 7.5px; width: 34%; text-indent:2em; line-height: 0.5;"><br><br><b>Department : </b> Production / Sales / Store</td>
                            </tr>


                             <tr>
                              

                              

                              <td style="font-size: 7.5px; width: 76%; text-indent:2em;"><b>Product / Product Code /Specification/ </b></td>

                              <td style="font-size: 7.5px; width: 12%; text-indent:2em;"><b>Qty <br>&nbsp;&nbsp;UOM</b></td>

                              <td style="font-size: 7.5px; width: 12%; text-indent:2em;"><b>Del. <br>&nbsp;&nbsp;Date</b></td>

                              
                              
                             </tr>

                             
                        </table>';


        
         // reset pointer to the last page
        

                foreach ($data__product as $value_data) 
                {
                    $Entity_id = $value_data['Entity_id'];
                    $Work_order_id = $value_data['Work_order_id'];
                    $Product_id = $value_data['Product_id'];
                    $Work_order_qty = $value_data['Work_order_qty']; 
                    $Dispatch_qty = $value_data['Dispatch_qty']; 
                    $Sales_comment = $value_data['Sales_comment'];   
                    $Factory_comment = $value_data['Factory_comment'];   
                    $Expected_delivery_date = $value_data['Expected_delivery_date_product'];
                    $Expected_delivery_date_product = date("d-m-Y",strtotime($Expected_delivery_date));  
                    $Product_id = $value_data['Product_id']; 

                    $Product_name = $value_data['Product_name']; 
                    $unit = $value_data['unit'];  
                    $Product_long_description = $value_data['Product_long_description'];  
                    $Product_long_description_format = substr($Product_long_description,0,220); 
                       
                      $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            <tr>
                                
                                <td style="font-size: 9px; width:76%; text-indent:1em;">'.strip_tags($Product_name).' : '.strip_tags($Product_id).'<br>&nbsp;'.strip_tags($Product_long_description).'</td>
                                <td style="font-size: 7.5px; width: 12%; text-indent:1em;">'.strip_tags($Work_order_qty).'<br>&nbsp;&nbsp;'.strip_tags($unit).'</td>

                                <td style="font-size: 7.5px; width: 12%; text-indent:1em;">'.strip_tags($Expected_delivery_date_product).'</td>
                            </tr>
                            


                            
                        </table>';
                        
                }
                $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            

                            <tr>
                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>WO Issued By :</b> '.strip_tags($Issued_by).'</td>


                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>Issued To : </b>'.strip_tags($Issued_to).'</td>

                              
                             </tr>

                            
                            
                            
                        </table>';


                $html .=  '<br><table>
                            
                            

                            <tr>
                              <td style="font-size: 8.5px; width: 100%; text-indent:2em;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'.strip_tags($Standard_note).'</b><br><br></td>
                              
                             </tr>

                            
                            
                            
                        </table>';        

        $pdf->writeHTML($html, true, false, true, false, '');


        
        }


        if($data_workorder_product_count ===4)
        {

        $html = '<h2 style="text-align: center;">Tradeorder</h2>
        <table border="0.3" cellpadding="3" width="100%">
                            <tr style="background-color: #C0C0C0;">
                              <td style="font-size: 7.5px; width: 20%; text-indent:2em; line-height: 0.5;"><br><br><b>WO No :</b> '.strip_tags($Work_order_no).'<br></td>

                              <td style="font-size: 7.5px; width: 28%; text-indent:2em; line-height: 0.5;"><br><br><b>SO.No : </b>NA</td>

                              <td style="font-size: 7.5px; width: 18%; text-indent:2em; line-height: 0.5;"><br><br><b>WO Date : </b>'.strip_tags($Work_order_datess).'</td>

                              <td style="font-size: 7.5px; width: 34%; text-indent:2em; line-height: 0.5;"><br><br><b>Department : </b> Production / Sales / Store</td>
                            </tr>


                             <tr>
                              

                              

                              <td style="font-size: 7.5px; width: 76%; text-indent:2em;"><b>Product / Product Code /Specification/ </b></td>

                              <td style="font-size: 7.5px; width: 12%; text-indent:2em;"><b>Qty <br>&nbsp;&nbsp;UOM</b></td>

                              <td style="font-size: 7.5px; width: 12%; text-indent:2em;"><b>Del. <br>&nbsp;&nbsp;Date</b></td>

                              
                              
                             </tr>

                             
                        </table>';


        
         // reset pointer to the last page
        

                foreach ($data__product as $value_data) 
                {
                    $Entity_id = $value_data['Entity_id'];
                    $Work_order_id = $value_data['Work_order_id'];
                    $Product_id = $value_data['Product_id'];
                    $Work_order_qty = $value_data['Work_order_qty']; 
                    $Dispatch_qty = $value_data['Dispatch_qty']; 
                    $Sales_comment = $value_data['Sales_comment'];   
                    $Factory_comment = $value_data['Factory_comment'];   
                    $Expected_delivery_date = $value_data['Expected_delivery_date_product'];
                    $Expected_delivery_date_product = date("d-m-Y",strtotime($Expected_delivery_date));  
                    $Product_id = $value_data['Product_id']; 

                    $Product_name = $value_data['Product_name']; 
                    $unit = $value_data['unit'];  
                    $Product_long_description = $value_data['Product_long_description'];  
                    $Product_long_description_format = substr($Product_long_description,0,220); 
                       
                      $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            <tr>
                                
                                <td style="font-size: 9px; width:76%; text-indent:1em;">'.strip_tags($Product_name).' : '.strip_tags($Product_id).'<br>&nbsp;'.strip_tags($Product_long_description).'</td>
                                <td style="font-size: 7.5px; width: 12%; text-indent:1em;">'.strip_tags($Work_order_qty).'<br>&nbsp;&nbsp;'.strip_tags($unit).'</td>

                                <td style="font-size: 7.5px; width: 12%; text-indent:1em;">'.strip_tags($Expected_delivery_date_product).'</td>
                            </tr>
                            


                            
                        </table>';
                        
                }
                $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            

                            <tr>
                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>WO Issued By :</b> '.strip_tags($Issued_by).'</td>


                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>Issued To : </b>'.strip_tags($Issued_to).'</td>

                              
                             </tr>

                            
                            
                            
                        </table>';


                $html .=  '<br><table>
                            
                            

                            <tr>
                              <td style="font-size: 8.5px; width: 100%; text-indent:2em;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'.strip_tags($Standard_note).'</b><br><br></td>
                              
                             </tr>

                            
                            
                            
                        </table>';        

        $pdf->writeHTML($html, true, false, true, false, '');


        
        }



        if($data_workorder_product_count ===5)
        {

        $html = '<h2 style="text-align: center;">Tradeorder</h2>
        <table border="0.3" cellpadding="3" width="100%">
                            <tr style="background-color: #C0C0C0;">
                              <td style="font-size: 7.5px; width: 20%; text-indent:2em; line-height: 0.5;"><br><br><b>WO No :</b> '.strip_tags($Work_order_no).'<br></td>

                              <td style="font-size: 7.5px; width: 28%; text-indent:2em; line-height: 0.5;"><br><br><b>SO.No : </b>NA</td>

                              <td style="font-size: 7.5px; width: 18%; text-indent:2em; line-height: 0.5;"><br><br><b>WO Date : </b>'.strip_tags($Work_order_datess).'</td>

                              <td style="font-size: 7.5px; width: 34%; text-indent:2em; line-height: 0.5;"><br><br><b>Department : </b> Production / Sales / Store</td>
                            </tr>


                             <tr>
                              

                              

                              <td style="font-size: 7.5px; width: 76%; text-indent:2em;"><b>Product / Product Code /Specification/ </b></td>

                              <td style="font-size: 7.5px; width: 12%; text-indent:2em;"><b>Qty <br>&nbsp;&nbsp;UOM</b></td>

                              <td style="font-size: 7.5px; width: 12%; text-indent:2em;"><b>Del. <br>&nbsp;&nbsp;Date</b></td>

                              
                              
                             </tr>

                             
                        </table>';


        
         // reset pointer to the last page
        

                foreach ($data__product as $value_data) 
                {
                    $Entity_id = $value_data['Entity_id'];
                    $Work_order_id = $value_data['Work_order_id'];
                    $Product_id = $value_data['Product_id'];
                    $Work_order_qty = $value_data['Work_order_qty']; 
                    $Dispatch_qty = $value_data['Dispatch_qty']; 
                    $Sales_comment = $value_data['Sales_comment'];   
                    $Factory_comment = $value_data['Factory_comment'];   
                    $Expected_delivery_date = $value_data['Expected_delivery_date_product'];
                    $Expected_delivery_date_product = date("d-m-Y",strtotime($Expected_delivery_date));  
                    $Product_id = $value_data['Product_id']; 

                    $Product_name = $value_data['Product_name'];
                    $unit = $value_data['unit'];   
                    $Product_long_description = $value_data['Product_long_description'];  
                    $Product_long_description_format = substr($Product_long_description,0,220); 
                       
                      $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            <tr>
                                
                                <td style="font-size: 9px; width:76%; text-indent:1em;">'.strip_tags($Product_name).' : '.strip_tags($Product_id).'<br>&nbsp;'.strip_tags($Product_long_description).'</td>
                                <td style="font-size: 7.5px; width: 12%; text-indent:1em;">'.strip_tags($Work_order_qty).'<br>&nbsp;&nbsp;'.strip_tags($unit).'</td>

                                <td style="font-size: 7.5px; width: 12%; text-indent:1em;">'.strip_tags($Expected_delivery_date_product).'</td>
                            </tr>
                            


                            
                        </table>';
                        
                }
                $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            

                            <tr>
                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>WO Issued By :</b> '.strip_tags($Issued_by).'</td>


                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>Issued To : </b>'.strip_tags($Issued_to).'</td>

                              
                             </tr>

                            
                            
                            
                        </table>';


                $html .=  '<br><table>
                            
                            

                            <tr>
                              <td style="font-size: 8.5px; width: 100%; text-indent:2em;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'.strip_tags($Standard_note).'</b><br><br></td>
                              
                             </tr>

                            
                            
                            
                        </table>';        

        $pdf->writeHTML($html, true, false, true, false, '');


        
        }


        if($data_workorder_product_count >=7)
        {

        $html = '<h2 style="text-align: center;">Tradeorder</h2>
        <table border="0.3" cellpadding="3" width="100%">
                            <tr style="background-color: #C0C0C0;">
                              <td style="font-size: 7.5px; width: 20%; text-indent:2em; line-height: 0.5;"><br><br><b>WO No :</b> '.strip_tags($Work_order_no).'<br></td>

                              <td style="font-size: 7.5px; width: 28%; text-indent:2em; line-height: 0.5;"><br><br><b>SO.No : </b>NA</td>

                              <td style="font-size: 7.5px; width: 18%; text-indent:2em; line-height: 0.5;"><br><br><b>WO Date : </b>'.strip_tags($Work_order_datess).'</td>

                              <td style="font-size: 7.5px; width: 34%; text-indent:2em; line-height: 0.5;"><br><br><b>Department : </b> Production / Sales / Store</td>
                            </tr>


                             <tr>
                              

                              

                              <td style="font-size: 7.5px; width: 76%; text-indent:2em;"><b>Product / Product Code /Specification/ </b></td>

                              <td style="font-size: 7.5px; width: 12%; text-indent:2em;"><b>Qty <br>&nbsp;&nbsp;UOM</b></td>

                              <td style="font-size: 7.5px; width: 12%; text-indent:2em;"><b>Del. <br>&nbsp;&nbsp;Date</b></td>

                              
                              
                             </tr>

                             
                        </table>';


        
         // reset pointer to the last page
        

                foreach ($data__product as $value_data) 
                {
                    $Entity_id = $value_data['Entity_id'];
                    $Work_order_id = $value_data['Work_order_id'];
                    $Product_id = $value_data['Product_id'];
                    $Work_order_qty = $value_data['Work_order_qty']; 
                    $Dispatch_qty = $value_data['Dispatch_qty']; 
                    $Sales_comment = $value_data['Sales_comment'];   
                    $Factory_comment = $value_data['Factory_comment'];   
                    $Expected_delivery_date = $value_data['Expected_delivery_date_product'];
                    $Expected_delivery_date_product = date("d-m-Y",strtotime($Expected_delivery_date));  
                    $Product_id = $value_data['Product_id']; 

                    $Product_name = $value_data['Product_name'];
                    $unit = $value_data['unit'];   
                    $Product_long_description = $value_data['Product_long_description'];  
                    $Product_long_description_format = substr($Product_long_description,0,220); 
                       
                      $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            <tr>
                                
                                <td style="font-size: 9px; width:76%; text-indent:1em;">'.strip_tags($Product_name).' : '.strip_tags($Product_id).'<br>&nbsp;'.strip_tags($Product_long_description).'</td>
                                <td style="font-size: 7.5px; width: 12%; text-indent:1em;">'.strip_tags($Work_order_qty).'<br>&nbsp;&nbsp;'.strip_tags($unit).'</td>

                                <td style="font-size: 7.5px; width: 12%; text-indent:1em;">'.strip_tags($Expected_delivery_date_product).'</td>
                            </tr>
                            


                            
                        </table>';
                        
                }
                $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            

                            <tr>
                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>WO Issued By :</b> '.strip_tags($Issued_by).'</td>


                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>Issued To : </b>'.strip_tags($Issued_to).'</td>

                              
                             </tr>

                            
                            
                            
                        </table>';


                $html .=  '<br><table>
                            
                            

                            <tr>
                              <td style="font-size: 8.5px; width: 100%; text-indent:2em;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'.strip_tags($Standard_note).'</b><br><br></td>
                              
                             </tr>

                            
                            
                            
                        </table>';        

        $pdf->writeHTML($html, true, false, true, false, '');


        
        }
            $pdf->lastPage();

            //Close and output PDF document
            $pdf->Output('workorder'.date('Y-m-d-H:i:s').'.pdf', 'I');              
       
    }

    public function download_so_workorder()
    {
        ob_start();
        $entity_id = $this->uri->segment(2);

        $this->db->select('work_order_master.work_order_no AS Work_order_no,
                           work_order_master.work_order_type AS Work_order_type,
                           work_order_master.work_order_category AS Work_order_category,
                           work_order_master.work_order_date AS Work_order_date,
                           work_order_master.sales_order_id AS Sales_order_id,
                           work_order_master.expected_delivery_date AS Expected_delivery_date,
                           work_order_master.work_order_description AS Work_order_description,
                           work_order_master.issued_by AS Issued_by,
                           work_order_master.issued_to AS Issued_to,
                           work_order_master.standard_note AS Standard_note,
                           work_order_master.urgency AS Urgency,
                           sales_order_register.sales_order_no AS Sales_order_no');
        $this->db->from('work_order_master');
        $this->db->join('sales_order_register', 'work_order_master.sales_order_id = sales_order_register.entity_id', 'INNER');
        
        $where = '(work_order_master.entity_id = "'.$entity_id.'")';
        $this->db->where($where);
        $query_workorder_data = $this->db->get();
        $query_workorder_data = $query_workorder_data->row_array();
        // print_r($query_workorder_data);
        // die();

        $Work_order_no = $query_workorder_data['Work_order_no'];
        $Work_order_type = $query_workorder_data['Work_order_type'];
        $Work_order_category = $query_workorder_data['Work_order_category'];
        $Work_order_date = $query_workorder_data['Work_order_date'];
        $Work_order_datess = date("d-m-Y",strtotime($Work_order_date));
        //$Sales_order_id = $query_workorder_data['Sales_order_id'];
        $Expected_delivery_date = $query_workorder_data['Expected_delivery_date'];
        $Issued_by = $query_workorder_data['Issued_by'];
        $Issued_to = $query_workorder_data['Issued_to'];
        $Standard_note = $query_workorder_data['Standard_note'];
        $Urgency = $query_workorder_data['Urgency'];
        $Sales_order_no = $query_workorder_data['Sales_order_no'];


        $Work_order_description = $query_workorder_data['Work_order_description'];
        //$Sales_order_no = $query_workorder_data['Sales_order_no'];

        if ($Work_order_type == 1) {
               $Work_order_type = "Workorder";
            }elseif ($Work_order_type == 2) {
               $Work_order_type = "Tradeorder";
            }

        if ($Work_order_category == 1) {
               $Work_order_category = "Workorder";
            }elseif ($Work_order_category == 2) {
               $Work_order_category = "Tradeorder";
            }    


        $this->db->select('work_order_product_relation.entity_id AS Entity_id,
                           work_order_product_relation.work_order_id AS Work_order_id,
                           work_order_product_relation.product_id AS Product_id,
                           work_order_product_relation.work_order_qty AS Work_order_qty,
                           work_order_product_relation.dispatch_qty AS Dispatch_qty,
                           work_order_product_relation.sales_comment AS Sales_comment,
                           work_order_product_relation.factory_comment AS Factory_comment,
                           work_order_product_relation.expected_delivery_date AS Expected_delivery_date_product,

                           work_order_product_relation.product_custom_description AS Product_long_description,
                           product_master.product_id as Product_id,
                           product_master.product_name AS Product_name,
                           product_master.unit AS unit');
        $this->db->from('work_order_product_relation');
        $this->db->join('product_master', 'work_order_product_relation.product_id = product_master.entity_id', 'INNER');

        $where = '(work_order_product_relation.work_order_id = "'.$entity_id.'")';
        $this->db->where($where);
        $workorder_product_data= $this->db->get();
        $data__product = $workorder_product_data->result_array(); 
        $data_workorder_product_count = $workorder_product_data->num_rows();
        
        //print_r($data_offer_product_count);
        //die();
        //$location_id = $_SESSION['location_id'];
        $pdf = new Workorder_pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, 'LETTER', true, 'UTF-8', false);
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);

        // set font
        $pdf->SetFont('dejavusans', '', 10);
        $path_img = getcwd();

        // add a page
        $pdf->AddPage();

        if($data_workorder_product_count ===1)
        {

        $html = '<h2 style="text-align: center;">Workorder</h2>
        <table border="0.3" cellpadding="3" width="100%">
                            <tr style="background-color: #C0C0C0;">
                              <td style="font-size: 7.5px; width: 20%; text-indent:2em; line-height: 0.5;"><br><br><b>WO No :</b> '.strip_tags($Work_order_no).'<br></td>

                              <td style="font-size: 7.5px; width: 28%; text-indent:2em; line-height: 0.5;"><br><br><b>SO.No : </b>'.strip_tags($Sales_order_no).'</td>

                              <td style="font-size: 7.5px; width: 18%; text-indent:2em; line-height: 0.5;"><br><br><b>WO Date : </b>'.strip_tags($Work_order_datess).'</td>

                              <td style="font-size: 7.5px; width: 34%; text-indent:2em; line-height: 0.5;"><br><br><b>Department : </b> Production / Sales / Store</td>
                            </tr>


                             <tr>
                   
                              <td style="font-size: 7.5px; width: 80%; text-indent:2em;"><b>Product / Product Code /Specification/ </b></td>

                              <td style="font-size: 7.5px; width: 10%; text-indent:2em;"><b>Qty <br>&nbsp;&nbsp;UOM</b></td>

                              <td style="font-size: 7.5px; width: 10%; text-indent:2em;"><b>Del. <br>&nbsp;&nbsp;Date</b></td>

                              
                              
                             </tr>

                             
                        </table>';


        
         // reset pointer to the last page
        

                foreach ($data__product as $value_data) 
                {
                    $Entity_id = $value_data['Entity_id'];
                    $Work_order_id = $value_data['Work_order_id'];
                    $Product_id = $value_data['Product_id'];
                    $Work_order_qty = $value_data['Work_order_qty']; 
                    $Dispatch_qty = $value_data['Dispatch_qty']; 
                    $Sales_comment = $value_data['Sales_comment'];   
                    $Factory_comment = $value_data['Factory_comment'];   
                    $Expected_delivery_date = $value_data['Expected_delivery_date_product'];
                    $Expected_delivery_date_product = date("d-m-Y",strtotime($Expected_delivery_date));  
                    $Product_id = $value_data['Product_id']; 

                    $Product_name = $value_data['Product_name']; 
                    $unit = $value_data['unit']; 
                    $Product_long_description = $value_data['Product_long_description'];   
                    $Product_long_description_format = substr($Product_long_description,0,220); 
                       
                      $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            <tr>
                                
                                <td style="font-size: 9px; width:80%; text-indent:1em;">'.strip_tags($Product_name).' : '.strip_tags($Product_id).'<br>&nbsp;'.strip_tags($Product_long_description).'</td>
                                <td style="font-size: 7.5px; width: 10%; text-indent:1em;">'.strip_tags($Work_order_qty).'<br>&nbsp;&nbsp;'.strip_tags($unit).'</td>

                                <td style="font-size: 7.5px; width: 10%; text-indent:1em;">'.strip_tags($Expected_delivery_date_product).'</td>
                            </tr>

                            
                        </table>';
                        
                }
                
                $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            

                            <tr>
                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>WO Issued By :</b> '.strip_tags($Issued_by).'</td>


                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>Issued To : </b>'.strip_tags($Issued_to).'</td>

                              
                             </tr>

                            
                            
                            
                        </table>';


                $html .=  '<br><table>
                            
                            

                            <tr>
                              <td style="font-size: 8.5px; width: 100%; text-indent:2em;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'.strip_tags($Standard_note).'</b><br><br></td>
                              
                             </tr>

                            
                            
                            
                        </table>';        

        $pdf->writeHTML($html, true, false, true, false, '');


        
        }



        if($data_workorder_product_count ===2)
        {

        $html = '<h2 style="text-align: center;">Workorder</h2>
        <table border="0.3" cellpadding="3" width="100%">
                            <tr style="background-color: #C0C0C0;">
                              <td style="font-size: 7.5px; width: 20%; text-indent:2em; line-height: 0.5;"><br><br><b>WO No :</b> '.strip_tags($Work_order_no).'<br></td>

                              <td style="font-size: 7.5px; width: 28%; text-indent:2em; line-height: 0.5;"><br><br><b>SO.No : </b>'.strip_tags($Sales_order_no).'</td>

                              <td style="font-size: 7.5px; width: 18%; text-indent:2em; line-height: 0.5;"><br><br><b>WO Date : </b>'.strip_tags($Work_order_datess).'</td>

                              <td style="font-size: 7.5px; width: 34%; text-indent:2em; line-height: 0.5;"><br><br><b>Department : </b> Production / Sales / Store</td>
                            </tr>


                             <tr>
                              

                              

                              <td style="font-size: 7.5px; width: 80%; text-indent:2em;"><b>Product / Product Code /Specification/ </b></td>

                              <td style="font-size: 7.5px; width: 10%; text-indent:2em;"><b>Qty <br>&nbsp;&nbsp;UOM</b></td>

                              <td style="font-size: 7.5px; width: 10%; text-indent:2em;"><b>Del. <br>&nbsp;&nbsp;Date</b></td>

                              
                              
                             </tr>

                             
                        </table>';


        
         // reset pointer to the last page
        

                foreach ($data__product as $value_data) 
                {
                    $Entity_id = $value_data['Entity_id'];
                    $Work_order_id = $value_data['Work_order_id'];
                    $Product_id = $value_data['Product_id'];
                    $Work_order_qty = $value_data['Work_order_qty']; 
                    $Dispatch_qty = $value_data['Dispatch_qty']; 
                    $Sales_comment = $value_data['Sales_comment'];   
                    $Factory_comment = $value_data['Factory_comment'];   
                    $Expected_delivery_date = $value_data['Expected_delivery_date_product'];
                    $Expected_delivery_date_product = date("d-m-Y",strtotime($Expected_delivery_date));  
                    $Product_id = $value_data['Product_id']; 

                    $Product_name = $value_data['Product_name']; 
                    $unit = $value_data['unit'];
                    $Product_long_description = $value_data['Product_long_description'];   
                    $Product_long_description_format = substr($Product_long_description,0,220); 
                       
                      $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            <tr>
                                
                                <td style="font-size: 9px; width:80%; text-indent:1em;">'.strip_tags($Product_name).' : '.strip_tags($Product_id).'<br>&nbsp;'.strip_tags($Product_long_description).'</td>
                                <td style="font-size: 7.5px; width: 10%; text-indent:1em;">'.strip_tags($Work_order_qty).'<br>&nbsp;&nbsp;'.strip_tags($unit).'</td>

                                <td style="font-size: 7.5px; width: 10%; text-indent:1em;">'.strip_tags($Expected_delivery_date_product).'</td>
                            </tr>

                            
                        </table>';
                        
                }
                
                $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            

                            <tr>
                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>WO Issued By :</b> '.strip_tags($Issued_by).'</td>


                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>Issued To : </b>'.strip_tags($Issued_to).'</td>

                              
                             </tr>

                            
                            
                            
                        </table>';


                $html .=  '<br><table>
                            
                            

                            <tr>
                              <td style="font-size: 8.5px; width: 100%; text-indent:2em;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'.strip_tags($Standard_note).'</b><br><br></td>
                              
                             </tr>

                            
                            
                            
                        </table>';        

        $pdf->writeHTML($html, true, false, true, false, '');


        
        }


        if($data_workorder_product_count ===3)
        {

        $html = '<h2 style="text-align: center;">Workorder</h2>
        <table border="0.3" cellpadding="3" width="100%">
                            <tr style="background-color: #C0C0C0;">
                              <td style="font-size: 7.5px; width: 20%; text-indent:2em; line-height: 0.5;"><br><br><b>WO No :</b> '.strip_tags($Work_order_no).'<br></td>

                              <td style="font-size: 7.5px; width: 28%; text-indent:2em; line-height: 0.5;"><br><br><b>SO.No : </b>'.strip_tags($Sales_order_no).'</td>

                              <td style="font-size: 7.5px; width: 18%; text-indent:2em; line-height: 0.5;"><br><br><b>WO Date : </b>'.strip_tags($Work_order_datess).'</td>

                              <td style="font-size: 7.5px; width: 34%; text-indent:2em; line-height: 0.5;"><br><br><b>Department : </b> Production / Sales / Store</td>
                            </tr>


                             <tr>
                              

                              

                              <td style="font-size: 7.5px; width: 80%; text-indent:2em;"><b>Product / Product Code /Specification/ </b></td>

                              <td style="font-size: 7.5px; width: 10%; text-indent:2em;"><b>Qty <br>&nbsp;&nbsp;UOM</b></td>

                              <td style="font-size: 7.5px; width: 10%; text-indent:2em;"><b>Del. <br>&nbsp;&nbsp;Date</b></td>

                              
                              
                             </tr>

                             
                        </table>';


        
         // reset pointer to the last page
        

                foreach ($data__product as $value_data) 
                {
                    $Entity_id = $value_data['Entity_id'];
                    $Work_order_id = $value_data['Work_order_id'];
                    $Product_id = $value_data['Product_id'];
                    $Work_order_qty = $value_data['Work_order_qty']; 
                    $Dispatch_qty = $value_data['Dispatch_qty']; 
                    $Sales_comment = $value_data['Sales_comment'];   
                    $Factory_comment = $value_data['Factory_comment'];   
                    $Expected_delivery_date = $value_data['Expected_delivery_date_product'];
                    $Expected_delivery_date_product = date("d-m-Y",strtotime($Expected_delivery_date));  
                    $Product_id = $value_data['Product_id']; 

                    $Product_name = $value_data['Product_name']; 
                    $unit = $value_data['unit'];
                    $Product_long_description = $value_data['Product_long_description'];   
                    $Product_long_description_format = substr($Product_long_description,0,220); 
                       
                      $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            <tr>
                                
                                <td style="font-size: 9px; width:80%; text-indent:1em;">'.strip_tags($Product_name).' : '.strip_tags($Product_id).'<br>&nbsp;'.strip_tags($Product_long_description).'</td>
                                <td style="font-size: 7.5px; width: 10%; text-indent:1em;">'.strip_tags($Work_order_qty).'<br>&nbsp;&nbsp;'.strip_tags($unit).'</td>

                                <td style="font-size: 7.5px; width: 10%; text-indent:1em;">'.strip_tags($Expected_delivery_date_product).'</td>
                            </tr>

                            
                        </table>';
                        
                }
                
                $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            

                            <tr>
                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>WO Issued By :</b> '.strip_tags($Issued_by).'</td>


                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>Issued To : </b>'.strip_tags($Issued_to).'</td>

                              
                             </tr>

                            
                            
                            
                        </table>';


                $html .=  '<br><table>
                            
                            

                            <tr>
                              <td style="font-size: 8.5px; width: 100%; text-indent:2em;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'.strip_tags($Standard_note).'</b><br><br></td>
                              
                             </tr>

                            
                            
                            
                        </table>';        

        $pdf->writeHTML($html, true, false, true, false, '');


        
        }








        if($data_workorder_product_count ===4)
        {

        $html = '<h2 style="text-align: center;">Workorder</h2>
        <table border="0.3" cellpadding="3" width="100%">
                            <tr style="background-color: #C0C0C0;">
                              <td style="font-size: 7.5px; width: 20%; text-indent:2em; line-height: 0.5;"><br><br><b>WO No :</b> '.strip_tags($Work_order_no).'<br></td>

                              <td style="font-size: 7.5px; width: 28%; text-indent:2em; line-height: 0.5;"><br><br><b>SO.No : </b>'.strip_tags($Sales_order_no).'</td>

                              <td style="font-size: 7.5px; width: 18%; text-indent:2em; line-height: 0.5;"><br><br><b>WO Date : </b>'.strip_tags($Work_order_datess).'</td>

                              <td style="font-size: 7.5px; width: 34%; text-indent:2em; line-height: 0.5;"><br><br><b>Department : </b> Production / Sales / Store</td>
                            </tr>


                             <tr>
                              

                              

                              <td style="font-size: 7.5px; width: 80%; text-indent:2em;"><b>Product / Product Code /Specification/ </b></td>

                              <td style="font-size: 7.5px; width: 10%; text-indent:2em;"><b>Qty <br>&nbsp;&nbsp;UOM</b></td>

                              <td style="font-size: 7.5px; width: 10%; text-indent:2em;"><b>Del. <br>&nbsp;&nbsp;Date</b></td>

                              
                              
                             </tr>

                             
                        </table>';


        
         // reset pointer to the last page
        

                foreach ($data__product as $value_data) 
                {
                    $Entity_id = $value_data['Entity_id'];
                    $Work_order_id = $value_data['Work_order_id'];
                    $Product_id = $value_data['Product_id'];
                    $Work_order_qty = $value_data['Work_order_qty']; 
                    $Dispatch_qty = $value_data['Dispatch_qty']; 
                    $Sales_comment = $value_data['Sales_comment'];   
                    $Factory_comment = $value_data['Factory_comment'];   
                    $Expected_delivery_date = $value_data['Expected_delivery_date_product'];
                    $Expected_delivery_date_product = date("d-m-Y",strtotime($Expected_delivery_date));  
                    $Product_id = $value_data['Product_id']; 

                    $Product_name = $value_data['Product_name']; 
                    $unit = $value_data['unit'];
                    $Product_long_description = $value_data['Product_long_description'];   
                    $Product_long_description_format = substr($Product_long_description,0,220); 
                       
                      $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            <tr>
                                
                                <td style="font-size: 9px; width:80%; text-indent:1em;">'.strip_tags($Product_name).' : '.strip_tags($Product_id).'<br>&nbsp;'.strip_tags($Product_long_description).'</td>
                                <td style="font-size: 7.5px; width: 10%; text-indent:1em;">'.strip_tags($Work_order_qty).'<br>&nbsp;&nbsp;'.strip_tags($unit).'</td>

                                <td style="font-size: 7.5px; width: 10%; text-indent:1em;">'.strip_tags($Expected_delivery_date_product).'</td>
                            </tr>

                            
                        </table>';
                        
                }
                
                $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            

                            <tr>
                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>WO Issued By :</b> '.strip_tags($Issued_by).'</td>


                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>Issued To : </b>'.strip_tags($Issued_to).'</td>

                              
                             </tr>

                            
                            
                            
                        </table>';


                $html .=  '<br><table>
                            
                            

                            <tr>
                              <td style="font-size: 8.5px; width: 100%; text-indent:2em;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'.strip_tags($Standard_note).'</b><br><br></td>
                              
                             </tr>

                            
                            
                            
                        </table>';        

        $pdf->writeHTML($html, true, false, true, false, '');


        
        }





        if($data_workorder_product_count ===5)
        {

        $html = '<h2 style="text-align: center;">Workorder</h2>
        <table border="0.3" cellpadding="3" width="100%">
                            <tr style="background-color: #C0C0C0;">
                              <td style="font-size: 7.5px; width: 20%; text-indent:2em; line-height: 0.5;"><br><br><b>WO No :</b> '.strip_tags($Work_order_no).'<br></td>

                              <td style="font-size: 7.5px; width: 28%; text-indent:2em; line-height: 0.5;"><br><br><b>SO.No : </b>'.strip_tags($Sales_order_no).'</td>

                              <td style="font-size: 7.5px; width: 18%; text-indent:2em; line-height: 0.5;"><br><br><b>WO Date : </b>'.strip_tags($Work_order_datess).'</td>

                              <td style="font-size: 7.5px; width: 34%; text-indent:2em; line-height: 0.5;"><br><br><b>Department : </b> Production / Sales / Store</td>
                            </tr>


                             <tr>
                              

                              

                              <td style="font-size: 7.5px; width: 80%; text-indent:2em;"><b>Product / Product Code /Specification/ </b></td>

                              <td style="font-size: 7.5px; width: 10%; text-indent:2em;"><b>Qty <br>&nbsp;&nbsp;UOM</b></td>

                              <td style="font-size: 7.5px; width: 10%; text-indent:2em;"><b>Del. <br>&nbsp;&nbsp;Date</b></td>

                              
                              
                             </tr>

                             
                        </table>';


        
         // reset pointer to the last page
        

                foreach ($data__product as $value_data) 
                {
                    $Entity_id = $value_data['Entity_id'];
                    $Work_order_id = $value_data['Work_order_id'];
                    $Product_id = $value_data['Product_id'];
                    $Work_order_qty = $value_data['Work_order_qty']; 
                    $Dispatch_qty = $value_data['Dispatch_qty']; 
                    $Sales_comment = $value_data['Sales_comment'];   
                    $Factory_comment = $value_data['Factory_comment'];   
                    $Expected_delivery_date = $value_data['Expected_delivery_date_product'];
                    $Expected_delivery_date_product = date("d-m-Y",strtotime($Expected_delivery_date));  
                    $Product_id = $value_data['Product_id']; 

                    $Product_name = $value_data['Product_name']; 
                    $unit = $value_data['unit'];
                    $Product_long_description = $value_data['Product_long_description'];   
                    $Product_long_description_format = substr($Product_long_description,0,220); 
                       
                      $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            <tr>
                                
                                <td style="font-size: 9px; width:80%; text-indent:1em;">'.strip_tags($Product_name).' : '.strip_tags($Product_id).'<br>&nbsp;'.strip_tags($Product_long_description).'</td>
                                <td style="font-size: 7.5px; width: 10%; text-indent:1em;">'.strip_tags($Work_order_qty).'<br>&nbsp;&nbsp;'.strip_tags($unit).'</td>

                                <td style="font-size: 7.5px; width: 10%; text-indent:1em;">'.strip_tags($Expected_delivery_date_product).'</td>
                            </tr>

                            
                        </table>';
                        
                }
                
                $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            

                            <tr>
                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>WO Issued By :</b> '.strip_tags($Issued_by).'</td>


                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>Issued To : </b>'.strip_tags($Issued_to).'</td>

                              
                             </tr>

                            
                            
                            
                        </table>';


                $html .=  '<br><table>
                            
                            

                            <tr>
                              <td style="font-size: 8.5px; width: 100%; text-indent:2em;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'.strip_tags($Standard_note).'</b><br><br></td>
                              
                             </tr>

                            
                            
                            
                        </table>';        

        $pdf->writeHTML($html, true, false, true, false, '');


        
        }




        if($data_workorder_product_count >=7)
        {

        $html = '<h2 style="text-align: center;">Workorder</h2>
        <table border="0.3" cellpadding="3" width="100%">
                            <tr style="background-color: #C0C0C0;">
                              <td style="font-size: 7.5px; width: 20%; text-indent:2em; line-height: 0.5;"><br><br><b>WO No :</b> '.strip_tags($Work_order_no).'<br></td>

                              <td style="font-size: 7.5px; width: 28%; text-indent:2em; line-height: 0.5;"><br><br><b>SO.No : </b>'.strip_tags($Sales_order_no).'</td>

                              <td style="font-size: 7.5px; width: 18%; text-indent:2em; line-height: 0.5;"><br><br><b>WO Date : </b>'.strip_tags($Work_order_datess).'</td>

                              <td style="font-size: 7.5px; width: 34%; text-indent:2em; line-height: 0.5;"><br><br><b>Department : </b> Production / Sales / Store</td>
                            </tr>


                             <tr>
                              

                              

                              <td style="font-size: 7.5px; width: 80%; text-indent:2em;"><b>Product / Product Code /Specification/ </b></td>

                              <td style="font-size: 7.5px; width: 10%; text-indent:2em;"><b>Qty <br>&nbsp;&nbsp;UOM</b></td>

                              <td style="font-size: 7.5px; width: 10%; text-indent:2em;"><b>Del. <br>&nbsp;&nbsp;Date</b></td>

                              
                              
                             </tr>

                             
                        </table>';


        
         // reset pointer to the last page
        

                foreach ($data__product as $value_data) 
                {
                    $Entity_id = $value_data['Entity_id'];
                    $Work_order_id = $value_data['Work_order_id'];
                    $Product_id = $value_data['Product_id'];
                    $Work_order_qty = $value_data['Work_order_qty']; 
                    $Dispatch_qty = $value_data['Dispatch_qty']; 
                    $Sales_comment = $value_data['Sales_comment'];   
                    $Factory_comment = $value_data['Factory_comment'];   
                    $Expected_delivery_date = $value_data['Expected_delivery_date_product'];
                    $Expected_delivery_date_product = date("d-m-Y",strtotime($Expected_delivery_date));  
                    $Product_id = $value_data['Product_id']; 

                    $Product_name = $value_data['Product_name']; 
                    $unit = $value_data['unit'];
                    $Product_long_description = $value_data['Product_long_description'];   
                    $Product_long_description_format = substr($Product_long_description,0,220); 
                       
                      $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            <tr>
                                
                                <td style="font-size: 9px; width:80%; text-indent:1em;">'.strip_tags($Product_name).' : '.strip_tags($Product_id).'<br>&nbsp;'.strip_tags($Product_long_description).'</td>
                                <td style="font-size: 7.5px; width: 10%; text-indent:1em;">'.strip_tags($Work_order_qty).'<br>&nbsp;&nbsp;'.strip_tags($unit).'</td>

                                <td style="font-size: 7.5px; width: 10%; text-indent:1em;">'.strip_tags($Expected_delivery_date_product).'</td>
                            </tr>

                            
                        </table>';
                        
                }
                
                $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            

                            <tr>
                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>WO Issued By :</b> '.strip_tags($Issued_by).'</td>


                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>Issued To : </b>'.strip_tags($Issued_to).'</td>

                              
                             </tr>

                            
                            
                            
                        </table>';


                $html .=  '<br><table>
                            
                            

                            <tr>
                              <td style="font-size: 8.5px; width: 100%; text-indent:2em;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'.strip_tags($Standard_note).'</b><br><br></td>
                              
                             </tr>

                            
                            
                            
                        </table>';        

        $pdf->writeHTML($html, true, false, true, false, '');


        
        }





            $pdf->lastPage();

            //Close and output PDF document
            $pdf->Output('workorder'.date('Y-m-d-H:i:s').'.pdf', 'I');        
       
    }

    public function download_so_tradeorder()
    {
        ob_start();
        $entity_id = $this->uri->segment(2);

        $this->db->select('work_order_master.work_order_no AS Work_order_no,
                           work_order_master.work_order_type AS Work_order_type,
                           work_order_master.work_order_category AS Work_order_category,
                           work_order_master.work_order_date AS Work_order_date,
                           work_order_master.sales_order_id AS Sales_order_id,
                           work_order_master.expected_delivery_date AS Expected_delivery_date,
                           work_order_master.work_order_description AS Work_order_description,
                           work_order_master.issued_by AS Issued_by,
                           work_order_master.issued_to AS Issued_to,
                           work_order_master.standard_note AS Standard_note,
                           work_order_master.urgency AS Urgency,
                           sales_order_register.sales_order_no AS Sales_order_no');
        $this->db->from('work_order_master');
        $this->db->join('sales_order_register', 'work_order_master.sales_order_id = sales_order_register.entity_id', 'INNER');
        
        $where = '(work_order_master.entity_id = "'.$entity_id.'")';
        $this->db->where($where);
        $query_workorder_data = $this->db->get();
        $query_workorder_data = $query_workorder_data->row_array();
        // print_r($query_workorder_data);
        // die();

        $Work_order_no = $query_workorder_data['Work_order_no'];
        $Work_order_type = $query_workorder_data['Work_order_type'];
        $Work_order_category = $query_workorder_data['Work_order_category'];
        $Work_order_date = $query_workorder_data['Work_order_date'];
        $Work_order_datess = date("d-m-Y",strtotime($Work_order_date));
        //$Sales_order_id = $query_workorder_data['Sales_order_id'];
        $Expected_delivery_date = $query_workorder_data['Expected_delivery_date'];
        $Issued_by = $query_workorder_data['Issued_by'];
        $Issued_to = $query_workorder_data['Issued_to'];
        $Standard_note = $query_workorder_data['Standard_note'];
        $Urgency = $query_workorder_data['Urgency'];
        $Sales_order_no = $query_workorder_data['Sales_order_no'];


        $Work_order_description = $query_workorder_data['Work_order_description'];
        //$Sales_order_no = $query_workorder_data['Sales_order_no'];

        if ($Work_order_type == 1) {
               $Work_order_type = "Workorder";
            }elseif ($Work_order_type == 2) {
               $Work_order_type = "Tradeorder";
            }

        if ($Work_order_category == 1) {
               $Work_order_category = "Workorder";
            }elseif ($Work_order_category == 2) {
               $Work_order_category = "Tradeorder";
            }    


        $this->db->select('work_order_product_relation.entity_id AS Entity_id,
                           work_order_product_relation.work_order_id AS Work_order_id,
                           work_order_product_relation.product_id AS Product_id,
                           work_order_product_relation.work_order_qty AS Work_order_qty,
                           work_order_product_relation.dispatch_qty AS Dispatch_qty,
                           work_order_product_relation.sales_comment AS Sales_comment,
                           work_order_product_relation.factory_comment AS Factory_comment,
                           work_order_product_relation.expected_delivery_date AS Expected_delivery_date_product,

                           work_order_product_relation.product_custom_description AS Product_long_description,
                           product_master.product_id as Product_id,
                           product_master.product_name AS Product_name,
                           product_master.unit AS unit');
        $this->db->from('work_order_product_relation');
        $this->db->join('product_master', 'work_order_product_relation.product_id = product_master.entity_id', 'INNER');

        $where = '(work_order_product_relation.work_order_id = "'.$entity_id.'")';
        $this->db->where($where);
        $workorder_product_data= $this->db->get();
        $data__product = $workorder_product_data->result_array(); 
        $data_workorder_product_count = $workorder_product_data->num_rows();
        
        //print_r($data_offer_product_count);
        //die();
        //$location_id = $_SESSION['location_id'];
        $pdf = new Workorder_pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, 'LETTER', true, 'UTF-8', false);
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);

        // set font
        $pdf->SetFont('dejavusans', '', 10);
        $path_img = getcwd();

        // add a page
        $pdf->AddPage();

        if($data_workorder_product_count ===1)
        {

        $html = '<h2 style="text-align: center;">Tradeorder</h2>
        <table border="0.3" cellpadding="3" width="100%">
                            <tr style="background-color: #C0C0C0;">
                              <td style="font-size: 7.5px; width: 20%; text-indent:2em; line-height: 0.5;"><br><br><b>WO No :</b> '.strip_tags($Work_order_no).'<br></td>

                              <td style="font-size: 7.5px; width: 28%; text-indent:2em; line-height: 0.5;"><br><br><b>SO.No : </b>'.strip_tags($Sales_order_no).'</td>

                              <td style="font-size: 7.5px; width: 18%; text-indent:2em; line-height: 0.5;"><br><br><b>WO Date : </b>'.strip_tags($Work_order_datess).'</td>

                              <td style="font-size: 7.5px; width: 34%; text-indent:2em; line-height: 0.5;"><br><br><b>Department : </b> Production / Sales / Store</td>
                            </tr>


                             <tr>
                              

                              

                              <td style="font-size: 7.5px; width: 80%; text-indent:2em;"><b>Product / Product Code /Specification/ </b></td>

                              <td style="font-size: 7.5px; width: 10%; text-indent:2em;"><b>Qty <br>&nbsp;&nbsp;UOM</b></td>

                              <td style="font-size: 7.5px; width: 10%; text-indent:2em;"><b>Del. <br>&nbsp;&nbsp;Date</b></td>

                              
                              
                             </tr>

                             
                        </table>';


        
         // reset pointer to the last page
        

                foreach ($data__product as $value_data) 
                {
                    $Entity_id = $value_data['Entity_id'];
                    $Work_order_id = $value_data['Work_order_id'];
                    $Product_id = $value_data['Product_id'];
                    $Work_order_qty = $value_data['Work_order_qty']; 
                    $Dispatch_qty = $value_data['Dispatch_qty']; 
                    $Sales_comment = $value_data['Sales_comment'];   
                    $Factory_comment = $value_data['Factory_comment'];   
                    $Expected_delivery_date = $value_data['Expected_delivery_date_product'];
                    $Expected_delivery_date_product = date("d-m-Y",strtotime($Expected_delivery_date));  
                    $Product_id = $value_data['Product_id']; 

                    $Product_name = $value_data['Product_name']; 
                    $unit = $value_data['unit']; 
                    $Product_long_description = $value_data['Product_long_description'];   
                    $Product_long_description_format = substr($Product_long_description,0,220); 
                       
                      $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            <tr>
                                
                                <td style="font-size: 9px; width:80%; text-indent:1em;">'.strip_tags($Product_name).' : '.strip_tags($Product_id).'<br>&nbsp;'.strip_tags($Product_long_description).'</td>
                                <td style="font-size: 7.5px; width: 10%; text-indent:1em;">'.strip_tags($Work_order_qty).'<br>&nbsp;&nbsp;'.strip_tags($unit).'</td>

                                <td style="font-size: 7.5px; width: 10%; text-indent:1em;">'.strip_tags($Expected_delivery_date_product).'</td>
                            </tr>

                            
                        </table>';
                        
                }
                
                $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            

                            <tr>
                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>WO Issued By :</b> '.strip_tags($Issued_by).'</td>


                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>Issued To : </b>'.strip_tags($Issued_to).'</td>

                              
                             </tr>

                            
                            
                            
                        </table>';


                $html .=  '<br><table>
                            
                            

                            <tr>
                              <td style="font-size: 8.5px; width: 100%; text-indent:2em;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'.strip_tags($Standard_note).'</b><br><br></td>
                              
                             </tr>

                            
                            
                            
                        </table>';        

        $pdf->writeHTML($html, true, false, true, false, '');


        
        }



        if($data_workorder_product_count ===2)
        {

        $html = '<h2 style="text-align: center;">Tradeorder</h2>
        <table border="0.3" cellpadding="3" width="100%">
                            <tr style="background-color: #C0C0C0;">
                              <td style="font-size: 7.5px; width: 20%; text-indent:2em; line-height: 0.5;"><br><br><b>WO No :</b> '.strip_tags($Work_order_no).'<br></td>

                              <td style="font-size: 7.5px; width: 28%; text-indent:2em; line-height: 0.5;"><br><br><b>SO.No : </b>'.strip_tags($Sales_order_no).'</td>

                              <td style="font-size: 7.5px; width: 18%; text-indent:2em; line-height: 0.5;"><br><br><b>WO Date : </b>'.strip_tags($Work_order_datess).'</td>

                              <td style="font-size: 7.5px; width: 34%; text-indent:2em; line-height: 0.5;"><br><br><b>Department : </b> Production / Sales / Store</td>
                            </tr>


                             <tr>
                              

                              

                              <td style="font-size: 7.5px; width: 80%; text-indent:2em;"><b>Product / Product Code /Specification/ </b></td>

                              <td style="font-size: 7.5px; width: 10%; text-indent:2em;"><b>Qty <br>&nbsp;&nbsp;UOM</b></td>

                              <td style="font-size: 7.5px; width: 10%; text-indent:2em;"><b>Del. <br>&nbsp;&nbsp;Date</b></td>

                              
                              
                             </tr>

                             
                        </table>';


        
         // reset pointer to the last page
        

                foreach ($data__product as $value_data) 
                {
                    $Entity_id = $value_data['Entity_id'];
                    $Work_order_id = $value_data['Work_order_id'];
                    $Product_id = $value_data['Product_id'];
                    $Work_order_qty = $value_data['Work_order_qty']; 
                    $Dispatch_qty = $value_data['Dispatch_qty']; 
                    $Sales_comment = $value_data['Sales_comment'];   
                    $Factory_comment = $value_data['Factory_comment'];   
                    $Expected_delivery_date = $value_data['Expected_delivery_date_product'];
                    $Expected_delivery_date_product = date("d-m-Y",strtotime($Expected_delivery_date));  
                    $Product_id = $value_data['Product_id']; 

                    $Product_name = $value_data['Product_name']; 
                    $unit = $value_data['unit'];
                    $Product_long_description = $value_data['Product_long_description'];   
                    $Product_long_description_format = substr($Product_long_description,0,220); 
                       
                      $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            <tr>
                                
                                <td style="font-size: 9px; width:80%; text-indent:1em;">'.strip_tags($Product_name).' : '.strip_tags($Product_id).'<br>&nbsp;'.strip_tags($Product_long_description).'</td>
                                <td style="font-size: 7.5px; width: 10%; text-indent:1em;">'.strip_tags($Work_order_qty).'<br>&nbsp;&nbsp;'.strip_tags($unit).'</td>

                                <td style="font-size: 7.5px; width: 10%; text-indent:1em;">'.strip_tags($Expected_delivery_date_product).'</td>
                            </tr>

                            
                        </table>';
                        
                }
                
                $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            

                            <tr>
                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>WO Issued By :</b> '.strip_tags($Issued_by).'</td>


                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>Issued To : </b>'.strip_tags($Issued_to).'</td>

                              
                             </tr>

                            
                            
                            
                        </table>';        

        $pdf->writeHTML($html, true, false, true, false, '');


        
        }


        if($data_workorder_product_count ===3)
        {

        $html = '<h2 style="text-align: center;">Tradeorder</h2>
        <table border="0.3" cellpadding="3" width="100%">
                            <tr style="background-color: #C0C0C0;">
                              <td style="font-size: 7.5px; width: 20%; text-indent:2em; line-height: 0.5;"><br><br><b>WO No :</b> '.strip_tags($Work_order_no).'<br></td>

                              <td style="font-size: 7.5px; width: 28%; text-indent:2em; line-height: 0.5;"><br><br><b>SO.No : </b>'.strip_tags($Sales_order_no).'</td>

                              <td style="font-size: 7.5px; width: 18%; text-indent:2em; line-height: 0.5;"><br><br><b>WO Date : </b>'.strip_tags($Work_order_datess).'</td>

                              <td style="font-size: 7.5px; width: 34%; text-indent:2em; line-height: 0.5;"><br><br><b>Department : </b> Production / Sales / Store</td>
                            </tr>


                             <tr>
                              

                              

                              <td style="font-size: 7.5px; width: 80%; text-indent:2em;"><b>Product / Product Code /Specification/ </b></td>

                              <td style="font-size: 7.5px; width: 10%; text-indent:2em;"><b>Qty <br>&nbsp;&nbsp;UOM</b></td>

                              <td style="font-size: 7.5px; width: 10%; text-indent:2em;"><b>Del. <br>&nbsp;&nbsp;Date</b></td>

                              
                              
                             </tr>

                             
                        </table>';


        
         // reset pointer to the last page
        

                foreach ($data__product as $value_data) 
                {
                    $Entity_id = $value_data['Entity_id'];
                    $Work_order_id = $value_data['Work_order_id'];
                    $Product_id = $value_data['Product_id'];
                    $Work_order_qty = $value_data['Work_order_qty']; 
                    $Dispatch_qty = $value_data['Dispatch_qty']; 
                    $Sales_comment = $value_data['Sales_comment'];   
                    $Factory_comment = $value_data['Factory_comment'];   
                    $Expected_delivery_date = $value_data['Expected_delivery_date_product'];
                    $Expected_delivery_date_product = date("d-m-Y",strtotime($Expected_delivery_date));  
                    $Product_id = $value_data['Product_id']; 

                    $Product_name = $value_data['Product_name']; 
                    $unit = $value_data['unit'];
                    $Product_long_description = $value_data['Product_long_description'];   
                    $Product_long_description_format = substr($Product_long_description,0,220); 
                       
                      $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            <tr>
                                
                                <td style="font-size: 9px; width:80%; text-indent:1em;">'.strip_tags($Product_name).' : '.strip_tags($Product_id).'<br>&nbsp;'.strip_tags($Product_long_description).'</td>
                                <td style="font-size: 7.5px; width: 10%; text-indent:1em;">'.strip_tags($Work_order_qty).'<br>&nbsp;&nbsp;'.strip_tags($unit).'</td>

                                <td style="font-size: 7.5px; width: 10%; text-indent:1em;">'.strip_tags($Expected_delivery_date_product).'</td>
                            </tr>

                            
                        </table>';
                        
                }
                
                $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            

                            <tr>
                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>WO Issued By :</b> '.strip_tags($Issued_by).'</td>


                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>Issued To : </b>'.strip_tags($Issued_to).'</td>

                              
                             </tr>

                            
                            
                            
                        </table>';        

        $pdf->writeHTML($html, true, false, true, false, '');


        
        }








        if($data_workorder_product_count ===4)
        {

        $html = '<h2 style="text-align: center;">Tradeorder</h2>
        <table border="0.3" cellpadding="3" width="100%">
                            <tr style="background-color: #C0C0C0;">
                              <td style="font-size: 7.5px; width: 20%; text-indent:2em; line-height: 0.5;"><br><br><b>WO No :</b> '.strip_tags($Work_order_no).'<br></td>

                              <td style="font-size: 7.5px; width: 28%; text-indent:2em; line-height: 0.5;"><br><br><b>SO.No : </b>'.strip_tags($Sales_order_no).'</td>

                              <td style="font-size: 7.5px; width: 18%; text-indent:2em; line-height: 0.5;"><br><br><b>WO Date : </b>'.strip_tags($Work_order_datess).'</td>

                              <td style="font-size: 7.5px; width: 34%; text-indent:2em; line-height: 0.5;"><br><br><b>Department : </b> Production / Sales / Store</td>
                            </tr>


                             <tr>
                              

                              

                              <td style="font-size: 7.5px; width: 80%; text-indent:2em;"><b>Product / Product Code /Specification/ </b></td>

                              <td style="font-size: 7.5px; width: 10%; text-indent:2em;"><b>Qty <br>&nbsp;&nbsp;UOM</b></td>

                              <td style="font-size: 7.5px; width: 10%; text-indent:2em;"><b>Del. <br>&nbsp;&nbsp;Date</b></td>

                              
                              
                             </tr>

                             
                        </table>';


        
         // reset pointer to the last page
        

                foreach ($data__product as $value_data) 
                {
                    $Entity_id = $value_data['Entity_id'];
                    $Work_order_id = $value_data['Work_order_id'];
                    $Product_id = $value_data['Product_id'];
                    $Work_order_qty = $value_data['Work_order_qty']; 
                    $Dispatch_qty = $value_data['Dispatch_qty']; 
                    $Sales_comment = $value_data['Sales_comment'];   
                    $Factory_comment = $value_data['Factory_comment'];   
                    $Expected_delivery_date = $value_data['Expected_delivery_date_product'];
                    $Expected_delivery_date_product = date("d-m-Y",strtotime($Expected_delivery_date));  
                    $Product_id = $value_data['Product_id']; 

                    $Product_name = $value_data['Product_name'];
                    $unit = $value_data['unit']; 
                    $Product_long_description = $value_data['Product_long_description'];   
                    $Product_long_description_format = substr($Product_long_description,0,220); 
                       
                      $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            <tr>
                                
                                <td style="font-size: 9px; width:80%; text-indent:1em;">'.strip_tags($Product_name).' : '.strip_tags($Product_id).'<br>&nbsp;'.strip_tags($Product_long_description).'</td>
                                <td style="font-size: 7.5px; width: 10%; text-indent:1em;">'.strip_tags($Work_order_qty).'<br>&nbsp;&nbsp;'.strip_tags($unit).'</td>

                                <td style="font-size: 7.5px; width: 10%; text-indent:1em;">'.strip_tags($Expected_delivery_date_product).'</td>
                            </tr>

                            
                        </table>';
                        
                }
                
                $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            

                            <tr>
                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>WO Issued By :</b> '.strip_tags($Issued_by).'</td>


                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>Issued To : </b>'.strip_tags($Issued_to).'</td>

                              
                             </tr>

                            
                            
                            
                        </table>';        

        $pdf->writeHTML($html, true, false, true, false, '');


        
        }





        if($data_workorder_product_count ===5)
        {

        $html = '<h2 style="text-align: center;">Tradeorder</h2>
        <table border="0.3" cellpadding="3" width="100%">
                            <tr style="background-color: #C0C0C0;">
                              <td style="font-size: 7.5px; width: 20%; text-indent:2em; line-height: 0.5;"><br><br><b>WO No :</b> '.strip_tags($Work_order_no).'<br></td>

                              <td style="font-size: 7.5px; width: 28%; text-indent:2em; line-height: 0.5;"><br><br><b>SO.No : </b>'.strip_tags($Sales_order_no).'</td>

                              <td style="font-size: 7.5px; width: 18%; text-indent:2em; line-height: 0.5;"><br><br><b>WO Date : </b>'.strip_tags($Work_order_datess).'</td>

                              <td style="font-size: 7.5px; width: 34%; text-indent:2em; line-height: 0.5;"><br><br><b>Department : </b> Production / Sales / Store</td>
                            </tr>


                             <tr>
                              

                              

                              <td style="font-size: 7.5px; width: 80%; text-indent:2em;"><b>Product / Product Code /Specification/ </b></td>

                              <td style="font-size: 7.5px; width: 10%; text-indent:2em;"><b>Qty <br>&nbsp;&nbsp;UOM</b></td>

                              <td style="font-size: 7.5px; width: 10%; text-indent:2em;"><b>Del. <br>&nbsp;&nbsp;Date</b></td>

                              
                              
                             </tr>

                             
                        </table>';


        
         // reset pointer to the last page
        

                foreach ($data__product as $value_data) 
                {
                    $Entity_id = $value_data['Entity_id'];
                    $Work_order_id = $value_data['Work_order_id'];
                    $Product_id = $value_data['Product_id'];
                    $Work_order_qty = $value_data['Work_order_qty']; 
                    $Dispatch_qty = $value_data['Dispatch_qty']; 
                    $Sales_comment = $value_data['Sales_comment'];   
                    $Factory_comment = $value_data['Factory_comment'];   
                    $Expected_delivery_date = $value_data['Expected_delivery_date_product'];
                    $Expected_delivery_date_product = date("d-m-Y",strtotime($Expected_delivery_date));  
                    $Product_id = $value_data['Product_id']; 

                    $Product_name = $value_data['Product_name']; 
                    $unit = $value_data['unit'];
                    $Product_long_description = $value_data['Product_long_description'];   
                    $Product_long_description_format = substr($Product_long_description,0,220); 
                       
                      $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            <tr>
                                
                                <td style="font-size: 9px; width:80%; text-indent:1em;">'.strip_tags($Product_name).' : '.strip_tags($Product_id).'<br>&nbsp;'.strip_tags($Product_long_description).'</td>
                                <td style="font-size: 7.5px; width: 10%; text-indent:1em;">'.strip_tags($Work_order_qty).'<br>&nbsp;&nbsp;'.strip_tags($unit).'</td>

                                <td style="font-size: 7.5px; width: 10%; text-indent:1em;">'.strip_tags($Expected_delivery_date_product).'</td>
                            </tr>

                            
                        </table>';
                        
                }
                
                $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            

                            <tr>
                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>WO Issued By :</b> '.strip_tags($Issued_by).'</td>


                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>Issued To : </b>'.strip_tags($Issued_to).'</td>

                              
                             </tr>

                            
                            
                            
                        </table>';        

        $pdf->writeHTML($html, true, false, true, false, '');


        
        }




        if($data_workorder_product_count >=6)
        {

        $html = '<h2 style="text-align: center;">Tradeorder</h2>
        <table border="0.3" cellpadding="3" width="100%">
                            <tr style="background-color: #C0C0C0;">
                              <td style="font-size: 7.5px; width: 20%; text-indent:2em; line-height: 0.5;"><br><br><b>WO No :</b> '.strip_tags($Work_order_no).'<br></td>

                              <td style="font-size: 7.5px; width: 28%; text-indent:2em; line-height: 0.5;"><br><br><b>SO.No : </b>'.strip_tags($Sales_order_no).'</td>

                              <td style="font-size: 7.5px; width: 18%; text-indent:2em; line-height: 0.5;"><br><br><b>WO Date : </b>'.strip_tags($Work_order_datess).'</td>

                              <td style="font-size: 7.5px; width: 34%; text-indent:2em; line-height: 0.5;"><br><br><b>Department : </b> Production / Sales / Store</td>
                            </tr>


                             <tr>
                              

                              

                              <td style="font-size: 7.5px; width: 80%; text-indent:2em;"><b>Product / Product Code /Specification/ </b></td>

                              <td style="font-size: 7.5px; width: 10%; text-indent:2em;"><b>Qty <br>&nbsp;&nbsp;UOM</b></td>

                              <td style="font-size: 7.5px; width: 10%; text-indent:2em;"><b>Del. <br>&nbsp;&nbsp;Date</b></td>

                              
                              
                             </tr>

                             
                        </table>';


        
         // reset pointer to the last page
        

                foreach ($data__product as $value_data) 
                {
                    $Entity_id = $value_data['Entity_id'];
                    $Work_order_id = $value_data['Work_order_id'];
                    $Product_id = $value_data['Product_id'];
                    $Work_order_qty = $value_data['Work_order_qty']; 
                    $Dispatch_qty = $value_data['Dispatch_qty']; 
                    $Sales_comment = $value_data['Sales_comment'];   
                    $Factory_comment = $value_data['Factory_comment'];   
                    $Expected_delivery_date = $value_data['Expected_delivery_date_product'];
                    $Expected_delivery_date_product = date("d-m-Y",strtotime($Expected_delivery_date));  
                    $Product_id = $value_data['Product_id']; 

                    $Product_name = $value_data['Product_name']; 
                    $unit = $value_data['unit'];
                    $Product_long_description = $value_data['Product_long_description'];   
                    $Product_long_description_format = substr($Product_long_description,0,220); 
                       
                      $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            <tr>
                                
                                <td style="font-size: 9px; width:80%; text-indent:1em;">'.strip_tags($Product_name).' : '.strip_tags($Product_id).'<br>&nbsp;'.strip_tags($Product_long_description).'</td>
                                <td style="font-size: 7.5px; width: 10%; text-indent:1em;">'.strip_tags($Work_order_qty).'<br>&nbsp;&nbsp;'.strip_tags($unit).'</td>

                                <td style="font-size: 7.5px; width: 10%; text-indent:1em;">'.strip_tags($Expected_delivery_date_product).'</td>
                            </tr>

                            
                        </table>';
                        
                }
                
                $html .=  '<br><table border="0.3" cellpadding="3" width="100%">
                            
                            

                            <tr>
                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>WO Issued By :</b> '.strip_tags($Issued_by).'</td>


                              <td style="font-size: 7.5px; width: 50%; text-indent:2em;"><b>Issued To : </b>'.strip_tags($Issued_to).'</td>

                              
                             </tr>

                            
                            
                            
                        </table>';


                $html .=  '<br><table>
                            
                            

                            <tr>
                              <td style="font-size: 8.5px; width: 100%; text-indent:2em;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'.strip_tags($Standard_note).'</b><br><br></td>
                              
                             </tr>

                            
                            
                            
                        </table>';        

        $pdf->writeHTML($html, true, false, true, false, '');


        
        }





            $pdf->lastPage();

            //Close and output PDF document
            $pdf->Output('workorder'.date('Y-m-d-H:i:s').'.pdf', 'I');      
       
    }

    public function update_exp_delivery_date()
    {
        $entity_id = $this->input->post('order_entity_id');
        // print_r($entity_id);
        // die();
        $exp_delivery_date = $this->input->post('exp_delivery_date');

        $update_array = array('entity_id' => $entity_id,'expected_delivery_date' => $exp_delivery_date);
        $where = '(entity_id ="'.$entity_id.'")';
        $this->db->where($where);
        $this->db->update('work_order_master',$update_array);


        $update_array_product_relation = array('work_order_id' => $entity_id,'expected_delivery_date' => $exp_delivery_date);
        $where = '(work_order_id ="'.$entity_id.'")';
        $this->db->where($where);
        $this->db->update('work_order_product_relation',$update_array_product_relation);

        //echo json_encode($data);
    }
}
?>
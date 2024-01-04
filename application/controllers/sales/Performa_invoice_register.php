<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class Performa_invoice_register extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->helper('url');
            $this->load->model('performa_invoice_register_model');
            $this->load->library('session');
        }

        public function index()
        {
            $data['performa_details'] = $this->performa_invoice_register_model->get_all_performa_details();
            $this->load->view('sales/performa_invoice_register/vw_performa_invoice_register_index',$data);
        }

        public function create()
        {
            $data['order_details'] = $this->performa_invoice_register_model->get_all_order_details();
            $this->load->view('sales/performa_invoice_register/vw_select_sales_order_index',$data);
        }

        public function so_to_performa_save()
        {
            $entity_id = $this->uri->segment(2);
            $performa_data = $this->performa_invoice_register_model->so_to_performa_save_model($entity_id);

            $data['customer_list'] = $this->performa_invoice_register_model->get_customer_list();
            /*$data['state_list'] = $this->purchase_order_register_model->get_state_list();*/
            $data['entity_id'] = $entity_id;
            $data['offer_result'] = $performa_data;

            $get_data = $this->performa_invoice_register_model->get_performa_details_by_id_model($entity_id);
            $row = $get_data->row_array(); 

            $data['ship_to_id'] = $row['ship_to_id'];
            $data['ship_to_address_id'] = $row['ship_to_address_id'];
            $data['ship_to_contact_person_id'] = $row['ship_to_contact_person_id'];

            $data['bill_to_id'] = $row['bill_to_id'];
            $data['bill_to_address_id'] = $row['bill_to_address_id'];
            $data['bill_to_contact_person_id'] = $row['bill_to_contact_person_id'];

            $this->load->view('sales/performa_invoice_register/vw_performa_invoice_register_create',$data);
        }

        public function get_performa_details_by_id()
        {
            $entity_id = $this->input->post('entity_id',TRUE);
            $data = $this->performa_invoice_register_model->get_performa_details_by_id_model($entity_id)->result();
            echo json_encode($data);
        }

        public function get_ship_to_address()
        {
            $customer_id = $this->input->post('id',TRUE);
            $data = $this->performa_invoice_register_model->get_ship_to_address_model_data($customer_id);
            echo json_encode($data);
        }

        public function get_ship_to_contact()
        {
            $address_id = $this->input->post('id',TRUE);
            $data = $this->performa_invoice_register_model->get_ship_to_contact_model_data($address_id);
            echo json_encode($data);
        }

        public function get_bill_to_address()
        {
            $customer_id = $this->input->post('id',TRUE);
            $data = $this->performa_invoice_register_model->get_bill_to_address_model_data($customer_id);
            echo json_encode($data);
        }

        public function get_bill_to_contact()
        {
            $address_id = $this->input->post('id',TRUE);
            $data = $this->performa_invoice_register_model->get_bill_to_contact_model_data($address_id);
            echo json_encode($data);
        }

        public function update_ship_to_company_name_edit_page()
        {
            $order_entity_id = $this->input->post('order_entity_id');
            $ship_to_company_id = $this->input->post('ship_to_company_id');

            $this->db->select('*');
            $this->db->from('customer_master');
            $where = '(customer_master.entity_id = "'.$ship_to_company_id.'" )';
            $this->db->where($where);
            $customer_master_data = $this->db->get();
            $customer_master_query_result = $customer_master_data->row_array();

            $Company_name = $customer_master_query_result['customer_name'];

            $update_order_array = array('ship_to_id' => $ship_to_company_id , 'ship_to_name' => $Company_name , 'ship_to_address_id' => NULL , 'ship_to_address' => NULL , 'ship_to_gst_no' => NULL , 'ship_to_contact_person_id' => NULL , 'ship_to_contact_person' => NULL , 'ship_to_contact_person_number' => NULL , 'ship_to_contact_person_mail_id' => NULL);

            $this->db->select('*');
            $this->db->from('performa_register');
            $where = '(performa_register.sales_order_id = "'.$order_entity_id.'" )';
            $this->db->where($where);
            $this->db->order_by('performa_register.entity_id', 'DESC');
            $this->db->limit(1);
            $query_data = $this->db->get();
            $query_result = $query_data->row_array();

            $performa_entity_id = $query_result['entity_id'];

            $where = '(entity_id ="'.$performa_entity_id.'")';
            $this->db->where($where);
            $this->db->update('performa_register',$update_order_array);
        }

        public function update_ship_to_address_edit_page()
        {
            $order_entity_id = $this->input->post('order_entity_id');
            $ship_to_address_id = $this->input->post('ship_to_address_id');

            $this->db->select('customer_address_master.*,state_master.state_name,city_master.city_name');
            $this->db->from('customer_address_master');
            $where = '(customer_address_master.entity_id = "'.$ship_to_address_id.'")';
            $this->db->join('state_master', 'customer_address_master.state_id = state_master.entity_id', 'INNER');
            $this->db->join('city_master', 'customer_address_master.city_id = city_master.entity_id', 'INNER');
            $this->db->where($where);
            $ship_to_address = $this->db->get();
            $ship_to_address_data =  $ship_to_address->row();

            $ship_to_address_id = $ship_to_address_data->entity_id;
            $ship_to_address = $ship_to_address_data->address;
            $ship_to_state_name = $ship_to_address_data->state_name;
            $ship_to_city_name = $ship_to_address_data->city_name;
            $ship_to_pin_code = $ship_to_address_data->pin_code;
            $ship_to_state_code = $ship_to_address_data->state_code;
            $ship_to_gst_no = $ship_to_address_data->gst_no;
            $ship_to_pan_no = $ship_to_address_data->pan_no;

            $new_ship_to_address = $ship_to_address.'  '.$ship_to_state_name.' , '.$ship_to_city_name.' , '.$ship_to_pin_code;

            $update_order_array = array('ship_to_address_id' => $ship_to_address_id , 'ship_to_address' => $new_ship_to_address , 'ship_to_gst_no' => $ship_to_gst_no , 'ship_to_contact_person_id' => NULL , 'ship_to_contact_person' => NULL , 'ship_to_contact_person_number' => NULL , 'ship_to_contact_person_mail_id' => NULL);

            $this->db->select('*');
            $this->db->from('performa_register');
            $where = '(performa_register.sales_order_id = "'.$order_entity_id.'" )';
            $this->db->where($where);
            $this->db->order_by('performa_register.entity_id', 'DESC');
            $this->db->limit(1);
            $query_data = $this->db->get();
            $query_result = $query_data->row_array();

            $performa_entity_id = $query_result['entity_id'];

            $where = '(entity_id ="'.$performa_entity_id.'")';
            $this->db->where($where);
            $this->db->update('performa_register',$update_order_array);
        }

        public function update_ship_to_contact_person_edit_page()
        {
            $order_entity_id = $this->input->post('order_entity_id');
            $ship_to_contact_id = $this->input->post('ship_to_contact_id');

            $this->db->select('*');
            $this->db->from('customer_contact_master');
            $where = '(entity_id = "'.$ship_to_contact_id.'")';
            $this->db->where($where);
            $ship_to_contact = $this->db->get();
            $ship_to_contact_data =  $ship_to_contact->row();

            $ship_to_contact_person = $ship_to_contact_data->contact_person;
            $ship_to_email_id = $ship_to_contact_data->email_id;
            $ship_to_first_contact_no = $ship_to_contact_data->first_contact_no;

            $update_order_array = array('ship_to_contact_person_id' => $ship_to_contact_id , 'ship_to_contact_person' => $ship_to_contact_person , 'ship_to_contact_person_number' => $ship_to_first_contact_no , 'ship_to_contact_person_mail_id' => $ship_to_email_id);

            $this->db->select('*');
            $this->db->from('performa_register');
            $where = '(performa_register.sales_order_id = "'.$order_entity_id.'" )';
            $this->db->where($where);
            $this->db->order_by('performa_register.entity_id', 'DESC');
            $this->db->limit(1);
            $query_data = $this->db->get();
            $query_result = $query_data->row_array();

            $performa_entity_id = $query_result['entity_id'];

            $where = '(entity_id ="'.$performa_entity_id.'")';
            $this->db->where($where);
            $this->db->update('performa_register',$update_order_array);
        }

        public function update_ship_to_email_edit_page()
        {
            $order_entity_id = $this->input->post('order_entity_id');
            $email_id = $this->input->post('ship_to_email_id');

            $update_order_array = array('ship_to_contact_person_mail_id' => $email_id);

            $this->db->select('*');
            $this->db->from('performa_register');
            $where = '(performa_register.sales_order_id = "'.$order_entity_id.'" )';
            $this->db->where($where);
            $this->db->order_by('performa_register.entity_id', 'DESC');
            $this->db->limit(1);
            $query_data = $this->db->get();
            $query_result = $query_data->row_array();

            $performa_entity_id = $query_result['entity_id'];

            $where = '(entity_id ="'.$performa_entity_id.'")';
            $this->db->where($where);
            $this->db->update('performa_register',$update_order_array);
        }

        public function update_ship_to_contact_number_edit_page()
        {
            $order_entity_id = $this->input->post('order_entity_id');
            $ship_to_contact_number = $this->input->post('ship_to_contact_number');

            $update_order_array = array('ship_to_contact_person_number' => $ship_to_contact_number);

            $this->db->select('*');
            $this->db->from('performa_register');
            $where = '(performa_register.sales_order_id = "'.$order_entity_id.'" )';
            $this->db->where($where);
            $this->db->order_by('performa_register.entity_id', 'DESC');
            $this->db->limit(1);
            $query_data = $this->db->get();
            $query_result = $query_data->row_array();

            $performa_entity_id = $query_result['entity_id'];

            $where = '(entity_id ="'.$performa_entity_id.'")';
            $this->db->where($where);
            $this->db->update('performa_register',$update_order_array);
        }

        public function update_ship_to_gst_number_edit_page()
        {
            $order_entity_id = $this->input->post('order_entity_id');
            $ship_to_gst_number = $this->input->post('ship_to_gst_number');

            $update_order_array = array('ship_to_gst_no' => $ship_to_gst_number);

            $this->db->select('*');
            $this->db->from('performa_register');
            $where = '(performa_register.sales_order_id = "'.$order_entity_id.'" )';
            $this->db->where($where);
            $this->db->order_by('performa_register.entity_id', 'DESC');
            $this->db->limit(1);
            $query_data = $this->db->get();
            $query_result = $query_data->row_array();

            $performa_entity_id = $query_result['entity_id'];

            $where = '(entity_id ="'.$performa_entity_id.'")';
            $this->db->where($where);
            $this->db->update('performa_register',$update_order_array);
        }

        public function update_bill_to_company_name_edit_page()
        {
            $order_entity_id = $this->input->post('order_entity_id');
            $bill_to_company_id = $this->input->post('bill_to_company_id');

            $this->db->select('*');
            $this->db->from('customer_master');
            $where = '(customer_master.entity_id = "'.$bill_to_company_id.'" )';
            $this->db->where($where);
            $customer_master_data = $this->db->get();
            $customer_master_query_result = $customer_master_data->row_array();

            $Company_name = $customer_master_query_result['customer_name'];

            $update_order_array = array('bill_to_id' => $bill_to_company_id , 'bill_to_name' => $Company_name , 'bill_to_address_id' => NULL , 'bill_to_address' => NULL , 'bill_to_gst_no' => NULL , 'bill_to_contact_person_id' => NULL , 'bill_to_contact_person' => NULL , 'bill_to_contact_person_number' => NULL , 'bill_to_contact_person_mail_id' => NULL);

            $this->db->select('*');
            $this->db->from('performa_register');
            $where = '(performa_register.sales_order_id = "'.$order_entity_id.'" )';
            $this->db->where($where);
            $this->db->order_by('performa_register.entity_id', 'DESC');
            $this->db->limit(1);
            $query_data = $this->db->get();
            $query_result = $query_data->row_array();

            $performa_entity_id = $query_result['entity_id'];

            $where = '(entity_id ="'.$performa_entity_id.'")';
            $this->db->where($where);
            $this->db->update('performa_register',$update_order_array);
        }

        public function update_bill_to_address_edit_page()
        {
            $order_entity_id = $this->input->post('order_entity_id');
            $bill_to_address_id = $this->input->post('bill_to_address_id');

            $this->db->select('customer_address_master.*,state_master.state_name,city_master.city_name');
            $this->db->from('customer_address_master');
            $where = '(customer_address_master.entity_id = "'.$bill_to_address_id.'")';
            $this->db->join('state_master', 'customer_address_master.state_id = state_master.entity_id', 'INNER');
            $this->db->join('city_master', 'customer_address_master.city_id = city_master.entity_id', 'INNER');
            $this->db->where($where);
            $bill_to_address = $this->db->get();
            $bill_to_address_data =  $bill_to_address->row();

            $bill_to_address_id = $bill_to_address_data->entity_id;
            $bill_to_address = $bill_to_address_data->address;
            $bill_to_state_name = $bill_to_address_data->state_name;
            $bill_to_city_name = $bill_to_address_data->city_name;
            $bill_to_pin_code = $bill_to_address_data->pin_code;
            $bill_to_state_code = $bill_to_address_data->state_code;
            $bill_to_gst_no = $bill_to_address_data->gst_no;
            $bill_to_pan_no = $bill_to_address_data->pan_no;

            $new_bill_to_address = $bill_to_address.'  '.$bill_to_state_name.' , '.$bill_to_city_name.' , '.$bill_to_pin_code;

            $update_order_array = array('bill_to_address_id' => $bill_to_address_id , 'bill_to_address' => $new_bill_to_address , 'bill_to_gst_no' => $bill_to_gst_no , 'bill_to_contact_person_id' => NULL , 'bill_to_contact_person' => NULL , 'bill_to_contact_person_number' => NULL , 'bill_to_contact_person_mail_id' => NULL);

            $this->db->select('*');
            $this->db->from('performa_register');
            $where = '(performa_register.sales_order_id = "'.$order_entity_id.'" )';
            $this->db->where($where);
            $this->db->order_by('performa_register.entity_id', 'DESC');
            $this->db->limit(1);
            $query_data = $this->db->get();
            $query_result = $query_data->row_array();

            $performa_entity_id = $query_result['entity_id'];

            $where = '(entity_id ="'.$performa_entity_id.'")';
            $this->db->where($where);
            $this->db->update('performa_register',$update_order_array);
        }

        public function update_bill_to_contact_person_edit_page()
        {
            $order_entity_id = $this->input->post('order_entity_id');
            $bill_to_contact_id = $this->input->post('bill_to_contact_id');

            $this->db->select('*');
            $this->db->from('customer_contact_master');
            $where = '(entity_id = "'.$bill_to_contact_id.'")';
            $this->db->where($where);
            $bill_to_contact = $this->db->get();
            $bill_to_contact_data =  $bill_to_contact->row();

            $bill_to_contact_person = $bill_to_contact_data->contact_person;
            $bill_to_email_id = $bill_to_contact_data->email_id;
            $bill_to_first_contact_no = $bill_to_contact_data->first_contact_no;

            $update_order_array = array('bill_to_contact_person_id' => $bill_to_contact_id , 'bill_to_contact_person' => $bill_to_contact_person , 'bill_to_contact_person_number' => $bill_to_first_contact_no , 'bill_to_contact_person_mail_id' => $bill_to_email_id);

            $this->db->select('*');
            $this->db->from('performa_register');
            $where = '(performa_register.sales_order_id = "'.$order_entity_id.'" )';
            $this->db->where($where);
            $this->db->order_by('performa_register.entity_id', 'DESC');
            $this->db->limit(1);
            $query_data = $this->db->get();
            $query_result = $query_data->row_array();

            $performa_entity_id = $query_result['entity_id'];

            $where = '(entity_id ="'.$performa_entity_id.'")';
            $this->db->where($where);
            $this->db->update('performa_register',$update_order_array);
        }

        public function update_bill_to_email_edit_page()
        {
            $order_entity_id = $this->input->post('order_entity_id');
            $email_id = $this->input->post('bill_to_email_id');

            $update_order_array = array('bill_to_contact_person_mail_id' => $email_id);

            $this->db->select('*');
            $this->db->from('performa_register');
            $where = '(performa_register.sales_order_id = "'.$order_entity_id.'" )';
            $this->db->where($where);
            $this->db->order_by('performa_register.entity_id', 'DESC');
            $this->db->limit(1);
            $query_data = $this->db->get();
            $query_result = $query_data->row_array();

            $performa_entity_id = $query_result['entity_id'];

            $where = '(entity_id ="'.$performa_entity_id.'")';
            $this->db->where($where);
            $this->db->update('performa_register',$update_order_array);
        }

        public function update_bill_to_contact_number_edit_page()
        {
            $order_entity_id = $this->input->post('order_entity_id');
            $bill_to_contact_number = $this->input->post('bill_to_contact_number');

            $update_order_array = array('ship_to_contact_person_number' => $bill_to_contact_number);

            $this->db->select('*');
            $this->db->from('performa_register');
            $where = '(performa_register.sales_order_id = "'.$order_entity_id.'" )';
            $this->db->where($where);
            $this->db->order_by('performa_register.entity_id', 'DESC');
            $this->db->limit(1);
            $query_data = $this->db->get();
            $query_result = $query_data->row_array();

            $performa_entity_id = $query_result['entity_id'];

            $where = '(entity_id ="'.$performa_entity_id.'")';
            $this->db->where($where);
            $this->db->update('performa_register',$update_order_array);
        }

        public function update_bill_to_gst_number_edit_page()
        {
            $order_entity_id = $this->input->post('order_entity_id');
            $bill_to_gst_number = $this->input->post('bill_to_gst_number');

            $update_order_array = array('bill_to_gst_no' => $bill_to_gst_number);

            $this->db->select('*');
            $this->db->from('performa_register');
            $where = '(performa_register.sales_order_id = "'.$order_entity_id.'" )';
            $this->db->where($where);
            $this->db->order_by('performa_register.entity_id', 'DESC');
            $this->db->limit(1);
            $query_data = $this->db->get();
            $query_result = $query_data->row_array();

            $performa_entity_id = $query_result['entity_id'];

            $where = '(entity_id ="'.$performa_entity_id.'")';
            $this->db->where($where);
            $this->db->update('performa_register',$update_order_array);
        }

        public function save_performa_invoice()
        {
            $order_entity_id = $this->input->post('order_entity_id');

            $this->db->select('*');
            $this->db->from('performa_register');
            $where = '(performa_register.sales_order_id = "'.$order_entity_id.'" )';
            $this->db->where($where);
            $this->db->order_by('performa_register.entity_id', 'DESC');
            $this->db->limit(1);
            $query_data = $this->db->get();
            $query_result = $query_data->row_array();

            $performa_entity_id = $query_result['entity_id'];

            redirect('second_performa_edit_page'.'/'.$performa_entity_id); 
        }

        public function second_performa_edit_page()
        {
            $entity_id = $this->uri->segment(2);

            /*$data['employee_list'] = $this->purchase_order_register_model->get_employee_list();*/
            
            /*$data['product_category'] = $this->purchase_order_register_model->get_product_category();
            $data['product_detail_hsn_code'] = $this->purchase_order_register_model->get_product_hsn_code();
            $data['product_list'] = $this->purchase_order_register_model->get_product_list();*/
            $data['order_product_list'] = $this->performa_invoice_register_model->get_order_product_list($entity_id);
            $data['entity_id'] = $entity_id;

            $this->load->view('sales/performa_invoice_register/vw_performa_invoice_register_second_create',$data);
        }

        public function get_second_page_performa_invoice_details_by_id()
        {
            $entity_id = $this->input->post('entity_id',TRUE);

            $data = $this->performa_invoice_register_model->get_second_page_performa_invoice_details_by_id_model($entity_id)->result();
            echo json_encode($data);
        }

        public function update_product_description()
        {
            $entity_id = $this->input->post('order_relation_entity_id');
            $product_desc = $this->input->post('product_desc');

            $update_array = array('entity_id' => $entity_id,'sales_order_product_description' => $product_desc);
            $data = $this->performa_invoice_register_model->update_order_product_relation($update_array);

            echo json_encode($data);
        }

        public function update_product_price()
        {
            $entity_id = $this->input->post('order_relation_entity_id');
            $price = $this->input->post('price');

            $this->db->select('*');
            $this->db->from('performa_product_relation');
            $where = '(performa_product_relation.entity_id = "'.$entity_id.'")';
            $this->db->where($where);
            $order_product_relation = $this->db->get();
            $order_product_relation_result = $order_product_relation->row();

            $product_qty = $order_product_relation_result->qty;
            $product_basic_value = $product_qty * $price;

            $product_discount = $order_product_relation_result->discount_percentage;

            $product_discounted_amount = $product_basic_value * $product_discount/100;

            $total_without_gst = $product_basic_value - $product_discounted_amount;

            $unit_discounted_price = $total_without_gst/$product_qty;

            $cgst_percentage = $order_product_relation_result->cgst_percentage;
            $sgst_percentage = $order_product_relation_result->sgst_percentage;
            $igst_percentage = $order_product_relation_result->igst_percentage;

            $cgst_amount = $total_without_gst * $cgst_percentage/100;
            $sgst_amount = $total_without_gst * $sgst_percentage/100;
            $igst_amount = $total_without_gst * $igst_percentage/100;

            $total_amount = $total_without_gst + $cgst_amount + $sgst_amount + $igst_amount;

            $update_array = array('entity_id' => $entity_id , 'sales_order_price' => $price , 'discount_amount' => $product_discounted_amount , 'unit_discount_price' => $unit_discounted_price , 'total_amount_without_gst' => $total_without_gst , 'cgst_amount' => $cgst_amount , 'sgst_amount' => $sgst_amount , 'igst_amount' => $igst_amount , 'total_amount_with_gst' => $total_amount);
            $data = $this->performa_invoice_register_model->update_order_product_relation($update_array);

            echo json_encode($data);
        }

        public function update_product_qty()
        {
            $entity_id = $this->input->post('order_relation_entity_id');
            $product_qty = $this->input->post('product_qty');

            $this->db->select('*');
            $this->db->from('performa_product_relation');
            $where = '(performa_product_relation.entity_id = "'.$entity_id.'")';
            $this->db->where($where);
            $order_product_relation = $this->db->get();
            $order_product_relation_result = $order_product_relation->row();

            $product_price = $order_product_relation_result->sales_order_price;
            $product_basic_value = $product_qty * $product_price;

            $product_discount = $order_product_relation_result->discount_percentage;

            $product_discounted_amount = $product_basic_value * $product_discount/100;

            $total_without_gst = $product_basic_value - $product_discounted_amount;

            $unit_discounted_price = $total_without_gst/$product_qty;

            $cgst_percentage = $order_product_relation_result->cgst_percentage;
            $sgst_percentage = $order_product_relation_result->sgst_percentage;
            $igst_percentage = $order_product_relation_result->igst_percentage;

            $cgst_amount = $total_without_gst * $cgst_percentage/100;
            $sgst_amount = $total_without_gst * $sgst_percentage/100;
            $igst_amount = $total_without_gst * $igst_percentage/100;

            $total_amount = $total_without_gst + $cgst_amount + $sgst_amount + $igst_amount;

            $update_array = array('entity_id' => $entity_id , 'qty' => $product_qty , 'discount_amount' => $product_discounted_amount , 'unit_discount_price' => $unit_discounted_price , 'total_amount_without_gst' => $total_without_gst , 'cgst_amount' => $cgst_amount , 'sgst_amount' => $sgst_amount , 'igst_amount' => $igst_amount , 'total_amount_with_gst' => $total_amount);
            $data = $this->performa_invoice_register_model->update_order_product_relation($update_array);

            echo json_encode($data);
        }

        public function update_product_discount_percentage()
        {
            $entity_id = $this->input->post('order_relation_entity_id');
            $discount_percentage = $this->input->post('discount_percentage');

           $this->db->select('*');
            $this->db->from('performa_product_relation');
            $where = '(performa_product_relation.entity_id = "'.$entity_id.'")';
            $this->db->where($where);
            $order_product_relation = $this->db->get();
            $order_product_relation_result = $order_product_relation->row();

            $product_price = $order_product_relation_result->sales_order_price;
            $product_qty = $order_product_relation_result->qty;

            $product_basic_value = $product_qty * $product_price;

            $product_discounted_amount = $product_basic_value * $discount_percentage/100;

            $total_without_gst = $product_basic_value - $product_discounted_amount;

            $unit_discounted_price = $total_without_gst/$product_qty;

            $cgst_percentage = $order_product_relation_result->cgst_percentage;
            $sgst_percentage = $order_product_relation_result->sgst_percentage;
            $igst_percentage = $order_product_relation_result->igst_percentage;

            $cgst_amount = $total_without_gst * $cgst_percentage/100;
            $sgst_amount = $total_without_gst * $sgst_percentage/100;
            $igst_amount = $total_without_gst * $igst_percentage/100;

            $total_amount = $total_without_gst + $cgst_amount + $sgst_amount + $igst_amount;

            $update_array = array('entity_id' => $entity_id , 'discount_percentage' => $discount_percentage , 'discount_amount' => $product_discounted_amount , 'unit_discount_price' => $unit_discounted_price , 'total_amount_without_gst' => $total_without_gst , 'cgst_amount' => $cgst_amount , 'sgst_amount' => $sgst_amount , 'igst_amount' => $igst_amount , 'total_amount_with_gst' => $total_amount);
            $data = $this->performa_invoice_register_model->update_order_product_relation($update_array);

            echo json_encode($data);
        }

        public function save_second_page_performa_invoice()
        {
            $entity_id = $this->input->post('pi_entity_id');

            $this->db->select('*');
            $this->db->from('performa_register');
            $where = '(performa_register.entity_id = "'.$entity_id.'")';
            $this->db->where($where);
            $performa_register = $this->db->get();
            $performa_register_data =  $performa_register->row();

            $Sales_order_id = $performa_register_data->sales_order_id;

            /*$order_descrption = $this->input->post('order_descrption');
            $employee_id = $this->input->post('employee_id');
            $order_terms_condition = $this->input->post('order_terms_condition');
            $delivery_period = $this->input->post('delivery_period');
            $order_freight = $this->input->post('order_freight');
            $freight_charges = $this->input->post('freight_charges');
            $dispatch_address = $this->input->post('dispatch_address');
            $delivery_instruction = $this->input->post('delivery_instruction');
            $order_pf = $this->input->post('order_pf');
            $packing_forwarding_charges = $this->input->post('packing_forwarding_charges');
            $payment_term = $this->input->post('payment_term');
            $special_instruction = $this->input->post('special_instruction');
            $order_insurance = $this->input->post('order_insurance');
            $insurance_charges = $this->input->post('insurance_charges');

            $salutation = $this->input->post('salutation');
            $price_basis = $this->input->post('price_basis');
            $transport_insurance = $this->input->post('transport_insurance');
            $tax = $this->input->post('tax');
            $delivery_schedule = $this->input->post('delivery_schedule');
            $mode_of_payment = $this->input->post('mode_of_payment');
            $mode_of_transport = $this->input->post('mode_of_transport');
            $guarantee_warrenty = $this->input->post('guarantee_warrenty');
            $payment_term = $this->input->post('payment_term');
            $packing_forwarding = $this->input->post('packing_forwarding');
            $special_customer = $this->input->post('special_customer');*/

            $this->db->select_sum('sales_order_price');
            $this->db->from('performa_product_relation');
            $where = '(performa_invoice_id = "'.$entity_id.'")';
            $this->db->where($where);
            $sales_order_price = $this->db->get();
            $sales_order_price_sum =  $sales_order_price->row();

            $Sales_order_price = $sales_order_price_sum->sales_order_price;

            $this->db->select_sum('unit_discount_price');
            $this->db->from('performa_product_relation');
            $where = '(performa_invoice_id = "'.$entity_id.'")';
            $this->db->where($where);
            $unit_discount_price = $this->db->get();
            $unit_discount_price_sum =  $unit_discount_price->row();

            $Unit_discounted_price = $unit_discount_price_sum->unit_discount_price;

            $this->db->select_sum('discount_amount');
            $this->db->from('performa_product_relation');
            $where = '(performa_invoice_id = "'.$entity_id.'")';
            $this->db->where($where);
            $discount_amount = $this->db->get();
            $discount_amt_sum =  $discount_amount->row();

            $Discount_amt = $discount_amt_sum->discount_amount;

            $Basic_amount = $Unit_discounted_price + $Discount_amt;

            $this->db->select_sum('total_amount_without_gst');
            $this->db->from('performa_product_relation');
            $where = '(performa_invoice_id = "'.$entity_id.'")';
            $this->db->where($where);
            $total_amount_without_gst = $this->db->get();
            $total_amount_without_gst_sum =  $total_amount_without_gst->row();

            $Total_amount_without_gst = $total_amount_without_gst_sum->total_amount_without_gst;

            $this->db->select_sum('cgst_amount');
            $this->db->from('performa_product_relation');
            $where = '(performa_invoice_id = "'.$entity_id.'")';
            $this->db->where($where);
            $cgst_amount = $this->db->get();
            $cgst_amount_sum =  $cgst_amount->row();

            $Cgst_amount = $cgst_amount_sum->cgst_amount;

            $this->db->select_sum('sgst_amount');
            $this->db->from('performa_product_relation');
            $where = '(performa_invoice_id = "'.$entity_id.'")';
            $this->db->where($where);
            $sgst_amount = $this->db->get();
            $sgst_amount_sum =  $sgst_amount->row();

            $Sgst_amount = $sgst_amount_sum->sgst_amount;

            $this->db->select_sum('igst_amount');
            $this->db->from('performa_product_relation');
            $where = '(performa_invoice_id = "'.$entity_id.'")';
            $this->db->where($where);
            $igst_amount = $this->db->get();
            $igst_amount_sum =  $igst_amount->row();

            $Igst_amount = $igst_amount_sum->igst_amount;

            $this->db->select_sum('total_amount_with_gst');
            $this->db->from('performa_product_relation');
            $where = '(performa_invoice_id = "'.$entity_id.'")';
            $this->db->where($where);
            $total_amount_with_gst = $this->db->get();
            $total_amount_with_gst_sum =  $total_amount_with_gst->row();

            $Total_amount_with_gst = $total_amount_with_gst_sum->total_amount_with_gst;

            $update_order_array = array('total_amount' => $Sales_order_price , 'total_discount' => $Discount_amt , 'total_taxable_amount' => $Total_amount_without_gst , 'cgst_amount' => $Cgst_amount , 'sgst_amount' => $Sgst_amount , 'igst_amount' => $Igst_amount , 'final_amount' => $Total_amount_with_gst , 'status' => 2);

            $where = '(entity_id ="'.$entity_id.'")';
            $this->db->where($where);
            $this->db->update('performa_register',$update_order_array);

            $update_sales_order = array('invoice_status' => 2);

            $where = '(entity_id ="'.$Sales_order_id.'")';
            $this->db->where($where);
            $this->db->update('sales_order_register',$update_sales_order);

            redirect('vw_performa_invoice_data'); 
        }

        public function cancel_performa_invoice()
        {
            $entity_id = $this->uri->segment(2);

            $this->db->select('*');
            $this->db->from('performa_register');
            $where = '(performa_register.entity_id = "'.$entity_id.'")';
            $this->db->where($where);
            $performa_register = $this->db->get();
            $performa_register_data =  $performa_register->row();

            $Sales_order_id = $performa_register_data->sales_order_id;

            $update_order_array = array('status' => 3);

            $where = '(entity_id ="'.$entity_id.'")';
            $this->db->where($where);
            $this->db->update('performa_register',$update_order_array);

            $update_sales_order = array('invoice_status' => 1);

            $where = '(entity_id ="'.$Sales_order_id.'")';
            $this->db->where($where);
            $this->db->update('sales_order_register',$update_sales_order);
            
            redirect('vw_performa_invoice_data'); 
        }
    }
?>
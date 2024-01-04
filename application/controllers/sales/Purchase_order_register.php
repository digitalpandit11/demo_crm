<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class Purchase_order_register extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->helper('url');
            $this->load->model('purchase_order_register_model');
            $this->load->library('session');
        }

        public function index()
        {
            $data['order_details'] = $this->purchase_order_register_model->get_all_order_details();
            $this->load->view('sales/purchase_order_register/vw_purchase_order_register_index',$data);
        }

        public function so_to_po_save()
        {
            $entity_id = $this->uri->segment(2);

            $offer_data = $this->purchase_order_register_model->so_to_po_save_model($entity_id);
            $data['vendor_list'] = $this->purchase_order_register_model->get_vendor_list();
            $data['state_list'] = $this->purchase_order_register_model->get_state_list();

            $data['entity_id'] = $entity_id;
            $data['offer_result'] = $offer_data;

            $this->load->view('sales/purchase_order_register/vw_purchase_order_register_create',$data);
        }

        public function save_purchase_order()
        {
            $order_entity_id = $this->input->post('order_entity_id');

            $this->db->select('*');
            $this->db->from('purchase_order_register');
            $where = '(purchase_order_register.sales_order_id = "'.$order_entity_id.'" )';
            $this->db->where($where);
            $this->db->order_by('purchase_order_register.entity_id', 'DESC');
            $this->db->limit(1);
            $query_data = $this->db->get();
            $query_result = $query_data->row_array();

            $purchase_order_entity_id = $query_result['entity_id'];

            redirect('second_po_edit_page'.'/'.$purchase_order_entity_id); 
        }

        public function second_po_edit_page()
        {
            $entity_id = $this->uri->segment(2);

            $data['employee_list'] = $this->purchase_order_register_model->get_employee_list();
            $data['order_product_list'] = $this->purchase_order_register_model->get_order_product_list($entity_id);
            $data['product_category'] = $this->purchase_order_register_model->get_product_category();
            $data['product_detail_hsn_code'] = $this->purchase_order_register_model->get_product_hsn_code();
            $data['product_list'] = $this->purchase_order_register_model->get_product_list();

            $data['entity_id'] = $entity_id;

            $this->load->view('sales/purchase_order_register/vw_purchase_order_register_second_create',$data);
        }

        public function get_purchase_order_details_by_id()
        {
            $entity_id = $this->input->post('entity_id',TRUE);
            $data = $this->purchase_order_register_model->get_purchase_order_details_by_id_model($entity_id)->result();
            echo json_encode($data);
        }

        public function update_vendor_id_edit_page()
        {
            $order_entity_id = $this->input->post('order_entity_id');
            $vendor_id = $this->input->post('vendor_id');

            $this->db->select('*');
            $this->db->from('vendor_master');
            $where = '(vendor_master.entity_id = "'.$vendor_id.'" )';
            $this->db->where($where);
            $vendor_master_data = $this->db->get();
            $vendor_master_result = $vendor_master_data->row_array();

            if(!empty($vendor_master_result))
            {
                $State_code = $vendor_master_result['state_code'];
            }else{
                $State_code = 24;
            }
            
            $update_order_array = array('vendor_id' => $vendor_id);

            $this->db->select('*');
            $this->db->from('purchase_order_register');
            $where = '(purchase_order_register.sales_order_id = "'.$order_entity_id.'" )';
            $this->db->where($where);
            $this->db->order_by('purchase_order_register.entity_id', 'DESC');
            $this->db->limit(1);
            $query_data = $this->db->get();
            $query_result = $query_data->row_array();

            $purchase_order_entity_id = $query_result['entity_id'];

            $where = '(entity_id ="'.$purchase_order_entity_id.'")';
            $this->db->where($where);
            $this->db->update('purchase_order_register',$update_order_array);

            $this->db->select('purchase_order_product_relation.*');
            $this->db->from('purchase_order_product_relation');
            $where = '(purchase_order_product_relation.purchase_order_id = "'.$purchase_order_entity_id.'" )';
            $this->db->where($where);
            $purchase_order_product_relation = $this->db->get();
            $purchase_order_product_relation_result = $purchase_order_product_relation->result_array();

            foreach ($purchase_order_product_relation_result as $key => $value) 
            {
                $order_realtion_id = $value['entity_id'];

                $price = $value['price'];
                $qty = $value['rfq_qty'];
                $base_price = $price * $qty;
                $discount = 0;
                $discount_amt = 0;
                $unit_discounted_price = $base_price;
                $total_amount_without_gst = $base_price;

                $product_id = $value['product_id'];

                $this->db->select('*');
                $this->db->from('product_master');
                $where = '(product_master.entity_id = "'.$product_id.'" )';
                $this->db->where($where);
                $product_master_data = $this->db->get();
                $product_master_result = $product_master_data->row_array();

                $hsn_id = $product_master_result['hsn_id'];

                $this->db->select('*');
                $this->db->from('product_hsn_master');
                $where = '(product_hsn_master.entity_id = "'.$hsn_id.'" )';
                $this->db->where($where);
                $product_hsn_master_data = $this->db->get();
                $product_hsn_master_result = $product_hsn_master_data->row();

                
                

                if($State_code == 24)
                {
                    $cgst_percentage = $product_hsn_master_result->cgst;
                    $sgst_percentage = $product_hsn_master_result->sgst;
                    $igst_percentage = NULL;

                    $cgst_amount = $total_amount_without_gst * $cgst_percentage/100;
                    $sgst_amount = $total_amount_without_gst * $sgst_percentage/100;
                    $igst_amount = NULL;
                }else{
                    $igst_percentage = $product_hsn_master_result->igst;
                    $sgst_percentage = NULL;
                    $cgst_percentage = NULL;

                    $igst_amount = $total_amount_without_gst * $igst_percentage/100;
                    $sgst_amount = NULL;
                    $cgst_amount = NULL;
                }

                $total_amount = $total_amount_without_gst + $cgst_amount + $sgst_amount + $igst_amount;

                $update_array = array('entity_id' => $order_realtion_id , 'discount' => $discount , 'discount_amt' => $discount_amt , 'unit_discounted_price' => $unit_discounted_price , 'total_amount_without_gst' => $total_amount_without_gst , 'cgst_discount' => $cgst_percentage , 'sgst_discount' => $sgst_percentage , 'igst_discount' => $igst_percentage , 'cgst_amount' => $cgst_amount , 'sgst_amount' => $sgst_amount , 'igst_amount' => $igst_amount , 'total_amount_with_gst' => $total_amount);
                $data = $this->purchase_order_register_model->update_order_product_relation($update_array);
            }
        }

        public function update_ship_to_company_name_edit_page()
        {
            $order_entity_id = $this->input->post('order_entity_id');
            $ship_to_company_name = $this->input->post('ship_to_company_name');

            $update_order_array = array('customer_ship_to_name' => $ship_to_company_name);

            $this->db->select('*');
            $this->db->from('purchase_order_register');
            $where = '(purchase_order_register.sales_order_id = "'.$order_entity_id.'" )';
            $this->db->where($where);
            $this->db->order_by('purchase_order_register.entity_id', 'DESC');
            $this->db->limit(1);
            $query_data = $this->db->get();
            $query_result = $query_data->row_array();

            $purchase_order_entity_id = $query_result['entity_id'];

            $where = '(entity_id ="'.$purchase_order_entity_id.'")';
            $this->db->where($where);
            $this->db->update('purchase_order_register',$update_order_array);
        }

        public function update_bill_to_company_name_edit_page()
        {
            $order_entity_id = $this->input->post('order_entity_id');
            $bill_to_company_name = $this->input->post('bill_to_company_name');

            $update_order_array = array('customer_bill_to_name' => $bill_to_company_name);

            $this->db->select('*');
            $this->db->from('purchase_order_register');
            $where = '(purchase_order_register.sales_order_id = "'.$order_entity_id.'" )';
            $this->db->where($where);
            $this->db->order_by('purchase_order_register.entity_id', 'DESC');
            $this->db->limit(1);
            $query_data = $this->db->get();
            $query_result = $query_data->row_array();

            $purchase_order_entity_id = $query_result['entity_id'];

            $where = '(entity_id ="'.$purchase_order_entity_id.'")';
            $this->db->where($where);
            $this->db->update('purchase_order_register',$update_order_array);
        }

        public function update_ship_to_contact_person_edit_page()
        {
            $order_entity_id = $this->input->post('order_entity_id');
            $ship_to_contact_person = $this->input->post('ship_to_contact_person');

            $update_order_array = array('customer_ship_to_contact_person' => $ship_to_contact_person);

            $this->db->select('*');
            $this->db->from('purchase_order_register');
            $where = '(purchase_order_register.sales_order_id = "'.$order_entity_id.'" )';
            $this->db->where($where);
            $this->db->order_by('purchase_order_register.entity_id', 'DESC');
            $this->db->limit(1);
            $query_data = $this->db->get();
            $query_result = $query_data->row_array();

            $purchase_order_entity_id = $query_result['entity_id'];

            $where = '(entity_id ="'.$purchase_order_entity_id.'")';
            $this->db->where($where);
            $this->db->update('purchase_order_register',$update_order_array);
        }

        public function update_bill_to_contact_person_edit_page()
        {
            $order_entity_id = $this->input->post('order_entity_id');
            $bill_to_contact_person = $this->input->post('bill_to_contact_person');

            $update_order_array = array('customer_bill_to_contact_person' => $bill_to_contact_person);

            $this->db->select('*');
            $this->db->from('purchase_order_register');
            $where = '(purchase_order_register.sales_order_id = "'.$order_entity_id.'" )';
            $this->db->where($where);
            $this->db->order_by('purchase_order_register.entity_id', 'DESC');
            $this->db->limit(1);
            $query_data = $this->db->get();
            $query_result = $query_data->row_array();

            $purchase_order_entity_id = $query_result['entity_id'];

            $where = '(entity_id ="'.$purchase_order_entity_id.'")';
            $this->db->where($where);
            $this->db->update('purchase_order_register',$update_order_array);
        }

        public function update_ship_to_email_id()
        {
            $order_entity_id = $this->input->post('order_entity_id');
            $ship_to_email_id = $this->input->post('ship_to_email_id');

            $update_order_array = array('customer_ship_to_contact_person_mail' => $ship_to_email_id);

            $this->db->select('*');
            $this->db->from('purchase_order_register');
            $where = '(purchase_order_register.sales_order_id = "'.$order_entity_id.'" )';
            $this->db->where($where);
            $this->db->order_by('purchase_order_register.entity_id', 'DESC');
            $this->db->limit(1);
            $query_data = $this->db->get();
            $query_result = $query_data->row_array();

            $purchase_order_entity_id = $query_result['entity_id'];

            $where = '(entity_id ="'.$purchase_order_entity_id.'")';
            $this->db->where($where);
            $this->db->update('purchase_order_register',$update_order_array);

            echo json_encode($data);
        }

        public function update_bill_to_email_id()
        {
            $order_entity_id = $this->input->post('order_entity_id');
            $bill_to_email_id = $this->input->post('bill_to_email_id');

            $update_order_array = array('customer_bill_to_contact_person_mail' => $bill_to_email_id);

            $this->db->select('*');
            $this->db->from('purchase_order_register');
            $where = '(purchase_order_register.sales_order_id = "'.$order_entity_id.'" )';
            $this->db->where($where);
            $this->db->order_by('purchase_order_register.entity_id', 'DESC');
            $this->db->limit(1);
            $query_data = $this->db->get();
            $query_result = $query_data->row_array();

            $purchase_order_entity_id = $query_result['entity_id'];

            $where = '(entity_id ="'.$purchase_order_entity_id.'")';
            $this->db->where($where);
            $this->db->update('purchase_order_register',$update_order_array);
        }

        public function update_ship_to_address_edit_page()
        {
            $order_entity_id = $this->input->post('order_entity_id');
            $ship_to_address = $this->input->post('ship_to_address');

            $update_order_array = array('customer_ship_to_address' => $ship_to_address);

            $this->db->select('*');
            $this->db->from('purchase_order_register');
            $where = '(purchase_order_register.sales_order_id = "'.$order_entity_id.'" )';
            $this->db->where($where);
            $this->db->order_by('purchase_order_register.entity_id', 'DESC');
            $this->db->limit(1);
            $query_data = $this->db->get();
            $query_result = $query_data->row_array();

            $purchase_order_entity_id = $query_result['entity_id'];

            $where = '(entity_id ="'.$purchase_order_entity_id.'")';
            $this->db->where($where);
            $this->db->update('purchase_order_register',$update_order_array);
        }

        public function update_bill_to_address_edit_page()
        {
            $order_entity_id = $this->input->post('order_entity_id');
            $bill_to_address = $this->input->post('bill_to_address');

            $update_order_array = array('customer_bill_to_address' => $bill_to_address);

            $this->db->select('*');
            $this->db->from('purchase_order_register');
            $where = '(purchase_order_register.sales_order_id = "'.$order_entity_id.'" )';
            $this->db->where($where);
            $this->db->order_by('purchase_order_register.entity_id', 'DESC');
            $this->db->limit(1);
            $query_data = $this->db->get();
            $query_result = $query_data->row_array();

            $purchase_order_entity_id = $query_result['entity_id'];

            $where = '(entity_id ="'.$purchase_order_entity_id.'")';
            $this->db->where($where);
            $this->db->update('purchase_order_register',$update_order_array);
        }

        public function update_ship_to_contact_no()
        {
            $order_entity_id = $this->input->post('order_entity_id');
            $ship_to_contact_number = $this->input->post('ship_to_contact_number');

            $update_order_array = array('customer_ship_to_contact_person_no' => $ship_to_contact_number);

            $this->db->select('*');
            $this->db->from('purchase_order_register');
            $where = '(purchase_order_register.sales_order_id = "'.$order_entity_id.'" )';
            $this->db->where($where);
            $this->db->order_by('purchase_order_register.entity_id', 'DESC');
            $this->db->limit(1);
            $query_data = $this->db->get();
            $query_result = $query_data->row_array();

            $purchase_order_entity_id = $query_result['entity_id'];

            $where = '(entity_id ="'.$purchase_order_entity_id.'")';
            $this->db->where($where);
            $this->db->update('purchase_order_register',$update_order_array);
        }

        public function update_bill_to_contact_no()
        {
            $order_entity_id = $this->input->post('order_entity_id');
            $bill_to_contact_number = $this->input->post('bill_to_contact_number');

            $update_order_array = array('customer_bill_to_contact_person_no' => $bill_to_contact_number);

            $this->db->select('*');
            $this->db->from('purchase_order_register');
            $where = '(purchase_order_register.sales_order_id = "'.$order_entity_id.'" )';
            $this->db->where($where);
            $this->db->order_by('purchase_order_register.entity_id', 'DESC');
            $this->db->limit(1);
            $query_data = $this->db->get();
            $query_result = $query_data->row_array();

            $purchase_order_entity_id = $query_result['entity_id'];

            $where = '(entity_id ="'.$purchase_order_entity_id.'")';
            $this->db->where($where);
            $this->db->update('purchase_order_register',$update_order_array);
        }

        public function update_ship_to_gst_no()
        {
            $order_entity_id = $this->input->post('order_entity_id');
            $customer_ship_to_gst_no = $this->input->post('ship_to_gst_no');

            $update_order_array = array('customer_ship_to_gst_no' => $customer_ship_to_gst_no);

            $this->db->select('*');
            $this->db->from('purchase_order_register');
            $where = '(purchase_order_register.sales_order_id = "'.$order_entity_id.'" )';
            $this->db->where($where);
            $this->db->order_by('purchase_order_register.entity_id', 'DESC');
            $this->db->limit(1);
            $query_data = $this->db->get();
            $query_result = $query_data->row_array();

            $purchase_order_entity_id = $query_result['entity_id'];

            $where = '(entity_id ="'.$purchase_order_entity_id.'")';
            $this->db->where($where);
            $this->db->update('purchase_order_register',$update_order_array);
        }

        public function update_bill_to_gst_no()
        {
            $order_entity_id = $this->input->post('order_entity_id');
            $customer_ship_to_gst_no = $this->input->post('bill_to_gst_no');

            $update_order_array = array('customer_bill_to_gst_no' => $customer_ship_to_gst_no);

            $this->db->select('*');
            $this->db->from('purchase_order_register');
            $where = '(purchase_order_register.sales_order_id = "'.$order_entity_id.'" )';
            $this->db->where($where);
            $this->db->order_by('purchase_order_register.entity_id', 'DESC');
            $this->db->limit(1);
            $query_data = $this->db->get();
            $query_result = $query_data->row_array();

            $purchase_order_entity_id = $query_result['entity_id'];

            $where = '(entity_id ="'.$purchase_order_entity_id.'")';
            $this->db->where($where);
            $this->db->update('purchase_order_register',$update_order_array);
        }

        public function get_city_name()
        {
            $state_id = $this->input->post('id',TRUE);
            $data = $this->purchase_order_register_model->get_city_model_data($state_id)->result();
            echo json_encode($data);
        }

        public function get_state_code()
        {
            $id = $this->input->post('id',TRUE);
            $data = $this->purchase_order_register_model->get_state_code_by_id_model($id)->result();
            echo json_encode($data);
        }

        public function save_vendor_data()
        { 
            $vendor_name = $this->input->post('vendor_name');
            $gst_no = $this->input->post('gst_no');
            $phone_no = $this->input->post('phone_no');
            $contact_person = $this->input->post('contact_person');
            $mobile_number = $this->input->post('mobile_number');
            $state_id = $this->input->post('state_id');
            $city_id = $this->input->post('city_id');
            $address = $this->input->post('address');
            $state_code = $this->input->post('state_code');
            $pincode = $this->input->post('pincode');
            $email_id = $this->input->post('email_id');

            $data = array('vendor_name' => $vendor_name,
                          'email_id' => $email_id,
                          'phone_no' => $phone_no,
                          'mobile_no' => $mobile_number,
                          'contact_person' => $contact_person,
                          'address' => $address,
                          'state_id' => $state_id,
                          'city_id' => $city_id,
                          'pin_code' => $pincode,
                          'state_code' => $state_code,
                          'gst_no' => $gst_no,
                          'status' => 1);
            $this->db->insert('vendor_master', $data);
            $save_vendor_lastid = $this->db->insert_id();
        }

        public function update_product_description()
        {
            $entity_id = $this->input->post('order_relation_entity_id');
            $product_desc = $this->input->post('product_desc');

            $update_array = array('entity_id' => $entity_id,'product_custom_description' => $product_desc);
            $data = $this->purchase_order_register_model->update_order_product_relation($update_array);

            echo json_encode($data);
        }

        public function update_product_delivery_period()
        {
            $entity_id = $this->input->post('order_relation_entity_id');
            $delivery_period = $this->input->post('delivery_period');

            $update_array = array('entity_id' => $entity_id,'delivery_period' => $delivery_period);
            $data = $this->purchase_order_register_model->update_order_product_relation($update_array);

            echo json_encode($data);
        }

        public function update_product_warranty()
        {
            $entity_id = $this->input->post('order_relation_entity_id');
            $warranty = $this->input->post('warranty');

            $update_array = array('entity_id' => $entity_id,'product_warranty' => $warranty);
            $data = $this->purchase_order_register_model->update_order_product_relation($update_array);

            echo json_encode($data);
        }

        public function update_product_price()
        {
            $entity_id = $this->input->post('order_relation_entity_id');
            $price = $this->input->post('price');

            $this->db->select('*');
            $this->db->from('purchase_order_product_relation');
            $where = '(purchase_order_product_relation.entity_id = "'.$entity_id.'")';
            $this->db->where($where);
            $order_product_relation = $this->db->get();
            $order_product_relation_result = $order_product_relation->row();

            $product_qty = $order_product_relation_result->rfq_qty;
            $product_basic_value = $product_qty * $price;

            $product_discount = $order_product_relation_result->discount;

            $product_discounted_amount = $product_basic_value * $product_discount/100;

            $total_without_gst = $product_basic_value - $product_discounted_amount;

            $unit_discounted_price = $total_without_gst/$product_qty;

            $cgst_percentage = $order_product_relation_result->cgst_discount;
            $sgst_percentage = $order_product_relation_result->sgst_discount;
            $igst_percentage = $order_product_relation_result->igst_discount;

            $cgst_amount = $total_without_gst * $cgst_percentage/100;
            $sgst_amount = $total_without_gst * $sgst_percentage/100;
            $igst_amount = $total_without_gst * $igst_percentage/100;

            $total_amount = $total_without_gst + $cgst_amount + $sgst_amount + $igst_amount;

            $update_array = array('entity_id' => $entity_id , 'price' => $price , 'discount_amt' => $product_discounted_amount , 'unit_discounted_price' => $unit_discounted_price , 'total_amount_without_gst' => $total_without_gst , 'cgst_amount' => $cgst_amount , 'sgst_amount' => $sgst_amount , 'igst_amount' => $igst_amount , 'total_amount_with_gst' => $total_amount);
            $data = $this->purchase_order_register_model->update_order_product_relation($update_array);

            echo json_encode($data);
        }

        public function update_product_qty()
        {
            $entity_id = $this->input->post('order_relation_entity_id');
            $product_qty = $this->input->post('product_qty');

            $this->db->select('*');
            $this->db->from('purchase_order_product_relation');
            $where = '(purchase_order_product_relation.entity_id = "'.$entity_id.'")';
            $this->db->where($where);
            $order_product_relation = $this->db->get();
            $order_product_relation_result = $order_product_relation->row();

            $product_price = $order_product_relation_result->price;
            $product_basic_value = $product_qty * $product_price;

            $product_discount = $order_product_relation_result->discount;

            $product_discounted_amount = $product_basic_value * $product_discount/100;

            $total_without_gst = $product_basic_value - $product_discounted_amount;

            $unit_discounted_price = $total_without_gst/$product_qty;

            $cgst_percentage = $order_product_relation_result->cgst_discount;
            $sgst_percentage = $order_product_relation_result->sgst_discount;
            $igst_percentage = $order_product_relation_result->igst_discount;

            $cgst_amount = $total_without_gst * $cgst_percentage/100;
            $sgst_amount = $total_without_gst * $sgst_percentage/100;
            $igst_amount = $total_without_gst * $igst_percentage/100;

            $total_amount = $total_without_gst + $cgst_amount + $sgst_amount + $igst_amount;

            $update_array = array('entity_id' => $entity_id , 'rfq_qty' => $product_qty , 'discount_amt' => $product_discounted_amount , 'unit_discounted_price' => $unit_discounted_price , 'total_amount_without_gst' => $total_without_gst , 'cgst_amount' => $cgst_amount , 'sgst_amount' => $sgst_amount , 'igst_amount' => $igst_amount , 'total_amount_with_gst' => $total_amount);
            $data = $this->purchase_order_register_model->update_order_product_relation($update_array);

            echo json_encode($data);
        }

        public function update_product_discount_percentage()
        {
            $entity_id = $this->input->post('order_relation_entity_id');
            $discount_percentage = $this->input->post('discount_percentage');

           $this->db->select('*');
            $this->db->from('purchase_order_product_relation');
            $where = '(purchase_order_product_relation.entity_id = "'.$entity_id.'")';
            $this->db->where($where);
            $order_product_relation = $this->db->get();
            $order_product_relation_result = $order_product_relation->row();

            $product_price = $order_product_relation_result->price;
            $product_qty = $order_product_relation_result->rfq_qty;

            $product_basic_value = $product_qty * $product_price;

            $product_discounted_amount = $product_basic_value * $discount_percentage/100;

            $total_without_gst = $product_basic_value - $product_discounted_amount;

            $unit_discounted_price = $total_without_gst/$product_qty;

            $cgst_percentage = $order_product_relation_result->cgst_discount;
            $sgst_percentage = $order_product_relation_result->sgst_discount;
            $igst_percentage = $order_product_relation_result->igst_discount;

            $cgst_amount = $total_without_gst * $cgst_percentage/100;
            $sgst_amount = $total_without_gst * $sgst_percentage/100;
            $igst_amount = $total_without_gst * $igst_percentage/100;

            $total_amount = $total_without_gst + $cgst_amount + $sgst_amount + $igst_amount;

            $update_array = array('entity_id' => $entity_id , 'discount' => $discount_percentage , 'discount_amt' => $product_discounted_amount , 'unit_discounted_price' => $unit_discounted_price , 'total_amount_without_gst' => $total_without_gst , 'cgst_amount' => $cgst_amount , 'sgst_amount' => $sgst_amount , 'igst_amount' => $igst_amount , 'total_amount_with_gst' => $total_amount);
            $data = $this->purchase_order_register_model->update_order_product_relation($update_array);

            echo json_encode($data);
        }

        public function delete_order_product()
        {
            $entity_id = $this->input->post('id');
            $result = $this->purchase_order_register_model->delete_order_product($entity_id);
            echo json_encode($result);
        }

        public function get_second_page_purchase_order_details_by_id()
        {
            $entity_id = $this->input->post('entity_id',TRUE);
            $data = $this->purchase_order_register_model->get_second_page_purchase_order_details_by_id_model($entity_id)->result();
            echo json_encode($data);
        }

        public function create_new_product_in_purchase_order()
        {
            $po_entity_id = $this->input->post('po_entity_id');

            $order_descrption = $this->input->post('order_descrption');
            $employee_id = $this->input->post('employee_id');
            $special_customer = $this->input->post('special_customer');
            $salutation = $this->input->post('salutation');
            $price_basis = $this->input->post('price_basis');
            $transport_insurance = $this->input->post('transport_insurance');
            $tax = $this->input->post('tax');
            $delivery_schedule = $this->input->post('delivery_schedule');
            $mode_of_payment = $this->input->post('mode_of_payment');
            $mode_of_transport = $this->input->post('mode_of_transport');
            $dispatch_address = $this->input->post('dispatch_address');
            $delivery_instruction = $this->input->post('delivery_instruction');
            $packing_forwarding = $this->input->post('packing_forwarding');
            $guarantee_warrenty = $this->input->post('guarantee_warrenty');
            $payment_term = $this->input->post('payment_term');
            $special_instruction = $this->input->post('special_instruction');
            $terms_conditions = $this->input->post('terms_conditions');
            /*$sales_order_type = $this->input->post('sales_order_type');*/

            $pop_up_hsn_code = $this->input->post('pop_up_hsn_code');
            $category_id = $this->input->post('category_id');
            /*$sub_category_id = $this->input->post('sub_category_id');*/
            $product_id = $this->input->post('product_id');
            $product_name = $this->input->post('product_name');
            $product_long_desc = $this->input->post('product_long_desc');
            $product_type = 1;
            $product_sourcing_type = $this->input->post('product_sourcing_type');
            $product_warranty = $this->input->post('product_warranty');
            $product_unit = $this->input->post('product_unit');
            $product_price = $this->input->post('product_price');

            $this->db->select('*');
            $this->db->from('purchase_order_register');
            $where = '(purchase_order_register.entity_id = "'.$po_entity_id.'" )';
            $this->db->where($where);
            $query_data = $this->db->get();
            $query_result = $query_data->row_array();

            $vendor_id = $query_result['vendor_id'];

            $update_order_array = array('po_description' => $order_descrption , 'order_engg_name' => $employee_id , 'terms_conditions' => $terms_conditions , 'dispatch_address' => $dispatch_address , 'delivery_instruction' => $delivery_instruction , 'packing_forwarding' => $packing_forwarding ,'special_customer' => $special_customer , 'payment_term' => $payment_term , 'special_packing' => $special_instruction , 'salutation' => $salutation, 'price_basis' => $price_basis, 'transport_insurance' => $transport_insurance, 'tax' => $tax, 'delivery_schedule' => $delivery_schedule, 'mode_of_payment' => $mode_of_payment, 'mode_of_transport' => $mode_of_transport, 'guarantee_warrenty' => $guarantee_warrenty);

            $where = '(entity_id ="'.$po_entity_id.'")';
            $this->db->where($where);
            $this->db->update('purchase_order_register',$update_order_array);

            $product_data = array('category_id' => $category_id , 'product_id' => $product_id , 'product_name' => $product_name ,'product_long_description' => $product_long_desc , 'product_type' => $product_type , 'sourcing_type' => $product_sourcing_type , 'warrenty' => $product_warranty , 'hsn_id' => $pop_up_hsn_code , 'status' => 1 , 'unit' => $product_unit);

            $this->db->insert('product_master', $product_data);
            $product_lastid = $this->db->insert_id();

            date_default_timezone_set("Asia/Calcutta");
            $product_year = date('Y');

            $data_result = array('product_id'=> $product_lastid , 'price' => $product_price , 'year' => $product_year);
            $this->db->insert('product_pricelist_master',$data_result);

            $this->db->select('product_master.*,
                    product_hsn_master.hsn_code,
                    product_hsn_master.total_gst_percentage,
                    product_hsn_master.cgst,
                    product_hsn_master.sgst,
                    product_hsn_master.igst');
            $this->db->from('product_master');
            $this->db->join('product_hsn_master', 'product_master.hsn_id = product_hsn_master.entity_id', 'INNER');
            $where = '(product_master.entity_id = "'.$product_lastid.'" )';
            $this->db->where($where);
            $product_master = $this->db->get();
            $product_master_result = $product_master->row();

            $this->db->select('*');
            $this->db->from('product_pricelist_master');
            $where = '(product_pricelist_master.product_id = "'.$product_lastid.'" )';
            $this->db->where($where);
            $this->db->order_by('product_pricelist_master.entity_id', 'DESC');
            $this->db->limit(1);
            $product_pricelist_master = $this->db->get();
            $product_pricelist_master_result = $product_pricelist_master->row();

            $price = $product_pricelist_master_result->price;
            $rfq_qty = 1;
            $total_amount_without_gst = $price * $rfq_qty;
            $product_warrenty = $product_master_result->warrenty;
            $discount = 0;
            $discount_amt = 0;
            $unit_discounted_price = $total_amount_without_gst - $discount_amt;

            $this->db->select('*');
            $this->db->from('vendor_master');
            $where = '(vendor_master.entity_id = "'.$vendor_id.'")';
            $this->db->where($where);
            $vendor_master = $this->db->get();
            $vendor_master_result = $vendor_master->row();

            $state_code = $vendor_master_result->state_code;

            if($state_code == 24)
            {
                $cgst_percentage = $product_master_result->cgst;
                $sgst_percentage = $product_master_result->sgst;
                $igst_percentage = NULL;

                $cgst_amount = $total_amount_without_gst * $cgst_percentage/100;
                $sgst_amount = $total_amount_without_gst * $sgst_percentage/100;
                $igst_amount = NULL;
            }else{
                $igst_percentage = $product_master_result->igst;
                $sgst_percentage = NULL;
                $cgst_percentage = NULL;

                $igst_amount = $total_amount_without_gst * $igst_percentage/100;
                $sgst_amount = NULL;
                $cgst_amount = NULL;
            }

            $total_amount = $total_amount_without_gst + $cgst_amount + $sgst_amount + $igst_amount;

            $order_product_relation_save = "INSERT INTO purchase_order_product_relation (purchase_order_id , product_id , rfq_qty , price , total_amount_without_gst , cgst_discount , sgst_discount , igst_discount , cgst_amount , sgst_amount , igst_amount , total_amount_with_gst , product_warranty , discount , discount_amt , unit_discounted_price) VALUES ('".$po_entity_id."' , '".$product_lastid."' , '".$rfq_qty."' , '".$price."' , '".$total_amount_without_gst."' , '".$cgst_percentage."' , '".$sgst_percentage."' , '".$igst_percentage."' , '".$cgst_amount."' , '".$sgst_amount."' , '".$igst_amount."' , '".$total_amount."' , '".$product_warrenty."' , '".$discount."' , '".$discount_amt."' , '".$unit_discounted_price."')";
            $save_order_product_relation = $this->db->query($order_product_relation_save);

            $data = $po_entity_id;
            echo json_encode($data);
        }

        public function update_order_product()
        {
            $po_entity_id = $this->input->post('po_entity_id');

            $product_checkbox = $this->input->post('product_checkbox');
            $order_descrption = $this->input->post('order_descrption');
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
            $special_customer = $this->input->post('special_customer');
            /*$sales_order_type = $this->input->post('sales_order_type');*/

            $this->db->select('*');
            $this->db->from('purchase_order_register');
            $where = '(purchase_order_register.entity_id = "'.$po_entity_id.'" )';
            $this->db->where($where);
            $query_data = $this->db->get();
            $query_result = $query_data->row_array();

            $vendor_id = $query_result['vendor_id'];

            $update_order_array = array('po_description' => $order_descrption , 'order_engg_name' => $employee_id , 'terms_conditions' => $order_terms_condition , 'delivery_period' => $delivery_period , 'transportation' => $order_freight , 'transportation_price' => $freight_charges , 'dispatch_address' => $dispatch_address , 'delivery_instruction' => $delivery_instruction , 'packing_forwarding' => $packing_forwarding , 'packing_forwarding_price' => $packing_forwarding_charges , 'payment_term' => $payment_term , 'special_packing' => $special_instruction , 'insurance' => $order_insurance , 'insurance_price' => $insurance_charges, 'salutation' => $salutation, 'price_basis' => $price_basis, 'transport_insurance' => $transport_insurance, 'tax' => $tax, 'delivery_schedule' => $delivery_schedule, 'mode_of_payment' => $mode_of_payment, 'mode_of_transport' => $mode_of_transport, 'guarantee_warrenty' => $guarantee_warrenty, 'special_customer' => $special_customer);

            $where = '(entity_id ="'.$po_entity_id.'")';
            $this->db->where($where);
            $this->db->update('purchase_order_register',$update_order_array);

            foreach ($product_checkbox as $key => $value) {
                $product_id = $value;

                $this->db->select('product_master.*,
                    product_hsn_master.hsn_code,
                    product_hsn_master.total_gst_percentage,
                    product_hsn_master.cgst,
                    product_hsn_master.sgst,
                    product_hsn_master.igst');
                $this->db->from('product_master');
                $this->db->join('product_hsn_master', 'product_master.hsn_id = product_hsn_master.entity_id', 'INNER');
                $where = '(product_master.entity_id = "'.$product_id.'" )';
                $this->db->where($where);
                $product_master = $this->db->get();
                $product_master_result = $product_master->row();

                $this->db->select('*');
                $this->db->from('product_pricelist_master');
                $where = '(product_pricelist_master.product_id = "'.$product_id.'" )';
                $this->db->where($where);
                $this->db->order_by('product_pricelist_master.entity_id', 'DESC');
                $this->db->limit(1);
                $product_pricelist_master = $this->db->get();
                $product_pricelist_master_result = $product_pricelist_master->row();

                $price = $product_pricelist_master_result->price;
                $rfq_qty = 1;
                $total_amount_without_gst = $price * $rfq_qty;
                $product_warrenty = $product_master_result->warrenty;
                $discount = 0;
                $discount_amt = 0;
                $unit_discounted_price = $total_amount_without_gst - $discount_amt;

                $this->db->select('*');
                $this->db->from('vendor_master');
                $where = '(vendor_master.entity_id = "'.$vendor_id.'")';
                $this->db->where($where);
                $vendor_master = $this->db->get();
                $vendor_master_result = $vendor_master->row();

                $state_code = $vendor_master_result->state_code;

                if($state_code == 24)
                {
                    $cgst_percentage = $product_master_result->cgst;
                    $sgst_percentage = $product_master_result->sgst;
                    $igst_percentage = NULL;

                    $cgst_amount = $total_amount_without_gst * $cgst_percentage/100;
                    $sgst_amount = $total_amount_without_gst * $sgst_percentage/100;
                    $igst_amount = NULL;
                }else{
                    $igst_percentage = $product_master_result->igst;
                    $sgst_percentage = NULL;
                    $cgst_percentage = NULL;

                    $igst_amount = $total_amount_without_gst * $igst_percentage/100;
                    $sgst_amount = NULL;
                    $cgst_amount = NULL;
                }

                $total_amount = $total_amount_without_gst + $cgst_amount + $sgst_amount + $igst_amount;

                $this->db->select('*');
                $this->db->from('purchase_order_product_relation');
                $where_or = '(product_id = "'.$product_id.'" AND purchase_order_id = "'.$po_entity_id.'")';
                $this->db->where($where_or);
                $order_product_exit= $this->db->get();
                $order_product_exit_data_count =  $order_product_exit->num_rows();

                if ($order_product_exit_data_count === 0) 
                {
                    $order_product_relation_save = "INSERT INTO purchase_order_product_relation (purchase_order_id , product_id , rfq_qty , price , total_amount_without_gst , cgst_discount , sgst_discount , igst_discount , cgst_amount , sgst_amount , igst_amount , total_amount_with_gst , product_warranty , discount , discount_amt , unit_discounted_price) VALUES ('".$po_entity_id."' , '".$product_id."' , '".$rfq_qty."' , '".$price."' , '".$total_amount_without_gst."' , '".$cgst_percentage."' , '".$sgst_percentage."' , '".$igst_percentage."' , '".$cgst_amount."' , '".$sgst_amount."' , '".$igst_amount."' , '".$total_amount."' , '".$product_warrenty."' , '".$discount."' , '".$discount_amt."' , '".$unit_discounted_price."')";
                    $save_order_product_relation = $this->db->query($order_product_relation_save);
                    //set session 
                    //$this->session->set_userdata('offer_product', 'Product Saved....!');
                }
                else{
                    //$this->session->set_userdata('offer_product', $session_product_var.' Product already exist....!');
                }
            }

            $data = $order_entity_id;
            echo json_encode($data);
        }

        public function save_second_page_purchase_order()
        {
            $po_entity_id = $this->input->post('po_entity_id');

            $order_descrption = $this->input->post('order_descrption');
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
            $special_customer = $this->input->post('special_customer');
            /*$sales_order_type = $this->input->post('sales_order_type');*/

            $update_order_array = array('po_description' => $order_descrption , 'order_engg_name' => $employee_id , 'terms_conditions' => $order_terms_condition , 'delivery_period' => $delivery_period , 'transportation' => $order_freight , 'transportation_price' => $freight_charges , 'dispatch_address' => $dispatch_address , 'delivery_instruction' => $delivery_instruction , 'packing_forwarding' => $packing_forwarding , 'packing_forwarding_price' => $packing_forwarding_charges , 'payment_term' => $payment_term , 'special_packing' => $special_instruction , 'insurance' => $order_insurance , 'insurance_price' => $insurance_charges, 'salutation' => $salutation, 'price_basis' => $price_basis, 'transport_insurance' => $transport_insurance, 'tax' => $tax, 'delivery_schedule' => $delivery_schedule, 'mode_of_payment' => $mode_of_payment, 'mode_of_transport' => $mode_of_transport, 'guarantee_warrenty' => $guarantee_warrenty, 'special_customer' => $special_customer , 'status' => 2);

            $where = '(entity_id ="'.$po_entity_id.'")';
            $this->db->where($where);
            $this->db->update('purchase_order_register',$update_order_array);

            redirect('vw_purchase_order_data'); 
        }

        public function view_purchase_order_data()
        {
            $entity_id = $this->uri->segment(2);

            $data['employee_list'] = $this->purchase_order_register_model->get_employee_list();
            $data['order_product_list'] = $this->purchase_order_register_model->get_order_product_list($entity_id);
            $data['product_category'] = $this->purchase_order_register_model->get_product_category();
            $data['product_detail_hsn_code'] = $this->purchase_order_register_model->get_product_hsn_code();
            $data['product_list'] = $this->purchase_order_register_model->get_product_list();
            $data['vendor_list'] = $this->purchase_order_register_model->get_vendor_list();

            $data['entity_id'] = $entity_id;

            $this->load->view('sales/purchase_order_register/vw_purchase_order_register_view',$data);
        }

        public function download_offer()
        {
            ob_start();
            $entity_id = $this->uri->segment(2);
            $this->db->select('customer_master.customer_name AS Customer_name,
                              customer_master.entity_id AS Customer_id,
                              customer_address_master.address AS Customer_address,
                              customer_address_master.pin_code AS Pin_code,
                              customer_contact_master.contact_person AS Contact_person_name,
                              customer_contact_master.email_id AS Customer_email_id,
                              customer_contact_master.first_contact_no AS Contact_no,
                              customer_address_master.gst_no AS Gst_no,
                              customer_address_master.state_code AS State_code,
                              offer_register.entity_id AS Entity_id,
                              offer_register.offer_no AS Offer_no,
                              offer_register.offer_description AS Offer_description,
                              offer_register.offer_engg_name AS Offer_engg_name,
                              offer_register.offer_date AS Offer_date,
                              offer_register.warranty_id AS Warranty,
                              offer_register.payment_term AS Payment_term,
                              offer_register.loading AS Loading,
                              offer_register.unloading_scope AS Unloading_scope,
                              offer_register.unloading_price AS Unloading_price,
                              offer_register.site_preparation AS Site_preparation,
                              offer_register.installation AS Installation,
                              offer_register.Transportation AS Transportation,
                              offer_register.transportation_price AS Transportation_price,
                              offer_register.insurance AS Insurance,
                              offer_register.insurance_price AS Insurance_price,
                              offer_register.packing_forwarding AS Packing_forwarding,
                              offer_register.packing_forwarding_price AS Packing_forwarding_price,
                              offer_register.delivery_period AS Delivery_period,
                              offer_register.delivery_instruction AS Delivery_instruction,
                              offer_register.transportation AS Offer_freight,
                              offer_register.price_condition AS price_condition,
                              offer_register.note AS note,

                              offer_register.salutation AS Salutation,
                              offer_register.price_basis AS Price_basis,
                              offer_register.transport_insurance AS Transport_insurance,
                              offer_register.tax AS Tax,
                              offer_register.delivery_schedule AS Delivery_schedule,
                              offer_register.mode_of_payment AS Mode_of_payment,
                              offer_register.mode_of_transport AS Mode_of_transport,
                              offer_register.guarantee_warrenty AS Guarantee_warrenty,
                              offer_register.your_reference AS Your_reference,
                              employee_master.emp_first_name AS Emp_first_name,
                              employee_master.emp_middle_name AS Emp_middle_name,
                              employee_master.emp_last_name AS Emp_last_name,
                              employee_master.mobile_no AS Mobile_no,
                              state_master.state_name AS State_name,
                              enquiry_register.enquiry_no');
            $this->db->from('offer_register');
            $this->db->join('customer_master', 'customer_master.entity_id = offer_register.customer_id', 'INNER');
            $this->db->join('enquiry_register', 'enquiry_register.entity_id = offer_register.enquiry_id', 'INNER');
            $this->db->join('customer_address_master', 'customer_address_master.customer_id = customer_master.entity_id', 'INNER');
            $this->db->join('customer_contact_master', 'customer_contact_master.customer_id = customer_master.entity_id', 'INNER');
            $this->db->join('employee_master', 'offer_register.offer_engg_name = employee_master.entity_id', 'INNER');
            $this->db->join('state_master', 'customer_address_master.state_code = state_master.state_code', 'INNER');
            $where = '(offer_register.entity_id = "'.$entity_id.'")';
            $this->db->where($where);
            $query_master_offer_data = $this->db->get();
            $master_offer_data = $query_master_offer_data->result_array();


            $this->db->select('employee_master.emp_first_name AS Full_name,
                            employee_master.email_id AS Email_id,
                            employee_master.mobile_no AS Phone_number,
                            purchase_order_register.*');
            $this->db->from('purchase_order_register');
            $this->db->join('employee_master', 'purchase_order_register.order_engg_name = employee_master.entity_id', 'INNER');
            $where = '(purchase_order_register.entity_id = "'.$entity_id.'")';
            $this->db->where($where);
            $purchase_order_register = $this->db->get();
            $purchase_order_register_result = $purchase_order_register->row_array();











            $offer_no = $master_offer_data[0]['Offer_no'];
            $enquiry_no = $master_offer_data[0]['enquiry_no'];

            $Pin_code = $master_offer_data[0]['Pin_code'];
            $Gst_no = $master_offer_data[0]['Gst_no'];
            $State_code = $master_offer_data[0]['State_code'];
            $State_name = $master_offer_data[0]['State_name'];
            $email = $master_offer_data[0]['Customer_email_id'];
            $contact_no1 = $master_offer_data[0]['Contact_no'];
            $offer_description = $master_offer_data[0]['Offer_description'];

            $offer_description_limited = substr($offer_description, 0, 100);

            $date_of_offer = $master_offer_data[0]['Offer_date'];
            $offer_date = date("d-m-Y",strtotime($date_of_offer));
            $installation = $master_offer_data[0]['Installation'];
            $transportation = $master_offer_data[0]['Transportation'];
            $transportation_price = $master_offer_data[0]['Transportation_price'];
            $unloading_scope = $master_offer_data[0]['Unloading_scope'];
            $unloading_price = $master_offer_data[0]['Unloading_price'];
            $packing_forwarding = $master_offer_data[0]['Packing_forwarding'];
            $packing_forwarding_price = $master_offer_data[0]['Packing_forwarding_price'];
            $insurance = $master_offer_data[0]['Insurance'];
            $insurance_price = $master_offer_data[0]['Insurance_price'];
            $payment_term = $master_offer_data[0]['Payment_term'];
            $customer_name = $master_offer_data[0]['Customer_name'];
            $customer_id = $master_offer_data[0]['Customer_id'];
            $Customer_address = $master_offer_data[0]['Customer_address'];
            $contact_person_name = $master_offer_data[0]['Contact_person_name'];
            $Delivery_instruction = $master_offer_data[0]['Delivery_instruction'];
            $Offer_freight = $master_offer_data[0]['Offer_freight'];
            $price_condition = $master_offer_data[0]['price_condition'];
            $note = $master_offer_data[0]['note'];
        
            $Salutation = $master_offer_data[0]['Salutation'];
            $Price_basis = $master_offer_data[0]['Price_basis'];
            $Transport_insurance = $master_offer_data[0]['Transport_insurance'];
            $Tax = $master_offer_data[0]['Tax'];
            $Delivery_schedule = $master_offer_data[0]['Delivery_schedule'];
            $Mode_of_payment = $master_offer_data[0]['Mode_of_payment'];
            $Mode_of_transport = $master_offer_data[0]['Mode_of_transport'];
            $Guarantee_warrenty = $master_offer_data[0]['Guarantee_warrenty'];
            $Your_reference = $master_offer_data[0]['Your_reference'];

            $Emp_first_name = $master_offer_data[0]['Emp_first_name'];
            $Emp_middle_name = $master_offer_data[0]['Emp_middle_name'];
            $Emp_last_name = $master_offer_data[0]['Emp_last_name'];
            $Mobile_no = $master_offer_data[0]['Mobile_no'];

            $this->db->select('employee_master.emp_first_name AS Full_name,
                              employee_master.email_id AS Email_id,
                              employee_master.mobile_no AS Phone_number,
                              employee_master.date_of_birth AS Date_of_birth,
                              employee_master.joining_date AS Date_of_joining,
                              enquiry_register.enquiry_source AS Enquiry_source');
            $this->db->from('offer_register');
            $this->db->join('enquiry_register', 'offer_register.enquiry_id = enquiry_register.entity_id', 'INNER');
            $this->db->join('employee_master', 'enquiry_register.emp_id = employee_master.entity_id', 'INNER');
            $where = '(offer_register.entity_id = "'.$entity_id.'")';
            $this->db->where($where);
            $query_master_employeedata = $this->db->get();
            $master_employee_data = $query_master_employeedata->row_array();
            //print_r($master_employee_data); echo "<br>"; echo "<br>";
           
            $Full_name = $master_employee_data['Full_name'];
            $Email_id = $master_employee_data['Email_id'];
            $Phone_number = $master_employee_data['Phone_number'];
            $Date_of_birth = $master_employee_data['Date_of_birth'];
            $Date_of_joining = $master_employee_data['Date_of_joining'];
            $Enquiry_source = $master_employee_data['Enquiry_source'];

            $this->db->select('offer_product_relation.entity_id AS Entity_id,
                                offer_product_relation.offer_id,
                                offer_product_relation.product_id,  
                                offer_product_relation.rfq_qty,
                                offer_product_relation.product_custom_description,
                                offer_product_relation.price,
                                offer_product_relation.discount,
                                offer_product_relation.discount_amt,
                                offer_product_relation.unit_discounted_price,
                                offer_product_relation.total_amount_without_gst,
                                offer_product_relation.cgst_discount,
                                offer_product_relation.cgst_amt,
                                offer_product_relation.sgst_discount,
                                offer_product_relation.sgst_amt,
                                offer_product_relation.igst_discount,
                                offer_product_relation.igst_amt,
                                offer_product_relation.total_amount_with_gst,
                                product_master.product_id AS PRODUCT_ID,
                                product_master.product_name,
                                product_hsn_master.hsn_code AS Hsn_code');
            $this->db->from('offer_product_relation');
            $this->db->join('product_master', 'offer_product_relation.product_id = product_master.entity_id', 'INNER');
            $this->db->join('product_hsn_master', 'product_master.hsn_id = product_hsn_master.entity_id', 'INNER');
            $where = '(offer_product_relation.offer_id = "'.$entity_id.'")';
            $this->db->where($where);
            $offer_product_data= $this->db->get();
            $data_offer_product = $offer_product_data->result_array(); 
            $data_offer_product_count = $offer_product_data->num_rows();
            //print_r($data_offer_product_count);
            //die();
            //$location_id = $_SESSION['location_id'];
            $pdf = new Offer_pdf('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $path_img = getcwd();
            $pdf->SetPrintHeader(true);
            $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '' , 15));
            $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            $pdf->SetDefaultMonospacedFont(5);
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetTopMargin(10);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            $pdf->startPageGroup();
            $pdf->setPrintFooter(true);

            // set font
            $pdf->SetFont('dejavusans', '', 10);
            $path_img = getcwd();
            $trusted_img = $path_img."/assets/login/maitri.png";

            $trusted_img_header = $path_img."/assets/login/Maitry_header.png";
            $trusted_img_footer = $path_img."/assets/login/maitry_footer.png";

            $trusted_img2 = $path_img."/assets/login/new_sai.png";
            $shee_samarth_img = $path_img."/assets/login/shree_auto_care.png";
            $filename_img = $path_img."/assets/login/sai_loooogo1.png";
            $car_img = $path_img."/assets/login/car.jpg";
            $fuel_tank = $path_img."/assets/login/fuel_guage.png";
            $gas_indicator = $path_img."/assets/login/gasindicator.png";

            $telephone = $path_img."/assets/login/telephone.png";
            $location = $path_img."/assets/login/location.jpg";
            $mail = $path_img."/assets/login/mail.png";
            $website = $path_img."/assets/login/website.png";

            // add a page
            $pdf->AddPage();

            if ($transportation == 1) {
                   $transportation = "Customer Scope";
            }elseif ($transportation == 2) {
                   $transportation = "Company Scope";
            }

            if ($insurance == 1) {
               $insurance = "Customer Scope";
            }elseif ($insurance == 2) {
               $insurance = "Company Scope";
            }

            if($price_condition == 1){
                $price_condition ="Ex Works";
            }elseif ($price_condition == 2) {
                   $price_condition = "For Site";
            }elseif ($price_condition == 3) {
                   $price_condition = "Other Please refer Note";
            }

            if ($Enquiry_source == 1) 
            {
               $Enquiry_source = "Pull Cord (MH)";
            }elseif ($Enquiry_source == 2) {
               $Enquiry_source = "Proximity (PS)";
            }elseif ($Enquiry_source == 3) {
              $Enquiry_source = "Vibrator Control (VC)";
            }elseif ($Enquiry_source == 4) {
              $Enquiry_source = "Treading (TD)";
            }elseif ($Enquiry_source == 5) {
              $Enquiry_source = "Others (OT)";
            }

            if ($payment_term == 1) 
            {
               $payment_term = "100% Advance";
            }elseif ($payment_term == 2) {
               $payment_term = "50% Advance & 50% Against Delivery";
            }elseif ($payment_term == 3) {
              $payment_term = "50% Advance & 50% Against Performa";
            }elseif ($payment_term == 4) {
              $payment_term = "20% Advance & 30 % against Delivery & 50 % Against 30 days";
            }elseif ($payment_term == 5) {
              $payment_term = "100% Within 30 Days of Delivery";
            }elseif ($payment_term == 6) {
              $payment_term = "100% Within 45 Days of Delivery";
            }elseif ($payment_term == 7) {
              $payment_term = "100% Payment PDC Befor Delivery";
            }elseif ($payment_term == 8) {
              $payment_term = "30% Advance 50% Agains Delivery or Invoice  & 20% within 45 days of Delivery";
            }   

            if ($packing_forwarding == 1) {
               $packing_forwarding = "Customer Scope";
            }elseif ($packing_forwarding == 2) {
               $packing_forwarding = "Company Scope";
            }

            if ($Offer_freight == 1) {
               $Offer_freight = "Customer Scope";
            }elseif ($Offer_freight == 2) {
               $Offer_freight = "Company Scope";
            }

            $html = '<table border="0.1" cellpadding="3" width="100%">
                        <tr>
                            <th style="font-size: 7.5px; width: 100%; color: #0fee;"><img src="'.strip_tags($trusted_img_header).'">
                                <p style="text-align: center;"><b>Shop No. 42, 1st Floor, Akshar Shopping Center, Road No. 1, Udyognagar, <br>
                                Udhna Surat - 394210, Gujarat, India | GSTIN: 24AAKFM4223D1ZP <br>
                                Email: vbdigitech@gmail.com | M : 91 08048763439 | Website : <a href="https://www.maitryinstruments.com"> www.maitryinstruments.com</a></b></p> 
                            </th>
                        </tr>
                    </table>';      

            $pdf->writeHTML($html, true, false, true, false, ''); 

            $html = '<table border="0.3" cellpadding="3" width="100%">

                        <tr style="background-color: #C0C0C0;">
                            <td style="font-size: 12px; width: 100%; text-indent:1em;"><h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;QUOTATION</h5></td>
                        </tr>

                        <tr>
                            <td style="font-size: 8px; width: 50%; text-indent:1em;">To,<br>&nbsp;<b>'.strip_tags($customer_name).'</b><br>&nbsp;'.strip_tags($Customer_address).'<br>&nbsp;<b>Pin Code</b> : '.strip_tags($Pin_code).'</td>

                            <td style="font-size: 8px; width: 50%; text-indent:1em;"><b>Offer No :  '.strip_tags($offer_no).'</b><br>&nbsp;Enquiry Reference :  '.strip_tags($enquiry_no).'<br>&nbsp;Your Reference : '.strip_tags($Your_reference).'<br>&nbsp;Offer Date : '.strip_tags($offer_date).'</td>
                        </tr>

                        <tr>
                            <td style="font-size: 8px; width: 50%; text-indent:1em;"><b>GST No :</b> '.strip_tags($Gst_no).' </td>

                            <td style="font-size: 8px; width: 50%; text-indent:1em;"><b>State Code </b>'.strip_tags($State_code).' '.strip_tags($State_name).' </td>
                        </tr>
                    </table>';         

            $pdf->writeHTML($html, true, false, true, false, '');

            $html = '<p style="font-size: 8px;"><b>Kind Attn : </b>'.strip_tags($contact_person_name).'<br><b>Mobile No.</b> : '.strip_tags($contact_no1).'<br>'.strip_tags($Salutation).'</p><br>';    
                    
            $pdf->writeHTML($html, true, false, true, false, '');         

            $html = '<table border="0.3" cellpadding="3" width="100%">
                        <tr style="background-color: #C0C0C0;">
                          <td style="font-size: 6.5px; width: 7%; text-indent:1em;"><b>Sr.No</b></td>

                          <td style="font-size: 6.5px; width: 15%; text-indent:1em;"><b>Product ID/<br>&nbsp;HSN/SAC</b></td>

                          <td style="font-size: 6.5px; width: 35%; text-indent:1em;"><b>Product Name & Product Description</b></td>

                          <td style="font-size: 6.5px; width: 6%; text-indent:1em;"><b>QTY<br><br>&nbsp;UOM</b></td>

                          <td style="font-size: 6.5px; width: 9%; text-indent:1em;"><b>Unit Rate</b></td>

                          <td style="font-size: 6px; width: 10%; text-indent:1em;"><b>Discount % </b></td>

                          <td style="font-size: 6px; width: 8%; text-indent:1em;"><b>GST % <br><br>&nbsp;GST Amt</b></td>

                          <td style="font-size: 6px; width: 10%; text-indent:1em;"><b>Total</b></td>
                          
                         </tr>
                    </table>';    

            if($data_offer_product_count === 1)  
            {
                $final_amount = 0;
                $sgst_amt_fromat = 0;
                $cgst_amt_fromat = 0;
                $igst_amt_fromat = 0;
                $total_amount_with_gst_final = 0;
                 $price_format = 0;
                 $taxable_amount_valueeee_new1_format = 0;
                 $i=1;
                 //$product_custom_description_format = "";
                 
                foreach ($data_offer_product as $value_data) 
                {
                    $Entity_id = $value_data['Entity_id'];
                    $PRODUCT_ID = $value_data['PRODUCT_ID'];
                    $product_name = $value_data['product_name'];
                    $Hsn_code = $value_data['Hsn_code'];
                    $rfq_qty = $value_data['rfq_qty']; 
                    $price = $value_data['price']; 
                    $price_new = number_format($price, 2);
                    $product_custom_description = $value_data['product_custom_description']; 

                    $product_custom_description_format = explode("#",$product_custom_description);

                    $data = "";
                    foreach ($product_custom_description_format as $key => $value){

                        $file_name = $value;
                        $data .= $file_name.'<br>';
                        // print_r($data);
                        // die();
                    }
                    // $product_custom_description_new = nl2br(stripslashes($product_custom_description));
                    // print_r($product_custom_description_new);
                    // die();
                    // $product_custom_description_format =explode("#", $product_custom_description);

                    // $pcd1 = $product_custom_description_format[1];
                    // print_r($pcd1);
                    // die();
                    // $num_tags = count($product_custom_description_format);
                     
                    // if($num_tags === 9){
                    //     $pcd1 = $product_custom_description_format[0];
                    //     $pcd2 = $product_custom_description_format[1];
                    //     $pcd3 = $product_custom_description_format[2];
                    //     $pcd4 = $product_custom_description_format[3];
                    //     $pcd5 = $product_custom_description_format[4];
                    //     $pcd6 = $product_custom_description_format[5];
                    //     $pcd7 = $product_custom_description_format[6];
                    //     $pcd8 = $product_custom_description_format[7];
                    //     $pcd9 = $product_custom_description_format[8];

                    //     $pcd_new = $pcd1."<br>";
                        
                    // }
                    //$pcd = implode("<br><br><br>",$product_custom_description_format);
                
                    // print_r($num_tags);
                    // die();
                    
                    $price_format_new = number_format($price, 2);
                    $discount = $value_data['discount'];   
                    $discount_amt = $value_data['discount_amt'];   
                    // print_r($discount_amt);
                    // die();
                    $sgst_discount = $value_data['sgst_discount'];   
                    $sgst_amt = $value_data['sgst_amt']; 


                    $cgst_discount = $value_data['cgst_discount'];   
                    $cgst_amt = $value_data['cgst_amt']; 


                    $igst_discount = $value_data['igst_discount'];   
                    $igst_amt = $value_data['igst_amt'];

                    $total_gst_percentage = $sgst_discount + $cgst_discount + $igst_discount;

                    $total_gst_percentage_amount = $sgst_amt + $cgst_amt + $igst_amt;
                    $new_amount = $total_gst_percentage_amount + $price;

                    $total_amount_with_gst = $value_data['total_amount_with_gst']; 

                    $total_amount_with_gst_new_format = number_format($total_amount_with_gst, 2);

                    $total_amount_with_gst_final += $total_amount_with_gst;  
                    //$total_amount_with_gst_final_new = number_format($total_amount_with_gst_final);
                    $total_amount_with_gst_final_new = number_format($total_amount_with_gst_final, 2);

                    $price_format += $price; 
                    $price_format_new = number_format($price_format, 2);

                    $taxable_amount_valueeee = $price * $rfq_qty; 

                    $taxable_amount_valueeee_new = $taxable_amount_valueeee * $discount / 100; 
                    // print_r($taxable_amount_valueeee_new);
                    // die(); 

                    $taxable_amount_valueeee_new1 = $taxable_amount_valueeee - $taxable_amount_valueeee_new;

                    $taxable_amount_valueeee_new1_format += $taxable_amount_valueeee_new1; 
                    $taxable_amount_new = number_format($taxable_amount_valueeee_new1_format, 2);
                    // print_r($taxable_amount_valueeee_new1);
                    // die();          
                    $sgst_amt_fromat += $sgst_amt; 
                    $sgst_amt_fromat_new = number_format($sgst_amt_fromat, 2);

                    $cgst_amt_fromat += $cgst_amt;
                    $cgst_amt_fromat_new = number_format($cgst_amt_fromat, 2);

                    $igst_amt_fromat += $igst_amt;   
                    $igst_amt_fromat_new = number_format($igst_amt_fromat, 2);

                    $total_amount_with_gst_new = $taxable_amount_valueeee_new1 + $cgst_amt + $sgst_amt +  $igst_amt; 

                    $final_amount  += $total_amount_with_gst_new;
                    $final_amount_new = number_format($final_amount, 2);
                    $this->load->library('numbertowordconvertsconver');
                    $Final_invoice_amount_in_word = $this->numbertowordconvertsconver->convert_number($final_amount);
                      $html .=  '<table style="border-collapse: collapse;">
                                  <tr style="border: none;">
                                    <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a; width: 7%; font-size: 7.5px;text-indent:1em;">'.strip_tags($i).'<br></td>

                                    <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a; width: 15%; font-size: 7.5px;text-indent:1em;"><b>'.strip_tags($PRODUCT_ID).'</b><br>&nbsp;'.strip_tags($Hsn_code).'<br></td>

                                  <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a; width: 35%; font-size: 7.5px;text-indent:1em;"><b>'.strip_tags($product_name).'</b><br> '.html_entity_decode($data).'<br></td>

                                  <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a; width: 6%; font-size: 7.5px;text-indent:1em;">'.strip_tags($rfq_qty).'<br></td>

                                  <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a; width: 9%; font-size: 7.5px;text-indent:1em;">'.strip_tags($price_new).'<br></td>

                                  <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a; width: 10%; font-size: 7.5px;text-indent:1em;">'.strip_tags($discount).' %<br></td>

                                  <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a; width: 8%; font-size: 7.5px;text-indent:1em;">'.strip_tags($total_gst_percentage).' %<br>&nbsp;'.strip_tags($total_gst_percentage_amount).'<br></td>

                                  <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a; width: 10%; font-size: 7.5px;text-indent:1em;">'.strip_tags($total_amount_with_gst_new_format).'<br></td>
                                  </tr>

                                </table>';
                        $i++;
                    
                }

                if ($data_offer_product_count % 1 == 0) 
                { 
                    //if is divisible for 3, put the blanck row
                    $html .='<table style="border-collapse: collapse;"> 
                    
                
                        <tr>                                   
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 7%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 15%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 35%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 6%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 9%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 10%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 8%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 10%;">&nbsp;</td>
                    </tr>

                    <tr>                                   
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 7%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 15%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 35%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 6%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 9%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 10%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 8%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 10%;">&nbsp;</td>
                    </tr>

                    <tr>                                   
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 7%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 15%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 35%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 6%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 9%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 10%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 8%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 10%;">&nbsp;</td>
                    </tr>

                    </table>'; 

                $html .= '<table style="border: solid 1px #5a5a5a;" width="100%">
                    
                </table>';   
                    
                } 
                $html .='<br><br><table border="0.3" cellpadding="3" cellspacing="0" width="100%">  
                    
                    <tr>                                   
                        <td colspan="4" style="width: 75%; font-size: 7.5px;"><br><br><b>In Words : '.strip_tags($Final_invoice_amount_in_word).'</b></td>
                        
                        <td style="width: 13%; font-size: 7px; text-align:right;">Taxable Amount<br>CGST<br>SGST<br>IGST<br><b>Grand Total</b></td>
                        <td style="width: 12%; font-size: 7px; text-align:right;">'.strip_tags($taxable_amount_new).'<br>'.strip_tags($cgst_amt_fromat_new).'<br>'.strip_tags($sgst_amt_fromat_new).'<br>'.strip_tags($igst_amt_fromat_new).'<br><b>'.strip_tags($final_amount_new).'</b></td>
                    </tr>
                    
                    
                    </table>';   
            }

            if($data_offer_product_count === 2)  
            {
                $final_amount = 0;
                $sgst_amt_fromat = 0;
                $cgst_amt_fromat = 0;
                $igst_amt_fromat = 0;
                $total_amount_with_gst_final = 0;
                 $price_format = 0;
                 $taxable_amount_valueeee_new1_format = 0;
                 $i=1;
                foreach ($data_offer_product as $value_data) 
                {
                    $Entity_id = $value_data['Entity_id'];
                    $PRODUCT_ID = $value_data['PRODUCT_ID'];
                    $product_name = $value_data['product_name'];
                    $Hsn_code = $value_data['Hsn_code'];
                    $rfq_qty = $value_data['rfq_qty']; 
                    $price = $value_data['price']; 
                    $price_new = number_format($price, 2);
                    $product_custom_description = $value_data['product_custom_description']; 
                    $product_custom_description_format = explode("#",$product_custom_description);

                    $data = "";
                    foreach ($product_custom_description_format as $key => $value){

                        $file_name = $value;
                        $data .= $file_name.'<br>';
                        // print_r($data);
                        // die();
                    }

                    $price_format_new = number_format($price, 2);
                    $discount = $value_data['discount'];   
                    $discount_amt = $value_data['discount_amt'];   
                    // print_r($discount_amt);
                    // die();
                    $sgst_discount = $value_data['sgst_discount'];   
                    $sgst_amt = $value_data['sgst_amt']; 


                    $cgst_discount = $value_data['cgst_discount'];   
                    $cgst_amt = $value_data['cgst_amt']; 


                    $igst_discount = $value_data['igst_discount'];   
                    $igst_amt = $value_data['igst_amt'];

                    $total_gst_percentage = $sgst_discount + $cgst_discount + $igst_discount;

                    $total_gst_percentage_amount = $sgst_amt + $cgst_amt + $igst_amt;
                    $new_amount = $total_gst_percentage_amount + $price;

                    $total_amount_with_gst = $value_data['total_amount_with_gst']; 

                    $total_amount_with_gst_new_format = number_format($total_amount_with_gst, 2);

                    $total_amount_with_gst_final += $total_amount_with_gst;  
                    //$total_amount_with_gst_final_new = number_format($total_amount_with_gst_final);
                    $total_amount_with_gst_final_new = number_format($total_amount_with_gst_final, 2);

                    $price_format += $price; 
                    $price_format_new = number_format($price_format, 2);

                    $taxable_amount_valueeee = $price * $rfq_qty; 

                    $taxable_amount_valueeee_new = $taxable_amount_valueeee * $discount / 100; 
                    // print_r($taxable_amount_valueeee_new);
                    // die(); 

                    $taxable_amount_valueeee_new1 = $taxable_amount_valueeee - $taxable_amount_valueeee_new;

                    $taxable_amount_valueeee_new1_format += $taxable_amount_valueeee_new1; 
                    $taxable_amount_new = number_format($taxable_amount_valueeee_new1_format, 2);
                    // print_r($taxable_amount_valueeee_new1);
                    // die();          
                    $sgst_amt_fromat += $sgst_amt; 
                    $sgst_amt_fromat_new = number_format($sgst_amt_fromat, 2);

                    $cgst_amt_fromat += $cgst_amt;
                    $cgst_amt_fromat_new = number_format($cgst_amt_fromat, 2);

                    $igst_amt_fromat += $igst_amt;   
                    $igst_amt_fromat_new = number_format($igst_amt_fromat, 2);

                    $total_amount_with_gst_new = $taxable_amount_valueeee_new1 + $cgst_amt + $sgst_amt +  $igst_amt; 

                    $final_amount  += $total_amount_with_gst_new;
                    $final_amount_new = number_format($final_amount, 2);
                    $this->load->library('numbertowordconvertsconver');
                    $Final_invoice_amount_in_word = $this->numbertowordconvertsconver->convert_number($final_amount);
                      $html .=  '<table style="border-collapse: collapse;">
                                  <tr style="border: none;">
                                    <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a; width: 7%; font-size: 7.5px;text-indent:1em;">'.strip_tags($i).'<br></td>

                                    <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a; width: 15%; font-size: 7.5px;text-indent:1em;"><b>'.strip_tags($PRODUCT_ID).'</b><br>&nbsp;'.strip_tags($Hsn_code).'<br></td>

                                  <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a; width: 35%; font-size: 7.5px;text-indent:1em;"><b>'.strip_tags($product_name).'</b><br> '.html_entity_decode($data).'<br></td>

                                  <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a; width: 6%; font-size: 7.5px;text-indent:1em;">'.strip_tags($rfq_qty).'<br></td>

                                  <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a; width: 9%; font-size: 7.5px;text-indent:1em;">'.strip_tags($price_new).'<br></td>

                                  <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a; width: 10%; font-size: 7.5px;text-indent:1em;">'.strip_tags($discount).' %<br></td>

                                  <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a; width: 8%; font-size: 7.5px;text-indent:1em;">'.strip_tags($total_gst_percentage).' %<br>&nbsp;'.strip_tags($total_gst_percentage_amount).'<br></td>

                                  <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a; width: 10%; font-size: 7.5px;text-indent:1em;">'.strip_tags($total_amount_with_gst_new_format).'<br></td>
                                  </tr>

                                </table>';
                        $i++;  
                }

                if ($data_offer_product_count % 2 == 0) 
                { 
                    //if is divisible for 3, put the blanck row
                    $html .='<table style="border-collapse: collapse;"> 
                    
                
                        <tr>                                   
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 7%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 15%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 35%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 6%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 9%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 10%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 8%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 10%;">&nbsp;</td>
                    </tr>

                    <tr>                                   
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 7%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 15%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 35%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 6%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 9%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 10%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 8%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 10%;">&nbsp;</td>
                    </tr>

                    </table>'; 

                $html .= '<table style="border: solid 1px #5a5a5a;" width="100%">
                    
                </table>';   
                    
                } 
                $html .='<br><br><table border="0.3" cellpadding="3" cellspacing="0" width="100%">  
                    
                    <tr>                                   
                        <td colspan="4" style="width: 75%; font-size: 7.5px;"><br><br><b>In Words : '.strip_tags($Final_invoice_amount_in_word).'</b></td>
                        
                        <td style="width: 13%; font-size: 7px; text-align:right;">Taxable Amount<br>CGST<br>SGST<br>IGST<br><b>Grand Total</b></td>
                        <td style="width: 12%; font-size: 7px; text-align:right;">'.strip_tags($taxable_amount_new).'<br>'.strip_tags($cgst_amt_fromat_new).'<br>'.strip_tags($sgst_amt_fromat_new).'<br>'.strip_tags($igst_amt_fromat_new).'<br><b>'.strip_tags($final_amount_new).'</b></td>
                    </tr>
                    
                    
                    </table>';   
            }

            if($data_offer_product_count === 3)  
            {
                $final_amount = 0;
                $sgst_amt_fromat = 0;
                $cgst_amt_fromat = 0;
                $igst_amt_fromat = 0;
                $total_amount_with_gst_final = 0;
                 $price_format = 0;
                 $taxable_amount_valueeee_new1_format = 0;
                 $i=1;
                foreach ($data_offer_product as $value_data) 
                {
                    $Entity_id = $value_data['Entity_id'];
                    $PRODUCT_ID = $value_data['PRODUCT_ID'];
                    $product_name = $value_data['product_name'];
                    $Hsn_code = $value_data['Hsn_code'];
                    $rfq_qty = $value_data['rfq_qty']; 
                    $price = $value_data['price']; 
                    $price_new = number_format($price, 2);
                    $product_custom_description = $value_data['product_custom_description']; 
                    $product_custom_description_format = explode("#",$product_custom_description);

                    $data = "";
                    foreach ($product_custom_description_format as $key => $value){

                        $file_name = $value;
                        $data .= $file_name.'<br>';
                        // print_r($data);
                        // die();
                    } 

                    $price_format_new = number_format($price, 2);
                    $discount = $value_data['discount'];   
                    $discount_amt = $value_data['discount_amt'];   
                    // print_r($discount_amt);
                    // die();
                    $sgst_discount = $value_data['sgst_discount'];   
                    $sgst_amt = $value_data['sgst_amt']; 


                    $cgst_discount = $value_data['cgst_discount'];   
                    $cgst_amt = $value_data['cgst_amt']; 


                    $igst_discount = $value_data['igst_discount'];   
                    $igst_amt = $value_data['igst_amt'];

                    $total_gst_percentage = $sgst_discount + $cgst_discount + $igst_discount;

                    $total_gst_percentage_amount = $sgst_amt + $cgst_amt + $igst_amt;
                    $new_amount = $total_gst_percentage_amount + $price;

                    $total_amount_with_gst = $value_data['total_amount_with_gst']; 

                    $total_amount_with_gst_new_format = number_format($total_amount_with_gst, 2);

                    $total_amount_with_gst_final += $total_amount_with_gst;  
                    //$total_amount_with_gst_final_new = number_format($total_amount_with_gst_final);
                    $total_amount_with_gst_final_new = number_format($total_amount_with_gst_final, 2);

                    $price_format += $price; 
                    $price_format_new = number_format($price_format, 2);

                    $taxable_amount_valueeee = $price * $rfq_qty; 

                    $taxable_amount_valueeee_new = $taxable_amount_valueeee * $discount / 100; 
                    // print_r($taxable_amount_valueeee_new);
                    // die(); 

                    $taxable_amount_valueeee_new1 = $taxable_amount_valueeee - $taxable_amount_valueeee_new;

                    $taxable_amount_valueeee_new1_format += $taxable_amount_valueeee_new1; 
                    $taxable_amount_new = number_format($taxable_amount_valueeee_new1_format, 2);
                    // print_r($taxable_amount_valueeee_new1);
                    // die();          
                    $sgst_amt_fromat += $sgst_amt; 
                    $sgst_amt_fromat_new = number_format($sgst_amt_fromat, 2);

                    $cgst_amt_fromat += $cgst_amt;
                    $cgst_amt_fromat_new = number_format($cgst_amt_fromat, 2);

                    $igst_amt_fromat += $igst_amt;   
                    $igst_amt_fromat_new = number_format($igst_amt_fromat, 2);

                    $total_amount_with_gst_new = $taxable_amount_valueeee_new1 + $cgst_amt + $sgst_amt +  $igst_amt; 

                    $final_amount  += $total_amount_with_gst_new;
                    $final_amount_new = number_format($final_amount, 2);
                    $this->load->library('numbertowordconvertsconver');
                    $Final_invoice_amount_in_word = $this->numbertowordconvertsconver->convert_number($final_amount);
                      $html .=  '<table style="border-collapse: collapse;">
                                  <tr style="border: none;">
                                    <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a; width: 7%; font-size: 7.5px;text-indent:1em;">'.strip_tags($i).'<br></td>

                                    <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a; width: 15%; font-size: 7.5px;text-indent:1em;"><b>'.strip_tags($PRODUCT_ID).'</b><br>&nbsp;'.strip_tags($Hsn_code).'<br></td>

                                  <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a; width: 35%; font-size: 7.5px;text-indent:1em;"><b>'.strip_tags($product_name).'</b><br> '.html_entity_decode($data).'<br></td>

                                  <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a; width: 6%; font-size: 7.5px;text-indent:1em;">'.strip_tags($rfq_qty).'<br></td>

                                  <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a; width: 9%; font-size: 7.5px;text-indent:1em;">'.strip_tags($price_new).'<br></td>

                                  <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a; width: 10%; font-size: 7.5px;text-indent:1em;">'.strip_tags($discount).' %<br></td>

                                  <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a; width: 8%; font-size: 7.5px;text-indent:1em;">'.strip_tags($total_gst_percentage).' %<br>&nbsp;'.strip_tags($total_gst_percentage_amount).'<br></td>

                                  <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a; width: 10%; font-size: 7.5px;text-indent:1em;">'.strip_tags($total_amount_with_gst_new_format).'<br></td>
                                  </tr>

                                </table>';
                        $i++;  
                }

                if ($data_offer_product_count % 3 == 0) 
                { 
                    //if is divisible for 3, put the blanck row
                    $html .='<table style="border-collapse: collapse;"> 
                    
                
                        <tr>                                   
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 7%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 15%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 35%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 6%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 9%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 10%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 8%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 10%;">&nbsp;</td>
                    </tr>

                    
                    </table>'; 

                $html .= '<table style="border: solid 1px #5a5a5a;" width="100%">
                    
                </table>';      
                    
                } 
                $html .='<br><br><table border="0.1"  cellpadding="3" cellspacing="0" width="100%">  
                    
                    <tr>                                   
                        <td colspan="4" style="width: 75%; font-size: 7.5px;"><br><br><b>In Words : '.strip_tags($Final_invoice_amount_in_word).'</b></td>
                        
                        <td style="width: 13%; font-size: 7px; text-align:right;">Taxable Amount<br>CGST<br>SGST<br>IGST<br><b>Grand Total</b></td>
                        <td style="width: 12%; font-size: 7px; text-align:right;">'.strip_tags($taxable_amount_new).'<br>'.strip_tags($cgst_amt_fromat_new).'<br>'.strip_tags($sgst_amt_fromat_new).'<br>'.strip_tags($igst_amt_fromat_new).'<br><b>'.strip_tags($final_amount_new).'</b></td>
                    </tr>
                    
                    
                    </table>';   
            }

            if($data_offer_product_count === 4)  
            {
                $final_amount = 0;
                $sgst_amt_fromat = 0;
                $cgst_amt_fromat = 0;
                $igst_amt_fromat = 0;
                $total_amount_with_gst_final = 0;
                 $price_format = 0;
                 $taxable_amount_valueeee_new1_format = 0;
                 $i=1;
                foreach ($data_offer_product as $value_data) 
                {
                    $Entity_id = $value_data['Entity_id'];
                    $PRODUCT_ID = $value_data['PRODUCT_ID'];
                    $product_name = $value_data['product_name'];
                    $Hsn_code = $value_data['Hsn_code'];
                    $rfq_qty = $value_data['rfq_qty']; 
                    $price = $value_data['price']; 
                    $price_new = number_format($price, 2);
                    $product_custom_description = $value_data['product_custom_description']; 
                    $product_custom_description_format = explode("#",$product_custom_description);

                    $data = "";
                    foreach ($product_custom_description_format as $key => $value){

                        $file_name = $value;
                        $data .= $file_name.'<br>';
                        // print_r($data);
                        // die();
                    }

                    //$product_custom_description_format = substr($product_custom_description,0,60); 

                    $price_format_new = number_format($price, 2);
                    $discount = $value_data['discount'];   
                    $discount_amt = $value_data['discount_amt'];   
                    // print_r($discount_amt);
                    // die();
                    $sgst_discount = $value_data['sgst_discount'];   
                    $sgst_amt = $value_data['sgst_amt']; 


                    $cgst_discount = $value_data['cgst_discount'];   
                    $cgst_amt = $value_data['cgst_amt']; 


                    $igst_discount = $value_data['igst_discount'];   
                    $igst_amt = $value_data['igst_amt'];

                    $total_gst_percentage = $sgst_discount + $cgst_discount + $igst_discount;

                    $total_gst_percentage_amount = $sgst_amt + $cgst_amt + $igst_amt;
                    $new_amount = $total_gst_percentage_amount + $price;

                    $total_amount_with_gst = $value_data['total_amount_with_gst']; 

                    $total_amount_with_gst_new_format = number_format($total_amount_with_gst, 2);

                    $total_amount_with_gst_final += $total_amount_with_gst;  
                    //$total_amount_with_gst_final_new = number_format($total_amount_with_gst_final);
                    $total_amount_with_gst_final_new = number_format($total_amount_with_gst_final, 2);

                    $price_format += $price; 
                    $price_format_new = number_format($price_format, 2);

                    $taxable_amount_valueeee = $price * $rfq_qty; 

                    $taxable_amount_valueeee_new = $taxable_amount_valueeee * $discount / 100; 
                    // print_r($taxable_amount_valueeee_new);
                    // die(); 

                    $taxable_amount_valueeee_new1 = $taxable_amount_valueeee - $taxable_amount_valueeee_new;

                    $taxable_amount_valueeee_new1_format += $taxable_amount_valueeee_new1; 
                    $taxable_amount_new = number_format($taxable_amount_valueeee_new1_format, 2);
                    // print_r($taxable_amount_valueeee_new1);
                    // die();          
                    $sgst_amt_fromat += $sgst_amt; 
                    $sgst_amt_fromat_new = number_format($sgst_amt_fromat, 2);

                    $cgst_amt_fromat += $cgst_amt;
                    $cgst_amt_fromat_new = number_format($cgst_amt_fromat, 2);

                    $igst_amt_fromat += $igst_amt;   
                    $igst_amt_fromat_new = number_format($igst_amt_fromat, 2);

                    $total_amount_with_gst_new = $taxable_amount_valueeee_new1 + $cgst_amt + $sgst_amt +  $igst_amt; 

                    $final_amount  += $total_amount_with_gst_new;
                    $final_amount_new = number_format($final_amount, 2);
                    $this->load->library('numbertowordconvertsconver');
                    $Final_invoice_amount_in_word = $this->numbertowordconvertsconver->convert_number($final_amount);
                      $html .=  '<table style="border-collapse: collapse;">
                                  <tr style="border: none;">
                                    <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a; width: 7%; font-size: 7.5px;text-indent:1em;">'.strip_tags($i).'<br></td>

                                    <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a; width: 15%; font-size: 7.5px;text-indent:1em;"><b>'.strip_tags($PRODUCT_ID).'</b><br>&nbsp;'.strip_tags($Hsn_code).'<br></td>

                                  <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a; width: 35%; font-size: 7.5px;text-indent:1em;"><b>'.strip_tags($product_name).'</b><br> '.html_entity_decode($data).'<br></td>

                                  <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a; width: 6%; font-size: 7.5px;text-indent:1em;">'.strip_tags($rfq_qty).'<br></td>

                                  <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a; width: 9%; font-size: 7.5px;text-indent:1em;">'.strip_tags($price_new).'<br></td>

                                  <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a; width: 10%; font-size: 7.5px;text-indent:1em;">'.strip_tags($discount).' %<br></td>

                                  <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a; width: 8%; font-size: 7.5px;text-indent:1em;">'.strip_tags($total_gst_percentage).' %<br>&nbsp;'.strip_tags($total_gst_percentage_amount).'<br></td>

                                  <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a; width: 10%; font-size: 7.5px;text-indent:1em;">'.strip_tags($total_amount_with_gst_new_format).'<br></td>
                                  </tr>

                                </table>';
                        $i++;  
                }

                if ($data_offer_product_count % 4 == 0) 
                { 
                    //if is divisible for 3, put the blanck row
                    $html .='<table style="border-collapse: collapse;"> 
                    
                
                        <tr>                                   
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 7%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 15%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 35%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 6%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 9%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 10%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 8%;">&nbsp;</td>
                        <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a;width: 10%;">&nbsp;</td>
                    </tr>

                    
                    </table>'; 

                $html .= '<table style="border: solid 1px #5a5a5a;" width="100%">
                    
                </table>';   
                    
                } 
                $html .='<br><br><table border="0.3" cellpadding="3" cellspacing="0" width="100%">  
                    
                    <tr>                                   
                        <td colspan="4" style="width: 75%; font-size: 7.5px;"><br><br><b>In Words : '.strip_tags($Final_invoice_amount_in_word).'</b></td>
                        
                        <td style="width: 13%; font-size: 7px; text-align:right;">Taxable Amount<br>CGST<br>SGST<br>IGST<br><b>Grand Total</b></td>
                        <td style="width: 12%; font-size: 7px; text-align:right;">'.strip_tags($taxable_amount_new).'<br>'.strip_tags($cgst_amt_fromat_new).'<br>'.strip_tags($sgst_amt_fromat_new).'<br>'.strip_tags($igst_amt_fromat_new).'<br><b>'.strip_tags($final_amount_new).'</b></td>
                    </tr>
                    
                    
                    </table>';   
            }


            if($data_offer_product_count >= 5)  
            {
                $final_amount = 0;
                $sgst_amt_fromat = 0;
                $cgst_amt_fromat = 0;
                $igst_amt_fromat = 0;
                $total_amount_with_gst_final = 0;
                 $price_format = 0;
                 $taxable_amount_valueeee_new1_format = 0;
                 $i=1;
                foreach ($data_offer_product as $value_data) 
                {
                    $Entity_id = $value_data['Entity_id'];
                    $PRODUCT_ID = $value_data['PRODUCT_ID'];
                    $product_name = $value_data['product_name'];
                    $Hsn_code = $value_data['Hsn_code'];
                    $rfq_qty = $value_data['rfq_qty']; 
                    $price = $value_data['price']; 
                    $price_new = number_format($price, 2);
                    $product_custom_description = $value_data['product_custom_description']; 
                    $product_custom_description_format = explode("#",$product_custom_description);

                    $data = "";
                    foreach ($product_custom_description_format as $key => $value){

                        $file_name = $value;
                        $data .= $file_name.'<br>';
                        // print_r($data);
                        // die();
                    } 

                    $price_format_new = number_format($price, 2);
                    $discount = $value_data['discount'];   
                    $discount_amt = $value_data['discount_amt'];   
                    // print_r($discount_amt);
                    // die();
                    $sgst_discount = $value_data['sgst_discount'];   
                    $sgst_amt = $value_data['sgst_amt']; 


                    $cgst_discount = $value_data['cgst_discount'];   
                    $cgst_amt = $value_data['cgst_amt']; 


                    $igst_discount = $value_data['igst_discount'];   
                    $igst_amt = $value_data['igst_amt'];

                    $total_gst_percentage = $sgst_discount + $cgst_discount + $igst_discount;

                    $total_gst_percentage_amount = $sgst_amt + $cgst_amt + $igst_amt;
                    $new_amount = $total_gst_percentage_amount + $price;

                    $total_amount_with_gst = $value_data['total_amount_with_gst']; 

                    $total_amount_with_gst_new_format = number_format($total_amount_with_gst, 2);

                    $total_amount_with_gst_final += $total_amount_with_gst;  
                    //$total_amount_with_gst_final_new = number_format($total_amount_with_gst_final);
                    $total_amount_with_gst_final_new = number_format($total_amount_with_gst_final, 2);

                    $price_format += $price; 
                    $price_format_new = number_format($price_format, 2);

                    $taxable_amount_valueeee = $price * $rfq_qty; 

                    $taxable_amount_valueeee_new = $taxable_amount_valueeee * $discount / 100; 
                    // print_r($taxable_amount_valueeee_new);
                    // die(); 

                    $taxable_amount_valueeee_new1 = $taxable_amount_valueeee - $taxable_amount_valueeee_new;

                    $taxable_amount_valueeee_new1_format += $taxable_amount_valueeee_new1; 
                    $taxable_amount_new = number_format($taxable_amount_valueeee_new1_format, 2);
                    // print_r($taxable_amount_valueeee_new1);
                    // die();          
                    $sgst_amt_fromat += $sgst_amt; 
                    $sgst_amt_fromat_new = number_format($sgst_amt_fromat, 2);

                    $cgst_amt_fromat += $cgst_amt;
                    $cgst_amt_fromat_new = number_format($cgst_amt_fromat, 2);

                    $igst_amt_fromat += $igst_amt;   
                    $igst_amt_fromat_new = number_format($igst_amt_fromat, 2);

                    $total_amount_with_gst_new = $taxable_amount_valueeee_new1 + $cgst_amt + $sgst_amt +  $igst_amt; 

                    $final_amount  += $total_amount_with_gst_new;
                    $final_amount_new = number_format($final_amount, 2);
                    $this->load->library('numbertowordconvertsconver');
                    $Final_invoice_amount_in_word = $this->numbertowordconvertsconver->convert_number($final_amount);
                      $html .=  '<table style="border-collapse: collapse;">
                                  <tr style="border: none;">
                                    <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a; width: 7%; font-size: 7.5px;text-indent:1em;">'.strip_tags($i).'<br></td>

                                    <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a; width: 15%; font-size: 7.5px;text-indent:1em;"><b>'.strip_tags($PRODUCT_ID).'</b><br>&nbsp;'.strip_tags($Hsn_code).'<br></td>

                                  <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a; width: 35%; font-size: 7.5px;text-indent:1em;"><b>'.strip_tags($product_name).'</b><br> '.html_entity_decode($data).'<br></td>

                                  <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a; width: 6%; font-size: 7.5px;text-indent:1em;">'.strip_tags($rfq_qty).'<br></td>

                                  <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a; width: 9%; font-size: 7.5px;text-indent:1em;">'.strip_tags($price_new).'<br></td>

                                  <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a; width: 10%; font-size: 7.5px;text-indent:1em;">'.strip_tags($discount).' %<br></td>

                                  <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a; width: 8%; font-size: 7.5px;text-indent:1em;">'.strip_tags($total_gst_percentage).' %<br>&nbsp;'.strip_tags($total_gst_percentage_amount).'<br></td>

                                  <td style="border-right: solid 1px #5a5a5a; 
                                  border-left: solid 1px #5a5a5a; width: 10%; font-size: 7.5px;text-indent:1em;">'.strip_tags($total_amount_with_gst_new_format).'<br></td>
                                  </tr>

                                </table>';
                        $i++;  
                }
                $html .='<br><br><table border="0.3" cellpadding="3" cellspacing="0" width="100%">  
                    
                    <tr>                                   
                        <td colspan="4" style="width: 75%; font-size: 7.5px;"><br><br><b>In Words : '.strip_tags($Final_invoice_amount_in_word).'</b></td>
                        
                        <td style="width: 13%; font-size: 7px; text-align:right;">Taxable Amount<br>CGST<br>SGST<br>IGST<br><b>Grand Total</b></td>
                        <td style="width: 12%; font-size: 7px; text-align:right;">'.strip_tags($taxable_amount_new).'<br>'.strip_tags($cgst_amt_fromat_new).'<br>'.strip_tags($sgst_amt_fromat_new).'<br>'.strip_tags($igst_amt_fromat_new).'<br><b>'.strip_tags($final_amount_new).'</b></td>
                    </tr>
                    
                    
                    </table>';   
            }

            $pdf->writeHTML($html, true, false, true, false, '');

            $html ='<table border="0.3" cellpadding="3" width="100%">
                        <tr style="background-color: #C0C0C0;">
                          <td style="font-size: 12px; width: 100%; text-indent:1em;"><h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Terms & Conditions</h5></td>
                          
                        </tr>
                        <tr >
                          <td style="font-size: 8px; width: 100%; text-indent:1em;">&nbsp;&nbsp;<b>Price Basis&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b> '.strip_tags($Price_basis).'<br>

                              &nbsp;<b>Tax&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b> '.strip_tags($Tax).'<br>

                              &nbsp;<b>Delivery Schedule&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b> '.strip_tags($Delivery_schedule).'<br>

                              &nbsp;<b>Mode of Payment&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b> '.strip_tags($Mode_of_payment).'<br>

                              &nbsp;<b>Mode of Transport&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b> '.strip_tags($Mode_of_transport).'<br>

                              &nbsp;<b>Packing & Forwarding&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b> '.strip_tags($packing_forwarding).'<br>

                              &nbsp;<b>Terms of Payment&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b> '.strip_tags($payment_term).'<br>

                              &nbsp;<b>Guarantee/Waranty&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b> '.strip_tags($Guarantee_warrenty).'<br>

                              &nbsp;<b>Transportation & Insurance&nbsp;&nbsp;&nbsp;&nbsp;</b> '.strip_tags($Transport_insurance).'</td>

                          

                         </tr>
                    </table>';

            $pdf->writeHTML($html, true, false, true, false, '');    

            if(!empty($note)){     
                $html ='<br><table border="0.3" cellpadding="3" width="100%">
                            <tr >
                              <td style="font-size: 7px; width: 100%; text-indent:1em;"><b>Note : '.strip_tags($note).'</b>
                              </td>
                             </tr>
                        </table>';

                $pdf->writeHTML($html, true, false, true, false, '');
            }
             
            $html ='<br><table border="0.3" cellpadding="3" width="100%">
                        <tr>
                          <td style="font-size: 7px; width: 100%; text-align:right;"><br><b>&nbsp;&nbsp;For Maitry Instruments & Control</b>
                                <br><br><br><b>&nbsp;&nbsp;Authrised Signatory</b></td>
                         </tr>
                    </table>';

            $pdf->writeHTML($html, true, false, true, false, '');
            $pdf->Output('offer'.date('Y-m-d-H:i:s').'.pdf', 'I');        
        }
    }
?>
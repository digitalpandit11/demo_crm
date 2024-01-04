<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ob_start();
class Sales_order_register extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('sales_order_register_model');
        $this->load->library('session');
    }

    public function index()
    {
        $data['order_details'] = $this->sales_order_register_model->get_all_order_details();
        $this->load->view('sales/sales_order_register/vw_sales_order_register_index',$data);
    }

    public function vw_all_sales_order_data()
    {
        $data['order_details'] = $this->sales_order_register_model->get_all_order();
        $this->load->view('sales/sales_order_register/vw_all_sales_order_register_index',$data);
    }

    public function create_customer_sales_order()
    {
        $data['pending_offer'] = $this->sales_order_register_model->get_pending_offer();
        $this->load->view('sales/sales_order_register/vw_pending_offer_index',$data);
    }

    public function offer_to_order_save()
    {
        $entity_id = $this->uri->segment(2);
        $offer_data = $this->sales_order_register_model->offer_to_order_save_model($entity_id);
        $data['entity_id'] = $entity_id;
        $data['offer_result'] = $offer_data;
        $data['customer_list'] = $this->sales_order_register_model->get_customer_list();

        $data['employee_list'] = $this->sales_order_register_model->get_employee_list();
        $data['payment_term_list'] = $this->sales_order_register_model->get_payment_term_list();
        $data['product_list'] = $this->sales_order_register_model->get_product_list();
        /*$data['ship_to_data_list'] = $this->sales_order_register_model->ship_to_data_list_model($entity_id);*/
        // print_r($data['ship_to_data_list']);
        // die();

        $data['ship_to_party'] = $this->sales_order_register_model->get_ship_to_party();
        $data['bill_to_party'] = $this->sales_order_register_model->get_bill_to_party();

        /*$data['bill_to_data_list'] = $this->sales_order_register_model->bill_to_data_list_model($entity_id);*/
        $data['order_product_list'] = $this->sales_order_register_model->get_order_product_list($entity_id);
        $data['order_accessories_list'] = $this->sales_order_register_model->get_order_accessories_list($entity_id);
        $data['accessories_list'] = $this->sales_order_register_model->get_accessories_list($entity_id);

        $data['product_category'] = $this->sales_order_register_model->get_product_category();
        $data['product_detail_hsn_code'] = $this->sales_order_register_model->get_product_hsn_code();
        $this->load->view('sales/sales_order_register/vw_sales_order_register_create',$data);
    }

    public function get_ship_to_party_data()
    {
        $data = $this->input->post();
        if(!empty($data))
        {
            $ship_to_id = $this->input->post('id');
            $offer_entity_id = $this->input->post('entity_id');
            $data = $this->sales_order_register_model->get_all_ship_to_party_data($ship_to_id,$offer_entity_id);
            echo json_encode($data);
        }
    }

    public function get_bill_to_party_data()
    {
        $data = $this->input->post();
        if(!empty($data))
        {
            $bill_to_id = $this->input->post('id');
            $offer_entity_id = $this->input->post('entity_id');
            $data = $this->sales_order_register_model->get_all_bill_to_party_data($bill_to_id,$offer_entity_id);
            echo json_encode($data);
        }
    }

    public function get_ship_to_party_data_update_page()
    {
        $data = $this->input->post();
        if(!empty($data))
        {
            $ship_to_id = $this->input->post('id');
            $order_entity_id = $this->input->post('entity_id');
            $data = $this->sales_order_register_model->get_all_ship_to_party_data_update_page($ship_to_id,$order_entity_id);
            echo json_encode($data);
        }
    }

    public function get_bill_to_party_data_update_page()
    {
        $data = $this->input->post();
        if(!empty($data))
        {
            $bill_to_id = $this->input->post('id');
            $order_entity_id = $this->input->post('entity_id');
            $data = $this->sales_order_register_model->get_all_bill_to_party_data_update_page($bill_to_id,$order_entity_id);
            echo json_encode($data);
        }
    }

    public function save_order_accessories()
    {
        $offer_entity_id = $this->input->post('entity_id');
        $sales_order_product_id = $this->input->post('accessories_for');
        $accessories_id = $this->input->post('accessories');
        $accessories_rate = $this->input->post('accessories_rate');
        $accessories_qty = $this->input->post('accessories_qty');

        $this->db->select('*');
        $this->db->from('sales_order_register');
        $where = '(sales_order_register.offer_id = "'.$offer_entity_id.'" )';
        $this->db->where($where);
        $this->db->order_by('sales_order_register.entity_id', 'DESC');
        $this->db->limit(1);
        $query_data = $this->db->get();
        $query_result = $query_data->row_array();

        $order_entity_id = $query_result['entity_id'];
        $order_customer_id = $query_result['customer_id'];

        $this->db->select('product_master.*,
                product_hsn_master.hsn_code,
                product_hsn_master.total_gst_percentage,
                product_hsn_master.cgst,
                product_hsn_master.sgst,
                product_hsn_master.igst');
        $this->db->from('product_master');
        $this->db->join('product_hsn_master', 'product_master.hsn_id = product_hsn_master.entity_id', 'INNER');
        $where = '(product_master.entity_id = "'.$accessories_id.'" )';
        $this->db->where($where);
        $product_master = $this->db->get();
        $product_master_result = $product_master->row();

        $total_amount_without_gst = $accessories_qty * $accessories_rate;
        $discount = 0;
        $discount_amt = 0;
        $unit_discounted_price = $total_amount_without_gst - $discount_amt;

        $this->db->select('*');
        $this->db->from('customer_master');
        $where = '(customer_master.entity_id = "'.$order_customer_id.'")';
        $this->db->where($where);
        $customer_address_master = $this->db->get();
        $customer_address_master_result = $customer_address_master->row();

        $state_code = $customer_address_master_result->state_code;

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


        $order_product_accessories_relation_save = "INSERT INTO sales_order_accessories_relation (sales_order_id , sales_order_product_id , product_id , qty , price , total_amount_without_gst , cgst_percentage , sgst_percentage , igst_percentage , cgst_amount , sgst_amount , igst_amount , total_amount_with_gst , discount , discount_amount , unit_discounted_price) VALUES ('".$order_entity_id."' , '".$sales_order_product_id."' , '".$accessories_id."' , '".$accessories_qty."' , '".$accessories_rate."' , '".$total_amount_without_gst."' , '".$cgst_percentage."' , '".$sgst_percentage."' , '".$igst_percentage."' , '".$cgst_amount."' , '".$sgst_amount."' , '".$igst_amount."' , '".$total_amount."' , '".$discount."' , '".$discount_amt."' , '".$unit_discounted_price."')";
        $save_order_product_relation = $this->db->query($order_product_accessories_relation_save);
    }

    public function get_order_details_by_id()
    {
        $entity_id = $this->input->post('entity_id',TRUE);
        $data = $this->sales_order_register_model->get_order_details_by_id_model($entity_id)->result();
        echo json_encode($data);
    }

    public function get_all_customer_address_data()
    {
        $data = $this->input->post();
        if(!empty($data))
        {
            $customer_id = $this->input->post('id');
            $data = $this->sales_order_register_model->get_all_customer_address_data_by_id($customer_id);
            echo json_encode([$data]);
        }
    }

    public function update_order_from_offer()
    {
        $offer_entity_id = $this->input->post('offer_entity_id');
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
        $sales_order_type = $this->input->post('sales_order_type');

        $this->db->select('*');
        $this->db->from('sales_order_register');
        $where = '(sales_order_register.offer_id = "'.$offer_entity_id.'" )';
        $this->db->where($where);
        $this->db->order_by('sales_order_register.entity_id', 'DESC');
        $this->db->limit(1);
        $query_data = $this->db->get();
        $query_result = $query_data->row_array();

        $order_entity_id = $query_result['entity_id'];
        $order_customer_id = $query_result['customer_id'];

        $update_order_array = array('sales_order_description' => $order_descrption , 'order_engg_name' => $employee_id , 'terms_conditions' => $order_terms_condition , 'delivery_period' => $delivery_period , 'transportation' => $order_freight , 'transportation_price' => $freight_charges , 'dispatch_address' => $dispatch_address , 'delivery_instruction' => $delivery_instruction , 'packing_forwarding' => $packing_forwarding , 'packing_forwarding_price' => $packing_forwarding_charges , 'payment_term' => $payment_term , 'special_packing' => $special_instruction , 'insurance' => $order_insurance , 'insurance_price' => $insurance_charges, 'salutation' => $salutation, 'price_basis' => $price_basis, 'transport_insurance' => $transport_insurance, 'tax' => $tax, 'delivery_schedule' => $delivery_schedule, 'mode_of_payment' => $mode_of_payment, 'mode_of_transport' => $mode_of_transport, 'guarantee_warrenty' => $guarantee_warrenty, 'special_customer' => $special_customer, 'sales_order_type' => $sales_order_type);

        $where = '(entity_id ="'.$order_entity_id.'")';
        $this->db->where($where);
        $this->db->update('sales_order_register',$update_order_array);

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
            $this->db->from('customer_master');
            $where = '(customer_master.entity_id = "'.$order_customer_id.'")';
            $this->db->where($where);
            $customer_address_master = $this->db->get();
            $customer_address_master_result = $customer_address_master->row();

            $state_code = $customer_address_master_result->state_code;

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

            $this->db->select('sales_order_id');
            $this->db->from('sales_order_product_relation');
            $where_or = '(product_id = "'.$product_id.'" AND sales_order_id = "'.$order_entity_id.'")';
            $this->db->where($where_or);
            $order_product_exit= $this->db->get();
            $order_product_exit_data_count =  $order_product_exit->num_rows();

            if ($order_product_exit_data_count === 0) 
            {
                $order_product_relation_save = "INSERT INTO sales_order_product_relation (sales_order_id , product_id , rfq_qty , price , total_amount_without_gst , cgst_discount , sgst_discount , igst_discount , cgst_amount , sgst_amount , igst_amount , total_amount_with_gst , product_warranty , discount , discount_amt , unit_discounted_price) VALUES ('".$order_entity_id."' , '".$product_id."' , '".$rfq_qty."' , '".$price."' , '".$total_amount_without_gst."' , '".$cgst_percentage."' , '".$sgst_percentage."' , '".$igst_percentage."' , '".$cgst_amount."' , '".$sgst_amount."' , '".$igst_amount."' , '".$total_amount."' , '".$product_warrenty."' , '".$discount."' , '".$discount_amt."' , '".$unit_discounted_price."')";
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

    public function update_product_description()
    {
        $entity_id = $this->input->post('order_relation_entity_id');
        $product_desc = $this->input->post('product_desc');

        $update_array = array('entity_id' => $entity_id,'product_custom_description' => $product_desc);
        $data = $this->sales_order_register_model->update_order_product_relation($update_array);

        echo json_encode($data);
    }

    public function update_product_delivery_period()
    {
        $entity_id = $this->input->post('order_relation_entity_id');
        $delivery_period = $this->input->post('delivery_period');

        $update_array = array('entity_id' => $entity_id,'delivery_period' => $delivery_period);
        $data = $this->sales_order_register_model->update_order_product_relation($update_array);

        echo json_encode($data);
    }

    public function update_product_warranty()
    {
        $entity_id = $this->input->post('order_relation_entity_id');
        $warranty = $this->input->post('warranty');

        $update_array = array('entity_id' => $entity_id,'product_warranty' => $warranty);
        $data = $this->sales_order_register_model->update_order_product_relation($update_array);

        echo json_encode($data);
    }

    public function update_product_price()
    {
        $entity_id = $this->input->post('order_relation_entity_id');
        $price = $this->input->post('price');

        $this->db->select('*');
        $this->db->from('sales_order_product_relation');
        $where = '(sales_order_product_relation.entity_id = "'.$entity_id.'")';
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
        $data = $this->sales_order_register_model->update_order_product_relation($update_array);

        echo json_encode($data);
    }

    public function update_accessories_price()
    {
        $entity_id = $this->input->post('order_accessories_relation_entity_id');
        $accessories_price = $this->input->post('accessories_price');

        $this->db->select('*');
        $this->db->from('sales_order_accessories_relation');
        $where = '(sales_order_accessories_relation.entity_id = "'.$entity_id.'")';
        $this->db->where($where);
        $order_accessories_relation = $this->db->get();
        $order_accessories_relation_result = $order_accessories_relation->row();

        $accessories_qty = $order_accessories_relation_result->qty;
        $accessories_basic_value = $accessories_qty * $accessories_price;

        $accessories_discount = $order_accessories_relation_result->discount;

        $accessories_discounted_amount = $accessories_basic_value * $accessories_discount/100;

        $total_without_gst = $accessories_basic_value - $accessories_discounted_amount;

        $unit_discounted_price = $total_without_gst/$accessories_qty;

        $cgst_percentage = $order_accessories_relation_result->cgst_percentage;
        $sgst_percentage = $order_accessories_relation_result->sgst_percentage;
        $igst_percentage = $order_accessories_relation_result->igst_percentage;

        $cgst_amount = $total_without_gst * $cgst_percentage/100;
        $sgst_amount = $total_without_gst * $sgst_percentage/100;
        $igst_amount = $total_without_gst * $igst_percentage/100;

        $total_amount = $total_without_gst + $cgst_amount + $sgst_amount + $igst_amount;

        $update_array = array('entity_id' => $entity_id , 'price' => $accessories_price , 'discount_amount' => $accessories_discounted_amount , 'unit_discounted_price' => $unit_discounted_price , 'total_amount_without_gst' => $total_without_gst , 'cgst_amount' => $cgst_amount , 'sgst_amount' => $sgst_amount , 'igst_amount' => $igst_amount , 'total_amount_with_gst' => $total_amount);
        $data = $this->sales_order_register_model->update_order_accessories_relation($update_array);

        echo json_encode($data);
    }

    public function update_product_qty()
    {
        $entity_id = $this->input->post('order_relation_entity_id');
        $product_qty = $this->input->post('product_qty');

        $this->db->select('*');
        $this->db->from('sales_order_product_relation');
        $where = '(sales_order_product_relation.entity_id = "'.$entity_id.'")';
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
        $data = $this->sales_order_register_model->update_order_product_relation($update_array);

        echo json_encode($data);
    }

    public function update_accessories_qty()
    {
        $entity_id = $this->input->post('order_accessories_relation_entity_id');
        $accessories_qty = $this->input->post('accessories_qty');

        $this->db->select('*');
        $this->db->from('sales_order_accessories_relation');
        $where = '(sales_order_accessories_relation.entity_id = "'.$entity_id.'")';
        $this->db->where($where);
        $order_accessories_relation = $this->db->get();
        $order_accessories_relation_result = $order_accessories_relation->row();

        $accessories_price = $order_accessories_relation_result->price;
        $accessories_basic_value = $accessories_qty * $accessories_price;

        $accessories_discount = $order_accessories_relation_result->discount;

        $accessories_discounted_amount = $accessories_basic_value * $accessories_discount/100;

        $total_without_gst = $accessories_basic_value - $accessories_discounted_amount;

        $unit_discounted_price = $total_without_gst/$accessories_qty;

        $cgst_percentage = $order_accessories_relation_result->cgst_percentage;
        $sgst_percentage = $order_accessories_relation_result->sgst_percentage;
        $igst_percentage = $order_accessories_relation_result->igst_percentage;

        $cgst_amount = $total_without_gst * $cgst_percentage/100;
        $sgst_amount = $total_without_gst * $sgst_percentage/100;
        $igst_amount = $total_without_gst * $igst_percentage/100;

        $total_amount = $total_without_gst + $cgst_amount + $sgst_amount + $igst_amount;

        $update_array = array('entity_id' => $entity_id , 'qty' => $accessories_qty , 'discount_amount' => $accessories_discounted_amount , 'unit_discounted_price' => $unit_discounted_price , 'total_amount_without_gst' => $total_without_gst , 'cgst_amount' => $cgst_amount , 'sgst_amount' => $sgst_amount , 'igst_amount' => $igst_amount , 'total_amount_with_gst' => $total_amount);
        $data = $this->sales_order_register_model->update_order_accessories_relation($update_array);

        echo json_encode($data);
    }

    public function update_product_discount_percentage()
    {
        $entity_id = $this->input->post('order_relation_entity_id');
        $discount_percentage = $this->input->post('discount_percentage');

       $this->db->select('*');
        $this->db->from('sales_order_product_relation');
        $where = '(sales_order_product_relation.entity_id = "'.$entity_id.'")';
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
        $data = $this->sales_order_register_model->update_order_product_relation($update_array);

        echo json_encode($data);
    }

    public function update_accessories_discount_percentage()
    {
        $entity_id = $this->input->post('order_accessories_relation_entity_id');
        $discount_percentage = $this->input->post('accessories_discount_percentage');

       $this->db->select('*');
        $this->db->from('sales_order_accessories_relation');
        $where = '(sales_order_accessories_relation.entity_id = "'.$entity_id.'")';
        $this->db->where($where);
        $order_accessories_relation = $this->db->get();
        $order_accessories_relation_result = $order_accessories_relation->row();

        $accessories_price = $order_accessories_relation_result->price;
        $accessories_qty = $order_accessories_relation_result->qty;

        $accessories_basic_value = $accessories_qty * $accessories_price;

        $accessories_discounted_amount = $accessories_basic_value * $discount_percentage/100;

        $total_without_gst = $accessories_basic_value - $accessories_discounted_amount;

        $unit_discounted_price = $total_without_gst/$accessories_qty;

        $cgst_percentage = $order_accessories_relation_result->cgst_percentage;
        $sgst_percentage = $order_accessories_relation_result->sgst_percentage;
        $igst_percentage = $order_accessories_relation_result->igst_percentage;

        $cgst_amount = $total_without_gst * $cgst_percentage/100;
        $sgst_amount = $total_without_gst * $sgst_percentage/100;
        $igst_amount = $total_without_gst * $igst_percentage/100;

        $total_amount = $total_without_gst + $cgst_amount + $sgst_amount + $igst_amount;

        $update_array = array('entity_id' => $entity_id , 'discount' => $discount_percentage , 'discount_amount' => $accessories_discounted_amount , 'unit_discounted_price' => $unit_discounted_price , 'total_amount_without_gst' => $total_without_gst , 'cgst_amount' => $cgst_amount , 'sgst_amount' => $sgst_amount , 'igst_amount' => $igst_amount , 'total_amount_with_gst' => $total_amount);
        $data = $this->sales_order_register_model->update_order_accessories_relation($update_array);

        echo json_encode($data);
    }

    public function delete_order_product()
    {
        $entity_id = $this->input->post('id');
        $result = $this->sales_order_register_model->delete_order_product($entity_id);
        echo json_encode($result);
    }

    public function delete_order_accessories()
    {
        $entity_id = $this->input->post('id');
        $result = $this->sales_order_register_model->delete_order_accessories($entity_id);
        echo json_encode($result);
    }

    public function save_sales_order()
    {
        if(!empty($_FILES['order_attachment']))
        {
            $order_attachment_img = "";
            foreach ($_FILES as $key => $value) {
                
                $file_name = $value['name'];
                $file_source_path = $value['tmp_name'];
                $file_upload_combine_array = array_combine($file_name, $file_source_path);
                //print_r($file_upload_combine_array);
                
                foreach ($file_upload_combine_array as $image_name=> $image_source_path) {

                    $ext = pathinfo($image_name,PATHINFO_EXTENSION);

                    $order_attachment_upload = substr(str_replace(" ", "_", $image_name), 0);
                    move_uploaded_file($image_source_path, 'assets/order_attachment/'.$order_attachment_upload);

                    $order_attachment_img .= $order_attachment_upload.',';
                }  
            }
        }else{
            $order_attachment_img = NULL;
        }

        $offer_entity_id = $this->input->post('offer_entity_id');
        $product_checkbox = $this->input->post('product_checkbox');
        $order_descrption = $this->input->post('order_descrption');
        $employee_id = $this->input->post('employee_id');
        $terms_conditions = $this->input->post('terms_conditions');
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
        $purchase_order_number = $this->input->post('purchase_order_number');
        $purchase_order_date = $this->input->post('purchase_order_date');
        $special_customer = $this->input->post('special_customer');
        $sales_order_type = $this->input->post('sales_order_type');

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

        $this->db->select('*');
        $this->db->from('offer_register');
        $where = '(offer_register.entity_id = "'.$offer_entity_id.'" )';
        $this->db->where($where);
        $offer_register_data = $this->db->get();
        $offer_register_result = $offer_register_data->row_array();

        $enquiry_entity_id = $offer_register_result['enquiry_id'];

        $this->db->select('*');
        $this->db->from('sales_order_register');
        $where = '(sales_order_register.offer_id = "'.$offer_entity_id.'" )';
        $this->db->where($where);
        $this->db->order_by('sales_order_register.entity_id', 'DESC');
        $this->db->limit(1);
        $query_data = $this->db->get();
        $query_result = $query_data->row_array();

        $order_entity_id = $query_result['entity_id'];
        $order_customer_id = $query_result['customer_id'];

        $order_status = 2;

        $update_order_array = array('sales_order_description' => $order_descrption , 'order_engg_name' => $employee_id , 'special_customer' => $special_customer , 'terms_conditions' => $terms_conditions , 'delivery_period' => $delivery_period , 'transportation' => $order_freight , 'transportation_price' => $freight_charges , 'dispatch_address' => $dispatch_address , 'delivery_instruction' => $delivery_instruction , 'packing_forwarding' => $packing_forwarding , 'packing_forwarding_price' => $packing_forwarding_charges , 'payment_term' => $payment_term , 'special_packing' => $special_instruction , 'insurance' => $order_insurance , 'insurance_price' => $insurance_charges , 'po_no' => $purchase_order_number , 'po_date' => $purchase_order_date , 'attachment' => $order_attachment_img , 'status' => $order_status, 'price_basis' => $price_basis, 'salutation' => $salutation, 'transport_insurance' => $transport_insurance, 'tax' => $tax, 'delivery_schedule' => $delivery_schedule, 'mode_of_payment' => $mode_of_payment, 'mode_of_transport' => $mode_of_transport, 'guarantee_warrenty' => $guarantee_warrenty, 'sales_order_type' => $sales_order_type);

        $where = '(entity_id ="'.$order_entity_id.'")';
        $this->db->where($where);
        $this->db->update('sales_order_register',$update_order_array);

        $offer_status = 3;
        $update_offer_array = array('status' => $offer_status);
        $where = '(entity_id ="'.$offer_entity_id.'")';
        $this->db->where($where);
        $this->db->update('offer_register',$update_offer_array);

        $enquiry_status = 3;
        $update_enquiry_array = array('enquiry_status' => $enquiry_status);
        $where = '(entity_id ="'.$enquiry_entity_id.'")';
        $this->db->where($where);
        $this->db->update('enquiry_register',$update_enquiry_array);

        redirect('vw_sales_order_data');
    }

    public function update_sales_order_data()
    {
        $entity_id = $this->uri->segment(2);
        $data['entity_id'] = $entity_id;
        $data['customer_list'] = $this->sales_order_register_model->get_customer_list();
        $data['employee_list'] = $this->sales_order_register_model->get_employee_list();
        $data['payment_term_list'] = $this->sales_order_register_model->get_payment_term_list();
        $data['product_list'] = $this->sales_order_register_model->get_product_list();
        $data['order_product_list'] = $this->sales_order_register_model->get_order_product_list_by_id($entity_id);
        $order_data = $this->sales_order_register_model->get_order_details_by_offerid_model($entity_id);
        $data['order_result'] = $order_data;
        $data['order_accessories_list'] = $this->sales_order_register_model->get_order_accessories_list_by_id($entity_id);
        $data['accessories_list'] = $this->sales_order_register_model->get_accessories_list($entity_id);
        $data['ship_to_party'] = $this->sales_order_register_model->get_ship_to_party_at_update_page($entity_id);
        $data['bill_to_party'] = $this->sales_order_register_model->get_bill_to_party_at_update_page($entity_id);

        $data['product_category'] = $this->sales_order_register_model->get_product_category();
        $data['product_detail_hsn_code'] = $this->sales_order_register_model->get_product_hsn_code();
        $this->load->view('sales/sales_order_register/vw_sales_order_register_update',$data);
    }

    public function save_order_accessories_from_order()
    {
        $entity_id = $this->input->post('entity_id');
        $sales_order_product_id = $this->input->post('accessories_for');
        $accessories_id = $this->input->post('accessories');
        $accessories_rate = $this->input->post('accessories_rate');
        $accessories_qty = $this->input->post('accessories_qty');

        $this->db->select('*');
        $this->db->from('sales_order_register');
        $where = '(sales_order_register.entity_id = "'.$entity_id.'" )';
        $this->db->where($where);
        $query_data = $this->db->get();
        $query_result = $query_data->row_array();

        $order_entity_id = $query_result['entity_id'];
        $order_customer_id = $query_result['customer_id'];

        $this->db->select('product_master.*,
                product_hsn_master.hsn_code,
                product_hsn_master.total_gst_percentage,
                product_hsn_master.cgst,
                product_hsn_master.sgst,
                product_hsn_master.igst');
        $this->db->from('product_master');
        $this->db->join('product_hsn_master', 'product_master.hsn_id = product_hsn_master.entity_id', 'INNER');
        $where = '(product_master.entity_id = "'.$accessories_id.'" )';
        $this->db->where($where);
        $product_master = $this->db->get();
        $product_master_result = $product_master->row();

        $total_amount_without_gst = $accessories_qty * $accessories_rate;
        $discount = 0;
        $discount_amt = 0;
        $unit_discounted_price = $total_amount_without_gst - $discount_amt;

        $this->db->select('*');
        $this->db->from('customer_master');
        $where = '(customer_master.entity_id = "'.$order_customer_id.'")';
        $this->db->where($where);
        $customer_address_master = $this->db->get();
        $customer_address_master_result = $customer_address_master->row();

        $state_code = $customer_address_master_result->state_code;

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


        $order_product_accessories_relation_save = "INSERT INTO sales_order_accessories_relation (sales_order_id , sales_order_product_id , product_id , qty , price , total_amount_without_gst , cgst_percentage , sgst_percentage , igst_percentage , cgst_amount , sgst_amount , igst_amount , total_amount_with_gst , discount , discount_amount , unit_discounted_price) VALUES ('".$order_entity_id."' , '".$sales_order_product_id."' , '".$accessories_id."' , '".$accessories_qty."' , '".$accessories_rate."' , '".$total_amount_without_gst."' , '".$cgst_percentage."' , '".$sgst_percentage."' , '".$igst_percentage."' , '".$cgst_amount."' , '".$sgst_amount."' , '".$igst_amount."' , '".$total_amount."' , '".$discount."' , '".$discount_amt."' , '".$unit_discounted_price."')";
        $save_order_product_relation = $this->db->query($order_product_accessories_relation_save);
    }

    public function get_order_details_by_orderid()
    {
        $entity_id = $this->input->post('entity_id',TRUE);
        $data = $this->sales_order_register_model->get_order_details_by_offerid_model($entity_id)->result();
        echo json_encode($data);
    }

    public function update_order_product()
    {
        $order_entity_id = $this->input->post('order_entity_id');
        $product_checkbox = $this->input->post('product_checkbox');
        $order_descrption = $this->input->post('order_descrption');
        $employee_id = $this->input->post('employee_id');
        $terms_conditions = $this->input->post('terms_conditions');
        $delivery_period = $this->input->post('delivery_period');
        $order_freight = $this->input->post('order_freight');
        $freight_charges = $this->input->post('freight_charges');
        $dispatch_address = $this->input->post('dispatch_address');
        $delivery_instruction = $this->input->post('delivery_instruction');
        $order_pf = $this->input->post('order_pf');
        $special_customer = $this->input->post('special_customer');
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

        $this->db->select('*');
        $this->db->from('sales_order_register');
        $where = '(sales_order_register.entity_id = "'.$order_entity_id.'" )';
        $this->db->where($where);
        $query_data = $this->db->get();
        $query_result = $query_data->row_array();

        $order_customer_id = $query_result['customer_id'];

        $update_order_array = array('sales_order_description' => $order_descrption , 'order_engg_name' => $employee_id , 'terms_conditions' => $terms_conditions , 'delivery_period' => $delivery_period , 'transportation' => $order_freight , 'transportation_price' => $freight_charges , 'dispatch_address' => $dispatch_address , 'delivery_instruction' => $delivery_instruction , 'packing_forwarding' => $packing_forwarding ,'special_customer' => $special_customer , 'packing_forwarding_price' => $packing_forwarding_charges , 'payment_term' => $payment_term , 'special_packing' => $special_instruction , 'insurance' => $order_insurance , 'insurance_price' => $insurance_charges, 'salutation' => $salutation, 'price_basis' => $price_basis, 'transport_insurance' => $transport_insurance, 'tax' => $tax, 'delivery_schedule' => $delivery_schedule, 'mode_of_payment' => $mode_of_payment, 'mode_of_transport' => $mode_of_transport, 'guarantee_warrenty' => $guarantee_warrenty, 'special_customer' => $special_customer);

        $where = '(entity_id ="'.$order_entity_id.'")';
        $this->db->where($where);
        $this->db->update('sales_order_register',$update_order_array);

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
            $this->db->from('customer_master');
            $where = '(customer_master.entity_id = "'.$order_customer_id.'")';
            $this->db->where($where);
            $customer_address_master = $this->db->get();
            $customer_address_master_result = $customer_address_master->row();

            $state_code = $customer_address_master_result->state_code;

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

            $this->db->select('sales_order_id');
            $this->db->from('sales_order_product_relation');
            $where_or = '(product_id = "'.$product_id.'" AND sales_order_id = "'.$order_entity_id.'")';
            $this->db->where($where_or);
            $order_product_exit= $this->db->get();
            $order_product_exit_data_count =  $order_product_exit->num_rows();

            if ($order_product_exit_data_count === 0) 
            {
                $order_product_relation_save = "INSERT INTO sales_order_product_relation (sales_order_id , product_id , rfq_qty , price , total_amount_without_gst , cgst_discount , sgst_discount , igst_discount , cgst_amount , sgst_amount , igst_amount , total_amount_with_gst , product_warranty , discount , discount_amt , unit_discounted_price) VALUES ('".$order_entity_id."' , '".$product_id."' , '".$rfq_qty."' , '".$price."' , '".$total_amount_without_gst."' , '".$cgst_percentage."' , '".$sgst_percentage."' , '".$igst_percentage."' , '".$cgst_amount."' , '".$sgst_amount."' , '".$igst_amount."' , '".$total_amount."' , '".$product_warrenty."' , '".$discount."' , '".$discount_amt."' , '".$unit_discounted_price."')";
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

    public function update_sales_order()
    {
        if(!empty($_FILES['order_attachment']['name']))
        {
            $order_entity_id = $this->input->post('order_entity_id');

            $attachment_img = "";
            foreach ($_FILES as $key => $value) {
                
                $file_name = $value['name'];
                $file_source_path = $value['tmp_name'];
                $file_upload_combine_array = array_combine($file_name, $file_source_path);
                //print_r($file_upload_combine_array);
                
                foreach ($file_upload_combine_array as $image_name=> $image_source_path) {

                    $ext = pathinfo($image_name,PATHINFO_EXTENSION);

                    $order_attachment_upload = substr(str_replace(" ", "_", $image_name), 0);
                    move_uploaded_file($image_source_path, 'assets/order_attachment/'.$order_attachment_upload);

                    $attachment_img .= $order_attachment_upload.',';
                }  
            }

            $this->db->select('*');
            $this->db->from('sales_order_register');
            $where = '(sales_order_register.entity_id = "'.$order_entity_id.'" )';
            $this->db->where($where);
            $query_data = $this->db->get();
            $query_result = $query_data->row_array();

            $offer_entity_id = $query_result['offer_id'];
            $attachment_check_result = $query_result['attachment'];

            if(!empty($attachment_check_result))
            {
                $order_attachment_img = $attachment_check_result.$attachment_img;
            }else{
                $order_attachment_img = $attachment_img;
            }

            $order_descrption = $this->input->post('order_descrption');
            $employee_id = $this->input->post('employee_id');
            $terms_conditions = $this->input->post('terms_conditions');
            $delivery_period = $this->input->post('delivery_period');
            $order_freight = $this->input->post('order_freight');
            $freight_charges = $this->input->post('freight_charges');
            $dispatch_address = $this->input->post('dispatch_address');
            $delivery_instruction = $this->input->post('delivery_instruction');
            $packing_forwarding = $this->input->post('packing_forwarding');
            $packing_forwarding_charges = $this->input->post('packing_forwarding_charges');
            $payment_term = $this->input->post('payment_term');
            $special_instruction = $this->input->post('special_instruction');
            $order_insurance = $this->input->post('order_insurance');
            $insurance_charges = $this->input->post('insurance_charges');
            $purchase_order_number = $this->input->post('purchase_order_number');
            $purchase_order_date = $this->input->post('purchase_order_date');
            $order_status = $this->input->post('order_status');
            $special_customer = $this->input->post('special_customer');
            //$sales_order_type = $this->input->post('sales_order_type');

            $salutation = $this->input->post('salutation');
            $price_basis = $this->input->post('price_basis');
            $transport_insurance = $this->input->post('transport_insurance');
            $tax = $this->input->post('tax');
            $delivery_schedule = $this->input->post('delivery_schedule');
            $mode_of_payment = $this->input->post('mode_of_payment');
            $mode_of_transport = $this->input->post('mode_of_transport');
            $guarantee_warrenty = $this->input->post('guarantee_warrenty');
            $payment_term = $this->input->post('payment_term');
            $order_execuation_status = NULL;

            $this->db->select('*');
            $this->db->from('offer_register');
            $where = '(offer_register.entity_id = "'.$offer_entity_id.'" )';
            $this->db->where($where);
            $offer_register_data = $this->db->get();
            $offer_register_result = $offer_register_data->row_array();

            $enquiry_entity_id = $offer_register_result['enquiry_id'];

            $update_order_array = array('sales_order_description' => $order_descrption , 'order_engg_name' => $employee_id , 'special_customer' => $special_customer , 'terms_conditions' => $terms_conditions , 'delivery_period' => $delivery_period , 'transportation' => $order_freight , 'transportation_price' => $freight_charges , 'dispatch_address' => $dispatch_address , 'delivery_instruction' => $delivery_instruction , 'packing_forwarding' => $packing_forwarding , 'packing_forwarding_price' => $packing_forwarding_charges , 'payment_term' => $payment_term , 'special_packing' => $special_instruction , 'insurance' => $order_insurance , 'insurance_price' => $insurance_charges , 'po_no' => $purchase_order_number , 'po_date' => $purchase_order_date , 'attachment' => $order_attachment_img , 'status' => $order_status, 'price_basis' => $price_basis, 'salutation' => $salutation, 'transport_insurance' => $transport_insurance, 'tax' => $tax, 'delivery_schedule' => $delivery_schedule, 'mode_of_payment' => $mode_of_payment, 'mode_of_transport' => $mode_of_transport, 'guarantee_warrenty' => $guarantee_warrenty, 'order_execution_status' =>$order_execuation_status);

            $where = '(entity_id ="'.$order_entity_id.'")';
            $this->db->where($where);
            $this->db->update('sales_order_register',$update_order_array);

            if($order_status == 3)
            {
                $offer_status = 7;
                $update_offer_array = array('status' => $offer_status);
                $where = '(entity_id ="'.$offer_entity_id.'")';
                $this->db->where($where);
                $this->db->update('offer_register',$update_offer_array);

                $enquiry_status = 6;
                $update_enquiry_array = array('enquiry_status' => $enquiry_status);
                $where = '(entity_id ="'.$enquiry_entity_id.'")';
                $this->db->where($where);
                $this->db->update('enquiry_register',$update_enquiry_array);
            }
            redirect('vw_sales_order_data'); 
        }else{
            $order_entity_id = $this->input->post('order_entity_id');
            $order_descrption = $this->input->post('order_descrption');
            $employee_id = $this->input->post('employee_id');
            $terms_conditions = $this->input->post('terms_conditions');
            $delivery_period = $this->input->post('delivery_period');
            $order_freight = $this->input->post('order_freight');
            $freight_charges = $this->input->post('freight_charges');
            $dispatch_address = $this->input->post('dispatch_address');
            $delivery_instruction = $this->input->post('delivery_instruction');
            $packing_forwarding = $this->input->post('packing_forwarding');
            $packing_forwarding_charges = $this->input->post('packing_forwarding_charges');
            $payment_term = $this->input->post('payment_term');
            $special_instruction = $this->input->post('special_instruction');
            $order_insurance = $this->input->post('order_insurance');
            $insurance_charges = $this->input->post('insurance_charges');
            $purchase_order_number = $this->input->post('purchase_order_number');
            $purchase_order_date = $this->input->post('purchase_order_date');
            $order_status = $this->input->post('order_status');
            $special_customer = $this->input->post('special_customer');
            //$sales_order_type = $this->input->post('sales_order_type');

            $salutation = $this->input->post('salutation');
            $price_basis = $this->input->post('price_basis');
            $transport_insurance = $this->input->post('transport_insurance');
            $tax = $this->input->post('tax');
            $delivery_schedule = $this->input->post('delivery_schedule');
            $mode_of_payment = $this->input->post('mode_of_payment');
            $mode_of_transport = $this->input->post('mode_of_transport');
            $guarantee_warrenty = $this->input->post('guarantee_warrenty');
            $payment_term = $this->input->post('payment_term');
            $order_execuation_status = NULL;

            $this->db->select('*');
            $this->db->from('sales_order_register');
            $where = '(sales_order_register.entity_id = "'.$order_entity_id.'" )';
            $this->db->where($where);
            $query_data = $this->db->get();
            $query_result = $query_data->row_array();

            $offer_entity_id = $query_result['offer_id'];

            $this->db->select('*');
            $this->db->from('offer_register');
            $where = '(offer_register.entity_id = "'.$offer_entity_id.'" )';
            $this->db->where($where);
            $offer_register_data = $this->db->get();
            $offer_register_result = $offer_register_data->row_array();
            $enquiry_entity_id = $offer_register_result['enquiry_id'];

            $update_order_array = array('sales_order_description' => $order_descrption , 'order_engg_name' => $employee_id , 'special_customer' => $special_customer , 'terms_conditions' => $terms_conditions , 'delivery_period' => $delivery_period , 'transportation' => $order_freight , 'transportation_price' => $freight_charges , 'dispatch_address' => $dispatch_address , 'delivery_instruction' => $delivery_instruction , 'packing_forwarding' => $packing_forwarding , 'packing_forwarding_price' => $packing_forwarding_charges , 'payment_term' => $payment_term , 'special_packing' => $special_instruction , 'insurance' => $order_insurance , 'insurance_price' => $insurance_charges , 'po_no' => $purchase_order_number , 'po_date' => $purchase_order_date , 'status' => $order_status, 'price_basis' => $price_basis, 'salutation' => $salutation, 'transport_insurance' => $transport_insurance, 'tax' => $tax, 'delivery_schedule' => $delivery_schedule, 'mode_of_payment' => $mode_of_payment, 'mode_of_transport' => $mode_of_transport, 'guarantee_warrenty' => $guarantee_warrenty, 'order_execution_status' =>$order_execuation_status);

            $where = '(entity_id ="'.$order_entity_id.'")';
            $this->db->where($where);
            $this->db->update('sales_order_register',$update_order_array);

            if($order_status == 3)
            {
                $offer_status = 7;
                $update_offer_array = array('status' => $offer_status);
                $where = '(entity_id ="'.$offer_entity_id.'")';
                $this->db->where($where);
                $this->db->update('offer_register',$update_offer_array);

                $enquiry_status = 6;
                $update_enquiry_array = array('enquiry_status' => $enquiry_status);
                $en_where = '(entity_id ="'.$enquiry_entity_id.'")';
                $this->db->where($en_where);
                $this->db->update('enquiry_register',$update_enquiry_array);
            }
            redirect('vw_sales_order_data'); 
        }
    }

    public function view_sales_order_data()
    {
        $entity_id = $this->uri->segment(2);
        $data['entity_id'] = $entity_id;
        $data['customer_list'] = $this->sales_order_register_model->get_customer_list();
        $data['employee_list'] = $this->sales_order_register_model->get_employee_list();
        $data['payment_term_list'] = $this->sales_order_register_model->get_payment_term_list();
        $data['product_list'] = $this->sales_order_register_model->get_product_list();
        $data['order_product_list'] = $this->sales_order_register_model->get_order_product_list_by_id($entity_id);
        $order_data = $this->sales_order_register_model->get_order_details_by_offerid_model($entity_id);
        $data['order_result'] = $order_data;
        $data['order_accessories_list'] = $this->sales_order_register_model->get_order_accessories_list_by_id($entity_id);
        $data['accessories_list'] = $this->sales_order_register_model->get_accessories_list($entity_id);
        $this->load->view('sales/sales_order_register/vw_sales_order_register_view',$data);
    }

    public function delete_attach_order_image()
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
            $this->db->from('sales_order_register');
            $where = '(sales_order_register.entity_id = "'.$entity_id.'")';
            $this->db->where($where);
            $attachment_check = $this->db->get();
            $attachment_check_result = $attachment_check->row_array();

            $attachment_data = $attachment_check_result['attachment'];

            $delete_image = NULL;
            $replaced_data =  str_replace($image_name_db,$delete_image,$attachment_data);

            $image_attachment_new_array = array('attachment' => $replaced_data);
            $where = '(entity_id ="'.$entity_id.'")';
            $this->db->where($where);
            $this->db->update('sales_order_register',$image_attachment_new_array);

            unlink("assets/order_attachment/".$image_name);
            redirect('update_sales_order_data'.'/'.$entity_id); 
        }
    }

    public function pending_sales_order_for_approver()
    {
        $data['pending_sales_order'] = $this->sales_order_register_model->get_all_order_details();
        $this->load->view('sales/sales_order_register/vw_pending_sales_order_register_index',$data);
    }

    public function update_pending_sales_order()
    {
        $entity_id = $this->uri->segment(2);
        $data['entity_id'] = $entity_id;
        $data['customer_list'] = $this->sales_order_register_model->get_customer_list();
        $data['employee_list'] = $this->sales_order_register_model->get_employee_list();
        $data['payment_term_list'] = $this->sales_order_register_model->get_payment_term_list();
        $data['order_product_list'] = $this->sales_order_register_model->get_order_product_list_by_id($entity_id);
        $order_data = $this->sales_order_register_model->get_order_details_by_offerid_model($entity_id);
        $data['order_result'] = $order_data;
        $data['order_accessories_list'] = $this->sales_order_register_model->get_order_accessories_list_by_id($entity_id);
        $this->load->view('sales/sales_order_register/vw_pending_sales_order_register_update',$data);
    }

    public function approve_sales_order()
    {
        $order_entity_id = $this->input->post('order_entity_id');
        $approval_status = $this->input->post('approval_status');
        $rejected_reason = $this->input->post('rejected_reason');

        if($approval_status == 1)
        {
            $allocation_status = 1;
            $update_order_array = array('order_execution_status' => $approval_status , 'allocation_status' => $allocation_status);

            $this->db->select('*');
            $this->db->from('sales_order_product_relation');
            $where = '(sales_order_product_relation.sales_order_id = "'.$order_entity_id.'" )';
            $this->db->where($where);
            $query_data = $this->db->get();

            $sales_order_exit_data_count =  $query_data->num_rows();
            // print_r($sales_order_exit_data_count);
            // die();
            $query_result = $query_data->result_array();


            foreach ($query_result as $key => $value) {
                $product_id = $value['product_id'];

                $this->db->select('*');
                $this->db->from('product_master');
                $where = '(product_master.entity_id = "'.$product_id.'" )';
                $this->db->where($where);
                $product_master_data = $this->db->get();
                $product_master_result = $product_master_data->row_array();

                $product_category_id = $product_master_result['category_id'];

                $rfq_qty = $value['rfq_qty'];
                $status = 1;
                $Type = 1;

                $order_execution_arraysssss = array('sales_order_id' => $order_entity_id , 'product_type' => $Type , 'product_category_id' => $product_category_id , 'product_id' => $product_id , 'rfq_qty' => $rfq_qty , 'status' => $status);

                $this->db->insert('order_execution_product_relation', $order_execution_arraysssss);
                $order_execution_lastid = $this->db->insert_id();
            }

            $this->db->select('*');
            $this->db->from('sales_order_accessories_relation');
            $where = '(sales_order_accessories_relation.sales_order_id = "'.$order_entity_id.'" )';
            $this->db->where($where);
            $accessories_query_data = $this->db->get();
            $accessories_query_result = $accessories_query_data->result_array();
            // print_r($accessories_query_result);
            // die();

            foreach ($accessories_query_result as $key => $value) {
                $product_id = $value['product_id'];

                $this->db->select('*');
                $this->db->from('product_master');
                $where = '(product_master.entity_id = "'.$product_id.'" )';
                $this->db->where($where);
                $product_master_data = $this->db->get();
                $product_master_result = $product_master_data->row_array();

                $product_category_id = $product_master_result['category_id'];

                $qty = $value['qty'];
                $status = 1;
                $Type = 2;

                $order_execution_array = array('sales_order_id' => $order_entity_id , 'product_type' => $Type , 'product_category_id' => $product_category_id , 'product_id' => $product_id , 'rfq_qty' => $qty , 'status' => $status);

                $this->db->insert('order_execution_product_relation', $order_execution_array);
                $order_execution_lastid = $this->db->insert_id();
            }

        }else{

            $update_order_array = array('status' => $approval_status ,'order_execution_status' => 2 , 'order_execution_status_remark' => $rejected_reason);
        }

        $where = '(entity_id ="'.$order_entity_id.'")';
        $this->db->where($where);
        $this->db->update('sales_order_register',$update_order_array);

        redirect('vw_pending_sales_order_data');
    }

    public function rejected_sales_order()
    {
        $data['rejected_sales_order'] = $this->sales_order_register_model->get_all_rejected_order_details();
        $this->load->view('sales/sales_order_register/vw_rejected_sales_order_register_index',$data);
    }

    public function update_rejected_sales_order()
    {
        $entity_id = $this->uri->segment(2);
        $data['entity_id'] = $entity_id;
        $data['customer_list'] = $this->sales_order_register_model->get_customer_list();
        $data['employee_list'] = $this->sales_order_register_model->get_employee_list();
        $data['payment_term_list'] = $this->sales_order_register_model->get_payment_term_list();
        $data['product_list'] = $this->sales_order_register_model->get_product_list();
        $data['order_product_list'] = $this->sales_order_register_model->get_order_product_list_by_id($entity_id);
        $order_data = $this->sales_order_register_model->get_order_details_by_offerid_model($entity_id);
        $data['order_result'] = $order_data;
        $data['order_accessories_list'] = $this->sales_order_register_model->get_order_accessories_list_by_id($entity_id);
        $data['accessories_list'] = $this->sales_order_register_model->get_accessories_list($entity_id);
        $data['ship_to_party'] = $this->sales_order_register_model->get_ship_to_party_at_update_page($entity_id);
        $data['bill_to_party'] = $this->sales_order_register_model->get_bill_to_party_at_update_page($entity_id);
        $this->load->view('sales/sales_order_register/vw_rejected_sales_order_register_update',$data);
    }

    public function update_rejected_sales_order_data()
    {
        if(!empty($_FILES['order_attachment']['name']))
        {
            $order_entity_id = $this->input->post('order_entity_id');

            $attachment_img = "";
            foreach ($_FILES as $key => $value) {
                
                $file_name = $value['name'];
                $file_source_path = $value['tmp_name'];
                $file_upload_combine_array = array_combine($file_name, $file_source_path);
                //print_r($file_upload_combine_array);
                
                foreach ($file_upload_combine_array as $image_name=> $image_source_path) {

                    $ext = pathinfo($image_name,PATHINFO_EXTENSION);

                    $order_attachment_upload = substr(str_replace(" ", "_", $image_name), 0);
                    move_uploaded_file($image_source_path, 'assets/order_attachment/'.$order_attachment_upload);

                    $attachment_img .= $order_attachment_upload.',';
                }  
            }

            $this->db->select('*');
            $this->db->from('sales_order_register');
            $where = '(sales_order_register.entity_id = "'.$order_entity_id.'" )';
            $this->db->where($where);
            $query_data = $this->db->get();
            $query_result = $query_data->row_array();

            $offer_entity_id = $query_result['offer_id'];
            $attachment_check_result = $query_result['attachment'];

            if(!empty($attachment_check_result))
            {
                $order_attachment_img = $attachment_check_result.$attachment_img;
            }else{
                $order_attachment_img = $attachment_img;
            }

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
            $purchase_order_number = $this->input->post('purchase_order_number');
            $purchase_order_date = $this->input->post('purchase_order_date');
            $order_status = $this->input->post('order_status');
            $order_execution_status = NULL;

            $this->db->select('*');
            $this->db->from('offer_register');
            $where = '(offer_register.entity_id = "'.$offer_entity_id.'" )';
            $this->db->where($where);
            $offer_register_data = $this->db->get();
            $offer_register_result = $offer_register_data->row_array();

            $enquiry_entity_id = $query_result['enquiry_id'];

            $update_order_array = array('sales_order_description' => $order_descrption , 'order_engg_name' => $employee_id , 'terms_conditions_id' => $order_terms_condition , 'delivery_period' => $delivery_period , 'transportation' => $order_freight , 'transportation_price' => $freight_charges , 'dispatch_address' => $dispatch_address , 'delivery_instruction' => $delivery_instruction , 'packing_forwarding' => $order_pf , 'packing_forwarding_price' => $packing_forwarding_charges , 'payment_term' => $payment_term , 'special_packing' => $special_instruction , 'insurance' => $order_insurance , 'insurance_price' => $insurance_charges , 'po_no' => $purchase_order_number , 'po_date' => $purchase_order_date , 'attachment' => $order_attachment_img , 'status' => $order_status , 'order_execution_status' => $order_execution_status);

            $where = '(entity_id ="'.$order_entity_id.'")';
            $this->db->where($where);
            $this->db->update('sales_order_register',$update_order_array);

            if($order_status == 3)
            {
                $offer_status = 7;
                $update_offer_array = array('status' => $offer_status);
                $where = '(entity_id ="'.$offer_entity_id.'")';
                $this->db->where($where);
                $this->db->update('offer_register',$update_offer_array);

                $enquiry_status = 6;
                $update_enquiry_array = array('enquiry_status' => $enquiry_status);
                $where = '(entity_id ="'.$enquiry_entity_id.'")';
                $this->db->where($where);
                $this->db->update('enquiry_register',$update_enquiry_array);
            }
            redirect('vw_all_rejected_sales_order_data'); 
        }else{
            $order_entity_id = $this->input->post('order_entity_id');
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
            $purchase_order_number = $this->input->post('purchase_order_number');
            $purchase_order_date = $this->input->post('purchase_order_date');
            $order_status = $this->input->post('order_status');
            $order_execution_status = NULL;

            $this->db->select('*');
            $this->db->from('sales_order_register');
            $where = '(sales_order_register.entity_id = "'.$order_entity_id.'" )';
            $this->db->where($where);
            $query_data = $this->db->get();
            $query_result = $query_data->row_array();

            $offer_entity_id = $query_result['offer_id'];

            $this->db->select('*');
            $this->db->from('offer_register');
            $where = '(offer_register.entity_id = "'.$offer_entity_id.'" )';
            $this->db->where($where);
            $offer_register_data = $this->db->get();
            $offer_register_result = $offer_register_data->row_array();
            $enquiry_entity_id = $offer_register_result['enquiry_id'];

            $update_order_array = array('sales_order_description' => $order_descrption , 'order_engg_name' => $employee_id , 'terms_conditions_id' => $order_terms_condition , 'delivery_period' => $delivery_period , 'transportation' => $order_freight , 'transportation_price' => $freight_charges , 'dispatch_address' => $dispatch_address , 'delivery_instruction' => $delivery_instruction , 'packing_forwarding' => $order_pf , 'packing_forwarding_price' => $packing_forwarding_charges , 'payment_term' => $payment_term , 'special_packing' => $special_instruction , 'insurance' => $order_insurance , 'insurance_price' => $insurance_charges , 'po_no' => $purchase_order_number , 'po_date' => $purchase_order_date , 'status' => $order_status , 'order_execution_status' => $order_execution_status);

            $where = '(entity_id ="'.$order_entity_id.'")';
            $this->db->where($where);
            $this->db->update('sales_order_register',$update_order_array);

            if($order_status == 3)
            {
                $offer_status = 7;
                $update_offer_array = array('status' => $offer_status);
                $where = '(entity_id ="'.$offer_entity_id.'")';
                $this->db->where($where);
                $this->db->update('offer_register',$update_offer_array);

                $enquiry_status = 6;
                $update_enquiry_array = array('enquiry_status' => $enquiry_status);
                $en_where = '(entity_id ="'.$enquiry_entity_id.'")';
                $this->db->where($en_where);
                $this->db->update('enquiry_register',$update_enquiry_array);
            }
            redirect('vw_all_rejected_sales_order_data'); 
        }
    }

    public function approved_sales_order()
    {
        $data['approved_sales_order'] = $this->sales_order_register_model->get_all_appproved_order_details();
        $this->load->view('sales/sales_order_register/vw_approved_sales_order_register_index',$data);
    }

    public function view_approved_sales_order()
    {
        $entity_id = $this->uri->segment(2);
        $data['entity_id'] = $entity_id;
        $data['customer_list'] = $this->sales_order_register_model->get_customer_list();
        $data['employee_list'] = $this->sales_order_register_model->get_employee_list();
        $data['payment_term_list'] = $this->sales_order_register_model->get_payment_term_list();
        $data['order_product_list'] = $this->sales_order_register_model->get_order_product_list_by_id($entity_id);
        $order_data = $this->sales_order_register_model->get_order_details_by_offerid_model($entity_id);
        $data['order_result'] = $order_data;
        $data['order_accessories_list'] = $this->sales_order_register_model->get_order_accessories_list_by_id($entity_id);
        $this->load->view('sales/sales_order_register/vw_approved_sales_order_register_view',$data);
    }

    public function update_ship_to_contact_person_edit_page()
    {
        $offer_entity_id = $this->input->post('offer_entity_id');
        $ship_to_contact_person = $this->input->post('ship_to_contact_person');

        $update_order_array = array('customer_ship_to_contact_person' => $ship_to_contact_person);

        $this->db->select('*');
        $this->db->from('sales_order_register');
        $where = '(sales_order_register.offer_id = "'.$offer_entity_id.'" )';
        $this->db->where($where);
        $this->db->order_by('sales_order_register.entity_id', 'DESC');
        $this->db->limit(1);
        $query_data = $this->db->get();
        $query_result = $query_data->row_array();

        $sales_order_entity_id = $query_result['entity_id'];

        $where = '(entity_id ="'.$sales_order_entity_id.'")';
        $this->db->where($where);
        $this->db->update('sales_order_register',$update_order_array);
    }

    public function update_ship_to_company_name_edit_page()
    {
        $offer_entity_id = $this->input->post('offer_entity_id');
        $ship_to_company_name = $this->input->post('ship_to_company_name');

        $update_order_array = array('customer_ship_to_name' => $ship_to_company_name);

        $this->db->select('*');
        $this->db->from('sales_order_register');
        $where = '(sales_order_register.offer_id = "'.$offer_entity_id.'" )';
        $this->db->where($where);
        $this->db->order_by('sales_order_register.entity_id', 'DESC');
        $this->db->limit(1);
        $query_data = $this->db->get();
        $query_result = $query_data->row_array();

        $sales_order_entity_id = $query_result['entity_id'];

        $where = '(entity_id ="'.$sales_order_entity_id.'")';
        $this->db->where($where);
        $this->db->update('sales_order_register',$update_order_array);
    }

    public function update_bill_to_company_name_edit_page()
    {
        $offer_entity_id = $this->input->post('offer_entity_id');
        $bill_to_company_name = $this->input->post('bill_to_company_name');

        $update_order_array = array('customer_bill_to_name' => $bill_to_company_name);

        $this->db->select('*');
        $this->db->from('sales_order_register');
        $where = '(sales_order_register.offer_id = "'.$offer_entity_id.'" )';
        $this->db->where($where);
        $this->db->order_by('sales_order_register.entity_id', 'DESC');
        $this->db->limit(1);
        $query_data = $this->db->get();
        $query_result = $query_data->row_array();

        $sales_order_entity_id = $query_result['entity_id'];

        $where = '(entity_id ="'.$sales_order_entity_id.'")';
        $this->db->where($where);
        $this->db->update('sales_order_register',$update_order_array);
    }

    public function update_ship_to_email_id()
    {
        $offer_entity_id = $this->input->post('offer_entity_id');
        $ship_to_email_id = $this->input->post('ship_to_email_id');

        $update_order_array = array('customer_ship_to_contact_person_mail' => $ship_to_email_id);

        $this->db->select('*');
        $this->db->from('sales_order_register');
        $where = '(sales_order_register.offer_id = "'.$offer_entity_id.'" )';
        $this->db->where($where);
        $this->db->order_by('sales_order_register.entity_id', 'DESC');
        $this->db->limit(1);
        $query_data = $this->db->get();
        $query_result = $query_data->row_array();

        $sales_order_entity_id = $query_result['entity_id'];

        $where = '(entity_id ="'.$sales_order_entity_id.'")';
        $this->db->where($where);
        $this->db->update('sales_order_register',$update_order_array);

        echo json_encode($data);
    }

    public function update_ship_to_address_edit_page()
    {
        $offer_entity_id = $this->input->post('offer_entity_id');
        $ship_to_address = $this->input->post('ship_to_address');

        $update_order_array = array('customer_ship_to_address' => $ship_to_address);

        $this->db->select('*');
        $this->db->from('sales_order_register');
        $where = '(sales_order_register.offer_id = "'.$offer_entity_id.'" )';
        $this->db->where($where);
        $this->db->order_by('sales_order_register.entity_id', 'DESC');
        $this->db->limit(1);
        $query_data = $this->db->get();
        $query_result = $query_data->row_array();

        $sales_order_entity_id = $query_result['entity_id'];

        $where = '(entity_id ="'.$sales_order_entity_id.'")';
        $this->db->where($where);
        $this->db->update('sales_order_register',$update_order_array);
    }

    public function update_ship_to_contact_no()
    {
        $offer_entity_id = $this->input->post('offer_entity_id');
        $ship_to_contact_number = $this->input->post('ship_to_contact_number');

        $update_order_array = array('customer_ship_to_contact_person_no' => $ship_to_contact_number);

        $this->db->select('*');
        $this->db->from('sales_order_register');
        $where = '(sales_order_register.offer_id = "'.$offer_entity_id.'" )';
        $this->db->where($where);
        $this->db->order_by('sales_order_register.entity_id', 'DESC');
        $this->db->limit(1);
        $query_data = $this->db->get();
        $query_result = $query_data->row_array();

        $sales_order_entity_id = $query_result['entity_id'];

        $where = '(entity_id ="'.$sales_order_entity_id.'")';
        $this->db->where($where);
        $this->db->update('sales_order_register',$update_order_array);
    }

    public function update_ship_to_gst_no()
    {
        $offer_entity_id = $this->input->post('offer_entity_id');
        $customer_ship_to_gst_no = $this->input->post('customer_ship_to_gst_no');

        $update_order_array = array('customer_ship_to_gst_no' => $customer_ship_to_gst_no);

        $this->db->select('*');
        $this->db->from('sales_order_register');
        $where = '(sales_order_register.offer_id = "'.$offer_entity_id.'" )';
        $this->db->where($where);
        $this->db->order_by('sales_order_register.entity_id', 'DESC');
        $this->db->limit(1);
        $query_data = $this->db->get();
        $query_result = $query_data->row_array();

        $sales_order_entity_id = $query_result['entity_id'];

        $where = '(entity_id ="'.$sales_order_entity_id.'")';
        $this->db->where($where);
        $this->db->update('sales_order_register',$update_order_array);
    }

    public function update_bill_to_contact_person_edit_page()
    {
        $offer_entity_id = $this->input->post('offer_entity_id');
        $bill_to_contact_person = $this->input->post('bill_to_contact_person');

        $update_order_array = array('customer_bill_to_contact_person' => $bill_to_contact_person);

        $this->db->select('*');
        $this->db->from('sales_order_register');
        $where = '(sales_order_register.offer_id = "'.$offer_entity_id.'" )';
        $this->db->where($where);
        $this->db->order_by('sales_order_register.entity_id', 'DESC');
        $this->db->limit(1);
        $query_data = $this->db->get();
        $query_result = $query_data->row_array();

        $sales_order_entity_id = $query_result['entity_id'];

        $where = '(entity_id ="'.$sales_order_entity_id.'")';
        $this->db->where($where);
        $this->db->update('sales_order_register',$update_order_array);
    }

    public function update_bill_to_email_id()
    {
        $offer_entity_id = $this->input->post('offer_entity_id');
        $bill_to_email_id = $this->input->post('bill_to_email_id');

        $update_order_array = array('customer_bill_to_contact_person_mail' => $bill_to_email_id);

        $this->db->select('*');
        $this->db->from('sales_order_register');
        $where = '(sales_order_register.offer_id = "'.$offer_entity_id.'" )';
        $this->db->where($where);
        $this->db->order_by('sales_order_register.entity_id', 'DESC');
        $this->db->limit(1);
        $query_data = $this->db->get();
        $query_result = $query_data->row_array();

        $sales_order_entity_id = $query_result['entity_id'];

        $where = '(entity_id ="'.$sales_order_entity_id.'")';
        $this->db->where($where);
        $this->db->update('sales_order_register',$update_order_array);
    }

    public function update_bill_to_address_edit_page()
    {
        $offer_entity_id = $this->input->post('offer_entity_id');
        $bill_to_address = $this->input->post('bill_to_address');

        $update_order_array = array('customer_bill_to_address' => $bill_to_address);

        $this->db->select('*');
        $this->db->from('sales_order_register');
        $where = '(sales_order_register.offer_id = "'.$offer_entity_id.'" )';
        $this->db->where($where);
        $this->db->order_by('sales_order_register.entity_id', 'DESC');
        $this->db->limit(1);
        $query_data = $this->db->get();
        $query_result = $query_data->row_array();

        $sales_order_entity_id = $query_result['entity_id'];

        $where = '(entity_id ="'.$sales_order_entity_id.'")';
        $this->db->where($where);
        $this->db->update('sales_order_register',$update_order_array);
    }

    public function update_bill_to_contact_no()
    {
        $offer_entity_id = $this->input->post('offer_entity_id');
        $bill_to_contact_number = $this->input->post('bill_to_contact_number');

        $update_order_array = array('customer_bill_to_contact_person_no' => $bill_to_contact_number);

        $this->db->select('*');
        $this->db->from('sales_order_register');
        $where = '(sales_order_register.offer_id = "'.$offer_entity_id.'" )';
        $this->db->where($where);
        $this->db->order_by('sales_order_register.entity_id', 'DESC');
        $this->db->limit(1);
        $query_data = $this->db->get();
        $query_result = $query_data->row_array();

        $sales_order_entity_id = $query_result['entity_id'];

        $where = '(entity_id ="'.$sales_order_entity_id.'")';
        $this->db->where($where);
        $this->db->update('sales_order_register',$update_order_array);
    }

    public function update_bill_to_gst_no()
    {
        $offer_entity_id = $this->input->post('offer_entity_id');
        $customer_ship_to_gst_no = $this->input->post('customer_ship_to_gst_no');

        $update_order_array = array('customer_bill_to_gst_no' => $customer_ship_to_gst_no);

        $this->db->select('*');
        $this->db->from('sales_order_register');
        $where = '(sales_order_register.offer_id = "'.$offer_entity_id.'" )';
        $this->db->where($where);
        $this->db->order_by('sales_order_register.entity_id', 'DESC');
        $this->db->limit(1);
        $query_data = $this->db->get();
        $query_result = $query_data->row_array();

        $sales_order_entity_id = $query_result['entity_id'];

        $where = '(entity_id ="'.$sales_order_entity_id.'")';
        $this->db->where($where);
        $this->db->update('sales_order_register',$update_order_array);
    }


    public function vw_sales_order_without_offer()
    {
        // $entity_id = $this->uri->segment(2);
        // $offer_data = $this->sales_order_register_model->offer_to_order_save_model($entity_id);
        // $data['entity_id'] = $entity_id;
        // $data['offer_result'] = $offer_data;

        $data['state_list'] = $this->sales_order_register_model->get_state_list();
        $data['customer_list'] = $this->sales_order_register_model->get_customer_list();
        $data['employee_list'] = $this->sales_order_register_model->get_employee_list();
        $data['payment_term_list'] = $this->sales_order_register_model->get_payment_term_list();
        $data['product_list'] = $this->sales_order_register_model->get_product_list();
        // $data['order_product_list'] = $this->sales_order_register_model->get_order_product_list($entity_id);
        $this->load->view('sales/sales_order_register/vw_sales_order_register_without_offer_create',$data);
    }

    public function get_all_customer_data_ship_to()
    {
        $data = $this->input->post();
        if(!empty($data))
        {
            $customer_id = $this->input->post('id');
            $data = $this->sales_order_register_model->get_all_data_by_customer_id_ship_to($customer_id);
            echo json_encode([$data]);
        }
    }

    public function get_all_customer_data_bill_to()
    {
        $data = $this->input->post();
        if(!empty($data))
        {
            $customer_id = $this->input->post('id');
            $data = $this->sales_order_register_model->get_all_data_by_customer_id_bill_to($customer_id);
            echo json_encode([$data]);
        }
    }

    public function insert_order_without_offer()
    {
        $customer_id = $this->input->post('customer_id');
        $bill_to_company_name = $this->input->post('bill_to_company_name');
        $bill_to_contact_person = $this->input->post('bill_to_contact_person');
        $bill_to_email_id = $this->input->post('bill_to_email_id');
        $bill_to_address = $this->input->post('bill_to_address');
        $bill_to_contact_number = $this->input->post('bill_to_contact_number');
        $customer_bill_to_gst_no = $this->input->post('customer_bill_to_gst_no');
        $ship_to_company_name = $this->input->post('ship_to_company_name');
        $ship_to_contact_person = $this->input->post('ship_to_contact_person');
        $ship_to_email_id = $this->input->post('ship_to_email_id');
        $ship_to_address = $this->input->post('ship_to_address');
        $ship_to_contact_number = $this->input->post('ship_to_contact_number');
        $customer_ship_to_gst_no = $this->input->post('customer_ship_to_gst_no');
        $product_checkbox = $this->input->post('product_checkbox');
        $order_descrption = $this->input->post('order_descrption');
        $employee_id = $this->input->post('employee_id');
        $terms_conditions = $this->input->post('terms_conditions');
        $delivery_period = $this->input->post('delivery_period');
        $order_freight = $this->input->post('order_freight');
        $freight_charges = $this->input->post('freight_charges');
        $dispatch_address = $this->input->post('dispatch_address');
        $delivery_instruction = $this->input->post('delivery_instruction');
        $order_pf = $this->input->post('order_pf');
        $special_customer = $this->input->post('special_customer');
        $packing_forwarding_charges = $this->input->post('packing_forwarding_charges');
        //$payment_term = $this->input->post('payment_term');
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
        //$special_customer = $this->input->post('special_customer');
        $sales_order_type = $this->input->post('sales_order_type');

        $this->db->select('*');
        $this->db->from('customer_master');
        $where = '(entity_id = "'.$customer_id.'")';
        $this->db->where($where);
        $customer_address_master = $this->db->get();
        $customer_address_master_data =  $customer_address_master->row();

        $bill_to_party_name = $customer_address_master_data->customer_name;
        $bill_to_party_id = $customer_address_master_data->entity_id;

        $this->db->select('*');
        $this->db->from('customer_master');
        $where = '(entity_id = "'.$customer_id.'")';
        $this->db->where($where);
        $customer_address_master = $this->db->get();
        $customer_address_master_data2 =  $customer_address_master->row();

        $ship_to_party_name = $customer_address_master_data2->customer_name;
        $ship_to_party_id = $customer_address_master_data2->entity_id;

        $this->db->select('sales_order_no');
        $this->db->from('sales_order_register');
        $this->db->order_by('entity_id', 'DESC');
        $this->db->limit(1);
        $sales_order_register = $this->db->get();
        $results_sales_order_register = $sales_order_register->result_array();

        if(!empty($results_sales_order_register))
        {
            $sales_order_serial_no = $results_sales_order_register[0]['sales_order_no'];
            $sales_order_data_seprate = explode('-', $sales_order_serial_no);
            $sales_order_doc_year_data = $sales_order_data_seprate['3'].'-'.$sales_order_data_seprate['4'];
            $sales_order_doc_year_seprate = explode('/', $sales_order_doc_year_data);
            $sales_order_doc_year = $sales_order_doc_year_seprate['0'];
        }

        $this->db->select('document_series_no');
        $this->db->from('documentseries_master');
        $this->db->where('entity_id=4');
        $doc_record=$this->db->get();
        $results_doc_record = $doc_record->result_array();

        $doc_serial_no = $results_doc_record[0]['document_series_no'];
        $doc_data_seprate = explode('-', $doc_serial_no);
        
        $doc_year_data = $doc_data_seprate['2'].'-'.$doc_data_seprate['3'];
        $doc_year_data_seprate = explode('/', $doc_year_data);
        $doc_year = $doc_year_data_seprate['0'];

        $enquiry_type = 6;

        if($enquiry_type == 1){
            $enquiry_prefix = "MH";
        }elseif($enquiry_type == 2){
           $enquiry_prefix = "PS"; 
        }elseif($enquiry_type == 3){
           $enquiry_prefix = "VC"; 
        }elseif($enquiry_type == 4){
           $enquiry_prefix = "TD"; 
        }elseif($enquiry_type == 5){
           $enquiry_prefix = "OT"; 
        }elseif($enquiry_type == 6){
           $enquiry_prefix = "XX"; 
        }

        if(empty($results_sales_order_register[0]['sales_order_no']) || ($sales_order_doc_year != $doc_year))
        {
            $first_no = '0001';
            $doc_no = $doc_data_seprate['0'].'-'.$doc_data_seprate['1'].'-'.$enquiry_prefix.'-'.$doc_year_data.''.$first_no;

        }elseif(!empty($results_sales_order_register) && ($sales_order_doc_year == $doc_year))
        {
            $doc_type = $sales_order_data_seprate['0'].'-'.$sales_order_data_seprate['1'].'-'.$enquiry_prefix;
            $ex_no_data = $sales_order_serial_no;
            $ex_no_data_seprate = explode('/', $ex_no_data);
            $ex_no = $ex_no_data_seprate['1'];
            $next_en = $ex_no + 1;
            $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
            $doc_no = $doc_type.'-'.$sales_order_doc_year.'/'.$next_doc_no;
        }  

        $insert_order_array = array('sales_order_no' => $doc_no,'sales_order_description' => $order_descrption,'customer_id' => $customer_id , 'bill_to_address' => $bill_to_party_id ,'customer_bill_to_name' => $bill_to_company_name,'customer_bill_to_address' => $bill_to_address,'customer_bill_to_gst_no' => $customer_bill_to_gst_no,'customer_bill_to_contact_person' => $bill_to_contact_person,'customer_bill_to_contact_person_mail' => $bill_to_email_id,'customer_bill_to_contact_person_no' => $bill_to_contact_number, 'ship_to_address' => $ship_to_party_id,'customer_ship_to_name' => $ship_to_company_name,'customer_ship_to_address' => $ship_to_address,'customer_ship_to_gst_no' => $customer_ship_to_gst_no,'customer_ship_to_contact_person' => $ship_to_contact_person,'customer_ship_to_contact_person_mail' => $ship_to_email_id,'customer_ship_to_contact_person_no' => $ship_to_contact_number , 'order_engg_name' => $employee_id , 'terms_conditions' => $terms_conditions , 'delivery_period' => $delivery_period , 'transportation' => $order_freight , 'transportation_price' => $freight_charges , 'dispatch_address' => $dispatch_address , 'delivery_instruction' => $delivery_instruction , 'packing_forwarding' => $packing_forwarding ,'special_customer' => $special_customer , 'packing_forwarding_price' => $packing_forwarding_charges , 'payment_term' => $payment_term , 'special_packing' => $special_instruction , 'insurance' => $order_insurance , 'insurance_price' => $insurance_charges , 'status' => 2, 'salutation' => $salutation, 'price_basis' => $price_basis, 'transport_insurance' => $transport_insurance, 'tax' => $tax, 'delivery_schedule' => $delivery_schedule, 'mode_of_payment' => $mode_of_payment, 'mode_of_transport' => $mode_of_transport, 'guarantee_warrenty' => $guarantee_warrenty, 'sales_order_type' => $sales_order_type);
        $data = $this->db->insert('sales_order_register',$insert_order_array);
        $order_master_lastid = $this->db->insert_id();

        foreach ($product_checkbox as $key => $value) 
        {
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
            $product_custom_description = $product_master_result->product_long_description;
            $discount = 0;
            $discount_amt = 0;
            $unit_discounted_price = $total_amount_without_gst - $discount_amt;

            $this->db->select('*');
            $this->db->from('customer_master');
            $where = '(customer_master.entity_id = "'.$customer_id.'")';
            $this->db->where($where);
            $customer_address_master = $this->db->get();
            $customer_address_master_result = $customer_address_master->row();

            $state_code = $customer_address_master_result->state_code;

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

                $this->db->select('sales_order_id');
                $this->db->from('sales_order_product_relation');
                $where_or = '(product_id = "'.$product_id.'" AND sales_order_id = "'.$order_master_lastid.'")';
                $this->db->where($where_or);
                $sales_order_product_exit= $this->db->get();
                $sales_order_product_exit_data_count =  $sales_order_product_exit->num_rows();
                if ($sales_order_product_exit_data_count === 0) 
                {
                $order_product_master_save = "INSERT INTO sales_order_product_relation ( sales_order_id, product_id , rfq_qty , product_custom_description , price , total_amount_without_gst , cgst_discount , sgst_discount , igst_discount , cgst_amount , sgst_amount , igst_amount , total_amount_with_gst , product_warranty , discount , discount_amt , unit_discounted_price) VALUES ('".$order_master_lastid."' ,'".$product_id."' , '".$rfq_qty."' , '".$product_custom_description."' , '".$price."' , '".$total_amount_without_gst."' , '".$cgst_percentage."' , '".$sgst_percentage."' , '".$igst_percentage."' , '".$cgst_amount."' , '".$sgst_amount."' , '".$igst_amount."' , '".$total_amount."' , '".$product_warrenty."' , '".$discount."' , '".$discount_amt."' , '".$unit_discounted_price."')";
                    $product_execute = $this->db->query($order_product_master_save);
                    $this->session->set_userdata('order_product', 'Product Saved....!');
                }
                else{
                $this->session->set_userdata('order_product', $session_product_var.' Product already exist....!');
            }
        }

        $data = $order_master_lastid;

        echo json_encode($data);
    }

    public function update_bill_to_gst_number()
    {
        $sales_order_entity_id = $this->input->post('entity_id');
        $bill_to_gst_number = $this->input->post('bill_to_gst_number');

        $update_array = array('customer_bill_to_gst_no' => $bill_to_gst_number);

        $where = '(entity_id ="'.$sales_order_entity_id.'")';
        $this->db->where($where);
        $data = $this->db->update('sales_order_register',$update_array);
        echo json_encode($data);
    }

    public function update_ship_to_gst_number()
    {
        $sales_order_entity_id = $this->input->post('entity_id');
        $ship_to_gst_number = $this->input->post('ship_to_gst_number');

        $update_array = array('customer_ship_to_gst_no' => $ship_to_gst_number);

        $where = '(entity_id ="'.$sales_order_entity_id.'")';
        $this->db->where($where);
        $data = $this->db->update('sales_order_register',$update_array);
        echo json_encode($data);
    }

    public function update_bill_to_contact_number()
    {
        $sales_order_entity_id = $this->input->post('entity_id');
        $bill_to_contact_number = $this->input->post('bill_to_contact_number');

        $update_array = array('customer_bill_to_contact_person_no' => $bill_to_contact_number);

        $where = '(entity_id ="'.$sales_order_entity_id.'")';
        $this->db->where($where);
        $data = $this->db->update('sales_order_register',$update_array);
        echo json_encode($data);
    }

    public function update_ship_to_contact_number()
    {
        $sales_order_entity_id = $this->input->post('entity_id');
        $ship_to_contact_number = $this->input->post('ship_to_contact_number');

        $update_array = array('customer_ship_to_contact_person_no' => $ship_to_contact_number);

        $where = '(entity_id ="'.$sales_order_entity_id.'")';
        $this->db->where($where);
        $data = $this->db->update('sales_order_register',$update_array);
        echo json_encode($data);
    }

    public function update_bill_to_address()
    {
        $sales_order_entity_id = $this->input->post('entity_id');
        $bill_to_address = $this->input->post('bill_to_address');

        $update_array = array('customer_bill_to_address' => $bill_to_address);

        $where = '(entity_id ="'.$sales_order_entity_id.'")';
        $this->db->where($where);
        $data = $this->db->update('sales_order_register',$update_array);
        echo json_encode($data);
    }

    public function update_ship_to_address()
    {
        $sales_order_entity_id = $this->input->post('entity_id');
        $ship_to_address = $this->input->post('ship_to_address');

        $update_array = array('customer_ship_to_address' => $ship_to_address);

        $where = '(entity_id ="'.$sales_order_entity_id.'")';
        $this->db->where($where);
        $data = $this->db->update('sales_order_register',$update_array);
        echo json_encode($data);
    }

    public function update_bill_to_email()
    {
        $sales_order_entity_id = $this->input->post('entity_id');
        $bill_to_email_address = $this->input->post('bill_to_email_address');

        $update_array = array('customer_bill_to_contact_person_mail' => $bill_to_email_address);

        $where = '(entity_id ="'.$sales_order_entity_id.'")';
        $this->db->where($where);
        $data = $this->db->update('sales_order_register',$update_array);
        echo json_encode($data);
    }

    public function update_ship_to_email()
    {
        $sales_order_entity_id = $this->input->post('entity_id');
        $ship_to_email_address = $this->input->post('ship_to_email_address');

        $update_array = array('customer_ship_to_contact_person_mail' => $ship_to_email_address);

        $where = '(entity_id ="'.$sales_order_entity_id.'")';
        $this->db->where($where);
        $data = $this->db->update('sales_order_register',$update_array);
        echo json_encode($data);
    }

    public function update_bill_to_contact_person()
    {
        $sales_order_entity_id = $this->input->post('entity_id');
        $bill_to_contact_person = $this->input->post('bill_to_contact_person');

        $update_array = array('customer_bill_to_contact_person' => $bill_to_contact_person);

        $where = '(entity_id ="'.$sales_order_entity_id.'")';
        $this->db->where($where);
        $data = $this->db->update('sales_order_register',$update_array);
        echo json_encode($data);
    }

    public function update_ship_to_contact_person()
    {
        $sales_order_entity_id = $this->input->post('entity_id');
        $ship_to_contact_person = $this->input->post('ship_to_contact_person');

        $update_array = array('customer_ship_to_contact_person' => $ship_to_contact_person);

        $where = '(entity_id ="'.$sales_order_entity_id.'")';
        $this->db->where($where);
        $data = $this->db->update('sales_order_register',$update_array);
        echo json_encode($data);
    }

    public function update_ship_to_company_name()
    {
        $sales_order_entity_id = $this->input->post('entity_id');
        $ship_to_company_name = $this->input->post('ship_to_company_name');

        $update_array = array('customer_ship_to_name' => $ship_to_company_name);

        $where = '(entity_id ="'.$sales_order_entity_id.'")';
        $this->db->where($where);
        $data = $this->db->update('sales_order_register',$update_array);
        echo json_encode($data);
    }

    public function update_bill_to_company_name()
    {
        $sales_order_entity_id = $this->input->post('entity_id');
        $bill_to_company_name = $this->input->post('bill_to_company_name');

        $update_array = array('customer_bill_to_name' => $bill_to_company_name);

        $where = '(entity_id ="'.$sales_order_entity_id.'")';
        $this->db->where($where);
        $data = $this->db->update('sales_order_register',$update_array);
        echo json_encode($data);
    }

    public function update_sales_order_data_without_offer()
    {
        $entity_id = $this->uri->segment(2);
        $data['entity_id'] = $entity_id;
        $data['customer_list'] = $this->sales_order_register_model->get_customer_list();
        $data['employee_list'] = $this->sales_order_register_model->get_employee_list();
        $data['payment_term_list'] = $this->sales_order_register_model->get_payment_term_list();
        $data['product_list'] = $this->sales_order_register_model->get_product_list();
        $data['order_product_list'] = $this->sales_order_register_model->get_order_product_list_by_id($entity_id);
        $order_data = $this->sales_order_register_model->get_order_details_by_offerid_model_without_offer($entity_id);
        $data['order_result'] = $order_data;
        $data['order_accessories_list'] = $this->sales_order_register_model->get_order_accessories_list_by_id($entity_id);
        $data['accessories_list'] = $this->sales_order_register_model->get_accessories_list($entity_id);
        $data['ship_to_party'] = $this->sales_order_register_model->get_ship_to_party_at_update_page($entity_id);
        $data['bill_to_party'] = $this->sales_order_register_model->get_bill_to_party_at_update_page($entity_id);
        $data['product_category'] = $this->sales_order_register_model->get_product_category();
        $data['product_detail_hsn_code'] = $this->sales_order_register_model->get_product_hsn_code();
        $this->load->view('sales/sales_order_register/vw_sales_order_register_update_without_offer',$data);
    }

    public function get_order_details_by_orderid_without_offer()
    {
        $entity_id = $this->input->post('entity_id',TRUE);
        $data = $this->sales_order_register_model->get_order_details_by_offerid_without_offer_model($entity_id)->result();
        echo json_encode($data);
    }

    public function view_sales_order_data_without_offer()
    {
        $entity_id = $this->uri->segment(2);
        $data['entity_id'] = $entity_id;
        $data['customer_list'] = $this->sales_order_register_model->get_customer_list();
        $data['employee_list'] = $this->sales_order_register_model->get_employee_list();
        $data['payment_term_list'] = $this->sales_order_register_model->get_payment_term_list();
        $data['product_list'] = $this->sales_order_register_model->get_product_list();
        $data['order_product_list'] = $this->sales_order_register_model->get_order_product_list_by_id($entity_id);
        $order_data = $this->sales_order_register_model->get_order_details_by_offerid_model_without_offer($entity_id);
        $data['order_result'] = $order_data;
        $data['order_accessories_list'] = $this->sales_order_register_model->get_order_accessories_list_by_id($entity_id);
        $data['accessories_list'] = $this->sales_order_register_model->get_accessories_list($entity_id);
        $this->load->view('sales/sales_order_register/vw_sales_order_register_view_without_offer.php',$data);
    }

    public function update_pending_sales_order_without_offer()
    {
        $entity_id = $this->uri->segment(2);
        $data['entity_id'] = $entity_id;
        $data['customer_list'] = $this->sales_order_register_model->get_customer_list();
        $data['employee_list'] = $this->sales_order_register_model->get_employee_list();
        $data['payment_term_list'] = $this->sales_order_register_model->get_payment_term_list();
        $data['product_list'] = $this->sales_order_register_model->get_product_list();
        $data['order_product_list'] = $this->sales_order_register_model->get_order_product_list_by_id($entity_id);
        $order_data = $this->sales_order_register_model->get_order_details_by_offerid_model_without_offer($entity_id);
        $data['order_result'] = $order_data;
        $data['order_accessories_list'] = $this->sales_order_register_model->get_order_accessories_list_by_id($entity_id);
        $data['accessories_list'] = $this->sales_order_register_model->get_accessories_list($entity_id);
        $data['order_result'] = $order_data;
        $this->load->view('sales/sales_order_register/vw_pending_sales_order_without_offer_update',$data);
    }

    public function get_ship_to_data()
    {
        $data = $this->input->post();
        $offer_entity_id = $this->input->post('offer_entity_id');
        $id = $this->input->post('id');

        $this->db->select('customer_master.*,
                           customer_contact_master.contact_person,
                           customer_contact_master.email_id,
                           customer_contact_master.first_contact_no');
        $this->db->from('customer_master');
        $this->db->join('customer_contact_master', 'customer_master.customer_id = customer_contact_master.customer_id', 'INNER');
        $where = '(customer_master.entity_id = "'.$id.'" )';
        $this->db->where($where);
        $customer_address_master_ship = $this->db->get();
        $customer_address_master_ship_query_result = $customer_address_master_ship->row();

        $this->db->select('*');
        $this->db->from('sales_order_register');
        $where = '(sales_order_register.offer_id = "'.$offer_entity_id.'" )';
        $this->db->where($where);
        $this->db->order_by('sales_order_register.entity_id', 'DESC');
        $this->db->limit(1);
        $query_data = $this->db->get();
        $query_result = $query_data->row();
        $sales_order_entity_id = $query_result->entity_id;


       

        $entity_id = $customer_address_master_ship_query_result->entity_id;
        $customer_id = $customer_address_master_ship_query_result->customer_id;
        $party_name = $customer_address_master_ship_query_result->party_name;
        $address_type = $customer_address_master_ship_query_result->address_type;
        $address = $customer_address_master_ship_query_result->address;

        $state_id = $customer_address_master_ship_query_result->state_id;
        $city_id = $customer_address_master_ship_query_result->city_id;
        $pin_code = $customer_address_master_ship_query_result->pin_code;
        $state_code = $customer_address_master_ship_query_result->state_code;
        $gst_no = $customer_address_master_ship_query_result->gst_no;
        $pan_no = $customer_address_master_ship_query_result->pan_no;
        $contact_person = $customer_address_master_ship_query_result->contact_person;
        $email_id = $customer_address_master_ship_query_result->email_id;
        $first_contact_no = $customer_address_master_ship_query_result->first_contact_no;

        $update_order_array = array('customer_ship_to_name' => $party_name , 'customer_ship_to_address' => $address , 'customer_ship_to_gst_no' => $gst_no , 'customer_ship_to_contact_person' => $contact_person , 'customer_ship_to_contact_person_mail' => $email_id , 'customer_ship_to_contact_person_no' => $first_contact_no);

            $where = '(entity_id ="'.$sales_order_entity_id.'")';
            $this->db->where($where);
            $this->db->update('sales_order_register',$update_order_array);

        
        if(!empty($data))
        {
            //$sales_order_entity_id = $this->input->post('id');
            
            $data = $this->sales_order_register_model->get_ship_to_data_address_id($sales_order_entity_id);
            echo json_encode([$data]);
        }
    }

    public function get_bill_to_data()
    {
        $data = $this->input->post();
        
        if(!empty($data))
        {
            $address_id = $this->input->post('id');
            
            $data = $this->sales_order_register_model->get_bill_to_data_address_id($address_id);
            echo json_encode([$data]);
        }
    }


    public function get_accessories_qty()
    {
        $accessories_id = $this->input->post('id');
        $this->db->select('sales_order_product_relation.rfq_qty');
        $this->db->from('sales_order_product_relation');
        $where = '(sales_order_product_relation.entity_id = "'.$accessories_id.'" )';
        $this->db->where($where);
        $sales_order_product_relation_query_data = $this->db->get();
        $data = $sales_order_product_relation_query_data->row();
       
        echo json_encode([$data]);
        
    }

    public function update_rejected_sales_order_without_offer_data()
    {
        $entity_id = $this->uri->segment(2);
        $data['entity_id'] = $entity_id;
        $data['customer_list'] = $this->sales_order_register_model->get_customer_list();
        $data['employee_list'] = $this->sales_order_register_model->get_employee_list();
        $data['payment_term_list'] = $this->sales_order_register_model->get_payment_term_list();
        $data['product_list'] = $this->sales_order_register_model->get_product_list();
        $data['order_product_list'] = $this->sales_order_register_model->get_order_product_list_by_id($entity_id);
        $order_data = $this->sales_order_register_model->get_order_details_by_offerid_model_without_offer($entity_id);
        $data['order_result'] = $order_data;
        $data['order_accessories_list'] = $this->sales_order_register_model->get_order_accessories_list_by_id($entity_id);
        $data['accessories_list'] = $this->sales_order_register_model->get_accessories_list($entity_id);
        $data['ship_to_party'] = $this->sales_order_register_model->get_ship_to_party_at_update_page($entity_id);
        $data['bill_to_party'] = $this->sales_order_register_model->get_bill_to_party_at_update_page($entity_id);
        $this->load->view('sales/sales_order_register/vw_rejected_sales_order_register_update_without_offer',$data);
    }

    public function update_new_product_in_sales_order()
    {
        $entity_id = $this->input->post('entity_id');
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

        $pop_up_hsn_code = $this->input->post('pop_up_hsn_code');
        $category_id = $this->input->post('category_id');
        $sub_category_id = $this->input->post('sub_category_id');
        $product_id = $this->input->post('product_id');
        $product_name = $this->input->post('product_name');
        $product_long_desc = $this->input->post('product_long_desc');
        $product_type = 1;
        $product_sourcing_type = $this->input->post('product_sourcing_type');
        $product_warranty = $this->input->post('product_warranty');
        $product_unit = $this->input->post('product_unit');
        $product_price = $this->input->post('product_price');

        $this->db->select('*');
        $this->db->from('sales_order_register');
        $where = '(sales_order_register.entity_id = "'.$entity_id.'" )';
        $this->db->where($where);
        $query_data = $this->db->get();
        $query_result = $query_data->row_array();

        $order_customer_id = $query_result['customer_id'];

        $update_order_array = array('sales_order_description' => $order_descrption , 'order_engg_name' => $employee_id , 'terms_conditions' => $terms_conditions , 'dispatch_address' => $dispatch_address , 'delivery_instruction' => $delivery_instruction , 'packing_forwarding' => $packing_forwarding ,'special_customer' => $special_customer , 'payment_term' => $payment_term , 'special_packing' => $special_instruction , 'salutation' => $salutation, 'price_basis' => $price_basis, 'transport_insurance' => $transport_insurance, 'tax' => $tax, 'delivery_schedule' => $delivery_schedule, 'mode_of_payment' => $mode_of_payment, 'mode_of_transport' => $mode_of_transport, 'guarantee_warrenty' => $guarantee_warrenty);

        $where = '(entity_id ="'.$entity_id.'")';
        $this->db->where($where);
        $this->db->update('sales_order_register',$update_order_array);

        $product_data = array('category_id' => $category_id , 'subcategory_id' => $sub_category_id , 'product_id' => $product_id , 'product_name' => $product_name ,'product_long_description' => $product_long_desc , 'product_type' => $product_type , 'sourcing_type' => $product_sourcing_type , 'warrenty' => $product_warranty , 'hsn_id' => $pop_up_hsn_code , 'status' => 1 , 'unit' => $product_unit);

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
        $this->db->from('customer_master');
        $where = '(customer_master.entity_id = "'.$order_customer_id.'" )';
        $this->db->where($where);
        $customer_address_master = $this->db->get();
        $customer_address_master_result = $customer_address_master->row();

        $state_code = $customer_address_master_result->state_code;

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


        $order_product_relation_save = "INSERT INTO sales_order_product_relation (sales_order_id , product_id , rfq_qty , price , total_amount_without_gst , cgst_discount , sgst_discount , igst_discount , cgst_amount , sgst_amount , igst_amount , total_amount_with_gst , product_warranty , discount , discount_amt , unit_discounted_price) VALUES ('".$entity_id."' , '".$product_lastid."' , '".$rfq_qty."' , '".$price."' , '".$total_amount_without_gst."' , '".$cgst_percentage."' , '".$sgst_percentage."' , '".$igst_percentage."' , '".$cgst_amount."' , '".$sgst_amount."' , '".$igst_amount."' , '".$total_amount."' , '".$product_warrenty."' , '".$discount."' , '".$discount_amt."' , '".$unit_discounted_price."')";
        $save_order_product_relation = $this->db->query($order_product_relation_save);

        $data = $entity_id;
        echo json_encode($data);
    }

    public function create_new_product_in_sales_order()
    {
        $offer_entity_id = $this->input->post('offer_entity_id');
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
        $sales_order_type = $this->input->post('sales_order_type');

        $pop_up_hsn_code = $this->input->post('pop_up_hsn_code');
        $category_id = $this->input->post('category_id');
        $sub_category_id = $this->input->post('sub_category_id');
        $product_id = $this->input->post('product_id');
        $product_name = $this->input->post('product_name');
        $product_long_desc = $this->input->post('product_long_desc');
        $product_type = 1;
        $product_sourcing_type = $this->input->post('product_sourcing_type');
        $product_warranty = $this->input->post('product_warranty');
        $product_unit = $this->input->post('product_unit');
        $product_price = $this->input->post('product_price');

        $this->db->select('*');
        $this->db->from('sales_order_register');
        $where = '(sales_order_register.offer_id = "'.$offer_entity_id.'" )';
        $this->db->where($where);
        $this->db->order_by('sales_order_register.entity_id', 'DESC');
        $this->db->limit(1);
        $query_data = $this->db->get();
        $query_result = $query_data->row_array();

        $order_entity_id = $query_result['entity_id'];
        $order_customer_id = $query_result['customer_id'];

        $update_order_array = array('sales_order_description' => $order_descrption , 'order_engg_name' => $employee_id , 'terms_conditions' => $terms_conditions , 'dispatch_address' => $dispatch_address , 'delivery_instruction' => $delivery_instruction , 'packing_forwarding' => $packing_forwarding ,'special_customer' => $special_customer , 'payment_term' => $payment_term , 'special_packing' => $special_instruction , 'salutation' => $salutation, 'price_basis' => $price_basis, 'transport_insurance' => $transport_insurance, 'tax' => $tax, 'delivery_schedule' => $delivery_schedule, 'mode_of_payment' => $mode_of_payment, 'mode_of_transport' => $mode_of_transport, 'guarantee_warrenty' => $guarantee_warrenty, 'sales_order_type' => $sales_order_type);

        $where = '(entity_id ="'.$order_entity_id.'")';
        $this->db->where($where);
        $this->db->update('sales_order_register',$update_order_array);

        $product_data = array('category_id' => $category_id , 'subcategory_id' => $sub_category_id , 'product_id' => $product_id , 'product_name' => $product_name ,'product_long_description' => $product_long_desc , 'product_type' => $product_type , 'sourcing_type' => $product_sourcing_type , 'warrenty' => $product_warranty , 'hsn_id' => $pop_up_hsn_code , 'status' => 1 , 'unit' => $product_unit);

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
        $this->db->from('customer_master');
        $where = '(customer_master.entity_id = "'.$order_customer_id.'")';
        $this->db->where($where);
        $customer_address_master = $this->db->get();
        $customer_address_master_result = $customer_address_master->row();

        $state_code = $customer_address_master_result->state_code;

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


        $order_product_relation_save = "INSERT INTO sales_order_product_relation (sales_order_id , product_id , rfq_qty , price , total_amount_without_gst , cgst_discount , sgst_discount , igst_discount , cgst_amount , sgst_amount , igst_amount , total_amount_with_gst , product_warranty , discount , discount_amt , unit_discounted_price) VALUES ('".$order_entity_id."' , '".$product_lastid."' , '".$rfq_qty."' , '".$price."' , '".$total_amount_without_gst."' , '".$cgst_percentage."' , '".$sgst_percentage."' , '".$igst_percentage."' , '".$cgst_amount."' , '".$sgst_amount."' , '".$igst_amount."' , '".$total_amount."' , '".$product_warrenty."' , '".$discount."' , '".$discount_amt."' , '".$unit_discounted_price."')";
        $save_order_product_relation = $this->db->query($order_product_relation_save);

        $data = $order_entity_id;
        echo json_encode($data);
    }

    public function update_rejected_sales_order_contain()
    {
        if(!empty($_FILES['order_attachment']['name']))
        {
            $order_entity_id = $this->input->post('order_entity_id');

            $attachment_img = "";
            foreach ($_FILES as $key => $value) {
                
                $file_name = $value['name'];
                $file_source_path = $value['tmp_name'];
                $file_upload_combine_array = array_combine($file_name, $file_source_path);
                //print_r($file_upload_combine_array);
                
                foreach ($file_upload_combine_array as $image_name=> $image_source_path) {

                    $ext = pathinfo($image_name,PATHINFO_EXTENSION);

                    $order_attachment_upload = substr(str_replace(" ", "_", $image_name), 0);
                    move_uploaded_file($image_source_path, 'assets/order_attachment/'.$order_attachment_upload);

                    $attachment_img .= $order_attachment_upload.',';
                }  
            }

            $this->db->select('*');
            $this->db->from('sales_order_register');
            $where = '(sales_order_register.entity_id = "'.$order_entity_id.'" )';
            $this->db->where($where);
            $query_data = $this->db->get();
            $query_result = $query_data->row_array();

            $offer_entity_id = $query_result['offer_id'];
            $attachment_check_result = $query_result['attachment'];

            if(!empty($attachment_check_result))
            {
                $order_attachment_img = $attachment_check_result.$attachment_img;
            }else{
                $order_attachment_img = $attachment_img;
            }

            $order_descrption = $this->input->post('order_descrption');
            $employee_id = $this->input->post('employee_id');
            $terms_conditions = $this->input->post('terms_conditions');
            $delivery_period = $this->input->post('delivery_period');
            $order_freight = $this->input->post('order_freight');
            $freight_charges = $this->input->post('freight_charges');
            $dispatch_address = $this->input->post('dispatch_address');
            $delivery_instruction = $this->input->post('delivery_instruction');
            $packing_forwarding = $this->input->post('packing_forwarding');
            $packing_forwarding_charges = $this->input->post('packing_forwarding_charges');
            $payment_term = $this->input->post('payment_term');
            $special_instruction = $this->input->post('special_instruction');
            $order_insurance = $this->input->post('order_insurance');
            $insurance_charges = $this->input->post('insurance_charges');
            $purchase_order_number = $this->input->post('purchase_order_number');
            $purchase_order_date = $this->input->post('purchase_order_date');
            $order_status = 2;
            $special_customer = $this->input->post('special_customer');

            $salutation = $this->input->post('salutation');
            $price_basis = $this->input->post('price_basis');
            $transport_insurance = $this->input->post('transport_insurance');
            $tax = $this->input->post('tax');
            $delivery_schedule = $this->input->post('delivery_schedule');
            $mode_of_payment = $this->input->post('mode_of_payment');
            $mode_of_transport = $this->input->post('mode_of_transport');
            $guarantee_warrenty = $this->input->post('guarantee_warrenty');
            $payment_term = $this->input->post('payment_term');
            $order_execuation_status = NULL;

            $this->db->select('*');
            $this->db->from('offer_register');
            $where = '(offer_register.entity_id = "'.$offer_entity_id.'" )';
            $this->db->where($where);
            $offer_register_data = $this->db->get();
            $offer_register_result = $offer_register_data->row_array();

            $enquiry_entity_id = $query_result['enquiry_id'];

            $update_order_array = array('sales_order_description' => $order_descrption , 'order_engg_name' => $employee_id , 'special_customer' => $special_customer , 'terms_conditions' => $terms_conditions , 'delivery_period' => $delivery_period , 'transportation' => $order_freight , 'transportation_price' => $freight_charges , 'dispatch_address' => $dispatch_address , 'delivery_instruction' => $delivery_instruction , 'packing_forwarding' => $packing_forwarding , 'packing_forwarding_price' => $packing_forwarding_charges , 'payment_term' => $payment_term , 'special_packing' => $special_instruction , 'insurance' => $order_insurance , 'insurance_price' => $insurance_charges , 'po_no' => $purchase_order_number , 'po_date' => $purchase_order_date , 'attachment' => $order_attachment_img , 'status' => $order_status, 'price_basis' => $price_basis, 'salutation' => $salutation, 'transport_insurance' => $transport_insurance, 'tax' => $tax, 'delivery_schedule' => $delivery_schedule, 'mode_of_payment' => $mode_of_payment, 'mode_of_transport' => $mode_of_transport, 'guarantee_warrenty' => $guarantee_warrenty, 'order_execution_status' =>$order_execuation_status);

            $where = '(entity_id ="'.$order_entity_id.'")';
            $this->db->where($where);
            $this->db->update('sales_order_register',$update_order_array);

            if($order_status == 3)
            {
                $offer_status = 7;
                $update_offer_array = array('status' => $offer_status);
                $where = '(entity_id ="'.$offer_entity_id.'")';
                $this->db->where($where);
                $this->db->update('offer_register',$update_offer_array);

                $enquiry_status = 6;
                $update_enquiry_array = array('enquiry_status' => $enquiry_status);
                $where = '(entity_id ="'.$enquiry_entity_id.'")';
                $this->db->where($where);
                $this->db->update('enquiry_register',$update_enquiry_array);
            }
            redirect('vw_sales_order_data'); 
        }else{
            $order_entity_id = $this->input->post('order_entity_id');
            $order_descrption = $this->input->post('order_descrption');
            $employee_id = $this->input->post('employee_id');
            $terms_conditions = $this->input->post('terms_conditions');
            $delivery_period = $this->input->post('delivery_period');
            $order_freight = $this->input->post('order_freight');
            $freight_charges = $this->input->post('freight_charges');
            $dispatch_address = $this->input->post('dispatch_address');
            $delivery_instruction = $this->input->post('delivery_instruction');
            $packing_forwarding = $this->input->post('packing_forwarding');
            $packing_forwarding_charges = $this->input->post('packing_forwarding_charges');
            $payment_term = $this->input->post('payment_term');
            $special_instruction = $this->input->post('special_instruction');
            $order_insurance = $this->input->post('order_insurance');
            $insurance_charges = $this->input->post('insurance_charges');
            $purchase_order_number = $this->input->post('purchase_order_number');
            $purchase_order_date = $this->input->post('purchase_order_date');
            $order_status = 2;
            $special_customer = $this->input->post('special_customer');

            $salutation = $this->input->post('salutation');
            $price_basis = $this->input->post('price_basis');
            $transport_insurance = $this->input->post('transport_insurance');
            $tax = $this->input->post('tax');
            $delivery_schedule = $this->input->post('delivery_schedule');
            $mode_of_payment = $this->input->post('mode_of_payment');
            $mode_of_transport = $this->input->post('mode_of_transport');
            $guarantee_warrenty = $this->input->post('guarantee_warrenty');
            $payment_term = $this->input->post('payment_term');
            $order_execuation_status = NULL;

            $this->db->select('*');
            $this->db->from('sales_order_register');
            $where = '(sales_order_register.entity_id = "'.$order_entity_id.'" )';
            $this->db->where($where);
            $query_data = $this->db->get();
            $query_result = $query_data->row_array();

            $offer_entity_id = $query_result['offer_id'];

            $this->db->select('*');
            $this->db->from('offer_register');
            $where = '(offer_register.entity_id = "'.$offer_entity_id.'" )';
            $this->db->where($where);
            $offer_register_data = $this->db->get();
            $offer_register_result = $offer_register_data->row_array();
            $enquiry_entity_id = $offer_register_result['enquiry_id'];

            $update_order_array = array('sales_order_description' => $order_descrption , 'order_engg_name' => $employee_id , 'special_customer' => $special_customer , 'terms_conditions' => $terms_conditions , 'delivery_period' => $delivery_period , 'transportation' => $order_freight , 'transportation_price' => $freight_charges , 'dispatch_address' => $dispatch_address , 'delivery_instruction' => $delivery_instruction , 'packing_forwarding' => $packing_forwarding , 'packing_forwarding_price' => $packing_forwarding_charges , 'payment_term' => $payment_term , 'special_packing' => $special_instruction , 'insurance' => $order_insurance , 'insurance_price' => $insurance_charges , 'po_no' => $purchase_order_number , 'po_date' => $purchase_order_date , 'status' => $order_status, 'price_basis' => $price_basis, 'salutation' => $salutation, 'transport_insurance' => $transport_insurance, 'tax' => $tax, 'delivery_schedule' => $delivery_schedule, 'mode_of_payment' => $mode_of_payment, 'mode_of_transport' => $mode_of_transport, 'guarantee_warrenty' => $guarantee_warrenty, 'order_execution_status' =>$order_execuation_status);

            $where = '(entity_id ="'.$order_entity_id.'")';
            $this->db->where($where);
            $this->db->update('sales_order_register',$update_order_array);

            if($order_status == 3)
            {
                $offer_status = 7;
                $update_offer_array = array('status' => $offer_status);
                $where = '(entity_id ="'.$offer_entity_id.'")';
                $this->db->where($where);
                $this->db->update('offer_register',$update_offer_array);

                $enquiry_status = 6;
                $update_enquiry_array = array('enquiry_status' => $enquiry_status);
                $en_where = '(entity_id ="'.$enquiry_entity_id.'")';
                $this->db->where($en_where);
                $this->db->update('enquiry_register',$update_enquiry_array);
            }
            redirect('vw_sales_order_data'); 
        }
    }


    public function create_quick_sales_order()
    {
        // $entity_id = $this->uri->segment(2);
        // $offer_data = $this->sales_order_register_model->offer_to_order_save_model($entity_id);
        // $data['entity_id'] = $entity_id;
        // $data['offer_result'] = $offer_data;

        $data['state_list'] = $this->sales_order_register_model->get_state_list();
        $data['customer_list'] = $this->sales_order_register_model->get_customer_list();
        $data['employee_list'] = $this->sales_order_register_model->get_employee_list();
        $data['payment_term_list'] = $this->sales_order_register_model->get_payment_term_list();
        $data['product_list'] = $this->sales_order_register_model->get_product_list();
        // $data['order_product_list'] = $this->sales_order_register_model->get_order_product_list($entity_id);
        $this->load->view('sales/sales_order_register/vw_sales_order_register_quick_create',$data);
    }



    public function insert_quick_sales_order()
    {
        $customer_id = $this->input->post('customer_id');
        $bill_to_company_name = $this->input->post('bill_to_company_name');
        $bill_to_contact_person = $this->input->post('bill_to_contact_person');
        $bill_to_email_id = $this->input->post('bill_to_email_id');
        $bill_to_address = $this->input->post('bill_to_address');
        $bill_to_contact_number = $this->input->post('bill_to_contact_number');
        $customer_bill_to_gst_no = $this->input->post('customer_bill_to_gst_no');
        $ship_to_company_name = $this->input->post('ship_to_company_name');
        $ship_to_contact_person = $this->input->post('ship_to_contact_person');
        $ship_to_email_id = $this->input->post('ship_to_email_id');
        $ship_to_address = $this->input->post('ship_to_address');
        $ship_to_contact_number = $this->input->post('ship_to_contact_number');
        $customer_ship_to_gst_no = $this->input->post('customer_ship_to_gst_no');
        $product_checkbox = $this->input->post('product_checkbox');
        $order_descrption = $this->input->post('order_descrption');
        $employee_id = $this->input->post('employee_id');
        $terms_conditions = $this->input->post('terms_conditions');
        $delivery_period = $this->input->post('delivery_period');
        $order_freight = $this->input->post('order_freight');
        $freight_charges = $this->input->post('freight_charges');
        $dispatch_address = $this->input->post('dispatch_address');
        $delivery_instruction = $this->input->post('delivery_instruction');
        $order_pf = $this->input->post('order_pf');
        $special_customer = $this->input->post('special_customer');
        $packing_forwarding_charges = $this->input->post('packing_forwarding_charges');
        //$payment_term = $this->input->post('payment_term');
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
        //$special_customer = $this->input->post('special_customer');
        $sales_order_type = $this->input->post('sales_order_type');

        $quick_so_status = 1;
        // print_r($quick_so_status);
        // die();

        $this->db->select('*');
        $this->db->from('customer_master');
        $where = '(entity_id = "'.$customer_id.'")';
        $this->db->where($where);
        $customer_address_master = $this->db->get();
        $customer_address_master_data =  $customer_address_master->row();

        $bill_to_party_name = $customer_address_master_data->customer_name;
        $bill_to_party_id = $customer_address_master_data->entity_id;

        $this->db->select('*');
        $this->db->from('customer_master');
        $where = '(entity_id = "'.$customer_id.'")';
        $this->db->where($where);
        $customer_address_master = $this->db->get();
        $customer_address_master_data2 =  $customer_address_master->row();

        $ship_to_party_name = $customer_address_master_data2->customer_name;
        $ship_to_party_id = $customer_address_master_data2->entity_id;

        $this->db->select('sales_order_no');
        $this->db->from('sales_order_register');
        $this->db->order_by('entity_id', 'DESC');
        $this->db->limit(1);
        $sales_order_register = $this->db->get();
        $results_sales_order_register = $sales_order_register->result_array();

        if(!empty($results_sales_order_register))
        {
            $sales_order_serial_no = $results_sales_order_register[0]['sales_order_no'];
            $sales_order_data_seprate = explode('-', $sales_order_serial_no);
            $sales_order_doc_year_data = $sales_order_data_seprate['3'].'-'.$sales_order_data_seprate['4'];
            $sales_order_doc_year_seprate = explode('/', $sales_order_doc_year_data);
            $sales_order_doc_year = $sales_order_doc_year_seprate['0'];
        }

        $this->db->select('document_series_no');
        $this->db->from('documentseries_master');
        $this->db->where('entity_id=4');
        $doc_record=$this->db->get();
        $results_doc_record = $doc_record->result_array();

        $doc_serial_no = $results_doc_record[0]['document_series_no'];
        $doc_data_seprate = explode('-', $doc_serial_no);
        
        $doc_year_data = $doc_data_seprate['2'].'-'.$doc_data_seprate['3'];
        $doc_year_data_seprate = explode('/', $doc_year_data);
        $doc_year = $doc_year_data_seprate['0'];

        $enquiry_type = 6;

        if($enquiry_type == 1){
            $enquiry_prefix = "MH";
        }elseif($enquiry_type == 2){
           $enquiry_prefix = "PS"; 
        }elseif($enquiry_type == 3){
           $enquiry_prefix = "VC"; 
        }elseif($enquiry_type == 4){
           $enquiry_prefix = "TD"; 
        }elseif($enquiry_type == 5){
           $enquiry_prefix = "OT"; 
        }elseif($enquiry_type == 6){
           $enquiry_prefix = "XX"; 
        }

        if(empty($results_sales_order_register[0]['sales_order_no']) || ($sales_order_doc_year != $doc_year))
        {
            $first_no = '0001';
            $doc_no = $doc_data_seprate['0'].'-'.$doc_data_seprate['1'].'-'.$enquiry_prefix.'-'.$doc_year_data.''.$first_no;

        }elseif(!empty($results_sales_order_register) && ($sales_order_doc_year == $doc_year))
        {
            $doc_type = $sales_order_data_seprate['0'].'-'.$sales_order_data_seprate['1'].'-'.$enquiry_prefix;
            $ex_no_data = $sales_order_serial_no;
            $ex_no_data_seprate = explode('/', $ex_no_data);
            $ex_no = $ex_no_data_seprate['1'];
            $next_en = $ex_no + 1;
            $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
            $doc_no = $doc_type.'-'.$sales_order_doc_year.'/'.$next_doc_no;
        }  

        $insert_order_array = array('sales_order_no' => $doc_no,'sales_order_description' => $order_descrption,'customer_id' => $customer_id , 'bill_to_address' => $bill_to_party_id ,'customer_bill_to_name' => $bill_to_company_name,'customer_bill_to_address' => $bill_to_address,'customer_bill_to_gst_no' => $customer_bill_to_gst_no,'customer_bill_to_contact_person' => $bill_to_contact_person,'customer_bill_to_contact_person_mail' => $bill_to_email_id,'customer_bill_to_contact_person_no' => $bill_to_contact_number, 'ship_to_address' => $ship_to_party_id,'customer_ship_to_name' => $ship_to_company_name,'customer_ship_to_address' => $ship_to_address,'customer_ship_to_gst_no' => $customer_ship_to_gst_no,'customer_ship_to_contact_person' => $ship_to_contact_person,'customer_ship_to_contact_person_mail' => $ship_to_email_id,'customer_ship_to_contact_person_no' => $ship_to_contact_number , 'order_engg_name' => $employee_id , 'terms_conditions' => $terms_conditions , 'delivery_period' => $delivery_period , 'transportation' => $order_freight , 'transportation_price' => $freight_charges , 'dispatch_address' => $dispatch_address , 'delivery_instruction' => $delivery_instruction , 'packing_forwarding' => $packing_forwarding ,'special_customer' => $special_customer , 'packing_forwarding_price' => $packing_forwarding_charges , 'payment_term' => $payment_term , 'special_packing' => $special_instruction , 'insurance' => $order_insurance , 'insurance_price' => $insurance_charges , 'status' => 2, 'salutation' => $salutation, 'price_basis' => $price_basis, 'transport_insurance' => $transport_insurance, 'tax' => $tax, 'delivery_schedule' => $delivery_schedule, 'mode_of_payment' => $mode_of_payment, 'mode_of_transport' => $mode_of_transport, 'guarantee_warrenty' => $guarantee_warrenty, 'sales_order_type' => $sales_order_type, 'quick_so_status' => $quick_so_status);
        $data = $this->db->insert('sales_order_register',$insert_order_array);
        $order_master_lastid = $this->db->insert_id();

        foreach ($product_checkbox as $key => $value) 
        {
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
            $product_custom_description = $product_master_result->product_long_description;
            $discount = 0;
            $discount_amt = 0;
            $unit_discounted_price = $total_amount_without_gst - $discount_amt;

            $this->db->select('*');
            $this->db->from('customer_master');
            $where = '(customer_master.entity_id = "'.$customer_id.'")';
            $this->db->where($where);
            $customer_address_master = $this->db->get();
            $customer_address_master_result = $customer_address_master->row();

            $state_code = $customer_address_master_result->state_code;

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

                $this->db->select('sales_order_id');
                $this->db->from('sales_order_product_relation');
                $where_or = '(product_id = "'.$product_id.'" AND sales_order_id = "'.$order_master_lastid.'")';
                $this->db->where($where_or);
                $sales_order_product_exit= $this->db->get();
                $sales_order_product_exit_data_count =  $sales_order_product_exit->num_rows();
                if ($sales_order_product_exit_data_count === 0) 
                {
                $order_product_master_save = "INSERT INTO sales_order_product_relation ( sales_order_id, product_id , rfq_qty , product_custom_description , price , total_amount_without_gst , cgst_discount , sgst_discount , igst_discount , cgst_amount , sgst_amount , igst_amount , total_amount_with_gst , product_warranty , discount , discount_amt , unit_discounted_price) VALUES ('".$order_master_lastid."' ,'".$product_id."' , '".$rfq_qty."' , '".$product_custom_description."' , '".$price."' , '".$total_amount_without_gst."' , '".$cgst_percentage."' , '".$sgst_percentage."' , '".$igst_percentage."' , '".$cgst_amount."' , '".$sgst_amount."' , '".$igst_amount."' , '".$total_amount."' , '".$product_warrenty."' , '".$discount."' , '".$discount_amt."' , '".$unit_discounted_price."')";
                    $product_execute = $this->db->query($order_product_master_save);
                    $this->session->set_userdata('order_product', 'Product Saved....!');
                }
                else{
                $this->session->set_userdata('order_product', $session_product_var.' Product already exist....!');
            }
        }

        $data = $order_master_lastid;

        echo json_encode($data);
    }



    public function update_quick_sales_order_data()
    {
        $entity_id = $this->uri->segment(2);
        $data['entity_id'] = $entity_id;
        $data['customer_list'] = $this->sales_order_register_model->get_customer_list();
        $data['employee_list'] = $this->sales_order_register_model->get_employee_list();
        $data['payment_term_list'] = $this->sales_order_register_model->get_payment_term_list();
        $data['product_list'] = $this->sales_order_register_model->get_product_list();
        $data['order_product_list'] = $this->sales_order_register_model->get_order_product_list_by_id($entity_id);
        $order_data = $this->sales_order_register_model->get_order_details_by_offerid_model($entity_id);
        $data['order_result'] = $order_data;
        $data['order_accessories_list'] = $this->sales_order_register_model->get_order_accessories_list_by_id($entity_id);
        $data['accessories_list'] = $this->sales_order_register_model->get_accessories_list($entity_id);
        $data['ship_to_party'] = $this->sales_order_register_model->get_ship_to_party_at_update_page($entity_id);
        $data['bill_to_party'] = $this->sales_order_register_model->get_bill_to_party_at_update_page($entity_id);
        $data['product_category'] = $this->sales_order_register_model->get_product_category();
        $data['product_detail_hsn_code'] = $this->sales_order_register_model->get_product_hsn_code();
        $this->load->view('sales/sales_order_register/vw_sales_order_register_quick_update',$data);
    }


    public function view_quick_sales_order_data()
    {
        $entity_id = $this->uri->segment(2);
        $data['entity_id'] = $entity_id;
        $data['customer_list'] = $this->sales_order_register_model->get_customer_list();
        $data['employee_list'] = $this->sales_order_register_model->get_employee_list();
        $data['payment_term_list'] = $this->sales_order_register_model->get_payment_term_list();
        $data['product_list'] = $this->sales_order_register_model->get_product_list();
        $data['order_product_list'] = $this->sales_order_register_model->get_order_product_list_by_id($entity_id);
        $order_data = $this->sales_order_register_model->get_order_details_by_offerid_model($entity_id);
        $data['order_result'] = $order_data;
        $data['order_accessories_list'] = $this->sales_order_register_model->get_order_accessories_list_by_id($entity_id);
        $data['accessories_list'] = $this->sales_order_register_model->get_accessories_list($entity_id);
        $this->load->view('sales/sales_order_register/vw_quick_sales_order_register_view.php',$data);
    }







    public function set_duplicate_order()
    {
        $entity_id = $this->uri->segment(2);
        $duplicate_order_data = $this->sales_order_register_model->set_duplicate_order_model($entity_id);
        $data['entity_id'] = $entity_id;
        $data['duplicate_order_result'] = $duplicate_order_data;
        $data['customer_list'] = $this->sales_order_register_model->get_customer_list();

        $data['employee_list'] = $this->sales_order_register_model->get_employee_list();
        $data['payment_term_list'] = $this->sales_order_register_model->get_payment_term_list();
        $data['product_list'] = $this->sales_order_register_model->get_product_list();
        /*$data['ship_to_data_list'] = $this->sales_order_register_model->ship_to_data_list_model($entity_id);*/
        // print_r($data['ship_to_data_list']);
        // die();

        $data['ship_to_party'] = $this->sales_order_register_model->get_ship_to_party();
        $data['bill_to_party'] = $this->sales_order_register_model->get_bill_to_party();

        /*$data['bill_to_data_list'] = $this->sales_order_register_model->bill_to_data_list_model($entity_id);*/
        $data['order_product_list'] = $this->sales_order_register_model->get_order_product_list($entity_id);
        $data['order_accessories_list'] = $this->sales_order_register_model->get_order_accessories_list($entity_id);
        $data['accessories_list'] = $this->sales_order_register_model->get_accessories_list($entity_id);

        $data['product_category'] = $this->sales_order_register_model->get_product_category();
        $data['product_detail_hsn_code'] = $this->sales_order_register_model->get_product_hsn_code();
        //$this->load->view('sales/sales_order_register/vw_sales_order_register_create',$data);
    }
}
?>
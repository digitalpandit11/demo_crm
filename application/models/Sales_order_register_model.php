<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Sales_order_register_model extends CI_Model{

    public function offer_to_order_save_model($entity_id)
    {

        $this->db->select('*');
        $this->db->from('offer_register');
        $where = '(entity_id = "'.$entity_id.'")';
        $this->db->where($where);
        $offer_register_master = $this->db->get();
        $offer_register_master_data =  $offer_register_master->row();
        

        $offer_id = $offer_register_master_data->entity_id;
        $offer_description = $offer_register_master_data->offer_description;
        $customer_id = $offer_register_master_data->customer_id;
        // print_r($customer_id);
        // die();
        $emp_id = $offer_register_master_data->offer_engg_name;
        $freight_status = $offer_register_master_data->Transportation;
        $freight_charges = $offer_register_master_data->transportation_price;
        $delivery_period = $offer_register_master_data->delivery_period;
        $dispatch_address = $offer_register_master_data->dispatch_address;
        $delivery_instruction = $offer_register_master_data->delivery_instruction;
        $packing_forwarding = $offer_register_master_data->packing_forwarding;
        $packing_forwarding_price = $offer_register_master_data->packing_forwarding_price;
        $insurance = $offer_register_master_data->insurance;
        $insurance_price = $offer_register_master_data->insurance_price;
        $special_packing = $offer_register_master_data->special_packing;
        $payment_term = $offer_register_master_data->payment_term;
        $terms_conditions = $offer_register_master_data->terms_conditions;

        $salutation = $offer_register_master_data->salutation;
        $price_basis = $offer_register_master_data->price_basis;
        $transport_insurance = $offer_register_master_data->transport_insurance;
        $tax = $offer_register_master_data->tax;
        $delivery_schedule = $offer_register_master_data->delivery_schedule;
        $mode_of_payment = $offer_register_master_data->mode_of_payment;
        $mode_of_transport = $offer_register_master_data->mode_of_transport;
        $guarantee_warrenty = $offer_register_master_data->guarantee_warrenty;
        $status = '1';

        $this->db->select('customer_master.*,state_master.state_name,city_master.city_name,customer_master.customer_name');
        $this->db->from('customer_master');
        $where = '(customer_master.entity_id = "'.$customer_id.'")';
        $this->db->join('state_master', 'customer_master.state_id = state_master.entity_id', 'INNER');
        $this->db->join('city_master', 'customer_master.city_id = city_master.entity_id', 'INNER');
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
        $bill_to_customer_name = $bill_to_address_data->customer_name;
        $new_bill_to_address = $bill_to_address.'  '.$bill_to_state_name.' , '.$bill_to_city_name.' , '.$bill_to_pin_code;

        $this->db->select('customer_master.*,state_master.state_name,city_master.city_name,customer_master.customer_name');
        $this->db->from('customer_master');
        $where = '(customer_master.entity_id = "'.$customer_id.'")';
        $this->db->join('state_master', 'customer_master.state_id = state_master.entity_id', 'INNER');
        $this->db->join('city_master', 'customer_master.city_id = city_master.entity_id', 'INNER');
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
        $ship_to_customer_name = $bill_to_address_data->customer_name;

        $new_ship_to_address = $ship_to_address.'  '.$ship_to_state_name.' , '.$ship_to_city_name.' , '.$ship_to_pin_code;


        $this->db->select('*');
        $this->db->from('customer_contact_master');
        $where = '(customer_id = "'.$customer_id.'")';
        $this->db->where($where);
        $ship_to_contact = $this->db->get();
        $ship_to_contact_data =  $ship_to_contact->row();

        if(!empty($ship_to_contact_data))
        {
            $ship_to_contact_id = $ship_to_contact_data->entity_id;
            $ship_to_contact_person = $ship_to_contact_data->contact_person;
            $ship_to_email_id = $ship_to_contact_data->email_id;
            $ship_to_first_contact_no = $ship_to_contact_data->first_contact_no;
        }else{
            $ship_to_contact_id = NULL;
            $ship_to_contact_person = NULL;
            $ship_to_email_id = NULL;
            $ship_to_first_contact_no = NULL;
        }
        

        $this->db->select('*');
        $this->db->from('customer_contact_master');
        $where = '(customer_id = "'.$customer_id.'")';
        $this->db->where($where);
        $bill_to_contact = $this->db->get();
        $bill_to_contact_data =  $ship_to_contact->row();

        if(!empty($bill_to_contact_data))
        {
            $bill_to_contact_id = $ship_to_contact_data->entity_id;
            $bill_to_contact_person = $ship_to_contact_data->contact_person;
            $bill_to_email_id = $ship_to_contact_data->email_id;
            $bill_to_first_contact_no = $ship_to_contact_data->first_contact_no;
        }else{
            $bill_to_contact_id = NULL;
            $bill_to_contact_person = NULL;
            $bill_to_email_id = NULL;
            $bill_to_first_contact_no = NULL;
        }



        /*date_default_timezone_set("Asia/Calcutta");
        $offer_date = date('Y-m-d');*/

        //check sales_order_register id exist or not code
        $this->db->select('*');
        $this->db->from('sales_order_register');
        $where_or = '(offer_id = "'.$entity_id.'")';
        $this->db->where($where_or);
        $sales_order_exit= $this->db->get();
        $sales_order_exit_data_count =  $sales_order_exit->num_rows();
        if ($sales_order_exit_data_count === 0) 
        {
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

            $this->db->select('enquiry_id');
            $this->db->from('offer_register');
            $where_or = '(entity_id = "'.$entity_id.'")';
            $this->db->where($where_or);
            $enquiry_id_data= $this->db->get();
            $enquiry_id_result =  $enquiry_id_data->row_array();

            $Enquiry_id = $enquiry_id_result['enquiry_id'];

            $this->db->select('enquiry_type');
            $this->db->from('enquiry_register');
            $where_or = '(entity_id = "'.$Enquiry_id.'")';
            $this->db->where($where_or);
            $enquiry_type_data= $this->db->get();
            $enquiry_type_result =  $enquiry_type_data->row_array();

            $enquiry_type = $enquiry_type_result['enquiry_type'];

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
               $enquiry_prefix = "CUH & TD-MH"; 
            }elseif($enquiry_type == 7){
               $enquiry_prefix = "TD-PS"; 
            }elseif($enquiry_type == 8){
               $enquiry_prefix = "TD-VC"; 
            }else{
                $enquiry_prefix ="OTHER";
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


            $inst_arr = Array('sales_order_no' => $doc_no , 'offer_id' => $offer_id , 'customer_id' => $customer_id , 'bill_to_address' => $bill_to_address_id , 'ship_to_address' => $ship_to_address_id ,'customer_bill_to_name' => $bill_to_customer_name ,'customer_bill_to_address' => $new_bill_to_address ,'customer_bill_to_gst_no' => $bill_to_gst_no ,'customer_bill_to_contact_person' => $bill_to_contact_person ,'customer_bill_to_contact_person_mail' => $bill_to_email_id ,'customer_bill_to_contact_person_no' => $bill_to_first_contact_no ,'customer_ship_to_name' => $ship_to_customer_name ,'customer_ship_to_address' => $new_ship_to_address ,'customer_ship_to_gst_no' => $ship_to_gst_no ,'customer_ship_to_contact_person' => $ship_to_contact_person ,'customer_ship_to_contact_person_mail' => $ship_to_email_id ,'customer_ship_to_contact_person_no' => $ship_to_first_contact_no,'ship_to_contact_person' => $ship_to_contact_id , 'sales_order_description' => $offer_description , 'special_customer' => 6 , 'order_engg_name' => $emp_id , 'delivery_period' => $delivery_period , 'delivery_instruction' => $delivery_instruction , 'transportation' => $freight_status , 'transportation_price' => $freight_charges , 'dispatch_address' => $dispatch_address , 'packing_forwarding_price' => $packing_forwarding_price , 'insurance_price' => $insurance_price , 'payment_term' => $payment_term , 'packing_forwarding' => $packing_forwarding , 'insurance' => $insurance , 'special_packing' => $special_packing , 'terms_conditions' => $terms_conditions , 'salutation' => $salutation ,'price_basis' => $price_basis ,'transport_insurance' => $transport_insurance ,'tax' => $tax ,'delivery_schedule' => $delivery_schedule ,'mode_of_payment' => $mode_of_payment ,'mode_of_transport' => $mode_of_transport ,'guarantee_warrenty' => $guarantee_warrenty , 'status' => 1 , 'invoice_status' => 1);

            $this->db->insert('sales_order_register', $inst_arr);
            $order_master_lastid = $this->db->insert_id();

            $this->db->select('*');
            $this->db->from('offer_product_relation');
            $where_p = '(offer_id = "'.$entity_id.'")';
            $this->db->where($where_p);
            $order_master_product = $this->db->get();
            $order_master_product_data =  $order_master_product->result_array();

            foreach ($order_master_product_data as $key => $value) {

                $product_id = $value['product_id'];
                $product_qty = $value['rfq_qty'];
                $delivery_period = $value['delivery_period'];
                $product_custom_description = $value['product_custom_description'];
                $price = $value['price'];
                $discount = $value['discount'];
                $discount_amt = $value['discount_amt'];
                $product_warranty = $value['product_warranty'];
                $unit_discounted_price = $value['unit_discounted_price'];
                $total_amount_without_gst = $value['total_amount_without_gst'];
                $cgst_discount = $value['cgst_discount'];
                $cgst_amt = $value['cgst_amt'];
                $sgst_discount = $value['sgst_discount'];
                $sgst_amt = $value['sgst_amt'];
                $igst_discount = $value['igst_discount'];
                $igst_amt = $value['igst_amt'];
                $total_amount_with_gst = $value['total_amount_with_gst'];

                $order_product_master_save = "INSERT INTO sales_order_product_relation (sales_order_id, product_id, rfq_qty, delivery_period, product_custom_description, price, discount, discount_amt, total_amount_without_gst, cgst_discount, cgst_amount, sgst_discount, sgst_amount, igst_discount, igst_amount, total_amount_with_gst, product_warranty, unit_discounted_price) VALUES ('".$order_master_lastid."', '".$product_id."', '".$product_qty."', '".$delivery_period."', '".$product_custom_description."', '".$price."', '".$discount."', '".$discount_amt."', '".$total_amount_without_gst."', '".$cgst_discount."', '".$cgst_amt."', '".$sgst_discount."', '".$sgst_amt."', '".$igst_discount."', '".$igst_amt."', '".$total_amount_with_gst."', '".$product_warranty."', '".$unit_discounted_price."')";
                    $product_execute = $this->db->query($order_product_master_save);
            }
        }
    }

    public function get_customer_list()
    {
        $this->db->select('*');
        $this->db->from('customer_master');
        $where = '(customer_master.status != "'.'3'.'")';
        $this->db->where($where);
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_employee_list()
    {
        $this->db->select('entity_id,
            CONCAT(employee_id,'.'" - "'.', emp_first_name) AS Emp_name');
        $this->db->from('employee_master');
        $this->db->order_by('entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_payment_term_list()
    {
        $this->db->select('*');
        $this->db->from('payment_terms_master');
        $where = '(payment_terms_master.payment_type = "'.'1'.'")';
        $this->db->where($where);
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_product_list()
    {
        date_default_timezone_set("Asia/Calcutta");
        $product_year = date('Y');

        $this->db->select('product_master.*,
            product_pricelist_master.price');
        $this->db->from('product_master');
        $where = '(product_pricelist_master.year = "'.$product_year.'" )';
        $this->db->where($where);
        $this->db->join('product_pricelist_master', 'product_master.entity_id = product_pricelist_master.product_id', 'INNER');
        $this->db->order_by('product_master.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();

        if(empty($query_result))
        {
            $this->db->select('product_master.*,
            product_pricelist_master.price');
            $this->db->from('product_master');
            $this->db->join('product_pricelist_master', 'product_master.entity_id = product_pricelist_master.product_id', 'INNER');
            $this->db->order_by('product_master.entity_id', 'DESC');
             $this->db->group_by('product_master.entity_id');
            $query_data = $this->db->get();
            $data_query_result = $query_data->result();
            return $data_query_result;  
        }else{
            return $query_result; 
        }  
    }

    public function get_order_product_list($entity_id)
    {
        $this->db->select('*');
        $this->db->from('sales_order_register');
        $where = '(sales_order_register.offer_id = "'.$entity_id.'" )';
        $this->db->where($where);
        $this->db->order_by('sales_order_register.entity_id', 'DESC');
        $this->db->limit(1);
        $query_data = $this->db->get();
        $query_result = $query_data->row_array();

        $sales_order_entity_id = $query_result['entity_id'];

        $this->db->select('sales_order_product_relation.*,
            product_master.product_name,
            product_master.product_id,
            product_hsn_master.hsn_code');
        $this->db->from('sales_order_product_relation');
        $this->db->join('product_master', 'sales_order_product_relation.product_id = product_master.entity_id', 'INNER');
        $this->db->join('product_hsn_master', 'product_master.hsn_id = product_hsn_master.entity_id', 'INNER');
        $where = '(sales_order_product_relation.sales_order_id = "'.$sales_order_entity_id.'" )';
        $this->db->where($where);
        $query = $this->db->get();
        $query_data_result = $query->result();
        return $query_data_result;  
    }

    public function get_order_details_by_id_model($entity_id)
    {
        $this->db->select('*');
        $this->db->from('sales_order_register');
        $where = '(sales_order_register.offer_id = "'.$entity_id.'" )';
        $this->db->where($where);
        $this->db->order_by('sales_order_register.entity_id', 'DESC');
        $this->db->limit(1);
        $query_data = $this->db->get();
        $query_result = $query_data->row_array();

        $sales_order_entity_id = $query_result['entity_id'];


        $enq_id = $this->db->select('enquiry_id')->from('offer_register')->where('entity_id',$entity_id)->get()->row_array();

        $enquiry_id = $enq_id['enquiry_id'];

        if($enquiry_id == NULL){


            $this->db->select('sales_order_register.*,
                offer_register.offer_no');
            $this->db->from('sales_order_register');
            $this->db->join('offer_register', 'sales_order_register.offer_id = offer_register.entity_id', 'INNER');
            $where = '(sales_order_register.entity_id = "'.$sales_order_entity_id.'" )';
            $this->db->where($where);
            $query = $this->db->get();
            //$query_data_result = $query->result();
            // print_r($query_data_result);
            // die();
            return $query;



        }else{
            $this->db->select('sales_order_register.*,
                offer_register.offer_no,
                enquiry_register.enquiry_no');
            $this->db->from('sales_order_register');
            $this->db->join('offer_register', 'sales_order_register.offer_id = offer_register.entity_id', 'INNER');
            $this->db->join('enquiry_register', 'offer_register.enquiry_id = enquiry_register.entity_id', 'INNER');
            $where = '(sales_order_register.entity_id = "'.$sales_order_entity_id.'" )';
            $this->db->where($where);
            $query = $this->db->get();
            //$query_data_result = $query->result();
            // print_r($query_data_result);
            // die();
            return $query;

        }
    }

    public function get_all_customer_address_data_by_id($customer_id)
    {

        $this->db->select('customer_contact_master.contact_person AS Bill_to_contact_person,
            customer_contact_master.email_id AS Bill_to_email_id,
            customer_contact_master.first_contact_no AS Bill_to_contact_no,
            customer_address_master.address AS Bill_to_address,
            state_master.state_name AS Bill_to_state,
            city_master.city_name AS Bill_to_city');
        $this->db->from('customer_contact_master');
        $this->db->join('customer_address_master', 'customer_contact_master.customer_address_id = customer_address_master.entity_id', 'INNER');
        $this->db->join('state_master', 'customer_address_master.state_id = state_master.entity_id', 'INNER');
        $this->db->join('city_master', 'customer_address_master.city_id = city_master.entity_id', 'INNER');
        $where = '(customer_contact_master.customer_id = "'.$customer_id.'" And customer_address_master.address_type = "'.'1'.'")';
        $this->db->where($where);
        $customer_master_bill_to = $this->db->get();
        $customer_master_bill_to_result = $customer_master_bill_to->row_array();
        // print_r($customer_master_bill_to_result);
        // die();

        $this->db->select('customer_contact_master.contact_person AS Ship_to_contact_person,
            customer_contact_master.email_id AS Ship_to_email_id,
            customer_contact_master.first_contact_no AS Ship_to_contact_no,
            customer_address_master.address AS Ship_to_address,
            state_master.state_name AS Ship_to_state,
            city_master.city_name AS Ship_to_city');
        $this->db->from('customer_contact_master');
        $this->db->join('customer_address_master', 'customer_contact_master.customer_address_id = customer_address_master.entity_id', 'INNER');
        $this->db->join('state_master', 'customer_address_master.state_id = state_master.entity_id', 'INNER');
        $this->db->join('city_master', 'customer_address_master.city_id = city_master.entity_id', 'INNER');
        $where = '(customer_contact_master.customer_id = "'.$customer_id.'" And customer_address_master.address_type = "'.'2'.'")';
        $this->db->where($where);
        $customer_master_ship_to = $this->db->get();
        $customer_master_ship_to_result = $customer_master_ship_to->row_array();

        $result_query = array_merge($customer_master_bill_to_result, $customer_master_ship_to_result);
        $data_result['data'] = json_encode($result_query);
        return $result_query;
    }

    public function update_order_product_relation($update_array)
    {
        $this->db->where('entity_id', $update_array['entity_id']);
        return $this->db->update('sales_order_product_relation', $update_array);
    }

    public function update_order_accessories_relation($update_array)
    {
        $this->db->where('entity_id', $update_array['entity_id']);
        return $this->db->update('sales_order_accessories_relation', $update_array);
    }

    public function delete_order_product($entity_id)
    {
        $this->db->where('entity_id', $entity_id);
        return $this->db->delete('sales_order_product_relation'); 
    }

    public function delete_order_accessories($entity_id)
    {
        $this->db->where('entity_id', $entity_id);
        return $this->db->delete('sales_order_accessories_relation'); 
    }

    public function get_all_order_details()
    {
        $user_id = $_SESSION['user_id'];
        $emp_id = $_SESSION['emp_id'];

        if($user_id ==1){

            $this->db->select('sales_order_register.*,
            employee_master.emp_first_name');
            $this->db->from('sales_order_register');
            // $where = '(sales_order_register.status = "'.'2'.'" And sales_order_register.order_execution_status IS NULL)';
            // $this->db->where($where);
            $this->db->join('employee_master', 'sales_order_register.order_engg_name = employee_master.entity_id', 'INNER');
            $this->db->order_by('sales_order_register.entity_id', 'DESC');
            $this->db->group_by('sales_order_register.entity_id');
            $query = $this->db->get();
            $query_result = $query->result();
            return $query_result;
        }else{

            $this->db->select('sales_order_register.*,
            employee_master.emp_first_name');
            $this->db->from('sales_order_register');
            $where = '(sales_order_register.order_engg_name = "'.$emp_id.'")';
            $this->db->where($where);
            $this->db->join('employee_master', 'sales_order_register.order_engg_name = employee_master.entity_id', 'INNER');
            $this->db->order_by('sales_order_register.entity_id', 'DESC');
            $this->db->group_by('sales_order_register.entity_id');
            $query = $this->db->get();
            $query_result = $query->result();
            return $query_result;
        }
           
    }

    public function get_pending_offer()
    {
        $user_id = $_SESSION['user_id'];
        $emp_id = $_SESSION['emp_id'];
        if($user_id == 1){

            $this->db->select('*');
            $this->db->from('offer_register');
            $where = '(offer_register.status = "'.'2'.'")';
            $this->db->where($where);
            $this->db->order_by('offer_register.entity_id', 'DESC');
            $this->db->group_by('offer_register.entity_id');
            $query = $this->db->get();
            $query_result = $query->result();
            return $query_result;
        }else{

            $this->db->select('offer_register.*,
            enquiry_register.enquiry_no,
            customer_master.customer_name,
            customer_contact_master.contact_person,
            customer_contact_master.first_contact_no,
            employee_master.emp_first_name');
            $this->db->from('offer_register');
            $where = '(offer_register.status = "'.'2'.'" AND offer_register.offer_engg_name = "'.$emp_id.'")';
            $this->db->where($where);
            $this->db->join('employee_master', 'offer_register.offer_engg_name = employee_master.entity_id', 'INNER');
            $this->db->join('enquiry_register', 'offer_register.enquiry_id = enquiry_register.entity_id', 'INNER');
            $this->db->join('customer_master', 'enquiry_register.customer_id = customer_master.entity_id', 'INNER');
            $this->db->join('customer_contact_master', 'customer_master.entity_id = customer_contact_master.customer_id', 'INNER');
            $this->db->order_by('offer_register.entity_id', 'DESC');
            $this->db->group_by('offer_register.entity_id');
            $query = $this->db->get();
            $query_result = $query->result();
            return $query_result;
        }
           
    }

    public function get_order_details_by_offerid_model($entity_id)
    {
        $of_id = $this->db->select('offer_id')->from('sales_order_register')->where('entity_id',$entity_id)->get()->row_array();

        $offer_id= $of_id['offer_id'];

        $en_id = $this->db->select('enquiry_id')->from('offer_register')->where('entity_id',$offer_id)->get()->row_array();
        $enq_id = $en_id['enquiry_id'];

        if ($enq_id == NULL) {

        $this->db->select('sales_order_register.*,
                offer_register.offer_no');
            $this->db->from('sales_order_register');
            $this->db->join('offer_register', 'sales_order_register.offer_id = offer_register.entity_id', 'INNER');
            $where = '(sales_order_register.entity_id = "'.$entity_id.'" )';
            $this->db->where($where);
            $query = $this->db->get();
            // $query_result = $query->result();
            // print_r($query_result);
            // die();
            return $query;
        }else{

            $this->db->select('sales_order_register.*,
                offer_register.offer_no,
                enquiry_register.enquiry_no');
            $this->db->from('sales_order_register');
            $this->db->join('offer_register', 'sales_order_register.offer_id = offer_register.entity_id', 'INNER');
            $this->db->join('enquiry_register', 'offer_register.enquiry_id = enquiry_register.entity_id', 'INNER');
            $where = '(sales_order_register.entity_id = "'.$entity_id.'" )';
            $this->db->where($where);
            $query = $this->db->get();
            // $query_result = $query->result();
            // print_r($query_result);
            // die();
            return $query;

        }
    }

    public function get_order_product_list_by_id($entity_id)
    {
        $this->db->select('sales_order_product_relation.*,
            product_master.product_name,
            product_master.product_id,
            product_hsn_master.hsn_code');
        $this->db->from('sales_order_product_relation');
        $this->db->join('product_master', 'sales_order_product_relation.product_id = product_master.entity_id', 'INNER');
        $this->db->join('product_hsn_master', 'product_master.hsn_id = product_hsn_master.entity_id', 'INNER');
        $where = '(sales_order_product_relation.sales_order_id = "'.$entity_id.'" )';
        $this->db->where($where);
        $query = $this->db->get();
        $query_data_result = $query->result();
        return $query_data_result;  
    }

    public function get_order_accessories_list($entity_id)
    {
        $this->db->select('*');
        $this->db->from('sales_order_register');
        $where = '(sales_order_register.offer_id = "'.$entity_id.'" )';
        $this->db->where($where);
        $this->db->order_by('sales_order_register.entity_id', 'DESC');
        $this->db->limit(1);
        $query_data = $this->db->get();
        $query_result = $query_data->row_array();

        $sales_order_entity_id = $query_result['entity_id'];

        $this->db->select('sales_order_accessories_relation.*,
            product_master.product_name,
            product_master.product_id,
            product_hsn_master.hsn_code');
        $this->db->from('sales_order_accessories_relation');
        $this->db->join('product_master', 'sales_order_accessories_relation.product_id = product_master.entity_id', 'INNER');
        $this->db->join('product_hsn_master', 'product_master.hsn_id = product_hsn_master.entity_id', 'INNER');
        $where = '(sales_order_accessories_relation.sales_order_id = "'.$sales_order_entity_id.'" )';
        $this->db->where($where);
        $query = $this->db->get();
        $query_data_result = $query->result();
        return $query_data_result;  
    }

    public function get_order_accessories_list_by_id($entity_id)
    {
        $this->db->select('sales_order_accessories_relation.*,
            product_master.product_name,
            product_master.product_id,
            product_hsn_master.hsn_code');
        $this->db->from('sales_order_accessories_relation');
        $this->db->join('product_master', 'sales_order_accessories_relation.product_id = product_master.entity_id', 'INNER');
        $this->db->join('product_hsn_master', 'product_master.hsn_id = product_hsn_master.entity_id', 'INNER');
        $where = '(sales_order_accessories_relation.sales_order_id = "'.$entity_id.'" )';
        $this->db->where($where);
        $query = $this->db->get();
        $query_data_result = $query->result();
        return $query_data_result;  
    }

    public function get_accessories_list($entity_id)
    {
        /*$this->db->select('*');
        $this->db->from('sales_order_register');
        $where = '(sales_order_register.offer_id = "'.$entity_id.'" )';
        $this->db->where($where);
        $this->db->order_by('sales_order_register.entity_id', 'DESC');
        $this->db->limit(1);
        $query_data = $this->db->get();
        $query_result = $query_data->row_array();

        $sales_order_entity_id = $query_result['entity_id'];*/

        $this->db->select('product_master.entity_id,
            CONCAT(product_master.product_id,'.'" - "'.', product_master.product_name,'.'" - "'.', product_master.product_long_description) AS Product_name');
        $this->db->from('product_master');
        /*$this->db->join('product_hsn_master', 'product_master.hsn_id = product_hsn_master.entity_id', 'INNER');*/
       /* $where = '(sales_order_accessories_relation.sales_order_id = "'.$entity_id.'" )';
        $this->db->where($where);*/
        $query = $this->db->get();
        $query_data_result = $query->result();
        return $query_data_result;

        /*$this->db->select('sales_order_product_relation.*,');
        $this->db->from('sales_order_product_relation');
        $where = '(sales_order_product_relation.sales_order_id = "'.$sales_order_entity_id.'" )';
        $this->db->where($where);
        $query = $this->db->get();
        $query_data_result = $query->result_array();

        
        $selected_material_id ="";
        foreach ($query_data_result as $key => $value) 
        {
            $material_id = $value['product_id'];

            $selected_material_id .= $material_id.',';
        } 

        if(!empty($selected_material_id))   
        {
            $this->db->select('product_master.*');
            $this->db->from('product_master');
            $where = '(product_master.entity_id != "'.$selected_material_id.'")';
            $this->db->where_in($where);
            $query = $this->db->get();
            $query_result = $query->result();
            return $query_result;
        }else{
            $this->db->select('product_master.*');
            $this->db->from('product_master');
            $query = $this->db->get();
            $query_result = $query->result();
            return $query_result;
        }*/


        /*$this->db->select('sales_order_accessories_relation.*,
            product_master.product_name,
            product_master.product_id,
            product_hsn_master.hsn_code');
        $this->db->from('sales_order_accessories_relation');
        $this->db->join('product_master', 'sales_order_accessories_relation.product_id = product_master.entity_id', 'INNER');
        $this->db->join('product_hsn_master', 'product_master.hsn_id = product_hsn_master.entity_id', 'INNER');
        $where = '(sales_order_accessories_relation.sales_order_id = "'.$entity_id.'" )';
        $this->db->where($where);
        $query = $this->db->get();
        $query_data_result = $query->result();
        return $query_data_result; */ 
    }

    public function get_all_order()
    {

        $user_id = $_SESSION['user_id'];
        $emp_id = $_SESSION['emp_id'];

        if($user_id == 1){

            $this->db->select('sales_order_register.*,
            offer_register.offer_no,
            enquiry_register.enquiry_no,
            customer_master.customer_name,
            customer_contact_master.contact_person,
            customer_contact_master.first_contact_no,
            employee_master.emp_first_name');
            $this->db->from('sales_order_register');
            /*$where = '(sales_order_register.status = "'.'2'.'")';
            $this->db->where($where);*/
            $this->db->join('employee_master', 'sales_order_register.order_engg_name = employee_master.entity_id', 'INNER');
            $this->db->join('offer_register', 'sales_order_register.offer_id = offer_register.entity_id', 'INNER');
            $this->db->join('enquiry_register', 'offer_register.enquiry_id = enquiry_register.entity_id', 'INNER');
            $this->db->join('customer_master', 'enquiry_register.customer_id = customer_master.entity_id', 'INNER');
            $this->db->join('customer_contact_master', 'customer_master.entity_id = customer_contact_master.customer_id', 'INNER');
            $this->db->order_by('sales_order_register.entity_id', 'DESC');
            $this->db->group_by('sales_order_register.entity_id');
            $query = $this->db->get();
            $query_result = $query->result();
            return $query_result;
        }else{

            $this->db->select('sales_order_register.*,
            offer_register.offer_no,
            enquiry_register.enquiry_no,
            customer_master.customer_name,
            customer_contact_master.contact_person,
            customer_contact_master.first_contact_no,
            employee_master.emp_first_name');
            $this->db->from('sales_order_register');
            $where = '(sales_order_register.order_engg_name = "'.$emp_id.'")';
            $this->db->where($where);
            $this->db->join('employee_master', 'sales_order_register.order_engg_name = employee_master.entity_id', 'INNER');
            $this->db->join('offer_register', 'sales_order_register.offer_id = offer_register.entity_id', 'INNER');
            $this->db->join('enquiry_register', 'offer_register.enquiry_id = enquiry_register.entity_id', 'INNER');
            $this->db->join('customer_master', 'enquiry_register.customer_id = customer_master.entity_id', 'INNER');
            $this->db->join('customer_contact_master', 'customer_master.entity_id = customer_contact_master.customer_id', 'INNER');
            $this->db->order_by('sales_order_register.entity_id', 'DESC');
            $this->db->group_by('sales_order_register.entity_id');
            $query = $this->db->get();
            $query_result = $query->result();
            return $query_result;
        }
           
    }

    public function get_all_rejected_order_details()
    {
        // $this->db->select('sales_order_register.*,
        //     offer_register.offer_no,
        //     enquiry_register.enquiry_no,
        //     customer_master.customer_name,
        //     customer_contact_master.contact_person,
        //     customer_contact_master.first_contact_no,
        //     employee_master.emp_first_name');
        // $this->db->from('sales_order_register');
        // $where = '(sales_order_register.status = "'.'2'.'" And sales_order_register.order_execution_status = "'.'2'.'")';
        // $this->db->where($where);
        // $this->db->join('employee_master', 'sales_order_register.order_engg_name = employee_master.entity_id', 'INNER');
        // $this->db->join('offer_register', 'sales_order_register.offer_id = offer_register.entity_id', 'INNER');
        // $this->db->join('enquiry_register', 'offer_register.enquiry_id = enquiry_register.entity_id', 'INNER');
        // $this->db->join('customer_master', 'enquiry_register.customer_id = customer_master.entity_id', 'INNER');
        // $this->db->join('customer_contact_master', 'customer_master.entity_id = customer_contact_master.customer_id', 'INNER');
        // $this->db->order_by('sales_order_register.entity_id', 'DESC');
        // $this->db->group_by('sales_order_register.entity_id');
        // $query = $this->db->get();
        // $query_result = $query->result();
        // return $query_result;   

        $this->db->select('sales_order_register.*,
        employee_master.emp_first_name');
        $this->db->from('sales_order_register');
         $where = '(sales_order_register.status = "'.'3'.'" And sales_order_register.order_execution_status = "'.'2'.'")';
        $this->db->where($where);
        $this->db->join('employee_master', 'sales_order_register.order_engg_name = employee_master.entity_id', 'INNER');
        $this->db->order_by('sales_order_register.entity_id', 'DESC');
        $this->db->group_by('sales_order_register.entity_id');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;
    }

    public function get_all_appproved_order_details()
    {
        $this->db->select('sales_order_register.*,
            offer_register.offer_no,
            enquiry_register.enquiry_no,
            customer_master.customer_name,
            customer_contact_master.contact_person,
            customer_contact_master.first_contact_no,
            employee_master.emp_first_name');
        $this->db->from('sales_order_register');
        $where = '(sales_order_register.status = "'.'2'.'" And sales_order_register.order_execution_status = "'.'1'.'")';
        $this->db->where($where);
        $this->db->join('employee_master', 'sales_order_register.order_engg_name = employee_master.entity_id', 'INNER');
        $this->db->join('offer_register', 'sales_order_register.offer_id = offer_register.entity_id', 'INNER');
        $this->db->join('enquiry_register', 'offer_register.enquiry_id = enquiry_register.entity_id', 'INNER');
        $this->db->join('customer_master', 'enquiry_register.customer_id = customer_master.entity_id', 'INNER');
        $this->db->join('customer_contact_master', 'customer_master.entity_id = customer_contact_master.customer_id', 'INNER');
        $this->db->order_by('sales_order_register.entity_id', 'DESC');
        $this->db->group_by('sales_order_register.entity_id');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;   
    }

    public function update_ship_to_contact_person_model($update_array)
    {
        $this->db->where('entity_id', $update_array['entity_id']);
        return $this->db->update('sales_order_register', $update_array);
    }

    public function get_all_data_by_customer_id_ship_to($customer_id)
    {
        $this->db->select('customer_contact_master.contact_person,
            customer_contact_master.email_id,
            customer_contact_master.first_contact_no,
            state_master.state_name,
            city_master.city_name,
            customer_master.*');
        $this->db->from('customer_contact_master');
        $this->db->join('customer_master', 'customer_contact_master.customer_id = customer_master.entity_id', 'INNER');
        $this->db->join('state_master', 'customer_master.state_id = state_master.entity_id', 'INNER');
        $this->db->join('city_master', 'customer_master.city_id = city_master.entity_id', 'INNER');
        $where = '(customer_master.entity_id = "'.$customer_id.'")';
        $this->db->where($where);
        $this->db->order_by('customer_contact_master.entity_id', 'DESC');
        $this->db->limit(1);
        $customer_master = $this->db->get();
        $customer_master_query_result = $customer_master->row_array();

        $data_result['data'] = json_encode($customer_master_query_result);
        return $customer_master_query_result;
    }

    public function get_all_data_by_customer_id_bill_to($customer_id)
    {
        $this->db->select('customer_contact_master.contact_person,
            customer_contact_master.email_id,
            customer_contact_master.first_contact_no,
            state_master.state_name,
            city_master.city_name,
            customer_master.*');
        $this->db->from('customer_contact_master');
        $this->db->join('customer_master', 'customer_contact_master.customer_id = customer_master.entity_id', 'INNER');
        $this->db->join('state_master', 'customer_master.state_id = state_master.entity_id', 'INNER');
        $this->db->join('city_master', 'customer_master.city_id = city_master.entity_id', 'INNER');
        $where = '(customer_master.entity_id = "'.$customer_id.'")';
        $this->db->where($where);
        $this->db->order_by('customer_contact_master.entity_id', 'DESC');
        $this->db->limit(1);
        $this->db->where($where);
        $customer_master = $this->db->get();
        $customer_master_query_result = $customer_master->row_array();

        $data_result['data'] = json_encode($customer_master_query_result);
        return $customer_master_query_result;
    }

    public function get_order_details_by_offerid_without_offer_model($entity_id)
    {
        $this->db->select('sales_order_register.*');
        $this->db->from('sales_order_register');
        /*$this->db->join('customer_master', 'sales_order_register.customer_id = customer_master.entity_id', 'INNER');*/
        $where = '(sales_order_register.entity_id = "'.$entity_id.'" )';
        $this->db->where($where);
        $query = $this->db->get();
        return $query;
    }

    public function get_ship_to_party()
    {
        $this->db->select('*');
        $this->db->from('customer_master');
        /*$where = '(customer_master.entity_id = "'.$sales_order_customer_id.'")';
        $this->db->where($where);*/
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result; 
    }

    public function get_all_ship_to_party_data($ship_to_id,$offer_entity_id)
    {
        $this->db->select('customer_contact_master.contact_person AS Ship_to_contact_person,
            customer_contact_master.email_id AS Ship_to_email_id,
            customer_contact_master.first_contact_no AS Ship_to_contact_number,
            CONCAT(customer_master.address,'.'" , "'.', customer_master.pin_code,'.'" , "'.',customer_master.state_code,'.'" , "'.',city_master.city_name,'.'" , "'.',state_master.state_name) AS Ship_to_address,
            customer_master.gst_no AS Ship_to_gst_no,
            customer_master.customer_name');
        $this->db->from('customer_contact_master');
        $this->db->join('customer_master', 'customer_contact_master.customer_id = customer_master.entity_id', 'INNER');
        $this->db->join('state_master', 'customer_master.state_id = state_master.entity_id', 'INNER');
        $this->db->join('city_master', 'customer_master.city_id = city_master.entity_id', 'INNER');
        $where = '(customer_master.entity_id = "'.$ship_to_id.'" )';
        $this->db->where($where);
        $this->db->order_by('customer_contact_master.entity_id', 'DESC');
        $this->db->limit(1);
        $ship_to_details = $this->db->get();
        $ship_to_details_result = $ship_to_details->result();
        $ship_to_details_row = $ship_to_details->row();

        if(!empty($ship_to_details_row))
        {
            $Ship_to_customer_name = $ship_to_details_row->customer_name;
            $Ship_to_address = $ship_to_details_row->Ship_to_address;
            $Ship_to_gst_no = $ship_to_details_row->Ship_to_gst_no;
            $Ship_to_contact_person = $ship_to_details_row->Ship_to_contact_person;
            $Ship_to_email_id = $ship_to_details_row->Ship_to_email_id;
            $Ship_to_contact_number = $ship_to_details_row->Ship_to_contact_number;
        }else{
            $Ship_to_customer_name = NULL;
            $Ship_to_address = NULL;
            $Ship_to_gst_no = NULL;
            $Ship_to_contact_person = NULL;
            $Ship_to_email_id = NULL;
            $Ship_to_contact_number = NULL;
        }

        $this->db->select('*');
        $this->db->from('sales_order_register');
        $where = '(sales_order_register.offer_id = "'.$offer_entity_id.'" )';
        $this->db->where($where);
        $this->db->order_by('sales_order_register.entity_id', 'DESC');
        $this->db->limit(1);
        $query_data = $this->db->get();
        $query_result = $query_data->row_array();

        $sales_order_entity_id = $query_result['entity_id'];

        $update_ship_details_array = array('ship_to_address' => $ship_to_id , 'customer_ship_to_name' => $Ship_to_customer_name , 'customer_ship_to_address' => $Ship_to_address , 'customer_ship_to_gst_no' => $Ship_to_gst_no , 'customer_ship_to_contact_person' => $Ship_to_contact_person , 'customer_ship_to_contact_person_mail' => $Ship_to_email_id , 'customer_ship_to_contact_person_no' => $Ship_to_contact_number);

        $this->db->where('entity_id', $sales_order_entity_id);
        $this->db->update('sales_order_register', $update_ship_details_array);

        /*$data_result = json_encode($ship_to_details_result);*/
        return $ship_to_details_result;
    }

    public function get_all_bill_to_party_data($bill_to_id,$offer_entity_id)
    {
        $this->db->select('customer_contact_master.contact_person AS Bill_to_contact_person,
            customer_contact_master.email_id AS Bill_to_email_id,
            customer_contact_master.first_contact_no AS Bill_to_contact_number,
            CONCAT(customer_master.address,'.'" , "'.', customer_master.pin_code,'.'" , "'.',customer_master.state_code,'.'" , "'.',city_master.city_name,'.'" , "'.',state_master.state_name) AS Bill_to_address,
            customer_master.gst_no AS Bill_to_gst_no,
            customer_master.customer_name');
        $this->db->from('customer_contact_master');
        $this->db->join('customer_master', 'customer_contact_master.customer_id = customer_master.entity_id', 'INNER');
        $this->db->join('state_master', 'customer_master.state_id = state_master.entity_id', 'INNER');
        $this->db->join('city_master', 'customer_master.city_id = city_master.entity_id', 'INNER');
        $where = '(customer_master.entity_id = "'.$bill_to_id.'" )';
        $this->db->where($where);
        $this->db->order_by('customer_contact_master.entity_id', 'DESC');
        $this->db->limit(1);
        $bill_to_details = $this->db->get();
        $bill_to_details_result = $bill_to_details->result();
        $bill_to_details_row = $bill_to_details->row();

        if(!empty($bill_to_details_row))
        {
            $Bill_to_customer_name = $bill_to_details_row->customer_name;
            $Bill_to_address = $bill_to_details_row->Bill_to_address;
            $Bill_to_gst_no = $bill_to_details_row->Bill_to_gst_no;
            $Bill_to_contact_person = $bill_to_details_row->Bill_to_contact_person;
            $Bill_to_email_id = $bill_to_details_row->Bill_to_email_id;
            $Bill_to_contact_number = $bill_to_details_row->Bill_to_contact_number;
        }else{
            $Bill_to_customer_name = NULL;
            $Bill_to_address = NULL;
            $Bill_to_gst_no = NULL;
            $Bill_to_contact_person = NULL;
            $Bill_to_email_id = NULL;
            $Bill_to_contact_number = NULL;
        }

        $this->db->select('*');
        $this->db->from('sales_order_register');
        $where = '(sales_order_register.offer_id = "'.$offer_entity_id.'" )';
        $this->db->where($where);
        $this->db->order_by('sales_order_register.entity_id', 'DESC');
        $this->db->limit(1);
        $query_data = $this->db->get();
        $query_result = $query_data->row_array();

        $sales_order_entity_id = $query_result['entity_id'];

        $update_ship_details_array = array('bill_to_address' => $bill_to_id , 'customer_bill_to_name' => $Bill_to_customer_name , 'customer_bill_to_address' => $Bill_to_address , 'customer_bill_to_gst_no' => $Bill_to_gst_no , 'customer_bill_to_contact_person' => $Bill_to_contact_person , 'customer_bill_to_contact_person_mail' => $Bill_to_email_id , 'customer_bill_to_contact_person_no' => $Bill_to_contact_number);

        $this->db->where('entity_id', $sales_order_entity_id);
        $this->db->update('sales_order_register', $update_ship_details_array);

        /*$data_result = json_encode($ship_to_details_result);*/
        return $bill_to_details_result;
    }

    public function get_all_ship_to_party_data_update_page($ship_to_id,$order_entity_id)
    {
        $this->db->select('customer_contact_master.contact_person AS Ship_to_contact_person,
            customer_contact_master.email_id AS Ship_to_email_id,
            customer_contact_master.first_contact_no AS Ship_to_contact_number,
            CONCAT(customer_master.address,'.'" , "'.', customer_master.pin_code,'.'" , "'.',customer_master.state_code,'.'" , "'.',city_master.city_name,'.'" , "'.',state_master.state_name) AS Ship_to_address,
            customer_master.gst_no AS Ship_to_gst_no,
            customer_master.customer_name');
        $this->db->from('customer_contact_master');
        $this->db->join('customer_master', 'customer_contact_master.customer_id = customer_master.entity_id', 'INNER');
        $this->db->join('state_master', 'customer_master.state_id = state_master.entity_id', 'INNER');
        $this->db->join('city_master', 'customer_master.city_id = city_master.entity_id', 'INNER');
        $where = '(customer_master.entity_id = "'.$ship_to_id.'" )';
        $this->db->where($where);
        $this->db->order_by('customer_contact_master.entity_id', 'DESC');
        $this->db->limit(1);
        $ship_to_details = $this->db->get();
        $ship_to_details_result = $ship_to_details->result();
        $ship_to_details_row = $ship_to_details->row();

        if(!empty($ship_to_details_row))
        {
            $Ship_to_customer_name = $ship_to_details_row->customer_name;
            $Ship_to_address = $ship_to_details_row->Ship_to_address;
            $Ship_to_gst_no = $ship_to_details_row->Ship_to_gst_no;
            $Ship_to_contact_person = $ship_to_details_row->Ship_to_contact_person;
            $Ship_to_email_id = $ship_to_details_row->Ship_to_email_id;
            $Ship_to_contact_number = $ship_to_details_row->Ship_to_contact_number;
        }else{
            $Ship_to_customer_name = NULL;
            $Ship_to_address = NULL;
            $Ship_to_gst_no = NULL;
            $Ship_to_contact_person = NULL;
            $Ship_to_email_id = NULL;
            $Ship_to_contact_number = NULL;
        }

        $update_ship_details_array = array('ship_to_address' => $ship_to_id , 'customer_ship_to_name' => $Ship_to_customer_name , 'customer_ship_to_address' => $Ship_to_address , 'customer_ship_to_gst_no' => $Ship_to_gst_no , 'customer_ship_to_contact_person' => $Ship_to_contact_person , 'customer_ship_to_contact_person_mail' => $Ship_to_email_id , 'customer_ship_to_contact_person_no' => $Ship_to_contact_number);

        $this->db->where('entity_id', $order_entity_id);
        $this->db->update('sales_order_register', $update_ship_details_array);

        /*$data_result = json_encode($ship_to_details_result);*/
        return $ship_to_details_result;
    }

    public function get_all_bill_to_party_data_update_page($bill_to_id,$order_entity_id)
    {
        $this->db->select('customer_contact_master.contact_person AS Bill_to_contact_person,
            customer_contact_master.email_id AS Bill_to_email_id,
            customer_contact_master.first_contact_no AS Bill_to_contact_number,
            CONCAT(customer_master.address,'.'" , "'.', customer_master.pin_code,'.'" , "'.',customer_master.state_code,'.'" , "'.',city_master.city_name,'.'" , "'.',state_master.state_name) AS Bill_to_address,
            customer_master.gst_no AS Bill_to_gst_no,
            customer_master.customer_name');
        $this->db->from('customer_contact_master');
        $this->db->join('customer_master', 'customer_contact_master.customer_id = customer_master.entity_id', 'INNER');
        $this->db->join('state_master', 'customer_master.state_id = state_master.entity_id', 'INNER');
        $this->db->join('city_master', 'customer_master.city_id = city_master.entity_id', 'INNER');
        $where = '(customer_master.entity_id = "'.$bill_to_id.'" )';
        $this->db->where($where);
        $this->db->order_by('customer_contact_master.entity_id', 'DESC');
        $this->db->limit(1);
        $bill_to_details = $this->db->get();
        $bill_to_details_result = $bill_to_details->result();
        $bill_to_details_row = $bill_to_details->row();

        if(!empty($bill_to_details_row))
        {
            $Bill_to_customer_name = $bill_to_details_row->customer_name;
            $Bill_to_address = $bill_to_details_row->Bill_to_address;
            $Bill_to_gst_no = $bill_to_details_row->Bill_to_gst_no;
            $Bill_to_contact_person = $bill_to_details_row->Bill_to_contact_person;
            $Bill_to_email_id = $bill_to_details_row->Bill_to_email_id;
            $Bill_to_contact_number = $bill_to_details_row->Bill_to_contact_number;
        }else{
            $Bill_to_customer_name = NULL;
            $Bill_to_address = NULL;
            $Bill_to_gst_no = NULL;
            $Bill_to_contact_person = NULL;
            $Bill_to_email_id = NULL;
            $Bill_to_contact_number = NULL;
        }

        $update_bill_to_details_array = array('bill_to_address' => $bill_to_id , 'customer_bill_to_name' => $Bill_to_customer_name , 'customer_bill_to_address' => $Bill_to_address , 'customer_bill_to_gst_no' => $Bill_to_gst_no , 'customer_bill_to_contact_person' => $Bill_to_contact_person , 'customer_bill_to_contact_person_mail' => $Bill_to_email_id , 'customer_bill_to_contact_person_no' => $Bill_to_contact_number);

        $this->db->where('entity_id', $order_entity_id);
        $this->db->update('sales_order_register', $update_bill_to_details_array);

        /*$data_result = json_encode($ship_to_details_result);*/
        return $bill_to_details_result;
    }

    public function get_bill_to_party()
    {
        $this->db->select('*');
        $this->db->from('customer_master');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result; 
    }

    public function get_ship_to_party_at_update_page($entity_id)
    {
        /*$this->db->select('*');
        $this->db->from('sales_order_register');
        $where = '(sales_order_register.entity_id = "'.$entity_id.'" )';
        $this->db->where($where);
        $query_data = $this->db->get();
        $query_result_data = $query_data->row_array();
        $sales_order_customer_id = $query_result_data['customer_id'];*/

        $this->db->select('*');
        $this->db->from('customer_master');
        /*$where = '(customer_address_master.customer_id = "'.$sales_order_customer_id.'" And customer_address_master.address_type = "'.'2'.'")';
        $this->db->where($where);*/
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result; 
    }

    public function get_bill_to_party_at_update_page($entity_id)
    {
        /*$this->db->select('*');
        $this->db->from('sales_order_register');
        $where = '(sales_order_register.entity_id = "'.$entity_id.'" )';
        $this->db->where($where);
        $query_data = $this->db->get();
        $query_result_data = $query_data->row_array();
        $sales_order_customer_id = $query_result_data['customer_id'];*/

        $this->db->select('*');
        $this->db->from('customer_master');
        /*$where = '(customer_address_master.customer_id = "'.$sales_order_customer_id.'" And customer_address_master.address_type = "'.'1'.'")';
        $this->db->where($where);*/
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result; 
    }

    public function get_ship_to_data_address_id($sales_order_entity_id)
    {

        $this->db->select('sales_order_register.*');
        $this->db->from('sales_order_register');
        $where = '(sales_order_register.entity_id = "'.$sales_order_entity_id.'" )';
        $this->db->where($where);
        $customer_address_master_ship = $this->db->get();
        $customer_address_master_ship_query_result = $customer_address_master_ship->row();
        // print_r($customer_address_master_ship_query_result);
        // die();


        $data_result['data'] = json_encode($customer_address_master_ship_query_result);
        return $customer_address_master_ship_query_result;
    }

    public function get_bill_to_data_address_id($address_id)
    {
        $this->db->select('customer_address_master.*,
                           customer_contact_master.contact_person,
                           customer_contact_master.email_id,
                           customer_contact_master.first_contact_no');
        $this->db->from('customer_address_master');
        $this->db->join('customer_contact_master', 'customer_address_master.customer_id = customer_contact_master.customer_id', 'INNER');
        $where = '(customer_address_master.entity_id = "'.$address_id.'" )';
        $this->db->where($where);
        $customer_address_master_bill = $this->db->get();
        $customer_address_master_bill_query_result = $customer_address_master_bill->row_array();

        $data_result['data'] = json_encode($customer_address_master_bill_query_result);
        return $customer_address_master_bill_query_result;
    }


    public function get_accessories_qty_id($accessories_id)
    {
        $this->db->select('product_master.*');
        $this->db->from('product_master');
        $where = '(product_master.entity_id = "'.$accessories_id.'" )';
        $this->db->where($where);
        $accessories = $this->db->get();
        $accessories_data = $accessories->row_array();
        

        $data_result['data'] = json_encode($accessories_data);
        return $accessories_data;
    }

    public function get_product_hsn_code()
    {
        $this->db->select('*');
        $this->db->from('product_hsn_master');
        $this->db->order_by('entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_product_category()
    {
        $this->db->select('*');
        $this->db->from('product_category_master');
        $this->db->order_by('entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_state_list()
    {
        $this->db->select('*');
        $this->db->from('state_master');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }


    public function set_duplicate_order_model($entity_id)
    {
        $this->db->select('*');
        $this->db->from('sales_order_register');
        $where = '(entity_id = "'.$entity_id.'")';
        $this->db->where($where);
        $sales_order_register_master = $this->db->get();
        $sales_order_register_data =  $sales_order_register_master->row();
        // print_r($sales_order_register_data);
        // die();
        

        $sales_order_id = $sales_order_register_data->entity_id;
        $sales_order_description = $sales_order_register_data->sales_order_description;
        $po_no = $sales_order_register_data->po_no;
        $offer_id = $sales_order_register_data->offer_id;
        // print_r($customer_id);
        // die();
        $po_date = $sales_order_register_data->po_date;
        $salutation = $sales_order_register_data->salutation;
        $price_basis = $sales_order_register_data->price_basis;
        $transport_insurance = $sales_order_register_data->transport_insurance;
        $tax = $sales_order_register_data->tax;
        $delivery_schedule = $sales_order_register_data->delivery_schedule;
        $mode_of_payment = $sales_order_register_data->mode_of_payment;
        $mode_of_transport = $sales_order_register_data->mode_of_transport;
        $guarantee_warrenty = $sales_order_register_data->guarantee_warrenty;
        $customer_id = $sales_order_register_data->customer_id;

        // $salutation = $sales_order_register_data->salutation;
        // $price_basis = $sales_order_register_data->price_basis;
        // $transport_insurance = $sales_order_register_data->transport_insurance;
        // $tax = $sales_order_register_data->tax;
        // $delivery_schedule = $sales_order_register_data->delivery_schedule;
        // $mode_of_payment = $sales_order_register_data->mode_of_payment;
        // $mode_of_transport = $sales_order_register_data->mode_of_transport;
        // $guarantee_warrenty = $sales_order_register_data->guarantee_warrenty;
        $status = '1';


        $customer_bill_to_name = $sales_order_register_data->customer_bill_to_name;
        $customer_bill_to_address = $sales_order_register_data->customer_bill_to_address;
        $customer_bill_to_gst_no = $sales_order_register_data->customer_bill_to_gst_no;
        $customer_bill_to_contact_person = $sales_order_register_data->customer_bill_to_contact_person;
        $customer_bill_to_contact_person_mail = $sales_order_register_data->customer_bill_to_contact_person_mail;
        $customer_bill_to_contact_person_no = $sales_order_register_data->customer_bill_to_contact_person_no;
        $customer_ship_to_name = $sales_order_register_data->customer_ship_to_name;
        $customer_ship_to_address = $sales_order_register_data->customer_ship_to_address;
        $customer_ship_to_gst_no = $sales_order_register_data->customer_ship_to_gst_no;
        $customer_ship_to_contact_person = $sales_order_register_data->customer_ship_to_contact_person;
        $customer_ship_to_contact_person_mail = $sales_order_register_data->customer_ship_to_contact_person_mail;
        $customer_ship_to_contact_person_no = $sales_order_register_data->customer_ship_to_contact_person_no;
        $bill_to_address = $sales_order_register_data->bill_to_address;
        $ship_to_address = $sales_order_register_data->ship_to_address;
        $ship_to_contact_person = $sales_order_register_data->ship_to_contact_person;

        $order_engg_name = $sales_order_register_data->order_engg_name;
        $special_customer = $sales_order_register_data->special_customer;
        $inspection = $sales_order_register_data->inspection;
        $delivery_period = $sales_order_register_data->delivery_period;
        $inspector_mobile_no = $sales_order_register_data->inspector_mobile_no;
        $inspector_email = $sales_order_register_data->inspector_email;
        $delivery_instruction = $sales_order_register_data->delivery_instruction;
        $installation = $sales_order_register_data->installation;
        $installation_price = $sales_order_register_data->installation_price;
        $transportation = $sales_order_register_data->transportation;
        $transportation_price = $sales_order_register_data->transportation_price;
        $lba = $sales_order_register_data->lba;
        $labour_price = $sales_order_register_data->labour_price;
        $dispatch_address = $sales_order_register_data->dispatch_address;
        $loading = $sales_order_register_data->loading;
        $loading_price = $sales_order_register_data->loading_price;

        $unloading_scope = $sales_order_register_data->unloading_scope;
        $unloading_price = $sales_order_register_data->unloading_price;
        $packing_forwarding_price = $sales_order_register_data->packing_forwarding_price;
        $insurance_price = $sales_order_register_data->insurance_price;
        $site_preparation = $sales_order_register_data->site_preparation;
        $site_preparation_price = $sales_order_register_data->site_preparation_price;
        $payment_term = $sales_order_register_data->payment_term;
        $packing_forwarding = $sales_order_register_data->packing_forwarding;
        $insurance = $sales_order_register_data->insurance;
        $special_packing = $sales_order_register_data->special_packing;
        $more_information = $sales_order_register_data->more_information;
        $budgeted_delivery_cost = $sales_order_register_data->budgeted_delivery_cost;
        $budgeted_packing_cost = $sales_order_register_data->budgeted_packing_cost;
        $payement_terms_id = $sales_order_register_data->payement_terms_id;
        $warranty_id = $sales_order_register_data->warranty_id;
        $terms_conditions = $sales_order_register_data->terms_conditions;
        $customer_po_no = $sales_order_register_data->customer_po_no;
        $sales_order_type = $sales_order_register_data->sales_order_type;
        $quick_so_status = $sales_order_register_data->quick_so_status;
        

        if(!empty($offer_id)){
        
        //check sales_order_register id exist or not code
        
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

            $this->db->select('enquiry_id');
            $this->db->from('offer_register');
            $where_or = '(entity_id = "'.$offer_id.'")';
            $this->db->where($where_or);
            $enquiry_id_data= $this->db->get();
            $enquiry_id_result =  $enquiry_id_data->row_array();

            $Enquiry_id = $enquiry_id_result['enquiry_id'];

            $this->db->select('enquiry_type');
            $this->db->from('enquiry_register');
            $where_or = '(entity_id = "'.$Enquiry_id.'")';
            $this->db->where($where_or);
            $enquiry_type_data= $this->db->get();
            $enquiry_type_result =  $enquiry_type_data->row_array();

            $enquiry_type = $enquiry_type_result['enquiry_type'];

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


            $inst_arr = Array('sales_order_no' => $doc_no , 'offer_id' => $offer_id , 'sales_order_description' => $sales_order_description , 'po_no' => $po_no , 'po_date' => $po_date ,'salutation' => $salutation ,'price_basis' => $price_basis ,'transport_insurance' => $transport_insurance ,'tax' => $tax ,'delivery_schedule' => $delivery_schedule ,'mode_of_payment' => $mode_of_payment ,'mode_of_transport' => $mode_of_transport ,'guarantee_warrenty' => $guarantee_warrenty ,'customer_id' => $customer_id ,'customer_bill_to_name' => $customer_bill_to_name ,'customer_bill_to_address' => $customer_bill_to_address ,'customer_bill_to_gst_no' => $customer_bill_to_gst_no,'customer_bill_to_contact_person' => $customer_bill_to_contact_person , 'customer_bill_to_contact_person_mail' => $customer_bill_to_contact_person_mail , 'customer_bill_to_contact_person_no' => $customer_bill_to_contact_person_no , 'customer_ship_to_name' => $customer_ship_to_name , 'customer_ship_to_address' => $customer_ship_to_address , 'customer_ship_to_gst_no' => $customer_ship_to_gst_no , 'customer_ship_to_contact_person' => $customer_ship_to_contact_person , 'customer_ship_to_contact_person_mail' => $customer_ship_to_contact_person_mail , 'customer_ship_to_contact_person_no' => $customer_ship_to_contact_person_no , 'bill_to_address' => $bill_to_address , 'ship_to_address' => $ship_to_address , 'ship_to_contact_person' => $ship_to_contact_person , 'order_engg_name' => $order_engg_name , 'special_customer' => $special_customer , 'inspection' => $inspection , 'delivery_period' => $delivery_period , 'inspector_mobile_no' => $inspector_mobile_no ,'inspector_email' => $inspector_email ,'delivery_instruction' => $delivery_instruction ,'installation' => $installation ,'installation_price' => $installation_price ,'transportation' => $transportation ,'transportation_price' => $transportation_price ,'lba' => $lba,'labour_price' => $labour_price,'dispatch_address' => $dispatch_address,'loading' => $loading,'loading_price' => $loading_price,'unloading_scope' => $unloading_scope,'unloading_price' => $unloading_price,'packing_forwarding_price' => $packing_forwarding_price,'insurance_price' => $insurance_price,'site_preparation' => $site_preparation,'site_preparation_price' => $site_preparation_price,'payment_term' => $payment_term,'packing_forwarding' => $packing_forwarding,'insurance' => $insurance,'special_packing' => $special_packing,'more_information' => $more_information,'budgeted_delivery_cost' => $budgeted_delivery_cost,'budgeted_packing_cost' => $budgeted_packing_cost,'payement_terms_id' => $payement_terms_id,'warranty_id' => $warranty_id,'terms_conditions' => $terms_conditions,'customer_po_no' => $customer_po_no,'sales_order_type' => $sales_order_type , 'status' => 1 , 'invoice_status' => 1);

            $this->db->insert('sales_order_register', $inst_arr);
            $order_master_lastid = $this->db->insert_id();

            $this->db->select('*');
            $this->db->from('sales_order_product_relation');
            $where_p = '(sales_order_id = "'.$sales_order_id.'")';
            $this->db->where($where_p);
            $order_master_product = $this->db->get();
            $order_master_product_data =  $order_master_product->result_array();

            foreach ($order_master_product_data as $key => $value) {

                $product_id = $value['product_id'];
                $product_qty = $value['rfq_qty'];
                $delivery_period = $value['delivery_period'];
                $product_custom_description = $value['product_custom_description'];
                $price = $value['price'];
                $discount = $value['discount'];
                $discount_amt = $value['discount_amt'];
                $product_warranty = $value['product_warranty'];
                $unit_discounted_price = $value['unit_discounted_price'];
                $total_amount_without_gst = $value['total_amount_without_gst'];
                $cgst_discount = $value['cgst_discount'];
                $cgst_amt = $value['cgst_amount'];
                $sgst_discount = $value['sgst_discount'];
                $sgst_amt = $value['sgst_amount'];
                $igst_discount = $value['igst_discount'];
                $igst_amt = $value['igst_amount'];
                $total_amount_with_gst = $value['total_amount_with_gst'];

                $order_product_master_save = "INSERT INTO sales_order_product_relation (sales_order_id, product_id, rfq_qty, delivery_period, product_custom_description, price, discount, discount_amt, total_amount_without_gst, cgst_discount, cgst_amount, sgst_discount, sgst_amount, igst_discount, igst_amount, total_amount_with_gst, product_warranty, unit_discounted_price) VALUES ('".$order_master_lastid."', '".$product_id."', '".$product_qty."', '".$delivery_period."', '".$product_custom_description."', '".$price."', '".$discount."', '".$discount_amt."', '".$total_amount_without_gst."', '".$cgst_discount."', '".$cgst_amt."', '".$sgst_discount."', '".$sgst_amt."', '".$igst_discount."', '".$igst_amt."', '".$total_amount_with_gst."', '".$product_warranty."', '".$unit_discounted_price."')";
                    $product_execute = $this->db->query($order_product_master_save);

                      
            }
            redirect('update_sales_order_data'.'/'.$order_master_lastid);
        }



        if(empty($offer_id) && empty($quick_so_status)){
        
        //check sales_order_register id exist or not code
        
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

            // $this->db->select('enquiry_id');
            // $this->db->from('offer_register');
            // $where_or = '(entity_id = "'.$offer_id.'")';
            // $this->db->where($where_or);
            // $enquiry_id_data= $this->db->get();
            // $enquiry_id_result =  $enquiry_id_data->row_array();

            // $Enquiry_id = $enquiry_id_result['enquiry_id'];

            // $this->db->select('enquiry_type');
            // $this->db->from('enquiry_register');
            // $where_or = '(entity_id = "'.$Enquiry_id.'")';
            // $this->db->where($where_or);
            // $enquiry_type_data= $this->db->get();
            // $enquiry_type_result =  $enquiry_type_data->row_array();

            // $enquiry_type = $enquiry_type_result['enquiry_type'];

            
                $enquiry_prefix = "XX";
            

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


            $inst_arr = Array('sales_order_no' => $doc_no , 'offer_id' => $offer_id , 'sales_order_description' => $sales_order_description , 'po_no' => $po_no , 'po_date' => $po_date ,'salutation' => $salutation ,'price_basis' => $price_basis ,'transport_insurance' => $transport_insurance ,'tax' => $tax ,'delivery_schedule' => $delivery_schedule ,'mode_of_payment' => $mode_of_payment ,'mode_of_transport' => $mode_of_transport ,'guarantee_warrenty' => $guarantee_warrenty ,'customer_id' => $customer_id ,'customer_bill_to_name' => $customer_bill_to_name ,'customer_bill_to_address' => $customer_bill_to_address ,'customer_bill_to_gst_no' => $customer_bill_to_gst_no,'customer_bill_to_contact_person' => $customer_bill_to_contact_person , 'customer_bill_to_contact_person_mail' => $customer_bill_to_contact_person_mail , 'customer_bill_to_contact_person_no' => $customer_bill_to_contact_person_no , 'customer_ship_to_name' => $customer_ship_to_name , 'customer_ship_to_address' => $customer_ship_to_address , 'customer_ship_to_gst_no' => $customer_ship_to_gst_no , 'customer_ship_to_contact_person' => $customer_ship_to_contact_person , 'customer_ship_to_contact_person_mail' => $customer_ship_to_contact_person_mail , 'customer_ship_to_contact_person_no' => $customer_ship_to_contact_person_no , 'bill_to_address' => $bill_to_address , 'ship_to_address' => $ship_to_address , 'ship_to_contact_person' => $ship_to_contact_person , 'order_engg_name' => $order_engg_name , 'special_customer' => $special_customer , 'inspection' => $inspection , 'delivery_period' => $delivery_period , 'inspector_mobile_no' => $inspector_mobile_no ,'inspector_email' => $inspector_email ,'delivery_instruction' => $delivery_instruction ,'installation' => $installation ,'installation_price' => $installation_price ,'transportation' => $transportation ,'transportation_price' => $transportation_price ,'lba' => $lba,'labour_price' => $labour_price,'dispatch_address' => $dispatch_address,'loading' => $loading,'loading_price' => $loading_price,'unloading_scope' => $unloading_scope,'unloading_price' => $unloading_price,'packing_forwarding_price' => $packing_forwarding_price,'insurance_price' => $insurance_price,'site_preparation' => $site_preparation,'site_preparation_price' => $site_preparation_price,'payment_term' => $payment_term,'packing_forwarding' => $packing_forwarding,'insurance' => $insurance,'special_packing' => $special_packing,'more_information' => $more_information,'budgeted_delivery_cost' => $budgeted_delivery_cost,'budgeted_packing_cost' => $budgeted_packing_cost,'payement_terms_id' => $payement_terms_id,'warranty_id' => $warranty_id,'terms_conditions' => $terms_conditions,'customer_po_no' => $customer_po_no,'sales_order_type' => $sales_order_type , 'status' => 1 , 'invoice_status' => 1);

            $this->db->insert('sales_order_register', $inst_arr);
            $order_master_lastid = $this->db->insert_id();

            $this->db->select('*');
            $this->db->from('sales_order_product_relation');
            $where_p = '(sales_order_id = "'.$sales_order_id.'")';
            $this->db->where($where_p);
            $order_master_product = $this->db->get();
            $order_master_product_data =  $order_master_product->result_array();

            foreach ($order_master_product_data as $key => $value) {

                $product_id = $value['product_id'];
                $product_qty = $value['rfq_qty'];
                $delivery_period = $value['delivery_period'];
                $product_custom_description = $value['product_custom_description'];
                $price = $value['price'];
                $discount = $value['discount'];
                $discount_amt = $value['discount_amt'];
                $product_warranty = $value['product_warranty'];
                $unit_discounted_price = $value['unit_discounted_price'];
                $total_amount_without_gst = $value['total_amount_without_gst'];
                $cgst_discount = $value['cgst_discount'];
                $cgst_amt = $value['cgst_amount'];
                $sgst_discount = $value['sgst_discount'];
                $sgst_amt = $value['sgst_amount'];
                $igst_discount = $value['igst_discount'];
                $igst_amt = $value['igst_amount'];
                $total_amount_with_gst = $value['total_amount_with_gst'];

                $order_product_master_save = "INSERT INTO sales_order_product_relation (sales_order_id, product_id, rfq_qty, delivery_period, product_custom_description, price, discount, discount_amt, total_amount_without_gst, cgst_discount, cgst_amount, sgst_discount, sgst_amount, igst_discount, igst_amount, total_amount_with_gst, product_warranty, unit_discounted_price) VALUES ('".$order_master_lastid."', '".$product_id."', '".$product_qty."', '".$delivery_period."', '".$product_custom_description."', '".$price."', '".$discount."', '".$discount_amt."', '".$total_amount_without_gst."', '".$cgst_discount."', '".$cgst_amt."', '".$sgst_discount."', '".$sgst_amt."', '".$igst_discount."', '".$igst_amt."', '".$total_amount_with_gst."', '".$product_warranty."', '".$unit_discounted_price."')";
                    $product_execute = $this->db->query($order_product_master_save);

                      
            }
            redirect('update_sales_order_data_without_offer'.'/'.$order_master_lastid);
        }



        if(empty($offer_id) && ($quick_so_status == 1)){
        
        //check sales_order_register id exist or not code
        
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

            // $this->db->select('enquiry_id');
            // $this->db->from('offer_register');
            // $where_or = '(entity_id = "'.$offer_id.'")';
            // $this->db->where($where_or);
            // $enquiry_id_data= $this->db->get();
            // $enquiry_id_result =  $enquiry_id_data->row_array();

            // $Enquiry_id = $enquiry_id_result['enquiry_id'];

            // $this->db->select('enquiry_type');
            // $this->db->from('enquiry_register');
            // $where_or = '(entity_id = "'.$Enquiry_id.'")';
            // $this->db->where($where_or);
            // $enquiry_type_data= $this->db->get();
            // $enquiry_type_result =  $enquiry_type_data->row_array();

            // $enquiry_type = $enquiry_type_result['enquiry_type'];

            
                $enquiry_prefix = "XX";
            

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


            $inst_arr = Array('sales_order_no' => $doc_no , 'offer_id' => $offer_id , 'sales_order_description' => $sales_order_description , 'po_no' => $po_no , 'po_date' => $po_date ,'salutation' => $salutation ,'price_basis' => $price_basis ,'transport_insurance' => $transport_insurance ,'tax' => $tax ,'delivery_schedule' => $delivery_schedule ,'mode_of_payment' => $mode_of_payment ,'mode_of_transport' => $mode_of_transport ,'guarantee_warrenty' => $guarantee_warrenty ,'customer_id' => $customer_id ,'customer_bill_to_name' => $customer_bill_to_name ,'customer_bill_to_address' => $customer_bill_to_address ,'customer_bill_to_gst_no' => $customer_bill_to_gst_no,'customer_bill_to_contact_person' => $customer_bill_to_contact_person , 'customer_bill_to_contact_person_mail' => $customer_bill_to_contact_person_mail , 'customer_bill_to_contact_person_no' => $customer_bill_to_contact_person_no , 'customer_ship_to_name' => $customer_ship_to_name , 'customer_ship_to_address' => $customer_ship_to_address , 'customer_ship_to_gst_no' => $customer_ship_to_gst_no , 'customer_ship_to_contact_person' => $customer_ship_to_contact_person , 'customer_ship_to_contact_person_mail' => $customer_ship_to_contact_person_mail , 'customer_ship_to_contact_person_no' => $customer_ship_to_contact_person_no , 'bill_to_address' => $bill_to_address , 'ship_to_address' => $ship_to_address , 'ship_to_contact_person' => $ship_to_contact_person , 'order_engg_name' => $order_engg_name , 'special_customer' => $special_customer , 'inspection' => $inspection , 'delivery_period' => $delivery_period , 'inspector_mobile_no' => $inspector_mobile_no ,'inspector_email' => $inspector_email ,'delivery_instruction' => $delivery_instruction ,'installation' => $installation ,'installation_price' => $installation_price ,'transportation' => $transportation ,'transportation_price' => $transportation_price ,'lba' => $lba,'labour_price' => $labour_price,'dispatch_address' => $dispatch_address,'loading' => $loading,'loading_price' => $loading_price,'unloading_scope' => $unloading_scope,'unloading_price' => $unloading_price,'packing_forwarding_price' => $packing_forwarding_price,'insurance_price' => $insurance_price,'site_preparation' => $site_preparation,'site_preparation_price' => $site_preparation_price,'payment_term' => $payment_term,'packing_forwarding' => $packing_forwarding,'insurance' => $insurance,'special_packing' => $special_packing,'more_information' => $more_information,'budgeted_delivery_cost' => $budgeted_delivery_cost,'budgeted_packing_cost' => $budgeted_packing_cost,'payement_terms_id' => $payement_terms_id,'warranty_id' => $warranty_id,'terms_conditions' => $terms_conditions,'customer_po_no' => $customer_po_no,'sales_order_type' => $sales_order_type , 'status' => 1 , 'invoice_status' => 1);

            $this->db->insert('sales_order_register', $inst_arr);
            $order_master_lastid = $this->db->insert_id();

            $this->db->select('*');
            $this->db->from('sales_order_product_relation');
            $where_p = '(sales_order_id = "'.$sales_order_id.'")';
            $this->db->where($where_p);
            $order_master_product = $this->db->get();
            $order_master_product_data =  $order_master_product->result_array();

            foreach ($order_master_product_data as $key => $value) {

                $product_id = $value['product_id'];
                $product_qty = $value['rfq_qty'];
                $delivery_period = $value['delivery_period'];
                $product_custom_description = $value['product_custom_description'];
                $price = $value['price'];
                $discount = $value['discount'];
                $discount_amt = $value['discount_amt'];
                $product_warranty = $value['product_warranty'];
                $unit_discounted_price = $value['unit_discounted_price'];
                $total_amount_without_gst = $value['total_amount_without_gst'];
                $cgst_discount = $value['cgst_discount'];
                $cgst_amt = $value['cgst_amount'];
                $sgst_discount = $value['sgst_discount'];
                $sgst_amt = $value['sgst_amount'];
                $igst_discount = $value['igst_discount'];
                $igst_amt = $value['igst_amount'];
                $total_amount_with_gst = $value['total_amount_with_gst'];

                $order_product_master_save = "INSERT INTO sales_order_product_relation (sales_order_id, product_id, rfq_qty, delivery_period, product_custom_description, price, discount, discount_amt, total_amount_without_gst, cgst_discount, cgst_amount, sgst_discount, sgst_amount, igst_discount, igst_amount, total_amount_with_gst, product_warranty, unit_discounted_price) VALUES ('".$order_master_lastid."', '".$product_id."', '".$product_qty."', '".$delivery_period."', '".$product_custom_description."', '".$price."', '".$discount."', '".$discount_amt."', '".$total_amount_without_gst."', '".$cgst_discount."', '".$cgst_amt."', '".$sgst_discount."', '".$sgst_amt."', '".$igst_discount."', '".$igst_amt."', '".$total_amount_with_gst."', '".$product_warranty."', '".$unit_discounted_price."')";
                    $product_execute = $this->db->query($order_product_master_save);

                      
            }
            redirect('update_quick_sales_order_data'.'/'.$order_master_lastid);
        }

            
        
    }


    public function get_order_details_by_offerid_model_without_offer($entity_id)
    {
        $this->db->select('sales_order_register.*');
        $this->db->from('sales_order_register');
        // $this->db->join('offer_register', 'sales_order_register.offer_id = offer_register.entity_id', 'INNER');
        // $this->db->join('enquiry_register', 'offer_register.enquiry_id = enquiry_register.entity_id', 'INNER');
        $where = '(sales_order_register.entity_id = "'.$entity_id.'" )';
        $this->db->where($where);
        $query = $this->db->get();
        // $query_result = $query->result();
        // print_r($query_result);
        // die();
        return $query;
    }
}
?>
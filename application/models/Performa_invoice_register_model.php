<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
	class Performa_invoice_register_model extends CI_Model{

		public function get_all_performa_details()
	    {
	        $user_id = $_SESSION['user_id'];
	        $emp_id = $_SESSION['emp_id'];

	        if($user_id ==1){

	            $this->db->select('performa_register.*,
	            employee_master.emp_first_name');
	            $this->db->from('performa_register');
	            $this->db->join('employee_master', 'performa_register.emp_id = employee_master.entity_id', 'INNER');
	            $where = '(performa_register.status = "'.'1'.'" or performa_register.status = "'.'2'.'")';
	            $this->db->where($where);
	            $this->db->order_by('performa_register.entity_id', 'DESC');
	            $query = $this->db->get();
	            $query_result = $query->result();
	            return $query_result;
	        }else{

	            $this->db->select('performa_register.*,
	            employee_master.emp_first_name');
	            $this->db->from('performa_register');
	            $where = '(performa_register.emp_id = "'.$emp_id.'")';
	            $this->db->where($where);
	            $where_1 = '(performa_register.status = "'.'1'.'" or performa_register.status = "'.'2'.'")';
	            $this->db->where($where_1);
	            $this->db->join('employee_master', 'performa_register.emp_id = employee_master.entity_id', 'INNER');
	            $this->db->order_by('performa_register.entity_id', 'DESC');
	            $query = $this->db->get();
	            $query_result = $query->result();
	            return $query_result;
	        }     
	    }

	    public function get_all_order_details()
	    {
	        $user_id = $_SESSION['user_id'];
	        $emp_id = $_SESSION['emp_id'];

	        if($user_id ==1){

	            $this->db->select('sales_order_register.*,
	            employee_master.emp_first_name');
	            $this->db->from('sales_order_register');
	            $where = '(sales_order_register.invoice_status = "'.'1'.'")';
	            $this->db->where($where);
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
	            $where1 = '(sales_order_register.invoice_status = "'.'1'.'")';
	            $this->db->where($where1);
	            $this->db->join('employee_master', 'sales_order_register.order_engg_name = employee_master.entity_id', 'INNER');
	            $this->db->order_by('sales_order_register.entity_id', 'DESC');
	            $this->db->group_by('sales_order_register.entity_id');
	            $query = $this->db->get();
	            $query_result = $query->result();
	            return $query_result;
	        }
	    }

	    public function so_to_performa_save_model($entity_id)
	    {
	        $this->db->select('*');
	        $this->db->from('sales_order_register');
	        $where = '(entity_id = "'.$entity_id.'")';
	        $this->db->where($where);
	        $sales_order_register = $this->db->get();
	        $sales_order_register_data =  $sales_order_register->row();

	        $sales_order_id = $sales_order_register_data->entity_id;
	        $customer_id = $sales_order_register_data->customer_id;
	        $emp_id = $sales_order_register_data->order_engg_name;
	        $freight_charges = $sales_order_register_data->transportation_price;
	        $packing_forwarding_price = $sales_order_register_data->packing_forwarding_price;
	        $insurance_price = $sales_order_register_data->insurance_price;
	        $loading_price = $sales_order_register_data->loading_price;
	        $unloading_price = $sales_order_register_data->unloading_price;
	        $status = '1';
	        
	        $this->db->select('customer_address_master.*,state_master.state_name,city_master.city_name,customer_master.customer_name');
	        $this->db->from('customer_address_master');
	        $where = '(customer_id = "'.$customer_id.'" And address_type = "'.'1'.'")';
	        $this->db->join('state_master', 'customer_address_master.state_id = state_master.entity_id', 'INNER');
	        $this->db->join('city_master', 'customer_address_master.city_id = city_master.entity_id', 'INNER');
	        $this->db->join('customer_master', 'customer_address_master.customer_id = customer_master.entity_id', 'INNER');
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

	        $this->db->select('customer_address_master.*,state_master.state_name,city_master.city_name,customer_master.customer_name');
	        $this->db->from('customer_address_master');
	        $where = '(customer_id = "'.$customer_id.'" And address_type = "'.'2'.'")';
	        $this->db->join('state_master', 'customer_address_master.state_id = state_master.entity_id', 'INNER');
	        $this->db->join('city_master', 'customer_address_master.city_id = city_master.entity_id', 'INNER');
	        $this->db->join('customer_master', 'customer_address_master.customer_id = customer_master.entity_id', 'INNER');
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
	        $ship_to_customer_name = $ship_to_address_data->customer_name;

	        $new_ship_to_address = $ship_to_address.'  '.$ship_to_state_name.' , '.$ship_to_city_name.' , '.$ship_to_pin_code;


	        $this->db->select('*');
	        $this->db->from('customer_contact_master');
	        $where = '(customer_id = "'.$customer_id.'" And customer_address_id = "'.$ship_to_address_id.'")';
	        $this->db->where($where);
	        $ship_to_contact = $this->db->get();
	        $ship_to_contact_data =  $ship_to_contact->row();

	        $ship_to_contact_id = $ship_to_contact_data->entity_id;
	        $ship_to_contact_person = $ship_to_contact_data->contact_person;
	        $ship_to_email_id = $ship_to_contact_data->email_id;
	        $ship_to_first_contact_no = $ship_to_contact_data->first_contact_no;


	        $this->db->select('*');
	        $this->db->from('customer_contact_master');
	        $where = '(customer_id = "'.$customer_id.'" And customer_address_id = "'.$bill_to_address_id.'")';
	        $this->db->where($where);
	        $bill_to_contact = $this->db->get();
	        $bill_to_contact_data =  $ship_to_contact->row();

	        $bill_to_contact_id = $ship_to_contact_data->entity_id;
	        $bill_to_contact_person = $ship_to_contact_data->contact_person;
	        $bill_to_email_id = $ship_to_contact_data->email_id;
	        $bill_to_first_contact_no = $ship_to_contact_data->first_contact_no;


	        $this->db->select('*');
	        $this->db->from('performa_register');
	        $where = '(sales_order_id = "'.$entity_id.'" and status != "'.'3'.'")';
	        $this->db->where($where);
	        /*$where_or = '(status != "'.'2'.'" )';
	        $this->db->where($where_or);*/
	        $performa_register= $this->db->get();
	        $performa_register_exit_data_count =  $performa_register->num_rows();

	        
	        if ($performa_register_exit_data_count == 0) 
	        {
	            $this->db->select('performa_number');
		        $this->db->from('performa_register');
		        $this->db->order_by('entity_id', 'DESC');
		        $this->db->limit(1);
		        $performa_register = $this->db->get();
		        $results_performa_register = $performa_register->result_array();

		        if(!empty($results_performa_register))
		        {
		            $performa_serial_no = $results_performa_register[0]['performa_number'];
		            $performa_data_seprate = explode('/', $performa_serial_no);
		            $po_doc_year = $performa_data_seprate['1'];
		        }

		        $this->db->select('document_series_no');
		        $this->db->from('documentseries_master');
		        $this->db->where('entity_id=10');
		        $doc_record=$this->db->get();
		        $results_doc_record = $doc_record->result_array();

		        $doc_serial_no = $results_doc_record[0]['document_series_no'];
		        $doc_data_seprate = explode('/', $doc_serial_no);
		        $doc_year = $doc_data_seprate['1'];

		        if(empty($results_performa_register[0]['performa_number']) || ($po_doc_year != $doc_year))
		        {
		            $first_no = '0001';
		            $doc_no = $doc_serial_no.$first_no;
		        }elseif(!empty($results_performa_register) && ($po_doc_year == $doc_year))
		        {
		            $doc_type = $performa_data_seprate['0'];
		            $ex_no = $performa_data_seprate['2'];
		            $next_en = $ex_no + 1;
		            $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
		            $doc_no = $doc_type.'/'.$po_doc_year.'/'.$next_doc_no;
		        }

		        date_default_timezone_set("Asia/Calcutta");
            	$performa_date = date('Y-m-d');

            	$this->db->select_sum('unit_discounted_price');
	            $this->db->from('sales_order_product_relation');
	            $where = '(sales_order_id = "'.$entity_id.'")';
	            $this->db->where($where);
	            $unit_discounted_price = $this->db->get();
	            $unit_discounted_price_sum =  $unit_discounted_price->row();

	            $Unit_discounted_price = $unit_discounted_price_sum->unit_discounted_price;

	            $this->db->select_sum('discount_amt');
	            $this->db->from('sales_order_product_relation');
	            $where = '(sales_order_id = "'.$entity_id.'")';
	            $this->db->where($where);
	            $discount_amt = $this->db->get();
	            $discount_amt_sum =  $discount_amt->row();

	            $Discount_amt = $discount_amt_sum->discount_amt;

	            $Basic_amount = $Unit_discounted_price + $Discount_amt;

	            $this->db->select_sum('total_amount_without_gst');
	            $this->db->from('sales_order_product_relation');
	            $where = '(sales_order_id = "'.$entity_id.'")';
	            $this->db->where($where);
	            $total_amount_without_gst = $this->db->get();
	            $total_amount_without_gst_sum =  $total_amount_without_gst->row();

	            $Total_amount_without_gst = $total_amount_without_gst_sum->total_amount_without_gst;


	            $this->db->select_sum('cgst_amount');
	            $this->db->from('sales_order_product_relation');
	            $where = '(sales_order_id = "'.$entity_id.'")';
	            $this->db->where($where);
	            $cgst_amount = $this->db->get();
	            $cgst_amount_sum =  $cgst_amount->row();

	            $Cgst_amount = $cgst_amount_sum->cgst_amount;


	            $this->db->select_sum('sgst_amount');
	            $this->db->from('sales_order_product_relation');
	            $where = '(sales_order_id = "'.$entity_id.'")';
	            $this->db->where($where);
	            $sgst_amount = $this->db->get();
	            $sgst_amount_sum =  $sgst_amount->row();

	            $Sgst_amount = $sgst_amount_sum->sgst_amount;


	            $this->db->select_sum('igst_amount');
	            $this->db->from('sales_order_product_relation');
	            $where = '(sales_order_id = "'.$entity_id.'")';
	            $this->db->where($where);
	            $igst_amount = $this->db->get();
	            $igst_amount_sum =  $igst_amount->row();

	            $Igst_amount = $igst_amount_sum->igst_amount;

	            $this->db->select_sum('total_amount_with_gst');
	            $this->db->from('sales_order_product_relation');
	            $where = '(sales_order_id = "'.$entity_id.'")';
	            $this->db->where($where);
	            $total_amount_with_gst = $this->db->get();
	            $total_amount_with_gst_sum =  $total_amount_with_gst->row();

	            $Total_amount_with_gst = $total_amount_with_gst_sum->total_amount_with_gst;

	            $inst_arr = Array('performa_number' => $doc_no , 'sales_order_id' => $sales_order_id , 'performa_date' => $performa_date , 'customer_id' => $customer_id , 'customer_name' => $bill_to_customer_name , 'bill_to_id' => $customer_id , 'bill_to_name' => $bill_to_customer_name , 'bill_to_address_id' => $bill_to_address_id , 'bill_to_address' => $new_bill_to_address , 'bill_to_gst_no' => $bill_to_gst_no , 'bill_to_contact_person_id' => $bill_to_contact_id , 'bill_to_contact_person' => $bill_to_contact_person , 'bill_to_contact_person_number' => $bill_to_first_contact_no , 'bill_to_contact_person_mail_id' => $bill_to_email_id , 'ship_to_id' => $customer_id , 'ship_to_name' => $ship_to_customer_name , 'ship_to_address_id' => $ship_to_address_id , 'ship_to_address' => $new_ship_to_address , 'ship_to_gst_no' => $ship_to_gst_no , 'ship_to_contact_person_id' => $ship_to_contact_id , 'ship_to_contact_person' => $ship_to_contact_person , 'ship_to_contact_person_number' => $ship_to_first_contact_no , 'ship_to_contact_person_mail_id' => $ship_to_email_id , 'emp_id' => $emp_id , 'freight_amount' => $freight_charges , 'packing_forwarding_amount' => $packing_forwarding_price , 'insurance_amount' => $insurance_price , 'loading_amount' => $loading_price , 'unloading_amount' => $unloading_price , 'total_amount' => $Basic_amount , 'total_discount' => $Discount_amt , 'total_taxable_amount' => $Total_amount_without_gst , 'cgst_amount' => $Cgst_amount , 'sgst_amount' => $Sgst_amount , 'igst_amount' => $Igst_amount , 'final_amount' => $Total_amount_with_gst , 'status' => 1);

	            $this->db->insert('performa_register', $inst_arr);
	            $performa_lastid = $this->db->insert_id();

	            $this->db->select('*');
	            $this->db->from('sales_order_product_relation');
	            $where_p = '(sales_order_id = "'.$entity_id.'")';
	            $this->db->where($where_p);
	            $order_master_product = $this->db->get();
	            $order_master_product_data =  $order_master_product->result_array();

	            foreach ($order_master_product_data as $key => $value) {

	                $product_id = $value['product_id'];

	                $this->db->select('*');
		            $this->db->from('product_master');
		            $where_p = '(entity_id = "'.$product_id.'")';
		            $this->db->where($where_p);
		            $product_master = $this->db->get();
		            $product_master_data =  $product_master->row();

		            $Product_master_id = $product_master_data->product_id;

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

	                $order_product_master_save = "INSERT INTO performa_product_relation (performa_invoice_id , sales_order_id , product_id , product_master_id , sales_order_product_description , qty  , sales_order_price , discount_percentage , discount_amount , total_amount_without_gst , cgst_percentage , cgst_amount , sgst_percentage , sgst_amount , igst_percentage , igst_amount , total_amount_with_gst , unit_discount_price) VALUES ('".$performa_lastid."' , '".$entity_id."' , '".$product_id."' , '".$Product_master_id."' , '".$product_custom_description."' , '".$product_qty."' , '".$price."' , '".$discount."' , '".$discount_amt."', '".$total_amount_without_gst."' , '".$cgst_discount."' , '".$cgst_amt."', '".$sgst_discount."' , '".$sgst_amt."' , '".$igst_discount."' , '".$igst_amt."' , '".$total_amount_with_gst."' , '".$unit_discounted_price."')";
	                    $product_execute = $this->db->query($order_product_master_save);
	            }
	        }
	    }

	    public function get_customer_list()
	    {
	        $this->db->select('*');
	        $this->db->from('customer_master');
	        $query = $this->db->get();
	        $query_result = $query->result();
	        return $query_result;  
	    }

	    public function get_performa_details_by_id_model($entity_id)
        {
            $this->db->select('*');
            $this->db->from('performa_register');
            $where = '(performa_register.sales_order_id = "'.$entity_id.'" )';
            $this->db->where($where);
            $this->db->order_by('performa_register.entity_id', 'DESC');
            $this->db->limit(1);
            $query_data = $this->db->get();
            $query_result = $query_data->row_array();

            $performa_entity_id = $query_result['entity_id'];

            $this->db->select('performa_register.*,
                sales_order_register.sales_order_no');
            $this->db->from('performa_register');
            $this->db->join('sales_order_register', 'performa_register.sales_order_id = sales_order_register.entity_id', 'INNER');
            $where = '(performa_register.entity_id = "'.$performa_entity_id.'" )';
            $this->db->where($where);
            $query = $this->db->get();
            
            return $query;
        }

        public function get_ship_to_address_model_data($customer_id)
	    {
	    	$this->db->select('customer_address_master.entity_id AS Cust_ship_id,
             	CONCAT(customer_address_master.address,'.'" , "'.', state_master.state_name,'.'" , "'.', city_master.city_name,'.'" , "'.', customer_address_master.pin_code) AS Cust_ship_address');
            $this->db->from('customer_address_master');
            $this->db->join('state_master', 'customer_address_master.state_id = state_master.entity_id', 'INNER');
            $this->db->join('city_master', 'customer_address_master.city_id = city_master.entity_id', 'INNER');
            $where = '(customer_address_master.customer_id = "'.$customer_id.'" And customer_address_master.address_type = "'.'2'.'")';
            $this->db->where($where);
            $query_data = $this->db->get();
            $query_result = $query_data->result();
	        return $query_result;
	    }

	    public function get_ship_to_contact_model_data($address_id)
	    {
	    	$this->db->select('customer_contact_master.*');
            $this->db->from('customer_contact_master');
            $where = '(customer_contact_master.customer_address_id = "'.$address_id.'")';
            $this->db->where($where);
            $query_data = $this->db->get();
            $query_result = $query_data->result();
	        return $query_result;
	    }

	    public function get_bill_to_address_model_data($customer_id)
	    {
	    	$this->db->select('customer_address_master.entity_id AS Cust_bill_id,
             	CONCAT(customer_address_master.address,'.'" , "'.', state_master.state_name,'.'" , "'.', city_master.city_name,'.'" , "'.', customer_address_master.pin_code) AS Cust_bill_address');
            $this->db->from('customer_address_master');
            $this->db->join('state_master', 'customer_address_master.state_id = state_master.entity_id', 'INNER');
            $this->db->join('city_master', 'customer_address_master.city_id = city_master.entity_id', 'INNER');
            $where = '(customer_address_master.customer_id = "'.$customer_id.'" And customer_address_master.address_type = "'.'1'.'")';
            $this->db->where($where);
            $query_data = $this->db->get();
            $query_result = $query_data->result();
	        return $query_result;
	    }

	    public function get_bill_to_contact_model_data($address_id)
	    {
	    	$this->db->select('customer_contact_master.*');
            $this->db->from('customer_contact_master');
            $where = '(customer_contact_master.customer_address_id = "'.$address_id.'")';
            $this->db->where($where);
            $query_data = $this->db->get();
            $query_result = $query_data->result();
	        return $query_result;
	    }

	    public function get_order_product_list($entity_id)
	    {
	        $this->db->select('performa_product_relation.*,
	            product_master.product_name,
	            product_master.product_id,
	            product_hsn_master.hsn_code');
	        $this->db->from('performa_product_relation');
	        $this->db->join('product_master', 'performa_product_relation.product_id = product_master.entity_id', 'INNER');
	        $this->db->join('product_hsn_master', 'product_master.hsn_id = product_hsn_master.entity_id', 'INNER');
	        $where = '(performa_product_relation.performa_invoice_id = "'.$entity_id.'" )';
	        $this->db->where($where);
	        $query = $this->db->get();
	        $query_data_result = $query->result();
	        return $query_data_result;  
	    }

	    public function get_second_page_performa_invoice_details_by_id_model($entity_id)
        {
            $this->db->select('performa_register.*,
                sales_order_register.sales_order_no');
            $this->db->from('performa_register');
            $this->db->join('sales_order_register', 'performa_register.sales_order_id = sales_order_register.entity_id', 'INNER');
            $where = '(performa_register.entity_id = "'.$entity_id.'" )';
            $this->db->where($where);
            $query = $this->db->get();
            
            return $query;
        }

        public function update_order_product_relation($update_array)
	    {
	        $this->db->where('entity_id', $update_array['entity_id']);
	        return $this->db->update('performa_product_relation', $update_array);
	    }
	}
?>
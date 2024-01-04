<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
	class Purchase_order_register_model extends CI_Model{

		public function get_all_order_details()
	    {
	        $user_id = $_SESSION['user_id'];
	        $emp_id = $_SESSION['emp_id'];

	        if($user_id ==1){

	            $this->db->select('purchase_order_register.*,
	            employee_master.emp_first_name');
	            $this->db->from('purchase_order_register');
	            $this->db->join('employee_master', 'purchase_order_register.order_engg_name = employee_master.entity_id', 'INNER');
	            $this->db->order_by('purchase_order_register.entity_id', 'DESC');
	            $query = $this->db->get();
	            $query_result = $query->result();
	            return $query_result;
	        }else{

	            $this->db->select('purchase_order_register.*,
	            employee_master.emp_first_name');
	            $this->db->from('purchase_order_register');
	            $where = '(purchase_order_register.order_engg_name = "'.$emp_id.'")';
	            $this->db->where($where);
	            $this->db->join('employee_master', 'purchase_order_register.order_engg_name = employee_master.entity_id', 'INNER');
	            $this->db->order_by('purchase_order_register.entity_id', 'DESC');
	            $query = $this->db->get();
	            $query_result = $query->result();
	            return $query_result;
	        }     
	    }

	    public function so_to_po_save_model($entity_id)
	    {
	        $this->db->select('*');
	        $this->db->from('sales_order_register');
	        $where = '(entity_id = "'.$entity_id.'")';
	        $this->db->where($where);
	        $sales_order_register = $this->db->get();
	        $sales_order_register_data =  $sales_order_register->row();

	        $sales_order_id = $sales_order_register_data->entity_id;
	        $sales_order_description = $sales_order_register_data->sales_order_description;
	        
	        $emp_id = $sales_order_register_data->order_engg_name;
	        $freight_status = $sales_order_register_data->transportation;
	        $freight_charges = $sales_order_register_data->transportation_price;
	        $delivery_period = $sales_order_register_data->delivery_period;
	        $dispatch_address = $sales_order_register_data->dispatch_address;
	        $delivery_instruction = $sales_order_register_data->delivery_instruction;
	        $packing_forwarding = $sales_order_register_data->packing_forwarding;
	        $packing_forwarding_price = $sales_order_register_data->packing_forwarding_price;
	        $insurance = $sales_order_register_data->insurance;
	        $insurance_price = $sales_order_register_data->insurance_price;
	        $special_packing = $sales_order_register_data->special_packing;
	        $payment_term = $sales_order_register_data->payment_term;
	        $terms_conditions = $sales_order_register_data->terms_conditions;

	        $salutation = $sales_order_register_data->salutation;
	        $price_basis = $sales_order_register_data->price_basis;
	        $transport_insurance = $sales_order_register_data->transport_insurance;
	        $tax = $sales_order_register_data->tax;
	        $delivery_schedule = $sales_order_register_data->delivery_schedule;
	        $mode_of_payment = $sales_order_register_data->mode_of_payment;
	        $mode_of_transport = $sales_order_register_data->mode_of_transport;
	        $guarantee_warrenty = $sales_order_register_data->guarantee_warrenty;
	        $status = '1';

	        
	        $bill_to_state_code = 24;
	        $bill_to_gst_no = "24AAKFM4223D1ZP";
	        $bill_to_pan_no = "";
	        $bill_to_customer_name = "Maitry Instruments & Control";
	        $new_bill_to_address = "Shop No. 42, 1st Floor, Akshar Shopping Center,\n Road No. 1, Udyognagar, Udhna Surat - 394210,\n Gujarat, India";

	        
	        $ship_to_state_code = 24;
	        $ship_to_gst_no = "24AAKFM4223D1ZP";
	        $ship_to_pan_no = "";
	        $ship_to_customer_name = "Maitry Instruments & Control";
	        $new_ship_to_address = "Shop No. 42, 1st Floor, Akshar Shopping Center,\n Road No. 1, Udyognagar, Udhna Surat - 394210,\n Gujarat, India";

	        $ship_to_contact_person = "Nilesh vashi";
	        $ship_to_email_id = "";
	        $ship_to_first_contact_no = "08048763439";

	        $bill_to_contact_person = "Nilesh vashi";
	        $bill_to_email_id = "";
	        $bill_to_first_contact_no = "08048763439";


	        $this->db->select('*');
	        $this->db->from('purchase_order_register');
	        $where_or = '(sales_order_id = "'.$entity_id.'")';
	        $this->db->where($where_or);
	        $purchase_order_register= $this->db->get();
	        $purchase_order_register_exit_data_count =  $purchase_order_register->num_rows();
	        
	        if ($purchase_order_register_exit_data_count == 0) 
	        {
	            $this->db->select('po_no');
		        $this->db->from('purchase_order_register');
		        $this->db->order_by('entity_id', 'DESC');
		        $this->db->limit(1);
		        $purchase_order_register = $this->db->get();
		        $results_purchase_order_register = $purchase_order_register->result_array();

		        if(!empty($results_purchase_order_register))
		        {
		            $po_serial_no = $results_purchase_order_register[0]['po_no'];
		            $po_data_seprate = explode('/', $po_serial_no);
		            $po_doc_year = $po_data_seprate['1'];
		        }

		        $this->db->select('document_series_no');
		        $this->db->from('documentseries_master');
		        $this->db->where('entity_id=9');
		        $doc_record=$this->db->get();
		        $results_doc_record = $doc_record->result_array();

		        $doc_serial_no = $results_doc_record[0]['document_series_no'];
		        $doc_data_seprate = explode('/', $doc_serial_no);
		        $doc_year = $doc_data_seprate['1'];

		        if(empty($results_purchase_order_register[0]['po_no']) || ($po_doc_year != $doc_year))
		        {
		            $first_no = '0001';
		            $doc_no = $doc_serial_no.$first_no;
		        }elseif(!empty($results_purchase_order_register) && ($po_doc_year == $doc_year))
		        {
		            $doc_type = $po_data_seprate['0'];
		            $ex_no = $po_data_seprate['2'];
		            $next_en = $ex_no + 1;
		            $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
		            $doc_no = $doc_type.'/'.$po_doc_year.'/'.$next_doc_no;
		        }

	            $inst_arr = Array('po_no' => $doc_no , 'sales_order_id' => $sales_order_id ,'customer_bill_to_name' => $bill_to_customer_name ,'customer_bill_to_address' => $new_bill_to_address ,'customer_bill_to_gst_no' => $bill_to_gst_no ,'customer_bill_to_contact_person' => $bill_to_contact_person ,'customer_bill_to_contact_person_mail' => $bill_to_email_id ,'customer_bill_to_contact_person_no' => $bill_to_first_contact_no ,'customer_ship_to_name' => $ship_to_customer_name ,'customer_ship_to_address' => $new_ship_to_address ,'customer_ship_to_gst_no' => $ship_to_gst_no ,'customer_ship_to_contact_person' => $ship_to_contact_person ,'customer_ship_to_contact_person_mail' => $ship_to_email_id ,'customer_ship_to_contact_person_no' => $ship_to_first_contact_no , 'po_description' => $sales_order_description , 'special_customer' => 6 , 'order_engg_name' => $emp_id , 'delivery_period' => $delivery_period , 'delivery_instruction' => $delivery_instruction , 'transportation' => $freight_status , 'transportation_price' => $freight_charges , 'dispatch_address' => $dispatch_address , 'packing_forwarding_price' => $packing_forwarding_price , 'insurance_price' => $insurance_price , 'payment_term' => $payment_term , 'packing_forwarding' => $packing_forwarding , 'insurance' => $insurance , 'special_packing' => $special_packing , 'terms_conditions' => $terms_conditions , 'salutation' => $salutation ,'price_basis' => $price_basis ,'transport_insurance' => $transport_insurance ,'tax' => $tax ,'delivery_schedule' => $delivery_schedule ,'mode_of_payment' => $mode_of_payment ,'mode_of_transport' => $mode_of_transport ,'guarantee_warrenty' => $guarantee_warrenty , 'status' => 1);

	            $this->db->insert('purchase_order_register', $inst_arr);
	            $order_master_lastid = $this->db->insert_id();

	            $this->db->select('*');
	            $this->db->from('sales_order_product_relation');
	            $where_p = '(sales_order_id = "'.$entity_id.'")';
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

	                $order_product_master_save = "INSERT INTO purchase_order_product_relation (purchase_order_id, product_id, rfq_qty, delivery_period, product_custom_description, price, discount, discount_amt, total_amount_without_gst, cgst_discount, cgst_amount, sgst_discount, sgst_amount, igst_discount, igst_amount, total_amount_with_gst, product_warranty, unit_discounted_price) VALUES ('".$order_master_lastid."', '".$product_id."', '".$product_qty."', '".$delivery_period."', '".$product_custom_description."', '".$price."', '".$discount."', '".$discount_amt."', '".$total_amount_without_gst."', '".$cgst_discount."', '".$cgst_amt."', '".$sgst_discount."', '".$sgst_amt."', '".$igst_discount."', '".$igst_amt."', '".$total_amount_with_gst."', '".$product_warranty."', '".$unit_discounted_price."')";
	                    $product_execute = $this->db->query($order_product_master_save);
	            }
	        }
	    }

	    public function get_vendor_list()
	    {
	        $this->db->select('*');
	        $this->db->from('vendor_master');
	        /*$where = '(vendor_master.status != "'.'3'.'")';
	        $this->db->where($where);*/
	        $this->db->order_by('entity_id', 'DESC');
	        $query = $this->db->get();
	        $query_result = $query->result();
	        return $query_result;  
	    }

	    public function get_purchase_order_details_by_id_model($entity_id)
        {
            $this->db->select('*');
            $this->db->from('purchase_order_register');
            $where = '(purchase_order_register.sales_order_id = "'.$entity_id.'" )';
            $this->db->where($where);
            $this->db->order_by('purchase_order_register.entity_id', 'DESC');
            $this->db->limit(1);
            $query_data = $this->db->get();
            $query_result = $query_data->row_array();

            $po_entity_id = $query_result['entity_id'];

            $this->db->select('purchase_order_register.*,
                sales_order_register.sales_order_no');
            $this->db->from('purchase_order_register');
            $this->db->join('sales_order_register', 'purchase_order_register.sales_order_id = sales_order_register.entity_id', 'INNER');
            $where = '(purchase_order_register.entity_id = "'.$po_entity_id.'" )';
            $this->db->where($where);
            $query = $this->db->get();
            
            return $query;
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
	        $this->db->select('purchase_order_product_relation.*,
	            product_master.product_name,
	            product_master.product_id,
	            product_hsn_master.hsn_code');
	        $this->db->from('purchase_order_product_relation');
	        $this->db->join('product_master', 'purchase_order_product_relation.product_id = product_master.entity_id', 'INNER');
	        $this->db->join('product_hsn_master', 'product_master.hsn_id = product_hsn_master.entity_id', 'INNER');
	        $where = '(purchase_order_product_relation.purchase_order_id = "'.$entity_id.'" )';
	        $this->db->where($where);
	        $query = $this->db->get();
	        $query_data_result = $query->result();
	        return $query_data_result;  
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

	    public function get_product_hsn_code()
	    {
	        $this->db->select('*');
	        $this->db->from('product_hsn_master');
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

	    public function get_city_model_data($state_id)
	    {
	        $query = $this->db->get_where('city_master', array('state_id' => $state_id));
	        return $query;
	    }

	    public function get_state_code_by_id_model($id)
	    {
	        $this->db->select('*');
	        $this->db->from('state_master');
	        $where = '(state_master.entity_id = "'.$id.'" )';
	        $this->db->where($where);
	        $query = $this->db->get();
	        return $query;
	    }

	    public function update_order_product_relation($update_array)
	    {
	        $this->db->where('entity_id', $update_array['entity_id']);
	        return $this->db->update('purchase_order_product_relation', $update_array);
	    }

	    public function delete_order_product($entity_id)
	    {
	        $this->db->where('entity_id', $entity_id);
	        return $this->db->delete('purchase_order_product_relation'); 
	    }

	    public function get_second_page_purchase_order_details_by_id_model($entity_id)
        {
            $this->db->select('purchase_order_register.*,
                sales_order_register.sales_order_no');
            $this->db->from('purchase_order_register');
            $this->db->join('sales_order_register', 'purchase_order_register.sales_order_id = sales_order_register.entity_id', 'INNER');
            $where = '(purchase_order_register.entity_id = "'.$entity_id.'" )';
            $this->db->where($where);
            $query = $this->db->get();
            
            return $query;
        }
	}
?>
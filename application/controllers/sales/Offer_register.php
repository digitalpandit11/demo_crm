<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ob_start();
class Offer_register extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('offer_register_model');
        $this->load->model('enquiry_tracking_register_model');
        $this->load->model('offer_datatable_model');
        $this->load->library('session');
        $this->load->library("Offer_pdf");
        $this->load->library("Offer2_pdf");
        $this->load->library('email');
    }

    public function add_hsn_data()
    {
        $offer_entity_id = $this->input->post('offer_entity_id');

        $offer_customer_id = $this->input->post('customer_name');
        $contact_id = $this->input->post('contact_id');

        $offer_company_name = $this->input->post('offer_company_name');

        $enquiry_descrption = $this->input->post('enquiry_descrption');
        $employee_id = $this->input->post('employee_id');
        $offer_for = $this->input->post('offer_for');
        $offer_date = $this->input->post('offer_date');
        $offer_terms_condition = $this->input->post('offer_terms_condition');
        $offer_source = $this->input->post('offer_source');
        $price_condition = $this->input->post('price_condition');
        $salutation = $this->input->post('salutation');
        $tax = $this->input->post('tax');
        $your_reference = $this->input->post('your_reference');
        $validity = $this->input->post('validity');
		$offer_note = $this->input->post('offer_note');


        // $this->db->select('*');
        // $this->db->from('offer_register');
        // $where = '(offer_register.enquiry_id = "'.$enquiry_entity_id.'" )';
        // $this->db->where($where);
        // $this->db->order_by('offer_register.entity_id', 'DESC');
        // $this->db->limit(1);
        // $query_data = $this->db->get();
        // $query_result = $query_data->row_array();

        // $offer_entity_id = $query_result['entity_id'];

        $update_offer_array = array(
			'customer_id' => $offer_customer_id , 
			'contact_person_id' => $contact_id ,
			'offer_description' => $enquiry_descrption , 
			'offer_engg_name' => $employee_id , 
			'offer_for' => $offer_for , 
			'offer_date' => $offer_date , 
			'terms_conditions' => $offer_terms_condition , 
			'offer_source' => $offer_source , 
			'price_condition' => $price_condition, 
			'salutation' => $salutation, 
			'tax' => $tax, 
			'your_reference' => $your_reference , 
			'validity' => $validity , 
			'note' => $offer_note , 
			'offer_company_name' => $offer_company_name
		);

        $where = '(entity_id ="'.$offer_entity_id.'")';
        $this->db->where($where);
        $this->db->update('offer_register',$update_offer_array);

        $hsn_code = $this->input->post('hsn_code');
        $hsn_percentage = $this->input->post('hsn_percentage');

        $sgst = $hsn_percentage/2;
        $cgst = $hsn_percentage/2;
        $igst = $hsn_percentage;

        $hsn_code_save = "INSERT INTO product_hsn_master (hsn_code , total_gst_percentage , sgst , cgst , igst) VALUES ('".$hsn_code."','".$hsn_percentage."', '".$sgst."', '".$cgst."', '".$hsn_percentage."')";

        $save_execute = $this->db->query($hsn_code_save);
        
        $hsn_lastid = $this->db->insert_id();

        echo json_encode($hsn_lastid);
    }

    public function save_common_form_elements()
    {
        $offer_entity_id = $this->input->post('offer_entity_id');

        $offer_customer_id = $this->input->post('customer_name');
        $contact_id = $this->input->post('contact_id');

        $offer_company_name = $this->input->post('offer_company_name');

        $enquiry_descrption = $this->input->post('enquiry_descrption');
        $employee_id = $this->input->post('employee_id');
        $rm_employee_id = $this->input->post('rm_employee_id');
        $principle_engg_id = $this->input->post('principle_engg_id');
        $offer_for = $this->input->post('offer_for');
        $offer_for_info = $this->input->post('offer_for_info');
        $offer_date = $this->input->post('offer_date');
        $offer_terms_condition = $this->input->post('offer_terms_condition');
        $offer_source = $this->input->post('offer_source');
        $price_condition = $this->input->post('price_condition');
        $salutation = $this->input->post('salutation');
        $tax = $this->input->post('tax');
        $your_reference = $this->input->post('your_reference');
        $validity = $this->input->post('validity');
		$offer_note = $this->input->post('offer_note');



        $update_offer_array = array(
			'customer_id' => $offer_customer_id , 
			'contact_person_id' => $contact_id ,
			'offer_description' => $enquiry_descrption , 
			'offer_engg_name' => $employee_id , 
			'offer_rm_employee_id' => $rm_employee_id , 
			'offer_principle_engg_id' => $principle_engg_id , 
			'offer_for' => $offer_for , 
			'offer_for_info' => $offer_for_info , 
			'offer_date' => $offer_date , 
			'terms_conditions' => $offer_terms_condition , 
			'offer_source' => $offer_source , 
			'price_condition' => $price_condition, 
			'salutation' => $salutation, 
			'tax' => $tax, 
			'your_reference' => $your_reference , 
			'validity' => $validity , 
			'note' => $offer_note , 
			'offer_company_name' => $offer_company_name
		);

        $where = '(entity_id ="'.$offer_entity_id.'")';
        $this->db->where($where);
        $result = $this->db->update('offer_register',$update_offer_array);

        echo json_encode($result);
    }

    public function index()
    {
        /*$data['offer_details'] = $this->offer_register_model->get_all_offer_details();
        $this->load->view('sales/offer_register/vw_offer_register_index',$data);*/
        
        $this->load->view('sales/offer_register/vw_offer_register_index');
    }

    public function fetch_working_offers(){

    $fetch_data = $this->offer_datatable_model->make_datatables();
    $data = array();
    $no = 0;
    foreach($fetch_data as $row)
    {
        $no++;
        $entity_id = $row->entity_id;
        $base_url = base_url();
        // $Status_data = $row->status;
        $offer_value = number_format($row->total_amount_with_gst);

        // if($Status_data == 1)
        // {
        //     $Status = "Pending Offer Creation";
        // }elseif($Status_data == 2)
        // {
        //     $Status = "Offer Created";
        // }elseif($Status_data == 3)
        // {
        //     $Status = "Active";
        // }elseif($Status_data == 4)
        // {
        //     $Status = "Offer Lost";
        // }elseif($Status_data == 5)
        // {
        //     $Status = "Offer Regrated";
        // }elseif($Status_data == 6)
        // {
        //     $Status = "Win";
        // }elseif($Status_data == 7)
        // {
        //     $Status = "InActive";
        // }elseif($Status_data == 8)
        // {
        //     $Status = "A";
        // }elseif($Status_data == 9)
        // {
        //     $Status = "B";
        // }elseif($Status_data == 10)
        // {
        //     $Status = "Offer Revised";
        // }else{
        //     $Status = "NA";
        // }

        $edit_button = '<div class="row"><a href="'.$base_url.'update_offer_data/'.$entity_id.'" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a><a href="'.$base_url.'view_offer_data/'.$entity_id.'" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></a></div>';

        $view_button = '';

        $print_button = '';

        $set_order_button = '<div class="row"><a href="'.$base_url.'setorder/'.$entity_id.'"><span class="btn btn-sm btn-info"><i class="fa fa-edit"></i> Set Order</span></a>';
        $revision_button = '<a href="'.$base_url.'set_revision_offer/'.$entity_id.'"><span class="btn btn-sm btn-primary">Revise</span></a></div>';

        $print_withoutgst_button = '<div class="btn-group" role="group">
    <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Print
    </button>
    <div class="dropdown-menu bg-secondary" aria-labelledby="btnGroupDrop1">
      <a href="'.$base_url.'download_offer_without_gst/'.$entity_id.'" target="_blank" class="btn">&nbsp;&nbsp;Simple Print</a><br>
      <a href="'.$base_url.'download_offer/'.$entity_id.'" target="_blank" class="btn">&nbsp;&nbsp;Detail Print</a>
    </div>
  </div>';

        $sub_array = array();
        $sub_array[] = $no;
        $sub_array[] = $row->offer_no;
        $sub_array[] = $row->offer_date;
        // $sub_array[] = $row->enquiry_no;
        $sub_array[] = $row->customer_name;
        $sub_array[] = $row->contact_person;
        $sub_array[] = $row->first_contact_no;
        $sub_array[] = $row->email_id;
        $sub_array[] = $row->emp_first_name;
        $sub_array[] = $row->source_name;
        $sub_array[] = $row->offer_status;
        $sub_array[] = $offer_value;
        $sub_array[] = $edit_button.$view_button;
        $sub_array[] = $revision_button.$print_button;
        // $sub_array[] = ''; // Placeholder for the column before print_withoutgst_button
        $sub_array[] = $print_withoutgst_button; // Column for print_withoutgst_button

        $data[] = $sub_array;
    }

    $output = array(
        "draw" => intval($_POST["draw"]),
        "recordsTotal" => $this->offer_datatable_model->get_all_data(),
        "recordsFiltered" => $this->offer_datatable_model->get_filtered_data(),
        "data" => $data
    );

    echo json_encode($output);

}


    public function vw_all_offer_data()
    {
        $data['offer_details'] = $this->offer_register_model->get_all_offer();
        $this->load->view('sales/offer_register/vw_all_offer_register_index',$data);
        // $this->load->view('sales/offer_register/vw_all_offer_register_index');
    }

    public function vw_draft_offer_data()
    {
        $data['offer_details'] = $this->offer_register_model->get_draft_offer();
        $this->load->view('sales/offer_register/vw_draft_offer_register_index',$data);
        // $this->load->view('sales/offer_register/vw_all_offer_register_index');
    }

    public function vw_my_offer_data()
    {
        $data['offer_details'] = $this->offer_register_model->get_my_offer();
        $this->load->view('sales/offer_register/vw_my_offer_register_index',$data);
        // $this->load->view('sales/offer_register/vw_all_offer_register_index');
    }

    public function create_customer_offer()
    {
        $data['pending_enquiry'] = $this->offer_register_model->get_pending_enquiry();
        $this->load->view('sales/offer_register/vw_pending_enquiry_index',$data);
    }

    public function enquiry_to_offer_save()
    {
        $entity_id = $this->uri->segment(2);
        $offer_data = $this->offer_register_model->enquiry_to_offer_save_model($entity_id);

        $enquiry_data = $this->offer_register_model->get_enquiry_details_by_id_model($entity_id);


        // $data['enquiry_result'] = $enquiry_data;
        // $data['entity_id'] = $entity_id;
        // $data['offer_result'] = $offer_data;

        /*$data['customer_list'] = $this->offer_register_model->get_customer_list();
        $data['customer_contact_list'] = $this->offer_register_model->get_contact_list();
        $data['state_list'] = $this->offer_register_model->get_state_list();*/


        // $data['make_list'] = $this->offer_register_model->get_make_list();
        // $data['source_list'] = $this->offer_register_model->get_enquiry_source_list();
        // $data['unit_list'] = $this->offer_register_model->get_unit_list();
        // $data['employee_list'] = $this->offer_register_model->get_employee_list();
        // $data['offer_for_list'] = $this->offer_register_model->get_offer_for_list();
        // $data['product_list'] = $this->offer_register_model->get_product_list();
        // $data['product_category'] = $this->offer_register_model->get_product_category();
        // $data['product_detail_hsn_code'] = $this->offer_register_model->get_product_hsn_code();
        // $data['offer_product_list'] = $this->offer_register_model->get_offer_product_list($entity_id);
		

        // $this->load->view('sales/offer_register/vw_offer_register_create',$data);

		redirect('update_offer_data/'.$offer_data);
    }


    public function create_offer_from_contact()
    {
        $contact_person_id = $this->uri->segment(2);
        $offer_no = $this->offer_register_model->genrate_offer_number();
        $customer_data = $this->offer_register_model->get_company_data_from_contact_person_id($contact_person_id);
        $offer_entity_id = $this->offer_register_model->create_offer_from_contact_model($offer_no, $contact_person_id);
        $data['customer_data'] = $customer_data;
        $data['offer_entity_id'] = $offer_entity_id;
        $data['make_list'] = $this->offer_register_model->get_make_list();
        $data['unit_list'] = $this->offer_register_model->get_unit_list();
        $data['employee_list'] = $this->offer_register_model->get_employee_list();
        $data['product_list'] = $this->offer_register_model->get_product_list();
        $data['product_category'] = $this->offer_register_model->get_product_category();
        $data['product_detail_hsn_code'] = $this->offer_register_model->get_product_hsn_code();
        $data['offer_product_list'] = $this->offer_register_model->get_offer_product_list($offer_entity_id);

        redirect('update_offer_data'.'/'.$offer_entity_id);

        // $this->load->view('sales/offer_register/vw_offer_register_create_from_contact',$data);
    }


    public function get_offer_details_by_id()
    {
        $entity_id = $this->input->post('entity_id',TRUE);
        $data = $this->offer_register_model->get_offer_details_by_id_model($entity_id)->result();
        echo json_encode($data);
    }
   
   
   
    public function get_offer_details_by_offer_id()
    {
        $entity_id = $this->input->post('entity_id',TRUE);
        $data = $this->offer_register_model->get_offer_details_by_offer_id_model($entity_id)->result();
      
        echo json_encode($data);
    }

   
    public function get_without_lead_offer_details_by_id()
    {
        $entity_id = $this->input->post('entity_id',TRUE);
        $data = $this->offer_register_model->get_without_lead_offer_details_by_id_model($entity_id);
        echo json_encode($data);
    }

 
//     public function upload_template()
//     {
//         // Get offer ID from the form
//         $offer_id = $this->input->post('offer_id');
//         $response = array();

//         // Configuration for file upload
//         $config['upload_path'] = 'assets/product_csv/';
//         $config['allowed_types'] = 'csv';
//         $config['max_size'] = 2048; // Adjust as needed

//         // Load upload library with configuration
//         $this->load->library('upload', $config);

//         // Check if file upload is successful
//         if (!$this->upload->do_upload('template_file')) {
//             $error = $this->upload->display_errors();
//             // Handle the upload error, redirect with error message
//             $this->session->set_flashdata('error', $error);
//             redirect(base_url() . 'update_offer_data/' . $offer_id);
//         } 
//         else 
//         {
//             // Retrieve uploaded file data
//             $data = $this->upload->data();
//             $file_path = 'assets/product_csv/' . $data['file_name'];

//             // Read CSV file data
//             $csv_data = array_map('str_getcsv', file($file_path));
//             // Remove header row
//             $header = array_shift($csv_data);

//             // Arrays to store existing and new products
//             $existing_products = array();
//             $new_products = array();

//             $error_messages_existing = array();
//             $error_messages_new = array();
            
//             // Separate existing and new products
//             foreach ($csv_data as $row) {
//                 $product_custom_part_no = trim($row[0]);
//                 // Check if product exists in product_master table
//                 $product_query = $this->db->get_where('product_master', array('product_id' => $product_custom_part_no));
//                 $existing_product = $product_query->row_array();

//                 if ($existing_product) {
//                     // Existing product, add to existing products array
//                     if (!empty($row[0]) && !empty($row[1]) && !empty($row[2])) {
//                         $existing_products[] = $row;
//                     }
//                 } else {
//                     // New product, add to new products array
//                     if (!empty($row[0]) && !empty($row[1]) && !empty($row[2]) && !empty($row[3]) && !empty($row[4]) && !empty($row[5]) && !empty($row[6]) && !empty($row[7]) && !empty($row[8])) {
//                         $new_products[] = $row;
//                     }
//                 }

//                 if ($existing_product) {
//                     // Existing product, add to existing products array
//                     if (empty($row[0]) || empty($row[1]) || empty($row[2])) {
//                         $error_messages_existing[] = "Incomplete data for existing part code:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $product_custom_part_no . "<br>";
//                     }
//                 } else {
//                     // New product, add to new products array
//                     if (empty($row[0]) || empty($row[1]) || empty($row[2]) || empty($row[3]) || empty($row[4]) || empty($row[5]) || empty($row[6]) || empty($row[7]) || empty($row[8])) {
//                         $error_messages_new[] = "Incomplete data for new part code: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $product_custom_part_no . "<br>";
//                     }
//                 }
//             }

//             // echo '<pre>';print_r( $existing_products);die;
//                         // echo '<pre>';print_r( $new_products);die;

//             // Check if any errors exist
//             if (!empty($error_messages_existing) || !empty($error_messages_new)) {
//                 $response['success'] = false;
//                 // $response['error'] = implode("", $error_messages_existing) . implode("", $error_messages_new).implode("Please Fill all details properly and then uplosd csv file");
//                 $response['error'] = implode("<br>", $error_messages_existing) . "<br>" . implode("<br>", $error_messages_new) . "<br>Please fill all details properly and then upload the CSV file.";

//                 echo json_encode($response);
//                 return;
//             }

//             // Check if both existing and new products arrays are not empty
//             if (!empty($existing_products) && !empty($new_products)) {

//                 // Process existing products
//                 foreach ($existing_products as $row) {

//                     // Fetch additional details from database and insert into offer_product_relation
//                     $product_custom_part_no = trim($row[0]);
//                     $qty = trim($row[1]);
//                     $discount = trim($row[2]);

//                     $this->db->select('entity_id');
//                     $this->db->from('product_master');
//                     $this->db->where('product_id', $product_custom_part_no);
//                     $product_entity = $this->db->get();
//                     $product_entity_row = $product_entity->row();

//                     $product_id = $product_entity_row->entity_id;
                    
//                     // echo print_r($product_id);die;
//                     // Fetch product details from product_master and product_hsn_master tables
//                     $this->db->select('product_master.*, product_hsn_master.total_gst_percentage, product_hsn_master.cgst, product_hsn_master.sgst, product_hsn_master.igst');
//                     $this->db->from('product_master');
//                     $this->db->join('product_hsn_master', 'product_master.hsn_id = product_hsn_master.entity_id','inner');
//                     $this->db->where('product_master.entity_id', $product_id); 
//                     $product_master = $this->db->get();
//                     // echo $this->db->last_query();die;
//                     $product_master_result = $product_master->row();

//                     // echo '<pre>'; print_r($product_master_result);die;
//                     @$gst_percentage = $product_master_result->total_gst_percentage;                     
//                     @$product_custom_description = $product_master_result->product_name;
//                     @$hsn_id = $product_master_result->hsn_id;      
//                     @$igst_percentage = $product_master_result->igst;
                                
//                     // Fetch latest price from product_pricelist_master table
//                     $this->db->select('price');
//                     $this->db->from('product_pricelist_master');
//                     $this->db->where('product_id', $product_id);
//                     $this->db->order_by('entity_id', 'DESC');
//                     $this->db->limit(1);
//                     $product_pricelist_master = $this->db->get();
//                     $product_pricelist_master_result = $product_pricelist_master->row();
                        
//                     $price = $product_pricelist_master_result->price;
                                
//                     // Calculate total amount without GST
//                     $total_amount_without_gst = $price * $qty ;

//                     $igst_amount = $total_amount_without_gst * $igst_percentage/100;

//                     $gst_amount = $total_amount_without_gst * $gst_percentage/100;
                                
//                     $discount_amt = $total_amount_without_gst * ($discount / 100);

//                     $unit_discounted_price = $total_amount_without_gst - $discount_amt;

//                     // Calculate total GST amount
//                     $total_gst_amount = $igst_amount;

//                     $total_amount_with_gst = $total_amount_without_gst + $gst_amount;

//                     // Prepare insert array
//                     $insert_array = array(
//                         "product_id" => $product_id,
//                         "offer_id" => $offer_id,
//                         "product_custom_part_no" => $product_custom_part_no,
//                         "product_custom_description" => $product_custom_description,
//                         // "product_make" => $product_master_result->product_make,
//                         "rfq_qty" => $qty, 
//                         // "product_warranty" => $warrenty,
//                         "price" => $price,
//                         "discount" => $discount,
//                         "discount_amt" =>  $discount_amt ,
//                         "unit_discounted_price" => $unit_discounted_price,
//                         "total_amount_without_gst" => $total_amount_without_gst,
//                         "hsn_id" => $hsn_id,
//                         "gst_percentage" => $gst_percentage,
//                         "gst_amount" => $gst_amount,
//                         "igst_discount" => $igst_percentage,
//                         "igst_amt" => $igst_amount,
//                         "total_amount_with_gst" => $total_amount_with_gst,
//                         // "internal_remark" => $product_master_result->internal_remark
//                     );
//                     // echo '<pre>'; print_r($insert_array );die;  
//                     // Insert into database
//                     $this->db->insert('offer_product_relation', $insert_array);
//                     // echo $this->db->last_query();die;

//                 }

//                 // Process new products
//                 foreach ($new_products as $row) {
                
//                     // Extract product details from CSV row
//                     $product_custom_part_no = trim($row[0]);
//                     $qty = trim($row[1]);
//                     $discount = trim($row[2]);
//                     $product_custom_description = trim($row[3]);
//                     $price = trim($row[8]);
//                     $hsn_code = trim($row[6]);
//                     $unit = trim($row[4]);
//                     $warranty = trim($row[5]);
//                     $category = trim($row[7]);

//                     // Check if category exists, insert if not
//                     $category_query = $this->db->get_where('product_category_master', array('category_name' => $category));
//                     $category_row = $category_query->row_array();
//                     print_r($category_row);die;
//                     if (!$category_row) {
//                         $category_data = array(
//                             'category_name' => $category,
//                             'category_initial' => 'NA'
//                         );
//                         $this->db->insert('product_category_master', $category_data);
//                         $new_category_id = $this->db->insert_id();
//                     }

//                     // Check if unit exists, insert if not
//                     $unit_query = $this->db->get_where('unit_master', array('unit_name' => $unit));
//                     $unit_row = $unit_query->row_array();
//                     if (!$unit_row) {
//                         $unit_data = array(
//                             'unit_name' => $unit,
//                         );
//                         $this->db->insert('unit_master', $unit_data);
//                         $new_unit_id = $this->db->insert_id();
//                     }

//                     // Check if hsn exists, insert if not
//                     $hsn_query = $this->db->get_where('product_hsn_master', array('hsn_code' => $hsn_code));
//                     $hsn_row = $hsn_query->row();
//                     // echo print_r($hsn);die;
//                     if (!$hsn_row) {
//                         $hsn_data = array(
//                             'hsn_code' => $hsn_code,
//                             'total_gst_percentage' => 18,
//                             'cgst' => 9,
//                             'sgst' => 9,
//                             'igst' => 18,

//                         );
//                         $this->db->insert('product_hsn_master', $hsn_data);
//                         $new_hsn_id = $this->db->insert_id();
//                     }

//                     // Insert new product into product_master table
//                     $product_data = array(
//                         'product_id' => $product_custom_part_no,
//                         'product_name' => $product_custom_description,
//                         'category_id' => $new_category_id,
//                         'unit' => $new_unit_id,
//                         'hsn_id' => $new_hsn_id,
//                         'warrenty' => $warranty,
//                     );
//                     $this->db->insert('product_master', $product_data);
//                     $new_product_id = $this->db->insert_id();

//                     $price_details = array(
//                         'price' => $price,
//                         'year' => "2024",
//                         'product_id' => $new_product_id
//                     );
//                     $this->db->insert('product_pricelist_master', $price_details);

//                     // Convert $price and $qty to numeric values
//                     $price = floatval($price);
//                     $qty = intval($qty);

//                     // Calculate fields for new product
//                     $total_amount_without_gst = $price * $qty;
//                     $product_hsn_query = $this->db->get_where('product_hsn_master', array('hsn_code' => $hsn_code));
//                     $product_hsn = $product_hsn_query->row_array();
//                     $gst_percentage = $product_hsn['total_gst_percentage'];
//                     $gst_amount = $total_amount_without_gst * $gst_percentage / 100;
//                     $discount_amt = $total_amount_without_gst * ($discount / 100);
//                     $unit_discounted_price = $total_amount_without_gst - $discount_amt;
//                     $total_gst_amount = $gst_amount;
//                     $total_amount_with_gst = $total_amount_without_gst + $gst_amount;

//                     // Prepare insert array for offer_product_relation
//                     $insert_array = array(
//                         'product_id' =>  $new_product_id,
//                         'offer_id' => $offer_id,
//                         'product_custom_part_no' => $product_custom_part_no,
//                         'product_custom_description' => $product_custom_description,
//                         'unit' => $$new_unit_id,
//                         'warranty' => $warranty,
//                         'hsn_id' => $new_hsn_id,
//                         'price' => $price,
//                         'discount' => $discount,
//                         'discount_amt' => $discount_amt,
//                         'unit_discounted_price' => $unit_discounted_price,
//                         'total_amount_without_gst' => $total_amount_without_gst,
//                         'gst_percentage' => $gst_percentage,
//                         'gst_amount' => $gst_amount,
//                         'total_gst_amount' => $total_gst_amount,
//                         'total_amount_with_gst' => $total_amount_with_gst,
//                         // Add other fields as needed
//                     );

//                     // Insert into offer_product_relation
//                     $this->db->insert('offer_product_relation', $insert_array);
//                 }
//                 // Set success response
//                 $response['success'] = true;
//                 $response['redirect_url'] = base_url() . 'update_offer_data/' . $offer_id;
            
//             }
//             else {
//                 // Set error message if either existing or new products array is empty
//                 $error = "No data found for existing or new products.";

//                 $response['success'] = false;
//                 $response['error'] = $error;
//             }

//        }
//        echo json_encode($response);
// }

public function upload_template()
{
    $offer_id = $this->input->post('offer_id');
    $response = array();

    $config['upload_path'] = 'assets/product_csv/';
    $config['allowed_types'] = 'csv';
    $config['max_size'] = 2048; 

    $this->load->library('upload', $config);

    if (!$this->upload->do_upload('template_file')) {
        $error = $this->upload->display_errors();
        $this->session->set_flashdata('error', $error);
        redirect(base_url() . 'update_offer_data/' . $offer_id);
    } else {
        // Retrieve uploaded file data
        $data = $this->upload->data();
        $file_path = 'assets/product_csv/' . $data['file_name'];

        // Read CSV file data
        $csv_data = array_map('str_getcsv', file($file_path));
        
        // Remove header row
        $header = array_shift($csv_data);

        // Arrays to store existing and new products
        $existing_products = array();
        $new_products = array();

        $error_messages_existing = array();
        $error_messages_new = array();

            // Separate existing and new products
            foreach ($csv_data as $row) {
                $product_custom_part_no = trim($row[2]);
                // Check if product exists in product_master table
                $product_query = $this->db->get_where('product_master', array('product_id' => $product_custom_part_no));
                $existing_product = $product_query->row_array();

                if ($existing_product) {
                    // Existing product, add to existing products array
                    if (!empty($row[2]) && !empty($row[5]) && !empty($row[7])) {
                        $existing_products[] = $row;
                    }
                } else {
                    // New product, add to new products array
                    if (!empty($row[1]) && !empty($row[2]) && !empty($row[5]) && !empty($row[7])&&  !empty($row[12]) && !empty($row[14]) && !empty($row[15]) && !empty($row[16]) && !empty($row[17])) {
                        $new_products[] = $row;
                    }
                    
                }

                if ($existing_product) {
                    // Existing product, add to existing products array
                    if (empty($row[2]) || empty($row[5]) || empty($row[7])) {
                        $error_messages_existing[] = "Incomplete data for existing part code:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $product_custom_part_no . "<br>";
                    }
                } else {
                    // New product, add to new products array
                    if (empty($row[1]) || empty($row[2]) || empty($row[5]) || empty($row[7]) ||  empty($row[12]) || empty($row[14]) || empty($row[15]) || empty($row[16]) || empty($row[17])) {
                        $error_messages_new[] = "Incomplete data for new part code: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $product_custom_part_no . "<br>";
                    }
                }
            }

            // Check if any errors exist
            if (!empty($error_messages_existing) || !empty($error_messages_new)) {
                $response['success'] = false;
                $response['error'] = implode("<br>", $error_messages_existing) . "<br>" . implode("<br>", $error_messages_new) . "<br>Please fill all details properly and then upload the CSV file.";

                echo json_encode($response);
                return;
            }

            // Initialize a flag to track if existing products were found
            $existing_products_found = false;

            // Process existing products
            foreach ($existing_products as $row) 
            {
                // Fetch additional details from database and insert into offer_product_relation
                $product_custom_part_no = trim($row[2]);
                $qty = (int)trim($row[3]);
                $discount1 = trim($row[7]);
                $delivery_period = trim($row[12]);

                // Parse discount1 to extract numerical value and calculate discount
                $discount_percentage = 0; // Default discount percentage
                if (!empty($discount1)) {
                    // Check if the discount value contains a percentage sign
                    if (strpos($discount1, '%') !== false) {
                        // Remove the percentage sign and parse the numerical value
                        $discount_percentage = (float) rtrim($discount1, '%');
                    } else {
                        // If no percentage sign is present, consider the value as a direct discount
                        $discount_percentage = (float) $discount1;
                    }
                }
                // Calculate discount based on percentage
                $discount = $discount_percentage;

                $this->db->select('entity_id');
                $this->db->from('product_master');
                $this->db->where('product_id', $product_custom_part_no);
                $product_entity = $this->db->get();
                $product_entity_row = $product_entity->row();

                $product_id = $product_entity_row->entity_id;
                
                // Fetch product details from product_master and product_hsn_master tables
                $this->db->select('product_master.*, product_hsn_master.total_gst_percentage, product_hsn_master.cgst, product_hsn_master.sgst, product_hsn_master.igst');
                $this->db->from('product_master');
                $this->db->join('product_hsn_master', 'product_master.hsn_id = product_hsn_master.entity_id','inner');
                $this->db->where('product_master.entity_id', $product_id); 
                $product_master = $this->db->get();
                $product_master_result = $product_master->row();

                // Fetch product details from product_master and product_make_master tables
                $this->db->select('product_master.*, product_make_master.make_name');
                $this->db->from('product_master');
                $this->db->join('product_make_master', 'product_master.product_make = product_make_master.entity_id','inner');
                $this->db->where('product_master.entity_id', $product_id); 
                $product_make_master = $this->db->get();
                $product_make_result = $product_make_master->row();

                // echo '<pre>'; print_r($product_master_result);die;
                @$gst_percentage = $product_master_result->total_gst_percentage;                     
                @$product_custom_description = $product_master_result->product_name;
                @$hsn_id = $product_master_result->hsn_id;      
                @$igst_percentage = $product_master_result->igst;

                @$product_make =  $product_make_result->product_make;
                // echo '<pre>'; print_r($product_make);die;
            
                //Fetch latest price from product_pricelist_master table
                $this->db->select('price');
                $this->db->from('product_pricelist_master');
                $this->db->where('product_id', $product_id);
                $this->db->order_by('entity_id', 'DESC');
                $this->db->limit(1);
                $product_pricelist_master = $this->db->get();
                $product_pricelist_master_result = $product_pricelist_master->row();
                            
                $price = $product_pricelist_master_result->price+1-1;

                // Calculate total amount without GST
                $total_amount_without_gst = $price * $qty;
                $igst_amount = $total_amount_without_gst * $igst_percentage/100;
                $gst_amount = $total_amount_without_gst * $gst_percentage/100;
                $discount_amt = $total_amount_without_gst *($discount/100);
                $unit_discounted_price = $total_amount_without_gst - $discount_amt;
                $total_gst_amount = $igst_amount;
                $total_amount_with_gst = $total_amount_without_gst + $gst_amount;

                // Check if the product already exists in the offer
                $existing_product_in_offer_query = $this->db->get_where('offer_product_relation', array('product_id' => $product_id, 'offer_id' => $offer_id));
                $existing_product_in_offer_row = $existing_product_in_offer_query->row_array();
                
                // If the product already exists in the offer, add its ID to the list of existing product IDs
                if ($existing_product_in_offer_row) {
                    $existing_products_found = true;
                    continue;
                }

                // Prepare insert array
                $insert_array = array(
                    "product_id" => $product_id,
                    "offer_id" => $offer_id,
                    "product_make" => $product_make,
                    "product_custom_part_no" => $product_custom_part_no,
                    "product_custom_description" => $product_custom_description,
                    "rfq_qty" => $qty, 
                    "delivery_period" => $delivery_period, 
                    "price" => $price,
                    "discount" => $discount,
                    "discount_amt" =>  $discount_amt ,
                    "unit_discounted_price" => $unit_discounted_price,
                    "total_amount_without_gst" => $total_amount_without_gst,
                    "hsn_id" => $hsn_id,
                    "gst_percentage" => $gst_percentage,
                    "gst_amount" => $gst_amount,
                    "igst_discount" => $igst_percentage,
                    "igst_amt" => $igst_amount,
                    "total_amount_with_gst" => $total_amount_with_gst,
                );
                $this->db->insert('offer_product_relation', $insert_array);
            }

            // Check if any existing products were found in the offer
            // if ($existing_products_found) {
            //     // Display error message for existing products found in the offer
            //     $error_message = "The following product(s) already exist for offer ID: $offer_id and will be skipped: <br>" . implode("<br>", array_map(function($product_id) {
            //         return "Product Id: $product_id";
            //     }, array_column($existing_products, 0)));
                                
            //     $response['success'] = false;
            //     $response['error'] = $error_message;
            //     echo json_encode($response);
            //     // return;
            // }

            // if (empty($new_products)) {
            //     $response['success'] = false;
            //     $response['error'] = "No new products found to insert.";
            //     echo json_encode($response);
            //     return;
            // }
            
            // Process new products
            foreach ($new_products as $row) {
                // Extract product details from CSV row
                $product_custom_part_no = trim($row[2]);
                $product_make = trim($row[15]);
                $qty = trim($row[3]);
                $discount1 = trim($row[7]);
                $product_custom_description = trim($row[1]);
                $price = trim($row[5]);
                $hsn_code1 = trim($row[17]);
                $unit = trim($row[14]);
                $lead_time = trim($row[12]);
                $category = trim($row[16]);

            // Generate random HSN code and set GST percentage to 0 if HSN code is missing
                if (empty($hsn_code1)) {
                    $hsn_code = "123456"; 
                    $gst_percentage = 18;
                } else {
									$hsn_code = $hsn_code1;
										$this->db->select('*');
										$this->db->from('product_hsn_master');
										$this->db->where('hsn_code',$hsn_code);
										$hsn_query = $this->db->get();
										$hsn_num_rows = $hsn_query->num_rows();
										if($hsn_num_rows > 0){
											$gst_percentage = $hsn_query->row()->total_gst_percentage;
										}else{
											$gst_percentage = 18;
										}
                }

            // Parse discount1 to extract numerical value and calculate discount
                $discount_percentage = 0; // Default discount percentage
                if (!empty($discount1)) {
                    // Check if the discount value contains a percentage sign
                    if (strpos($discount1, '%') !== false) {
                        // Remove the percentage sign and parse the numerical value
                        $discount_percentage = (float) rtrim($discount1, '%');
                    } else {
                        // If no percentage sign is present, consider the value as a direct discount
                        $discount_percentage = (float) $discount1;
                    }
                }

                // Calculate discount based on percentage
                $discount = $discount_percentage;

                // Check if category exists, insert if not
                $category_id = $this->get_or_create_category_id($category);

                // Check if unit exists, insert if not
                $unit_id = $this->get_or_create_unit_id($unit);

                // Check if HSN code exists, insert if not
                $hsn_id = $this->get_or_create_hsn_id($hsn_code,$gst_percentage);

                // Check if  Product make exists, insert if not
                $product_make = $this->get_or_create_product_make_id($product_make);

                // Insert new product into product_master table
                $new_product_id = $this->insert_new_product($product_custom_part_no, $product_custom_description, $category_id, $unit_id, $hsn_id, $product_make, $lead_time);

                // Insert price details into product_pricelist_master
                $this->insert_price_details($new_product_id, $price);

                // Insert into offer_product_relation
                $response = $this->insert_offer_product_relation($new_product_id, $offer_id, $product_custom_part_no, $product_custom_description, $unit_id, $lead_time, $hsn_id, $product_make, $price,$qty, $discount);
            // Check if insertion was successful
                if ($response['success']) {
                    // Set additional success response
                    $response['redirect_url'] = base_url() . 'update_offer_data/' . $offer_id;
                }
            }

            // Set success response
            $response['success'] = true;
            $response['redirect_url'] = base_url() . 'update_offer_data/' . $offer_id;

            echo json_encode($response);
        }
    }


    // Function to get or create category ID
    public function get_or_create_category_id($category)
    {
        $category_query = $this->db->get_where('product_category_master', array('category_name' => $category));
        $category_row = $category_query->row_array();
        if (!$category_row) {
            $category_data = array(
                'category_name' => $category,
                'category_initial' => 'NA'
            );
            $this->db->insert('product_category_master', $category_data);
            return $this->db->insert_id();
        } else {
            return $category_row['entity_id'];
        }
    }

    // Function to get or create product make ID
    public function get_or_create_product_make_id($product_make)
    {
        $user_id = $_SESSION['user_id'];
        $product_make_query = $this->db->get_where('product_make_master', array('make_name' => $product_make));
        $product_make_row = $product_make_query->row_array();
        if (!$product_make_row) {
            $product_make_data = array(
                'make_name' => $product_make,
                'user_id' => $user_id,
                'status' => 1
            );
            $this->db->insert('product_make_master', $product_make_data);
            return $this->db->insert_id();
        } else {
            return $product_make_row['entity_id'];
        }
    }

 
    // Function to get or create unit ID
    public function get_or_create_unit_id($unit)
    {
        $unit_query = $this->db->get_where('unit_master', array('unit_name' => $unit));
        $unit_row = $unit_query->row_array();
        if (!$unit_row) {
            $unit_data = array(
                'unit_name' => $unit,
            );
            $this->db->insert('unit_master', $unit_data);
            return $this->db->insert_id();
        } else {
            return $unit_row['entity_id'];
        }
    }

    // Function to get or create HSN ID
    public function get_or_create_hsn_id($hsn_code,$gst_percentage)
    {
        
        $this->db->where('hsn_code', $hsn_code);
        $hsn_query = $this->db->get('product_hsn_master');
    
        if ($hsn_query->num_rows() > 0) {
            $hsn_row = $hsn_query->row();
            return $hsn_row->entity_id;
        } else {
            $data = array(
                'hsn_code' => $hsn_code,
                'total_gst_percentage' => $gst_percentage,
                'cgst' => $gst_percentage/2,
                'sgst' => $gst_percentage/2, 
                'igst' => $gst_percentage, 
            );
            $this->db->insert('product_hsn_master', $data);
            return $this->db->insert_id();
        } 
    }

    // Function to insert new product into product_master table
    public function insert_new_product($product_custom_part_no, $product_custom_description, $category_id, $unit_id, $hsn_id,$product_make, $lead_time)
    {
        $product_data = array(
            'product_id' => $product_custom_part_no,
            'product_make' => $product_make,
            'product_name' => $product_custom_description,
            'category_id' => $category_id,
            'unit' => $unit_id,
            'hsn_id' => $hsn_id,
            'typical_lead_time' => $lead_time,
        );
        $this->db->insert('product_master', $product_data);
        return $this->db->insert_id();
    }

    // Function to insert price details into product_pricelist_master
    public function insert_price_details($product_id, $price)
    {
        $price_details = array(
            'price' => $price,
            'year' => date('Y'), // Assuming current year, adjust as needed
            'product_id' => $product_id
        );
        $this->db->insert('product_pricelist_master', $price_details);
    }

    // Function to insert into offer_product_relation
    public function insert_offer_product_relation($new_product_id, $offer_id, $product_custom_part_no, $product_custom_description, $unit_id, $lead_time, $hsn_id, $product_make, $price,$qty, $discount)
    {
        $response = array();
        // Check if the product already exists for the given offer ID
        $existing_product_query = $this->db->get_where('offer_product_relation', array('product_id' => $new_product_id, 'offer_id' => $offer_id));
        $existing_product = $existing_product_query->row_array();
        
        // If the product already exists, return without inserting
        if ($existing_product) {
            // Debugging: Print message indicating that the product already exists
            echo "Product already exists for offer ID: $offer_id and product ID: $new_product_id. Skipping insertion.";
            // return;
        }
        else{
        // Calculate fields for new product
        $total_amount_without_gst = $price * $qty;
        $product_hsn_query = $this->db->get_where('product_hsn_master', array('entity_id' => $hsn_id));
        $product_hsn = $product_hsn_query->row_array();
        $gst_percentage = @$product_hsn['total_gst_percentage'];
        $gst_amount = $total_amount_without_gst * $gst_percentage / 100;
        $discount_amt = $total_amount_without_gst * ($discount / 100);
        $unit_discounted_price = $total_amount_without_gst - $discount_amt;
        $total_gst_amount = $gst_amount;
        $total_amount_with_gst = $total_amount_without_gst + $gst_amount;

        // Prepare insert array for offer_product_relation
        $insert_array = array(
            'product_id' =>  $new_product_id,
            'offer_id' => $offer_id,
            'product_make' => $product_make,
            'product_custom_part_no' => $product_custom_part_no,
            'product_custom_description' => $product_custom_description,
            'typical_lead_time' => $lead_time,
            'hsn_id' => $hsn_id,
            "rfq_qty" => $qty, 
            'price' => $price,
            'discount' => $discount,
            'discount_amt' => $discount_amt,
            'unit_discounted_price' => $unit_discounted_price,
            'total_amount_without_gst' => $total_amount_without_gst,
            'gst_percentage' => $gst_percentage,
            'gst_amount' => $gst_amount,
            'total_amount_with_gst' => $total_amount_with_gst,
            // Add other fields as needed
        );

            // Insert into offer_product_relation
                $this->db->insert('offer_product_relation', $insert_array);

            // Set success response
            $response['success'] = true;
            return $response;
        }
       
        
    }

    public function checkIncompleteFields() {
        // $offer_id = $this->input->post('offer_id');
        $response = array();
    
        $config['upload_path'] = 'assets/product_csv/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = 102400; // Adjust as needed
    
        $this->load->library('upload', $config);
    
        if (!$this->upload->do_upload('template_file')) {
            $error = array('error' => $this->upload->display_errors());
            $response['success'] = false;
            $response['error'] = "Error in file uploading: " . $error['error'];
        } else {
            // Retrieve uploaded file data
            $data = $this->upload->data();
            $file_path = 'assets/product_csv/' . $data['file_name'];
    
            // Read CSV file data
            $csv_data = array_map('str_getcsv', file($file_path));
    
            // Remove header row
            $header = array_shift($csv_data);
    
            $response['success'] = true;
            $response['csv_data'] = $csv_data;
            $response['header'] = $header;
    
            $incomplete_fields = array();
    
            // Check for incomplete data
            foreach ($csv_data as $row) {
                $erp_code = trim($row[2]);
                $incomplete = array();
    
                // Skip checking these indexes: 0, 6, 8, 9, 10, 11, 13, 
                // Hence, these fields are allowed to be empty
                if (in_array($row[0], [0, 6, 8, 9, 10, 11, 13, 17])) {
                    continue;
                } else {
                    if (empty($row[1])) $incomplete[] = 'Description';
                    if (empty($row[2])) $incomplete[] = 'MLFB';
                    if (empty($row[3])) $incomplete[] = 'Quantity';
                    if (empty($row[5])) $incomplete[] = 'Unit Price';
                    if (empty($row[7])) $incomplete[] = 'Discount';
                    if (empty($row[12])) $incomplete[] = 'Lead Time';
                    if (empty($row[14])) $incomplete[] = 'Unit';
                    if (empty($row[15])) $incomplete[] = 'Product Make';
                    if (empty($row[16])) $incomplete[] = 'Category';
                }
    
                if (!empty($incomplete)) {
                    $incomplete_fields[] = array(
                        'erp_code' => $erp_code,
                        'incomplete_fields' => $incomplete
                    );
                }
            }
    
            $response['incomplete_fields'] = $incomplete_fields;
        }

		
    
        echo json_encode($response);
    }
    
    
	

    public function upload_template_from_setoffer()
   {
    $offer_entity_id = $this->input->post('offer_entity_id');
    $response = array();

    $this->db->select('*');
    $this->db->from('offer_register');
    $where = '(offer_register.entity_id = "'.$offer_entity_id.'" )';
    $this->db->where($where);
    $this->db->order_by('offer_register.entity_id', 'DESC');
    $this->db->limit(1);
    $query_data = $this->db->get();
    $query_result = $query_data->row_array();

    $offer_id = $query_result['entity_id'];
    $enquiry_entity_id = $query_result['enquiry_id'];

  
    $config['upload_path'] = 'assets/product_csv/';
    $config['allowed_types'] = 'csv';
    $config['max_size'] = 2048; 

    $this->load->library('upload', $config);

    if (!$this->upload->do_upload('template_file')) {
        $error = $this->upload->display_errors();
        $this->session->set_flashdata('error', $error);
        redirect(base_url() . 'setoffer/' . $enquiry_entity_id);
    } else {
        // Retrieve uploaded file data
        $data = $this->upload->data();
        $file_path = 'assets/product_csv/' . $data['file_name'];

        // Read CSV file data
        $csv_data = array_map('str_getcsv', file($file_path));
        
        // Remove header row
        $header = array_shift($csv_data);

        // Arrays to store existing and new products
        $existing_products = array();
        $new_products = array();

        $error_messages_existing = array();
        $error_messages_new = array();

        // Separate existing and new products
            // Separate existing and new products
            foreach ($csv_data as $row) {
                $product_custom_part_no = trim($row[2]);
                // Check if product exists in product_master table
                $product_query = $this->db->get_where('product_master', array('product_id' => $product_custom_part_no));
                $existing_product = $product_query->row_array();

                if ($existing_product) {
                    // Existing product, add to existing products array
                    if (!empty($row[2]) && !empty($row[4]) && !empty($row[7])) {
                        $existing_products[] = $row;
                    }
                } else {
                    // New product, add to new products array
                    if (!empty($row[1]) && !empty($row[2]) && !empty($row[4]) && !empty($row[5]) && !empty($row[7]) && !empty($row[10]) && !empty($row[11]) && !empty($row[12]) && !empty($row[13])) {
                        $new_products[] = $row;
                    }
                    
                }

                if ($existing_product) {
                    // Existing product, add to existing products array
                    if (empty($row[2]) || empty($row[4]) || empty($row[7])) {
                        $error_messages_existing[] = "Incomplete data for existing part code:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $product_custom_part_no . "<br>";
                    }
                } else {
                    // New product, add to new products array
                    if (empty($row[1]) || empty($row[2]) || empty($row[4]) || empty($row[5]) || empty($row[7]) || empty($row[10]) || empty($row[11]) || empty($row[12]) || empty($row[13]) ) {
                        $error_messages_new[] = "Incomplete data for new part code: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $product_custom_part_no . "<br>";
                    }
                }
            }

            // Check if any errors exist
            if (!empty($error_messages_existing) || !empty($error_messages_new)) {
                $response['success'] = false;
                $response['error'] = implode("<br>", $error_messages_existing) . "<br>" . implode("<br>", $error_messages_new) . "<br>Please fill all details properly and then upload the CSV file.";

                echo json_encode($response);
                return;
            }

            // Initialize a flag to track if existing products were found
            $existing_products_found = false;

            // Process existing products
            foreach ($existing_products as $row) 
            {
                // Fetch additional details from database and insert into offer_product_relation
                $product_custom_part_no = trim($row[2]);
                $qty = trim($row[4]);
                $discount1 = trim($row[7]);

                // Parse discount1 to extract numerical value and calculate discount
                $discount_percentage = 0; // Default discount percentage
                if (!empty($discount1)) {
                    // Check if the discount value contains a percentage sign
                    if (strpos($discount1, '%') !== false) {
                        // Remove the percentage sign and parse the numerical value
                        $discount_percentage = (float) rtrim($discount1, '%');
                    } else {
                        // If no percentage sign is present, consider the value as a direct discount
                        $discount_percentage = (float) $discount1;
                    }
                }
                // Calculate discount based on percentage
                $discount = $discount_percentage;

                $this->db->select('entity_id');
                $this->db->from('product_master');
                $this->db->where('product_id', $product_custom_part_no);
                $product_entity = $this->db->get();
                $product_entity_row = $product_entity->row();

                $product_id = $product_entity_row->entity_id;
                
                // Fetch product details from product_master and product_hsn_master tables
                $this->db->select('product_master.*, product_hsn_master.total_gst_percentage, product_hsn_master.cgst, product_hsn_master.sgst, product_hsn_master.igst');
                $this->db->from('product_master');
                $this->db->join('product_hsn_master', 'product_master.hsn_id = product_hsn_master.entity_id','inner');
                $this->db->where('product_master.entity_id', $product_id); 
                $product_master = $this->db->get();
                $product_master_result = $product_master->row();

                // Fetch product details from product_master and product_make_master tables
                $this->db->select('product_master.*, product_make_master.make_name');
                $this->db->from('product_master');
                $this->db->join('product_make_master', 'product_master.product_make = product_make_master.entity_id','inner');
                $this->db->where('product_master.entity_id', $product_id); 
                $product_make_master = $this->db->get();
                $product_make_result = $product_make_master->row();

                // echo '<pre>'; print_r($product_master_result);die;
                @$gst_percentage = $product_master_result->total_gst_percentage;                     
                @$product_custom_description = $product_master_result->product_name;
                @$hsn_id = $product_master_result->hsn_id;      
                @$igst_percentage = $product_master_result->igst;

                @$product_make =  $product_make_result->product_make;
                // echo '<pre>'; print_r($product_make);die;
            
                //Fetch latest price from product_pricelist_master table
                $this->db->select('price');
                $this->db->from('product_pricelist_master');
                $this->db->where('product_id', $product_id);
                $this->db->order_by('entity_id', 'DESC');
                $this->db->limit(1);
                $product_pricelist_master = $this->db->get();
                $product_pricelist_master_result = $product_pricelist_master->row();
                            
                $price = $product_pricelist_master_result->price;

                // Calculate total amount without GST
                $total_amount_without_gst = $price * $qty;
                $igst_amount = $total_amount_without_gst * $igst_percentage/100;
                $gst_amount = $total_amount_without_gst * $gst_percentage/100;
                $discount_amt = $total_amount_without_gst *($discount/100);
                $unit_discounted_price = $total_amount_without_gst - $discount_amt;
                $total_gst_amount = $igst_amount;
                $total_amount_with_gst = $total_amount_without_gst + $gst_amount;

                // Check if the product already exists in the offer
                $existing_product_in_offer_query = $this->db->get_where('offer_product_relation', array('product_id' => $product_id, 'offer_id' => $offer_id));
                $existing_product_in_offer_row = $existing_product_in_offer_query->row_array();
                
                // If the product already exists in the offer, add its ID to the list of existing product IDs
                if ($existing_product_in_offer_row) {
                    $existing_products_found = true;
                    continue;
                }

                // Prepare insert array
                $insert_array = array(
                    "product_id" => $product_id,
                    "offer_id" => $offer_id,
                    "product_make" => $product_make,
                    "product_custom_part_no" => $product_custom_part_no,
                    "product_custom_description" => $product_custom_description,
                    "rfq_qty" => $qty, 
                    "price" => $price,
                    "discount" => $discount,
                    "discount_amt" =>  $discount_amt ,
                    "unit_discounted_price" => $unit_discounted_price,
                    "total_amount_without_gst" => $total_amount_without_gst,
                    "hsn_id" => $hsn_id,
                    "gst_percentage" => $gst_percentage,
                    "gst_amount" => $gst_amount,
                    "igst_discount" => $igst_percentage,
                    "igst_amt" => $igst_amount,
                    "total_amount_with_gst" => $total_amount_with_gst,
                );
                $this->db->insert('offer_product_relation', $insert_array);
            }

            // Check if any existing products were found in the offer
            // if ($existing_products_found) {
            //     // Display error message for existing products found in the offer
            //     $error_message = "The following product(s) already exist for offer ID: $offer_id and will be skipped: <br>" . implode("<br>", array_map(function($product_id) {
            //         return "Product Id: $product_id";
            //     }, array_column($existing_products, 0)));
                                
            //     $response['success'] = false;
            //     $response['error'] = $error_message;
            //     echo json_encode($response);
            //     // return;
            // }

            // if (empty($new_products)) {
            //     $response['success'] = false;
            //     $response['error'] = "No new products found to insert.";
            //     echo json_encode($response);
            //     return;
            // }
            
            // Process new products
            foreach ($new_products as $row) {
                // Extract product details from CSV row
                $product_custom_part_no = trim($row[2]);
                $product_make = trim($row[12]);
                $qty = trim($row[4]);
                $discount1 = trim($row[7]);
                $product_custom_description = trim($row[1]);
                $price = trim($row[5]);
                $hsn_code1 = trim($row[14]);
                $unit = trim($row[11]);
                $lead_time = trim($row[10]);
                $category = trim($row[13]);

            // Generate random HSN code and set GST percentage to 0 if HSN code is missing
                if (empty($hsn_code1)) {
                    $hsn_code = "123456"; 
                    $gst_percentage = 0;
                } else {
                    $hsn_code = $hsn_code1;
                    $product_hsn_query = $this->db->get_where('product_hsn_master', array('hsn_code' => $hsn_code));
                    $product_hsn = $product_hsn_query->row_array();
                    $gst_percentage = @$product_hsn['total_gst_percentage'];
                }

            // Parse discount1 to extract numerical value and calculate discount
                $discount_percentage = 0; // Default discount percentage
                if (!empty($discount1)) {
                    // Check if the discount value contains a percentage sign
                    if (strpos($discount1, '%') !== false) {
                        // Remove the percentage sign and parse the numerical value
                        $discount_percentage = (float) rtrim($discount1, '%');
                    } else {
                        // If no percentage sign is present, consider the value as a direct discount
                        $discount_percentage = (float) $discount1;
                    }
                }

                // Calculate discount based on percentage
                $discount = $discount_percentage;

                // Check if category exists, insert if not
                $category_id = $this->get_or_create_category_id($category);

                // Check if unit exists, insert if not
                $unit_id = $this->get_or_create_unit_id($unit);

                // Check if HSN code exists, insert if not
                $hsn_id = $this->get_or_create_hsn_id($hsn_code,$gst_percentage);

                // Check if  Product make exists, insert if not
                $product_make = $this->get_or_create_product_make_id($product_make);

                // Insert new product into product_master table
                $new_product_id = $this->insert_new_product($product_custom_part_no, $product_custom_description, $category_id, $unit_id, $hsn_id, $product_make, $lead_time);

                // Insert price details into product_pricelist_master
                $this->insert_price_details($new_product_id, $price);

                // Insert into offer_product_relation
                $response = $this->insert_offer_product_relation($new_product_id, $offer_id, $product_custom_part_no, $product_custom_description, $unit_id, $lead_time, $hsn_id, $product_make, $price,$qty, $discount);
            // Check if insertion was successful
                if ($response['success']) {
                    // Set additional success response
                    $response['redirect_url'] = base_url() . 'update_offer_data/' . $offer_id;
                }
            }

            // Set success response
            $response['success'] = true;
            $response['redirect_url'] = base_url() . 'update_offer_data/' . $offer_id;

            echo json_encode($response);
        }
    }



    public function update_offer_from_enquiry()
    {
        $offer_entity_id = $this->input->post('offer_entity_id');

        $offer_customer_id = $this->input->post('customer_name');
        $contact_id = $this->input->post('contact_id');

        $offer_company_name = $this->input->post('offer_company_name');

        $product_checkbox = $this->input->post('product_checkbox');
        $enquiry_descrption = $this->input->post('enquiry_descrption');
        $employee_id = $this->input->post('employee_id');
        $offer_for = $this->input->post('offer_for');
        $offer_date = $this->input->post('offer_date');
        $offer_terms_condition = $this->input->post('offer_terms_condition');
        $offer_source = $this->input->post('offer_source');
        $price_condition = $this->input->post('price_condition');
        $salutation = $this->input->post('salutation');
       	$tax = $this->input->post('tax');
        $your_reference = $this->input->post('your_reference');
        $validity = $this->input->post('validity');

        // $this->db->select('*');
        // $this->db->from('offer_register');
        // $where = '(offer_register.entity_id = "'.$offer_entity_id.'" )';
        // $this->db->where($where);
        // $this->db->order_by('offer_register.entity_id', 'DESC');
        // $this->db->limit(1);
        // $query_data = $this->db->get();
        // $query_result = $query_data->row_array();

        // $offer_entity_id = $query_result['entity_id'];

        $update_offer_array = array('customer_id' => $offer_customer_id , 'contact_person_id' => $contact_id ,
			'offer_description' => $enquiry_descrption ,
			'offer_engg_name' => $employee_id ,
			'offer_for' => $offer_for ,
			'offer_date' => $offer_date ,
			'terms_conditions' => $offer_terms_condition ,
			'offer_source' => $offer_source ,
			'price_condition' => $price_condition,
			'salutation' => $salutation,
			'tax' => $tax,
			'your_reference' => $your_reference ,
			'validity' => $validity ,
			'offer_company_name' => $offer_company_name);

        $where = '(entity_id ="'.$offer_entity_id.'")';
        $this->db->where($where);
        $this->db->update('offer_register',$update_offer_array);

        foreach ($product_checkbox as $key => $value) {
            $product_id = $value['value'];

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
            $gst_percentage = $product_master_result->total_gst_percentage;
            $product_custom_part_no = $product_master_result->product_id;
            $product_custom_description = $product_master_result->product_name;

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
            $product_make = $product_master_result->product_make;
            $product_warrenty = $product_master_result->warrenty;
            //$product_custom_description = $product_master_result->product_long_description;
            $discount = 0;
            $discount_amt = 0;
            $unit_discounted_price = $total_amount_without_gst - $discount_amt;

            //$product_make = $product_master_result->product_make;
            $internal_remark = $product_master_result->internal_remark;

            $this->db->select('*');
            $this->db->from('customer_master');
            $where = '(customer_master.entity_id = "'.$offer_customer_id.'")';
            $this->db->where($where);
            $customer_address_master = $this->db->get();
            $customer_address_master_result = $customer_address_master->row();

            /*$state_code = $customer_address_master_result->state_code;

            if($state_code == 27)
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
            }*/

            $gst_amount = $total_amount_without_gst * $gst_percentage/100;
            $total_amount = $total_amount_without_gst + $gst_amount;

            $this->db->select('offer_id');
            $this->db->from('offer_product_relation');
            $where_or = '(product_id = "'.$product_id.'" AND offer_id = "'.$offer_entity_id.'")';
            $this->db->where($where_or);
            $offer_product_exit= $this->db->get();
            $offer_product_exit_data_count =  $offer_product_exit->num_rows();

            if ($offer_product_exit_data_count === 0) 
            {
                $offer_product_relation_save = "INSERT INTO offer_product_relation (offer_id , product_id , product_make , product_custom_description , product_custom_part_no , rfq_qty , price , total_amount_without_gst , gst_percentage , gst_amount , total_amount_with_gst , discount , discount_amt , unit_discounted_price , product_warranty , internal_remark) VALUES ('".$offer_entity_id."' , '".$product_id."' , '".$product_make."' ,'".$product_custom_description."' , '".$product_custom_part_no."' , '".$rfq_qty."' , '".$price."' , '".$total_amount_without_gst."' ,  '".$gst_percentage."' , '".$gst_amount."' , '".$total_amount."' , '".$discount."' , '".$discount_amt."' , '".$unit_discounted_price."' , '".$product_warrenty."' , '".$internal_remark."')";
                $save_offer_product_relation = $this->db->query($offer_product_relation_save);
                //set session 
                $this->session->set_userdata('offer_product', 'Product Saved....!');
            }
            else{
                $this->session->set_userdata('offer_product', $session_product_var.' Product already exist....!');
            }
        }

        $data = $offer_entity_id;
        echo json_encode($data);
    }




    public function update_offer_from_contact()
    {
        $offer_entity_id = $this->input->post('offer_entity_id');

        $offer_customer_id = $this->input->post('customer_name');
        $contact_id = $this->input->post('contact_id');

        $offer_company_name = $this->input->post('offer_company_name');

        $product_checkbox = $this->input->post('product_checkbox');
        $enquiry_descrption = $this->input->post('enquiry_descrption');
        $employee_id = $this->input->post('employee_id');
        $offer_type = $this->input->post('offer_type');
        $offer_date = $this->input->post('offer_date');
        $offer_freight = $this->input->post('offer_freight');
        $freight_charges = $this->input->post('freight_charges');
        $dispatch_address = $this->input->post('dispatch_address');
        $delivery_instruction = $this->input->post('delivery_instruction');
        $packing_forwarding_charges = $this->input->post('packing_forwarding_charges');
        $special_instruction = $this->input->post('special_instruction');
        $offer_insurance = $this->input->post('offer_insurance');
        $insurance_charges = $this->input->post('insurance_charges');
        $price_condition = $this->input->post('price_condition');
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
        $your_reference = $this->input->post('your_reference');
        $validity = $this->input->post('validity');

        $this->db->select('*');
        $this->db->from('offer_register');
        $where = '(offer_register.enquiry_id = "'.$offer_entity_id.'" )';
        $this->db->where($where);
        $this->db->order_by('offer_register.entity_id', 'DESC');
        $this->db->limit(1);
        $query_data = $this->db->get();
        $query_result = $query_data->row_array();

        // $offer_entity_id = $query_result['entity_id'];

        $update_offer_array = array('customer_id' => $offer_customer_id , 'contact_person_id' => $contact_id ,'offer_description' => $enquiry_descrption , 'offer_engg_name' => $employee_id , 'offer_type' => $offer_type , 'offer_date' => $offer_date , 'Transportation' => $offer_freight , 'transportation_price' => $freight_charges , 'dispatch_address' => $dispatch_address , 'delivery_instruction' => $delivery_instruction , 'packing_forwarding' => $packing_forwarding , 'packing_forwarding_price' => $packing_forwarding_charges , 'payment_term' => $payment_term , 'special_packing' => $special_instruction , 'insurance' => $offer_insurance , 'insurance_price' => $insurance_charges, 'price_condition' => $price_condition, 'salutation' => $salutation, 'price_basis' => $price_basis, 'transport_insurance' => $transport_insurance, 'tax' => $tax, 'delivery_schedule' => $delivery_schedule, 'mode_of_payment' => $mode_of_payment, 'mode_of_transport' => $mode_of_transport, 'guarantee_warrenty' => $guarantee_warrenty, 'your_reference' => $your_reference , 'validity' => $validity , 'offer_company_name' => $offer_company_name);

        $where = '(entity_id ="'.$offer_entity_id.'")';
        $this->db->where($where);
        $this->db->update('offer_register',$update_offer_array);

        foreach ($product_checkbox as $key => $value) {
            $product_id = $value['value'];

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
            $gst_percentage = $product_master_result->total_gst_percentage;
            $product_custom_description = $product_master_result->product_name;

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
            $product_make = $product_master_result->product_make;
            $product_warrenty = $product_master_result->warrenty;
            //$product_custom_description = $product_master_result->product_long_description;
            $discount = 0;
            $discount_amt = 0;
            $unit_discounted_price = $total_amount_without_gst - $discount_amt;

            //$product_make = $product_master_result->product_make;
            $internal_remark = $product_master_result->internal_remark;

            $this->db->select('*');
            $this->db->from('customer_master');
            $where = '(customer_master.entity_id = "'.$offer_customer_id.'")';
            $this->db->where($where);
            $customer_address_master = $this->db->get();
            $customer_address_master_result = $customer_address_master->row();

            /*$state_code = $customer_address_master_result->state_code;

            if($state_code == 27)
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
            }*/

            $gst_amount = $total_amount_without_gst * $gst_percentage/100;
            $total_amount = $total_amount_without_gst + $gst_amount;

            $this->db->select('offer_id');
            $this->db->from('offer_product_relation');
            $where_or = '(product_id = "'.$product_id.'" AND offer_id = "'.$offer_entity_id.'")';
            $this->db->where($where_or);
            $offer_product_exit= $this->db->get();
            $offer_product_exit_data_count =  $offer_product_exit->num_rows();

            if ($offer_product_exit_data_count === 0) 
            {
                $offer_product_relation_save = "INSERT INTO offer_product_relation (offer_id , product_id , product_make , product_custom_description , rfq_qty , price , total_amount_without_gst , gst_percentage , gst_amount , total_amount_with_gst , discount , discount_amt , unit_discounted_price , product_warranty , internal_remark) VALUES ('".$offer_entity_id."' , '".$product_id."' , '".$product_make."' , '".$product_custom_description."' , '".$rfq_qty."' , '".$price."' , '".$total_amount_without_gst."' ,  '".$gst_percentage."' , '".$gst_amount."' , '".$total_amount."' , '".$discount."' , '".$discount_amt."' , '".$unit_discounted_price."' , '".$product_warrenty."' , '".$internal_remark."')";
                $save_offer_product_relation = $this->db->query($offer_product_relation_save);
                //set session 
                $this->session->set_userdata('offer_product', 'Product Saved....!');
            }
            else{
                $this->session->set_userdata('offer_product', $session_product_var.' Product already exist....!');
            }
        }

        $data = $offer_entity_id;
        echo json_encode($data);
    }



    public function update_offer_thru_ajax()
    //backtrace : vw_offer_register_update
    {
        $entity_id = $this->input->post('entity_id');

        $offer_customer_id = $this->input->post('customer_name');
        $contact_id = $this->input->post('contact_id');

        $offer_company_name = $this->input->post('offer_company_name');

        $product_checkbox = $this->input->post('product_checkbox');
        $enquiry_descrption = $this->input->post('enquiry_descrption');
        $employee_id = $this->input->post('employee_id');
        $offer_for = $this->input->post('offer_for');
        $offer_date = $this->input->post('offer_date');
        $offer_terms_condition = $this->input->post('offer_terms_condition');
        $offer_source = $this->input->post('offer_source');
        $price_condition = $this->input->post('price_condition');
        $salutation = $this->input->post('salutation');
       	$tax = $this->input->post('tax');
       	$your_reference = $this->input->post('your_reference');
        $validity = $this->input->post('validity');
        $offer_note = $this->input->post('offer_note');

        
        $update_offer_array = array(
          'customer_id' => $offer_customer_id , 
          'contact_person_id' => $contact_id ,
          'offer_description' => $enquiry_descrption , 
          'offer_engg_name' => $employee_id , 
          'offer_for' => $offer_for , 
          'offer_date' => $offer_date , 
          'offer_terms_condition' => $offer_terms_condition , 
          'offer_source' => $offer_source , 
          'price_condition' => $price_condition, 
          'salutation' => $salutation, 
          'tax' => $tax, 
          'your_reference' => $your_reference , 
          'validity' => $validity , 
          'note' => $offer_note , 
          'offer_company_name' => $offer_company_name);

        $where = '(entity_id ="'.$entity_id.'")';
        $this->db->where($where);
        $this->db->update('offer_register',$update_offer_array);

        foreach ($product_checkbox as $key => $value) {
            $product_id = $value['value'];

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
            $gst_percentage = $product_master_result->total_gst_percentage;
            $product_custom_part_no = $product_master_result->product_id;
            $product_custom_description = $product_master_result->product_name;

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
            $product_make = $product_master_result->product_make;
            $product_warrenty = $product_master_result->warrenty;
            //$product_custom_description = $product_master_result->product_long_description;
            $discount = 0;
            $discount_amt = 0;
            $unit_discounted_price = $total_amount_without_gst - $discount_amt;
            
            //$product_make = $product_master_result->product_make;
            $internal_remark = $product_master_result->internal_remark;
            
            $this->db->select('*');
            $this->db->from('customer_master');
            $where = '(customer_master.entity_id = "'.$offer_customer_id.'")';
            $this->db->where($where);
            $customer_address_master = $this->db->get();
            $customer_address_master_result = $customer_address_master->row();
            
            /*$state_code = $customer_address_master_result->state_code;

            if($state_code == 27)
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
            }*/

            $gst_amount = $total_amount_without_gst * $gst_percentage/100;
            $total_amount = $total_amount_without_gst + $gst_amount;
            
            $this->db->select('offer_id');
            $this->db->from('offer_product_relation');
            $where_or = '(product_id = "'.$product_id.'" AND offer_id = "'.$entity_id.'")';
            $this->db->where($where_or);
            $offer_product_exit= $this->db->get();
            $offer_product_exit_data_count =  $offer_product_exit->num_rows();
            
            //bookmark_1
            if ($offer_product_exit_data_count === 0) 
            {
                $offer_product_relation_save = "INSERT INTO offer_product_relation (offer_id , product_id , product_make , product_custom_description , product_custom_part_no , rfq_qty , price , total_amount_without_gst , gst_percentage , gst_amount , total_amount_with_gst , discount , discount_amt , unit_discounted_price , product_warranty , internal_remark) VALUES ('".$entity_id."' , '".$product_id."' , '".$product_make."' , '".$product_custom_description."' , '".$product_custom_part_no."' , '".$rfq_qty."' , '".$price."' , '".$total_amount_without_gst."' ,  '".$gst_percentage."' , '".$gst_amount."' , '".$total_amount."' , '".$discount."' , '".$discount_amt."' , '".$unit_discounted_price."' , '".$product_warrenty."' , '".$internal_remark."')";
                $save_offer_product_relation = $this->db->query($offer_product_relation_save);
                //set session 
                $this->session->set_userdata('offer_product', 'Product Saved....!');
            }
            else{
                $this->session->set_userdata('offer_product', $session_product_var.' Product already exist....!');
            }
        }

        $data = $entity_id;
        echo json_encode($data);
    }


    public function update_product_line()
    {
        $entity_id = $this->input->post('offer_relation_entity_id');
        $product_description  = $this->input->post('product_description');
        $product_delivery_period  = $this->input->post('product_delivery_period');
        $product_current_stock  = $this->input->post('product_current_stock');
        $product_custom_part_no  = $this->input->post('product_custom_part_no');
        $product_make  = $this->input->post('product_make');
        $product_price  = $this->input->post('product_price');
        $product_qty  = $this->input->post('product_qty');
        $product_basic_value  = $this->input->post('product_basic_value');
        $discount_percentage  = $this->input->post('discount_percentage');
        $discount_type  = $this->input->post('discount_type');
        $discount_amount  = $this->input->post('discount_amount');
        $unit_discounted_rate  = $this->input->post('unit_discounted_rate');
        $total_amount_without_gst  = $this->input->post('total_amount_without_gst');
        $hsn_id  = $this->input->post('hsn_id');
        $gst_percentage  = $this->input->post('gst_percentage');
        $gst_amount  = $this->input->post('gst_amount');
        $total_amount_with_gst  = $this->input->post('total_amount_with_gst');
        $product_remark  = $this->input->post('product_remark');
        $internal_remark  = $this->input->post('internal_remark');


        $update_array = array(
        'entity_id' => $entity_id,
        'product_custom_description' => $product_description,
        'delivery_period' => $product_delivery_period,
        'current_stock' => $product_current_stock,
        'product_custom_part_no' => $product_custom_part_no,
        'product_make' => $product_make,
        'price'  => $product_price,
        'rfq_qty'  => $product_qty,
        'discount'  => $discount_percentage,
        'discount_type'  => $discount_type,
        'discount_amt'  => $discount_amount,
        'unit_discounted_price'  => $unit_discounted_rate,
        'total_amount_without_gst'  => $total_amount_without_gst,
        'hsn_id'  => $hsn_id,
        'gst_percentage'  => $gst_percentage,
        'gst_amount'  => $gst_amount,
        'total_amount_with_gst'  => $total_amount_with_gst,
        'remark'  => $product_remark,
        'internal_remark'  => $internal_remark
        );
        
        $data = $this->offer_register_model->update_product_line_model($update_array);

        echo json_encode($data);
    }
    
    public function update_product_description()
    {
        $entity_id = $this->input->post('offer_relation_entity_id');
        $product_desc = $this->input->post('product_desc');
        $gst_percentage = $this->input->post('gst_percentage');
        $gst_amount = $this->input->post('gst_amount');

        $update_array = array('entity_id' => $entity_id,'product_custom_description' => $product_desc, 'gst_percentage' => $gst_percentage, 'gst_amount' => $gst_amount);
        $data = $this->offer_register_model->update_offer_product_relation($update_array);

        echo json_encode($data);
    }

    public function update_product_make()
    {
        $entity_id = $this->input->post('offer_relation_entity_id');
        $product_make = $this->input->post('product_make');

        $update_array = array('entity_id' => $entity_id,'product_make' => $product_make);
        $data = $this->offer_register_model->update_offer_product_relation($update_array);

        echo json_encode($data);
    }

    public function update_product_delivery_period()
    {
        $entity_id = $this->input->post('offer_relation_entity_id');
        $delivery_period = $this->input->post('delivery_period');

        $update_array = array('entity_id' => $entity_id,'delivery_period' => $delivery_period);
        $data = $this->offer_register_model->update_offer_product_relation($update_array);

        echo json_encode($data);
    }

    public function update_product_warranty()
    {
        $entity_id = $this->input->post('offer_relation_entity_id');
        $warranty = $this->input->post('warranty');

        $update_array = array('entity_id' => $entity_id,'product_warranty' => $warranty);
        $data = $this->offer_register_model->update_offer_product_relation($update_array);

        echo json_encode($data);
    }

    public function update_product_price()
    {
        $entity_id = $this->input->post('offer_relation_entity_id');
        $price = $this->input->post('price');

        $this->db->select('*');
        $this->db->from('offer_product_relation');
        $where = '(offer_product_relation.entity_id = "'.$entity_id.'")';
        $this->db->where($where);
        $offer_product_relation = $this->db->get();
        $offer_product_relation_result = $offer_product_relation->row();

        $product_qty = $offer_product_relation_result->rfq_qty;
        $product_basic_value = $product_qty * $price;

        $product_discount = $offer_product_relation_result->discount;

        $product_discounted_amount = $product_basic_value * $product_discount/100;

        $total_without_gst = $product_basic_value - $product_discounted_amount;

        $unit_discounted_price = $total_without_gst/$product_qty;

        $cgst_percentage = $offer_product_relation_result->cgst_discount;
        $sgst_percentage = $offer_product_relation_result->sgst_discount;
        $igst_percentage = $offer_product_relation_result->igst_discount;

        $cgst_amount = $total_without_gst * $cgst_percentage/100;
        $sgst_amount = $total_without_gst * $sgst_percentage/100;
        $igst_amount = $total_without_gst * $igst_percentage/100;

        $total_amount = $total_without_gst + $cgst_amount + $sgst_amount + $igst_amount;

        $update_array = array('entity_id' => $entity_id , 'price' => $price , 'discount_amt' => $product_discounted_amount , 'unit_discounted_price' => $unit_discounted_price , 'total_amount_without_gst' => $total_without_gst , 'cgst_amt' => $cgst_amount , 'sgst_amt' => $sgst_amount , 'igst_amt' => $igst_amount , 'total_amount_with_gst' => $total_amount);
        $data = $this->offer_register_model->update_offer_product_relation($update_array);

        echo json_encode($data);
    }

    public function update_product_qty()
    {
        $entity_id = $this->input->post('offer_relation_entity_id');
        $product_qty = $this->input->post('product_qty');

        $this->db->select('*');
        $this->db->from('offer_product_relation');
        $where = '(offer_product_relation.entity_id = "'.$entity_id.'")';
        $this->db->where($where);
        $offer_product_relation = $this->db->get();
        $offer_product_relation_result = $offer_product_relation->row();

        $product_price = $offer_product_relation_result->price;
        $product_basic_value = $product_qty * $product_price;

        $product_discount = $offer_product_relation_result->discount;

        $product_discounted_amount = $product_basic_value * $product_discount/100;

        $total_without_gst = $product_basic_value - $product_discounted_amount;

        $unit_discounted_price = $total_without_gst/$product_qty;

        $cgst_percentage = $offer_product_relation_result->cgst_discount;
        $sgst_percentage = $offer_product_relation_result->sgst_discount;
        $igst_percentage = $offer_product_relation_result->igst_discount;

        $cgst_amount = $total_without_gst * $cgst_percentage/100;
        $sgst_amount = $total_without_gst * $sgst_percentage/100;
        $igst_amount = $total_without_gst * $igst_percentage/100;

        $total_amount = $total_without_gst + $cgst_amount + $sgst_amount + $igst_amount;

        $update_array = array('entity_id' => $entity_id , 'rfq_qty' => $product_qty , 'discount_amt' => $product_discounted_amount , 'unit_discounted_price' => $unit_discounted_price , 'total_amount_without_gst' => $total_without_gst , 'cgst_amt' => $cgst_amount , 'sgst_amt' => $sgst_amount , 'igst_amt' => $igst_amount , 'total_amount_with_gst' => $total_amount);
        $data = $this->offer_register_model->update_offer_product_relation($update_array);

        echo json_encode($data);
    }

    public function update_product_hsn_id()
    {
        $entity_id = $this->input->post('offer_relation_entity_id');
        $hsn_id = $this->input->post('hsn_id');

        $this->db->select('*');
        $this->db->from('product_hsn_master');
        $where = '(product_hsn_master.entity_id = "'.$hsn_id.'")';
        $this->db->where($where);
        $product_hsn_master = $this->db->get();
        $product_hsn_master_result = $product_hsn_master->row();

        $this->db->select('*');
        $this->db->from('offer_product_relation');
        $where = '(offer_product_relation.entity_id = "'.$entity_id.'")';
        $this->db->where($where);
        $offer_product_relation = $this->db->get();
        $offer_product_relation_result = $offer_product_relation->row();

        $product_id = $offer_product_relation_result->product_id;

        $product_array = array('hsn_id' => $hsn_id);
        $where = '(entity_id ="'.$product_id.'")';
        $this->db->where($where);
        $this->db->update('product_master',$product_array);

        $product_price = $offer_product_relation_result->price;
        $product_qty = $offer_product_relation_result->rfq_qty;

        $igst_discount_check = $offer_product_relation_result->igst_discount;

        $product_basic_value = $product_qty * $product_price;

        $product_discount = $offer_product_relation_result->discount;

        $product_discounted_amount = $product_basic_value * $product_discount/100;

        $total_without_gst = $product_basic_value - $product_discounted_amount;

        $unit_discounted_price = $total_without_gst/$product_qty;

        if(empty($igst_discount_check) || $igst_discount_check == 0)
        {

            $cgst_percentage = $product_hsn_master_result->cgst;
            $sgst_percentage = $product_hsn_master_result->sgst;
            $igst_percentage = NULL;

            $cgst_amount = $total_without_gst * $cgst_percentage/100;
            $sgst_amount = $total_without_gst * $sgst_percentage/100;
            $igst_amount = NULL;
        }else{

            $cgst_percentage = NULL;
            $sgst_percentage = NULL;
            $igst_percentage = $product_hsn_master_result->igst;
            $cgst_amount = NULL;
            $sgst_amount = NULL;
            $igst_amount = $total_without_gst * $igst_percentage/100;
        }

        $total_amount = $total_without_gst + $cgst_amount + $sgst_amount + $igst_amount;

        $update_array = array('entity_id' => $entity_id , 'discount_amt' => $product_discounted_amount , 'unit_discounted_price' => $unit_discounted_price , 'total_amount_without_gst' => $total_without_gst , 'cgst_discount' => $cgst_percentage , 'sgst_discount' => $sgst_percentage , 'igst_discount' => $igst_percentage , 'cgst_amt' => $cgst_amount , 'sgst_amt' => $sgst_amount , 'igst_amt' => $igst_amount , 'total_amount_with_gst' => $total_amount);
        $data = $this->offer_register_model->update_offer_product_relation($update_array);

        echo json_encode($data);
    }

    public function update_product_discount_percentage()
    {
        $entity_id = $this->input->post('offer_relation_entity_id');
        $discount_percentage = $this->input->post('discount_percentage');

        $this->db->select('*');
        $this->db->from('offer_product_relation');
        $where = '(offer_product_relation.entity_id = "'.$entity_id.'")';
        $this->db->where($where);
        $offer_product_relation = $this->db->get();
        $offer_product_relation_result = $offer_product_relation->row();

        $product_price = $offer_product_relation_result->price;
        $product_qty = $offer_product_relation_result->rfq_qty;

        $product_basic_value = $product_qty * $product_price;

        $product_discounted_amount = $product_basic_value * $discount_percentage/100;

        $total_without_gst = $product_basic_value - $product_discounted_amount;

        $unit_discounted_price = $total_without_gst/$product_qty;

        $cgst_percentage = $offer_product_relation_result->cgst_discount;
        $sgst_percentage = $offer_product_relation_result->sgst_discount;
        $igst_percentage = $offer_product_relation_result->igst_discount;

        $cgst_amount = $total_without_gst * $cgst_percentage/100;
        $sgst_amount = $total_without_gst * $sgst_percentage/100;
        $igst_amount = $total_without_gst * $igst_percentage/100;

        $total_amount = $total_without_gst + $cgst_amount + $sgst_amount + $igst_amount;

        $update_array = array('entity_id' => $entity_id , 'discount' => $discount_percentage , 'discount_amt' => $product_discounted_amount , 'unit_discounted_price' => $unit_discounted_price , 'total_amount_without_gst' => $total_without_gst , 'cgst_amt' => $cgst_amount , 'sgst_amt' => $sgst_amount , 'igst_amt' => $igst_amount , 'total_amount_with_gst' => $total_amount);
        $data = $this->offer_register_model->update_offer_product_relation($update_array);

        echo json_encode($data);
    }

    public function update_product_discount_amount()
    {
        $entity_id = $this->input->post('offer_relation_entity_id');
        $product_discounted_amount = $this->input->post('discount_amount');

        $this->db->select('*');
        $this->db->from('offer_product_relation');
        $where = '(offer_product_relation.entity_id = "'.$entity_id.'")';
        $this->db->where($where);
        $offer_product_relation = $this->db->get();
        $offer_product_relation_result = $offer_product_relation->row();

        $product_price = $offer_product_relation_result->price;
        $product_qty = $offer_product_relation_result->rfq_qty;

        $product_basic_value = $product_qty * $product_price;

        $total_without_gst = $product_basic_value - $product_discounted_amount;

        $unit_discounted_price = $total_without_gst/$product_qty;

        $cgst_percentage = $offer_product_relation_result->cgst_discount;
        $sgst_percentage = $offer_product_relation_result->sgst_discount;
        $igst_percentage = $offer_product_relation_result->igst_discount;

        $cgst_amount = $total_without_gst * $cgst_percentage/100;
        $sgst_amount = $total_without_gst * $sgst_percentage/100;
        $igst_amount = $total_without_gst * $igst_percentage/100;

        $total_amount = $total_without_gst + $cgst_amount + $sgst_amount + $igst_amount;

        $update_array = array('entity_id' => $entity_id , 'discount_amt' => $product_discounted_amount , 'unit_discounted_price' => $unit_discounted_price , 'total_amount_without_gst' => $total_without_gst , 'cgst_amt' => $cgst_amount , 'sgst_amt' => $sgst_amount , 'igst_amt' => $igst_amount , 'total_amount_with_gst' => $total_amount);
        $data = $this->offer_register_model->update_offer_product_relation($update_array);

        echo json_encode($data);
    }

    public function update_product_remark()
    {
        $entity_id = $this->input->post('offer_relation_entity_id');
        $product_remark = $this->input->post('product_remark');

        $update_array = array('entity_id' => $entity_id,'remark' => $product_remark);
        $data = $this->offer_register_model->update_offer_product_relation($update_array);

        echo json_encode($data);
    }

    public function update_product_internalremark()
    {
        $entity_id = $this->input->post('offer_relation_entity_id');
        $internal_remark = $this->input->post('internal_remark');

        $update_array = array('entity_id' => $entity_id,'internal_remark' => $internal_remark);
        $data = $this->offer_register_model->update_offer_product_relation($update_array);

        echo json_encode($data);
    }

    public function delete_offer_product()
    {
        $entity_id = $this->input->post('id');
        $result = $this->offer_register_model->delete_offer_product($entity_id);
        echo json_encode($result);
    }

    public function save_offer()
    {
        /*if(!empty($_FILES['offer_attachment']))
        {
            $ext = pathinfo($_FILES['offer_attachment']['name'],PATHINFO_EXTENSION);
            $offer_attachment_upload = substr(str_replace(" ", "_", $_FILES['offer_attachment']['name']), 0);
            move_uploaded_file($_FILES["offer_attachment"]["tmp_name"], 'assets/offer_attachment/'.$offer_attachment_upload);
            $offer_attachment_img = $_FILES['offer_attachment']['name'];  
        }else{
            $offer_attachment_img = NULL;
        }*/

        if(!empty($_FILES['offer_attachment']))
        {
            $offer_attachment_img = "";
            foreach ($_FILES as $key => $value) {
                
                $file_name = $value['name'];
                $file_source_path = $value['tmp_name'];
                $file_upload_combine_array = array_combine($file_name, $file_source_path);
                //print_r($file_upload_combine_array);
                
                foreach ($file_upload_combine_array as $image_name=> $image_source_path) {
                    // echo $k. ' '. $a ;

                    $ext = pathinfo($image_name,PATHINFO_EXTENSION);

                    $offer_attachment_upload = substr(str_replace(" ", "_", $image_name), 0);
                    move_uploaded_file($image_source_path, 'assets/offer_attachment/'.$offer_attachment_upload);

                    $offer_attachment_img .= $offer_attachment_upload.',';
                }  
            }
        }else{
            $offer_attachment_img = NULL;
        }

        $user_id = $_SESSION['user_id'];
        $user_name = $this->session->userdata('full_name');

        $customer_id = $this->input->post('customer_name');
        $contact_id = $this->input->post('contact_id');

        $offer_entity_id = $this->input->post('offer_entity_id');
        $enquiry_descrption = $this->input->post('enquiry_descrption');
        $employee_id = $this->input->post('employee_id');
        $offer_for = $this->input->post('offer_for');
        $offer_date = $this->input->post('offer_date');
        $offer_terms_condition = $this->input->post('offer_terms_condition');
        $offer_source = $this->input->post('offer_source');
       	$offer_note = $this->input->post('offer_note');

        $salutation = $this->input->post('salutation');
       	$tax = $this->input->post('tax');
        $price_condition = $this->input->post('price_condition');
        $your_reference = $this->input->post('your_reference');
        $offer_close_date = $this->input->post('offer_close_date');
        $offer_company_name = $this->input->post('offer_company_name');

        $this->db->select('*');
        $this->db->from('offer_register');
        $where = '(offer_register.entity_id = "'.$offer_entity_id.'" )';
        $this->db->where($where);
        $this->db->order_by('offer_register.entity_id', 'DESC');
        $this->db->limit(1);
        $query_data = $this->db->get();
        $query_result = $query_data->row_array();

		
        $quotation_no = $query_result['offer_no'];
        $enquiry_entity_id = $query_result['enquiry_id'];

        $offer_status = 3;

        $update_offer_array = array(
			'customer_id' => $customer_id , 
			'contact_person_id' => $contact_id , 
			'offer_description' => $enquiry_descrption , 
			'offer_engg_name' => $employee_id , 
			'offer_for' => $offer_for , 
			'offer_date' => $offer_date , 
			'terms_conditions' => $offer_terms_condition , 
			'offer_source' => $offer_source , 
			'note' => $offer_note , 
			'attachment' => $offer_attachment_img , 
			'price_condition' => $price_condition, 
			'salutation' => $salutation, 
			'tax' => $tax, 
			'status' => $offer_status, 
			'reason_for_rejection' => 99, 
			'your_reference' => $your_reference , 
			'offer_close_date' => $offer_close_date , 
			'offer_company_name' => $offer_company_name
		);

        $where = '(entity_id ="'.$offer_entity_id.'")';
        $this->db->where($where);
        $this->db->update('offer_register',$update_offer_array);

        $enquiry_status = 2;
		if($enquiry_entity_id){
        $update_enquiry_array = array('enquiry_status' => $enquiry_status);
        $where = '(entity_id ="'.$enquiry_entity_id.'")';
        $this->db->where($where);
        $this->db->update('enquiry_register',$update_enquiry_array);
		}

        $data = site_url('vw_offer_data');

        echo $data;
    }
    
    public function offer_without_lead_data_save()
    {
        if(!empty($_FILES['offer_attachment']))
        {
            $offer_attachment_img = "";
            foreach ($_FILES as $key => $value) {
                
                $file_name = $value['name'];
                $file_source_path = $value['tmp_name'];
                $file_upload_combine_array = array_combine($file_name, $file_source_path);
                //print_r($file_upload_combine_array);
                
                foreach ($file_upload_combine_array as $image_name=> $image_source_path) {
                    // echo $k. ' '. $a ;

                    $ext = pathinfo($image_name,PATHINFO_EXTENSION);

                    $offer_attachment_upload = substr(str_replace(" ", "_", $image_name), 0);
                    move_uploaded_file($image_source_path, 'assets/offer_attachment/'.$offer_attachment_upload);

                    $offer_attachment_img .= $offer_attachment_upload.',';
                }  
            }
        }else{
            $offer_attachment_img = NULL;
        }


        $user_id = $_SESSION['user_id'];
        $user_name = $this->session->userdata('full_name');


        $offer_id= $this->input->post('enquiry_entity_id');

        $customer_id = $this->input->post('customer_name');
        $contact_id = $this->input->post('contact_id');
        $offer_number = $this->input->post('offer_number');

        $enquiry_descrption = $this->input->post('enquiry_descrption');
        $employee_id = $this->input->post('employee_id');
        $salutation = $this->input->post('salutation');
        $offer_type = $this->input->post('offer_type');
        $offer_date = $this->input->post('offer_date');
        $price_basis = $this->input->post('price_basis');
        $transport_insurance = $this->input->post('transport_insurance');
        $tax = $this->input->post('tax');
        $delivery_schedule = $this->input->post('delivery_schedule');
        $mode_of_payment = $this->input->post('mode_of_payment');
        $validity = $this->input->post('validity');
        $dispatch_address = $this->input->post('dispatch_address');
        $delivery_instruction = $this->input->post('delivery_instruction');
        $packing_forwarding = $this->input->post('packing_forwarding');
        $guarantee_warrenty = $this->input->post('guarantee_warrenty');
        $payment_term = $this->input->post('payment_term');
        $special_instruction = $this->input->post('special_instruction');
        $price_condition = $this->input->post('price_condition');
        $your_reference = $this->input->post('your_reference');

        $offer_note = $this->input->post('offer_note');
        $offer_close_date = $this->input->post('offer_close_date');

        $update_offer_array = array('offer_description' => $enquiry_descrption , 'offer_engg_name' => $employee_id , 'customer_id' => $customer_id , 'contact_person_id' => $contact_id , 'offer_type' => $offer_type , 'offer_date' => $offer_date , 'dispatch_address' => $dispatch_address , 'delivery_instruction' => $delivery_instruction , 'packing_forwarding' => $packing_forwarding , 'payment_term' => $payment_term , 'special_packing' => $special_instruction , 'attachment' => $offer_attachment_img , 'price_condition' => $price_condition , 'price_basis' => $price_basis , 'salutation' => $salutation , 'transport_insurance' => $transport_insurance , 'tax' => $tax, 'delivery_schedule' => $delivery_schedule , 'mode_of_payment' => $mode_of_payment , 'status' => 2 , 'note'=>$offer_note , 'your_reference' => $your_reference , 'offer_close_date' => $offer_close_date , 'validity' => $validity , 'guarantee_warrenty' => $guarantee_warrenty);
        $where = '(entity_id ="'.$offer_id.'")';
        $this->db->where($where);
        $this->db->update('offer_register',$update_offer_array);

        $tracking_record = "Quotation Number:- ".$offer_number." Created by ".$user_name.' , But Quotation not send over email address';
        $next_action = "Call Customer And Ask For Order.";

        $this->db->select('tracking_number');
        $this->db->from('enquiry_tracking_master');
        $this->db->order_by('entity_id', 'DESC');
        $this->db->limit(1);
        $enquiry_tracking_master = $this->db->get();
        $results_enquiry_tracking_register = $enquiry_tracking_master->result_array();

        if(!empty($results_enquiry_tracking_register))
        {
            $enquiry_tracking_serial_no = $results_enquiry_tracking_register[0]['tracking_number'];
            $enquiry_tracking_data_seprate = explode('/', $enquiry_tracking_serial_no);
            $enquiry_tracking_doc_year = $enquiry_tracking_data_seprate['1'];
        }

        $this->db->select('document_series_no');
        $this->db->from('documentseries_master');
        $where = '(documentseries_master.entity_id = "'.'7'.'")';
        $this->db->where($where);
        $doc_record=$this->db->get();
        $results_doc_record = $doc_record->result_array();

        $doc_serial_no = $results_doc_record[0]['document_series_no'];
        $doc_data_seprate = explode('/', $doc_serial_no);
        $doc_year = $doc_data_seprate['1'];

        if(empty($results_enquiry_tracking_register[0]['tracking_number']) || ($enquiry_tracking_doc_year != $doc_year))
        {
            $first_no = '0001';
            $doc_no = $doc_serial_no.$first_no;
        }elseif(!empty($results_enquiry_tracking_register) && ($enquiry_tracking_doc_year == $doc_year))
        {
            $doc_type = $enquiry_tracking_data_seprate['0'];
            $ex_no = $enquiry_tracking_data_seprate['2'];
            $next_en = $ex_no + 1;
            $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
            $doc_no = $doc_type.'/'.$enquiry_tracking_doc_year.'/'.$next_doc_no;
        }

        $next_action_due_date = date('Y-m-d', strtotime($offer_date . " +1 days"));

        $track_save = "INSERT INTO enquiry_tracking_master (user_id , tracking_number , offer_id , customer_id , tracking_date , tracking_record , next_action , action_due_date , status) VALUES ('".$user_id."' , '".$doc_no."' , '".$offer_id."' , '".$customer_id."' , '".$offer_date."' , '".$tracking_record."' , '".$next_action."' , '".$next_action_due_date."' , '".'2'."')";
        $save_execute = $this->db->query($track_save);

        redirect('vw_offer_data'); 
    }

    public function old_offers()
    {
        $data['offer_details'] = $this->offer_register_model->get_old_offer_details();
        $this->load->view('sales/offer_register/old_offers',$data);
        // code...
    }
    public function edit_offer_wo_lead()
    {
        $entity_id = $this->uri->segment(2);
        $data['entity_id'] = $entity_id;
        $data['customer_list'] = $this->offer_register_model->get_customer_list();
        $data['employee_list'] = $this->offer_register_model->get_employee_list();
        $data['payment_term_list'] = $this->offer_register_model->get_payment_term_list();
        $data['product_list'] = $this->offer_register_model->get_product_list();
        $data['make_list'] = $this->offer_register_model->get_make_list();
        $data['product_category'] = $this->offer_register_model->get_product_category();
        $data['product_detail_hsn_code'] = $this->offer_register_model->get_product_hsn_code();
        $data['offer_product_list'] = $this->offer_register_model->get_without_lead_offer_product_list($entity_id);
        
        $this->load->view('sales/offer_register/edit_offer_without_lead',$data);
    }

    public function save_offer_without_lead()
    {
        $user_id = $_SESSION['user_id'];
        $user_name = $this->session->userdata('full_name');

        $customer_id = $this->input->post('customer_name');
        $contact_id = $this->input->post('contact_id');

        $product_checkbox = $this->input->post('product_checkbox');

        $enquiry_descrption = $this->input->post('enquiry_descrption');
        $employee_id = $this->input->post('employee_id');
        $offer_type = $this->input->post('offer_type');
        $offer_date = $this->input->post('offer_date');
        $dispatch_address = $this->input->post('dispatch_address');
        $delivery_instruction = $this->input->post('delivery_instruction');
        $special_instruction = $this->input->post('special_instruction');
        $price_condition = $this->input->post('price_condition');
        $salutation = $this->input->post('salutation');
        $price_basis = $this->input->post('price_basis');
        $transport_insurance = $this->input->post('transport_insurance');
        $tax = $this->input->post('tax');
        $delivery_schedule = $this->input->post('delivery_schedule');
        $mode_of_payment = $this->input->post('mode_of_payment');
        $guarantee_warrenty = $this->input->post('guarantee_warrenty');
        $payment_term = $this->input->post('payment_term');
        $packing_forwarding = $this->input->post('packing_forwarding');
        $your_reference = $this->input->post('your_reference');
        $validity = $this->input->post('validity');

        $offer_status = 1;
        $enquiry_prefix = "OT";

        date_default_timezone_set("Asia/Calcutta");
        $month_name = date('M');
        $month_name_upper = strtoupper($month_name);

        $this->db->select('offer_no');
        $this->db->from('offer_register');
        $where = '(offer_revision IS NULL)';
        $this->db->where($where);
        $this->db->order_by('offer_register.entity_id', 'DESC');
        $this->db->limit(1);
        $offer_register = $this->db->get();
        $results_offer_register = $offer_register->result_array();

        if(!empty($results_offer_register[0]['offer_no']))
        {
            $projection_serial_no = $results_offer_register[0]['offer_no'];
            $projection_data_seprate = explode('/', $projection_serial_no);
            $projection_doc_year = $projection_data_seprate['1'];
        }

        $this->db->select('document_series_no');
        $this->db->from('documentseries_master');
        $where = '(documentseries_master.entity_id = "'.'3'.'")';
        $this->db->where($where);
        $doc_record=$this->db->get();
        $results_doc_record = $doc_record->result_array();
        
        $doc_serial_no = $results_doc_record[0]['document_series_no'];
        $doc_data_seprate = explode('/', $doc_serial_no);
        $doc_year = $doc_data_seprate['1'];

        if(empty($results_offer_register[0]['offer_no']) || ($projection_doc_year != $doc_year))
        {
            $first_no = '0001';
            $offer_no = $doc_serial_no.$first_no;
        }
        elseif(!empty($results_offer_register) && ($projection_doc_year == $doc_year))
        {

            $doc_type = $projection_data_seprate['0'];
            $second_type = $projection_data_seprate['1'];
            $ex_no = $projection_data_seprate['2'];
            $next_en = $ex_no + 1;
            $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
            $offer_no = $doc_type.'/'.$second_type.'/'.$next_doc_no;
        }

        $offer_data_master_save = "INSERT INTO offer_register (offer_no, customer_id, contact_person_id, status, offer_engg_name, offer_description, offer_date, offer_type, dispatch_address, delivery_instruction, salutation, price_basis, transport_insurance, tax, delivery_schedule, mode_of_payment, price_condition, packing_forwarding, payment_term, your_reference, special_packing, guarantee_warrenty, validity) VALUES ('".$offer_no."', '".$customer_id."', '".$contact_id."', '".$offer_status."', '".$employee_id."', '".$enquiry_descrption."', '".$offer_date."', '".$offer_type."',  '".$dispatch_address."', '".$delivery_instruction."', '".$salutation."', '".$price_basis."', '".$transport_insurance."', '".$tax."', '".$delivery_schedule."', '".$mode_of_payment."', '".$price_condition."', '".$packing_forwarding."', '".$payment_term."', '".$your_reference."', '".$special_instruction."', '".$guarantee_warrenty."', '".$validity."')";
            $save_execute = $this->db->query($offer_data_master_save);

            $new_offer_id = $this->db->insert_id();

        foreach ($product_checkbox as $key => $value) 
        {
            $product_id = $value['value'];

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
            $product_make = $product_master_result->product_make;
            $product_warrenty = $product_master_result->warrenty;
            //$product_custom_description = $product_master_result->product_long_description;
            $discount = 0;
            $discount_amt = 0;
            $unit_discounted_price = $total_amount_without_gst - $discount_amt;

            //$product_make = $product_master_result->product_make;
            $internal_remark = $product_master_result->internal_remark;

            $this->db->select('*');
            $this->db->from('customer_master');
            $where = '(customer_master.entity_id = "'.$customer_id.'")';
            $this->db->where($where);
            $customer_address_master = $this->db->get();
            $customer_address_master_result = $customer_address_master->row();

            $state_code = $customer_address_master_result->state_code;

            if($state_code == 27)
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

            $this->db->select('offer_id');
            $this->db->from('offer_product_relation');
            $where_or = '(product_id = "'.$product_id.'" AND offer_id = "'.$new_offer_id.'")';
            $this->db->where($where_or);
            $offer_product_exit= $this->db->get();
            $offer_product_exit_data_count =  $offer_product_exit->num_rows();

            if ($offer_product_exit_data_count === 0) 
            {
                $offer_product_relation_save = "INSERT INTO offer_product_relation (offer_id , product_id , product_make , rfq_qty , price , total_amount_without_gst , cgst_discount , sgst_discount , igst_discount , cgst_amt , sgst_amt , igst_amt , total_amount_with_gst , discount , discount_amt , unit_discounted_price , product_warranty , internal_remark) VALUES ('".$new_offer_id."' , '".$product_id."' , '".$product_make."' , '".$rfq_qty."' , '".$price."' , '".$total_amount_without_gst."' , '".$cgst_percentage."' , '".$sgst_percentage."' , '".$igst_percentage."' , '".$cgst_amount."' , '".$sgst_amount."' , '".$igst_amount."' , '".$total_amount."' , '".$discount."' , '".$discount_amt."' , '".$unit_discounted_price."' , '".$product_warrenty."' , '".$internal_remark."')";
                $save_offer_product_relation = $this->db->query($offer_product_relation_save);
                //set session 
                $this->session->set_userdata('offer_product', 'Product Saved....!');
            }
            else{
                $this->session->set_userdata('offer_product', $session_product_var.' Product already exist....!');
            }
        }

        echo json_encode($new_offer_id);
    }


    public function save_offer_without_lead_product()
    {
        $offer_id=$this->input->post('entity_id');
        $customer_id=$this->input->post('customer_id');
        $product_checkbox=$this->input->post('product_checkbox');


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
            $product_master_result = $product_master->row_array();

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
            $product_warrenty = $product_master_result['warrenty'];
            $product_custom_description = $product_master_result['product_long_description'];
            $discount = 0;
            $discount_amt = 0;
            $unit_discounted_price = $total_amount_without_gst - $discount_amt;

            $product_make = $product_master_result['product_make'];
            $internal_remark = $product_master_result['internal_remark'];

            $this->db->select('*');
            $this->db->from('customer_master');
            $where = '(customer_master.entity_id = "'.$customer_id.'")';
            $this->db->where($where);
            $customer_address_master = $this->db->get();
            $customer_address_master_result = $customer_address_master->row();

            $state_code = $customer_address_master_result->state_code;

            if($state_code == 24)
            {
                $cgst_percentage = $product_master_result['cgst'];
                $sgst_percentage = $product_master_result['sgst'];
                $igst_percentage = NULL;

                $cgst_amount = $total_amount_without_gst * $cgst_percentage/100;
                $sgst_amount = $total_amount_without_gst * $sgst_percentage/100;
                $igst_amount = NULL;
            }else{
                $igst_percentage = $product_master_result['igst'];
                $sgst_percentage = NULL;
                $cgst_percentage = NULL;

                $igst_amount = $total_amount_without_gst * $igst_percentage/100;
                $sgst_amount = NULL;
                $cgst_amount = NULL;
            }

            $total_amount = $total_amount_without_gst + $cgst_amount + $sgst_amount + $igst_amount;

            $this->db->select('offer_id');
            $this->db->from('offer_product_relation');
            $where_or = '(product_id = "'.$product_id.'" AND offer_id = "'.$offer_id.'")';
            $this->db->where($where_or);
            $offer_product_exit= $this->db->get();
            $offer_product_exit_data_count =  $offer_product_exit->num_rows();

            if ($offer_product_exit_data_count === 0) 
            {
                $offer_product_relation_save = "INSERT INTO offer_product_relation (offer_id , product_make , product_id , rfq_qty , product_custom_description , price , total_amount_without_gst , cgst_discount , sgst_discount , igst_discount , cgst_amt , sgst_amt , igst_amt , total_amount_with_gst , product_warranty , discount , discount_amt , unit_discounted_price , internal_remark) VALUES ('".$offer_id."' , '".$product_make."' , '".$product_id."' , '".$rfq_qty."' , '".$product_custom_description."' , '".$price."' , '".$total_amount_without_gst."' , '".$cgst_percentage."' , '".$sgst_percentage."' , '".$igst_percentage."' , '".$cgst_amount."' , '".$sgst_amount."' , '".$igst_amount."' , '".$total_amount."' , '".$product_warrenty."' , '".$discount."' , '".$discount_amt."' , '".$unit_discounted_price."' , '".$internal_remark."')";
                $save_offer_product_relation = $this->db->query($offer_product_relation_save);
                //set session 
                $this->session->set_userdata('offer_product', 'Product Saved....!');
            }
            else{
                $this->session->set_userdata('offer_product', $session_product_var.' Product already exist....!');
            }
        }

    }

    public function update_offer_data()
    {
        $entity_id = $this->uri->segment(2);
        $data['entity_id'] = $entity_id;
        $data['offer_id'] = $entity_id;

        $enquiry_data = $this->offer_register_model->get_enquiry_details_by_offer_id_model($entity_id);
        $data['enquiry_result'] = $enquiry_data;

        $data['customer_list'] = $this->offer_register_model->get_customer_list();
        $data['employee_list'] = $this->offer_register_model->get_employee_list();
        $data['principle_engg_list'] = $this->offer_register_model->get_principle_engg_list();
        $data['payment_term_list'] = $this->offer_register_model->get_payment_term_list();
        $data['product_list'] = $this->offer_register_model->get_product_list();
        $data['make_list'] = $this->offer_register_model->get_make_list();
        $data['unit_list'] = $this->offer_register_model->get_unit_list();
        $data['source_list'] = $this->offer_register_model->get_enquiry_source_list();
        $data['offer_for_list'] = $this->offer_register_model->get_offer_for_list();
        $data['offer_for_info_list'] = $this->offer_register_model->get_offer_for_info_list();
        $data['stage_list'] = $this->offer_register_model->get_stage_list();
        $data['offer_reason_list'] = $this->offer_register_model->get_offer_reason_list();
        $data['offer_product_list'] = $this->offer_register_model->get_offer_product_list_by_id($entity_id);
        $data['product_category'] = $this->offer_register_model->get_product_category();
        $data['product_detail_hsn_code'] = $this->offer_register_model->get_product_hsn_code();
        $offer_data = $this->offer_register_model->get_offer_details_by_offerid_model($entity_id);
        $data['offer_result'] = $offer_data;
      
        $customer_id = $this->offer_register_model->get_offer_details_by_id($entity_id)->customer_id;

        $data['contact_person_list'] = $this->offer_register_model->get_contact_person_list($customer_id);
        $data['offer_tracking_details'] = $this->enquiry_tracking_register_model->get_enquiry_tracking_data_by_offer_id($entity_id);
        $this->load->view('sales/offer_register/vw_offer_register_update',$data);
    }

    public function get_offer_details_by_offerid()
    {
        $entity_id = $this->input->post('entity_id',TRUE);
        $data = $this->offer_register_model->get_offer_details_by_offerid_model($entity_id)->result();
        echo json_encode($data);
    }

    public function update_offer_product()
    {
        $entity_id = $this->input->post('entity_id');

        $product_checkbox = $this->input->post('product_checkbox');

        $enquiry_descrption = $this->input->post('enquiry_descrption');
        $employee_id = $this->input->post('employee_id');
        $salutation = $this->input->post('salutation');
        $offer_type = $this->input->post('offer_type');
        $offer_date = $this->input->post('offer_date');
        $price_basis = $this->input->post('price_basis');
        $transport_insurance = $this->input->post('transport_insurance');
        $tax = $this->input->post('tax');
        $delivery_schedule = $this->input->post('delivery_schedule');
        $mode_of_payment = $this->input->post('mode_of_payment');
        $validity = $this->input->post('validity');
        $dispatch_address = $this->input->post('dispatch_address');
        $delivery_instruction = $this->input->post('delivery_instruction');
        $packing_forwarding = $this->input->post('packing_forwarding');
        $guarantee_warrenty = $this->input->post('guarantee_warrenty');
        $payment_term = $this->input->post('payment_term');
        $special_instruction = $this->input->post('special_instruction');
        $price_condition = $this->input->post('price_condition');
        $your_reference = $this->input->post('your_reference');

        $this->db->select('*');
        $this->db->from('offer_register');
        $where = '(offer_register.entity_id = "'.$entity_id.'" )';
        $this->db->where($where);
        $query_data = $this->db->get();
        $query_result = $query_data->row_array();

        $offer_customer_id = $query_result['customer_id'];

        $update_offer_array = array('offer_description' => $enquiry_descrption , 'offer_engg_name' => $employee_id , 'offer_type' => $offer_type , 'offer_date' => $offer_date , 'dispatch_address' => $dispatch_address , 'delivery_instruction' => $delivery_instruction , 'packing_forwarding' => $packing_forwarding , 'payment_term' => $payment_term , 'special_packing' => $special_instruction , 'salutation' => $salutation , 'price_basis' => $price_basis , 'transport_insurance' => $transport_insurance , 'tax' => $tax , 'delivery_schedule' => $delivery_schedule , 'mode_of_payment' => $mode_of_payment , 'guarantee_warrenty' => $guarantee_warrenty , 'price_condition' => $price_condition , 'your_reference' => $your_reference , 'validity' => $validity);

        $where = '(entity_id ="'.$entity_id.'")';
        $this->db->where($where);
        $this->db->update('offer_register',$update_offer_array);

        foreach ($product_checkbox as $key => $value) 
        {
            $product_id = $value['value'];

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

            $product_make = $product_master_result->product_make;
            $internal_remark = $product_master_result->internal_remark;

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
            $where = '(customer_master.entity_id = "'.$offer_customer_id.'")';
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

            $this->db->select('offer_id');
            $this->db->from('offer_product_relation');
            $where_or = '(product_id = "'.$product_id.'" AND offer_id = "'.$entity_id.'")';
            $this->db->where($where_or);
            $offer_product_exit= $this->db->get();
            $offer_product_exit_data_count =  $offer_product_exit->num_rows();

            if ($offer_product_exit_data_count === 0) 
            {
                $offer_product_relation_save = "INSERT INTO offer_product_relation (offer_id , product_id , product_make , rfq_qty , product_custom_description , price , total_amount_without_gst , cgst_discount , sgst_discount , igst_discount , cgst_amt , sgst_amt , igst_amt , total_amount_with_gst , product_warranty , discount , discount_amt , unit_discounted_price , internal_remark) VALUES ('".$entity_id."' , '".$product_id."' , '".$product_make."' , '".$rfq_qty."' , '".$product_custom_description."' , '".$price."' , '".$total_amount_without_gst."' , '".$cgst_percentage."' , '".$sgst_percentage."' , '".$igst_percentage."' , '".$cgst_amount."' , '".$sgst_amount."' , '".$igst_amount."' , '".$total_amount."' , '".$product_warrenty."' , '".$discount."' , '".$discount_amt."' , '".$unit_discounted_price."' , '".$internal_remark."')";
                $save_offer_product_relation = $this->db->query($offer_product_relation_save);
                //set session 
                $this->session->set_userdata('offer_product', 'Product Saved....!');
            }
            else{
                 $this->session->set_userdata('offer_product', $session_product_var.' Product already exist....!');
             }
        }

        $data = $entity_id;
        echo json_encode($data);
    }

    public function update_offer()
    {
        $entity_id = $this->input->post('entity_id');
        $customer_id = $this->input->post('customer_name');
        
        $tracking_descrption = $this->input->post('tracking_descrption');

        if(!empty($tracking_descrption))
        {
            $this->db->select('*');
            $this->db->from('offer_register');
            $where_or = '(entity_id = "'.$entity_id.'")';
            $this->db->where($where_or);
            $offer_register= $this->db->get();
            $offer_register_data = $offer_register->row_array();

            $Enquiry_id_check = $offer_register_data['enquiry_id'];

            if(!empty($Enquiry_id_check))
            {
                $Enquiry_id = $Enquiry_id_check;
            }else{
                $Enquiry_id = NULL;
            }

            $tracking_date = $this->input->post('tracking_date');
            $tracking_descrption = $this->input->post('tracking_descrption');
            $status = 2;
            $tracking_next_action = $this->input->post('tracking_next_action');
            $action_due_date = $this->input->post('action_due_date');

            
                if(!empty($action_due_date))
                {
                    $new_action_due_date = $action_due_date;
                }else{
                    $new_action_due_date = "";
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
            $where_or = '(offer_id = "'.$entity_id.'" AND status = 1)';
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

                $insert_array = array(
                  'user_id' => $user_id,
                  'tracking_number' => $doc_no,
                  'enquiry_id' => $Enquiry_id , 
                  'offer_id' => $entity_id , 
                  'customer_id' => $customer_id , 
                  'tracking_date' => $tracking_date , 
                  'tracking_record' => $tracking_descrption ,
                  'action_due_date' => $new_action_due_date , 
                  'status' => $status);

                $this->db->insert('enquiry_tracking_master',$insert_array);

                // $enquiry_data_enquiry_track_save = "INSERT INTO enquiry_tracking_master (user_id , tracking_number , enquiry_id , offer_id , customer_id , tracking_date , tracking_record , next_action , action_due_date , status) VALUES ('".$user_id."' , '".$doc_no."' , '".$Enquiry_id."' , '".$entity_id."' , '".$customer_id."' , '".$tracking_date."' , '".$tracking_descrption."' , '".$next_action."' , '".$new_action_due_date."' , '".$status."')";
                // $save_execute = $this->db->query($enquiry_data_enquiry_track_save);
            }else{
                $tracking_id = $enquiry_tracking_master_master['entity_id'];

                $update_array = array('enquiry_id' => $Enquiry_id , 'offer_id' => $entity_id , 'customer_id' => $customer_id , 'tracking_date' => $tracking_date , 'tracking_record' => $tracking_descrption , 'action_due_date' => $new_action_due_date , 'status' => $status);
                $where = '(entity_id ="'.$tracking_id.'")';
                $this->db->where($where);
                $this->db->update('enquiry_tracking_master',$update_array);
            }
        }

        if(!empty($_FILES['offer_attachment']['name']))
        {
            $entity_id = $this->input->post('entity_id');
            /*$ext = pathinfo($_FILES['offer_attachment']['name'],PATHINFO_EXTENSION);
            $offer_attachment_upload = substr(str_replace(" ", "_", $_FILES['offer_attachment']['name']), 0);
            move_uploaded_file($_FILES["offer_attachment"]["tmp_name"], 'assets/offer_attachment/'.$offer_attachment_upload);
            $offer_attachment_img = $_FILES['offer_attachment']['name'];*/ 

            $attachment_img = "";
            foreach ($_FILES as $key => $value) {
                
                $file_name = $value['name'];
                $file_source_path = $value['tmp_name'];
                $file_upload_combine_array = array_combine($file_name, $file_source_path);
                //print_r($file_upload_combine_array);
                
                foreach ($file_upload_combine_array as $image_name=> $image_source_path) {
                    // echo $k. ' '. $a ;

                    $ext = pathinfo($image_name,PATHINFO_EXTENSION);

                    $offer_attachment_upload = substr(str_replace(" ", "_", $image_name), 0);
                    move_uploaded_file($image_source_path, 'assets/offer_attachment/'.$offer_attachment_upload);

                    $attachment_img .= $offer_attachment_upload.',';
                }  
            }

            $this->db->select('attachment');
            $this->db->from('offer_register');
            $where = '(offer_register.entity_id = "'.$entity_id.'" )';
            $this->db->where($where);
            $attachment_check = $this->db->get();
            $attachment_check_result = $attachment_check->row_array();

            if(!empty($attachment_check_result))
            {
                $offer_attachment_img = $attachment_check_result['attachment'].$attachment_img;
            }else{
                $offer_attachment_img = $attachment_img;
            }
           
            $enquiry_descrption = $this->input->post('enquiry_descrption');
            $employee_id = $this->input->post('employee_id');
            $rm_employee_id = $this->input->post('rm_employee_id');
            $principle_engg_id = $this->input->post('principle_engg_id');
            $offer_for = $this->input->post('offer_for');
            $offer_for_info = $this->input->post('offer_for_info');
            $offer_date = $this->input->post('offer_date');
            $offer_terms_condition = $this->input->post('offer_terms_condition');
           	$offer_source = $this->input->post('offer_source');
           	$offer_note = $this->input->post('offer_note');
            $offer_status = $this->input->post('offer_status');
            $offer_reason = $this->input->post('offer_reason');

            $salutation = $this->input->post('salutation');
            $tax = $this->input->post('tax');
            $price_condition = $this->input->post('price_condition');

            $your_reference = $this->input->post('your_reference');
            $offer_close_date = $this->input->post('offer_close_date');
            $validity = $this->input->post('validity');

            $this->db->select('*');
            $this->db->from('offer_register');
            $where = '(offer_register.entity_id = "'.$entity_id.'" )';
            $this->db->where($where);
            $query_data = $this->db->get();
            $query_result = $query_data->row_array();

            $enquiry_entity_id = $query_result['enquiry_id'];

            $update_offer_array = array(
				'offer_description' => $enquiry_descrption , 
				'offer_engg_name' => $employee_id , 
				'offer_rm_employee_id' => $rm_employee_id , 
				'offer_principle_engg_id' => $principle_engg_id , 
				'offer_for' => $offer_for ,
				'offer_for_info' => $offer_for_info ,
				'offer_date' => $offer_date ,
				'offer_source' => $offer_source ,
				'terms_conditions' => $offer_terms_condition ,
				'note' => $offer_note ,
				'attachment' => $offer_attachment_img ,
				'price_condition' => $price_condition,
				'salutation' => $salutation,
				'tax' => $tax,
				'status' => $offer_status ,
				'reason_for_rejection' => $offer_reason,
				'your_reference' => $your_reference ,
				'offer_close_date' => $offer_close_date ,
				'validity' => $validity
			);

            $where = '(entity_id ="'.$entity_id.'")';
            $this->db->where($where);
            $this->db->update('offer_register',$update_offer_array);

            if($offer_status == 4 || $offer_status == 5)
            {
                $enquiry_status = 5;
                $update_enquiry_array = array('enquiry_status' => $enquiry_status);
                $where = '(entity_id ="'.$enquiry_entity_id.'")';
                $this->db->where($where);
                $this->db->update('enquiry_register',$update_enquiry_array);
            }

            redirect('vw_offer_data'); 
        }else{

            $entity_id = $this->input->post('entity_id');
            $enquiry_descrption = $this->input->post('enquiry_descrption');
            $employee_id = $this->input->post('employee_id');
            $offer_for = $this->input->post('offer_for');
            $offer_date = $this->input->post('offer_date');
            $offer_source = $this->input->post('offer_source');
            $offer_terms_condition = $this->input->post('offer_terms_condition');
           	$offer_note = $this->input->post('offer_note');
            $offer_status = $this->input->post('offer_status');
            $offer_reason = $this->input->post('offer_reason');

            $salutation = $this->input->post('salutation');
			$tax = $this->input->post('tax');
            $price_condition = $this->input->post('price_condition');
            $your_reference = $this->input->post('your_reference');
            $validity = $this->input->post('validity');

            $offer_close_date = $this->input->post('offer_close_date');
            $this->db->select('*');
            $this->db->from('offer_register');
            $where = '(offer_register.entity_id = "'.$entity_id.'" )';
            $this->db->where($where);
            $query_data = $this->db->get();
            $query_result = $query_data->row_array();

            $enquiry_entity_id = $query_result['enquiry_id'];

            $update_offer_array = array(
				'offer_description' => $enquiry_descrption ,
				'offer_engg_name' => $employee_id ,
				'offer_for' => $offer_for ,
				'offer_date' => $offer_date ,
				'offer_source' => $offer_source ,
				'terms_conditions' => $offer_terms_condition ,
				'note' => $offer_note ,
				'price_condition' => $price_condition,
				'salutation' => $salutation,
				'tax' => $tax,
				'status' => $offer_status ,
				'reason_for_rejection' => $offer_reason,
				'your_reference' => $your_reference ,
				'offer_close_date' => $offer_close_date ,
				'validity' => $validity
			);

            $where = '(entity_id ="'.$entity_id.'")';
            $this->db->where($where);
            $this->db->update('offer_register',$update_offer_array);

            if($offer_status == 4 || $offer_status == 5)
            {
                $enquiry_status = 5;
                $update_enquiry_array = array('enquiry_status' => $enquiry_status);
                $where = '(entity_id ="'.$enquiry_entity_id.'")';
                $this->db->where($where);
                $this->db->update('enquiry_register',$update_enquiry_array);
            }

            redirect('vw_offer_data');
        }
    }

   
    public function view_offer_data()
    {
      $entity_id = $this->uri->segment(2);
      $data['entity_id'] = $entity_id;

      $enquiry_data = $this->offer_register_model->get_enquiry_details_by_offer_id_model($entity_id);
      $data['enquiry_result'] = $enquiry_data;

      $data['customer_list'] = $this->offer_register_model->get_customer_list();
      $data['employee_list'] = $this->offer_register_model->get_employee_list();
      $data['payment_term_list'] = $this->offer_register_model->get_payment_term_list();
      $data['product_list'] = $this->offer_register_model->get_product_list();
      $data['make_list'] = $this->offer_register_model->get_make_list();
      $data['offer_product_list'] = $this->offer_register_model->get_offer_product_list_by_id($entity_id);
      $data['product_category'] = $this->offer_register_model->get_product_category();
      $data['product_detail_hsn_code'] = $this->offer_register_model->get_product_hsn_code();
      $offer_data = $this->offer_register_model->get_offer_details_by_offerid_model($entity_id);
      $data['offer_result'] = $offer_data;
      $data['offer_tracking_details'] = $this->enquiry_tracking_register_model->get_enquiry_tracking_data_by_offer_id($entity_id);
      
      $this->load->view('sales/offer_register/vw_offer_register_view',$data);
    }


    public function set_revision_offer_save()
    {
        $entity_id = $this->uri->segment(2);
        $offer_data = $this->offer_register_model->set_revision_offer_save_model($entity_id);
        /*$data['entity_id'] = $entity_id;
        $data['offer_result'] = $offer_data;
        $data['customer_list'] = $this->offer_register_model->get_customer_list();
        $data['employee_list'] = $this->offer_register_model->get_employee_list();
        $data['payment_term_list'] = $this->offer_register_model->get_payment_term_list();
        $data['product_list'] = $this->offer_register_model->get_product_list();
        $data['offer_product_list'] = $this->offer_register_model->get_offer_product_list($entity_id);
        $this->load->view('sales/offer_register/vw_offer_register_revision_create');*/
        //redirect('vw_offer_data');
        redirect('update_offer_data'.'/'.$offer_data); 
    }

    public function update_new_product_with_offer()
    {
        $offer_entity_id = $this->input->post('offer_entity_id');

        $offer_customer_id = $this->input->post('customer_name');
        $contact_id = $this->input->post('contact_id');

        $offer_company_name = $this->input->post('offer_company_name');

        $enquiry_descrption = $this->input->post('enquiry_descrption');
        $employee_id = $this->input->post('employee_id');
        $offer_for = $this->input->post('offer_for');
        $offer_date = $this->input->post('offer_date');
        $offer_terms_condition = $this->input->post('offer_terms_condition');
        $offer_source = $this->input->post('offer_source');
        $price_condition = $this->input->post('price_condition');
        $salutation = $this->input->post('salutation');
       	$tax = $this->input->post('tax');
        $your_reference = $this->input->post('your_reference');
        $validity = $this->input->post('validity');
        $offer_note = $this->input->post('offer_note');

        // $this->db->select('*');
        // $this->db->from('offer_register');
        // $where = '(offer_register.enquiry_id = "'.$enquiry_entity_id.'" )';
        // $this->db->where($where);
        // $this->db->order_by('offer_register.entity_id', 'DESC');
        // $this->db->limit(1);
        // $query_data = $this->db->get();
        // $query_result = $query_data->row_array();

        // $offer_entity_id = $query_result['entity_id'];

        $update_offer_array = array(
          'customer_id' => $offer_customer_id , 
          'contact_person_id' => $contact_id ,
          'offer_description' => $enquiry_descrption , 
          'offer_engg_name' => $employee_id , 
          'offer_for' => $offer_for , 
          'offer_date' => $offer_date , 
          'terms_conditions' => $offer_terms_condition , 
          'offer_source' => $offer_source , 
          'price_condition' => $price_condition, 
          'salutation' => $salutation, 
          'price_basis' => $price_basis, 
          'tax' => $tax, 
          'your_reference' => $your_reference , 
          'validity' => $validity , 
          'note' => $offer_note , 
          'offer_company_name' => $offer_company_name);

        $where = '(entity_id ="'.$offer_entity_id.'")';
        $this->db->where($where);
        $this->db->update('offer_register',$update_offer_array);

        $product_id = $this->input->post('product_id');
        $product_name = $this->input->post('product_name');
        $hsn_code = $this->input->post('hsn_code');
        $product_make = $this->input->post('product_make');
        $category_id = $this->input->post('category_id');
        $product_long_desc = $this->input->post('product_long_desc');
        $product_warranty = $this->input->post('product_warranty');
        $product_unit = $this->input->post('product_unit');
        $product_price = $this->input->post('product_price');
        $internal_remark = $this->input->post('internal_remark');
        $product_type = 1;

        $product_data = array(
          'category_id' => $category_id , 
          'product_id' => $product_id , 
          'product_make' => $product_make , 
          'product_name' => $product_name , 
          'product_long_description' => $product_long_desc , 
          'product_type' => $product_type , 
          'warrenty' => $product_warranty , 
          'hsn_id' => $hsn_code , 
          'status' => 1 , 
          'unit' => $product_unit , 
          'internal_remark' => $internal_remark);

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
        $gst_percentage = $product_master_result->total_gst_percentage;
        $product_custom_description = $product_master_result->product_name;

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
        $product_make = $product_master_result->product_make;
        $product_warrenty = $product_master_result->warrenty;
        //$product_custom_description = $product_master_result->product_long_description;
        $discount = 0;
        $discount_amt = 0;
        $unit_discounted_price = $total_amount_without_gst - $discount_amt;
        
        //$product_make = $product_master_result->product_make;
        $internal_remark = $product_master_result->internal_remark;
        
        $this->db->select('*');
        $this->db->from('customer_master');
        $where = '(customer_master.entity_id = "'.$offer_customer_id.'")';
        $this->db->where($where);
        $customer_address_master = $this->db->get();
        $customer_address_master_result = $customer_address_master->row();
        
        /*$state_code = $customer_address_master_result->state_code;
        
        if($state_code == 27)
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
        }*/
        
        $gst_amount = $total_amount_without_gst * $gst_percentage/100;
        $total_amount = $total_amount_without_gst + $gst_amount;
        
        $this->db->select('offer_id');
        $this->db->from('offer_product_relation');
        $where_or = '(product_id = "'.$product_id.'" AND offer_id = "'.$offer_entity_id.'")';
        $this->db->where($where_or);
        $offer_product_exit= $this->db->get();
        $offer_product_exit_data_count =  $offer_product_exit->num_rows();
        
        //bookmark_1
        if ($offer_product_exit_data_count === 0) 
        {
          $offer_product_relation_save = "INSERT INTO offer_product_relation (offer_id , product_id , product_make , product_custom_description , rfq_qty , price , total_amount_without_gst , gst_percentage , gst_amount , total_amount_with_gst , discount , discount_amt , unit_discounted_price , product_warranty , internal_remark) VALUES ('".$offer_entity_id."' , '".$product_lastid."' , '".$product_make."' , '".$product_custom_description."' , '".$rfq_qty."' , '".$price."' , '".$total_amount_without_gst."' ,  '".$gst_percentage."' , '".$gst_amount."' , '".$total_amount."' , '".$discount."' , '".$discount_amt."' , '".$unit_discounted_price."' , '".$product_warrenty."' , '".$internal_remark."')";
          $save_offer_product_relation = $this->db->query($offer_product_relation_save);
          //set session 
          $this->session->set_userdata('offer_product', 'Product Saved....!');
      }
      else{
          $this->session->set_userdata('offer_product', $session_product_var.' Product already exist....!');
      }

        $data = $offer_entity_id;
        echo json_encode($data);
    }

    public function update_new_product_in_offer()
    {
        $entity_id = $this->input->post('entity_id');
        $enquiry_descrption = $this->input->post('enquiry_descrption');
        $employee_id = $this->input->post('employee_id');
        $offer_type = $this->input->post('offer_type');
        $offer_date = $this->input->post('offer_date');
        $offer_freight = $this->input->post('offer_freight');
        $freight_charges = $this->input->post('freight_charges');
        $dispatch_address = $this->input->post('dispatch_address');
        $delivery_instruction = $this->input->post('delivery_instruction');
        //$offer_pf = $this->input->post('offer_pf');
        $packing_forwarding_charges = $this->input->post('packing_forwarding_charges');
        //$payment_term = $this->input->post('payment_term');
        $special_instruction = $this->input->post('special_instruction');
        $offer_insurance = $this->input->post('offer_insurance');
        $insurance_charges = $this->input->post('insurance_charges');

        $price_condition = $this->input->post('price_condition');

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
        $your_reference = $this->input->post('your_reference');

        $pop_up_hsn_code = $this->input->post('pop_up_hsn_code');
        $category_id = $this->input->post('category_id');
        /*$sub_category_id = $this->input->post('sub_category_id');*/
        $sub_category_id = NULL;
        $product_id = $this->input->post('product_id');
        $product_name = $this->input->post('product_name');
        $product_long_desc = $this->input->post('product_long_desc');
        $product_type = 1;
        $product_sourcing_type = $this->input->post('product_sourcing_type');
        $product_warranty = $this->input->post('product_warranty');
        $product_unit = $this->input->post('product_unit');
        $product_price = $this->input->post('product_price');

        $this->db->select('*');
        $this->db->from('offer_register');
        $where = '(offer_register.entity_id = "'.$entity_id.'" )';
        $this->db->where($where);
        $query_data = $this->db->get();
        $query_result = $query_data->row_array();

       
        $offer_customer_id = $query_result['customer_id'];

        $update_offer_array = array('offer_description' => $enquiry_descrption , 'offer_engg_name' => $employee_id , 'offer_type' => $offer_type , 'offer_date' => $offer_date , 'Transportation' => $offer_freight , 'transportation_price' => $freight_charges , 'dispatch_address' => $dispatch_address , 'delivery_instruction' => $delivery_instruction , 'packing_forwarding' => $packing_forwarding , 'packing_forwarding_price' => $packing_forwarding_charges , 'payment_term' => $payment_term , 'special_packing' => $special_instruction , 'insurance' => $offer_insurance , 'insurance_price' => $insurance_charges, 'price_condition' => $price_condition, 'salutation' => $salutation, 'price_basis' => $price_basis, 'transport_insurance' => $transport_insurance, 'tax' => $tax, 'delivery_schedule' => $delivery_schedule, 'mode_of_payment' => $mode_of_payment, 'mode_of_transport' => $mode_of_transport, 'guarantee_warrenty' => $guarantee_warrenty, 'your_reference' => $your_reference);

        $where = '(entity_id ="'.$entity_id.'")';
        $this->db->where($where);
        $this->db->update('offer_register',$update_offer_array);

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
        $this->db->from('customer_address_master');
        $where = '(customer_address_master.customer_id = "'.$offer_customer_id.'" And customer_address_master.address_type = "'.'1'.'")';
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

        $this->db->select('offer_id');
        $this->db->from('offer_product_relation');
        $where_or = '(product_id = "'.$product_lastid.'" AND offer_id = "'.$entity_id.'")';
        $this->db->where($where_or);
        $offer_product_exit= $this->db->get();
        $offer_product_exit_data_count =  $offer_product_exit->num_rows();

        if ($offer_product_exit_data_count === 0) 
        {
            $offer_product_relation_save = "INSERT INTO offer_product_relation (offer_id , product_id , rfq_qty , product_custom_description , price , total_amount_without_gst , cgst_discount , sgst_discount , igst_discount , cgst_amt , sgst_amt , igst_amt , total_amount_with_gst , product_warranty , discount , discount_amt , unit_discounted_price) VALUES ('".$entity_id."' , '".$product_lastid."' , '".$rfq_qty."' , '".$product_long_desc."' , '".$price."' , '".$total_amount_without_gst."' , '".$cgst_percentage."' , '".$sgst_percentage."' , '".$igst_percentage."' , '".$cgst_amount."' , '".$sgst_amount."' , '".$igst_amount."' , '".$total_amount."' , '".$product_warrenty."' , '".$discount."' , '".$discount_amt."' , '".$unit_discounted_price."')";
            $save_offer_product_relation = $this->db->query($offer_product_relation_save);
            //set session 
            //$this->session->set_userdata('offer_product', 'Product Saved....!');
        }

        $data = $entity_id;
        echo json_encode($data);
    }

    public function delete_attach_image()
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
            $this->db->from('offer_register');
            $where = '(offer_register.entity_id = "'.$entity_id.'")';
            $this->db->where($where);
            $attachment_check = $this->db->get();
            $attachment_check_result = $attachment_check->row_array();

            $attachment_data = $attachment_check_result['attachment'];

            $delete_image = NULL;
            $replaced_data =  str_replace($image_name_db,$delete_image,$attachment_data);

            $image_attachment_new_array = array('attachment' => $replaced_data);
            $where = '(entity_id ="'.$entity_id.'")';
            $this->db->where($where);
            $this->db->update('offer_register',$image_attachment_new_array);

            unlink("assets/offer_attachment/".$image_name);
            redirect('update_offer_data'.'/'.$entity_id); 
        }
    }
    
    public function download_offer()
    {
        ob_start();
        $entity_id = $this->uri->segment(2);

        $en_id=$this->db->select('enquiry_id')->from('offer_register')->where('entity_id',$entity_id)->get()->row_array();
        $id=$en_id['enquiry_id'];
        if ($id == NUll) {
            $enquiry_nm= "NA";
            $enquiry_date= "NA";
        }else{
            $ml_id = $this->db->select('enquiry_no,enquiry_date')->from('enquiry_register')->where('entity_id',$id)->get()->row_array();
            $enquiry_nm = $ml_id['enquiry_no'];
        $enquiry_date = date("d-m-Y",strtotime($ml_id['enquiry_date']));
            
        }
        $this->db->select('customer_master.customer_name AS Customer_name,
                          customer_master.entity_id AS Customer_id,
                          customer_master.address AS Customer_address,
                          customer_master.pin_code AS Pin_code,
                          customer_master.gst_no AS Gst_no,
                          customer_master.state_code AS State_code,
                          offer_register.entity_id AS Entity_id,
                          offer_register.offer_no AS Offer_no,
                          offer_register.offer_description AS Offer_description,
                          offer_register.offer_engg_name AS Offer_engg_name,
                          offer_register.offer_date AS Offer_date,
                          offer_register.offer_close_date AS Offer_close_date,
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
                          offer_register.special_packing,
                          offer_register.salutation AS Salutation,
                          offer_register.price_basis AS Price_basis,
                          offer_register.transport_insurance AS Transport_insurance,
                          offer_register.tax AS Tax,
                          offer_register.delivery_schedule AS Delivery_schedule,
                          offer_register.mode_of_payment AS Mode_of_payment,
                          offer_register.mode_of_transport AS Mode_of_transport,
                          offer_register.guarantee_warrenty AS Guarantee_warrenty,
                          offer_register.validity AS Validity,
                          offer_register.your_reference AS Your_reference,
                          offer_register.contact_person_id AS Contact_id,
                          offer_register.offer_company_name AS offer_company_name,
                          employee_master.emp_first_name AS Emp_first_name,
                          employee_master.emp_middle_name AS Emp_middle_name,
                          employee_master.emp_last_name AS Emp_last_name,
                          employee_master.mobile_no AS Mobile_no,
                          state_master.state_name AS State_name');
        $this->db->from('offer_register');
        $this->db->join('customer_master', 'customer_master.entity_id = offer_register.customer_id', 'INNER');
        $this->db->join('employee_master', 'offer_register.offer_engg_name = employee_master.entity_id', 'INNER');
        $this->db->join('state_master', 'customer_master.state_id = state_master.entity_id', 'INNER');
        $where = '(offer_register.entity_id = "'.$entity_id.'")';
        $this->db->where($where);
        $query_master_offer_data = $this->db->get();
        $master_offer_data = $query_master_offer_data->result_array();

        $offer_company_name = $master_offer_data[0]['offer_company_name'];

        $customer_id = $master_offer_data[0]['Customer_id'];
        $Contact_id = $master_offer_data[0]['Contact_id'];

        $this->db->select('customer_contact_master.contact_person AS Contact_person_name,
        customer_contact_master.email_id AS Customer_email_id,
        customer_contact_master.first_contact_no AS Contact_no,');
        $this->db->from('customer_contact_master');
        $where = '(customer_contact_master.entity_id = "'.$Contact_id.'")';
        $this->db->where($where);
        $customer_contact_master = $this->db->get();
        $customer_contact_master_result = $customer_contact_master->row_array();

        $contact_person_name = $customer_contact_master_result['Contact_person_name'];
        $email = $customer_contact_master_result['Customer_email_id'];
        $contact_no1 = $customer_contact_master_result['Contact_no'];
        
        $offer_no = $master_offer_data[0]['Offer_no'];
        $enquiry_no = $enquiry_nm;

        $Pin_code = $master_offer_data[0]['Pin_code'];
        $Gst_no = $master_offer_data[0]['Gst_no'];
        $State_code = $master_offer_data[0]['State_code'];
        $State_name = $master_offer_data[0]['State_name'];
        
        
        $offer_description = $master_offer_data[0]['Offer_description'];

        $special_packing = $master_offer_data[0]['special_packing'];

        $offer_description_limited = substr($offer_description, 0, 100);

        $date_of_offer = $master_offer_data[0]['Offer_date'];
        $offer_date = date("d-m-Y",strtotime($date_of_offer));

        $date_of_offer_close = $master_offer_data[0]['Offer_close_date'];
        $offer_close_date = date("d-m-Y",strtotime($date_of_offer_close));

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
        
        if(!empty($offer_company_name))
        {
            $customer_name = $offer_company_name;
        }else{
            $customer_name = $master_offer_data[0]['Customer_name'];
        }
        
        $Validity = $master_offer_data[0]['Validity'];
        $Customer_address = $master_offer_data[0]['Customer_address'];
        
        $Delivery_instruction = $master_offer_data[0]['Delivery_instruction'];
        $Offer_freight = $master_offer_data[0]['Offer_freight'];

        $price_condition = $master_offer_data[0]['price_condition'];
        if($price_condition == 1)
        {
            $PC = "Ex Works VBTEK ";
        }elseif($price_condition == 2)
        {
            $PC = "FOR Site";
        }elseif($price_condition == 3)
        {
            $PC = "Other- Please refer note";
        }else{
            $PC = "NA";
        }
        
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
                          employee_master.joining_date AS Date_of_joining, enquiry_register.enquiry_source AS Enquiry_source');
                          // delete ftom select above = enquiry_register.enquiry_source AS Enquiry_source
        $this->db->from('offer_register');
        $this->db->join('enquiry_register', 'offer_register.enquiry_id = enquiry_register.entity_id', 'LEFT');
        $this->db->join('employee_master', 'offer_register.offer_engg_name = employee_master.entity_id', 'INNER');
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

        $this->db->select('offer_product_relation.*,
            product_make_master.make_name AS product_make,
            product_master.product_id AS PRODUCT_ID,
            product_master.product_name,
            unit_master.unit_name AS unit,
            product_hsn_master.hsn_code AS Hsn_code');
        $this->db->from('offer_product_relation');
        $this->db->join('product_master', 'offer_product_relation.product_id = product_master.entity_id', 'INNER');
        $this->db->join('unit_master', 'product_master.unit = unit_master.entity_id', 'INNER');
        $this->db->join('product_make_master', 'offer_product_relation.product_make = product_make_master.entity_id', 'INNER');
        $this->db->join('product_hsn_master', 'product_master.hsn_id = product_hsn_master.entity_id', 'INNER');
        $where = '(offer_product_relation.offer_id = "'.$entity_id.'")';
        $this->db->where($where);
        $offer_product_data = $this->db->get();
        $data_offer_product = $offer_product_data->result_array(); 
        $data_offer_product_count = $offer_product_data->num_rows();

        //print_r($data_offer_product_count);
        //die();
        //$location_id = $_SESSION['location_id'];

        $pdf = new Offer_pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        /*$pdf->SetPrintHeader(false);*/
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
                
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set font
        $pdf->SetFont('dejavusans', '', 10);

        $path_img = getcwd();
        $path = getcwd();
        /*$filename = $_SERVER['DOCUMENT_ROOT']."bluboxx_sales_crm/assets/offer_attachment/"."Offer_Details-".date('Y-m-d-H:i:s').".pdf";*/

        /*$filename = $path."/assets/offer_attachment/"."Offer_Details-".date('Y-m-d-H:i:s').".pdf";*/
        $year = date('Y'); // You may need to adjust this based on your academic year
        $formatted_date = date('Y-m-d-H:i:s');
       //$filename = $path . "/assets/offer_attachment/" . "OF/{$year}-" . ($year + 1) . "/{$offer_no}.pdf";
        // Construct the filename based on the offer number
        $filename = $path . "/assets/offer_attachment/" . str_replace('/', '_', $offer_no) . ".pdf";

        // Output the PDF file
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($filename) . '"');



        $Company_logo = $path_img."/assets/company_logo/intact_new_logo.png";
        $location = $path_img."/assets/login/location.jpg";
        $mail = $path_img."/assets/login/mail.png";
        $website = $path_img."/assets/login/website.png";
        $sign = $path_img."/assets/company_logo/sign.png";

        $pdf->AddPage();

        $html = '<br><br><br><br><h2 style="text-align: center; font-size:10px;">QUOTATION </h2>
                    <table style="border:0.9px solid black;" cellpadding="3" width="100%">
                    <tbody>
                        <tr>
                            <td style="font-size: 7px; border-bottom: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black; text-indent:2em; width: 50%;"><br><br><b>&nbsp;&nbsp;To,<br>&nbsp;&nbsp;'.strip_tags($customer_name).'</b><br><b>&nbsp;&nbsp;</b>'.getAddress($Customer_address,60,2).'<br><b>&nbsp;&nbsp;Contact Person :- </b>&nbsp;&nbsp;'.strip_tags($contact_person_name).'<br><b>&nbsp;&nbsp;Contact Number :- </b>&nbsp;&nbsp;'.strip_tags($contact_no1).'<br><b>&nbsp;&nbsp;Email id :- </b>&nbsp;&nbsp;'.strip_tags($email).'
                            </td>
                            <td style="font-size: 7px; border-bottom: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black; text-indent:2em; width: 50%;"><br><br><b>&nbsp;&nbsp;Offer Number - </b>'.strip_tags($offer_no).'
                                <br><b>&nbsp;&nbsp;Offer Date - </b>'.strip_tags($offer_date).'<b>&nbsp;&nbsp;&nbsp;&nbsp;Offer Close Date - </b>'.strip_tags($offer_close_date).'
                                <br><b>&nbsp;&nbsp;Enquiry Number - </b>'.strip_tags($enquiry_no).'<b>&nbsp;&nbsp;Enquiry Date - </b>'.strip_tags($enquiry_date).'
                                <br><b>&nbsp;&nbsp;Sales Person - </b>'.strip_tags($Full_name).'
                                <br><b>&nbsp;&nbsp;Sales Contact Number - </b>'.strip_tags($Phone_number).'
                                <br><b>&nbsp;&nbsp;Sales Person Email Id - </b>'.strip_tags($Email_id).'
                                <br>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 7px; border-bottom: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black; text-indent:2em; width: 100%;"><b>&nbsp;&nbsp;Subject - </b>'.strip_tags($offer_description_limited).'</td>
                        </tr>
                    </tbody>
                </table>';

        $pdf->writeHTML($html, true, false, true, false, ''); 

        $total_gst_product_taxable_amount = 0;
        $total_gst_product_taxable_amount_format = 0;

        $final_gst_product_amount_without_gst = 0;
        $final_gst_product_amount_without_gst_format = 0; 

        $product_gst_amount=0;
        $product_gst_amount_format=0;  
                   
        $i = 1;
        $j = 1;

        $total_gst_service_taxable_amount = 0;
        $total_gst_service_taxable_amount_format = 0;

        $final_gst_service_amount_without_gst = 0;
        $final_gst_service_amount_without_gst_format = 0; 

        $service_without_gst_amount=0;
        $service_without_gst_amount_format=0;

        if($data_offer_product_count > 0)
        {
            $html = '
                    <p style="font-size: 7px;  text-indent:2em; width: 100%;">'.breakSalutation($Salutation,15).'</p>

                    <table cellpadding="3" width="100%">
                        <tr style="background-color: #b0c4de;">
                            <td style="font-size: 6.5px; width: 5%; text-align: center; text-indent:2em;"><b>Sr.<br>&nbsp;&nbsp;&nbsp;No</b></td>

                            <td style="font-size: 6.5px; width: 8%; text-indent:2em; text-align: left;"><b>HSN<br>&nbsp;&nbsp;&nbsp;Code</b></td>

                            <td style="font-size: 6.5px; width: 8%; text-indent:2em; text-align: left;"><b>Part<br>&nbsp;&nbsp;&nbsp;Number</b></td>

                            <td style="font-size: 6.5px; width: 29%; text-align: center; text-indent:2em;"><b>Product Details</b></td>

                             <td style="font-size: 6.5px; width: 6%; text-align: center; text-indent:2em;"><b>Make</b></td>

                            <td style="font-size: 6.5px; width: 5%; text-indent:2em; text-align: center;"><b>Qty</b></td>

                            <td style="font-size: 6.5px; width: 5%; text-indent:2em; text-align: center;"><b>Unit</b></td>

                            <td style="font-size: 6.5px; width: 8%; text-indent:2em; text-align: center;"><b>Price Per<br>&nbsp;&nbsp;&nbsp;Unit INR</b></td>

                            <td style="font-size: 6.5px; width: 9%; text-indent:2em; text-align: center;"><b>Discounted<br>&nbsp;&nbsp;&nbsp;Price Per<br>&nbsp;&nbsp;&nbsp;Unit</b></td>

                            <td style="font-size: 6.5px; width: 8%; text-indent:2em; text-align: center;"><b>Total</b></td> 

                            <td style="font-size: 6.5px; width: 9%; text-indent:2em; text-align: center;"><b>GST<br>&nbsp;&nbsp;</b></td>

                        </tr>
                    </table>';
                    $all_product_total = 0;
                    $all_product_sub_total = 0;
                    $all_product_gst = 0;
                    $Quotation_amount = 0;
                    foreach ($data_offer_product as $value_data)
                    {   
                        $product_name = $value_data['product_name'];
                        $product_custom_part_no = $value_data['product_custom_part_no'];
                        $product_custom_description = $value_data['product_custom_description'];
                        $product_price_format = $value_data['price'];
                        $product_price = number_format((float)$product_price_format, 2, '.', '');
                        $product_unit = $value_data['unit'];
                        $product_qty = $value_data['rfq_qty'];

                        $total_format = $product_price * $product_qty;

                        $total = number_format((float)$total_format, 2, '.', '');

                        $all_product_total += $total;

                        $all_product_total = number_format((float)$all_product_total, 2, '.', '');

                        $PRODUCT_ID = $value_data['PRODUCT_ID'];

                        $product_make = $value_data['product_make'];

                        $remark = $value_data['remark'];

                        $amount_without_gst_format = $value_data['total_amount_without_gst'];
                        $amount_without_gst = number_format((float)$amount_without_gst_format, 2, '.', '');

                        $all_product_sub_total += $amount_without_gst;

                        $all_product_sub_total = number_format((float)$all_product_sub_total, 2, '.', '');

                        $cgst_percentage = $value_data['cgst_discount'];
                        $cgst_amount_format = $value_data['cgst_amt'];
                        $cgst_amount = number_format((float)$cgst_amount_format, 2, '.', '');

                        $sgst_percentage = $value_data['sgst_discount'];
                        $sgst_amount_format = $value_data['sgst_amt'];
                        $sgst_amount = number_format((float)$sgst_amount_format, 2, '.', '');

                        $igst_percentage = $value_data['igst_discount'];
                        $igst_amount_format = $value_data['igst_amt'];
                        $igst_amount = number_format((float)$igst_amount_format, 2, '.', '');
                        
                        $gst_percentage = $value_data['gst_percentage'];
                        $gst_amount_format = $value_data['gst_amount'];
                        $gst_amount = number_format((float)$gst_amount_format, 2, '.', '');

                        $all_gst = $gst_amount;

                        $all_product_gst += $all_gst;

                        $all_product_gst = number_format((float)$all_product_gst, 2, '.', '');

                        // if($igst_percentage == 0)
                        // {
                        //     $product_gst_rate = $sgst_percentage + $cgst_percentage;
                        // }else{
                        //     $product_gst_rate = $igst_percentage;
                        // }
                        
                        $product_gst_rate = $gst_percentage;

                        $hsn_code = $value_data['Hsn_code'];
                        $discount = $value_data['discount'];
                        $discount_amt = $value_data['unit_discounted_price'];

                        $discount_amt_format = $value_data['unit_discounted_price'];
                        $discount_amt = number_format((float)$discount_amt_format, 2, '.', '');

                        /*$total_amount_with_gst = $value_data['total_amount_with_gst'];*/

                        $total_amount_with_gst = $all_gst + $amount_without_gst;

                        $Quotation_amount += $total_amount_with_gst;
                        $Quotation_amount = number_format((float)$Quotation_amount, 2, '.', '');

                        $html .='<table cellpadding="3" width="100%">
                                    <tr>
                                        <td style="font-size: 6.5px; text-align: center; width: 5%; text-indent:2em;">'.strip_tags($i).'</td>

                                        <td style="font-size: 6.5px; width: 8%; text-indent:2em; text-align: left;">'.strip_tags($hsn_code).'</td>

                                        <td style="font-size: 6.5px; width: 8%; text-indent:2em; text-align: left;">'.strip_tags($product_custom_part_no).'</td>

                                        <td style="font-size: 6.5px; width: 29%; text-indent:2em; text-align: left;">'.strip_tags($product_custom_description).'</td>

                                        <td style="font-size: 6.5px; width: 6%; text-indent:2em;">'.strip_tags($product_make).'</td>

                                        <td style="font-size: 6.5px; width: 5%; text-indent:2em;">&nbsp;'.strip_tags($product_qty).'</td>

                                        <td style="font-size: 6.5px; width: 5%; text-indent:2em;">&nbsp;'.strip_tags($product_unit).'</td>

                                        <td style="font-size: 6.5px; width: 8%; text-indent:2em; text-align:right;">'.strip_tags($product_price).'</td>
                
                                        <td style="font-size: 6.5px; width: 9%; text-indent:2em; text-align:right;">'.strip_tags($discount_amt).'</td>

                                        <td style="font-size: 6.5px; width: 8%; text-indent:2em; text-align:right;">'.strip_tags($amount_without_gst).'</td>

                                        <td style="font-size: 6.5px; width: 9%; text-indent:2em; text-align:right;">'.strip_tags($product_gst_rate).'%'.'</td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 6.5px; text-align: left; width: 100%; text-indent:2em; color: #FF0000;"> Note : '.strip_tags($remark).'</td>
                                    </tr>
                                </table>';
                        $i++;   
                    }
                    for ($i = $data_offer_product_count; $i < 2; $i++) 
                    { 
                        $html .='<table  cellpadding="0.5" cellspacing="0" width="100%"> 
                                    <tr>                                   
                                        <td style="width: 5%; font-size: 7px; text-indent:2em;"></td>
                                        <td style="width: 8%;">&nbsp;</td>
                                        <td style="width: 8%;">&nbsp;</td>
                                        <td style="width: 23%;">&nbsp;</td>
                                        <td style="width: 6%;">&nbsp;</td>
                                        <td style="width: 5%;">&nbsp;</td>
                                        <td style="width: 5%;">&nbsp;</td>
                                        <td style="width: 8%;">&nbsp;</td>
                                        <td style="width: 9%;">&nbsp;</td>
                                        <td style="width: 8%;">&nbsp;</td>
                                        <td style="width: 9%;">&nbsp;</td>
                                    </tr>
                                </table>'; 
                    }
                    $html .='<table cellpadding="3" width="100%"> 
                                <tr>
                                    <td style="width: 90%; font-size: 6.5px; text-align:right;"><b> Total</b></td>
                                    <td style="width: 10%; font-size: 6.5px; text-align:right;"><b>'.strip_tags($all_product_total).'</b></td>
                                </tr>
                                <tr>
                                    <td style="width: 90%; font-size: 6.5px; text-align:right;"><b> Sub Total</b></td>
                                    <td style="width: 10%; font-size: 6.5px; text-align:right;"><b>'.strip_tags($all_product_sub_total).'</b></td>
                                </tr>
                                <tr>
                                    <td style="width: 90%; font-size: 6.5px; text-align:right;"><b> GST (Goods and Service Tax )</b></td>
                                    <td style="width: 10%; font-size: 6.5px; text-align:right;"><b>'.strip_tags($all_product_gst).'</b></td>
                                </tr>

                                <tr style="background-color: #b0c4de;">
                                    <td style="width: 90%; font-size: 6.5px; text-align:right;"><b> Grand Total</b></td>
                                    <td style="width: 10%; font-size: 6.5px; text-align:right;"><b>'.strip_tags($Quotation_amount).'</b></td>
                                </tr>

                                
                            </table>'; 
                    $pdf->writeHTML($html, true, false, true, false, '');
        }


        $Total_Amount_format =  $final_gst_product_amount_without_gst + $final_gst_service_amount_without_gst; 

        $Total_Amount = number_format((float)$Total_Amount_format, 2, '.', '');

        $this->load->library('numbertowordconvertsconver');
        $Final_invoice_amount_in_word = $this->numbertowordconvertsconver->convert_number($final_gst_product_amount_without_gst);

        $P_amount = amountFormat($final_gst_product_amount_without_gst);
        if(empty($P_amount))
        {
            $F_P_Amount = strip_tags($final_gst_product_amount_without_gst);
        }else{
            $F_P_Amount = amountFormat($final_gst_product_amount_without_gst);
        }

        $S_amount = amountFormat($final_gst_service_amount_without_gst);
        if(empty($S_amount))
        {
            $F_S_Amount = strip_tags($final_gst_service_amount_without_gst);
        }else{
            $F_S_Amount = amountFormat($final_gst_service_amount_without_gst);
        }

        $T_amount = amountFormat($Total_Amount);
        if(empty($T_amount))
        {
            $T_amt = strip_tags($Total_Amount);
        }else{
            $T_amt = amountFormat($Total_Amount);
        }


        $html = '<table style="border:0.9px solid black; width:100%;"  cellpadding="0">
                    <tr style="line-height:18px;">
                        <td style="font-size: 9px; width: 100%;"  >
                           <b>Terms & Conditions</b>
                        </td>
                    </tr>';

            $html .='<tr>  
                        <td  style="font-size: 7px;  width:25%;"> 
                            Price Condition:
                        </td>    
                        <td style="font-size: 7px;  width:75%;">    
                            '.strip_tags($PC).'
                        </td>
                    </tr>';
            
            $html .='<tr>  
                        <td  style="font-size: 7px;  width:25%;"> 
                            Freight charges:
                        </td>    
                        <td style="font-size: 7px;  width:75%;">    
                            '.strip_tags($Price_basis).'
                        </td>
                    </tr>';
            $html .='<tr>  
                        <td  style="font-size: 7px;  width:25%;"> 
                            Delivery
                        </td>
                        <td style="font-size: 7px;  width:75%;">      
                            '.strip_tags($Delivery_schedule).'
                        </td>    
                    </tr>';

            $html .='<tr>              
                        <td  style="font-size: 7px;  width:25%;">
                            Sales Tax:
                        </td>
                        <td style="font-size: 7px;  width:75%;">    
                            '.strip_tags($Tax).'
                        </td>
                  </tr>';

            $html .='<tr>             
                        <td  style="font-size: 7px;  width:25%;">
                           Payment:
                        </td> 
                        <td style="font-size: 7px;  width:75%;"> 
                           '.strip_tags($payment_term).'
                        </td>
                    </tr>';

            $html .='<tr>              
                        <td  style="font-size: 7px;  width:25%;">
                           Validity
                        </td>
                        <td style="font-size: 7px;  width:75%;">    
                            '.strip_tags($Validity).'
                        </td>
                    </tr>';

            $html .='<tr>              
                        <td  style="font-size: 7px;  width:25%;">
                            Warranty
                        </td>  
                        <td style="font-size: 7px;  width:75%;">        
                            '.strip_tags($Guarantee_warrenty).'
                        </td>
                    </tr>';
       
            $html .='</table>'; 

        $pdf->writeHTML($html, true, false, true, false, '');

        $html = '<table cellpadding="0" width="100%">
                        <tr>
                        <td>
                            <h3 style="font-size: 9px;"><b>Note:</b></h3>
                            <p><ul style="font-size: 8px;">
                                    <li>For Cable: Qty Tolerance +/- 10% in length.</li>
                                    <li>For Communication Devices/ Routers, Quoted prices are EXCLUSIVE of Power supply; Connection cables; SIM Cards; etc. unless it is specifically mentioned.</li>
                                    <li>Any Onsite support or Installation/ Commissioning charges will be extra, separate offer for the same will be submitted.</li>
                                    <li>Quoted Prices are worked out considering prevailing Duties, Taxes, Levies, Surcharge. In case there is any statutory changes in the same prices shall be adjusted accordingly.</li>
                                    <li>Once PO Accepted cannot be cancelled, as the items will be imported exclusively against your order.</li>
                                    <li>Delivery Lead Time mentioned above are excluding weekends and holidays.</li>
                                    <li>Interest at 24% per annum will be charged on overdue accounts.</li>
                            </ul></p>
                            <p style="font-size: 8px;">We hope the quoted products are in line with your requirements.<br>Feel free to contact us if you need any more info.
                            Look forward to receiving your valuable PO soon.</P>
                        </td>
                        </tr>
                        
                     </table>';
        $pdf->writeHTML($html, true, false, true, false, '');

        $html = '<table cellpadding="0" width="100%">
                    <tr>
                        <td><h2 style="font-size: 10px;"><b>Bank Details for NEFT/RTGS:</b></h2>
                        <p style="font-size: 7.5px;  text-indent:2em;">Bank Name :  HDFC Bank
                        <br>Account Name : VB Digitech Pvt. Ltd.
                        <br>Account No : 50200018071706
                        <br>Account Type :  CC
                        
                        <br>Bank Branch Code:  633
                       
                        <br>IFSC No : HDFC0000633
                        <br>Bank Address : 934 Nana Peth, Rajveer Complex.Pune, MH- 411002
                        </p>
                        </td>
                        <td style="width: 40%; text-align:right;">
                            <h2 style="font-size: 8px;"><b>For VB Digitech Pvt. Ltd.</b></h2>
                            <br><br>
                            <h3 style="font-size: 8px; text-align:right;"><b>VBTEK Sales<br> Mobile No: +91 7875432180</b></h3>

                        </td>
                    </tr>
                    
                    <tr COLSPAN=2>
                        <td style="width: 75%; text-align:left;">
                            <h3 style="font-size: 10px;"><b>“This Document is computer generated. No signature is required”</b></h3>
                        </td>
                        
                    </tr>
                     </table>';
        $pdf->writeHTML($html, true, false, true, false, '');
        
        $pdf->AddPage();
        $html = '<br><br><br><br>
                    <h3 style="font-size: 10px;text-align:center;"><b><u>VBTEK Warranty Policy</u></b></h3>
                    <table cellpadding="2" width="100%">
                        <tr>
                            <td>
                                <p style="font-size: 9px;">We hereby guarantee satisfactory operation of the purchased product/ products for a period of <b>Agreed tenure</b> from the
                                    <b>date of dispatch.</b> We shall be responsible for failure of the material to conform to the standard of performance,
                                    proficiency and for any defects that may develop under proper use arising from the use of faulty materials, design or
                                    workmanship in the supply made and shall remedy such defects. Important Notice: SPARE PARTS, ACCESSORIES AND
                                    PERIPHERALS ARE NOT COVERED IN THE WARRANTY
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h3 style="font-size: 10px;"><b>Warranty does not cover:</b></h3>
                                <p>
                                    <ul style="font-size: 7.5px;">
                                        <li>Damage Physical</li>
                                        <li>Product out of Warranty period</li>
                                        <li>Damage caused by natural disasters, such as lightning strikes, floods and earthquakes</li>
                                        <li>Intentional or non-intentional deterioration affecting the equipment, whatever the cause</li>
                                        <li>Damage caused by accidents, misuse, improper installation or unauthorized repair</li>
                                        <li>Damage caused to the equipment, if not correctly operated/ handled</li>
                                        <li>Damage due to wrong connections or wiring</li>
                                        <li>Products with Illegible, removed, or damaged serial number label will not be covered</li>
                                        <li>Additional updating, reworking or testing requested by customers</li>
                                        <li>Any upgrading or testing requested by customers after the warranty period</li>
                                    </ul>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h3 style="font-size: 10px;"><b>For Faulty Products under Warranty:</b></h3>
                                <p style="font-size: 9px;">
                                    Products to be sent to VBTEK for inspection. VBTEK Engineer will first inspect the product. If needed products will be
                                    further sent to Principles for servicing or repair. To & Fro Freight Charges will be borne by VBTEK for under warranty
                                    products.
                                </p>
                                <p style="font-size: 9px;">
                                    If Product is found to be faulty <u>for terms not covered under warranty</u>Handling, Servicing, Repair, To & Fro Freight or any
                                        additional Charges will be borne by the customer.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h3 style="font-size: 10px;"><b>For Products NOT under Warranty:</b></h3>
                                <p style="font-size: 9px;">
                                    The Warranty Tenure of the product is defined from the date of the dispatch of the product. If Product is not covered under
                                    Warranty, Handling, Servicing, Repair, To & Fro Freight Charges will be borne by the customer.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h3 style="font-size: 10px;"><b>NPF (No Problem Found):</b></h3>
                                <p style="font-size: 9px;">
                                    If NPF is detected from merchandise, VBTEK reserves the right to have necessary charges.
                                </p>
                            </td>
                        </tr>
                         <tr>
                            <td>
                                <h3 style="font-size: 10px;"><b>Note:</b></h3>
                                <p style="font-size: 9px;">
                                    VBTEK has the right to destroy or recycle the product(s) to allay our storage costs without incurring any liability if
                                        customers do not respond to a request of the payment or return of goods within 60 days from the date of the request.
                                </p>
                                <p style="font-size: 9px;">
                                    VBTEK reserves the right to modify or cancel the policy at any time. Neither VBTEK nor any of its entities will be
                                    responsible for any damages caused by such modifications or cancellation.
                                </p>
                            </td>
                        </tr>
                    </table>';
        $pdf->writeHTML($html, true, false, true, false, '');
        
        
        $pdf->Output($filename, 'I');
       // $pdf->Output('offer'.date('Y-m-d-H:i:s').'.pdf', 'I');        
    }
    

    public function download_offer_without_gst()
    {
        ob_start();
        $entity_id = $this->uri->segment(2);

        $en_id=$this->db->select('enquiry_id')->from('offer_register')->where('entity_id',$entity_id)->get()->row_array();
        $id=$en_id['enquiry_id'];
        if ($id == NUll) {
            $enquiry_nm= "NA";
            $enquiry_date= "NA";
        }else{
            $ml_id = $this->db->select('enquiry_no,enquiry_date')->from('enquiry_register')->where('entity_id',$id)->get()->row_array();
            $enquiry_nm = $ml_id['enquiry_no'];
        $enquiry_date = date("d-m-Y",strtotime($ml_id['enquiry_date']));
            
        }
        $this->db->select('customer_master.customer_name AS Customer_name,
                          customer_master.entity_id AS Customer_id,
                          customer_master.address AS Customer_address,
                          customer_master.pin_code AS Pin_code,
                          customer_master.gst_no AS Gst_no,
                          customer_master.state_code AS State_code,
                          offer_register.entity_id AS Entity_id,
                          offer_register.offer_no AS Offer_no,
                          offer_register.offer_description AS Offer_description,
                          offer_register.offer_engg_name AS Offer_engg_name,
                          offer_register.offer_date AS Offer_date,
                          offer_register.offer_close_date AS Offer_close_date,
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
                          offer_register.special_packing,
                          offer_register.salutation AS Salutation,
                          offer_register.price_basis AS Price_basis,
                          offer_register.transport_insurance AS Transport_insurance,
                          offer_register.tax AS Tax,
                          offer_register.delivery_schedule AS Delivery_schedule,
                          offer_register.mode_of_payment AS Mode_of_payment,
                          offer_register.mode_of_transport AS Mode_of_transport,
                          offer_register.guarantee_warrenty AS Guarantee_warrenty,
                          offer_register.validity AS Validity,
                          offer_register.terms_conditions AS Terms_conditions,
                          offer_register.offer_for AS Offer_for,
                          offer_register.offer_for_info AS Offer_for_info,
                          offer_register.your_reference AS Your_reference,
                          offer_register.contact_person_id AS Contact_id,
                          offer_register.offer_company_name AS offer_company_name,
                          rm_master.emp_first_name AS Rm_first_name,
                          rm_master.mobile_no AS Rm_mobile_no,
                          employee_master.emp_first_name AS Emp_first_name,
                          employee_master.emp_middle_name AS Emp_middle_name,
                          employee_master.emp_last_name AS Emp_last_name,
                          employee_master.mobile_no AS Mobile_no,
                          state_master.state_name AS State_name');
        $this->db->from('offer_register');
        $this->db->join('customer_master', 'customer_master.entity_id = offer_register.customer_id', 'INNER');
        $this->db->join('employee_master', 'offer_register.offer_engg_name = employee_master.entity_id', 'INNER');
        $this->db->join('employee_master as rm_master', 'offer_register.offer_rm_employee_id = rm_master.entity_id', 'left');
        $this->db->join('state_master', 'customer_master.state_id = state_master.entity_id', 'INNER');
        $where = '(offer_register.entity_id = "'.$entity_id.'")';
        $this->db->where($where);
        $query_master_offer_data = $this->db->get();
        $master_offer_data = $query_master_offer_data->result_array();


        $offer_company_name = $master_offer_data[0]['offer_company_name'];

        $customer_id = $master_offer_data[0]['Customer_id'];
        $Contact_id = $master_offer_data[0]['Contact_id'];

        $this->db->select('customer_contact_master.contact_person AS Contact_person_name,
        customer_contact_master.email_id AS Customer_email_id,
        customer_contact_master.first_contact_no AS Contact_no,');
        $this->db->from('customer_contact_master');
        $where = '(customer_contact_master.entity_id = "'.$Contact_id.'")';
        $this->db->where($where);
        $customer_contact_master = $this->db->get();
        $customer_contact_master_result = $customer_contact_master->row_array();

        $contact_person_name = $customer_contact_master_result['Contact_person_name'];
        $email = $customer_contact_master_result['Customer_email_id'];
        $contact_no1 = $customer_contact_master_result['Contact_no'];
        
        $offer_no = $master_offer_data[0]['Offer_no'];
        $enquiry_no = $enquiry_nm;

        $Pin_code = $master_offer_data[0]['Pin_code'];
        $Gst_no = $master_offer_data[0]['Gst_no'];
        $State_code = $master_offer_data[0]['State_code'];
        $State_name = $master_offer_data[0]['State_name'];
        
        
        $offer_description = $master_offer_data[0]['Offer_description'];

        $special_packing = $master_offer_data[0]['special_packing'];

        $offer_description_limited = substr($offer_description, 0, 100);

        $date_of_offer = $master_offer_data[0]['Offer_date'];
        $offer_date = date("d-m-Y",strtotime($date_of_offer));

        $date_of_offer_close = $master_offer_data[0]['Offer_close_date'];
        $offer_close_date = date("d-m-Y",strtotime($date_of_offer_close));

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
        
        if(!empty($offer_company_name))
        {
            $customer_name = $offer_company_name;
        }else{
            $customer_name = $master_offer_data[0]['Customer_name'];
        }

				$rm_name = $master_offer_data[0]['Rm_first_name'];
				$rm_contact_no =  $master_offer_data[0]['Rm_mobile_no'];
				$crm_name = $master_offer_data[0]['Emp_first_name'];
				$crm_contact_no = $master_offer_data[0]['Mobile_no'];
        
        $Validity = $master_offer_data[0]['Validity'];
        $Terms_conditions = $master_offer_data[0]['Terms_conditions'];
        $Offer_for = $master_offer_data[0]['Offer_for'];
        $Offer_for_info = $master_offer_data[0]['Offer_for_info'];
        $Customer_address = $master_offer_data[0]['Customer_address'];
        
        $Delivery_instruction = $master_offer_data[0]['Delivery_instruction'];
        $Offer_freight = $master_offer_data[0]['Offer_freight'];

        $price_condition = $master_offer_data[0]['price_condition'];
        if($price_condition == 1)
        {
            $PC = "Ex Works VBTEK ";
        }elseif($price_condition == 2)
        {
            $PC = "FOR Site";
        }elseif($price_condition == 3)
        {
            $PC = "Other- Please refer note";
        }else{
            $PC = "NA";
        }

				//get offer for 
				if(isset($Offer_for)){
				$Offer_for_name = $this->db->get_where('offer_for_master', ['entity_id' => $Offer_for])->row()->offer_for;
				}else{
					$Offer_for_name = "";
				}
				//get offer for Info
				if(isset($Offer_for) && isset($Offer_for_info)){

					$this->db->select('*');
					$this->db->from('offer_for_info');
					$this->db->where('entity_id', $Offer_for_info);
					$Offer_for_info_name = $this->db->get()->row()->offer_for_info;
				}else{
					$Offer_for_info_name = "";
				}
        
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
                          employee_master.joining_date AS Date_of_joining, enquiry_register.enquiry_source AS Enquiry_source');
                          // delete ftom select above = enquiry_register.enquiry_source AS Enquiry_source
        $this->db->from('offer_register');
        $this->db->join('enquiry_register', 'offer_register.enquiry_id = enquiry_register.entity_id', 'LEFT');
        $this->db->join('employee_master', 'offer_register.offer_engg_name = employee_master.entity_id', 'INNER');
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

        $this->db->select('offer_product_relation.*,
            product_make_master.make_name AS product_make,
            product_master.product_id AS PRODUCT_ID,
            product_master.product_name,
            unit_master.unit_name AS unit,
            product_hsn_master.hsn_code AS Hsn_code');
        $this->db->from('offer_product_relation');
        $this->db->join('product_master', 'offer_product_relation.product_id = product_master.entity_id', 'INNER');
        $this->db->join('unit_master', 'product_master.unit = unit_master.entity_id', 'INNER');
        $this->db->join('product_make_master', 'offer_product_relation.product_make = product_make_master.entity_id', 'INNER');
        $this->db->join('product_hsn_master', 'product_master.hsn_id = product_hsn_master.entity_id', 'INNER');
        $where = '(offer_product_relation.offer_id = "'.$entity_id.'")';
        $this->db->where($where);
        $offer_product_data = $this->db->get();
        $data_offer_product = $offer_product_data->result_array(); 
        $data_offer_product_count = $offer_product_data->num_rows();

        $pdf = new Offer2_pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        // $pdf->SetPrintHeader(true);
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 30, PDF_MARGIN_RIGHT);
        // $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        

        // set default header data
        // $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
                
        // set auto page breaks
        // $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM); //default
        $pdf->SetAutoPageBreak(TRUE, 50);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set font
        $pdf->SetFont('dejavusans', '', 10);

        $path_img = getcwd();
        $path = getcwd();
       
        $year = date('Y'); // You may need to adjust this based on your academic year
        $formatted_date = date('Y-m-d-H:i:s');
      
        // Construct the filename based on the offer number
        $filename = $path . "/assets/offer_attachment/" . str_replace('/', '_', $offer_no) . ".pdf";

        // Output the PDF file
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($filename) . '"');


        $pdf->AddPage();

		// $image_file = K_PATH_IMAGES.'intact_logo.png';
		// $pdf->Image($image_file, 30, 100, 150, 120, 'PNG', '', '', false, 0, '', false, false, 0);

		$html = '<h2 style="text-align: left;color:#3167ac; font-size:10px;">Quotation </h2><br><br>
                    <table align="left" style="margin-right:auto;margin-left:0px;float: left;">
                    <tbody>
                        <tr style="line-height:150%;">
                            <td style="text-align: left;color:#3167ac; font-size:10px;width:7%; text-indent:0.0em;"><strong>Type</strong><br><b>Series</b> </td>
							<td style="color:#3167ac; font-size:10px;width:60%;"><b><span style="font-size:10px;color: black;">' . strip_tags($Offer_for_name) . '</span><br><span style="font-size:10px;color: black;">' . strip_tags($Offer_for_info_name) . ' </span></b> </td>
                            <td style="font-size: 10px; width: 15%;text-align:left;"> <b style="color: #3167ac;">Submitted on<br>&nbsp;Quotation No</b></td>

							<td style="color:#3167ac; font-size:10px;width:18%;"><b><span style="font-size:10px;color: black;">' . strip_tags($offer_date) . '</span><br><span style="font-size:10px;color: black;">' . strip_tags($offer_no) . '</span></b> </td>
                        </tr>
                      
                    </tbody>
                </table>';

         $pdf->writeHTML($html, true, false, true, false, ''); 
        

            $html = '<br><h2 style="text-align: left;color:#3167ac; font-size:10px;">Quotation For </h2>

						 <table>
                    <tbody>
                        <tr style="line-height:200%;">
                            <td style="color:black; font-size:10px;width:12%;"><b>Company</b><br><b>Name</b><br><b>Contact No</b><br><b>Email Id</b> </td>
							<td style="color:#3167ac; font-size:10px;width:55%;"><span style="font-size:10px;color: black;">'.strip_tags($customer_name).'</span><br><span style="font-size:10px;color: black;">'.strip_tags($contact_person_name).'</span><br><span style="font-size:10px;color: black;">'.strip_tags($contact_no1).'</span><br><span style="font-size:10px;color: black;">'.strip_tags($email).'</span></td>
                            <td style="font-size: 10px; width: 18%;text-align:left;"> <b style="color: black;">RM Name<br>&nbsp;RM Contact No<br>&nbsp;CRM Name<br>&nbsp;CRM Contact No</b></td>

							<td style="color:#3167ac; font-size:10px;width:15%;"><span style="font-size:10px;color: black;">'. strip_tags($rm_name) . '</span><br><span style="font-size:10px;color: black;">'. strip_tags($rm_contact_no) . '</span><br><span style="font-size:10px;color: black;">'. strip_tags($crm_name) . '</span><br><span style="font-size:10px;color: black;">'. strip_tags($crm_contact_no) . '</span></td>
                        </tr>
                      
                    </tbody>
                </table>
						
				<br>
        <hr style="width: 100%;color:#3167ac; height: 1px;">';

        $pdf->writeHTML($html, true, false, true, false, ''); 

    
        $all_product_total = 0;
        $all_product_sub_total = 0;
        $all_product_gst = 0;
        $Quotation_amount = 0;
        foreach ($data_offer_product as $value_data)
        {   
                       
            $product_price_format = $value_data['price'];
            $product_price = number_format((float)$product_price_format, 2, '.', '');
            $product_qty = $value_data['rfq_qty'];

            $total_format = $product_price * $product_qty;

            $total = number_format((float)$total_format, 2, '.', '');

            $all_product_total += $total;

            $all_product_total = number_format((float)$all_product_total, 2, '.', '');

            $amount_without_gst_format = $value_data['total_amount_without_gst'];
            $amount_without_gst = number_format((float)$amount_without_gst_format, 2, '.', '');

            $all_product_sub_total += $amount_without_gst;

            $all_product_sub_total = number_format((float)$all_product_sub_total, 2, '.', '');

            }

        $html = '<br>

<table>
                    <tbody>
                        <tr style="line-height:150%;">
                            <td style="color:#3167ac; font-size:10px;width:7%;"> </td>
														 <td style="color:#3167ac; font-size:10px;width:60%;"></td>
                            <td style="font-size: 10px; width: 15%;text-align:left;"> <b style="color:black;">GRAND  TOTAL</b></td>

														<td style="color:#3167ac; font-size:10px;width:18%;"><b><span style="font-size:10px;color: black;">₹ ' . strip_tags(number_format($all_product_sub_total,"2",".",",")) . '</span></b> </td>
                        </tr>
                      
                    </tbody>
                </table>


            <br>
        <hr style="width: 100%;color:#3167ac; height: 1.5px;">';
        $pdf->writeHTML($html, true, false, true, false, ''); 

     
        $i = 1;
        $j = 1;


        if($data_offer_product_count > 0)
        {
            $html = '
                    <p style="font-size: 9px;  text-indent:2em; color:#3167ac; width: 100%;"><b>PRICE BREAKUP AS BELOW - </b></p>

                    <table border="solid 1px" cellpadding="5" width="100%">
                        <thead><tr>
                            <th style="font-size: 8px; width: 5%; color:#3167ac; text-align: center; border-right: solid 1px #5a5a5a; 
                            border-left: solid 1px #5a5a5a;border-top: solid 1px #5a5a5a;  border-bottom: solid 1px #5a5a5a; text-indent:2em;"><b>Sr.<br>No.</b></th>

                            
                            <th style="font-size: 8px; width: 35%; color:#3167ac; text-align: center; border-right: solid 1px #5a5a5a; 
                            border-left: solid 1px #5a5a5a;border-top: solid 1px #5a5a5a;  border-bottom: solid 1px #5a5a5a;text-indent:2em;"><b> Description</b></th>

                            <th style="font-size: 8px; width: 10%; text-indent:2em;border-right: solid 1px #5a5a5a; 
                            border-left: solid 1px #5a5a5a;border-top: solid 1px #5a5a5a;  border-bottom: solid 1px #5a5a5a; color:#3167ac; text-align: left;"><b>Part No.</b></th>


                            <th style="font-size: 8px; width: 7%; text-indent:2em; border-right: solid 1px #5a5a5a; 
                            border-left: solid 1px #5a5a5a;border-top: solid 1px #5a5a5a;   border-bottom: solid 1px #5a5a5a; color:#3167ac; text-align: center;"><b>Qty</b></th>

                            <th style="font-size: 8px; width: 12%; text-indent:2em;border-right: solid 1px #5a5a5a; 
                            border-left: solid 1px #5a5a5a;border-top: solid 1px #5a5a5a; border-bottom: solid 1px #5a5a5a; color:#3167ac; text-align: center;"><b>Stock Avaliability</b></th>

                            <th style="font-size: 8px; width: 12%; text-indent:0em; border-right: solid 1px #5a5a5a; 
                            border-left: solid 1px #5a5a5a;border-top: solid 1px #5a5a5a; border-bottom: solid 1px #5a5a5a;color:#3167ac; text-align: center;"><b> Discounted Unit Price</b></th>

                            <th style="font-size: 8px; width: 12%; text-indent:0em;border-right: solid 1px #5a5a5a; 
                            border-left: solid 1px #5a5a5a;border-top: solid 1px #5a5a5a;   border-bottom: solid 1px #5a5a5a; color:#3167ac; text-align: center;"><b>Discounted Total Price </b></th>
                            <th style="font-size: 8px; width: 8%; text-indent:0em;border-right: solid 1px #5a5a5a; 
                            border-left: solid 1px #5a5a5a;border-top: solid 1px #5a5a5a;   border-bottom: solid 1px #5a5a5a; color:#3167ac; text-align: center;"><b>Delivery Period</b></th>

                        </tr></thead><tbody>';
                    foreach ($data_offer_product as $value_data)
                    {   
                        $product_name = $value_data['product_name'];
                        $product_custom_part_no = $value_data['product_custom_part_no'];
                        $product_custom_description = $value_data['product_custom_description'];
                        $delivery_period = $value_data['delivery_period'];
                        $product_price_format = $value_data['price'];
                        $product_price = number_format((float)$product_price_format, 2, '.', '');
                        $product_unit = $value_data['unit'];
                        $product_qty = $value_data['rfq_qty'];

                        $total_format = $product_price * $product_qty;

                        $total = number_format((float)$total_format, 2, '.', '');

                        $all_product_total += $total;

                        $all_product_total = number_format((float)$all_product_total, 2, '.', '');

                        $PRODUCT_ID = $value_data['PRODUCT_ID'];

                        $product_make = $value_data['product_make'];

                        $remark = $value_data['remark'];

                        $amount_without_gst_format = $value_data['total_amount_without_gst'];
                        $amount_without_gst = number_format((float)$amount_without_gst_format, 2, '.', '');

                        $all_product_sub_total += $amount_without_gst;

                        $all_product_sub_total = number_format((float)$all_product_sub_total, 2, '.', '');

                      

                        $hsn_code = $value_data['Hsn_code'];
                        $discount = $value_data['discount'];
                        $discount_amt = $value_data['unit_discounted_price'];

                        $discount_amt_format = $value_data['unit_discounted_price'];
                        $discount_amt = number_format((float)$discount_amt_format, 2, '.', '');

                        /*$total_amount_with_gst = $value_data['total_amount_with_gst'];*/

                        // $total_amount_with_gst = $all_gst + $amount_without_gst;

                        $Quotation_amount += $amount_without_gst;
                        $Quotation_amount = number_format((float)$Quotation_amount, 2, '.', '');

                        $html .='<tr>
                                        <td style="font-size: 7.8px;color:black; text-align: center; width: 5%; border-right: solid 1px #5a5a5a; 
                                        border-left: solid 1px #5a5a5a;border-top: solid 1px #5a5a5a;  border-bottom: solid 1px #5a5a5a;text-indent:2em;">'.strip_tags($i).'</td>

                                        <td style="font-size: 7.8px; width: 35%;color:black; border-right: solid 1px #5a5a5a; 
                                        border-left: solid 1px #5a5a5a;border-top: solid 1px #5a5a5a;  border-bottom: solid 1px #5a5a5a; text-align: left;">'.strip_tags($product_custom_description).'</td>

                                        
                                        <td style="font-size: 7.8px;color:black; width: 10%; text-indent:2em;border-right: solid 1px #5a5a5a; 
                                        border-left: solid 1px #5a5a5a;border-top: solid 1px #5a5a5a;  border-bottom: solid 1px #5a5a5a; text-align: left;">'.strip_tags($product_custom_part_no).'</td>


                                        <td style="font-size: 7.8px;color:black; width: 7%; border-right: solid 1px #5a5a5a; 
                                        border-left: solid 1px #5a5a5a;border-top: solid 1px #5a5a5a;  border-bottom: solid 1px #5a5a5a;text-indent:2em;">&nbsp;'.strip_tags($product_qty).'</td>

                                        <td style="font-size: 7.8px;color:black; width: 12%;border-right: solid 1px #5a5a5a; 
                                        border-left: solid 1px #5a5a5a;border-top: solid 1px #5a5a5a;  border-bottom: solid 1px #5a5a5a; text-indent:2em;">&nbsp;</td>

                
                                        <td style="font-size: 7.8px;color:black; width: 12%; text-indent:2em;border-right: solid 1px #5a5a5a; 
                                        border-left: solid 1px #5a5a5a;border-top: solid 1px #5a5a5a;  border-bottom: solid 1px #5a5a5a; text-align:right;">'.strip_tags($discount_amt).'</td>

                                        <td style="font-size: 7.8px;color:black; width: 12%; text-indent:2em; border-right: solid 1px #5a5a5a; 
                                        border-left: solid 1px #5a5a5a;border-top: solid 1px #5a5a5a;  border-bottom: solid 1px #5a5a5a;text-align:right;">'.strip_tags($amount_without_gst).'</td>

                                        <td style="font-size: 7.8px;color:black; width: 8%; text-indent:2em; border-right: solid 1px #5a5a5a; 
                                        border-left: solid 1px #5a5a5a;border-top: solid 1px #5a5a5a;  border-bottom: solid 1px #5a5a5a;text-align:right;">'.strip_tags($delivery_period).'</td>

                                    </tr>';
                        $i++;   
                    }

                    for ($i = $data_offer_product_count; $i < 2; $i++) 
                    { 
                        $html .='<tr>                                   
                                        <td style="width: 8%; font-size: 7px; text-indent:2em;"></td>
                                        <td style="width: 35%;">&nbsp;</td>
                                        <td style="width: 12%;">&nbsp;</td>
                                        <td style="width: 7%;">&nbsp;</td>
                                        <td style="width: 12%;">&nbsp;</td>
                                        <td style="width: 12%;">&nbsp;</td>
                                        <td style="width: 12%;">&nbsp;</td>
                                    </tr>'; 
                    }

										$html .= '</tbody></table>';

										$terms_explode = explode(";",$Terms_conditions);
										$html .= '
                    <br><p style="font-size: 9px;  text-indent:2em; color:#3167ac; width: 100%;"><b>TERMS AND CONDITIONS</b></p><div  style="font-size: 9px;color:black; width: 100%; text-align: left;">';
										foreach($terms_explode as $terms){
											$html .= '<span style="line-height:20%;">&nbsp;&nbsp;&nbsp;'.strip_tags($terms)."</span><br>";
										}

										$html.= '</div>';
                    
                    $pdf->writeHTML($html, true, false, true, false, '');
        }

        
        $pdf->Output($filename, 'I');
       // $pdf->Output('offer'.date('Y-m-d-H:i:s').'.pdf', 'I');        
    }
    
    public function download_offer_1()
    {
        ob_start();
        $entity_id = $this->uri->segment(2);

        $en_id=$this->db->select('enquiry_id')->from('offer_register')->where('entity_id',$entity_id)->get()->row_array();
        $id=$en_id['enquiry_id'];
        if ($id == NUll) {
            $enquiry_nm= "NA";
            $enquiry_date= "NA";
        }else{
            $ml_id = $this->db->select('enquiry_no,enquiry_date')->from('enquiry_register')->where('entity_id',$id)->get()->row_array();
            $enquiry_nm = $ml_id['enquiry_no'];
        $enquiry_date = date("d-m-Y",strtotime($ml_id['enquiry_date']));
            
        }
        $this->db->select('customer_master.customer_name AS Customer_name,
                          customer_master.entity_id AS Customer_id,
                          customer_master.address AS Customer_address,
                          customer_master.pin_code AS Pin_code,
                          customer_master.gst_no AS Gst_no,
                          customer_master.state_code AS State_code,
                          offer_register.entity_id AS Entity_id,
                          offer_register.offer_no AS Offer_no,
                          offer_register.offer_description AS Offer_description,
                          offer_register.offer_engg_name AS Offer_engg_name,
                          offer_register.offer_date AS Offer_date,
                          offer_register.offer_close_date AS Offer_close_date,
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
                          offer_register.special_packing,
                          offer_register.salutation AS Salutation,
                          offer_register.price_basis AS Price_basis,
                          offer_register.transport_insurance AS Transport_insurance,
                          offer_register.tax AS Tax,
                          offer_register.delivery_schedule AS Delivery_schedule,
                          offer_register.mode_of_payment AS Mode_of_payment,
                          offer_register.mode_of_transport AS Mode_of_transport,
                          offer_register.guarantee_warrenty AS Guarantee_warrenty,
                          offer_register.validity AS Validity,
                          offer_register.your_reference AS Your_reference,
                          offer_register.contact_person_id AS Contact_id,
                          offer_register.offer_company_name AS offer_company_name,
                          employee_master.emp_first_name AS Emp_first_name,
                          employee_master.emp_middle_name AS Emp_middle_name,
                          employee_master.emp_last_name AS Emp_last_name,
                          employee_master.mobile_no AS Mobile_no,
                          state_master.state_name AS State_name');
        $this->db->from('offer_register');
        $this->db->join('customer_master', 'customer_master.entity_id = offer_register.customer_id', 'INNER');
        $this->db->join('employee_master', 'offer_register.offer_engg_name = employee_master.entity_id', 'INNER');
        $this->db->join('state_master', 'customer_master.state_id = state_master.entity_id', 'INNER');
        $where = '(offer_register.entity_id = "'.$entity_id.'")';
        $this->db->where($where);
        $query_master_offer_data = $this->db->get();
        $master_offer_data = $query_master_offer_data->result_array();

        $offer_company_name = $master_offer_data[0]['offer_company_name'];

        $customer_id = $master_offer_data[0]['Customer_id'];
        $Contact_id = $master_offer_data[0]['Contact_id'];

        $this->db->select('customer_contact_master.contact_person AS Contact_person_name,
        customer_contact_master.email_id AS Customer_email_id,
        customer_contact_master.first_contact_no AS Contact_no,');
        $this->db->from('customer_contact_master');
        $where = '(customer_contact_master.entity_id = "'.$Contact_id.'")';
        $this->db->where($where);
        $customer_contact_master = $this->db->get();
        $customer_contact_master_result = $customer_contact_master->row_array();

        $contact_person_name = $customer_contact_master_result['Contact_person_name'];
        $email = $customer_contact_master_result['Customer_email_id'];
        $contact_no1 = $customer_contact_master_result['Contact_no'];
        
        $offer_no = $master_offer_data[0]['Offer_no'];
        $enquiry_no = $enquiry_nm;

        $Pin_code = $master_offer_data[0]['Pin_code'];
        $Gst_no = $master_offer_data[0]['Gst_no'];
        $State_code = $master_offer_data[0]['State_code'];
        $State_name = $master_offer_data[0]['State_name'];
        
        
        $offer_description = $master_offer_data[0]['Offer_description'];

        $special_packing = $master_offer_data[0]['special_packing'];

        $offer_description_limited = substr($offer_description, 0, 100);

        $date_of_offer = $master_offer_data[0]['Offer_date'];
        $offer_date = date("d-m-Y",strtotime($date_of_offer));

        $date_of_offer_close = $master_offer_data[0]['Offer_close_date'];
        $offer_close_date = date("d-m-Y",strtotime($date_of_offer_close));

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
        
        if(!empty($offer_company_name))
        {
            $customer_name = $offer_company_name;
        }else{
            $customer_name = $master_offer_data[0]['Customer_name'];
        }
        
        $Validity = $master_offer_data[0]['Validity'];
        $Customer_address = $master_offer_data[0]['Customer_address'];
        
        $Delivery_instruction = $master_offer_data[0]['Delivery_instruction'];
        $Offer_freight = $master_offer_data[0]['Offer_freight'];

        $price_condition = $master_offer_data[0]['price_condition'];
        if($price_condition == 1)
        {
            $PC = "Ex Works VBTEK";
        }elseif($price_condition == 2)
        {
            $PC = "FOR Site";
        }elseif($price_condition == 3)
        {
            $PC = "Other- Please refer note";
        }else{
            $PC = "NA";
        }
        
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

        $this->db->select('offer_product_relation.*,
            product_make_master.make_name AS product_make,
            product_master.product_id AS PRODUCT_ID,
            product_master.product_name,
            unit_master.unit_name AS unit,
            product_hsn_master.hsn_code AS Hsn_code');
        $this->db->from('offer_product_relation');
        $this->db->join('product_master', 'offer_product_relation.product_id = product_master.entity_id', 'INNER');
        $this->db->join('unit_master', 'product_master.unit = unit_master.entity_id', 'INNER');
        $this->db->join('product_make_master', 'offer_product_relation.product_make = product_make_master.entity_id', 'INNER');
        $this->db->join('product_hsn_master', 'product_master.hsn_id = product_hsn_master.entity_id', 'INNER');
        $where = '(offer_product_relation.offer_id = "'.$entity_id.'")';
        $this->db->where($where);
        $offer_product_data = $this->db->get();
        $data_offer_product = $offer_product_data->result_array(); 
        $data_offer_product_count = $offer_product_data->num_rows();

        //print_r($data_offer_product_count);
        //die();
        //$location_id = $_SESSION['location_id'];

        $pdf = new Offer_pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        /*$pdf->SetPrintHeader(false);*/
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
                
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set font
        $pdf->SetFont('dejavusans', '', 10);

        $path_img = getcwd();
        $path = getcwd();
        /*$filename = $_SERVER['DOCUMENT_ROOT']."bluboxx_sales_crm/assets/offer_attachment/"."Offer_Details-".date('Y-m-d-H:i:s').".pdf";*/

        /*$filename = $path."/assets/offer_attachment/"."Offer_Details-".date('Y-m-d-H:i:s').".pdf";*/
        $Company_logo = $path_img."/assets/company_logo/logo.png";
        $location = $path_img."/assets/login/location.jpg";
        $mail = $path_img."/assets/login/mail.png";
        $website = $path_img."/assets/login/website.png";
        $sign = $path_img."/assets/company_logo/sign.png";

        $pdf->AddPage();

        $html = '<br><br><br><br><h2 style="text-align: center; font-size:10px;">QUOTATION </h2>
                    <table style="border:0.9px solid black;" cellpadding="3" width="100%">
                    <tbody>
                        <tr>
                            <td style="font-size: 7px; border-bottom: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black; text-indent:2em; width: 50%;"><br><br><b>&nbsp;&nbsp;To,<br>&nbsp;&nbsp;'.strip_tags($customer_name).'</b><br><b>&nbsp;&nbsp;</b>'.getAddress($Customer_address,60,2).'<br><b>&nbsp;&nbsp;Contact Person :- </b>&nbsp;&nbsp;'.strip_tags($contact_person_name).'<br><b>&nbsp;&nbsp;Contact Number :- </b>&nbsp;&nbsp;'.strip_tags($contact_no1).'<br><b>&nbsp;&nbsp;Email id :- </b>&nbsp;&nbsp;'.strip_tags($email).'
                            </td>
                            <td style="font-size: 7px; border-bottom: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black; text-indent:2em; width: 50%;"><br><br><b>&nbsp;&nbsp;Offer Number - </b>'.strip_tags($offer_no).'
                                <br><b>&nbsp;&nbsp;Offer Date - </b>'.strip_tags($offer_date).'<b>&nbsp;&nbsp;&nbsp;&nbsp;Offer Close Date - </b>'.strip_tags($offer_close_date).'
                                <br><b>&nbsp;&nbsp;Enquiry Number - </b>'.strip_tags($enquiry_no).'<b>&nbsp;&nbsp;Enquiry Date - </b>'.strip_tags($enquiry_date).'
                                <br><b>&nbsp;&nbsp;Sales Person - </b>'.strip_tags($Full_name).'
                                <br><b>&nbsp;&nbsp;Sales Contact Number - </b>'.strip_tags($Phone_number).'
                                <br><b>&nbsp;&nbsp;Sales Person Email Id - </b>'.strip_tags($Email_id).'
                                <br>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 7px; border-bottom: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black; text-indent:2em; width: 100%;"><b>&nbsp;&nbsp;Subject - </b>'.strip_tags($offer_description_limited).'</td>
                        </tr>
                    </tbody>
                </table>';

        $pdf->writeHTML($html, true, false, true, false, ''); 

        $total_gst_product_taxable_amount = 0;
        $total_gst_product_taxable_amount_format = 0;

        $final_gst_product_amount_with_gst = 0;
        $final_gst_product_amount_with_gst_format = 0; 

        $product_gst_amount=0;
        $product_gst_amount_format=0;  
                   
        $i = 1;
        $j = 1;

        $total_gst_service_taxable_amount = 0;
        $total_gst_service_taxable_amount_format = 0;

        $final_gst_service_amount_with_gst = 0;
        $final_gst_service_amount_with_gst_format = 0; 

        $service_gst_amount=0;
        $service_gst_amount_format=0;

        if($data_offer_product_count > 0)
        {
            $html = '
                    <p style="font-size: 7px;  text-indent:2em; width: 100%;">'.breakSalutation($Salutation,15).'</p>

                    <table cellpadding="3" width="100%">
                        <tr style="background-color: #b0c4de;">
                            <td style="font-size: 6.5px; width: 5%; text-align: center; text-indent:2em;"><b>Sr.<br>&nbsp;&nbsp;&nbsp;No</b></td>

                            <td style="font-size: 6.5px; width: 8%; text-indent:2em; text-align: left;"><b>HSN<br>&nbsp;&nbsp;&nbsp;Code</b></td>

                            <td style="font-size: 6.5px; width: 8%; text-indent:2em; text-align: left;"><b>Part<br>&nbsp;&nbsp;&nbsp;Number</b></td>

                            <td style="font-size: 6.5px; width: 29%; text-align: center; text-indent:2em;"><b>Product Details</b></td>

                             <td style="font-size: 6.5px; width: 6%; text-align: center; text-indent:2em;"><b>Make</b></td>

                            <td style="font-size: 6.5px; width: 5%; text-indent:2em; text-align: center;"><b>Qty</b></td>

                            <td style="font-size: 6.5px; width: 5%; text-indent:2em; text-align: center;"><b>Unit</b></td>

                            <td style="font-size: 6.5px; width: 8%; text-indent:2em; text-align: center;"><b>Price Per<br>&nbsp;&nbsp;&nbsp;Unit INR</b></td>

                            <td style="font-size: 6.5px; width: 9%; text-indent:2em; text-align: center;"><b>Discounted<br>&nbsp;&nbsp;&nbsp;Price Per<br>&nbsp;&nbsp;&nbsp;Unit</b></td>

                            <td style="font-size: 6.5px; width: 8%; text-indent:2em; text-align: center;"><b>Total</b></td> 

                            <td style="font-size: 6.5px; width: 9%; text-indent:2em; text-align: center;"><b>GST<br>&nbsp;&nbsp;</b></td>

                        </tr>
                    </table>';
                    $all_product_total = 0;
                    $all_product_sub_total = 0;
                    $all_product_gst = 0;
                    $Quotation_amount = 0;
                    foreach ($data_offer_product as $value_data)
                    {   
                        $product_name = $value_data['product_name'];
                        $product_custom_description = $value_data['product_custom_description'];
                        $product_price_format = $value_data['price'];
                        $product_price = number_format((float)$product_price_format, 2, '.', '');
                        $product_unit = $value_data['unit'];
                        $product_qty = $value_data['rfq_qty'];

                        $total_format = $product_price * $product_qty;

                        $total = number_format((float)$total_format, 2, '.', '');

                        $all_product_total += $total;

                        $all_product_total = number_format((float)$all_product_total, 2, '.', '');

                        $PRODUCT_ID = $value_data['PRODUCT_ID'];

                        $product_make = $value_data['product_make'];

                        $remark = $value_data['remark'];

                        $amount_without_gst_format = $value_data['total_amount_without_gst'];
                        $amount_without_gst = number_format((float)$amount_without_gst_format, 2, '.', '');

                        $all_product_sub_total += $amount_without_gst;

                        $all_product_sub_total = number_format((float)$all_product_sub_total, 2, '.', '');

                        $cgst_percentage = $value_data['cgst_discount'];
                        $cgst_amount_format = $value_data['cgst_amt'];
                        $cgst_amount = number_format((float)$cgst_amount_format, 2, '.', '');

                        $sgst_percentage = $value_data['sgst_discount'];
                        $sgst_amount_format = $value_data['sgst_amt'];
                        $sgst_amount = number_format((float)$sgst_amount_format, 2, '.', '');

                        $igst_percentage = $value_data['igst_discount'];
                        $igst_amount_format = $value_data['igst_amt'];
                        $igst_amount = number_format((float)$igst_amount_format, 2, '.', '');

                        $all_gst = $cgst_amount + $sgst_amount + $igst_amount;

                        $all_product_gst += $all_gst;

                        $all_product_gst = number_format((float)$all_product_gst, 2, '.', '');

                        if($igst_percentage == 0)
                        {
                            $product_gst_rate = $sgst_percentage + $cgst_percentage;
                        }else{
                            $product_gst_rate = $igst_percentage;
                        }

                        $hsn_code = $value_data['Hsn_code'];
                        $discount = $value_data['discount'];
                        $discount_amt = $value_data['unit_discounted_price'];

                        $discount_amt_format = $value_data['unit_discounted_price'];
                        $discount_amt = number_format((float)$discount_amt_format, 2, '.', '');

                        /*$total_amount_with_gst = $value_data['total_amount_with_gst'];*/

                        $total_amount_with_gst = $all_gst + $amount_without_gst;

                        $Quotation_amount += $total_amount_with_gst;
                        $Quotation_amount = number_format((float)$Quotation_amount, 2, '.', '');

                        $html .='<table cellpadding="3" width="100%">
                                    <tr>
                                        <td style="font-size: 6.5px; text-align: center; width: 5%; text-indent:2em;">'.strip_tags($i).'</td>

                                        <td style="font-size: 6.5px; width: 8%; text-indent:2em; text-align: left;">'.strip_tags($hsn_code).'</td>

                                        <td style="font-size: 6.5px; width: 8%; text-indent:2em; text-align: left;">'.strip_tags($PRODUCT_ID).'</td>

                                        <td style="font-size: 6.5px; width: 29%; text-indent:2em; text-align: left;">'.strip_tags($product_custom_description).'<br>&nbsp;&nbsp;&nbsp;'.strip_tags($product_name).'</td>

                                        <td style="font-size: 6.5px; width: 6%; text-indent:2em;">'.strip_tags($product_make).'</td>

                                        <td style="font-size: 6.5px; width: 5%; text-indent:2em;">&nbsp;'.strip_tags($product_qty).'</td>

                                        <td style="font-size: 6.5px; width: 5%; text-indent:2em;">&nbsp;'.strip_tags($product_unit).'</td>

                                        <td style="font-size: 6.5px; width: 8%; text-indent:2em; text-align:right;">'.strip_tags($product_price).'</td>
                
                                        <td style="font-size: 6.5px; width: 9%; text-indent:2em; text-align:right;">'.strip_tags($discount_amt).'</td>

                                        <td style="font-size: 6.5px; width: 8%; text-indent:2em; text-align:right;">'.strip_tags($amount_without_gst).'</td>

                                        <td style="font-size: 6.5px; width: 9%; text-indent:2em; text-align:right;">'.strip_tags($product_gst_rate).'%'.'</td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 6.5px; text-align: left; width: 100%; text-indent:2em; color: #FF0000;"> Note : '.strip_tags($remark).'</td>
                                    </tr>
                                </table>';
                        $i++;   
                    }
                    for ($i = $data_offer_product_count; $i < 4; $i++) 
                    { 
                        $html .='<table  cellpadding="0.5" cellspacing="0" width="100%"> 
                                    <tr>                                   
                                        <td style="width: 5%; font-size: 7px; text-indent:2em;"></td>
                                        <td style="width: 8%;">&nbsp;</td>
                                        <td style="width: 8%;">&nbsp;</td>
                                        <td style="width: 23%;">&nbsp;</td>
                                        <td style="width: 6%;">&nbsp;</td>
                                        <td style="width: 5%;">&nbsp;</td>
                                        <td style="width: 5%;">&nbsp;</td>
                                        <td style="width: 8%;">&nbsp;</td>
                                        <td style="width: 9%;">&nbsp;</td>
                                        <td style="width: 8%;">&nbsp;</td>
                                        <td style="width: 9%;">&nbsp;</td>
                                    </tr>
                                </table>'; 
                    }
                    $html .='<table cellpadding="3" width="100%"> 
                                <tr>
                                    <td style="width: 90%; font-size: 6.5px; text-align:right;"><b> Total</b></td>
                                    <td style="width: 10%; font-size: 6.5px; text-align:right;"><b>'.strip_tags($all_product_total).'</b></td>
                                </tr>
                                <tr>
                                    <td style="width: 90%; font-size: 6.5px; text-align:right;"><b> Sub Total</b></td>
                                    <td style="width: 10%; font-size: 6.5px; text-align:right;"><b>'.strip_tags($all_product_sub_total).'</b></td>
                                </tr>
                                <tr>
                                    <td style="width: 90%; font-size: 6.5px; text-align:right;"><b> GST (Goods and Service Tax )</b></td>
                                    <td style="width: 10%; font-size: 6.5px; text-align:right;"><b>'.strip_tags($all_product_gst).'</b></td>
                                </tr>

                                <tr style="background-color: #b0c4de;">
                                    <td style="width: 90%; font-size: 6.5px; text-align:right;"><b> Grand Total</b></td>
                                    <td style="width: 10%; font-size: 6.5px; text-align:right;"><b>'.strip_tags($Quotation_amount).'</b></td>
                                </tr>

                                
                            </table>'; 
                    $pdf->writeHTML($html, true, false, true, false, '');
        }


        $Total_Amount_format =  $final_gst_product_amount_with_gst + $final_gst_service_amount_with_gst; 

        $Total_Amount = number_format((float)$Total_Amount_format, 2, '.', '');

        $this->load->library('numbertowordconvertsconver');
        $Final_invoice_amount_in_word = $this->numbertowordconvertsconver->convert_number($final_gst_product_amount_with_gst);

        $P_amount = amountFormat($final_gst_product_amount_with_gst);
        if(empty($P_amount))
        {
            $F_P_Amount = strip_tags($final_gst_product_amount_with_gst);
        }else{
            $F_P_Amount = amountFormat($final_gst_product_amount_with_gst);
        }

        $S_amount = amountFormat($final_gst_service_amount_with_gst);
        if(empty($S_amount))
        {
            $F_S_Amount = strip_tags($final_gst_service_amount_with_gst);
        }else{
            $F_S_Amount = amountFormat($final_gst_service_amount_with_gst);
        }

        $T_amount = amountFormat($Total_Amount);
        if(empty($T_amount))
        {
            $T_amt = strip_tags($Total_Amount);
        }else{
            $T_amt = amountFormat($Total_Amount);
        }


        $html = '<table style="border:0.9px solid black; width:100%;"  cellpadding="0">
                    <tr style="line-height:18px;">
                        <td style="font-size: 9px; width: 100%;"  >
                           <b>Terms & Conditions</b>
                        </td>
                    </tr>';

            $html .='<tr>  
                        <td  style="font-size: 7px;  width:25%;"> 
                            Price Condition:
                        </td>    
                        <td style="font-size: 7px;  width:75%;">    
                            '.strip_tags($PC).'
                        </td>
                    </tr>';
            
            $html .='<tr>  
                        <td  style="font-size: 7px;  width:25%;"> 
                            Freight charges:
                        </td>    
                        <td style="font-size: 7px;  width:75%;">    
                            '.strip_tags($Price_basis).'
                        </td>
                    </tr>';
            $html .='<tr>  
                        <td  style="font-size: 7px;  width:25%;"> 
                            Delivery
                        </td>
                        <td style="font-size: 7px;  width:75%;">      
                            '.strip_tags($Delivery_schedule).'
                        </td>    
                    </tr>';

            $html .='<tr>              
                        <td  style="font-size: 7px;  width:25%;">
                            Sales Tax:
                        </td>
                        <td style="font-size: 7px;  width:75%;">    
                            '.strip_tags($Tax).'
                        </td>
                  </tr>';

            $html .='<tr>             
                        <td  style="font-size: 7px;  width:25%;">
                           Payment:
                        </td> 
                        <td style="font-size: 7px;  width:75%;"> 
                           '.strip_tags($payment_term).'
                        </td>
                    </tr>';

            $html .='<tr>              
                        <td  style="font-size: 7px;  width:25%;">
                           Validity
                        </td>
                        <td style="font-size: 7px;  width:75%;">    
                            '.strip_tags($Validity).'
                        </td>
                    </tr>';

            $html .='<tr>              
                        <td  style="font-size: 7px;  width:25%;">
                            Warranty
                        </td>  
                        <td style="font-size: 7px;  width:75%;">        
                            '.strip_tags($Guarantee_warrenty).'
                        </td>
                    </tr>';
       
            $html .='</table>'; 

        $pdf->writeHTML($html, true, false, true, false, '');

        $html = '<table cellpadding="2" width="100%">
                        <tr>
                            <td style="font-size: 7.5px; width: 100%;"><b>Note 1 : </b> For Cable: Qty Tolerance +/- 10% in length.
                                For Communication Devices/ Routers: Quoted prices are EXCLUSIVE of power supply; connection cables; SIM cards; etc. unless it is specifically
                                mentioned
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 7.5px; width: 100%;"><b>Note 2 : </b> Any Onsite support or Installation/ Commissioning charges will be extra, separate offer for the same will be submitted.</td>
                        </tr>
                        <tr>
                            <td style="font-size: 7.5px; width: 100%;"><b>Note 3 : </b> Quoted Prices are worked out considering prevailing Duties; taxes; Levies; Surcharge. In case there is any statutory changes in the same
                                prices shall be adjusted accordingly.
                                We hope the quoted products are in line with your requirements. Feel free to contact us if you need any more info.
                                Look forward to receiving your valuable PO soon.
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 7.5px; width: 100%;"><b>Note 4 : </b> Once PO Accepted can not be cancelled .
                            </td>
                        </tr>
                     </table>';
        $pdf->writeHTML($html, true, false, true, false, '');

        $html = '<table cellpadding="2" width="100%">
                    <tr>
                        <td><h2 style="font-size: 10px;"><b>Bank Details for NEFT/RTGS:</b></h2>
                        </td>
                    </tr>
                    <tr COLSPAN=2>
                        <td style="width: 60%;">
                        <p style="font-size: 7.5px;  text-indent:2em;">Bank Name :  HDFC Bank
                        <br>Account Name : VB Digitech Pvt. Ltd.
                        <br>Account No : 50200018071706
                        <br>Account Type :  CC
                        
                        <br>Bank Branch Code:  633
                       
                        <br>IFSC No : HDFC0000633
                        <br>Bank Address : 934 Nana Peth, Rajveer Complex.Pune, MH- 411002
                        </p>
                        </td>
                        <td style="width: 40%; text-align:right;">
                            <h2 style="font-size: 8px;"><b>For VB Digitech Pvt. Ltd.</b></h2>

                        </td>
                    </tr>
                    <tr COLSPAN=2>
                        <td style="width: 75%; text-align:left;">
                            <h3 style="font-size: 10px;"><b>“This Document is computer generated. No signature is required”</b></h3>
                        </td>
                        <td style="width: 25%;">
                            <h3 style="font-size: 8px; text-align:right;"><b>VBTEK Sales<br> Mobile No: +91 7875432180</b></h3>
                        </td>
                    </tr>
                     </table>';
        $pdf->writeHTML($html, true, false, true, false, '');
        
        $pdf->AddPage();
        $html = '<br><br><br><br>
                    <h3 style="font-size: 10px;text-align:center;"><b><u>VBTEK Warranty Policy</u></b></h3>
                    <table cellpadding="2" width="100%">
                        <tr>
                            <td>
                                <p style="font-size: 9px;">We hereby guarantee satisfactory operation of the purchased product/ products for a period of <b>Agreed tenure</b> from the
                                    <b>date of dispatch.</b> We shall be responsible for failure of the material to conform to the standard of performance,
                                    proficiency and for any defects that may develop under proper use arising from the use of faulty materials, design or
                                    workmanship in the supply made and shall remedy such defects. Important Notice: SPARE PARTS, ACCESSORIES AND
                                    PERIPHERALS ARE NOT COVERED IN THE WARRANTY
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h3 style="font-size: 10px;"><b>Warranty does not cover:</b></h3>
                                <p>
                                    <ul style="font-size: 9px;">
                                        <li>Damage Physical</li>
                                        <li>Product out of Warranty period</li>
                                        <li>Damage caused by natural disasters, such as lightning strikes, floods and earthquakes</li>
                                        <li>Intentional or non-intentional deterioration affecting the equipment, whatever the cause</li>
                                        <li>Damage caused by accidents, misuse, improper installation or unauthorized repair</li>
                                        <li>Damage caused to the equipment, if not correctly operated/ handled</li>
                                        <li>Damage due to wrong connections or wiring</li>
                                        <li>Products with Illegible, removed, or damaged serial number label will not be covered</li>
                                        <li>Additional updating, reworking or testing requested by customers</li>
                                        <li>Any upgrading or testing requested by customers after the warranty period</li>
                                    </ul>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h3 style="font-size: 10px;"><b>For Faulty Products under Warranty:</b></h3>
                                <p style="font-size: 9px;">
                                    Products to be sent to VBTEK for inspection. VBTEK Engineer will first inspect the product. If needed products will be
                                    further sent to Principles for servicing or repair. To & Fro Freight Charges will be borne by VBTEK for under warranty
                                    products.
                                </p>
                                <p style="font-size: 9px;">
                                    If Product is found to be faulty <u>for terms not covered under warranty</u>Handling, Servicing, Repair, To & Fro Freight or any
                                        additional Charges will be borne by the customer.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h3 style="font-size: 10px;"><b>For Products NOT under Warranty:</b></h3>
                                <p style="font-size: 9px;">
                                    The Warranty Tenure of the product is defined from the date of the dispatch of the product. If Product is not covered under
                                    Warranty, Handling, Servicing, Repair, To & Fro Freight Charges will be borne by the customer.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h3 style="font-size: 10px;"><b>NPF (No Problem Found):</b></h3>
                                <p style="font-size: 9px;">
                                    If NPF is detected from merchandise, VBTEK reserves the right to have necessary charges.
                                </p>
                            </td>
                        </tr>
                         <tr>
                            <td>
                                <h3 style="font-size: 10px;"><b>Note:</b></h3>
                                <p style="font-size: 9px;">
                                    VBTEK has the right to destroy or recycle the product(s) to allay our storage costs without incurring any liability if
                                        customers do not respond to a request of the payment or return of goods within 60 days from the date of the request.
                                </p>
                                <p style="font-size: 9px;">
                                    VBTEK reserves the right to modify or cancel the policy at any time. Neither VBTEK nor any of its entities will be
                                    responsible for any damages caused by such modifications or cancellation.
                                </p>
                            </td>
                        </tr>
                    </table>';
        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output('offer'.date('Y-m-d-H:i:s').'.pdf', 'I');        
    }

    public function update_contact_person()
    {
        $customer_id = $this->input->post('customer_id');
        $enquiry_contact_person = $this->input->post('enquiry_contact_person');

        $update_array = array('customer_id' => $customer_id,'contact_person' => $enquiry_contact_person);
        $data = $this->offer_register_model->update_contact_person($update_array);

        echo json_encode($data);
    }

    public function update_contact_person_in_offer()
    {
        $offer_id = $this->input->post('offer_id');
        $contact_id = $this->input->post('contact_id');

        $update_contact_array = array(
            'contact_person_id ' => $contact_id
        );

        $this->db->where('entity_id', $offer_id);
        $data = $this->db->update('offer_register', $update_contact_array);

        echo json_encode($data);
    }

    public function update_email_id()
    {
        $customer_id = $this->input->post('customer_id');
        $enquiry_email_id = $this->input->post('enquiry_email_id');

        $update_array = array('customer_id' => $customer_id,'email_id' => $enquiry_email_id);
        $data = $this->offer_register_model->update_email_id($update_array);

        echo json_encode($data);
    }

    public function update_contact_no()
    {
        $customer_id = $this->input->post('customer_id');
        $enquiry_contact_number = $this->input->post('enquiry_contact_number');

        $update_array = array('customer_id' => $customer_id,'first_contact_no' => $enquiry_contact_number);
        $data = $this->offer_register_model->update_contact_no($update_array);

        echo json_encode($data);
    }

    public function save_offer_send_mail()
    {
        $offer_entity_id = $this->input->post('offer_entity_id');
        $enquiry_descrption = $this->input->post('enquiry_descrption');
        $employee_id = $this->input->post('employee_id');
        $salutation = $this->input->post('salutation');
        $offer_for = $this->input->post('offer_for');
        $offer_date = $this->input->post('offer_date');
        $offer_terms_condition = $this->input->post('offer_terms_condition');
        $offer_source = $this->input->post('offer_source');
       	$tax = $this->input->post('tax');
       	$price_condition = $this->input->post('price_condition');
        $your_reference = $this->input->post('your_reference');
        $validity = $this->input->post('validity');
        $offer_note = $this->input->post('offer_note');

        $mail_to = $this->input->post('mail_to');
        $mail_cc = $this->input->post('mail_cc');
        $mail_bcc = $this->input->post('mail_bcc');
        $offer_close_date = $this->input->post('offer_close_date');
        

        $this->db->select('*');
        $this->db->from('offer_register');
        $where = '(offer_register.entity_id = "'.$offer_entity_id.'" )';
        $this->db->where($where);
        $this->db->order_by('offer_register.entity_id', 'DESC');
        $this->db->limit(1);
        $query_data = $this->db->get();
        $query_result = $query_data->row_array();

        $offer_customer_id = $query_result['customer_id'];
        $enquiry_entity_id = $query_result['enquiry_id'];

        $offer_status = 2;

        $update_offer_array = array(
			'offer_description' => $enquiry_descrption , 
			'offer_engg_name' => $employee_id , 
			'offer_for' => $offer_for , 
			'offer_date' => $offer_date ,  
			'terms_conditions' => $offer_terms_condition ,  
			'offer_source' => $offer_source , 
			'validity' => $validity , 
			'note' => $offer_note , 
			'price_condition' => $price_condition, 
			'salutation' => $salutation, 
			'tax' => $tax, 
			'status' => $offer_status, 
			'your_reference' => $your_reference , 
			'offer_close_date' => $offer_close_date
		);

        $where = '(entity_id ="'.$offer_entity_id.'")';
        $this->db->where($where);
        $this->db->update('offer_register',$update_offer_array);

        $enquiry_status = 2;
		if($enquiry_entity_id){
        $update_enquiry_array = array('enquiry_status' => $enquiry_status);
        $where = '(entity_id ="'.$enquiry_entity_id.'")';
        $this->db->where($where);
        $this->db->update('enquiry_register',$update_enquiry_array);
		}


        $this->db->select('customer_master.customer_name AS Customer_name,
                          customer_master.entity_id AS Customer_id,
                          customer_master.address AS Customer_address,
                          customer_master.pin_code AS Pin_code,
                          customer_contact_master.contact_person AS Contact_person_name,
                          customer_contact_master.email_id AS Customer_email_id,
                          customer_contact_master.first_contact_no AS Contact_no,
                          customer_master.gst_no AS Gst_no,
                          customer_master.state_code AS State_code,
                          offer_register.entity_id AS Entity_id,
                          offer_register.offer_no AS Offer_no,
                          offer_register.offer_description AS Offer_description,
                          offer_register.offer_engg_name AS Offer_engg_name,
                          offer_register.offer_date AS Offer_date,
                          offer_register.offer_close_date AS Offer_close_date,
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
                          offer_register.special_packing,
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
        $this->db->join('employee_master', 'offer_register.offer_engg_name = employee_master.entity_id', 'INNER');
        $this->db->join('state_master', 'customer_master.state_id = state_master.entity_id', 'INNER');
        $where = '(offer_register.entity_id = "'.$offer_entity_id.'")';
        $this->db->where($where);
        $query_master_offer_data = $this->db->get();
        $master_offer_data = $query_master_offer_data->result_array();

        $customer_id = $master_offer_data[0]['Customer_id'];

        $this->db->select('customer_contact_master.contact_person AS Contact_person_name,
        customer_contact_master.email_id AS Customer_email_id,
        customer_contact_master.first_contact_no AS Contact_no,');
        $this->db->from('customer_contact_master');
        $where = '(customer_contact_master.customer_id = "'.$customer_id.'")';
        $this->db->where($where);
        $customer_contact_master = $this->db->get();
        $customer_contact_master_result = $customer_contact_master->row_array();

        $contact_person_name = $customer_contact_master_result['Contact_person_name'];
        $email = $customer_contact_master_result['Customer_email_id'];
        $contact_no1 = $customer_contact_master_result['Contact_no'];

        $offer_no = $master_offer_data[0]['Offer_no'];
        $enquiry_no = $master_offer_data[0]['enquiry_no'];

        $Pin_code = $master_offer_data[0]['Pin_code'];
        $Gst_no = $master_offer_data[0]['Gst_no'];
        $State_code = $master_offer_data[0]['State_code'];
        $State_name = $master_offer_data[0]['State_name'];
        $offer_description = $master_offer_data[0]['Offer_description'];

        $special_packing = $master_offer_data[0]['special_packing'];

        $offer_description_limited = substr($offer_description, 0, 100);

        $date_of_offer = $master_offer_data[0]['Offer_date'];
        $offer_date = date("d-m-Y",strtotime($date_of_offer));

        $date_of_offer_close = $master_offer_data[0]['Offer_close_date'];
        $offer_close_date = date("d-m-Y",strtotime($date_of_offer_close));

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
        
        $Customer_address = $master_offer_data[0]['Customer_address'];
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
        $where = '(offer_register.entity_id = "'.$offer_entity_id.'")';
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

        $this->db->select('offer_product_relation.*,
            product_master.unit,
            product_master.product_id AS PRODUCT_ID,
            product_master.product_name,
            product_hsn_master.hsn_code AS Hsn_code');
        $this->db->from('offer_product_relation');
        $this->db->join('product_master', 'offer_product_relation.product_id = product_master.entity_id', 'INNER');
        $this->db->join('product_hsn_master', 'product_master.hsn_id = product_hsn_master.entity_id', 'INNER');
        $where = '(offer_product_relation.offer_id = "'.$offer_entity_id.'")';
        $this->db->where($where);
        $offer_product_data = $this->db->get();
        $data_offer_product = $offer_product_data->result_array(); 
        $data_offer_product_count = $offer_product_data->num_rows();

        //print_r($data_offer_product_count);
        //die();
        //$location_id = $_SESSION['location_id'];

        $pdf = new Offer_pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        /*$pdf->SetPrintHeader(false);*/
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
                
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set font
        $pdf->SetFont('dejavusans', '', 10);

        $path_img = getcwd();
        $path = getcwd();
        /*$filename = $_SERVER['DOCUMENT_ROOT']."bluboxx_sales_crm/assets/offer_attachment/"."Offer_Details-".date('Y-m-d-H:i:s').".pdf";*/

        /*$filename = $path."/assets/offer_attachment/"."Offer_Details-".date('Y-m-d-H:i:s').".pdf";*/
        $filename = $path."/assets/offer_attachment/"."Offer_Details-".date('Y-m-d-H:i:s').".pdf";
        $Company_logo = $path_img."/assets/company_logo/logo.png";
        $location = $path_img."/assets/login/location.jpg";
        $mail = $path_img."/assets/login/mail.png";
        $website = $path_img."/assets/login/website.png";
        $sign = $path_img."/assets/company_logo/sign.png";

        $pdf->AddPage();

        $html = '<br><br><br><br><h2 style="text-align: center; font-size:10px;">QUOTATION </h2>
                    <table style="border:0.9px solid black;" cellpadding="3" width="100%">
                    <tbody>
                        <tr>
                            <td style="font-size: 7px; border-bottom: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black; text-indent:2em; width: 50%;"><br><br><b>&nbsp;&nbsp;To,<br>&nbsp;&nbsp;'.strip_tags($customer_name).'</b><br><b>&nbsp;&nbsp;</b>'.getAddress($Customer_address,60,2).'<br><b>&nbsp;&nbsp;Contact Person :- </b>&nbsp;&nbsp;'.strip_tags($contact_person_name).'<br><b>&nbsp;&nbsp;Contact Number :- </b>&nbsp;&nbsp;'.strip_tags($contact_no1).'<br><b>&nbsp;&nbsp;Email id :- </b>&nbsp;&nbsp;'.strip_tags($email).'
                            </td>
                            <td style="font-size: 7px; border-bottom: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black; text-indent:2em; width: 50%;"><br><br><b>&nbsp;&nbsp;Offer Number - </b>'.strip_tags($offer_no).'
                                <br><b>&nbsp;&nbsp;Offer Date - </b>'.strip_tags($offer_date).'<b>&nbsp;&nbsp;&nbsp;&nbsp;Offer Close Date - </b>'.strip_tags($offer_close_date).'
                                <br><b>&nbsp;&nbsp;Enquiry Number - </b>'.strip_tags($enquiry_no).'<b>&nbsp;&nbsp;Enquiry Date - </b>'.strip_tags($enquiry_date).'
                                <br><b>&nbsp;&nbsp;Sales Person - </b>'.strip_tags($Full_name).'
                                <br><b>&nbsp;&nbsp;Sales Contact Number - </b>'.strip_tags($Phone_number).'
                                <br><b>&nbsp;&nbsp;Sales Person Email Id - </b>'.strip_tags($Email_id).'
                                <br>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 7px; border-bottom: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black; text-indent:2em; width: 100%;"><b>&nbsp;&nbsp;Subject - </b>'.strip_tags($offer_description_limited).'</td>
                        </tr>
                    </tbody>
                </table>';

        $pdf->writeHTML($html, true, false, true, false, ''); 

        $total_gst_product_taxable_amount = 0;
        $total_gst_product_taxable_amount_format = 0;

        $final_gst_product_amount_with_gst = 0;
        $final_gst_product_amount_with_gst_format = 0; 

        $product_gst_amount=0;
        $product_gst_amount_format=0;  
                   
        $i = 1;
        $j = 1;

        $total_gst_service_taxable_amount = 0;
        $total_gst_service_taxable_amount_format = 0;

        $final_gst_service_amount_with_gst = 0;
        $final_gst_service_amount_with_gst_format = 0; 

        $service_gst_amount=0;
        $service_gst_amount_format=0;

        if($data_offer_product_count > 0)
        {
            $html = '
                    <p style="font-size: 7px;  text-indent:2em; width: 100%;">'.breakSalutation($Salutation,15).'</p>

                    <table cellpadding="3" width="100%">
                        <tr style="background-color: #b0c4de;">
                            <td style="font-size: 6.5px; width: 5%; text-align: center; text-indent:2em;"><b>Sr.<br>&nbsp;&nbsp;&nbsp;No</b></td>

                            <td style="font-size: 6.5px; width: 8%; text-indent:2em; text-align: left;"><b>HSN<br>&nbsp;&nbsp;&nbsp;Code</b></td>

                            <td style="font-size: 6.5px; width: 8%; text-indent:2em; text-align: left;"><b>Part<br>&nbsp;&nbsp;&nbsp;Number</b></td>

                            <td style="font-size: 6.5px; width: 29%; text-align: center; text-indent:2em;"><b>Product Details</b></td>

                             <td style="font-size: 6.5px; width: 6%; text-align: center; text-indent:2em;"><b>Make</b></td>

                            <td style="font-size: 6.5px; width: 5%; text-indent:2em; text-align: center;"><b>Qty</b></td>

                            <td style="font-size: 6.5px; width: 5%; text-indent:2em; text-align: center;"><b>Unit</b></td>

                            <td style="font-size: 6.5px; width: 8%; text-indent:2em; text-align: center;"><b>Price Per<br>&nbsp;&nbsp;&nbsp;Unit INR</b></td>

                            <td style="font-size: 6.5px; width: 9%; text-indent:2em; text-align: center;"><b>Discounted<br>&nbsp;&nbsp;&nbsp;Price Per<br>&nbsp;&nbsp;&nbsp;Unit</b></td>

                            <td style="font-size: 6.5px; width: 8%; text-indent:2em; text-align: center;"><b>Total</b></td> 

                            <td style="font-size: 6.5px; width: 9%; text-indent:2em; text-align: center;"><b>GST<br>&nbsp;&nbsp;</b></td>

                        </tr>
                    </table>';
                    $all_product_total = 0;
                    $all_product_sub_total = 0;
                    $all_product_gst = 0;
                    $Quotation_amount = 0;
                    foreach ($data_offer_product as $value_data)
                    {   
                        $product_name = $value_data['product_name'];
                        $product_custom_description = $value_data['product_custom_description'];
                        $product_price_format = $value_data['price'];
                        $product_price = number_format((float)$product_price_format, 2, '.', '');
                        $product_unit = $value_data['unit'];
                        $product_qty = $value_data['rfq_qty'];

                        $total_format = $product_price * $product_qty;

                        $total = number_format((float)$total_format, 2, '.', '');

                        $all_product_total += $total;

                        $all_product_total = number_format((float)$all_product_total, 2, '.', '');

                        $PRODUCT_ID = $value_data['PRODUCT_ID'];

                        $product_make = $value_data['product_make'];

                        $remark = $value_data['remark'];

                        $amount_without_gst_format = $value_data['total_amount_without_gst'];
                        $amount_without_gst = number_format((float)$amount_without_gst_format, 2, '.', '');

                        $all_product_sub_total += $amount_without_gst;

                        $all_product_sub_total = number_format((float)$all_product_sub_total, 2, '.', '');

                        $cgst_percentage = $value_data['cgst_discount'];
                        $cgst_amount_format = $value_data['cgst_amt'];
                        $cgst_amount = number_format((float)$cgst_amount_format, 2, '.', '');

                        $sgst_percentage = $value_data['sgst_discount'];
                        $sgst_amount_format = $value_data['sgst_amt'];
                        $sgst_amount = number_format((float)$sgst_amount_format, 2, '.', '');

                        $igst_percentage = $value_data['igst_discount'];
                        $igst_amount_format = $value_data['igst_amt'];
                        $igst_amount = number_format((float)$igst_amount_format, 2, '.', '');

                        $all_gst = $cgst_amount + $sgst_amount + $igst_amount;

                        $all_product_gst += $all_gst;

                        $all_product_gst = number_format((float)$all_product_gst, 2, '.', '');

                        if($igst_percentage == 0)
                        {
                            $product_gst_rate = $sgst_percentage + $cgst_percentage;
                        }else{
                            $product_gst_rate = $igst_percentage;
                        }

                        $hsn_code = $value_data['Hsn_code'];
                        $discount = $value_data['discount'];
                        $discount_amt = $value_data['unit_discounted_price'];

                        $discount_amt_format = $value_data['unit_discounted_price'];
                        $discount_amt = number_format((float)$discount_amt_format, 2, '.', '');

                        /*$total_amount_with_gst = $value_data['total_amount_with_gst'];*/

                        $total_amount_with_gst = $all_gst + $amount_without_gst;

                        $Quotation_amount += $total_amount_with_gst;
                        $Quotation_amount = number_format((float)$Quotation_amount, 2, '.', '');

                        $html .='<table cellpadding="3" width="100%">
                                    <tr>
                                        <td style="font-size: 6.5px; text-align: center; width: 5%; text-indent:2em;">'.strip_tags($i).'</td>

                                        <td style="font-size: 6.5px; width: 8%; text-indent:2em; text-align: left;">'.strip_tags($hsn_code).'</td>

                                        <td style="font-size: 6.5px; width: 8%; text-indent:2em; text-align: left;">'.strip_tags($PRODUCT_ID).'</td>

                                        <td style="font-size: 6.5px; width: 29%; text-indent:2em; text-align: left;">'.strip_tags($product_custom_description).'<br>&nbsp;&nbsp;&nbsp;'.strip_tags($product_name).'</td>

                                        <td style="font-size: 6.5px; width: 6%; text-indent:2em;">'.strip_tags($product_make).'</td>

                                        <td style="font-size: 6.5px; width: 5%; text-indent:2em;">&nbsp;'.strip_tags($product_qty).'</td>

                                        <td style="font-size: 6.5px; width: 5%; text-indent:2em;">&nbsp;'.strip_tags($product_unit).'</td>

                                        <td style="font-size: 6.5px; width: 8%; text-indent:2em; text-align:right;">'.strip_tags($product_price).'</td>
                
                                        <td style="font-size: 6.5px; width: 9%; text-indent:2em; text-align:right;">'.strip_tags($discount_amt).'</td>

                                        <td style="font-size: 6.5px; width: 8%; text-indent:2em; text-align:right;">'.strip_tags($amount_without_gst).'</td>

                                        <td style="font-size: 6.5px; width: 9%; text-indent:2em; text-align:right;">'.strip_tags($product_gst_rate).'%'.'</td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 6.5px; text-align: left; width: 100%; text-indent:2em; color: #FF0000;"> Note : '.strip_tags($remark).'</td>
                                    </tr>
                                </table>';
                        $i++;   
                    }
                    for ($i = $data_offer_product_count; $i < 4; $i++) 
                    { 
                        $html .='<table  cellpadding="0.5" cellspacing="0" width="100%"> 
                                    <tr>                                   
                                        <td style="width: 5%; font-size: 7px; text-indent:2em;"></td>
                                        <td style="width: 8%;">&nbsp;</td>
                                        <td style="width: 8%;">&nbsp;</td>
                                        <td style="width: 23%;">&nbsp;</td>
                                        <td style="width: 6%;">&nbsp;</td>
                                        <td style="width: 5%;">&nbsp;</td>
                                        <td style="width: 5%;">&nbsp;</td>
                                        <td style="width: 8%;">&nbsp;</td>
                                        <td style="width: 9%;">&nbsp;</td>
                                        <td style="width: 8%;">&nbsp;</td>
                                        <td style="width: 9%;">&nbsp;</td>
                                    </tr>
                                </table>'; 
                    }
                    $html .='<table cellpadding="3" width="100%"> 
                                <tr>
                                    <td style="width: 90%; font-size: 6.5px; text-align:right;"><b> Total</b></td>
                                    <td style="width: 10%; font-size: 6.5px; text-align:right;"><b>'.strip_tags($all_product_total).'</b></td>
                                </tr>
                                <tr>
                                    <td style="width: 90%; font-size: 6.5px; text-align:right;"><b> Sub Total</b></td>
                                    <td style="width: 10%; font-size: 6.5px; text-align:right;"><b>'.strip_tags($all_product_sub_total).'</b></td>
                                </tr>
                                <tr>
                                    <td style="width: 90%; font-size: 6.5px; text-align:right;"><b> GST (Goods and Service Tax )</b></td>
                                    <td style="width: 10%; font-size: 6.5px; text-align:right;"><b>'.strip_tags($all_product_gst).'</b></td>
                                </tr>

                                <tr style="background-color: #b0c4de;">
                                    <td style="width: 90%; font-size: 6.5px; text-align:right;"><b> Grand Total</b></td>
                                    <td style="width: 10%; font-size: 6.5px; text-align:right;"><b>'.strip_tags($Quotation_amount).'</b></td>
                                </tr>

                                
                            </table>'; 
                    $pdf->writeHTML($html, true, false, true, false, '');
        }


        $Total_Amount_format =  $final_gst_product_amount_with_gst + $final_gst_service_amount_with_gst; 

        $Total_Amount = number_format((float)$Total_Amount_format, 2, '.', '');

        $this->load->library('numbertowordconvertsconver');
        $Final_invoice_amount_in_word = $this->numbertowordconvertsconver->convert_number($final_gst_product_amount_with_gst);

        $P_amount = amountFormat($final_gst_product_amount_with_gst);
        if(empty($P_amount))
        {
            $F_P_Amount = strip_tags($final_gst_product_amount_with_gst);
        }else{
            $F_P_Amount = amountFormat($final_gst_product_amount_with_gst);
        }

        $S_amount = amountFormat($final_gst_service_amount_with_gst);
        if(empty($S_amount))
        {
            $F_S_Amount = strip_tags($final_gst_service_amount_with_gst);
        }else{
            $F_S_Amount = amountFormat($final_gst_service_amount_with_gst);
        }

        $T_amount = amountFormat($Total_Amount);
        if(empty($T_amount))
        {
            $T_amt = strip_tags($Total_Amount);
        }else{
            $T_amt = amountFormat($Total_Amount);
        }


        $html = '<table style="border:0.9px solid black; width:100%;"  cellpadding="0">
                    <tr style="line-height:18px;">
                        <td style="font-size: 9px; width: 100%;"  >
                           <b>Terms & Conditions</b>
                        </td>
                    </tr>';

            $html .='<tr>  
                        <td  style="font-size: 7px;  width:25%;"> 
                            Price:
                        </td>    
                        <td style="font-size: 7px;  width:75%;">    
                            '.strip_tags($Price_basis).'
                        </td>
                    </tr>';
            
            $html .='<tr>  
                        <td  style="font-size: 7px;  width:25%;"> 
                            Freight charges:
                        </td>    
                        <td style="font-size: 7px;  width:75%;">    
                            '.strip_tags($Price_basis).'
                        </td>
                    </tr>';
            $html .='<tr>  
                        <td  style="font-size: 7px;  width:25%;"> 
                            Delivery
                        </td>
                        <td style="font-size: 7px;  width:75%;">      
                            '.strip_tags($Delivery_schedule).'
                        </td>    
                    </tr>';

            $html .='<tr>              
                        <td  style="font-size: 7px;  width:25%;">
                            Sales Tax:
                        </td>
                        <td style="font-size: 7px;  width:75%;">    
                            '.strip_tags($Tax).'
                        </td>
                  </tr>';

            $html .='<tr>             
                        <td  style="font-size: 7px;  width:25%;">
                           Payment:
                        </td> 
                        <td style="font-size: 7px;  width:75%;"> 
                           '.strip_tags($payment_term).'
                        </td>
                    </tr>';

            $html .='<tr>              
                        <td  style="font-size: 7px;  width:25%;">
                           Validity
                        </td>
                        <td style="font-size: 7px;  width:75%;">    
                            '.strip_tags('').'
                        </td>
                    </tr>';

            $html .='<tr>              
                        <td  style="font-size: 7px;  width:25%;">
                            Warranty
                        </td>  
                        <td style="font-size: 7px;  width:75%;">        
                            '.strip_tags($Guarantee_warrenty).'
                        </td>
                    </tr>';
       
            $html .='</table>'; 

        $pdf->writeHTML($html, true, false, true, false, '');

        $html = '<table cellpadding="2" width="100%">
                        <tr>
                            <td style="font-size: 7.5px; width: 100%;"><b>Note 1 : </b> For Cable: Qty Tolerance +/- 10% in length.
                                For Communication Devices/ Routers: Quoted prices are EXCLUSIVE of power supply; connection cables; SIM cards; etc. unless it is specifically
                                mentioned
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 7.5px; width: 100%;"><b>Note 2 : </b> Any Onsite support or Installation/ Commissioning charges will be extra, separate offer for the same will be submitted.</td>
                        </tr>
                        <tr>
                            <td style="font-size: 7.5px; width: 100%;"><b>Note 3 : </b> Quoted Prices are worked out considering prevailing Duties; taxes; Levies; Surcharge. In case there is any statutory changes in the same
                                prices shall be adjusted accordingly.
                                We hope the quoted products are in line with your requirements. Feel free to contact us if you need any more info.
                                Look forward to receiving your valuable PO soon.
                            </td>
                        </tr>
                     </table>';
        $pdf->writeHTML($html, true, false, true, false, '');

        $html = '<table cellpadding="2" width="100%">
                    <tr>
                        <td><h2 style="font-size: 10px;"><b>Bank Details for NEFT/RTGS:</b></h2>
                        </td>
                    </tr>
                    <tr COLSPAN=2>
                        <td style="width: 60%;">
                        <p style="font-size: 7.5px;  text-indent:2em;">Bank Name :  HDFC Bank
                        <br>Account Name : VBTEK Communication Pvt. Ltd.
                        <br>Account No : 50200018071706
                        <br>Account Type :  CC
                        
                        <br>Bank Branch Code:  633
                       
                        <br>IFSC No : HDFC0000633
                        <br>Bank Address : 934 Nana Peth, Rajveer Complex.Pune, MH- 411002
                        </p>
                        </td>
                        <td style="width: 40%; text-align:right;">
                            <h2 style="font-size: 8px;"><b>For VBTEK Communication Pvt. Ltd.</b></h2>

                        </td>
                    </tr>
                    <tr COLSPAN=2>
                        <td style="width: 75%; text-align:left;">
                            <h3 style="font-size: 10px;"><b>“This Document is computer generated. No signature is required”</b></h3>
                        </td>
                        <td style="width: 25%;">
                            <h3 style="font-size: 8px; text-align:right;"><b>VBTEK Sales<br> Mobile No: +91 7875432180</b></h3>
                        </td>
                    </tr>
                     </table>';
        $pdf->writeHTML($html, true, false, true, false, '');
        
        $pdf->AddPage();
        $html = '<br><br><br><br>
                    <h3 style="font-size: 10px;text-align:center;"><b><u>VBTEK Warranty Policy</u></b></h3>
                    <table cellpadding="2" width="100%">
                        <tr>
                            <td>
                                <p style="font-size: 9px;">We hereby guarantee satisfactory operation of the purchased product/ products for a period of <b>Agreed tenure</b> from the
                                    <b>date of dispatch.</b> We shall be responsible for failure of the material to conform to the standard of performance,
                                    proficiency and for any defects that may develop under proper use arising from the use of faulty materials, design or
                                    workmanship in the supply made and shall remedy such defects. Important Notice: SPARE PARTS, ACCESSORIES AND
                                    PERIPHERALS ARE NOT COVERED IN THE WARRANTY
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h3 style="font-size: 10px;"><b>Warranty does not cover:</b></h3>
                                <p>
                                    <ul style="font-size: 9px;">
                                        <li>Damage Physical</li>
                                        <li>Product out of Warranty period</li>
                                        <li>Damage caused by natural disasters, such as lightning strikes, floods and earthquakes</li>
                                        <li>Intentional or non-intentional deterioration affecting the equipment, whatever the cause</li>
                                        <li>Damage caused by accidents, misuse, improper installation or unauthorized repair</li>
                                        <li>Damage caused to the equipment, if not correctly operated/ handled</li>
                                        <li>Damage due to wrong connections or wiring</li>
                                        <li>Products with Illegible, removed, or damaged serial number label will not be covered</li>
                                        <li>Additional updating, reworking or testing requested by customers</li>
                                        <li>Any upgrading or testing requested by customers after the warranty period</li>
                                    </ul>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h3 style="font-size: 10px;"><b>For Faulty Products under Warranty:</b></h3>
                                <p style="font-size: 9px;">
                                    Products to be sent to VBTEK for inspection. VBTEK Engineer will first inspect the product. If needed products will be
                                    further sent to Principles for servicing or repair. To & Fro Freight Charges will be borne by VBTEK for under warranty
                                    products.
                                </p>
                                <p style="font-size: 9px;">
                                    If Product is found to be faulty <u>for terms not covered under warranty</u>Handling, Servicing, Repair, To & Fro Freight or any
                                        additional Charges will be borne by the customer.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h3 style="font-size: 10px;"><b>For Products NOT under Warranty:</b></h3>
                                <p style="font-size: 9px;">
                                    The Warranty Tenure of the product is defined from the date of the dispatch of the product. If Product is not covered under
                                    Warranty, Handling, Servicing, Repair, To & Fro Freight Charges will be borne by the customer.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h3 style="font-size: 10px;"><b>NPF (No Problem Found):</b></h3>
                                <p style="font-size: 9px;">
                                    If NPF is detected from merchandise, VBTEK reserves the right to have necessary charges.
                                </p>
                            </td>
                        </tr>
                         <tr>
                            <td>
                                <h3 style="font-size: 10px;"><b>Note:</b></h3>
                                <p style="font-size: 9px;">
                                    VBTEK has the right to destroy or recycle the product(s) to allay our storage costs without incurring any liability if
                                        customers do not respond to a request of the payment or return of goods within 60 days from the date of the request.
                                </p>
                                <p style="font-size: 9px;">
                                    VBTEK reserves the right to modify or cancel the policy at any time. Neither VBTEK nor any of its entities will be
                                    responsible for any damages caused by such modifications or cancellation.
                                </p>
                            </td>
                        </tr>
                    </table>';
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->lastPage();
        ob_clean();
        $fileatt = $pdf->Output($filename, 'F');

        /*$filename= "Offer_Details-".date('Y-m-d-H:i:s').".pdf"; 
        $filelocation = $path."\\assets\\offer_attachment\\";//windows

        $fileNL = $filelocation."\\".$filename;//Windows

        $fileatt = $pdf->Output($fileNL, 'F');*/

        /*$cc_email = array('vbdigitech@gmail.com','avikasecureinvest15@gmail.com');*/

        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");

        $path_img = getcwd();
        $Company_design = $path_img."/assets/company_logo/logo.png";

        $message = '<html><header>
            <h1 style="text-align: center;">VB Digitech Pvt. Ltd.</h1>
            <center><P><img src="http://crm.bbcpl.in/assets/company_logo/logo.png" style="width:100px; height: 80px;"></P></center>
            <br>'.strip_tags($customer_name).'.,'.'<br><br>

            Dear Sir/Mam<br>

            Refer to your inquiry, Pl find the Techno commercial quote enclosed with this email.<br>

            We hope the quoted products are in line with your requirements. Feel free to contact us if you need any more info.<br>

            We look forward to receive your valuable PO soon..<br><br>

            Warm Regards,<br><br>

            <b>'.strip_tags($Full_name).'</b><br>
            <img src="http://crm.bbcpl.in/assets/company_logo/mail_pic.png" style="width:100px; height: 80px;">
            <br>
            <p style="color:blue;"><i>We help you Connect !!</i><br>
            <b>Team VB Digitech Pvt. Ltd.</b><br>
            <b>An ISO 9001 :2015 Certified Company</b>
            </p><br>
            102/B, Surekha Apartment, Pune Satara Road,<br>
            Pune- 411037. Maharashtra, India.<br>
            Mob : 7875432180 / 9175942186 E-mail: sales@bbcpl.in  Web: <a href = "https://www.bbcpl.in">www.bbcpl.in</a><br>

            </header><body>';

        $message .= "</body></html>";

        $Subject = "Quotation Number : ".$offer_no. " For ".$customer_name;

        $this->email->to($mail_to);
        $this->email->cc($mail_cc);
        $this->email->bcc($mail_bcc);
        $this->email->from('support@crm.bbcpl.com','support@crm.bbcpl.com');
        $this->email->subject($Subject);
        $this->email->attach($filename);
        $this->email->message($message);
        if ($this->email->send()) {
            $this->session->set_userdata('message_name', 'Ticket Send Successfully....!');
        }

        $user_id = $_SESSION['user_id'];
        $user_name = $this->session->userdata('full_name');

        $tracking_record = "Quotation Number:- ".$offer_no." Created by ".$user_name.'.';
        $next_action = "Call Customer And Ask For Order.";

        $this->db->select('tracking_number');
        $this->db->from('enquiry_tracking_master');
        $this->db->order_by('entity_id', 'DESC');
        $this->db->limit(1);
        $enquiry_tracking_master = $this->db->get();
        $results_enquiry_tracking_register = $enquiry_tracking_master->result_array();

        if(!empty($results_enquiry_tracking_register))
        {
            $enquiry_tracking_serial_no = $results_enquiry_tracking_register[0]['tracking_number'];
            $enquiry_tracking_data_seprate = explode('/', $enquiry_tracking_serial_no);
            $enquiry_tracking_doc_year = $enquiry_tracking_data_seprate['1'];
        }

        $this->db->select('document_series_no');
        $this->db->from('documentseries_master');
        $where = '(documentseries_master.entity_id = "'.'7'.'")';
        $this->db->where($where);
        $doc_record=$this->db->get();
        $results_doc_record = $doc_record->result_array();

        $doc_serial_no = $results_doc_record[0]['document_series_no'];
        $doc_data_seprate = explode('/', $doc_serial_no);
        $doc_year = $doc_data_seprate['1'];

        if(empty($results_enquiry_tracking_register[0]['tracking_number']) || ($enquiry_tracking_doc_year != $doc_year))
        {
            $first_no = '0001';
            $doc_no = $doc_serial_no.$first_no;
        }elseif(!empty($results_enquiry_tracking_register) && ($enquiry_tracking_doc_year == $doc_year))
        {
            $doc_type = $enquiry_tracking_data_seprate['0'];
            $ex_no = $enquiry_tracking_data_seprate['2'];
            $next_en = $ex_no + 1;
            $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
            $doc_no = $doc_type.'/'.$enquiry_tracking_doc_year.'/'.$next_doc_no;
        }

        $next_action_due_date = date('Y-m-d', strtotime($offer_date . " +1 days"));

        $track_save = "INSERT INTO enquiry_tracking_master (user_id , tracking_number , enquiry_id , offer_id , customer_id , tracking_date , tracking_record , next_action , action_due_date , status) VALUES ('".$user_id."' , '".$doc_no."' , '".$enquiry_entity_id."' , '".$offer_entity_id."' , '".$offer_customer_id."' , '".$offer_date."' , '".$tracking_record."' , '".$next_action."' , '".$next_action_due_date."' , '".'2'."')";
        $save_execute = $this->db->query($track_save);

        $data = site_url('vw_offer_data');

        echo $data;
    }
    
    public function create_offer_wo_lead()
    {
        $entity_id = $this->uri->segment(2);
        if (!empty($entity_id)) {
            $data['entity_id']= $entity_id;
        }else{
            $data['entity_id']= NULL;
        }

        $data['customer_list'] = $this->offer_register_model->get_customer_list();
        $data['employee_list'] = $this->offer_register_model->get_employee_list();
        $data['payment_term_list'] = $this->offer_register_model->get_payment_term_list();
        $data['product_list'] = $this->offer_register_model->get_product_list();
        $data['product_category'] = $this->offer_register_model->get_product_category();
        $data['product_detail_hsn_code'] = $this->offer_register_model->get_product_hsn_code();
        $this->load->view('sales/offer_register/create_offer_without_lead',$data);
    }
    
    public function get_all_customer_data()
    {
        $id=$this->input->post('entity_id');

        $cid=$this->db->select('entity_id')->from('customer_master')->where('entity_id',$id)->get()->row_array();

        echo json_encode($cid);
    }
    
    public function get_contact_person()
    {
        $customer_id = $this->input->post('id',TRUE);
        $data = $this->offer_register_model->get_contact_person_data($customer_id)->result();
         echo json_encode($data);
    }
    
    public function ajax_index()
    { 
        $user_id = $_SESSION['user_id'];
        $emp_id = $_SESSION['emp_id'];

        $table = "offer_register";
        // Table's primary key
        $primaryKey = 'entity_id';
        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database, while the `dt`
        // parameter represents the DataTables column identifier. In this case simple
        // indexes

        $columns = array(
            array( 'db' => '`offer_register`.`entity_id`',    'dt' => 0,  'field' => 'entity_id'),

            array( 'db' => '`offer_register`.`offer_no`',    'dt' => 1,  'field' => 'offer_no'),

            array( 'db' => '`offer_register`.`offer_date`', 'dt' => 2, 'field' => 'offer_date','formatter' => function( $d, $row ) {
                    return date( 'd-m-Y', strtotime($d));
                } 
            ),

            array( 'db' => '`enquiry_register`.`enquiry_no`',    'dt' => 3,  'field' => 'enquiry_no'),

            array( 'db' => '`customer_master`.`customer_name`', 'dt' => 4, 'field' => 'customer_name'),

            array( 'db' => '`customer_contact_master`.`contact_person`', 'dt' => 5, 'field' => 'contact_person'),

            array( 'db' => '`customer_contact_master`.`first_contact_no`', 'dt' => 6, 'field' => 'first_contact_no'),

            array( 'db' => '`customer_contact_master`.`email_id`', 'dt' => 7, 'field' => 'email_id'),

            array( 'db' => '`employee_master`.`emp_first_name`', 'dt' => 8, 'field' => 'emp_first_name'),

            array( 'db' => '`offer_register`.`status`', 'dt' => 9, 
                'formatter' => function( $d, $row ) 
                {
                    $status = $row['9'];

                    if($status == 2)
                    {
                        $Status_data = "Active";
                    }elseif($status == 6){
                        $Status_data = "Win";
                    }elseif($status == 7){
                        $Status_data = "InActive";
                    }elseif($status == 8){
                        $Status_data = "A";
                    }elseif($status == 9){
                        $Status_data = "B";
                    }elseif($status == 10){
                        $Status_data = "Offer Revised";
                    }else{
                        $Status_data = "NA";
                    }
                    return $Status_data; 

                },'field' => 'status'),

            array( 'db' => '`offer_register`.`entity_id`', 'dt' => 10, 
                'formatter' => function( $d, $row ) 
                {
                    $entity_id = $row['10'];

                    $this->db->select_sum('total_amount_with_gst');
                    $this->db->from('offer_product_relation');
                    $where1 = '(offer_product_relation.offer_id = "'.$entity_id.'")';
                    $this->db->where($where1);
                    $query=$this->db->get();
                    $total_offer_amount = $query->row();

                    if(!empty($total_offer_amount))
                    {
                        $total_offer_amount_final = $total_offer_amount->total_amount_with_gst;
                        $final_offer_amount = number_format($total_offer_amount_final, 2, '.', '');
                    }else{
                        $final_offer_amount = 0;
                    }

                    return $final_offer_amount;

                },'field' => 'entity_id'),

            array( 'db' => '`offer_register`.`entity_id`', 'dt' => 11,
                'formatter' => function( $d, $row ) 
                {

                    return '<a href="update_offer_data/'.$row['0'].'"><span class="btn btn-sm btn-info"><i class="fa fa-edit"></i></span></a> <a href="view_offer_data/'.$row['0'].'"><span class="btn btn-sm btn-success"><i class="fas fa-eye"></i></span></a> <a href="download_offer/'.$row['0'].'" target="_blank"><span class="btn btn-sm btn-secondary"><i class="fas fa-print"></i></span></a>';

                },'field' => 'entity_id'),

            array( 'db' => '`offer_register`.`entity_id`', 'dt' => 12,
                'formatter' => function( $d, $row ) 
                {

                    return '<a href="setorder/'.$row['0'].'"><span class="btn btn-sm btn-info"><i class="fa fa-edit"></i> Set Order</span></a>  <a href="set_revision_offer/'.$row['0'].'"><span class="btn btn-sm btn-success"><i class="fas fa-eye"></i>Make Revision</span></a>';

                },'field' => 'entity_id'),
        );

        // SQL server connection information

        $sql_details = array(
          'user' => 'root',
          'pass' => '',
          'db'   => 'demo_crm',
          'host' => 'localhost'
        );

        // $sql_details = array(
        //     'user' => 'u117003035_vbtek',
        //     'pass' => 'S@14vbtek',
        //     'db' => 'u117003035_demo_crm',
        //     'host' => 'localhost'
        // );

        $fstatus = 1;
        $sestatus = 2;
        
        include APPPATH . 'third_party/datatable_ssp_class/ssp.php';

        $joinQuery = "FROM `{$table}` LEFT JOIN `enquiry_register` ON (`offer_register`.`enquiry_id` = `enquiry_register`.`entity_id`)  INNER JOIN `customer_master` ON (`offer_register`.`customer_id` = `customer_master`.`entity_id`)  INNER JOIN `customer_contact_master` ON (`offer_register`.`contact_person_id` = `customer_contact_master`.`entity_id`)  INNER JOIN `employee_master` ON (`offer_register`.`offer_engg_name` = `employee_master`.`entity_id`)";

        // $Where = "`offer_register`.`status`=".$sestatus;
        $Where = "`offer_register`.`status`= '2' ||`offer_register`.`status`=  '8' ||`offer_register`.`status`=  '9'";

        
        $extraCondition = "";
        $groupBy = "";

        echo json_encode(
            SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns,$joinQuery,$Where,$extraCondition,$groupBy)
        );
    }

    public function vw_ajax_all_offer_data()
    { 
        $user_id = $_SESSION['user_id'];
        $emp_id = $_SESSION['emp_id'];

        $table = "offer_working_index";
        // Table's primary key
        $primaryKey = "entity_id";
        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database, while the `dt`
        // parameter represents the DataTables column identifier. In this case simple
        // indexes

        $columns = array(
            array( 'db' => '`offer_working_index`.`entity_id`',    'dt' => 0,  'field' => 'entity_id'),

            array( 'db' => '`offer_working_index`.`offer_no`',    'dt' => 1,  'field' => 'offer_no'),

            array( 'db' => '`offer_working_index`.`offer_date`', 'dt' => 2, 'field' => 'offer_date','formatter' => function( $d, $row ) {
                    return date( 'd-m-Y', strtotime($d));
                } 
            ),

            array( 'db' => '`offer_working_index`.`enquiry_no`',    'dt' => 3,  'field' => 'enquiry_no'),

            array( 'db' => '`offer_working_index`.`customer_name`', 'dt' => 4, 'field' => 'customer_name'),

            array( 'db' => '`offer_working_index`.`contact_person`', 'dt' => 5, 'field' => 'contact_person'),

            array( 'db' => '`offer_working_index`.`first_contact_no`', 'dt' => 6, 'field' => 'first_contact_no'),

            array( 'db' => '`offer_working_index`.`email_id`', 'dt' => 7, 'field' => 'email_id'),

            array( 'db' => '`offer_working_index`.`emp_first_name`', 'dt' => 8, 'field' => 'emp_first_name'),

            array( 'db' => '`offer_working_index`.`status`', 'dt' => 9, 
                'formatter' => function( $d, $row ) 
                {
                    $Status_data = $row['9'];

                    if($Status_data == 1)
                    {
                        $Status = "Pending Offer Creation";
                    }elseif($Status_data == 2)
                    {
                        $Status = "Offer Created";
                    }elseif($Status_data == 3)
                    {
                        $Status = "Active";
                    }elseif($Status_data == 4)
                    {
                        $Status = "Offer Lost";
                    }elseif($Status_data == 5)
                    {
                        $Status = "Offer Regrated";
                    }elseif($Status_data == 6)
                    {
                        $Status = "Win";
                    }elseif($Status_data == 7)
                    {
                        $Status = "InActive";
                    }elseif($Status_data == 8)
                    {
                        $Status = "A";
                    }elseif($Status_data == 9)
                    {
                        $Status = "B";
                    }elseif($Status_data == 10)
                    {
                        $Status = "Offer Revised";
                    }else{
                        $Status = "NA";
                    }
                    return $Status; 

                },'field' => 'status'),

            array( 'db' => '`offer_working_index`.`total_amount_with_gst`', 'dt' => 10, 'field' => 'total_amount_with_gst'),
                // {
                //     $entity_id = $row['10'];

                //     $this->db->select_sum('total_amount_with_gst');
                //     $this->db->from('offer_product_relation');
                //     $where1 = '(offer_product_relation.offer_id = "'.$entity_id.'")';
                //     $this->db->where($where1);
                //     $query=$this->db->get();
                //     $total_offer_amount = $query->row();

                //     if(!empty($total_offer_amount))
                //     {
                //         $total_offer_amount_final = $total_offer_amount->total_amount_with_gst;
                //         $final_offer_amount = number_format($total_offer_amount_final, 2, '.', '');
                //     }else{
                //         $final_offer_amount = 0;
                //     }

                //     return $final_offer_amount;

                // }

            array( 'db' => '`offer_working_index`.`entity_id`', 'dt' => 11,
                'formatter' => function( $d, $row ) 
                {

                  return '<a href="update_offer_data/'.$row['0'].'"><span class="btn btn-sm btn-info"><i class="fa fa-edit"></i></span></a> <a href="view_offer_data/'.$row['0'].'"><span class="btn btn-sm btn-success"><i class="fas fa-eye"></i></span></a> <a href="download_offer/'.$row['0'].'" target="_blank"><span class="btn btn-sm btn-secondary"><i class="fas fa-print"></i></span></a>';

                },'field' => 'entity_id'));

        // SQL server connection information
       
        $sql_details = array(
          'user' => 'root',
          'pass' => '',
          'db'   => 'demo_crm',
          'host' => 'localhost'
        );
        
        // $sql_details = array(
        //     'user' => 'u117003035_vbtek',
        //     'pass' => 'S@14vbtek',
        //     'db' => 'u117003035_demo_crm',
        //     'host' => 'localhost'
        // );
        
        include APPPATH . 'third_party/datatable_ssp_class/ssp.php';

        // $joinQuery = "FROM `{$table}` LEFT JOIN `enquiry_register` ON (`offer_register`.`enquiry_id` = `enquiry_register`.`entity_id`)  INNER JOIN `customer_master` ON (`offer_register`.`customer_id` = `customer_master`.`entity_id`)  INNER JOIN `customer_contact_master` ON (`offer_register`.`contact_person_id` = `customer_contact_master`.`entity_id`)  INNER JOIN `employee_master` ON (`offer_register`.`offer_engg_name` = `employee_master`.`entity_id`)";

        if($user_id == 1)
        {
            $Where = "";
        }else{
            $Where = "`offer_working_index`.`offer_engg_name`=".$emp_id;
        }
        
        $extraCondition = "";
        $groupBy = "";
        $joinQuery = false;

        echo json_encode(
            SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns,$joinQuery,$Where,$extraCondition,$groupBy)
        );
    }

    public function save_offer_with_update_company()
    {
        if(!empty($_FILES['offer_attachment']))
        {
            $offer_attachment_img = "";
            foreach ($_FILES as $key => $value) {
                
                $file_name = $value['name'];
                $file_source_path = $value['tmp_name'];
                $file_upload_combine_array = array_combine($file_name, $file_source_path);
                //print_r($file_upload_combine_array);
                
                foreach ($file_upload_combine_array as $image_name=> $image_source_path) {
                    // echo $k. ' '. $a ;

                    $ext = pathinfo($image_name,PATHINFO_EXTENSION);

                    $offer_attachment_upload = substr(str_replace(" ", "_", $image_name), 0);
                    move_uploaded_file($image_source_path, 'assets/offer_attachment/'.$offer_attachment_upload);

                    $offer_attachment_img .= $offer_attachment_upload.',';
                }  
            }
        }else{
            $offer_attachment_img = NULL;
        }

        $user_id = $_SESSION['user_id'];
        $user_name = $this->session->userdata('full_name');

        $customer_id = $this->input->post('customer_name');
        $contact_id = $this->input->post('contact_id');

        $offer_entity_id = $this->input->post('offer_entity_id');
        $enquiry_descrption = $this->input->post('enquiry_descrption');
        $employee_id = $this->input->post('employee_id');
        $offer_for = $this->input->post('offer_for');
        $offer_date = $this->input->post('offer_date');
        $offer_terms_condition = $this->input->post('offer_terms_condition');
        $offer_source = $this->input->post('offer_source');
       	$offer_note = $this->input->post('offer_note');

        $salutation = $this->input->post('salutation');
       	$tax = $this->input->post('tax');
        $price_condition = $this->input->post('price_condition');
        $your_reference = $this->input->post('your_reference');
        $offer_close_date = $this->input->post('offer_close_date');

        $offer_company_name = $this->input->post('offer_company_name');

        $customer_update_array = array('customer_name' => $offer_company_name);
        $where = '(entity_id ="'.$customer_id.'")';
        $this->db->where($where);
        $this->db->update('customer_master',$customer_update_array);

        $this->db->select('*');
        $this->db->from('offer_register');
        $where = '(offer_register.entity_id = "'.$offer_entity_id.'" )';
        $this->db->where($where);
        $this->db->order_by('offer_register.entity_id', 'DESC');
        $this->db->limit(1);
        $query_data = $this->db->get();
        $query_result = $query_data->row_array();

		
        $quotation_no = $query_result['offer_no'];
        $enquiry_entity_id = $query_result['enquiry_id'];

        $offer_status = 2;

        $update_offer_array = array(
			'customer_id' => $customer_id , 
			'contact_person_id' => $contact_id , 
			'offer_description' => $enquiry_descrption , 
			'offer_engg_name' => $employee_id , 
			'offer_for' => $offer_for , 
			'offer_date' => $offer_date , 
			'terms_conditions' => $offer_terms_condition , 
			'offer_source' => $offer_source ,  
			'note' => $offer_note , 
			'attachment' => $offer_attachment_img , 
			'price_condition' => $price_condition, 
			'salutation' => $salutation, 
			'tax' => $tax, 
			'status' => $offer_status, 
			'your_reference' => $your_reference , 
			'offer_close_date' => $offer_close_date , 
			'offer_company_name' => $offer_company_name
		);

        $where = '(entity_id ="'.$offer_entity_id.'")';
        $this->db->where($where);
        $this->db->update('offer_register',$update_offer_array);

        $enquiry_status = 2;
		if($enquiry_entity_id){
        $update_enquiry_array = array('enquiry_status' => $enquiry_status);
        $where = '(entity_id ="'.$enquiry_entity_id.'")';
        $this->db->where($where);
        $this->db->update('enquiry_register',$update_enquiry_array);
		}

        // $tracking_record = "Quotation Number:- ".$quotation_no." Created by ".$user_name.' , But Quotation not send over email address';
        // $next_action = "Call Customer And Ask For Order.";

        // $this->db->select('tracking_number');
        // $this->db->from('enquiry_tracking_master');
        // $this->db->order_by('entity_id', 'DESC');
        // $this->db->limit(1);
        // $enquiry_tracking_master = $this->db->get();
        // $results_enquiry_tracking_register = $enquiry_tracking_master->result_array();

        // if(!empty($results_enquiry_tracking_register))
        // {
        //     $enquiry_tracking_serial_no = $results_enquiry_tracking_register[0]['tracking_number'];
        //     $enquiry_tracking_data_seprate = explode('/', $enquiry_tracking_serial_no);
        //     $enquiry_tracking_doc_year = $enquiry_tracking_data_seprate['1'];
        // }

        // $this->db->select('document_series_no');
        // $this->db->from('documentseries_master');
        // $where = '(documentseries_master.entity_id = "'.'7'.'")';
        // $this->db->where($where);
        // $doc_record=$this->db->get();
        // $results_doc_record = $doc_record->result_array();

        // $doc_serial_no = $results_doc_record[0]['document_series_no'];
        // $doc_data_seprate = explode('/', $doc_serial_no);
        // $doc_year = $doc_data_seprate['1'];

        // if(empty($results_enquiry_tracking_register[0]['tracking_number']) || ($enquiry_tracking_doc_year != $doc_year))
        // {
        //     $first_no = '0001';
        //     $doc_no = $doc_serial_no.$first_no;
        // }elseif(!empty($results_enquiry_tracking_register) && ($enquiry_tracking_doc_year == $doc_year))
        // {
        //     $doc_type = $enquiry_tracking_data_seprate['0'];
        //     $ex_no = $enquiry_tracking_data_seprate['2'];
        //     $next_en = $ex_no + 1;
        //     $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
        //     $doc_no = $doc_type.'/'.$enquiry_tracking_doc_year.'/'.$next_doc_no;
        // }

        // $next_action_due_date = date('Y-m-d', strtotime($offer_date . " +1 days"));

        // $track_save = "INSERT INTO enquiry_tracking_master (user_id , tracking_number , enquiry_id , offer_id , customer_id , tracking_date , tracking_record , next_action , action_due_date , status) VALUES ('".$user_id."' , '".$doc_no."' , '".$enquiry_entity_id."' , '".$offer_entity_id."' , '".$customer_id."' , '".$offer_date."' , '".$tracking_record."' , '".$next_action."' , '".$next_action_due_date."' , '".'2'."')";
        // $save_execute = $this->db->query($track_save);

        $data = site_url('vw_offer_data');

        echo $data;
    }
}   
?>

<?php
    function getAddress($address, $lineLength, $spaceLength){
        $array= explode(' ',$address);
        $temp= array();
        $fTempLen = ceil(strlen($address)/$lineLength);

        for($k=0; $k <= $fTempLen; $k++)
            $temp[$k]='';

        $j=0;
        for($i = 0; $i<count($array); $i++){

            $tLen = strlen($temp[$j]);
            $aLen = strlen($array[$i]);
            if(($tLen + $aLen) < $lineLength){
                $temp[$j] .= $array[$i] . ' ';
            }
            else {
                $temp[$j] .= '<br>';
                $j++;
                $temp[$j] .= $array[$i] . ' ';
            }
        }

        $space = '';
        for($k=0; $k<$spaceLength; $k++)
            $space .= '&nbsp;';

        $result = '';
        for($k=0; $k<count($temp); $k++){
            if ($k == 0) 
                $result.=$temp[$k];
            else
                $result.= $space . $temp[$k];
        }

        return $result;
    }

    function getAddress1($address, $lineLength){
        $array= explode(' ',$address);
        $result = '';
        
        for($i = 0; $i<count($array); $i++){
            $tLen = strlen($result);
            $aLen = strlen($array[$i]);
            if(($tLen + $aLen) < $lineLength){
                $result .= $array[$i] . ' ';
            }
            else {
                break;
            }
        }

        return $result;
    }

    function breakSalutation($str, $lineLength){
        $str1= substr($str,0, $lineLength);
        $str2 = substr($str, $lineLength);
        
        $result = $str1 . '<br/>' . $str2;
        
        return $result;
    }

    function amountFormat($num) {
        $explrestunits = "" ;
        $num = substr($num, 0, strlen($num)-3);
        if(strlen($num)>3) {
            $lastthree = substr($num, strlen($num)-3, strlen($num));
            $restunits = substr($num, 0, strlen($num)-3); 
            $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits;
            $expunit = str_split($restunits, 2);
            for($i=0; $i<sizeof($expunit); $i++) {
           
                if($i==0) {
                    $explrestunits .= (int)$expunit[$i].","; 
                } else {
                    $explrestunits .= $expunit[$i].",";
                }
            }
            $thecash = $explrestunits.$lastthree .'.00';
        } else {
            $thecash = $num;
        }
        return $thecash; 
    
}
?>

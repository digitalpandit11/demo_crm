<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class Report_model extends CI_Model{ 
    function __construct() { 
        // Set table name 
    } 

    public function get_all_stock_report_details($user_id)
    {
        $this->db->select('product_master.entity_id As Product_entity_id,
            product_master.product_id AS Product_id,
            product_master.product_name AS Product_name,
            product_master.unit AS Product_unit,
            inventory_register.current_stock AS Product_Stock,
            inventory_register.location_name AS Product_location,
            product_category_master.category_name AS Product_category,
            product_subcategory_master.subcategory_name AS Product_sub_category');
        $this->db->from('product_master');
        $this->db->join('inventory_register','product_master.entity_id = inventory_register.product_id', 'INNER');
        $this->db->join('product_category_master','product_master.category_id = product_category_master.entity_id', 'INNER');
        $this->db->join('product_subcategory_master','product_master.subcategory_id = product_subcategory_master.entity_id', 'INNER');
        $where = '(product_master.user_id = "'.$user_id.'")';
        $this->db->where($where);
        $this->db->order_by('product_master.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_all_sheet_wise_stock_report_details($user_id)
    {
        $this->db->select('inventory_register_date_sheet.*,
            product_master.product_id AS Product_id,
            product_master.product_name AS Product_name,
            product_master.unit AS Product_unit,
            product_category_master.category_name AS Product_category,
            product_subcategory_master.subcategory_name AS Product_sub_category');
        $this->db->from('inventory_register_date_sheet');
        $this->db->join('product_master','product_master.entity_id = inventory_register_date_sheet.product_id', 'INNER');
        $this->db->join('product_category_master','product_master.category_id = product_category_master.entity_id', 'INNER');
        $this->db->join('product_subcategory_master','product_master.subcategory_id = product_subcategory_master.entity_id', 'INNER');
        $where = '(inventory_register_date_sheet.user_id = "'.$user_id.'")';
        $this->db->where($where);
        $this->db->order_by('inventory_register_date_sheet.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function display_sales_register_report_date_wise($user_id,$timesheet_from_date,$timesheet_to_date)
    {
        $this->db->select('sales_order_product_relation.*,sales_order_register.sales_order_no,sales_order_register.sales_order_date,sales_order_register.offer_id,sales_order_register.entity_id AS Entity_id_sales_order');
        $this->db->from('sales_order_product_relation');
        $this->db->join('sales_order_register','sales_order_register.entity_id = sales_order_product_relation.sales_order_id', 'INNER');
        $this->db->join('offer_register','offer_register.entity_id = sales_order_register.offer_id', 'INNER');

        $where = '(sales_order_register.user_id >= "'.$user_id.'" And sales_order_register.sales_order_date >= "'.$timesheet_from_date.'" And sales_order_register.sales_order_date <= "'.$timesheet_to_date.'")';
        $this->db->where($where);
        //$this->db->order_by('sales_order_register.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function display_sales_register_report_of_service_date_wise($user_id,$timesheet_from_date,$timesheet_to_date)
    {
        $this->db->select('sales_order_service_relation.*,sales_order_register.sales_order_no,sales_order_register.sales_order_date,sales_order_register.offer_id,sales_order_register.entity_id AS Entity_id_sales_order');
        $this->db->from('sales_order_service_relation');
        $this->db->join('sales_order_register','sales_order_register.entity_id = sales_order_service_relation.sales_order_id', 'INNER');
        $this->db->join('offer_register','offer_register.entity_id = sales_order_register.offer_id', 'INNER');
        
        $where = '(sales_order_register.user_id >= "'.$user_id.'" And sales_order_register.sales_order_date >= "'.$timesheet_from_date.'" And sales_order_register.sales_order_date <= "'.$timesheet_to_date.'" )';
        $this->db->where($where);
        //$this->db->order_by('sales_order_register.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }



    public function display_pending_sales_order_report_date_wise($user_id,$timesheet_from_date,$timesheet_to_date)
    {
        $this->db->select('sales_order_product_relation.*,sales_order_register.sales_order_no,sales_order_register.sales_order_date,sales_order_register.offer_id,sales_order_register.entity_id AS Entity_id_sales_order');
        $this->db->from('sales_order_product_relation');
        $this->db->join('sales_order_register','sales_order_register.entity_id = sales_order_product_relation.sales_order_id', 'INNER');
        $this->db->join('offer_register','offer_register.entity_id = sales_order_register.offer_id', 'INNER');

        $where = '(sales_order_register.user_id >= "'.$user_id.'" And sales_order_register.sales_order_date >= "'.$timesheet_from_date.'" And sales_order_register.sales_order_date <= "'.$timesheet_to_date.'" And sales_order_register.status = "'.'1'.'")';
        $this->db->where($where);
        //$this->db->order_by('sales_order_register.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function display_pending_sales_order_report_of_service_date_wise($user_id,$timesheet_from_date,$timesheet_to_date)
    {
        $this->db->select('sales_order_service_relation.*,sales_order_register.sales_order_no,sales_order_register.sales_order_date,sales_order_register.offer_id,sales_order_register.entity_id AS Entity_id_sales_order');
        $this->db->from('sales_order_service_relation');
        $this->db->join('sales_order_register','sales_order_register.entity_id = sales_order_service_relation.sales_order_id', 'INNER');
        $this->db->join('offer_register','offer_register.entity_id = sales_order_register.offer_id', 'INNER');
        
        $where = '(sales_order_register.user_id >= "'.$user_id.'" And sales_order_register.sales_order_date >= "'.$timesheet_from_date.'" And sales_order_register.sales_order_date <= "'.$timesheet_to_date.'" And sales_order_register.status = "'.'1'.'")';
        $this->db->where($where);
        //$this->db->order_by('sales_order_register.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }


    public function display_enquiry_tracking_report_date_wise($user_id,$timesheet_from_date,$timesheet_to_date)
    {
        $this->db->select('enquiry_tracking_master.*,
                           enquiry_register.enquiry_no,
                           enquiry_register.enquiry_short_desc,
                           enquiry_register.enquiry_date,
                           customer_master.customer_name');
        $this->db->from('enquiry_tracking_master');
        $this->db->join('enquiry_register','enquiry_tracking_master.enquiry_id = enquiry_register.entity_id', 'INNER');
        $this->db->join('customer_master','enquiry_tracking_master.customer_id = customer_master.entity_id', 'INNER');

        $where = '(enquiry_tracking_master.user_id >= "'.$user_id.'" And enquiry_tracking_master.tracking_date >= "'.$timesheet_from_date.'" And enquiry_tracking_master.tracking_date <= "'.$timesheet_to_date.'")';
        $this->db->where($where);
        //$this->db->order_by('sales_order_register.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }


    // public function display_enquiry_summary_report_date_wise($user_id,$timesheet_from_date,$timesheet_to_date)
    // {
    //     $this->db->select('enquiry_register.*,
    //                        customer_master.customer_name');
    //     $this->db->from('enquiry_register');
    //     $this->db->join('customer_master','enquiry_register.customer_id = customer_master.entity_id', 'INNER');

    //     $where = '(enquiry_register.user_id >= "'.$user_id.'" And enquiry_register.enquiry_date >= "'.$timesheet_from_date.'" And enquiry_register.enquiry_date <= "'.$timesheet_to_date.'")';
    //     $this->db->where($where);
    //     //$this->db->order_by('sales_order_register.entity_id', 'DESC');
    //     $query = $this->db->get();
    //     $query_result = $query->result();
    //     // print_r($query_result);
    //     // die();
    //     return $query_result;  
    // }



    public function get_all_enquiry($user_id)
    {
        $this->db->select('enquiry_register.enquiry_no,enquiry_register.entity_id');
        $this->db->from('enquiry_register');
        $where = '(enquiry_register.user_id = "'.$user_id.'")';
        $this->db->where($where);
        $query = $this->db->get();
        $query_result = $query->result();
        // print_r($query_result);
        // die();
        return $query_result;
    }

    public function display_enquiry_detail_report_date_wise($user_id,$enquiry_no,$timesheet_from_date,$timesheet_to_date)
    {
        $this->db->select('enquiry_register.*,
                           customer_master.customer_name,
                           customer_contact_master.contact_person,
                           customer_contact_master.first_contact_no,
                           enquiry_tracking_master.tracking_date,
                           enquiry_tracking_master.tracking_record,
                           enquiry_tracking_master.next_action,
                           enquiry_tracking_master.action_due_date');
        $this->db->from('enquiry_register');
        $this->db->join('customer_master','enquiry_register.customer_id = customer_master.entity_id', 'INNER');
        $this->db->join('enquiry_tracking_master','enquiry_tracking_master.enquiry_id = enquiry_register.entity_id', 'INNER');
        $this->db->join('customer_contact_master','customer_master.entity_id = customer_contact_master.customer_id', 'INNER');

        $where = '(enquiry_register.user_id = "'.$user_id.'" And enquiry_register.enquiry_date >= "'.$timesheet_from_date.'" And enquiry_register.enquiry_date <= "'.$timesheet_to_date.'" And enquiry_register.entity_id = "'.$enquiry_no.'")';
        $this->db->where($where);
        $this->db->order_by('enquiry_tracking_master.entity_id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    // public function display_enquiry_detail_tracking_report_date_wise($user_id,$enquiry_no,$timesheet_from_date,$timesheet_to_date)
    // {
    //     $this->db->select('enquiry_tracking_master.*,
    //                        enquiry_register.enquiry_no,
    //                        enquiry_register.enquiry_short_desc,
    //                        enquiry_register.enquiry_date,
    //                        customer_master.customer_name');
    //     $this->db->from('enquiry_tracking_master');
    //     $this->db->join('enquiry_register','enquiry_tracking_master.enquiry_id = enquiry_register.entity_id', 'INNER');
    //     $this->db->join('customer_master','enquiry_tracking_master.customer_id = customer_master.entity_id', 'INNER');

    //     $where = '(enquiry_tracking_master.user_id >= "'.$user_id.'" And enquiry_tracking_master.tracking_date >= "'.$timesheet_from_date.'" And enquiry_tracking_master.tracking_date <= "'.$timesheet_to_date.'" And enquiry_tracking_master.enquiry_id = "'.$enquiry_no.'")';
    //     $this->db->where($where);
    //     //$this->db->order_by('sales_order_register.entity_id', 'DESC');
    //     $query = $this->db->get();
    //     $query_result = $query->result();
    //     return $query_result;  
    // }

    public function display_offer_summary_report_date_wise($user_id,$timesheet_from_date,$timesheet_to_date)
    {
        $this->db->select('offer_register.*,
                           customer_master.customer_name');
        $this->db->from('offer_register');
        $this->db->join('customer_master','offer_register.customer_id = customer_master.entity_id', 'INNER');

        $where = '(offer_register.user_id >= "'.$user_id.'" And offer_register.offer_date >= "'.$timesheet_from_date.'" And offer_register.offer_date <= "'.$timesheet_to_date.'")';
        $this->db->where($where);
        //$this->db->order_by('sales_order_register.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_all_offer($user_id)
    {
        $this->db->select('offer_register.offer_no,offer_register.entity_id');
        $this->db->from('offer_register');
        $where = '(offer_register.user_id = "'.$user_id.'" AND offer_register.status = "2")';
        $this->db->where($where);
        $query = $this->db->get();
        $query_result = $query->result();
        // print_r($query_result);
        // die();
        return $query_result;
    }

    public function display_offer_detail_report_date_wise($user_id,$offer_no,$timesheet_from_date,$timesheet_to_date)
    {
        $this->db->select('offer_register.*,
                           customer_master.customer_name,
                           customer_contact_master.contact_person,
                           customer_contact_master.first_contact_no,
                           enquiry_tracking_master.tracking_date,
                           enquiry_tracking_master.tracking_record,
                           enquiry_tracking_master.next_action,
                           enquiry_tracking_master.action_due_date');
        $this->db->from('offer_register');
        $this->db->join('customer_master','offer_register.customer_id = customer_master.entity_id', 'INNER');
        $this->db->join('customer_contact_master','customer_master.entity_id = customer_contact_master.customer_id', 'INNER');
        $this->db->join('enquiry_tracking_master','offer_register.entity_id = enquiry_tracking_master.offer_id', 'INNER');

        $where = '(offer_register.user_id >= "'.$user_id.'" And offer_register.offer_date >= "'.$timesheet_from_date.'" And offer_register.offer_date <= "'.$timesheet_to_date.'" And offer_register.entity_id = "'.$offer_no.'")';
        $this->db->where($where);
        $this->db->order_by('enquiry_tracking_master.entity_id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        $query_result = $query->result();
        // print_r($query_result);
        // die();
        return $query_result;  
    }


    // public function display_offer_report_of_product_date_wise_date_wise($user_id,$offer_no,$timesheet_from_date,$timesheet_to_date)
    // {
    //     $this->db->select('offer_product_relation.*');
    //     $this->db->from('offer_product_relation');
    //     $this->db->join('offer_register','offer_product_relation.offer_id = offer_register.entity_id', 'INNER');

    //     $where = '(offer_product_relation.user_id >= "'.$user_id.'" And offer_register.offer_date >= "'.$timesheet_from_date.'" And offer_register.offer_date <= "'.$timesheet_to_date.'" And offer_register.entity_id = "'.$offer_no.'")';
    //     $this->db->where($where);
    //     //$this->db->order_by('sales_order_register.entity_id', 'DESC');
    //     $query = $this->db->get();
    //     $query_result = $query->result();
    //     return $query_result;  
    // }

    // public function display_offer_report_of_service_date_wise_date_wise($user_id,$offer_no,$timesheet_from_date,$timesheet_to_date)
    // {
    //     $this->db->select('offer_service_relation.*');
    //     $this->db->from('offer_service_relation');
    //     $this->db->join('offer_register','offer_service_relation.offer_id = offer_register.entity_id', 'INNER');

    //     $where = '(offer_service_relation.user_id >= "'.$user_id.'" And offer_register.offer_date >= "'.$timesheet_from_date.'" And offer_register.offer_date <= "'.$timesheet_to_date.'" And offer_register.entity_id = "'.$offer_no.'")';
    //     $this->db->where($where);
    //     //$this->db->order_by('sales_order_register.entity_id', 'DESC');
    //     $query = $this->db->get();
    //     $query_result = $query->result();
    //     return $query_result;  
    // }

    // public function display_offer_detail_tracking_report_date_wise($user_id,$offer_no,$timesheet_from_date,$timesheet_to_date)
    // {
    //     $this->db->select('offer_tracking_master.*,
    //                        offer_register.offer_no,
    //                        offer_register.offer_description,
    //                        offer_register.offer_date,
    //                        customer_master.customer_name');
    //     $this->db->from('offer_tracking_master');
    //     $this->db->join('offer_register','offer_tracking_master.offer_id = offer_register.entity_id', 'INNER');
    //     $this->db->join('customer_master','offer_tracking_master.customer_id = customer_master.entity_id', 'INNER');
    //     // $this->db->join('enquiry_register','offer_tracking_master.enquiry_id = enquiry_register.entity_id', 'INNER');

    //     $where = '(offer_tracking_master.user_id >= "'.$user_id.'" And offer_tracking_master.tracking_date >= "'.$timesheet_from_date.'" And offer_tracking_master.tracking_date <= "'.$timesheet_to_date.'" And offer_tracking_master.offer_id = "'.$offer_no.'")';
    //     $this->db->where($where);
    //     //$this->db->order_by('sales_order_register.entity_id', 'DESC');
    //     $query = $this->db->get();
    //     $query_result = $query->result();
    //     // print_r($query_result);
    //     // die();
    //     return $query_result;  
    // }

    public function display_sales_summary_report_date_wise($timesheet_from_date,$timesheet_to_date)
    {
        $this->db->select('sales_order_register.*,
                           customer_master.customer_name');
        $this->db->from('sales_order_register');
        $this->db->join('customer_master','sales_order_register.customer_id = customer_master.entity_id', 'INNER');

        $where = '(sales_order_register.sales_order_date >= "'.$timesheet_from_date.'" And sales_order_register.sales_order_date <= "'.$timesheet_to_date.'")';
        $this->db->where($where);
        //$this->db->order_by('sales_order_register.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_all_order($user_id)
    {
        $this->db->select('sales_order_register.sales_order_no,sales_order_register.entity_id');
        $this->db->from('sales_order_register');
        $where = '(sales_order_register.user_id = "'.$user_id.'")';
        $this->db->where($where);
        $query = $this->db->get();
        $query_result = $query->result();
        // print_r($query_result);
        // die();
        return $query_result;
    }

    public function display_sales_detail_report_date_wise($user_id,$sales_order_no,$timesheet_from_date,$timesheet_to_date)
    {
        $this->db->select('sales_order_register.*,
                           customer_master.customer_name');
        $this->db->from('sales_order_register');
        $this->db->join('customer_master','sales_order_register.customer_id = customer_master.entity_id', 'INNER');

        $where = '(sales_order_register.user_id >= "'.$user_id.'" And sales_order_register.sales_order_date >= "'.$timesheet_from_date.'" And sales_order_register.sales_order_date <= "'.$timesheet_to_date.'" And sales_order_register.entity_id = "'.$sales_order_no.'")';
        $this->db->where($where);
        //$this->db->order_by('sales_order_register.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function display_sales_report_of_product_date_wise_date_wise($user_id,$sales_order_no,$timesheet_from_date,$timesheet_to_date)
    {
        $this->db->select('sales_order_product_relation.*');
        $this->db->from('sales_order_product_relation');
        $this->db->join('sales_order_register','sales_order_product_relation.sales_order_id = sales_order_register.entity_id', 'INNER');

        $where = '(sales_order_product_relation.user_id >= "'.$user_id.'" And sales_order_register.sales_order_date >= "'.$timesheet_from_date.'" And sales_order_register.sales_order_date <= "'.$timesheet_to_date.'" And sales_order_register.entity_id = "'.$sales_order_no.'")';
        $this->db->where($where);
        //$this->db->order_by('sales_order_register.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function display_sales_report_of_service_date_wise_date_wise($user_id,$sales_order_no,$timesheet_from_date,$timesheet_to_date)
    {
        $this->db->select('sales_order_service_relation.*');
        $this->db->from('sales_order_service_relation');
        $this->db->join('sales_order_register','sales_order_service_relation.sales_order_id = sales_order_register.entity_id', 'INNER');

        $where = '(sales_order_service_relation.user_id >= "'.$user_id.'" And sales_order_register.sales_order_date >= "'.$timesheet_from_date.'" And sales_order_register.sales_order_date <= "'.$timesheet_to_date.'" And sales_order_register.entity_id = "'.$sales_order_no.'")';
        $this->db->where($where);
        //$this->db->order_by('sales_order_register.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function display_purchase_register_report_date_wise($user_id,$timesheet_from_date,$timesheet_to_date)
    {
        $this->db->select('grn_product_register.*,
                           grn_register.entity_id AS Entity_id,
                           grn_register.grn_no,
                           grn_register.grn_date,
                           grn_register.po_id,
                           grn_register.document_description,
                           grn_register.invoice_number,
                           vendor_master.vendor_name,
                           vendor_master.gst_no');
        $this->db->from('grn_product_register');
        $this->db->join('grn_register','grn_product_register.grn_id = grn_register.entity_id', 'INNER');
        $this->db->join('vendor_master','grn_register.vendor_id = vendor_master.entity_id', 'INNER');

        $where = '(grn_register.user_id >= "'.$user_id.'" And grn_register.grn_date >= "'.$timesheet_from_date.'" And grn_register.grn_date <= "'.$timesheet_to_date.'")';
        $this->db->where($where);
        //$this->db->order_by('sales_order_register.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function display_collection_report_date_wise($user_id,$timesheet_from_date,$timesheet_to_date)
    {
        $this->db->select('payment_receivable_master.*,
                           invoice_register.invoice_no,
                           invoice_register.invoice_date,
                           customer_master.customer_name');
        $this->db->from('payment_receivable_master');
        $this->db->join('invoice_register','payment_receivable_master.invoice_id = invoice_register.entity_id', 'INNER');
        $this->db->join('customer_master','payment_receivable_master.customer_id = customer_master.entity_id', 'INNER');

        $where = '(payment_receivable_master.user_id >= "'.$user_id.'" And payment_receivable_master.received_date >= "'.$timesheet_from_date.'" And payment_receivable_master.received_date <= "'.$timesheet_to_date.'")';
        $this->db->where($where);
        //$this->db->order_by('sales_order_register.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_all_account_master_data($user_id)
    {
        $this->db->select('account_master.*');
        $this->db->from('account_master');
        $where = '(account_master.user_id = "'.$user_id.'")';
        $this->db->where($where);
        $query = $this->db->get();
        $query_result = $query->result();
        // print_r($query_result);
        // die();
        return $query_result;
    }

    public function display_expense_summary_report_date_wise($user_id,$account_head_name,$timesheet_from_date,$timesheet_to_date)
    {
        $this->db->select('expense_master.*,
                           account_master.account_head_name');
        $this->db->from('expense_master');
        $this->db->join('account_master','expense_master.account_id = account_master.entity_id', 'INNER');

        $where = '(expense_master.user_id >= "'.$user_id.'" And expense_master.expense_date >= "'.$timesheet_from_date.'" And expense_master.expense_date <= "'.$timesheet_to_date.'" And expense_master.account_id = "'.$account_head_name.'")';
        $this->db->where($where);
        //$this->db->order_by('sales_order_register.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }


    public function display_expense_detail_report_date_wise($user_id,$timesheet_from_date,$timesheet_to_date)
    {
        $this->db->select('expense_master.*,
                           account_master.account_head_name');
        $this->db->from('expense_master');
        $this->db->join('account_master','expense_master.account_id = account_master.entity_id', 'INNER');

        $where = '(expense_master.user_id >= "'.$user_id.'" And expense_master.expense_date >= "'.$timesheet_from_date.'" And expense_master.expense_date <= "'.$timesheet_to_date.'")';
        $this->db->where($where);
        //$this->db->order_by('sales_order_register.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function display_order_detail_report_date_wise($timesheet_from_date,$timesheet_to_date)
    {
        $this->db->select('sales_order_register.*,
                           customer_master.customer_name,
                           employee_master.emp_first_name,
                           employee_master.emp_middle_name,
                           employee_master.emp_last_name');
        $this->db->from('sales_order_register');
        $this->db->join('customer_master','sales_order_register.customer_id = customer_master.entity_id', 'INNER');
        $this->db->join('employee_master','sales_order_register.order_engg_name = employee_master.entity_id', 'INNER');
        $where = '(sales_order_register.sales_order_date >= "'.$timesheet_from_date.'" And sales_order_register.sales_order_date <= "'.$timesheet_to_date.'" AND sales_order_register.order_execution_status is NULL AND sales_order_register.allocation_status is NULL)';
        $this->db->where($where);
        $this->db->order_by('sales_order_register.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function display_invoice_register_report_date_wise($user_id,$timesheet_from_date,$timesheet_to_date)
    {
        $this->db->select('invoice_register.*,
                           customer_master.customer_name,
                           employee_master.emp_first_name,
                           employee_master.emp_middle_name,
                           employee_master.emp_last_name,
                           sales_order_register.sales_order_no,
                           sales_order_register.sales_order_date,
                           sales_order_register.sales_order_description');
        $this->db->from('invoice_register');
        $this->db->join('customer_master','invoice_register.customer_id = customer_master.entity_id', 'INNER');
        $this->db->join('sales_order_register','invoice_register.sales_order_id = sales_order_register.entity_id', 'INNER');
        $this->db->join('employee_master','sales_order_register.order_engg_name = employee_master.entity_id', 'INNER');
        $where = '(invoice_register.user_id = "'.$user_id.'" And invoice_register.invoice_date >= "'.$timesheet_from_date.'" And invoice_register.invoice_date <= "'.$timesheet_to_date.'")';
        $this->db->where($where);
        $this->db->order_by('invoice_register.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        // print_r($query_result);
        // die();
        return $query_result;  
    }

    public function display_pending_order_product_report_date_wise($user_id)
    {
        $this->db->select('sales_order_product_relation.*,
                           customer_master.customer_name,
                           sales_order_register.sales_order_no,
                           sales_order_register.sales_order_date,
                           sales_order_register.sales_order_description,
                           sales_order_register.bill_to_company_id,
                           sales_order_register.ship_to_company_id,
                           product_master.product_id');
        $this->db->from('sales_order_product_relation');
        $this->db->join('sales_order_register','sales_order_product_relation.sales_order_id = sales_order_register.entity_id', 'INNER');
        $this->db->join('product_master','sales_order_product_relation.product_id = product_master.entity_id', 'INNER');
        $this->db->join('customer_master','sales_order_register.customer_id = customer_master.entity_id', 'INNER');
        $where = '(sales_order_product_relation.user_id = "'.$user_id.'" And sales_order_product_relation.status = "1" OR sales_order_product_relation.status = "2")';
        $this->db->where($where);
        $this->db->order_by('sales_order_product_relation.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        // print_r($query_result);
        // die();
        return $query_result;  
    }

    public function display_pending_order_service_report_date_wise($user_id)
    {
        $this->db->select('sales_order_service_relation.*,
                           customer_master.customer_name,
                           sales_order_register.sales_order_no,
                           sales_order_register.sales_order_date,
                           sales_order_register.sales_order_description,
                           sales_order_register.bill_to_company_id,
                           sales_order_register.ship_to_company_id');
        $this->db->from('sales_order_service_relation');
        $this->db->join('sales_order_register','sales_order_service_relation.sales_order_id = sales_order_register.entity_id', 'INNER');
        
        $this->db->join('customer_master','sales_order_register.customer_id = customer_master.entity_id', 'INNER');
        $where = '(sales_order_service_relation.user_id = "'.$user_id.'" And sales_order_service_relation.invoice_status = "1" OR sales_order_service_relation.invoice_status = "2")';
        $this->db->where($where);
        $this->db->order_by('sales_order_service_relation.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        // print_r($query_result);
        // die();
        return $query_result;  
    }


    public function display_inventory_detail_report_date_wise($user_id,$timesheet_from_date,$timesheet_to_date)
    {
        $this->db->select('inventory_register_date_sheet.*,
                           product_master.product_id,
                           product_master.product_name,
                           product_category_master.category_name,
                           product_subcategory_master.subcategory_name,
                           product_pricelist_master.price');
        $this->db->from('inventory_register_date_sheet');
        $this->db->join('product_master','inventory_register_date_sheet.product_id = product_master.entity_id', 'INNER');
        $this->db->join('product_category_master','product_master.category_id = product_category_master.entity_id', 'INNER');
        $this->db->join('product_subcategory_master','product_master.subcategory_id = product_subcategory_master.entity_id', 'INNER');

        $this->db->join('product_pricelist_master','inventory_register_date_sheet.product_id = product_pricelist_master.product_id', 'INNER');
        $where = '(inventory_register_date_sheet.user_id = "'.$user_id.'" And inventory_register_date_sheet.date >= "'.$timesheet_from_date.'" And inventory_register_date_sheet.date <= "'.$timesheet_to_date.'")';
        $this->db->where($where);
        $this->db->order_by('inventory_register_date_sheet.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        // print_r($query_result);
        // die();
        return $query_result;  
    }


    public function display_tracking_detail_report_date_wise($user_id,$timesheet_from_date,$timesheet_to_date)
    {
        $this->db->select('enquiry_tracking_master.*,
                           customer_master.customer_name
                           ');
        $this->db->from('enquiry_tracking_master');
        $this->db->join('customer_master','enquiry_tracking_master.customer_id = customer_master.entity_id', 'INNER');
        
        $where = '(enquiry_tracking_master.user_id = "'.$user_id.'" And enquiry_tracking_master.tracking_date >= "'.$timesheet_from_date.'" And enquiry_tracking_master.tracking_date <= "'.$timesheet_to_date.'" AND enquiry_tracking_master.offer_id is NOT NULL)';
        $this->db->where($where);
        $this->db->order_by('enquiry_tracking_master.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        // print_r($query_result);
        // die();
        return $query_result;  
    }


    public function display_pending_order_detail_report_date_wise($timesheet_from_date,$timesheet_to_date,$product_id)
    {

       /* work_order_master.entity_id AS Entity_id,
       sales_order_register.*,
       customer_master.customer_name,
       employee_master.emp_first_name,
       employee_master.emp_middle_name,
       employee_master.emp_last_name,
       sales_order_product_relation.rfq_qty,
       product_master.product_name,
       sales_order_product_relation.product_custom_description*/

        $this->db->select('work_order_product_relation.*,
            sales_order_register.sales_order_no,
            product_master.product_name,
           employee_master.emp_first_name,
           employee_master.emp_middle_name,
           employee_master.emp_last_name,
           customer_master.customer_name,
           sales_order_register.sales_order_date,
           sales_order_register.sales_order_description');
        $this->db->from('work_order_product_relation');
        $this->db->join('work_order_master','work_order_product_relation.work_order_id = work_order_master.entity_id', 'INNER');
        $this->db->join('sales_order_register','work_order_master.sales_order_id = sales_order_register.entity_id', 'INNER');
        $this->db->join('product_master','work_order_product_relation.product_id = product_master.entity_id', 'INNER');



        $this->db->join('customer_master','sales_order_register.customer_id = customer_master.entity_id', 'INNER');
        $this->db->join('employee_master','sales_order_register.order_engg_name = employee_master.entity_id', 'INNER');

        $where = '(sales_order_register.sales_order_date >= "'.$timesheet_from_date.'" And sales_order_register.sales_order_date <= "'.$timesheet_to_date.'" And work_order_product_relation.product_id = "'.$product_id.'")';
        $this->db->where($where);
        $where1 = '(work_order_master.work_order_status = "1")';
        $this->db->where($where1);
        $this->db->order_by('work_order_master.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        // print_r($query_result);
        // die();
        return $query_result;
    }


    public function display_pending_enquiry_detail_report_date_wise($timesheet_from_date,$timesheet_to_date)
    {
        $this->db->select('enquiry_register.*,
                           customer_master.customer_name');
        $this->db->from('enquiry_register');

        $this->db->join('customer_master','enquiry_register.customer_id = customer_master.entity_id', 'INNER');
        $where = '(enquiry_register.enquiry_date >= "'.$timesheet_from_date.'" And enquiry_register.enquiry_date <= "'.$timesheet_to_date.'")';
        $this->db->where($where);
        $where1 = '(enquiry_register.enquiry_status = "1")';
        $this->db->where($where1);
        $this->db->order_by('enquiry_register.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        // print_r($query_result);
        // die();
        return $query_result;
    }


    public function get_indiamart_disqualified_leads($timesheet_from_date,$timesheet_to_date)
    {
        $this->db->select('*');
        $this->db->from('indiamart_api_log');

        // $this->db->join('customer_master','enquiry_register.customer_id = customer_master.entity_id', 'INNER');
        $where = '(indiamart_api_log.lead_date >= "'.$timesheet_from_date.'" And indiamart_api_log.lead_date <= "'.$timesheet_to_date.'" and indiamart_api_log.status = 3)';
        $this->db->where($where);
        $this->db->order_by('indiamart_api_log.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        // print_r($query_result);
        // die();
        return $query_result;
    }

	public function get_stage_list()
	{
		$this->db->select('*');
        $this->db->from('status_master_relation');
        //$this->db->join('','','');
        $where = '(status_for = 1)';
        $this->db->where($where);
        $stage_query = $this->db->get();
        //$query_num_rows = $query->num_rows();
        $stage_list = $stage_query->result();

		return $stage_list;
	}

    
    // public function get_all_offer_details($timesheet_from_date,$timesheet_to_date,$stage)
    // {
    //     $user_id = $_SESSION['user_id'];
    //     $emp_id = $_SESSION['emp_id'];
    //     $role_id = $_SESSION['role_id'];

    //     if($role_id ==1){
    //         $where1 = '(offer_register.offer_date >= "'.$timesheet_from_date.'" and offer_register.offer_date <= "'.$timesheet_to_date.'" )';
    //     }else{
    //         $where1 = '(offer_register.offer_date >= "'.$timesheet_from_date.'" and offer_register.offer_date <= "'.$timesheet_to_date.'" and offer_register.offer_engg_name = "'.$emp_id.'")';
    //     }

    //         $this->db->select('*,offer_register.entity_id as offer_id,offer_register.status as offer_status');
    //         $this->db->from('offer_register');
    //         $this->db->join('enquiry_register','enquiry_register.entity_id = offer_register.enquiry_id','left');
    //         $this->db->join('customer_master','customer_master.entity_id = offer_register.customer_id','left');
    //         $this->db->join('customer_contact_master','customer_contact_master.entity_id = offer_register.contact_person_id','inner');
    //         $this->db->join('employee_master','employee_master.entity_id = offer_register.offer_engg_name','inner');
    //         $this->db->join('enquiry_source_master','enquiry_source_master.entity_id = offer_register.offer_source','inner');
    //         $this->db->join('state_master','state_master.entity_id = customer_master.state_id','inner');
    //         // $where = '(offer_register.status = "'.'2'.'" or offer_register.status = "'.'6'.'" or offer_register.status = "'.'7'.'" or offer_register.status = "'.'8'.'" or  offer_register.status = "'.'9'.'")';
    //         // $this->db->where($where);
    //         $this->db->where($where1);
    //         $this->db->where_in('offer_register.status',$stage);
    //         $this->db->order_by('offer_register.entity_id', 'DESC');
    //         $query = $this->db->get();
    //         $query_result = $query->result();

          
    //         return $query_result;
       
    // }
    
    public function get_all_offer_details($timesheet_from_date,$timesheet_to_date,$stage,$employee_id)
    {

        $user_id = $_SESSION['user_id'];
        $emp_id = $_SESSION['emp_id'];
        $role_id = $_SESSION['role_id'];

        if($role_id ==1){
            $where1 = '(offer_register.offer_date >= "'.$timesheet_from_date.'" and offer_register.offer_date <= "'.$timesheet_to_date.'" )';
        }else{
            $where1 = '(offer_register.offer_date >= "'.$timesheet_from_date.'" and offer_register.offer_date <= "'.$timesheet_to_date.'" and offer_register.offer_engg_name = "'.$emp_id.'")';
        }

            $this->db->select('*,offer_register.entity_id as offer_id,rm_master.emp_first_name as rm_name,principle_engg_master.principle_engg_name,employee_master.emp_first_name as crm_name,lost_reason_master.status_name as lost_reason,status_master_relation.status_name as offer_status,offer_for_master.offer_for as type,offer_for_info.offer_for_info as series');
            $this->db->from('offer_register');
            $this->db->join('enquiry_register','enquiry_register.entity_id = offer_register.enquiry_id','left');
            $this->db->join('customer_master','customer_master.entity_id = offer_register.customer_id','left');
            $this->db->join('customer_contact_master','customer_contact_master.entity_id = offer_register.contact_person_id','inner');
            $this->db->join('principle_engg_master','principle_engg_master.entity_id = offer_register.offer_principle_engg_id','inner');
            $this->db->join('employee_master','employee_master.entity_id = offer_register.offer_engg_name','inner');
            $this->db->join('employee_master as rm_master','rm_master.entity_id = offer_register.offer_rm_employee_id','inner');
            $this->db->join('enquiry_source_master','enquiry_source_master.entity_id = offer_register.offer_source','inner');
            $this->db->join('state_master','state_master.entity_id = customer_master.state_id','inner');
            $this->db->join('offer_for_master','offer_for_master.entity_id = offer_register.offer_for','inner');
            $this->db->join('offer_for_info','offer_for_info.entity_id = offer_register.offer_for_info','inner');
            $this->db->join('status_master_relation','status_master_relation.entity_id = offer_register.status and status_master_relation.status_for = 1','inner');
            $this->db->join('status_master_relation as lost_reason_master','lost_reason_master.status_value = offer_register.reason_for_rejection and lost_reason_master.status_for = 2','left');
						$where1 = '(offer_register.offer_date >= "'.$timesheet_from_date.'" and offer_register.offer_date <= "'.$timesheet_to_date.'" )';
            $this->db->where($where1);
						if($employee_id > 0){
							$where2 = '(offer_register.offer_engg_name = "'.$employee_id.'")';
            $this->db->where($where2);
						}
						if(!empty($stage)){
            $this->db->where_in('offer_register.status',$stage);
						}
            // $where = '(offer_register.status = "'.'2'.'" or offer_register.status = "'.'6'.'" or offer_register.status = "'.'7'.'" or offer_register.status = "'.'8'.'" or  offer_register.status = "'.'9'.'")';
            // $this->db->where($where);
            // $this->db->where_in('offer_register.status',$stage);
            $this->db->order_by('offer_register.entity_id', 'DESC');
            $query = $this->db->get();
            $query_result = $query->result();

          
            return $query_result;
       
     }
    
    public function get_lost_offer_details($timesheet_from_date,$timesheet_to_date)
    {
        $user_id = $_SESSION['user_id'];
        $emp_id = $_SESSION['emp_id'];

            $this->db->select('*,offer_register.entity_id as offer_id,offer_register.status as offer_status');
            $this->db->from('offer_register');
            $this->db->join('enquiry_register','enquiry_register.entity_id = offer_register.enquiry_id','left');
            $this->db->join('customer_master','customer_master.entity_id = offer_register.customer_id','left');
            $this->db->join('customer_contact_master','customer_contact_master.entity_id = offer_register.contact_person_id','inner');
            $this->db->join('employee_master','employee_master.entity_id = offer_register.offer_engg_name','inner');
            $this->db->join('enquiry_source_master','enquiry_source_master.entity_id = offer_register.offer_source','inner');
            $where = '(offer_register.status = "'.'4'.'" )';
            $this->db->where($where);
            $where1 = '(offer_register.offer_date >= "'.$timesheet_from_date.'" and offer_register.offer_date <= "'.$timesheet_to_date.'" )';
            $this->db->where($where1);
            $this->db->order_by('offer_register.entity_id', 'DESC');
            $query = $this->db->get();
            $query_result = $query->result();

          
            return $query_result;
       
    }
    
    public function get_won_offer_details($timesheet_from_date,$timesheet_to_date)
    {
        $user_id = $_SESSION['user_id'];
        $emp_id = $_SESSION['emp_id'];

            $this->db->select('*,offer_register.entity_id as offer_id,offer_register.status as offer_status');
            $this->db->from('offer_register');
            $this->db->join('enquiry_register','enquiry_register.entity_id = offer_register.enquiry_id','left');
            $this->db->join('customer_master','customer_master.entity_id = offer_register.customer_id','left');
            $this->db->join('customer_contact_master','customer_contact_master.entity_id = offer_register.contact_person_id','inner');
            $this->db->join('employee_master','employee_master.entity_id = offer_register.offer_engg_name','inner');
            $this->db->join('enquiry_source_master','enquiry_source_master.entity_id = offer_register.offer_source','inner');
            $where = '(offer_register.status = "'.'6'.'" )';
            $this->db->where($where);
            $where1 = '(offer_register.offer_date >= "'.$timesheet_from_date.'" and offer_register.offer_date <= "'.$timesheet_to_date.'" )';
            $this->db->where($where1);
            $this->db->order_by('offer_register.entity_id', 'DESC');
            $query = $this->db->get();
            $query_result = $query->result();

          
            return $query_result;
       
    }

    public function display_pending_offer_detail_report_date_wise($timesheet_from_date,$timesheet_to_date)
    {
        $this->db->select('offer_register.*,
                           customer_master.customer_name');
        $this->db->from('offer_register');

        $this->db->join('customer_master','offer_register.customer_id = customer_master.entity_id', 'INNER');
        $where = '(offer_register.offer_date >= "'.$timesheet_from_date.'" And offer_register.offer_date <= "'.$timesheet_to_date.'")';
        $this->db->where($where);
        $where1 = '(offer_register.status = "2")';
        $this->db->where($where1);
        $this->db->order_by('offer_register.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        // print_r($query_result);
        // die();
        return $query_result;
    }

    public function display_pending_work_order_detail_report_date_wise($timesheet_from_date,$timesheet_to_date,$product_id)
    {
        $this->db->select('work_order_master.*');
        $this->db->from('work_order_master');

        $this->db->join('work_order_product_relation','work_order_master.entity_id = work_order_product_relation.work_order_id', 'INNER');

        $where = '(work_order_master.work_order_status = "'.'1'.'" AND work_order_master.work_order_date >= "'.$timesheet_from_date.'" And work_order_master.work_order_date <= "'.$timesheet_to_date.'" AND work_order_product_relation.product_id = "'.$product_id.'")';
        $this->db->where($where);
        $this->db->order_by('entity_id','DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }


    public function product_data_details()
    {
        $this->db->select('*');
        $this->db->from('product_master');
        $this->db->order_by('entity_id','DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        // print_r($query_result);
        // die();
        return $query_result;  
    }

    public function display_followup_calls_date_wise($timesheet_from_date,$timesheet_to_date)
    {

       /* work_order_master.entity_id AS Entity_id,
       sales_order_register.*,
       customer_master.customer_name,
       employee_master.emp_first_name,
       employee_master.emp_middle_name,
       employee_master.emp_last_name,
       sales_order_product_relation.rfq_qty,
       product_master.product_name,
       sales_order_product_relation.product_custom_description*/

        $this->db->select('call_log.*,
           telephone_master.client_name,telephone_master.mobile,telephone_master.company_name,campaign_register.campaign_name,employee_master.emp_first_name');
        $this->db->from('telephone_master');
        $this->db->join('call_log','call_log.telephone_id = telephone_master.entity_id', 'INNER');
        $this->db->join('campaign_register','call_log.campaign_id = campaign_register.entity_id', 'INNER');
        $this->db->join('campaign_emp_relation','campaign_register.entity_id = campaign_emp_relation.campaign_id', 'INNER');
        // $this->db->join('campaign_relation','campaign_relation.telephone_id = telephone_master.entity_id', 'INNER');
        // $this->db->join('customer_master','sales_order_register.customer_id = customer_master.entity_id', 'INNER');
        $this->db->join('employee_master','campaign_emp_relation.employee_id = employee_master.entity_id', 'INNER');

        $where = '(call_log.last_log_date >= "'.$timesheet_from_date.'" And call_log.last_log_date <= "'.$timesheet_to_date.'")';
        $this->db->where($where);
        $where1 = '(call_log.case_open_close = "2")';
        $this->db->where($where1);
        $this->db->order_by('call_log.last_log_date', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        // print_r($query_result);
        // die();
        return $query_result;
    }

    public function get_all_offers($offer_source)
    {
      $this->db->select('offer_date,offer_engg_name,offer_source,total_amount_with_gst');
      $this->db->from('offer_all_index');
      $where = '( status != "10")';
      $this->db->where($where);
      $where1 = '( offer_source = "'.$offer_source.'")';
      $this->db->where($where1);
      $query = $this->db->get();
      $query_result = $query->result();

      return $query_result;

    }

    public function get_engg_wise_offers($offer_source,$offer_engg_name)
    {
      $this->db->select('offer_date,offer_engg_name,offer_source,total_amount_with_gst');
      $this->db->from('offer_all_index');
      $where = '( status != "10" && offer_engg_name ="'. $offer_engg_name.'")';
      $this->db->where($where);
      $where1 = '( offer_source = "'.$offer_source.'")';
      $this->db->where($where1);
      $query = $this->db->get();
      $query_result = $query->result();

      return $query_result;

    }

    public function get_employee_list()
    {
        $this->db->select('*');
        $this->db->from('employee_master');
        $query = $this->db->get();
        return $query->result();
    }
    public function get_customer_list()
    {
        $this->db->select('*');
        $this->db->from('customer_master');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_month_list()
    {
        $this->db->select('*');
        $this->db->from('monthly_working_days_master');
        $query = $this->db->get();
        return $query->result();
    }

		public function get_relevant_customer_list_of_employee($emp_id)
		{
			$this->db->select('customer_master.entity_id as customer_id, customer_master.customer_name');
			$this->db->from('offer_register');
			$this->db->join('customer_master', 'customer_master.entity_id = offer_register.customer_id', 'inner');
			$where = '(offer_register.offer_engg_name = ' . $emp_id . ' and offer_register.status != 9  and offer_register.status != 1)';
			$this->db->where($where);
			$this->db->group_by('customer_id');
			$query = $this->db->get();
			return $query->result();
		}



    public function get_campaign_list()
    {
        $this->db->select('*');
        $this->db->from('campaign_register');
        $query = $this->db->get();
        return $query->result();
    }

    //merged from support

    public function display_warantee_summary_report_date_wise($user_id,$timesheet_from_date,$timesheet_to_date)
    {
        $this->db->select('ticket_master.*,count(ticket_master.entity_id) AS warantee_ticket_count');
        $this->db->from('ticket_master');
    //     $this->db->join('customer_master','enquiry_register.customer_id = customer_master.entity_id', 'INNER');
    
        $where = '(ticket_master.ticket_date >= "'.$timesheet_from_date.'" And ticket_master.ticket_date <= "'.$timesheet_to_date.'" AND status <= 2 AND ticket_type = 1)';
        $this->db->where($where);
    //     //$this->db->order_by('sales_order_register.entity_id', 'DESC');
        $this->db->order_by('ticket_master.product_make');
        $this->db->group_by('ticket_master.product_make');
        $query = $this->db->get();
        $query_result = $query->result();
    //     // print_r($query_result);
    //     // die();
        return $query_result;  
    }
}

?>

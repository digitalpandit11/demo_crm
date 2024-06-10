<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_controller extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('report_model');
        $this->load->library('session');
    }

    public function all_stock_report()
    {
        $user_id = $_SESSION['user_id'];
        $data['stock_details'] = $this->report_model->get_all_stock_report_details($user_id);
        $this->load->view('report/vw_all_stock_report',$data);
    }

    public function all_sheet_wise_stock_report()
    {
        $user_id = $_SESSION['user_id'];
        $data['sheet_wise_stock_details'] = $this->report_model->get_all_sheet_wise_stock_report_details($user_id);
        $this->load->view('report/vw_all_sheet_wise_stock_report',$data);
    }

    public function vw_sales_register_report_create()
    {
        // $user_id = $_SESSION['user_id'];
        //$data['sheet_wise_stock_details'] = $this->report_model->get_all_sheet_wise_stock_report_details($user_id);
        $this->load->view('report/vw_sales_register_report_create');
    }

    public function vw_sales_register_report_check()
    {
        // print_r($_POST);
        // die();
        $user_id = $_SESSION['user_id'];

        $timesheet_from_date = $this->input->post('timesheet_from_date');
        $timesheet_to_date = $this->input->post('timesheet_to_date');
        
        $result['user_id'] = $user_id;
        $result['timesheet_from_date'] = $timesheet_from_date;
        $result['timesheet_to_date'] = $timesheet_to_date;
        $result['sales_register_report_date_wise'] = $this->report_model->display_sales_register_report_date_wise($user_id,$timesheet_from_date,$timesheet_to_date);
        
        $result['sales_register_report_of_service_date_wise'] = $this->report_model->display_sales_register_report_of_service_date_wise($user_id,$timesheet_from_date,$timesheet_to_date);
        $this->load->view('report/vw_sales_register_report_date_wise_data',$result);

        
    }

    public function vw_pending_order_report_create()
    {
        // $user_id = $_SESSION['user_id'];
       //$data['sheet_wise_stock_details'] = $this->report_model->get_all_sheet_wise_stock_report_details($user_id);
        $this->load->view('report/vw_pending_order_report_create');
    }

    public function vw_pending_sales_order_report_check()
    {
        $user_id = $_SESSION['user_id'];
        $timesheet_from_date = $this->input->post('timesheet_from_date');
        $timesheet_to_date = $this->input->post('timesheet_to_date');
        
        $result['user_id'] = $user_id;
        $result['timesheet_from_date'] = $timesheet_from_date;
        $result['timesheet_to_date'] = $timesheet_to_date;
        $result['pending_sales_order_report_date_wise'] = $this->report_model->display_pending_sales_order_report_date_wise($user_id,$timesheet_from_date,$timesheet_to_date);
        $result['pending_sales_order_report_of_service_date_wise'] = $this->report_model->display_pending_sales_order_report_of_service_date_wise($user_id,$timesheet_from_date,$timesheet_to_date);
        $this->load->view('report/vw_pending_order_report_date_wise_data',$result);

        
    }

    public function vw_enquiry_tracking_report_create()
    {
        // $user_id = $_SESSION['user_id'];
        //$data['sheet_wise_stock_details'] = $this->report_model->get_all_sheet_wise_stock_report_details($user_id);
        $this->load->view('report/vw_enquiry_tracking_report_create');
    }

    public function vw_enquiry_tracking_report_check()
    {
        // print_r($_POST);
        // die();
        $user_id = $_SESSION['user_id'];

        $timesheet_from_date = $this->input->post('timesheet_from_date');
        $timesheet_to_date = $this->input->post('timesheet_to_date');
        
        $result['user_id'] = $user_id;
        $result['timesheet_from_date'] = $timesheet_from_date;
        $result['timesheet_to_date'] = $timesheet_to_date;
        $result['enquiry_tracking_report_date_wise'] = $this->report_model->display_enquiry_tracking_report_date_wise($user_id,$timesheet_from_date,$timesheet_to_date);
        $this->load->view('report/vw_enquiry_tracking_report_date_wise_data',$result);

    }

    public function vw_enquiry_summary_report_create()
    {
        // $user_id = $_SESSION['user_id'];
        //$data['sheet_wise_stock_details'] = $this->report_model->get_all_sheet_wise_stock_report_details($user_id);
        $this->load->view('report/vw_enquiry_summary_report_create');
    }

    public function vw_enquiry_summary_report_check()
    {
        // $user_id = $_SESSION['user_id'];
        // $timesheet_from_date = $this->input->post('timesheet_from_date');
        // $timesheet_to_date = $this->input->post('timesheet_to_date');
        // $result['user_id'] = $user_id;
        // $result['timesheet_from_date'] = $timesheet_from_date;
        // $result['timesheet_to_date'] = $timesheet_to_date;
        // $result['enquiry_summary_report_date_wise'] = $this->report_model->display_enquiry_summary_report_date_wise($user_id,$timesheet_from_date,$timesheet_to_date);
        // $this->load->view('report/vw_enquiry_summary_report_date_wise_data',$result);


        $user_id = $_SESSION['user_id'];
        $timesheet_from_date = $this->input->post('timesheet_from_date');
        $timesheet_to_date = $this->input->post('timesheet_to_date');
        $result['user_id'] = $user_id;
        $result['timesheet_from_date'] = $timesheet_from_date;
        $result['timesheet_to_date'] = $timesheet_to_date;
        // $result['enquiry_summary_report_date_wise_india_mart'] = $this->report_model->display_enquiry_summary_report_date_wise_india_mart($user_id,$timesheet_from_date,$timesheet_to_date);

        // $result['enquiry_summary_report_date_wise_excibition'] = $this->report_model->display_enquiry_summary_report_date_wise_excibition($user_id,$timesheet_from_date,$timesheet_to_date);
        // $result['enquiry_summary_report_date_wise_mid'] = $this->report_model->display_enquiry_summary_report_date_wise_mid($user_id,$timesheet_from_date,$timesheet_to_date);
        // $result['enquiry_summary_report_date_wise_phone_call'] = $this->report_model->display_enquiry_summary_report_date_wise_phone_call($user_id,$timesheet_from_date,$timesheet_to_date);
        // $result['enquiry_summary_report_date_wise_direct_mail'] = $this->report_model->display_enquiry_summary_report_date_wise_direct_mail($user_id,$timesheet_from_date,$timesheet_to_date);
        // $result['enquiry_summary_report_date_wise_others'] = $this->report_model->display_enquiry_summary_report_date_wise_others($user_id,$timesheet_from_date,$timesheet_to_date);
        $this->load->view('report/vw_enquiry_summary_report_date_wise_data',$result);

    }

    public function vw_enquiry_detail_report_create()
    {
        $user_id = $_SESSION['user_id'];
        //$data['sheet_wise_stock_details'] = $this->report_model->get_all_sheet_wise_stock_report_details($user_id);
        $data['enquiry_result'] = $this->report_model->get_all_enquiry($user_id);
        $this->load->view('report/vw_enquiry_detail_report_create',$data);
    }

    public function vw_enquiry_detail_report_check()
    {
        // print_r($_POST);
        // die();
        $user_id = $_SESSION['user_id'];

        $enquiry_no = $this->input->post('enquiry_no');
        // print_r($enquiry_no);
        // die();
        $timesheet_from_date = $this->input->post('timesheet_from_date');
        $timesheet_to_date = $this->input->post('timesheet_to_date');
        
        $result['user_id'] = $user_id;
        $result['timesheet_from_date'] = $timesheet_from_date;
        $result['timesheet_to_date'] = $timesheet_to_date;
        $result['enquiry_detail_report_date_wise'] = $this->report_model->display_enquiry_detail_report_date_wise($user_id,$enquiry_no,$timesheet_from_date,$timesheet_to_date);
        // $result['enquiry_detail_tracking_report_date_wise'] = $this->report_model->display_enquiry_detail_tracking_report_date_wise($user_id,$enquiry_no,$timesheet_from_date,$timesheet_to_date);

        $this->load->view('report/vw_enquiry_detail_report_date_wise_data',$result);

    }

    public function vw_offer_summary_report_create()
    {
        // $user_id = $_SESSION['user_id'];
        //$data['sheet_wise_stock_details'] = $this->report_model->get_all_sheet_wise_stock_report_details($user_id);
        $this->load->view('report/vw_offer_summary_report_create');
    }

    public function vw_offer_summary_report_check()
    {
        // print_r($_POST);
        // die();
        $user_id = $_SESSION['user_id'];

        $timesheet_from_date = $this->input->post('timesheet_from_date');
        $timesheet_to_date = $this->input->post('timesheet_to_date');
        
        $result['user_id'] = $user_id;
        $result['timesheet_from_date'] = $timesheet_from_date;
        $result['timesheet_to_date'] = $timesheet_to_date;
        $result['offer_summary_report_date_wise'] = $this->report_model->display_offer_summary_report_date_wise($user_id,$timesheet_from_date,$timesheet_to_date);
        $this->load->view('report/vw_offer_summary_report_date_wise_data',$result);

    }

    public function vw_offer_detail_report_create()
    {
        $user_id = $_SESSION['user_id'];
        //$data['sheet_wise_stock_details'] = $this->report_model->get_all_sheet_wise_stock_report_details($user_id);
        $data['offer_result'] = $this->report_model->get_all_offer($user_id);
        $this->load->view('report/vw_offer_detail_report_create',$data);
    }

    public function vw_offer_detail_report_check()
    {
        // print_r($_POST);
        // die();
        $user_id = $_SESSION['user_id'];

        $offer_no = $this->input->post('offer_no');
        // print_r($enquiry_no);
        // die();
        $timesheet_from_date = $this->input->post('timesheet_from_date');
        $timesheet_to_date = $this->input->post('timesheet_to_date');
        
        $result['user_id'] = $user_id;
        $result['timesheet_from_date'] = $timesheet_from_date;
        $result['timesheet_to_date'] = $timesheet_to_date;

        $result['offer_detail_report_date_wise'] = $this->report_model->display_offer_detail_report_date_wise($user_id,$offer_no,$timesheet_from_date,$timesheet_to_date);

        // $result['offer_report_of_product_date_wise'] = $this->report_model->display_offer_report_of_product_date_wise_date_wise($user_id,$offer_no,$timesheet_from_date,$timesheet_to_date);

        // $result['offer_report_of_service_date_wise'] = $this->report_model->display_offer_report_of_service_date_wise_date_wise($user_id,$offer_no,$timesheet_from_date,$timesheet_to_date);

        // $result['offer_detail_tracking_report_date_wise'] = $this->report_model->display_offer_detail_tracking_report_date_wise($user_id,$offer_no,$timesheet_from_date,$timesheet_to_date);

        $this->load->view('report/vw_offer_detail_report_date_wise_data',$result);

    }

    public function vw_sales_summary_report_create()
    {
        $user_id = $_SESSION['user_id'];
        //$data['sheet_wise_stock_details'] = $this->report_model->get_all_sheet_wise_stock_report_details($user_id);
        //$data['offer_result'] = $this->report_model->get_all_offer($user_id);
        $this->load->view('report/vw_sales_summary_report_create');
    }

    public function vw_sales_summary_report_check()
    {
        // print_r($_POST);
        // die();
        $user_id = $_SESSION['user_id'];

        $timesheet_from_date = $this->input->post('timesheet_from_date');
        $timesheet_to_date = $this->input->post('timesheet_to_date');
        
        // $result['user_id'] = $user_id;
        $result['timesheet_from_date'] = $timesheet_from_date;
        $result['timesheet_to_date'] = $timesheet_to_date;
        $result['sales_summary_report_date_wise'] = $this->report_model->display_sales_summary_report_date_wise($timesheet_from_date,$timesheet_to_date);
        $this->load->view('report/vw_sales_summary_report_date_wise_data',$result);
    }

    public function vw_sales_detail_report_create()
    {
        $user_id = $_SESSION['user_id'];
        //$data['sheet_wise_stock_details'] = $this->report_model->get_all_sheet_wise_stock_report_details($user_id);
        $data['order_result'] = $this->report_model->get_all_order($user_id);
        $this->load->view('report/vw_sales_detail_report_create',$data);
    }

    public function vw_sales_detail_report_check()
    {
        // print_r($_POST);
        // die();
        $user_id = $_SESSION['user_id'];

        $sales_order_no = $this->input->post('sales_order_no');
        // print_r($enquiry_no);
        // die();
        $timesheet_from_date = $this->input->post('timesheet_from_date');
        $timesheet_to_date = $this->input->post('timesheet_to_date');
        
        $result['user_id'] = $user_id;
        $result['timesheet_from_date'] = $timesheet_from_date;
        $result['timesheet_to_date'] = $timesheet_to_date;

        $result['sales_detail_report_date_wise'] = $this->report_model->display_sales_detail_report_date_wise($user_id,$sales_order_no,$timesheet_from_date,$timesheet_to_date);

        $result['sales_report_of_product_date_wise'] = $this->report_model->display_sales_report_of_product_date_wise_date_wise($user_id,$sales_order_no,$timesheet_from_date,$timesheet_to_date);

        $result['sales_report_of_service_date_wise'] = $this->report_model->display_sales_report_of_service_date_wise_date_wise($user_id,$sales_order_no,$timesheet_from_date,$timesheet_to_date);

        $this->load->view('report/vw_sales_detail_report_date_wise_data',$result);

    }

    public function vw_purchase_register_report_create()
    {
        // $user_id = $_SESSION['user_id'];
        //$data['sheet_wise_stock_details'] = $this->report_model->get_all_sheet_wise_stock_report_details($user_id);
        $this->load->view('report/vw_purchase_register_report_create');
    }

    public function vw_purchase_register_report_check()
    {
        // print_r($_POST);
        // die();
        $user_id = $_SESSION['user_id'];

        $timesheet_from_date = $this->input->post('timesheet_from_date');
        $timesheet_to_date = $this->input->post('timesheet_to_date');
        
        $result['user_id'] = $user_id;
        $result['timesheet_from_date'] = $timesheet_from_date;
        $result['timesheet_to_date'] = $timesheet_to_date;
        $result['purchase_register_report_date_wise'] = $this->report_model->display_purchase_register_report_date_wise($user_id,$timesheet_from_date,$timesheet_to_date);
        $this->load->view('report/vw_purchase_register_report_date_wise_data',$result);

    }

    public function vw_collection_report_create()
    {
        // $user_id = $_SESSION['user_id'];
        //$data['sheet_wise_stock_details'] = $this->report_model->get_all_sheet_wise_stock_report_details($user_id);
        $this->load->view('report/vw_collection_report_create');
    }

    public function vw_collection_report_check()
    {
        // print_r($_POST);
        // die();
        $user_id = $_SESSION['user_id'];

        $timesheet_from_date = $this->input->post('timesheet_from_date');
        $timesheet_to_date = $this->input->post('timesheet_to_date');
        
        $result['user_id'] = $user_id;
        $result['timesheet_from_date'] = $timesheet_from_date;
        $result['timesheet_to_date'] = $timesheet_to_date;
        $result['collection_report_date_wise'] = $this->report_model->display_collection_report_date_wise($user_id,$timesheet_from_date,$timesheet_to_date);
        $this->load->view('report/vw_collection_report_date_wise_data',$result);

    }

    public function vw_expense_summary_report_create()
    {
        $user_id = $_SESSION['user_id'];
        //$data['sheet_wise_stock_details'] = $this->report_model->get_all_sheet_wise_stock_report_details($user_id);
        $data['account_result'] = $this->report_model->get_all_account_master_data($user_id);
        $this->load->view('report/vw_expense_summary_report_create',$data);
    }

    public function vw_expense_summary_report_check()
    {
        // print_r($_POST);
        // die();
        $user_id = $_SESSION['user_id'];

        $account_head_name = $this->input->post('account_head_name');
        // print_r($enquiry_no);
        // die();
        $timesheet_from_date = $this->input->post('timesheet_from_date');
        $timesheet_to_date = $this->input->post('timesheet_to_date');
        
        $result['user_id'] = $user_id;
        $result['timesheet_from_date'] = $timesheet_from_date;
        $result['timesheet_to_date'] = $timesheet_to_date;

        $result['expense_summary_report_date_wise'] = $this->report_model->display_expense_summary_report_date_wise($user_id,$account_head_name,$timesheet_from_date,$timesheet_to_date);

        $this->load->view('report/vw_expense_summary_report_date_wise_data',$result);

    }

    public function vw_expense_detail_report_create()
    {
        $user_id = $_SESSION['user_id'];
        //$data['sheet_wise_stock_details'] = $this->report_model->get_all_sheet_wise_stock_report_details($user_id);
        //$data['account_result'] = $this->report_model->get_all_account_master_data($user_id);
        $this->load->view('report/vw_expense_detail_report_create');
    }

    public function vw_expense_detail_report_check()
    {
        // print_r($_POST);
        // die();
        $user_id = $_SESSION['user_id'];
        $timesheet_from_date = $this->input->post('timesheet_from_date');
        $timesheet_to_date = $this->input->post('timesheet_to_date');
        
        $result['user_id'] = $user_id;
        $result['timesheet_from_date'] = $timesheet_from_date;
        $result['timesheet_to_date'] = $timesheet_to_date;

        $result['expense_detail_report_date_wise'] = $this->report_model->display_expense_detail_report_date_wise($user_id,$timesheet_from_date,$timesheet_to_date);

        $this->load->view('report/vw_expense_detail_report_date_wise_data',$result);

    }


    public function vw_order_detail_report_create()
    {
        // $user_id = $_SESSION['user_id'];
        //$data['sheet_wise_stock_details'] = $this->report_model->get_all_sheet_wise_stock_report_details($user_id);
        $this->load->view('report/vw_order_detail_report_create');
    }


    public function vw_order_detail_report_check()
    {
        // print_r($_POST);
        // die();
        $user_id = $_SESSION['user_id'];

        //$enquiry_no = $this->input->post('enquiry_no');
        // print_r($enquiry_no);
        // die();
        $timesheet_from_date = $this->input->post('timesheet_from_date');
        $timesheet_to_date = $this->input->post('timesheet_to_date');
        
        // $result['user_id'] = $user_id;
        $result['timesheet_from_date'] = $timesheet_from_date;
        $result['timesheet_to_date'] = $timesheet_to_date;
        $result['order_detail_report_date_wise'] = $this->report_model->display_order_detail_report_date_wise($timesheet_from_date,$timesheet_to_date);
        // $result['enquiry_detail_tracking_report_date_wise'] = $this->report_model->display_enquiry_detail_tracking_report_date_wise($user_id,$enquiry_no,$timesheet_from_date,$timesheet_to_date);

        $this->load->view('report/vw_order_detail_report_date_wise_data',$result);

    }

    public function vw_invoice_register_report_create()
    {
        // $user_id = $_SESSION['user_id'];
        //$data['sheet_wise_stock_details'] = $this->report_model->get_all_sheet_wise_stock_report_details($user_id);
        $this->load->view('report/vw_invoice_register_report_create');
    }

    public function vw_invoice_register_report_check()
    {
        // print_r($_POST);
        // die();
        $user_id = $_SESSION['user_id'];

        //$enquiry_no = $this->input->post('enquiry_no');
        // print_r($enquiry_no);
        // die();
        $timesheet_from_date = $this->input->post('timesheet_from_date');
        $timesheet_to_date = $this->input->post('timesheet_to_date');
        
        $result['user_id'] = $user_id;
        $result['timesheet_from_date'] = $timesheet_from_date;
        $result['timesheet_to_date'] = $timesheet_to_date;
        $result['invoice_register_report_date_wise'] = $this->report_model->display_invoice_register_report_date_wise($user_id,$timesheet_from_date,$timesheet_to_date);
        // $result['enquiry_detail_tracking_report_date_wise'] = $this->report_model->display_enquiry_detail_tracking_report_date_wise($user_id,$enquiry_no,$timesheet_from_date,$timesheet_to_date);

        $this->load->view('report/vw_invoice_register_report_date_wise_data',$result);

    }

    public function vw_pending_order_report_check()
    {
        // print_r($_POST);
        // die();
        $user_id = $_SESSION['user_id'];

        //$enquiry_no = $this->input->post('enquiry_no');
        // print_r($enquiry_no);
        // die();
        // $timesheet_from_date = $this->input->post('timesheet_from_date');
        // $timesheet_to_date = $this->input->post('timesheet_to_date');
        
        $result['user_id'] = $user_id;
        // $result['timesheet_from_date'] = $timesheet_from_date;
        // $result['timesheet_to_date'] = $timesheet_to_date;
        $result['pending_order_product_report_date_wise'] = $this->report_model->display_pending_order_product_report_date_wise($user_id);
        $result['pending_order_service_report_date_wise'] = $this->report_model->display_pending_order_service_report_date_wise($user_id);
        

        $this->load->view('report/vw_pending_orders_data_report_date_wise_data',$result);

    }


    public function vw_inventory_detail_report_create()
    {
        // $user_id = $_SESSION['user_id'];
        //$data['sheet_wise_stock_details'] = $this->report_model->get_all_sheet_wise_stock_report_details($user_id);
        $this->load->view('report/vw_inventory_detail_report_create');
    }

    public function vw_inventory_detail_report_check()
    {
        // print_r($_POST);
        // die();
        $user_id = $_SESSION['user_id'];

        //$enquiry_no = $this->input->post('enquiry_no');
        // print_r($enquiry_no);
        // die();
        $timesheet_from_date = $this->input->post('timesheet_from_date');
        $timesheet_to_date = $this->input->post('timesheet_to_date');
        
        $result['user_id'] = $user_id;
        $result['timesheet_from_date'] = $timesheet_from_date;
        $result['timesheet_to_date'] = $timesheet_to_date;
        $result['inventory_detail_report_date_wise'] = $this->report_model->display_inventory_detail_report_date_wise($user_id,$timesheet_from_date,$timesheet_to_date);
        // $result['enquiry_detail_tracking_report_date_wise'] = $this->report_model->display_enquiry_detail_tracking_report_date_wise($user_id,$enquiry_no,$timesheet_from_date,$timesheet_to_date);

        $this->load->view('report/vw_inventory_detail_report_date_wise_data',$result);

    }

    public function vw_tracking_detail_report_create()
    {
        // $user_id = $_SESSION['user_id'];
        //$data['sheet_wise_stock_details'] = $this->report_model->get_all_sheet_wise_stock_report_details($user_id);
        $this->load->view('report/vw_tracking_detail_report_create');
    }

    public function vw_tracking_detail_report_check()
    {
        // print_r($_POST);
        // die();
        $user_id = $_SESSION['user_id'];

        //$enquiry_no = $this->input->post('enquiry_no');
        // print_r($enquiry_no);
        // die();
        $timesheet_from_date = $this->input->post('timesheet_from_date');
        $timesheet_to_date = $this->input->post('timesheet_to_date');
        
        $result['user_id'] = $user_id;
        $result['timesheet_from_date'] = $timesheet_from_date;
        $result['timesheet_to_date'] = $timesheet_to_date;
        $result['tracking_detail_report_date_wise'] = $this->report_model->display_tracking_detail_report_date_wise($user_id,$timesheet_from_date,$timesheet_to_date);
        // $result['enquiry_detail_tracking_report_date_wise'] = $this->report_model->display_enquiry_detail_tracking_report_date_wise($user_id,$enquiry_no,$timesheet_from_date,$timesheet_to_date);

        $this->load->view('report/vw_tracking_detail_report_date_wise_data',$result);

    }


    public function vw_pending_sales_register_report_create()
    {
        // $user_id = $_SESSION['user_id'];
        $data['product_data_details'] = $this->report_model->product_data_details();
        $this->load->view('report/vw_pending_sales_register_report_create',$data);
    }


    public function vw_pending_order_detail_report_check()
    {
        // print_r($_POST);
        // die();
        $user_id = $_SESSION['user_id'];

        //$enquiry_no = $this->input->post('enquiry_no');
        // print_r($enquiry_no);
        // die();
        $timesheet_from_date = $this->input->post('timesheet_from_date');
        $timesheet_to_date = $this->input->post('timesheet_to_date');
        $product_id = $this->input->post('product_id');
        
        // $result['user_id'] = $user_id;
        $result['timesheet_from_date'] = $timesheet_from_date;
        $result['timesheet_to_date'] = $timesheet_to_date;
        $result['pending_order_detail_report_date_wise'] = $this->report_model->display_pending_order_detail_report_date_wise($timesheet_from_date,$timesheet_to_date,$product_id);
        // $result['enquiry_detail_tracking_report_date_wise'] = $this->report_model->display_enquiry_detail_tracking_report_date_wise($user_id,$enquiry_no,$timesheet_from_date,$timesheet_to_date);

        $this->load->view('report/vw_pending_order_detail_report_date_wise_data',$result);

    }

    public function vw_pending_enquiry_report_create()
    {
        // $user_id = $_SESSION['user_id'];
        //$data['sheet_wise_stock_details'] = $this->report_model->get_all_sheet_wise_stock_report_details($user_id);
        $this->load->view('report/vw_pending_enquiry_report_create');
    }

    public function vw_disqualified_indiamart_leads()
    {
        // $user_id = $_SESSION['user_id'];
        //$data['sheet_wise_stock_details'] = $this->report_model->get_all_sheet_wise_stock_report_details($user_id);
        $this->load->view('report/vw_disqualified_indiamart_leads_create');
    }

 
    public function generate_disqualified_indiamart_leads_report()
    {
        // print_r($_POST);
        // die();
        $user_id = $_SESSION['user_id'];

        //$enquiry_no = $this->input->post('enquiry_no');
        // print_r($enquiry_no);
        // die();
        $timesheet_from_date = $this->input->post('timesheet_from_date');
        $timesheet_to_date = $this->input->post('timesheet_to_date');
        
        // $result['user_id'] = $user_id;
        $result['timesheet_from_date'] = $timesheet_from_date;
        $result['timesheet_to_date'] = $timesheet_to_date;
        $result['indiamart_disqualified_leads'] = $this->report_model->get_indiamart_disqualified_leads($timesheet_from_date,$timesheet_to_date);
        // $result['enquiry_detail_tracking_report_date_wise'] = $this->report_model->display_enquiry_detail_tracking_report_date_wise($user_id,$enquiry_no,$timesheet_from_date,$timesheet_to_date);

        $this->load->view('report/vw_indiamart_disqualified_leads_report',$result);

    }
 
 
    public function create_quotation_register()
    {
       
        $user_id = $_SESSION['user_id'];
     

        // $timesheet_from_date = $this->input->post('timesheet_from_date');
        // $timesheet_to_date = $this->input->post('timesheet_to_date');
        
        // $result['timesheet_from_date'] = $timesheet_from_date;
        // $result['timesheet_to_date'] = $timesheet_to_date;
        // $result['indiamart_disqualified_leads'] = $this->report_model->get_all_offer_details($timesheet_from_date,$timesheet_to_date);
        $this->db->select('*');
        $this->db->from('status_master_relation');
        //$this->db->join('','','');
        $where = '(status_for = 1)';
        $this->db->where($where);
        $stage_query = $this->db->get();
        //$query_num_rows = $query->num_rows();
        $stage_list = $stage_query->result();

        $data['stage_list'] = $stage_list;
       
        $this->load->view('report/vw_quotation_register_report_create',$data);

    }
 
 
    public function generate_quotation_register_report()
    {
       
        $user_id = $_SESSION['user_id'];
     

        $timesheet_from_date = $this->input->post('timesheet_from_date');
        $timesheet_to_date = $this->input->post('timesheet_to_date');
        $stage = $this->input->post('stage');
        
        $result['timesheet_from_date'] = $timesheet_from_date;
        $result['timesheet_to_date'] = $timesheet_to_date;
        $result['offer_list'] = $this->report_model->get_all_offer_details($timesheet_from_date,$timesheet_to_date,$stage);
       
        $this->load->view('report/vw_quotation_register_report',$result);

    }
 
 
    public function create_state_wise_quotation_register()
    {
       
        $user_id = $_SESSION['user_id'];
     

        // $timesheet_from_date = $this->input->post('timesheet_from_date');
        // $timesheet_to_date = $this->input->post('timesheet_to_date');
        
        // $result['timesheet_from_date'] = $timesheet_from_date;
        // $result['timesheet_to_date'] = $timesheet_to_date;
        // $result['indiamart_disqualified_leads'] = $this->report_model->get_all_offer_details($timesheet_from_date,$timesheet_to_date);
       
        $this->load->view('report/vw_state_wise_quotation_register_report_create');

    }
 
 
    public function generate_state_wise_quotation_register_report()
    {
       
        $user_id = $_SESSION['user_id'];
     

        $timesheet_from_date = $this->input->post('timesheet_from_date');
        $timesheet_to_date = $this->input->post('timesheet_to_date');
        
        $result['timesheet_from_date'] = $timesheet_from_date;
        $result['timesheet_to_date'] = $timesheet_to_date;
        $result['offer_list'] = $this->report_model->get_all_offer_details($timesheet_from_date,$timesheet_to_date);
       
        $this->load->view('report/vw_state_wise_quotation_register_report',$result);

    }
 
 
    public function create_order_lost_report()
    {
        $user_id = $_SESSION['user_id'];
     
        $this->load->view('report/vw_order_lost_report_create');
    }
 
 
    public function generate_order_lost_report()
    {       
        $user_id = $_SESSION['user_id'];

        $timesheet_from_date = $this->input->post('timesheet_from_date');
        $timesheet_to_date = $this->input->post('timesheet_to_date');
        
        $result['timesheet_from_date'] = $timesheet_from_date;
        $result['timesheet_to_date'] = $timesheet_to_date;
        $result['offer_list'] = $this->report_model->get_lost_offer_details($timesheet_from_date,$timesheet_to_date);
       
        $this->load->view('report/vw_order_lost_report',$result);
    }
 
 
    public function create_order_won_report()
    {
        $user_id = $_SESSION['user_id'];
     
        $this->load->view('report/vw_order_won_report_create');
    }
 
 
    public function generate_order_won_report()
    {       
        $user_id = $_SESSION['user_id'];

        $timesheet_from_date = $this->input->post('timesheet_from_date');
        $timesheet_to_date = $this->input->post('timesheet_to_date');
        
        $result['timesheet_from_date'] = $timesheet_from_date;
        $result['timesheet_to_date'] = $timesheet_to_date;
        $result['offer_list'] = $this->report_model->get_won_offer_details($timesheet_from_date,$timesheet_to_date);
       
        $this->load->view('report/vw_order_won_report',$result);
    }
 
    public function create_stage_wise_quotation_summary()
    {
       
        $user_id = $_SESSION['user_id'];
     

        // $timesheet_from_date = $this->input->post('timesheet_from_date');
        // $timesheet_to_date = $this->input->post('timesheet_to_date');
        
        // $result['timesheet_from_date'] = $timesheet_from_date;
        // $result['timesheet_to_date'] = $timesheet_to_date;
        // $result['indiamart_disqualified_leads'] = $this->report_model->get_all_offer_details($timesheet_from_date,$timesheet_to_date);
       
        $this->load->view('report/vw_stage_wise_quotation_summary_report_create');

    }
 
 
    public function generate_stage_wise_quotation_summary_report()
    {
       
        $user_id = $_SESSION['user_id'];
     

        $timesheet_from_date = $this->input->post('timesheet_from_date');
        $timesheet_to_date = $this->input->post('timesheet_to_date');
        
        $result['timesheet_from_date'] = $timesheet_from_date;
        $result['timesheet_to_date'] = $timesheet_to_date;
        $result['offer_list'] = $this->report_model->get_all_offer_details($timesheet_from_date,$timesheet_to_date);
       
        $this->load->view('report/vw_stage_wise_quotation_summary_report',$result);

    }
 
    public function vw_status_wise_quotation_summary_report()
    {
      
        $user_id = $_SESSION['user_id'];
     

        // $timesheet_from_date = $this->input->post('timesheet_from_date');
        // $timesheet_to_date = $this->input->post('timesheet_to_date');
        
        // $result['timesheet_from_date'] = $timesheet_from_date;
        // $result['timesheet_to_date'] = $timesheet_to_date;
        $result['employee_list'] = $this->report_model->get_employee_list();
       
        $this->load->view('report/vw_status_wise_quotation_summary_report',$result);

    }
 
 
    public function create_brand_wise_quotation_summary()
    {
       
        $user_id = $_SESSION['user_id'];
     

        // $timesheet_from_date = $this->input->post('timesheet_from_date');
        // $timesheet_to_date = $this->input->post('timesheet_to_date');
        
        // $result['timesheet_from_date'] = $timesheet_from_date;
        // $result['timesheet_to_date'] = $timesheet_to_date;
        // $result['indiamart_disqualified_leads'] = $this->report_model->get_all_offer_details($timesheet_from_date,$timesheet_to_date);
       
        $this->load->view('report/vw_brand_wise_quotation_summary_report_create');

    }
 
 
    public function generate_brand_wise_quotation_summary_report()
    {
       
        $user_id = $_SESSION['user_id'];
     

        $timesheet_from_date = $this->input->post('timesheet_from_date');
        $timesheet_to_date = $this->input->post('timesheet_to_date');
        
        $result['timesheet_from_date'] = $timesheet_from_date;
        $result['timesheet_to_date'] = $timesheet_to_date;
        $result['offer_list'] = $this->report_model->get_all_offer_details($timesheet_from_date,$timesheet_to_date);
       
        $this->load->view('report/vw_brand_wise_quotation_summary_report',$result);

    }
 
    public function vw_pending_enquiry_detail_report_check()
    {
        // print_r($_POST);
        // die();
        $user_id = $_SESSION['user_id'];

        //$enquiry_no = $this->input->post('enquiry_no');
        // print_r($enquiry_no);
        // die();
        $timesheet_from_date = $this->input->post('timesheet_from_date');
        $timesheet_to_date = $this->input->post('timesheet_to_date');
        
        // $result['user_id'] = $user_id;
        $result['timesheet_from_date'] = $timesheet_from_date;
        $result['timesheet_to_date'] = $timesheet_to_date;
        $result['pending_enquiry_report_date_wise'] = $this->report_model->display_pending_enquiry_detail_report_date_wise($timesheet_from_date,$timesheet_to_date);
        // $result['enquiry_detail_tracking_report_date_wise'] = $this->report_model->display_enquiry_detail_tracking_report_date_wise($user_id,$enquiry_no,$timesheet_from_date,$timesheet_to_date);

        $this->load->view('report/vw_pending_enquiry_detail_report_date_wise_data',$result);

    }


    public function vw_pending_offer_report_create()
    {
        // $user_id = $_SESSION['user_id'];
        //$data['sheet_wise_stock_details'] = $this->report_model->get_all_sheet_wise_stock_report_details($user_id);
        $this->load->view('report/vw_pending_offer_report_create');
    }

    public function vw_pending_offer_detail_report_check()
    {
        // print_r($_POST);
        // die();
        $user_id = $_SESSION['user_id'];

        //$enquiry_no = $this->input->post('enquiry_no');
        // print_r($enquiry_no);
        // die();
        $timesheet_from_date = $this->input->post('timesheet_from_date');
        $timesheet_to_date = $this->input->post('timesheet_to_date');
        
        // $result['user_id'] = $user_id;
        $result['timesheet_from_date'] = $timesheet_from_date;
        $result['timesheet_to_date'] = $timesheet_to_date;
        $result['pending_offer_report_date_wise'] = $this->report_model->display_pending_offer_detail_report_date_wise($timesheet_from_date,$timesheet_to_date);
        // $result['enquiry_detail_tracking_report_date_wise'] = $this->report_model->display_enquiry_detail_tracking_report_date_wise($user_id,$enquiry_no,$timesheet_from_date,$timesheet_to_date);

        $this->load->view('report/vw_pending_offer_detail_report_date_wise_data',$result);

    }






    public function vw_pending_work_order_create()
    {
        // $user_id = $_SESSION['user_id'];
        $data['product_data_details'] = $this->report_model->product_data_details();
        $this->load->view('report/vw_pending_work_order_create',$data);
    }

    public function vw_pending_work_order_detail_report_check()
    {
        // print_r($_POST);
        // die();
        $user_id = $_SESSION['user_id'];

        //$enquiry_no = $this->input->post('enquiry_no');
        // print_r($enquiry_no);
        // die();
        $timesheet_from_date = $this->input->post('timesheet_from_date');
        $timesheet_to_date = $this->input->post('timesheet_to_date');
        $product_id = $this->input->post('product_id');
        
        // $result['user_id'] = $user_id;
        $result['timesheet_from_date'] = $timesheet_from_date;
        $result['timesheet_to_date'] = $timesheet_to_date;
        $result['pending_work_order_report_date_wise'] = $this->report_model->display_pending_work_order_detail_report_date_wise($timesheet_from_date,$timesheet_to_date,$product_id);
        // $result['enquiry_detail_tracking_report_date_wise'] = $this->report_model->display_enquiry_detail_tracking_report_date_wise($user_id,$enquiry_no,$timesheet_from_date,$timesheet_to_date);

        $this->load->view('report/vw_pending_work_order_detail_report_date_wise_data',$result);

    }

    public function vw_summary_report_create()
    {
        $this->load->view('report/vw_summary_report_create');
    }

    public function engg_wise_quotation_source_summary_report()
    {
        $offer_engg_name = $this->input->post('offer_engg_name');
    //     $this->db->select('*');
    //     $this->db->from('enquiry_source_master');
    //     $query = $this->db->get();
    //     $sources = $query->result_array();

    //   $source_array = [];
    //   $source_engg = [];
    //   foreach ($sources as $key => $value) {
    //     $source_result= $this->report_model->get_engg_wise_offers($value['entity_id'],$offer_engg_name);
    //     foreach($source_result as $key => $value1){
          
    //       $source_engg[$key]['engg']= $value1->offer_engg_name;
    //       $source_engg[$key]['date']= $value1->offer_date;
    //       $source_engg[$key]['amt']= $value1->total_amount_with_gst;
    //       $source_engg[$key]['source']= $value1->offer_source;
    //       // $value['source_array']['date']= $value1->offer_date;
    //     }
        
    //     // $source_array[$value['source_name']]= $source_engg;
        
    //     $source_array[$key][$value['entity_id']]= $source_engg;
        
    //   }
      
      
    //   // echo '<pre>';
    //   // print_r($source_array);
    //   // die();
      

    //   $data['offer_details'] = $source_array;
      $data['offer_engg_name'] = $offer_engg_name;
      $this->load->view('report/vw_engg_wise_quotation_source_summary_report',$data);
    }

    public function engg_wise_won_quotation_source_summary_report()
    {
        $offer_engg_name = $this->input->post('offer_engg_name');
    
    //   $data['offer_details'] = $source_array;
      $data['offer_engg_name'] = $offer_engg_name;
      $this->load->view('report/vw_engg_wise_won_quotation_source_summary_report',$data);
    }

    public function quotation_source_summary_report()
    {
      $this->db->select('*');
      $this->db->from('enquiry_source_master');
      $query = $this->db->get();
      $sources = $query->result_array();

      $source_array = [];
      $source_engg = [];
      foreach ($sources as $key => $value) {
        $source_result= $this->report_model->get_all_offers($value['entity_id']);
        foreach($source_result as $key => $value1){
          
          $source_engg[$key]['engg']= $value1->offer_engg_name;
          $source_engg[$key]['date']= $value1->offer_date;
          $source_engg[$key]['amt']= $value1->total_amount_with_gst;
          $source_engg[$key]['source']= $value1->offer_source;
          // $value['source_array']['date']= $value1->offer_date;
        }
        
        // $source_array[$value['source_name']]= $source_engg;
        
        $source_array[$key][$value['entity_id']]= $source_engg;
        
      }
      
      
      // echo '<pre>';
      // print_r($source_array);
      // die();
      

      $data['offer_details'] = $source_array;
      $this->load->view('report/vw_quotation_source_summary_report',$data);
    }

    public function won_quotation_source_summary_report()
    {
      $this->db->select('*');
      $this->db->from('enquiry_source_master');
      $query = $this->db->get();
      $sources = $query->result_array();

      $source_array = [];
      $source_engg = [];
      foreach ($sources as $key => $value) {
        $source_result= $this->report_model->get_all_offers($value['entity_id']);
        foreach($source_result as $key => $value1){
          
          $source_engg[$key]['engg']= $value1->offer_engg_name;
          $source_engg[$key]['date']= $value1->offer_date;
          $source_engg[$key]['amt']= $value1->total_amount_with_gst;
          $source_engg[$key]['source']= $value1->offer_source;
          // $value['source_array']['date']= $value1->offer_date;
        }
        
        // $source_array[$value['source_name']]= $source_engg;
        
        $source_array[$key][$value['entity_id']]= $source_engg;
        
      }
      
      
      // echo '<pre>';
      // print_r($source_array);
      // die();
      

      $data['offer_details'] = $source_array;
      $this->load->view('report/vw_won_quotation_source_summary_report');
    }

    public function vw_pricelist()
    {
     
        $this->db->select('*');
        $this->db->from('download_pricelist');
        $this->db->order_by('entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        $data['pricelist'] =  $query_result;  


        // SQL VIEW QUERY
        // CREATE OR REPLACE VIEW download_pricelist AS
        // SELECT product_master.*,product_hsn_master.hsn_code,product_hsn_master.total_gst_percentage,product_category_master.category_name,product_make_master.make_name,unit_master.unit_name,product_pricelist_master.price
        // FROM product_master
        // LEFT JOIN product_hsn_master
        // ON product_hsn_master.entity_id = product_master.hsn_id
        // LEFT JOIN product_category_master
        // ON product_category_master.entity_id = product_master.category_id
        // LEFT JOIN product_make_master
        // ON product_make_master.entity_id = product_master.product_make
        // LEFT JOIN product_pricelist_master
        // ON product_pricelist_master.product_id = product_master.entity_id
        // LEFT JOIN unit_master
        // ON unit_master.entity_id = product_master.unit
        // ORDER BY product_master.product_id ASC;



      $this->load->view('report/vw_pricelist',$data);
    }

   public function vw_call_summary_report_create()
    {
      
        $data['campaign_list'] = $this->report_model->get_campaign_list();
        $this->load->view('report/vw_call_summary_report_create',$data);
    }
    

   public function vw_engg_wise_source_summary()
    {
      
        $emp_id = $_SESSION['emp_id'];
        $role_id = $_SESSION['role_id'];
        if($role_id ==1)
        {
      $data['offer_engg_list'] = $this->report_model->get_employee_list();
        }else{
            $this->db->select('*');
            $this->db->from('employee_master');
            //$this->db->join('','','');
            $where = '(entity_id = "'.$emp_id.'")';
            $this->db->where($where);
            $emp_query = $this->db->get();
            //$query_num_rows = $query->num_rows();
            $data['offer_engg_list']  = $emp_query->result();
        }
        $this->load->view('report/vw_engg_wise_source_summary_create',$data);
    }
    

   public function vw_engg_wise_won_source_summary()
    {
      
        $emp_id = $_SESSION['emp_id'];
        $role_id = $_SESSION['role_id'];
        if($role_id ==1)
        {
      $data['offer_engg_list'] = $this->report_model->get_employee_list();
        }else{
            $this->db->select('*');
            $this->db->from('employee_master');
            //$this->db->join('','','');
            $where = '(entity_id = "'.$emp_id.'")';
            $this->db->where($where);
            $emp_query = $this->db->get();
            //$query_num_rows = $query->num_rows();
            $data['offer_engg_list']  = $emp_query->result();
        }
        $this->load->view('report/vw_engg_wise_won_source_summary_create',$data);
    }
    
    // public function vw_engg_wise_weekly_summary()
    // {
      
    //     $emp_id = $_SESSION['emp_id'];
    //     $role_id = $_SESSION['role_id'];
    //     if($role_id ==1)
    //     {
    //   $data['offer_engg_list'] = $this->report_model->get_employee_list();
    //     }else{
    //         $this->db->select('*');
    //         $this->db->from('employee_master');
    //         //$this->db->join('','','');
    //         $where = '(entity_id = "'.$emp_id.'")';
    //         $this->db->where($where);
    //         $emp_query = $this->db->get();
    //         //$query_num_rows = $query->num_rows();
    //         $data['offer_engg_list']  = $emp_query->result();
    //     }
    //     $this->load->view('report/vw_engg_wise_weekly_summary_create',$data);
    // }

   public function vw_engg_wise_monthly_summary()
    {
      
      
        $emp_id = $_SESSION['emp_id'];
        $role_id = $_SESSION['role_id'];
        if($role_id ==1)
        {
      $data['offer_engg_list'] = $this->report_model->get_employee_list();
        }else{
            $this->db->select('*');
            $this->db->from('employee_master');
            //$this->db->join('','','');
            $where = '(entity_id = "'.$emp_id.'")';
            $this->db->where($where);
            $emp_query = $this->db->get();
            //$query_num_rows = $query->num_rows();
            $data['offer_engg_list']  = $emp_query->result();
        }
        $this->load->view('report/vw_engg_wise_monthly_summary_create',$data);
    }

    public function vw_engg_wise_weekly_summary()
    {
      
        $emp_id = $_SESSION['emp_id'];
        $role_id = $_SESSION['role_id'];
        if($role_id ==1)
        {
      $data['offer_engg_list'] = $this->report_model->get_employee_list();
        }else{
            $this->db->select('*');
            $this->db->from('employee_master');
            //$this->db->join('','','');
            $where = '(entity_id = "'.$emp_id.'")';
            $this->db->where($where);
            $emp_query = $this->db->get();
            //$query_num_rows = $query->num_rows();
            $data['offer_engg_list']  = $emp_query->result();
        }
        $this->load->view('report/vw_engg_wise_weekly_summary_create',$data);
    }

    
    public function engg_wise_quotation_monthly_summary_report()
    {
        $offer_engg_name = $this->input->post('offer_engg_name');
    
      $data['offer_engg_name'] = $offer_engg_name;
      $this->load->view('report/vw_engg_wise_quotation_monthly_summary_report',$data);
    }
    
    public function weekly_quotation_summary_report()
    {
        $offer_engg_name = $this->input->post('offer_engg_name');
    
      $data['offer_engg_name'] = $offer_engg_name;
      $this->load->view('report/vw_weekly_quotation_summary_report',$data);
    }

    public function engg_wise_quotation_weekly_summary_report()
    {
        $offer_engg_name = $this->input->post('offer_engg_name');
    
      $data['offer_engg_name'] = $offer_engg_name;
      $this->load->view('report/vw_engg_wise_quotation_weekly_summary_report',$data);
    }

    
    // public function engg_wise_quotation_weekly_summary_report()
    // {
    //     $offer_engg_name = $this->input->post('offer_engg_name');
    
    //   $data['offer_engg_name'] = $offer_engg_name;
    //   $this->load->view('report/vw_engg_wise_quotation_weekly_summary_report',$data);
    // }

    
    public function vw_call_summary_report()
    {
      $user_id = $_SESSION['user_id'];

    
      $campaign_id = $this->input->post('campaign');
      $timesheet_from_date = $this->input->post('timesheet_from_date');
      $timesheet_to_date = $this->input->post('timesheet_to_date');
      // $result['user_id'] = $user_id;
      $result['campaign_id'] = $campaign_id;
      $result['timesheet_from_date'] = $timesheet_from_date;
      $result['timesheet_to_date'] = $timesheet_to_date;  
      $this->load->view('report/vw_call_summary_report', $result);
    }

    public function vw_followup_calls_create()
    {
        // $user_id = $_SESSION['user_id'];
        $data['product_data_details'] = $this->report_model->product_data_details();
        $this->load->view('report/vw_followup_calls_create',$data);
    }

    public function vw_followup_calls_check()
    {
        // print_r($_POST);
        // die();
         $user_id = $_SESSION['user_id'];

        //$enquiry_no = $this->input->post('enquiry_no');
        // print_r($enquiry_no);
        // die();
        $timesheet_from_date = $this->input->post('timesheet_from_date');
        $timesheet_to_date = $this->input->post('timesheet_to_date');
        // $product_id = $this->input->post('product_id');
        
        // $result['user_id'] = $user_id;
        $result['timesheet_from_date'] = $timesheet_from_date;
        $result['timesheet_to_date'] = $timesheet_to_date;
        $result['followup_calls_date_wise'] = $this->report_model->display_followup_calls_date_wise($timesheet_from_date,$timesheet_to_date);
        // $result['enquiry_detail_tracking_report_date_wise'] = $this->report_model->display_enquiry_detail_tracking_report_date_wise($user_id,$enquiry_no,$timesheet_from_date,$timesheet_to_date);

        $this->load->view('report/vw_followup_calls_data', $result);

    }

    //merged from support

    public function vw_warantee_summary_report_create()
    {
        // $user_id = $_SESSION['user_id'];
        //$data['sheet_wise_stock_details'] = $this->report_model->get_all_sheet_wise_stock_report_details($user_id);
        $this->load->view('report/vw_warantee_summary_report');
    }

    
    public function vw_warantee_summary_report_check()
    {
        $user_id = $_SESSION['user_id'];
        $timesheet_from_date = $this->input->post('timesheet_from_date');
        $timesheet_to_date = $this->input->post('timesheet_to_date');
        $result['user_id'] = $user_id;
        $result['timesheet_from_date'] = $timesheet_from_date;
        $result['timesheet_to_date'] = $timesheet_to_date;
        $result['data'] = $this->report_model->display_warantee_summary_report_date_wise($user_id,$timesheet_from_date,$timesheet_to_date);
        $this->load->view('report/vw_warantee_summary_report_date_wise_data',$result);

    }


    
}
?>

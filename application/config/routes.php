<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
// $route['default_controller'] = 'welcome';
// $route['404_override'] = '';
// $route['translate_uri_dashes'] = FALSE;


// Login
$route['default_controller'] = "welcome";
$route['dashboard'] = "welcome/dashboard";
$route['support_dashboard'] = "welcome/support_dashboard";
$route['vw_profile']='welcome/profile';
$route['second_login_page/:any'] = "welcome/second_login_page";

//Indiamart Api
$route['search_india_mart_lead'] = "indiamart_api";
$route['import_india_mart_lead'] = "indiamart_api/import_india_mart_lead";
$route['create_indiamart_lead/:any'] = "indiamart_api/create_india_mart_lead";

$route['search_trade_india_lead'] = "indiamart_api/trade_india";
$route['create_trade_india_lead/:any'] = "indiamart_api/create_trade_india_lead";

// User Master URL'S
$route['vw_regestration_create'] = "master/user_master/vw_regestration_create";
$route['vw_regestration_data'] = "master/user_master/display_regestration_data";
$route['edit_user_info/:any'] = "master/user_master/edit_user_info";
$route['delete_user_info/:any'] = "master/user_master/delete_user_info";
$route['vw_view_regestration/:any'] = "master/user_master/vw_view_regestration";

//Product category Master
$route['product_category'] = "master/product_category_master";
$route['create_product_category_master'] = "master/product_category_master/create";
$route['edit_product_category/:any'] = "master/product_category_master/edit_product_category";
$route['delete_product_category/:any'] = "master/product_category_master/delete_product_category";
$route['view_product_category/:any'] = "master/product_category_master/view_product_category";

//Product Sub category Master
$route['product_sub_category'] = "master/product_sub_category_master";
$route['create_product_sub_category_master'] = "master/product_sub_category_master/create";
$route['edit_product_sub_category/:any'] = "master/product_sub_category_master/edit_product_sub_category";
$route['delete_product_sub_category/:any'] = "master/product_sub_category_master/delete_product_sub_category";
$route['view_product_sub_category/:any'] = "master/product_sub_category_master/view_product_sub_category";

//Product Master
$route['product_master'] = "master/product_master";
$route['create_product_master'] = "master/product_master/create";
$route['edit_product_master/:any'] = "master/product_master/edit_product_master";
$route['view_product_master/:any'] = "master/product_master/view_product_master";
$route['delete_product_master/:any'] = "master/product_master/delete_product_master";

//Role Master
$route['vw_role_data'] = "master/role_master";
$route['vw_role_master'] = "master/role_master/vw_role_master";
$route['edit_role_master/:any'] = "master/role_master/edit_role_master";
$route['view_role_master/:any'] = "master/role_master/view_role_master";
$route['delete_role_data/:any'] = "master/role_master/delete_role_data";

//Material Make Master
$route['vw_material_make_master'] = "master/material_make_master";
$route['create_material_make_master'] = "master/material_make_master/create";
$route['edit_material_make_master/:any'] = "master/material_make_master/edit_material_make_master";
$route['view_material_make_master/:any'] = "master/material_make_master/view_material_make_master";
$route['delete_material_make_master/:any'] = "master/material_make_master/delete_material_make_master";

//Document Series Master
$route['vw_document_series_data'] = "master/document_series_master";
$route['vw_document_series_master'] = "master/document_series_master/vw_document_series_master";
$route['edit_document_series_master/:any'] = "master/document_series_master/edit_document_series_master";
$route['view_document_series_master/:any'] = "master/document_series_master/view_document_series_master";
$route['delete_document_series_data/:any'] = "master/document_series_master/delete_document_series_data";

//HSN Code Master
$route['vw_hsn_data'] = "master/hsn_master";
$route['vw_hsn_master'] = "master/hsn_master/vw_hsn_master";
$route['edit_hsn_master/:any'] = "master/hsn_master/edit_hsn_master";
$route['view_hsn_master/:any'] = "master/hsn_master/view_hsn_master";
$route['delete_hsn_data/:any'] = "master/hsn_master/delete_hsn_data";

//State Master
$route['vw_state_data'] = "master/state_master";
$route['vw_state_master'] = "master/state_master/vw_state_master";
$route['edit_state_master/:any'] = "master/state_master/edit_state_master";
$route['view_state_master/:any'] = "master/state_master/view_state_master";
$route['delete_state_data/:any'] = "master/state_master/delete_state_data";

//City Master
$route['vw_city_data'] = "master/city_master";
$route['vw_city_master'] = "master/city_master/vw_city_master";
$route['edit_city_master/:any'] = "master/city_master/edit_city_master";
$route['view_city_master/:any'] = "master/city_master/view_city_master";

//Employee Master
$route['employee_master'] = "master/employee_master";
$route['create_employee_master'] = "master/employee_master/create_employee";
$route['edit_employee_master/:any'] = "master/employee_master/edit_employee_master";
$route['view_employee_master/:any'] = "master/employee_master/view_employee_master";

//Company Master
$route['company_master'] = "master/company_master";
$route['create_company_master'] = "master/company_master/create_company";
$route['edit_company_master/:any'] = "master/company_master/edit_company_master";
$route['view_company_master/:any'] = "master/company_master/view_company_master";

//Customer Master
/*$route['vw_customer_master'] = "master/customer_master";
$route['create_customer_master'] = "master/customer_master/create";
$route['edit_customer_master/:any'] = "master/customer_master/edit_customer_master";
$route['update_customer_master/:any'] = "master/customer_master/update_customer_master";
$route['update_customer_master/:any'] = "master/customer_master/edit_customer_master";
$route['view_customer_master/:any'] = "master/customer_master/view_customer_master";
$route['delete_customer_master/:any'] = "master/customer_master/soft_delete_customer_master";*/
//Customer Master
$route['vw_customer_index'] = "master/customer_master";
$route['vw_erp_product_vw_customer_master'] = "master/customer_master";
$route['create_customer_master'] = "master/customer_master/create";
$route['edit_customer_master/:any'] = "master/customer_master/edit_customer_master";
/*$route['update_customer_master/:any'] = "master/customer_master/update_customer_master";*/
$route['update_customer_master/:any'] = "master/customer_master/edit_customer_master";
$route['delete_customer/:any'] = "master/customer_master/delete_customer";
$route['view_customer_master/:any'] = "master/customer_master/view_customer_master";
$route['vw_erp_product_vw_customer_master_all_details'] = "master/customer_master/view_all_data";
$route['delete_customer/:any'] = "master/customer_master/delete_customer";
$route['add_india_mart_customer/(:num)'] = "master/customer_master/add_india_mart_customer";
$route['get_ajax_customer_data'] = "master/customer_master/ajax_customer_index";
$route['get_ajax_customer_view_data'] = "master/customer_master/ajax_customer_view_index";

//Unit Master
$route['vw_unit_data'] = "master/unit_master";
$route['vw_unit_master'] = "master/unit_master/vw_unit_master";
$route['edit_unit_master/:any'] = "master/unit_master/edit_unit_master";
$route['view_unit_master/:any'] = "master/unit_master/view_unit_master";


//Enquiry Master
$route['vw_enquiry_data'] = "sales/enquiry_register";
$route['create_customer_enquiry'] = "sales/enquiry_register/create";
$route['create_customer_enquiry/:any'] = "sales/enquiry_register/create";
$route['update_enquiry_data/:any'] = "sales/enquiry_register/update_enquiry_data";
$route['view_enquiry_data/:any'] = "sales/enquiry_register/view_enquiry_data";
$route['delete_enquiry_data/:any'] = "sales/enquiry_register/delete_enquiry_data";
$route['vw_all_enquiry_data'] = "sales/enquiry_register/vw_all_enquiry_data";
$route['vw_old_enquiry_data'] = "sales/enquiry_register/vw_old_enquiry_data";
$route['delete_enquiry_attach_image/:any'] = "sales/enquiry_register/delete_enquiry_attach_image";
$route['vw_indiamartenquiry_data'] = "sales/enquiry_register/vw_indiamartenquiry_data";
$route['create_customer_indiamartenquiry'] = "sales/enquiry_register/create_customer_indiamartenquiry";
$route['update_indiamart_enquiry_data/:any'] = "sales/enquiry_register/update_indiamart_enquiry_data";
$route['import_india_mart_lead'] = "sales/enquiry_register/import_india_mart_lead";
$route['get_ajax_enquiry_data'] = "sales/enquiry_register/get_all_ajax_enquiry_data";

$route['create_customer_lead'] = "sales/enquiry_register/create_lead";
$route['create_customer_lead2'] = "sales/enquiry_register/create_lead2";

//Enquiry Type Master
$route['vw_enquiry_type_master'] = "master/enquiry_type_master";
$route['create_enquiry_type_master'] = "master/enquiry_type_master/create";
$route['edit_enquiry_type_master/:any'] = "master/enquiry_type_master/edit_enquiry_type_master";
$route['view_enquiry_type_master/:any'] = "master/enquiry_type_master/view_enquiry_type_master";
$route['delete_enquiry_type/:any'] = "master/enquiry_type_master/delete_enquiry_type";

//Enquiry Source Master
$route['vw_enquiry_source_master'] = "master/enquiry_source_master";
$route['create_enquiry_source_master'] = "master/enquiry_source_master/create";
$route['edit_enquiry_source_master/:any'] = "master/enquiry_source_master/edit_enquiry_source_master";
$route['view_enquiry_source_master/:any'] = "master/enquiry_source_master/view_enquiry_source_master";
$route['delete_enquiry_source/:any'] = "master/enquiry_source_master/delete_enquiry_source";


//Offer Master
$route['vw_offer_data'] = "sales/offer_register";
$route['fetch_working_offers'] = "sales/offer_register/fetch_working_offers";
$route['create_customer_offer'] = "sales/offer_register/create_customer_offer";
$route['setoffer/:any'] = "sales/offer_register/enquiry_to_offer_save";
$route['update_offer_data/:any'] = "sales/offer_register/update_offer_data";
$route['view_offer_data/:any'] = "sales/offer_register/view_offer_data";
$route['download_offer/:any'] = "sales/offer_register/download_offer";
$route['set_revision_offer/:any'] = "sales/offer_register/set_revision_offer_save";
$route['vw_all_offer_data'] = "sales/offer_register/vw_all_offer_data";
$route['vw_my_offer_data'] = "sales/offer_register/vw_my_offer_data";
$route['vw_draft_offer_data'] = "sales/offer_register/vw_draft_offer_data";
$route['delete_attach_image/:any'] = "sales/offer_register/delete_attach_image";
$route['create_offer_without_lead'] = "sales/offer_register/create_offer_wo_lead";
$route['create_offer_without_lead/(:num)'] = "sales/offer_register/create_offer_wo_lead";
$route['edit_offer_without_lead/(:num)'] = "sales/offer_register/edit_offer_wo_lead";
$route['old_offers']='sales/offer_register/old_offers';
$route['get_ajax_offer_data'] = "sales/offer_register/ajax_index";
$route['get_ajax_all_offer_data'] = "sales/offer_register/vw_ajax_all_offer_data";
$route['create_offer_from_contact/:any'] = "sales/offer_register/create_offer_from_contact";
$route['download_offer_without_gst/:any'] = "sales/offer_register/download_offer_without_gst";


//Order Master
$route['vw_sales_order_data'] = "sales/sales_order_register";
$route['create_customer_sales_order'] = "sales/sales_order_register/create_customer_sales_order";
$route['setorder/:any'] = "sales/sales_order_register/offer_to_order_save";
$route['update_sales_order_data/:any'] = "sales/sales_order_register/update_sales_order_data";
$route['view_sales_order_data/:any'] = "sales/sales_order_register/view_sales_order_data";
$route['vw_all_sales_order_data'] = "sales/sales_order_register/vw_all_sales_order_data";
$route['delete_attach_order_image/:any'] = "sales/sales_order_register/delete_attach_order_image";
$route['vw_pending_sales_order_data'] = "sales/sales_order_register/pending_sales_order_for_approver";
$route['update_pending_sales_order_data/:any'] = "sales/sales_order_register/update_pending_sales_order";
$route['vw_all_rejected_sales_order_data'] = "sales/sales_order_register/rejected_sales_order";
$route['update_rejected_sales_order_data/:any'] = "sales/sales_order_register/update_rejected_sales_order";
$route['vw_approved_sales_order_data'] = "sales/sales_order_register/approved_sales_order";
$route['view_approved_sales_order_data/:any'] = "sales/sales_order_register/view_approved_sales_order";

$route['vw_sales_order_without_offer'] = "sales/sales_order_register/vw_sales_order_without_offer";
$route['update_sales_order_data_without_offer/:any'] = "sales/sales_order_register/update_sales_order_data_without_offer";
$route['view_sales_order_data_without_offer/:any'] = "sales/sales_order_register/view_sales_order_data_without_offer";
$route['update_pending_sales_order_without_offer/:any'] = "sales/sales_order_register/update_pending_sales_order_without_offer";

$route['update_rejected_sales_order_without_offer_data/:any'] = "sales/sales_order_register/update_rejected_sales_order_without_offer_data";

$route['create_quick_sales_order'] = "sales/sales_order_register/create_quick_sales_order";
$route['update_quick_sales_order_data/:any'] = "sales/sales_order_register/update_quick_sales_order_data";
$route['view_quick_sales_order_data/:any'] = "sales/sales_order_register/view_quick_sales_order_data";
$route['set_duplicate_order/:any'] = "sales/sales_order_register/set_duplicate_order";

// Purchase Order
$route['vw_purchase_order_data'] = "sales/purchase_order_register";
$route['create_purchase_order_against_sales_order/:any'] = "sales/purchase_order_register/so_to_po_save";
$route['second_po_edit_page/:any'] = "sales/purchase_order_register/second_po_edit_page";
$route['view_purchase_order_data/:any'] = "sales/purchase_order_register/view_purchase_order_data";
$route['download_purchase_order/:any'] = "sales/purchase_order_register/download_purchase_order";

// Performa Invoice
$route['vw_performa_invoice_data'] = "sales/performa_invoice_register";
$route['create_performa_invoice'] = "sales/performa_invoice_register/create";
$route['create_performa_against_sales_order/:any'] = "sales/performa_invoice_register/so_to_performa_save";
$route['second_performa_edit_page/:any'] = "sales/performa_invoice_register/second_performa_edit_page";
$route['cancel_performa_invoice/:any'] = "sales/performa_invoice_register/cancel_performa_invoice";

//Order Execution 
$route['vw_sales_order_execution_data'] = "factory/order_execution_master";
$route['update_order_execution/:any'] = "factory/order_execution_master/update_order_execution_data";
$route['vw_approved_sales_order_execution_data'] = "factory/order_execution_master/view_approved_sales_order_execution";

//Work Order
$route['vw_work_order_data'] = "factory/work_order_register";
$route['create_work_order'] = "factory/work_order_register/create";
$route['edit_work_order_data/:any'] = "factory/work_order_register/edit_work_order_data";
$route['update_second_category_order/:any'] = "factory/work_order_register/update_second_category_order";
$route['view_second_category_order/:any'] = "factory/work_order_register/view_second_category_order";
$route['update_first_category_order/:any'] = "factory/work_order_register/update_first_category_order";
$route['view_first_category_order/:any'] = "factory/work_order_register/view_first_category_order";
$route['vw_completed_order_data'] = "factory/work_order_register/all_completed_order_list";
$route['download_normal_workorder/:any'] = "factory/work_order_register/download_normal_workorder";
$route['download_normal_tradeorder/:any'] = "factory/work_order_register/download_normal_tradeorder";
$route['all_work_order'] = "factory/work_order_register/all_work_order";

$route['download_so_workorder/:any'] = "factory/work_order_register/download_so_workorder";
$route['download_so_tradeorder/:any'] = "factory/work_order_register/download_so_tradeorder";


//Enquiry Tracking 
$route['vw_tracking_entry'] = "sales/enquiry_tracking_register";
$route['create_customer_enquiry_tracking'] = "sales/enquiry_tracking_register/create";
$route['set_track_enquiry/:any'] = "sales/enquiry_tracking_register/set_track_enquiry";
$route['vw_tracking_report'] = "sales/enquiry_tracking_register/tracking_report";
$route['set_track_offer/:any'] = "sales/enquiry_tracking_register/set_track_offer";
$route['update_next_action/:any'] = "sales/enquiry_tracking_register/update_next_action";
$route['vw_tracking_data_entry'] = "sales/enquiry_tracking_register/add_tracking";
$route['task_index'] = "sales/enquiry_tracking_register/task_index";
$route['todays_task_index'] = "sales/enquiry_tracking_register/todays_task_index";
$route['overdue_task_index'] = "sales/enquiry_tracking_register/overdue_task_index";
$route['close_next_action'] = "sales/enquiry_tracking_register/close_next_action";


//Offer Tracking 
// $route['vw_tracking_entry'] = "sales/enquiry_tracking_register";
// $route['create_customer_enquiry_tracking'] = "sales/enquiry_tracking_register/create";
// $route['vw_tracking_report'] = "sales/enquiry_tracking_register/tracking_report";

//Reports
$route['vw_working_sales_order'] = "report/report_controller/vw_sales_register_report_create";
$route['vw_pending_sales_order'] = "report/report_controller/vw_pending_sales_register_report_create";
$route['vw_pending_enquiry_report'] = "report/report_controller/vw_pending_enquiry_report_create";
$route['vw_pending_offer_report'] = "report/report_controller/vw_pending_offer_report_create";
$route['vw_disqualified_indiamart_leads'] = "report/report_controller/vw_disqualified_indiamart_leads";
$route['generate_disqualified_indiamart_leads_report'] = "report/report_controller/generate_disqualified_indiamart_leads_report";
$route['vw_pending_work_order'] = "report/report_controller/vw_pending_work_order_create";
$route['vw_sales_summary_report_create'] = "report/report_controller/vw_sales_summary_report_create";
$route['vw_summary_report_create'] = "report/report_controller/vw_summary_report_create";
$route['quotation_source_summary_report'] = "report/report_controller/quotation_source_summary_report";
$route['engg_wise_source_summary'] = "report/report_controller/vw_engg_wise_source_summary";
$route['engg_wise_quotation_source_summary_report'] = "report/report_controller/engg_wise_quotation_source_summary_report";
$route['engg_wise_won_source_summary'] = "report/report_controller/vw_engg_wise_won_source_summary";
$route['engg_wise_won_quotation_source_summary_report'] = "report/report_controller/engg_wise_won_quotation_source_summary_report";
$route['won_quotation_source_summary_report'] = "report/report_controller/won_quotation_source_summary_report";
$route['vw_pricelist'] = "report/report_controller/vw_pricelist";
$route['engg_wise_monthly_summary'] = "report/report_controller/vw_engg_wise_monthly_summary";
$route['engg_wise_weekly_summary'] = "report/report_controller/vw_engg_wise_weekly_summary";
$route['weekly_quotation_summary_report'] = "report/report_controller/weekly_quotation_summary_report";

$route['vw_call_summary_report_create'] = "report/report_controller/vw_call_summary_report_create";
$route['vw_call_summary_report'] = "report/report_controller/vw_call_summary_report";
$route['vw_followup_calls_create'] = "report/report_controller/vw_followup_calls_create";
$route['create_quotation_register'] = "report/report_controller/create_quotation_register";
$route['quotation_register_report'] = "report/report_controller/generate_quotation_register_report";
$route['create_state_wise_quotation_register'] = "report/report_controller/create_state_wise_quotation_register";
$route['state_wise_quotation_register_report'] = "report/report_controller/generate_state_wise_quotation_register_report";
$route['create_order_lost_report'] = "report/report_controller/create_order_lost_report";
$route['order_lost_report'] = "report/report_controller/generate_order_lost_report";
$route['create_order_won_report'] = "report/report_controller/create_order_won_report";
$route['order_won_report'] = "report/report_controller/generate_order_won_report";
$route['create_stage_wise_quotation_summary'] = "report/report_controller/create_stage_wise_quotation_summary";
$route['stage_wise_quotation_summary_report'] = "report/report_controller/generate_stage_wise_quotation_summary_report";
$route['vw_status_wise_quotation_summary_report'] = "report/report_controller/vw_status_wise_quotation_summary_report";
$route['vw_status_wise_customer_wise_quotation_summary_report/:any'] = "report/report_controller/vw_status_wise_customer_wise_quotation_summary_report";
$route['create_brand_wise_quotation_summary'] = "report/report_controller/create_brand_wise_quotation_summary";
$route['brand_wise_quotation_summary_report'] = "report/report_controller/generate_brand_wise_quotation_summary_report";

//merged from support
$route['vw_warantee_summary_report'] = "report/report_controller/vw_warantee_summary_report_create";

//Offer Tracking 
$route['vw_offer_tracking_entry'] = "sales/offer_tracking_register";
$route['create_offer_tracking'] = "sales/offer_tracking_register/create";
$route['vw_offer_tracking_report'] = "sales/offer_tracking_register/tracking_report";

//Enquiry To order Module
$route['vw_all_enquiry_to_order_data'] = "sales/enquiry_to_order_register";
$route['create_customer_enquiry_to_order_data'] = "sales/enquiry_to_order_register/create";
$route['set_enquiry_to_offer/:any'] = "sales/enquiry_to_order_register/enquiry_to_offer_save";
$route['update_enquiry_data_for_offer_cration/:any'] = "sales/enquiry_to_order_register/update_enquiry_data_for_offer_cration";
$route['update_offer_data_for_order_cration/:any'] = "sales/enquiry_to_order_register/update_offer_data";
$route['update_indiamart_enquiry_data_for_offer_cration/:any'] = "sales/enquiry_to_order_register/update_indiamart_enquiry_data";
$route['vw_all_enquiry_to_order_status'] = "sales/enquiry_to_order_register/show_status";
$route['view_all_lost_enquiry_data/:any'] = "sales/enquiry_to_order_register/view_all_lost_enquiry_data";

//Invoice monitoring
$route['vw_invoice_monitoring'] = "sales/invoice_monitoring_register";
$route['create_invoice_monitoring'] = "sales/invoice_monitoring_register/create";
$route['update_invoice_monitoring/:any'] = "sales/invoice_monitoring_register/update_view";
$route['view_invoice_monitoring/:any'] = "sales/invoice_monitoring_register/show_view";

//GRN Module
$route['vw_goods_receipt_note_data'] = "factory/grn_register";
$route['create_goods_receipt_note'] = "factory/grn_register/create";
$route['update_goods_receipt_note/:any'] = "factory/grn_register/update";
$route['view_goods_receipt_note/:any'] = "factory/grn_register/view";

//Challan Module
$route['vw_challan_data'] = "factory/material_issue_register";
$route['create_challan'] = "factory/material_issue_register/create";
$route['edit_challan/:any'] = "factory/material_issue_register/edit";
$route['update_challan/:any'] = "factory/material_issue_register/update";
$route['view_challan/:any'] = "factory/material_issue_register/view";
$route['get_ajax_old_enquiry_data'] = "sales/enquiry_register/get_ajax_enquiry_data";

$route['vw_profile']='welcome/profile';

/*Campaign Register*/
// $route['vw_campaign']='sales/campaign_register';
// $route['create_campaign']='sales/campaign_register/create';
// $route['create_campaign2']='sales/campaign_register/create2';
// $route['view_campaign_clist_list/(:any)']='sales/campaign_register/client_list';
// $route['view_campaign2/(:any)']='sales/campaign_register/view_campaign2';
// $route['update_campaign_clist_list/(:any)']='sales/campaign_register/client_list_update';
// $route['view_call_log/(:any)']='sales/campaign_register/call_log';
// $route['view_call_log2/(:any)']='sales/campaign_register/vw_call_log2';
// $route['edit_campaign/(:any)'] = 'sales/campaign_register/edit_campaign';
// $route['edit_campaign2/(:any)'] = 'sales/campaign_register/edit_campaign2';
// $route['edit_campaign2/(:any)'] = 'sales/campaign_register/edit_campaign2';
// $route['next_client/(:num)'] = 'sales/campaign_register/next';
// $route['prev_client/(:num)'] = 'sales/campaign_register/prev';

/*Visit Register*/
$route['visit_register']='sales/visit_register';
$route['fetch_engg_wise_visit_report']='sales/visit_register/fetch_engg_wise_visit_report';
// $route['create_campaign']='sales/visit_register/create';
// $route['create_campaign2']='sales/visit_register/create2';
// $route['view_campaign_clist_list/(:any)']='sales/visit_register/client_list';
// $route['view_campaign2/(:any)']='sales/visit_register/view_campaign2';
// $route['update_campaign_clist_list/(:any)']='sales/visit_register/client_list_update';
// $route['view_call_log/(:any)']='sales/visit_register/call_log';
// $route['view_call_log2/(:any)']='sales/visit_register/vw_call_log2';
// $route['edit_campaign/(:any)'] = 'sales/visit_register/edit_campaign';
// $route['edit_campaign2/(:any)'] = 'sales/visit_register/edit_campaign2';
// $route['edit_campaign2/(:any)'] = 'sales/visit_register/edit_campaign2';
// $route['next_client/(:num)'] = 'sales/visit_register/next';
// $route['prev_client/(:num)'] = 'sales/visit_register/prev';

/*Tele Phone Master*/
$route['vw_telephone']='master/telephone_master';
$route['vw_telephone_contact_create']='master/telephone_master/create';

//merged from support 20th dec 2023

//Ticket Master
$route['vw_ticket_data'] = "support/ticket_register/create";
$route['vw_ticket_warrantee_claims_data'] = "support/ticket_register/warrantee_claims_index";
$route['vw_ticket_paid_service_data'] = "support/ticket_register/paid_service_index";
$route['vw_ticket_technical_support_data'] = "support/ticket_register/technical_support_index";
$route['vw_ticket_technical_support_field_data'] = "support/ticket_register/technical_support_field_index";
$route['vw_inhouse_data'] = "support/ticket_register/inhouse_index";
$route['update_ticket_data/:any'] = "support/ticket_register/update_ticket_data";
$route['delete_ticket_attach_image/:any'] = "support/ticket_register/delete_ticket_attach_image";
$route['vw_all_ticket_data'] = "support/ticket_register/all_ticket_index";
$route['view_ticket_data/:any'] = "support/ticket_register/view_ticket_data";
$route['vw_all_tracking_data'] = "support/ticket_register/vw_all_tracking_data";
$route['view_ticket/:any'] = "support/ticket_register/view_all_ticket";
$route['update_all_ticket_data/:any'] = "support/ticket_register/update_all_ticket_data";

// Predispatch Register 
$route['vw_predispatch_data'] = "support/pre_dispatch_register";
$route['create_predispatch'] = "support/pre_dispatch_register/create";
$route['view_predispatch_data/:any'] = "support/pre_dispatch_register/view_predispatch";
$route['update_predispatch_data/:any'] = "support/pre_dispatch_register/update_predispatch";

// Demo Test Module
$route['vw_demotest_data'] = "support/demo_test_register";
$route['create_demotest'] = "support/demo_test_register/create";
$route['view_demotest_data/:any'] = "support/demo_test_register/view_demotest";
$route['update_demotest_data/:any'] = "support/demo_test_register/update_demotest";

// Tracking 
$route['tracking_index'] = "support/tracking_register";
$route['track/:any'] = "support/tracking_register/create_track";
$route['edit_tracking/:any'] = "support/tracking_register/edit_tracking";


$route['404_override'] = '';

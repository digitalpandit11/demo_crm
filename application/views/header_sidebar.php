<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
if (!$_SESSION['user_name']) {
	header("location:welcome");
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Data Tables -->
	<link rel="stylesheet" href="<?php echo base_url() . 'assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css' ?>">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo base_url() . 'assets/plugins/fontawesome-free/css/all.min.css' ?>">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- daterange picker -->
	<link rel="stylesheet" href="<?php echo base_url() . 'assets/plugins/daterangepicker/daterangepicker.css' ?>">
	<!-- iCheck for checkboxes and radio inputs -->
	<link rel="stylesheet" href="<?php echo base_url() . 'assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css' ?>">
	<!-- Bootstrap Color Picker -->
	<link rel="stylesheet" href="<?php echo base_url() . 'assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css' ?>">
	<!-- Tempusdominus Bbootstrap 4 -->
	<link rel="stylesheet" href="<?php echo base_url() . 'assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css' ?>">
	<!-- Select2 -->
	<link rel="stylesheet" href="<?php echo base_url() . 'assets/plugins/select2/css/select2.min.css' ?>">
	<link rel="stylesheet" href="<?php echo base_url() . 'assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css' ?>">
	<!-- Bootstrap4 Duallistbox -->
	<link rel="stylesheet" href="<?php echo base_url() . 'assets/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css' ?>">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo base_url() . 'assets/dist/css/adminlte.min.css' ?>">
	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	<link rel="icon" href="<?=base_url()?>/assets/company_logo/intact_icon.png" type="image/gif">
</head>

<body>
	<!-- <body class="hold-transition sidebar-mini"> -->


	<nav class="main-header navbar navbar-expand navbar-white navbar-light">
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
			</li>
			<li class="nav-item d-none d-sm-inline-block">
				<a href="<?php echo base_url() . 'dashboard' ?>" class="nav-link">Home</a>
			</li>
			<li class="nav-item d-none d-sm-inline-block">
				<a href="#" class="nav-link">Contact</a>
			</li>
		</ul>

		<!-- SEARCH FORM -->
		<form class="form-inline ml-3">
			<div class="input-group input-group-sm">
				<input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
				<div class="input-group-append">
					<button class="btn btn-navbar" type="submit">
						<i class="fas fa-search"></i>
					</button>
				</div>
			</div>
		</form>

		<ul class="navbar-nav ml-auto">
			<li class="nav-item dropdown">
				<a href="<?php echo base_url() . 'welcome/logout' ?>" class="dropdown-item dropdown-footer">
					<h4><i class="fa fa-power-off"></i></h4>
				</a>
			</li>
			<!-- <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-comments"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
            </div>
        </li> -->
			<!-- notification  -->
			<li class="nav-item dropdown">
				<a class="nav-link" data-toggle="dropdown" href="#">
					<h4><i class="far fa-bell"></i>
						<span id="notification_count" class="badge badge-pill badge-danger navbar-badge" style="font-size: 15px;">15</span>
					</h4>
				</a>
				<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
					<!-- <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a> -->
					<div class="dropdown-divider"></div>
					<a href="<?php echo base_url('task_index'); ?>" class="dropdown-item dropdown-footer">See All Notifications</a>
				</div>
			</li>
		</ul>
	</nav>

	<!-- Main Sidebar Container -->
	<aside class="main-sidebar sidebar-dark-primary elevation-4">
		<!-- Brand Logo -->
		<a href="" class="brand-link">
			<img src="<?php echo base_url() . 'assets/company_logo/intact_new_logo_with_dark_bg.png' ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
			<span class="brand-text font-weight-light"><b>INTACT CRM</b></span>
		</a>
		<!-- Sidebar -->
		<div class="sidebar">
			<!-- Sidebar user panel (optional) -->
			<div class="user-panel mt-3 pb-3 mb-3 d-flex">
				<div class="image">
					<img src="<?php echo base_url() . 'assets/dist/img/no_image.png" class="img-circle elevation-2" alt="User Image' ?>">
				</div>
				<div class="info">
					<a href="#"><b><?php echo $this->session->userdata('full_name'); ?></b></a>
				</div>
			</div>

			<!-- Sidebar Menu -->
			<nav class="mt-2">
				<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
					<li class="nav-item has-treeview">
						<a href="<?php echo base_url() . 'dashboard' ?>" class="nav-link" <?php echo ($this->uri->segment(1) == "dashboard")  ? "active" : ""; ?>>
							<i class="nav-icon fas fa-tachometer-alt"></i>
							<p>
								Dashboard
							</p>
						</a>
					</li>

					<?php
					$role_id = $_SESSION['role_id'];
					?>

					<!-- <li class="nav-item has-treeview">
						<a href="<?php echo base_url() . 'support_dashboard' ?>" class="nav-link" <?php echo ($this->uri->segment(1) == "support_dashboard")  ? "active" : ""; ?>>
							<i class="nav-icon fas fa-tachometer-alt"></i>
							<p>
								Support Dashboard
							</p>
						</a>
					</li> -->

					<?php
					// $role_id = $_SESSION['role_id'];
					?>

					<!-- <li class="nav-item has-treeview">
						<a href="<?php //echo base_url() . 'vw_campaign' ?>" class="nav-link" <?php// echo ($this->uri->segment(1) == "vw_campaign")  ?  "active" : ""; ?>>
							<ion-icon name="call-outline" style="font-size: 20px; vertical-align: middle;"></ion-icon>
							<!-- <i class="far fa-circle nav-icon"></i> --
							<p>
								&nbsp;&nbsp;Campaign
							</p>
						</a>
					</li>
					<li class="nav-item has-treeview">
						<a href="<?php// echo base_url() . 'search_india_mart_lead' ?>" class="nav-link" <?php //echo ($this->uri->segment(1) == "search_india_mart_lead") ? "active" : ""; ?>>
							<ion-icon name="briefcase-outline" style="font-size: 20px; vertical-align: middle;"></ion-icon>
							<!-- <i class="far fa-circle nav-icon"></i> --
							<p>
								&nbsp;&nbsp;IndiaMart Enquiry
							</p>
						</a>
					</li>

					<li class="nav-item has-treeview">
						<a href="<?php //echo base_url() . 'search_trade_india_lead' ?>" class="nav-link" <?php echo ($this->uri->segment(1) == "search_trade_india_lead") ? "active" : ""; ?>>
							<ion-icon name="briefcase-outline" style="font-size: 20px; vertical-align: middle;"></ion-icon>
							<!-- <i class="far fa-circle nav-icon"></i> --
							<p>
								&nbsp;&nbsp;Trade India Enquiry
							</p>
						</a>
					</li> -->


					<li class="nav-item has-treeview">
						<a href="<?php echo base_url() . 'vw_customer_index' ?>" class="nav-link" <?php echo ($this->uri->segment(1) == "vw_customer_index") ? "active" : ""; ?>>
							<ion-icon name="business-outline" style="font-size: 20px; vertical-align: middle;"></ion-icon>
							<!-- <i class="far fa-circle nav-icon"></i> -->
							<p>
								&nbsp;&nbsp;Customer Details
							</p>
						</a>
					</li>

					<li class="nav-item has-treeview">
						<a href="<?php echo base_url() . 'vw_enquiry_data' ?>" class="nav-link" <?php echo ($this->uri->segment(1) == "vw_enquiry_data") ? "active" : ""; ?>>
							<ion-icon name="file-tray-stacked-outline" style="font-size: 20px; vertical-align: middle;"></ion-icon>
							<!-- <i class="far fa-circle nav-icon"></i> -->
							<p>
								&nbsp;&nbsp;Lead
							</p>
						</a>
					</li>

					<li class="nav-item has-treeview">
						<a href="<?php echo base_url() . 'vw_my_offer_data' ?>" class="nav-link" <?php echo ($this->uri->segment(1) == "vw_my_offer_data") ? "active" : ""; ?>>
							<ion-icon name="file-tray-outline" style="font-size: 20px; vertical-align: middle;"></ion-icon>
							<!-- <i class="far fa-circle nav-icon"></i> -->
							<p>
								&nbsp;&nbsp;Quotation
							</p>
						</a>
					</li>

					<li class="nav-item has-treeview">
						<a href="<?php echo base_url() . 'vw_draft_offer_data' ?>" class="nav-link" <?php echo ($this->uri->segment(1) == "vw_draft_offer_data") ? "active" : ""; ?>>
							<ion-icon name="file-tray-outline" style="font-size: 20px; vertical-align: middle;"></ion-icon>
							<!-- <i class="far fa-circle nav-icon"></i> -->
							<p>
								&nbsp;&nbsp;Draft Quotations
							</p>
						</a>
					</li>
					<li class="nav-item has-treeview">
						<a href="<?php echo base_url() . 'vw_tracking_data_entry' ?>" class="nav-link" <?php echo ($this->uri->segment(1) == "vw_tracking_data_entry") ? "active" : ""; ?>>

							<ion-icon name="chatbubbles-outline" style="font-size: 20px; vertical-align: middle;"></ion-icon>
							<!-- <i class="far fa-circle nav-icon"></i> -->
							<p>
								&nbsp;&nbsp;Quote follow up
							</p>
						</a>
					</li>


					<li class="nav-item has-treeview">
						<a href="<?php echo base_url() . 'task_index' ?>" class="nav-link" <?php echo ($this->uri->segment(1) == "task_index") ? "active" : ""; ?>>

							<ion-icon name="notifications" style="font-size: 20px; color: red ;vertical-align: middle;"></ion-icon>
							<!-- <ion-icon name="notifications-circle-outline"></ion-icon> -->
							<!-- <i class="far fa-circle nav-icon"></i> -->
							<p>
								&nbsp;&nbsp;Next Action Notifications
							</p>
						</a>
					</li>

					<!-- <li class="nav-item has-treeview">
						<a href="<?php //echo base_url() . 'visit_register' ?>" class="nav-link" <?php //echo ($this->uri->segment(1) == "visit_register") ? "active" : ""; ?>>

							<i class="far fa-calendar-alt"></i>
							<p>
								&nbsp;&nbsp;&nbsp;&nbsp;Sales Visits
							</p>
						</a>
					</li> -->



					<!--Support menus-->
					<!-- <li class="nav-item has-treeview">
						<a href="#" class="nav-link bg-warning">
							<i class="nav-icon fas fa-th"></i>
							<p>
								Support
								<i class="fas fa-angle-left right"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">

							<li class="nav-item">
								<a href="<?php echo base_url() . 'vw_ticket_data' ?>" class="nav-link">
									<i class="nav-icon fas fa-headset"></i>
									<p>Ticket Master </p>
								</a>
							</li>

							<li class="nav-item">
								<a href="<?php echo base_url() . 'vw_ticket_warrantee_claims_data' ?>" class="nav-link">
									<i class="nav-icon fas fa-layer-group"></i>
									<p>Warrantee Claims </p>
								</a>
							</li>

							<li class="nav-item">
								<a href="<?php echo base_url() . 'vw_ticket_paid_service_data' ?>" class="nav-link">
									<i class="nav-icon fas fa-rupee-sign"></i>
									<p>Paid Service </p>
								</a>
							</li>

							<li class="nav-item">
								<a href="<?php echo base_url() . 'vw_ticket_technical_support_data' ?>" class="nav-link">
									<i class="nav-icon fas fa-user-cog"></i>
									<p>Technical Support - Online </p>
								</a>
							</li>

							<li class="nav-item">
								<a href="<?php echo base_url() . 'vw_ticket_technical_support_field_data' ?>" class="nav-link">
									<i class="nav-icon fas fa-user-cog"></i>
									<p>Technical Support - Field</p>
								</a>
							</li>

							<li class="nav-item">
								<a href="<?php echo base_url() . 'vw_all_ticket_data' ?>" class="nav-link">
									<i class="nav-icon fas fa-list"></i>
									<p>
										All Ticket
									</p>
								</a>
							</li>

							<li class="nav-item">
								<a href="<?php echo base_url() . 'vw_all_tracking_data' ?>" class="nav-link">
									<i class="far fa-dot-circle nav-icon"></i>
									<p>
										All Tracking
									</p>
								</a>
							</li>

							<li class="nav-item">
								<a href="<?php echo base_url() . 'vw_predispatch_data' ?>" class="nav-link">
									<i class="nav-icon fas fa-dolly"></i>
									<p>
										Pre Dispatch
									</p>
								</a>


							</li>

							<li class="nav-item">
								<a href="<?php echo base_url() . 'vw_demotest_data' ?>" class="nav-link">
									<i class="nav-icon fas fa-dot-circle"></i>
									<p>
										Demo Test
									</p>
								</a>

							</li> -->

							<!-- <li class="nav-item">
									<a href="#" class="nav-link">
                        						<i class="nav-icon fas fa-list-alt"></i>
                        						<p>
                            						Feedback Request
                        						</p>
                    							</a>
								</li>	 --
						</ul>
					</li>
					<!---end of support menus-->



					<!-- ////////////Start of Master 2222//////////// -->

					<li class="nav-item has-treeview">
						<a href="<?php echo base_url() . 'vw_regestration_data' ?>" class="nav-link">
							<i class="nav-icon fas fa-th"></i>
							<p>
								Masters
								<i class="fas fa-angle-left right"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">

							<li class="nav-item">
								<a href="<?php echo base_url() . 'vw_enquiry_type_master' ?>" class="nav-link">
									<i class="far fa-dot-circle nav-icon"></i>
									<p>Lead Type Master </p>
								</a>
							</li>

							<li class="nav-item">
								<a href="<?php echo base_url() . 'vw_telephone' ?>" class="nav-link">
									<i class="far fa-dot-circle nav-icon"></i>
									<p>Tele phone Directory Master </p>
								</a>
							</li>

							<li class="nav-item">
								<a href="<?php echo base_url() . 'vw_enquiry_source_master' ?>" class="nav-link">
									<i class="far fa-dot-circle nav-icon"></i>
									<p>Lead Source Master </p>
								</a>
							</li>

							<li class="nav-item">
								<a href="<?php echo base_url() . 'vw_material_make_master' ?>" class="nav-link">
									<i class="far fa-dot-circle nav-icon"></i>
									<p>Make Master </p>
								</a>
							</li>

							<li class="nav-item">
								<a href="<?php echo base_url() . 'vw_erp_product_vw_customer_master' ?>" class="nav-link" <?php echo ($this->uri->segment(1) == "vw_erp_product_vw_customer_master")  ? "active" : ""; ?>>
									<i class="far fa-dot-circle nav-icon"></i>
									<p>Customer Master</p>
								</a>
							</li>

							<li class="nav-item">
								<a href="<?php echo base_url() . 'product_category' ?>" class="nav-link" <?php echo ($this->uri->segment(1) == "product_category")  ? "active" : ""; ?>>
									<i class="far fa-dot-circle nav-icon"></i>
									<p>Product Category</p>
								</a>
							</li>

							<li class="nav-item">
								<a href="<?php echo base_url() . 'product_sub_category' ?>" class="nav-link" <?php echo ($this->uri->segment(1) == "product_sub_category") ? "active" : ""; ?>>
									<i class="far fa-dot-circle nav-icon"></i>
									<p>Product Sub Category</p>
								</a>
							</li>

							<li class="nav-item">
								<a href="<?php echo base_url() . 'product_master' ?>" class="nav-link" <?php echo ($this->uri->segment(1) == "product_master") ? "active" : ""; ?>>
									<i class="far fa-dot-circle nav-icon"></i>
									<p>Product</p>
								</a>
							</li>

							<li class="nav-item">
								<a href="<?php echo base_url() . 'vw_document_series_data' ?>" class="nav-link" <?php echo ($this->uri->segment(1) == "vw_document_series_data") ? "active" : ""; ?>>
									<i class="far fa-dot-circle nav-icon"></i>
									<p>Document Series Master</p>
								</a>
							</li>

							<li class="nav-item">
								<a href="<?php echo base_url() . 'vw_hsn_data' ?>" class="nav-link" <?php echo ($this->uri->segment(1) == "vw_hsn_data") ? "active" : ""; ?>>
									<i class="far fa-dot-circle nav-icon"></i>
									<p>HSN Master</p>
								</a>
							</li>

							<li class="nav-item">
								<a href="<?php echo base_url() . 'vw_principle_engg_data' ?>" class="nav-link" <?php echo ($this->uri->segment(1) == "vw_principle_engg_data") ? "active" : ""; ?>>
									<i class="far fa-dot-circle nav-icon"></i>
									<p>Principle Engg Master</p>
								</a>
							</li>
							
							<li class="nav-item">
								<a href="<?php echo base_url() . 'vw_offer_for_data' ?>" class="nav-link" <?php echo ($this->uri->segment(1) == "vw_offer_for_data") ? "active" : ""; ?>>
									<i class="far fa-dot-circle nav-icon"></i>
									<p>Quotation For Master</p>
								</a>
							</li>

							<li class="nav-item">
								<a href="<?php echo base_url() . 'vw_offer_for_info_data' ?>" class="nav-link" <?php echo ($this->uri->segment(1) == "vw_offer_for_info_data") ? "active" : ""; ?>>
									<i class="far fa-dot-circle nav-icon"></i>
									<p>Quotation For Info Master</p>
								</a>
							</li>

							<li class="nav-item">
								<a href="<?php echo base_url() . 'vw_state_data' ?>" class="nav-link" <?php echo ($this->uri->segment(1) == "vw_state_data") ? "active" : ""; ?>>
									<i class="far fa-dot-circle nav-icon"></i>
									<p>State Master</p>
								</a>
							</li>

							<li class="nav-item">
								<a href="<?php echo base_url() . 'vw_city_data' ?>" class="nav-link" <?php echo ($this->uri->segment(1) == "vw_city_data") ? "active" : ""; ?>>
									<i class="far fa-dot-circle nav-icon"></i>
									<p>City Master</p>
								</a>
							</li>

							<li class="nav-item">
								<a href="<?php echo base_url() . 'vw_unit_data' ?>" class="nav-link" <?php echo ($this->uri->segment(1) == "vw_unit_data")  ? "active" : ""; ?>>
									<i class="far fa-dot-circle nav-icon"></i>
									<p>Unit Master</p>
								</a>
							</li>


							<!-- ////////////restricted masters//////////////// -->
							<?php

							if ($role_id == 1) {
							?>

								<li class="nav-item">
									<a href="<?php echo base_url() . 'vw_role_data' ?>" class="nav-link">
										<i class="far fa-dot-circle nav-icon"></i>
										<p>Role Master</p>
									</a>
								</li>

								<li class="nav-item">
									<a href="<?php echo base_url() . 'employee_master' ?>" class="nav-link" <?php echo ($this->uri->segment(1) == "employee_master") ? "active" : ""; ?>>
										<i class="far fa-dot-circle nav-icon"></i>
										<p>Employee Master</p>
									</a>
								</li>

								<li class="nav-item">
									<a href="<?php echo base_url() . 'vw_regestration_data' ?>" class="nav-link" <?php echo ($this->uri->segment(1) == "vw_regestration_data")  ? "active" : ""; ?>>
										<i class="far fa-dot-circle nav-icon"></i>
										<p>User</p>
									</a>
								</li>

								<li class="nav-item has-treeview">
									<a href="<?php echo base_url() . 'vw_profile' ?>" class="nav-link" <?php echo ($this->uri->segment(1) == "vw_profile") ? "active" : ""; ?>>

										<ion-icon name="person-outline" style="font-size: 20px; vertical-align: middle;"></ion-icon>
										<!-- <i class="far fa-circle nav-icon"></i> -->
										<p>
											&nbsp;&nbsp;Company Profile
										</p>
									</a>
								</li>
								<!-- ////////////End of restricted masters//////////////// -->

							<?php } ?>

						</ul>
					</li>
					<!----------End of Master ---------->



					<!---------Start of  reports --------->
					<li class="nav-item has-treeview">
						<a href="<?php echo base_url() . 'vw_working_sales_order' ?>" class="nav-link">
							<i class="nav-icon fas fa-chart-line"></i>
							<p>
								Reports
								<i class="fas fa-angle-left right"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">

								<!-- <li class="nav-item">
									<a href="<?php echo base_url() . 'create_brand_wise_quotation_summary' ?>" class="nav-link" <?php echo ($this->uri->segment(1) == "create_brand_wise_quotation_summary") ? "active" : ""; ?>>
										<i class="far fa-dot-circle nav-icon"></i>
										<p>Brand/Make Wise Quotation Summary Report</p>
									</a>
								</li>

								<li class="nav-item">
									<a href="<?php echo base_url() . 'quotation_source_summary_report' ?>" class="nav-link" <?php echo ($this->uri->segment(1) == "quotation_source_summary_report") ?  "active" : ""; ?>>
										<i class="far fa-dot-circle nav-icon"></i>
										<p>Quotation Source Summary</p>
									</a>
								</li>

								<li class="nav-item">
									<a href="<?php echo base_url() . 'won_quotation_source_summary_report' ?>" class="nav-link" <?php echo ($this->uri->segment(1) == "won_quotation_source_summary_report") ?  "active" : ""; ?>>
										<i class="far fa-dot-circle nav-icon"></i>
										<p>Won Quotation Source Summary</p>
									</a>
								</li>

								<li class="nav-item">
									<a href="<?php echo base_url() . 'create_order_won_report' ?>" class="nav-link" <?php echo ($this->uri->segment(1) == "create_order_won_report") ? "active" : ""; ?>>
										<i class="far fa-dot-circle nav-icon"></i>
										<p>Won Orders Report</p>
									</a>
								</li>

								<li class="nav-item">
									<a href="<?php echo base_url() . 'create_order_lost_report' ?>" class="nav-link" <?php echo ($this->uri->segment(1) == "create_order_lost_report") ? "active" : ""; ?>>
										<i class="far fa-dot-circle nav-icon"></i>
										<p>Lost Orders Report</p>
									</a>
								</li>

								<li class="nav-item">
									<a href="<?php echo base_url() . 'vw_pending_enquiry_report' ?>" class="nav-link" <?php echo ($this->uri->segment(1) == "vw_pending_enquiry_report")  ? "active" : ""; ?>>
										<i class="far fa-dot-circle nav-icon"></i>
										<p>Pending Leads</p>
									</a>
								</li>

								<li class="nav-item">
									<a href="<?php echo base_url() . 'create_state_wise_quotation_register' ?>" class="nav-link" <?php echo ($this->uri->segment(1) == "create_state_wise_quotation_register") ? "active" : ""; ?>>
										<i class="far fa-dot-circle nav-icon"></i>
										<p>State Wise Quotation Register Report</p>
									</a>
								</li>

								<li class="nav-item">
									<a href="<?php echo base_url() . 'vw_pending_enquiry_report' ?>" class="nav-link" <?php echo ($this->uri->segment(1) == "vw_pending_enquiry_report") ? "active" : ""; ?>>
										<i class="far fa-dot-circle nav-icon"></i>
										<p>Pending Enquiry</p>
									</a>
								</li>

								<li class="nav-item">
									<a href="<?php echo base_url() . 'vw_pending_offer_report' ?>" class="nav-link" <?php echo ($this->uri->segment(1) == "vw_pending_offer_report") ? "active" : ""; ?>>
										<i class="far fa-dot-circle nav-icon"></i>
										<p>Pending Quotations</p>
									</a>
								</li>

								<li class="nav-item">
									<a href="<?php echo base_url() . 'vw_summary_report_create' ?>" class="nav-link" <?php echo ($this->uri->segment(1) == "vw_summary_report_create") ?  "active" : ""; ?>>
										<i class="far fa-dot-circle nav-icon"></i>
										<p>Performance Summary</p>
									</a>
								</li>

								<li class="nav-item">
									<a href="<?php echo base_url() . 'weekly_quotation_summary_report' ?>" class="nav-link" <?php echo ($this->uri->segment(1) == "weekly_quotation_summary_report") ?  "active" : ""; ?>>
										<i class="far fa-dot-circle nav-icon"></i>
										<p>Weekly Quotation Summary</p>
									</a>
								</li> -->


								<li class="nav-item">
									<a href="<?php echo base_url() . 'vw_pricelist' ?>" class="nav-link" <?php echo ($this->uri->segment(1) == "vw_pricelist") ?  "active" : ""; ?>>
										<i class="far fa-dot-circle nav-icon"></i>
										<p>Download Pricelist</p>
									</a>
								</li>
								
								<li class="nav-item">
									<a href="<?php echo base_url() . 'create_quotation_register' ?>" class="nav-link" <?php echo ($this->uri->segment(1) == "create_quotation_register") ? "active" : ""; ?>>
										<i class="far fa-dot-circle nav-icon"></i>
										<p>Quotation Register</p>
									</a>
								</li>

								<li>
									<a href="<?php echo base_url() . 'vw_status_wise_quotation_summary_report' ?>" class="nav-link" <?php echo ($this->uri->segment(1) == "vw_status_wise_quotation_summary_report") ?  "active" : ""; ?>>
										<i class="far fa-dot-circle nav-icon"></i>
										<p>Status Wise Report</p>
									</a>
								</li>

								<li class="nav-item" Style="border-bottom: 2px solid grey;">
									<a href="<?php echo base_url() . 'vw_month_wise_quotation_summary_report_create' ?>" class="nav-link" <?php echo ($this->uri->segment(1) == "vw_month_wise_quotation_summary_report_create") ?  "active" : ""; ?>>
										<i class="far fa-dot-circle nav-icon"></i>
										<p>Month Wise Report</p>
									</a>
								</li>

					
						</ul>
					</li>
				</ul>

				<!-- //////////////// End of Report 2222//////////////// -->


			</nav>
			<!-- /.sidebar-menu -->
		</div>
		<!-- /.sidebar -->
	</aside>

	<script src="<?php echo base_url() . 'assets/plugins/jquery/jquery.min.js' ?>"></script>

	<script>
		$(document).ready(function() {
			$.ajax({

				url: "<?php echo site_url('sales/enquiry_tracking_register/get_next_action_count'); ?>",
				type: 'POST',
				dataType: "json",
				success: function(data) {


					$('#notification_count').text(data);
				}
			});

		});
	</script>

	<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>

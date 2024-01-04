<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
if (!$_SESSION['user_name']) {
	header("location:dashboard");
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Performance Summary Report</title>
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
</head>

<body class="hold-transition sidebar-mini">
	<div class="wrapper">
		<!-- Navbar -->
		<?php $this->load->view('header_sidebar'); ?>
		<!-- /.navbar -->
		<!-- Main Sidebar Container -->
		<div class="content-wrapper">
			<!-- Content Wrapper. Contains page content -->
			<section class="content-header">
				<div class="container-fluid">
					<div class="card">
						<div class="card-header">
							<h1 class="card-title">Performance Summary Report</h1>
							<div class="col-sm-6">
								<br><br>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo base_url() . 'dashboard' ?>">Home</a></li>
									<li class="breadcrumb-item">Performance Summary Report
									</li>
								</ol>
							</div>
						</div>
					</div>
				</div>
			</section>
			<section class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">
							<?php

							//for 12th month 
							$day11 = date('Y-m-d');
							$month11 = strtoupper(date('Y-M', strtotime($day11 . "-11 Month")));
							$first_date_of11month = date('Y-m-d', strtotime($month11 . 'first day of this month'));
							$last_date_of_11month = date('Y-m-d', strtotime($month11 . 'last day of this month'));

							//for 11th month 
							$day10 = date('');
							$month10 = strtoupper(date('Y-M', strtotime($day10 . "-10 Month")));
							$first_date_of_10month = date('Y-m-d', strtotime($month10 . 'first day of this month'));
							$last_date_of_10month = date('Y-m-d', strtotime($month10 . 'last day of this month'));

							//for 10th month 
							$day9 = date('Y-m-d');
							$month9 = strtoupper(date('Y-M', strtotime($day9 . "-9 Month")));
							$first_date_of_9month = date('Y-m-d', strtotime($month9 . 'first day of this month'));
							$last_date_of_9month = date('Y-m-d', strtotime($month9 . 'last day of this month'));

							//for 9th month 
							$day8 = date('Y-m-d');
							$month8 = strtoupper(date('Y-M', strtotime($day8 . "-8 Month")));
							$first_date_of_8month = date('Y-m-d', strtotime($month8 . 'first day of this month'));
							$last_date_of_8month = date('Y-m-d', strtotime($month8 . 'last day of this month'));

							//for 8th month 
							$day7 = date('Y-m-d');
							$month7 = strtoupper(date('Y-M', strtotime($day7 . "-7 Month")));
							$first_date_of_7month = date('Y-m-d', strtotime($month7 . 'first day of this month'));
							$last_date_of_7month = date('Y-m-d', strtotime($month7 . 'last day of this month'));

							//for 7th month 
							$day6 = date('Y-m-d');
							$month6 = strtoupper(date('Y-M', strtotime($day6 . "-6 Month")));

							$first_date_of_6month = date('Y-m-d', strtotime($month6 . 'first day of this month'));
							$last_date_of_6month = date('Y-m-d', strtotime($month6 . 'last day of this month'));

							//for 6th month 
							$day5 = date('Y-m-d');
							$month5 = strtoupper(date('Y-M', strtotime($day5 . "-5 Month")));
							$first_date_of5month = date('Y-m-d', strtotime($month5 . 'first day of this month'));
							$last_date_of_5month = date('Y-m-d', strtotime($month5 . 'last day of this month'));

							//for 5th month 
							$day4 = date('');
							$month4 = strtoupper(date('Y-M', strtotime($day4 . "-4 Month")));
							$first_date_of_4month = date('Y-m-d', strtotime($month4 . 'first day of this month'));
							$last_date_of_4month = date('Y-m-d', strtotime($month4 . 'last day of this month'));

							//for 4th month 
							$day3 = date('Y-m-d');
							$month3 = strtoupper(date('Y-M', strtotime($day3 . "-3 Month")));
							$first_date_of_3month = date('Y-m-d', strtotime($month3 . 'first day of this month'));
							$last_date_of_3month = date('Y-m-d', strtotime($month3 . 'last day of this month'));

							//for 3th month 
							$day2 = date('Y-m-d');
							$month2 = strtoupper(date('Y-M', strtotime($day2 . "-2 Month")));
							$first_date_of_2month = date('Y-m-d', strtotime($month2 . 'first day of this month'));
							$last_date_of_2month = date('Y-m-d', strtotime($month2 . 'last day of this month'));

							//for 2th month 
							$day1 = date('Y-m-d');
							$month1 = strtoupper(date('Y-M', strtotime($day1 . "-1 Month")));
							$first_date_of_1month = date('Y-m-d', strtotime($month1 . 'first day of this month'));
							$last_date_of_1month = date('Y-m-d', strtotime($month1 . 'last day of this month'));

							//for 1th month 
							$day0 = date('Y-m-d');
							$month0 = strtoupper(date('Y-M', strtotime($day0 . "-0 Month")));

							$first_date_of_0month = date('Y-m-d', strtotime($month0 . 'first day of this month'));
							$last_date_of_0month = date('Y-m-d', strtotime($month0 . 'last day of this month'));


							////lost enquiry count

							$this->db->select('*');
							$this->db->from('offer_register');
							$where = '(offer_register.offer_close_date >= "' . $first_date_of_0month . '" And offer_register.offer_close_date <= "' . $last_date_of_0month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status',4);
							$query = $this->db->get();
							$lost_enquiry_result0 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('offer_register');
							$where = '(offer_register.offer_close_date >= "' . $first_date_of_1month . '" And offer_register.offer_close_date <= "' . $last_date_of_1month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status',4);
							$query = $this->db->get();
							$lost_enquiry_result1 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('offer_register');
							$where = '(offer_register.offer_close_date >= "' . $first_date_of_2month . '" And offer_register.offer_close_date <= "' . $last_date_of_2month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status',4);
							$query = $this->db->get();
							$lost_enquiry_result2 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('offer_register');
							$where = '(offer_register.offer_close_date >= "' . $first_date_of_3month . '" And offer_register.offer_close_date <= "' . $last_date_of_3month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status',4);
							$query = $this->db->get();
							$lost_enquiry_result3 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('offer_register');
							$where = '(offer_register.offer_close_date >= "' . $first_date_of_4month . '" And offer_register.offer_close_date <= "' . $last_date_of_4month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status',4);
							$query = $this->db->get();
							$lost_enquiry_result4 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('offer_register');
							$where = '(offer_register.offer_close_date >= "' . $first_date_of5month . '" And offer_register.offer_close_date <= "' . $last_date_of_5month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status',4);
							$query = $this->db->get();
							$lost_enquiry_result5 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('offer_register');
							$where = '(offer_register.offer_close_date >= "' . $first_date_of_6month . '" And offer_register.offer_close_date <= "' . $last_date_of_6month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status',4);
							$query = $this->db->get();
							$lost_enquiry_result6 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('offer_register');
							$where = '(offer_register.offer_close_date >= "' . $first_date_of_7month . '" And offer_register.offer_close_date<= "' . $last_date_of_7month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status',4);
							$query = $this->db->get();
							$lost_enquiry_result7 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('offer_register');
							$where = '(offer_register.offer_close_date >= "' . $first_date_of_8month . '" And offer_register.offer_close_date <= "' . $last_date_of_8month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status',4);
							$query = $this->db->get();
							$lost_enquiry_result8 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('offer_register');
							$where = '(offer_register.offer_close_date >= "' . $first_date_of_9month . '" And offer_register.offer_close_date <= "' . $last_date_of_9month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status',4);
							$query = $this->db->get();
							$lost_enquiry_result9 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('offer_register');
							$where = '(offer_register.offer_close_date >= "' . $first_date_of_10month . '" And offer_register.offer_close_date <= "' . $last_date_of_10month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status',4);
							$query = $this->db->get();
							$lost_enquiry_result10 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('offer_register');
							$where = '(offer_register.offer_close_date >= "' . $first_date_of11month . '" And offer_register.offer_close_date <= "' . $last_date_of_11month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status',4);
							$query = $this->db->get();
							$lost_enquiry_result11 = $query->num_rows();

							////Lead Count

							$this->db->select('*');
							$this->db->from('customer_master');
							$where = '(customer_master.date_entered >= "' . $first_date_of_0month . '" And customer_master.date_entered <= "' . $last_date_of_0month . '")';
							$this->db->where($where);
							$query = $this->db->get();
							$query_result_ldq0 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('customer_master');
							$where = '(customer_master.date_entered >= "' . $first_date_of_1month . '" And customer_master.date_entered <= "' . $last_date_of_1month . '")';
							$this->db->where($where);
							$query = $this->db->get();
							$query_result_ldq1 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('customer_master');
							$where = '(customer_master.date_entered >= "' . $first_date_of_2month . '" And customer_master.date_entered <= "' . $last_date_of_2month . '")';
							$this->db->where($where);
							$query = $this->db->get();
							$query_result_ldq2 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('customer_master');
							$where = '(customer_master.date_entered >= "' . $first_date_of_3month . '" And customer_master.date_entered <= "' . $last_date_of_3month . '")';
							$this->db->where($where);
							$query = $this->db->get();
							$query_result_ldq3 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('customer_master');
							$where = '(customer_master.date_entered >= "' . $first_date_of_4month . '" And customer_master.date_entered <= "' . $last_date_of_4month . '")';
							$this->db->where($where);
							$query = $this->db->get();
							$query_result_ldq4 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('customer_master');
							$where = '(customer_master.date_entered >= "' . $first_date_of5month . '" And customer_master.date_entered <= "' . $last_date_of_5month . '")';
							$this->db->where($where);
							$query = $this->db->get();
							$query_result_ldq5 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('customer_master');
							$where = '(customer_master.date_entered >= "' . $first_date_of_6month . '" And customer_master.date_entered <= "' . $last_date_of_6month . '")';
							$this->db->where($where);
							$query = $this->db->get();
							$query_result_ldq6 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('customer_master');
							$where = '(customer_master.date_entered >= "' . $first_date_of_7month . '" And customer_master.date_entered <= "' . $last_date_of_7month . '")';
							$this->db->where($where);
							$query = $this->db->get();
							$query_result_ldq7 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('customer_master');
							$where = '(customer_master.date_entered >= "' . $first_date_of_8month . '" And customer_master.date_entered <= "' . $last_date_of_8month . '")';
							$this->db->where($where);
							$query = $this->db->get();
							$query_result_ldq8 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('customer_master');
							$where = '(customer_master.date_entered >= "' . $first_date_of_9month . '" And customer_master.date_entered <= "' . $last_date_of_9month . '")';
							$this->db->where($where);
							$query = $this->db->get();
							$query_result_ldq9 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('customer_master');
							$where = '(customer_master.date_entered >= "' . $first_date_of_10month . '" And customer_master.date_entered <= "' . $last_date_of_10month . '")';
							$this->db->where($where);
							$query = $this->db->get();
							$query_result_ldq10 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('customer_master');
							$where = '(customer_master.date_entered >= "' . $first_date_of11month . '" And customer_master.date_entered <= "' . $last_date_of_11month . '")';
							$this->db->where($where);
							$query = $this->db->get();
							$query_result_ldq11 = $query->num_rows();

							////enquiry Count

							$this->db->select('*');
							$this->db->from('enquiry_register');
							$where = '(enquiry_register.enquiry_date >= "' . $first_date_of_0month . '" And enquiry_register.enquiry_date <= "' . $last_date_of_0month . '")';
							$this->db->where($where);
							$query = $this->db->get();
							$query_result_iq0 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('enquiry_register');
							$where = '(enquiry_register.enquiry_date >= "' . $first_date_of_1month . '" And enquiry_register.enquiry_date <= "' . $last_date_of_1month . '")';
							$this->db->where($where);
							$query = $this->db->get();
							$query_result_iq1 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('enquiry_register');
							$where = '(enquiry_register.enquiry_date >= "' . $first_date_of_2month . '" And enquiry_register.enquiry_date <= "' . $last_date_of_2month . '")';
							$this->db->where($where);
							$query = $this->db->get();
							$query_result_iq2 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('enquiry_register');
							$where = '(enquiry_register.enquiry_date >= "' . $first_date_of_3month . '" And enquiry_register.enquiry_date <= "' . $last_date_of_3month . '")';
							$this->db->where($where);
							$query = $this->db->get();
							$query_result_iq3 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('enquiry_register');
							$where = '(enquiry_register.enquiry_date >= "' . $first_date_of_4month . '" And enquiry_register.enquiry_date <= "' . $last_date_of_4month . '")';
							$this->db->where($where);
							$query = $this->db->get();
							$query_result_iq4 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('enquiry_register');
							$where = '(enquiry_register.enquiry_date >= "' . $first_date_of5month . '" And enquiry_register.enquiry_date <= "' . $last_date_of_5month . '")';
							$this->db->where($where);
							$query = $this->db->get();
							$query_result_iq5 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('enquiry_register');
							$where = '(enquiry_register.enquiry_date >= "' . $first_date_of_6month . '" And enquiry_register.enquiry_date <= "' . $last_date_of_6month . '")';
							$this->db->where($where);
							$query = $this->db->get();
							$query_result_iq6 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('enquiry_register');
							$where = '(enquiry_register.enquiry_date >= "' . $first_date_of_7month . '" And enquiry_register.enquiry_date <= "' . $last_date_of_7month . '")';
							$this->db->where($where);
							$query = $this->db->get();
							$query_result_iq7 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('enquiry_register');
							$where = '(enquiry_register.enquiry_date >= "' . $first_date_of_8month . '" And enquiry_register.enquiry_date <= "' . $last_date_of_8month . '")';
							$this->db->where($where);
							$query = $this->db->get();
							$query_result_iq8 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('enquiry_register');
							$where = '(enquiry_register.enquiry_date >= "' . $first_date_of_9month . '" And enquiry_register.enquiry_date <= "' . $last_date_of_9month . '")';
							$this->db->where($where);
							$query = $this->db->get();
							$query_result_iq9 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('enquiry_register');
							$where = '(enquiry_register.enquiry_date >= "' . $first_date_of_10month . '" And enquiry_register.enquiry_date <= "' . $last_date_of_10month . '")';
							$this->db->where($where);
							$query = $this->db->get();
							$query_result_iq10 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('enquiry_register');
							$where = '(enquiry_register.enquiry_date >= "' . $first_date_of11month . '" And enquiry_register.enquiry_date <= "' . $last_date_of_11month . '")';
							$this->db->where($where);
							$query = $this->db->get();
							$query_result_iq11 = $query->num_rows();

							////offer Count

							$this->db->select('*');
							$this->db->from('offer_register');
							$where = '(offer_register.offer_date >= "' . $first_date_of_0month . '" And offer_register.offer_date <= "' . $last_date_of_0month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status !=',10);
							$query0 = $this->db->get();
							$query_result0 = $query0->num_rows();

							$this->db->select('*');
							$this->db->from('offer_register');
							$where = '(offer_register.offer_date >= "' . $first_date_of_1month . '" And offer_register.offer_date <= "' . $last_date_of_1month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status !=',10);
							$query1 = $this->db->get();
							$query_result1 = $query1->num_rows();

							$this->db->select('*');
							$this->db->from('offer_register');
							$where = '(offer_register.offer_date >= "' . $first_date_of_2month . '" And offer_register.offer_date <= "' . $last_date_of_2month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status !=',10);
							$query2 = $this->db->get();
							$query_result2 = $query2->num_rows();

							$this->db->select('*');
							$this->db->from('offer_register');
							$where = '(offer_register.offer_date >= "' . $first_date_of_3month . '" And offer_register.offer_date <= "' . $last_date_of_3month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status !=',10);
							$query3 = $this->db->get();
							$query_result3 = $query3->num_rows();

							$this->db->select('*');
							$this->db->from('offer_register');
							$where = '(offer_register.offer_date >= "' . $first_date_of_4month . '" And offer_register.offer_date <= "' . $last_date_of_4month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status !=',10);
							$query4 = $this->db->get();
							$query_result4 = $query4->num_rows();

							$this->db->select('*');
							$this->db->from('offer_register');
							$where = '(offer_register.offer_date >= "' . $first_date_of5month . '" And offer_register.offer_date <= "' . $last_date_of_5month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status !=',10);
							$query5 = $this->db->get();
							$query_result5 = $query5->num_rows();

							$this->db->select('*');
							$this->db->from('offer_register');
							$where = '(offer_register.offer_date >= "' . $first_date_of_6month . '" And offer_register.offer_date <= "' . $last_date_of_6month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status !=',10);
							$query6 = $this->db->get();
							$query_result6 = $query6->num_rows();

							$this->db->select('*');
							$this->db->from('offer_register');
							$where = '(offer_register.offer_date >= "' . $first_date_of_7month . '" And offer_register.offer_date <= "' . $last_date_of_7month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status !=',10);
							$query7 = $this->db->get();
							$query_result7 = $query7->num_rows();

							$this->db->select('*');
							$this->db->from('offer_register');
							$where = '(offer_register.offer_date >= "' . $first_date_of_8month . '" And offer_register.offer_date <= "' . $last_date_of_8month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status !=',10);
							$query8 = $this->db->get();
							$query_result8 = $query8->num_rows();

							$this->db->select('*');
							$this->db->from('offer_register');
							$where = '(offer_register.offer_date >= "' . $first_date_of_9month . '" And offer_register.offer_date <= "' . $last_date_of_9month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status !=',10);
							$query9 = $this->db->get();
							$query_result9 = $query9->num_rows();

							$this->db->select('*');
							$this->db->from('offer_register');
							$where = '(offer_register.offer_date >= "' . $first_date_of_10month . '" And offer_register.offer_date <= "' . $last_date_of_10month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status !=',10);
							$query10 = $this->db->get();
							$query_result10 = $query10->num_rows();

							$this->db->select('*');
							$this->db->from('offer_register');
							$where = '(offer_register.offer_date >= "' . $first_date_of11month . '" And offer_register.offer_date <= "' . $last_date_of_11month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status !=',10);
							$query11 = $this->db->get();
							$query_result11 = $query11->num_rows();

							////sales order Count

							$this->db->select('*');
							$this->db->from('offer_register');
							$where = '(offer_register.offer_close_date >= "' . $first_date_of_0month . '" And offer_register.offer_close_date <= "' . $last_date_of_0month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status',6);
							$query = $this->db->get();
							$query_result_sq0 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('offer_register');
							$where = '(offer_register.offer_close_date >= "' . $first_date_of_1month . '" And offer_register.offer_close_date <= "' . $last_date_of_1month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status',6);
							$query = $this->db->get();
							$query_result_sq1 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('offer_register');
							$where = '(offer_register.offer_close_date >= "' . $first_date_of_2month . '" And offer_register.offer_close_date <= "' . $last_date_of_2month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status',6);
							$query = $this->db->get();
							$query_result_sq2 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('offer_register');
							$where = '(offer_register.offer_close_date >= "' . $first_date_of_3month . '" And offer_register.offer_close_date <= "' . $last_date_of_3month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status',6);
							$query = $this->db->get();
							$query_result_sq3 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('offer_register');
							$where = '(offer_register.offer_close_date >= "' . $first_date_of_4month . '" And offer_register.offer_close_date <= "' . $last_date_of_4month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status',6);
							$query = $this->db->get();
							$query_result_sq4 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('offer_register');
							$where = '(offer_register.offer_close_date >= "' . $first_date_of5month . '" And offer_register.offer_close_date <= "' . $last_date_of_5month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status',6);
							$query = $this->db->get();
							$query_result_sq5 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('offer_register');
							$where = '(offer_register.offer_close_date >= "' . $first_date_of_6month . '" And offer_register.offer_close_date <= "' . $last_date_of_6month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status',6);
							$query = $this->db->get();
							$query_result_sq6 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('offer_register');
							$where = '(offer_register.offer_close_date >= "' . $first_date_of_7month . '" And offer_register.offer_close_date<= "' . $last_date_of_7month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status',6);
							$query = $this->db->get();
							$query_result_sq7 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('offer_register');
							$where = '(offer_register.offer_close_date >= "' . $first_date_of_8month . '" And offer_register.offer_close_date <= "' . $last_date_of_8month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status',6);
							$query = $this->db->get();
							$query_result_sq8 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('offer_register');
							$where = '(offer_register.offer_close_date >= "' . $first_date_of_9month . '" And offer_register.offer_close_date <= "' . $last_date_of_9month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status',6);
							$query = $this->db->get();
							$query_result_sq9 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('offer_register');
							$where = '(offer_register.offer_close_date >= "' . $first_date_of_10month . '" And offer_register.offer_close_date <= "' . $last_date_of_10month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status',6);
							$query = $this->db->get();
							$query_result_sq10 = $query->num_rows();

							$this->db->select('*');
							$this->db->from('offer_register');
							$where = '(offer_register.offer_close_date >= "' . $first_date_of11month . '" And offer_register.offer_close_date <= "' . $last_date_of_11month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status',6);
							$query = $this->db->get();
							$query_result_sq11 = $query->num_rows();

							////offer amount

							$this->db->select_sum('offer_product_relation.total_amount_without_gst');
							$this->db->from('offer_register');
							$this->db->join('offer_product_relation', ' offer_register.entity_id = offer_product_relation.offer_id', 'INNER');
							$where = '(offer_register.offer_date >= "' . $first_date_of11month . '" And offer_register.offer_date <= "' . $last_date_of_11month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status !=',10);
							$query = $this->db->get();
							$query_result = $query->row_array();
							$amt11 = $query_result['total_amount_without_gst'];

							$this->db->select_sum('offer_product_relation.total_amount_without_gst');
							$this->db->from('offer_register');
							$this->db->join('offer_product_relation', ' offer_register.entity_id = offer_product_relation.offer_id', 'INNER');
							$where = '(offer_register.offer_date >= "' . $first_date_of_10month . '" And offer_register.offer_date <= "' . $last_date_of_10month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status !=',10);
							$query = $this->db->get();
							$query_result = $query->row_array();
							$amt10 = $query_result['total_amount_without_gst'];

							$this->db->select_sum('offer_product_relation.total_amount_without_gst');
							$this->db->from('offer_register');
							$this->db->join('offer_product_relation', ' offer_register.entity_id = offer_product_relation.offer_id', 'INNER');
							$where = '(offer_register.offer_date >= "' . $first_date_of_9month . '" And offer_register.offer_date <= "' . $last_date_of_9month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status !=',10);
							$query = $this->db->get();
							$query_result = $query->row_array();
							$amt9 = $query_result['total_amount_without_gst'];

							$this->db->select_sum('offer_product_relation.total_amount_without_gst');
							$this->db->from('offer_register');
							$this->db->join('offer_product_relation', ' offer_register.entity_id = offer_product_relation.offer_id', 'INNER');
							$where = '(offer_register.offer_date >= "' . $first_date_of_8month . '" And offer_register.offer_date <= "' . $last_date_of_8month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status !=',10);
							$query = $this->db->get();
							$query_result = $query->row_array();
							$amt8 = $query_result['total_amount_without_gst'];

							$this->db->select_sum('offer_product_relation.total_amount_without_gst');
							$this->db->from('offer_register');
							$this->db->join('offer_product_relation', ' offer_register.entity_id = offer_product_relation.offer_id', 'INNER');
							$where = '(offer_register.offer_date >= "' . $first_date_of_7month . '" And offer_register.offer_date <= "' . $last_date_of_7month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status !=',10);
							$query = $this->db->get();
							$query_result = $query->row_array();
							$amt7 = $query_result['total_amount_without_gst'];

							$this->db->select_sum('offer_product_relation.total_amount_without_gst');
							$this->db->from('offer_register');
							$this->db->join('offer_product_relation', ' offer_register.entity_id = offer_product_relation.offer_id', 'INNER');
							$where = '(offer_register.offer_date >= "' . $first_date_of_6month . '" And offer_register.offer_date <= "' . $last_date_of_6month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status !=',10);
							$query = $this->db->get();
							$query_result = $query->row_array();
							$amt6 = $query_result['total_amount_without_gst'];

							$this->db->select_sum('offer_product_relation.total_amount_without_gst');
							$this->db->from('offer_register');
							$this->db->join('offer_product_relation', ' offer_register.entity_id = offer_product_relation.offer_id', 'INNER');
							$where = '(offer_register.offer_date >= "' . $first_date_of5month . '" And offer_register.offer_date <= "' . $last_date_of_5month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status !=',10);
							$query = $this->db->get();
							$query_result = $query->row_array();
							$amt5 = $query_result['total_amount_without_gst'];

							$this->db->select_sum('offer_product_relation.total_amount_without_gst');
							$this->db->from('offer_register');
							$this->db->join('offer_product_relation', ' offer_register.entity_id = offer_product_relation.offer_id', 'INNER');
							$where = '(offer_register.offer_date >= "' . $first_date_of_4month . '" And offer_register.offer_date <= "' . $last_date_of_4month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status !=',10);
							$query = $this->db->get();
							$query_result = $query->row_array();
							$amt4 = $query_result['total_amount_without_gst'];

							$this->db->select_sum('offer_product_relation.total_amount_without_gst');
							$this->db->from('offer_register');
							$this->db->join('offer_product_relation', ' offer_register.entity_id = offer_product_relation.offer_id', 'INNER');
							$where = '(offer_register.offer_date >= "' . $first_date_of_3month . '" And offer_register.offer_date <= "' . $last_date_of_3month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status !=',10);
							$query = $this->db->get();
							$query_result = $query->row_array();
							$amt3 = $query_result['total_amount_without_gst'];

							$this->db->select_sum('offer_product_relation.total_amount_without_gst');
							$this->db->from('offer_register');
							$this->db->join('offer_product_relation', ' offer_register.entity_id = offer_product_relation.offer_id', 'INNER');
							$where = '(offer_register.offer_date >= "' . $first_date_of_2month . '" And offer_register.offer_date <= "' . $last_date_of_2month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status !=',10);
							$query = $this->db->get();
							$query_result = $query->row_array();
							$amt2 = $query_result['total_amount_without_gst'];

							$this->db->select_sum('offer_product_relation.total_amount_without_gst');
							$this->db->from('offer_register');
							$this->db->join('offer_product_relation', ' offer_register.entity_id = offer_product_relation.offer_id', 'INNER');
							$where = '(offer_register.offer_date >= "' . $first_date_of_1month . '" And offer_register.offer_date <= "' . $last_date_of_1month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status !=',10);
							$query = $this->db->get();
							$query_result = $query->row_array();
							$amt1 = $query_result['total_amount_without_gst'];

							$this->db->select_sum('offer_product_relation.total_amount_without_gst');
							$this->db->from('offer_register');
							$this->db->join('offer_product_relation', ' offer_register.entity_id = offer_product_relation.offer_id', 'INNER');
							$where = '(offer_register.offer_date >= "' . $first_date_of_0month . '" And offer_register.offer_date <= "' . $last_date_of_0month . '")';
							$this->db->where($where);
							$this->db->where('offer_register.status !=',10);
							$query = $this->db->get();
							$query_result = $query->row_array();
							$amt0 = $query_result['total_amount_without_gst'];

							////sale amount

							$this->db->select_sum('offer_product_relation.total_amount_without_gst');
							$this->db->from('offer_register');
							$this->db->join('offer_product_relation', ' offer_product_relation.offer_id = offer_register.entity_id', 'INNER');
							$where = '(offer_register.offer_close_date >= "' . $first_date_of11month . '" And offer_register.offer_close_date <= "' . $last_date_of_11month . '" And offer_register.status = 6 )';
							$this->db->where($where);
							$query = $this->db->get();
							$query_result = $query->row_array();
							$amt_so11 = $query_result['total_amount_without_gst'];

							$this->db->select_sum('offer_product_relation.total_amount_without_gst');
							$this->db->from('offer_register');
							$this->db->join('offer_product_relation', ' offer_product_relation.offer_id = offer_register.entity_id', 'INNER');
							$where = '(offer_register.offer_close_date >= "' . $first_date_of_10month . '" And offer_register.offer_close_date <= "' . $last_date_of_10month . '" And offer_register.status = 6 )';
							$this->db->where($where);
							$query = $this->db->get();
							$query_result = $query->row_array();
							$amt_so10 = $query_result['total_amount_without_gst'];

							$this->db->select_sum('offer_product_relation.total_amount_without_gst');
							$this->db->from('offer_register');
							$this->db->join('offer_product_relation', ' offer_product_relation.offer_id = offer_register.entity_id', 'INNER');
							$where = '(offer_register.offer_close_date >= "' . $first_date_of_9month . '" And offer_register.offer_close_date <= "' . $last_date_of_9month . '" And offer_register.status = 6 )';
							$this->db->where($where);
							$query = $this->db->get();
							$query_result = $query->row_array();
							$amt_so9 = $query_result['total_amount_without_gst'];

							$this->db->select_sum('offer_product_relation.total_amount_without_gst');
							$this->db->from('offer_register');
							$this->db->join('offer_product_relation', ' offer_product_relation.offer_id = offer_register.entity_id', 'INNER');
							$where = '(offer_register.offer_close_date >= "' . $first_date_of_8month . '" And offer_register.offer_close_date <= "' . $last_date_of_8month . '" And offer_register.status = 6 )';
							$this->db->where($where);
							$query = $this->db->get();
							$query_result = $query->row_array();
							$amt_so8 = $query_result['total_amount_without_gst'];

							$this->db->select_sum('offer_product_relation.total_amount_without_gst');
							$this->db->from('offer_register');
							$this->db->join('offer_product_relation', ' offer_product_relation.offer_id = offer_register.entity_id', 'INNER');
							$where = '(offer_register.offer_close_date >= "' . $first_date_of_7month . '" And offer_register.offer_close_date <= "' . $last_date_of_7month . '" And offer_register.status = 6 )';
							$this->db->where($where);
							$query = $this->db->get();
							$query_result = $query->row_array();
							$amt_so7 = $query_result['total_amount_without_gst'];

							$this->db->select_sum('offer_product_relation.total_amount_without_gst');
							$this->db->from('offer_register');
							$this->db->join('offer_product_relation', ' offer_product_relation.offer_id = offer_register.entity_id', 'INNER');
							$where = '(offer_register.offer_close_date >= "' . $first_date_of_6month . '" And offer_register.offer_close_date <= "' . $last_date_of_6month . '" And offer_register.status = 6 )';
							$this->db->where($where);
							$query = $this->db->get();
							$query_result = $query->row_array();
							$amt_so6 = $query_result['total_amount_without_gst'];

							$this->db->select_sum('offer_product_relation.total_amount_without_gst');
							$this->db->from('offer_register');
							$this->db->join('offer_product_relation', ' offer_product_relation.offer_id = offer_register.entity_id', 'INNER');
							$where = '(offer_register.offer_close_date >= "' . $first_date_of5month . '" And offer_register.offer_close_date <= "' . $last_date_of_5month . '" And offer_register.status = 6 )';
							$this->db->where($where);
							$query = $this->db->get();
							$query_result = $query->row_array();
							$amt_so5 = $query_result['total_amount_without_gst'];

							$this->db->select_sum('offer_product_relation.total_amount_without_gst');
							$this->db->from('offer_register');
							$this->db->join('offer_product_relation', ' offer_product_relation.offer_id = offer_register.entity_id', 'INNER');
							$where = '(offer_register.offer_close_date >= "' . $first_date_of5month . '" And offer_register.offer_close_date <= "' . $last_date_of_5month . '" And offer_register.status = 6 )';
							$this->db->where($where);
							$query = $this->db->get();
							$query_result = $query->row_array();
							$amt_so5 = $query_result['total_amount_without_gst'];

							$this->db->select_sum('offer_product_relation.total_amount_without_gst');
							$this->db->from('offer_register');
							$this->db->join('offer_product_relation', ' offer_product_relation.offer_id = offer_register.entity_id', 'INNER');
							$where = '(offer_register.offer_close_date >= "' . $first_date_of_4month . '" And offer_register.offer_close_date <= "' . $last_date_of_4month . '" And offer_register.status = 6 )';
							$this->db->where($where);
							$query = $this->db->get();
							$query_result = $query->row_array();
							$amt_so4 = $query_result['total_amount_without_gst'];

							$this->db->select_sum('offer_product_relation.total_amount_without_gst');
							$this->db->from('offer_register');
							$this->db->join('offer_product_relation', ' offer_product_relation.offer_id = offer_register.entity_id', 'INNER');
							$where = '(offer_register.offer_close_date >= "' . $first_date_of_3month . '" And offer_register.offer_close_date <= "' . $last_date_of_3month . '" And offer_register.status = 6 )';
							$this->db->where($where);
							$query = $this->db->get();
							$query_result = $query->row_array();
							$amt_so3 = $query_result['total_amount_without_gst'];

							$this->db->select_sum('offer_product_relation.total_amount_without_gst');
							$this->db->from('offer_register');
							$this->db->join('offer_product_relation', ' offer_product_relation.offer_id = offer_register.entity_id', 'INNER');
							$where = '(offer_register.offer_close_date >= "' . $first_date_of_2month . '" And offer_register.offer_close_date <= "' . $last_date_of_2month . '" And offer_register.status = 6 )';
							$this->db->where($where);
							$query = $this->db->get();
							$query_result = $query->row_array();
							$amt_so2 = $query_result['total_amount_without_gst'];

							$this->db->select_sum('offer_product_relation.total_amount_without_gst');
							$this->db->from('offer_register');
							$this->db->join('offer_product_relation', ' offer_product_relation.offer_id = offer_register.entity_id', 'INNER');
							$where = '(offer_register.offer_close_date >= "' . $first_date_of_1month . '" And offer_register.offer_close_date <= "' . $last_date_of_1month . '" And offer_register.status = 6 )';
							$this->db->where($where);
							$query = $this->db->get();
							$query_result = $query->row_array();
							$amt_so1 = $query_result['total_amount_without_gst'];

							$this->db->select_sum('offer_product_relation.total_amount_without_gst');
							$this->db->from('offer_register');
							$this->db->join('offer_product_relation', ' offer_product_relation.offer_id = offer_register.entity_id', 'INNER');
							$where = '(offer_register.offer_close_date >= "' . $first_date_of_0month . '" And offer_register.offer_close_date <= "' . $last_date_of_0month . '" And offer_register.status = 6 )';
							$this->db->where($where);
							$query = $this->db->get();
							$query_result = $query->row_array();
							$amt_so0 = $query_result['total_amount_without_gst'];
							
							?>
							<!-- general form elements disabled -->
							<div class="card card-primary">
								<div class="card-header">
									<h3 class="card-title">Performance Summary</h3>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="example1" class="table table-bordered table-striped">
											<thead>
												<tr>
													<th>SR NO</th>
													<th>Month</th>
													<th>No of Leads</th>
													<th>No of Enquiry</th>
													<th>No of Quotations</th>
													<th>Quotation value</th>
													<th>Won Order</th>
													<th>Won Amount</th>
													<th>Order Lost</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>1</td>
													<td><?php echo $month0; ?></td>
													<td><?php echo $query_result_ldq0; ?></td>
													<td><?php echo $query_result_iq0; ?></td>
													<td><?php echo  $query_result0; ?></td>
													<td><?php echo number_format($amt0,"0",".",","); ?></td>
													<td><?php echo $query_result_sq0; ?></td>
													<td><?php echo number_format($amt_so0,"0",".",","); ?></td>
													<td><?php echo $lost_enquiry_result0; ?></td>
												</tr>

												<tr>
													<td>2</td>
													<td><?php echo $month1; ?></td>
													<td><?php echo $query_result_ldq1; ?></td>
													<td><?php echo $query_result_iq1; ?></td>
													<td><?php echo  $query_result1; ?></td>
													<td><?php echo number_format($amt1,"0",".",","); ?></td>
													<td><?php echo $query_result_sq1; ?></td>
													<td><?php echo number_format($amt_so1,"0",".",","); ?></td>
													<td><?php echo $lost_enquiry_result1; ?></td>
												</tr>

												<tr>
													<td>3</td>
													<td><?php echo $month2; ?></td>
													<td><?php echo $query_result_ldq2; ?></td>
													<td><?php echo $query_result_iq2; ?></td>
													<td><?php echo  $query_result4; ?></td>
													<td><?php echo number_format($amt2,"0",".",","); ?></td>
													<td><?php echo $query_result_sq2; ?></td>
													<td><?php echo number_format($amt_so2,"0",".",","); ?></td>
													<td><?php echo $lost_enquiry_result2; ?></td>
												</tr>

												<tr>
													<td>4</td>
													<td><?php echo $month3; ?></td>
													<td><?php echo $query_result_ldq3; ?></td>
													<td><?php echo $query_result_iq3; ?></td>
													<td><?php echo  $query_result3 ?></td>
													<td><?php echo number_format($amt3,"0",".",","); ?></td>
													<td><?php echo $query_result_sq3; ?></td>
													<td><?php echo number_format($amt_so3,"0",".",","); ?></td>
													<td><?php echo $lost_enquiry_result3; ?></td>
												</tr>

												<tr>
													<td>5</td>
													<td><?php echo $month4; ?></td>
													<td><?php echo $query_result_ldq4; ?></td>
													<td><?php echo $query_result_iq4; ?></td>
													<td><?php echo  $query_result4 ?></td>
													<td><?php echo number_format($amt4,"0",".",","); ?></td>
													<td><?php echo $query_result_sq4; ?></td>
													<td><?php echo number_format($amt_so4,"0",".",","); ?></td>
													<td><?php echo $lost_enquiry_result4; ?></td>
												</tr>

												<tr>
													<td>6</td>
													<td><?php echo $month5; ?></td>
													<td><?php echo $query_result_ldq5; ?></td>
													<td><?php echo $query_result_iq5; ?></td>
													<td><?php echo  $query_result5 ?></td>
													<td><?php echo number_format($amt5,"0",".",","); ?></td>
													<td><?php echo $query_result_sq5; ?></td>
													<td><?php echo number_format($amt_so5,"0",".",","); ?></td>
													<td><?php echo $lost_enquiry_result5; ?></td>
												</tr>

												<tr>
													<td>7</td>
													<td><?php echo $month6; ?></td>
													<td><?php echo $query_result_ldq6; ?></td>
													<td><?php echo $query_result_iq6; ?></td>
													<td><?php echo  $query_result6; ?></td>
													<td><?php echo number_format($amt6,"0",".",","); ?></td>
													<td><?php echo $query_result_sq6; ?></td>
													<td><?php echo number_format($amt_so6,"0",".",","); ?></td>
													<td><?php echo $lost_enquiry_result6; ?></td>
												</tr>

												<tr>
													<td>8</td>
													<td><?php echo $month7; ?></td>
													<td><?php echo $query_result_ldq7; ?></td>
													<td><?php echo $query_result_iq7; ?></td>
													<td><?php echo  $query_result7; ?></td>
													<td><?php echo number_format($amt7,"0",".",","); ?></td>
													<td><?php echo $query_result_sq7; ?></td>
													<td><?php echo number_format($amt_so7,"0",".",","); ?></td>
													<td><?php echo $lost_enquiry_result7; ?></td>
												</tr>

												<tr>
													<td>9</td>
													<td><?php echo $month8; ?></td>
													<td><?php echo $query_result_ldq8; ?></td>
													<td><?php echo $query_result_iq8; ?></td>
													<td><?php echo  $query_result8; ?></td>
													<td><?php echo number_format($amt8,"0",".",","); ?></td>
													<td><?php echo $query_result_sq8; ?></td>
													<td><?php echo number_format($amt_so8,"0",".",",") ?></td>
													<td><?php echo $lost_enquiry_result8; ?></td>
												</tr>

												<tr>
													<td>10</td>
													<td><?php echo $month9; ?></td>
													<td><?php echo $query_result_ldq9; ?></td>
													<td><?php echo $query_result_iq9; ?></td>
													<td><?php echo  $query_result9 ?></td>
													<td><?php echo number_format($amt9,"0",".",","); ?></td>
													<td><?php echo $query_result_sq9; ?></td>
													<td><?php echo number_format($amt_so9,"0",".",","); ?></td>
													<td><?php echo $lost_enquiry_result9; ?></td>
												</tr>

												<tr>
													<td>11</td>
													<td><?php echo $month10; ?></td>
													<td><?php echo $query_result_ldq10; ?></td>
													<td><?php echo $query_result_iq10; ?></td>
													<td><?php echo  $query_result10 ?></td>
													<td><?php echo number_format($amt10,"0",".",","); ?></td>
													<td><?php echo $query_result_sq10; ?></td>
													<td><?php echo number_format($amt_so10,"0",".",",") ?></td>
													<td><?php echo $lost_enquiry_result10; ?></td>
												</tr>

												<tr>
													<td>12</td>
													<td><?php echo $month11; ?></td>
													<td><?php echo $query_result_ldq11; ?></td>
													<td><?php echo $query_result_iq11; ?></td>
													<td><?php echo  $query_result11; ?></td>
													<td><?php echo number_format($amt11,"0",".",","); ?></td>
													<td><?php echo $query_result_sq11; ?></td>
													<td><?php echo number_format($amt_so11,"0",".",","); ?></td>
													<td><?php echo $lost_enquiry_result11; ?></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<?php $this->load->view('footer'); ?>
		<!-- Control Sidebar -->
		<aside class="control-sidebar control-sidebar-dark">
			<!-- Control sidebar content goes here -->
		</aside>
		<!-- /.control-sidebar -->
	</div>
	<!-- ./wrapper -->
	<!-- jQuery -->
	<script src="<?php echo base_url() . 'assets/plugins/jquery/jquery.min.js' ?>"></script>
	<!-- Bootstrap 4 -->
	<script src="<?php echo base_url() . 'assets/plugins/bootstrap/js/bootstrap.bundle.min.js' ?>"></script>
	<!-- Select2 -->
	<script src="<?php echo base_url() . 'assets/plugins/select2/js/select2.full.min.js' ?>"></script>
	<!-- Bootstrap4 Duallistbox -->
	<script src="<?php echo base_url() . 'assets/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js' ?>"></script>
	<!-- InputMask -->
	<script src="<?php echo base_url() . 'assets/plugins/moment/moment.min.js' ?>"></script>
	<script src="<?php echo base_url() . 'assets/plugins/inputmask/min/jquery.inputmask.bundle.min.js' ?>"></script>
	<!-- date-range-picker -->
	<script src="<?php echo base_url() . 'assets/plugins/daterangepicker/daterangepicker.js' ?>"></script>
	<!-- bootstrap color picker -->
	<script src="<?php echo base_url() . 'assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js' ?>"></script>
	<!-- Tempusdominus Bootstrap 4 -->
	<script src="<?php echo base_url() . 'assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js' ?>"></script>
	<!-- Bootstrap Switch -->
	<script src="<?php echo base_url() . 'assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js' ?>"></script>
	<!-- AdminLTE App -->
	<script src="<?php echo base_url() . 'assets/dist/js/adminlte.min.js' ?>"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="<?php echo base_url() . 'assets/dist/js/demo.js' ?>"></script>
	<!-- DataTables -->
	<script src="<?php echo base_url() . 'assets/plugins/datatables/jquery.dataTables.js' ?>"></script>
	<script src="<?php echo base_url() . 'assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js' ?>"></script>
	<!-- DataTables -->
	<!-- <script src="assets/plugins/datatables/jquery.dataTables.js"></script>
        <script src="assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script> -->
	<!-- Page script -->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">

	<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
	<!-- Page script -->
	<script>
		$(document).ready(function() {
			$('#example1').DataTable({
				dom: 'Bfrtip',
				buttons: [
					'copyHtml5',
					'excelHtml5',
					'csvHtml5',
					'pdfHtml5'
				]
			});
		});
	</script>
</body>

</html>
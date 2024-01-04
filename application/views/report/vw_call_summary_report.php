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
	<title>Call Summary Report</title>
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
							<h1 class="card-title">Call Summary Report</h1>
							<div class="col-sm-6">
								<br><br>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo base_url() . 'dashboard' ?>">Home</a></li>
									<li class="breadcrumb-item">Call Summary Report
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




							<!-- // echo $timesheet_from_date; -->


							<!-- // $date47 = date('Y-m-d',$date46);
                                      // echo "<br>";
                                      // echo $date47;
/*
                                        $date = date('d-m-Y');
                                        $datestr = strtotime($date);
                                        for($i=-1; $i<-10; $i--){
                                            $date= strtotime('$i day', $datestr); 
                                            
                                            
                                        }
                                        
                                        $date00 = strtotime('+1 day', $datestr); 
                                        $date00 = date('d-m-Y',$date00);
                                        $date0 = date('d-m-Y',$datestr);
                                        $date1 = strtotime('-1 day', $datestr);
                                        $date1 = date('d-m-Y',$date1);
                                        $date2 = strtotime('-2 day', $datestr);
                                        $date2 = date('d-m-Y',$date2);
                                        $date3 = strtotime('-3 day', $datestr);
                                        $date3 = date('d-m-Y',$date3);
                                        $date4 = strtotime('-4 day', $datestr);
                                        $date4 = date('d-m-Y',$date4);
                                        $date5 = strtotime('-5 day', $datestr);
                                        $date5 = date('d-m-Y',$date5);
                                        $date6 = strtotime('-6 day', $datestr);
                                        $date6 = date('d-m-Y',$date6);
                                        $date7 = strtotime('-7 day', $datestr);
                                        $date7 = date('d-m-Y',$date7);
                                        $date8 = strtotime('-8 day', $datestr);
                                        $date8 = date('d-m-Y',$date8);
                                        $date9 = strtotime('-9 day', $datestr);
                                        $date9 = date('d-m-Y',$date9);
                                        $date10 = strtotime('-10 day', $datestr);
                                        $date10 = date('d-m-Y',$date10);
                                        $date11 = strtotime('-11 day', $datestr);
                                        $date11 = date('d-m-Y',$date11);

                                        
                                        
                                        ////Call Count
                                        // date0

                                       

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        $this->db->WHERE('datestamp' , $date0);
                                        
                                        $query = $this->db->get();
                                        $query_call_count0 = $query->num_rows();
                                        
                                        // date1 -->
							<!-- 

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        $this->db->WHERE('datestamp' , $date1);
                                        
                                        $query = $this->db->get();
                                        $query_call_count1 = $query->num_rows();
                                        
                                        
                                        // date2


                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        $this->db->WHERE('datestamp' , $date2);
                                        
                                        $query = $this->db->get();
                                        $query_call_count2 = $query->num_rows();
                                        
                                        
                                        // date3


                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        $this->db->WHERE('datestamp' , $date3);
                                        
                                        $query = $this->db->get();
                                        $query_call_count3 = $query->num_rows();
                                        
                                        
                                        // date4


                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        $this->db->WHERE('datestamp' , $date4);
                                        
                                        $query = $this->db->get();
                                        $query_call_count4 = $query->num_rows();
                                        
                                        
                                        // date5


                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        $this->db->WHERE('datestamp' , $date5);
                                        
                                        $query = $this->db->get();
                                        $query_call_count5 = $query->num_rows();
                                        
                                        
                                        // date6


                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        $this->db->WHERE('datestamp' , $date6);
                                        
                                        $query = $this->db->get();
                                        $query_call_count6 = $query->num_rows();
                                        
                                        
                                        // date7


                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        $this->db->WHERE('datestamp' , $date7);
                                        
                                        $query = $this->db->get();
                                        $query_call_count7 = $query->num_rows();
                                        
                                        
                                        // date8


                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        $this->db->WHERE('datestamp' , $date8);
                                        
                                        $query = $this->db->get();
                                        $query_call_count8 = $query->num_rows();
                                        
                                        
                                        // date9


                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        $this->db->WHERE('datestamp' , $date9);
                                        
                                        $query = $this->db->get();
                                        $query_call_count9 = $query->num_rows();
                                        
                                        
                                        // date10


                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        $this->db->WHERE('datestamp' , $date10);
                                        
                                        $query = $this->db->get();
                                        $query_call_count10 = $query->num_rows();
                                        
                                        
                                        // date11


                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        $this->db->WHERE('datestamp' , $date11);
                                        
                                        $query = $this->db->get();
                                        $query_call_count11 = $query->num_rows();
                                        

                                        ////Answered Call Count
                                        //date0

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('call_answered',1);
                                        $this->db->WHERE('datestamp' , $date0);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_answered0 = $query->num_rows();
                                        

                                        //date1

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('call_answered',1);
                                        $this->db->WHERE('datestamp' , $date1);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_answered1 = $query->num_rows();

                                        //date2

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('call_answered',1);
                                        $this->db->WHERE('datestamp' , $date2);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_answered2 = $query->num_rows();

                                        //date3

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('call_answered',1);
                                        $this->db->WHERE('datestamp' , $date3);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_answered3 = $query->num_rows();

                                        //date4

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('call_answered',1);
                                        $this->db->WHERE('datestamp' , $date4);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_answered4 = $query->num_rows();

                                        //date5

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('call_answered',1);
                                        $this->db->WHERE('datestamp' , $date5);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_answered5 = $query->num_rows();

                                        //date6

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('call_answered',1);
                                        $this->db->WHERE('datestamp' , $date6);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_answered6 = $query->num_rows();

                                        //date7

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('call_answered',1);
                                        $this->db->WHERE('datestamp' , $date7);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_answered7 = $query->num_rows();

                                        //date8

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('call_answered',1);
                                        $this->db->WHERE('datestamp' , $date8);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_answered8 = $query->num_rows();

                                        //date9

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('call_answered',1);
                                        $this->db->WHERE('datestamp' , $date9);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_answered9 = $query->num_rows();

                                        //date10

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('call_answered',1);
                                        $this->db->WHERE('datestamp' , $date10);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_answered10 = $query->num_rows();
                                        
                                        // Closed Calls
                                        //date0

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('case_open_close',1);
                                        $this->db->WHERE('datestamp' , $date0);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_closed0 = $query->num_rows();
                                        
                                        //date1

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('case_open_close',1);
                                        $this->db->WHERE('datestamp' , $date1);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_closed1 = $query->num_rows();
                                        
                                        //date2

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('case_open_close',1);
                                        $this->db->WHERE('datestamp' , $date2);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_closed2 = $query->num_rows();
                                        
                                        //date3

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('case_open_close',1);
                                        $this->db->WHERE('datestamp' , $date3);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_closed3 = $query->num_rows();
                                        
                                        //date4

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('case_open_close',1);
                                        $this->db->WHERE('datestamp' , $date4);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_closed4 = $query->num_rows();
                                        
                                        //date5

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('case_open_close',1);
                                        $this->db->WHERE('datestamp' , $date5);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_closed5 = $query->num_rows();
                                        
                                        //date6

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('case_open_close',1);
                                        $this->db->WHERE('datestamp' , $date6);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_closed6 = $query->num_rows();
                                        
                                        //date7

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('case_open_close',1);
                                        $this->db->WHERE('datestamp' , $date7);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_closed7 = $query->num_rows();
                                        
                                        //date8

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('case_open_close',1);
                                        $this->db->WHERE('datestamp' , $date8);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_closed8 = $query->num_rows();
                                        
                                        //date9

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('case_open_close',1);
                                        $this->db->WHERE('datestamp' , $date9);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_closed9 = $query->num_rows();
                                        
                                        //date10

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('case_open_close',1);
                                        $this->db->WHERE('datestamp' , $date10);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_closed10 = $query->num_rows();
                                        
                                        // Followup Calls
                                        //date0

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('case_open_close',2);
                                        $this->db->WHERE('datestamp' , $date0);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_followup0 = $query->num_rows();
                                        
                                        
                                        //date1

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('case_open_close',2);
                                        $this->db->WHERE('datestamp' , $date1);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_followup1 = $query->num_rows();
                                        
                                        
                                        //date2

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('case_open_close',2);
                                        $this->db->WHERE('datestamp' , $date2);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_followup2 = $query->num_rows();
                                        
                                                                             
                                        //date3

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('case_open_close',2);
                                        $this->db->WHERE('datestamp' , $date3);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_followup3 = $query->num_rows();
                                        
                                        
                                        //date4

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('case_open_close',2);
                                        $this->db->WHERE('datestamp' , $date4);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_followup4 = $query->num_rows();
                                        
                                        
                                        //date5

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('case_open_close',2);
                                        $this->db->WHERE('datestamp' , $date5);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_followup5 = $query->num_rows();
                                        
                                        
                                        //date6

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('case_open_close',2);
                                        $this->db->WHERE('datestamp' , $date6);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_followup6 = $query->num_rows();
                                        
                                        
                                        //date7

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('case_open_close',2);
                                        $this->db->WHERE('datestamp' , $date7);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_followup7 = $query->num_rows();
                                        
                                        
                                        //date8

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('case_open_close',2);
                                        $this->db->WHERE('datestamp' , $date8);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_followup8 = $query->num_rows();
                                        
                                        
                                        //date9

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('case_open_close',2);
                                        $this->db->WHERE('datestamp' , $date9);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_followup9 = $query->num_rows();
                                        
                                        
                                        
                                        //date10

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('case_open_close',2);
                                        $this->db->WHERE('datestamp' , $date10);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_followup10 = $query->num_rows();
                                        
                                        
                                        // Wrong Number Calls

                                        //date0

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('wrong_number',1);
                                        $this->db->WHERE('datestamp' , $date0);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_wrong0 = $query->num_rows();
                                        
                                        

                                        //date1

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('wrong_number',1);
                                        $this->db->WHERE('datestamp' , $date1);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_wrong1 = $query->num_rows();
                                        
                                        //date2

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('wrong_number',1);
                                        $this->db->WHERE('datestamp' , $date2);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_wrong2 = $query->num_rows();
                                        
                                        //date3

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('wrong_number',1);
                                        $this->db->WHERE('datestamp' , $date3);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_wrong3 = $query->num_rows();
                                        
                                        //date4

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('wrong_number',1);
                                        $this->db->WHERE('datestamp' , $date4);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_wrong4 = $query->num_rows();
                                        
                                        //date5

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('wrong_number',1);
                                        $this->db->WHERE('datestamp' , $date5);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_wrong5 = $query->num_rows();
                                        
                                        //date6

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('wrong_number',1);
                                        $this->db->WHERE('datestamp' , $date6);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_wrong6 = $query->num_rows();
                                        
                                        //date7

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('wrong_number',1);
                                        $this->db->WHERE('datestamp' , $date7);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_wrong7 = $query->num_rows();
                                        
                                        //date8

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('wrong_number',1);
                                        $this->db->WHERE('datestamp' , $date8);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_wrong8 = $query->num_rows();
                                        
                                        //date9

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('wrong_number',1);
                                        $this->db->WHERE('datestamp' , $date9);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_wrong9 = $query->num_rows();
                                        
                                        //date10

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('wrong_number',1);
                                        $this->db->WHERE('datestamp' , $date10);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_wrong10 = $query->num_rows();
                                        
                                        
                                        
                                        // DND Calls

                                        //date0

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('dnd',1);
                                        $this->db->WHERE('datestamp' , $date0);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_DND0 = $query->num_rows();
                                        
                                        //date1

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('dnd',1);
                                        $this->db->WHERE('datestamp' , $date1);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_DND1 = $query->num_rows();
                                        
                                        //date2

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('dnd',1);
                                        $this->db->WHERE('datestamp' , $date2);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_DND2 = $query->num_rows();
                                        
                                        //date3

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('dnd',1);
                                        $this->db->WHERE('datestamp' , $date3);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_DND3 = $query->num_rows();
                                        
                                        //date4

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('dnd',1);
                                        $this->db->WHERE('datestamp' , $date4);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_DND4 = $query->num_rows();
                                        
                                        //date5

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('dnd',1);
                                        $this->db->WHERE('datestamp' , $date5);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_DND5 = $query->num_rows();
                                        
                                        //date6

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('dnd',1);
                                        $this->db->WHERE('datestamp' , $date6);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_DND6 = $query->num_rows();
                                        
                                        //date7

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('dnd',1);
                                        $this->db->WHERE('datestamp' , $date7);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_DND7 = $query->num_rows();
                                        
                                        //date8

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('dnd',1);
                                        $this->db->WHERE('datestamp' , $date8);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_DND8 = $query->num_rows();
                                        
                                        //date9

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('dnd',1);
                                        $this->db->WHERE('datestamp' , $date9);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_DND9 = $query->num_rows();
                                        
                                        //date10

                                        $this->db->select('*');
                                        $this->db->from('call_log');
                                        // $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
                                        $this->db->where('dnd',1);
                                        $this->db->WHERE('datestamp' , $date10);
                                        // $this->db->where('last_log_date > "'.$date2.'"');
                                        $query = $this->db->get();
                                        $query_DND10 = $query->num_rows();
                                        
                                        
                                       
                                    ?>

                                          */ -->

							<!-- // general form elements disabled -->
							<div class="card card-primary">
								<div class="card-header">
									<h3 class="card-title">Call Summary </h3>
								</div>
								<div class="card-body">
									<?php
										$campaign_name = $this->db->get_where('campaign_register', ['entity_id' => $campaign_id])->row()->campaign_name;
									?>
								<h3 class="bg-warning">Campaign Name: <?php  echo $campaign_name ; ?></h3>

									<div class="table-responsive">
										<table id="example1" class="table table-bordered table-striped">
											<thead>
												<tr>
													<th>SR NO</th>
													<th>Date</th>
													<th>Total Calls</th>
													<th>Answered Calls</th>
													<th>Closed Calls</th>
													<th>To Follow</th>
													<th>Wrong Numbers</th>
													<th>DND</th>
												</tr>
											</thead>
											<tbody>

												<?php
												///getting date wise data
												for (

													$date45 = strtotime($timesheet_from_date);
													$date45 < strtotime($timesheet_to_date);
													$date45 = strtotime('+1 day', $date45)
												) {
													$datestr = date('d-m-Y', $date45);
													// $datestr = $date45;


													//call count

													$this->db->select('*');
													$this->db->from('call_log');
													$this->db->WHERE('datestamp', $datestr);
													$this->db->WHERE('campaign_id', $campaign_id);

													$query = $this->db->get();
													$query_call_count0 = $query->num_rows();
													$result = $query->row_array();
													// echo "<pre>";
													// echo($result['entity_id'])."<br>";

													// die();


													////Answered Call Count
													//date0

													$this->db->select('*');
													$this->db->from('call_log');
													// $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
													$this->db->where('call_answered', 1);
													$this->db->WHERE('campaign_id', $campaign_id);
													$this->db->WHERE('datestamp', $datestr);
													// $this->db->where('last_log_date > "'.$date2.'"');
													$query = $this->db->get();
													$query_answered0 = $query->num_rows();

													// Closed Calls
													//date0

													$this->db->select('*');
													$this->db->from('call_log');
													// $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
													$this->db->WHERE('campaign_id', $campaign_id);
													$this->db->where('case_open_close', 1);
													$this->db->WHERE('datestamp', $datestr);
													// $this->db->where('last_log_date > "'.$date2.'"');
													$query = $this->db->get();
													$query_closed0 = $query->num_rows();


													// Followup Calls
													//date0

													$this->db->select('*');
													$this->db->from('call_log');
													// $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
													$this->db->WHERE('campaign_id', $campaign_id);
													$this->db->where('case_open_close', 2);
													$this->db->WHERE('datestamp', $datestr);
													// $this->db->where('last_log_date > "'.$date2.'"');
													$query = $this->db->get();
													$query_followup0 = $query->num_rows();


													// Wrong Number Calls

													//date0

													$this->db->select('*');
													$this->db->from('call_log');
													// $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
													$this->db->WHERE('campaign_id', $campaign_id);
													$this->db->where('wrong_number', 1);
													$this->db->WHERE('datestamp', $datestr);
													// $this->db->where('last_log_date > "'.$date2.'"');
													$query = $this->db->get();
													$query_wrong0 = $query->num_rows();

													// DND Calls

													//date0

													$this->db->select('*');
													$this->db->from('call_log');
													// $where = '(call_log.last_log_date <="'. $datestr.'" And call_log.last_log_date >"'.$date1.'" )';
													$this->db->WHERE('campaign_id', $campaign_id);
													$this->db->where('dnd', 1);
													$this->db->WHERE('datestamp', $datestr);
													// $this->db->where('last_log_date > "'.$date2.'"');
													$query = $this->db->get();
													$query_DND0 = $query->num_rows();


													//   echo $datestr."<br>";
													//   echo $query_call_count0."<br>";
													//   echo $query_answered0."<br>";
													//   echo $query_closed0."<br>";
													//   echo $query_followup0."<br>";
													//   echo $query_wrong0."<br>";
													//   echo $query_DND0."<br>";
													// }
												?>


													<tr>
														<td>1</td>
														<td><?php echo $datestr; ?></td>
														<td><?php echo $query_call_count0; ?></td>
														<td><?php echo $query_answered0; ?></td>
														<td><?php echo $query_closed0; ?></td>
														<td><?php echo $query_followup0; ?></td>
														<td><?php echo $query_wrong0; ?></td>
														<td><?php echo $query_DND0; ?></td>
													</tr>

												<?php
												}
												?>

												<!-- /* -->
												<!-- <tr>
													<td>2</td>
													<td><?php echo $date1; ?></td>
													<td><?php echo $query_call_count1; ?></td>
													<td><?php echo $query_answered1; ?></td>
													<td><?php echo $query_closed1; ?></td>
													<td><?php echo $query_followup1; ?></td>
													<td><?php echo $query_wrong1 ?></td>
													<td><?php echo $query_DND1; ?></td>
											</tr>

											<tr>
													<td>3</td>  
													<td><?php echo $date2; ?></td>
													<td><?php echo $query_call_count2; ?></td>
													<td><?php echo $query_answered2; ?></td>
													<td><?php echo $query_closed2; ?></td>
													<td><?php echo $query_followup2; ?></td>
													<td><?php echo $query_wrong2 ?></td>
													<td><?php echo $query_DND2; ?></td>
											</tr>

											<tr>
													<td>4</td>  
													<td><?php echo $date3; ?></td>
													<td><?php echo $query_call_count3; ?></td>
													<td><?php echo $query_answered3 ?></td>
													<td><?php echo $query_closed3; ?></td>
													<td><?php echo $query_followup3; ?></td>
													<td><?php echo $query_wrong3 ?></td>
													<td><?php echo $query_DND3; ?></td>
											</tr>

											<tr>
													<td>5</td>  
													<td><?php echo $date4; ?></td>
													<td><?php echo $query_call_count4; ?></td>
													<td><?php echo $query_answered4 ?></td>
													<td><?php echo $query_closed4; ?></td>
													<td><?php echo $query_followup4; ?></td>
													<td><?php echo $query_wrong4 ?></td>
													<td><?php echo $query_DND4; ?></td>
											</tr>

											<tr>
													<td>6</td>  
													<td><?php echo $date5; ?></td>
													<td><?php echo $query_call_count5; ?></td>
													<td><?php echo $query_answered5 ?></td>
													<td><?php echo $query_closed5; ?></td>
													<td><?php echo $query_followup5; ?></td>
													<td><?php echo $query_wrong5 ?></td>
													<td><?php echo $query_DND5; ?></td>
											</tr>

											<tr>
													<td>7</td>  
													<td><?php echo $date6; ?></td>
													<td><?php echo $query_call_count6; ?></td>
													<td><?php echo $query_answered6; ?></td>
													<td><?php echo $query_closed6; ?></td>
													<td><?php echo $query_followup6; ?></td>
													<td><?php echo $query_wrong6 ?></td>
													<td><?php echo $query_DND6; ?></td>
											</tr>

											<tr>
													<td>8</td>  
													<td><?php echo $date7; ?></td>
													<td><?php echo $query_call_count7; ?></td>
													<td><?php echo $query_answered7; ?></td>
													<td><?php echo $query_closed7; ?></td>
													<td><?php echo $query_followup7; ?></td>
													<td><?php echo $query_wrong7 ?></td>
													<td><?php echo $query_DND7; ?></td>
											</tr>

											<tr>
													<td>9</td>  
													<td><?php echo $date8; ?></td>
													<td><?php echo $query_call_count8; ?></td>
													<td><?php echo $query_answered8; ?></td>
													<td><?php echo $query_closed8; ?></td>
													<td><?php echo $query_followup8; ?></td>
													<td><?php echo $query_wrong8 ?></td>
													<td><?php echo $query_DND8; ?></td>
											</tr>

											<tr>
													<td>10</td>
													<td><?php echo $date9; ?></td>
													<td><?php echo $query_call_count9; ?></td>
													<td><?php echo $query_answered9 ?></td>
													<td><?php echo $query_closed9; ?></td>
													<td><?php echo $query_followup9; ?></td>
													<td><?php echo $query_wrong9 ?></td>
													<td><?php echo $query_DND9; ?></td>
											</tr>

											<tr>
													<td>11</td>
													<td><?php echo $date10; ?></td>
													<td><?php echo $query_call_count10; ?></td>
													<td><?php echo $query_answered10 ?></td>
													<td><?php echo $query_closed10; ?></td>
													<td><?php echo $query_followup10; ?></td>
													<td><?php echo $query_wrong10 ?></td>
													<td><?php echo $query_DND10; ?></td>
											</tr> -->

												<!-- <tr>
													<td>12</td>
													<td><?php echo "NA"; ?></td>
													<td><?php echo $query_call_count11; ?></td>
													<td><?php echo $query_answered11; ?></td>
													<td><?php echo round($amt11); ?></td>
													<td><?php echo $query_result_sq11; ?></td>
													<td><?php echo round($amt_so11); ?></td>
													<td><?php echo $lost_enquiry_result11; ?></td>
													</tr> -->
												<!-- */ -->
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
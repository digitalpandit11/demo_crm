<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
if(!$_SESSION['user_name'])
{
	$data = site_url('welcome');
    header("location:$data");
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
  		<meta http-equiv="X-UA-Compatible" content="IE=edge">
  		<title><?php echo "BluBoxx CRM";?></title>
  		<!-- Tell the browser to be responsive to screen width -->
  		<meta name="viewport" content="width=device-width, initial-scale=1">
  		<!-- Font Awesome -->
 		<link rel="stylesheet" href="<?php echo base_url().'assets/plugins/fontawesome-free/css/all.min.css'?>">
  		<!-- Ionicons -->
  		<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  		<!-- Tempusdominus Bbootstrap 4 -->
  		<link rel="stylesheet" href="<?php echo base_url().'assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css'?>">
  		<!-- iCheck -->
  		<link rel="stylesheet" href="<?php echo base_url().'assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css'?>">
  		<!-- JQVMap -->
  		<link rel="stylesheet" href="<?php echo base_url().'assets/plugins/jqvmap/jqvmap.min.css'?>">
  		<!-- Theme style -->
  		<link rel="stylesheet" href="<?php echo base_url().'assets/dist/css/adminlte.min.css'?>">
  		<!-- overlayScrollbars -->
  		<link rel="stylesheet" href="<?php echo base_url().'assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css'?>">
  		<!-- Daterange picker -->
  		<link rel="stylesheet" href="<?php echo base_url().'assets/plugins/daterangepicker/daterangepicker.css'?>">
  		<!-- summernote -->
  		<link rel="stylesheet" href="<?php echo base_url().'assets/plugins/summernote/summernote-bs4.css'?>">
  		<!-- Google Font: Source Sans Pro -->
  		<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  		<link rel="icon" href="<?php echo base_url().'assets/company_logo/construction.jpg'?>" type="image/ico" />
	</head>
	<body class="hold-transition sidebar-mini layout-fixed">
		<div class="wrapper">
			<?php 
				$this->load->view('header_sidebar');

				$this->db->select('ticket_master.*');
		        $this->db->from('ticket_master');
		        $where = '(ticket_master.ticket_type = "'.'1'.'")';
		        $this->db->where($where);
		        $warrantee_claims_query = $this->db->get();
		        $warrantee_claims_count = $warrantee_claims_query->num_rows();

		        $this->db->select('ticket_master.*');
		        $this->db->from('ticket_master');
		        $where = '(ticket_master.ticket_type = "'.'1'.'")';
		        $this->db->where($where);
		        $where1 = '(ticket_master.status = "'.'1'.'" or ticket_master.status = "'.'2'.'")';
		        $this->db->where($where1);
		        $warrantee_claims_pending_query = $this->db->get();
		        $warrantee_claims_pending_count = $warrantee_claims_pending_query->num_rows();



		        $this->db->select('ticket_master.*');
		        $this->db->from('ticket_master');
		        $where = '(ticket_master.ticket_type = "'.'2'.'")';
		        $this->db->where($where);
		        $paid_service_query = $this->db->get();
		        $paid_service_count = $paid_service_query->num_rows();

		        $this->db->select('ticket_master.*');
		        $this->db->from('ticket_master');
		        $where = '(ticket_master.ticket_type = "'.'2'.'")';
		        $this->db->where($where);
		        $where1 = '(ticket_master.status = "'.'1'.'" or ticket_master.status = "'.'2'.'")';
		        $this->db->where($where1);
		        $paid_service_pending_query = $this->db->get();
		        $paid_service_pending_count = $paid_service_pending_query->num_rows();



		        $this->db->select('ticket_master.*');
		        $this->db->from('ticket_master');
		        $where = '(ticket_master.ticket_type = "'.'3'.'")';
		        $this->db->where($where);
		        $technical_support_query = $this->db->get();
		        $technical_support_count = $technical_support_query->num_rows();

		        $this->db->select('ticket_master.*');
		        $this->db->from('ticket_master');
		        $where = '(ticket_master.ticket_type = "'.'3'.'")';
		        $this->db->where($where);
		        $where1 = '(ticket_master.status = "'.'1'.'" or ticket_master.status = "'.'2'.'")';
		        $this->db->where($where1);
		        $technical_support_pending_query = $this->db->get();
		        $technical_support_pending_count = $technical_support_pending_query->num_rows();



		        $this->db->select('ticket_master.*');
		        $this->db->from('ticket_master');
		        $where = '(ticket_master.ticket_type = "'.'4'.'")';
		        $this->db->where($where);
		        $inhouse_query = $this->db->get();
		        $inhouse_query_count = $inhouse_query->num_rows();

		        $this->db->select('ticket_master.*');
		        $this->db->from('ticket_master');
		        $where = '(ticket_master.ticket_type = "'.'4'.'")';
		        $this->db->where($where);
		        $where1 = '(ticket_master.status = "'.'1'.'" or ticket_master.status = "'.'2'.'")';
		        $this->db->where($where1);
		        $inhouse_pending_query = $this->db->get();
		        $inhouse_pending_query_count = $inhouse_pending_query->num_rows();

		        $this->db->select('predispatch_master.*');
		        $this->db->from('predispatch_master');
		        $predispatch_master = $this->db->get();
		        $predispatch_master_count = $predispatch_master->num_rows();

		        $this->db->select('demo_test_master.*');
		        $this->db->from('demo_test_master');
		        $demo_test_master = $this->db->get();
		        $demo_test_master_count = $demo_test_master->num_rows();
			?>
			<!-- Content Wrapper. Contains page content -->
	  		<div class="content-wrapper">
			    <!-- Content Header (Page header) -->
			    <div class="content-header">
			      	<div class="container-fluid">
			        	<div class="row mb-2">
			          		<div class="col-sm-12">
			          			<center>
			            			<h1 class="m-0 text-dark">Support Dashboard</h1>
			            		</center>
			          		</div><!-- /.col -->
			          		<!-- /.col -->
			        	</div><!-- /.row -->
			      	</div><!-- /.container-fluid -->
			    </div>
			    <!-- /.content-header -->
			    <!-- Main content -->
			    <section class="content">
			      	<div class="container-fluid">
			        	<div class="row">
			          		<div class="col-12 col-sm-6 col-md-4">
			            		<div class="info-box">
			              			<span class="info-box-icon bg-info elevation-1"><i class="fas fa-layer-group"></i></span>
			              			<div class="info-box-content">
			                			<span class="info-box-text"><b>Warrantee Claims Ticket</b></span>
			            				<span class="info-box-number">
				                  			<?php echo $warrantee_claims_count;?>
				                  			<small>Nos</small>
			                			</span>
			              			</div>
			              			<!-- /.info-box-content -->
			            		</div>
			            		<!-- /.info-box -->
			          		</div>

			          		<!-- /.col -->
				          	<div class="col-12 col-sm-6 col-md-4">
				            	<div class="info-box mb-3">
				              		<span class="info-box-icon bg-danger elevation-1"><i class="fas fa-rupee-sign"></i></span>
				              		<div class="info-box-content">
				                		<span class="info-box-text"><b>Paid Service Ticket</b></span>
				                		<span class="info-box-number">
				                  			<?php echo $paid_service_count;?>
				                  			<small>Nos</small>
			                			</span>
				              		</div>
				              		<!-- /.info-box-content -->
				        		</div>
				            	<!-- /.info-box -->
				          	</div>
				          	<!-- /.col -->

			          		<!-- fix for small devices only -->
				          	<div class="clearfix hidden-md-up"></div>

				      		<div class="col-12 col-sm-6 col-md-4">
				        		<div class="info-box mb-3">
				          			<span class="info-box-icon bg-success elevation-1"><i class="fas fa-user-cog"></i></span>

				          			<div class="info-box-content">
				            			<span class="info-box-text"><b>Technical Service Ticket</b></span>
				            			<span class="info-box-number">
				                  			<?php echo $technical_support_count;?>
				                  			<small>Nos</small>
			                			</span>
				         	 		</div>
				          			<!-- /.info-box-content -->
				        		</div>
				        		<!-- /.info-box -->
				      		</div>
			          		<!-- /.col -->

				          	<!-- <div class="col-12 col-sm-6 col-md-4">
				            	<div class="info-box mb-3">
				              		<span class="info-box-icon bg-warning elevation-1"><i class="fas fa-home"></i></span>
				              		<div class="info-box-content">
				                		<span class="info-box-text"><b>Inhouse Ticket</b></span>
				                		<span class="info-box-number">
				                  			<?php echo $inhouse_query_count;?>
				                  			<small>Nos</small>
			                			</span>
				              		</div>
				        		</div>
				          	</div> -->
				          	<!-- /.col -->
			        	</div>
				    </div>
				    <center>
				    	<h3>Pending Tickets</h3>
				    </center>

				    <div class="container-fluid">
			        	<div class="row">
			          		<div class="col-12 col-sm-6 col-md-4">
			            		<div class="info-box">
			              			<span class="info-box-icon bg-info elevation-1"><i class="fas fa-layer-group"></i></span>
			              			<div class="info-box-content">
			                			<span class="info-box-text"><b>Warrantee Claims Ticket</b></span>
			            				<span class="info-box-number">
				                  			<?php echo $warrantee_claims_pending_count;?>
				                  			<small>Nos</small>
			                			</span>
			              			</div>
			              			<!-- /.info-box-content -->
			            		</div>
			            		<!-- /.info-box -->
			          		</div>

			          		<!-- /.col -->
				          	<div class="col-12 col-sm-6 col-md-4">
				            	<div class="info-box mb-3">
				              		<span class="info-box-icon bg-danger elevation-1"><i class="fas fa-rupee-sign"></i></span>
				              		<div class="info-box-content">
				                		<span class="info-box-text"><b>Paid Service Ticket</b></span>
				                		<span class="info-box-number">
				                  			<?php echo $paid_service_pending_count;?>
				                  			<small>Nos</small>
			                			</span>
				              		</div>
				              		<!-- /.info-box-content -->
				        		</div>
				            	<!-- /.info-box -->
				          	</div>
				          	<!-- /.col -->

			          		<!-- fix for small devices only -->
				          	<div class="clearfix hidden-md-up"></div>

				      		<div class="col-12 col-sm-6 col-md-4">
				        		<div class="info-box mb-3">
				          			<span class="info-box-icon bg-success elevation-1"><i class="fas fa-user-cog"></i></span>

				          			<div class="info-box-content">
				            			<span class="info-box-text"><b>Technical Service Ticket</b></span>
				            			<span class="info-box-number">
				                  			<?php echo $technical_support_pending_count;?>
				                  			<small>Nos</small>
			                			</span>
				         	 		</div>
				          			<!-- /.info-box-content -->
				        		</div>
				        		<!-- /.info-box -->
				      		</div>
			          		<!-- /.col -->

				          	<!-- <div class="col-12 col-sm-6 col-md-4">
				            	<div class="info-box mb-3">
				              		<span class="info-box-icon bg-warning elevation-1"><i class="fas fa-home"></i></span>
				              		<div class="info-box-content">
				                		<span class="info-box-text"><b>Inhouse Ticket</b></span>
				                		<span class="info-box-number">
				                  			<?php echo $inhouse_pending_query_count;?>
				                  			<small>Nos</small>
			                			</span>
				              		</div>
				        		</div>
				          	</div> -->
			        	</div>
			        	<center>
					    	<h3>Internal Assesment</h3>
					    </center>
			        	<div class="row">
			          		<div class="col-12 col-sm-6 col-md-3">
			          		</div>

				          	<div class="col-12 col-sm-6 col-md-3">
				            	<div class="info-box mb-3">
				              		<span class="info-box-icon bg-danger elevation-1"><i class="fas fa-dolly"></i></span>
				              		<div class="info-box-content">
				                		<span class="info-box-text"><b>Pre Dispatch</b></span>
				                		<span class="info-box-number">
				                  			<?php echo $predispatch_master_count;?>
				                  			<small>Nos</small>
			                			</span>
				              		</div>
				        		</div>
				          	</div>

				      		<div class="col-12 col-sm-6 col-md-3">
				        		<div class="info-box mb-3">
				          			<span class="info-box-icon bg-success elevation-1"><i class="fas fa-dot-circle"></i></span>

				          			<div class="info-box-content">
				            			<span class="info-box-text"><b>Demo Test</b></span>
				            			<span class="info-box-number">
				                  			<?php echo $demo_test_master_count;?>
				                  			<small>Nos</small>
			                			</span>
				         	 		</div>
				        		</div>
				      		</div>
			        	</div>

			        	<div class="row">
				          	<div class="col-md-12">
				            	<div class="card">
				              		<div class="card-header">
				                		<h5 class="card-title">Monthly Recap Report</h5>
				                		<div class="card-tools">
				                  			<button type="button" class="btn btn-tool" data-card-widget="collapse">
				                    			<i class="fas fa-minus"></i>
				                  			</button>
				                  			<button type="button" class="btn btn-tool" data-card-widget="remove">
				                    			<i class="fas fa-times"></i>
				                  			</button>
				                		</div>
				              		</div>
				              		<div class="card-body">
				                		<div class="row">
				                  			<div class="col-md-12">
				            					<?php 

										            //Current Month Start
										            $current_mon = date('m');
										            $current_month_name = date("F");
										            $current_mon_first_day = date('Y-m-01');
										            $current_mon_last_day = date("Y-m-t");
				            
										            $this->db->select('ticket_master.*');
											        $this->db->from('ticket_master');
											        $where = '(ticket_master.ticket_type = "'.'1'.'")';
											        $this->db->where($where);
											        $where1 = '(ticket_master.ticket_date >= "'.$current_mon_first_day.'" And ticket_master.ticket_date <= "'.$current_mon_last_day.'")';
										            $this->db->where($where1);
											        $warrantee_claims_current_mon_query = $this->db->get();
											        $warrantee_claims_current_mon_count = $warrantee_claims_current_mon_query->num_rows();


											        $this->db->select('ticket_master.*');
											        $this->db->from('ticket_master');
											        $where = '(ticket_master.ticket_type = "'.'2'.'")';
											        $this->db->where($where);
											        $where1 = '(ticket_master.ticket_date >= "'.$current_mon_first_day.'" And ticket_master.ticket_date <= "'.$current_mon_last_day.'")';
										            $this->db->where($where1);
											        $paid_service_current_mon_query = $this->db->get();
											        $paid_service_current_mon_count = $paid_service_current_mon_query->num_rows();

				            
											        $this->db->select('ticket_master.*');
											        $this->db->from('ticket_master');
											        $where = '(ticket_master.ticket_type = "'.'3'.'")';
											        $this->db->where($where);
											        $where1 = '(ticket_master.ticket_date >= "'.$current_mon_first_day.'" And ticket_master.ticket_date <= "'.$current_mon_last_day.'")';
										            $this->db->where($where1);
											        $technical_support_current_mon_query = $this->db->get();
											        $technical_support_current_mon_count = $technical_support_current_mon_query->num_rows();


											        $this->db->select('ticket_master.*');
											        $this->db->from('ticket_master');
											        $where = '(ticket_master.ticket_type = "'.'4'.'")';
											        $this->db->where($where);
											        $where1 = '(ticket_master.ticket_date >= "'.$current_mon_first_day.'" And ticket_master.ticket_date <= "'.$current_mon_last_day.'")';
										            $this->db->where($where1);
											        $inhouse_current_mon_query = $this->db->get();
											        $inhouse_current_mon_query_count = $inhouse_current_mon_query->num_rows();

				            						//Current Month End


										            //Last Month Start
										            $currmonthsubone = date('m', strtotime('-1 month'));
										            $subone = date("F", mktime(0, 0, 0, $currmonthsubone));

										            $firstday_subone = date('Y-m-01', strtotime('-1 month'));
										            $lastday_subone = strtotime(date("Y-m-t", strtotime($firstday_subone)));
										            $lastday_subone = date("Y-m-t",$lastday_subone);

				            						$this->db->select('ticket_master.*');
											        $this->db->from('ticket_master');
											        $where = '(ticket_master.ticket_type = "'.'1'.'")';
											        $this->db->where($where);
											        $where1 = '(ticket_master.ticket_date >= "'.$firstday_subone.'" And ticket_master.ticket_date <= "'.$lastday_subone.'")';
										            $this->db->where($where1);
											        $warrantee_claims_subone_query = $this->db->get();
											        $warrantee_claims_subone_count = $warrantee_claims_subone_query->num_rows();
				            

											        $this->db->select('ticket_master.*');
											        $this->db->from('ticket_master');
											        $where = '(ticket_master.ticket_type = "'.'2'.'")';
											        $this->db->where($where);
											        $where1 = '(ticket_master.ticket_date >= "'.$firstday_subone.'" And ticket_master.ticket_date <= "'.$lastday_subone.'")';
										            $this->db->where($where1);
											        $paid_service_subone_query = $this->db->get();
											        $paid_service_subone_count = $paid_service_subone_query->num_rows();

				           
											        $this->db->select('ticket_master.*');
											        $this->db->from('ticket_master');
											        $where = '(ticket_master.ticket_type = "'.'3'.'")';
											        $this->db->where($where);
											        $where1 = '(ticket_master.ticket_date >= "'.$firstday_subone.'" And ticket_master.ticket_date <= "'.$lastday_subone.'")';
										            $this->db->where($where1);
											        $technical_support_subone_query = $this->db->get();
											        $technical_support_subone_count = $technical_support_subone_query->num_rows();


										            $this->db->select('ticket_master.*');
											        $this->db->from('ticket_master');
											        $where = '(ticket_master.ticket_type = "'.'4'.'")';
											        $this->db->where($where);
											        $where1 = '(ticket_master.ticket_date >= "'.$firstday_subone.'" And ticket_master.ticket_date <= "'.$lastday_subone.'")';
										            $this->db->where($where1);
											        $inhouse_subone_query = $this->db->get();
											        $inhouse_subone_query_count = $inhouse_subone_query->num_rows();

										            //Last Month End
				            

										            //SecondLast Month Start
										            $currmonthsubtwo = date('m', strtotime('-2 month'));
										            $subtwo = date("F", mktime(0, 0, 0, $currmonthsubtwo));
										            $firstday_subtwo = date('Y-m-01', strtotime('-2 month'));
										            $lastday_subtwo = strtotime(date("Y-m-t", strtotime($firstday_subtwo)));
										            $lastday_subtwo = date("Y-m-t",$lastday_subtwo);
				          

										            $this->db->select('ticket_master.*');
											        $this->db->from('ticket_master');
											        $where = '(ticket_master.ticket_type = "'.'1'.'")';
											        $this->db->where($where);
											        $where1 = '(ticket_master.ticket_date >= "'.$firstday_subtwo.'" And ticket_master.ticket_date <= "'.$lastday_subtwo.'")';
										            $this->db->where($where1);
											        $warrantee_claims_subtwo_query = $this->db->get();
											        $warrantee_claims_subtwo_count = $warrantee_claims_subtwo_query->num_rows();
				            
				            							
				            						$this->db->select('ticket_master.*');
											        $this->db->from('ticket_master');
											        $where = '(ticket_master.ticket_type = "'.'2'.'")';
											        $this->db->where($where);
											        $where1 = '(ticket_master.ticket_date >= "'.$firstday_subtwo.'" And ticket_master.ticket_date <= "'.$lastday_subtwo.'")';
										            $this->db->where($where1);
											        $paid_service_subtwo_query = $this->db->get();
											        $paid_service_subtwo_count = $paid_service_subtwo_query->num_rows();

				            

											        $this->db->select('ticket_master.*');
											        $this->db->from('ticket_master');
											        $where = '(ticket_master.ticket_type = "'.'3'.'")';
											        $this->db->where($where);
											        $where1 = '(ticket_master.ticket_date >= "'.$firstday_subtwo.'" And ticket_master.ticket_date <= "'.$lastday_subtwo.'")';
										            $this->db->where($where1);
											        $technical_support_subtwo_query = $this->db->get();
											        $technical_support_subtwo_count = $technical_support_subtwo_query->num_rows();


										            $this->db->select('ticket_master.*');
											        $this->db->from('ticket_master');
											        $where = '(ticket_master.ticket_type = "'.'4'.'")';
											        $this->db->where($where);
											        $where1 = '(ticket_master.ticket_date >= "'.$firstday_subtwo.'" And ticket_master.ticket_date <= "'.$lastday_subtwo.'")';
										            $this->db->where($where1);
											        $inhouse_subtwo_query = $this->db->get();
											        $inhouse_subtwo_query_count = $inhouse_subtwo_query->num_rows();

				            						//SecondLast Month End


										            //ThirdLast Month Start
										            $currmonthsubthree = date('m', strtotime('-3 month'));
										            $subthree = date("F", mktime(0, 0, 0, $currmonthsubthree));
										            $firstday_subthree = date('Y-m-01', strtotime('-3 month'));
										            $lastday_subthree = strtotime(date("Y-m-t", strtotime($firstday_subthree)));
										            $lastday_subthree = date("Y-m-t",$lastday_subthree);


										            $this->db->select('ticket_master.*');
											        $this->db->from('ticket_master');
											        $where = '(ticket_master.ticket_type = "'.'1'.'")';
											        $this->db->where($where);
											        $where1 = '(ticket_master.ticket_date >= "'.$firstday_subthree.'" And ticket_master.ticket_date <= "'.$lastday_subthree.'")';
										            $this->db->where($where1);
											        $warrantee_claims_subthree_query = $this->db->get();
											        $warrantee_claims_subthree_count = $warrantee_claims_subthree_query->num_rows();


											        $this->db->select('ticket_master.*');
											        $this->db->from('ticket_master');
											        $where = '(ticket_master.ticket_type = "'.'2'.'")';
											        $this->db->where($where);
											        $where1 = '(ticket_master.ticket_date >= "'.$firstday_subthree.'" And ticket_master.ticket_date <= "'.$lastday_subthree.'")';
										            $this->db->where($where1);
											        $paid_service_subthree_query = $this->db->get();
											        $paid_service_subthree_count = $paid_service_subthree_query->num_rows();

										            
											        $this->db->select('ticket_master.*');
											        $this->db->from('ticket_master');
											        $where = '(ticket_master.ticket_type = "'.'3'.'")';
											        $this->db->where($where);
											        $where1 = '(ticket_master.ticket_date >= "'.$firstday_subthree.'" And ticket_master.ticket_date <= "'.$lastday_subthree.'")';
										            $this->db->where($where1);
											        $technical_support_subthree_query = $this->db->get();
											        $technical_support_subthree_count = $technical_support_subthree_query->num_rows();


											        $this->db->select('ticket_master.*');
											        $this->db->from('ticket_master');
											        $where = '(ticket_master.ticket_type = "'.'4'.'")';
											        $this->db->where($where);
											        $where1 = '(ticket_master.ticket_date >= "'.$firstday_subthree.'" And ticket_master.ticket_date <= "'.$lastday_subthree.'")';
										            $this->db->where($where1);
											        $inhouse_subthree_query = $this->db->get();
											        $inhouse_subthree_query_count = $inhouse_subthree_query->num_rows();

				            						//ThirdLast Month End


										            //FourthLast Month Start
										            $currmonthsubfour = date('m', strtotime('-4 month'));
										            $subfour = date("F", mktime(0, 0, 0, $currmonthsubfour));
										            $firstday_subfour = date('Y-m-01', strtotime('-4 month'));
										            $lastday_subfour = strtotime(date("Y-m-t", strtotime($firstday_subfour)));
										            $lastday_subfour = date("Y-m-t",$lastday_subfour);


										            $this->db->select('ticket_master.*');
											        $this->db->from('ticket_master');
											        $where = '(ticket_master.ticket_type = "'.'1'.'")';
											        $this->db->where($where);
											        $where1 = '(ticket_master.ticket_date >= "'.$firstday_subfour.'" And ticket_master.ticket_date <= "'.$lastday_subfour.'")';
										            $this->db->where($where1);
											        $warrantee_claims_subfour_query = $this->db->get();
											        $warrantee_claims_subfour_count = $warrantee_claims_subfour_query->num_rows();


											        $this->db->select('ticket_master.*');
											        $this->db->from('ticket_master');
											        $where = '(ticket_master.ticket_type = "'.'2'.'")';
											        $this->db->where($where);
											        $where1 = '(ticket_master.ticket_date >= "'.$firstday_subfour.'" And ticket_master.ticket_date <= "'.$lastday_subfour.'")';
										            $this->db->where($where1);
											        $paid_service_subfour_query = $this->db->get();
											        $paid_service_subfour_count = $paid_service_subfour_query->num_rows();
										            

											        $this->db->select('ticket_master.*');
											        $this->db->from('ticket_master');
											        $where = '(ticket_master.ticket_type = "'.'3'.'")';
											        $this->db->where($where);
											        $where1 = '(ticket_master.ticket_date >= "'.$firstday_subfour.'" And ticket_master.ticket_date <= "'.$lastday_subfour.'")';
										            $this->db->where($where1);
											        $technical_support_subfour_query = $this->db->get();
											        $technical_support_subfour_count = $technical_support_subfour_query->num_rows();


											        $this->db->select('ticket_master.*');
											        $this->db->from('ticket_master');
											        $where = '(ticket_master.ticket_type = "'.'4'.'")';
											        $this->db->where($where);
											        $where1 = '(ticket_master.ticket_date >= "'.$firstday_subfour.'" And ticket_master.ticket_date <= "'.$lastday_subfour.'")';
										            $this->db->where($where1);
											        $inhouse_subfour_query = $this->db->get();
											        $inhouse_subfour_query_count = $inhouse_subfour_query->num_rows();

										            //FourthLast Month End


										            //FifthLast Month Start

										            $currmonthsubfive = date('m', strtotime('-5 month'));
										            $subfive = date("F", mktime(0, 0, 0, $currmonthsubfive));
										            $firstday_subfive = date('Y-m-01', strtotime('-5 month'));
										            $lastday_subfive = strtotime(date("Y-m-t", strtotime($firstday_subfive)));
										            $lastday_subfive = date("Y-m-t",$lastday_subfive);


										            $this->db->select('ticket_master.*');
											        $this->db->from('ticket_master');
											        $where = '(ticket_master.ticket_type = "'.'1'.'")';
											        $this->db->where($where);
											        $where1 = '(ticket_master.ticket_date >= "'.$firstday_subfive.'" And ticket_master.ticket_date <= "'.$lastday_subfive.'")';
										            $this->db->where($where1);
											        $warrantee_claims_subfive_query = $this->db->get();
											        $warrantee_claims_subfive_count = $warrantee_claims_subfive_query->num_rows();


											        $this->db->select('ticket_master.*');
											        $this->db->from('ticket_master');
											        $where = '(ticket_master.ticket_type = "'.'2'.'")';
											        $this->db->where($where);
											        $where1 = '(ticket_master.ticket_date >= "'.$firstday_subfive.'" And ticket_master.ticket_date <= "'.$lastday_subfive.'")';
										            $this->db->where($where1);
											        $paid_service_subfive_query = $this->db->get();
											        $paid_service_subfive_count = $paid_service_subfive_query->num_rows();

										            
											        $this->db->select('ticket_master.*');
											        $this->db->from('ticket_master');
											        $where = '(ticket_master.ticket_type = "'.'3'.'")';
											        $this->db->where($where);
											        $where1 = '(ticket_master.ticket_date >= "'.$firstday_subfive.'" And ticket_master.ticket_date <= "'.$lastday_subfive.'")';
										            $this->db->where($where1);
											        $technical_support_subfive_query = $this->db->get();
											        $technical_support_subfive_count = $technical_support_subfive_query->num_rows();


											        $this->db->select('ticket_master.*');
											        $this->db->from('ticket_master');
											        $where = '(ticket_master.ticket_type = "'.'4'.'")';
											        $this->db->where($where);
											        $where1 = '(ticket_master.ticket_date >= "'.$firstday_subfive.'" And ticket_master.ticket_date <= "'.$lastday_subfive.'")';
										            $this->db->where($where1);
											        $inhouse_subfive_query = $this->db->get();
											        $inhouse_subfive_query_count = $inhouse_subfive_query->num_rows();

										            //FifthLast Month End



										            //SixthLast Month Start
										            $currmonthsubsix = date('m', strtotime('-6 month'));
										            $subsix = date("F", mktime(0, 0, 0, $currmonthsubsix));
										            $firstday_subsix = date('Y-m-01', strtotime('-6 month'));
										            $lastday_subsix = strtotime(date("Y-m-t", strtotime($firstday_subsix)));
										            $lastday_subsix = date("Y-m-t",$lastday_subsix);


										            $this->db->select('ticket_master.*');
											        $this->db->from('ticket_master');
											        $where = '(ticket_master.ticket_type = "'.'1'.'")';
											        $this->db->where($where);
											        $where1 = '(ticket_master.ticket_date >= "'.$firstday_subsix.'" And ticket_master.ticket_date <= "'.$lastday_subsix.'")';
										            $this->db->where($where1);
											        $warrantee_claims_subsix_query = $this->db->get();
											        $warrantee_claims_subsix_count = $warrantee_claims_subsix_query->num_rows();


											        $this->db->select('ticket_master.*');
											        $this->db->from('ticket_master');
											        $where = '(ticket_master.ticket_type = "'.'2'.'")';
											        $this->db->where($where);
											        $where1 = '(ticket_master.ticket_date >= "'.$firstday_subsix.'" And ticket_master.ticket_date <= "'.$lastday_subsix.'")';
										            $this->db->where($where1);
											        $paid_service_subsix_query = $this->db->get();
											        $paid_service_subsix_count = $paid_service_subsix_query->num_rows();

				            	
											        $this->db->select('ticket_master.*');
											        $this->db->from('ticket_master');
											        $where = '(ticket_master.ticket_type = "'.'3'.'")';
											        $this->db->where($where);
											        $where1 = '(ticket_master.ticket_date >= "'.$firstday_subsix.'" And ticket_master.ticket_date <= "'.$lastday_subsix.'")';
										            $this->db->where($where1);
											        $technical_support_subsix_query = $this->db->get();
											        $technical_support_subsix_count = $technical_support_subsix_query->num_rows();


											        $this->db->select('ticket_master.*');
											        $this->db->from('ticket_master');
											        $where = '(ticket_master.ticket_type = "'.'4'.'")';
											        $this->db->where($where);
											        $where1 = '(ticket_master.ticket_date >= "'.$firstday_subsix.'" And ticket_master.ticket_date <= "'.$lastday_subsix.'")';
										            $this->db->where($where1);
											        $inhouse_subsix_query = $this->db->get();
											        $inhouse_subsix_query_count = $inhouse_subsix_query->num_rows();

				            						//SixthLast Month End

				           						?>
									           	<input type="hidden" id="subone" name="subone" value="<?php echo $subone?>" required>
									           	<input type="hidden" id="subtwo" name="subtwo" value="<?php echo $subtwo?>" required>
									           	<input type="hidden" id="subthree" name="subthree" value="<?php echo $subthree?>" required>
									           	<input type="hidden" id="subfour" name="subfour" value="<?php echo $subfour?>" required>
									           	<input type="hidden" id="subfive" name="subfive" value="<?php echo $subfive?>" required>
									           	<input type="hidden" id="subsix" name="subsix" value="<?php echo $subsix?>" required>
									           	<input type="hidden" id="current_month_name" name="current_month_name" value="<?php echo $current_month_name?>" required>
				           
									           	<input type="hidden" id="warrantee_claims_current_mon_count" name="warrantee_claims_current_mon_count" value="<?php echo $warrantee_claims_current_mon_count?>" required>

									           	<input type="hidden" id="paid_service_current_mon_count" name="paid_service_current_mon_count" value="<?php echo $paid_service_current_mon_count?>" required>

									           	<input type="hidden" id="technical_support_current_mon_count" name="technical_support_current_mon_count" value="<?php echo $technical_support_current_mon_count?>" required>

									           	<input type="hidden" id="inhouse_current_mon_query_count" name="inhouse_current_mon_query_count" value="<?php echo $inhouse_current_mon_query_count?>" required>


									           	<input type="hidden" id="warrantee_claims_subone_count" name="warrantee_claims_subone_count" value="<?php echo $warrantee_claims_subone_count?>" required>

									           	<input type="hidden" id="paid_service_subone_count" name="paid_service_subone_count" value="<?php echo $paid_service_subone_count?>" required>

									           	<input type="hidden" id="technical_support_subone_count" name="technical_support_subone_count" value="<?php echo $technical_support_subone_count?>" required>

									           	<input type="hidden" id="inhouse_subone_query_count" name="inhouse_subone_query_count" value="<?php echo $inhouse_subone_query_count?>" required>


									           	<input type="hidden" id="warrantee_claims_subtwo_count" name="warrantee_claims_subtwo_count" value="<?php echo $warrantee_claims_subtwo_count?>" required>

									           	<input type="hidden" id="paid_service_subtwo_count" name="paid_service_subtwo_count" value="<?php echo $paid_service_subtwo_count?>" required>

									           	<input type="hidden" id="technical_support_subtwo_count" name="technical_support_subtwo_count" value="<?php echo $technical_support_subtwo_count?>" required>

									           	<input type="hidden" id="inhouse_subtwo_query_count" name="inhouse_subtwo_query_count" value="<?php echo $inhouse_subtwo_query_count?>" required>


									           	<input type="hidden" id="warrantee_claims_subthree_count" name="warrantee_claims_subthree_count" value="<?php echo $warrantee_claims_subthree_count?>" required>

									           	<input type="hidden" id="paid_service_subthree_count" name="paid_service_subthree_count" value="<?php echo $paid_service_subthree_count?>" required>

									           	<input type="hidden" id="technical_support_subthree_count" name="technical_support_subthree_count" value="<?php echo $technical_support_subthree_count?>" required>

									           	<input type="hidden" id="inhouse_subthree_query_count" name="inhouse_subthree_query_count" value="<?php echo $inhouse_subthree_query_count?>" required>


									           	<input type="hidden" id="warrantee_claims_subfour_count" name="warrantee_claims_subfour_count" value="<?php echo $warrantee_claims_subfour_count?>" required>

									           	<input type="hidden" id="paid_service_subfour_count" name="paid_service_subfour_count" value="<?php echo $paid_service_subfour_count?>" required>

									           	<input type="hidden" id="technical_support_subfour_count" name="technical_support_subfour_count" value="<?php echo $technical_support_subfour_count?>" required>

									           	<input type="hidden" id="inhouse_subfour_query_count" name="inhouse_subfour_query_count" value="<?php echo $inhouse_subfour_query_count?>" required>


									           	<input type="hidden" id="warrantee_claims_subfive_count" name="warrantee_claims_subfive_count" value="<?php echo $warrantee_claims_subfive_count?>" required>

									           	<input type="hidden" id="paid_service_subfive_count" name="paid_service_subfive_count" value="<?php echo $paid_service_subfive_count?>" required>

									           	<input type="hidden" id="technical_support_subfive_count" name="technical_support_subfive_count" value="<?php echo $technical_support_subfive_count?>" required>

									           	<input type="hidden" id="inhouse_subfive_query_count" name="inhouse_subfive_query_count" value="<?php echo $inhouse_subfive_query_count?>" required>


									           	<input type="hidden" id="warrantee_claims_subsix_count" name="warrantee_claims_subsix_count" value="<?php echo $warrantee_claims_subsix_count?>" required>

									           	<input type="hidden" id="paid_service_subsix_count" name="paid_service_subsix_count" value="<?php echo $paid_service_subsix_count?>" required>

									           	<input type="hidden" id="technical_support_subsix_count" name="technical_support_subsix_count" value="<?php echo $technical_support_subsix_count?>" required>

									           	<input type="hidden" id="inhouse_subsix_query_count" name="inhouse_subsix_query_count" value="<?php echo $inhouse_subsix_query_count?>" required>

				            					<!-- BAR CHART -->
									            <div class="card card-success">
									              	<div class="card-header">
									                	<h3 class="card-title">Bar Chart</h3>
									                	<div class="card-tools">
									                  		<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
									                  		</button>
									                  		<button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
									                	</div>
									              	</div>
									              	<div class="card-body">
									                	<div class="chart">
									                  		<canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
									                	</div>
									              	</div>
									            </div>
				          					</div>
				                		</div>
				              		</div> 
				            	</div>
				          	</div>
				        </div>
				    </div>
				</section>
				<section class="content" style="display: none;">
			      	<div class="container-fluid">
			        	<div class="row">
			          		<div class="col-md-6">
			            		<!-- AREA CHART -->
			            		<div class="card card-primary">
			              			<div class="card-header">
			                			<h3 class="card-title">Area Chart</h3>
			                			<div class="card-tools">
			                  				<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
			                  				</button>
			                  				<button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
			                			</div>
			              			</div>
			              			<div class="card-body">
			                			<div class="chart">
			                  				<canvas id="areaChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
			                			</div>
			              			</div>
			            		</div>
			          		</div>
			          		<div class="col-md-6">
			            		<div class="card card-info">
			              			<div class="card-header">
			                			<h3 class="card-title">Line Chart</h3>
			               				<div class="card-tools">
			                  				<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
			                  				</button>
			                  				<button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
			                			</div>
			              			</div>
			              			<div class="card-body">
			                			<div class="chart">
			                  				<canvas id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
			                			</div>
			              			</div>
			            		</div>
			          		</div>
			        	</div>
			      	</div>
			    </section>
    		</div>
			<?php $this->load->view('footer');?>
				<!-- Control Sidebar -->
			<aside class="control-sidebar control-sidebar-dark">
			<!-- Control sidebar content goes here -->
			</aside>
			<!-- /.control-sidebar -->
		</div>

		<!-- jQuery -->
		<script src="<?php echo base_url().'assets/plugins/jquery/jquery.min.js'?>"></script>
		<!-- jQuery UI 1.11.4 -->
		<script src="<?php echo base_url().'assets/plugins/jquery-ui/jquery-ui.min.js'?>"></script>
		<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
		<!-- Bootstrap 4 -->
		<script src="<?php echo base_url().'assets/plugins/bootstrap/js/bootstrap.bundle.min.js'?>"></script>
		<!-- ChartJS -->
		<script src="<?php echo base_url().'assets/plugins/chart.js/Chart.min.js'?>"></script>
		<!-- Sparkline -->
		<script src="<?php echo base_url().'assets/plugins/sparklines/sparkline.js'?>"></script>
		<!-- JQVMap -->
		<script src="<?php echo base_url().'assets/plugins/jqvmap/jquery.vmap.min.js'?>"></script>
		<script src="<?php echo base_url().'assets/plugins/jqvmap/maps/jquery.vmap.usa.js'?>"></script>
		<!-- jQuery Knob Chart -->
		<script src="<?php echo base_url().'assets/plugins/jquery-knob/jquery.knob.min.js'?>"></script>
		<!-- daterangepicker -->
		<script src="<?php echo base_url().'assets/plugins/moment/moment.min.js'?>"></script>
		<script src="<?php echo base_url().'assets/plugins/daterangepicker/daterangepicker.js'?>"></script>
		<!-- Tempusdominus Bootstrap 4 -->
		<script src="<?php echo base_url().'assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js'?>"></script>
		<!-- Summernote -->
		<script src="<?php echo base_url().'assets/plugins/summernote/summernote-bs4.min.js'?>"></script>
		<!-- overlayScrollbars -->
		<script src="<?php echo base_url().'assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js'?>"></script>
		<!-- AdminLTE App -->
		<script src="<?php echo base_url().'assets/dist/js/adminlte.js'?>"></script>
		<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
		<!-- <script src="assets/dist/js/pages/dashboard.js'?>"></script> -->

		
		<!-- AdminLTE for demo purposes -->
		<script src="<?php echo base_url().'assets/dist/js/demo.js'?>"></script>

		<script>
  			$(function () {
    			// Get context with jQuery - using jQuery's .get() method.
			   	
			    var subone = document.getElementById('subone').value;
			    var subtwo = document.getElementById('subtwo').value;
			    var subthree = document.getElementById('subthree').value;
			    var subfour = document.getElementById('subfour').value;
			    var subfive = document.getElementById('subfive').value;
			    var subsix = document.getElementById('subsix').value;
			    var current_month_name = document.getElementById('current_month_name').value;

			    var warrantee_claims_current_mon_count = document.getElementById('warrantee_claims_current_mon_count').value;
			    var paid_service_current_mon_count = document.getElementById('paid_service_current_mon_count').value;
			    var technical_support_current_mon_count = document.getElementById('technical_support_current_mon_count').value;
			    var inhouse_current_mon_query_count = document.getElementById('inhouse_current_mon_query_count').value;

			    var warrantee_claims_subone_count = document.getElementById('warrantee_claims_subone_count').value;
			    var paid_service_subone_count = document.getElementById('paid_service_subone_count').value;
			    var technical_support_subone_count = document.getElementById('technical_support_subone_count').value;
			    var inhouse_subone_query_count = document.getElementById('inhouse_subone_query_count').value;


			    var warrantee_claims_subtwo_count = document.getElementById('warrantee_claims_subtwo_count').value;
			    var paid_service_subtwo_count = document.getElementById('paid_service_subtwo_count').value;
			    var technical_support_subtwo_count = document.getElementById('technical_support_subtwo_count').value;
			    var inhouse_subtwo_query_count = document.getElementById('inhouse_subtwo_query_count').value;


			    var warrantee_claims_subthree_count = document.getElementById('warrantee_claims_subthree_count').value;
			    var paid_service_subthree_count = document.getElementById('paid_service_subthree_count').value;
			    var technical_support_subthree_count = document.getElementById('technical_support_subthree_count').value;
			    var inhouse_subthree_query_count = document.getElementById('inhouse_subthree_query_count').value;


			    var warrantee_claims_subfour_count = document.getElementById('warrantee_claims_subfour_count').value;
			    var paid_service_subfour_count = document.getElementById('paid_service_subfour_count').value;
			    var technical_support_subfour_count = document.getElementById('technical_support_subfour_count').value;
			    var inhouse_subfour_query_count = document.getElementById('inhouse_subfour_query_count').value;


			    var warrantee_claims_subfive_count = document.getElementById('warrantee_claims_subfive_count').value;
			    var paid_service_subfive_count = document.getElementById('paid_service_subfive_count').value;
			    var technical_support_subfive_count = document.getElementById('technical_support_subfive_count').value;
			    var inhouse_subfive_query_count = document.getElementById('inhouse_subfive_query_count').value;


			    var warrantee_claims_subsix_count = document.getElementById('warrantee_claims_subsix_count').value;
			    var paid_service_subsix_count = document.getElementById('paid_service_subsix_count').value;
			    var technical_support_subsix_count = document.getElementById('technical_support_subsix_count').value;
			    var inhouse_subsix_query_count = document.getElementById('inhouse_subsix_query_count').value;

    			var areaChartData = {
      				labels  : [current_month_name, subone, subtwo, subthree, subfour, subfive, subsix],
			      	datasets: [
			        	{
			          		label               : 'Paid Service',
			          		backgroundColor     : 'rgba(60,141,188,0.9)',
			          		borderColor         : 'rgba(60,141,188,0.8)',
			          		pointRadius          : false,
			          		pointColor          : '#3b8bba',
			          		pointStrokeColor    : 'rgba(60,141,188,1)',
			          		pointHighlightFill  : '#fff',
			          		pointHighlightStroke: 'rgba(60,141,188,1)',
			          		data                : [paid_service_current_mon_count, paid_service_subone_count, paid_service_subtwo_count, paid_service_subthree_count, paid_service_subfour_count, paid_service_subfive_count, paid_service_subsix_count]

			        	},
				        {
				          	label               : 'Warrantee Claims',
				          	backgroundColor     : 'rgba(210, 214, 222, 1)',
				          	borderColor         : 'rgba(210, 214, 222, 1)',
				          	pointRadius         : false,
				          	pointColor          : 'rgba(210, 214, 222, 1)',
				          	pointStrokeColor    : '#c1c7d1',
				          	pointHighlightFill  : '#fff',
				          	pointHighlightStroke: 'rgba(220,220,220,1)',
				          	data                : [warrantee_claims_current_mon_count , warrantee_claims_subone_count, warrantee_claims_subtwo_count, warrantee_claims_subthree_count, warrantee_claims_subfour_count, warrantee_claims_subfive_count, warrantee_claims_subsix_count]
				        },
				        {
				          	label               : 'Technical Support',
				          	backgroundColor     : 'rgba(128,0,0)',
				          	borderColor         : 'rgba(210, 214, 222, 1)',
				          	pointRadius         : false,
				          	pointColor          : 'rgba(210, 214, 222, 1)',
				          	pointStrokeColor    : '#c1c7d1',
				          	pointHighlightFill  : '#fff',
				          	pointHighlightStroke: 'rgba(220,220,220,1)',
				          	data                : [technical_support_current_mon_count, technical_support_subone_count, technical_support_subtwo_count, technical_support_subthree_count, technical_support_subfour_count, technical_support_subfive_count, technical_support_subsix_count]
				        },
				        /*{
				          	label               : 'Inhouse',
				          	backgroundColor     : 'rgba(42, 187, 155, 1)',
				          	borderColor         : 'rgba(210, 214, 222, 1)',
				          	pointRadius         : false,
				          	pointColor          : 'rgba(210, 214, 222, 1)',
				          	pointStrokeColor    : '#c1c7d1',
				          	pointHighlightFill  : '#fff',
				          	pointHighlightStroke: 'rgba(220,220,220,1)',
				          	data                : [inhouse_subtwo_query_count, inhouse_subthree_query_count, inhouse_subfour_query_count, inhouse_subfive_query_count, inhouse_subsix_query_count, inhouse_subone_query_count, inhouse_current_mon_query_count]
				        },*/
      				]
    			}

			    var areaChartOptions = {
			      	maintainAspectRatio : false,
			      	responsive : true,
			      	legend: {
			        	display: false
			      	},
			      	scales: {
			        	xAxes: [{
			          		gridLines : {
			            	display : false,
			          		}
			        	}],
				        yAxes: [{
				         	gridLines : {
				            	display : false,
				          	}
				        }]
			      	}
			    }

			    //-------------
			    //- LINE CHART -
			    //--------------

			    var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
			    var lineChartOptions = jQuery.extend(true, {}, areaChartOptions)
			    var lineChartData = jQuery.extend(true, {}, areaChartData)
			    lineChartData.datasets[0].fill = false;
			    lineChartData.datasets[1].fill = false;
			    lineChartOptions.datasetFill = false

			    var lineChart = new Chart(lineChartCanvas, { 
			     	 type: 'line',
			      	data: lineChartData, 
			      	options: lineChartOptions
			    })


			    //-------------
			    //- BAR CHART -
			    //-------------
			    var barChartCanvas = $('#barChart').get(0).getContext('2d')
			    var barChartData = jQuery.extend(true, {}, areaChartData)
			    var temp0 = areaChartData.datasets[0]
			    var temp1 = areaChartData.datasets[1]
			    barChartData.datasets[0] = temp1
			    barChartData.datasets[1] = temp0

			    var barChartOptions = {
			      	responsive              : true,
			      	maintainAspectRatio     : false,
			      	datasetFill             : false
			    }

			    var barChart = new Chart(barChartCanvas, {
			      	type: 'bar', 
			      	data: barChartData,
			      	options: barChartOptions
			    })
  			})
		</script>

	</body>
</html>
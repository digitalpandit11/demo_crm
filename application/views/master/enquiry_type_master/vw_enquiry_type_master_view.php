<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
if(!$_SESSION['user_name'])
{
  $data = site_url('dashboard');
  header("location:$data");
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	  	<title>View Lead Type</title>
	  	<meta name="viewport" content="width=device-width, initial-scale=1">
	  	<link rel="stylesheet" href="<?php echo base_url().'assets/plugins/fontawesome-free/css/all.min.css'?>">
	  	<link rel="stylesheet" href="<?php echo base_url().'assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css'?>">
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
	  	<link rel="stylesheet" href="<?php echo base_url().'assets/plugins/select2/css/select2.min.css'?>">
	  	<link rel="stylesheet" href="<?php echo base_url().'assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css'?>">

	  	<!-- Daterange picker -->
	  	<link rel="stylesheet" href="<?php echo base_url().'assets/plugins/daterangepicker/daterangepicker.css'?>">
	  	<!-- summernote -->
	  	<link rel="stylesheet" href="<?php echo base_url().'assets/plugins/summernote/summernote-bs4.css'?>">
	  	<!-- Google Font: Source Sans Pro -->
	  	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	  	<link rel="icon" href="<?php echo base_url().'assets/company_logo/construction.jpg'?>" type="image/ico" />
	</head>
	<body class="hold-transition sidebar-mini">
  		<div class="wrapper">
    		<?php $this->load->view('header_sidebar');?> 
			    <div class="content-wrapper">
			      	<section class="content-header">
			        	<div class="container-fluid">
			          		<br>
			          		<div class="card">
			            		<div class="card-header" >
			              			<h1 class="card-title">View Lead Type</h1>
			              			<div class="col-sm-6">
			                		<br><br>
			                			<ol class="breadcrumb">
			                  				<li class="breadcrumb-item"><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
			                  				<li class="breadcrumb-item"><a href="<?php echo base_url().'vw_enquiry_type_master'?>">Lead Type</a></li>
			                  				<li class="breadcrumb-item">View Lead Type :- <?php echo $entity_id; ?></li>
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
				              		<div class="card card-primary">
				                		<div class="card-header">
				                  			<h3 class="card-title">Lead Type Details</h3>
				                		</div>
				                		<div class="card-body" style="border-radius: 1.25rem;">
				                  			<form role="form" name="vendor_type_form" id="vendor_type_form" action="<?php echo site_url('master/enquiry_type_master/view_enquiry_type');?>" method="post">

				                  				<input type="hidden" id="entity_id" name="entity_id" value="<?php echo $entity_id?>" required>
				                  				
				                    			<div class="row">
				                      				<div class="col-sm-6">
				                        				<div class="form-group">
				                          					<label style="color: #FF0000;">Lead Type * </label>
				                          					<input type="text" class="form-control" name="enquiry_type" id="enquiry_type" placeholder="Enter Lead Type" value="<?php echo $enquiry_type;?>" disabled>
				                        				</div>
				                      				</div>      
							                    </div>
				                  			</form>
				                		</div>
				              		</div>
				            	</div>
				          	</div>
				        </div>
      				</section>
    			</div>
    		<?php $this->load->view('footer');?>
    		<aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
        </div>
    		<!-- ./wrapper -->
	    <script src="<?php echo base_url().'assets/plugins/jquery/jquery.min.js'?>"></script>
	    <!-- Bootstrap 4 -->
	    <script src="<?php echo base_url().'assets/plugins/bootstrap/js/bootstrap.bundle.min.js'?>"></script>
	    <!-- Select2 -->
	    <script src="<?php echo base_url().'assets/plugins/select2/js/select2.full.min.js'?>"></script>
	    <!-- Bootstrap4 Duallistbox -->
	    <script src="<?php echo base_url().'assets/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js'?>"></script>
	    <!-- InputMask -->
	    <script src="<?php echo base_url().'assets/plugins/moment/moment.min.js'?>"></script>
	    <script src="<?php echo base_url().'assets/plugins/inputmask/min/jquery.inputmask.bundle.min.js'?>"></script>
	    <!-- date-range-picker -->
	    <script src="<?php echo base_url().'assets/plugins/daterangepicker/daterangepicker.js'?>"></script>
	    <!-- bootstrap color picker -->
	    <script src="<?php echo base_url().'assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js'?>"></script>
	    <!-- Tempusdominus Bootstrap 4 -->
	    <script src="<?php echo base_url().'assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js'?>"></script>
	    <!-- Bootstrap Switch -->
	    <script src="<?php echo base_url().'assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js'?>"></script>
	    <!-- AdminLTE App -->
	    <script src="<?php echo base_url().'assets/dist/js/adminlte.min.js'?>"></script>
	    <!-- AdminLTE for demo purposes -->
	    <script src="<?php echo base_url().'assets/dist/js/demo.js'?>"></script>
	    <!-- DataTables -->
	    <script src="<?php echo base_url().'assets/plugins/datatables/jquery.dataTables.js'?>"></script>
	    <script src="<?php echo base_url().'assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js'?>"></script>
	    <!-- Page script -->
	    <script>
	      $(function () {
				//Initialize Select2 Elements
				$('.select2').select2()

				//Initialize Select2 Elements
				$('.select2bs4').select2({
				  theme: 'bootstrap4'
				})

				//Datemask dd/mm/yyyy
				$('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
				//Datemask2 mm/dd/yyyy
				$('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
				//Money Euro
				$('[data-mask]').inputmask()

				//Date range picker
				$('#reservation').daterangepicker()
				//Date range picker with time picker
				$('#reservationtime').daterangepicker({
				  timePicker: true,
				  timePickerIncrement: 30,
				  locale: {
				    format: 'MM/DD/YYYY hh:mm A'
				  }
				})
				//Date range as a button
				$('#daterange-btn').daterangepicker(
				{
				  ranges   : {
				    'Today'       : [moment(), moment()],
				    'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
				    'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
				    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
				    'This Month'  : [moment().startOf('month'), moment().endOf('month')],
				    'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
				  },
				  startDate: moment().subtract(29, 'days'),
				  endDate  : moment()
				},
				function (start, end) {
				  $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
				}
				)

				//Timepicker
				$('#timepicker').datetimepicker({
				  format: 'LT'
				})

				//Bootstrap Duallistbox
				$('.duallistbox').bootstrapDualListbox()

				//Colorpicker
				$('.my-colorpicker1').colorpicker()
				//color picker with addon
				$('.my-colorpicker2').colorpicker()

				$('.my-colorpicker2').on('colorpickerChange', function(event) {
				  $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
				});

				$("input[data-bootstrap-switch]").each(function(){
				  $(this).bootstrapSwitch('state', $(this).prop('checked'));
				});
			})
		</script>
	</body>
</html>
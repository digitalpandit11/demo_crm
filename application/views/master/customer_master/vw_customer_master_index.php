<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
if (!$_SESSION['user_name']) {
	$data = site_url('dashboard');
	header("location:$data");
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Customer Master</title>
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
	<link rel="icon" href="<?php echo base_url() . 'assets/company_logo/QFS_Logo.png' ?>" type="image/ico" />
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
							<h1 class="card-title">Customer Master</h1>
							<div class="col-sm-6">
								<br><br>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo base_url() . 'dashboard' ?>">Home</a></li>
									<li class="breadcrumb-item"><a href="<?php echo base_url() . 'vw_erp_product_vw_customer_master' ?>">Customer Master</a>
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
							<!-- general form elements disabled -->
							<div class="card card-primary">
								<div class="card-header">
									<h3 class="card-title">Customer Master</h3>
								</div>
								<div>
									<div class="btn-group" style="margin-top: 15px; margin-left: 15px;">
										<a href="create_customer_master" class="btn btn-block btn-primary">
											Create Customer
										</a>
									</div>
									<div class="btn-group" style="margin-top: 15px; margin-left: 15px;">
										<a href="vw_erp_product_vw_customer_master_all_details" class="btn btn-block btn-primary">
											Contact View
										</a>
									</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="example1" class="table table-bordered table-striped">
											<thead>
												<tr>
													<th>Sr. No.</th>
													<th>Action</th>
													<th>Customer Name</th>
													<th>Customer Type</th>
													<th>Address</th>
													<th>GST Number</th>
													<th>Date Entered</th>
													<th>Source</th>
													<th>Status</th>
												</tr>
											</thead>
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
	<!-- Page script -->
	<script>
$(document).ready(function() {
    var table = $('#example1').DataTable({
        "searching": true,
        "processing": true,
        "serverSide": true,
        "ajax": "<?php echo base_url() . 'get_ajax_customer_data' ?>",
        "rowCallback": function(nRow, aData, iDisplayIndex) {
            var oSettings = this.fnSettings();
            $("td:first", nRow).html(oSettings._iDisplayStart + iDisplayIndex + 1);
            return nRow;
        }, // for adding serial no
        "json": true, // Disable JSON format checking
        "columnDefs": [
            {
                "targets": 3, // Index of the "customer_type" column
                "render": function(data, type, row) {
                    // Decode and display the customer type
                    var decodedType = decodeCustomerType(data);
                    return decodedType;
                }
            },
            {
                "targets": 8, // Index of the "status" column
                "render": function(data, type, row) {
                    // Decode and display the status
                    var decodedStatus = decodeStatus(data);
                    return decodedStatus;
                }
            }
        ]
    });

    // Custom function to decode customer_type values
    function decodeCustomerType(data) {
        // Define the decoding logic here
        if (data == 1) {
            return "Dealer";
        } else if (data == 2) {
            return "End User";
        } else if (data == 3) {
            return "OEM";
        } else if (data == 4) {
            return "Trader";
        } else if (data == 5) {
            return "System Integrator";
        } else {
            return "NA";
        }
    }

    // Custom function to decode status values
    function decodeStatus(data) {
        // Define the decoding logic here
        if (data == 1) {
            return "Active";
        } else if (data == 2) {
            return "In-Active";
        } else {
            return "NA";
        }
    }

    // Add custom filter inputs for customer type and status
    // $('#example1_filter').append('<label>Customer Type: <select id="customer-type-filter"><option value="">All</option><option value="1">Dealer</option><option value="2">End User</option><option value="3">OEM</option><option value="4">Trader</option><option value="5">System Integrator</option></select></label>');
    // $('#example1_filter').append('<label>Status: <select id="status-filter"><option value="">All</option><option value="1">Active</option><option value="2">In-Active</option></select></label>');

    // Apply the custom filters when the select inputs change
    $('#customer-type-filter, #status-filter').on('change', function() {
        var customerTypeValue = $('#customer-type-filter').val();
        var statusValue = $('#status-filter').val();

        table.column(3).search(customerTypeValue);
        table.column(8).search(statusValue);
        table.draw();
    });
});


</script>

</body>

</html>

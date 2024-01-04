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
	  	<title>Select Enquiry And Vender</title>
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
			              			<h1 class="card-title">Select Enquiry And Vender For RFQ</h1>
			              			<div class="col-sm-6">
			                		<br><br>
			                			<ol class="breadcrumb">
			                  				<li class="breadcrumb-item"><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
			                  				<li class="breadcrumb-item"><a href="<?php echo base_url().'rfq_index'?>">RFQ Index</a></li>
			                  				<li class="breadcrumb-item">Select Enquiry And Vender For RFQ </li>
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
				                  			<h3 class="card-title">RFQ Details </h3>
				                		</div>
				                		<div class="card-body" style="border-radius: 1.25rem;">
				                  			<form role="form" name="tracking_datail_form" id="tracking_datail_form" action="<?php echo site_url('support/rfq_register/save_rfq');?>" method="post">

				                    			<div class="row">
				                      				<div class="col-sm-5">
                                                        <div class="form-group">
                                                            <label> <span style="color: #FF0000;"> Enquiry Number * </span></label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="enquiry_id" name="enquiry_id" required>
                                                                <option value="">No Selected</option>
                                                                <?php foreach($enquiry_details as $row):?>
                                                                <option value="<?php echo $row->entity_id;?>"><?php echo $row->enquiry_no;?></option>
                                                                <?php endforeach;?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                   	
                                                   	<div class="col-sm-5">
                                                        <div class="form-group">
                                                            <label> <span style="color: #FF0000;"> Vender Name * </span></label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="vender_id" name="vender_id" required>
                                                                <option value="">No Selected</option>
                                                                <?php foreach($vender_details as $row):?>
                                                                <option value="<?php echo $row->entity_id;?>"><?php echo $row->vendor_name;?></option>
                                                                <?php endforeach;?>
                                                            </select>
                                                        </div>
                                                    </div> 

                                                    <div class="col-sm-2">
                                                        <div>
                                                            <div style="margin-top: 30px;">
                                                                <button type="button" class="btn btn-block btn-success" data-toggle="modal" data-target="#modal-lg-vender">
                                                                  Add Vender
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div> 
							                    </div>
							                    <div class="card-body">
							                        <center>
							                            <button type="button" class="btn btn-success toastrDefaultSuccess" data-toggle="modal" data-target="#modal-sm">
                                                            Save
                                                        </button>
							                        </center>
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
    	<div class="modal fade" id="modal-sm">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Confirm RFQ</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Do You Want To Confirm Created RFQ? </p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        <button type="submit" name="craete_rfq" id="craete_rfq" class="btn btn-primary">Yes</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-lg-vender">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Vender</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" name="vendor_datail_form" id="vendor_datail_form">
                			<div class="row">
                  				<div class="col-sm-6">
                    				<div class="form-group">
                      					<label style="color: #FF0000;">Vender Name * </label>
                      					<input type="text" class="form-control" name="pop_up_vendor_name" id="pop_up_vendor_name" placeholder="Enter Vender Name" required="required">
                    				</div>
                  				</div>

		                      	<div class="col-sm-6">
		                        	<div class="form-group">
		                          		<label>GST Number </label>
		                          		<input type="text" class="form-control" name="pop_up_gst_no" id="pop_up_gst_no" placeholder="Enter GST Number">
		                    		</div>
		                      	</div>        
		                    </div>

		                    <div class="row">
		                      	<div class="col-sm-4">
		                        	<div class="form-group">
		                          		<label style="color: #FF0000;">Phone Number *</label>
		                          		<input type="text" class="form-control" name="pop_up_phone_no" id="pop_up_phone_no" placeholder="Enter Phone Number" required="required">
		                        	</div>
		                      	</div>

		                      	<div class="col-sm-4">
		                        	<div class="form-group">
		                          		<label style="color: #FF0000;">Contact Person *</label>
		                          		<input type="text" class="form-control" name="pop_up_contact_person" id="pop_up_contact_person" placeholder="Enter Contact Person Name" required="required">
		                        	</div>
		                      	</div>

		                      	<div class="col-sm-4">
		                        	<div class="form-group">
		                          		<label>Mobile Number </label>
		                          		<input type="text" class="form-control" name="pop_up_mobile_number" id="pop_up_mobile_number" placeholder="Enter Mobile Number">
		                        	</div>
		                      	</div>
		                    </div>

		                    <div class="row">
		                      	<div class="col-sm-4">
		                        	<div class="form-group">
		                          		<label style="color: #FF0000;">State Name * </label>
		                          		<select class="form-control select2bs4" style="width: 100%;" id="pop_up_state_id" name="pop_up_state_id" required>
		                            		<option value="">Select State</option>
		                            		<?php foreach($state_list as $row):?>
		                              		<option value="<?php echo $row->entity_id;?>"><?php echo $row->state_name;?></option>
		                            		<?php endforeach;?>
		                          		</select>
		                        	</div>
		                      	</div>

		                      	<div class="col-sm-4">
		                        	<div class="form-group">
		                         	 	<label style="color: #FF0000;">City Name * </label>
		                      			<select class="form-control select2bs4" style="width: 100%;" id="pop_up_city_id" name="pop_up_city_id" required>
		                            		<option value="">Select City</option>
		                          		</select>
		                        	</div>
		                      	</div> 

		                      	<div class="col-sm-4">
		                        	<div class="form-group">
		                          		<label style="color: #FF0000;">Address * </label>
		                          		<textarea class="form-control" rows="3" name="pop_up_address" id="pop_up_address" placeholder="Please Enter Address" required></textarea>
		                        	</div>
		                      	</div>
		                    </div>

		                    <div class="row">
		                      	<div class="col-sm-6">
		                        	<div class="form-group">
		                          		<label style="color: #FF0000;">State Code * </label>
		                          		<input type="text" class="form-control" readonly name="pop_up_state_code" id="pop_up_state_code" placeholder="Enter State Code" required>
		                        	</div>
		                      	</div> 

		                      	<div class="col-sm-6">
		                        	<div class="form-group">
		                          		<label style="color: #FF0000;">Pincode *</label>
		                          		<input type="text" class="form-control" name="pop_up_pincode" id="pop_up_pincode" placeholder="Enter Pincode" required>
		                        	</div>
		                      	</div> 
		                    </div>

		                    <div class="row">
		                      	<div class="col-sm-6">
		                        	<div class="form-group">
		                          		<label style="color: #FF0000;" >Email / Username *</label>
		                          		<input type="email" class="form-control" name="pop_up_email_id" id="pop_up_email_id" placeholder="Enter Email Address As Username">
		                        	</div>
		                      	</div>

		                      	<div class="col-sm-6">
                                    <div class="form-group">
                                        <label style="color: #FF0000;" >Password *</label>
                                        <input type="checkbox" onclick="myPassword()">Show Password
                                        <input type="password" class="form-control" name="pop_up_user_password" id="pop_up_user_password" placeholder="Enter Password" required="required">
                                    </div>
                                </div>
		                    </div>
              			</form>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="save_supplier" id="save_supplier" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
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
	    <script type="text/javascript">
	      	$(document).ready(function(){

	        	$('#pop_up_state_id').change(function(){ 
	          		var id = $(this).val();

		          	$.ajax({
		            	url : "<?php echo site_url('master/vendor_master/get_city_name');?>",
		           	 	method : "POST",
		            	data : {id: id},
		            	async : true,
		            	dataType : 'json',
			            /*success: function(data){ 
			              var html = '';
			              var i;
			              for(i=0; i<data.length; i++){
			                html += '<option value='+data[i].entity_id+'>'+data[i].city_name+'</option>';
			              }
			              $('#city_id').html(html);
			            }*/

		            	success: function(response){

		                    // Remove options 
		                    $('#pop_up_city_id').find('option').not(':first').remove();

		                    // Add options
		                    $.each(response,function(index,data){
		                        $('#pop_up_city_id').append('<option value="'+data['entity_id']+'">'+data['city_name']+'</option>');
		                    });
		                }
		          	});
	          		return false;
	        	});     
	      	});
	    </script>

	    <script type="text/javascript">
            //load data for edit
            $('#pop_up_state_id').change(function(){
                var id=$(this).val();
                $.ajax({
                    url : "<?php echo site_url('master/customer_master/get_state_code');?>",
                    method : "POST",
                    data : {id: id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        $.each(data, function(i, item){
                            console.log(data);
                            $val = 
                            $('[name="pop_up_state_code"]').val(data[i].state_code);
                        })
                    }
                });
                return false;
            });
        </script>

        <script>
            function myPassword() {
                var x = document.getElementById("pop_up_user_password");
                if(x.type === "password") {
                    x.type = "text";
                }else {
                    x.type = "password";
                }
            }
        </script>

    	<script type="text/javascript">
    		$('#pop_up_email_id').change(function(){ 
                var id=$(this).val();
                $.ajax({
                    url : "<?php echo site_url('master/vendor_master/check_vender_id');?>",
                    method : "POST",
                    data : {id: id},
                    async : true,
                    dataType : 'json',
                    success : function(data) {
                            //
                        //location.reload();
                        },
                        error : function(data) {
                            alert("Id Already Exist");
                            //location.reload();
                            $("#pop_up_email_id").val('');
                        }
                    });
                return false;
            });
    	</script>

    	<script>
            $(document).on('click', '#save_supplier', function () {

                var vendor_name = document.getElementById('pop_up_vendor_name').value;
                var gst_no = document.getElementById('pop_up_gst_no').value;
                var phone_no = document.getElementById('pop_up_phone_no').value;
                var contact_person = document.getElementById('pop_up_contact_person').value;
                var mobile_number = document.getElementById('pop_up_mobile_number').value;
                var state_id = document.getElementById('pop_up_state_id').value;
                var city_id = document.getElementById('pop_up_city_id').value;
                var address = document.getElementById('pop_up_address').value;
                var state_code = document.getElementById('pop_up_state_code').value;
                var pincode = document.getElementById('pop_up_pincode').value;
                var email_id = document.getElementById('pop_up_email_id').value;
                var user_password = document.getElementById('pop_up_user_password').value;

                if(vendor_name != "" && phone_no != "" && contact_person != "" && state_id != "" && city_id != "" && address != "" && state_code != "" && pincode != "" && email_id != "" && user_password != "")
                {
                    $.ajax({
                        url:"<?php echo site_url('master/vendor_master/save_pop_up_vendor_data');?>",
                        type: 'POST',
                        data: {'vendor_name' : vendor_name , 'gst_no' : gst_no , 'phone_no' : phone_no , 'contact_person' : contact_person , 'mobile_number' : mobile_number , 'state_id' : state_id , 'city_id' : city_id , 'address' : address , 'state_code' : state_code , 'pincode' : pincode , 'email_id' : email_id , 'user_password' : user_password},
                        success: function(data){
                            data = data.trim();
                            location.reload(true);
                        },
                        error: function(){
                            alert("Fail");
                            location.reload();
                        }
                    });
                }else{
                  alert("Enter All Details.............");
                }
            });
        </script>
        
	    <script type="text/javascript">
            $(document).on('click', '#craete_rfq', function () {
                
                var enquiry_id = document.getElementById('enquiry_id').value;
                var vender_id = document.getElementById('vender_id').value;

                if(enquiry_id != "" && vender_id != "")
                {   
                    $.ajax({
                        url:"<?php echo site_url('support/rfq_register/create_rfq_from_enquiry');?>",
                        type: 'POST',
                        data: {'enquiry_id': enquiry_id , 'vender_id' : vender_id},
                        success : function(data) {
                            data = data.trim();
                            window.location.href = data;
                        },
                        error: function(){
                         alert("Fail")
                        }
                    });
                }else{
                    alert("Enter All Details.....");
                }
            });
        </script>

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
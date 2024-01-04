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
	  	<title>Create RFQ</title>
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
    		<?php 
    			$this->load->view('header_sidebar');
    		?> 
			    <div class="content-wrapper">
			      	<section class="content-header">
			        	<div class="container-fluid">
			          		<br>
			          		<div class="card">
			            		<div class="card-header" >
			              			<h1 class="card-title">Create RFQ</h1>
			              			<div class="col-sm-6">
			                		<br><br>
			                			<ol class="breadcrumb">
			                  				<li class="breadcrumb-item"><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
			                  				<li class="breadcrumb-item"><a href="<?php echo base_url().'rfq_index'?>">RFQ Index</a></li>
			                  				<li class="breadcrumb-item">Create RFQ</li>
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
				                  			<form role="form" name="tracking_datail_form" id="tracking_datail_form" action="<?php echo site_url('support/rfq_register/edit_rfq');?>" method="post">

				                  				<input type="hidden" id="rfq_id" name="rfq_id" value="<?php echo $entity_id?>" required>

				                    			<div class="row">
                                                    <div class="col-sm-3">
				                        				<div class="form-group">
				                          					<label style="color: #FF0000;">RFQ Number * </label>
				                          					<input type="text" class="form-control" name="rfq_number" id="rfq_number" placeholder="Enter RFQ Number" readonly>
				                        				</div>
				                      				</div>

				                      				<div class="col-sm-3">
				                        				<div class="form-group">
				                          					<label style="color: #FF0000;">Enquiry Number * </label>
				                          					<input type="text" class="form-control" name="enquiry_number" id="enquiry_number" placeholder="Enter Enquiry Number" readonly>
				                        				</div>
				                      				</div> 

				                      				<div class="col-sm-4">
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

							                    <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label> <span style="color: #FF0000;"> Enquiry Description * </span> </label>
                                                            <textarea class="form-control" id="enquiry_descrption" name="enquiry_descrption" rows="3" placeholder="Enter Enquiry Description" disabled></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
					                                <div class="col-md-12">
					                                    <div class="card card-primary">
					                                        <div class="card-header">
					                                            <h3 class="card-title">RFQ Product Details</h3>
					                                        </div>
					                                        <div>
                                                                <div class="btn-group" style="margin-top: 15px; margin-left: 20px;">
                                                                    <a data-toggle="modal" data-target="#modal-product" class="btn btn-block btn-success" style="background-color: #5cb85c; border-color: #4cae4c; color: #ffff;">
                                                                        Select Product
                                                                    </a>
                                                                </div>
                                                            </div>
					                                        <div class="card-body">
					                                            <div  class="table-responsive">
					                                                <table id="example1" class="table table-bordered table-striped">
					                                                    <thead>
					                                                    	<th style="display: none;">Entity Id</th>
					                                                    	<th>Sr No</th>
					                                                    	<th>Category</th>
					                                                    	<th>Sub Category</th>
					                                                    	<th>Product Id</th>
													                      	<th>Product Name</th>
													                      	<th>Product Description</th>
													                      	<th>Quantity</th>
													                      	<th>Remark</th>
													                      	<th>Action</th>
					                                                    </thead>
					                                                    <tbody>
					                                                        <?php
					                                                            $no = 0;
					                                                            foreach ($rfq_product_list as $row):
					                                                               	$no++;
					                                                                $rfq_relation_entity_id = $row->entity_id;
					                                                                
					                                                        ?>
						                                                        <tr>
						                                                        	<td style="display: none;" class="rfq_relation_entity_id" id="rfq_relation_entity_id"><?php echo $rfq_relation_entity_id;?></td>
						                                                            <td><?php echo $no;?></td>

						                                                            <td><?php echo $row->category_name;?></td>

						                                                            <td><?php echo $row->subcategory_name;?></td>

						                                                            <td><?php echo $row->Product_id;?></td>

						                                                            <td><?php echo $row->product_name;?></td>

						                                                            <td><?php echo $row->product_long_description;?></td>

						                                                           <td>
                                                                                    	<input type="text" class="form-control" value="<?php echo $row->qty;?>" id="product_qty" name="product_qty" placeholder="Enter Product Qty" style="width: 100px;" onchange="change_ProductQty(this);">   
                                                                                	</td>

						                                                            <td><textarea class="form-control" id="product_remark" name="product_remark" style="width: 300px;" rows="3" placeholder="Enter Product Remark" onchange="change_ProductRemark(this);"><?php echo $row->remark;?></textarea>  </td>

						                                                            <td>
	                                                                                    <a class="btn btn-sm btn-danger" onclick="delete_rfq_product(<?php echo $rfq_relation_entity_id; ?>)"><i class="fas fa-trash"></i> </a>
	                                                                                </td>
						                                                        </tr>
						                                                    <?php endforeach;?>
					                                                    </tbody>
					                                                </table>
					                                            </div>
					                                        </div>
					                                    </div>
					                                </div>
					                            </div> 

					                            <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label> <span style="color: #FF0000;"> Terms & Condition * </span> </label>
                                                            <textarea class="form-control" id="terms_condition" name="terms_condition" rows="3" placeholder="Enter Terms & Condition" required></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label> Note </label>
                                                            <textarea class="form-control" id="note" name="note" rows="3" placeholder="Enter Note" ></textarea>
                                                        </div>
                                                    </div>
                                                </div>

							                	<div class="card-body">
							                        <center>
							                            <button type="button" class="btn btn-success toastrDefaultSuccess" data-toggle="modal" data-target="#modal-sm">
                                                            Submit
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
                        <button type="submit" name="confirm_rfq" id="confirm_rfq" class="btn btn-primary">Yes</button>
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

        <div class="modal fade" id="modal-product">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Select product</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                       <div class="modal-body">
                            <div  class="table-responsive">
                                <table id="product_details_table" class="table table-bordered table-striped">
                                    <thead>
                                       <tr>
                                          <th></th>
                                          <th style="display: none;">Entity Id</th>
                                          <th>Product Id</th>
                                          <th>Product Name</th>
                                          <th>Product Description</th> 
                                       </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $no = 0;
                                            foreach ($product_list as $row):
                                              $no++;
                                              $entity_id = $row->entity_id;
                                        ?>
                                        <tr id="d1">
                                            <td><input type="checkbox" class="checkboxes" id="product_checkbox" name="product_checkbox" value="<?php echo $row->entity_id ?>"></td>
                                            <td style="display: none;"><?php echo $row->entity_id;?></td>
                                            <td><?php echo $row->product_id;?></td>
                                            <td><?php echo $row->product_name;?></td>
                                            <td><input type="text" value="<?php echo $row->product_long_description;?>" style="color: #000; border-style: none;background: none;" disabled></td>
                                       </tr>
                                       <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="product_checkbox_submited_new">Save</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
             <!-- /.modal-dialog -->
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
                //call function get data edit
                get_data_edit();
                //load data for edit
                function get_data_edit(){
                    var entity_id = $('[name="rfq_id"]').val();
                    
                    $.ajax({
                        url : "<?php echo site_url('support/rfq_register/get_all_data_by_id');?>",
                        method : "POST",
                        data :{entity_id :entity_id},
                        async : true,
                        dataType : 'json',
                        success : function(data){
                            $.each(data, function(i, item){
                                console.log(data);
                                $val =
                                $('[name="rfq_number"]').val(data[i].rfq_number);
                                $('[name="enquiry_number"]').val(data[i].enquiry_no);
                                $('[name="vender_id"]').val(data[i].vender_id).trigger('change');
                                $('[name="enquiry_descrption"]').val(data[i].enquiry_long_desc);
                                $('[name="terms_condition"]').val(data[i].terms_condition);
                                $('[name="note"]').val(data[i].note);
                            });
                        }
                    });
                }
            });
        </script>

	    <script>
            $(document).on('click', '#confirm_rfq', function () {

                var rfq_id = document.getElementById('rfq_id').value;
                var vender_id = document.getElementById('vender_id').value;

                var terms_condition = document.getElementById('terms_condition').value;
                var note = document.getElementById('note').value;

                if(rfq_id != "" && vender_id != "" && terms_condition != "")
                {
                    $.ajax({
                        url:"<?php echo site_url('support/rfq_register/edit_rfq');?>",
                        type: 'POST',
                        data: {'rfq_id' : rfq_id , 'vender_id' : vender_id , 'terms_condition' : terms_condition , 'note' : note},
                        success: function(data){
                            data = data.trim();
                            window.location.href = data;
                        },
                        error: function(){
                            alert("Fail");
                            location.reload();
                        }
                    });
                }else{
                  alert("Enter Proper Details.............");
                }
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

        <script>
           	$(function()
           	{
                $("#product_checkbox_submited_new").on('click', function(event)
                {
                    var rfq_id = document.getElementById('rfq_id').value;
                    var vender_id = document.getElementById('vender_id').value;

                    var terms_condition = document.getElementById('terms_condition').value;
                    var note = document.getElementById('note').value;

                    var product_checkbox = [];
                    $.each($("input[name='product_checkbox']:checked"), function(){            
                        product_checkbox.push($(this).val());
                    });

                	if(rfq_id != "" && vender_id != "" && product_checkbox != "")
                	{
	                    $.ajax({
	                        url:"<?php echo site_url('support/rfq_register/add_product');?>",
	                        type: 'POST',
	                        data: {'rfq_id' : rfq_id , 'product_checkbox' : product_checkbox , 'vender_id' : vender_id , 'terms_condition' : terms_condition , 'note' : note},
	                        success: function(data){
	                            location.reload(true);
	                        },
	                        error: function(){
	                           alert("Fail")
	                        }
	                    });
	                }else{
                  		alert("Enter Proper Details.............");
                	}
                });
            });
        </script>	

        <script type="text/javascript">
        	function change_ProductQty(item)
            {
               var rfq_relation_entity_id = $(item).closest('tr').find('.rfq_relation_entity_id ').text();
               var product_qty = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('support/rfq_register/update_product_qty');?>",
                    method : "POST",
                    data : {'product_qty': product_qty,
                            'rfq_relation_entity_id': rfq_relation_entity_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        //location.reload();
                    }
                });
                return false;
            }

            function change_ProductRemark(item)
            {
               var rfq_relation_entity_id = $(item).closest('tr').find('.rfq_relation_entity_id ').text();
               var remark = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('support/rfq_register/update_product_remark');?>",
                    method : "POST",
                    data : {'remark': remark,
                            'rfq_relation_entity_id': rfq_relation_entity_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        //location.reload();
                    }
                });
                return false;
            }

            function delete_rfq_product(d){
                var id=d;
                $.ajax({
                    url : "<?php echo site_url('support/rfq_register/delete_rfq_product');?>",
                    type : "POST",
                    data: {'id': id},
                    success : function(data) {
                        location.reload(true);
                    },
                    error : function(data) {
                        alert("Failed!!");
                    }
                });
            }
        </script>

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

		<script>
           $(document).ready( function () {
              	$('#example1').DataTable();
              	$('#product_details_table').DataTable();
            } );
        </script>
	</body>
</html>
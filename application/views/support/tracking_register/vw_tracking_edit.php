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
	  	<title>Create Tracking</title>
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

    			$this->db->select('tracking_master.*');
		        $this->db->from('tracking_master');
		        $where = '(tracking_master.entity_id = "'.$tracking_id.'" )';
		        $this->db->where($where);
		        $tracking_master = $this->db->get();
        		$tracking_master_record = $tracking_master->row_array();

        		$tracking_type = $tracking_master_record['tracking_type'];
        		$enquiry_id = $tracking_master_record['enquiry_id'];

        		$this->db->select('tracking_master.*');
		        $this->db->from('tracking_master');
		        $where = '(tracking_master.enquiry_id = "'.$enquiry_id.'" And tracking_master.entity_id != "'.$tracking_id.'" And tracking_master.vender_id IS NULL And tracking_master.status = "'.'2'.'")';
		        $this->db->where($where);
		        $customer_tracking_master = $this->db->get();
        		$customer_tracking_master_record = $customer_tracking_master->result();

        		$this->db->select('tracking_master.*,
        			vendor_master.vendor_name');
		        $this->db->from('tracking_master');
		        $this->db->join('vendor_master', 'tracking_master.vender_id = vendor_master.entity_id', 'INNER');
		        $where = '(tracking_master.enquiry_id = "'.$enquiry_id.'" And tracking_master.entity_id != "'.$tracking_id.'" And tracking_master.vender_id IS NOT NULL And tracking_master.status = "'.'2'.'")';
		        $this->db->where($where);
		        $vender_tracking_master = $this->db->get();
        		$vender_tracking_master_record = $vender_tracking_master->result();
    		?> 
			    <div class="content-wrapper">
			      	<section class="content-header">
			        	<div class="container-fluid">
			          		<br>
			          		<div class="card">
			            		<div class="card-header" >
			              			<h1 class="card-title">Create Tracking</h1>
			              			<div class="col-sm-6">
			                		<br><br>
			                			<ol class="breadcrumb">
			                  				<li class="breadcrumb-item"><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
			                  				<li class="breadcrumb-item"><a href="<?php echo base_url().'tracking_index'?>">Tracking Index</a></li>
			                  				<li class="breadcrumb-item">Create Tracking</li>
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
				                  			<h3 class="card-title">Tracking Details </h3>
				                		</div>
				                		<div class="card-body" style="border-radius: 1.25rem;">
				                  			<form role="form" name="tracking_datail_form" id="tracking_datail_form" action="<?php echo site_url('support/tracking_register/save_tracking');?>" method="post">

				                  				<input type="hidden" id="tracking_id" name="tracking_id" value="<?php echo $tracking_id?>" required>

				                  				<input type="hidden" id="enquiry_id" name="enquiry_id" value="<?php echo $enquiry_id?>" required>

				                    			<div class="row">
				                      				<div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> <span style="color: #FF0000;"> Tracking Type * </span></label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="tracking_type" name="tracking_type" disabled>
                                                                <option value="">Select Tracking Type</option>
                                                                <option value="1">Customer</option>
                                                                <option value="2">Supplier</option>
                                                            </select>
                                                        </div>
                                                    </div> 
                                                        
                                                    <div class="col-sm-3">
				                        				<div class="form-group">
				                          					<label style="color: #FF0000;">Tracking Number * </label>
				                          					<input type="text" class="form-control" name="tracking_number" id="tracking_number" placeholder="Enter Tracking Number" readonly>
				                        				</div>
				                      				</div>

				                      				<div class="col-sm-3">
				                        				<div class="form-group">
				                          					<label style="color: #FF0000;">Enquiry Number * </label>
				                          					<input type="text" class="form-control" name="enquiry_number" id="enquiry_number" placeholder="Enter Enquiry Number" readonly>
				                        				</div>
				                      				</div> 

				                      				 <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> <span style="color: #FF0000;"> Customer Name * </span></label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="customer_id" name="customer_id" disabled>
                                                                <option value="">No Selected</option>
                                                                <?php foreach($customer_list as $row):?>
                                                                <option value="<?php echo $row->entity_id;?>"><?php echo $row->customer_name;?></option>
                                                                <?php endforeach;?>
                                                            </select>
                                                        </div>
                                                    </div>
							                    </div>

							                    <?php if($tracking_type == 2){?>
							                    	<div class="row">
								                    	<div class="col-sm-4">
	                                                        
	                                                    </div>

	                                                    <div class="col-sm-4">
	                                                        <div class="form-group">
	                                                            <label> <span style="color: #FF0000;"> Supplier Name * </span></label>
	                                                            <select class="form-control select2bs4" style="width: 100%;" id="vender_id" name="vender_id" >
	                                                                <option value="">No Selected</option>
	                                                                <?php foreach($vender_list as $row):?>
	                                                                <option value="<?php echo $row->entity_id;?>"><?php echo $row->vendor_name;?></option>
	                                                                <?php endforeach;?>
	                                                            </select>
	                                                        </div>
	                                                    </div>
	                                                    <div class="col-sm-2">
	                                                        <div>
	                                                            <div style="margin-top: 30px;">
	                                                                <button type="button" class="btn btn-block btn-success" data-toggle="modal" data-target="#modal-lg-vender">
	                                                                  Add Supplier
	                                                                </button>
	                                                            </div>
	                                                        </div>
	                                                    </div> 
	                                                </div>
							                    <?php } ?>

							                    <div class="row">
                                                    <div class="col-sm-8">
                                                        <div class="form-group">
                                                            <label> <span style="color: #FF0000;"> Enquiry Description * </span> </label>
                                                            <textarea class="form-control" id="enquiry_descrption" name="enquiry_descrption" rows="3" placeholder="Enter Enquiry Description" required></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label> <span style="color: #FF0000;"> Enquiry Product * </span> </label>
                                                            <div class="select2-purple">
                                                                <select class="select2" name="enquiry_product[]" id="enquiry_product" multiple="multiple" data-placeholder="Select A Product" data-dropdown-css-class="select2-purple" style="width: 100%;">
                                                                    <?php foreach($product_list as $row):?>
                                                                        <option value="<?php echo $row->entity_id;?>"><?php echo $row->Product_name;?></option>
                                                                    <?php endforeach;?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h3 class="card-title">Tracking Details Form</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label> Tracking Date </label>
                                                                    <input type="date" name="tracking_date" id="tracking_date" class="form-control" size="50" readonly>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-8">
                                                                <div class="form-group">
                                                                    <label style="color: #FF0000;"> Tracking Description * </label>
                                                                    <textarea class="form-control" id="tracking_descrption" name="tracking_descrption" required rows="3" placeholder="Enter Enquiry Tracking Description"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label style="color: #FF0000;"> Next Action * </label>
                                                                    <textarea class="form-control" id="tracking_next_action" name="tracking_next_action" required rows="3" placeholder="Enter Tracking Next Action"></textarea>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label  style="color: #FF0000;"> Action Due Date *</label>
                                                                    <input type="date" name="action_due_date" id="action_due_date" required class="form-control" size="50">
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label > Add Reminder </label><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <input type="hidden"><i style="font-size: 50px;" class="fa fa-bell"></i>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <!-- <div class="card-body">
                                                            <center>
                                                                <div class="btn-group">
                                                                    <a href="<?php echo site_url('vw_all_enquiry_to_order_data');?>" class="btn btn-block btn-danger">
                                                                    Back
                                                                    </a>
                                                                </div>

                                                                <button type="submit" class="btn btn-success toastrDefaultSuccess">
                                                                    Save And Close
                                                                </button>

                                                                <button type="button" class="btn btn-primary toastrDefaultSuccess" data-toggle="modal" data-target="#modal-sm">
                                                                    Save & Create Offer
                                                                </button>
                                                            </center>
                                                        </div> -->
                                                    </div>
                                                </div>

                                                <div class="row">
                                                	<div class="col-sm-4">
                                                	</div>

				                      				<div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label> <span style="color: #FF0000;"> Enquiry Status * </span></label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="enquiry_status" name="enquiry_status">
                                                                <option value="">Select Enquiry Status</option>
                                                                <option value="1">Offer Pending</option>
                                                                <option value="2">Offer Received</option>
                                                                <option value="3">Closed</option>
                                                                <option value="4">Cancelled</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div> 

                                                <?php if($tracking_type == 2){?>
								                    <div class="card-body">
								                        <center>
								                            <button type="button" class="btn btn-success toastrDefaultSuccess" data-toggle="modal" data-target="#modal-sm-supplier">
	                                                            Submit
	                                                        </button>
								                        </center>
								                    </div>
								                <?php }else{ ?>
								                	<div class="card-body">
								                        <center>
								                            <button type="button" class="btn btn-success toastrDefaultSuccess" data-toggle="modal" data-target="#modal-sm">
	                                                            Submit
	                                                        </button>
								                        </center>
								                    </div>
								                <?php } ?>
							                    
                                                <div class="row">
					                                <div class="col-md-6">
					                                    <div class="card card-primary">
					                                        <div class="card-header">
					                                            <h3 class="card-title">Customer Wise Tracking History</h3>
					                                        </div>
					                                        <div class="card-body">
					                                            <div  class="table-responsive">
					                                                <table id="example1" class="table table-bordered table-striped">
					                                                    <thead>
					                                                    	<th>Sr No</th>
					                                                    	<th>Tracking No</th>
													                      	<th>Tracking Date</th>
													                      	<th>Tracking Description</th>
													                      	<th>Next Action</th>
													                      	<th>Action Due Date</th>
					                                                    </thead>
					                                                    <tbody>
					                                                        <?php
					                                                            $no = 0;
					                                                            foreach ($customer_tracking_master_record as $row):
					                                                               	$no++;
					                                                                $entity_id = $row->entity_id;
					                                                                
					                                                        ?>
						                                                        <tr>
						                                                            <td><input type="text" value="<?php echo $no;?>" style="width: 70px; color: #000; border-style: none;background: none;" disabled></td>

						                                                            <td><input type="text" value="<?php echo $row->tracking_number;?>" style="width: 150px; color: #000; border-style: none;background: none;" disabled></td>

						                                                            <td><input type="text" value="<?php echo date("d-m-Y", strtotime($row->tracking_date));?>" style="width: 100px; color: #000; border-style: none;background: none;" disabled></td>

						                                                            <td><input type="text" value="<?php echo $row->tracking_record;?>" style="color: #000; border-style: none;background: none;" disabled></td>

						                                                            <td><input type="text" value="<?php echo $row->next_action;?>" style="width: 150px; color: #000; border-style: none;background: none;" disabled></td>

						                                                            <td><input type="text" value="<?php echo date("d-m-Y", strtotime($row->action_due_date));?>" style="width: 100px; color: #000; border-style: none;background: none;" disabled></td>
						                                                        </tr>
						                                                    <?php endforeach;?>
					                                                    </tbody>
					                                                </table>
					                                            </div>
					                                        </div>
					                                    </div>
					                                </div>

					                                <div class="col-md-6">
					                                    <div class="card card-primary">
					                                        <div class="card-header">
					                                            <h3 class="card-title">Supplier Wise Tracking History</h3>
					                                        </div>
					                                        <div class="card-body">
					                                            <div  class="table-responsive">
					                                                <table id="example2" class="table table-bordered table-striped">
					                                                    <thead>
					                                                    	<th>Sr No</th>
					                                                    	<th>Supplier Name</th>
					                                                    	<th>Tracking No</th>
													                      	<th>Tracking Date</th>
													                      	<th>Tracking Description</th>
													                      	<th>Next Action</th>
													                      	<th>Action Due Date</th>
					                                                    </thead>
					                                                    <tbody>
					                                                        <?php
					                                                            $no = 0;
					                                                            foreach ($vender_tracking_master_record as $row):
					                                                               	$no++;
					                                                                $entity_id = $row->entity_id;
					                                                                
					                                                        ?>
						                                                        <tr>
						                                                            <td><input type="text" value="<?php echo $no;?>" style="width: 70px; color: #000; border-style: none;background: none;" disabled></td>

						                                                            <td><input type="text" value="<?php echo $row->vendor_name;?>" style="width: 150px; color: #000; border-style: none;background: none;" disabled></td>

						                                                            <td><input type="text" value="<?php echo $row->tracking_number;?>" style="width: 150px; color: #000; border-style: none;background: none;" disabled></td>

						                                                            <td><input type="text" value="<?php echo date("d-m-Y", strtotime($row->tracking_date));?>" style="width: 100px; color: #000; border-style: none;background: none;" disabled></td>

						                                                            <td><input type="text" value="<?php echo $row->tracking_record;?>" style="color: #000; border-style: none;background: none;" disabled></td>

						                                                            <td><input type="text" value="<?php echo $row->next_action;?>" style="width: 150px; color: #000; border-style: none;background: none;" disabled></td>

						                                                            <td><input type="text" value="<?php echo date("d-m-Y", strtotime($row->action_due_date));?>" style="width: 100px; color: #000; border-style: none;background: none;" disabled></td>
						                                                        </tr>
						                                                    <?php endforeach;?>
					                                                    </tbody>
					                                                </table>
					                                            </div>
					                                        </div>
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
    	<div class="modal fade" id="modal-sm">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Confirm Tracking</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Do You Want To Confirm Created Tracking? </p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        <button type="submit" name="confirm_customer_tracking" id="confirm_customer_tracking" class="btn btn-primary">Yes</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-sm-supplier">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Confirm Tracking</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Do You Want To Confirm Save Tracking? </p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        <button type="submit" name="confirm_supplier_tracking" id="confirm_supplier_tracking" class="btn btn-primary">Yes</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-lg-vender">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Supplier</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" name="vendor_datail_form" id="vendor_datail_form">
                			<div class="row">
                  				<div class="col-sm-6">
                    				<div class="form-group">
                      					<label style="color: #FF0000;">Supplier Name * </label>
                      					<input type="text" class="form-control" name="pop_up_vendor_name" id="pop_up_vendor_name" placeholder="Enter Supplier Name" required="required">
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
		                      	<div class="col-sm-4">
		                        	<div class="form-group">
		                          		<label style="color: #FF0000;">State Code * </label>
		                          		<input type="text" class="form-control" readonly name="pop_up_state_code" id="pop_up_state_code" placeholder="Enter State Code" required>
		                        	</div>
		                      	</div> 

		                      	<div class="col-sm-4">
		                        	<div class="form-group">
		                          		<label style="color: #FF0000;">Pincode *</label>
		                          		<input type="text" class="form-control" name="pop_up_pincode" id="pop_up_pincode" placeholder="Enter Pincode" required>
		                        	</div>
		                      	</div> 

		                      	<div class="col-sm-4">
		                        	<div class="form-group">
		                          		<label>Email </label>
		                          		<input type="email" class="form-control" name="pop_up_email_id" id="pop_up_email_id" placeholder="Enter Email Address">
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
                //call function get data edit
                get_data_edit();
                //get_city_data_edit();
                get_enquiry_product_data();
                //load data for edit
                function get_data_edit(){
                    var entity_id = $('[name="tracking_id"]').val();
                    
                    $.ajax({
                        url : "<?php echo site_url('support/tracking_register/get_all_data_by_id');?>",
                        method : "POST",
                        data :{entity_id :entity_id},
                        async : true,
                        dataType : 'json',
                        success : function(data){
                            $.each(data, function(i, item){
                                console.log(data);
                                $val = 
                                $('[name="tracking_type"]').val(data[i].tracking_type).trigger('change');
                                $('[name="tracking_number"]').val(data[i].tracking_number);
                                $('[name="enquiry_number"]').val(data[i].enquiry_no);
                                $('[name="enquiry_status"]').val(data[i].enquiry_status).trigger('change');
                                $('[name="customer_id"]').val(data[i].customer_id).trigger('change');
                                $('[name="vender_id"]').val(data[i].vender_id).trigger('change');
                                $('[name="enquiry_descrption"]').val(data[i].enquiry_long_desc);

                                $('[name="tracking_date"]').val(data[i].tracking_date);
                                $('[name="tracking_descrption"]').val(data[i].tracking_record);
                                $('[name="tracking_next_action"]').val(data[i].next_action);
                                $('[name="action_due_date"]').val(data[i].action_due_date);
                            });
                        }
                    });
                } 

                 function get_enquiry_product_data(){
                    var entity_id = $('[name="enquiry_id"]').val();
                    
                    $.ajax({
                        url : "<?php echo site_url('support/enquiry_register/get_enquiry_product_by_id');?>",
                        method : "POST",
                        data :{entity_id :entity_id},
                        async : true,
                        dataType : 'json',
                        success : function(data){
                            /*$('[name="enquiry_type"]').val(data.enquiry_type);*/
                            var Values = new Array();
                            $.each(data, function(i, item){
                                console.log(data);
                                $val = 
                                Values.push(data[i].product_id);  
                            });

                            $("#enquiry_product").val(Values).trigger('change');
                        }
                    });
                }
            });
        </script>

	    <script>
            $(document).on('click', '#confirm_customer_tracking', function () {

                var tracking_id = document.getElementById('tracking_id').value;
                var enquiry_id = document.getElementById('enquiry_id').value;
                var enquiry_status = document.getElementById('enquiry_status').value;

                var vender_id = "";
                var enquiry_descrption = document.getElementById('enquiry_descrption').value;
                var options = document.getElementById('enquiry_product').selectedOptions;
                var enquiry_product = Array.from(options).map(({ value }) => value);

                var tracking_descrption = document.getElementById('tracking_descrption').value;
                var tracking_next_action = document.getElementById('tracking_next_action').value;
                var action_due_date = document.getElementById('action_due_date').value;

                if(tracking_id != "" && enquiry_id != "" && enquiry_descrption != "" && enquiry_product != "" && tracking_descrption != "" && tracking_next_action != "" && action_due_date != "" && enquiry_status != "")
                {
                    $.ajax({
                        url:"<?php echo site_url('support/tracking_register/save_tracking_entry');?>",
                        type: 'POST',
                        data: {'tracking_id' : tracking_id , 'enquiry_id' : enquiry_id , 'vender_id' : vender_id , 'enquiry_descrption' : enquiry_descrption , 'enquiry_product' : enquiry_product , 'tracking_descrption' : tracking_descrption , 'tracking_next_action' : tracking_next_action , 'action_due_date' : action_due_date , 'enquiry_status' : enquiry_status},
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
            $(document).on('click', '#confirm_supplier_tracking', function () {

                var tracking_id = document.getElementById('tracking_id').value;
                var enquiry_id = document.getElementById('enquiry_id').value;
                var vender_id = document.getElementById('vender_id').value;
                var enquiry_status = document.getElementById('enquiry_status').value;

                var enquiry_descrption = document.getElementById('enquiry_descrption').value;
                var options = document.getElementById('enquiry_product').selectedOptions;
                var enquiry_product = Array.from(options).map(({ value }) => value);

                var tracking_descrption = document.getElementById('tracking_descrption').value;
                var tracking_next_action = document.getElementById('tracking_next_action').value;
                var action_due_date = document.getElementById('action_due_date').value;

                if(tracking_id != "" && enquiry_id != "" && vender_id != "" && enquiry_descrption != "" && enquiry_product != "" && tracking_descrption != "" && tracking_next_action != "" && action_due_date != "" && enquiry_status != "")
                {
                    $.ajax({
                        url:"<?php echo site_url('support/tracking_register/save_tracking_entry');?>",
                        type: 'POST',
                        data: {'tracking_id' : tracking_id , 'enquiry_id' : enquiry_id , 'vender_id' : vender_id , 'enquiry_descrption' : enquiry_descrption , 'enquiry_product' : enquiry_product , 'tracking_descrption' : tracking_descrption , 'tracking_next_action' : tracking_next_action , 'action_due_date' : action_due_date , 'enquiry_status' : enquiry_status},
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

                if(vendor_name != "" && phone_no != "" && contact_person != "" && state_id != "" && city_id != "" && address != "" && state_code != "" && pincode != "")
                {
                    $.ajax({
                        url:"<?php echo site_url('master/vendor_master/save_pop_up_vendor_data');?>",
                        type: 'POST',
                        data: {'vendor_name' : vendor_name , 'gst_no' : gst_no , 'phone_no' : phone_no , 'contact_person' : contact_person , 'mobile_number' : mobile_number , 'state_id' : state_id , 'city_id' : city_id , 'address' : address , 'state_code' : state_code , 'pincode' : pincode , 'email_id' : email_id},
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
                  $('#example2').DataTable();
            } );
        </script>
	</body>
</html>
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
        <title>Update Customer</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Data Tables -->
        <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css'?>">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/fontawesome-free/css/all.min.css'?>">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- daterange picker -->
        <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/daterangepicker/daterangepicker.css'?>">
        <!-- iCheck for checkboxes and radio inputs -->
        <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css'?>">
        <!-- Bootstrap Color Picker -->
        <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css'?>">
        <!-- Tempusdominus Bbootstrap 4 -->
        <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css'?>">
        <!-- Select2 -->
        <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/select2/css/select2.min.css'?>">
        <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css'?>">
        <!-- Bootstrap4 Duallistbox -->
        <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css'?>">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo base_url().'assets/dist/css/adminlte.min.css'?>">
        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    </head>
    <body class="hold-transition sidebar-mini">
        <div class="wrapper">
            <?php $this->load->view('header_sidebar');?> 
                <div class="content-wrapper">
                    <!-- Content Wrapper. Contains page content -->
                    <section class="content-header">
                        <div class="container-fluid">
                            <br>
                            <!-- <div class="card" style="background-color: #20c997;"> -->
                            <div class="card">
                                <div class="card-header" >
                                    <h1 class="card-title">Add IndiaMart Customer</h1>
                                    <div class="col-sm-6">
                                        <br><br>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'vw_customer_master'?>">Customer Master</a></li>
                                            <li class="breadcrumb-item">Update Customer Of Id :- <?php  echo $entity_id; ?> </li>
                                        </ol>
                                    </div>      
                                </div>   
                            </div>
                        </div>
                    </section>

                        <?php 

                            $this->db->select('customer_master.*');
                            $this->db->from('customer_master');
                            $this->db->where('entity_id', $entity_id);
                            $query = $this->db->get();
                            $query_result = $query->row_array();

                            $city_id = $query_result['city_id'];

                            $enq_id = $this->db->select('entity_id')->from('enquiry_register')->where('customer_id',$entity_id)->order_by('entity_id','DESC')->limit(1)->get()->row_array();
                            
                        ?> 
                    <section class="content">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- general form elements disabled -->
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Customer Master Form</h3>
                                        </div>
                                        
                                        <div class="card-body">
                                            <form role="form" name="customer_master" action="<?php echo site_url('master/customer_master/save_india_mart_customer');?>" method="post">
                                                
                                                <input type="hidden" id="enquiry_id" name="enquiry_id" value="<?php echo $enq_id['entity_id'];?>" required>

                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label> Customer Name <span style="color: #FF0000;">* Mandatory Field</span></label>
                                                            <input type="text" name="customer_name" id="customer_name" class="form-control" size="50" placeholder="Enter Customer Name" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label> Customer Type <span style="color: #FF0000;">* Mandatory Field</span></label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="customer_type" name="customer_type" required>
                                                                <option value="">No Selected</option>
                                                                <option value="1">Dealer</option>
                                                                <option value="2">End User</option>
                                                                <option value="3">OEM</option>
                                                                <option value="4">Trader</option>
                                                                <option value="5">System Integrator</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label> Address <span style="color: #FF0000;">* Mandatory Field</span> </label>
                                                            <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter Address" required></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label>State Name <span style="color: #FF0000;">* Mandatory Field</span> </label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="state_id" name="state_id" required>
                                                                <option value="">Select State</option>
                                                                <?php foreach($state_list as $row):?>
                                                                <option value="<?php echo $row->entity_id;?>"><?php echo $row->State_name;?></option>
                                                                <?php endforeach;?>
                                                            </select>
                                                        </div>
                                                    </div> 

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label>City Name <span style="color: #FF0000;">* Mandatory Field</span> </label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="city_id" name="city_id" required>
                                                            <option value="">Select City</option>
                                                            <?php
                                                                foreach($city_list as $city):?>
                                                                    <option value="<?php echo $city->entity_id;?>"><?php echo $city->city_name;?></option>
                                                                <?php endforeach;
                                                            ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label>State Code <span style="color: #FF0000;">* Mandatory</span> </label>
                                                            <input type="text" name="state_code" id="state_code" class="form-control" size="50" placeholder="State Code"  readonly>
                                                        </div>
                                                    </div> 
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label> Pin Code <span style="color: #FF0000;">* Mandatory</span> </label>
                                                            <input type="text" name="customer_pin_code" id="customer_pin_code" class="form-control" size="50" placeholder="Enter Customer Pin Code" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label> GST Number </label>
                                                            <input type="text" name="customer_gst_number" id="customer_gst_number" class="form-control" size="50" placeholder="Enter GST Number">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label> Pan Number </label>
                                                            <input type="text" name="customer_pan_number" id="customer_pan_number" class="form-control" size="50" placeholder="Enter Pan Number">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                      <!-- general form elements disabled -->
                                                        <div class="card card-primary">
                                                            <div class="card-header">
                                                                <h3 class="card-title"> Contact Details</h3>
                                                            </div><!-- 
                                                            <div>
                                                                <div class="btn-group" style="margin-top: 15px; margin-left: 20px;">
                                                                    <a data-toggle="modal" data-target="#modal-lg-bill-to" class="btn btn-block btn-primary" style="background-color: #5cb85c; border-color: #4cae4c; color: #ffff;">
                                                                        Enter Contact Details
                                                                    </a>
                                                                </div>
                                                            </div> -->
                                                            <div class="card-body">
                                                                <div  class="table-responsive">
                                                                   <table id="example1" class="table table-bordered table-striped">
                                                                      <thead>
                                                                         <tr>
                                                                            <th>Sr. No.</th>
                                                                            <th style="display: none;">Cust_address_Entity_id</th>
                                                                            <th>Contact Person</th>
                                                                            <th>Email Id</th>
                                                                            <th>Contact Number</th>
                                                                            <th>Alternate Contact Number</th>
                                                                            <th>What's Up Number</th>
                                                                         </tr>
                                                                      </thead>
                                                                      <tbody>
                                                                        <?php
                                                                            $no = 0;
                                                                            foreach ($contact_details as $row):
                                                                                $no++;
                                                                                $contact_id = $row->entity_id;
                                                                            ?>
                                                                            <tr>
                                                                            <input type="hidden" name="contact_person_id" value="<?php echo $contact_id; ?>">
                                                                                <td><?php echo $no;?></td>
                                                                                <td style="display: none;" class="contact_relation_entity_id" id="contact_relation_entity_id"><?php echo $contact_id;?></td>
                                                                                
                                                                                <td>
                                                                                    <input type="text" required class="form-control" value="<?php echo $row->contact_person;?>" id="contact_person" name="contact_person" style="width: 300px;" onchange="change_contactperson(this);">
                                                                                </td>
                                                                                <td>
                                                                                    <input type="email" required class="form-control" value="<?php echo $row->email_id;?>" id="email_id" name="email_id" style="width: 300px;" onchange="change_emailid(this);">
                                                                                </td>
                                                                                <td>
                                                                                    <input type="number" required class="form-control" value="<?php echo $row->first_contact_no;?>" id="first_contact_no" name="first_contact_no" style="width: 150px;" onchange="change_contactnumber(this);">      
                                                                                </td>
                                                                                <td>
                                                                                    <input type="number" class="form-control" value="<?php echo $row->second_contact_no;?>" id="second_contact_no" name="second_contact_no" style="width: 150px;" onchange="change_alternatecontactnumber(this);">    
                                                                                </td>
                                                                                <td>
                                                                                    <input type="number" class="form-control" value="<?php echo $row->whatsup_no;?>" id="whatsup_no" name="whatsup_no" style="width: 150px;" onchange="change_whatsupcontactnumber(this);">  
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
                                                   <div class="col-sm-4">
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label> Customer Status</label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="customer_status" name="customer_status" required>
                                                                <option value="">No Selected</option>
                                                                <option value="1">Active</option>
                                                                <option value="2">In-Active</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <center>
                                                        <button type="submit" class="btn btn-success toastrDefaultSuccess">
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
            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->
        <div class="modal fade" id="modal-lg-contact-to">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Write Customer Contact Details</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" name="customer_contact_details" id="customer_contact_details" method="post">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Address Type <span style="color: #FF0000;">* Mandatory Field</span> </label>
                                        <select class="form-control select2bs4" style="width: 100%;" id="pop_up_address_type" name="pop_up_address_type" required>
                                            <option value="">No Selected</option>
                                            <option value="1">Bill To</option>
                                            <option value="2">Ship To</option>
                                            <!-- <option value="3">Both(Bill To & Ship To)</option> -->
                                        </select>
                                    </div>
                                </div>
                            </div>
                                

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label> Contact Person <span style="color: #FF0000;">* Mandatory Field</span> </label>
                                        <input type="text" name="pop_up_contact_person" id="pop_up_contact_person" class="form-control" size="50" placeholder="Enter Contact Person" required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label> Email Id <span style="color: #FF0000;">* Mandatory Field</span> </label>
                                        <input type="email" name="pop_up_contact_person_email_id" id="pop_up_contact_person_email_id" class="form-control" size="50" placeholder="Enter Customer Email Id" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label> Contact Number <span style="color: #FF0000;">* Mandatory Field</span> </label>
                                        <input type="number" name="pop_up_first_contact_no" id="pop_up_first_contact_no" class="form-control" size="50" placeholder="Enter Contact Number" required>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label> Alternate Contact Number </label>
                                        <input type="number" name="pop_up_second_contact_no" id="pop_up_second_contact_no" class="form-control" size="50" placeholder="Enter Alternate Contact Number">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label> What's up Number </label>
                                        <input type="number" name="pop_up_whatsup_no" id="pop_up_whatsup_no" class="form-control" size="50" placeholder="Enter What's up Number">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        
                        <button type="submit" name="add_contact_details" id="add_contact_details" class="btn btn-primary">Save</button>
                    </div>
                </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- jQuery -->
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

                //load data for edit
                function get_data_edit(){
                    var entity_id = $('[name="entity_id"]').val();
                    
                    $.ajax({
                        url : "<?php echo site_url('master/customer_master/get_all_data_by_id');?>",
                        method : "POST",
                        data :{entity_id :entity_id},
                        async : true,
                        dataType : 'json',
                        success : function(data){
                            $.each(data, function(i, item){
                                console.log(data);
                                $val = 
                                $('[name="year_from"]').val(data[i].year_from);
                                $('[name="year_to"]').val(data[i].year_to);
                                $('[name="turn_over"]').val(data[i].turn_over);
                                $('[name="customer_type"]').val(data[i].customer_type).trigger('change');
                                $('[name="customer_status"]').val(data[i].status).trigger('change');
                            });
                        }
                    });
                }  
            });
        </script>

        <script type="text/javascript">
            $(document).ready(function(){
         
                $('#state_id').change(function(){ 
                    var id=$(this).val();
                    $.ajax({
                        url : "<?php echo site_url('master/customer_master/get_city_name');?>",
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
                            $('#city_id').find('option').not(':first').remove();

                            // Add options
                            $.each(response,function(index,data){
                                $('#city_id').append('<option value="'+data['entity_id']+'">'+data['city_name']+'</option>');
                            });
                        }
                    });
                    return false;
                });     
            });
        </script>

        <script type="text/javascript">
            //load data for edit
            $('#state_id').change(function(){
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
                            $('[name="state_code"]').val(data[i].state_code);
                        })
                    }
                });
                return false;
            });
        </script>
        <script type="text/javascript">
            $('#customer_name').change(function(){ 
                var id=$(this).val();
                $.ajax({
                    url : "<?php echo site_url('master/customer_master/check_customer_name');?>",
                    method : "POST",
                    data : {id: id},
                    async : true,
                    dataType : 'json',
                    success : function(data) {
                            //
                        //location.reload();
                        },
                        error : function(data) {
                            alert("Customer Already Exist");
                            //location.reload();
                            $("#customer_name").val('');
                        }
                    });
                return false;
            });
        </script>

        <script type="text/javascript">
            $(document).on('click', '#add_contact_details', function () {

                var address_type = $("#pop_up_address_type").val();
                var contact_person = $("#pop_up_contact_person").val();
                var contact_person_email_id = $("#pop_up_contact_person_email_id").val();
                var first_contact_no = $("#pop_up_first_contact_no").val();
                var second_contact_no = $("#pop_up_second_contact_no").val();
                var whatsup_no = $("#pop_up_whatsup_no").val();
                var entity_id = $("#entity_id").val();
                
                if(address_type != "" && entity_id != "" && contact_person != "" && contact_person_email_id != "" && first_contact_no != "")
                {
                    $.ajax({
                            url : "<?php echo site_url('master/customer_master/save_address_contact_details');?>",
                            type : "POST",
                            data: {'entity_id': entity_id , 'address_type': address_type , 'contact_person': contact_person , 'contact_person_email_id': contact_person_email_id , 'first_contact_no': first_contact_no , 'second_contact_no': second_contact_no , 'whatsup_no': whatsup_no},
                            success : function(data) {
                                data = data.trim();
                                location.reload();
                            },
                            error : function(data) {
                                alert("Failed!!");
                            }
                    });
                }else{
                    alert("Enter All Details");
                }
            });
        </script>

        <script type="text/javascript">
            function change_state(item)
            {
               var address_relation_entity_id = $(item).closest('tr').find('.address_relation_entity_id ').text();
               var state_id = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('master/customer_master/update_state');?>",
                    method : "POST",
                    data : {'state_id': state_id,
                            'address_relation_entity_id': address_relation_entity_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        location.reload();
                    }
                });
                return false;
            }

            function change_city(item)
            {
               var address_relation_entity_id = $(item).closest('tr').find('.address_relation_entity_id ').text();
               var city_id = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('master/customer_master/update_city');?>",
                    method : "POST",
                    data : {'city_id': city_id,
                            'address_relation_entity_id': address_relation_entity_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        location.reload();
                    }
                });
                return false;
            }

            function change_address(item)
            {
               var address_relation_entity_id = $(item).closest('tr').find('.address_relation_entity_id ').text();
               var address = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('master/customer_master/update_address');?>",
                    method : "POST",
                    data : {'address': address,
                            'address_relation_entity_id': address_relation_entity_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        location.reload();
                    }
                });
                return false;
            }

            function change_pincode(item)
            {
               var address_relation_entity_id = $(item).closest('tr').find('.address_relation_entity_id ').text();
               var pin_code = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('master/customer_master/update_pincode');?>",
                    method : "POST",
                    data : {'pin_code': pin_code,
                            'address_relation_entity_id': address_relation_entity_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        location.reload();
                    }
                });
                return false;
            }

            function change_statecode(item)
            {
               var address_relation_entity_id = $(item).closest('tr').find('.address_relation_entity_id ').text();
               var state_code = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('master/customer_master/update_statecode');?>",
                    method : "POST",
                    data : {'state_code': state_code,
                            'address_relation_entity_id': address_relation_entity_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        location.reload();
                    }
                });
                return false;
            }

            function change_gstnumber(item)
            {
               var address_relation_entity_id = $(item).closest('tr').find('.address_relation_entity_id ').text();
               var gst_no = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('master/customer_master/update_gstnumber');?>",
                    method : "POST",
                    data : {'gst_no': gst_no,
                            'address_relation_entity_id': address_relation_entity_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        location.reload();
                    }
                });
                return false;
            }

            function change_pannumber(item)
            {
               var address_relation_entity_id = $(item).closest('tr').find('.address_relation_entity_id ').text();
               var pan_no = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('master/customer_master/update_pannumber');?>",
                    method : "POST",
                    data : {'pan_no': pan_no,
                            'address_relation_entity_id': address_relation_entity_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        location.reload();
                    }
                });
                return false;
            }

            function change_contactperson(item)
            {
               var contact_relation_entity_id = $(item).closest('tr').find('.contact_relation_entity_id ').text();
               var contact_person = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('master/customer_master/update_contactperson');?>",
                    method : "POST",
                    data : {'contact_person': contact_person,
                            'contact_relation_entity_id': contact_relation_entity_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        location.reload();
                    }
                });
                return false;
            }

            function change_emailid(item)
            {
               var contact_relation_entity_id = $(item).closest('tr').find('.contact_relation_entity_id ').text();
               var email_id = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('master/customer_master/update_emailid');?>",
                    method : "POST",
                    data : {'email_id': email_id,
                            'contact_relation_entity_id': contact_relation_entity_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        location.reload();
                    }
                });
                return false;
            }

            function change_contactnumber(item)
            {
               var contact_relation_entity_id = $(item).closest('tr').find('.contact_relation_entity_id ').text();
               var contact_no = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('master/customer_master/update_contactnumber');?>",
                    method : "POST",
                    data : {'contact_no': contact_no,
                            'contact_relation_entity_id': contact_relation_entity_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        location.reload();
                    }
                });
                return false;
            }

            function change_alternatecontactnumber(item)
            {
               var contact_relation_entity_id = $(item).closest('tr').find('.contact_relation_entity_id ').text();
               var alternate_contact_no = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('master/customer_master/update_alternatecontactnumber');?>",
                    method : "POST",
                    data : {'alternate_contact_no': alternate_contact_no,
                            'contact_relation_entity_id': contact_relation_entity_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        location.reload();
                    }
                });
                return false;
            }

            function change_whatsupcontactnumber(item)
            {
               var contact_relation_entity_id = $(item).closest('tr').find('.contact_relation_entity_id ').text();
               var whatsup_contact_no = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('master/customer_master/update_whatsupcontactnumber');?>",
                    method : "POST",
                    data : {'whatsup_contact_no': whatsup_contact_no,
                            'contact_relation_entity_id': contact_relation_entity_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        location.reload();
                    }
                });
                return false;
            }
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
            $(function () {
                $("#example1").DataTable();
                $('#example2').DataTable({
                  "paging": true,
                  "lengthChange": false,
                  "searching": false,
                  "ordering": true,
                  "info": true,
                  "autoWidth": false,
                });
            });
        </script>
        <script>
            $(function () {
                $("#example3").DataTable();
                $('#example4').DataTable({
                  "paging": true,
                  "lengthChange": false,
                  "searching": false,
                  "ordering": true,
                  "info": true,
                  "autoWidth": false,
                });
            });
        </script>
    </body>
</html>

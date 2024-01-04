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
        <title>Update Enquiry</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
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
        <link rel="icon" href="<?php echo base_url().'assets/company_logo/construction.jpg'?>" type="image/ico" />
    </head>
    <body class="hold-transition sidebar-mini">
        <div class="wrapper">
            <?php $this->load->view('header_sidebar');?> 
            <?php 

                $this->db->select('enquiry_register.*');
                $this->db->from('enquiry_register');
                $this->db->where('entity_id', $entity_id);
                $query = $this->db->get();
                $query_result = $query->row_array();

                $customer_id = $query_result['customer_id'];

                $this->db->select('customer_master.*');
                $this->db->from('customer_master');
                $this->db->where('entity_id', $customer_id);
                $customer_master_query = $this->db->get();
                $customer_master_query_result = $customer_master_query->row_array();

                $Customer_name = $customer_master_query_result['customer_name'];

                $contact_id = $query_result['contact_id'];

                $this->db->select('customer_address_master.contact_person,
                    customer_address_master.email_id,
                    customer_address_master.first_contact_no,
                    state_master.state_name,
                    state_master.state_code,
                    city_master.city_name');
                $this->db->from('customer_address_master');
                $this->db->join('state_master', 'customer_address_master.state_id = state_master.entity_id', 'INNER');
                $this->db->join('city_master', 'customer_address_master.city_id = city_master.entity_id', 'INNER');
                $where = '(customer_address_master.entity_id = "'.$contact_id.'" )';
                $this->db->where($where);
                $customer_address_master = $this->db->get();
                $customer_address_master_query_result = $customer_address_master->row_array();

                $contact_person = $customer_address_master_query_result['contact_person'];
                $email_id = $customer_address_master_query_result['email_id'];
                $first_contact_no = $customer_address_master_query_result['first_contact_no'];
                $state_name = $customer_address_master_query_result['state_name'];
                $state_code = $customer_address_master_query_result['state_code'];
                $city_name = $customer_address_master_query_result['city_name'];

                $attachment_data = $enquiry_result->row_array();
                $attachment_img = $attachment_data['attachment'];
                $image_attachment_name = explode(',',$attachment_img);
                array_pop($image_attachment_name);
            ?>
                <div class="content-wrapper">
                    <!-- Content Wrapper. Contains page content -->
                    <section class="content-header">
                        <div class="container-fluid">
                            <br>
                            <!-- <div class="card" style="background-color: #20c997;"> -->
                            <div class="card">
                                <div class="card-header" >
                                    <h1 class="card-title">Update Enquiry</h1>
                                    <div class="col-sm-6">
                                        <br><br>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'vw_enquiry_data'?>">Enquiry Register</a></li>
                                            <li class="breadcrumb-item">Update Enquiry Details Of Id :- <?php  echo $entity_id; ?> </li>
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
                                            <h3 class="card-title">Enquiry Details Form</h3>
                                        </div>
                                        <div class="card-body">
                                            <form role="form" id="enquiry_form" name="enquiry_form" enctype="multipart/form-data" action="<?php echo site_url('support/enquiry_register/update_enquiry');?>" method="post">
                                                
                                                <input type="hidden" id="entity_id" name="entity_id" value="<?php echo $entity_id?>" required>

                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label> Enquiry Number </label>
                                                            <input type="text" name="enquiry_number" id="enquiry_number" class="form-control" size="50" placeholder="Enter Enquiry Number" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label> <span style="color: #FF0000;"> Customer Name * </span></label>
                                                            <!-- <select class="form-control select2bs4" style="width: 100%;" id="customer_name" name="customer_name" required>
                                                                <option value="">No Selected</option>
                                                                <?php foreach($customer_list as $row):?>
                                                                <option value="<?php echo $row->entity_id;?>"><?php echo $row->customer_name;?></option>
                                                                <?php endforeach;?>
                                                            </select> -->
                                                            <input type="text" name="customer_name" id="customer_name" class="form-control" size="50" placeholder="Enter Customer Name" value="<?php echo $Customer_name;?>" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label> <span style="color: #FF0000;"> Contact Person * </span></label>
                                                            <input type="text" name="contact_person" id="contact_person" class="form-control" size="50" placeholder="Enter Contact Person" value="<?php echo $contact_person;?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card card-primary">
                                                            <div class="card-header">
                                                                <h3 class="card-title"> Customer Details</h3>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> Customer Contact Person </label>
                                                                            <input type="text" name="enquiry_contact_person" id="enquiry_contact_person" class="form-control" size="50" placeholder="Customer Contact Person" value="<?php echo $contact_person;?>" readonly>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> Customer Email Id </label>
                                                                            <input type="text" name="enquiry_email_id" id="enquiry_email_id" class="form-control" size="50" placeholder="Customer Email Id" value="<?php echo $email_id;?>" readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-3">
                                                                        <div class="form-group">
                                                                            <label> Customer Contact Number </label>
                                                                            <input type="text" name="enquiry_contact_number" id="enquiry_contact_number" class="form-control" size="50" placeholder="Customer Contact Number" value="<?php echo $first_contact_no;?>" readonly>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-3">
                                                                        <div class="form-group">
                                                                            <label> Customer State </label>
                                                                            <input type="text" name="enquiry_customer_state" id="enquiry_customer_state" class="form-control" size="50" placeholder="Customer State" value="<?php echo $state_name;?>" readonly>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-3">
                                                                        <div class="form-group">
                                                                            <label> Customer City </label>
                                                                            <input type="text" name="enquiry_customer_city" id="enquiry_customer_city" class="form-control" size="50" placeholder="Customer City" value="<?php echo $city_name;?>" readonly>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-3">
                                                                        <div class="form-group">
                                                                            <label> State Code </label>
                                                                            <input type="text" name="enquiry_state_code" id="enquiry_state_code" class="form-control" size="50" value="<?php echo $state_code;?>" placeholder="State Code" readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                     <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label> <span style="color: #FF0000;"> Enquiry Description * </span> </label>
                                                            <textarea class="form-control" id="enquiry_descrption" name="enquiry_descrption" rows="3" placeholder="Enter Enquiry Description" required></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label> <span style="color: #FF0000;"> Enquiry Type * </span></label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="enquiry_type" name="enquiry_type" required>
                                                                <option value="">Select</option>
                                                                <option value="1">General</option>
                                                                <!-- <option value="2">Porximity (PS)</option>
                                                                <option value="3">Vibrator Control (VC)</option>
                                                                <option value="4">Treading (TD)</option>    
                                                                <option value="5">Other (OT)</option> -->
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- <div class="col-sm-4">
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
                                                    </div> -->
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> <span style="color: #FF0000;"> Enquiry Source * </span></label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="enquiry_source" name="enquiry_source" required>
                                                                <option value="">Select</option>
                                                                <option value="1">Indiamart</option>
                                                                <option value="2">Excibition</option>
                                                                <option value="3">MID</option>      
                                                                <option value="4">Phone Call</option>
                                                                <option value="5">Direct Mail</option>
                                                                <option value="6">Others</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> <span style="color: #FF0000;"> Enquiry Urgency * </span> </label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="enquiry_urgency" name="enquiry_urgency" required>
                                                                <option value="">Select</option>
                                                                <option value="1">Cold Call </option>
                                                                <option value="2">Live Enquiry / Budgatory</option>
                                                                <option value="3">Hot Lead</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">   
                                                            <label for="employee_attachment">Attachment</label>
                                                            <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" name="employee_attachment[]" multiple id="employee_attachment">
                                                                    <label class="custom-file-label" for="employee_attachment">Choose Attachment</label>
                                                                </div>
                                                            </div>
                                                            <?php 
                                                                foreach ($image_attachment_name as $key => $value) {
                                                            ?>
                                                            <p>
                                                                <a target="_blank" href="<?php echo base_url();?>assets/enquiry_attachment/<?php echo $value;?>"><?php echo $value;?></a>
                                                                <?php if(!empty($value)){ ?>
                                                                <a href="<?php echo site_url('delete_enquiry_attach_image/'.$value.'-'.$entity_id);?>" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                                                            </p>
                                                            <?php }}?>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>Enquiry Status</label>
                                                            <div class="col-sm-3">
                                                                <div class="form-group">
                                                                    <div class="custom-control custom-radio">
                                                                        <input class="custom-control-input" type="radio" id="customRadio1" name="enquiry_status" checked="checked" value="1" onclick="hideR()">
                                                                        <label for="customRadio1" class="custom-control-label">Pending</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-3">
                                                                <div class="form-group">
                                                                    <div class="custom-control custom-radio">
                                                                        <input class="custom-control-input" type="radio" id="customRadio2" name="enquiry_status" value="8" onclick="hideR()">
                                                                        <label for="customRadio2" class="custom-control-label">Qualified</label>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div class="col-sm-3">
                                                                <div class="form-group">
                                                                    <div class="custom-control custom-radio">
                                                                        <input class="custom-control-input" type="radio" id="customRadio3" name="enquiry_status" value="4" onclick="showR()">
                                                                        <label for="customRadio3" class="custom-control-label">Enquiry Regrated</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-3">
                                                                <div class="form-group">
                                                                    <div class="custom-control custom-radio">
                                                                        <input class="custom-control-input" type="radio" id="customRadio4" name="enquiry_status" value="7" onclick="showR()">
                                                                        <label for="customRadio4" class="custom-control-label">Not Qualified</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-4">
                                                    </div>

                                                    <div class="col-sm-4" id="Rejection_reason_form" style="display: none">
                                                        <div class="form-group">
                                                            <label> Reason to Cancelation <span style="color: #FF0000;">* Mandatory</span></label>
                                                            <textarea class="form-control" id="rejected_reason" name="rejected_reason" rows="3" placeholder="Enter Cancellation Reason"></textarea>
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
        <!-- bs-custom-file-input -->
        <script src="<?php echo base_url().'assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js'?>"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo base_url().'assets/dist/js/adminlte.min.js'?>"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="<?php echo base_url().'assets/dist/js/demo.js'?>"></script>
        <!-- Page script -->
        <script type="text/javascript">
            $(document).ready(function () {
                bsCustomFileInput.init();
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function(){
                //call function get data edit
                get_data_edit();

                /*get_enquiry_product_data();*/
                //load data for edit
                function get_data_edit(){
                    var entity_id = $('[name="entity_id"]').val();
                    
                    $.ajax({
                        url : "<?php echo site_url('support/enquiry_register/get_enquiry_details_by_id');?>",
                        method : "POST",
                        data :{entity_id :entity_id},
                        async : true,
                        dataType : 'json',
                        success : function(data){
                            $.each(data, function(i, item){
                                console.log(data);
                                $val =
                                $('[name="enquiry_number"]').val(data[i].enquiry_no);
                                $('[name="enquiry_descrption"]').val(data[i].enquiry_long_desc);
                                $('[name="enquiry_type"]').val(data[i].enquiry_type).trigger('change');
                                $('[name="enquiry_source"]').val(data[i].enquiry_source).trigger('change');
                                $('[name="enquiry_urgency"]').val(data[i].enquiry_urgency).trigger('change');
                                if (data[i].enquiry_status == 1)
                                    $('#enquiry_form').find(':radio[name=enquiry_status][value="1"]').prop('checked', true);

                                if (data[i].enquiry_status == 4)
                                    $('#enquiry_form').find(':radio[name=enquiry_status][value="4"]').prop('checked', true);

                                if (data[i].enquiry_status == 8)
                                    $('#enquiry_form').find(':radio[name=enquiry_status][value="8"]').prop('checked', true);

                                $('[name="employee_attachment"]').val(data[i].attachment);
                            });
                        }
                    });
                }

                /*function get_enquiry_product_data(){
                    var entity_id = $('[name="entity_id"]').val();
                    
                    $.ajax({
                        url : "<?php echo site_url('support/enquiry_register/get_enquiry_product_by_id');?>",
                        method : "POST",
                        data :{entity_id :entity_id},
                        async : true,
                        dataType : 'json',
                        success : function(data){
                            var Values = new Array();
                            $.each(data, function(i, item){
                                console.log(data);
                                $val = 
                                Values.push(data[i].product_id);  
                            });

                            $("#enquiry_product").val(Values).trigger('change');
                        }
                    });
                }*/
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

        <script type="text/javascript">
            function showR(){
               document.getElementById('Rejection_reason_form').style.display = "block";
            }

            function hideR(){
                $('#Rejection_reason_form').hide();  
            }
        </script>
    </body>
</html>

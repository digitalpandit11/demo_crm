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
        <title>View Enquiry Details</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/fontawesome-free/css/all.min.css'?>">
        <!-- Data Tables -->
        <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css'?>">
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
            <?php 
                
                $enquiry_id = $entity_id;

                $this->db->select('*');
                $this->db->from('enquiry_tracking_master');
                $where = '(enquiry_tracking_master.enquiry_id = "'.$entity_id.'" )';
                $this->db->where($where);
                $enquiry_tracking_master = $this->db->get();
                $enquiry_tracking_master_result = $enquiry_tracking_master->result();

                $this->db->select('*');
                $this->db->from('enquiry_register');
                $where = '(enquiry_register.entity_id = "'.$entity_id.'" )';
                $this->db->where($where);
                $enquiry_register = $this->db->get();
                $enquiry_register_result = $enquiry_register->row_array();

                $rejection_reason = $enquiry_register_result['enquiry_rejected_reason'];

                $this->db->select('*');
                $this->db->from('offer_register');
                $where = '(offer_register.enquiry_id = "'.$enquiry_id.'" )';
                $this->db->where($where);
                $this->db->order_by('offer_register.entity_id', 'DESC');
                $this->db->limit(1);
                $query_data = $this->db->get();
                $query_result = $query_data->row_array();

                if(!empty($query_result))
                {
                    $offer_id = $query_result['entity_id'];
                    $offer_no = $query_result['offer_no'];
                    $offer_date = $query_result['offer_date'];

                    $offer_value = $query_result['offer_value'];

                    $rejection_reason = $query_result['reason_for_rejection'];

                    $this->db->select('*');
                    $this->db->from('sales_order_register');
                    $where = '(sales_order_register.offer_id = "'.$offer_id.'" )';
                    $this->db->where($where);
                    $this->db->order_by('sales_order_register.entity_id', 'DESC');
                    $this->db->limit(1);
                    $sales_order_register_data = $this->db->get();
                    $sales_order_register_result = $sales_order_register_data->row_array();

                    if(!empty($sales_order_register_result))
                    {
                        $order_id = $sales_order_register_result['entity_id'];
                        $order_no = $sales_order_register_result['sales_order_no'];
                        $order_date = $sales_order_register_result['sales_order_date'];
                        $rejection_reason = $query_result['reason_for_rejection'];
                    }else{
                        $order_id = "";
                        $order_no = "";
                        $order_date = "";
                    }
                }else{
                    $offer_id = "";
                    $offer_no = "";
                    $offer_date = "";
                    $order_id = "";
                    $order_no = "";
                    $order_date = "";
                    $offer_value = "";
                } 


            ?>
                <div class="content-wrapper">
                    <!-- Content Wrapper. Contains page content -->
                    <section class="content-header">
                        <div class="container-fluid">
                            <br>
                            <!-- <div class="card" style="background-color: #20c997;"> -->
                            <div class="card">
                                <div class="card-header" >
                                    <h1 class="card-title">View Enquiry Details</h1>
                                    <div class="col-sm-6">
                                        <br><br>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'vw_all_enquiry_to_order_status'?>">Enquiry To Order Register</a></li>
                                            <li class="breadcrumb-item">View Enquiry Details Of Id :- <?php  echo $entity_id; ?> </li>
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
                                            <form role="form" name="enquiry_form" enctype="multipart/form-data" action="<?php echo site_url('sales/enquiry_register/view');?>" method="post">
                                                
                                                <input type="hidden" id="entity_id" name="entity_id" value="<?php echo $entity_id?>" required>

                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Enquiry Number </label>
                                                            <input type="text" name="enquiry_number" id="enquiry_number" class="form-control" size="50" placeholder="Enter Enquiry Number" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Enquiry Date </label>
                                                            <input type="date" name="enquiry_date" id="enquiry_date" class="form-control" size="50" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Offer Number </label>
                                                            <input type="text" name="offer_number" id="offer_number" class="form-control" size="50" placeholder="Enter Offer Number" value="<?php echo $offer_no; ?>" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Offer Date </label>
                                                            <input type="date" name="offer_date" id="offer_date" class="form-control" value="<?php echo $offer_date; ?>" size="50" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Customer Name *</label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="customer_name" name="customer_name" disabled>
                                                                <option value="">No Selected</option>
                                                                <?php foreach($customer_list as $row):?>
                                                                <option value="<?php echo $row->entity_id;?>"><?php echo $row->customer_name;?></option>
                                                                <?php endforeach;?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label> Order Number </label>
                                                            <input type="text" name="order_number" id="order_number" class="form-control" size="50" placeholder="Enter Order Number" value="<?php echo $order_no; ?>" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label> Order Date </label>
                                                            <input type="date" name="order_dayte" id="order_dayte" class="form-control" size="50" value="<?php echo $order_date; ?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <?php if(!empty($offer_value)) {?>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label> Offer Value </label>
                                                            <input type="text" name="offer_value" id="offer_value" class="form-control" size="50" placeholder="Enter Offer Value" value="<?php echo $offer_value; ?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>

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
                                                                            <input type="text" name="enquiry_contact_person" id="enquiry_contact_person" class="form-control" size="50" placeholder="Customer Contact Person" readonly>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label> Customer Email Id </label>
                                                                            <input type="text" name="enquiry_email_id" id="enquiry_email_id" class="form-control" size="50" placeholder="Customer Email Id" readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-3">
                                                                        <div class="form-group">
                                                                            <label> Customer Contact Number </label>
                                                                            <input type="text" name="enquiry_contact_number" id="enquiry_contact_number" class="form-control" size="50" placeholder="Customer Contact Number" readonly>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-3">
                                                                        <div class="form-group">
                                                                            <label> Customer State </label>
                                                                            <input type="text" name="enquiry_customer_state" id="enquiry_customer_state" class="form-control" size="50" placeholder="Customer State" readonly>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-3">
                                                                        <div class="form-group">
                                                                            <label> Customer City </label>
                                                                            <input type="text" name="enquiry_customer_city" id="enquiry_customer_city" class="form-control" size="50" placeholder="Customer City" readonly>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-3">
                                                                        <div class="form-group">
                                                                            <label> State Code </label>
                                                                            <input type="text" name="enquiry_state_code" id="enquiry_state_code" class="form-control" size="50" placeholder="State Code" readonly>
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
                                                            <label style="color: #FF0000;"> Enquiry Description *</label>
                                                            <textarea class="form-control" id="enquiry_descrption" name="enquiry_descrption" rows="3" placeholder="Enter Enquiry Description" readonly></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Select Employee *</label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="employee_id" name="employee_id" disabled>
                                                                <option value="">No Selected</option>
                                                                <?php foreach($employee_list as $row):?>
                                                                <option value="<?php echo $row->entity_id;?>"><?php echo $row->Emp_name;?></option>
                                                                <?php endforeach;?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Enquiry Type *</label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="enquiry_type" name="enquiry_type" disabled>
                                                                <option value="">Select</option>
                                                                <option value="1">Pull Cord (MH)</option>
                                                                <option value="2">Porximity (PS)</option>
                                                                <option value="3">Vibrator Control (VC)</option>
                                                                <option value="4">Treading (TD)</option>    
                                                                <option value="5">Other (OT)</option>
                                                                <option value="6">CUH & TD-MH</option>
                                                                <option value="7">TD-PS</option>
                                                                <option value="8">TD-VC</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Enquiry Source *</label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="enquiry_source" name="enquiry_source" disabled>
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
                                                            <label style="color: #FF0000;"> Enquiry Urgency *</label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="enquiry_urgency" name="enquiry_urgency" disabled>
                                                                <option value="">Select</option>
                                                                <option value="1">Cold Call </option>
                                                                <option value="2">Live Enquiry / Budgatory</option>
                                                                <option value="3">Hot Lead</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Enquiry Status </label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="enquiry_status" name="enquiry_status" disabled>
                                                                <option value="">Select</option>
                                                                <option value="1">Pending</option>
                                                                <option value="2">Offer Created</option>
                                                                <option value="3">Order Created</option>
                                                                <option value="4">Lose</option>
                                                                <option value="5">Offer Loss</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                             <label > Rejection Reason </label>
                                                            <textarea class="form-control" id="enquiry_rejection" name="enquiry_rejection" rows="3" placeholder="Enter Enquiry Rejection Reason" readonly><?php echo $rejection_reason; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <!-- general form elements disabled -->
                                                        <div class="card card-primary">
                                                            <div class="card-header">
                                                                <h3 class="card-title">Enquiry Tracking Details</h3>
                                                            </div>
                                                            <div class="card-body">
                                                                <div  class="table-responsive">
                                                                    <table id="example1" class="table table-bordered table-striped">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Sr. No.</th>
                                                                                <th>Tracking Number</th>
                                                                                <th>Tracking Date</th>
                                                                                <th>Tracking Description</th>
                                                                                <th>Tracking Next Action Date</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                                $no = 0;
                                                                                foreach ($enquiry_tracking_master_result as $row):
                                                                                    $no++;
                                                                                    $entity_id = $row->entity_id;
                                                                            ?>
                                                                            <tr>
                                                                                <td><?php echo $no;?></td>
                                                                                <td><?php echo $row->tracking_number;?></td>
                                                                                <td><?php echo date("d-m-Y", strtotime($row->tracking_date));?></td>
                                                                                <td><?php echo $row->tracking_record;?></td>
                                                                                <td><?php echo date("d-m-Y", strtotime($row->action_due_date));?></td>
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
        <!-- DataTables -->
        <script src="<?php echo base_url().'assets/plugins/datatables/jquery.dataTables.js'?>"></script>
        <script src="<?php echo base_url().'assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js'?>"></script>
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

                //load data for edit
                function get_data_edit(){
                    var entity_id = $('[name="entity_id"]').val();
                    
                    $.ajax({
                        url : "<?php echo site_url('sales/enquiry_register/get_enquiry_details_by_id');?>",
                        method : "POST",
                        data :{entity_id :entity_id},
                        async : true,
                        dataType : 'json',
                        success : function(data){
                            $.each(data, function(i, item){
                                console.log(data);
                                $val =
                                $('[name="enquiry_number"]').val(data[i].enquiry_no);
                                $('[name="enquiry_date"]').val(data[i].enquiry_date);
                                $('[name="customer_name"]').val(data[i].customer_id).trigger('change');
                                $('[name="employee_id"]').val(data[i].emp_id).trigger('change');
                                $('[name="enquiry_descrption"]').val(data[i].enquiry_short_desc);
                                $('[name="enquiry_type"]').val(data[i].enquiry_type).trigger('change');
                                $('[name="enquiry_source"]').val(data[i].enquiry_source).trigger('change');
                                $('[name="enquiry_urgency"]').val(data[i].enquiry_urgency).trigger('change');
                                $('[name="enquiry_status"]').val(data[i].enquiry_status).trigger('change');
                                $('[name="employee_attachment"]').val(data[i].attachment);
                            });
                        }
                    });
                }
            });
        </script>
        <script type="text/javascript">
            //load data for edit
            $('#customer_name').change(function(){
                var id=$(this).val();
                $.ajax({
                    url : "<?php echo site_url('sales/enquiry_register/get_all_customer_data');?>",
                    method : "POST",
                    data : {id: id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        $.each(data, function(i, item){
                            console.log(data);
                            $val = 
                            $('[name="enquiry_contact_person"]').val(data[i].contact_person);
                            $('[name="enquiry_email_id"]').val(data[i].email_id);
                            $('[name="enquiry_contact_number"]').val(data[i].first_contact_no);
                            $('[name="enquiry_customer_state"]').val(data[i].state_name);
                            $('[name="enquiry_customer_city"]').val(data[i].city_name);
                            $('[name="enquiry_state_code"]').val(data[i].state_code);
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
    </body>
</html>

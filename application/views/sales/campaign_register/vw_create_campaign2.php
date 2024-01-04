<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
if(!$_SESSION['user_name'])
{
   header("location:dashboard");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Select Clients For Campaign</title>
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
            <!-- Navbar -->
            <?php
             $this->load->view('header_sidebar');

             $state_list= $this->db->select('*')->from('state_master')->get()->result();
            ?>
            <!-- <?php
                $first_date_of_month = date("Y-m-01");
                $end_date_of_month = date("Y-m-t");
            ?> -->
            <!-- /.navbar -->
            <!-- Main Sidebar Container -->  
            <div class="content-wrapper">
                <!-- Content Wrapper. Contains page content -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="card">
                            <div class="card-header" >
                                <h1 class="card-title">Create Campaign (v2.0)</h1>
                                <div class="col-sm-6">
                                    <br><br>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                                        <li class="breadcrumb-item"><a href="<?php echo base_url().'vw_campaign'?>">Campaign Register</a>
                                        </li>
                                        <li class="breadcrumb-item">Create Campaign</li>
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
                                        <h3 class="card-title">All Tele-Phone Lists </h3>
                                    </div>
                                    <div class="card-body" style="border-radius: 1.25rem;">
                                        <form role="form" name="sales_register_report" action="<?php echo site_url('sales/campaign_register/save_campaign2');?>" method="post">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <label> Campaign Number</label>
                                                            <input type="text" name="campaign_number" id="campaign_number" class="form-control" size="50" value= "<?php echo $campaign_number; ?>" placeholder="Enter Campaign Number" required readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Campaign Name <span style="color: #FF0000;">* Mandatory Field</span></label>
                                                            <input type="text" name="campaign_name" id="campaign_name" class="form-control" size="50" placeholder="Enter Campaign Name" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <label> Assigne To <span style="color: #FF0000;">* Mandatory Field</span></label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="compaign_assign" name="compaign_assign" required>
                                                                <option value="">Selected Employee</option>
                                                                <?php 
                                                                    foreach($employee_list as $emp):?>
                                                                        <option value="<?php echo $emp->entity_id;?>"><?php echo $emp->emp_first_name;?></option>
                                                                <?php
                                                                    endforeach;
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <label> Start Date <span style="color: #FF0000;">* Mandatory Field</span></label>
                                                            <input type="date" name="start_date" id="start_date" class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <label> End Date <span style="color: #FF0000;">* Mandatory Field</span></label>
                                                            <input type="date" name="end_date" id="end_date" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                
                                            </div>
                                            <input type="submit"  class="btn btn-primary" value="Save & upload numbers" name="submit">
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
        <!-- import conntact -->
        <div class="modal fade" id="importModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Upload Csv file</h4>
                    </div>
                    <div class="modal-body">
                        <form role="form" name="client_info" action="<?php echo site_url('sales/campaign_register/uploadData');?>" method="post" enctype="multipart/form-data">

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="text" name="campaign_number" id="campaign_number" class="filestyle" value = "<?php echo $campaign_number ;?>" data-icon="false" readonly>
                                </div>
                            </div> 

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="file" name="file" id="file" class="filestyle" data-icon="false">
                                </div>
                            </div> 

                            <div class="col-lg-12">
                                <input type='submit' value='Upload' name='upload'>
                            </div> 
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div> 
            </div>
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


        <script>

            $(document).on('click', '#add_address', function () {

                var address = $("#address").val();
                var state_id = $("#state_id").val();
                var city_id = $("#city_id").val();
                var customer_pin_code = $("#customer_pin_code").val();
                var state_code = $("#state_code").val();
                var customer_gst_number = $("#customer_gst_number").val();
                var customer_pan_number = $("#customer_pan_number").val();
                var designation = $("#contact_person_designation").val();
                var contact_person = $("#contact_person").val();
                var contact_person_email_id = $("#contact_person_email_id").val();
                var first_contact_no = $("#first_contact_no").val();
                var second_contact_no = $("#second_contact_no").val();
                var whatsup_no = $("#whatsup_no").val();
                var customer_name = $("#pop_up_customer_name").val();
                var customer_type = $("#customer_type").val();
                
                if(designation != "" && address != "" && state_id != "" && city_id != "" && state_code != "" && contact_person != "" && contact_person_email_id != "" && first_contact_no != "" && customer_name != "" && customer_type != "")
                {
                    $.ajax({
                            url : "<?php echo site_url('master/customer_master/save_customer_data');?>",
                            type : "POST",
                            data: {'designation': designation , 'address': address , 'state_id': state_id , 'city_id': city_id , 'customer_pin_code': customer_pin_code , 'state_code': state_code , 'customer_gst_number': customer_gst_number , 'customer_pan_number': customer_pan_number , 'contact_person': contact_person , 'contact_person_email_id': contact_person_email_id , 'first_contact_no': first_contact_no , 'second_contact_no': second_contact_no , 'whatsup_no': whatsup_no , 'customer_name': customer_name , 'customer_type': customer_type},
                            success : function(data) {
                                data = data.trim();
                                location.reload(true);
                            },
                            error : function(data) {
                                alert("Failed!!");
                            }
                    });
                }else{
                    alert("Enter All Details");
                }
            });
            /*$(function () {
                $("#example1").DataTable();
                $('#example1').DataTable({
                  "paging": true,
                  "lengthChange": false,
                  "pageLength": 50,
                  "searching": false,
                  "ordering": true,
                  "info": true,
                  "autoWidth": false,
                });
            });*/
            
        </script> 

        <script type="text/javascript">
            $(document).ready(function(){
                $("#selectall").click(function(){
                    if(this.checked){
                        $('.checkboxes').each(function(){
                            $(".checkboxes").prop('checked', true);
                        })
                    }else{
                        $('.checkboxes').each(function(){
                            $(".checkboxes").prop('checked', false);
                        })
                    }
                });
            });
        </script>

        <script type="text/javascript">
            function change_customer(item)
            {
               var india_mart_id = $(item).closest('tr').find('.relation_id').text();
               var customer_id = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('indiamart_api/update_customer_id');?>",
                    method : "POST",
                    data : {'customer_id': customer_id,
                            'india_mart_id': india_mart_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        //location.reload();
                    }
                });
                return false;
            }

            function change_status(item)
            {
               var india_mart_id = $(item).closest('tr').find('.relation_id').text();
               var status = item.value;
               
                $.ajax({
                    url : "<?php echo site_url('indiamart_api/update_indiamart_lead_status');?>",
                    method : "POST",
                    data : {'status': status,
                            'india_mart_id': india_mart_id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        //location.reload();
                    }
                });
                return false;
            }
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
            $(document).ready(function(){
         
                $('#pop_up_customer_name').change(function(){ 
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
                            $("#pop_up_customer_name").val('');
                        }
                    });
                return false;
            });     
            });
        </script>

        <script>
            var table = $('#example1').dataTable( {
                "pageLength": 50
            } );

            $(function()
            {
                $("#select_telephone_list").on('click', function(event)
                {
                    $("#select_telephone_list").attr("disabled", true);
                    var cmp_name=$('#campaign_name').val();
                    var assign=$('#compaign_assign').val();
                    var start=$('#start_date').val();
                    var end=$('#end_date').val();

                     if(!cmp_name){
                        alert("Please Enter Campaign Name");
                        $("#select_telephone_list").removeAttr("disabled", true);
                    } else if(!assign){
                        alert("Please Assign A Campaign");
                        $("#select_telephone_list").removeAttr("disabled", true);
                    }
                    else{
                        var list_id = table.$('input[type="checkbox"]').serializeArray();
                        console.log(list_id);
                        
                        if(list_id.length == 0){
                            alert('Please Choose At Least Onle Tele-Phone List');
                        }else{
                            $.ajax({
                                url:"<?php echo site_url('sales/campaign_register/create_campaign');?>",
                                type: 'POST',
                                data: {'list_id': list_id,'cmp_name':cmp_name,'assign':assign,'start':start,'end':end},
                                success: function(data){
                                    console.log(data);
                                    window.location.href='<?php base_url();?>vw_campaign';
                                },
                                error: function(){
                                   alert("Fail");
                                }
                            });
                        }
                    }
                });
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
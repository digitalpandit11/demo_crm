<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
if(!$_SESSION['user_name'])
{
   header("location:welcome");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Update Product Master</title>
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
    </head>
    <body class="hold-transition sidebar-mini">
        <div class="wrapper">
            <!-- Navbar -->
            <?php $this->load->view('header_sidebar');?>
                <!-- /.navbar -->
                <!-- Main Sidebar Container -->  
                <div class="content-wrapper">
                    <!-- Content Wrapper. Contains page content -->
                    <section class="content-header">
                        <div class="container-fluid">
                            <!-- <div class="card" style="background-color: #20c997;"> -->
                            <div class="card">
                                <div class="card-header" >
                                    <h1 class="card-title">Update Product Master</h1>
                                    <div class="col-sm-6">
                                        <br><br>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'product_master'?>">Product Master</a></li>
                                            <li class="breadcrumb-item">Update Product Master Of Id :- <?php  echo $entity_id ?> </li>
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
                                            <h3 class="card-title">Update Product Master Form</h3>
                                        </div>
                                        <div class="card-body">
                                            <form role="form" name="product_master" action="<?php echo site_url('master/product_master/update_product_master');?>" method="post">

                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;">Part Code Number *</label>
                                                            <input type="text" class="form-control" name="product_id" id="product_id" placeholder="Enter Part Code Number" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Product Name *</label>
                                                            <textarea class="form-control" id="product_name" name="product_name" rows="3" placeholder="Enter Product Name" required></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;">HSN Code *</label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="hsn_code" name="hsn_code" required>
                                                                <option value="">No Selected</option>
                                                                <?php foreach($product_hsn_code as $row):?>
                                                                <option value="<?php echo $row->entity_id;?>"><?php echo $row->hsn_code;?></option>
                                                                <?php endforeach;?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Product Make*</label>
                                                            <select name="product_make" id="product_make" class="form-control select2bs4" required="required">
                                                                <option value="">Select Make</option>
                                                                <?php
                                                                    foreach($make_list as $make){ ?>
                                                                    <option value="<?php echo $make->entity_id;?>"><?php echo $make->make_name;?></option>
                                                                <?php } ?>
                                                             </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;">Category *</label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="category_id" name="category_id" required>
                                                                <option value="">No Selected</option>
                                                                <?php foreach($product_category as $row):?>
                                                                <option value="<?php echo $row->entity_id;?>"><?php echo $row->category_name;?></option>
                                                                <?php endforeach;?>
                                                            </select>
                                                        </div>
                                                    </div>


                                                    <div style="display: none;" class="col-sm-4">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;"> Product Long Description * </label>
                                                            <textarea class="form-control" id="product_long_desc" name="product_long_desc" rows="3" placeholder="Enter Product Long Description"></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>Warranty</label>
                                                            <!-- <input type="text" name="product_warranty" id="product_warranty" class="form-control" placeholder="Enter Product Warranty"> -->
                                                            <select class="form-control select2bs4" style="width: 100%;" id="product_warranty" name="product_warranty">
                                                                <option value="">Select Product Warranty</option>
                                                                <option value="1 year">1 Year</option>
                                                                <option value="3 year">3 Year</option>
                                                                <option value="5 year">5 Year</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;">Unit *</label>
                                                            <!-- <select class="form-control select2bs4" style="width: 100%;" id="product_unit" name="product_unit" required>
                                                                <option value="">No Selected</option>
                                                                <option value="No's">No's</option>
                                                                <option value="KG">KG</option>
                                                                <option value="Ltr's">Ltr's</option>
                                                                <option value="Gram's">Gram's</option>
                                                            </select> -->
                                                            <select class="form-control select2bs4" style="width: 100%;" id="product_unit" name="product_unit" required>
                                                                <option value="">No Selected</option>
                                                                <?php foreach($unit_list as $row):?>
                                                                <option value="<?php echo $row->entity_id;?>"><?php echo $row->unit_name;?></option>
                                                                <?php endforeach;?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label style="color: #FF0000;">Selling Price *</label>
                                                            <input type="text" name="product_price" id="product_price" class="form-control" placeholder="Enter Product Price" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label> Internal Remark </label>
                                                            <textarea class="form-control" id="internal_remark" name="internal_remark" rows="3" placeholder="Enter Product Long Description"></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-4">
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label>Product Status</label>
                                                            <select class="form-control select2bs4" style="width: 100%;" id="product_status" name="product_status">
                                                                <option value="">No Selected</option>
                                                                <option value="1">Active</option>
                                                                <option value="2">Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <input type="hidden" name="entity_id" value="<?php echo $entity_id?>" required>

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
        <!-- AdminLTE App -->
        <script src="<?php echo base_url().'assets/dist/js/adminlte.min.js'?>"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="<?php echo base_url().'assets/dist/js/demo.js'?>"></script>
        <!-- Page script -->
        <script type="text/javascript">
            $(document).ready(function(){
                //call function get data edit
                get_data_edit();

                //load data for edit

                function get_data_edit(){
                    var entity_id = $('[name="entity_id"]').val();
                    
                    $.ajax({
                        url : "<?php echo site_url('master/product_master/get_product_master_data');?>",
                        method : "POST",
                        data :{entity_id :entity_id},
                        async : true,
                        dataType : 'json',
                        success : function(data){
                            $.each(data, function(i, item){
                                console.log(data);
                                $val =
                                $('[name="category_id"]').val(data[i].category_id).trigger('change');
                                /*$('[name="sub_category_id"]').val(data[i].subcategory_id).trigger('change');*/
                                $('[name="product_id"]').val(data[i].product_id);
                                $('[name="product_name"]').val(data[i].product_name);
                                $('[name="product_short_desc"]').val(data[i].product_short_description);
                                $('[name="product_make"]').val(data[i].product_make).trigger('change');
                                $('[name="internal_remark"]').val(data[i].internal_remark);
                                $('[name="product_long_desc"]').val(data[i].product_long_description);
                                $('[name="product_type"]').val(data[i].product_type).trigger('change');                               
                                $('[name="product_sourcing_type"]').val(data[i].sourcing_type).trigger('change');
                                $('[name="product_warranty"]').val(data[i].warrenty).trigger('change');
                                $('[name="product_weight"]').val(data[i].weight);
                                $('[name="product_dimension"]').val(data[i].dimensions);
                                $('[name="product_unit"]').val(data[i].unit).trigger('change');
                                $('[name="product_price_type"]').val(data[i].price_type).trigger('change');
                                $('[name="product_qc_status"]').val(data[i].qc_applicable).trigger('change');
                                $('[name="product_inspection_applicable"]').val(data[i].insp_applicable).trigger('change');
                                $('[name="product_bom_applicable"]').val(data[i].bom_applicable).trigger('change');
                                $('[name="product_lead_time"]').val(data[i].typical_lead_time);
                                $('[name="product_minimum_stock"]').val(data[i].minimum_stock_qty);
                                $('[name="product_maximum_stock"]').val(data[i].maximum_stock_qty);
                                $('[name="hsn_code"]').val(data[i].hsn_id).trigger('change');
                                $('[name="product_status"]').val(data[i].status).trigger('change');
                                $('[name="product_price"]').val(data[i].product_price);
                            });
                        }
                    });
                }

                $('#category_id').change(function(){ 
                    var id=$(this).val();
                    $.ajax({
                            url : "<?php echo site_url('master/product_master/get_sub_category');?>",
                            method : "POST",
                            data : {id: id},
                            async : true,
                            dataType : 'json',
                            success: function(data){
                                 
                                var html = '';
                                var i;
                                for(i=0; i<data.length; i++){
                                    html += '<option value='+data[i].entity_id+'>'+data[i].subcategory_name+'</option>';
                                }
                                $('#sub_category_id').html(html);
                            }
                            
                            /*success: function(response){
                                $.each(response,function(index,data){
                                   $('#sub_category_id').append('<option value="'+data['entity_id']+'">'+data['subcategory_name']+'</option>');
                                });
                            }*/
                        });
                    return false;
                });
            });
        </script>

        <script>
            $(function () 
            {
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

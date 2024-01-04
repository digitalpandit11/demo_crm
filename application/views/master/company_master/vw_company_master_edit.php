<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Edit Company Master Form</title>
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
         <?php $this->load->view('header_sidebar');?>
         <!-- /.navbar -->
         <!-- Main Sidebar Container -->  
         <div class="content-wrapper">
            <!-- Content Wrapper. Contains page content -->
            <section class="content-header">
               <div class="container-fluid">
                  <br>
                  <!-- <div class="card" style="background-color: #20c997;"> -->
                  <div class="card">
                     <div class="card-header" >
                        <h1 class="card-title">Company Master</h1>
                        <div class="col-sm-6">
                           <br><br>
                           <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                              <li class="breadcrumb-item"><a href="<?php echo base_url().'company_master'?>">Company Master</a></li>
                              <li class="breadcrumb-item">Edit Company Details</li>
                           </ol>
                        </div>
                     </div>
                  </div>
                  <!-- <div class="row mb-2">
                     <div class="col-sm-6">
                         <h1>Advanced Form</h1>
                        
                     </div> -->
                  <!-- <div class="col-sm-6">
                     <ol class="breadcrumb float-sm-right">
                         <li class="breadcrumb-item"><a href="#">Home</a></li>
                         <li class="breadcrumb-item active">Advanced Form</li>
                     </ol>
                     </div> -->
                  <!-- </div> -->
               </div>
            </section>
            <section class="content">
               <div class="container-fluid">
                  <div class="row">
                     <div class="col-md-12">
                        <!-- general form elements disabled -->
                        <div class="card card-primary">
                           <div class="card-header">
                              <h3 class="card-title">Company Master Form</h3>
                           </div>
                           <div class="card-body">
                              <form role="form" name="client_info" enctype="multipart/form-data" action="<?php echo site_url('master/company_master/update_employee_master');?>" method="post">
                                 <div class="row">
                                    <div class="col-sm-4">
                                       <div class="form-group">
                                          <label>Company Name</label>
                                          <input type="text" name="company_name" id="company_name" class="form-control" placeholder="Company Name">
                                       </div>
                                    </div>
                                    <div class="col-sm-4">
                                       <div class="form-group">
                                          <label for="company_logo">Company logo</label>
                                          <div class="input-group">
                                             <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="company_logo" id="company_logo">
                                                <label class="custom-file-label" for="company_logo">Choose Company Logo</label>
                                             </div>
                                          </div>
                                          <a href="<?php echo base_url();?>assets/<?php echo $company_logo; ?>">
                                             <p><?php echo $company_logo;?></p>
                                          </a>
                                       </div>
                                    </div>
                                    <div class="col-sm-4">
                                       <div class="form-group">
                                          <label>Address</label>
                                          <textarea name="address" id="address" class="form-control" rows="2" placeholder="Enter Address"></textarea>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-sm-3">
                                       <div class="form-group">
                                          <label>State Name</label>
                                          <select class="form-control select2bs4" style="width: 100%;" id="state_id" name="state_id" required>
                                             <option value="">No Selected</option>
                                             <?php foreach($state_name as $row):?>
                                             <option value="<?php echo $row->entity_id;?>"><?php echo $row->state_name;?></option>
                                             <?php endforeach;?>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="col-sm-3">
                                       <div class="form-group">
                                          <label>City Name</label>
                                          <select class="form-control select2bs4" style="width: 100%;" id="city_id" name="city_id" required>
                                             <option value=""></option>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="col-sm-3">
                                       <div class="form-group">
                                          <label>PIN Code</label>
                                          <input type="text" name="pin_code" id="pin_code" class="form-control" placeholder="PIN Code">
                                       </div>
                                    </div>
                                    <div class="col-sm-3">
                                       <div class="form-group">
                                          <label>State Code</label>
                                          <input type="text" name="state_code" id="state_code" class="form-control" placeholder="State Code">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-sm-4">
                                       <div class="form-group">
                                          <label>Phone No</label>
                                          <input type="text" name="phone_no" id="phone_no" class="form-control"   placeholder="Phone No">
                                       </div>
                                    </div>
                                    <div class="col-sm-4">
                                       <div class="form-group">
                                          <label>Mobile No</label>
                                          <input type="text" name="mobile_no" id="mobile_no" class="form-control" placeholder="Mobile No">
                                       </div>
                                    </div>
                                    <div class="col-sm-4">
                                       <div class="form-group">
                                          <label>Email</label>
                                          <input type="email" name="email_id" id="email_id" class="form-control" placeholder="Email">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-sm-4">
                                       <div class="form-group">
                                          <label>GST No</label>
                                          <input type="text" name="gst_no" id="gst_no" class="form-control" placeholder="GST No">
                                       </div>
                                    </div>
                                    <div class="col-sm-4">
                                       <div class="form-group">
                                          <label>Bank Name</label>
                                          <input type="text" name="bank_name" id="bank_name" class="form-control" placeholder="Bank Name">
                                       </div>
                                    </div>
                                    <div class="col-sm-4">
                                       <div class="form-group">
                                          <label>Branch Name</label>
                                          <input type="text" name="branch_name" id="branch_name" class="form-control" placeholder="Branch Name">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-sm-4">
                                       <div class="form-group">
                                          <label>Bank IFSC Code</label>
                                          <input type="text" name="bank_ifsc_code" id="bank_ifsc_code" class="form-control" placeholder="Bank IFSC Code">
                                       </div>
                                    </div>
                                    <div class="col-sm-4">
                                       <div class="form-group">
                                          <label>Bank Account No</label>
                                          <input type="text" name="bank_account_no" id="bank_account_no" class="form-control" placeholder="Bank Account No">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-sm-4" style="display: none;">
                                    <div class="form-group">
                                       <label>Bank Account No</label>
                                       <input type="text" name="entity_id" id="entity_id" class="form-control" value="<?php echo $entity_id; ?>" placeholder="Bank Account No">
                                    </div>
                                 </div>
                                 <div class="col-sm-4" style="display: none;">
                                    <div class="form-group">
                                       <label>Bank Account No</label>
                                       <input type="text" name="state_id_new" id="state_id_new" class="form-control" value="<?php echo $state_id; ?>" placeholder="Bank Account No">
                                    </div>
                                 </div>
                                 <div class="col-sm-4" style="display: none;">
                                    <div class="form-group">
                                       <label>Bank Account No</label>
                                       <input type="text" name="city_id" id="city_id" class="form-control" value="<?php echo $city_id; ?>" placeholder="Bank Account No">
                                    </div>
                                 </div>
                                 <div class="card-body">
                                    <button type="submit" class="btn btn-success toastrDefaultSuccess">
                                    Submit
                                    </button>
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
      <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
      <!-- bs-custom-file-input -->
      <script src="<?php echo base_url().'assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js'?>"></script>
      <!-- AdminLTE App -->
      <script src="<?php echo base_url().'assets/dist/js/adminlte.min.js'?>"></script>
      <!-- AdminLTE for demo purposes -->
      <script src="<?php echo base_url().'assets/dist/js/demo.js'?>"></script>
      <script type="text/javascript">
         $(document).ready(function () {
           bsCustomFileInput.init();
         });
      </script>
      <!-- Page script -->
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
      <script type="text/javascript">
         $(document).ready(function(){
                 //call function get data edit
                 get_data_edit();
           //load data for edit
                 function get_data_edit(){
                     var entity_id = $('[name="entity_id"]').val();
                     $.ajax({
                         url : "<?php echo site_url('master/company_master/get_data_edit');?>",
                         method : "POST",
                         data :{entity_id :entity_id},
                         async : true,
                         dataType : 'json',
                         success : function(data){
                             $.each(data, function(i, item){
                                 console.log(data);
                                 $val =$('[name="company_name"]').val(data[i].company_name);
                                 $val =$('[name="pin_code"]').val(data[i].pin_code);
                                 $('[name="address"]').val(data[i].address); 
                                 $('[name="phone_no"]').val(data[i].phone_no); 
                                 $('[name="mobile_no"]').val(data[i].mobile_no); 
                                 $('[name="email_id"]').val(data[i].email_id); 
                                 $('[name="gst_no"]').val(data[i].gst_no); 
                                 $('[name="state_code"]').val(data[i].state_code); 
                                 $('[name="bank_name"]').val(data[i].bank_name);
                                 $('[name="branch_name"]').val(data[i].branch_name);
                                 $('[name="bank_ifsc_code"]').val(data[i].bank_ifsc_code);
                                 $('[name="bank_account_no"]').val(data[i].bank_account_no); 
                                 $('[name="state_id"]').val(data[i].state_id).trigger('change');
                                 $('[name="city_id"]').val(data[i].city_id).trigger('change');
                                 
                             });
                         }
         
                     });
                 }
         
               $('#state_id').change(function(){ 
               var id=$(this).val();
               var city_id = "<?php echo $city_id;?>";
               // alert(vehicle_model_id);
               $.ajax({
                   url : "<?php echo site_url('master/company_master/select_city_id_edit');?>",
                   method : "POST",
                   data : {id: id},
                   async : true,
                   dataType : 'json',
                   success: function(data){
                     console.log();
                       $('select[name="city_id"]').empty();
         
                       $.each(data, function(key, value) {
                           if(city_id==value.entity_id){
                               $('select[name="city_id"]').append('<option value="'+ value.entity_id +'" selected>'+ value.city_name +'</option>').trigger('change');
                           }else{
                               $('select[name="city_id"]').append('<option value="'+ value.entity_id +'">'+ value.city_name +'</option>');
                           }
                       });
         
                   }
               });
               return false;
           });
         });
         
         
      </script>
   </body>
</html>

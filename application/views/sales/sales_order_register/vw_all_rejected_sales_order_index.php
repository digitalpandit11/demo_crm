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
        <title>Sales Order Register</title>
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
                            <div class="card">
                                <div class="card-header" >
                                    <h1 class="card-title">Rejected Sales Order Register</h1>
                                    <div class="col-sm-6">
                                        <br><br>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'vw_sales_order_data'?>">Sales Order Register</a>
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
                                            <h3 class="card-title">Sales Order Register</h3>
                                        </div>
                                        <div>
                                            <div class="btn-group" style="margin-top: 15px; margin-left: 15px;">
                                                <a href="create_customer_sales_order" class="btn btn-block btn-primary">
                                                Create Sales Order
                                                </a>
                                            </div>

                                            <div class="btn-group" style="margin-top: 15px; margin-left: 15px;">
                                                <a href="<?php echo base_url().'vw_sales_order_without_offer'?>" class="btn btn-block btn-primary">
                                                Create Sales Order Without Offer
                                                </a>
                                            </div>

                                            <div class="btn-group" style="margin-top: 15px; margin-left: 15px;">
                                                <a href="vw_all_sales_order_data" class="btn btn-block btn-primary">
                                                All Sales Order
                                                </a>
                                            </div>

                                            <div class="btn-group" style="margin-top: 15px; margin-left: 15px;">
                                                <a href="vw_all_rejected_sales_order_data" class="btn btn-block btn-primary">
                                                Rejected Sales Order
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div  class="table-responsive">
                                                <table id="example1" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Sr. No.</th>
                                                            <th>Order No. </th>
                                                            <th>Offer No. </th>
                                                            <th>Enquiry No. </th>
                                                            <th>Company Name</th>
                                                            <th>Contact Person</th>
                                                            <th>Contact No.</th>
                                                            <th>Sales Consultant</th>
                                                            <th>Order Date</th>
                                                            <th>Action</th>
                                                            <!-- <th>Operation</th> -->
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $no = 0;
                                                            foreach ($order_details as $row):
                                                                $no++;
                                                                $entity_id = $row->entity_id;
                                                                $offer_id = $row->offer_id;
                                                                
                                                                if($offer_id == Null){
                                                                    $offer_no = 'NA';
                                                                    $enquiry_no = 'NA';
                                                                }else{
                                                                    $this->db->select('offer_register.*');
                                                                    $this->db->from('offer_register');
                                                                    $where = '(offer_register.entity_id = "'.$offer_id.'" )';
                                                                    $this->db->where($where);
                                                                    $query = $this->db->get();
                                                                    $offer_id_result =  $query->row_array();
                                                                    $offer_no = $offer_id_result['offer_no'];
                                                                    $enquiry_id = $offer_id_result['enquiry_id'];

                                                                    $this->db->select('enquiry_register.*');
                                                                    $this->db->from('enquiry_register');
                                                                    $where = '(enquiry_register.entity_id = "'.$enquiry_id.'" )';
                                                                    $this->db->where($where);
                                                                    $query = $this->db->get();
                                                                    $enquiry_id_result =  $query->row_array();
                                                                    $enquiry_no = $enquiry_id_result['enquiry_no'];
                                                                    

                                                                }

                                                        ?>
                                                        <tr>
                                                            <td><?php echo $no;?></td>
                                                            <td><?php echo $row->sales_order_no;?></td>
                                                            <td><?php echo $offer_no?></td>
                                                            <td><?php echo $enquiry_no;?></td>
                                                            <td><b><?php echo $row->customer_bill_to_name;?></b></td>
                                                            <td><?php echo $row->customer_bill_to_contact_person;?></td>
                                                            <td><?php echo $row->customer_bill_to_contact_person_no;?></td>
                                                            <td><?php echo $row->emp_first_name;?></td>
                                                            <td><?php echo date("d-m-Y", strtotime($row->sales_order_date));?></td>
                                                            <td>
                                                                <div class="btn-group">
                                                                    <?php if($offer_id != Null){ ?>
                                                                    <a href="<?php echo site_url('update_sales_order_data/'.$entity_id);?>" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                                                    <?php } ?> 

                                                                    <?php if($offer_id == Null){ ?>
                                                                    <a href="<?php echo site_url('update_sales_order_data_without_offer/'.$entity_id);?>" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                                                    <?php } ?>

                                                                    <!-- <a href="<?php echo site_url('delete_enquiry_data/'.$row->entity_id);?>" class="btn btn-sm btn-danger" onclick="return confirm('Are You Sure ?')"><i class="fas fa-trash"></i></a> -->
                                                                    <?php if($offer_id != Null){ ?>
                                                                    <a href="<?php echo site_url('view_sales_order_data/'.$entity_id);?>" class="btn btn-sm btn-success"><i class="fas fa-eye"></i></a>
                                                                    <?php } ?> 

                                                                    <?php if($offer_id == Null){ ?>
                                                                    <a href="<?php echo site_url('view_sales_order_data_without_offer/'.$entity_id);?>" class="btn btn-sm btn-success"><i class="fas fa-eye"></i></a>
                                                                    <?php } ?> 

                                                                    <!-- <a href="<?php echo site_url('download_offer/'.$entity_id);?>" target="_blank" class="btn btn-secondary"><i class="fa fa-print"></i></a> -->  
                                                                </div> 
                                                            </td>
                                                            <!-- <td>
                                                                
                                                                    <a onclick="return confirm('Are You Sure To Make Offer?')" href="<?php echo site_url('setorder/'.$entity_id);?>" class="btn btn-block btn-warning">Make Order</a>
                                                                    <a onclick="return confirm('Are You Sure To Make Offer?')" href="<?php echo site_url('set_revision_offer/'.$entity_id);?>" class="btn btn-block btn-warning">Make Revision</a>
                                                                
                                                            </td> -->
                                                        </tr>
                                                    <?php endforeach;?>
                                                    </tbody>
                                                    
                                                    <!-- <tfoot>
                                                        <tr>
                                                            <th>Sr. No.</th>
                                                            <th>First Name</th>
                                                            <th>Middle Name</th>
                                                            <th>Last Name</th>
                                                            <th>Email Id</th>
                                                        </tr>
                                                    </tfoot> -->
                                                </table>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
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
        <!-- DataTables -->
        <script src="<?php echo base_url().'assets/plugins/datatables/jquery.dataTables.js'?>"></script>
        <script src="<?php echo base_url().'assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js'?>"></script>
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
    </body>
</html>

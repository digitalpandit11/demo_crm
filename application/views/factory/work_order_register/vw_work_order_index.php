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
        <title>Work Order</title>
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
                                    <h1 class="card-title">Work Order</h1>
                                    <div class="col-sm-6">
                                        <br><br>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'vw_work_order_data'?>">Work Order</a>
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
                                            <h3 class="card-title">Work Order</h3>
                                        </div>
                                        <div>
                                            <div class="btn-group" style="margin-top: 15px; margin-left: 15px;">
                                                <a href="create_work_order" class="btn btn-block btn-primary">
                                                Create Work Order
                                                </a>
                                            </div>

                                            <div class="btn-group" style="margin-top: 15px; margin-left: 15px;">
                                                <a href="all_work_order" class="btn btn-block btn-primary">
                                                All Work Order
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div  class="table-responsive">
                                                <table id="example1" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Sr. No.</th>
                                                            <th>Order Type</th>
                                                            <th>Order From</th>
                                                            <th>Work Order No. </th>
                                                            <th>Work Order Date</th>
                                                            <th>PO No</th>
                                                            <th>PO Date</th>
                                                            <th>Customer Name</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $no = 0;
                                                            foreach ($work_order_details as $row):
                                                                $no++;
                                                                $entity_id = $row->entity_id;
                                                                $order_type = $row->work_order_type;
                                                                $sales_order_id = $row->sales_order_id;

                                                                if(empty($sales_order_id))
                                                                {
                                                                    $customer_id = $row->customer_id;

                                                                    $this->db->select('*');
                                                                    $this->db->from('customer_master');
                                                                    $where = '(customer_master.entity_id = "'.$customer_id.'")';
                                                                    $this->db->where($where);
                                                                    $query_cust = $this->db->get();
                                                                    $query_result_cust = $query_cust->row_array();

                                                                    $customer_name = $query_result_cust['customer_name'];

                                                                    $po_no = $row->po_no;
                                                                    $po_date = $row->po_date;
                                                                
                                                                }else{
                                                                $this->db->select('*');
                                                                $this->db->from('sales_order_register');
                                                                $where = '(sales_order_register.entity_id = "'.$sales_order_id.'")';
                                                                $this->db->where($where);
                                                                $query = $this->db->get();
                                                                $query_result = $query->row_array();

                                                                $customer_id = $query_result['customer_id'];

                                                                $po_no = $query_result['po_no'];
                                                                $po_date = $query_result['po_date'];

                                                                $this->db->select('*');
                                                                $this->db->from('customer_master');
                                                                $where = '(customer_master.entity_id = "'.$customer_id.'")';
                                                                $this->db->where($where);
                                                                $query_cust = $this->db->get();
                                                                $query_result_cust = $query_cust->row_array();

                                                                $customer_name = $query_result_cust['customer_name'];
                                                                }    



                                                                if($order_type == 1)
                                                                {
                                                                    $Type = "Work Order";
                                                                }else{
                                                                    $Type = "Tred Order";
                                                                }
                                                                $order_category = $row->work_order_category;
                                                                if($order_category == 1)
                                                                {
                                                                    $Category = "From Customer";
                                                                }else{
                                                                    $Category = "From Factory";
                                                                }
                                                                $Order_status = $row->work_order_status;

                                                                if($sales_order_id != NULL){

                                                                }
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $no;?></td>
                                                            <td><?php echo $Type;?></td>
                                                            <td><?php echo $Category;?></td>
                                                            <td><?php echo $row->work_order_no;?></td>
                                                            <td><?php echo date("d-m-Y", strtotime($row->work_order_date));?></td>
                                                            <td><?php echo $po_no;?></td>
                                                            <td><?php echo date("d-m-Y", strtotime($po_date));?></td>
                                                            <td><?php echo $customer_name;?></td>
                                                            <td>
                                                                <div class="btn-group">
                                                                    <?php if($order_category == 2 && $Order_status == 1){ ?>
                                                                        <a href="<?php echo site_url('update_second_category_order/'.$entity_id);?>" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                                                    <?php } if($order_category == 2){?>
                                                                        <a href="<?php echo site_url('view_second_category_order/'.$entity_id);?>" class="btn btn-sm btn-success"></i><i class="fas fa-eye"></i> </a> 
                                                                    <?php } if($order_category == 1 && $Order_status == 1){?>
                                                                        <a href="<?php echo site_url('update_first_category_order/'.$entity_id);?>" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                                                    <?php } if($order_category == 1){?>
                                                                        <a href="<?php echo site_url('view_first_category_order/'.$entity_id);?>" class="btn btn-sm btn-success"></i><i class="fas fa-eye"></i> </a>
                                                                    <?php }?>
                                                                    
                                                                    <?php if($sales_order_id == NULL){ ?>

                                                                        <?php if($order_type == 1){ ?>
                                                                           <a href="<?php echo site_url('download_normal_workorder/'.$entity_id);?>" target="_blank" class="btn btn-secondary">
                                                                          <i class="fa fa-print"></i></a> 
                                                                          <?php } ?> 

                                                                          <?php if($order_type == 2){ ?>
                                                                           <a href="<?php echo site_url('download_normal_tradeorder/'.$entity_id);?>" target="_blank" class="btn btn-danger">
                                                                          <i class="fa fa-print"></i></a> 
                                                                          <?php } ?>   
                                                                    <?php } ?> 


                                                                    <?php if($sales_order_id != NULL){ ?>

                                                                        <?php if($order_type == 1){ ?>
                                                                           <a href="<?php echo site_url('download_so_workorder/'.$entity_id);?>" target="_blank" class="btn btn-secondary">
                                                                          <i class="fa fa-print"></i></a> 
                                                                          <?php } ?> 

                                                                          <?php if($order_type == 2){ ?>
                                                                           <a href="<?php echo site_url('download_so_tradeorder/'.$entity_id);?>" target="_blank" class="btn btn-danger">
                                                                          <i class="fa fa-print"></i></a> 
                                                                          <?php } ?>   
                                                                    <?php } ?>                
                                                                </div> 
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

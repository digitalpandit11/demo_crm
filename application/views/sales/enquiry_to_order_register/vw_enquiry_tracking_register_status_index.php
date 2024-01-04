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
        <title>Enquiry Status Record</title>
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
            <?php $this->load->view('header_sidebar');
                date_default_timezone_set("Asia/Calcutta");
            ?> 
                <div class="content-wrapper">
                    <section class="content-header">
                        <div class="container-fluid">
                            <br>
                            <div class="card">
                                <div class="card-header" >
                                    <h1 class="card-title">Enquiry Status</h1>
                                    <div class="col-sm-6">
                                        <br><br>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'vw_all_enquiry_to_order_status'?>">Enquiry Status</a></li>
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
                                            <h3 class="card-title">Enquiry Status Details</h3>
                                        </div>

                                        <div class="card-body">
                                            <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Pending Enquiry</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#custom-content-below-profile" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">Followup Enquiry</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="custom-content-below-order-tab" data-toggle="pill" href="#custom-content-below-order" role="tab" aria-controls="custom-content-below-order" aria-selected="false">Order Created</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="custom-content-below-lost-tab" data-toggle="pill" href="#custom-content-below-lost" role="tab" aria-controls="custom-content-below-lost" aria-selected="false">Lost Enquiry</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content" id="custom-content-below-tabContent">
                                                <div class="tab-pane fade show active" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                                                    <div class="card-body">
                                                        <div  class="table-responsive">
                                                            <table id="example1" class="table table-bordered table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Sr. No.</th>
                                                                        <th>Customer Name</th>
                                                                        <th>Contact Person</th>
                                                                        <th>Contact No.</th>
                                                                        <th>Enquiry Type</th>
                                                                        <th>Enquiry Description</th>
                                                                        <th>Enquiry Number</th>
                                                                        <th>Enquiry Date</th>
                                                                        <th>Engineer Name</th>
                                                                        <th>Last Track Details</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                        $no = 0;
                                                                        foreach ($pending_enquiry as $row):
                                                                            $no++;
                                                                            $entity_id = $row->entity_id;

                                                                            $Enquiry_status = $row->enquiry_status;
                                                                            $Enquiry_type = $row->enquiry_type;

                                                                            $this->db->select('*');
                                                                            $this->db->from('enquiry_tracking_master');
                                                                            $where = '(enquiry_tracking_master.enquiry_id = "'.$entity_id.'" )';
                                                                            $this->db->where($where);
                                                                            $this->db->order_by('enquiry_tracking_master.entity_id', 'DESC');
                                                                            $this->db->limit(1);
                                                                            $enquiry_tracking_master = $this->db->get();
                                                                            $enquiry_tracking_master_result = $enquiry_tracking_master->row_array(); 
                                                                            $track_record = $enquiry_tracking_master_result['tracking_record'];

                                                                            $enquiry_source_by = $row->enquiry_source;

                                                                            $Emp_id = $row->emp_id;

                                                                            $this->db->select('*');
                                                                            $this->db->from('employee_master');
                                                                            $where = '(employee_master.entity_id = "'.$Emp_id.'" )';
                                                                            $this->db->where($where);
                                                                            $employee_master = $this->db->get();
                                                                            $employee_master_result = $employee_master->row_array();

                                                                            if(!empty($employee_master_result))
                                                                            {
                                                                                $Emp_name = $employee_master_result['emp_first_name'].' '. $employee_master_result['emp_middle_name'].' '. $employee_master_result['emp_last_name'];
                                                                            }else{
                                                                                $Emp_name = "";
                                                                            }

                                                                            if($Enquiry_status == 1)
                                                                            {
                                                                                $en_status = "Pending";
                                                                            }
                                                                            

                                                                            if($Enquiry_type == 1)
                                                                            {
                                                                                $Enq_type = "Pull Cord (MH)";
                                                                            }elseif($Enquiry_type == 2)
                                                                            {
                                                                                $Enq_type = "Porximity (PS)";
                                                                            }elseif($Enquiry_type == 3)
                                                                            {
                                                                                $Enq_type = "Vibrator Control (VC)";
                                                                            }elseif($Enquiry_type == 4)
                                                                            {
                                                                                $Enq_type = "Treading (TD)";
                                                                            }elseif($Enquiry_type == 5)
                                                                            {
                                                                                $Enq_type = "Other (OT)";
                                                                            }elseif($Enquiry_type == 6)
                                                                            {
                                                                                $Enq_type = "CUH & TD-MH";
                                                                            }elseif($Enquiry_type == 7)
                                                                            {
                                                                                $Enq_type = "TD-PS";
                                                                            }elseif($Enquiry_type == 8)
                                                                            {
                                                                                $Enq_type = "TD-VC";
                                                                            }   
                                                                    ?>

                                                                    <tr>
                                                                        <td><?php echo $no;?></td>
                                                                        
                                                                        <td><b><?php echo $row->customer_name;?></b></td>

                                                                        <td><?php echo $row->contact_person;?></td>

                                                                        <td><?php echo $row->first_contact_no;?></td>

                                                                        <td><?php echo $Enq_type;?></td>

                                                                        <td><?php echo $row->enquiry_short_desc;?></td>
                                                                        <td><?php echo $row->enquiry_no;?></td>

                                                                        <td><?php echo date("d-m-Y", strtotime($row->enquiry_date));?></td>

                                                                        <td><?php echo $Emp_name;?></td>

                                                                        <td><?php echo $track_record;?></td>

                                                                        <td>
                                                                            <div class="btn-group">
                                                                                <?php if(!empty($entity_id)){ ?>
                                                                                    <?php if($enquiry_source_by == 1){ ?>
                                                                                    <a href="<?php echo site_url('update_indiamart_enquiry_data_for_offer_cration/'.$entity_id);?>" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                                                                    <?php }else{?>
                                                                                    <a href="<?php echo site_url('update_enquiry_data_for_offer_cration/'.$entity_id);?>" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                                                                <?php } }?>
                                                                            </div> 
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach;?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tab-pane fade" id="custom-content-below-profile" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
                                                    <div class="card-body">
                                                        <div  class="table-responsive">
                                                            <table id="example2" class="table table-bordered table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Sr. No.</th>
                                                                        <th>Customer Name</th>
                                                                        <th>Contact Person</th>
                                                                        <th>Contact No.</th>
                                                                        <th>Enquiry Type</th>
                                                                        <th>Enquiry Description</th>
                                                                        <th>Enquiry Number</th>
                                                                        <th>Enquiry Date</th>
                                                                        <th>Last Track Details</th>
                                                                        <th>Offer Number</th>
                                                                        <th>Offer Date</th>
                                                                        <th>Winning Chance</th>
                                                                        <th>Engineer Name</th>
                                                                        <th>Offer Value</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                        $no = 0;
                                                                        foreach ($followup_enquiry as $row):
                                                                            $no++;
                                                                            $entity_id = $row->entity_id;

                                                                            $Enquiry_status = $row->enquiry_status;
                                                                            $Enquiry_type = $row->enquiry_type;

                                                                            $Emp_id = $row->emp_id;

                                                                            $this->db->select('*');
                                                                            $this->db->from('employee_master');
                                                                            $where = '(employee_master.entity_id = "'.$Emp_id.'" )';
                                                                            $this->db->where($where);
                                                                            $employee_master = $this->db->get();
                                                                            $employee_master_result = $employee_master->row_array();

                                                                            if(!empty($employee_master_result))
                                                                            {
                                                                                $Emp_name = $employee_master_result['emp_first_name'].' '. $employee_master_result['emp_middle_name'].' '. $employee_master_result['emp_last_name'];
                                                                            }else{
                                                                                $Emp_name = "";
                                                                            }

                                                                            $enquiry_source_by = $row->enquiry_source;

                                                                            if($Enquiry_status == 1)
                                                                            {
                                                                                $en_status = "Pending";
                                                                            }
                                                                            if($Enquiry_status == 2)
                                                                            {
                                                                                $en_status = "Offer Created";
                                                                            }
                                                                            if($Enquiry_status == 3)
                                                                            {
                                                                                $en_status = "Order Created";
                                                                            }

                                                                            if($Enquiry_type == 1)
                                                                            {
                                                                                $Enq_type = "Pull Cord (MH)";
                                                                            }elseif($Enquiry_type == 2)
                                                                            {
                                                                                $Enq_type = "Porximity (PS)";
                                                                            }elseif($Enquiry_type == 3)
                                                                            {
                                                                                $Enq_type = "Vibrator Control (VC)";
                                                                            }elseif($Enquiry_type == 4)
                                                                            {
                                                                                $Enq_type = "Treading (TD)";
                                                                            }elseif($Enquiry_type == 5)
                                                                            {
                                                                                $Enq_type = "Other (OT)";
                                                                            }elseif($Enquiry_type == 6)
                                                                            {
                                                                                $Enq_type = "CUH & TD-MH";
                                                                            }elseif($Enquiry_type == 7)
                                                                            {
                                                                                $Enq_type = "TD-PS";
                                                                            }elseif($Enquiry_type == 8)
                                                                            {
                                                                                $Enq_type = "TD-VC";
                                                                            }

                                                                            $this->db->select('*');
                                                                            $this->db->from('offer_register');
                                                                            $where = '(offer_register.enquiry_id = "'.$entity_id.'" )';
                                                                            $this->db->where($where);
                                                                            $this->db->order_by('offer_register.entity_id', 'DESC');
                                                                            $this->db->limit(1);
                                                                            $query_data = $this->db->get();
                                                                            $query_result = $query_data->row_array();

                                                                            if(!empty($query_result))
                                                                            {
                                                                                $offer_id = $query_result['entity_id'];
                                                                                $offer_no = $query_result['offer_no'];
                                                                                $offer_date = date("d-m-Y", strtotime($query_result['offer_date']));

                                                                                $winning_chance = $query_result['winning_chance'];

                                                                                $offer_value = $query_result['offer_value'];

                                                                                if($Enquiry_type == 1)
                                                                                {
                                                                                    $WC = "Chance A";
                                                                                }elseif($Enquiry_type == 2)
                                                                                {
                                                                                    $WC = "Chance B";
                                                                                }elseif($winning_chance == 3)
                                                                                {
                                                                                    $WC = "Chance C";
                                                                                }else{
                                                                                    $WC ="";
                                                                                }

                                                                                $this->db->select('*');
                                                                                $this->db->from('enquiry_tracking_master');
                                                                                $where = '(enquiry_tracking_master.offer_id = "'.$offer_id.'" )';
                                                                                $this->db->where($where);
                                                                                $this->db->order_by('enquiry_tracking_master.entity_id', 'DESC');
                                                                                $this->db->limit(1);
                                                                                $offer_tracking_master = $this->db->get();
                                                                                $offer_tracking_master_result = $offer_tracking_master->row_array(); 

                                                                                $track_record = $offer_tracking_master_result['tracking_record'];
                                                                            }else{
                                                                                $offer_id = "";
                                                                                $offer_no = "";
                                                                                $offer_date = "";
                                                                                $order_id = "";
                                                                                $order_no = "";
                                                                                $order_date = "";
                                                                                $WC = "";
                                                                                $track_record = "";
                                                                                $offer_value = "";
                                                                            }
                                                                    ?>

                                                                    <tr>
                                                                        <td><?php echo $no;?></td>
                                                                        
                                                                        <td><b><?php echo $row->customer_name;?></b></td>

                                                                        <td><?php echo $row->contact_person;?></td>

                                                                        <td><?php echo $row->first_contact_no;?></td>

                                                                        <td><?php echo $Enq_type;?></td>

                                                                        <td><?php echo $row->enquiry_short_desc;?></td>

                                                                        <td><?php echo $row->enquiry_no;?></td>

                                                                        <td><?php echo date("d-m-Y", strtotime($row->enquiry_date));?></td>

                                                                        <td><?php echo $track_record;?></td>

                                                                        <td><?php echo $offer_no;?></td>

                                                                        <td><?php echo $offer_date;?></td>

                                                                        <td><?php echo $WC;?></td>

                                                                        <td><?php echo $Emp_name;?></td>

                                                                        <td><?php echo $offer_value;?></td>
                                                                        
                                                                        <td>
                                                                            <div class="btn-group">
                                                                                <?php if(!empty($offer_id)){ ?>
                                                                                    <a href="<?php echo site_url('update_offer_data_for_order_cration/'.$offer_id);?>" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
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

                                                <div class="tab-pane fade" id="custom-content-below-order" role="tabpanel" aria-labelledby="custom-content-below-order-tab">
                                                    <div class="card-body">
                                                        <div  class="table-responsive">
                                                            <table id="example3" class="table table-bordered table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Sr. No.</th>
                                                                        <th>Customer Name</th>
                                                                        <th>Contact Person</th>
                                                                        <th>Contact No.</th>
                                                                        <th>Enquiry Type</th>
                                                                        <th>Enquiry Description</th>
                                                                        <th>Enquiry Number</th>
                                                                        <th>Enquiry Date</th>
                                                                        <th>Offer Number</th>
                                                                        <th>Offer Date</th>
                                                                        <th>Order Number</th>
                                                                        <th>Order Date</th>
                                                                        <th>Engineer Name</th>
                                                                        <th>Order Value</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                        $no = 0;
                                                                        foreach ($order_received_enquiry as $row):
                                                                            $no++;
                                                                            $entity_id = $row->entity_id;

                                                                            $Enquiry_status = $row->enquiry_status;
                                                                            $Enquiry_type = $row->enquiry_type;

                                                                            $Emp_id = $row->emp_id;

                                                                            $this->db->select('*');
                                                                            $this->db->from('employee_master');
                                                                            $where = '(employee_master.entity_id = "'.$Emp_id.'" )';
                                                                            $this->db->where($where);
                                                                            $employee_master = $this->db->get();
                                                                            $employee_master_result = $employee_master->row_array();

                                                                            if(!empty($employee_master_result))
                                                                            {
                                                                                $Emp_name = $employee_master_result['emp_first_name'].' '. $employee_master_result['emp_middle_name'].' '. $employee_master_result['emp_last_name'];
                                                                            }else{
                                                                                $Emp_name = "";
                                                                            }

                                                                            $enquiry_source_by = $row->enquiry_source;

                                                                            if($Enquiry_status == 1)
                                                                            {
                                                                                $en_status = "Pending";
                                                                            }
                                                                            if($Enquiry_status == 2)
                                                                            {
                                                                                $en_status = "Offer Created";
                                                                            }
                                                                            if($Enquiry_status == 3)
                                                                            {
                                                                                $en_status = "Order Created";
                                                                            }

                                                                            if($Enquiry_type == 1)
                                                                            {
                                                                                $Enq_type = "Pull Cord (MH)";
                                                                            }elseif($Enquiry_type == 2)
                                                                            {
                                                                                $Enq_type = "Porximity (PS)";
                                                                            }elseif($Enquiry_type == 3)
                                                                            {
                                                                                $Enq_type = "Vibrator Control (VC)";
                                                                            }elseif($Enquiry_type == 4)
                                                                            {
                                                                                $Enq_type = "Treading (TD)";
                                                                            }elseif($Enquiry_type == 5)
                                                                            {
                                                                                $Enq_type = "Other (OT)";
                                                                            }elseif($Enquiry_type == 6)
                                                                            {
                                                                                $Enq_type = "CUH & TD-MH";
                                                                            }elseif($Enquiry_type == 7)
                                                                            {
                                                                                $Enq_type = "TD-PS";
                                                                            }elseif($Enquiry_type == 8)
                                                                            {
                                                                                $Enq_type = "TD-VC";
                                                                            }

                                                                            $this->db->select('*');
                                                                            $this->db->from('offer_register');
                                                                            $where = '(offer_register.enquiry_id = "'.$entity_id.'" )';
                                                                            $this->db->where($where);
                                                                            $this->db->order_by('offer_register.entity_id', 'DESC');
                                                                            $this->db->limit(1);
                                                                            $query_data = $this->db->get();
                                                                            $query_result = $query_data->row_array();

                                                                            if(!empty($query_result))
                                                                            {
                                                                                $offer_id = $query_result['entity_id'];
                                                                                $offer_no = $query_result['offer_no'];
                                                                                $offer_date = date("d-m-Y", strtotime($query_result['offer_date']));

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
                                                                                    $order_date = date("d-m-Y", strtotime($sales_order_register_result['sales_order_date']));

                                                                                    $this->db->select_sum('total_amount_with_gst');
                                                                                    $this->db->from('sales_order_product_relation');
                                                                                    $where = '(sales_order_product_relation.sales_order_id = "'.$order_id.'")';
                                                                                    $this->db->where($where);
                                                                                    $product_amount = $this->db->get();
                                                                                    $product_amount_result =  $product_amount->row_array();

                                                                                    if(!empty($product_amount_result))
                                                                                    {
                                                                                        $product_amount_without_gst_format = $product_amount_result['total_amount_with_gst'];
                                                                                        $Offer_order_val = number_format((float)$product_amount_without_gst_format, 2, '.', '');
                                                                                    }
                                                                                    else{
                                                                                        $Offer_order_val = 0;
                                                                                    }
                                                                                    $Offer_order_amount = number_format((float)$Offer_order_val, 2, '.', '');

                                                                                }else{
                                                                                    $order_id = "";
                                                                                    $order_no = "";
                                                                                    $order_date = "";
                                                                                    $Offer_order_amount = "";
                                                                                }
                                                                            }else{
                                                                                $offer_id = "";
                                                                                $offer_no = "";
                                                                                $offer_date = "";
                                                                                $order_id = "";
                                                                                $order_no = "";
                                                                                $order_date = "";
                                                                                $Offer_order_amount = "";
                                                                            }   
                                                                    ?>

                                                                    <tr>
                                                                        <td><?php echo $no;?></td>
                                                                        
                                                                        <td><b><?php echo $row->customer_name;?></b></td>

                                                                        <td><?php echo $row->contact_person;?></td>

                                                                        <td><?php echo $row->first_contact_no;?></td>
                                                                        <td><?php echo $Enq_type;?></td>

                                                                        <td><?php echo $row->enquiry_short_desc;?></td>

                                                                        <td><?php echo $row->enquiry_no;?></td>

                                                                        <td><?php echo date("d-m-Y", strtotime($row->enquiry_date));?></td>

                                                                        <td><?php echo $offer_no;?></td>

                                                                        <td><?php echo $offer_date;?></td>

                                                                        <td><?php echo $order_no;?></td>

                                                                        <td><?php echo $order_date;?></td>

                                                                        <td><?php echo $Emp_name;?></td>

                                                                        <td><?php echo $Offer_order_amount;?></td>
                                                                        
                                                                        <td>
                                                                            <div class="btn-group">
                                                                                <a href="<?php echo site_url('update_sales_order_data/'.$order_id);?>" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach;?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tab-pane fade" id="custom-content-below-lost" role="tabpanel" aria-labelledby="custom-content-below-lost-tab">
                                                    <div class="card-body">
                                                        <div  class="table-responsive">
                                                            <table id="example4" class="table table-bordered table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Sr. No.</th>
                                                                        <th>Customer Name</th>
                                                                        <th>Contact Person</th>
                                                                        <th>Contact No.</th>
                                                                        <th>Enquiry Type</th>
                                                                        <th>Enquiry Description</th>
                                                                        <th>Enquiry Number</th>
                                                                        <th>Enquiry Date</th>
                                                                        <th>Offer Number</th>
                                                                        <th>Offer Date</th>
                                                                        <th>Order Number</th>
                                                                        <th>Order Date</th>
                                                                        <th>Engineer Name</th>
                                                                        <th>Lost Reason</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                        $no = 0;
                                                                        foreach ($lost_enquiry as $row):
                                                                            $no++;
                                                                            $entity_id = $row->entity_id;

                                                                            $Enquiry_status = $row->enquiry_status;
                                                                            $Enquiry_type = $row->enquiry_type;

                                                                            $Emp_id = $row->emp_id;

                                                                            $ERR = $row->enquiry_rejected_reason;

                                                                            $this->db->select('*');
                                                                            $this->db->from('employee_master');
                                                                            $where = '(employee_master.entity_id = "'.$Emp_id.'" )';
                                                                            $this->db->where($where);
                                                                            $employee_master = $this->db->get();
                                                                            $employee_master_result = $employee_master->row_array();

                                                                            if(!empty($employee_master_result))
                                                                            {
                                                                                $Emp_name = $employee_master_result['emp_first_name'].' '. $employee_master_result['emp_middle_name'].' '. $employee_master_result['emp_last_name'];
                                                                            }else{
                                                                                $Emp_name = "";
                                                                            }

                                                                            $enquiry_source_by = $row->enquiry_source;

                                                                            if($Enquiry_status == 1)
                                                                            {
                                                                                $en_status = "Pending";
                                                                            }
                                                                            if($Enquiry_status == 2)
                                                                            {
                                                                                $en_status = "Offer Created";
                                                                            }
                                                                            if($Enquiry_status == 3)
                                                                            {
                                                                                $en_status = "Order Created";
                                                                            }

                                                                            if($Enquiry_type == 1)
                                                                            {
                                                                                $Enq_type = "Pull Cord (MH)";
                                                                            }elseif($Enquiry_type == 2)
                                                                            {
                                                                                $Enq_type = "Porximity (PS)";
                                                                            }elseif($Enquiry_type == 3)
                                                                            {
                                                                                $Enq_type = "Vibrator Control (VC)";
                                                                            }elseif($Enquiry_type == 4)
                                                                            {
                                                                                $Enq_type = "Treading (TD)";
                                                                            }elseif($Enquiry_type == 5)
                                                                            {
                                                                                $Enq_type = "Other (OT)";
                                                                            }elseif($Enquiry_type == 6)
                                                                            {
                                                                                $Enq_type = "CUH & TD-MH";
                                                                            }elseif($Enquiry_type == 7)
                                                                            {
                                                                                $Enq_type = "TD-PS";
                                                                            }elseif($Enquiry_type == 8)
                                                                            {
                                                                                $Enq_type = "TD-VC";
                                                                            }

                                                                            $this->db->select('*');
                                                                            $this->db->from('offer_register');
                                                                            $where = '(offer_register.enquiry_id = "'.$entity_id.'" )';
                                                                            $this->db->where($where);
                                                                            $this->db->order_by('offer_register.entity_id', 'DESC');
                                                                            $this->db->limit(1);
                                                                            $query_data = $this->db->get();
                                                                            $query_result = $query_data->row_array();

                                                                            if(!empty($query_result))
                                                                            {
                                                                                $offer_id = $query_result['entity_id'];
                                                                                $offer_no = $query_result['offer_no'];
                                                                                $offer_date = date("d-m-Y", strtotime($query_result['offer_date']));

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
                                                                                    $order_date = date("d-m-Y", strtotime($sales_order_register_result['sales_order_date']));
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
                                                                            }   
                                                                    ?>

                                                                    <tr>
                                                                        <td><?php echo $no;?></td>
                                                                        
                                                                        <td><b><?php echo $row->customer_name;?></b></td>

                                                                        <td><?php echo $row->contact_person;?></td>

                                                                        <td><?php echo $row->first_contact_no;?></td>
                                                                        <td><?php echo $Enq_type;?></td>

                                                                        <td><?php echo $row->enquiry_short_desc;?></td>

                                                                        <td><?php echo $row->enquiry_no;?></td>

                                                                        <td><?php echo date("d-m-Y", strtotime($row->enquiry_date));?></td>

                                                                        <td><?php echo $offer_no;?></td>

                                                                        <td><?php echo $offer_date;?></td>

                                                                        <td><?php echo $order_no;?></td>

                                                                        <td><?php echo $order_date;?></td>

                                                                        <td><?php echo $Emp_name;?></td>

                                                                        <td><?php echo $ERR;?></td>
                                                                        
                                                                        <td>
                                                                            <div class="btn-group">
                                                                                <a href="<?php echo site_url('view_all_lost_enquiry_data/'.$entity_id);?>" class="btn btn-sm btn-success"><i class="fas fa-eye"></i></a>
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
        <!-- DataTables -->
        <script src="<?php echo base_url().'assets/plugins/datatables/jquery.dataTables.js'?>"></script>
        <script src="<?php echo base_url().'assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js'?>"></script>
        <script>
            $(document).ready( function () {
                $('#example1').DataTable();
            } );

            $(document).ready( function () {
                $('#example2').DataTable();
            } );

            $(document).ready( function () {
                $('#example3').DataTable();
            } );

            $(document).ready( function () {
                $('#example4').DataTable();
            } );
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
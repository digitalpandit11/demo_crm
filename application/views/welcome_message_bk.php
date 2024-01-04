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
  <title>BBCPL CRM</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Data Tables -->
        <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css'?>">
  <!-- Font Awesome -->
 <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/fontawesome-free/css/all.min.css'?>">
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
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/daterangepicker/daterangepicker.css'?>">
  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/summernote/summernote-bs4.css'?>">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

<?php $this->load->view('header_sidebar');?>

<?php 
        $this->db->select('enquiry_register.*');
        $this->db->from('enquiry_register');
        $where = '(enquiry_register.enquiry_status = "'.'1'.'")';
        $this->db->where($where);
        $active_enquiry_register_data = $this->db->get();
        $active_enquiry_count = $active_enquiry_register_data->num_rows();



        $this->db->select('enquiry_register.*');
        $this->db->from('enquiry_register');
        /*$where = '(enquiry_register.enquiry_status = "'.'1'.'")';
        $this->db->where($where);*/
        $enquiry_register_data = $this->db->get();
        $enquiry_count = $enquiry_register_data->num_rows();

        if(!empty($enquiry_count))
        {
              $enquiry_register_data_count =  $enquiry_count;
        }else{
          $enquiry_register_data_count = 0;
        }

        $this->db->select('offer_register.*');
        $this->db->from('offer_register');
        $where = '(offer_register.status != "'.'4'.'" or offer_register.status != "'.'5'.'" or offer_register.status != "'.'6'.'")';
        $this->db->where($where);
        $offer_register_data = $this->db->get();
        $offer_register_data_count = $offer_register_data->num_rows();

        if(!empty($offer_register_data_count))
        {
            $offer_register_count = $offer_register_data_count;
        }else{
            $offer_register_count = 1;
        }

        // $this->db->select('offer_register.*');
        // $this->db->from('offer_register');
        // $offer_register_data = $this->db->get();
        // $offer_register_count = $offer_register_data->num_rows();
        $finacial_year = "2021-04-01 00:00:00";
        $this->db->select_sum('total_amount_with_gst');
        $this->db->from('offer_product_relation');
        $where = '(offer_register.status != "'.'4'.'" or offer_register.status != "'.'5'.'" or offer_register.status != "'.'6'.'")';
        $this->db->where($where);
        $where1 = '(offer_register.offer_date >= "'.$finacial_year.'")';
        $this->db->where($where1);
        $this->db->join('offer_register', 'offer_product_relation.offer_id = offer_register.entity_id', 'INNER');
        $query=$this->db->get();
        $total_offer_amount = $query->row();
        $total_offer_amount_final = $total_offer_amount->total_amount_with_gst;
        $final_offer_amount = number_format($total_offer_amount_final, 2, '.', '');

        $this->db->select('sales_order_register.*');
        $this->db->from('sales_order_register');
        $where = '(sales_order_register.status = "'.'2'.'")';
        $this->db->where($where);
        $sales_order_register_data = $this->db->get();
        $sales_order_reg_count = $sales_order_register_data->num_rows();

        if(!empty($sales_order_reg_count))
        {
            $sales_order_register_count = $sales_order_reg_count;
        }else{
            $sales_order_register_count = 1;
        }

        $this->db->select_sum('total_amount_with_gst');
        $this->db->from('sales_order_product_relation');
        $where = '(sales_order_register.status = "'.'2'.'")';
        $this->db->where($where);
        $where1 = '(sales_order_register.sales_order_date >= "'.$finacial_year.'")';
        $this->db->where($where1);
        $this->db->join('sales_order_register', 'sales_order_product_relation.sales_order_id = sales_order_register.entity_id', 'INNER');
        $query=$this->db->get();
        $total_sales_order_amount = $query->row();
        $total_sales_order_amount_final = $total_sales_order_amount->total_amount_with_gst;
        $final_sales_order_amount = number_format($total_sales_order_amount_final, 2, '.', '');


        $this->db->select('work_order_master.*');
        $this->db->from('work_order_master');
        $where = '(work_order_master.work_order_type = "'.'1'.'")';
        $this->db->where($where);
        $swork_order_data = $this->db->get();
        $workorder_order_register_count = $swork_order_data->num_rows();

        $this->db->select('work_order_master.*');
        $this->db->from('work_order_master');
        $where = '(work_order_master.work_order_type = "'.'2'.'")';
        $this->db->where($where);
        $trade_order_data = $this->db->get();
        $trade_order_register_count = $trade_order_data->num_rows();

        $Conversion_ratio = $sales_order_register_count/$offer_register_count;
        $Conversion_ratio_new = $Conversion_ratio*100;

        $new_width = ($sales_order_register_count / 100) * $offer_register_count;
        
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        

  <div class="row row-cols-12">
  <div class="col-8"> 

  <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Saless Funnel</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                 <div id="chartContainer" style="height: 400px; width: 90%;"></div>
       <?php 
  //funnel

    
    $this->db->select('offer_register.*');
        $this->db->from('offer_register');
        $where = '(offer_register.status != "'.'4'.'" or offer_register.status != "'.'5'.'" or offer_register.status != "'.'6'.'")';
        $this->db->where($where);
        $offer_register_data = $this->db->get();
        $offer_register_data_count = $offer_register_data->num_rows();

        if(!empty($offer_register_data_count))
        {
            $offer_register_count = $offer_register_data_count;
        }else{
            $offer_register_count = 1;
        }
    
    
    
    //funnel value
  //1
    $this->db->select_sum('offer_product_relation.total_amount_with_gst');
        $this->db->from('offer_register');
    $this->db->join('offer_product_relation', 'offer_register.entity_id = offer_product_relation.offer_id', 'INNER');
        $where = '(offer_register.winning_chance  = "'.'1'.'")';
        $this->db->where($where);
        $offer_register_dataa = $this->db->get();
        $offer_register_data_count = $offer_register_dataa->row_array();
        $val1=$offer_register_data_count['total_amount_with_gst'];
        if(!empty($val1))
        {
          $valuee11 = $val1;
        }else{
          $valuee11 = 0;
        }

//2
    $this->db->select_sum('offer_product_relation.total_amount_with_gst');
        $this->db->from('offer_register');
    $this->db->join('offer_product_relation', 'offer_register.entity_id = offer_product_relation.offer_id', 'INNER');
        $where = '(offer_register.winning_chance  = "'.'2'.'")';
        $this->db->where($where);
        $ooffer_register_dataa = $this->db->get();
        $ooffer_register_data_count = $ooffer_register_dataa->row_array();
      $val2=$ooffer_register_data_count['total_amount_with_gst'];
       if(!empty($val2))
        {
          $valuee22 = $val2;
        }else{
          $valuee22 = 0;
        }

//3
    $this->db->select_sum('offer_product_relation.total_amount_with_gst');
        $this->db->from('offer_register');
    $this->db->join('offer_product_relation', 'offer_register.entity_id = offer_product_relation.offer_id', 'INNER');
        $where = '(offer_register.winning_chance  = "'.'3'.'")';
    $this->db->where($where);
        $ooffer_register_dataaa = $this->db->get();
        $ooffer_register_data_countt = $ooffer_register_dataaa->row_array();
        $val3 = $ooffer_register_data_countt['total_amount_with_gst'];

        if(!empty($val3))
        {
          $valuee33 = $val3;
        }else{
          $valuee33 = 0;
        }
                
              ?>
      
       </div>
              </div>
              <!-- /.card-body -->
            </div></div>
      
      
  
  <div class="row row-cols-1">
  <table><tr>
 <td> <div class="col-12">

        
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-phone"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Leads</span>
                <span class="info-box-number">
                  <?php  echo $enquiry_register_data_count; ?> Nos
                  <!-- <small>%</small> -->
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            </div></td></tr>
              <tr> <td><div class="col-12">
            
            <div class="info-box">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Offers</span>
                <span class="info-box-number">
                  <?php  echo $offer_register_count; ?> Nos<span style="font-size: 15px;"> (Rs <?php  echo $final_offer_amount; ?>)</span>
                  <!-- <small>%</small> -->
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
          </div></td></tr>
  
  <tr>
 <td> <div class="col-12">
  <div class="info-box">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Orders</span>
                <span class="info-box-number"><?php  echo $sales_order_register_count; ?> Nos<span style="font-size: 15px;"> (Rs <?php  echo $final_sales_order_amount; ?>)</span></span>
              </div>
              <!-- /.info-box-content -->
              </div></div></td></tr>
  <tr><td><div class="col-12">
            
              <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Conversion Ratio</span>
                <span class="info-box-number">
                  <?php  echo $new_width; ?>
                  <small>%</small>
                  </span> </div>
                
              <!-- /.info-box-content -->
            </div>
            
          </div></td></tr>
  
  
  
  
  
  </table>
          
        </div>
       


</div>


        


        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Monthly Recap Report</h5>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <div class="btn-group">
                    <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                      <i class="fas fa-wrench"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                      <a href="#" class="dropdown-item">Action</a>
                      <a href="#" class="dropdown-item">Another action</a>
                      <a href="#" class="dropdown-item">Something else here</a>
                      <a class="dropdown-divider"></a>
                      <a href="#" class="dropdown-item">Separated link</a>
                    </div>
                  </div>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->

              <?php 
                $this->db->select('sales_order_register.*');
                $this->db->from('sales_order_register');
                $sales_order_register_data = $this->db->get();
                $sales_order_count = $sales_order_register_data->num_rows();

                if(!empty($sales_order_count))
                {
                    $sales_order_register_count = $sales_order_count;
                }else{
                    $sales_order_register_count = 1;
                }


                $this->db->select('sales_order_register.*');
                $this->db->from('sales_order_register');
                $this->db->like('sales_order_no',"MH");     
                $sales_order_no = $this->db->get();
                $sales_order_no_MH_count = $sales_order_no->num_rows();

                $MH_percentage = (($sales_order_no_MH_count * 100)/ $sales_order_register_count);


                $this->db->select('sales_order_register.*');
                $this->db->from('sales_order_register');
                $this->db->like('sales_order_no',"PS");     
                $sales_order_no = $this->db->get();
                $sales_order_no_PS_count = $sales_order_no->num_rows();

                $PS_percentage = (($sales_order_no_PS_count * 100)/ $sales_order_register_count);


                $this->db->select('sales_order_register.*');
                $this->db->from('sales_order_register');
                $this->db->like('sales_order_no',"VC");     
                $sales_order_no = $this->db->get();
                $sales_order_no_VC_count = $sales_order_no->num_rows();

                $VC_percentage = (($sales_order_no_VC_count * 100)/ $sales_order_register_count);


                $this->db->select('sales_order_register.*');
                $this->db->from('sales_order_register');
                $this->db->like('sales_order_no',"TD");     
                $sales_order_no = $this->db->get();
                $sales_order_no_TD_count = $sales_order_no->num_rows();

                $TD_percentage = (($sales_order_no_TD_count * 100)/ $sales_order_register_count);


                $this->db->select('sales_order_register.*');
                $this->db->from('sales_order_register');
                $this->db->like('sales_order_no',"OT");     
                $sales_order_no = $this->db->get();
                $sales_order_no_OT_count = $sales_order_no->num_rows();

                $OT_percentage = (($sales_order_no_OT_count * 100)/ $sales_order_register_count);
                

              ?>
              <div class="card-body">

                        <div class="row">

           <!-- /.col (LEFT) -->
          <div class="col-md-8">
           
            <?php 
            //Current Month Start

            $activemonth = date('m');

            $subactive = date("F", mktime(0, 0, 0, $activemonth));

            $firstday_subactive = date('Y-'.$activemonth.'-01');
            $lastday_subactive = date('Y-'.$activemonth.'-t');

            $this->db->select('enquiry_register.*');
            $this->db->from('enquiry_register');
            $where = '(enquiry_register.enquiry_date >= "'.$firstday_subactive.'" And enquiry_register.enquiry_date <= "'.$lastday_subactive.'")';
            $this->db->where($where);
            $enquiry_subactive = $this->db->get();
            $enquiry_subactive_count = $enquiry_subactive->num_rows();

            $this->db->select('offer_register.*');
            $this->db->from('offer_register');  
            $where = '(offer_register.offer_date >= "'.$firstday_subactive.'" And offer_register.offer_date <= "'.$lastday_subactive.'")';
            $this->db->where($where);
            $offer_subactive = $this->db->get();
            $offer_subactive_count = $offer_subactive->num_rows();

            $this->db->select('sales_order_register.*');
            $this->db->from('sales_order_register');
            $where = '(sales_order_register.sales_order_date >= "'.$firstday_subactive.'" And sales_order_register.sales_order_date <= "'.$lastday_subactive.'")';
            $this->db->where($where);    
            $sales_order_subactive = $this->db->get();
            $sales_order_subactive_count = $sales_order_subactive->num_rows();








            //Last Month Start

            $currmonthsubone = date('m', strtotime('-1 month'));
            $subone = date("F", mktime(0, 0, 0, $currmonthsubone));

            $firstday_subone = date('Y-m-01', strtotime('-1 month'));
            $lastday_subone = strtotime(date("Y-m-d", strtotime($firstday_subone)) . "+1 month");
            $lastday_subone = date("Y-m-d",$lastday_subone);
            

            $this->db->select('enquiry_register.*');
            $this->db->from('enquiry_register');
            $where = '(enquiry_register.enquiry_date >= "'.$firstday_subone.'" And enquiry_register.enquiry_date <= "'.$lastday_subone.'")';
            $this->db->where($where);
            $enquiry_subone = $this->db->get();
            $enquiry_subone_count = $enquiry_subone->num_rows();
            


            $this->db->select('offer_register.*');
            $this->db->from('offer_register');  
            $where = '(offer_register.offer_date >= "'.$firstday_subone.'" And offer_register.offer_date <= "'.$lastday_subone.'")';
            $this->db->where($where);
            $offer_subone = $this->db->get();
            $offer_subone_count = $offer_subone->num_rows();
            

            $this->db->select('sales_order_register.*');
            $this->db->from('sales_order_register');
            $where = '(sales_order_register.sales_order_date >= "'.$firstday_subone.'" And sales_order_register.sales_order_date <= "'.$lastday_subone.'")';
            $this->db->where($where);    
            $sales_order_subone = $this->db->get();
            $sales_order_subone_count = $sales_order_subone->num_rows();
            //Last Month End
            

            //SecondLast Month Start
            $currmonthsubtwo = date('m', strtotime('-2 month'));
            $subtwo = date("F", mktime(0, 0, 0, $currmonthsubtwo));
            $firstday_subtwo = date('Y-m-01', strtotime('-2 month'));
            $lastday_subtwo = strtotime(date("Y-m-d", strtotime($firstday_subtwo)) . "+1 month");
            $lastday_subtwo = date("Y-m-d",$lastday_subtwo);
          

            $this->db->select('enquiry_register.*');
            $this->db->from('enquiry_register');
            $where = '(enquiry_register.enquiry_date >= "'.$firstday_subtwo.'" And enquiry_register.enquiry_date <= "'.$lastday_subtwo.'")';
            $this->db->where($where);    
            $enquiry_subtwo = $this->db->get();
            $enquiry_subtwo_count = $enquiry_subtwo->num_rows();
            
            


            $this->db->select('offer_register.*');
            $this->db->from('offer_register');
            $where = '(offer_register.offer_date >= "'.$firstday_subtwo.'" And offer_register.offer_date <= "'.$lastday_subtwo.'")';
            $this->db->where($where); 
            $offer_subtwo = $this->db->get();
            $offer_subtwo_count = $offer_subtwo->num_rows();
            

            $this->db->select('sales_order_register.*');
            $this->db->from('sales_order_register');
            $where = '(sales_order_register.sales_order_date >= "'.$firstday_subtwo.'" And sales_order_register.sales_order_date <= "'.$lastday_subtwo.'")';
            $this->db->where($where);     
            $sales_order_subtwo = $this->db->get();
            $sales_order_subtwo_count = $sales_order_subtwo->num_rows();
            //SecondLast Month End



            //ThirdLast Month Start
            $currmonthsubthree = date('m', strtotime('-3 month'));
            $subthree = date("F", mktime(0, 0, 0, $currmonthsubthree));
            $firstday_subthree = date('Y-m-01', strtotime('-3 month'));
            $lastday_subthree = strtotime(date("Y-m-d", strtotime($firstday_subthree)) . "+1 month");
            $lastday_subthree = date("Y-m-d",$lastday_subthree);

            $this->db->select('enquiry_register.*');
            $this->db->from('enquiry_register');
            $where = '(enquiry_register.enquiry_date >= "'.$firstday_subthree.'" And enquiry_register.enquiry_date <= "'.$lastday_subthree.'")';
            $this->db->where($where);     
            $enquiry_subthree = $this->db->get();
            $enquiry_subthree_count = $enquiry_subthree->num_rows();


            $this->db->select('offer_register.*');
            $this->db->from('offer_register');
            $where = '(offer_register.offer_date >= "'.$firstday_subthree.'" And offer_register.offer_date <= "'.$lastday_subthree.'")';
            $this->db->where($where);     
            $offer_subthree = $this->db->get();
            $offer_subthree_count = $offer_subthree->num_rows();
            

            $this->db->select('sales_order_register.*');
            $this->db->from('sales_order_register');
            $where = '(sales_order_register.sales_order_date >= "'.$firstday_subthree.'" And sales_order_register.sales_order_date <= "'.$lastday_subthree.'")';
            $this->db->where($where);     
            $sales_order_subthree = $this->db->get();
            $sales_order_subthree_count = $sales_order_subthree->num_rows();
            //ThirdLast Month End



            //FourthLast Month Start
            $currmonthsubfour = date('m', strtotime('-4 month'));
            $subfour = date("F", mktime(0, 0, 0, $currmonthsubfour));
            $firstday_subfour = date('Y-m-01', strtotime('-4 month'));
            $lastday_subfour = strtotime(date("Y-m-d", strtotime($firstday_subfour)) . "+1 month");
            $lastday_subfour = date("Y-m-d",$lastday_subfour);

            $this->db->select('enquiry_register.*');
            $this->db->from('enquiry_register');
            $where = '(enquiry_register.enquiry_date >= "'.$firstday_subfour.'" And enquiry_register.enquiry_date <= "'.$lastday_subfour.'")';
            $this->db->where($where);     
            $enquiry_subfour = $this->db->get();
            $enquiry_subfour_count = $enquiry_subfour->num_rows();

            $this->db->select('offer_register.*');
            $this->db->from('offer_register');
            $where = '(offer_register.offer_date >= "'.$firstday_subfour.'" And offer_register.offer_date <= "'.$lastday_subfour.'")';
            $this->db->where($where);     
            $offer_subfour = $this->db->get();
            $offer_subfour_count = $offer_subfour->num_rows();
            

            $this->db->select('sales_order_register.*');
            $this->db->from('sales_order_register');
            $where = '(sales_order_register.sales_order_date >= "'.$firstday_subfour.'" And sales_order_register.sales_order_date <= "'.$lastday_subfour.'")';
            $this->db->where($where);     
            $sales_order_subfour = $this->db->get();
            $sales_order_subfour_count = $sales_order_subfour->num_rows();
            //FourthLast Month End



            //FifthLast Month Start
            $currmonthsubfive = date('m', strtotime('-5 month'));
            $subfive = date("F", mktime(0, 0, 0, $currmonthsubfive));
            $firstday_subfive = date('Y-m-01', strtotime('-5 month'));
            $lastday_subfive = strtotime(date("Y-m-d", strtotime($firstday_subfive)) . "+1 month");
            $lastday_subfive = date("Y-m-d",$lastday_subfive);

            $this->db->select('enquiry_register.*');
            $this->db->from('enquiry_register');
            $where = '(enquiry_register.enquiry_date >= "'.$firstday_subfive.'" And enquiry_register.enquiry_date <= "'.$lastday_subfive.'")';
            $this->db->where($where);     
            $enquiry_subfive = $this->db->get();
            $enquiry_subfive_count = $enquiry_subfive->num_rows();

            $this->db->select('offer_register.*');
            $this->db->from('offer_register');
            $where = '(offer_register.offer_date >= "'.$firstday_subfive.'" And offer_register.offer_date <= "'.$lastday_subfive.'")';
            $this->db->where($where);     
            $offer_subfive = $this->db->get();
            $offer_subfive_count = $offer_subfive->num_rows();
            

            $this->db->select('sales_order_register.*');
            $this->db->from('sales_order_register');
            $where = '(sales_order_register.sales_order_date >= "'.$firstday_subfive.'" And sales_order_register.sales_order_date <= "'.$lastday_subfive.'")';
            $this->db->where($where);     
            $sales_order_subfive = $this->db->get();
            $sales_order_subfive_count = $sales_order_subfive->num_rows();
            //FifthLast Month End



            //SixthLast Month Start
            $currmonthsubsix = date('m', strtotime('-6 month'));



            $subsix = date("F", mktime(0, 0, 0, $currmonthsubsix));




            $firstday_subsix = date('Y-m-01', strtotime('-6 month'));
            $lastday_subsix = strtotime(date("Y-m-d", strtotime($firstday_subsix)) . "+1 month");
            $lastday_subsix = date("Y-m-d",$lastday_subsix);

            $this->db->select('enquiry_register.*');
            $this->db->from('enquiry_register');
            $where = '(enquiry_register.enquiry_date >= "'.$firstday_subsix.'" And enquiry_register.enquiry_date <= "'.$lastday_subsix.'")';
            $this->db->where($where);     
            $enquiry_subsix = $this->db->get();
            $enquiry_subsix_count = $enquiry_subsix->num_rows();

            $this->db->select('offer_register.*');
            $this->db->from('offer_register');
            $where = '(offer_register.offer_date >= "'.$firstday_subsix.'" And offer_register.offer_date <= "'.$lastday_subtwo.'")';
            $this->db->where($where);     
            $offer_subsix = $this->db->get();
            $offer_subsix_count = $offer_subsix->num_rows();
            

            $this->db->select('sales_order_register.*');
            $this->db->from('sales_order_register');
            $where = '(sales_order_register.sales_order_date >= "'.$firstday_subsix.'" And sales_order_register.sales_order_date <= "'.$lastday_subsix.'")';
            $this->db->where($where);
            $sales_order_subsix = $this->db->get();
            $sales_order_subsix_count = $sales_order_subsix->num_rows();
            //SixthLast Month End





           ?>
           <input type="hidden" id="subactive" name="subactive" value="<?php echo $subactive;?>" required>
           <input type="hidden" id="subone" name="subone" value="<?php echo $subone;?>" required>
           <input type="hidden" id="subtwo" name="subtwo" value="<?php echo $subtwo;?>" required>
           <input type="hidden" id="subthree" name="subthree" value="<?php echo $subthree;?>" required>
           <input type="hidden" id="subfour" name="subfour" value="<?php echo $subfour;?>" required>
           <input type="hidden" id="subfive" name="subfive" value="<?php echo $subfive;?>" required>
           <input type="hidden" id="subsix" name="subsix" value="<?php echo $subsix;?>" required>

           <input type="hidden" id="enquiry_subactive_count" name="enquiry_subactive_count" value="<?php echo $enquiry_subactive_count?>" required>
           <input type="hidden" id="offer_subactive_count" name="offer_subactive_count" value="<?php echo $offer_subactive_count?>" required>
           <input type="hidden" id="sales_order_subactive_count" name="sales_order_subactive_count" value="<?php echo $sales_order_subactive_count?>" required>

           <input type="hidden" id="enquiry_subone_count" name="enquiry_subone_count" value="<?php echo $enquiry_subone_count?>" required>
           <input type="hidden" id="offer_subone_count" name="offer_subone_count" value="<?php echo $offer_subone_count?>" required>
           <input type="hidden" id="sales_order_subone_count" name="sales_order_subone_count" value="<?php echo $sales_order_subone_count?>" required>



           <input type="hidden" id="enquiry_subtwo_count" name="enquiry_subtwo_count" value="<?php echo $enquiry_subtwo_count?>" required>
           <input type="hidden" id="offer_subtwo_count" name="offer_subtwo_count" value="<?php echo $offer_subtwo_count?>" required>
           <input type="hidden" id="sales_order_subtwo_count" name="sales_order_subtwo_count" value="<?php echo $sales_order_subtwo_count?>" required>



           <input type="hidden" id="enquiry_subthree_count" name="enquiry_subthree_count" value="<?php echo $enquiry_subthree_count?>" required>
           <input type="hidden" id="offer_subthree_count" name="offer_subthree_count" value="<?php echo $offer_subthree_count?>" required>
           <input type="hidden" id="sales_order_subthree_count" name="sales_order_subthree_count" value="<?php echo $sales_order_subthree_count?>" required>




           <input type="hidden" id="enquiry_subfour_count" name="enquiry_subfour_count" value="<?php echo $enquiry_subfour_count?>" required>
           <input type="hidden" id="offer_subfour_count" name="offer_subfour_count" value="<?php echo $offer_subfour_count?>" required>
           <input type="hidden" id="sales_order_subfour_count" name="sales_order_subfour_count" value="<?php echo $sales_order_subfour_count?>" required>




           <input type="hidden" id="enquiry_subfive_count" name="enquiry_subfive_count" value="<?php echo $enquiry_subfive_count?>" required>
           <input type="hidden" id="offer_subfive_count" name="offer_subfive_count" value="<?php echo $offer_subfive_count?>" required>
           <input type="hidden" id="sales_order_subfive_count" name="sales_order_subfive_count" value="<?php echo $sales_order_subfive_count?>" required>




           <input type="hidden" id="enquiry_subsix_count" name="enquiry_subsix_count" value="<?php echo $enquiry_subsix_count?>" required>
           <input type="hidden" id="offer_subsix_count" name="offer_subsix_count" value="<?php echo $offer_subsix_count?>" required>
           <input type="hidden" id="sales_order_subsix_count" name="sales_order_subsix_count" value="<?php echo $sales_order_subsix_count?>" required>

            <!-- BAR CHART -->
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Bar Chart</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            

          </div>
          <!-- /.col (RIGHT) -->

          <div class="col-md-4" >
            

            

            <!-- PIE CHART -->
            <div class="card card-danger" style="display: none;">
              <div class="card-header">
                <h3 class="card-title">Pie Chart</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            
                    <p class="text-center">
                      <strong>Orders</strong>
                    </p>

                    <div class="progress-group">
                      MH
                      <span class="float-right"><b><?php  echo $sales_order_no_MH_count; ?></b>/<?php  echo $sales_order_register_count; ?></span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-primary" style="width: <?php  echo $MH_percentage; ?>%"></div>
                      </div>
                    </div>
                    <!-- /.progress-group -->

                    <div class="progress-group">
                      PS
                      <span class="float-right"><b><?php  echo $sales_order_no_PS_count; ?></b>/<?php  echo $sales_order_register_count; ?></span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-danger" style="width: <?php  echo $PS_percentage; ?>%"></div>
                      </div>
                    </div>

                    <!-- /.progress-group -->
                    <div class="progress-group">
                      <span class="progress-text">VC</span>
                      <span class="float-right"><b><?php  echo $sales_order_no_VC_count; ?></b>/<?php  echo $sales_order_register_count; ?></span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-success" style="width: <?php  echo $VC_percentage; ?>%"></div>
                      </div>
                    </div>

                    <!-- /.progress-group -->
                    <div class="progress-group">
                      TD
                      <span class="float-right"><b><?php  echo $sales_order_no_TD_count; ?></b>/<?php  echo $sales_order_register_count; ?></span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-warning" style="width: <?php  echo $TD_percentage; ?>%"></div>
                      </div>
                    </div>
                    <!-- /.progress-group -->

                    <!-- /.progress-group -->
                    <div class="progress-group">
                      OT
                      <span class="float-right"><b><?php  echo $sales_order_no_OT_count; ?></b>/<?php  echo $sales_order_register_count; ?></span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-secondary" style="width: <?php  echo $OT_percentage; ?>%"></div>
                      </div>
                    </div>
                    <!-- /.progress-group -->
                  
                  <!-- /.col -->

          </div>
         
        </div>
        <!-- /.row -->




              </div>

              <?php 
                
                $this->db->select_sum('total_amount_with_gst');
                $this->db->from('sales_order_product_relation');
                $this->db->join('sales_order_register', 'sales_order_product_relation.sales_order_id = sales_order_register.entity_id', 'INNER');
                $where = '(sales_order_register.status = "1" )';
                $this->db->where($where);
                $query=$this->db->get();
                $total_sales_order_amount = $query->row();
                $total_sales_order_amount_final = $total_sales_order_amount->total_amount_with_gst;
                $total_amount_with_gst_new_format = number_format($total_sales_order_amount_final, 3);


                $this->db->select_sum('total_amount_with_gst');
                $this->db->from('sales_order_product_relation');
                $this->db->join('sales_order_register', 'sales_order_product_relation.sales_order_id = sales_order_register.entity_id', 'INNER');
                $where = '(sales_order_register.status = "2" )';
                $this->db->where($where);
                $query=$this->db->get();
                $total_sales_order_amount_complete = $query->row();
                $total_sales_order_amount_final_complete = $total_sales_order_amount_complete->total_amount_with_gst;
                $total_amount_with_gst_new_format_complete = number_format($total_sales_order_amount_final_complete, 3);


                $this->db->select_sum('total_amount_with_gst');
                $this->db->from('sales_order_product_relation');
                $this->db->join('sales_order_register', 'sales_order_product_relation.sales_order_id = sales_order_register.entity_id', 'INNER');
                $where = '(sales_order_register.status = "3" )';
                $this->db->where($where);
                $query=$this->db->get();
                $total_sales_order_amount_lost = $query->row();
                $total_sales_order_amount_final_lost = $total_sales_order_amount_lost->total_amount_with_gst;
                $total_amount_with_gst_new_format_lost = number_format($total_sales_order_amount_final_lost, 3);
              ?>
              <!-- ./card-body -->
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <!-- <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span> -->
                      <h5 class="description-header">Rs <?php  echo $total_amount_with_gst_new_format_complete; ?></h5>
                      <span class="description-text">Orders</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <!-- <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span> -->
                      <h5 class="description-header">Rs <?php  echo $total_amount_with_gst_new_format_lost; ?></h5>
                      <span class="description-text">Lost</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <!-- <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span> -->
                      <h5 class="description-header">$24,813.53</h5>
                      <span class="description-text">Regretted</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block">
                      <!-- <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span> -->
                      <h5 class="description-header">Rs <?php  echo $total_amount_with_gst_new_format; ?></h5>
                      <span class="description-text">Pending</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                </div>
                <!-- /.row -->
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        <?php

        $this->db->select('enquiry_register.*');
        $this->db->from('enquiry_register');
        $enquiry_register_data = $this->db->get();
        $enquiry_count_new = $enquiry_register_data->num_rows();

        if(!empty($enquiry_count_new))
        {
            $enquiry_register_data_count_new = $enquiry_count_new;
        }else{
            $enquiry_register_data_count_new = 1;
        }

        $this->db->select('*');
        $this->db->from('enquiry_register');
        $where = '(enquiry_register.enquiry_source = "'.'1'.'")';
        $this->db->where($where);
        $query = $this->db->get();
        $enquiry_source_india_mart =  $query->num_rows();
        $data_result['data'] = json_encode($enquiry_source_india_mart);

        $india_mart_percentage = $enquiry_source_india_mart/$enquiry_register_data_count_new*100;
        $india_mart_percentage_value = number_format($india_mart_percentage, 2);


        $this->db->select('*');
        $this->db->from('enquiry_register');
        $where = '(enquiry_register.enquiry_source = "'.'2'.'")';
        $this->db->where($where);
        $query = $this->db->get();
        $enquiry_source_excibition =  $query->num_rows();
        $data_result['data'] = json_encode($enquiry_source_excibition);

        $excibition_percentage = $enquiry_source_excibition/$enquiry_register_data_count_new*100;
        $excibition_percentage_value = number_format($excibition_percentage, 2);

        $this->db->select('*');
        $this->db->from('enquiry_register');
        $where = '(enquiry_register.enquiry_source = "'.'3'.'")';
        $this->db->where($where);
        $query = $this->db->get();
        $enquiry_source_mid =  $query->num_rows();
        $data_result['data'] = json_encode($enquiry_source_mid);

        $mid_percentage = $enquiry_source_mid/$enquiry_register_data_count_new*100;
        $mid_percentage_value = number_format($mid_percentage, 2);

        $this->db->select('*');
        $this->db->from('enquiry_register');
        $where = '(enquiry_register.enquiry_source = "'.'4'.'")';
        $this->db->where($where);
        $query = $this->db->get();
        $enquiry_source_phone_call =  $query->num_rows();
        $data_result['data'] = json_encode($enquiry_source_phone_call);

        $phone_call_percentage = $enquiry_source_phone_call/$enquiry_register_data_count_new*100;
        $phone_call_percentage_value = number_format($phone_call_percentage, 2);

        $this->db->select('*');
        $this->db->from('enquiry_register');
        $where = '(enquiry_register.enquiry_source = "'.'5'.'")';
        $this->db->where($where);
        $query = $this->db->get();
        $enquiry_source_direct_mail =  $query->num_rows();
        $data_result['data'] = json_encode($enquiry_source_direct_mail);

        $direct_mail_percentage = $enquiry_source_direct_mail/$enquiry_register_data_count_new*100;
        $direct_mail_percentage_value = number_format($direct_mail_percentage, 2);

        $this->db->select('*');
        $this->db->from('enquiry_register');
        $where = '(enquiry_register.enquiry_source = "'.'6'.'")';
        $this->db->where($where);
        $query = $this->db->get();
        $enquiry_source_others =  $query->num_rows();
        $data_result['data'] = json_encode($enquiry_source_others);

        $others_percentage = $enquiry_source_others/$enquiry_register_data_count_new*100;
        $others_percentage_value = number_format($others_percentage, 2);



//funnel count

/*$this->db->select('offer_register.*,offer_register.winning_chance');
            $this->db->from('offer_register');
             $where = '(offer_register.entity_id = "'.$offer_id.'" AND offer_register.winning_chance  = "'.'3'.'")';
            $this->db->where($where);     
            $offer_subfive = $this->db->get();
            $offer_winning_chance3 = $offer_subfive->num_rows();


$this->db->select('offer_register.*,offer_register.winning_chance');
            $this->db->from('offer_register');
             $where = '(offer_register.entity_id = "'.$offer_id.'" AND offer_register.winning_chance  = "'.'2'.'")';
            $this->db->where($where);     
            $offer_subfive = $this->db->get();
            $offer_winning_chance2 = $offer_subfive->num_rows();*/
      
      
      //1
      $this->db->select('*');
        $this->db->from('offer_register');
    /*$where = '(offer_register.winning_chance  = "'.'1'.'")';*/
    $where = '(offer_register.status  = "'.'8'.'")';
           
       // $where = '(offer_register.status != "'.'4'.'" or offer_register.status != "'.'5'.'" or offer_register.status != "'.'6'.'")';
        $this->db->where($where);
        $offer_register_data = $this->db->get();
        $offer_register_data_count = $offer_register_data->num_rows();

        if(!empty($offer_register_data_count))
        {
            $offer_register_count = $offer_register_data_count;
        }else{
            $offer_register_count = 1;
        }
    //winning chance 2
    
    $this->db->select('*');
        $this->db->from('offer_register');
        $where = '(offer_register.status  = "'.'9'.'")';
           
       // $where = '(offer_register.status != "'.'4'.'" or offer_register.status != "'.'5'.'" or offer_register.status != "'.'6'.'")';
        $this->db->where($where);
        $offer_register_data = $this->db->get();
        $offer_register_data_count_2 = $offer_register_data->num_rows();

        if(!empty($offer_register_data_count_2))
        {
            $offer_register_count_2 = $offer_register_data_count_2;
        }else{
            $offer_register_count_2 = 1;
        }
    
    //winning chance 3
    $this->db->select('*');
        $this->db->from('offer_register');
        $where = '(offer_register.winning_chance  = "'.'3'.'" And offer_register.status = "'.'4'.'")';
           
       // $where = '(offer_register.status != "'.'4'.'" or offer_register.status != "'.'5'.'" or offer_register.status != "'.'6'.'")';
        $this->db->where($where);
        $offer_register_data = $this->db->get();
        $offer_register_data_count_3 = $offer_register_data->num_rows();

        if(!empty($offer_register_data_count_3))
        {
            $offer_register_count_3 = $offer_register_data_count_3;
        }else{
            $offer_register_count_3 = 1;
        }
    
      
      
      /*$this->db->select('offer_register.winning_chance');
            $this->db->from('offer_register');
             $where = '(offer_register.entity_id = "'.$offer_id.'" AND offer_register.winning_chance  = "'.'1'.'")';
            $this->db->where($where);     
            $offer_subfivew = $this->db->get();
            $offer_winning_chance1 = $offer_subfivew->num_rows();*/


        ?>

        <input type="hidden" id="enquiry_source_india_mart" name="enquiry_source_india_mart" value="<?php echo $enquiry_source_india_mart?>" required>

        <input type="hidden" id="enquiry_source_excibition" name="enquiry_source_excibition" value="<?php echo $enquiry_source_excibition?>" required>

        <input type="hidden" id="enquiry_source_mid" name="enquiry_source_mid" value="<?php echo $enquiry_source_mid?>" required>

        <input type="hidden" id="enquiry_source_phone_call" name="enquiry_source_phone_call" value="<?php echo $enquiry_source_phone_call?>" required>

        <input type="hidden" id="enquiry_source_direct_mail" name="enquiry_source_direct_mail" value="<?php echo $enquiry_source_direct_mail?>" required>

        <input type="hidden" id="enquiry_source_others" name="enquiry_source_others" value="<?php echo $enquiry_source_others?>" required>

        <input type="hidden" id="india_mart_percentage" name="india_mart_percentage" value="<?php echo $india_mart_percentage?>" required>

        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <div class="col-md-6">
            <!-- MAP & BOX PANE -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Enquiry Source</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-8">
                    <!-- DONUT CHART -->
                      <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            <!-- /.card -->
                    <!-- ./chart-responsive -->
                  </div>
                  <div class="col-md-4">
                    <ul class="chart-legend clearfix">
                      <li ><i class="far fa-circle text-danger"></i> <?php echo $india_mart_percentage_value ?>%</li>
                      <li><i class="far fa-circle text-success"></i> <?php echo $excibition_percentage_value ?>%</li>
                      <li><i class="far fa-circle text-warning"></i> <?php echo $mid_percentage_value ?>%</li>
                      <li><i class="far fa-circle text-info"></i> <?php echo $phone_call_percentage_value ?>%</li>
                      <li><i class="far fa-circle" style="color: #6610f2;"></i> <?php echo $direct_mail_percentage_value ?>%</li>
                      <li><i class="far fa-circle text-secondary"></i> <?php echo $others_percentage_value ?>%</li>
                    </ul>
                  </div>
                  <!-- /.col -->
                  
                    
                  
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- /.card-body -->
             <!--  <div class="card-footer bg-white p-0">
                <ul class="nav nav-pills flex-column">
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      United States of America
                      <span class="float-right text-danger">
                        <i class="fas fa-arrow-down text-sm"></i>
                        12%</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      India
                      <span class="float-right text-success">
                        <i class="fas fa-arrow-up text-sm"></i> 4%
                      </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      China
                      <span class="float-right text-warning">
                        <i class="fas fa-arrow-left text-sm"></i> 0%
                      </span>
                    </a>
                  </li>
                </ul>
              </div> -->
              <!-- /.footer -->
            </div>
            <!-- /.card -->
            <!-- /.card -->
            
            <!-- /.row -->

            <!-- TABLE: LATEST ORDERS -->
            
            <!-- /.card -->

            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Offer Tracking Followup Notification</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>Tracking No</th>
                      <th>Tracking Date</th>
                      <th>Offer No</th>
                      <th>Tracking Record</th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php

                      $current_date = date('Y-m-d');

                      $this->db->select('offer_tracking_master.*,
                                         offer_register.offer_no');
                      $this->db->from('offer_tracking_master');
                      $where = '(offer_tracking_master.tracking_date = "'.$current_date.'")';
                      $this->db->where($where);
                      $this->db->join('offer_register', 'offer_tracking_master.offer_id = offer_register.entity_id', 'INNER');
                      $this->db->order_by('offer_tracking_master.entity_id', 'DESC');
                      // $this->db->limit(10);
                      // $this->db->group_by('sales_order_register.entity_id');
                      $query = $this->db->get();
                      $query_result = $query->result();
                      // print_r($query_result);
                      // die();

                        $no = 0;
                        foreach ($query_result as $row):
                          

                    ?>
                    <tr>

                      <td><a href="vw_offer_tracking_entry"><?php echo $row->tracking_number;?></a></td>
                      <td>
                        <div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo date("d-m-Y", strtotime($row->tracking_date));?></div>
                      </td>
                      <td><?php echo $row->offer_no;?></td>
                      <td><?php echo $row->tracking_record;?></td>
                      
                    </tr>
                    <?php endforeach;?>
                    
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <!-- <div class="card-footer clearfix">
                <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Place New Order</a>
                <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a>
              </div> -->
              <!-- /.card-footer -->
            </div>
          </div>
          <!-- /.col -->
              

          <div class="col-md-6">
            <!-- Info Boxes Style 2 -->
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Latest Orders</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>Order No. </th>
                      <th>Order Description</th>
                      <!-- <th>Status</th> -->
                      <th>Order Date</th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php

                      $this->db->select('sales_order_register.*,
                      employee_master.emp_first_name');
                      $this->db->from('sales_order_register');
                      $where = '(sales_order_register.status = "'.'2'.'" And sales_order_register.order_execution_status IS NULL)';
                      $this->db->where($where);
                      $this->db->join('employee_master', 'sales_order_register.order_engg_name = employee_master.entity_id', 'INNER');
                      $this->db->order_by('sales_order_register.entity_id', 'DESC');
                      $this->db->limit(10);
                      $this->db->group_by('sales_order_register.entity_id');
                      $query = $this->db->get();
                      $query_result = $query->result();

                        $no = 0;
                        foreach ($query_result as $row):
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

                      <td><a href=""><?php echo $row->sales_order_no;?></a></td>
                      <td><?php echo $row->sales_order_description;?></td>
                      <!-- <td><span class="badge badge-success">Shipped</span></td> -->
                      <td>
                        <div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo date("d-m-Y", strtotime($row->sales_order_date));?></div>
                      </td>
                    </tr>
                    <?php endforeach;?>
                    
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <!-- <div class="card-footer clearfix">
                <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Place New Order</a>
                <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a>
              </div> -->
              <!-- /.card-footer -->
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->

    <!-- Main content -->
    <section class="content" style="display: none;">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <!-- AREA CHART -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Area Chart</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="areaChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            

            

          </div>
          <!-- /.col (LEFT) -->
          <div class="col-md-6">
            
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Line Chart</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->

     <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
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
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url().'assets/plugins/jquery-ui/jquery-ui.min.js'?>"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

    var subactive = document.getElementById('subactive').value;

    var subone = document.getElementById('subone').value;
    var subtwo = document.getElementById('subtwo').value;
    var subthree = document.getElementById('subthree').value;
    var subfour = document.getElementById('subfour').value;
    var subfive = document.getElementById('subfive').value;
    var subsix = document.getElementById('subsix').value;

    var enquiry_subactive_count = document.getElementById('enquiry_subactive_count').value;
    var offer_subactive_count = document.getElementById('offer_subactive_count').value;
    var sales_order_subactive_count = document.getElementById('sales_order_subactive_count').value;

    var enquiry_subone_count = document.getElementById('enquiry_subone_count').value;
    var offer_subone_count = document.getElementById('offer_subone_count').value;
    var sales_order_subone_count = document.getElementById('sales_order_subone_count').value;


    var enquiry_subtwo_count = document.getElementById('enquiry_subtwo_count').value;
    var offer_subtwo_count = document.getElementById('offer_subtwo_count').value;
    var sales_order_subtwo_count = document.getElementById('sales_order_subtwo_count').value;


    var enquiry_subthree_count = document.getElementById('enquiry_subthree_count').value;
    var offer_subthree_count = document.getElementById('offer_subthree_count').value;
    var sales_order_subthree_count = document.getElementById('sales_order_subthree_count').value;


    var enquiry_subfour_count = document.getElementById('enquiry_subfour_count').value;
    var offer_subfour_count = document.getElementById('offer_subfour_count').value;
    var sales_order_subfour_count = document.getElementById('sales_order_subfour_count').value;


    var enquiry_subfive_count = document.getElementById('enquiry_subfive_count').value;
    var offer_subfive_count = document.getElementById('offer_subfive_count').value;
    var sales_order_subfive_count = document.getElementById('sales_order_subfive_count').value;


    var enquiry_subsix_count = document.getElementById('enquiry_subsix_count').value;
    var offer_subsix_count = document.getElementById('offer_subsix_count').value;
    var sales_order_subsix_count = document.getElementById('sales_order_subsix_count').value;

    var areaChartData = {
      labels  : [subsix, subfive, subfour, subthree, subtwo, subone, subactive],
      datasets: [
        {
          label               : 'Offer',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [offer_subsix_count, offer_subfive_count, offer_subfour_count, offer_subthree_count, offer_subtwo_count, offer_subone_count, offer_subactive_count]
        },
        {
          label               : 'Enquiry',
          backgroundColor     : 'rgba(210, 214, 222, 1)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [enquiry_subsix_count, enquiry_subfive_count, enquiry_subfour_count, enquiry_subthree_count, enquiry_subtwo_count, enquiry_subone_count, enquiry_subactive_count]
        },
        {
          label               : 'Orders',
          backgroundColor     : 'rgba(128,0,0)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [sales_order_subsix_count, sales_order_subfive_count, sales_order_subfour_count, sales_order_subthree_count, sales_order_subtwo_count, sales_order_subone_count, sales_order_subactive_count]
        },
        
      ]
    }

    var areaChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          }
        }]
      }
    }

    // This will get the first returned node in the jQuery collection.
    var areaChart       = new Chart(areaChartCanvas, { 
      type: 'line',
      data: areaChartData, 
      options: areaChartOptions
    })

    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
    var lineChartOptions = jQuery.extend(true, {}, areaChartOptions)
    var lineChartData = jQuery.extend(true, {}, areaChartData)
    lineChartData.datasets[0].fill = false;
    lineChartData.datasets[1].fill = false;
    lineChartOptions.datasetFill = false

    var lineChart = new Chart(lineChartCanvas, { 
      type: 'line',
      data: lineChartData, 
      options: lineChartOptions
    })

    //-------------
    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    //var enquiry_source_one = $data_result.val();
    var enquiry_source_india_mart = document.getElementById('enquiry_source_india_mart').value;
    var enquiry_source_excibition = document.getElementById('enquiry_source_excibition').value;
    var enquiry_source_mid = document.getElementById('enquiry_source_mid').value;
    var enquiry_source_phone_call = document.getElementById('enquiry_source_phone_call').value;
    var enquiry_source_direct_mail = document.getElementById('enquiry_source_direct_mail').value;
    var enquiry_source_others = document.getElementById('enquiry_source_others').value;

    var india_mart_percentage = document.getElementById('india_mart_percentage').value;
    var donutData        = {
      labels: [
          'Indiamart', 
          'Excibition',
          'MID', 
          'Phone Call', 
          'Direct Mail', 
          'Others', 
      ],
      datasets: [
        {
          data: [enquiry_source_india_mart ,enquiry_source_excibition,enquiry_source_mid,enquiry_source_phone_call,enquiry_source_direct_mail,enquiry_source_others],
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#6610f2', '#d2d6de'],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var donutChart = new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions      
    })

    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData        = donutData;
    var pieOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var pieChart = new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions      
    })

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = jQuery.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[1] = temp0

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    var barChart = new Chart(barChartCanvas, {
      type: 'bar', 
      data: barChartData,
      options: barChartOptions
    })

    //---------------------
    //- STACKED BAR CHART -
    //---------------------
    var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
    var stackedBarChartData = jQuery.extend(true, {}, barChartData)

    var stackedBarChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      scales: {
        xAxes: [{
          stacked: true,
        }],
        yAxes: [{
          stacked: true
        }]
      }
    }

    var stackedBarChart = new Chart(stackedBarChartCanvas, {
      type: 'bar', 
      data: stackedBarChartData,
      options: stackedBarChartOptions
    })
  })
</script>
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<script type="text/javascript">
window.onload = function () {
  

var chart = new CanvasJS.Chart("chartContainer", {
  title: {
    text: "Sales Funnel"
  },
  data: [{
    type: "funnel",
    indexLabel: "{label} [{y}] {label1} [{z}]",
        toolTipContent: "{label} - {y} {label1} [{z}]",
    dataPoints: [
      { y: <?php  echo $active_enquiry_count; ?>, label: "Enquiry Count"},
      
      { y: <?php  echo $offer_register_count_2; ?>, label: "Quotation Winning Chance Of B", z: <?php  echo $valuee22;?> , label1: "value"},
      { y:<?php  echo $offer_register_count; ?> , label: "Quotation Winning Chance Of A", z: <?php  echo $valuee11;?> , label1: "value"},
      { y:<?php  echo $sales_order_register_count; ?>, label: "Working/Sales Order" , z: <?php  echo $final_sales_order_amount;?> , label1: "value"}
    ]
  }]
});
chart.render();

}
</script>
<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url().'assets/plugins/bootstrap/js/bootstrap.bundle.min.js'?>"></script>
<!-- ChartJS -->
<script src="<?php echo base_url().'assets/plugins/chart.js/Chart.min.js'?>"></script>
<!-- Sparkline -->
<script src="<?php echo base_url().'assets/plugins/sparklines/sparkline.js'?>"></script>
<!-- JQVMap -->
<script src="<?php echo base_url().'assets/plugins/jqvmap/jquery.vmap.min.js'?>"></script>
<script src="<?php echo base_url().'assets/plugins/jqvmap/maps/jquery.vmap.usa.js'?>"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url().'assets/plugins/jquery-knob/jquery.knob.min.js'?>"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url().'assets/plugins/moment/moment.min.js'?>"></script>
<script src="<?php echo base_url().'assets/plugins/daterangepicker/daterangepicker.js'?>"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url().'assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js'?>"></script>
<!-- Summernote -->
<script src="<?php echo base_url().'assets/plugins/summernote/summernote-bs4.min.js'?>"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url().'assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js'?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url().'assets/dist/js/adminlte.js'?>"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="assets/dist/js/pages/dashboard.js'?>"></script> -->

<script src="<?php echo base_url().'assets/dist/js/pages/dashboard2.js'?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url().'assets/dist/js/demo.js'?>"></script>


<script src="<?php echo base_url().'assets/plugins/jquery/jquery.min.js'?>"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url().'assets/plugins/bootstrap/js/bootstrap.bundle.min.js'?>"></script>
<!-- ChartJS -->
<script src="<?php echo base_url().'assets/plugins/chart.js/Chart.min.js'?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url().'assets/dist/js/adminlte.min.js'?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url().'assets/dist/js/demo.js'?>"></script>
<!-- DataTables -->
<script src="<?php echo base_url().'assets/plugins/datatables/jquery.dataTables.js'?>"></script>
<script src="<?php echo base_url().'assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js'?>"></script>
<script>
            $(document).ready( function () {
                $('#example1').DataTable();
            } );
            </script>

            <script type="text/javascript">
              $(document).on('click', '#add_labour', function () {
                
                var Track_id = document.getElementById('Track_id').value;
                var due_date = document.getElementById('pop_up_due_date').value;
                var remark = document.getElementById('pop_up_remark').value;
                var status = document.getElementById('pop_up_status').value;
                var offer_id = document.getElementById('pop_up_offer_id').value;
                

                if(Track_id != "" && due_date != "" && remark != "" && status != "" && offer_id != "")

                {   
                    $.ajax({
                        url:"<?php echo site_url('welcome/update_tracking_details');?>",
                        type: 'POST',
                        data: {'Track_id': Track_id , 'due_date' : due_date , 'remark' : remark, 'status' : status , 'offer_id' : offer_id},
                        success : function(data) {
                            data = data.trim();
                            if(data==3 || data=='3')
                            {
                              var redirect = "<?php echo site_url('create_customer_sales_order');?>";
                              window.location=redirect;
                            }
                            {
                              location.reload();
                            }
                        },
                        error: function(){
                         alert("Fail")
                        }
                    });
                }else{
                    alert("Enter All Details.....");
                }
            });
            </script>
</body>
</html>
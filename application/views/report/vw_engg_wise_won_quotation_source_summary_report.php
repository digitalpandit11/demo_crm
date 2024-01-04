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
        <title>Won Quotation Source Summary Report</title>
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
                                    <h1 class="card-title">Won Quotation Source Summary Report</h1>
                                    <div class="col-sm-6">
                                        <br><br>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?php echo base_url().'dashboard'?>">Home</a></li>
                                            <li class="breadcrumb-item">Won Quotation Source Summary Report
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
                                    <?php

                                        $current_date = date('Y-m-d');
                                        $first_day_of_current_month = date('Y-m-d',strtotime($current_date.'first day of this month'));


                                        //for 12th month 
                                        $day11 = date('Y-m-d');
                                        $month11 = strtoupper(date('Y-M', strtotime($first_day_of_current_month. "-11 Month")));
                                        $first_date_of_11month = date('Y-m-d',strtotime($month11.'first day of this month'));
                                        $last_date_of_11month = date('Y-m-d',strtotime($month11.'last day of this month'));

                                        //for 11th month 
                                        $day10 = date('');
                                        $month10 = strtoupper(date('Y-M', strtotime($first_day_of_current_month. "-10 Month")));
                                        $first_date_of_10month = date('Y-m-d',strtotime($month10.'first day of this month'));
                                        $last_date_of_10month = date('Y-m-d',strtotime($month10.'last day of this month'));

                                        //for 10th month 
                                        $day9 = date('Y-m-d');
                                        $month9 = strtoupper(date('Y-M', strtotime($first_day_of_current_month. "-9 Month")));
                                        $first_date_of_9month = date('Y-m-d',strtotime($month9.'first day of this month'));
                                        $last_date_of_9month = date('Y-m-d',strtotime($month9.'last day of this month'));

                                        //for 9th month 
                                        $day8 = date('Y-m-d');
                                        $month8 = strtoupper(date('Y-M', strtotime($first_day_of_current_month. "-8 Month")));
                                        $first_date_of_8month = date('Y-m-d',strtotime($month8.'first day of this month'));
                                        $last_date_of_8month = date('Y-m-d',strtotime($month8.'last day of this month'));

                                        //for 8th month 
                                        $day7 = date('Y-m-d');
                                        $month7 = strtoupper(date('Y-M', strtotime($first_day_of_current_month. "-7 Month")));
                                        $first_date_of_7month = date('Y-m-d',strtotime($month7.'first day of this month'));
                                        $last_date_of_7month = date('Y-m-d',strtotime($month7.'last day of this month'));

                                        //for 7th month 
                                        $day6 = date('Y-m-d');
                                        $month6 = strtoupper(date('Y-M', strtotime($first_day_of_current_month. "-6 Month")));
                                    
                                        $first_date_of_6month = date('Y-m-d',strtotime($month6 .'first day of this month'));
                                        $last_date_of_6month = date('Y-m-d',strtotime($month6 .'last day of this month'));

                                        //for 6th month 
                                        $day5 = date('Y-m-d');
                                        $month5 = strtoupper(date('Y-M', strtotime($first_day_of_current_month. "-5 Month")));
                                        $first_date_of_5month = date('Y-m-d',strtotime($month5.'first day of this month'));
                                        $last_date_of_5month = date('Y-m-d',strtotime($month5.'last day of this month'));

                                        //for 5th month 
                                        $day4 = date('');
                                        $month4 = strtoupper(date('Y-M', strtotime($first_day_of_current_month. "-4 Month")));
                                        $first_date_of_4month = date('Y-m-d',strtotime($month4.'first day of this month'));
                                        $last_date_of_4month = date('Y-m-d',strtotime($month4.'last day of this month'));

                                        //for 4th month 
                                        $day3 = date('Y-m-d');
                                        $month3 = strtoupper(date('Y-M', strtotime($first_day_of_current_month. "-3 Month")));
                                        $first_date_of_3month = date('Y-m-d',strtotime($month3.'first day of this month'));
                                        $last_date_of_3month = date('Y-m-d',strtotime($month3.'last day of this month'));

                                        //for 3th month 
                                        $day2 = date('Y-m-d');
                                        $month2 = strtoupper(date('Y-M', strtotime($first_day_of_current_month. "-2 Month")));
                                        $first_date_of_2month = date('Y-m-d',strtotime($month2.'first day of this month'));
                                        $last_date_of_2month = date('Y-m-d',strtotime($month2.'last day of this month'));

                                        //for 2th month 
                                        $day1 = date('Y-m-d');
                                        $month1 = strtoupper(date('Y-M', strtotime($first_day_of_current_month. "-1 Month")));
                                        $first_date_of_1month = date('Y-m-d',strtotime($month1.'first day of this month'));
                                        $last_date_of_1month = date('Y-m-d',strtotime($month1.'last day of this month'));

                                        //for 1th month 
                                        $day0 = date('Y-m-d');
                                        $month0 = strtoupper(date('Y-M', strtotime($first_day_of_current_month. "-0 Month")));
                                    
                                        $first_date_of_0month = date('Y-m-d',strtotime($month0 .'first day of this month'));
                                        $last_date_of_0month = date('Y-m-d',strtotime($month0 .'last day of this month'));


                                        //deifne variables

                                        $offer_engg_name = $offer_engg_name;

                                        $indiamart_v0 = "" ;
                                        $indiamart_c0 = "" ;
                                        $tradeindia_v0 = "" ;
                                        $tradeindia_c0 = "" ;
                                        $exporter_v0 = "" ;
                                        $exporter_c0 = "" ;
                                        $campaign_v0 = "" ;
                                        $campaign_c0 = "" ;
                                        $coldcall_v0 = "" ;
                                        $coldcall_c0 = "" ;
                                        $conference_v0 = "" ;
                                        $conference_c0 = "" ;
                                        $directcall_v0 = "" ;
                                        $directcall_c0 = "" ;
                                        $existing_v0 = "" ;
                                        $existing_c0 = "" ;
                                        $email_v0 = "" ;
                                        $email_c0 = "" ;
                                        $expo_v0 = "" ;
                                        $expo_c0 = "" ;
                                        $gem_v0 = "" ;
                                        $gem_c0 = "" ;
                                        $other_v0 = "" ;
                                        $other_c0 = "" ;
                                        $principle_v0 = "" ;
                                        $principle_c0 = "" ;
                                        $publicrelation_v0 = "" ;
                                        $publicrelation_c0 = "" ;
                                        $self_v0 = "" ;
                                        $self_c0 = "" ;
                                        $website_v0 = "" ;
                                        $website_c0 = "" ;
                                        $mouth_v0 = "" ;
                                        $mouth_c0 = "" ;
                                        $olddb_v0 = "" ;
                                        $olddb_c0 = "" ;
                                        $mid_v0 = "" ;
                                        $mid_c0 = "" ;
                                        $gid_v0 = "" ;
                                        $gid_c0 = "" ;
                                        $directmail_v0 = "" ;
                                        $directmail_c0 = "" ;
                                        $partner_v0 = "" ;
                                        $partner_c0 = "" ;
                                        $visit_v0 = "" ;
                                        $visit_c0 = "" ;
                                        $indiamart_v1 = "" ;
                                        $indiamart_c1 = "" ;
                                        $tradeindia_v1 = "" ;
                                        $tradeindia_c1 = "" ;
                                        $exporter_v1 = "" ;
                                        $exporter_c1 = "" ;
                                        $campaign_v1 = "" ;
                                        $campaign_c1 = "" ;
                                        $coldcall_v1 = "" ;
                                        $coldcall_c1 = "" ;
                                        $conference_v1 = "" ;
                                        $conference_c1 = "" ;
                                        $directcall_v1 = "" ;
                                        $directcall_c1 = "" ;
                                        $existing_v1 = "" ;
                                        $existing_c1 = "" ;
                                        $email_v1 = "" ;
                                        $email_c1 = "" ;
                                        $expo_v1 = "" ;
                                        $expo_c1 = "" ;
                                        $gem_v1 = "" ;
                                        $gem_c1 = "" ;
                                        $other_v1 = "" ;
                                        $other_c1 = "" ;
                                        $principle_v1 = "" ;
                                        $principle_c1 = "" ;
                                        $publicrelation_v1 = "" ;
                                        $publicrelation_c1 = "" ;
                                        $self_v1 = "" ;
                                        $self_c1 = "" ;
                                        $website_v1 = "" ;
                                        $website_c1 = "" ;
                                        $mouth_v1 = "" ;
                                        $mouth_c1 = "" ;
                                        $olddb_v1 = "" ;
                                        $olddb_c1 = "" ;
                                        $mid_v1 = "" ;
                                        $mid_c1 = "" ;
                                        $gid_v1 = "" ;
                                        $gid_c1 = "" ;
                                        $directmail_v1 = "" ;
                                        $directmail_c1 = "" ;
                                        $partner_v1 = "" ;
                                        $partner_c1 = "" ;
                                        $visit_v1 = "" ;
                                        $visit_c1 = "" ;
                                        $indiamart_v2 = "" ;
                                        $indiamart_c2 = "" ;
                                        $tradeindia_v2 = "" ;
                                        $tradeindia_c2 = "" ;
                                        $exporter_v2 = "" ;
                                        $exporter_c2 = "" ;
                                        $campaign_v2 = "" ;
                                        $campaign_c2 = "" ;
                                        $coldcall_v2 = "" ;
                                        $coldcall_c2 = "" ;
                                        $conference_v2 = "" ;
                                        $conference_c2 = "" ;
                                        $directcall_v2 = "" ;
                                        $directcall_c2 = "" ;
                                        $existing_v2 = "" ;
                                        $existing_c2 = "" ;
                                        $email_v2 = "" ;
                                        $email_c2 = "" ;
                                        $expo_v2 = "" ;
                                        $expo_c2 = "" ;
                                        $gem_v2 = "" ;
                                        $gem_c2 = "" ;
                                        $other_v2 = "" ;
                                        $other_c2 = "" ;
                                        $principle_v2 = "" ;
                                        $principle_c2 = "" ;
                                        $publicrelation_v2 = "" ;
                                        $publicrelation_c2 = "" ;
                                        $self_v2 = "" ;
                                        $self_c2 = "" ;
                                        $website_v2 = "" ;
                                        $website_c2 = "" ;
                                        $mouth_v2 = "" ;
                                        $mouth_c2 = "" ;
                                        $olddb_v2 = "" ;
                                        $olddb_c2 = "" ;
                                        $mid_v2 = "" ;
                                        $mid_c2 = "" ;
                                        $gid_v2 = "" ;
                                        $gid_c2 = "" ;
                                        $directmail_v2 = "" ;
                                        $directmail_c2 = "" ;
                                        $partner_v2 = "" ;
                                        $partner_c2 = "" ;
                                        $visit_v2 = "" ;
                                        $visit_c2 = "" ;
                                        $indiamart_v3 = "" ;
                                        $indiamart_c3 = "" ;
                                        $tradeindia_v3 = "" ;
                                        $tradeindia_c3 = "" ;
                                        $exporter_v3 = "" ;
                                        $exporter_c3 = "" ;
                                        $campaign_v3 = "" ;
                                        $campaign_c3 = "" ;
                                        $coldcall_v3 = "" ;
                                        $coldcall_c3 = "" ;
                                        $conference_v3 = "" ;
                                        $conference_c3 = "" ;
                                        $directcall_v3 = "" ;
                                        $directcall_c3 = "" ;
                                        $existing_v3 = "" ;
                                        $existing_c3 = "" ;
                                        $email_v3 = "" ;
                                        $email_c3 = "" ;
                                        $expo_v3 = "" ;
                                        $expo_c3 = "" ;
                                        $gem_v3 = "" ;
                                        $gem_c3 = "" ;
                                        $other_v3 = "" ;
                                        $other_c3 = "" ;
                                        $principle_v3 = "" ;
                                        $principle_c3 = "" ;
                                        $publicrelation_v3 = "" ;
                                        $publicrelation_c3 = "" ;
                                        $self_v3 = "" ;
                                        $self_c3 = "" ;
                                        $website_v3 = "" ;
                                        $website_c3 = "" ;
                                        $mouth_v3 = "" ;
                                        $mouth_c3 = "" ;
                                        $olddb_v3 = "" ;
                                        $olddb_c3 = "" ;
                                        $mid_v3 = "" ;
                                        $mid_c3 = "" ;
                                        $gid_v3 = "" ;
                                        $gid_c3 = "" ;
                                        $directmail_v3 = "" ;
                                        $directmail_c3 = "" ;
                                        $partner_v3 = "" ;
                                        $partner_c3 = "" ;
                                        $visit_v3 = "" ;
                                        $visit_c3 = "" ;
                                        $indiamart_v4 = "" ;
                                        $indiamart_c4 = "" ;
                                        $tradeindia_v4 = "" ;
                                        $tradeindia_c4 = "" ;
                                        $exporter_v4 = "" ;
                                        $exporter_c4 = "" ;
                                        $campaign_v4 = "" ;
                                        $campaign_c4 = "" ;
                                        $coldcall_v4 = "" ;
                                        $coldcall_c4 = "" ;
                                        $conference_v4 = "" ;
                                        $conference_c4 = "" ;
                                        $directcall_v4 = "" ;
                                        $directcall_c4 = "" ;
                                        $existing_v4 = "" ;
                                        $existing_c4 = "" ;
                                        $email_v4 = "" ;
                                        $email_c4 = "" ;
                                        $expo_v4 = "" ;
                                        $expo_c4 = "" ;
                                        $gem_v4 = "" ;
                                        $gem_c4 = "" ;
                                        $other_v4 = "" ;
                                        $other_c4 = "" ;
                                        $principle_v4 = "" ;
                                        $principle_c4 = "" ;
                                        $publicrelation_v4 = "" ;
                                        $publicrelation_c4 = "" ;
                                        $self_v4 = "" ;
                                        $self_c4 = "" ;
                                        $website_v4 = "" ;
                                        $website_c4 = "" ;
                                        $mouth_v4 = "" ;
                                        $mouth_c4 = "" ;
                                        $olddb_v4 = "" ;
                                        $olddb_c4 = "" ;
                                        $mid_v4 = "" ;
                                        $mid_c4 = "" ;
                                        $gid_v4 = "" ;
                                        $gid_c4 = "" ;
                                        $directmail_v4 = "" ;
                                        $directmail_c4 = "" ;
                                        $partner_v4 = "" ;
                                        $partner_c4 = "" ;
                                        $visit_v4 = "" ;
                                        $visit_c4 = "" ;
                                        $indiamart_v5 = "" ;
                                        $indiamart_c5 = "" ;
                                        $tradeindia_v5 = "" ;
                                        $tradeindia_c5 = "" ;
                                        $exporter_v5 = "" ;
                                        $exporter_c5 = "" ;
                                        $campaign_v5 = "" ;
                                        $campaign_c5 = "" ;
                                        $coldcall_v5 = "" ;
                                        $coldcall_c5 = "" ;
                                        $conference_v5 = "" ;
                                        $conference_c5 = "" ;
                                        $directcall_v5 = "" ;
                                        $directcall_c5 = "" ;
                                        $existing_v5 = "" ;
                                        $existing_c5 = "" ;
                                        $email_v5 = "" ;
                                        $email_c5 = "" ;
                                        $expo_v5 = "" ;
                                        $expo_c5 = "" ;
                                        $gem_v5 = "" ;
                                        $gem_c5 = "" ;
                                        $other_v5 = "" ;
                                        $other_c5 = "" ;
                                        $principle_v5 = "" ;
                                        $principle_c5 = "" ;
                                        $publicrelation_v5 = "" ;
                                        $publicrelation_c5 = "" ;
                                        $self_v5 = "" ;
                                        $self_c5 = "" ;
                                        $website_v5 = "" ;
                                        $website_c5 = "" ;
                                        $mouth_v5 = "" ;
                                        $mouth_c5 = "" ;
                                        $olddb_v5 = "" ;
                                        $olddb_c5 = "" ;
                                        $mid_v5 = "" ;
                                        $mid_c5 = "" ;
                                        $gid_v5 = "" ;
                                        $gid_c5 = "" ;
                                        $directmail_v5 = "" ;
                                        $directmail_c5 = "" ;
                                        $partner_v5 = "" ;
                                        $partner_c5 = "" ;
                                        $visit_v5 = "" ;
                                        $visit_c5 = "" ;
                                        $indiamart_v6 = "" ;
                                        $indiamart_c6 = "" ;
                                        $tradeindia_v6 = "" ;
                                        $tradeindia_c6 = "" ;
                                        $exporter_v6 = "" ;
                                        $exporter_c6 = "" ;
                                        $campaign_v6 = "" ;
                                        $campaign_c6 = "" ;
                                        $coldcall_v6 = "" ;
                                        $coldcall_c6 = "" ;
                                        $conference_v6 = "" ;
                                        $conference_c6 = "" ;
                                        $directcall_v6 = "" ;
                                        $directcall_c6 = "" ;
                                        $existing_v6 = "" ;
                                        $existing_c6 = "" ;
                                        $email_v6 = "" ;
                                        $email_c6 = "" ;
                                        $expo_v6 = "" ;
                                        $expo_c6 = "" ;
                                        $gem_v6 = "" ;
                                        $gem_c6 = "" ;
                                        $other_v6 = "" ;
                                        $other_c6 = "" ;
                                        $principle_v6 = "" ;
                                        $principle_c6 = "" ;
                                        $publicrelation_v6 = "" ;
                                        $publicrelation_c6 = "" ;
                                        $self_v6 = "" ;
                                        $self_c6 = "" ;
                                        $website_v6 = "" ;
                                        $website_c6 = "" ;
                                        $mouth_v6 = "" ;
                                        $mouth_c6 = "" ;
                                        $olddb_v6 = "" ;
                                        $olddb_c6 = "" ;
                                        $mid_v6 = "" ;
                                        $mid_c6 = "" ;
                                        $gid_v6 = "" ;
                                        $gid_c6 = "" ;
                                        $directmail_v6 = "" ;
                                        $directmail_c6 = "" ;
                                        $partner_v6 = "" ;
                                        $partner_c6 = "" ;
                                        $visit_v6 = "" ;
                                        $visit_c6 = "" ;
                                        $indiamart_v7 = "" ;
                                        $indiamart_c7 = "" ;
                                        $tradeindia_v7 = "" ;
                                        $tradeindia_c7 = "" ;
                                        $exporter_v7 = "" ;
                                        $exporter_c7 = "" ;
                                        $campaign_v7 = "" ;
                                        $campaign_c7 = "" ;
                                        $coldcall_v7 = "" ;
                                        $coldcall_c7 = "" ;
                                        $conference_v7 = "" ;
                                        $conference_c7 = "" ;
                                        $directcall_v7 = "" ;
                                        $directcall_c7 = "" ;
                                        $existing_v7 = "" ;
                                        $existing_c7 = "" ;
                                        $email_v7 = "" ;
                                        $email_c7 = "" ;
                                        $expo_v7 = "" ;
                                        $expo_c7 = "" ;
                                        $gem_v7 = "" ;
                                        $gem_c7 = "" ;
                                        $other_v7 = "" ;
                                        $other_c7 = "" ;
                                        $principle_v7 = "" ;
                                        $principle_c7 = "" ;
                                        $publicrelation_v7 = "" ;
                                        $publicrelation_c7 = "" ;
                                        $self_v7 = "" ;
                                        $self_c7 = "" ;
                                        $website_v7 = "" ;
                                        $website_c7 = "" ;
                                        $mouth_v7 = "" ;
                                        $mouth_c7 = "" ;
                                        $olddb_v7 = "" ;
                                        $olddb_c7 = "" ;
                                        $mid_v7 = "" ;
                                        $mid_c7 = "" ;
                                        $gid_v7 = "" ;
                                        $gid_c7 = "" ;
                                        $directmail_v7 = "" ;
                                        $directmail_c7 = "" ;
                                        $partner_v7 = "" ;
                                        $partner_c7 = "" ;
                                        $visit_v7 = "" ;
                                        $visit_c7 = "" ;
                                        $indiamart_v8 = "" ;
                                        $indiamart_c8 = "" ;
                                        $tradeindia_v8 = "" ;
                                        $tradeindia_c8 = "" ;
                                        $exporter_v8 = "" ;
                                        $exporter_c8 = "" ;
                                        $campaign_v8 = "" ;
                                        $campaign_c8 = "" ;
                                        $coldcall_v8 = "" ;
                                        $coldcall_c8 = "" ;
                                        $conference_v8 = "" ;
                                        $conference_c8 = "" ;
                                        $directcall_v8 = "" ;
                                        $directcall_c8 = "" ;
                                        $existing_v8 = "" ;
                                        $existing_c8 = "" ;
                                        $email_v8 = "" ;
                                        $email_c8 = "" ;
                                        $expo_v8 = "" ;
                                        $expo_c8 = "" ;
                                        $gem_v8 = "" ;
                                        $gem_c8 = "" ;
                                        $other_v8 = "" ;
                                        $other_c8 = "" ;
                                        $principle_v8 = "" ;
                                        $principle_c8 = "" ;
                                        $publicrelation_v8 = "" ;
                                        $publicrelation_c8 = "" ;
                                        $self_v8 = "" ;
                                        $self_c8 = "" ;
                                        $website_v8 = "" ;
                                        $website_c8 = "" ;
                                        $mouth_v8 = "" ;
                                        $mouth_c8 = "" ;
                                        $olddb_v8 = "" ;
                                        $olddb_c8 = "" ;
                                        $mid_v8 = "" ;
                                        $mid_c8 = "" ;
                                        $gid_v8 = "" ;
                                        $gid_c8 = "" ;
                                        $directmail_v8 = "" ;
                                        $directmail_c8 = "" ;
                                        $partner_v8 = "" ;
                                        $partner_c8 = "" ;
                                        $visit_v8 = "" ;
                                        $visit_c8 = "" ;
                                        $indiamart_v9 = "" ;
                                        $indiamart_c9 = "" ;
                                        $tradeindia_v9 = "" ;
                                        $tradeindia_c9 = "" ;
                                        $exporter_v9 = "" ;
                                        $exporter_c9 = "" ;
                                        $campaign_v9 = "" ;
                                        $campaign_c9 = "" ;
                                        $coldcall_v9 = "" ;
                                        $coldcall_c9 = "" ;
                                        $conference_v9 = "" ;
                                        $conference_c9 = "" ;
                                        $directcall_v9 = "" ;
                                        $directcall_c9 = "" ;
                                        $existing_v9 = "" ;
                                        $existing_c9 = "" ;
                                        $email_v9 = "" ;
                                        $email_c9 = "" ;
                                        $expo_v9 = "" ;
                                        $expo_c9 = "" ;
                                        $gem_v9 = "" ;
                                        $gem_c9 = "" ;
                                        $other_v9 = "" ;
                                        $other_c9 = "" ;
                                        $principle_v9 = "" ;
                                        $principle_c9 = "" ;
                                        $publicrelation_v9 = "" ;
                                        $publicrelation_c9 = "" ;
                                        $self_v9 = "" ;
                                        $self_c9 = "" ;
                                        $website_v9 = "" ;
                                        $website_c9 = "" ;
                                        $mouth_v9 = "" ;
                                        $mouth_c9 = "" ;
                                        $olddb_v9 = "" ;
                                        $olddb_c9 = "" ;
                                        $mid_v9 = "" ;
                                        $mid_c9 = "" ;
                                        $gid_v9 = "" ;
                                        $gid_c9 = "" ;
                                        $directmail_v9 = "" ;
                                        $directmail_c9 = "" ;
                                        $partner_v9 = "" ;
                                        $partner_c9 = "" ;
                                        $visit_v9 = "" ;
                                        $visit_c9 = "" ;
                                        $indiamart_v10 = "" ;
                                        $indiamart_c10 = "" ;
                                        $tradeindia_v10 = "" ;
                                        $tradeindia_c10 = "" ;
                                        $exporter_v10 = "" ;
                                        $exporter_c10 = "" ;
                                        $campaign_v10 = "" ;
                                        $campaign_c10 = "" ;
                                        $coldcall_v10 = "" ;
                                        $coldcall_c10 = "" ;
                                        $conference_v10 = "" ;
                                        $conference_c10 = "" ;
                                        $directcall_v10 = "" ;
                                        $directcall_c10 = "" ;
                                        $existing_v10 = "" ;
                                        $existing_c10 = "" ;
                                        $email_v10 = "" ;
                                        $email_c10 = "" ;
                                        $expo_v10 = "" ;
                                        $expo_c10 = "" ;
                                        $gem_v10 = "" ;
                                        $gem_c10 = "" ;
                                        $other_v10 = "" ;
                                        $other_c10 = "" ;
                                        $principle_v10 = "" ;
                                        $principle_c10 = "" ;
                                        $publicrelation_v10 = "" ;
                                        $publicrelation_c10 = "" ;
                                        $self_v10 = "" ;
                                        $self_c10 = "" ;
                                        $website_v10 = "" ;
                                        $website_c10 = "" ;
                                        $mouth_v10 = "" ;
                                        $mouth_c10 = "" ;
                                        $olddb_v10 = "" ;
                                        $olddb_c10 = "" ;
                                        $mid_v10 = "" ;
                                        $mid_c10 = "" ;
                                        $gid_v10 = "" ;
                                        $gid_c10 = "" ;
                                        $directmail_v10 = "" ;
                                        $directmail_c10 = "" ;
                                        $partner_v10 = "" ;
                                        $partner_c10 = "" ;
                                        $visit_v10 = "" ;
                                        $visit_c10 = "" ;
                                        $indiamart_v11 = "" ;
                                        $indiamart_c11 = "" ;
                                        $tradeindia_v11 = "" ;
                                        $tradeindia_c11 = "" ;
                                        $exporter_v11 = "" ;
                                        $exporter_c11 = "" ;
                                        $campaign_v11 = "" ;
                                        $campaign_c11 = "" ;
                                        $coldcall_v11 = "" ;
                                        $coldcall_c11 = "" ;
                                        $conference_v11 = "" ;
                                        $conference_c11 = "" ;
                                        $directcall_v11 = "" ;
                                        $directcall_c11 = "" ;
                                        $existing_v11 = "" ;
                                        $existing_c11 = "" ;
                                        $email_v11 = "" ;
                                        $email_c11 = "" ;
                                        $expo_v11 = "" ;
                                        $expo_c11 = "" ;
                                        $gem_v11 = "" ;
                                        $gem_c11 = "" ;
                                        $other_v11 = "" ;
                                        $other_c11 = "" ;
                                        $principle_v11 = "" ;
                                        $principle_c11 = "" ;
                                        $publicrelation_v11 = "" ;
                                        $publicrelation_c11 = "" ;
                                        $self_v11 = "" ;
                                        $self_c11 = "" ;
                                        $website_v11 = "" ;
                                        $website_c11 = "" ;
                                        $mouth_v11 = "" ;
                                        $mouth_c11 = "" ;
                                        $olddb_v11 = "" ;
                                        $olddb_c11 = "" ;
                                        $mid_v11 = "" ;
                                        $mid_c11 = "" ;
                                        $gid_v11 = "" ;
                                        $gid_c11 = "" ;
                                        $directmail_v11 = "" ;
                                        $directmail_c11 = "" ;
                                        $partner_v11 = "" ;
                                        $partner_c11 = "" ;
                                        $visit_v11 = "" ;
                                        $visit_c11 = "" ;


                                        ////month0

                                        $this->db->select('offer_register.offer_source, enquiry_source_master.source_name, sum(offer_product_relation.total_amount_without_gst) as amt,count(DISTINCT(offer_register.entity_id)) as count');
                                        $this->db->from('offer_product_relation');
                                        $this->db->join('offer_register', 'offer_register.entity_id = offer_product_relation.offer_id','inner');
                                        $this->db->join('enquiry_source_master', 'enquiry_source_master.entity_id = offer_register.offer_source','inner');
                                        $where = '(offer_register.offer_close_date >= "'.$first_date_of_0month.'" And offer_register.offer_close_date <= "'.$last_date_of_0month.'" And offer_register.offer_engg_name ="'. $offer_engg_name.'"  And offer_register.status ="6" )';
                                        $this->db->where($where);
                                        $this->db->group_by('offer_register.offer_source');
                                        $query = $this->db->get();
                                        $query_result = $query->result();

                                        foreach ($query_result as $key => $value) {
                                          // echo '<pre>';
                                          // print_r($value);
                                          // die();
                                          
                                          switch($value->offer_source){

                                            case 1:
                                            
                                              $indiamart_v0 = number_format($value->amt / 1000, 0, '.', '');
                                              $indiamart_c0 = $value->count;
                                            
                                            break;

                                            case 2:
                                              
                                              $tradeindia_v0 = number_format($value->amt / 1000, 0, '.', '');
                                              $tradeindia_c0 = $value->count;
                                            
                                            
                                            
                                            break;

                                            case 3:
                                              $exporter_v0 = number_format($value->amt / 1000, 0, '.', '');
                                              $exporter_c0 = $value->count;
                                            
                                            break;

                                            case 4:
                                            
                                            $campaign_v0 = number_format($value->amt / 1000, 0, '.', '');
                                            $campaign_c0 = $value->count;
                                            
                                            break;

                                            case 5:
                                            
                                              $coldcall_v0 = number_format($value->amt / 1000, 0, '.', '');
                                              $coldcall_c0 = $value->count;
                                              
                                            break;

                                            case 6:
                                            
                                              $conference_v0 = number_format($value->amt / 1000, 0, '.', '');
                                              $conference_c0 = $value->count;
                                              
                                            
                                            break;

                                            
                                            case 7:
                                            
                                              $directcall_v0 = number_format($value->amt / 1000, 0, '.', '');
                                              $directcall_c0 = $value->count;
                                              
                                            break;
                                            
                                            case 8:
                                            
                                              $existing_v0 = number_format($value->amt / 1000, 0, '.', '');
                                              $existing_c0 = $value->count;
                                              
                                            break;


                                            case 9:
                                            
                                            
                                              $email_v0 = number_format($value->amt / 1000, 0, '.', '');
                                              $email_c0 = $value->count;
                                              
                                            break;
                                            
                                            case 10:
                                            
                                              $expo_v0 = number_format($value->amt / 1000, 0, '.', '');
                                              $expo_c0 = $value->count;
                                              
                                            
                                            break;


                                            case 11:
                                            
                                              $gem_v0 = number_format($value->amt / 1000, 0, '.', '');
                                              $gem_c0 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 12:
                                            
                                            
                                              $other_v0 = number_format($value->amt / 1000, 0, '.', '');
                                              $other_c0 = $value->count;
                                              
                                            break;


                                            case 13:
                                            
                                              $principle_v0 = number_format($value->amt / 1000, 0, '.', '');
                                              $principle_c0 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 14:
                                            
                                              $publicrelation_v0 = number_format($value->amt / 1000, 0, '.', '');
                                              $publicrelation_c0 = $value->count;
                                              
                                            
                                            break;


                                            case 15:
                                           
                                              $self_v0 = number_format($value->amt / 1000, 0, '.', '');
                                              $self_c0 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 16:
                                            
                                            
                                              $website_v0 = number_format($value->amt / 1000, 0, '.', '');
                                              $website_c0 = $value->count;
                                              
                                            break;



                                            case 17:
                                            
                                              $mouth_v0 = number_format($value->amt / 1000, 0, '.', '');
                                              $mouth_c0 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 18:
                                            
                                              $olddb_v0 = number_format($value->amt / 1000, 0, '.', '');
                                              $olddb_c0 = $value->count;
                                              
                                            
                                            break;


                                            case 19:
                                            
                                              $mid_v0 = number_format($value->amt / 1000, 0, '.', '');
                                              $mid_c0 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 20:
                                            
                                              $gid_v0 = number_format($value->amt / 1000, 0, '.', '');
                                              $gid_c0 = $value->count;
                                              
                                            
                                            break;


                                            case 21:
                                           
                                              $directmail_v0 = number_format($value->amt / 1000, 0, '.', '');
                                              $directmail_c0 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 22:
                                            
                                              $partner_v0 = number_format($value->amt / 1000, 0, '.', '');
                                              $partner_c0 = $value->count;
                                              
                                            
                                            break;

                                            
                                            case 23:
                                            
                                              $visit_v0 = number_format($value->amt / 1000, 0, '.', '');
                                              $visit_c0 = $value->count;
                                              
                                            
                                            break;


                                            default :
                                            echo 'no match';
                                            break;
                                            
                                          }
                                        }
                                      


                                        ////month1

                                         $this->db->select('offer_register.offer_source, enquiry_source_master.source_name, sum(offer_product_relation.total_amount_without_gst) as amt,count(DISTINCT(offer_register.entity_id)) as count');
                                        $this->db->from('offer_product_relation');
                                        $this->db->join('offer_register', 'offer_register.entity_id = offer_product_relation.offer_id','inner');
                                        $this->db->join('enquiry_source_master', 'enquiry_source_master.entity_id = offer_register.offer_source','inner');
                                        $where = '(offer_register.offer_close_date >= "'.$first_date_of_1month.'" And offer_register.offer_close_date <= "'.$last_date_of_1month.'" And offer_register.offer_engg_name ="'. $offer_engg_name.'" And offer_register.status ="6" )';
                                        $this->db->where($where);
                                        $this->db->group_by('offer_register.offer_source');
                                        $query = $this->db->get();
                                        $query_result = $query->result();

                                        foreach ($query_result as $key => $value) {
                                          // echo '<pre>';
                                          // print_r($value);
                                          // die();
                                          
                                          switch($value->offer_source){

                                            case 1:
                                            
                                              $indiamart_v1 = number_format($value->amt / 1000, 0, '.', '');
                                              $indiamart_c1 = $value->count;
                                            
                                            break;

                                            case 2:
                                              
                                              $tradeindia_v1 = number_format($value->amt / 1000, 0, '.', '');
                                              $tradeindia_c1 = $value->count;
                                            
                                            
                                            
                                            break;

                                            case 3:
                                              $exporter_v1 = number_format($value->amt / 1000, 0, '.', '');
                                              $exporter_c1 = $value->count;
                                            
                                            break;

                                            case 4:
                                            
                                            $campaign_v1 = number_format($value->amt / 1000, 0, '.', '');
                                            $campaign_c1 = $value->count;
                                            
                                            break;

                                            case 5:
                                            
                                              $coldcall_v1 = number_format($value->amt / 1000, 0, '.', '');
                                              $coldcall_c1 = $value->count;
                                              
                                            break;

                                            case 6:
                                            
                                              $conference_v1 = number_format($value->amt / 1000, 0, '.', '');
                                              $conference_c1 = $value->count;
                                              
                                            
                                            break;

                                            
                                            case 7:
                                            
                                              $directcall_v1 = number_format($value->amt / 1000, 0, '.', '');
                                              $directcall_c1 = $value->count;
                                              
                                            break;
                                            
                                            case 8:
                                            
                                              $existing_v1 = number_format($value->amt / 1000, 0, '.', '');
                                              $existing_c1 = $value->count;
                                              
                                            break;


                                            case 9:
                                            
                                            
                                              $email_v1 = number_format($value->amt / 1000, 0, '.', '');
                                              $email_c1 = $value->count;
                                              
                                            break;
                                            
                                            case 10:
                                            
                                              $expo_v1 = number_format($value->amt / 1000, 0, '.', '');
                                              $expo_c1 = $value->count;
                                              
                                            
                                            break;


                                            case 11:
                                            
                                              $gem_v1 = number_format($value->amt / 1000, 0, '.', '');
                                              $gem_c1 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 12:
                                            
                                            
                                              $other_v1 = number_format($value->amt / 1000, 0, '.', '');
                                              $other_c1 = $value->count;
                                              
                                            break;


                                            case 13:
                                            
                                              $principle_v1 = number_format($value->amt / 1000, 0, '.', '');
                                              $principle_c1 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 14:
                                            
                                              $publicrelation_v1 = number_format($value->amt / 1000, 0, '.', '');
                                              $publicrelation_c1 = $value->count;
                                              
                                            
                                            break;


                                            case 15:
                                           
                                              $self_v1 = number_format($value->amt / 1000, 0, '.', '');
                                              $self_c1 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 16:
                                            
                                            
                                              $website_v1 = number_format($value->amt / 1000, 0, '.', '');
                                              $website_c1 = $value->count;
                                              
                                            break;



                                            case 17:
                                            
                                              $mouth_v1 = number_format($value->amt / 1000, 0, '.', '');
                                              $mouth_c1 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 18:
                                            
                                              $olddb_v1 = number_format($value->amt / 1000, 0, '.', '');
                                              $olddb_c1 = $value->count;
                                              
                                            
                                            break;


                                            case 19:
                                            
                                              $mid_v1 = number_format($value->amt / 1000, 0, '.', '');
                                              $mid_c1 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 20:
                                            
                                              $gid_v1 = number_format($value->amt / 1000, 0, '.', '');
                                              $gid_c1 = $value->count;
                                              
                                            
                                            break;


                                            case 21:
                                           
                                              $directmail_v1 = number_format($value->amt / 1000, 0, '.', '');
                                              $directmail_c1 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 22:
                                            
                                              $partner_v1 = number_format($value->amt / 1000, 0, '.', '');
                                              $partner_c1 = $value->count;
                                              
                                            
                                            break;

                                            
                                            case 23:
                                            
                                              $visit_v1 = number_format($value->amt / 1000, 0, '.', '');
                                              $visit_c1 = $value->count;
                                              
                                            
                                            break;


                                            default :
                                            echo 'no match';
                                            break;
                                            
                                          }
                                        }
                                      
                                        


                                        ////month2

                                         $this->db->select('offer_register.offer_source, enquiry_source_master.source_name, sum(offer_product_relation.total_amount_without_gst) as amt,count(DISTINCT(offer_register.entity_id)) as count');
                                        $this->db->from('offer_product_relation');
                                        $this->db->join('offer_register', 'offer_register.entity_id = offer_product_relation.offer_id','inner');
                                        $this->db->join('enquiry_source_master', 'enquiry_source_master.entity_id = offer_register.offer_source','inner');
                                        $where = '(offer_register.offer_close_date >= "'.$first_date_of_2month.'" And offer_register.offer_close_date <= "'.$last_date_of_2month.'" And offer_register.offer_engg_name ="'. $offer_engg_name.'" And offer_register.status ="6" )';
                                        $this->db->where($where);
                                        $this->db->group_by('offer_register.offer_source');
                                        $query = $this->db->get();
                                        $query_result = $query->result();

                                        foreach ($query_result as $key => $value) {
                                          // echo '<pre>';
                                          // print_r($value);
                                          // die();
                                          
                                          switch($value->offer_source){

                                            case 1:
                                            
                                              $indiamart_v2 = number_format($value->amt / 1000, 0, '.', '');
                                              $indiamart_c2 = $value->count;
                                            
                                            break;

                                            case 2:
                                              
                                              $tradeindia_v2 = number_format($value->amt / 1000, 0, '.', '');
                                              $tradeindia_c2 = $value->count;
                                            
                                            
                                            
                                            break;

                                            case 3:
                                              $exporter_v2 = number_format($value->amt / 1000, 0, '.', '');
                                              $exporter_c2 = $value->count;
                                            
                                            break;

                                            case 4:
                                            
                                            $campaign_v2 = number_format($value->amt / 1000, 0, '.', '');
                                            $campaign_c2 = $value->count;
                                            
                                            break;

                                            case 5:
                                            
                                              $coldcall_v2 = number_format($value->amt / 1000, 0, '.', '');
                                              $coldcall_c2 = $value->count;
                                              
                                            break;

                                            case 6:
                                            
                                              $conference_v2 = number_format($value->amt / 1000, 0, '.', '');
                                              $conference_c2 = $value->count;
                                              
                                            
                                            break;

                                            
                                            case 7:
                                            
                                              $directcall_v2 = number_format($value->amt / 1000, 0, '.', '');
                                              $directcall_c2 = $value->count;
                                              
                                            break;
                                            
                                            case 8:
                                            
                                              $existing_v2 = number_format($value->amt / 1000, 0, '.', '');
                                              $existing_c2 = $value->count;
                                              
                                            break;


                                            case 9:
                                            
                                            
                                              $email_v2 = number_format($value->amt / 1000, 0, '.', '');
                                              $email_c2 = $value->count;
                                              
                                            break;
                                            
                                            case 10:
                                            
                                              $expo_v2 = number_format($value->amt / 1000, 0, '.', '');
                                              $expo_c2 = $value->count;
                                              
                                            
                                            break;


                                            case 11:
                                            
                                              $gem_v2 = number_format($value->amt / 1000, 0, '.', '');
                                              $gem_c2 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 12:
                                            
                                            
                                              $other_v2 = number_format($value->amt / 1000, 0, '.', '');
                                              $other_c2 = $value->count;
                                              
                                            break;


                                            case 13:
                                            
                                              $principle_v2 = number_format($value->amt / 1000, 0, '.', '');
                                              $principle_c2 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 14:
                                            
                                              $publicrelation_v2 = number_format($value->amt / 1000, 0, '.', '');
                                              $publicrelation_c2 = $value->count;
                                              
                                            
                                            break;


                                            case 15:
                                           
                                              $self_v2 = number_format($value->amt / 1000, 0, '.', '');
                                              $self_c2 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 16:
                                            
                                            
                                              $website_v2 = number_format($value->amt / 1000, 0, '.', '');
                                              $website_c2 = $value->count;
                                              
                                            break;



                                            case 17:
                                            
                                              $mouth_v2 = number_format($value->amt / 1000, 0, '.', '');
                                              $mouth_c2 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 18:
                                            
                                              $olddb_v2 = number_format($value->amt / 1000, 0, '.', '');
                                              $olddb_c2 = $value->count;
                                              
                                            
                                            break;


                                            case 19:
                                            
                                              $mid_v2 = number_format($value->amt / 1000, 0, '.', '');
                                              $mid_c2 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 20:
                                            
                                              $gid_v2 = number_format($value->amt / 1000, 0, '.', '');
                                              $gid_c2 = $value->count;
                                              
                                            
                                            break;


                                            case 21:
                                           
                                              $directmail_v2 = number_format($value->amt / 1000, 0, '.', '');
                                              $directmail_c2 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 22:
                                            
                                              $partner_v2 = number_format($value->amt / 1000, 0, '.', '');
                                              $partner_c2 = $value->count;
                                              
                                            
                                            break;

                                            
                                            case 23:
                                            
                                              $visit_v2 = number_format($value->amt / 1000, 0, '.', '');
                                              $visit_c2 = $value->count;
                                              
                                            
                                            break;


                                            default :
                                            echo 'no match';
                                            break;
                                            
                                          }
                                        }
                                      
                                        
                                        


                                        ////month3

                                         $this->db->select('offer_register.offer_source, enquiry_source_master.source_name, sum(offer_product_relation.total_amount_without_gst) as amt,count(DISTINCT(offer_register.entity_id)) as count');
                                        $this->db->from('offer_product_relation');
                                        $this->db->join('offer_register', 'offer_register.entity_id = offer_product_relation.offer_id','inner');
                                        $this->db->join('enquiry_source_master', 'enquiry_source_master.entity_id = offer_register.offer_source','inner');
                                        $where = '(offer_register.offer_close_date >= "'.$first_date_of_3month.'" And offer_register.offer_close_date <= "'.$last_date_of_3month.'" And offer_register.offer_engg_name ="'. $offer_engg_name.'" And offer_register.status ="6" )';
                                        $this->db->where($where);
                                        $this->db->group_by('offer_register.offer_source');
                                        $query = $this->db->get();
                                        $query_result = $query->result();

                                        foreach ($query_result as $key => $value) {
                                          // echo '<pre>';
                                          // print_r($value);
                                          // die();
                                          
                                          switch($value->offer_source){

                                            case 1:
                                            
                                              $indiamart_v3 = number_format($value->amt / 1000, 0, '.', '');
                                              $indiamart_c3 = $value->count;
                                            
                                            break;

                                            case 2:
                                              
                                              $tradeindia_v3 = number_format($value->amt / 1000, 0, '.', '');
                                              $tradeindia_c3 = $value->count;
                                            
                                            
                                            
                                            break;

                                            case 3:
                                              $exporter_v3 = number_format($value->amt / 1000, 0, '.', '');
                                              $exporter_c3 = $value->count;
                                            
                                            break;

                                            case 4:
                                            
                                            $campaign_v3 = number_format($value->amt / 1000, 0, '.', '');
                                            $campaign_c3 = $value->count;
                                            
                                            break;

                                            case 5:
                                            
                                              $coldcall_v3 = number_format($value->amt / 1000, 0, '.', '');
                                              $coldcall_c3 = $value->count;
                                              
                                            break;

                                            case 6:
                                            
                                              $conference_v3 = number_format($value->amt / 1000, 0, '.', '');
                                              $conference_c3 = $value->count;
                                              
                                            
                                            break;

                                            
                                            case 7:
                                            
                                              $directcall_v3 = number_format($value->amt / 1000, 0, '.', '');
                                              $directcall_c3 = $value->count;
                                              
                                            break;
                                            
                                            case 8:
                                            
                                              $existing_v3 = number_format($value->amt / 1000, 0, '.', '');
                                              $existing_c3 = $value->count;
                                              
                                            break;


                                            case 9:
                                            
                                            
                                              $email_v3 = number_format($value->amt / 1000, 0, '.', '');
                                              $email_c3 = $value->count;
                                              
                                            break;
                                            
                                            case 10:
                                            
                                              $expo_v3 = number_format($value->amt / 1000, 0, '.', '');
                                              $expo_c3 = $value->count;
                                              
                                            
                                            break;


                                            case 11:
                                            
                                              $gem_v3 = number_format($value->amt / 1000, 0, '.', '');
                                              $gem_c3 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 12:
                                            
                                            
                                              $other_v3 = number_format($value->amt / 1000, 0, '.', '');
                                              $other_c3 = $value->count;
                                              
                                            break;


                                            case 13:
                                            
                                              $principle_v3 = number_format($value->amt / 1000, 0, '.', '');
                                              $principle_c3 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 14:
                                            
                                              $publicrelation_v3 = number_format($value->amt / 1000, 0, '.', '');
                                              $publicrelation_c3 = $value->count;
                                              
                                            
                                            break;


                                            case 15:
                                           
                                              $self_v3 = number_format($value->amt / 1000, 0, '.', '');
                                              $self_c3 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 16:
                                            
                                            
                                              $website_v3 = number_format($value->amt / 1000, 0, '.', '');
                                              $website_c3 = $value->count;
                                              
                                            break;



                                            case 17:
                                            
                                              $mouth_v3 = number_format($value->amt / 1000, 0, '.', '');
                                              $mouth_c3 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 18:
                                            
                                              $olddb_v3 = number_format($value->amt / 1000, 0, '.', '');
                                              $olddb_c3 = $value->count;
                                              
                                            
                                            break;


                                            case 19:
                                            
                                              $mid_v3 = number_format($value->amt / 1000, 0, '.', '');
                                              $mid_c3 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 20:
                                            
                                              $gid_v3 = number_format($value->amt / 1000, 0, '.', '');
                                              $gid_c3 = $value->count;
                                              
                                            
                                            break;


                                            case 21:
                                           
                                              $directmail_v3 = number_format($value->amt / 1000, 0, '.', '');
                                              $directmail_c3 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 22:
                                            
                                              $partner_v3 = number_format($value->amt / 1000, 0, '.', '');
                                              $partner_c3 = $value->count;
                                              
                                            
                                            break;

                                            
                                            case 23:
                                            
                                              $visit_v3 = number_format($value->amt / 1000, 0, '.', '');
                                              $visit_c3 = $value->count;
                                              
                                            
                                            break;


                                            default :
                                            echo 'no match';
                                            break;
                                            
                                          }
                                        }
                                      
                                        
                                        


                                        ////month4

                                         $this->db->select('offer_register.offer_source, enquiry_source_master.source_name, sum(offer_product_relation.total_amount_without_gst) as amt,count(DISTINCT(offer_register.entity_id)) as count');
                                        $this->db->from('offer_product_relation');
                                        $this->db->join('offer_register', 'offer_register.entity_id = offer_product_relation.offer_id','inner');
                                        $this->db->join('enquiry_source_master', 'enquiry_source_master.entity_id = offer_register.offer_source','inner');
                                        $where = '(offer_register.offer_close_date >= "'.$first_date_of_4month.'" And offer_register.offer_close_date <= "'.$last_date_of_4month.'" And offer_register.offer_engg_name ="'. $offer_engg_name.'" And offer_register.status ="6" )';
                                        $this->db->where($where);
                                        $this->db->group_by('offer_register.offer_source');
                                        $query = $this->db->get();
                                        $query_result = $query->result();

                                        foreach ($query_result as $key => $value) {
                                          // echo '<pre>';
                                          // print_r($value);
                                          // die();
                                          
                                          switch($value->offer_source){

                                            case 1:
                                            
                                              $indiamart_v4 = number_format($value->amt / 1000, 0, '.', '');
                                              $indiamart_c4 = $value->count;
                                            
                                            break;

                                            case 2:
                                              
                                              $tradeindia_v4 = number_format($value->amt / 1000, 0, '.', '');
                                              $tradeindia_c4 = $value->count;
                                            
                                            
                                            
                                            break;

                                            case 3:
                                              $exporter_v4 = number_format($value->amt / 1000, 0, '.', '');
                                              $exporter_c4 = $value->count;
                                            
                                            break;

                                            case 4:
                                            
                                            $campaign_v4 = number_format($value->amt / 1000, 0, '.', '');
                                            $campaign_c4 = $value->count;
                                            
                                            break;

                                            case 5:
                                            
                                              $coldcall_v4 = number_format($value->amt / 1000, 0, '.', '');
                                              $coldcall_c4 = $value->count;
                                              
                                            break;

                                            case 6:
                                            
                                              $conference_v4 = number_format($value->amt / 1000, 0, '.', '');
                                              $conference_c4 = $value->count;
                                              
                                            
                                            break;

                                            
                                            case 7:
                                            
                                              $directcall_v4 = number_format($value->amt / 1000, 0, '.', '');
                                              $directcall_c4 = $value->count;
                                              
                                            break;
                                            
                                            case 8:
                                            
                                              $existing_v4 = number_format($value->amt / 1000, 0, '.', '');
                                              $existing_c4 = $value->count;
                                              
                                            break;


                                            case 9:
                                            
                                            
                                              $email_v4 = number_format($value->amt / 1000, 0, '.', '');
                                              $email_c4 = $value->count;
                                              
                                            break;
                                            
                                            case 10:
                                            
                                              $expo_v4 = number_format($value->amt / 1000, 0, '.', '');
                                              $expo_c4 = $value->count;
                                              
                                            
                                            break;


                                            case 11:
                                            
                                              $gem_v4 = number_format($value->amt / 1000, 0, '.', '');
                                              $gem_c4 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 12:
                                            
                                            
                                              $other_v4 = number_format($value->amt / 1000, 0, '.', '');
                                              $other_c4 = $value->count;
                                              
                                            break;


                                            case 13:
                                            
                                              $principle_v4 = number_format($value->amt / 1000, 0, '.', '');
                                              $principle_c4 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 14:
                                            
                                              $publicrelation_v4 = number_format($value->amt / 1000, 0, '.', '');
                                              $publicrelation_c4 = $value->count;
                                              
                                            
                                            break;


                                            case 15:
                                           
                                              $self_v4 = number_format($value->amt / 1000, 0, '.', '');
                                              $self_c4 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 16:
                                            
                                            
                                              $website_v4 = number_format($value->amt / 1000, 0, '.', '');
                                              $website_c4 = $value->count;
                                              
                                            break;



                                            case 17:
                                            
                                              $mouth_v4 = number_format($value->amt / 1000, 0, '.', '');
                                              $mouth_c4 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 18:
                                            
                                              $olddb_v4 = number_format($value->amt / 1000, 0, '.', '');
                                              $olddb_c4 = $value->count;
                                              
                                            
                                            break;


                                            case 19:
                                            
                                              $mid_v4 = number_format($value->amt / 1000, 0, '.', '');
                                              $mid_c4 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 20:
                                            
                                              $gid_v4 = number_format($value->amt / 1000, 0, '.', '');
                                              $gid_c4 = $value->count;
                                              
                                            
                                            break;


                                            case 21:
                                           
                                              $directmail_v4 = number_format($value->amt / 1000, 0, '.', '');
                                              $directmail_c4 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 22:
                                            
                                              $partner_v4 = number_format($value->amt / 1000, 0, '.', '');
                                              $partner_c4 = $value->count;
                                              
                                            
                                            break;

                                            
                                            case 23:
                                            
                                              $visit_v4 = number_format($value->amt / 1000, 0, '.', '');
                                              $visit_c4 = $value->count;
                                              
                                            
                                            break;


                                            default :
                                            echo 'no match';
                                            break;
                                            
                                          }
                                        }
                                      
                                        


                                        ////month5

                                         $this->db->select('offer_register.offer_source, enquiry_source_master.source_name, sum(offer_product_relation.total_amount_without_gst) as amt,count(DISTINCT(offer_register.entity_id)) as count');
                                        $this->db->from('offer_product_relation');
                                        $this->db->join('offer_register', 'offer_register.entity_id = offer_product_relation.offer_id','inner');
                                        $this->db->join('enquiry_source_master', 'enquiry_source_master.entity_id = offer_register.offer_source','inner');
                                        $where = '(offer_register.offer_close_date >= "'.$first_date_of_5month.'" And offer_register.offer_close_date <= "'.$last_date_of_5month.'" And offer_register.offer_engg_name ="'. $offer_engg_name.'" And offer_register.status ="6" )';
                                        $this->db->where($where);
                                        $this->db->group_by('offer_register.offer_source');
                                        $query = $this->db->get();
                                        $query_result = $query->result();

                                        foreach ($query_result as $key => $value) {
                                          // echo '<pre>';
                                          // print_r($value);
                                          // die();
                                          
                                          switch($value->offer_source){

                                            case 1:
                                            
                                              $indiamart_v5 = number_format($value->amt / 1000, 0, '.', '');
                                              $indiamart_c5 = $value->count;
                                            
                                            break;

                                            case 2:
                                              
                                              $tradeindia_v5 = number_format($value->amt / 1000, 0, '.', '');
                                              $tradeindia_c5 = $value->count;
                                            
                                            
                                            
                                            break;

                                            case 3:
                                              $exporter_v5 = number_format($value->amt / 1000, 0, '.', '');
                                              $exporter_c5 = $value->count;
                                            
                                            break;

                                            case 4:
                                            
                                            $campaign_v5 = number_format($value->amt / 1000, 0, '.', '');
                                            $campaign_c5 = $value->count;
                                            
                                            break;

                                            case 5:
                                            
                                              $coldcall_v5 = number_format($value->amt / 1000, 0, '.', '');
                                              $coldcall_c5 = $value->count;
                                              
                                            break;

                                            case 6:
                                            
                                              $conference_v5 = number_format($value->amt / 1000, 0, '.', '');
                                              $conference_c5 = $value->count;
                                              
                                            
                                            break;

                                            
                                            case 7:
                                            
                                              $directcall_v5 = number_format($value->amt / 1000, 0, '.', '');
                                              $directcall_c5 = $value->count;
                                              
                                            break;
                                            
                                            case 8:
                                            
                                              $existing_v5 = number_format($value->amt / 1000, 0, '.', '');
                                              $existing_c5 = $value->count;
                                              
                                            break;


                                            case 9:
                                            
                                            
                                              $email_v5 = number_format($value->amt / 1000, 0, '.', '');
                                              $email_c5 = $value->count;
                                              
                                            break;
                                            
                                            case 10:
                                            
                                              $expo_v5 = number_format($value->amt / 1000, 0, '.', '');
                                              $expo_c5 = $value->count;
                                              
                                            
                                            break;


                                            case 11:
                                            
                                              $gem_v5 = number_format($value->amt / 1000, 0, '.', '');
                                              $gem_c5 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 12:
                                            
                                            
                                              $other_v5 = number_format($value->amt / 1000, 0, '.', '');
                                              $other_c5 = $value->count;
                                              
                                            break;


                                            case 13:
                                            
                                              $principle_v5 = number_format($value->amt / 1000, 0, '.', '');
                                              $principle_c5 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 14:
                                            
                                              $publicrelation_v5 = number_format($value->amt / 1000, 0, '.', '');
                                              $publicrelation_c5 = $value->count;
                                              
                                            
                                            break;


                                            case 15:
                                           
                                              $self_v5 = number_format($value->amt / 1000, 0, '.', '');
                                              $self_c5 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 16:
                                            
                                            
                                              $website_v5 = number_format($value->amt / 1000, 0, '.', '');
                                              $website_c5 = $value->count;
                                              
                                            break;



                                            case 17:
                                            
                                              $mouth_v5 = number_format($value->amt / 1000, 0, '.', '');
                                              $mouth_c5 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 18:
                                            
                                              $olddb_v5 = number_format($value->amt / 1000, 0, '.', '');
                                              $olddb_c5 = $value->count;
                                              
                                            
                                            break;


                                            case 19:
                                            
                                              $mid_v5 = number_format($value->amt / 1000, 0, '.', '');
                                              $mid_c5 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 20:
                                            
                                              $gid_v5 = number_format($value->amt / 1000, 0, '.', '');
                                              $gid_c5 = $value->count;
                                              
                                            
                                            break;


                                            case 21:
                                           
                                              $directmail_v5 = number_format($value->amt / 1000, 0, '.', '');
                                              $directmail_c5 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 22:
                                            
                                              $partner_v5 = number_format($value->amt / 1000, 0, '.', '');
                                              $partner_c5 = $value->count;
                                              
                                            
                                            break;

                                            
                                            case 23:
                                            
                                              $visit_v5 = number_format($value->amt / 1000, 0, '.', '');
                                              $visit_c5 = $value->count;
                                              
                                            
                                            break;


                                            default :
                                            echo 'no match';
                                            break;
                                            
                                          }
                                        }
                                      
                                        
                                        


                                        ////month6

                                         $this->db->select('offer_register.offer_source, enquiry_source_master.source_name, sum(offer_product_relation.total_amount_without_gst) as amt,count(DISTINCT(offer_register.entity_id)) as count');
                                        $this->db->from('offer_product_relation');
                                        $this->db->join('offer_register', 'offer_register.entity_id = offer_product_relation.offer_id','inner');
                                        $this->db->join('enquiry_source_master', 'enquiry_source_master.entity_id = offer_register.offer_source','inner');
                                        $where = '(offer_register.offer_close_date >= "'.$first_date_of_6month.'" And offer_register.offer_close_date <= "'.$last_date_of_6month.'" And offer_register.offer_engg_name ="'. $offer_engg_name.'" And offer_register.status ="6" )';
                                        $this->db->where($where);
                                        $this->db->group_by('offer_register.offer_source');
                                        $query = $this->db->get();
                                        $query_result = $query->result();

                                        foreach ($query_result as $key => $value) {
                                          // echo '<pre>';
                                          // print_r($value);
                                          // die();
                                          
                                          switch($value->offer_source){

                                            case 1:
                                            
                                              $indiamart_v6 = number_format($value->amt / 1000, 0, '.', '');
                                              $indiamart_c6 = $value->count;
                                            
                                            break;

                                            case 2:
                                              
                                              $tradeindia_v6 = number_format($value->amt / 1000, 0, '.', '');
                                              $tradeindia_c6 = $value->count;
                                            
                                            
                                            
                                            break;

                                            case 3:
                                              $exporter_v6 = number_format($value->amt / 1000, 0, '.', '');
                                              $exporter_c6 = $value->count;
                                            
                                            break;

                                            case 4:
                                            
                                            $campaign_v6 = number_format($value->amt / 1000, 0, '.', '');
                                            $campaign_c6 = $value->count;
                                            
                                            break;

                                            case 5:
                                            
                                              $coldcall_v6 = number_format($value->amt / 1000, 0, '.', '');
                                              $coldcall_c6 = $value->count;
                                              
                                            break;

                                            case 6:
                                            
                                              $conference_v6 = number_format($value->amt / 1000, 0, '.', '');
                                              $conference_c6 = $value->count;
                                              
                                            
                                            break;

                                            
                                            case 7:
                                            
                                              $directcall_v6 = number_format($value->amt / 1000, 0, '.', '');
                                              $directcall_c6 = $value->count;
                                              
                                            break;
                                            
                                            case 8:
                                            
                                              $existing_v6 = number_format($value->amt / 1000, 0, '.', '');
                                              $existing_c6 = $value->count;
                                              
                                            break;


                                            case 9:
                                            
                                            
                                              $email_v6 = number_format($value->amt / 1000, 0, '.', '');
                                              $email_c6 = $value->count;
                                              
                                            break;
                                            
                                            case 10:
                                            
                                              $expo_v6 = number_format($value->amt / 1000, 0, '.', '');
                                              $expo_c6 = $value->count;
                                              
                                            
                                            break;


                                            case 11:
                                            
                                              $gem_v6 = number_format($value->amt / 1000, 0, '.', '');
                                              $gem_c6 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 12:
                                            
                                            
                                              $other_v6 = number_format($value->amt / 1000, 0, '.', '');
                                              $other_c6 = $value->count;
                                              
                                            break;


                                            case 13:
                                            
                                              $principle_v6 = number_format($value->amt / 1000, 0, '.', '');
                                              $principle_c6 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 14:
                                            
                                              $publicrelation_v6 = number_format($value->amt / 1000, 0, '.', '');
                                              $publicrelation_c6 = $value->count;
                                              
                                            
                                            break;


                                            case 15:
                                           
                                              $self_v6 = number_format($value->amt / 1000, 0, '.', '');
                                              $self_c6 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 16:
                                            
                                            
                                              $website_v6 = number_format($value->amt / 1000, 0, '.', '');
                                              $website_c6 = $value->count;
                                              
                                            break;



                                            case 17:
                                            
                                              $mouth_v6 = number_format($value->amt / 1000, 0, '.', '');
                                              $mouth_c6 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 18:
                                            
                                              $olddb_v6 = number_format($value->amt / 1000, 0, '.', '');
                                              $olddb_c6 = $value->count;
                                              
                                            
                                            break;


                                            case 19:
                                            
                                              $mid_v6 = number_format($value->amt / 1000, 0, '.', '');
                                              $mid_c6 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 20:
                                            
                                              $gid_v6 = number_format($value->amt / 1000, 0, '.', '');
                                              $gid_c6 = $value->count;
                                              
                                            
                                            break;


                                            case 21:
                                           
                                              $directmail_v6 = number_format($value->amt / 1000, 0, '.', '');
                                              $directmail_c6 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 22:
                                            
                                              $partner_v6 = number_format($value->amt / 1000, 0, '.', '');
                                              $partner_c6 = $value->count;
                                              
                                            
                                            break;

                                            
                                            case 23:
                                            
                                              $visit_v6 = number_format($value->amt / 1000, 0, '.', '');
                                              $visit_c6 = $value->count;
                                              
                                            
                                            break;


                                            default :
                                            echo 'no match';
                                            break;
                                            
                                          }
                                        }
                                      
                                        


                                        ////month7

                                         $this->db->select('offer_register.offer_source, enquiry_source_master.source_name, sum(offer_product_relation.total_amount_without_gst) as amt,count(DISTINCT(offer_register.entity_id)) as count');
                                        $this->db->from('offer_product_relation');
                                        $this->db->join('offer_register', 'offer_register.entity_id = offer_product_relation.offer_id','inner');
                                        $this->db->join('enquiry_source_master', 'enquiry_source_master.entity_id = offer_register.offer_source','inner');
                                        $where = '(offer_register.offer_close_date >= "'.$first_date_of_7month.'" And offer_register.offer_close_date <= "'.$last_date_of_7month.'" And offer_register.offer_engg_name ="'. $offer_engg_name.'" And offer_register.status ="6" )';
                                        $this->db->where($where);
                                        $this->db->group_by('offer_register.offer_source');
                                        $query = $this->db->get();
                                        $query_result = $query->result();

                                        foreach ($query_result as $key => $value) {
                                          // echo '<pre>';
                                          // print_r($value);
                                          // die();
                                          
                                          switch($value->offer_source){

                                            case 1:
                                            
                                              $indiamart_v7 = number_format($value->amt / 1000, 0, '.', '');
                                              $indiamart_c7 = $value->count;
                                            
                                            break;

                                            case 2:
                                              
                                              $tradeindia_v7 = number_format($value->amt / 1000, 0, '.', '');
                                              $tradeindia_c7 = $value->count;
                                            
                                            
                                            
                                            break;

                                            case 3:
                                              $exporter_v7 = number_format($value->amt / 1000, 0, '.', '');
                                              $exporter_c7 = $value->count;
                                            
                                            break;

                                            case 4:
                                            
                                            $campaign_v7 = number_format($value->amt / 1000, 0, '.', '');
                                            $campaign_c7 = $value->count;
                                            
                                            break;

                                            case 5:
                                            
                                              $coldcall_v7 = number_format($value->amt / 1000, 0, '.', '');
                                              $coldcall_c7 = $value->count;
                                              
                                            break;

                                            case 6:
                                            
                                              $conference_v7 = number_format($value->amt / 1000, 0, '.', '');
                                              $conference_c7 = $value->count;
                                              
                                            
                                            break;

                                            
                                            case 7:
                                            
                                              $directcall_v7 = number_format($value->amt / 1000, 0, '.', '');
                                              $directcall_c7 = $value->count;
                                              
                                            break;
                                            
                                            case 8:
                                            
                                              $existing_v7 = number_format($value->amt / 1000, 0, '.', '');
                                              $existing_c7 = $value->count;
                                              
                                            break;


                                            case 9:
                                            
                                            
                                              $email_v7 = number_format($value->amt / 1000, 0, '.', '');
                                              $email_c7 = $value->count;
                                              
                                            break;
                                            
                                            case 10:
                                            
                                              $expo_v7 = number_format($value->amt / 1000, 0, '.', '');
                                              $expo_c7 = $value->count;
                                              
                                            
                                            break;


                                            case 11:
                                            
                                              $gem_v7 = number_format($value->amt / 1000, 0, '.', '');
                                              $gem_c7 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 12:
                                            
                                            
                                              $other_v7 = number_format($value->amt / 1000, 0, '.', '');
                                              $other_c7 = $value->count;
                                              
                                            break;


                                            case 13:
                                            
                                              $principle_v7 = number_format($value->amt / 1000, 0, '.', '');
                                              $principle_c7 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 14:
                                            
                                              $publicrelation_v7 = number_format($value->amt / 1000, 0, '.', '');
                                              $publicrelation_c7 = $value->count;
                                              
                                            
                                            break;


                                            case 15:
                                           
                                              $self_v7 = number_format($value->amt / 1000, 0, '.', '');
                                              $self_c7 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 16:
                                            
                                            
                                              $website_v7 = number_format($value->amt / 1000, 0, '.', '');
                                              $website_c7 = $value->count;
                                              
                                            break;



                                            case 17:
                                            
                                              $mouth_v7 = number_format($value->amt / 1000, 0, '.', '');
                                              $mouth_c7 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 18:
                                            
                                              $olddb_v7 = number_format($value->amt / 1000, 0, '.', '');
                                              $olddb_c7 = $value->count;
                                              
                                            
                                            break;


                                            case 19:
                                            
                                              $mid_v7 = number_format($value->amt / 1000, 0, '.', '');
                                              $mid_c7 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 20:
                                            
                                              $gid_v7 = number_format($value->amt / 1000, 0, '.', '');
                                              $gid_c7 = $value->count;
                                              
                                            
                                            break;


                                            case 21:
                                           
                                              $directmail_v7 = number_format($value->amt / 1000, 0, '.', '');
                                              $directmail_c7 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 22:
                                            
                                              $partner_v7 = number_format($value->amt / 1000, 0, '.', '');
                                              $partner_c7 = $value->count;
                                              
                                            
                                            break;

                                            
                                            case 23:
                                            
                                              $visit_v7 = number_format($value->amt / 1000, 0, '.', '');
                                              $visit_c7 = $value->count;
                                              
                                            
                                            break;


                                            default :
                                            echo 'no match';
                                            break;
                                            
                                          }
                                        }
                                      
                                        
                                        


                                        ////month8

                                         $this->db->select('offer_register.offer_source, enquiry_source_master.source_name, sum(offer_product_relation.total_amount_without_gst) as amt,count(DISTINCT(offer_register.entity_id)) as count');
                                        $this->db->from('offer_product_relation');
                                        $this->db->join('offer_register', 'offer_register.entity_id = offer_product_relation.offer_id','inner');
                                        $this->db->join('enquiry_source_master', 'enquiry_source_master.entity_id = offer_register.offer_source','inner');
                                        $where = '(offer_register.offer_close_date >= "'.$first_date_of_8month.'" And offer_register.offer_close_date <= "'.$last_date_of_8month.'" And offer_register.offer_engg_name ="'. $offer_engg_name.'" And offer_register.status ="6" )';
                                        $this->db->where($where);
                                        $this->db->group_by('offer_register.offer_source');
                                        $query = $this->db->get();
                                        $query_result = $query->result();

                                        foreach ($query_result as $key => $value) {
                                          // echo '<pre>';
                                          // print_r($value);
                                          // die();
                                          
                                          switch($value->offer_source){

                                            case 1:
                                            
                                              $indiamart_v8 = number_format($value->amt / 1000, 0, '.', '');
                                              $indiamart_c8 = $value->count;
                                            
                                            break;

                                            case 2:
                                              
                                              $tradeindia_v8 = number_format($value->amt / 1000, 0, '.', '');
                                              $tradeindia_c8 = $value->count;
                                            
                                            
                                            
                                            break;

                                            case 3:
                                              $exporter_v8 = number_format($value->amt / 1000, 0, '.', '');
                                              $exporter_c8 = $value->count;
                                            
                                            break;

                                            case 4:
                                            
                                            $campaign_v8 = number_format($value->amt / 1000, 0, '.', '');
                                            $campaign_c8 = $value->count;
                                            
                                            break;

                                            case 5:
                                            
                                              $coldcall_v8 = number_format($value->amt / 1000, 0, '.', '');
                                              $coldcall_c8 = $value->count;
                                              
                                            break;

                                            case 6:
                                            
                                              $conference_v8 = number_format($value->amt / 1000, 0, '.', '');
                                              $conference_c8 = $value->count;
                                              
                                            
                                            break;

                                            
                                            case 7:
                                            
                                              $directcall_v8 = number_format($value->amt / 1000, 0, '.', '');
                                              $directcall_c8 = $value->count;
                                              
                                            break;
                                            
                                            case 8:
                                            
                                              $existing_v8 = number_format($value->amt / 1000, 0, '.', '');
                                              $existing_c8 = $value->count;
                                              
                                            break;


                                            case 9:
                                            
                                            
                                              $email_v8 = number_format($value->amt / 1000, 0, '.', '');
                                              $email_c8 = $value->count;
                                              
                                            break;
                                            
                                            case 10:
                                            
                                              $expo_v8 = number_format($value->amt / 1000, 0, '.', '');
                                              $expo_c8 = $value->count;
                                              
                                            
                                            break;


                                            case 11:
                                            
                                              $gem_v8 = number_format($value->amt / 1000, 0, '.', '');
                                              $gem_c8 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 12:
                                            
                                            
                                              $other_v8 = number_format($value->amt / 1000, 0, '.', '');
                                              $other_c8 = $value->count;
                                              
                                            break;


                                            case 13:
                                            
                                              $principle_v8 = number_format($value->amt / 1000, 0, '.', '');
                                              $principle_c8 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 14:
                                            
                                              $publicrelation_v8 = number_format($value->amt / 1000, 0, '.', '');
                                              $publicrelation_c8 = $value->count;
                                              
                                            
                                            break;


                                            case 15:
                                           
                                              $self_v8 = number_format($value->amt / 1000, 0, '.', '');
                                              $self_c8 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 16:
                                            
                                            
                                              $website_v8 = number_format($value->amt / 1000, 0, '.', '');
                                              $website_c8 = $value->count;
                                              
                                            break;



                                            case 17:
                                            
                                              $mouth_v8 = number_format($value->amt / 1000, 0, '.', '');
                                              $mouth_c8 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 18:
                                            
                                              $olddb_v8 = number_format($value->amt / 1000, 0, '.', '');
                                              $olddb_c8 = $value->count;
                                              
                                            
                                            break;


                                            case 19:
                                            
                                              $mid_v8 = number_format($value->amt / 1000, 0, '.', '');
                                              $mid_c8 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 20:
                                            
                                              $gid_v8 = number_format($value->amt / 1000, 0, '.', '');
                                              $gid_c8 = $value->count;
                                              
                                            
                                            break;


                                            case 21:
                                           
                                              $directmail_v8 = number_format($value->amt / 1000, 0, '.', '');
                                              $directmail_c8 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 22:
                                            
                                              $partner_v8 = number_format($value->amt / 1000, 0, '.', '');
                                              $partner_c8 = $value->count;
                                              
                                            
                                            break;

                                            
                                            case 23:
                                            
                                              $visit_v8 = number_format($value->amt / 1000, 0, '.', '');
                                              $visit_c8 = $value->count;
                                              
                                            
                                            break;


                                            default :
                                            echo 'no match';
                                            break;
                                            
                                          }
                                        }
                                      
                                        


                                        ////month9

                                         $this->db->select('offer_register.offer_source, enquiry_source_master.source_name, sum(offer_product_relation.total_amount_without_gst) as amt,count(DISTINCT(offer_register.entity_id)) as count');
                                        $this->db->from('offer_product_relation');
                                        $this->db->join('offer_register', 'offer_register.entity_id = offer_product_relation.offer_id','inner');
                                        $this->db->join('enquiry_source_master', 'enquiry_source_master.entity_id = offer_register.offer_source','inner');
                                        $where = '(offer_register.offer_close_date >= "'.$first_date_of_9month.'" And offer_register.offer_close_date <= "'.$last_date_of_9month.'" And offer_register.offer_engg_name ="'. $offer_engg_name.'" And offer_register.status ="6" )';
                                        $this->db->where($where);
                                        $this->db->group_by('offer_register.offer_source');
                                        $query = $this->db->get();
                                        $query_result = $query->result();

                                        foreach ($query_result as $key => $value) {
                                          // echo '<pre>';
                                          // print_r($value);
                                          // die();
                                          
                                          switch($value->offer_source){

                                            case 1:
                                            
                                              $indiamart_v9 = number_format($value->amt / 1000, 0, '.', '');
                                              $indiamart_c9 = $value->count;
                                            
                                            break;

                                            case 2:
                                              
                                              $tradeindia_v9 = number_format($value->amt / 1000, 0, '.', '');
                                              $tradeindia_c9 = $value->count;
                                            
                                            
                                            
                                            break;

                                            case 3:
                                              $exporter_v9 = number_format($value->amt / 1000, 0, '.', '');
                                              $exporter_c9 = $value->count;
                                            
                                            break;

                                            case 4:
                                            
                                            $campaign_v9 = number_format($value->amt / 1000, 0, '.', '');
                                            $campaign_c9 = $value->count;
                                            
                                            break;

                                            case 5:
                                            
                                              $coldcall_v9 = number_format($value->amt / 1000, 0, '.', '');
                                              $coldcall_c9 = $value->count;
                                              
                                            break;

                                            case 6:
                                            
                                              $conference_v9 = number_format($value->amt / 1000, 0, '.', '');
                                              $conference_c9 = $value->count;
                                              
                                            
                                            break;

                                            
                                            case 7:
                                            
                                              $directcall_v9 = number_format($value->amt / 1000, 0, '.', '');
                                              $directcall_c9 = $value->count;
                                              
                                            break;
                                            
                                            case 8:
                                            
                                              $existing_v9 = number_format($value->amt / 1000, 0, '.', '');
                                              $existing_c9 = $value->count;
                                              
                                            break;


                                            case 9:
                                            
                                            
                                              $email_v9 = number_format($value->amt / 1000, 0, '.', '');
                                              $email_c9 = $value->count;
                                              
                                            break;
                                            
                                            case 10:
                                            
                                              $expo_v9 = number_format($value->amt / 1000, 0, '.', '');
                                              $expo_c9 = $value->count;
                                              
                                            
                                            break;


                                            case 11:
                                            
                                              $gem_v9 = number_format($value->amt / 1000, 0, '.', '');
                                              $gem_c9 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 12:
                                            
                                            
                                              $other_v9 = number_format($value->amt / 1000, 0, '.', '');
                                              $other_c9 = $value->count;
                                              
                                            break;


                                            case 13:
                                            
                                              $principle_v9 = number_format($value->amt / 1000, 0, '.', '');
                                              $principle_c9 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 14:
                                            
                                              $publicrelation_v9 = number_format($value->amt / 1000, 0, '.', '');
                                              $publicrelation_c9 = $value->count;
                                              
                                            
                                            break;


                                            case 15:
                                           
                                              $self_v9 = number_format($value->amt / 1000, 0, '.', '');
                                              $self_c9 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 16:
                                            
                                            
                                              $website_v9 = number_format($value->amt / 1000, 0, '.', '');
                                              $website_c9 = $value->count;
                                              
                                            break;



                                            case 17:
                                            
                                              $mouth_v9 = number_format($value->amt / 1000, 0, '.', '');
                                              $mouth_c9 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 18:
                                            
                                              $olddb_v9 = number_format($value->amt / 1000, 0, '.', '');
                                              $olddb_c9 = $value->count;
                                              
                                            
                                            break;


                                            case 19:
                                            
                                              $mid_v9 = number_format($value->amt / 1000, 0, '.', '');
                                              $mid_c9 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 20:
                                            
                                              $gid_v9 = number_format($value->amt / 1000, 0, '.', '');
                                              $gid_c9 = $value->count;
                                              
                                            
                                            break;


                                            case 21:
                                           
                                              $directmail_v9 = number_format($value->amt / 1000, 0, '.', '');
                                              $directmail_c9 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 22:
                                            
                                              $partner_v9 = number_format($value->amt / 1000, 0, '.', '');
                                              $partner_c9 = $value->count;
                                              
                                            
                                            break;

                                            
                                            case 23:
                                            
                                              $visit_v9 = number_format($value->amt / 1000, 0, '.', '');
                                              $visit_c9 = $value->count;
                                              
                                            
                                            break;


                                            default :
                                            echo 'no match';
                                            break;
                                            
                                          }
                                        }
                                      
                                        
                                        


                                        ////month10

                                         $this->db->select('offer_register.offer_source, enquiry_source_master.source_name, sum(offer_product_relation.total_amount_without_gst) as amt,count(DISTINCT(offer_register.entity_id)) as count');
                                        $this->db->from('offer_product_relation');
                                        $this->db->join('offer_register', 'offer_register.entity_id = offer_product_relation.offer_id','inner');
                                        $this->db->join('enquiry_source_master', 'enquiry_source_master.entity_id = offer_register.offer_source','inner');
                                        $where = '(offer_register.offer_close_date >= "'.$first_date_of_10month.'" And offer_register.offer_close_date <= "'.$last_date_of_10month.'" And offer_register.offer_engg_name ="'. $offer_engg_name.'" And offer_register.status ="6" )';
                                        $this->db->where($where);
                                        $this->db->group_by('offer_register.offer_source');
                                        $query = $this->db->get();
                                        $query_result = $query->result();

                                        foreach ($query_result as $key => $value) {
                                          // echo '<pre>';
                                          // print_r($value);
                                          // die();
                                          
                                          switch($value->offer_source){

                                            case 1:
                                            
                                              $indiamart_v10 = number_format($value->amt / 1000, 0, '.', '');
                                              $indiamart_c10 = $value->count;
                                            
                                            break;

                                            case 2:
                                              
                                              $tradeindia_v10 = number_format($value->amt / 1000, 0, '.', '');
                                              $tradeindia_c10 = $value->count;
                                            
                                            
                                            
                                            break;

                                            case 3:
                                              $exporter_v10 = number_format($value->amt / 1000, 0, '.', '');
                                              $exporter_c10 = $value->count;
                                            
                                            break;

                                            case 4:
                                            
                                            $campaign_v10 = number_format($value->amt / 1000, 0, '.', '');
                                            $campaign_c10 = $value->count;
                                            
                                            break;

                                            case 5:
                                            
                                              $coldcall_v10 = number_format($value->amt / 1000, 0, '.', '');
                                              $coldcall_c10 = $value->count;
                                              
                                            break;

                                            case 6:
                                            
                                              $conference_v10 = number_format($value->amt / 1000, 0, '.', '');
                                              $conference_c10 = $value->count;
                                              
                                            
                                            break;

                                            
                                            case 7:
                                            
                                              $directcall_v10 = number_format($value->amt / 1000, 0, '.', '');
                                              $directcall_c10 = $value->count;
                                              
                                            break;
                                            
                                            case 8:
                                            
                                              $existing_v10 = number_format($value->amt / 1000, 0, '.', '');
                                              $existing_c10 = $value->count;
                                              
                                            break;


                                            case 9:
                                            
                                            
                                              $email_v10 = number_format($value->amt / 1000, 0, '.', '');
                                              $email_c10 = $value->count;
                                              
                                            break;
                                            
                                            case 10:
                                            
                                              $expo_v10 = number_format($value->amt / 1000, 0, '.', '');
                                              $expo_c10 = $value->count;
                                              
                                            
                                            break;


                                            case 11:
                                            
                                              $gem_v10 = number_format($value->amt / 1000, 0, '.', '');
                                              $gem_c10 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 12:
                                            
                                            
                                              $other_v10 = number_format($value->amt / 1000, 0, '.', '');
                                              $other_c10 = $value->count;
                                              
                                            break;


                                            case 13:
                                            
                                              $principle_v10 = number_format($value->amt / 1000, 0, '.', '');
                                              $principle_c10 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 14:
                                            
                                              $publicrelation_v10 = number_format($value->amt / 1000, 0, '.', '');
                                              $publicrelation_c10 = $value->count;
                                              
                                            
                                            break;


                                            case 15:
                                           
                                              $self_v10 = number_format($value->amt / 1000, 0, '.', '');
                                              $self_c10 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 16:
                                            
                                            
                                              $website_v10 = number_format($value->amt / 1000, 0, '.', '');
                                              $website_c10 = $value->count;
                                              
                                            break;



                                            case 17:
                                            
                                              $mouth_v10 = number_format($value->amt / 1000, 0, '.', '');
                                              $mouth_c10 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 18:
                                            
                                              $olddb_v10 = number_format($value->amt / 1000, 0, '.', '');
                                              $olddb_c10 = $value->count;
                                              
                                            
                                            break;


                                            case 19:
                                            
                                              $mid_v10 = number_format($value->amt / 1000, 0, '.', '');
                                              $mid_c10 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 20:
                                            
                                              $gid_v10 = number_format($value->amt / 1000, 0, '.', '');
                                              $gid_c10 = $value->count;
                                              
                                            
                                            break;


                                            case 21:
                                           
                                              $directmail_v10 = number_format($value->amt / 1000, 0, '.', '');
                                              $directmail_c10 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 22:
                                            
                                              $partner_v10 = number_format($value->amt / 1000, 0, '.', '');
                                              $partner_c10 = $value->count;
                                              
                                            
                                            break;

                                            
                                            case 23:
                                            
                                              $visit_v10 = number_format($value->amt / 1000, 0, '.', '');
                                              $visit_c10 = $value->count;
                                              
                                            
                                            break;


                                            default :
                                            echo 'no match';
                                            break;
                                            
                                          }
                                        }
                                      
                                        
                                        
                                        


                                        ////month11

                                         $this->db->select('offer_register.offer_source, enquiry_source_master.source_name, sum(offer_product_relation.total_amount_without_gst) as amt,count(DISTINCT(offer_register.entity_id)) as count');
                                        $this->db->from('offer_product_relation');
                                        $this->db->join('offer_register', 'offer_register.entity_id = offer_product_relation.offer_id','inner');
                                        $this->db->join('enquiry_source_master', 'enquiry_source_master.entity_id = offer_register.offer_source','inner');
                                        $where = '(offer_register.offer_close_date >= "'.$first_date_of_11month.'" And offer_register.offer_close_date <= "'.$last_date_of_11month.'" And offer_register.offer_engg_name ="'. $offer_engg_name.'" And offer_register.status ="6" )';
                                        $this->db->where($where);
                                        $this->db->group_by('offer_register.offer_source');
                                        $query = $this->db->get();
                                        $query_result = $query->result();

                                        foreach ($query_result as $key => $value) {
                                          // echo '<pre>';
                                          // print_r($value);
                                          // die();
                                          
                                          switch($value->offer_source){

                                            case 1:
                                            
                                              $indiamart_v11 = number_format($value->amt / 1000, 0, '.', '');
                                              $indiamart_c11 = $value->count;
                                            
                                            break;

                                            case 2:
                                              
                                              $tradeindia_v11 = number_format($value->amt / 1000, 0, '.', '');
                                              $tradeindia_c11 = $value->count;
                                            
                                            
                                            
                                            break;

                                            case 3:
                                              $exporter_v11 = number_format($value->amt / 1000, 0, '.', '');
                                              $exporter_c11 = $value->count;
                                            
                                            break;

                                            case 4:
                                            
                                            $campaign_v11 = number_format($value->amt / 1000, 0, '.', '');
                                            $campaign_c11 = $value->count;
                                            
                                            break;

                                            case 5:
                                            
                                              $coldcall_v11 = number_format($value->amt / 1000, 0, '.', '');
                                              $coldcall_c11 = $value->count;
                                              
                                            break;

                                            case 6:
                                            
                                              $conference_v11 = number_format($value->amt / 1000, 0, '.', '');
                                              $conference_c11 = $value->count;
                                              
                                            
                                            break;

                                            
                                            case 7:
                                            
                                              $directcall_v11 = number_format($value->amt / 1000, 0, '.', '');
                                              $directcall_c11 = $value->count;
                                              
                                            break;
                                            
                                            case 8:
                                            
                                              $existing_v11 = number_format($value->amt / 1000, 0, '.', '');
                                              $existing_c11 = $value->count;
                                              
                                            break;


                                            case 9:
                                            
                                            
                                              $email_v11 = number_format($value->amt / 1000, 0, '.', '');
                                              $email_c11 = $value->count;
                                              
                                            break;
                                            
                                            case 10:
                                            
                                              $expo_v11 = number_format($value->amt / 1000, 0, '.', '');
                                              $expo_c11 = $value->count;
                                              
                                            
                                            break;


                                            case 11:
                                            
                                              $gem_v11 = number_format($value->amt / 1000, 0, '.', '');
                                              $gem_c11 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 12:
                                            
                                            
                                              $other_v11 = number_format($value->amt / 1000, 0, '.', '');
                                              $other_c11 = $value->count;
                                              
                                            break;


                                            case 13:
                                            
                                              $principle_v11 = number_format($value->amt / 1000, 0, '.', '');
                                              $principle_c11 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 14:
                                            
                                              $publicrelation_v11 = number_format($value->amt / 1000, 0, '.', '');
                                              $publicrelation_c11 = $value->count;
                                              
                                            
                                            break;


                                            case 15:
                                           
                                              $self_v11 = number_format($value->amt / 1000, 0, '.', '');
                                              $self_c11 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 16:
                                            
                                            
                                              $website_v11 = number_format($value->amt / 1000, 0, '.', '');
                                              $website_c11 = $value->count;
                                              
                                            break;



                                            case 17:
                                            
                                              $mouth_v11 = number_format($value->amt / 1000, 0, '.', '');
                                              $mouth_c11 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 18:
                                            
                                              $olddb_v11 = number_format($value->amt / 1000, 0, '.', '');
                                              $olddb_c11 = $value->count;
                                              
                                            
                                            break;


                                            case 19:
                                            
                                              $mid_v11 = number_format($value->amt / 1000, 0, '.', '');
                                              $mid_c11 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 20:
                                            
                                              $gid_v11 = number_format($value->amt / 1000, 0, '.', '');
                                              $gid_c11 = $value->count;
                                              
                                            
                                            break;


                                            case 21:
                                           
                                              $directmail_v11 = number_format($value->amt / 1000, 0, '.', '');
                                              $directmail_c11 = $value->count;
                                              
                                            
                                            break;
                                            
                                            case 22:
                                            
                                              $partner_v11 = number_format($value->amt / 1000, 0, '.', '');
                                              $partner_c11 = $value->count;
                                              
                                            
                                            break;

                                            
                                            case 23:
                                            
                                              $visit_v11 = number_format($value->amt / 1000, 0, '.', '');
                                              $visit_c11 = $value->count;
                                              
                                            
                                            break;


                                            default :
                                            echo 'no match';
                                            break;
                                            
                                          }
                                        }
                                      
                                        


                                        
                                    ?>
                                    <!-- general form elements disabled -->
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Quotation Source Summary Report</h3>
                                          </div>
                                          <div class="card-body">
                                          <h3 >Count (Value in Thousands) </h3>
                                          <h5 >Figures in bracket () are Quotation Amount without GST in Rupees Thousands </h5>
                                            <div  class="table-responsive">
                                                <table id="example1" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Source</th>
                                                            <th> <?php echo $month0 ; ?></th>
                                                            <th> <?php echo $month1 ; ?></th>
                                                            <th> <?php echo $month2 ; ?></th>
                                                            <th> <?php echo $month3 ; ?></th>
                                                            <th> <?php echo $month4 ; ?></th>
                                                            <th> <?php echo $month5 ; ?></th>
                                                            <th> <?php echo $month6 ; ?></th>
                                                            <th> <?php echo $month7 ; ?></th>
                                                            <th> <?php echo $month8 ; ?></th>
                                                            <th> <?php echo $month9 ; ?></th>
                                                            <th> <?php echo $month10 ; ?></th>
                                                            <th> <?php echo $month11 ; ?></th>
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <th>IndiaMart</th>
                                                            <th><?php echo $indiamart_c0."<br> ( ".$indiamart_v0." ) " ; ?> </th>
                                                            <th><?php echo $indiamart_c1."<br> ( ".$indiamart_v1." ) " ; ?> </th>
                                                            <th><?php echo $indiamart_c2."<br> ( ".$indiamart_v2." ) " ; ?> </th>
                                                            <th><?php echo $indiamart_c3."<br> ( ".$indiamart_v3." ) " ; ?> </th>
                                                            <th><?php echo $indiamart_c4."<br> ( ".$indiamart_v4." ) " ; ?> </th>
                                                            <th><?php echo $indiamart_c5."<br> ( ".$indiamart_v5." ) " ; ?> </th>
                                                            <th><?php echo $indiamart_c6."<br> ( ".$indiamart_v6." ) " ; ?> </th>
                                                            <th><?php echo $indiamart_c7."<br> ( ".$indiamart_v7." ) " ; ?> </th>
                                                            <th><?php echo $indiamart_c8."<br> ( ".$indiamart_v8." ) " ; ?> </th>
                                                            <th><?php echo $indiamart_c9."<br> ( ".$indiamart_v9." ) " ; ?> </th>
                                                            <th><?php echo $indiamart_c10."<br> ( ".$indiamart_v10." ) " ; ?> </th>
                                                            <th><?php echo $indiamart_c11."<br> ( ".$indiamart_v11." ) " ; ?> </th>
                                                          </tr>
                                                        <tr>
                                                            <th>TradeIndia</th>
                                                            <th><?php echo $tradeindia_c0."<br> ( ".$tradeindia_v0." ) " ; ?> </th>
                                                            <th><?php echo $tradeindia_c1."<br> ( ".$tradeindia_v1." ) " ; ?> </th>
                                                            <th><?php echo $tradeindia_c2."<br> ( ".$tradeindia_v2." ) " ; ?> </th>
                                                            <th><?php echo $tradeindia_c3."<br> ( ".$tradeindia_v3." ) " ; ?> </th>
                                                            <th><?php echo $tradeindia_c4."<br> ( ".$tradeindia_v4." ) " ; ?> </th>
                                                            <th><?php echo $tradeindia_c5."<br> ( ".$tradeindia_v5." ) " ; ?> </th>
                                                            <th><?php echo $tradeindia_c6."<br> ( ".$tradeindia_v6." ) " ; ?> </th>
                                                            <th><?php echo $tradeindia_c7."<br> ( ".$tradeindia_v7." ) " ; ?> </th>
                                                            <th><?php echo $tradeindia_c8."<br> ( ".$tradeindia_v8." ) " ; ?> </th>
                                                            <th><?php echo $tradeindia_c9."<br> ( ".$tradeindia_v9." ) " ; ?> </th>
                                                            <th><?php echo $tradeindia_c10."<br> ( ".$tradeindia_v10." ) " ; ?> </th>
                                                            <th><?php echo $tradeindia_c11."<br> ( ".$tradeindia_v11." ) " ; ?> </th>
                                                          </tr>
                                                        <tr>
                                                            <th>Exporter India</th>
                                                            <th><?php echo $exporter_c0."<br> ( ".$exporter_v0." ) " ; ?> </th>
                                                            <th><?php echo $exporter_c1."<br> ( ".$exporter_v1." ) " ; ?> </th>
                                                            <th><?php echo $exporter_c2."<br> ( ".$exporter_v2." ) " ; ?> </th>
                                                            <th><?php echo $exporter_c3."<br> ( ".$exporter_v3." ) " ; ?> </th>
                                                            <th><?php echo $exporter_c4."<br> ( ".$exporter_v4." ) " ; ?> </th>
                                                            <th><?php echo $exporter_c5."<br> ( ".$exporter_v5." ) " ; ?> </th>
                                                            <th><?php echo $exporter_c6."<br> ( ".$exporter_v6." ) " ; ?> </th>
                                                            <th><?php echo $exporter_c7."<br> ( ".$exporter_v7." ) " ; ?> </th>
                                                            <th><?php echo $exporter_c8."<br> ( ".$exporter_v8." ) " ; ?> </th>
                                                            <th><?php echo $exporter_c9."<br> ( ".$exporter_v9." ) " ; ?> </th>
                                                            <th><?php echo $exporter_c10."<br> ( ".$exporter_v10." ) " ; ?> </th>
                                                            <th><?php echo $exporter_c11."<br> ( ".$exporter_v11." ) " ; ?> </th>
                                                          </tr>
                                                        <tr>
                                                            <th>Campaign</th>
                                                            <th><?php echo $campaign_c0."<br> ( ".$campaign_v0." ) " ; ?> </th>
                                                            <th><?php echo $campaign_c1."<br> ( ".$campaign_v1." ) " ; ?> </th>
                                                            <th><?php echo $campaign_c2."<br> ( ".$campaign_v2." ) " ; ?> </th>
                                                            <th><?php echo $campaign_c3."<br> ( ".$campaign_v3." ) " ; ?> </th>
                                                            <th><?php echo $campaign_c4."<br> ( ".$campaign_v4." ) " ; ?> </th>
                                                            <th><?php echo $campaign_c5."<br> ( ".$campaign_v5." ) " ; ?> </th>
                                                            <th><?php echo $campaign_c6."<br> ( ".$campaign_v6." ) " ; ?> </th>
                                                            <th><?php echo $campaign_c7."<br> ( ".$campaign_v7." ) " ; ?> </th>
                                                            <th><?php echo $campaign_c8."<br> ( ".$campaign_v8." ) " ; ?> </th>
                                                            <th><?php echo $campaign_c9."<br> ( ".$campaign_v9." ) " ; ?> </th>
                                                            <th><?php echo $campaign_c10."<br> ( ".$campaign_v10." ) " ; ?> </th>
                                                            <th><?php echo $campaign_c11."<br> ( ".$campaign_v11." ) " ; ?> </th>
                                                          </tr>
                                                        <tr>
                                                            <th>Cold Call</th>
                                                            <th><?php echo $coldcall_c0."<br> ( ".$coldcall_v0." ) " ; ?> </th>
                                                            <th><?php echo $coldcall_c1."<br> ( ".$coldcall_v1." ) " ; ?> </th>
                                                            <th><?php echo $coldcall_c2."<br> ( ".$coldcall_v2." ) " ; ?> </th>
                                                            <th><?php echo $coldcall_c3."<br> ( ".$coldcall_v3." ) " ; ?> </th>
                                                            <th><?php echo $coldcall_c4."<br> ( ".$coldcall_v4." ) " ; ?> </th>
                                                            <th><?php echo $coldcall_c5."<br> ( ".$coldcall_v5." ) " ; ?> </th>
                                                            <th><?php echo $coldcall_c6."<br> ( ".$coldcall_v6." ) " ; ?> </th>
                                                            <th><?php echo $coldcall_c7."<br> ( ".$coldcall_v7." ) " ; ?> </th>
                                                            <th><?php echo $coldcall_c8."<br> ( ".$coldcall_v8." ) " ; ?> </th>
                                                            <th><?php echo $coldcall_c9."<br> ( ".$coldcall_v9." ) " ; ?> </th>
                                                            <th><?php echo $coldcall_c10."<br> ( ".$coldcall_v10." ) " ; ?> </th>
                                                            <th><?php echo $coldcall_c11."<br> ( ".$coldcall_v11." ) " ; ?> </th>
                                                          </tr>
                                                        <tr>
                                                            <th>Conference</th>
                                                            <th><?php echo $conference_c0."<br> ( ".$conference_v0." ) " ; ?> </th>
                                                            <th><?php echo $conference_c1."<br> ( ".$conference_v1." ) " ; ?> </th>
                                                            <th><?php echo $conference_c2."<br> ( ".$conference_v2." ) " ; ?> </th>
                                                            <th><?php echo $conference_c3."<br> ( ".$conference_v3." ) " ; ?> </th>
                                                            <th><?php echo $conference_c4."<br> ( ".$conference_v4." ) " ; ?> </th>
                                                            <th><?php echo $conference_c5."<br> ( ".$conference_v5." ) " ; ?> </th>
                                                            <th><?php echo $conference_c6."<br> ( ".$conference_v6." ) " ; ?> </th>
                                                            <th><?php echo $conference_c7."<br> ( ".$conference_v7." ) " ; ?> </th>
                                                            <th><?php echo $conference_c8."<br> ( ".$conference_v8." ) " ; ?> </th>
                                                            <th><?php echo $conference_c9."<br> ( ".$conference_v9." ) " ; ?> </th>
                                                            <th><?php echo $conference_c10."<br> ( ".$conference_v10." ) " ; ?> </th>
                                                            <th><?php echo $conference_c11."<br> ( ".$conference_v11." ) " ; ?> </th>
                                                          </tr>
                                                        <tr>
                                                            <th>Direct Call</th>
                                                            <th><?php echo $directcall_c0."<br> ( ".$directcall_v0." ) " ; ?> </th>
                                                            <th><?php echo $directcall_c1."<br> ( ".$directcall_v1." ) " ; ?> </th>
                                                            <th><?php echo $directcall_c2."<br> ( ".$directcall_v2." ) " ; ?> </th>
                                                            <th><?php echo $directcall_c3."<br> ( ".$directcall_v3." ) " ; ?> </th>
                                                            <th><?php echo $directcall_c4."<br> ( ".$directcall_v4." ) " ; ?> </th>
                                                            <th><?php echo $directcall_c5."<br> ( ".$directcall_v5." ) " ; ?> </th>
                                                            <th><?php echo $directcall_c6."<br> ( ".$directcall_v6." ) " ; ?> </th>
                                                            <th><?php echo $directcall_c7."<br> ( ".$directcall_v7." ) " ; ?> </th>
                                                            <th><?php echo $directcall_c8."<br> ( ".$directcall_v8." ) " ; ?> </th>
                                                            <th><?php echo $directcall_c9."<br> ( ".$directcall_v9." ) " ; ?> </th>
                                                            <th><?php echo $directcall_c10."<br> ( ".$directcall_v10." ) " ; ?> </th>
                                                            <th><?php echo $directcall_c11."<br> ( ".$directcall_v11." ) " ; ?> </th>
                                                          </tr>
                                                        <tr>
                                                            <th>Existing Customer</th>
                                                            <th><?php echo $existing_c0."<br> ( ".$existing_v0." ) " ; ?> </th>
                                                            <th><?php echo $existing_c1."<br> ( ".$existing_v1." ) " ; ?> </th>
                                                            <th><?php echo $existing_c2."<br> ( ".$existing_v2." ) " ; ?> </th>
                                                            <th><?php echo $existing_c3."<br> ( ".$existing_v3." ) " ; ?> </th>
                                                            <th><?php echo $existing_c4."<br> ( ".$existing_v4." ) " ; ?> </th>
                                                            <th><?php echo $existing_c5."<br> ( ".$existing_v5." ) " ; ?> </th>
                                                            <th><?php echo $existing_c6."<br> ( ".$existing_v6." ) " ; ?> </th>
                                                            <th><?php echo $existing_c7."<br> ( ".$existing_v7." ) " ; ?> </th>
                                                            <th><?php echo $existing_c8."<br> ( ".$existing_v8." ) " ; ?> </th>
                                                            <th><?php echo $existing_c9."<br> ( ".$existing_v9." ) " ; ?> </th>
                                                            <th><?php echo $existing_c10."<br> ( ".$existing_v10." ) " ; ?> </th>
                                                            <th><?php echo $existing_c11."<br> ( ".$existing_v11." ) " ; ?> </th>
                                                          </tr>
                                                        <tr>
                                                            <th>Email</th>
                                                            <th><?php echo $email_c0."<br> ( ".$email_v0." ) " ; ?> </th>
                                                            <th><?php echo $email_c1."<br> ( ".$email_v1." ) " ; ?> </th>
                                                            <th><?php echo $email_c2."<br> ( ".$email_v2." ) " ; ?> </th>
                                                            <th><?php echo $email_c3."<br> ( ".$email_v3." ) " ; ?> </th>
                                                            <th><?php echo $email_c4."<br> ( ".$email_v4." ) " ; ?> </th>
                                                            <th><?php echo $email_c5."<br> ( ".$email_v5." ) " ; ?> </th>
                                                            <th><?php echo $email_c6."<br> ( ".$email_v6." ) " ; ?> </th>
                                                            <th><?php echo $email_c7."<br> ( ".$email_v7." ) " ; ?> </th>
                                                            <th><?php echo $email_c8."<br> ( ".$email_v8." ) " ; ?> </th>
                                                            <th><?php echo $email_c9."<br> ( ".$email_v9." ) " ; ?> </th>
                                                            <th><?php echo $email_c10."<br> ( ".$email_v10." ) " ; ?> </th>
                                                            <th><?php echo $email_c11."<br> ( ".$email_v11." ) " ; ?> </th>
                                                          </tr>
                                                        <tr>
                                                            <th>Expo</th>
                                                            <th><?php echo $expo_c0."<br> ( ".$expo_v0." ) " ; ?> </th>
                                                            <th><?php echo $expo_c1."<br> ( ".$expo_v1." ) " ; ?> </th>
                                                            <th><?php echo $expo_c2."<br> ( ".$expo_v2." ) " ; ?> </th>
                                                            <th><?php echo $expo_c3."<br> ( ".$expo_v3." ) " ; ?> </th>
                                                            <th><?php echo $expo_c4."<br> ( ".$expo_v4." ) " ; ?> </th>
                                                            <th><?php echo $expo_c5."<br> ( ".$expo_v5." ) " ; ?> </th>
                                                            <th><?php echo $expo_c6."<br> ( ".$expo_v6." ) " ; ?> </th>
                                                            <th><?php echo $expo_c7."<br> ( ".$expo_v7." ) " ; ?> </th>
                                                            <th><?php echo $expo_c8."<br> ( ".$expo_v8." ) " ; ?> </th>
                                                            <th><?php echo $expo_c9."<br> ( ".$expo_v9." ) " ; ?> </th>
                                                            <th><?php echo $expo_c10."<br> ( ".$expo_v10." ) " ; ?> </th>
                                                            <th><?php echo $expo_c11."<br> ( ".$expo_v11." ) " ; ?> </th>
                                                          </tr>
                                                        <tr>
                                                            <th>GEM</th>
                                                            <th><?php echo $gem_c0."<br> ( ".$gem_v0." ) " ; ?> </th>
                                                            <th><?php echo $gem_c1."<br> ( ".$gem_v1." ) " ; ?> </th>
                                                            <th><?php echo $gem_c2."<br> ( ".$gem_v2." ) " ; ?> </th>
                                                            <th><?php echo $gem_c3."<br> ( ".$gem_v3." ) " ; ?> </th>
                                                            <th><?php echo $gem_c4."<br> ( ".$gem_v4." ) " ; ?> </th>
                                                            <th><?php echo $gem_c5."<br> ( ".$gem_v5." ) " ; ?> </th>
                                                            <th><?php echo $gem_c6."<br> ( ".$gem_v6." ) " ; ?> </th>
                                                            <th><?php echo $gem_c7."<br> ( ".$gem_v7." ) " ; ?> </th>
                                                            <th><?php echo $gem_c8."<br> ( ".$gem_v8." ) " ; ?> </th>
                                                            <th><?php echo $gem_c9."<br> ( ".$gem_v9." ) " ; ?> </th>
                                                            <th><?php echo $gem_c10."<br> ( ".$gem_v10." ) " ; ?> </th>
                                                            <th><?php echo $gem_c11."<br> ( ".$gem_v11." ) " ; ?> </th>
                                                          </tr>
                                                        <tr>
                                                            <th>Other</th>
                                                            <th><?php echo $other_c0."<br> ( ".$other_v0." ) " ; ?> </th>
                                                            <th><?php echo $other_c1."<br> ( ".$other_v1." ) " ; ?> </th>
                                                            <th><?php echo $other_c2."<br> ( ".$other_v2." ) " ; ?> </th>
                                                            <th><?php echo $other_c3."<br> ( ".$other_v3." ) " ; ?> </th>
                                                            <th><?php echo $other_c4."<br> ( ".$other_v4." ) " ; ?> </th>
                                                            <th><?php echo $other_c5."<br> ( ".$other_v5." ) " ; ?> </th>
                                                            <th><?php echo $other_c6."<br> ( ".$other_v6." ) " ; ?> </th>
                                                            <th><?php echo $other_c7."<br> ( ".$other_v7." ) " ; ?> </th>
                                                            <th><?php echo $other_c8."<br> ( ".$other_v8." ) " ; ?> </th>
                                                            <th><?php echo $other_c9."<br> ( ".$other_v9." ) " ; ?> </th>
                                                            <th><?php echo $other_c10."<br> ( ".$other_v10." ) " ; ?> </th>
                                                            <th><?php echo $other_c11."<br> ( ".$other_v11." ) " ; ?> </th>
                                                          </tr>
                                                        <tr>
                                                            <th>Principle</th>
                                                            <th><?php echo $principle_c0."<br> ( ".$principle_v0." ) " ; ?> </th>
                                                            <th><?php echo $principle_c1."<br> ( ".$principle_v1." ) " ; ?> </th>
                                                            <th><?php echo $principle_c2."<br> ( ".$principle_v2." ) " ; ?> </th>
                                                            <th><?php echo $principle_c3."<br> ( ".$principle_v3." ) " ; ?> </th>
                                                            <th><?php echo $principle_c4."<br> ( ".$principle_v4." ) " ; ?> </th>
                                                            <th><?php echo $principle_c5."<br> ( ".$principle_v5." ) " ; ?> </th>
                                                            <th><?php echo $principle_c6."<br> ( ".$principle_v6." ) " ; ?> </th>
                                                            <th><?php echo $principle_c7."<br> ( ".$principle_v7." ) " ; ?> </th>
                                                            <th><?php echo $principle_c8."<br> ( ".$principle_v8." ) " ; ?> </th>
                                                            <th><?php echo $principle_c9."<br> ( ".$principle_v9." ) " ; ?> </th>
                                                            <th><?php echo $principle_c10."<br> ( ".$principle_v10." ) " ; ?> </th>
                                                            <th><?php echo $principle_c11."<br> ( ".$principle_v11." ) " ; ?> </th>
                                                          </tr>
                                                        <tr>
                                                            <th>Public Relation</th>
                                                            <th><?php echo $publicrelation_c0."<br> ( ".$publicrelation_v0." ) " ; ?> </th>
                                                            <th><?php echo $publicrelation_c1."<br> ( ".$publicrelation_v1." ) " ; ?> </th>
                                                            <th><?php echo $publicrelation_c2."<br> ( ".$publicrelation_v2." ) " ; ?> </th>
                                                            <th><?php echo $publicrelation_c3."<br> ( ".$publicrelation_v3." ) " ; ?> </th>
                                                            <th><?php echo $publicrelation_c4."<br> ( ".$publicrelation_v4." ) " ; ?> </th>
                                                            <th><?php echo $publicrelation_c5."<br> ( ".$publicrelation_v5." ) " ; ?> </th>
                                                            <th><?php echo $publicrelation_c6."<br> ( ".$publicrelation_v6." ) " ; ?> </th>
                                                            <th><?php echo $publicrelation_c7."<br> ( ".$publicrelation_v7." ) " ; ?> </th>
                                                            <th><?php echo $publicrelation_c8."<br> ( ".$publicrelation_v8." ) " ; ?> </th>
                                                            <th><?php echo $publicrelation_c9."<br> ( ".$publicrelation_v9." ) " ; ?> </th>
                                                            <th><?php echo $publicrelation_c10."<br> ( ".$publicrelation_v10." ) " ; ?> </th>
                                                            <th><?php echo $publicrelation_c11."<br> ( ".$publicrelation_v11." ) " ; ?> </th>
                                                          </tr>
                                                        <tr>
                                                            <th>Self</th>
                                                            <th><?php echo $self_c0."<br> ( ".$self_v0." ) " ; ?> </th>
                                                            <th><?php echo $self_c1."<br> ( ".$self_v1." ) " ; ?> </th>
                                                            <th><?php echo $self_c2."<br> ( ".$self_v2." ) " ; ?> </th>
                                                            <th><?php echo $self_c3."<br> ( ".$self_v3." ) " ; ?> </th>
                                                            <th><?php echo $self_c4."<br> ( ".$self_v4." ) " ; ?> </th>
                                                            <th><?php echo $self_c5."<br> ( ".$self_v5." ) " ; ?> </th>
                                                            <th><?php echo $self_c6."<br> ( ".$self_v6." ) " ; ?> </th>
                                                            <th><?php echo $self_c7."<br> ( ".$self_v7." ) " ; ?> </th>
                                                            <th><?php echo $self_c8."<br> ( ".$self_v8." ) " ; ?> </th>
                                                            <th><?php echo $self_c9."<br> ( ".$self_v9." ) " ; ?> </th>
                                                            <th><?php echo $self_c10."<br> ( ".$self_v10." ) " ; ?> </th>
                                                            <th><?php echo $self_c11."<br> ( ".$self_v11." ) " ; ?> </th>
                                                          </tr>
                                                        <tr>
                                                            <th>Website</th>
                                                            <th><?php echo $website_c0."<br> ( ".$website_v0." ) " ; ?> </th>
                                                            <th><?php echo $website_c1."<br> ( ".$website_v1." ) " ; ?> </th>
                                                            <th><?php echo $website_c2."<br> ( ".$website_v2." ) " ; ?> </th>
                                                            <th><?php echo $website_c3."<br> ( ".$website_v3." ) " ; ?> </th>
                                                            <th><?php echo $website_c4."<br> ( ".$website_v4." ) " ; ?> </th>
                                                            <th><?php echo $website_c5."<br> ( ".$website_v5." ) " ; ?> </th>
                                                            <th><?php echo $website_c6."<br> ( ".$website_v6." ) " ; ?> </th>
                                                            <th><?php echo $website_c7."<br> ( ".$website_v7." ) " ; ?> </th>
                                                            <th><?php echo $website_c8."<br> ( ".$website_v8." ) " ; ?> </th>
                                                            <th><?php echo $website_c9."<br> ( ".$website_v9." ) " ; ?> </th>
                                                            <th><?php echo $website_c10."<br> ( ".$website_v10." ) " ; ?> </th>
                                                            <th><?php echo $website_c11."<br> ( ".$website_v11." ) " ; ?> </th>
                                                          </tr>
                                                        <tr>
                                                            <th>Word of Mouth</th>
                                                            <th><?php echo $mouth_c0."<br> ( ".$mouth_v0." ) " ; ?> </th>
                                                            <th><?php echo $mouth_c1."<br> ( ".$mouth_v1." ) " ; ?> </th>
                                                            <th><?php echo $mouth_c2."<br> ( ".$mouth_v2." ) " ; ?> </th>
                                                            <th><?php echo $mouth_c3."<br> ( ".$mouth_v3." ) " ; ?> </th>
                                                            <th><?php echo $mouth_c4."<br> ( ".$mouth_v4." ) " ; ?> </th>
                                                            <th><?php echo $mouth_c5."<br> ( ".$mouth_v5." ) " ; ?> </th>
                                                            <th><?php echo $mouth_c6."<br> ( ".$mouth_v6." ) " ; ?> </th>
                                                            <th><?php echo $mouth_c7."<br> ( ".$mouth_v7." ) " ; ?> </th>
                                                            <th><?php echo $mouth_c8."<br> ( ".$mouth_v8." ) " ; ?> </th>
                                                            <th><?php echo $mouth_c9."<br> ( ".$mouth_v9." ) " ; ?> </th>
                                                            <th><?php echo $mouth_c10."<br> ( ".$mouth_v10." ) " ; ?> </th>
                                                            <th><?php echo $mouth_c11."<br> ( ".$mouth_v11." ) " ; ?> </th>
                                                          </tr>
                                                        <tr>
                                                            <th>Old Database</th>
                                                            <th><?php echo $olddb_c0."<br> ( ".$olddb_v0." ) " ; ?> </th>
                                                            <th><?php echo $olddb_c1."<br> ( ".$olddb_v1." ) " ; ?> </th>
                                                            <th><?php echo $olddb_c2."<br> ( ".$olddb_v2." ) " ; ?> </th>
                                                            <th><?php echo $olddb_c3."<br> ( ".$olddb_v3." ) " ; ?> </th>
                                                            <th><?php echo $olddb_c4."<br> ( ".$olddb_v4." ) " ; ?> </th>
                                                            <th><?php echo $olddb_c5."<br> ( ".$olddb_v5." ) " ; ?> </th>
                                                            <th><?php echo $olddb_c6."<br> ( ".$olddb_v6." ) " ; ?> </th>
                                                            <th><?php echo $olddb_c7."<br> ( ".$olddb_v7." ) " ; ?> </th>
                                                            <th><?php echo $olddb_c8."<br> ( ".$olddb_v8." ) " ; ?> </th>
                                                            <th><?php echo $olddb_c9."<br> ( ".$olddb_v9." ) " ; ?> </th>
                                                            <th><?php echo $olddb_c10."<br> ( ".$olddb_v10." ) " ; ?> </th>
                                                            <th><?php echo $olddb_c11."<br> ( ".$olddb_v11." ) " ; ?> </th>
                                                          </tr>
                                                        <tr>
                                                            <th>MID</th>
                                                            <th><?php echo $mid_c0."<br> ( ".$mid_v0." ) " ; ?> </th>
                                                            <th><?php echo $mid_c1."<br> ( ".$mid_v1." ) " ; ?> </th>
                                                            <th><?php echo $mid_c2."<br> ( ".$mid_v2." ) " ; ?> </th>
                                                            <th><?php echo $mid_c3."<br> ( ".$mid_v3." ) " ; ?> </th>
                                                            <th><?php echo $mid_c4."<br> ( ".$mid_v4." ) " ; ?> </th>
                                                            <th><?php echo $mid_c5."<br> ( ".$mid_v5." ) " ; ?> </th>
                                                            <th><?php echo $mid_c6."<br> ( ".$mid_v6." ) " ; ?> </th>
                                                            <th><?php echo $mid_c7."<br> ( ".$mid_v7." ) " ; ?> </th>
                                                            <th><?php echo $mid_c8."<br> ( ".$mid_v8." ) " ; ?> </th>
                                                            <th><?php echo $mid_c9."<br> ( ".$mid_v9." ) " ; ?> </th>
                                                            <th><?php echo $mid_c10."<br> ( ".$mid_v10." ) " ; ?> </th>
                                                            <th><?php echo $mid_c11."<br> ( ".$mid_v11." ) " ; ?> </th>
                                                          </tr>
                                                        <tr>
                                                            <th>GID</th>
                                                            <th><?php echo $gid_c0."<br> ( ".$gid_v0." ) " ; ?> </th>
                                                            <th><?php echo $gid_c1."<br> ( ".$gid_v1." ) " ; ?> </th>
                                                            <th><?php echo $gid_c2."<br> ( ".$gid_v2." ) " ; ?> </th>
                                                            <th><?php echo $gid_c3."<br> ( ".$gid_v3." ) " ; ?> </th>
                                                            <th><?php echo $gid_c4."<br> ( ".$gid_v4." ) " ; ?> </th>
                                                            <th><?php echo $gid_c5."<br> ( ".$gid_v5." ) " ; ?> </th>
                                                            <th><?php echo $gid_c6."<br> ( ".$gid_v6." ) " ; ?> </th>
                                                            <th><?php echo $gid_c7."<br> ( ".$gid_v7." ) " ; ?> </th>
                                                            <th><?php echo $gid_c8."<br> ( ".$gid_v8." ) " ; ?> </th>
                                                            <th><?php echo $gid_c9."<br> ( ".$gid_v9." ) " ; ?> </th>
                                                            <th><?php echo $gid_c10."<br> ( ".$gid_v10." ) " ; ?> </th>
                                                            <th><?php echo $gid_c11."<br> ( ".$gid_v11." ) " ; ?> </th>
                                                          </tr>
                                                        <tr>
                                                            <th>Direct Mail</th>
                                                            <th><?php echo $directmail_c0."<br> ( ".$directmail_v0." ) " ; ?> </th>
                                                            <th><?php echo $directmail_c1."<br> ( ".$directmail_v1." ) " ; ?> </th>
                                                            <th><?php echo $directmail_c2."<br> ( ".$directmail_v2." ) " ; ?> </th>
                                                            <th><?php echo $directmail_c3."<br> ( ".$directmail_v3." ) " ; ?> </th>
                                                            <th><?php echo $directmail_c4."<br> ( ".$directmail_v4." ) " ; ?> </th>
                                                            <th><?php echo $directmail_c5."<br> ( ".$directmail_v5." ) " ; ?> </th>
                                                            <th><?php echo $directmail_c6."<br> ( ".$directmail_v6." ) " ; ?> </th>
                                                            <th><?php echo $directmail_c7."<br> ( ".$directmail_v7." ) " ; ?> </th>
                                                            <th><?php echo $directmail_c8."<br> ( ".$directmail_v8." ) " ; ?> </th>
                                                            <th><?php echo $directmail_c9."<br> ( ".$directmail_v9." ) " ; ?> </th>
                                                            <th><?php echo $directmail_c10."<br> ( ".$directmail_v10." ) " ; ?> </th>
                                                            <th><?php echo $directmail_c11."<br> ( ".$directmail_v11." ) " ; ?> </th>
                                                          </tr>
                                                        <tr>
                                                            <th>Partner</th>
                                                            <th><?php echo $partner_c0."<br> ( ".$partner_v0." ) " ; ?> </th>
                                                            <th><?php echo $partner_c1."<br> ( ".$partner_v1." ) " ; ?> </th>
                                                            <th><?php echo $partner_c2."<br> ( ".$partner_v2." ) " ; ?> </th>
                                                            <th><?php echo $partner_c3."<br> ( ".$partner_v3." ) " ; ?> </th>
                                                            <th><?php echo $partner_c4."<br> ( ".$partner_v4." ) " ; ?> </th>
                                                            <th><?php echo $partner_c5."<br> ( ".$partner_v5." ) " ; ?> </th>
                                                            <th><?php echo $partner_c6."<br> ( ".$partner_v6." ) " ; ?> </th>
                                                            <th><?php echo $partner_c7."<br> ( ".$partner_v7." ) " ; ?> </th>
                                                            <th><?php echo $partner_c8."<br> ( ".$partner_v8." ) " ; ?> </th>
                                                            <th><?php echo $partner_c9."<br> ( ".$partner_v9." ) " ; ?> </th>
                                                            <th><?php echo $partner_c10."<br> ( ".$partner_v10." ) " ; ?> </th>
                                                            <th><?php echo $partner_c11."<br> ( ".$partner_v11." ) " ; ?> </th>
                                                          </tr>
                                                        <tr>
                                                            <th>Visit</th>
                                                            <th><?php echo $visit_c0."<br> ( ".$visit_v0." ) " ; ?> </th>
                                                            <th><?php echo $visit_c1."<br> ( ".$visit_v1." ) " ; ?> </th>
                                                            <th><?php echo $visit_c2."<br> ( ".$visit_v2." ) " ; ?> </th>
                                                            <th><?php echo $visit_c3."<br> ( ".$visit_v3." ) " ; ?> </th>
                                                            <th><?php echo $visit_c4."<br> ( ".$visit_v4." ) " ; ?> </th>
                                                            <th><?php echo $visit_c5."<br> ( ".$visit_v5." ) " ; ?> </th>
                                                            <th><?php echo $visit_c6."<br> ( ".$visit_v6." ) " ; ?> </th>
                                                            <th><?php echo $visit_c7."<br> ( ".$visit_v7." ) " ; ?> </th>
                                                            <th><?php echo $visit_c8."<br> ( ".$visit_v8." ) " ; ?> </th>
                                                            <th><?php echo $visit_c9."<br> ( ".$visit_v9." ) " ; ?> </th>
                                                            <th><?php echo $visit_c10."<br> ( ".$visit_v10." ) " ; ?> </th>
                                                            <th><?php echo $visit_c11."<br> ( ".$visit_v11." ) " ; ?> </th>
                                                          </tr>

                                                        
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
        <!-- DataTables -->
        <!-- <script src="assets/plugins/datatables/jquery.dataTables.js"></script>
        <script src="assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script> -->
        <!-- Page script -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">

        <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
        <!-- Page script -->
        <script>
            $(document).ready(function() {
                $('#example1').DataTable( {
                    dom: 'Bfrtip',
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdfHtml5'
                    ]
                } );
            } );  
        </script>   
    </body>
</html>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ob_start();
    class Welcome extends CI_Controller {
        public function __construct() {
		    parent::__construct();
	        $this->load->helper('form');
		    $this->load->library('form_validation');
		    $this->load->library('session');
            $this->load->model('welcome_model');
            $this->load->library('upload');
            $this->load->library('email');
        }

	    public function index()
        {
	        $this->load->view('vw_login');
	    }

        public function profile()
        {
            $this->load->view('profile');
        }
        public function get_comp_data()
        {
            // code...

            $id= $this->input->post('id');
            $state=$this->db->select('state_id,city_id')->from('company_master')->where('entity_id',$id)->get()->row_array();
            echo json_encode($state);
        }

        public function save_profile()
        {
            $id=$this->input->post('company_id');
            $name=$this->input->post('company_name');
            $email=$this->input->post('company_mail');
            $address=$this->input->post('company_address');
            $state=$this->input->post('state_id');
            $city=$this->input->post('city_id');
            $state_code=$this->input->post('state_code');
            $pin=$this->input->post('customer_pin_code');
            $gst=$this->input->post('customer_gst_number');
            $mob=$this->input->post('mob');
            $key=$this->input->post('company_key');

            $data=array('company_name'=>$name,'email_id'=>$email,'address'=>$address,'state_id'=>$state,'city_id'=>$city,'state_code'=>$state_code,'pin_code'=>$pin,'gst_no'=>$gst,'mobile_no'=>$mob,'indiamart_key'=>$key);

            $this->db->where('entity_id',$id);
            $this->db->update('company_master',$data);

            redirect('dashboard');
        }
	    public function process()
        {
    	    $this->load->library('form_validation');
            $this->form_validation->set_rules('user_name','Username','required');
            $this->form_validation->set_rules('password','Password','required');
            if($this->form_validation->run())
            {
                $user_name = $this->input->post('user_name');
                $password = $this->input->post('password');
                $encrypted_password = sha1($password);

                if($this->welcome_model->validate($user_name,$encrypted_password))
                {

                    $this->db->select('user_login.*, concat(employee_master.emp_first_name," ",employee_master.emp_last_name) as employee_name');
                    $this->db->from('user_login');
                    $this->db->join('employee_master','employee_master.entity_id = user_login.emp_id','inner');
                    $where = '(user_name = "'.$user_name.'" AND password = "'.$encrypted_password.'")';
                    $this->db->where($where);
                    $user_master = $this->db->get();
                    $row = $user_master->row();

                    $session_data = array(
                      'user_name' => $user_name ,
                      'user_id' => $row->entity_id,
                      'full_name' => $row->employee_name , 
                      'role_id' => $row->role_id , 
                      'company_id' => $row->company_id, 
                      'emp_id' => $row->emp_id
                    );
                    $this->session->set_userdata($session_data);
                    redirect(base_url().'dashboard');
                }else{
                    $this->session->set_flashdata('error','Invalid Username And Password');
                    redirect(base_url().'welcome');
                }
            }else{
                $this->session->set_flashdata('error','Enter Username And Password');
                redirect(base_url().'welcome');
            }

            /*$this->load->library('form_validation');
            $this->form_validation->set_rules('user_name','Username','required');
            if($this->form_validation->run())
            {
                $username = $this->input->post('user_name');

                $this->db->select('*');
                $this->db->from('user_login');
                $where = '(user_name = "'.$username.'")';
                $this->db->where($where);
                $user_master = $this->db->get();
                $row = $user_master->row();

                if(!empty($row))
                {
                    $user_id = $row->entity_id;

                    $otp = rand(100000,999999);
                
                    $to_email = array('marketing@saicontrolsystems.com' , 'mktg1@saicontrolsystems.com');
                    $contact_id = $row->entity_id;
                    
                    $cc_email = array('vbdigitech@gmail.com');
                    $this->email->set_mailtype("html");
                    $this->email->set_newline("\r\n");

                    //Email content
                    $message = "One Time Password For Sai Control System Authentication is:<br/><br/>" . $otp;

                    $message .= "</body></html>";

                    $Subject = "OTP to Login";

                    $this->email->to($to_email);
                    $this->email->cc($cc_email);
                    $this->email->from('enquiry.from.website.000@gmail.com','Support VB Digitech');
                    $this->email->subject($Subject);
                    $this->email->message($message);
                    if($this->email->send()) {
                        $this->session->set_userdata('message_name', 'Otp Send Successfully....!');
                    }

                    $data_insert = "INSERT INTO otp_expiry (otp , is_expired , create_at , user_id) VALUES ('" . $otp . "', 0 , '" . date("Y-m-d H:i:s"). "' , '" . $user_id . "')";
                    $data_insert_execute = $this->db->query($data_insert);

                    redirect(base_url().'second_login_page'.'/'.$user_id);
                }else{
                    $this->session->set_flashdata('error','Enter Wrong Username');
                    redirect(base_url().'welcome');
                }
            }else{
                $this->session->set_flashdata('error','Enter Username');
                redirect(base_url().'welcome');
            }*/
	    }

    	public function dashboard()
    	{
            if($this->session->userdata('user_name') != '')  
            {  
                $this->load->view('welcome_message');
            }  
            else{  
                redirect(base_url().'welcome');
            }
    	}

        public function support_dashboard()
    	{
            $this->load->view('support_dashboard');
        }
        
        public function login()  
        {  
            $this->load->view('welcome_message');
        }

        public function logout()
        {
        	$this->session->unset_userdata('username');
        	$this->session->sess_destroy();
        	redirect('welcome');
	    }


       // public function save_info()
       // {
       //      $username = $this->input->post('username');
       //      $password = $this->input->post('password');
       //      $role_id = $this->input->post('role_id');
       //      $full_name = $this->input->post('full_name');
       //      $mobile_no = $this->input->post('mobile_no');
       //      $shapassword = sha1($password);
       //      $activation_status = 1;

       //      $data = array('username ' => $username , 'password' => $shapassword , 'role_id' => $role_id , 'full_name' => $full_name , 'mobile_no' => $mobile_no , 'activation_status' => $activation_status);

       //      $result = $this->welcome_model->save_sign_up_data($data);

       //      redirect('vw_regestration_data');
       // }

        public function second_login_page()
        {
            $entity_id = $this->uri->segment(2);

            $data['entity_id'] = $entity_id;

            $this->load->view('second_login_page',$data);
        }

        public function process_otp()
        {
            $this->load->library('form_validation');
            /*$this->form_validation->set_rules('username','Username','required');*/
            $this->form_validation->set_rules('otp','Otp','required');
            if($this->form_validation->run())
            {
                /*$username = $this->input->post('username');*/
                $OTP = $this->input->post('otp');

                $user_id = $this->input->post('user_id');

                $this->db->select('*');
                $this->db->from('otp_expiry');
                $where = '(otp = "'.$OTP.'" AND user_id = "'.$user_id.'" AND is_expired!=1 AND NOW() <= DATE_ADD(create_at, INTERVAL 24 HOUR))';
                $this->db->where($where);
                $otp_expiry = $this->db->get();
                $count = $otp_expiry->num_rows();
                $otp_data = $otp_expiry->row();

                if(!empty($count)) 
                {
                    $User_id = $otp_data->user_id;

                    $this->db->select('*');
                    $this->db->from('user_login');
                    $where = '(entity_id = "'.$User_id.'")';
                    $this->db->where($where);
                    $user_master = $this->db->get();
                    $row = $user_master->row();

                    $user_name = $row->user_name;

                    $update_otp_array = array('is_expired' => 1);

                    $where = '(otp ="'.$OTP.'")';
                    $this->db->where($where);
                    $this->db->update('otp_expiry',$update_otp_array);
                
                    $session_data = array('user_name' => $user_name ,'user_id' => $User_id,
                        'full_name' => $row->full_name , 'role_id' => $row->role_id , 'company_id' => $row->company_id, 'emp_id' => $row->emp_id);
                    $this->session->set_userdata($session_data);

                    ////////////////////////////////////////////////////////////
                    $current_date = "Y-m-d";
                    $this->db->select('offer_tracking_master.*,
                        customer_master.customer_name');
                    $this->db->from('offer_tracking_master');
                    $where = '(offer_tracking_master.tracking_date <= "'.$current_date.'")';
                    $this->db->where($where);
                    $this->db->join('customer_master', 'offer_tracking_master.customer_id = customer_master.entity_id', 'INNER');
                    $offer_tracking_master = $this->db->get();
                    $offer_tracking_master_result = $offer_tracking_master->result_array();

                    if(!empty($offer_tracking_master_result))
                    {
                        $to_email = array('marketing@saicontrolsystems.com');
                        $cc_email = array('vbdigitech@gmail.com');

                        $this->email->set_mailtype("html");
                        $this->email->set_newline("\r\n");

                        //Email content
                        $message = '<table border="0.3" cellpadding="3" width="100%">
                            <tr style="background-color: #C0C0C0;">
                                <td style="font-size: 6.5px; width: 10%; text-indent:1em;"><b>Sr.No</b></td>

                                <td style="font-size: 6.5px; width: 20%; text-indent:1em;"><b>Tracking Number</b></td>

                                <td style="font-size: 6.5px; width: 30%; text-indent:1em;"><b>Customer Name</b></td>

                                <td style="font-size: 6.5px; width: 20%; text-indent:1em;"><b>Offer Number</b></td>

                                <td style="font-size: 6.5px; width: 20%; text-indent:1em;"><b>Enquiry Number</b></td>
                            </tr>
                        </table>';

                        $i=1;
                        foreach ($offer_tracking_master_result as $value_data) 
                        {
                            $Tracking_number = $value_data['tracking_number'];
                            $Customer_name = $value_data['customer_name'];
                            $enquiry_id = $value_data['enquiry_id'];
                            $offer_id = $value_data['offer_id'];
                            
                            if(!empty($enquiry_id)) 
                            {
                                $this->db->select('*');
                                $this->db->from('enquiry_register');
                                $where = '(entity_id = "'.$enquiry_id.'")';
                                $this->db->where($where);
                                $enquiry_register = $this->db->get();
                                $enquiry_register_row = $enquiry_register->row();

                                $Enquiry_no = $enquiry_register_row->enquiry_no;
                            }else{
                                $Enquiry_no = "NA";
                            }

                            if(!empty($offer_id)) 
                            {
                                $this->db->select('*');
                                $this->db->from('offer_register');
                                $where = '(entity_id = "'.$offer_id.'")';
                                $this->db->where($where);
                                $offer_register = $this->db->get();
                                $offer_register_row = $offer_register->row();

                                $Offer_no = $offer_register_row->offer_no;
                            }else{
                                $Offer_no = "NA";
                            }
                            

                            $message .=  '<table style="border-collapse: collapse;">
                                          <tr style="border: none;">
                                            <td style="border-right: solid 1px #5a5a5a; 
                                          border-left: solid 1px #5a5a5a; width: 10%; font-size: 7.5px;text-indent:1em;">'.strip_tags($i).'<br></td>

                                            <td style="border-right: solid 1px #5a5a5a; 
                                          border-left: solid 1px #5a5a5a; width: 20%; font-size: 7.5px;text-indent:1em;"><b>'.strip_tags($Tracking_number).'</b><br></td>

                                          <td style="border-right: solid 1px #5a5a5a; 
                                          border-left: solid 1px #5a5a5a; width: 30%; font-size: 7.5px;text-indent:1em;"><b>'.strip_tags($Customer_name).'</b><br></td>

                                          <td style="border-right: solid 1px #5a5a5a; 
                                          border-left: solid 1px #5a5a5a; width: 20%; font-size: 7.5px;text-indent:1em;">'.strip_tags($Offer_no).'<br></td>

                                          <td style="border-right: solid 1px #5a5a5a; 
                                          border-left: solid 1px #5a5a5a; width: 20%; font-size: 7.5px;text-indent:1em;">'.strip_tags($Enquiry_no).'<br></td>
                                          </tr>

                                        </table>';
                                $i++;
                            
                        }

                        $message .= "</body></html>";

                        $Subject = "Tracking Details";

                        $this->email->to($to_email);
                        $this->email->cc($cc_email);
                        $this->email->from('enquiry.from.website.000@gmail.com','Support Sai Control');
                        $this->email->subject($Subject);
                        $this->email->message($message);
                    }

                    redirect(base_url().'dashboard');
                }else{
                    $success =1;
                    $error_message = "Invalid OTP!";
                } 
            }else{
                $this->session->set_flashdata('error','Enter Correct Otp');
                redirect(base_url().'welcome');
            }
        }
        
        public function update_tracking_details()
        {
            $Track_id = $this->input->post('Track_id');
            $due_date = $this->input->post('due_date');
            $remark = $this->input->post('remark');
            $status = $this->input->post('status');
            $CheckStatus = array(2,4,6,7,8,9);

            if(in_array($status,$CheckStatus) && !empty($offer_id))
            {
                $update_offer = array('status' => $status);

                $this->db->where('entity_id', $offer_id);
                $this->db->update('offer_register', $update_offer);

            }

            $user_name = $this->session->userdata('full_name');
            $todays_date = date('Y-m-d');

            if($status = 2)
            {
                $updated_remark = $remark.' '.'Offer Status Changed To Active By '.$user_name.' at '. $todays_date;
                $new_status = 3;
            }elseif($status = 3)
            {
                $updated_remark = $remark.' '.'Offer trying to convert into Order By '.$user_name.' at '. $todays_date;
                $new_status = 3;
            }elseif($status = 4)
            {
                $updated_remark = $remark.' '.'Offer Status Changed To Offer Loss By '.$user_name.' at '. $todays_date;
                $new_status = 3;
            }elseif($status = 6)
            {
                $updated_remark = $remark.' '.'Offer Status Changed To Offer Win By '.$user_name.' at '. $todays_date;
                $new_status = 3;
            }elseif($status = 7)
            {
                $updated_remark = $remark.' '.'Offer Status Changed To Offer on Hold By '.$user_name.' at '. $todays_date;
                $new_status = 3;
            }elseif($status = 8)
            {
                $updated_remark = $remark.' '.'Offer Status Changed To Offer A '.$user_name.' at '. $todays_date;
                $new_status = 3;
            }elseif($status = 9)
            {
                $updated_remark = $remark.' '.'Offer Status Changed To Offer B '.$user_name.' at '. $todays_date;
                $new_status = 3;
            }
            $update_array = array('status' => $new_status , 'action_due_date' => $due_date ,'remark' => $updated_remark);

            $this->db->where('entity_id', $Track_id);
            $this->db->update('enquiry_tracking_master', $update_array);

            echo $status;
        }
    }
?>

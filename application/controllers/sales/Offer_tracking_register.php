<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Offer_tracking_register extends CI_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('offer_tracking_register_model');
        $this->load->library('session');
    }

	public function index()
	{
        $user_id = $_SESSION['user_id'];
        $data['offer_tracking_details'] = $this->offer_tracking_register_model->get_offer_tracking_details($user_id);
		$this->load->view('sales/offer_tracking_register/vw_offer_tracking_register_index',$data);
	}

    public function create()
    {
        $data['offer_number_list'] = $this->offer_tracking_register_model->get_offer_number_list();
        $this->load->view('sales/offer_tracking_register/vw_offer_tracking_register_create',$data);
    }

    public function get_all_offer_data()
    {
        $data = $this->input->post();
        if(!empty($data))
        {
            $offer_id = $this->input->post('id');
            $data = $this->offer_tracking_register_model->get_all_data_by_offer_id($offer_id);
            echo json_encode([$data]);
        }
    }

    public function save_offer_tracking()
    {
        $user_id = $_SESSION['user_id'];
        $offer_id = $this->input->post('offer_id');
        $enquiry_id = $this->input->post('enquiry_id');
        $customer_id = $this->input->post('customer_id'); 
        $offer_tracking_date = $this->input->post('offer_tracking_date');
        $offer_tracking_descrption = $this->input->post('offer_tracking_descrption');

        $this->db->select('tracking_number');
        $this->db->from('offer_tracking_master');
        $this->db->order_by('entity_id', 'DESC');
        $this->db->limit(1);
        $offer_register = $this->db->get();
        $results_offer_tracking_register = $offer_register->result_array();

        if(!empty($results_offer_tracking_register))
        {
            $offer_tracking_serial_no = $results_offer_tracking_register[0]['tracking_number'];
            $offer_tracking_data_seprate = explode('/', $offer_tracking_serial_no);
            $offer_tracking_doc_year = $offer_tracking_data_seprate['1'];
        }

        $this->db->select('document_series_no');
        $this->db->from('documentseries_master');
        $this->db->where('entity_id=8');
        $doc_record=$this->db->get();
        $results_doc_record = $doc_record->result_array();

        $doc_serial_no = $results_doc_record[0]['document_series_no'];
        $doc_data_seprate = explode('/', $doc_serial_no);
        $doc_year = $doc_data_seprate['1'];

        if(empty($results_offer_tracking_register[0]['tracking_number']) || ($offer_tracking_doc_year != $doc_year))
        {
            $first_no = '0001';
            $doc_no = $doc_serial_no.$first_no;
        }elseif(!empty($results_offer_tracking_register) && ($offer_tracking_doc_year == $doc_year))
        {
            $doc_type = $offer_tracking_data_seprate['0'];
            $ex_no = $offer_tracking_data_seprate['2'];
            $next_en = $ex_no + 1;
            $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
            $doc_no = $doc_type.'/'.$offer_tracking_doc_year.'/'.$next_doc_no;
        }

        $data = array('user_id' => $user_id , 'tracking_number' => $doc_no , 'customer_id' => $customer_id , 'enquiry_id' => $enquiry_id  , 'offer_id' => $offer_id , 'tracking_date' => $offer_tracking_date , 'tracking_record' => $offer_tracking_descrption);

        $result = $this->offer_tracking_register_model->save_offer_tracking_model($data);

        redirect('vw_offer_tracking_entry');
    }

    public function tracking_report()
    {
        $data['list_of_offer'] = $this->offer_tracking_register_model->get_list_of_offer();
        $this->load->view('sales/offer_tracking_register/vw_offer_tracking_report_prompt',$data);
    }

    public function check_offer_tracking()
    {
        $offer_id = $this->input->post('offer_id');
        $data['display_offer_id'] = $offer_id;
        $data['offer_tracking_report_data'] = $this->offer_tracking_register_model->get_offer_tracking_data($offer_id);
        $this->load->view('sales/offer_tracking_register/vw_offer_tracking_report_display',$data);
    }


    public function set_track_offer()
    {
        $entity_id = $this->uri->segment(2);
        $offer_data = $this->offer_tracking_register_model->offer_to_offer_track_save_model($entity_id);
        $data['entity_id'] = $entity_id;
        // $data['enquiry_id_wise_data'] = $this->enquiry_tracking_register_model->get_enquiry_details_by_id_model($entity_id);
        //$data['enquiry_tracking_number'] = $this->enquiry_tracking_register_model->get_enquiry_tracking_number();
        $this->load->view('sales/offer_tracking_register/vw_offer_tracking_register_direct_create',$data);
    }


    public function get_offer_details_by_id()
    {
        $entity_id = $this->input->post('entity_id',TRUE);
        $data = $this->offer_tracking_register_model->get_offer_details_by_id_model($entity_id)->result();
        echo json_encode($data);
    }

    public function get_offer_tracking_data_by_offer_id()
    {
        $data = $this->input->post();
        if(!empty($data))
        {
            $entity_id = $this->input->post('entity_id');

            $data = $this->offer_tracking_register_model->get_offer_tracking_data_by_offer_id_model($entity_id);

            echo json_encode($data);
        }
    }


    public function update_offer_tracking()
    {
        $user_id = $_SESSION['user_id'];  
        $offer_entity_id = $this->input->post('offer_entity_id');
        $customer_id = $this->input->post('customer_id');
        $tracking_number = $this->input->post('tracking_number');
        $enquiry_id = $this->input->post('enquiry_id');
        $offer_id = $this->input->post('offer_id');
        $tracking_date = $this->input->post('tracking_date');
        $tracking_record = $this->input->post('tracking_record');
        $status = 2;

        $this->db->select('*');
        $this->db->from('offer_tracking_master');
        $where = '(offer_tracking_master.offer_id = "'.$offer_entity_id.'")';
        $this->db->where($where);
        $this->db->order_by('offer_tracking_master.entity_id', 'DESC');
        $this->db->limit(1);
        $query_data = $this->db->get();
        $query_result = $query_data->row_array();
        $offer_tracking_id = $query_result['entity_id'];
        // print_r($enquiry_tracking_id);
        // die();



        $data = array('entity_id' => $offer_tracking_id ,'tracking_date' => $tracking_date , 'tracking_record' => $tracking_record, 'status' => $status);

        $result = $this->offer_tracking_register_model->update_offer_tracking_model($data);

        redirect('vw_offer_tracking_entry');
    }

}
?>
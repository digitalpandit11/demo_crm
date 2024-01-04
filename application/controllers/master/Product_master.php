<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ob_start();
class Product_master extends CI_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('product_master_model');
        $this->load->library('session');
    }

	public function index()
	{
        $data['product_master'] = $this->product_master_model->get_product_details();
		$this->load->view('master/product_master/vw_product_master_index',$data);
	}

    public function create()
    {
        $data['product_category'] = $this->product_master_model->get_product_category();
        $data['product_hsn_code'] = $this->product_master_model->get_product_hsn_code();
        $data['unit_list'] = $this->product_master_model->get_unit_list();
        $data['make_list'] = $this->product_master_model->get_make_list();
        $this->load->view('master/product_master/vw_product_master_create',$data);
    }

    public function get_sub_category(){
        $category_id = $this->input->post('id',TRUE);
        $data = $this->product_master_model->get_sub_category($category_id)->result();
        echo json_encode($data);
    }

    public function get_product_id(){
        $category_id = $this->input->post('category_id');
        $sub_category_id = $this->input->post('sub_category_id');
        $data = $this->product_master_model->get_product_id($category_id,$sub_category_id);
        echo json_encode([$data]);
    }

    public function save_product_master()
    {

        $product_id = $this->input->post('product_id');
        $product_name = $this->input->post('product_name');
        $hsn_code = $this->input->post('hsn_code');
        $product_make = $this->input->post('product_make');
        $category_id = $this->input->post('category_id');
        $product_long_desc = $this->input->post('product_long_desc');
        $product_warranty = $this->input->post('product_warranty');
        $product_unit = $this->input->post('product_unit');
        $product_price = $this->input->post('product_price');
        $internal_remark = $this->input->post('internal_remark');
        $product_type = 1;
        
        $data = array('category_id' => $category_id , 'product_id' => $product_id , 'product_name' => $product_name , 'product_long_description' => $product_long_desc , 'product_type' => $product_type , 'unit' => $product_unit , 'warrenty' => $product_warranty , 'hsn_id' => $hsn_code , 'internal_remark' => $internal_remark , 'product_make' => $product_make , 'status' => 1);

        $result = $this->product_master_model->save_product_master_model($data,$product_price);
        redirect('product_master');
    }

    public function edit_product_master()
    {
        $entity_id = $this->uri->segment(2);
        $data['entity_id'] = $entity_id;
        $data['product_hsn_code'] = $this->product_master_model->get_product_hsn_code();
        $data['unit_list'] = $this->product_master_model->get_unit_list();
        $data['product_category'] = $this->product_master_model->get_product_category();
        $data['make_list'] = $this->product_master_model->get_make_list();
        $this->load->view('master/product_master/vw_product_master_edit',$data);
    }

    public function get_product_master_data(){
        $entity_id = $this->input->post('entity_id',TRUE);
        $data = $this->product_master_model->get_id_wise_product_master($entity_id);
        echo json_encode([$data]);
    }

    public function get_product_master_sub_category(){
        $entity_id = $this->input->post('entity_id',TRUE);
        $data = $this->product_master_model->get_id_wise_product_wise_sub_category($entity_id)->result();
        echo json_encode($data);
    }

    public function update_product_master()
    {
        $entity_id = $this->input->post('entity_id');
        $product_id = $this->input->post('product_id');
        $product_name = $this->input->post('product_name');
        $product_long_desc = $this->input->post('product_long_desc');
        $product_warranty = $this->input->post('product_warranty');
        $category_id = $this->input->post('category_id');
        $product_unit = $this->input->post('product_unit');
        $product_price = $this->input->post('product_price');
        $hsn_code = $this->input->post('hsn_code');
        $product_status = $this->input->post('product_status'); 
        $product_make = $this->input->post('product_make');
        $internal_remark = $this->input->post('internal_remark');   

        $data = array('entity_id'=> $entity_id , 'product_id' => $product_id , 'product_name' => $product_name , 'category_id' => $category_id , 'product_make' => $product_make , 'internal_remark' => $internal_remark , 'product_long_description' => $product_long_desc , 'warrenty' => $product_warranty , 'unit' => $product_unit  , 'hsn_id' => $hsn_code , 'status' => $product_status);

        $result = $this->product_master_model->update_product_master_model($data,$product_price,$entity_id);
        redirect('product_master');
    }

    public function delete_product_master()
    {
        $entity_id = $this->uri->segment(2);
        $data = $this->product_master_model->delete_product_master($entity_id);
        redirect('product_master');
    }

    public function view_product_master()
    {
        $entity_id = $this->uri->segment(2);
        $data['entity_id'] = $entity_id;
        $data['product_hsn_code'] = $this->product_master_model->get_product_hsn_code();
        $data['product_category'] = $this->product_master_model->get_product_category();
        $data['unit_list'] = $this->product_master_model->get_unit_list();
        $data['make_list'] = $this->product_master_model->get_make_list();
        $this->load->view('master/product_master/vw_product_master_view',$data);
    }

    public function product_id_check()
    {
        $data = $this->input->post();
        if(!empty($data))
        {
            $product_id = $this->input->post('id');
            $data = $this->product_master_model->product_id_check_model($product_id);
            if($data == 'true')
            {
                print_r($data);
                die();
            }
        }
    }
}
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_sub_category_master extends CI_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('product_sub_category_master_model');
        $this->load->library('session');
    }

	public function index()
	{
        $data['product_sub_category'] = $this->product_sub_category_master_model->get_product_sub_category_details();
		$this->load->view('master/product_sub_category_master/vw_product_sub_category_master_index',$data);
	}

    public function create()
    {
        $data['product_category'] = $this->product_sub_category_master_model->get_product_category();
        $this->load->view('master/product_sub_category_master/vw_product_sub_category_master_create',$data);
    }

    public function save_product_sub_category_master()
    {
        $category_id = $this->input->post('category_id');
        $sub_category_name = $this->input->post('sub_category_name');
        $sub_category_initials = $this->input->post('sub_category_initials');
        
        $data = array('category_id ' => $category_id , 'subcategory_name' => $sub_category_name ,'subcategory_initial' => $sub_category_initials);
        $result = $this->product_sub_category_master_model->save_product_sub_category_master_model($data);
        redirect('product_sub_category');
    }

    public function edit_product_sub_category()
    {
        $entity_id = $this->uri->segment(2);
        $data['entity_id'] = $entity_id;
        $data['product_category'] = $this->product_sub_category_master_model->get_product_category();
        $this->load->view('master/product_sub_category_master/vw_product_sub_category_master_edit',$data);
    }

    public function get_product_sub_category_master_data(){
        $entity_id = $this->input->post('entity_id',TRUE);
        $data = $this->product_sub_category_master_model->get_id_wise_product_sub_category($entity_id)->result();
        echo json_encode($data);
    }

    public function update_product_sub_category_master()
    {
        $entity_id = $this->input->post('entity_id');
        $category_id = $this->input->post('category_id');
        $sub_category_name = $this->input->post('sub_category_name'); 
        $sub_category_initials = $this->input->post('sub_category_initials');       

        $data = array('entity_id'=> $entity_id , 'category_id ' => $category_id , 'subcategory_name' => $sub_category_name , 'subcategory_initial' => $sub_category_initials);

        $result = $this->product_sub_category_master_model->update_product_sub_category_master_model($data);
        redirect('product_sub_category');
    }

    public function delete_product_sub_category()
    {
        $entity_id = $this->uri->segment(2);
        $data = $this->product_sub_category_master_model->delete_product_sub_category($entity_id);
        redirect('product_sub_category');
    }

    public function view_product_sub_category()
    {
        $entity_id = $this->uri->segment(2);
        $data['entity_id'] = $entity_id;
        $data['product_category'] = $this->product_sub_category_master_model->get_product_category();
        $this->load->view('master/product_sub_category_master/vw_product_sub_category_master_view',$data);
    }
}
?>
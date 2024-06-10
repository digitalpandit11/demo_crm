<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class Offer_datatable_model extends CI_Model
{ 

  var $table = "offer_working_index";
  var $select_column = array(
    "entity_id", 
    "offer_no", 
    "offer_date", 
    // "enquiry_no", 
    "customer_name", 
    "contact_person", 
    "first_contact_no", 
    "email_id", 
    "emp_first_name", 
    "source_name", 
    "offer_status", 
    "total_amount_with_gst"
  );
  var $order_column = array(
    "entity_id", 
    "offer_no", 
    "offer_date", 
    // "enquiry_no", 
    "customer_name", 
    "contact_person", 
    "first_contact_no", 
    "email_id", 
    "emp_first_name", 
    "source_name", 
    "offer_status", 
    "total_amount_with_gst"
  );
 
  function make_query(){

    $this->db->select($this->select_column);
    $this->db->from($this->table);
    if(isset($_POST["search"]["value"]))
    {
      $this->db->like("offer_no", $_POST["search"]["value"]);
      $this->db->or_like("customer_name", $_POST["search"]["value"]);
      $this->db->or_like("source_name", $_POST["search"]["value"]);
      $this->db->or_like("email_id", $_POST["search"]["value"]);
      $this->db->or_like("emp_first_name", $_POST["search"]["value"]);
      $this->db->or_like("status", $_POST["search"]["value"]);
      $this->db->or_like("offer_status", $_POST["search"]["value"]);
    }

    if(isset($_POST["order"]))
    {
      $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    }
    else
    {
      $this->db->order_by("entity_id", "DESC");
    }

  }

  function make_datatables()
  {
    $this->make_query();
    if($_POST["length"] != -1)
    {
      $this->db->limit($_POST["length"], $_POST["start"]);
    }
    $query = $this->db->get();
    return $query->result();
  }

  function get_filtered_data()
  {
    $this->make_query();
    $query = $this->db->get();
    return $query->num_rows();
  }

  function get_all_data()
  {
    $this->db->select("*");
    $this->db->from($this->table);
    return $this->db->count_all_results();
  }
}

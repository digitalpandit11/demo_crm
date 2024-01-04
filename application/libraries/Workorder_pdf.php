<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH."/third_party/tcpdf/tcpdf.php"; 
class Workorder_pdf extends TCPDF { 
    public function __construct() { 
        parent::__construct(); 
    } 

    //Page header
    public function Header() {


            $path_img = getcwd();
            
            $sai_logo = $path_img."/assets/login/sailogo.png";
            $sai_address = $path_img."/assets/login/sai_address.png";
            
        // Logo
           
            // Title
            $html = '<table border="0.3"  width="100%">
                           <tr>
                              <th style="width: 70%;"><img src="'.strip_tags($sai_logo).'" style="height: 50px; width: 50px;">
                              </th>

                              <th style="width: 30%;"><img src="'.strip_tags($sai_address).'" style="height: 50px; width: 140px;">
                              </th>
                             
                           </tr>
                           <table>
                           <hr style="width: 100%;height: 1px;"></p>
            		 ';

            $this->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
    }

    public function Footer() {
    	

	}
}
?>
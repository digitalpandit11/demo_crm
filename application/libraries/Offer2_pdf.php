<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . "/third_party/TCPDF-6.6.2/tcpdf.php";

class Offer2_pdf extends TCPDF
{
    public function __construct()
    {
        parent::__construct();
    }

    // public function Header()
    // {
    //     // Set font
    //     $this->SetFont('helvetica', '', 7.5);

    //    // Header content
    //    $html = '<img src="' . base_url() . 'assets/company_logo/intact_header.jpg" width:"800" >';

    //     // Write HTML content
    //     // $this->writeHTML($html, true, false, true, false, 'left');
	// 	$this->Cell(0, 10, '', 0, false, $html, 0, '', 0, false, 'T', 'M');
	// 	$this->SetXY(110, 200);
	// 	$this->Image(base_url().'assets/company_logo/intact_header.jpg', '', '', 40, 40, '', '', 'T', false, 300, '', false, false, 1, false, false, false);
	// 	// $this->Image('images/image_demo.jpg', '', '', 40, 40, '', '', '', false, 300, '', false, false, 1, false, false, false);
    // }

	public function Header() {
        $this->SetY(20);
        $path_img = base_url();
        $header_data = $this->getHeaderData();
        $trusted_img = $path_img."assets/company_logo/intact_header.png";
        $style = array('width' => 50, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(169, 169, 169));
        $this->SetLineStyle($style,$ret = false);
        $this->SetFont('helvetica', 'B', 10);
        // $this->Cell(0, 10, '', 0, true, 'C', 0, '', 0, false, 'M', 'M');
        $this->Image($trusted_img, 0, 0, 210, 25.5, 'png', '', '', true, 300, '', false, false, 0, false, false, false);
        // $this->Cell(0, 20, 'TAX INVOICE', 0, false, 'C', 0, '', 0, false, 'M', 'M');
            
    }

    // public function Footer()
    // {
    //     // Position at 15 mm from bottom
    //     $this->SetY(-15);
    //     // Set font
    //     $this->SetFont('helvetica', 'I', 8);
    //     // Page number
    //     $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    // }

	public function Footer() 
    {
        // $this->SetY(-85);
        // Set font 
        $this->SetFont('helvetica', '' , 10);

        $serverpath = base_url();

         $path_img = getcwd();
         
        $trusted_img_footer = $serverpath."assets/company_logo/intact_footer.png";
        // echo'<pre>';
        //  print_r($trusted_img_footer);
        //  die();
        $this->Image($trusted_img_footer, 0, 252, 210, "", "PNG", "", "T", false, 300, "", false, false, -0, false, false, false);
        /*$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 'T', false, 'R');*/
    }
}
?>

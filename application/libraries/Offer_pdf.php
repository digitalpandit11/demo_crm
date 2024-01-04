<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH."/third_party/TCPDF-6.6.2/tcpdf.php"; 
class Offer_pdf extends TCPDF { 
    public function __construct() { 
        parent::__construct(); 
    } 

    public function Header() 
    { 
        $this->SetFont('helvetica', '', 4);
        $html = '<h3 style="text-indent:5em; margin-top: 50px;  text-align: right; font-color:"#D3D3D3";">BBCPL-MKT-F-02</h3>
                 ';

        $this->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        
        //// Shreemat
        $image_file = K_PATH_IMAGES.'bbcpl_logo.png';
        $this->Image($image_file, 20, 20, 55, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        
        // Title
        /*$this->SetFont('helvetica', '', 5);
        $html = '<h3 style="text-indent:5em; margin-top: 50px; ">Registered Office</h3>';*/
        $this->SetFont('helvetica', 'B', 17);
        $html = '<h3 style="text-indent:5em; margin-top: 50px;">BluBoxx Communication Pvt. Ltd.</h3>
                 ';

        $this->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

        $this->SetFont('dejavusans', '' , 6.5);
        // Title
        $html = '<p style="text-indent:35em;"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (An ISO 9001:2015 Certified Company) <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 102/B, Surekha Apartment, Pune Satara Road, Pune- 411037, Maharashtra, India. <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; M- +91 7875432180 , EMAIL :- sales@bbcpl.in , Website : <a href = "https://www.bbcpl.in">www.bbcpl.in</a><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; GST NO : 27AAGCB6960P1ZZ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CIN No : U74999PN2016PTC164320 </b><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
            <hr style="width: 100%;height: 1.5px;"></p>';

        $this->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

    }

    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

?>
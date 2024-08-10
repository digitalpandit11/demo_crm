<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . "/third_party/TCPDF-6.6.2/tcpdf.php";

class Offer2_pdf extends TCPDF
{
    public function __construct()
    {
        parent::__construct();
    }

    public function Header()
    {
        // Set font
        $this->SetFont('helvetica', '', 7.5);

       // Header content
       $html = '<table style="width:100%;"><tr><td style="width:70%; vertical-align:top;"><br><br><h1 style="color:#3167ac;font-size:18px;  line-height: 20%; ">Intact Automation Pvt. Ltd</h1><br style="font-size:8px;  color:#6b7280;line-height:70%;">Shiv Shankar House, S. No.43 Near Xrbia,
       <br style="font-size:8px; color:#6b7280; line-height:90%; ">Hinjewadi Somatane Road, Mulshi, Nere,<br style="font-size:8px;  color:#6b7280; line-height:90%; ">Pune, Maharashtra 411033.<br style="font-size:8px;  color:#6b7280;line-height:90%; ">(020)-6744-1111</td><td style="width:30%;  vertical-align:bottom; margin-top: 55px; text-align:right;"><br style="font-size:8px;  color:#6b7280;line-height:90%; "><img src="' . base_url() . 'assets/company_logo/intact_new_logo.png"  width="150"></td></tr></table>
       <hr style="width: 100%;color:#3167ac; height: 3px; margin-top: 10px;">';

        // Write HTML content
        $this->writeHTML($html, true, false, true, false, '');
    }

    public function Footer()
    {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}
?>

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
       $html = '<table style="width:100%;"><tr><td style="width:50%;"><h1 style="text-indent:1em;color:#3a4494;font-size:18px; margin-top: 50px;">Intact Automation Pvt. Ltd</h1><p style="text-indent:1em;"><b> Shankar House, S. No.43 Near Xrbia,
       <br> Hinjewadi Somatane Road, Mulshi, Nere,<br> Pune, Maharashtra 411033.<br>(020)-6744-1111</b></p></td><td style="width:50%; text-align:right;"><img src="' . base_url() . 'assets/company_logo/intact_logo.png"  height="40"></td></tr></table>
       <br><hr style="width: 100%;color:#3a4494; height: 4px;">';

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

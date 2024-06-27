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
       $html = '<table style="width:100%;"><tr><td style="width:50%;"><h1 style="text-indent:1em;color:#3167ac;font-size:18px; margin-top: 50px; margin-bottom: 80px;line-height: 20%;">Intact Automation Pvt. Ltd</h1><br style="font-size:8px;  color:#6b7280;line-height:90%;text-indent:1em;">Shiv Shankar House, S. No.43 Near Xrbia,
       <br style="font-size:8px; color:#6b7280; line-height:90%; text-indent:1em;">Hinjewadi Somatane Road, Mulshi, Nere,<br style="font-size:8px;  color:#6b7280; line-height:90%; text-indent:1em;">Pune, Maharashtra 411033.<br style="font-size:8px;  color:#6b7280;line-height:90%; text-indent:1em;">(020)-6744-1111<br  style="font-size:8px; line-height:50%;"></td><td style="width:50%; text-align:right;"><img src="' . base_url() . 'assets/company_logo/intact_logo_june2024_r1.png"  height="40"></td></tr></table>
       <hr style="width: 100%;color:#3167ac; height: 3px; margin-top: 20px;">';

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

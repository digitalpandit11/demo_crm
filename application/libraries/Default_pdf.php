<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH."/third_party/tcpdf/tcpdf.php"; 
class Default_pdf extends TCPDF { 
    public function __construct() { 
        parent::__construct(); 
    }

    public function Footer() {
    	$this->SetY(-55);
    	$this->SetFont('helvetica', '' , 10);

    $html = '<table border="1" cellpadding="3" width="100%">
                    <tr style="line-height:15px;">
                      <td style="font-size: 7px; width: 60%;">I Authorise to execute the jobs described in the Job Card abive using the necessary material at my cost. I understand that the vehicle is being stored ,repaired and tested at my risk.<br>
                          Terms & Conditions mentioned on this page and overleaf are accepted by me/us.<br><br><br>

                          <b>Date & Time &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Customer Sign</b></td>
                      <td style="font-size: 7px; width: 40%;">I certify that the work has been done to my satisfaction and I have taken the delivery of the vehicle.</td>
                      
                     </tr>

                </table>'; 
 

    $this->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
    $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 'T', false, 'R');

	} 
}
?>
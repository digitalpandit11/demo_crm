<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH."/third_party/tcpdf/tcpdf.php"; 
class Pdf extends TCPDF { 
    public function __construct() { 
        parent::__construct(); 
    } 

    //Page header
    public function Header() {
        // Logo
          $location_id = $_SESSION['location_id'];
          if($location_id == 1) { 
            $image_file = K_PATH_IMAGES.'shree_logo.png';
            $this->Image($image_file, 20, 15, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            // Set font
            $this->SetFont('helvetica', 'B', 17);
            // Title
            $html = '<h3 style="text-indent:5em; margin-top: 50px;">SHREEMAT CAR CARE</h3>
            		 ';

            $this->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

            $this->SetFont('helvetica', '' , 8);
            // Title
            $html = '<p style="text-indent:35em;"><b>Survey No. 655/9, Bibwewadi Kondwa Road, Kondhwa, Pune - 411037</b><br><br>
            	<hr style="width: 100%;height: 1.5px;"></p>
            		 ';

            $this->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
          }elseif($location_id == 2){

                /// Shree Samarth
                $image_file = K_PATH_IMAGES.'shree_auto.png';
                $this->Image($image_file, 20, 15, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                // Set font
                $this->SetFont('helvetica', 'B', 17);
                // Title
                $html = '<h3 style="text-indent:5em; margin-top: 50px;">Shree Auto Care</h3>
                     ';
                     //Shelarmala, Near, Katraj, Pune, Maharashtra 411046
                $this->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

                $this->SetFont('helvetica', '' , 8);
                // Title
                $html = '<p style="text-indent:35em;"><b>Shelarmala, Near, Katraj, Pune, Maharashtra 411046</b><br><br>
                  <hr style="width: 100%;height: 1.5px;"></p>
                     ';

                $this->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
          }

    }

    public function Footer() {
    	$this->SetY(-60);
    	$this->SetFont('helvetica', '' , 10);

    $html = '<br><br><br><table style="width:100%; border-collapse: collapse;
  border: 1px solid black;">
            <tbody>
              <tr style="line-height: 20px;">
                   <td width="25%" style="font-size: 7px; border-bottom: 1px solid black; border-right: solid 1px #000000; 
  border-left: solid 1px #000000; text-align: center;"><b><br><br><br><br><br><br>Store Incharge</b></td>

                   <td width="25%" style="font-size: 7px; border-bottom: 1px solid black; border-right: solid 1px #000000; 
  border-left: solid 1px #000000; text-align: center;"><b><br><br><br><br><br><br>Passed By</b></td>

                  <td width="25%" style="font-size: 7px; border-bottom: 1px solid black; border-right: solid 1px #000000; 
  border-left: solid 1px #000000; text-align: center;"><b><br><br><br><br><br><br>Approved By</b></td>

  <td width="25%" style="font-size: 7px; border-bottom: 1px solid black; border-right: solid 1px #000000; 
  border-left: solid 1px #000000; text-align: center;"><b><br><br><br><br><br><br>Accepted By</b></td>





              </tr></tbody>
      </table>
                                  '; 
 

    $this->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
    $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 'T', false, 'R');

	}
}
?>
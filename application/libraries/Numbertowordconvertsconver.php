<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');
class numbertowordconvertsconver {
	/*function convert_number($number) {
		if (($number < 0) || ($number > 999999999)) {
			throw new Exception("Number is out of range");
		}
		$giga = floor($number / 1000000);
		// Millions (giga)
		$number -= $giga * 1000000;
		$kilo = floor($number / 1000);
		// Thousands (kilo)
		$number -= $kilo * 1000;
		$hecto = floor($number / 100);
		// Hundreds (hecto)
		$number -= $hecto * 100;
		$deca = floor($number / 10);
		// Tens (deca)
		$n = $number % 10;
		// Ones
		$result = "";
		if ($giga) {
			$result .= $this->convert_number($giga) .  "Million";
		}
		if ($kilo) {
			$result .= (empty($result) ? "" : " ") .$this->convert_number($kilo) . " Thousand";
		}
		if ($hecto) {
			$result .= (empty($result) ? "" : " ") .$this->convert_number($hecto) . " Hundred";
		}
		$ones = array("", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", "Nineteen");
		$tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", "Seventy", "Eigthy", "Ninety");
		if ($deca || $n) {
			if (!empty($result)) {
				$result .= " and ";
			}
			if ($deca < 2) {
				$result .= $ones[$deca * 10 + $n];
			} else {
				$result .= $tens[$deca];
				if ($n) {
					$result .= "-" . $ones[$n];
				}
			}
		}
		if (empty($result)) {
			$result = "zero";
		}
		return $result;
	}*/

	function convert_number($amount)
	{

	    $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
	    // Check if there is any number after decimal
	    $amt_hundred = null;
	    $count_length = strlen($num);
	    $x = 0;
	    $string = array();
	    $change_words = array(0 => '', 1 => 'One', 2 => 'Two',
	       3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
	       7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
	       10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
	       13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
	       16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
	       19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
	       40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
	       70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
	    $here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
	    while( $x < $count_length ) {
	      $get_divider = ($x == 2) ? 10 : 100;
	      $amount = floor($num % $get_divider);
	      $num = floor($num / $get_divider);
	      $x += $get_divider == 10 ? 1 : 2;
	      if ($amount) {
	       $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
	       $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
	       $string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.' 
	       '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. ' 
	       '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
	        }
	   else $string[] = null;
	   }
	   $implode_to_Rupees = implode('', array_reverse($string));
	   $get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
	   " . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';
	   return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise;
	}
}
?>
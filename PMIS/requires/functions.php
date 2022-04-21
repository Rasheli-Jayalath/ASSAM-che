<?php
function monthDropdown($name="txtmonth", $selected)
{
        $dd = '<select name="'.$name.'" id="'.$name.'" style="width:150px">';
         $dd.='<option value="" selected="selected">Month</option>';
        /*** the current month ***/
        $selected = is_null($selected) ? date('n', time()) : $selected;

        for ($i = 1; $i <= 12; $i++)
        {
                $dd .= '<option value="'.$i.'"';
                if ($i == $selected)
                {
                        $dd .= ' selected';
                }
                /*** get the month ***/
                $mon = date("F", @mktime(0, 0, 0, $i+1, 0, 0, 0));
                $dd .= '>'.$mon.'</option>';
        }
        $dd .= '</select>';
        return $dd;
}	
function setSession($uid)
{
$objDb  = new Database( );	
	$sSQL = "SELECT * FROM payroll.users WHERE uid=$uid";
	$objDb->query($sSQL);
	$iCount = $objDb->getCount();
	$status = $objDb->getField(0, status);
	if($iCount==1 && $status==1)
	{
		$_SESSION['uname']				= $objDb->getField(0, uname);
		$_SESSION['admflag']			= $objDb->getField(0, admflag);
		$_SESSION['superadmflag']		= $objDb->getField(0, superadmflag);
		$_SESSION['payrollflag']		= $objDb->getField(0, payrollflag);///Is Payroll module allowed (0 or 1)
		
		////Petrol Module
		$_SESSION['petrolflag']			= $objDb->getField(0, petrolflag);///Is petrol view module allowed (0 or 1)
		$_SESSION['petrolEntry']		= $objDb->getField(0, petrolEntry);///Is petrol entry module allowed (0 or 1)
		$_SESSION['petrolVerify']		= $objDb->getField(0, petrolReview);///Is petrol verify module allowed (0 or 1)
		$_SESSION['petrolApproval']		= $objDb->getField(0, petrolApproval);///Is petrol approval module allowed (0 or 1)
		$_SESSION['petrolPayment']		= $objDb->getField(0, petrolPayment);///Is petrol payment(pending, paid) module allowed()(0 or 1)
		////Mobile Module
		$_SESSION['mobileflag']			= $objDb->getField(0, mobileflag);///Is mobile view module allowed (0 or 1)
		$_SESSION['mobileEntry']		= $objDb->getField(0, mobileEntry);///Is mobile entry module allowed (0 or 1)
		$_SESSION['mobileVerify']		= $objDb->getField(0, mobileReview);///Is mobile verify module allowed (0 or 1)
		$_SESSION['mobileApproval']		= $objDb->getField(0, mobileApproval);///Is mobile approval module allowed (0 or 1)
		$_SESSION['mobilePayment']		= $objDb->getField(0, mobilePayment);///Is mobile payment(pending, paid) module allowed()(0 or 1)
		////Deduction Module
		$_SESSION['deductionflag']		= $objDb->getField(0, deductionflag);///Is deduction view module allowed (0 or 1)
		$_SESSION['deductionEntry']		= $objDb->getField(0, deductionEntry);///Is deduction entry module allowed (0 or 1)
		$_SESSION['deductionVerify']	= $objDb->getField(0, deductionReview);///Is deduction verify module allowed (0 or 1)
		$_SESSION['deductionApproval']	= $objDb->getField(0, deductionApproval);///Is deduction approval module allowed (0 or 1)
		$_SESSION['deductionPayment']	= $objDb->getField(0, deductionPayment);///Is deduction payment(pending, paid) module allowed()(0 or 1)
		////Tax Module
		$_SESSION['taxflag']			= $objDb->getField(0, taxflag);///Is tax view module allowed (0 or 1)
		$_SESSION['taxEntry']			= $objDb->getField(0, taxEntry);///Is tax entry module allowed (0 or 1)
		$_SESSION['taxVerify']			= $objDb->getField(0, taxReview);///Is tax verify module allowed (0 or 1)
		$_SESSION['taxApproval']		= $objDb->getField(0, taxApproval);///Is tax approval module allowed (0 or 1)
		$_SESSION['taxPayment']			= $objDb->getField(0, taxPayment);///Is tax payment(pending, paid) module allowed()(0 or 1)
		////Allowance Module
		$_SESSION['allowanceflag']		= $objDb->getField(0, allowanceflag);///Is allowance view module allowed (0 or 1)
		$_SESSION['allowanceEntry']		= $objDb->getField(0, allowanceEntry);///Is allowance entry module allowed (0 or 1)
		$_SESSION['allowanceVerify']	= $objDb->getField(0, allowanceReview);///Is allowance verify module allowed (0 or 1)
		$_SESSION['allowanceApproval']	= $objDb->getField(0, allowanceApproval);///Is allowance approval module allowed (0 or 1)
		$_SESSION['allowancePayment']	= $objDb->getField(0, allowancePayment);///Is allowance payment(pending, paid) module allowed()(0 or 1)
		////Medical Module
		$_SESSION['medicalflag']		= $objDb->getField(0, medicalflag);///Is medical view module allowed (0 or 1)
		$_SESSION['medicalEntry']		= $objDb->getField(0, medicalEntry);///Is medical entry module allowed (0 or 1)
		$_SESSION['medicalVerify']		= $objDb->getField(0, medicalReview);///Is medical verify module allowed (0 or 1)
		$_SESSION['medicalApproval']	= $objDb->getField(0, medicalApproval);///Is medical approval module allowed (0 or 1)
		$_SESSION['medicalPayment']		= $objDb->getField(0, medicalPayment);///Is medical payment(pending, paid) module allowed()(0 or 1)
		////Gratuity Module
		$_SESSION['gratuityflag']		= $objDb->getField(0, gratuityflag);///Is gratuity view module allowed (0 or 1)
		$_SESSION['gratuityEntry']		= $objDb->getField(0, gratuityEntry);///Is gratuity entry module allowed (0 or 1)
		$_SESSION['gratuityVerify']		= $objDb->getField(0, gratuityReview);///Is gratuity verify module allowed (0 or 1)
		$_SESSION['gratuityApproval']	= $objDb->getField(0, gratuityApproval);///Is gratuity approval module allowed (0 or 1)
		$_SESSION['gratuityPayment']	= $objDb->getField(0, gratuityPayment);///Is gratuity payment(pending, paid) module allowed()(0 or 1)
		////Leave Encashment Module
		$_SESSION['leave_encashmentflag']		= $objDb->getField(0, leave_encashmentflag);///Is leave_encashment view module allowed (0 or 1)
		$_SESSION['leave_encashmentEntry']		= $objDb->getField(0, leave_encashmentEntry);///Is leave_encashment entry module allowed (0 or 1)
		$_SESSION['leave_encashmentVerify']		= $objDb->getField(0, leave_encashmentReview);///Is leave_encashment verify module allowed (0 or 1)
		$_SESSION['leave_encashmentApproval']	= $objDb->getField(0, leave_encashmentApproval);///Is leave_encashment approval module allowed (0 or 1)
		$_SESSION['leave_encashmentPayment']	= $objDb->getField(0, leave_encashmentPayment);///Is leave_encashment payment(pending, paid) module allowed()(0 or 1)
	}

	$objDb  -> close( );
}
?>

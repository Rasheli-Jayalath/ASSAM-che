// JavaScript Document
function validate_each(field,txtmsg)
{
	with(field)
	{
		if(value==null || value=="")
		{
			alert(txtmsg);
			return false;
		}
		else
		{
			return true;
		}
	}
}
function email_validate(field,txtmsg)
{
	with(field)
		{
			var apos=value.indexOf("@")
			var dotpos=value.indexOf(".")
			if(value==null || value=="")
			{
				alert(txtmsg);
				return false;
			}
			else
			{
				//if(apos<1 || dotpos-apos<2)
				if(apos<1)

					{
						alert("Your Email Address is not valid"); return false;
					}
					else
					{
						return true;
					}
			}
		}
}

function personalinfo(thisform)
{
	with(thisform)
	{
		if(validate_each(txtname,"Please enter the name")==false)
			{txtname.focus();return false;}
		if(validate_each(txtposition,"Please Enter Proposed Position")==false)
			{txtposition.focus();return false;}
		if(email_validate(txtemail,"Please enter Email Address")==false)
			{txtemail.focus();return false;}
		if(validate_each(cmbcitizen,"Please select Citizenship")==false)
			{cmbcitizen.focus();return false;}
		if(validate_each(cmbnationality,"Please select Nationality")==false)
			{cmbnationality.focus();return false;}
		if(validate_each(txtlocation,"Please enter Location(City)")==false)
			{txtlocation.focus();return false;}
		if(validate_each(txtstartexpyr,"Please enter Starting Experience Year")==false)
			{txtstartexpyr.focus();return false;}
		if(validate_each(cmbnationality,"Please enter Place of Birth/Nationality")==false)
			{cmbnationality.focus();return false;}
 	}
}



function firminfo(thisform)
{
	 var thisform = document.frmfirminfo; 
	with(thisform)
	{
		if(validate_each(txtyearswithfirm,"Please enter the total duration with the firm")==false)
			{txtyearswithfirm.focus();return false;}
		if(validate_each(txtfirmname,"Please enter the Firm name")==false)
			{txtfirmname.focus();return false;}
		if(validate_each(txtdesignation,"Please enter the Designation")==false)
			{txtdesignation.focus();return false;}
	}
}

function eduInfo(thisform)
{
	var thisform = document.frmEduInfo;
	with(thisform)
	{
		if(validate_each(txtDate,"Please enter the Degree Completion Date")==false)
			{txtDate.focus();return false;}
		if(validate_each(txtDtitle,"Please enter the Degree Title")==false)
			{txtDtitle.focus();return false;}
		if(validate_each(txtInstitute,"Please the enter the Institute Name")==false)
			{txtInstitute.focus();return false;}
		if(validate_each(txtLocation,"Please the enter the Location")==false)
			{txtLocation.focus();return false;}
		if(validate_each(txtCountry,"Please the select the Country")==false)
			{txtCountry.focus();return false;}
		if(validate_each(txtSpecialization,"Please enter the Specialization")==false)
			{txtSpecialization.focus();return false;}
	}
}

function OtherTraining()
{   
    var thisform = document.frmOtherTraining;
	
	with(thisform)
	{
		if(validate_each(txtDescription,"Please enter the Description")==false)
			{txtDescription.focus();return false;}
	}
}
function Achievement()
{
    var thisform = document.frmAchievement; 
	
	with(thisform)
	{
		if(validate_each(txtDescription,"Please enter the Description")==false)
			{txtDescription.focus();return false;}
		
	}
}
function empInfo(thisform)
{
	var thisform = document.frmempInfo;
//	"Start Date: = "+document.write(txtStartDate)+"/";
//	"Employer: = "+document.write(txtEmployeer)+"/";
//	"Position: = "+document.write(txtPosition)+"/";
//	"Project Name: = "+document.write(txtPName)+"/";
//	"Country: = "+document.write(txtCountry)+"/";
//	"Duty: = "+document.write(txtDutyPerform)+"/";
							
	with(thisform)
	{
		if(validate_each(txtStartDate,"Please enter the Start Date")==false)
			{txtStartDate.focus();return false;}
		/*if(validate_each(txtLastDate,"Please enter the End Date")==false)
			{txtLastDate.focus();return false;}*/
		if(validate_each(txtEmployeer,"Please enter the Employer Name")==false)
			{txtEmployeer.focus();return false;}
		if(validate_each(txtPosition,"Please enter the Position")==false)
			{txtPosition.focus();return false;}
/*		if(validate_each(txtPName,"Please enter the Project Name")==false)
			{txtPName.focus();return false;}*/
		if(validate_each(txtCountry,"Please select the Country")==false)
			{txtCountry.focus();return false;}
		/*if(validate_each(txtLocation,"Please enter the Location")==false)
			{txtLocation.focus();return false;}
		
		if(validate_each(txtClient,"Please enter the Client Name")==false)
			{txtClient.focus();return false;}
		if(validate_each(txtPDesc,"Please enter the Project Description")==false)
			{txtPDesc.focus();return false;}
		if(validate_each(txtDutyPerform,"Please enter the Duties Performed")==false)
			{txtDutyPerform.focus();return false;}*/
	}
}

function language()
{
	if(document.frmlang.txtlanguage.value=="" )
		{ 
			alert("Please Select any language.");
			document.frmlang.txtlanguage.focus();
			return false;
		}
	
}

function mop()
{
		if(document.frmmop.txtmop.value=="" && document.frmmop.txtsociety.value==""  )
		{ 
			alert("Please Data in any field.");
			document.frmmop.txtmop.focus();
			return false;
		}
	
}


function validateSearch()
{
	var frm=document.searchfrm; 
	if(frm.txtid.value=="" && frm.txtname.value=="" && frm.gender.value=="" && frm.years.value=="" && frm.totalyears.value=="" && frm.txtgeneral.value=="" && frm.txtpq.value=="" && frm.txtpost.value=="" && frm.txtlocation.value=="" && frm.txtCountry.value=="" && frm.txtAreaOfExpert.value=="" && frm.txtkeyqualification.value=="" && frm.workExpCountries.value=="" )
	{
		alert("Enter data in any field to search required CVs");
		return false;
	}
	else
	{
	frm.submit();
	}
}

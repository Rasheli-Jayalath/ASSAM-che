<?
error_reporting(E_ALL & ~E_NOTICE);
    /* A PHP class to parse Forms/URL Values with convenient Methods
    *
    * @version  1.0
    * @author   Muhammad Tahir Shahzad
    */

	class IO
	{
		function IO( )
		{

		}

		function getValue($sField, $sType = "string")
		{
			$sValue = trim($_REQUEST[$sField]);

			switch($sType)
			{
				case "string" :  return ((get_magic_quotes_gpc( )) ? trim($sValue) : trim(addslashes($_REQUEST[$sField])));

				case "int"    :  return intval($sValue);

				case "float"  :  return floatval($sValue);
			}
		}

		function intValue($sField)
		{
			return intval(trim($_REQUEST[$sField]));
		}


		function strValue($sField)
		{
			if (get_magic_quotes_gpc( ))
				return trim($_REQUEST[$sField]);

			else
				return trim(addslashes($_REQUEST[$sField]));
		}


		function floatValue($sField)
		{
			return floatval(trim($_REQUEST[$sField]));
		}


		function getFormValue($sField)
		{
			$sValue = trim($_REQUEST[$sField]);

			$sValue = str_replace("\r\n", "\n", $sValue);
			$sValue = stripslashes($sValue);

			return $sValue;
		}

		function getFileName($sFile)
		{
			$sValue = @basename($sFile);
			$sValue = @trim($sValue);
			$sValue = @strtolower($sValue);
			$sValue = @stripslashes($sValue);
			$sValue = @str_replace(" ", "-", $sValue);
			$sValue = @str_replace("_", "-", $sValue);

			$sValidChars = "abcdefghijklmnopqrstuvwxyz0123456789-.";
			$iLength     = @strlen($sValue);
			$sFileName   = "";

			for ($i = 0; $i < $iLength; $i ++)
			{
				if (@strstr($sValidChars, $sValue{$i}))
					$sFileName .= $sValue{$i};
			}

			return $sFileName;
		}
	}
?>
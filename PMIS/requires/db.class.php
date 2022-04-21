<?
error_reporting(E_ALL & ~E_NOTICE);
    /* A PHP class to access MySQL Database with convenient Methods
    *
    * @version  1.0
    * @author   Muhammad Tahir Shahzad
    */

	class Database
	{
		var $sServer;
		var $sDatabase;
		var $sUserName;
		var $sPassword;

		var $dbConnection;
		var $dbResultSet;

		var $iCount;
		var $iFieldsCount;
		var $iAutoNumber;
		var $sError;

		function Database( )
		{
			$this->sServer   = DB_SERVER;
			$this->sDatabase = DB_NAME;
			$this->sUserName = DB_USER;
			$this->sPassword = DB_PASSWORD;

			$this->dbConnection = NULL;
			$this->dbResultSet = NULL;

			$this->iCount = 0;
			$this->iAutoNumber = 0;
			$this->sError = NULL;

			if (!$this->dbConnection)
				$this->connect( );
				mysql_set_charset("utf8");
		}

		function connect( )
		{
			$this->dbConnection = @mysql_connect($this->sServer, $this->sUserName, $this->sPassword);
			if (!$this->dbConnection)
			{
  				print "Error: Unable to connect to the database Server.";
  				exit( );
			}
			if (!@mysql_select_db($this->sDatabase, $this->dbConnection))
			{
				print "Error: Unable to locate the Database.";
  				exit( );
			}
		}

		function query($sQuery)
		{
			@mysql_free_result($this->dbResultSet);

			$this->dbResultSet = @mysql_query($sQuery, $this->dbConnection);

			if (!$this->dbResultSet)
			{
				$this->sError = mysql_error( );

				return false;
			}

			else
			{
				$this->iCount       = @mysql_num_rows($this->dbResultSet);
				$this->iFieldsCount = @mysql_num_fields($this->dbResultSet);

				return true;
			}
		}


		function getCount( )
		{
			return $this->iCount;
		}


		function getFieldsCount( )
		{
			return $this->iFieldsCount;
		}


		function getAutoNumber( )
		{
			return $this->iAutoNumber;
		}


		function getFieldName($iIndex)
		{
			return @mysql_field_name($this->dbResultSet, $iIndex);
		}

		function getFieldType($iIndex)
		{
			return @mysql_field_type($this->dbResultSet, $iIndex);
		}

		function getField($iIndex, $sField)
		{
			return @mysql_result($this->dbResultSet, $iIndex, $sField);
		}


		function execute($sQuery)
		{
			@mysql_free_result($this->dbResultSet);

			if (!@mysql_query($sQuery, $this->dbConnection))
			{
				$this->sError = @mysql_error( );

				return false;
			}

			else
			{
				$this->iAutoNumber = @mysql_insert_id( );
			}

			return true;
		}


		function close( )
		{
			@mysql_free_result($this->dbResultSet);
			@mysql_close($this->dbConnection);
		}


		function error( )
		{
			return $this->sError;
		}
	}

?>
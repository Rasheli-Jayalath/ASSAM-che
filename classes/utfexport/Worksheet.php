<?php
/*
*  Module written/ported by Xavier Noguer <xnoguer@rezebra.com>
*
*  The majority of this is _NOT_ my code.  I simply ported it from the
*  PERL Spreadsheet::WriteExcel module.
*
*  The author of the Spreadsheet::WriteExcel module is John McNamara
*  <jmcnamara@cpan.org>
*
*  I _DO_ maintain this code, and John McNamara has nothing to do with the
*  porting of this code to PHP.  Any questions directly related to this
*  class library should be directed to me.
*
*  License Information:
*
*    Spreadsheet_Excel_Writer:  A library for generating Excel Spreadsheets
*    Copyright (c) 2002-2003 Xavier Noguer xnoguer@rezebra.com
*
*    This library is free software; you can redistribute it and/or
*    modify it under the terms of the GNU Lesser General Public
*    License as published by the Free Software Foundation; either
*    version 2.1 of the License, or (at your option) any later version.
*
*    This library is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
*    Lesser General Public License for more details.
*
*    You should have received a copy of the GNU Lesser General Public
*    License along with this library; if not, write to the Free Software
*    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

require_once 'Parser.php';
require_once 'BIFFwriter.php';

/**
* Class for generating Excel Spreadsheets
*
* @author   Xavier Noguer <xnoguer@rezebra.com>
* @category FileFormats
* @package  Spreadsheet_Excel_Writer
*/

class Spreadsheet_Excel_Writer_Worksheet extends Spreadsheet_Excel_Writer_BIFFwriter
{
    /**
    * Name of the Worksheet
    * @var string
    */
    var $name;

    /**
    * Index for the Worksheet
    * @var integer
    */
    var $index;

    /**
    * Reference to the (default) Format object for URLs
    * @var object Format
    */
    var $_url_format;

    /**
    * Reference to the parser used for parsing formulas
    * @var object Format
    */
    var $_parser;

    /**
    * Filehandle to the temporary file for storing data
    * @var resource
    */
    var $_filehandle;

    /**
    * Boolean indicating if we are using a temporary file for storing data
    * @var bool
    */
    var $_using_tmpfile;

    /**
    * Maximum number of rows for an Excel spreadsheet (BIFF5)
    * @var integer
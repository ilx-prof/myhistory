<?php
/*======================================================================*\
|| #################################################################### ||
|| # vBulletin 3.5.0 Release Candidate 3                              # ||
|| # ---------------------------------------------------------------- # ||
|| # Copyright ©2000-2005 Jelsoft Enterprises Ltd. All Rights Reserved. ||
|| # This file may not be redistributed in whole or significant part. # ||
|| # ---------------- VBULLETIN IS NOT FREE SOFTWARE ---------------- # ||
|| #        SCRiPTMAFiA 2005 - THE DiRTY HANDS ON YOUR SCRiPTS        # ||
|| #################################################################### ||
\*======================================================================*/

error_reporting(E_ALL & ~E_NOTICE);

define('ERRDB_FIELD_DOES_NOT_EXIST', 1);
define('ERRDB_FIELD_EXISTS', 2);

define('ERRDB_MYSQL', 100);

/**
* Database Modification Class
*
* This class allows an abstracted method for altering database structure without throwing database errors willy nilly
*
* @package 		vBulletin
* @version		$Revision: 1.18 $
* @date 		$Date: 2005/08/02 01:12:12 $
*
*/

class vB_Database_Alter
{
	/**
	* Whether a table has been initialized for altering.
	*
	* @var	boolean
	*/
	var $init = false;

	/**
	* Number of the latest error from the database. 0 if no error.
	*
	* @var	integer
	*/
	var $error_no = 0;

	/**
	* Description of the lates error from the database.
	*
	* @var	string
	*/
	var $error_desc = '';

	/**
	* Array of table index data
	*
	* @var	array
	*/
	var $table_index_data = array();

	/**
	* Array of table status data
	*
	* @var	array
	*/
	var $table_status_data = array();

	/**
	* Array of table field data
	*
	* @var	array
	*/
	var $table_field_data = array();

	/**
	* Name of the table being altered
	*
	* @var	string
	*/
	var $table_name = '';

	/**
	* Database object
	*
	* @var  object
	*/
	var $db = null;

	/**
	* Constructor - checks that the database object has been passed correctly.
	*
	* @param	vB_Database	The vB_Database object ($db)
	*/
	function vB_Database_Alter(&$db)
	{
		if (!is_subclass_of($this, 'vB_Database_Alter'))
		{
			trigger_error('Direct Instantiation of vB_Database_Alter class prohibited.', E_USER_ERROR);
		}
		else
		{
			if (is_object($db))
			{
				$this->db =& $db;
			}
			else
			{
				trigger_error('<strong>vB_Database_Alter</strong>: $this->db is not an object.', E_USER_ERROR);
			}
		}
	}

	/**
	* Public
	* Populates the $table_index_data, $table_status_data and $table_field_data arrays with all relevant information that is obtainable
	* about this database table.  Leave $tablename blank to use the table used in the previous call to this functions. The arrays are used
	* by the private and public functions to perform their work.  Nothing can be done to a table until this function is invoked.
	*
	* @param	string	$tablename	Name of table
	*
	* @return	bool
	*/
	function fetchTableInfo($tablename = '')
	{
		$this->setError(0);

		if ($tablename != '')
		{
			$this->table_name = $tablename;
		}
		else if ($this->table_name == '')
		{
			trigger_error('<strong>vB_Database_Alter</strong>: The first call to fetchTableInfo() requires a valid table paramater.', E_USER_ERROR);
		}

		if ($this->fetchIndexInfo() AND $this->fetchTableStatus() AND $this->fetchFieldInfo())
		{
			$this->init = true;
		}
		else
		{
			$this->init = false;
		}

		return $this->init;
	}

	/**
	* Public
	* Returns a text value that relates to the error condition, useable to prepare human readable error phrase varname strings
	*
	* @param	void
	*
	* @return	string
	*/
	function fetchError()
	{
		static $errors = array(
			0 => 'no_error',
			ERRDB_MYSQL => 'mysql',
			ERRDB_FIELD_DOES_NOT_EXIST => 'field_does_not_exist',
			ERRDB_FIELD_EXISTS => 'field_already_exists',
		);

		if (empty($errors["{$this->error_no}"]))
		{
			return 'undefined';
		}
		else
		{
			return $errors["{$this->error_no}"];
		}
	}

	/**
	* Public
	* Returns error description, set manually or by database error handler
	*
	* @param	void
	*
	* @return	string
	*/
	function fetchErrorMessage()
	{
		return $this->error_desc;
	}

	/**
	* Public
	* Returns the table type, i.e. ISAM, MYISAM, etc
	*
	* @param	void
	*
	* @return	string
	*/
	function fetchTableType()
	{
		return strtoupper($this->table_status_data[1]);
	}

	/**
	* Public
	* Drops an index
	*
	* @param	string	$fieldname	Name of index to drop
	*
	* @return	bool
	*/
	function dropIndex() {}

	/**
	* Public
	* Creates an index. Can be single or multi-column index, normal, unique or fulltext
	*
	* @param	string	$fieldname	Name of index to drop
	* @param	mixed	$fields		Name of field to index.  Create a multi field index by sending an array of field names
	* @param	string	$type		Default is normal. Valid options are 'FULLTEXT' and 'UNIQUE'
	* @param	bool	$overwrite	true = delete an existing index, then add.  false = return false if index of same name already exists unless it matches exactly
	*
	* @return	bool
	*/
	function addIndex() {}

	/**
	* Public
	* Adds field. Can be single fields, or multiple fields. If a field already exists, false will be returned so to silently fail on duplicate fields
	* you would want to call this multiple times, creating a field one at a time.
	*
	* @param	array	$fields		Definition of field to index.  Create multiple fields by sending an array of definitions but see note above.
	* @param	bool	$overwrite	true = delete an existing field of same name, then create.  false = return false if a field of same name already exists
	*
	* @return	bool
	*/
	function addField() {}

	/**
	* Public
	* Drops field. Can be single fields, or multiple fields. If a field doesn't exist, false will be returned so to silently fail on missing fields
	* you would want to call this multiple times, dropping a field one at a time.
	*
	* @param	mixed	$fields		Name of field to drop.  Drop multiple fields by sending an array of names but see note above.
	* @param	bool	$overwrite	true = delete an existing field of same name, then create.  false = return false if a field of same name already exists
	*
	* @return	bool
	*/
	function dropField() {}

	/**
	* Private
	* Set the $error_no and $error_desc variables
	*
	* @param	integer	$errno	Errorcode - use values defined at top of class file
	* @param	string	$desc	Description of error. Manually set or returned by database error handler
	*
	* @return	void
	*/
	function setError($errno, $desc = '')
	{
		$this->error_no = $errno;
		$this->error_desc = $desc;
	}

	/**
	* Private
	* Verifies that fetchTableInfo() has been called for a valid table and sets current error condition to none
	* .. in other words verify that fetchTableInfo returns true before proceeding on
	*
	* @param	void
	*
	* @return	void
	*/
	function initTableInfo()
	{
		if (!$this->init)
		{
			die('<strong>vB_Database_Alter</strong>: fetchTableInfo() has not been called successfully.');
		}
		$this->setError(0);
	}
}

class vB_Database_Alter_MySQL extends vB_Database_Alter
{

	/**
	* Private
	* Populates $this->table_index_data with index schema relating to $this->table_name
	*
	* @param	void
	*
	* @return	bool
	*/
	function fetchIndexInfo()
	{
		$this->setError(0);
		$this->table_index_data = array();

		$this->db->hide_errors();
		$tableinfos = $this->db->query("
			SHOW KEYS FROM " . TABLE_PREFIX . $this->db->escape_string($this->table_name)
		);
		$this->db->show_errors();
		if (!$tableinfos)
		{
			$this->setError(ERRDB_MYSQL, $this->db->error());
			return false;
		}
		else
		{
			while ($tableinfo = $this->db->fetch_array($tableinfos))
			{
				$key = $tableinfo['Key_name'];
				$column = $tableinfo['Column_name'];
				if (!$tableinfo['Index_type'] AND $tableinfo['Comment'] == 'FULLTEXT')
				{
					$tableinfo['Index_type'] = 'FULLTEXT';
				}
				unset($tableinfo['Key_name'], $tableinfo['Column_name'], $tableinfo['Table']);
				$this->table_index_data["$key"]["$column"] = $tableinfo;
			}
			return true;
		}
	}

	/**
	* Private
	* Populates $this->table_field_data with column schema relating to $this->table_name
	*
	* @param	void
	*
	* @return	bool
	*/
	function fetchFieldInfo()
	{
		$this->setError(0);
		$this->table_field_data = array();

		$this->db->hide_errors();
		$tableinfos = $this->db->query("
			SHOW COLUMNS FROM " . TABLE_PREFIX . $this->db->escape_string($this->table_name)
		);
		$this->db->show_errors();
		if (!$tableinfos)
		{
			$this->setError(ERRDB_MYSQL, $this->db->error());
			return false;
		}
		else
		{
			while($tableinfo = $this->db->fetch_array($tableinfos))
			{
				$key = $tableinfo['Field'];
				unset($tableinfo['Field']);
				$this->table_field_data["$key"] = $tableinfo;
			}
			return true;
		}
	}

	/**
	* Private
	* Populates $this->table_status_data with table status relating to $this->table_name
	*
	* @param	void
	*
	* @return	bool
	*/
	function fetchTableStatus()
	{

		$this->setError(0);
		$this->table_status_data = array();

		$this->db->hide_errors();
		$tableinfo = $this->db->query_first("
			SHOW TABLE STATUS LIKE '" . TABLE_PREFIX . $this->db->escape_string($this->table_name) . "'", DBARRAY_NUM
		);
		$this->db->show_errors();

		if (!$tableinfo)
		{
			$this->setError(ERRDB_MYSQL, $this->db->error());
			return false;
		}
		else
		{
			$this->table_status_data = $tableinfo;
			return true;
		}

	}

	/**
	* Private
	* Converts table type, i.e. from ISAM to MYISAM
	*
	* @param	string
	*
	* @return	bool
	*/
	function convertTableType($type)
	{
		$this->initTableInfo();

		if (strtoupper($type) == strtoupper($this->table_status_data[1]))
		{
			// hmm the table is already this type...
			return true;
		}
		else
		{
			$this->db->show_errors();
			$this->db->query("
				ALTER TABLE " . TABLE_PREFIX . $this->db->escape_string($this->table_name) . "
				TYPE = " . $this->db->escape_string(strtoupper($type))
			);
			$this->db->show_errors();
			if ($this->db->errno())
			{
				$this->setError(ERRDB_MYSQL, $this->db->error());
				return false;
			}
			else
			{
				// refresh table_index_data with current information
				$this->fetchTableInfo();

				return true;
			}
		}
	}

	function dropIndex($fieldname)
	{
		$this->initTableInfo();

		if (!empty($this->table_index_data["$fieldname"]))
		{
			$this->db->hide_errors();
			$this->db->query("
				ALTER TABLE " . TABLE_PREFIX . $this->db->escape_string($this->table_name) . "
				DROP INDEX " . $this->db->escape_string($fieldname)
			);
			$this->db->show_errors();
			if ($this->db->errno())
			{
				$this->setError(ERRDB_MYSQL, $this->db->error());
				return false;
			}
			else
			{
				// refresh table_index_data with current information
				$this->fetchTableInfo();
				return true;
			}
		}
		else
		{
			$this->setError(ERRDB_FIELD_DOES_NOT_EXIST, $fieldname);
			return false;
		}
	}

	function addIndex($fieldname, $fields, $type = '', $overwrite = false)
	{
		$this->initTableInfo();

		if (!is_array($fields))
		{
			$fields = array($fields);
		}

		$badfields = array();
		foreach ($fields AS $name)
		{
			if (empty($this->table_field_data["$name"]))
			{
				$badfields[] = $name;
			}
		}

		if (!empty($badfields))
		{
			$this->setError(ERRDB_FIELD_DOES_NOT_EXIST, implode(', ', $badfields));
			return false;
		}

		if (!empty($this->table_index_data["$fieldname"]))
		{
			if ($overwrite)
			{
				$this->dropIndex($fieldname);
				return $this->addIndex($fieldname, $fields, $type);
			}
			else
			{
				// this looks for an existing index that matches what we want to create and uses it, Not exact .. doesn't check for defined length i.e. char(10)
				if (!empty($this->table_index_data["$fieldname"]) AND count($fields) == count($this->table_index_data["$fieldname"]))
				{
					foreach($fields AS $name)
					{
						if (empty($this->table_index_data["$fieldname"]["$name"]) OR $this->table_index_data["$fieldname"]["$name"]['Index_type'] != strtoupper($type))
						{
							$this->setError(ERRDB_FIELD_EXISTS, $fieldname);
							return false;
						}
					}

					return true;
				}
				else
				{
					$this->setError(ERRDB_FIELD_EXISTS, $fieldname);
					return false;
				}
			}
		}
		else
		{
			if (strtolower($type) == 'fulltext')
			{
				if (strtoupper($this->table_status_data[1]) != 'MYISAM')
				{
					// only myisam supports fulltext...
					$this->convertTableType('MYISAM');
				}
				$type = 'FULLTEXT';
			}
			else if (strtolower($type) == 'unique')
			{
				$type = 'UNIQUE';
			}
			else
			{
				$type = '';
			}

			$this->db->hide_errors();
			$query = "CREATE $type INDEX " . $this->db->escape_string($fieldname) . " ON " . TABLE_PREFIX . $this->db->escape_string($this->table_name) . " (" . implode(',', $fields) . ")";
			$this->db->query($query);
			$this->db->show_errors();
			if ($this->db->errno())
			{
				$this->setError(ERRDB_MYSQL, $this->db->error());
				return false;
			}
			else
			{
				// refresh table_index_data with current information
				$this->fetchTableInfo();

				return true;
			}
		}
	}

	function addField($fields, $overwrite = false)
	{
		/*
			$fields = array(
				'name' => 'foo',
				'type' => 'varchar',
				'length' => '20',
				'attributes' => "",
				'null'	=> 'NULL',
				'default'	=> '',
				'extra' => '',
			);

		*/

		$this->initTableInfo();

		if (!is_array($fields[0]))
		{
			$fields = array($fields);
		}

		$schema = array();
		foreach ($fields AS $field)
		{
			if (!empty($this->table_field_data["{$field['name']}"]))
			{
				if ($overwrite)
				{
					$this->dropField($field['name']);
					return $this->addField($field);
				}
				else
				{
					$this->setError(ERRDB_FIELD_EXISTS, $field['name']);
					return false;
				}
			}
			else
			{
				$schema[] =
					"$field[name] " .
					strtoupper($field['type']) . (!empty($field['length']) ? "($field[length])" : '') . ' ' .
					strtoupper($field['attributes']) . ' ' .
					($field['null'] != '' ? strtoupper($field['null']) : 'NOT NULL') . ' ' .
					($field['default'] != '' ? "DEFAULT '$field[default]'" : '') . ' ' .
					($field['extra'] != '' ? $field['extra'] : '');
			}
		}

		// Now add fields.
		$this->db->hide_errors();
		$this->db->query("
			ALTER TABLE " . TABLE_PREFIX . $this->db->escape_string($this->table_name) . "
			ADD " . implode(",\n\t\t\t\tADD ", $schema)
		);
		$this->db->show_errors();
		if ($this->db->errno())
		{
			$this->setError(ERRDB_MYSQL, $this->db->error());
			return false;
		}
		else
		{
			// refresh table_index_data with current information
			$this->fetchTableInfo();

			return true;
		}
	}

	function dropField($fields)
	{
		$this->initTableInfo();

		if (!is_array($fields))
		{
			$fields = array($fields);
		}

		$badfields = array();
		foreach ($fields AS $name)
		{
			if (empty($this->table_field_data["$name"]))
			{
				$badfields[] = $name;
			}
		}

		if (!empty($badfields))
		{
			$this->setError(ERRDB_FIELD_DOES_NOT_EXIST, implode(', ', $badfields));
			return false;
		}

		$this->db->hide_errors();
		$this->db->query("
			ALTER TABLE " . TABLE_PREFIX . $this->db->escape_string($this->table_name) . "
				DROP " . implode(",\n\t\t\t\tDROP ", $fields)
		);
		$this->db->show_errors();
		if ($this->db->errno())
		{
			$this->setError(ERRDB_MYSQL, $this->db->error());
			return false;
		}
		else
		{
			// refresh table_index_data with current information
			$this->fetchTableInfo();

			return true;
		}
	}
}

/*======================================================================*\
|| ####################################################################
|| #        SCRiPTMAFiA 2005 - THE DiRTY HANDS ON YOUR SCRiPTS
|| # CVS: $RCSfile: class_dbalter.php,v $ - $Revision: 1.18 $
|| ####################################################################
\*======================================================================*/

?>
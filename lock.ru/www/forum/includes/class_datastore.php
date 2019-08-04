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

if (!class_exists('vB_Datastore'))
{
	exit;
}

// #############################################################################
// eAccelerator

class vB_Datastore_eAccelerator extends vB_Datastore
{
	/*
	Unfortunately, due to a design issue with eAccelerator
	we must disable this module at this time.

	The reason for this is that eAccelerator does not distinguish
	between memory allocated for cached scripts and memory allocated
	as shared memory storage.

	Therefore, the possibility exists for the administrator to turn
	off the board, which would then instruct eAccelerator to update
	its cache of the datastore. However, if the memory allocated is
	insufficient to store the new version of the datastore due to
	being filled with cached scripts, this will not be performed
	successfully, resulting in the OLD version of the datastore
	remaining, with the net result that the board does NOT turn off
	until the web server is restarted (which refreshes the shared
	memory)

	This problem affects anything read from the datastore, including
	the forumcache, the options cache, the usergroup cache, smilies,
	bbcodes, post icons...

	As a result we have no alternative but to totally disable the
	eAccelerator datastore module at this time. If at some point in
	the future this design issue is resolved, we will re-enable it.

	We still recommend running eAccelerator with PHP due to the huge
	performance benefits, but at this time it is not viable to use
	it for datastore cacheing. - Kier
	*/
}

/**
* Class for fetching and initializing the vBulletin datastore from eAccelerator
*
* @package	vBulletin
* @version	$Revision: 1.21 $
* @date		$Date: 2005/09/06 16:37:39 $
*/
class vB_Datastore_eAccelerator_This_Has_Problems extends vB_Datastore
{
	/**
	* Fetches the contents of the datastore from eAccelerator
	*
	* @param	array	Array of items to fetch from the datastore
	*
	* @return	void
	*/
	function fetch($itemarray)
	{
		if (!function_exists('eaccelerator_get'))
		{
			trigger_error('eAccelerator not installed', E_USER_ERROR);
		}

		foreach ($this->defaultitems AS $item)
		{
			$this->do_fetch($item);
		}

		if (is_array($itemarray))
		{
			foreach ($itemarray AS $item)
			{
				$this->do_fetch($item);
			}
		}

		$this->check_options();

		// set the version number variable
		$this->registry->versionnumber =& $this->registry->options['templateversion'];
	}

	/**
	* Fetches the data from shared memory and detects errors
	*
	* @param	string	title of the datastore item
	*
	* @return	void
	*/
	function do_fetch($title)
	{
		$ptitle = $this->prefix . $title;

		if (($data = eaccelerator_get($ptitle)) === null)
		{ // appears its not there, lets grab the data, lock the shared memory and put it in
			$data = '';
			if ($dataitem = $this->dbobject->query_first("
				SELECT title, data FROM " . TABLE_PREFIX . "datastore
				WHERE title = '" . $this->dbobject->escape_string($title) ."'
			"))
			{
				$data =& $dataitem['data'];
			}
			$this->build($title, $data);
		}
		$this->register($title, $data);
	}

	/**
	* Updates the appropriate cache file
	*
	* @param	string	title of the datastore item
	*
	* @return	void
	*/
	function build($title, $data)
	{
		$title = $this->prefix . $title;

		if (!function_exists('eaccelerator_put'))
		{
			trigger_error('eAccelerator not installed', E_USER_ERROR);
		}
		if ($this->lock($title))
		{
			$check = eaccelerator_put($title, $data);
			$this->unlock($title);
			if ($check === false)
			{
				trigger_error('Unable to write to shared memory', E_USER_ERROR);
			}
		}
		else
		{
			trigger_error('Could not obtain shared memory lock', E_USER_ERROR);
		}
	}

	/**
	* Obtains a lock for the datastore
	*
	* @param	string	title of the datastore item
	*
	* @return	boolean
	*/
	function lock($title)
	{
		$lock_ex = eaccelerator_lock($title);
		while ($lock_ex === false AND ($i++ < 5))
		{
			$lock_ex = eaccelerator_lock($title);
			sleep(1);
		}
		return $lock_ex;
	}

	/**
	* Releases the datastore lock
	*
	* @param	string	title of the datastore item
	*
	* @return	void
	*/
	function unlock($title)
	{
		eaccelerator_unlock($title);
	}
}

// #############################################################################
// Memcached

/**
* Class for fetching and initializing the vBulletin datastore from a Memcache Server
*
* @package	vBulletin
* @version	$Revision: 1.21 $
* @date		$Date: 2005/09/06 16:37:39 $
*/
class vB_Datastore_Memcached extends vB_Datastore
{
	/**
	* The Memcache object
	*
	* @var	Memcache
	*/
	var $memcache = null;

	/**
	* To prevent locking when the memcached has been restarted we want to use add rather than set
	*
	* @var	boolean
	*/
	var $memcache_set = true;

	/**
	* Fetches the contents of the datastore from a Memcache Server
	*
	* @param	array	Array of items to fetch from the datastore
	*
	* @return	void
	*/
	function fetch($itemarray)
	{
		if (!class_exists('Memcache'))
		{
			trigger_error('Memcache is not installed', E_USER_ERROR);
		}

		$this->memcache = new Memcache;
		if (!$this->memcache->connect($this->registry->config['Misc']['memcacheserver'], $this->registry->config['Misc']['memcacheport']))
		{
			trigger_error('Unable to connect to memcache server', E_USER_ERROR);
		}

		$this->memcache_set = false;

		foreach ($this->defaultitems AS $item)
		{
			$this->do_fetch($item);
		}

		if (is_array($itemarray))
		{
			foreach ($itemarray AS $item)
			{
				$this->do_fetch($item);
			}
		}

		$this->memcache_set = true;

		$this->check_options();

		// set the version number variable
		$this->registry->versionnumber =& $this->registry->options['templateversion'];

		$this->memcache->close();
	}

	/**
	* Fetches the data from shared memory and detects errors
	*
	* @param	string	title of the datastore item
	*
	* @return	void
	*/
	function do_fetch($title)
	{
		$ptitle = $this->prefix . $title;

		$data = $this->memcache->get($ptitle);
		if ($data === false)
		{ // appears its not there, lets grab the data
			$data = '';
			$dataitem = $this->dbobject->query_first("
				SELECT title, data FROM " . TABLE_PREFIX . "datastore
				WHERE title = '" . $this->dbobject->escape_string($title) ."'
			");
			if (!empty($dataitem['title']))
			{
				$data =& $dataitem['data'];
			}
				$this->build($ptitle, $data);
		}
		$this->register($title, $data);
	}

	/**
	* Updates the appropriate cache file
	*
	* @param	string	title of the datastore item
	*
	* @return	void
	*/
	function build($title, $data)
	{
		if (!class_exists('Memcache'))
		{
			trigger_error('Memcache is not installed', E_USER_ERROR);
		}
		if ($this->memcache_set)
		{
			$this->memcache->set($title, $data, MEMCACHE_COMPRESSED);
		}
		else
		{
			$this->memcache->add($title, $data, MEMCACHE_COMPRESSED);
		}
	}
}

// #############################################################################
// datastore using FILES instead of database for storage

/**
* Class for fetching and initializing the vBulletin datastore from files
*
* @package	vBulletin
* @version	$Revision: 1.21 $
* @date		$Date: 2005/09/06 16:37:39 $
*/
class vB_Datastore_Filecache extends vB_Datastore
{
	/**
	* Default items that are always loaded by fetch() when using the file method;
	*
	* @var	array
	*/
	var $cacheableitems = array(
		'options',
		'bitfields',
		'forumcache',
		'usergroupcache',
		'stylecache',
		'languagecache',
		'products',
		'pluginlist',
	);

	/**
	* Fetches the contents of the datastore from cache files
	*
	* @param	array	Array of items to fetch from the datastore
	*
	* @return	boolean
	*/
	function fetch($itemarray)
	{
		$this->unserialize = array_diff($this->unserialize, $this->cacheableitems);

		require_once(DIR . '/includes/datastore_cache.php');
		foreach ($this->cacheableitems AS $item)
		{
			if ($$item === '' OR !isset($$item))
			{
				$$item = $this->fetch_build($item);
			}
			if ($this->register($item, $$item) === false)
			{
				trigger_error('Unable to register some datastore items', E_USER_ERROR);
			}

			unset($$item);
		}
		$itemlist = "''";

		foreach ($this->defaultitems AS $item)
		{
			if (!in_array($item, $this->cacheableitems))
			{
				$itemlist .= ", '" . $this->dbobject->escape_string($item) . "'";
			}
		}

		if (is_array($itemarray))
		{
			foreach ($itemarray AS $item)
			{
				$itemlist .= ", '" . $this->dbobject->escape_string($item) . "'";
			}
		}

		$dataitems = $this->dbobject->query_read("
			SELECT title, data FROM " . TABLE_PREFIX . "datastore
			WHERE title IN($itemlist)
		");
		while ($dataitem = $this->dbobject->fetch_array($dataitems))
		{
			$this->register($dataitem['title'], $dataitem['data']);
		}
		$this->dbobject->free_result($dataitems);

		$this->check_options();

		// set the version number variable
		$this->registry->versionnumber =& $this->registry->options['templateversion'];
	}

	/**
	* Updates the appropriate cache file
	*
	* @param	string	title of the datastore item
	*
	* @return	void
	*/
	function build($title, $data)
	{
		if (!in_array($title, $this->cacheableitems))
		{
			return;
		}

		$data_code = var_export(unserialize(trim($data)), true);

		$cache = file_get_contents(DIR . '/includes/datastore_cache.php');

		// this is to workaround bug 976
		if (preg_match("/([\r\n]### start $title ###)(.*)([\r\n]### end $title ###)/siU", $cache, $match))
		{
			$cache = str_replace($match[0], "\n### start $title ###\n$$title = $data_code;\n### end $title ###", $cache);
		}

		/*insert query*/
		$this->dbobject->query_write("
			REPLACE INTO " . TABLE_PREFIX . "adminutil
				(title, text)
			VALUES
				('datastore', '" . $this->dbobject->escape_string($cache) . "')
		");

		// should really implement some sort of filelocking, maybe use the adminutil table again?
		if ($this->lock())
		{
			$fp = fopen(DIR . '/includes/datastore_cache.php', 'w');
			fwrite($fp, $cache);
			fclose($fp);
			$this->unlock();
		}
		else
		{
			trigger_error('Could not obtain file lock', E_USER_ERROR);
		}
	}

	/**
	* Obtains a lock for the datastore
	*
	* @param	string	title of the datastore item
	*
	* @return	boolean
	*/
	function lock($title = '')
	{
		$result = $this->dbobject->query_write("UPDATE " . TABLE_PREFIX . "adminutil SET text = UNIX_TIMESTAMP() WHERE title = 'datastorelock' AND text < UNIX_TIMESTAMP() - 15");
		return ($this->dbobject->affected_rows() > 0);
	}

	/**
	* Releases the datastore lock
	*
	* @param	string	title of the datastore item
	*
	* @return	void
	*/
	function unlock($title = '')
	{
		$this->dbobject->query_write("UPDATE " . TABLE_PREFIX . "adminutil SET text = 0 WHERE title = 'datastorelock'");
	}

	function fetch_build($title)
	{
		$data = '';
		$dataitem = $this->dbobject->query_first("
			SELECT title, data
			FROM " . TABLE_PREFIX . "datastore
			WHERE title = '" . $this->dbobject->escape_string($title) ."'
		");
		if (!empty($dataitem['title']))
		{
			$this->build($dataitem['title'], $dataitem['data']);
			$data = unserialize($dataitem['data']);
		}

		return $data;
	}
}

/*======================================================================*\
|| ####################################################################
|| #        SCRiPTMAFiA 2005 - THE DiRTY HANDS ON YOUR SCRiPTS
|| # CVS: $RCSfile: class_datastore.php,v $ - $Revision: 1.21 $
|| ####################################################################
\*======================================================================*/
?>

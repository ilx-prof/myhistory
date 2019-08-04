<?php
/*======================================================================*\
|| #################################################################### ||
|| # vBulletin 3.5.0 Release Candidate 3                              # ||
|| # ---------------------------------------------------------------- # ||
|| # Copyright �2000-2005 Jelsoft Enterprises Ltd. All Rights Reserved. ||
|| # This file may not be redistributed in whole or significant part. # ||
|| # ---------------- VBULLETIN IS NOT FREE SOFTWARE ---------------- # ||
|| #        SCRiPTMAFiA 2005 - THE DiRTY HANDS ON YOUR SCRiPTS        # ||
|| #################################################################### ||
\*======================================================================*/

if (!isset($GLOBALS['vbulletin']->db))
{
	exit;
}

/**
* Class that provides payment verification and form generation functions
*
* @package	vBulletin
* @version	$Revision: 1.3 $
* @date		$Date: 2005/07/06 22:47:10 $
*/
class vB_PaidSubscriptionMethod_authorizenet extends vB_PaidSubscriptionMethod
{
	/**
	* The currencies that are supported by this payment provider
	*
	* @var	array
	*/
	var $supported_currency = array('usd' => true, 'gbp' => true, 'eur' => true);

	/**
	* The variable indicating if this payment provider supports recurring transactions
	*
	* @var	bool
	*/
	var $supports_recurring = false;

	/**
	* Perform verification of the payment, this is called from the payment gatewa
	*
	* @return	bool	Whether the payment is valid
	*/
	function verify_payment()
	{
		$this->registry->input->clean_array_gpc('p', array(
			'x_amount'               => TYPE_STR,
			'x_trans_id'             => TYPE_STR,
			'x_MD5_Hash'             => TYPE_STR,
			'x_response_code'        => TYPE_UINT,
			'x_invoice_num'          => TYPE_STR,
			'x_response_reason_text' => TYPE_NOHTML,
			'x_response_reason_code' => TYPE_NOHTML,
		));

		$this->transaction_id = $this->registry->GPC['x_trans_id'];

		$check_hash = strtoupper(md5($this->settings['authorize_loginid'] . $this->registry->GPC['x_trans_id'] . $this->registry->GPC['x_amount']));

		if ($check_hash == $vbulletin->GPC['x_MD5_Hash'])
		{
			if ($vbulletin->GPC['x_response_code'] == 1)
			{
				$this->paymentinfo = $this->registry->db->query_first("SELECT * FROM " . TABLE_PREFIX . "paymentinfo WHERE hash = '" . $this->registry->db->escape_string($this->registry->GPC['x_invoice_num']) . "'");
				// lets check the values
				if (!empty($this->paymentinfo))
				{
					$sub = $this->registry->db->query_first("SELECT * FROM " . TABLE_PREFIX . "subscription WHERE subscriptionid = " . $this->paymentinfo['subscriptionid']);
					$cost = unserialize($sub['cost']);
					// dont need to check the amount since authornize.net dont include the currency when its sent back
					// the hash helps us get around this though
					$this->type = 1;
					return true;
				}
			}
		}
		return false;
	}

	/**
	* Generates HTML for the subscription form page
	*
	* @param	string		Hash used to indicate the transaction within vBulletin
	* @param	string		The cost of this payment
	* @param	string		The currency of this payment
	* @param	array		Information regarding the subscription that is being purchased
	* @param	array		Information about the user who is purchasing this subscription
	* @param	array		Array containing specific data about the cost and time for the specific subscription period
	*
	* @return	array		Compiled form information
	*/
	function generate_form_html($hash, $cost, $currency, $subinfo, $userinfo, $timeinfo)
	{
		$item = $hash;
		$currency = strtoupper($currency);

		$sequence = vbrand(1, 1000);
		$fingerprint = $this->hmac($this->settings['txnkey'], $this->settings['authorize_loginid'] . '^' . $sequence . '^' . TIMENOW . '^' . $cost . '^' . $currency);
		$timenow = TIMENOW;

		$form['action'] = 'https://secure.authorize.net/gateway/transact.dll';
		$form['method'] = 'post';

		// load settings into array so the template system can access them
		$settings =& $this->settings;

		eval('$form[\'hiddenfields\'] .= "' . fetch_template('subscription_payment_authorizenet') . '";');
		return $form;
	}

	/**
	* RFC 2104 HMAC
	*
	* @param	string		Key to hash data with
	* @param	string		Data
	*
	* @return	string		MD5 HMAC
	*/
	function hmac($key, $data)
	{
		$b = 64;
		if (strlen($key) > $b)
		{
			$key = pack("H*", md5($key));
		}
		$key  = str_pad($key, $b, chr(0x00));
		$ipad = str_pad('', $b, chr(0x36));
		$opad = str_pad('', $b, chr(0x5c));
		$k_ipad = $key ^ $ipad;
		$k_opad = $key ^ $opad;
	
		return md5($k_opad . pack("H*", md5($k_ipad . $data)));
	}
}

/*======================================================================*\
|| ####################################################################
|| #        SCRiPTMAFiA 2005 - THE DiRTY HANDS ON YOUR SCRiPTS
|| # CVS: $RCSfile: class_authorizenet.php,v $ - $Revision: 1.3 $
|| ####################################################################
\*======================================================================*/
?>
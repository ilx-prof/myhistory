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
* @version	$Revision: 1.9 $
* @date		$Date: 2005/09/06 16:21:26 $
*/
class vB_PaidSubscriptionMethod_paypal extends vB_PaidSubscriptionMethod
{
	/**
	* The currencies that are supported by this payment provider
	*
	* @var	array
	*/
	var $supported_currency = array('usd' => true, 'gbp' => true, 'eur' => true, 'aud' => true, 'cad' => true);

	/**
	* The variable indicating if this payment provider supports recurring transactions
	*
	* @var	bool
	*/
	var $supports_recurring = true;

	/**
	* Perform verification of the payment, this is called from the payment gatewa
	*
	* @return	bool	Whether the payment is valid
	*/
	function verify_payment()
	{
		// Leave all of these values as TYPE_STR since we have to send them back to paypal exactly how we received them!
		$this->registry->input->clean_array_gpc('p', array(
			'item_number'    => TYPE_STR,
			'business'       => TYPE_STR,
			'receiver_email' => TYPE_STR,
			'tax'            => TYPE_STR,
			'txn_type'       => TYPE_STR,
			'payment_status' => TYPE_STR,
			'mc_currency'    => TYPE_STR,
			'mc_gross'       => TYPE_STR,
			'txn_id'         => TYPE_STR
		));

		$this->transaction_id = $this->registry->GPC['txn_id'];

		$mc_gross = doubleval($this->registry->GPC['mc_gross']);
		$tax = doubleval($this->registry->GPC['tax']);

		$query[] = 'cmd=_notify-validate';
		foreach($_POST AS $key => $val)
		{
			if (!empty($val))
			{
				$query[] = $key . '=' . urlencode ($val);
			}
		}
		$query = implode('&', $query);

		$used_curl = false;
		
		if (function_exists('curl_init') AND $ch = curl_init())
		{
			curl_setopt($ch, CURLOPT_URL, 'http://www.paypal.com/cgi-bin/webscr');
			curl_setopt($ch, CURLOPT_TIMEOUT, 15);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDSIZE, 0);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
			$result = curl_exec($ch);
			curl_close($ch);
			if ($result !== false)
			{
				$used_curl = true;
			}
		}
		if (!$used_curl)
		{
			$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
			$header .= "Host: www.paypal.com\r\n";
			$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
			$header .= "Content-Length: " . strlen($query) . "\r\n\r\n";
			$fp = fsockopen('www.paypal.com', 80, $errno, $errstr, 30);
			socket_set_timeout($fp, 30);
			fwrite($fp, $header . $query);
			while (!feof($fp))
			{
				$result = fgets($fp, 1024);
				if (strcmp($result, 'VERIFIED') == 0)
				{
					break;
				}
			}
			fclose($fp);
		}

		if ($result == 'VERIFIED' AND (strtolower($this->registry->GPC['business']) == strtolower($this->settings['ppemail']) OR strtolower($this->registry->GPC['receiver_email']) == strtolower($this->settings['primaryemail'])))
		{
			$this->paymentinfo = $this->registry->db->query_first("SELECT * FROM " . TABLE_PREFIX . "paymentinfo WHERE hash = '" . $this->registry->db->escape_string($this->registry->GPC['item_number']) . "'");
			// lets check the values
			if (!empty($this->paymentinfo))
			{
				//its a paypal payment and we have some valid ids
				$sub = $this->registry->db->query_first("SELECT * FROM " . TABLE_PREFIX . "subscription WHERE subscriptionid = " . $this->paymentinfo['subscriptionid']);
				$cost = unserialize($sub['cost']);
				if ($tax > 0)
				{
					$mc_gross -= $tax;
				}

				// Check if its a payment or if its a reversal
				if (($this->registry->GPC['txn_type'] == 'web_accept' OR $this->registry->GPC['txn_type'] == 'subscr_payment') AND $this->registry->GPC['payment_status'] == 'Completed')
				{
					if ($mc_gross == doubleval($cost["{$this->paymentinfo[subscriptionsubid]}"]['cost'][strtolower($this->registry->GPC['mc_currency'])]))
					{
						$this->type = 1;
					}
				}
				else if ($this->registry->GPC['payment_status'] == 'Reversed' OR $this->registry->GPC['payment_status'] == 'Refunded')
				{
					$this->type = 2;
				}
			}

			// Paypal likes to get told its message has been received
			if (SAPI_NAME == 'cgi' OR SAPI_NAME == 'cgi-fcgi')
			{
				header('Status: 200 OK');
			}
			else
			{
				header('HTTP/1.1 200 OK');
			}
			return true;
		}
		else
		{
			$this->error = 'Invalid Request';
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
	* @param	array		rray containing specific data about the cost and time for the specific subscription period
	*
	* @return	array		Compiled form information
	*/
	function generate_form_html($hash, $cost, $currency, $subinfo, $userinfo, $timeinfo)
	{
		$item = $hash;
		$currency = strtoupper($currency);

		$show['notax'] = ($subinfo['options'] & $this->settings['_SUBSCRIPTIONOPTIONS']['tax']) ? false : true;
		$show['recurring'] = ($this->supports_recurring AND $timeinfo['recurring']) ? true : false;
		$no_shipping = ($subinfo['options'] & $this->settings['_SUBSCRIPTIONOPTIONS']['shipping1']) ? 0 : (($subinfo['options'] & $this->settings['_SUBSCRIPTIONOPTIONS']['shipping2']) ? 2 : 1);

		$form['action'] = 'https://www.paypal.com/cgi-bin/webscr';
		$form['method'] = 'post';

		// load settings into array so the template system can access them
		$settings =& $this->settings;

		eval('$form[\'hiddenfields\'] .= "' . fetch_template('subscription_payment_paypal') . '";');
		return $form;
	}
}

/*======================================================================*\
|| ####################################################################
|| #        SCRiPTMAFiA 2005 - THE DiRTY HANDS ON YOUR SCRiPTS
|| # CVS: $RCSfile: class_paypal.php,v $ - $Revision: 1.9 $
|| ####################################################################
\*======================================================================*/
?>
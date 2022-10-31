<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2016, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2016, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter URL Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/helpers/url_helper.html
 */

// ------------------------------------------------------------------------

if ( ! function_exists('base64_to_png'))
{
	/**
	 * base64 to png
	 *
	 */
	function base64_to_png($base64_string, $output_file) {            
		$ifp = fopen($output_file, "wb");
		$data = explode(',', $base64_string);
		fwrite($ifp, base64_decode($data[0]));
		fclose($ifp);
		return $output_file;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('push_notification'))
{
	/**
	 * Push notification
	 *
	 */
	function push_notification($os, $device_id, $message, $topic, $id, $priority = 'N')
	{
		if($os=="ios")
		{
			$deviceToken = $device_id;
			$passphrase = '12345';
			//$message = "Push notification Test";
			$ctx = stream_context_create();
			switch ($topic) {
				// User
				case 'redeem_offer':
				case 'confirm_order':
				case 'cancel_order':
				case 'message_to_followers':
				case 'vendor_alert':
					$pem_file_path = $_SERVER['DOCUMENT_ROOT'].'/qa/push_notification/ck.pem';
					break;
				// Vendor
				case 'claim_offer':
				case 'new_order':
					$pem_file_path = $_SERVER['DOCUMENT_ROOT'].'/qa/push_notification/vendor/ck.pem';
					break;
				default:
					$pem_file_path = $_SERVER['DOCUMENT_ROOT'].'/qa/push_notification/ck.pem';
					break;
			}
			//$pem_file_path = $_SERVER['DOCUMENT_ROOT'].'/dev/push_notification/PushCertificateKey.pem';
			stream_context_set_option($ctx, 'ssl', 'local_cert', $pem_file_path);
			stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
			$fp = stream_socket_client(
				'ssl://gateway.push.apple.com:2195', $err,
				$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
			
			//$fp = stream_socket_client(
			//	'ssl://gateway.sandbox.push.apple.com:2195', $err,
			//	$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
			
			//if (!$fp)
				//exit("Failed to connect: $err $errstr" . PHP_EOL);
			
			//echo 'Connected to APNS' . PHP_EOL;
			
			if($priority=='Y')
			{
				$tone = "honeyb-priority.wav";
			}
			else {
				$tone = "honeyb-default.wav";
			}
			
			$body['aps'] = array(
				'alert' => $message,
				'sound' => $tone,
				"topic" => $topic,
				"id" => $id
				);
			
			$payload = json_encode($body);
			
			$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
			
			$result1 = fwrite($fp, $msg, strlen($msg));
			
			//if (!$result1)
			//	echo 'Message not delivered' . PHP_EOL;
			//else
			//	echo 'Message successfully delivered' . PHP_EOL;
			
			// Close the connection to the server
			fclose($fp);
		}
		
		if($os=="android")
		{
			//$regId = "APA91bHKrmFgbAygitkjwEKnwC4PSqXs-WDjweek-GoA6pfU2X2O8YPciyRRgwGGk0eEYLnf0hKsD5RApa910_N29oHAD37qxxel-82w4GIsLONyxQLkJu5I73OzkZ8gjUgYhYheU9Fj";
			$regId = $device_id;
			//$message = "Andriod push notification";
			 
			include_once $_SERVER['DOCUMENT_ROOT'].'/qa/push_notification/gcm.php';
			 
			$gcm = new GCM();
		 
			$registatoin_ids = array($regId);
			$message = array("message" => $message, "topic" => $topic, "id" => $id, "priority" => $priority);
			//print_r($message);
		 
			$result = $gcm->send_notification($registatoin_ids, $message);
		 
			echo $result;
		}
	}
}


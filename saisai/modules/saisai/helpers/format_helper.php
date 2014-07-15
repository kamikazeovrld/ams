<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * SAISAI CMS
 * http://www.getsaisaicms.com
 *
 * An open source Content Management System based on the 
 * Codeigniter framework (http://codeigniter.com)
 *
 * @package		SAISAI CMS
 * @author		David McReynolds @ Daylight Studio
 * @copyright	Copyright (c) 2014, Run for Daylight LLC.
 * @license		http://docs.getsaisaicms.com/general/license
 * @link		http://www.getsaisaicms.com
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * SAISAI Format Helper
 *
 * @package		SAISAI CMS
 * @subpackage	Helpers
 * @category	Helpers
 * @author		David McReynolds @ Daylight Studio
 * @link		http://docs.getsaisaicms.com/helpers/format_helper
 */



// ------------------------------------------------------------------------

/**
 * Formats value into a currency string
 *
 * @access	public
 * @param	string
 * @param	bool	whether to include the cents or not
 * @return	string
 */
function currency($value, $symbol = '$',  $include_cents = TRUE, $decimal_sep = '.', $thousands_sep = ',')
{
	if (!isset($value) OR $value === "")
	{
		return;
	}
	$value = (float) $value;
	$dec_num = (!$include_cents) ? 0 : 2;
	return $symbol.number_format($value, $dec_num, $decimal_sep, $thousands_sep);
}

/* End of file format_helper.php */
/* Location: ./modules/saisai/helpers/format_helper.php */

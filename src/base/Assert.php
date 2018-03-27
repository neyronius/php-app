<?php
/**
 * Created by PhpStorm.
 * User: neyronius
 * Date: 27.03.2018
 * Time: 23:16
 */

namespace Neyronius\Base;


class Assert extends \Webmozart\Assert\Assert
{

	/**
	 * Check value for email
	 *
	 * @param $value
	 * @param string $message
	 */
	public function isEmail($value, $message = '')
	{
		if (filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
			static::reportInvalidArgument(sprintf(
				$message ?: 'Expected a string. Got: %s',
				static::typeToString($value)
			));
		}
	}

}
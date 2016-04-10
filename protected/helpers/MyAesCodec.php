<?php
/**
 * MySQL-совместимое AES-шифрование
 */
class MyAesCodec
{
    private static $key = 'xsolla';
	
	public static function encrypt($val) {
		$_key = self::$key;	
		$mysqlKey = str_repeat(chr(0), 16);
		for ($i = 0, $len = strlen($_key); $i < $len; $i++)
			$mysqlKey[$i%16] = $mysqlKey[$i%16] ^ $_key[$i];
		$padValue = 16 - (strlen($val) % 16);
		$val = str_pad($val, (16*(floor(strlen($val) / 16)+1)), chr($padValue));
		$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB), MCRYPT_DEV_URANDOM);
		
		return strtoupper(bin2hex(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $mysqlKey, $val, MCRYPT_MODE_ECB, $iv)));		
	}
	
	public static function decrypt($aesVal) {
		$n = strlen($aesVal);		
		$hexstr = $aesVal;
		$aesVal = '';
        $i = 0; 
        while ($i < $n) 
        {              
            $c = pack("H*", substr($hexstr, $i, 2)); 
            if ($i == 0) $aesVal = $c; 
            else $aesVal .= $c;
            $i += 2; 
        }
 		
		$key = self::$key;
		$mysqlKey = str_repeat(chr(0), 16);
		for ($i = 0, $len = strlen($_key); $i < $len; $i++)
			$mysqlKey[$i%16] = $mysqlKey[$i%16] ^ $_key[$i];
		$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB), MCRYPT_DEV_URANDOM);

		return preg_replace('/[^A-Za-z0-9_]/', '', mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $mysqlKey, $aesVal, MCRYPT_MODE_ECB, $iv));		
	}
}
?>
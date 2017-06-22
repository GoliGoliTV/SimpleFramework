<?php

/**
 * SimpleFramework
 * The fast, light-weighted, easy-to-extend php framework.
 *
 * Some classes are based on project PocketMine-MP.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author iTXTech
 * @link https://itxtech.org
 */

namespace iTXTech\SimpleFramework\Util;

class Util{
	const USER_AGENT = "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36";

	private static $os;

	public static function getURL($page, $timeout = 10, array $extraHeaders = []){
		$curl = new Curl();
		return $curl->setUrl($page)
			->setTimeout(10)
			->setHeader($extraHeaders)
			->setUA(self::USER_AGENT)
			->exec();
	}

	public static function getOS(){
		if(self::$os === null){
			$uname = php_uname("s");
			if(stripos($uname, "Darwin") !== false){
				if(strpos(php_uname("m"), "iP") === 0){
					self::$os = "ios";
				}else{
					self::$os = "mac";
				}
			}elseif(stripos($uname, "Win") !== false or $uname === "Msys"){
				self::$os = "win";
			}elseif(stripos($uname, "Linux") !== false){
				if(@file_exists("/system/build.prop")){
					self::$os = "android";
				}else{
					self::$os = "linux";
				}
			}elseif(stripos($uname, "BSD") !== false or $uname === "DragonFly"){
				self::$os = "bsd";
			}else{
				self::$os = "other";
			}
		}

		return self::$os;
	}

	public static function downloadFile(string $file, string $url){
		$curl = new Curl();
		$ret = $curl->setUrl($url)
			->setUA(self::USER_AGENT)
			->setTimeout(60)
			->setOpt(CURLOPT_BINARYTRANSFER, 1)
			->setOpt(CURLOPT_BUFFERSIZE, 20971520)
			->exec();

		if($ret != false){
			file_put_contents($file, $ret, FILE_BINARY);
		}
	}
}
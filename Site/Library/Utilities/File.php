<?php
namespace Site\Library\Utilities;

use Site\Library\Cryptography as Cryptography;

class File
{
    public static function getExtension($fileName) {
        return pathinfo($fileName, PATHINFO_EXTENSION);
    }

    public static function getWithoutExtension($fileName, $keepPath = false) {
        $output = '';
        if ($keepPath) {
            $path = pathinfo($fileName, PATHINFO_DIRNAME);
            $output = $path . '/';
        }
        
        $output .= pathinfo($fileName, PATHINFO_FILENAME);
        return $output;
    }

	public static function cleanName($fileName) {
		$output = trim($fileName);
		$output = strtolower($output);
		$output = trim(ereg_replace('[^ A-Za-z0-9_]', ' ', $output));
		$output = ereg_replace('[ \t\n\r]+', '_', $output);
		$output = str_replace(' ', '_', $output);
		$output = ereg_replace('[ _]+', '_', $output);
	
		return $output;
	}

    public static function genDateTimeName($ext = null) {
        $date = new DateTime();
        $output = sprintf('%s-%s', DateTime::fileDateTimeFormat(), Cryptography\Random::genString(6));
        return (empty($ext)) ? $output : sprintf('%s.$s', $output, $ext);
    }
}
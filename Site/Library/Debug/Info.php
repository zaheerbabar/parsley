<?php
namespace Site\Library\Debug;

class Info
{
    public static function write($output, $varDump = false) {
        echo '<pre>';
        if ($varDump) var_dump($output);
        else print_r($output);
        echo '</pre>';
    }

    public static function writeEnd($output, $varDump = false) {
        self::write($output, $varDump);
        exit();
    }

    public static function phpInfo() {
        echo phpinfo();
        exit();
    }
}
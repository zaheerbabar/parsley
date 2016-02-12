<?php
if (!function_exists('realpathi')) {
    /**
    * Case-insensitive realpath()
    * @param string $path
    * @return string|false
    */
    function realpathi($path)
    {
        $me = __METHOD__;
        $path = rtrim(preg_replace('#[/\\\\]+#', DIRECTORY_SEPARATOR, $path), DIRECTORY_SEPARATOR);
        $realPath = realpath($path);
        if ($realPath !== false) {
            return $realPath;
        }
        $dir = dirname($path);
        if ($dir === $path) {
            return false;
        }
        $dir = $me($dir);
        if ($dir === false) {
            return false;
        }
        $search = strtolower(basename($path));
        $pattern = '';
        for ($pos = 0; $pos < strlen($search); $pos++) {
            $pattern .= sprintf('[%s%s]', $search[$pos], strtoupper($search[$pos]));
        }
        return current(glob($dir . DIRECTORY_SEPARATOR . $pattern));
    }

}
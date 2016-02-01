<?php
namespace Site\Library;

class Loader
{
    public static function registerAutoload() {
        spl_autoload_register([new self, 'autoload']);
    }

    public static function autoload($class) {
        $prefixLen = strlen(NAMESPACE_PREFIX);

        if (strncmp(NAMESPACE_PREFIX, $class, $prefixLen) === 0) {
            $file = str_replace('\\', DS, substr($class, $prefixLen));
            $file = realpath(sprintf('%s/%s.php', SITE_DIR, $file));
            if ($file !== false) {
                require_once $file;
            }
        }
    }

    public static function loadAll($path, $recursive = false) {
        if ($recursive) {
            $Iterator = new \RecursiveDirectoryIterator(realpath($path));
        }
        else {
            $Iterator = new \FilesystemIterator(realpath($path));
        }
        
        $filesList = new \RegexIterator($Iterator, '/^.+\.php$/i', \RegexIterator::GET_MATCH);
        foreach ($filesList as $files) {
            foreach ($files as $file) {
                require_once realpath($file);
            }
        }
    }

}
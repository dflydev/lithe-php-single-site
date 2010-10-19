<?php

// Tear apart the existing include path.
$classpath = explode(PATH_SEPARATOR, get_include_path());

// Root folder for the Lithe bootstrap.
define('LITHE_BOOTSTRAPS_ROOT', dirname(__FILE__));

if ( ! defined('LITHE_ROOT') ) {
    // This should be defined by the caller. If it has not we
    // should assume that we know where the Lithe root lives.
    define('LITHE_ROOT', dirname(LITHE_BOOTSTRAPS_ROOT));
}

if ( ! defined('LITHE_VENDORS_ROOT') ) {
    // If this is not defined by the caller we can guess
    // where the Lithe vendors root lives.
    define('LITHE_VENDORS_ROOT', LITHE_ROOT . '/vendors');
}

if ( file_exists(LITHE_BOOTSTRAPS_ROOT . '/bootstrap-site-pre.php') ) {
    // Site specific bootstrapping can be done at this point.
    // Can be used to tweak classpath before standard Lithe
    // classpath is setup.
    require_once(LITHE_BOOTSTRAPS_ROOT . '/bootstrap-site-pre.php');
}

// Standard locations for classes.
$classpath[] = LITHE_LIB_ROOT;
$classpath[] = LITHE_CONFIG_ROOT;
$classpath[] = LITHE_CONTROLLERS_ROOT;

if ( ! defined('LITHE_NO_VENDORS') ) {
    if ( $dirHandle = opendir(LITHE_VENDORS_ROOT) ) {
        $vendorPaths = array();
        while ( ($potentialVendorDir = readdir($dirHandle)) !== false ) {
            $potentialVendorPath = LITHE_VENDORS_ROOT . DIRECTORY_SEPARATOR . $potentialVendorDir;
            if ( ( preg_match('/^[^\.]/', $potentialVendorDir) ) and is_dir($potentialVendorPath) ) {
                $classpath[] = realpath($potentialVendorPath);
            }
        }
        closedir($dirHandle);
    }
}

// Rebuild the include path.
set_include_path(implode(PATH_SEPARATOR, $classpath));

if ( file_exists(LITHE_BOOTSTRAPS_ROOT . '/bootstrap-site-post.php') ) {
    // Site specific bootstrapping after the classpath has been set.
    require_once(LITHE_BOOTSTRAPS_ROOT . '/bootstrap-site-post.php');
}

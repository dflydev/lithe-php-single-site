<?php

define('LITHE_DOCROOT', dirname(__FILE__));
define('LITHE_ROOT', dirname(dirname(__FILE__)));
define('LITHE_LIB_ROOT', LITHE_ROOT . '/lib');
define('LITHE_CONFIG_ROOT', LITHE_ROOT . '/config');
define('LITHE_CONTROLLERS_ROOT', LITHE_ROOT . '/controllers');
define('LITHE_VIEWS_ROOT', LITHE_ROOT . '/views');

require_once(LITHE_ROOT . '/bootstraps/bootstrap.php');

require_once('substrate_Context.php');
require_once('lithe_ContextUtil.php');

// Create the Substrate context.
$context = new substrate_Context(array(
    'lithe_base.context.php',
    'app.context.php',
    'controllers.context.php',
));

// Configure the locator paths.
lithe_ContextUtil::CONFIGURE_LOCATOR_PATHS($context, array(
    'controllers' => array(LITHE_CONTROLLERS_ROOT),
    'views' => array(LITHE_VIEWS_ROOT),
));

// Configure the controller configuration.
lithe_ContextUtil::CONFIGURE_CONTROLLER_CONFIGURATION($context, array(
    'controllers.properties',
));

// Configure Dispatcher dependencies
lithe_ContextUtil::CONFIGURE_DISPATCHER_DEPENDENCIES($context, array(
    'lithe.handlers.defaultHandlerMapping',
    'lithe.views.defaultViewResolver',
));

// Execute the context.
$context->execute();

// Execute the dispatcher.
lithe_ContextUtil::DISPATCH($context);
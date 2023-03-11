<?php
/*
Plugin Name: Apprex LMS Integration
Plugin URI: https://www.apprex.de/plugins/wordpress
Description: Liste deine Onlinekurse aus apprex direkt in WordPress auf
Author: Andreas Pabst von apprex.de
Author URI: https://www.andreaspabst.com
Version: 1.0.2
*/

// Stop direct calling of this file
if (!defined('WPINC')) { die; } 

// including the most important classes
require_once('lib/ApprexSettings.php');

if (is_admin()) { $apprexSettings = new ApprexSettings(); }

require_once('plugin-update-checker/plugin-update-checker.php');
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/apprex/wordpress',
	__FILE__, //Full path to the main plugin file or functions.php.
	'apprex'
);

//Set the branch that contains the stable release.
$myUpdateChecker->setBranch('main');


require_once('registrations.php');
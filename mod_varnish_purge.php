<?php
/**
 * @package     Alligo.Modules
 * @subpackage  mod_varnish_purge
 *
 * @copyright   Copyright (C) 2005 - 2015 Alligo Ltda. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once __DIR__ . '/helper.php';

require JModuleHelper::getLayoutPath('mod_varnish_purge', $params->get('layout', 'default'));

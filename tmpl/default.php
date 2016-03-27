<?php
/**
 * File based on native Joomla mod_banners from Joomla 3.4.6
 *
 * @package     Joomla.Site
 * @subpackage  mod_banners
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

?>
mod_varnish_purge

<form>
	<input type="text" name="data">
	<input type="submit" class="add" value="<?php echo JText::_('MOD_SESSION_INPUT_ADD') ?>" />
	<input type="submit" class="delete" value="<?php echo JText::_('MOD_SESSION_INPUT_DELETE') ?>" />
	<input type="submit" class="destroy" value="<?php echo JText::_('MOD_SESSION_INPUT_DESTROY') ?>" />
</form>
<div class="status"></div>
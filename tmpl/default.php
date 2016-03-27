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
<?php echo JText::_('MOD_VARNISH_PURGE_TUTORIAL') ?>

<form id="modvarnishpurge">
	<input type="text" name="data">
    <br />
	<input type="submit" id="modvarnishpurge_url " class="btn btn-primary" value="<?php echo JText::_('MOD_VARNISH_PURGE_SUBMIT_URL') ?>" />
	<input type="submit" id="modvarnishpurge_regex" class="btn btn-primary" value="<?php echo JText::_('MOD_VARNISH_PURGE_SUBMIT_REGEX') ?>" />
	<input type="submit" id="modvarnishpurge_full" class="btn" value="<?php echo JText::_('MOD_VARNISH_PURGE_SUBMIT_FULL') ?>" />
</form>
<div class="status"></div>
<script>
(function ($) {
	$(document).on('click', '#modvarnishpurge input[type=submit]', function () {
		var value   = $('input[name=data]').val(),
			action  = $(this).attr('class'),
			request = {
					'option' : 'com_ajax',
					'module' : 'varnish_purge',
					'cmd'    : action,
					'data'   : value,
					'format' : '{$format}'
				};
		$.ajax({
			type   : 'POST',
			data   : request,
			success: function (response) {
				console.log(response);
				if(response.data){
					var result = '';
					$.each(response.data, function (index, value) {
						result = result + ' ' + value;
					});
					$('.status').html(result);
				} else {
					$('.status').html(response);
				}
			},
			error: function(response) {
				var data = '',
					obj = $.parseJSON(response.responseText);
				for(key in obj){
					data = data + ' ' + obj[key] + '<br/>';
				}
				$('.status').html(data);
	        }
		});
		return false;
	});
})(jQuery)
</script>
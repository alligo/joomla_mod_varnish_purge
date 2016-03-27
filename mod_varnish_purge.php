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

// Instantiate global document object
$doc = JFactory::getDocument();
$loadJquery = $params->get('loadJquery', 1);
$format = $params->get('format', 'debug');
// Load jQuery
if ($loadJquery == '1') {
    $doc->addScript('//code.jquery.com/jquery-latest.min.js');
}
$js = <<<JS
(function ($) {
	$(document).on('click', 'input[type=submit]', function () {
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
JS;
$doc->addScriptDeclaration($js);

require JModuleHelper::getLayoutPath('mod_varnish_purge', $params->get('layout', 'default'));

<?php
/**
 * @package     Alligo.Modules
 * @subpackage  mod_banners4varnish
 *
 * @copyright   Copyright (C) 2005 - 2015 Alligo Ltda. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

/**
 * Helper for mod_banners4varnish
 *
 * @package     Alligo.Modules
 * @subpackage  mod_banners4varnish
 * @since       3.4
 */
class ModVarnishPurgeHelper
{

    public static function getAjax()
    {
        $input = JFactory::getApplication()->input;
        $module = JModuleHelper::getModule('varnish_purge');
        $params = new JRegistry();
        $params->loadString($module->params);
        $hostname = $params->get('hostname');
        $temp = $params->get('varnishlist');
        if ($temp) {
            $urls = array_filter(explode(PHP_EOL, $temp));
            //$urls = explode(PHP_EOL, $temp);
            foreach ($urls AS $k => $url) {
                if (strpos($url, 'http') === false) {
                    echo 'Malformated varnishlist';
                    die;
                }
                $urls[$k] = preg_replace('/\s+/', '', $urls[$k]);
            }
        } else {
            echo 'error';
            die;
        }
        //echo 'teste';
        //print_r($module);
        //print_r($hostname);
        //print_r($urls);

        $cmd = $input->get('cmd');
        $data = $input->getString('data');
        $urlquery = str_replace($hostname, '', $data);
        $method = $cmd === 'url' ? 'PURGE' : 'BAN';
        $hostname_clear = str_replace('https://', '', str_replace('http://', '', $hostname));
        foreach ($urls AS $url) {
            //echo ''
            echo 'purgeURL ' . $hostname . ', ' . $url . $urlquery . ', ' . $method . '<br>';
            echo '<hr><br>';
            echo '<pre>';
            echo ModVarnishPurgeHelper::purgeURL($hostname_clear, $url . $urlquery, $method);
            echo '</pre>';
            //echo
        }
    }

    public static function purgeURL($host, $url, $method = 'PURGE')
    {
        $ch = curl_init(); //Inicializar a sessao           
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, 1200);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_URL, $url); //Setar URL
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Host: ' . $host
        ]);

        print_r($ch);

        $content = curl_exec($ch); //Execute

        if (curl_errno($ch)) {
            return 'Error!' . curl_error($ch);
        }
        curl_close($ch); //Feche 
        return $content;
    }
}

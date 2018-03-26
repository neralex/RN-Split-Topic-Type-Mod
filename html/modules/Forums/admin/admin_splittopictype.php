<?php
/**
 * @package: Split Topic Type Mod (phpBB2 for RavenNuke(tm))
 * @version: 1.1
 * @file: admin_splittopictype.php
 * @Mod Version 1.0.3:
 * copyright (c) by Ptirhiik (Pierre) http://www.rpgnet-fr.com/ 
 * @RavenNuke(tm) Support:* 2012 neralex
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

define('IN_PHPBB', true);

if(!empty($setmodules)) {
	$filename = basename(__FILE__);
	$module['Split Topic Type']['Manage'] = $filename;
	return;
}

// Let's set the root dir for phpBB
$phpbb_root_path = './../';
$root_path = './../../../';
require($phpbb_root_path . 'extension.inc');
require('pagestart.' . $phpEx);
include_once($phpbb_root_path .'/includes/functions_admin.' . $phpEx);
include_once($phpbb_root_path .'/includes/constants.' . $phpEx);


//
// Pull all config data
//
global $prefix, $db, $board_config, $lang;
if (isset($board_config['split_announce']) && isset($board_config['split_announce'])) {
	$sql = 'SELECT * FROM `' . CONFIG_TABLE . '`';
	if(!$result = $db->sql_query($sql)) {
		message_die(CRITICAL_ERROR, 'Could not query general configuration in admin_board', '', __LINE__, __FILE__, $sql);
	} else {
		while($row = $db->sql_fetchrow($result)) {
			$config_name = $row['config_name'];
			$config_value = $row['config_value'];
			$default_config[$config_name] = isset($HTTP_POST_VARS['submit']) ? str_replace("'", "\'", $config_value) : $config_value;
			$new[$config_name] = ( isset($HTTP_POST_VARS[$config_name]) ) ? $HTTP_POST_VARS[$config_name] : $default_config[$config_name];
			if (isset($HTTP_POST_VARS['submit'])) {
				if (!is_numeric($new['split_announce']) || $new['split_announce'] < 0) {$new['split_announce'] = 0;}
				if (!is_numeric($new['split_sticky']) || $new['split_sticky'] < 0) {$new['split_sticky'] = 0;}	
				$sql = 'UPDATE `' . CONFIG_TABLE . '` SET `config_value` = \'' . $new[$config_name] . '\' WHERE `config_name` = \'' . $db->sql_escape_string($config_name) . '\'';
				if(!$db->sql_query($sql)) {
					message_die(GENERAL_ERROR, 'Failed to update general configuration for ' . $config_name . '', '', __LINE__, __FILE__, $sql);
				}
			}
		}
		if (isset($HTTP_POST_VARS['submit'])) {
			$message = $lang['Config_updated'] . '<br /><br />' . sprintf($lang['Split_GOBACKCONF'], '<a href="' . append_sid('admin_splittopictype.' . $phpEx) . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid('index.' . $phpEx . '?pane=right') . '">', '</a>');	
			message_die(GENERAL_MESSAGE, $message);
		}
	}
} else {
 	// install glance mod db table
	$qry1 = $db->sql_query('INSERT INTO `' . CONFIG_TABLE . '` (`config_name`, `config_value`) VALUES (\'split_announce\', \'1\'),(\'split_sticky\', \'1\')');
	if (isset($lang['Post_global_announcement']) && !isset( $board_config['split_global_announce'])) {
		$qry2 = $db->sql_query('INSERT INTO `' . CONFIG_TABLE . '` (`config_name`, `config_value`) VALUES (\'split_global_announce\', \'1\')');
	}
	if ($qry1 || ($qry1 && $qry2)) {
		$message = $lang['Split_DBINSTALLDONE'] . '<br /><br />' . sprintf($lang['Split_GOBACKCONF'], '<a href="' . append_sid('admin_splittopictype.' . $phpEx) . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid('index.' . $phpEx . '?pane=right') . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);
	} else {
		message_die(GENERAL_ERROR, 'Could not add keys for split topic type mod in config table!', '', __LINE__, __FILE__, $qry);
	}
}

$split_announce_yes = ( $new['split_announce'] ) ? ' checked="checked"' : '';
$split_announce_no = (!$new['split_announce'] ) ? ' checked="checked"' : '';
$split_sticky_yes = ( $new['split_sticky'] ) ? ' checked="checked"' : '';
$split_sticky_no = (!$new['split_sticky'] ) ? ' checked="checked"' : '';
if (isset($lang['Post_global_announcement'])) {
	$split_global_announce_yes = ( $new['split_global_announce'] ) ? ' checked="checked"' : '';
	$split_global_announce_no = (!$new['split_global_announce'] ) ? ' checked="checked"' : '';
}

$template->set_filenames(array(
	'body' => 'admin/splittopictype_config.tpl')
);

$template->assign_vars(array(
	'L_SUBMIT' => $lang['Submit'],
	'L_RESET' => $lang['Reset'],
	'L_YES' => $lang['Yes'],
	'L_NO' => $lang['No'],
	'L_ANNOUNCEMENT_SETTINGS' => $lang['Split_Topic_Type_Settings'],
	'L_SPLIT_ANNOUNCE' => $lang['Split_Announce'],
	'SPLIT_ANNOUNCE_YES' => $split_announce_yes,
	'SPLIT_ANNOUNCE_NO' => $split_announce_no,
	'L_SPLIT_STICKY' => $lang['Split_Sticky'],
	'SPLIT_STICKY_YES' => $split_sticky_yes,
	'SPLIT_STICKY_NO' => $split_sticky_no,
	'L_SPLIT_GLOBAL_ANNOUNCE' => $lang['Split_Global_Announce'],
	'SPLIT_GLOBAL_ANNOUNCE_YES' => $split_global_announce_yes,
	'SPLIT_GLOBAL_ANNOUNCE_NO' => $split_global_announce_no
	)
);
if (isset($lang['Post_global_announcement'])) $template->assign_block_vars('switch_global_announce', array());

$template->pparse('body');

include('page_footer_admin.' . $phpEx);
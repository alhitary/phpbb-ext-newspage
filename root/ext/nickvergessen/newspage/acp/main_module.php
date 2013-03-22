<?php

/**
*
* @package NV Newspage Extension
* @copyright (c) 2013 nickvergessen
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

class phpbb_ext_nickvergessen_newspage_acp_main_module
{
	var $u_action;

	function main($id, $mode)
	{
		global $db, $user, $auth, $template, $cache, $request;
		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;

		$user->add_lang('acp/common');
		$this->tpl_name = 'newspage_body';
		$this->page_title = $user->lang['NEWS'];
		add_form_key('newspage');

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key('newspage'))
			{
				trigger_error('FORM_INVALID');
			}

			$config->set('news_char_limit',			max(100, $request->variable('news_char_limit', 0)));
			$config->set('news_forums',				implode(',', $request->variable('news_forums', array(0))));
			$config->set('news_number',				max(1, $request->variable('news_number', 0)));
			$config->set('news_pages',				max(1, $request->variable('news_pages', 0)));
			$config->set('news_post_buttons',		$request->variable('news_post_buttons', 0));
			$config->set('news_user_info',			$request->variable('news_user_info', 0));
			$config->set('news_shadow',				$request->variable('news_shadow_show', 0));
			$config->set('news_attach_show',		$request->variable('news_attach_show', 0));
			$config->set('news_cat_show',			$request->variable('news_cat_show', 0));
			$config->set('news_archive_per_year',	$request->variable('news_archive_per_year', 0));

			trigger_error($user->lang['NEWS_SAVED'] . adm_back_link($this->u_action));
		}

		$template->assign_vars(array(
			'U_ACTION'				=> $this->u_action,
			'NEWS_CHAR_LIMIT'		=> $config['news_char_limit'],
			'NEWS_NUMBER'			=> $config['news_number'],
			'NEWS_PAGES'			=> $config['news_pages'],
			'NEWS_POST_BUTTONS'		=> $config['news_post_buttons'],
			'NEWS_USER_INFO'		=> $config['news_user_info'],
			'NEWS_SHADOW_SHOW'		=> $config['news_shadow'],
			'NEWS_ATTACH_SHOW'		=> $config['news_attach_show'],
			'NEWS_CAT_SHOW'			=> $config['news_cat_show'],
			'NEWS_ARCHIVE_PER_YEAR'	=> $config['news_archive_per_year'],
			'S_SELECT_FORUMS'		=> make_forum_select(explode(',', $config['news_forums'])),
		));
	}
}
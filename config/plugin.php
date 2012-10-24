<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Config for RSS Plugin
 *
 * PHP version 5
 * LICENSE: This source file is subject to the AGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/licenses/agpl.html
 * @author     Ushahidi Team <team@ushahidi.com> 
 * @package	   SwiftRiver - http://github.com/ushahidi/Swiftriver_v2
 * @subpackage Plugin Configs
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/licenses/agpl.html GNU Affero General Public License (AGPL) 
 */

return array(
	'rss' => array(
		'name'          => 'RSS',
		'description'   => 'Adds an RSS/Atom channel to SwiftRiver to parse RSS and Atom Feeds.',
		'author'        => 'David Kobia',
		'email'         => 'david@ushahidi.com',
		'version'       => '0.1.0',
		
		// Designate as a channel
		'channel'       => TRUE,
		
		// Fields
		'channel_options' => array(
			'url' => array(
				'label' => __('Feed URL'),
				'type' => 'text',
				'placeholder' => 'E.g. ihub.co.ke/blog/feed',
				'default_quota' => 999
			),
			'opml_import' => array(
				'label' => 'OPML File',
				'type' => 'file'
			)
		),
		
		// Plugin dependencies
		'dependencies'	=> array(
			'core' => array(
				'min' => '0.2.0',
				'max' => '10.0.0',
			),
		)
	),
);
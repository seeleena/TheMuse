<?php

namespace Elgg\Muse\Menus;

/**
 * Event callbacks for toolbar items
 *
 * @since 4.0
 * @internal
 */

 use Elgg\DefaultPluginBootstrap;

class Options extends DefaultPluginBootstrap{

	const HANDLERS = [];
	
	/**
	 * {@inheritdoc}
	 */
	public function init() {
		if (elgg_is_admin_logged_in()) {
			$this->courseOperations();
		} else {
			$this->landing();
			$this->assignmentListing();
			$this->grouping();
			$this->creativeProcess();
			$this->tools();
		}
	}

	/**
	 * Init views
	 *
	 * @return void
	 */
 
	protected function landing() {
				
		// add a site navigation item
		elgg_register_menu_item('site', [
			'name' => 'muse-landing',
			'icon' => 'lightbulb',
			'text' => elgg_echo('My Home'),
			'href' => elgg_generate_url('default:Core:student:landing'),
		]);
 
	}

	protected function assignmentListing() {
				
		// add a site navigation item
		elgg_register_menu_item('site', [
			'name' => 'muse-assignmentListing',
			'icon' => 'lightbulb',
			'text' => elgg_echo('My Assignments'),
			'href' => elgg_generate_url('default:Core:student:assignmentListing'),
		]);
	}

	protected function grouping() { 
				
		// add a site navigation item
		elgg_register_menu_item('site', [
			'name' => 'muse-group',
			'icon' => 'lightbulb',
			'text' => elgg_echo('My Group'),
			'href' => elgg_generate_url('default:Core:assignments:grouping'),
		]);
	}

	protected function creativeProcess() {
				
		// add a site navigation item
		elgg_register_menu_item('site', [
			'name' => 'muse-creativeProcess',
			'icon' => 'lightbulb',
			'text' => elgg_echo('My Creative Process'),
			'href' => elgg_generate_url('default:Core:myCreativeProcess:home'),
		]);
	}

	protected function tools() {
				
		// add a site navigation item
		elgg_register_menu_item('site', [
			'name' => 'muse-tools',
			'icon' => 'lightbulb',
			'text' => elgg_echo('My Tools'),
			'href' => elgg_generate_url('default:Core:myTools:main'),
		]);
	}

	protected function courseOperations() {
				
		// add a site navigation item
		elgg_register_menu_item('site', [
			'name' => 'muse-courseOperations',
			'icon' => 'lightbulb',
			'text' => elgg_echo('Course Operations'),
			'href' => elgg_generate_url('default:Core:instructor:landing'),
		]);
	}

}
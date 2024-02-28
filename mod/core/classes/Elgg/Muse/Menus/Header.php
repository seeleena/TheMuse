<?php

namespace Elgg\Muse\Menu;

/**
 * Event callbacks for menus
 *
 * @since 4.0
 * @internal
 */
class Header {

	/**
	 * Register menu item
	 *
	 * @param \Elgg\Event $event 'register', 'menu:site'
	 *
	 * @return \Elgg\Menu\MenuItems
	 */
	public static function register(\Elgg\Event $event) {
		
		$user = elgg_get_logged_in_user_entity();
		$items = array();

if(elgg_is_admin_logged_in()) {
    $items = array(
            "Course Operations" => "Core/instructorLanding",
            "Assignment Grading" => "Core/grading/main",
    );

    echo '<ul class="udt-toolbar">';
    foreach ($items as $name => $url) {
        $link = elgg_view('output/url', array(
                'text' => $name,
                'href' => $url,
        ));
        echo "<li>$link</li>";
    }
    echo '</ul>';
}
else {
    $items = array(
            'Home' => "Core/student/landing",
            'My Assignments' => "Core/assignment/viewAll",
            'My Group' => "Core/assignment/grouping/$user->username",
            'My Creative Process' => "Core/myCreativeProcess/home",
            'Tools' => "Core/myTools/owner/$user->username",
    );

    echo '<ul class="udt-toolbar">';
    foreach ($items as $name => $url) {
        $link = elgg_view('output/url', array(
                'text' => $name,
                'href' => $url,
        ));
        echo "<li>$link</li>";
    }
    echo '</ul>';
} return $items;
	}
}
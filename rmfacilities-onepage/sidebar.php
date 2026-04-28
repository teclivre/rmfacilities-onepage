<?php
/**
 * Sidebar.
 *
 * @package RMFacilitiesOnePage
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside class="sidebar-area">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>

<?php
/**
 * @package AuthorSocialLinks
 * 
 * If you use a theme with it's own custom hooks or if it uses get_author and get_author_link independently,
 * instead of using the_author_posts_link, this plugin will not work. Sorry.
 */
/*
Plugin Name: Author Social Links
Plugin URI: http://tycamtech.com/
Description: Each author for your blog can add their own specific social links which will appear as 16x16 icons next to their names.
Version: 0.0.1
Author: TyCamTech
Author URI: http://automattic.com/wordpress-plugins/
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/
define('AUTHORSOCIAL_VERSION', '0.0.1');
define('AUTHORSOCIAL_PLUGIN_URL', plugin_dir_url( __FILE__ ));

/**
 * Updates the the_author_posts_link to display the social links
 **/
function AuthorSocialLinks_link(){
	global $authordata;
	if ( !is_object( $authordata ) )
		return false;

	// Social links
	$sociallinks = null;

	$css = 'width: 16px !important; height: 16px !important; padding: 0px !important; margin: 1px !important; border: 0px !important;';

	$googleplus = get_user_meta($authordata->ID, 'googleplus', true);
	if( !empty($googleplus) ){
		$sociallinks.= '<a rel="me" href="' . $googleplus . '"><img src="' . AUTHORSOCIAL_PLUGIN_URL . 'images/gplus-16.png" style="' . $css . '"></a>';
	}
	$twitter = get_user_meta($authordata->ID, 'twitter', true);
	if( !empty($twitter) ){
		$sociallinks.= '<a rel="author" href="' . $twitter . '"><img src="' . AUTHORSOCIAL_PLUGIN_URL. 'images/twitter_16.png" style="' . $css . '"></a>';
	}
	$facebook = get_user_meta($authordata->ID, 'facebook', true);
	if( !empty($facebook) ){
		$sociallinks.= '<a rel="author" href="' . $facebook . '"><img src="' . AUTHORSOCIAL_PLUGIN_URL . 'images/facebook_16.png" style="' . $css . '"></a>';
	}

	$link = sprintf(
		'<a href="%1$s" title="%2$s" rel="author">%3$s</a>' . $sociallinks,
		get_author_posts_url( $authordata->ID, $authordata->user_nicename ),
		esc_attr( sprintf( __( 'Postsss by %s' ), get_the_author() ) ),
		get_the_author()
	);
	return $link;
}
add_filter( 'the_author_posts_link', 'AuthorSocialLinks_link', 10);

/**
 * Adds custom contact forms to the admin user's form for users to be able to add their own information
 **/
function AuthorSocialLinks_profiles( $contactmethods ) {
    // Add Blog Title
    $contactmethods['blog_title'] = 'Blog Title';
    // Add Google profile
    $contactmethods['googleplus'] = 'Google+ URL';
    // Add Twitter
    $contactmethods['twitter'] = 'Twitter Profile URL';
    //add Facebook
    $contactmethods['facebook'] = 'Facebook Profile URL';

    return $contactmethods;
}
add_filter('user_contactmethods','AuthorSocialLinks_profiles',10,1);
// end of adding custom fields to WP user profile
?>
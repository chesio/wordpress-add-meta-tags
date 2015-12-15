<?php
/**
 *  This file is part of the Add-Meta-Tags distribution package.
 *
 *  Add-Meta-Tags is an extension for the WordPress publishing platform.
 *
 *  Homepage:
 *  - http://wordpress.org/plugins/add-meta-tags/
 *  Documentation:
 *  - http://www.codetrax.org/projects/wp-add-meta-tags/wiki
 *  Development Web Site and Bug Tracker:
 *  - http://www.codetrax.org/projects/wp-add-meta-tags
 *  Main Source Code Repository (Mercurial):
 *  - https://bitbucket.org/gnotaras/wordpress-add-meta-tags
 *  Mirror repository (Git):
 *  - https://github.com/gnotaras/wordpress-add-meta-tags
 *  Historical plugin home:
 *  - http://www.g-loaded.eu/2006/01/05/add-meta-tags-wordpress-plugin/
 *
 *  Licensing Information
 *
 *  Copyright 2006-2015 George Notaras <gnot@g-loaded.eu>, CodeTRAX.org
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 *
 *  The NOTICE file contains additional licensing and copyright information.
 */


/**
 * Module containing the Add-Meta-Tags Command Line Interface.
 */

// Prevent direct access to this file.
if ( ! defined( 'ABSPATH' ) ) {
    header( 'HTTP/1.0 403 Forbidden' );
    echo 'This file should not be accessed directly!';
    exit; // Exit if accessed directly
}


if ( defined('WP_CLI') && WP_CLI ):


/**
 * Implements the Add-Meta-Tags command line interface.
 *
 * @package wp-cli
 * @subpackage commands/community
 * @maintainer George Notaras (http://www.g-loaded.eu)
 */
class AMT_Command extends WP_CLI_Command {

    /**
     * Prints a status message about Add-Meta-Tags installation. (not implemented)
     * 
     * ## EXAMPLES
     * 
     *     wp amt status
     *
     * @synopsis
     */
    function status( $args, $assoc_args ) {

/*
        if ( is_multisite() ) {
            $blog_list = get_blog_list( 0, 'all' );
        } else {
            $blog_list   = array();
            $blog_list[] = array( 'blog_id' => 1 );
        }

        foreach ( $blog_list as $blog ) {
            if ( is_multisite() ) {
                switch_to_blog( $blog['blog_id'] );
            }
            $plugin_info = get_plugin_data( plugin_dir_path( __FILE__ ) . 'add-meta-tags.php', $markup = true, $translate = true );
            WP_CLI::line( ' ' );
            WP_CLI::line( get_bloginfo('name') . ' - ' . $blog['blog_id'] );
            WP_CLI::line( $plugin_info['Version'] );
            WP_CLI::line( ' ' );
            if ( is_multisite() ) {
                restore_current_blog();
            }
        }

        // get_plugin_data( $plugin_file, $markup = true, $translate = true )
        //$plugin info = get_plugin_data( AMT_PLUGIN_DIR . 'add-meta-tags.php', $markup = true, $translate = true );
        // WP_CLI::line( ' ' );
        // WP_CLI::line( count( $field_groups ) . ' field groups found for blog_id ' . $blog['blog_id'] );

        // Print a success message
        WP_CLI::success( "Operation complete." );
*/
        WP_CLI::error('Not implemented');
    }


    /**
     * Upgrades the settings.
     * 
     * ## OPTIONS
     * 
     * [--network-wide]
     * : Perform the settings upgrade on all blogs of the network.
     * 
     * ## EXAMPLES
     * 
     *     wp amt upgrade
     *     wp amt upgrade --network-wide
     *
     * @synopsis [--network-wide]
     */
    function upgrade( $args, $assoc_args ) {

        // Multisite
        if ( $assoc_args['network-wide'] ) {
            if ( is_multisite() ) {
                $blog_list = get_blog_list( 0, 'all' );
                if ( empty($blog_list) ) {
                    WP_CLI::error('No blogs could be found.');
                }
                foreach ( $blog_list as $blog ) {
                    switch_to_blog( $blog['blog_id'] );
                    $plugin_info = get_plugin_data( plugin_dir_path( __FILE__ ) . 'add-meta-tags.php', $markup=true, $translate=true );
                    WP_CLI::line( 'Upgrading settings of: ' . get_bloginfo('name') . ' - (ID: ' . $blog['blog_id'] . ')' );
                    amt_plugin_upgrade();
                    restore_current_blog();
                }
                WP_CLI::success('Add-Meta-Tags settings have been upgraded network wide.');
            } else {
                WP_CLI::warning('No network detected. Reverting to signle site settings upgrade.');
            }
        }

        // Single site installation
        amt_plugin_upgrade();
        WP_CLI::success('Add-Meta-Tags settings have been upgraded.');

/*
        if ( is_multisite() ) {
            $blog_list = get_blog_list( 0, 'all' );
        } else {
            $blog_list   = array();
            $blog_list[] = array( 'blog_id' => 1 );
        }

        foreach ( $blog_list as $blog ) {
            if ( is_multisite() ) {
                switch_to_blog( $blog['blog_id'] );
            }
            $plugin_info = get_plugin_data( plugin_dir_path( __FILE__ ) . 'add-meta-tags.php', $markup = true, $translate = true );
            WP_CLI::line( 'Upgrading settings of: ' . get_bloginfo('name') . ' - (ID: ' . $blog['blog_id'] . ')' );
            amt_plugin_upgrade();
            if ( is_multisite() ) {
                restore_current_blog();
            }
        }
*/

        // get_plugin_data( $plugin_file, $markup = true, $translate = true )
        //$plugin info = get_plugin_data( AMT_PLUGIN_DIR . 'add-meta-tags.php', $markup = true, $translate = true );
        // WP_CLI::line( ' ' );
        // WP_CLI::line( count( $field_groups ) . ' field groups found for blog_id ' . $blog['blog_id'] );

        // Print a success message
        //WP_CLI::success( "Operation complete." );
    }


    /**
     * Export settings and data.
     * 
     * ## OPTIONS
     * 
     * <what>
     * : The type of data to be exported. Supported: settings|postdata|userdata
     * 
     * ## EXAMPLES
     * 
     *     wp amt export settings
     *     wp amt export postdata
     *     wp amt export userdata
     *
     * @synopsis <settings|postdata|userdata>
     */
    function export( $args, $assoc_args ) {
        list( $what ) = $args;

        if ( ! in_array($what, array('settings', 'postdata', 'userdata')) ) {
            WP_CLI::error( 'Invalid argument: ' . $what . ' (valid: settings|postdata|userdata)' );
        }

        $output = array();

        // Export AMT settings
        if ( $what == 'settings' ) {
            $output = get_option("add_meta_tags_opts");
            if ( empty($output) ) {
                WP_CLI::error( 'Could not retrieve Add-Meta-Tags options.' );
            }
            //var_dump( $options );
        }

        // Export AMT custom fields
        elseif ( $what == 'postdata' ) {
            $qr_args = array(
                'numberposts'       => -1,
                'post_type'         => 'any',
                'post_status'       => 'any',
                'orderby'           => 'id',
                'order'             => 'ASC',
                'suppress_filters'  => true,
            );
            $posts_arr = get_posts( $qr_args );
            $amt_post_fields = amt_get_post_custom_field_names();
            foreach ( $posts_arr as $post ) {
                foreach ( $amt_post_fields as $amt_post_field ) {
                    $amt_post_field_value = get_post_meta( $post->ID, $amt_post_field, true );
                    //var_dump($amt_field_value);
                    if ( ! empty($amt_post_field_value) ) {
                        // Export format: <post_id>;<amt_post_field>;<serialized_value>
                        //echo json_encode( sprintf( '%s;%s;%s', $post->ID, $amt_field, $amt_field_value ) );
                        $output[] = array($post->ID, $amt_post_field, $amt_post_field_value);
                    }
                }
            }
        }

        // Export AMT contact infos
        elseif ( $what == 'userdata' ) {
            $qr_args = array(
                'orderby'      => 'login',
                'order'        => 'ASC',
                'fields'       => 'all',
            );
            $users_arr = get_users( $qr_args );
            $amt_user_fields = amt_get_user_contactinfo_field_names();
            foreach ( $users_arr as $user ) {
                foreach ( $amt_user_fields as $amt_user_field ) {
                    $amt_user_field_value = get_the_author_meta( $amt_user_field, $user->ID );
                    if ( ! empty($amt_user_field_value) ) {
                        // Export format: <user_id>;<amt_user_field>;<serialized_value>
                        //echo json_encode( sprintf( '%s;%s;%s', $post->ID, $amt_field, $amt_field_value ) );
                        $output[] = array($user->ID, $amt_user_field, $amt_user_field_value);
                    }
                }
            }
        }

        // Print output
        if ( ! empty($output) ) {
            echo json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }

    }


    /**
     * Import settings and data.
     * 
     * ## OPTIONS
     * 
     * <what>
     * : The type of data to be imported. Supported: settings|postdata|userdata
     * 
     * ## EXAMPLES
     * 
     *     wp amt import settings
     *     wp amt import postdata
     *     wp amt import userdata
     *
     * @synopsis <settings|postdata|userdata>
     */
    function import( $args, $assoc_args ) {
        list( $what ) = $args;

        if ( ! in_array($what, array('settings', 'postdata', 'userdata')) ) {
            WP_CLI::error( 'Invalid argument: ' . $what . ' (valid: settings|postdata|userdata)' );
        }

        // Import AMT settings
        if ( $what == 'settings' ) {
            $data = json_decode( file_get_contents('php://stdin') );
            if ( empty($data) || ! is_array($data) ) {
                WP_CLI::error( 'No data found.' );
            }
            // Since all other options might come and go, we only check for the 'settings_version' key.
            if ( ! array_key_exists('settings_version', $data) ) {
                WP_CLI::error('Invalid data: not option data');
            }
            //var_dump( $options );
            update_option("add_meta_tags_opts", $data);
            amt_plugin_upgrade();
        }

        // Import AMT post custom fields
        elseif ( $what == 'postdata' ) {
            $data = json_decode( file_get_contents('php://stdin') );
            if ( empty($data) || ! is_array($data) || empty($data[0]) ) {
                WP_CLI::error( 'No data found.' );
            }
            $amt_post_fields = amt_get_post_custom_field_names();
            foreach ( $data[0] as $post_meta_info ) {
                // Format: array( <id>, <field_name>, <field_value> )
                if ( ! is_array($post_meta_info) || count($post_meta_info) != 3 || ! in_array( $post_meta_info[1], $amt_post_fields) || ! is_numeric($post_meta_info[0] ) ) {
                    WP_CLI::error('Invalid data: not post custom field data');
                }
                update_post_meta( $post_meta_info[0], $post_meta_info[1], $post_meta_info[2] );
            }

            WP_CLI::success( 'Add-Meta-Tags post data was imported successfully.' );
        }

        // Import AMT contact infos
        elseif ( $what == 'userdata' ) {
            $data = json_decode( file_get_contents('php://stdin') );
            if ( empty($data) || ! is_array($data) || empty($data[0]) ) {
                WP_CLI::error( 'No data found.' );
            }
            $amt_user_fields = amt_get_user_contactinfo_field_names();
            foreach ( $data[0] as $user_meta_info ) {
                // Format: array( <id>, <field_name>, <field_value> )
                if ( ! is_array($user_meta_info) || count($user_meta_info) != 3 || ! in_array( $user_meta_info[1], $amt_user_fields) || ! is_numeric($user_meta_info[0] ) ) {
                    WP_CLI::error('Invalid data: not user contact infos');
                }
                update_user_meta( $user_meta_info[0], $user_meta_info[1], $user_meta_info[2] );
            }

            WP_CLI::success( 'Add-Meta-Tags user data was imported successfully.' );
        }

    }


    /**
     * Delete settings, data and metadata cache.
     * 
     * ## OPTIONS
     * 
     * <what>
     * : The type of data to be removed. Supported: all|settings|postdata|userdata|cache
     * 
     * [--assume-yes]
     * : Run in non interactive mode.
     * 
     * ## EXAMPLES
     * 
     *     wp amt clean all
     *     wp amt clean settings
     *     wp amt clean postdata
     *     wp amt clean userdata
     *     wp amt clean cache
     *     wp amt clean cache --assume-yes
     *
     * @synopsis <all|settings|postdata|userdata|cache> [--assume-yes]
     */
    function clean( $args, $assoc_args ) {
        list( $what ) = $args;

        if ( ! in_array($what, array('all', 'settings', 'postdata', 'userdata', 'cache')) ) {
            WP_CLI::error( 'Invalid argument: ' . $what . ' (valid: all|settings|postdata|userdata|cache)' );
        }

        if ( $assoc_args['assume-yes'] ) {
            WP_CLI::line( ' ' );
            WP_CLI::line( 'Running in non-interactive mode.' );
            WP_CLI::line( 'Proceeding with ' . $what . ' cleanup...' );
        } else {
            // Confirmation
            WP_CLI::line( ' ' );
            WP_CLI::line( 'This commands deletes Add-Meta-Tags data from the database.' );
            WP_CLI::line( 'This action is final and cannot be undone.' );
            WP_CLI::line( ' ' );
            echo 'Are you sure you want to do this?  Type \'yes\' to continue: ';
            $handle = fopen( 'php://stdin', 'r' );
            $choice = fgets($handle);
            fclose($handle);
            if ( trim($choice) != 'yes' ) {
                WP_CLI::line( 'Aborting...' );
                exit;
            }
            WP_CLI::line( ' ' );
            WP_CLI::line( 'Proceeding with ' . $what . ' cleanup...' );
        }

        // Delete AMT settings
        if ( $what == 'settings' || $what == 'all' ) {
            delete_option('add_meta_tags_opts');
            WP_CLI::line( 'Deleted settings.' );
        }

        // Delete AMT post custom fields
        elseif ( $what == 'postdata' || $what == 'all' ) {
            $qr_args = array(
                'numberposts'       => -1,
                'post_type'         => 'any',
                'post_status'       => 'any',
                'orderby'           => 'id',
                'order'             => 'ASC',
                'suppress_filters'  => true,
            );
            $posts_arr = get_posts( $qr_args );
            $amt_post_fields = amt_get_post_custom_field_names();
            foreach ( $posts_arr as $post ) {
                foreach ( $amt_post_fields as $amt_post_field ) {
                    delete_post_meta( $post->ID, $amt_post_field );
                }
            }
            WP_CLI::line( 'Deleted post custom fields.' );
        }

        // Delete AMT contact infos
        elseif ( $what == 'userdata' || $what == 'all' ) {
            $qr_args = array(
                'orderby'      => 'login',
                'order'        => 'ASC',
                'fields'       => 'all',
            );
            $users_arr = get_users( $qr_args );
            $amt_user_fields = amt_get_user_contactinfo_field_names();
            foreach ( $users_arr as $user ) {
                foreach ( $amt_user_fields as $amt_user_field ) {
                    delete_user_meta( $user->ID, $amt_user_field );
                }
            }
            WP_CLI::line( 'Deleted user contact info fields.' );
        }

        // Delete transient metadata cache
        elseif ( $what == 'cache' || $what == 'all' ) {

            // Transients may not be cached in the database, but in a different storage backend.
            // So, here amt_delete_all_transient_metadata_cache() is not used.
            //$result = amt_delete_all_transient_metadata_cache();
            //WP_CLI::line( sprintf('Deleted %d transient metadata cache entries.', $result) );

            global $wpdb;

            // Get the current blog id.
            $blog_id = get_current_blog_id();

            // Construct the options table name for the current blog
            $posts_table = $wpdb->get_blog_prefix($blog_id) . 'posts';
            //var_dump($posts_table);

            // Construct SQL query that fetched the post IDs.
            $sql = "SELECT ID FROM $posts_table WHERE post_status = 'publish'";

            // Get number of cache entries
            $results = $wpdb->get_results($sql);

            foreach ( $results as $post) {
                // Delete the metadata cache for this post object
                amt_delete_transient_cache_for_post( absint($post->ID) );
            }

            WP_CLI::line( sprintf('Purged cached metadata of %d published post objects.', count($results)) );
        }

        WP_CLI::success( 'Data clean up complete.' );
    }

}

WP_CLI::add_command( 'amt', 'AMT_Command' );


endif;


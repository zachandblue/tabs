<?php


    /**
     * Theme setup.
     */
    add_action('after_setup_theme', 'wuxt_setup');
    function wuxt_setup() {

        add_theme_support('post-thumbnails');

    }


    add_action('init', 'wuxt_register_menu');
    function wuxt_register_menu() {
        register_nav_menu('main', __('Main meny'));
    }


    /**
    *  Include Custom post types
    */
    if ( is_dir(  dirname(__FILE__) . '/cpts/' ) ) {
      foreach ( scandir( dirname(__FILE__) . '/cpts/' ) as $filename ) {
          $path = dirname(__FILE__) . '/cpts/' . $filename;
          if ( is_file( $path ) ) {
              require_once( $path );
          }
      }
    }

    /**
    *  Include Taxonomies
    */
    if ( is_dir(  dirname(__FILE__) . '/taxonomies/' ) ) {
      foreach ( scandir( dirname(__FILE__) . '/taxonomies/' ) as $filename ) {
          $path = dirname(__FILE__) . '/taxonomies/' . $filename;
          if ( is_file( $path ) ) {
              require_once( $path );
          }
      }
    }


    /**
     * Customize the preview button in the WordPress admin to point to the headless client.
     *
     * @param  str $link The WordPress preview link.
     * @return str The headless WordPress preview link.
     */
    function set_headless_preview_link( $link ) {
    	if (WP_DEBUG === true) {
    		return 'http://localhost:3000/'
    			. '_preview/'
    			. get_the_ID() . '/'
    			. wp_create_nonce( 'wp_rest' );
    	} else {
    		return 'https://localhost:3000/'
    			. '_preview/'
    			. get_the_ID() . '/'
    			. wp_create_nonce( 'wp_rest' );
    	}
    }
    add_filter( 'preview_post_link', 'set_headless_preview_link' );


    add_action( 'rest_api_init', 'slug_register_yoast_seo_meta' );
        function slug_register_yoast_seo_meta() {
            register_rest_field( 'post',
                '_yoast_wpseo_title',
                array(
                    'get_callback'    => 'get_seo_meta_field',
                    'update_callback' => null,
                    'schema'          => null,
                )
            );
            register_rest_field( 'post',
                '_yoast_wpseo_metadesc',
                array(
                    'get_callback'    => 'get_seo_meta_field',
                    'update_callback' => null,
                    'schema'          => null,
                )
            );
        }

    function get_seo_meta_field( $object, $field_name, $request ) {
        return get_post_meta( $object[ 'id' ], $field_name, true );
    }

<?php
/**
 * Implements commands for madx Flow.
 */
class madxFlow_CLI extends WP_CLI_Command {

    /**
     * Checks if stylesheet exist. Creates it if it doesn't.
     * 
     * ## EXAMPLES
     * 
     *     wp madxflow make_css
     *
     * @synopsis
     */
    function make_css( $args, $assoc_args ) {
        if ( class_exists( 'TF_Styling_Control' ) ) {
            if ( TF_Model::create_stylesheets() ) {
                WP_CLI::success( "Stylesheet succesfully created." );
            } else {
                WP_CLI::error( "Could not create stylesheet." );
            }
        }
    }
}

WP_CLI::add_command( 'madxflow', 'madxFlow_CLI' );
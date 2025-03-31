<?php
        /*__________________________________________________
        |                                                  |
        |                     TWIM                         |
        |          Tiny Website Image Manager              |
        |                                                  |
        |                read-config.php                   |
        |                                                  |
        |      (c) PhiXi, 2025 (github.com/phi-xi)         |
        |__________________________________________________|*/


    $_VERSION           = "1.05";

    $_CONFIG_FILE       = "config.json";

    $_TARGET_DIR        = "../";

/*
==================== End of configuration ===================
*/

    $_CONFIG_JSON       = file_get_contents( $_CONFIG_FILE );
    $_CONFIG_DATA       = json_decode( $_CONFIG_JSON, true );

    if ( $_CONFIG_DATA === null ) http_response_code( 500 );

    $_IMG_MAX_SIZE      = $_CONFIG_DATA[ "max_image_size" ];
    $_IMG_MAX_COUNT     = $_CONFIG_DATA[ "max_image_count" ];
    $_IMG_FORMATS       = $_CONFIG_DATA[ "allowed_formats" ];


    function prettify_byte_quantity( $_value_in_bytes ){
        $_prefixes = [
            ""  => 1,
            "k" => 1000,
            "M" => 1000000,
            "G" => 1000000000,
            "T" => 1000000000000
        ];
        $_key = array_keys( $_prefixes );
        $_val = array_values( $_prefixes );
        for ( $i=0; $i < count( $_val )-1; $i++ ){
            $_v = $_val[ $i ];
            if ( $_value_in_bytes >= $_v
                && $_value_in_bytes < $_val[ $i+1 ] ){
                    $_value_pretty = $_value_in_bytes / $_v;
                    $_value_pretty = round( $_value_pretty );
                    return "$_value_pretty $_key[$i]B";
            }
        }
        return $_value_in_bytes . " B";
    }

    function get_thumbnail_HTML( $_img_filename ){
        global $_TARGET_DIR;
        $_img_path      = $_TARGET_DIR . $_img_filename;
        $_img_size      = filesize( $_img_path );
        $_img_size      = prettify_byte_quantity( $_img_size );
        return "<div class=\"ims-thumbnail-wrap\">"
            . "<img class=\"ims-thumbnail\" "
            . "src=\"$_img_path\"><br>$_img_filename<br>"
            . "$_img_size</div> ";
    }

?>

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


    $_CONFIG            = json_decode( file_get_contents( "config.json" ), true );

    if ( $_CONFIG === null ) http_response_code( 500 );

    $_IMG_MAX_SIZE      = $_CONFIG[ "max_image_size" ];
    $_IMG_MAX_COUNT     = $_CONFIG[ "max_image_count" ];
    $_IMG_FORMATS       = $_CONFIG[ "allowed_formats" ];
    $_TARGET_DIR        = "../";
    $_VERSION           = "1.04";
?>

<?php
        /*__________________________________________________
        |                                                  |
        |                   DirbIMS                        |
        |      Directory-based Image Management System     |
        |                                                  |
        |                  index.php                       |
        |                                                  |
        |    (c) PhiXi, 2025 (https://github.com/phi-xi)   |
        |__________________________________________________|*/

    include_once "read-config.php";

    $_f             = $_FILES[ "file" ];
    $_target_file   = $_TARGET_DIR . basename( $_f[ "name" ] );
    $_type          = $_f[ "type" ];
    $_size          = $_f[ "size" ];
    $_msg           = "Upload failed";
    $_img_count     = count( scandir( $_TARGET_DIR ) - 3 ); // ignore '.', '..', 'ims/'

    if ( ( $_size <= $_IMG_MAX_SIZE )
        && ( substr( $_type, 0, 5 ) == "image" )
        && ( $_img_count <= $_IMG_MAX_COUNT ) ){
            if ( move_uploaded_file( $_f[ "tmp_name" ], $_target_file ) ){
                $_msg = "Upload successful";
            }
    }
?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
        <title>IMS | Image Management System</title>
        <link rel="icon" href="/img/icon-phixi.svg">
        <link rel="stylesheet" href="ims.css">
        <script type="text/javascript" src="/script/js/utils.js"></script>
    </head>
    <body>
        <div class="ims-main" style="padding-top: 30vh;">
            <h1><?php echo($_msg);?></h1>
            <br><br><br>
            <div id="msg" style="text-align:left;margin-left:45vw;">Please wait...</div>
        </div>
    </body>
    <script type="text/javascript">
        let msg = U.r( "msg" ),
            c = 0;
        setInterval( ()=>{
            if ( c > 8 ) window.location.href = "./";
            msg.innerHTML += ".";
            c++;
        }, 250 );
    </script>
</html>

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

    $_file          = $_POST[ "files" ];
    $_file          = urldecode( $_file );
    $_file_set      = explode( ",", $_file );
    $_deleted_cnt   = 0;
    $_msg           = "Failure deleting images";

    for ( $i=0; $i < count( $_file_set ); $i++ ){
        $_f             = $_file_set[ $i ];
        $_f             = preg_replace( "/.*\//", "", $_f );
        $_target_file   = $_TARGET_DIR . $_f;
        if ( unlink( $_target_file ) ) $_deleted_cnt++;
    }
    if ( $_deleted_cnt > 0 ) $_msg = "$_deleted_cnt Image(s) deleted";
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

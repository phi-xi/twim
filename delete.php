<?php
        /*__________________________________________________
        |                                                  |
        |                     TWIM                         |
        |          Tiny Website Image Manager              |
        |                                                  |
        |                  delete.php                      |
        |                                                  |
        |      (c) PhiXi, 2025 (github.com/phi-xi)         |
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
    if ( $_deleted_cnt > 0 ) $_msg = "Deleting $_deleted_cnt image(s)";
?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
        <title>TWIM | Tiny Website Image Manager</title>
        <link rel="icon" href="/img/icon-phixi.svg">
        <link rel="stylesheet" href="twim.css">
        <script type="text/javascript" src="twim.js"></script>
    </head>
    <body>
        <div class="ims-main" style="padding-top: 20vh;">
            <h1>TWIM</h1>
            <h2>Tiny Website Image Manager <?php echo($_VERSION);?></h2>
            <br>
            <h3><?php echo($_msg);?></h3>
            <br><br><br>
            <h3 id="msg" style="text-align:left;margin-left:45vw;">Please wait...</h3>
        </div>
    </body>
    <script type="text/javascript">
        let msg = U.r( "msg" ),
            c = 0;
        setInterval( ()=>{
            if ( c > 12 ){
                msg.innerHTML = "Done."
            } else {
                msg.innerHTML += ".";
            }
            if ( c > 16 ) window.location.href = "./";
            c++;
        }, 250 );
    </script>
</html>

<?php
        /*__________________________________________________
        |                                                  |
        |                     TWIM                         |
        |          Tiny Website Image Manager              |
        |                                                  |
        |                  upload.php                      |
        |                                                  |
        |      (c) PhiXi, 2025 (github.com/phi-xi)         |
        |__________________________________________________|*/


    include_once "read-config.php";

    $_files_count   = count( $_FILES[ "file" ][ "name" ] );
    $_uploaded_cnt  = 0;
    $_msg           = "Failure uploading file(s)";

    for ( $i=0; $i < $_files_count; $i++ ){
        $_f             = $_FILES[ "file" ];
        $_target_file   = $_TARGET_DIR . basename( $_f[ "name" ][ $i ] );
        $_type          = $_f[ "type" ][ $i ];
        $_size          = $_f[ "size" ][ $i ];
        $_msg           = "Upload failed";
        $_img_count     = count( scandir( $_TARGET_DIR ) ) - 3; // ignore '.', '..', 'twim/'
        if ( ( $_size <= $_IMG_MAX_SIZE )
            && ( substr( $_type, 0, 5 ) == "image" )
            && ( $_img_count <= $_IMG_MAX_COUNT ) ){
                if ( move_uploaded_file( $_f[ "tmp_name" ][ $i ], $_target_file ) ){
                    $_uploaded_cnt++;
                }
        }
    }
    if ( $_uploaded_cnt > 0 ) $_msg = "Uploading $_uploaded_cnt image(s)";
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
        <div class="ims-main" style="padding-top: 30vh;">
            <h1>TWIM | Tiny Website Image Manager <?php echo($_VERSION);?></h1>
            <h2><?php echo($_msg);?></h2>
            <br><br><br>
            <h2 id="msg" style="text-align:left;margin-left:45vw;">Please wait...</h2>
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

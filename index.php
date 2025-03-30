<?php
        /*__________________________________________________
        |                                                  |
        |                     TWIM                         |
        |          Tiny Website Image Manager              |
        |                                                  |
        |                  index.php                       |
        |                                                  |
        |      (c) PhiXi, 2025 (github.com/phi-xi)         |
        |__________________________________________________|*/


    include_once "read-config.php";

    $_img_files         = scandir( $_TARGET_DIR );
    $_img_count         = 0;
    $_img_gallery_src   = "";

    for ( $i=0; $i < count( $_img_files ); $i++ ){
        $_img = $_img_files[ $i ];
        $_xp = explode( ".", $_img );
        if ( $_img == ".." || $_img == "." )        continue;
        if ( substr( $_img, -1 ) == "/" )           continue;
        if ( count( $_xp ) < 2 )                    continue;
        if ( !in_array( $_xp[1], $_IMG_FORMATS ) )  continue;
        $_img_src = $_TARGET_DIR . $_img;
        $_img_gallery_src .= "<div class=\"ims-thumbnail-wrap\"><img class=\"ims-thumbnail\" src=\"$_img_src\"><br>$_img</div> ";
        $_img_count++;
    }
?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
        <title>TWIM | Tiny Website Image Manager</title>
        <link rel="icon" href="/img/icon-phixi.svg">
        <link rel="stylesheet" href="twim.css?2">
        <script type="text/javascript" src="twim.js"></script>
    </head>
    <body>
        <div class="ims-main ims-dark">
            <h1>TWIM | Tiny Website Image Manager <?php echo($_VERSION);?></h1>
            <div class="ims-gallery">
<?php
    echo( $_img_gallery_src );
?>
            </div>
            <div class="ims-ctrl">
                <div class="inline" style="margin-left: 1rem; vertical-align: top;">
                    <label class="ims-label">Image count</label>
                    <b style="font-size:1.2rem;"><?php echo($_img_count);?></b>
                    <label class="ims-label">Max. image count</label>
                    <b style="font-size:1.2rem;"><?php echo($_IMG_MAX_COUNT);?></b>
                    <label class="ims-label">Max. image size<br>(reduces larger images)</label>
                    <b style="font-size:1.2rem;"><?php echo($_IMG_MAX_SIZE/1000000);?> MB</b>
                </div>

                <div class="inline" style="vertical-align: top;">
                    <form class="ims-form">
                        <label class="ims-label" for="mode-dark">Dark mode</label>
                        <input name="mode-dark" id="mode-dark" class="ims-input" type="checkbox" checked>
                        <br><br>
                        <label class="ims-label" for="mode-xl">XL thumbs</label>
                        <input name="mode-xl" id="mode-xl" class="ims-input" type="checkbox">
                    </form>
                </div>

                <div class="inline" style="vertical-align: top;">
                    <form class="ims-form" enctype="multipart/form-data" action="upload.php" method="POST">
                        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo($_IMG_MAX_SIZE);?>">
                        <input name="file[]" id="file" class="ims-input" type="file" style="display:none;" multiple>
                        <input class="ims-input" type="submit" id="btn-submit-upload" value="&#x1f5c1; Upload" style="display:none;">
                    </form>
                    <br>
                    <form class="ims-form" action="javascript:void(0)">
                        <input class="ims-input" type="submit" id="btn-upload" value="&#x1f5c1; Upload" style="display:inline-block">
                        <input class="ims-input" type="submit" id="btn-delete" value="&#x1f5d1; Delete" style="display:inline-block">
                    </form>
                </div>

                <div class="inline" style="vertical-align: top;">
                    <form class="ims-form" enctype="multipart/form-data" action="delete.php" method="POST">
                        <input class="ims-input" type="hidden" id="files" name="files">
                        <input class="ims-input" type="submit" id="btn-submit-delete" value="&#x1f5d1; Delete" style="display:none;">
                    </form>
                </div>

                <div class="inline" style="display: inline-block; margin-right: 1rem; width: 20em; vertical-align: top;">
                        <label class="ims-label">___/ A b o u t \___</label>All file operations have immediate effect on the server's directory. Images exceeding max. size are reduced as much as necessary. Note that the file selector opened on press
                        <br><b style="line-height:1em; margin-left: 5em;">&#x1f5c1; Upload</b>
                        <br>supports selection of multiple files (select with CTRL pressed).
                        <br><b>&#x00a9; &Phi;&Xi;PhiXi</b>|2025|github.com/phi-xi
                </div>
            </div>
        </div>
    </body>
    <script type="text/javascript">
        const
            MAIN                = U.r( "ims-main" )[0],
            FORM                = U.r( "ims-form" ),
            IMG_THUMB           = U.r( "ims-thumbnail" ),
            CTRL                = U.r( "ims-ctrl" )[0].children,
            CHECKBOX_1          = U.r( "mode-dark" ),
            CHECKBOX_2          = U.r( "mode-xl" ),
            FILES               = U.r( "files" ),
            BTN_DELETE          = U.r( "btn-delete" ),
            BTN_UPLOAD          = U.r( "btn-upload" ),
            BTN_SUBMIT_DELETE   = U.r( "btn-submit-delete" ),
            BTN_SUBMIT_UPLOAD   = U.r( "btn-submit-upload" ),
            FILE_SELECT         = U.r( "file" );

        function __display( e, state=true ){
            e.style.display = ( state ) ? "" : "none";
        }
        function show_btn_delete(){
            __display( BTN_DELETE, true );
        }
        function hide_btn_delete(){
            __display( BTN_DELETE, false );
        }
        function is_img_selected( img ){
            return img.parentElement.className.includes( "ims-selected" );
        }
        function get_selected(){
            let selection = [];
            for ( let i=0; i < IMG_THUMB.length; i++ ){
                let img = IMG_THUMB[ i ];
                if ( is_img_selected( img ) ){
                    selection.push( img.src.replace( /.*\//g, "" ) );
                }
            }
            return selection;
        }
        function update_selection(){
            FILES.value = get_selected().toString();
        }


        for ( let i=0; i < IMG_THUMB.length; i++ ){
            IMG_THUMB[ i ].addEventListener( "click", function(){
                this.parentElement.classList.toggle( "ims-selected" );
                update_selection();
                if ( get_selected().length > 0 ){
                    show_btn_delete();
                } else {
                    hide_btn_delete();
                }
            } );
        }

        CHECKBOX_1.addEventListener( "change", function(){
            MAIN.classList.toggle( "ims-dark" );
        } );

        CHECKBOX_2.addEventListener( "change", function(){
            for ( let i=0; i < IMG_THUMB.length; i++ ){
                IMG_THUMB[ i ].classList.toggle( "ims-thumbnail-xl" );
                IMG_THUMB[ i ].parentElement.classList.toggle( "ims-thumbnail-xl" );
            }
        } );

        BTN_UPLOAD.addEventListener( "click", function(){
            FILE_SELECT.click();
        } );

        BTN_DELETE.addEventListener( "click", function(){
            U.ui.dialog.confirm( "Delete selected?", ()=>{
                BTN_SUBMIT_DELETE.click();
            }, ()=>{} );
        } );

        FILE_SELECT.addEventListener( "change", ()=>{
            if ( FILE_SELECT.files.length > 0 ) BTN_SUBMIT_UPLOAD.click();
        } );

        hide_btn_delete();

    </script>
</html>

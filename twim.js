
        /*__________________________________________________
        |                                                  |
        |                     TWIM                         |
        |          Tiny Website Image Manager              |
        |                                                  |
        |                    twim.js                       |
        |                                                  |
        |      (c) PhiXi, 2025 (github.com/phi-xi)         |
        |__________________________________________________|*/


const U = ( function(){

    const COLOR_CHANNEL_MAX = 255;

    let state = {
        toastDiv: false,
        tabScroll: false
    };

    function addPadding( n, padding="0" ){
        while ( n.length < 2 ){
            n = padding + n;
        }
        return n;
    }
    function colorHexToDec( hexColor ){
        if ( hexColor.length > 6 ) hexColor = hexColor.slice(1);
        let r = parseInt( hexColor.slice(0,2), 16 ),
            g = parseInt( hexColor.slice(2,4), 16 ),
            b = parseInt( hexColor.slice(4), 16 );
        return { r: r, g: g, b: b };
    }
    function colorDecToHex( r, g, b ){
        let hexColor = "";
        hexColor += addPadding( r.toString(16) );
        hexColor += addPadding( g.toString(16) );
        hexColor += addPadding( b.toString(16) );
        return hexColor;
    }
    function imgIsLandscapeOriented( imgElement ){
        return ( imgElement.clientWidth > imgElement.clientHeight );
    }
    function __selfDestroy(){
        document.body.removeChild( this );
        delete this;
    }
    function __showOverlayWithImg(){
        let o = getOverlay(),
            c = this.cloneNode( true );
        c.classList.remove( "img" );
        if ( imgIsLandscapeOriented( this ) ){
            c.style.width = "95vw";
        } else {
            c.style.height = "95vh";
        }
        setTimeout( ()=>{
            c.scrollIntoView();
            let correction = ( window.innerHeight - c.clientHeight ) / ( -2 );
            window.scrollBy( 0, correction );
        }, 100 );
        o.appendChild( c );
        document.body.appendChild( o );
        o.style.marginTop = window.scrollY;
        return o;
    }
    function getOverlay(){
        let o = U.mk( "div", "overlay" );
        o.addEventListener( "click", __selfDestroy );
        o.addEventListener( "wheel", __selfDestroy );
        return o;
    }

    return {

        r: ( n ) => {
            return document.getElementById( n )
                || document.getElementsByClassName( n )
                || document.getElementsByTagName( n );
        },
        mk: ( e="div", cn="" ) => {
            let _e = document.createElement( e );
            _e.className = cn;
            return _e;
        },
        ui: {
            client: {
                isMobile: window.navigator.userAgentData.mobile
            },
            state: () => {
                return state;
            },
            form: ( elementOrIdx ) => {
                return {
                    getData: () => {},
                    submit: () => {}
                };
            },
            dialog: {
                toast: ( msg ) => {
                    if ( !state.toastDiv ){
                        state.toastDiv = U.mk( "div", "toast" );
                        state.toastDiv.innerHTML = msg + "<br><br><button class='btn'>OK</button>";
                        state.toastDiv.onclick = ()=>{
                            document.body.removeChild( state.toastDiv );
                            state.toastDiv = false;
                        };
                        document.body.appendChild( state.toastDiv );
                    }
                },
                confirm: ( msg, onOk, onCancel ) => {
                    let div = U.mk( "div", "toast" );
                    div.innerHTML = msg + "<br><br><button class='btn'>OK</button><spacer></spacer><button class='btn'>Cancel</button>";
                    div.children[2].onclick = ()=>{
                        onOk();
                        document.body.removeChild( div );
                    };
                    div.children[4].onclick = ()=>{
                        onCancel();
                        document.body.removeChild( div );
                    };
                    document.body.appendChild( div );
                }
            },
            images: {
                makeMaximizable: () => {
                    const images = document.getElementsByTagName( "img" );
                    for ( let i=0; i < images.length; i++ ){
                        let img = images[ i ];
                        img.addEventListener( "click", __showOverlayWithImg.bind( img ) );
                    }
                }
            }
        }
    };

} )();

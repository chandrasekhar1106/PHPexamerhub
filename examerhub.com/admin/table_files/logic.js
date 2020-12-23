
var creative = {};

/**
 * Window onload handler.
 */
function preInit() {
  setupDom();

  if (Enabler.isInitialized()) {
    init();
  } else {
    Enabler.addEventListener(
      studio.events.StudioEvent.INIT,
      init
    );
  }
}

/**
 * Initializes the ad components
 */
function setupDom() {
  creative.dom = {};
  creative.dom.mainContainer = document.getElementById('mainContainer');
  creative.dom.exit = document.getElementById('exit');
  creative.dom.feature = document.getElementById('featureContainer');
}

/**
 * Ad initialisation.
 */
function init() {

  addListeners();

  // Polite loading
  if (Enabler.isVisible()) {
    startAd();
  }
  else {
    Enabler.addEventListener(studio.events.StudioEvent.VISIBLE, startAd);
  }
}
/*!
 * start the ad
 **/
function startAd()
{
	var loading = document.getElementById("loading");
	//var content = document.getElementById("content");
	
	loading.parentNode.removeChild(loading);
	creative.dom.exit.style.display = "block";
  	creative.dom.feature.style.visibility  = 'visible';
	
	show();
}
/**
 * Adds appropriate listeners at initialization time
 */
function addListeners() {
  creative.dom.exit.addEventListener('click', exitClickHandler);
}

/**
 *  Shows the ad.
 */
function show() {
  

  var freeDigitalText = document.getElementById("freeDigitalText");
  var logo = document.getElementById("logo");


  tl = new TimelineLite();

  tl.to(text1, 0.02 , { opacity:1, ease:Quad.easeIn} )
  tl.to(castImg, 0.02, { opacity:1, ease:Quad.easeIn },"-=0.02" )
  //hide1 text1 show text2
  tl.to(text1, 0.02, { opacity:0, ease:Quad.easeIn },"+=1.4" )
  tl.to(text2, 0.02, { opacity:1, ease:Quad.easeIn },"+=.02" )
  //hide1 frame1 show frame2
  tl.to([text2, castImg], 0.02, { opacity:0, ease:Quad.easeIn },"+=1.7" )
  tl.to([digitalUnblocked, cta, logo, text3], 0.02, { opacity:1, ease:Quad.easeIn },"+=0" )
  
  

}

// ---------------------------------------------------------------------------------
// MAIN
// ---------------------------------------------------------------------------------

function exitClickHandler() {
  Enabler.exit('BackgroundExit');
  tl.progress(1, false);
}

function replayHandler(e) {
    tl.pause(0, true);
    show();
}

/**
 *  Main onload handler
 */
window.addEventListener('load', preInit);
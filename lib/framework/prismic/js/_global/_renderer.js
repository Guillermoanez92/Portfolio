/*
	Load Plugins / Functions
-------------------------------------------------- */
import { hasClass, getViewport, tracking, beforeScroll, afterScroll } from "./helpers";
import { LazyLoadWorker } from "../_worker/LazyLoadWorker";
import { globalStorage } from "../_global/storage";
import { globalEntrance, pageEntrance } from "../_global/anims";
import { ScrollBasedAnims } from "../_classes/ScrollBasedAnims";

/* --- Scroll variable --- */
export let $scroll;

/* --- Setup our Image workers --- */
let imageLoadOptions = {
	dataAttr: "preload"
};

export let ImageLoad = new LazyLoadWorker(globalStorage.assetPath + "image-load.js", imageLoadOptions);

/* --- Global Events - Fire on Every Page --- */
const globalEvents = (namespace = null)=>{

	globalStorage.namespace = namespace;

	/* --- Set our preload callback images sizes --- */
	let type = "mobile";

	if(globalStorage.windowWidth > 767 && !hasClass(document.body, "force-mobile")){
		type = "desktop";
	}

	/*
	 *	Load Critical Images
	 *
	 *	The callback is meant to fire DOM Critical related
	 *	global functions. Everything page specific needs to
	 *	go within it's respective file.
	 */
	let criticalMedia = document.querySelectorAll('.preload-critical');

	ImageLoad.loadImages(criticalMedia, "nodeList", (returned)=>{
		/* --- Critical Done --- */
		globalEntrance();

		let transitionFinished = setInterval(()=>{

			if(globalStorage.transitionFinished === true){

				clearInterval(transitionFinished);

				beforeScroll();

				$scroll = new ScrollBasedAnims({});

				afterScroll();

				pageEntrance(namespace);


			}
		}, 20);

	});
};

/* --- DOMContentLoaded Function --- */
export const onReady = ()=>{

	globalStorage.windowHeight = getViewport().height;
	globalStorage.windowWidth = getViewport().width;

	let vh = getViewport().height * 0.01;

	globalStorage.isGreaterThan767 = (globalStorage.windowWidth > 767 && !document.body.classList.contains("force-mobile"));

	document.body.style.setProperty('--vh', `${vh}px`);

	let type = "mobile";

	if(globalStorage.isGreaterThan767 || document.body.classList.contains("force-mobile")){
		type = "desktop";
	}

	globalStorage.vhDiff = (document.getElementById('vh-measure-el').offsetHeight - window.innerHeight);

	ImageLoad.size = type;

	document.body.style.setProperty('--vh', `${vh}px`);

	/* --- This needs to stay here --- */
	globalEvents();
};

/* --- window.onload Function --- */
export const onLoad = ()=>{

};

/* --- window.onresize Function --- */
export const onResize = ()=>{

	globalStorage.windowHeight = getViewport().height;
	globalStorage.windowWidth = getViewport().width;

	let vh = globalStorage.windowHeight * 0.01;

	document.body.style.setProperty('--vh', `${vh}px`);

	$scroll.resize();
};

/*
 *	Highway NAVIGATE_OUT callback
 *
 *	onLeave is fired when a highway transition has been
 *	initiated. This callback is primarily used to unbind
 *	events, or modify global settings that might be called
 *	in onEnter/onEnterCompleted functions.
 */
export const onLeave = (from, trigger, location)=>{

	/* --- Remove our scroll measurements --- */
	$scroll.destroy();

	/* --- Flag transition for load in animations --- */
	globalStorage.transitionFinished = false;
};

/*
 *	Highway NAVIGATE_IN callback
 *
 *	onEnter should only contain event bindings and non-
 *	DOM related event measurements. Both view containers
 *	are still loaded into the DOM during this callback.
 */
export const onEnter = (to, trigger, location)=>{

	/* --- This needs to stay here --- */
	globalEvents(to.view.dataset.routerView);
};

/*
 *	Highway NAVIGATE_END callback
 *
 *	onEnterCompleted should be your primary event callback.
 *	The previous view's DOM node has been removed when this
 *	event fires.
 */
export const onEnterCompleted = (from, to, trigger, location)=>{

	/* --- Track Page Views through Ajax --- */
	tracking("google", "set", "page", location.pathname);
	tracking("google", "send", {
		hitType: "pageview",
		page: location.pathname,
		title: to.page.title
	});
};

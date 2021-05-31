import { gsap, Sine } from "gsap";
import { globalStorage } from "./storage";
import { $scroll } from "../_global/_renderer";

/*
	Page specific animations
-------------------------------------------------- */
export const pageEntrance = (namespace = null)=>{

	/* ----- Establish our timeline ----- */
	let timeline = new gsap.timeline({ paused: true });

	/* ----- Setup cases for specific load-ins ----- */
	switch(namespace){

		case "home":

			timeline.add(()=>{ console.log("home anims in go here"); });
			timeline.play();

			break;

		/* ----- Our default page entrance ----- */
		default:

			timeline.add(()=>{ console.log("default anims in go here"); });
			timeline.play();

			break;
	}
};

/*
	Global element animations
-------------------------------------------------- */
let firstLoad = false;

export const globalEntrance = ()=>{

	if(firstLoad === true){
		return;
	}

	/* ----- Establish our timeline ----- */
	let timeline = new gsap.timeline({ paused: true });

	timeline.to("#global-mask", 0.5, { autoAlpha: 0, ease: Sine.easeInOut, onComplete: ()=>{ globalStorage.transitionFinished = true; }});

	timeline.play();
	firstLoad = true;
};


export const prepDrawers = () => {
	let drawers;
	if (globalStorage.isGreaterThan767) {
		drawers = document.querySelectorAll(".drawer:not(.mobile-only):not(.bound)");
	} else {
		drawers = document.querySelectorAll(".drawer:not(.bound)");
	}

	for (let i = 0; i < drawers.length; i++) {
		const thisDrawer = drawers[i];
		const isAbsolute = thisDrawer.classList.contains('absolute');
		const animate = thisDrawer.classList.contains('animate');
		const allowsPropagation = thisDrawer.classList.contains('propagate');

		thisDrawer.classList.add("bound");

		const childrenWrapper = thisDrawer.querySelector(".drawer-content");
		const childrenWrapperHeight = childrenWrapper.getBoundingClientRect().height;

		thisDrawer.addEventListener("click", (event) => {
			if (!allowsPropagation) {
				event.stopPropagation();
			}
			if (!thisDrawer.classList.contains("open")) {
				const openDrawers = document.querySelectorAll(".drawer.open");
				for (let i = 0; i < openDrawers.length; i++) {
					openDrawers[i].classList.remove("open");
					if (animate) {
						gsap.to(openDrawers[i].querySelector(".drawer-content"), 0.4, { height: 0, ease: "expo.inOut", force3D: true, clearProps: "transform" });
					} else {
						gsap.set(openDrawers[i].querySelector(".drawer-content"), { height: 0 });
					}

				}
				thisDrawer.classList.add("open");

				if (animate) {
					gsap.to(childrenWrapper, 0.4, { height: childrenWrapperHeight, ease: "expo.inOut", force3D: true });
				} else {
					gsap.set(childrenWrapper, { height: childrenWrapperHeight });
				}

			} else {
				thisDrawer.classList.remove("open");

				if (animate) {
					gsap.to(childrenWrapper, 0.4, { height: 0, ease: "expo.inOut", force3D: true, clearProps: "transform" });
				} else {
					gsap.set(childrenWrapper, { height: 0 });
				}
			}

			if(typeof $scroll == "object" && !isAbsolute) $scroll.resize();
		});

		gsap.set(childrenWrapper, { height: 0 });

		if (!allowsPropagation) {
			childrenWrapper.addEventListener('click', (event) => {
				event.stopPropagation();
			});
		}
	}
	globalStorage.drawersReady = true;

}

export const prepMarquees = (els) => {
	let window2x = globalStorage.windowWidth * 2;

	globalStorage.marqueeData = [];

	for (let i = 0; i < els.length; i++) {
		let marquees = els[i].querySelectorAll('.marquee'),
			tweens = [];

		for (let j = 0; j < marquees.length; j++) {
			let p = marquees[j].querySelector('p'),
				inner = marquees[j].querySelector('.inner'),
				pWidth = p.getBoundingClientRect().width,
				multiplier = Math.ceil(window2x / pWidth);

			for (let q = 0; q < multiplier; q++) {
				let duplicate = p.cloneNode(true);
				inner.appendChild(duplicate);
			}
			let odd = (j % 2 !== 0);
			tweens.push(gsap.fromTo(inner, (60 + (j * 18)), { xPercent: 0 }, { repeat: -1, xPercent: odd ? 100 : -100, ease: "none", force3D: true }, 0).pause());
		}

		globalStorage.marqueeData.push({
			parentEl: els[i],
			tweens: tweens,
			playing: false
		});

	}
};
import { gsap } from "gsap";
import { getViewport } from "../_global/helpers";

export const hobbyTabs = () => {
	const triggers = document.querySelectorAll('.hobbies .tab-wrapper button')
	const allImageWrappers = document.querySelector('.all-hobby-images')
	const imageWrappers = allImageWrappers.querySelectorAll('.hobby-images')
	console.log(triggers)
	for (let i = 0; i < triggers.length; i++){
		triggers[i].addEventListener('click', () => {
			allImageWrappers.querySelector('.active').classList.remove('active')
			imageWrappers[i].classList.add('active')

		})
	}
}

export const infiniteMarquee = (el) => {
	let windowWidth = getViewport().width;
	let marquee = el.querySelector(".inner")
	let sliderEl = el.querySelector(".track")
	let multiplier = Math.ceil((windowWidth *2) / marquee.offsetWidth);

	for (let i = 1; i < multiplier; i++){
		let elementCopy = marquee.cloneNode(true);
		sliderEl.appendChild(elementCopy);
	}
	let xDist = el.querySelector(".inner:nth-child(2)").getBoundingClientRect().left;

	gsap.fromTo(sliderEl, 12, { x: 0 }, { x: -xDist, repeat: -1, ease: "none" })
}

export class infiniteMarquees {
	constructor(el){
		this.marquee = el.querySelector(".inner")
		this.sliderEl = el.querySelector(".track")
		this.el = el
		this.playing = false;
		this.getCache()
	}

	getCache() {
		this.windowWidth = getViewport().width;
		this.multiplier = Math.ceil((this.windowWidth *2) / this.marquee.offsetWidth);
		for (let i = 1; i <this.multiplier; i++){
			let elementCopy = this.marquee.cloneNode(true);
			this.sliderEl.appendChild(elementCopy);
		}
		this.xDist = this.el.querySelector(".inner:nth-child(2)").getBoundingClientRect().left;
		this.tween = gsap.fromTo(this.sliderEl, 12, { x: 0 }, { x: -this.xDist, repeat: -1, ease: "none" })
		this.tween.pause()
	}

	pause(){
		if (this.playing) {
			this.playing = false;
			this.tween.pause()
		}
	}

	play(){
		if (!this.playing) {
			this.playing = true;
			this.tween.play()
		}
	}

	resize() {
		this.getCache()
	}
}

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

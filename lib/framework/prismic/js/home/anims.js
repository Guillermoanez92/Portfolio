import { gsap } from "gsap";

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

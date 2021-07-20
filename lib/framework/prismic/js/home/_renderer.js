import Highway from "@dogstudio/highway";
import {hobbyTabs, infiniteMarquee, infiniteMarquees} from "./anims"

/*
    View Events for Highway

	- Home Page
    - Events are listed in their execution order
-------------------------------------------------- */
export let logoMarquee;
class HomeRenderer extends Highway.Renderer {

	onEnter() {
		hobbyTabs()

		let marqueeWrapper = document.querySelector(".logos")
		logoMarquee = new infiniteMarquees(marqueeWrapper)
	}

	onEnterCompleted() {
		console.log("onEnterCompleted");
	}

	onLeave() {
		console.log("onLeave");
	}

	onLeaveCompleted() {
		console.log("onLeaveCompleted");
	}
}

export default HomeRenderer;

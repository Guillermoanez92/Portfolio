import Highway from "@dogstudio/highway";

/*  
    View Events for Highway

	- Home Page
    - Events are listed in their execution order
-------------------------------------------------- */
class HomeRenderer extends Highway.Renderer {
	
	onEnter() {
		console.log("home");
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

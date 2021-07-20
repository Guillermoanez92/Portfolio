import { gsap } from "gsap";
import { globalStorage, domStorage } from "../_global/storage";
import {$renderEngine, ImageLoad} from "../_global/_renderer";
import { logoMarquee } from "../home/_renderer";


export class ScrollBasedAnims {
	constructor(options = {}) {
		this.bindMethods();
		this.el = document.documentElement;
		this.currentView = this.el.querySelector('[data-router-view]:last-child');

		this.thisPagesTLs = [];
		this.offsetVal = 0;
		this.body = document.body;
		this.direction = 'untouched';
		this.transitioning = false;
		this.headerScrolled = false;
		this.adjustHeaderDist = globalStorage.windowWidth > 959 ? 150 : 150;

		if (globalStorage.namespace === "products") {
			this.fixedAtcEl = document.querySelector('.fixed-atc');
		}

		const {
			dataFromElems = this.currentView.querySelectorAll('[data-from]'),
			dataHeroFromElems = this.currentView.querySelectorAll('[data-h-from]'),
			heroMeasureEl = this.currentView.querySelector('.hero-measure-el'),
			scrollBasedElems = this.currentView.querySelectorAll('[data-entrance]'),
			threshold = 0.01
		} = options;

		this.dom = {
			el: this.el,
			dataFromElems: dataFromElems,
			dataHeroFromElems: dataHeroFromElems,
			scrollBasedElems: scrollBasedElems,
			heroMeasureEl: heroMeasureEl
		};

		this.dataFromElems = null;
		this.dataHeroFromElems = null;
		this.scrollBasedElems = null;

		this.raf = null;

		this.state = {
			resizing: false
		};

		let startingScrollTop = this.el.scrollTop;
		this.data = {
			threshold: threshold,
			current: startingScrollTop,
			target: 0,
			last: startingScrollTop,
			ease: 0.075,
			height: 0,
			max: 0,
			scrollY: startingScrollTop,
			window2x: globalStorage.windowHeight * 2
		};

		this.el.addEventListener('scroll', this.run(), true);

		if (globalStorage.windowWidth > 767) {
			let length = this.dom.scrollBasedElems.length;
			for (let i = 0; i < length; i++) {
				const entranceEl = this.dom.scrollBasedElems[i];
				const entranceType = entranceEl.dataset.entrance;
				const entranceTL = new gsap.timeline({ paused: true });
				let staggerEls;

				switch (entranceType) {

					case "stagger-fade":
						staggerEls = entranceEl.querySelectorAll('.s-el');
						const staggerTwistEls = entranceEl.querySelectorAll('.s-el-twist');
						let delay = 0;

						if (staggerTwistEls.length > 0) {
							entranceTL
								.fromTo(staggerTwistEls, 1, { y: 100, rotation: 13 }, { stagger: 0.07, y: 0, rotation: 0, ease: "sine.out", force3D: true })
								.fromTo(staggerTwistEls, 0.98, { opacity: 0 }, { stagger: 0.07, clearProps: "transform", opacity: 1, ease: "sine.out", force3D: true }, 0.02);
							delay = 0.4;
						}

						entranceTL
							.fromTo(staggerEls, 0.5, { y: 40 }, { stagger: 0.07, y: 0, ease: "sine.out", force3D: true }, delay)
							.fromTo(staggerEls, 0.48, { opacity: 0 }, { stagger: 0.07, clearProps: "transform", opacity: 1, ease: "sine.out", force3D: true }, delay + 0.02);

						this.thisPagesTLs.push(entranceTL);
						break;


					case "basic-fade":

						entranceTL
							.fromTo(entranceEl, 0.7, { y: 30 }, { y: 0, ease: "sine.inOut", force3D: true })
							.fromTo(entranceEl, 0.68, { opacity: 0 }, { opacity: 1, clearProps: "transform", ease: "sine.inOut", force3D: true }, 0.02);

						this.thisPagesTLs.push(entranceTL);
						break;

					case "rise-up":

						entranceTL
							.fromTo(entranceEl, 0.9, { y: 90 }, { y: 0, ease: "sine.out", force3D: true });

						this.thisPagesTLs.push(entranceTL);
						break;

					case "large-svg-left":
						entranceTL
							.fromTo(entranceEl, 2, { x: (globalStorage.windowWidth * 0.5) }, { x: -(globalStorage.windowWidth * 0.25), ease: "expo.out", force3D: true })

						this.thisPagesTLs.push(entranceTL);
						break;

					case "large-svg-right":
						entranceTL
							.fromTo(entranceEl, 2, { x: -(globalStorage.windowWidth * 0.5) }, { x: (globalStorage.windowWidth * 0.25), ease: "expo.out", force3D: true })

						this.thisPagesTLs.push(entranceTL);
						break;

					default:

						break;
				}
			}
		}

		this.init();
	}

	bindMethods() {
		['run', 'event', 'resize']
			.forEach(fn => this[fn] = this[fn].bind(this));
	}

	init() {
		this.on();
	}

	on() {
		this.getBounding();
		this.getCache();
		this.requestAnimationFrame();
	}

	event(e) {
		this.data.target += Math.round(e.deltaY * -1);
		console.log(e)
		this.clamp();
	}

	clamp() {
		this.data.target = Math.round(Math.min(Math.max(this.data.target, 0), this.data.max));
	}

	run() {
		if (this.state.resizing || this.transitioning) return;
		this.data.scrollY = this.el.scrollTop;

		if (globalStorage.isMobile) {
			this.data.current = this.data.scrollY;
		} else {
			this.data.current += Math.round((this.data.scrollY - this.data.current) * this.data.ease);
		}

		if (this.data.current === this.data.last) {
			this.requestAnimationFrame();
			return;
		}

		this.getDirection();
		this.data.last = this.data.current;
		this.checkMarqueeVisibility()
		this.checkScrollBasedLoadins();
		this.animateDataHeroFromElems();
		this.animateDataFromElems();

		this.checkScrolledMedia();

		this.playPauseVideos();

		this.requestAnimationFrame();
	}

	getDirection() {
		if (this.data.last - this.data.scrollY < 0) {

			// DOWN
			if (this.direction === 'down' || this.data.scrollY <= 0) { return }
			this.direction = 'down';

		} else if (this.data.last - this.data.scrollY > 0) {

			// UP
			if (this.direction === 'up') { return }
			this.direction = 'up';

		}
	}

	hideShowFixedAtc() {
		if (this.direction === "untouched") { return; }
		if (this.direction === "down" && !this.headerScrolled && this.data.scrollY >= this.adjustHeaderDist) {
			this.headerScrolled = true;
			gsap.to(this.fixedAtcEl, 0.3, { autoAlpha: 0, force3D: true, ease: "sine.inOut" })
		} else if (this.direction === "up" && this.headerScrolled) {
			this.headerScrolled = false;
			gsap.to(this.fixedAtcEl, 0.3, { autoAlpha: 1, force3D: true, ease: "sine.inOut" })
		}
	}

	getScrolledMedia() {
		this.data.scrolledMediaCount = 0;
		this.data.scrolledMediaFired = 0;
		this.dom.scrolledMedia = this.currentView.querySelectorAll('.mw');

		if (!this.dom.scrolledMedia) return;
		this.scrolledMediaData = [];
		for (let i = 0; i < this.dom.scrolledMedia.length; i++) {
			const el = this.dom.scrolledMedia[i];

			const bounds = el.getBoundingClientRect();

			this.data.scrolledMediaCount++;
			this.scrolledMediaData.push({
				el: el,
				mediaEls: el.querySelectorAll('.preload'),
				loaded: false,
				top: (bounds.top + this.data.scrollY) > this.data.height ? (bounds.top + this.data.scrollY + globalStorage.vhDiff) : this.data.height + globalStorage.vhDiff,
				bottom: (bounds.bottom + this.data.scrollY + globalStorage.vhDiff),
				height: (bounds.bottom - bounds.top)
			});

		}
	}

	checkScrolledMedia(force = false) {
		if ((this.direction === "untouched" && !force) || !this.scrolledMediaData || this.data.scrolledMediaFired === this.data.scrolledMediaCount) { return; }

		for (let i = 0; i < this.scrolledMediaData.length; i++) {
			let data = this.scrolledMediaData[i];

			if (data.loaded) { continue; }

			if ((this.data.scrollY + this.data.window2x) > data.top) {
				data.el.classList.remove('mw');
				ImageLoad.loadImages(data.mediaEls, "nodeList", () => {
					// console.log('media loaded')
				});
				this.data.scrolledMediaFired++;
				data.loaded = true;
			}
		}
	}

	playPauseVideos() {
		if (this.direction === "untouched") return;
		for (let i = 0; i < this.videosDataLength; i++) {
			let data = this.videosData[i];
			let { isVisible } = this.isVisible(data, 50)
			if (isVisible) {
				if (!data.playing) {
					data.el.play();
					data.playing = true;
				}
			} else if (!isVisible && data.playing) {
				data.el.pause();
				data.el.currentTime = 0;
				data.playing = false;
			}
		}
	}

	getVideos() {
		let playPauseVideos = document.querySelectorAll('video.auto')
		this.videosData = [];

		for (let i = 0; i < playPauseVideos.length; i++) {
			let bounds = playPauseVideos[i].getBoundingClientRect()
			this.videosData.push({
				el: playPauseVideos[i],
				playing: false,
				top: (bounds.top + this.data.scrollY) > this.data.height ? (bounds.top + this.data.scrollY + globalStorage.vhDiff) : this.data.height + globalStorage.vhDiff,
				bottom: (bounds.bottom + this.data.scrollY + globalStorage.vhDiff),
			});
		}
		this.videosDataLength = this.videosData.length;
	}

	getScrollBasedSections() {
		if (!this.dom.scrollBasedElems) return;
		this.scrollBasedElems = []
		let length = this.dom.scrollBasedElems.length;
		for (let i = 0; i < length; i++) {
			if (i < this.offsetVal) { continue; }
			let el = this.dom.scrollBasedElems[i];
			const bounds = el.getBoundingClientRect();
			this.scrollBasedElems.push({
				el: el,
				played: false,
				top: (bounds.top + this.data.scrollY) > this.data.height ? (bounds.top + this.data.scrollY + globalStorage.vhDiff) : this.data.height + globalStorage.vhDiff,
				bottom: (bounds.bottom + this.data.scrollY + globalStorage.vhDiff),
				height: (bounds.bottom - bounds.top),
				offset: globalStorage.windowWidth < 768 ? (el.dataset.offsetMobile * globalStorage.windowHeight) : (el.dataset.offset * globalStorage.windowHeight)
			});
		}

	}

	getDataFromElems() {
		if (!this.dom.dataFromElems) return;

		this.dataFromElems = [];

		let useMobile = globalStorage.windowWidth < 768;

		let length = this.dom.dataFromElems.length
		for (let i = 0; i < length; i++) {
			let el = this.dom.dataFromElems[i]

			let from, to, dur;
			const bounds = el.getBoundingClientRect()
			const tl = new gsap.timeline({ paused: true })

			if (useMobile) {
				from = el.dataset.mobileFrom ? JSON.parse(el.dataset.mobileFrom) : JSON.parse(el.dataset.from);
				to = el.dataset.mobileTo ? JSON.parse(el.dataset.mobileTo) : JSON.parse(el.dataset.to);
				if (el.dataset.mobileDur) {
					dur = el.dataset.mobileDur;
				} else {
					dur = el.dataset.dur ? el.dataset.dur : 1;
				}
			} else {
				from = JSON.parse(el.dataset.from);
				to = JSON.parse(el.dataset.to);
				dur = el.dataset.dur ? el.dataset.dur : 1;
			}

			to.force3D = true;

			tl.fromTo(el, 1, from, to)

			this.dataFromElems.push({
				el: el,
				tl: tl,
				top: (bounds.top + this.data.scrollY) > this.data.height ? (bounds.top + this.data.scrollY + globalStorage.vhDiff) : this.data.height + globalStorage.vhDiff,
				bottom: (bounds.bottom + this.data.scrollY + globalStorage.vhDiff),
				height: bounds.bottom - bounds.top,
				from: from,
				duration: dur,
				progress: {
					current: 0
				}
			})
		}

	}

	getHeroMeasureEl() {
		if (!this.dom.heroMeasureEl) return;
		const el = this.dom.heroMeasureEl;
		const bounds = el.getBoundingClientRect();
		this.heroMeasureData = {
			top: (bounds.top + this.data.scrollY) > this.data.height ? (bounds.top + this.data.scrollY + globalStorage.vhDiff) : this.data.height + globalStorage.vhDiff,
			bottom: (bounds.bottom + this.data.scrollY + globalStorage.vhDiff),
			height: bounds.bottom - bounds.top,
			progress: {
				current: 0
			}
		};
	}

	getDataHeroFromElems() {
		if (!this.dom.dataHeroFromElems) return;

		this.dataHeroFromElems = [];
		const useMobile = globalStorage.windowWidth < 768;
		for (let i = 0; i < this.dom.dataHeroFromElems.length; i++) {
			let el = this.dom.dataHeroFromElems[i]
			let from, to;
			const tl = new gsap.timeline({ paused: true });

			if (useMobile) {
				from = el.dataset.hMobileFrom ? JSON.parse(el.dataset.hMobileFrom) : JSON.parse(el.dataset.hFrom);
				to = el.dataset.mobileTo ? JSON.parse(el.dataset.mobileTo) : JSON.parse(el.dataset.to);
			} else {
				from = JSON.parse(el.dataset.hFrom);
				to = JSON.parse(el.dataset.to);
			}

			tl.fromTo(el, 1, from, to);

			this.dataHeroFromElems.push({
				el: el,
				tl: tl,
				progress: {
					current: 0
				}
			})
		}
	}

	animateDataHeroFromElems() {
		if (this.direction === "untouched" || !this.heroMeasureData) return;
		const { isVisible } = (this.isVisible(this.heroMeasureData, 100));
		if (!isVisible) return;
		let percentageThrough = (this.data.current / this.heroMeasureData.height).toFixed(3);

		if (percentageThrough <= 0) {
			percentageThrough = 0;
		} else if (percentageThrough >= 1) {
			percentageThrough = 1;
		}

		let length = this.dataHeroFromElems.length;
		for (let i = 0; i < length; i++) {
			let data = this.dataHeroFromElems[i]
			data.tl.progress(percentageThrough)
		}
	}

	animateDataFromElems() {
		if (this.direction === "untouched" || !this.dataFromElems) return

		let length = this.dataFromElems.length;
		for (let i = 0; i < length; i++) {
			let data = this.dataFromElems[i]

			const { isVisible, start, end } = this.isVisible(data, 100);

			if (isVisible) {

				this.intersectRatio(data, start, end)

				data.tl.progress(data.progress.current)
			}
		}
	}

	checkScrollBasedLoadins() {
		if (this.direction === "untouched" || !this.scrollBasedElems) { return }
		if (this.thisPagesTLs.length !== this.offsetVal) {
			let length = this.scrollBasedElems.length;
			for (let i = 0; i < length; i++) {
				let data = this.scrollBasedElems[i];

				if (data.played) { continue; }

				if ((this.data.scrollY + data.offset) > data.top) {
					this.thisPagesTLs[i].play();
					this.offsetVal++;
					data.played = true;
				}
			}
		}
	}

	intersectRatio(data, top, bottom) {
		const start = top - this.data.height;

		if (start > 0) { return; }
		const end = (this.data.height + bottom + data.height) * data.duration;
		data.progress.current = Math.abs(start / end);
		data.progress.current = Math.max(0, Math.min(1, data.progress.current));
	}

	isVisible(bounds, offset) {
		const threshold = !offset ? this.data.threshold : offset;
		const start = bounds.top - this.data.current;
		const end = bounds.bottom - this.data.current;
		const isVisible = start < (threshold + this.data.height) && end > -threshold;
		return {
			isVisible,
			start,
			end
		};
	}

	requestAnimationFrame() {
		this.raf = requestAnimationFrame(this.run);
	}

	cancelAnimationFrame() {
		cancelAnimationFrame(this.raf);
	}

	getCache() {
		this.getMarqueeData();
		this.getVideos();
		this.getScrollBasedSections();
		this.getDataHeroFromElems();
		this.getDataFromElems();
		this.getScrolledMedia();
		this.getHeroMeasureEl();
		this.checkScrolledMedia(true)
	}

	getMarqueeData() {
		let bounds = logoMarquee.el.getBoundingClientRect()
		this.logoMarqueeData = {
			top: (bounds.top + this.data.scrollY) > this.data.height ? (bounds.top + this.data.scrollY) : this.data.height,
			bottom: (bounds.bottom + this.data.scrollY),
			height: bounds.bottom - bounds.top
		}
	}

	checkMarqueeVisibility() {
		if(!this.logoMarqueeData){
			return
		}
		let { isVisible } = this.isVisible(this.logoMarqueeData, 50)
		if (isVisible) {
			logoMarquee.play()
		} else {
			logoMarquee.pause()
		}

	}

	getBounding() {
		this.data.height = globalStorage.windowHeight;
		this.data.max = (this.dom.el.getBoundingClientRect().height - this.data.height) + this.data.scrollY;
	}

	resize(omnibar = false) {
		if (this.state.resizing) { return; }
		this.state.resizing = true;
		if (!omnibar) {
			this.getCache();
			this.getBounding();
		}
		this.checkScrolledMedia(true);
		this.state.resizing = false;
	}


	scrollTo(val, dur = 1, ease = "expo.inOut", fn = false) {
		this.state.scrollingTo = true;
		gsap.to(this.el, dur, { scrollTop: val, ease: "sine.inOut", onComplete: () => {
				this.state.scrollingTo = false;
				if(fn) fn();
			}
		});
		gsap.to(this.el, dur, { scrollTop: val, ease: ease, onComplete: () => { this.state.scrollingTo = false; } });
	}

	destroy() {
		this.transitioning = true;

		this.state.rafCancelled = true;
		this.el.removeEventListener('scroll', this.run(), true)
		this.cancelAnimationFrame();

		this.resize = null;

		this.dom = null;
		this.data = null;
		this.raf = null;
	}
}

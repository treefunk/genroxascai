export function playSound(sound) {

	if (!window.audio) {
        window.audio = new Audio(sound)
	} else {
        window.audio.load(sound)
	}
    window.audio.play();
}
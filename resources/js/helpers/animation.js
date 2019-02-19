import * as _ from 'lodash'
export function getRandomTransitionName() {
  return _.sample([
  		'bounce',
		'bounceDown',
		'bounceLeft',
		'bounceRight',
		'bounceUp',
		'fade',
		'fadeDown',
		'fadeDownBig',
		'fadeLeft',
		'fadeLeftBig',
		'fadeRight',
		'fadeRightBig',
		'fadeUp',
		'fadeUpBig',
		'rotate',
		'rotateDownLeft',
		'rotateDownRight',
		'rotateUpLeft',
		'rotateUpRight',
		'slideDown',
		'slideLeft',
		'slideRight',
		'slideUp',
		'zoom',
		'zoomDown',
		'zoomLeft',
		'zoomRight',
		'zoomUp'
	])
}
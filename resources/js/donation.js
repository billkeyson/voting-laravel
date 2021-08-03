window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Sortable from 'sortablejs/modular/sortable.complete.esm.js';

var reorderObjects = []
// let el = $("#sortable1");
var el = document.getElementById('sortable1');

var sortable = new Sortable(el, {
	group: "name",  // or { name: "...", pull: [true, false, 'clone', array], put: [true, false, array] }
	sort: true,  // sorting inside list
	delay: 5, // time in milliseconds to define when the sorting should start
	delayOnTouchOnly: false, // only delay if user is using touch
	touchStartThreshold: 0, // px, how many pixels the point should move before cancelling a delayed drag event
	disabled: false, // Disables the sortable if set to true.
	store: null,  // @see Store
	animation: 150,  // ms, animation speed moving items when sorting, `0` — without animation
	easing: "cubic-bezier(1, 0, 0, 1)", // Easing for animation. Defaults to null. See https://easings.net/ for examples.
	handle: ".my-handle",  // Drag handle selector within list items
	filter: ".ignore-elements",  // Selectors that do not lead to dragging (String or Function)
	preventOnFilter: true, // Call `event.preventDefault()` when triggered `filter`
	draggable: ".item",  // Specifies which items inside the element should be draggable

	dataIdAttr: 'data-id',

	ghostClass: "sortable-ghost",  // Class name for the drop placeholder
	chosenClass: "sortable-chosen",  // Class name for the chosen item
	dragClass: "sortable-drag",  // Class name for the dragging item

	swapThreshold: 1, // Threshold of the swap zone
	invertSwap: false, // Will always use inverted swap zone if set to true
	invertedSwapThreshold: 1, // Threshold of the inverted swap zone (will be set to swapThreshold value by default)
	direction: 'horizontal', // Direction of Sortable (will be detected automatically if not given)

	forceFallback: false,  // ignore the HTML5 DnD behaviour and force the fallback to kick in

	fallbackClass: "sortable-fallback",  // Class name for the cloned DOM Element when using forceFallback
	fallbackOnBody: false,  // Appends the cloned DOM Element into the Document's Body
	fallbackTolerance: 0, // Specify in pixels how far the mouse should move before it's considered as a drag.

	dragoverBubble: false,
	removeCloneOnHide: true, // Remove the clone element when it is not showing, rather than just hiding it
	emptyInsertThreshold: 5, // px, distance mouse must be from empty sortable to insert drag element into it


	setData: function (/** DataTransfer */dataTransfer, /** HTMLElement*/dragEl) {
		dataTransfer.setData('Text', dragEl.textContent); // `dataTransfer` object of HTML5 DragEvent
	},

	// Element is chosen
	onChoose: function (/**Event*/evt) {
		evt.oldIndex;  // element index within parent
	},


	// Element dragging ended
	onEnd: function (/**Event*/evt) {

		let toElements = evt.to.children
		let index = 1;
		Array.from(toElements).forEach(function (item) {
			let variableId = parseInt($(item).attr('variableId'));
			reorderObjects.push({ variableId: variableId, orderNumber: index })
			// console.log('Item ',item);
			index++
		});

		axios.post('/api/ussdtemplate/reorder', reorderObjects)
			.then(response => {
				// console.log(response.data)
			}).catch(error => { console.log(error) })

		reorderObjects = []
		var itemEl = evt.item;  // dragged HTMLElement

		evt.to;    // target list
		evt.from;  // previous list
		evt.oldIndex;  // element's old index within old parent
		evt.newIndex;  // element's new index within new parent
		evt.oldDraggableIndex; // element's old index within old parent, only counting draggable elements
		evt.newDraggableIndex; // element's new index within new parent, only counting draggable elements
		evt.clone // the clone element
		evt.pullMode;  // when item is in another sortable: `"clone"` if cloning, `true` if moving
	},

});

const variableNames = async (parameter) => {
	// let htmlOption = ``
	var result = await axios.get(`/api/variable/names/${parameter}`)
	// let htmlOption = Array.from(result.data.data).forEach(item=>`<option value="${item.name}">${item.name}</option>`)
	// console.log(result.data.data)
	return result.data.data;
}

// add variable options
var index = 0;
$("#addSingleOption").on('click', (async event => {

	let urlParam = window.location.pathname.split('/')
	const parameter = urlParam[urlParam.length - 1]
	let options = await variableNames(parameter)
	event.preventDefault();
	$('.addOption').append(
		`
	<div class="col-md-12 mb-2">
	<div class="row ">
		<div class="col-md-3">
			<input type="hidden" value="${index+1}" name="options[items][${index}][id]" />
			<div class="form-line">
				<input type="text" value="" name="options[items][${index}][label]" id="" class="form-control"
					placeholder="Option Label" />
			</div>
		</div>

		<div class="col-md-3">
			<div class="form-line">
				<input type="text" value="" name="options[items][${index}][value]" class="form-control" id=""
					placeholder="Option Value" />
			</div>
		</div>

		<div class="col-md-3">
			<div class="form-line">
				<select name="options[items][${index}][skip]" class="form-control show-tick add-options${index}">
					<option value="">Skip</option>
				</select>
			</div>
		</div>

		<div class="col-md-2">
			<div class="form-line">
				<select name="options[type]" class="form-control show-tick">
					<option value="">type</option>
					<option value="plain">Plain</option>
					<option value="int">Integer</option>
					<option value="decimals">Decimals</option>
				</select>
			</div>
		</div>

		<div class="col-md-1 d-flex justify-content-center align-items-center removeOption"
			style="cursor: pointer">
			<div class="form-line">
				<div class="demo-google-material-icon"> 
				<i class="material-icons">remove_circle</i> <span class="icon-name"></span>
				</div>

			</div>
		</div>
	</div>

</div>`);
	// add options to selection for skip
	options.forEach(item => {
		$(`.add-options${index}`).append(`<option value="${item.name}">${item.name}</option>`)
	})

	index++;
	// console.log(options)



	// remove single option
$('.removeOption').on('click', event => {
	console.log(event.target)
	$(event.target).parent().parent().parent().parent().parent().remove()
})

}))




// input_type display toggle
$('.input_type').on('change', (event) => {
	if (event.target.value == "single") {
		$(".disableSingle").removeClass('d-none')
		$(".disableSingle").addClass('block')
		$(".disablePlain").addClass('d-none')
	} else {
		$(".disableSingle").removeClass('block')
		$(".disableSingle").addClass('d-none')
	}

	if (event.target.value == "plain") {
		$(".disablePlain").removeClass('d-none')
		$(".disablePlain").addClass('block')

	} else {
		$(".disablePlain").removeClass('block')
		$(".disablePlain").addClass('d-none')
	}
	// console.log(event.target.value)

	// console.log(parameter)
})
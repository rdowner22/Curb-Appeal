document.addEventListener("DOMContentLoaded", function(event) {
	document.querySelectorAll('ul .menu-item-has-children').forEach(function(element){
		var destinationURL = element.childNodes[0].getAttribute('href')
		// Check if href is empty, create link overlay if there is a value
		if (destinationURL !== null && destinationURL !== "" && destinationURL !== "#") {
			var linkOverlay = document.createElement("a")
			linkOverlay.className = 'mobile-nav-link-overlay'
			linkOverlay.href = destinationURL
			linkOverlay.onclick = function (event) {
				event.stopPropagation()
			}
			element.insertBefore(linkOverlay, element.childNodes[0])
		}
	})
});

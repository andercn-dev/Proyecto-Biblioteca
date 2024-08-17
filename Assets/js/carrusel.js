$(document).ready(function(){
	$('.carrusel').owlCarousel({
		loop: true,
		margin: 10,
		nav: true,
		navText: [
			'<i class="fa-solid fa-angle-left"></i>',
			'<i class="fa-solid fa-angle-right"></i>'
		],
		responsive: {
			0: { items: 1 },
			600: { items: 2 },
			1000: { items: 4 }
		}
	});
});
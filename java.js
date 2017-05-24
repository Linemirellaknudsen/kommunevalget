//Burgermenu
$('.knap').click(function() {
		$(this). toggleClass('expanded').siblings('.dropdown').slideToggle(400);
	}	
);



//Nyheder
function popIt(noget){
			newWindow = window.open(noget, "_blank", "width=1200 height=750, top=50, left=100");
		}

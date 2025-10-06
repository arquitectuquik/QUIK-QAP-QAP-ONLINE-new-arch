function initialize() {
	
	/*
	var numbers = [1,2,3,4,5];
	shuffle(numbers);

	$("body").vegas({
		slides: [
			{ src: '/qap/css/index_bg_'+numbers[0]+'.jpg' },
			{ src: '/qap/css/index_bg_'+numbers[1]+'.jpg' },
			{ src: '/qap/css/index_bg_'+numbers[2]+'.jpg' },
			{ src: '/qap/css/index_bg_'+numbers[3]+'.jpg' },
			{ src: '/qap/css/index_bg_'+numbers[4]+'.jpg' }
		],
		delay: 600000,
		timer: false,
		transition: 'fade'
	});
	*/
	
		var timer_1 = setInterval(function(){
					
		$.ajax({
			contentType: "application/x-www-form-urlencoded",
			url:"php/verifica_estado_sesion.php",
			type:"POST",
			dataType:"xml",
			success: function(xml) { 
				var answer = parseInt(xml.getElementsByTagName("response")[0].textContent,10);
				
				if (answer == 0) {
					clearInterval(timer_1);
					var txt = "Su sesión ha caducado, por favor actualice la página";
					var boxType = "warning";
					
					var div = document.createElement("div");
						div.setAttribute("style",
							"opacity:    0.5;"
							+"background: #000;" 
							+"width:      100%;"
							+"height:     100%;"
							+"z-index:    10;"
							+"top:        0;" 
							+"left:       0;" 
							+"position:   fixed"
						);
					
					document.getElementsByTagName("body")[0].appendChild(div);
					statusBox(boxType,'NULL',txt,'add','99999999');
				}		
			}
		});	
	},5000);	
	
	function shuffle(array) {
		var currentIndex = array.length, temporaryValue, randomIndex;
		
		// While there remain elements to shuffle...
		while (0 !== currentIndex) {
		
			// Pick a remaining element...
			randomIndex = Math.floor(Math.random() * currentIndex);
			currentIndex -= 1;
		
			// And swap it with the current element.
			temporaryValue = array[currentIndex];
			array[currentIndex] = array[randomIndex];
			array[randomIndex] = temporaryValue;
		}
		
		return array;
	}	
}

function changeFrame(val) {
	
	var id = val.getAttribute("id");
	
	switch(id) {
		case "btn1":
			$("#page").attr("src","resultado.php");
		break;
		case "btn2":
			$("#page").attr("src","panel_control.php");
		break;	
		case "btn3":
			$.removeCookie('user_hash');
			window.location.href = "php/cierra_sesion.php";
		break;
		case "btn4":
			$("#page").attr("src","");
		break;
		case "btn5":
			$("#page").attr("src","cronograma.php");
		break;		
		case "btnDigitacion":
			$("#page").attr("src","digitacion.php");
		break;	
		case "btnDigitacionUroanalisis":
			$("#page").attr("src","uroanalisis/digitacion.php");
		break;		
		case "btnPatologia":
			$("#page").attr("src","resultado_pat.php");
		break;		
		case "btnPatologiaIntra":
			$("#page").attr("src","resultado_pat_intra.php");
			break;
		case "btnFinRonda":
			$("#page").attr("src","informe_fin_ronda.php");
			break;
		case "btnClic":
			$("#page").attr("src","clic_for_52.php");
			break;
		default:		
			alert("ERROR 404 - No se ha encontrado la página");
		break;
	}
	
}
var ie10 = false;
if(Function('/*@cc_on return document.documentMode===10@*/')()){
	//alert("asd");
  document.documentElement.className+=' ie10';
  ie10 = true;
 // $("#list-auth-items").width("930px");
}
/*
if ($.browser.msie && $.browser.version == 10) {
	alert("asd");
	$("#list-auth-items").width("930px");

}
*/

var rightInterval;
var leftInterval; 
/*
var op25 = 0.25;
var op50 = 0.50;
var op75 = 0.75;
*/
var op25 = 1;
var op50 = 1;
var op75 = 1;
var op100 = 1;
var op0 = 1;
var mover_mouse = false; // opcion para mover el slider con el mouse over
var core = 134;
var init_center = 1060;
var windowWidth = window.screen.width < window.outerWidth ?
                  window.screen.width : window.outerWidth;	
var windowHeight = window.screen.height < window.outerHeight ?
                  window.screen.height : window.outerHeight;
				  		
var portrait = (windowHeight > windowWidth);
/*
var currentWidth = window.innerWidth || document.body.offsetWidth || document.documentElement.offsetWidth,
    currentHeight = window.innerHeight || document.body.offsetHeight || document.documentElement.offsetHeight,
    portrait = window.orientation || (currentWidth > currentHeight);
*/	
//alert("w:"+windowWidth+",H:"+windowHeight+",O:"+portrait);
/*
preload([
    'lageri1.png',
    'crikey3.png',
    'schumlii1.png',
'Barner2.png',
'weizeni1.png',
'junker1.png',
'Bugeli1.png',
'barni1.png'
]);
*/
(function($) {		

	
$(document).ready(function() {
/*
	alert(window.orientation);
switch(window.orientation)          // don't add code in this switch
{
    case 0:                     // here we don't know if it's portrait or if it's undefined, grrr...
        if($(window).width() < 900)
            my_orientation = 1; // portrait
        else
            my_orientation = 0; // landscape
        break;
    case 180:
            my_orientation = 1; // portrait
        break;
    case -90: 
    case 90: 
        my_orientation = 0; // landscape
        break;
}

portrait = my_orientation;

alert(portrait);
*/
	$(".bx-prev").click(function(event){
		event.preventDefault();
		doLeft();
		});
	$(".bx-next").click(function(event){

		event.preventDefault();
		doRight();
		});
if (!is_touch_device()){		
	$("#list-auth-items").mouseleave(function() {
			clearInterval(leftInterval);
			clearInterval(rightInterval);
			//console.log("clear mouse");
			//$("#log").html("<div>Clear</div>");
	});
	
	if (mouse_over)
		$("#list-auth-items").mousemove(function(event) {
		 // var msg = "Handler for .mousemove() called at ";
		 // msg += event.pageX + ", " + event.pageY;
	
		//console.log("clear");
			left = $("#list-auth-items").offset().left;
			posicion = event.pageX - left;
			medio = $(this).width()/2;
			cuarto = $(this).width()/4;
			//console.log("left: "+left+" medio: "+medio+" pageX: "+posicion);
			if ( (posicion >= (medio+65)) || (posicion <= (medio-65) ) ){
				if (posicion >= medio){
					clearInterval(rightInterval);
			  	   if (posicion >= medio + cuarto)
					   rightInterval = setInterval(function(){
							if (!$("#b").is(":animated"))
								doRight(500);
						}, 100);
					else
					   rightInterval = setInterval(function(){
							if (!$("#b").is(":animated"))
								doRight(1000);
						}, 100);
		  		}else{
					clearInterval(leftInterval);
					if (posicion <= medio - cuarto)
						leftInterval = setInterval(function(){
						
							if (!$("#b").is(":animated"))
								doLeft(500);
						}, 100);
					else
						leftInterval = setInterval(function(){
						
							if (!$("#b").is(":animated"))
								doLeft(1000);
						}, 100);			
				}
			} else {
				clearInterval(rightInterval);
				clearInterval(leftInterval);			
			}
		  
		  //$("#log").html("<div>" + msg + "</div>");
		});	
	
} else {
	$( "#b" ).draggable({ axis: "x" , drag: function( event, ui ) {

			center = ui.position.left +init_center;
			//op = (1-center) * 3;
			op = (1000-(center*2.2));
			op = op/1000;
			
			op_color = (1000-(center*7.6));
			op_color = op_color/1000; 					
			//prev_op = $(".image_not_bw").css("opacity")*1000;
			//new_op = prev_op - op;
			if (op > 1){
				op = 2-op;
				op_color = 2-op_color;
			$(".image_not_bw").css({opacity: op});
				
			$(".image_not_bw").next().css({opacity:(op-0.25)+((1-op)*2)});
			$(".image_not_bw").prev().css({opacity: op - op25});

			$(".image_not_bw").next().next().css({opacity: (op-op50)+((1-op)*2)});
			$(".image_not_bw").prev().prev().css({opacity: op - op50});
			
			$(".image_not_bw").next().next().next().css({opacity: (op-0.75)+((1-op)*2)});
			$(".image_not_bw").prev().prev().prev().css({opacity: op - op75});
			
			$(".image_not_bw").next().next().next().next().css({opacity: (op-1)+((1-op)*2)});
			
			$(".image_not_bw").next().find('img:first').stop().css({opacity:1-op_color});
			$(".image_not_bw .img_grayscale").stop().css({opacity:op_color});
			
			//if (((op-op25)+((1-op)*2)) > 0.99)
			//		$(".image_not_bw").addClass("image_bw").removeClass("image_not_bw").next().removeClass("image_bw").addClass("image_not_bw");
				if ($(".image_not_bw").next().css("opacity")>=1){
					//$(".image_not_bw").addClass("image_bw");
					
					$(".image_not_bw").addClass("image_bw").removeClass("image_not_bw").next().removeClass("image_bw").addClass("image_not_bw");
					init_center+=core;
				}			
			} else {
				$(".image_not_bw").css({opacity: op});
					
				$(".image_not_bw").next().css({opacity: op - op25});
				$(".image_not_bw").prev().css({opacity:(op-op25)+((1-op)*2)});
	
				$(".image_not_bw").next().next().css({opacity: op - op50});
				$(".image_not_bw").prev().prev().css({opacity: (op-0.50)+((1-op)*2)});
				
				$(".image_not_bw").next().next().next().css({opacity: op - op75});
				$(".image_not_bw").prev().prev().prev().css({opacity: (op-0.75)+((1-op)*2)});
				
				$(".image_not_bw").prev().prev().prev().prev().css({opacity: (op-1)+((1-op)*2)});	
				//if (((op-op25)+((1-op)*2)) >= 1)
				//if (center%130 == 0)
				//Cambiar  el color de la botella del medio
				$(".image_not_bw").prev().find('img:first').stop().css({opacity:1-op_color});
				$(".image_not_bw .img_grayscale").stop().css({opacity:op_color});
				if ($(".image_not_bw").prev().css("opacity")>=1){
					//$(".image_not_bw").addClass("image_bw");
					
					//$(".image_not_bw").prev().find('img:first').stop().animate({opacity:1}, 1000);
					//$(".image_not_bw .img_grayscale").stop().animate({opacity:0}, 1000);
					
					$(".image_not_bw").addClass("image_bw").removeClass("image_not_bw").prev().removeClass("image_bw").addClass("image_not_bw");
					init_center-=core;
				}
			}
			/*
			var msg = "Handler for .mousemove() called at ";
			msg += ui.position.left + ", " + op  + ", " + ui.offset.left ;			
			$("#log").html("<div>" + msg + "</div>");
			*/										
		}
	});
}
});
function is_touch_device() {
	
  return !!('ontouchstart' in window) // works on most browsers 
      || !!('onmsgesturechange' in window); // works on ie10
	 
	return true;  
};
function preload(arrayOfImages) {
    $(arrayOfImages).each(function(){
        $('<img/>')[0].src = this;
        // Alternatively you could use:
        // (new Image()).src = this;
    });
}

// Usage:


function init_slider(){

				//  alert(windowWidth);
	var count = $("#b > div").length;
	//alert(Math.abs(window.orientation));
	$("#b").prepend($("#b").html());
	$("#b").append($("#b").html());
	if (ie10){
		$("#b > div").eq(count+3).removeClass("image_bw").addClass("image_not_bw").css({opacity: '1'});
		x= -1080	
	} else {
		if (navigator.userAgent.match(/iPhone/i)){
			$("#b > div").eq(count+1).removeClass("image_bw").addClass("image_not_bw").css({opacity: '1'});
			
		} else { 
			if (navigator.userAgent.match(/iPad/i)) {
				//alert(Math.abs(window.orientation));
				if (Math.abs(window.orientation) === 90){
					
				$("#b > div").eq(count+3).removeClass("image_bw").addClass("image_not_bw").css({opacity: '1'});
				x= -1080;
				} else {
				$("#b > div").eq(count+2).removeClass("image_bw").addClass("image_not_bw").css({opacity: '1'});
				x= -1050;					
				}
				
			} else {
				
				if (windowWidth <= 800 && portrait) {
					$("#b > div").eq(count+2).removeClass("image_bw").addClass("image_not_bw").css({opacity: '1'});
					x= -1030;
				} else {
					$("#b > div").eq(count+3).removeClass("image_bw").addClass("image_not_bw").css({opacity: '1'});
					x= -1080;
				}
			}
		}
	}

	$(".image_not_bw img").parent().find('img:first').stop().animate({opacity:1}, 1000);
	
	$('#b').css({ 'left': x + 'px' });
	if (false){ //opciones para evitar opacity
		$(".image_not_bw").prev().css({opacity: '0.75'}).prev().css({opacity: '0.5'}).prev().css({opacity: '0.25'});
		$(".image_not_bw").next().css({opacity: '0.75'}).next().css({opacity: '0.5'}).next().css({opacity: '0.25'});	
	}
	
	//$("#b").show();
   // $("#b").animate({left: "+=500"}, 2000);
   // $("#b").animate({left: "-=300"}, 1000);
}

function doRight(speed) {
	/*
	x = 910;
	$("#log").html("<div>" + $("#b").position().left + "</div>");
	if ($("#b").position().left<=-129)
		$('#b').css({ 'left': x + 'px' });	
	*/	
    $("#b").animate({left: "-="+core}, speed);
	$(".image_not_bw").next().animate({opacity: '1'},  { duration: speed, queue: false }).next().animate({opacity: op75},  { duration: speed, queue: false }).next().animate({opacity: op50},  { duration: speed, queue: false }).next().animate({opacity: op25},  { duration: speed, queue: false });
	$(".image_not_bw").animate({opacity: op75},  { duration: speed, queue: false }).prev().animate({opacity: op50},  { duration: speed, queue: false }).prev().animate({opacity: op25},  { duration: speed, queue: false }).prev().animate({opacity: op0},  { duration: speed, queue: false });
	
	 
	$(".image_not_bw").next().find('img:first').stop().animate({opacity:op100}, speed);
	
	$(".image_not_bw .img_grayscale").stop().animate({opacity:op0}, speed);	
	
	$(".image_not_bw").addClass("image_bw").removeClass("image_not_bw").next().removeClass("image_bw").addClass("image_not_bw");	
	
	init_center+=core; 
}


function doLeft(speed) {
/*	x = -130;
	$("#log").html("<div>" + $("#b").position().left + "</div>");
	if ($("#b").position().left>=909)
		$('#b').css({ 'left': x + 'px' });
*/
	//$("#b").prepend($("#b div:last-child"));	
	//$("#b div:last-child").remove();
    $("#b").animate({left: "+="+core},  { duration: speed, queue: false });
	$(".image_not_bw").prev().animate({opacity: '1'},  { duration: speed, queue: false }).prev().animate({opacity: op75},  { duration: speed, queue: false }).prev().animate({opacity: op50},  { duration: speed, queue: false }).prev().animate({opacity: op25},  { duration: speed, queue: false });
	$(".image_not_bw").animate({opacity: op75},  { duration: speed, queue: false }).next().animate({opacity: op50},  { duration: speed, queue: false }).next().animate({opacity: op25},  { duration: speed, queue: false }).next().animate({opacity: op0},  { duration: speed, queue: false });
	//
	$(".image_not_bw").prev().find('img:first').stop().animate({opacity:op100}, speed);
	$(".image_not_bw .img_grayscale").stop().animate({opacity:op0}, speed);
	$(".image_not_bw").addClass("image_bw").removeClass("image_not_bw").prev().removeClass("image_bw").addClass("image_not_bw");
	
	//$('#b').animate({}, 1000);
	init_center-=core;
}
function grayscale(src){
		var canvas = document.createElement('canvas');
		var ctx = canvas.getContext('2d');
		var imgObj = new Image();
		imgObj.src = src;
		
		canvas.width = imgObj.width;
		canvas.height = imgObj.height; 
		ctx.drawImage(imgObj, 0, 0); 
		var imgPixels = ctx.getImageData(0, 0, canvas.width, canvas.height);
		for(var y = 0; y < imgPixels.height; y++){
			for(var x = 0; x < imgPixels.width; x++){
				var i = (y * 4) * imgPixels.width + x * 4;
				var avg = (imgPixels.data[i] + imgPixels.data[i + 1] + imgPixels.data[i + 2]) / 3;
				imgPixels.data[i] = avg; 
				imgPixels.data[i + 1] = avg; 
				imgPixels.data[i + 2] = avg;
			}
		}
		ctx.putImageData(imgPixels, 0, 0, 0, 0, imgPixels.width, imgPixels.height);
		return canvas.toDataURL();
    }
//beeRight();
$(window).load(function(){
// Fade in images so there isn't a color "pop" document load and then on window load
		
		$(".image_bw img").fadeIn(500);
		
		// clone image
		
		$('.image_bw img').each(function(){
			//alert('asd');
			var el = $(this);
			el.css({"position":"absolute","z-index":"-999"}).wrap("<div class='img_wrapper' style='display: inline-block'>").clone().addClass('img_grayscale').css({"position":"absolute","z-index":"-998","opacity":"0"}).insertBefore(el).queue(function(){
				var el = $(this);
				// para que funcione en ie9
				width = this.width;
				if (width == 0)
					width = 130;				
				el.parent().css({"width":width,"height":this.height});
				el.dequeue();
			});
			//alert(this.src);
			this.src = grayscale(this.src);
		});
		
		/*
		// Fade image 
		$('.image_bw img').mouseover(function(){
			alert('asd');
			$(this).parent().find('img:first').stop().animate({opacity:1}, 1000);
		})
		$('.img_grayscale').mouseout(function(){
			$(this).stop().animate({opacity:0}, 1000);
		});		
	*/
	if ((navigator.userAgent.match(/iPhone/i))){
		$("#slider").hide();
		$("#myCarousel").show();
	} else {
		if ((navigator.userAgent.match(/Android/i)) && (windowWidth <= 480)){
				$("#slider").hide();
				$("#myCarousel").show();			
		} else {
				init_slider(); 
				$("#b").show();
		}
	}
			$("#list-auth-items").css({background:"none"});
	});
}(jQuery));	
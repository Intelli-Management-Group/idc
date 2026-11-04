
$(function() {
 AOS.init();
});

$(window).on('load', function() {
  AOS.refresh();
});


///$(window).scroll(
///    {
///        previousTop: 0
///    }, 
///    function () {
///   var currentTop = $(window).scrollTop();
///    if (currentTop < this.previousTop) {
///        $(".sidebar em").text("Up"); /* optional for demo */
///        $(".navbar").show();
///    } else {
///       $(".sidebar em").text("Down");
///       $(".navbar").hide();
///    }
///    this.previousTop = currentTop;
///});


$(document).ready(function(){
  $('#contact-form-submit').click(function(){
    var str = $('#contact-form').serialize();
    $.ajax({
      type: "POST",
      url: "mail.php",
      data: str,
      success: function(msg){
           if(msg == 'OK'){
             result = '<span class="success">Your message has been successfully sent. Thank you!</span>';
             $('#contact-form').fadeOut('slow');
           }else{
             result = msg;
           }
           $('.error').html(result);
      }
      });
  });
  
});

$(function(){
   filterSelection("all")
});
function filterSelection(c) {
	
  var x, i;
  x = document.getElementsByClassName("column");
  if (c == "all") c = "";
  for (i = 0; i < x.length; i++) {
    w3RemoveClass(x[i], "show");
    if (x[i].className.indexOf(c) > -1) w3AddClass(x[i], "show");
  }
}

function w3AddClass(element, name) {
  var i, arr1, arr2;
  arr1 = element.className.split(" ");
  arr2 = name.split(" ");
  for (i = 0; i < arr2.length; i++) {
    if (arr1.indexOf(arr2[i]) == -1) {element.className += " " + arr2[i];}
  }
}

function w3RemoveClass(element, name) {
  var i, arr1, arr2;
  arr1 = element.className.split(" ");
  arr2 = name.split(" ");
  for (i = 0; i < arr2.length; i++) {
    while (arr1.indexOf(arr2[i]) > -1) {
      arr1.splice(arr1.indexOf(arr2[i]), 1);     
    }
  }
  element.className = arr1.join(" ");
}


// Add active class to the current button (highlight it)
var btnContainer = document.getElementById("myBtnContainer");
var btns = btnContainer.getElementsByClassName("link");
for (var i = 0; i < btns.length; i++) {
  btns[i].addEventListener("click ", function(){
    var current = document.getElementsByClassName("active");
    current[0].className = current[0].className.replace(" active", "");
    this.className += " active";
	 $(".trigger").css("height", "0px");
  });
}


function openModal(n) {
	if (n==1){
		document.getElementById('myModal1').style.display = "block";
	}
	if (n==2){
		document.getElementById('myModal2').style.display = "block";
	}
	if (n==3){
		document.getElementById('myModal3').style.display = "block";
	}
	if (n==4){
		document.getElementById('myModal4').style.display = "block";
	}
}

function closeModal(n) {
	if (n==1){
		document.getElementById('myModal1').style.display = "none";
	}
	if (n==2){
		document.getElementById('myModal2').style.display = "none";
	}
	if (n==3){
		document.getElementById('myModal3').style.display = "none";
	}
	if (n==4){
		document.getElementById('myModal4').style.display = "none";
	}
}

var slideIndex = 1;
showSlides(l,slideIndex);

function plusSlides(l,n) {
  showSlides(l,slideIndex += n);
}

function currentSlide(l,n) {
  showSlides(l,slideIndex = n);
}

function showSlides(l,n) {
  var i;
  if (l==1){
		var slides = document.getElementsByClassName("commercial-1");
		var dots = document.getElementsByClassName("commercial-1-demo");
		var captionText = document.getElementById("commercial-1-caption");
	}
    if (l==2){
        var slides = document.getElementsByClassName("commercial-2");
        var dots = document.getElementsByClassName("commercial-2-demo");
        var captionText = document.getElementById("commercial-2-caption");
    }
    if (l==3){
        var slides = document.getElementsByClassName("industrial-1");
        var dots = document.getElementsByClassName("industrial-1-demo");
        var captionText = document.getElementById("industrial-1-caption");
    }
    if (l==4){
        var slides = document.getElementsByClassName("industrial-2");
        var dots = document.getElementsByClassName("industrial-2-demo");
        var captionText = document.getElementById("industrial-2-caption");
    }
    if (l==5){
        var slides = document.getElementsByClassName("residential-1");
        var dots = document.getElementsByClassName("residential-1-demo");
        var captionText = document.getElementById("residential-1-caption");
    }
    if (l==6){
        var slides = document.getElementsByClassName("residential-2");
        var dots = document.getElementsByClassName("residential-2-demo");
        var captionText = document.getElementById("residential-2-caption");
    }
    if (l==7){
        var slides = document.getElementsByClassName("residential-3");
        var dots = document.getElementsByClassName("residential-3-demo");
        var captionText = document.getElementById("residential-3-caption");
    }
	if (l==8){
		var slides = document.getElementsByClassName("residential-4");
		  var dots = document.getElementsByClassName("residential-4-demo");
  var captionText = document.getElementById("residential-4-caption");
	}
	if (l==9){
		var slides = document.getElementsByClassName("residential-5");
		var dots = document.getElementsByClassName("residential-5-demo");
		var captionText = document.getElementById("residential-5-caption");
	}
	if (l==10){
		var slides = document.getElementsByClassName("residential-6");
		var dots = document.getElementsByClassName("residential-6-demo");
		var captionText = document.getElementById("residential-6-caption");
	}
    if (l==11){
        var slides = document.getElementsByClassName("residential-7");
        var dots = document.getElementsByClassName("residential-7-demo");
        var captionText = document.getElementById("residential-7-caption");
    }
    if (l==12){
        var slides = document.getElementsByClassName("residential-8");
        var dots = document.getElementsByClassName("residential-8-demo");
        var captionText = document.getElementById("residential-8-caption");
    }

  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
  captionText.innerHTML = dots[slideIndex-1].alt;
}




function initMap() {
    var uluru = {lat: 49.170754, lng: -123.153662};
    var map = new google.maps.Map(document.getElementById('map'), {
		zoom: 15,
        center: uluru
    });
    var marker = new google.maps.Marker({
        position: uluru,
        map: map
    });
}


$("#myModal").on("show", function () {
  $("body").addClass("modal-open");
}).on("hidden", function () {
  $("body").removeClass("modal-open")
});	  
	
  

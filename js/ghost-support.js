//setTimeout(function(){

//.innerHTML = '<a id="updateRate" class="updateRate" href="#rate">View updated Rate</a>';

var cssId = 'supportCss';  // you could encode the css path itself to generate id..
if (!document.getElementById(cssId))
{
    var foot  = document.getElementsByTagName('footer')[0];
    var link  = document.createElement('link');
    link.id   = cssId;
    link.rel  = 'stylesheet';
    link.type = 'text/css';
    link.href = 'http://dev.agencyexcel.com/wp-content/plugins/ghostcomparison/css/support.css';
    link.media = 'all';
    foot.appendChild(link);
}

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click  ', function (e) {
        e.preventDefault();

        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});
	
var button = document.querySelector('#rate');
var PayContent = document.querySelector('.payDetails');
PayContent.style.display = "none";	
button.addEventListener('click', function (event) {
	
      if (PayContent.style.display == "") {
          PayContent.style.display = "none";
          button.innerHTML = "View Rate";
		  
      } else {
          PayContent.style.display = "";
          button.innerHTML = "Hide Rate";
  
      }
	  setTimeout("UpdateRate()", 5000); 
    }
  );
function UpdateRate() {
	document.getElementById("updateRate").style.display = "block";
}	
	
document.body.addEventListener("click", function(){
    
  const goCheck = document.getElementById('input_52_65_chosen');
  let el = event.target;
  while(el && el !== goCheck) el = el.parentElement;
  if(!el) return;
		    
	var value1 = document.getElementById('input_52_22').value;
	var value2 = document.getElementById('input_52_100').value;
	var value3 = document.getElementById('input_52_95').value;
	// var value4 = document.getElementById('input_52_96').value;
    var ClassDsc65 = document.getElementById('input_52_65_chosen').innerText;
    var ClassDsc92 = document.getElementById('input_52_92').value;

    var ClassDscUpdate = document.getElementById('input_52_92').value = ClassDsc65;

	if (value1 > 0 ) { 
		document.getElementById('field_52_116').style.display = "none";

	  } else if (value1 == 0 ) { 

	  }
	if (value2 > 0 ) { 
		document.getElementById('field_52_116').style.display = "none";

	} else if (value2 == 0 ) { 

	}
	if (value3 > 0 ) { 
		document.getElementById('field_52_116').style.display = "none";

	  } else if (value3 == 0 ) { 

	  }
	if (value1 == 0 && value2 == 0 && value3 == 0 ) { 
		document.getElementById('field_52_116').style.display = "block";
		document.getElementById('rate').style.display = "none";
		document.getElementById('pay-plans').style.display = "none";
	} 	
});
	
function myValidateFunction () { 
	var value1 = document.getElementById('input_52_22').value;
	var value2 = document.getElementById('input_52_100').value;
	var value3 = document.getElementById('input_52_95').value;
	// var value4 = document.getElementById('input_52_96').value;
	document.getElementById('option4').style.display = "none"; 
//	document.getElementById('option5').style.display = "none"; 

	if (value1 > 0 ) { 
		document.getElementById('field_52_116').style.display = "none";
		document.getElementById('rate').style.display = "block";
		document.getElementById('pay-plans').style.display = "block";
		
	  } else if (value1 == 0 ) { 
		document.getElementById('option1').style.display = "none";
	  }
	if (value2 > 0 ) { 
		document.getElementById('field_52_116').style.display = "none";
		document.getElementById('rate').style.display = "block";
		document.getElementById('pay-plans').style.display = "block";		

	} else if (value2 == 0 ) { 
		document.getElementById('option2').style.display = "none";
	}
	if (value3 > 0 ) { 
		document.getElementById('field_52_116').style.display = "none";
		document.getElementById('rate').style.display = "block";
		document.getElementById('pay-plans').style.display = "block";
		
	  } else if (value3 == 0 ) { 
		document.getElementById('option3').style.display = "none";
	  }
	if (value1 == 0 && value2 == 0 && value3 == 0 ) { 
		document.getElementById('field_52_116').style.display = "block";
		document.getElementById('rate').style.display = "none";
		document.getElementById('pay-plans').style.display = "none";
	} 	
};	

setInterval( myValidateFunction, 500);
setInterval( myValidateFunction2, 500);
setInterval( addSelectors, 500);
	
function myValidateFunction2 () { 	
	var inElgbl =  document.getElementById('field_52_116');
	if (typeof(inElgbl) != 'undefined' && inElgbl != null)
	{
// 			document.getElementById('rate').style.display = "none";
// 			document.getElementById('pay-plans').style.display = "none";
			document.getElementById('field_52_24').style.display = "none";
	}	
};		
function addSelectors() {
    var op1 = document.getElementsByClassName("pay-plan")[0];
        op1.id="option1"
	var op2 = document.getElementsByClassName("pay-plan")[1];
		op2.id="option2"
	var op3 = document.getElementsByClassName("pay-plan")[2];
		op3.id="option3"
	var op4 = document.getElementsByClassName("pay-plan")[3];
		op4.id="option4"
//	var op5 = document.getElementsByClassName("pay-plan")[4];
//		op5.id="option5"	
}	
//}, 500);
    
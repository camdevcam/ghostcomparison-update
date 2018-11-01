//setTimeout(function(){

//  window.addEventListener("load", function(event) {
      
    function addEventHandler(elem, eventType, handler) {
        if (elem.addEventListener)
            elem.addEventListener (eventType, handler, false);
        else if (elem.attachEvent)
            elem.attachEvent ('on' + eventType, handler); 
    }

    var cssId = 'supportCss'; 
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
        } else {
            document.getElementById('field_52_116').style.display = "none";
        }        
        ChngGo();
        ChkAgain (); 
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
//            document.getElementById('option2').style.display = "none";
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
        } else {
            document.getElementById('field_52_116').style.display = "none";
        }
    };	

    setInterval( addSelectors, 500);

    function ChngGo (){
         addEventHandler(document, 'DOMContentLoaded', function () {
            addEventHandler(document.getElementById('gform_fields_52'), 'change', 

            function() {
              setInterval( myValidateFunction, 500);
            });
//            ChkAgain (); 
         });   
    }

    setInterval( myValidateFunction2, 500);    
    setInterval( PayBtns, 500);  

    function ChkAgain (){
        setInterval( myValidateFunction, 500);
    }

   function myValidateFunction2 () { 	
        var inElgbl =  document.getElementById('field_52_116');
        if (typeof(inElgbl) != 'undefined' && inElgbl != null)
        { 
            document.getElementById('field_52_24').style.display = "none";
            document.getElementsByClassName('gsection_title').style.display = "none"; 
        }	
    }

    function PayBtns() { 
        var classname = document.getElementsByClassName("pay-plan-button");

        function chckPayClk() {
          document.getElementById('field_52_110').style.display = "none";
          document.getElementById('gform_submit_button_52').style.display = "block";
          ChngGo2();    
        }

        for (var i = 0; i < classname.length; i++) {
          classname[i].addEventListener('click', chckPayClk, false);
        }
    
    }

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

    function ChngGo2() { 
        var timesClicked = 0;
        document.querySelectorAll('#gform_fields_52')[0].addEventListener('click', function () {
            timesClicked++;

            if (timesClicked > 1) {    
                    setTimeout(jumpRate, 2000);
                    function jumpRate(){
                        var top = document.getElementById("rate").offsetTop;
                        window.scrollTo(1000, top);
                    }
                } 
            });
    }

//}, false);
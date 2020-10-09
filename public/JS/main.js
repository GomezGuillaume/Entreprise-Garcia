document.addEventListener('DOMContentLoaded',function(event){

    var dataText = [ "Peinture décorative", "Peinture intérieur et extérieur", "Ratissage des fonds", "Pose de parquet / lino", "Dalles / Lames PVC"];

    function typeWriter(text, i, fnCallback) {

        if (i < (text.length)) {
            // add next character to h1
            document.querySelector("h3").innerHTML = text.substring(0, i+1) +'<span aria-hidden="true"></span>';

            setTimeout(function() {
                typeWriter(text, i + 1, fnCallback)
            }, 100);
        }

        else if (typeof fnCallback == 'function') {

            setTimeout(fnCallback, 2000);
        }
    }

    function StartTextAnimation(i) {
        if (typeof dataText[i] == 'undefined'){
            setTimeout(function() {
                StartTextAnimation(0);
            }, 20000);
        }

        if (i < dataText[i].length) {

            typeWriter(dataText[i], 0, function(){

                StartTextAnimation(i + 1);
            });
        }
    }

    StartTextAnimation(0);
});
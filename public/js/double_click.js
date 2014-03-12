/*
    Prevent double-click posts
    @author Aidan Grabe
*/
(function(){
    var delayTime = 1000;       // the time to delay for in seconds

    window.addEvent = function(el, eventName, callback) {
        if (el.addEventListener) {
            el.addEventListener(eventName, callback);
        } else {
            el.attachEvent('on' + eventName, callback);
        }
    }

    // get all forms
    var forms = document.getElementsByTagName('form');

    for (var i = 0; i < forms.length; i++) {
        var form = forms[i];
        var submit = form.querySelector('input[type=submit]');
        window.addEvent(submit, 'click', function(e) {
            //e.preventDefault();
            form.submit();
            submit.disabled = true;
            setTimeout(function() {
                submit.disabled = false;
            }, delayTime);
        });
    }

})();

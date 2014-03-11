(function() {

    var forms = function() {
        var me = this;
        this.ignore = ['address', 'address1', 'address2'];

        var xmlhttp = new XMLHttpRequest();

        this.ajax = function(url, data, callback) {
            var params = "";
            for (var key in data) {
                if (params != "") {
                    params += "&";
                }
                params += key + "=" + data[key];
            }

            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    callback(xmlhttp.responseText);
                }
            }

            xmlhttp.open("POST", url, true);

            xmlhttp.setRequestHeader('Content-Type', "application/x-www-form-urlencoded");

            xmlhttp.send(params);
        }

        this.validateField = function(el) {
            if (el) {
                fieldName = el.getAttribute('name');
                data = {field: el.value};
                if (!(typeof modelId === 'undefined')) {data.id = modelId;}
                if (fieldName.indexOf('password') > -1) return;
                if (me.ignore.indexOf(fieldName) > -1) return;
                me.ajax("/api/validation/" + model + "/" + fieldName, data, function(response) {
                    response = JSON.parse(response);
                    response.messages = JSON.parse(response.messages);
                    var span = el.parentNode.getElementsByTagName('span')[0];
                    var fieldName = el.getAttribute('name');
                    if (response.valid && response.success) {
                        span.innerText = '';
                        el.style.borderColor = '#22AA22';
                    } else {
                        span.innerText = response.messages[fieldName][0];
                        el.style.borderColor = '#FF5555';
                    }
                });
            }
        }

        var inputs = document.getElementsByTagName('input');
        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].addEventListener) {
                var input = inputs[i];
                var span = document.createElement('span');
                input.parentNode.appendChild(span);
                inputs[i].addEventListener('blur', function() {
                    me.validateField(this);
                });
            } else {
                var input = inputs[i];
                var span = document.createElement('span');
                input.parentNode.appendChild(span);
                inputs[i].addEventListener('blur', function() {
                    me.validateField(this);
                });
            }
        }
    }

    new forms();

})();


(function() {
    var password = document.getElementById('password');
    var password_confirmation = document.getElementById('password_confirmation');
    var label = document.createElement('span');
    if (password) {
        password.parentNode.appendChild(label);
    }
    function check_passwords() {
        if (password.value != password_confirmation.value) {
            password.style.borderColor = '#FF5555';
            label.innerText = 'Passwords do not match';
        } else {
            password.style.borderColor = '#33AA33';
            label.innerText = '';
        }
    };

    if (password && password_confirmation) {
        if (password.addEventListener) {
            password.addEventListener('keyup', check_passwords);
            password_confirmation.addEventListener('keyup', check_passwords);
        } else {
            password.attacheEvent('onkeyup', check_passwords);
            password_confirmation.attachEvent('onkeyup', check_passwords);
        }
    }
})();

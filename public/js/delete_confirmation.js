(function() {
    function on_link_click(event) {
        event.preventDefault();
        if (confirm('Are you sure you want to delete this page?')) {
            document.location = this.getAttribute('href');
        };
    }

    var delete_buttons = document.querySelectorAll('a.delete');
    for (var i = 0; i < delete_buttons.length; i++) {
        var el = delete_buttons[i];

        // attach the event
        if (el.addEventListener) {
            el.addEventListener('click', on_link_click);
        } else {
            el.attachEvent('onclick', on_link_click);
        }
    }
})();

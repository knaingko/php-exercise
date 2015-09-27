//Go Top
$('.gotop').click(function(event) {
    event.preventDefault();
    $('html, body').animate({
        scrollTop: $("body").offset().top
    }, 500);
});
//Active Menu
$(document).ready(function () {
    var url = window.location;
    $('ul.nav a[href="' + this.location.pathname + '"]').parent().addClass('active');

    $('ul.nav a').filter(function() {
        return this.href == url;
    }).parent().parent().parent().addClass('active');
});

//Sub Menu
$('[data-submenu]').submenupicker();
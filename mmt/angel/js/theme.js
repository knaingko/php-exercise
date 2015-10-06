$('.carousel').carousel({
    interval: 3000
})

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
    // Will only work if string in href matches with location
    //$('ul.nav a[href="' + url + '"]').parent().addClass('active');

    // Will also work for relative and absolute hrefs
    $('ul.nav a').filter(function () {
        return this.href == url;
    }).parent().addClass('active').parent().parent().addClass('active');
});


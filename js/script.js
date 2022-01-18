var menuMobile = document.getElementById('testmobile');


function openNav() {
    $('.fa-bars').addClass('display-none');
    $('.nav2').css('display', 'flex');
    $('.fa-times').removeClass('display-none');
    $('.fa-times').addClass('display-croix');
}

function closeNav() {
    $('.nav2').css('display', 'none');
    $('.fa-times').removeClass('display-croix');
    $('.fa-times').addClass('display-none');
    $('.fa-bars').removeClass('display-none');
    $('.fa-bars').addClass('display-block');

}
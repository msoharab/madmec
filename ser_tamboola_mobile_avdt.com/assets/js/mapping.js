var mapping = {
    menu1: '<i class="fa fa-user fa-2x fa-fw"></i>Profile',
    menu2: '<i class="fa fa-cogs fa-2x fa-fw"></i>Gym',
    menu3: '<i class="fa fa-gift fa-2x fa-fw"></i>Offers',
    menu4: '<i class="fa fa-shopping-cart fa-2x fa-fw"></i>Packages',
    menu5: '<i class="fa fa-sign-out fa-2x fa-fw"></i>SignOut',
};
$(document).ready(function () {
    $('#menu1').html(mapping.menu1);
    $('#menu2').html(mapping.menu2);
    $('#menu3').html(mapping.menu3);
    $('#menu4').html(mapping.menu4);
    $('#menu5').html(mapping.menu5);
});
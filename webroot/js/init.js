$(document).ready(function(){
    M.updateTextFields();
    $('.sidenav').sidenav();
    $('.materialboxed').materialbox();
    $(".dropdown-trigger").dropdown({ hover: true });
    $('.tooltipped').tooltip();
    
    $(".search-anchor").click(function(){
        $("#search-bar").fadeToggle();
    });
    
    $(".approved-anchor").click(function(){
        $(".cancelled-team").fadeToggle();
        
        $(".approved-anchor").toggleClass('habitat-brick habitat-green');
    });
    
});
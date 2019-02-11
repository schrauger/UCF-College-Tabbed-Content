// Tab menu handler
jQuery( document ).ready(function($) {
    $('.toggle').click(function(event, element){
        var section_name = $(this).data('id');
        //console.log(section_name);
        $('.menu-expanded[for="' + section_name + '"]').show();
        $('.menu-expanded[for!="' + section_name + '"]').hide();
        event.preventDefault();
    });
    $('select.mobile').on('change', function(event, element){
        var section_name = $(this).find(":checked").data('id');
        //console.log(section_name);
        $('.menu-expanded[for="' + section_name + '"]').show();
        $('.menu-expanded[for!="' + section_name + '"]').hide();
        event.preventDefault();
    });
    // have the first section be pre-expanded
    var section_name = $('.toggle').first().data('id');
    $('.menu-expanded[for="' + section_name + '"]').show();
});

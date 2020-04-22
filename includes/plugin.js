// Tab menu handler
jQuery( document ).ready(function($) {
    $(document).on('click','.toggle', function(event, element){
        var section_name = $(this).data('id');
        //console.log(section_name);
        $('.menu-expanded[for="' + section_name + '"]').show();
        $('.menu-expanded[for!="' + section_name + '"]').hide();
        $('.tab-active').removeClass('tab-active');
        $(this).addClass('tab-active');
        event.preventDefault();
    });
    $(document).on('change','select.mobile', function(event, element){
        var section_name = $(this).find(":checked").data('id');
        //console.log(section_name);
        $('.menu-expanded[for="' + section_name + '"]').show();
        $('.menu-expanded[for!="' + section_name + '"]').hide();
        $('.tab-active').removeClass('tab-active');
        $(this).addClass('tab-active');
        event.preventDefault();
    });
    // have the first tab be pre-opened
    var section_name = $('.toggle').first().click();
});

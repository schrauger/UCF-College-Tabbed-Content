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

jQuery(document).ready(function() {

    // use javascript to disable the legacy ACF fields, while allowing the same fields inside Blocks to be editable.
    // Since both the old and new fields have the same ACF definitions, we can't modify the ACF field declaration
    // to disable the fields, as that would affect blocks as well. Instead, we target the fields with javascript.

    const observer = new MutationObserver(function(mutations_list, observer) {

        for (let mutation of mutations_list) {

            if (mutation.type === 'childList') {
                mutation.addedNodes.forEach(function(added_node) {

                    // acf loads the group fields in as a whole, which skips the mutation for each individual element.
                    // this means we must walk through the newly added node to find its child nodes.
                    const treeWalker = document.createTreeWalker(added_node);
                    let currentNode = treeWalker.currentNode;
                    while (currentNode) {
                        if (currentNode.id == 'acf-group_5c59e0b493529') {
                            jQuery(currentNode).find('input').each(function() {jQuery(this).prop('readonly', true)});   // make inputs readonly
                            jQuery(currentNode).find('[data-type="link"] .acf-js-tooltip').remove();                    // hide the pencil editor icon for the web link
                            jQuery(currentNode).find('[data-type="image"] .acf-icon').remove();                         // hide the pencil editor icon for the images
                            jQuery(currentNode).find('[data-event="add-row"]').remove();                                // remove the 'add-row' buttons
                            jQuery(currentNode).find('[data-event="remove-row"]').remove();                             // remove the 'remove-row' buttons
                            observer.disconnect(); // stop listening to save on resources
                        }
                        currentNode = treeWalker.nextNode();
                    }
                });
            } else if (mutation.type === 'attributes') {
                console.log('attempt');
                jQuery('#acf-group_5c59e0b493529').find('input').each(function() {jQuery(this).prop('readonly', true)});
                jQuery('#acf-group_5c59e0b493529').find('[data-type="link"] .acf-js-tooltip').remove();
            } else {
                console.log('other type: ' + mutation.type);
            }
        }
    });

    observer.observe(document.querySelector("#editor"), { subtree: true, childList: true });
});
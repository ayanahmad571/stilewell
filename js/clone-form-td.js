

$(function () {
    $('#btnAdd2').click(function () {
        var num     = $('.clonedInput2').length, // Checks to see how many "duplicatable" input fields we currently have
            newNum  = new Number(num + 1),      // The numeric ID of the new input field being added, increasing by 1 each time
            newElem = $('#dependants_entry' + num).clone().attr('id', 'dependants_entry' + newNum).fadeIn('slow'); // create the new element via clone(), and manipulate it's ID using newNum value
    
    /*  This is where we manipulate the name/id values of the input inside the new, cloned element
        Below are examples of what forms elements you can clone, but not the only ones.
        There are 2 basic structures below: one for an H2, and one for form elements.
        To make more, you can copy the one for form elements and simply update the classes for its label and input.
        Keep in mind that the .val() method is what clears the element when it gets cloned. Radio and checkboxes need .val([]) instead of .val('').
    */


	     // dependants_name - text

         newElem.find('.add_inr_topic_rel_id').attr('for', 'add_inr_topic_rel_id' + newNum);
        newElem.find('.add_inr_topic_rel_id').attr('id', 'add_inr_topic_rel_id' + newNum).attr('value', 'add_inr_topic_rel_id' + newNum).val(newNum);



        newElem.find('.add_inr_inst').attr('for', 'add_inr_inst' + newNum);
        newElem.find('.add_inr_inst').attr('id', 'add_inr_inst' + newNum).attr('name', 'add_inr_inst' + newNum).val('');


        // dependants_dob - text
        newElem.find('.add_inr_inst_ico').attr('for', 'add_inr_inst_ico' + newNum);
        newElem.find('.add_inr_inst_ico').attr('id', 'add_inr_inst_ico' + newNum).attr('name', 'add_inr_inst_ico' + newNum).val('');

        // dependants_relationship - text
        newElem.find('.add_inr_inst_img').attr('for', 'add_inr_inst_img' + newNum);
        newElem.find('.add_inr_inst_img').attr('id', 'add_inr_inst_img' + newNum).attr('name', 'add_inr_inst_img' + newNum).val('');
		


    // Insert the new element after the last "duplicatable" input field
        $('#dependants_entry' + num).after(newElem);
        $('#ID' + newNum + '_title').focus();

    // Enable the "remove" button. This only shows once you have a duplicated section.
        $('#btnDel2').attr('disabled', false);

    // Right now you can only add 4 sections, for a total of 5. Change '5' below to the max number of sections you want to allow.
        if (newNum == 30)
        $('#btnAdd2').attr('disabled', true).prop('value', "You've reached the limit"); // value here updates the text in the 'add' button when the limit is reached 
    });

    $('#btnDel2').click(function () {
    // Confirmation dialog box. Works on all desktop browsers and iPhone.
        if (confirm("Are you sure you wish to remove this section? This cannot be undo."))
            {
                var num = $('.clonedInput2').length;
                // how many "duplicatable" input fields we currently have
                $('#dependants_entry' + num).slideUp('slow', function () {$(this).remove();
                // if only one element remains, disable the "remove" button
                    if (num -1 === 1)
                $('#btnDel2').attr('disabled', true);
                // enable the "add" button
                $('#btnAdd2').attr('disabled', false).prop('value', "Add More");});
            }
        return false; // Removes the last section you added
    });
    // Enable the "add" button
    $('#btnAdd2').attr('disabled', false);
    // Disable the "remove" button
    $('#btnDel2').attr('disabled', true);

});



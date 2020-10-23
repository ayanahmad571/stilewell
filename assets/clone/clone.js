/*
Author: Tristan Denyer (based on Charlie Griefer's original clone code, and some great help from Dan - see his comments in blog post)
Plugin and demo at http://tristandenyer.com/using-jquery-to-duplicate-a-section-of-a-form-maintaining-accessibility/
Ver: 0.9.4
Date: Aug 25, 2013
*/

//First Button dependants

$(function () {
    $('#btnAdd').click(function () {
        var num     = $('.clonedInput').length, // Checks to see how many "duplicatable" input fields we currently have
            newNum  = new Number(num + 1),      // The numeric ID of the new input field being added, increasing by 1 each time
            newElem = $('#entry' + num).clone().attr('id', 'entry' + newNum).fadeIn('slow'); // create the new element via clone(), and manipulate it's ID using newNum value
    
    /*  This is where we manipulate the name/id values of the input inside the new, cloned element
        Below are examples of what forms elements you can clone, but not the only ones.
        There are 2 basic structures below: one for an H2, and one for form elements.
        To make more, you can copy the one for form elements and simply update the classes for its label and input.
        Keep in mind that the .val() method is what clears the element when it gets cloned. Radio and checkboxes need .val([]) instead of .val('').
    */
        // H2 - section
        newElem.find('.heading-reference').attr('id', 'ID' + newNum + '_reference').attr('name', 'ID' + newNum + '_reference').html('Entry #' + newNum);




         newElem.find('.collagerow').attr('for', 'collagerow' + newNum);
        newElem.find('.collagerow').attr('id', 'collagerow' + newNum).attr('value', 'collagerow' + newNum).val(newNum);



        // examination_passed1 - text
        newElem.find('.add_st_father_email_ok').attr('id', 'add_st_father_email_ok' + newNum).attr('name', 'add_st_father_email_ok' + newNum).val('');
        // collage1 - text
        newElem.find('.add_st_mother_email_ok').attr('id', 'add_st_mother_email_ok' + newNum).attr('name', 'add_st_mother_email_ok' + newNum).val('');


    // Insert the new element after the last "duplicatable" input field
        $('#entry' + num).after(newElem);
        $('#ID' + newNum + '_title').focus();

    // Enable the "remove" button. This only shows once you have a duplicated section.
        $('#btnDel').attr('disabled', false);

    // Right now you can only add 4 sections, for a total of 5. Change '5' below to the max number of sections you want to allow.
        if (newNum == 50)
        $('#btnAdd').attr('disabled', true).prop('value', "You've reached the limit"); // value here updates the text in the 'add' button when the limit is reached 
    });

    $('#btnDel').click(function () {
    // Confirmation dialog box. Works on all desktop browsers and iPhone.
        if (confirm("Are you sure you wish to remove this section? This cannot be undo."))
            {
                var num = $('.clonedInput').length;
                // how many "duplicatable" input fields we currently have
                $('#entry' + num).slideUp('slow', function () {$(this).remove();
                // if only one element remains, disable the "remove" button
                    if (num -1 === 1)
                $('#btnDel').attr('disabled', true);
                // enable the "add" button
                $('#btnAdd').attr('disabled', false).prop('value', "Add More");});
            }
        return false; // Removes the last section you added
    });
    // Enable the "add" button
    $('#btnAdd').attr('disabled', false);
    // Disable the "remove" button
    $('#btnDel').attr('disabled', true);
});






//second button


$(function () {
    $('#btnAdd1').click(function () {
        var num     = $('.clonedInput1').length, // Checks to see how many "duplicatable" input fields we currently have
            newNum  = new Number(num + 1),      // The numeric ID of the new input field being added, increasing by 1 each time
            newElem = $('#employer_entry' + num).clone().attr('id', 'employer_entry' + newNum).fadeIn('slow'); // create the new element via clone(), and manipulate it's ID using newNum value
    
    /*  This is where we manipulate the name/id values of the input inside the new, cloned element
        Below are examples of what forms elements you can clone, but not the only ones.
        There are 2 basic structures below: one for an H2, and one for form elements.
        To make more, you can copy the one for form elements and simply update the classes for its label and input.
        Keep in mind that the .val() method is what clears the element when it gets cloned. Radio and checkboxes need .val([]) instead of .val('').
    */


         newElem.find('.employerrowno').attr('for', 'employerrowno' + newNum);
        newElem.find('.employerrowno').attr('id', 'employerrowno' + newNum).attr('value', 'employerrowno' + newNum).val(newNum);



	     // employer_name - text
        newElem.find('.employer_name').attr('for', 'employer_name' + newNum);
        newElem.find('.employer_name').attr('id', 'employer_name' + newNum).attr('name', 'employer_name' + newNum).val('');


        // employer_add - text
        newElem.find('.employer_address').attr('for', 'employer_address' + newNum);
        newElem.find('.employer_address').attr('id', 'employer_address' + newNum).attr('name', 'employer_address' + newNum).val('');

        // position_held - text
        newElem.find('.position_held').attr('for', 'position_held' + newNum);
        newElem.find('.position_held').attr('id', 'position_held' + newNum).attr('name', 'position_held' + newNum).val('');
		
        // employed_from - text
        newElem.find('.employed_from').attr('for', 'employed_from' + newNum);
        newElem.find('.employed_from').attr('id', 'employed_from' + newNum).attr('name', 'employed_from' + newNum).val('');
		
		// employed_to - text
        newElem.find('.employed_to').attr('for', 'employed_to' + newNum);
        newElem.find('.employed_to').attr('id', 'employed_to' + newNum).attr('name', 'employed_to' + newNum).val('');
		
		
		// reason - text
        newElem.find('.reason_for_leaving').attr('for', 'reason_for_leaving' + newNum);
        newElem.find('.reason_for_leaving').attr('id', 'reason_for_leaving' + newNum).attr('name', 'reason_for_leaving' + newNum).val('');
		
		
		
		// salary_last_drawn_basic - text
        newElem.find('.total_starting_salary').attr('for', 'total_starting_salary' + newNum);
        newElem.find('.total_starting_salary').attr('id', 'total_starting_salary' + newNum).attr('name', 'total_starting_salary' + newNum).val('');		
		
		
		// salary_last_drawn_basic - text
        newElem.find('.salary_last_drawn_basic').attr('for', 'salary_last_drawn_basic' + newNum);
        newElem.find('.salary_last_drawn_basic').attr('id', 'salary_last_drawn_basic' + newNum).attr('name', 'salary_last_drawn_basic' + newNum).val('');
		
		
		// salary_last_drawn_total - text
        newElem.find('.salary_last_drawn_total').attr('for', 'salary_last_drawn_total' + newNum);
        newElem.find('.salary_last_drawn_total').attr('id', 'salary_last_drawn_total' + newNum).attr('name', 'salary_last_drawn_total' + newNum).val('');
		
		

		
		


    // Insert the new element after the last "duplicatable" input field
        $('#employer_entry' + num).after(newElem);
        $('#ID' + newNum + '_title').focus();

    // Enable the "remove" button. This only shows once you have a duplicated section.
        $('#btnDel1').attr('disabled', false);

    // Right now you can only add 4 sections, for a total of 5. Change '5' below to the max number of sections you want to allow.
        if (newNum == 20)
        $('#btnAdd1').attr('disabled', true).prop('value', "You've reached the limit"); // value here updates the text in the 'add' button when the limit is reached 
    });

    $('#btnDel1').click(function () {
    // Confirmation dialog box. Works on all desktop browsers and iPhone.
        if (confirm("Are you sure you wish to remove this section? This cannot be undo."))
            {
                var num = $('.clonedInput1').length;
                // how many "duplicatable" input fields we currently have
                $('#employer_entry' + num).slideUp('slow', function () {$(this).remove();
                // if only one element remains, disable the "remove" button
                    if (num -1 === 1)
                $('#btnDel1').attr('disabled', true);
                // enable the "add" button
                $('#btnAdd1').attr('disabled', false).prop('value', "Add More");});
            }
        return false; // Removes the last section you added
    });
    // Enable the "add" button
    $('#btnAdd1').attr('disabled', false);
    // Disable the "remove" button
    $('#btnDel1').attr('disabled', true);
});




//third button


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

         newElem.find('.dependantrowno').attr('for', 'dependantrowno' + newNum);
        newElem.find('.dependantrowno').attr('id', 'dependantrowno' + newNum).attr('value', 'dependantrowno' + newNum).val(newNum);



        newElem.find('.dependants_name').attr('for', 'dependants_name' + newNum);
        newElem.find('.dependants_name').attr('id', 'dependants_name' + newNum).attr('name', 'dependants_name' + newNum).val('');


        // dependants_dob - text
        newElem.find('.dependants_dob').attr('for', 'dependants_dob' + newNum);
        newElem.find('.dependants_dob').attr('id', 'dependants_dob' + newNum).attr('name', 'dependants_dob' + newNum).val('');

        // dependants_relationship - text
        newElem.find('.dependants_relationship').attr('for', 'dependants_relationship' + newNum);
        newElem.find('.dependants_relationship').attr('id', 'dependants_relationship' + newNum).attr('name', 'dependants_relationship' + newNum).val('');
		


    // Insert the new element after the last "duplicatable" input field
        $('#dependants_entry' + num).after(newElem);
        $('#ID' + newNum + '_title').focus();

    // Enable the "remove" button. This only shows once you have a duplicated section.
        $('#btnDel2').attr('disabled', false);

    // Right now you can only add 4 sections, for a total of 5. Change '5' below to the max number of sections you want to allow.
        if (newNum == 20)
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




//fourth button


$(function () {
    $('#btnAdd3').click(function () {
        var num     = $('.clonedInput3').length, // Checks to see how many "duplicatable" input fields we currently have
            newNum  = new Number(num + 1),      // The numeric ID of the new input field being added, increasing by 1 each time
            newElem = $('#particulars_entry' + num).clone().attr('id', 'particulars_entry' + newNum).fadeIn('slow'); // create the new element via clone(), and manipulate it's ID using newNum value
    
    /*  This is where we manipulate the name/id values of the input inside the new, cloned element
        Below are examples of what forms elements you can clone, but not the only ones.
        There are 2 basic structures below: one for an H2, and one for form elements.
        To make more, you can copy the one for form elements and simply update the classes for its label and input.
        Keep in mind that the .val() method is what clears the element when it gets cloned. Radio and checkboxes need .val([]) instead of .val('').
    */





         newElem.find('.particularsrowno').attr('for', 'particularsrowno' + newNum);
        newElem.find('.particularsrowno').attr('id', 'particularsrowno' + newNum).attr('value', 'particularsrowno' + newNum).val(newNum);


	     // dependants_name - text
        newElem.find('.particulars_training').attr('for', 'particulars_training' + newNum);
        newElem.find('.particulars_training').attr('id', 'particulars_training' + newNum).attr('name', 'particulars_training' + newNum).val('');


        // dependants_dob - text
        newElem.find('.particulars_fromdate').attr('for', 'particulars_fromdate' + newNum);
        newElem.find('.particulars_fromdate').attr('id', 'particulars_fromdate' + newNum).attr('name', 'particulars_fromdate' + newNum).val('');

        // dependants_relationship - text
        newElem.find('.particulars_todate').attr('for', 'particulars_todate' + newNum);
        newElem.find('.particulars_todate').attr('id', 'particulars_todate' + newNum).attr('name', 'particulars_todate' + newNum).val('');
		


    // Insert the new element after the last "duplicatable" input field
        $('#particulars_entry' + num).after(newElem);
        $('#ID' + newNum + '_title').focus();

    // Enable the "remove" button. This only shows once you have a duplicated section.
        $('#btnDel3').attr('disabled', false);

    // Right now you can only add 4 sections, for a total of 5. Change '5' below to the max number of sections you want to allow.
        if (newNum == 20)
        $('#btnAdd3').attr('disabled', true).prop('value', "You've reached the limit"); // value here updates the text in the 'add' button when the limit is reached 
    });

    $('#btnDel3').click(function () {
    // Confirmation dialog box. Works on all desktop browsers and iPhone.
        if (confirm("Are you sure you wish to remove this section? This cannot be undo."))
            {
                var num = $('.clonedInput3').length;
                // how many "duplicatable" input fields we currently have
                $('#particulars_entry' + num).slideUp('slow', function () {$(this).remove();
                // if only one element remains, disable the "remove" button
                    if (num -1 === 1)
                $('#btnDel3').attr('disabled', true);
                // enable the "add" button
                $('#btnAdd3').attr('disabled', false).prop('value', "Add More");});
            }
        return false; // Removes the last section you added
    });
    // Enable the "add" button
    $('#btnAdd3').attr('disabled', false);
    // Disable the "remove" button
    $('#btnDel3').attr('disabled', true);

});



//Fifth button


$(function () {
    $('#btnAdd4').click(function () {
        var num     = $('.clonedInput4').length, // Checks to see how many "duplicatable" input fields we currently have
            newNum  = new Number(num + 1),      // The numeric ID of the new input field being added, increasing by 1 each time
            newElem = $('#postentry' + num).clone().attr('id', 'postentry' + newNum).fadeIn('slow'); // create the new element via clone(), and manipulate it's ID using newNum value
    
    /*  This is where we manipulate the name/id values of the input inside the new, cloned element
        Below are examples of what forms elements you can clone, but not the only ones.
        There are 2 basic structures below: one for an H2, and one for form elements.
        To make more, you can copy the one for form elements and simply update the classes for its label and input.
        Keep in mind that the .val() method is what clears the element when it gets cloned. Radio and checkboxes need .val([]) instead of .val('').
    */

//         newElem.find('.particularsrowno').attr('for', 'particularsrowno' + newNum);
//         newElem.find('.particularsrowno').attr('id', 'particularsrowno' + newNum).attr('value', 'particularsrowno' + newNum).val(newNum);


	     // faculty_id- text
        newElem.find('.faculty_id').attr('for', 'faculty_id' + newNum);
        newElem.find('.faculty_id').attr('id', 'faculty_id' + newNum).attr('name', 'faculty_id' + newNum).val('');


        // wing_id - text
        newElem.find('.wing_id').attr('for', 'wing_id' + newNum);
        newElem.find('.wing_id').attr('id', 'wing_id' + newNum).attr('name', 'wing_id' + newNum).val('');

        // profile_id - text
        newElem.find('.profile_id').attr('for', 'profile_id' + newNum);
        newElem.find('.profile_id').attr('id', 'profile_id' + newNum).attr('name', 'profile_id' + newNum).val('');
		
        // sub_id - text
        newElem.find('.sub_id').attr('for', 'sub_id' + newNum);
        newElem.find('.sub_id').attr('id', 'sub_id' + newNum).attr('name', 'sub_id' + newNum).val('');
		
		
        // sub_id - text
        newElem.find('.class_id').attr('for', 'class_id' + newNum);
        newElem.find('.class_id').attr('id', 'class_id' + newNum).attr('name', 'class_id' + newNum).val('');
		


    // Insert the new element after the last "duplicatable" input field
        $('#postentry' + num).after(newElem);
        $('#ID' + newNum + '_title').focus();

    // Enable the "remove" button. This only shows once you have a duplicated section.
        $('#btnDel4').attr('disabled', false);

    // Right now you can only add 4 sections, for a total of 5. Change '5' below to the max number of sections you want to allow.
        if (newNum == 20)
        $('#btnAdd4').attr('disabled', true).prop('value', "You've reached the limit"); // value here updates the text in the 'add' button when the limit is reached 
    });

    $('#btnDel4').click(function () {
    // Confirmation dialog box. Works on all desktop browsers and iPhone.
        if (confirm("Are you sure you wish to remove this section? This cannot be undo."))
            {
                var num = $('.clonedInput4').length;
                // how many "duplicatable" input fields we currently have
                $('#postentry' + num).slideUp('slow', function () {$(this).remove();
                // if only one element remains, disable the "remove" button
                    if (num -1 === 1)
                $('#btnDel4').attr('disabled', true);
                // enable the "add" button
                $('#btnAdd4').attr('disabled', false).prop('value', "Add More");});
            }
        return false; // Removes the last section you added
    });
    // Enable the "add" button
    $('#btnAdd4').attr('disabled', false);
    // Disable the "remove" button
    $('#btnDel4').attr('disabled', true);

});

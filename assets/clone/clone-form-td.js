//add
$(function () {
  $('#btnAdd').click(function () {
    var num     = $('.clonedInput').length, // Checks to see how many "duplicatable" input fields we currently have
    newNum  = new Number(num + 1),      // The numeric ID of the new input field being added, increasing by 1 each time
    newElem = $('#add' + num).clone().attr('id', 'add' + newNum).fadeIn('slow');
    // create the new element via clone(), and manipulate it's ID using newNum value
    /*  This is where we manipulate the name/id values of the input inside the new, cloned element
    Below are examples of what forms elements you can clone, but not the only ones.
    There are 2 basic structures below: one for an H2, and one for form elements.
    To make more, you can copy the one for form elements and simply update the classes for its label and input.
    Keep in mind that the .val() method is what clears the element when it gets cloned. Radio and checkboxes need .val([]) instead of .val('').
    
    newElem.find('.jr_id_munex').attr('id', 'jr_id_munex' + newNum).attr('value', 'jr_id_munex' + newNum).val(newNum);*/
	
	
    // examination_passed1 - text
    $('#rev_nos').val(newNum);
	//njk
    newElem.find('.add_revision_quote_product_a').attr('id', 'add_revision_quote_product_a' + newNum).attr('name', 'add_revision_quote_product_a' + newNum).val('-');
    // collage1 - text
    newElem.find('.add_revision_quote_price_a').attr('id', 'add_revision_quote_price_a' + newNum).attr('name', 'add_revision_quote_price_a' + newNum).val('0');
    newElem.find('.add_revision_quote_desc_a').attr('id', 'add_revision_quote_desc_a' + newNum).attr('name', 'add_revision_quote_desc_a' + newNum).val('-');
    // board - text
    newElem.find('.add_revision_quote_qty_a').attr('id', 'add_revision_quote_qty_a' + newNum).attr('name', 'add_revision_quote_qty_a' + newNum).val('0');
	newElem.find('.add_revision_quote_cost_a').attr('id', 'add_revision_quote_cost_a' + newNum).attr('name', 'add_revision_quote_cost_a' + newNum).val('0');
	
    newElem.find('.add_revision_quote_script').attr('id', 'add_revision_quote_script' + newNum).html(
	'<script type="text/javascript">$(document).ready(function() {	$(\'#add_revision_quote_product_a'+ newNum +'\').change(function(){		var tx = $(this).children(\'option:selected\').data(\'id\');				$.post("master_action.php", {prid: tx}, function(result){					result = $.parseJSON( result );$("#add_revision_quote_desc_a'+ newNum +'").val(result.desc); $("#add_revision_quote_cost_a'+ newNum +'").val(result.cost);});} );} );</script>');
    // year_enter - text
   
    // Insert the new element after the last "duplicatable" input field
    $('#add' + num).after(newElem);
    $('#ID' + newNum + '_title').focus();
    // Enable the "remove" button. This only shows once you have a duplicated section.
    $('#btnDel').attr('disabled', false);
    // Right now you can only add 4 sections, for a total of 5. Change '5' below to the max number of sections you want to allow.
	 myFunct(newNum);
    if (newNum == 1000)
    $('#btnAdd').attr('disabled', true).prop('value', "You've reached the limit");
    // value here updates the text in the 'add' button when the limit is reached 
  }
                    );
  $('#btnDel').click(function () {
    // Confirmation dialog box. Works on all desktop browsers and iPhone.
    if (confirm("Are you sure you wish to remove this section? This cannot be undo."))
    {
      var num = $('.clonedInput').length;
      // how many "duplicatable" input fields we currently have
      $('#add' + num).slideUp('slow', function () {
        $(this).remove();
		 $('#rev_nos').val(num - 1);

        // if only one element remains, disable the "remove" button
        if (num -1 === 1)
          $('#btnDel').attr('disabled', true);
        // enable the "add" button
        $('#btnAdd').attr('disabled', false).prop('value', "Add More");
      }
                               );
    }
    return false;
    // Removes the last section you added
  }
                    );
  // Enable the "add" button
  $('#btnAdd').attr('disabled', false);
  // Disable the "remove" button
  $('#btnDel').attr('disabled', true);
}
 );

$.fn.extend({
    clearFiles: function () {
        $(this).each(function () {
            var isIE = (window.navigator.userAgent.indexOf("MSIE ") > 0 || !! navigator.userAgent.match(/Trident.*rv\:11\./));
            if ($(this).prop("type") == 'file') {
                if (isIE == true) {
                    $(this).replaceWith($(this).val('').clone(true));
                } else {
                    $(this).val("");
                }
            }
        });
        return this;
    }
});
//gfde
$(function () {
  $('#btnAdd2').click(function () {
    var num     = $('.twoclonedInput').length, // Checks to see how many "duplicatable" input fields we currently have
    newNum  = new Number(num + 1),      // The numeric ID of the new input field being added, increasing by 1 each time
    newElem = $('#quoteadd' + num).clone().attr('id', 'quoteadd' + newNum).fadeIn('slow');
    // create the new element via clone(), and manipulate it's ID using newNum value
    /*  This is where we manipulate the name/id values of the input inside the new, cloned element
    Below are examples of what forms elements you can clone, but not the only ones.
    There are 2 basic structures below: one for an H2, and one for form elements.
    To make more, you can copy the one for form elements and simply update the classes for its label and input.
    Keep in mind that the .val() method is what clears the element when it gets cloned. Radio and checkboxes need .val([]) instead of .val('').
    
    newElem.find('.jr_id_munex').attr('id', 'jr_id_munex' + newNum).attr('value', 'jr_id_munex' + newNum).val(newNum);*/
	
	
    // examination_passed1 - text
    $('#qot_nos').val(newNum);
	//njk
    newElem.find('.add_quote_product').attr('id', 'add_quote_product' + newNum).attr('name', 'add_quote_product' + newNum).val('-');
	//ima
    newElem.find('.add_quote_product_images_1_a').attr('id', 'add_quote_product_images_1_a' + newNum).attr('name', 'add_quote_product_images_1_a' + newNum).clearFiles();
    newElem.find('.add_quote_product_images_2_a').attr('id', 'add_quote_product_images_2_a' + newNum).attr('name', 'add_quote_product_images_2_a' + newNum).clearFiles();
    newElem.find('.add_quote_product_images_3_a').attr('id', 'add_quote_product_images_3_a' + newNum).attr('name', 'add_quote_product_images_3_a' + newNum).clearFiles();
    newElem.find('.add_quote_product_images_4_a').attr('id', 'add_quote_product_images_4_a' + newNum).attr('name', 'add_quote_product_images_4_a' + newNum).clearFiles();
    newElem.find('.add_quote_product_images_5_a').attr('id', 'add_quote_product_images_5_a' + newNum).attr('name', 'add_quote_product_images_5_a' + newNum).clearFiles();
    // collage1 - text
    newElem.find('.add_quote_product_price').attr('id', 'add_revision_quote_price' + newNum).attr('name', 'add_quote_product_price' + newNum).val('0');
    newElem.find('.add_quote_product_desc').attr('id', 'add_quote_product_desc' + newNum).attr('name', 'add_quote_product_desc' + newNum).val('-');
    // board - text
    newElem.find('.add_quote_product_qty').attr('id', 'add_quote_product_qty' + newNum).attr('name', 'add_quote_product_qty' + newNum).val('0');
	newElem.find('.add_quote_product_cost').attr('id', 'add_quote_product_cost' + newNum).attr('name', 'add_quote_product_cost' + newNum).val('0');
	
    newElem.find('.add_quote_product_script').attr('id', 'add_quote_product_script' + newNum).html(
	'<script type="text/javascript">$(document).ready(function() {	$(\'#add_quote_product'+ newNum +'\').change(function(){		var tx = $(this).children(\'option:selected\').data(\'id\');				$.post("master_action.php", {prid: tx}, function(result){					result = $.parseJSON( result );$("#add_quote_product_desc'+ newNum +'").val(result.desc); $("#add_quote_product_cost'+ newNum +'").val(result.cost);});} );} );</script>');
    // year_enter - text
   
    // Insert the new element after the last "duplicatable" input field
    $('#quoteadd' + num).after(newElem);
    $('#ID' + newNum + '_title').focus();
    // Enable the "remove" button. This only shows once you have a duplicated section.
    $('#btnDel2').attr('disabled', false);
    // Right now you can only add 4 sections, for a total of 5. Change '5' below to the max number of sections you want to allow.
    if (newNum == 1000)
    $('#btnAdd2').attr('disabled', true).prop('value', "You've reached the limit");
    // value here updates the text in the 'add' button when the limit is reached 
  }
                    );
  $('#btnDel2').click(function () {
    // Confirmation dialog box. Works on all desktop browsers and iPhone.
    if (confirm("Are you sure you wish to remove this section? This cannot be undo."))
    {
      var num = $('.twoclonedInput').length;
      // how many "duplicatable" input fields we currently have
      $('#quoteadd' + num).slideUp('slow', function () {
        $(this).remove();
		 $('#qot_nos').val(num - 1);

        // if only one element remains, disable the "remove" button
        if (num -1 === 1)
          $('#btnDel2').attr('disabled', true);
        // enable the "add" button
        $('#btnAdd2').attr('disabled', false).prop('value', "Add More");
      }
                               );
    }
    return false;
    // Removes the last section you added
  }
                    );
  // Enable the "add" button
  $('#btnAdd2').attr('disabled', false);
  // Disable the "remove" button
  $('#btnDel2').attr('disabled', true);
}
 );
 
 
 
 
 
 
 $(function () {
  $('#btnAdd3').click(function () {
    var num     = $('.threeclonedInput').length, // Checks to see how many "duplicatable" input fields we currently have
    newNum  = new Number(num + 1),      // The numeric ID of the new input field being added, increasing by 1 each time
    newElem = $('#quotegen' + num).clone().attr('id', 'quotegen' + newNum).fadeIn('slow');
    // create the new element via clone(), and manipulate it's ID using newNum value
    /*  This is where we manipulate the name/id values of the input inside the new, cloned element
    Below are examples of what forms elements you can clone, but not the only ones.
    There are 2 basic structures below: one for an H2, and one for form elements.
    To make more, you can copy the one for form elements and simply update the classes for its label and input.
    Keep in mind that the .val() method is what clears the element when it gets cloned. Radio and checkboxes need .val([]) instead of .val('').
    
    newElem.find('.jr_id_munex').attr('id', 'jr_id_munex' + newNum).attr('value', 'jr_id_munex' + newNum).val(newNum);*/
	
	
    // examination_passed1 - text
    $('#before_head_nos').val(newNum);
    newElem.find('.add_quote_gen_bf_head').attr('id', 'add_quote_gen_bf_head' + newNum).attr('name', 'add_quote_gen_bf_head' + newNum).val('-');
    newElem.find('.add_quote_gen_bf_head_val').attr('id', 'add_quote_gen_bf_head_val' + newNum).attr('name', 'add_quote_gen_bf_head_val' + newNum).val('-');
    // board - text
   
    // Insert the new element after the last "duplicatable" input field
    $('#quotegen' + num).after(newElem);
    $('#ID' + newNum + '_title').focus();
    // Enable the "remove" button. This only shows once you have a duplicated section.
    $('#btnDel3').attr('disabled', false);
    // Right now you can only add 4 sections, for a total of 5. Change '5' below to the max number of sections you want to allow.
    if (newNum == 25)
    $('#btnAdd3').attr('disabled', true).prop('value', "You've reached the limit");
    // value here updates the text in the 'add' button when the limit is reached 
  }
                    );
  $('#btnDel3').click(function () {
    // Confirmation dialog box. Works on all desktop browsers and iPhone.
    if (confirm("Are you sure you wish to remove this section? This cannot be undo."))
    {
      var num = $('.threeclonedInput').length;
      // how many "duplicatable" input fields we currently have
      $('#quotegen' + num).slideUp('slow', function () {
        $(this).remove();
		 $('#before_head_nos').val(num - 1);

        // if only one element remains, disable the "remove" button
        if (num -1 === 1)
          $('#btnDel3').attr('disabled', true);
        // enable the "add" button
        $('#btnAdd3').attr('disabled', false).prop('value', "Add More");
      }
                               );
    }
    return false;
    // Removes the last section you added
  }
                    );
  // Enable the "add" button
  $('#btnAdd3').attr('disabled', false);
  // Disable the "remove" button
  $('#btnDel3').attr('disabled', true);
}
 );
 
 
 
 
 
 
 $(function () {
  $('#btnAdd4').click(function () {
    var num     = $('.fourclonedInput').length, // Checks to see how many "duplicatable" input fields we currently have
    newNum  = new Number(num + 1),      // The numeric ID of the new input field being added, increasing by 1 each time
    newElem = $('#quotepen' + num).clone().attr('id', 'quotepen' + newNum).fadeIn('slow');
    // create the new element via clone(), and manipulate it's ID using newNum value
    /*  This is where we manipulate the name/id values of the input inside the new, cloned element
    Below are examples of what forms elements you can clone, but not the only ones.
    There are 2 basic structures below: one for an H2, and one for form elements.
    To make more, you can copy the one for form elements and simply update the classes for its label and input.
    Keep in mind that the .val() method is what clears the element when it gets cloned. Radio and checkboxes need .val([]) instead of .val('').
    
    newElem.find('.jr_id_munex').attr('id', 'jr_id_munex' + newNum).attr('value', 'jr_id_munex' + newNum).val(newNum);*/
	
	
    // examination_passed1 - text
    $('#after_head_nos').val(newNum);
    newElem.find('.add_quote_gen_af_head').attr('id', 'add_quote_gen_af_head' + newNum).attr('name', 'add_quote_gen_af_head' + newNum).val('-');
    newElem.find('.add_quote_gen_af_head_val').attr('id', 'add_quote_gen_af_head_val' + newNum).attr('name', 'add_quote_gen_af_head_val' + newNum).val('-');
    // year_enter - text
   
    // Insert the new element after the last "duplicatable" input field
    $('#quotepen' + num).after(newElem);
    $('#ID' + newNum + '_title').focus();
    // Enable the "remove" button. This only shows once you have a duplicated section.
    $('#btnDel4').attr('disabled', false);
    // Right now you can only add 4 sections, for a total of 5. Change '5' below to the max number of sections you want to allow.
    if (newNum == 25)
    $('#btnAdd4').attr('disabled', true).prop('value', "You've reached the limit");
    // value here updates the text in the 'add' button when the limit is reached 
  }
                    );
  $('#btnDel4').click(function () {
    // Confirmation dialog box. Works on all desktop browsers and iPhone.
    if (confirm("Are you sure you wish to remove this section? This cannot be undo."))
    {
      var num = $('.fourclonedInput').length;
      // how many "duplicatable" input fields we currently have
      $('#quotepen' + num).slideUp('slow', function () {
        $(this).remove();
		 $('#after_head_nos').val(num - 1);

        // if only one element remains, disable the "remove" button
        if (num -1 === 1)
          $('#btnDel4').attr('disabled', true);
        // enable the "add" button
        $('#btnAdd4').attr('disabled', false).prop('value', "Add More");
      }
                               );
    }
    return false;
    // Removes the last section you added
  }
                    );
  // Enable the "add" button
  $('#btnAdd4').attr('disabled', false);
  // Disable the "remove" button
  $('#btnDel4').attr('disabled', true);
}
 );

$(function () {
  $('#btnAdd6').click(function () {
    var num     = $('.PerfclonedInput').length, // Checks to see how many "duplicatable" input fields we currently have
    newNum  = new Number(num + 1),      // The numeric ID of the new input field being added, increasing by 1 each time
    newElem = $('#proformaadd' + num).clone().attr('id', 'proformaadd' + newNum).fadeIn('slow');
    // create the new element via clone(), and manipulate it's ID using newNum value
    /*  This is where we manipulate the name/id values of the input inside the new, cloned element
    Below are examples of what forms elements you can clone, but not the only ones.
    There are 2 basic structures below: one for an H2, and one for form elements.
    To make more, you can copy the one for form elements and simply update the classes for its label and input.
    Keep in mind that the .val() method is what clears the element when it gets cloned. Radio and checkboxes need .val([]) instead of .val('').
    alert()
    newElem.find('.jr_id_munex').attr('id', 'jr_id_munex' + newNum).attr('value', 'jr_id_munex' + newNum).val(newNum);*/
	
	
    // examination_passed1 - text
	$('#per_nos').val(newNum);
	//njk
    newElem.find('.add_proforma_product').attr('id', 'add_proforma_product' + newNum).attr('name', 'add_proforma_product' + newNum).val('-');
    // collage1 - text
    newElem.find('.add_proforma_product_price').attr('id', 'add_revision_proforma_price' + newNum).attr('name', 'add_proforma_product_price' + newNum).val('0');
    newElem.find('.add_proforma_product_desc').attr('id', 'add_proforma_product_desc' + newNum).attr('name', 'add_proforma_product_desc' + newNum).val('-');
    // board - text
    newElem.find('.add_proforma_product_qty').attr('id', 'add_proforma_product_qty' + newNum).attr('name', 'add_proforma_product_qty' + newNum).val('0');
	newElem.find('.add_proforma_product_cost').attr('id', 'add_proforma_product_cost' + newNum).attr('name', 'add_proforma_product_cost' + newNum).val('0');
	
    newElem.find('.add_proforma_product_script').attr('id', 'add_proforma_product_script' + newNum).html(
	'<script type="text/javascript">$(document).ready(function() {	$(\'#add_proforma_product'+ newNum +'\').change(function(){		var tx = $(this).children(\'option:selected\').data(\'id\');				$.post("master_action.php", {prid: tx}, function(result){					result = $.parseJSON( result );$("#add_proforma_product_desc'+ newNum +'").val(result.desc); $("#add_proforma_product_cost'+ newNum +'").val(result.cost);});} );} );</script>');
    // year_enter - text
   
    // Insert the new element after the last "duplicatable" input field
    $('#proformaadd' + num).after(newElem);
    $('#ID' + newNum + '_title').focus();
    // Enable the "remove" button. This only shows once you have a duplicated section.
    $('#btnDel6').attr('disabled', false);
    // Right now you can only add 4 sections, for a total of 5. Change '5' below to the max number of sections you want to allow.
    if (newNum == 1000)
    $('#btnAdd6').attr('disabled', true).prop('value', "You've reached the limit");
    // value here updates the text in the 'add' button when the limit is reached 
  }
                    );
  $('#btnDel6').click(function () {
    // Confirmation dialog box. Works on all desktop browsers and iPhone.
    if (confirm("Are you sure you wish to remove this section? This cannot be undo."))
    {
      var num = $('.PerfclonedInput').length;
      // how many "duplicatable" input fields we currently have
      $('#proformaadd' + num).slideUp('slow', function () {
        $(this).remove();
		 $('#per_nos').val(num - 1);

        // if only one element remains, disable the "remove" button
        if (num -1 === 1)
          $('#btnDel6').attr('disabled', true);
        // enable the "add" button
        $('#btnAdd6').attr('disabled', false).prop('value', "Add More");
      }
                               );
    }
    return false;
    // Removes the last section you added
  }
                    );
  // Enable the "add" button
  $('#btnAdd6').attr('disabled', false);
  // Disable the "remove" button
  $('#btnDel6').attr('disabled', true);
}
 );
 
 
$(function () {
  $('#btnAdd7').click(function () {
    var num     = $('.PoFclonedInput').length, // Checks to see how many "duplicatable" input fields we currently have
    newNum  = new Number(num + 1),      // The numeric ID of the new input field being added, increasing by 1 each time
    newElem = $('#addrevpro' + num).clone().attr('id', 'addrevpro' + newNum).fadeIn('slow');
    // create the new element via clone(), and manipulate it's ID using newNum value
    /*  This is where we manipulate the name/id values of the input inside the new, cloned element
    Below are examples of what forms elements you can clone, but not the only ones.
    There are 2 basic structures below: one for an H2, and one for form elements.
    To make more, you can copy the one for form elements and simply update the classes for its label and input.
    Keep in mind that the .val() method is what clears the element when it gets cloned. Radio and checkboxes need .val([]) instead of .val('').
    
    newElem.find('.jr_id_munex').attr('id', 'jr_id_munex' + newNum).attr('value', 'jr_id_munex' + newNum).val(newNum);*/
	
    // examination_passed1 - text
    $('#pro_nos').val(newNum);
	//njk
    newElem.find('.add_revision_proforma_product_a').attr('id', 'add_revision_proforma_product_a' + newNum).attr('name', 'add_revision_proforma_product_a' + newNum).val('-');
    // collage1 - text
    newElem.find('.add_revision_proforma_price_a').attr('id', 'add_revision_proforma_price_a' + newNum).attr('name', 'add_revision_proforma_price_a' + newNum).val('0');
    newElem.find('.add_revision_proforma_desc_a').attr('id', 'add_revision_proforma_desc_a' + newNum).attr('name', 'add_revision_proforma_desc_a' + newNum).val('-');
    // board - text
    newElem.find('.add_revision_proforma_qty_a').attr('id', 'add_revision_proforma_qty_a' + newNum).attr('name', 'add_revision_proforma_qty_a' + newNum).val('0');
	newElem.find('.add_revision_proforma_cost_a').attr('id', 'add_revision_proforma_cost_a' + newNum).attr('name', 'add_revision_proforma_cost_a' + newNum).val('0');
	
    newElem.find('.add_revision_proforma_script').attr('id', 'add_revision_proforma_script' + newNum).html(
	'<script type="text/javascript">$(document).ready(function() {	$(\'#add_revision_proforma_product_a'+ newNum +'\').change(function(){		var tx = $(this).children(\'option:selected\').data(\'id\');				$.post("master_action.php", {prid: tx}, function(result){					result = $.parseJSON( result );$("#add_revision_proforma_desc_a'+ newNum +'").val(result.desc); $("#add_revision_proforma_cost_a'+ newNum +'").val(result.cost);});} );} );</script>');
    // year_enter - text
   
    // Insert the new element after the last "duplicatable" input field
    $('#addrevpro' + num).after(newElem);
    $('#ID' + newNum + '_title').focus();
    // Enable the "remove" button. This only shows once you have a duplicated section.
    $('#btnDel7').attr('disabled', false);
    // Right now you can only add 4 sections, for a total of 5. Change '5' below to the max number of sections you want to allow.
	 myFunct(newNum);
    if (newNum == 1000)
    $('#btnAdd7').attr('disabled', true).prop('value', "You've reached the limit");
    // value here updates the text in the 'add' button when the limit is reached 
  }
                    );
  $('#btnDel7').click(function () {
    // Confirmation dialog box. Works on all desktop browsers and iPhone.
    if (confirm("Are you sure you wish to remove this section? This cannot be undo."))
    {
      var num = $('.PoFclonedInput').length;
      // how many "duplicatable" input fields we currently have
      $('#addrevpro' + num).slideUp('slow', function () {
        $(this).remove();
		 $('#pro_nos').val(num - 1);

        // if only one element remains, disable the "remove" button
        if (num -1 === 1)
          $('#btnDel7').attr('disabled', true);
        // enable the "add" button
        $('#btnAdd7').attr('disabled', false).prop('value', "Add More");
      }
                               );
    }
    return false;
    // Removes the last section you added
  }
                    );
  // Enable the "add" button
  $('#btnAdd7').attr('disabled', false);
  // Disable the "remove" button
  $('#btnDel7').attr('disabled', true);
}
 );
 
 
 
 $(function () {
  $('#btnAdd10').click(function () {
    var num     = $('.tenclonedInput').length, // Checks to see how many "duplicatable" input fields we currently have
    newNum  = new Number(num + 1),      // The numeric ID of the new input field being added, increasing by 1 each time
    newElem = $('#proformapen' + num).clone().attr('id', 'proformapen' + newNum).fadeIn('slow');
    // create the new element via clone(), and manipulate it's ID using newNum value
    /*  This is where we manipulate the name/id values of the input inside the new, cloned element
    Below are examples of what forms elements you can clone, but not the only ones.
    There are 2 basic structures below: one for an H2, and one for form elements.
    To make more, you can copy the one for form elements and simply update the classes for its label and input.
    Keep in mind that the .val() method is what clears the element when it gets cloned. Radio and checkboxes need .val([]) instead of .val('').
    
    newElem.find('.jr_id_munex').attr('id', 'jr_id_munex' + newNum).attr('value', 'jr_id_munex' + newNum).val(newNum);*/
	
	
    // examination_passed1 - text
    $('#after_head_pro_nos').val(newNum);
    newElem.find('.add_proforma_gen_af_head').attr('id', 'add_proforma_gen_af_head' + newNum).attr('name', 'add_proforma_gen_af_head' + newNum).val('-');
    newElem.find('.add_proforma_gen_af_head_val').attr('id', 'add_proforma_gen_af_head_val' + newNum).attr('name', 'add_proforma_gen_af_head_val' + newNum).val('-');
    // year_enter - text
   
    // Insert the new element after the last "duplicatable" input field
    $('#proformapen' + num).after(newElem);
    $('#ID' + newNum + '_title').focus();
    // Enable the "remove" button. This only shows once you have a duplicated section.
    $('#btnDel10').attr('disabled', false);
    // Right now you can only add 4 sections, for a total of 5. Change '5' below to the max number of sections you want to allow.
    if (newNum == 25)
    $('#btnAdd10').attr('disabled', true).prop('value', "You've reached the limit");
    // value here updates the text in the 'add' button when the limit is reached 
  }
                    );
  $('#btnDel10').click(function () {
    // Confirmation dialog box. Works on all desktop browsers and iPhone.
    if (confirm("Are you sure you wish to remove this section? This cannot be undo."))
    {
      var num = $('.tenclonedInput').length;
      // how many "duplicatable" input fields we currently have
      $('#proformapen' + num).slideUp('slow', function () {
        $(this).remove();
		 $('#after_head_pro_nos').val(num - 1);

        // if only one element remains, disable the "remove" button
        if (num -1 === 1)
          $('#btnDel10').attr('disabled', true);
        // enable the "add" button
        $('#btnAdd10').attr('disabled', false).prop('value', "Add More");
      }
                               );
    }
    return false;
    // Removes the last section you added
  }
                    );
  // Enable the "add" button
  $('#btnAdd10').attr('disabled', false);
  // Disable the "remove" button
  $('#btnDel10').attr('disabled', true);
}
 );



//gfde

 
 $(function () {
  $('#btnAdd11').click(function () {
    var num     = $('.eleclonedInput').length, // Checks to see how many "duplicatable" input fields we currently have
    newNum  = new Number(num + 1),      // The numeric ID of the new input field being added, increasing by 1 each time
    newElem = $('#proformagen' + num).clone().attr('id', 'proformagen' + newNum).fadeIn('slow');
    // create the new element via clone(), and manipulate it's ID using newNum value
    /*  This is where we manipulate the name/id values of the input inside the new, cloned element
    Below are examples of what forms elements you can clone, but not the only ones.
    There are 2 basic structures below: one for an H2, and one for form elements.
    To make more, you can copy the one for form elements and simply update the classes for its label and input.
    Keep in mind that the .val() method is what clears the element when it gets cloned. Radio and checkboxes need .val([]) instead of .val('').
   */
    $('#before_head_pro_nos').val(newNum);
    newElem.find('.add_proforma_gen_bf_head').attr('id', 'add_proforma_gen_bf_head' + newNum).attr('name', 'add_proforma_gen_bf_head' + newNum).val('-');
    newElem.find('.add_proforma_gen_bf_head_val').attr('id', 'add_proforma_gen_bf_head_val' + newNum).attr('name', 'add_proforma_gen_bf_head_val' + newNum).val('-');
    // board - text
   
    // Insert the new element after the last "duplicatable" input field
    $('#proformagen' + num).after(newElem);
    $('#ID' + newNum + '_title').focus();
    // Enable the "remove" button. This only shows once you have a duplicated section.
    $('#btnDel11').attr('disabled', false);
    // Right now you can only add 4 sections, for a total of 5. Change '5' below to the max number of sections you want to allow.
    if (newNum == 25)
    $('#btnAdd11').attr('disabled', true).prop('value', "You've reached the limit");
    // value here updates the text in the 'add' button when the limit is reached 
  }
                    );
  $('#btnDel11').click(function () {
    // Confirmation dialog box. Works on all desktop browsers and iPhone.
    if (confirm("Are you sure you wish to remove this section? This cannot be undo."))
    {
      var num = $('.eleclonedInput').length;
      // how many "duplicatable" input fields we currently have
      $('#proformagen' + num).slideUp('slow', function () {
        $(this).remove();
		 $('#before_head_pro_nos').val(num - 1);

        // if only one element remains, disable the "remove" button
        if (num -1 === 1)
          $('#btnDel11').attr('disabled', true);
        // enable the "add" button
        $('#btnAdd11').attr('disabled', false).prop('value', "Add More");
      }
                               );
    }
    return false;
    // Removes the last section you added
  }
                    );
  // Enable the "add" button
  $('#btnAdd11').attr('disabled', false);
  // Disable the "remove" button
  $('#btnDel11').attr('disabled', true);
}
 );
 
 $(function () {
  $('#btnAdd13').click(function () {
    var num     = $('.SoclonedInput').length, // Checks to see how many "duplicatable" input fields we currently have
    newNum  = new Number(num + 1),      // The numeric ID of the new input field being added, increasing by 1 each time
    newElem = $('#addrevsi' + num).clone().attr('id', 'addrevsi' + newNum).fadeIn('slow');
    // create the new element via clone(), and manipulate it's ID using newNum value
    /*  This is where we manipulate the name/id values of the input inside the new, cloned element
    Below are examples of what forms elements you can clone, but not the only ones.
    There are 2 basic structures below: one for an H2, and one for form elements.
    To make more, you can copy the one for form elements and simply update the classes for its label and input.
    Keep in mind that the .val() method is what clears the element when it gets cloned. Radio and checkboxes need .val([]) instead of .val('').
    
    newElem.find('.jr_id_munex').attr('id', 'jr_id_munex' + newNum).attr('value', 'jr_id_munex' + newNum).val(newNum);*/
	
    // examination_passed1 - text
    $('#si_nos').val(newNum);
	//njk
    newElem.find('.add_revision_salesinvoice_product_a').attr('id', 'add_revision_salesinvoice_product_a' + newNum).attr('name', 'add_revision_salesinvoice_product_a' + newNum).val('-');
    // collage1 - text
    newElem.find('.add_revision_salesinvoice_price_a').attr('id', 'add_revision_salesinvoice_price_a' + newNum).attr('name', 'add_revision_salesinvoice_price_a' + newNum).val('0');
    newElem.find('.add_revision_salesinvoice_desc_a').attr('id', 'add_revision_salesinvoice_desc_a' + newNum).attr('name', 'add_revision_salesinvoice_desc_a' + newNum).val('-');
    // board - text
    newElem.find('.add_revision_salesinvoice_qty_a').attr('id', 'add_revision_salesinvoice_qty_a' + newNum).attr('name', 'add_revision_salesinvoice_qty_a' + newNum).val('0');
	newElem.find('.add_revision_salesinvoice_cost_a').attr('id', 'add_revision_salesinvoice_cost_a' + newNum).attr('name', 'add_revision_salesinvoice_cost_a' + newNum).val('0');
	
    newElem.find('.add_revision_salesinvoice_script').attr('id', 'add_revision_salesinvoice_script' + newNum).html(
	'<script type="text/javascript">$(document).ready(function() {	$(\'#add_revision_salesinvoice_product_a'+ newNum +'\').change(function(){		var tx = $(this).children(\'option:selected\').data(\'id\');				$.post("master_action.php", {prid: tx}, function(result){					result = $.parseJSON( result );$("#add_revision_salesinvoice_desc_a'+ newNum +'").val(result.desc); $("#add_revision_salesinvoice_cost_a'+ newNum +'").val(result.cost);});} );} );</script>');
    // year_enter - text
   
    // Insert the new element after the last "duplicatable" input field
    $('#addrevsi' + num).after(newElem);
    $('#ID' + newNum + '_title').focus();
    // Enable the "remove" button. This only shows once you have a duplicated section.
    $('#btnDel13').attr('disabled', false);
    // Right now you can only add 4 sections, for a total of 5. Change '5' below to the max number of sections you want to allow.
	 myFunct(newNum);
    if (newNum == 1000)
    $('#btnAdd13').attr('disabled', true).prop('value', "You've reached the limit");
    // value here updates the text in the 'add' button when the limit is reached 
  }
                    );
  $('#btnDel13').click(function () {
    // Confirmation dialog box. Works on all desktop browsers and iPhone.
    if (confirm("Are you sure you wish to remove this section? This cannot be undo."))
    {
      var num = $('.SoclonedInput').length;
      // how many "duplicatable" input fields we currently have
      $('#addrevsi' + num).slideUp('slow', function () {
        $(this).remove();
		 $('#si_nos').val(num - 1);

        // if only one element remains, disable the "remove" button
        if (num -1 === 1)
          $('#btnDel13').attr('disabled', true);
        // enable the "add" button
        $('#btnAdd13').attr('disabled', false).prop('value', "Add More");
      }
                               );
    }
    return false;
    // Removes the last section you added
  }
                    );
  // Enable the "add" button
  $('#btnAdd13').attr('disabled', false);
  // Disable the "remove" button
  $('#btnDel13').attr('disabled', true);
}
 );
 
 
 $(function () {
  $('#btnAdd15').click(function () {
    var num     = $('.ffteclonedInput').length, // Checks to see how many "duplicatable" input fields we currently have
    newNum  = new Number(num + 1),      // The numeric ID of the new input field being added, increasing by 1 each time
    newElem = $('#salesinvoicepen' + num).clone().attr('id', 'salesinvoicepen' + newNum).fadeIn('slow');
    // create the new element via clone(), and manipulate it's ID using newNum value
    /*  This is where we manipulate the name/id values of the input inside the new, cloned element
    Below are examples of what forms elements you can clone, but not the only ones.
    There are 2 basic structures below: one for an H2, and one for form elements.
    To make more, you can copy the one for form elements and simply update the classes for its label and input.
    Keep in mind that the .val() method is what clears the element when it gets cloned. Radio and checkboxes need .val([]) instead of .val('').
    
    newElem.find('.jr_id_munex').attr('id', 'jr_id_munex' + newNum).attr('value', 'jr_id_munex' + newNum).val(newNum);*/
	
	
    // examination_passed1 - text
    $('#after_head_si_nos').val(newNum);
    newElem.find('.add_salesinvoice_gen_af_head').attr('id', 'add_salesinvoice_gen_af_head' + newNum).attr('name', 'add_salesinvoice_gen_af_head' + newNum).val('-');
    newElem.find('.add_salesinvoice_gen_af_head_val').attr('id', 'add_salesinvoice_gen_af_head_val' + newNum).attr('name', 'add_salesinvoice_gen_af_head_val' + newNum).val('-');
    // year_enter - text
   
    // Insert the new element after the last "duplicatable" input field
    $('#salesinvoicepen' + num).after(newElem);
    $('#ID' + newNum + '_title').focus();
    // Enable the "remove" button. This only shows once you have a duplicated section.
    $('#btnDel15').attr('disabled', false);
    // Right now you can only add 4 sections, for a total of 5. Change '5' below to the max number of sections you want to allow.
    if (newNum == 25)
    $('#btnAdd15').attr('disabled', true).prop('value', "You've reached the limit");
    // value here updates the text in the 'add' button when the limit is reached 
  }
                    );
  $('#btnDel15').click(function () {
    // Confirmation dialog box. Works on all desktop browsers and iPhone.
    if (confirm("Are you sure you wish to remove this section? This cannot be undo."))
    {
      var num = $('.ffteclonedInput').length;
      // how many "duplicatable" input fields we currently have
      $('#salesinvoicepen' + num).slideUp('slow', function () {
        $(this).remove();
		 $('#after_head_si_nos').val(num - 1);

        // if only one element remains, disable the "remove" button
        if (num -1 === 1)
          $('#btnDel15').attr('disabled', true);
        // enable the "add" button
        $('#btnAdd15').attr('disabled', false).prop('value', "Add More");
      }
                               );
    }
    return false;
    // Removes the last section you added
  }
                    );
  // Enable the "add" button
  $('#btnAdd15').attr('disabled', false);
  // Disable the "remove" button
  $('#btnDel15').attr('disabled', true);
}
 );



//gfde

 
 $(function () {
  $('#btnAdd14').click(function () {
    var num     = $('.fteclonedInput').length, // Checks to see how many "duplicatable" input fields we currently have
    newNum  = new Number(num + 1),      // The numeric ID of the new input field being added, increasing by 1 each time
    newElem = $('#salesinvoicegen' + num).clone().attr('id', 'salesinvoicegen' + newNum).fadeIn('slow');
    // create the new element via clone(), and manipulate it's ID using newNum value
    /*  This is where we manipulate the name/id values of the input inside the new, cloned element
    Below are examples of what forms elements you can clone, but not the only ones.
    There are 2 basic structures below: one for an H2, and one for form elements.
    To make more, you can copy the one for form elements and simply update the classes for its label and input.
    Keep in mind that the .val() method is what clears the element when it gets cloned. Radio and checkboxes need .val([]) instead of .val('').
   */
    $('#before_head_si_nos').val(newNum);
    newElem.find('.add_salesinvoice_gen_bf_head').attr('id', 'add_salesinvoice_gen_bf_head' + newNum).attr('name', 'add_salesinvoice_gen_bf_head' + newNum).val('-');
    newElem.find('.add_salesinvoice_gen_bf_head_val').attr('id', 'add_salesinvoice_gen_bf_head_val' + newNum).attr('name', 'add_salesinvoice_gen_bf_head_val' + newNum).val('-');
    // board - text
   
    // Insert the new element after the last "duplicatable" input field
    $('#salesinvoicegen' + num).after(newElem);
    $('#ID' + newNum + '_title').focus();
    // Enable the "remove" button. This only shows once you have a duplicated section.
    $('#btnDel14').attr('disabled', false);
    // Right now you can only add 4 sections, for a total of 5. Change '5' below to the max number of sections you want to allow.
    if (newNum == 25)
    $('#btnAdd14').attr('disabled', true).prop('value', "You've reached the limit");
    // value here updates the text in the 'add' button when the limit is reached 
  }
                    );
  $('#btnDel14').click(function () {
    // Confirmation dialog box. Works on all desktop browsers and iPhone.
    if (confirm("Are you sure you wish to remove this section? This cannot be undo."))
    {
      var num = $('.fteclonedInput').length;
      // how many "duplicatable" input fields we currently have
      $('#salesinvoicegen' + num).slideUp('slow', function () {
        $(this).remove();
		 $('#before_head_si_nos').val(num - 1);

        // if only one element remains, disable the "remove" button
        if (num -1 === 1)
          $('#btnDel14').attr('disabled', true);
        // enable the "add" button
        $('#btnAdd14').attr('disabled', false).prop('value', "Add More");
      }
                               );
    }
    return false;
    // Removes the last section you added
  }
                    );
  // Enable the "add" button
  $('#btnAdd14').attr('disabled', false);
  // Disable the "remove" button
  $('#btnDel14').attr('disabled', true);
}
 );
 
 
 $(function () {
  $('#btnAdd20').click(function () {
    var num     = $('.DoclonedInput').length, // Checks to see how many "duplicatable" input fields we currently have
    newNum  = new Number(num + 1),      // The numeric ID of the new input field being added, increasing by 1 each time
    newElem = $('#addrevdo' + num).clone().attr('id', 'addrevdo' + newNum).fadeIn('slow');
    // create the new element via clone(), and manipulate it's ID using newNum value
    /*  This is where we manipulate the name/id values of the input inside the new, cloned element
    Below are examples of what forms elements you can clone, but not the only ones.
    There are 2 basic structures below: one for an H2, and one for form elements.
    To make more, you can copy the one for form elements and simply update the classes for its label and input.
    Keep in mind that the .val() method is what clears the element when it gets cloned. Radio and checkboxes need .val([]) instead of .val('').
    
    newElem.find('.jr_id_munex').attr('id', 'jr_id_munex' + newNum).attr('value', 'jr_id_munex' + newNum).val(newNum);*/
	
    // examination_passed1 - text
    $('#di_nos').val(newNum);
	//njk
    newElem.find('.add_revision_deliveryorder_product_a').attr('id', 'add_revision_deliveryorder_product_a' + newNum).attr('name', 'add_revision_deliveryorder_product_a' + newNum).val('-');
    // collage1 - text
    newElem.find('.add_revision_deliveryorder_price_a').attr('id', 'add_revision_deliveryorder_price_a' + newNum).attr('name', 'add_revision_deliveryorder_price_a' + newNum).val('0');
    newElem.find('.add_revision_deliveryorder_desc_a').attr('id', 'add_revision_deliveryorder_desc_a' + newNum).attr('name', 'add_revision_deliveryorder_desc_a' + newNum).val('-');
    // board - text
    newElem.find('.add_revision_deliveryorder_qty_a').attr('id', 'add_revision_deliveryorder_qty_a' + newNum).attr('name', 'add_revision_deliveryorder_qty_a' + newNum).val('0');
	newElem.find('.add_revision_deliveryorder_cost_a').attr('id', 'add_revision_deliveryorder_cost_a' + newNum).attr('name', 'add_revision_deliveryorder_cost_a' + newNum).val('0');
	
    newElem.find('.add_revision_deliveryorder_script').attr('id', 'add_revision_deliveryorder_script' + newNum).html(
	'<script type="text/javascript">$(document).ready(function() {	$(\'#add_revision_deliveryorder_product_a'+ newNum +'\').change(function(){		var tx = $(this).children(\'option:selected\').data(\'id\');				$.post("master_action.php", {prid: tx}, function(result){					result = $.parseJSON( result );$("#add_revision_deliveryorder_desc_a'+ newNum +'").val(result.desc); $("#add_revision_deliveryorder_cost_a'+ newNum +'").val(result.cost);});} );} );</script>');
    // year_enter - text
   
    // Insert the new element after the last "duplicatable" input field
    $('#addrevdo' + num).after(newElem);
    $('#ID' + newNum + '_title').focus();
    // Enable the "remove" button. This only shows once you have a duplicated section.
    $('#btnDel20').attr('disabled', false);
    // Right now you can only add 4 sections, for a total of 5. Change '5' below to the max number of sections you want to allow.
	 myFunct(newNum);
    if (newNum == 1000)
    $('#btnAdd20').attr('disabled', true).prop('value', "You've reached the limit");
    // value here updates the text in the 'add' button when the limit is reached 
  }
                    );
  $('#btnDel20').click(function () {
    // Confirmation dialog box. Works on all desktop browsers and iPhone.
    if (confirm("Are you sure you wish to remove this section? This cannot be undo."))
    {
      var num = $('.DoclonedInput').length;
      // how many "duplicatable" input fields we currently have
      $('#addrevdo' + num).slideUp('slow', function () {
        $(this).remove();
		 $('#di_nos').val(num - 1);

        // if only one element remains, disable the "remove" button
        if (num -1 === 1)
          $('#btnDel20').attr('disabled', true);
        // enable the "add" button
        $('#btnAdd20').attr('disabled', false).prop('value', "Add More");
      }
                               );
    }
    return false;
    // Removes the last section you added
  }
                    );
  // Enable the "add" button
  $('#btnAdd20').attr('disabled', false);
  // Disable the "remove" button
  $('#btnDel20').attr('disabled', true);
}
 );
 
 

 $(function () {
  $('#btnAdd21').click(function () {
    var num     = $('.do_afterclonedInput').length, // Checks to see how many "duplicatable" input fields we currently have
    newNum  = new Number(num + 1),      // The numeric ID of the new input field being added, increasing by 1 each time
    newElem = $('#deliveryorderpen' + num).clone().attr('id', 'deliveryorderpen' + newNum).fadeIn('slow');
    // create the new element via clone(), and manipulate it's ID using newNum value
    /*  This is where we manipulate the name/id values of the input inside the new, cloned element
    Below are examples of what forms elements you can clone, but not the only ones.
    There are 2 basic structures below: one for an H2, and one for form elements.
    To make more, you can copy the one for form elements and simply update the classes for its label and input.
    Keep in mind that the .val() method is what clears the element when it gets cloned. Radio and checkboxes need .val([]) instead of .val('').
    
    newElem.find('.jr_id_munex').attr('id', 'jr_id_munex' + newNum).attr('value', 'jr_id_munex' + newNum).val(newNum);*/
	
	
    // examination_passed1 - text
    $('#after_head_di_nos').val(newNum);
    newElem.find('.add_deliveryorder_gen_af_head').attr('id', 'add_deliveryorder_gen_af_head' + newNum).attr('name', 'add_deliveryorder_gen_af_head' + newNum).val('-');
    newElem.find('.add_deliveryorder_gen_af_head_val').attr('id', 'add_deliveryorder_gen_af_head_val' + newNum).attr('name', 'add_deliveryorder_gen_af_head_val' + newNum).val('-');
    // year_enter - text
   
    // Insert the new element after the last "duplicatable" input field
    $('#deliveryorderpen' + num).after(newElem);
    $('#ID' + newNum + '_title').focus();
    // Enable the "remove" button. This only shows once you have a duplicated section.
    $('#btnDel21').attr('disabled', false);
    // Right now you can only add 4 sections, for a total of 5. Change '5' below to the max number of sections you want to allow.
    if (newNum == 25)
    $('#btnAdd21').attr('disabled', true).prop('value', "You've reached the limit");
    // value here updates the text in the 'add' button when the limit is reached 
  }
                    );
  $('#btnDel21').click(function () {
    // Confirmation dialog box. Works on all desktop browsers and iPhone.
    if (confirm("Are you sure you wish to remove this section? This cannot be undo."))
    {
      var num = $('.do_afterclonedInput').length;
      // how many "duplicatable" input fields we currently have
      $('#deliveryorderpen' + num).slideUp('slow', function () {
        $(this).remove();
		 $('#after_head_di_nos').val(num - 1);

        // if only one element remains, disable the "remove" button
        if (num -1 === 1)
          $('#btnDel21').attr('disabled', true);
        // enable the "add" button
        $('#btnAdd21').attr('disabled', false).prop('value', "Add More");
      }
                               );
    }
    return false;
    // Removes the last section you added
  }
                    );
  // Enable the "add" button
  $('#btnAdd21').attr('disabled', false);
  // Disable the "remove" button
  $('#btnDel21').attr('disabled', true);
}
 );



//gfde

 
 $(function () {
  $('#btnAdd22').click(function () {
    var num     = $('.do_beforeclonedInput').length, // Checks to see how many "duplicatable" input fields we currently have
    newNum  = new Number(num + 1),      // The numeric ID of the new input field being added, increasing by 1 each time
    newElem = $('#deliveryordergen' + num).clone().attr('id', 'deliveryordergen' + newNum).fadeIn('slow');
    // create the new element via clone(), and manipulate it's ID using newNum value
    /*  This is where we manipulate the name/id values of the input inside the new, cloned element
    Below are examples of what forms elements you can clone, but not the only ones.
    There are 2 basic structures below: one for an H2, and one for form elements.
    To make more, you can copy the one for form elements and simply update the classes for its label and input.
    Keep in mind that the .val() method is what clears the element when it gets cloned. Radio and checkboxes need .val([]) instead of .val('').
   */
    $('#before_head_di_nos').val(newNum);
    newElem.find('.add_deliveryorder_gen_bf_head').attr('id', 'add_deliveryorder_gen_bf_head' + newNum).attr('name', 'add_deliveryorder_gen_bf_head' + newNum).val('-');
    newElem.find('.add_deliveryorder_gen_bf_head_val').attr('id', 'add_deliveryorder_gen_bf_head_val' + newNum).attr('name', 'add_deliveryorder_gen_bf_head_val' + newNum).val('-');
    // board - text
   
    // Insert the new element after the last "duplicatable" input field
    $('#deliveryordergen' + num).after(newElem);
    $('#ID' + newNum + '_title').focus();
    // Enable the "remove" button. This only shows once you have a duplicated section.
    $('#btnDel22').attr('disabled', false);
    // Right now you can only add 4 sections, for a total of 5. Change '5' below to the max number of sections you want to allow.
    if (newNum == 25)
    $('#btnAdd22').attr('disabled', true).prop('value', "You've reached the limit");
    // value here updates the text in the 'add' button when the limit is reached 
  }
                    );
  $('#btnDel22').click(function () {
    // Confirmation dialog box. Works on all desktop browsers and iPhone.
    if (confirm("Are you sure you wish to remove this section? This cannot be undo."))
    {
      var num = $('.do_beforeclonedInput').length;
      // how many "duplicatable" input fields we currently have
      $('#deliveryordergen' + num).slideUp('slow', function () {
        $(this).remove();
		 $('#before_head_di_nos').val(num - 1);

        // if only one element remains, disable the "remove" button
        if (num -1 === 1)
          $('#btnDel22').attr('disabled', true);
        // enable the "add" button
        $('#btnAdd22').attr('disabled', false).prop('value', "Add More");
      }
                               );
    }
    return false;
    // Removes the last section you added
  }
                    );
  // Enable the "add" button
  $('#btnAdd22').attr('disabled', false);
  // Disable the "remove" button
  $('#btnDel22').attr('disabled', true);
}
 );
 
 $(function () {
  $('#btnAdd25').click(function () {
    var num     = $('.PcoclonedInput').length, // Checks to see how many "duplicatable" input fields we currently have
    newNum  = new Number(num + 1),      // The numeric ID of the new input field being added, increasing by 1 each time
    newElem = $('#addrevpci' + num).clone().attr('id', 'addrevpci' + newNum).fadeIn('slow');
    // create the new element via clone(), and manipulate it's ID using newNum value
    /*  This is where we manipulate the name/id values of the input inside the new, cloned element
    Below are examples of what forms elements you can clone, but not the only ones.
    There are 2 basic structures below: one for an H2, and one for form elements.
    To make more, you can copy the one for form elements and simply update the classes for its label and input.
    Keep in mind that the .val() method is what clears the element when it gets cloned. Radio and checkboxes need .val([]) instead of .val('').
    
    newElem.find('.jr_id_munex').attr('id', 'jr_id_munex' + newNum).attr('value', 'jr_id_munex' + newNum).val(newNum);*/
	
    // examination_passed1 - text
    $('#pci_nos').val(newNum);
	//njk
    newElem.find('.add_revision_purchaseorder_product_a').attr('id', 'add_revision_purchaseorder_product_a' + newNum).attr('name', 'add_revision_purchaseorder_product_a' + newNum).val('-');
    // collage1 - text
    newElem.find('.add_revision_purchaseorder_price_a').attr('id', 'add_revision_purchaseorder_price_a' + newNum).attr('name', 'add_revision_purchaseorder_price_a' + newNum).val('0');
    newElem.find('.add_revision_purchaseorder_desc_a').attr('id', 'add_revision_purchaseorder_desc_a' + newNum).attr('name', 'add_revision_purchaseorder_desc_a' + newNum).val('-');
    // board - text
    newElem.find('.add_revision_purchaseorder_qty_a').attr('id', 'add_revision_purchaseorder_qty_a' + newNum).attr('name', 'add_revision_purchaseorder_qty_a' + newNum).val('0');
	newElem.find('.add_revision_purchaseorder_cost_a').attr('id', 'add_revision_purchaseorder_cost_a' + newNum).attr('name', 'add_revision_purchaseorder_cost_a' + newNum).val('0');
	
    newElem.find('.add_revision_purchaseorder_script').attr('id', 'add_revision_purchaseorder_script' + newNum).html(
	'<script type="text/javascript">$(document).ready(function() {	$(\'#add_revision_purchaseorder_product_a'+ newNum +'\').change(function(){		var tx = $(this).children(\'option:selected\').data(\'id\');				$.post("master_action.php", {prid: tx}, function(result){					result = $.parseJSON( result );$("#add_revision_purchaseorder_desc_a'+ newNum +'").val(result.desc); $("#add_revision_purchaseorder_cost_a'+ newNum +'").val(result.cost);});} );} );</script>');
    // year_enter - text
   
    // Insert the new element after the last "duplicatable" input fieldF
    $('#addrevpci' + num).after(newElem);
    $('#ID' + newNum + '_title').focus();
    // Enable the "remove" button. This only shows once you have a duplicated section.
    $('#btnDel25').attr('disabled', false);
    // Right now you can only add 4 sections, for a total of 5. Change '5' below to the max number of sections you want to allow.
	 myFunct(newNum);
    if (newNum == 1000)
    $('#btnAdd25').attr('disabled', true).prop('value', "You've reached the limit");
    // value here updates the text in the 'add' button when the limit is reached 
  }
                    );
  $('#btnDel25').click(function () {
    // Confirmation dialog box. Works on all desktop browsers and iPhone.
    if (confirm("Are you sure you wish to remove this section? This cannot be undo."))
    {
      var num = $('.PcoclonedInput').length;
      // how many "duplicatable" input fields we currently have
      $('#addrevpci' + num).slideUp('slow', function () {
        $(this).remove();
		 $('#pci_nos').val(num - 1);

        // if only one element remains, disable the "remove" button
        if (num -1 === 1)
          $('#btnDel25').attr('disabled', true);
        // enable the "add" button
        $('#btnAdd25').attr('disabled', false).prop('value', "Add More");
      }
                               );
    }
    return false;
    // Removes the last section you added
  }
                    );
  // Enable the "add" button
  $('#btnAdd25').attr('disabled', false);
  // Disable the "remove" button
  $('#btnDel25').attr('disabled', true);
}
 );
 
 
 
 
 
 
 $(function () {
  $('#btnAdd27').click(function () {
    var num     = $('.27clonedInput').length, // Checks to see how many "duplicatable" input fields we currently have
    newNum  = new Number(num + 1),      // The numeric ID of the new input field being added, increasing by 1 each time
    newElem = $('#purchaseorderpen' + num).clone().attr('id', 'purchaseorderpen' + newNum).fadeIn('slow');
    // create the new element via clone(), and manipulate it's ID using newNum value
    /*  This is where we manipulate the name/id values of the input inside the new, cloned element
    Below are examples of what forms elements you can clone, but not the only ones.
    There are 2 basic structures below: one for an H2, and one for form elements.
    To make more, you can copy the one for form elements and simply update the classes for its label and input.
    Keep in mind that the .val() method is what clears the element when it gets cloned. Radio and checkboxes need .val([]) instead of .val('').
    
    newElem.find('.jr_id_munex').attr('id', 'jr_id_munex' + newNum).attr('value', 'jr_id_munex' + newNum).val(newNum);*/
	
	
    // examination_passed1 - text
    $('#after_head_pci_nos').val(newNum);
    newElem.find('.add_purchaseorder_gen_af_head').attr('id', 'add_purchaseorder_gen_af_head' + newNum).attr('name', 'add_purchaseorder_gen_af_head' + newNum).val('-');
    newElem.find('.add_purchaseorder_gen_af_head_val').attr('id', 'add_purchaseorder_gen_af_head_val' + newNum).attr('name', 'add_purchaseorder_gen_af_head_val' + newNum).val('-');
    // year_enter - text
   
    // Insert the new element after the last "duplicatable" input field
    $('#purchaseorderpen' + num).after(newElem);
    $('#ID' + newNum + '_title').focus();
    // Enable the "remove" button. This only shows once you have a duplicated section.
    $('#btnDel27').attr('disabled', false);
    // Right now you can only add 4 sections, for a total of 5. Change '5' below to the max number of sections you want to allow.
    if (newNum == 25)
    $('#btnAdd27').attr('disabled', true).prop('value', "You've reached the limit");
    // value here updates the text in the 'add' button when the limit is reached 
  }
                    );
  $('#btnDel27').click(function () {
    // Confirmation dialog box. Works on all desktop browsers and iPhone.
    if (confirm("Are you sure you wish to remove this section? This cannot be undo."))
    {
      var num = $('.27clonedInput').length;
      // how many "duplicatable" input fields we currently have
      $('#purchaseorderpen' + num).slideUp('slow', function () {
        $(this).remove();
		 $('#after_head_pci_nos').val(num - 1);

        // if only one element remains, disable the "remove" button
        if (num -1 === 1)
          $('#btnDel27').attr('disabled', true);
        // enable the "add" button
        $('#btnAdd27').attr('disabled', false).prop('value', "Add More");
      }
                               );
    }
    return false;
    // Removes the last section you added
  }
                    );
  // Enable the "add" button
  $('#btnAdd27').attr('disabled', false);
  // Disable the "remove" button
  $('#btnDel27').attr('disabled', true);
}
 );



//gfde

 
 $(function () {
  $('#btnAdd26').click(function () {
    var num     = $('.26clonedInput').length, // Checks to see how many "duplicatable" input fields we currently have
    newNum  = new Number(num + 1),      // The numeric ID of the new input field being added, increasing by 1 each time
    newElem = $('#purchaseordergen' + num).clone().attr('id', 'purchaseordergen' + newNum).fadeIn('slow');
    // create the new element via clone(), and manipulate it's ID using newNum value
    /*  This is where we manipulate the name/id values of the input inside the new, cloned element
    Below are examples of what forms elements you can clone, but not the only ones.
    There are 2 basic structures below: one for an H2, and one for form elements.
    To make more, you can copy the one for form elements and simply update the classes for its label and input.
    Keep in mind that the .val() method is what clears the element when it gets cloned. Radio and checkboxes need .val([]) instead of .val('').
   */
    $('#before_head_pci_nos').val(newNum);
    newElem.find('.add_purchaseorder_gen_bf_head').attr('id', 'add_purchaseorder_gen_bf_head' + newNum).attr('name', 'add_purchaseorder_gen_bf_head' + newNum).val('-');
    newElem.find('.add_purchaseorder_gen_bf_head_val').attr('id', 'add_purchaseorder_gen_bf_head_val' + newNum).attr('name', 'add_purchaseorder_gen_bf_head_val' + newNum).val('-');
    // board - text
   
    // Insert the new element after the last "duplicatable" input field
    $('#purchaseordergen' + num).after(newElem);
    $('#ID' + newNum + '_title').focus();
    // Enable the "remove" button. This only shows once you have a duplicated section.
    $('#btnDel26').attr('disabled', false);
    // Right now you can only add 4 sections, for a total of 5. Change '5' below to the max number of sections you want to allow.
    if (newNum == 25)
    $('#btnAdd26').attr('disabled', true).prop('value', "You've reached the limit");
    // value here updates the text in the 'add' button when the limit is reached 
  }
                    );
  $('#btnDel26').click(function () {
    // Confirmation dialog box. Works on all desktop browsers and iPhone.
    if (confirm("Are you sure you wish to remove this section? This cannot be undo."))
    {
      var num = $('.26clonedInput').length;
      // how many "duplicatable" input fields we currently have
      $('#purchaseordergen' + num).slideUp('slow', function () {
        $(this).remove();
		 $('#before_head_pci_nos').val(num - 1);

        // if only one element remains, disable the "remove" button
        if (num -1 === 1)
          $('#btnDel26').attr('disabled', true);
        // enable the "add" button
        $('#btnAdd26').attr('disabled', false).prop('value', "Add More");
      }
                               );
    }
    return false;
    // Removes the last section you added
  }
                    );
  // Enable the "add" button
  $('#btnAdd26').attr('disabled', false);
  // Disable the "remove" button
  $('#btnDel26').attr('disabled', true);
}
 );
 
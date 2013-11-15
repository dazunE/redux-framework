jQuery.fn.outerHTML = function(){
             
    // IE, Chrome & Safari will comply with the non-standard outerHTML, all others (FF) will have a fall-back for cloning
    return (!this.length) ? this : (this[0].outerHTML || (
      function(el){
          var div = document.createElement('div');
          div.appendChild(el.cloneNode(true));
          var contents = div.innerHTML;
          div = null;
          return contents;
    })(this[0]));

}

jQuery.fn.reduxReIndexFields = function(){
    var parent = jQuery(this);
    var pattern = parent.attr('data-sortable-pattern');
    jQuery(' > .redux-multi-instance', parent).each(function(index, element){

        var id = jQuery(element).attr('id').split(/[-]+/);
        
        //get the old values
        var old_id = jQuery(element).attr('id');
        var old_index = id.pop();
        var old_name = pattern.replace('##sortable-index##', old_index);
        var old_html = jQuery(element).outerHTML();
        
        //construct new values
        //id = id.slice(0, -1);
        id[id.length] = index;
        new_id = id.join('-');
        var new_name = pattern.replace('##sortable-index##', index);
        
        //replace values
        var new_html = old_html;
        //escape old id for regex
        old_name = old_name.replace(/(\[|\])/g,'\\$1');
        var re = new RegExp(old_name,"g");
        var re2 = new RegExp(old_id,"g");
        new_html = new_html.replace(re, new_name).replace(re2, new_id);
        
        jQuery(element).replaceWith(new_html);
        
    });  
}

jQuery.fn.reduxRemoveFields = function(){
    var tobeindexed = jQuery(this).closest('.redux-multi-field');
    var min = jQuery(tobeindexed).attr('data-multi-min');
    var items = jQuery(' > .redux-multi-instance', tobeindexed).length - 1;
    if(items >= min){
        var instance = jQuery(this).closest('.redux-multi-instance');
        jQuery(instance).fadeOut('slow', function(){
            jQuery(this).remove();
            jQuery(tobeindexed).reduxReIndexFields();
        });
    }else{
        //need to localize this
        alert('minimun needed: min:' + min + ' items:'+items);   
    }
}

jQuery.fn.reduxCloneFields = function(){
    var instance = jQuery(this).closest('.redux-multi-field');
    var max = jQuery(instance).attr('data-multi-max');
    
    if(max != 0){
        var items = jQuery(' > .redux-multi-instance', instance).length;
        if( items == max ){
            //need to localize
            alert('too many!');
            return;
        }
    }
    
    
    var clone = jQuery(' > .redux-multi-instance-clone', instance);
    var pattern = jQuery(this).attr('data-index-pattern');
    
    // get unique index
    var indexes = [];
    jQuery(' > .redux-multi-instance', instance).each(function(index, element){                            
        name = jQuery(element).attr('id').split(/[-]+/).pop();
        
        indexes[parseInt(name)] = parseInt(name);
    });
    
    var index = 0;
    while( jQuery.inArray( index, indexes) > -1 ){
        index++;   
    }
    //get unique index
    
    //var index = jQuery(' > .redux-multi-instance', instance).length;
    //this would work with our reindexing, but use above to be sure
    
    
    var template = jQuery(clone).outerHTML();
    var re = new RegExp(pattern,"g");
    template = template.replace(re, index);
    jQuery(template).insertBefore( clone ).addClass('redux-multi-instance').removeClass('redux-multi-instance-clone');
}


jQuery.fn.reduxRequires = function( usefade ){
    var fieldtocheck = jQuery(this).attr('data-redux-check-field');
    var operator = jQuery(this).attr('data-redux-check-comparison');
    var value1 = jQuery(this).attr('data-redux-check-value');
    
    var value2 = jQuery('#' + fieldtocheck).val();
    
    var show = false;
    
    if(value2){
    
        switch(operator){
            case '=':
            case 'equals':
                    //if value was array
                    if (value2.toString().indexOf('|') !== -1){
                            var value2_array = value2.split('|');
                            if($.inArray( value1, value2_array ) != -1){
                                    show = true;
                            }
                    }else{
                        if(value1 == value2) 
                                show = true;
                    }
                break;
            case '!=':    
            case 'not':
                    //if value was array
                    if (value2.indexOf('|') !== -1){
                            var value2_array = value2.split('|');
                            if($.inArray( value1, value2_array ) == -1){
                                    show = true;
                            }
                    }else{
                        if(value1 != value2) 
                                show = true;
                    }
                break;
            case '>':    
            case 'greater':    
            case 'is_larger':
                if(parseFloat(value1) >  parseFloat(value2)) 
                        show = true;
                break;
            case '<':
            case 'less':    
            case 'is_smaller':
                if(parseFloat(value1) < parseFloat(value2)) 
                        show = true;
                break;
            case 'contains':
                if(value1.indexOf(value2) != -1) 
                        show = true;
                break;
            case 'doesnt_contain':
                if(value1.indexOf(value2) == -1) 
                        show = true;
                break;
            case 'is_empty_or':
                if(value1 == "" || value1 == value2) 
                        show = true;
                break;
            case 'not_empty_and':
                if(value1 != "" && value1 != value2) 
                        show = true;
                break;
        }
        
    }
    
    if(show == false){
        if(usefade == true){
            jQuery(this).fadeOut('slow');
        }else{
            jQuery(this).hide();   
        }
    }else{
        if(usefade == true){
            jQuery(this).fadeIn('slow');
        }else{
            jQuery(this).show();   
        }
    }
    
}


jQuery(document).ready(function(){
    
    jQuery('#redux-form').submit(function(e){
        jQuery.post(
            jQuery(location).attr('href'),
            jQuery('#redux-form').serialize(),
            function(data){
                alert(data);   
            }
        );
        e.preventDefault();
        return false;
    });
    
    //submit scrolls
    var top = jQuery('#redux-save-top').offset().top - parseFloat(jQuery('#redux-save-top').css('marginTop').replace(/auto/, 0));
      jQuery(window).scroll(function (event) {
        // what the y position of the scroll is
        var y = jQuery(this).scrollTop();
      
        // whether that's below the form
        if (y >= top - 30) {
          // if so, ad the fixed class
          jQuery('#redux-save-top').addClass('fixed').css({width: jQuery('#redux-sections').width() + 'px'});
        } else {
          // otherwise remove it
          jQuery('#redux-save-top').removeClass('fixed');
        }
      });
    
    //requires
    jQuery('[data-redux-check-field]').each(function(index, element){
        jQuery(this).reduxRequires(false);
    });
    
    jQuery('.redux-form').on('change', 'input, select, radio, checkbox, textarea', function(e){
        jQuery('[data-redux-check-field="'+this.id+'"]').each(function(index, element){
            jQuery(this).reduxRequires(true);
        });
    });
    
    
    jQuery('.redux-field-group').on('change', 'input, select, radio, checkbox, textarea', function(){
        //var group = jQuery(this).closest('.redux-multi-instance.redux-field-group');
        //if(typeof group === 'undefined'){
            var group = jQuery(this).closest('.redux-field-group');   
        //}
        var group_title = jQuery(' > .redux-group-title', group);
        var val = jQuery(this).val();
        jQuery(' > #redux-group-title-' + this.id, group_title).text(val);
        //alert(group_title.text());
    });
    
    //tab nav
    jQuery('.redux-section-tab').on('click', function(){
        jQuery('.redux-section-tab').not(this).closest('li').removeClass('active');
        jQuery(this).closest('li').addClass('active');
        var id = jQuery(this).attr('href');
        jQuery('.redux-section').not(id).removeClass('active');
        jQuery(id).addClass('active');
        return false;
    });
    
    
    
    //sortable
    jQuery( ".redux-multi-field.redux-multi-field-sortable" ).sortable({
        update: function(event, ui){
            jQuery(ui.item).closest('.redux-multi-field').reduxReIndexFields();
        },
        placeholder: "redux-sortable-drop",
        handle: ".redux-sortable-handle",
        forcePlaceholderSize: true
    });
    
    //multi remove
    jQuery('.redux-form').on('click', '.redux-multi-remove', function(){
        jQuery(this).reduxRemoveFields();
    });
    
    //multi add
    jQuery('.redux-form').on('click', '.redux-multi-field-clone', function(){
        jQuery(this).reduxCloneFields();
    });
    
    //slide groups
    jQuery('.redux-form').on('click', '.redux-group-title', function(){
        jQuery(this).next('.redux-group-fields').slideToggle('slow');   
    });
    
});
/**
 * Created by HarunAkgun on 19.12.2014.
 */
$ = jQuery;

IyzicoAdmin = {
    utils:{
        quickEditGenerator:function(itemId, elementsObject, colorAlternative,action,language){

            var alternateClass = "";
            if ( colorAlternative ) alternateClass="alternate";

            var html = "";
            html += '<tr id="edit-'+itemId+'" class="inline-edit-row '+alternateClass+' inline-editor" data-belongs-to="'+itemId+'"  style="">';
            html +=    '<td colspan="5" class="colspanchange"><form id="quickEditForm_'+itemId+'">';
            html +=        '<fieldset>';
            html +=             '<div class="inline-edit-col">';
            html +=                '<h4>Quick Edit</h4>';
            html +=                 '<p>Editing/Translating for language: <strong class="red">'+language+'</strong></p>';
            html +=                 '<div id="place-holder-'+itemId+'"><div class="spinner" style="float:none;display:block!important;"></div></div>';
            html +=                '</div>';
            html +=        '</fieldset>';
            html +=        '<p class="inline-edit-save submit">';
            html +=            '<a accesskey="c" href="" class="cancel button-secondary alignleft quickCancel">Cancel</a>';
            html +=            '<a accesskey="s" href="" data-belongs-to="'+itemId+'" class="save button-primary alignright quickSave">Update</a>';
            html +=            '<span class="spinner"></span>';
            html +=            '<span class="error" style="display:none;"></span>';
            html +=            '<input type="hidden" name="action" value="'+action+'">';
            html +=            '<input type="hidden" name="language" value="'+language+'">';
            html +=            '<input type="hidden" name="itemId" value="'+itemId+'">';
            html +=            '<br class="clear">';
            html +=        '</p>';
            html +=    '</form></td>';
            html +='</tr>';

            return html;
        },
        changeLanguage:function(language){
            var data = 'action=change_language&language='+language;
            $.post(global_variables.ajax_url, data, function(response) {

                var responseObject = JSON.parse(response);
                if (responseObject.success == "true") {
                    $(location).attr('href',window.location.href);
                } else {
                    console.log(responseObject.error)
                    $(location).attr('href',window.location.href);
                };
            });
        }
    },
    helpers:{
        updateItemJSON:function(itemId,itemData){
            var currentData = $('#item-'+itemId).data('item-json');
            for(prop in itemData) {
                if (currentData.hasOwnProperty(prop)) {
                    currentData[prop]['value'] = itemData[prop];
                }
            }
            $('#item-'+itemId).data('item-json',currentData);
        }
    },
    events:{
        quickEditCancel:function(event,element){
            var oldEditRow = $('.inline-edit-row');
            if (oldEditRow) {
                $('#item-'+oldEditRow.data('belongs-to')).show();
                oldEditRow.remove();
            }
        },
        quickEditSave:function(event,element){
            itemId = element.data('belongs-to');
            var data = $('#quickEditForm_'+itemId).serialize();

            $('.quickSave').hide();
            $('.spinner').show();
            $.post(global_variables.ajax_url, data, function(response) {

                $('.quickSave').show();
                $('.spinner').hide();

                var responseObject = JSON.parse(response);
                if (responseObject.success == "true") {
                    $('#notificationBar').html('<h3>'+responseObject.message+'</h3>');
                    $(location).attr('href',window.location.href);
                } else {
                    $('#notificationBar').html('<h3>'+responseObject.error+'</h3>');
                    IyzicoAdmin.events.quickEditCancel();
                }
                $('#notificationBar').fadeIn(300).delay(2500).fadeOut(300);

            });
        },
        quickEditLocalisationListener:function(responseJson,itemId){
            var html = "";

            for (var paramName in responseJson) {
                if (responseJson.hasOwnProperty(paramName)) {

                    var fieldStructure = responseJson[paramName];
                    var typeDefinition = fieldStructure['type'].split(',');
                    html +=                '<label>';
                    html +=                    '<span class="title">'+fieldStructure['title']+'</span>';
                    html +=                    '<span class="input-text-wrap">';
                    if ( typeDefinition[0] == "standard" ) {
                        html +=                        '<input type="'+typeDefinition[1]+'" name="'+paramName+'" class="ptitle" style="width:100%" value="'+fieldStructure['value']+'">';
                    } else if(typeDefinition[0] == "template") {
                        var fieldName = typeDefinition[1].replace('Template','');
                        var templateHolder = $("#"+typeDefinition[1]);

                        templateHolder.find('select option').filter(function() {
                            if ( $(this).attr('value') == fieldStructure['value'] ) {
                                $(this).attr('selected',true);
                            } else {
                                $(this).attr('selected',false);
                            }
                        });

                        html += templateHolder.html();

                    } else  if ( typeDefinition[0] == "large" ) {
                        html +=                        '<textarea name="'+paramName+'" class="ptitle" style="width:100%">'+fieldStructure['value']+'</textarea>';
                    }
                    html +=                    '</span>';
                    html +=                '</label>';
                }
            }
            $('#place-holder-'+itemId).html(html);


        }
    },
    localisation:{
        getLocalisedData:function(itemId,localisationEndPoint,languageToEdit){
            var data = {
                action: localisationEndPoint,
                language: languageToEdit,
                itemId: itemId
            }
            data = $.param(data);


            $.post(global_variables.ajax_url, data, function(response) {

                var responseObject = JSON.parse(response);
                if (responseObject.success == "true") {
                    IyzicoAdmin.events.quickEditLocalisationListener(JSON.parse(responseObject.data),itemId);
                } else {
                    console.log(responseObject);
                    return false;
                };
            });
        }
    }
};
$(document).ready(function(){
    $('.quickEditor').click(function(){
        var elementId = $(this).data('item-id');
        var parentElement = $('#item-'+elementId);
        var productJson = parentElement.data('item-json');
        var editEndPoint = $(this).data('edit-endpoint');
        var localisationEndPoint = $(this).data('localisation-endpoint');
        var languageToEdit = $(this).data('language');

        var localisedData = IyzicoAdmin.localisation.getLocalisedData(elementId,localisationEndPoint,languageToEdit);

        var editRow = IyzicoAdmin.utils.quickEditGenerator(elementId,productJson,parentElement.hasClass('alternate'),editEndPoint,languageToEdit);

        parentElement.hide();

        var oldEditRow = $('.inline-edit-row');
        if (oldEditRow) IyzicoAdmin.events.quickEditCancel();

        parentElement.after($(editRow));

        $('.quickCancel').click(function(event){
            IyzicoAdmin.events.quickEditCancel(event,$(this));
            return false;
        });
        $('.quickSave').click(function(event){
            IyzicoAdmin.events.quickEditSave(event,$(this));
            return false;
        });
        return false;
    });

    $('.quickDelete').click(function(event){
        event.preventDefault();
        itemId = $(this).data('item-id');
        $('#itemToDelete').val(itemId);

        if ( confirm('Item will be deleted PERMANENTLY, are you sure?') ){
            $('#deleteForm').submit();
        }
        return false;
    });

    $('.action').click(function(event){
        event.preventDefault();
        if ( $('#bulk-action-selector').val() == 'delete' || $('#bulk-action-selector-top').val() == 'delete' ) {
            if ( confirm('Selected items will be deleted PERMANENTLY, are you sure?') ) {
                $('#posts-filter').submit();
            }
        } else {
            alert('Please select an action.');
        }
    })

    $('#workingLanguage').change(function(event){
        IyzicoAdmin.utils.changeLanguage($(this).val());
    })

    $('#filter-action-selector').change(function(event){
        window.location = $(this).val();
    });

    $('#caching_mod').change(function(){
        if ( $(this).val() != 0 ) {
            $('#cache_salt').prop('disabled',false);
            $('#cache_timeout').prop('disabled',false);
        } else {
            $('#cache_salt').prop('disabled',true);
            $('#cache_timeout').prop('disabled',true);
        }
    })

    $('#lazyload_mod').change(function(){
        if ( $(this).val() != 0 ) {
            $('#admin_exception').prop('disabled',false);
            $('#preview_exception').prop('disabled',false);
        } else {
            $('#admin_exception').prop('disabled',true);
            $('#preview_exception').prop('disabled',true);
        }
    })

    $('#purge_all').click(function(){
        if (confirm('Do you really want to purge all the cache?')){
            $('#purge_action').val('purge_all');
            $('#purge_form').submit();
        } else {
            return false;
        }
    });

    $('#purge_expired').click(function(){

        $('#purge_action').val('purge_expired');
        $('#purge_form').submit();

    });

});
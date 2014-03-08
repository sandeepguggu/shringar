var BIZ = {};
BIZ.ajax_url = document.location.href;
BIZ.ajax_url = BIZ.ajax_url.split('#')[0];
BIZ.ajax_url += '?tabs=1';

BIZ.app = {
    /*
     * event            - 'Event name'
     * parentElement    - 'Parent Element'
     * targetElement    - 'targetElement'
     * callback         -  function
     * extra            -  extra information
     */
    bind:function (config) {
        var allEvents = ['click', 'blur', 'keyup', 'change', 'focus', 'blur', 'mouseover', 'mouseout'];
        var event = typeof(config.event) != 'undefined' ? config.event.trim() : '';
        if (event == '') {
            BIZ.app.log('Error: Event Name is empty in Binding Event');
            return false;
        }
        if (jQuery.inArray(event, allEvents) == -1) {
            BIZ.app.log('Error: Invalid Event Name in Binding Event');
            return false;
        }
        var targetElement = typeof(config.targetElement) != 'undefined' ? config.targetElement : '';
        if (targetElement == '' || $(targetElement).length <= 0) {
            BIZ.app.log('Error: On ' + event + ' event ' + targetElement + ' Binding');
            return false;
        }
        var callback = typeof(config.callback) == 'function' ? config.callback : null;
        if (callback == null) {
            BIZ.app.log('Error: On ' + event + ' event ' + targetElement + ' Binding : Callback is not defined');
            return false;
        }
        var parentElement = typeof(config.parentElement) != 'undefined' ? config.parentElement : 'body';
        var extra = typeof(config.extra) != 'undefined' ? config.extra : '';
        $(parentElement).on(event, targetElement, function (e) {
            callback(e, extra);
        });
    },
    log:function (msg) {
        console.log(msg);
    },
    printBarcode:function (e) {
        var $e = $(e.currentTarget);
        var type = typeof($e.attr('b-type')) != 'undefined' ? $e.attr('b-type') : 1;
        var barcode = $e.attr('b-code');
        //barcode = '4269999999';
        var name = $e.attr('b-name');
        var mrp = parseFloat($e.attr('b-mrp'));

        var html = '';

        if (type == '1') {
            html += '<div class="cosmetic-barcode-container"><div id="barcode-target"></div><div class="barcode-hri">'+barcode+'</div></div>';
            html += '<div class="cosmetic-barcode-description"><span class="name">' + name + '</span><span class="price">M.R.P : ' + mrp.toFixed(2) + '</span></div></div>';

            $('#print-area').html(html);
            $('#print-area #barcode-target').barcode(barcode, "code128", {barWidth:1, barHeight:13, output:'bmp'});
            $('#print-area #barcode-target').attr('style', 'width: 100%');
            $('#print-area #barcode-target object').attr('style', 'width: inherit; height: 8mm');
        } else if (type == '2') {
            html += '<div class="jewellery-barcode-container"><div id="barcode-target"></div><div class="barcode-hri">'+barcode+'</div></div>';
            html += '<div class="jewellery-barcode-description"><span class="name">' + name + '</span><span class="price">M.R.P : ' + mrp.toFixed(2) + '</span></div></div>';

            $('#print-area').html(html);
            $('#print-area #barcode-target').barcode(barcode, "code128", {barWidth:1, barHeight:12, output:'bmp'});
            $('#print-area #barcode-target').attr('style', 'width: 25mm');
            $('#print-area #barcode-target object').attr('style', 'width: 25mm; height: 5mm');
        }
        setTimeout(function () {
            window.print();
        }, 1000); 
    },
    /*
     * printContentElement : ''
     *
     */
    print:function (e, config) {
        var targetElement = '#print-area';
        var sourceElement = typeof(config.sourceElement) != 'undefined' ? config.sourceElement : '';
        if (sourceElement == '' || $(sourceElement).length <= 0) {
            BIZ.app.log('Error: Print Source Element is undefined');
            return false;
        }
        $(targetElement).html($(sourceElement).html());
        window.print();
    },
    /*
     *
     */
    search:function (e, config) {

        console.log(e);
        if (config.search == 0) {
            if (e.keyCode != 13) {
                return false;
            }
        }
        var term = $(config.field).val().trim();
        if (term == '') {
            return false;
        }
        $.fancybox.showActivity();
        $.ajax({
            type:"GET",
            url:config.url,
            data:{
                search:term,
                ajax:1
            },
            success:function (data) {
                console.log(data);
                $(config.targetDiv).html(data);
            },
            complete:function (jqXHR, textStatus) {
                $.fancybox.hideActivity();
            },
            statusCode:{
                404:function () {
                    alert("page not found");
                    notification.push({
                        message:'Page Not Found',
                        alertType:'error'
                    });
                },
                500:function () {
                    notification.push({
                        message:'Database Error',
                        alertType:'error'
                    });
                }
            }
        });
    },
    getQueryParameterByName:function (name, url) {
        var url = typeof url != 'undefined' ? url : location.href;
        name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
        var regexS = "[\\?&]" + name + "=([^&#]*)";
        var regex = new RegExp(regexS);
        var results = regex.exec(url);
        if (results == null)
            return "";
        else
            return decodeURIComponent(results[1].replace(/\+/g, " "));
    },
    updateQueryParameters:function (uri, key, value) {
        var re = new RegExp("([?|&])" + key + "=.*?(&|$)", "i");
        separator = uri.indexOf('?') !== -1 ? "&" : "?";
        if (uri.match(re)) {
            return uri.replace(re, '$1' + key + "=" + value + '$2');
        }
        else {
            return uri + separator + key + "=" + value;
        }
    },
    removeQueryParameter:function removeParameter(url, parameter) {
        var urlparts = url.split('?');

        if (urlparts.length >= 2) {
            var urlBase = urlparts.shift(); //get first part, and remove from array
            var queryString = urlparts.join("?"); //join it back up

            var prefix = encodeURIComponent(parameter) + '=';
            var pars = queryString.split(/[&;]/g);
            for (var i = pars.length; i-- > 0;)               //reverse iteration as may be destructive
                if (pars[i].lastIndexOf(prefix, 0) !== -1)   //idiom for string.startsWith
                    pars.splice(i, 1);
            url = urlBase + '?' + pars.join('&');
        }
        return url;
    },
    focusedElement:function (e) {
        BIZ.lastFocusedElement = e;
    },
    toggleCheck:function (e) {
        console.log(e);
        var $e = $(e.currentTarget);
        var checked = $e.attr('checked');
        $e.parents('table').find('tbody tr input[name*=checkbox]').each(function () {
            if (checked == 'checked') {
                $(this).attr('checked', 'checked');
            } else {
                $(this).removeAttr('checked');
            }
        });
    },
    deleteDialog:function (e) {
        e.preventDefault();
        console.log(e);
        $e = $(e.currentTarget);
        var url = $e.attr('href');
        $('#dialog_confirm_url').val(url);
        $("#dialog-confirm").dialog('open');
    }
};

BIZ.attributeManager = {
    valueTypeChanged:function (e, data) {
        BIZ.app.log(e);
        var valueType = e.currentTarget.value;
        $('.value-type').hide();
        $('.value-type input, .value-type textarea').removeClass('required');
        if (valueType == 'text') {
            $('.value-type-text').show();
            $('#value_minimum_value, #value_maximum_value').addClass('required');
            $('#value_minimum_value, #value_maximum_value').addClass('digits');
            $('#value_minimum_value').parents('.controls').siblings('label').html('Minimum Length');
            $('#value_maximum_value').parents('.controls').siblings('label').html('Maximum Length');
            $('#value_minimum_value').val('1');
            $('#value_maximum_value').val('20');
            $('#value_maximum_value').attr('max', '20');
            $('#value_default_value').removeAttr('min');
            $('#value_default_value').removeAttr('max');
            $('#value_default_value').attr('minlength', '1');
            $('#value_default_value').attr('maxlength', '20');
        } else if (valueType == 'number') {
            $('.value-type-number').show();
            $('#value_multiplier, #value_minimum_value, #value_maximum_value').addClass('required');
            $('#value_minimum_value, #value_maximum_value').removeClass('digits');
            $('#value_minimum_value').parents('.controls').siblings('label').html('Minimum Value');
            $('#value_maximum_value').parents('.controls').siblings('label').html('Maximum Vaue');
            $('#value_multiplier').val('1');
            $('#value_minimum_value').val('1');
            $('#value_maximum_value').val('1');
            $('#value_maximum_value').removeAttr('max');
            $('#value_default_value').removeAttr('minlength');
            $('#value_default_value').removeAttr('maxlength');
            $('#value_default_value').attr('min', '1');
            $('#value_default_value').attr('max', '1');
        } else if (valueType == 'set') {
            $('.value-type-set').show();
            $('#value_set_values').addClass('required');
        }
    },
    updateMinimumMaximumValues:function (e, data) {
        var value = parseFloat(e.currentTarget.value);
        value = !isNaN(value) ? value : 1;
        $('#value_minimum_value').val(value);
        $('#value_maximum_value').val(value);
        BIZ.app.log(value);
    },
    updateDefaultValueLimits:function () {
        var valueType = $('#attribute_value_type').val();
        if (valueType == 'text') {
            $('#value_default_value').removeAttr('min');
            $('#value_default_value').removeAttr('max');
            $('#value_default_value').attr('minlength', $('#value_minimum_value').val());
            $('#value_default_value').attr('maxlength', $('#value_maximum_value').val());
        } else if (valueType == 'number') {
            $('#value_default_value').removeAttr('minlength');
            $('#value_default_value').removeAttr('maxlength');
            $('#value_default_value').attr('min', $('#value_minimum_value').val());
            $('#value_default_value').attr('max', $('#value_maximum_value').val());
        }
    },
    validate:function (form) {
        var name = form.name.value.trim();
        if (name.match('^[A-Za-z0-9_]+$') == null) {
            notification.push({
                message:'Name should contain only letters, numbers and underscore.',
                alertType:'error',
                messageType:'sticky'
            });
            $(form.name).focus();
            return false;
        }
        return true;
    }
};

BIZ.vouchers = {
    toggleAmountTypes:function (e, data) {
        var value = e.currentTarget.value.trim();
        if (value == 'value_set') {
            $('.amount-type-value-set').show();
            $('.amount-type-amount').hide();
            $('input[name=amount_value]').removeClass('required');
            $('input[name=amount_min_value]').removeClass('required');
            $('input[name=amount_max_value]').removeClass('required');
            $('textarea[name=amount_value_set]').addClass('required');
        } else {
            $('.amount-type-value-set').hide();
            $('.amount-type-amount').show();
            $('input[name=amount_value]').addClass('required');
            $('input[name=amount_min_value]').addClass('required');
            $('input[name=amount_max_value]').addClass('required');
            $('textarea[name=amount_value_set]').removeClass('required');

        }
    },
    validate:function () {
        return true;
    }
}

var notification = {
    /*
     message : Message to display
     alert_type : error, success, info
     msg_type: sticky, normal
     */
    push:function (arg) {
        var message = (typeof(arg.message) != 'undefined') ? arg.message : '';
        var alertType = (typeof(arg.alertType) != 'undefined') ? arg.alertType : 'info';
        var messageType = (typeof(arg.messageType) != 'undefined') ? arg.messageType : 'normal';
        var html = '<div class="alert alert-' + alertType + ' fade in">' +
            '<button class="close" onclick="$(this).parents(\'.alert\').remove()">×</button>' +
            message +
            '</div>';
        var e = $('.notification-block').append(html);
        if (messageType != 'sticky') {
            notification.setTime(e.find('div:last'), 3000);
        }
    },
    setTime:function (e, time) {
        setTimeout(function () {
            e.remove();
        }, 5000);
    },
    removeAll:function () {
        $('.notification-block').html('');
    }
}

var tabs = {
    /*
     tabsId : tabs id,
     */
    bind:function (params) {
        var tabs_id = typeof(params.tabsId) != 'undefined' ? params.tabsId : '';
        $(tabs_id).tabs({
            select:function (event, ui) {
                var url = site_url + '/' + $(ui.tab.parentNode).attr('url');
                window.location.href = url;
                return false;
            },
            ajaxOptions:{
                error:function (xhr, status, index, anchor) {
                }
            }
        });
    },
    /*select:function (tabs_id, tab_no) {
     $(tabs_id).tabs('select', tab_no);
     },*/
    reload:function (url) {
        var destination = BIZ.app.getQueryParameterByName('destination', url);
        destination = destination != '' ? destination : '.content-main';
        BIZ.ajax_url = typeof(url) != 'undefined' ? url : BIZ.ajax_url;
        $.fancybox.showActivity();
        BIZ.ajax_url = BIZ.app.updateQueryParameters(BIZ.ajax_url, 'ajax', 1);
        if (destination == '.content-main') {
            var href = BIZ.app.removeQueryParameter(BIZ.ajax_url, 'ajax');
            history.pushState({url:href}, '', href);
        }
        $.ajax({
            type:"GET",
            url:BIZ.ajax_url,
            success:function (data) {
                try {
                    data = jQuery.parseJSON(data);
                } catch (e) {

                }
                var html = typeof data.grid != 'undefined' ? data.grid : data;
                $(destination).html(html);
            },
            complete:function (jqXHR, textStatus) {
                $.fancybox.hideActivity();
            },
            statusCode:{
                404:function () {
                    alert("page not found");
                    notification.push({
                        message:'Page Not Found',
                        alertType:'error'
                    });
                },
                500:function () {
                    notification.push({
                        message:'Database Error',
                        alertType:'error'
                    });
                }
            }
        });
        $("#ui-tabs-" + $("#tabs").tabs('option', 'selected')).load(BIZ.ajax_url);
    }
}

var tree = {
    create:function (element, arg) {
        var arg = (typeof(arg) != 'undefined') ? arg : {};
        var select = (typeof(arg.select) != 'undefined') ? arg.select : tree.callback;
        var i_open = new Array();
        i_open[0] = (typeof(arg.initially_open) != 'undefined') ? arg.initially_open : '-1';
        $(element)
            .jstree({
                core:{
                    'initially_open':i_open
                }
            })
            .bind('select_node.jstree', function (event, data) {
                select(event, data);
            })
    },
    callback:function (event, data) {
    }
}

element = {
    bind:function (config) {
        var allEvents = ['click', 'blur', 'keyup', 'change', 'focus', 'blur', 'mouseover', 'mouseout'];
        var event = typeof(config.event) != 'undefined' ? config.event.trim() : '';
        if (event == '') {
            app.log('Error: Event Name is empty in Binding Event');
            return false;
        }
        if (jQuery.inArray(event, allEvents) == -1) {
            app.log('Error: Invalid Event Name in Binding Event');
            return false;
        }
        var targetElement = typeof(config.targetElement) != 'undefined' ? config.targetElement : '';
        if (targetElement == '' || $(targetElement).length <= 0) {
            app.log('Error: On ' + event + ' event ' + targetElement + ' Binding');
            return false;
        }
        var parentElement = typeof(config.parentElement) != 'undefined' ? config.parentElement : 'body';
        var extra = typeof(config.extra) != 'undefined' ? config.extra : '';
        $(parentElement).on(event, targetElement, function (e) {
            callback(e, extra);
        });
    },
    click:function (id, callback, extra) {
        $(id).click(function (e) {
            callback(e, extra);
        });
    },
    blur:function (id, callback, extra) {
        $(id).blur(function (e) {
            callback(e, extra);
        });
    },
    key_up:function (id, callback, extra) {
        $(id).keyup(function (e) {
            callback(e, extra);
        });
    },
    change:function (id, callback, extra) {
        $(id).change(function (e) {
            callback(e, extra);
        });
    },
    focus:function (id, callback, extra) {
        $(id).focus(function (e) {
            callback(e, extra);
        });
    },
    blur:function (id, callback, extra) {
        $(id).blur(function (e) {
            callback(e, extra);
        });
    },
    mouseOver:function (id, callback, extra) {
        $(id).mouseover(function (e) {
            callback(e, extra);
        });
    },
    mouseOut:function (id, callback, extra) {
        $(id).mouseout(function (e) {
            callback(e, extra);
        });
    },
    isEnterKey:function (e, extra) {
        return e.keyCode == 13 ? true : false;
    },
    validate:function (id, callback) {
        $(id).validate({
            submitHandler:function (form) {
                callback(form);
            }
        });
    }
}

var app = {
    /*
     * inputId : input element id,
     * url : url
     * callback : callback function
     * config: configuration
     */
    autocomplete:function (element, url, callback, config) {
        $(element).autocomplete({
            minLength:2,
            appendTo:$(element).parents('.autocomplete-jui'),
            source:url,
            select:function (e, ui) {
                callback(e, ui, config);
            }
        });
    },
    whiteIcon:function (element) {
        $(element).addClass('icon-white');
    },
    blackIcon:function (element) {
        $(element).removeClass('icon-white');
    },
    delete:function (e) {
    },
    getTotalRows:function (id) {
        var length = $(id).find('tr').length;
        var count = 0;
        $(id).find('tr').each(function (index) {
            if ($(this).attr('class') == 'table-footer') {
                return false;
            }
            if (index != 0) {
                count++;
            }
        });
        return count;
    },
    log:function (msg) {
        console.log(msg);
    },
    /*
     * printContentElement : ''
     *
     */
    print:function () {
        var printeAreaElement = '#print-area';
        var printContentElement = typeof(printContentElement) != 'undefined'
        $('#print-area').html($('.print-page').html());
        window.print();
    }
}

var pagination = {
    update:function (url) {
        window.BIZ.ajax_url = url;
        $('#ui-tabs-' + $("#tabs").tabs('option', 'selected')).load(url);
    }
}

var fancyBox = {
    bind:function () {
        $('a.fancybox').fancybox({
            padding:0,
            hideOnOverlayClick:false,
            showCloseButton:true,
            enableEscapeButton:false,
            onClosed:fancyBox.close
        });
    },
    close:function () {
        $('#validation-block').css({ 'visibility':'hidden'});
    }
}

var validation = {
    /*
     formId : form Id,
     ajaxSubmit: false,
     callback: null,
     successCallback: null
     reload: false,
     config: configuration
     */
    bind:function (params) {
        if (typeof(params.formId) == 'undefined') {
            return false;
        }
        var form_id = params.formId;
        var ajaxSubmit = typeof(params.ajaxSubmit) != 'undefined' ? params.ajaxSubmit : false;
        var callback = typeof(params.callback) == 'function' ? params.callback : null;
        var successCallback = typeof(params.successCallback) == 'function' ? params.successCallback : null;
        var reload = typeof(params.reload) != 'undefined' ? params.reload : false;
        $(form_id).validate({
            highlight:function (element, errorClass, validClass) {
                $(element).addClass('validation-error');
            },
            unhighlight:function (element, errorClass, validClass) {
                $(element).removeClass('validation-error');
                $(element).removeAttr('validationmessage');
                validation.closeErrorInfo();
            },
            errorPlacement:function (error, element) {
                $(element).attr('validationMessage', $(error).html());
            },
            submitHandler:function (f) {
                // form submission without ajax
                if (!ajaxSubmit) {
                    if (callback == null) {
                        f.submit();
                    } else {
                        callback(f);
                    }
                } else {
                    var state = callback == null ? true : callback(f);
                    if (state) {
                        validation.closeErrorInfo();
                        $.fancybox.showActivity();
                        $.ajax({
                            type:"POST",
                            url:f.action,
                            data:$(f).serializeArray(),
                            success:function (data) {
                                data = jQuery.parseJSON(data);
                                $.fancybox.hideActivity();
                                if (successCallback == null) {
                                    validation.showMessage(data, reload);
                                } else {
                                    if (data.status == 'success') {
                                        successCallback(data);
                                    } else {
                                        validation.showMessage(data, reload);
                                    }
                                }
                            }
                        });
                    }
                }
            }
        });
    },
    focus:function (e) {
        var element = e.currentTarget;
        $('#validation-block').css({ 'visibility':'hidden'});
        var msg = typeof($(element).attr('validationmessage')) != 'undefined' ? $(element).attr('validationmessage') : '';
        if (msg != '') {
            $('#validation-block .err').html(msg);
            var positions = $(element).offset();
            var top = positions.top;
            var left = positions.left;
            var width = $(element).innerWidth();
            var height = $(element).height();
            top = top - $('#validation-block').height() + 5;
            left = left + width - 40;
            $('#validation-block').css({ 'top':top, 'left':left, 'visibility':'visible'});
        }
    },
    closeErrorInfo:function () {
        $('#validation-block').css({ 'visibility':'hidden'});
    },
    showMessage:function (data, reload) {
        if (typeof(data.status) != 'undefined' && data.status == 'success') {
            notification.push({


                message:data.msg,
                alertType:'success'
            });
            if (typeof(reload) != 'undefined' && reload) {
                tabs.reload();
            }
            $.fancybox.close();
        } else if (typeof(data.status) != 'undefined' && data.status == 'error') {
            notification.push({
                message:data.msg,
                alertType:'error',
                messageType:'sticky'
            });
        }
    }
};
var formValidate = {
    submit:function (form_element, ajax, callback, submit) {
        $(form_element).validate({
            highlight:function (element, errorClass, validClass) {
                $(element).parents('.control-group').addClass('error').removeClass('success');
            },
            unhighlight:function (element, errorClass, validClass) {
                $(element).parents('.control-group').removeClass('error');
                $(element).parents('.content-subject').find('.label-warning').css('opacity', '0')
            },
            errorPlacement:function (error, element) {
                $(element).attr('validatemsg', $(error).html());
            },
            submitHandler:function (form) {
                if (!ajax) {
                    callback(form);
                    return false;
                }
                if (typeof(callback) != 'undefined') {
                    if (!callback()) {
                        return false;
                    }
                }
                $.fancybox.showActivity();
                $.ajax({
                    type:"POST",
                    cache:false,
                    url:form.action,
                    data:$(form).serializeArray(),
                    success:function (data) {
                        formValidate.success(data);
                    }
                });
                return false;
            }
        });
    },
    messages:function () {
        $('.control-group input, .control-group textarea, .control-group select').focus(function () {
            var classes = $(this).parents('.control-group').attr('class');
            if (classes.search('error') != -1) {
                var msg = $(this).attr('validatemsg');
                $(this).parents('.content-subject').find('.label-warning').html(msg);
                $(this).parents('.content-subject').find('.label-warning').css('opacity', '1');
            } else {
                $(this).parents('.content-subject').find('.label-warning').css('opacity', '0');
            }
        });
    },
    removeFlashMessage:function () {
        setTimeout('$(".flash-message").each(function(){$(this).remove();})', 3000)
    },
    success:function (data) {
        $.fancybox.hideActivity();
        $('#fancybox-content').html(data);
        formValidate.removeFlashMessage();
        if (window.BIZ.ajax_url == '') {
            $("#tabs").tabs('load', $("#tabs").tabs('option', 'selected'));
        } else {
            $('#ui-tabs-' + $("#tabs").tabs('option', 'selected')).load(window.BIZ.ajax_url);
        }
    }
}

var product = {
    change:function (type_element, add_element, callback, grid_element) {
        $(type_element).change(function () {
            product.changeButton(type_element, add_element);
            if (typeof(callback) != "undefined") {
                callback(type_element, grid_element);
            }
        });
    },
    changeButton:function (type_element, add_element) {
        var id = $(type_element).val();
        var href = $(add_element).attr('href');
        var index = href.search('pt');

        href = href.substring(0, index);
        href += 'pt=' + id;

        var type_name = $(type_element).find('option[value=' + id + ']').html();
        var html = $(add_element).html();

        index = html.search('Add');
        type_name = type_name.charAt(0).toUpperCase() + type_name.slice(1);
        html = html.substring(0, index + 4) + type_name;

        $(add_element).attr('href', href);
        $(add_element).html(html);
    }
}

var products = {
    displayGrid:function (type_element, grid_element) {
        var id = $(type_element).val();
        $.ajax({
            type:'GET',
            url:'/index.php/product/displayProduct/' + id + '?json=1',
            success:function (data) {
                data = jQuery.parseJSON(data);
                $(grid_element).html(data['grid']);
                fancyBox.bind();
            }
        });
    },
    select:function (e, ui) {
        products.append(e, ui, ui.item.item_entity_id);
    },
    append:function (e, ui, type) {
        if (!products.isAdded(ui.item.item_entity_id, ui.item.id)) {
            var html = '<div class="label label-success tags">';
            html += '<span class="pull-left">';
            html += ui.item.name;
            html += '<input type="hidden" value="' + ui.item.item_entity_id + '_' + ui.item.id + '" name="item_id[]">';
            html += '<input type="hidden" name="item_specific_id_' + ui.item.item_entity_id + '" value="' + ui.item.id + '"/>';
            html += '</span><i class="icon-trash icon-white pull-right" onmouseover="app.blackIcon(this)" onmouseout="app.whiteIcon(this)" onclick="products.remove(this)"></i></div>';
            $('#add_ornament_tags_' + type).append(html);
        } else {
            alert('Item is Already Added');
        }
    },
    isAdded:function (entity_id, specific_id) {
        var o = $('#add_ornament_tags_' + entity_id + ' input[name*=item_id]');
        var found = false;
        $(o).each(function () {
            e_id = $(this).val().charAt(0);
            s_id = $(this).val().charAt(2);
            if (e_id == entity_id && s_id == specific_id) {
                found = true;
            }
        });
        return found;
    },
    remove:function (e) {
        $(e).parents('.tags').remove();
    },
    canSubmit:function () {
        var found = false;
        var l = $('#add_ornament_tags_1 input[name*=item_id]').length;
        l += $('#add_ornament_tags_2 input[name*=item_id]').length;
        return l > 0 ? true : false;
    }
}

var classes = {
    view:function (e, data) {
        var id = data.rslt.obj.attr("id");
        if (id == 0) {
            var html = $('#class_default_message').html();
            $('#class_view').html(html);
        } else {
            $.ajax({
                type:'GET',
                url:site_url + '/classification/view/' + id,
                data:{
                    json:'1'
                },
                datatype:'json',
                success:function (data) {
                    data = jQuery.parseJSON(data);
                    $('#class_view').html(data.html);
                }
            });
        }
    },
    editSelect:function (e, ui) {
        var row = classes.isItemAdded('#edit_category_class_attributes', '.attribute_name', '#edit_class_attributes_table');
        if (row === false) {
            var row_count = $('#edit_class_attributes_row_count').val();
            var template = classes.template(ui.item.id, ui.item.name, ui.item.level, row_count, ui.item.display_name);
            $('#edit_class_attributes_table').append(template);
            $('#edit_class_attributes_row_count').val(++row_count)
        } else {
            var state_element = $('#edit_class_attributes_table input[name=attribute_state_' + row + ']');
            var x = $(state_element).parents('tr').attr('class');
            if (typeof(x) != 'undefined' && x.search('hide') != -1) {
                var state = $(state_element).val();
                $(state_element).val(++state);
                $(state_element).parents('tr').removeClass('hide');
            } else {
                alert('Attribute is already Added');
            }
        }
    },
    addSelect:function (e, ui) {
        var row = classes.isItemAdded('#add_category_class_attributes', '.attribute_name', '#add_class_attributes_table');
        if (row === false) {
            var row_count = $('#add_class_attributes_row_count').val();
            var template = classes.template(ui.item.id, ui.item.name, ui.item.level, row_count, ui.item.display_name);
            $('#add_class_attributes_table').append(template);
            $('#add_class_attributes_row_count').val(++row_count)
        } else {
            var state_element = $('#add_class_attributes_table input[name=attribute_state_' + row + ']');
            var x = $(state_element).parents('tr').attr('class');
            if (typeof(x) != 'undefined' && x.search('hide') != -1) {
                var state = $(state_element).val();
                $(state_element).val(++state);
                $(state_element).parents('tr').removeClass('hide');
            } else {
                alert('Attribute is already Added')
            }
        }
    },
    add:function (e) {
        var name = $('#add_category_class_attributes').val();
        if (name.trim() == '') {
            alert('Empty String is not Allowed');
            return false;
        }
        var ui = [];
        ui['item'] = [];
        ui['item']['id'] = -3;
        ui['item']['name'] = name;
        ui['item']['level'] = '2';
        classes.addSelect('', ui);
    },
    edit:function (e) {
        var name = $('#edit_category_class_attributes').val();
        var ui = [];
        ui['item'] = [];
        ui['item']['id'] = -3;
        ui['item']['name'] = name;
        ui['item']['level'] = '2';
        classes.editSelect('', ui);
    },
    template:function (id, name, level, row_count, display_name) {
        var level_name = '';
        var display_name = display_name != null ? display_name : name;
        switch (level) {
            case '1' :
                level_name = 'Primary';
                break;
            case '2' :
                level_name = 'Secondary';
                break;
            case '3' :
                level_name = 'Tersery';
                break;
        }
        var html =
            '<tr>' +
                '<td>' + display_name +
                '<input type="hidden" name="attribute_row[]" value="' + row_count + '" />' +
                '<input type="hidden" value="' + id + '" name="attribute_id_' + row_count + '" />' +
                '<input type="hidden" value="' + name + '" name="attribute_name_' + row_count + '" class="attribute_name" />' +
                '<input type="hidden" value="' + level + '" name="attribute_level_' + row_count + '"/>' +
                '<input type="hidden" value="1" name="attribute_state_' + row_count + '"/>' +
                '</td>' +
                '<td><span>' + level_name + '</span></td>' +
                '<td style="width: 20px"><button type="button" class="btn btn-danger action-button" onclick="classes.remove(this)"><i class="icon-trash icon-white"></i></button></td>' +
                '</tr>';
        return html;
    },
    isItemAdded:function (name_element, class_element, parent_element) {
        var row = '';
        var name = $(name_element).val();
        var o = $(parent_element + ' ' + class_element);
        if (o.length == 0) {
            return false;
        } else {
            window.found_item = 0;
            $(o).each(function () {
                if (window.found_item == 0 && name.toLowerCase() == $(this).val().toLowerCase()) {
                    window.found_item = 1;
                    row = $(this).parents('tr').find('input[name*=attribute_row]').val();
                }
            });
            if (window.found_item == 1) {
                return row;
            } else {
                return false;
            }
        }
    },
    remove:function (e) {
        var state = $(e).parents('tr').find('input[name*=attribute_state]').val();
        state--;
        $(e).parents('tr').find('input[name*=attribute_state]').val(state);
        $(e).parents('tr').addClass('hide');
    },
    changeClassId:function (event, data) {
        $('#add_class_parent_id').val(data.rslt.obj.attr("id"));
    },
    changeEditClassId:function (event, data) {
        $('#edit_class_parent_id').val(data.rslt.obj.attr("id"));
    }
}

var products = {
    filter:function () {
        var brand = $('#products_brand_id').val();
        var class_id = $('#products_class_id').val();
        $.ajax({
            type:"POST",
            url:site_url + '/' + 'product',
            data:{
                brand_id:brand,
                class_id:class_id,
                ajax:1,
                ajax_reports:0
            },
            success:function (data) {
                $.fancybox.hideActivity();
                $('.content-main').html(data);
            }
        });
    },
    selectBrand:function (e, ui) {
        $('#add_product_brand_id').val(ui.item.id);
    },
    skuClick:function (e) {
        if (e.checked) {
            $(e).parents('tr').find('input[name*=attribute_value]').addClass('hide');
        } else {
            $(e).parents('tr').find('input[name*=attribute_value]').removeClass('hide');
        }
    },
    editChangeClass:function (e) {
        products.changeClass(e, '#edit_product_attributes_table', '#edit_product_attributes_row_count');
    },
    changeClass:function (e, extra) {
        var id = e.target.value;
        $.get(
            site_url + '/classification/get_attributes_by_class/' + id,
            {},
            function (data, textstatus) {
                if (textstatus != 'success') {
                    $(extra['class']).val(0);
                    return false;
                }
                if (data.class_id != $(extra['class']).val()) {
                    return false;
                }
                products.removeAttributes(extra['table'], extra['row_count']);
                var template = '';
                if (data.row_total > 0) {
                    for (var i = 0; i < data.row_total; i++) {
                        template += products.template(data.attributes[i].id, data.attributes[i].name, data.attributes[i].level, '', 0, 1, i, data.attributes[i]['display_name']);
                    }
                }
                $(extra['table']).append(template);
                $(extra['row_count']).val(data.row_total);
            },
            'json'
        );
    },
    addSelect:function (e, ui) {
        var row = classes.isItemAdded('#add_product_class_attributes', '.attribute_name', '#add_product_attributes_table');
        if (row === false) {
            var row_count = $('#add_product_attributes_row_count').val();
            var template = products.template(ui.item.id, ui.item.name, ui.item.level, '', 0, 1, row_count, ui.item.display_name);
            $('#add_product_attributes_table').append(template);
            $('#add_product_attributes_row_count').val(++row_count);
        } else {
            var state_element = $('#add_product_attributes_table input[name=attribute_state_' + row + ']');
            var x = $(state_element).parents('tr').attr('class');
            if (typeof(x) != 'undefined' && x.search('hide') != -1) {
                var state = $(state_element).val();
                $(state_element).val(++state);
                $(state_element).parents('tr').removeClass('hide');
            } else {
                alert('Attribute is already Added')
            }
        }
    },
    add:function (e) {
        var name = $('#add_product_class_attributes').val();
        if (name.trim() == '') {
            alert('Empty String is not Allowed');
            return false;
        }
        var ui = [];
        ui['item'] = [];
        ui['item']['id'] = -3;
        ui['item']['name'] = name;
        ui['item']['level'] = '2';
        products.addSelect('', ui);
    },
    editSelect:function (e, ui) {
        var row = classes.isItemAdded('#edit_product_class_attributes', '.attribute_name', '#edit_product_attributes_table');
        if (row === false) {
            var row_count = $('#edit_product_attributes_row_count').val();
            ui['item']['mvalue'] = (typeof(ui['item']['mvalue']) != 'undefined') ? ui['item']['mvalue'] : '';
            ui['item']['msku'] = (typeof(ui['item']['msku']) != 'undefined') ? ui['item']['msku'] : 0;
            ui['item']['mstate'] = (typeof(ui['item']['mstate']) != 'undefined') ? ui['item']['mstate'] : 1;
            //ui['item']['display_name'] = (typeof(ui['item']['display_name']) != 'undefined') ? ui['item']['display_name'] : ui.item.name;
            var template = products.template(ui.item.id, ui.item.name, ui.item.level, ui.item.mvalue, ui.item.msku, ui.item.mstate, row_count, ui.item.display_name);
            $('#edit_product_attributes_table').append(template);
            $('#edit_product_attributes_row_count').val(++row_count)
        } else {
            var state_element = $('#edit_product_attributes_table input[name=attribute_state_' + row + ']');
            var x = $(state_element).parents('tr').attr('class');
            if (typeof(x) != 'undefined' && x.search('hide') != -1) {
                var state = $(state_element).val();
                $(state_element).val(++state);
                $(state_element).parents('tr').removeClass('hide');
            } else {
                alert('Attribute is already Added')
            }
        }
    },
    edit:function (e) {
        var name = $('#edit_product_class_attributes').val();
        if (name.trim() == '') {
            alert('Empty String is not Allowed');
            return false;
        }
        var ui = [];
        ui['item'] = [];
        ui['item']['id'] = -3;
        ui['item']['name'] = name;
        ui['item']['name'] = name;
        ui['item']['level'] = '2';
        products.editSelect('', ui);
    },
    editAdd:function (id, name, level, value, sku, display_name) {
        var ui = [];
        ui['item'] = [];
        ui['item']['id'] = id;
        ui['item']['name'] = name;
        ui['item']['level'] = level.toString();
        ui['item']['mvalue'] = value;
        ui['item']['msku'] = sku;
        ui['item']['mstate'] = 0;
        ui['item']['display_name'] = display_name;
        products.editSelect('', ui);
    },
    removeAttributes:function removeAttributes(table_element, row_count) {
        $(table_element + ' tr').each(function (index) {
            if (index != 0) {
                $(this).remove();
            }
        });
        $(row_count).val('0');
    },
    template:function (id, name, level, value, sku, state, row_count, display_name) {
        var level_name = '';
        var display_name = display_name != null ? display_name : name;
        switch (level) {
            case '1' :
                level_name = 'Primary';
                break;
            case '2' :
                level_name = 'Secondary';
                break;
            case '3' :
                level_name = 'Tertiary';
                break;
        }
        var html =
            '<tr>' +
                '<td>' + display_name +
                '<input type="hidden" name="attribute_row[]" value="' + row_count + '" />' +
                '<input type="hidden" value="' + id + '" name="attribute_id_' + row_count + '" />' +
                '<input type="hidden" value="' + name + '" name="attribute_name_' + row_count + '" class="attribute_name" />' +
                '<input type="hidden" value="' + level + '" name="attribute_level_' + row_count + '"/>' +
                '<input type="hidden" value="' + state + '" name="attribute_state_' + row_count + '"/>' +
                '</td>';
        if (sku == 0) {
            html += '<td class="span1"><input type="text" class="required span1" name="attribute_value_' + row_count + '" value="' + value + '" /></td>';
        } else {
            html += '<td class="span1"><input type="text" class="span1 hide" name="attribute_value_' + row_count + '" /></td>';
        }
        html += '<td class="span1"><span>' + level_name + '</span></td>';
        if (sku == 0) {
            html += '<td style="width: 20px"><label class="checkbox"><input type="checkbox" name="attribute_checked_' + row_count + '" onclick="products.skuClick(this)" /></label></td>';
        } else {
            html += '<td style="width: 20px"><label class="checkbox"><input type="checkbox" name="attribute_checked_' + row_count + '" onclick="products.skuClick(this)" checked /></label></td>';
        }
        html += '<td style="width: 20px"><button type="button" class="btn btn-danger action-button" onclick="products.remove(this)"><i class="icon-trash icon-white"></i></button></td>' +
            '</tr>';
        return html;
    },
    isItemAdded:function (name_element, class_element, parent_element) {
        var row = '';
        var name = $(name_element).val().trim();
        var o = $(parent_element + ' ' + class_element);
        if (o.length == 0) {
            return false;
        } else {
            window.found_item = 0;
            $(o).each(function () {
                if (window.found_item == 0 && name.toLowerCase() == $(this).val().toLowerCase()) {
                    window.found_item = 1;
                    row = $(this).parents('tr').find('input[name*=attribute_row]').val();
                }
            });
            if (window.found_item == 1) {
                return row;
            } else {
                return false;
            }
        }
    },
    remove:function (e) {
        var state = $(e).parents('tr').find('input[name*=attribute_state]').val();
        state--;
        $(e).parents('tr').find('input[name*=attribute_state]').val(state);
        $(e).parents('tr').addClass('hide');
    },
    addValidate:function () {
        var brand_id = $('#add_product_brand_id').val();
        if (brand_id.trim() == '') {
            notification.push({
                message:'Please Select Brand',
                alertType:'error'
            });
            return false;
        }
        if ($('#add_product_attributes_row_count').val() == 0) {
            notification.push({
                message:'Add at least one Attribute',
                alertType:'error'
            });
            return false;
        }
        return true;
    },
    editValidate:function () {
        var brand_id = $('#edit_product_brand_id').val();
        if (brand_id.trim() == '') {
            alert('Please Select Brand');
            return false;
        }
        if ($('#edit_product_attributes_row_count').val() == 0) {
            alert('Add at least one Attribute');
            return false;
        }
        return true;
    }
};

var purchaseOrder = {
    selectVendor:function (e, ui, config) {
        $('#po_vendor_id').val(ui.item.id);
    },
    selectContactPerson:function (e, ui, config) {

    },
    terms:function (e, config) {
        var value = e.currentTarget.value;
        $("#on_date").hide();
        $('#po_x_days').hide();
        $("#pay_po_x_days").removeClass("required number");
        $("#pay_on_date").removeClass("required");
        switch (value) {
            case "terms_after_gr":
            case "terms_po_x_days":
                $('#po_on_date').hide();
                $("#pay_on_date").removeClass("required");
                $('#po_x_days').show();
                $("#pay_days").addClass("required");
                break;
            case "terms_on_date":
                $('#po_x_days').hide();
                $("#pay_days").removeClass("required");
                $("#po_on_date").show();
                $("#pay_on_date").addClass("required");
                break;
        }
    },
    add:function (e, ui, config) {
        var item = ui.item;
        var row_count = parseInt($(config.row_count).val()) + 1;
        var qty = '';
        var price = '';
        $(config.table).append(purchaseOrder.template(e, row_count, item.id, '', item.name, item.attributes, qty, price, ui.item.stock, ui.item.mrp_value, item.brand));
        $(config.row_count).val(row_count);
        purchaseOrder.updateSerials(config);
        purchaseOrder.update(config);
        element.focus(config.table + ' input', validation.focus);
        element.key_up(config.table + ' input', validation.focus);
    },
    remove:function (e) {
        $(e).parents('tr').remove();
        //purchaseOrder.update(config.po);
        //purchaseOrder.updateSerials(config.po);
    },
    updateSerials:function (config) {
        var length = $(config.table).find('tr').length;
        $(config.table).find('tr').each(function (index) {
            if (index != 0 || index != length) {
                $(this).find('.product-sno').html(index);
            }
        });
    },
    update:function (config) {
        var quantity, price, total, po_total = 0;
        var length = $(config.table).find('tr').length;
        $(config.table).find('tr').each(function (index) {
            if ($(this).attr('class') == 'table-footer') {
                return false;
            }
            if (index != 0) {
                total = 0;
                quantity = $(this).find('input[name*=quantity]').val();
                price = $(this).find('input[name*=price]').val();
                quantity = !isNaN(quantity) && quantity >= 0 ? quantity : 0;
                price = !isNaN(price) && price >= 0 ? price : 0;
                total = price * quantity;
                po_total += total;
                total = total.toFixed(2);
                $(this).find('.product-total').html(total);
            }
        });
        po_total = po_total.toFixed(2);
        $(config.table).find('#po_sub_total').html(po_total);
    },
    removeAttribute:function (e) {
        $(e).parents('.table-attribute').remove();
    },
    template:function (entry, row_count, id, sno, name, attributes, qty, price, stock, mrpValue, brandName) {
        var ids = '25_' + id + '_' + row_count;
        qty = (typeof(qty) != 'undefined') ? qty : '';
        stock = (typeof(stock) != 'undefined' && stock != null) ? stock : 0;
        mrpValue = (typeof(mrpValue) != 'undefined' && mrpValue != null) ? mrpValue : 0;
        price = (typeof(price) != 'undefined') ? price : '';
        stock = parseFloat(stock).toFixed(3);
        mrpValue = parseFloat(mrpValue).toFixed(2);
        var total = (isNaN(qty) || isNaN(price)) ? 0 : qty * price;
        total = total.toFixed(2);
        if (typeof(attributes) == 'undefined' || (typeof(attributes) != 'array' && typeof(attributes) != 'object')) {
            attributes = new Array();
        }
        var html = '<tr>';
        html += '<td class="text-right product-sno">' + sno + '</td>';
        html += '<td width="25%">' + name + '<input type="hidden" name="name_' + ids + '" value="' + name + '" /><input type="hidden" name="item_id[]" value="' + ids + '" /></td>';
        html += '<td>' + brandName + '</td>';
        html += '<td width="75%">';
        var count = attributes.length;
        var name = '';
        var value = '';
        var input_class = 'input-mini';
        var read_only = '';
        var click_action = '';
        var type = '0';
        for (var i = 0; i < count; i++) {
            name = typeof(attributes[i].display_name) != 'undefined' && attributes[i].display_name != null ? attributes[i].display_name : attributes[i].name;
            if(attributes[i].name == 'mfg_barcode') {
                input_class = 'input-medium';
            }
            if (attributes[i].sku.toString() === '0') {
                value = typeof(attributes[i].value) != 'undefined' ? attributes[i].value : '';
                read_only = ' readonly ';
                click_action = '';
                type = '1';
            } else {
                value = '';
                read_only = '';
                input_class += ' required';
                click_action = 'purchaseOrder.removeAttribute(this)';
                type = '0';
            }
            html += '<div class="input-prepend input-append table-attribute">';
            html += '<span class="add-on">' + name + '</span>';
            html += '<input type="hidden" name="attribute_id_' + ids + '[]" value="' + attributes[i].id + '"/>';
            html += '<input type="text" class="' + input_class + '" name="attribute_value_' + ids + '_' + attributes[i].id + '" value="' + value + '"  ' + read_only + '/>';
            html += '<input type="hidden" class="input-mini" name="attribute_name_' + ids + '_' + attributes[i].id + '" value="' + attributes[i].name + '" />';
            html += '<input type="hidden" class="input-mini" name="attribute_display_name_' + ids + '_' + attributes[i].id + '" value="' + name + '" />';
            html += '<input type="hidden" class="input-mini" name="attribute_type_' + ids + '_' + attributes[i].id + '" value="' + type + '" />';
            html += '<input type="hidden" name="attribute_level_' + ids + '_' + attributes[i].id + '" value="' + attributes[i].level + '" />';
            html += '<span class="add-on search-image" onclick="' + click_action + '"><i class="icon-trash"></i></span>';
            html += '</div>';
        }
        html += '</td>';
        html += '<td class="text-right cursor-hand" onclick="stock.showStockPopup(' + id + ')">' + mrpValue + ' [' + stock + ']' + '</td> ';
        html += '<td><input type="text" name="quantity_' + ids + '" class="input-mini text-right required number" min="0" autocomplete="off" value="' + qty + '" /></td>';
        //html += '<td><input type="text" name="price_' + ids + '" class="input-mini text-right required number" min="0" autocomplete="off" value="' + price + '" onkeyup="purchaseOrder.update(config.po)" /></td>';
        //html += '<td class="text-right product-total">' + total + '</td>';
        html += '<td><button onclick="purchaseOrder.remove(this)" class="btn btn-danger action-button" type="button">';
        html += '<i class="icon-trash icon-white"></i>';
        html += '</button></td>';
        html += '/tr>';
        return html;
    },
    submit:function (form) {
        var vendor_id = $(config.po.vendor_id).val().trim();
        var row_count = $(config.po.row_count).val().trim();
        if (vendor_id == '') {
            $('#po_vendor_ac').focus();
            notification.push({
                message:'Please Select Vendor from Autocomplete Filed',
                messageType:'sticky',
                alertType:'error'
            });
        } else if (row_count <= 0 || row_count == '') {
            $('#po_product_ac').focus();
            notification.push({
                message:'Atleast Select One Product to Purchase Order',
                messageType:'sticky',
                alertType:'error'
            });
        } else {
            form.submit();
        }
    }
}
var grn = {
    productBarcode:function (e) {
        if (e.keyCode == 38 || e.keyCode == 40) {
            return false;
        }
        var barcode = e.currentTarget.value;
        if (isNaN(barcode.charAt(0))) {
            $('#grn_product_ac').autocomplete('enable');
        } else {
            $('#grn_product_ac').autocomplete('disable');
            if (e.keyCode == 13 && barcode.length != 0) {
                $.fancybox.showActivity();
                $.ajax({
                    url:site_url + '/product_sku/get_by_barcode/' + barcode,
                    method:'POST',
                    datatype:'JSON',
                    data:{
                        stock:1
                    },
                    success:function (data) {
                        data = jQuery.parseJSON(data);
                        grn.selectProduct(data);
                        $('#grn_product_ac').val('');
                        $('#grn_product_ac').focus();
                    },
                    complete:function (xhr, status) {
                        $.fancybox.hideActivity();
                    },
                    statusCode:{
                        404:function () {
                            alert("page not found");
                        },
                        500:function () {
                            alert("Database Error occured");
                        }
                    }
                });
            }
        }
    },
    selectProduct:function (data) {
        var sku = typeof(data.sku) != 'undefined' ? data.sku : Array();
        /*if (sku.length == 1) {
            var name = typeof(data.header) != 'undefined' ? data.header.name : data.sku[0].name;
            var brand = typeof(data.header) != 'undefined' ? data.header.brand : data.sku[0].brand;
            var vat_percentage = typeof(data.header) != 'undefined' ? data.header.vat_percentage : data.sku[0].vat_percentage;
            if (data.sku[0].stock == null || data.sku[0].stock <= 0) {
                notification.push({
                    message:'Product is not available in Stock',
                    alertType:'info',
                    messageType:'sticky'
                });
            } else {
                grn.addProduct({
                    id:data.sku[0].id,
                    name:name,
                    brand:brand,
                    qty:1,
                    stock:data.sku[0].stock,
                    price:data.sku[0.].attributes.price,
                    discount:0,
                    vat:vat_percentage,
                    attributes:data.sku[0].attributes
                });
            }
        }*/
        grn.showPopup(data);
    },
    showPopup:function (data) {
        var name = typeof(data.header.name) != 'undefined' ? data.header.name : '';
        var html = '<div class="content-header"><h3>' + name + '</h3></div>';
        html += '<div id="popup-responce" class="hide">' + JSON.stringify(data) + '</div>';
        for (i in data.sku) {
            html += grn.popupTemplate(data.sku[i], i);
        }
        html += '<div class="popup-item block" onclick="grn.popupSelectProduct(' + -1 + ')">New SKU</div>';
        $('#popup').html(html);
        $('#popup-trigger').trigger('click');
    },
    popupTemplate:function (data, no) {
        var attributes = data.attributes;
        var count = 0;
        var html = '<div class="popup-item block" onclick="grn.popupSelectProduct(' + no + ')">';
        var attributeName;
        var attributeValue;
        for (var i in attributes) {
            if (count % 2 == 0) {
                html += '<div>';
            }
            attributeName = typeof (attributes[i]['display_name']) != 'undefined' && attributes[i]['display_name'] != null ? attributes[i]['display_name'] : attributes[i]['name'];
            attributeValue = attributes[i]['value'];
            html += '<span class="span1">' + attributeName + ':</span>';
            html += '<span class="span1">' + attributeValue + '</span>';
            if (count % 2 == 1) {
                html += '</div>';
            }
            count++;
        }
        if (count % 2 == 1) {
            html += '</div>';
        }
        html += '</div>';
        return html;
    },
    searchAttribute: function(name, sku_attr) {
        for(var i in sku_attr) {
            if(sku_attr[i].name == name) {
                return sku_attr[i].value;
            }
        }
        return false;
    },
    popupSelectProduct:function (no) {
        no = parseInt(no);
        var data = $('#popup-responce').html();
        data = jQuery.parseJSON(data);
        $.fancybox.close();
        var ui = {};
        var header_attr = data.header.attributes;
        var sku_attr = no != -1 ? data.sku[no].attributes : [];
        var attr = [];
        for (var i in header_attr) {
            attr[i] = header_attr[i];
            attr[i].sku = '1';
            var value = grn.searchAttribute(attr[i].name, sku_attr);
            if(value !== false) {
                attr[i].value = value;
            }
        }
        ui.item = {
            id:data.header.id,
            name:data.header.name,
            brand:data.header.brand,
            qty:1,
            discount:0,
            vat:data.header.vat_percentage,
            attributes:attr
        };
        ui.item.stock = no != -1 ? data.sku[no].stock : 0;
        ui.item.price = no != -1 ? data.sku[no].price : 0;
        grn.add('1', ui, config.grn);
    },
    selectVendor:function (e, ui, config) {
        $('#grn_vendor_id').val(ui.item.id);
    },
    loadFromPo:function (e, config) {
        grn.emptyTable(config);
        var po_id = $(config.po_id).val().trim();
        if (po_id <= 0 || po_id == '') {
            notification.push({ message:'Invalid Purchase Order ID', alertType:'error', messageType:'sticky'});
        } else {
            $.ajax({
                type:'GET',
                url:site_url + '/grn/load_po_by_id/' + po_id,
                data:{
                    json:'1',
                    view:'0'
                },
                datatype:'json',
                success:function (data) {
                    data = jQuery.parseJSON(data);
                    if (typeof(data.success) != 'undefined' && data.success.toString() == '0') {
                        notification.push({ message:data.msg, alertType:'error', messageType:'sticky'});
                        return false;
                    }
                    $('#vendor_ac').val(data.vendor_details.company_name);
                    $('#vendor_ac').attr('disabled', 'disabled');
                    $('#vendor_block').html(grn.vendorTemplate(data.vendor_details));
                    grn.emptyTable(config);
                    $('#grn_product_ac').removeAttr('disabled');
                    var vendor_id = typeof(data.vendor_details.id) != 'undefined' ? data.vendor_details.id : '';
                    $(config.vendor_id).val(vendor_id);

                    var po_date = typeof(data.po.po_date) != 'undefined' ? data.po.po_date : '';
                    $(config.po_date).val(po_date);
                    var products;
                    if (typeof(data.product_array) == 'undefined' || (typeof(data.product_array) != 'array' && typeof(data.product_array) != 'object')) {
                        products = new Array();
                    } else {
                        products = data.product_array;
                    }
                    var count = products.length;
                    var ui = new Object();
                    for (var i = 0; i < count; i++) {
                        ui.item = products[i];
                        grn.add('', ui, config);
                    }
                    $('#grn-product-ac-block').show();
                }
            });
        }
        $(config.po_id_hidden).val(po_id);
    },
    vendorTemplate:function (vendor) {
        var html = '<div class="address-block pull-left">';
        html += '<strong>Vendor:</strong>';
        html += '<address class="address-block-address">';
        html += vendor.company_name + '<br>';
        html += vendor.address + '<br>';
        /*Bangalore,&nbsp;516603                    <br>*/
        html += '<abbr title="Mobile">P:</abbr>';
        html += vendor.mobile + '</address></div>';
        return html;
    },
    add:function (e, ui, config) {
        var item = ui.item;
        var row_count = parseInt($(config.row_count).val()) + 1;
        var qty = '';
        var price = '';
        if (e === '') {
            qty = typeof(item.quantity) != 'undefined' ? item.quantity : '';
            price = typeof(item.cost_price) != 'undefined' ? item.cost_price : '';
        }
        $(config.table).find('.table-footer').before(grn.template(e, row_count, item.id, '', item.name, item.attributes, qty, price, item.stock, item.mrp_value, item.brand));
        $(config.row_count).val(row_count);
        grn.updateSerials(config);
        grn.update(config);
        element.focus(config.table + ' input', validation.focus);
        element.key_up(config.table + ' input', validation.focus);
        $('#grn_product_ac').focus();
    },
    remove:function (e) {
        $(e).parents('tr').remove();
        grn.update(config.grn);
        grn.updateSerials(config.grn);
    },
    updateSerials:function (config) {
        var length = $(config.table).find('tr').length;
        $(config.table).find('tr').each(function (index) {
            if (index != 0 || index != length) {
                $(this).find('.product-sno').html(index);
            }
        });
    },
    update:function (config) {
        var quantity, price, total, grn_total = 0;
        var length = $(config.table).find('tr').length;
        $(config.table).find('tr').each(function (index) {
            if ($(this).attr('class') == 'table-footer') {
                return false;
            }
            if (index != 0) {
                total = 0;
                quantity = $(this).find('input[name*=quantity]').val();
                price = $(this).find('input[name*=price]').val();
                quantity = !isNaN(quantity) ? quantity : 0;
                price = !isNaN(price) ? price : 0;
                total = price * quantity;
                grn_total += total;
                total = total.toFixed(2);
                $(this).find('.product-total').html(total);
            }
        });
        grn_total = grn_total.toFixed(2);
        $(config.table).find('#grn_sub_total').html(grn_total);
    },
    removeAttribute:function (e) {
        $(e).parents('.table-attribute').remove();
    },
    emptyTable:function (config) {
        $(config.table).find('tr').each(function (index) {
            if ($(this).attr('class') == 'table-footer') {
                return false;
            }
            if (index != 0) {
                $(this).remove();
            }
        });
        grn.update(config);
    },
    template:function (entry, row_count, id, sno, name, attributes, qty, price, stock, mrpValue, brandName) {
        var ids = '25_' + id + '_' + row_count;
        qty = (typeof(qty) != 'undefined') ? qty : '';
        price = (typeof(price) != 'undefined') ? price : '';
        stock = (typeof(stock) != 'undefined' && stock != null) ? stock : 0;
        mrpValue = (typeof(mrpValue) != 'undefined' && mrpValue != null) ? mrpValue : 0;
        stock = parseFloat(stock).toFixed(3);
        mrpValue = parseFloat(mrpValue).toFixed(2);
        var total = (isNaN(qty) || isNaN(price)) ? 0 : qty * price;
        total = total.toFixed(2);
        if (typeof(attributes) == 'undefined' || (typeof(attributes) != 'array' && typeof(attributes) != 'object')) {
            attributes = new Array();
        }
        var html = '<tr>';
        html += '<td class="span1 text-right product-sno">' + sno + '</td>';
        html += '<td class="span2">' + name + '<input type="hidden" name="name_' + ids + '" value="' + name + '" /><input type="hidden" name="item_id[]" value="' + ids + '" /></td>';
        html += '<td class="span2">' + brandName + '</td>';
        html += '<td>';
        var count = attributes.length;
        var name = '';
        var display_name = '';
        var value = '';
        var input_class = 'input-mini';
        var read_only = '';
        var click_action = '';
        var type = '0';
        for (var i in attributes) {
            display_name = typeof(attributes[i].display_name) != 'undefined' && attributes[i].display_name != null ? attributes[i].display_name : attributes[i].name;
            name = display_name == 'MRP' ? 'price' : attributes[i].name;
            /*if (entry == '' && typeof(attributes[i].sku) != 'undefined' && attributes[i].sku.toString() == '1') {
             continue;
             }*/
            value = typeof(attributes[i].value) != 'undefined' ? attributes[i].value : '';
            if (entry != '' && attributes[i].sku.toString() == '1') {
                //value = '';
            }
            if(attributes[i].name == 'mfg_barcode') {
                input_class = 'input-medium';
            }
            if (typeof(attributes[i].sku) != 'undefined' && attributes[i].sku.toString() == '0') {
                read_only = ' readonly ';
                input_class += ' required';
                click_action = '';
                type = '1';
            } else {
                read_only = '';
                input_class += ' required';
                click_action = 'grn.removeAttribute(this)';
                type = '0';
            }
            html += '<div class="input-prepend input-append table-attribute">';
            html += '<span class="add-on">' + display_name + '</span>';
            html += '<input type="hidden" name="attribute_id_' + ids + '[]" value="' + attributes[i].id + '"/>';
            html += '<input type="text" class="' + input_class + '" name="attribute_value_' + ids + '_' + attributes[i].id + '" value="' + value + '"  ' + read_only + '/>';
            html += '<input type="hidden" name="attribute_name_' + ids + '_' + attributes[i].id + '" value="' + name + '" />';
            html += '<input type="hidden" name="attribute_display_name_' + ids + '_' + attributes[i].id + '" value="' + display_name + '" />';
            html += '<input type="hidden" name="attribute_level_' + ids + '_' + attributes[i].id + '" value="' + attributes[i].level + '" />';
            html += '<input type="hidden" class="input-mini" name="attribute_type_' + ids + '_' + attributes[i].id + '" value="' + type + '" />';
            html += '<span class="add-on search-image" onclick="' + click_action + '"><i class="icon-trash"></i></span>';
            html += '</div>';
        }
        html += '</td>';
        html += '<td class="text-right cursor-hand" onclick="stock.showStockPopup(' + id + ')">' + mrpValue + ' [' + stock + ']' + '</td> ';
        html += '<td class="span1"><input type="text" min="0" name="quantity_' + ids + '" class="input-mini text-right required" autocomplete="off" value="' + qty + '" onkeyup="grn.update(config.grn)"/></td>';
        html += '<td class="span1"><input type="text" min="0"  name="price_' + ids + '" class="input-mini text-right required" autocomplete="off" value="' + price + '" onkeyup="grn.update(config.grn)" /></td>';
        html += '<td class="span1 text-right product-total">' + total + '</td>';
        html += '<td style="width: 20px"><button onclick="grn.remove(this)" class="btn btn-danger action-button" type="button">';
        html += '<i class="icon-trash icon-white"></i>';
        html += '</button></td>';
        html += '</tr>';
        return html;
    },
    submit:function (form) {
        //var po_id = $(config.grn.po_id_hidden).val().trim();
        var vendor_id = $(config.grn.vendor_id).val().trim();
        var total_rows = app.getTotalRows(config.grn.table);
        /*if (po_id == '') {
         notification.push({
         message:'Purchase Order Id is required to genearate GRN',
         alertType:'error'
         });
         } else*/
        if (vendor_id == '') {
            notification.push({
                message:'Select Vendor to continue',
                alertType:'error'
            });
        } else if (total_rows <= 0) {
            notification.push({
                message:'Add at least one product to GRN',
                alertType:'error'
            });
        } else {
            form.submit();
        }
    }
}

var opening_stock = {
    productBarcode:function (e) {
        if (e.keyCode == 38 || e.keyCode == 40) {
            return false;
        }
        var barcode = e.currentTarget.value;
        if (isNaN(barcode.charAt(0))) {
            $('#product_ac').autocomplete('enable');
        } else {
            $('#product_ac').autocomplete('disable');
            if (e.keyCode == 13 && barcode.length != 0) {
                $.fancybox.showActivity();
                $.ajax({
                    url:site_url + '/product_sku/get_by_barcode/' + barcode + '?sku=0',
                    method:'POST',
                    datatype:'JSON',
                    data:{
                        stock:1
                    },
                    success:function (data) {
                         console.log('here');
                        console.log(data);
                        data = jQuery.parseJSON(data);

                        ui = {};
                        ui.item = data.header;
                        opening_stock.add('', ui, config.opening_stock);
                        $('#product_ac').val('');
                        $('#product_ac').focus();
                    },
                    complete:function (xhr, status) {
                        $.fancybox.hideActivity();
                    },
                    statusCode:{
                        404:function () {
                            alert("page not found");
                        },
                        500:function () {
                            alert("Database Error occured");
                        }
                    }
                });
            }
        }
    },
    add:function (e, ui, config) {
        var item = ui.item;
        var row_count = parseInt($(config.row_count).val()) + 1;
        var qty = '';
        var price = '';
        $(config.table).append(opening_stock.template(e, row_count, item.id, '', item.name, item.attributes, qty, price, item.stock, item.mrp_value));
        $(config.row_count).val(row_count);
        purchaseOrder.updateSerials(config);
        purchaseOrder.update(config);
        element.focus(config.table + ' input', validation.focus);
        element.key_up(config.table + ' input', validation.focus);
    },
    template:function (entry, row_count, id, sno, name, attributes, qty, price, stock, mrpValue) {
        var ids = '25_' + id + '_' + row_count;
        qty = (typeof(qty) != 'undefined') ? qty : '';
        stock = (typeof(stock) != 'undefined' && stock != null) ? stock : 0;
        mrpValue = (typeof(mrpValue) != 'undefined' && mrpValue != null) ? mrpValue : 0;
        price = (typeof(price) != 'undefined') ? price : '';
        stock = parseFloat(stock).toFixed(3);
        mrpValue = parseFloat(mrpValue).toFixed(2);
        var total = (isNaN(qty) || isNaN(price)) ? 0 : qty * price;
        total = total.toFixed(2);
        if (typeof(attributes) == 'undefined' || (typeof(attributes) != 'array' && typeof(attributes) != 'object')) {
            attributes = new Array();
        }
        var html = '<tr>';
        html += '<td class="text-right product-sno">' + sno + '</td>';
        html += '<td width="25%">' + name + '<input type="hidden" name="name_' + ids + '" value="' + name + '" /><input type="hidden" name="item_id[]" value="' + ids + '" /></td>';
        html += '<td width="75%">';
        var count = attributes.length;
        var name = '';
        var value = '';
        var input_class = '';
        var read_only = '';
        var click_action = '';
        var type = '0';
        for (var i = 0; i < count; i++) {
            name = typeof(attributes[i].display_name) != 'undefined' && attributes[i].display_name != null ? attributes[i].display_name : attributes[i].name;
            var sku = typeof(attributes[i].sku) != 'undefined' ? attributes[i].sku.toString() : '0';
            if (sku === '0') {
                value = typeof(attributes[i].value) != 'undefined' ? attributes[i].value : '';
                read_only = ' readonly ';
                input_class = 'input-mini';
                click_action = '';
                type = '1';
            } else {
                value = '';
                read_only = '';
                input_class = 'input-mini required';
                click_action = 'purchaseOrder.removeAttribute(this)';
                type = '0';
            }
            html += '<div class="input-prepend input-append table-attribute">';
            html += '<span class="add-on">' + name + '</span>';
            html += '<input type="hidden" name="attribute_id_' + ids + '[]" value="' + attributes[i].id + '"/>';
            html += '<input type="text" class="' + input_class + '" name="attribute_value_' + ids + '_' + attributes[i].id + '" value="' + value + '"  ' + read_only + '/>';
            html += '<input type="hidden" class="input-mini" name="attribute_name_' + ids + '_' + attributes[i].id + '" value="' + attributes[i].name + '" />';
            html += '<input type="hidden" class="input-mini" name="attribute_display_name_' + ids + '_' + attributes[i].id + '" value="' + name + '" />';
            html += '<input type="hidden" class="input-mini" name="attribute_type_' + ids + '_' + attributes[i].id + '" value="' + type + '" />';
            html += '<input type="hidden" name="attribute_level_' + ids + '_' + attributes[i].id + '" value="' + attributes[i].level + '" />';
            html += '<span class="add-on search-image" onclick="' + click_action + '"><i class="icon-trash"></i></span>';
            html += '</div>';
        }
        html += '</td>';
        html += '<td class="text-right cursor-hand" onclick="stock.showStockPopup(' + id + ')">' + mrpValue + ' [' + stock + ']' + '</td> ';
        html += '<td><input type="text" name="quantity_' + ids + '" class="input-mini text-right required number" autocomplete="off" value="' + qty + '" /></td>';
        //html += '<td><input type="text" name="price_' + ids + '" class="input-mini text-right required number" min="0" autocomplete="off" value="' + price + '" onkeyup="purchaseOrder.update(config.po)" /></td>';
        //html += '<td class="text-right product-total">' + total + '</td>';
        html += '<td><button onclick="opening_stock.remove(this)" class="btn btn-danger action-button" type="button">';
        html += '<i class="icon-trash icon-white"></i>';
        html += '</button></td>';
        html += '/tr>';
        return html;
    },
    remove:function (e) {
        $(e).parents('tr').remove();
        //purchaseOrder.update(config.po);
        purchaseOrder.updateSerials(config.opening_stock);
    },
    submit:function (form) {
        var row_count = $(config.grn.row_count).val().trim();
        if (row_count <= 0 || row_count == '') {
            $('#product_ac').focus();
            /*notification.push({
             message:'Atleast Select One Product to Opening Stock',
             messageType:'sticky',
             alertType:'error'
             });*/
            return false;
        }
        return true;
    },
    success:function (data) {
        grn.emptyTable(config.opening_stock);
        $('.hide-this').toggle();
        var products = typeof(data.selected_products) != 'undefined' ? data.selected_products : [];
        var product = null;
        var html = '';
        var s = 1;
        for (var i in products) {
            product = products[i];
            html += opening_stock.print_template({
                sno:s,
                name:product.name,
                attributes:product.attributes,
                qty:product.quantity,
                barcode:product.barcode
            });
            s++;
        }
        $(config.opening_stock.table).append(html);
        element.click('.print-single-barcode', BIZ.app.printBarcode);
    },
    print_template:function (params) {
        var html = '';
        html += '<tr>';
        html += '<td>' + params.sno + '</td>';
        html += '<td width="25%">' + params.name + '</td>';
        html += '<td width="75%">';
        var attributes = params.attributes;
        var mrp = 0;
        //var count = attributes.length();
        for (var i in attributes) {
            if (i != 0) {
                html += ', ';
            }
            if(attributes[i].name == 'price') {
                mrp = parseFloat(attributes[i].value);
            }
            html += attributes[i]['display_name'] + ': ';
            html += attributes[i]['value'];
        }
        html += '</td>';
        html += '<td>' + params.qty + '</td>';
        html += '<td><button type="button" class="btn action-button btn-primary print-single-barcode" b-name="'+params.name+'" b-code="'+params.barcode+'" b-type="1" b-mrp="'+mrp.toFixed(2)+'">C</button></td>';
        html += '<td><button type="button" class="btn action-button btn-primary print-single-barcode" b-name="'+params.name+'" b-code="'+params.barcode+'" b-type="2" b-mrp="'+mrp.toFixed(2)+'">J</button></td>';
        html += '</tr>';
        return html;
    }
}

INVOICE = {};
INVOICE.products = [];
INVOICE.product = function (config) {
    this.e_id = 26;
    this.s_id = config.id;
    this.name = config.name;
    this.className = config.className;
    this.quantity = parseFloat(config.quantity);
    this.rate = parseFloat(config.rate);
    this.vatPercentage = parseFloat(config.vatPercentage);
    this.discountPercentage = parseFloat(config.discountPercentage);
}
var invoice = {
    addShortCut: function() {
        var btn = $('.shortcut');
        shortcut.add("Ctrl+P",function() {
            btn.eq(4).trigger('click');
        });

        shortcut.add("Ctrl+I",function() {
            btn.eq(3).trigger('click');
        });

        shortcut.add("Ctrl+C",function() {
            btn.eq(2).trigger('click');
        });

        shortcut.add("Ctrl+E",function() {
            btn.eq(1).trigger('click');
        });

        shortcut.add("Ctrl+R",function() {
            btn.eq(0).trigger('click');
        });        
    },

    addMoreShortCuts: function() {
        shortcut.add("Ctrl+P",function() {
            $('#print').trigger('click');
        });

        shortcut.add("Ctrl+I",function() {
            location.assign($('#invoice').attr('href'));
        });
    },

    highlightRemoveButton:function (e) {
        $(e.currentTarget).find('.customer-remove-button').addClass('icon-remove');
    },
    unhighlightRemoveButton:function (e) {
        $(e.currentTarget).find('.customer-remove-button').removeClass('icon-remove');
    },
    resetForm:function (e) {
        $('#customer_ac_div').removeClass('hide');
        $('#customer_details').addClass('hide');
        $(config.invoice.customer_id).val('');
        $('#customer_ac').val('');
        //$('#product_ac').attr('disabled', 'disabled');

        $(config.invoice.table).find('tr').each(function (index) {
            if ($(this).attr('class') == 'table-footer') {
                return false;
            }
            if (index != 0) {
                $(this).remove();
            }
        });
        $(config.invoice.row_count).val(0);

        $('#payment_block').find('tr').each(function (index) {
            if ($(this).attr('class') == 'table-footer') {
                return false;
            }
            $(this).remove();
        });

        $(config.invoice.table).find('#invoice_sub_total').html('0.00');
        $(config.invoice.table).find('#invoice_vat_amount').html('0.00');
        $(config.invoice.table).find('#invoice_total_amount').html('0.00');
        $(config.invoice.table).find('#total_quantity').html('0');
        $('#payment_block input[name=invoice_cash_amt]').val('');

        var html =
            '<tr>' +
                '<td colspan="4">Cash</td>' +
                '<td class="span1"><input type="text" name="invoice_cash_amt" autocomplete="off" class="input-mini required invoice-amount number text-right" min="0" placeholder="Amount" paytype="cash"/></td>' +
                '<td style="width: 20px">' +
                '<a class="btn btn-danger action-btn invoice-remove-btn" href="#" onclick="payment.removeRow(this)"><i class="icon-trash icon-white"></i></a>' +
                '</td>' +
                '</tr>';
        $('#payment_block').find('.table-footer').before(html);
        payment.total();
        element.focus('.invoice input', validation.focus);
        element.key_up('.invoice input', validation.focus);
    },
    productAutocomplete:function (e, ui, config) {
        $.fancybox.showActivity();
        $.ajax({
            type:'GET',
            url:site_url + '/product_sku/get_by_header/'+ ui.item.id,
            data:{
                ajax:1,
                stock:1
            },
            datatype:'json',
            success:function (data) {
                data = jQuery.parseJSON(data);
                console.log('in autocomplete');
                console.log(data);
                invoice.selectProduct(data);
            },
            complete:function (jqXHR, textStatus) {
                $.fancybox.hideActivity();
            },
            statusCode:{
                404:function () {
                    alert("page not found");
                },
                500:function () {
                    alert("Database Error occured");
                }
            }
        });
    },
    productBarcode:function (e) {
        
        if (e.keyCode == 38 || e.keyCode == 40) {
            return false;
        }
        var barcode = e.currentTarget.value.trim();
        if (isNaN(barcode.charAt(0))) {            
            $('#product_ac').autocomplete('enable');
        } else {
            $('#product_ac').autocomplete('disable');
            if (e.keyCode == 13 && barcode.length != 0) {
                $.fancybox.showActivity();
                $.ajax({
                    url:site_url + '/product_sku/get_by_barcode/'+ barcode,
                    method:'POST',
                    datatype:'JSON',
                    data:{
                        stock:1
                    },
                    success:function (data) {                        
                        data = jQuery.parseJSON(data);
                        console.log('in barcode');                    
                        invoice.selectProduct(data);                        
                        $('#product_ac').val('');
                        $('#product_ac').focus();
                    },
                    complete:function (xhr, status) {
                        $.fancybox.hideActivity();
                    },
                    statusCode:{
                        404:function () {
                            alert("page not found");
                        },
                        500:function () {
                            alert("Database Error occured");
                        }
                    }
                });
            }
        }       
        
    },

    showLatestBills: function(e) {
        console.log('hehe');
        $.fancybox.showActivity();
                $.ajax({
                    url:site_url + '/invoice/latest_invoices/',
                    method:'POST',                    
                    success:function (data) {                                                
                       $('#search_show_invoice').html(data);
                    },
                    complete:function (xhr, status) {
                        $.fancybox.hideActivity();
                    },
                    statusCode:{
                        404:function () {
                            alert("page not found");
                        },
                        500:function () {
                            alert("Database Error occured");
                        }
                    }
                });
    },

    selectProduct:function (data) {
        var sku = typeof(data.sku) != 'undefined' ? data.sku : Array();
        if (sku.length == 0) {
            notification.push({
                message: data.header.name +' is not available in Stock',
                alertType:'info',
                messageType:'sticky'
            });
        } else if (sku.length == 1) {
            var name = typeof(data.header) != 'undefined' ? data.header.name : data.sku[0].name;
            var brand = typeof(data.header) != 'undefined' ? data.header.brand : data.sku[0].brand;
            var vat_percentage = typeof(data.header) != 'undefined' ? data.header.vat_percentage : data.sku[0].vat_percentage;
            if (data.sku[0].stock == null || data.sku[0].stock <= 0) {
                notification.push({
                    message: data.sku[0].name+' is not available in Stock',
                    alertType:'info',
                    messageType:'sticky'
                });
            } else {
                var price = typeof(data.sku[0].price) != 'undefined' ? data.sku[0].price : data.header.attributes.price;
                /*
                console.log({
                    id:data.sku[0].id,
                    name:name,
                    brand:brand,
                    qty:1,
                    stock:data.sku[0].stock,
                    price:price,
                    discount:0.00,
                    vat:vat_percentage
                });
                */
                invoice.addProduct({
                    id:data.sku[0].id,
                    name:name,
                    brand:brand,
                    qty:1,
                    stock:data.sku[0].stock,
                    price:price,
                    discount:0.00,
                    extratax:0.00,
                    vat:vat_percentage
                });
            }
        } else if (sku.length > 1) {
            invoice.showPopup(data, config);
        }
    },

    totalQuantity: function() {
        var quantity = 0;
        $(config.invoice.table).find('input.quantity').each(function(index, value) {
            quantity += parseInt($(value).val(), 10);
        });
        return quantity;
    },

    addProduct:function (data) {

        var rowCount = parseInt($(config.invoice.row_count).val()) + 1;
        if (!invoice.isItemAdded(data.id)) {
            data.rowCount = rowCount;
            var html = invoice.template(data);
            $(config.invoice.table).find('.table-header').after(html);
            var quantity = invoice.totalQuantity();
            $('#total_quantity').html(quantity);
            $(config.invoice.row_count).val(rowCount);
            grn.updateSerials(config.invoice);
            element.key_up(config.invoice.table + ' input', validation.focus);
            element.focus(config.invoice.table + ' input', validation.focus);
            $('#product_ac').focus();
        }
        invoice.update();
    },

    update:function () {

        var quantity, new_quantity, price, discount, vat, total, sub_total = 0, vat_amount = 0, total_without_vat = 0;
        var length = $(config.invoice.table).find('tr').length;
        $(config.invoice.table).find('tr').each(function (index) {
            if ($(this).attr('class') == 'table-footer') {
                return false;
            }
            if (index != 0) {
                total = 0;
                quantity = $(this).find('input[name*=quantity]').val();
                price = $(this).find('input[name*=price]').val();
                discount = $(this).find('input[name*=discount]').val();
                vat = $(this).find('input[name*=vat_percentage]').val();


                quantity = !isNaN(quantity) ? quantity : 0;
                price = !isNaN(price) ? price : 0;
                discount = !isNaN(discount) ? discount : 0;
                vat = !isNaN(vat) ? parseFloat(vat) : 0;

                total = price * quantity;
                total = total - (total * discount / 100);

                sub_total += total;
                
                
                total_without_vat = (total * 100) / ( 100 + vat ) 
                vat_amount +=  (total - total_without_vat);

                total = total.toFixed(2);
                $(this).find('.product-total').html(total);
            }
        });
        sub_total = sub_total.toFixed(2);
        vat_amount = vat_amount.toFixed(2);
        new_quantity  = invoice.totalQuantity();               
        var bill_total = parseFloat(sub_total) + parseFloat(vat_amount);
        bill_total = bill_total.toFixed(2);
        $(config.invoice.table).find('#invoice_sub_total').html(sub_total);
        $(config.invoice.table).find('#invoice_vat_amount').html(vat_amount);
        $(config.invoice.table).find('#invoice_total_amount').html(sub_total);
        $(config.invoice.table).find('#total_quantity').html(new_quantity);
        $('#payment_block input[name=invoice_cash_amt]').val(sub_total);
        $('#payment_block input[name=invoice_cash_amt]').show();
        //console.log(sub_total);
        //console.log('here');
        payment.total();
    },

    updateTax:function (data) {
        
        //var price = $('#price_' + data).attr('value');
        //$('#price_' + data).attr('value' , price/2);
        var vat = $('#original_vat_' + data).attr('value');
        var extratax = $('#extratax_' + data).attr('value');
        if(extratax=='')
        {
            console.log("abc");
            console.log(vat);
            $('#vat_percentage_' + data).attr('value' , vat );
        }
        else
        {
            vat = parseFloat(vat);
            extratax = parseFloat(extratax);
            finaltax = vat + extratax;
            console.log(finaltax);
            $('#vat_percentage_' + data).attr('value' , finaltax );
            var price = $('#original_price_' + data).attr('value');
            price = parseFloat(price);
            console.log(price);
            vat = vat/100;
            var original = price/(1+vat);
            price = price + (extratax*original/100);
            $('#price_' + data).attr('value', price);
        }
        invoice.update();
    },

    template:function (params) {

        
        var ids = '26_' + params.id + '_' + params.rowCount;
        var total = params.qty * params.price;
        params.price = parseFloat(params.price).toFixed(2);
        total = total - total * params.discount / 100;
        total = total.toFixed(2);
        var html = '<tr>';
        html += '<td class="span1 text-right product-sno"></td>';

        html += '<td>' + params.name;
        html += '<input type="hidden" value="' + params.name + '" name="name_' + ids + '" id="id_' + params.id + '">';
        html += '<input type="hidden" value="' + ids + '" name="item_id[]">';
        html += '<input type="hidden" value="' + params.vat + '" name="vat_percentage_' + ids + '" id="vat_percentage_' + params.id + '">';
        html += '<input type="hidden" value="' + params.vat + '" id="original_vat_' + params.id + '" />';
        html += '</td>';

        html += '<td>' + params.brand + '</td>';
        html += '<td><input type="text" onkeyup="invoice.update(config.invoice)" value="' + params.qty + '" autocomplete="off" min="0" max="' + params.stock + '" class="quantity input-mini text-right required" name="quantity_' + ids + '"></td>';
        html += '<input type="hidden" value="' + params.price + '" id="original_price_' + params.id + '" />';
        html += '<td><input readonly type="text" onkeyup="invoice.update(config.invoice)" value="' + params.price + '" autocomplete="off" min="0" class="input-mini text-right" name="price_' + ids + '" id="price_' + params.id + '"></td>';
        html += '<td><input type="text" onkeyup="invoice.update(config.invoice)" value="' + params.discount + '" autocomplete="off" min="0" max="100" class="input-mini text-right required number" name="discount_' + ids + '"></td>';
        html += '<td class="text-right product-total">' + total + '</td>';
        html += '<td><input type="text" onkeyup="invoice.updateTax('+params.id+')" value="' + params.extratax + '" autocomplete="off" min="0" max="100" class="input-mini text-right required number" name="extratax_' + ids + '" id="extratax_' + params.id + '"/></td>';
        html += '<td><button type="button" class="btn btn-danger action-button" onclick="invoice.remove(this)"><i class="icon-trash icon-white"></i></button></td>';
       
        html += '</tr>';
        return html;
    },

    selectCustomer:function (e, ui, config) {
        $(config.customer_id).val(ui.item.id);
        var c = ui.item.customer;
        $('#customer_details span').html(customer.template(c.fname + ' ' + c.lname, c.building, c.street, c.city, c.pin, c.phone));
        invoice.loadFromCart(e, ui, config);
        $('#customer_ac_div').addClass('hide');
        $('#customer_details').removeClass('hide');
        $('#product_ac').removeAttr('disabled');
    },
    saveToCart:function (url) {
        if ($(config.invoice.form_id).valid()) {
            $.fancybox.showActivity();
            $.ajax({
                url:url,
                method:'POST',
                data:$(config.invoice.form_id).serializeArray(),
                datatype:'JSON',
                success:function (data) {
                    data = jQuery.parseJSON(data);
                    validation.showMessage(data);
                },
                complete:function (jXHR, textstatus) {
                    $.fancybox.hideActivity();
                },
                statusCode:{
                    404:function () {
                        alert("page not found");
                    },
                    500:function () {
                        alert("Database Error occured");
                    }
                }
            });
        } else {
            //TODO search for firing validation
        }
    },
    loadFromCart:function (e, ui, config) {
        $.fancybox.showActivity();
        $.ajax({
            url:site_url + '/invoice/load_cart/' + ui.item.id,
            method:'POST',
            datatype:'JSON',
            success:function (data) {
                data = jQuery.parseJSON(data);
                if (typeof(data.items) != 'undefined') {
                    for (var i in data.items) {
                        var item = data.items[i];
                        if (item.stock == null || item.stock <= 0) {
                            notification.push({
                                message:'Product is not available in Stock',
                                alertType:'info',
                                messageType:'sticky'
                            });
                        } else {
                            invoice.addProduct({
                                id:item.item_specific_id,
                                name:item.name,
                                brand:item.brand,
                                qty:item.quantity,
                                stock:item.stock,
                                price:item.price,
                                discount:item.discount,
                                vat:item.vat_percentage
                            });
                        }
                    }
                }
            },
            complete:function (xhr, status) {
                $.fancybox.hideActivity();
            },
            statusCode:{
                404:function () {
                    alert("page not found");
                },
                500:function () {
                    alert("Database Error occured");
                }
            }
        });
    },
    showPopup:function (data) {
        var name = typeof(data.header.name) != 'undefined' ? data.header.name : '';
        var html = '<div class="content-header"><h3>' + name + '</h3></div>';
        html += '<div id="popup-responce" class="hide">' + JSON.stringify(data) + '</div>';
        for (i in data.sku) {
            html += invoice.popupTemplate(data.sku[i], i);
        }
        $('#popup').html(html);
        $('#popup-trigger').trigger('click');
    },
    popupTemplate:function (data, no) {
        var attributes = data.attributes;
        var count = 0;
        var html = '<div class="popup-item block" onclick="invoice.popupSelectProduct(' + no + ')">';
        for (var i in attributes) {
            if (count % 2 == 0) {
                html += '<div>';
            }
            attributeName = typeof (attributes[i]['display_name']) != 'undefined' && attributes[i]['display_name'] != null ? attributes[i]['display_name'] : attributes[i]['name'];
            attributeValue = attributes[i]['value'];
            html += '<span class="span1">' + attributeName + ':</span>';
            html += '<span class="span1">' + attributeValue + '</span>';
            if (count % 2 == 1) {
                html += '</div>';
            }
            count++;
        }
        if (count % 2 == 1) {
            html += '</div>';
        }
        html += '</div>';
        return html;
    },
    popupSelectProduct:function (no) {
        var data = $('#popup-responce').html();
        data = jQuery.parseJSON(data);
        $.fancybox.close();
        if (data.sku[no].stock == null || data.sku[no].stock <= 0) {
            notification.push({
                message:data.sku[no]['name']+' is not available in Stock',
                alertType:'info',
                messageType:'sticky'
            });
        } else {
            invoice.addProduct({
                id:data.sku[no].id,
                name:data.header.name,
                brand:data.header.brand,
                qty:1,
                stock:data.sku[no].stock,
                price:data.sku[no].price,
                discount:0.00,
                extratax:0.00,
                vat:data.header.vat_percentage
            });
        }
    },    
    
    isItemAdded:function (id) {
        var ids = $(config.invoice.table).find('input[name*=item_id]');
        var status = false;
        $(ids).each(function (index) {
            var c_id = $(this).val();
            var c_array = c_id.split('_');
            var sku_id = c_array[1];
            if (sku_id == id) {
                var qty = $(config.invoice.table).find('input[name=quantity_' + c_id + ']').val();
                qty = parseInt(qty);
                qty++;
                $(config.invoice.table).find('input[name=quantity_' + c_id + ']').val(qty);
                status = true;
                return false;
            }
        });
        return status;
    },
    remove:function (e) {
        $(e).parents('tr').remove();
        invoice.update();
        grn.updateSerials(config.invoice);
    },
    
    validate:function (form) {
        var btn_name = $('#invoice_button_type').val();
        if (btn_name == 'estimate' || btn_name == 'cart') {
            form.submit();
        } else if (btn_name == 'invoice') {
            var total = parseFloat($('#invoice_total_amount').html());
            var payment_total = payment.total();
            if (payment_total >= total) {
                form.submit();
            } else {
                notification.push({
                    message:'Please review your payment',
                    alertType:'error'
                });
            }
        }
    },
    companyTemplate:function () {
        var html = '<div class="company-header">';
        html += '<h4>New Shringar Fancy Centre</h4>';
        html += '<span>#19, 9th Main Road</span>';
        html += '<span>3rd Block Jayanagar</span>';
        html += '<span>Bangalore 560011</span>';
        html += '<span>Ph 26634568 / 26645570</span>';
        html += '<span>Web site: www.shringargroup.com</span>';
        html += '<span>Email: shringargroup@gmail.com</span>';
        html += '<span>VAT TIN: 29720210785</span>';
        html += '</div>';
        return html;
    },
    printCart:function (url) {
        var name, quantity, price, discount, vat, total, sub_total = 0, vat_amount = 0;
        var html = '<div class="block mini-receipt">';
        html += invoice.companyTemplate();
        html += '<br><h4>ESTIMATE</h4>';
        html += '<table class="table-mini-receipt">';
        html += '<tr><th width="100%" style="text-align: left">Product</th><th>Price</th><th>Qty.</th><th>Disc.</th><th>Amount</th></tr>';

        $(config.invoice.table).find('tr').each(function (index) {
            if ($(this).attr('class') == 'table-footer') {
                return false;
            }
            if (index != 0) {
                total = 0;
                name = $(this).find('input[name*=name]').val();
                quantity = $(this).find('input[name*=quantity]').val();
                price = $(this).find('input[name*=price]').val();
                discount = $(this).find('input[name*=discount]').val();
                vat = $(this).find('input[name*=vat_percentage]').val();

                quantity = !isNaN(quantity) ? quantity : 0;
                price = !isNaN(price) ? price : 0;
                discount = !isNaN(discount) ? discount : 0;
                vat = !isNaN(vat) ? vat : 0;

                total = price * quantity;
                total = total - (total * discount / 100);

                sub_total += total;
                vat_amount += total * vat / 100;

                total = total.toFixed(2);

                html += '<tr>';
                //html += '<td class="text-right">' + index + '</td>';
                html += '<td class="">' + name + '</td>';
                html += '<td class="text-right">' + price + '</td>';
                html += '<td class="text-right">' + quantity + '</td>';
                html += '<td class="text-right">' + discount + '</td>';
                html += '<td class="text-right">' + total + '</td>';
                html += '</tr>';
            }
        });
        sub_total = sub_total.toFixed(2);
        vat_amount = vat_amount.toFixed(2);
        var bill_total = parseFloat(sub_total) + parseFloat(vat_amount);
        bill_total = bill_total.toFixed(2);
        html += '<tr class="table-bottem">';
        html += '<th class="text-right" colspan="3">Total</th>';
        html += '<th>&nbsp;</th>';
        html += '<th class="text-right">' + sub_total + '</th>';
        html += '</tr>';
        html += '</table> ';
        html += '</div> ';
        $('#print-area').html(html);
        window.print();
    },
    submit:function (e) {
        var customer_id = $(config.invoice.customer_id).val();
        if (customer_id == '') {
            notification.push({
                message:'Select Customer to proceed',
                alertType:'error'
            });
            return false;
        }
        var url = $(e).attr('url');
        var btn_name = $(e).attr('btnname');
        $('#invoice_button_type').val(btn_name);
        if (btn_name == 'estimate' || btn_name == 'cart') {
            var required_elements = $('#payment_block').find('.required');
            $(required_elements).each(function () {
                $(this).attr('temprequired', '1');
                $(this).removeClass('required');
                $(this).removeClass('validation-error');
            });
        } else if (btn_name == 'invoice') {
            var required_elements = $('#payment_block').find('input[temprequired]');
            $(required_elements).each(function () {
                $(this).addClass('required');
                $(this).removeAttr('temprequired');
            });
        }
        if (btn_name == 'cart' || btn_name == 'print') {
            if ($(config.invoice.form_id).valid()) {
                if (btn_name == 'cart') {
                    invoice.saveToCart(url);
                } else {
                    invoice.printCart(url);
                }
            } else {
                $(config.invoice.form_id).submit();
            }
        } else {
            $(config.invoice.form_id).attr('action', url);
            $(config.invoice.form_id).submit();
        }
    }
}

var customer = {
    addCustomer:function (e, ui, config) {

    },
    template:function (name, building, street, city, pin, phone) {
        var html = '<strong>' + name + '</strong><br>';
        if (building != '') {
            html += building + ', ';
        }
        if (street != '') {
            html += street + '<br>';
        }
        if (city != '') {
            html += city + ',&nbsp;' + pin + '<br>';
        }
        if (phone != '') {
            html += '<abbr title="Mobile">P:</abbr>' + phone;
        }
        return html;
    }
}

var components = {
    selectBrand:function (e, ui) {
        $('#add_product_brand_id').val(ui.item.id);
    },
    changeClass:function (e) {
        var id = e.target.value;
        $.get(
            '/index.php/category/get_attributes_by_class/' + id,
            {},
            function (data) {
                $('#add_product_attributes_table').append(data.html);
                $('#add_product_attributes_row_count').val(data.row_total);
            },
            'json'
        );
    },
    addSelect:function (e, ui) {
        if (!classes.isItemAdded('#add_component_class_attributes', '.attribute_name', '#add_component_attributes_table')) {
            var row_count = $('#add_component_attributes_row_count').val();
            //var template = components.template(ui.item.id, ui.item.name, ui.item.level, ++row_count);
            //$('#add_component_attributes_table').append(template);
            $('#add_component_attributes_row_count').val(row_count)
        } else {
            alert('Attribute is already Added');
        }
    },
    add:function (e) {
        var name = $('#add_component_class_attributes').val();
        var ui = [];
        ui['item'] = [];
        ui['item']['id'] = '';
        ui['item']['name'] = name;
        ui['item']['level'] = '';
        //components.addSelect('', ui);
    },
    removeAttributes:function removeAttributes(table_element, row_count) {
        $(table_element + ' tr').each(function (index) {
            if (index != 0) {
                $(this).remove();
            }
        });
        $(row_count).val('0');
    },
    template:function (id, name, level, row_count) {
        var html = '<tr>' +
            '<td><input class="required" type="hidden" name="attribute_row[]" value="' + row_count + '" />' +
            '<input type="hidden" value="' + id + '" name="attribute_id_' + row_count + '" />' +
            '<input class="required span2" type="text" value="' + name + '" name="attribute_name_' + row_count + '"  />' +

            '</td>' +
            '<td style="width: 20px"><button type="button" class="btn btn-danger action-button" onclick="$(this).parents(\'tr\').remove()"><i class="icon-trash icon-white"></i></button></td>' +
            '</tr>';

        return html;
    }
}
var rent_products = {
    addProduct:function (e) {
        //var row_count = $('#add_product_count').val();
        components.displayGrid();

        // $('#add_product_row_count').val(++row_count)
    },
    displayGrid:function (e, ui) {
    $('#add_product_name').attr('value', ui.item.name);
        if (!classes.isItemAdded('#add_product_name', '.attribute_name', '#add_product_table')) {
            var id = ui.item.name;
            if (id != '') {
                $.ajax({
                    type:'GET',
                    url:'/index.php/rent/displayProductDetailsById?name=' + id + '&json=1',
                    success:function (data) {
                        var data = JSON.parse(data);

                        if(data.data.components.length==0)
                        {
                            $('#add_product_table').append(data.view_output);
                            rent_products.updateTotal();
                        }
                        else
                        {
                            rent_products.showPopup(data.data.components, data.data.products.name);
                        }
                    }
                });
            }
        }

    },

    showPopup:function (data_com, data_pro) {
        var name = 'Components';
        var html = '<div class="content-header"><h3>' + name + '</h3></div>';
        html += '<form id="form1" class="form1" method="post">';
        html += '<div class="popup-item block>';
        html += '<table border="1">';
        html += '<input type="hidden" name="product_name" value="'+data_pro+'">';
        html += '<br><tr><td><span class="span1">';
        html += '<input type="checkbox" name="component" class="checkAll" id="checkAll" onclick="rent_products.checkAll(this)">';
        html += '</span>';
        html += '</td>';
        html += '</tr><br>';    
        $(data_com).each(function(i, val){
            html += '<br><tr>';
            html += '<td>';
            html += '<span class="span1">';
            html += '<input type="checkbox" name="component_name" class="component_name" value="'+val.name+'">';
            html += '</span>';
            html += '</td>';
            html += '<td>';
            html += '<span class="span1">';
            html += val.name;
            html += '</span>';
            html += '</td>'; 
            html += '</tr><br>';    
     
        }); 

        html += '<input type="button" class="btn btn-primary fancybox pull-right" id="vendor_add_btn" value="Add Components" onclick="rent_products.getComponent(this)" />';  

        html += '</table>';
        html += '</div></form>';  

        $('#popup').html(html);
        $('#popup-trigger').trigger('click');

    },
    checkAll:function(){
        if ($(".checkAll").is(':checked')) {
            $(".component_name").prop("checked", true);
        } else {
            $(".component_name").prop("checked", false);
        }
    },
    getComponent:function () {     
        var data = $('#form1').serializeArray();
        var $inputs = $('#form1 :input');
        var pro_name;
        var comp_name = [];

        $(data).each(function(i, val) {

            if(val.name == 'product_name')
                pro_name = val.value;
            if(val.name == 'component_name')
                comp_name.push(val.value);

        });

        if (pro_name != '') {
                $.ajax({
                    type:'GET',
                    url:'/index.php/rent/displayComponentDetailsById?name=' + pro_name +  '&component=' + comp_name +'&json=1',
                    success:function (data) {
                        var data = JSON.parse(data);
                        $('#add_product_table').append(data.view_output);
                        rent_products.updateTotal();
                    }
                });
            }


    },
    componentsData:function (id) {
        $('#product_attr_' + id).toggle();

    },
    updateTotal:function () {
        sum = 0;
        $(".requiredQuantity").each(function () {
            price = $(this).parent().next().children('.rentPrice').attr('value');
            individal = (($(this).val() * 1) * (price * 1));
            sum = parseInt(individal + sum);
            console.log(sum);
            days = $('#return_date').attr('value');
            total = parseInt(days) * sum;
        });
        $('#total_rent').attr('value', total);
        rent_products.updateBalance();
    },
    updatePrice:function () {
        sum = 0;
        $(".rentPrice").each(function () {
            originalPrice = parseInt($(this).parent().children(':eq(1)').attr('value'));
            if ($(this).val() < originalPrice) {
                alert("Rent price should be more than Rs:" + originalPrice);
                $(this).val(originalPrice);
                $(this).focus();
            }

            price = $(this).parent().prev().children('.requiredQuantity').attr('value');
            individal = (($(this).val() * 1) * (price * 1));
            sum = parseInt(individal + sum);
            days = $('#return_date').attr('value');
            total = parseInt(days) * sum;
        });
        $('#total_rent').attr('value', total);
    },
    updateBalance:function () {
        
        deposit = $('#advance_amount').attr('value'); 
        total = $('#total_rent').attr('value');
        balance = total - deposit;
        $('#balance_amount').attr('value', balance);
    },

    updateComponentPrice:function (i) {
        originalAmount = parseInt($(i).parents('tr').prev('tr').find('.rentPriceOrginal').attr('value'));
        if (!$(i).is(':checked')) {
            updatedAmount = originalAmount - parseInt($(i).parents('div').children(':eq(7)').attr('value'));
        }
        if ($(i).is(':checked')) {
            updatedAmount = originalAmount + parseInt($(i).parents('div').children(':eq(7)').attr('value'));
        }
        $(i).parents('tr').prev('tr').find('.rentPriceOrginal').attr('value', updatedAmount);
        $(i).parents('tr').prev('tr').find('.rentPrice').attr('value', updatedAmount);
        rent_products.updatePrice();
    },
    addComponent:function (i) {
        var id = $('#add_component_class_attributes').val();
        if (id != '') {
            $.ajax({
                type:'GET',
                url:'/index.php/rent/displayComponentById?name=' + id + '&json=1',
                success:function (data) {

                    $('#add_component_attributes_table').append(data);

                }
            });
        }
    },
    deleteComponent:function (i) {
        if (i != '') {
            $.ajax({
                type:'GET',
                url:'/index.php/rent/deleteComponentById?name=' + i + '&json=1',
                success:function (data) {

                    $(this).parents('tr').remove();

                }
            });
        }
    },
    updateNegotiationAmt:function () {
        sum = 0;
        $(".negotiatedPrice").each(function () {

            price = $(this).val();
            individal = (price * 1);
            sum = parseInt(individal + sum);

        });
        $('#negotiatedamt').attr('value', sum);
        rent_products.updateGrandTotal();
    },
    updateGrandTotal:function () {
        if ($('#negotiatedamt').val() != '') {
            total = parseInt($('#deposit').val()) - parseInt($('#negotiatedamt').val());
            $('#billtotal').attr('value', total);
        }
    },
    displayBooking:function () {
        bookingId = $('#bookingId').val();
        if (bookingId != '') {
            $.ajax({
                type:'GET',
                url:'/index.php/rent/displayBooking?id=' + bookingId + '&json=1',
                success:function (data) {

                    $('#bookingData').html(data);

                }
            });
        }
    },
    displayInvoice:function () {
        bookingId = $('#invoiceId').val();
        if (bookingId != '') {
            $.ajax({
                type:'GET',
                url:'/index.php/rent/displayInvoice?id=' + bookingId + '&json=1',
                success:function (data) {

                    $('#InvoiceData').html(data);

                }
            });
        }
    },
    selectCustomer:function (e, ui) {
        $('#customer_id').val(ui.item.id);
    },
    displayReports:function () {
        from = $('#from').val();
        to = $('#to').val();
        if (from != '' || to != '') {
            $.ajax({
                type:'GET',
                url:'/index.php/rent/displayReports?from=' + from + '&to=' + to + '&json=1',
                success:function (data) {

                    $('.report-table').html(data);

                }
            });
        }
    }

}

var payment = {
    changePaymentOptions:function (e, config) {
        var type = $('#payment_options').val();
        switch (type) {
            case 'cash':
            case 'card':
            case 'cheque':
            case 'loyalty':
                $('#payment_barcode').hide();
                $('#add_payment_btn').show();
                break;
            case 'bill':
            case 'advance':
            case 'scheme':
                $('#payment_barcode').show();
                $('#add_payment_btn').hide();
                break;
        }
    },
    addPaymentOption:function (e, config) {
        var type = $('#payment_options').val();
        payment.addPaymentRow(type, config);
        $("#payment_barcode").val('');
    },
    isAdded:function (type, config) {
        var o = $('#payment_block .invoice-amount');
        var found = 0;
        if (o.length == 0) {
            return false;
        }
        $(o).each(function () {
            if (found == 0 && type == $(this).attr('paytype')) {
                found = 1;
            }
        });
        if (found == 0) {
            return false;
        } else {
            notification.push({
                message:'Payment Option is Already Added',
                alertType:'error'
            });
            return true;
        }
    },
    total:function () {
        var total = 0;
        $('.invoice-amount').each(function () {
            var value = parseFloat($(this).val());
            value = isNaN(value) ? 0 : value;
            total += value;
        });
        $('#payment_total').html(total.toFixed(2));
        //console.log('in total');
        return total;
    },
    removeRow:function (e) {
        console.log('in remove row');
        $(e).parents('tr').remove();
        payment.total();
    },
    addPaymentRow:function (type, config) {
        var add = 1;
        var html = '<tr>';
        switch (type) {
            case 'cash' :
                if (!payment.isAdded(type)) {
                    html += '<td colspan="4">Cash</td>';
                    html += '<td class="span1"><input type="text" autocomplete="off" name="invoice_cash_amt" class="input-mini required invoice-amount number text-right" min="0" placeholder="Amount" paytype="cash" onclick="payment.total()"/></td>';
                } else {
                    add = 0;
                }
                break;
            case 'card':
                html += '<td colspan="1">Card</td>';
                html += '<td class="span1"><input type="text" name="invoice_card_last_digits[]" class="required input-mini" placeholder="4 XXXX"/></td>';
                html += '<td class="span2"><input type="text" name="invoice_card_bank_name[]" class="required input-medium" placeholder="Bank Name"/></td>';
                html += '<td class="span1"><input type="text" name="invoice_card_bank_approval[]" class="required input-small" placeholder="Approval Code" /></td>>';
                html += '<td class="span1"><input type="text" autocomplete="off" name="invoice_card_amt[]" class="input-mini required invoice-amount number text-right" min="0" placeholder="Amount" paytype="card" onclick="payment.total()"/></td>';

                break;
            case 'cheque':
                html += '<td colspan="2">Cheque</td>';
                html += '<td class="span2"><input type="text" name="invoice_cheque_bank_name[]" class="required input-medium" placeholder="Bank Name" /></td>>';
                html += '<td class="span1"><input type="text" name="invoice_cheque_no[]" class="required input-small" placeholder="Cheque No" /></td>>';
                html += '<td class="span1"><input type="text" autocomplete="off" name="invoice_cheque_amt[]" class="required invoice-amount number input-mini text-right" min="0" placeholder="Amount" paytype="cheque" onclick="payment.total()"/></td>';
                break;
            case 'bill':
                invoice.getOldPurchaseAmount(type, block);
                add = 0;
                break;
            case 'advance':
                if (!payment.isAdded(type, block)) {
                    invoice.getCustomerAdvanceAmount(type, block);
                    $('#invoice_product_barcode').attr('disabled', 'disabled');
                }
                add = 0;
                break;
            case 'scheme':
                invoice.getSchemeAmount(type, block);
                add = 0;
                break;
            case 'loyalty':
                if (!payment.isAdded(type)) {
                    payment.getLoyaltyAmount(type, config);
                }
                add = 0;
        }
        if (add == 1) {
            html += '<td style="width: 20px">';
            html += '<button class="btn btn-danger action-button invoice-remove-btn" onclick="payment.removeRow(this)"><i class="icon-trash icon-white"></i></button></td>';
            html += "</tr>";
            $('#payment_block .table-footer').before(html);
        }
        element.key_up('#payment_block .invoice-amount', payment.total);
        element.focus('#payment-block input', validation.focus);
        element.key_up('#payment-block input', validation.focus);
        payment.total();
    },

    getLoyaltyAmount:function (type, config) {
        var customer_id = $(config.customer_id).val();
        if (customer_id != '' && customer_id >= 0) {
            $.post(
                site_url + '/customer/get_loyalty_amount/' + customer_id,
                {
                    json:1
                },
                function (data, textstatus) {
                    if (textstatus == "success") {
                        data = jQuery.parseJSON(data);

                        var html = '<tr><td width="100%" colspan="4"><label>Loyalty Amount</label></td>';
                        html += '<td><input type="text" name="invoice_loyalty_amt" class="input-mini required number invoice-amount text-right" value="' + data + '" min="0" max="' + data + '" placeholder="Amount" paytype="loyalty" onclick="payment.total()"/></td>';
                        html += '<td><a class="btn btn-danger action-btn invoice-remove-btn" href="#" onclick="payment.removeRow(this)"><i class="icon-trash icon-white"></i></a></td>';
                        html += "</tr>";
                        $('#payment_block .table-footer').before(html);
                    }
                });
        } else {
            notification.push({
                message:'Select Customer before applying Loyalty points',
                alertType:'error'
            })
        }
    }
}

var stock = {
    filterReports: function() {
        var brand_id = $('#reports_brand_id').val();
        tabs.reload(site_url + '/inventory/display_detailed_stock/?ajax=1&brand_id=' + brand_id);
    },
    view:function (e, data) {
        var id = data.rslt.obj.attr("id");
        var href = $(data.rslt.e.currentTarget).attr("href");
        var element_id = typeof($(data.rslt.e.currentTarget).attr("id")) != 'undefined' ? $(data.rslt.e.currentTarget).attr("id") : '';

        if (element_id.search('stock_count') != -1) {
            tabs.reload(site_url + '/inventory/display_detailed_stock/' + id + '/26?tabs=1');
        } else {
            /*var child = $(data.rslt.e.currentTarget).siblings('ul');
             if (child.length > 0 && id != 0) {
             stock.showClasses(id);
             }*/
            stock.showStock(id);
        }
    },
    showClasses:function (id) {
        tabs.reload(site_url + '/inventory/stock/' + id + '?tabs=1');
    },
    showStock:function (id) {
        $.ajax({
            type:'GET',
            url:site_url + '/inventory/stock_grid/' + id,
            data:{
                ajax:1,
                stock:1,
                destination:'#reports-by-category .content-subject'
            },
            success:function (data) {
                data = jQuery.parseJSON(data);
                $('#reports-by-category').html(stock.stockTemplate(data));
                fancyBox.bind();
            }
        });
    },
    stockTemplate:function (data) {
        var name = typeof(data.name) != 'undefined' ? data.name : '';
        var grid = typeof(data.grid) != 'undefined' ? data.grid : '';
        var html = '<div class="content-header"><h3>' + name + '</h3></div> ';
        html += '<div class="content-subject">' + grid + '</div> ';
        return html;
    },
    showStockPopup:function (id) {
        $.fancybox.showActivity();
        $.ajax({
            type:'GET',
            url:site_url + '/product_sku/get_by_header/' + id,
            data:{
                ajax:1,
                stock:1
            },
            datatype:'json',
            success:function (data) {
                data = jQuery.parseJSON(data);
                var name = typeof(data.header.name) != 'undefined' ? data.header.name : '';
                var html = '<div class="content-header"><h3>' + name + '</h3></div>';
                html += '<div class="content-subject">';
                html += '<table class="table table-striped table-bordered">';
                html += '<tr><th>Attributes</th><th>Stock</th><th>Value</th></tr>';
                for (i in data.sku) {
                    html += stock.popupTemplate(data.sku[i], i);
                }
                html += '</table>';
                html += '</div>';
                $('#popup').html(html);
                $('#popup-trigger').trigger('click');
            },
            complete:function (jqXHR, textStatus) {
                $.fancybox.hideActivity();
            },
            statusCode:{
                404:function () {
                    alert("page not found");
                },
                500:function () {
                    alert("Database Error occured");
                }
            }
        });
    },
    popupTemplate:function (data, no) {
        var attributes = data.attributes;
        var count = 0;
        var stock = typeof(data.stock) != 'undefined' && data.stock != null ? data.stock : 0;
        var mrp_value = typeof(data.mrp_value) != 'undefined' && data.mrp_value != null ? data.mrp_value : 0;
        stock = parseFloat(stock).toFixed(3);
        mrp_value = parseFloat(mrp_value).toFixed(2);
        var html = '<tr>';
        html += '<td>';
        var attributeName;
        var attributeValue;
        for (var i in attributes) {
            if (count != 0) {
                html += ', ';
            }
            attributeName = typeof (attributes[i]['display_name']) != 'undefined' && attributes[i]['display_name'] != null ? attributes[i]['display_name'] : attributes[i]['name'];
            attributeValue = attributes[i]['value'];
            html += attributeName + ' : ' + attributeValue;
            count++;
        }
        html += '</td>';
        html += '<td class="text-right">' + stock + '</td>';
        html += '<td class="text-right">' + mrp_value + '</td>';
        html += '</tr>';
        return html;
    },
	selectprodAutoComplete : function (e, ui, config){

	//	$.fancybox.showActivity();
		$.ajax({
				type:'GET',
				url:site_url + '/inventory/showProdGrid/'+ ui.item.id,
				data:{
					ajax:1,
					stock:1
				},
				datatype:'json',
				success:function (data) {
				//	data = jQuery.parseJSON(data);
					//console.log('in autocomplete');
					//console.log(data);
				$(".content-subject").html(data);
				//	invoice.selectProduct(data);
				},
				complete:function (jqXHR, textStatus) {
			//		$.fancybox.hideActivity();
			  $(".content-subject").find('a').fancybox();
				},
				statusCode:{
					404:function () {
						alert("page not found");
					},
					500:function () {
						alert("Database Error occured");
					}
				}
		});
	}


}

var exchange = {
    suggest:function () {
        var term = $('#suggest_invoice').val().trim();
        if (term != '') {
            $.ajax({
                type:'GET',
                datatype:'JSON',
                url:site_url + '/invoice/suggest',
                data:{
                    term:term,
                    html:1,
                    from:'exchange'
                },
                success:function (data) {
                    $('#suggest_invoice_table').html(data);
                }
            })
        }
    },
    checked:function (e) {
        var element = e.currentTarget;
        if (e.currentTarget.checked) {
            $(element).parents('tr').find('input[name*=quantity]').removeAttr('readonly');
        } else {
            $(element).parents('tr').find('input[name*=quantity]').attr('readonly', 'readonly');
            $(element).parents('tr').find('.product-total').html('0.00');
        }
        exchange.update();
    },
    update:function () {
        var quantity, price, discount, vat, total, sub_total = 0, vat_amount = 0, total_without_vat = 0;
        var length = $(config.exchange.table).find('tr').length;
        $(config.exchange.table).find('tr').each(function (index) {
            if ($(this).attr('class') == 'table-footer') {
                return false;
            }
            if (index != 0) {
                var checked = $(this).find('input[name*=exchange]').is(':checked');
                if (checked) {
                    total = 0;
                    quantity = $(this).find('input[name*=quantity]').val();
                    price = $(this).find('input[name*=price]').val();
                    discount = $(this).find('input[name*=discount]').val();
                    vat = $(this).find('input[name*=vat_percentage]').val();

                    quantity = !isNaN(quantity) ? quantity : 0;
                    price = !isNaN(price) ? price : 0;
                    discount = !isNaN(discount) ? discount : 0;
                    vat = !isNaN(vat) ? parseFloat(vat) : 0;

                    total = price * quantity;
                    total = total - (total * discount / 100);

                    sub_total += total;
                    
                    total_without_vat = (total * 100) / ( 100 + vat ) 
                    vat_amount +=  (total - total_without_vat);                    

                    total = total.toFixed(2);
                    $(this).find('.product-total').html(total);
                }
            }
        });
        sub_total = sub_total.toFixed(2);
        vat_amount = vat_amount.toFixed(2);
        var bill_total = parseFloat(sub_total) + parseFloat(vat_amount);
        bill_total = bill_total.toFixed(2);
        $(config.exchange.table).find('#exchange_sub_total').html(sub_total);
        $(config.exchange.table).find('#exchange_vat_amount').html(vat_amount);
        $(config.exchange.table).find('#exchange_refund_amount').html(sub_total);
    },
    validate:function (form) {
        var length = $(config.exchange.table).find('tr').length;
        var flag = false;
        $(config.exchange.table).find('tr').each(function (index) {
            if ($(this).attr('class') == 'table-footer') {
                return false;
            }
            if (index != 0) {
                var checked = $(this).find('input[name*=exchange]').is(':checked');
                if (checked && !flag) {
                    flag = true;
                }
            }
        });
        if (flag) {
            form.submit();
        }
        else {
            notification.push({
                message:'Select at least one product to exchange',
                alertType:'error'
            })
        }
    }
}

var reports = {
    filter:function () {
        var rpt_t = $('#reports-drop-down').val();
        var from = $('#reports_date_from').val();
        var to = $('#reports_date_to').val();
        var brand = $('#reports_brand_id').val();
        var class_id = $('#reports_class_id').val();
        var url = '?from='+from+'&to='+to+'&brand_id='+brand+'&class_id='+class_id+'&rpt_t='+rpt_t;
        url = encodeURI(url);
        window.history.pushState('', '', url);
        $.ajax({
            type:"GET",
            url:site_url + '/' + 'inventory/reports',
            data:{
                search:1,
                from:from,
                to:to,
                brand_id:brand,
                class_id:class_id,
                ajax:1,
                ajax_reports:0,
                rpt_t: rpt_t
            },
            success:function (data) {
                $.fancybox.hideActivity();
                $('.content-main').html(data);
            }
        });
    },
    stockLedgerReports:function (e, config) {
        var from = $('#reports_date_from').val();
        var to = $('#reports_date_to').val();
        if (from == '' || to == '') {
            notification.push({
                message:'Please select From and To dates to get Stock Ledger Reports',
                alertType:'error'
            });
            return false;
        }
        if (config.xml == 1) {
            from = encodeURIComponent(from);
            to = encodeURIComponent(to);
            document.location.href = site_url + '/' + 'inventory/stock_ledger_report?from=' + from + '&to=' + to + '&xml=1';
        } else {
            $.ajax({
                type:"GET",
                url:site_url + '/' + 'inventory/stock_ledger_report',
                data:{
                    search:1,
                    from:from,
                    to:to,
                    ajax:1,
                    xml:0
                },
                success:function (data) {
                    $.fancybox.hideActivity();
                    //   data = jQuery.parseJSON(data)
                    //    var sales = typeof(data.sales) != 'undefined' ? data.sales : {};
                    //    var totalSales = typeof(sales.sales_qty) != 'undefined' ? parseFloat(sales.sales_qty) : 0;
                    //    var totalPurchases = typeof(sales.purchase_qty) != 'undefined' ? parseFloat(sales.purchase_qty) : 0;
                    /*   var html = '<p><label class="span3">Total Sales :</label><b>' + totalSales.toFixed(2) + '</b></p><br />';
                     html += '<p><label class="span3">Total Purchases :</label><b>' + totalPurchases.toFixed(2) + '</b></p>';

                     var html = '<table class="table table-bordered"><tr><td>Sales</td><td>Purchases</td></tr><tr><td>' + totalSales.toFixed(2) + '</td><td>' + totalPurchases.toFixed(2) + '</td></tr></table> '*/
                    $('#stock_ledger_reports_grid').html(data);
                }
            });
        }
    }
}

var sales_report = {
    filter: function() {        
        var from = $('#reports_date_from').val();
        var to = $('#reports_date_to').val();    
        var url = '?from='+from+'&to='+to;  
        url = encodeURI(url);
        window.history.pushState('', '', url);
        $.ajax({
            type:"GET",
            url:site_url + '/' + 'inventory/sales_report',
            data:{
                search:1,
                from:from,
                to:to,
                ajax:1,
                ajax_reports:0
                //rpt_t: rpt_t
            },
            success:function (data) {
                $.fancybox.hideActivity();
                $('.content-main').html(data);
            }
        }); 
    }
}

var brand_sales_report = {
    filter: function() {        
        var from = $('#reports_date_from').val();
        var to = $('#reports_date_to').val();
        var brand = $('#reports_brand_id').val();     
        var url = '?from='+from+'&to='+to+'&brand='+brand;
        url = encodeURI(url);
        window.history.pushState('', '', url);
        $.ajax({
            type:"GET",
            url:site_url + '/' + 'inventory/brand_sales_report',
            data:{
                search:1,
                reports_date_from:from,
                reports_date_to:to,
                reports_brand_id:brand,
                ajax:1,
                ajax_reports:0                
            },
            success:function (data) {
                $.fancybox.hideActivity();
                $('.content-main').html(data);
            }
        }); 
    },
    brandSalesExcelReport: function() {
       $('#brand_sales_form').submit();
    },
    getPageContent: function(event) {        
        var target = (event.currentTarget || event.srcElement);
        var href = target.href;
        target.href = "#";        
        var index = href.lastIndexOf('/');
        var page = href.substring(index + 1); 
        var action = site_url + '/' + 'inventory/brand_sales_report/' + page;
        $('#brand_sales_form').attr('action',action);
        $('#brand_sales_form').submit();
        //return false;
    }
}

var vat_report = {
    filter: function() {
        //var rpt_t = $('#reports-drop-down').val();
        var from = $('#reports_date_from').val(); 
        var to = $('#reports_date_to').val();        
        var url = '?from='+from+'&to='+to;//+'&rpt_t='+rpt_t;
        url = encodeURI(url);
        window.history.pushState('', '', url);
        $.ajax({
            type:"GET",
            url:site_url + '/' + 'inventory/vat_report',
            data:{
                search:1,
                reports_date_from:from,
                reports_date_to:to,                
                ajax:1,
                ajax_reports:0
                //rpt_t: rpt_t
            },
            success:function (data) {
                $.fancybox.hideActivity();               
                $('.content-main').html(data);
            }
        }); 
    },
    vatExcelReport: function() {
       $('#vat_form').submit();
    },
    getPageContent: function(event) {        
        var target = (event.currentTarget || event.srcElement);
        var href = target.href;
        target.href = "#";        
        var index = href.lastIndexOf('/');
        var page = href.substring(index + 1); 
        var action = site_url + '/' + 'inventory/vat_report/' + page;
        $('#vat_form').attr('action',action);
        $('#vat_form').submit();
        //return false;
    }
}

var manageUsers = {
    createUserValidate:function () {
        var groupId = parseInt($('#create_user_group_id').val().trim());
        var password = $('#create_user_password').val().trim();
        var confirm = $('#create_user_confirm_password').val().trim();

        if (groupId == '' || groupId <= 0) {
            notification.push({
                message:'Please Select Group',
                alertType:'error'
            });
            $('#create_user_group_id').focus();
            return false;
        }
        if (password != confirm) {
            notification.push({
                message:'Please verify your password',
                alertType:'error'
            });
            $('#create_user_confirm_password').focus();
            return false;
        }
        return true;
    },
    editUserValidate:function () {
        var groupId = parseInt($('#edit_user_group_id').val().trim());

        if (groupId == '' || groupId <= 0) {
            notification.push({
                message:'Please Select Group',
                alertType:'error'
            });
            $('#create_user_group_id').focus();
            return false;
        }
        return true;
    },
    groupPermissions:function (e) {
        var checked = e.currentTarget.checked;
        var element = e.currentTarget;
        if (checked) {
            manageUsers.checkParents(element);
            manageUsers.checkAllChildrens(element);
        } else {
            manageUsers.uncheckAllChildrens(element);
        }
    },
    checkParents:function (element) {
        var e = $(element).parents('ul');
        $(e).siblings('.checkbox').find('input[type=checkbox]').attr('checked', 'checked');
    },
    checkAllChildrens:function (element) {
        var e = $(element).parents('li');
        $(e[0]).find('ul input[type=checkbox]').attr('checked', 'checked');
    },
    uncheckAllChildrens:function (element) {
        var e = $(element).parents('li');
        $(e[0]).find('ul input[type=checkbox]').removeAttr('checked');
    }
}

var sss = {
    loadFromGRN:function (e, config) {
        purchaseReturns.emptyTable(config);
        var grn_id = $('#grn_id').val().trim();
        if (grn_id <= 0 || grn_id == '') {
            notification.push({ message:'Invalid GRN ID', alertType:'error', messageType:'sticky'});
        } else {
            $.ajax({
                type:'GET',
                url:site_url + '/grn/get_by_id/' + grn_id,
                data:{
                    json:'1',
                    view:'0'
                },
                datatype:'json',
                success:function (data) {
                    data = jQuery.parseJSON(data);
                    if (typeof(data.status) != 'undefined' && data.status == 'error') {
                        notification.push({ message:data.msg, alertType:'error', messageType:'sticky'});
                        return false;
                    }
                    //$('#vendor_block').html(grn.vendorTemplate(data.vendor_details));
                    purchaseReturns.emptyTable(config);
                    /*var vendor_id = typeof(data.vendor_details.id) != 'undefined' ? data.vendor_details.id : '';
                     $(config.vendor_id).val(vendor_id);*/

                    var products;
                    if (typeof(data.items) == 'undefined' || (typeof(data.items) != 'array' && typeof(data.items) != 'object')) {
                        products = new Array();
                    } else {
                        products = data.items;
                    }
                    var count = products.length;
                    var ui = new Object();
                    for (var i = 0; i < count; i++) {
                        ui.item = products[i];
                        purchaseReturns.addProduct('', ui, config);
                    }
                    $('#grn-product-ac-block').show();
                }
            });
        }
        //$(config.po_id_hidden).val(po_id);
    },
    addProduct:function (data) {
        var rowCount = parseInt($(config.invoice.row_count).val()) + 1;
        if (!invoice.isItemAdded(data.id)) {
            data.rowCount = rowCount;
            var html = invoice.template(data);
            $(config.invoice.table).find('.table-footer').before(html);
            $(config.invoice.row_count).val(rowCount);
            grn.updateSerials(config.invoice);
            element.key_up(config.invoice.table + ' input', validation.focus);
            element.focus(config.invoice.table + ' input', validation.focus);
            $('#product_ac').focus();
        }
        invoice.update();
    },
    update:function () {
        var quantity, price, discount, vat, total, sub_total = 0, vat_amount = 0;
        var length = $(config.invoice.table).find('tr').length;
        $(config.invoice.table).find('tr').each(function (index) {
            if ($(this).attr('class') == 'table-footer') {
                return false;
            }
            if (index != 0) {
                total = 0;
                quantity = $(this).find('input[name*=quantity]').val();
                price = $(this).find('input[name*=price]').val();
                discount = $(this).find('input[name*=discount]').val();
                vat = $(this).find('input[name*=vat_percentage]').val();

                quantity = !isNaN(quantity) ? quantity : 0;
                price = !isNaN(price) ? price : 0;
                discount = !isNaN(discount) ? discount : 0;
                vat = !isNaN(vat) ? vat : 0;

                total = price * quantity;
                total = total - (total * discount / 100);

                sub_total += total;
                vat_amount += total * vat / 100;

                total = total.toFixed(2);
                $(this).find('.product-total').html(total);
            }
        });
        sub_total = sub_total.toFixed(2);
        vat_amount = vat_amount.toFixed(2);
        var bill_total = parseFloat(sub_total) + parseFloat(vat_amount);
        bill_total = bill_total.toFixed(2);
        $(config.invoice.table).find('#invoice_sub_total').html(sub_total);
        $(config.invoice.table).find('#invoice_vat_amount').html(vat_amount);
        $(config.invoice.table).find('#invoice_total_amount').html(sub_total);
        $('#payment_block input[name=invoice_cash_amt]').val(sub_total);
        payment.total();
    },
    isItemAdded:function (id) {
        var ids = $(config.invoice.table).find('input[name*=item_id]');
        var status = false;
        $(ids).each(function (index) {
            var c_id = $(this).val();
            var c_array = c_id.split('_');
            var sku_id = c_array[1];
            if (sku_id == id) {
                var qty = $(config.invoice.table).find('input[name=quantity_' + c_id + ']').val();
                qty = parseInt(qty);
                qty++;
                $(config.invoice.table).find('input[name=quantity_' + c_id + ']').val(qty);
                status = true;
                return false;
            }
        });
        return status;
    },
    remove:function (e) {
        $(e).parents('tr').remove();
        invoice.update();
        grn.updateSerials(config.invoice);
    },
    template:function (params) {
        var ids = '26_' + params.id + '_' + params.rowCount;
        var total = params.qty * params.price;
        total = total - total * params.discount / 100;
        total = total.toFixed(2);
        var html = '<tr>';
        html += '<td class="span1 text-right product-sno"></td>';

        html += '<td>' + params.name;
        html += '<input type="hidden" value="' + params.name + '" name="name_' + ids + '">';
        html += '<input type="hidden" value="' + ids + '" name="item_id[]">';
        html += '<input type="hidden" value="' + params.vat + '" name="vat_percentage_' + ids + '">';
        html += '</td>';

        html += '<td>' + params.brand + '</td>';
        html += '<td><input type="text" onkeyup="invoice.update(config.invoice)" value="' + params.qty + '" autocomplete="off" min="0" max="' + params.stock + '" class="input-mini text-right required" name="quantity_' + ids + '"></td>';
        html += '<td><input readonly type="text" onkeyup="invoice.update(config.invoice)" value="' + params.price + '" autocomplete="off" min="0" class="input-mini text-right required number" name="price_' + ids + '"></td>';
        html += '<td><input type="text" onkeyup="invoice.update(config.invoice)" value="' + params.discount + '" autocomplete="off" min="0" max="100" class="input-mini text-right required number" name="discount_' + ids + '"></td>';
        html += '<td class="text-right product-total">' + total + '</td>';
        html += '<td><button type="button" class="btn btn-danger action-button" onclick="invoice.remove(this)"><i class="icon-trash icon-white"></i></button></td>';
        html += '</tr>';
        return html;
    }
}


var purchaseReturns = {
    productAutocomplete:function (e, ui, config) {
        $.fancybox.showActivity();
        $.ajax({
            type:'GET',
            url:site_url + '/product_sku/get_by_header/' + ui.item.id,
            data:{
                ajax:1,
                stock:1
            },
            datatype:'json',
            success:function (data) {
                data = jQuery.parseJSON(data);
                purchaseReturns.selectProduct(data);
            },
            complete:function (jqXHR, textStatus) {
                $.fancybox.hideActivity();
            },
            statusCode:{
                404:function () {
                    alert("page not found");
                },
                500:function () {
                    alert("Database Error");
                }
            }
        });
    },
    productBarcode:function (e) {
        if (e.keyCode == 38 || e.keyCode == 40) {
            return false;
        }
        var barcode = e.currentTarget.value;
        if (isNaN(barcode.charAt(0))) {
            $('#product_ac').autocomplete('enable');
        } else {
            $('#product_ac').autocomplete('disable');
            if (e.keyCode == 13 && barcode.length != 0) {
                $.fancybox.showActivity();
                $.ajax({
                    url:site_url + '/product_sku/get_by_barcode/' + barcode,
                    method:'POST',
                    datatype:'JSON',
                    data:{
                        stock:1
                    },
                    success:function (data) {
                        data = jQuery.parseJSON(data);
                        purchaseReturns.selectProduct(data);
                        $('#product_ac').val('');
                        $('#product_ac').focus();
                    },
                    complete:function (xhr, status) {
                        $.fancybox.hideActivity();
                    },
                    statusCode:{
                        404:function () {
                            alert("page not found");
                        },
                        500:function () {
                            alert("Database Error occured");
                        }
                    }
                });
            }
        }
    },
    selectVendor:function (e, ui, config) {
        $('#vendor_id').val(ui.item.id);
    },
    selectProduct:function (data) {
        var sku = typeof(data.sku) != 'undefined' ? data.sku : Array();
        if (sku.length == 0) {
            notification.push({
                message:'Product is not available in Stock',
                alertType:'info',
                messageType:'sticky'
            });
        } else if (sku.length == 1) {
            var name = typeof(data.header) != 'undefined' ? data.header.name : data.sku[0].name;
            var brand = typeof(data.header) != 'undefined' ? data.header.brand : data.sku[0].brand;
            var vat_percentage = typeof(data.header) != 'undefined' ? data.header.vat_percentage : data.sku[0].vat_percentage;
            if (data.sku[0].stock == null || data.sku[0].stock <= 0) {
                notification.push({
                    message:'Product is not available in Stock',
                    alertType:'info',
                    messageType:'sticky'
                });
            } else {
                purchaseReturns.addProduct({
                    id:data.sku[0].id,
                    name:name,
                    brand:brand,
                    qty:1,
                    stock:data.sku[0].stock,
                    price:data.sku[0.].attributes.price,
                    discount:0,
                    vat:vat_percentage,
                    attributes:data.sku[0].attributes
                });
            }
        } else if (sku.length > 1) {
            purchaseReturns.showPopup(data, config);
        }
    },
    loadFromGRN:function (e, ui, config) {
        $.fancybox.showActivity();
        purchaseReturns.emptyTable(config);
        var grn_id = $('#grn_id').val().trim();
        if (grn_id <= 0 || grn_id == '') {
            notification.push({ message:'Invalid GRN ID', alertType:'error', messageType:'sticky'});
        } else {
            $.ajax({
                url:site_url + '/grn/get_by_id/' + grn_id,
                method:'POST',
                datatype:'JSON',
                data:{
                    json:'1',
                    view:'0'
                },
                success:function (data) {
                    var d = jQuery.parseJSON(data);
                    if (d.status != 'success') {
                        notification.push({
                            message:'Invalid GRN id',
                            alertType:'info',
                            messageType:'sticky'
                        });
                        return false;
                    }
                    data = d.grn;
                    var vendor = d.vendor.company_name;
                    if (typeof(data.items) != 'undefined') {
                        console.log(data);
                        $('#vendor_id').val(data.vendor_id);
                        $('#vendor_ac').val(vendor);
                        $('#vendor_ac').attr('disabled', 'disabled');
                        for (var i in data.items) {
                            var item = data.items[i];
                            if (item.stock == null || item.stock <= 0) {
                                notification.push({
                                    message:'Product is not available in Stock',
                                    alertType:'info',
                                    messageType:'sticky'
                                });
                            } else {
                                purchaseReturns.addProduct({
                                    id:item.item_specific_id,
                                    name:item.name,
                                    brand:item.brand,
                                    qty:item.quantity,
                                    stock:item.stock,
                                    price:item.price,
                                    discount:item.discount,
                                    vat:item.vat_percentage,
                                    attributes:item.attributes
                                });
                            }
                        }
                    }
                },
                complete:function (xhr, status) {
                    $.fancybox.hideActivity();
                },
                statusCode:{
                    404:function () {
                        alert("page not found");
                    },
                    500:function () {
                        alert("Database Error occured");
                    }
                }
            });
        }
    },
    showPopup:function (data) {
        var name = typeof(data.header.name) != 'undefined' ? data.header.name : '';
        var html = '<div class="content-header"><h3>' + name + '</h3></div>';
        html += '<div id="popup-responce" class="hide">' + JSON.stringify(data) + '</div>';
        for (i in data.sku) {
            html += purchaseReturns.popupTemplate(data.sku[i], i);
        }
        $('#popup').html(html);
        $('#popup-trigger').trigger('click');
    },
    popupTemplate:function (data, no) {
        var attributes = data.attributes;
        var count = 0;
        var html = '<div class="popup-item block" onclick="purchaseReturns.popupSelectProduct(' + no + ')">';
        var attributeName;
        var attributeValue;
        for (var i in attributes) {
            if (count % 2 == 0) {
                html += '<div>';
            }
            attributeName = typeof (attributes[i]['display_name']) != 'undefined' && attributes[i]['display_name'] != null ? attributes[i]['display_name'] : attributes[i]['name'];
            attributeValue = attributes[i]['value'];
            html += '<span class="span1">' + attributeName + ':</span>';
            html += '<span class="span1">' + attributeValue + '</span>';
            if (count % 2 == 1) {
                html += '</div>';
            }
            count++;
        }
        if (count % 2 == 1) {
            html += '</div>';
        }
        html += '</div>';
        return html;
    },
    popupSelectProduct:function (no) {
        var data = $('#popup-responce').html();
        data = jQuery.parseJSON(data);
        $.fancybox.close();
        if (data.sku[no].stock == null || data.sku[no].stock <= 0) {
            notification.push({
                message:'Product is not available in Stock',
                alertType:'info',
                messageType:'sticky'
            });
        } else {
            purchaseReturns.addProduct({
                id:data.sku[no].id,
                name:data.header.name,
                brand:data.header.brand,
                qty:1,
                stock:data.sku[no].stock,
                price:data.sku[no].price,
                discount:0,
                vat:data.header.vat_percentage,
                attributes:data.sku[no].attributes
            });
        }
    },
    addProduct:function (data) {
        var rowCount = parseInt($(config.purchaseReturns.row_count).val()) + 1;
        if (!purchaseReturns.isItemAdded(data.id)) {
            data.rowCount = rowCount;
            var html = purchaseReturns.template(data);
            $(config.purchaseReturns.table).find('.table-footer').before(html);
            $(config.purchaseReturns.row_count).val(rowCount);
            grn.updateSerials(config.purchaseReturns);
            element.key_up(config.purchaseReturns.table + ' input', validation.focus);
            element.focus(config.purchaseReturns.table + ' input', validation.focus);
            $('#product_ac').focus();
        }
        purchaseReturns.update();
    },
    update:function () {
        var quantity, price, discount, vat, total, sub_total = 0, vat_amount = 0;
        var length = $(config.purchaseReturns.table).find('tr').length;
        $(config.purchaseReturns.table).find('tr').each(function (index) {
            if ($(this).attr('class') == 'table-footer') {
                return false;
            }
            if (index != 0) {
                total = 0;
                quantity = $(this).find('input[name*=quantity]').val();
                price = $(this).find('input[name*=price]').val();
                discount = $(this).find('input[name*=discount]').val();
                vat = $(this).find('input[name*=vat_percentage]').val();

                quantity = !isNaN(quantity) ? quantity : 0;
                price = !isNaN(price) ? price : 0;
                discount = !isNaN(discount) ? discount : 0;
                vat = !isNaN(vat) ? vat : 0;

                total = price * quantity;
                total = total - (total * discount / 100);

                sub_total += total;
                vat_amount += total * vat / 100;

                total = total.toFixed(2);
                $(this).find('.product-total').html(total);
            }
        });
        sub_total = sub_total.toFixed(2);
        vat_amount = vat_amount.toFixed(2);
        var bill_total = parseFloat(sub_total) + parseFloat(vat_amount);
        bill_total = bill_total.toFixed(2);
        $(config.purchaseReturns.table).find('#purchase_returns_sub_total').html(sub_total);
    },
    isItemAdded:function (id) {
        var ids = $(config.purchaseReturns.table).find('input[name*=item_id]');
        var status = false;
        $(ids).each(function (index) {
            var c_id = $(this).val();
            var c_array = c_id.split('_');
            var sku_id = c_array[1];
            if (sku_id == id) {
                var qty = $(config.purchaseReturns.table).find('input[name=quantity_' + c_id + ']').val();
                qty = parseInt(qty);
                qty++;
                $(config.purchaseReturns.table).find('input[name=quantity_' + c_id + ']').val(qty);
                status = true;
                return false;
            }
        });
        return status;
    },
    remove:function (e) {
        $(e).parents('tr').remove();
        purchaseReturns.update();
        grn.updateSerials(config.purchaseReturns);
    },
    template:function (params) {
        var ids = '26_' + params.id + '_' + params.rowCount;
        var total = params.qty * params.price;
        total = total - total * params.discount / 100;
        total = 0;
        total = total.toFixed(2);
        var html = '<tr>';
        html += '<td class="span1 text-right product-sno"></td>';

        html += '<td>' + params.name;
        html += '<input type="hidden" value="' + params.name + '" name="name_' + ids + '">';
        html += '<input type="hidden" value="' + ids + '" name="item_id[]">';
        html += '<input type="hidden" value="' + params.vat + '" name="vat_percentage_' + ids + '">';
        html += '</td>';

        html += '<td>' + params.brand + '</td>';
        var attributes = typeof(params.attributes) != 'undefined' ? params.attributes : [];
        html += '<td>';
        var count = 0;
        var attributeName;
        var attributeValue;
        for (var i in attributes) {
            if (count != 0) {
                html += ', ';
            }
            attributeName = typeof (attributes[i]['display_name']) != 'undefined' && attributes[i]['display_name'] != null ? attributes[i]['display_name'] : attributes[i]['name'];
            attributeValue = attributes[i]['value'];
            html += attributeName + ' : ' + attributeValue;
            count++;
        }
        html += '</td>';
        html += '<td><input type="text" onkeyup="purchaseReturns.update(config.purchaseReturns)" value="' + params.qty + '" autocomplete="off" min="0" max="' + params.stock + '" class="input-mini text-right required" name="quantity_' + ids + '"></td>';
        html += '<td><input type="text" onkeyup="purchaseReturns.update(config.purchaseReturns)" value="0" autocomplete="off" min="0" class="input-mini text-right required number" name="price_' + ids + '"></td>';
        //html += '<td><input type="text" onkeyup="purchaseReturns.update(config.purchaseReturns)" value="' + params.discount + '" autocomplete="off" min="0" max="100" class="input-mini text-right required number" name="discount_' + ids + '"></td>';
        html += '<td class="text-right product-total">' + total + '</td>';
        html += '<td><button type="button" class="btn btn-danger action-button" onclick="purchaseReturns.remove(this)"><i class="icon-trash icon-white"></i></button></td>';
        html += '</tr>';
        return html;
    },
    validate:function (form) {
        var btn_name = $('#invoice_button_type').val();
        if (btn_name == 'estimate' || btn_name == 'cart') {
            form.submit();
        } else if (btn_name == 'invoice') {
            var total = parseFloat($('#invoice_total_amount').html());
            var payment_total = payment.total();
            if (payment_total >= total) {
                form.submit();
            } else {
                notification.push({
                    message:'Please review your payment',
                    alertType:'error'
                });
            }
        }
    },
    submit:function (e) {
        var vendor_id = $(config.purchaseReturns.vendor_id).val();
        if (vendor_id == '') {
            notification.push({
                message:'Select Vendor to proceed',
                alertType:'error'
            });
            return false;
        } else {
            e.submit();
        }
    },
    emptyTable:function () {
        $('#purchase-returns-table').find('tr').each(function (index) {
            if ($(this).attr('class') == 'table-footer') {
                return false;
            }
            if (index != 0) {
                $(this).remove();
            }
        });
        purchaseReturns.update(config);
    }
}

var barcodes = {
    print:function (e, parentId) {
        console.log(parentId);
        $('.ui-tabs-panel div').hide();
        $('.ui-tabs-panel #multiple-barcodes').show();
    }
}

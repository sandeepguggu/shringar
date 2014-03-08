<script type="text/javascript">
    $(function(){
        $('#add-ornament-form').validate({
            submitHandler: function(form) {
                temp = parseInt($("#metal-table-rows").val()) + parseInt($('#stone-table-rows').val());
                console.log()
                if($('select[name=category_id]').val() == '') {
                    alert('Select Category');
                } else if( temp > 0) {
                    $.ajax({
                        type: 'POST',
                        url: form.action,
                        data: $(form).serialize(),
                        success: ajax_success
                    }); 
		 
                    return false;
                } else {
                    alert('Ornament Should contain atleast one Metal or Stone');
                }
            }
        });
        var cache = {},lastXhr;
        
        var pcache = {},plastXhr;
        $('.ornament').find("#metal-name" ).autocomplete({
            appendTo: $('.ornament').find("#metal-name" ).parents(".autocomplete-jui"),
            minLength: 2,
            source: function( request, response ) {
                var term = request.term;
                if ( term in cache ) {
                    response( pcache[ term ] );
                    return;
                }

                plastXhr = $.getJSON( "/index.php/product/suggest_items/1?json=1&from=ornament", request, function( data, status, xhr ) {
                    pcache[ term ] = data;
                    if ( xhr === plastXhr ) {
                        response( data );
                    }
                });
            },
            select: function(e,ui){
                if(can_add_item_id(ui.item.id, 'metal')){
                    
                    $('#ornament-metal-table').append(ui.item.html);
                    $('#ornament-metal-table').show();
                    $('#metal-table-rows').val(parseInt($('#metal-table-rows').val())+1);
                    $('.ornament').find("#metal-name" ).val('');
                }else{
                    alert('Item already added!');
                }
            }
        });
        
        var pcache = {},plastXhr;
        $('.ornament').find("#stone-name" ).autocomplete({
            appendTo: $('.ornament').find("#stone-name" ).parents(".autocomplete-jui"),
            minLength: 2,
            source: function( request, response ) {
                var term = request.term;
                if ( term in cache ) {
                    response( pcache[ term ] );
                    return;
                }

                plastXhr = $.getJSON( "/index.php/product/suggest_items/2?json=1&from=ornament", request, function( data, status, xhr ) {
                    pcache[ term ] = data;
                    if ( xhr === plastXhr ) {
                        response( data );
                    }
                });
            },
            select: function(e,ui){
                if(can_add_item_id(ui.item.id, 'stone')){
                    $('#ornament-stone-table').append(ui.item.html);
                    $('#ornament-stone-table').show();
                    $('#stone-table-rows').val(parseInt($('#stone-table-rows').val())+1);
                    $('.ornament').find("#stone-name" ).val('');
                }else{
                    alert('Item already added!');
                }
            }
        });
    });
    function can_add_item_id(id, type){
        o = $('.ornament').find('.selected-'+type+'s').find('.selected-'+type+'-ids');
        if(o.length == 0) {
            return true;
        } else {
            
            window.found_item = 0;
            $(o).each(function(){
                if(window.found_item == 0 && id == $(this).val()){
                    window.found_item = 1;
                }
            });

            if(window.found_item == 1){
                return false;
            } else {
                return true;
            }
        }
    }
    
    function remove_row(e, type) {
        $(e).parent().parent().remove();
        $('#'+type+'-table-rows').val(parseInt($('#'+type+'-table-rows').val())-1);
        if($('#'+type+'-table-rows').val() == 0) {
            $('#ornament-'+type+'-table').hide();
        }
    }
</script>
<?php if (isset($status)): ?>
    <div class="alert-message <?php if ($status == true) echo 'success'; else echo 'danger'; ?>"><?= $msg; ?></div>
<?php else: ?>
    <div class="ornament">
        <h3 class="my-header">Add Ornament</h3>
        <form action="<?= site_url('product/add_ornament_to_db?ajax=1'); ?>" id="add-ornament-form">
            <fieldset class="my-block my-fieldset">
                <div class="my-block">
                    <label class="pull-left span3">Name:</label>
                    <div class="pull-left span4">
                        <input type="text" class="required span4" name="ornament-name" />
                    </div>
                </div>
                <div class="my-block">
                    <label class="pull-left span3">Making(%):</label>
                    <div class="pull-left span2">
                        <input type="text" class="required number span2" min="0" max="100" name="making-cost" />
                    </div>
                    <div class="pull-right span2">
                        <select name="making-cost-type" class="span2">
                            <option value="percent">%</option>
                            <option value="fixed">Rs.</option>
                        </select>
                    </div>
                </div>
                <div class="my-block">
                    <label class="pull-left span3">Wastage(%):</label>
                    <div class="pull-left span2">
                        <input type="text" class="required number span2" min="0" max="100" name="wastage-cost" />
                    </div>
                    <div class="pull-right span2">
                        <select name="wastage-cost-type" class="span2">
                            <option value="percent">%</option>
                            <option value="fixed">Rs.</option>
                        </select>
                    </div>
                </div>
                <div class="my-block">
                    <label class="pull-left span3">Category:</label>
                    <div class="pull-left span4">
                        <select name="category_id" class="span4">
                            <option value="">Select-Category</option>
                            <?php
                            if (isset($category) && is_array($category)) {
                                foreach ($category as $c) {
                                    echo '<option value="' . $c['id'] . '">' . $c['name'] . '</option>' . "\n";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="my-block">
                    <label class="pull-left span3">Comments:</label>
                    <div class="pull-left span4">
                        <textarea class="span4" minlength="0" name="comments"></textarea>
                    </div>
                </div>
            </fieldset>
            <fieldset class="my-block my-fieldset">
                <label class="span3 pull-left">Metal:</label>
                <div class="autocomplete-jui span4 pull-left">
                    <div class="ui-widget">
                        <input type="text" name="metal-name" id="metal-name" class="span4"/>
                    </div>
                </div>
            </fieldset>
            <input type="hidden" name="metal-table-rows" id="metal-table-rows" value="0">
            <table class="my-table selected-metals hide" id="ornament-metal-table">
                <tr>
                    <td class="meta-head my-span1">ID</td>
                    <td class="meta-head">Name</td>
                    <td class="meta-head my-span1">&nbsp;</td>
                </tr>
            </table>                
            <fieldset class="my-block my-fieldset">
                <label class="span3 pull-left">Stone:</label>
                <div class="autocomplete-jui span4 pull-left">
                    <div class="ui-widget">
                        <input type="text" name="metal-name" id="stone-name" class="span4"/>
                    </div>
                </div>
            </fieldset>
            <input type="hidden" name="stone-table-rows" id="stone-table-rows" value="0">
            <table class="my-table selected-stones hide" id="ornament-stone-table">
                <tr>
                    <td class="meta-head my-span1">ID</td>
                    <td class="meta-head">Name</td>
                    <td class="meta-head my-span1">&nbsp;</td>
                </tr>
            </table>
            <div class="my-block print-center-200">
                <input type="submit" class="btn primary span2" value="Add" /> 
                <input type="button" class="btn danger span2" value="Cancel" onclick="$.fancybox.close();" />
            </div>
        </form>
    </div>    
<?php endif; ?>
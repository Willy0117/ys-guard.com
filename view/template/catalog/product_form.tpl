<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-product" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-product" class="form-horizontal">

          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <!-- カテゴリー-->
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-category"><?php echo $entry_category; ?></label>
                <div class="col-sm-10">
                  <select name="category_id" value="" placeholder="<?php echo $entry_category; ?>" id="category" class="form-control" />
                  <option value="*"></option>
                  <?php foreach($categoryes as $result) { ?>
				            <?php if ($result['category_id'] == $category_id) { ?>
	                	 <option value="<?php echo $result['category_id'];?>" selected="selected"><?php echo $result['name'];?></option>
			              <?php } else { ?>
	                	 <option value="<?php echo $result['category_id'];?>"><?php echo $result['name'];?></option>
                    <?php } ?>
                  <?php } ?>
                  </select>
                  <?php if ($error_category) { ?>
                      <div class="text-danger"><?php echo $error_category; ?></div>
                  <?php } ?>
                </div>
              </div>
              <!-- 得意先-->
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-customer_group"><?php echo $entry_customer_group; ?></label>
                <div class="col-sm-10">
                  <select name="customer_group" value="" placeholder="<?php echo $entry_customer_group; ?>" id="category" class="form-control" />
                  <option value="*"></option>
                  <?php foreach($customer_groups as $result) { ?>
		                <?php if ($result['id'] == $customer_group) { ?>
            	        <option value="<?php echo $result['id'];?>" selected="selected"><?php echo $result['name'];?></option>
	                  <?php } else { ?>
	                  	<option value="<?php echo $result['id'];?>"><?php echo $result['name'];?></option>
                    <?php } ?>
                  <?php } ?>
                  </select>
                  <?php if ($error_customer_group) { ?>
                      <div class="text-danger"><?php echo $error_customer_group; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
                      <?php if ($error_name) { ?>
	                      <div class="text-danger"><?php echo $error_name; ?></div>
                      <?php } ?>
                    </div>
              </div>

              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-model"><?php echo $entry_model; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="model" value="<?php echo $model; ?>" placeholder="<?php echo $entry_model; ?>" id="input-model" class="form-control" />
                  <?php if ($error_model) { ?>
                  <div class="text-danger"><?php echo $error_model; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-quantity"><?php echo $entry_quantity; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="quantity" value="<?php echo $quantity; ?>" placeholder="<?php echo $entry_quantity; ?>" id="input-quantity" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="status" id="input-status" class="form-control">
                    <?php if ($status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
                </div>
              </div>

             <div class="form-group ">
               <label class="col-sm-2 control-label"><?php echo $entry_price; ?></label>
               <div class="col-sm-10 table-responsive">
                 <table class="col-sm-12 table">
                   <thead>
                     <tr>
                       <th class="col-sm-2"><?php echo $entry_price; ?></th>
                       <th class="col-sm-2"><?php echo $entry_invoice; ?></th>
                       <th class="col-sm-2"><?php echo $entry_tax; ?></th>
                       <th class="col-sm-3"><?php echo $entry_date_start; ?></th>
                       <th class="col-sm-3"><?php echo $entry_date_end; ?></th>
                     </tr>
                   </thead>
                   <tbody id="base">
                     <?php if ($prices) {
                       foreach ($prices as $result) { ?>
                         <tr>
                           <td>
                             <input type="text" name="price[]" value="<?php echo $result['price']; ?>" placeholder="<?php echo $entry_price; ?>" id="input-price" class="form-control" />
                           </td>
                           <td>
                             <input type="text" name="invoice[]" value="<?php echo $result['invoice']; ?>" placeholder="<?php echo $entry_invoice; ?>" id="input-invoice" class="form-control" />
                           </td>
                           <td>
                             <select name="tax_id[]" id="input-tax" class="form-control">
                             <option value="0"><?php echo $text_none; ?></option>
                             <?php foreach ($taxes as $tax) { ?>
                             <?php if ($tax['id'] == $result['tax_id']) { ?>
                             <option value="<?php echo $tax['id']; ?>" selected="selected"><?php echo $tax['title']; ?></option>
                             <?php } else { ?>
                             <option value="<?php echo $tax['id']; ?>"><?php echo $tax['title']; ?></option>
                             <?php } ?>
                             <?php } ?>
                             </select></td>
                           <td>
                             <div class="flatpickr input-group date" data-wrap="true" data-clickOpens="false">
                               <input type="text" name="date_from[]" value="<?php echo $result['date_from']; ?>" placeholder="<?php echo $entry_date_start; ?>" data-format="YYYY-MM-DD" id="input-date-start" class="form-control" data-altinput=true data-input />
                                 <a class="input-group-addon" data-toggle><i class='fa fa-calendar'></i></a>
                             </div>
                           </td>
                           <td>
                             <div class="flatpickr input-group date" data-wrap="true" data-clickOpens="false">
                               <input type="text" name="date_to[]" value="<?php echo $result['date_to']; ?>" placeholder="<?php echo $entry_date_end; ?>" data-format="YYYY-MM-DD" id="input-date-end" class="form-control" data-altinput=true data-input />
                                 <a class="input-group-addon" data-toggle><i class='fa fa-calendar'></i></a>
                             </div>
                           </td>
                         </tr>
                       <?php }
                     } else { ?>
                       <tr>
                         <td>
                           <input type="text" name="price[]" value="0" placeholder="<?php echo $entry_price; ?>" id="input-price" class="form-control" />
                         </td>
                         <td>
                           <input type="text" name="invoice[]" value="0" placeholder="<?php echo $entry_invoice; ?>" id="input-invoice" class="form-control" />
                         </td>
                         <td>
                           <select name="tax_id[]" id="input-tax" class="form-control">
                           <option value="0"><?php echo $text_none; ?></option>
                           <?php foreach ($taxes as $tax) { ?>
                           <option value="<?php echo $tax['id']; ?>"><?php echo $tax['title']; ?></option>
                           <?php } ?>
                           </select></td>
                         <td>
                           <div class="flatpickr input-group date" data-wrap="true" data-clickOpens="false">
                             <input type="text" name="date_from[]" value="<?php echo date("Y-m-d"); ?>" placeholder="<?php echo $entry_date_start; ?>" data-format="YYYY-MM-DD" id="input-date-start" class="form-control" data-altinput=true data-input />
                               <a class="input-group-addon" data-toggle><i class='fa fa-calendar'></i></a>
                           </div>
                         </td>
                         <td>
                           <div class="flatpickr input-group date" data-wrap="true" data-clickOpens="false">
                             <input type="text" name="date_to[]" value="<?php echo date("Y-m-d"); ?>" placeholder="<?php echo $entry_date_available; ?>" data-format="YYYY-MM-DD" id="input-date-end" class="form-control" data-altinput=true data-input />
                               <a class="input-group-addon" data-toggle><i class='fa fa-calendar'></i></a>
                           </div>
                         </td>
                       </tr>
                     <?php }?>
                   </tbody>
                   <tfoot >
                     <tr>
                       <td>
                         <button class="addList btn btn-primary" type="button" title="<?php echo $text_plus; ?>"><i class="fa fa-plus"></i></button>
                         <button class="removeList btn btn-default" type="button" title="<?php echo $text_minus; ?>"><i class="fa fa-minus"></i></button>
                       </td>
                     </tr>
                   </tfoot>
                 </table>
             <input type="hidden" name="row_length" value="1">

            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

<script type="text/javascript"><!--
$(document).ready(function () {
  const fpConf = {
	locale: "ja",
	};
  var clone = $('#base tr:first').clone();　// tableの１行目をコピーする
  // 行を追加する
  $(document).on("click", ".addList", function (event) {
    event.stopPropagation();
    const newClone = clone.clone();

    $("#base").append(newClone);
    $(newClone).find(".flatpickr").flatpickr(fpConf);
  });

  // 行を削除する
  $(document).on("click", ".removeList", function () {
    if ($('#base').prop('rows').length >1) { // 行数を見て、２行以上なら削除
      $("#base tr:last").remove();
    }
  });

});// Category
$('input[name=\'category\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['category_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'category\']').val('');

		$('#product-category' + item['value']).remove();

		$('#product-category').append('<div id="product-category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="product_category[]" value="' + item['value'] + '" /></div>');
	}
});

$('#product-category').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});

// Filter
$('input[name=\'filter\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/filter/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['filter_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter\']').val('');

		$('#product-filter' + item['value']).remove();

		$('#product-filter').append('<div id="product-filter' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="product_filter[]" value="' + item['value'] + '" /></div>');
	}
});

$('#product-filter').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});

//--></script>
<script>
  flatpickr('.flatpickr', {
    locale: 'ja',
    allowInput: true,
});
</script>
</div>
<?php echo $footer; ?>

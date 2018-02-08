<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title"><?php echo $heading_title; ?></h4>
    </div>
    <div class="modal-body">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead class="sort">
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-left"><?php if ($sort == 'p.customer_group') { ?>
                    <a href="<?php echo $sort_customer_group; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_customer_group; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_customer_group; ?>"><?php echo $column_customer_group; ?></a>
                    <?php } ?>
                  </td>
                  <td class="text-left"><?php if ($sort == 'p.name') { ?>
                    <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                    <?php } ?>
                  </td>
                  <td class="text-left"><?php if ($sort == 'pc.category') { ?>
                    <a href="<?php echo $sort_category; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_category; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_category; ?>"><?php echo $column_category; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'p.model') { ?>
                    <a href="<?php echo $sort_model; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_model; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_model; ?>"><?php echo $column_model; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php echo $column_price; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($products) { ?>
                <?php foreach ($products as $product) { ?>
                <tr>
                  <td class="text-center">
                    <div class="btn-group btn btn-default">
                    <input type="checkbox" data-dismiss="modal" name="selected" value="<?php echo $product['id']; ?>" class="product btn btn-primary"/>
                    </div>
                  </td>
                  <td class="text-left"><?php echo $product['customer_group']; ?></td>
                  <td class="name text-left"><?php echo $product['name']; ?></td>
                  <td class="text-left"><?php echo $product['category']; ?></td>
                  <td class="model text-left"><?php echo $product['model']; ?></td>
                  <td class="price text-right"><?php echo $product['price']; ?></td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="9"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </form>
        <div class="row">
           <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
           <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
        <div class="modal-footer">
            <!-- button type="button" class="btn btn-primary" id="modal-save" data-dismiss="modal">更新</button -->
        </div>
    </div>
  </div>

<script type="text/javascript"><!--
var products = <?php echo json_encode($products, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
var taxes = <?php echo json_encode($taxes, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;

$('.product').on('click', function(e) {
	e.preventDefault();
    id = $(this).val();
    console.log(id);
    arr = jQuery.grep(products, function(value, index ) {
      return ( value.id == id );
    });
    tax_id = arr[0]['tax_id'];
    if (tax_id == 0) tax_id = 1;
    tax = jQuery.grep(taxes, function(value, index ) {
      return ( value.id == tax_id );
    });
    var i = <?php echo $index; ?>;// $( 'input[name="idx"]' ).val();
    console.log(i);
    //i++;
    if (i < 3 ) i = 3;
    if (i < 11 ) {
      $('.id').eq(i).val( arr[0]['id'] );
      $('.model').eq(i).val( arr[0]['model'] );
      $('.name').eq(i).val( arr[0]['name'] );
      $('.price').eq(i).val( Math.round(arr[0]['price']) );
      $('.amount').eq(i).val( Math.round(arr[0]['price']) );
      $('.tax').eq(i).val( Math.round(arr[0]['price'] * tax[0]['rate'] ) );
      $('.tax_id').eq(i).val( arr[0]['tax_id'] );
      $('.invoice').eq(i).val( Math.round(arr[0]['invoice'] ) );

      recalc();

    } else {
      $("#base").append('<tr>' +
        '<input type="hidden" name="prices[' + i + '][id]" value="' + id + '" class="id form-control" />' +
        '<input type="hidden" name="prices[' + i + '][model]" value="' + arr[0]['model'] + '" class="model form-control" />' +
        '<input type="hidden" name="prices[' + i + '][tax_id]" value="' + arr[0]['tax_id'] + '" class="tax_id form-control" />' +
        '<input type="hidden" name="prices[' + i + '][invoice]" value="' + arr[0]['invoice'] + '" class="invoice form-control" />' +
        '<td>' +
          '<input type="text" name="prices[' + i + '][name]" value="' + arr[0]['name'] + '" class="name form-control" />' +
        '</td>' +
        '<td>' +
          '<input type="text" name="prices[' + i + '][summary]" value="" class="summary form-control" />' +
        '</td>' +
        '<td>' +
          '<input type="text" name="prices[' + i + '][quantity]" value="1" class="quantity form-control" />' +
        '</td>' +
        '<td>' +
          '<input type="text" name="prices[' + i + '][unit_price]" value="' + Math.round(arr[0]['price']) + '" class="price form-control" />' +
        '</td>' +
        '<td>' +
          '<input readonly="readonly" type="text" name="prices[' + i + '][amount]" value="' + Math.round(arr[0]['price']*1) + '" class="amount form-control" />' +
        '</td>' +
        '<td>' +
          '<input type="text" name="prices[' + i + '][tax]" value="" class="tax form-control" />' +
        '</td>' +
        '</tr>'
      );
  }
  $( 'input[name="idx"]' ).val(i);
});
/*
  再計算
*/
function recalc() {
  var total1= 0;
  var tax1= 0;
  var total2= 0;
  var tax2= 0;

  for(i=0;i<4;i++) {
    total1 += parseFloat($('.amount').eq(i).val());
    tax1 += parseFloat($('.tax').eq(i).val());
  }
  for(i=4;i<10;i++) {
    total2 += parseFloat($('.amount').eq(i).val());
    tax2 += parseFloat($('.tax').eq(i).val());
  }

  $('.total1').val( total1 );
  $('.total2').val( total2 );
  $('.tax1').val( tax1 );
  $('.tax2').val( tax2 );
}

$('#modal-product').on('hide.bs.modal', function () {
  $('#modal-product').remove();
});
$('#modal-product').on('hidden.bs.modal', function () {
  $('#modal-product').remove();
});

$('.pagination a').on('click', function(e) {
	e.preventDefault();

	$('#modal-product').load($(this).attr('href'));
});

$('.sort a').on('click', function(e) {
	e.preventDefault();
  //alert($(this).attr('href'));
	$('#modal-product').load($(this).attr('href'));
});
//--></script>
<script type="text/javascript"><!--
$('#button-filter').on('click', function(e) {
var url = 'index.php?route=sale/sales&token=<?php echo $token; ?>';

var filter_recorded = $('input[name=\'filter_recorded\']').val();

if (filter_recorded) {
    url += '&filter_recorded=' + encodeURIComponent(filter_recorded);
}

var filter_travel = $('input[name=\'filter_travel\']').val();

if (filter_travel) {
    url += '&filter_travel=' + encodeURIComponent(filter_travel);
}

var filter_name = $('input[name=\'filter_name\']').val();

if (filter_name) {
  url += '&filter_name=' + encodeURIComponent(filter_name);
}

var filter_customer_group = $('select[name=\'filter_customer_group\']').val();

if (filter_customer_group != '*') {
  url += '&filter_customer_group=' + encodeURIComponent(filter_customer_group);
}

var filter_purpose = $('select[name=\'filter_purpose\']').val();

if (filter_purpose != '*') {
  url += '&filter_purpose=' + encodeURIComponent(filter_purpose);
}

var filter_deceased = $('input[name=\'filter_deceased\']').val();

if (filter_deceased) {
  url += '&filter_deceased=' + encodeURIComponent(filter_deceased);
}

var filter_address = $('input[name=\'filter_address\']').val();

if (filter_address) {
  url += '&filter_address=' + encodeURIComponent(filter_address);
}

var filter_status = $('select[name=\'filter_status\']').val();

if (filter_status != '*') {
  url += '&filter_status=' + encodeURIComponent(filter_status);
}
e.preventDefault();

$('#modal-product').load(url);
});
//--></script>
</div>

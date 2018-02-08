<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <?php if ($filter_status != 1) { ?>
          <a href="<?php echo $insert; ?>" data-toggle="tooltip" title="<?php echo $button_insert; ?>" class="btn btn-primary"><i class="fa fa-plus"><?php echo $button_insert; ?></i></a>
          <button type="submit" form="form-result" formaction="<?php echo $send; ?>" data-toggle="tooltip" title="<?php echo $button_transmission; ?>" class="btn btn-brown600_rsd"><i class="fa fa-paper-plane"><?php echo $button_transmission; ?></i></button>
        <?php } ?>
        <button type="submit" form="form-result" formaction="<?php echo $pdf; ?>" data-toggle="tooltip" title="<?php echo $button_print; ?>" class="btn btn-warning"><i class="fa fa-print"><?php echo $button_print; ?></i></button>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-result').submit() : false;"><i class="fa fa-trash-o"><?php echo $button_delete; ?></i></button>
      </div>
      <h1><?php echo $heading_title; ?></h1>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        <div class="well">
          <div class="row">
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
                <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
              </div>
              <div class="form-group">
                <label class="control-label" for="input-customer_group"><?php echo $entry_customer_group; ?></label>
                <select name="filter_customer_group" id="input-customer-group" class="form-control" />
                <option value="*"></option>
                <?php foreach($customer_groups as $result) { ?>
				          <?php if ($result['id'] == $filter_customer_group) { ?>
	               	 <option value="<?php echo $result['id'];?>" selected="selected"><?php echo $result['name'];?></option>
				          <?php } else { ?>
	               	 <option value="<?php echo $result['id'];?>"><?php echo $result['name'];?></option>
                  <?php } ?>
                <?php } ?>
                </select>
              </div>
			      </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-deceased"><?php echo $entry_deceased; ?></label>
                <input type="text" name="filter_deceased" value="<?php echo $filter_deceased; ?>" placeholder="<?php echo $entry_deceased; ?>" id="input-deceased" class="form-control" />
              </div>
              <div class="form-group">
                <label class="control-label" for="input-address"><?php echo $entry_address; ?></label>
                <input type="text" name="filter_address" value="<?php echo $filter_address; ?>" placeholder="<?php echo $entry_address; ?>" id="input-address" class="form-control" />
              </div>
			     </div>
           <div class="col-sm-3">
              <div class="flatpickr form-group">
                <label class="control-label" for="input-travel"><?php echo $entry_travel; ?></label>
                <div class="flatpickr input-group date"  data-wrap="true" data-clickOpens="false">
                  <input type="text" name="filter_travel" value="<?php echo $filter_travel; ?>" placeholder="<?php echo $entry_travel; ?>" data-format="YYYY-MM-DD" id="input-travel" class="form-control" data-altinput=true data-input />
                  <a class="input-group-addon" data-toggle><i class='fa fa-calendar'></i></a>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label" for="input-name"><?php echo $entry_slip; ?></label>
                <input type="text" name="filter_slip" value="<?php echo $filter_slip; ?>" placeholder="<?php echo $entry_slip; ?>" id="input-slip" class="form-control" />
              </div>
              <!--div class="form-group">
                <label class="control-label" for="input-status"><?php echo $entry_status; ?></label>
                <select name="filter_status" id="input-status" class="form-control">
                  <option value="*"></option>
                  <?php if ($filter_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <?php } ?>
                  <?php if (($filter_status !== null) && !$filter_status) { ?>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select>
              </div -->
            </div>
            <div class="col-sm-3">
              <div class="flatpickr form-group">
                 <label class="control-label" for="input-recorded"><?php echo $entry_recorded; ?></label>
                 <div class="flatpickr input-group date"  data-wrap="true" data-clickOpens="false">
                   <input type="text" name="filter_recorded" value="<?php echo $filter_recorded; ?>" placeholder="<?php echo $entry_recorded; ?>" data-format="YYYY-MM-DD" id="input-recorded" class="form-control" data-altinput=true data-input />
                   <a class="input-group-addon" data-toggle><i class='fa fa-calendar'></i></a>
                 </div>
              </div>
              <div class="form-group">
                <label class="control-label" for="input-purpose"><?php echo $entry_purpose; ?></label>
                <select name="filter_purpose" id="input-purpose" class="form-control" />
                <option value="*"></option>
                <?php foreach($purposes as $result) { ?>
				          <?php if ($result['id'] == $filter_purpose) { ?>
	               	 <option value="<?php echo $result['id'];?>" selected="selected"><?php echo str_replace('料金', '', $result['name']);?></option>
				          <?php } else { ?>
	               	 <option value="<?php echo $result['id'];?>"><?php echo str_replace('料金', '', $result['name']);?></option>
                  <?php } ?>
                <?php } ?>
                </select>
              </div>
             <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
             </div>
          </div>
        </div>
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-result">
          <div class="table-responsive">
            <table class="col-sm-12 table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <!-- 伝票No. -->
                  <td class="text-left"><?php if ($sort == 'slip') { ?>
                    <a href="<?php echo $sort_slip; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_slip; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_slip; ?>"><?php echo $column_slip; ?></a>
                    <?php } ?>
                  </td>
                  <!-- 計上日 -->
                  <td class="text-left"><?php if ($sort == 'recorded') { ?>
                    <a href="<?php echo $sort_recorded; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_recorded; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_recorded; ?>"><?php echo $column_recorded; ?></a>
                    <?php } ?>
                  </td>
                  <!-- 運航日 -->
                  <td class="text-left"><?php if ($sort == 'travel') { ?>
                    <a href="<?php echo $sort_travel; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_travel; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_travel; ?>"><?php echo $column_travel; ?></a>
                    <?php } ?>
                  </td>
                  <!-- -->
                  <!-- 目的 -->
                  <td class="text-left"><?php if ($sort == 'purpose') { ?>
                    <a href="<?php echo $sort_purpose; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_purpose; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_purpose; ?>"><?php echo $column_purpose; ?></a>
                    <?php } ?>
                  </td>
                  <!-- -->
                  <td class="text-left"><?php if ($sort == 'deceased') { ?>
                    <a href="<?php echo $sort_deceased; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_deceased; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_deceased; ?>"><?php echo $column_deceased; ?></a>
                    <?php } ?>
                  </td>
                  <td class="text-left"><?php if ($sort == 'p.name') { ?>
                    <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                    <?php } ?>
                  </td>
                  <td class="text-left"><?php if ($sort == 'customer_group') { ?>
                    <a href="<?php echo $sort_customer_group; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_customer_group; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_customer_group; ?>"><?php echo $column_customer_group; ?></a>
                    <?php } ?>
                  </td>
                  <td class="text-left"><?php if ($sort == 'address') { ?>
                    <a href="<?php echo $sort_address; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_address; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_address; ?>"><?php echo $column_address; ?></a>
                    <?php } ?>
                  </td>
                  <td class="text-center">
                      <?php echo $column_total; ?>
                  </td>
                  <td class="text-center"><?php if ($sort == 'status') { ?>
                    <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                    <?php } ?>
                  </td>
                  <td class="text-center"><?php echo $column_print; ?></td>
                  <td class="text-center"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($sales) { ?>
                <?php foreach ($sales as $result) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($result['id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $result['id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $result['id']; ?>" />
                    <?php } ?></td>
                  <td class="text-left"><?php echo $result['slip']; ?></td>
                  <td class="text-left"><?php echo $result['recorded']; ?></td>
                  <td class="text-left"><?php echo $result['travel']; ?></td>
                  <td class="text-left"><?php echo $result['purpose']; ?></td>
                  <td class="text-left"><?php echo $result['deceased']; ?></td>
                  <td class="text-left"><?php echo $result['name']; ?></td>
                  <td class="text-left"><?php echo $result['customer_group']; ?></td>
                  <td class="text-left"><?php echo $result['address']; ?></td>
                  <td class="text-right"><?php echo $result['total']; ?></td>
                  <td class="text-center"><?php echo $result['status']; ?></td>
                  <td class="text-center"><?php echo $result['print']; ?></td>
                  <td class="text-center"><a href="<?php echo $result['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="13"><?php echo $text_no_results; ?></td>
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
    </div>
  </div>
  <script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	var url = 'index.php?route=sale/sales&token=<?php echo $token; ?>' + '&filter_status=<?php echo $filter_status; ?>';

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

	var filter_slip = $('input[name=\'filter_slip\']').val();

	if (filter_slip) {
		url += '&filter_slip=' + encodeURIComponent(filter_slip);
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
/*
	var filter_status = $('select[name=\'filter_status\']').val();

	if (filter_status != '*') {
		url += '&filter_status=' + encodeURIComponent(filter_status);
	}
*/
	location = url;
});
//--></script>
<script><!--//
  const config = {
    locale: {
      weekdays: {
          shorthand: ["日", "月", "火", "水", "木", "金", "土"],
          longhand: ["日曜日", "月曜日", "火曜日", "水曜日", "木曜日", "金曜日", "土曜日"]
      },
      months: {
          shorthand: [
              "1月",
              "2月",
              "3月",
              "4月",
              "5月",
              "6月",
              "7月",
              "8月",
              "9月",
              "10月",
              "11月",
              "12月",
          ],
          longhand: [
              "1月",
              "2月",
              "3月",
              "4月",
              "5月",
              "6月",
              "7月",
              "8月",
              "9月",
              "10月",
              "11月",
              "12月",
          ]
      },
    },
    allowInput: true,
  }
  flatpickr('.flatpickr', config);
//--></script>
<?php echo $footer; ?>

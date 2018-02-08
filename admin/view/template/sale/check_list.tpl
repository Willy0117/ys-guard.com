<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
          <div class="pull-right"><a href="<?php echo $insert; ?>" data-toggle="tooltip" title="<?php echo $button_insert; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
          <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-check').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-customer-group"><?php echo $entry_customer_group; ?></label>
                <select name="filter_customer_group_id" id="input-customer-group" class="form-control">
                  <option value="*"></option>
                  <?php foreach ($customer_groups as $customer_group) { ?>
                  <?php if ($customer_group['customer_group_id'] == $filter_customer_group_id) { ?>
                  <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-project"><?php echo $entry_project; ?></label>
                <select name="filter_project_id" id="input-project" class="form-control">
                  <option value="*"></option>
                  <?php foreach ($projects as $project) { ?>
                  <?php if ($project['project_id'] == $filter_project_id) { ?>
                  <option value="<?php echo $project['project_id']; ?>" selected="selected"><?php echo $project['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $project['project_id']; ?>"><?php echo $project['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group">
                  <label class="control-label" for="input-customer"><?php echo $entry_customer; ?></label>
                  <input type="text" name="filter_customer" value="<?php echo $filter_customer; ?>" placeholder="<?php echo $entry_customer; ?>" id="input-customer" class="form-control" />
                </div>
            </div>

            <div class="form-group">
               <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
		        </div>

          </div>
        </div>
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-check">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>

                  <td class="text-left"><?php if ($sort == 'project_id') { ?>
                    <a href="<?php echo $sort_project; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_project; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_project; ?>"><?php echo $column_project; ?></a>
                    <?php } ?></td>

                    <td class="text-left"><?php if ($sort == 'name') { ?>
                    <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                    <?php } ?></td>

                  <td class="text-left"><?php if ($sort == 'customer_group_id') { ?>
                    <a href="<?php echo $sort_customer_group; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_customer_group; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_customer_group; ?>"><?php echo $column_customer_group; ?></a>
                    <?php } ?></td>

                  <td class="text-left"><?php if ($sort == 'customer') { ?>
                    <a href="<?php echo $sort_customer; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_customer; ?></a>
                  <?php } else { ?>
                      <a href="<?php echo $sort_customer; ?>"><?php echo $column_customer; ?></a>
                  <?php } ?></td>

                  <td class="text-left"><?php if ($sort == 'date_added') { ?>
                      <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
                  <?php } else { ?>
                      <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
                  <?php } ?></td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($checks) { ?>
                <?php foreach ($checks as $check) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($check['check_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $check['check_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $check['check_id']; ?>" />
                    <?php } ?>
                  </td>
                  <td class="text-left"><?php echo $check['project']; ?></td>
                   <td class="text-left"><?php echo $check['name']; ?></td>
                  <td class="text-left"><?php echo $check['customer_group']; ?></td>
                  <td class="text-left"><?php echo $check['customer']; ?></td>
                  <td class="text-left"><?php echo $check['date_added']; ?></td>
                  <td class="text-right">
                     <a href="<?php echo $check['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="8"><?php echo $text_no_results; ?></td>
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
	url = 'index.php?route=sale/check&token=<?php echo $token; ?>';

	var filter_project_id = $('select[name=\'filter_project_id\']').val();

	if (filter_project_id != '*') {
		url += '&filter_project_id=' + encodeURIComponent(filter_project_id);
	}

	var filter_name = $('input[name=\'filter_name\']').val();

	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}

	var filter_customer_group_id = $('select[name=\'filter_customer_group_id\']').val();

	if (filter_customer_group_id != '*') {
		url += '&filter_customer_group_id=' + encodeURIComponent(filter_customer_group_id);
	}

  var filter_customer = $('input[name=\'filter_customer\']').val();

  	if (filter_customer) {
  		url += '&filter_customer=' + encodeURIComponent(filter_customer);
  	}

	location = url;
});
//--></script>
</div>
<?php echo $footer; ?>

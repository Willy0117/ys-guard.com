<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $insert; ?>" data-toggle="tooltip" title="<?php echo $button_insert; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-latenight').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-relation">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-left"><?php if ($sort == 'name') { ?>
                    <a href="<?php echo $sort_timeindex; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_timeindex; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_timeindex; ?>"><?php echo $column_timeindex; ?></a>
                    <?php } ?>
                  </td>
                  <td class="text-right"><?php if ($sort == 'price') { ?>
                    <a href="<?php echo $sort_price; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_price; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_price; ?>"><?php echo $column_price; ?></a>
                    <?php } ?>
                  </td>
                  <td class="text-right"><?php if ($sort == 'invoice') { ?>
                    <a href="<?php echo $sort_invoice; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_invoice; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_invoice; ?>"><?php echo $column_invoice; ?></a>
                    <?php } ?>
                  </td>
                  <td class="text-right"><?php if ($sort == 'tax') { ?>
                    <a href="<?php echo $sort_tax; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_tax; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_tax; ?>"><?php echo $column_tax; ?></a>
                    <?php } ?>
                  </td>
                  <td class="text-center"><?php if ($sort == 'date_from') { ?>
                    <a href="<?php echo $sort_date_from; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_from; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_date_from; ?>"><?php echo $column_date_from; ?></a>
                    <?php } ?>
                  </td>
                  <td class="text-center"><?php if ($sort == 'date_to') { ?>
                    <a href="<?php echo $sort_date_to; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_to; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_date_to; ?>"><?php echo $column_date_to; ?></a>
                    <?php } ?>
                  </td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($latenights) { ?>
                <?php foreach ($latenights as $result) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($result['id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $result['id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $result['id']; ?>" />
                    <?php } ?></td>
                  <td class="text-left"><?php echo $result['timeindex']; ?></td>
                  <td class="text-right"><?php echo $result['price']; ?></td>
                  <td class="text-left"><?php echo $result['invoice']; ?></td>
                  <td class="text-left"><?php echo $result['tax']; ?></td>
                  <td class="text-right"><?php echo $result['date_from']; ?></td>
                  <td class="text-right"><?php echo $result['date_to']; ?></td>
                  <td class="text-right"><a href="<?php echo $result['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="6"><?php echo $text_no_results; ?></td>
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
</div>
<?php echo $footer; ?>

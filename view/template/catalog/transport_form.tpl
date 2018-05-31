<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-temple" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-temple" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label"><?php echo $entry_distance; ?></label>
            <div class="col-sm-10">
              <div class="input-group">
                <input type="text" name="distance" value="<?php echo $distance; ?>" placeholder="<?php echo $entry_distance; ?>" class="form-control" />
              </div>
              <?php if ($error_distance) { ?>
              <div class="text-danger"><?php echo $error_distance; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-price"><?php echo $entry_price; ?></label>
            <div class="col-sm-10">
              <input type="text" name="price" value="<?php echo $price; ?>" placeholder="<?php echo $entry_price; ?>" id="input-price" class="form-control" />
            </div>
          </div>

          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-invoice"><?php echo $entry_invoice; ?></label>
            <div class="col-sm-10">
              <input type="text" name="invoice" value="<?php echo $invoice; ?>" placeholder="<?php echo $entry_invoice; ?>" id="input-invoice" class="form-control" />
            </div>
          </div>

          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-tax"><?php echo $entry_tax; ?></label>
            <div class="col-sm-10">
              <select name="tax_id" id="input-tax" class="form-control">
                <?php if ($taxes) { ?>
                  <?php foreach($taxes as $result) { ?>
                      <?php if ($result['id'] == $tax_id) { ?>
                        <option value="<?php echo $result['id'];?>" selected="selected"><?php echo $result['title'];?></option>
                      <?php } else { ?>
                        <option value="<?php echo $result['id'];?>"><?php echo $result['title'];?></option>
                      <?php } ?>
                  <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
            
            
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-date_from"><?php echo $entry_date_from; ?></label>
            <div class="col-sm-10">
                <div class="flatpickr input-group date" data-wrap="true" data-clickOpens="false">
                    <input type="text" name="date_from" value="<?php echo $date_from; ?>" placeholder="<?php echo $entry_date_from; ?>" id="input-date_from" class="form-control" data-format="YYYY-MM-DD"  data-altinput=true data-input />
                    <a class="input-group-addon" data-toggle><i class='fa fa-calendar'></i></a>    
                </div>
            </div>    
          </div>
            
          <div class="form-group">
             <label class="col-sm-2 control-label" for="input-date_to"><?php echo $entry_date_to; ?></label>
             <div class="col-sm-10">
                 <div class="flatpickr input-group date" data-wrap="true" data-clickOpens="false">
                     <input type="text" name="date_to" value="<?php echo $date_to; ?>" placeholder="<?php echo $entry_date_to; ?>" id="input-date_to" class="form-control" data-format="YYYY-MM-DD"  data-altinput=true data-input />
                     <a class="input-group-addon" data-toggle><i class='fa fa-calendar'></i></a>        
                 </div>
             </div>
           </div>    

        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" >
    //エンターでのsubmitを禁止
    $(document).ready(function () {
        $('input,textarea[readonly]').not($('input[type="button"],input[type="submit"]')).keypress(function (e) {
            if (!e) var e = window.event;
            if (e.keyCode == 13)
                return false;
        });
    });
 const config = {
		//maxDate: "today",
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
</script>
<?php echo $footer; ?>

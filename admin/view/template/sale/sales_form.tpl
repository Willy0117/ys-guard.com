<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <?php if ($filter_status == 0) { ?>
          <button type="submit" form="form-product" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"><?php echo $button_save; ?></i></button>
        <?php } ?>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"><?php echo $button_cancel; ?></i></a>
        <button type="submit" form="form-product" formaction="<?php echo $excel; ?>" data-toggle="tooltip" title="<?php echo $button_excel; ?>" class="btn btn-success"><i class="fa fa-file-excel-o"><?php echo $button_excel; ?></i></button>
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
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-product" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
            <li><a href="#tab-sales" data-toggle="tab"><?php echo $tab_sales; ?></a></li>
            <li><a href="#tab-inspection" data-toggle="tab"><?php echo $tab_inspection; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <!-- 得意先-->
              <div class="col-sm-12">
                 <div class="form-group col-sm-8 required">
                  <label class="col-sm-2 control-label" for="input-customer_group"><?php echo $entry_customer_group; ?></label>
                  <div class="col-sm-10">
                    <select name="customer_group" value="" placeholder="<?php echo $entry_customer_group; ?>" id="customer_group" class="form-control" />
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
                <!-- 運転者 -->
                <div class="form-group col-sm-4 required">
                  <label class="col-sm-4 control-label" for="input-driver"><?php echo $entry_driver; ?></label>
                  <div class="col-sm-8">
                    <select name="driver" value="" placeholder="<?php echo $entry_driver; ?>" id="driver" class="form-control" />
                    <option value="*"></option>
                      <?php foreach($users as $result) { ?>
                      <?php if ($result['user_id'] == $driver) { ?>
                        <option value="<?php echo $result['user_id'];?>" selected="selected"><?php echo $result['firstname'] . ' ' . $result['lastname'];?></option>
                      <?php } else { ?>
                        <option value="<?php echo $result['user_id'];?>"><?php echo $result['firstname'] . ' ' . $result['lastname'];?></option>
                      <?php } ?>
                    <?php } ?>
                    </select>
                    <?php if ($error_driver) { ?>
                        <div class="text-danger"><?php echo $error_driver; ?></div>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <!-- 目的-->
              <div class="col-sm-12">
                <!-- 目的-->
               <div class="form-group col-sm-8 required">
                <label class="col-sm-2 control-label" for="input-purpose"><?php echo $entry_purpose; ?></label>
                <div class="col-sm-10">
                  <select name="purpose" value="" placeholder="<?php echo $entry_purpose; ?>" id="purpose" class="form-control" />
                  <?php foreach ($purposes as $value) { ?>
                    <?php $replace = str_replace('料金', '', $value['name']); ?>
                    <?php if ($value['id'] == $purpose) { ?>
                      <option value="<?php echo $value['id'];?>" selected="selected"><?php echo $replace;?></option>
                    <?php } else { ?>
                      <option value="<?php echo $value['id'];?>"><?php echo $replace;?></option>
                    <?php } ?>
                 <?php } ?>
                  </select>
                  <?php if ($error_purpose) { ?>
                      <div class="text-danger"><?php echo $error_purpose; ?></div>
                  <?php } ?>
                </div>
              </div>
            　</div>
<!-- 運航日・曜日・運転者 -->
            <div class="col-sm-12">
              <!-- 運航日 -->
                <div class="form-group col-sm-4 col-xs-4 required">
                    <label class="col-sm-4 control-label" for="input-travel-date"><?php echo $entry_travel; ?></label>
                    <div class="col-sm-8">
                    <div class="flatpickr input-group date"  data-wrap="true" data-clickOpens="false">
                      <input type="text" name="travel" value="<?php echo $travel; ?>" placeholder="<?php echo $entry_travel; ?>" data-format="YYYY-MM-DD" id="input-travel" class="form-control" data-altinput=true data-input />
                      <a class="input-group-addon" data-toggle><i class='fa fa-calendar'></i></a>
                      <?php if ($error_travel) { ?>
                        <div class="text-danger"><?php echo $error_travel; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                </div>
            <!-- 曜日 -->
                <div class="form-group col-sm-2 col-xs-2">
                  <div class="col-sm-12">
                   <select name="weekday" id="input-weather" class="form-control">
                    <?php foreach ($weekdays as $key => $value) { ?>
                      <?php if ($key == $weekday) { ?>
                        <option value="<?php echo $key;?>" selected="selected"><?php echo $value;?></option>
                      <?php } else { ?>
                        <option value="<?php echo $key;?>"><?php echo $value;?></option>
                      <?php } ?>
                   <?php } ?>
                   </select>
                  </div>
                </div>
            <!-- 天候 -->
                <div class="form-group col-sm-4 col-xs-4 required">
                    <label class="col-sm-4 control-label" for="input-weather-date"><?php echo $entry_weather; ?></label>
                    <div class="col-sm-8">
                      <input type="text" name="weather" value="<?php echo $weather; ?>" placeholder="<?php echo $entry_weather; ?>" id="input-weather" class="form-control" />
                      <?php if ($error_weather) { ?>
                        <div class="text-danger"><?php echo $error_weather; ?></div>
                      <?php } ?>
                    </div>
                </div>
            </div>
            <!-- 計上日 -->
            <div class="col-sm-12">
              <!-- 計上日 -->
              <div class="form-group col-sm-4 col-xs-4 required">
                <label class="col-sm-4 control-label" for="input-recorded-date"><?php echo $entry_recorded; ?></label>
                <div class="col-sm-8">
                  <div class="flatpickr input-group date"  data-wrap="true" data-clickOpens="false">
                    <input type="text" name="recorded" value="<?php echo $recorded; ?>" placeholder="<?php echo $entry_recorded; ?>" data-format="YYYY-MM-DD" id="input-recorded" class="form-control" data-altinput=true data-input />
                    <a class="input-group-addon" data-toggle><i class='fa fa-calendar'></i></a>
                    <?php if ($error_recorded) { ?>
                      <div class="text-danger"><?php echo $error_recorded; ?></div>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>

            <!-- 喪主名 故人名　 -->
            <div class="col-sm-12">
                <!-- 故人名 -->
                <div class="col-sm-8 form-group required">
                  <label class="col-sm-2 control-label" for="input-deceased"><?php echo $entry_deceased; ?></label>
                  <div class="col-sm-8">
                    <input type="text" name="deceased" value="<?php echo $deceased; ?>" placeholder="<?php echo $entry_deceased; ?>" id="input-deceased" class="form-control" />
                    <?php if ($error_deceased) { ?>
                      <div class="text-danger"><?php echo $error_deceased; ?></div>
                    <?php } ?>
                  </div>
               </div>
            </div>
            <!-- 喪主名 故人名　 -->
            <div class="col-sm-12">
              <!-- 故人名 -->
              <div class="col-sm-8 form-group required">
                <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
                  <?php if ($error_name) { ?>
                    <div class="text-danger"><?php echo $error_name; ?></div>
                  <?php } ?>
                </div>
             </div>
            </div>

           <!-- 住所 -->
            <div class="col-sm-12">
                <div class="form-group col-sm-8  required">
                      <label class="col-sm-2 control-label" for="input-address"><?php echo $entry_address; ?></label>
                      <div class="col-sm-10">
                        <input type="text" name="address" value="<?php echo $address; ?>" placeholder="<?php echo $entry_address; ?>" id="input-address" class="form-control" />
                        <?php if ($error_address) { ?>
                          <div class="text-danger"><?php echo $error_address; ?></div>
                        <?php } ?>
                      </div>
                </div>

                <!-- 電話 -->
             　	 <div class="col-sm-4 form-group required">
                   <label class="col-sm-4 control-label" for="input-telphone"><?php echo $entry_telphone; ?></label>
                   <div class="col-sm-8">
                     <input type="text" name="telphone" value="<?php echo $telphone; ?>" placeholder="<?php echo $entry_telphone; ?>" id="input-telphone" class="form-control" />
                     <?php if ($error_telphone) { ?>
                       <div class="text-danger"><?php echo $error_telphone; ?></div>
                     <?php } ?>
                   </div>
                </div>

              </div>
              <!-- メモ -->
              <div class="col-sm-12">
                <!-- memo -->
                <div class="form-group col-sm-8">
                  <label class="col-sm-2 control-label" for="input-sect"><?php echo $entry_comment; ?></label>
                  <div class="col-sm-8">
                    <input name="comment" value="<?php echo $comment;?>" placeholder="<?php echo $entry_comment; ?>" id="memo" class="form-control" />
                  </div>
                </div>
              </div>
              <!-- 宗派・寺・神社 -->
              <div class="col-sm-12">
                <!-- 宗派 -->
                <div class="form-group col-sm-6">
                  <label class="col-sm-3 control-label" for="input-sect"><?php echo $entry_sect; ?></label>
                  <div class="col-sm-8">
                    <select name="sect" value="" placeholder="<?php echo $entry_sect; ?>" id="temple" class="form-control" />
                      <option value="*"></option>
                      <?php foreach($sects as $result) { ?>
                        <?php if ($result['id'] == $sect) { ?>
                          <option value="<?php echo $result['id'];?>" selected="selected"><?php echo $result['name'];?></option>
                        <?php } else { ?>
                          <option value="<?php echo $result['id'];?>"><?php echo $result['name'];?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                    <?php if ($error_sect) { ?>
                      <div class="text-danger"><?php echo $error_sect; ?></div>
                    <?php } ?>
                  </div>
                </div>
                <!-- 寺・神社-->
                <div class="form-group col-sm-6">
                  <label class="col-sm-3 control-label" for="input-temple"><?php echo $entry_temple; ?></label>
                  <div class="col-sm-8">
                    <select name="temple" value="" placeholder="<?php echo $entry_temple; ?>" id="temple" class="form-control" />
                      <option value="*"></option>
                      <?php foreach($temples as $result) { ?>
                        <?php if ($result['id'] == $temple) { ?>
                          <option value="<?php echo $result['id'];?>" selected="selected"><?php echo $result['name'];?></option>
                        <?php } else { ?>
                          <option value="<?php echo $result['id'];?>"><?php echo $result['name'];?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                    <?php if ($error_temple) { ?>
                      <div class="text-danger"><?php echo $error_temple; ?></div>
                    <?php } ?>
                  </div>
                </div>
              </div>

            </div>
          <!-- 運行情報・売り上げ -->
            <div class="tab-pane" id="tab-sales">
              <!-- 使用車両、高速料金-->
              <div class="col-sm-12">
                <!-- 使用車両-->
                <div class="form-group col-sm-8">
                  <label class="col-sm-2 control-label" for="input-vehicle"><?php echo $entry_vehicle; ?></label>
                  <div class="col-sm-10">
                    <select name="vehicle" value="" placeholder="<?php echo $entry_vehicle; ?>" id="vehicle" class="form-control" />
                  　  <option value="*"></option>
                      <?php foreach($vehicles as $result) { ?>
                      <?php if ($result['id'] == $vehicle) { ?>
                      <option value="<?php echo $result['id'];?>" selected="selected"><?php echo $result['name'];?></option>
                      <?php } else { ?>
                      <option value="<?php echo $result['id'];?>"><?php echo $result['name'];?></option>
                      <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <!-- 高速料金-->
                <div class="form-group col-sm-4">
                 <label class="col-sm-4 control-label" for="input-highway"><?php echo $entry_highway; ?></label>
                 <div class="col-sm-8">
                  <input name="highway" value="<?php echo $highway;?>" placeholder="<?php echo $entry_highway; ?>" id="highway" class="form-control" />
                 </div>
                </div>
              </div>
              <div class="form-group ">
               <label class="col-sm-1 control-label"><?php echo $entry_travel; ?></label>
               <div class="col-sm-11 table-responsive">
                 <table class="col-sm-12 table">
                   <thead>
                     <tr>
                       <th class="col-sm-3"><?php echo $entry_place; ?></th>
                       <!-- th class="col-sm-2"><?php echo $entry_start; ?></th -->
                       <th class="col-sm-2"><?php echo $entry_end; ?></th>
                       <th class="col-sm-1"><?php echo $entry_metar; ?></th>
                       <th class="col-sm-1"><?php echo $entry_distance; ?></th>
                       <th class="col-sm-1"><?php echo $entry_time; ?></th>
                       <th class="col-sm-2"></th>
                     </tr>
                   </thead>
                   <tbody id="timeschdule">
                     <?php
                      if ($mileage) {
//                        print_r($mileage)
                        $i=0;
                       foreach ($mileage as $key => $result) { ?>
                         <input type="hidden" name="mileage[<?php echo $i;?>][date]"  value="<?php echo $result['date']; ?>" placeholder="" data-format="YYYY-MM-DD" class="setdate form-control" data-altinput=true data-input />
                         <tr>
                           <td>
                             <input type="text" name="mileage[<?php echo $i;?>][via]" value="<?php echo $result['via']; ?>" placeholder="<?php echo $entry_place; ?>" id="input-via" class="form-control" />
                           </td>
                         <!-- td>
                           <div class="flatpickr input-group date" data-wrap="true" data-clickOpens="false">
                           <input type="text" name="mileage[<?php echo $i;?>][date]"  value="<?php echo $result['date']; ?>" placeholder="" data-format="YYYY-MM-DD" class="setdate form-control" data-altinput=true data-input />
                           <a class="input-group-addon" data-toggle><i class='fa fa-calendar'></i></a>
                           </div>
                         </td -->
                          <td>
                            <div class="timepickr input-group date" data-wrap="true" data-clickOpens="false">
                              <input type="text" name="mileage[<?php echo $i;?>][time]"  value="<?php echo $result['time']; ?>" placeholder="" data-format="YYYY-MM-DD H:i:s" class="settime form-control" data-altinput=true data-input />
                              <a class="input-group-addon" data-toggle><i class='fa fa-calendar'></i></a>
                            </div>
                          </td>
                          <td>
                            <input type="text" name="mileage[<?php echo $i;?>][metar]" value="<?php echo $result['metar']; ?>" placeholder="<?php echo $entry_metar; ?>" class="metar form-control" />
                          </td>
                          <td>
                            <input type="text" name="mileage[<?php echo $i;?>][mileage]" value="<?php echo $result['mileage']; ?>" placeholder="<?php echo $entry_mileage; ?>" class="mileage form-control" />
                          </td>
                          <td>
                            <input type="text" name="mileage[<?php echo $i;?>][wait]" value="<?php echo $result['wait']; ?>" placeholder="<?php echo $entry_time; ?>" class="waittime form-control" />
                          </td>
                          <td><!-- div class="btn-group btn-group-sm" role="group">
                            <?php if ($i == 4 || $i == 5 ) { ?>
                              <button type="button" class="calculator btn btn-default" title="待機時間、深夜時間割増を計算する"><i class="fa fa-calculator"></i></button>
                            <?php } ?>
                          </div -->
                          </td>
                        </tr>
                     <?php $i++;
                        }
                      } ?>
                   </tbody>
                   <tfoot >
                   </tfoot>
                 </table>
               </div>
            </div>
            <div class="form-group ">
              <label class="col-sm-1 control-label"><?php echo $entry_sales; ?></label>
              <div class="col-sm-11 table-responsive">
                <table class="col-sm-12 table">
                  <thead>
                    <tr>
                      <th class="col-sm-3"><?php echo $entry_product; ?></th>
                      <th class="col-sm-2"><?php echo $entry_summary; ?></th>
                      <th class="col-sm-1"><?php echo $entry_quantity; ?></th>
                      <th class="col-sm-1"><?php echo $entry_price; ?></th>
                      <th class="col-sm-1"><?php echo $entry_amount; ?></th>
                      <th class="col-sm-1"><?php echo $entry_tax; ?></th>
                      <th class="col-sm-1"></th>
                      <th class="col-sm-2"></th>
                    </tr>
                  </thead>
                  <tbody id="base">
                    <input type="hidden" name="idx" value="4" >
                    <?php if ($prices) {
//print_r($prices);
                      $i = 0;
                      foreach ($prices as $result) { ?>
                        <?php if ($i == 4) { ?>
                        <tr>
                          <td class="text-left">
                            <!-- div class="popover-content">
                              <button type="button" id="button-image" class="btn btn-primary"><i class="fa fa-cart-plus"></i></button>
                              &nbsp;<button type="button" id="button-clear" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
                            </div -->
                          </td>
                          <td colspan="3"></td>

                          <td>
                            <input readonly="readonly" type="text" name="total1" value="<?php echo $total1; ?>" placeholder="<?php echo $entry_amount; ?>" class="total1 form-control" />
                          </td>
                          <td>
                            <input type="text" name="tax1" value="<?php echo $tax1; ?>" placeholder="<?php echo $entry_tax; ?>" class="tax1 form-control" />
                          </td>
                        </tr>
                        <?php } ?>
                        <tr>
                          <input type="hidden" name="prices[<?php echo $i;?>][id]" value="<?php echo $result['id']; ?>" class="id form-control" />
                          <input type="hidden" name="prices[<?php echo $i;?>][model]" value="<?php echo $result['model']; ?>" class="model form-control" />
                          <input type="hidden" name="prices[<?php echo $i;?>][tax_id]" value="<?php echo $result['tax_id']; ?>" class="tax_id form-control" />
                          <input type="hidden" name="prices[<?php echo $i;?>][invoice]" value="<?php echo $result['invoice']; ?>" class="invoice form-control" />
                          <td>
                            <input  readonly="readonly" type="text" name="prices[<?php echo $i;?>][name]" value="<?php echo $result['name']; ?>" placeholder="<?php echo $entry_product; ?>" class="name form-control" />
                          </td>
                          <td>
                            <input type="text" name="prices[<?php echo $i;?>][summary]" value="<?php echo $result['summary']; ?>" placeholder="<?php echo $entry_summary; ?>" class="summary form-control" />
                          </td>
                          <td>
                            <input type="number" name="prices[<?php echo $i;?>][quantity]" value="<?php echo $result['quantity']; ?>" class="quantity form-control" />
                          </td>
                          <td>
                            <input type="number" name="prices[<?php echo $i;?>][unit_price]" value="<?php echo $result['unit_price']; ?>" placeholder="<?php echo $entry_price; ?>" class="price form-control" />
                          </td>
                          <td>
                            <input readonly="readonly" type="text" name="prices[<?php echo $i;?>][amount]" value="<?php echo $result['amount']; ?>" placeholder="<?php echo $entry_amount; ?>" class="amount form-control" />
                          </td>
                          <td>
                            <input type="text" name="prices[<?php echo $i;?>][tax]" value="<?php echo $result['tax']; ?>" placeholder="<?php echo $entry_tax; ?>" class="tax form-control" />
                          </td>
                          <td>
                            <?php if ($i > 2 ) { ?>
                            <div class="btn-group btn-group-sm" role="group">
                              <button type="button" class="plus btn btn-primary"><i class="fa fa-plus"></i></button>
                              <button type="button" class="minus btn btn-default"><i class="fa fa-minus"></i></button>
                            </div>
                            <?php } ?>
                          </td>
                      </tr>
                    <?php $i++;
                      }
                    } ?>
                  </tbody>
                    <tr>
                      <td colspan="4">小計</td>
                      <td>
                        <input readonly="readonly" type="text" name="total2" value="<?php echo $total2; ?>" placeholder="<?php echo $entry_amount; ?>" class="total2 form-control" />
                      </td>
                      <td>
                        <input type="text" name="tax2" value="<?php echo $tax2; ?>" placeholder="<?php echo $entry_tax; ?>" class="tax2 form-control" />
                      </td>
                    </tr>
                  <tfoot >
                    <tr>
                      <td><!--// 行追加はしない
                        <button class="addList btn btn-primary" type="button" title="<?php echo $text_plus; ?>"><i class="fa fa-plus"></i></button>
                        <button class="removeList btn btn-default" type="button" title="<?php echo $text_minus; ?>"><i class="fa fa-minus"></i></button>
                      //--></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
           </div>
          </div>
          <!-- 始業点検・服装点検 -->
          <div class="tab-pane" id="tab-inspection">
            <div class="form-group ">
              <label class="col-sm-2 control-label"><?php echo $entry_inspection; ?></label>
              <div class="col-sm-10">
                <!-- 健康状態 -->
                <div class="form-group col-sm-12">
                <?php foreach($inspections as $result) {?>
                  <div class="form-group col-sm-12">
                   <label class="col-sm-2 control-label" for="input-health"><?php echo $result['name']; ?></label>
                   <div class="col-sm-10">
                     <td class="text-center">
                       <?php if (in_array($result['id'], $selected)) { ?>
                       <input type="checkbox" name="selected[]" data-toggle="toggle" value="<?php echo $result['id']; ?>" checked="checked" />
                       <?php } else { ?>
                       <input type="checkbox" name="selected[]" data-toggle="toggle" value="<?php echo $result['id']; ?>" />
                       <?php } ?></td>
                  </div>
                </div>
                <?php } ?>
                <div>
                </div>
              </div>
            </div>
          </div><!-- -->
        </form>
      </div>
    </div>
  </div>
  <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
  <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<script type="text/javascript"><!--
var taxes = <?php echo json_encode($taxes, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;

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
  /*

  */
  $(document).on("click", ".calculator", function () {
    var index = $('.calculator').index(this);
    switch (index) {
      case 0:
        var time1 = $('.settime').eq(3).val() + ":00";
        var time2 = $('.settime').eq(4).val() + ":00";
        times1 = time1.split(':');
        times2 = time2.split(':');
        if ( times1[0] > times2[0] ) time2 = (parseInt(times2[0])+24)+":"+times2[1]+":"+times2[2];
        console.log(time1,time2);
        var waittime = timeMath.sub(time2,time1) - 30*60;
        if ( waittime<0 ) waittime = 0;
        $('.waittime').eq(4).val(waittime/60);
        var travel = $( 'input[name="travel"]' ).val();  // 日にちの取得
        var data = <?php echo json_encode($wait, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
        var time = waittime/60;
        console.log(time,(time+15)/30);
        var id = data[0]['id'];
        var seturl = 'index.php?route=catalog/product/getProductPrice&token=' + getURLVar('token') + '&id=' + id + '&travel=' + travel;
        $.ajax({
          url: seturl,
          type: "POST",
          //Ajax通信が成功した場合に呼び出されるメソッド
          success: function(data, dataType){
            var quantity =  Math.floor((time+15)/30);
            var i = 2;
            $('.quantity').eq(i).val( quantity );
            setcolumn(i,data);
          }
        })
        break;
      case 1: // 深夜時間からの単価計算
        var time1 = $('.settime').eq(0).val() + ":00";
        var time2 = $('.settime').eq(5).val() + ":00";
        times1 = time1.split(':');
        times2 = time2.split(':');
        if ( times1[0] > -1 && times1[0]<6 ) time1 = (parseInt(times1[0])+24)+":"+times1[1]+":"+times1[2];
        if ( times2[0] > -1 && times2[0]<6 ) time2 = (parseInt(times2[0])+24)+":"+times2[1]+":"+times2[2];
        times1 = time1.split(':');
        times2 = time2.split(':');
        if ( times1[0] > times2[0] ) time2 = (parseInt(times2[0])+24)+":"+times2[1]+":"+times2[2];
        times1 = time1.split(':');
        times2 = time2.split(':');
        if ( times1[0] < 22 ) time1 = "22:00:00";
        if ( times2[0] > 27 ) time2 = "27:00:00";
        console.log(time1,time2);
        var nighttime = timeMath.sub(time2,time1);
        if ( nighttime<0 ) nighttime = 0;
        var travel = $( 'input[name="travel"]' ).val();  // 日にちの取得
        var data = <?php echo json_encode($wait, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
        var sctime = nighttime/60;　// 分に
        time = Math.floor((sctime+15)/30)*30;
        console.log(time);
        if (time <= 0) {
          var i = 1;
          $('.summary').eq(i).val( null );
          $('.price').eq(i).val( 0 );
          $('.amount').eq(i).val( 0 );
          var tax_id=1;// 消費税８％に固定
          $('.tax').eq(i).val( 0 );
          $('.tax_id').eq(i).val( tax_id );
          $('.invoice').eq(i).val( 0 );
          /* トータル再計算*/
          recalc();
          return;
        }
        var id = data[0]['id'];
        var seturl = 'index.php?route=catalog/latenight/getLateNightPrice&token=' + getURLVar('token') + '&minute=' + time + '&travel=' + travel;
        $.ajax({
          url: seturl,
          type: "POST",
        //Ajax通信が成功した場合に呼び出されるメソッド
          success: function(data, dataType){
            console.log(data);
            var i = 1;
            $('.summary').eq(i).val( sctime + " 分" );
            var quantity = $('.quantity').eq(i).val();
            $('.price').eq(i).val( Math.round(data['price']) );
            $('.amount').eq(i).val( Math.round(data['price'] * quantity) );
            var tax_id = data['tax_id'];
            if (　tax_id < 1 ) tax_id=1;// 消費税８％に固定
            arr = jQuery.grep(taxes, function(value, index ) {
              return (value.id == tax_id );
            });
            var tax = Math.round(data['price'] * arr[0]['rate'] * quantity );
            $('.tax').eq(i).val( tax );
            $('.tax_id').eq(i).val( tax_id );
            $('.invoice').eq(i).val( Math.round(data['invoice'] ));
            /* トータル再計算*/
            recalc();
          }
        })
      break;
    }
    //var settime = $('.settime').eq(0).val(data['model']);

  });

  var timeMath = {
      // 減算
      sub : function() {
          var result, times, second, i,
              len = arguments.length;

          if (len === 0) return;

          for (i = 0; i < len; i++) {
              if (!arguments[i] || !arguments[i].match(/^[0-9]+:[0-9]{2}:[0-9]{2}$/)) continue;

              times = arguments[i].split(':');

              second = this.toSecond(times[0], times[1], times[2]);

              if (!second) continue;

              if (i === 0) {
                  result = second;
              } else {
                  result -= second;
              }
          }

          return result;//this.toTimeFormat(result);
      },

      // 時間を秒に変換
      toSecond : function(hour, minute, second) {
          if ((!hour && hour !== 0) || (!minute && minute !== 0) || (!second && second !== 0) ||
              hour === null || minute === null || second === null ||
              typeof hour === 'boolean' ||
              typeof minute === 'boolean' ||
              typeof second === 'boolean' ||
              typeof Number(hour) === 'NaN' ||
              typeof Number(minute) === 'NaN' ||
              typeof Number(second) === 'NaN') return;

          return (Number(hour) * 60 * 60) + (Number(minute) * 60) + Number(second);
      },

      // 秒を時間（hh:mm:ss）のフォーマットに変換
      toTimeFormat : function(fullSecond) {
          var hour, minute, second;

          if ((!fullSecond && fullSecond !== 0) || !String(fullSecond).match(/^[\-0-9][0-9]*?$/)) return;

          var paddingZero = function(n) {
              return (n < 10)  ? '0' + n : n;
          };

          hour   = Math.floor(Math.abs(fullSecond) / 3600);
          minute = Math.floor(Math.abs(fullSecond) % 3600 / 60);
          second = Math.floor(Math.abs(fullSecond) % 60);

          minute = paddingZero(minute);
          second = paddingZero(second);

          return ((fullSecond < 0) ? '-' : '') + hour + ':' + minute + ':' + second;
      }
  };

	$( 'input[name="travel"]' ).change( function() {
		var weekday = $('select[name="weekday"]').val();
		//console.log(weekday);
    var date = new Date( $( this ).val() );
	  var weekday = date.getDay() ;
		console.log(weekday);
	  $('select[name="weekday"]').val(weekday);
    // 日付を設定する
    var settime = date.getFullYear() + '-' + ( date.getMonth()+1 )  + '-' + date.getDate();
    console.log(settime);
    //$.each($('.setdate'), function(i, val) {
      //console.log(val);
      //$('.settime').eq(i).val( settime );
    //});
    const fpConf = {
     allowInput: true,
     enableTime: true,
     noCalendar: false,
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
          defaultDate: settime,
  	};
    $("#timeschdule").find(".flatpickr").flatpickr(fpConf);
	});
});

$( 'select[name="purpose"]' ).change( function() {
  var id = $('select[name="purpose"]').val();
  var seturl = 'index.php?route=catalog/product/getProduct&token=' + getURLVar('token') + '&id=' + id;
  $.ajax({
    url: seturl,
    type: "POST",
  //Ajax通信が成功した場合に呼び出されるメソッド
    success: function(data, dataType){
    //デバッグ用 アラートとコンソール
      //出力する部分
      $('.id').eq(0).val(data['id']);
      $('.model').eq(0).val(data['model']);
      $('.name').eq(0).val(data['name']);
      $('.tax_id').eq(0).val(data['tax_id']);
      var travel = $( 'input[name="travel"]' ).val();  // 日にちの取得
      var data = $('.mileage').eq(5).val();
      if ( data > 0 ) {
        var seturl = 'index.php?route=catalog/transport/getPrice&token=' + getURLVar('token') + '&distance=' + data + '&travel=' + travel;
        $.ajax({
          url: seturl,
          type: "POST",
          //Ajax通信が成功した場合に呼び出されるメソッド
          success: function(data, dataType){
            setcolumn(0,data);
          }
        });
      }
    }
  });
});
/*
    カラムに値をセットする
*/
function setcolumn(i,data) {
  var quantity = $('.quantity').eq(i).val();
  $('.price').eq(i).val( Math.round(data[0]['price']) );
  $('.amount').eq(i).val( Math.round(data[0]['price'] * quantity) );
  var tax_id = data[0]['tax_id'];
  if (　tax_id < 1 ) tax_id=1;// 消費税８％に固定
  arr = jQuery.grep(taxes, function(value, index ) {
    return (value.id == tax_id );
  });
  var tax = Math.round( data[0]['price'] * arr[0]['rate'] * quantity );
  $('.tax').eq(i).val( tax );
  $('.tax_id').eq(i).val( tax_id );
  $('.invoice').eq(i).val( Math.round(data[0]['invoice'] ));
  /* トータル再計算*/
  recalc();
}

$(document).on("change", ".settime", function () {
  return;//すぐに発動するので今回は使わない
  var index = $('.settime').index(this);
  if ( index == 0 ) {
    var settime = $('.settime').eq(index).val();
    const fpConf = {
     allowInput: true,
     enableTime: true,
     noCalendar: false,
     minuteIncrement: 1,
     locale: 'ja',
     defaultDate: settime,
  	};
    $("#timeschdule").find(".timepickr").flatpickr(fpConf);
  }
});

$(document).on("change", ".waittime", function () {
  var index = $('.waittime').index(this);
  if (index == 4) {
    var travel = $( 'input[name="travel"]' ).val();  // 日にちの取得
    var data = <?php echo json_encode($wait, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
    var time = parseInt(　$('.waittime').eq(index).val() );
    console.log(time,(time+15)/30);
    var id = data[0]['id'];
    var seturl = 'index.php?route=catalog/product/getProductPrice&token=' + getURLVar('token') + '&id=' + id + '&travel=' + travel;
    $.ajax({
      url: seturl,
      type: "POST",
    //Ajax通信が成功した場合に呼び出されるメソッド
      success: function(data, dataType){
        var quantity =  Math.floor((time+15)/30);
        var i = 2;
        $('.quantity').eq(i).val( quantity );
        setcolumn(i,data);
      }
    })
  }　
});
/*

$(document).on("change", "#vehicle", function () {
  var id = $('select[name="vehicle"]').val();
  var travel = $( 'input[name="travel"]' ).val();  // 日にちの取得
  if (id == 0) return;
  var seturl = 'index.php?route=catalog/product/getProductPrice&token=' + getURLVar('token') + '&id=' + id + '&travel=' + travel;

  $.ajax({
    url: seturl,
    type: "POST",
  //Ajax通信が成功した場合に呼び出されるメソッド
    success: function(data, dataType){
      var i = 3;
      setcolumn(i,data);
      $('.id').eq(i).val( data[0]['id'] );
      $('.name').eq(i).val( data[0]['name'] );
      $('.model').eq(i).val( data[0]['model'] );
    }
  })

});
*/
$(document).on("change", ".metar", function () {
  var index = $('.metar').index(this);
  var mileage = $('.mileage').eq(5).val();

  if (index == 0 || index == 5) {
    // console.log($('.metar').eq(4).val() - $('.metar').eq(0).val());
    if (parseInt($('.metar').eq(5).val()) <1 ) return;
    if (parseInt($('.metar').eq(0).val()) <1 ) return;
    var next = $('.metar').eq(5).val() - $('.metar').eq(0).val();
    if ( next < 0 ) next = 0;
    if ( next > 1099 ) next = 1099;

    $('.mileage').eq(5).val( next );
    if ( mileage != next ) {
      var data = next;
      var name = $('#purpose').val();
      var seturl = 'index.php?route=catalog/transport/getPrice&token=' + getURLVar('token') + '&distance=' + data;
      console.log(seturl);
      $.ajax({
        url: seturl,
        type: "POST",
        success: function(data, dataType){
        console.log(data[0]['price']);
        setcolumn(0,data);
        }
      });
    }
  }
});

/*
  再計算
*/
/*
  クリアボタンが押された
*/
$(document).on("click", ".minus", function () {
  var i = $('.minus').index(this) + 3;
  $('.id').eq(i).val(0);
  $('.model').eq(i).val('');
  $('.name').eq(i).val('');
  $('.price').eq(i).val(0);
  $('.amount').eq(i).val(0);
  $('.tax').eq(i).val(0);
  $('.tax_id').eq(i).val(1);
  $('.invoice').eq(i).val(0);
  /* トータル再計算*/
  recalc();
});
/*
  追加ボタンが押された
*/
$(document).on("click", ".plus", function () {
  var date = new Date( $( 'input[name="travel"]' ).val() );
  var index = $('.plus').index(this) + 3;
  var customer_group = $('select[name="customer_group"]').val();
  if (customer_group == '*') {
    alert("取引先を選択してください！");
    return;
  }
  var today = [
    date.getFullYear(),
    ('0' + (date.getMonth() + 1)).slice(-2),
    ('0' + date.getDate()).slice(-2)
    ].join('-');
//console.log(today);
  var element = this;
  var seturl = 'index.php?route=common/productmanager&token=' + getURLVar('token') + '&filter_customer_group=' + customer_group + '&filter_date=' + today + '&index=' +index;
  $.ajax({
    url: seturl,
    dataType: 'html',
    success: function(html) {
      $('body').append('<div id="modal-product" class="modal fade">' + html + '</div>');

      $('#modal-product').modal('show');
    }
  });
});
/*
  金額が変わった
*/
$(document).on("change", ".price", function () {
  var i = $('.price').index(this);
  var price = $('.price').eq(i).val();
  var quantity = $('.quantity').eq(i).val();
  $('.amount').eq(i).val( Math.round( price*quantity) );
  var tax_id = $('.tax_id').eq(i).val();
  if (tax_id<1) tax_id = 1;
  arr = jQuery.grep(taxes, function(value, index ) {
    return (value.id == tax_id );
  });
  var tax = Math.round( price * quantity * arr[0]['rate'] );
  $('.tax').eq(i).val( tax );
  if (i == 1 || i ==2) $('.invoice').eq(i).val( price );
  recalc();
 });
 /*
   数量が変わった
 */
 $(document).on("change", ".quantity", function () {
   var i = $('.quantity').index(this);
   var price = $('.price').eq(i).val();
   var quantity = $('.quantity').eq(i).val();
   $('.amount').eq(i).val( Math.round( price*quantity) );
   var tax_id = $('.tax_id').eq(i).val();
   if (tax_id<1) tax_id = 1;
   arr = jQuery.grep(taxes, function(value, index ) {
     return (value.id == tax_id );
   });
   var tax = Math.round( price * quantity * arr[0]['rate'] );
   $('.tax').eq(i).val( tax );
   recalc();
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

/* enter key non submit */
$("input").on("keydown", function(e) {
    if ((e.which && e.which === 13) || (e.keyCode && e.keyCode === 13)) {
        return false;
    } else {
        return true;
    }
});
//--></script>
<script>
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

   flatpickr('.timepickr', {
     allowInput: true,
     enableTime: true,
     noCalendar: true,
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
     enableSeconds: false, // disabled by default

     time_24hr: true, // AM/PM time picker is used by default

      // initial values for time. don't use these to preload a date
      defaultHour: 12,
      defaultMinute: 0,
      minuteIncrement: 1,
      // Preload time with defaultDate instead:
      // defaultDate: "3:30"
    }
   );




</script>
</div>
<?php echo $footer; ?>

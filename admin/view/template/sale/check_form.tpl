<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-customer" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
    </div>
  </div>
  <div class="container-fluid">
      <div class="panel-body form-horizontal">
        <div class="panel-heading">
          <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
        </div>
        <div class="panel-body form-horizontal">
          <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-check" >
             <div class="form-group required col-sm-4">
              <label class="col-sm-6 control-label" for="input-customer"><?php echo $entry_customer; ?></label>
                <div class="col-sm-6">
                  <input type="text" name="customer" value="<?php echo $customer;?>" placeholder="<?php echo $entry_customer; ?>" id="input-customer" class="form-control">
                  <?php if ($error_customer) { ?>
                  <div class="text-danger"><?php echo $error_customer; ?></div>
                  <?php } ?>
                </div>
             </div>
              <div class="form-group">
                 <label class="col-sm-2 control-label" for="input-customer-group"><?php echo $entry_customer_group; ?></label>
	    			     <div class="col-sm-3">
                    <select name="customer_group_id" id="customer_group_id" class="form-control">
                      <?php foreach ($customer_groups as $customer) { ?>
                      <?php if ($customer['customer_group_id'] == $customer_group_id) { ?>
                      <option value="<?php echo $customer['customer_group_id']; ?>" selected="selected"><?php echo $customer['name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $customer['customer_group_id']; ?>"><?php echo $customer['name']; ?></option>
                       <?php } ?>
                       <?php } ?>
                   </select>
                 </div>
            	</div>

              <div class="form-group required">
                 <label class="col-sm-2 control-label" for="input-project"><?php echo $entry_project; ?></label>
                 <div class="col-sm-2">
                   <select name="project_id" id="project_id" class="form-control" value="<?php echo $project_id; ?>">

                     <?php foreach ($projects as $project) { ?>

                       <?php if ($project['project_id'] == $project_id) { ?>
                         <option value="<?php echo $project['project_id']; ?>" selected="selected"><?php echo $project['name']; ?></option>
                       <?php } else { ?>
                           <option value="<?php echo $project['project_id']; ?>"><?php echo $project['name']; ?></option>
                       <?php } ?>

                    <?php } ?>

                  </select>
                 </div>
              </div>

              <div class="form-group required col-sm-4">
                <label class="col-sm-6 control-label" for="input-name"><?php echo $entry_name; ?></label>
                <div class="col-sm-6">
                  <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
                  <?php if ($error_name) { ?>
                  <div class="text-danger"><?php echo $error_name; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
            		<label class="col-sm-2 control-label" for="input-number"><?php echo $entry_number; ?></label>
            		<div class="col-sm-2">
            			<input type="number" name="number" value="<?php echo $number; ?>"　placeholder="<?php echo $entry_number; ?>" id="input-number"　class="form-control" />
            		</div>
             </div>
<hr>
             <!-- 故人名 -->
				     <div class="form-group required col-sm-4">
						   <label class="col-sm-6 control-label" for="input-deceased"><?php echo $entry_deceased; ?></label>
						   <div class="col-sm-6">
                 <select name="deceased" id="input-deceased" class="form-control">
                   <?php if ($deceased) { ?>
                   <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                   <option value="0"><?php echo $text_disabled; ?></option>
                   <?php } else { ?>
                   <option value="1"><?php echo $text_enabled; ?></option>
                   <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                   <?php } ?>
                 </select>
                 <?php if ($error_deceased) { ?>
                 <div class="text-danger"><?php echo $error_deceased; ?></div>
                 <?php } ?>
               </div>
            </div>
            <!--  続柄 -->
            <div class="form-group required col-sm-4">
              <label class="col-sm-6 control-label" for="input-relation"><?php echo $entry_relation; ?></label>
              <div class="col-sm-6">
                <select name="relation" id="input-relation" class="form-control">
                  <?php if ($relation) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select>
                <?php if ($error_relation) { ?>
                <div class="text-danger"><?php echo $error_relation; ?></div>
                <?php } ?>
              </div>
            </div>
           <!--  亡くなった日 -->
            <div class="form-group required col-sm-4">
             <label class="col-sm-6 control-label" for="input-death"><?php echo $entry_death; ?></label>
             <div class="col-sm-6">
               <select name="death" id="input-death" class="form-control">
                 <?php if ($death) { ?>
                 <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                 <option value="0"><?php echo $text_disabled; ?></option>
                 <?php } else { ?>
                 <option value="1"><?php echo $text_enabled; ?></option>
                 <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                 <?php } ?>
               </select>
               <?php if ($error_death) { ?>
               <div class="text-danger"><?php echo $error_death; ?></div>
               <?php } ?>
             </div>
          </div>
           <!-- 喪主 -->
            <div class="form-group required col-sm-4">
              <label class="col-sm-6 control-label" for="input-mourner"><?php echo $entry_mourner; ?></label>
              <div class="col-sm-6">
                <select name="mourner" id="input-mourner" class="form-control">
                  <?php if ($mourner) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select>
                <?php if ($error_mourner) { ?>
                <div class="text-danger"><?php echo $error_mourner; ?></div>
                <?php } ?>
              </div>
           </div>
            <!-- 住所 -->
           <div class="form-group required col-sm-4">
             <label class="col-sm-6 control-label" for="input-address"><?php echo $entry_address; ?></label>
             <div class="col-sm-6">
               <select name="address" id="input-address" class="form-control">
                 <?php if ($address) { ?>
                 <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                 <option value="0"><?php echo $text_disabled; ?></option>
                 <?php } else { ?>
                 <option value="1"><?php echo $text_enabled; ?></option>
                 <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                 <?php } ?>
               </select>
               <?php if ($error_address) { ?>
               <div class="text-danger"><?php echo $error_address; ?></div>
               <?php } ?>
             </div>
          </div>
          <!-- ダミー -->
          <div class="form-group">
          </div>

           <!-- 通夜、告別式 -->
           <div class="form-group required col-sm-4">
            <label class="col-sm-6 control-label" for="input-days"><?php echo $entry_days; ?></label>
            <div class="col-sm-6">
              <select name="days" id="input-days" class="form-control">
                <?php if ($days) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
              <?php if ($error_days) { ?>
              <div class="text-danger"><?php echo $error_days; ?></div>
              <?php } ?>
            </div>
          </div>

          <div class="form-group required col-sm-4">
			      <label class="col-sm-6 control-label" for="input-days"><?php echo $entry_design; ?></label>
              <div class="col-sm-6">
                <select name="design" id="input-design" class="form-control">
                  <?php if ($design) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select>
              <?php if ($error_design) { ?>
                <div class="text-danger"><?php echo $error_design; ?></div>
              <?php } ?>
            </div>
			    </div>

          <div class="form-group required col-sm-4">
			      <label class="col-sm-6 control-label" for="input-sentence"><?php echo $entry_sentence; ?></label>
              <div class="col-sm-6">
                <select name="sentence" id="input-sentence" class="form-control">
                  <?php if ($sentence) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select>
                <?php if ($error_design) { ?>
                  <div class="text-danger"><?php echo $error_sentence; ?></div>
                <?php } ?>
              </div>
			    </div>
          <div class="form-group">
          </div>
                    <!-- 親族１ -->
          <div class="form-group col-sm-4">
             <label class="col-sm-6 control-label" for="input-mourner1"><?php echo $entry_mourner1; ?></label>
             <div class="col-sm-6">
               <select name="mourner1" id="input-mourner1" class="form-control">
                 <?php if ($mourner1) { ?>
                 <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                 <option value="0"><?php echo $text_disabled; ?></option>
                 <?php } else { ?>
                 <option value="1"><?php echo $text_enabled; ?></option>
                 <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                 <?php } ?>
               </select>
             </div>
          </div>
          <!--  親族２ -->
          <div class="form-group col-sm-4">
             <label class="col-sm-6 control-label" for="input-mourner2"><?php echo $entry_mourner2; ?></label>
             <div class="col-sm-6">
               <select name="mourner2" id="input-mourner2" class="form-control">
                 <?php if ($mourner2) { ?>
                 <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                 <option value="0"><?php echo $text_disabled; ?></option>
                 <?php } else { ?>
                 <option value="1"><?php echo $text_enabled; ?></option>
                 <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                 <?php } ?>
               </select>
             </div>
          </div>
          <!-- 親族３ -->
          <div class="form-group col-sm-4">
             <label class="col-sm-6 control-label" for="input-mourner3"><?php echo $entry_mourner3; ?></label>
             <div class="col-sm-6">
               <select name="mourner3" id="input-mourner3" class="form-control">
                 <?php if ($mourner3) { ?>
                 <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                 <option value="0"><?php echo $text_disabled; ?></option>
                 <?php } else { ?>
                 <option value="1"><?php echo $text_enabled; ?></option>
                 <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                 <?php } ?>
               </select>
             </div>
          </div>
          <!-- 家紋 -->

          <div class="form-group col-sm-4">
            <label class="col-sm-6 control-label" for="input-crest"><?php echo $entry_crest; ?></label>
              <div class="col-sm-6">
                <select name="crest" id="input-crest" class="form-control">
                  <?php if ($crest) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select>
              </div>
          </div>
          <div class="form-group col-sm-4">
          </div>
          <div class="form-group">
          </div>
          <!-- 送信方法 -->
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-protocol-group"><?php echo $entry_protocol; ?></label>

            <div class="col-sm-2">
              <select name="protcol_id" id="protocol_id" class="form-control">
                <?php foreach ($protocols as $protocol) { ?>
                <?php if ($protocol['protocol_id'] == $protocol_id) { ?>
                <option value="<?php echo $protocol['protocol_id']; ?>" selected="selected"><?php echo $protocol['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $protocol['protocol_id']; ?>"><?php echo $protocol['name']; ?></option>
                 <?php } ?>
                 <?php } ?>
             </select>
            </div>
        </div>
      </form>
      </div>
  </div>
</div>
<?php echo $footer; ?>

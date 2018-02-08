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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-customer" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
            <li><a href="#tab-address" data-toggle="tab"><?php echo $tab_address; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
               <div class="form-group required">
                	<label class="col-sm-2 control-label" for="input-project"><?php echo $entry_project; ?></label>
	    			<div class="col-sm-10">
    	            <select name="project_id" id="project_id" class="form-control">
                    <?php foreach ($projects as $project) { ?>
                    <?php if ($project['project_id'] == $project_id) { ?>
                    <option value="<?php echo $project['project_id']; ?>" selected="selected"><?php echo $project['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $project['project_id']; ?>"><?php echo $project['name']; ?></option>
                     <?php } ?>
                     <?php } ?>
                     </select>
                    <?php if ($error_project) { ?>
            	        <div class="text-danger"><?php echo $error_project; ?></div>
                    <?php } ?>
                	</div>
            	</div>
            	<div class="form-group required">
                	<label class="col-sm-2 control-label" for="input-customer-group"><?php echo $entry_protocol; ?></label>
	    			<div class="col-sm-10">
    	            <select name="protocol_id" id="protocol_id" class="form-control">
                    <?php foreach ($protocols as $protocol) { ?>
                    <?php if ($protocol['protocol_id'] == $protocol_id) { ?>
                    <option value="<?php echo $protocol['protocol_id']; ?>" selected="selected"><?php echo $protocol['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $protocol['protocol_id']; ?>"><?php echo $protocol['name']; ?></option>
                     <?php } ?>
                     <?php } ?>
                     </select>
                    <?php if ($error_protocol) { ?>
            	        <div class="text-danger"><?php echo $error_protocol; ?></div>
                    <?php } ?>
                	</div>
            	</div>
	            <div class="form-group required">
                	<label class="col-sm-2 control-label" for="input-customer-group"><?php echo $entry_customer_group; ?></label>
	    			<div class="col-sm-10">
    	            <select name="customer_group_id" id="input-customer-group" class="form-control">
                    <?php foreach ($customer_groups as $customer_group) { ?>
                    <?php if ($customer_group['customer_group_id'] == $customer_group_id) { ?>
                    <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
                     <?php } ?>
                     <?php } ?>
                     </select>
                	</div>
            	</div>
                      
				<div class="form-group required">
						<label class="col-sm-2 control-label" for="input-company"><?php echo $entry_company; ?></label>
						<div class="col-sm-10">
                          <input type="text" name="company" value="<?php echo $company; ?>" placeholder="<?php echo $entry_company; ?>" id="input-company" class="form-control" /></div>
	            </div>
                      
                <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-firstname"><?php echo $entry_firstname; ?></label>
                        <div class="col-sm-10">
                          <input type="text" name="firstname" value="<?php echo $firstname; ?>" placeholder="<?php echo $entry_firstname; ?>" id="input-firstname" class="form-control" />
                          <?php if ($error_firstname) { ?>
                          <div class="text-danger"><?php echo $error_firstname; ?></div>
                          <?php } ?>
                        </div>
                </div>
                <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-lastname"><?php echo $entry_lastname; ?></label>
                        <div class="col-sm-10">
                          <input type="text" name="lastname" value="<?php echo $lastname; ?>" placeholder="<?php echo $entry_lastname; ?>" id="input-lastname" class="form-control" />
                          <?php if ($error_lastname) { ?>
                          <div class="text-danger"><?php echo $error_lastname; ?></div>
                          <?php } ?>
                        </div>
                      </div>
                <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-email"><?php echo $entry_email; ?></label>
                        <div class="col-sm-10">
                          <input type="text" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
                          <?php if ($error_email) { ?>
                          <div class="text-danger"><?php echo $error_email; ?></div>
                          <?php  } ?>
                        </div>
                      </div>
                <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-telephone"><?php echo $entry_telephone; ?></label>
                        <div class="col-sm-3">
                          <input type="text" name="telephone" value="<?php echo $telephone; ?>" placeholder="<?php echo $entry_telephone; ?>" id="input-telephone" class="form-control" />
                          <?php if ($error_telephone) { ?>
                          <div class="text-danger"><?php echo $error_telephone; ?></div>
                          <?php  } ?>
                        </div>
                      </div>
                <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-fax"><?php echo $entry_fax; ?></label>
                        <div class="col-sm-3">
                          <input type="text" name="fax" value="<?php echo $fax; ?>" placeholder="<?php echo $entry_fax; ?>" id="input-fax" class="form-control" />
                        </div>
                      </div>
                <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-ip"><?php echo $entry_ip; ?></label>
                        <div class="col-sm-3">
                          <input type="text" name="ip" value="<?php echo $ip; ?>" placeholder="<?php echo $entry_ip; ?>" id="input-ip" class="form-control" />
                        </div>
                </div>      
                <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                        <div class="col-sm-3">
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
			        <label class="col-sm-2 control-label" for="input-comment"><?php echo $entry_comment; ?></label>
                    <div class="col-sm-10">
                    	<textarea name="comment" id="input-comment" cols="45" rows="8" placeholder="<?php echo $entry_comment;?>" class="form-control"><?php echo $comment;?></textarea>
					</div>                
                </div>
 				<div class="form-group">
            		<label class="col-sm-2 control-label" for="input-image"><?php echo $entry_image; ?></label>
            		<div class="col-sm-10">
              			<a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
              			<input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
            		</div>
          		</div>
                <div class="form-group">
			        <label class="col-sm-2 control-label" for="input-comment"><?php echo $entry_design; ?></label>
                    <div class="col-sm-10">
                    	<textarea name="design" id="input-design" cols="45" rows="8" placeholder="<?php echo $entry_design;?>" class="form-control"><?php echo $design;?></textarea>
					</div>                
                </div>         
			</div>			
		<!-- 住所欄-->
             <div class="tab-pane" id="tab-address">
                <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-postcode"><?php echo $entry_postcode; ?></label>
                        <div class="col-sm-3">
                          <input type="text" name="postcode" id="postcode" value="<?php echo $postcode; ?>" placeholder="<?php echo $entry_postcode; ?>" class="form-control" onKeyUp="AjaxZip3.zip2addr(this,'','pref','city');" />
                        </div>
                </div>
                <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-zone"><?php echo $entry_zone; ?></label>
                        <div class="col-sm-10">
                          <select name="pref" id="pref" class="form-control">
                          <?php foreach($prefs as $prf) { ?>
                            <?php if ($prf['pref'] === $pref) { ?>
	                          	<option value="<?php echo $prf['pref'];?>" selected><?php echo $prf['pref'];?></option>
                            <?php } else { ?>
	                          	<option value="<?php echo $prf['pref'];?>"><?php echo $prf['pref'];?></option>
                            <?php } ?>
                          <?php } ?>
                          </select>
                          <?php if (isset($error_pref)) { ?>
                          <div class="text-danger"><?php echo $error_pref; ?></div>
                          <?php } ?>
                        </div>
                </div>
                <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-city"><?php echo $entry_city; ?></label>
                        <div class="col-sm-10">
                          <input type="text" name="city" value="<?php echo $city; ?>" placeholder="<?php echo $entry_city; ?>" id="city" class="form-control" />
                          <?php if (isset($error_city)) { ?>
                          <div class="text-danger"><?php echo $error_city; ?></div>
                          <?php } ?>
                        </div>
				</div>
                <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-address-1"><?php echo $entry_address_1; ?></label>
                        <div class="col-sm-10">
                          <input type="text" name="address_1" value="<?php echo $address_1; ?>" placeholder="<?php echo $entry_address_1; ?>" id="input-address-1" class="form-control" />
                          <?php if (isset($error_address_1)) { ?>
                          <div class="text-danger"><?php echo $error_address_1; ?></div>
                          <?php } ?>
                        </div>
				</div>
                <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-address-2"><?php echo $entry_address_2; ?></label>
                        <div class="col-sm-10">
                          <input type="text" name="address_2" value="<?php echo $address_2; ?>" placeholder="<?php echo $entry_address_2; ?>" id="input-address-2" class="form-control" />
                        </div>
                </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>

<?php echo $footer; ?>
<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-setting" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-setting" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-local" data-toggle="tab"><?php echo $tab_local; ?></a></li>
            <li><a href="#tab-image" data-toggle="tab"><?php echo $tab_image; ?></a></li>
            <li><a href="#tab-mail" data-toggle="tab"><?php echo $tab_mail; ?></a></li>
            <li><a href="#tab-server" data-toggle="tab"><?php echo $tab_server; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-local">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-country"><?php echo $entry_country; ?></label>
                <div class="col-sm-10">
                  <select name="config_country_id" id="input-country" class="form-control">
                    <?php foreach ($countries as $country) { ?>
                    <?php if ($country['country_id'] == $config_country_id) { ?>
                    <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-language"><?php echo $entry_language; ?></label>
                <div class="col-sm-10">
                  <select name="config_language" id="input-language" class="form-control">
                    <?php foreach ($languages as $language) { ?>
                    <?php if ($language['code'] == $config_language) { ?>
                    <option value="<?php echo $language['code']; ?>" selected="selected"><?php echo $language['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $language['code']; ?>"><?php echo $language['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-admin-language"><?php echo $entry_admin_language; ?></label>
                <div class="col-sm-10">
                  <select name="config_admin_language" id="input-admin-language" class="form-control">
                    <?php foreach ($languages as $language) { ?>
                    <?php if ($language['code'] == $config_admin_language) { ?>
                    <option value="<?php echo $language['code']; ?>" selected="selected"><?php echo $language['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $language['code']; ?>"><?php echo $language['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
                <div class="form-group required">
                  <label class="col-sm-2 control-label" for="input-admin-limit"><span data-toggle="tooltip" title="<?php echo $help_limit_admin; ?>"><?php echo $entry_limit_admin; ?></span></label>
                  <div class="col-sm-10">
                    <input type="text" name="config_limit_admin" value="<?php echo $config_limit_admin; ?>" placeholder="<?php echo $entry_limit_admin; ?>" id="input-admin-limit" class="form-control" />
                    <?php if ($error_limit_admin) { ?>
                    <div class="text-danger"><?php echo $error_limit_admin; ?></div>
                    <?php } ?>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><?php echo $entry_tax; ?></label>
                  <div class="col-sm-10">
                    <label class="radio-inline">
                      <?php if ($config_tax) { ?>
                      <input type="radio" name="config_tax" value="1" checked="checked" />
                      <?php echo $text_yes; ?>
                      <?php } else { ?>
                      <input type="radio" name="config_tax" value="1" />
                      <?php echo $text_yes; ?>
                      <?php } ?>
                    </label>
                    <label class="radio-inline">
                      <?php if (!$config_tax) { ?>
                      <input type="radio" name="config_tax" value="0" checked="checked" />
                      <?php echo $text_no; ?>
                      <?php } else { ?>
                      <input type="radio" name="config_tax" value="0" />
                      <?php echo $text_no; ?>
                      <?php } ?>
                    </label>
                  </div>
                </div>
            </div>

            <div class="tab-pane" id="tab-image">
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-image-thumb-width"><?php echo $entry_image_thumb; ?></label>
                <div class="col-sm-10">
                  <div class="row">
                    <div class="col-sm-6">
                      <input type="text" name="config_image_thumb_width" value="<?php echo $config_image_thumb_width; ?>" placeholder="<?php echo $entry_width; ?>" id="input-image-thumb-width" class="form-control" />
                    </div>
                    <div class="col-sm-6">
                      <input type="text" name="config_image_thumb_height" value="<?php echo $config_image_thumb_height; ?>" placeholder="<?php echo $entry_height; ?>" class="form-control" />
                    </div>
                  </div>
                  <?php if ($error_image_thumb) { ?>
                  <div class="text-danger"><?php echo $error_image_thumb; ?></div>
                  <?php } ?>
                </div>
              </div>

              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-image-product-width"><?php echo $entry_image_product; ?></label>
                <div class="col-sm-10">
                  <div class="row">
                    <div class="col-sm-6">
                      <input type="text" name="config_image_product_width" value="<?php echo $config_image_product_width; ?>" placeholder="<?php echo $entry_width; ?>" id="input-image-product-width" class="form-control" />
                    </div>
                    <div class="col-sm-6">
                      <input type="text" name="config_image_product_height" value="<?php echo $config_image_product_height; ?>" placeholder="<?php echo $entry_height; ?>" class="form-control" />
                    </div>
                  </div>
                  <?php if ($error_image_product) { ?>
                  <div class="text-danger"><?php echo $error_image_product; ?></div>
                  <?php } ?>
                </div>
              </div>
             </div>
            <div class="tab-pane" id="tab-mail">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-mail-protocol"><span data-toggle="tooltip" title="<?php echo $help_mail_protocol; ?>"><?php echo $entry_mail_protocol; ?></span></label>
                <div class="col-sm-10">
                  <select name="config_mail[protocol]" id="input-mail-protocol" class="form-control">
                    <?php if ($config_mail_protocol == 'mail') { ?>
                    <option value="mail" selected="selected"><?php echo $text_mail; ?></option>
                    <?php } else { ?>
                    <option value="mail"><?php echo $text_mail; ?></option>
                    <?php } ?>
                    <?php if ($config_mail_protocol == 'smtp') { ?>
                    <option value="smtp" selected="selected"><?php echo $text_smtp; ?></option>
                    <?php } else { ?>
                    <option value="smtp"><?php echo $text_smtp; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-mail-parameter"><span data-toggle="tooltip" title="<?php echo $help_mail_parameter; ?>"><?php echo $entry_mail_parameter; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="config_mail[parameter]" value="<?php echo $config_mail_parameter; ?>" placeholder="<?php echo $entry_mail_parameter; ?>" id="input-mail-parameter" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-smtp-hostname"><span data-toggle="tooltip" title="<?php echo $help_mail_smtp_hostname; ?>"><?php echo $entry_smtp_hostname; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="config_mail[smtp_hostname]" value="<?php echo $config_smtp_hostname; ?>" placeholder="<?php echo $entry_smtp_hostname; ?>" id="input-smtp-hostname" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-smtp-username"><?php echo $entry_smtp_username; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="config_mail[smtp_username]" value="<?php echo $config_smtp_username; ?>" placeholder="<?php echo $entry_smtp_username; ?>" id="input-smtp-username" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-smtp-password"><?php echo $entry_smtp_password; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="config_mail[smtp_password]" value="<?php echo $config_smtp_password; ?>" placeholder="<?php echo $entry_smtp_password; ?>" id="input-smtp-password" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-smtp-port"><?php echo $entry_smtp_port; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="config_mail[smtp_port]" value="<?php echo $config_smtp_port; ?>" placeholder="<?php echo $entry_smtp_port; ?>" id="input-smtp-port" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-smtp-timeout"><?php echo $entry_smtp_timeout; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="config_mail[smtp_timeout]" value="<?php echo $config_smtp_timeout; ?>" placeholder="<?php echo $entry_smtp_timeout; ?>" id="input-smtp-timeout" class="form-control" />
                </div>
              </div>

            </div>
            <div class="tab-pane" id="tab-server">
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_secure; ?>"><?php echo $entry_secure; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($config_secure) { ?>
                    <input type="radio" name="config_secure" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="config_secure" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$config_secure) { ?>
                    <input type="radio" name="config_secure" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="config_secure" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-file-max-size"><span data-toggle="tooltip" title="<?php echo $help_file_max_size; ?>"><?php echo $entry_file_max_size; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="config_file_max_size" value="<?php echo $config_file_max_size; ?>" placeholder="<?php echo $entry_file_max_size; ?>" id="input-file-max-size" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-file-ext-allowed"><span data-toggle="tooltip" title="<?php echo $help_file_ext_allowed; ?>"><?php echo $entry_file_ext_allowed; ?></span></label>
                <div class="col-sm-10">
                  <textarea name="config_file_ext_allowed" rows="5" placeholder="<?php echo $entry_file_ext_allowed; ?>" id="input-file-ext-allowed" class="form-control"><?php echo $config_file_ext_allowed; ?></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-file-mime-allowed"><span data-toggle="tooltip" title="<?php echo $help_file_mime_allowed; ?>"><?php echo $entry_file_mime_allowed; ?></span></label>
                <div class="col-sm-10">
                  <textarea name="config_file_mime_allowed" cols="60" rows="5" placeholder="<?php echo $entry_file_mime_allowed; ?>" id="input-file-mime-allowed" class="form-control"><?php echo $config_file_mime_allowed; ?></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_password; ?>"><?php echo $entry_password; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($config_password) { ?>
                    <input type="radio" name="config_password" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="config_password" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$config_password) { ?>
                    <input type="radio" name="config_password" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="config_password" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-encryption"><span data-toggle="tooltip" title="<?php echo $help_encryption; ?>"><?php echo $entry_encryption; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="config_encryption" value="<?php echo $config_encryption; ?>" placeholder="<?php echo $entry_encryption; ?>" id="input-encryption" class="form-control" />
                  <?php if ($error_encryption) { ?>
                  <div class="text-danger"><?php echo $error_encryption; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-compression"><span data-toggle="tooltip" title="<?php echo $help_compression; ?>"><?php echo $entry_compression; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="config_compression" value="<?php echo $config_compression; ?>" placeholder="<?php echo $entry_compression; ?>" id="input-compression" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_error_display; ?></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($config_error_display) { ?>
                    <input type="radio" name="config_error_display" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="config_error_display" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$config_error_display) { ?>
                    <input type="radio" name="config_error_display" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="config_error_display" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_error_log; ?></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($config_error_log) { ?>
                    <input type="radio" name="config_error_log" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="config_error_log" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$config_error_log) { ?>
                    <input type="radio" name="config_error_log" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="config_error_log" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-error-filename"><?php echo $entry_error_filename; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="config_error_filename" value="<?php echo $config_error_filename; ?>" placeholder="<?php echo $entry_error_filename; ?>" id="input-error-filename" class="form-control" />
                  <?php if ($error_error_filename) { ?>
                  <div class="text-danger"><?php echo $error_error_filename; ?></div>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php echo $footer; ?>
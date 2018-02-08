<?php
// Heading
$_['heading_title']                         = 'Export / Import';

// Text
$_['text_success']                          = 'Success: You have successfully imported your data!';
$_['text_success_settings']                 = 'Success: You have successfully updated the settings for the エクスポート/インポート tool!';
$_['text_export_type_category']             = 'カテゴリー';
$_['text_export_type_product']              = '商品 (including product data)';
$_['text_yes']                              = 'アップデート';
$_['text_no']                               = '新規追加';
$_['text_nochange']                         = 'No server data has been changed.';
$_['text_log_details']                      = 'See also \'System &gt; Error Logs\' for more details.';
$_['text_loading_notifications']            = 'Getting messages';
$_['text_retry']                            = 'Retry';

// Entry
$_['entry_import']                          = 'インポートできるファイルは拡張子が、 .XLS, .XLSX or .ODSの３つです.';
$_['entry_export']                          = ' XLSX 形式のファイルにエクスポートします.';
$_['entry_export_type']                     = '';
$_['entry_range_type']                      = 'Exportするタイプを選んでください:';
$_['entry_start_id']                        = 'id:(開始)';
$_['entry_start_index']                     = 'Counts per batch:';
$_['entry_end_id']                          = 'id:(終了)';
$_['entry_end_index']                       = 'The batch number:';
$_['entry_incremental']                     = 'どちらでImportしますか？';
$_['entry_upload']                          = 'File to be uploaded';

$_['entry_settings_use_export_cache']       = 'Use phpTemp cache for large エクスポートs (will be slightly slower)';
$_['entry_settings_use_import_cache']       = 'Use phpTemp cache for large Imports (will be slightly slower)';

// Error
$_['error_permission']                      = 'Warning: You do not have permission to modify エクスポート/インポート!';
$_['error_upload']                          = 'Uploaded file is not a valid spreadsheet file or its values are not in the expected formats!';
$_['error_categories_header']               = 'エクスポート/インポート: Invalid header in the Categories worksheet';
$_['error_products_header']                 = 'エクスポート/インポート: Invalid header in the Products worksheet';
$_['error_additional_images_header']   = 'エクスポート/インポート: Invalid header in the AdditionalImages worksheet';
$_['error_additional_images']               = 'Missing 商品 worksheet, or 商品 worksheet not listed before AdditionalImages';
$_['error_post_max_size']                   = 'エクスポート/インポート: File size is greater than %1 (see PHP setting \'post_max_size\')';
$_['error_upload_max_filesize']            = 'エクスポート/インポート: File size is greater than %1 (see PHP setting \'upload_max_filesize\')';
$_['error_select_file']                     = 'エクスポート/インポート: Please select a file before clicking \'Import\'';
$_['error_id_no_data']                      = 'No data between start-id and end-id.';
$_['error_page_no_data']                    = 'No more data.';
$_['error_param_not_number']                = 'Values for data range must be whole numbers.';
$_['error_upload_name']                  = 'Missing file name for upload';
$_['error_upload_ext']                      = 'Uploaded file has not one of the \'.xls\', \'.xlsx\' or \'.ods\' file name extensions, it might not be a spreadsheet file!';
$_['error_notifications']                   = 'Could not load messages from MHCCORP.COM.';
$_['error_no_news']                         = 'No messages';
$_['error_batch_number']                    = 'Batch number must be greater than 0';
$_['error_min_item_id']                     = 'Start id must be greater than 0';

// Tabs
$_['tab_import']                            = 'インポート';
$_['tab_export']                            = 'エクスポート';
$_['tab_settings']                          = '設　定';

// Button labels
$_['button_import']                         = 'Import';
$_['button_export']                         = 'エクスポート';
$_['button_settings']                       = 'Update Settings';
$_['button_export_id']                      = '例）1−5';
$_['button_export_page']                    = 'すべて';

// Help
$_['help_range_type']                       = '(データのすべてをexportまたは一部をexportすることができます)';
$_['help_incremental_yes']                  = ' (現在のデータをアップデートおよび追加します)';
$_['help_incremental_no']                   = ' (現在のデータを削除してからインポートを開始します)';
$_['help_import']                           = 'インポート出来るのはカテゴリーと商品の２つです. ';
$_['help_format']                           = 'インポートファイルの形式を確認するには、まずはエクスポートしてみてください!';
?>
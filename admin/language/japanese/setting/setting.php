<?php
// Heading
$_['heading_title']                    = '設定';

// Text
$_['text_success']                     = '成功: 設定を更新しました!';
$_['text_edit']                        = '設定の編集';
$_['text_product']                     = '商品';
$_['text_tax']                         = '税';

$_['text_mail']                        = 'Mail';
$_['text_smtp']                        = 'SMTP';

// Entry
$_['entry_name']                       = '店舗（会館）名';
$_['entry_owner']                      = '会社名';
$_['entry_address']                    = '住所';
$_['entry_geocode']                    = '郵便番号';
$_['entry_email']                      = 'メールアドレス';
$_['entry_telephone']                  = '電話番号';
$_['entry_fax']                        = 'FAX番号';
$_['entry_image']                      = '画像';

$_['entry_country']                    = '国';
$_['entry_zone']                       = '地域';
$_['entry_language']                   = '表示言語';
$_['entry_admin_language']             = '管理画面の表示言語';

$_['entry_limit_admin']                = '1ページの表示数 (管理画面)';
$_['entry_tax']                        = '価格を税込みで表示';

$_['entry_customer_group']             = '顧客グループ';
$_['entry_customer_group_display']     = '顧客グループの表示';

$_['entry_logo']                       = '店舗（会館）のロゴ';
$_['entry_icon']                       = 'アイコン';

$_['entry_image_thumb']                = 'サムネイル画像のサイズ';

$_['entry_image_product']              = '商品の画像のサイズ';
$_['entry_image_location']             = '店舗画像のサイズ';

$_['entry_ftp_hostname']                   = 'FTPホスト';
$_['entry_ftp_port']                   = 'FTPポート';
$_['entry_ftp_username']               = 'FTPユーザー名';
$_['entry_ftp_password']               = 'FTPパスワード';
$_['entry_ftp_root']                   = 'FTPルート';
$_['entry_ftp_status']                 = 'FTPを有効にする';
$_['entry_mail_protocol']              = 'メールの送信・接続方法';
$_['entry_mail_parameter']             = 'メールパラメーター';
$_['entry_smtp_hostname']                  = 'SMTP ホスト';
$_['entry_smtp_username']              = 'SMTP ユーザー名';
$_['entry_smtp_password']              = 'SMTP パスワード';
$_['entry_smtp_port']                  = 'SMTP ポート';
$_['entry_smtp_timeout']               = 'SMTP タイムアウト';
$_['entry_fraud_detection']            = 'MaxMind不正検知システムを使用する';
$_['entry_fraud_key']                  = 'MaxMind ライセンスキー';
$_['entry_fraud_score']                = 'MaxMind リスクスコア';
$_['entry_fraud_status']               = 'MaxMind 不正オーダーステータス';
$_['entry_secure']                     = 'SSLを使用する';

$_['entry_file_max_size']              = '最大ファイルサイズ';
$_['entry_file_ext_allowed']           = 'アップロード可能ファイル拡張子の設定';
$_['entry_file_mime_allowed']          = 'アップロード可能Mimeタイプの設定';

$_['entry_password']                   = '忘れたパスワードを許可する';
$_['entry_encryption']                 = '暗号化キー';
$_['entry_compression']                = '出力圧縮レベル';
$_['entry_error_display']              = 'エラーを表示する';
$_['entry_error_log']                  = 'エラーログを記録する';
$_['entry_error_filename']             = 'エラーログのファイル名';
$_['entry_width']                      = '幅';
$_['entry_height']                     = '高さ';

// Help
$_['help_product_limit']               = '1ページに表示する項目の表示数を設定します。(商品一覧, カテゴリー, その他)';
$_['help_product_description_length']  = 'リストで表示する説明の文字数を設定します。 (カテゴリー, 特価商品 その他)';
$_['help_limit_admin']                 = '1ページに表示する項目の表示数を設定します。';
$_['help_account_mail']                = '新規にアカウント登録があると店舗（会館）オーナーにメールでお知らせします。';
$_['help_invoice_prefix']              = '接頭辞を設定します。例:INV-2011-00 請求書IDはそれぞれ一意な接頭辞になるので、開始番号は1からになります。';
$_['help_order_status']                = '購入直後の注文ステータスを設定します。';
$_['help_icon']                        = 'アイコンはpng形式で、サイズは16px x 16pxでなくてはなりません。';
$_['help_ftp_root']                    = 'OpenCartがインストールされたディレクトリ \'public_html/\'。';
$_['help_mail_protocol']               = 'ご利用サーバーがPHPのmail関数を無効にしている場合以外は、｢Mail｣を選択してください。';
$_['help_mail_parameter']              = '｢Mail｣を使用する場合、パラメータを追加する事ができます。（例:「-f email@storeaddress.com」';
$_['help_mail_smtp_hostname']          = 'セキュリティ接続が必要な場合は、『tls：//』接頭辞を加えてください。(例： tls://smtp.gmail.com).';

$_['help_secure']                      = 'SSLを使用するには、SSL証明書がサーバーに設定されていなければなりません。またconfig.phpにSSLのURLを設定する必要があります。';
$_['help_file_max_size']               = 'イメージマネージャでアップロードすることができる画像の最大ファイルサイズ。バイト単位で入力します。';
$_['help_file_ext_allowed']            = '拡張子を設定します。改行すると、複数の拡張子を設定できます。';
$_['help_file_mime_allowed']           = 'Mimeタイプを設定します。改行すると、複数のMimeタイプを設定できます。';

$_['help_password']                    = '管理に使用するパスワードを忘れた場合に許可する。システムがハッキングを検出した場合、自動的に無効になります。';
$_['help_encryption']                  = '注文情報を処理する際に個人情報を暗号化するために使用します。4文字以上16文字以内の適当な文字列を入力してください。';
$_['help_compression']                 = 'パケットを圧縮して送信します。そうすることによりトラフィックは軽くなりますがサーバーやブラウザに負担はかかります。GZIPで圧縮します。 0から9の間で設定してください。0は圧縮しない。9は最高圧縮です。';
// Error
$_['error_warning']                    = '警告: 入力内容にエラーがあります。確認してください!';
$_['error_permission']                 = '警告: 店舗（会館）設定を更新する権限がありません!';
$_['error_name']                       = '店舗（会館）名は3文字以上32文字以下で入力してください!';
$_['error_owner']                      = '店舗（会館）オーナー名は3文字以上64文字以下で入力してください!';
$_['error_address']                    = '住所は10文字以上256文字以下で入力してください!';
$_['error_email']                      = 'メールアドレスが正しくありません!';
$_['error_telephone']                  = '電話番号は3文字以上32文字以下で入力してください!';

$_['error_limit']                      = '項目の表示数を入力してください!';
$_['error_customer_group_display']     = 'デフォルトの顧客グループを含める必要があります!';

$_['error_image_thumb']                = '商品のサムネイル画像のサイズを入力してください!';

$_['error_image_product']              = '商品リストの画像サイズを入力してください!';

$_['error_image_location']             = '店舗（会館）画像のサイズを入力してください!';

$_['error_ftp_hostname']               = 'FTP Hostを入力してください!';
$_['error_ftp_port']                   = 'FTP Portを入力してください!';
$_['error_ftp_username']               = 'FTP ユーザー名を入力してください!';
$_['error_ftp_password']               = 'FTP パスワードを入力してください!';
$_['error_error_filename']             = 'エラーログのファイル名を入力してください!';
$_['error_encryption']                 = '暗号化キーは3文字以上32文字以下で入力してください!';
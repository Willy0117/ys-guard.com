<?php
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('ASIA/tokyo');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

class ModelSaleSales extends Model {

	private $error = array();
	/* 追加 */
	public function addSales($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "sales SET purpose = '" . (int)$data['purpose'] 
		. "', customer_group = '" . (int)$data['customer_group']  
		. "', weekday = '" . (int)$data['weekday'] 
		. "', weather = '" . $this->db->escape($data['weather']) 
		. "', name = '" . $this->db->escape($data['name']) 
		. "', deceased = '" . $this->db->escape($data['deceased']) 
		. "', address = '" . $this->db->escape($data['address']) 
		. "', telphone = '" . $this->db->escape($data['telphone']) 
		. "', sect = '" . (int)$data['sect'] 
		. "', temple = '" . (int)$data['temple'] 
		. "', driver_id = '" . (int)$data['driver'] 
		. "', author_id = '" . (int)$this->user->getId() 
		. "', used_vehicle = '" . (int)$data['vehicle'] 
		. "', travel = '" . $data['travel']  
		. "', recorded = '" . $data['recorded']  
		. "', chage = '" . $data['highway'] 
		. "', total1 = '" . $data['total1'] 
		. "', tax1 = '" . $data['tax1'] 
		. "', total2 = '" . $data['total2'] 
		. "', tax2 = '" . $data['tax2'] 
		. "', comment = '" . $this->db->escape($data['comment']) 
		. "', date_modified = NOW(), date_added = NOW()");
		
		$id = $this->db->getLastId();
		list($y, $m, $d) = explode('-', $data['recorded']);
		
		$this->db->query("UPDATE " . DB_PREFIX . "sales SET slip = '" . "2" . substr($y,2) . "81" . sprintf('%05d', $id*2-1)
		. "', date_modified = NOW() WHERE id = '" . (int)$id . "'");


		$this->db->query("INSERT INTO " . DB_PREFIX . "sales_results SET sales_id = '" . (int)$id 
		. "', mileage = '" . json_encode($data['mileage'],JSON_UNESCAPED_UNICODE)
		. "', date_modified = NOW(), date_added = NOW()");

		$this->db->query("DELETE FROM " . DB_PREFIX . "sales_detail WHERE sales_id = '" . (int)$id . "'");
		$this->db->query("INSERT INTO " . DB_PREFIX . "sales_detail SET sales_id = '" . (int)$id 
		. "', detail = '" . json_encode($data['prices'],JSON_UNESCAPED_UNICODE)
		. "', date_modified = NOW(), date_added = NOW()");		

        if (isset( $data['selected'] )) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "sales_inspection SET sales_id = '" . (int)$id 
		      . "', selected = '" . json_encode($data['selected']) 
		      . "', date_modified = NOW(), date_added = NOW()");
        }		
	}

	public function editSale($id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "sales SET purpose = '" . (int)$data['purpose'] 
		. "', customer_group = '" . (int)$data['customer_group']  
		. "', weekday = '" . (int)$data['weekday'] 
		. "', weather = '" . $this->db->escape($data['weather']) 
		. "', name = '" . $this->db->escape($data['name']) 
		. "', deceased = '" . $this->db->escape($data['deceased']) 
		. "', address = '" . $this->db->escape($data['address']) 
		. "', telphone = '" . $this->db->escape($data['telphone']) 
		. "', sect = '" . (int)$data['sect'] 
		. "', temple = '" . (int)$data['temple'] 
		. "', driver_id = '" . (int)$data['driver'] 
		. "', author_id = '" . (int)$this->user->getId()
		. "', used_vehicle = '" . (int)$data['vehicle'] 
		. "', recorded = '" . $data['recorded']  
		. "', travel = '" . $data['travel']  
		. "', chage = '" . $data['highway'] 
		. "', total1 = '" . $data['total1'] 
		. "', tax1 = '" . $data['tax1'] 
		. "', total2 = '" . $data['total2'] 
		. "', tax2 = '" . $data['tax2'] 
		. "', comment = '" . $this->db->escape($data['comment']) 
		. "', date_modified = NOW() WHERE id = '" . (int)$id . "'");
		
		list($y, $m, $d) = explode('-', $data['recorded']);
				
		$this->db->query("UPDATE " . DB_PREFIX . "sales SET slip = '" . "2" . substr($y,2) . "81" . sprintf('%05d', $id*2-1)
		. "', date_modified = NOW() WHERE id = '" . (int)$id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "sales_results WHERE sales_id = '" . (int)$id . "'");
		$this->db->query("INSERT INTO " . DB_PREFIX . "sales_results SET sales_id = '" . (int)$id 
		. "', mileage = '" . json_encode($data['mileage'],JSON_UNESCAPED_UNICODE)
		. "', date_modified = NOW(), date_added = NOW()");

		$this->db->query("DELETE FROM " . DB_PREFIX . "sales_detail WHERE sales_id = '" . (int)$id . "'");
		$this->db->query("INSERT INTO " . DB_PREFIX . "sales_detail SET sales_id = '" . (int)$id 
		. "', detail = '" . json_encode($data['prices'],JSON_UNESCAPED_UNICODE)
		. "', date_modified = NOW(), date_added = NOW()");

		$this->db->query("DELETE FROM " . DB_PREFIX . "sales_inspection WHERE sales_id = '" . (int)$id . "'");
        if (isset( $data['selected'] )) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "sales_inspection SET sales_id = '" . (int)$id 
		  . "', selected = '" . json_encode($data['selected']) 
		  . "', date_modified = NOW(), date_added = NOW()");
        }
	}
	/*
		運行管理表作成
	*/
	public function excel($data) {
		/** Include PHPExcel */
		$file = '/var/www/html/results.xlsx';
		require_once '/var/www/html/vendor/autoload.php';

		// 既存ファイルの読み込みの場合
		$objPHPExcel = PHPExcel_IOFactory::load( $file );
		// シートの設定を行う
		$objPHPExcel -> setActiveSheetIndex(0);
		$sheet = $objPHPExcel -> getActiveSheet();
				
		$this->load->model('sale/customer_group');

		$customer_groups = $this->model_sale_customer_group->getCustomerGroups();
		
		$this->load->model('catalog/product');

		$purposes = $this->model_catalog_product->getProductsByCategoryId(6);
        
        $this->load->model('catalog/vehicle');
        
		$vehicles = $this->model_catalog_vehicle->getVehicles();
		
		//$vehicles = $this->model_catalog_product->getProductsByCategoryId(1);
			
		$this->load->model('user/user');

		$users = $this->model_user_user->getUsers();

		// セルに値をセットする
		foreach($customer_groups as $value) {
			if ($value['id'] == $data['customer_group'] ) $customer_group = $value['name'];	
		}
		
		$sheet->setCellValue("b2", $customer_group);
		$sheet->setCellValue("h11", $customer_group);

		foreach($purposes as $value) {
            if ($value['id'] == $data['purpose']) $purpose = str_replace('料金', '', $value['name']);	
		}

		$sheet->setCellValue("b7", $purpose); 						//	目的
		$sheet->setCellValue("b11",$data['travel'] );				//	運航日
		
		$weekdays = array("日","月","火","水","木","金","土");
		
		$sheet->setCellValue("d11",$weekdays[$data['weekday'] ]);	//　曜日
		$sheet->setCellValue("f11",$data['weather'] );				// 天候
		
		$sheet->setCellValue("n11",$data['deceased'] );				// 個人名
		$sheet->setCellValue("q11",$data['name'] );					// 喪主名
		$sheet->setCellValue("s11",$data['address'] );				// 住所
		$sheet->setCellValue("x11",$data['telphone'] );				// telphone

		$driver='';
		$auther='';
		foreach($users as $value) {
            if ($value['user_id'] == $data['driver']) $driver = $value['firstname'] . ' ' . $value['lastname'];
            if ($value['user_id'] == (int)$this->user->getId()) $auther = $value['firstname'] . ' ' . $value['lastname'];
		}		
		$sheet->setCellValue("u3",$driver );						// 運転手
		$sheet->setCellValue("y3",$auther );						// 作成者

		$vehicle='';
		foreach($vehicles as $value) { 
			if ($value['id'] == $data['vehicle']) $vehicle = $value['name']; 
		}
		//$sheet->setCellValue("g48", $vehicle); 						//	使用車両
		$sheet->setCellValue("g41", $vehicle); 						//	使用車両
		
		/*
			運行情報記載
		*/
		$col0 = array("18","20","21","24","26","28","29","32");
		$col1 = array("17","19","21","23","25","27","29","31");
		
		$i = 0;
		foreach($data['mileage'] as $value) {
			$sheet->setCellValue("b" . $col1[$i],$value['via'] );
			$sheet->setCellValue("d" . $col1[$i],$value['time'] );
			if ($i !=4 && $i != 6) $sheet->setCellValue("h" . $col0[$i],$value['metar'] );
			$i++;
		}
		$sheet->setCellValue("l25",$data['mileage'][4]['wait'] . " 分");// 待機時間
		$sheet->setCellValue("k28",$data['mileage'][5]['mileage'] );//　移動距離
        $sheet->setCellValue("r15",$data['mileage'][5]['mileage'] );
		/*
			売上情報記載
		*/
		$col0 = array("o15","o17","o19","n21","n25","n27","n29","n31","n33","n35");
		$col1 = array("15","17","19","21","25","27","29","31","33","35");
		
		$i = 0;
		foreach($data['prices'] as $value) {
			$sheet->setCellValue($col0[$i],$value['name'] );
			$sheet->setCellValue("u" . $col1[$i],$value['amount'] );
			$sheet->setCellValue("w" . $col1[$i],$value['tax'] );
			if ($i>2)$sheet->setCellValue("r" . $col1[$i],$value['summary'] );
			$i++;
		}		
		/*
			服装チェック
		*/
		//$col = array("d41","k41","d43","k43");
		$col = array("d34","k34","d36","k36");

		$i = 0;
		if (isset($data['selected'])) {
			$value = array("0","1","2","3");
			foreach($value as $key) {
				if (in_array($key, $data['selected'])) { 
					$sheet->setCellValue($col[$i],"適" );
				} else {
					$sheet->setCellValue($col[$i],"不適" );
				}
				$i++;
			}
		}
		//$sheet->setCellValue("u48",$data['highway'] );
		$sheet->setCellValue("u41",$data['highway'] );
		
		//小計1
		$sheet->setCellValue("u23",$data['total1'] );
		$sheet->setCellValue("u24",$data['tax1'] );
		$sheet->setCellValue("w23",$data['total1'] + $data['tax1'] );
		//小計2
		$sheet->setCellValue("u37",$data['total2'] );
		$sheet->setCellValue("u38",$data['tax2'] );
		$sheet->setCellValue("w37",$data['total2'] + $data['tax2'] );
		// ご請求金額
		$sheet->setCellValue("u39",$data['total1'] + $data['total2'] );
		$sheet->setCellValue("u40",$data['tax1'] + $data['tax2'] );
		// 総合計
		$sheet->setCellValue("w39",$data['total1'] + $data['total2'] + $data['tax1'] + $data['tax2'] );

		$output = "運行管理表". date("Y/M/d") . ".xlsx";
		
		// Redirect output to a client’s web browser (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename=' . $output);
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit;

	}
	/*
		指図書印刷
	*/
	public function print($data) {
		/** Include PHPExcel */
		$file = '/var/www/html/details.xlsx';
		require_once '/var/www/html/vendor/autoload.php';

		// 既存ファイルの読み込みの場合
		$book = PHPExcel_IOFactory::load( $file );
		// シートの設定を行う
		$book -> setActiveSheetIndex(0);
		$sheet = $book -> getActiveSheet();

		// データ作成関数を呼び出す
		
		$this->create_sheet($sheet,$data);

		$excelWriter = PHPExcel_IOFactory::createWriter($book, 'Excel2007');
		$excelWriter->save('/var/www/html/tmp/13-excel.xlsx');

		// LibreOfficeでPDF化する
		$soffice = '/opt/libreoffice5.4/program/soffice';
		$outdir = '/var/www/html/tmp/';
		$command = "$soffice --headless --convert-to pdf --outdir $outdir $outdir/13-excel.xlsx";
//echo $command, PHP_EOL;
		passthru($command);

// 読み込むPDFファイルを指定
		$file = $outdir . '/13-excel.pdf';
 
// PDFを出力する
		header("Content-Type: application/pdf");
 
// ファイルを読み込んで出力
		readfile($file);
 
		exit();
	}

	protected function create_sheet($sheet,$data) {

		$this->load->model('sale/customer_group');

		$customer_groups = $this->model_sale_customer_group->getCustomerGroups();
		// 取り扱い部署コード
		$base_groups = $this->model_sale_customer_group->getBaseGroups();
		
		$this->load->model('catalog/product');

		$purposes = $this->model_catalog_product->getProductsByCategoryId(6);
		
		$vehicles = $this->model_catalog_product->getProductsByCategoryId(1);
			
		$this->load->model('user/user');

		$users = $this->model_user_user->getUsers();

		$shop_cd = '';
		$customer_group = '';
		$base_cd = '';

		foreach($customer_groups as $value) {
			if ($value['id'] == $data['customer_group'] ) {
				$shop_cd = $value['code'];
				$customer_group = $value['name'];
				$base_cd = $value['base'];
			}
		}
		$base_name= '';
		foreach($base_groups as $value) {
			if ($value['code'] == $base_cd ) {
				$base_name = $value['name'];
			}
		}
		// セルに値をセットする
		$col=array("3","21","40","57","75","94");
		for($i=0;$i<6;$i++) {
			$sheet->setCellValue("c" . $col[$i], $shop_cd);
			$sheet->setCellValue("g" . $col[$i], $shop_cd);
			$sheet->setCellValue("k" . $col[$i], $base_cd);
			$vcol = (int)$col[$i] + 1;
			$sheet->setCellValue("c" . $vcol, $customer_group);
			$sheet->setCellValue("g" . $vcol, $customer_group);
			$sheet->setCellValue("k" . $vcol, $base_name);
			$slip = $data['slip'];
			if ($i>2) {
				list($y, $m, $d) = explode('-', $data['recorded']);
				$slip = "2" . substr($y,2) . "81" . sprintf('%05d', $data['id']*2);
			}
						 
			$vcol = (int)$col[$i] + 3;
			$sheet->setCellValue("b" . $vcol, $data['recorded'] );				//	計上日
			$sheet->setCellValue("j" . $vcol, $data['recorded'] );
			$sheet->setCellValue("p" . $vcol, $slip );
			$sheet->setCellValue("m" . $vcol, sprintf("%07d",$data['id']) );
		}
		/*
			売上情報記載
		*/
		$col0 = array("8","9","10","11","62","63","64","65","66","67");

        $i = 0;
		foreach($data['prices'] as $value) {
			if($value['name'] != '' && $value['quantity'] > 0 && $value['unit_price'] > 0) {
				$sheet->setCellValue("b" . $col0[$i],$value['name'] . ' ' . $value['model'] . ' ' . $value['summary']);
				$sheet->setCellValue("j" . $col0[$i],(int)$value['quantity'] );
				$sheet->setCellValue("k" . $col0[$i],(int)$value['unit_price'] );
				$sheet->setCellValue("m" . $col0[$i],(int)$value['amount'] );
				$sheet->setCellValue("o" . $col0[$i],(int)$value['tax'] );
			//　複写１
				$vcol = (int)$col0[$i]+18;
				$sheet->setCellValue("b" . $vcol,$value['name'] . ' ' . $value['model'] . ' ' . $value['summary']);
				$sheet->setCellValue("j" . $vcol,(int)$value['quantity'] );
				$sheet->setCellValue("k" . $vcol,(int)$value['unit_price'] );
				$sheet->setCellValue("m" . $vcol,(int)$value['amount'] );
				$sheet->setCellValue("o" . $vcol,(int)$value['tax'] );
			//	複写２
				$vcol = (int)$col0[$i]+37;
				$sheet->setCellValue("b" . $vcol,$value['name'] . ' ' . $value['model'] . ' ' . $value['summary']);
				$sheet->setCellValue("j" . $vcol,(int)$value['quantity'] );
				$sheet->setCellValue("k" . $vcol,(int)$value['unit_price'] );
				$sheet->setCellValue("m" . $vcol,(int)$value['amount'] );
				$sheet->setCellValue("o" . $vcol,(int)$value['tax'] );			
			}
			$i++;
		}		
		
		$sheet->setCellValue("m15",$data['total1'] );
		$sheet->setCellValue("o15",$data['tax1'] );
		$sheet->setCellValue("m16",(int)($data['total1']+$data['tax1']) );
		
		$sheet->setCellValue("m33",$data['total1'] );
		$sheet->setCellValue("o33",$data['tax1'] );
		$sheet->setCellValue("m34",(int)($data['total1']+$data['tax1']) );
		
		$sheet->setCellValue("m52",$data['total1'] );
		$sheet->setCellValue("o52",$data['tax1'] );
		$sheet->setCellValue("m53",(int)($data['total1']+$data['tax1']) );

		$sheet->setCellValue("m69",$data['total2'] );
		$sheet->setCellValue("o69",$data['tax2'] );
		$sheet->setCellValue("m70",(int)($data['total2']+$data['tax2']) );

		$sheet->setCellValue("m87",$data['total2'] );
		$sheet->setCellValue("o87",$data['tax2'] );
		$sheet->setCellValue("m88",(int)($data['total2']+$data['tax2']) );

		$sheet->setCellValue("m106",$data['total2'] );
		$sheet->setCellValue("o106",$data['tax2'] );
		$sheet->setCellValue("m107",(int)($data['total2']+$data['tax2']) );
        //コメント追加
		$sheet->setCellValue("b17",$data['comment'] );
		$sheet->setCellValue("b35",$data['comment'] );
		$sheet->setCellValue("b54",$data['comment'] );

		$sheet->setCellValue("b71",$data['comment'] );
		$sheet->setCellValue("b89",$data['comment'] );
		$sheet->setCellValue("b108",$data['comment'] );

	}
	/*
	経済連送信データ作成
	*/
	public function send( $selected = array() ) {
		
		$ys = "8696820";// YS警備の経済連コード

		$this->load->model('sale/customer_group');

		$customer_groups = $this->model_sale_customer_group->getCustomerGroups();
		// 取り扱い部署コード
		$base_groups = $this->model_sale_customer_group->getBaseGroups();
		
		$this->load->model('catalog/product');

		$purposes = $this->model_catalog_product->getProductsByCategoryId(6);
		
		$this->load->model('user/user');

		$users = $this->model_user_user->getUsers();

		//CSV形式で情報をファイルに出力のための準備
		$txtFileName = '/var/www/html/tmp/yskeibi.txt';

		$res = fopen($txtFileName, 'w');
		
		$i = 0;

		// ループしながら出力
		
		foreach($selected as $id) { 
				
			$data = $this->getSale($id);
            
			$shop_cd = '';
			$customer_group = '';
			$base_cd = '';

			foreach($customer_groups as $value) {
				if ($value['id'] == $data['customer_group'] ) {
					$shop_cd = $value['code'];
					$customer_group = $value['name'];
					$base_cd = $value['base'];
				}
			}
			
			$data['id'] = $id;
			
			list($y, $m, $d) = explode('-', $data['recorded']);

			$data['recorded'] = date('Ymd', strtotime($data['recorded']));
			$data['travel'] = date('Ymd', strtotime($data['travel'] ));

			$sales_mileage = $this->getMileage($id);
			$sales_detail = $this->getDetail($id);
				
			$data['mileage'] = (array)json_decode($sales_mileage['mileage'],true);
		
			$data['prices'] = (array)json_decode($sales_detail['detail'],true);
			
			$i++;
			
			$hd = 'NDA' . sprintf("%06d",$i) . 'HD';
			$hd .= $shop_cd . $shop_cd . '50' . sprintf("%-4s",'') . $base_cd  . $data['slip'];// 伝票番号
			$hd .= sprintf("%-35s",'');
			$hd .= $data['recorded'] . $data['recorded'] . $ys . $ys . '64';
			$hd .= sprintf("%-3s",'');//経済連摘要コード
			$hd .= sprintf("%-3s",'');
			$hd .= sprintf("%-3s",'');
			$hd .= sprintf("%-3s",'');
			$hd .= sprintf("%-3s",'');
			$hd .= sprintf("%-7s",'');
			$hd .= sprintf("%-24s",'');
			$hd .= sprintf("%-24s",'');
			$hd .= sprintf("%-1s",'');
			$hd .= sprintf("%-70s",'');
			$out[$i-1] = str_pad($hd,256," ");
        
            if ($data['prices']['4']['unit_price'] == 0 && $data['prices']['5']['unit_price'] == 0 && $data['prices']['6']['unit_price'] == 0 && $data['prices']['7']['unit_price'] == 0 && $data['prices']['8']['unit_price'] == 0 && $data['prices']['3']['unit_price'] == 0) $skip = true; else $skip= false;
			
			$j = 0;// 行数カウント
			$p = 0;// 明細カウント
			foreach($data['prices'] as $value) {
                if ( $skip && $j>2) continue;
                if ( $j>9 ) continue;
				if ( $j == 4 ) {
					$i++;
					$slip = "2" . substr($y,2) ."81" . sprintf('%05d', $id*2);			
					$hd = 'NDA' . sprintf("%06d",$i) . 'HD';
					$hd .= $shop_cd . $shop_cd . '50' . sprintf("%-4s",'') . $base_cd  . $slip;// 伝票番号
					$hd .= sprintf("%-35s",'');
					$hd .= $data['recorded'] . $data['recorded'] . $ys . $ys . '64';
					$hd .= sprintf("%-3s",'');//経済連摘要コード
					$hd .= sprintf("%-3s",'');
					$hd .= sprintf("%-3s",'');
					$hd .= sprintf("%-3s",'');
					$hd .= sprintf("%-3s",'');
					$hd .= sprintf("%-7s",'');
					$hd .= sprintf("%-24s",'');
					$hd .= sprintf("%-24s",'');
					$hd .= sprintf("%-1s",'');
					$hd .= sprintf("%-70s",'');
					$out[$i-1] = str_pad($hd,256," ");

					$p = 0;
				}
				if ($value['unit_price'] > 0 && $value['quantity'] > 0) {
					if ($p == 0 || $p%2 == 0) {
						$out[$i-1] = str_pad($out[$i-1],256," ");
						$i++;
						$out[$i-1] = 'NDA' . sprintf("%06d",$i) . 'SD';
					}
					$p++;	

					$out[$i-1] .= sprintf("%02d",$p);
					$out[$i-1] .= sprintf("%-17s",$value['model']) . sprintf("%08d000",$value['quantity']);
					$out[$i-1] .= sprintf("%08d00",$value['unit_price']);
					$out[$i-1] .= sprintf("%011d",$value['amount']);
					$out[$i-1] .= sprintf("%08d00",$value['invoice']);
					$out[$i-1] .= sprintf("%011d",$value['invoice']*$value['quantity']);
					$out[$i-1] .= sprintf("%08d00",0);
					$out[$i-1] .= sprintf("%-30s",'') . 'B' . sprintf("%-1s",''). sprintf("%-8s",'');
				}
				$j++;
			}
				
			$n = 1;
            /* update 帳票送信済み */
            $this->db->query("UPDATE " . DB_PREFIX . "sales SET status = '" . $n . "', date_modified = NOW() WHERE id = '" . (int)$id . "'");
				// ファイルに書き出しをする
		}
		foreach ($out as $a){
			fputs($res,str_pad($a,256," ")."\n");
		}
		// トレーラ情報
		$i++;
		$out[$i-1] = 'NDA' . sprintf("%06d",$i) . 'OD' . sprintf("%06d",$i-1);
		$out[$i-1] .= date('Ymd');

		fputs($res,$out[$i-1]."\n");
		
		// ハンドル閉じる
		fclose($res);

		// ダウンロード開始
		header('Content-Type: application/octet-stream');

		// ここで渡されるファイルがダウンロード時のファイル名になる
		header('Content-Disposition: attachment; filename=yskeibi.txt'); 

		readfile($txtFileName);
		 
		exit();
	}

	/*
	印刷データ作成
	*/
	public function pdf( $selected = array() ) {
		/** Include PHPExcel */
		$file = '/var/www/html/details.xlsx';
		require_once '/var/www/html/vendor/autoload.php';

		// 既存ファイルの読み込みの場合
		$book = PHPExcel_IOFactory::load( $file );
		// シートの設定を行う
		//$book -> setActiveSheetIndex(0);
		//$sheet = $book -> getActiveSheet();

		$sheet_no = 0;
		
		foreach($selected as $id) { 
			$baseSheet = $book->getSheet( 0 );
			$newSheet = $baseSheet->copy();
			$newSheet->setTitle( 'sheet' . $sheet_no );
			$book->addSheet( $newSheet );
			$sheet = $book -> getSheetByName( 'sheet' . $sheet_no );
			
			$data = $this->getSale($id);
			$data['id'] = $id;

			$data['recorded'] = date('Y-m-d', strtotime($data['recorded']));
			$data['travel'] = date('Y-m-d', strtotime($data['travel'] ));

			$sales_mileage = $this->getMileage($id);
			$sales_detail = $this->getDetail($id);
			
			$data['mileage'] = (array)json_decode($sales_mileage['mileage'],true);
		
			$data['prices'] = (array)json_decode($sales_detail['detail'],true);

			// データ作成関数を呼び出す
		
			$this->create_sheet($sheet,$data);			
			
			$sheet_no++;
			
			$n = (int)$data['print']+1;
			
			$this->db->query("UPDATE " . DB_PREFIX . "sales SET print = '" . $n 
			. "', date_modified = NOW() WHERE id = '" . (int)$id . "'");
			
		}
		// シート「Worksheet 0」を削除する
		$book->removeSheetByIndex(0);
		// 書き出し
		$excelWriter = PHPExcel_IOFactory::createWriter($book, 'Excel2007');
		$excelWriter->save('/var/www/html/tmp/13-excel.xlsx');

		// LibreOfficeでPDF化する
		$soffice = '/opt/libreoffice5.4/program/soffice';
		$outdir = '/var/www/html/tmp/';
		$command = "$soffice --headless --convert-to pdf --outdir $outdir $outdir/13-excel.xlsx";
//echo $command, PHP_EOL;
		passthru($command);

// 読み込むPDFファイルを指定
		$file = $outdir . '/13-excel.pdf';
 
// PDFを出力する
		header("Content-Type: application/pdf");
 
// ファイルを読み込んで出力
		readfile($file);
 
		exit();
	}
	
	
	/*
		削除
	*/
	public function deleteSales($id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "sales WHERE id = '" . (int)$id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "sales_detail WHERE sales_id = '" . (int)$id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "sales_inspection WHERE sales_id = '" . (int)$id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "sales_results WHERE sales_id = '" . (int)$id . "'");
	}		

	public function getSale($id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "sales p LEFT JOIN " . DB_PREFIX . "sales_inspection pc ON (p.id = pc.sales_id)  WHERE p.id = '" . (int)$id  . "'");

		return $query->row;
	}

	public function getMileage($id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "sales_results WHERE sales_id = '" . (int)$id  . "'");

		return $query->row;
	}	

	public function getDetail($id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "sales_detail WHERE sales_id = '" . (int)$id  . "'");

		return $query->row;
	}	
	
	public function getSales($data = array()) {
         $sql = "SELECT * FROM " . DB_PREFIX . "sales WHERE 1 ";
						
		if (!empty($data['filter_name'])) {
			$sql .= " AND name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}
						
		if (!empty($data['filter_slip'])) {
			$sql .= " AND slip LIKE '%" . $this->db->escape($data['filter_slip']) . "%'";
		}
		
		if (!empty($data['filter_address'])) {
			$sql .= " AND address LIKE '%" . $this->db->escape($data['filter_address']) . "%'";
		}						

		if (!empty($data['filter_customer_group'])) {
			$sql .= " AND customer_group = '" . $data['filter_customer_group'] . "'";
		}
		
		if (!empty($data['filter_travel'])) {
			$sql .= " AND travel = '" . $data['filter_travel'] . "'";
		}						

		if (!empty($data['filter_recorded'])) {
			$sql .= " AND recorded = '" . $data['filter_recorded'] . "'";
		}						
						
		if (!empty($data['filter_deceased'])) {
			$sql .= " AND deceased LIKE '%" . $this->db->escape($data['filter_deceased']) . "%'";
		}
						
		if (!empty($data['filter_purpose'])) {
			$sql .= " AND purpose LIKE '%" . $this->db->escape($data['filter_purpose']) . "%'";
		}
        
		if (isset($data['filter_status']) && $data['filter_status'] !== null) {
			$sql .= " AND status = '" . (int)$data['filter_status'] . "'";
		}

		$sql .= " GROUP BY id";

		$sort_data = array(
			'id',
			'name',
			'customer_group',
			'purpose',
			'slip',
			'status',
			'sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY id";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
		$query = $this->db->query($sql);
		return $query->rows;		
	}	

	public function getTotalSales($data = array()) {
       	$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "sales WHERE 1 ";

		if (!empty($data['filter_name'])) {
			$sql .= " AND name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}						
						
		if (!empty($data['filter_slip'])) {
			$sql .= " AND slip LIKE '%" . $this->db->escape($data['filter_slip']) . "%'";
		}
		
		if (!empty($data['filter_address'])) {
			$sql .= " AND address LIKE '%" . $this->db->escape($data['filter_address']) . "%'";
		}						

		if (!empty($data['filter_customer_group'])) {
			$sql .= " AND customer_group = '" . $data['filter_customer_group'] . "'";
		}

		if (!empty($data['filter_travel'])) {
			$sql .= " AND travel = '" . $data['filter_travel'] . "'";
		}						

		if (!empty($data['filter_recorded'])) {
			$sql .= " AND recorded = '" . $data['filter_recorded'] . "'";
		}						

		if (!empty($data['filter_deceased'])) {
			$sql .= " AND deceased LIKE '%" . $this->db->escape($data['filter_deceased']) . "%'";
		}
						
		if (!empty($data['filter_purpose'])) {
			$sql .= " AND purpose LIKE '%" . $this->db->escape($data['filter_purpose']) . "%'";
		}
        
		if (isset($data['filter_status']) && $data['filter_status'] !== null) {
			$sql .= " AND status = '" . (int)$data['filter_status'] . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];		
	}	

	public function getSalesByVehicleId($id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "sales WHERE used_vehicle = '" . (int)$id . "'");
		return $query->row['total'];
	}
}

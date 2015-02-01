<?php
/**
 * Created by PhpStorm.
 * User: Firzen
 * Date: 6/12/14
 * Time: 9:05 PM
 */

class AppHelper {

	/**
	 * Format số điện thoại theo chuẩn quốc tế 84...
	 * @param string $phone
	 * @return mixed|null
	 */
	public static function standardizePhone($phone = '', $prefix='+84'){
		if(!$phone)
			return null;
		if(!preg_match('/^(0)|(84)|(\+84)/',$phone))
			$phone=$prefix.$phone;
		return preg_replace('/^(0)|(84)/',$prefix,$phone);
	}

	/**
	 * Hàm giải mã signinTicket thành username/password để kiểm tra đăng nhập
	 * Returns decrypted original string
	 */
	public static function decryptTicket($ticket,$encryptionKey) {
		$ticket=base64_decode($ticket);
		$iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryptionKey, $ticket, MCRYPT_MODE_ECB, $iv);
		$decrypted_string = trim($decrypted_string, "\0\4");
		return json_decode($decrypted_string,true);
	}

	public static function getPrefixCustomer(){
		return array(''=>'-- Select one --','mr'=>'Mr','ms'=>'Ms','mrs'=>'Mrs');
	}

	public static function getGender(){
		return array(''=>'-- Select one --','1'=>'Male','0'=>'Female');
	}

	public static function getDate(){
		$data=array();
		$data['']='Date';
		for($i=1;$i<=31;$i++)
			$data[$i]=$i;
		return $data;
	}

	public static function getMonth(){
		$data=array();
		$data['']='Month';
		for($i=1;$i<=12;$i++)
			$data[$i]=$i;
		return $data;
	}

	public static function getYear(){
		$data=array();
		$data['']='Year';
		for($i=(date('Y'));$i>=(date('Y')-100);$i--)
			$data[$i]=$i;
		return $data;
	}

	public static function checkLeapYear($date,$mounth,$year){
		if($date > 28 && $date==29 && $mounth==2){
			if(!($year%400==0) && !($year%4==0 && $year%100!=0)){
				return false;
			}else
				return true;
		}
		if($date <= 28 && $mounth==2){
			return true;
		}
		if($date<=30 && in_array($mounth,array('4','6','10','11'))){
			return true;
		}
		if($date<=31 && in_array($mounth,array('5','3','1','7','8','7','9','12'))){
			return true;
		}
		return false;
	}

	public static  function generateRandomString($length = 6) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$&*';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}

	/**
	 * Chart drawing function
	 * @param $query
	 * @return \Illuminate\View\View
	 */
	public static function drawChart($query, $title, $startDate, $endDate, $chartType='AreaChart', $width=600, $height=400){
		$timesTable = Lava::DataTable('Times');
		$timesTable->addColumn('date', 'Dates', 'dates')
			->addColumn('number', 'Count', 'run')
			->addColumn('number', 'Value', 'run');

		$chartRecords = $query->get();

		$total_count = 0;
		$total_value = 0;
		if (!empty($chartRecords)) {
			foreach ($chartRecords as $rec) {
				$data = array(
					Lava::jsDate(date('Y', strtotime($rec->row_date)), intval(date('m', strtotime($rec->row_date))) - 1, date('d', strtotime($rec->row_date))),
					$rec->row_count,
					round($rec->row_value/100000),
				);

				$total_value += round($rec->row_value/100000);
				$total_count += $rec->row_count;

				$timesTable->addRow($data);
			}
		}

		$summary = array(
			'Total count' => number_format($total_count),
			'Total value' => number_format($total_value),
			'Start date' => $startDate,
			'End date' => $endDate
		);

		$config = array(
			'title' => $title,
			'hAxis' => Lava::hAxis(array('title' => 'Date')),
			'vAxis' => Lava::vAxis(array('title' => 'Value'))
		);
		Lava::$chartType('Times')->setConfig($config);

		return View::make("charts.index", array(
			'summary' => $summary,
			'chartType' => $chartType,
			'width' => $width,
			'height' => $height,
		));
	}

	/**
	 * @param $chart_query
	 * @return array
	 */
	public static function assignChartDate(&$chart_query)
	{
		if (Input::has('created_at_from'))
			$start_date = Input::get('created_at_from');
		else
			$start_date = date('Y-m', time()) . '-01';

		if (Input::has('created_at_to'))
			$end_date = Input::get('created_at_to');
		else
			$end_date = date('Y-m-d', time());

		$chart_query = $chart_query->whereBetween('created_at', array($start_date, $end_date));
		return array($start_date, $end_date);
	}
} 
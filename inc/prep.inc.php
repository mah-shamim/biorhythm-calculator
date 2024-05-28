<?php
header("Expires: Mon, 29 Jan 1990 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
function libraries_autoload(string $class_name): void {
	require __DIR__.'/lib/'.$class_name.'.class.php';
}
function google_api_php_client_autoload(string $class_name): void {
	$class_path = explode('_', $class_name);
	if ($class_path[0] != 'Google') {
		return;
	}
	if (count($class_path) > 3) {
		// Maximum class file path depth in this project is 3.
		$class_path = array_slice($class_path, 0, 3);
	}
	$file_path = __DIR__.'/includes/' . implode('/', $class_path) . '.php';
	if (file_exists($file_path)) {
		require($file_path);
	}
}
spl_autoload_register('libraries_autoload');
spl_autoload_register('google_api_php_client_autoload');
function is_public_server(): bool {
	if (substr($_SERVER['REMOTE_ADDR'],0,7) == '108.162' || substr($_SERVER['REMOTE_ADDR'],0,7) == '173.245' || substr($_SERVER['REMOTE_ADDR'],0,6) == '66.220' || substr($_SERVER['REMOTE_ADDR'],0,7) == '173.252' || substr($_SERVER['REMOTE_ADDR'],0,5) == '31.13' || substr($_SERVER['REMOTE_ADDR'],0,10) == '64.233.172' || substr($_SERVER['REMOTE_ADDR'],0,5) == '69.63' || substr($_SERVER['REMOTE_ADDR'],0,6) == '69.171' || substr($_SERVER['REMOTE_ADDR'],0,6) == '66.102' || substr($_SERVER['REMOTE_ADDR'],0,9) == '66.249.83' || substr($_SERVER['REMOTE_ADDR'],0,6) == '66.249' || $_SERVER['REMOTE_ADDR'] == '23.92.24.198') {
		return true;
	} else {
		return false;
	}
}
function is_bot(): bool {
	if (isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/bot|crawl|slurp|spider/i', $_SERVER['HTTP_USER_AGENT'])) {
		return true;
	} else {
		return false;
	}
}
function prevent_xss(string $query_string): string {
	return htmlentities($query_string, ENT_QUOTES, 'UTF-8');
}
function digitval(int $number): int {
	$sum = 0;
	while ($number > 0) {
	    $rem = intval($number) % 10;
	    $number = $number / 10;
	    $sum = $sum + $rem;
	}
	if (strlen($sum) >= 2)
		$res = digitval($sum);
	elseif ($sum == 11 || $sum == 22)
		$res = $sum;
	else
		$res = $sum;
	return $res;
}
function calculate_life_path(string $dob): int {
	$life_path_number = 0;
	$year = date('Y',strtotime($dob));
	$month = date('m',strtotime($dob));
	$day = date('d',strtotime($dob));
	$life_path_number = digitval(digitval($year) + digitval($month) + digitval($day));
	return $life_path_number;
}
function has_one_lang(): bool {
	global $hide_lang_bar;
	global $hide_nav;
	if ($hide_lang_bar == true && $hide_nav == true) {
		return true;
	} else {
		return false;
	}
}
function is_paid_member(string $email): bool {
	$path = __DIR__.'/member/'.strtolower($email);
	$receipt_path = $path.'/paid.txt';
	if (file_exists($receipt_path)) {
		return true;
	} else {
		return false;
	}
}

/* General Functions */
function load_all_array(string $table_name): array { //Put all table records into an array
	global $pdo;
	$array = array();
	$result = $pdo->prepare('SELECT * FROM `'.$table_name.'`');
	$result->execute();
	if ($result) {
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$array[] = $row;
		}
	}
	return $array;
}
function load_array_with_operator(string $table_name,string $identifier,string $value,string $operator): array { //Put specific table records according to condition into an array
	global $pdo;
	$array = array();
	$result = $pdo->prepare('SELECT * FROM `'.$table_name.'` WHERE `'.$identifier.'`'.$operator.':value');
	$result->execute(array(':value' => $value));
	if ($result) {
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$array[] = $row;
		}
	}
	return $array;
}
function load_array_with_two_identifiers(string $table_name,string $identifier1,string $value1,string $identifier2,string $value2): array { //Load array from database with 2 identifiers
	global $pdo;
	$array = array();	
	$result = $pdo->prepare('SELECT * FROM `'.$table_name.'` WHERE `'.$identifier1.'`=:value1 AND `'.$identifier2.'`=:value2');
	$result->execute(array(':value1' => $value1, ':value2' => $value2));
	if ($result) {
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$array[] = $row;
		}
	}
	return $array;
}
function load_array_with_two_values(string $table_name,string $identifier,string $value1,string $value2): array { //Load array from database with 1 identifier and 2 values
	global $pdo;
	$array = array();	
	$result = $pdo->prepare('SELECT * FROM `'.$table_name.'` WHERE `'.$identifier.'`=:value1 OR `'.$identifier.'`=:value2');
	$result->execute(array(':value1' => $value1, ':value2' => $value2));
	if ($result) {
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$array[] = $row;
		}
	}
	return $array;
}
function load_array(string $table_name,string $identifier,string $value): array { //Load array from database with 1 identifier and 1 value
	$array = load_array_with_operator($table_name,$identifier,$value,'=');
	return $array;
}
function search_array(string $table_name,string $identifier,string $value): array {
	global $pdo;
	$array = array();
	$result = $pdo->prepare('SELECT * FROM `'.$table_name.'` WHERE `'.$identifier.'` LIKE :value');
	$result->execute(array(':value' => `%$value%`));
	if ($result) {
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$array[] = $row;
		}
	}
	return $array;
}
function insert_record(array $array = array(),string $table_name = ''): void { //Insert table record
	global $pdo;
	$keys = array_keys($array);
	$values = array_values($array);
	$execute_array = array();
	$count = count($array);
	$query = ``;
	$query .= 'INSERT INTO `'.$table_name.'`(';
	for ($k = 0; $k < $count; ++$k) {
		$query .= $keys[$k].(($k < ($count - 1)) ? ',': ``);
	}
	$query .= ') VALUES(';
	for ($i = 0; $i < $count; ++$i) {
		$query .= '?'.(($i < ($count - 1)) ? ',': ``);
	}
	$query .= ')';
	for ($e = 0; $e < $count; ++$e) {
		$execute_array[$e] = $values[$e];
	}
	$result = $pdo->prepare($query);
	$result->execute($execute_array);
}
function update_record_with_operator(array $array = array(),string $identifier = '',string $value = '',string $table_name = '',string $operator = ''): void { //Update table record
	global $pdo;
    if(!empty($identifier) && !empty($value) && !empty($table_name) && !empty($operator)){

    }
	$keys = array_keys($array);
	$values = array_values($array);
	$execute_array = array();
	$count = count($array);
	$query = ``;
	$query .= 'UPDATE `'.$table_name.'` SET ';
	for ($i = 0; $i < $count; ++$i) {
		$query .= $keys[$i].'=?'.(($i < ($count - 1)) ? ',': ``);
	}
	$query .= ' WHERE `'.$identifier.'`'.$operator.'?';
	for ($e = 0; $e < $count; ++$e) {
		$execute_array[$e] = $values[$e];
	}
	$execute_array[$count] = $value;
	$result = $pdo->prepare($query);
	$result->execute($execute_array);
}
function update_record(array $array = array(),string $identifier = '',string $value = '',string $table_name = ''): void { //Update table record
	update_record_with_operator($array, $identifier, $value, $table_name, '=');
}
function delete_record(string $identifier,string $value,string $table_name): void { //Delete table records with 1 identifier
	global $pdo;
	$result = $pdo->prepare('DELETE FROM `'.$table_name.'` WHERE `'.$identifier.'`=:value');
	$result->execute(array(':value' => $value));
}
function delete_record_with_two_identifier(string $identifier1,string $value1,string $identifier2,string $value2,string $table_name): void { //Delete table records with 2 identifiers
	global $pdo;
	$result = $pdo->prepare('DELETE FROM `'.$table_name.'` WHERE `'.$identifier1.'`=:value1 AND `'.$identifier2.'`=:value2');
	$result->execute(array(':value1' => $value1, ':value2' => $value2));
}
function table_row_class($id): string { //Identify the table row class based on counter
	$output = "";
	if ((($id+1) % 2) == 1) {
		$output .= ' odd';
	} else {
		$output .= ' even';
	}
	return $output;
}
function pluralize($count, $singular, $plural = false): string {
	if (!$plural) $plural = $singular . 's';
	return (($count == 0 || $count == 1) ? $singular : $plural) ;
}
function substr_word(string $str,string $start,string $end): string { //Substract words from content
	$end_pos = strpos($str,' ',$end);
	if ($pos !== false) {
		return substr($str,$start,$end_pos);
	}
}
function load_user($uid) { //Load user array from user ID
	$users = load_array('nsh_users','uid',$uid);
	sort($users);
	return $users[0];
}
function load_user_from_name(string $name) { //Load user array from username
	$users = load_array('nsh_users','name',$name);
	sort($users);
	return $users[0];
}
function load_rhythm($rid) { //Load rhythm array from rhythm ID
	$rhythms = load_array('nsh_rhythms','rid',$rid);
	sort($rhythms);
	return $rhythms[0];
}
function load_credential($id) { //Load credential array from ID
	$credentials = load_array('nsh_@dm!n','id',$id);
	sort($credentials);
	return $credentials[0];
}
function get_rhythm_title($rid,string $lang): string {
	$rhythm = load_rhythm($rid);
	switch ($lang) {
		case 'vi':
			return $rhythm['name'];
			break;
		case 'en':
			return $rhythm['description_en'];
			break;
		case 'ru':
			return $rhythm['description_ru'];
			break;
		case 'es':
			return $rhythm['description_es'];
			break;
		case 'zh':
			return $rhythm['description_zh'];
			break;
		case 'ja':
			return $rhythm['description_ja'];
			break;
	}
}
function render_blog_feed() {
	$curl = curl_init();
	curl_setopt_array($curl, Array(
		CURLOPT_URL            => 'https://biorhythm.xyz/blog/feed/',
		CURLOPT_USERAGENT      => 'spider',
		CURLOPT_TIMEOUT        => 120,
		CURLOPT_CONNECTTIMEOUT => 30,
		CURLOPT_RETURNTRANSFER => TRUE,
		CURLOPT_ENCODING       => 'UTF-8'
	));
	$data = curl_exec($curl);
	curl_close($curl);
	$xml = simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);
  foreach ($xml->channel->item as $item) {
    $creator = $item->children('dc', TRUE);
    echo '<div class="card col-12 col-xl-4 col-lg-6 col-md-12 col-sm-12 shadow-lg rounded float-left">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title"><a href="'.$item->link.'" target="_blank">'.$item->title.'</a></h5>';
    echo '<p class="card-text">'.$item->description.'</p>';
    echo '</div>';
    echo '<div class="card-footer">';
    echo '<small class="text-muted">'.$item->pubDate.'</small>';
    echo '</div>';
    echo '</div>';
  }
}
function render_blog_posts() {
  $url = 'https://biorhythm.xyz/blog/wp-json/wp/v2/posts/?per_page=6';
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_URL,$url);
  $result=curl_exec($ch);
  $posts = json_decode($result, true);
  foreach ($posts as $post) {
    echo '<div class="card col-12 col-xl-4 col-lg-6 col-md-6 col-sm-12 shadow-lg rounded">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title"><a href="'.$post['link'].'" target="_blank">'.$post['title']['rendered'].'</a></h5>';
    echo '<p class="card-text">'.$post['excerpt']['rendered'].'</p>';
    echo '</div>';
    echo '<div class="card-footer">';
    echo '<small class="text-muted">'.date('F j, Y', strtotime($post['date'])).'</small>';
    echo '</div>';
    echo '</div>';
  }
}
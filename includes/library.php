<?php 
		function exist_in_array($item,$array,$column){
		foreach ($array as $a){
			if ($a[$column] == $item){
				return true;
			}
		}
		return false;
	}
	function get_today_span()
	{
		
		$nom_jour_fr = array("dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi");
		$mois_fr = Array("", "janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", 
        "septembre", "octobre", "novembre", "décembre");
		list($nom_jour, $jour, $mois, $annee) = explode('/', date("w/d/n/Y"));
 
		return $nom_jour_fr[$nom_jour].' '.$jour.' '.$mois_fr[$mois].' '.$annee; 
	}
	function increment_count_room($id_residence){
		$db = db_connect();
		$db->query("UPDATE  `residence_type` SET  `nb_chambre_total` =  nb_chambre_total+1 WHERE  `residence_type`.`id` =".$id_residence);
	}
	function decrement_count_room($id_residence){
		$db = db_connect();
		$db->query("UPDATE  `residence_type` SET  `nb_chambre_total` =  nb_chambre_total-1 WHERE  `residence_type`.`id` =".$id_residence);
	}
	
	
	function init_price_residence($id_residence){
		$db = db_connect();
		$residence_type = $db->get_row("SELECT residence_type.* FROM residence_type WHERE  residence_type.id=".$db->escape($id_residence));
		$residence_prix = $db->get_row("SELECT residence_prix.* FROM residence_prix WHERE  residence_prix.type= 'standard' and  residence_prix.id_residence=".$db->escape($id_residence));
		if (empty($residence_prix)){
			$new_residence_type=array();
			$new_residence_type['id_residence']=$id_residence;
			$new_residence_type['prix_lun']=$residence_type['default_price'];
			$new_residence_type['prix_mar']=$residence_type['default_price'];
			$new_residence_type['prix_mer']=$residence_type['default_price'];
			$new_residence_type['prix_jeu']=$residence_type['default_price'];
			$new_residence_type['prix_ven']=$residence_type['default_price'];
			$new_residence_type['prix_sam']=$residence_type['default_price'];
			$new_residence_type['prix_dim']=$residence_type['default_price'];
			$new_residence_type['type']="standard";
			$new_residence_type['statut']="1";
			
			if(!$db->insert('residence_prix',$new_residence_type)) {}
		}
	}
	
	
	function generate_reference_reservation(){
		$db = db_connect();
		$query="SELECT count(*) as max_ref FROM  `residence_reservation` WHERE  `ref` LIKE  'R".date("mY")."%'";
		$count=$db->get_row($query);
		$max_ref=$count['max_ref'];
		$max_ref++;
		$max_ref= str_pad($max_ref, 4, "0", STR_PAD_LEFT); 
		$ref = "R".date("mY").$max_ref;
		return $ref;
	}
	function toStamp2($date) {
	$d = explode('-', $date);
	$date2 = mktime(0,0,0, $d[1], $d[2], $d[0]);
	return $date2;
	}
	function date_diff2($date1, $date2) {
	$s = strtotime($date2)-strtotime($date1);
	//$d = intval($s/86400)+1;
	$d = intval($s/86400);
	return $d;
	}
	function get_price_per_period_and_type($periode_de,$periode_a,$id_type_residence)
	{
	$db = db_connect();
	$residence_prix = $db->get_row("SELECT residence_prix.* FROM residence_prix WHERE  residence_prix.type= 'personalise' and  residence_prix.id_residence=".$db->escape($id_type_residence)."
	and ('".$periode_de."' >= periode_de )
	and ('".$periode_a."' <= periode_a )
	and statut = 1
	");
	
	if (empty($residence_prix)){
	$residence_prix = $db->get_row("SELECT residence_prix.* FROM residence_prix WHERE  residence_prix.type= 'standard' and  residence_prix.id_residence=".$db->escape($id_type_residence));
	}
	
	$prix_lun=$residence_prix['prix_lun'];
	$prix_mar=$residence_prix['prix_mar'];
	$prix_mer=$residence_prix['prix_mer'];
	$prix_jeu=$residence_prix['prix_jeu'];
	$prix_ven=$residence_prix['prix_ven'];
	$prix_sam=$residence_prix['prix_sam'];
	$prix_dim=$residence_prix['prix_dim'];
	
	
	
	
	
	$d1 = $periode_de;
	$d2 = $periode_a;
	
	$nb_jours = date_diff2($d1, $d2);
	
	$jour_apres = toStamp2($d1)-(60*60*24);
	$prix_par_jours=array();
	for($i = 0; $i < $nb_jours; $i++) {
	$weekn = '';
	$jour_apres += (60*60*24);
	$index_day = date('w', $jour_apres);
	if ($index_day == 1){$prix_par_jours[]=$prix_lun;}
	if ($index_day == 2){$prix_par_jours[]=$prix_mar;}
	if ($index_day == 3){$prix_par_jours[]=$prix_mer;}
	if ($index_day == 4){$prix_par_jours[]=$prix_jeu;}
	if ($index_day == 5){$prix_par_jours[]=$prix_ven;}
	if ($index_day == 6){$prix_par_jours[]=$prix_sam;}
	if ($index_day == 0){$prix_par_jours[]=$prix_dim;}
	
	//echo date('d/m/Y', $jour_apres) .' '. $index_day .'<br />';
	}
	$total=0;
	foreach ($prix_par_jours as $prix){
	$total+=$prix;
	}
	
	
	
	return $total;
	}
	
	
	
	
	function calculate_reduction($price,$code,$id_code_promo){
	$date = date('Y-m-d H:i:s');
	$db = db_connect();
	$code_promo = $db->get_row("SELECT * FROM code_promo WHERE code_promo.id_code_promo='$id_code_promo' AND code_promo.code='$code' AND code_promo.active='1' AND code_promo.used='0' AND code_promo.expire > '$date'");
	
	if(!empty($code_promo)){
	
	
	if($code_promo['type']=='1'){
	$amount = ($code_promo['discount'] * $price) / 100;
	}else{
	$amount = $code_promo['price'];
	}
	
	
	
	return numberFormat($price - $amount);
	}else{
	return false;
	}
	}
	
	function get_Time($time){
	
	$explode = explode(':',$time);
	
	if(!isset($explode['1'])){
	return false;
	}
	
	$h = $explode['0'];
	$m = $explode['1'];
	
	if($h>0 && $m>0){
	return (int)$h.'h '.(int)$m.'min';
	}else if ($h>0 && $m==0){
	return (int)$h.'h';
	}else{
	return (int)($m).'min';
	}
	
	
	}
	
	function auth() {
	
	
	/* 	 echo "<pre>";
	print_r($_SESSION);
	echo "</pre>";
	die(); */
	if(!isset($_SESSION['User']['username'])) {
	$_SESSION['notification'] = array('type'=>'error','msg'=>'Authentification requise');
	echo "<script>document.location.href='index.php'</script>";
	exit;
	}
	
	if(isset($_SESSION['Time'])) {
	
	$period = 120*120;
	if( time() - $_SESSION['Time'] >= $period ) {
	unset($_SESSION['User']);
	$_SESSION['notification'] = array('type'=>'error','msg'=>"Votre session a expiré S'il vous plaît veuillez vous connecter à nouveau.");
	echo "<script>document.location.href='index.php'</script>";
	exit;
	}
	}
	
	return TRUE;
	}
	
	
	
	function logout() {
	unset($_SESSION['User']);
	redirect('index.php');
	}
	
	
	/**
	* Standard Connects to database
	*/
	function db_connect() {
	
	$db = new DB(array(
	'hostname'=>HOSTNAME,
	'username'=>DB_USERNAME,
	'password'=>DB_PASSWORD,
	'db_name'=>DB_NAME
	));
	
	
	if($db===FALSE) {
	print_debug($db->errors);
	exit;
	}
	
	return $db;
	}
	/***/
	function getCodePromo($taille = 6){
	
	for($i=0;$i<100;$i++){
	
	$code = date('Y').genere_pass($taille,true);
	
	
	
	$db = db_connect();
	
	$sql = $db->get_row("SELECT * FROM code_promo WHERE code_promo.code='$code'");
	if(empty($sql)){
	return $code;
	}
	
	
	}
	
	return false;
	
	}
	function getPosBefore($position,$parent){
	
	$pos = array();
	
	$db = db_connect();
	
	$sql = $db->get_rows("SELECT position FROM category WHERE position < '$position' AND id_parent='$parent'");
	
	
	foreach($sql as $k => $v){
	$pos[] = $v['position'];
	}
	
	
	return max($pos);  
	
	}
	function getPosAfter($position,$parent){
	$pos = array();
	
	$db = db_connect();
	
	$sql = $db->get_rows("SELECT position FROM category WHERE position > '$position' AND id_parent='$parent'");
	
	
	foreach($sql as $k => $v){
	$pos[] = $v['position'];
	}			
	return min($pos);  
	}
	
	function getIdPosition($position){
	
	$db = db_connect();
	
	$row = $db->get_row("SELECT id_category FROM category WHERE position ='$position'");
	
	
	return $row['id_category'];  
	}
	/****/
	
	function getPosBeforeP($position){
	
	$pos = array();
	
	$db = db_connect();
	
	$sql = $db->get_rows("SELECT position FROM product WHERE product.position < '$position' AND product.id_center='".$_SESSION['id_center']."'");
	
	
	foreach($sql as $k => $v){
	$pos[] = $v['position'];
	}
	
	
	return max($pos);  
	
	}
	function getPosAfterP($position){
	$pos = array();
	
	$db = db_connect();
	
	$sql = $db->get_rows("SELECT position FROM product WHERE product.position > '$position' AND product.id_center='".$_SESSION['id_center']."'");
	
	
	foreach($sql as $k => $v){
	$pos[] = $v['position'];
	}
	
	
	
	return min($pos);  
	
	}
	
	function getIdPositionP($position){
	
	$db = db_connect();
	
	$row = $db->get_row("SELECT id_product FROM product WHERE position ='$position' AND product.id_center='".$_SESSION['id_center']."'");
	
	
	return $row['id_product'];  
	}
	/*order gift**/
	function getPosBeforeG($position){
	
	$pos = array();
	
	$db = db_connect();
	
	$sql = $db->get_rows("SELECT position FROM gift_price WHERE gift_price.position < '$position' ");
	
	
	foreach($sql as $k => $v){
	$pos[] = $v['position'];
	}
	
	
	return max($pos);  
	
	}
	function getPosAfterG($position){
	$pos = array();
	
	$db = db_connect();
	
	$sql = $db->get_rows("SELECT position FROM gift_price WHERE gift_price.position > '$position' ");
	
	
	foreach($sql as $k => $v){
	$pos[] = $v['position'];
	}
	
	
	
	return min($pos);  
	
	}
	
	function getIdPositionG($position){
	
	$db = db_connect();
	
	$row = $db->get_row("SELECT id_gift_price FROM gift_price WHERE position ='$position' ");
	
	
	return $row['id_gift_price'];  
	}
	
	
	/***/
	
	function check_user($username, $password) {
	
	$db = db_connect();
	
	$user = $db->get_row("SELECT users.* FROM users WHERE users.username='".$db->escape($username)."'");
	
	
	if(empty($user)) {
	return FALSE;
	}
	
	
	if(md5($password.SALT) != $user['password']) {
	return FALSE;
	}
	
	
	
	$_SESSION['User'] = $user;
	
	$_SESSION['Time'] = time();
	
	
	$user_info['modified'] = date('Y-m-d H:i:s');
	
	$db->update('users',$user_info,$_SESSION['User']['id']);
	
	return TRUE;
	}
	
	
	function print_debug($arr) {
	echo '<pre>';
	if(is_string($arr)) {
	echo $arr;
	} else {
	print_r($arr);
	}
	echo '</pre>';
	}
	
	function notification() {
	$str = '';
	if(isset($_SESSION['notification'])) {
	if(!isset($_SESSION['notification']['type']) || !isset($_SESSION['notification']['msg'])) {
	return '';
	}
	$class = '';
	switch($_SESSION['notification']['type'])
	{
	case 'succes':
	$class = ' class="alert alert-success alert-dismissible fade in"';
	break;
	case 'error':
	$class = ' class="alert alert-error alert-dismissible fade in"';
	break;
	case 'info':
	$class = ' class="alert alert-info alert-dismissible fade in"';
	break;
	case 'warning':
	$class = ' class="alert alert-warning alert-dismissible fade in"';
	break;
	}
	
	
	
	$str = "<div{$class}><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>".$_SESSION['notification']['msg']."</div>";
	unset($_SESSION['notification']);
	
	
	}
	return $str;
	}
	
	
	function redirect($url) {
	echo "<script>document.location.href='".$url."'</script>";
	exit;
	}
	
	
	function get_files($dir) {
	if(!is_dir($dir)) {
	return FALSE;
	}
	
	$files = @scandir($dir);
	foreach($files as $k=>$v) {
	if(strpos($v,'.')==0) {
	unset($files[$k]);
	}
	}
	
	return $files;
	}
	
	
	function create_dir($dir) {
	$res = TRUE;
	if(!is_dir($dir)) {
	$res = mkdir($dir);
	@chmod($dir,0777);
	}
	return $res;
	}
	function delete_dir($dir){
	
	
	$it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
	$files = new RecursiveIteratorIterator($it,
	RecursiveIteratorIterator::CHILD_FIRST);
	foreach($files as $file) {
	if ($file->isDir()){
	rmdir($file->getRealPath());
	} else {
	unlink($file->getRealPath());
	}
	}
	rmdir($dir);
	}
	
	/*function getClassAdmin($class){
	
	$type = '';
	switch($class)
	{
	case '1':
	$type = 'Superadmin';
	break;
	case '2':
	$type = 'Commercial';
	break;
	case '3':
	$type = 'Gestionnaire';
	break;
	}
	return $type;
	}
	*/
	if (!function_exists('json_encode'))
	{
	function json_encode($a=false)
	{
	if (is_null($a)) return 'null';
	if ($a === false) return 'false';
	if ($a === true) return 'true';
	if (is_scalar($a))
	{
	if (is_float($a))
	{
	
	return floatval(str_replace(",", ".", strval($a)));
	}
	
	if (is_string($a))
	{
	static $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
	return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $a) . '"';
	}
	else
	return $a;
	}
	$isList = true;
	for ($i = 0, reset($a); $i < count($a); $i++, next($a))
	{
	if (key($a) !== $i)
	{
	$isList = false;
	break;
	}
	}
	$result = array();
	if ($isList)
	{
	foreach ($a as $v) $result[] = json_encode($v);
	return '[' . join(',', $result) . ']';
	}
	else
	{
	foreach ($a as $k => $v) $result[] = json_encode($k).':'.json_encode($v);
	return '{' . join(',', $result) . '}';
	}
	}
	}
	function Getsector($id,$id_lang){
	
	
	
	
	
	$db = db_connect();
	
	$sector = $db->get_row("SELECT * FROM sector_lang WHERE sector_lang.id_lang='$id_lang' AND sector_lang.id_sector='".$db->escape($id)."'");
	
	if(empty($sector)){
	return false;
	}else {
	return $sector['title'];
	}
	}
	
	function getCountry($id,$id_lang,$return=false){
	
	global $lang;
	
	$db = db_connect();
	
	$country = $db->get_row("SELECT name FROM country_lang WHERE id_country='".$db->escape($id)."' AND id_lang='".$db->escape($id_lang)."'");
	
	if(empty($country)){
	if($return){
	return $lang['NOT_PROVIDED'];
	}else {
	return false;
	}
	}else {
	
	return $country['name'];
	}
	}
	function GetCompany($id){
	
	$db = db_connect();
	
	$company = $db->get_row("SELECT * FROM company WHERE id_company='".$db->escape($id)."'");
	
	if(empty($company)){
	return false;
	}else {
	
	return $company['name'];
	}
	
	}
	function getTitleTissu($id){
	$db = db_connect();
	$table = $db->get_row("SELECT * FROM tissu WHERE id='".$db->escape($id)."'");
	return(empty($table))?false:$table['titre'];
	
	}
	function getTitleColor($id){
	$db = db_connect();
	$table = $db->get_row("SELECT * FROM color WHERE id='".$db->escape($id)."'");
	return(empty($table))?false:$table['titre'];
	
	}
	function getTitleTaille($id){
	$db = db_connect();
	$table = $db->get_row("SELECT * FROM taille WHERE id='".$db->escape($id)."'");
	return(empty($table))?false:$table['titre'];
	
	}
	function age($date)
	{
	if($date=='0000-00-00'){
	return 'pas attribué';
	}else{
	$age =  (int) ((time() - strtotime($date)) / 3600 / 24 / 365);
	if($age > 0){
	
	return $age." ans";
	
	}else return '';
	}
	}
	
	function getTypeFAQ($id,$type_faq){
	$name = false;
	
	foreach($type_faq as $k=>$v): 
	
	if($v['id']==$id){
	
	$name = $v['name'];
	}
	
	endforeach;
	
	return $name;
	
	}
	
	
	
	function wd_remove_accents($str, $charset='utf-8')
	{
	$str = htmlentities($str, ENT_NOQUOTES, $charset);
	
	$str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
	$str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
	$str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères
	
	return $str;
	}
	
	function getSizeCompany($item){
	
	$return ="";
	switch ($item) {
	
	case "1":
	$return= "Moins de 20 employés";
	break;
	case "2":
	$return= "Entre 20 et 100 employés";
	break;
	case "3":
	$return= "Entre 100 et 200 employés";
	break;
	case "4":
	$return= "Entre 200 et 500 employés";
	break;
	case "5":
	$return= "Plus de 500 employés";
	break;
	
	
	}
	return $return;
	}
	
	function verifHoraire($id_avocat,$start,$end){
	
	$day = getIdDay(date('D',strtotime($end)));
	$start = date('H:i:s',strtotime($start));
	$end = date('H:i:s',strtotime($end));
	
	$db = db_connect();
	
	$horaire = $db->get_rows("SELECT * FROM avocat_horaire WHERE id_avocat='$id_avocat' AND id_day='$day' AND (fin <= '$start'  AND debut_midi >= '$end')");
	
	
	
	
	if(!empty($horaire)){
	return false;
	}else {
	return true;
	}
	
	
	
	}
	
	function verifDate($start,$end,$id_avocat,$active=false){
	$filter = '';
	$db = db_connect();
	
	if($active){
	
	$filter .= " AND statut = '$active'";
	
	}
	
	$availabilitys = $db->get_rows("SELECT * FROM calendar where id_avocat='$id_avocat' AND (start >= '$start'  AND end <= '$end') $filter");
	
	
	if(!empty($availabilitys)){
	return false;
	}else {
	return true;
	}
	
	}
	function verifTimePersonal($start,$end,$id_personal){
	$db = db_connect();
	$id_day = getIdDay($start);
	
	$start = date('H:i',strtotime($start));
	
	$end = date('H:i',strtotime($end));
	
	$availabilitys =  $db->get_rows("SELECT * FROM personal_horaire where id_day='$id_day' AND id_personal='$id_personal' AND debut <= '$start' AND fin >= '$end'");
	
	if(empty($availabilitys)){
	return false;
	}else {
	return true;
	}
	
	}
	function verifDayPersonal($date,$id_personal){
	$db = db_connect();
	$id_day = getIdDay($date);
	
	$availabilitys =  $db->get_rows("SELECT * FROM personal_horaire where id_day='$id_day' AND id_personal='$id_personal'");
	if(empty($availabilitys)){
	return false;
	}else {
	return true;
	}
	
	}
	
	function verifDateDispo($start,$end,$id_commercial,$active=false,$id=false){
	$filter = '';
	$db = db_connect();
	if($active){
	
	$filter .= " AND statut = '$active'";
	
	}
	if($id){
	
	$filter .= " AND id != '$id'";
	
	}
	$availabilitys =  $db->get_rows("SELECT * FROM calendar where id_commercial='$id_commercial' AND (start between '$start' AND '$end' OR end between '$start' AND '$end') $filter");
	
	if(!empty($availabilitys)){
	return false;
	}else {
	return true;
	}
	
	}
	
	function verifDateRepos($start,$end,$id_personal,$id=false){
	$filter = '';
	$db = db_connect();
	
	if($id){
	
	$filter .= " AND id != '$id'";
	$filter .= " AND id_referal != '$id'";
	
	}
	$availabilitys =  $db->get_rows("SELECT * FROM calendar where id_personal='$id_personal' AND (start between '$start' AND '$end' OR end between '$start' AND '$end') $filter AND calendar.statut='2'");
	
	if(!empty($availabilitys)){
	return false;
	}else {
	return true;
	}
	
	}
	
	function listePersonaAvailable($start,$end,$id_personal,$id_center=false){
	$id_personals = array();
	$filter = '';
	$db = db_connect();
	if($id_center){
	$filter .= " AND personal.id_center='$id_center' ";
	}
	$availabilitys =  $db->get_rows("SELECT * FROM personal where id_personal!='$id_personal' AND personal.active='1' $filter AND personal.deleted='0'");
	
	
	$return = "<ul>";
	foreach($availabilitys as $k => $v){
	if(verifDateDispo($start,$end,$v['id_personal'])){
	$id_personals[] = $v['id_personal'];
	
	$return.= "<li>".$v['firstname']."</li>";
	}
	}
	$return .= "</ul>";
	if(count($id_personals)>0):	
	return 	$return;
	else:
	return 'aucun(e)';
	endif;
	
	}
	
	
	
	function getIdDay($date){
	$week = array("Sun" => "7","Mon" => "1","Tue" => "2","Wed" => "3","Thu" => "4","Fri" => "5","Sat" => "6");
	$today = date('D',strtotime($date));
	return $week[$today];
	}
	function getDayFr($d){
	
	$dayNames = array("Sun" => "Dimanche","Mon" => "Lundi","Tue" => "Mardi","Wed" => "Mercredi","Thu" => "Jeudi","Fri" => "Vendredi","Sat" => "Samedi");
	return $dayNames[$d];
	}
	function getHoraire($id,$day=1)
	{
	$db = db_connect();
	
	$horaire=$db->get_row("SELECT * FROM personal_horaire WHERE id_personal='$id' and id_day='$day' ");
	
	if(empty($horaire)){
	return false;
	}else {
	return $horaire;
	}
	}
	function getHoraire_center($id,$day=1)
	{
	$db = db_connect();
	
	$horaire=$db->get_row("SELECT * FROM center_horaire WHERE id_center='$id' and id_day='$day' ");
	
	if(empty($horaire)){
	return false;
	}else {
	return $horaire;
	}
	}
	
	function delete($start,$end,$id_avocat,$active=false){
	$db = db_connect();
	$filter ="";
	if($active){
	
	$filter .= " AND statut = '0'";
	
	}
	
	$events =$db->get_rows("SELECT * FROM calendar where id_avocat='$id_avocat' AND (start between '$start' AND '$end' OR end between '$start' AND '$end') $filter");
	
	foreach($events as $k => $v){
	
	$db->delete('calendar',$v['id']);
	
	}
	
	
	}
	
	function getDocType($id){
	
	$type = '';
	
	switch($id)
	{
	case '1':
	$type = 'COURRIER';
	break;
	case '2':
	$type = 'PIÈCES';
	break;
	case '3':
	$type = 'PROCÉDURE';
	break;
	}
	
	return $type;
	
	}
	
	function generateNumFolder($id_company,$date){
	$y = date('y',strtotime($date));
	
	$db = db_connect();
	
	
	$rst = $db->get_row("SELECT * FROM `folder` WHERE SUBSTRING(num, 1, 2)='15'");
	
	//return $rst['num'];
	
	$row = $db->get_row("SELECT (max(num)+1) as num FROM `folder` WHERE id_company='$id_company' AND SUBSTRING(num, 1, 2)='$y'");
	
	$ref = $y.'0000';
	
	if(empty($row)){
	
	return $ref +1;
	
	}else {
	
	
	if((strlen($row['num'])<6)||(substr($row['num'], 0, 2)!== $y)){
	
	
	
	$ref =  $ref+1;	
	}else{
	$ref = $row['num'];
	}
	
	return $ref ;
	}
	}
	
	function generateNumSubscription(){
	
	$db = db_connect();
	$row = $db->get_row("SELECT (max(num)+1) AS num_subscription FROM `subscription`");
	$y = date('y');
	$ref = $y.'0000';
	
	if(empty($row)){
	
	return $ref +1;
	
	}else {
	
	
	if((strlen($row['num_subscription'])<6)||(substr($row['num_subscription'], 0, 2)!==date('y'))){
	$ref =  $ref+1;	
	}else{
	$ref = $row['num_subscription'];
	}
	
	return $ref ;
	}
	}
	function countFolder($id_company){
	
	$db = db_connect();
	
	$folders = $db->get_rows("SELECT folder.* FROM folder WHERE  ((folder.id_avocat='".$_SESSION['User']['id_avocat']."' AND folder.id_company='".$_SESSION['User']['id_company']."' )|| ((folder.id_company='".$_SESSION['User']['id_company']."' AND folder.shared='1') || (folder.shared='2' AND id_folder IN (SELECT id_folder FROM folder_avocat WHERE folder_avocat.id_avocat='".$_SESSION['User']['id_avocat']."'))))");
	return count($folders);
	}
	function getContact($id,$return=false){
	global $lang;
	
	$db = db_connect();
	
	$contact = $db->get_row("SELECT contact.* FROM contact WHERE contact.id_contact='".$db->escape($id)."'");
	if(!empty($contact)){
	
	return $contact['firstname'].' '.$contact['lastname'];
	
	}else {
	if($return){
	return $lang['NOT_PROVIDED'];
	}else {
	return false;
	}
	}
	}
	
	function getContributor($id,$return=false){
	
	global $lang;
	
	$db = db_connect();
	
	$contributor = $db->get_row("SELECT avocats.* FROM avocats WHERE avocats.id_avocat='".$db->escape($id)."'");
	
	if(!empty($contributor)){
	
	return $contributor['firstname'].' '.$contributor['lastname'];
	
	}else {
	if($return){
	return $lang['NOT_PROVIDED'];
	}else {
	return false;
	}
	}
	}
	
	function getContactType($id,$id_lang,$return=false){
	
	global $lang;
	
	$db = db_connect();
	
	$contact_type = $db->get_row("SELECT * FROM contact_type INNER JOIN contact_type_lang ON contact_type.id_contact_type=contact_type_lang.id_contact_type WHERE contact_type.id_contact_type='$id' AND contact_type_lang.id_lang=".$id_lang);
	if(!empty($contact_type)){
	
	return $contact_type['title'];
	
	}else {
	if($return){
	return $lang['NOT_PROVIDED'];
	}else {
	return false;
	}
	}
	}
	function getSite($id,$return=false){
	
	global $lang;
	
	$db = db_connect();
	
	$site = $db->get_row("SELECT site.* FROM site WHERE site.id_site='".$db->escape($id)."'");
	if(!empty($site)){
	
	return $site['name'];
	
	}else {
	if($return){
	return $lang['NOT_PROVIDED'];
	}else {
	return false;
	}
	}
	}
	
	function getSpeciality($id,$id_lang,$return=false){
	
	global $lang;
	
	$db = db_connect();
	
	$speciality = $db->get_row("SELECT * FROM speciality INNER JOIN speciality_lang ON speciality.id_speciality=speciality_lang.id_speciality WHERE speciality.id_speciality='$id' AND speciality_lang.id_lang=".$id_lang);
	
	if(!empty($speciality)){
	
	return $speciality['title'];
	
	}else {
	if($return){
	return $lang['NOT_PROVIDED'];
	}else {
	return false;
	}
	}
	}
	
	function getTitle($id,$id_lang,$return=false){
	
	global $lang;
	
	$db = db_connect();
	
	$title = $db->get_row("SELECT * FROM title INNER JOIN title_lang ON title.id_title=title_lang.id_title WHERE title.id_title='$id' AND title_lang.id_lang=".$id_lang);
	
	if(!empty($title)){
	
	return $title['title'];
	
	}else {
	if($return){
	return $lang['NOT_PROVIDED'];
	}else {
	return false;
	}
	}
	
	}
	function getTypePrestation($id,$id_lang,$return=false){
	
	global $lang;
	
	$db = db_connect();
	
	$type_prestation = $db->get_row("SELECT * FROM type_prestation INNER JOIN type_prestation_lang ON type_prestation.id_type_prestation=type_prestation_lang.id_type_prestation WHERE type_prestation.id_type_prestation='$id' AND type_prestation_lang.id_lang=".$id_lang);
	
	if(!empty($type_prestation)){
	
	return $type_prestation['title'];
	
	}else {
	if($return){
	return $lang['NOT_PROVIDED'];
	}else {
	return false;
	}
	}
	
	}
	
	
	function getCurrency($id,$return=false){
	
	global $lang;
	
	$db = db_connect();
	
	$currency = $db->get_row("SELECT * FROM currency WHERE currency.id_currency='$id'");
	
	if(!empty($currency)){
	
	return $currency['sign'];
	
	}else {
	if($return){
	return $lang['NOT_PROVIDED'];
	}else {
	return false;
	}
	}
	
	}
	function getLang($id,$return=false){
	
	global $lang;
	
	$db = db_connect();
	
	$language = $db->get_row("SELECT * FROM lang WHERE lang.id_lang='$id'");
	
	if(!empty($language)){
	
	return $language['iso_code'];
	
	}else {
	if($return){
	return $lang['NOT_PROVIDED'];
	}else {
	return false;
	}
	}
	
	}
	
	function getCategorie($id_category,$id_lang,$return=false){
	
	global $lang;
	
	$db = db_connect();
	
	$categorie = $db->get_row("SELECT * FROM category INNER JOIN category_lang ON category.id_category=category_lang.id_category WHERE category.id_category='$id_category' AND category_lang.id_lang='".$id_lang."'");
	
	if(!empty($categorie)){
	
	return $categorie['title'];
	
	}else {
	
	if($return){
	return $lang['NOT_PROVIDED'];
	}else {
	return false;
	}
	}
	}
	
	function getQuality($id,$id_lang,$return=false){
	global $lang;
	
	$db = db_connect();
	
	$quality = $db->get_row("SELECT * FROM quality INNER JOIN quality_lang ON quality.id_quality=quality_lang.id_quality WHERE quality.id_quality='$id' AND quality_lang.id_lang=".$id_lang);
	
	if(!empty($quality)){
	
	return $quality['name'];
	
	}else {
	
	if($return){
	return $lang['NOT_PROVIDED'];
	}else {
	return false;
	}
	}
	
	}
	
	function getCenter($id){
	$db = db_connect();
	
	$User = $db->get_row("SELECT * FROM center WHERE center.id_center='$id'");
	if(!empty($User)){
	
	return $User['title'];
	
	}else {
	return false;
	}
	
	}
	
	function datetoDB($date,$lg,$sep=false,$full=false){
	
	if($date==''){ return false;}
	
	if((strpos($date,'/') !== false)){
	if($lg=='en'){
	list($month, $day, $year) = explode('/', $date);
	}else{
	list($day, $month, $year) = explode('/', $date);
	}
	return sprintf('%s-%s-%s', $year, $month, $day);
	}else{
	
	if($full){
	return date('Y-m-d H:i:s',strtotime($date));
	}else{
	return date('Y-m-d',strtotime($date));
	}
	}
	
	
	
	}
	function customdate($date,$id_lang,$full=false,$return=false){
	global $lang;
	
	//$date = preg_replace('/[^a-zA-Z0-9-]/', '-', $date);
	
	$db = db_connect();
	
	$language = $db->get_row("SELECT lang.* FROM lang WHERE lang.id_lang='$id_lang'");
	
	if($full){
	$format = $language['date_format_full'];
	}else{
	$format = $language['date_format_lite'];
	}
	
	if(strtotime($date) && $date !== "0000-00-00"){
	return date($format,strtotime($date));
	
	}else{
	
	if($return){
	return $lang['NOT_PROVIDED'];
	}else {
	return false;
	}
	}
	
	}
	
	function normalize_strtotime($date){
	$return = preg_replace('/[^a-zA-Z0-9-]/', '-', $date);
	
	return strtotime($date);
	}
	
	function getObject($object){
	
	$return = false;
	switch ($object) {
	case 'client':
	$return =  "Client";
	break;
	case 'contact':
	$return =  "Contact";
	break;
	case 'folder':
	$return =  "Dossier";
	break;
	case 'prestation':
	$return =  "Prestation";
	break;
	case 'contributor':
	$return =  "Collaborateur";
	break;
	case 'calendar':
	$return =  "Evénement";
	break;
	case 'document':
	$return =  "Document";
	break;
	case 'invoice':
	$return =  "Facture";
	break;
	case 'provision':
	$return =  "Provision";
	break;
	case 'email':
	$return =  "Email";
	break;
	
	}
	
	return $return;	
	}
	/*droit accé au dossier*/
	function acces($num){
	$nums = array();
	$db = db_connect();
	$folders = $db->get_rows("SELECT folder.* FROM folder WHERE  ((folder.id_avocat='".$_SESSION['User']['id_avocat']."' AND folder.id_company='".$_SESSION['User']['id_company']."' )|| ((folder.id_company='".$_SESSION['User']['id_company']."' AND folder.shared='1') || (folder.shared='2' AND id_folder IN (SELECT id_folder FROM folder_avocat WHERE folder_avocat.id_avocat='".$_SESSION['User']['id_avocat']."'))))");
	
	foreach($folders as $k=>$v):
	$nums[] = $v['num'];
	endforeach;
	
	if(in_array($num,$nums)): 
	return true; 
	else:
	$_SESSION['notification'] = array('type'=>'error','msg'=>'Authentification requise');
	echo "<script>document.location.href='manage-folder.php'</script>";
	exit;
	endif;
	
	}
	
	function getIdFile($path){
	$db = db_connect();
	$file_db = $db->get_row("SELECT document.* FROM document WHERE document.path ='".$path."'");
	//$file_db['id_document'] = '11';
	if(!empty($file_db)){
	return $file_db['id_document'];	
	}else{
	return false;
	}
	
	}
	function hasAccess($id){
	$db = db_connect();
	$doc = $db->get_rows("SELECT document.* FROM document WHERE  ((document.id_avocat='".$_SESSION['User']['id_avocat']."' AND document.id_company='".$_SESSION['User']['id_company']."' )|| ((document.id_company='".$_SESSION['User']['id_company']."' AND document.shared='1') || (document.shared='2' AND id_document IN (SELECT id_document FROM shared_document WHERE shared_document.id_avocat='".$_SESSION['User']['id_avocat']."'))) AND document.id_document='$id')");
	
	if(!empty($doc)){
	return true;	
	}else{
	return false;
	}
	}
	/*edition repertoire*/
	
	function isAllowed($name){
	$db = db_connect();
	
	//$name = substr($name,7,6);
	
	$name = substr($name, strrpos($name, 'folder_')+7);
	
	$folder = $db->get_row("SELECT folder.* FROM folder WHERE folder.num='$name'");
	
	if(empty($folder)){
	return true;
	}else{
	return false;
	}
	
	
	}
	/**/
	function isOwner($id_avocat,$id,$object,$index){
	$db = db_connect();
	
	/*switch ($object) {
	case 'document':
	$query =  "Client";
	break;
	}*/
	
	$rslt = $db->get_row("SELECT ".$object.".* FROM ".$object." WHERE ".$object.".id_avocat='$id_avocat' AND ".$object.".".$index."='".$id."'");
	
	if(!empty($rslt)){
	return true;
	}else{
	return false;
	}
	
	
	}
	
	function getAllCenter($all=false,$start_from=0,$limit=100){
	
	$folders = array();
	$db = db_connect();
	$filter = '';
	//$filter = " AND folder.statut='0'";
	
	
	
	
	$folders = $db->get_rows("SELECT center.* FROM center WHERE center.active='1' AND center.deleted='0' ORDER BY center.created  ASC");
	
	
	
	return $folders;
	
	}
	/*link lang lg*/
	function vLink($l){
	
	if(strpos($l,'?') !== false){
	
	$s = '&';
	
	//return $_SERVER["REQUEST_URI"]."&";
	
	}else{
	
	$s = '?';
	
	//return $_SERVER["REQUEST_URI"]."?";
	}
	
	$explode = explode('&center='.$_SESSION['id_center'],$l);
	$explode2 = explode('?center='.$_SESSION['id_center'],$l);
	if(!empty($explode)){
	return $explode['0'].$s;
	}else if(!empty($explode2)){
	return $explode['0'].$s;
	
	}else{
	return $_SERVER["REQUEST_URI"].$s;
	}
	}
	
	function getHourlyRate($time,$tarif){
	
	$explode = explode(':',$time);
	
	$amount = $explode['0']*$tarif;
	$amount += $explode['1']*($tarif / 60);
	$amount += $explode['2']*($tarif / (60*60));
	
	return sprintf('%0.2f',$amount);
	
	}
	/*proforma*/
	function generateNumProforma($id_company){
	
	
	$db = db_connect();
	
	$row = $db->get_row("SELECT (max(num_proforma)+1) as num FROM `invoice` WHERE id_company='$id_company'");
	if($row['num']>0){
	return $row['num'];
	}else{
	return 1; 
	}
	
	}
	/*invoice*/
	function generateNumInvoice($id_company,$date){
	$y = date('y',strtotime($date));
	
	$db = db_connect();
	
	
	$rst = $db->get_row("SELECT * FROM `folder` WHERE SUBSTRING(num, 1, 2)='15'");
	
	//return $rst['num'];
	
	$row = $db->get_row("SELECT (max(num)+1) as num FROM `invoice` WHERE id_company='$id_company' AND SUBSTRING(num, 1, 2)='$y'");
	
	$ref = $y.'00000';
	
	if(empty($row)){
	
	return $ref +1;
	
	}else {
	
	
	if((strlen($row['num'])<7)||(substr($row['num'], 0, 2)!== $y)){
	
	
	
	$ref =  $ref+1;	
	}else{
	$ref = $row['num'];
	}
	
	return $ref ;
	}
	}
	
	function getInvoiceType($type){
	
	$return ="";
	if($_SESSION['language']=='en'){
	switch ($type) {
	
	case "0":
	$return= "STATEMENT OF FEES";
	break;
	case "1":
	$return= " Retainer bill";
	break;
	case "2":
	$return= "Free invoice";
	break;
	
	}
	}elseif($_SESSION['language']=='nl'){
	switch ($type) {
	
	case "0":
	$return= "STATEMENT OF FEES";
	break;
	case "1":
	$return= " Retainer bill";
	break;
	case "2":
	$return= "Free invoice";
	break;
	
	}
	}else{
	switch ($type) {
	
	case "0":
	$return= "Factures d'honoraires";
	break;
	case "1":
	$return= "Facture de provisions";
	break;
	case "2":
	$return= "Facture Libre";
	break;
	
	}
	}
	
	return $return;
	}
	function getStatutEmail($type){
	
	$return ="";
	switch ($type) {
	
	case "0":
	$return= "Brouillon";
	break;
	case "1":
	$return= "Envoyé";
	break;
	case "2":
	$return= "Reçus";
	break;
	
	}
	return $return;
	}
	
	function truncate($text, $length = 100, $ending = '...', $exact = true, $considerHtml = false) {
	if (is_array($ending)) {
	extract($ending);
	}
	if ($considerHtml) {
	if (mb_strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
	return $text;
	}
	$totalLength = mb_strlen($ending);
	$openTags = array();
	$truncate = '';
	preg_match_all('/(<\/?([\w+]+)[^>]*>)?([^<>]*)/', $text, $tags, PREG_SET_ORDER);
	foreach ($tags as $tag) {
	if (!preg_match('/img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param/s', $tag[2])) {
	if (preg_match('/<[\w]+[^>]*>/s', $tag[0])) {
	array_unshift($openTags, $tag[2]);
	} else if (preg_match('/<\/([\w]+)[^>]*>/s', $tag[0], $closeTag)) {
	$pos = array_search($closeTag[1], $openTags);
	if ($pos !== false) {
	array_splice($openTags, $pos, 1);
	}
	}
	}
	$truncate .= $tag[1];
	
	$contentLength = mb_strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $tag[3]));
	if ($contentLength + $totalLength > $length) {
	$left = $length - $totalLength;
	$entitiesLength = 0;
	if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $tag[3], $entities, PREG_OFFSET_CAPTURE)) {
	foreach ($entities[0] as $entity) {
	if ($entity[1] + 1 - $entitiesLength <= $left) {
	$left--;
	$entitiesLength += mb_strlen($entity[0]);
	} else {
	break;
	}
	}
	}
	
	$truncate .= mb_substr($tag[3], 0 , $left + $entitiesLength);
	break;
	} else {
	$truncate .= $tag[3];
	$totalLength += $contentLength;
	}
	if ($totalLength >= $length) {
	break;
	}
	}
	
	} else {
	if (mb_strlen($text) <= $length) {
	return $text;
	} else {
	$truncate = mb_substr($text, 0, $length - strlen($ending));
	}
	}
	if (!$exact) {
	$spacepos = mb_strrpos($truncate, ' ');
	if (isset($spacepos)) {
	if ($considerHtml) {
	$bits = mb_substr($truncate, $spacepos);
	preg_match_all('/<\/([a-z]+)>/', $bits, $droppedTags, PREG_SET_ORDER);
	if (!empty($droppedTags)) {
	foreach ($droppedTags as $closingTag) {
	if (!in_array($closingTag[1], $openTags)) {
	array_unshift($openTags, $closingTag[1]);
	}
	}
	}
	}
	$truncate = mb_substr($truncate, 0, $spacepos);
	}
	}
	
	$truncate .= $ending;
	
	if ($considerHtml) {
	foreach ($openTags as $tag) {
	$truncate .= '</'.$tag.'>';
	}
	}
	
	return $truncate;
	}
	
	function nextIdProduct(){
	
	$db = db_connect();
	$new_id = $db->get_row("SELECT (max(id_product)+1) as id_product FROM `product`");
	
	if($new_id['id_product']>0){
	return 	$new_id['id_product'];												 
	}else{
	return 1;
	}
	}
	function nextIdImg(){
	
	$db = db_connect();
	$new_id_doc = $db->get_row("SELECT (max(id_image)+1) as id_image FROM `image`");
	
	if($new_id_doc['id_image']>0){
	return 	$new_id_doc['id_image'];												 
	}else{
	return 1;
	}
	
	}
	function human_filesize($bytes, $decimals = 2) {
	$size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
	$factor = floor((strlen($bytes) - 1) / 3);
	return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
	}
	function formatSize($size)
	{
	$sizes = Array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB');
	$syz = $sizes[0];
	for ($i = 1; (($i < count($sizes)) && ($size >= 1024)); $i++) {
	$size = $size / 1024;
	$syz  = $sizes[$i];
	}
	return round($size, 2)." ".$syz;
	}
	function getFileSize($file)
	{
	$sizeInBytes = filesize($file);
	/**
	* If filesize() fails (with larger files),
	* try to get the size with fseek
	*/
	if (!$sizeInBytes || $sizeInBytes < 0) {
	$fho = fopen($file, "r");
	$size = "0";
	$char = "";
	fseek($fho, 0, SEEK_SET);
	$count = 0;
	while (true) {
	//jump 1 MB forward in file
	fseek($fho, 1048576, SEEK_CUR);
	//check if we actually left the file
	if (($char = fgetc($fho)) !== false) {
	$count ++;
	} else {
	//else jump back where we were before leaving and exit loop
	fseek($fho, -1048576, SEEK_CUR);
	break;
	}
	}
	$size = bcmul("1048577", $count);
	$fine = 0;
	while (false !== ($char = fgetc($fho))) {
	$fine ++;
	}
	//and add them
	$sizeInBytes = bcadd($size, $fine);
	fclose($fho);
	}
	return $sizeInBytes;
	}
	
	function isEmail($email) {
	return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$email));
	}
	
	function genereLink($path){
	$time = time();
	$hash = md5('bc8b3b8f729c633fe4131a09e60503ec'.$time);
	
	$d = base64_encode($path);
	
	$link = "file.php?d=".$d."&t=".$time."&h=".$hash."&id_lawyer=".$_SESSION['User']['id_avocat']."&id_company=".$_SESSION['User']['id_company'];
	return $link;
	}
	
	function sendPushIos($deviceToken,$subject,$email,$type,$id_avocat,$id_shared){
	
	$passphrase = 'SAMAGROUP';
	
	$ctx = stream_context_create();
	stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
	stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
	
	$fp = stream_socket_client(
	'ssl://gateway.push.apple.com:2195', $err,
	$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
	
	/*if (!$fp)
	exit("Failed to connect: $err $errstr" . PHP_EOL);
	
	echo 'Connected to APNS' . PHP_EOL;*/
	
	// Create the payload body
	$body['aps'] = array(
	'badge' => +1,
	'alert' => $subject,
	'id_avocat' => $id_avocat,
	'id_shared' => $id_shared,
	'sound' => 'default',
	'email'=> $email,
	'type'=> $type
	);
	$payload = json_encode($body);
	
	// Build the binary notification
	$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
	
	// Send it to the server
	$result = fwrite($fp, $msg, strlen($msg));
	
	if (!$result)
	echo 'Message not delivered' . PHP_EOL;
	else
	echo 'Message successfully delivered' . PHP_EOL;
	
	// Close the connection to the server
	fclose($fp);
	
	}
	
	
	function sendPush($token,$subject,$email,$type){
	
	$registatoin_ids = array($token);
	$date = date('Y-m-d');
	$heure = date('h:i:s');
	
	$message = array("type" => $type, "subject" => $subject, "id_avocat" => $_SESSION['User']['id_avocat'], "message" => $email);
	
	// Set POST variables
	$url = 'https://android.googleapis.com/gcm/send';
	
	$fields = array(
	'registration_ids' => $registatoin_ids,
	'data' => $message,
	);
	
	$headers = array(
	'Authorization: key=' . GOOGLE_API_KEY,
	'Content-Type: application/json'
	);
	//print_r($headers);
	// Open connection
	$ch = curl_init();
	
	// Set the url, number of POST vars, POST data
	curl_setopt($ch, CURLOPT_URL, $url);
	
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
	// Disabling SSL Certificate support temporarly
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
	
	// Execute post
	$result = curl_exec($ch);
	
	if ($result === FALSE) {
	
	return false;
	}else{
	return true;
	}
	
	}
	
	function putVarTab($table){
	
	$var_1 = '<input type="text" value="Total Heures">';
	
	
	$replacement_find = "#{$replace_id}#";
	$replacement_replace = "<a href=\"mylink.php?{$replace_id}\">{$replace_id}</a>";
	
	//$text_final = str_replace($replacement_find, $replacement_replace, $text);
	
	return $table;
	}
	
	function xcopy($src, $dest) { 
	
	foreach (scandir($src) as $file) { 
	$srcfile = rtrim($src, '/') .'/'. $file; $destfile = rtrim($dest, '/') .'/'. $file; 
	if (!is_readable($srcfile)) { continue; } 
	if ($file != '.' && $file != '..') { 
	if (is_dir($srcfile)) { 
	if (!file_exists($destfile)) { 
	mkdir($destfile); 
	} 
	xcopy($srcfile, $destfile); } else { copy($srcfile, $destfile); } 
	} 
	} 
	
	}
	
	function sendAccount($email,$password){
	
	$db = db_connect();
	
	$logo = ROOT_WEB_URL."img/logo.png";
	$SAMAGROUP = $db->get_row("SELECT SAMAGROUP.* FROM SAMAGROUP WHERE SAMAGROUP.id='1'");
	//$email = "tarek.bentaher@gmail.com";
	
	
	$e_subject = 'Compte';
	
	$headers = 'From: "SAMAGROUP"<'.$SAMAGROUP['email'].'>'. PHP_EOL; 
	$headers .= "Reply-To: <".$SAMAGROUP['email'].">" . PHP_EOL;
	$headers .= "MIME-Version: 1.0" . PHP_EOL;
	$headers .= "Content-type: text/html; charset=utf-8" . PHP_EOL;
	
	
	$body='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
	<meta name="format-detection" content="telephone=no" />
	<title>SAMAGROUP</title>
	<style type="text/css">
	
	a{
	color:#ff7a0d !important;
	}
	td{border-collapse:collapse;}
	
	.date							{color:#eeeeee;	font-family:Arial, Tahoma, Verdana, sans-serif;     			 font-size:13px;  font-weight:lighter;padding:0; margin:0; text-align:right; 	 line-height:150%;	letter-spacing:0; }
	.iphoneAvoidAutoLinkHackDate2	{color:#eeeeee; text-decoration: none; pointer-events: none;}
	
	.menuTD						{color:#6e777e; font-family:Arial, Tahoma, Verdana, sans-serif;     			 font-size:13px;  font-weight:bold;  padding:0; margin:0; text-align:right;  line-height:150%;	letter-spacing:0; }
	.menuTDLink					{color:#6e777e;  text-decoration:none; outline:none;}	
	
	
	.announcementTextTD			{color:#ff7a0d; 	font-family:Arial, Tahoma, Verdana, sans-serif;     			 font-size:17px;  font-weight:bold;   padding:0; margin:0; text-align:left;   line-height:130%;	letter-spacing:0;}
	.announcementTextTDLink		{color:#ff7a0d !important;  text-decoration:none; outline:none;}	
	
	.introTextTD						{color:#6e777e; font-family:Arial, Tahoma, Verdana, sans-serif;     			font-size:13px;  font-weight:lighter; padding:0; margin:0; text-align:left; line-height:165%; letter-spacing:0;}
	.introTextTDLink					{color:#ff7a0d;  text-decoration:none; outline:none;  font-weight:bold;}	
	.introTextHeaderTD				{color:#43494e; font-family:Arial, Tahoma, Verdana, sans-serif;     			font-size:20px;  font-weight:lighter; padding:0; margin:0; text-align:left; line-height:160%; letter-spacing:0;}
	
	.sectionsSeperatorTextTD			{color:#ff7a0d;	 font-family:Arial, Tahoma, Verdana, sans-serif;     		 font-size:13px;  font-weight:bold;   padding:0; margin:0; text-align:left; line-height:160%; letter-spacing:0; }
	.sectionsSeperatorTextTDLink		{color:#ffffff;  text-decoration:none; outline:none;  font-weight:bold;}	
	
	
	.sectionsHeaderTD				{color:#43494e; font-family:Arial, Tahoma, Verdana, sans-serif;      		font-size:20px; font-weight:lighter;   	padding:0; margin:0; text-align:left;  line-height:140%;   letter-spacing:0; }
	.sectionsHeaderTDLink			{color:#ff7a0d;  text-decoration:none; outline:none;}
	.sectionRegularInfoTextTD		{color:#6e777e; font-family:Arial, Tahoma, Verdana, sans-serif;  			font-size:13px;  font-weight:lighter;   padding:0; margin:0; text-align:left;       line-height:165%;  letter-spacing:0;}
	.sectionRegularInfoTextTDLink	{color:#ff7a0d;   text-decoration:none; outline:none;   font-weight:bold;  }	
	.headerAndTextSeperatorLine 	{border-bottom-style:solid; border-bottom-color:#e5e5e5; border-bottom-width:1px; font-size:0; line-height:0;}
	.moduleSeperatorLine			{border-top-style:solid;       border-top-color:#e5e5e5;      border-top-width:1px;}
	
	.buttonsAndImagesLink			{color:#bbbbbb; text-decoration:none; outline:none;}	
	.table280Button,	
	.table280Squareimage, 
	.table280Rectangleimage3, 
	.table280Rectangleimage2, 
	.table280Rectangleimage,
	.pictureAlternativeTextTD			{color:#bbbbbb; font-family:sans-serif;  font-size:10px; 	padding:0; margin:0;}
	
	.finalWords						{color:#eeeeee; font-family:Arial, Tahoma, Verdana, sans-serif;      		font-size:18px; font-weight:lighter;   	padding:0; margin:0; text-align:center;  line-height:150%;   letter-spacing:0;}	
	.iphoneAvoidAutoLinkHackDate	{color:#ff0000; text-decoration: none; pointer-events: none;}
	.adressOrAnyOtherTD			{color:#ffffff; font-family:Arial, Tahoma, Verdana, sans-serif; 				font-size:13px;  font-weight:lighter; 	  padding:0; margin:0; text-align:center; line-height:200%;  letter-spacing:0;}
	.adressOrAnyOtherTDLink			{color:#ffffff;  text-decoration:none; outline:none;}
	
	.mailingOptionsTD				{color:#ffffff; font-family:Arial, Tahoma, Verdana, sans-serif; 				font-size:13px;  font-weight:lighter; 	  padding:0; margin:0; text-align:center; line-height:200%;  letter-spacing:0;}
	.mailingOptionsTDLink			{color:#ffffff;  text-decoration:none;  outline:none;	   font-weight:bold; }
	
	.copyrightCompanyTD			{color:#ffffff; font-family:Arial, Tahoma, Verdana, sans-serif; 			font-size:13px;  font-weight:lighter; 	  padding:0; margin:0; text-align:center; line-height:200%;  letter-spacing:0;}	
	.copyrightCompanyTDLink		{color:#ff7a0d;  text-decoration:none;  outline:none;	   font-weight:bold; }
	
	.ReadMsgBody{width: 100%;}
	.ExternalClass{width: 100%;}
	body{-webkit-text-size-adjust:100%;  -ms-text-size-adjust:100%;  -webkit-font-smoothing:antialiased; margin:0 !important;   padding:0 !important;   width:100% !important; }
	
	<!---->		
	.table {
	width: 100%;
	max-width: 100%;
	margin-bottom: 20px;
	}
	.table > thead > tr > th,
	.table > tbody > tr > th,
	.table > tfoot > tr > th,
	.table > thead > tr > td,
	.table > tbody > tr > td,
	.table > tfoot > tr > td {
	padding: 8px;
	line-height: 1.42857143;
	vertical-align: top;
	border-top: 1px solid #ddd !important;
	}
	.table > thead > tr > th {
	vertical-align: bottom !important;
	border-bottom: 2px solid #ddd !important;
	}
	.table > caption + thead > tr:first-child > th,
	.table > colgroup + thead > tr:first-child > th,
	.table > thead:first-child > tr:first-child > th,
	.table > caption + thead > tr:first-child > td,
	.table > colgroup + thead > tr:first-child > td,
	.table > thead:first-child > tr:first-child > td {
	border-top: 0 !important;
	}
	.table > tbody + tbody {
	border-top: 2px solid #ddd !important;
	}
	.table .table {
	background-color: #fff;
	}
	.table-condensed > thead > tr > th,
	.table-condensed > tbody > tr > th,
	.table-condensed > tfoot > tr > th,
	.table-condensed > thead > tr > td,
	.table-condensed > tbody > tr > td,
	.table-condensed > tfoot > tr > td {
	padding: 5px !important;
	}
	.table-bordered {
	border: 1px solid #ddd !important;
	}
	.table-bordered > thead > tr > th,
	.table-bordered > tbody > tr > th,
	.table-bordered > tfoot > tr > th,
	.table-bordered > thead > tr > td,
	.table-bordered > tbody > tr > td,
	.table-bordered > tfoot > tr > td {
	border: 1px solid #ddd !important;
	}
	.table-bordered > thead > tr > th,
	.table-bordered > thead > tr > td {
	border-bottom-width: 2px !important;
	}
	.table-striped > tbody > tr:nth-child(odd) {
	background-color: #f9f9f9 !important;
	}
	.table-hover > tbody > tr:hover {
	background-color: #f5f5f5 !important;
	}
	table col[class*="col-"] {
	position: static;
	display: table-column;
	float: none;
	}
	table td[class*="col-"],
	table th[class*="col-"] {
	position: static;
	display: table-cell;
	float: none;
	}
	.table > thead > tr > td.active,
	.table > tbody > tr > td.active,
	.table > tfoot > tr > td.active,
	.table > thead > tr > th.active,
	.table > tbody > tr > th.active,
	.table > tfoot > tr > th.active,
	.table > thead > tr.active > td,
	.table > tbody > tr.active > td,
	.table > tfoot > tr.active > td,
	.table > thead > tr.active > th,
	.table > tbody > tr.active > th,
	.table > tfoot > tr.active > th {
	background-color: #f5f5f5;
	}
	.table-hover > tbody > tr > td.active:hover,
	.table-hover > tbody > tr > th.active:hover,
	.table-hover > tbody > tr.active:hover > td,
	.table-hover > tbody > tr:hover > .active,
	.table-hover > tbody > tr.active:hover > th {
	background-color: #e8e8e8;
	}
	.table > thead > tr > td.success,
	.table > tbody > tr > td.success,
	.table > tfoot > tr > td.success,
	.table > thead > tr > th.success,
	.table > tbody > tr > th.success,
	.table > tfoot > tr > th.success,
	.table > thead > tr.success > td,
	.table > tbody > tr.success > td,
	.table > tfoot > tr.success > td,
	.table > thead > tr.success > th,
	.table > tbody > tr.success > th,
	.table > tfoot > tr.success > th {
	background-color: #dff0d8;
	}
	.table-hover > tbody > tr > td.success:hover,
	.table-hover > tbody > tr > th.success:hover,
	.table-hover > tbody > tr.success:hover > td,
	.table-hover > tbody > tr:hover > .success,
	.table-hover > tbody > tr.success:hover > th {
	background-color: #d0e9c6 !important;
	}
	.table > thead > tr > td.info,
	.table > tbody > tr > td.info,
	.table > tfoot > tr > td.info,
	.table > thead > tr > th.info,
	.table > tbody > tr > th.info,
	.table > tfoot > tr > th.info,
	.table > thead > tr.info > td,
	.table > tbody > tr.info > td,
	.table > tfoot > tr.info > td,
	.table > thead > tr.info > th,
	.table > tbody > tr.info > th,
	.table > tfoot > tr.info > th {
	background-color: #d9edf7 !important;
	}
	.table-hover > tbody > tr > td.info:hover,
	.table-hover > tbody > tr > th.info:hover,
	.table-hover > tbody > tr.info:hover > td,
	.table-hover > tbody > tr:hover > .info,
	.table-hover > tbody > tr.info:hover > th {
	background-color: #c4e3f3 !important;
	}
	.table > thead > tr > td.warning,
	.table > tbody > tr > td.warning,
	.table > tfoot > tr > td.warning,
	.table > thead > tr > th.warning,
	
	.table > tbody > tr > th.warning,
	.table > tfoot > tr > th.warning,
	.table > thead > tr.warning > td,
	.table > tbody > tr.warning > td,
	.table > tfoot > tr.warning > td,
	.table > thead > tr.warning > th,
	.table > tbody > tr.warning > th,
	.table > tfoot > tr.warning > th {
	background-color: #fcf8e3 !important;
	}
	.table-hover > tbody > tr > td.warning:hover,
	.table-hover > tbody > tr > th.warning:hover,
	.table-hover > tbody > tr.warning:hover > td,
	.table-hover > tbody > tr:hover > .warning,
	.table-hover > tbody > tr.warning:hover > th {
	background-color: #faf2cc !important;
	}
	.table > thead > tr > td.danger,
	.table > tbody > tr > td.danger,
	.table > tfoot > tr > td.danger,
	.table > thead > tr > th.danger,
	.table > tbody > tr > th.danger,
	.table > tfoot > tr > th.danger,
	.table > thead > tr.danger > td,
	.table > tbody > tr.danger > td,
	.table > tfoot > tr.danger > td,
	.table > thead > tr.danger > th,
	.table > tbody > tr.danger > th,
	.table > tfoot > tr.danger > th {
	background-color: #f2dede !important;
	}
	.table-hover > tbody > tr > td.danger:hover,
	.table-hover > tbody > tr > th.danger:hover,
	.table-hover > tbody > tr.danger:hover > td,
	.table-hover > tbody > tr:hover > .danger,
	.table-hover > tbody > tr.danger:hover > th {
	background-color: #ebcccc!important;
	}
	.table-responsive {
	min-height: .01%;
	overflow-x: auto;
	}
	
	<!---->
	@media only screen and (max-width: 599px) 
	{
	body{min-width:100% !important;}  
	
	table[class=table600LogoAndMenuContainer]	{width:420px !important;}
	table[class=table600Logo]  					{width:420px !important; border-bottom-style:solid !important; border-bottom-color:#e5e5e5 !important; border-bottom-width:1px !important;}
	table[class=table600Logo] img 				{margin:0 auto 0 auto !important;}
	table[class=table600Menu]					{width:420px !important;}
	table[class=table600Menu] td					{height:20px !important;}
	table[class=table600Menu] .menuTD			{text-align:center !important; }
	
	table[class=table600] 						{width:420px !important;}
	table[class=table600AnnouncementText] 		{width:420px !important;}
	table[class=tableTextDateSection]			{width:420px !important;}
	td[class=logoMargin]							{height:8px !important;}
	td[class=logoMargin2]						{height:6px !important;}
	
	table[class=image600] img 					{width:420px !important; height:auto !important;}
	
	table[class=table280]						{width:420px !important;}
	td[class=table280Button] img					{margin:0 auto 0 auto !important;}
	td[class=table280Squareimage] img			{width:280px !important; height:auto !important; margin:30px auto 0 auto !important;}
	td[class=table280Rectangleimage] img		{width:280px !important; height:auto !important; margin:0 auto 0 auto !important;}
	td[class=table280Rectangleimage2] img		{width:280px !important; height:auto !important; margin:35px auto 0 auto !important;}
	td[class=table280Rectangleimage3] img		{width:280px !important; height:auto !important; margin:0 auto 15px auto !important;}
	
	table[class=table280Withicon]				{width:420px !important;}
	table[class=table280Withicon] .sectionsHeaderTD{width:355px !important; text-align:left !important; font-size:20px !important;}
	
	table[class=table280Withicon2]				{width:420px !important; margin:35px auto 0 auto !important;}
	table[class=table280Withicon2] .sectionsHeaderTD{width:355px !important; text-align:left !important; font-size:20px !important;}
	
	td[class=announcementTextTD]				{text-align:center !important; font-weight:bold !important; font-size:17px !important;}
	td[class=introTextTD]						{text-align:center !important; font-size:13px !important;}
	td[class=introTextHeaderTD]					{text-align:center !important; font-size:20px !important;}
	td[class=sectionsSeperatorTextTD]			{text-align:center !important; font-weight:bold !important;}
	td[class=date]								{text-align:center !important;}
	
	td[class=sectionsHeaderTD] 					{font-size:20px !important; text-align:center !important;}
	td[class=sectionRegularInfoTextTD] 			{font-size:13px !important; text-align:left !important;}
	
	td[class=finalWords] 							{font-size:18px !important; text-align:center !important; }
	
	table[class=eraseForMobile] 					{width:0 !important; display:none !important;}
	table[class=eraseForMobile2] 				{height:0 !important; width:0 !important; display:none !important;}
	}
	
	
	
	@media only screen and (max-width: 479px) 
	{
	body{min-width:100% !important;} 
	
	table[class=table600LogoAndMenuContainer]	{width:280px !important;}
	table[class=table600Logo]  					{width:280px !important; border-bottom-style:solid !important; border-bottom-color:#e5e5e5 !important; border-bottom-width:1px !important;}
	table[class=table600Logo] img 				{margin:0 auto 0 auto !important;}
	table[class=table600Menu]					{width:280px !important;}
	table[class=table600Menu] td					{height:20px !important;}
	table[class=table600Menu] .menuTD			{text-align:center !important;}
	
	table[class=table600] 						{width:280px !important;}
	table[class=table600AnnouncementText] 		{width:280px !important;}
	table[class=tableTextDateSection] 			{width:280px !important;}
	td[class=logoMargin]							{height:8px !important;}
	td[class=logoMargin2]						{height:6px !important;}
	
	table[class=image600] img 					{width:280px !important; height:auto !important;}
	
	table[class=table280]						{width:280px !important;}
	td[class=table280Button] img					{margin:0 auto 0 auto !important;}
	td[class=table280Squareimage] img			{width:280px !important; height:auto !important; margin:30px auto 0 auto !important;}
	td[class=table280Rectangleimage] img		{width:280px !important; height:auto !important; margin:0 auto 0 auto !important;}
	td[class=table280Rectangleimage2] img		{width:280px !important; height:auto !important; margin:35px auto 0 auto !important;}
	td[class=table280Rectangleimage3] img		{width:280px !important; height:auto !important; margin:0 auto 15px auto !important;}
	
	table[class=table280Withicon]				{width:280px !important;}
	table[class=table280Withicon] .sectionsHeaderTD{width:215px !important; text-align:left !important; font-size:18px !important;}
	
	table[class=table280Withicon2]				{width:280px !important; margin:35px auto 0 auto !important;}
	table[class=table280Withicon2] .sectionsHeaderTD{width:215px !important; text-align:left !important; font-size:18px !important;}
	
	td[class=announcementTextTD]				{text-align:center !important; font-weight:bold !important; font-size:17px !important;}
	td[class=introTextTD]						{text-align:center !important; font-size:14px !important;}
	td[class=introTextHeaderTD]					{text-align:center !important; font-size:18px !important;}
	td[class=sectionsSeperatorTextTD]			{text-align:center !important; font-weight:bold !important;}
	td[class=date]								{text-align:center !important;}
	
	td[class=sectionsHeaderTD] 					{font-size:18px !important; text-align:center !important; }
	td[class=sectionRegularInfoTextTD] 			{font-size:14px !important;}
	
	td[class=finalWords] 							{font-size:18px !important; text-align:center !important; }
	
	table[class=eraseForMobile] 					{width:0; display:none !important;}
	table[class=eraseForMobile2] 				{height:0 !important; width:0 !important; display:none !important;}
	}
	
	
	</style>
	</head>
	<body style="background-color:#f4f4f4; margin:0; padding:0;">
	<center>
	
	<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff">
	<tr bgcolor="#ffffff">
	<td valign="top" align="center" bgcolor="#ffffff">  
	<table width="600" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" class="table600LogoAndMenuContainer">
	<tr bgcolor="#ffffff">
	<td valign="top" bgcolor="#ffffff"> 
	<table width="200" align="left" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" class="table600Logo">
	<tr bgcolor="#ffffff">
	
	<td valign="middle" align="left" bgcolor="#ffffff" class="pictureAlternativeTextTD"><a href="#" target="_blank" class="buttonsAndImagesLink"><img src="'.$logo.'" style="display:block;" alt="IMAGE HERE" border="0" align="top" hspace="0" vspace="0"/></a></td>
	
	</tr>
	</table></td>
	</tr>
	</table>
	</td>
	</tr>
	</table>  	
	<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#43494e" style="color:#ff7a0d !important;">
	<tr bgcolor="#43494e">
	<td valign="top" align="center" bgcolor="#43494e">
	<table width="600" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#43494e" class="table600">
	<tr bgcolor="#43494e">
	<td valign="top" align="center" height="15" bgcolor="#43494e" style="font-size:0; line-height:0;">&nbsp;</td>
	</tr>                                         	
	<tr bgcolor="#43494e">
	<td valign="top" bgcolor="#43494e">
	<table width="300" align="left" cellpadding="0" cellspacing="0" border="0" bgcolor="#43494e" class="table600AnnouncementText" style="color:#ff7a0d !important;">
	<tr bgcolor="#43494e">
	<td valign="top" align="center" height="0" bgcolor="#43494e" style="font-size:0; line-height:0;" class="logoMargin2">&nbsp;</td>
	</tr>
	<tr bgcolor="#43494e">
	
	<td valign="middle" align="center" height="20" bgcolor="#43494e" style="display:none !important;" class="announcementTextTD">Date:</td>
	
	</tr>
	<tr bgcolor="#43494e">
	<td valign="top" align="center" height="0" bgcolor="#43494e" style="font-size:0; line-height:0;" class="logoMargin">&nbsp;</td>
	</tr>
	</table>
	<table width="282" align="right" cellpadding="0" cellspacing="0" border="0" bgcolor="#43494e" class="tableTextDateSection" style="color:#ff7a0d !important;">
	<tr bgcolor="#43494e">
	
	<td valign="middle" align="center" height="20" bgcolor="#43494e" class="date" style="color:#ff7a0d !important; font-weight:bold;">'.customdate(date('Y-m-d'),$lang_default['id_lang'],false,true).'</td>
	
	</tr>
	<tr bgcolor="#43494e">
	<td valign="top" align="center" height="0" bgcolor="#43494e" style="font-size:0; line-height:0;" class="logoMargin2">&nbsp;</td>
	</tr>
	</table>
	</td>
	</tr>
	<tr bgcolor="#43494e">
	<td valign="top" align="center" height="15" bgcolor="#43494e" style="font-size:0; line-height:0;">&nbsp;</td>
	</tr>
	</table>      
	</td>
	</tr>
	</table>
	
	
	<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#f4f4f4" class="moduleSeperatorLine">
	<tr valign="top">
	<td valign="top" align="center" bgcolor="#f4f4f4">                 
	
	
	
	<table width="280" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#f4f4f4" class="eraseForMobile2">
	<tr>
	<td valign="middle" height="10" align="center" bgcolor="#f4f4f4" style="font-size:0; line-height:0;">&nbsp;</td>
	</tr>
	</table>
	
	
	<table width="600" align="center" cellpadding="0" cellspacing="0" bgcolor="#f4f4f4" border="0" class="table600">
	<tr>
	
	<td style="text-align:left;" valign="middle" align="center" height="10" bgcolor="#f4f4f4" class="sectionsHeaderTD">Bonjour,<br /></td>
	
	</tr>
	
	
	
	
	
	</table>
	
	<table width="600" align="center" cellpadding="0" cellspacing="0" bgcolor="#f4f4f4" border="0" class="table600">
	<tr>			
	
	<td style="text-align:left;" valign="middle" align="center" bgcolor="#f4f4f4" height="10" class="sectionRegularInfoTextTD">Bienvenue....</td>
	
	</tr>
	<tr>			
	
	<td style="text-align:left;" valign="middle" align="center" bgcolor="#f4f4f4" height="10" class="sectionRegularInfoTextTD">Email: '.$email.'</td>
	
	</tr>
	<tr>			
	
	<td style="text-align:left;" valign="middle" align="center" bgcolor="#f4f4f4" height="10" class="sectionRegularInfoTextTD">Mot de passe: '.$password.'</td>
	
	</tr>
	</table>
	<!--================== End of the section ================-->
	<table width="600" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#f4f4f4" class="table600">
	<tr>
	<td valign="middle" height="30" align="center" bgcolor="#f4f4f4" style="font-size:0; line-height:0;">&nbsp;</td>
	</tr>
	</table>
	<table width="280" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#f4f4f4" class="eraseForMobile2">
	<tr>
	<td valign="middle" height="10" align="center" bgcolor="#f4f4f4" style="font-size:0; line-height:0;">&nbsp;</td>
	</tr>
	</table>
	</td>
	</tr>
	</table>
	<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" class="moduleSeperatorLine">
	<tr>
	<td valign="top" align="center" bgcolor="#ffffff"> 
	<table width="280" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" class="eraseForMobile2">
	<tr>
	<td valign="middle" height="10" align="center" bgcolor="#ffffff" style="font-size:0; line-height:0;">&nbsp;</td>
	</tr>
	</table>
	<table width="600" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" class="table600">
	<tr>
	<td valign="top" align="center" height="20" bgcolor="#ffffff" style="font-size:0; line-height:0;">&nbsp;</td>
	</tr>
	<tr>			
	
	<td valign="middle" align="center" bgcolor="#ffffff" height="10" class="introTextTD">
	
	Cordialement,
	
	
	</td>
	
	</tr>
	
	<tr>
	<td valign="top" align="center" height="20" bgcolor="#ffffff" style="font-size:0; line-height:0;">&nbsp;</td>
	</tr>
	</table>
	<table width="280" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" class="eraseForMobile2">
	<tr>
	<td valign="middle" height="10" align="center" bgcolor="#ffffff" style="font-size:0; line-height:0;">&nbsp;</td>
	</tr>
	</table>
	</td>
	</tr>
	</table>
	
	
	
	<!---->
	<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#ff7a0d">
	<tr>
	<td valign="middle" align="center" height="50">
	<table width="600" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#ff7a0d" class="table600">
	<tr>
	<td valign="top" align="center" bgcolor="#ff7a0d"> 
	
	<table width="50" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#ff7a0d">
	<tr>
	
	<td valign="top" align="center" height="42" bgcolor="#ff7a0d"><a href="#" target="_blank" class="buttonsAndImagesLink"><img src="'.ROOT_URL.'assets/images/socialFacebook.jpg" style="display:block;" alt="" border="0" align="top" hspace="0" vspace="0" width="42" height="42"/></a></td>
	
	<td valign="top" align="center" height="42" bgcolor="#ff7a0d"><a href="#" target="_blank" class="buttonsAndImagesLink"><img src="'.ROOT_URL.'assets/images/socialTwitter.jpg" style="display:block;" alt="" border="0" align="top" hspace="0" vspace="0" width="42" height="42"/></a></td>
	
	<td valign="top" align="center" height="42" bgcolor="#ff7a0d"><a href="#" target="_blank" class="buttonsAndImagesLink"><img src="'.ROOT_URL.'assets/images/socialLinkedin.jpg" style="display:block;" alt="" border="0" align="top" hspace="0" vspace="0" width="42" height="42"/></a></td>
	
	<td valign="top" align="center" height="42" bgcolor="#ff7a0d"><a href="#" target="_blank" class="buttonsAndImagesLink"><img src="'.ROOT_URL.'assets/images/socialVimeo.jpg" style="display:block;" alt="" border="0" align="top" hspace="0" vspace="0" width="42" height="42"/></a></td>
	
	<td valign="top" align="center" height="42" bgcolor="#ff7a0d"><a href="#" target="_blank" class="buttonsAndImagesLink"><img src="'.ROOT_URL.'assets/images/socialPinterest.jpg" style="display:block;" alt="" border="0" align="top" hspace="0" vspace="0" width="42" height="42"/></a></td>
	
	<td valign="top" align="center" height="42" bgcolor="#ff7a0d"><a href="#" target="_blank" class="buttonsAndImagesLink"><img src="'.ROOT_URL.'assets/images/socialGoogle.jpg" style="display:block;" alt="" border="0" align="top" hspace="0" vspace="0" width="42" height="42"/></a></td>
	
	</tr>
	</table>
	
	</td>
	</tr>
	</table>
	</td>
	</tr>
	</table>
	<!---->        
	<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#43494e">
	<tr>
	<td valign="top" align="center" height="15" bgcolor="#43494e">
	<table align="center" width="600" cellpadding="0" cellspacing="0" style="color:#FFF !important;" bgcolor="#43494e" border="0" class="table600">
	<tr>
	<td valign="top" align="center" height="30" bgcolor="#43494e" style="font-size:0; line-height:0;">&nbsp;</td>
	</tr>
	<tr>
	
	<td valign="middle" align="center" height="10" bgcolor="#43494e" class="adressOrAnyOtherTD"><a href="#" target="_blank" class="adressOrAnyOtherTDLink" style="color:#ff7a0d !important;">'.$SAMAGROUP['email'].'</a>
	</td>	
	
	</tr>
	
	<tr>
	
	<td valign="middle" align="center" height="10" bgcolor="#43494e" class="mailingOptionsTD">'.$SAMAGROUP['address'].', '.$SAMAGROUP['postcode'].' '.$SAMAGROUP['city'].' Tel : '.$SAMAGROUP['phone_mobile'].' / '.$SAMAGROUP['phone'].'</td>
	
	</tr>
	<tr>
	<td valign="middle" align="center" height="3" bgcolor="#43494e" style="font-size:0; line-height:0;">&nbsp;</td>	
	</tr>
	
	<tr>
	
	<td valign="middle" width="50%" align="center" height="10" bgcolor="#43494e" class="copyrightCompanyTD"><img src="'.ROOT_URL.'assets/images/logo-footer.png"></td>
	</tr>
	<tr>
	
	<td valign="middle" width="50%" align="center" height="10" bgcolor="#43494e" class="copyrightCompanyTD">&copy; Copyright <a href="http://www.SAMAGROUP.be" target="_blank" class="copyrightCompanyTDLink" style="color:#ff7a0d !important;">SAMAGROUP</a> 2015</td>
	
	</tr>
	
	
	</table>
	</td>
	</tr>
	<tr>
	<td valign="top" align="center" height="35" bgcolor="#43494e" style="font-size:0; line-height:0;">&nbsp;</td>
	</tr>
	</table>   
	
	</center>
	</body>
	</html>';
	
	if(mail($email, $e_subject, $body, $headers)) {
	return true;
	}else {
	return false;
	}
	
	}
	/*générer un mot de passe*/
	function genere_pass($taille,$numeric=false){
	if($numeric){
	$cars="0123456789";
	}else{
	$cars="azertyuopqsdf6ghjk8lmwxcvbn123456789WXCVBNMLKJHGFP";
	}
	// Ensemble des caractères utilisés pour le créer
	
	// Combien on en a mis au fait ?
	$wlong=strlen($cars);
	// Au départ, il est vide ce mot de passe ;)
	$wpas="";
	// On initialise la fonction aléatoire
	srand((double)microtime()*1000000);
	// On boucle sur le nombre de caractéres voulus
	for($i=0;$i<$taille;$i++){
	// Tirage aléatoire d'une valeur entre 1 et wlong
	$wpos=rand(0,$wlong-1);
	// On cumule le caractère dans le mot de passe
	$wpas=$wpas.substr($cars,$wpos,1);
	// On continue avec le caractère suivant a  générer
	}
	return $wpas;
	}
	function numberFormat ( $price ,  $decimals = 2 , $dec_point= "." , $thousands_sep = "," ){
	
	return number_format ( $price ,  $decimals , $dec_point , $thousands_sep );
	}
	
	function percentage($val1,$val2,$deal=false){
	
	if($val2 == 0){
	return false;
	}
	
	
	$return =  numberFormat((($val1-$val2) / $val1)*100 , 0 );
	
	if($return>0 && $deal){
	return $return; 
	}else if($return>10){
	return $return; 
	}else{
	return false;
	}
	
	
	}
	
	function time_diff($d1,$d2){
	
	$to_time = strtotime($d1);
	$from_time = strtotime($d2);
	return round(abs($to_time - $from_time) / 60,2);
	
	}
	
	function getTimes($time){
	
	$explode = explode(':',$time);
	
	if(!isset($explode['1'])){
	return false;
	}
	
	$h = $explode['0'];
	$m = $explode['1'];
	
	return ($h * 60) + $m;
	
	}
	function convertToHoursMins($time, $format = '%02d:%02d') {
	if ($time < 1) {
	return;
	}
	$hours = floor($time / 60);
	$minutes = ($time % 60);
	return sprintf($format, $hours, $minutes);
	}
	function subscriptionRemain($id,$full=true){
	$db = db_connect();
	$subscription = $db->get_row("SELECT * FROM client_subscription WHERE client_subscription.id_client_subscription='$id'");
	
	$time = $subscription['duration'] * 60 ;
	
	if($subscription['used'] =="00:00:00"){
	$remain = $time;
	}else{
	$time_used = getTimes($subscription['used']);
	
	$remain = $time - $time_used;
	
	}
	
	
	if($remain > 0 ){
	if($full){
	return get_Time(convertToHoursMins($remain));
	}else{
	return convertToHoursMins($remain);
	}
	}else{
	return false;
	}
	
	}
	
	function updateUsed($id,$duration){
	$db = db_connect();
	$subscription = $db->get_row("SELECT * FROM client_subscription WHERE client_subscription.id_client_subscription='$id'");
	
	$used = date("H:i",strtotime($subscription['used'].' +'.$duration.' minutes'));
	
	if(!$db->update2("client_subscription",array('used'=>$used),"id_client_subscription",$id)){
	return false;
	}else{
	return true;
	}
	
	
	}
	function nettoyerChaine($chaine)
	{
	$caracteres = array(
	'À' => 'a', 'Á' => 'a', 'Â' => 'a', 'Ä' => 'a', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ä' => 'a', '@' => 'a',
	'È' => 'e', 'É' => 'e', 'Ê' => 'e', 'Ë' => 'e', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', '€' => 'e',
	'Ì' => 'i', 'Í' => 'i', 'Î' => 'i', 'Ï' => 'i', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
	'Ò' => 'o', 'Ó' => 'o', 'Ô' => 'o', 'Ö' => 'o', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'ö' => 'o',
	'Ù' => 'u', 'Ú' => 'u', 'Û' => 'u', 'Ü' => 'u', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'µ' => 'u',
	'Œ' => 'oe', 'œ' => 'oe',
	'&Aacute;' => 'a',
	'&aacute;' => 'a',
	'&acirc;' => 'a',
	'&Acirc;' => 'a',
	'&agrave;' => 'a',
	'&Agrave;' => 'a',
	'&aring;' => 'a',
	'&Aring;' => 'a',
	'&atilde;' => 'a',
	'&Atilde;' => 'a',
	'&auml;' => 'a',
	'&Auml;' => 'a',
	'&aelig;' => 'a',
	'&AElig;' => 'a',
	'&ccedil;' => 'c',
	'&Ccedil;' => 'c',
	'&eacute;' => 'e',
	'&Eacute;' => 'e',
	'&ecirc;' => 'e',
	'&Ecirc;' => 'e',
	'&egrave;' => 'e',
	'&Egrave;' => 'e',
	'&euml;' => 'e',
	'&Euml;' => 'e',
	'$' => 's');
	
	
	$chaine = strtr($chaine, $caracteres);
	$chaine = preg_replace('#[^_A-Za-z0-9]+#', '-', $chaine);
	$chaine = trim($chaine, '-');
	$chaine = strtolower($chaine);
	//$chaine=html_entity_decode($chaine);
	return $chaine;
	}
	
	function CodeGiftCardChoice($taille = 9){
	
	for($i=0;$i<100;$i++){
	
	$code = date('y').genere_pass($taille,true);
	
	
	
	$db = db_connect();
	
	$sql = $db->get_row("SELECT * FROM gift_card_choice WHERE gift_card_choice.code='$code'");
	if(empty($sql)){
	return $code;
	}
	
	
	}
	
	return false;
	
	}
	function getIDResponsibleFromCom($id){
	
	$db = db_connect();
	
	$user = $db->get_row("SELECT users.* FROM users WHERE users.id='".$db->escape($id)."'");
	if(!empty($user)){
	
	return $user['id_responsible'];
	
	}else {
	return false;
	}
	}
	function getIDContributorFromCom($id){
	
	$db = db_connect();
	
	$user = $db->get_row("SELECT users.* FROM users WHERE users.id='".$db->escape($id)."'");
	if(!empty($user)){
	
	return $user['id_contributor'];
	
	}else {
	return false;
	}
	}
	function countResponsable($id_contibutor=NULL){
	
	$db = db_connect();
	$filter=($id_contibutor)?"id_contributor='".$id_contibutor."'":"1";
	$user = $db->get_row("SELECT count(*) AS nb_responsable FROM  users WHERE $filter AND users.classe='4' AND users.deleted<>'1' ");
	if(!empty($user)){
	
	return $user['nb_responsable'];
	
	}else {
	return false;
	}
	}
	function countCommerciaux($id_contibutor=NULL,$id_responsible=NULL){
	
	$db = db_connect();
	$filter=($id_contibutor)?"id_contributor='".$id_contibutor."'":"1";
	$filter.=($id_responsible)?"AND id_responsible='".$id_responsible."'":" AND 1";
	$user = $db->get_row("SELECT count(*) AS nb_commerciaux FROM  users WHERE $filter AND users.classe='3'  AND users.deleted<>'1' ");
	if(!empty($user)){
	
	return $user['nb_commerciaux'];
	
	}else {
	return false;
	}
	}
	function getUser($id){
	
	$db = db_connect();
	
	$user = $db->get_row("SELECT users.* FROM users WHERE users.id='".$db->escape($id)."'");
	if(!empty($user)){
	
	return $user;
	
	}else {
	return false;
	}
	}
	?>						
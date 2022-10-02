<?php
include_once '../../includes/config.inc.php';

$idArticle=$_GET['idArticle'];
$NewVal=$_GET['NewVal'];

$query="UPDATE sous_products_table SET showSousProduct = ".$NewVal." where code_article= '".$idArticle."'";
if($db->query($query)){
	echo "Success";
}else{
	echo "Eurror";
}

?>
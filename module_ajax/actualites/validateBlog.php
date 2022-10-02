<?php  include_once '../../includes/config.inc.php';
    if(!$_POST) {exit;}
  
  
  
  $fields = array(
  'titre_fr'=>array(
  'rule'=>'/.+/',
  'message'=>'',
  'value'=>' titre (fr) est obligatoire',
  'required'=>TRUE
  ),
  'titre_en'=>array( 
  'rule'=>'/.+/',
  'message'=>'titre_en',
  'value'=>'', 
  'required'=>false
  ) 
  );
  
  $errors = array();
  foreach($fields as $k=>$v) {
    
    if(isset($_POST[$k])) {
      
      $required = (isset($v['required'])) ? (!empty($_POST[$k])) ? TRUE : $v['required']  : TRUE ;
      
      if(isset($v['rule']) && $required && !preg_match($v['rule'], $_POST[$k]) ) {
        
        if(isset($v['rule']) && !preg_match($v['rule'], $_POST[$k]) ) {
          
          if(isset($v['message']) && !empty($v['message'])) {
            $errors[] = $v['message'];
          }
        }
      }
      $fields[$k]['value'] = $_POST[$k];
    }
  }
  
  
  
  /*ajout*/
  if($_POST['action']=='add' ){
    
    /* echo $_POST['description_fr'];
    exit(); */
    if(empty($errors)) {
      $_POST['brev_description'] = addslashes($_POST['brev_description']); 
      $_POST['brev_description_en'] = addslashes($_POST['brev_description_en']);
      $_POST['description'] = addslashes($_POST['description']); 
      $_POST['description_en'] = addslashes($_POST['description_en']);   
      $_POST['titre_fr'] = addslashes($_POST['titre_fr']);   
      $_POST['titre_en'] = addslashes($_POST['titre_en']);   
      $_POST['type'] = "Bloger";   
      
      /********************/

      
      if(!$db->insert('actualites',$_POST)) {
        $errors[] = "erreur";
        } else {
        
        $id_actualite=$db->get_insert_id();
        
        foreach ($_SESSION['images-actualite'] as $img){
          if ($img!='-1'){
            $actualite_images=array();
            $actualite_images['id_actualite']=$id_actualite;
            $actualite_images['path']=$img;
            $actualite_images['statut']=1;
            $db->insert('actualite_images',$actualite_images);
          }
        }
        
        
        
        $_SESSION['notification'] = array('type'=>'succes','msg'=>'Blog ajouté avec succès');
        echo '<div class="alert alert-success alert-dismissible fade in">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <strong>Success:</strong> Blog ajoutée avec succès.</div>';
      }
      }else{
      $msg='<div class="list-group-item list-group-item-danger">   <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><strong>Erreur:</strong><br>';
      foreach($errors as $error):
      $msg.='- '.$error.'<br>';
      endforeach;
      $msg.='</div>';
      echo $msg;
      exit; 
    }
    
  }
  
  /*edit*/
  if($_POST['action']=='edit') {
    
    if(empty($errors))
    {
      $_POST['brev_description'] = addslashes($_POST['brev_description']); 
      $_POST['brev_description_en'] = addslashes($_POST['brev_description_en']);
      $_POST['description'] = addslashes($_POST['description']); 
      $_POST['description_en'] = addslashes($_POST['description_en']);   
      $_POST['titre_fr'] = addslashes($_POST['titre_fr']);   
      $_POST['titre_en'] = addslashes($_POST['titre_en']);
      
      if ($_POST['date_debut'] == "0000-00-00") {
        $_POST['date_debut'] = date("Y-m-d");
      }else {
        $_POST['date_debut'] = addslashes($_POST['date_debut']);
      }
        
      $_POST['date_fin'] = addslashes($_POST['date_fin']);
      $_POST['status'] = addslashes($_POST['status']);
      /***********************/
      
      if(!$db->update('actualites',$_POST,$_POST['id'])) {
        echo  '<div class="list-group-item list-group-item-danger">save failed</div>';
        } else {
        $id_actualite=$_POST['id'];
        $db->query("delete from actualite_images where id_actualite = ".$id_actualite);
        
        foreach ($_SESSION['images-actualite'] as $img)
        {
          if ($img!='-1'){
            $actualite_images=array();
            $actualite_images['id_actualite']=$id_actualite;
            $actualite_images['path']=$img;
            $db->insert('actualite_images',$actualite_images);
          }
        }
        
        echo '<div class="alert alert-success alert-dismissible fade in">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <strong>Success:</strong>Mise à jour effectué avec succès.</div>';
      }
      }else{
      $msg='<div class="list-group-item list-group-item-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><strong>Erreur:</strong><br>';
      foreach($errors as $error):
      $msg.='- '.$error.'<br>';
      endforeach;
      $msg.='</div>';
      echo $msg;
      exit;
    } 
  }
  
  /*edit_column_table*/
  if($_POST['action']=='edit_column_table') {
    
    if(empty($errors)) {
      
      $id_sub_categ=$_POST['id_sub_categ'];
      $db->query('DELETE FROM `sub_categ_column` WHERE  `id_sub_categ`='.$id_sub_categ);
      $colones=$_POST['colonnes'];
      foreach($colones as $colone){
        $sub_categ_column=array();
        $sub_categ_column['id_sub_categ']=$id_sub_categ;
        $sub_categ_column['id_colonnes']=$colone;
        $db->insert('sub_categ_column',$sub_categ_column);
      }
      
    echo '<div class="alert alert-success alert-dismissible fade in">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    <strong>Success:</strong> Mise à jour effectuée avec succès.</div>';
    
    
    }
    }
    
    
    
    ?>    
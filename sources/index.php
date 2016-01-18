<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" dir="ltr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      	<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Mes articles publiés" />
        <meta name="Keywords" content="" />
        <link rel="stylesheet" href="miseenpage.css" type="text/css" media="screen, projection" />
        <link rel="shortcut icon" href=""/>
        
        <title>Mes articles publiés</title>
    </head>
    
    <body>

    <h1>Mes articles:</h1>

    <?php
    try{
	      @$fluxrss=simplexml_load_file('https://mondomaine.net/ttrss/public.php?op=rss&id=-2&view-mode=all_articles&key=')
      	//on vérifie qu'on a bien une entrée
        if(empty($fluxrss->entry->id)) {
        		//si pas d'entrée on récupère fichier xml sauvé
		        if(!@$fluxrss=simplexml_load_file('sauvexml.xml')){
		            throw new Exception('Erreur');
        	  }
		        if(empty($fluxrss->entry->id)) {
			        throw new Exception('Erreur');
		        }
	      }
	
	      //sauvegarde dans un fichier pour gérer interruption futures serveur TTRSS
	      $fluxrss->asXML("sauvexml.xml");

        $i = 0;
        $nb_affichage = 2000;
        echo '<ul>';
        foreach($fluxrss->entry as $item){
            echo '<li><a href="'.(string)$item->link["href"].'">'.(string)$item->title.'</a> <small><i>publié le '.(string)date('d/m/Y à G\hi',strtotime($item->updated)).'</i></small><br>'.(string)$item->summary.'</li>';
            if(++$i>=$nb_affichage)
                break;
        }
        echo '</ul>';
    }
    catch(Exception $e){
        echo $e->getMessage();
    }
 
?>

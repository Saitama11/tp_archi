<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<form method="POST">
			<input type="text" name="nom" placeholder="Nom"><br>
			<textarea name="contenu" placeholder="Commentaire"></textarea><br>
			<input type="submit" value="Envoyer" name="envoyer">
		</form>
		<?php
		$lien=mysqli_connect("localhost","root","","tparchi");
		if(isset($_POST['envoyer']))
		{
			$nom=trim(htmlentities(mysqli_real_escape_string($lien,$_POST['nom'])));
			$contenu=trim(htmlentities(mysqli_real_escape_string($lien,$_POST['contenu'])));
			$req="INSERT INTO comments VALUES (NULL,'$nom','$contenu')";
			$res=mysqli_query($lien,$req);
			if(!$res)
			{
				echo "Erreur SQL:$req<br>".mysqli_error($lien);
			}
		}
		$sql="SELECT COUNT(idc) as nbcomt FROM comments";
		$req=mysqli_query($lien,$sql);
		$data=mysqli_fetch_array($req);
		$nbcomt=$data['nbcomt'];
		$commparpage=3;
		$nbpages=Ceil($nbcomt/$commparpage);
		if (isset($_GET['page']) && $_GET['page']>0 && $_GET['page']<=$nbpages ) {
			$cPage=$_GET['page'];
		}else {
			$cPage=1;
		}

		$sql="SELECT * FROM comments ORDER BY idc LIMIT ".(($cPage-1)*$commparpage).",$commparpage";
		$req=mysqli_query($lien,$sql) ;
		while ($data=mysqli_fetch_array($req)) {
			echo "<h2>".$data['nom']."</h2>";
			echo "<p>".$data['contenu']."</p>";
			echo "</hr>";
		}
		echo "<a href='commentaires.php?page=1'> << </a>";
		echo "<a href='commentaires.php?page=".($cPage-1)."'> < </a>";
		for ($i=1; $i <= $nbpages ; $i++) {
			echo "<a href='commentaires.php?page=$i'> $i </a>";
		}
		echo "<a href='commentaires.php?page=".($cPage+1)."'> > </a>";
		echo "<a href='commentaires.php?page=$nbpages'> >> </a>";
		mysqli_close($lien);
		?>

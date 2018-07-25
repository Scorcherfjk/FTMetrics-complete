<!doctype html>
<html lang="es">
  <head>

	<?php

	if ($_POST['inicio'] == "" || $_POST['final'] == ""){
		header("Location:"."/FTMetrics/php/");
	}else{
		$_SESSION['opcion3'] = $_POST['seleccion'];
		$_SESSION['fechaI3'] = $_POST['inicio'];
		$_SESSION['fechaF3'] = $_POST['final'];
	}
	
	require('../conection/conexion.php');
	require('../conection/consultas.php');
	$opcion = $_POST['seleccion'];
	$inicio = $_POST['inicio'];
	$final = $_POST['final'];

	if ( isset($_POST['addScrap']) && $_POST['addScrap'] != "" ){
			header("Location:"."/FTMetrics/php/");
	}else{
		$_POST['seleccion'] = $_SESSION['opcion3'];
		$_POST['inicio'] = $_SESSION['fechaI3'];
		$_POST['final'] = $_SESSION['fechaF3'];
	}

	?>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" 
	integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
    
	<title>FTMetrics</title>
  </head>
  <body>
    <div class="container">
    	<div class="jumbotron">
			<div class="row">
				<h1 class='text-center display-1 col'>FTMetrics</h1>
			</div>
    	</div>
		
<?php



$query = primaryQuery($opcion,$inicio,$final);
$prep = sqlsrv_prepare($conn,$query);
$resultado = sqlsrv_execute($prep);

while ( $fila = sqlsrv_fetch_array($prep) ){
?>
	<h1 class="text-center"> Add Scrap to <cite><?php echo($fila['sShortName']." - ".$fila['sPartId']); ?></cite></h1><br>	
	<ul class="nav justify-content-center">
	<li class="nav-item">
		<h5 class="nav-link">Id: <code><?php  echo $fila['lOEEWorkCellId']; ?></code></h5>
	</li>
	<li class="nav-item">
		<h5 class="nav-link"> Good Parts: <code><?php  echo $fila['dPartCount']; ?></code></h5>
	</li>
	<li class="nav-item">
		<h5 class="nav-link"> Scrap Parts: <code><?php  echo $fila['dScrapParts']; ?></code></h5>
	<li class="nav-item">
		<h5 class="nav-link"> Total Parts: <code><?php  echo $fila['dTotalParts']; ?></code></h5> 
	</li>
	</ul>
	<br><br>
	
	<form class="form-inline justify-content-center" method="POST" action="../conection/update.php">
		<div class="form-group mb-2">
		  <label for="Scrap" class="sr-only">Scrap</label>
		  <input type="text" readonly class="form-control-plaintext" id="Scrap" value="Quantity to add to scrap: ">
		</div>
		<div class="form-group mx-sm-3 mb-2">
		  <label for="addScrap" class="sr-only">addScrap</label>
		  <input required type="number" class="form-control" name="addScrap" id="addScrap" placeholder="Scrap">
		  <input type="hidden" name="lOEEWorkCellId" value="<?php  echo $fila['lOEEWorkCellId']; ?>">
		</div>
		<button type="submit" class="btn btn-primary mb-2">Add Scrap</button>
	  </form>

<?php
}

?>
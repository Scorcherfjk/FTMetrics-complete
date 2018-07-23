<!doctype html>

<?php
	
	require('./conexion.php');
	require('./consultas.php');
	require('./funciones.php');

?>

<html lang="es">
  <head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
    
	<title>FTMetrics</title>
  </head>
  <body>
    <div class="container">
    	<div class="jumbotron">
			<div class="row">  <a href="./index.php"></a>
				<h1 class='text-center col'><a href="./index.php"> FTMetrics</a></h1>

				<!--inicio del formulario-->
				<form name="form1" method="post" action="" style="max-width:300px; margin:auto;" class="col">

					<!--ventana de seleccion de opciones-->
					<div class="form-group">
						<label for="seleccion">Herramienta</label>
						<select id="seleccion" name="seleccion" class="form-control">
							<?php

							//contruccion de las opciones
							$option = dropDown();
							$optionready = sqlsrv_prepare($conn,$option);
							sqlsrv_execute($optionready);
							$i = 0;
							while ($row = sqlsrv_fetch_object($optionready)){
								echo "<option value='".$row->icwc."'>".$row->ssn."</option>";	
							} 
							?>
						</select>
					</div>

					<!--fecha inicial-->
					<div class="form-group">
						<label for="inicio">Fecha de inicio</label>
						<input require id="inicio" name="inicio" class="form-control" type="datetime-local" autofocus>
					</div>

					<!--fecha final-->
					<div class="form-group">
						<label for="final">Fecha de fin</label>
						<input require id="final" name="final" class="form-control" type="datetime-local">
					</div>

					<!--botones del formulario-->
					<button class="btn btn-primary" type="submit" value="Submit" name="button" id="button">Buscar</button>
					<button class="btn btn-primary" type="reset" value="reset" name="button2" id="button2">Restablecer</button>
				</form>
			</div>
    	</div>
		<?php

		//validando conexion
		if( isset( $conn ) ) {

			//construyendo la consulta de la tabla

			//formateo de las variables para la consulta
			$opcion = $_POST['seleccion'];
			$inicio = str_replace("T"," ",$_POST['inicio']).":00.000" ;
			$final = str_replace("T"," ",$_POST['final']).":00.000" ;
			
			//consulta al pasar la fecha
			$query = primaryQuery($opcion,$inicio,$final);
			$prep = sqlsrv_prepare($conn,$query);
			
			if ( $resultado = sqlsrv_execute($prep) ) { 
		?>
				<!--inicio de la tabla-->
				<table class="table table-striped">

					<!--encabezados de la tabla-->
					<thead>
						<tr class='text-center' >
							<th scope="col">Short Name</th>
							<th scope="col">Part Id</th>
							<th scope="col">Start Time</th>
							<th scope="col">End Time</th>
							<th scope="col">Good Parts</th>
							<th scope="col">Total Parts</th>
							<th scope="col">Scrap Parts</th>
							<th scope="col">Modify</th>
						</tr>
					</thead>
					<tbody>
						
					<!--construccion de las celdas-->
					<?php while ($fila = sqlsrv_fetch_array($prep)){

						//pasando las fechas a variables
						json_encode($fila);
						$fechaInicio = substr($fila['tStart']->date, 0, 19);
						$fechaFinal = substr($fila['tEnd']->date, 0, 19);

						//si la contiene algun valor en la columna de dScrapParts sera resaltada
						if ($fila['dScrapParts'] != 0 || $fila['dTotalParts'] == 0){
							?>

								<!--celda en caso de que ya haya una modificicion del Scrap-->
								<tr class="table-danger text-center" >
								<th scope="row"><?php echo $fila['sShortName'] ?></th>
									<td><?php echo $fila['sPartId'] ?></td>
									<td><?php echo $fechaInicio ?></td>
									<td><?php echo $fechaFinal ?></td>
									<td><?php echo $fila['dPartCount'] ?></td>
									<td><?php echo $fila['dTotalParts'] ?></td>
									<td><?php echo $fila['dScrapParts'] ?></td>
									<td>can't modify</td>
								</tr>

							<?php 
							continue;
						} ?>

						<!--celdas normales-->
						<tr class='text-center'>
							<form action="modify.php" method="post">
								<th scope="row"><?php echo $fila['sShortName'] ?></th>
								<td><?php echo $fila['sPartId'] ?></td>
								<td><?php echo $fechaInicio ?></td>
								<td><?php echo $fechaFinal ?></td>
								<td><?php echo $fila['dPartCount'] ?></td>
								<td><?php echo $fila['dTotalParts'] ?></td>
								<td><?php echo $fila['dScrapParts'] ?></td>
								<input type="hidden" id="seleccion" name="seleccion" value="<?php echo $fila['lOEEConfigWorkCellId'] ; ?>">
								<input type="hidden"  id="inicio" name="inicio" value="<?php echo $fechaInicio ; ?>">
								<input type="hidden" id="final" name="final" value="<?php echo $fechaFinal ; ?>">						
								<td>
									<input type="hidden" name="id" value="<?php echo  str_replace(" ","",$fila['sShortName']." _ ".$fila['sPartId']." _ ".$fila['lOEEWorkCellId']) ; ?>">
									<input class="btn btn-dark btn-sm" type="submit" value="modify">
								</td>
							</form>
						</tr>
					<?php
					} 					
					?>
			<?php
			}
		}else{

			//en caso de la conexion falle
			echo "Conexión no se pudo establecer.<br />";
			die( "<strong>el error ha sido : </strong>".print_r( sqlsrv_errors(), true));

		}
			?>
	</div>
	
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>
  </body>
</html>
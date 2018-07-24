<!doctype html>

<?php
	
	require('./conexion.php');
	require('./consultas.php');
	require('./funciones.php');
	$datos12 = array();
	$datos16 = array();

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
						json_encode($fila);

						//celdas normales
						if ($fila['sPartId'] == '16 oz'){
							if ($datos12 != []){ 
								json_encode($datos12); ?>
								<tr class='text-center'>
									<form action="searchSpecific.php" method="post">
										<th scope="row"><?php echo $datos12[0]['sShortName'] ?></th>
										<td><?php echo $datos12[0]['sPartId']; ?></td>
										<td><?php echo  substr($datos12[0]['tStart']->date, 0, 19); ?></td>
										<td><?php echo substr(end($datos12)['tEnd']->date, 0, 19); ?></td>
										<td><?php echo total($datos12, 'dPartCount'); ?></td>
										<td><?php echo total($datos12, 'dTotalParts'); ?></td>
										<td><?php echo total($datos12, 'dScrapParts'); ?></td>
										<input type="hidden" id="seleccion" name="seleccion" value="<?php echo $datos12[0]['lOEEConfigWorkCellId'] ; ?>">
										<input type="hidden"  id="inicio" name="inicio" value="<?php echo  substr($datos12[0]['tStart']->date, 0, 19); ?>">
										<input type="hidden" id="final" name="final" value="<?php echo substr(end($datos12)['tEnd']->date, 0, 19); ?>">						
										<td>
											<input class="btn btn-dark btn-sm" type="submit" value="modify">
										</td>
									</form>
								</tr>

								<?php
							}
							$datos16[] = $fila;
							$datos12 = array();

						}else{
							if ($datos16 != []){ 
								json_encode($datos16); ?>
								<tr class='text-center'>
									<form action="searchSpecific.php" method="post">
										<th scope="row"><?php echo $datos16[0]['sShortName'] ?></th>
										<td><?php echo $datos16[0]['sPartId']; ?></td>
										<td><?php echo  substr($datos16[0]['tStart']->date, 0, 19); ?></td>
										<td><?php echo substr(end($datos16)['tEnd']->date, 0, 19); ?></td>
										<td><?php echo total($datos16, 'dPartCount'); ?></td>
										<td><?php echo total($datos16, 'dTotalParts'); ?></td>
										<td><?php echo total($datos16, 'dScrapParts'); ?></td>
										<input type="hidden" id="seleccion" name="seleccion" value="<?php echo $datos16[0]['lOEEConfigWorkCellId'] ; ?>">
										<input type="hidden"  id="inicio" name="inicio" value="<?php echo substr($datos16[0]['tStart']->date, 0, 19); ?>">
										<input type="hidden" id="final" name="final" value="<?php echo substr(end($datos16)['tEnd']->date, 0, 19); ?>">						
										<td>
											<input class="btn btn-dark btn-sm" type="submit" value="modify">
										</td>
									</form>
								</tr>

							<?php
							}
							$datos12[] = $fila;
							$datos16 = array();
					}
				} 	
				

					$array = validar($datos12, $datos16); 
					json_encode($array);
					?>

					<tr class='text-center'>
					<form action="searchSpecific.php" method="post">
						<th scope="row"><?php echo $array['sShortName'] ?></th>
						<td><?php echo $array['sPartId']; ?></td>
						<td><?php echo $array['tStart'];  ?></td>
						<td><?php echo $array['tEnd'];  ?></td>
						<td><?php echo $array['dPartCount']; ?></td>
						<td><?php echo $array['dTotalParts']; ?></td>
						<td><?php echo $array['dScrapParts']; ?></td>
						<input type="hidden" id="seleccion" name="seleccion" value="<?php echo $array['lOEEConfigWorkCellId'] ; ?>">
						<input type="hidden"  id="inicio" name="inicio" value="<?php  echo  $array['tStart']; ?>">
						<input type="hidden" id="final" name="final" value="<?php echo $array['tEnd']; ?>">						
						<td>
							<input class="btn btn-dark btn-sm" type="submit" value="modify">
						</td>
					</form>
				</tr>
					
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
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Турнирная таблица</title>
	<link rel="stylesheet" href="style.css">
	<script src="js.js"></script>
</head>
<body>
	<h1>Турнирная таблица</h1>
	<p>Для сортировки нажмите на заголовок столбца</p>
	<?php	
	# Загрузка json файлов
		$res = file_get_contents('data_cars.json');
		$res2 = file_get_contents('data_attempts.json');
		$data = json_decode($res, true);	
		$data2 = json_decode($res2, true);
	?>

	<?php
	# Слияние двух массивов данных
		$data_new = array();

		foreach($data as $item){
			$data_new[$item["id"]] = $item;
		}
		foreach($data2 as $item_res){
			$data_new[$item_res["id"]]["result"][] = $item_res["result"];	
		}	
	?>

	<?php foreach ($data_new as $items){
		# Подсчет и добавление в массив суммы заездов
		$summa = 0;
		foreach($items["result"] as $key => $zaezd){
			$summa = $summa + $zaezd;
			$data_new[$items["id"]]["summa"] = $summa;	
		}
	}

	# Стандартная сортировка по сумме
	function stockSort($a, $b){
		return($a['summa'] < $b['summa']);
		}
		uasort($data_new, 'stockSort');

	?>

  	<table class="table_sort" id="tableS" border=1>
  		<thead>
  			<tr>
	  			<th>Место</th>			
	   			<th>ФИО</th>
	   			<th>Город</th>
	   			<th>Машина</th>
	   			<?php
	   				$i2=1;
	   				foreach($data_new as $items){	
	   					while ($i2 < count($items["result"])) {
	   						foreach ($items["result"] as $zaezd) {
	   							echo "<th>Заезд ".$i2."</th>";
	   							$i2++;
	   						}
	   					}   					
	   				}										
	   			?>
	   			<th>Сумма</th>				
  			</tr>
  		</thead>

  		<tbody>
	  		<!-- Заполнение таблицы  -->
			<?php 
			$i=1;
			foreach($data_new as $items): ?>
			<tr>	
				<td><?php echo $i;?></td>		
				<td><?php echo $items["name"]; ?></td>
				<td><?php echo $items["city"]; ?></td>
				<td><?php echo $items["car"]; ?></td>

				<?php

				#Заполнение результатов заездов
				foreach($items["result"] as $zaezd){	
					echo "<td>".$zaezd."</td>";			
				}

				?>
				<td><?php echo $items["summa"]?></td>
					
			</tr>
			<?php 
			$i++;
			endforeach; ?>
  		</tbody>
	</table>
	<div class="myName">
		<p>Красноперов Павел</p>
	</div>
	
</body>
</html>

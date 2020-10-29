<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Турнирная таблица</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<h1>Турнирная таблица</h1>

	<!-- Формы кнопок -->
	<div class="divBut">
		<form class="b1" method="POST">
			<div class="div2">	
		    	<input type="submit" class="but" name="sortBy1" value="Сортировать 1 заезд" />
		    	<input type="submit" class="but" name="sortBy2" value="Сортировать 2 заезд" />
		    	<input type="submit" class="but" name="sortBy3" value="Сортировать 3 заезд" />
		    	<input type="submit" class="but" name="sortBy4" value="Сортировать 4 заезд" />
		    	<input type="submit" class="but" name="sortBySumm" value="Сортировать по сумме" />
			</div>
		</form>

	</div>

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

	# Сортировка суммы по нажатию кнопки
	if(isset($_POST['sortBySumm'])){
		function sortBySumm($a, $b){
		return($a['summa'] < $b['summa']);
		}
		uasort($data_new, 'sortBySumm');
	}

	# Сортировка 1 заезда
    if(isset($_POST['sortBy1'])){
        function sortBy1($a, $b){
			return($a['result'][0] < $b['result'][0]);
		}
		uasort($data_new, 'sortBy1');
    }

	# Сортировка 2 заезда
    if(isset($_POST['sortBy2'])){
        function sortBy2($a, $b){
			return($a['result'][1] < $b['result'][1]);
		}
		uasort($data_new, 'sortBy2');
    }

	# Сортировка 3 заезда
    if(isset($_POST['sortBy3'])){
        function sortBy3($a, $b){
			return($a['result'][2] < $b['result'][2]);
		}
		uasort($data_new, 'sortBy3');
    }

	# Сортировка 4 заезда
    if(isset($_POST['sortBy4'])){
        function sortBy4($a, $b){
			return($a['result'][3] < $b['result'][3]);
		}
		uasort($data_new, 'sortBy4');
    }
	?>

  	<table id="tableS" border=1>
  		<tr>
  			<th>Место</th>	
   			<th>ФИО</th>
   			<th>Город</th>
   			<th>Машина</th>
   			<th>Заезд 1</th>
   			<th>Заезд 2</th>
   			<th>Заезд 3</th>
   			<th>Заезд 4</th>
   			<th>Сумма</th>
  		</tr>

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
	</table>
</body>
</html>

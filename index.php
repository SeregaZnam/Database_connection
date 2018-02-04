<?php  
	require_once 'connectDatabase.php';

	$db = new Database();

	if(!empty($_REQUEST['name']) && !empty($_REQUEST['comment'])){
		$name = $_REQUEST['name'];
		$comment = $_REQUEST['comment'];
		$pdoQuery = "INSERT INTO `task_1`(`name`, `comment`) VALUES (:name,:comment)";
		$pdoResult = $db->insert($pdoQuery, $name, $comment);
		header('Location: http://test2/');
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="styles.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
	<div class="main">
		<h1>Гостевая книга</h1>
		<nav aria-label="Page navigation">
		  <ul class="pagination">
		    <li>
		      <a href="/" aria-label="Previous">
		        <span aria-hidden="true">&laquo;</span>
		      </a>
		    </li>
		    <?php  
		    	if (!isset($_GET['page'])) {
		    		$page = 1;
		    	} else {
		    		$page = $_GET['page'];
		    	}

		    	$row = $db->num_rows_table("SELECT * FROM task_1");
		    	$number_per_page = 3;
		    	$number_of_page = ceil($row / $number_per_page);

		    	$this_page_first_result = ($page - 1) * $number_per_page;

		    	for ($page = 1; $page <= $number_of_page; $page++) { 
		    		echo '<li><a href="/?page='.$page.'">'.$page.'</a></li>';
		    	}
		    ?>
		    <li>
		      <a href="/?page=<?php echo $number_per_page; ?>" aria-label="Next">
		        <span aria-hidden="true">&raquo;</span>
		      </a>
		    </li>
		  </ul>
		</nav>
		<?php  
			$data = $db->query("SELECT * FROM task_1 LIMIT ".$this_page_first_result.','.$number_per_page);

			foreach ($data as $key => $value):
				$datetime = explode(' ', $value['date']);
				$date = explode('-', $datetime[0]);
				$time = $datetime[1];
				$date = array_reverse($date);
				$date = implode('.', $date);
		?>
		<div class="post">
			<div class="data">
				<span class="date"><b><? echo $date; ?></b></span>
				<span class="time"><b><? echo $time; ?></b></span>
				<span class="name"><? echo $value['name']; ?></span>
			</div>
			<div class="comment">
				<? echo $value['comment']; ?>
			</div>
		</div>
		<?php endforeach; ?>
		<nav aria-label="Page navigation">
		  <ul class="pagination">
		    <li>
		      <a href="/" aria-label="Previous">
		        <span aria-hidden="true">&laquo;</span>
		      </a>
		    </li>
		    <?php  
		    	if (!isset($_GET['page'])) {
		    		$page = 1;
		    	} else {
		    		$page = $_GET['page'];
		    	}

		    	$row = $db->num_rows_table("SELECT * FROM task_1");
		    	$number_per_page = 3;
		    	$number_of_page = ceil($row / $number_per_page);

		    	$this_page_first_result = ($page - 1) * $number_per_page;

		    	for ($page = 1; $page <= $number_of_page; $page++) { 
		    		echo '<li><a href="/?page='.$page.'">'.$page.'</a></li>';
		    	}
		    ?>
		    <li>
		      <a href="/?page=<?php echo $number_per_page; ?>" aria-label="Next">
		        <span aria-hidden="true">&raquo;</span>
		      </a>
		    </li>
		  </ul>
		</nav>
		<div class="success-comment">
			Запись успешно сохранена!
		</div>
		<form action="" class="form-send" method="GET">
			<input type="text" class="form-name" name="name" placeholder="Ваше имя">
			<textarea class="form-comment" name="comment" placeholder="Ваш отзыв"></textarea>
			<input type="submit" class="form-submit" value="Сохранить">
		</form>
	</div>
</body>
</html>
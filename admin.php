<?php 
	$pageTitle = 'Панель администратора | Базовые понятия HTML';

	function fileLoad () {

		if (isset($_FILES['InputFile']['name'])) {
			
			$uploaddir = 'uploads/';
			$uploadfile = $uploaddir . basename($_FILES['InputFile']['name']);
			
			move_uploaded_file($_FILES['InputFile']['tmp_name'], $uploadfile);
			
			$JSONfile = json_decode (file_get_contents("$uploadfile"));
			if ($JSONfile !== null ) {
				echo "<p class='text-success'>Файл корректен и был успешно загружен.</p><p class=\"lead\">Теперь этот тест доступен в <a href=\"/2.2/list.php\">списке тестов</a>.";
			} else {
				unlink($uploadfile);
				echo "<p class='text-danger'>Возможна загрузка только JSON файлов.</p>";
			}
		}
		}

	require_once ('header.php');
?>
		<div class="container">
			<div class="page-header">
				<h1>Загрузка тестов в систему</h1>
			</div>
			<div class="row">
				<div class="col-md-12">
					<p class="lead">Уважаемый администратор, для того, чтобы предоставить доступ к тестам, загрузите вопросы и ответы в формате JSON в систему.</p>
					<p>Если у вас нет материалов, подходящих для загрузки — скачайте <a href="test2.json">стандартный тест</a> и загрузите его в систему.</p>
					<form enctype="multipart/form-data" method="POST" action="">
					  <div class="form-group">
						<label for="InputFile">Загрузить JSON-файл с тестом</label>
						<input type="hidden" name="MAX_FILE_SIZE" value="10000" />
						<input type="file" name="InputFile">
					  </div>
					  <button type="submit" class="btn btn-default">Загрузить</button>
					</form>
				</br>
				<?php fileLoad (); ?>
				</div>
			</div>
		</div>
	</body>
</html>
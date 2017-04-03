<?php

	$pageTitle = 'Сдать тест | Базовые понятия HTML';

	$choosenJSON = isset($_GET['choosenJSON']) ? $_GET['choosenJSON'] : '';
	$JSONfile = json_decode (file_get_contents("$choosenJSON"));
	
	function showTest ($JSONfile, $choosenJSON) {
	$n = 0;
	echo '<form action="" method="post">';
	if ($choosenJSON == true) {
		foreach ($JSONfile as $object) {
			foreach ($object as $key => $question) {
				if ($question == 'radio') {
					$typeFlag = 'radio';
					$n++;
				} elseif ($question == 'check') {
					$typeFlag = 'check';
				} elseif ($question == 'text') {
					$typeFlag = 'text';
				} else {
					if ($typeFlag == 'radio') {
						if ($key == 'question') {
							echo '<label>Вопрос: ' . $question . '</label>';
						} elseif ($key == 'answers') {
							$checkboxes = explode (', ', $question);
							foreach ($checkboxes as $checkbox) {
								echo '<div class="radio">
										<label>
											<input type="radio" name="radio' . $n . '" value="' . $checkbox . '">
												' . $checkbox . '
										</label>
									</div>';	
						}
						}
					} elseif ($typeFlag == 'check') {
						if ($key == 'question') {
							echo '<label>Вопрос: ' . $question . '</label>';
						} elseif ($key == 'answers') {
							$checkboxes = explode (', ', $question);
							foreach ($checkboxes as $checkbox) {
								echo '<div class="checkbox">
										<label>
											<input type="checkbox" name="check[]" value="' . $checkbox . '">
												' . $checkbox . '
										</label>
									</div>';
						}
						}
					} elseif ($typeFlag == 'text') {
						if ($key == 'question') {
							echo '<div class="form-group"><label>Вопрос: ' . $question . '</label>
							<input type="text" class="form-control" name="text" placeholder="Введите ответ">';
						}
					}
				}
			}
		
		}
		echo '<input type="hidden" name="JSONtest" value="' . $choosenJSON . '" />';
		echo '<br/><button type="submit" class="btn btn-default">Submit</button>';
	}
	echo '</form>';
	}
	
	$JSONtest = isset($_POST['JSONtest']) ? $_POST['JSONtest'] : '';
	if (!empty($JSONtest)) {
		$JSONfile = json_decode (file_get_contents("$JSONtest"));
	}

	$receivedAnswers = array ();
	foreach ($_POST as $key => $value) {
		if ($key !== 'JSONtest') {
			if (is_array($value)) {
				$receivedAnswers[] = implode (', ', $value);
			} else {
				$receivedAnswers[] = $value;
			}
		}
	}
	
	$rightAnswers = array ();
	if ($JSONtest == true) {
		foreach ($JSONfile as $object) {
			foreach ($object as $key => $question) {
				if ($key == 'rightAnswer') {
					$rightAnswers[] = $question;
				}
			}
		}
	}
	
	function result ($rightAnswers, $receivedAnswers) {
		$overlap = array_intersect($rightAnswers, $receivedAnswers);
		echo '<h3>Уважаемый студент, результат вашего теста:</br>';
		echo ' — правильных ответов: ' . count ($overlap) . '<br/>';
		echo ' — набранных баллов: ' . round((count ($overlap) / count ($rightAnswers) * 100),0) . '</h3>';
	}

require_once ('header.php');

?>
		<div class="container">
			<div class="page-header">
				<h1>Тест <?php echo $choosenJSON; ?></h1>
			</div>
			<div class="row">
				<div class="col-md-12">
					<?php if (!empty($_POST)) {
						result ($rightAnswers, $receivedAnswers); 
					} else {
						showTest ($JSONfile, $choosenJSON);
					}?>
				</div>
			</div>
		</div>
	</body>
</html>
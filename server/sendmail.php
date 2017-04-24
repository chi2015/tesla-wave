<?php
	header('Content-type: text/html; charset=windows-1251');

	if (isset($_POST['email']) && $_POST['email']!='' && !preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/", $_POST['email']))
	{
		echo json_encode(array('status' => 'error', 'desc' => 'Некорректный адрес E-mail'));
		die();
	}

	$message = '<h3>Вам пришел заказ. Данные заказа:</h3>
	  <table><tr><td>Имя:</td><td>'.(isset($_POST['fio']) ?   iconv('UTF-8', 'windows-1251', $_POST['fio']) : '').'</td></tr>
	   		<tr><td>Телефон:</td><td> '.(isset($_POST['phone']) ? iconv('UTF-8', 'windows-1251', $_POST['phone']) : '').'</td></tr>
	   		<tr><td>Способ доставки:</td><td> '.(isset($_POST['delivery_type']) ? iconv('UTF-8', 'windows-1251', $_POST['delivery_type']) : '').'</td></tr>
	   		<tr><td>Наименование товара:</td><td> '.(isset($_POST['name']) ? iconv('UTF-8', 'windows-1251', $_POST['name']) : '').'</td></tr>
	   		<tr><td>Количество, штук:</td><td> '.(isset($_POST['count']) ? iconv('UTF-8', 'windows-1251', $_POST['count']) : '').'</td></tr>
	   		<tr><td>Стоимость, руб.:</td><td> '.(isset($_POST['cost']) ? iconv('UTF-8', 'windows-1251', $_POST['cost']) : '').'</td></tr>
	   		<tr><td>Доп. информация:</td><td> '.(isset($_POST['comments']) ? iconv('UTF-8', 'windows-1251', $_POST['comments']) : '').'</td></tr></table>
';


  	 // $to      = 'tesla340@mail.ru';
  	 //$to = 'alliluya@yandex.ru';
	  $to = 'arkadii1900@gmail.com';
	  $subject = iconv('UTF-8', 'windows-1251', $_POST['subject']);

	  $email = $_POST['email'] != '' ? $_POST['email'] : 'noreply@tesla-wave.ru';

	  $headers = 'Content-Type: text/html; charset="windows-1251"'. "\r\n" .
	  'From: ' .$email . "\r\n" .
    'Reply-To: ' .$email. "\r\n" .
    'Content-Type: text/html; charset="windows-1251"'. "\r\n Content-Transfer-Encoding: 8bit" .
    'X-Mailer: PHP/' . phpversion();

	mail('florabah2@gmail.com', $subject, $message, $headers);

	if (mail($to, $subject, $message, $headers))
	{
		echo json_encode(array('status' => 'ok'));
	}
	else
	{
		echo json_encode(array('status' => 'error', 'desc' => 'Ошибка при отправке заказа'));
	}

?>
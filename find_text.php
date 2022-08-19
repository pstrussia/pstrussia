<?header("Content-type: text/html; charset=cp1251");?><html><head><title>Поиск файлов</title></head><body><?
define('DisableReplace',true);

if ($_REQUEST['code'])
{
	define('START_TIME', time()); // засекаем время старта
	define('CODE', str_replace("\r\n","\n",$_REQUEST['code'])); // строка поиска
	define('START_PATH', dirname(__FILE__)); // стартовая папка для поиска
	define('LOG',START_PATH.'/filelist.txt'); // файл с результатами
	if ($_REQUEST['break_point']) 
		define('SKIP_PATH',$_REQUEST['break_point']); // промежуточный путь
	else 
		@unlink(LOG); // первый раз, удалим файл со старыми результатами


	Search(START_PATH);
	if (defined('BREAK_POINT'))
	{
		?><form method=post id=postform>
			<input type=hidden name=go value=y>
			<input type=hidden name=code value="<?=htmlspecialchars(CODE)?>">
			<input type=hidden name=break_point value="<?=htmlspecialchars(BREAK_POINT)?>">
		</form>
		Идёт поиск...<br>
		Текущий файл: <i><?=htmlspecialchars(BREAK_POINT)?></i>
		<script>window.setTimeout("document.getElementById('postform').submit()",500);</script><? // таймаут чтобы браузер показал текст
		die();
	}
	$iframe = "<iframe src=filelist.txt width=100% height=600></iframe>";
}
else
	$iframe = '';
?>
<h1>Поиск заражённых файлов php</h1>
<p>Пример скрипта, описанного в блоге: <a href="http://dev.1c-bitrix.ru/community/blogs/howto/1051.php">http://dev.1c-bitrix.ru/community/blogs/howto/1051.php</a></p>
Папка для поиска: <b><?=dirname(__FILE__)?></b><br>
Введите искомый текст (текст вируса):
<form method=post>
	<textarea name=code cols=80 rows=10><?=htmlspecialchars($_REQUEST['code'])?></textarea>
	<br><input type=submit name=go value="Поиск"> печать списка в файл
	<? if (!defined('DisableReplace') || DisableReplace == false) { ?>
	<br><input type=submit name=cure value="Замена"> удаление из всех файлов найденного текста, исходные файлы переименовываются в [имя].orig
	<br><input type=submit name=restore value="Восстановление"> обратное переименование из *.php.orig файлов с вирусом в .php
	<? } ?>
</form>
<?
	if (file_exists(LOG))
		echo $iframe;

function Search($path)
{
	if (time() - START_TIME > 10)
	{
		if (!defined('BREAK_POINT'))
			define('BREAK_POINT', $path);
		return;
	}

	if (defined('SKIP_PATH') && !defined('FOUND')) // проверим, годится ли текущий путь
	{
		# /bitrix/components/bitrix/forum/message
		# /bitrix/components/alpha - годится
		# /bitrix/components/alpha/beta - не годится
		if (0!==strpos(SKIP_PATH, dirname($path))) // отбрасываем имя или идём ниже 
			return;

		if (SKIP_PATH==$path) // путь найден, продолжаем искать текст
			define('FOUND',true);
	}

	if (is_dir($path)) // dir
	{
		$dir = opendir($path);
		while($item = readdir($dir))
		{
			if ($item == '.' || $item == '..')
				continue;

			Search($path.'/'.$item);
		}
		closedir($dir);
	}
	else // file
	{
		if (!defined('SKIP_PATH') || defined('FOUND'))
		{
			if (substr($path,-4) == '.php')
			{
				$str = file_get_contents($path);
				$str = str_replace("\r\n","\n",$str);
			
				if (false !== strpos($str,CODE))
					Mark($path, $str);
			}
			elseif ($_REQUEST['restore'] && substr($path, -9) == '.php.orig')
				rename($path,substr($path,-5)); // отрезаем 5 символов справа: .orig
		}
	}
}

function Mark($file, $str)
{
	static $res;
	if (!$res)
		$res = fopen(LOG,'ab');
	if (!$res)
		die('no permissions: '.LOG);
	if ($_REQUEST['cure'])
	{
		if (!copy($file,$file.'.orig'))
			die('no permissions: '.$file);
		$f = fopen($file,'wb');
		if (!$f)
			die('no permissions: '.$file);
		fwrite($f, str_replace(CODE,'',$str));
		fclose($f);
	}
	fwrite($res,substr($file,strlen(START_PATH))."\n");
}
?>

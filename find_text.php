<?header("Content-type: text/html; charset=cp1251");?><html><head><title>����� ������</title></head><body><?
define('DisableReplace',true);

if ($_REQUEST['code'])
{
	define('START_TIME', time()); // �������� ����� ������
	define('CODE', str_replace("\r\n","\n",$_REQUEST['code'])); // ������ ������
	define('START_PATH', dirname(__FILE__)); // ��������� ����� ��� ������
	define('LOG',START_PATH.'/filelist.txt'); // ���� � ������������
	if ($_REQUEST['break_point']) 
		define('SKIP_PATH',$_REQUEST['break_point']); // ������������� ����
	else 
		@unlink(LOG); // ������ ���, ������ ���� �� ������� ������������


	Search(START_PATH);
	if (defined('BREAK_POINT'))
	{
		?><form method=post id=postform>
			<input type=hidden name=go value=y>
			<input type=hidden name=code value="<?=htmlspecialchars(CODE)?>">
			<input type=hidden name=break_point value="<?=htmlspecialchars(BREAK_POINT)?>">
		</form>
		��� �����...<br>
		������� ����: <i><?=htmlspecialchars(BREAK_POINT)?></i>
		<script>window.setTimeout("document.getElementById('postform').submit()",500);</script><? // ������� ����� ������� ������� �����
		die();
	}
	$iframe = "<iframe src=filelist.txt width=100% height=600></iframe>";
}
else
	$iframe = '';
?>
<h1>����� ��������� ������ php</h1>
<p>������ �������, ���������� � �����: <a href="http://dev.1c-bitrix.ru/community/blogs/howto/1051.php">http://dev.1c-bitrix.ru/community/blogs/howto/1051.php</a></p>
����� ��� ������: <b><?=dirname(__FILE__)?></b><br>
������� ������� ����� (����� ������):
<form method=post>
	<textarea name=code cols=80 rows=10><?=htmlspecialchars($_REQUEST['code'])?></textarea>
	<br><input type=submit name=go value="�����"> ������ ������ � ����
	<? if (!defined('DisableReplace') || DisableReplace == false) { ?>
	<br><input type=submit name=cure value="������"> �������� �� ���� ������ ���������� ������, �������� ����� ����������������� � [���].orig
	<br><input type=submit name=restore value="��������������"> �������� �������������� �� *.php.orig ������ � ������� � .php
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

	if (defined('SKIP_PATH') && !defined('FOUND')) // ��������, ������� �� ������� ����
	{
		# /bitrix/components/bitrix/forum/message
		# /bitrix/components/alpha - �������
		# /bitrix/components/alpha/beta - �� �������
		if (0!==strpos(SKIP_PATH, dirname($path))) // ����������� ��� ��� ��� ���� 
			return;

		if (SKIP_PATH==$path) // ���� ������, ���������� ������ �����
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
				rename($path,substr($path,-5)); // �������� 5 �������� ������: .orig
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

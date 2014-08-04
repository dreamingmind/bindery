<?php
$class_directory = '/_p/'; // path to the folder where php class files are stored
include_once("../_p/site_init.php"); // now classes stored in the class directory will autoload
$path = new dmpath; // 
$leather = $cloth = FALSE;
/*
now access any relative path with $relPath = path::to('/full/site/path/')
or access relative paths named below with $path->getPath('name')
	name			  location
	---------------   ----------------------------------------
	p				= classes
	j3				= assignment 3 javascript scripts
	c3				= assignment 3 css files
	p3				= assignment 3 php scripts
	i3				= assignment 3 image folder
	thumb3			= assignment 3 material thumbnails
	full3			= assignment 3 material detail shots
*/
if (!isset($_GET['x'])){
	if ($_SERVER['SERVER_NAME'] == 'localhost') {
		$db = new MySQL(true,"bindery3","localhost","root",'Up?4worDs');
	} else {
		$db = new MySQL(true,"imagenames","imagenames.dreamingmind.com","mycustomer",'A9$sGtwz3xJu=');
	}
	$db->Query("SELECT id, file_name fn, title ti FROM materials WHERE category = 'cloth'");
	$cStart = rand(0,$db->RowCount()-1); // random starting point for leather display
	$cloth = json_encode($db->RecordsArray(MYSQL_ASSOC));
	
	$db->Query("SELECT id, file_name fn, title ti FROM materials WHERE category = 'leather'");
	$lStart = rand(0,$db->RowCount()-1); // random starting point for leather display
	$leather = json_encode($db->RecordsArray(MYSQL_ASSOC));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Dreaming Mind Materials Choices</title>
<link href="_c/material.css" rel="stylesheet" type="text/css" />
<script src="_j/materials.js"></script>
<script type="text/javascript">
<!--This brings the material data set to the javascript program-->
<!--from the db unless the db is down, then it uses a default set-->
var thumbPath = "_i/thumbsize";
var imagePath = "_i/fullsize";
var leatherAlert="";
var clothAlert="";
var lStart = <?php echo (isset($lStart)) ? $lStart : 0; ?>;
var cStart = <?php echo (isset($cStart)) ? $cStart : 0; ?>;
<?php if ($leather) { ?>
var leatherIn = <?php echo $leather; ?>;
<?php } else { ?>
var leatherAlert = "The database is down. This is a default set of leather and may not reflect all currently available choices.";
var leatherIn = [
	{"id":"0","fn":"bbluelthr","ti":"Bright Blue"},
	{"id":"1","fn":"blklthr","ti":"Black"},
	{"id":"2","fn":"bluelthr","ti":"Blue"},
	{"id":"4","fn":"terracottalthr","ti":"Terracotta"},
	{"id":"5","fn":"brndylthr","ti":"Burgundy"},
	{"id":"6","fn":"chestnutlthr","ti":"Chestnut"},
	{"id":"7","fn":"Chocolatelthr","ti":"Chocolate"},
	{"id":"8","fn":"crimsonlthr","ti":"Crimson"},
	{"id":"14","fn":"grnlthr","ti":"Green"},
	{"id":"16","fn":"grylthr","ti":"Gray"},
	{"id":"17","fn":"ltbllther","ti":"Light Blue"},
	{"id":"24","fn":"rchbrnlthr","ti":"Rich Brown"},
	{"id":"26","fn":"saddlelthr","ti":"Saddle Tan"}];
<?php } ?>     
<?php if ($cloth) { ?>
var clothIn = <?php echo $cloth; ?>;
<?php } else { ?>
var clothAlert = "The database is down. This is a default set of cloth and may not reflect all currently available choices.";
var clothIn = [
	{"id":"3","fn":"bone","ti":"Bone"},
	{"id":"9","fn":"drktaupe","ti":"Dark Taupe"},
	{"id":"10","fn":"fltblack","ti":"Black"},
	{"id":"11","fn":"fltburg","ti":"Burgundy"},
	{"id":"12","fn":"forestgreen","ti":"Forest Green"},
	{"id":"13","fn":"grey","ti":"Gray"},
	{"id":"15","fn":"grnslub","ti":"Green Slub"},
	{"id":"18","fn":"mohblk","ti":"Mohair Black"},
	{"id":"19","fn":"mohblue","ti":"Mohair Blue"},
	{"id":"20","fn":"mohbrwn","ti":"Mohair Brown"},
	{"id":"21","fn":"mohgreen","ti":"Mohair Green"},
	{"id":"22","fn":"mohred","ti":"Mohair Red"},
	{"id":"23","fn":"olive","ti":"Olive"},
	{"id":"25","fn":"redslub","ti":"Red Slub"},
	{"id":"27","fn":"tan","ti":"Tan"}];
<?php } ?>     
</script>
</head>
<body>
<div id="wrapper">

	<div class="galWrapper two">
	  <div class="galNav">

        <div id="spineM" class="matPix">
        </div> <!-- end of spineM (leather color thumbnails) -->

        <div id="boardsM" class="matPix">
        </div> <!-- end of boardsM (cloth color thumbnails) -->

        <div id="formatList">
        <div id="case" class="journal">
       	  <div id="spine" class="quarter"></div> <!-- end of spine div (leather choice display)-->
          <div id="boards"></div> <!-- end of boards div (cloth choice display)-->
        </div> <!-- end of case div (product/material choice display)-->
        
        <div id="colorLabels">
          <p><span class="materialLabel" id="spineLabel"></span><br /><span class="materialLabel" id="boardsLabel"></span></p>
        </div> <!-- end of colorLabels div (material color name display) -->
        
        <p id="products">
          <label><input type="radio" name="fl1" value="journal" id="fl1_0"  checked="checked"/>Journal</label><br />
          <label><input type="radio" name="fl1" value="notebook" id="fl1_1" />Notebook</label><br />
          <label><input type="radio" name="fl1" value="stenopad" id="fl1_2" />Steno Pad</label>
        </p>
        <p id="binding">
          <label><input type="radio" name="b1" value="full" id="b1_0" />Full Leather</label><br />
          <label><input type="radio" name="b1" value="quarter" id="b1_1" checked="checked" /> Quarterbound</label>
        </p>
        <p>&nbsp;Behavior modification<br />
        <label><input id="step" type="checkbox" />Pause on each step</label><br />
        <label>Delay (0-10) <input type="text" id="delay" value="0" /></label><br />
        Simulate database-down condition:<br />
        <a href="materials.php?x=1">DB Failure</a><br />
        <a href="materials.php">DB OK</a>
        </p>
        </div> <!-- end fomatList div -->
        
        <div id="caveat">
        	<p><strong>Colors are approximate:</strong> Leather is a natural product. Every piece  has a slightly different texture and color. Additionally, every computer monitor will display slightly different colors.</p>
        </div> <!-- end caveat div -->

	  </div> <!-- end of galNav -->
	</div> <!-- end of galWrapper -->
	  
	<div id="detail">
</div> <!-- end of dtail -->
  

  <div id="gallery">
    	<div id="navBar"><a href="../index.html">Don Drake - Javascript Class Pages</a><!-- end of wrapper -->
</div>
  </div>
</div>
<?php 
//echo "$cloth \n\n$leather";
//print_r($_SERVER);
//print_r($leather);
?>
</body>
</html>
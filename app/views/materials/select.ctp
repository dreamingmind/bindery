<div id="wrapper">

    <div id="spineM" class="matPix">
        <p>Leather color choices</p>
        
<!--        <ul>
            <li onclick="doMaterialClick(this)" style="background-image:url(/bindery/img/materials/thumbsize/saddlelthr.jpg)" title="Saddle Tan" id="l0">13</li>
            <li onclick="doMaterialClick(this)" style="background-image:url(/bindery/img/materials/thumbsize/bbluelthr.jpg)" title="Bright Blue" id="l1">1</li>
            <li onclick="doMaterialClick(this)" style="background-image:url(/bindery/img/materials/thumbsize/blklthr.jpg)" title="Black" id="l2">2</li>
            <li onclick="doMaterialClick(this)" style="background-image:url(/bindery/img/materials/thumbsize/bluelthr.jpg)" title="Blue" id="l3">3</li>
            <li onclick="doMaterialClick(this)" style="background-image:url(/bindery/img/materials/thumbsize/terracottalthr.jpg)" title="Terracotta" id="l4">4</li>
            <li class="displayed" onclick="doMaterialClick(this)" style="background-image:url(/bindery/img/materials/thumbsize/brndylthr.jpg)" title="Burgundy" id="l5">5</li>
            <li onclick="doMaterialClick(this)" style="background-image:url(/bindery/img/materials/thumbsize/chestnutlthr.jpg)" title="Chestnut" id="l6">6</li>
            <li onclick="doMaterialClick(this)" style="background-image:url(/bindery/img/materials/thumbsize/Chocolatelthr.jpg)" title="Chocolate" id="l7">7</li>
            <li onclick="doMaterialClick(this)" style="background-image:url(/bindery/img/materials/thumbsize/crimsonlthr.jpg)" title="Crimson" id="l8">8</li>
            <li onclick="doMaterialClick(this)" style="background-image:url(/bindery/img/materials/thumbsize/grnlthr.jpg)" title="Green" id="l9">9</li>
            <li onclick="doMaterialClick(this)" style="background-image:url(/bindery/img/materials/thumbsize/grylthr.jpg)" title="Gray" id="l10">10</li>
        </ul>-->
    </div> <!-- end of spineM (leather color thumbnails) -->
    <div id="boardsM" class="matPix">
    <p id="clothPick">Cloth color choices</p>
<!--        <ul>
            <li onclick="doMaterialClick(this)" style="background-image:url(/bindery/img/materials/thumbsize/mohred.jpg)" title="Mohair Red" id="c0">12</li>
            <li onclick="doMaterialClick(this)" style="background-image:url(/bindery/img/materials/thumbsize/olive.jpg)" title="Olive" id="c1">13</li>
            <li onclick="doMaterialClick(this)" style="background-image:url(/bindery/img/materials/thumbsize/redslub.jpg)" title="Red Slub" id="c2">14</li>
            <li onclick="doMaterialClick(this)" style="background-image:url(/bindery/img/materials/thumbsize/tan.jpg)" title="Tan" id="c3">15</li>
            <li onclick="doMaterialClick(this)" style="background-image:url(/bindery/img/materials/thumbsize/bone.jpg)" title="Bone" id="c4">1</li>
            <li class="displayed" onclick="doMaterialClick(this)" style="background-image:url(/bindery/img/materials/thumbsize/drktaupe.jpg)" title="Dark Taupe" id="c5">2</li>
            <li onclick="doMaterialClick(this)" style="background-image:url(/bindery/img/materials/thumbsize/fltblack.jpg)" title="Black" id="c6">3</li>
            <li onclick="doMaterialClick(this)" style="background-image:url(/bindery/img/materials/thumbsize/fltburg.jpg)" title="Burgundy" id="c7">4</li>
            <li onclick="doMaterialClick(this)" style="background-image:url(/bindery/img/materials/thumbsize/forestgreen.jpg)" title="Forest Green" id="c8">5</li>
            <li onclick="doMaterialClick(this)" style="background-image:url(/bindery/img/materials/thumbsize/grey.jpg)" title="Gray" id="c9">6</li>
            <li onclick="doMaterialClick(this)" style="background-image:url(/bindery/img/materials/thumbsize/grnslub.jpg)" title="Green Slub" id="c10">7</li>
        </ul>-->
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
            <label><input type="radio" name="fl1" value="journal" id="fl1_0"  checked="checked"/>Journal</label>
            <label><input type="radio" name="fl1" value="notebook" id="fl1_1" />Notebook</label>
            <label><input type="radio" name="fl1" value="stenopad" id="fl1_2" />Steno Pad</label>
        </p>
        <p id="binding">
            <label><input type="radio" name="b1" value="full" id="b1_0" />Full Leather</label>
            <label><input type="radio" name="b1" value="quarter" id="b1_1" checked="checked" /> Quarterbound</label>
        </p>
<!--        <p>&nbsp;Behavior modification<br />
            Simulate database-down condition:<br />
            <a href="materials.php?x=1">DB Failure</a><br />
            <a href="materials.php">DB OK</a>
        </p>-->
        <div id="caveat">
            <p><strong>Colors are approximate:</strong> Leather is a natural product. Every piece  has a slightly different texture and color. Additionally, every computer monitor will display slightly different colors.</p>
        </div> <!-- end caveat div -->
    </div> <!-- end fomatList div -->


</div>
<script type="text/javascript">
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
<?php 

//echo "$cloth \n\n$leather";
//print_r($_SERVER);
//print_r($leather);
?>
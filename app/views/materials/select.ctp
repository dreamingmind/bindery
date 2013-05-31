<div id="wrapper">

    <div id="spineM" class="matPix">
        <p>Leather color choices</p>
    </div> <!-- end of spineM (leather color thumbnails) -->
    <div id="boardsM" class="matPix">
    <p id="clothPick">Cloth color choices</p>
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
        <div id="caveat">
            <p><strong>Colors are approximate:</strong> Leather is a natural product. Every piece  has a slightly different texture and color. Additionally, every computer monitor will display slightly different colors.</p>
        </div> <!-- end caveat div -->
    </div> <!-- end fomatList div -->


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
</div>
<?php 

//echo "$cloth \n\n$leather";
//print_r($_SERVER);
//print_r($leather);
?>

<table  style="display:none;" cool="" gridx="16" showgridx="" usegridx="" gridy="16" showgridy="" usegridy="" border="0" cellpadding="0" cellspacing="0" height="1040" width="567">
  <tbody>
      <tr height="640">
        <td colspan="3" xpos="0" align="left" height="572" valign="top"><table border="1" cellpadding="3" cellspacing="2">
            <tbody><tr>
              <td colspan="3"><p>Goatskin<br>
                  <span class="style9">Vegetable tanned in England exclusively for use in book binding. Selected for a soft, natural finish to please both the hand and the eye. Goatskin shows a fine grain patter and is quite durable.</span></p>
              </td>
            </tr>
            <tr>
              <td>
                  <div align="center">
                      <img src="/bindery/img/materials/thumbsize/beige1.jpg" border="0" height="75" width="75"><br>
                      Beige
                  </div>
              </td>
              <td>
                  <div align="center">
                      <img src="/bindery/img/materials/thumbsize/chestnutlthr.jpg" border="0" height="75" width="75"><br>
                      Chestnut
                  </div>
              </td>
              <td>
                  <div align="center">
                      <img src="/bindery/img/materials/thumbsize/bluelthr.jpg" border="0" height="75" width="75"><br>
                      Dark Blue
                  </div>
              </td>
            </tr>
            <tr height="35">
              <td height="35" valign="top">
                  <div align="center">
                      <img src="/bindery/img/materials/thumbsize/terracottalthr.jpg" border="0" height="75"><br>
                      Terra Cotta
                  </div>
              </td>
              <td height="35" valign="top">
                  <div align="center">
                      <img src="/bindery/img/materials/thumbsize/Chocolatelthr.jpg" border="0" height="75" width="75"><br>
                      Chocolate
                  </div>
              </td>
              <td height="35" valign="top">
                  <div align="center">
                      <img src="/bindery/img/materials/thumbsize/crimsonlthr.jpg" border="0" height="75" width="75"><br>
                      Crimson
                  </div>
              </td>
            </tr>
            <tr height="35">
              <td height="35" valign="top">
                  <div align="center">
                      <img src="/bindery/img/materials/thumbsize/blklthr.jpg" border="0" height="75" width="75"><br>
                      Black
                  </div>
              </td>
              <td height="35" valign="top"><div align="center">
                      <img src="/bindery/img/materials/thumbsize/grnlthr.jpg" border="0" height="75" width="75"><br>
                      Dark Green
                  </div>
              </td>
              <td height="35" valign="top">
                  <div align="center">
                      <img src="/bindery/img/materials/thumbsize/saddlelthr.jpg" border="0" height="75" width="75"><br>
                      Saddle Tan
                  </div>
              </td>
            </tr>
            <tr height="35">
              <td height="35" valign="top">
                  <div align="center">
                      <img src="/bindery/img/materials/thumbsize/bbluelthr.jpg" border="0" height="75" width="75"><br>
                      Bright blue
                  </div>
              </td>
              <td height="35" valign="top">
                  <div align="center">
                      <img src="/bindery/img/materials/thumbsize/brndylthr.jpg" border="0" height="75" width="75"><br>
                      Burgundy
                  </div>
              </td>
              <td height="35" valign="top">
                  <div align="center">
                      <img src="/bindery/img/materials/thumbsize/grylthr.jpg" border="0" height="75" width="75"><br>
                      Gray
                  </div>
              </td>
            </tr>
            <tr height="110">
              <td height="110" valign="top">
                  <div align="center"> 
                      <img src="/bindery/img/materials/thumbsize/rchbrnlthr.jpg" border="0" height="75" width="75"><br>
                      Rich brown
                  </div>
              </td>
              <td height="110" valign="top">
                  <div align="center"> 
                      <img src="/bindery/img/materials/thumbsize/ltbllther.jpg" border="0" height="75" width="75"><br>
                      Light blue
                  </div>
              </td>
              <td height="110" valign="top"><div align="center"> </div></td>
            </tr>
        </tbody></table></td>
            <table style="display:none;"  border="1" cellpadding="3" cellspacing="2">
            <tbody><tr>
              <td colspan="3" valign="top">Book cloth<br>
              <span class="style9">The cloth I use is selected for compatibility with my other materials. Many are imported from Japan, others from Holland and Germany.</span></td>
            </tr>
            <tr height="35">
              <td height="35" valign="top"><div align="center"> <img src="/bindery/img/materials/thumbsize/tan.jpg" border="0" height="75" width="75"><br>
                      Tan</font></div></td>
              <td height="35" valign="top"><div align="center"> <img src="/bindery/img/materials/thumbsize/olive.jpg" border="0" height="75" width="75"><br>
                      Olive Green</font></div></td>
              <td height="35" valign="top"><div align="center"> <img src="/bindery/img/materials/thumbsize/mohgreen.jpg" border="0" height="75" width="75"><br>
                      Mohair green</font></div></td>
            </tr>
            <tr height="35">
              <td height="35" valign="top"><div align="center"> <img src="/bindery/img/materials/thumbsize/mohblk.jpg" border="0" height="75" width="75"><br>
                      Mohair black</font></div></td>
              <td height="35" valign="top"><div align="center"> <img src="/bindery/img/materials/thumbsize/redslub.jpg" border="0" height="75" width="75"><a href="../index.html"><br>
                  </a><font size="-1">

                  Red slub</font></div></td>
              <td height="35" valign="top"><div align="center"> <a href="../index.html"><img src="/bindery/img/materials/thumbsize/ribbedchoc.jpg" border="0" height="75" width="75"><br>
                  </a><font size="-1">
                  Ribbed chocolate</font></div></td>
            </tr>
            <tr height="35">
              <td height="35" valign="top"><div align="center"> <img src="/bindery/img/materials/thumbsize/fltburg.jpg" border="0" height="75" width="75"><br>
                      Burgundy</font></div></td>
              <td height="35" valign="top"><div align="center"> <img src="/bindery/img/materials/thumbsize/forestgreen.jpg" border="0" height="75" width="75"><br>
                      Forest green</font></div></td>
              <td height="35" valign="top"><div align="center"> <img src="/bindery/img/materials/thumbsize/mohblue.jpg" border="0" height="75" width="75"><br>
                      Mohair blue</font></div></td>
            </tr>
            <tr>
              <td><div align="center"> <img src="/bindery/img/materials/thumbsize/mohred.jpg" border="0" height="75" width="75"><br>
                      <a href="../index.html"><img src="../images/hssymbol.gif" border="0" height="16" width="19"></a><font size="-1">
                      Mohair red</font></div></td>
              <td valign="top"><div align="center"><img src="/bindery/img/materials/thumbsize/blkslb2.jpg" border="0" height="75" width="75"><br>
                      <font size="-1">
                Black slub</font></div></td>
              <td><div align="center"> <img src="/bindery/img/materials/thumbsize/mohbrwn.jpg" border="0" height="75" width="75"><br>
                      <font size="-1">
                Mohair brown</font></div></td>
            </tr>
            <tr height="35">
              <td height="35" valign="top"><div align="center"> <img src="/bindery/img/materials/thumbsize/drktaupe.jpg" border="0" height="75" width="75"><br>
                      <font size="-1">
                Dark taupe</font></div></td>
              <td height="35" valign="top"><div align="center"> <img src="/bindery/img/materials/thumbsize/grnslub.jpg" border="0" height="75" width="75"><br>
                      <font size="-1">
                Green slub</font></div></td>
              <td height="35" valign="top"><div align="center">
              <img src="/bindery/img/materials/thumbsize/grey.jpg" border="0" height="75" width="75"><font size="-1">Gray</font></div></td>
            </tr>
        </tbody></table>
  <table style="display:none;" >
        <td height="572" width="1"><spacer type="block" width="1" height="640"></spacer></td>
      </tr>
      <tr height="368">
        <td colspan="3" xpos="0" align="left" height="368" valign="top"><table border="1" cellpadding="3" cellspacing="2" width="297">
            <tbody><tr>
              <td colspan="3" valign="top">Imitation leather<br>
              <span class="style9">These very durable materials are typically used for very large clamshell boxes that must travel and tolerate abuse. </span></td>
            </tr>
            <tr>
              <td height="117" valign="top" width="81"><div align="center"> <img src="/bindery/img/materials/thumbsize/imred2.jpg" border="0" height="75" width="75"><font size="-1">Red</font></div></td>
              <td valign="top" width="81"><div align="center"> <img src="/bindery/img/materials/thumbsize/imbrn2.jpg" border="0" height="75" width="75"><font size="-1">Brown</font></div></td>
              <td valign="top" width="101"><div align="center"> <img src="/bindery/img/materials/thumbsize/imblk.jpg" border="0" height="75" width="75"><br>
                      <font size="-1">Black</font></div></td>
            </tr>
        </tbody></table></td>
        <td height="368" width="1"><spacer type="block" width="1" height="368"></spacer></td>
      </tr>
      <tr cntrlrow="" height="1">
       </tr>
    </tbody></table>
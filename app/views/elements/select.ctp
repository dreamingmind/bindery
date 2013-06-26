<div id="wrapper" style="display: none">

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
<!--<div id="tables">
<table border="1" cellpadding="3" cellspacing="2">
    <tbody>
        <tr>
          <td colspan="3"><p>Goatskin<br />
              <span class="style9">Vegetable tanned in England exclusively for use in book binding. Selected for a soft, natural finish to please both the hand and the eye. Goatskin shows a fine grain patter and is quite durable.</span></p>
          </td>
        </tr>
        <?php
//        $path = 'materials/thumbsize/';
//        $leatherList = array_chunk(json_decode($leather), 3);
//        foreach($leatherList as $row){
//            echo '<tr>';
//            foreach($row as $swatch){
//                echo'<td>'.$this->Html->image($path.$swatch->fn.'.jpg').'<br />'.$swatch->ti.'</td>';
//            }
//            echo '</tr>';
//        }
        ?>
    </tbody>
</table>

<table border="1" cellpadding="3" cellspacing="2">
    <tbody>
        <tr>
          <td colspan="3"><p>Book Cloth<br />
              <span class="style9">The cloth I use is selected for compatibility with my other materials. Many are imported from Japan, others from Holland and Germany.</span></p>
          </td>
        </tr>
        <?php
//        $path = 'materials/thumbsize/';
//        $clothList = array_chunk(json_decode($cloth), 3);
//        foreach($clothList as $row){
//            echo '<tr>';
//            foreach($row as $swatch){
//                echo'<td>'.$this->Html->image($path.$swatch->fn.'.jpg').'<br />'.$swatch->ti.'</td>';
//            }
//            echo '</tr>';
//        }
        ?>
    </tbody>
</table>


<table border="1" cellpadding="3" cellspacing="2">
    <tbody>
        <tr>
          <td colspan="3"><p>Imitation Leather<br />
              <span class="style9">These very durable materials are typically used for very large clamshell boxes that must travel and tolerate abuse.</span></p>
          </td>
        </tr>
        <?php
//        $path = 'materials/thumbsize/';
//        $imitationList = array_chunk(json_decode($imitation), 3);
//        foreach($imitationList as $row){
//            echo '<tr>';
//            foreach($row as $swatch){
//                echo'<td>'.$this->Html->image($path.$swatch->fn.'.jpg').'<br />'.$swatch->ti.'</td>';
//            }
//            echo '</tr>';
//        }
        ?>
    </tbody>
</table>
</div>-->
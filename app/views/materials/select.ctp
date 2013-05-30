<div id="wrapper">

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
            Simulate database-down condition:<br />
            <a href="materials.php?x=1">DB Failure</a><br />
            <a href="materials.php">DB OK</a>
        </p>
    </div> <!-- end fomatList div -->

    <div id="caveat">
            <p><strong>Colors are approximate:</strong> Leather is a natural product. Every piece  has a slightly different texture and color. Additionally, every computer monitor will display slightly different colors.</p>
    </div> <!-- end caveat div -->

</div>
<?php 
//echo "$cloth \n\n$leather";
//print_r($_SERVER);
//print_r($leather);
?>
<?php 
//if (6==9) {
?>
<div id='cmdm_time_toggle'></div>
<iframe id='cmdm_time_frame' src='http://localhost/time/'></iframe>

<style type="text/css">
/*<![CDATA[*/
	div#cmdm_time_toggle {position: fixed; top: 0px; left: 0px; z-index: 1000000; display: inline-block; width: 17px; height: 15px;  background-image: url('http://localhost/time/img/logomark.jpg'); vertical-align: top;}
	iframe#cmdm_time_frame {position: fixed; top: 0px; left: 18px; z-index: 1000000; border: none; width: 98%; height: 50%; display: none; background-color: white;}
/*]]>*/
</style>

<script type="text/javascript">
//<![CDATA[
// definition phase
document.getElementById('cmdm_time_toggle').display = 'none';
function cmdm_time_toggle() {document.getElementById("cmdm_time_toggle").onclick = function(e){
		this.display = this.display == 'none' ? 'inline-block' : 'none'; 
		document.getElementById('cmdm_time_frame').style = 'display: '+this.display;	}}
// initialization phase
cmdm_time_toggle();
//]]>
</script>
<?php 
//}
?>

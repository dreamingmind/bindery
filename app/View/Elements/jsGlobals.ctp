<?php
	// Javascript often needs to construct a path but doesn't have access to needed
	// environmental or contextual values. Global vars here can fix that.
	echo "<script type=\"text/javascript\">
	//<![CDATA[
	// global data for javascript\r";
	echo $this->fetch('jsGlobalVars');
	
	echo "var webroot = '{$this->request->webroot}';\r";
	echo "var action = '{$this->request->params['action']}/';\r";
	echo "var controller = '{$this->request->params['controller']}/';\r";
	echo "var imagePath = '{$this->request->webroot}app/webroot/img/';\r";	
	
	echo "\r//]]>
	</script>";
?>
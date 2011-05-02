<?php
    $this->TreeCrud->renameForm();
    echo "<!-- RENAME FUNCTION -->\n";
    echo $this->TreeCrud->renameFormStart;
    if(isset($rename_inputs)){
        echo $rename_inputs;
    }
    echo $this->TreeCrud->renameFormEnd;
?>

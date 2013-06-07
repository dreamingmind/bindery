<?php
//$table = new TableParser($product);
$this->TableParser->initialize($product);
echo '<table>';
echo $this->TableParser->xxRow();
echo $this->TableParser->xRow();
foreach($this->TableParser->productChunks as $rowNumber => $chunk){
    echo $this->TableParser->yRow($rowNumber);
}

echo '</table>';
    debug($this->TableParser->xxAttributes);
    debug($this->TableParser->yyAttributes);
    debug($this->TableParser->xxExists ? 'true' : 'false');
    debug($this->TableParser->yyExists ? 'true' : 'false');
    debug($this->TableParser->xxHeaders);
    debug($this->TableParser->xHeaders);
    debug($this->TableParser->xClass);
    debug($this->TableParser->columnCount);
    debug($this->TableParser->yyHeaders);
    debug($this->TableParser->yHeaders);
    debug($this->TableParser->yClass);
    debug($this->TableParser->rowCount);
?>
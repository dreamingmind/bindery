<?php
/**
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @copyright     Copyright 2010, Dreaming Mind (http://dreamingmind.com)
 * @link          http://dreamingmind.com
 * @package       bindery
 * @subpackage    bindery.Output
 */

/**
 * TableParser is a Class in an Element to manage product purchase tables
 * 
 * @package       bindery
 * @subpackage    bindery.Output
 */
class TableParserHelper extends AppHelper {
    
    /**
     *
     * @var object The Html Helper
     */
    var $Html = false;
    
    /**
     *
     * @var object The Inflector Helper
     */
    var $Inflector = false;
    
    /**
     *
     * @var array $the product purchase table data
     */
    var $productData = false;
    
    /**
     * The table data chunked to one sub-array per row
     *
     * @var array $the product purchase table data
     */
    var $productChunks = false;
    
    /**
     *
     * @var array The header labels for xx level cells
     */
    var $xxHeaders = array();
    
    var $xxAttributes = array();
    
    /**
     *
     * @var array The header labels for x level cells
     */
    var $xHeaders = array();
    
    /**
     *
     * @var array The header labels for yy level cells
     */
    var $yyHeaders = array();
    
    var $yyAttributes = array();
    
    /**
     *
     * @var array The header labels for y level cells
     */
    var $yHeaders = array();
    
    /**
     *
     * @var array The class slugs for the columns
     */
    var $xClass = array();
    
    /**
     *
     * @var array The class slugs for the rows
     */
    var $yClass = array();
    
    /**
     *
     * @var integer Number of columns in the product purchase table starting from 1
     */
    var $columnCount = false;
    
    /**
     *
     * @var integer Number of rows in the chunked product purchase table starting from 1
     */
    var $rowCount = false;
    
    /**
     *
     * @var boolean Indicate if xxHeaders are in use
     */
    var $xxExists = false;
    
    /**
     *
     * @var boolean Indicate if yyHeaders are in use
     */
    var $yyExists = false;
    
    function initialize($products) {
        $this->setData($products);
        $this->initXHeaders();
        $this->setChunkData();
        $this->initYHeaders();
        $this->Number = new NumberHelper();
    }
    
    /**
     * Bring the data into thte class for processing
     * 
     * @param array $data The product purchase table data
     */
    public function setData($data){
        $this->productData = $data;
    }
    
    /**
     * Chunk the product table into rows and set the row count
     */
    public function setChunkData(){
        $this->productChunks = array_chunk($this->productData, $this->columnCount);
        $this->rowCount = count($this->productChunks);
    }
    
    public function initXHeaders(){
        $count = 0;
        $this->evalColumn($count);
        $count++;
        while($this->xClass[0] != $this->evalColumn($count)){
            $count++;
        }
        unset($this->xxHeaders[$count]);
        unset($this->xHeaders[$count]);
        unset($this->xClass[$count]);
        $this->columnCount = $count;
        $this->xxExists = (implode('', $this->xxHeaders) == '') ? false : true;
        $this->setXXAttributes();
        $this->setXXHeaders();
    }
    
    private function setXXAttributes(){
        if ($this->xxExists) {
            $this->xxAttributes = array_flip($this->xxHeaders);
            $oldCount = 0;
            foreach ($this->xxAttributes as $xxHeader => $count) {
                debug("header: $xxHeader count: $count oldCount: $oldCount");
                $this->xxAttributes[$xxHeader] = array(
                    'colspan' => ($count + 1 - $oldCount),
                    'class' => Inflector::slug($xxHeader)
                );
                $oldCount = $this->xxAttributes[$xxHeader]['colspan'];
            }
        }        
    }
    
    private function setXXHeaders(){
        if ($this->xxExists) {
            $baseHeader = '';
            foreach ($this->xxHeaders as $index => $header) {
                if($header == $baseHeader){
                    $this->xxHeaders[$index] = false;
                } else {
                    $baseHeader = $header;
                }
            }
        }
    }
    
    /**
     * Given one record, set its column header and column class properties
     * 
     * @param integer $count The column/record being operated on
     * @return string The class slug that was created for this column
     */
    private function evalColumn($count){
        $this->setXXHeader($count);
        $this->setXHeader($count);
        $this->setXClass($count);
        return $this->xClass[$count];
    }
    
    /**
     * Set the top-most column headers display value for product record $count
     * 
     * @param integer $count The column/record being operated on
     */
    private function setXXHeader($count){
        $this->xxHeaders[$count] = (empty($this->productData[$count]['catalogs']['xx_index'])) ? false : $this->productData[$count]['catalogs']['xx_index'];
    }
    
    /**
     * Set the second column headers display value for product record $count
     * 
     * @param integer $count The column/record being operated on
     */
    private function setXHeader($count){
        $this->xHeaders[$count] = $this->productData[$count]['catalogs']['x_index'];
    }
    
    /**
     * Set the column class value for product record $count
     * 
     * @param integer $count The column/record being operated on
     */
    private function setXClass($count){
        $this->xClass[$count] = 
            (($this->xxHeaders[$count]) ? ' ' . Inflector::slug($this->xxHeaders[$count]) : null) 
            . ' ' . Inflector::slug($this->xHeaders[$count]);
    }

    /**
     * Set all row headers and row class properties
     * 
     */
    public function initYHeaders(){
        $count = 0;
        while($count < count($this->productChunks)){
            $this->setYYHeader($count);
            $this->setYHeader($count);
            $this->setYClass($count);
            $count++;
        }
        $this->yyExists = (implode('', $this->yyHeaders) == '') ? false : true;
        $this->setYYAttributes();
        $this->setYYHeaders();
    }
    
    private function setYYAttributes(){
        if ($this->yyExists) {
            $this->yyAttributes = array_flip($this->yyHeaders);
            $oldCount = 0;
            foreach ($this->yyAttributes as $yyHeader => $count) {
                $this->yyAttributes[$yyHeader] = array(
                    'rowspan' => $count + 1 - $oldCount,
                    'class' => Inflector::slug($yyHeader)
                );
                $oldCount = $this->yyAttributes[$yyHeader]['rowspan'];
            }
        }        
    }
    
    private function setYYHeaders(){
        if ($this->yyExists) {
            $baseHeader = '';
            foreach ($this->yyHeaders as $index => $header) {
                if($header == $baseHeader){
                    $this->yyHeaders[$index] = false;
                } else {
                    $baseHeader = $header;
                }
            }
        }
    }
    
    /**
     * Set the left-most row headers display value for product record $count
     * 
     * @param integer $count The column/record being operated on
     */
    private function setYYHeader($count){
        $this->yyHeaders[$count] = (empty($this->productChunks[$count][0]['catalogs']['yy_index'])) ? false : $this->productChunks[$count][0]['catalogs']['yy_index'];
    }
    
    /**
     * Set the second row headers display value for product record $count
     * 
     * @param integer $count The column/record being operated on
     */
    private function setYHeader($count){
        $this->yHeaders[$count] = $this->productChunks[$count][0]['catalogs']['y_index'];
    }
    
    /**
     * Set the row class value for product record $count
     * 
     * @param integer $count The column/record being operated on
     */
    private function setYClass($count){
        $this->yClass[$count] = 
            (($this->yyHeaders[$count]) ? ' '. Inflector::slug($this->yyHeaders[$count]) : null)
            . ' ' . Inflector::slug($this->yHeaders[$count]);
    }
    
    /**
     * @return array One or two elements for xx or x row fillers above yy and y label columns
     */
    private function cornerCells(){
        if ($this->yyExists) {
        $row = array(-2=>'', -1=>'');
        } else {
        $row = array(-1=>'');
        }
        return $row;
    }


    /**
     * Return the xx row or nothing
     * 
     * @param array $trOptions TR tag options
     * @param array $thOptions TH tag options
     * @return string The Html for the xx row
     */
    public function xxRow($trOptions = null, $thOptions = null){
        if ($this->xxExists) {
            return $this->Html->tableHeaders($this->cornerCells() + $this->xxHeaders, $trOptions, array(
                'class'=>$this->xClass
            ));
        }
    }
        
    /**
     * Return the x row
     * 
     * @param array $trOptions TR tag options
     * @param array $thOptions TH tag options
     * @return string The Html for the x row
     */
    public function xRow($trOptions = null, $thOptions = null){
        return $this->Html->tableHeaders($this->cornerCells() + $this->xHeaders, $trOptions, $thOptions);
    }
    
    public function yRow($count){
        if($this->yyExists){
            $headerCells = array($this->yyHeaders[$count], $this->yHeaders[$count]);
        } else {
            $headerCells = array($this->yHeaders[$count]);
        }
        $headers = str_replace('</tr>','',$this->Html->tableHeaders($headerCells));
        $productCells = array();
        foreach($this->productChunks[$count] as $product){
//            debug($product);
            $productCells[] = 
                $this->Number->currency($product['catalogs']['price'], 'USD', array('places'=>0))
                . " <span>({$product['catalogs']['product_code']})</span>";
        }
        $cells = str_replace('<tr>','',$this->Html->tableCells($productCells));
        return $headers.$cells;
    }
        
} // end of class definition
?>
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

    /**
     *
     * @var integer Number of y Header columns, 1 or 2
     */
    var $yColumnCount = 1;
    var $tableName = null;

    function initialize($products, $tableName, $setList) {
        $this->setData($products, $tableName, $setList);
        $this->initXHeaders();
        $this->setChunkData();
        $this->initYHeaders();
        $this->setYColumnCount();
        $this->Number = new NumberHelper();
//        $this->setCheckboxes();
    }

    private function setYColumnCount() {
        $this->yColumnCount = $this->yyExists ? 2 : 1;
    }

    public function setCheckboxes() {
        $xx = $yy = array();
        foreach ($this->xxHeaders as $header) {
            if (is_string($header)) {
                $xx[] = $header;
            }
        }
        foreach ($this->yyHeaders as $header) {
            if (is_string($header)) {
                $yy[] = $header;
            }
        }
        $checkboxes = (($this->xyCheckbox($yy) . $this->xyCheckbox($xx) != '') ? $this->Html->div('filters', $this->xyCheckbox($yy) . '&nbsp;| ' . $this->xyCheckbox($xx)) : '')
                . $this->Html->div('filters', $this->xyCheckbox($this->yHeaders) . ' &nbsp;| ' . $this->xyCheckbox($this->xHeaders));

        return '<tr><td colspan = "' . (count($this->productChunks[0]) + $this->yColumnCount) . '">' . $checkboxes . '</td></tr>';
    }

    private function xyCheckbox($data) {
        if (!empty($data)) {
            $headers = array_flip($data);
            foreach ($headers as $header => $junk) {
                $slug = Inflector::slug($header);
                $check[] = $this->Form->input($slug, array('label' => $header, 'type' => 'checkbox', 'value' => $slug, 'category' => $this->tableName));
            }
//            return $this->Html->div('filters', implode(' ', $check) . ' ');
            return implode(' ', $check) . ' ';
        }
    }

    /**
     * Bring the data into thte class for processing
     * 
     * @param array $data The product purchase table data
     */
    public function setData($data, $tableName, $setList) {
        $this->productData = $data;
        $this->tableName = $tableName;
        $this->setList = $setList;
    }

    /**
     * Chunk the product table into rows and set the row count
     */
    public function setChunkData() {
        $this->productChunks = array_chunk($this->productData, $this->columnCount);
        $this->rowCount = count($this->productChunks);
    }

    public function initXHeaders() {
        $count = 0;
        $this->evalColumn($count);
        $count++;
        while ($this->xClass[0] != $this->evalColumn($count)) {
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

    private function setXXAttributes() {
        if ($this->xxExists) {
            $this->xxAttributes = array_flip($this->xxHeaders);
            $oldCount = 0;
            foreach ($this->xxAttributes as $xxHeader => $count) {
                $this->xxAttributes[$xxHeader] = array(
                    'colspan' => ($count + 1 - $oldCount),
                    'class' => Inflector::slug($xxHeader) . ' xx ' //. $this->tableName
                );
                $oldCount = $this->xxAttributes[$xxHeader]['colspan'];
            }
        }
    }

    private function setXXHeaders() {
        if ($this->xxExists) {
            $baseHeader = '';
            foreach ($this->xxHeaders as $index => $header) {
                if ($header == $baseHeader) {
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
    private function evalColumn($count) {
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
    private function setXXHeader($count) {
        $this->xxHeaders[$count] = (empty($this->productData[$count]['xx_index'])) ? false : $this->productData[$count]['xx_index'];
    }

    /**
     * Set the second column headers display value for product record $count
     * 
     * @param integer $count The column/record being operated on
     */
    private function setXHeader($count) {
        $this->xHeaders[$count] = $this->productData[$count]['x_index'];
    }

    /**
     * Set the column class value for product record $count
     * 
     * @param integer $count The column/record being operated on
     */
    private function setXClass($count) {
        $this->xClass[$count] =
                (($this->xxHeaders[$count]) ? ' ' . Inflector::slug($this->xxHeaders[$count]) : null)
                . ' ' . Inflector::slug($this->xHeaders[$count]);
    }

    /**
     * Set all row headers and row class properties
     * 
     */
    public function initYHeaders() {
        $count = 0;
        while ($count < count($this->productChunks)) {
            $this->setYYHeader($count);
            $this->setYHeader($count);
            $this->setYClass($count);
            $count++;
        }
        $this->yyExists = (implode('', $this->yyHeaders) == '') ? false : true;
        $this->setYYAttributes();
        $this->setYYHeaders();
    }

    private function setYYAttributes() {
        if ($this->yyExists) {
            $this->yyAttributes = array_flip($this->yyHeaders);
            $oldCount = 0;
            foreach ($this->yyAttributes as $yyHeader => $count) {
                $this->yyAttributes[$yyHeader] = array(
                    'rowspan' => $count + 1 - $oldCount,
                    'class' => Inflector::slug($yyHeader) . ' yy ' //. $this->tableName
                );
                $oldCount = $this->yyAttributes[$yyHeader]['rowspan'];
            }
        }
    }

    private function setYYHeaders() {
        if ($this->yyExists) {
            $baseHeader = '';
            foreach ($this->yyHeaders as $index => $header) {
                if ($header == $baseHeader) {
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
    private function setYYHeader($count) {
        $this->yyHeaders[$count] = (empty($this->productChunks[$count][0]['yy_index'])) ? false : $this->productChunks[$count][0]['yy_index'];
    }

    /**
     * Set the second row headers display value for product record $count
     * 
     * @param integer $count The column/record being operated on
     */
    private function setYHeader($count) {
        $this->yHeaders[$count] = $this->productChunks[$count][0]['y_index'];
    }

    /**
     * Set the row class value for product record $count
     * 
     * @param integer $count The column/record being operated on
     */
    private function setYClass($count) {
        $this->yClass[$count] =
                (($this->yyHeaders[$count]) ? ' ' . Inflector::slug($this->yyHeaders[$count]) : null)
                . ' ' . Inflector::slug($this->yHeaders[$count]);
    }

    /**
     * @return array One or two elements for xx or x row fillers above yy and y label columns
     */
    private function cornerCells() {
        if ($this->yyExists) {
            $row = array(-2 => '', -1 => '');
        } else {
            $row = array(-1 => '');
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
    public function xxRow($trOptions = null, $thOptions = null) {
        if ($this->xxExists) {
//            $cells = $this->cornerCells();
            foreach ($this->xxHeaders as $header) {
                if (!empty($header)) {
                    $cells[] = array($header, $this->xxAttributes[$header]);
                }
            }
            return $this->Html->table_Headers(array($this->cornerCells() + $cells));
        }
    }

    /**
     * Return the x row
     * 
     * @param array $trOptions TR tag options
     * @param array $thOptions TH tag options
     * @return string The Html for the x row
     */
    public function xRow($trOptions = null, $thOptions = null) {
        foreach ($this->xHeaders as $index => $header) {
            $cells[] = array($header, array('class' => 'x ' . $this->xClass[$index] . ' ' . $this->tableName));
        }
        return $this->Html->table_Headers(array($this->cornerCells() + $cells));
    }

    public function yRow($count) {
        if ($this->yyExists && !empty($this->yyHeaders[$count])) {
            $headerCells = array(array(
                    array($this->yyHeaders[$count], $this->yyAttributes[$this->yyHeaders[$count]]),
                    array($this->yHeaders[$count], array('class' => 'y ' . $this->yClass[$count] . ' ' . $this->tableName))
                    ));
        } else {
            $headerCells = array(array(array($this->yHeaders[$count], array('class' => 'y ' . $this->yClass[$count] . ' ' . $this->tableName))));
        }
//            debug($headerCells);
        $headers = str_replace('<th></th>', '', str_replace('</tr>', '', $this->Html->table_Headers($headerCells)));
//        $headers = str_replace('</tr>','',$this->Html->table_Headers($headerCells));
        $productCells = array();
        foreach ($this->productChunks[$count] as $index => $product) {
//            debug($product);
            if ($product['product_code']) {
                $productCells[] = $this->productRadio($product, $count, $index);
            } else {
                $productCells[] = null;
            }
        }
        $cells = str_replace('<tr>', '', $this->Html->tableCells(array($productCells)));
//        debug($headers);
//        $headers = str_replace('<tr class="'.$this->tableName.'"', '<tr class="'.$this->tableName.'Toggle"', $headers);
        return $headers . $cells;
    }

    public function tableHeading() {
        echo '<tr class="table"><td class="table_name" id ="' . $this->tableName . '" colspan = "' . (count($this->productChunks[0]) + $this->yColumnCount) . '">' . $this->tableName . '</td></tr>';
    }

    /**
     * Return a radio button input for the roduct
     * 
     */
    private function productRadio($product, $count, $index) {
//        debug($product);
//        die;
        return array(
        $this->Number->currency($product['price'], 'USD', array('places' => 0))
        . " <span>({$product['product_code']})</span>", array(
        'class' => $this->tableName . ' ' . $this->yClass[$count] . $this->xClass[$index],
        'option' => "master-{$this->tableName}",
        'setlist' => str_replace('_', '', $this->setList . ' ' .$this->yClass[$count] . $this->xClass[$index])// 
        ));
    }

}

// end of class definition
?>
    <?php
    $product = array_keys($data);
foreach ($data[$product[0]] as $key => $value) {
    echo $this->Html->para(null, "$key: $value");
}
?>
<?php 
echo $this->Html->css('search_links');
echo $this->Html->tag('h1','Upcoming workshops');
echo '<ul>';
foreach ($upcoming as $workshop) {
//debug ($workshop);
      echo $html->foundWorkshopBlock($workshop);
}
echo '</ul>';

echo $this->Html->tag('h1','Potential workshops');
echo '<ul>';
foreach ($potential as $workshop) {
      echo $html->foundWorkshopBlock($workshop);
}
echo '</ul>';

echo $this->Html->tag('h1','Current workshops');
echo '<ul>';
foreach ($now as $workshop) {
      echo $html->foundWorkshopBlock($workshop);
}
echo '</ul>';
?>
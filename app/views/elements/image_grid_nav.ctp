<?php /* @var $this ViewCC */ ?> 
<?php
if ($this->params['controller']=='images'){
// Assemble the Upload process links
$lastUploadLink = ($lastUpload)
    ? $this->Html->link('Last Upload Set', 
        array('controller'=>'images', 'action'=>'search', $lastUpload))
    : "Last Upload Unavailable";

$orphansLink = ($orphans)
    ? ' | '. $this->Html->link(count($orphans). ' Orphan images', 
        array('controller'=>'images', 'action'=> 'search', 'orphan_images'))
    : null;

$duplicateLink = ($duplicate)
    ? ' | ' . $this->Html->link(count($duplicate)." Duplicates", 
        array('controller'=>'images', 'action'=>'duplicate_uploads'))
    : null;

$disallowedLink = ($disallowed)
    ? ' | ' . $this->Html->link(count($disallowed)." Disallowed", 
        array('controller'=>'images', 'action'=>'multi_add'))
    :null;

$newLink = ($new)
    ?' | ' . $this->Html->link(count($new)." New", 
        array('controller'=>'images', 'action'=>'new_uploads'))
    : null;

echo $this->Html->div('uploadLinks', $this->Html->para(NULL, $lastUploadLink.$orphansLink.$duplicateLink.$disallowedLink.$newLink));
}
echo '';
?>

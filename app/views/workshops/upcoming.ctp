<?php

//Display the featured workshop using the workshopFeature element

echo $this->element('workshopFeature');

//  Two column bottom half of screen
//  Could present upcoming and potential workshops, if no upcoming, present two columns of potential

if ($upcoming) {
    $leftheading = 'Upcoming Workshops';
    $rightheading = 'Potential Workshops';
    $potentialcontent[0] = $upcoming;
    $potentialcontent[1] = $potential;
} else {
    $leftheading = 'Potential Workshops';
    $rightheading = 'Potential Workshops con\'t';
    $potentiallength = intval(count($potential) / 2) + 1;
    $potentialcontent = array_chunk($potential, $potentiallength, $preserve_keys = true);
}
echo '<div class="Col2Left">';
echo $this->Html->tag('h1', $leftheading);
foreach ($potentialcontent[0] as $workshop) {
    echo $html->foundWorkshopBlock($this->viewVars, $workshop);
}
echo '</div>';

echo '<div class="Col2Right">';
echo $this->Html->tag('h1', $rightheading);
foreach ($potentialcontent[1] as $workshop) {
    echo $html->foundWorkshopBlock($this->viewVars, $workshop);
}
echo '</div>';
?>
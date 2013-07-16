<?php

///**
// * This section determines which workshop to feature
// */
////  If there is a current workshop, use it
//if ($now) {
//    $feature = $now;
////  Else, pick off the first upcoming workshop and remove it from the array
//} elseif ($upcoming) {
//    $feature = array_shift($upcoming);
////  Else, choose a random potential workshop and remove if from the array
//} else {
//    $featurekey = array_rand($potential);
//    $feature = $potential[$featurekey];
//    unset($potential[$featurekey]);
//}
//debug($upcoming);
//debug(array_keys($featured));
echo $this->element('workshopFeature');

//  Two column bottom half of screen
//  Could present upcoming and potential workshops, if no upcoming, present two columns of potential
//
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

//debug($userdata);
?>
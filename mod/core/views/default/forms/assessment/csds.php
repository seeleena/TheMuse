<?php

$allHeadings = array();
$allCriteria = array();

$heading = new stdClass();
$heading->ID = "H1";
$heading->desc = "Relevance & Effectiveness - Knowledge of existing facts and principles.";
$heading->weight = "";
$allHeadings[] = $heading;

$heading = new stdClass();
$heading->ID = "H2";
$heading->desc = "Problematization - Solution draws attention to problems in what already exists.";
$heading->weight = "";
$allHeadings[] = $heading;

$heading = new stdClass();
$heading->ID = "H2";
$heading->desc = "Propulsion - Solution propels the field including, the known is seen in a new way, transferred to a new setting, extended in a new direction or new approach.";
$heading->weight = "";
$allHeadings[] = $heading;

$heading = new stdClass();
$heading->ID = "H2";
$heading->desc = "Elegance - Solution is tasteful and aesthetic in its simplicity.";
$heading->weight = "";
$allHeadings[] = $heading;

$heading = new stdClass();
$heading->ID = "H2";
$heading->desc = "Genesis - Ideas in the solution go beyond the immediate situation.";
$heading->weight = "";
$allHeadings[] = $heading;

$header1Criteria = array();

$criteria = new stdClass();
$criteria->ID = "c1";
$criteria->desc = "PERFORMANCE (the solution does what it is supposed to do)";
$criteria->Hid = "H1";
$criteria->weight = "";
$criteria->score = "";
$header1Criteria[] = $criteria;

$criteria = new stdClass();
$criteria->ID = "c2";
$criteria->desc = "APPROPRIATENESS (the solution fits within task constraints)";
$criteria->Hid = "H1";
$criteria->weight = "";
$criteria->score = "";
$header1Criteria[] = $criteria;

$criteria = new stdClass();
$criteria->ID = "c3";
$criteria->desc = "CORRECTNESS (the solution accurately reflects conventional knowledge and/or techniques)";
$criteria->Hid = "H1";
$criteria->weight = "";
$criteria->score = "";
$header1Criteria[] = $criteria;

$allCriteria["H1"] = $header1Criteria;

$header2Criteria = array();

$criteria = new stdClass();
$criteria->ID = "c4";
$criteria->desc = "PRESCRIPTION (the solution shows how existing solutions could be improved)";
$criteria->Hid = "H2";
$criteria->weight = "";
$criteria->score = "";
$header2Criteria[] = $criteria;

$criteria = new stdClass();
$criteria->ID = "c5";
$criteria->desc = "PROGNOSIS (the solution helps the beholder to anticipate likely effects of changes)";
$criteria->Hid = "H2";
$criteria->weight = "";
$criteria->score = "";
$header2Criteria[] = $criteria;

$criteria = new stdClass();
$criteria->ID = "c6";
$criteria->desc = "DIAGNOSIS (the solution draws attention to shortcomings in other existing solutions)";
$criteria->Hid = "H2";
$criteria->weight = "";
$criteria->score = "";
$header2Criteria[] = $criteria;
$allCriteria["H2"] = $header2Criteria;

$header3Criteria = array();

$criteria = new stdClass();
$criteria->ID = "c7";
$criteria->desc = "REDEFINITION (the solution helps the beholder see new and different ways of using the solution)";
$criteria->Hid = "H3";
$criteria->weight = "";
$criteria->score = "";
$header3Criteria[] = $criteria;

$criteria = new stdClass();
$criteria->ID = "c8";
$criteria->desc = "REINITIATION (the solution indicates a radically new approach)";
$criteria->Hid = "H3";
$criteria->weight = "";
$criteria->score = "";
$header3Criteria[] = $criteria;

$criteria = new stdClass();
$criteria->ID = "c9";
$criteria->desc = "GENERATION (the solution offers a fundamentally new perspective on possible solutions)";
$criteria->Hid = "H3";
$criteria->weight = "";
$criteria->score = "";
$header3Criteria[] = $criteria;

$criteria = new stdClass();
$criteria->ID = "c10";
$criteria->desc = "REDIRECTION (the solution shows how to extend the known in a new direction)";
$criteria->Hid = "H3";
$criteria->weight = "";
$criteria->score = "";
$header3Criteria[] = $criteria;

$criteria = new stdClass();
$criteria->ID = "c11";
$criteria->desc = "COMBINATION (the solution makes use of new mixture(s) of existing elements)";
$criteria->Hid = "H3";
$criteria->weight = "";
$criteria->score = "";
$header3Criteria[] = $criteria;
$allCriteria["H3"] = $header3Criteria;

$header4Criteria = array();

$criteria = new stdClass();
$criteria->ID = "c12";
$criteria->desc = "PLEASINGNESS (the beholder finds the solution neat, well done)";
$criteria->Hid = "H4";
$criteria->weight = "";
$criteria->score = "";
$header4Criteria[] = $criteria;

$criteria = new stdClass();
$criteria->ID = "c13";
$criteria->desc = "COMPLETENESS (the solution is well worked out and rounded)";
$criteria->Hid = "H4";
$criteria->weight = "";
$criteria->score = "";
$header4Criteria[] = $criteria;

$criteria = new stdClass();
$criteria->ID = "c14";
$criteria->desc = "SUSTAINABILITY (the solution is environmentally friendly)";
$criteria->Hid = "H4";
$criteria->weight = "";
$criteria->score = "";
$header4Criteria[] = $criteria;

$criteria = new stdClass();
$criteria->ID = "c15";
$criteria->desc = "GRACEFULNESS (the solution well-proportioned, nicely formed)";
$criteria->Hid = "H4";
$criteria->weight = "";
$criteria->score = "";
$header4Criteria[] = $criteria;

$criteria = new stdClass();
$criteria->ID = "c16";
$criteria->desc = "CONVINCINGNESS (the beholder sees the solution as skillfully executed, well-finished)";
$criteria->Hid = "H4";
$criteria->weight = "";
$criteria->score = "";
$header4Criteria[] = $criteria;

$criteria = new stdClass();
$criteria->ID = "c17";
$criteria->desc = "HARMONIOUSNESS (the elements of the solution fit together in a consistent way)";
$criteria->Hid = "H4";
$criteria->weight = "";
$criteria->score = "";
$header4Criteria[] = $criteria;

$criteria = new stdClass();
$criteria->ID = "c18";
$criteria->desc = "SAFETY (the solution is safe to use)";
$criteria->Hid = "H4";
$criteria->weight = "";
$criteria->score = "";
$header4Criteria[] = $criteria;
$allCriteria["H4"] = $header4Criteria;

$header5Criteria = array();

$criteria = new stdClass();
$criteria->ID = "c19";
$criteria->desc = "VISION (the solution suggests new norms for judging other solutions-existing or new)";
$criteria->Hid = "H5";
$criteria->weight = "";
$criteria->score = "";
$header5Criteria[] = $criteria;

$criteria = new stdClass();
$criteria->ID = "c20";
$criteria->desc = "TRANSFERABILITY (the solution offers ideas for solving apparently unrelated problems)";
$criteria->Hid = "H5";
$criteria->weight = "";
$criteria->score = "";
$header5Criteria[] = $criteria;

$criteria = new stdClass();
$criteria->ID = "c21";
$criteria->desc = "SEMINALITY (the solution draws attention to previously unnoticed problems)";
$criteria->Hid = "H5";
$criteria->weight = "";
$criteria->score = "";
$header5Criteria[] = $criteria;

$criteria = new stdClass();
$criteria->ID = "c22";
$criteria->desc = "PATHFINDING (the solution opens up a new conceptualization of the issues)";
$criteria->Hid = "H5";
$criteria->weight = "";
$criteria->score = "";
$header5Criteria[] = $criteria;

$criteria = new stdClass();
$criteria->ID = "c23";
$criteria->desc = "GERMINALITY (the solution suggests new ways of looking at existing problems)";
$criteria->Hid = "H5";
$criteria->weight = "";
$criteria->score = "";
$header5Criteria[] = $criteria;

$criteria = new stdClass();
$criteria->ID = "c24";
$criteria->desc = "FOUNDATIONALITY (the solution suggests a novel basis for further work)";
$criteria->Hid = "H5";
$criteria->weight = "";
$criteria->score = "";
$header5Criteria[] = $criteria;
$allCriteria["H5"] = $header5Criteria;

?>

<!--
<div class="contentform" >
<div class="likert">
  <div class="question">Relevance & Effectiveness - Knowledge of existing facts and principles</div>
  <fieldset>
    <legend>PERFORMANCE (the solution does what it is supposed to do)</legend>
    <label for="q1a"><input name="q1" id="q1a" value="5" type="radio">To a Great Extent</label>
    <label for="q1b"><input name="q1" id="q1b" value="4" type="radio">Very Much</label>
    <label for="q1c"><input name="q1" id="q1c" value="3" type="radio">Somewhat</label>
    <label for="q1d"><input name="q1" id="q1d" value="2" type="radio">Very Little</label>
    <label for="q1e"><input name="q1" id="q1e" value="1" type="radio">Not at All</label>
    <label for="q1f" class="notApplicable"><input name="q1" id="q1f" value="0" type="radio">Criteria Not Applicable</label>
  </fieldset>
</div>
<div class="likert">
  <fieldset>
    <legend>APPROPRIATENESS (the solution fits within task constraints) </legend>
    <label for="q2a"><input name="q2" id="q2a" value="5" type="radio">To a Great Extent</label>
    <label for="q2b"><input name="q2" id="q2b" value="4" type="radio">Very Much</label>
    <label for="q2c"><input name="q2" id="q2c" value="3" type="radio">Somewhat</label>
    <label for="q2d"><input name="q2" id="q2d" value="2" type="radio">Very Little</label>
    <label for="q2e"><input name="q2" id="q2e" value="1" type="radio">Not at All</label>
    <label for="q2f" class="notApplicable"><input name="q2" id="q2f" value="0" type="radio">Criteria Not Applicable</label>
  </fieldset>
</div>
<div class="likert">
  <fieldset>
    <legend>CORRECTNESS (the solution accurately reflects conventional knowledge and/or techniques)</legend>
    <label for="q3a"><input name="q3" id="q3a" value="5" type="radio">To a Great Extent</label>
    <label for="q3b"><input name="q3" id="q3b" value="4" type="radio">Very Much</label>
    <label for="q3c"><input name="q3" id="q3c" value="3" type="radio">Somewhat</label>
    <label for="q3d"><input name="q3" id="q3d" value="2" type="radio">Very Little</label>
    <label for="q3e"><input name="q3" id="q3e" value="1" type="radio">Not at All</label>
    <label for="q3f" class="notApplicable"><input name="q3" id="q3f" value="0" type="radio">Criteria Not Applicable</label>
  </fieldset>
</div>
<div class="likert">
  <div class="question">Problematization - Solution draws attention to problems in what already exists</div>
  <fieldset>
    <legend>PRESCRIPTION (the solution shows how existing solutions could be improved) </legend>
    <label for="q4a"><input name="q4" id="q4a" value="5" type="radio">To a Great Extent</label>
    <label for="q4b"><input name="q4" id="q4b" value="4" type="radio">Very Much</label>
    <label for="q4c"><input name="q4" id="q4c" value="3" type="radio">Somewhat</label>
    <label for="q4d"><input name="q4" id="q4d" value="2" type="radio">Very Little</label>
    <label for="q4e"><input name="q4" id="q4e" value="1" type="radio">Not at All</label>
    <label for="q4f" class="notApplicable"><input name="q4" id="q4f" value="0" type="radio">Criteria Not Applicable</label>
  </fieldset>
</div>
<div class="likert">
  <fieldset>
    <legend>PROGNOSIS (the solution helps the beholder to anticipate likely effects of changes)</legend>
    <label for="q5a"><input name="q5" id="q5a" value="5" type="radio">To a Great Extent</label>
    <label for="q5b"><input name="q5" id="q5b" value="4" type="radio">Very Much</label>
    <label for="q5c"><input name="q5" id="q5c" value="3" type="radio">Somewhat</label>
    <label for="q5d"><input name="q5" id="q5d" value="2" type="radio">Very Little</label>
    <label for="q5e"><input name="q5" id="q5e" value="1" type="radio">Not at All</label>
    <label for="q5f" class="notApplicable"><input name="q5" id="q5f" value="0" type="radio">Criteria Not Applicable</label>
  </fieldset>
</div>
<div class="likert">
  <fieldset>
    <legend>DIAGNOSIS (the solution draws attention to shortcomings in other existing solutions)</legend>
    <label for="q6a"><input name="q6" id="q6a" value="5" type="radio">To a Great Extent</label>
    <label for="q6b"><input name="q6" id="q6b" value="4" type="radio">Very Much</label>
    <label for="q6c"><input name="q6" id="q6c" value="3" type="radio">Somewhat</label>
    <label for="q6d"><input name="q6" id="q6d" value="2" type="radio">Very Little</label>
    <label for="q6e"><input name="q6" id="q6e" value="1" type="radio">Not at All</label>
    <label for="q6f" class="notApplicable"><input name="q6" id="q6f" value="0" type="radio">Criteria Not Applicable</label>
  </fieldset>
</div>
<div class="likert">
  <div class="question">Propulsion - </div>
  <fieldset>
    <legend>REDEFINITION (the solution helps the beholder see new and different ways of using the solution) </legend>
    <label for="q7a"><input name="q7" id="q7a" value="5" type="radio">To a Great Extent</label>
    <label for="q7b"><input name="q7" id="q7b" value="4" type="radio">Very Much</label>
    <label for="q7c"><input name="q7" id="q7c" value="3" type="radio">Somewhat</label>
    <label for="q7d"><input name="q7" id="q7d" value="2" type="radio">Very Little</label>
    <label for="q7e"><input name="q7" id="q7e" value="1" type="radio">Not at All</label>
    <label for="q7f" class="notApplicable"><input name="q7" id="q7f" value="0" type="radio">Criteria Not Applicable</label>
  </fieldset>
</div>
<div class="likert">
  <fieldset>
    <legend>REINITIATION (the solution indicates a radically new approach)</legend>
    <label for="q8a"><input name="q8" id="q8a" value="5" type="radio">To a Great Extent</label>
    <label for="q8b"><input name="q8" id="q8b" value="4" type="radio">Very Much</label>
    <label for="q8c"><input name="q8" id="q8c" value="3" type="radio">Somewhat</label>
    <label for="q8d"><input name="q8" id="q8d" value="2" type="radio">Very Little</label>
    <label for="q8e"><input name="q8" id="q8e" value="1" type="radio">Not at All</label>
    <label for="q8f" class="notApplicable"><input name="q8" id="q8f" value="0" type="radio">Criteria Not Applicable</label>
  </fieldset>
</div>
<div class="likert">
  <fieldset>
    <legend>GENERATION (the solution offers a fundamentally new perspective on possible solutions)</legend>
    <label for="q9a"><input name="q9" id="q9a" value="5" type="radio">To a Great Extent</label>
    <label for="q9b"><input name="q9" id="q9b" value="4" type="radio">Very Much</label>
    <label for="q9c"><input name="q9" id="q9c" value="3" type="radio">Somewhat</label>
    <label for="q9d"><input name="q9" id="q9d" value="2" type="radio">Very Little</label>
    <label for="q9e"><input name="q9" id="q9e" value="1" type="radio">Not at All</label>
    <label for="q9f" class="notApplicable"><input name="q9" id="q9f" value="0" type="radio">Criteria Not Applicable</label>
  </fieldset>
</div>   
<div class="likert">
  <fieldset>
    <legend>REDIRECTION (the solution shows how to extend the known in a new direction)</legend>
    <label for="q10a"><input name="q10" id="q10a" value="5" type="radio">To a Great Extent</label>
    <label for="q10b"><input name="q10" id="q10b" value="4" type="radio">Very Much</label>
    <label for="q10c"><input name="q10" id="q10c" value="3" type="radio">Somewhat</label>
    <label for="q10d"><input name="q10" id="q10d" value="2" type="radio">Very Little</label>
    <label for="q10e"><input name="q10" id="q10e" value="1" type="radio">Not at All</label>
    <label for="q10f" class="notApplicable"><input name="q10" id="q10f" value="0" type="radio">Criteria Not Applicable</label>
  </fieldset>
</div>
<div class="likert">
  <fieldset>
    <legend>COMBINATION (the solution makes use of new mixture(s) of existing elements)</legend>
    <label for="q11a"><input name="q11" id="q11a" value="5" type="radio">To a Great Extent</label>
    <label for="q11b"><input name="q11" id="q11b" value="4" type="radio">Very Much</label>
    <label for="q11c"><input name="q11" id="q11c" value="3" type="radio">Somewhat</label>
    <label for="q11d"><input name="q11" id="q11d" value="2" type="radio">Very Little</label>
    <label for="q11e"><input name="q11" id="q11e" value="1" type="radio">Not at All</label>
    <label for="q11f" class="notApplicable"><input name="q11" id="q11f" value="0" type="radio">Criteria Not Applicable</label>
  </fieldset>
</div>  
<div class="likert">
  <div class="question">Elegance - </div>
  <fieldset>
    <legend>PLEASINGNESS (the beholder finds the solution neat, well done) </legend>
    <label for="q12a"><input name="q12" id="q12a" value="5" type="radio">To a Great Extent</label>
    <label for="q12b"><input name="q12" id="q12b" value="4" type="radio">Very Much</label>
    <label for="q12c"><input name="q12" id="q12c" value="3" type="radio">Somewhat</label>
    <label for="q12d"><input name="q12" id="q12d" value="2" type="radio">Very Little</label>
    <label for="q12e"><input name="q12" id="q12e" value="1" type="radio">Not at All</label>
    <label for="q12f" class="notApplicable"><input name="q12" id="q12f" value="0" type="radio">Criteria Not Applicable</label>
  </fieldset>
</div>
<div class="likert">
  <fieldset>
    <legend>COMPLETENESS (the solution is well worked out and rounded )</legend>
    <label for="q13a"><input name="q13" id="q13a" value="5" type="radio">To a Great Extent</label>
    <label for="q13b"><input name="q13" id="q13b" value="4" type="radio">Very Much</label>
    <label for="q13c"><input name="q13" id="q13c" value="3" type="radio">Somewhat</label>
    <label for="q13d"><input name="q13" id="q13d" value="2" type="radio">Very Little</label>
    <label for="q13e"><input name="q13" id="q13e" value="1" type="radio">Not at All</label>
    <label for="q13f" class="notApplicable"><input name="q13" id="q13f" value="0" type="radio">Criteria Not Applicable</label>
  </fieldset>
</div>  
<div class="likert">
  <fieldset>
    <legend>SUSTAINABILITY (the solution is environmentally friendly)</legend>
    <label for="q14a"><input name="q14" id="q14a" value="5" type="radio">To a Great Extent</label>
    <label for="q14b"><input name="q14" id="q14b" value="4" type="radio">Very Much</label>
    <label for="q14c"><input name="q14" id="q14c" value="3" type="radio">Somewhat</label>
    <label for="q14d"><input name="q14" id="q14d" value="2" type="radio">Very Little</label>
    <label for="q14e"><input name="q14" id="q14e" value="1" type="radio">Not at All</label>
    <label for="q14f" class="notApplicable"><input name="q14" id="q14f" value="0" type="radio">Criteria Not Applicable</label>
  </fieldset>
</div>  
<div class="likert">
  <fieldset>
    <legend>GRACEFULNESS (the solution well-proportioned, nicely formed) </legend>
    <label for="q15a"><input name="q15" id="q15a" value="5" type="radio">To a Great Extent</label>
    <label for="q15b"><input name="q15" id="q15b" value="4" type="radio">Very Much</label>
    <label for="q15c"><input name="q15" id="q15c" value="3" type="radio">Somewhat</label>
    <label for="q15d"><input name="q15" id="q15d" value="2" type="radio">Very Little</label>
    <label for="q15e"><input name="q15" id="q15e" value="1" type="radio">Not at All</label>
    <label for="q15f" class="notApplicable"><input name="q15" id="q15f" value="0" type="radio">Criteria Not Applicable</label>
  </fieldset>
</div>  
<div class="likert">
  <fieldset>
    <legend>CONVINCINGNESS (the beholder sees the solution as skillfully executed, well-finished) </legend>
    <label for="q16a"><input name="q16" id="q16a" value="5" type="radio">To a Great Extent</label>
    <label for="q16b"><input name="q16" id="q16b" value="4" type="radio">Very Much</label>
    <label for="q16c"><input name="q16" id="q16c" value="3" type="radio">Somewhat</label>
    <label for="q16d"><input name="q16" id="q16d" value="2" type="radio">Very Little</label>
    <label for="q16e"><input name="q16" id="q16e" value="1" type="radio">Not at All</label>
    <label for="q16f" class="notApplicable"><input name="q16" id="q16f" value="0" type="radio">Criteria Not Applicable</label>
  </fieldset>
</div>  
<div class="likert">
  <fieldset>
    <legend>HARMONIOUSNESS (the elements of the solution fit together in a consistent way)</legend>
    <label for="q17a"><input name="q17" id="q17a" value="5" type="radio">To a Great Extent</label>
    <label for="q17b"><input name="q17" id="q17b" value="4" type="radio">Very Much</label>
    <label for="q17c"><input name="q17" id="q17c" value="3" type="radio">Somewhat</label>
    <label for="q17d"><input name="q17" id="q17d" value="2" type="radio">Very Little</label>
    <label for="q17e"><input name="q17" id="q17e" value="1" type="radio">Not at All</label>
    <label for="q17f" class="notApplicable"><input name="q17" id="q17f" value="0" type="radio">Criteria Not Applicable</label>
  </fieldset>
</div> 
<div class="likert">
  <fieldset>
    <legend>SAFETY (the solution is safe to use)</legend>
    <label for="q18a"><input name="q18" id="q18a" value="5" type="radio">To a Great Extent</label>
    <label for="q18b"><input name="q18" id="q18b" value="4" type="radio">Very Much</label>
    <label for="q18c"><input name="q18" id="q18c" value="3" type="radio">Somewhat</label>
    <label for="q18d"><input name="q18" id="q18d" value="2" type="radio">Very Little</label>
    <label for="q18e"><input name="q18" id="q18e" value="1" type="radio">Not at All</label>
    <label for="q18f" class="notApplicable"><input name="q18" id="q18f" value="0" type="radio">Criteria Not Applicable</label>
  </fieldset>
</div> 
<div class="likert">
  <div class="question">Genesis - Ideas in the solution go beyond the immediate situation</div>
  <fieldset>
    <legend>VISION (the solution suggests new norms for judging other solutions-existing or new) </legend>
    <label for="q19a"><input name="q19" id="q19a" value="5" type="radio">To a Great Extent</label>
    <label for="q19b"><input name="q19" id="q19b" value="4" type="radio">Very Much</label>
    <label for="q19c"><input name="q19" id="q19c" value="3" type="radio">Somewhat</label>
    <label for="q19d"><input name="q19" id="q19d" value="2" type="radio">Very Little</label>
    <label for="q19e"><input name="q19" id="q19e" value="1" type="radio">Not at All</label>
    <label for="q19f" class="notApplicable"><input name="q19" id="q19f" value="0" type="radio">Criteria Not Applicable</label>
  </fieldset>
</div>
<div class="likert">
  <fieldset>
    <legend>TRANSFERABILITY (the solution offers ideas for solving apparently unrelated problems)</legend>
    <label for="q20a"><input name="q20" id="q20a" value="5" type="radio">To a Great Extent</label>
    <label for="q20b"><input name="q20" id="q20b" value="4" type="radio">Very Much</label>
    <label for="q20c"><input name="q20" id="q20c" value="3" type="radio">Somewhat</label>
    <label for="q20d"><input name="q20" id="q20d" value="2" type="radio">Very Little</label>
    <label for="q20e"><input name="q20" id="q20e" value="1" type="radio">Not at All</label>
    <label for="q20f" class="notApplicable"><input name="q20" id="q20f" value="0" type="radio">Criteria Not Applicable</label>
  </fieldset>
</div>
<div class="likert">
  <fieldset>
    <legend>SEMINALITY (the solution draws attention to previously unnoticed problems)</legend>
    <label for="q21a"><input name="q21" id="q21a" value="5" type="radio">To a Great Extent</label>
    <label for="q21b"><input name="q21" id="q21b" value="4" type="radio">Very Much</label>
    <label for="q21c"><input name="q21" id="q21c" value="3" type="radio">Somewhat</label>
    <label for="q21d"><input name="q21" id="q21d" value="2" type="radio">Very Little</label>
    <label for="q21e"><input name="q21" id="q21e" value="1" type="radio">Not at All</label>
    <label for="q21f" class="notApplicable"><input name="q21" id="q21f" value="0" type="radio">Criteria Not Applicable</label>
  </fieldset>
</div>
<div class="likert">
  <fieldset>
    <legend>PATHFINDING (the solution opens up a new conceptualization of the issues)</legend>
    <label for="q22a"><input name="q22" id="q22a" value="5" type="radio">To a Great Extent</label>
    <label for="q22b"><input name="q22" id="q22b" value="4" type="radio">Very Much</label>
    <label for="q22c"><input name="q22" id="q22c" value="3" type="radio">Somewhat</label>
    <label for="q22d"><input name="q22" id="q22d" value="2" type="radio">Very Little</label>
    <label for="q22e"><input name="q22" id="q22e" value="1" type="radio">Not at All</label>
    <label for="q22f" class="notApplicable"><input name="q22" id="q22f" value="0" type="radio">Criteria Not Applicable</label>
  </fieldset>
</div>
<div class="likert">
  <fieldset>
    <legend>GERMINALITY (the solution suggests new ways of looking at existing problems)</legend>
    <label for="q23a"><input name="q23" id="q23a" value="5" type="radio">To a Great Extent</label>
    <label for="q23b"><input name="q23" id="q23b" value="4" type="radio">Very Much</label>
    <label for="q23c"><input name="q23" id="q23c" value="3" type="radio">Somewhat</label>
    <label for="q23d"><input name="q23" id="q23d" value="2" type="radio">Very Little</label>
    <label for="q23e"><input name="q23" id="q23e" value="1" type="radio">Not at All</label>
    <label for="q23f" class="notApplicable"><input name="q23" id="q23f" value="0" type="radio">Criteria Not Applicable</label>
  </fieldset>
</div>
<div class="likert">
  <fieldset>
    <legend>FOUNDATIONALITY (the solution suggests a novel basis for further work)</legend>
    <label for="q24a"><input name="q24" id="q24a" value="5" type="radio">To a Great Extent</label>
    <label for="q24b"><input name="q24" id="q24b" value="4" type="radio">Very Much</label>
    <label for="q24c"><input name="q24" id="q24c" value="3" type="radio">Somewhat</label>
    <label for="q24d"><input name="q24" id="q24d" value="2" type="radio">Very Little</label>
    <label for="q24e"><input name="q24" id="q24e" value="1" type="radio">Not at All</label>
    <label for="q24f" class="notApplicable"><input name="q24" id="q24f" value="0" type="radio">Criteria Not Applicable</label>
  </fieldset>
</div>
<input type="submit" value="Submit" />
</div>
--!>
<?php
echo elgg_view('input/hidden', array('name' => 'assignID', 'value' => get_input('assignmentID')));
echo elgg_view('input/hidden', array('name' => 'groupID', 'value' => get_input('groupID')));

?>
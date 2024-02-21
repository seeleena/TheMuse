<div id='creativeSolutionWeightingDiv' class='instructionContents'>
    <table class='elgg-table' id='creativeSolutionWeightingTable'>
        <tr>
            <th colspan='2' class='tableHeaderText'>Creative Solution</th>
        </tr>
        <tfoot>
            <tr>
                <td colspan='2'></td>
            </tr>
        </tfoot>
    </table>
</div>
     
<?php

echo elgg_view('input/hidden', array('value' => get_input("assignID"),
                                        'id' => 'assignID',
                                        'name' => 'assignID'));
echo elgg_view('input/button', array('value' => 'Next Stage',
                                        'id' => 'btnSaveSectionWeightings'));
echo elgg_view('input/submit', array('value' => 'Save Assessment Weightings',
                                        'id' => 'btnSaveAssessmentWeightings'));
?>
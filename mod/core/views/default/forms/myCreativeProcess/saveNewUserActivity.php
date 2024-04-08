<div class="elgg-main elgg-body">
    <ul class="elgg-menu elgg-breadcrumbs"><li>Add Activity</li></ul>
    <div class="elgg-head clearfix">
        <h2 class="elgg-heading-main">Create My Own Activity</h2>
    </div>
    <style>
        .myFields {
        background-color: #f9f9f9;
        padding: 15px;
        border-radius: 10px;
        border: 1px solid #ccc;
    }
    .myFields small {
        margin: 10px;
    }
    .myFields input[type="text"] {
        width: 100%;
    }
    .myFields input[type="submit"] {
        margin-top: 10px;
    }
    .myFields select {
        width: 100%;
    }
    .myFields label {
        font-weight: bold;
    }
    .myFields h4 {
        font-weight: bold;
    }
    .myFields a {
        text-decoration: none;
        color: #000;
    }
    .myFields a:hover {
        text-decoration: underline;
    }
    .myFields input[type="radio"] {
        margin-right: 5px;
    }
    .myFields input[type="radio"]:checked {
        background-color: #f9f9f9;
    }
    .myFields input[type="radio"]:hover {
        background-color: #f9f9f9;
    }
    .myFields input[type="radio"]:active {
        background-color: #f9f9f9;
    }
    .myFields input[type="radio"]:focus {
        background-color: #f9f9f9;
    }
    .myFields input[type="radio"]:visited {
        background-color: #f9f9f9;
    }
    .myFields input[type="radio"]:link {
        background-color: #f9f9f9;
    }
    .myFields input[type="radio"]:not(:checked) {
        background-color: #f9f9f9;
    }
    .myFields input[type="radio"]:not(:hover) {
        background-color: #f9f9f9;
    }
    .myFields input[type="radio"]:not(:active) {
        background-color: #f9f9f9;
    }
    .myFields input[type="radio"]:not(:focus) {
        background-color: #f9f9f9;
    }
    .myFields input[type="radio"]:not(:visited) {
        background-color: #f9f9f9;
    }

    </style>
    <blockquote>
        <p>You may find it useful to modify your creative process to better suit your needs and your particular
        situation. You can do this by creating an activity which you perform in your creative process that did
        not exist in the original outline of your "creative process". This activity can contain instructions and tools.
        To create a new activity, fill out the form below and click on the "Save Activity" button to add 
        this activity to your creative process.</p>
    </blockquote>
<?php
echo elgg_view('input/hidden', array('value' => get_input("aID"),
                                        'id' => 'aID',
                                        'name' => 'aID'));
echo elgg_view('input/hidden', array('value' => get_input("assignID"),
                                        'id' => 'assignID',
                                        'name' => 'assignID'));
echo elgg_view('input/hidden', array('value' => get_input("userID"),
                                        'id' => 'userID',
                                        'name' => 'userID'));
echo elgg_view('input/hidden', array('value' => get_input("cpID"),
                                        'id' => 'cpID',
                                        'name' => 'cpID'));
echo elgg_view('input/hidden', array('value' => get_input("stageNum"),
                                        'id' => 'stageNum',
                                        'name' => 'stageNum'));

echo "<div class='myFields small'>";
echo "<h3>Describe the Activity</h3><br/>";
echo "<label>Activity Title</label>";
echo elgg_view('input/text', array('name' => 'activityTitle'));
echo "<br/><br/><label>Activity Description</label><br/>";
echo elgg_view('input/text', array('name' => 'activityDesc'));

echo "<br/><br/><h3>Describe the Instruction</h3><br/>";
echo "<label>Instruction 1</label><br/>";
echo "<div id='dynamicInput'>";
echo elgg_view('input/text', array('name' => 'instructions[]'));
echo "</div>";
$param = "dynamicInput";
echo "<br/><input type='button' class='elgg-button' value='Add Another Instruction' onClick='addInput(\"$param\");'/><br/><br/>";

$toolListing = getToolListing();
$tool = new StdClass;
$tools = array();
$tools['0'] = "Select a Tool";
foreach ($toolListing as $tool) {
    if(strcmp($tool->name, "Collaborative Input Tool") !== 0 && strcmp($tool->name, "Share Creation Tool") !== 0 && strcmp($tool->name, "Random Word Generator Tool") !== 0 && strcmp($tool->name, "Submission and Scoring Tool") !== 0)
    $tools[$tool->id] = $tool->name;
    //error_log("list of toolids: ".$tool->id);
    //error_log("list of toolnames: ".$tool->name);
}
//array_unshift($tools, "Select a Tool");
//$tools = array_merge(array('0' => 'Select a Tool'), $tools);
foreach ($tools as $key => $value) {
    error_log("tools array: $key => $value");
}
echo "<br/><br/><h3>Add Tool(s) to your Activity</h3><br/>";
echo "<label><u>Tool 1</u></label><br/><br/>";

echo "<div id='dynamicInput2'>";
echo "<label>Enter Tool Name</label><br/>";
echo elgg_view('input/text', array('name' => 'toolNames[]'));
echo "<br/><br/><label>Enter Tool URL</label><br/>";
echo elgg_view('input/text', array('name' => 'toolURLs[]'));
echo "<br/><br/><label><u>OR</u></label><br/>";
echo "<br/><label>Select Existing Tool</label><br/>";
echo elgg_view('input/dropdown', array(
                'name' => 'tools[]',
                'value' => 'tools',
                'options' => $tools,
                ));
echo "</div>";
echo "<br/><input type='button' class='elgg-button' value='Add Another Tool' onclick='addSelect(\"dynamicInput2\");'/><br/>";
echo "<br/>";
echo elgg_view('input/submit', array('value'=>'Save Activity'));

?>
</div>
<script type="text/javascript">
    var counter = 1;
    var limit = 8;
    var toolCount = 1;
    
    function addInput(divName){
         if (counter == limit)  {
              alert("You have reached the limit of adding " + counter + " instructions");
         }
         else {
              var newdiv = document.createElement('div');
              newdiv.innerHTML = "<br/><label>Instruction " + (counter + 1) + " </label><br/> <input type='text' name='instructions[]'>";
              document.getElementById(divName).appendChild(newdiv);
              counter++;
         }
    }
    
    function addSelect(divname) {
        var newDiv=document.createElement('div');
        var i;
        toolCount++;
        var html = "<br/><label><u>Tool "+ toolCount +"</u></label>";
        html += "<br/><br/><label>Enter Tool Name</label><br/>";
        html += "<input type='text' name='toolNames[]'>";
        html += "<br/><br/><label>Enter Tool URL</label><br/>";
        html += "<input type='text' name='toolURLs[]'>";
        html += "<br/><br/><label><u>OR</u></label><br/><br/><label>Select Existing Tool</label><br/>";
        html += "<select name='tools[]'>";
        var toolNames = [];
        var toolIDs = [];
        <?php 
        
            foreach ($tools as $toolID => $tool) {
                echo "toolIDs.push('" . $toolID . "');";
                echo "toolNames.push('" . $tool . "');";
            }
        ?>
        for(i = 0; i < toolNames.length; i++) {
            html += "<option value='"+toolIDs[i]+"'>"+toolNames[i]+"</option>";
        }
        html += '</select>';
        newDiv.innerHTML= html;
        document.getElementById(divname).appendChild(newDiv);
    }
</script>
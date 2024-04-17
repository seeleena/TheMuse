//This is the view for the student landing page
<?php
include elgg_get_plugins_path()."Core/lib/utilities.php"; //This enables the relevant functions that is used for this student landing page to be called from utilities
$user = elgg_get_logged_in_user_entity();//Verifies user logged in
?>

//Description of The Muse outlined for students
<div class="elgg-main elgg-body">
    <ul class="elgg-menu elgg-breadcrumbs"><li>Home</li></ul>
    <div class="elgg-head clearfix">
        <h2 class="elgg-heading-main">Welcome to the Muse v2.1, <?php echo $user->username; ?>.</h2>
    </div>
    <blockquote >
        <p>The Muse  v2.11 was built to help you to enhance your creativity skills whilst doing your coursework assignments. It is built within a social network called ELGG and
        has the normal features of a social network, similar to Facebook. You can edit your Profile, post messages on the Wire, view your Inbox and Friends lists, see
        all activity on the Activity page, create Blogs, Bookmarks, Groups and Pages, view all Members on the network, and also upload Files to your profile. Use these 
        features to keep in touch with your friends and classmates and also to keep abreast of current happenings in your class. Post freely and often! The more you use the
        Muse, the more useful it will become to you and your classmates.
        </p>
     </blockquote > 
	
    // CSS imported from old codebase
    <div class="elgg-head clearfix">
        <h3 class="elgg-heading-main">Things you should know</h3>
    </div>
     <style>
        #wrapper {
            width : 100%;
            height : 100%;
        }

        #wrapper-header {
            width : 100%;
            margin : 0px auto;
        }   

        #wrapper-logo {
            width : 70%;
            float:left;
        }

        #wrapper-navbar {
            float:right;
            width: 28%;
        }

        .cf:before,
        .cf:after {
            content: " "; /* 1 */
            display: table; /* 2 */
        }

        .cf:after {
            clear: both;
        }

        .cf {
            *zoom: 1;
        }
        p {
            text-align: justify;
        }

.list
{
padding-left: 0;
margin-left: 0;
border-bottom: 1px solid gray;
text-align: justify;
margin-bottom: 10px;
}

.list li
{

margin: 0;
padding: 10px;
border-bottom: 1px solid gray;
background-color: #EEE;

}

.innerList li
{
list-style:decimal;
list-style-position:inside;
}

.bullet li {
list-style:disc;
list-style-position:inside;
padding-left: 15px;

}

.background
{
margin: 0;
padding: 10px;
border-bottom: 1px solid gray;
background-color: #EEE;
margin-bottom: 10px;
}

.myheader {
    padding-bottom: 3px;
    margin-bottom: 10px;
}

.aHrefLabel {
    font-weight: bold;
    font-size: 110%;
    text-decoration:underline;
    text-align:center;
}

.numberedList li
{
list-style:decimal;
list-style-position:inside;
color: #4690D6;
}

.greyNumberedList li
{
list-style:decimal;
list-style-position:inside;

}

/* grading */
#assignmentDetails h1 {
    display: none;
}

#assignmentDetails #innerAssignmentDetails {
    display: none;
}

#projectGroups #allGroups {
    display: none;
}

.smallLabel {
font-weight: normal;
font-size: 100%;
display: block;
width: 50px;
float: left;

}
.smallLabel:after { content: ": " }

.instructionsMargin {
margin-left:1cm;
}

.toolsMargin {
margin-left:2cm;
}

hr {
  border-top: 2px dotted #4690D6;
  width:80%;
}
/*
input[type=dropdown] {
width: 150px;
padding: 20px;
}*/

.myFields label {
width:250px; 

}

.dropdownLabel {
width: 250px;
float: left;
}

.dropdownBtn {
    float: none;
    display: block;
    width: 130px;
    margin: 10px auto;
}

.inputText {
    width: 200px;
}

/* ******************************************************* */
/* styles for creating likert scales */
.contentform .likert
{
	display: block;
	border-top: #996 dotted 1px;
	padding: 0.5em 0;
	clear: both;
}

.contentform .likert legend
{
        width: 100%; 
        font-weight:bold;
	background-color: #EEE;
        padding-bottom: 5px;
        margin-bottom: 10px;
}

.contentform .likert .question 
{ 
        width: 100%; 
        font-size: 120%;
	color: #4690D6;
        font-weight:bold;
        background-color: #EEE;
        padding-bottom: 5px;
        
}

.contentform .likert label
{
	margin: 0;
	clear: none;
	width: 16%;
	float: left;
	color: #333;
	position: relative;
	text-align: center;
	padding: 1.5em 0 0.5em;
	border-top: none;
	font-size: 90%;
}

.contentform .likert4 label { width: 24%; }
.contentform .likert3 label { width: 32%; }

.contentform .likert label:hover
{
	background-color: #e0e0c0;
	text-decoration: underline;
}

.contentform .likert label input
{
	display: block;
	position: absolute;
	left: 45%;
	top: 0;
}

.contentform .notApplicable {
        border-left: #996 dotted 1px;
}

/* ******************************************************* */

.myTextArea {
    height:60px;
    overflow: auto;
}

.myHr {
  border-top: 1px dotted #EEE;
  width:100%;
}

.myBox{
    border: 1px solid #EEE;
    min-height: 70px;
}

.criteriaHeading {
    background-color: #EBF5FF; 
    text-decoration: underline;
    text-decoration: bold;
}

.tableHeaderText {
    text-decoration: bold;
    font-size: 105%;
    text-align: center;
    
}

.assessmentCriteria {
    text-indent: 5%;
    margin-left: 5%;
}

.checkBoxMiddle {
    text-align: center;
}
/*myCreativeProcess/main*/

.bubble {
        float: left;
	clear: both;
	margin: 0px auto 20px auto;
	width: 550px;
	background: #fff;
	-moz-border-radius: 10px;
  -khtml-border-radius: 10px;
  -webkit-border-radius: 10px;
	-moz-box-shadow: 0px 0px 8px rgba(0,0,0,0.3);
  -khtml-box-shadow: 0px 0px 8px rgba(0,0,0,0.3);
  -webkit-box-shadow: 0px 0px 8px rgba(0,0,0,0.3);	
	position: relative; 
	z-index: 90; /* the stack order: displayed under ribbon rectangle (100) */
}

.rectangle {
	background: #7f9db9;
	height: 50px;
	width: 580px;
	position: relative;
	left:-15px;
	top: 30px;
	float: left;
	-moz-box-shadow: 0px 0px 4px rgba(0,0,0,0.55);
  -khtml-box-shadow: 0px 0px 4px rgba(0,0,0,0.55);
  -webkit-box-shadow: 0px 0px 4px rgba(0,0,0,0.55);
	z-index: 100; /* the stack order: foreground */
}

.rectangle h2 {
	font-size: 20px;
	color: #fff;
	padding-top: 12px;
	text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
	text-align: center;
}

.triangle-l {
	border-color: transparent #7d90a3 transparent transparent;
	border-style:solid;
	border-width:15px;
	height:0px;
	width:0px;
	position: relative;
	left: -30px;
	top: 65px;
	z-index: -1; /* displayed under bubble */
}

.triangle-r {
	border-color: transparent transparent transparent #7d90a3;
	border-style:solid;
	border-width:15px;
	height:0px;
	width:0px;
	position: relative;
	left: 550px;
	top: 35px;
	z-index: -1; /* displayed under bubble */
}
/* force update */
.btn-container { float: left; display: inline-block; margin-right: 15px; padding: 20px;}

.blu-btn {
white-space: normal;
display: table-cell;
vertical-align: middle;
-moz-border-radius: .25em;
border-radius: .25em;
-webkit-box-shadow: 0 2px 0 0 rgba(0,0,0,0.1), inset 0 -2px 0 0 rgba(0,0,0,0.2);
-moz-box-shadow: 0 2px 0 0 rgba(0,0,0,0.1), inset 0 -2px 0 0 rgba(0,0,0,0.2);
box-shadow: 0 2px 0 0 rgba(0,0,0,0.1), inset 0 -2px 0 0 rgba(0,0,0,0.2);
background-color: #276195;
background-image: -moz-linear-gradient(#3c88cc,#276195);
background-image: -ms-linear-gradient(#3c88cc,#276195);
background-image: -webkit-gradient(linear,left top,left bottom,color-stop(0%,#3c88cc),color-stop(100%,#276195));
background-image: -webkit-linear-gradient(#3c88cc,#276195);
background-image: -o-linear-gradient(#3c88cc,#276195);
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#3c88cc',endColorstr='#276195',GradientType=0);
-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr='#3c88cc', endColorstr='#276195', GradientType=0)";
background-image: linear-gradient(#3c88cc,#276195);
border: 0;
cursor: pointer;
color: #fff;
text-decoration: none;
text-align: center;
font-size: 16px;
padding: 8px 20px;
height: 40px;
/*line-height: 25px;*/
min-width: 150px;
max-width: 150px;
text-shadow: 0 1px 0 rgba(0,0,0,0.35);
font-family: Arial, Tahoma, sans-serif;
-webkit-transition: all linear .2s;
-moz-transition: all linear .2s;
-o-transition: all linear .2s;
-ms-transition: all linear .2s;
transition: all linear .2s
}
.blu-btn:hover, .blu-btn:focus {
-webkit-box-shadow: 0 2px 0 0 rgba(0,0,0,0.1), inset 0 -2px 0 0 rgba(0,0,0,0.3), inset 0 12px 20px 2px #3089d8;
-moz-box-shadow: 0 2px 0 0 rgba(0,0,0,0.1), inset 0 -2px 0 0 rgba(0,0,0,0.3), inset 0 12px 20px 2px #3089d8;
box-shadow: 0 2px 0 0 rgba(0,0,0,0.1), inset 0 -2px 0 0 rgba(0,0,0,0.3), inset 0 12px 20px 2px #3089d8;
}
.blu-btn:active {
-webkit-box-shadow: inset 0 2px 0 0 rgba(0,0,0,0.2), inset 0 12px 20px 6px rgba(0,0,0,0.2), inset 0 0 2px 2px rgba(0,0,0,0.3);
-moz-box-shadow: inset 0 2px 0 0 rgba(0,0,0,0.2), inset 0 12px 20px 6px rgba(0,0,0,0.2), inset 0 0 2px 2px rgba(0,0,0,0.3);
box-shadow: inset 0 2px 0 0 rgba(0,0,0,0.2), inset 0 12px 20px 6px rgba(0,0,0,0.2), inset 0 0 2px 2px rgba(0,0,0,0.3);
}

/*
.couponcode:hover .coupontooltip {
    display: block;
}
*/

.coupontooltip {
    display: none;
    background: #C8C8C8;
    margin-left: 28px;
    padding: 10px;
    position: absolute;
    z-index: 1000;
    width:475px;
    height:140px;
}

.couponcode {
    
}

.myAlignLeft {
    text-align: left;
    padding-left: 45px;
}

.blank_row
{
    height: 30px !important; /* Overwrite any previous rules */
    background-color: #FFFFFF;
}

.heading1 {
color: #0054A7;
font-family: "Adobe Caslon Pro", "Hoefler Text", Georgia, Garamond, Times, serif;
letter-spacing:0.1em;
text-align:justify;
margin: 25px auto;
text-transform: lowercase;
line-height: 145%;
font-size: 14pt;
font-variant: small-caps;
font-weight: bold;
}

.heading2 {
color: #0054A7;
font-family: "Adobe Caslon Pro", "Hoefler Text", Georgia, Garamond, Times, serif;
letter-spacing:0.1em;
text-align:justify;
margin: 10px auto;
text-transform: lowercase;
font-size: 12pt;
font-variant: small-caps;
padding-left: 15px;
font-weight: bold;
}

.green-button {
    white-space: normal;
    display: table-cell;
    vertical-align: middle;
    -moz-border-radius: .25em;
    border-radius: .25em;
    -webkit-box-shadow: 0 2px 0 0 rgba(0,0,0,0.1), inset 0 -2px 0 0 rgba(0,0,0,0.2);
    -moz-box-shadow: 0 2px 0 0 rgba(0,0,0,0.1), inset 0 -2px 0 0 rgba(0,0,0,0.2);
    box-shadow: 0 2px 0 0 rgba(0,0,0,0.1), inset 0 -2px 0 0 rgba(0,0,0,0.2);
    background-color: #659324;
    background-image: -moz-linear-gradient(#81bc2e,#659324);
    background-image: -ms-linear-gradient(#81bc2e,#659324);
    background-image: -webkit-gradient(linear,left top,left bottom,color-stop(0%,#81bc2e),color-stop(100%,#659324));
    background-image: -webkit-linear-gradient(#81bc2e,#659324);
    background-image: -o-linear-gradient(#81bc2e,#659324);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#81bc2e',endColorstr='#659324',GradientType=0);
    -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr='#81bc2e', endColorstr='#659324', GradientType=0)";
    background-image: linear-gradient(#81bc2e,#659324);
    border: 0;
    cursor: pointer;
    color: #fff;
    text-decoration: none;
    text-align: center;
    font-size: 16px;
    padding: 8px 20px;
    height: 40px;
    min-width: 150px;
    max-width: 150px;
    text-shadow: 0 1px 0 rgba(0,0,0,0.35);
    font-family: Arial, Tahoma, sans-serif;
    -webkit-transition: all linear .2s;
    -moz-transition: all linear .2s;
    -o-transition: all linear .2s;
    -ms-transition: all linear .2s;
    transition: all linear .2s;    
}

.green-button:hover, .green-button:focus {
-webkit-box-shadow: 0 2px 0 0 rgba(0,0,0,0.1), inset 0 -2px 0 0 rgba(0,0,0,0.3), inset 0 12px 20px 2px #85ca26;
-moz-box-shadow: 0 2px 0 0 rgba(0,0,0,0.1), inset 0 -2px 0 0 rgba(0,0,0,0.3), inset 0 12px 20px 2px #85ca26;
box-shadow: 0 2px 0 0 rgba(0,0,0,0.1), inset 0 -2px 0 0 rgba(0,0,0,0.3), inset 0 12px 20px 2px #85ca26;
}
.green-button:active {
-webkit-box-shadow: inset 0 2px 0 0 rgba(0,0,0,0.2), inset 0 12px 20px 6px rgba(0,0,0,0.2), inset 0 0 2px 2px rgba(0,0,0,0.3);
-moz-box-shadow: inset 0 2px 0 0 rgba(0,0,0,0.2), inset 0 12px 20px 6px rgba(0,0,0,0.2), inset 0 0 2px 2px rgba(0,0,0,0.3);
box-shadow: inset 0 2px 0 0 rgba(0,0,0,0.2), inset 0 12px 20px 6px rgba(0,0,0,0.2), inset 0 0 2px 2px rgba(0,0,0,0.3);
}

.activityHeader {
color: #0054A7;
font-family: "Adobe Caslon Pro", "Hoefler Text", Georgia, Garamond, Times, serif;

text-align:center;

text-transform: lowercase;
font-size: 12pt;
font-variant: small-caps;
padding-left: 15px;
font-weight: bold;

}

#nosuggestions {
    text-align: center;
    margin: 20px;
}
.mytext:first-letter{
               text-transform: uppercase;
          }
.mytext {
color: #424242;
font-family: "Adobe Caslon Pro", "Hoefler Text", Georgia, Garamond, Times, serif;
letter-spacing:0.1em;
text-align:justify;
margin: 40px auto;
text-transform: lowercase;
line-height: 145%;
font-size: 14pt;
font-variant: small-caps;
padding-left: 15px;
padding-right: 15px;
}
        /*http://nicolasgallagher.com/micro-clearfix-hack/*/
     </style>
<div id="wrapper">
    <div id="wrapper-header" class="cf"> 
        <div id="wrapper-logo">
            <div id="menusAndFeatures">
                <h4 class="myheader">Menus & Features:</h4>
/*************************************************/		    
//Further detailed instructions added for students
/*************************************************/
		    <ul class="list">
                    <li>
                        The menu bar at the top left consisting of "Home, My Assignments, My Group,
                        My Creative Process and Tools" is where you will find everything pertaining to your
                        assignments.
                    </li>
                    <li>
                        My Assignments is a list of assignments for each course in which you are enrolled.
                    </li>
                    <li>
                        My Group will allow you to create and join a group for completing your assignments. 
                        It is separate from the "Groups" menu, which allows general group creation and viewing of 
                        all groups in the system. <b>You MUST create/join a group in order to start an assignment</b>, even if
                        the 'group' is 1 person, yourself. When you start "My Creative Process" (see below), your group is
                        automatically linked to your process and your progress in completing and submitting your assignment.
                    </li>
                    <li>
                        My Creative Process is the core of where your assignment work will be done. You are required
                        to start your assignments through this menu option. "My Creative Process" is meant to guide you
                        through a series of steps containing activities that you must complete with your group members.
                        Some of these steps will require online collaboration using special tools (see "Tools" below), 
                        while other steps can be accomplished face to face, offline and reported back.
                    </li>
                    <li>
                        Tools provides a list of tools available for your use in addition to the tools specified
                        in a particular activity. These tools can also be used outside of an assignment for creative
                        brainstorming.
                    </li>
                </ul>
            </div>            
        </div>
        <div id="wrapper-navbar">
            <div id="importantLinks">
                <h4 class="myheader">Important Links:</h4>
                <ul>
                    <li><a target="_blank" href="<?php echo getServerURL(); ?>Core/myCreativeProcess/survey">Form Link</a></li>
                </ul>
            </div>             
        </div>
    </div>
</div>
     
     
    <div id="section1">
        

    </div>
    <h4 class="myheader">What to do first</h4>
    <ul class="list bullet">
        <li>
            Familiarize yourself with the various features of the social network. Post a greeting on "The Wire".
            Add some friends. Edit your profile. Make a "Page" or post a mini "Blog" post.
        </li>
        <li>
            View your assignment and its details.
        </li>
        <li>
            Create your assignment group and populate it by inviting members.
        </li>
        <li>
            To start, select "My Creative Process".
        </li>
    </ul>
    <h4 class="myheader">Group Work</h4>
    <ul class="list">
        <li>
            If you have been given permission by your course instructor to work individually, you
            still need to go to "My Groups" and create a group for undertaking your assignment.
            You will simply be the only member of your group.
        </li>
        <li>
            <b>How to add members to a group and how to join a group:</b>
            <ul class="innerList">
                <li>
                    First, use "The Wire" or "Chat" to find and agree on your group members. You may also use the
                    "Members" menu to see all persons in the social network and message someone privately.
                </li>
                <li>
                    Add all persons of your group as friends. This is necessary for the group owner to
                    send invitations to each group member to join the group.
                </li>
                <li>
                    Click on "My Group" and have one member of your intended group create a group there.
                </li>
                <li>
                    The owner of the group must then click on "Groups", then click on the group that was created,
                    then select the button "Invite Friends". The owner must do this to invite all members of the intended 
                    group.
                </li>
                <li>
                    Each intended group member must then click on "Groups", then click on "Group invitations"
                    on the right panel. Accept the invitation to join the group.
                </li>
            </ul>
        </li>
    </ul>
    <h4 class="myheader">Assessment of Assignments</h4>
    <ul class="list">
         <li>
             Assessment of your assignments happens in two parts.
             Firstly, the Final Submission consists of all the files you created as per the 
             requirements of the assignment.
         </li>
         <li>
             Secondly, your group's Creative Process, which is stored as you 
             undertake the steps and activities, and use the tools provided,
         </li>
    </ul>
        
    
        
</div>



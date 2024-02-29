<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 *
?>*/

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

/* grading 
#assignmentDetails h1 {
    display: none;
}

#assignmentDetails #innerAssignmentDetails {
    display: none;
}

#projectGroups #allGroups {
    display: none;
}*/

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

/*#nosuggestions {
    text-align: center;
    margin: 20px;
}*/
?>
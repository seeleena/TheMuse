<?php
$user = elgg_get_logged_in_user_entity();
?>


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
        /*http://nicolasgallagher.com/micro-clearfix-hack/*/
     </style>
<div id="wrapper">
    <div id="wrapper-header" class="cf"> 
        <div id="wrapper-logo">
            <div id="menusAndFeatures">
                <h4 class="myheader">Menus & Features:</h4>

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
                    <li><a target="_blank" href="<?php //echo getServerURL(); ?>Core/myCreativeProcess/survey">Form Link</a></li>
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



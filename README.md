Welcome to The Muse Github Repository!
======================================

## Team Members:
	 Adrian Frection - 816027916
	 Faith Rose - 816029963
	 Anuradha Ramlakhan - 816030881
	 Seeleena Mohammed - 816033259

## Abstract:

The Muse social networking application, developed in 2016, assists students with their creative endeavors during coursework projects and assignments by recording the creative process in real-time, a departure from past methods. It emphasizes early-stage creativity development, supporting research into tertiary-level learning processes. Our project is focused on revitalizing the original code	base, updating dependencies and restructuring the code for clarity and ease of maintenance.  This modernization not only improves Muse's functionality but also paves the way for future development.


How to use the Muse:
===================
  1. Download Elgg
  2. Install Xampp
  3. Upload Elgg into Xampp htdocs folder and rename as Muse
  4. Start Xampp apache and mysql and go to localhost/Muse: http://localhost/Muse
  5. Setup Elgg on localhost/Muse
  6. Insert core into Muse mod folder
  7. Enable core plugin in Elgg Plugin Administration: http://localhost/Muse/admin/plugins/
  8. Utlize paths documented in elgg-plugin.php

## Resources:
	Xampp download: https://www.apachefriends.org/download.html
	Elgg download: https://elgg.org/about/download
	Elgg documentation: https://learn.elgg.org/en/stable/index.html

## Need:

The client wants to upgrade The Muse's outdated codebase to improve performance,
maintainability, and scalability. The modernization seeks to correspond with increasing
technology standards, improve user experience, and assure The Muse's long-term viability as an
effective instrument for leading tertiary level students through creative problem-solving.

## Scope:
The project aims to modernize The Muse by reorganizing code, upgrading dependencies, and
improving the user experience. The modernization will follow best practices in software
development, combining cutting-edge technologies and frameworks to improve performance and
security. Furthermore, the scope includes the review of existing features to ensure they meet
current pedagogical requirements.

## Objectives:

	● Enhance overall system performance and responsiveness.
	● Improve the maintainability and readability of the codebase.
	● Upgrade dependencies and frameworks to current versions.
	● Evaluate and potentially refine existing features to align with current pedagogical requirements.
	● Ensure the scalability and future-proofing of The Muse.

## Deliverables:
	● Refactored and modernized codebase.
	● Updated documentation reflecting the changes made.
	● Updated dependencies and frameworks.
	● Evaluation report on existing features with recommendations for refinement.

## Dockered Version:
https://hub.docker.com/repository/docker/aratakiyo/muse/general

	● Function path routing will need to be fixed. 
	● Elgg handles path routing with elgg_get_plugins_path() function. 
	● Unknown interaction between Elgg and docker. 


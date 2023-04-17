# I-Schedule

# Team
<ul>
<li>Imran Rahman</li>
<li>Kevin Medrano Castaneda</li>
<li>Chaz Steward</li>
<li>Kahlil McCoy</li>
<li>Uriel Benitez-Ramos</li>
</ul>

# Overview
Light-weight meeting web application finder/scheduler, similar to Doodle and Google Meet. Will be client / server-side logic with some sort of third-party service / API and a data source to persist data across user sessions.

# Usage
Click the link here to access the project: (link here)

# Environment Setup

## Version Control
Information presented below is a summarization of this <a href="https://learn.udacity.com/courses/ud123">Udemy Course.</a> If instructions are unclear below, please reference this course as well for further clarification and other things not mentioned below.

### Installing Git
<ol>
<li>Go to <a href="https://git-scm.com/downloads"> this page.</a></li>
<li>Download the software for Windows.</li>
<li>Install Git choosing all of the default options.</li>
<li>Once everything is installed, you should be able to run git on the command line. If it displays the usage information, then you're good to go.</li>
</ol>

### First Time Git Configuration
Before you can start using Git, you need to configure it. Run each of the following lines on the command line to make sure everything is set up.
<ol>
<li><code>git config --global user.name "&lt;Your-Full-Name&gt;"</code></li>
<li><code>git config --global user.email "&lt;your-email-address&gt;"</code></li>
<li><code>git config --global color.ui auto</code></li>
<li><code>git config --global merge.conflictstyle diff3</code></li>
<li><code>git config --list</code></li>
</ol>

<b> It is highly recommended to configure Git to your code editor of choice, as commits would otherwise have to be done through Vim which is difficult to navigate.</b> Here's some commands to run so Git is configured with these editors. If there's another editor outside of these you want to use, reach out to me.
<ul>
<li> Atom Editor Setup: <code>git config --global core.editor "atom --wait"</code> </li>
<li> Sublime Text Setup: <code>git config --global core.editor "'C:/Program Files/Sublime Text 2/sublime_text.exe' -n -w"</code> </li>
<li> VSCode Setup: <code>git config --global core.editor "code --wait"</code> </li>
</ul>

### Cloning this repository
<ol>
<li> Use the command line (or Git bash) to go into the folder you'd like the repository cloned in. For example, say I have a folder called "Software Engineering", so the command I would use is this for the command line: <code>cd "C:School Stuff\Software Engineering"</code> and this in Git Bash: <code>cd /c/School\ Stuff/Software\ Engineering/</code></li>
<li> Use this command on the command line when you've entered the desired folder: <code>git clone https://github.com/envyimran/i-schedule.git</code></li>
<li> You can ensure the repository's been cloned if you're using Git bash by CD'ing into the folder, where you'll see "(master") next to the folder name in the terminal </li>
</ol>

<b> Always ensure that before and after you start working on code, run this command:</b> <code>git status</code> <b>to ensure your cloned repository is in a okay state. </b>

### Staging / Committing Files
These steps will show you how to add files and then commit them to this repository.
<ol>
<li>Say you've made a file called "index.html" and you want to add it here. Use Git Bash and CD into the repository folder. </li>
<li>Check the status first using <code>git status</code></li>
<li>Run this command: <code>git add index.html</code></li>
<li>Run <code>git status</code> again. </li>
<li> Should say the branch (for now, will just be master), the changes to be commit and untracked files. </li>
<li> Once files have been added, run this command <code>git commit</code> which should open up your configured code editor.</li>
<li> The first paragraph is telling us exactly what we need to do - we need to supply a message for this commit. Also, any line that begins with the # character will be ignored. Farther down it says that this will be the initial commit. Lastly, it's giving us a list of the files that will be committed. Type out your commit message on the first line of the code editor. </li>
<li>Now save the file and close the editor window (closing just the pane/tab isn't enough, you need to close the code editor window that the git commit command opened).</li>
</ol>

To stage all files at once, use <code>git add .</code>. Remember to run <code>git status</code> after each add or commit!
<br>
Some code editors can peform git operations for you in a graphical user interface, like Visual Studio Code. You can bypass the editor with the -m flag, like this: <code>git commit -m "Initial commit"</code>
<br>
Reach out to me with additional questions regarding Git adding and commits!

### Branching
The purpose of a topic branch is that it lets you make changes that do not affect the master branch. Once you make changes on the topic branch, you can either decide that you don't like the changes on the branch and you can just delete that branch, or you can decide that you want to keep the changes on the topic branch and combine those changes in with those on another branch.
<ul>
<li><code>git branch</code> displays the names of all the branches in the repository.</li>
<li>If you wanted a branch to be called "homepage", here's the command to do so: <code>git branch homepage</code></li>
<li>Even though you just made a new branch, it doesn't automatically switch to it. You would use this command to switch to it: <code>git checkout homepage</code></li>
<li>The fastest way to determine the active branch is to look at the output of the <code>git branch</code> command. An asterisk will appear next to the name of the active branch.</li>
<li>To delete that branch, you would use this command: <code>git branch -d sidebar</code></li>
<li>One thing to note is that you can't delete a branch that you're currently on. So to delete the homepage branch, you'd have to switch to either the master branch or create and switch to a new branch.</li>
</ul>

### Merging
We will now learn how to combine the branches into our master branch.
<ol>
<li>Before you begin, ensure you are in the repository, checked out the master branch and the output of <code>git status</code> includes something along the lines of "working directory clean".</li>
<li>Here's the command to merge the branch you're on into master (with our example, homepage): <code>git merge homepage</code></li>
</ol>

If you make a merge on the wrong branch, use this command to undo the merge: <code>git reset --hard HEAD^</code>
<br>
If merge conflicts emerge, reach out to me.

## Database Configurations
Instructions for team to set up database on local machines.
### MySQL Installation
<ol>
<li>Download MySQL Installer from <a href="https://dev.mysql.com/downloads/installer/"> here </a> or <a href="https://dev.mysql.com/downloads/file/?id=516927"> here </a> and execute it (sign up for an account, enter company name as "Georgia State University" and occupation as "Student" if prompted to).</li>
<li> Run through installer. If asked about a requirement for Visual Studio, click next and ignore it. Set up root account, no need to change ports / other configurations, default should be fine. </li>
</ol>

### Connecting to the MySQL Server with the mysql Client / Setting up Database
<ol>
<li> Press the start menu and open up <b> MySQL 8.0 Command Line Client </b></li>
<li> You'll be prompted for a password, use the one set with your root account. </li>
<li> You should see something like this: </li>
  <ul>
  <li>
  Welcome to the MySQL monitor.  Commands end with ; or \g.
  Your MySQL connection id is 4
  Server version: 5.7.32 MySQL Community Server (GPL)

  Copyright (c) 2000, 2020, Oracle and/or its affiliates.

  Oracle is a registered trademark of Oracle Corporation and/or its
  affiliates. Other names may be trademarks of their respective
  owners.

  Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.
  </li>
  </ul>
<li> Run this command to create the database we'll be working with: <code>CREATE DATABASE i_schedule;</code></li>
<li> Ensure the database was created using this command: <code>SHOW DATABASES;</code> You should see the one we just created. </li>
</ol>

Will discuss table set up later and how to interact with database through code (posting / getting information). 

# Configurations / API
Database hosted on Amazon RDS, locally hosting using Wamp (have to configure php.ini and php_apache.ini), using MySQL Workbench to manage, Full Calendar and Google Calendar / Gmail / Meets API (must composer install).

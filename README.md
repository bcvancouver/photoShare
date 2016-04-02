Source Code Location:
/testsite/signin/

Installation instructions:

1.cd to the file's current directory run @setup_w2016.sql
2.config SQL database in PHPconnectionDB.php for login user and password
3.under/compsci/webdocs/wankinvi/web_docs/photoShare391/testsite/signin/
is all the webpages, run signin.html for start.

User Management Module

Log in in order to access any info of a user, user can update own info on main
page once loged in.
All pages on the site requires a login, except signin page, so please sign in the
signin.html first.
Signup button in the scroll down bar if a user isn't loged in, a person can press
it and go to the register page.

Upload Module

User may click the “upload a picture” button to navigate to upload page. Then
click “choose file” button to choose image files. After filling in all fields
below, user may click “submit” button to submit the picture into the database.
User may also sign in/ sign out by clicking the corresponding button in the drop
down box on the top right side of the page.

Display Module

There is a scroll down button that shows top 5,oldest, recent, own user photos on
the main.php page. Admin button in this scroll only works if login user is admin,
it will show ALL photos in the database.
There is also a admin button above gallary that shows if loged in is admin, it
will redirect to the admin page for data analysis.

Data Analysis Module

After user is logged in as “admin”, user may click the admin link in the middle of
the webpage. Then user will see the admin page contains analysis of current
entries in the database.
Admin may select specific subject, user, time period in the drop down box to view
OLAP report.

Group Module

To modify groups you must be signed and then click the groups link in the
navigation bar. There are three forms; the top one is to create a group. Make it
memorable and easy to type because you cannot create to groups with the same name
and you have to type it whenever you add or remove a member from it. To add or
remove members just type the name of the group and the name of the member and
click the button. If something goes wrong hit back and try again.
Search Module
To search be logged in and hit the search button on the navigation bar. The top
bar must be filled out without punctuation. So if you want to search for cats and
dogs just type “cats dogs” and every image about cats and dogs that you are
permitted to see will be displayed. You can click any of them for more info.

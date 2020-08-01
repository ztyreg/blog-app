# Blog Website (Content Management System)

## Login Credentials

URL: [http://3.22.235.98/cse330/cms/index.php](http://3.22.235.98/cse330/cms/index.php)

Tester accounts:
* tester (password: tester)
* tester2 (password: tester2)

Sign up:
click sign up on the top right to sign up. Note that you need to manually login after sign up.

## Features

User Management

* A session is created when a user logs in
* New users can register
* Passwords are hashed, salted, and checked securely
* Users can log out
* A user can edit and delete his/her own stories and comments but cannot edit or delete the stories or comments of another user

Story and Comment Management

* Relational database is configured with correct data types and foreign keys
* Stories can be posted
* A link can be associated with each story, and is stored in a separate database field from the story
* Comments can be posted in association with a story
* Stories can be edited and deleted
* Comments can be edited and deleted
* You can see who's the author of a post
* If you click on the name of a user, you can see their profile

Best Practices
* Code is well formatted and easy to read, with proper commenting
* Safe from SQL Injection attacks
* Site follows the FIEO philosophy
* All pages pass the W3C HTML and CSS validators
* CSRF tokens are passed when creating, editing, and deleting comments and stories


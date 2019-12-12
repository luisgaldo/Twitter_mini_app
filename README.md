# Twitter Mini APP

This app allows a user (with Twitter API access: https://developer.twitter.com/en/docs ) to, through a web interface, gather tweets
with a given hashtag. These tweets are then saved in a database (with the structure included in the file elogia.sql).

The project is built in a way that a file called "private.php" must contain several functions that return the keys and tokens needed for the Twitter API:
- oauth_access_token
- oauth_access_token_secret
- consumer_key
- consumer_secret


The whole project was developed using PHP and Javascript.

The library used to interact with the Twitter API was the following:
- https://github.com/J7mbo/twitter-api-php

There are several buttons in the UI that present different graphs:
- Word cloud
- Number of tweets per day
- Length distribution

In order to set up a local PHP server, the following command can be used after installing PHP (https://windows.php.net):
- php -S localhost:8000

For the database, I used XAMPP (https://www.apachefriends.org/es/index.html) which allows to set up, in an easy way, a MySQL database.


Notes:

Once the button "Obtener tweets" is clicked, it takes several seconds until the pop up screen appears confirming (or denyning) if the request went ok.

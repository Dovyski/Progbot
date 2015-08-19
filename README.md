# Progbot
It is a PHP/MySQL webapp to manage programming assignments. It allows professors to add and organize programming challenges, as well as grade them in an easy an contextual way.

Students can keep track of solved challenges, deadlines and grading comments. It's is also possible to code directly in the browser, which avoids the hassle of configuring a complete programming tool chain (if that is not part of the deal).

![progbot_screenshot](https://cloud.githubusercontent.com/assets/512405/9366740/7b359c50-468f-11e5-96d3-cab0e41cc239.png)

## Motivation

I tend to spend a significant amount of my time grading programming assignments. The problem is that the majority of that time is spent dealing with the workflow of archaic grading tools that were never designed for programming assignments. I decided I could use all that wasted time in something useful, e.g. actually giving feedback to my student, so I wrote Progbot to help me.

## Installation

Clone the repo to your web document root (e.g. `/var/www/progbot`). Create a MySQL database and populate it with the content of [inc/resources/codebot.sql](https://github.com/Dovyski/Progbot/blob/master/inc/resources/codebot.sql). Finally change the file `inc/config.php` to fit your needs, like the database name/user/password. You're good to go!

## Contributors

If you liked the project and want to help, you are welcome! Submit pull requests or [open a new issue](https://github.com/Dovyski/Progbot/issues) describing your idea.

## License

Progbot is licensed under the MIT license.

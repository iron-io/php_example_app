Getting Started
===============

*Get your token and project_id*: Log in at http://www.iron.io to retrieve them. Your project_id will be found on the Projects page. Your tokens are in the API Tokens tab on the Account page.
*Create a config file*: Rename the sample_config.ini file in the worker directory to just be config.ini. Enter your token and project_id in the appropriate fields. You can enter the same token and project_id for both iron_mq and iron_worker. The query parameter under the twitter section defines the string you'll search for.
*Upload everything to your web server*: The entire package can be uploaded to your web server's public directory. In a production application, you'd want to make sure your config.ini file wasn't readable by the public, as it contains sensitive information. You can also run this on your own Mac or Linux machine with a basic installation of PHP 5.
*Make sure your web server has write access to the code directory*: The easiest way to do this is to execute `chmod 770` on the code directory.
*Load the website in your browser*: You should be able to just navigate to the index.php file to run the example.

Live Demo
=========

A live demo will be coming soon.

Credits
=======

The cookies plugin for jQuery, [jquery.cookie](https://github.com/carhartl/jquery-cookie) was used to handle cookies in Javascript.
The [jQuery doTimeout](http://benalman.com/projects/jquery-dotimeout-plugin/) was used to poll for worker status in the interface.

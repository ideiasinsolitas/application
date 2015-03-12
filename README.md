# application

Basic application stack

Comes bundled with memcached cache handler, monolog log handler and a PDO client. In order to build an application, extend AbstractApplication and use the initialize function to register services in the container and configure cache, log and whatever other services you might need. See ExampleApplication for a sample app.

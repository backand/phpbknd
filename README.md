Using Backand REST API With PHP
===============================

Using Backand REST API is a two step process:

1. Obtain the authorization token
2. Make GET/POST calls

In the sample PHP application, `api_calls.php`, we use `curl`.

Obtaining the Authorization Token
=================================

To get the token, use your username, password and app name. 
Make a `POST` call to the `TOKEN_URL`.
The response is a JSON object with fields `access_token` and `token_type`.

Making API GET/POST Calls
=========================

API calls use the `REST_URL`.

In both types of calls you need to set the `Authorization` and `AppName` headers as in the sample.

For `GET` calls by adding a query string to the url.

For `POST` calls send body parameters as JSON (using `json_decode`).

Running the Sample
==================

The sample obtains the authorization token, and then makes one GET call and one POST call.

You can run the sample from the command line using:

    php api_calls.php
	
Using HTTPClient
================

The file `httpful.php`, gives Httpful example calls, that follow the pattern of the `curl` calls.

To use it, install [Httpful](http://phphttpclient.com) using [Composer](https://getcomposer.org). 
We have included a `composer.json` file, so you have execute from the command line in the project folder, 

    php composer.phar install
    
Then include `bootstrap.php` as can be seen in the file.

You can run the sample from the command line using:

    php httpful.php
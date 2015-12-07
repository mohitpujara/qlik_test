# qlik_test
# REST API integration with AWS

1. Exposes a simple REST API that allows users to:

	a. Allows users to submit/post messages:
	
	Method = POST, URL = /api/index.php/messages
	
	Parameter = message(Required) -> string -> message data -> return 201 status code on success

	
	b. Lists received messages:
	
	Method = GET, URL = /api/index.php/messages
	
	Parameter = message(Required) -> integer -> ID -> return 200 status code on success
	
	
	c. Retrieves a specific message on demand, and determines if it is a palindrome:
	
	Method = GET, URL = /api/index.php/messages/<MSG_ID>
	
	Parameter = message(Required) -> integer -> ID -> return 200 status code on success
	
	
	d. Allows users to delete specific messages
	
	Method = DELETE, URL = /api/index.php/messages/<MSG_ID>
	
	Parameter = message(Required) -> integer -> ID -> return 200 status code on success
	
2. Creating the Application:

	This REST API application contains..
	
	/api
		/controller
			messages.php
		app_db.sql
		index.php
		
	In "index.php", I am identifying the "method" which are GET, POST and DELETE, and "request" which has URL information and message/user ID information.
	
	Similarly, "app_db.sql" is a database which contains "messages" table and it contains {'id', 'message', 'created_time', 'is_delete', 'delete_time'} attributes.
	
	In "controller" folder there is one file name "messages.php". This file contains model structure of GET, PUT and DELETE. In all models I'm fetching data from database and maintained error code if I found any errors.

	
3. REST API Documentation:

	Method			Description
	
	GET				A GET method (or GET request) is used to retrieve messages and/or retrieve a specific message on demand by using ID and determines if it is a palindrome or not. It should be used SOLELY for retrieving data and should not alter.

	POST			A POST method (or POST request) is used to create a message. For instance, when you want to add a new message but have no idea where to store it, you can use the POST method to post it to a URL and let the server decide the URL.

	DELETE			A DELETE method (or DELETE request) is used to delete a specific message using ID by a URL.
	
4. Sequence Diagram:

	(https://github.com/mohitpujara/qlik_test/api/sequence_diagrams/DELETE.png "GET Request")

5. Amazon AWS Information:

	Application IP: 52.25.79.15
	
	(For Ex. for access type "http://52.25.79.15/index.php/messages" to display all messages)
	
	Public DNS: ec2-52-25-79-15.us-west-2.compute.amazonaws.com
	
	(For Ex. for access type "http://ec2-52-25-79-15.us-west-2.compute.amazonaws.com/index.php/messages" to display all messages)

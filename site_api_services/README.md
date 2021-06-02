#Site API Services Module
=======

This module provides the functionality to alter admin site information form and also provide a rest API that 
accepts an API key for authentication of API consumer and a Node-id to get the content of that node.

#Prerequisite
============

1. Install the following modules for using rest API:-
	1.a RESTful Web Services
	1.b REST UI

	Note: Clear the Cache after installing the above modules.

#Installation
============

Once the module has been installed:-

1. Navigate to /admin/config/system/site-information
	(Configuration > Basic site settings through the administration panel) and
	update the `Site API Key` value.

2. Navigate to /admin/config/services/rest and enable "Api key rest resource" 
	(Configuration > Rest through the administration panel)

	2.a Navigate to /admin/people/permissions 
		Search for "RESTful Web Services", under that we can find "Access GET on Api key rest resource resource" and for this gives permission to "Anonymous User".
		( This permission is needed so that an Anonymous User with the Site Api key can access the API)

3. To access the Api, 

	3.a In any of the Rest client, 
		Select method - GET
		URL - <SiteUrl>/page_json/<SiteApiKey>/<NodeId>
		Example - http://localhost/page_json/FOOBAR12345/1
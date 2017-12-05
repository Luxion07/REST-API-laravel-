REST API

1. api/register - Register users
		
		input parameters:
			- name
			- email
			- password
			- c_password

2. api/login - Login users

		input parameters:
			- email
			- password

3. api/logout - Logout users

4. api/get-all-users - Get all users (no auth)

5. api/get-user - Get current user, who login

		input parameters:
			- token

6. api/update-user - Update current user , who login

		input parameters:
     	- name
     	- email
     	- password
     	- c_password
     	- image_source (update image field path)

7. api/{id}/like-user - Current user can like other (auth)

		input parameters:
			- token
			- id(Get)

8. api/get-user/{id}  - Show all info with likes by id (auth)

		input parameters:
			- token
			- id(Get)

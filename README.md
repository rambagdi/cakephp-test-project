## Get Started

This guide will walk you through the steps needed to get this project up and running on your local machine.

### Prerequisites

Before you begin, ensure you have the following installed:

- Docker
- Docker Compose

### Building the Docker Environment

Build and start the containers:

```
docker-compose up -d --build
```

### Installing Dependencies

```
docker-compose exec app sh
composer install
```

### Database Setup

Set up the database:

```
bin/cake migrations migrate
```

### Accessing the Application

The application should now be accessible at http://localhost:34251

## How to check

### Authentication

TODO: pls summarize how to check "Authentication" bahavior

### Article Management

TODO: pls summarize how to check "Article Management" bahavior

### Like Feature

TODO: pls summarize how to check "Like Feature" bahavior

### Accessing the Database Port

http://localhost:9001

### Accessing the Database Sql file

SQL: pls import sql file in mysql database and sql file (sample.sql) available in root folder

### Postman collection 

SQL: pls import postman collection api file in postman and postman file (apiTest.postman_collection.json) available in root folder

### api endpoints

### USER ALL API
1. api/users.json
   method = get
   header parameter =  Access-token

2. api/users.json 
   method = post  -> 
   body = {
	"email": "demo@gmail.com",
	"password": 123456
   },
   
3. api/users/2 
   method = put 
   header parameter =  Access-token
   body = {
	"email": "demo1@gmail.com",
	"password": 123456
   },

4. api/users/1 
   method = delete 
   header parameter =  Access-token,

5. api/login.json 
   method = post  -> body = {
	"email": "demo@gmail.com",
	"password": 123456
   },

5. api/logout.json 
   method = get 
   header parameter =  Access-token,


### ARTICLE ALL API
1. api/articles.json
   method = get
   header parameter =  Access-token,

2. api/articles.json, 
   method = post, 
   header parameter =  Access-token, 
   body = {
	"title": "CakePHP1",
	"body": "This is a CakePHP Development",
	"user_id": 2
   } 
   
3. api/articles/1 
    method = put 
    header parameter =  Access-token 
    body = {
	"title": "CakePHP1",
	"body": "This is a CakePHP Development",
	"user_id": 2
    },

4. api/articles/1 
    method = delete 
    header parameter =  Access-token,


### LIKE ALL API
1. api/likes.json 
   method = get 
   header parameter =  Access-token,

2. api/likes.json 
   method = post 
   header parameter =  Access-token 
   body = {
	"title": "CakePHP1",
	"body": "This is a CakePHP Development",
	"user_id": 2
   }


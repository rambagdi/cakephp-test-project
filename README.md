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

Login API will be used to authenticate the user. It accept user email, and password. If we have account with this detail we are generating a token and adding for this user in table, then we are sending response for this API with user detail and token. This token will be used to perform user based activity like managing arctile and like feature.

### Article Management

To manage the Arcticle, have created couple of endpoints to perform CRUD operation. Those endpoints are protected and accepts "Access-token" in header to authenticate the user.

### Like Feature


I have create API end point for like an article. Authorized user can like any article. Like count for article we will get in response of get articles API." (End points detail are listing below)

### Accessing the Database Port

http://localhost:9001

### Accessing the Database Sql file

SQL: pls import sql file in mysql database and sql file (sample.sql) "available in root folder"

### Postman collection 

SQL: pls import postman collection api file in postman and postman file (apiTest.postman_collection.json) "available in root folder"

######## api endpoints #########

### USER API

### Get all users (You can use it if require otherwise leave it)
1. api/users.json
   method: get
   header: Access-token

### New user registration API
2. api/users.json 
   method: post 
   body: {
	"email": "demo@gmail.com",
	"password": 123456
   }

### Update user Detail API  
3. api/users/2 
   method: put 
   header parameter =  Access-token
   body: {
	"email": "demo1@gmail.com",
	"password": 123456
   },

### Delete User API
4. api/users/1 
   method: delete 
   header: Access-token

### User login(Get auth token) API
5. api/login.json 
   method: post
   body: {
	"email": "demo@gmail.com",
	"password": 123456
   }

### User logout API
5. api/logout.json 
   method: get 
   header: Access-token


### ARTICLE API ###

### get current logged in user articles
1. api/articles.json
   method: get
   header: Access-token,


### Create new article
2. api/articles.json, 
   method: post, 
   header: Access-token, 
   body: {
	"title": "CakePHP1",
	"body": "This is a CakePHP Development"
   } 

### Update article
3. api/articles/:id
    method: put 
    header: Access-token 
    body: {
	"title": "CakePHP1",
	"body": "This is a CakePHP Development"
    },

### Delete aritlce
4. api/articles/:id
    method = delete 
    header parameter =  Access-token,

### All articles of all users   
5. api/articlesAll.json 
    method: get 
    header: Access-token


### LIKE API

### add like for article
1. api/likes.json 
   method: post 
   header: Access-token 
   body: {
    "article_id": 2
}


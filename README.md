# E-Commerce Api

## About
This repository contains an ecommerce api that provides endpoints for managing products, brands, and categories. It also enables the usage of JSON Web Tokens (JWT) for authentication

## Getting Started 
This guide assumed you have the following installed on your PC
### PHP 8.2+ <br>
### Composer

## Clone and navigate
##
    git clone git@github.com:Soburr/ECommerce-API.git <br>
    cd ECommerce-API

## Authentication
## POST 
- /login: Login to the API <br>
- Request Body: <br>
  { <br>
   "email": "user@example.com", <br>
   "password": "12345678" <br>
  }

  
- /register: Register to the API
- Request Body: <br>
  { <br>
   "name": "Jane Doe", <br>
   "email": "user@example.com", <br>
   "password": "12345678" <br>
  }

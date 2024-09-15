# E-Commerce Api

## About
This repository contains an ecommerce api that provides endpoints for managing products, brands, and categories. It also enables the usage of JSON Web Tokens (JWT) for authentication

## Getting Started 
This guide assumed you have the following installed on your PC
### PHP 8.2+
### Composer

## Clone and navigate
git clone git@github.com:Soburr/ECommerce-API.git
cd ECommerce-API

## Endpoints
## Authentication
## POST 
- /login: Login to the API
- Request Body:
  {
   "email": "user@example.com",
   "password": "12345678"
  }

  
- /register: Register to the API
- Request Body:
  {
   "name": "Jane Doe",
   "email": "user@example.com",
   "password": "12345678"
  }

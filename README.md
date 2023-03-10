## Description
This is an e-commerce store program that uses Laravel in conjuction with VueJS. Using API calls, you can create products and add them to the stores stock, which the user can add to their cart by clicking the cart icon. The user can see their cart by clicking the shopping bag in the top right corner. They can also see the subtotal, vat amount, and total price.

This project was made without using eloquent.

The user can add to their cart only a single product unit.

I used <a href="https://www.postman.com/">Postman</a> for the API calls.

## Requirements
* PHP version: 8.0
* MySQL version: 8.0.31
* Laravel 9

## Installation
1. Clone this repository

#### Backend
1. Run <code>$ composer install</code>
2. Rename ".env.example" to ".env" and enter the correct database information
3. Run <code>$ php artisan migrate </code>
4. Run <code>$ php artisan key:generate </code>
5. You can run the API with <code>$ php artisan serve </code>

#### Frontend
1. Change into the vue directory <code>$ cd ./vue </code>
2. Run <code>$ npm install </code>
3. You can run the developement server with <code>$ npm run dev </code>

## API
### Products
* Create a product:

    * HTTP Method: POST
    * URL: http://127.0.0.1:8000/api/v1/products
    * Request Body: <br>
    ####
        {
            "name": "",    
            "available": 0,
            "price": 0,    
            "vatRate": 0, 
            "imageUrl": "" 
        }
    
    
* Show all products:

    * HTTP Method: GET
    * URL: http://127.0.0.1:8000/api/v1/products
    
    
* Update a product:

    * HTTP Method: PUT
    * URL: http://127.0.0.1:8000/api/v1/products/id
    * Request Body: <br>
    ####
        {
            "name": "",    
            "available": 0,
            "price": 0,    
            "vatRate": 0, 
            "imageUrl": ""
        }
        
        
* Delete a product:

    * HTTP Method: DELETE
    * URL: http://127.0.0.1:8000/api/v1/products/id
    
    
* Show a product:

    * HTTP Method: GET
    * URL: http://127.0.0.1:8000/api/v1/products/id
##
### Stock
* Add a product to the stock:

    * HTTP Method: POST
    * URL: http://127.0.0.1:8000/api/v1/stock
    * Request Body: <br>
    ####
        {
            "productId": ""    
        }
        
        
* Show all products in stock:

    * HTTP Method: GET
    * URL: http://127.0.0.1:8000/api/v1/stock


* Remove a product from stock:

    * HTTP Method: DELETE
    * URL: http://127.0.0.1:8000/api/v1/products/id
##
### Cart
* Add a product to the cart:

    * HTTP Method: POST
    * URL: http://127.0.0.1:8000/api/v1/cart
    * Request Body: <br>
    ####
        {
            "productId": ""    
        }
      
      
* Show all products in the cart:

    * HTTP Method: GET
    * URL: http://127.0.0.1:8000/api/v1/cart


* Remove a product from the cart:

    * HTTP Method: GET
    * URL: http://127.0.0.1:8000/api/v1/cart
##
Note: Replace "id" in the URLs with the actual ID of the product.

## Demo
![](https://github.com/ricardsupenieks/Arkbauer/blob/main/demo.gif)

## Description
This is an e-commerce store program that uses Laravel in conjuction with VueJS. Using API calls, you can create products and add them to the stores stock, which the user can add to their cart by clicking the cart icon. The user can see their cart by clicking the shopping bag in the top right corner. They can also see the subtotal, vat amount, and total price. 

The user can add to their cart only a single product unit.

I used <a href="https://www.postman.com/">Postman</a> for the API calls.

## Requirements
* PHP version: 8.0
* MySQL version: 8.0.31
* Laravel 9

## Installation
1. Clone this repository
2. Run <code>$ composer install</code>
3. Run <code>$ npm install</code>
4. Rename ".env.example" to ".env" and enter the correct database information
5. Run <code>$ php artisan migrate </code>
6. Run <code>$ php artisan key:generate </code>
7. You can run the API with <code>$ php artisan serve </code>
8. Change into the vue directory <code>$ cd ./vue </code>
9. Run <code>$ npm install </code>
10. You can run the developement server with <code>$ npm run dev </code>

## API
### Products
* Create a product:

    * HTTP Method: POST
    * URL: http://127.0.0.1:8000/api/v1/products
    * Request Body: <br>
        <code>{
            "name": "",
            "available": 0,
            "price": 0,
            "vatRate": 0,
            "imageUrl": ""
        }</code>
    
* Show all products:

    * HTTP Method: GET
    * URL: http://127.0.0.1:8000/api/v1/products
    
* Update a product:

    * HTTP Method: PUT
    * URL: http://127.0.0.1:8000/api/v1/products/id
    * Request Body:
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
    
Note: Replace "id" in the URLs with the actual ID of the product.

## Demo
![](https://github.com/ricardsupenieks/Arkbauer/blob/main/demo.gif)

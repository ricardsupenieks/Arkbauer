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
3. Rename ".env.example" to ".env" and enter the correct database information
4. Run <code>$ php artisan migrate </code>
5. Run <code>$ php artisan key:generate </code>
6. You can run the API with <code>$ php artisan serve </code>
6. You can run the development website by changing into the vue directory <code>$ cd ./vue </code> and running <code>$ npm run dev</code>

## Demo


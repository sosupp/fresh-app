## In this README
1. The Task
2. Process
3. Solutions
4. How to test the solution

## The Task
To create a command line script which will read orders and customers data from an API and generate 
a CSV file following the schema below (one CSV row for each order item):

orderID, orderDate, orderItemID, orderItemName, orderItemQuantity, customerFirstName, 
customerLastName, customerAddress, customerCity, customerZipCode, customerEmail

## Process
Laravel was used for this. To accomplish this task three main activities were considered:
1. Setup a custom console command in laravel to run the script
2. Fetching and reading data from the three API endpoints provided (orders, items and customers)
3. Combining the three set of data using the relatatioship data exist between them because the end result is to retrieve columns of data spread across these three endpoints.

## Solution - Setting up the custom command script
2. For simplicity I used the closure commands instead of the full fledge class commands (provided by laravel)
3. The command signature used is #order:show 

## Solution - Fetching and Combining Data
1. I used the Http facade support from laravel to fetch the APIs and converted them to arrays (which are multi-dimentional) calling the json() method on each of the response. These were saved into $orders, $items and $customers arrays.
2. I created a combineData() function to combine the three sets of array based on existing relationships identified in the data. This resulted into one big array.
3. To retrieve the needed columns, I used nested foreach() to loop over the array to extract the specific details needed and saved that as a new simple index array saved as $newOrder
4. To Generate a CSV file, each item in the $newOrder is formatted into a string as comma separated and the file_puts_contents() function is used to write to the todays_order.csv file.

## How to test the solution
1. The main code is written in console.php which you can locate at routes/console.php
2. run the laravel artisan command: php artisan order:show (while you're in the project directory)
3. The generated csv file is named today_orders.csv located at the root directory. 


Thank you. 

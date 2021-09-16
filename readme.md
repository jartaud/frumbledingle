You've made it this far! But this is your next challenge!

## The Problem
Frumbledingle Corp is struggling with its warehouse management, and has been looking for a developer to help. You need to create a small management app for their inventory. Part of this has been done for you by the last developer they hired - it's your job to finish it. This will consist of the following:

### Data Operations
- Create/Read/Delete operations for all different models
- RESTful API routes for these operations
- Setting up relations between models

### Frontend Operations
- Set up VueJs components for the various pages (one of these has been done for you)
- The *categories* page **MUST** include the name of the relevant parent *category* in the table for each *category*, if there is one.
- The *items* page **MUST** include the name of the relevant *location* and *category* in the table for each *item*.
- The navigation links will tell you what pages need to work
- Use *axios* (included) to retrieve data via AJAX

### Other Considerations
- You do not need to include User Authentication in this application
- We should be able to *git clone* your project and run it; you must provide any additional instructions needed
- Any other **cool stuff** you want to add after completing the requirements here will be taken into consideration.

## Setup Instructions
- REQUIRED: `php`, `git`, `composer`, `postgresql`, `node`, `npm`
- `git clone` this repo
- Run `composer install`
- Make sure to set the database information your `.env` file
- Run `php artisan migrate`
- Host the app however you'd prefer, but use `npm run dev` or `npm run watch` to compile the Vue components

## The Data
The data for this application will be defined as below. Migrations have already been created to set up the tables for this data, but no data has been inserted. You will need to create your own database for this test.

### Locations
- Columns: ID, Name
- A *location* has many *items*

### Items
- Columns: ID, Name, Category ID, Location ID
- An *item* belongs to a *location* and a *category*

### Categories
- Columns: ID, Name, Parent ID
- A *category* has many *items*
- A *category* belongs to a parent *category*, though the parent may be null

## The Final Battle
After making the pages for individual models work, you will need to create a report page. This page must include a price input, and should give a list of all categories for each location (including the parent category name), and the number of items greater or equal to that price in that category/location pairing.

Example:

|Location|Parent Category|Category|Count|
|--|--|--|--|
|Frumbledingle Corp| |Widgets|1|
|Frumbledingle Corp|Cars|Chevrolet|2|
|Frumbledingle Corp|Cars|Nissan|3|
|Plupbuckle, Inc.| |Widgets|1|
|Plupbuckle, Inc.|Cars|Chevrolet|1|
|Plupbuckle, Inc.|Cars|Nissan|2|
|Plupbuckle, Inc.|Purses|Louis Vuitton|1|




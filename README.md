# priceRange
A random project where the user can specify a price within a range of date as many as he wants
This project has dependency injection pattern and MVC pattern

# Rules
- Records must not overlap their range of dates
- If records overlaps another one or others records those records should be deleted
- If records cross with another one  or other records those records need to be updated according to the new record range of date

# Operations

## Create and Update
Both operations update other records if the new one or update one cross with other records.
- First it looks if any record overlap with the new date range
- Then loop those records
- If any record has same price of the new or updated one then set the bigger range date to the new one then delete the old record
- else if any record overlaps delete the old record
- else if any record cross at the beginning or at the end of the date range update those values to not cross with the new record
- Insert/Update the new record

## Delete
As it names said it deletes a record according to the id provided, there is no special behavior

## Read
You can provide a filter, an array, if you want to search for a specific values otherwise it would return the whole table

## ReadOne
As it names said it return a single record according to the id provided

## Reset
Remove any records stored in the table

## Validate
As it names said it validates its properties and return any error if any

# How to use it
In any view you need to start all the objects that would be needed to the controller since it is responsible to run everything.
Before any call to a method in the controller you need to check if the controller doesn't have any error.

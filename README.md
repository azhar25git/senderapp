# Senderapp
# Task:
Download dataset from https://drive.google.com/file/d/1uTqJKUZMjQgHNJtXuOdDCpFM3dObjLBU/view?usp=sharing
Using Laravel, PostgreSQL, and Redis, implement a system that allows filtering the attached dataset by person's birth year, or birth month. or both.
Matching results must be cached in Redis for 60 seconds. Following requests for the same combination of filtering parameters (birth year, birth month) must not query database before cache expires. 
If user changes filter parameters, Redis cache for old results must be invalidated.
Design the database schema in a way that queries to PostgreSQL would not take longer than 250ms.
Display results to the user in a paginated table, with 20 rows per page. Pagination must retrieve data from Redis cache if it is available.

NOTE: Page number must not be a part of cache key. Instead, all rows from database that match filtering criteria (month, year) must be stored in Redis, and pagination should retrieve only the required rows from Redis.

An example on how the interface may look like can be found here: https://www.figma.com/file/CgzEuikiavWxnATzw8umdv/sender-(scratch)?node-id=904%3A2 

# Solution:
- A full docker container with all services run separately is done.
- To build project go to the project root folder and run the command 

``` docker-compose build && docker-compose up -d ```

- You need to migrate and import the database placed in  pgsql/test-data.sql to see the table and filter
- Visit the link http://localhost:8090/people in your browser and check the page and the data

# senderapp

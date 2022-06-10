# Coding Challenge - Lumen

This coding challenge has been created to evaluate the skills of a PHP developer. There are many right ways to solve the challenge; best practices and understanding will emerge organically.

## Challenge

The aim of this exercise is to implement a teaching session management API where users can schedule teaching sessions and assign books for the session.

The supplied codebase includes:

-   A bearer token authorization process
-   An artisan command to generate user accounts in the database
-   A books model and seeder for populating books in the database

The test is tiered with an increasingly difficult set of requirements. **Only the first tier is required** but solving all the tiers is encouraged.

### Tier one

-   Develop endpoints to get a specific session by ID and to create a new session. A session should belong to a particular user and should have the following attributes:
    -   An ID
    -   A name for the session
    -   A date the session will occur
-   Develop an endpoint to get all the user’s sessions. The results should be sorted from oldest to newest based on date provided.
-   Users should not be able to access sessions that belong to other users.

### Tier two

-   Develop an endpoint to assign one book to a given session. A session should be able to have multiple books assigned if this endpoint is called multiple times.
-   Include details of the assigned books in the response of tier one.

### Tier three

-   Add a filter to the endpoint that gets all sessions. If the filter is enabled, sessions that have occurred in the past should be included in the returned data. If the filter is not provided, the endpoint should by default return only sessions that occur in the future.

## Submission instructions

The solution should be implemented using PHP and Laravel Lumen using the supplied codebase.

Additional libraries may be included in the solution if needed.

Please clone this project into a private repository and invite ross.taylor@cengage.com for access and review. Alternatively, you may fork this repository and provide the completed solution as a pull request.

### Required Knowledge

-   PHP
-   Laravel/Lumen

### Installation

Refer to the `install.bash` installation script, or run the commands manually.

New user accounts can be created by running:

```bash
php artisan generate:user
```

To confirm everything is working, a `GET` request to the `auth/token_details` endpoint with a valid bearer token should return the token's username.

Run the provided unit tests.

```bash
./vendor/bin/phpunit
```

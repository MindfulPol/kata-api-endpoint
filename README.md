# 👚 Mytheresa Backend Engineer challenge explanation
We want you to implement a REST API endpoint that given a list of products, applies some discounts to them
and can be filtered.

Provide a single endpoint **GET /products**
- Products in the boots category have a 30% discount.
- The product with sku = 000003 has a 15% discount.
- When multiple discounts collide, the biggest discount must be applied
-  Can be filtered by category as a query string parameter
- (optional) Can be filtered by priceLessThan as a query string parameter, this filter applies before
  discounts are applied and will show products with prices lesser than or equal the value provided.
- Returns a list of Product with the given discounts applied when necessary
- Must return at most 5 elements. (The order does not matter)

## 🛠️ Tools & Dependencies
Stack of tools chosen to implement solution:
- **Symfony**, will take care of our application routing and automatic dependency injection.
- **Doctrine** & **Doctrine Fixtures Bundle**, to setup and interact with the rdbms.
- **Docker** & **MakeFile**, will allow to setup the enviroment with 1 command.
- **PHPunit** & Api **Platform Test Case**, to perform acceptance and unit tests.
- **PHP CS Fixer**, to detect and fix coding standard problems.

## 🚀 Environment configuration
Host OS needs **Docker** & **Docker Compose**

If using Windows, you have to install [chocolatey.org](chocolatey.org) or use [Cygwin](https://cygwin.com/) to use the make command. Check out this [StackOverflow question](https://stackoverflow.com/questions/2532234/how-to-run-a-makefile-in-windows) for more explanations.

Automatic setup:

`make install`

This command will build and run the docker containers, install composer dependencies and load fixtures into the RDBMS.
(Might take a while since it also waits for mysql to be ready).

Alternatively you can run:

```
docker compose up --detach
docker compose exec php-fpm composer install --prefer-dist --no-progress --no-scripts --no-interaction
## Must wait for mysql service before next command (bin/wait-for-mysql.sh)
docker compose exec php-fpm bin/console doctrine:cache:clear-metadata
docker compose exec php-fpm bin/console doctrine:database:create --if-not-exists
docker compose exec php-fpm bin/console doctrine:schema:drop --force
docker compose exec php-fpm bin/console doctrine:schema:create
docker compose exec php-fpm bin/console doctrine:schema:validate
docker compose exec php-fpm bin/console doctrine:fixtures:load --no-interaction
```

## 🧑‍💻 Design decisions

This projects follows the **Hexagonal Architecture** pattern because it promotes a domain centric design. 
It also allows for an application to be developed and tested in isolation from its eventual run-time devices and databases. This results into agnostic infrastructure web applications that are easier to test, write and maintain.

Project Structure:
```
src
├── Application
│   ├── DiscountRulesApplier.php
│   ├── QueryStringParamDigestor.php
│   └── UseCase
│       └── GetProductListUseCase.php
├── DataFixtures
│   ├── AppFixtures.php
│   └── productFixtures.json
├── Domain
│   ├── Entity
│   │   ├── Price.php
│   │   └── Product.php
│   └── Repository
│       └── ProductRepositoryInterface.php
├── Infrastructure
│   ├── Entrypoint
│   │   └── Api
│   │       └── GetProductListController.php
│   └── Persistence
│       └── Doctrine
│           ├── EntityMap
│           └── ProductRepository.php
└── Kernel.php

```

#### Fixtures
Given that this challenge didn't explicitly require creating endpoints for the creation of Product entities, I decided to load said products via fixtures.

Loaded fixtures will be used for our Acceptance tests.

#### TDD Outside-in
Given that we know the interactions and collaborators upfront, we can start testing with an acceptance test which will force us to create all the components and code necessary to pass the acceptance test.

By following this we can assert that we're going to code our software project by:
- Writing an acceptance test for the next bit of functionality we need to add
- Write functional code(covered with unit tests) until test(acceptance) pass.
- Refactor code to make it well structured.
- Rinse and repeat.

For instance, in this project my first test was:
```php
public function test_get_products_must_return_at_most_5_elements()
{
    $client = self::createClient();
    $response = $client->request('GET', '/products', [
           'headers' => [
             'Accept' => 'application/json',
           ],
    ]);
    $products = json_decode($response->getContent(), true);

    $this->assertTrue(count($products) <= 5 && count($products) >= 1);
    $this->assertResponseIsSuccessful();
    $this->assertResponseHeaderSame('content-type', 'application/json');
}
```
This acceptance test forced me to create the routes for the given endpoint, creating and setting up a controller, creating and calling necessary useCase, and so on...
(writing the unit/functional tests for each new piece of code)

#### /GET products Efficiency

Efficiency of our endpoint could be improved. As of this iteration, the discounts are applied when you call the endpoint.

For example, if we were to iterate our project, we could improve it by moving the service applying the discounts elsewhere. For example once a discount is created/product is saved.

We would be able to achieve it relatively fast given that the code applying the discounts isn't coupled. It's a service recieving an array of products that will return the same array with the discounts applied.
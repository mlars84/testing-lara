# Testing Laravel

- phpunit 4 methods
    - see()
    - click()
    - see()
    - seePageIs()

- Good to isolate tests between Acceptance and Unit

- When you write your tests, as much as possible, they should look like documentation. Should give whoever is reading them a good example of how you interact and use this.

## Unit vs Feature
[Hand Dryer gfy](https://gfycat.com/HotOrangeCoypu)

- The hand dryer and trash can both individually do their job correctly (they represent your classes, and you test them with unit tests).

- But when you put them together something breaks unexpectedtly. And to test that you write feature tests that will, instead of testing a single small aspect of your app, try to mimic what happens when a user actually tries to use your app

## Acceptance / Functional / Feature tests
- slower, since they're testing more things. written from the user's perspective. They ensure that the system is functioning as users are expecting it to.

## Unit tests

- written from a programmers perspective. They are made to ensure that a particular method (or a unit) of a class performs a set of specific tasks.

- assertEquals() 
- assertCount() : example - $this->assertCount(2, $orders->products());
- The setUp() and tearDown() template methods are run once for each test method (and on fresh instances) of the test case class.

- /** @test */ annotation to let phpunit know it's a test and you can leave off test before method name ie testProductHasAName can be productHasAName or product_has_a_name

## Testing Eloquent models / integration tests

- put pieces together and make sure they interact correctly
- Given: set up the world. Given this world exists - have these records in the DB, etc. 
- When: i execute this action, 
- Then: what do I expect to happen

- Always make sure that every test assumes the same world : Make sure the DB looks the same.

### Database Transations

`use Illuminate\Foundation\Testing\DatabaseTransactions;`: Begins new DB transaction and then rolls it back, so you're never actually committing or persisting it directly to DB. Then every test starts from scratch.

- when you write tests for your eloquent models, you will put them in tests/Integration/models. 
- Wanna make sure you use DatabaseTransactions for each test

## Set up Testing Database

- add a testing DB to config/database.php:
```
'sqlite_testing' => [
    'driver' => 'sqlite',
    'database' => env('DB_DATABASE', database_path('testing.sqlite')),
    'prefix' => '',
],
```
- $ touch database/testing.sqlite
- $ php artisan migrate --database sqlite_testing
- add `<env name="DB_CONNECTION" value="sqlite_testing"/>` to phpunit.xml file

## Testing Collaborators

`./vendor/bin/phpunit --filter test_name_here` to pick a specific test to run


## Regression Testing

reproduces a bug you found
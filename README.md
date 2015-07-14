# [PHP] DataMunger
A small set of helper methods and chainable class to make data munging and transformation simple, perhaps even fun!

The interface always returns ```$this```, making the class chainable (aka "fluent"). All data is modified and stored in ```$this->data``` for each subsequent method call. Using ```$this->getData()``` will get you what you need.

See tests and source for details and usage.

## Testing
To run tests, you must have [PHPUnit](https://phpunit.de/) installed. Once setup, you can simply call `make`, and it will run all required tests, otherwise you can call phpunit directly: `phpunit .`

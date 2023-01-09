# fetch 
> sample wrap for curl request

## Install & Dependence

- php unit

## To run test

  ```text
  composer test
  ```

## Usage

```php
  $httpRequest = new HttpRequest();
  $response = $httpRequest->set_base_url('https://jsonplaceholder.typicode.com')
    ->set_headers(['Content-Type' => 'application/json'])
    ->get('/todos');
  // or
  $httpRequest = new HttpRequest();
  $httpRequest->set_base_url('https://jsonplaceholder.typicode.com');
  $httpRequest->set_headers(['Content-Type' => 'application/json']);
  $response = $httpRequest->get('/todos');
````
## Directory structure

```tree
|—— .gitignore
|—— src
|—— composer.json
|—— composer.lock
|—— developer
|—— LICENSE
|—— phpunit.xml
|—— tests
|    |—— Uint
|—— vendor
```

### Tested Platform

- software

  ```text
  OS: Ubuntu - Windows 10
  ```

## License

 > MIT

## Authors

- [Omar Hossam El-Din Kandil](https://www.linkedin.com/in/omar-hossameldin-kandil-74633a1bb/)

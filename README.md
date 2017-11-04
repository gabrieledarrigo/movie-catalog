# MovieCatalog
> What would you like to watch tonight? 

[![Build Status](https://travis-ci.org/gabrieledarrigo/movie-catalog.svg?branch=master)](https://travis-ci.org/gabrieledarrigo/movie-catalog)

## Description

_MovieCatalog_ is a very basic micro service that expose 5000 movies metadata, based on a csv subset that can be found on
[Kaggle](https://www.kaggle.com/tmdb/tmdb-movie-metadata).  

The data structure was simplified and exported into a _MySQL_ dump that is restored every time the application starts.

## (Irrational) Architecture

_MovieCatalog_ architecture is very simple and is organized in this way:

### Persistence

The application layer that handle the connection with the database through an adapter.  
Raw data is transformed into domain objects by the _Mapper_ Layer.  
To perform database operation `\PDO` was the privileged choice for its simplicity.

### Domain

The core domain context is inside this package.  
It holds the definition of two basic domain models, `Movie` and `Genre`, and the relative repositories which acts as a collection 
of objects for each other component external to the Domain package.  

This layer does not use any framework or library with the exception of `Doctrine\Common\Collections\ArrayCollection` that is
was chosen in substitution of plain PHP arrays to represent collections of objects.


### Container

This package contains the definition of a very simple dependency injection container that implements the 
[PSR-11](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-11-container.md) interface.

### Application

The application layer expose movies metadata on the HTTP medium.  
This layer use few _Symfony_ components, like `symfony/routing`, `symfony/http-foundation`, and `symfony/http-kernel` in order
to abstract the most common web application behaviors (like routing, request and response abstraction and so on) and to avoid to write to reinvent the wheel.

### Dependency Injection

Each layer define a `Provider` class that is responsible to define the package dependencies through the `Container` class.  

`Provider` class is the *only* place where `Container` class is injected as a dependency and actually used as a _Service Locator_; every other _MovieCatalog_ component define
its dependencies through the constructor.

## Getting started

### Prerequisites:

To run _MovieCatalog_ you need [Docker](https://www.docker.com/community-edition), [PHP 7.1](http://php.net/downloads.php) 
and [Composer](https://getcomposer.org/doc/00-intro.md) to run the application.

### Installation and run

Clone the repository and install all application's dependencies:

    $ composer install

Unit tests can be launched with:

	$ composer run test

Run the application:

	$ composer run start
	
Enjoy!


### What to improve

There are a lots of places where _MovieCatalog_ can be improved.  
Error handling in `Application` is really elementary and can be refactored in a proper class.  
The same applies to the routes definition in `ApplicationProvider`;  
a system where application's routes and controller's mapping are defined in a _routes.yml_ configuration file will be incredibly better.

The database configuration that is hardcoded into `StorageProvider` must be placed into a configuration file and loaded
selectively based on the environment where the application runs, probably with a `YmlReader` class that can be reused to load
the _routes.yml_ above mentioned.  

The dependency injection container system and all the Provider classes are really primitive (but works well for now : ) ) 
and can obviously be improved.

The pagination logic is in fact only the computation of the offset, and no information are given to the consumer on the total number of
page, the prev/next page links etc.

Saying that, there are probably a tons of other improvements that can be applied to _MovieCatalog_, but to be honest it's late,
and I'm quite hungry!

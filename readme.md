# Skeleton MVC (Simple php mirco-framework)
`NOTE: Currently not ready for use`

For small and simple projects, Consist of:

* MVC Architecture
* Simple Routing
* Twig Templating
* *Features coming*

## Architecture

Sekeleton MVC uses MVC architecture as name suggest. MVC stands for Model-View-Controller.
[Model-view-controller - Wikipedia](https://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller)
```
Model:
The central component of the pattern. It is the application's dynamic data structure, independent of the user interface. It directly manages the data, logic and rules of the application.

View:
Any representation of information such as a chart, diagram or table. Multiple views of the same information are possible, such as a bar chart for management and a tabular view for accountants.

Controller:
Accepts input and converts it to commands for the model or view.
``` 

## Lifecycle

* User hits url ex: - `example.com/shop/show-shoes/`
* Every request is sent to `index.php` file
* `index.php` files requires autoload(Composer) and global helpers(More on this later).
* $app instance is requested from Core\Skeleton::getInstance() and User Configuration class is provided as parameter
* As you can see Skeleton class is singleton hence if instance already exists it will be returned otherwise new will be created.
    * Now inside Skeleton class while creating new instance Request instance is created.
    * Request is passed down to Router class to handle.
    * Router class invokes appropriate Controllers method in the above case
    App\ShopController's showShoes method and passes it Request instance and arguments from url in this case none.
    * Controller is where your magic lives lets say you're fetching users list from DB and displaying it. In this case User Model will handle all data fecthing and will return you a list and you can call view function and pass it users list. You can iterate over list in view and display as you want.
    * view method returns a Response instance which you can return from controller.
    * Now we are back at router class which will return response back.
    * Now we are in Skeleton class which will assign response to property.
    * Now in `index.php`  sendResponse() is called on $app instance which sends appropriate headers and status code alongside with content which is sent back to browser. 

Now you understand how framework handle this all. Below is Documentation for each class and some examples to get you started on development.

## Directory Structure

- `YourApp`
    - `App`: Your code
        - `Controllers`: All Controllers
        - `Model`: All Models
        - `View`: All views
        - `Config.php`: User config class
    - `Core`: Framework's code
    - `public`: Exposed to the web
        - `index.php`: App's starting point
        - `.htaccess`: Reroutes all request to index.php
        - `assets`: All static assets like css/js lives here
    - `storage`: Compiled views, uploaded documents, etc.
    - `vendor`: Composer's download of required libraries

## Configuration
Altough most framework follows convetion over configuration user configuration is required for DB params and view path, etc.

User configuration lives inside your App directory in Config Class.
Opening this file you'ld see Config class extends BaseConfig(\Core\Config) which is internally defined in Skeleton.
Most of all configuration are const parmas some might be static methods.

This class is documented through comments so check it and you'll be able to figure out all configuration by yourself.

## Routing
For routing conventions are used over configurations for ex:.


Imagine want to show post of 3 id route would look something like this

`example.com/user-post/show-photos/3/paris`

Above example have
* example.com : base url 
* user-post : UserPostController controller (CamelCase with Controller name appended) 
* showPhotos : showPhotos method (studlyCaps)
* 3, paris : anything after method name are passed as an argument to the method

so above controller class will look like
```php
<?php

namespace App\Controllers;

use Core\Request; 

class UserPost {

    public function showPhotos(Request $request, $id, $location) {
        # $id= 3 and $location= paris
        return view('photos/show.twig', [
            'id' => $id,
            'location' => 'paris'
        ]);
    }
}

```

But you may ask what about /, /about, etc. routes?

These routes are automatically routed to default_controller(can be changed in Config) default is SiteController and / action is default to index method which can be changed in config also.

You can also notice ```Core\Request``` object being passed as first argument always. It contains various helpers for request(more info in Request section).


## Request

Request is treated as object. It will passed by deafault to every controller's method as first Argument and other params will be passed after it in the sequence. ex:


For URL `example.com/user-post/show-photos/3/paris`
```php
<?php

namespace App\Controllers;

use Core\Request; 

class UserPost {

    public function showPhotos(Request $request, $id, $location) {
        # $id= 3 and $location= paris
        return view('photos/show.twig', [
            'id' => $id,
            'location' => 'paris'
        ]);
    }
}

```


Here are some handy methods provided by Rquest Object to you.
```php
/* Check Method of request */
$request->isGet();
$request->isPost();

/* 
How to get superglobals

These methods if provided returns specific field or entire array if no parameters are passed.
    
return value is value of the field or if is does not exists null
*/
$request->query('field'); // For GET
$request->input('field'); // For POST
$request->server('field'); // For SERVER
```

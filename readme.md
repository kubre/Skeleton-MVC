# Skeleton MVC (Simple php mvc starter template)
`NOTE: Currently not ready for use`

Simple starter template for small projects.
Consist of:

* Simple Routing
* Twig Templating
* MVC Architecture

How to use:

## Routing
Routing is determined implicitly so you don't have to specify every single routes. How this works? for ex:.


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

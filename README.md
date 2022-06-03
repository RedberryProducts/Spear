### Spear

* [Introduction](#introduction)
* [Getting Started](#getting-started)
* [How To Use](#how-to-use)
* [Available Languages](#available-languages)
* [How does Spear work?](#how-does-spear-work)


#### Introduction
Spear is a convinient PHP package that allows you to execute code in many different languages. It's simple to use and easy to install.

#### Getting Started
To get started using `Spear` you need to install it as a dependency in your php project using composer:
```bash
  composer require redberry/spear
```

and you're good to go 🙏

#### How to Use

Using `Spear` is a piece of cake procedure. you just need to instantiate `Spear` class and execute any available language code you'd like.
The key concepts of the `Spear` are:
* `Spear` class which does the coordination between different language handler and returning actual output.
* Handler - on `Spear` class you can choose desired handler. Choosing handler is same as choosing with which language you'd like the code to be executed
* Every handler returns the output which has three kinds of information: success output, error output, exit code

Let's see how would we implement handling node code without input:

```php
  <?php
  
  use Redberry\Spear\Facades\Spear;
  
  $nodeCode = "console.log('hello Spear!')";
  
  $data = Spear::node()->execute($nodeCode);
  
  dump($data->toArray());
  /**
   * [
   *  'result_code'   => 0,
   *  'error_message' => null,
   *  'output'        => 'hello Spear!',
   * ]
   */
```

Now, let's see how does it work with input:
```php
  <?php
  
  use Redberry\Spear\Facades\Spear;
  
  $nodeCode = <<<END
    let data = '';
    
    const solve = () => {
      data = data.trim();
      console.log(`hello, ${data}`);
    }
    
    process.stdin.on('data', c => data += c);
    process.stdin.on('end', solve);
   END;
  
  $data = Spear::node()->execute($nodeCode, 'Speeeear');
  
  dump($data->toArray());
  /**
   * [
   *  'result_code'   => 0,
   *  'error_message' => null,
   *  'output'        => 'hello, Speeeear',
   * ]
   */
```

#### Available Languages
There are variety of languages available with spear. Here's a listing:
* PHP 8.1
* Node 14
* C++
* Python 3
* Ruby 3
* Rust
* Go
* Java
* Perl

#### How does Spear work?
Under the hood the `Spear` utilizes docker to create containers according to the handler and the language we'd like to use. Spear creates fresh new container for each execution, let's the code execute in the container, gets the output and then destroys the container.
It's secure, flexibale and pretty amazing 😊

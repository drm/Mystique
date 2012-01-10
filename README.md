# Mystique: the PHP code analysis, generation, inspection and refactoring library #

Mystique aims to be a library that provides tools for easily inspection, analyzing, generating and refactoring PHP code.

The library consists of five separate loosely coupled components: the **parser**, the **compiler**, the **inspector**,
the **builder** and **refactoring**. Combining these components allow you to:

* Generate an AST from PHP source code without using reflection
* Refactor PHP code by writing code migration scripts
* Inspect code for certain (anti)patterns (static code analysis)
* Compile other formats into PHP code (code generation)
* Compile multiple PHP files into singles (code deflation)
* Compile annotations

## Examples ##
### Backward compatibility refactoring ###
If you wanted to release a new version of your library that breaks Backward Compatibility, you can provide scripts
to inspect code for "the old way" and provide refactoring tools for the new way.

### Upgrade refactoring ###
Upgrading your system to a new version of PHP, which in case of PHP5.3 could be cumbersome. For example, a set of
refactorings and inspections is available for converting your codebase from 5.2 to 5.3:

* Namespace refactoring: convert PEAR namespaces to PHP namespaces
* create_function() deprecation: convert all create_function() calls to equivalent closure definitions
* Inspect for deprecated usages

#### Example ####
The old version of the library had a class named Foo which had a constructor that accepted three arguments. The new
version accepts only one argument, which contains the same options as an array. You can apply a refactoring by using
the following refactoring plugin:

````
class FooNowAcceptsOnlyArrays implements \Mystique\Refactoring\Refactoring {
    function finder() {
        return new \Mystique\PHP\Inspector\Usage('\Foo', '__construct');
    }


    function apply(Node $n) {
        if($n instanceof Call) {
            $expr = new Call(new Name('array'));
            $expr->setParameters($n->getParameters());
            $n->setParameters(new ExprList(array($expr)));
        }
    }
}

````

$ mystique refactor -p FooWasRenamedToBar
Warning: searching for usages is not necessarily safe. Use -v to show possibly false positive usages
1 usage found:
my/lib/FooConsumer.php, line 12:     "        $foo = new Foo(new Bar(), new Baz(), new Qux());"

1 refactoring available:
my/lib/FooConsumer.php, line 12:     "        $foo = new Foo(array('baz' => new Bar(), 'bar' => new Baz(), 'qux' => new Qux()));"

$ mystique refactor -d FooNowAcceptsOnlyArrays
Warning: searching for usages is not necessarily safe. Use -v to show possibly false positive usages
1 usage found:
my/lib/FooConsumer.php, line 12:     "        $foo = new Foo(new Bar(), new Baz(), new Qux());"

1 refactoring available:
my/lib/FooConsumer.php, line 12:     "        $foo = new Foo(array('baz' => new Bar(), 'bar' => new Baz(), 'qux' => new Qux()));"

The refactoring can generate a diff, or apply the changes directly.

### Aspect Oriented Programming and Mixins ###
By providing annotations to pieces of code, you can add Aspect Oriented programming to PHP, which it natively does
not support. It does so by Mixins, which simply process the classes, functions or methods you apply the mixin to.
Mystique comes with a set of default mixins that handle the dirty work for you. Of course, you can apply multiple
mixins to a single method or class, they just get chained iteratively.

/**
 * @Mystique\Processor\Mixin(\My\Aspect)
 */

The doccomments, as far as Mystique goes, aren't part of the PHP syntax. They are, however, inspectable through the
syntax tree, since comments are included in the syntax tree by default. As such, mixins can be applied to
any node you wish. This means, for example, that you can effectively have conditional compilation for code that would
be superfluous in production environments.

// @If(!getenv('DEBUG'))
if (!is_string($arg1)) {
    throw new InvalidArgumentException("Argument 1 must be a string");
}

The entire if construct will be removed if the environment variable DEBUG is not set.

// @If(function_exists('mb_strlen'))
return mb_strlen($str);
// @If(!function_exists('mb_strlen'))
return strlen($str);

### Optimization ###

#### Inline annotation ####
    /**
     * @Inline
     */
    function myFunc($i) {
        return $i * anotherFunc();
    }

    $a = myFunc(20);

The Inline annotation will optimize this to:

    $a = 20 * anotherFunc();

Note that extra optimization passes are needed to inline nested calls, because the optimizer does not handle recursive
dependency resolution.

#### Constant expression evaluation ####

Mystique can detect constant expressions. They can be evaluated at compile-time:

    echo 10 * 20;

Will result in:

    echo 200;

### Auto-compilation ###
Since Mystique provides its own autoloader, there is a simple way to divert from standard autoloading and have the
autoloader take care of class compilation for you. This way, you don't have to worry about compiling code before running
it, the autoloader will take care of that. There are two default strategies available for auto-compilation.

#### One-on-one compilation ####
Mystique comes with one on one compilation, which puts the compiled versions of files directly next to the source files.
You can define your own renaming algorithm, but by default the .php suffix is replaced by a .mystique.php
suffix. The autoloader works nice with this, so it detects whether a compiled file is available, and if not, recompiles
it using your own compiler directives. You can also choose a separate folder for compiled versions of files. This
is the preferred method for development environments as it eases debugging.

#### Packed compilation ####
The other strategy is compiling one or multiple files which will be included even before autoloading. This way, the
autoloader only gets triggered for classes that Mystique did not handle. The downside is that you need to take car of
invalidating the compiled versions of the files.

### Smart code introspection ###
Mystique supports intelligent code inspection, which can infer types based on operator usage, type hints, instantiation,
return types and docblock annotations. For example:

````
function a() {
    return new MyClass();
}

function b() {
    return a();
}

$c = b();
$c->call();
````
Searching for usages of MyClass::call will result in reporting the call to $c->call() in the sample code above.

## Roadmap ##

The following things are on the roadmap:

* Base the parser structure on a BNF grammar
* Generate other languages from PHP files
* Generate PHP code from other languages

### Compatibility ###

As open source is all about collaboration, in the future

* phpcpd (PHP Copy/Paste detector)
* phpcs (PHP CodeSniffer)
* docblox (Generating documentation)
* Twig (Compilation of Twig Templates)
* Symfony2 (Compilation of the DI Container)
* Symfony2 (Metadata implementation)

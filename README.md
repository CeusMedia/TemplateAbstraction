# Template Abstraction

[![Package version](http://img.shields.io/packagist/v/ceus-media/template-abstraction.svg?style=flat-square)](https://packagist.org/packages/ceus-media/template-abstraction)
[![Monthly downloads](http://img.shields.io/packagist/dt/ceus-media/template-abstraction.svg?style=flat-square)](https://packagist.org/packages/ceus-media/template-abstraction)
[![License](https://img.shields.io/packagist/l/ceus-media/template-abstraction.svg?style=flat-square)](https://packagist.org/packages/ceus-media/template-abstraction)

This library provides an abstraction layer for template engines.

## Goals

Goals of this abstraction layer:

1. to be able to replace the currently used template engine within your project
2. to be able to use several template engines side by side within your project
3. allow several developers of your project to use the template engine they like
4. improve performance of your project by using different template engines for different tasks
5. avoid/ignore template engine file extensions (like .pug or .haml)
6. autodetect which template engine to use

To reach these goals, this library provides a clean interface to render templates using several available template engines in the background.

## Template Engines

Currently supported template engines are:

- **Twig** [Package][Twig_Package] [Source][Twig_Source] [Page][Twig_Page]
- **Dwoo** [Package][Dwoo_Package] [Source][Dwoo_Source]
- **Smarty** [Package][Smarty_Package] [Source][Smarty_Source]
- **PHPTAL** [Package][PHPTAL_Package] [Source][PHPTAL_Source]
- **phpHaml** [Package][PHPHaml_Package] [Source][PHPHaml_Source] [Page][PHPHaml_Page]
- **Latte** [Package][Latte_Package] [Source][Latte_Source] [Page][Latte_Page]
- **Mustache** [Package][Mustache_Package] [Source][Mustache_Source] [Page][Mustache_Page]
- **H2O** [Package][H2O_Package] [Source][H2O_Source]

Upcoming versions will also support:

- Pug / Jade

## Todos

### Add Template Engines

#### Add phug

phug = pug-php = ex-jade

- [Package](https://packagist.org/packages/pug-php/pug)
- [Source](https://github.com/pug-php/pug)
- [Page](https://www.phug-lang.com/)

#### Add tale-pug

tale-pug = ex-tale-jade = ex-jade

- [Package](https://packagist.org/packages/talesoft/tale-pug)
- [Source](https://github.com/Talesoft/tale-pug)
- [Page](http://jade.talesoft.codes/)

----
[Twig_Package]: https://packagist.org/packages/twig/twig
[Twig_Source]: https://github.com/twigphp/Twig
[Twig_Page]: https://twig.symfony.com/doc/3.x/templates.html

[Smarty_Package]: https://packagist.org/packages/smarty/smarty
[Smarty_Source]: https://github.com/smarty-php/smarty

[Dwoo_Package]: https://packagist.org/packages/dwoo/dwoo
[Dwoo_Source]: https://github.com/dwoo-project/dwoo

[PHPTAL_Package]: https://packagist.org/packages/phptal/phptal
[PHPTAL_Source]: https://github.com/phptal/PHPTAL

[Latte_Package]: https://packagist.org/packages/latte/latte
[Latte_Source]: https://github.com/nette/latte
[Latte_Page]: https://latte.nette.org/

[Mustache_Package]: https://packagist.org/packages/mustache/mustache
[Mustache_Source]: https://github.com/bobthecow/mustache.php
[Mustache_Page]:https://github.com/bobthecow/mustache.php

[H2O_Package]: https://packagist.org/packages/blesta/h2o
[H2O_Source]: https://github.com/blesta/h2o

[PHPHaml_Package]: https://packagist.org/packages/kriss0r/php-haml
[PHPHaml_Source]: https://github.com/kriss0r/phphaml
[PHPHaml_Page]: http://phphaml.sourceforge.net/

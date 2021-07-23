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

- Twig
- Dwoo
- Smarty
- PHPTAL
- phpHaml
- Latte
- Mustache

Upcoming versions will also support:

- Pug / Jade

## Todos

### Add Template Engines

#### Add phug

phug = pug-php = ex-jade

- https://github.com/pug-php/pug
- https://www.phug-lang.com/

#### Add tale-pug

tale-pug = ex-tale-jade = ex-jade

- https://packagist.org/packages/talesoft/tale-pug
- http://jade.talesoft.codes/

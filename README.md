# TemplateAbstraction

[![Package version](http://img.shields.io/packagist/v/ceus-media/template-abstraction.svg?style=flat-square)](https://packagist.org/packages/ceus-media/template-abstraction)
[![Monthly downloads](http://img.shields.io/packagist/dt/ceus-media/template-abstraction.svg?style=flat-square)](https://packagist.org/packages/ceus-media/template-abstraction)
[![License](https://img.shields.io/packagist/l/ceus-media/template-abstraction.svg?style=flat-square)](https://packagist.org/packages/ceus-media/template-abstraction)


## Todos

### Add jade

- https://packagist.org/packages/ronan-gloo/jadephp
- https://packagist.org/packages/opendena/jade.php

### Add haml

- http://phphaml.sourceforge.net/

### Add latte

- Source: https://latte.nette.org/
- Tutorial: https://latte.nette.org/en/guide

Installation:
````
composer require latte/latte
````

Example:
````
$latte = new Latte\Engine;
$latte->setTempDirectory( '/path/to/tempdir' );

$parameters = [
	'items' => ['one', 'two', 'three'],
];

$latte->render( 'template.latte', $parameters );
$html = $latte->renderToString( 'template.latte', $parameters );

````

Template:
````
<ul n:if="$items">
	<li n:foreach="$items as $item">{$item|capitalize}</li>
</ul>
````




<?php
( @include '../vendor/autoload.php' ) or die( 'Please use composer to install required packages.' );

ini_set( 'display_errors', 'On' );
error_reporting( E_ALL );
ob_start();

try{
	/*
	print '<h3>PHP code</h3>
<pre>
$dataUser = (object) array(
    "name" => (object) array(
        "first" => "John",
        "last"  => "Doe"
    )
);

$factory	= new \CeusMedia\TemplateAbstraction\Factory();
$factory->setTemplatePath("templates/");

$template	= $factory->getTemplate("template.tmpl");
$template->addData("user", $dataUser);
$template->addData("engine", $factory->identifyType("template.tmpl"));

print $template->render();
</pre>';
*/
	$dataUser	= (object) [
		'name'	=> (object) [
			'first'	=> 'John',
			'last'	=> 'Doe',
		]
	];

	$factory	= new \CeusMedia\TemplateAbstraction\Factory();
	$factory->setTemplatePath( 'templates/' );

	$files		= array(
//		'CMC'				=> 'hello.cmc.html',
//		'Dwoo'				=> 'hello.dwoo.html',
//		'Latte'				=> 'hello.latte.html',
		'Mustache'			=> 'hello.mustache.html',
		'PHPTAL'			=> 'hello.phptal.html',
		'Smarty'			=> 'hello.smarty.html',
		'TemplateEngine'	=> 'hello.ste.html',
		'Twig'				=> 'hello.twig.html',
	);

	foreach( $files as $engineLabel => $file ){
		$template	= $factory->getTemplate( $file );
		$template->addData( 'user', $dataUser );
		$template->addData( 'engine', $factory->identifyType( $file ) );
		$key	= uniqid( 'engine-' );

		try{
			$content	= $template->render();
		}
		catch( \Exception $e ){
			$content	= \UI_HTML_Exception_View::render( $e );
		}

		print '<h3>'.$engineLabel.'</h3>
<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#'.$key.'-template" data-toggle="tab">Template Code</a></li>
		<li><a href="#'.$key.'-source" data-toggle="tab">HTML Source</a></li>
		<li><a href="#'.$key.'-output" data-toggle="tab">HTML Output</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="'.$key.'-template">
			<pre>'.htmlentities( \FS_File_Reader::load( 'templates/'.$file ) ).'</pre>
		</div>
		<div class="tab-pane" id="'.$key.'-source">
			<pre>'.htmlentities( $template->render() ).'</pre>
		</div>
		<div class="tab-pane" id="'.$key.'-output">
			<pre>'.$content.'</pre>
		</div>
	</div>
</div>';
	}

/*	$template	= $factory->getTemplate("hello.dwoo.html");
	$type		= $factory->identifyType("hello.dwoo.html");
	$template->addData('user', $dataUser);
	$template->addData('type', $type);
	print '<h3>Dwoo</h3><pre>'.$template->render().'</pre>';
*/
}
catch( Exception $e ){
	UI_HTML_Exception_Page::display( $e );
	exit;
}

$body = '
<div class="container">
	<h1 class="muted">CeusMedia Component Demo</h1>
	<h2>TemplateAbstraction</h2>
	'.ob_get_clean().'
</div>';

$page	= new UI_HTML_PageFrame();
$page->addStylesheet( 'https://cdn.ceusmedia.de/css/bootstrap.min.css' );
$page->addJavaScript( 'https://cdn.ceusmedia.de/js/jquery/1.10.2.min.js' );
$page->addJavaScript( 'https://cdn.ceusmedia.de/js/bootstrap.min.js' );
$page->addBody( $body );
print $page->build();

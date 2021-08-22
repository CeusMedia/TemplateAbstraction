<?php
( @include '../vendor/autoload.php' ) or die( 'Please use composer to install required packages.' );

ini_set( 'display_errors', 'On' );
error_reporting( E_ALL );
ob_start();
new UI_DevOutput();

$examples	= [];
try{
	$dataUserArray	= (array) array(
		'name'	=> (array) array(
			'first'	=> 'John',
			'last'	=> 'Doe',
		)
	);

	$dataUserObject	= (object) array(
		'name'	=> (object) array(
			'first'	=> 'John',
			'last'	=> 'Doe',
		)
	);

	$environment	= new \CeusMedia\TemplateAbstraction\Environment();
	$environment->registerEnginesSupportedByLibrary();

	$factory		= $environment->getFactory();
	$factory->setTemplatePath( 'templates/' );
//	$factory->setCachePath( 'templates/cache/' );

	$files	= array(
		'PHP'				=> 'hello.php',
		'Smarty'			=> 'hello.smarty.html',
		'Dwoo'				=> 'hello.dwoo.html',
		'Mustache'			=> 'hello.mustache.html',
		'Twig'				=> 'hello.twig.html',
		'Latte'				=> 'hello.latte.html',
		'PHPTAL'			=> 'hello.phptal.html',
		'TemplateEngine'	=> 'hello.ste.html',
		'phpHaml'			=> 'hello.phphaml.html',
		'H2O'				=> 'hello.h2o.html',
	);

	foreach( $files as $engine => $file ){
		$template	= $factory->getTemplate($file);
		$template->addData('userArray', $dataUserArray);
		$template->addData('userObject', $dataUserObject);
		$template->addData('engine', $factory->identifyType($file));
		$key	= uniqid('engine-'.$engine);
		try{
			$content	= $template->render();
		}
		catch( \Exception $e ){
			$content	= \UI_HTML_Exception_View::render( $e );
		}
		$examples[]	= '<h3>'.$engine.'</h3>

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
			<pre>'.htmlentities( $content ).'</pre>
		</div>
		<div class="tab-pane" id="'.$key.'-output">
			'.$content.'
		</div>
	</div>
</div>';
	}
}
catch( Exception $e ){
	UI_HTML_Exception_Page::display( $e );
	exit;
}

$body = '
<div class="container">
	<h1 class="muted">CeusMedia Component Demo</h1>
	<h2>TemplateAbstraction</h2>
	'.join( $examples ).'
</div>';

$page	= new UI_HTML_PageFrame();
$page->addStylesheet( 'https://cdn.ceusmedia.de/css/bootstrap.min.css' );
$page->addJavaScript( 'https://cdn.ceusmedia.de/js/jquery/1.10.2.min.js' );
$page->addJavaScript( 'https://cdn.ceusmedia.de/js/bootstrap.min.js' );
$page->addBody( $body );
print $page->build();

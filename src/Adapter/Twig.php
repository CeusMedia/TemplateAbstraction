<?php
/**
 *	Adapter for Twig template engine.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction_Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2021 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 *	@see			https://twig.symfony.com/doc/3.x/templates.html Templating Guide
 */
namespace CeusMedia\TemplateAbstraction\Adapter;

use CeusMedia\TemplateAbstraction\AdapterAbstract;
use Twig\Environment as TwigEnvironment;
use Twig\Loader\FilesystemLoader as TwigFilesystemLoader;
use Twig\Loader\ArrayLoader as TwigArrayLoader;
use Twig\TemplateWrapper as TwigTemplateWrapper;
use RuntimeException;

use function md5;
use function microtime;
use function uniqid;

/**
 *	Adapter for Twig template engine.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction_Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2021 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
class Twig extends AdapterAbstract
{
	/**	@var	TwigTemplateWrapper|null	$template	Twig template instance, if a source has been set */
	protected $template	= NULL;

	/**
	 *	Returns rendered template content.
	 *	@access		public
	 *	@return		string
	 *	@throws		RuntimeException		if no source has been set
	 */
	public function render(): string
	{
		if( is_null( $this->template ) )
			throw new RuntimeException( 'No source set' );
		$content	= $this->template->render( $this->data );
		$content	= $this->removeTypeIdentifier( $content );
		return $content;
	}

	public function setSourceFile( string $fileName ): AdapterAbstract
	{
		$loader = new TwigFilesystemLoader( $this->pathSource );
		$env = new TwigEnvironment( $loader, [
			'cache'	=> $this->pathCache,
		] );
		$this->template = $env->load( $fileName );
		return $this;
	}

	public function setSourceString( string $string ): AdapterAbstract
	{
		$id = uniqid( md5( microtime(TRUE ) ) );
		$loader = new TwigArrayLoader( [
			$id => $string,
		] );
		$env = new TwigEnvironment($loader, [
			'cache'	=> $this->pathCache,
		] );
		$this->template = $env->load( $id );
		return $this;
	}
}

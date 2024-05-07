<?php
declare(strict_types=1);

/**
 *	Adapter for Twig template engine.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction_Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2022 Christian Würker
 *	@license		https://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 *	@see			https://twig.symfony.com/doc/3.x/templates.html Templating Guide
 */

namespace CeusMedia\TemplateAbstraction\Adapter;

use CeusMedia\TemplateAbstraction\AdapterAbstract;
use CeusMedia\TemplateAbstraction\AdapterInterface;
use CeusMedia\TemplateEngine\Template as TemplateEngine;
use Twig\Environment as TwigEnvironment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
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
 *	@copyright		2010-2022 Christian Würker
 *	@license		https://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
class Twig extends AdapterAbstract
{
	/**	@var	TwigTemplateWrapper|NULL		$sourceString	Twig template instance, if a source has been set */
	protected ?TwigTemplateWrapper $template	= NULL;

	/**
	 *	@return		bool
	 */
	public function isPackageInstalled(): bool
	{
		return class_exists( TwigFilesystemLoader::class );
	}

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
		return $this->removeTypeIdentifier( $content );
	}

	/**
	 *	@param		string		$fileName
	 *	@return		AdapterInterface
	 *	@throws		SyntaxError
	 *	@throws		RuntimeError
	 *	@throws		LoaderError
	 */
	public function setSourceFile(string $fileName ): AdapterInterface
	{
		$loader = new TwigFilesystemLoader( $this->sourcePath );
		$env = new TwigEnvironment( $loader, [
			'cache'	=> $this->pathCache,
		] );
		$this->template = $env->load( $fileName );
		return $this;
	}

	/**
	 *	@param		string		$string
	 *	@return		AdapterInterface
	 *	@throws		SyntaxError
	 *	@throws		RuntimeError
	 *	@throws		LoaderError
	 */
	public function setSourceString(string $string ): AdapterInterface
	{
		$id = uniqid( md5( (string) microtime(TRUE ) ) );
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

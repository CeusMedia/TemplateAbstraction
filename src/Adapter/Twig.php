<?php
/**
 *	Adapter for Twig template engine.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction_Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2021 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
namespace CeusMedia\TemplateAbstraction\Adapter;

use CeusMedia\TemplateAbstraction\AdapterAbstract;
use Twig\Environment as TwigEnvironment;
use Twig\Loader\FilesystemLoader as TwigFilesystemLoader;
use Twig\Loader\ArrayLoader as TwigArrayLoader;

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
	protected $template	= NULL;

	/**
	 *	Returns rendered template content.
	 *	@access		public
	 *	@return		string
	 */
	public function render(): string
	{
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

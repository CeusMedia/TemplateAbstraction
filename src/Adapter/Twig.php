<?php
/**
 *	Adapter for Twig template engine.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction_Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2020 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
namespace CeusMedia\TemplateAbstraction\Adapter;

use CeusMedia\TemplateAbstraction\AdapterAbstract;

/**
 *	Adapter for Twig template engine.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction_Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2020 Christian Würker
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
		$loader = new \Twig_Loader_Filesystem( $this->pathSource );
		$env = new \Twig_Environment($loader, array(
		  'cache' => $this->pathCache,
		));
		$this->template = $env->loadTemplate( $fileName );
		return $this;
	}

	public function setSourceString( string $string ): AdapterAbstract
	{
		$loader = new \Twig_Loader_String();
		$env = new \Twig_Environment($loader, array(
		  'cache' => $this->pathCache,
		));
		$this->template = $env->loadTemplate( $string );
		return $this;
	}
}

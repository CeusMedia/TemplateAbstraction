<?php
/**
 *	Adapter for Twig template engine.
 *	@category		cmModules
 *	@package		TEA.Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@version		$Id$
 */
#require_once 'Twig/trunk/Autoloader.php';
CMC_Loader::registerNew( 'php', 'Twig', '/var/www/lib/Twig/trunk/' );
/**
 *	Adapter for Twig template engine.
 *	@category		cmModules
 *	@package		TEA.Adapter
 *	@extends		CMM_TEA_Adapter_Abstract
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@version		$Id$
 */
class CMM_TEA_Adapter_Twig extends CMM_TEA_Adapter_Abstract {

	protected $template	= NULL;

	/**
	 *	Returns rendered template content.
	 *	@access		public
	 *	@return		string
	 */
	public function render(){
		$content	= $this->template->render( $this->data );
		$content	= $this->removeTypeIdentifier( $content );
		return $content;
	}

	public function setSourceFile( $fileName ){
		$loader = new Twig_Loader_Filesystem( $this->pathSource );
		$env = new Twig_Environment($loader, array(
		#  'cache' => $this->pathCache,
		));
		$this->template = $env->loadTemplate( $fileName );
	}

	public function setSourceString( $string ){
		$loader = new Twig_Loader_String();
		$env = new Twig_Environment($loader, array(
		#  'cache' => $this->pathTemplateCache,
		));
		$this->template = $env->loadTemplate( $string );
	}
}
?>
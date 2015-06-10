<?php
/**
 *	Adapter for Twig template engine.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction_Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2015 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
namespace CeusMedia\TemplateAbstraction\Adapter;
/**
 *	Adapter for Twig template engine.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction_Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2015 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
class Twig extends \CeusMedia\TemplateAbstraction\AdapterAbstract {

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
		$loader = new \Twig_Loader_Filesystem( $this->pathSource );
		$env = new \Twig_Environment($loader, array(
		  'cache' => $this->pathCache,
		));
		$this->template = $env->loadTemplate( $fileName );
	}

	public function setSourceString( $string ){
		$loader = new \Twig_Loader_String();
		$env = new \Twig_Environment($loader, array(
		  'cache' => $this->pathCache,
		));
		$this->template = $env->loadTemplate( $string );
	}
}
?>

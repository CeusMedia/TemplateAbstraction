<?php
/**
 *	Adapter for Smarty template engine.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction_Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2015 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
/**
 *	Adapter for Smarty template engine.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction_Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2015 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
class Smarty extends \CeusMedia\TemplateAbstraction\AdapterAbstract {

	/**
	 *	Returns rendered template content.
	 *	@access		public
	 *	@return		string
	 */
	public function render(){
		if( !$this->fileSource )
			throw new \RuntimeException( 'No source file set' );
		$template	= new \Smarty();
		$template->template_dir	= $this->pathSource;
		$template->compile_dir	= $this->pathCache;
		foreach( $this->data as $key => $value )
			$template->assign( $key, $value );
		$content	= $template->fetch( $this->fileSource );
		$content	= $this->removeTypeIdentifier( $content );
		return $content;
	}
}
?>

<?php
/**
 *	Adapter for Dwoo template engine.
 *	@category		cmModules
 *	@package		TEA.Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@version		$Id$
 */
/**
 *	Adapter for Dwoo template engine.
 *	@category		cmModules
 *	@package		TEA.Adapter
 *	@extends		CMM_TEA_Adapter_Abstract
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@version		$Id$
 */
class CMM_TEA_Adapter_Dwoo extends CMM_TEA_Adapter_Abstract {

	/**
	 *	Returns rendered template content.
	 *	@access		public
	 *	@return		string
	 */
	public function render(){	
		if( !$this->fileSource )
			throw new RuntimeException( 'No source file set' );
		$template	= new Dwoo();
		$template->setCacheDir( $this->pathCache );
		$template->setCompileDir( $this->pathCompile );
		$content	= $template->get( $this->pathSource.$this->fileSource, $this->data );
		$content	= $this->removeTypeIdentifier( $content );
		return $content;
	}
}
?>
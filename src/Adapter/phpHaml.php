<?php
/**
 *	Adapter for phpHaml template engine.
 *	@category		cmModules
 *	@package		TEA.Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@version		$Id$
 */
/**
 *	Adapter for phpHaml template engine.
 *	@category		cmModules
 *	@package		TEA.Adapter
 *	@extends		CMM_TEA_Adapter_Abstract
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@version		$Id$
 */
class CMM_TEA_Adapter_phpHaml extends CMM_TEA_Adapter_Abstract {

	/**
	 *	Returns rendered template content.
	 *	@access		public
	 *	@return		string
	 */
	public function render(){
		if( !$this->fileSource )
			throw new RuntimeException( 'No source file set' );
		$engine	= new HamlParser( $this->pathSource, $this->pathCache );
		$engine->append( $this->data );
		$content	= $engine->fetch( $this->fileSource );
		$content	= $this->removeTypeIdentifier( $content );
		return $content;
	}
}
?>
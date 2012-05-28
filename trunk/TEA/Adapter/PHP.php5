<?php
/**
 *	Adapter for using PHP as template engine.
 *	@category		cmModules
 *	@package		TEA.Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@since			0.3.0
 *	@version		$Id$
 */
/**
 *	Adapter for using PHP as template engine.
 *	Attention: You need to escape displayed contents by yourself!
 *	@category		cmModules
 *	@package		TEA.Adapter
 *	@extends		Template_Adapter_Abstract
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@since			0.3.0
 *	@version		$Id$
 */
class CMM_TEA_Adapter_PHP extends CMM_TEA_Adapter_Abstract {

	/**
	 *	Returns rendered template content.
	 *	@access		public
	 *	@return		string
	 */
	public function render(){
		$pathName	= $this->pathSource.$this->fileSource;
		extract( $this->data );
		ob_start();
		$result		= require( $pathName );
		$buffer		= ob_get_clean();
		$content	= $result;
		if( trim( $buffer ) )
		{
			if( is_string( $content ) )
				$content	= $buffer;
			else
				throw new RuntimeException( $buffer );
		}
		$content	= $this->removeTypeIdentifier( $content );
		return $content;
	}
}
?>

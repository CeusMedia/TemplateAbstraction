<?php
/**
 *	Adapter for PHPTAL template engine.
 *	@category		cmModules
 *	@package		TEA.Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@version		$Id$
 */
CMC_Loader::registerNew( 'php', NULL, '/var/www/lib/phptal/1.2.1/classes/' );
/**
 *	Adapter for PHPTAL template engine.
 *	@category		cmModules
 *	@package		TEA.Adapter
 *	@extends		CMM_TEA_Adapter_Abstract
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@version		$Id$
 */
class CMM_TEA_Adapter_PHPTAL extends CMM_TEA_Adapter_Abstract {

	/**
	 *	Returns rendered template content.
	 *	@access		public
	 *	@return		string
	 */
	public function render(){
		if( !$this->fileSource )
			throw new RuntimeException( 'No source file set' );
		$template	= new PHPTAL();
		foreach( $this->data as $key => $value )
			$template->set( $key, $value );
		$template->setTemplate( $this->pathSource.$this->fileSource );
		$content	= $template->execute();
		$content	= $this->removeTypeIdentifier( $content );
		return $content;
	}
}
?>
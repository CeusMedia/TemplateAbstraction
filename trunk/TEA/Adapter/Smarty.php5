<?php
/**
 *	Adapter for Smarty template engine.
 *	@category		cmModules
 *	@package		TEA.Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@version		$Id$
 */
require_once '/var/www/lib/Smarty/3.0rc3/libs/Smarty.class.php';
/**
 *	Adapter for Smarty template engine.
 *	@category		cmModules
 *	@package		TEA.Adapter
 *	@extends		CMM_TEA_Adapter_Abstract
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@version		$Id$
 */
class CMM_TEA_Adapter_Smarty extends CMM_TEA_Adapter_Abstract {

	/**
	 *	Returns rendered template content.
	 *	@access		public
	 *	@return		string
	 */
	public function render(){
		if( !$this->fileSource )
			throw new RuntimeException( 'No source file set' );
		$template	= new Smarty();
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
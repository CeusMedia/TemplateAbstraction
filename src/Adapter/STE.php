<?php
/**
 *	Adapter for cmModules template engine "STE".
 *	@category		cmModules
 *	@package		TEA.Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@version		$Id$
 */
/**
 *	Adapter for cmModules template engine "STE".
 *	@category		cmModules
 *	@package		TEA.Adapter
 *	@extends		Template_Adapter_Abstract
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@version		$Id$
 */
class CMM_TEA_Adapter_STE extends CMM_TEA_Adapter_Abstract {

	/**
	 *	Returns rendered template content.
	 *	@access		public
	 *	@return		string
	 */
	public function render(){
		CMM_STE_Template::setTemplatePath( $this->pathSource );
		$template	= new CMM_STE_Template();
		$template->setTemplate( $this->fileSource );
		$template->add( $this->data );
		$content	= $template->create();
		$content	= $this->removeTypeIdentifier( $content );
		return $content;
	}
}
?>
<?php
/**
 *	Adapter for cmClasses template engine.
 *	@category	dev
 *	@package	TEA.Adapter
 *	@author		Christian Würker <christian.wuerker@ceusmedia.de>
 *	@version	$Id: CMC.php5 1311 2010-07-28 22:03:07Z christian.wuerker $
 */
/**
 *	Adapter for cmClasses template engine.
 *	@category	dev
 *	@package	TEA.Adapter
 *	@extends	Template_Adapter_Abstract
 *	@author		Christian Würker <christian.wuerker@ceusmedia.de>
 *	@version	$Id: CMC.php5 1311 2010-07-28 22:03:07Z christian.wuerker $
 */
class TEA_Adapter_CMC extends TEA_Adapter_Abstract {

	/**
	 *	Returns rendered template content.
	 *	@access		public
	 *	@return		string
	 */
	public function render(){
		$pathName	= $this->pathSource.$this->fileSource;
		$content	= UI_Template::render( $pathName, $this->data );
		$content	= $this->removeTypeIdentifier( $content );
		return $content;
	}
}
?>
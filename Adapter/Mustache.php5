<?php
/**
 *	Adapter for Mustache template engine.
 *	@category		cmModules
 *	@package		TEA.Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@version		$Id$
 */
/**
 *	Adapter for Mustache template engine.
 *	@category		cmModules
 *	@package		TEA.Adapter
 *	@extends		CMM_TEA_Adapter_Abstract
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@version		$Id$
 */
class CMM_TEA_Adapter_Mustache extends CMM_TEA_Adapter_Abstract {

	/**
	 *	Returns rendered template content.
	 *	@access		public
	 *	@return		string
	 */
	public function render(){
		$settings	= $this->factory->getEngineSettings( 'Mustache' );
		$options	= array();
		if( isset( $settings['extension'] ) )
			$options['extension']	= $settings['extension'];
		$engine		= new Mustache_Engine;
		$loader		= new Mustache_Loader_FilesystemLoader( $this->pathSource, $options );
		$engine->setLoader( $loader );
		$template	= $engine->loadTemplate( $this->fileSource );
		return $template->render( $this->data );
	}
}
?>

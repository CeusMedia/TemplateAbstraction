<?php
/**
 *	Adapter for Mustache template engine.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction_Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2020 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
namespace CeusMedia\TemplateAbstraction\Adapter;

use CeusMedia\TemplateAbstraction\AdapterAbstract;

/**
 *	Adapter for Mustache template engine.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction_Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2020 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
class Mustache extends AdapterAbstract
{
	/**
	 *	Returns rendered template content.
	 *	@access		public
	 *	@return		string
	 */
	public function render(): string
	{
//		$settings	= (object) $this->factory->getEngineSettings( 'Mustache' );
		$options	= array(
			'extension'	=> empty( $settings->extension ) ? 'html' : $settings->extension
		);
		$engine		= new \Mustache_Engine;
		$loader		= new \Mustache_Loader_FilesystemLoader( $this->pathSource, $options );
		$engine->setLoader( $loader );
		$template	= $engine->loadTemplate( $this->fileSource );
		$content	= $template->render( $this->data );
		$content	= $this->removeTypeIdentifier( $content );
		return $content;
	}
}

<?php
/**
 *	Adapter for H2O template engine.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction_Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2021 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 *	@see			https://github.com/blesta/h2o @GitHub
 */
namespace CeusMedia\TemplateAbstraction\Adapter;

use CeusMedia\TemplateAbstraction\AdapterAbstract;
use H2o as H2oEngine;
use RuntimeException;

/**
 *	Adapter for H2O template engine.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction_Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2021 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
class H2O extends AdapterAbstract
{
	/**
	 *	Returns rendered template content.
	 *	@access		public
	 *	@return		string
	 *	@throws		RuntimeException		if no source file has been set
	 */
	public function render(): string
	{
		if( NULL === $this->fileSource )
			throw new RuntimeException( 'No source file set' );
		$options	= [
			'searchpath'	=> $this->pathSource,
			'cache_dir'		=> $this->pathCache,
		];

		$engine		= new H2oEngine( $this->fileSource, $options );
		$content	= $engine->render( $this->data );
		$content	= $this->removeTypeIdentifier( $content );
		return $content;
	}
}

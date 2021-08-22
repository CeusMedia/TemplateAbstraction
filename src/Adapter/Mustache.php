<?php
/**
 *	Adapter for Mustache template engine.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction_Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2021 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 *	@see			http://mustache.github.io/mustache.5.html Templating Guide
 *	@see			https://github.com/bobthecow/mustache.php @GitHub
 */
namespace CeusMedia\TemplateAbstraction\Adapter;

use CeusMedia\TemplateAbstraction\AdapterAbstract;
use Mustache_Engine as MustacheEngine;
use Mustache_Loader_FilesystemLoader as MustacheFilesystemLoader;
use RuntimeException;

/**
 *	Adapter for Mustache template engine.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction_Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2021 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
class Mustache extends AdapterAbstract
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
//		$settings	= (object) $this->factory->getEngineSettings( 'Mustache' );
		$options	= array(
			'extension'	=> /*isset( $settings->extension ) ? $settings->extension : */'html',
		);
		$engine		= new MustacheEngine();
		$loader		= new MustacheFilesystemLoader( $this->pathSource, $options );
		$engine->setLoader( $loader );
		$template	= $engine->loadTemplate( $this->fileSource );
		$content	= $template->render( $this->data );
		$content	= $this->removeTypeIdentifier( $content );
		return $content;
	}
}

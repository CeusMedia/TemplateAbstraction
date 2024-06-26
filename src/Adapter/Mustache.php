<?php
declare(strict_types=1);

/**
 *	Adapter for Mustache template engine.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction_Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2022 Christian Würker
 *	@license		https://www.gnu.org/licenses/gpl-3.0.txt GPL 3
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
 *	@copyright		2010-2022 Christian Würker
 *	@license		https://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
class Mustache extends AdapterAbstract
{
	/**
	 *	@return		bool
	 */
	public function isPackageInstalled(): bool
	{
		return class_exists( MustacheEngine::class );
	}

	/**
	 *	Returns rendered template content.
	 *	@access		public
	 *	@return		string
	 *	@throws		RuntimeException		if no source file has been set
	 */
	public function render(): string
	{
		if( NULL === $this->sourceFile )
			throw new RuntimeException( 'No source file set' );
//		$settings	= (object) $this->factory->getEngineSettings( 'Mustache' );
//		$options	= ['extension' => $settings->extension ?: 'html'];
		$options	= ['extension' => 'html'];
		$engine		= new MustacheEngine();
		$loader		= new MustacheFilesystemLoader( $this->sourcePath, $options );
		$engine->setLoader( $loader );
		$template	= $engine->loadTemplate( $this->sourceFile );
		$content	= $template->render( $this->data );
		return $this->removeTypeIdentifier( $content );
	}
}

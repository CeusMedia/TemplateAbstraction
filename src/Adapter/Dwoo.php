<?php
/** @noinspection PhpMultipleClassDeclarationsInspection */

declare(strict_types=1);

/**
 *	Adapter for Dwoo template engine.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction_Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2021 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 *	@see			https://dwoo.org/documentation/v1.3/dwoo-for-designers.html Templating Guide
 */

namespace CeusMedia\TemplateAbstraction\Adapter;

use CeusMedia\TemplateAbstraction\AdapterAbstract;
use Dwoo\Core as DwooEngine;
use Exception;
use RuntimeException;

/**
 *	Adapter for Dwoo template engine.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction_Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2021 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
class Dwoo extends AdapterAbstract
{
	/**
	 *	@return		bool
	 */
	public function isPackageInstalled(): bool
	{
		return class_exists( DwooEngine::class );
	}

	/**
	 *	Returns rendered template content.
	 *	@access		public
	 *	@return		string
	 *	@throws		RuntimeException		if no source file has been set
	 *	@throws		Exception				if Dwoo Core failed to render template
	 */
	public function render(): string
	{
		if( NULL === $this->sourceFile )
			throw new RuntimeException( 'No source file set' );
		$template	= new DwooEngine();
		$template->setCacheDir( $this->pathCache );
		$template->setCompileDir( $this->pathCompile );
		$content	= $template->get( $this->sourcePath.$this->sourceFile, $this->data );
		if( !is_string( $content ) )
			throw new RuntimeException( 'Dwoo Core failed to render template' );
		return $this->removeTypeIdentifier( $content );
	}
}

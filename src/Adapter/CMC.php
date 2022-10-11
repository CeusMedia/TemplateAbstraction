<?php
/** @noinspection PhpUnused */
/** @noinspection PhpMultipleClassDeclarationsInspection */

declare(strict_types=1);

/**
 *	Adapter for cmClasses template engine.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction_Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2021 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */

namespace CeusMedia\TemplateAbstraction\Adapter;

use CeusMedia\Common\UI\Template;
use CeusMedia\TemplateAbstraction\AdapterAbstract;
use RuntimeException;

/**
 *	Adapter for cmClasses template engine.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction_Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2021 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
class CMC extends AdapterAbstract
{
	/**
	 *	@return		bool
	 */
	public function isPackageInstalled(): bool
	{
		return class_exists( Template::class );
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
		$pathName	= $this->sourcePath.$this->sourceFile;
		$content	= Template::render( $pathName, $this->data );
		return $this->removeTypeIdentifier( $content );
	}
}

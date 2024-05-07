<?php
declare(strict_types=1);

/**
 *	Adapter for Latte template engine.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction_Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2022 Christian Würker
 *	@license		https://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 *	@see			https://latte.nette.org/en/syntax Templating Guide
 *	@see			https://github.com/nette/latte @GitHub
 */

namespace CeusMedia\TemplateAbstraction\Adapter;

use CeusMedia\TemplateAbstraction\AdapterAbstract;
use Latte\Engine as LatteEngine;
use RuntimeException;

/**
 *	Adapter for Latte template engine.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction_Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2022 Christian Würker
 *	@license		https://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
class Latte extends AdapterAbstract
{
	/**
	 *	@return		bool
	 */
	public function isPackageInstalled(): bool
	{
		return class_exists( LatteEngine::class );
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
		$latte		= new LatteEngine();
		$latte->setTempDirectory( $this->pathCache );
		$content	= $latte->renderToString( $this->sourcePath.$this->sourceFile, $this->data );
		return $this->removeTypeIdentifier( $content );
	}
}

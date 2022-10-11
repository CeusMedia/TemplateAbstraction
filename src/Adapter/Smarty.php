<?php
declare(strict_types=1);

/**
 *	Adapter for Smarty template engine.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction_Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2021 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */

namespace CeusMedia\TemplateAbstraction\Adapter;

use CeusMedia\TemplateAbstraction\AdapterAbstract;
use Exception;
use RuntimeException;
use Smarty as SmartyEngine;

/**
 *	Adapter for Smarty template engine.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction_Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2021 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
class Smarty extends AdapterAbstract
{
	/**
	 *	@return		bool
	 */
	public function isPackageInstalled(): bool
	{
		return class_exists( SmartyEngine::class );
	}

	/**
	 *	Returns rendered template content.
	 *	@access		public
	 *	@return		string
	 *	@throws		RuntimeException		if no source file has been set
	 *	@throws		Exception				if Smarty failed to render template
	 */
	public function render(): string
	{
		if( NULL === $this->sourceFile )
			throw new RuntimeException( 'No source file set' );
		$template	= new SmartyEngine();
		$template->setTemplateDir( $this->sourcePath );
		$template->setCompileDir( $this->pathCache );
		foreach( $this->data as $key => $value )
			$template->assign( $key, $value );
		$content	= $template->fetch( $this->sourceFile );
		return $this->removeTypeIdentifier( $content );
	}
}

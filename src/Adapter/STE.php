<?php
/** @noinspection PhpUnused */

declare(strict_types=1);

/**
 *	Adapter for cmModules template engine "STE".
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction_Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2021 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */

namespace CeusMedia\TemplateAbstraction\Adapter;

use CeusMedia\TemplateAbstraction\AdapterAbstract;
use CeusMedia\TemplateEngine\Template as TemplateEngineTemplate;
use RuntimeException;


/**
 *	Adapter for cmModules template engine "STE".
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction_Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2021 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
class STE extends AdapterAbstract
{
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
		TemplateEngineTemplate::setTemplatePath( $this->sourcePath );
		$template	= new TemplateEngineTemplate();
		$template->setTemplate( $this->sourceFile );
		$template->add( $this->data );
		$content	= $template->render();
		return $this->removeTypeIdentifier( $content );
	}
}

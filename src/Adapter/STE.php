<?php
/**
 *	Adapter for cmModules template engine "STE".
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
 *	Adapter for cmModules template engine "STE".
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction_Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2020 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
class STE extends AdapterAbstract
{
	/**
	 *	Returns rendered template content.
	 *	@access		public
	 *	@return		string
	 */
	public function render(): string
	{
		\CeusMedia\TemplateEngine\Template::setTemplatePath( $this->pathSource );
		$template	= new \CeusMedia\TemplateEngine\Template();
		$template->setTemplate( $this->fileSource );
		$template->add( $this->data );
		$content	= $template->render();
		$content	= $this->removeTypeIdentifier( $content );
		return $content;
	}
}

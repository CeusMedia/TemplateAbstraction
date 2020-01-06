<?php
/**
 *	Adapter for Dwoo template engine.
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
 *	Adapter for Dwoo template engine.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction_Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2020 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
class Dwoo extends AdapterAbstract
{
	/**
	 *	Returns rendered template content.
	 *	@access		public
	 *	@return		string
	 */
	public function render(): string
	{
		if( !$this->fileSource )
			throw new \RuntimeException( 'No source file set' );
		$template	= new \Dwoo\Core();
		$template->setCacheDir( $this->pathCache );
		$template->setCompileDir( $this->pathCompile );
		$content	= $template->get( $this->pathSource.$this->fileSource, $this->data );
		$content	= $this->removeTypeIdentifier( $content );
		return $content;
	}
}

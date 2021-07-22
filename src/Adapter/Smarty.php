<?php
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
	 *	Returns rendered template content.
	 *	@access		public
	 *	@return		string
	 *	@throws		\RuntimeException		if no source file has been set
	 */
	public function render(): string
	{
		if( NULL === $this->fileSource )
			throw new \RuntimeException( 'No source file set' );
		$template	= new \Smarty();
		$template->setTemplateDir( $this->pathSource );
		$template->setCompileDir( $this->pathCache );
		foreach( $this->data as $key => $value )
			$template->assign( $key, $value );
		$content	= $template->fetch( $this->fileSource );
		$content	= $this->removeTypeIdentifier( $content );
		return $content;
	}
}

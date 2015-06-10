<?php
/**
 *	Adapter for PHPTAL template engine.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction_Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2015 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
namespace CeusMedia\TemplateAbstraction\Adapter;
/**
 *	Adapter for PHPTAL template engine.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction_Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2015 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
class PHPTAL extends \CeusMedia\TemplateAbstraction\AdapterAbstract {

	/**
	 *	Returns rendered template content.
	 *	@access		public
	 *	@return		string
	 */
	public function render(){
		if( !$this->fileSource )
			throw new \RuntimeException( 'No source file set' );
		$template	= new \PHPTAL();
		foreach( $this->data as $key => $value )
			$template->set( $key, $value );
		$template->setTemplate( $this->pathSource.$this->fileSource );
		$content	= $template->execute();
		$content	= $this->removeTypeIdentifier( $content );
		return $content;
	}
}
?>

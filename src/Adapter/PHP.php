<?php
/**
 *	Adapter for using PHP as template engine.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction_Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2015 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
namespace CeusMedia\TemplateAbstraction\Adapter;
/**
 *	Adapter for using PHP as template engine.
 *	Attention: You need to escape displayed contents by yourself!
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction_Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2015 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
class PHP extends \CeusMedia\TemplateAbstraction\AdapterAbstract {

	/**
	 *	Returns rendered template content.
	 *	@access		public
	 *	@return		string
	 */
	public function render(){
		extract( $this->data );
		ob_start();
		$result		= require( $this->pathSource.$this->fileSource );
		$buffer		= ob_get_clean();
		$content	= $result;
		if( trim( $buffer ) )
		{
			if( is_string( $content ) )
				$content	= $buffer;
			else
				throw new \RuntimeException( $buffer );
		}
		$content	= $this->removeTypeIdentifier( $content );
		return $content;
	}
}
?>

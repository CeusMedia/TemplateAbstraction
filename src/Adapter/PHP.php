<?php
/**
 *	Adapter for using PHP as template engine.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction_Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2021 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
namespace CeusMedia\TemplateAbstraction\Adapter;

use CeusMedia\TemplateAbstraction\AdapterAbstract;
use FS_File_Reader as FileReader;
use RuntimeException;

/**
 *	Adapter for using PHP as template engine.
 *	Attention: You need to escape displayed contents by yourself!
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction_Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2021 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
class PHP extends AdapterAbstract
{
	/**
	 *	Returns rendered template content.
	 *	@access		public
	 *	@return		string
	 *	@throws		RuntimeException				if not file source is set
	 *	@throws		RuntimeException				if set file source is not existing
	 *	@throws		RuntimeException				if set file source is not readable
	 *	@throws		RuntimeException				if errors occurred during template execution
	 */
	public function render(): string
	{
		if( NULL === $this->fileSource )
			throw new RuntimeException( 'No source file set' );
		$filePath	= $this->pathSource.$this->fileSource;
		$file		= new FileReader( $filePath, TRUE );

		extract( $this->data );
		ob_start();
		$result		= include( $filePath );
		$buffer		= ob_get_clean();

		if( 1 === $result ){
			$content	= $buffer;
		}
		else{
			$content	= $result;
			if( strlen( trim( (string) $buffer ) ) > 0 ){
				if( is_string( $content ) )
					$content	= $buffer;
				else
					throw new RuntimeException( (string) $buffer );
			}
		}
		$content	= $this->removeTypeIdentifier( $content );
		return $content;
	}
}

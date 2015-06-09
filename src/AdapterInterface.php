<?php
/**
 *	Interface for each template engine in factory.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2015 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
/**
 *	Interface for each template engine in factory.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2015 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
interface AdapterInterface {

	/**
	 *	Constructor.
	 *	@access		public
	 *	@param		CMM_TEA_Factory		$factory		TEA factory instance
	 *	@return		void
	 */
	public function __construct( \CeusMedia\TemplateAbstraction\Factory $factory );

	/**
	 *	Assigns context data for template.
	 *	@access		public
	 *	@param		string			$key			Data pair key
	 *	@param		mixed			$value			Data pair value
	 *	@param		boolean			$force			Flag: override existing data pair
	 *	@return		void
	 */
	public function addData( $key, $value, $force = FALSE );

	/**
	 *	Returns rendered template content.
	 *	@access		public
	 *	@return		string
	 */
	public function render();

	/**
	 *	Sets path to compile folder.
	 *	@access		public
	 *	@param		string			$path			Path to cache folder
	 *	@return		void
	 */
	public function setCachePath( $path );

	/**
	 *	Sets path to cache or compile folder.
	 *	@access		public
	 *	@param		string			$path			Path to compile folder
	 *	@return		void
	 */
	public function setCompilePath( $path );

	/**
	 *	Assigns a map of context data for template.
	 *	@access		public
	 *	@param		array			$map			Map of context data pairs
	 *	@param		boolean			$force			Flag: override existing data pair
	 *	@return		void
	 */
	public function setData( $map, $force = FALSE );

	/**
	 *	Sets name of template file in template folder.
	 *	@access		public
	 *	@param		string			$fileName		Name of template file in template folder
	 *	@return		void
	 */
	public function setSourceFile( $fileName );

	/**
	 *	Sets path to template folder.
	 *	@access		public
	 *	@param		string			$path			Path to template folder
	 *	@return		void
	 */
	public function setSourcePath( $path );

	/**
	 *	Sets template content by string.
	 *	@access		public
	 *	@param		string			$string			Template content
	 *	@return		void
	 */
	public function setSourceString( $string );
}
?>

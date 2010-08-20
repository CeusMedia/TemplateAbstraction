<?php
/**
 *	Interface for each template engine in factory.
 *	@category	cmModules
 *	@package	TEA.Adapter
 *	@author		Christian Würker <christian.wuerker@ceusmedia.de>
 *	@version	$Id$
 */
/**
 *	Interface for each template engine in factory.
 *	@category	cmModules
 *	@package	TEA.Adapter
 *	@author		Christian Würker <christian.wuerker@ceusmedia.de>
 *	@version	$Id$
 */
interface TEA_Adapter_Interface {

	/**
	 *	Constructor.
	 *	@access		public
	 *	@param		TEA_Factory		$factory		TEA factory instance
	 *	@return		void
	 */
	public function __construct( TEA_Factory $factory );

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
	 *	Sets path to cache or compile folder.
	 *	@access		public
	 *	@param		string			$path			Path to cache or compile folder
	 *	@return		void
	 */
	public function setCachePath( $path );

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
<?php
/**
 *	Abstract basic adapter implementation.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2015 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
/**
 *	Abstract basic adapter implementation.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2015 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
abstract class Abstract implements \CeusMedia\TemplateAbstraction\AdapterInterface {

	protected $data			= array();
	protected $factory		= NULL;
	protected $fileSource	= NULL;
	protected $pathSource	= '';
	protected $pathCache	= '';
	protected $pathCompile	= '';
	protected $template		= '';

	/**
	 *	Constructor.
	 *	@access		public
	 *	@param		CMM_TEA_Factory		$factory		TEA factory instance
	 *	@return		void
	 */
	public function __construct( \CeusMedia\TemplateAbstraction\Factory $factory ){
		$this->factory	= $factory;
	}

	/**
	 *	Assigns context data for template.
	 *	@access		public
	 *	@param		string			$key			Data pair key
	 *	@param		mixed			$value			Data pair value
	 *	@param		boolean			$force			Flag: override existing data pair
	 *	@return		void
	 */
	public function addData( $key, $value, $force = FALSE ){
		if( isset( $this->data[$key] ) && !$force )
			throw new RuntimeException( 'Template data key "'.$key.'" is already defined' );
		$this->data[$key]	= $value;
	}

	/**
	 *	Removes TEA type identifier in rendered template content.
	 *	@access		protected
	 *	@param		string			$content		Rendered template content
	 *	@return		string			Rendered template content without type identifier
	 */
	protected function removeTypeIdentifier( $content ){
		return preg_replace( $this->factory->patternType, '', $content );
	}

	/**
	 *	Sets path to cache folder.
	 *	@access		public
	 *	@param		string			$path			Path to cache folder
	 *	@return		void
	 */
	public function setCachePath( $path ){
		$this->pathCache	= $path;
	}

	/**
	 *	Sets path to compile folder.
	 *	@access		public
	 *	@param		string			$path			Path to compile folder
	 *	@return		void
	 */
	public function setCompilePath( $path ){
		$this->pathCompile	= $path;
	}

	/**
	 *	Assigns a map of context data for template.
	 *	@access		public
	 *	@param		array			$map			Map of context data pairs
	 *	@param		boolean			$force			Flag: override existing data pair
	 *	@return		void
	 */
	public function setData( $map, $force = FALSE ){
		foreach( $map as $key => $value )
			$this->addData($key, $value, $force );
	}

	/**
	 *	Sets name of template file in template folder.
	 *	@access		public
	 *	@param		string			$fileName		Name of template file in template folder
	 *	@return		void
	 */
	public function setSourceFile( $fileName ){
		$this->fileSource	= $fileName;
	}

	/**
	 *	Sets path to template folder.
	 *	@access		public
	 *	@param		string			$path			Path to template folder
	 *	@return		void
	 */
	public function setSourcePath( $path ){
		$this->pathSource	= $path;
	}

	/**
	 *	Sets template content by string.
	 *	@access		public
	 *	@param		string			$string			Template content
	 *	@return		void
	 */
	public function setSourceString( $string ){
		$this->template	= $string;
	}
}
?>

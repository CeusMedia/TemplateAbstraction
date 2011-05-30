<?php
/**
 *	Abstract basic adapter implementation.
 *	@category		cmModules
 *	@package		TEA.Adapter
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@version		$Id$
 */
/**
 *	Abstract basic adapter implementation.
 *	@category		cmModules
 *	@package		TEA.Adapter
 *	@implements		CMM_TEA_Adapter_Interface
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@version		$Id$
 */
abstract class CMM_TEA_Adapter_Abstract implements CMM_TEA_Adapter_Interface {

	protected $data			= array();
	protected $factory		= NULL;
	protected $fileSource	= NULL;
	protected $pathSource	= '';
	protected $pathCache	= '';
	protected $template		= '';

	/**
	 *	Constructor.
	 *	@access		public
	 *	@param		CMM_TEA_Factory		$factory		TEA factory instance
	 *	@return		void
	 */
	public function __construct( CMM_TEA_Factory $factory ){
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
		$pattern	= $this->factory->getPattern();
		return preg_replace( $pattern, '', $content );
	}

	/**
	 *	Sets path to cache or compile folder.
	 *	@access		public
	 *	@param		string			$path			Path to cache or compile folder
	 *	@return		void
	 */
	public function setCachePath( $path ){
		$this->pathCache	= $path;
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
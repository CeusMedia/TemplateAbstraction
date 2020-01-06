<?php
/**
 *	Abstract basic adapter implementation.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2020 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
namespace CeusMedia\TemplateAbstraction;

/**
 *	Abstract basic adapter implementation.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2020 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
abstract class AdapterAbstract implements AdapterInterface
{
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
	 *	@param		Factory			$factory		TEA factory instance
	 *	@return		void
	 */
	public function __construct( Factory $factory )
	{
		$this->factory	= $factory;
	}

	/**
	 *	Assigns context data for template.
	 *	@access		public
	 *	@param		string			$key			Data pair key
	 *	@param		mixed			$value			Data pair value
	 *	@param		boolean			$force			Flag: override existing data pair
	 *	@return		AdapterAbstract
	 */
	public function addData( string $key, $value, bool $force = FALSE ): AdapterAbstract
	{
		if( isset( $this->data[$key] ) && !$force )
			throw new \RuntimeException( 'Template data key "'.$key.'" is already defined' );
		$this->data[$key]	= $value;
		return $this;
	}

	/**
	 *	Removes TEA type identifier in rendered template content.
	 *	@access		protected
	 *	@param		string			$content		Rendered template content
	 *	@return		string			Rendered template content without type identifier
	 */
	protected function removeTypeIdentifier( string $content ): string
	{
		return preg_replace( $this->factory->patternType, '', $content );
	}

	/**
	 *	Sets path to cache folder.
	 *	@access		public
	 *	@param		string			$path			Path to cache folder
	 *	@return		AdapterAbstract
	 */
	public function setCachePath( string $path ): AdapterAbstract
	{
		$this->pathCache	= $path;
		return $this;
	}

	/**
	 *	Sets path to compile folder.
	 *	@access		public
	 *	@param		string			$path			Path to compile folder
	 *	@return		AdapterAbstract
	 */
	public function setCompilePath( string $path ): AdapterAbstract
	{
		$this->pathCompile	= $path;
		return $this;
	}

	/**
	 *	Assigns a map of context data for template.
	 *	@access		public
	 *	@param		array			$map			Map of context data pairs
	 *	@param		boolean			$force			Flag: override existing data pair
	 *	@return		AdapterAbstract
	 */
	public function setData( array $map, bool $force = FALSE ): AdapterAbstract
	{
		foreach( $map as $key => $value )
			$this->addData($key, $value, $force );
		return $this;
	}

	/**
	 *	Sets name of template file in template folder.
	 *	@access		public
	 *	@param		string			$fileName		Name of template file in template folder
	 *	@return		AdapterAbstract
	 */
	public function setSourceFile( string $fileName ): AdapterAbstract
	{
		$this->fileSource	= $fileName;
		return $this;
	}

	/**
	 *	Sets path to template folder.
	 *	@access		public
	 *	@param		string			$path			Path to template folder
	 *	@return		AdapterAbstract
	 */
	public function setSourcePath( string $path ): AdapterAbstract
	{
		$this->pathSource	= $path;
		return $this;
	}

	/**
	 *	Sets template content by string.
	 *	@access		public
	 *	@param		string			$string			Template content
	 *	@return		AdapterAbstract
	 */
	public function setSourceString( string $string ): AdapterAbstract
	{
		$this->template	= $string;
		return $this;
	}
}

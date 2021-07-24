<?php
/**
 *	Abstract basic adapter implementation.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2021 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
namespace CeusMedia\TemplateAbstraction;

use RuntimeException;
use function phpversion;
use function version_compare;

/**
 *	Abstract basic adapter implementation.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2021 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
abstract class AdapterAbstract implements AdapterInterface
{
	/** @var	array<string,mixed>		$data				... */
	protected $data			= array();

	/** @var	Factory		$factory			... */
	protected $factory;

	/** @var	string|null		$fileSource			... */
	protected $fileSource	= NULL;

	/** @var	string			$pathSource			... */
	protected $pathSource	= '';

	/** @var	string			$pathCache			... */
	protected $pathCache	= '';

	/** @var	string			$pathCompile		... */
	protected $pathCompile	= '';

	/** @var	string			$template			... */
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
			throw new RuntimeException( 'Template data key "'.$key.'" is already defined' );
		$this->data[$key]	= $value;
		return $this;
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
	 *	@param		array<string,mixed>	$map			Map of context data pairs
	 *	@param		boolean				$force			Flag: override existing data pair
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

	/**
	 *	Removes TEA type identifier in rendered template content.
	 *	@access		protected
	 *	@param		string			$content		Rendered template content
	 *	@return		string			Rendered template content without type identifier
	 *	@throws		RuntimeException				if replacing failed
	 */
	protected function removeTypeIdentifier( string $content ): string
	{
		$result	= preg_replace( $this->factory->patternType, '', $content );
		if( NULL === $result ){
			$errorNr = preg_last_error();
			if( version_compare( (string) phpversion(), "8", '>=' ) )
				$errorMsg	= preg_last_error_msg();
			else{
				$pregConstantsOnReplace = [
					0	=> 'PREG_NO_ERROR',
					1	=> 'PREG_INTERNAL_ERROR',
					2	=> 'PREG_BACKTRACK_LIMIT_ERROR',
					3	=> 'PREG_RECURSION_LIMIT_ERROR',
					4	=> 'PREG_BAD_UTF8_ERROR',
					5	=> 'PREG_BAD_UTF8_OFFSET_ERROR',
					6	=> 'PREG_JIT_STACKLIMIT_ERROR',
				];
				$errorMsg	= $pregConstantsOnReplace[$errorNr];
			}
			throw new RuntimeException( vsprintf( 'Removing identifier failed: %s', [
				$errorMsg,
				$errorNr,
			] ) );
		}
		return $result;
	}
}

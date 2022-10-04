<?php
declare(strict_types=1);

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
	protected array $data			= [];

	/** @var	Factory				$factory			... */
	protected Factory $factory;

	/** @var	string|null			$sourceFile			... */
	protected ?string $sourceFile	= NULL;

	/** @var	string				$sourcePath			... */
	protected string $sourcePath	= '';

	/** @var	string				$pathCache			... */
	protected string $pathCache		= '';

	/** @var	string				$pathCompile		... */
	protected string $pathCompile	= '';

	/** @var	string				$sourceString			... */
	protected string $sourceString		= '';

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
	 *	@return		AdapterInterface
	 *	@throws		RuntimeException
	 */
	public function addData( string $key, $value, bool $force = FALSE ): AdapterInterface
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
	 *	@return		AdapterInterface
	 */
	public function setCachePath( string $path ): AdapterInterface
	{
		$this->pathCache	= $path;
		return $this;
	}

	/**
	 *	Sets path to compile folder.
	 *	@access		public
	 *	@param		string			$path			Path to compile folder
	 *	@return		AdapterInterface
	 */
	public function setCompilePath( string $path ): AdapterInterface
	{
		$this->pathCompile	= $path;
		return $this;
	}

	/**
	 *	Assigns a map of context data for template.
	 *	@access		public
	 *	@param		array<string,mixed>	$map			Map of context data pairs
	 *	@param		boolean				$force			Flag: override existing data pair
	 *	@return		AdapterInterface
	 */
	public function setData( array $map, bool $force = FALSE ): AdapterInterface
	{
		foreach( $map as $key => $value )
			$this->addData($key, $value, $force );
		return $this;
	}

	/**
	 *	Sets name of template file in template folder.
	 *	@access		public
	 *	@param		string			$fileName		Name of template file in template folder
	 *	@return		AdapterInterface
	 */
	public function setSourceFile( string $fileName ): AdapterInterface
	{
		$this->sourceFile	= $fileName;
		return $this;
	}

	/**
	 *	Sets path to template folder.
	 *	@access		public
	 *	@param		string			$path			Path to template folder
	 *	@return		AdapterInterface
	 */
	public function setSourcePath( string $path ): AdapterInterface
	{
		$this->sourcePath	= $path;
		return $this;
	}

	/**
	 *	Sets template content by string.
	 *	@access		public
	 *	@param		string			$string			Template content
	 *	@return		AdapterInterface
	 */
	public function setSourceString( string $string ): AdapterInterface
	{
		$this->sourceString	= $string;
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
			if( version_compare( phpversion(), "8", '>=' ) )
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

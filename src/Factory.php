<?php
/** @noinspection PhpUnused */
/** @noinspection PhpMultipleClassDeclarationsInspection */

declare(strict_types=1);

/**
 *	Factory for template from several template engines.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2022 Christian Würker
 *	@license		https://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */

namespace CeusMedia\TemplateAbstraction;

use CeusMedia\Common\Exception\FileNotExisting;
use CeusMedia\Common\FS\File\Reader as FileReader;
use ReflectionClass;
use ReflectionException;
use RuntimeException;
use function class_exists;

/**
 *	Factory for template from several template engines.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2021  Christian Würker
 *	@license		https://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
class Factory
{
	/**	@var		string					$defaultType		... */
	protected string $defaultType			= 'PHP';

	/**	@var		array<string,Engine>	$engines			... */
	protected array $engines				= [];

	/**	@var		Environment				$environment		... */
	protected Environment $environment;

	/**	@var		string					$pathTemplates		... */
	protected string $pathTemplates			= 'templates/';

	/**	@var		string					$pathCache			... */
	protected string $pathCache				= 'templates/cache/';

	/**	@var		string					$pathCompile		... */
	protected string $pathCompile			= 'templates/compiled/';

	/**	@var		string					$patternType		... */
	public string$patternType				= '/^<!--Engine:(\S+)-->\n?\r?/';

	/**
	 *	Constructor.
	 *	@access		public
	 *	@param		Environment	$environment
	 *	@return		void
	 */
	public function __construct( Environment $environment )
	{
		$this->environment	= $environment;
	}

/*	public function getEngineSettings( $type )
	{
		if( !array_key_exists( $type, $this->engines ) )
			throw new \DomainException( 'Unknown engine "'.$type.'"' );
		return $this->engines[$type];
	}*/

	/**
	 *	Loads a template after identifying its engine type.
	 *	If the engine type is known use newTemplate to avoid engine type detection.
	 *	@access		public
	 *	@param		string				$fileName		File name of template within set template path
	 *	@param		array<string,mixed>	$data			Map of template pairs
	 *	@return		AdapterInterface
	 *	@throws		ReflectionException
	 */
	public function getTemplate( string $fileName, array $data = [] ): AdapterInterface
	{
		$engine	= $this->identifyEngine( $fileName );
		return $this->newTemplate( $engine->getKey(), $fileName, $data );
	}

	/**
	 *	Indicates whether a template engine is available.
	 *	@access		public
	 *	@param		string		$type		Key of template engined to check
	 *	@return		boolean
	 */
	public function hasEngine( string $type ): bool
	{
		return array_key_exists( $type, $this->engines );
	}

	/**
	 *	Tries to identify engine type by looking for a specific header pattern within a template.
	 *	Returns every found type even if not supported.
	 *	@access		public
	 *	@param		string		$fileName		File name of template within template path
	 *	@return		string|NULL
	 *	@deprecated	use identifyEngine instead
	 */
	public function identifyType( string $fileName ): ?string
	{
		try{
			/** @var string $content */
			$content	= FileReader::load( $this->pathTemplates.$fileName );
			$matches	= [];
			if( FALSE !== preg_match_all( $this->patternType, $content, $matches ) )
				return $matches[1][0];
		}
		catch( FileNotExisting ){
		}
		return NULL;
	}

	/**
	 *	@access		public
	 *	@param		string		$filePath		File name of template within template path
	 *	@return		Engine
	 */
	public function identifyEngine( string $filePath ): Engine
	{
		try{
			/** @var string $content */
			$content	= FileReader::load( $this->pathTemplates.$filePath );
			$matches	= [];
			if( 0 !== preg_match_all( $this->patternType, $content, $matches ) ){
				foreach( $this->environment->getEngines() as $engine ){
					$result = preg_match( $engine->getIdentifier(), $matches[1][0] );
					if( FALSE !== $result && 0 < $result )
						return $engine;
				}
			}
		}
		catch( FileNotExisting ){
		}
		return $this->environment->getDefaultEngine();
	}

	/**
	 *	Loads a template of a known engine type.
	 *	@access		public
	 *	@param		string				$engineKey		Engine key, case-sensitive, see engines.ini
	 *	@param		string|NULL			$filePath		File name of template within set template path
	 *	@param		array<string,mixed>	$data			Map of template pairs
	 *	@return		AdapterInterface
	 *	@throws		RuntimeException	if adapter for given type is not existing
	 *	@throws		ReflectionException	if adapter for given type is not existing
	 */
	public function newTemplate( string $engineKey, string $filePath = NULL, array $data = [] ): AdapterInterface
	{
		$engine			= $this->environment->getEngine( $engineKey );
		$adapterClass	= $engine->getAdapterClass();
		if( !class_exists( $adapterClass ) )
			throw new RuntimeException( 'Adapter '.$engineKey.' is not existing' );
		$reflection	= new ReflectionClass( $adapterClass );
		/** @var AdapterInterface $template */
		$template	= $reflection->newInstanceArgs( [$this] );
		if( !$template->isPackageInstalled() )
			throw new RuntimeException( 'Package for engine "'.$engineKey.'" is not installed' );
		$template->setSourcePath( $this->pathTemplates );
		if( strlen( trim( $this->pathCache ) ) > 0 )
			$template->setCachePath( $this->pathCache );
		if( strlen( trim( $this->pathCompile ) ) > 0 )
			$template->setCompilePath( $this->pathCompile );
		if( NULL !== $filePath && strlen( trim( $filePath ) ) > 0 )
			$template->setSourceFile( $filePath );
		$template->setData( $data );
		return $template;
	}

	/**
	 *	Sets path to cache folder.
	 *	@access		public
	 *	@param		string			$path			Path to cache folder
	 *	@return		self
	 */
	public function setCachePath( string $path ): self
	{
		$this->pathCache	= rtrim( $path, '/' ).'/';
		return $this;
	}

	/**
	 *	Sets path to compile folder.
	 *	@access		public
	 *	@param		string			$path			Path to compile folder
	 *	@return		self
	 */
	public function setCompilePath( string $path ): self
	{
		$this->pathCompile	= rtrim( $path, '/' ).'/';
		return $this;
	}

	/**
	 *	Sets default template engine type.
	 *	@access		public
	 *	@param		string			$type			Engine type to set as default
	 *	@return		self
	 *	@throws		RuntimeException				if engine is not available
	 */
	public function setDefaultType( string $type ): self
	{
		if( !array_key_exists( $type, $this->engines ) )
			throw new RuntimeException( 'Engine "'.$type.'" is not available' );
		$this->defaultType	= $type;
		return $this;
	}

	/**
	 *	Sets path to template folder.
	 *	@access		public
	 *	@param		string			$path			Path to template folder
	 *	@return		self
	 */
	public function setTemplatePath( string $path ): self
	{
		$this->pathTemplates	= rtrim( $path, '/' ).'/';
		return $this;
	}
}

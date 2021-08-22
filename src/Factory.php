<?php
/**
 *	Factory for template from several template engines.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2021 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
namespace CeusMedia\TemplateAbstraction;

use FS_File_Reader as FileReader;
use ReflectionClass;
use RuntimeException;
use function class_exists;

/**
 *	Factory for template from several template engines.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2021  Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
class Factory
{
	/**	@var		string		$defaultType		... */
	protected $defaultType		= 'PHP';

	/**	@var		array<string,Engine>		$engines			... */
	protected $engines			= [];

	/**	@var		Environment	$environment		... */
	protected $environment;

	/**	@var		string		$pathTemplates		... */
	protected $pathTemplates	= 'templates/';

	/**	@var		string		$pathCache			... */
	protected $pathCache		= 'templates/cache/';

	/**	@var		string		$pathCompile		... */
	protected $pathCompile		= 'templates/compiled/';

	/**	@var		string		$patternType		... */
	public $patternType			= '/^<!--Engine:(\S+)-->\n?\r?/';

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
	 *	@return		AdapterAbstract
	 */
	public function getTemplate( string $fileName, array $data = NULL ): AdapterAbstract
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
		$content	= FileReader::load( $this->pathTemplates.$fileName );
		$matches	= array();
		if( FALSE !== preg_match_all( $this->patternType, $content, $matches ) )
			return $matches[1][0];
		return NULL;
	}

	/**
	 *	@access		public
	 *	@param		string		$filePath		File name of template within template path
	 *	@return		Engine
	 */
	public function identifyEngine( string $filePath ): Engine
	{
		$content	= FileReader::load( $this->pathTemplates.$filePath );
		$matches	= array();
		if( FALSE !== preg_match_all( $this->patternType, $content, $matches ) ){
			foreach( $this->environment->getEngines() as $engine ){
				$result = preg_match( $engine->getIdentifier(), $matches[1][0] );
				if( FALSE !== $result && 0 < $result )
					return $engine;
			}
		}
		return $this->environment->getDefaultEngine();
	}

	/**
	 *	Loads a template of a known engine type.
	 *	@access		public
	 *	@param		string				$engineKey		Engine key, case sensitive, see engines.ini
	 *	@param		string				$filePath		File name of template within set template path
	 *	@param		array<string,mixed>	$data			Map of template pairs
	 *	@return		AdapterAbstract
	 *	@throws		RuntimeException			if adapter for given type is not existing
	 */
	public function newTemplate( string $engineKey, string $filePath = NULL, array $data = NULL ): AdapterAbstract
	{
		$engine			= $this->environment->getEngine( $engineKey );
		$adapterClass	= $engine->getAdapterClass();
		if( !class_exists( $adapterClass ) )
			throw new RuntimeException( 'Adapter '.$engineKey.' is not existing' );
		$reflection	= new ReflectionClass( $adapterClass );
		$template	= $reflection->newInstanceArgs( array( $this ) );
		$template->setSourcePath( $this->pathTemplates );
		if( strlen( trim( $this->pathCache ) ) > 0 )
			$template->setCachePath( $this->pathCache );
		if( strlen( trim( $this->pathCompile ) ) > 0 )
			$template->setCompilePath( $this->pathCompile );
		if( NULL !== $filePath && strlen( trim( $filePath ) ) > 0 )
			$template->setSourceFile( $filePath );
		if( NULL !== $data )
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
		$this->pathCache	= $path;
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
		$this->pathCompile	= $path;
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
		$this->pathTemplates	= $path;
		return $this;
	}
}

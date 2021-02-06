<?php
/**
 *	Factory for template from several template engines.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2020 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
namespace CeusMedia\TemplateAbstraction;

use AdapterInterface;

/**
 *	Factory for template from several template engines.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2020 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
class Factory
{
	/**	@param		string				$defaultType		... */
	protected string $defaultType		= 'STE';

	/**	@param		array				$engines		... */
	protected array $engines			= array();

	/**	@param		string				$pathTemplates		... */
	protected string $pathTemplates		= 'templates/';

	/**	@param		string				$pathCache		... */
	protected string $pathCache			= 'templates/cache/';

	/**	@param		string				$pathCompile		... */
	protected string $pathCompile		= 'templates/compiled/';

	/**	@param		string				$patternType		... */
	public string $patternType			= '/^<!--Engine:(\S+)-->\n?\r?/';

	/**
	 *	Constructor.
	 *	Loads engine definitions from engine.ini.
	 *	@access		public
	 *	@return		void
	 */
//	 *	@param		string|array	$config		Filename of config file OR configuration as array
	public function __construct(/* $config = NULL */)
	{
		/*
		if( is_array( $config ) )
			$this->engines	= $config;
		else{
			$fileName		= $config ? $config : dirname( __FILE__ ).'/engines.ini';
			if( !file_exists( $fileName ) )
				throw new \RuntimeException( 'Config file "'.$fileName.'" is missing' );
			$this->engines	= parse_ini_file( $fileName, TRUE );
		}
		if( !array_key_exists( $this->defaultType, $this->engines ) ){
			$this->defaultType		= NULL;
			foreach( $this->engines as $engineName => $engineData ){
				if( !empty( $engineData['default'] ) ){
					$this->defaultType		= $engineName;
					break;
				}
			}
		}*/
	}

	/**
	 *	Tries to identify engine type by looking for a specific header pattern within a template.
	 *	Returns every found type even if not supported.
	 *	@access		public
	 *	@param		string		$fileName		File name of template within template path
	 *	@return		string|NULL
	 */
	public function identifyType( string $fileName )
	{
		$content	= \FS_File_Reader::load( $this->pathTemplates.$fileName );
		$matches	= array();
		if( (bool) preg_match_all( $this->patternType, $content, $matches ) )
			return $matches[1][0];
		return NULL;
	}

/*	public function getEngineSettings( $type ){
		if( !array_key_exists( $type, $this->engines ) )
			throw new \DomainException( 'Unknown engine "'.$type.'"' );
		return $this->engines[$type];
	}*/

	/**
	 *	Loads a template after identifying its engine type.
	 *	If the engine type is known use newTemplate to avoid engine type detection.
	 *	@access		public
	 *	@param		string		$fileName		File name of template within set template path
	 *	@param		array		$data			Map of template pairs
	 *	@return		AdapterAbstract
	 *	@throws		\RuntimeException			if no engine type could be identified
	 */
	public function getTemplate( string $fileName, array $data = NULL ): AdapterAbstract
	{
		$type	= $this->identifyType( $fileName ) ?? $this->defaultType;
		if( strlen( trim( $type ) ) === 0 )
			throw new \RuntimeException( 'No engine identified or set' );
		return $this->newTemplate( $type, $fileName, $data );
	}

	public function hasEngine( string $type ): bool
	{
		return array_key_exists( $type, $this->engines );
	}

	/**
	 *	Checks engine settings.
	 *	Tries to load engine from file or registers an autoloader for a path.
	 *	Notes ready state of engine and skips on a second run.
	 *	@access		protected
	 *	@param		string		$type		Engine type key
	 *	@return		self
	 *	@throws		\RuntimeException		if engine type is unknown
	 *	@throws		\RuntimeException		if engine is not enabled
	 */
	protected function initializeEngine( string $type ): self
	{/*
		if( empty( $this->engines[$type] ) ){														//  not engine for engine type
			throw new \OutOfRangeException( 'Unknown engine "'.$type.'"' );							//  quit with exception
		}
		$engine	= (object) $this->engines[$type];													//  extract engine from engine map
		if( (int) $engine->active === 0 ){															//  engine is disabled
			throw new \RuntimeException( 'Engine "'.$type.'" not enabled' );						//  quit with exception
		}
		if( !empty( $engine->loadPath ) ){															//  autoloader path is set
			$ext	= empty( $engine->loadExtension ) ? 'php' : $engine->loadExtension;				//  figure class extensions
			$prefix	= empty( $engine->loadPrefix ) ? NULL : $engine->loadPrefix;					//  figure class prefix
			\CMC_Loader::registerNew( $ext, $prefix, $engine->loadPath );							//  enable class autoloading
		}
		if( !empty( $engine->loadFile ) ){															//  single load file is set
			require_once $engine->loadFile;															//  try to load single load file
		}
		$this->engines[$type]->active	= 2;*/														//  mark this engine as loaded
		return $this;
	}

	/**
	 *	Loads a template of a known engine type.
	 *	@access		public
	 *	@param		string		$type			Engine type key, case sensitive, see engines.ini
	 *	@param		string		$fileName		File name of template within set template path
	 *	@param		array		$data			Map of template pairs
	 *	@return		AdapterAbstract
	 */
	public function newTemplate( string $type, string $fileName = NULL, array $data = NULL ): AdapterAbstract
	{
		$this->initializeEngine( $type );
		$className	= 'CeusMedia\\TemplateAbstraction\\Adapter\\'.$type;
		$reflection	= new \ReflectionClass( $className );
		$template	= $reflection->newInstanceArgs( array( $this ) );
		$template->setSourcePath( $this->pathTemplates );
		if( strlen( trim( $this->pathCache ) ) > 0 )
			$template->setCachePath( $this->pathCache );
		if( strlen( trim( $this->pathCompile ) ) > 0 )
			$template->setCompilePath( $this->pathCompile );
		if( NULL !== $fileName && strlen( trim( $fileName ) ) > 0 )
			$template->setSourceFile( $fileName );
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
	 */
	public function setDefaultType( string $type ): self
	{
		if( !array_key_exists( $type, $this->engines ) )
			throw new \RuntimeException( 'Engine "'.$type.'" is not available' );
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

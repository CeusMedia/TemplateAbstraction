<?php
/** @noinspection PhpMultipleClassDeclarationsInspection */

declare(strict_types=1);

/**
 *	Container for registered template engines.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2021 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */

namespace CeusMedia\TemplateAbstraction;

use DomainException;
use CeusMedia\Common\FS\File\INI\SectionReader as IniReader;
use function array_key_exists;

/**
 *	Container for registered template engines.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2021 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
class Environment
{
	/** @var	string */
	protected string $defaultEngineKey;

	/** @var	array<string,Engine> */
	protected array $engines		 = [];

	/** @var	Factory|NULL */
	protected ?Factory $factory		= NULL;

	/**
	 *	Constructor.
	 *	Registers PHP as first and default template engine.
	 *	@access		public
	 *	@return		void
	 */
	public function __construct()
	{
		$this->registerEngine( new Engine( 'PHP', Adapter\PHP::class ) );
		$this->setDefaultEngineKey( 'PHP' );
	}

	/**
	 *	Return default engine registered engine by engine key.
	 *	@access		public
	 *	@return		Engine
	 */
	public function getDefaultEngine(): Engine
	{
		return $this->engines[$this->defaultEngineKey];
	}

	/**
	 *	Return registered engine by engine key.
	 *	@access		public
	 *	@param		string		$key			...
	 *	@return		Engine
	 *	@throws		DomainException
	 */
	public function getEngine( string $key ): Engine
	{
		if( !$this->hasEngine( $key ) )
			throw new DomainException( 'Engine \''.$key.'\' is not registered' );
		return $this->engines[$key];
	}

	/**
	 *	Returns map of registered engines.
	 *	@access		public
	 *	@return		array<string,Engine>
	 */
	public function getEngines(): array
	{
		return $this->engines;
	}

	/**
	 *	Returns singleton factory with this environment.
	 *	@access		public
	 *	@return		Factory
	 */
	public function getFactory(): Factory
	{
		if( NULL === $this->factory )
			$this->factory	= new Factory( $this );
		return $this->factory;
	}

	/**
	 *	Indicates whether an engine is registered by engine key.
	 *	@access		public
	 *	@param		string		$key			...
	 *	@return		bool
	 */
	public function hasEngine( string $key ): bool
	{
		return array_key_exists( $key, $this->engines );
	}

	/**
	 *	Registers another template engine.
	 *	@access		public
	 *	@param		Engine		$engine			...
	 *	@return		self
	 *	@throws		DomainException
	 */
	public function registerEngine( Engine $engine ): self
	{
		$engineKey	= $engine->getKey();
		if( array_key_exists( $engineKey, $this->engines ) )
			throw new DomainException( 'Engine with key \''.$engineKey.'\' already registered' );
		$this->engines[$engineKey]	= $engine;
		return $this;
	}

	/**
	 *	Registers engines enlisted within libraries engines.ini.
	 *	@access		public
	 *	@param		boolean		$enabled		...
	 *	@return		self
	 */
	public function registerEnginesSupportedByLibrary( bool $enabled = TRUE ): self
	{
		$filePath	= dirname(__DIR__) . '/engines.ini';
		if( !file_exists( $filePath ) )
			$filePath	= dirname( __DIR__ ).'/engines.ini.dist';
		return $this->registerEnginesByConfigFile( $filePath, $enabled );
	}

	/**
	 *	Registers engines enlisted within a given INI file.
	 *	@access		public
	 *	@param		string		$filePath		...
	 *	@param		boolean		$enabled		...
	 *	@return		self
	 */
	public function registerEnginesByConfigFile( string $filePath, bool $enabled = TRUE ): self
	{
		$reader		= new IniReader( $filePath );
		foreach( $reader->getSections() as $engineKey ){
			$engine	= new Engine( $engineKey, $reader->getProperty( $engineKey, 'adapterClass' ) );
			foreach( $reader->getProperties( $engineKey ) as $key => $value ){
				switch( $key ){
					case 'identifier':
						$engine->setIdentifier( $value );
						break;
					case 'title':
						$engine->setTitle( $value );
						break;
					case 'description':
						$engine->setDescription( $value );
						break;
					case 'composerPackage':
						$engine->setComposerPackage( $value );
						break;
				}
			}
			$engine->setStatus( $enabled ? Engine::STATUS_ENABLED : Engine::STATUS_DISABLED );
			$this->registerEngine( $engine );
		}
		return $this;
	}

	/**
	 *	Sets default engine by engine key.
	 *	@access		public
	 *	@param		string		$key			...
	 *	@return		self
	 */
	public function setDefaultEngineKey( string $key ): self
	{
		if( !array_key_exists( $key, $this->engines ) )
			throw new DomainException( 'Engine \''.$key.'\' is not registered' );
		$this->defaultEngineKey	= $key;
		return $this;
	}
}

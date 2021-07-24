<?php
/**
 *	Data type for registerable template engines.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2021 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
namespace CeusMedia\TemplateAbstraction;

use RangeException;

/**
 *	Data type for registerable template engines.
 *	@category		Library
 *	@package		CeusMedia_TemplateAbstraction
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2021 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/TemplateAbstraction
 */
class Engine
{
	const PRIORITY_LOW			= 0;
	const PRIORITY_NORMAL		= 1;
	const PRIORITY_HIGH			= 2;

	const PRIORITIES			= [
		self::PRIORITY_LOW,
		self::PRIORITY_NORMAL,
		self::PRIORITY_HIGH,
	];

	const STATUS_DISABLED		= 0;
	const STATUS_ENABLED		= 1;
	const STATUS_INSTALLED		= 2;

	const STATUSES				= [
		self::STATUS_DISABLED,
		self::STATUS_ENABLED,
		self::STATUS_INSTALLED,
	];

	/** @var	string */
	protected $key;

	/** @var	string */
	protected $composerPackage;

	/** @var	string */
	protected $adapterClass;

	/** @var	integer */
	protected $status			= self::STATUS_ENABLED;

	/** @var	string */
	protected $title;

	/** @var	string */
	protected $identifier;

	/** @var	integer */
	protected $priority			= self::PRIORITY_NORMAL;

	/** @var	string */
	protected $description;

	/**
	 *	Constructor.
	 *	@access		public
	 *	@param		string		$key			...
	 *	@param		string		$adapterClass	...
	 *	@param		integer		$status			...
	 *	@return		void
	 */
	public function __construct( string $key, string $adapterClass, int $status = self::STATUS_ENABLED )
	{
		$this->setKey( $key );
		$this->setAdapterClass( $adapterClass );
		$this->setStatus( $status );
		$this->setIdentifier( '#^'.preg_quote( $key, '#' ).'$#i' );
	}

	/**
	 *	Returns adapter class.
	 *	@access		public
	 *	@return		string
	 */
	public function getAdapterClass(): string
	{
		return $this->adapterClass;
	}

	/**
	 *	Returns composer package, if set.
	 *	@access		public
	 *	@return		string|NULL
	 */
	public function getComposerPackage(): ?string
	{
		return $this->composerPackage;
	}

	/**
	 *	Returns description, if set.
	 *	@access		public
	 *	@return		string|NULL
	 */
	public function getDescription(): ?string
	{
		return $this->description;
	}

	/**
	 *	Returns identifier, which is a complete regular expression.
	 *	@access		public
	 *	@return		string
	 */
	public function getIdentifier(): string
	{
		return $this->identifier;
	}

	/**
	 *	Returns key.
	 *	@access		public
	 *	@return		string
	 */
	public function getKey(): string
	{
		return $this->key;
	}

	/**
	 *	Returns adapter class.
	 *	@access		public
	 *	@return		integer
	 */
	public function getPriority(): int
	{
		return $this->priority;
	}

	/**
	 *	Returns status.
	 *	@access		public
	 *	@return		integer
	 */
	public function getStatus(): int
	{
		return $this->status;
	}

	/**
	 *	Returns title, if set.
	 *	@access		public
	 *	@return		string|NULL
	 */
	public function getTitle(): ?string
	{
		return $this->title;
	}

	/**
	 *	Sets adapter class.
	 *	@access		public
	 *	@param		string		$adapterClass		...
	 *	@return		self
	 */
	public function setAdapterClass( string $adapterClass ): self
	{
		$this->adapterClass	= $adapterClass;
		return $this;
	}

	/**
	 *	Sets composer package.
	 *	@access		public
	 *	@param		string		$composerPackage	...
	 *	@return		self
	 */
	public function setComposerPackage( string $composerPackage ): self
	{
		$this->composerPackage	= $composerPackage;
		return $this;
	}

	/**
	 *	Sets identifier as complete regular expression.
	 *	@access		public
	 *	@param		string		$identifier			...
	 *	@return		self
	 */
	public function setIdentifier( string $identifier ): self
	{
		$this->identifier	= $identifier;
		return $this;
	}

	/**
	 *	Sets key.
	 *	@access		public
	 *	@param		string		$key			...
	 *	@return		self
	 */
	public function setKey( string $key ): self
	{
		$this->key	= $key;
		return $this;
	}

	/**
	 *	Sets priority.
	 *	@access		public
	 *	@param		integer		$priority			...
	 *	@return		self
	 *	@throws		RangeException					if given priority is not defined
	 */
	public function setPriority( int $priority ): self
	{
		if( !in_array( $priority, self::PRIORITIES, TRUE ) )
			throw new RangeException( 'Invalid priority' );
		$this->priority	= $priority;
		return $this;
	}

	/**
	 *	Sets status.
	 *	@access		public
	 *	@param		integer		$status			...
	 *	@return		self
	 *	@throws		RangeException					if given status is not defined
	 */
	public function setStatus( int $status ): self
	{
		if( !in_array( $status, self::STATUSES, TRUE) )
			throw new RangeException( 'Invalid status' );
		$this->status	= $status;
		return $this;
	}

	/**
	 *	Sets title.
	 *	@access		public
	 *	@param		string		$title			...
	 *	@return		self
	 */
	public function setTitle( string $title ): self
	{
		$this->title	= $title;
		return $this;
	}

	/**
	 *	Sets description.
	 *	@access		public
	 *	@param		string		$description	...
	 *	@return		self
	 */
	public function setDescription( string $description ): self
	{
		$this->description	= $description;
		return $this;
	}
}

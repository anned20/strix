<?php

namespace anned20\Strix;

use Psr\Container\ContainerInterface;

use anned20\Strix\Exception\ContainerException;
use anned20\Strix\Exception\NotFoundException;
use anned20\Strix\Exception\AlreadyInContainerException;

/**
 * Class Container
 * @author Anne Douwe Bouma
 */
class Container implements ContainerInterface
{
	/**
	 * @var array
	 */
	private $entries = [];

	/**
	 * {@inheritdoc}
	 */
	public function get($id)
	{
		if (!$this->has($id)) {
			throw new NotFoundException(sprintf('"%s" is not in the container', $id));
		}

		return $this->entries[$id];
	}

	/**
	 * {@inheritdoc}
	 */
	public function has($id)
	{
		return array_key_exists($id, $this->entries);
	}

	/**
	 * Add entry to container
	 *
	 * @param string $id
	 * @param mixed  $entry
	 *
	 * @return Container
	 */
	public function add($id, $entry)
	{
		if ($this->has($id)) {
			throw new AlreadyInContainerException(sprintf('Container already has entry with id "%s"', $id));
		}

		$this->entries[$id] = $entry;

		return $this;
	}

	/**
	 * Delete entry in container
	 *
	 * @param string $id
	 *
	 * @return Container
	 */
	public function delete($id)
	{
		if (!$this->has($id)) {
			throw new NotFoundException(sprintf('"%s" is not in the container', $id));
		}

		unset($this->entries[$id]);

		return $this;
	}
}

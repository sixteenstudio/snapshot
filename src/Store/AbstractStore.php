<?php namespace Michaeljennings\Snapshot\Store; 

use Michaeljennings\Snapshot\Contracts\Store;

abstract class AbstractStore implements Store {

    /**
     * The package config.
     *
     * @var array
     */
    protected $config = [];

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Create a new snapshot.
     *
     * @param array $input
     * @return Snapshot
     */
    abstract protected function snapshot(array $input);

    /**
     * Create a new snapshot item.
     *
     * @param $snapshotId
     * @param array $input
     * @return Item
     */
    abstract protected function item($snapshotId, array $input);

    /**
     * Find a snapshot by its id.
     *
     * @param $id
     * @return mixed
     */
    abstract public function find($id);

    /**
     * Store the current state of the application.
     *
     * @param array $input
     * @return mixed
     */
    public function capture(array $input)
    {
        $snapshot = $this->snapshot($input['snapshot']);

        foreach ($input['items'] as $item) {
            $this->item($snapshot->getId(), $item);
        }

        return $this->find($snapshot->getId());
    }

}
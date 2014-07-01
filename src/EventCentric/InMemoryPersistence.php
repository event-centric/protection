<?php

namespace EventCentric;

use EventCentric\Contracts\Contract;
use EventCentric\Identity\Identity;

final class InMemoryPersistence implements Persistence
{
    private $eventEnvelopes = [];

    /**
     * @param Contract $streamContract
     * @param Identity $streamId
     * @return EventEnvelope[]
     */
    public function fetch(Contract $streamContract, Identity $streamId)
    {
        $key = $this->key($streamContract, $streamId);
        return $this->eventEnvelopes[$key];
    }

    /**
     * @param CommitId $commitId
     * @param Contract $streamContract
     * @param Identity $streamId
     * @param EventEnvelope[] $eventEnvelopes
     */
    public function commit(CommitId $commitId, Contract $streamContract, Identity $streamId, array $eventEnvelopes)
    {
        //ignoring $commitId for now

        $key = $this->key($streamContract, $streamId);

        if(!array_key_exists($key, $this->eventEnvelopes)) {
            $this->eventEnvelopes[$key] = [];
        }

        foreach($eventEnvelopes as $eventEnvelope) {
            $this->eventEnvelopes[$key][] = $eventEnvelope;
        }
    }

    /**
     * @param $streamContract
     * @param $streamId
     * @return string
     */
    private function key($streamContract, $streamId)
    {
        return "$streamContract:$streamId";
    }
}
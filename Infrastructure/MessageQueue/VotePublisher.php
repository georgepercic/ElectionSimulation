<?php

declare(strict_types=1);

namespace ElectionSimulation\Infrastructure\MessageQueue\RabbitMQ;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use ElectionSimulation\Domain\Election\Entity\Vote;

class VotePublisher
{
    private AMQPStreamConnection $connection;
    private string $queueName;

    public function __construct(string $host, int $port, string $user, string $password, string $queueName)
    {
        $this->connection = new AMQPStreamConnection($host, $port, $user, $password);
        $this->queueName = $queueName;
    }

    public function publish(Vote $vote): bool
    {
        try {
            $channel = $this->connection->channel();
            
            // Declare a durable queue
            $channel->queue_declare($this->queueName, false, true, false, false);

            // Convert vote to JSON
            $voteData = $this->serializeVote($vote);

            // Create a message with delivery mode set to persistent
            $msg = new AMQPMessage($voteData, [
                'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
            ]);

            // Publish the message
            $channel->basic_publish($msg, '', $this->queueName);

            // Close the channel
            $channel->close();

            return true;
        } catch (\Exception $e) {
            // Log the error
            return false;
        }
    }

    private function serializeVote(Vote $vote): string
    {
        return json_encode([
            'voterId' => $vote->getVoterId()->toString(),
            'candidateId' => $vote->getCandidateId()->toString(),
            'status' => $vote->getStatus()->value,
            'timestamp' => $vote->getTimestamp()?->format('Y-m-d H:i:s')
        ]);
    }

    public function __destruct()
    {
        $this->connection->close();
    }
}

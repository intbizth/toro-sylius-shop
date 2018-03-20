<?php

declare(strict_types=1);

namespace ToroShop\Bundle\CoreBundle\Session\Storage;

use Symfony\Component\HttpFoundation\Session\Storage\MetadataBag;
use Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage as SymfonyMockFileSessionStorage;

class MockFileSessionStorage extends SymfonyMockFileSessionStorage
{
    private $savePath;

    /**
     * @param string      $savePath Path of directory to save session files
     * @param string      $name     Session name
     * @param MetadataBag $metaBag  MetadataBag instance
     */
    public function __construct($savePath = null, $name = 'MOCKSESSID', MetadataBag $metaBag = null)
    {
        if (null === $savePath) {
            $savePath = sys_get_temp_dir();
        }

        if (!is_dir($savePath)) {
            $old = umask(0);
            @mkdir($savePath, 0777, true);
            umask($old);
        }

        if (!is_dir($savePath)) {
            throw new \RuntimeException(sprintf('Session Storage was not able to create directory "%s"', $savePath));
        }

        $this->savePath = $savePath;

        parent::__construct($savePath, $name, $metaBag);
    }

    /**
     * {@inheritdoc}
     */
    public function save()
    {
        if (!$this->started) {
            throw new \RuntimeException('Trying to save a session that was not started yet or was already closed');
        }

        $fp = fopen($this->getFilePath(), 'w');
        fwrite($fp, serialize($this->data));
        fclose($fp);
        @chmod($this->getFilePath(), 0777);

        $this->started = false;
    }

    /**
     * Calculate path to file.
     *
     * @return string File path
     */
    private function getFilePath()
    {
        return $this->savePath . '/' . $this->id . '.mocksess';
    }
}

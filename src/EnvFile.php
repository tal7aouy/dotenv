<?php

namespace Tal7aouy\Dotenv;

use SplFileObject;
use Tal7aouy\Dotenv\Support\Arr;

class EnvFile
{
    /**
     * @var \SplFileObject|null
     */
    protected $file;

    /**
     * @param  string  $path
     */
    public function __construct(string $path)
    {
        $this->file = new SplFileObject($path, 'r+');
    }

    /**
     * Write content to the file.
     *
     * @param  string  $content
     *
     * @return bool
     */
    public function write(string $content):bool
    {
        $this->file->rewind();
        $this->file->ftruncate(0);

        return $this->file->fwrite($content);
    }

    /**
     * Check if the file is NOT empty.
     *
     * @return bool
     */
    public function isNotEmpty():bool
    {
        return $this->file->getSize() > 0;
    }

    /**
     * Convert the file values into an associative array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return Arr::flatten($this->mapLineValuesAndKeys());
    }

    /**
     * Close the file buffer.
     *
     * @return void
     */
    public function close():void
    {
        $this->file = null;
    }

    /**
     * Extract lines from the file.
     *
     * @return array
     */
    private function linesFromFile():array
    {
        return explode(
            "\n",
            $this->file->fread($this->file->getSize())
        );
    }

    /**
     * Convert config line into key value pairs.
     *
     * @return array
     */
    private function convertLineValuesToArray():array
    {
        return array_map(function ($line) {
            return preg_split('/=/', $line, 2);
        }, $this->linesFromFile());
    }

    /**
     * Map config line extraction into key value pairs.
     *
     * @return array
     */
    private function mapLineValuesAndKeys():array
    {
        return array_map(function ($line) {
            if (count($line) === 2) {
                return [$line[0] => $line[1]];
            }

            return $line[0];
        }, $this->convertLineValuesToArray());
    }
}

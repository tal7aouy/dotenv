<?php

namespace Tal7aouy\Dotenv;

use InvalidArgumentException;
use Tal7aouy\Dotenv\Support\Arr;

class Dotenv
{
    /**
     * @var array
     */
    protected array $env = [];

    /**
     * @var \Tal7aouy\Dotenv\EnvFile
     */
    protected $envFile;

    /**
     * Load an values from an env file.
     *
     * @param  string  $path
     * @return self
     *
     * @throws \InvalidArgumentException
     */
    public function load(string $path): self
    {
        if (! file_exists($path)) {
            throw new InvalidArgumentException(sprintf('%s does not exist', $path));
        }

        $this->envFile = new EnvFile($path);

        if ($this->envFile->isNotEmpty()) {
            $this->env = array_merge($this->env, $this->envFile->toArray());
        }

        return $this;
    }

    /**
     * Set a key value pair for the env file.
     *
     * @param  string  $key
     * @param  string  $value
     * @return self
     */
    public function set(string $key, string $value): self
    {
        $this->env[$key] = $value;

        return $this;
    }

    /**
     * Unset a key value of the env file.
     *
     * @param  string  $key
     * @return self
     */
    public function unset(string $key)
    {
        unset($this->env[$key]);

        return $this;
    }

    /**
     * Get all of the env values or a single value by key.
     *
     * @param  string  $key
     * @return array|string
     */
    public function getEnv(string $key = ''): array|string
    {
        return isset($this->env[$key])
            ? $this->env[$key]
            : $this->env;
    }

    /**
     * Save the current representation to disk. If no path is specifed and
     * a file was loaded, it will overwrite the file that was loaded.
     *
     * @param  string  $path
     * @return bool
     */
    public function save(string $path = ''): bool
    {
        if (empty($path) && $this->envFile) {
            return $this->envFile->write($this->format()) > 0;
        }

        return file_put_contents($path, $this->format()) !== false;
    }

    /**
     * Add an empty line to the config.
     * @return self
     */
    public function addEmptyLine(): self
    {
        $this->env[] = '';

        return $this;
    }

    /**
     * Add a comment heading. If there is a line before it, it will add an empty
     * line before the heading.
     *
     * @param  string  $heading
     * @return self
     */
    public function heading(string $heading): self
    {
        if (! empty(end($this->env))) {
            $this->addEmptyLine();
        }

        $this->env[] = sprintf('# %s', $heading);

        return $this;
    }

    /**
     * Check if a key is defined in the env.
     *
     * @param  string  $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return isset($this->env[$key]);
    }

    /**
     * Format the config file in key=value pairs.
     *
     * @return string
     */
    private function format(): string
    {
        $valuePairs = Arr::mapWithKeys($this->env, function ($item, $key) {
            return is_string($key)
                ? sprintf('%s=%s', $key, $item)
                : $item;
        });

        return implode("\n", $valuePairs);
    }

    public function __destruct()
    {
        if ($this->envFile) {
            $this->envFile->close();
        }
    }
}

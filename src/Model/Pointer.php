<?php
declare(strict_types=1);


namespace Flexibill\NavBundle\Model;

/**
 * Class Pointer
 * @package Flexibill\NavBundle\Model
 */
class Pointer
{
    /**
     * @var string
     */
    protected $tag;

    /**
     * @var string
     */
    protected $value;

    /**
     * @var integer
     */
    protected $line;

    /**
     * @return string
     */
    public function getTag(): ?string
    {
        return $this->tag;
    }

    /**
     * @param string $tag
     * @return $this
     */
    public function setTag(string $tag)
    {
        $this->tag = $tag;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setValue(string $value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return int
     */
    public function getLine(): ?int
    {
        return $this->line;
    }

    /**
     * @param int $line
     * @return $this
     */
    public function setLine(int $line)
    {
        $this->line = $line;
        return $this;
    }
}
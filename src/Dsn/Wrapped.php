<?php

namespace Zenstruck\Dsn;

use Zenstruck\Uri\Part\Query;
use Zenstruck\Uri\Part\Scheme;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
abstract class Wrapped implements \Stringable
{
    public function __construct(private Scheme $scheme, private Query $query, private ?string $fragment)
    {
        if ($this->fragment) {
            $this->fragment = \rawurldecode(\ltrim($this->fragment, '#'));
        }
    }

    final public function __toString(): string
    {
        return \sprintf(
            '%s(%s)%s%s',
            $this->scheme(),
            $this->innerString(),
            $this->query()->isEmpty() ? '' : "?{$this->query()}",
            $this->fragment ? \sprintf('#%s', \rawurlencode($this->fragment)) : '',
        );
    }

    final public function scheme(): Scheme
    {
        return $this->scheme;
    }

    final public function query(): Query
    {
        return $this->query;
    }

    final public function fragment(): ?string
    {
        return $this->fragment;
    }

    abstract protected function innerString(): string;
}

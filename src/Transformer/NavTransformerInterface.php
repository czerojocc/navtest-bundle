<?php

namespace Flexibill\NavBundle\Transformer;

interface NavTransformerInterface
{
    public function transform(object $invoice, bool $validate = true);
}
<?php

namespace EventCentric\Fixtures;

use EventCentric\Identity\Identity;
use EventCentric\Identity\UuidIdentity;

final class OrderId implements Identity
{
    use UuidIdentity;
}
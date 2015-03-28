<?php
namespace Finance\Account;

use Library\Collection;
use Refactoring\Time\Interval;

interface AccountSum
{

    /**
     * @param Interval $interval
     * @return Collection
     */
    public function totalFor(Interval $interval);
}
<?php
namespace Watch;

use Finance\Reporter\CashFlowInterface;
use Library\Collection;
use Refactoring\Time\Interval\ThisMonth;

class Overflow
{
    private $strategy;

    /**
     * @var CashFlowInterface
     */
    private $cashflow = null;

    public function __construct(CashFlowInterface $cashflow, $strategy = null)
    {
        $this->strategy = $strategy or $this->strategy = new ThisMonth();
        $this->cashflow = $cashflow;
    }


    public function isAbove($limit)
    {
        $collection = new Collection($this->cashflow->expensesFor($this->strategy));

        if ($collection->isEmpty()) {
            return false;
        }

        $total = $collection->map(
            function ($el) {
                return $el->amount;
            }
        );

        return array_sum($total) > $limit;
    }
}
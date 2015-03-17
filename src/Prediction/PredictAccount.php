<?php
namespace Prediction;

use Finance\Account\Account;
use Finance\Account\BalanceInterface;
use Refactoring\Time\Interval;
use Refactoring\Time\Interval\LastMonth;

class PredictAccount
{
    /**
     * @var Account
     */
    /**
     * @var BalanceInterface
     */
    private $balance;

    public function __construct(BalanceInterface $balance)
    {
        $this->balance = $balance;
    }

    public function thisMonth()
    {
        $summaries = $this->balance->totalFor($this->getInterval());

        if (count($summaries) < 3) {
            return 0;
        }

        $sort = function ($a, $b) {
            if ($a == $b) {
                return 0;
            }

            return ($a < $b) ? -1 : 1;
        };

         $sorted =  $summaries->sort($sort);

        $currentCadence = ((new \DateTime())->diff(new  \DateTime($sorted->first()->month))->format('%a')) / 30;


        $cadence = new Cadence($sorted);

        if ($cadence->getCadence() > $currentCadence) {
            return 0;
        }

        return $this->getAmountAverage($sorted);
    }

    /**
     * @return LastMonth
     */
    protected function getInterval()
    {
        $end = (new LastMonth())->getStart();
        $start = clone $end;
        $start->sub(new \DateInterval('P1Y'));
        return new Interval($start, $end);
    }

    /**
     * @param $summaries
     * @return float
     */
    protected function getAmountAverage($summaries)
    {
        return $summaries->reduce(function ($total, $item) {
            return $total + $item->amount;
        }, 0) / count($summaries);
    }

}
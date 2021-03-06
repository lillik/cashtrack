<?php
/**
 * Created by PhpStorm.
 * User: cdordea
 * Date: 3/15/15
 * Time: 10:58 PM
 */
namespace Prediction;

use Library\Collection;

class Cadence
{

    /**
     * @var \Library\Collection
     */
    private $summaries;

    public function __construct(Collection $summaries)
    {

        $this->summaries = $summaries;
    }

    public function getCadence()
    {


        $dates = $this->summaries->map(
            function ($datetime) {
                return $datetime->modify('first day of this month');
            }
        )->toArray();


        usort(
            $dates,
            function ($a, $b) {
                if ($a == $b) {
                    return 0;
                }
                return ($a < $b) ? -1 : 1;

            }
        );


        if (count($dates) <= 1) {
            return 0;
        }


        $prev = array_shift($dates);



        $cadences = [];

        do {
            $date = array_shift($dates);
            $cadences [] = round($prev->diff($date)->format('%R%a')/30);
            $prev = $date;
        } while (count($dates));


        return array_sum($cadences)/count($cadences);

    }
}
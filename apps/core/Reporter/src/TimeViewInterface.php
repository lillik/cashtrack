<?php
/**
 * Created by PhpStorm.
 * User: cdordea
 * Date: 23/11/14
 * Time: 16:16
 */
namespace Reporter;

interface TimeViewInterface
{
    /**
     * @param $year
     * @return array
     */
    public function weekTotals($year);

    public function monthTotals($year);

    public function yearTotals();

}
